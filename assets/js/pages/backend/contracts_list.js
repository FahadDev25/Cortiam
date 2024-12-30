jQuery(document).ready(function() {
	$.fn.dataTable.moment( 'YYYY/MM/DD HH:mm A' );
  ourdatatable = jQuery('#contracttable').DataTable({
      dom: '<"datatable-buttons"B><"datatable-header"lf><"datatable-scroll-wrap"t><"datatable-footer"ip>',
      "responsive": true,
      "autoWidth": false,
      "bAutoWidth": false,
      "colReorder": true,
      "order": [[ 1, "asc" ]],
      "paging": true,
      "pageLength": 25,
      "lengthMenu": [ 10, 25, 50, 75, 100 ],
  		"language": {
	      "zeroRecords": "No message at this moment.",
	      "loadingRecords": '<div style="display:inline-block;width:100%;text-align:center;height:30px;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></div>'
	    },
	    "rowId":function(a) {
		    return 'contract-' + a.record_id;
		  },
      "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
	      jQuery(nRow).attr("data-record", aData.record_id);
	      jQuery(nRow).addClass("clickmetrigger");
	      return nRow;
      },
			"columnDefs": [
			  { "type": "html", "targets": 0, "data": "image", "title": "", "orderable": false, "searchable": false, "width": "80px"},
			  { "type": "string", "targets": 1, "data": "location", "title": "Location", "width": "100px"},
			  { "type": "string",  	"targets": 2, "data": "agent", "title": "Agent", "width": "150px"},
			  { "type": "string",  	"targets": 3, "data": "seller", "title": "Seller", "width": "150px"},
			  { "type": "num-fmt",  	"targets": 4, "data": "commission", "title": "Commission Rate", "width": "70px", "render": $.fn.dataTable.render.number( ',', '.', 1, '%' )},
			  { "type": "string",  	"targets": 5, "data": "contract", "title": "Contract Length", "width": "100px", "render":function ( data, type, row, meta ) {return data + ' Months';}},
			  { "type": "html",   "targets": 6, "data": "status", "title": "Status", "orderable": false, "searchable": false, "className": "text-center", "width": "80px" },
			],
      buttons: {
          buttons: [
              {
                  extend: 'copyHtml5',
                  className: 'btn btn-outline bg-slate-800 text-slate-800 border-slate',
                  exportOptions: {
                      columns: [ 0, ':visible' ]
                  }
              },
                {
                    extend: 'print',
                    text: ' Print',
                    className: 'btn btn-outline bg-slate-800 text-slate-800 border-slate',
                  	exportOptions: {
                      columns: ':visible'
                  	}
                },
              {
                  extend: 'excelHtml5',
                  className: 'btn btn-outline bg-slate-800 text-slate-800 border-slate',
                  exportOptions: {
                      columns: ':visible'
                  }
              },
              {
                  extend: 'pdfHtml5',
                  orientation: 'landscape',
								  customize: function (doc) {
								    doc.content[1].table.widths =
								        Array(doc.content[1].table.body[0].length + 1).join('*').split('');
								  },
                  className: 'btn btn-outline bg-slate-800 text-slate-800 border-slate',
                  exportOptions: {
                      columns: ':visible'
                  }
              },
              {
                  extend: 'colvis',
                  text: '<i class="icon-three-bars"></i>',
                  className: 'btn btn-outline bg-slate-800 text-slate-800 border-slate btn-icon dropdown-toggle'
              }
          ]
      },
			"ajax": {
        'type': 'POST',
        'url': cortiamajax.contracttableajaxurl,
	    },
  });

	jQuery('body').on( "click", '.clickmetrigger', function(ev) {
		ev.preventDefault();
  	record_id = jQuery(this).data('record');
		jQuery.ajax({
			type: "post",
			url: cortiamajax.viewcontracturl,
  		data: {'record_id' : record_id},
			dataType: "json",
			beforeSend: function() {
				jQuery.blockUI({message: '<div class="emptyloader"><img src="' + cortiamajax.loadingimage + '"></div>',css: {border:'0px',width:'100%',top:'10%',left:'0%',background:'transparent', cursor:'context-menu'},overlayCSS: {backgroundColor:'#000000',opacity:.7}});
			},
			success: function(response){
				if(response.success){
					swal.fire({
						html: response.html,
						confirmButtonText : 'Close',
						customClass: {
					    confirmButton: 'btn btn-secondary',
					    popup: 'longerpop'
					  }
					});
				}
		  	if(response.fail){
					swal.fire({
						title: response.fail_title,
						text: response.fail_message,
						type: "error",
						confirmButtonClass: "btn btn-secondary"
					});
		  	}
				jQuery.unblockUI();
			}
		});
	});
});
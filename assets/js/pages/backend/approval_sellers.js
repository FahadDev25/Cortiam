jQuery(document).ready(function() {
	jQuery('#approval').select2({minimumResultsForSearch: -1});

	jQuery('#state').select2({
	  data: _states_
	}).trigger('change');

  jQuery('#reportrange').daterangepicker({
      applyClass: 'btn-primary',
      cancelClass: 'btn-light',
      ranges: {
          'Today': [moment(), moment()],
          'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days': [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month': [moment().startOf('month'), moment().endOf('month')],
          'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },
      startDate: moment().startOf('month'),
      endDate: moment().endOf('month'),
      opens: 'left',
  }, function (start, end) {
		jQuery('#reportrange').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
		jQuery('#start_date').val(start.format('MMMM D, YYYY'));
		jQuery('#end_date').val(end.format('MMMM D, YYYY'));
  });

	jQuery('#applyfilters').on( 'click', function (ev) {
		ev.preventDefault();
		block = jQuery('#accountstable').closest('.card');
		jQuery(block).block({
		  message: '<i class="icon-spinner2 spinner"></i>',
		  overlayCSS: {
		      backgroundColor: '#fff',
		      opacity: 0.8,
		      cursor: 'wait',
		      'box-shadow': '0 0 0 1px #ddd'
		  },
		  css: {
		      border: 0,
		      padding: 0,
		      backgroundColor: 'none'
		  }
		});
		ourdatatable.ajax.url( cortiamajax.datatableajaxurl ).load(function( data ) {
			jQuery(block).unblock();
		});
  });

	jQuery('#resetfilters').on( 'click',function (ev) {
			ev.preventDefault();
      jQuery('#tablefilters select').each(function(e) {
      	 jQuery(this).find("option").eq(0).prop('selected', true).trigger("change");
      });
			jQuery('#reportrange').data('daterangepicker').setStartDate(moment().startOf('month'));
			jQuery('#start_date').val(moment().startOf('month'));
			jQuery('#reportrange').data('daterangepicker').setEndDate(moment().endOf('month'));
			jQuery('#end_date').val(moment().endOf('month'));
  });

	function buildTableData(){
		var obj = {
			start_date: jQuery("input[name='start_date']" ).val(),
			end_date: jQuery("input[name='end_date']" ).val(),
			approval: jQuery("select[name='approval']" ).val(),
			state: jQuery("select[name='state']" ).val(),
			order: jQuery("input[name='order']" ).val(),
		};
		return obj;
	}

	$.fn.dataTable.moment( 'D MMMM, YYYY' );
  ourdatatable = jQuery('#accountstable').DataTable({
      dom: '<"datatable-buttons"B><"datatable-header"lf><"datatable-scroll-wrap"t><"datatable-footer"ip>',
      language: {
          search: '<span>Filter:</span> _INPUT_',
          searchPlaceholder: 'Type to filter...',
          lengthMenu: '<span>Show:</span> _MENU_',
          paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
      },
      "responsive": true,
      "autoWidth": false,
      "bAutoWidth": false,
      "colReorder": true,
      "order": [],
      "paging": true,
      "pageLength": 25,
      "lengthMenu": [ 10, 25, 50, 75, 100 ],
  		"oLanguage": {
	      sLoadingRecords: '<div style="display:inline-block;width:100%;text-align:center;height:30px;"><div class="kt-spinner kt-spinner--lg kt-spinner--center kt-spinner--dark"></div></div>'
	    },
	    "rowId":function(a) {
		    return 'record-' + a.user_id;
		  },
			"columnDefs": [
			  { "type": "string", "targets": 0, "data": "user_image", "title": "", "width": "80px"},
			  { "type": "string", "targets": 1, "data": "fullname", "title": "Full Name"},
			  { "type": "html",  	"targets": 2, "data": "phone", "orderable": false, "title": "Phone Number", "width": "200px"},
			  { "type": "html",  	"targets": 3, "data": "email", "title": "Email", "width": "250px" },
			  { "type": "html",  	"targets": 4, "data": "location", "title": "Location", "width": "250px" },
			  { "type": "html",  	"targets": 5, "data": "status", "title": "Status", "width": "90px", "className": 'text-center'  },
			  { "type": "date", "targets": 6, "data": "approval_date", "title": "Action Date", "width": "200px" },
			],
			"fnRowCallback": function( nRow, aaData, iDisplayIndex ) {
				jQuery(nRow).addClass(aaData["approval"].toLowerCase().replace(/ /g, '-')).addClass('clickmetrigger');
				jQuery(nRow).attr('data-link',aaData["link"].toLowerCase());
				return nRow;
			},
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
        'url': cortiamajax.datatableajaxurl,
        'data': buildTableData
	    },
  });

	jQuery('body').on( "click", '.clickmetrigger', function(ev) {
		ev.preventDefault();
  	row_link = jQuery(this).data('link');
  	window.location.href = row_link;
	});
});


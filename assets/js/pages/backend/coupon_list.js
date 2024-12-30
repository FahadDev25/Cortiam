jQuery(document).ready(function() {
	jQuery('#coupon_status').select2({minimumResultsForSearch: -1});
	jQuery('#coupon_type').select2({minimumResultsForSearch: -1});


  jQuery('#reportrange').daterangepicker({
      applyClass: 'btn-primary',
      cancelClass: 'btn-light',
      ranges: {
          'Today': [moment(), moment()],
          'Tomorrow': [moment().add(1, 'days'), moment().add(1, 'days')],
          'This Week': [moment().startOf('week'), moment().endOf('week')],
          'Next Week': [moment().add(1, 'week').startOf('week'), moment().add(1, 'week').endOf('week')],
          'This Month': [moment().startOf('month'), moment().endOf('month')],
          'Next Month': [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')],
          'This Year': [moment().startOf('year'), moment().endOf('year')],
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

	jQuery('#accountstable').on( 'click', '.copyme', function (ev) {
		ev.preventDefault();
		var $temp = jQuery('<input style="opacity:1;">');
		jQuery("body").append($temp);
		$temp.val(jQuery(this).data('copy')).select();
		document.execCommand("copy");
//		$temp.remove();
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
			coupon_status: jQuery("select[name='coupon_status']" ).val(),
			coupon_type: jQuery("select[name='coupon_type']" ).val(),
		};
		return obj;
	}

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
      "order": [[ 0, "asc" ]],
      "paging": true,
      "pageLength": 25,
      "lengthMenu": [ 10, 25, 50, 75, 100 ],
  		"oLanguage": {
	      sLoadingRecords: '<div style="display:inline-block;width:100%;text-align:center;height:30px;"><div class="kt-spinner kt-spinner--lg kt-spinner--center kt-spinner--dark"></div></div>'
	    },
	    "rowId":function(a) {
		    return 'record-' + a.coupon_id;
		  },
			"columnDefs": [
			  { "type": "string", "targets": 0, "data": "coupon_code", "title": "Coupon Code", "width": "120px"},
			  { "type": "string", "targets": 1, "data": "coupon_desc", "title": "Description", "visible": false},
			  { "type": "string", "targets": 4, "data": "valid_on", "title": "Valid Between", "width": "100px" },
			  { "type": "html",  	"targets": 2, "data": "coupon_type", "title": "Discount Type", "width": "90px" },
			  { "type": "html",  	"targets": 3, "data": "coupon_amount", "title": "Discount Amount", "width": "120px" },
			  { "type": "html",  	"targets": 5, "data": "coupon_status", "title": "Status", "width": "100px" },
			  { "type": "string", "targets": 6, "data": "added_on", "title": "Added on", "width": "100px" },
			  { "type": "html",   "targets": 7, "data": "actions", "orderable": false, "searchable": false, "width": "90px" },
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
        'url': cortiamajax.datatableajaxurl,
        'data': buildTableData
	    },
  });
});


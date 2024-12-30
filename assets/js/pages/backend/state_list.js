jQuery(document).ready(function() {

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
			  { "type": "string", "targets": 0, "data": "state", "title": "State Name"},
			  { "type": "string", "targets": 1, "data": "cost", "title": "Winning Cost", "width": "200px"},
			  { "type": "html",   "targets": 2, "data": "actions", "orderable": false, "searchable": false, "width": "150px" },
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
	    },
  });
});


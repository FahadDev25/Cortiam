jQuery(document).ready(function() {

  jQuery('body').on('click', '.deleteprofileimg', function (ev) {
		ev.preventDefault();
  	selected_button = jQuery(this);
  	profile_id = jQuery(this).data('profile');
		swal.fire({
	    title: "Delete Profile Photo",
	    text: "Selected photo will be removed from profile and you won't be able to revert this action! Are you sure want to continue?",
	    type: "question",
	    showCancelButton: !0,
	    cancelButtonText: '<b><i class="icon-cross2"></i></b> No',
			cancelButtonClass: "btn bg-danger btn-labeled btn-labeled-left rounded-round float-left",
	    confirmButtonText: '<b><i class="icon-checkmark3"></i></b> Yes',
			confirmButtonClass: "btn bg-teal-400 btn-labeled btn-labeled-left rounded-round float-right"
		}).then(function(e) {
			if(e.value){
				jQuery.ajax({
					type: "post",
					url: cortiamajax.deleteprofileimgurl,
		  		data: {'profile_id' : profile_id, 'type' : 'seller'},
					dataType: "json",
					beforeSend: function() {
						jQuery.blockUI({message: '<div class="emptyloader"><img src="' + cortiamajax.loadingimage + '"></div>',css: {border:'0px',width:'100%',top:'10%',left:'0%',background:'transparent', cursor:'context-menu'},overlayCSS: {backgroundColor:'#000000',opacity:.7}});
					},
					success: function(response){
						if(response.success){
							swal.fire({
								title: response.success_title,
								text: response.success_message,
								type: "success",
								confirmButtonClass: "btn btn-secondary"
							});
							jQuery(selected_button).addClass('d-none');
							jQuery('#pageavatar').attr('src',cortiamajax.emptyphoto);
						}
				  	if(response.fail){
							swal.fire({
								background: "#fff",
								title: response.fail_title,
								text: response.fail_message,
								type: "error",
								confirmButtonClass: "btn btn-secondary"
							});
				  	}
						jQuery.unblockUI();
					}
				});
			}
		});
  });

  jQuery('#state').select2({
		data: _states_,
	  placeholder: 'Select a State',
	  allowClear: true
  });

	jQuery('#state').on('select2:select', function (e) {
	  var selected_state = e.params.data;
		jQuery('#city').select2({
			data: _cities_[selected_state.id],
			placeholder: 'Select a City',
			allowClear: true
		});
	});

	jQuery('#city').select2({
		data:  _cities_[''+jQuery('#state').val()+''],
		placeholder: 'Select a City',
		allowClear: true
	});

	jQuery('.trgswitches').on( "click", function(ev) {
		ev.preventDefault();
		var extra_class = jQuery(this).data('type');
		jQuery('.form-check-input-switchery.'+extra_class).trigger('click');
	});

  jQuery('#password').passy(function(strength) {
	  jQuery('#password_indicator').text(pw_feedback[strength].text);
	  jQuery('#password_indicator').css({'background-color': pw_feedback[strength].color, 'border-color': pw_feedback[strength].color, 'color': pw_feedback[strength].textColor});
  });

  jQuery('#passwordagain').blur(function() {
    if(jQuery('#passwordagain').val().length == 0){
      jQuery('#passwordagain_indicator').text('No Password').css({'background-color': '', 'border-color': '', 'color': ''});
    }else if (jQuery('#password').val() != jQuery('#passwordagain').val()) {
      jQuery('#passwordagain_indicator').text('Not Match').css({'background-color': '#D55757', 'border-color': '#D55757', 'color': '#ffffff'});
    }else {
      jQuery('#passwordagain_indicator').text('Match').css({'background-color': '#40B381', 'border-color': '#40B381', 'color': '#ffffff'});
    }
  });

	var switchelems = Array.prototype.slice.call(document.querySelectorAll('.form-check-input-switchery'));

	switchelems.forEach(function(html) {
	  var switchery = new Switchery(html);
	});

	$.fn.dataTable.moment( 'YYYY/MM/DD HH:mm A' );
  messagedatatable = jQuery('#messagetable').DataTable({
      dom: '<"datatable-header"lf><"datatable-scroll-wrap"t><"datatable-footer"ip>',
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
		    return 'message-' + a.record_id;
		  },
			"columnDefs": [
			  { "type": "string", "targets": 0, "data": "from", "title": "Message From", "width": "120px", "className": "text-left"},
			  { "type": "string", "targets": 1, "data": "to", "title": "Message To", "width": "120px", "className": "text-left"},
			  { "type": "string", "targets": 2, "data": "title", "title": "Title", "width": "250px"},
			  { "type": "date",  	"targets": 3, "data": "date", "title": "Date", "width": "120px"},
			  { "type": "html", "targets": 4, "data": "status", "title": "Status", "width": "100px", "className": "text-center"},
			  { "type": "html", "targets": 5, "data": "link", "title": "", "orderable": false, "searchable": false, "width": "30px", "className": "text-center" },
			],
			"ajax": {
        'type': 'POST',
        'url': cortiamajax.messagetableajaxurl,
        'data': {seller_id: cortiamajax.seller_id}
	    },
  });


	jQuery('body').on( "click", '.viewmessage', function(ev) {
		ev.preventDefault();
  	record_id = jQuery(this).data('record');
		jQuery.ajax({
			type: "post",
			url: cortiamajax.viewmessageurl,
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


  propertiesdatatable = jQuery('#propstable').DataTable({
      dom: '<"datatable-header"lf><"datatable-scroll-wrap"t><"datatable-footer"ip>',
      "responsive": true,
      "autoWidth": false,
      "bAutoWidth": false,
      "colReorder": true,
      "order": [[ 1, "asc" ]],
      "paging": true,
      "pageLength": 25,
      "lengthMenu": [ 10, 25, 50, 75, 100 ],
  		"language": {
	      "zeroRecords": "No property at this moment.",
	      "loadingRecords": '<div style="display:inline-block;width:100%;text-align:center;height:30px;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></div>'
	    },
	    "rowId":function(a) {
		    return 'prop-' + a.property_id;
		  },
			"columnDefs": [
			  { "type": "string", "targets": 0, "data": "image", "title": "", "orderable": false, "searchable": false, "width": "80px"},
			  { "type": "string", "targets": 1, "data": "location", "title": "Location"},
			  { "type": "string",  	"targets": 2, "data": "type", "title": "Property", "width": "100px"},
			  { "type": "string",  	"targets": 3, "data": "sub_type", "title": "Type", "width": "150px" },
			  { "type": "string",  	"targets": 4, "data": "building_size", "title": "Building Size", "width": "150px" },
			  { "type": "date", "targets": 5, "data": "created_on", "title": "Created On", "width": "200px" },
			  { "type": "html",   "targets": 6, "data": "status", "orderable": false, "searchable": false, "className": "text-center", "width": "100px" },
			  { "type": "html",   "targets": 7, "data": "link", "orderable": false, "searchable": false, "width": "150px" },
			],
			"ajax": {
        'type': 'POST',
        'url': cortiamajax.propertiestableajaxurl,
        'data': {seller_id: cortiamajax.seller_id}
	    },
  });


  offersdatatable = jQuery('#offertable').DataTable({
      dom: '<"datatable-header"lf><"datatable-scroll-wrap"t><"datatable-footer"ip>',
      "responsive": true,
      "autoWidth": false,
      "bAutoWidth": false,
      "colReorder": true,
      "order": [[ 6, "desc" ]],
      "paging": true,
      "pageLength": 25,
      "lengthMenu": [ 10, 25, 50, 75, 100 ],
  		"language": {
	      "zeroRecords": "No offer at this moment.",
	      "loadingRecords": '<div style="display:inline-block;width:100%;text-align:center;height:30px;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></div>'
	    },
	    "rowId":function(a) {
		    return 'offer-' + a.record_id;
		  },
			"columnDefs": [
			  { "type": "html", "targets": 0, "data": "image", "title": "", "orderable": false, "searchable": false, "width": "80px"},
			  { "type": "string", "targets": 1, "data": "location", "title": "Location", "width": "100px"},
			  { "type": "string",  	"targets": 2, "data": "from", "title": "From", "width": "150px"},
			  { "type": "string",  	"targets": 3, "data": "to", "title": "To", "width": "150px"},
			  { "type": "num-fmt",  	"targets": 4, "data": "commission", "title": "Commission Rate", "width": "70px", "render": $.fn.dataTable.render.number( ',', '.', 1, '%' )},
			  { "type": "string",  	"targets": 5, "data": "contract", "title": "Contract Length", "width": "100px", "render":function ( data, type, row, meta ) {return data + ' Months';}},
			  { "type": "date", "targets": 6, "data": "created_on", "title": "Send On", "width": "140px" },
			  { "type": "html",   "targets": 7, "data": "status", "title": "Status", "orderable": false, "searchable": false, "className": "text-center", "width": "80px" },
			  { "type": "html",   "targets": 8, "data": "link", "orderable": false, "searchable": false, "width": "50px" },
			],
			"ajax": {
        'type': 'POST',
        'url': cortiamajax.offertableajaxurl,
        'data': {seller_id: cortiamajax.seller_id}
	    },
  });

	jQuery('body').on( "click", '.viewoffer', function(ev) {
		ev.preventDefault();
  	record_id = jQuery(this).data('record');
		jQuery.ajax({
			type: "post",
			url: cortiamajax.viewofferurl,
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

  contractdatatable = jQuery('#contracttable').DataTable({
      dom: '<"datatable-header"lf><"datatable-scroll-wrap"t><"datatable-footer"ip>',
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
			"columnDefs": [
			  { "type": "html", "targets": 0, "data": "image", "title": "", "orderable": false, "searchable": false, "width": "80px"},
			  { "type": "string", "targets": 1, "data": "location", "title": "Location", "width": "100px"},
			  { "type": "string",  	"targets": 2, "data": "agent", "title": "Agent", "width": "150px"},
			  { "type": "string",  	"targets": 3, "data": "seller", "title": "Seller", "width": "150px"},
			  { "type": "num-fmt",  	"targets": 4, "data": "commission", "title": "Commission Rate", "width": "70px", "render": $.fn.dataTable.render.number( ',', '.', 1, '%' )},
			  { "type": "string",  	"targets": 5, "data": "contract", "title": "Contract Length", "width": "100px", "render":function ( data, type, row, meta ) {return data + ' Months';}},
			  { "type": "html",   "targets": 6, "data": "status", "title": "Status", "orderable": false, "searchable": false, "className": "text-center", "width": "80px" },
			  { "type": "html",   "targets": 7, "data": "link", "orderable": false, "searchable": false, "width": "50px" },
			],
			"ajax": {
        'type': 'POST',
        'url': cortiamajax.contracttableajaxurl,
        'data': {seller_id: cortiamajax.seller_id}
	    },
  });

	jQuery('body').on( "click", '.viewcontract', function(ev) {
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


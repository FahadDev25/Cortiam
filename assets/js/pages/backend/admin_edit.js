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
		  		data: {'profile_id' : profile_id, 'type' : 'administrator'},
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

  jQuery('#messagetable').DataTable({
      dom: '<"datatable-header"lf><"datatable-scroll-wrap"t><"datatable-footer"ip>',
      "responsive": true,
      "autoWidth": false,
      "bAutoWidth": false,
      "colReorder": true,
      "order": [[ 3, "asc" ]],
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
			  { "type": "string", "targets": 0, "data": "fullname", "title": "", "width": "80px"},
			  { "type": "html",  	"targets": 1, "data": "phone", "orderable": false, "title": "Full Name", "width": "130px"},
			  { "type": "html",  	"targets": 2, "data": "email", "title": "Message", "width": "250px" },
			  { "type": "string", "targets": 3, "data": "created_on", "title": "Created On", "width": "100px" },
			],
  });

  jQuery('#logtable').DataTable({
      dom: '<"datatable-header"lf><"datatable-scroll-wrap"t><"datatable-footer"ip>',
      "responsive": true,
      "autoWidth": false,
      "bAutoWidth": false,
      "colReorder": true,
      "order": [[ 3, "asc" ]],
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
			  { "type": "string", "targets": 3, "data": "created_on", "title": "Action Date", "width": "80px" },
			  { "type": "string", "targets": 0, "data": "fullname", "title": "Action", "width": "90%"},
			],
  });

});


jQuery(document).ready(function() {
  var $image = jQuery("#avatar-cropper-image");
  var $filefield = jQuery("#avatarupload")[0];
  var $currentavatar = jQuery('#pageavatar').attr('src');

	jQuery('body').on( "change", '#avatarupload', function(ev) {
		jQuery('#avatarmodal').modal({show:true,backdrop:'static'}).on('shown.bs.modal', function (e) {
	    var oFReader = new FileReader();
	    oFReader.readAsDataURL($filefield.files[0]);
	    oFReader.onload = function (oFREvent) {

	    $image.attr('src', this.result);
	    $image.cropper({
	      aspectRatio: 1,
	      preview: '.previewAvatar',
		    autoCropArea: 1
	    });
	    };
	    jQuery('#avatarupload').val('');
		}).on('hidden.bs.modal', function () {
			$image.attr('src', '');
			$image.cropper('destroy');
			jQuery('#pageavatar').attr('src', $currentavatar);
		});
	});

  jQuery('body').on('click', '#getmydata', function () {
    canvas = $image.cropper('getCroppedCanvas',{width:250,height:250});
    canvas.toBlob(function(blob) {
      url = URL.createObjectURL(blob);
      var reader = new FileReader();
			reader.readAsDataURL(blob);
			reader.onloadend = function() {
				var base64data = reader.result;
				$.ajax({
				  type: "POST",
				  dataType: "json",
				  url: cortiamajax.avataruploadurl,
				  data: {image: base64data, type: 'agent', recordID: jQuery('input[name="recordID"]').val()},
				  success: function(data){
				  	$currentavatar = data.avatarurl;
				  	jQuery('.deleteprofileimg').removeClass('d-none');
						jQuery('#avatarmodal').modal('hide');
				  }
				});
			}
    });
  });

  jQuery('.avatar-cropper-toolbar').on('click', '[data-method]', function () {
    var $this = jQuery(this),
        data = $this.data(),
        $target,
        result;

    if ($image.data('cropper') && data.method) {
      data = $.extend({}, data);
      if (typeof data.target !== 'undefined') {
        $target = jQuery(data.target);
        if (typeof data.option === 'undefined') {
        	data.option = JSON.parse($target.val());
        }
      }

      result = $image.cropper(data.method, data.option, data.secondOption);

      switch (data.method) {
          case 'scaleX':
          case 'scaleY':
              jQuery(this).data('option', -data.option);
          break;
      }
    }
  });

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
		  		data: {'profile_id' : profile_id, 'type' : 'agent'},
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

  jQuery('.select').select2({
  	minimumResultsForSearch: Infinity,
  });

  jQuery('#bio').trumbowyg({
      btns: [
          // ['formatting'],
          ['strong', 'em'],
          ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
          ['unorderedList', 'orderedList'],
          ['undo', 'redo'], // Only supported in Blink browsers
          ['insertImage', 'link'],
          ['viewHTML'],
          ['fullscreen']
      ]
  });

  jQuery('#estate_specialization').trumbowyg({
      btns: [
          // ['formatting'],
          ['strong', 'em'],
          ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
          ['unorderedList', 'orderedList'],
          ['undo', 'redo'], // Only supported in Blink browsers
          ['insertImage', 'link'],
          ['viewHTML'],
          ['fullscreen']
      ]
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

  jQuery('#brokerage_state').select2({
		data: _states_,
	  placeholder: 'Select a State',
	  allowClear: true
  });

	jQuery('#brokerage_state').on('select2:select', function (e) {
	  var selected_state = e.params.data;
		jQuery('#brokerage_city').select2({
			data: _cities_[selected_state.id],
			placeholder: 'Select a City',
			allowClear: true
		});
	});

  jQuery('#brokerage_city').select2({
		data:  _cities_[''+jQuery('#state').val()+''],
		placeholder: 'Select a City',
		allowClear: true
	});

	jQuery("#experience").datepicker({startView: 2, format: 'yyyy', autoHide: true});

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

	jQuery('body').on( 'click', '.editformupdate', function (ev) {
		ev.preventDefault();
		var form_values = jQuery('.editform').serializeArray();
		form_values.push({name: "edittype", value: "approval"});
		jQuery.ajax({
			type: "post",
			url: cortiamajax.formajaxurl,
		  data: form_values,
			dataType: "json",
			beforeSend: function() {
				jQuery('.editform').block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.7}});
			},
			success: function(response){
		  	if(response.success){
					swal.fire({
						title: response.success_title,
						text: response.success_message,
						type: "success",
						confirmButtonClass: "btn btn-secondary"
					});
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
				if(response.errorfields){
					jQuery.each(response.errorfields, function(index, value) {
						if(jQuery("#"+index).hasClass('select2-hidden-accessible')){
							jQuery("#"+index).next('span.select2-container').find('.select2-selection--single').addClass("border-danger").one("focus", function() {
								jQuery(this).removeClass("border-danger");
							});
						}else{
							jQuery("#"+index).addClass("border-danger").one("focus", function() {
								jQuery(this).removeClass("border-danger");
							});
						}
			    });
				}
	  		jQuery('.editform').unblock();
			}
		});
  });

	jQuery('body').on( 'click', '#sendsupport', function (ev) {
		ev.preventDefault();
		jQuery.ajax({
			type: "post",
			url: cortiamajax.sendsupporturl,
		  data: {'message_title' : jQuery('#message_title').val(), 'message_text' : jQuery('#message_text').val()},
			dataType: "json",
			beforeSend: function() {
				jQuery('#tresult').block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.7}});
			},
			success: function(response){
		  	if(response.redirect_to){
		  		window.location.replace(response.redirect_to);
		  	}else{
		  		jQuery('#tresult').unblock();
			  	if(response.success){
						swal.fire({
							title: response.success_title,
							text: response.success_message,
							type: "success",
							confirmButtonClass: "btn btn-secondary"
						});
			  	}
		  	}
		  	if(response.fail){
		  		jQuery('#tresult').unblock();
					swal.fire({
						background: "#fff",
						title: response.fail_title,
						text: response.fail_message,
						type: "error",
						confirmButtonClass: "btn btn-secondary"
					});
		  	}
				if(response.errorfields){
					jQuery.each(response.errorfields, function(index, value) {
						if(jQuery("#"+index).hasClass('select2-hidden-accessible')){
							jQuery("#"+index).next('span.select2-container').find('.select2-selection--single').addClass("border-danger").one("focus", function() {
								jQuery(this).removeClass("border-danger");
							});
						}else{
							jQuery("#"+index).addClass("border-danger").one("focus", function() {
								jQuery(this).removeClass("border-danger");
							});
						}
			    });
				}
			}
		});
  });


  jQuery('body').on( "click", '#addlicense', function(ev) {
  	jQuery(this).hide();
		ev.preventDefault();
		jQuery('#addlicense').hide();
		jQuery('#licenselistingpart').slideUp();
		jQuery('#tlicenses').block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.7}});
		jQuery.ajax({
		  url: cortiamajax.getlicenseformurl,
		  type: "POST",
		  dataType: "json",
		  success: function(i, s, r, a) {
		  	if(i.success){
		  		jQuery('#addnewlicense').html(i.form);
					jQuery('#addnewlicense').slideDown('slow');
			    jQuery('html, body').animate({scrollTop: jQuery("#tlicenses").offset().top}, 1000);

				  jQuery('#interested').select2({
				  	minimumResultsForSearch: Infinity,
				  });
				  jQuery('#license_state').select2({
						data: _states_,
					  placeholder: 'Select a State',
					  allowClear: true
				  });
				  jQuery('#license_expire').datepicker({format: 'mm/dd/yyyy', startDate: new Date(), autoHide: true});
		  	}
		  	if(i.fail){
					swal.fire({
						title: i.fail_title,
						text: i.fail_message,
						type: "error",
						confirmButtonClass: "btn btn-success"
					});
		  	}
		  	jQuery('#tlicenses').unblock();
		  }
		});
  });


  jQuery('body').on( "click", '#license-add-button', function(ev) {
		ev.preventDefault();
		var form_data = jQuery('#addnewlicense :input').serializeArray();
		form_data.push({name: "agent_id", value: cortiamajax.agent_id});
		jQuery('#addnewlicense').block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.7}});
		jQuery.ajax({
		  url: cortiamajax.addlicenseurl,
		  type: "POST",
		  data: form_data,
		  dataType: "json",
		  success: function(response) {
		  	if(response.success){
					swal.fire({
						title: response.success_title,
						text: response.success_message,
						type: "success",
						confirmButtonClass: "btn btn-success"
					});

					jQuery.ajax({
					  url: cortiamajax.listlicenseurl,
					  type: "POST",
					  data: {agent_id: cortiamajax.agent_id},
					  dataType: "json",
					  success: function(i, s, r, a) {
					  	if(i.success){
					  		jQuery('#licenselistingpart .profile-list').html(i.form);
								jQuery('#licenselistingpart').slideDown('slow');
								jQuery('#addnewlicense').html('').slideUp();
						    jQuery('html, body').animate({scrollTop: jQuery("#tlicenses").offset().top}, 1000);
								jQuery('#addlicense').show();
					  	}
					  }
					});
		  	}
		  	if(response.fail){
					swal.fire({
						title: response.fail_title,
						text: response.fail_message,
						type: "error",
						confirmButtonClass: "btn btn-success"
					});
		  	}
		  	if(response.fail){
					swal.fire({
						title: response.fail_title,
						text: response.fail_message,
						type: "error",
						confirmButtonClass: "btn btn-success"
					});
		  	}
				if(response.errorfields){
					jQuery.each(response.errorfields, function(index, value) {
						if(jQuery("#"+index).hasClass('select2-hidden-accessible')){
							jQuery("#"+index).next('span.select2-container').find('.select2-selection--single').addClass("border-danger").one("focus", function() {
								jQuery(this).removeClass("border-danger");
							});
						}else{
							jQuery("#"+index).addClass("border-danger").one("focus", function() {
								jQuery(this).removeClass("border-danger");
							});
						}
			    });
				}
		  	jQuery('#addnewlicense').unblock();
		  }
		});
  });

  jQuery('body').on( "click", '.editmylicense', function(ev) {
		ev.preventDefault();
  	license_id = jQuery(this).data('id');
		jQuery('#addlicense').hide();
		jQuery('#licenselistingpart').slideUp();
		jQuery('#tlicenses').block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.7}});
		jQuery.ajax({
		  url: cortiamajax.getlicenseformurl,
		  type: "POST",
		  data: {'licenseid' : license_id},
		  dataType: "json",
		  success: function(i, s, r, a) {
		  	if(i.success){
		  		jQuery('#addnewlicense').html(i.form);
					jQuery('#addnewlicense').slideDown('slow');
			    jQuery('html, body').animate({scrollTop: jQuery("#tlicenses").offset().top}, 1000);

				  jQuery('#interested').select2({
				  	minimumResultsForSearch: Infinity,
				  });
				  jQuery('#license_state').select2({
						data: _states_,
					  placeholder: 'Select a State',
					  allowClear: true
				  });
				  jQuery('#license_expire').datepicker({format: 'mm/dd/yyyy', startDate: new Date(), autoHide: true});
		  	}
		  	if(i.fail){
					swal.fire({
						title: i.fail_title,
						text: i.fail_message,
						type: "error",
						confirmButtonClass: "btn btn-success"
					});
		  	}
		  	jQuery('#tlicenses').unblock();
		  }
		});
  });

  jQuery('body').on( "click", '#license-update-button', function(ev) {
		ev.preventDefault();
		var form_data = jQuery('#addnewlicense :input').serializeArray();
		form_data.push({name: "agent_id", value: cortiamajax.agent_id});
		jQuery('#addnewlicense').block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.7}});
		jQuery.ajax({
		  url: cortiamajax.editlicenseurl,
		  type: "POST",
		  data: form_data,
		  dataType: "json",
		  success: function(response) {
		  	if(response.success){
					swal.fire({
						title: response.success_title,
						text: response.success_message,
						type: "success",
						confirmButtonClass: "btn btn-success"
					});

					jQuery.ajax({
					  url: cortiamajax.listlicenseurl,
					  type: "POST",
					  data: {agent_id: cortiamajax.agent_id},
					  dataType: "json",
					  success: function(i, s, r, a) {
					  	if(i.success){
					  		jQuery('#licenselistingpart .profile-list').html(i.form);
								jQuery('#licenselistingpart').slideDown('slow');
								jQuery('#addnewlicense').html('').slideUp();
						    jQuery('html, body').animate({scrollTop: jQuery("#tlicenses").offset().top}, 1000);
								jQuery('#addlicense').show();
					  	}
					  }
					});
		  	}
		  	if(response.fail){
					swal.fire({
						title: response.fail_title,
						text: response.fail_message,
						type: "error",
						confirmButtonClass: "btn btn-success"
					});
		  	}
				if(response.errorfields){
					jQuery.each(response.errorfields, function(index, value) {
						if(jQuery("#"+index).hasClass('select2-hidden-accessible')){
							jQuery("#"+index).next('span.select2-container').find('.select2-selection--single').addClass("border-danger").one("focus", function() {
								jQuery(this).removeClass("border-danger");
							});
						}else{
							jQuery("#"+index).addClass("border-danger").one("focus", function() {
								jQuery(this).removeClass("border-danger");
							});
						}
			    });
				}
		  	jQuery('#addnewlicense').unblock();
		  }
		});
  });

  jQuery('body').on( "click", '#license-cancel-button', function(ev) {
		ev.preventDefault();
		jQuery('#addnewlicense').slideUp().html('');
		jQuery('#addlicense').show();
 		jQuery('#licenselistingpart').slideDown();
   	jQuery('html, body').animate({scrollTop: jQuery("#tlicenses").offset().top}, 1000);
  });

  jQuery('body').on( "click", '.deletemylicense', function(ev) {
		ev.preventDefault();
  	license_id = jQuery(this).data('id');
  	payment_row = jQuery(this).parents('tr');
		swal.fire({
			title: 'Agent License Removal',
			text: 'Are you sure you want to delete selected agent license?',
	    type: "question",
	    showCancelButton: !0,
	    cancelButtonText: 'Cancel',
			cancelButtonClass: "btn btn-danger float-left",
	    confirmButtonText: 'Proceed',
			confirmButtonClass: "btn btn-success float-right"
		}).then(function(e) {
			if(e.value){
				jQuery('#paymentpart').block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.7}});
				jQuery.ajax({
				  url: cortiamajax.deletelicenseurl,
				  type: "POST",
				  data: {'license_id' : license_id},
				  dataType: "json",
				  success: function(i, s, r, a) {
				  	if(i.success){
							swal.fire({
								title: i.success_title,
								text: i.success_message,
								type: "success",
								confirmButtonClass: "btn btn-success"
							});
							jQuery(payment_row).remove();
				  	}
				  	if(i.fail){
							swal.fire({
								title: i.fail_title,
								text: i.fail_message,
								type: "error",
								confirmButtonClass: "btn btn-success"
							});
				  	}
				  	jQuery('#paymentpart').unblock();
				  }
				});
			}
		});
  });

  jQuery('body').on( "click", '.approvemylicense', function(ev) {
		ev.preventDefault();
  	license_id = jQuery(this).data('id');
  	approval = jQuery(this).data('type');
		jQuery('#tlicenses').block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.7}});
		swal.fire({
			title: approval + ' Agent License',
			text: 'Are you sure you want to ' + approval.toLowerCase() + ' selected agent license?',
	    type: "question",
	    showCancelButton: !0,
	    cancelButtonText: 'Cancel',
			cancelButtonClass: "btn btn-danger float-left",
	    confirmButtonText: 'Proceed',
			confirmButtonClass: "btn btn-success float-right"
		}).then(function(e) {
			if(e.value){
				jQuery.ajax({
				  url: cortiamajax.approvelicenseurl,
				  type: "POST",
				  data: {'license_id' : license_id, 'type' : approval},
				  dataType: "json",
				  success: function(i, s, r, a) {
				  	if(i.success){
							swal.fire({
								title: i.success_title,
								text: i.success_message,
								type: "success",
								confirmButtonClass: "btn btn-success"
							});
							jQuery.ajax({
							  url: cortiamajax.listlicenseurl,
							  type: "POST",
							  data: {agent_id: cortiamajax.agent_id},
							  dataType: "json",
							  success: function(i, s, r, a) {
							  	if(i.success){
							  		jQuery('#licenselistingpart .profile-list').html(i.form);
								    jQuery('html, body').animate({scrollTop: jQuery("#tlicenses").offset().top}, 1000);
							  	}
							  }
							});
				  	}
				  	if(i.fail){
							swal.fire({
								title: i.fail_title,
								text: i.fail_message,
								type: "error",
								confirmButtonClass: "btn btn-success"
							});
				  	}
				  }
				});
			}
	  	jQuery('#tlicenses').unblock();
		});
  });
});
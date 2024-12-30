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
				  data: {image: base64data, type: 'seller', recordID: jQuery('input[name="recordID"]').val()},
				  success: function(data){
				  	$currentavatar = data.avatarurl;
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

	jQuery('body').on( 'click', '#approveme', function (ev) {
		ev.preventDefault();
		jQuery.ajax({
			type: "post",
			url: cortiamajax.approveajaxurl,
		  data: {'message_text' : jQuery('#message_text').val()},
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

	jQuery('body').on( 'click', '#declineme', function (ev) {
		ev.preventDefault();
		jQuery.ajax({
			type: "post",
			url: cortiamajax.declineajaxurl,
		  data: {'message_text' : jQuery('#message_text').val()},
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

});


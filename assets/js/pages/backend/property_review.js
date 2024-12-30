jQuery(document).ready(function() {
	jQuery('#seller_id').select2();

	jQuery('#type').bootstrapSwitch();

	jQuery('#type').on('switchChange.bootstrapSwitch', function (event, state) {
	    if(state) {
	    	jQuery('#hideforcommercial').show();
		    jQuery('#sub_type').empty().select2({data: property_types.residental});
	    } else {
	    	jQuery('#hideforcommercial').hide();
 		    jQuery('#sub_type').empty().select2({data: property_types.commercial});
	    }
	});


	jQuery('#sub_type').select2({
	  data: (property_types.current == 'Residential' ? property_types.residental : property_types.commercial)
	}).val(property_types.sub_type).trigger('change');


  jQuery('#approx_value').maskMoney({prefix:'', allowNegative: false, precision: 0, thousands:',', decimal:'', affixesStay: false});
  jQuery('#winning_fee').maskMoney({prefix:'', allowNegative: false, precision: 0, thousands:',', decimal:'', affixesStay: false});

	jQuery("#built_date").datepicker({
    format: "yyyy",
    viewMode: "years",
    minViewMode: "years"
	});

  jQuery( "#commission_rate" ).spinner({
    step: 0.5,
    numberFormat: "n",
    spin: function( event, ui ) {
      if ( ui.value > 6 ) {
        jQuery( this ).spinner( "value", 6 );
        return false;
      } else if ( ui.value < 0 ) {
        jQuery( this ).spinner( "value", 0 );
        return false;
      }
    }
  });

  jQuery( "#contract_length" ).spinner({
    step: 1,
    spin: function( event, ui ) {
      if ( ui.value > 12 ) {
        jQuery( this ).spinner( "value", 12 );
        return false;
      } else if ( ui.value < 2 ) {
        jQuery( this ).spinner( "value", 2 );
        return false;
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

	var $propimage = jQuery("#property-cropper-image");
  var $propfilefield = '';
  var $propresultfield = '';
  var $propavatar = '';
  var $propcurrentavatar = '';


	jQuery('body').on( "change", '.property_img_upload', function(ev) {
	  $propfilefield = jQuery('#' + jQuery(this).data('file'))[0];
	  $propresultfield = jQuery('#' + jQuery(this).data('target'));
	  $propavatar = jQuery('#' + jQuery(this).data('avatar'));
	  $propcurrentavatar = $propavatar.attr('src');
		jQuery('#propertymodal').modal({show:true,backdrop:'static'}).on('shown.bs.modal', function (e) {
	    var oFReader = new FileReader();
	    oFReader.readAsDataURL($propfilefield.files[0]);
	    oFReader.onload = function (oFREvent) {

	    $propimage.attr('src', this.result);
	    $propimage.cropper({
	      aspectRatio: 1.3333333333333333,
	    });
	    };
	    jQuery('#avatarupload').val('');
		}).on('hidden.bs.modal', function () {
			$propimage.attr('src', '');
			$propimage.cropper('destroy');
			$propavatar.attr('src', $propcurrentavatar);
		});
	});

  jQuery('body').on('click', '#getpropdata', function () {
    canvas = $propimage.cropper('getCroppedCanvas',{width:1200,height:900});
    canvas.toBlob(function(blob) {
      url = URL.createObjectURL(blob);
      var reader = new FileReader();
			reader.readAsDataURL(blob);
			reader.onloadend = function() {
				var base64data = reader.result;
				$.ajax({
				  type: "POST",
				  dataType: "json",
				  url: cortiamajax.propimageuploadurl,
				  data: {image: base64data, type: $propresultfield.attr('id'), recordID: jQuery('input[name="recordID"]').val()},
				  success: function(data){
				  	$propcurrentavatar = data.avatarurl;
				  	$propresultfield.val(data.avatar_string)
						jQuery('#propertymodal').modal('hide');
				  }
				});
			}
    });
  });

  jQuery('.property-cropper-toolbar').on('click', '[data-method]', function () {
    var $this = jQuery(this),
        data = $this.data(),
        $target,
        result;

    if ($propimage.data('cropper') && data.method) {
      data = $.extend({}, data);
      if (typeof data.target !== 'undefined') {
        $target = jQuery(data.target);
        if (typeof data.option === 'undefined') {
        	data.option = JSON.parse($target.val());
        }
      }

      result = $propimage.cropper(data.method, data.option, data.secondOption);

      switch (data.method) {
          case 'scaleX':
          case 'scaleY':
              jQuery(this).data('option', -data.option);
          break;
      }
    }
  });

  jQuery('body').on('click', '.changedefaultimg', function (ev) {
		ev.preventDefault();
  	selected_button = jQuery(this);
  	property_id = jQuery(this).data('property');
  	image_id = jQuery(this).data('image');
		jQuery.ajax({
			type: "post",
			url: cortiamajax.defaultimageurl,
  		data: {'property_id' : property_id, 'image_id' : image_id},
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
					jQuery('.changedefaultimg, .deletedefaultimg').removeClass('d-none');
					jQuery(selected_button).addClass('d-none');
					jQuery(selected_button).next('.deletedefaultimg').addClass('d-none');
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
  });

  jQuery('body').on('click', '.deletedefaultimg', function (ev) {
		ev.preventDefault();
  	selected_button = jQuery(this);
  	property_id = jQuery(this).data('property');
  	image_id = jQuery(this).data('image');
		jQuery.ajax({
			type: "post",
			url: cortiamajax.deleteimageurl,
  		data: {'property_id' : property_id, 'image_id' : image_id},
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
					jQuery(selected_button).prev('.changedefaultimg').addClass('d-none');
					jQuery('#show_'+image_id).attr('src',cortiamajax.emptyphoto);
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

window.addEventListener("load", function(){
	var map = new Microsoft.Maps.Map('#previewmap', {
	    credentials: cortiamajax.map_key,
	    center: new Microsoft.Maps.Location(cortiamajax.latitude, cortiamajax.longitude),
//	    center: new Microsoft.Maps.Location(43.907373, -79.446407),
	    mapTypeId: Microsoft.Maps.MapTypeId.canvasLight,
	    zoom: 16
	});

  var pin = new Microsoft.Maps.Pushpin(map.getCenter(), {
      icon: MapPinIconImage,
      iconSize: { width: 40, height: 40 }
  });

  map.entities.push(pin);
});


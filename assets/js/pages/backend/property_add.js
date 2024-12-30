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
		placeholder: "Select a type",
	  data: property_types.residental
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
  var $propclearfield = '';


	jQuery('body').on( "change", '.property_img_upload', function(ev) {
	  $propfilefield = jQuery('#' + jQuery(this).data('file'))[0];
		$propclearfield = jQuery('#' + jQuery(this).data('file'));
	  $propresultfield = jQuery('#' + jQuery(this).data('target'));
	  $propavatar = jQuery('#' + jQuery(this).data('avatar'));
	  $propcurrentavatar = $propavatar.attr('src');
		jQuery('#propertymodal').modal({show:true,backdrop:'static'}).on('shown.bs.modal', function (e) {
	  	jQuery('#propertymodal .modal-dialog').block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.9}});
			var UploadfileName = $propfilefield.value
			var UploadfileNameExt = UploadfileName.substr(UploadfileName.lastIndexOf('.') + 1);
	    var oFReader = new FileReader();
			if(UploadfileNameExt.toLowerCase() == "heic"){
	      heic2any({
	          blob: $propfilefield.files[0],
	          toType: "image/png",
	      }).then(function (resultBlob) {
	    		oFReader.readAsDataURL(resultBlob);
	      });
			}else{
	    	oFReader.readAsDataURL($propfilefield.files[0]);
			}
	    oFReader.onload = function (oFREvent) {
		    $propimage.attr('src', this.result);
		    $propimage.cropper({
		      aspectRatio: 1.3333333333333333,
		    });
	    };
			$propimage.on('ready', function () {
				jQuery('#propertymodal .modal-dialog').unblock();
			});
		}).on('hidden.bs.modal', function () {
			$propclearfield.val('');
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

});

window.addEventListener("load", function(){
	var map = new Microsoft.Maps.Map('#previewmap', {
	    credentials: cortiamajax.map_key,
	    mapTypeId: Microsoft.Maps.MapTypeId.canvasLight,
	    zoom: 16
	});
});


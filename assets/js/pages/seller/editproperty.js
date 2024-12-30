jQuery(document).ready(function() {

  jQuery('body').on('click', '.tab-buttons', function () {
		jQuery('.tab-buttons').removeClass('active');
  });

	jQuery('#commission_rate, #contract_length, #type').select2({minimumResultsForSearch: -1});

	if(jQuery('#type').val() == 'Residential'){
		jQuery('#sub_type').select2({minimumResultsForSearch: -1, data: property_types.residental}).val(property_types.sub_type).trigger('change');
	}else{
		jQuery('#sub_type').select2({minimumResultsForSearch: -1, data: property_types.commercial}).val(property_types.sub_type).trigger('change');
	}

	jQuery('#type').on('select2:select', function (e) {
    if(jQuery('#type').val() == 'Residential') {
    	jQuery('#hideforcommercial').show();
    	jQuery('#changeablebutton').addClass('resident').removeClass('commercial');
	    jQuery('#sub_type').empty().select2({minimumResultsForSearch: -1, data: property_types.residental});
    } else if(jQuery('#type').val() == 'Commercial') {
    	jQuery('#hideforcommercial').hide();
    	jQuery('#changeablebutton').addClass('commercial').removeClass('resident');
	    jQuery('#sub_type').empty().select2({minimumResultsForSearch: -1, data: property_types.commercial});
    } else {
    	jQuery('#hideforcommercial').hide();
    	jQuery('#changeablebutton').addClass('resident').removeClass('commercial');
	    jQuery('#sub_type').empty().select2({minimumResultsForSearch: -1, data: ["Property Type"]});
    }
	});

	jQuery("#built_date").datepicker({
    format: "yyyy",
    viewMode: "years",
    minViewMode: "years"
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

//  jQuery('.maxlength-textarea').maxlength({
//      alwaysShow: true,
//  });

	var $propimage = jQuery("#property-cropper-image");
  var $propfilefield = '';
  var $propresultfield = '';
  var $propimg = '';
  var $propcurrentimg = '';
  var $propclearfield = '';

    $("html").on("dragover", function(e) {
        e.preventDefault();
        e.stopPropagation();
        $("h1").text("Drag here");
    });

    $("html").on("drop", function(e) { e.preventDefault(); e.stopPropagation(); });

    // Drag enter
    $('.dropboxfields').on('dragenter', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).addClass('activated');
    });

    // Drag over
    $('.dropboxfields').on('dragover', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).addClass('activated');
    });
    $('.dropboxfields').on('dragleave', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).removeClass('activated');
    });

    // Drop
    $('.dropboxfields').on('drop', function (e) {
        e.stopPropagation();
        e.preventDefault();
				let fileInput = document.querySelector('#' + $(this).data('file'));
				fileInput.files = e.originalEvent.dataTransfer.files;
        $(this).removeClass('activated');

			  $propfilefield = jQuery('#' + jQuery(this).data('file'))[0];
	  		$propclearfield = jQuery('#' + jQuery(this).data('file'));
			  $propresultfield = jQuery('#' + jQuery(this).data('target'));
	  	  $propimg = jQuery('#' + jQuery(this).data('img'));
	  		$propcurrentimg = $propimg.attr('src');

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
					$propimg.attr('src', $propcurrentimg);
			});

    });


	jQuery('body').on( "change", '.property_img_upload', function(ev) {
	  $propfilefield = jQuery('#' + jQuery(this).data('file'))[0];
	  $propclearfield = jQuery('#' + jQuery(this).data('file'));
	  $propresultfield = jQuery('#' + jQuery(this).data('target'));
	  $propimg = jQuery('#' + jQuery(this).data('img'));
		$propcurrentimg = $propimg.attr('src');
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
			$propimg.attr('src', $propcurrentimg);
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
					beforeSend: function() {
						jQuery('#propertymodal .modal-dialog').block({message: '<img src="' + cortiamajax.loadingimage + '"></div>',css: {border:'0px',width:'100%',top:'10%',left:'0%',background:'transparent', cursor:'context-menu'},overlayCSS: {backgroundColor:'#ffffff',opacity:.9}});
					},
				  success: function(data){
				  	if(data.success){
							swal.fire({
								title: data.success_title,
								text: data.success_message,
								type: "success",
								confirmButtonClass: "button-success"
							});
				  	}
				  	$propcurrentimg = data.avatarurl;
				  	$propresultfield.val(data.avatar_string)
						jQuery('#propertymodal .modal-dialog').unblock();
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


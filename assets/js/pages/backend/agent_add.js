jQuery(document).ready(function() {
  var $image = jQuery("#avatar-cropper-image");
  var $filefield = jQuery("#avatarupload")[0];
  var $currentavatar = jQuery('#pageavatar').attr('src');

	jQuery('body').on( "change", '#avatarupload', function(ev) {
		jQuery('#avatarmodal').modal({show:true,backdrop:'static'}).on('shown.bs.modal', function (e) {
	  	jQuery('#avatarmodal .modal-dialog').block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.9}});
			var UploadfileName = $filefield.value
			var UploadfileNameExt = UploadfileName.substr(UploadfileName.lastIndexOf('.') + 1);
	    var oFReader = new FileReader();
			if(UploadfileNameExt.toLowerCase() == "heic"){
	      heic2any({
	          blob: $filefield.files[0],
	          toType: "image/png",
	      }).then(function (resultBlob) {
	    		oFReader.readAsDataURL(resultBlob);
        });
			}else{
	    	oFReader.readAsDataURL($filefield.files[0]);
			}
	    oFReader.onload = function (oFREvent) {
		    $image.attr('src', this.result);
		    $image.cropper({
		      aspectRatio: 1,
		      autoCropArea: 1
		    });
	    };
			$image.on('ready', function () {
				jQuery('#avatarmodal .modal-dialog').unblock();
			});
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
				  data: {image: base64data},
				  success: function(data){
				  	$currentavatar = data.avatarurl;
				  	jQuery('input[name="avatar_string"]').val(data.avatar_string)
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

  jQuery('#license_states').select2({
		data: _states_,
	  placeholder: 'Select a State',
	  allowClear: true
  });

  jQuery('#license_expires').daterangepicker({
    "singleDatePicker": true,
    "showDropdowns": true,
    "minDate": new Date()
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

	var switchelems = Array.prototype.slice.call(document.querySelectorAll('.form-check-input-switchery'));

	switchelems.forEach(function(html) {
	  var switchery = new Switchery(html);
	});

});


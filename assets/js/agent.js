jQuery(document).ready(function() {

  jQuery('.format-phone-number').formatter({
      pattern: '{{999}}-{{999}}-{{9999}}'
  });

  jQuery('*[placeholder]').CorTitle();

	jQuery('body').on('click', '#res_menu_icon', function (ev) {
		ev.preventDefault();
		jQuery('#membermenu').slideToggle('slow');
	});

  jQuery('[data-display="tooltip"]').tooltip();
	jQuery('body').on('click', '.dofullscreen', function (ev) {
		ev.preventDefault();
//		jQuery(this).find('.icon-co').toggleClass('expand').toggleClass('target');
//		jQuery(this).parents('.card').toggleClass('makefull');
//		jQuery('html, body').animate({scrollTop: '0px'}, 300);
//		if(jQuery('.carousel').length){
//			jQuery('.carousel').slick('refresh');
//		}
		jQuery(this).find('.icon-co').toggleClass('expand').toggleClass('target');
		jQuery(this).parents('.card').find('.card-body, .card-footer').slideToggle('fast');
		if(jQuery('.carousel').length){
			jQuery('.carousel').slick('refresh');
		}
	});

  var $image = jQuery("#avatar-cropper-image");
  var $filefield = jQuery("#avatarupload")[0];
  var $currentavatar = jQuery('#useravatarbig').attr('src');

	jQuery('body').on( "click", '.triggerphotochange', function(ev) {
		ev.preventDefault();
		jQuery('#avatarupload').click();
	});

	jQuery('body').on( "change", '#avatarupload', function(ev) {
		jQuery('#avatarmodal').modal({show:true,backdrop:'static'}).on('shown.bs.modal', function (e) {
	  	jQuery('#avatarmodal .modal-dialog').block({ message: '<img src="' + cortiamphotoajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.9}});
			jQuery('.dropdown-menu').removeClass('show');
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
	    jQuery('#avatarupload').val('');
			$image.attr('src', '');
			$image.cropper('destroy');
			jQuery('#useravatarbig, #useravatarsmall, .photoneedsupdate').attr('src', $currentavatar);
		});
	});

  jQuery('body').on('click', '#dophotocrop', function () {
    canvas = $image.cropper('getCroppedCanvas',{width:250,height:250});
    canvas.toBlob(function(blob) {
      url = URL.createObjectURL(blob);
      var reader = new FileReader();
			reader.readAsDataURL(blob);
			reader.onloadend = function() {
				var base64data = reader.result;
		  	jQuery('#avatarmodal .modal-dialog').block({ message: '<img src="' + cortiamphotoajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.9}});
				$.ajax({
				  type: "POST",
				  dataType: "json",
				  url: cortiamphotoajax.avataruploadurl,
				  data: {image: base64data, type: 'admin', recordID: jQuery('input[name="recordID"]').val()},
				  success: function(data){
				  	$currentavatar = data.avatarurl;
						jQuery('#avatarmodal').modal('hide');
						jQuery('#avatarmodal .modal-dialog').unblock();
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


  jQuery('form.ajaxform').each(function(key, form) {
		jQuery(form).validate({
			ignore: ".ignore, :hidden, .returnbackbutton",
			submitHandler: function(form, event) {
			  event.preventDefault();
			  actionname = jQuery(form).data('source');
		  	jQuery(form).block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#f5f5f5',opacity:0.7}});
				jQuery(form).ajaxSubmit({
				  url: cortiamajax[actionname],
				  type: "POST",
				  dataType: "json",
				  success: function(i, s, r, a) {
				  	if(i.redirect_to){
				  		window.location.replace(i.redirect_to);
				  	}else{
					  	if(i.success){
								swal.fire({
									title: i.success_title,
									text: i.success_message,
									type: "success",
									confirmButtonClass: "button-success"
								});
								jQuery(form).unblock();
					  	}
							if (typeof RunAjaxFormSuccess === 'function') {
							  RunAjaxFormSuccess();
							}
							if (i.orangemessage) {
								jQuery('.approvalmessage').remove();
								jQuery('.content .container .row .maincontent').prepend(i.orangemessage);
							}
				  	}
				  	if(i.fail){
							swal.fire({
								title: i.fail_title,
								text: i.fail_message,
								type: "error",
								confirmButtonClass: "button-danger"
							});
							if (typeof RunAjaxFormFail === 'function') {
							  RunAjaxFormFail();
							}
							jQuery(form).unblock();
				  	}
				  	if(i.tos){
							jQuery.blockUI({message: i.tos_content ,onBlock: function(){jQuery("body").addClass("modal-open");}, onUnblock: function(){jQuery("body").removeClass("modal-open");}, css: {border:'0px',width:'100%',height:'100%',top:'0%',left:'0%',background:'transparent', cursor:'context-menu'},overlayCSS: {backgroundColor:'#000000',opacity:.7}});

							jQuery('#tos_action .disablefornow').tooltip();
							ScrollCheckElement = document.getElementById('tos_popup');
							jQuery('#tos_popup').scroll(function() {
								if( ScrollCheckElement.scrollTop >= (ScrollCheckElement.scrollHeight - ScrollCheckElement.offsetHeight)){
									jQuery('#tos_action .disablefornow').fadeOut(500, function() {jQuery('#tos_action').removeClass('disabled');});
								}
							});

							jQuery('#tos_action .button-danger').one('click touchstart', function(ev) {
						    jQuery.unblockUI();
						    jQuery(form).unblock();
						    jQuery("body").removeClass("modal-open");
							});

							jQuery('#tos_action .button-success').one('click touchstart', function(ev) {
								jQuery.ajax({
									type: "post",
									url: cortiamajax.accepttosurl,
		  						data: {'tos_accepted' : true},
									dataType: "json",
									beforeSend: function() {
										jQuery('#tos_action').block({ message: 'PLEASE WAIT...', css: {'font-size':'1rem','font-weight':'600',border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#f5f5f5',opacity:0.7}});
									},
									success: function(response){
										if(response.success){
						    			jQuery("body").removeClass("modal-open");
											jQuery.unblockUI();
											jQuery('#editprofileform .button-orange').click();
										}else{
											jQuery.unblockUI();
											swal.fire({
												title: response.fail_title,
												text: response.fail_message,
												type: "error",
												confirmButtonClass: "button-orange"
											});
										}
									}
								});
							});
				  	}
						if(i.errorfields){
							jQuery.each(i.errorfields, function(index, value) {
								jQuery("#"+index).addClass("border-danger").one("focus", function() {
									jQuery(this).removeClass("border-danger");
								});
					    });
						}
				  }
				});

			}
		});
	});

	if(typeof popmeup.messagetitle != 'undefined'){
  	jQuery('body').on('click', '.nav-link:not(:last-child)', function (ev) {
			if(typeof licenseaddedyes == 'undefined'){
	  		ev.preventDefault();
				swal.fire({
					title: popmeup.messagetitle,
					text: popmeup.messagetext,
					type: "error",
					confirmButtonClass: "button-danger"
				});
			}
		});
	}

	if(typeof notify.theme != 'undefined'){
		iziToast.show(notify);
	}
});
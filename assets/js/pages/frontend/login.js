jQuery(document).ready(function() {

	jQuery('body').on('click', '#res_menu_icon', function (ev) {
		ev.preventDefault();
		jQuery('#mainnav').toggleClass('mobilemenu');
	});

	jQuery('.form-input-styled').uniform();

	jQuery('body').on( 'click', '#logmein', function(ev) {
		ev.preventDefault();
        jQuery.ajax({
		  url: login.loginurl,
		  type: "POST",
          data: jQuery('.login-form').serialize(),
		  dataType: "json",
      beforeSend: function() {


          jQuery('#logincard').block({
              message: '<div class="processing text-blue"><i class="icon-spinner9 spinner mr-2"></i></div>',
              overlayCSS: {
	              backgroundColor: '#f5f5f5',
	              opacity: 0.7,
	              cursor: 'wait',
	              'border-radius' : '.75rem'
              },
              css: {
	              padding: 15,
	              'border-radius': '5px',
	              width: '80%',
	              left: '10%',
	              color: '#ffffff',
	              border: '0px solid #aaa',
	              backgroundColor: 'transparent',
	              cursor: 'wait'
              }
          });
      },
		  success: function(i)
		  {
				
			if(i.redirect_to){
		  	 	window.location.replace(i.redirect_to);
		  	}else{
		  	 	jQuery('#errorwrap').html('<div class="alert bg-danger text-white alert-styled-left alert-dismissible"><button type="button" class="close" data-dismiss="alert"><span>×</span></button><span class="font-weight-semibold">' + i.fail_message + '</span></div>');
		  	 	jQuery('#logincard').unblock();
		  	}
		  },error : function(request, status, error) {

			console.log(error);

			jQuery('#errorwrap').html('<div class="alert bg-danger text-white alert-styled-left alert-dismissible"><button type="button" class="close" data-dismiss="alert"><span>×</span></button><span class="font-weight-semibold">' + request.responseText.redirect_to+ '</span></div>');
			jQuery('#logincard').unblock();
		}
		
		
		});
	});

	jQuery('body').on( 'click', '#forgotmypass', function(ev) {
		ev.preventDefault();
		jQuery.ajax({
		  url: login.forgeturl,
		  type: "POST",
      data: jQuery('.forgot-form').serialize(),
		  dataType: "json",
      beforeSend: function() {
          jQuery('#logincard').block({
              message: '<div class="processing text-blue"><i class="icon-spinner9 spinner mr-2"></i></div>',
              overlayCSS: {
	              backgroundColor: '#f5f5f5',
	              opacity: 0.7,
	              cursor: 'wait',
	              'border-radius' : '.75rem'
              },
              css: {
	              padding: 15,
	              'border-radius': '5px',
	              width: '80%',
	              left: '10%',
	              color: '#ffffff',
	              border: '0px solid #aaa',
	              backgroundColor: 'transparent',
	              cursor: 'wait'
              }
          });
      },
		  success: function(i, s, r, a) {
		  	if(i.success){
					swal.fire({
						title: i.success_title,
						text: i.success_message,
						type: "success",
						confirmButtonClass: "button-orange"
					});
		  	}
		  	if(i.fail){
					swal.fire({
						title: i.fail_title,
						text: i.fail_message,
						type: "error",
						confirmButtonClass: "button-red"
					});
		  	}
				jQuery('#logincard').unblock();
		  }
		});
	});

	jQuery('body').on( 'click', '#triggerforgot', function(ev) {
		ev.preventDefault();
		jQuery('#logincard').addClass('d-none');;
		jQuery('#forgotcard').addClass('animated flipInY').removeClass('d-none');
	});

	jQuery('body').on( 'click', '#triggerlogin', function(ev) {
		ev.preventDefault();
		jQuery('#forgotcard').addClass('d-none').removeClass('animated flipInY');
		jQuery('#logincard').addClass('animated flipInY').removeClass('d-none');
	});

});
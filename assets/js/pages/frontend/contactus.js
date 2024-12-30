jQuery(document).ready(function() {

	jQuery( "form.contactusform" ).validate({
		ignore: ".ignore, :hidden, .returnbackbutton",
		submitHandler: function(form, event) {
		  event.preventDefault();
		  jQuery('#response').html('');
		  jQuery('.contactusform').block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.7}});
			jQuery(form).ajaxSubmit({
			  url: cortiamajax.formajaxurl,
			  type: "POST",
			  dataType: "json",
			  success: function(i, s, r, a) {
			  	if(i.success){
			  		gtag('event', 'Request', {'event_category' : 'Contact'});
		  			jQuery('.contactus-content .formside').html(i.html);
			  	}
			  	if(i.fail){
						jQuery('html, body').animate({scrollTop: jQuery('.contactus-content').offset().top}, 500);
			  		jQuery('#response').html(i.fail_message);
			  		jQuery('.contactusform').unblock();
			  	}
					if(i.errorfields){
						jQuery.each(i.errorfields, function(index, value) {
							jQuery("#"+index).addClass("border-danger").one("focus, mouseenter", function() {
								jQuery(this).removeClass("border-danger");
							});
				    });
					}
			  }
			});
		}
	});

});
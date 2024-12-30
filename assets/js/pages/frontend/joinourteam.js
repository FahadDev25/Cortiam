jQuery(document).ready(function() {

	jQuery( "form.joinusform" ).validate({
		ignore: ".ignore, :hidden, .returnbackbutton",
		submitHandler: function(form, event) {
		  event.preventDefault();
		  jQuery('#response').html('');
		  jQuery('.joinusform').block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.7}});
			jQuery(form).ajaxSubmit({
			  url: cortiamajax.formajaxurl,
			  type: "POST",
			  dataType: "json",
			  success: function(i, s, r, a) {
			  	if(i.redirect_to){
			  		gtag('event', 'Team', {'event_category' : 'Join'});
			  		window.location.replace(i.redirect_to);
			  	}
			  	if(i.fail){
						jQuery('html, body').animate({scrollTop: jQuery('.signup-content').offset().top}, 500);
			  		jQuery('#response').html(i.fail_message);
			  		jQuery('.joinusform').unblock();
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
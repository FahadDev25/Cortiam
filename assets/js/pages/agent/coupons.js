jQuery(document).ready(function() {


  jQuery('form.couponform').each(function(key, form) {
		jQuery(form).validate({
			ignore: ".ignore, :hidden, .returnbackbutton",
			submitHandler: function(form, event) {
			  event.preventDefault();
			  actionname = jQuery(form).data('source');
		  	jQuery(form).block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.7}});
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
								jQuery.ajax({
								  url: cortiamajax.updateurl,
								  type: "POST",
								  dataType: "json",
								  success: function(i, s, r, a) {
								  	jQuery('#couponlist').html(i.html);
										jQuery(form).unblock();
								  }
								});
				  		}
				  	}
				  	if(i.fail){
							swal.fire({
								title: i.fail_title,
								text: i.fail_message,
								type: "error",
								confirmButtonClass: "button-danger"
							});
							jQuery(form).unblock();
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


  jQuery('#couponlist').sortable({
  	axis: 'y',
  	items: "li.profile-list-item",
    update: function (event, ui) {
      var data = $(this).sortable('serialize');
			jQuery('#couponlistpart').block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.7}});
			jQuery.ajax({
			  url: cortiamajax.orderurl,
			  type: "POST",
			  data: data,
			  dataType: "json",
			  success: function(i, s, r, a) {
			  	if(i.fail){
						swal.fire({
							title: i.fail_title,
							text: i.fail_message,
							type: "error",
							confirmButtonClass: "button-orange"
						});
			  	}
			  	jQuery('#couponlistpart').unblock();
			  }
			});
    }
  });

});
jQuery(document).ready(function() {

	jQuery('body').on( "click", '.closeproposalpopup', function(ev) {
		ev.preventDefault();
		jQuery.unblockUI();
	});

	jQuery('body').on( "click", '.thisisexpired', function(ev) {
		ev.preventDefault();
  	button = jQuery(this);
  	profile_url = jQuery(button).data('profile');
  	price = jQuery(button).data('price');
		swal.fire({
	    title: "You have exceeded your 48hr window!",
	    text: "If you would like to work with this seller you will need to reintroduce yourself and be accepted by them again.",
	    type: "question",
	    showCancelButton: !0,
	    cancelButtonText: 'Close',
			cancelButtonClass: "button-dark float-left",
	    confirmButtonText: 'Proceed',
			confirmButtonClass: "button-orange float-right"
		}).then(function(e) {
			if(e.value){
	  		window.location.replace(profile_url);
			}
		});
	});

	jQuery('body').on( "click", '.paymentidrequired', function(ev) {
		ev.preventDefault();
  	button = jQuery(this);
  	profile_url = jQuery(button).data('profile');
  	price = jQuery(button).data('price');
		swal.fire({
	    title: "Payment Method Error",
	    text: "To accept this agreement you need an active payment method to pay $" + price + "USD one time fee as agreement fee. Please add your credit card as payment method in your account to accept this agreement.",
	    type: "question",
	    showCancelButton: !0,
	    cancelButtonText: 'Close',
			cancelButtonClass: "button-dark float-left",
	    confirmButtonText: 'Proceed',
			confirmButtonClass: "button-orange float-right"
		}).then(function(e) {
			if(e.value){
	  		window.location.replace(profile_url);
			}
		});
	});

	jQuery('body').on( "click", '.acceptagreement', function(ev) {
		ev.preventDefault();
  	button = jQuery(this);
  	agree_id = jQuery(button).data('agree');
  	price = jQuery(button).data('price');
		swal.fire({
	    title: "Are you sure?",
	    text: "By accepting this agreement you will be charged $" + price + "USD one time fee. Are you sure you want to accept this agreement?",
	    type: "question",
	    showCancelButton: !0,
	    cancelButtonText: 'Cancel',
			cancelButtonClass: "button-dark float-left",
	    confirmButtonText: 'Proceed',
			confirmButtonClass: "button-orange float-right"
		}).then(function(e) {
			if(e.value){
				jQuery.ajax({
					type: "post",
					url: cortiamajax.accepturl,
		  		data: {'agree_id' : agree_id},
					dataType: "json",
					beforeSend: function() {
						jQuery.blockUI({message: '<div class="emptyloader"><img src="' + cortiamajax.loadingimage + '"></div>',css: {border:'0px',width:'100%',top:'10%',left:'0%',background:'transparent', cursor:'context-menu'},overlayCSS: {backgroundColor:'#000000',opacity:.7}});
					},
					success: function(response){
				  	if(response.redirect_to){
				  		window.location.replace(response.redirect_to);
				  	}else{
							if(response.success){
								jQuery('#agree-' + agree_id).replaceWith(response.newcard);
								swal.fire({
									title: response.success_title,
									text: response.success_message,
									type: "success",
									confirmButtonClass: "button-orange"
								});
								jQuery.unblockUI();
							}
					  	if(response.fail){
								swal.fire({
									title: response.fail_title,
									text: response.fail_message,
									type: "error",
									confirmButtonClass: "button-orange"
								});
								jQuery.unblockUI();
					  	}
						}
					}
				});
			}
		});
	});

	jQuery('body').on( "click", '.declineagreement', function(ev) {
		ev.preventDefault();
  	button = jQuery(this);
  	agree_id = jQuery(button).data('agree');
		swal.fire({
	    title: "Are you sure?",
	    text: "Are you sure you want to decline this agreement?",
	    type: "question",
	    showCancelButton: !0,
	    cancelButtonText: 'Cancel',
			cancelButtonClass: "button-dark float-left",
	    confirmButtonText: 'Proceed',
			confirmButtonClass: "button-orange float-right"
		}).then(function(e) {
			if(e.value){
				jQuery.ajax({
					type: "post",
					url: cortiamajax.declineurl,
		  		data: {'agree_id' : agree_id},
					dataType: "json",
					beforeSend: function() {
						jQuery.blockUI({message: '<div class="emptyloader"><img src="' + cortiamajax.loadingimage + '"></div>',css: {border:'0px',width:'100%',top:'10%',left:'0%',background:'transparent', cursor:'context-menu'},overlayCSS: {backgroundColor:'#000000',opacity:.7}});
					},
					success: function(response){
						if(response.success){
							jQuery('#agree-' + agree_id).replaceWith(response.newcard);
							swal.fire({
								title: response.success_title,
								text: response.success_message,
								type: "success",
								confirmButtonClass: "button-orange"
							});
							jQuery.unblockUI();
						}
				  	if(response.fail){
							swal.fire({
								title: response.fail_title,
								text: response.fail_message,
								type: "error",
								confirmButtonClass: "button-orange"
							});
				  	}
					}
				});
			}
		});
	});

});
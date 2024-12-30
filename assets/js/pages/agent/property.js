jQuery(document).ready(function() {

	jQuery(document).on("click", '[data-toggle="lightbox"]', function(event) {
	  event.preventDefault();
	  jQuery(this).ekkoLightbox();
	});

	jQuery('body').on( "click", '#saveproperty', function(ev) {
		ev.preventDefault();
  	button = jQuery(this);
  	property_value = jQuery(this).data('value');
  	if(property_value == 'save'){
  		next_property_value = 'unsave';
  		next_button_text = 'UNSAVE';
  	}else{
  		next_property_value = 'save';
  		next_button_text = 'SAVE';
  	}
		jQuery.ajax({
			type: "post",
			url: cortiamajax.savepropertyurl,
		  data: {'property_id' : cortiamajax.property_id, 'value' : property_value},
			dataType: "json",
			beforeSend: function() {
				jQuery('.buttonsrow').block({message: '<img src="' + cortiamajax.loadingimage + '">',css: {border:'0px',width:'100%',top:'0px' , background:'transparent'},overlayCSS: {backgroundColor:'#ffffff',opacity:.8}});
			},
			success: function(response){
				if(response.success){
					jQuery(button).html(next_button_text).data('value', next_property_value);
				}else{
					swal.fire({
						title: response.fail_title,
						text: response.fail_message,
						type: "error",
						confirmButtonClass: "button-orange"
					});
				}
				jQuery('.buttonsrow').unblock();
			}
		});
	});

	jQuery('body').on( "click", '#expressproperty', function(ev) {
		ev.preventDefault();
  	button = jQuery(this);
		jQuery.ajax({
			type: "post",
			url: cortiamajax.expresspropertyurl,
		  data: {'property_id' : cortiamajax.property_id},
			dataType: "json",
			beforeSend: function() {
				jQuery('.buttonsrow').block({message: '<img src="' + cortiamajax.loadingimage + '">',css: {border:'0px',width:'100%',top:'0px' , background:'transparent'},overlayCSS: {backgroundColor:'#ffffff',opacity:.8}});
			},
			success: function(response){
				if(response.success){
					jQuery('#counterofferproperty , #expressproperty').remove();
					swal.fire({
						title: response.success_title,
						text: response.success_message,
						type: "success",
						confirmButtonClass: "button-orange"
					});
				}else{
					swal.fire({
						title: response.fail_title,
						text: response.fail_message,
						type: "error",
						confirmButtonClass: "button-orange"
					});
				}
				jQuery('.buttonsrow').unblock();
			}
		});
	});

	jQuery('body').on( "click", '#withdrawproposal', function(ev) {
		ev.preventDefault();
  	button = jQuery(this);
  	proposal_id = jQuery(button).data('prop');
		swal.fire({
	    title: "Are you sure?",
	    text: "Are you sure you want to withdraw this proposal?",
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
					url: cortiamajax.withdrawproposalurl,
		  		data: {'proposal_id' : proposal_id},
					dataType: "json",
					beforeSend: function() {
						jQuery('.buttonsrow').block({message: '<img src="' + cortiamajax.loadingimage + '">',css: {border:'0px',width:'100%',top:'0px' , background:'transparent'},overlayCSS: {backgroundColor:'#ffffff',opacity:.8}});
					},
					success: function(response){
						if(response.success){
							jQuery('#withdrawproposal, #proposedetails').remove();
							jQuery('.buttonsrow').append('<a href="#" class="button-dark" id="expressproperty">INTRODUCTION</a> <a href="#" class="button-border-orange" id="counterofferproperty">COUNTER OFFER</a>');
							swal.fire({
								title: response.success_title,
								text: response.success_message,
								type: "success",
								confirmButtonClass: "button-orange"
							});
						}else{
							swal.fire({
								title: response.fail_title,
								text: response.fail_message,
								type: "error",
								confirmButtonClass: "button-orange"
							});
						}
						jQuery('.buttonsrow').unblock();
					}
				});
			}else{
				jQuery('.buttonsrow').unblock();
			}
		});
	});

	jQuery('body').on( "click", '#counterofferproperty', function(ev) {
		ev.preventDefault();
  	button = jQuery(this);
		jQuery.ajax({
			type: "post",
			url: cortiamajax.counterofferform,
		  data: {'property_id' : cortiamajax.property_id},
			dataType: "json",
			beforeSend: function() {
				jQuery.blockUI({message: '<div id="co_form"><img src="' + cortiamajax.loadingimage + '"></div>',css: {border:'0px',width:'100%',top:'10%',left:'0%',background:'transparent', cursor:'context-menu'},overlayCSS: {backgroundColor:'#000000',opacity:.7}});
			},
			success: function(response){
				if(response.success){
					jQuery('#co_form').html(response.form);
				  jQuery('.maxlength-textarea').maxlength({alwaysShow: true});
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

	jQuery('body').on( "click", '#send-counter-offer', function(ev) {
		ev.preventDefault();
  	button = jQuery(this);
		var form_data = jQuery('#offer-form').serializeArray();
		form_data.push({name: "property_id", value: cortiamajax.property_id});
		jQuery.ajax({
			type: "post",
			url: cortiamajax.counterofferurl,
		  data: form_data,
			dataType: "json",
			beforeSend: function() {
				jQuery('#offer-form').block({message: '<img src="' + cortiamajax.loadingimage + '"></div>',css: {border:'0px',width:'100%',top:'10%',background:'transparent', cursor:'context-menu'},overlayCSS: {backgroundColor:'#ffffff',opacity:.9}});
			},
			success: function(response){
				if(response.success){
					jQuery('#counterofferproperty , #expressproperty').remove();
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
					jQuery('#offer-form').unblock();
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

	jQuery('body').on( "click", '#cancel-counter-offer', function(ev) {
		ev.preventDefault();
		jQuery.unblockUI();
	});

});
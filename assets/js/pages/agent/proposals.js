jQuery(document).ready(function() {

	jQuery('body').on( "click", '.closeproposalpopup', function(ev) {
		ev.preventDefault();
		jQuery.unblockUI();
	});

	jQuery('body').on( "click", '.acceptproposal', function(ev) {
		ev.preventDefault();
  	button = jQuery(this);
  	proposal_id = jQuery(button).data('prop');
		swal.fire({
	    title: "Are you sure?",
	    text: "Are you sure you want to accept this proposal?",
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
					url: cortiamajax.acceptproposalurl,
		  		data: {'proposal_id' : proposal_id},
					dataType: "json",
					beforeSend: function() {
						jQuery.blockUI({message: '<div class="emptyloader"><img src="' + cortiamajax.loadingimage + '"></div>',css: {border:'0px',width:'100%',top:'10%',left:'0%',background:'transparent', cursor:'context-menu'},overlayCSS: {backgroundColor:'#000000',opacity:.7}});
					},
					success: function(response){
						if(response.success){
							jQuery('#props-' + proposal_id).replaceWith(response.newcard);
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
					}
				});
			}else{
				jQuery('#record-' + record_id).removeClass('table-danger');
			}
		});
	});

	jQuery('body').on( "click", '.declineproposal', function(ev) {
		ev.preventDefault();
  	button = jQuery(this);
  	proposal_id = jQuery(button).data('prop');
		swal.fire({
	    title: "Are you sure?",
	    text: "Are you sure you want to decline this proposal?",
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
					url: cortiamajax.declineproposalurl,
		  		data: {'proposal_id' : proposal_id},
					dataType: "json",
					beforeSend: function() {
						jQuery.blockUI({message: '<div class="emptyloader"><img src="' + cortiamajax.loadingimage + '"></div>',css: {border:'0px',width:'100%',top:'10%',left:'0%',background:'transparent', cursor:'context-menu'},overlayCSS: {backgroundColor:'#000000',opacity:.7}});
					},
					success: function(response){
						if(response.success){
							jQuery('#props-' + proposal_id).replaceWith(response.newcard);
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
					}
				});
			}else{
				jQuery.unblockUI();
			}
		});
	});

	jQuery('body').on( "click", '.withdrawproposal', function(ev) {
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
						jQuery.blockUI({message: '<div class="emptyloader"><img src="' + cortiamajax.loadingimage + '"></div>',css: {border:'0px',width:'100%',top:'10%',left:'0%',background:'transparent', cursor:'context-menu'},overlayCSS: {backgroundColor:'#000000',opacity:.7}});
					},
					success: function(response){
						if(response.success){
							jQuery('#props-' + proposal_id).replaceWith(response.newcard);
							if(jQuery('#responsewaitprops .proplisting').length < 1){
								jQuery('#responsewaitprops').append('<div class="col-md-12"><p class="text-center p-5">Currently you do not have any response waiting proposals.</p></div>');
							}
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
					}
				});
			}else{
				jQuery('#record-' + record_id).removeClass('table-danger');
			}
		});
	});

	jQuery('body').on( "click", '.counterofferproposal', function(ev) {
		ev.preventDefault();
  	button = jQuery(this);
  	proposal_id = jQuery(button).data('prop');
		jQuery.ajax({
			type: "post",
			url: cortiamajax.counterofferform,
		  data: {'proposal_id' : proposal_id},
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
  	proposal_id = jQuery(button).data('prop');
		form_data.push({name: "proposal_id", value: proposal_id});
		jQuery.ajax({
			type: "post",
			url: cortiamajax.counterofferurl,
		  data: form_data,
			dataType: "json",
			beforeSend: function() {
				jQuery('#offer-form').block({message: '<img src="' + cortiamajax.loadingimage + '"></div>',css: {border:'0px',width:'100%',top:'10%',left:'0%',background:'transparent', cursor:'context-menu'},overlayCSS: {backgroundColor:'#ffffff',opacity:.9}});
			},
			success: function(response){
				if(response.success){
					jQuery(button).remove();
					jQuery('#props-' + proposal_id).replaceWith(response.newcard);
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
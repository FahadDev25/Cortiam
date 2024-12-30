jQuery(document).ready(function() {

	gtag('event', 'Signup', {'event_category' : 'Visit', 'User Type': 'Seller'});

  jQuery('#state').select2({
		data: _states_,
	  placeholder: 'Select a State',
	  allowClear: true
  });

	jQuery('#state').on('select2:select', function (e) {
	  var selected_state = e.params.data;

		if(selected_state.text !== 'Florida')
		{
			jQuery('#response').html('');
			jQuery('#response').html('<div class="alert bg-info text-white alert-styled-left alert-dismissible"><button type="button" class="close" data-dismiss="alert"><span>×</span></button><span class="font-weight-semibold">Currently, our service is only available in Florida.</span></div>');

		}    	
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

	jQuery( "form.signupform" ).validate({
		ignore: ".ignore, :hidden, .returnbackbutton",
		submitHandler: function(form, event) {
		  event.preventDefault();
		  jQuery('#response').html('');
		  jQuery('.signupform').block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.7}});
			
			jQuery(form).ajaxSubmit({
			  url: cortiamajax.formajaxurl,
			  type: "POST",
			  dataType: "json",
			  success: function(i, s, r, a) {
			  	gtag('event', 'Submitted', {'event_category' : 'Signup', 'User Type': 'Seller'});
			  	if(i.askfor){
						swal.fire({
						  title: i.askfor_title,
						  showCancelButton: true,
					    html: i.askfor_message,
					    type: "question",
					    cancelButtonText: 'Cancel',
							cancelButtonClass: "button-red float-left",
					    confirmButtonText: 'Accept',
							confirmButtonClass: "button-orange float-right",
						}).then(function(e) {

							if(e.value){
								form_details = jQuery('.signupform').serialize();
								console.log(form_details);

								jQuery.ajax({
								  url: cortiamajax.notifyajaxurl,
								  type: "POST",
								  data: form_details,
								  dataType: "json",
								  success: function(i, s, r, a) {
								  	if(i.redirect_to){
								  		window.location.replace(i.redirect_to);
								  	}else{
									  	if(i.success){
									  		gtag('event', 'Waitlist', {'event_category' : 'Added', 'User Type': 'Seller'});
												swal.fire({
													title: i.success_title,
													text: i.success_message,
													type: "success",
													confirmButtonClass: "btn btn-secondary"
												});
												jQuery('#record-' + record_id).remove();
									  	}
								  	}
								  	if(i.fail){
											swal.fire({
												title: i.fail_title,
												text: i.fail_message,
												type: "error",
												confirmButtonClass: "btn btn-secondary"
											});
								  	}
								  }
								});
							}
							if(e.dismiss == 'cancel'){
								gtag('event', 'Waitlist', {'event_category' : 'Disagree', 'User Type': 'Seller'});
								swal.fire({
									title: i.cancelty_title,
									text: i.cancelty_message,
									type: "success",
									confirmButtonClass: "btn btn-secondary"
								});
		  					jQuery('#response').html('');
					  		jQuery('.signupform').unblock();
							}
						});
			  	}
			  	if(i.redirect_to){
			  		gtag('event', 'Completed', {'event_category' : 'Signup', 'User Type': 'Seller'});
			  		window.location.replace(i.redirect_to);
			  	}
			  	if(i.fail){
			  		jQuery('#response').html(i.fail_message);
			  		jQuery('.signupform').unblock();
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


	jQuery(document).on('focusout', '#email', function(){
		let email = $(this).val();
		jQuery.ajax({
			type: "post",
			url: cortiamajax.emailajaxurl,
  		    data: { email : email},
			dataType: "json",
			success: function(response){
				if(response.success == "success")
				{
					
					$('#email').val('');
					$('#email').focus();
					jQuery('#response').html('');
					jQuery('#response').html('<div class="alert bg-danger text-white alert-styled-left alert-dismissible"><button type="button" class="close" data-dismiss="alert"><span>×</span></button><span class="font-weight-semibold">'+response.messsage+'</span></div>');
					jQuery('.signupform').unblock();


					return false;	
				}					

			}
		});
		
	});

});


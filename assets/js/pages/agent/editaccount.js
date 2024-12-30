jQuery(document).ready(function() {
	$('.specialization-selection').select2();
	jQuery('body').on( "click", '.deactivateme', function(ev) {
		ev.preventDefault();
		record_id = jQuery(this).data('id');
		swal.fire({
		  title: 'Please Confirm!',
		  input: 'text',
		  inputAttributes: {
		    autocapitalize: 'on'
		  },
		  showCancelButton: true,
	    html: 'Your account will be removed and you won\'t be able to revert this action! If you still want to continue please type <b>"DELETE"</b> to the input box and click proceed button.',
	    type: "question",
	    cancelButtonText: '<b><i class="icon-cross2"></i></b> Cancel',
			cancelButtonClass: "button-dark float-left",
	    confirmButtonText: '<b><i class="icon-checkmark3"></i></b> Proceed',
			confirmButtonClass: "button-orange float-right",
		  inputValidator: (value) => {
		    return new Promise((resolve) => {
		      if (value === 'DELETE') {
		        resolve()
		      } else {
		        resolve('You should type "DELETE"')
		      }
		    })
		  }
		}).then(function(e) {
			if(e.value == 'DELETE'){
				jQuery.ajax({
				  url: cortiamajax.deactivateurl,
				  type: "POST",
				  data: {'recordID' : record_id},
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
									confirmButtonClass: "btn btn-secondary"
								});
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
		});
	});

	jQuery('body').on( "change", '#notifications', function(ev) {
		if(!jQuery(this).is(":checked")){
			swal.fire({
			  title: 'Please Confirm!',
			  showCancelButton: true,
		    html: 'Disabling email notifications might lead you to missing important emails and impact your ability to win properties. Are you so you want to proceed and cancel email notifications?',
		    type: "question",
		    cancelButtonText: '<b><i class="icon-cross2"></i></b> Cancel',
				cancelButtonClass: "button-dark float-left",
		    confirmButtonText: '<b><i class="icon-checkmark3"></i></b> Proceed',
				confirmButtonClass: "button-orange float-right",
			}).then(function(e) {
				if(e.dismiss == 'cancel'){
					jQuery('#notifications').prop('checked', true);
				}
			});
		}
	});

	jQuery(document).on('keyup', function(e) {
	  if (e.which === 27) {
	    jQuery.unblockUI();
	  }
	});

	jQuery('body').on('click touchstart', '.blockOverlay', function(ev) {
    jQuery.unblockUI();
	});


  jQuery('body').on( "click", '#deletemycard', function(ev) {
		ev.preventDefault();
  	payment_id = jQuery(this).data('id');
  	payment_row = jQuery(this).parents('.profile-list-item');
		swal.fire({
			title: 'Payment Method Removal',
			text: 'Are you sure you want to delete selected payment method?',
	    type: "question",
	    showCancelButton: !0,
	    cancelButtonText: 'Cancel',
			cancelButtonClass: "button-dark float-left",
	    confirmButtonText: 'Proceed',
			confirmButtonClass: "button-orange float-right"
		}).then(function(e) {
			if(e.value){
				jQuery('#paymentpart').block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.7}});
				jQuery.ajax({
				  url: cortiamajax.deletecardurl,
				  type: "POST",
				  data: {'payment_id' : payment_id},
				  dataType: "json",
				  success: function(i, s, r, a) {
				  	if(i.success){
							swal.fire({
								title: i.success_title,
								text: i.success_message,
								type: "success",
								confirmButtonClass: "button-orange"
							});
							jQuery(payment_row).remove();
				  	}
				  	if(i.fail){
							swal.fire({
								title: i.fail_title,
								text: i.fail_message,
								type: "error",
								confirmButtonClass: "button-orange"
							});
				  	}
				  	jQuery('#paymentpart').unblock();
				  }
				});
			}
		});
  });

  jQuery('body').on( "click", '#setmycard', function(ev) {
		ev.preventDefault();
  	payment_id = jQuery(this).data('id');
  	current_buttons = jQuery(this).parents('.profile-list-item').find('.btn-group.dropleft');
		swal.fire({
			title: 'Set Default Payment Method',
			text: 'Are you sure you want to set selected payment method as default payment method?',
	    type: "question",
	    showCancelButton: !0,
	    cancelButtonText: 'Cancel',
			cancelButtonClass: "button-dark float-left",
	    confirmButtonText: 'Proceed',
			confirmButtonClass: "button-orange float-right"
		}).then(function(e) {
			if(e.value){
				jQuery('#paymentpart').block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.7}});
				jQuery.ajax({
				  url: cortiamajax.setpaymenturl,
				  type: "POST",
				  data: {'payment_id' : payment_id},
				  dataType: "json",
				  success: function(i, s, r, a) {
				  	if(i.success){
							swal.fire({
								title: i.success_title,
								text: i.success_message,
								type: "success",
								confirmButtonClass: "button-orange"
							});
							jQuery('.btn-group.dropleft').removeClass('invisible');
							jQuery(current_buttons).addClass('invisible');
				  	}
				  	if(i.fail){
							swal.fire({
								title: i.fail_title,
								text: i.fail_message,
								type: "error",
								confirmButtonClass: "button-orange"
							});
				  	}
				  	jQuery('#paymentpart').unblock();
				  }
				});
			}
		});
  });

  jQuery('body').on( "click", '#card-cancel-button', function(ev) {
		ev.preventDefault();
		jQuery('#cardpart').slideUp().html('');
		jQuery('#addcart').show();
  });

  jQuery('body').on( "click", '#addcart', function(ev) {
  	jQuery(this).hide();
		ev.preventDefault();
		jQuery('#cardpart').hide();
		jQuery('#paymentpart').block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.7}});
		jQuery.ajax({
		  url: cortiamajax.getformurl,
		  type: "POST",
		  dataType: "json",
		  success: function(i, s, r, a) {
		  	if(i.success){
		  		jQuery('#cardpart').html(i.form);
					jQuery('#cardpart').slideDown('slow');
			    jQuery('html, body').animate({scrollTop: jQuery("#cardpart").offset().top}, 1000);

					var stripe = Stripe(cortiamajax.stripekey);

					var elements = stripe.elements();
					var cardElement = elements.create('card', {
			  		iconStyle: 'solid',
					  style: {
					    base: {
					      backgroundColor: '#ffffff',
					      lineHeight: '36px',
					      color: '#000000',
					      padding: 6,
					      fontWeight: 300,
					      fontFamily: 'Open Sans, Segoe UI, sans-serif',
					      fontSize: '16px',
					      fontSmoothing: 'antialiased',
					      ':-webkit-autofill': {
					        color: '#4c525e',
					      },
					      '::placeholder': {
					        color: '#999999',
					      },
					    },
					    invalid: {
					      iconColor: '#da0101',
					      color: '#da0101',
					    }
					  },
					  classes: {
					    focus: 'is-focused',
					    empty: 'is-empty',
					  }
					});
					cardElement.mount('#card-element');

					var cardholderName = document.getElementById('cardholder-name');
					var cardholderPhone = document.getElementById('cardholder-phone');
					var cardButton = document.getElementById('card-button');
					var clientSecret = cardButton.dataset.secret;

					function CheckCardError(result) {
					  var errorElement = document.querySelector('.error');
					  errorElement.classList.remove('visible');
					  if (result.error) {
					    errorElement.textContent = result.error.message;
					    errorElement.classList.add('visible');
					  }
					  jQuery('#paymentpart').unblock();
					}

					cardElement.on('change', function(event) {
					  CheckCardError(event);
					});


				  jQuery('#cardpart input').each(function(key, input) {
					  input.addEventListener('focus', function() {
					    input.classList.add('is-focused');
					  });
					  input.addEventListener('blur', function() {
					    input.classList.remove('is-focused');
					  });
					  input.addEventListener('keyup', function() {
					    if (input.value.length === 0) {
					      input.classList.add('is-empty');
					    } else {
					      input.classList.remove('is-empty');
					    }
					  });
				  });


					cardButton.addEventListener("click", function(event) {
					  event.preventDefault();
						_card_name_ = jQuery('#cardholder-name').val();
						_card_phone_ = jQuery('#cardholder-phone').val();
						phoneregex = /[0-9\-\(\)\s]+/;
						if(_card_name_ == ""){
							jQuery('#cardpart .outcome .error').html('Please fill your Name.').addClass('visible');
							jQuery('#cardholder-name').one( "click", function() {
								jQuery('#cardpart .outcome .error').html(' ').removeClass('visible');
							});
						}else if(_card_phone_ == ""){
							jQuery('#cardpart .outcome .error').html('Please fill your Phone number.').addClass('visible');
							jQuery('#cardholder-phone').one( "click", function() {
								jQuery('#cardpart .outcome .error').html(' ').removeClass('visible');
							});
						}else if(!phoneregex.test(_card_phone_)){
							jQuery('#cardpart .outcome .error').html('Please fill a valid Phone number.').addClass('visible');
							jQuery('#cardholder-phone').one( "click", function() {
								jQuery('#cardpart .outcome .error').html(' ').removeClass('visible');
							});
						}else {
							jQuery('#paymentpart').block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.7}});
						  stripe
						    .confirmCardSetup(clientSecret, {
						      payment_method: {
						        card: cardElement,
						        billing_details: {
						          name: cardholderName.value,
						          phone: cardholderPhone.value,
						        },
						      }
						    })
						    .then(function(result) {
						      if (result.error) {
							      CheckCardError(result);
						      } else {
										jQuery.ajax({
										  url: cortiamajax.newcardurl,
										  type: "POST",
										  data: {'payment_id' : result.setupIntent.payment_method},
										  dataType: "json",
										  success: function(i, s, r, a) {
										  	if(i.success){
													swal.fire({
														title: i.success_title,
														text: i.success_message,
														type: "success",
														confirmButtonClass: "button-orange"
													});
													jQuery.ajax({
													  url: cortiamajax.updatecardurl,
													  type: "POST",
													  dataType: "json",
													  success: function(response) {
													  	if(response.success){
													  		jQuery('#cardlistingpart').html(response.html);
																jQuery('#cardpart').slideUp().html('');
																jQuery('#addcart').show();
													  	}
													  	if(response.fail){
																swal.fire({
																	title: i.fail_title,
																	text: i.fail_message,
																	type: "error",
																	confirmButtonClass: "button-orange"
																});
													  	}
													  	jQuery('#paymentpart').unblock();
													  }
													});
										  	}
										  	if(i.fail){
													swal.fire({
														title: i.fail_title,
														text: i.fail_message,
														type: "error",
														confirmButtonClass: "button-orange"
													});
										  		jQuery('#paymentpart').unblock();
										  	}
										  }
										});
						      }
						    });
							}
						});
			  	}
			  	if(i.fail){
						swal.fire({
							title: i.fail_title,
							text: i.fail_message,
							type: "error",
							confirmButtonClass: "button-orange"
						});
			  	}
			  	jQuery('#paymentpart').unblock();
		  }
		});
  });



  jQuery('body').on( "change", '#paymentmethodchange', function(ev) {
      if(jQuery(this).is(":checked")) {
      	new_payment_type = 'automatic';
      	new_payment_variable = 'Yes';
      	new_payment_cancel = false;
      }else{
      	new_payment_type = 'manual';
      	new_payment_variable = 'No';
      	new_payment_cancel = true;
      }
		swal.fire({
			title: 'Payment Method Change',
			text: 'Are you sure you want to set your payments to '+ new_payment_type  +'?',
	    type: "question",
	    showCancelButton: !0,
	    cancelButtonText: 'Cancel',
			cancelButtonClass: "button-dark float-left",
	    confirmButtonText: 'Proceed',
			confirmButtonClass: "button-orange float-right"
		}).then(function(e) {
			if(e.value){
				jQuery('#paymentpart').block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.7}});
				jQuery.ajax({
				  url: cortiamajax.changepaymenturl,
				  type: "POST",
				  data: {'auto_payment' : new_payment_variable},
				  dataType: "json",
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
								confirmButtonClass: "button-orange"
							});
				  	}
				  	jQuery('#paymentpart').unblock();
				  }
				});
			}else{
				jQuery('#paymentmethodchange').prop('checked', new_payment_cancel);
			}
		});
  });

  jQuery('#bio').trumbowyg({
      btns: [
          // ['formatting'],
          ['strong', 'em'],
          ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
          ['unorderedList', 'orderedList'],
          ['undo', 'redo'], // Only supported in Blink browsers
          ['insertImage', 'link'],
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
      ]
  });

  jQuery('.select').select2({
  	minimumResultsForSearch: Infinity,
  });

	jQuery("#experience").datepicker({
    format: "yyyy",
    viewMode: "years",
    minViewMode: "years",
    endDate: new Date(),
    autoHide: true
	});

//   jQuery('#state').select2({
// 		data: _states_,
// 	  placeholder: 'Select a State',
// 	  allowClear: true
//   });

// 	jQuery('#state').on('select2:select', function (e) {
// 	  var selected_state = e.params.data;
// 		jQuery('#city').select2({
// 			data: _cities_[selected_state.id],
// 			placeholder: 'Select a City',
// 			allowClear: true
// 		});
// 	});

// 	jQuery('#city').select2({
// 		data:  _cities_[''+jQuery('#state').val()+''],
// 		placeholder: 'Select a City',
// 		allowClear: true
// 	});

//   jQuery('#brokerage_state').select2({
// 		data: _states_,
// 	  placeholder: 'Select a State',
// 	  allowClear: true
//   });

// 	jQuery('#brokerage_state').on('select2:select', function (e) {
// 	  var selected_state = e.params.data;
// 		jQuery('#brokerage_city').select2({
// 			data: _cities_[selected_state.id],
// 			placeholder: 'Select a City',
// 			allowClear: true
// 		});
// 	});

// 	jQuery('#brokerage_city').select2({
// 		data:  _cities_[''+jQuery('#brokerage_state').val()+''],
// 		placeholder: 'Select a City',
// 		allowClear: true
// 	});


  jQuery('body').on( "click", '#addlicense', function(ev) {
  	jQuery(this).hide();
		ev.preventDefault();
		jQuery('#addlicense').hide();
		jQuery('#licenselistingpart').slideUp();
		jQuery('#licensespart').block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.7}});
		jQuery.ajax({
		  url: cortiamajax.getlicenseformurl,
		  type: "POST",
		  dataType: "json",
		  success: function(i, s, r, a) {
		  	if(i.success){
		  		jQuery('#addnewlicense').html(i.form);
					jQuery('#addnewlicense').slideDown('slow');
			    jQuery('html, body').animate({scrollTop: jQuery("#licensespart").offset().top}, 1000);

				  jQuery('#interested').select2({
				  	minimumResultsForSearch: Infinity,
				  });
				  jQuery('#license_state').select2({
						data: _states_,
					  placeholder: 'Select a State',
					  allowClear: true
				  });
				  jQuery('#license_expire').datepicker({format: 'mm/dd/yyyy', startDate: new Date(), autoHide: true});
				  jQuery('#new-license-form *[placeholder]').CorTitle();
		  	}
		  	if(i.fail){
					swal.fire({
						title: i.fail_title,
						text: i.fail_message,
						type: "error",
						confirmButtonClass: "button-orange"
					});
		  	}
		  	jQuery('#licensespart').unblock();
		  }
		});
  });


  jQuery('body').on( "click", '#license-add-button', function(ev) {
		ev.preventDefault();
		var form_data = jQuery('#new-license-form').serializeArray();
		jQuery('#addnewlicense').block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.7}});
		jQuery.ajax({
		  url: cortiamajax.addlicenseurl,
		  type: "POST",
		  data: form_data,
		  dataType: "json",
		  success: function(response) {
		  	if(response.success){
					swal.fire({
						title: response.success_title,
						text: response.success_message,
						type: "success",
						confirmButtonClass: "button-orange"
					});

					jQuery.ajax({
					  url: cortiamajax.listlicenseurl,
					  type: "POST",
					  dataType: "json",
					  success: function(i, s, r, a) {
					  	if(i.success){
					  		jQuery('#licenselistingpart .profile-list').html(i.form);
								jQuery('#licenselistingpart').slideDown('slow');
								jQuery('#addnewlicense').html('').slideUp();
						    jQuery('html, body').animate({scrollTop: jQuery("#licensespart").offset().top}, 1000);
								jQuery('#addlicense').show();
								licenseaddedyes = 'Yes';
					  	}
					  }
					});
		  	}
		  	if(response.fail){
					swal.fire({
						title: response.fail_title,
						text: response.fail_message,
						type: "error",
						confirmButtonClass: "button-orange"
					});
		  	}
		  	if(response.fail){
					swal.fire({
						title: response.fail_title,
						text: response.fail_message,
						type: "error",
						confirmButtonClass: "button-orange"
					});
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
		  	jQuery('#addnewlicense').unblock();
		  }
		});
  });

  jQuery('body').on( "click", '#editmylicense', function(ev) {
		ev.preventDefault();
  	license_id = jQuery(this).data('id');
		jQuery('#addlicense').hide();
		jQuery('#licenselistingpart').slideUp();
		jQuery('#licensespart').block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.7}});
		jQuery.ajax({
		  url: cortiamajax.getlicenseformurl,
		  type: "POST",
		  data: {'licenseid' : license_id},
		  dataType: "json",
		  success: function(i, s, r, a) {
		  	if(i.success){
		  		jQuery('#addnewlicense').html(i.form);
					jQuery('#addnewlicense').slideDown('slow');
			    jQuery('html, body').animate({scrollTop: jQuery("#licensespart").offset().top}, 1000);

				  jQuery('#interested').select2({
				  	minimumResultsForSearch: Infinity,
				  });
				  jQuery('#license_state').select2({
						data: _states_,
					  placeholder: 'Select a State',
					  allowClear: true
				  });
				  jQuery('#license_expire').datepicker({format: 'mm/dd/yyyy', startDate: new Date(), autoHide: true});
				  jQuery('#new-license-form *[placeholder]').CorTitle();
		  	}
		  	if(i.fail){
					swal.fire({
						title: i.fail_title,
						text: i.fail_message,
						type: "error",
						confirmButtonClass: "button-orange"
					});
		  	}
		  	jQuery('#licensespart').unblock();
		  }
		});
  });

  jQuery('body').on( "click", '#license-update-button', function(ev) {
		ev.preventDefault();
		var form_data = jQuery('#new-license-form').serializeArray();
		jQuery('#addnewlicense').block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.7}});
		jQuery.ajax({
		  url: cortiamajax.editlicenseurl,
		  type: "POST",
		  data: form_data,
		  dataType: "json",
		  success: function(response) {
		  	if(response.success){
					swal.fire({
						title: response.success_title,
						text: response.success_message,
						type: "success",
						confirmButtonClass: "button-orange"
					});

					jQuery.ajax({
					  url: cortiamajax.listlicenseurl,
					  type: "POST",
					  dataType: "json",
					  success: function(i, s, r, a) {
					  	if(i.success){
					  		jQuery('#licenselistingpart .profile-list').html(i.form);
								jQuery('#licenselistingpart').slideDown('slow');
								jQuery('#addnewlicense').html('').slideUp();
						    jQuery('html, body').animate({scrollTop: jQuery("#licensespart").offset().top}, 1000);
								jQuery('#addlicense').show();
					  	}
					  }
					});
		  	}
		  	if(response.fail){
					swal.fire({
						title: response.fail_title,
						text: response.fail_message,
						type: "error",
						confirmButtonClass: "button-orange"
					});
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
		  	jQuery('#addnewlicense').unblock();
		  }
		});
  });

  jQuery('body').on( "click", '#license-cancel-button', function(ev) {
		ev.preventDefault();
		jQuery('#addnewlicense').slideUp().html('');
		jQuery('#addlicense').show();
 		jQuery('#licenselistingpart').slideDown();
   	jQuery('html, body').animate({scrollTop: jQuery("#licensespart").offset().top}, 1000);
  });

  jQuery('body').on( "click", '#deletemylicense', function(ev) {
		ev.preventDefault();
  	license_id = jQuery(this).data('id');
  	payment_row = jQuery(this).parents('.profile-list-item');
		swal.fire({
			title: 'Agent License Removal',
			text: 'Are you sure you want to delete selected agent license?',
	    type: "question",
	    showCancelButton: !0,
	    cancelButtonText: 'Cancel',
			cancelButtonClass: "button-dark float-left",
	    confirmButtonText: 'Proceed',
			confirmButtonClass: "button-orange float-right"
		}).then(function(e) {
			if(e.value){
				jQuery('#paymentpart').block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.7}});
				jQuery.ajax({
				  url: cortiamajax.deletelicenseurl,
				  type: "POST",
				  data: {'license_id' : license_id},
				  dataType: "json",
				  success: function(i, s, r, a) {
				  	if(i.success){
							swal.fire({
								title: i.success_title,
								text: i.success_message,
								type: "success",
								confirmButtonClass: "button-orange"
							});
							jQuery(payment_row).remove();
				  	}
				  	if(i.fail){
							swal.fire({
								title: i.fail_title,
								text: i.fail_message,
								type: "error",
								confirmButtonClass: "button-orange"
							});
				  	}
				  	jQuery('#paymentpart').unblock();
				  }
				});
			}
		});
  });

});
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
		  jQuery(this).find('.icon-co').toggleClass('expand').toggleClass('target');
		  jQuery(this).parents('.card').find('.card-body, .card-footer').slideToggle('fast');
		  if(jQuery('.carousel').length){
			  jQuery('.carousel').slick('refresh');
		  }
	  })
  
	  if(jQuery(window).width() > 1024){
		  var topofmodal = '9%';
		  var processpad = 25;
		  var processwidth = '60%';
		  var processleft = '20%';
	  }else if(jQuery(window).width() > 700){
		  var topofmodal = '6%';
		  var processpad = 15;
		  var processwidth = '86%';
		  var processleft = '7%';
	  }else{
		  var topofmodal = '2%';
		  var processpad = 10;
		  var processwidth = '94%';
		  var processleft = '3%';
	  }
  
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

						console.log(i);


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
											  jQuery('#addpropertyform #steps-fourth .button-orange').click();
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
						if(i.returntab){
							  jQuery('#' + i.tabid + ' .tab-pane').removeClass('active');
							  jQuery('#' + i.returntab).addClass('show').addClass('active');
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
  
	jQuery('body').on('click', '.withdrawalbutton', function (ev) {
		ev.preventDefault();
		propertyID = jQuery(this).data('property');
		redirect = jQuery(this).data('redirect');
	  jQuery('html, body').animate({scrollTop: jQuery('body').offset().top}, 500);
		  jQuery.ajax({
			  type: "post",
			  url: cortiamgeneralajax.withdrawform,
			  data: 'propertyID=' + propertyID + '&redirect=' + redirect,
			  dataType: "json",
			  beforeSend: function() {
				  jQuery.blockUI({
			  message: '<div class="modalloader"><img src="' + cortiamgeneralajax.loadingimage  + '"></div>',
			  overlayCSS:  {
				  backgroundColor: '#000000',
				  opacity:         0.4,
				  cursor:          'default'
				  },
				  css: {
				  top:        topofmodal,
				  padding:        processpad,
				  width:          processwidth,
				  left:           processleft,
				  color:          '#ffffff',
				  border:         '0px solid #aaa',
				  position:  'absolute',
				  backgroundColor:'transparent',
				  }
			  });
			  },
			  success: function(response){
				  if(response.form){
					  jQuery('.blockMsg').html(response.form);
				  }else{
					  jQuery.unblockUI();
				  }
			  }
		  });
	});
  
	jQuery('body').on('click', '.submitwithdraw', function (ev) {
		ev.preventDefault();
	  jQuery('html, body').animate({scrollTop: jQuery('body').offset().top}, 500);
		  jQuery.ajax({
			  type: "post",
			  url: cortiamgeneralajax.withdrawurl,
			  data: jQuery('form.withdrawform').serialize(),
			  dataType: "json",
			  beforeSend: function() {
				jQuery('.modalform').block({ message: '<img src="' + cortiamgeneralajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.7}});
			  },
			  success: function(response){
				if(response.success){
					if(response.redirect_to){
						window.location.replace(response.redirect_to);
					}else{
						  swal.fire({
							  title: response.success_title,
							  text: response.success_message,
							  type: "success",
							  confirmButtonClass: "button-success"
						  });
						  jQuery.unblockUI();
					}
				}
				if(response.fail){
					  swal.fire({
						  title: response.fail_title,
						  text: response.fail_message,
						  type: "error",
						  confirmButtonClass: "button-danger"
					  });
				}
				  if(response.errorfields){
					  jQuery.each(response.errorfields, function(index, value) {
						  jQuery("#"+index).addClass("border-danger").one("focus", function() {
							  jQuery(this).removeClass("border-danger");
						  });
				  });
				  jQuery('.modalform').unblock();
				  }
			  }
		  });
	});
  
	  jQuery('body').on('click touchstart', '.closemodal', function(ev) {
	  jQuery.unblockUI();
	  });
  
	  if(typeof notify.theme != 'undefined'){
		  iziToast.show(notify);
	  }
  });
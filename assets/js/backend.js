/* ------------------------------------------------------------------------------
 *
 *  # Custom JS code
 *
 *  Place here all your custom js. Make sure it's loaded after app.js
 *
 * ---------------------------------------------------------------------------- */
var pw_feedback = [
    {color: '#D55757', text: 'Weak', textColor: '#fff'},
    {color: '#EB7F5E', text: 'Normal', textColor: '#fff'},
    {color: '#3BA4CE', text: 'Good', textColor: '#fff'},
    {color: '#40B381', text: 'Strong', textColor: '#fff'}
];
MapPinIconImage = 'data:image/svg+xml;base64,PHN2ZyBoZWlnaHQ9JzMwMHB4JyB3aWR0aD0nMzAwcHgnICBmaWxsPSIjRTY3NzAwIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2ZXJzaW9uPSIxLjEiIHg9IjBweCIgeT0iMHB4IiB2aWV3Qm94PSIwIDAgNTAwIDUwMCIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwIDAgNTAwIDUwMCIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+PGc+PHBhdGggZD0iTTMzMS45LDc5LjVjLTQ5LjEtMzguNC0xMTguNC0zNy40LTE2Ni4zLDIuNWwtMC44LDAuNmMtNDkuMiw0MS02MiwxMTEuNC0zMC4zLDE2Ny4xbDExMy4yLDE5OC45TDM2NC4zLDI1MSAgIGMxMi40LTIxLDE4LjQtNDQuMiwxOC40LTY3LjJDMzgyLjcsMTQ0LjMsMzY1LDEwNS40LDMzMS45LDc5LjV6IE0yNTAsMjIxLjNjLTI5LjQsMC01My4zLTIzLjktNTMuMy01My4zICAgYzAtMjkuNCwyMy45LTUzLjMsNTMuMy01My4zczUzLjMsMjMuOSw1My4zLDUzLjNDMzAzLjMsMTk3LjQsMjc5LjQsMjIxLjMsMjUwLDIyMS4zeiI+PC9wYXRoPjxnPjxwYXRoIGQ9Ik0zMzksNzIuNWMtMjQuNS0xOC45LTUzLjctMzAuMS04NC44LTMxYy0zMC4zLTAuOS02MSw4LjMtODUuNywyNS44Yy00OCwzNC4yLTcxLjUsOTQuNi01Ni45LDE1Mi4xICAgIGM2LjUsMjUuNiwyMS43LDQ4LjQsMzQuNiw3MS4yYzE4LjQsMzIuMywzNi44LDY0LjYsNTUuMiw5Ni45YzEyLjMsMjEuNywyNC4xLDQzLjksMzcuMSw2NS4yYzAuMiwwLjMsMC40LDAuNywwLjYsMSAgICBjMy43LDYuNiwxMy41LDYuNCwxNy4zLDBjMjEuMi0zNiw0Mi40LTcxLjksNjMuNi0xMDcuOWMxMy40LTIyLjcsMjYuOC00NS40LDQwLjItNjguMmMxMC41LTE3LjgsMjEuNC0zNS4xLDI3LjEtNTUuMiAgICBDNDAyLjgsMTY4LDM4My4zLDEwNy42LDMzOSw3Mi41Yy00LjItMy40LTEwLTQuMS0xNC4xLDBjLTMuNSwzLjUtNC4zLDEwLjgsMCwxNC4xYzM2LjQsMjguOSw1NS4xLDc2LjEsNDUuMywxMjIuMSAgICBjLTQuNSwyMC45LTE1LDM4LjItMjUuNiw1Ni4yYy0yNy4yLDQ2LjEtNTQuMyw5Mi4xLTgxLjUsMTM4LjJjLTgsMTMuNS0xNS45LDI3LTIzLjksNDAuNmM1LjgsMCwxMS41LDAsMTcuMywwICAgIGMtOS43LTE3LTE5LjQtMzQtMjktNTFjLTE4LjEtMzEuNy0zNi4xLTYzLjUtNTQuMi05NS4yYy0xMC0xNy41LTIwLTM1LTI5LjktNTIuNmMtMjUuNi00NS41LTE5LjYtMTA0LjIsMTUuOS0xNDIuOCAgICBjMzcuNS00MC44LDk5LjEtNTIuNywxNDguNC0yNi4zYzYsMy4yLDExLjksNi44LDE3LjMsMTFjNC4zLDMuMywxMCw0LjIsMTQuMSwwQzM0Mi40LDgzLjIsMzQzLjMsNzUuOCwzMzksNzIuNXoiPjwvcGF0aD48cGF0aCBkPSJNMjUwLDIxMS4zYy0xNy45LTAuMi0zNC44LTExLjQtNDAuOC0yOC42Yy02LTE3LjQtMC44LTM2LjcsMTMuNS00OC40YzE0LTExLjUsMzQuMy0xMi42LDQ5LjctMy40ICAgIGMxNS4yLDkuMiwyMy44LDI3LjcsMjAuMSw0NS4zQzI4OC4zLDE5Ni42LDI3MC43LDIxMSwyNTAsMjExLjNjLTEyLjksMC4yLTEyLjksMjAuMiwwLDIwYzI2LjgtMC4zLDUwLjMtMTcsNTkuNi00MiAgICBjOS0yNC4yLDEuMS01My0xOC43LTY5LjVjLTIwLjUtMTcuMS01MC4zLTIwLTczLjQtNi4xYy0yMi45LDEzLjgtMzQuMyw0MC40LTI5LjYsNjYuNWM1LjQsMjkuNiwzMi41LDUwLjcsNjIuMSw1MSAgICBDMjYyLjksMjMxLjQsMjYyLjksMjExLjQsMjUwLDIxMS4zeiI+PC9wYXRoPjwvZz48L2c+PC9zdmc+';

function changeMenuByResolution() {
	if(window.innerWidth < 1400){
		document.body.classList.add("sidebar-xs");
	}
}
window.onresize = changeMenuByResolution;
window.onload = changeMenuByResolution;
jQuery(document).ready(function() {

  if(jQuery(window).width() > 992) {
  	jQuery('body').removeClass('sidebar-xs');
  }else{
  	jQuery('body').addClass('sidebar-xs');
  }

  jQuery('.format-phone-number').formatter({
      pattern: '{{999}}-{{999}}-{{9999}}'
  });



	jQuery( "form.ajaxform" ).validate({
		ignore: ".ignore, :hidden, .returnbackbutton",
		submitHandler: function(form, event) {
		  event.preventDefault();
	  	jQuery(form).find('.sendajaxform').addClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !0);
			jQuery(form).ajaxSubmit({
			  url: cortiamajax.formajaxurl,
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
								confirmButtonClass: "btn btn-secondary"
							});
				  	}
			  	}
			  	if(i.fail){
			  		jQuery(form).find('.sendajaxform').removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1);
						swal.fire({
							background: "#fff",
							title: i.fail_title,
							text: i.fail_message,
							type: "error",
							confirmButtonClass: "btn btn-secondary"
						});
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


	jQuery('body').on( "click", '.deleterecordbutton', function(ev) {
		ev.preventDefault();
		record_id = jQuery(this).data('record');
		jQuery('#record-' + record_id).addClass('table-danger');
		swal.fire({
	    title: "Are you sure?",
	    text: "Selected database record will be deleted and you won't be able to revert this action!",
	    type: "question",
	    showCancelButton: !0,
	    cancelButtonText: '<b><i class="icon-cross2"></i></b> Cancel',
			cancelButtonClass: "btn bg-danger btn-labeled btn-labeled-left rounded-round float-left",
	    confirmButtonText: '<b><i class="icon-checkmark3"></i></b> Proceed',
			confirmButtonClass: "btn bg-teal-400 btn-labeled btn-labeled-left rounded-round float-right"
		}).then(function(e) {
			if(e.value){
				jQuery.ajax({
				  url: cortiamajax.deleteajaxurl,
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
			}else{
				jQuery('#record-' + record_id).removeClass('table-danger');
			}
		});
	});

	jQuery('body').on( "click", '.acenableaccount', function(ev) {
		ev.preventDefault();
		record_id = jQuery(this).data('record');
		jQuery('#record-' + record_id).addClass('table-danger');
		swal.fire({
	    title: "Enable Account",
	    text: "Selected account will be enable, are you sure want to enable this account?",
	    type: "question",
	    showCancelButton: !0,
	    cancelButtonText: '<b><i class="icon-cross2"></i></b> Cancel',
			cancelButtonClass: "btn bg-danger btn-labeled btn-labeled-left rounded-round float-left",
	    confirmButtonText: '<b><i class="icon-checkmark3"></i></b> Proceed',
			confirmButtonClass: "btn bg-teal-400 btn-labeled btn-labeled-left rounded-round float-right"
		}).then(function(e) {
			if(e.value){
				jQuery.ajax({
				  url: cortiamajax.acenableajaxurl,
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
								ourdatatable.ajax.reload();
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
			}else{
				jQuery('#record-' + record_id).removeClass('table-danger');
			}
		});
	});

	jQuery('body').on( "click", '.acdisableaccount', function(ev) {
		ev.preventDefault();
		record_id = jQuery(this).data('record');
		jQuery('#record-' + record_id).addClass('table-danger');
		swal.fire({
	    title: "Disable Account",
	    text: "Selected account will be disabled, are you sure want to disable this account?",
	    type: "question",
	    showCancelButton: !0,
	    cancelButtonText: '<b><i class="icon-cross2"></i></b> Cancel',
			cancelButtonClass: "btn bg-danger btn-labeled btn-labeled-left rounded-round float-left",
	    confirmButtonText: '<b><i class="icon-checkmark3"></i></b> Proceed',
			confirmButtonClass: "btn bg-teal-400 btn-labeled btn-labeled-left rounded-round float-right"
		}).then(function(e) {
			if(e.value){
				jQuery.ajax({
				  url: cortiamajax.acdisableeajaxurl,
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
								ourdatatable.ajax.reload();
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
			}else{
				jQuery('#record-' + record_id).removeClass('table-danger');
			}
		});
	});

	jQuery('body').on( "click", '.getlocation', function(ev) {
		ev.preventDefault();
		var targetmap = jQuery(this).data('map');
		jQuery("form.ajaxform").ajaxSubmit({
		  url: cortiamajax.getlocationajaxurl,
		  type: "POST",
		  dataType: "json",
		  success: function(i, s, r, a) {
		  	if(i.success){
		  		var new_lat = i.latitude;
		  		var new_lan = i.longitude;
					var map = new Microsoft.Maps.Map(document.getElementById(targetmap), {});

					map.entities.push(Microsoft.Maps.TestDataGenerator.getPushpins(10, map.getBounds()));
			    for (var i = map.entities.getLength() - 1; i >= 0; i--) {
			        var pushpin = map.entities.get(i);
			        if (pushpin instanceof Microsoft.Maps.Pushpin) {
			            map.entities.removeAt(i);
			        }
			    }

	        map.setView({
	            mapTypeId: Microsoft.Maps.MapTypeId.canvasLight,
	            center: new Microsoft.Maps.Location(new_lat, new_lan),
	            zoom: 16
	        });

				  var pin = new Microsoft.Maps.Pushpin(map.getCenter(), {
				      icon: MapPinIconImage,
				      iconSize: { width: 40, height: 40 }
				  });

				  map.entities.push(pin);
		  	}
		  	if(i.fail){
					swal.fire({
						title: i.fail_title,
						text: i.fail_message,
						type: "error",
						confirmButtonClass: "btn btn-secondary"
					});
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
	});

	jQuery('body').on( "click", '#clearallnotifications', function(ev) {
		ev.preventDefault();
		jQuery.ajax({
		  url: mainfunc.clearnotification_url,
		  type: "POST",
		  data: {'recordID' : mainfunc.notify_id},
		  dataType: "json",
		  success: function(i, s, r, a) {
		  	if(i.success){
					jQuery('#notification_listing').html('<li class="text-center">No new notification<li>');
					jQuery('#notification_listing_amount').html('0');
		  	}
		  }
		});
	});


	jQuery('.returnbackbutton').on( "click", function(ev) {
		ev.preventDefault();
		history.go(-1);
	});

	if(typeof notify.type != 'undefined'){
		new PNotify({
			addclass: notify.addclass,
			title: notify.title,
			text: notify.text,
			type: notify.type,
		});
	}

});
//jQuery(window).on('resize', function() {
//  if(jQuery(window).width() > 992) {
//  	jQuery('body').removeClass('sidebar-xs');
//  }else{
//  	jQuery('body').addClass('sidebar-xs');
//  }
//})
jQuery(document).ready(function() {
  jQuery('.editor').summernote();

  jQuery('body').on('click', '#updatetutorial', function () {
		jQuery.ajax({
			type: "post",
			url: cortiamajax.formajaxurl,
		  data: {'content' : jQuery('.editor').summernote('code')},
			dataType: "json",
			beforeSend: function() {
				jQuery('#tutorialwrap').block({message: '<img src="' + cortiamajax.loadingimage + '">',css: {border:'0px',width:'100%',top:'0px' , background:'transparent'},overlayCSS: {backgroundColor:'#ffffff',opacity:.8, 'z-index':'1000000'}});
			},
			success: function(response){
				jQuery('#tutorialwrap').unblock();
				if(response.success){
					new PNotify({
						addclass: 'alert  alert-styled-left',
						title: response.success_title,
						text: response.success_message,
						type: 'success',
					});
				}else{
					new PNotify({
						addclass: 'alert  alert-styled-left',
						title: response.fail_title,
						text: response.fail_message,
						type: 'error',
					});
				}
			}
		});
	});

});
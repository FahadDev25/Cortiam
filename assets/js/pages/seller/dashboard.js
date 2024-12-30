jQuery(document).ready(function() {
  jQuery('#bio').trumbowyg({
      btns: [
          // ['formatting'],
          ['strong', 'em'],
          ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
          ['unorderedList', 'orderedList'],
          ['undo', 'redo'], // Only supported in Blink browsers
          ['insertImage', 'link'],
          ['viewHTML'],
          ['fullscreen']
      ]
  });

  jQuery('.select').select2({
  	minimumResultsForSearch: Infinity,
  });

  jQuery('#state').autocomplete({
  	source: _states_,
    select: function( event, ui ) {
		  jQuery('#city').autocomplete({
		  	source: _cities_[ui.item.value]
		  });
   	}
  });

  jQuery('#city').autocomplete({
  	source: _cities_[''+jQuery('#state').val()+'']
  });

  jQuery('#brokerage_state').autocomplete({
  	source: _states_,
    select: function( event, ui ) {
		  jQuery('#brokerage_city').autocomplete({
		  	source: _cities_[ui.item.value]
		  });
   	}
  });

  jQuery('#brokerage_city').autocomplete({
  	source: _cities_[''+jQuery('#brokerage_state').val()+'']
  });

  jQuery('#license_states').autocomplete({
  	source: _states_
  });

  jQuery('.carousel').each(function(key, carousel) {
  	if(jQuery(carousel).find('.proplisting').length >= 3){
			jQuery(carousel).slick({
			  dots: false,
			  infinite: false,
			  speed: 300,
			  slidesToShow: 3,
			  slidesToScroll: 1,
			  responsive: [
			    {
			      breakpoint: 600,
			      settings: {
			        slidesToShow: 2,
			        slidesToScroll: 1
			      }
			    },
			    {
			      breakpoint: 480,
			      settings: {
			        slidesToShow: 1,
			        slidesToScroll: 1
			      }
			    }
			  ]
			});
  	}
  });

	jQuery('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		if(jQuery(jQuery(e.target).attr('href') + ' .carousel').length){
			jQuery(jQuery(e.target).attr('href') + ' .carousel').slick('refresh');
		}
	})


	jQuery('body').on( "click", '.favmebutton', function(ev) {
		ev.preventDefault();
  	favbutton = jQuery(this);
  	favbutton_value = jQuery(favbutton).data('type');
  	agent_id = jQuery(favbutton).data('agent');
		jQuery.ajax({
			type: "post",
			url: cortiamajax.favoriteurl,
		  data: {'agent_id' : agent_id, 'value' : favbutton_value, 'bigger' : true},
			dataType: "json",
			beforeSend: function() {
				jQuery.blockUI({message: '<div class="emptyloader"><img src="' + cortiamajax.loadingimage + '"></div>',css: {border:'0px',width:'100%',top:'10%',left:'0%',background:'transparent', cursor:'context-menu'},overlayCSS: {backgroundColor:'#000000',opacity:.7}});
			},
			success: function(response){
				if(response.buttonicon){
					jQuery(favbutton).html(response.buttonicon);
				}
				if(response.buttonvalue){
					jQuery(favbutton).data('type', response.buttonvalue);
				}
		  	if(response.success){
					swal.fire({
						title: response.success_title,
						text: response.success_message,
						type: "success",
						confirmButtonClass: "button-success"
					});
		  	}
		  	if(response.removeagent){
		  		jQuery('#nav-fa .carousel #' + response.removeagent).remove();
			  	if(jQuery('#nofavtext').length < 1){
			  		jQuery('#nav-fa .carousel').append('<h4 class="p-5 text-center" id="nofavtext">You have no favorite agent at this moment.</h4>');
			  	}
		  	}
		  	if(response.addagent){
			  	if(jQuery('#nofavtext').length > 0){
			  		jQuery('#nofavtext').remove();
			  	}
		  		jQuery('#nav-fa .carousel').append(response.addagent);
		  	}
				if(response.fail){
					swal.fire({
						title: response.fail_title,
						text: response.fail_message,
						type: "error",
						confirmButtonClass: "button-orange"
					});
				}
				jQuery.unblockUI();
			}
		});
	});

});

jQuery(document).ready(function() {

  jQuery('#state').select2({
		data: _states_,
	  placeholder: 'Select a State',
	  allowClear: true
  });

	jQuery('#state').on('select2:select', function (e) {
	  var selected_state = e.params.data;
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

	jQuery('body').on( 'click', '#searchagent', function(ev) {
		ev.preventDefault();
		jQuery.ajax({
		  url: cortiamajax.formajaxurl,
		  type: "POST",
      data: jQuery('.search-form').serialize(),
		  dataType: "json",
      beforeSend: function() {
				jQuery('.findagent-list').block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.7}});
      },
		  success: function(i, s, r, a) {
		  	if(i.success){
					jQuery('#findagenthtml').html(i.html);
		  	}
		  	if(i.fail){
					swal.fire({
						title: i.fail_title,
						text: i.fail_message,
						type: "error",
						confirmButtonClass: "button-orange"
					});
		  	}
		  	jQuery('.findagent-list').unblock();
		  }
		});
	});

	jQuery("#zipcode").keypress(function(e) {
	    if(e.which == 13) {
				jQuery.ajax({
				  url: cortiamajax.formajaxurl,
				  type: "POST",
		      data: jQuery('.search-form').serialize(),
				  dataType: "json",
		      beforeSend: function() {
						jQuery('.findagent-list').block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.7}});
		      },
				  success: function(i, s, r, a) {
				  	if(i.success){
							jQuery('#findagenthtml').html(i.html);
				  	}
				  	if(i.fail){
							swal.fire({
								title: i.fail_title,
								text: i.fail_message,
								type: "error",
								confirmButtonClass: "button-orange"
							});
				  	}
				  	jQuery('.findagent-list').unblock();
				  }
				});
	    }
	});

});
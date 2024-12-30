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

	jQuery('.trgswitches').on( "click", function(ev) {
		ev.preventDefault();
		var extra_class = jQuery(this).data('type');
		jQuery('.form-check-input-switchery.'+extra_class).trigger('click');
	});

  jQuery('#password').passy(function(strength) {
	  jQuery('#password_indicator').text(pw_feedback[strength].text);
	  jQuery('#password_indicator').css({'background-color': pw_feedback[strength].color, 'border-color': pw_feedback[strength].color, 'color': pw_feedback[strength].textColor});
  });

  jQuery('#passwordagain').blur(function() {
    if(jQuery('#passwordagain').val().length == 0){
      jQuery('#passwordagain_indicator').text('No Password').css({'background-color': '', 'border-color': '', 'color': ''});
    }else if (jQuery('#password').val() != jQuery('#passwordagain').val()) {
      jQuery('#passwordagain_indicator').text('Not Match').css({'background-color': '#D55757', 'border-color': '#D55757', 'color': '#ffffff'});
    }else {
      jQuery('#passwordagain_indicator').text('Match').css({'background-color': '#40B381', 'border-color': '#40B381', 'color': '#ffffff'});
    }
  });

	var switchelems = Array.prototype.slice.call(document.querySelectorAll('.form-check-input-switchery'));

	switchelems.forEach(function(html) {
	  var switchery = new Switchery(html);
	});

});


jQuery(document).ready(function() {
	jQuery('.form-check-input-switchery').bootstrapSwitch();

jQuery('.form-check-input-switchery').on('switchChange.bootstrapSwitch', function(event, state) {
	current_switch = '#state-' + jQuery(this).data('id');
	if(state){
		jQuery(current_switch).prop('readonly', false);
	}else{
		jQuery(current_switch).prop('readonly', true);
	}
});

});

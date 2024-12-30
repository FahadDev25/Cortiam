jQuery(document).ready(function() {
  jQuery('.maxlength-textarea').maxlength({
      alwaysShow: true,
  });

	jQuery('#type_append').html(jQuery('#coupon_type').find(':selected').data('append'));
	jQuery('#type_prepend').html(jQuery('#coupon_type').find(':selected').data('prepend'));

	jQuery('#coupon_type').select2({
  	minimumResultsForSearch: Infinity,
  }).on('select2:select', function (e) {
  	jQuery('#type_append').html(jQuery(e.params.data.element).data('append'));
  	jQuery('#type_prepend').html(jQuery(e.params.data.element).data('prepend'));
	});

	jQuery('#coupon_code').alphanum({
	  allowSpace: false,
	  allowNewline: false,
	  allowOtherCharSets: false,
	});

  jQuery('#couponrange').daterangepicker({
      applyClass: 'btn-primary',
      cancelClass: 'btn-light',
      ranges: {
          'Today': [moment(), moment()],
          'Tomorrow': [moment().add(1, 'days'), moment().add(1, 'days')],
          'This Week': [moment().startOf('week'), moment().endOf('week')],
          'Next Week': [moment().add(1, 'week').startOf('week'), moment().add(1, 'week').endOf('week')],
          'This Month': [moment().startOf('month'), moment().endOf('month')],
          'Next Month': [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')],
          'This Year': [moment().startOf('year'), moment().endOf('year')],
      },
      startDate: jQuery('#begin_date').val(),
      endDate: jQuery('#end_date').val(),
      opens: 'left',
  }, function (start, end) {
		jQuery('#couponrange').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
		jQuery('#begin_date').val(start.format('MMMM D, YYYY'));
		jQuery('#end_date').val(end.format('MMMM D, YYYY'));
  });
});
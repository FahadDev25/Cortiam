videoSrc = '';
jQuery(document).ready(function() {
	jQuery('.ytvideo').click(function() {
	    videoSrc = jQuery(this).data( "src" );
	});

	jQuery('#videoModal').on('shown.bs.modal', function (e) {
		jQuery("#video").attr('src', videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0" );
	})

	jQuery('#videoModal').on('hide.bs.modal', function (e) {
    jQuery("#video").attr('src', '');
	})

	jQuery('body').on('click', '#res_menu_icon', function (ev) {
		ev.preventDefault();
		jQuery('#mainnav').toggleClass('mobilemenu');
	});

  jQuery('.format-phone-number').formatter({
      pattern: '{{999}}-{{999}}-{{9999}}'
  });
});
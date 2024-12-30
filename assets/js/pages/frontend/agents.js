AOS.init();
jQuery(document).ready(function() {

  const player = new Plyr('#videoplayer', {
  	"controls" : ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'fullscreen']
	});

	jQuery('#VoiceModal').on('shown.bs.modal', function (e) {
		document.getElementById('silentvideo').pause();
		player.play();
	})

	jQuery('#VoiceModal').on('hide.bs.modal', function (e) {
		document.getElementById('silentvideo').play();
		player.pause();
	})
});
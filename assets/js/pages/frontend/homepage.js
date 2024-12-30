jQuery(document).ready(function() {
  const player = new Plyr('#videoplayer', {
  	"controls" : ['play-large']
	});

	jQuery('#VoiceModal').on('shown.bs.modal', function (e) {
		document.getElementById('silentvideo').pause();
		player.play();
	})

	jQuery('#VoiceModal').on('hide.bs.modal', function (e) {
		document.getElementById('silentvideo').play();
		player.pause();
	})

	jQuery('#AgentAccordion').on('shown.bs.collapse', function(e){
		jQuery(e.target).parent('.card').find(".indicator").html('-');
	}).on('hidden.bs.collapse', function(e){
		jQuery(e.target).parent('.card').find(".indicator").html('+');
	});

});
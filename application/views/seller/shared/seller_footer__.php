		   	</div>
			</div>
		</div>
	</main>

		<!--begin Page Scripts -->
    <?php if (isset($footer_data['js_files'])) { echo "\n\t<script src=\"".implode("\"></script>\n\t<script src=\"",$footer_data['js_files'])."\"></script>\n";}?>
		<!--end Page Scripts -->
	</body>


	<!-- end Body -->
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCywz554GE2hipurlh2Yoc0XRhh7Ut3_3k&libraries=places"></script>

<script>
	var input = document.getElementById('address');
	if(input !== '')
	{
    	google.maps.event.addDomListener(window, 'load', initialize);
	}

	function initialize() { 
  
		var autocomplete = new google.maps.places.Autocomplete(input);  
		autocomplete.addListener('place_changed', function () { 
			var place = autocomplete.getPlace();

		});

	}

</script>
<div id="avatarmodal" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-center">Edit Your Photo</h3>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="image-cropper-container mb-3 photocropwrap">
					<img src="<?php echo base_url('assets/images/backend/placeholder.png');?>" alt="" class="cropper" id="avatar-cropper-image">
				</div>
				<div class="form-group avatar-cropper-toolbar mb-0">
					<div class="btn-group btn-group-justified d-flex rounded orange-bg">
							<button type="button" class="btn bg-orange-700 btn-icon" data-method="setDragMode" data-option="move" title="Move">
								<span class="icon-co-big white move"></span>
							</button>
							<button type="button" class="btn bg-orange-700 btn-icon" data-method="setDragMode" data-option="crop" title="Crop">
								<span class="icon-co-big white crop"></span>
							</button>
							<button type="button" class="btn bg-orange-700 btn-icon" data-method="zoom" data-option="0.1" title="Zoom In">
								<span class="icon-co-big white zoomin"></span>
							</button>
							<button type="button" class="btn bg-orange-700 btn-icon" data-method="zoom" data-option="-0.1" title="Zoom Out">
								<span class="icon-co-big white zoomout"></span>
							</button>
							<button type="button" class="btn bg-orange-700 btn-icon" data-method="rotate" data-option="-45" title="Rotate Left">
								<span class="icon-co-big white rotateleft"></span>
							</button>
							<button type="button" class="btn bg-orange-700 btn-icon" data-method="rotate" data-option="45" title="Rotate Right">
								<span class="icon-co-big white rotateright"></span>
							</button>
							<button type="button" class="btn bg-orange-700 btn-icon" data-method="scaleX" data-option="-1" title="Flip Horizontal">
								<span class="icon-co-big white fliph"></span>
							</button>
							<button type="button" class="btn bg-orange-700 btn-icon" data-method="scaleY" data-option="-1" title="Flip Vertical">
								<span class="icon-co-big white flipv"></span>
							</button>
					</div>
				</div>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="button-danger" data-dismiss="modal">Cancel</button>
				<button type="button" class="button-success" id="dophotocrop">Change</button>
			</div>
		</div>
	</div>
</div>


</html>
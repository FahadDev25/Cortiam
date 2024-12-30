				<!-- Highlighting rows and columns -->
				<div class="card">
					<form method="POST" class="ajaxform">
					<div class="card-header header-elements-inline">
						<h5 class="card-title"><?php echo $header_data['page_title'];?></h5>
						<div class="header-elements">
							<div class="list-icons">
            		<a class="list-icons-item" data-action="collapse"></a>
            	</div>
          	</div>
					</div>
<div class="card-body bg-indigo-400 text-left card-img-top" style="background-image: url(<?php echo base_url('assets/images/backend/panel_bg.png');?>); background-size: contain;">
									<div class="card-img-actions d-inline-block mb-3">
										<div class="previewAvatar" style="border-radius:50%;width:170px;height:170px;overflow:hidden;background:white">
											<img class="img-fluid rounded-circle" src="<?php echo base_url('assets/images/backend/face11.jpg');?>" width="170" height="170" alt="" id="pageavatar">
										</div>
										<div class="card-img-actions-overlay rounded-circle">
											<div tabindex="500" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round btn-file"><i class="icon-file-plus"></i><input type="file" class="file-input" id="uploadtest"></div>

											<a href="user_pages_profile.html" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round ml-2">
												<i class="icon-link"></i>
											</a>
										</div>
									</div>

						    		<h6 class="font-weight-semibold mb-0">Victoria Davidson</h6>
						    		<span class="d-block opacity-75">Head of UX</span>

					    			<div class="list-icons list-icons-extended mt-3">
				                    	<a href="#" class="list-icons-item text-white" data-popup="tooltip" title="" data-container="body" data-original-title="Google Drive"><i class="icon-google-drive"></i></a>
				                    	<a href="#" class="list-icons-item text-white" data-popup="tooltip" title="" data-container="body" data-original-title="Twitter"><i class="icon-twitter"></i></a>
				                    	<a href="#" class="list-icons-item text-white" data-popup="tooltip" title="" data-container="body" data-original-title="Github"><i class="icon-github"></i></a>
			                    	</div>
						    	</div>
					<div class="card-body">
							<div class="row">
								<div class="col-md-6">
									<fieldset>
										<legend class="font-weight-semibold text-orange-700"><i class="icon-reading mr-2"></i> Personal detailaaaaa</legend>

<input type="hidden" name="croppResult">

									</fieldset>
								</div>


								<div class="col-md-6">
									<div id="thumbresult"></div>

								</div>
							</div>

					</div>
					<div class="card-footer bg-white text-right">
						<button type="submit" class="btn btn-primary">Submit <i class="icon-paperplane ml-2"></i></button>
					</div>
					</form>
				</div>
				<!-- /highlighting rows and columns -->

<div id="avatarmodal" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-center">H3 heading title</h3>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="image-cropper-container mb-3">
					<img src="<?php echo base_url('assets/images/backend/placeholder.png');?>" alt="" class="cropper" id="demo-cropper-image">
				</div>
				<div class="form-group avatar-cropper-toolbar mb-0">
					<div class="btn-group btn-group-justified">
						<div class="btn-group">
							<button type="button" class="btn bg-orange-700 btn-icon" data-method="setDragMode" data-option="move" title="Move">
								<span class="icon-move"></span>
							</button>
						</div>
						<div class="btn-group">
							<button type="button" class="btn bg-orange-700 btn-icon" data-method="setDragMode" data-option="crop" title="Crop">
								<span class="icon-crop2"></span>
							</button>
						</div>
						<div class="btn-group">
							<button type="button" class="btn bg-orange-700 btn-icon" data-method="zoom" data-option="0.1" title="Zoom In">
								<span class="icon-zoomin3"></span>
							</button>
						</div>
						<div class="btn-group">
							<button type="button" class="btn bg-orange-700 btn-icon" data-method="zoom" data-option="-0.1" title="Zoom Out">
								<span class="icon-zoomout3"></span>
							</button>
						</div>
						<div class="btn-group">
							<button type="button" class="btn bg-orange-700 btn-icon" data-method="rotate" data-option="-45" title="Rotate Left">
								<span class="icon-rotate-ccw3"></span>
							</button>
						</div>
						<div class="btn-group">
							<button type="button" class="btn bg-orange-700 btn-icon" data-method="rotate" data-option="45" title="Rotate Right">
								<span class="icon-rotate-cw3"></span>
							</button>
						</div>
						<div class="btn-group">
							<button type="button" class="btn bg-orange-700 btn-icon" data-method="scaleX" data-option="-1" title="Flip Horizontal">
								<span class="icon-flip-vertical4"></span>
							</button>
						</div>
						<div class="btn-group">
							<button type="button" class="btn bg-orange-700 btn-icon" data-method="scaleY" data-option="-1" title="Flip Vertical">
								<span class="icon-flip-vertical3"></span>
							</button>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn bg-danger btn-labeled btn-labeled-left rounded-round" data-dismiss="modal"><b><i class="icon-cross2"></i></b> Cancel</button>
				<button type="button" class="btn bg-teal-400 btn-labeled btn-labeled-left rounded-round" id="getmydata"><b><i class="icon-checkmark3"></i></b> Proceed</button>
			</div>
		</div>
	</div>
</div>
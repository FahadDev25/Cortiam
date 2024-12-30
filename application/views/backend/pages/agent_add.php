				<!-- Inner container -->
				<div class="d-xl-flex align-items-md-start" id="changeforlowres">

					<!-- Left sidebar component -->
					<div class="sidebar sidebar-light bg-transparent sidebar-component sidebar-component-left wmin-300 border-0 shadow-0 sidebar-expand-md">

						<!-- Sidebar content -->
						<div class="sidebar-content">

							<!-- Navigation -->
							<div class="card">
								<div class="card-body bg-orange-800 text-center card-img-top" style="background-image: url(<?php echo base_url('assets/images/backend/panel_bg.png');?>); background-size: contain;">
									<div class="card-img-actions d-inline-block mb-3">
										<div class="previewAvatar border-2" style="border-radius:50%;width:170px;height:170px;overflow:hidden;background:white">
											<img class="img-fluid rounded-circle" src="<?php echo (($agent['avatar_string'])? base_url($agent['avatar_string']):base_url('assets/images/backend/userphoto.jpg'));?>" width="170" height="170" alt="" id="pageavatar">
										</div>
										<div class="card-img-actions-overlay rounded-circle">
											<div tabindex="500" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round btn-file"  data-popup="tooltip" title="Change Profile Photo" data-placement="top"><i class="icon-compose"></i><input type="file" class="file-input" id="avatarupload"></div>
										</div>
									</div>

						    		<h6 class="font-weight-semibold mb-0">Add New</h6>
						    		<span class="d-block opacity-75">Agent Account</span>

					    			<div class="list-icons list-icons-extended mt-2">
                  	</div>
						    	</div>

								<div class="card-body p-0">
									<ul class="nav nav-sidebar mb-2">
										<li class="nav-item-header">Navigation</li>
										<li class="nav-item">
											<a href="#tdetails" class="nav-link active" data-toggle="tab"><i class="icon-magazine"></i> General Details</a>
										</li>
										<li class="nav-item">
											<a href="#tmedia" class="nav-link" data-toggle="tab"><i class="icon-presentation"></i> Media & Biography</a>
										</li>
										<li class="nav-item">
											<a href="#tbusiness" class="nav-link" data-toggle="tab"><i class="icon-vcard"></i> Business & License Info</a>
										</li>
									</ul>
								</div>
							</div>

						</div>
						<!-- /sidebar content -->

					</div>
					<!-- /left sidebar component -->


					<!-- Right content -->
					<form method="POST" class="ajaxform w-100">
					<div class="tab-content w-100">
						<div class="tab-pane fade active show" id="tdetails">

							<div class="card">
								<div class="card-header bg-transparent header-elements-inline">
									<h6 class="card-title">General Details</h6>
								</div>

								<div class="card-body">
									<div class="row">
										<div class="col-xl-6">
											<fieldset>
												<legend class="font-weight-semibold text-grey-400"><i class="icon-reading mr-2"></i> Personal details</legend>

												<div class="form-group">
													<label>First Name:</label>
													<input type="text" class="form-control" name="first_name" id="first_name">
												</div>

												<div class="form-group">
													<label>Last Name:</label>
													<input type="text" class="form-control" name="last_name" id="last_name">
												</div>

												<div class="form-group">
													<label>Phone Number:</label>
													<input type="tel" class="form-control format-phone-number" name="phone" id="phone">
												</div>

												<div class="form-group">
													<label>Email Address:</label>
													<input type="email" class="form-control" name="email" id="email">
												</div>

											</fieldset>
										</div>
										<div class="col-xl-6">
											<fieldset>
												<legend class="font-weight-semibold text-grey-400"><i class="icon-location4 mr-2"></i> Location details</legend>

												<div class="row">
													<div class="col-xl-9">
														<div class="form-group">
															<label>Address line:</label>
															<input type="text" name="address" id="address" class="form-control setmap">
														</div>
													</div>

													<div class="col-xl-3">
														<div class="form-group">
															<label>Unit:</label>
															<input type="text" name="unit" id="unit" class="form-control">
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-xl-4">
														<div class="form-group">
															<label>State:</label>
															<input type="text" name="state" id="state" class="form-control">
														</div>
													</div>

													<div class="col-xl-5">
														<div class="form-group">
															<label>City:</label>
															<input type="text" name="city" id="city" class="form-control">
														</div>
													</div>

													<div class="col-xl-3">
														<div class="form-group">
															<label>Zip Code:</label>
															<input type="text" name="zipcode" id="zipcode" class="form-control">
														</div>
													</div>
												</div>
											</fieldset>
											<fieldset>
												<legend class="font-weight-semibold text-grey-400"><i class="icon-keyboard mr-2"></i> Password details</legend>
												<div class="form-group">
													<label>Password:</label>
													<div class="input-group group-indicator">
														<input type="text" class="form-control" name="password" id="password" placeholder="Enter your password">
														<span class="input-group-append">
															<span class="input-group-text" id="password_indicator">No password</span>
														</span>
													</div>
												</div>
												<div class="form-group">
													<label>Password (Again):</label>
													<div class="input-group group-indicator">
														<input type="text" class="form-control" name="passwordagain" id="passwordagain" placeholder="Enter your password">
														<span class="input-group-append">
															<span class="input-group-text" id="passwordagain_indicator">No password</span>
														</span>
													</div>
												</div>
											</fieldset>
										</div>
									</div>
								</div>
								<div class="card-footer bg-white text-right">
									<button type="submit" class="btn btn-primary">Submit <i class="icon-paperplane ml-2"></i></button>
								</div>
							</div>

						</div>
						<div class="tab-pane fade" id="tmedia">

							<div class="card">
								<div class="card-header bg-transparent header-elements-inline">
									<h6 class="card-title">Media & Biography</h6>
								</div>

								<div class="card-body">
										<div class="row">
											<div class="col-xl-6">
												<fieldset>
													<legend class="font-weight-semibold text-grey-400"><i class="icon-screen3 mr-2"></i> Social Media</legend>

													<div class="form-group">
														<label>Facebook:</label>
														<input type="text" name="facebook" id="facebook" class="form-control">
													</div>

													<div class="form-group">
														<label>LinkedIn:</label>
														<input type="text" name="linkedin" id="linkedin" class="form-control">
													</div>

													<div class="form-group">
														<label>Twitter:</label>
														<input type="text" name="twitter" id="twitter" class="form-control">
													</div>

													<div class="form-group">
														<label>Google:</label>
														<input type="text" name="google" id="google" class="form-control">
													</div>

													<div class="form-group">
														<label>Instagram:</label>
														<input type="text" name="instagram" id="instagram" class="form-control">
													</div>

													<div class="form-group">
														<label>YouTube Video URL:</label>
														<input type="text" name="youtube_video" id="youtube_video" class="form-control">
													</div>

												</fieldset>
											</div>
											<div class="col-xl-6">
												<fieldset>
													<legend class="font-weight-semibold text-grey-400"><i class="icon-quill4 mr-2"></i> Biography</legend>
													<div id="bio"></div>
												</fieldset>
											</div>
										</div>

								</div>
								<div class="card-footer bg-white text-right">
									<button type="submit" class="btn btn-primary">Submit <i class="icon-paperplane ml-2"></i></button>
								</div>
							</div>

						</div>
						<div class="tab-pane fade" id="tbusiness">

							<div class="card">
								<div class="card-header bg-transparent header-elements-inline">
									<h6 class="card-title">Business & License Info</h6>
								</div>

								<div class="card-body">
									<div class="row">
										<div class="col-xl-5">
											<fieldset>
												<legend class="font-weight-semibold text-grey-400"><i class="icon-office mr-2"></i> Brokerage Info</legend>

												<div class="form-group">
													<label>Company Name:</label>
													<input type="text" name="brokerage_name" id="brokerage_name" class="form-control">
												</div>

												<div class="row">
													<div class="col-xl-9">
														<div class="form-group">
															<label>Address:</label>
															<input type="text" name="brokerage_address" id="brokerage_address" class="form-control">
														</div>
													</div>

													<div class="col-xl-3">
														<div class="form-group">
															<label>Unit:</label>
															<input type="text" name="brokerage_unit" id="brokerage_unit" class="form-control">
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-xl-4">
														<div class="form-group">
															<label>State:</label>
															<input type="text" name="brokerage_state" id="brokerage_state" class="form-control">
														</div>
													</div>

													<div class="col-xl-5">
														<div class="form-group">
															<label>City:</label>
															<input type="text" name="brokerage_city" id="brokerage_city" class="form-control">
														</div>
													</div>

													<div class="col-xl-3">
														<div class="form-group">
															<label>Zip Code:</label>
															<input type="text" name="brokerage_zipcode" id="brokerage_zipcode" class="form-control">
														</div>
													</div>

												</div>
												<div class="form-group">
													<label>Phone Number:</label>
													<input type="text" name="brokerage_phone" id="brokerage_phone" class="form-control format-phone-number">
												</div>

											</fieldset>
											<fieldset>
												<legend class="font-weight-semibold text-grey-400"><i class="icon-vcard mr-2"></i> Real Estate License Info</legend>
												<div class="row">
													<div class="col-xl-6">
														<div class="form-group">
															<label>License Number:</label>
															<input type="text" name="license_number" id="license_number" class="form-control">
														</div>
													</div>
													<div class="col-xl-6">
														<div class="form-group">
															<label>License Expiration Date:</label>
															<input type="text" name="license_expires" id="license_expires" class="form-control">
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-xl-6">
														<div class="form-group">
															<label>State Licensed:</label>
															<input type="text" name="license_states" id="license_states" class="form-control">
														</div>
													</div>
													<div class="col-xl-6">
														<div class="form-group">
															<label>Real Estate Focus:</label>
															<select class="form-control select" name="interested" id="interested">
																<option value="">Please select an option</option>
																<option value="Residential" <?php echo (($agent['interested'] == 'Residential')? 'selected':'');?>>Residential</option>
																<option value="Commercial" <?php echo (($agent['interested'] == 'Commercial')? 'selected':'');?>>Commercial</option>
																<option value="Both" <?php echo (($agent['interested'] == 'Both')? 'selected':'');?>>Both</option>
															</select>
														</div>
													</div>
												</div>
											</fieldset>
										</div>
										<div class="col-xl-7">
											<fieldset>
												<legend class="font-weight-semibold text-grey-400"><i class="icon-calendar mr-2"></i>Real Estate Experience</legend>
												<div class="form-group">
													<label>First Year Licensed:</label>
													<input type="number" name="experience" id="experience" class="form-control" placeholder="First Year Licensed">
												</div>
											</fieldset>
											<fieldset>
												<legend class="font-weight-semibold text-grey-400"><i class="icon-quill4 mr-2"></i>Real Estate Specialization</legend>
												<div id="estate_specialization"><?php echo $agent['estate_specialization'];?></div>
											</fieldset>
										</div>
									</div>
								</div>

								<div class="card-footer bg-white text-right">
									<input type="hidden" name="avatar_string" value="">
									<button type="submit" class="btn btn-primary">Submit <i class="icon-paperplane ml-2"></i></button>
								</div>

							</div>

						</div>
					</div>
					<!-- /right content -->
					</form>
				</div>
				<!-- /inner container -->

<div id="avatarmodal" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-center">Edit Your Photo</h3>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="image-cropper-container mb-3">
					<img src="<?php echo base_url('assets/images/backend/placeholder.png');?>" alt="" class="cropper" id="avatar-cropper-image">
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
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
											<div tabindex="500" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round btn-file" data-popup="tooltip" title="Change Profile Photo" data-placement="top"><i class="icon-compose"></i><input type="file" class="file-input" id="avatarupload"></div>
											<div data-profile="<?php echo $agent['agent_id'];?>" class="deleteprofileimg btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round ml-1 <?php echo ((!$agent['avatar_string'])? 'd-none':'');?>" data-popup="tooltip" title="Remove Profile Photo"><i class="icon-trash"></i></div>
										</div>
									</div>

						    		<h6 class="font-weight-semibold mb-0"><?php echo $agent['first_name'];?> <?php echo $agent['last_name'];?></h6>
						    		<span class="d-block opacity-75"><?php echo $agent['city'].', '.$agent['state'];?><br>Created on <?php echo date("Y-m-d \a\\t h:i:s A",$agent['created_on']);?></span>

					    			<div class="list-icons list-icons-extended mt-2">
	                  	<?php if($agent['email']){?><a href="mailto:<?php echo $agent['email'];?>" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round btn-file btn-sm" data-popup="tooltip" title="Send Email" data-placement="top"><i class="icon-envelop3"></i></a><?php }?>
	                  	<?php if($agent['phone']){?><a href="tel:<?php echo preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1-$2-$3', $agent['phone']);?>" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round btn-file btn-sm" data-popup="tooltip" title="Call Now" data-container="top"><i class="icon-phone"></i></a><?php }?>
                  	</div>
                  	<div class="clear"></div>
					    			<div class="list-icons list-icons-extended mt-2">
	                  	<?php if($agent['facebook']){?><a href="//<?php echo $agent['facebook'];?>" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round btn-file btn-sm" data-popup="tooltip" target="_blank" title="Facebook" data-container="top"><i class="icon-facebook"></i></a><?php }?>
	                  	<?php if($agent['linkedin']){?><a href="//<?php echo $agent['linkedin'];?>" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round btn-file btn-sm" data-popup="tooltip" target="_blank" title="LinkedIn" data-container="top"><i class="icon-linkedin2"></i></a><?php }?>
	                  	<?php if($agent['twitter']){?><a href="//<?php echo $agent['twitter'];?>" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round btn-file btn-sm" data-popup="tooltip" target="_blank" title="Twitter" data-container="top"><i class="icon-twitter"></i></a><?php }?>
	                  	<?php if($agent['google']){?><a href="//<?php echo $agent['google'];?>" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round btn-file btn-sm" data-popup="tooltip" target="_blank" title="Google" data-container="top"><i class="icon-google-plus"></i></a><?php }?>
	                  	<?php if($agent['instagram']){?><a href="//<?php echo $agent['instagram'];?>" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round btn-file btn-sm" data-popup="tooltip" target="_blank" title="Instagram" data-container="top"><i class="icon-instagram"></i></a><?php }?>
                  	</div>
						    	</div>

								<div class="card-body p-0">
									<ul class="nav nav-sidebar mb-2">
										<li class="nav-item-header">Navigation</li>
										<li class="nav-item">
											<a href="#tdetails" class="nav-link" data-toggle="tab"><i class="icon-magazine"></i> General Details</a>
										</li>
										<li class="nav-item">
											<a href="#tmedia" class="nav-link" data-toggle="tab"><i class="icon-presentation"></i> Media & Biography</a>
										</li>
										<li class="nav-item">
											<a href="#tbusiness" class="nav-link" data-toggle="tab"><i class="icon-office"></i> Business Info</a>
										</li>
										<li class="nav-item">
											<a href="#tlicenses" class="nav-link" data-toggle="tab"><i class="icon-vcard"></i> Licenses</a>
										</li>
										<li class="nav-item">
											<a href="#tresult" class="nav-link active" data-toggle="tab"><i class="icon-lifebuoy"></i> Support History</a>
										</li>
									</ul>
								</div>
							</div>

						</div>
						<!-- /sidebar content -->

					</div>
					<!-- /left sidebar component -->


					<!-- Right content -->
					<form method="POST" class="editform w-100">
					<div class="tab-content w-100">
						<div class="tab-pane fade" id="tdetails">

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
													<input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo $agent['first_name'];?>">
												</div>

												<div class="form-group">
													<label>Last Name:</label>
													<input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo $agent['last_name'];?>">
												</div>

												<div class="form-group">
													<label>Phone Number:</label>
													<input type="tel" class="form-control format-phone-number" name="phone" id="phone" value="<?php echo preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1-$2-$3', $agent['phone']);?>">
												</div>

												<div class="form-group">
													<label>Email Address:</label>
													<input type="email" class="form-control" name="email" id="email" value="<?php echo $agent['email'];?>">
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
															<input type="text" name="address" id="address" class="form-control setmap" value="<?php echo $agent['address'];?>">
														</div>
													</div>

													<div class="col-xl-3">
														<div class="form-group">
															<label>Unit:</label>
															<input type="text" name="unit" id="unit" class="form-control" value="<?php echo $agent['unit'];?>">
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-xl-4">
														<div class="form-group">
															<label>State:</label>
															<input type="text" name="state" id="state" class="form-control" value="<?php echo $agent['state'];?>">
														</div>
													</div>

													<div class="col-xl-5">
														<div class="form-group">
															<label>City:</label>
															<input type="text" name="city" id="city" class="form-control" value="<?php echo $agent['city'];?>">
														</div>
													</div>

													<div class="col-xl-3">
														<div class="form-group">
															<label>Zip Code:</label>
															<input type="text" name="zipcode" id="zipcode" class="form-control" value="<?php echo $agent['zipcode'];?>">
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
									<button type="submit" class="btn btn-primary editformupdate">Submit <i class="icon-paperplane ml-2"></i></button>
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
											<div class="col-xl-5">
												<fieldset>
													<legend class="font-weight-semibold text-grey-400"><i class="icon-screen3 mr-2"></i> Social Media</legend>

													<div class="form-group">
														<label>Facebook:</label>
														<input type="text" name="facebook" id="facebook" class="form-control" value="<?php echo $agent['facebook'];?>">
													</div>

													<div class="form-group">
														<label>LinkedIn:</label>
														<input type="text" name="linkedin" id="linkedin" class="form-control" value="<?php echo $agent['linkedin'];?>">
													</div>

													<div class="form-group">
														<label>Twitter:</label>
														<input type="text" name="twitter" id="twitter" class="form-control" value="<?php echo $agent['twitter'];?>">
													</div>

													<div class="form-group">
														<label>Google:</label>
														<input type="text" name="google" id="google" class="form-control" value="<?php echo $agent['google'];?>">
													</div>

													<div class="form-group">
														<label>Instagram:</label>
														<input type="text" name="instagram" id="instagram" class="form-control" value="<?php echo $agent['instagram'];?>">
													</div>

												</fieldset>
											</div>
											<div class="col-xl-7">
												<fieldset>
													<legend class="font-weight-semibold text-grey-400"><i class="icon-quill4 mr-2"></i> Biography</legend>
													<div id="bio"><?php echo $agent['bio'];?></div>
												</fieldset>
											</div>
										</div>

								</div>
								<div class="card-footer bg-white text-right">
									<button type="submit" class="btn btn-primary editformupdate">Submit <i class="icon-paperplane ml-2"></i></button>
								</div>
							</div>

						</div>
						<div class="tab-pane fade" id="tbusiness">

							<div class="card">
								<div class="card-header bg-transparent header-elements-inline">
									<h6 class="card-title">Business Info</h6>
								</div>

								<div class="card-body">
									<div class="row">
										<div class="col-xl-5">
											<fieldset>
												<legend class="font-weight-semibold text-grey-400"><i class="icon-office mr-2"></i> Brokerage Info</legend>

												<div class="form-group">
													<label>Company Name:</label>
													<input type="text" name="brokerage_name" id="brokerage_name" class="form-control" value="<?php echo $agent['brokerage_name'];?>">
												</div>

												<div class="row">
													<div class="col-xl-9">
														<div class="form-group">
															<label>Address:</label>
															<input type="text" name="brokerage_address" id="brokerage_address" class="form-control" value="<?php echo $agent['brokerage_address'];?>">
														</div>
													</div>

													<div class="col-xl-3">
														<div class="form-group">
															<label>Unit:</label>
															<input type="text" name="brokerage_unit" id="brokerage_unit" class="form-control" value="<?php echo $agent['brokerage_unit'];?>">
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-xl-3">
														<div class="form-group">
															<label>State:</label>
															<input type="text" name="brokerage_state" id="brokerage_state" class="form-control" value="<?php echo $agent['brokerage_state'];?>">
														</div>
													</div>

													<div class="col-xl-6">
														<div class="form-group">
															<label>City:</label>
															<input type="text" name="brokerage_city" id="brokerage_city" class="form-control" value="<?php echo $agent['brokerage_city'];?>">
														</div>
													</div>

													<div class="col-xl-3">
														<div class="form-group">
															<label>Zip Code:</label>
															<input type="text" name="brokerage_zipcode" id="brokerage_zipcode" class="form-control" value="<?php echo $agent['brokerage_zipcode'];?>">
														</div>
													</div>

												</div>
												<div class="form-group">
													<label>Phone Number:</label>
													<input type="text" name="brokerage_phone" id="brokerage_phone" class="form-control format-phone-number" value="<?php echo preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1-$2-$3', $agent['brokerage_phone']);?>">
												</div>

											</fieldset>
											<fieldset>
												<legend class="font-weight-semibold text-grey-400"><i class="icon-calendar mr-2"></i>Real Estate Experience</legend>
												<div class="form-group">
													<label>First Year Licensed:</label>
													<input type="number" name="experience" id="experience" class="form-control" placeholder="First Year Licensed" value="<?php echo $agent['experience'];?>">
												</div>
											</fieldset>
										</div>
										<div class="col-xl-7">
											<fieldset>
												<legend class="font-weight-semibold text-grey-400"><i class="icon-quill4 mr-2"></i>Real Estate Specialization</legend>
												<div id="estate_specialization"><?php echo $agent['estate_specialization'];?></div>
											</fieldset>
										</div>
									</div>
								</div>

								<div class="card-footer bg-white text-right">
									<input type="hidden" name="recordID" value="<?php echo $agent['agent_id'];?>">
									<button type="submit" class="btn btn-primary editformupdate">Submit <i class="icon-paperplane ml-2"></i></button>
								</div>

							</div>

						</div>
						<div class="tab-pane fade" id="tlicenses">

							<div class="card">
								<div class="card-header bg-transparent header-elements-inline">
									<h6 class="card-title">My Licenses</h6>
									<div class="header-elements">
											<a id="addlicense" class="btn btn-success btn-labeled btn-labeled-left btn-sm text-white" data-toggle="tooltip" data-placement="bottom" title="Add new license"><b><i class="icon-add"></i></b>Add New</a>
									</div>
								</div>

								<div class="card-body">
									<div id="addnewlicense"></div>
									<div id="licenselistingpart">
										<div class="table-responsive">
											<table class="table text-nowrap">
												<thead>
													<th>License Number</th>
													<th class="text-center">State Licensed</th>
													<th class="text-center">License Type</th>
													<th class="text-center">Expire Date</th>
													<th class="text-center">Status</th>
													<th class="text-center"></th>
												</thead>
												<tbody class="profile-list">
												<?php if($licenses) {?>
												<?php foreach ($licenses as $license) { ?>
													<tr class="cursor-pointer collapsed" data-toggle="collapse" role="button" aria-expanded="false">
														<td><?php echo $license['license_number'];?></td>
														<td class="text-center"><?php echo $license['license_state'];?></td>
														<td class="text-center"><?php echo (($license['interested'] == 'Both')? 'Residential & Commercial':$license['interested']);?></td>
														<td class="text-center"><?php echo date('m-d-Y', $license['license_expire']);?></td>
														<td class="text-center"><?php echo generate_license_status_pill($license['license_status']);?></td>
														<td class="text-right">
																<div class="btn-group mt-2 dropleft" data-toggle="tooltip" data-placement="left" title="Click for options">
																	<span data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="cardopenmenu"><i class="icon-menu"></i></span>
																	<div class="dropdown-menu border-grey-700 bg-grey border-2">
																		<?php if ($license['license_status'] == 'Pending') { ?>
																		<button class="dropdown-item text-success-800 approvemylicense" type="button" data-id="<?php echo $license['license_id'];?>" data-type="Approve"><i class="icon-thumbs-up3"></i> Approve</button>
																		<button class="dropdown-item text-danger-800 approvemylicense" type="button" data-id="<?php echo $license['license_id'];?>" data-type="Decline"><i class="icon-thumbs-down3"></i> Decline</button>
																		<div class="dropdown-divider"></div>
																		<?php } ?>
																		<button class="dropdown-item editmylicense" type="button" data-id="<?php echo $license['license_id'];?>"><i class="icon-pencil7"></i> Edit Details</button>
																		<button class="dropdown-item deletemylicense" type="button" data-id="<?php echo $license['license_id'];?>"><i class="icon-trash"></i> Delete</button>
																	</div>
																</div>
														</td>
													</tr>
													<?php }?>
												<?php }else {?>
												  <tr><td colspan="6" class="text-center">No agent license.</td></tr>
												<?php }?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>

						</div>
						<div class="tab-pane fade active show" id="tresult">
							<div class="card">
								<div class="card-header bg-transparent header-elements-inline">
									<h6 class="card-title">Support History</h6>
								</div>

								<div class="card-body">
									<ul class="media-list media-chat media-chat-scrollable mb-3">
										<?php
										if ($history) {
											foreach ($history as $history_item) {
												if ($history_item['msg_from'] == 'Admin') {
												echo '<li class="media media-chat-item-reverse">
																<div class="media-body">
																	<div class="media-chat-item">'.nl2br($history_item['message_text']).'</div>
																	<div class="font-size-sm text-muted mt-2"><i class="icon-alarm ml-2 text-muted"></i> '.date("j F, Y h:i:s A",$history_item['message_date']).' by '.$history_item['admin'].'</div>
																</div>

																<div class="ml-3">
																		<img src="'.(($history_item['admin_image'])? base_url(str_replace(".jpg","_mini.jpg",$history_item['admin_image'])):base_url('images/userphoto_mini.jpg')).'" class="rounded-circle" width="40" height="40" alt="'.$history_item['admin'].'">
																</div>
															</li>';
												}else{
													echo '<li class="media">
																	<div class="mr-3">
																		<img src="'.(($history_item['agent_image'])? base_url(str_replace(".jpg","_mini.jpg",$history_item['agent_image'])):base_url('images/userphoto_mini.jpg')).'" class="rounded-circle" width="40" height="40" alt="'.$history_item['seller'].'">
																	</div>
																	<div class="media-body">
																		<div class="media-chat-item">'.nl2br($history_item['message_text']).'</div>
																		<div class="font-size-sm text-muted mt-2"><i class="icon-alarm ml-2 text-muted"></i> '.date("j F, Y h:i:s A",$history_item['message_date']).' by '.$history_item['agent'].'</div>
																	</div>
																</li>';
												}
											}
										}else{
											echo '<li class="media content-divider justify-content-center text-muted mx-0">No approval history</li>';
										}
										?>
									</ul>
								</div>
								<div class="card-header bg-transparent header-elements-inline border-top">
									<h6 class="card-title">Reply Support Request</h6>
								</div>
								<div class="card-body">
									<textarea name="message_text" id="message_text" class="form-control mb-3" rows="3" cols="1" placeholder="Enter your message..."></textarea>
								</div>
								<div class="card-footer bg-white text-right">
									<button class="btn btn-success" id="sendsupport">Send <i class="icon-checkmark-circle ml-2"></i></button>
								</div>
							</div>
						</div>
						</form>
					<!-- /right content -->
				</div>
				<!-- /inner container -->
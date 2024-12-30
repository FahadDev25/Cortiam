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
											<a class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round ml-1" data-popup="tooltip" title="Download This Photo" href="<?php echo (($agent['avatar_string'])? base_url($agent['avatar_string']):base_url('assets/images/backend/userphoto.jpg'));?>" download><i class="icon-download"></i></a>
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
	                  	<?php if($agent['facebook']){?><a href="<?php echo $agent['facebook'];?>" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round btn-file btn-sm" data-popup="tooltip" target="_blank" title="Facebook" data-container="top"><i class="icon-facebook"></i></a><?php }?>
	                  	<?php if($agent['linkedin']){?><a href="<?php echo $agent['linkedin'];?>" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round btn-file btn-sm" data-popup="tooltip" target="_blank" title="LinkedIn" data-container="top"><i class="icon-linkedin2"></i></a><?php }?>
	                  	<?php if($agent['twitter']){?><a href="<?php echo $agent['twitter'];?>" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round btn-file btn-sm" data-popup="tooltip" target="_blank" title="Twitter" data-container="top"><i class="icon-twitter"></i></a><?php }?>
	                  	<?php if($agent['google']){?><a href="<?php echo $agent['google'];?>" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round btn-file btn-sm" data-popup="tooltip" target="_blank" title="Google" data-container="top"><i class="icon-google-plus"></i></a><?php }?>
	                  	<?php if($agent['instagram']){?><a href="<?php echo $agent['instagram'];?>" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round btn-file btn-sm" data-popup="tooltip" target="_blank" title="Instagram" data-container="top"><i class="icon-instagram"></i></a><?php }?>
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
											<a href="#tbusiness" class="nav-link" data-toggle="tab"><i class="icon-office"></i> Business Info</a>
										</li>
										<li class="nav-item">
											<a href="#tlicenses" class="nav-link" data-toggle="tab"><i class="icon-vcard"></i> Licenses</a>
										</li>
										<?php if($account['permissions'][90] == 'Yes'){?>
										<li class="nav-item">
											<a href="#tlimits" class="nav-link" data-toggle="tab"><i class="icon-list-numbered"></i> Limits & Fees</a>
										</li>
										<?php } ?>
										<?php if($account['permissions'][120] == 'Yes'){?>
										<li class="nav-item">
											<a href="#tprops" class="nav-link" data-toggle="tab"><i class="icon-city"></i> Properties</a>
										</li>
										<?php } ?>
										<?php if($account['permissions'][130] == 'Yes'){?>
										<li class="nav-item">
											<a href="#tmessages" class="nav-link" data-toggle="tab"><i class="icon-comments"></i> Messages</a>
										</li>
										<?php } ?>
										<?php if($account['permissions'][140] == 'Yes'){?>
										<li class="nav-item">
											<a href="#toffers" class="nav-link" data-toggle="tab"><i class="icon-drawer3"></i> Proposals</a>
										</li>
										<?php } ?>
										<?php if($account['permissions'][150] == 'Yes'){?>
										<li class="nav-item">
											<a href="#tcontract" class="nav-link" data-toggle="tab"><i class="icon-quill4"></i> Agreements</a>
										</li>
										<?php } ?>
										<?php if($account['permissions'][170] == 'Yes'){?>
										<li class="nav-item">
											<a href="#thistory" class="nav-link" data-toggle="tab"><i class="icon-history"></i> Purchase History</a>
										</li>
										<?php } ?>
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
												<?php if($agent['membership_due']) {?>
												<?php if($agent['membership_due'] > time()) {?>
													<div class="alert alert-info bg-primary text-white alert-styled-left alert-styled-custom alert-arrow-left"><span class="font-weight-semibold">Next account membership payments is due <?php echo date('m/d/Y h:i A',$agent['membership_due']);?></span></div>
												<?php } ?>
												<?php if($agent['membership_due'] < time()) {?>
													<div class="alert alert-info bg-danger border-danger text-white alert-styled-left alert-styled-custom alert-arrow-left"><span class="font-weight-semibold">Account membership payment failed, it was due <?php echo date('m/d/Y h:i A',$agent['membership_due']);?></span></div>
												<?php } ?>
												<?php } ?>

												<?php if($agent['accept_tos']) {?>
													<div class="alert bg-primary text-white alert-styled-left"><span class="font-weight-semibold">Term of Service accepted on <?php echo date('m/d/Y h:i A',$agent['accept_tos']);?></span></div>
												<?php }else { ?>
													<div class="alert bg-danger text-white alert-styled-left"><span class="font-weight-semibold">Agent not accepted Term of Service yet.</span></div>
												<?php } ?>

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
													<div class="form-group">
														<label>YouTube Video URL:</label>
														<input type="text" name="youtube_video" id="youtube_video" class="form-control" value="<?php echo $agent['youtube_video'];?>">
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
									<button type="submit" class="btn btn-primary">Submit <i class="icon-paperplane ml-2"></i></button>
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
									<button type="submit" class="btn btn-primary">Submit <i class="icon-paperplane ml-2"></i></button>
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
										<div class="table">
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
						<div class="tab-pane fade" id="tlimits">

							<div class="card">
								<div class="card-header bg-transparent header-elements-inline">
									<h6 class="card-title">Limits, Fees</h6>
								</div>

								<div class="card-body">
										<div class="row">
											<div class="col-xl-6">
												<fieldset>
													<legend class="font-weight-semibold text-grey-400 "><i class="icon-list-numbered mr-2"></i> Limits</legend>

													<div class="row">
														<p class="col-xl-12 mb-1 font-weight-semibold text-grey">Introductions Limit</p>
														<div class="col-xl-6">
															<div class="input-group">
																<span class="input-group-prepend">
																	<span class="input-group-text">Monthly</span>
																</span>
																<input type="text" name="offer_limit" id="offer_limit" class="form-control" value="<?php echo $agent['offer_limit'];?>">
															</div>
														</div>
														<div class="col-xl-6">
															<div class="input-group">
																<span class="input-group-prepend">
																	<span class="input-group-text">Remaining</span>
																</span>
																<input type="text" name="offer_remain" id="offer_remain" class="form-control" value="<?php echo $agent['offer_remain'];?>">
															</div>
														</div>
														<p class="col-xl-12 mb-1 mt-2 font-weight-semibold text-grey">Win Limit</p>
														<div class="col-xl-6">
															<div class="input-group">
																<span class="input-group-prepend">
																	<span class="input-group-text">Monthly</span>
																</span>
																<input type="text" name="win_limit" id="win_limit" class="form-control" value="<?php echo $agent['win_limit'];?>">
															</div>
														</div>
														<div class="col-xl-6">
															<div class="input-group">
																<span class="input-group-prepend">
																	<span class="input-group-text">Remaining</span>
																</span>
																<input type="text" name="win_remain" id="win_remain" class="form-control" value="<?php echo $agent['win_remain'];?>">
															</div>
														</div>
													</div>

												</fieldset>
											</div>
											<div class="col-xl-6">
												<fieldset>
													<legend class="font-weight-semibold text-grey-400"><i class="icon-cash mr-2"></i> Fees</legend>
													<div class="form-group">
														<label>Monthly Fee:</label>
														<input type="text" name="membership_fee" id="membership_fee" class="form-control" value="<?php echo $agent['membership_fee'];?>">
														<small class="form-text text-muted">If you change monthly fee amount, new fee will be deducted from agents account.</small>
													</div>
													<div class="form-group">
														<label>Won Listing Fee:</label>
														<input type="text" name="win_cost" id="win_cost" class="form-control" value="<?php echo $agent['win_cost'];?>">
														<small class="form-text text-muted">If you set won listing fee amount, while creating new contract new fee amount will be deducted from agents account instead of state based winning cost.</small>
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
						<div class="tab-pane fade" id="thistory">
							<div class="card">
								<div class="card-header bg-transparent header-elements-inline">
									<h6 class="card-title">Purchase History</h6>
								</div>
								<div class="table-responsive">
									<table class="table text-nowrap">
										<thead>
											<th>Payment Description</th>
											<th class="text-center">Payment Amount</th>
											<th class="text-center">Payment Date</th>
											<th class="text-center">Status</th>
										</thead>
										<tbody>
										<?php if($invoices) {?>
											<?php foreach ($invoices as $invoice) { ?>
												<?php if($invoice['payment_type'] == 'Free Trial') {?>
												<tr class="collapsed" data-toggle="collapse" href="#invoice-<?php echo $invoice['invoice_id'];?>" role="button" aria-expanded="false" aria-controls="invoice-<?php echo $invoice['invoice_id'];?>">
													<td><?php echo $invoice['payment_desc'];?></td>
													<td class="text-center">$<?php echo number_format($invoice['final_amount'],2);?></td>
													<td class="text-center"><?php echo date('m/d/Y h:i A', $agent['free_starts']);?> and <?php echo date('m/d/Y h:i A', $agent['free_ends']);?></td>
													<td class="text-center">
														<span class="badge badge-success">FREE</span>
													</td>
												</tr>
												<?php }else{?>
												<tr class="cursor-pointer collapsed" data-toggle="collapse" href="#invoice-<?php echo $invoice['invoice_id'];?>" role="button" aria-expanded="false" aria-controls="invoice-<?php echo $invoice['invoice_id'];?>">
													<td><?php echo $invoice['payment_desc'];?></td>
													<td class="text-center">$<?php echo number_format($invoice['final_amount'],2);?></td>
													<td class="text-center"><?php echo (($invoice["payment_time"])? date("Y-m-d h:i A",$invoice["payment_time"]):'--');?></td>
													<td class="text-center">
													<?php if($invoice['invoice_status'] == 'Completed'){ ?>
														<span class="badge badge-success"><?php echo strtoupper($invoice['invoice_status']);?></span>
													<?php }else{ ?>
														<span class="badge badge-danger"><?php echo strtoupper($invoice['invoice_status']);?></span>
													<?php } ?>
													</td>
												</tr>
												<tr class="multi-collapse collapse invoiceexplain" id="invoice-<?php echo $invoice['invoice_id'];?>">
													<td colspan="4" class="alert p-3 alert-primary border-0 text-center">
													<?php
													switch ($invoice['invoice_status']) {
														case 'Completed':
															echo 'Payment completed on '.date('m/d/Y h:i A',$invoice['payment_time']).(($invoice['discount_amount'])? '<br><b>'.$invoice['coupon_code'].'</b> coupon used for this payment and saved $'.$invoice['discount_amount'].'. Payment amount dropped from $'.$invoice['real_amount'].' to $'.$invoice['final_amount'].'.':'');
															if(($invoice['pay_id']) && ($account['permissions'][180] == 'Yes')){
																echo '<a href="#" class="ml-4 btn btn-danger btn-labeled btn-labeled-right btn-sm refundmoney" data-amount="'.$invoice['final_amount'].'" data-refund="'.$invoice['invoice_id'].'"><b><i class="icon-cash3"></i></b> Refund</a>';
															}
															break;
														case 'Refund':
															echo 'Payment completed on '.date('m/d/Y h:i A',$invoice['payment_time']). ' and refund on '.date('m/d/Y h:i A',$invoice['refund_date']).' by '.$invoice['refund_admin'].'.';
															break;
														case 'Failed':
															echo 'Payment failed '.$invoice['try_amount'].' times and will be processed again on '.date('m/d/Y h:i A',$invoice['try_time']);
															break;
														default:
															echo 'Payment due date is '.date('m/d/Y h:i A',$invoice['try_time']);
															break;
													}
													?>
													</td>
												</tr>
												<?php }?>
											<?php }?>
										<?php }else {?>
										  <tr><td colspan="4" class="text-center">No purchase history.</td></tr>
										<?php }?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="tmessages">
							<div class="card">
								<div class="card-header bg-transparent header-elements-inline">
									<h6 class="card-title">Messages</h6>
								</div>
								<div class="card-body">

									<table class="table table-hover datatable-highlight" id="messagetable">
										<thead>
											<tr>
												<th>From</th>
												<th>To</th>
												<th>Title</th>
												<th>Send Date</th>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>

								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="tprops">
							<div class="card">
								<div class="card-header bg-transparent header-elements-inline">
									<h6 class="card-title">Properties</h6>
								</div>
								<div class="card-body">

									<table class="table table-hover datatable-highlight" id="propstable">
										<thead>
											<tr>
												<th></th>
												<th>Location</th>
												<th>Property</th>
												<th>Type</th>
												<th>Building Size</th>
												<th>Created On</th>
												<th class="text-center">Status</th>
												<th class="text-center"></th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>

								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="toffers">
							<div class="card">
								<div class="card-header bg-transparent header-elements-inline">
									<h6 class="card-title">Proposals</h6>
								</div>
								<div class="card-body">

									<table class="table table-hover datatable-highlight" id="offertable">
										<thead>
											<tr>
												<th></th>
												<th>Location</th>
												<th>From</th>
												<th>To</th>
												<th>Commission Rate</th>
												<th>Contract Length</th>
												<th>Send On</th>
												<th class="text-center">Status</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>

								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="tcontract">
							<div class="card">
								<div class="card-header bg-transparent header-elements-inline">
									<h6 class="card-title">Agreements</h6>
								</div>
								<div class="card-body">

									<table class="table table-hover datatable-highlight" id="contracttable">
										<thead>
											<tr>
												<th></th>
												<th>Location</th>
												<th>Agent</th>
												<th>Seller</th>
												<th>Commission Rate</th>
												<th>Contract Length</th>
												<th class="text-center">Signed</th>
												<th class="text-center">Status</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>

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
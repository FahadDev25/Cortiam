				<!-- Inner container -->
				<div class="d-md-flex align-items-md-start" id="changeforlowres">

					<!-- Left sidebar component -->
					<div class="sidebar sidebar-light bg-transparent sidebar-component sidebar-component-left wmin-300 border-0 shadow-0 sidebar-expand-md">

						<!-- Sidebar content -->
						<div class="sidebar-content">

							<!-- Navigation -->
							<div class="card">
								<div class="card-body bg-orange-800 text-center card-img-top" style="background-image: url(<?php echo base_url('assets/images/backend/panel_bg.png');?>); background-size: contain;">
									<div class="card-img-actions d-inline-block mb-3">
										<div class="previewAvatar border-2" style="border-radius:50%;width:170px;height:170px;overflow:hidden;background:white">
											<img class="img-fluid rounded-circle" src="<?php echo (($seller['avatar_string'])? base_url($seller['avatar_string']):base_url('assets/images/backend/userphoto.jpg'));?>" width="170" height="170" alt="" id="pageavatar">
										</div>
										<div class="card-img-actions-overlay rounded-circle">
											<div tabindex="500" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round btn-file"  data-popup="tooltip" title="Change Profile Photo" data-placement="top"><i class="icon-compose"></i><input type="file" class="file-input" id="avatarupload"></div>
										</div>
									</div>


						    		<h6 class="font-weight-semibold mb-0"><?php echo $seller['first_name'];?> <?php echo $seller['last_name'];?></h6>
						    		<span class="d-block opacity-75"><?php echo $seller['city'].', '.$seller['state'];?><br>Created on <?php echo date("Y-m-d \a\\t h:i:s A",$seller['created_on']);?></span>

					    			<div class="list-icons list-icons-extended mt-3">
	                  	<?php if($seller['email']){?><a href="mailto:<?php echo $seller['email'];?>" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round btn-file" data-popup="tooltip" title="Send Email" data-placement="top"><i class="icon-envelop3"></i></a><?php }?>
	                  	<?php if($seller['phone']){?><a href="tel:<?php echo preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1-$2-$3', $seller['phone']);?>" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round btn-file" data-popup="tooltip" title="Call Now" data-container="top"><i class="icon-phone"></i></a><?php }?>
                  	</div>
						    	</div>

								<div class="card-body p-0">
									<ul class="nav nav-sidebar mb-2">
										<li class="nav-item-header">Navigation</li>
										<li class="nav-item">
											<a href="#tdetails" class="nav-link active" data-toggle="tab"><i class="icon-magazine"></i> General Details</a>
										</li>
										<li class="nav-item">
											<a href="#tresult" class="nav-link" data-toggle="tab"><i class="icon-eye"></i> Approve/Decline</a>
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
						<div class="tab-pane fade active show" id="tdetails">

							<div class="card">
								<div class="card-header bg-transparent header-elements-inline">
									<h6 class="card-title">General Details</h6>
								</div>

								<div class="card-body">
									<div class="row">
										<div class="col-md-6">
											<fieldset>
												<legend class="font-weight-semibold text-grey-400"><i class="icon-reading mr-2"></i> Personal details</legend>

												<div class="form-group">
													<label>First Name:</label>
													<input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo $seller['first_name'];?>">
												</div>

												<div class="form-group">
													<label>Last Name:</label>
													<input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo $seller['last_name'];?>">
												</div>

												<div class="form-group">
													<label>Phone Number:</label>
													<input type="tel" class="form-control format-phone-number" name="phone" id="phone" value="<?php echo preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1-$2-$3', $seller['phone']);?>">
												</div>

												<div class="form-group">
													<label>Email Address:</label>
													<input type="email" class="form-control" name="email" id="email" value="<?php echo $seller['email'];?>">
												</div>
												<?php if($seller['accept_tos']) {?>
													<div class="alert bg-primary text-white alert-styled-left"><span class="font-weight-semibold">Term of Service accepted on <?php echo date('m/d/Y h:i A',$seller['accept_tos']);?></span></div>
												<?php }else { ?>
													<div class="alert bg-danger text-white alert-styled-left"><span class="font-weight-semibold">Agent not accepted Term of Service yet.</span></div>
												<?php } ?>
											</fieldset>
										</div>
										<div class="col-md-6">
											<fieldset>
												<legend class="font-weight-semibold text-grey-400"><i class="icon-location4 mr-2"></i> Location details</legend>

												<div class="row">
													<div class="col-md-9">
														<div class="form-group">
															<label>Address line:</label>
															<input type="text" name="address" id="address" class="form-control" value="<?php echo $seller['address'];?>">
														</div>
													</div>

													<div class="col-md-3">
														<div class="form-group">
															<label>Unit:</label>
															<input type="text" name="unit" id="unit" class="form-control" value="<?php echo $seller['unit'];?>">
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-md-4">
														<div class="form-group">
															<label>State:</label>
															<input type="text" name="state" id="state" class="form-control" value="<?php echo $seller['state'];?>">
														</div>
													</div>

													<div class="col-md-5">
														<div class="form-group">
															<label>City:</label>
															<input type="text" name="city" id="city" class="form-control" value="<?php echo $seller['city'];?>">
														</div>
													</div>

													<div class="col-md-3">
														<div class="form-group">
															<label>Zip Code:</label>
															<input type="text" name="zipcode" id="zipcode" class="form-control" value="<?php echo $seller['zipcode'];?>">
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
									<input type="hidden" name="recordID" value="<?php echo $seller['seller_id'];?>">
									<button type="submit" class="btn btn-primary editformupdate">Submit <i class="icon-paperplane ml-2"></i></button>
								</div>
							</div>

						</div>
						<div class="tab-pane fade" id="tresult">
							<div class="card">
								<div class="card-header bg-transparent header-elements-inline">
									<h6 class="card-title">Approve/Decline History</h6>
									<?php echo (($seller["approval"] == 'Denied')? '<span class="badge badge-pill float-right badge-danger">Denied</span>':(($seller["approval"] == 'Completed')? '<span class="badge badge-pill float-right badge-success">Completed</span>':'<span class="badge badge-pill float-right badge-info">Waiting</span>'));?>
								</div>

								<div class="card-body">
									<ul class="media-list media-chat media-chat-scrollable mb-3">
										<?php
										if ($history) {
											foreach ($history as $history_item) {
												if ($history_item['type'] == 'Admin') {
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
																		<img src="'.(($history_item['seller_image'])? base_url(str_replace(".jpg","_mini.jpg",$history_item['seller_image'])):base_url('images/userphoto_mini.jpg')).'" class="rounded-circle" width="40" height="40" alt="'.$history_item['seller'].'">
																	</div>
																	<div class="media-body">
																		<div class="media-chat-item">'.nl2br($history_item['message_text']).'</div>
																		<div class="font-size-sm text-muted mt-2"><i class="icon-alarm ml-2 text-muted"></i> '.date("j F, Y h:i:s A",$history_item['message_date']).' by '.$history_item['seller'].'</div>
																	</div>
																</li>';
												}
											}
										}else{
											echo '<li class="media content-divider justify-content-center text-muted mx-0">No approval history</li>';
										}
										?>
									</ul>
								<?php if (in_array($seller['approval'],array('Waiting','Denied'))) {?>
									<textarea name="message_text" id="message_text" class="form-control mb-3" rows="3" cols="1" placeholder="Enter your reason..."></textarea>
								</div>
								<div class="card-footer bg-white text-right">
									<button class="btn btn-danger float-left" id="declineme">Decline <i class="icon-cancel-circle2 ml-2"></i></button>
									<button class="btn btn-success" id="approveme">Approve <i class="icon-checkmark-circle ml-2"></i></button>
								</div>
								<?php }else{ ?>
								</div>
								<?php } ?>
							</div>
						</div>
						</form>
					<!-- /right content -->
				</div>
				<!-- /inner container -->

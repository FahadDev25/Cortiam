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
											<img class="img-fluid rounded-circle" src="<?php echo (($administrator['avatar_string'])? base_url($administrator['avatar_string']):base_url('assets/images/backend/userphoto.jpg'));?>" width="170" height="170" alt="" id="pageavatar">
										</div>
									</div>

						    		<h6 class="font-weight-semibold mb-0"><?php echo $administrator['first_name'];?> <?php echo $administrator['last_name'];?></h6>
						    		<span class="d-block opacity-75"><?php echo $administrator['city'].', '.$administrator['state'];?><br>Created on <?php echo date("Y-m-d \a\\t h:i:s A",$administrator['created_on']);?></span>

					    			<div class="list-icons list-icons-extended mt-3">
	                  	<?php if($administrator['email']){?><a href="mailto:<?php echo $administrator['email'];?>" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round btn-file" data-popup="tooltip" title="Send Email" data-placement="top"><i class="icon-envelop3"></i></a><?php }?>
	                  	<?php if($administrator['phone']){?><a href="tel:<?php echo preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1-$2-$3', $administrator['phone']);?>" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round btn-file" data-popup="tooltip" title="Call Now" data-container="top"><i class="icon-phone"></i></a><?php }?>
                  	</div>
						    	</div>

								<div class="card-body p-0">
									<ul class="nav nav-sidebar mb-2">
										<li class="nav-item-header">Navigation</li>
										<li class="nav-item">
											<a href="#tdetails" class="nav-link active" data-toggle="tab"><i class="icon-magazine"></i> General Details</a>
										</li>
										<?php if($account['permissions'][50] == 'Yes'){?>
										<li class="nav-item">
											<a href="#tpermissions" class="nav-link" data-toggle="tab"><i class="icon-eye"></i> Permissions & Notifications</a>
										</li>
										<?php } ?>
										<?php if($account['permissions'][51] == 'Yes'){?>
<!--										<li class="nav-item">
											<a href="#tmessages" class="nav-link" data-toggle="tab"><i class="icon-comments"></i> Messages</a>
										</li>-->
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
													<input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo $administrator['first_name'];?>">
												</div>

												<div class="form-group">
													<label>Last Name:</label>
													<input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo $administrator['last_name'];?>">
												</div>

												<div class="form-group">
													<label>Phone Number:</label>
													<input type="tel" class="form-control format-phone-number" name="phone" id="phone" value="<?php echo preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1-$2-$3', $administrator['phone']);?>">
												</div>

												<div class="form-group">
													<label>Email Address:</label>
													<input type="email" class="form-control" name="email" id="email" value="<?php echo $administrator['email'];?>">
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
															<input type="text" name="address" id="address" class="form-control setmap" value="<?php echo $administrator['address'];?>">
														</div>
													</div>

													<div class="col-xl-3">
														<div class="form-group">
															<label>Unit:</label>
															<input type="text" name="unit" id="unit" class="form-control" value="<?php echo $administrator['unit'];?>">
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-xl-4">
														<div class="form-group">
															<label>State:</label>
															<input type="text" name="state" id="state" class="form-control" value="<?php echo $administrator['state'];?>">
														</div>
													</div>

													<div class="col-xl-5">
														<div class="form-group">
															<label>City:</label>
															<input type="text" name="city" id="city" class="form-control" value="<?php echo $administrator['city'];?>">
														</div>
													</div>

													<div class="col-xl-3">
														<div class="form-group">
															<label>Zip Code:</label>
															<input type="text" name="zipcode" id="zipcode" class="form-control" value="<?php echo $administrator['zipcode'];?>">
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
						<div class="tab-pane fade" id="tpermissions">

							<div class="card">
								<div class="card-header bg-transparent header-elements-inline">
									<h6 class="card-title">Permissions & Notifications</h6>
								</div>

								<div class="card-body">
									<div class="row">

										<div class="col-xl-6 col-md-6">
											<fieldset>
												<legend class="font-weight-semibold  text-grey-400"><i class="icon-eye mr-2"></i> Permission details<a href="#" class="badge badge-flat border-grey text-grey-600 float-right trgswitches" data-type="perms">Check/Uncheck All</a></legend>
												<div class="row">
													<div class="col-xl-6">
													<?php
														$permissions = $administrator['permissions'];
														foreach ($admin_permissions as $key => $admin_permission) {
															if(is_numeric($key)){
																echo '<div class="form-check form-check-switchery border-checkbox-list text-secondary font-size-xs"><label class="form-check-label"><input type="checkbox" class="form-check-input-switchery invisible perms" id="permissions-'.$key.'" name="permissions['.$key.']" value="Yes" '.(($permissions[$key])? 'checked':'').'>'.$admin_permission.'</label></div>';
															}else{
																if($section_counter == 5){ echo '</div><div class="col-xl-6">';$section_counter = -10;}
																echo '<p class="font-weight-semibold mt-1 mb-2 text-grey-300">'.$admin_permission.' Permissions</p>';
																$section_counter++;
															}
														}
													?>
													</div>
												</div>
											</fieldset>
										</div>

										<div class="col-xl-6 col-md-6">
											<fieldset>
												<legend class="font-weight-semibold text-grey-400"><i class="icon-volume-medium mr-2"></i> Notification details<a href="#" class="badge badge-flat border-grey text-grey-600 float-right trgswitches" data-type="nots">Check/Uncheck All</a></legend>
												<?php
													$notifications = $administrator['notifications'];
													foreach ($admin_notifications as $key => $admin_notification) {
														echo '<div class="form-check form-check-switchery border-checkbox-list text-secondary font-size-xs"><label class="form-check-label"><input type="checkbox" class="form-check-input-switchery invisible nots" id="notification-'.$key.'" name="notifications['.$key.']" value="Yes" '.(($notifications[$key])? 'checked':'').'>'.$admin_notification.'</label></div>';
													}

												?>
											</fieldset>
										</div>

									</div>
								</div>

								<div class="card-footer bg-white text-right">
									<input type="hidden" name="recordID" value="<?php echo $administrator['admin_id'];?>">
									<input type="hidden" name="avatar_string" value="<?php echo $administrator['avatar_string'];?>">
									<button type="submit" class="btn btn-primary">Submit <i class="icon-paperplane ml-2"></i></button>
								</div>

							</div>

						</div>
						<div class="tab-pane fade" id="tmessages">
							<div class="card">
								<div class="card-header bg-transparent header-elements-inline">
									<h6 class="card-title">Messages</h6>
								</div>

										<table class="table table-hover datatable-highlight" id="messagetable">
											<thead style="display:none;">
												<tr>
													<th class="text-center"></th>
													<th class="text-center"></th>
													<th>Full Name</th>
													<th>Message</th>
													<th class="text-center">Date</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td><span class="badge badge-success">Support</span></td>
													<td><img class="img-fluid rounded-circle" src="<?php echo base_url('assets/images/backend/userphoto.jpg');?>" width="40" height="40" alt=""></td>
													<td>John Doe</td>
													<td><div class="table-inbox-subject">Sed tincidunt leo ut porttitor venenatis</div><span class="text-muted font-weight-normal">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc rutrum mollis arcu quis consectetur. Etiam viverra, turpis et volutpat congue, nisi nulla placerat tortor....</span></td>
													<td><?php echo date('M d, Y', strtotime( '+'.mt_rand(0,30).' days'));?></td>
												</tr>
												<tr>
													<td><span class="badge badge-success">Support</span></td>
													<td><img class="img-fluid rounded-circle" src="<?php echo base_url('assets/images/backend/userphoto.jpg');?>" width="40" height="40" alt=""></td>
													<td>John Doe</td>
													<td><div class="table-inbox-subject">Aliquam id elit varius, mollis dolor sit amet, posuere mauris</div><span class="text-muted font-weight-normal">Praesent mollis semper magna vel elementum. Nunc sollicitudin ultrices laoreet. Suspendisse interdum enim id tempus vestibulum....</span></td>
													<td><?php echo date('M d, Y', strtotime( '+'.mt_rand(0,30).' days'));?></td>
												</tr>
												<tr>
													<td><span class="badge badge-danger">Report</span></td>
													<td><img class="img-fluid rounded-circle" src="<?php echo base_url('assets/images/backend/userphoto.jpg');?>" width="40" height="40" alt=""></td>
													<td>John Doe</td>
													<td><div class="table-inbox-subject">Praesent mollis semper magna vel elementum</div><span class="text-muted font-weight-normal">Donec quis ipsum eget tellus ornare pulvinar. Mauris imperdiet nec leo sit amet vestibulum. Ut quis mauris viverra, iaculis felis nec....</span></td>
													<td><?php echo date('M d, Y', strtotime( '+'.mt_rand(0,30).' days'));?></td>
												</tr>
												<tr>
													<td><span class="badge badge-success">Support</span></td>
													<td><img class="img-fluid rounded-circle" src="<?php echo base_url('assets/images/backend/userphoto.jpg');?>" width="40" height="40" alt=""></td>
													<td>John Doe</td>
													<td><div class="table-inbox-subject">Aenean bibendum tellus eget diam pellentesque lacinia</div><span class="text-muted font-weight-normal">Cras blandit tellus accumsan porttitor fringilla. Nam blandit felis eget orci convallis congue. Suspendisse quis congue tellus. Sed ultrices...</span></td>
													<td><?php echo date('M d, Y', strtotime( '+'.mt_rand(0,30).' days'));?></td>
												</tr>
												<tr>
													<td><span class="badge badge-success">Support</span></td>
													<td><img class="img-fluid rounded-circle" src="<?php echo base_url('assets/images/backend/userphoto.jpg');?>" width="40" height="40" alt=""></td>
													<td>John Doe</td>
													<td><div class="table-inbox-subject">Donec pellentesque nisi ac sodales placerat</div><span class="text-muted font-weight-normal">Curabitur lacinia sem sit amet vestibulum rutrum. Nulla facilisi. Sed tempor, arcu rhoncus luctus tempor, augue tellus hendrerit odio, nec...</span></td>
													<td><?php echo date('M d, Y', strtotime( '+'.mt_rand(0,30).' days'));?></td>
												</tr>
												<tr>
													<td><span class="badge badge-success">Support</span></td>
													<td><img class="img-fluid rounded-circle" src="<?php echo base_url('assets/images/backend/userphoto.jpg');?>" width="40" height="40" alt=""></td>
													<td>John Doe</td>
													<td><div class="table-inbox-subject">Fusce ornare efficitur arcu, eget tincidunt ipsum facilisis</div><span class="text-muted font-weight-normal">Aenean quis purus rutrum lorem suscipit sollicitudin non id urna. Aenean elit enim, ultricies porta justo sit amet, faucibus imperdiet ligula....</span></td>
													<td><?php echo date('M d, Y', strtotime( '+'.mt_rand(0,30).' days'));?></td>
												</tr>

											</tbody>
										</table>
							</div>

						</div>
					</div>
					<!-- /right content -->
					</form>
				</div>
				<!-- /inner container -->


			<!-- Content area -->
			<div class="content">

				<div class="row">

					<div class="col-sm-6 col-xl-3">
						<div class="card">
							<div class="card-body">
								<div class="d-flex">
									<h3 class="font-weight-semibold mb-0"><?php echo $agent_count;?></h3>
			                	</div>

			                	<div>
									Real Estate Agents (Last 15 Days)
									<div class="text-muted font-size-sm"><?php echo number_format(($agent_count/15),2);?> avg</div>
								</div>
							</div>

							<div class="container-fluid">
								<div id="second_chart"></div>
							</div>
						</div>
					</div>

					<div class="col-sm-6 col-xl-3">
						<div class="card">
							<div class="card-body">
								<div class="d-flex">
									<h3 class="font-weight-semibold mb-0"><?php echo $seller_count;?></h3>
			                	</div>

			                	<div>
									Property Owners (Last 15 Days)
									<div class="text-muted font-size-sm"><?php echo number_format(($seller_count/15),2);?> avg</div>
								</div>
							</div>

							<div class="container-fluid">
								<div id="third_chart"></div>
							</div>
						</div>
					</div>

					<div class="col-sm-6 col-xl-3">
						<div class="card">
							<div class="card-body">
								<div class="d-flex">
									<h3 class="font-weight-semibold mb-0"><?php echo $properties_count;?></h3>
			                	</div>

			                	<div>
									Properties (Last 15 Days)
									<div class="text-muted font-size-sm"><?php echo number_format(($properties_count/15),2);?> avg</div>
								</div>
							</div>

							<div id="fourth_chart"></div>
						</div>
					</div>

					<div class="col-sm-6 col-xl-3">
						<div class="card">
							<div class="card-body">
								<div class="d-flex">
									<h3 class="font-weight-semibold mb-0">$<?php echo $invoice_count;?></h3>
			          </div>
			          <div>Total Revenue (Last 15 Days)
									<div class="text-muted font-size-sm">$<?php echo number_format(($invoice_count/15),2);?> avg</div>
								</div>
							</div>
							<div id="first_chart"></div>
						</div>
					</div>

				</div>
				<div class="row">
					<div class="col-sm-9 col-xl-9">

						<div class="card">
							<div class="table-responsive">
								<table class="table text-nowrap">
									<thead>
										<tr>
											<th>Full Name</th>
											<th>State</th>
											<th>City</th>
											<th>Email</th>
											<th>Phone</th>
										</tr>
									</thead>
									<tbody>
										<tr class="table-active table-border-double">
											<td colspan="5">Last 5 Real Estate Agents</td>
										</tr>
										<?php foreach ($last_agents as $last_agent) { ?>
										<tr>
											<td>
												<div class="d-flex align-items-center">
													<div class="mr-3">
														<img class="img-fluid rounded-circle" src="<?php echo (($last_agent['avatar_string'])? base_url(str_replace(".jpg","_mini.jpg",$last_agent['avatar_string'])):base_url('images/userphoto_mini.jpg'))?>" width="40" height="40" alt="">
													</div>
													<div>
														<a href="<?php echo base_url('ct-admin/edit-agent/'.$last_agent["agent_id"]);?>" class="text-default font-weight-semibold"><?php echo $last_agent["first_name"].' '.$last_agent["last_name"];?></a>
													</div>
												</div>
											</td>
											<td><span class="text-muted"><?php echo $last_agent["city"];?></span></td>
											<td><span class="text-muted"><?php echo $last_agent["state"];?></span></td>
											<td><?php echo $last_agent["email"];?></td>
											<td><?php echo $last_agent["phone"];?></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>

						<div class="card">
							<div class="table-responsive">
								<table class="table text-nowrap">
									<thead>
										<tr>
											<th>Full Name</th>
											<th>State</th>
											<th>City</th>
											<th>Email</th>
											<th>Phone</th>
										</tr>
									</thead>
									<tbody>
										<tr class="table-active table-border-double">
											<td colspan="5">Last 5 Property Owners</td>
										</tr>
										<?php foreach ($last_sellers as $last_seller) { ?>
										<tr>
											<td>
												<div class="d-flex align-items-center">
													<div class="mr-3">
														<img class="img-fluid rounded-circle" src="<?php echo (($last_seller['avatar_string'])? base_url(str_replace(".jpg","_mini.jpg",$last_seller['avatar_string'])):base_url('images/userphoto_mini.jpg'))?>" width="40" height="40" alt="">
													</div>
													<div>
														<a href="<?php echo base_url('ct-admin/edit-seller/'.$last_seller["seller_id"]);?>" class="text-default font-weight-semibold"><?php echo $last_seller["first_name"].' '.$last_seller["last_name"];?></a>
													</div>
												</div>
											</td>
											<td><span class="text-muted"><?php echo $last_seller["city"];?></span></td>
											<td><span class="text-muted"><?php echo $last_seller["state"];?></span></td>
											<td><?php echo $last_seller["email"];?></td>
											<td><?php echo $last_seller["phone"];?></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>

						<div class="card">
							<div class="table-responsive">
								<table class="table text-nowrap">
									<thead>
										<tr>
											<th>Property</th>
											<th>Owner</th>
											<th>Type</th>
											<th>Sub Type</th>
											<th>Size</th>
										</tr>
									</thead>
									<tbody>
										<tr class="table-active table-border-double">
											<td colspan="5">Last 5 Properties</td>
										</tr>
										<?php foreach ($last_properties as $last_property) { ?>
										<tr>
											<td>
												<div class="d-flex align-items-center">
													<div class="mr-3">
														<img class="img-fluid rounded-circle" src="<?php echo (($last_property['default_image'])? base_url(str_replace(".jpg","_mini.jpg",$last_property['default_image'])):base_url('assets/images/backend/propertyphoto_mini.jpg'))?>" width="40" height="40" alt="">
													</div>
													<div>
														<a href="<?php echo base_url('ct-admin/edit-property/'.$last_property["property_id"]);?>" class="text-default font-weight-semibold"><?php echo $last_property["city"].', '.$last_property["state"];?></a>
														<div class="text-muted font-size-sm">
															<?php echo $last_property["address"].', '.$last_property["zipcode"];?>
														</div>
													</div>
												</div>
											</td>
											<td><?php echo $last_property["first_name"].' '.$last_property["last_name"];?></td>
											<td><span class="text-muted"><?php echo $last_property["type"];?></span></td>
											<td><span class="text-muted"><?php echo $last_property["sub_type"];?></span></td>
											<td><?php echo $last_property["building_size"];?></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>

					</div>
					<div class="col-sm-3 col-xl-3">


						<a class="card card-body" href="<?php echo base_url('ct-admin/list-coupons');?>">
							<div class="media">
								<div class="media-body">
									<h3 class="font-weight-semibold mb-0 text-grey-800"><?php echo (($coupon_count)? $coupon_count:0);?></h3>
									<span class="text-uppercase font-size-sm text-muted">active coupons</span>
								</div>

								<div class="ml-3 align-self-center">
									<i class="icon-price-tag icon-3x text-danger-400"></i>
								</div>
							</div>
						</a>

						<div class="card text-center">
							<div class="card-body">
								<i class="icon-thumbs-up3 icon-3x text-slate-700 mt-1"></i>
								<h5 class="font-weight-semibold mb-0 mt-1">Waiting Approvals</h5>
								<div class="font-size-sm text-muted">Currently</div>
							</div>
							<div class="card-body">
								<div class="row text-center">
									<a class="col-4" href="<?php echo base_url('ct-admin/approval-agents');?>">
										<p><i class="icon-users2 icon-2x d-inline-block text-info"></i></p>
										<h5 class="font-weight-semibold mb-0 text-grey-800"><?php echo (($waiting_approvals['Agent'])? $waiting_approvals['Agent']:'0');?></h5>
										<span class="text-muted font-size-sm">Real Estate Agents</span>
									</a>

									<a class="col-4" href="<?php echo base_url('ct-admin/approval-sellers');?>">
										<p><i class="icon-users4 icon-2x d-inline-block text-warning"></i></p>
										<h5 class="font-weight-semibold mb-0 text-grey-800"><?php echo (($waiting_approvals['Seller'])? $waiting_approvals['Seller']:'0');?></h5>
										<span class="text-muted font-size-sm">Property Owners</span>
									</a>

									<a class="col-4" href="<?php echo base_url('ct-admin/approval-properties');?>">
										<p><i class="icon-city icon-2x d-inline-block text-success"></i></p>
										<h5 class="font-weight-semibold mb-0 text-grey-800"><?php echo (($waiting_approvals['Properties'])? $waiting_approvals['Properties']:'0');?></h5>
										<span class="text-muted font-size-sm">Properties</span>
									</a>
								</div>
							</div>
						</div>

						<div class="card text-center">
							<div class="card-body">
								<i class="icon-drawer3 icon-3x text-success mt-1"></i>
								<h5 class="font-weight-semibold mb-0 mt-1">Introductions/Agreements</h5>
								<div class="font-size-sm text-muted">Last 15 days</div>
							</div>

							<div class="card-body border-top-0 pt-0">
								<div class="row">
									<a class="col-6" href="<?php echo base_url('ct-admin/list-introductions');?>">
										<div class="text-uppercase font-size-xs text-muted">Introductions</div>
										<h5 class="font-weight-semibold line-height-1 mt-1 mb-0 text-grey-800"><?php echo (($proposal_count)? $proposal_count:0);?></h5>
									</a>

									<a class="col-6" href="<?php echo base_url('ct-admin/list-agreements');?>">
										<div class="text-uppercase font-size-xs text-muted">Agreements</div>
										<h5 class="font-weight-semibold line-height-1 mt-1 mb-0 text-grey-800"><?php echo (($contract_count)? $contract_count:0);?></h5>
									</a>
								</div>
							</div>
						</div>

						<div class="card text-center">
							<div class="card-body">
								<i class="icon-lifebuoy icon-3x text-warning mt-1"></i>
								<h5 class="font-weight-semibold mb-0 mt-1">Support Requests</h5>
								<div class="font-size-sm text-muted">Last 15 days</div>
							</div>

							<div class="card-body border-top-0 pt-0">
								<div class="row">
									<a class="col-6" href="<?php echo base_url('ct-admin/list-seller-support');?>">
										<div class="text-uppercase font-size-xs text-muted">Property Owners</div>
										<h5 class="font-weight-semibold line-height-1 mt-1 mb-0 text-grey-800"><?php echo (($waiting_supports['Seller'])? $waiting_supports['Seller']:'0');?></h5>
									</a>

									<a class="col-6" href="<?php echo base_url('ct-admin/list-agent-support');?>">
										<div class="text-uppercase font-size-xs text-muted">Real Estate Agents</div>
										<h5 class="font-weight-semibold line-height-1 mt-1 mb-0 text-grey-800"><?php echo (($waiting_supports['Agent'])? $waiting_supports['Agent']:'0');?></h5>
									</a>
								</div>
							</div>
						</div>

					</div>
				</div>

			</div>
			<!-- /content area -->


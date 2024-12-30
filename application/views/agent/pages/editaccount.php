	<form method="POST" class="ajaxform w-100" data-source="formajaxurl" autocomplete="off" id="editprofileform">
	<div class="card">
	  <div class="card-header header-elements-inline">
			<h3 class="card-title"><span class="icon-co-big orange profile"></span> Profile</h3>
			<div class="header-elements">
				<div class="dropdown d-inline mr-0 mr-sm-2">
					<a href="#" role="button" id="questiontab-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="icon-co-big question"></span></a>
				  <div class="dropdown-menu dropdown-menu-right larger" aria-labelledby="questiontab-1" id="questiontab-1">
						<p>Vivamus in tellus hendrerit, euismod erat in, tempus mi. Sed vel blandit velit, ut accumsan orci. Vestibulum sed rutrum mi. Proin sed dolor turpis. Suspendisse sagittis faucibus eros a sodales. Nulla in tempor magna. Proin efficitur imperdiet dolor eu imperdiet.</p>
				  </div>
				</div>
				<h6 class="d-inline mt-1 align-middle">EMAIL NOTIFICATION</h6>
				<label class="switchbutton ml-2">
				  <input type="checkbox" name="notifications" id="notifications" value="Yes" <?php echo (($account['notifications'] == 'Yes')? 'checked':'');;?>>
				  <span class="switchslider round"></span>
				</label>
			</div>
	  </div>
	  <div class="card-body">
			<fieldset>
			<div class="row">
				<div class="col-md-3 text-center">
					<h5 class="text-left">Profile
                        </h5>
	  			<div class="d-inline-block my-3 mt-lg-4 mt-xl-4 mouseoverlayer">
	  				<img class="img-fluid rounded-circle user-avatar photoneedsupdate" src="<?php echo (($account['avatar_string'])? base_url($account['avatar_string']):base_url('assets/images/backend/userphoto.jpg'));?>" width="120" height="120" id="editavatarstring">
	  				<div class="hoverlayer rounded-circle triggerphotochange"><div class="centerer" data-toggle="tooltip" data-placement="left" title="Click to change"><span class="icon-co-big white write"></span></div></div>
	  			</div>
				</div>
				<div class="col-md-9">
					<div class="row">
						<h5 class="col-sm-12">Personal Information</h5>
						<div class="col-md-6">
							<div class="form-group">
								<input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" value="<?php echo $account['first_name'];?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" value="<?php echo $account['last_name'];?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<input type="tel" class="form-control format-phone-number" name="phone" placeholder="Phone Number" id="phone" value="<?php echo preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1-$2-$3', $account['phone']);?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<input type="email" class="form-control" name="email" id="email" placeholder="Email Address" value="<?php echo $account['email'];?>">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<input type="text" name="youtube_video" id="youtube_video" class="form-control" placeholder="YouTube Video URL" value="<?php echo $account['youtube_video'];?>">
							</div>
						</div>
					</div>
				</div>
			</div>
			<hr>

			<div class="row">
				<h5 class="col-sm-12">Location Information</h5>
				<div class="col-md-9">
					<div class="form-group">
						<input type="text" name="address" id="address" class="form-control setmap" placeholder="Address Line" value="<?php echo $account['address'];?>">
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<input type="text" name="unit" id="unit" class="form-control" placeholder="Unit" value="<?php echo $account['unit'];?>">
					</div>
				</div>
			</div>

			
			<div class="row">
				<div class="col-md-5">
					<div class="form-group">
						<select name="state" id="state" class="form-control">
						<?php 
							if(isset($account['state']) &&  $account['state'])
							{
						?>
							  <option value="<?= $account['state'] ?>"><?= $account['state'] ?></option>
						<?php
							}else{
						?>
							  <option>Select a State</option>

						<?php

							}
						?>
						</select>
					</div>
				</div>

				<div class="col-md-5">
					<div class="form-group">
						<select name="city" id="city"class="form-control">
						<?php 
							if(isset($account['city']) &&  $account['city'])
							{
						?>
							  <option value="<?= $account['city'] ?>"><?= $account['city'] ?></option>
						<?php
							}else{
						?>
							  <option>Select a City</option>

						<?php

							}
						?>
						</select>
					</div>
				</div>

				<div class="col-md-2">
					<div class="form-group">
						<input type="text" name="zipcode" id="zipcode" class="form-control" placeholder="Zip Code" value="<?php echo $account['zipcode'];?>">
					</div>
				</div>
	
			</div>
			<hr>
			<div class="row mt-3">
				<h5 class="col-sm-12">Brokerage Info</h5>
				<div class="col-md-12">
					<div class="form-group">
						<input type="text" name="brokerage_name" id="brokerage_name" class="form-control" placeholder="Company Name" value="<?php echo $account['brokerage_name'];?>">
					</div>
				</div>
				<div class="col-md-9">
					<div class="form-group">
						<input type="text" name="brokerage_address" id="brokerage_address" class="form-control" placeholder="Address" value="<?php echo $account['brokerage_address'];?>">
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<input type="text" name="brokerage_unit" id="brokerage_unit" class="form-control" placeholder="Unit" value="<?php echo $account['brokerage_unit'];?>">
					</div>
				</div>
				<div class="col-md-5">
					<div class="form-group">
						<select name="brokerage_state" id="brokerage_state" class="form-control">
						<?php 
							if(isset($account['brokerage_state']) &&  $account['brokerage_state'])
							{
						?>
							  <option value="<?= $account['brokerage_state'] ?>"><?= $account['brokerage_state'] ?></option>
						<?php
							}else{
						?>
							  <option>Select a State</option>

						<?php

							}
						?>
						</select>
					</div>
				</div>
				<div class="col-md-5">
					<div class="form-group">

						<select name="brokerage_city" id="brokerage_city" class="form-control">
						<?php 
							if(isset($account['brokerage_city']) &&  $account['brokerage_city'])
							{
						?>
							  <option value="<?= $account['brokerage_city'] ?>"><?= $account['brokerage_city'] ?></option>
						<?php
							}else{
						?>
							  <option>Select a City</option>

						<?php

							}
						?>
						</select>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<input type="text" name="brokerage_zipcode" id="brokerage_zipcode" class="form-control" placeholder="Zip Code" value="<?php echo $account['brokerage_zipcode'];?>">
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<input type="text" name="brokerage_phone" id="brokerage_phone" class="form-control format-phone-number" placeholder="Phone Number" value="<?php echo preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1-$2-$3', $account['brokerage_phone']);?>">
					</div>
				</div>
				<hr class="mt-3">
				<h5 class="col-sm-12">Real Estate Experience</h5>
				<div class="col-md-12">
					<div class="form-group">
						<input type="number" name="experience" id="experience" class="form-control" placeholder="First Year Licensed" value="<?php echo $account['experience'];?>">
					</div>
				</div>
                <h5 class="col-sm-12">Specialization</h5>
                <div class="col-md-5">
                    <div class="form-group">

                        <select class="form-control specialization-selection" id="specialization-selection" name="specializations[]" multiple="multiple">
                            <?php
                            if(isset($specializations) && $specializations !== '')
                            {
                                foreach($specializations as $key => $val)
                                {
                                    ?>
                                    <option value="<?= $val['id'] ?>" <?= array_search($val['id'], array_column($agentspecializations, 'specialization_id')) !== false ? 'selected' : '' ?>><?=  $val['name']?></option>
                                    <?php

                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
				<h5 class="col-sm-12">Real Estate Specialization</h5>
				<div class="col-md-12">
					<div id="estate_specialization" placeholder="Please describe your particular real estate specialization such as waterfront, mountain homes..."><?php echo $account['estate_specialization'];?></div>
				</div>
			</div>
			<hr class="mt-3">

			<div class="row">
				<h5 class="col-sm-12">Social Media</h5>
				<div class="col-md-6">
					<div class="form-group">
						<input type="text" name="facebook" id="facebook" class="form-control" placeholder="Facebook Profile" value="<?php echo $account['facebook'];?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<input type="text" name="linkedin" id="linkedin" class="form-control" placeholder="LinkedIn Profile" value="<?php echo $account['linkedin'];?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<input type="text" name="twitter" id="twitter" class="form-control" placeholder="Twitter Profile" value="<?php echo $account['twitter'];?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<input type="text" name="google" id="google" class="form-control" placeholder="Google Profile" value="<?php echo $account['google'];?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<input type="text" name="instagram" id="instagram" class="form-control" placeholder="Instagram Profile" value="<?php echo $account['instagram'];?>">
					</div>
				</div>
			</div>
			<hr>
			<div class="row">
				<h5 class="col-sm-12">Biography</h5>
				<div class="col-md-12">
					<div id="bio" placeholder="Please describe your short biography, its important part of introducing yourself to potential clients..."><?php echo $account['bio'];?></div>
				</div>
			</div>

			</fieldset>

	  </div>
	  <div class="card-footer text-right">
				<button type="submit" class="button-orange">Update Profile</button>
	  </div>
	</div>
	</form>


	<div class="card" id="licensespart">
	  <div class="card-header header-elements-inline">
			<h3 class="card-title"><span class="icon-co-big orange license"></span> Licenses</h3>
			<div class="header-elements">
				<div class="dropdown d-inline">
					<a href="#" role="button" id="questiontab-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="icon-co-big question"></span></a>
				  <div class="dropdown-menu dropdown-menu-right larger" aria-labelledby="questiontab-1" id="questiontab-1">
						<p>Vivamus in tellus hendrerit, euismod erat in, tempus mi. Sed vel blandit velit, ut accumsan orci. Vestibulum sed rutrum mi. Proin sed dolor turpis. Suspendisse sagittis faucibus eros a sodales. Nulla in tempor magna. Proin efficitur imperdiet dolor eu imperdiet.</p>
				  </div>
				</div>
	  		<a class="headerelementlink" id="addlicense" data-toggle="tooltip" data-placement="bottom" title="Add new license"><span class="icon-co-big add"></span></a>
				<a href="#" class="dofullscreen"><span class="icon-co-big expand"></span></a>
			</div>
	  </div>
	  <div class="card-body">
			<fieldset>
			<div class="row">
				<div class="col-md-12">
					<div id="addnewlicense">

					</div>
				</div>
				<div class="col-md-12" id="licenselistingpart">
					<ul class="profile-list">
						<?php if($licenses) {?>
						<?php foreach ($licenses as $license) { ?>
						  <li class="profile-list-item">
							  <div class="row no-gutters">
								  <div class="col-sm-8">
								  	<p class="titlepart"><strong><?php echo (($license['interested'] == 'Both')? 'Residential & Commercial':$license['interested']);?> License for <?php echo $license['license_state'];?></strong></p>
								  	<p class="subtitlepart">Expires on <?php echo date('m-d-Y', $license['license_expire']);?></p>
							  	</div>
								  <div class="col-sm-2 align-middle text-center">
								  	<?php echo generate_license_status_pill($license['license_status']);?>
							  	</div>
								  <div class="col-sm-2 align-middle text-right">
										<div class="btn-group mt-2 dropleft" data-toggle="tooltip" data-placement="left" title="Click for options">
											<span data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="cardopenmenu"><i class="icon-menu"></i></span>
											<div class="dropdown-menu">
												<button class="dropdown-item" type="button" id="editmylicense" data-id="<?php echo $license['license_id'];?>">Edit Details</button>
												<button class="dropdown-item" type="button" id="deletemylicense" data-id="<?php echo $license['license_id'];?>">Delete</button>
											</div>
										</div>
							  	</div>
							  	</div>
						  </li>
							<?php }?>
						<?php }else {?>
						  <li class="list-group-item text-center">Please add your agent license for your account.</li>
						<?php }?>
					</ul>
				</div>
			</div>
			</fieldset>
	  </div>

	</div>

	<form method="POST" class="ajaxform w-100" data-source="passwordajaxurl">
	<div class="card">
	  <div class="card-header header-elements-inline">
			<h3 class="card-title"><span class="icon-co-big orange profile"></span> Password Change</h3>
			<div class="header-elements">
				<div class="dropdown d-inline">
					<a href="#" role="button" id="questiontab-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="icon-co-big question"></span></a>
				  <div class="dropdown-menu dropdown-menu-right larger" aria-labelledby="questiontab-1" id="questiontab-1">
						<p>Password and confirm password are not mandatory fields for updating your profile details. Please only use when you want to update/change your account password.</p>
				  </div>
					<a href="#" class="dofullscreen"><span class="icon-co-big expand"></span></a>
				</div>
			</div>
	  </div>
	  <div class="card-body">
			<fieldset>
			<div class="row">
				<div class="col-md-12">
					<div class="alert alert-info">Password and confirm password are not mandatory fields for updating your profile details. Please only use when you want to update/change your account password.</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<input type="password" class="form-control" name="password" id="password" placeholder="Password"">
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<input type="password" class="form-control" name="passwordagain" id="passwordagain" placeholder="Repeat Password">
					</div>
				</div>
			</div>
			</fieldset>

	  </div>
	  <div class="card-footer text-right">
	  	<button type="submit" class="button-orange">Change Password</button>
	  </div>
	  <div class="card-footer text-left dark">
	  	<a href="#" class="deactivateme" data-id="<?php echo $account['agent_id'];?>"><i class="icon-cancel-circle2 mr-2"></i>Remove Account</a></button>
	  </div>
	</div>
	</form>

	<?php if($account['stripe_id']) {?>
	<div class="card" id="paymentpart">
	  <div class="card-header header-elements-inline">
			<h3 class="card-title"><span class="icon-co-big orange ccard"></span> Credit Cards</h3>
			<div class="header-elements">
				<div class="dropdown d-inline">
					<a href="#" role="button" id="questiontab-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="icon-co-big question"></span></a>
				  <div class="dropdown-menu dropdown-menu-right larger" aria-labelledby="questiontab-1" id="questiontab-1">
						<p>Vivamus in tellus hendrerit, euismod erat in, tempus mi. Sed vel blandit velit, ut accumsan orci. Vestibulum sed rutrum mi. Proin sed dolor turpis. Suspendisse sagittis faucibus eros a sodales. Nulla in tempor magna. Proin efficitur imperdiet dolor eu imperdiet.</p>
				  </div>
				</div>
	  		<a class="headerelementlink" id="addcart" data-toggle="tooltip" data-placement="bottom" title="Add new credit card"><span class="icon-co-big add"></span></a>
				<a href="#" class="dofullscreen"><span class="icon-co-big expand"></span></a>
			</div>
	  </div>
	  <div class="card-body">
			<fieldset>
			<div class="row">
				<div class="col-md-12">
					<div id="cardpart">

					</div>
				</div>
				<div class="col-md-12" id="cardlistingpart">
					<ul class="profile-list">
						<?php if($credit_cards) {?>
						<?php foreach ($credit_cards as $credit_card) { ?>
						  <li class="profile-list-item">
							  <div class="row no-gutters">
								  <div class="col-sm-9">
								  	<div class="float-left mr-2"><?php echo card_icons($credit_card['brand']);?></div>
								  	<p class="titlepart"><strong><?php echo ucfirst($credit_card['brand']);?> **** <?php echo $credit_card['last_digit'];?></strong></p>
								  	<p class="subtitlepart">Expires on <?php echo date('M Y', $credit_card['expire_date']);?></p>
							  	</div>
								  <div class="col-sm-3 align-middle text-right">
										<div class="btn-group dropleft <?php echo (($credit_card['payment_id'] == $account['payment_id'])? 'invisible':'');?>" data-toggle="tooltip" data-placement="left" title="Click for options">
											<span data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="cardopenmenu"><i class="icon-menu"></i></span>
											<div class="dropdown-menu">
												<button class="dropdown-item" type="button" id="deletemycard" data-id="<?php echo $credit_card['card_id'];?>">Delete</button>
												<button class="dropdown-item" type="button" id="setmycard" data-id="<?php echo $credit_card['card_id'];?>">Set As Default</button>
											</div>
										</div>
							  	</div>
							  	</div>
						  </li>
							<?php }?>
						<?php }else {?>
						  <li class="list-group-item text-center">Please add your credit card to activate your payment system.</li>
						<?php }?>
					</ul>
				</div>
			</div>
			</fieldset>
	  </div>

	</div>
	<?php } ?>

	<?php if($invoices) {?>
	<div class="card" id="invoicepart">
	  <div class="card-header header-elements-inline">
			<h3 class="card-title"><span class="icon-co-big orange finance"></span> Payments</h3>
			<div class="header-elements">
				<div class="dropdown d-inline">
					<a href="#" role="button" id="questiontab-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="icon-co-big question"></span></a>
				  <div class="dropdown-menu dropdown-menu-right larger" aria-labelledby="questiontab-1" id="questiontab-1">
						<p>Vivamus in tellus hendrerit, euismod erat in, tempus mi. Sed vel blandit velit, ut accumsan orci. Vestibulum sed rutrum mi. Proin sed dolor turpis. Suspendisse sagittis faucibus eros a sodales. Nulla in tempor magna. Proin efficitur imperdiet dolor eu imperdiet.</p>
				  </div>
					<a href="#" class="dofullscreen"><span class="icon-co-big expand"></span></a>
				</div>
			</div>
	  </div>
	  <div class="card-body">
			<fieldset>
			<div class="row">
				<div class="col-md-12">
					<ul class="profile-list expandable" id="invoicelistingpart">
						<?php if($invoices) {?>
						<?php foreach ($invoices as $invoice) { ?>
						  <li class="profile-list-item">
						  	<?php if($invoice['payment_type'] == 'Free Trial'){ ?>
							  <div class="trialmessage pl-3 text-center" data-toggle="collapse" href="#invoice-<?php echo $invoice['invoice_id'];?>" role="button" aria-expanded="false" aria-controls="invoice-<?php echo $invoice['invoice_id'];?>">Free Trial Period between <?php echo date('m/d/Y h:i A', $account['free_starts']);?> and <?php echo date('m/d/Y h:i A', $account['free_ends']);?>.</div>
						  	<?php }else{ ?>
							  <div class="row pl-3 cursor-pointer collapsed" data-toggle="collapse" href="#invoice-<?php echo $invoice['invoice_id'];?>" role="button" aria-expanded="false" aria-controls="invoice-<?php echo $invoice['invoice_id'];?>">
								  <div class="col-sm-9 align-middle">
							  		<p class="titlepart"><?php echo $invoice['payment_desc'];?></p>
							  	</div>
								  <div class="col-sm-1 align-middle">
								  	<p class="mb-0 text-nowrap">$<?php echo $invoice['final_amount'];?></p>
							  	</div>
								  <div class="col-sm-2 align-middle text-right">
								  	<?php echo generate_invoice_status_pill($invoice['invoice_status']);?>
							  	</div>
						  	</div>
						  	<div class="col-sm-12 multi-collapse collapse invoiceexplain" id="invoice-<?php echo $invoice['invoice_id'];?>">
						  	<?php
								switch ($invoice['invoice_status']) {
									case 'Completed':
										echo 'Payment completed on '.date('m/d/Y h:i A',$invoice['payment_time']).(($invoice['discount_amount'])? '<br><b>'.$invoice['coupon_code'].'</b> coupon used for this payment and saved $'.$invoice['discount_amount'].'. Payment amount dropped from $'.$invoice['real_amount'].' to $'.$invoice['final_amount'].'.':'');
										break;
									case 'Refund':
										echo 'Payment completed on '.date('m/d/Y h:i A',$invoice['payment_time']). ' and refund on '.date('m/d/Y h:i A',$invoice['refund_date']).'.';
										break;
									case 'Failed':
										echo 'Payment failed '.$invoice['try_amount'].' times and will be processed again on '.date('m/d/Y h:i A',$invoice['try_time']);
										break;
									default:
										echo 'Payment due date is '.date('m/d/Y h:i A',$invoice['try_time']);
										break;
								}
								?>
						  	</div>
						  	<?php } ?>
						  </li>
							<?php }?>
						<?php }else {?>
						  <li class="list-group-item text-center">Please add your credit card to activate your payment system.</li>
						<?php }?>
					</ul>
				</div>
				<?php if($account['membership_due']){ ?>
<!--				<div class="col-md-12"><div class="approvalmessage mb-1">Next payment period of your membership is on <?php echo date('m/d/Y h:i A',$account['membership_due']);?><div><div>-->
				<?php } ?>
			</div>
			</fieldset>
	  </div>
	</div>
	<?php } ?>
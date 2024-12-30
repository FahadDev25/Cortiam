	<form method="POST" class="ajaxform w-100" data-source="formajaxurl">
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
						<input type="text" name="state" id="state" class="form-control" placeholder="State" value="<?php echo $account['state'];?>">
					</div>
				</div>

				<div class="col-md-5">
					<div class="form-group">
						<input type="text" name="city" id="city" class="form-control" placeholder="City" value="<?php echo $account['city'];?>">
					</div>
				</div>

				<div class="col-md-2">
					<div class="form-group">
						<input type="text" name="zipcode" id="zipcode" class="form-control" placeholder="Zip Code" value="<?php echo $account['zipcode'];?>">
					</div>
				</div>
			</div>
			</fieldset>

	  </div>
	  <div class="card-footer text-right">
	  	<button type="submit" class="button-orange">Update Profile</button>
	  </div>
	</div>
	</form>

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
	  	<a href="#" class="deactivateme" data-id="<?php echo $account['seller_id'];?>"><i class="icon-cancel-circle2 mr-2"></i>Remove Account</button>
	  </div>
	</div>
	</form>
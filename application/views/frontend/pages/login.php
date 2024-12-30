<body>
	<!-- Page content -->
	<div class="page-content">
		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Content area -->
			<div class="content d-flex flex-column justify-content-center align-items-center">
				<div id="errorwrap">

				</div>

				<!-- Login form -->
				<form class="login-form" id="logincard">
					<div class="card my-5">
						<div class="card-body">
							<div class="text-center mb-3">
								<h5 class="mb-0">Login to your account</h5>
								<span class="d-block text-muted">Your credentials</span>
							</div>

							<div class="form-group form-group-feedback form-group-feedback-left">
								<input class="form-control" type="email" placeholder="Email" name="lindentity" autocomplete="off" required value="">
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
								</div>
							</div>

							<div class="form-group form-group-feedback form-group-feedback-left">
								<input class="form-control" type="password" placeholder="Password" name="lpassword" required value="">
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
							</div>

							<div class="form-group">
								<button type="submit"  id="logmein" class="btn btn-primary btn-block">Sign in <i class="icon-circle-right2 ml-2"></i></button>
							</div>

							<div class="text-center">
								<a href="#"  id="triggerforgot">Forgot password?</a>
							</div>

							<div class="text-center mt-2">
								Dont have a Cortiam Account? <a href="<?php echo base_url('sign-up');?>">Sign Up Now!</a>
							</div>

							<hr>

							<span class="form-text text-center text-muted content-divider">By continuing, you're confirming that you've read our <a href="#">Terms &amp; Conditions</a> and <a href="#">Cookie Policy</a></span>
						</div>
					</div>
				</form>
				<!-- /login form -->

				<!-- Forgot form -->
				<form class="forgot-form d-none" id="forgotcard">
					<div class="card mb-0">
						<div class="card-body">
							<div class="text-center mb-3">
								<i class="icon-spinner11 icon-2x text-warning border-warning border-3 rounded-round p-3 mb-3 mt-1"></i>
								<h5 class="mb-0">Password recovery</h5>
								<span class="d-block text-muted">Please enter your email to recieve instructions in email</span>
							</div>

							<div class="form-group form-group-feedback form-group-feedback-left">
								<input class="form-control" type="email" placeholder="Email" name="remail" id="kt_email" autocomplete="off" required >
								<div class="form-control-feedback">
									<i class="icon-mail5 text-muted"></i>
								</div>
							</div>

							<div class="form-group">
								<button type="submit" id="forgotmypass" class="btn btn-primary btn-block">Request <i class="icon-circle-right2 ml-2"></i></button>
							</div>

							<div class="text-center">
								<a href="#"  id="triggerlogin">Cancel</a>
							</div>

							<hr>

							<span class="form-text text-center text-muted content-divider">By continuing, you're confirming that you've read our <a href="<?php echo base_url('terms-of-use');?>" target="_blank">Terms &amp; Conditions</a> and <a href="<?php echo base_url('privacy-policy');?>" target="_blank">Cookie Policy</a></span>
						</div>
					</div>
				</form>
				<!-- /forgot form -->

			</div>
			<!-- /content area -->

		</div>
		<!-- /main content-->

	</div>
	<!-- /page content -->
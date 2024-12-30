	<style>
		.get-started{
			position: absolute;
			bottom: 0;
			left: 0;
			right: 0;
			bottom: 13px;
			width: 90%;
		}


		.card-sides{
		height: 100%;
    	border: 1px solid #DAE1E7;
    	padding: 27px;
		border-radius: 5px;
		position: relative;

	}
	.card-sides > h2{
		color: #000;
    	font-weight: 600;
    	text-align: center;
	}
.btn-primary-color{
	background-color: #ff7043;
	border-color: #ff7043;
	color: #fff;
}
.btn-primary-color:hover{
	background-color: #fff;
	color: #ff7043;
}

.minHeight{

	min-height: 400px;
}


.panel-title {
        display: inline;
        font-weight: bold;
        }
        .display-table {
            display: table;
        }
        .display-tr {
            display: table-row;
        }
        .display-td {
            display: table-cell;
            vertical-align: middle;
            width: 100%;
        }

.hide{

	display: none;
}		

.has-error{

	color : red;
}
 .btn-primary-css{
	position: absolute;
	left: 0;
	right: 0;
	width: 85%;
	bottom: 18px;
 }

</style>

	<form method="POST" class="couponform w-100" data-source="formajaxurl">
		<div class="card" id="couponaddpart">
			<div class="card-header header-elements-inline">
				<h3 class="card-title"><span class="icon-co-big orange coupon"></span> Membership Plans</h3>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-sm-12 col-md-8 offset-md-2">
						<div class="form-group">
							<h5 class="col-sm-12">Select a Plan</h5>

							<div class="row">


								<?php
								if (isset($plans) && $plans !== '')
								{
									foreach ($plans as $key => $plan)
									{
								?>
								
										<div class="col-sm-4">
											<div class="card bg-warning border-0 rounded-0 shadow" style="min-height: 500px !important;">
												<div class="card-header text-center text-white border-0 py-1">
														<h5 class="mb-0 font-weight-normal"><strong><?= $plan['title'] ?></strong></h5>
														<h1 class="text-center font-weight-bold text-white mb-0" style="font-size: 34px">$<?= $plan['price'] ?></h1>
														<p><?= $plan['details'] ?></p>
												</div>
											<div class="card-body bg-white">
											<?php 
												  $features = getFeatures($plan['id']);										 
											
											?>

												<ul class="list-unstyled">
													<?php
														foreach ($features as $key => $feature)
														{
													?>		
															<li class="mb-4"><strong><?=  $feature['title'] ?></strong></li>												
													<?php 
														}
													?>
												</ul>
													
													<!-- <p class="small text-center font-weight-bolder text-secondary">per month</p> -->
													<a href="javascript:void(0);" class="btn btn-block bg-warning text-white btn-primary-css mx-auto get-started" data-toggle="modal" data-target="#myModal" data-pice="<?= $plan['price'] ?>" data-id="<?= $plan['id'] ?>">Get Started</a></div>
											</div>
										</div>


								<?php
 									}

								}
								?>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</form>




	
	<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-xl">    
      <!-- Modal content-->
      <div class="modal-content py-4">
		<div class="text-center">
			<h1 class="font-weight-bold text-warning">Membership Plans</h1>
		</div>      
        <div class="modal-body py-3">
			<div class="col-sm-12">
				<div class="row justify-content-center">
				   <div class="row strip-row">
						<div class="col-md-12">
							<div class="panel panel-default credit-card-box">
								<div class="panel-heading display-table" >
									<div class="row display-tr" >
										<h3 class="panel-title display-td" >Payment Details</h3>
										<div class="display-td" >                            
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-credit-card" viewBox="0 0 16 16">
												<path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z"/>
												<path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z"/>
											</svg>
										</div>
									</div>                    
								</div>
								<div class="panel-body">

								<div class="alert alert-success" role="alert" id="payment-notification" style="display:none;">
									This is a success alert—check it out!
								</div>

									<form role="form" method="post" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="<?php echo $this->config->item('stripe_key') ?>"
															id="payment-form">

											<div class='form-row row'>
												<div class='col-lg-12 form-group required'>
													<label class='control-label'>Name on Card</label>
													<input class='form-control' maxlength='150' type='text'>
												</div>
											</div>

											<div class='form-row row'>
												<div class='col-lg-12 form-group card required'>
													<label class='control-label'>Card Number</label> <input
														autocomplete='off' class='form-control card-number' maxlength='20'
														type='text'>
												</div>
                        					</div>



											<div class='form-row row'>
												<div class='col-sm-12 col-md-4 form-group cvc required'>
													<label class='control-label'>CVC</label> <input autocomplete='off'
														class='form-control card-cvc' placeholder='ex. 311' maxlength='4'
														type='text'>
												</div>
												<div class='col-sm-12 col-md-4 form-group expiration required'>
													<label class='control-label'>Expiration Month</label> <input
														class='form-control card-expiry-month' placeholder='MM' maxlength='2'
														type='text'>
												</div>
												<div class='col-sm-12 col-md-4 form-group expiration required'>
													<label class='control-label'>Expiration Year</label> <input
														class='form-control card-expiry-year' placeholder='YYYY' maxlength='4'
														type='text'>
												</div>
											</div>
						
											<div class='form-row row'>
												<div class='col-md-12 error form-group hide'>
													<div class='alert-danger alert'>Please correct the errors and try
														again.</div>
												</div>
											</div>

											<div class="row">
												<div class="col-sm-12">
													<div class="form-group">
														<label class='control-label'>Coupon (20% off)</label>
														<input class="form-control" type="text" readonly name="coupon" id="Coupon" value="<?= random_str(32); ?>" />
														<input class="form-control" type="hidden" readonly name="coupon_percentage" id="coupon_percentage" />
													</div>													
												</div>
											</div>			
						
											<div class="row">
												<div class="col-sm-12">
													<a href="javascript:void(0);" class="btn btn-primary btn-lg btn-block"  id="set-price">Pay Now</a>
													<?php //$paymentCompleted = $this->session->userdata('payment');  ?>										
													

												</div>
											</div>

									</form>					
								</div>		
						</div>
     				</div> 
	
				   </div>
				</div>
			</div>
		</div>
	  </div>
	</div> 		  
	
	</div>

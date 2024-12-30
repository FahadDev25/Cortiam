
<main role="main">
	<div class="agentsignup jumbotron jumbotron-fluid mb-0">
	  <div class="container">
		  <h1 class="headline">REAL ESTATE AGENT</h1><br>
	  </div>
	</div>
	<div class="signup-content text-center">
	  <div class="container">
			<div class="row px-3 px-md-5">
			  <div class="col-md-8 offset-md-2">
					<h3>AGENT SIGN UP</h3>
					<p class="mb-3">You're one step closer to meeting more customers. Fill out this form to create your secure account.</p>
			  </div>
			  <div class="col-md-6 offset-md-3">
			  	<div id="response"></div>
					<form method="POST" id="agentSignupform" class="signupform w-100">
					  <div class="form-group">
					    <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name">
					  </div>
					  <div class="form-group">
					    <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name">
					  </div>
					  <div class="form-group">
					    <input type="email" class="form-control" name="email" id="email" placeholder="Email Address">
					  </div>
					  <div class="form-group">
					    <input type="tel" class="form-control format-phone-number" name="phone" id="phone" placeholder="Phone Number">
					  </div>
						<div class="form-group text-left" id="statecontainer">
							<input type="text" name="state" id="state" class="form-control" placeholder="State">
						</div>
						<div class="form-group text-left" id="citycontainer">
							<input type="text" name="city" id="city" class="form-control" placeholder="City">
						</div>
					  <div class="form-group">
					    <input type="password" class="form-control" name="password" id="password" placeholder="Create Password">
					  </div>
					  <div class="form-group">
					    <input type="password" class="form-control" name="passwordagain" id="passwordagain" placeholder="Repeat Password">
					  </div>

					   <div class="form-group">
  							<a href="javascript:void(0);" id="take_membership_plan" data-toggle="modal" data-target="#myModal">Membership plan</a>
						</div>

						<input type="hidden" id="member_ship_plan" name="member_ship_plan" value="" />

					  <div class="form-group">
					    <input type="submit" class="button-orange" value="SUBMIT">
					  </div>
				  </form>
			  </div>
		  </div>
  	</div>
	</div>
</main>

<style>
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

.strip-row{

	display: none;
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
</style>


<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-xl">    
      <!-- Modal content-->
      <div class="modal-content py-4">
		<div class="text-center">
			<h1 class="font-weight-bold text-warning">Membership Plans</h1>
		</div>      
        <div class="modal-body py-3">
			<div class="col-sm-12">
				<div class="row justify-content-center plane-row">
					
<?php
				if(isset($memberShipPlans) && $memberShipPlans !== '')
				{
					foreach ($memberShipPlans as $key => $plan)
					{
?>					   

						<div class="col-sm-12 col-md-4 mb-4">
							<div class="card-sides minHeight position-relative <?= ($key % 2 == 0) ? "" : "shadow-lg" ?>">

								<h2 class="mb-0 text-center"><?= $plan['title']?></h2>
								<h5 class="text-center font-weight-bold mb-1">  $<?= $plan['price']?>  </h5>
								<p class="text-center"><?= $plan['details']?></p>
								<ul class="list-unstyled">

<?php
								$optionsArray = explode(", ", $plan['options']);
								foreach ($optionsArray as $key1 => $value)
								{
?>
									
										<li class="my-2 py-2 border-bottom"><?= $value ?></li>
<?php
								}

?>																	</ul>

								<div class="text-center mt-4">
									<a href="javascript:void(0);" data-id="<?= $plan['id'] ?>" data-plan="<?= $plan['title'] ?>" class="btn btn-outline-warning d-block w-75 position-absolute bottom-0 mb-2 mx-auto  <?= ($key % 2 == 0) ? ""  : "btn-primary-color" ?> member-card" data-price ="<?= $plan['price']?>" style="bottom:0;left:0;right:0;">
										Get Started
									</a>
								</div>
							</div>
						</div>



<?php					
					}
				}
					
?>
					
				</div>


				<div class="row strip-row">
					<div class="col-md-6 offset-md-3">
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
													<a href="javascript:void(0);" class="btn btn-primary btn-lg btn-block"  id="set-price"></a>
													<?php $paymentCompleted = $this->session->userdata('payment');  ?>

													<?php 

														if(!isset($paymentCompleted) || $paymentCompleted !== 'completed')
														{														
													?>
															<a href="javascript:void(0);" id="goBackBtn" class="btn btn-warning btn-block" onclick="goBack()">Go Back</a>
													</php

														}
													?>
													

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>


 <script>

jQuery(document).ready(function(){



		jQuery(document).on('click', '#set-price', function(){

			let selectedDataPlan = $(this).attr('data-plan');

			$('.member-card').each(function(){ 
       				
				if(selectedDataPlan == $(this).attr('data-plan'))
				{
					$(this).text('Plan Selected');
				}else{

					$(this).text('Get Started');
				}

    		});

			$('form.require-validation').submit();

		});



		$('.card-number').on('keypress change', function (e) {

			var charCode = (e.which) ? e.which : event.keyCode    

			if (String.fromCharCode(charCode).match(/[^0-9]/g))    
				return false;           
			
 			$(this).val(function (index, value) {
		
				return value.replace(/\W/gi, '').replace(/(.{4})/g, '$1 ');
  			});
		});


		var $form         = $(".require-validation");
	  $('form.require-validation').submit(function(e) {



		var $form         = $(".require-validation"),
			inputSelector = ['input[type=email]', 'input[type=password]',
							 'input[type=text]', 'input[type=file]',
							 'textarea'].join(', '),
			$inputs       = $form.find('.required').find(inputSelector),
			$errorMessage = $form.find('div.error'),
			valid         = true;
			$errorMessage.addClass('hide');
	 
			$('.has-error').removeClass('has-error');
		$inputs.each(function(i, el) {
		  var $input = $(el);
		  if ($input.val() === '') {
			$input.parent().addClass('has-error');
			$errorMessage.removeClass('hide');
			e.preventDefault();
		  }
		});
		 
		if (!$form.data('cc-on-file')) {
		  e.preventDefault();
		  Stripe.setPublishableKey($form.data('stripe-publishable-key'));
		  Stripe.createToken({
			number: $('.card-number').val(),
			cvc: $('.card-cvc').val(),
			exp_month: $('.card-expiry-month').val(),
			exp_year: $('.card-expiry-year').val()
		  }, stripeResponseHandler);
		}
		
	  });
		  
	  function stripeResponseHandler(status, response) {
			if (response.error) {
				$('.error')
					.removeClass('hide')
					.find('.alert')
					.text(response.error.message);
			} else {
				var token = response['id'];
				$form.find('input[type=text]').empty();
				$form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");

			

			jQuery.ajax({
				type: "post",
				url: cortiamajax.paymentajaxurl,
				data: { email : 'abaig4325@gmail.com', token : token},
				dataType: "json",
				success: function(response){

				if(response.success)
				{
					$('#payment-notification').css('display', 'block');
					$('#payment-notification').text(response.success);
	

					// $('#email').val('');
					// $('#email').focus();
					// jQuery('#response').html('');
					// jQuery('#response').html('<div class="alert bg-danger text-white alert-styled-left alert-dismissible"><button type="button" class="close" data-dismiss="alert"><span>×</span></button><span class="font-weight-semibold">'+response.messsage+'</span></div>');
					// jQuery('.signupform').unblock();

					let title =	$('#set-price').attr('data-plan');

					setTimeout(function () {
							$('#payment-notification').css('display', 'none');
							$form[0].reset();
							$("#myModal").modal('hide');


						swal.fire({
							title: title,
							text: title + " plan selected successfully!",
							type: "success",
							confirmButtonClass: "btn btn-secondary"
						});

						goBack();

							

						$('#take_membership_plan').text(title + " plan selected");
					}, 3000);					


					return false;	
				}					

			}
		});
				
			}
		}
		 
	});


 function goBack()
 {
	$('.plane-row').show();
    $('.strip-row').hide();

 }
	
</script>
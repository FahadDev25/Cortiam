 	<?php if(@in_array($property['property_id'], $win_properties)){ ?>
	<div class="card" id="couponlistpart">
	  <div class="card-header header-elements-inline">
			<h3 class="card-title"><span class="icon-co-big orange license"></span> Property Owner Details</h3>
	  </div>
	  <div class="card-body">
			<div class="row whitedetails">
				<div class="col-md-4"><strong>Full Name</strong><br><?php echo $property['first_name'].' '.$property['last_name'];?></div>
				<div class="col-md-4"><strong>Email Address</strong><br><a href="mailto:<?php echo $property['email'];?>" class="text-dark"><?php echo $property['email'];?></a></div>
				<div class="col-md-4"><strong>Phone Number</strong><br><a href="tel:<?php echo preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1-$2-$3', $property['phone']);?>" class="text-dark"><?php echo preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1-$2-$3', $property['phone']);?></a></div>
			</div>
		</div>
	  <div class="card-footer text-center buttonsrow">
			<a href="<?php echo cortiam_base_url('view-messages/').$property['seller_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $property['first_name'].' '.$property['last_name'])), 'underscore', true);?>" class="button-border-gray text-center">CLICK HERE TO MESSAGE SELLER</a>
		</div>
	</div>
	<?php } ?>
	<div class="card" id="couponlistpart">
	  <div class="card-header header-elements-inline">
			<h3 class="card-title"><span class="icon-co-big orange house"></span> Listing</h3>
	  </div>
	  <div class="card-body">
			<div class="row">
				<div class="propertyslider">
					<div id="PropertyImages"  class="carousel slide carousel-fade w-100 p-0" data-ride="carousel">
						<div class="carousel-inner">
						<?php echo ($property['front_image'])? '<a href="'.base_url($property['front_image']).'" class="carousel-item active" data-toggle="lightbox" data-gallery="gallery"><img src="'.base_url($property['front_image']).'" class="d-block w-100"></a>':'';?>
						<?php echo ($property['rear_image'])? '<a href="'.base_url($property['rear_image']).'" class="carousel-item" data-toggle="lightbox" data-gallery="gallery"><img src="'.base_url($property['rear_image']).'" class="d-block w-100"></a>':'';?>
						<?php echo ($property['left_image'])? '<a href="'.base_url($property['left_image']).'" class="carousel-item" data-toggle="lightbox" data-gallery="gallery"><img src="'.base_url($property['left_image']).'" class="d-block w-100"></a>':'';?>
						<?php echo ($property['right_image'])? '<a href="'.base_url($property['right_image']).'" class="carousel-item" data-toggle="lightbox" data-gallery="gallery"><img src="'.base_url($property['right_image']).'" class="d-block w-100"></a>':'';?>
						</div>
					  <a class="carousel-control-prev" href="#PropertyImages" role="button" data-slide="prev">
					    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
					    <span class="sr-only">Previous</span>
					  </a>
					  <a class="carousel-control-next" href="#PropertyImages" role="button" data-slide="next">
					    <span class="carousel-control-next-icon" aria-hidden="true"></span>
					    <span class="sr-only">Next</span>
					  </a>
					</div>
				</div>
			</div>
			<div class="row">
				<?php if(@in_array($property['property_id'], $win_properties)){ ?>
					<div class="col-md-12 orange-address-bar">ADDRESS: <?php echo strtoupper((($property['unit'])? $property['unit'].' ':'').$property['address'].' - '.$property['city'].', '.$property['state'].', '.$property['zipcode']);?></div>
				<?php }else{ ?>
					<div class="col-md-12 orange-address-bar">ADDRESS: <?php echo strtoupper($property['city'].', '.$property['state']);?></div>
				<?php } ?>
			</div>
			<div class="row rateandtime border-bottom">
				<div class="col-md-4"><strong>Commission Rate:</strong><br><?php echo $property['commission_rate'];?>%</div>
				<div class="col-md-4"><strong>Length of Contract:</strong><br><?php echo $property['contract_length'];?> Months</div>
				<div class="col-md-4"><strong>Approximate Value:</strong><br>$<?php echo number_format($property['approx_value'],2);?></div>
			</div>
			<div class="row gray-type-bar">
				<div class="col-md-12"><?php echo strtoupper($property['type'].' - '.$property['sub_type']);?></div>
			</div>
			<div class="row rateandtime border-bottom">
				<div class="col-md-4"><strong>Build Year:</strong><br><?php echo $property['built_date'];?></div>
				<div class="col-md-4"><strong>Land Size:</strong><br><?php echo $property['land_size'];?> sqft.</div>
				<div class="col-md-4"><strong>Building Size:</strong><br><?php echo $property['building_size'];?> sqft.</div>
			</div>
			<?php
			if ($property['winning_fee']) {
				 $fee_amount = $property['winning_fee'];
			}elseif ($account['win_cost']) {
				 $fee_amount = $account['win_cost'];
			}else{
				$fee_amount = $property['win_fee'];
			}
			?>
			<?php if($property['type'] == 'Residential'){ ?>
			<div class="row graydetails border-bottom">
				<div class="col-md-4"><strong>Bedroom:</strong><br><?php echo $property['bedroom'];?></div>
				<div class="col-md-4"><strong>Bathroom:</strong><br><?php echo $property['bathroom'];?></div>
				<div class="col-md-4"><strong>Fee:</strong><br>$<?php echo number_format($fee_amount,2);?></div>
			</div>
			<?php }else{ ?>
			<div class="row graydetails border-bottom">
				<div class="col-md-12"><strong>Fee:</strong><br>$<?php echo number_format($fee_amount,2);?></div>
			</div>
			<?php } ?>

	  	<?php if ($proposal_status) {?>
			<div class="row my-2" id="proposedetails">
				<div class="alert alert-info mb-0 w-100 text-center" role="alert"><?php echo (($proposal_status['prop_from'] == 'Agent')? 'You sent an introduction for the above property on':'Property owner for the above property counter offered to you on');?> <?php echo date('m/d/Y h:i:s A', $proposal_status['prop_date'])?>.<br>Please click <a href="<?php echo cortiam_base_url('view-proposal/').$proposal_status['prop_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $proposal_status['city'].' '.$proposal_status['state'])), 'underscore', true);?>">here</a> for the details of the proposal.</div>
			</div>
	  	<?php }?>
	  </div>
	  <div class="card-footer text-center buttonsrow">
		<?php
			
			$total_amount =  $property['approx_value'] + $fee_amount;

			if($total_amount <= $amount_limit)
			{
		?>
				<div class="alert alert-success mb-0 w-100 text-center" role="alert">You can win property/properties you having enough monthly Amount.</div>
				<br>			  
		<?php
					
			}else{
		?>
			  	<div class="alert alert-info mb-0 w-100 text-center" role="alert">Your selected Monthly Amount is low, you can not send more introductions or connects</div>
				<br>
		<?php
			}
		?>

			
	  	<a href="#" class="button-orange" id="saveproperty" data-value="<?php echo ($save_status)? 'unsave':'save';?>"><?php echo ($save_status)? 'UNSAVE':'SAVE';?></a>
		<?php if(((($proposal_status['status'] == 'Unread') || ($proposal_status['status'] == 'Read')) && ($proposal_status['prop_from'] == 'Agent')) && ($account['active'] == 1) && ($account['approval'] == 'Completed')){ ?><a href="#" class="button-dark" id="withdrawproposal" data-prop="<?php echo $proposal_status['prop_id'];?>">WITHDRAW</a><?php } ?>

		<?php
			if($total_amount <= $amount_limit)
			{

     	?>				
	  		  <?php if((!$proposal_status) && ($account['offer_remain'] > 0) && ($account['active'] == 1) && ($account['approval'] == 'Completed')){ ?><a href="#" class="button-dark" id="expressproperty">INTRODUCTION</a><?php } ?>
	  		  <?php if((!$proposal_status) && ($account['offer_remain'] > 0) && ($account['active'] == 1) && ($account['approval'] == 'Completed')){ ?><a href="#" class="button-border-orange" id="counterofferproperty">COUNTER OFFER</a><?php } ?>
	    <?php
			}
		?>	


	  		
	  </div>
	</div>
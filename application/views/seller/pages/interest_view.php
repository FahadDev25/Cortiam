 		<div class="card mb-3" id="couponlistpart">
		  <div class="card-header header-elements-inline">
					<h3 class="card-title"><span class="icon-co-big orange talk"></span> <?php echo (($proposal['prop_from'] == 'Agent')? $agent_account['first_name'].' '.$agent_account['last_name'].'\'s':'Your');?> Proposal</h3>
					<?php echo generate_seller_proposal_ribbon($proposal['prop_from'],$proposal['status'],$proposal['first_counter'], 'right',$proposal['main_id']);?>
					<div class="header-elements">
					</div>
		  </div>
		  <div class="card-body">
		  	<div class="row">
		  		<div class="col-md-12 py-3 px-lg-3 px-xl-3 dark-bg profile-header">
		  			<?php echo (($agent_account['approval'] != 'Completed')? '<div class="ribbon ribbon-top-left ribbonred"><span>Inactive</span></div>':'');?>
		  			<img class="img-fluid rounded-circle user-avatar float-left mr-3" src="<?php echo (($agent_account['avatar_string'])? base_url($agent_account['avatar_string']):base_url('images/userphoto.jpg'));?>" width="120" height="120">
		  			<h3 class="mt-4 mb-0"><strong><?php echo $agent_account['first_name'].' '.$agent_account['last_name'];?></strong></h3>
		  			<h6><?php echo $agent_account['brokerage_name'];?></h6>
		  			<div class="messagebutton">
		  				<?php if(in_array($proposal['status'], array('Unread','Read')) && $proposal['prop_from'] == 'Agent') { ?>
							<button class="button-border-orange smallerbutton acceptproposal">ACCEPT</button>
							<button class="button-border-gray smallerbutton declineproposal">DECLINE</button>
							<button class="button-border-white smallerbutton counterofferproposal">COUNTER OFFER</button>
		  				<?php } ?>
		  			</div>
		  		</div>
		  		<div class="col-md-12 mt-3 px-lg-3 px-xl-3">
		  			<h5 class="mb-0"><strong>Biography</strong></h5>
		  			<?php echo nl2br($agent_account['bio']);?>
		  		</div>
	  			<?php if($agent_account['estate_specialization']) {?>
		  		<div class="col-md-12 mt-3 px-lg-3 px-xl-3">
		  			<h5 class="mb-0"><strong>Real Estate Specialization</strong></h5>
		  			<?php echo nl2br($agent_account['estate_specialization']);?>
		  		</div>
					<?php } ?>
					<?php if($agent_licenses) {?>
		  		<div class="col-md-7 mt-3 px-lg-3 px-xl-3">
		  			<h5 class="mb-0"><strong>Real Estate Focus</strong></h5>
						<?php foreach ($agent_licenses as $agent_license) { ?>
					  	<?php echo (($agent_license['interested'] == 'Both')? 'Residential & Commercial':$agent_license['interested']);?> Properties in <?php echo $agent_license['license_state'];?><br>
						<?php }?>
		  		</div>
					<?php }else{?>
					<div class="col-md-7 mt-3 px-lg-3 px-xl-3"></div>
					<?php }?>
		  		<div class="col-md-5 mt-3 px-lg-3 px-xl-3">
		  			<h5 class="mb-0"><strong>Years Experience</strong></h5>
		  			<?php echo (date("Y") - $agent_account['experience']);?>
		  		</div>
		  		<div class="col-md-12 mt-3 px-lg-3 px-xl-3">
		  			<h5 class="mb-0"><strong>Brokerage Address</strong></h5>
		  			<?php echo $agent_account['brokerage_address'].' '.$agent_account['brokerage_unit'].', '.$agent_account['brokerage_city'].', '.$agent_account['brokerage_state'].' '.$agent_account['brokerage_zipcode'];?>
		  		</div>
		  		<div class="col-md-7 mt-3 px-lg-3 px-xl-3">
		  			<h5 class="mb-0"><strong>Brokerage Phone Number</strong></h5>
		  			<a href="tel:<?php echo preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1-$2-$3', $agent_account['brokerage_phone']);?>" class="text-dark"><?php echo preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1-$2-$3', $agent_account['brokerage_phone']);?></a>
		  		</div>
		  		<div class="col-md-5 mt-3 px-lg-3 px-xl-3">
		  			<h5 class="mb-0"><strong>Email</strong></h5>
		  			<a href="mailto:<?php echo $agent_account['email'];?>" class="text-dark"><?php echo $agent_account['email'];?></a>
		  		</div>
		  		<div class="col-md-7 mt-3 px-lg-3 px-xl-3">
		  			<?php if($agent_account['youtube_video']) {?>
		  			<?php preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $agent_account['youtube_video'], $match);?>
			  		<div class="embed-responsive embed-responsive-16by9">
				  		<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $match[1];?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
						</div>
						<?php } ?>
		  		</div>
		  		<div class="col-md-5 mt-3 px-lg-3 px-xl-3">
		  			<?php if($agent_account['facebook']) {?><div class="my-2"><a href="<?php echo $agent_account['facebook'];?>" target="_blank" class="text-gray"><span class="icon-co-sm orange facebook"></span> <?php echo $agent_account['facebook'];?></a></div><?php } ?>
		  			<?php if($agent_account['linkedin']) {?><div class="my-2"><a href="<?php echo $agent_account['linkedin'];?>" target="_blank" class="text-gray"><span class="icon-co-sm orange linkedin"></span> <?php echo $agent_account['linkedin'];?></a></div><?php } ?>
		  			<?php if($agent_account['twitter']) {?><div class="my-2"><a href="<?php echo $agent_account['twitter'];?>" target="_blank" class="text-gray"><span class="icon-co-sm orange twitter"></span> <?php echo $agent_account['twitter'];?></a></div><?php } ?>
		  			<?php if($agent_account['google']) {?><div class="my-2"><a href="<?php echo $agent_account['google'];?>" target="_blank" class="text-gray"><span class="icon-co-sm orange google"></span> <?php echo $agent_account['google'];?></a></div><?php } ?>
		  			<?php if($agent_account['instagram']) {?><div class="my-2"><a href="<?php echo $agent_account['instagram'];?>" target="_blank" class="text-gray"><span class="icon-co-sm orange instagram"></span> <?php echo $agent_account['instagram'];?></a></div><?php } ?>
		  		</div>
		  	</div>
		  </div>
	  </div>

 		<div class="card previous_offer">
		  <div class="card-header">
		  	<h5 class="m-0">
		  	<span class="icon-co-sm envelope"></span> Your Initial Offer on <?php echo date('Y/m/d \a\t h:i:s A',$property['created_on']);?>
		  	</h5>
		  </div>
		  <div class="card-body p-0">
		  	<div class="container-fluid">
			  	<div class="row">
			  		<div class="col-md-6 py-2 text-center dark-bg">
			  			<strong>Commission Rate:</strong>
			  			<p class="mb-0"><?php echo $property['commission_rate'];?>%</p>
			  		</div>
			  		<div class="col-md-6 py-2 text-center dark-bg">
			  			<strong>Length of Contract:</strong>
			  			<p class="mb-0"><?php echo $property['contract_length'];?> Months</p>
			  		</div>
		  		</div>
		  	</div>
		  </div>
	  </div>
		<div class="down_arrow"></div>

		<?php if($related_proposals){ ?>
			<?php	foreach ($related_proposals as $related_proposal) {	?>
			 		<div class="card previous_offer">
					  <div class="card-header">
					  	<h5 class="m-0">
					  	<span class="icon-co-sm envelope"></span> <?php echo (($related_proposal['prop_from'] == 'Agent')? 'Agents':'Your');?> Offer on <?php echo date('Y/m/d \a\t h:i:s A',$related_proposal['prop_date']);?>
					  	</h5>
					  </div>
					  <div class="card-body pt-0">
					  	<div class="container-fluid">
						  	<div class="row">
						  		<div class="col-md-6 py-2 text-center dark-bg">
						  			<strong>Commission Rate:</strong>
						  			<p class="mb-0"><?php echo $related_proposal['commission_rate'];?>%</p>
						  		</div>
						  		<div class="col-md-6 py-2 text-center dark-bg">
						  			<strong>Length of Contract:</strong>
						  			<p class="mb-0"><?php echo $related_proposal['contract_length'];?> Months</p>
						  		</div>
						  		<div class="col-md-12 mt-2 px-lg-2 px-xl-2">
						  			<strong><?php echo (($related_proposal['prop_from'] == 'Agent')? 'Agent':'Your');?> Terms:</strong>
						  			<p><?php echo $related_proposal['prop_text'];?></p>
						  		</div>
					  		</div>
					  	</div>
					  </div>
				  </div>
					<div class="down_arrow"></div>
			<?php }?>
		<?php }?>

 		<div class="card">
		  <div class="card-header">
		  	<h5 class="m-0 text-center">
		  	<span class="icon-co-sm envelope"></span> <?php echo (($proposal['prop_from'] == 'Agent')? 'Agents':'Your');?> Latest Offer on <?php echo date('Y/m/d \a\t h:i:s A',$proposal['prop_date']);?>
		  	</h5>
		  </div>
		  <div class="card-body pt-0">
		  	<div class="row">
		  		<div class="col-md-6 mt-3 py-2 text-center red-bg">
		  			<strong>Commission Rate:</strong>
		  			<p class="mb-0"><?php echo $proposal['commission_rate'];?>%</p>
		  		</div>
		  		<div class="col-md-6 mt-3 py-2 text-center red-bg">
		  			<strong>Length of Contract:</strong>
		  			<p class="mb-0"><?php echo $proposal['contract_length'];?> Months</p>
		  		</div>
		  		<div class="col-md-12 mt-3 px-lg-3 px-xl-3">
		  			<strong><?php echo (($proposal['prop_from'] == 'Agent')? 'Agent':'Your');?> Terms:</strong>
		  			<p><?php echo $proposal['prop_text'];?></p>
		  		</div>
	 				<?php if(in_array($proposal['status'], array('Unread','Read')) && $proposal['prop_from'] == 'Agent') { ?>
		  		<div class="col-md-12 mt-1 px-lg-3 px-xl-3 text-center buttonsrow">
					  <button class="button-border-orange smallerbutton text-center mr-3 acceptproposal">ACCEPT THIS OFFER</button>
					  <button class="button-border-dark smallerbutton text-center mr-3 declineproposal">DECLINE THIS OFFER</button>
					  <button class="button-border-gray smallerbutton text-center counterofferproposal">COUNTER OFFER</button>
		  		</div>
  				<?php }elseif(in_array($proposal['status'], array('Unread','Read','Countered')) && $proposal['prop_from'] == 'Seller') { ?>
		  		<div class="col-md-12 mt-1 px-lg-3 px-xl-3 text-center buttonsrow">
		  			<button class="button-dark text-center mr-3 withdrawproposal" data-prop="<?php echo $proposal['prop_id'];?>">WITHDRAW</button>
		  		</div>
  				<?php } ?>
		  	</div>
		  </div>
	  </div>
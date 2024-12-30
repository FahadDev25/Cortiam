 		<div class="card">
		  <div class="card-header header-elements-inline">
					<h3 class="card-title"><span class="icon-co-big orange agent"></span> Agent Profiles</h3>
					<div class="header-elements">
					</div>
					<?php if(!$agent_licenses) {?><div class="ribbon ribbon-top-right ribbonred"><span>Inactive</span></div><?php } ?>
		  </div>
		  <div class="card-body">
		  	<div class="row">
		  		<div class="col-md-12 py-3 px-lg-3 px-xl-3 dark-bg profile-header">
		  			<img class="img-fluid rounded-circle user-avatar float-left mr-3" src="<?php echo (($agent_account['avatar_string'])? base_url($agent_account['avatar_string']):base_url('images/userphoto.jpg'));?>" width="120" height="120">
		  			<h3 class="mt-4 mb-0"><strong><?php echo $agent_account['first_name'].' '.$agent_account['last_name'];?></strong></h3>
		  			<h6><?php echo $agent_account['brokerage_name'];?></h6>
		  			<div class="messagebutton">
							<a href="<?php echo cortiam_base_url('edit-account');?>" class="button-border-white smallerbutton sendmessagebutton">Send Message</a>
							<?php if($favorite_status){ ?>
								<a href="<?php echo cortiam_base_url('edit-account');?>" class="button-border-white smallerbutton favoritebutton" data-type="remove"><i class="icon-heart-broken2"></i></a>
							<?php }else{ ?>
								<a href="<?php echo cortiam_base_url('edit-account');?>" class="button-border-white smallerbutton favoritebutton" data-type="add"><i class="icon-heart5"></i></a>
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
		  			<?php echo (($agent_account['brokerage_unit'])? $agent_account['brokerage_unit'].' ':'').$agent_account['brokerage_address'].', '.$agent_account['brokerage_city'].', '.$agent_account['brokerage_state'].', '.$agent_account['brokerage_zipcode'];?>
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
		  		<div>
		  		</div>
		  	</div>
		  </div>
	  </div>
	  <?php if ($agent_proposals) { ?>
	  	<?php foreach ($agent_proposals as $agent_proposal) { ?>
 		<div class="card">
		  <div class="card-header header-elements-inline">
					<h3 class="card-title"><?php echo strtoupper((($agent_proposal['unit'])? $agent_proposal['unit'].' ':'').$agent_proposal['address'].', '.$agent_proposal['city'].', '.$agent_proposal['state'].', '.$agent_proposal['zipcode']);?></h3>
					<?php echo generate_seller_proposal_ribbon($agent_proposal['prop_from'],$agent_proposal['status'],$agent_proposal['first_counter'], 'right',$agent_proposal['main_id']);?>
					<div class="header-elements"></div>
		  </div>
		  <div class="card-body">
		  	<div class="row">
		  		<div class="col-md-3"><img class="img-fluid" src="<?php echo base_url($agent_proposal['default_image']);?>"></div>
		  		<div class="col-md-9">
						<div class="row no-gutters">
							<div class="col-md-6 py-2 text-center dark-bg">
								<strong>Commission Rate:</strong>
								<p class="mb-0"><?php echo $agent_proposal['commission_rate'];?>%</p>
							</div>
							<div class="col-md-6 py-2 text-center dark-bg">
								<strong>Length of Contract:</strong>
								<p class="mb-0"><?php echo $agent_proposal['contract_length'];?> Months</p>
							</div>
							<?php if ($agent_proposal['prop_text']) {?>
							<div class="col-md-12 mt-2">
								<strong>Agent Terms:</strong>
								<p><?php echo $agent_proposal['prop_text'];?></p>
							</div>
							<?php } ?>
				  	</div>
		  		</div>
		  	</div>
		  </div>
		  <div class="card-footer">
				<?php if(in_array($agent_proposal['status'], array('Unread','Read'))) { ?>
				<div class="col-md-12 mt-1 px-lg-3 px-xl-3 text-center buttonsrow">
				  <button class="button-border-orange smallerbutton text-center mr-3 acceptproposal" data-prop="<?php echo $agent_proposal['prop_id'];?>">ACCEPT THIS OFFER</button>
				  <button class="button-border-dark smallerbutton text-center mr-3 declineproposal" data-prop="<?php echo $agent_proposal['prop_id'];?>">DECLINE THIS OFFER</button>
				  <button class="button-border-gray smallerbutton text-center counterofferproposal" data-prop="<?php echo $agent_proposal['prop_id'];?>">COUNTER OFFER</button>
				</div>
				<?php } ?>
		  </div>
	  </div>
	  	<?php } ?>
	  <?php } ?>
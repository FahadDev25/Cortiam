		<div class="card">
		  <div class="card-header header-elements-inline">
				<h3 class="card-title"><span class="icon-co-big orange write"></span> Proposals</h3>
		  </div>
		  <div class="card-body">

				<div class="row" id="responsewaitprops">
					<div class="col-md-12"><div class="gray-bg w-100 p-2"><h3 class="m-0">Response Waiting Proposal</h3></div></div>
			  <?php if($waiting_proposals){ ?>
				  <?php
				  foreach ($waiting_proposals as $proposal) {
				  ?>
				  <?php $current_prop_id = $proposal['property_id']; ?>
				  <?php $proposal_purl = cortiam_base_url('view-proposal/').$proposal['prop_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $proposal['city'].' '.$proposal['state'])), 'underscore', true); ?>
				  <?php $purl = cortiam_base_url('view-property/').$proposal['property_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $proposal['city'].' '.$proposal['state'])), 'underscore', true); ?>

					  <div class="col-md-6 col-lg-4" id="props-<?php echo $proposal['prop_id'];?>">
							<a href="<?php echo $proposal_purl;?>" class="card proplisting mb-2 <?php echo ($proposal['status'] == 'Unread')? 'animated bounce':'';?>">
								<?php echo generate_agent_proposal_ribbon($proposal['prop_from'],$proposal['status'],'left',$proposal['main_id']);?>
							  <img class="card-img-top" src="<?php echo base_url($proposal['default_image']);?>" alt="Listing Image">
							  <div class="card-body orange-bg px-2">
							    <span class="float-left"><b><?php echo $proposal['type'];?></b></span>
							    <small class="float-right"><?php echo $proposal['building_size'];?> sqft.</small>
							  </div>
							  <div class="card-footer addresspart p-2">
								  <strong>Commission Rate:</strong><p><?php echo $proposal['commission_rate'];?>%</p>
								  <strong>Contract Length:</strong><p><?php echo $proposal['contract_length'];?> Months</p>
							  </div>
								<?php
								if ($proposal['winning_fee']) {
									 $fee_amount = $proposal['winning_fee'];
								}elseif ($account['win_cost']) {
									 $fee_amount = $account['win_cost'];
								}else{
									$fee_amount = $property['win_fee'];
								}
								?>
							  <small class="winfee">Fee: $<?php echo number_format($fee_amount,2);?></small>
							</a>
						  <?php if($proposal['prop_from'] == 'Seller'){ ?>
							<div class="px-2">
							  <button class="button-orange smallerbutton text-center float-left acceptproposal" data-prop="<?php echo $proposal['prop_id'];?>">ACCEPT</button>
							  <button class="button-gray smallerbutton text-center float-right declineproposal" data-prop="<?php echo $proposal['prop_id'];?>">DECLINE</button>
							  <button class="button-border-gray w-100 smallerbutton text-center float-right mt-2 counterofferproposal" data-prop="<?php echo $proposal['prop_id'];?>">COUNTER OFFER</button>
							  <a class="button-underline-gray w-100 smallerbutton text-center mt-2" href="<?php echo $purl;?>">View Property Page</a>
							</div>
						  <?php }else{ ?>
							<div class="px-2">
							  <button class="button-orange smallerbutton text-center float-left button-disabled">ACCEPT</button>
							  <button class="button-gray smallerbutton text-center float-right button-disabled">DECLINE</button>
							  <button class="button-dark w-100 smallerbutton text-center float-right mt-2 withdrawproposal" data-prop="<?php echo $proposal['prop_id'];?>">WITHDRAW</button>
							  <a class="button-underline-gray w-100 smallerbutton text-center mt-2" href="<?php echo $purl;?>">View Property Page</a>
							</div>
						  <?php } ?>
					  </div>

			  	<?php } ?>
			  <?php }else{ ?>
		  		<div class="col-md-12"><p class="text-center py-3 p-sm-5">Currently you do not have any response waiting proposals.</p></div>
			  <?php } ?>
		  	</div>
		  	<hr>
				<div class="row">
					<div class="col-md-12"><div class="gray-bg w-100 p-2"><h3 class="m-0">Accepted Proposal</h3></div></div>
			  <?php if($accepted_proposals){ ?>
				  <?php
				  foreach ($accepted_proposals as $proposal) {
				  ?>
				  <?php $current_prop_id = $proposal['property_id']; ?>
				  <?php $proposal_purl = cortiam_base_url('view-proposal/').$proposal['prop_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $proposal['city'].' '.$proposal['state'])), 'underscore', true); ?>
				  <?php $purl = cortiam_base_url('view-property/').$proposal['property_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $proposal['city'].' '.$proposal['state'])), 'underscore', true); ?>

					  <div class="col-md-6 col-lg-4" id="props-<?php echo $proposal['prop_id'];?>">
							<a href="<?php echo $proposal_purl;?>" class="card proplisting mb-2 <?php echo (in_array($proposal['status'], array('Countered','Declined')))? 'grayout':'';?> <?php echo ($proposal['status'] == 'Unread')? 'animated bounce':'';?>">
								<?php echo generate_agent_proposal_ribbon($proposal['prop_from'],$proposal['status'],'left',$proposal['main_id']);?>
							  <img class="card-img-top" src="<?php echo base_url($proposal['default_image']);?>" alt="Listing Image">
							  <div class="card-body orange-bg px-2">
							    <span class="float-left"><b><?php echo $proposal['type'];?></b></span>
							    <small class="float-right"><?php echo $proposal['building_size'];?> sqft.</small>
							  </div>
							  <div class="card-footer addresspart p-2">
								  <strong>Commission Rate:</strong><p><?php echo $proposal['commission_rate'];?>%</p>
								  <strong>Contract Length:</strong><p><?php echo $proposal['contract_length'];?> Months</p>
							  </div>
								<?php
								if ($proposal['winning_fee']) {
									 $fee_amount = $proposal['winning_fee'];
								}elseif ($account['win_cost']) {
									 $fee_amount = $account['win_cost'];
								}else{
									$fee_amount = $property['win_fee'];
								}
								?>
							  <small class="winfee">Fee: $<?php echo number_format($fee_amount,2);?></small>
							</a>
							<div class="px-2">
							  <button class="button-orange smallerbutton button-disabled text-center float-left">ACCEPT</button>
							  <button class="button-gray smallerbutton button-disabled text-center float-right">DECLINE</button>
							  <button class="button-border-gray w-100 smallerbutton button-disabled text-center float-right mt-2">COUNTER OFFER</button>
							  <a class="button-underline-gray w-100 smallerbutton text-center mt-2" href="<?php echo $purl;?>">View Property Page</a>
							</div>
					  </div>

			  	<?php } ?>
			  <?php }else{ ?>
		  		<div class="col-md-12"><p class="text-center py-3 p-sm-5">Currently you do not have any accepted proposals.</p></div>
			  <?php } ?>
		  	</div>
		  	<hr>
				<div class="row">
					<div class="col-md-12"><div class="gray-bg w-100 p-2"><h3 class="m-0">Declined Proposals </h3></div></div>
			  <?php if($declined_proposals){ ?>
				  <?php
				  foreach ($declined_proposals as $proposal) {
				  ?>
				  <?php $current_prop_id = $proposal['property_id']; ?>
				  <?php $proposal_purl = cortiam_base_url('view-proposal/').$proposal['prop_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $proposal['city'].' '.$proposal['state'])), 'underscore', true); ?>
				  <?php $purl = cortiam_base_url('view-property/').$proposal['property_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $proposal['city'].' '.$proposal['state'])), 'underscore', true); ?>

					  <div class="col-md-6 col-lg-4" id="props-<?php echo $proposal['prop_id'];?>">
							<a href="<?php echo $proposal_purl;?>" class="card proplisting mb-2 <?php echo (in_array($proposal['status'], array('Countered','Declined')))? 'grayout':'';?> <?php echo ($proposal['status'] == 'Unread')? 'animated bounce':'';?>">
								<?php echo generate_agent_proposal_ribbon($proposal['prop_from'],$proposal['status'],'left',$proposal['main_id']);?>
							  <img class="card-img-top" src="<?php echo base_url($proposal['default_image']);?>" alt="Listing Image">
							  <div class="card-body orange-bg px-2">
							    <span class="float-left"><b><?php echo $proposal['type'];?></b></span>
							    <small class="float-right"><?php echo $proposal['building_size'];?> sqft.</small>
							  </div>
							  <div class="card-footer addresspart p-2">
								  <strong>Commission Rate:</strong><p><?php echo $proposal['commission_rate'];?>%</p>
								  <strong>Contract Length:</strong><p><?php echo $proposal['contract_length'];?> Months</p>
							  </div>
								<?php
								if ($proposal['winning_fee']) {
									 $fee_amount = $proposal['winning_fee'];
								}elseif ($account['win_cost']) {
									 $fee_amount = $account['win_cost'];
								}else{
									$fee_amount = $property['win_fee'];
								}
								?>
							  <small class="winfee">Fee: $<?php echo number_format($fee_amount,2);?></small>
							</a>
							<div class="px-2">
							  <button class="button-orange smallerbutton button-disabled text-center float-left">ACCEPT</button>
							  <button class="button-gray smallerbutton button-disabled text-center float-right">DECLINE</button>
							  <button class="button-border-gray w-100 smallerbutton button-disabled text-center float-right mt-2">COUNTER OFFER</button>
							  <a class="button-underline-gray w-100 smallerbutton text-center mt-2" href="<?php echo $purl;?>">View Property Page</a>
							</div>
					  </div>

			  	<?php } ?>
			  <?php }else{ ?>
		  		<div class="col-md-12"><p class="text-center py-3 p-sm-5">Currently you do not have any declined proposals.</p></div>
			  <?php } ?>
		  	</div>

	  </div>
	  <div class="card-footer"></div>
	</div>
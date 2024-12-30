		<div class="card">
		  <div class="card-header header-elements-inline">
				<h3 class="card-title"><span class="icon-co-big orange talk"></span> Agents Expressing Interest</h3>
		  </div>
		  <div class="card-body">
				<div class="row">
			  <?php if($proposals){ ?>
			  <?php
			  $current_prop_id = null;
			  foreach ($proposals as $proposal) {
			  ?>

			  <?php if($current_prop_id != $proposal['property_id']){ ?>
			  <?php if($current_prop_id){ ?>
		  	</div>
					  <hr>
				<div class="row">
			  <?php }  ?>
					<div class="col-md-12"><div class="gray-bg w-100 p-2"><h5 class="m-0"><span class="icon-co-sm gray proposal"></span> <?php echo $proposal['type'].' Property  at '.(($proposal['unit'])? $proposal['unit'].' ':'').$proposal['address'].' '.$proposal['city'].', '.$proposal['state'].', '.$proposal['zipcode'];?></h5></div></div>
			  <?php }  ?>
			  <?php $current_prop_id = $proposal['property_id']; ?>
			  <?php $proposal_purl = cortiam_base_url('view-interest/').$proposal['prop_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $proposal['first_name'].' '.$proposal['last_name'])), 'underscore', true); ?>
			  <?php $purl = cortiam_base_url('agent-profile/').$proposal['agent_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $proposal['first_name'].' '.$proposal['last_name'])), 'underscore', true); ?>

				  <div class="col-md-6 col-lg-4 proplistingwrap" id="props-<?php echo $proposal['prop_id'];?>">
						<a href="<?php echo $proposal_purl;?>" class="card proplisting mb-2 <?php echo (in_array($proposal['status'], array('Countered','Declined','Withdrawn')))? 'grayout':'';?> <?php echo (($proposal['status'] == 'Unread') && $proposal['prop_from'] == 'Agent')? 'animated bounce':'';?>">
							<?php echo generate_seller_proposal_ribbon($proposal['prop_from'],$proposal['status'],$proposal['first_counter'],'left', $proposal['main_id']);?>
						  <img class="card-img-top" src="<?php echo (($proposal['avatar_string'])? base_url($proposal['avatar_string']):base_url('images/userphoto.jpg'));?>" alt="Listing Image">
						  <div class="card-body orange-bg px-2">
						    <span class="float-left"><b><?php echo $proposal['first_name'].' '.$proposal['last_name'];?></b></span>
						    <small class="float-right"><?php $experience = (date("Y") - $proposal['experience']); echo (($experience > 1)? $experience.' Years':$experience.' Year')?></small>
						  </div>
						  <div class="card-footer addresspart p-2">
							  <strong>Address:</strong><p><?php echo $proposal['agent_address'].' '.$proposal['agent_city'].', '.$proposal['agent_state'].' '.$proposal['agent_zipcode'];?></p>
							  <strong>Phone:</strong><p><?php echo $proposal['agent_phone'];?></p>
						  </div>
						</a>
						  <?php if(in_array($proposal['status'], array('Unread','Read')) && $proposal['prop_from'] == 'Agent'){ ?>
							<div class="px-2">
							  <button class="button-orange smallerbutton text-center float-left acceptproposal" data-prop="<?php echo $proposal['prop_id'];?>">ACCEPT</button>
							  <button class="button-gray smallerbutton text-center float-right declineproposal" data-prop="<?php echo $proposal['prop_id'];?>">DECLINE</button>
							  <button class="button-border-gray w-100 smallerbutton text-center float-right mt-2 counterofferproposal" data-prop="<?php echo $proposal['prop_id'];?>">COUNTER OFFER</button>
							  <a class="button-underline-gray w-100 smallerbutton text-center mt-2" href="<?php echo cortiam_base_url('agent-profile/').$proposal['agent_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $proposal['first_name'].' '.$proposal['last_name'])), 'underscore', true);?>">View Agent Profile</a>
							</div>
						  <?php }elseif(in_array($proposal['status'], array('Declined')) && ($proposal['prop_from'] == 'Agent') && ($proposal['prop_status'] == 'Active')){ ?>
							<div class="px-2">
							  <button class="button-orange smallerbutton button-disabled text-center float-left">ACCEPT</button>
							  <button class="button-gray smallerbutton button-disabled text-center float-right">DECLINE</button>
							  <button class="button-border-gray w-100 smallerbutton text-center float-right mt-2 counterofferproposal" data-prop="<?php echo $proposal['prop_id'];?>">COUNTER OFFER</button>
							  <a class="button-underline-gray w-100 smallerbutton text-center mt-2" href="<?php echo cortiam_base_url('agent-profile/').$proposal['agent_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $proposal['first_name'].' '.$proposal['last_name'])), 'underscore', true);?>">View Agent Profile</a>
							</div>
						  <?php }elseif(in_array($proposal['status'], array('Unread','Read','Countered')) && $proposal['prop_from'] == 'Seller'){ ?>
							<div class="px-2">
							  <button class="button-orange smallerbutton button-disabled text-center float-left">ACCEPT</button>
							  <button class="button-gray smallerbutton button-disabled text-center float-right">DECLINE</button>
							  <button class="button-dark w-100 smallerbutton text-center float-right mt-2 withdrawproposal" data-prop="<?php echo $proposal['prop_id'];?>">WITHDRAW</button>
							  <a class="button-underline-gray w-100 smallerbutton text-center mt-2" href="<?php echo cortiam_base_url('agent-profile/').$proposal['agent_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $proposal['first_name'].' '.$proposal['last_name'])), 'underscore', true);?>">View Agent Profile</a>
							</div>
						  <?php }else{ ?>
							<div class="px-2">
							  <button class="button-orange smallerbutton button-disabled text-center float-left">ACCEPT</button>
							  <button class="button-gray smallerbutton button-disabled text-center float-right">DECLINE</button>
							  <button class="button-border-gray w-100 smallerbutton button-disabled text-center float-right mt-2">COUNTER OFFER</button>
							  <a class="button-underline-gray w-100 smallerbutton text-center mt-2" href="<?php echo $purl;?>">View Agent Profile</a>
							</div>
						  <?php } ?>
				  </div>

			  <?php } ?>
			  <?php }else{ ?>
			  	<div class="col-md-12"><p class="text-center py-3 p-sm-5">You have not received any agents expressing interest from your active properties.</p></div>
			  <?php } ?>

		  </div>
	  </div>
	  <div class="card-footer"></div>
	</div>

	<div class="card">
	  <div class="card-header header-elements-inline">
			<h3 class="card-title"><span class="icon-co-big orange list"></span> Previously Selected Agents</h3>
			<div class="header-elements">
				<a href="#" class="dofullscreen"><span class="icon-co-big expand"></span></a>
			</div>
	  </div>
	  <div class="card-body">
			<div class="row">

			<?php if($agreements) { ?>
				<?php foreach ($agreements as $agreement) { ?>
				  <?php $purl = cortiam_base_url('agent-profile/').$agreement['agent_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $agreement['agent'])), 'underscore', true); ?>
				  <div class="col-md-6 col-lg-4" id="agree-<?php echo $agreement['agr_id'];?>">
						<div class="card proplisting mb-2 <?php echo ($agreement['seller_response'] == 'Waiting')? 'animated bounce':'';?>">
							<?php echo generate_agreement_ribbon($agreement['agr_status'], $agreement['expire_time']);?>
						  <img class="card-img-top" src="<?php echo base_url($agreement['default_image']);?>" alt="Listing Image">
						  <a href="<?php echo $purl;?>" class="aggrementavatarlink"><img class="img-fluid rounded-circle user-avatar" src="<?php echo (($agreement['avatar_string'])? base_url($agreement['avatar_string']):base_url('assets/images/backend/userphoto.jpg'));?>" width="60" height="60"></a>
						  <div class="card-body orange-bg px-2">
						    <span class="float-left"><?php echo $agreement['state'];?></span>
						    <span class="float-right"><?php echo $agreement['city'];?></span>
						  </div>
						  <div class="card-footer addresspart p-2">
							  <strong>Commission Rate:</strong><p><?php echo $agreement['commission_rate'];?>%</p>
							  <strong>Contract Length:</strong><p><?php echo $agreement['contract_length'];?> Months</p>
						  </div>
						</div>
						<div class="px-2 text-center">
						  <a href="<?php echo cortiam_base_url('view-messages/').$agreement['agent_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $agreement['agent'])), 'underscore', true);?>" class="button-orange w-100 float-left smallerbutton text-center">CHAT</a>
						</div>
						<div class="px-2 text-center"></div>
				  </div>
				<?php } ?>
			<?php }else{ ?>
			  	<div class="col-md-12"><p class="text-center py-3 p-sm-5">You have not selected any agents from your previous properties.</p></div>
			<?php } ?>

	  	</div>
	  </div>
	</div>

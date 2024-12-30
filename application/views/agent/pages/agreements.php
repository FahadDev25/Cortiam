	<div class="card">
	  <div class="card-header header-elements-inline">
			<h3 class="card-title"><span class="icon-co-big orange list"></span> List of Agreements with Sellers</h3>
			<div class="header-elements">
				<a href="#" class="dofullscreen"><span class="icon-co-big expand"></span></a>
			</div>
	  </div>
	  <div class="card-body">
			<div class="row">

			<?php if($agreements) { ?>
				<?php foreach ($agreements as $agreement) { ?>
				  <div class="col-md-6 col-lg-4" id="agree-<?php echo $agreement['agr_id'];?>">
						<div class="card proplisting mb-2 <?php echo ($agreement['agent_response'] == 'Waiting')? 'animated bounce':'';?>">
							<?php echo generate_agreement_ribbon($agreement['agr_status'], $agreement['expire_time']);?>
						  <img class="card-img-top" src="<?php echo base_url($agreement['default_image']);?>" alt="Listing Image">
						  <div class="card-body orange-bg px-2">
						    <span class="float-left"><b><?php echo $agreement['type'];?></b></span>
						    <small class="float-right"><?php echo $agreement['building_size'];?> sqft.</small>
						  </div>
						  <div class="card-footer addresspart p-2">
							  <strong>Commission Rate:</strong><p><?php echo $agreement['commission_rate'];?>%</p>
							  <strong>Contract Length:</strong><p><?php echo $agreement['contract_length'];?> Months</p>
						  </div>
						  <small class="winfee">Fee: $<?php echo number_format($agreement['agr_fee'],2);?></small>
						</div>
					  <?php if($agreement['agr_status'] == 'Open'){ ?>
						  <?php if ($agreement['expire_time'] < time()) { ?>
						  <?php $purl = cortiam_base_url('view-property/').$agreement['property_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $agreement['city'].' '.$agreement['state'])), 'underscore', true); ?>
								<div class="px-2">
								  <button class="button-orange smallerbutton text-center float-left thisisexpired" data-profile="<?php echo $purl;?>">ACCEPT</button>
								  <button class="button-gray smallerbutton text-center float-right thisisexpired" data-profile="<?php echo $purl;?>">DECLINE</button>
								</div>
						  <?php }elseif(!$account['payment_id']){ ?>
								<div class="px-2">
								  <button class="button-orange smallerbutton text-center float-left paymentidrequired" data-profile="<?php echo cortiam_base_url('edit-account');?>#paymentpart" data-price="<?php echo $agreement['agr_fee'];?>">ACCEPT</button>
								  <button class="button-gray smallerbutton text-center float-right declineagreement" data-agree="<?php echo $agreement['agr_id'];?>">DECLINE</button>
								</div>
							<?php }else{ ?>
								<div class="px-2">
								  <button class="button-orange smallerbutton text-center float-left acceptagreement" data-agree="<?php echo $agreement['agr_id'];?>" data-price="<?php echo $agreement['agr_fee'];?>">ACCEPT</button>
								  <button class="button-gray smallerbutton text-center float-right declineagreement" data-agree="<?php echo $agreement['agr_id'];?>">DECLINE</button>
								</div>
							<?php } ?>
						<?php }elseif($agreement['agr_status'] == 'Completed'){ ?>
							<div class="px-2 text-center">
							  <a href="<?php echo cortiam_base_url('view-proposal/').$agreement['prop_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $agreement['city'].' '.$agreement['state'])), 'underscore', true);?>" class="button-orange float-right smallerbutton text-center">VIEW SELLERS CONTACT INFO</a>
							</div>
					  <?php }elseif($agreement['agr_status'] == 'Expired'){ ?>
				  		<?php $purl = cortiam_base_url('view-property/').$agreement['property_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $agreement['city'].' '.$agreement['state'])), 'underscore', true); ?>
							<div class="px-2">
							  <button class="button-orange smallerbutton text-center float-left thisisexpired" data-profile="<?php echo $purl;?>">ACCEPT</button>
							  <button class="button-gray smallerbutton text-center float-right thisisexpired" data-profile="<?php echo $purl;?>">DECLINE</button>
							</div>
					  <?php }else{ ?>
							<div class="px-2 text-center"></div>
					  <?php } ?>
				  </div>
				<?php } ?>
			<?php }else{ ?>
		  		<div class="col-md-12"><p class="text-center py-3 p-sm-5">Currently you do not have any agreements.</p></div>
			<?php } ?>
	  	</div>
	  </div>
	</div>
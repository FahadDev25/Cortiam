	<div class="card mb-3" id="couponlistpart">
	  <div class="card-header header-elements-inline">
			<h3 class="card-title"><span class="icon-co-big orange talk"></span> <?php echo (($proposal['prop_from'] == 'Seller')? 'Seller\'s':'Your');?> Proposal</h3>
			<?php echo generate_agent_proposal_ribbon($proposal['prop_from'],$proposal['status'], 'right',$proposal['main_id']);?>
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
				<div class="col-md-12 orange-address-bar">ADDRESS: <?php echo strtoupper((($property['unit'])? $property['unit'].' ':'').$property['address'].', '.$property['city'].', '.$property['state'].', '.$property['zipcode']);?></div>
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
			<?php if($property['type'] == 'Residential'){ ?>
			<div class="row graydetails border-bottom">
				<div class="col-md-4"><strong>Bedroom:</strong><br><?php echo $property['bedroom'];?></div>
				<div class="col-md-4"><strong>Bathroom:</strong><br><?php echo $property['bathroom'];?></div>
				<div class="col-md-4"><strong>Fee:</strong><br>$<?php echo number_format($property['win_fee'],2);?></div>
			</div>
			<?php }else{ ?>
			<div class="row graydetails border-bottom">
				<div class="col-md-12"><strong>Fee:</strong><br>$<?php echo number_format($property['win_fee'],2);?></div>
			</div>
			<?php } ?>
			<?php if(@in_array($property['property_id'], $win_properties)){ ?>
			<div class="row">
				<div class="col-md-12 orange-address-bar">PROPERTY OWNERS DETAILS</div>
			</div>
			<div class="row graydetails border-bottom">
				<div class="col-md-4"><strong>Full Name</strong><br><?php echo $property['first_name'].' '.$property['last_name'];?></div>
				<div class="col-md-4"><strong>Email Address</strong><br><a href="mailto:<?php echo $property['email'];?>" class="text-dark"><?php echo $property['email'];?></a></div>
				<div class="col-md-4"><strong>Phone Number</strong><br><a href="tel:<?php echo preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1-$2-$3', $property['phone']);?>" class="text-dark"><?php echo preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1-$2-$3', $property['phone']);?></a></div>
			</div>
			<?php } ?>
		  </div>
	  </div>

		<?php if($related_proposals){ ?>
	  <div id="propsaccordion">
	 		<div class="card rounded mb-0">
			  <div class="card-header" id="proposalhistoryheader">
			  	<h5 class="m-0" data-toggle="collapse" data-target="#proposalhistory" aria-expanded="true" aria-controls="proposalhistory">
			  	<span class="icon-co-sm proposal"></span> History
			  	</h5>
			  </div>

			  <div id="proposalhistory" class="collapse show" aria-labelledby="proposalhistory" data-parent="#propsaccordion">
			  <div class="card-body">
			  	<div id="historywrap">
			  		<div id="timeline">
			  			<div>
								<?php
									$counter = 1;
									foreach ($related_proposals as $related_proposal) {
										$current_date = date('m/d/Y', $related_proposal['prop_date']);
										echo ((($current_date != $previous_date) && ($counter != 1))? '</section>':'');
										echo (($current_date != $previous_date)? '<section class="year"><h3>'.$current_date.'</h3>':'');
										echo '<section>
														<h4><i class="icon-alarm"></i> '.date('h:i:s A', $related_proposal['prop_date']).'</h4>
														<ul>
															<li><b>'.(($related_proposal['prop_from'] == 'Agent')? 'You '.(($counter != 1)? 'Counter':'').' Offer':'Seller '.(($counter != 1)? 'Counter':'').' Offer').'</b><br>Commission Rate: '.$related_proposal['commission_rate'].'%<br>Length of Contract: '.$related_proposal['contract_length'].' Months'.(($related_proposal['prop_text'])? (($related_proposal['prop_from'] == 'Agent')? '<br>Your':'<br>Seller').' Terms: '.$related_proposal['prop_text']:'').'</li>
														</ul>
													</section>';
										$previous_date = $current_date;
										$counter++;
									}
									echo '</section>';
								?>
								</div>
							</div>
						</div>
				  </div>
			  </div>
		  </div>
	  </div>
		<?php }?>

	<div class="card">
	  <div class="card-header">
	  	<h5 class="m-0">
	  	<span class="icon-co-sm envelope"></span> <?php echo (($proposal['prop_from'] == 'Agent')? 'Your':'Sellers');?> Latest Offer on <?php echo date('Y/m/d \a\t h:i:s A',$proposal['prop_date']);?>
	  	</h5>
	  </div>
	  <div class="card-body pt-0">
			<div class="row simpledetails p-0">
				<div class="col-md-6 mt-3 py-2 text-center dark-bg">
					<strong>Commission Rate:</strong>
					<p class="mb-0"><?php echo $proposal['commission_rate'];?>%</p>
				</div>
				<div class="col-md-6 mt-3 py-2 text-center dark-bg">
					<strong>Length of Contract:</strong>
					<p class="mb-0"><?php echo $proposal['contract_length'];?> Months</p>
				</div>
				<div class="col-md-12 mt-3 px-3">
					<h3><?php echo (($proposal['prop_from'] == 'Seller')? 'Seller':'Your');?> Terms:</h3>
					<p><?php echo $proposal['prop_text'];?></p>
				</div>
	  	</div>
	  </div>
	  <?php if((($proposal['status'] == 'Unread') || ($proposal['status'] == 'Read'))){ ?>
	  <?php if($proposal['prop_from'] == 'Seller'){ ?>
	  <div class="card-footer text-center buttonsrow">
		  <button class="button-border-orange smallerbutton text-center mr-3 acceptproposal">ACCEPT THIS OFFER</button>
		  <button class="button-border-dark smallerbutton text-center mr-3 declineproposal">DECLINE THIS OFFER</button>
		  <button class="button-border-gray smallerbutton text-center counterofferproposal">COUNTER OFFER</button>
		</div>
		<?php }else{ ?>
	  <div class="card-footer text-center buttonsrow">
		  <button class="button-dark text-center mr-3 withdrawproposal" data-prop="<?php echo $proposal['prop_id'];?>">WITHDRAW</button>
		</div>
		<?php } ?>
		<?php } ?>
	</div>
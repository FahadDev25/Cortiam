 		<div class="card">
		  <div class="card-header header-elements-inline">
				<h3 class="card-title"><span class="icon-co-big orange profile"></span> Profile</h3>
				<div class="header-elements">
					<a href="<?php echo cortiam_base_url('edit-account');?>" class="button-orange text-center">Edit</a>
				</div>
		  </div>
		  <div class="card-body">
		  	<div class="row">
		  		<div class="col-md-12 py-3 px-lg-3 px-xl-3 dark-bg profile-header">
		  			<div class="float-left mr-3 mouseoverlayer">
		  				<img class="img-fluid rounded-circle user-avatar photoneedsupdate" src="<?php echo (($account['avatar_string'])? base_url($account['avatar_string']):base_url('assets/images/backend/userphoto.jpg'));?>" width="120" height="120">
		  				<div class="hoverlayer rounded-circle triggerphotochange"><div class="centerer" data-toggle="tooltip" data-placement="left" title="Click to change"><span class="icon-co-big white write"></span></div></div>
		  			</div>
		  			<h3 class="mt-4 mb-0"><strong><?php echo $account['first_name'].' '.$account['last_name'];?></strong></h3>
		  			<h6><?php echo $account['brokerage_name'];?></h6>
		  		</div>
		  		<div class="col-md-12 mt-3 px-lg-3 px-xl-3">
		  			<h5 class="mb-0"><strong>Biography</strong></h5>
		  			<?php echo nl2br($account['bio']);?>
		  		</div>
	  			<?php if($account['estate_specialization']) {?>
		  		<div class="col-md-12 mt-3 px-lg-3 px-xl-3">
		  			<h5 class="mb-0"><strong>Real Estate Specialization</strong></h5>
		  			<?php echo nl2br($account['estate_specialization']);?>
		  		</div>
					<?php } ?>

                <?php if(isset($agent_specializations)) {?>
                    <div class="col-md-12 mt-3 px-lg-3 px-xl-3">
                        <h5 class="mb-0"><strong>Specialization</strong></h5>

                        <?php
                        foreach ($agent_specializations as $special){?>
                            <span class="badge badge-secondary"><?= $special['name']?></span>
                            <?php
                        }
                        //                                echo nl2br($agent_specializations['estate_specialization']);
                        ?>
                    </div>
                <?php } ?>

					<?php if($licenses) {?>
		  		<div class="col-md-7 mt-3 px-lg-3 px-xl-3">
		  			<h5 class="mb-0"><strong>Real Estate Focus</strong></h5>
						<?php foreach ($licenses as $license) { ?>
					  	<?php echo (($license['interested'] == 'Both')? 'Residential & Commercial':$license['interested']);?> Properties in <?php echo $license['license_state'];?><br>
						<?php }?>
		  		</div>
					<?php }else{?>
					<div class="col-md-7 mt-3 px-lg-3 px-xl-3"></div>
					<?php }?>
		  		<div class="col-md-5 mt-3 px-lg-3 px-xl-3">
		  			<h5 class="mb-0"><strong>Years Experience</strong></h5>
		  			<?php echo (date("Y") - $account['experience']);?>
		  		</div>
		  		<div class="col-md-12 mt-3 px-lg-3 px-xl-3">
		  			<h5 class="mb-0"><strong>Address</strong></h5>
		  			<?php echo (($account['brokerage_unit'])? $account['brokerage_unit'].' ':'').$account['brokerage_address'].', '.$account['brokerage_city'].', '.$account['brokerage_state'].', '.$account['brokerage_zipcode'];?>
		  		</div>
		  		<div class="col-md-7 mt-3 px-lg-3 px-xl-3">
		  			<h5 class="mb-0"><strong>Phone Number</strong></h5>
		  			<a href="tel:<?php echo preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1-$2-$3', $account['brokerage_phone']);?>" class="text-dark"><?php echo preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1-$2-$3', $account['brokerage_phone']);?></a>
		  		</div>
		  		<div class="col-md-5 mt-3 px-lg-3 px-xl-3">
		  			<h5 class="mb-0"><strong>Email</strong></h5>
		  			<a href="mailto:<?php echo $account['email'];?>" class="text-dark"><?php echo $account['email'];?></a>
		  		</div>
		  		<div class="col-md-7 mt-3 px-lg-3 px-xl-3">
		  			<?php if($account['youtube_video']) {?>
		  			<?php preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $account['youtube_video'], $match);?>
			  		<div class="embed-responsive embed-responsive-16by9">
				  		<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $match[1];?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
						</div>
						<?php } ?>
		  		</div>
		  		<div class="col-md-5 mt-3 px-lg-3 px-xl-3">
		  			<?php if($account['facebook']) {?><div class="my-2"><a href="<?php echo $account['facebook'];?>" target="_blank" class="text-gray"><span class="icon-co-sm orange facebook"></span> <?php echo $account['facebook'];?></a></div><?php } ?>
		  			<?php if($account['linkedin']) {?><div class="my-2"><a href="<?php echo $account['linkedin'];?>" target="_blank" class="text-gray"><span class="icon-co-sm orange linkedin"></span> <?php echo $account['linkedin'];?></a></div><?php } ?>
		  			<?php if($account['twitter']) {?><div class="my-2"><a href="<?php echo $account['twitter'];?>" target="_blank" class="text-gray"><span class="icon-co-sm orange twitter"></span> <?php echo $account['twitter'];?></a></div><?php } ?>
		  			<?php if($account['google']) {?><div class="my-2"><a href="<?php echo $account['google'];?>" target="_blank" class="text-gray"><span class="icon-co-sm orange google"></span> <?php echo $account['google'];?></a></div><?php } ?>
		  			<?php if($account['instagram']) {?><div class="my-2"><a href="<?php echo $account['instagram'];?>" target="_blank" class="text-gray"><span class="icon-co-sm orange instagram"></span> <?php echo $account['instagram'];?></a></div><?php } ?>
		  		</div>
		  	</div>
		  </div>
	  </div>
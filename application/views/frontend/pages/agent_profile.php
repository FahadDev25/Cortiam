
<main role="main">
	<div class="findagent jumbotron jumbotron-fluid mb-0">
	  <div class="container">
		  <h1 class="headline">FIND YOUR AGENT</h1>
		  <div class="lead">Get to know your agent before you choose them. Meet multiple agents from various brokerages.</div><br>
	  </div>
	</div>
	<div class="profile-content">
	  <div class="container">
			<div class="row">


				  	<div class="row">
				  		<div class="col-md-12 py-3 px-lg-3 px-xl-3 dark-bg profile-header">
				  			<img class="img-fluid rounded-circle user-avatar float-left mr-3" src="<?php echo (($agent_account['avatar_string'])? base_url($agent_account['avatar_string']):base_url('images/userphoto.jpg'));?>" width="120" height="120">
				  			<h3 class="mt-4 mb-0"><strong><?php echo $agent_account['first_name'].' '.$agent_account['last_name'];?></strong></h3>
				  			<h6><?php echo $agent_account['brokerage_name'];?></h6>
				  			<div class="messagebutton">
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
	</div>
</main>
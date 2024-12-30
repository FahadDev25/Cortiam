	<form method="POST" class="couponform w-100" data-source="formajaxurl">
	<div class="card" id="couponaddpart">
	  <div class="card-header header-elements-inline">
			<h3 class="card-title"><span class="icon-co-big orange coupon"></span> Coupons</h3>
	  </div>
	  <div class="card-body">
			<div class="row">
				<h5 class="col-sm-12">Add New Coupon</h5>
				<div class="col-md-9">
					<div class="form-group">
						<input type="text" name="coupon_code" id="coupon_code" class="form-control" placeholder="Add Your Coupon Code" value="">
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">
	  				<button type="submit" class="button-orange mt-1 w-100">Save</button>
					</div>
				</div>
			</div>
	  </div>
	</div>
	</form>

	<?php if($coupons) {?>
	<div class="card" id="couponlistpart">
	  <div class="card-header header-elements-inline">
			<h3 class="card-title"><span class="icon-co-big orange proplist"></span> Coupon Collection</h3>
	  </div>
	  <div class="card-body">
			<fieldset>
			<div class="row">
				<div class="col-md-12">
					<?php if($account['auto_payment'] == 'Yes') { ?>
						<p class="alert alert-warning">Your coupons will used automatically by their order while processing your payments. Please drag&drop coupons to adjust order of your coupons.</p>
					<?php } ?>
					<ul class="profile-list" id="couponlist">
						<?php foreach ($coupons as $coupon) { ?>
						  <li class="profile-list-item rowmovable" id="coupon-<?php echo $coupon['use_id'];?>">
							  <div class="row no-gutters">
								  <div class="col-sm-8">
								  	<p class="titlepart"><strong><?php echo $coupon['coupon_code'];?></strong></p>
								  	<p class="subtitlepart"><?php echo (($coupon['coupon_used'] == 'Yes')? 'Coupon used on '.date('F j, Y', $coupon['used_on']):'Coupon will expire on '.date('F j, Y', $coupon['end_date']));?></p>
							  	</div>
								  <div class="col-sm-2">
								  	<?php
								  	switch ($coupon['coupon_type']) {
								  		case 'Percentage':
								  			echo '-'.$coupon['coupon_amount'].'%';
								  			break;
								  		case 'Win Limit':
								  			echo '+'.number_format($coupon['coupon_amount']).' Wins';
								  			break;
								  		case 'Interest Limit':
								  			echo '+'.number_format($coupon['coupon_amount']).' Interest';
								  			break;
								  		default:
								  			echo '-'.$coupon['coupon_amount'].' USD';
								  			break;
								  	}
								  	?>
							  	</div>
								  <div class="col-sm-2 align-middle text-right">
								  	<span class="badge badge-pill <?php echo (($coupon['coupon_used'] == 'Yes')? 'badge-secondary">Used':'orange-bg">Active');?></span>
							  	</div>
						  	</div>
						  </li>
							<?php }?>
					</ul>
				</div>
				<div class="col-md-12">
					<div id="cardpart">

					</div>
				</div>
			</div>
			</fieldset>
	  </div>
	</div>
	<?php } ?>
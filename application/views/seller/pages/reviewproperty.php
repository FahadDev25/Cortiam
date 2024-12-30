	<div class="card">
	  <div class="card-header header-elements-inline">
			<h3 class="card-title"><span class="icon-co-big orange step2"></span> Property Details</h3>
			<div class="header-elements">
				<a href="#" class="dofullscreen"><span class="icon-co-big expand"></span></a>
			</div>
	  </div>
	  <div class="card-body">

			<div class="row mb-3">
				<div class="col-md-5">
					<img class="propimg img-fluid" src="<?php echo (($property['default_image'])? base_url($property['default_image']):base_url('images/empty.png'));?>" alt="" width="100%">
				</div>
				<div class="col-md-7">

					<div class="row mb-3">
						<div class="col-md-6">
							<input type="text" name="type" id="type" class="form-control" placeholder="Property Type" value="<?php echo $property['type'];?>" disabled>
						</div>
						<div class="col-md-6">
							<input type="text" name="type" id="sub_type" class="form-control" placeholder="Property Type" value="<?php echo $property['sub_type'];?>" disabled>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4">
							<div class="input-group">
								<input type="number" name="land_size" id="land_size" class="form-control" placeholder="Land Size" value="<?php echo $property['land_size'];?>" disabled step="0.01">
								<span class="input-group-append">
								<span class="input-group-text">Acre</span>
								</span>
							</div>
						</div>
						<div class="col-md-4">
							<div class="input-group">
								<input type="number" name="building_size" id="building_size" class="form-control" placeholder="Building Size" value="<?php echo $property['building_size'];?>" disabled step="0.01">
								<span class="input-group-append">
								<span class="input-group-text">Acre</span>
								</span>
							</div>
						</div>
						<div class="col-md-4">
							<input type="text" name="built_date" id="built_date" class="form-control" placeholder="Build Year" data-date-end-date="<?php echo date("m/d/Y");?>" value="<?php echo $property['built_date'];?>" disabled>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-9">
							<input type="text" maxlength="225"  name="address" id="address" class="form-control maxlength-textarea" placeholder="Address line" value="<?php echo $property['address'];?>" disabled>
						</div>

						<div class="col-md-3">
							<input type="text" name="unit" id="unit" class="form-control" placeholder="Unit" value="<?php echo $property['unit'];?>" disabled>
						</div>
					</div>

					<div class="row">
						<div class="col-md-3">
							<input type="text" name="state" id="state" class="form-control" placeholder="State" value="<?php echo $property['state'];?>" disabled>
						</div>

						<div class="col-md-6">
							<input type="text" name="city" id="city" class="form-control" placeholder="City" value="<?php echo $property['city'];?>" disabled>
						</div>

						<div class="col-md-3">
							<input type="text" name="zipcode" id="zipcode" class="form-control" placeholder="Zip Code" value="<?php echo $property['zipcode'];?>" disabled>
						</div>
					</div>

				</div>
			</div>
	  </div>
	</div>

	<form method="POST" class="ajaxform w-100" data-source="formajaxurl">
	<div class="card">
	  <div class="card-header header-elements-inline">
			<h3 class="card-title"><span class="icon-co-big orange step3"></span> Approval Process Details</h3>
			<div class="header-elements">
				<a href="#" class="dofullscreen"><span class="icon-co-big expand"></span></a>
			</div>
	  </div>
	  <div class="card-body">
			<ul class="media-list media-chat mb-3">
				<?php
				if ($history) {
					foreach ($history as $history_item) {
						if ($history_item['type'] == 'Admin') {
						echo '<li class="media media-chat-item-reverse">
										<div class="media-body">
											<div class="media-chat-item">'.nl2br($history_item['message_text']).'</div>
											<div class="font-size-sm text-muted mt-1 mb-2"><i class="icon-alarm ml-2 text-muted"></i> '.date("j F, Y h:i:s A",$history_item['message_date']).' by Cortiam</div>
										</div>

										<div class="ml-3">
												<img src="'.(($history_item['admin_image'])? base_url(str_replace(".jpg","_mini.jpg",$history_item['admin_image'])):base_url('images/userphoto_mini.jpg')).'" class="rounded-circle" width="40" height="40" alt="'.$history_item['admin'].'">
										</div>
									</li>';
						}else{
							echo '<li class="media">
											<div class="mr-3">
												<img src="'.(($history_item['seller_image'])? base_url(str_replace(".jpg","_mini.jpg",$history_item['seller_image'])):base_url('images/userphoto_mini.jpg')).'" class="rounded-circle" width="40" height="40" alt="'.$history_item['seller'].'">
											</div>
											<div class="media-body">
												<div class="media-chat-item">'.nl2br($history_item['message_text']).'</div>
												<div class="font-size-sm text-muted mt-1 mb-2"><i class="icon-alarm ml-2 text-muted"></i> '.date("j F, Y h:i:s A",$history_item['message_date']).' by '.$history_item['seller'].'</div>
											</div>
										</li>';
						}
					}
				}else{
					echo '<li class="media content-divider justify-content-center text-muted mx-0">No approval history</li>';
				}
				?>
			</ul>
			<hr>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<textarea name="message_text" id="message_text" class="form-control maxlength-textarea" rows="3" cols="1" placeholder="Enter your reason..."></textarea>
					</div>
				</div>
			</div>

	  </div>
	  <div class="card-footer text-right">
	  	<button type="submit" class="button-orange">Request Approval Again</button>
	  </div>
	</div>
	</form>
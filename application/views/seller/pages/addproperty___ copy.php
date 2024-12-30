	<form method="POST" class="ajaxform w-100" data-source="formajaxurl" id="addpropertyform" novalidate>


  <div class="tab-content pt-3" id="nav-tabContent">

    <div class="tab-pane fade show active" id="steps-first" role="tabpanel" aria-labelledby="steps-first-tab">
			<div class="progress steps">
			  <div class="progress-bar" role="progressbar" style="width: 6%;" aria-valuenow="6" aria-valuemin="0" aria-valuemax="100">6%</div>
			</div>
			<h2 class="steps-title"><span class="icon-co-steps contract"></span> Your Terms</h2>
			<h4 class="steps-subtitle">Tell us about your terms!</h4>
			<div class="card">
			  <div class="card-body">
					<div class="row">
						<div class="col-md-6 pb-3 pb-sm-0">
							<select name="commission_rate" id="commission_rate" placeholder="Commission Rate %">
								<option value="">Commission Rate %</option>
								<?php
								$comm_rate = 3;
								while($comm_rate <= 6) {
									echo '<option value="'.$comm_rate.'">'.$comm_rate.' %</option>';
									$comm_rate += 0.5;
								}
								?>
							</select>
							<span class="field-desc"><ul class="pl-3"><li>Typical total commission rate is 6%</li><li>The commission rate you choose will be split between the seller and buyer agents</li></ul></span>
						</div>
						<div class="col-md-6">
							<select name="contract_length" id="contract_length" placeholder="Length of Contract">
								<option value="">Length of Contract</option>
								<?php
								$months = 1;
								while($months <= 12) {
									echo '<option value="'.$months.'">'.$months.' Months</option>';
									$months++;
								}
								?>
							</select>
							<span class="field-desc"><ul class="pl-3"><li>Length of contract is the amount of time you are bound to work exclusively with your chosen agent</li><li>In a standard market the most common contract length is between three to six months</li></ul></span>
						</div>
					</div>
			  </div>
			  <div class="card-footer text-right">
			  	<a class="button-orange faketab-buttons text-center" id="steps-first-next">Next</a>
			  </div>
			</div>
    </div>

    <div class="tab-pane fade show" id="steps-second" role="tabpanel" aria-labelledby="steps-second-tab">
			<div class="progress steps">
			  <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
			</div>
			<h2 class="steps-title"><span class="icon-co-steps resident" id="changeablebutton"></span> Property Details</h2>
			<h4 class="steps-subtitle">So, you have decided to sell your home?</h4>
			<div class="card">
			  <div class="card-body">
					<div class="row mb-3">
						<div class="col-md-6 mb-2 mb-sm-0">
							<select name="type" id="type" placeholder="Residential or Commercial?">
								<option value="">Is this property residential or commercial?</option>
								<option value="Residential">Residential</option>
								<option value="Commercial">Commercial</option>
							</select>
						</div>
						<div class="col-md-6">
							<select name="sub_type" id="sub_type" placeholder="Property Type">
								<option value="">Property Type</option>
							</select>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-4 mb-3 mb-sm-0">
							<div class="input-group">
								<input type="number" name="land_size" id="land_size" class="form-control" placeholder="Land Size" step="0.01">
								<span class="input-group-append">
								<span class="input-group-text">Acre</span>
								</span>
							</div>
							<span class="field-desc">Please do not use special characters, numbers only.</span>
						</div>
						<div class="col-md-4 mb-3 mb-sm-0">
							<div class="input-group">
								<input type="number" name="building_size" id="building_size" class="form-control" placeholder="Building Size" step="0.01">
								<span class="input-group-append">
								<span class="input-group-text">Acre</span>
								</span>
							</div>
							<span class="field-desc">Please do not use special characters, numbers only.</span>
						</div>
						<div class="col-md-4">
							<input type="text" name="built_date" id="built_date" class="form-control" placeholder="Build Year" data-date-end-date="+5y">
						</div>
					</div>
					<div class="row mb-3" id="hideforcommercial" style="display:none;">
						<div class="col-md-6 mb-3 mb-sm-0">
							<input type="number" name="bedroom" id="bedroom" class="form-control" placeholder="Bedroom Amount">
						</div>
						<div class="col-md-6">
							<input type="number" name="bathroom" id="bathroom" class="form-control" placeholder="Bathroom Amount">
						</div>
					</div>

					<div class="row mb-3">
						<div class="col-md-9 mb-3 mb-sm-0">
							<input type="text" maxlength="225"  name="address" id="address" class="form-control maxlength-textarea" placeholder="Address line">
						</div>

						<div class="col-md-3">
							<input type="text" name="unit" id="unit" class="form-control" placeholder="Unit">
						</div>
					</div>

					<div class="row">
						<div class="col-md-5 mb-3 mb-sm-0">
							<input type="text" name="state" id="state" class="form-control" placeholder="State">
						</div>

						<div class="col-md-5 mb-3 mb-sm-0">
							<input type="text" name="city" id="city" class="form-control" placeholder="City">
						</div>

						<div class="col-md-2">
							<input type="text" name="zipcode" id="zipcode" class="form-control" placeholder="Zip Code">
						</div>
						<div class="col-md-12">
							<span class="field-desc">Until the Agent has won a listing, they will not be able to view the full address.</span>
						</div>
					</div>

			  </div>
			  <div class="card-footer text-right">
			  	<a class="button-dark tab-buttons float-left text-center" id="steps-first-tab" data-toggle="tab" href="#steps-first" role="tab" aria-controls="steps-first" aria-selected="false">Back</a>
			  	<a class="button-orange faketab-buttons text-center" id="steps-second-next">Next</a>
			  </div>
			</div>
    </div>

    <div class="tab-pane fade show" id="steps-fourth" role="tabpanel" aria-labelledby="steps-fourth-tab">
			<div class="progress steps">
			  <div class="progress-bar" role="progressbar" style="width: 80%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">80%</div>
			</div>
			<h2 class="steps-title"><span class="icon-co-steps photo"></span> Upload Photos</h2>
			<h4 class="steps-subtitle px-2">Awesome...one more step! In order to protect your privacy, please be sure to not upload any photos with your home address.</h4>
			<div class="card">
			  <div class="card-body">
					<div class="row mb-3">
						<div class="col-md-6">
							<h4>Outdoor Photo 1</h4>
							<div class="overlayuploader">
								<img class="propimg img-fluid" id="show_front_image" src="<?php echo base_url('images/empty.png');?>" alt="" width="100%">
								<p class="dropboxfields" data-file="fpimage" data-target="front_image" data-img="show_front_image"><span class="d-none d-lg-block">Drop files here to start uploading<br>or<br></span><a href="<?php echo cortiam_base_url('edit-account');?>" class="button-dark btn-file mt-2"><span class="d-lg-none">ADD PHOTO</span><span class="d-none d-lg-block">SELECT FILE</span><input type="file" class="file-input property_img_upload" data-file="fpimage" data-target="front_image" data-img="show_front_image" id="fpimage" accept="image/*;capture=camera"></a></p>
								<p class="removefields" data-target="front_image" data-img="show_front_image"><a href="<?php echo cortiam_base_url('edit-account');?>" class="button-dark btn-file mt-2">REMOVE PHOTO</a></p>
								<input type="hidden" name="front_image" id="front_image">
							</div>
						</div>
						<div class="col-md-6">
							<h4>Outdoor Photo 2</h4>
							<div class="overlayuploader">
								<img class="propimg img-fluid" id="show_rear_image" src="<?php echo base_url('images/empty.png');?>" alt="">
								<p class="dropboxfields" data-file="rpimage" data-target="rear_image" data-img="show_rear_image"><span class="d-none d-lg-block">Drop files here to start uploading<br>or<br></span><a href="<?php echo cortiam_base_url('edit-account');?>" class="button-dark btn-file mt-2"><span class="d-lg-none">ADD PHOTO</span><span class="d-none d-lg-block">SELECT FILE</span><input type="file" class="file-input property_img_upload" data-file="rpimage" data-target="rear_image" data-img="show_rear_image" id="rpimage" accept="image/*;capture=camera"></a></p>
								<p class="removefields" data-target="rear_image" data-img="show_rear_image"><a href="<?php echo cortiam_base_url('edit-account');?>" class="button-dark btn-file mt-2">REMOVE PHOTO</a></p>
								<input type="hidden" name="rear_image" id="rear_image">
							</div>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-6">
							<h4>Indoor Photo 1</h4>
							<div class="overlayuploader">
								<img class="propimg img-fluid" id="show_left_image" src="<?php echo base_url('images/empty.png');?>" alt="">
								<p class="dropboxfields" data-file="spimage" data-target="left_image" data-img="show_left_image"><span class="d-none d-lg-block">Drop files here to start uploading<br>or<br></span><a href="<?php echo cortiam_base_url('edit-account');?>" class="button-dark btn-file mt-2"><span class="d-lg-none">ADD PHOTO</span><span class="d-none d-lg-block">SELECT FILE</span><input type="file" class="file-input property_img_upload" data-file="spimage" data-target="left_image" data-img="show_left_image" id="spimage" accept="image/*;capture=camera"></a></p>
								<p class="removefields" data-target="left_image" data-img="show_left_image"><a href="<?php echo cortiam_base_url('edit-account');?>" class="button-dark btn-file mt-2">REMOVE PHOTO</a></p>
								<input type="hidden" name="left_image" id="left_image">
							</div>
						</div>
						<div class="col-md-6">
							<h4>Indoor Photo 2</h4>
							<div class="overlayuploader">
								<img class="propimg img-fluid" id="show_right_image" src="<?php echo base_url('images/empty.png');?>" alt="">
								<p class="dropboxfields" data-file="ospimage" data-target="right_image" data-img="show_right_image"><span class="d-none d-lg-block">Drop files here to start uploading<br>or<br></span><a href="<?php echo cortiam_base_url('edit-account');?>" class="button-dark btn-file mt-2"><span class="d-lg-none">ADD PHOTO</span><span class="d-none d-lg-block">SELECT FILE</span><input type="file" class="file-input property_img_upload" data-file="ospimage" data-target="right_image" data-img="show_right_image" id="ospimage" accept="image/*;capture=camera"></a></p>
								<p class="removefields" data-target="right_image" data-img="show_right_image"><a href="<?php echo cortiam_base_url('edit-account');?>" class="button-dark btn-file mt-2">REMOVE PHOTO</a></p>
								<input type="hidden" name="right_image" id="right_image">
							</div>
						</div>
					</div>
			  </div>
			  <div class="card-footer text-right">
			  	<a class="button-dark tab-buttons float-left text-center" id="steps-third-tab" data-toggle="tab" href="#steps-second" role="tab" aria-controls="steps-third" aria-selected="false">Back</a>
	  			<button type="submit" class="button-orange">Submit</button>
			  </div>
			</div>
    </div>

	</div>

	</form>

 	<?php if ($my_properties) {?>
	<div class="card">
	  <div class="card-header header-elements-inline">
			<h3 class="card-title"><span class="icon-co-big orange proplist"></span> List of Previously Added Properties</h3>
			<div class="header-elements">
				<a href="#" class="dofullscreen"><span class="icon-co-big expand"></span></a>
			</div>
	  </div>
	  <div class="card-body">
			<div class="row">
		  <?php
		  foreach ($my_properties as $my_property) {
		  	echo generate_seller_property_card($my_property);
		  }
		  ?>
		  </div>
	  </div>
	  <div class="card-footer">
		  <?php if (count($my_properties) >= 1) { ?>
			<div class="row">
		  	<div class="col-md-12 text-center"><a href="<?php echo cortiam_base_url('list-properties');?>" class="button-underline-gray">View All Properties</a></div>
		  </div>
		  <?php } ?>
	  </div>
	</div>
 	<?php } ?>

	<div id="propertymodal" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-center">Edit Image</h3>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="image-cropper-container mb-3">
					<img src="<?php echo base_url('assets/images/backend/placeholder.png');?>" alt="" class="cropper" id="property-cropper-image">
				</div>
				<div class="form-group property-cropper-toolbar mb-0">
					<div class="btn-group btn-group-justified d-flex rounded orange-bg">
							<button type="button" class="btn bg-orange-700 btn-icon" data-method="setDragMode" data-option="move" title="Move">
								<span class="icon-co-big white move"></span>
							</button>
							<button type="button" class="btn bg-orange-700 btn-icon" data-method="setDragMode" data-option="crop" title="Crop">
								<span class="icon-co-big white crop"></span>
							</button>
							<button type="button" class="btn bg-orange-700 btn-icon" data-method="zoom" data-option="0.1" title="Zoom In">
								<span class="icon-co-big white zoomin"></span>
							</button>
							<button type="button" class="btn bg-orange-700 btn-icon" data-method="zoom" data-option="-0.1" title="Zoom Out">
								<span class="icon-co-big white zoomout"></span>
							</button>
							<button type="button" class="btn bg-orange-700 btn-icon" data-method="rotate" data-option="-45" title="Rotate Left">
								<span class="icon-co-big white rotateleft"></span>
							</button>
							<button type="button" class="btn bg-orange-700 btn-icon" data-method="rotate" data-option="45" title="Rotate Right">
								<span class="icon-co-big white rotateright"></span>
							</button>
							<button type="button" class="btn bg-orange-700 btn-icon" data-method="scaleX" data-option="-1" title="Flip Horizontal">
								<span class="icon-co-big white fliph"></span>
							</button>
							<button type="button" class="btn bg-orange-700 btn-icon" data-method="scaleY" data-option="-1" title="Flip Vertical">
								<span class="icon-co-big white flipv"></span>
							</button>
					</div>
				</div>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="button-danger" data-dismiss="modal"><b><i class="icon-cross2"></i></b> Cancel</button>
				<button type="button" class="button-success" id="getpropdata"><b><i class="icon-checkmark3"></i></b> Proceed</button>
			</div>
		</div>
	</div>
</div>
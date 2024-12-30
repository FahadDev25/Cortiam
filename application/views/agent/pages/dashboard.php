	<div class="card">
	  <div class="card-header header-elements-inline">
				<h3 class="card-title"><span class="icon-co-big orange listbold"></span> Your Dashboard</h3>
				<div class="header-elements">
					<div class="dropdown d-inline">
						<a href="#" role="button" id="questiontab-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="icon-co-big question"></span></a>
					  <div class="dropdown-menu dropdown-menu-right larger" aria-labelledby="questiontab-1" id="questiontab-1">
					  	<p><b>Your Introductions:</b> Listings that agents have expressed interest in; awaiting action from seller<br>
								<b>Awaiting Action:</b> Listing that require action i.e. counteroffer, pay balance<br>
								<b>Properties Won:</b> Listings agent won; access here for customer portal<br>
								<b>Saved Properties:</b> Listings agents have saved to come back to</p>
					  </div>
					</div>
					<div class="dropdown d-inline">
						<a href="#" role="button" id="enabletabviamenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="icon-co-big gear"></span></a>
					  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="enabletabviamenu" id="tabviamenu">
							<a href="<?php echo base_url('agent/');?>" data-open="nav-ac" data-active="nav-ac-tab" class="dropdown-item">Your Introductions</a>
							<a href="<?php echo base_url('agent/');?>" data-open="nav-pe" data-active="nav-pe-tab" class="dropdown-item">Awaiting Action</a>
							<a href="<?php echo base_url('agent/');?>" data-open="nav-yo" data-active="nav-yo-tab" class="dropdown-item">Properties Won</a>
							<a href="<?php echo base_url('agent/');?>" data-open="nav-sa" data-active="nav-sa-tab" class="dropdown-item">Saved Properties</a>
					  </div>
					</div>


					<a href="#" class="dofullscreen"><span class="icon-co-big expand"></span></a>
				</div>
	  </div>
	  <div class="card-body">
      <nav>
        <div class="nav nav-tabs nav-fill proptabs" id="nav-tab" role="tablist">
          <a class="nav-item nav-link active" id="nav-ac-tab" data-toggle="tab" href="#nav-ac" role="tab" aria-controls="nav-ac" aria-selected="false">Your Introductions</a>
          <a class="nav-item nav-link" id="nav-pe-tab" data-toggle="tab" href="#nav-pe" role="tab" aria-controls="nav-pe" aria-selected="false">Awaiting Action</a>
          <a class="nav-item nav-link" id="nav-yo-tab" data-toggle="tab" href="#nav-yo" role="tab" aria-controls="nav-yo" aria-selected="false">Properties Won</a>
          <a class="nav-item nav-link" id="nav-sa-tab" data-toggle="tab" href="#nav-sa" role="tab" aria-controls="nav-sa" aria-selected="false">Saved Properties</a>
        </div>
      </nav>
      <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-ac" role="tabpanel" aria-labelledby="nav-ac-tab">

        	<?php if ($express_properties){ ?>
					<div class="row carousel justify-content-center">
						<?php
							foreach ($express_properties as $express_property) {
								echo generate_property_card($express_property, $account['win_cost']);
							}
						?>
					</div>
					<?php }else{ ?>
						<h4 class="py-3 p-sm-5 text-center">Currently there is no property added to your active listing.</h4>
					<?php } ?>

        </div>
        <div class="tab-pane fade show" id="nav-pe" role="tabpanel" aria-labelledby="nav-pe-tab">

        	<?php if ($pending_properties){ ?>
					<div class="row carousel justify-content-center">
						<?php
							foreach ($pending_properties as $pending_property) {
								echo generate_property_card($pending_property, $account['win_cost']);
							}
						?>
					</div>
					<?php }else{ ?>
						<h4 class="py-3 p-sm-5 text-center">Currently there is no property added to your pending listing.</h4>
					<?php } ?>

        </div>
        <div class="tab-pane fade show" id="nav-yo" role="tabpanel" aria-labelledby="nav-yo-tab">

        	<?php if ($win_properties){ ?>
					<div class="row carousel justify-content-center">
						<?php
							foreach ($win_properties as $win_property) {
								echo generate_property_card($win_property, $account['win_cost']);
							}
						?>
					</div>
					<?php }else{ ?>
						<h4 class="py-3 p-sm-5 text-center">Currently there is no property added to your listing.</h4>
					<?php } ?>

        </div>
        <div class="tab-pane fade show" id="nav-sa" role="tabpanel" aria-labelledby="nav-sa-tab">

					<div class="row carousel justify-content-center">
        	<?php if ($saved_properties){ ?>
						<?php
							foreach ($saved_properties as $saved_property) {
								echo generate_property_card($saved_property, $account['win_cost']);
							}
						?>
					<?php }else{ ?>
						<h4 class="py-3 p-sm-5 text-center">Currently there is no property added to your saved listing.</h4>
					<?php } ?>
					</div>

        </div>

	  	</div>
	  </div>
	  <div class="card-footer"></div>
	</div>


	<div class="card" id="remainingnumbers">
		<div class="dropdown">
			<a href="#" role="button" id="questiontab-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="icon-co-big question"></span></a>
		  <div class="dropdown-menu dropdown-menu-right larger" aria-labelledby="questiontab-1" id="questiontab-1">
				<p>
					<b>Remaining Introductions:</b>
					This number indicates the remaining opportunities you have to introduce yourself to potential clients. Each agent can have (10) pending introductions.
				</p>
				<p>
					<b>Remaining Wins:</b> 
					This number indicates monthly clients allowed per agent
				</p>
		  </div>
		</div>
	  <div class="card-body">
	  	<div class="row">
	  		<div class="col-md-6">
			  	<h5 class="text-center mt-2"><b>Remaining Introductions</b></h5>
			  	<?php
			  	if ( $account['offer_remain'] >=  $account['offer_limit']) {
			  		$exp_percentage = 100;
			  	}else{
			  		$exp_percentage = round($account['offer_remain']/($account['offer_limit']/100));
			  	}
			  	?>
					<div class="c100 p<?php echo $exp_percentage;?> center green my-2">
					    <span><?php echo $account['offer_remain'];?></span>
					    <div class="slice"><div class="bar"></div><div class="barfill"></div></div>
					</div>
	  		</div>
	  		<div class="col-md-6">
			  	<h5 class="text-center mt-2"><b>Remaining Wins</b></h5>
			  	<?php
			  	if ( $account['win_remain'] >=  $account['win_limit'])
				{
			  		$win_percentage = 100;
			  	}else{
			  		$win_percentage = round($account['win_remain']/($account['win_limit']/100));
			  	}
			  	?>
					<div class="c100 p<?php echo $win_percentage;?> center blue my-2">
					    <span><?php echo $account['win_remain'];?></span>
					    <div class="slice"><div class="bar"></div><div class="barfill"></div></div>
					</div>
	  		</div>
	  		<div class="col-md-12">
					<?php if($account['membership_due'] > time()){ ?>
					<div class="text-center">Wins Reset on <?php echo date('m/d/Y h:i A',$account['membership_due']);?></div>
					<?php } ?>
	  		</div>
	  	</div>
	  </div>
	</div>


	<div class="card">
	  <div class="card-header header-elements-inline">
			<h3 class="card-title"><span class="icon-co-big orange house"></span> Search Properties</h3>
			<div class="header-elements">
				<div class="dropdown d-inline">
					<a href="#" role="button" id="questiontab-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="icon-co-big question"></span></a>
				  <div class="dropdown-menu dropdown-menu-right larger" aria-labelledby="questiontab-2" id="questiontab-2">
							<p><b>Select a State:</b> Search properties by state<br>
							<b>Select a City:</b> Search properties by city<br>
							<b>Zip Code:</b> Search properties by zip code<br>
							<b>Property Type:</b> Single family, duplex, condo, etc...<br>
							<b>Commission Rate:</b> % Rate agent will recieve after sale<br>
							<b>Length of Contract:</b> Time period seller has set to sell</p>
				  </div>
				</div>
				<a href="#" class="dofullscreen"><span class="icon-co-big expand"></span></a>
			</div>
	  </div>
	  <div class="card-body">
	  	<div class="row">
	  		<div class="col-md-4 pb-2 pb-md-0">
	  			<input type="text" id="s_state" name="s_state" class="form-control" placeholder="State">
	  		</div>
	  		<div class="col-md-4 pb-2 pb-md-0">
	  			<input type="text" id="s_city" name="s_city" class="form-control" placeholder="City">
	  		</div>
	  		<div class="col-md-4 pb-2 pb-md-0">
	  			<button type="submit" class="button-orange w-100 mt-1" id="tablesearch">Search</button>
	  		</div>
	  		<div class="col-md-12 pb-2 pb-md-0">
	  			<button class="button-gray w-100 mt-1" data-toggle="collapse" href="#advancedsearch" role="button" aria-expanded="false" aria-controls="advancedsearch">Advanced Search</button>
	  		</div>
  		</div>
  		<div class="collapse multi-collapse" id="advancedsearch">
		  	<div class="row pt-md-2">
		  		<div class="col-md-4 pb-2 pb-md-0">
		  			<input type="text" id="s_zipcode" name="s_zipcode" class="form-control" placeholder="Zip Code">
		  		</div>
		  		<div class="col-md-8 pb-2 pb-md-0 rangesliderwrap" data-toggle="tooltip" data-placement="top" title="Search radius only available with Zip Code">
		  			<input type="range" min="10" max="100" value="20" class="slider align-middle" id="s_ziprange" name="s_ziprange">
		  			<div class="rangeshow"><span id="rangeshow"></span> Miles</div>
		  		</div>
	  		</div>
		  	<div class="row pt-md-2">
		  		<div class="col-md-4 pb-2 pb-md-0">
						<select name="s_type" id="s_type" class="select">
							<option value="">Property Type</option>
							<option value="Residential">Residential</option>
							<option value="Commercial">Commercial</option>
							<option value="Both">Both</option>
						</select>
		  		</div>
		  		<div class="col-md-4 pb-2 pb-md-0">
						<select name="s_commission_rate" id="s_commission_rate" class="select">
							<option value="">Commission Rate %</option>
							<?php
							$comm_rate = 0.5;
							while($comm_rate <= 6) {
								echo '<option value="'.$comm_rate.'">'.$comm_rate.' %</option>';
								$comm_rate += 0.5;
							}
							?>
						</select>
		  		</div>
		  		<div class="col-md-4 pb-2 pb-md-0">
						<select name="s_contract_length" id="s_contract_length" class="select">
							<option value="">Length of Contract</option>
							<?php
							$months = 1;
							while($months <= 12) {
								echo '<option value="'.$months.'">'.$months.' Months</option>';
								$months++;
							}
							?>
						</select>
		  		</div>
		  	</div>
	  	</div>
	  	<div class="row pt-4">
					<table class="table table-hover datatable-highlight w-100" id="propertytable">
						<thead class="thead-dark">
							<tr>
								<th>Photo</th>
								<th>Location</th>
								<th>Type</th>
								<th>Approx<br>Value</th>
								<th>Terms</th>
								<th>Period</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
  		</div>
	  </div>
	  <div class="card-footer"></div>
	</div>

	<div class="card" id="messageslast">
	  <div class="card-header header-elements-inline">
			<h3 class="card-title"><span class="icon-co-big orange envelope"></span> Messages</h3>
			<div class="header-elements">
				<div class="dropdown d-inline">
					<a href="#" role="button" id="questiontab-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="icon-co-big question"></span></a>
				  <div class="dropdown-menu dropdown-menu-right larger" aria-labelledby="questiontab-5" id="questiontab-5">
						<p>Messages is designed for inbound messages</p>
				  </div>
				</div>
			</div>
	  </div>
	  <div class="card-body">
		  <?php if($pms){ ?>
			  <?php  foreach ($pms as $pm) { ?>
			  	<?php if ($pm['msg_type'] == 'message') {?>
			  	<a href="<?php echo cortiam_base_url('message-center');?>" class="row no-gutters messagelistitem">
	  				<div class="col-md-9 msgtitle"><strong><?php echo $pm['first_name'][0].' '.$pm['last_name'][0];?></strong></div>
			  		<div class="col-md-3 msgdate"><?php echo time_elapsed_string($pm['message_date']);?></div>
			  		<div class="col-md-12 msgbody"><?php echo $pm['message_text'];?></div>
			  	</a>
		  		<?php }else{ ?>
			  	<a href="<?php echo cortiam_base_url('support-center');?>" class="row no-gutters messagelistitem">
			  		<div class="col-md-9 msgtitle"><strong><?php echo $pm['first_name'].' '.$pm['last_name'];?></strong></div>
			  		<div class="col-md-3 msgdate"><?php echo time_elapsed_string($pm['message_date']);?></div>
			  		<div class="col-md-12 msgbody"><?php echo $pm['message_text'];?></div>
			  	</a>
		  		<?php } ?>
		  	<?php } ?>
		  <?php }else{ ?>
	  		<div class="col-md-12"><p class="text-center py-3 p-sm-5">You do not have any messages</p></div>
		  <?php } ?>
	  </div>
	</div>
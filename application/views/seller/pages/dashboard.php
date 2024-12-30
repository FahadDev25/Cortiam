
	<div class="card">
	  <div class="card-header header-elements-inline">
			<h3 class="card-title"><span class="icon-co-big orange envelope"></span> New Messages</h3>
	  </div>
	  <div class="card-body">
			<div class="row">
		  <?php if($pms){ ?>
			  <?php  foreach ($pms as $pm) { ?>
			  	<?php if ($pm['msg_type'] == 'message') {?>
			  	<a href="<?php echo cortiam_base_url('message-center');?>" class="row no-gutters messagelistitem">
			  		<div class="col-md-9 msgtitle"><strong><?php echo $pm['first_name'].' '.$pm['last_name'];?></strong></div>
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
	</div>

	<div class="card">
	  <div class="card-header header-elements-inline">
			<h3 class="card-title"><span class="icon-co-big orange agent"></span> Agents</h3>
			<div class="header-elements">
				<div class="dropdown d-inline">
					<a href="#" role="button" id="questiontab-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="icon-co-big question"></span></a>
				  <div class="dropdown-menu dropdown-menu-right larger" aria-labelledby="questiontab-3" id="questiontab-3">
						<p><b>Agents:</b> All available agents in sellers area<br>
						<b>Favorite Agents:</b> Agents sellers have saved for later<br>
						<b>My Agents:</b> Agents seller has agreed to work with</p>
				  </div>
				</div>
				<a href="#" class="dofullscreen"><span class="icon-co-big expand"></span></a>
			</div>
	  </div>
	  <div class="card-body">
      <nav>
        <div class="nav nav-tabs nav-fill proptabs" id="nav-tab" role="tablist">
          <a class="nav-item nav-link active" id="nav-ag-tab" data-toggle="tab" href="#nav-ag" role="tab" aria-controls="nav-ag" aria-selected="false">Agents</a>
          <a class="nav-item nav-link" id="nav-fa-tab" data-toggle="tab" href="#nav-fa" role="tab" aria-controls="nav-fa" aria-selected="false">Favorite Agents</a>
          <a class="nav-item nav-link" id="nav-ya-tab" data-toggle="tab" href="#nav-ya" role="tab" aria-controls="nav-ya" aria-selected="false">My Agents</a>
        </div>
      </nav>
      <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-ag" role="tabpanel" aria-labelledby="nav-ag-tab">

        	<?php if ($express_agents){ ?>
					<div class="row carousel justify-content-center">
						<?php
							foreach ($express_agents as $express_agent) {
								echo generate_agent_card($express_agent);
							}
						?>
					</div>
					<?php }else{ ?>
						<h4 class="py-3 p-sm-5 text-center">You have no agents at this moment</h4>
					<?php } ?>

        </div>
        <div class="tab-pane fade show" id="nav-fa" role="tabpanel" aria-labelledby="nav-fa-tab">

					<div class="row carousel justify-content-center">
        	<?php if ($saved_agents){ ?>
						<?php
							foreach ($saved_agents as $saved_agent) {
								echo generate_agent_card($saved_agent, true);
							}
						?>
					<?php }else{ ?>
						<h4 class="py-3 p-sm-5 text-center" id="nofavtext">You have no favorite agent at this moment.</h4>
					<?php } ?>
					</div>

        </div>
        <div class="tab-pane fade show" id="nav-ya" role="tabpanel" aria-labelledby="nav-ya-tab">

        	<?php if ($dealed_agents){ ?>
					<div class="row carousel justify-content-center">
						<?php
							foreach ($dealed_agents as $dealed_agent) {
								echo generate_agent_card($dealed_agent);
							}
						?>
					</div>
					<?php }else{ ?>
						<h4 class="py-3 p-sm-5 text-center">You have no agents at this moment</h4>
					<?php } ?>

        </div>

	  	</div>
	  </div>
	  <div class="card-footer"></div>
	</div>


 	<?php if ($my_properties) {?>
	<div class="card">
	  <div class="card-header header-elements-inline">
			<h3 class="card-title"><span class="icon-co-big orange proplist"></span> Your Properties</h3>
			<div class="header-elements">
				<div class="dropdown d-inline">
					<a href="#" role="button" id="questiontab-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="icon-co-big question"></span></a>
				  <div class="dropdown-menu dropdown-menu-right larger" aria-labelledby="questiontab-2" id="questiontab-2">
						<p>Properties added by the seller up for bid.</p>
				  </div>
				</div>
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
	  <div class="card-footer  text-center">
		  <?php if (count($my_properties) >= 12) { ?>
			<div class="row">
		  	<div class="col-md-12"><a href="<?php echo cortiam_base_url('list-properties');?>" class="button-underline-gray">View All Properties</a></div>
		  </div>
		  <?php } ?>
	  </div>
	</div>
 	<?php } ?>
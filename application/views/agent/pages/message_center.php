	<div class="card" id="couponlistpart">
	  <div class="card-header header-elements-inline">
			<h3 class="card-title"><span class="icon-co-big orange envelope"></span> Message Center</h3>
<!--			<div class="header-elements">
				<div class="dropdown d-inline">
					<span role="button" id="dropdownSettingsLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sort by <i class="icon-arrow-down5 mr-3 icon-2x"></i></span>
				  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownSettingsLink">
						<a href="<?php echo base_url('agent/');?>#" class="dropdown-item">Date Ascending</a>
						<a href="<?php echo base_url('agent/');?>#" class="dropdown-item">Date Descending</a>
				  </div>
				</div>
			</div>-->
	  </div>
	  <div class="card-body">
		  <?php if($messages){ ?>
			  <?php  foreach ($messages as $message) { ?>
			  	<a href="<?php echo cortiam_base_url('view-messages/').$message['seller_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $message['first_name'][0].' '.$message['last_name'][0])), 'underscore', true);?>" class="row no-gutters messagelistitem">
			  		<div class="col-md-9 msgtitle"><strong><?php echo $message['first_name'][0].'.'.$message['last_name'][0].'.';?></strong></div>
			  		<div class="col-md-3 msgdate"><?php echo time_elapsed_string($message['message_date']);?></div>
			  		<div class="col-md-12 msgbody"><?php echo $message['message_text'];?></div>
			  	</a>
		  	<?php } ?>
		  <?php }else{ ?>
	  		<div class="col-md-12"><p class="text-center py-3 p-sm-5">You do not have any messages</p></div>
		  <?php } ?>
	  </div>
	</div>
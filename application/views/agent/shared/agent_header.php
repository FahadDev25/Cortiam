<!DOCTYPE html>
<html lang="en">

	<head>
		<base href="../">
		<meta charset="utf-8" />
    <title><?php echo $header_data['meta_title']; ?></title>
    <link rel="icon" type="image/png" href="<?php echo base_url('/favicon.png');?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<?php if($header_data['auto_refresh']){ ?><meta http-equiv="refresh" content="<?php echo $header_data['auto_refresh'];?>"><?php }?>

		<!--begin::Global Theme Styles(used by all pages) -->
    <?php if (isset($header_data['css_files'])) { echo "\n\t<link rel=\"stylesheet\" href=\"".implode("\" />\n\t<link rel=\"stylesheet\" href=\"", $header_data['css_files'])."\" />\n";}?>
    <?php if (isset($header_data['js_files'])) { echo "\n\t<script src=\"".implode("\"></script>\n\t<script src=\"", $header_data['js_files'])."\"></script>\n";}?>
		<!--end::Global Theme Styles -->
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<!-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-178011517-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'UA-178011517-1');
		</script> -->
	</head>
	<header>
		<div class="navigation">
			<div class="container">
			  <div class="row">
			    <div class="col-lg-3 col-md-5 col-2">
						<a href="<?php echo base_url('agent');?>" class="float-left">
							<img src="<?php echo base_url('images/cortiam_logo.png');?>" class="cortiam-logo d-none d-md-block" alt="Cortiam">
							<img src="<?php echo base_url('images/cortiam_responsive_logo.png');?>" class="cortiam-logo d-block d-md-none" alt="Cortiam">
						</a>
			  	</div>
			    <div class="col-lg-9 col-md-7 col-10 white-bg text-right">
						<div class="dropdown d-inline">
						<a href="<?php echo base_url('agent/tutorials');?>" class="icon-co-sm hat mr-3" data-display="tooltip" data-placement="left" title="Click to view tutorials"></a>
						<a href="<?php echo base_url('agent');?>" class="icon-co-sm envelope mr-3" data-display="tooltip" data-placement="left" title="Your Messages" role="button" id="latestmsg" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo (($count_pms = count($pms))? '<span class="badge orange-bg bubble animated flash">'.$count_pms.'</span>':'');?></a>
						  <div class="dropdown-menu links dropdown-menu-right" aria-labelledby="latestmsg">
						  	<?php
						  	if($pms) {
						  		foreach ($pms as $pm) {
						  			if ($pm['msg_type'] == 'message') {
						  				$pms_message++;
						  				echo '<div class="dropdown-item"><a href="'.cortiam_base_url('message-center').'"><span class="icon-co-sm message"></span> Message from '.$pm['first_name'].' '.$pm['last_name'].'</a></div>';
						  			}else{
						  				$pms_supports++;
						  				echo '<div class="dropdown-item"><a href="'.cortiam_base_url('support-center').'"><span class="icon-co-sm support"></span> Support message from '.$pm['first_name'].' '.$pm['last_name'].'</a></div>';
						  			}
						  		}
						  	}else{
						  		echo '<div class="dropdown-item text-center"><div class="p-2"><span class="icon-co-sm message"></span> No new messages</div></div>';
						  	}
						  	?>
							</div>
						</div>
						<div class="dropdown d-inline">
						<a href="<?php echo base_url('agent');?>#" class="icon-co-sm bell mr-3" role="button" id="latestnotify" data-display="tooltip" data-placement="left" title="Your Notifications" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo (($count_usno = (count($usnos) + count($usnots)))? '<span class="badge orange-bg bubble animated flash">'.$count_usno.'</span>':'');?></a>
						  <div class="dropdown-menu links dropdown-menu-right" aria-labelledby="latestnotify">
						  	<?php
						  	if($usnos) {
						  		foreach ($usnos as $usno) {
						  			echo '<div class="dropdown-item"><a href="'.cortiam_base_url('proposals').'"><span class="icon-co-sm proposal"></span> New proposal from '.$usno['first_name'].' '.$usno['last_name'].'</a></div>';
						  		}
						  		if($usnots) {
							  		foreach ($usnots as $usnot) {
											switch ($usnot['action']) {
												case 'account_declined':
													$usnotlink = cortiam_base_url('approval-process');
													break;
												default:
													$usnotlink = cortiam_base_url('notifications');
													break;
											}
							  			echo '<div class="dropdown-item"><a href="'.$usnotlink.'"><span class="icon-co-sm bell"></span>'.$usnot['title'].'</a></div>';
							  		}
						  		}
						  	}elseif($usnots) {
						  		foreach ($usnots as $usnot) {
						  			echo '<div class="dropdown-item"><a href="'.cortiam_base_url('notifications').'"><span class="icon-co-sm bell"></span>'.$usnot['title'].'</a></div>';
						  		}
						  	}else{
						  		echo '<div class="dropdown-item text-center empty"><span class="icon-co-sm bell"></span> No new notification</div>';
						  	}
						  	?>
							</div>
						</div>
						<div class="dropdown d-inline">
							<img class="img-fluid rounded-circle user-avatar" src="<?php echo (($account['avatar_string'])? base_url($account['avatar_string']):base_url('assets/images/backend/userphoto.jpg'));?>" width="46" height="46" role="button" id="useravatarsmall" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

						  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="useravatarsmall">
						  	<div class="dropdown-item avatar-item"><img class="img-fluid" src="<?php echo (($account['avatar_string'])? base_url($account['avatar_string']):base_url('assets/images/backend/userphoto.jpg'));?>" width="200" height="200" id="useravatarbig"></div>
								<div class="dropdown-divider m-0"></div>
								<div class="dropdown-item"><a href="<?php echo cortiam_base_url('edit-account');?>" class="button-orange btn-file w-100 text-center" data-toggle="tooltip" data-placement="left" title="Click to change">Change Photo<input type="file" class="file-input" id="avatarupload" accept="image/*;capture=camera"></a></div>
								<div class="dropdown-divider m-0"></div>
								<div class="dropdown-item"><a class="button-dark w-100 text-center" href="<?php echo base_url('logout');?>">Logout</a></div>
						  </div>
	    				<a href="#" id="res_menu_icon"><span class="icon-co-big orange menu"></span></a>
						</div>
			  	</div>
			  </div>
		  </div>
	  </div>
	</header>
	<main role="main" class="fill">
		<div class="content fill">
			<div class="container fill">
			  <div class="row fill">
			    <div class="col-md-12 col-lg-3 gray-bg" style="min-height:850px" id="membermenu">
						<nav class="nav flex-column">
						  <a class="nav-link <?php echo (($header_data['current_menu'] == 'dashboard')? 'active':'');?>" href="<?php echo cortiam_base_url('');?>"><span class="icon-co-sm dashboard"></span> Agent Dashboard</a>
						  <a class="nav-link <?php echo (($header_data['current_menu'] == 'editaccount')? 'active':'');?>" href="<?php echo cortiam_base_url('edit-account');?>"><span class="icon-co-sm account"></span> My Account</a>
						  <a class="nav-link <?php echo (($header_data['current_menu'] == 'myplan')? 'active':'');?>" href="<?php echo cortiam_base_url('my-plan');?>"><span class="icon-co-sm bars"></span> My Membership Plan</a>
     					  <a class="nav-link <?php echo (($header_data['current_menu'] == 'profile')? 'active':'');?>" href="<?php echo cortiam_base_url('my-profile');?>"><span class="icon-co-sm profile"></span> My Profile</a>
						  <a class="nav-link <?php echo (($header_data['current_menu'] == 'proposals')? 'active':'');?>" href="<?php echo cortiam_base_url('proposals');?>"><span class="icon-co-sm proposal"></span> Introductions<?php echo (($count_usno = count($usnos))? '<span class="badge orange-bg bubble lmenu animated flash">'.$count_usno.'</span>':'');?></a>
						  <a class="nav-link <?php echo (($header_data['current_menu'] == 'agreements')? 'active':'');?>" href="<?php echo cortiam_base_url('agreements');?>"><span class="icon-co-sm agreement"></span> Properties Won<?php echo (($uswapp)? '<span class="badge orange-bg bubble lmenu animated flash">'.count($uswapp).'</span>':'');?></a>
						  <a class="nav-link <?php echo (($header_data['current_menu'] == 'messagecenter')? 'active':'');?>" href="<?php echo cortiam_base_url('message-center');?>"><span class="icon-co-sm envelope"></span> Message Center<?php echo (($pms_message)? '<span class="badge orange-bg bubble lmenu animated flash">'.$pms_message.'</span>':'');?></a>
						  <a class="nav-link <?php echo (($header_data['current_menu'] == 'discount')? 'active':'');?>" href="<?php echo cortiam_base_url('my-coupons');?>"><span class="icon-co-sm discount"></span> Discount / Coupon Codes</a>
						  <a class="nav-link <?php echo (($header_data['current_menu'] == 'support')? 'active':'');?>" href="<?php echo cortiam_base_url('support-center');?>"><span class="icon-co-sm support"></span> Contact Support<?php echo (($pms_supports)? '<span class="badge orange-bg bubble lmenu animated flash">'.$pms_supports.'</span>':'');?></a>
						  <a class="nav-link <?php echo (($header_data['current_menu'] == 'tutorial')? 'active':'');?>" href="<?php echo cortiam_base_url('tutorials');?>"><span class="icon-co-sm hat"></span> Tutorial</a>
						  <a class="nav-link <?php echo (($header_data['current_menu'] == 'video')? 'active':'');?>" href="<?php echo cortiam_base_url('video');?>"><span class="icon-co-sm hat"></span> Introduction Video</a>

						  <a class="nav-link" href="<?php echo base_url('logout');?>#"><span class="icon-co-sm logout"></span> Logout</a>
						</nav>
						<div class="memberbox">
							<div class="dropdown">
								<a href="#" role="button" id="questiontab-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="icon-co-big halfsize question"></span></a>
							  <div class="dropdown-menu dropdown-menu-right larger" aria-labelledby="questiontab-1" id="questiontab-1">
									<p><b>Remaining Introductions:</b> This number indicates the remaining opportunities you have to introduce yourself to potential clients. Each agent can have (10) pending introductions.</p>
									<p><b>Remaining Wins:</b> This number indicates monthly clients allowed per agent</p>
							  </div>
							</div>
							<div class="memberboxrow">
								<h5 class="mb-0">Membership Status</h5>
			    			<div>
			    			<?php if ($account['approval'] == 'Waiting') { ?>
			    				Waiting Approval
			    			<?php }elseif ($account['approval'] == 'Denied') { ?>
				   				<?php if ($account['licenses']['no_license'] || $account['licenses']['no_active_license']) { ?>
			    				Locked<br><a class="memberboxbutton" href="<?php echo cortiam_base_url('edit-account');?>#licensespart">(No active License)</a>
				   				<?php  }else{ ?>
			    				Denied<br><a class="memberboxbutton" href="<?php echo cortiam_base_url('edit-account');?>#editprofileform">(Click to Update Details)</a>
				   				<?php  } ?>
			    			<?php }else{ ?>
			    				<?php if(!$account['payment_id']){ ?>
			    					<?php if ($account['free_starts'] && $account['free_ends']) { ?>
			    						<?php if ($account['free_ends'] < time()) { ?>
			    						Free Period Expired<br><a class="memberboxbutton" href="<?php echo cortiam_base_url('edit-account');?>#paymentpart">(Click Here to Upgrade for<br>$59.95 per Month)</a>
			    						<?php }else{ ?>
			    						Free Period<br><a class="memberboxbutton" href="<?php echo cortiam_base_url('edit-account');?>#paymentpart">(Click Here to Upgrade for<br>$59.95 per Month)</a>
			    						<?php } ?>
			    					<?php }else{ ?>
			    					Inactive<br><a class="memberboxbutton" href="<?php echo cortiam_base_url('edit-account');?>#paymentpart">(Click Here to Upgrade for<br>$59.95 per Month)</a>
			    					<?php } ?>
			    				<?php }else{ ?>
		    						<?php if ($account['membership_due'] < time()) { ?>
			    						Inactive<br><a class="memberboxbutton" href="<?php echo cortiam_base_url('edit-account');?>#paymentpart">(Click Here to Upgrade for<br>$59.95 per Month)</a>
			    					<?php }else{ ?>
			    						Active
			    					<?php } ?>
			    				<?php } ?>
			    			<?php } ?>

			    			</div>
		    				<hr class="my-2">
							</div>
							<?php if (($account['free_starts'] < time()) && ($account['free_ends'] > time())) { ?>
							<div class="memberboxrow">
								<h5 class="mb-0">Free Membership Period</h5>
		    				<div><?php echo date('m/d/Y', $account['free_starts']);?> - <?php echo date('m/d/Y', $account['free_ends']);?></div>
		    				<hr class="my-2">
		    			</div>
		    			<?php } ?>

		    			<?php if($account['payment_id']){ ?>
							<div class="memberboxrow">
								<h5 class="mb-0">Membership Period</h5>
			    			<?php if($account['membership_due'] > time()){ ?>
			    			<div><?php echo date('m/d/Y', ($account['membership_due'] - 2629743));?> - <?php echo date('m/d/Y', $account['membership_due']);?></div>
			    			<?php }else{ ?>
			    			<div>Ends on <?php echo date('m/d/Y', $account['membership_due']);?></div>
			    			<?php } ?>
		    				<hr class="my-2">
		    			</div>
		    			<?php } ?>
							<div class="memberboxrow">
								<h5 class="mb-0">Remaining Introductions</h5>
								<div><?php echo $account['offer_remain'];?> / <?php echo $account['offer_limit'];?></div>
			    			<hr class="my-2">
							</div>
							<div class="memberboxrow">
								<h5 class="mb-0">Remaining Wins</h5>
								<div><?php echo $account['win_remain'];?> / <?php echo $account['win_limit'];?></div>
							</div>
						</div>
			    </div>
			   	<div class="col-md-12 col-lg-9 maincontent min-vh-100 posunset">
			   	<div class="stickytop">
			   	<?php if ($account['approval'] == 'Waiting') { ?>
			   		<div class="approvalmessage"> Your account is currently pending approval by the Cortiam administrators. Please check your profile details to ensure that your information correct and complete to speed up your approval process.</div>
			   	<?php  } ?>
			   	<?php if ($account['licenses']['no_license']) { ?>
			   		<div class="approvalmessage">Please add your real estate agent license information before you continue using our system. After you update your license information, the details will need to be approved by the Cortiam administrators and your account will be enabled shortly after.</div>
			   	<?php  } ?>
			   	<?php if ($account['licenses']['expired_license']) { ?>
			   		<div class="approvalmessage">Your real estate agent <?php echo (count($account['licenses']['expired_states']) > 1)? 'licenses':'license';?> for <?php echo implode(", ", $account['licenses']['expired_states'])?> has expired. Please update your license information with your new license details before you continue using our system. After you update your license information, the details will need to be approved by the Cortiam administrators and your account will be enabled shortly after.</div>
			   	<?php  } ?>
			   	<?php if ($account['licenses']['declined_license']) { ?>
			   		<div class="approvalmessage">Your real estate agent <?php echo (count($account['licenses']['declined']) > 1)? 'licenses':'license';?> for <?php echo implode(", ", $account['licenses']['declined_states'])?> has declined. Please update your license information with your new license details before you continue using our system. After you update your license information, the details will need to be approved by the Cortiam administrators and your account will be enabled shortly after.</div>
			   	<?php  } ?>
			   	<?php if ($account['approval'] == 'Denied') { ?>
				   	<?php if ($account['licenses']['no_license'] || $account['licenses']['no_active_license']) { ?>
				   		<div class="approvalmessage"> Your account is locked because your <?php echo (count($account['licenses']['expired_states']) > 1)? 'licenses':'license';?> expired. Please update your license information with your new license details before you continue using our system. After you update your license information, the details will need to be approved by the Cortiam administrators and your account will be enabled shortly after.</div>
				   	<?php  }else{ ?>
				   		<div class="approvalmessage"> Your account application is currently denied by the Cortiam administrators. Please check your <a href="<?php echo cortiam_base_url('approval-process');?>">approval page</a> for more details and ensure that your missing/wrong information fixed before apply again for a new approval process.</div>
				   	<?php  } ?>
			   	<?php  } ?>
			   	<?php if (($account['approval'] == 'Completed') && (!$account['payment_id'])) { ?>
			   		<?php if ($account['free_starts'] && $account['free_ends']) { ?>
				   		<?php if ($account['free_ends'] < time()) { ?>
					   		<div class="approvalmessage"> Your free trial period expired. Because your acount doesn't have any active payment method, we cannot extend your membership period. Please check and update your payment method in <a href="<?php echo cortiam_base_url('edit-account');?>#paymentpart" class="button-orange">your account</a> details to continue your membership.</div>
					   	<?php  }else{ ?>
						   	<?php if ($account['free_ends'] < strtotime('+ 7 days')) { ?>
					   		<div class="approvalmessage"> Your free trial period will expire on <?php echo date('m/d/Y h:i A', $account['free_ends']);?>. Because your account doesn't have any active payment method, your membership will be stopped. If you want to continue your membership, please check and update your payment method in <a href="<?php echo cortiam_base_url('edit-account');?>#paymentpart" class="button-orange">your account</a> details.</div>
					   		<?php  } ?>
				   		<?php  } ?>
			   		<?php  }else{ ?>
				   		<div class="approvalmessage"> Your account doesn't have any active payment method.<br>Please check and update your payment method in <a href="<?php echo cortiam_base_url('edit-account');?>#paymentpart" class="button-orange">your account</a> details to continue your membership.</div>
			   		<?php  } ?>
			   	<?php  }else if (($account['approval'] == 'Completed') && ($account['membership_due'] < time())) { ?>
			   		<div class="approvalmessage"> Your accounts expired because your payment cannot collected automatically. Please check and update your payment method in <a href="<?php echo cortiam_base_url('edit-account');?>#paymentpart" class="button-orange">your account</a> details to <?php echo ((is_null($account['membership_due']))? 'start':'continue')?> your membership.</div>
			   	<?php  } ?>
			   	</div>
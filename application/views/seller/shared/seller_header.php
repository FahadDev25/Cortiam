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
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-178011517-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'UA-178011517-1');
		</script>
	</head>
	<header>
		<div class="navigation">
			<div class="container">
			  <div class="row">
			    <div class="col-lg-3 col-md-5 col-2">
						<a href="<?php echo base_url('seller');?>" class="float-left">
							<img src="<?php echo base_url('images/cortiam_logo.png');?>" class="cortiam-logo d-none d-md-block" alt="Cortiam">
							<img src="<?php echo base_url('images/cortiam_responsive_logo.png');?>" class="cortiam-logo d-block d-md-none" alt="Cortiam">
						</a>
			  	</div>
			    <div class="col-lg-9 col-md-7 col-10 white-bg text-right">
						<div class="dropdown d-inline">
						<a href="<?php echo base_url('seller/tutorials');?>" class="icon-co-sm hat mr-3" data-display="tooltip" data-placement="left" title="Click to view tutorials"></a>
						<a href="<?php echo base_url('seller');?>" class="icon-co-sm envelope mr-3" data-display="tooltip" data-placement="left" title="Your Messages" role="button" id="latestmsg" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo (($count_pms = count($pms))? '<span class="badge orange-bg bubble animated flash">'.$count_pms.'</span>':'');?></a>
						  <div class="dropdown-menu links dropdown-menu-right" aria-labelledby="latestmsg">
						  	<?php
						  	if($pms) {
						  		foreach ($pms as $pm) {
						  			if ($pm['msg_type'] == 'message') {
						  				$pms_message++;
						  				echo '<div class="dropdown-item"><a href="'.cortiam_base_url('message-center').'"><span class="icon-co-sm message"></span> New message from '.$pm['first_name'].' '.$pm['last_name'].'</a></div>';
						  			}else{
						  				$pms_supports++;
						  				echo '<div class="dropdown-item"><a href="'.cortiam_base_url('support-center').'"><span class="icon-co-sm support"></span> New support message from '.$pm['first_name'].' '.$pm['last_name'].'</a></div>';
						  			}
						  		}
						  	}else{
						  		echo '<div class="dropdown-item text-center"><div class="p-2"><span class="icon-co-sm message"></span> No new messages</div></div>';
						  	}
						  	?>
							</div>
						</div>
						<div class="dropdown d-inline">
						<a href="<?php echo base_url('seller');?>#" class="icon-co-sm bell mr-3" role="button" id="latestnotify" data-display="tooltip" data-placement="left" title="Your Notifications" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo (($count_usno = (count($usnos) + count($usnots)))? '<span class="badge orange-bg bubble animated flash">'.$count_usno.'</span>':'');?></a>
						  <div class="dropdown-menu links dropdown-menu-right" aria-labelledby="latestnotify">
						  	<?php
						  	if($usnos) {
						  		foreach ($usnos as $usno) {
						  			echo '<div class="dropdown-item"><a href="'.cortiam_base_url('agents').'"><span class="icon-co-sm proposal"></span> New interest from '.$usno['first_name'].' '.$usno['last_name'].'</a></div>';
						  		}
						  		if($usnots) {
							  		foreach ($usnots as $usnot) {
							  			echo '<div class="dropdown-item"><a href="'.cortiam_base_url('notifications').'"><span class="icon-co-sm bell"></span>'.$usnot['title'].'</a></div>';
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
						  	<div class="dropdown-item avatar-item"><img class="img-fluid" src="<?php echo (($account['avatar_string'])? base_url($account['avatar_string']):base_url('assets/images/backend/userphoto.jpg'));?>" width="200" height="200" title="<?php echo $account['first_name'].' '.$account['last_name'];?>" id="useravatarbig"></div>
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
						  <a class="nav-link <?php echo (($header_data['current_menu'] == 'dashboard')? 'active':'');?>" href="<?php echo cortiam_base_url('');?>"><span class="icon-co-sm dashboard"></span> Seller Dashboard</a>
						  <a class="nav-link <?php echo (($header_data['current_menu'] == 'editaccount')? 'active':'');?>" href="<?php echo cortiam_base_url('edit-account');?>"><span class="icon-co-sm account"></span> My Account</a>
						  <a class="nav-link <?php echo (($header_data['current_menu'] == 'addproperty')? 'active':'');?>" href="<?php echo cortiam_base_url('add-property');?>"><span class="icon-co-sm addnew"></span> Add/Edit Property</a>
						  <a class="nav-link <?php echo (($header_data['current_menu'] == 'agents')? 'active':'');?>" href="<?php echo cortiam_base_url('agents');?>"><span class="icon-co-sm agreement"></span> Agents<?php echo (($count_usno = count($usnos))? '<span class="badge orange-bg bubble lmenu animated flash">'.$count_usno.'</span>':'');?></a>
						  <a class="nav-link <?php echo (($header_data['current_menu'] == 'messagecenter')? 'active':'');?>" href="<?php echo cortiam_base_url('message-center');?>"><span class="icon-co-sm envelope"></span> Message Center<?php echo (($pms_message)? '<span class="badge orange-bg bubble lmenu animated flash">'.$pms_message.'</span>':'');?></a>
						  <a class="nav-link <?php echo (($header_data['current_menu'] == 'support')? 'active':'');?>" href="<?php echo cortiam_base_url('support-center');?>"><span class="icon-co-sm support"></span> Contact Support<?php echo (($pms_supports)? '<span class="badge orange-bg bubble lmenu animated flash">'.$pms_supports.'</span>':'');?></a>
						  <a class="nav-link <?php echo (($header_data['current_menu'] == 'tutorial')? 'active':'');?>" href="<?php echo cortiam_base_url('tutorials');?>"><span class="icon-co-sm hat"></span> Tutorial</a>
						  <a class="nav-link" href="<?php echo base_url('logout');?>#"><span class="icon-co-sm logout"></span> Logout</a>
						</nav>
			    </div>
			   	<div class="col-md-12 col-lg-9 maincontent min-vh-100 posunset">
			   	<?php if ($account['approval'] == 'Waiting') { ?>
			   		<div class="approvalmessage"> Your account is currently pending approval by the Cortiam administrators. Please check your profile details to ensure that your information correct and complete to speed up your approval process.</div>
			   	<?php  } ?>
			   	<?php if ($account['approval'] == 'Denied') { ?>
			   		<div class="approvalmessage"> Your account application is currently denied by the Cortiam administrators. Please check your <a href="<?php echo cortiam_base_url('approval-process');?>">approval page</a> for more details and ensure that your missing/wrong information fixed before apply again for a new approval process.</div>
			   	<?php  } ?>

<!DOCTYPE html>
<html lang="en">

	<head>
		<base href="../">
		<meta charset="utf-8" />
    <title><?php echo $header_data['meta_title']; ?></title>
    <link rel="icon" type="image/png" href="<?php echo base_url('/favicon.png');?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!--begin::Global Theme Styles(used by all pages) -->
    <?php if (isset($header_data['css_files'])) { echo "\n\t<link rel=\"stylesheet\" href=\"".implode("\" />\n\t<link rel=\"stylesheet\" href=\"", $header_data['css_files'])."\" />\n";}?>
    <?php if (isset($header_data['js_files'])) { echo "\n\t<script src=\"".implode("\"></script>\n\t<script src=\"", $header_data['js_files'])."\"></script>\n";}?>
		<!--end::Global Theme Styles -->
	</head>
<body>
	<!-- Main navbar -->
	<div class="navbar navbar-expand-md navbar-dark">
		<div class="navbar-brand">
			<a href="<?php echo base_url('ct-admin/');?>" class="d-inline-block">
				<img src="<?php echo base_url('assets/images/backend/cortiam_white_logo.png');?>" alt="Cortiam">
			</a>
		</div>

		<div class="d-md-none">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
				<i class="icon-tree5"></i>
			</button>
			<button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
				<i class="icon-paragraph-justify3"></i>
			</button>
		</div>

		<div class="collapse navbar-collapse pr-0" id="navbar-mobile">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
						<i class="icon-paragraph-justify3"></i>
					</a>
				</li>

			</ul>

			<span class="badge bg-success ml-md-3 mr-md-auto">Online</span>

			<ul class="navbar-nav">

				<li class="nav-item dropdown">

					<a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">
						<i class="icon-bell3"></i>
						<span class="d-md-none ml-2">System Notifications</span>
						<?php echo (($waiting_notifications)? '<span class="badge badge-pill bg-warning-400 ml-auto ml-md-0" id="notification_listing_amount">'.count($waiting_notifications).'</span>':'');?>
					</a>

					<div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-350">
						<div class="dropdown-content-header bg-dark-grey">
							<span class="font-weight-semibold">System Notifications</span>
							<a href="#" class="badge badge-secondary" id="clearallnotifications">Clear All</a>
						</div>

						<div class="dropdown-content-body dropdown-scrollable">
							<ul class="media-list" id="notification_listing">
								<?php if($waiting_notifications) {?>
									<?php
									foreach ($waiting_notifications as $waiting_notification) {
										switch ($waiting_notification['action']) {
											case 'agent_review':
												$link = base_url('ct-admin/review-agent/'.$waiting_notification['action_id']);
												break;
											case 'seller_review':
												$link = base_url('ct-admin/review-seller/'.$waiting_notification['action_id']);
												break;
											case 'property_review':
												$link = base_url('ct-admin/review-property/'.$waiting_notification['action_id']);
												break;
											case 'admin_review':
												$link = base_url('ct-admin/edit-administrator/'.$waiting_notification['action_id']);
												break;
											case 'agent_support':
												$link = base_url('ct-admin/view-agent-support/'.$waiting_notification['action_id']);
												break;
											case 'seller_support':
												$link = base_url('ct-admin/view-seller-support/'.$waiting_notification['action_id']);
												break;
											case 'agent_edit':
												$link = base_url('ct-admin/edit-agent/'.$waiting_notification['action_id']);
												break;
											case 'seller_edit':
												$link = base_url('ct-admin/edit-seller/'.$waiting_notification['action_id']);
												break;
											case 'property_edit':
												$link = base_url('ct-admin/edit-property/'.$waiting_notification['action_id']);
												break;
											default:
												$link = null;
												break;
										}
										echo '<li class="media">
														'.(($link)? '<a class="media-body text-dark" href="'.$link.'">':'<div class="media-body">').'
															<div class="media-title">
																<span class="font-weight-semibold w-100">'.$waiting_notification['title'].'</span>
																<span class="text-muted float-right font-size-sm w-100">'.date("Y-m-d h:i A",$waiting_notification['added_on']).'</span>
															</div>
															<span class="text-muted">'.$sup_request['message_title'].'</span>
														'.(($link)? '</a>':'</div>').'
													</li>';
									}
									?>
								<?php }else{?>
								<li class="text-center">No new notification<li>
								<?php }?>
							</ul>
						</div>
						<div class="dropdown-content-footer justify-content-center p-0">
							<a href="<?php echo base_url('ct-admin/notifications');?>" class="bg-dark-grey text-white w-100 py-2 text-center">View All Notifications</a>
						</div>
					</div>
				</li>
				<li class="nav-item dropdown">

					<a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">
						<i class="icon-lifebuoy"></i>
						<span class="d-md-none ml-2">Support Requests</span>
						<?php echo (($waiting_supports['All'])? '<span class="badge badge-pill bg-warning-400 ml-auto ml-md-0">'.$waiting_supports['All'].'</span>':'');?>
					</a>

					<div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-350">
						<div class="dropdown-content-header bg-dark-grey">
							<span class="font-weight-semibold">Support Requests</span>
						</div>

						<div class="dropdown-content-body dropdown-scrollable">
							<ul class="media-list">
								<?php if($waiting_supports['messages']) {?>
									<?php
									foreach ($waiting_supports['messages'] as $user_key => $sup_request) {
										echo '<li class="media">
														<div class="mr-3 position-relative">
															<img src="'.(($sup_request['user_image'])? base_url($sup_request['user_image']):base_url('images/userphoto.jpg')).'" width="36" height="36" class="rounded-circle" alt="">
														</div>

														<div class="media-body">
															<div class="media-title">
																<a href="'.(($sup_request['user_type'] == 'Agent')? base_url('ct-admin/view-agent-support/'.$user_key):base_url('ct-admin/view-seller-support/'.$user_key)).'">
																	<span class="font-weight-semibold">'.$sup_request['user'].'</span>
																	<span class="text-muted float-right font-size-sm">'.date("Y-m-d h:i A",$sup_request["message_date"]).'</span>
																</a>
															</div>

															<span class="text-muted">'.$sup_request['message_title'].'</span>
														</div>
													</li>';
									}
									?>
								<?php }else{?>
								<li class="text-center">No new message<li>
								<?php }?>
							</ul>
						</div>
						<div class="dropdown-content-footer justify-content-center p-0">
							<a href="<?php echo base_url('ct-admin/list-seller-support');?>" class="bg-dark-grey text-white w-50 py-2 text-center">View Owner Requests</a>
							<a href="<?php echo base_url('ct-admin/list-agent-support');?>" class="bg-dark-grey text-white w-50 py-2 text-center">View Agent Requests</a>
						</div>
					</div>
				</li>

				<li class="nav-item dropdown dropdown-user">
					<a href="<?php echo base_url('/ct-admin/edit-administrator/'.$account['admin_id']);?>" class="navbar-nav-link d-flex align-items-center" title="Your Profile">
						<img src="<?php echo (($account['avatar_string'])? base_url($account['avatar_string']):base_url('images/userphoto.jpg'));?>" class="rounded-circle mr-2" height="34" alt="">
						<span><?php echo $account['first_name'].' '.$account['last_name'];?></span>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?php echo base_url('logout');?>"class="navbar-nav-link" ><i class="icon-switch2"></i></a>
				</li>
			</ul>
		</div>
	</div>
	<!-- /main navbar -->
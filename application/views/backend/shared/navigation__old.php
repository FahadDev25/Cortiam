	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

			<!-- Sidebar mobile toggler -->
			<div class="sidebar-mobile-toggler text-center">
				<a href="#" class="sidebar-mobile-main-toggle">
					<i class="icon-arrow-left8"></i>
				</a>
				Navigation
				<a href="#" class="sidebar-mobile-expand">
					<i class="icon-screen-full"></i>
					<i class="icon-screen-normal"></i>
				</a>
			</div>
			<!-- /sidebar mobile toggler -->


			<!-- Sidebar content -->
			<div class="sidebar-content">

				<!-- User menu -->
				<div class="sidebar-user">
					<div class="card-body">
						<div class="media">
							<div class="mr-3">
								<a href="<?php echo base_url('ct-admin/');?>"><img src="<?php echo (($account['avatar_string'])? base_url($account['avatar_string']):base_url('assets/images/backend/userphoto.jpg'));?>" width="38" height="38" class="rounded-circle" alt=""></a>
							</div>

							<div class="media-body">
								<div class="media-title font-weight-semibold"><?php echo $account['first_name'].' '.$account['last_name'];?></div>
								<div class="font-size-xs opacity-50">
									<i class="icon-pin font-size-sm"></i><?php echo $account['city'].', '.$account['state'];?>
								</div>
							</div>

							<div class="ml-3 align-self-center">
								<a href="<?php echo base_url('/ct-admin/edit-administrator/'.$account['admin_id']);?>" class="text-white"><i class="icon-cog3"></i></a>
							</div>
						</div>
					</div>
				</div>
				<!-- /user menu -->


				<!-- Main navigation -->
				<div class="card card-sidebar-mobile">
					<ul class="nav nav-sidebar" data-nav-type="accordion">

						<!-- Main -->
						<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>
						<li class="nav-item"><a href="<?php echo base_url('ct-admin/');?>" class="nav-link<?php echo ($header_data['menuitem'] == 'dashboard')? ' active':'';?>"><i class="icon-home4"></i> <span>Dashboard</span></a></li>
						<?php if(($account['permissions'][10] == 'Yes') || ($account['permissions'][20] == 'Yes')){ ?>
						<li class="nav-item nav-item-submenu<?php echo ($header_data['menusection'] == 'admins')? ' nav-item-open':'';?>">
							<a href="#" class="nav-link"><i class="icon-user"></i> <span>Administrators</span></a>

							<ul class="nav nav-group-sub" data-submenu-title="Administrators" <?php echo ($header_data['menusection'] == 'admins')? 'style="display: block;"':'';?>>
								<?php if($account['permissions'][10] == 'Yes'){?><li class="nav-item"><a href="<?php echo base_url('ct-admin/list-administrator');?>" class="nav-link<?php echo ($header_data['menuitem'] == 'listadmin')? ' active':'';?>">List All</a></li><?php } ?>
								<?php if($account['permissions'][20] == 'Yes'){?><li class="nav-item"><a href="<?php echo base_url('ct-admin/add-administrator');?>" class="nav-link<?php echo ($header_data['menuitem'] == 'addadmin')? ' active':'';?>">Add New</a></li><?php } ?>
							</ul>
						</li>
						<?php } ?>
						<?php if(($account['permissions'][190] == 'Yes') || ($account['permissions'][200] == 'Yes')){ ?>
						<li class="nav-item nav-item-submenu<?php echo ($header_data['menusection'] == 'sellers')? ' nav-item-open':'';?>">
							<a href="#" class="nav-link"><i class="icon-users4"></i> <span>Property Owners</span></a>

							<ul class="nav nav-group-sub" data-submenu-title="Sellers" <?php echo ($header_data['menusection'] == 'sellers')? 'style="display: block;"':'';?>>
								<?php if($account['permissions'][190] == 'Yes'){?><li class="nav-item"><a href="<?php echo base_url('ct-admin/list-seller');?>" class="nav-link<?php echo ($header_data['menuitem'] == 'listseller')? ' active':'';?>">List All</a></li><?php } ?>
								<?php if($account['permissions'][200] == 'Yes'){?><li class="nav-item"><a href="<?php echo base_url('ct-admin/add-seller');?>" class="nav-link<?php echo ($header_data['menuitem'] == 'addseller')? ' active':'';?>">Add New</a></li><?php } ?>
							</ul>
						</li>
						<?php } ?>
						<?php if(($account['permissions'][60] == 'Yes') || ($account['permissions'][70] == 'Yes')){ ?>
						<li class="nav-item nav-item-submenu<?php echo ($header_data['menusection'] == 'agents')? ' nav-item-open':'';?>">
							<a href="#" class="nav-link"><i class="icon-users"></i> <span>Real Estate Agents</span></a>

							<ul class="nav nav-group-sub" data-submenu-title="Agents" <?php echo ($header_data['menusection'] == 'agents')? 'style="display: block;"':'';?>>
								<?php if($account['permissions'][60] == 'Yes'){?><li class="nav-item"><a href="<?php echo base_url('ct-admin/list-agent');?>" class="nav-link<?php echo ($header_data['menuitem'] == 'listagent')? ' active':'';?>">List All</a></li><?php } ?>
								<?php if($account['permissions'][70] == 'Yes'){?><li class="nav-item"><a href="<?php echo base_url('ct-admin/add-agent');?>" class="nav-link<?php echo ($header_data['menuitem'] == 'addagent')? ' active':'';?>">Add New</a></li><?php } ?>
							</ul>
						</li>
						<?php } ?>
						<?php if(($account['permissions'][261] == 'Yes')){ ?>
						<li class="nav-item nav-item-submenu<?php echo ($header_data['menusection'] == 'awaiting')? ' nav-item-open':'';?>">
							<a href="#" class="nav-link"><i class="icon-calendar22"></i> <span>Waitlist</span></a>

							<ul class="nav nav-group-sub" data-submenu-title="Awaiting" <?php echo ($header_data['menusection'] == 'awaiting')? 'style="display: block;"':'';?>>
								<?php if($account['permissions'][261] == 'Yes'){?><li class="nav-item"><a href="<?php echo base_url('ct-admin/awaiting-users');?>" class="nav-link<?php echo ($header_data['menuitem'] == 'awaiting')? ' active':'';?>">List All</a></li><?php } ?>
							</ul>
						</li>
						<?php } ?>
						<?php if(($account['permissions'][270] == 'Yes') || ($account['permissions'][280] == 'Yes')){ ?>
						<li class="nav-item nav-item-submenu<?php echo ($header_data['menusection'] == 'properties')? ' nav-item-open':'';?>">
							<a href="#" class="nav-link"><i class="icon-city"></i> <span>Properties</span></a>

							<ul class="nav nav-group-sub" data-submenu-title="Properties" <?php echo ($header_data['menusection'] == 'properties')? 'style="display: block;"':'';?>>
								<?php if($account['permissions'][270] == 'Yes'){?><li class="nav-item"><a href="<?php echo base_url('ct-admin/list-properties');?>" class="nav-link<?php echo ($header_data['menuitem'] == 'listproperty')? ' active':'';?>">List All</a></li><?php } ?>
								<?php if($account['permissions'][280] == 'Yes'){?><li class="nav-item"><a href="<?php echo base_url('ct-admin/add-property');?>" class="nav-link<?php echo ($header_data['menuitem'] == 'addproperty')? ' active':'';?>">Add New</a></li><?php } ?>
							</ul>
						</li>
						<?php } ?>
						<?php if(($account['permissions'][330] == 'Yes') || ($account['permissions'][350] == 'Yes') || ($account['permissions'][370] == 'Yes')){ ?>
						<?php
						$total_app_waiting += (($account['permissions'][330] == 'Yes')? 0:0);
						$total_app_waiting += (($account['permissions'][350] == 'Yes')? $waiting_approvals['Agent']:0);
						$total_app_waiting += (($account['permissions'][370] == 'Yes')? $waiting_approvals['Properties']:0);
						?>
						<li class="nav-item nav-item-submenu<?php echo ($header_data['menusection'] == 'approvals')? ' nav-item-open':'';?>">
							<a href="#" class="nav-link"><i class="icon-thumbs-up3"></i> <span>Approvals</span><?php echo (($total_app_waiting)? '<span class="badge badge-danger align-self-center ml-auto">'.$total_app_waiting.'</span>':'');?></a>
							<ul class="nav nav-group-sub" data-submenu-title="Approvals" <?php echo ($header_data['menusection'] == 'approvals')? 'style="display: block;"':'';?>>
<!--								<?php if($account['permissions'][330] == 'Yes'){?><li class="nav-item"><a href="<?php echo base_url('ct-admin/approval-sellers');?>" class="nav-link<?php echo ($header_data['menuitem'] == 'sellerapproval')? ' active':'';?>"><span>Property Owners</span><?php echo (($waiting_approvals['Seller'])? '<span class="badge badge-danger align-self-center ml-auto">'.$waiting_approvals['Seller'].'</span>':'');?></a></li><?php } ?>-->
								<?php if($account['permissions'][350] == 'Yes'){?><li class="nav-item"><a href="<?php echo base_url('ct-admin/approval-agents');?>" class="nav-link<?php echo ($header_data['menuitem'] == 'agentapproval')? ' active':'';?>"><span>Real Estate Agents</span><?php echo (($waiting_approvals['Agent'])? '<span class="badge badge-danger align-self-center ml-auto">'.$waiting_approvals['Agent'].'</span>':'');?></a></li><?php } ?>
								<?php if($account['permissions'][370] == 'Yes'){?><li class="nav-item"><a href="<?php echo base_url('ct-admin/approval-properties');?>" class="nav-link<?php echo ($header_data['menuitem'] == 'propertyapproval')? ' active':'';?>"><span>Properties</span><?php echo (($waiting_approvals['Properties'])? '<span class="badge badge-danger align-self-center ml-auto">'.$waiting_approvals['Properties'].'</span>':'');?></a></li><?php } ?>
							</ul>
						</li>
						<?php } ?>
						<?php if(($account['permissions'][400] == 'Yes') || ($account['permissions'][410] == 'Yes')){ ?>
						<li class="nav-item nav-item-submenu<?php echo ($header_data['menusection'] == 'coupons')? ' nav-item-open':'';?>">
							<a href="#" class="nav-link"><i class="icon-price-tag"></i> <span>Coupons</span></a>
							<ul class="nav nav-group-sub" data-submenu-title="Coupons" <?php echo ($header_data['menusection'] == 'coupons')? 'style="display: block;"':'';?>>
								<?php if($account['permissions'][400] == 'Yes'){?><li class="nav-item"><a href="<?php echo base_url('ct-admin/list-coupons');?>" class="nav-link<?php echo ($header_data['menuitem'] == 'listcoupon')? ' active':'';?>">List All</a></li><?php } ?>
								<?php if($account['permissions'][410] == 'Yes'){?><li class="nav-item"><a href="<?php echo base_url('ct-admin/add-coupon');?>" class="nav-link<?php echo ($header_data['menuitem'] == 'addcoupon')? ' active':'';?>">Add New</a></li><?php } ?>
							</ul>
						</li>
						<?php } ?>
						<?php if(($account['permissions'][580] == 'Yes') || ($account['permissions'][600] == 'Yes')){ ?>
						<li class="nav-item nav-item-submenu<?php echo ($header_data['menusection'] == 'supports')? ' nav-item-open':'';?>">
							<a href="#" class="nav-link"><i class="icon-lifebuoy"></i> <span>Support Requests</span><?php echo (($waiting_supports['All'])? '<span class="badge badge-danger align-self-center ml-auto">'.$waiting_supports['All'].'</span>':'');?></a>
							<ul class="nav nav-group-sub" data-submenu-title="Support Requests" <?php echo ($header_data['menusection'] == 'supports')? 'style="display: block;"':'';?>>
								<?php if($account['permissions'][580] == 'Yes'){?><li class="nav-item"><a href="<?php echo base_url('ct-admin/list-seller-support');?>" class="nav-link<?php echo ($header_data['menuitem'] == 'sellersupport')? ' active':'';?>">Property Owners Requests<?php echo (($waiting_supports['Seller'])? '<span class="badge badge-danger align-self-center ml-auto">'.$waiting_supports['Seller'].'</span>':'');?></a></li><?php } ?>
								<?php if($account['permissions'][600] == 'Yes'){?><li class="nav-item"><a href="<?php echo base_url('ct-admin/list-agent-support');?>" class="nav-link<?php echo ($header_data['menuitem'] == 'agentsupport')? ' active':'';?>">Real Estate Agent Requests<?php echo (($waiting_supports['Agent'])? '<span class="badge badge-danger align-self-center ml-auto">'.$waiting_supports['Agent'].'</span>':'');?></a></li><?php } ?>
							</ul>
						</li>
						<?php } ?>
						<?php if($account['permissions'][480] == 'Yes'){?><li class="nav-item"><a href="<?php echo base_url('ct-admin/list-messages');?>" class="nav-link<?php echo ($header_data['menuitem'] == 'messages')? ' active':'';?>"><i class="icon-comments"></i> <span>Messages</span></a></li><?php } ?>
						<?php if($account['permissions'][500] == 'Yes'){?><li class="nav-item"><a href="<?php echo base_url('ct-admin/list-introductions');?>" class="nav-link<?php echo ($header_data['menuitem'] == 'introductions')? ' active':'';?>"><i class="icon-drawer3"></i> <span>Introductions</span></a></li><?php } ?>
						<?php if($account['permissions'][510] == 'Yes'){?><li class="nav-item"><a href="<?php echo base_url('ct-admin/list-agreements');?>" class="nav-link<?php echo ($header_data['menuitem'] == 'agreements')? ' active':'';?>"><i class="icon-quill4"></i> <span>Agreements</span></a></li><?php } ?>
						<?php if(($account['permissions'][520] == 'Yes') || ($account['permissions'][530] == 'Yes') || ($account['permissions'][540] == 'Yes')){ ?>
						<li class="nav-item nav-item-submenu<?php echo ($header_data['menusection'] == 'reportings')? ' nav-item-open':'';?>">
							<a href="#" class="nav-link"><i class="icon-graph"></i> <span>Reportings</span></a>
							<ul class="nav nav-group-sub" data-submenu-title="Reportings" <?php echo ($header_data['menusection'] == 'reportings')? 'style="display: block;"':'';?>>
								<?php if($account['permissions'][520] == 'Yes'){?><li class="nav-item"><a href="<?php echo base_url('ct-admin/user-reporting');?>" class="nav-link<?php echo ($header_data['menuitem'] == 'userreporting')? ' active':'';?>">User Reporting</a></li><?php } ?>
								<?php if($account['permissions'][530] == 'Yes'){?><li class="nav-item"><a href="<?php echo base_url('ct-admin/property-reporting');?>" class="nav-link<?php echo ($header_data['menuitem'] == 'propertyreporting')? ' active':'';?>">Properties Reporting</a></li><?php } ?>
								<?php if($account['permissions'][540] == 'Yes'){?><li class="nav-item"><a href="<?php echo base_url('ct-admin/financial-reporting');?>" class="nav-link<?php echo ($header_data['menuitem'] == 'financialreporting')? ' active':'';?>">Financial Reporting</a></li><?php } ?>
							</ul>
						</li>
						<?php } ?>
						<?php if($account['permissions'][550] == 'Yes'){ ?>
						<li class="nav-item nav-item-submenu<?php echo ($header_data['menusection'] == 'tutorials')? ' nav-item-open':'';?>">
							<a href="#" class="nav-link"><i class="icon-graduation"></i> <span>Tutorial Pages</span></a>
							<ul class="nav nav-group-sub" data-submenu-title="Tutorial Pages" <?php echo ($header_data['menusection'] == 'tutorials')? 'style="display: block;"':'';?>>
								<?php if($account['permissions'][550] == 'Yes'){?><li class="nav-item"><a href="<?php echo base_url('ct-admin/tutorial-agent');?>" class="nav-link<?php echo ($header_data['menuitem'] == 'agenttutorial')? ' active':'';?>">Real Estate Agent Tutorial</a></li><?php } ?>
								<?php if($account['permissions'][550] == 'Yes'){?><li class="nav-item"><a href="<?php echo base_url('ct-admin/tutorial-seller');?>" class="nav-link<?php echo ($header_data['menuitem'] == 'sellertutorial')? ' active':'';?>">Property Owner Tutorial</a></li><?php } ?>
							</ul>
						</li>
						<?php } ?>
						<?php if(($account['permissions'][560] == 'Yes') || ($account['permissions'][570] == 'Yes')){ ?>
						<li class="nav-item nav-item-submenu<?php echo ($header_data['menusection'] == 'settings')? ' nav-item-open':'';?>">
							<a href="#" class="nav-link"><i class="icon-gear"></i> <span>Settings</span></a>
							<ul class="nav nav-group-sub" data-submenu-title="Location" <?php echo ($header_data['menusection'] == 'settings')? 'style="display: block;"':'';?>>
								<?php if(($account['permissions'][560] == 'Yes') || ($account['permissions'][570] == 'Yes')){?><li class="nav-item"><a href="<?php echo base_url('ct-admin/settings');?>" class="nav-link<?php echo ($header_data['menuitem'] == 'settings')? ' active':'';?>">General Settings</a></li><?php } ?>
								<?php if($account['permissions'][575] == 'Yes'){?><li class="nav-item"><a href="<?php echo base_url('ct-admin/free-period');?>" class="nav-link<?php echo ($header_data['menuitem'] == 'freepayment')? ' active':'';?>">Free Payment Period</a></li><?php } ?>
								<?php if($account['permissions'][576] == 'Yes'){?><li class="nav-item"><a href="<?php echo base_url('ct-admin/state-signup');?>" class="nav-link<?php echo ($header_data['menuitem'] == 'signup')? ' active':'';?>">Signup Settings</a></li><?php } ?>
							</ul>
						</li>
						<?php } ?>
						<?php if(($account['permissions'][440] == 'Yes') || ($account['permissions'][441] == 'Yes')){ ?>
						<li class="nav-item nav-item-submenu<?php echo ($header_data['menusection'] == 'location')? ' nav-item-open':'';?>">
							<a href="#" class="nav-link"><i class="icon-map4"></i> <span>Location</span></a>
							<ul class="nav nav-group-sub" data-submenu-title="Location" <?php echo ($header_data['menusection'] == 'location')? 'style="display: block;"':'';?>>
								<?php if($account['permissions'][440] == 'Yes'){?><li class="nav-item"><a href="<?php echo base_url('ct-admin/list-state');?>" class="nav-link<?php echo ($header_data['menuitem'] == 'liststates')? ' active':'';?>">List All</a></li><?php } ?>
								<?php if($account['permissions'][441] == 'Yes'){?><li class="nav-item"><a href="<?php echo base_url('ct-admin/add-state');?>" class="nav-link<?php echo ($header_data['menuitem'] == 'addstate')? ' active':'';?>">Add New</a></li><?php } ?>
							</ul>
						</li>
						<?php } ?>
						<li class="nav-item"><a href="<?php echo base_url('ct-admin/notifications');?>" class="nav-link<?php echo ($header_data['menuitem'] == 'notifications')? ' active':'';?>"><i class="icon-list"></i> <span>Notifications</span></a></li>

						<li class="nav-item"><a href="<?php echo base_url('ct-admin/memberships');?>" class="nav-link<?php echo ($header_data['menuitem'] == 'memberships')? ' active':'';?>"><i class="icon-list"></i> <span>Memberships</span></a></li>
						<!-- /page kits -->

					</ul>
				</div>
				<!-- /main navigation -->

			</div>
			<!-- /sidebar content -->

		</div>
		<!-- /main sidebar -->


		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
				    <?php if (isset($header_data['page_title'])) { echo '<h4 class="font-weight-semibold">'.$header_data['main_title'].'</h4>';}?>
						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>

					<div class="header-elements d-none">

					</div>
				</div>

				<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
					<div class="d-flex">
						<div class="breadcrumb">
							<?php
								if (isset($header_data['breadcrumb'])) {
									foreach ($header_data['breadcrumb'] as $key => $value) {
										if ($header_data['breadcrumb_links'][$key]) {
											echo '<a href="'.$header_data['breadcrumb_links'][$key].'" class="breadcrumb-item">'.(($key === 0)? '<i class="icon-home2 mr-2"></i> ':'').$value.'</a>';
										}else{
											echo '<span class="breadcrumb-item active">'.$value.'</span>';
										}
									}
								}
							?>
						</div>

						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>

					<div class="header-elements d-none">
					</div>
				</div>
			</div>
			<!-- /page header -->
			<!-- Content area -->
			<div class="content">

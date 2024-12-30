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
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-178011517-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'UA-178011517-1');
		</script>
	</head>
<body>
<header class="fixed-top">
	<div class="navigation">
		<div class="navcontainer">
		  <div class="row">
		    <div class="col-md-2 col-8">
					<a href="<?php echo base_url('');?>" class="d-inline-block">
						<img src="<?php echo base_url('images/cortiam_logo.png');?>" class="cortiam-logo" alt="Cortiam">
					</a>
		    </div>
		    <div class="col-4 d-block d-sm-none">
	    		<a href="#" id="res_menu_icon" class="float-right"><span class="icon-co-big orange menu"></span></a>
		    </div>
		    <div class="col-md-10 col-12" id="mainnav">
					<ul class="nav justify-content-end">
					  <li class="nav-item">
					    <a class="nav-link <?php echo (($header_data['current_menu'] == 'home')? 'active':'');?>" href="<?php echo base_url('');?>">Home</a>
					  </li>
					  <li class="nav-item">
					    <a class="nav-link <?php echo (($header_data['current_menu'] == 'setterms')? 'active':'');?>" href="<?php echo base_url('set-your-terms');?>">Set Your Terms</a>
					  </li>
					  <li class="nav-item">
					    <a class="nav-link <?php echo (($header_data['current_menu'] == 'findagent')? 'active':'');?>" href="<?php echo base_url('agents-on-cortiam');?>">Agents On Cortiam</a>
					  </li>
					  <li class="nav-item">
					    <a class="nav-link <?php echo (($header_data['current_menu'] == 'agentcenter')? 'active':'');?>" href="<?php echo base_url('agents');?>">Agents</a>
					  </li>
					  <li class="nav-item">
					    <a class="nav-link <?php echo (($header_data['current_menu'] == 'about')? 'active':'');?>" href="<?php echo base_url('about-us');?>">About Us</a>
					  </li>
					  <?php if($this->router->fetch_method() != 'login') { ?>
					  	<?php if ($this->ion_auth->logged_in())	{?>
						  	<?php if ($this->ion_auth->get_user_type() == 'Administrator')	{?>
						  		<li class="nav-item ml-5">
								    <a class="button-orange" href="<?php echo base_url('ct-admin');?>" tabindex="-1" aria-disabled="true">ACCOUNT</a>
								  </li>
						  	<?php }elseif ($this->ion_auth->get_user_type() == 'Agent')	{?>
						  		<li class="nav-item ml-5">
								    <a class="button-orange" href="<?php echo base_url('agent');?>" tabindex="-1" aria-disabled="true">ACCOUNT</a>
								  </li>
						  	<?php }elseif($this->ion_auth->get_user_type() == 'Seller'){ ?>
						  		<li class="nav-item ml-5">
								    <a class="button-orange" href="<?php echo base_url('seller');?>" tabindex="-1" aria-disabled="true">ACCOUNT</a>
								  </li>
						  	<?php }else{  ?>

								<li class="nav-item ml-md-5">
									<a class="button-orange" href="<?php echo base_url('login');?>" tabindex="-1" aria-disabled="true">LOGIN</a>
								</li>
								<?php } ?>
					  	<?php }else{ ?>
							  <li class="nav-item ml-md-5">
							    <a class="button-orange" href="<?php echo base_url('login');?>" tabindex="-1" aria-disabled="true">LOGIN</a>
							  </li>
					  	<?php } ?>
					  <?php } ?>
						
					</ul>
		    </div>
		  </div>
		</div>
	</div>
</header>
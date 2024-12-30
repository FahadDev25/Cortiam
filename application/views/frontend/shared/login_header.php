<!DOCTYPE html>
<html lang="en">

	<head>
		<base href="../">
		<meta charset="utf-8" />
    <title><?php echo $header_data['meta_title']; ?></title>
    <link rel="icon" type="image/png" href="<?php echo base_url('/favicon.ico');?>">
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
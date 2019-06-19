<!DOCTYPE html>
<html>
	<head>
		<!-- Basic -->
		<meta charset="utf-8">
		<title><?php echo $company['company_name']; ?></title>
		<meta name="keywords" content="Finquote - Broker CRM" />
		<meta name="description" content="Customer Relationship Management for Brokers">
		<meta name="author" content="Finquote - Broker CRM">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- Web Fonts  -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="<?php echo base_url('assets_login/vendor/bootstrap/bootstrap.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets_login/vendor/fontawesome/css/font-awesome.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets_login/vendor/owlcarousel/owl.carousel.min.css'); ?>" media="screen">
		<link rel="stylesheet" href="<?php echo base_url('assets_login/vendor/owlcarousel/owl.theme.default.min.css'); ?>" media="screen">
		<link rel="stylesheet" href="<?php echo base_url('assets_login/vendor/magnific-popup/magnific-popup.css'); ?>" media="screen">

		<!-- Dropzone Uploader -->
		<link rel="stylesheet" href="<?php echo base_url('assets/css/image_uploader/dropzone.css'); ?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/css/image_uploader/basic.css'); ?>" />	
		
		<!-- Sweet Alert -->
		<link rel="stylesheet" href="<?php echo base_url('assets/vendor/sweetalert/sweetalert.css'); ?>">		

		<!-- Theme CSS -->
		<link rel="stylesheet" href="<?php echo base_url('assets_login/css/theme.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets_login/css/theme-elements.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets_login/css/theme-blog.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets_login/css/theme-shop.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets_login/css/theme-animate.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets_login/css/datepicker.css'); ?>">

		<!-- Current Page CSS -->
		<link rel="stylesheet" href="<?php echo base_url('assets_login/vendor/rs-plugin/css/settings.css'); ?>" media="screen">
		<link rel="stylesheet" href="<?php echo base_url('assets_login/vendor/circle-flip-slideshow/css/component.css'); ?>" media="screen">

		<link rel="stylesheet" href="<?php echo base_url('assets_login/css/theme-admin-extension.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets_login/css/skins/extension.css'); ?>">		
		
		<!-- Skin CSS -->
		<link rel="stylesheet" href="<?php echo base_url('assets_login/css/skins/default.css'); ?>">

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="<?php echo base_url('assets_login/css/custom.css'); ?>">
		<?php if($company['favicon']!="" && file_exists($company['favicon']) ){ ?>
		<link rel="shortcut icon" href="<?php echo $company['favicon']; ?>" type="image/x-icon">
		<?php }else{ ?>
		<link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.png'); ?>" type="image/x-icon">
		<?php } ?>

		<!-- Head Libs -->
		<script src="<?php echo base_url('assets_login/vendor/modernizr/modernizr.js'); ?>?v=<?php echo time();?>"></script>
		
		
		<!--[if IE]>
			<link rel="stylesheet" href="<?php echo base_url('css/ie.css'); ?>">
		<![endif]-->

		<!--[if lte IE 8]>
			<script src="<?php echo base_url('assets_login/vendor/respond/respond.js'); ?>"></script>
			<script src="<?php echo base_url('assets_login/vendor/excanvas/excanvas.js'); ?>"></script>
		<![endif]-->	
	</head>
<!DOCTYPE html>
<html class="fixed sidebar-left-collapsed">
	<head>
		<!-- Basic -->
		<meta charset="UTF-8">
		<title><?php echo $company['company_name']; ?></title>
		<meta name="keywords" content="Finquote - Broker CRM" />
		<meta name="description" content="Customer Relationship Management for Brokers">
		<meta name="author" content="Finquote - Broker CRM">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.css'); ?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/vendor/font-awesome/css/font-awesome.css'); ?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/vendor/magnific-popup/magnific-popup.css'); ?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/vendor/bootstrap-datepicker/css/datepicker3.css'); ?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css'); ?>" />

		<!-- Specific Page Vendor CSS -->
		<link rel="stylesheet" href="<?php echo base_url('assets/vendor/select2/select2.css'); ?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css'); ?>" />

		<!-- Fixed Columns -->
		<link rel="stylesheet" href="<?php echo base_url('assets/vendor/jquery-datatables/extensions/FixedColumns/css/dataTables.fixedColumns.css'); ?>" />	

		<!-- Tags -->
		<link rel="stylesheet" href="<?php echo base_url('assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css'); ?>" />	
		
		<!-- Calendar -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.0/fullcalendar.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.0/fullcalendar.print.css" rel='stylesheet' media='print'>
		
		<!-- JS Tree -->
		<link rel="stylesheet" href="<?php echo base_url('assets/vendor/jstree/themes/default/style.css'); ?>" />

		<!-- Time Picker -->
		<link rel="stylesheet" href="<?php echo base_url('assets/vendor/bootstrap-timepicker/css/bootstrap-timepicker.min.css'); ?>" />

		<!-- Color Picker -->
		<link rel="stylesheet" href="<?php echo base_url('assets/vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.css'); ?>" />
		
		<!-- Sweet Alert -->
		<link rel="stylesheet" href="<?php echo base_url('assets/vendor/sweetalert/sweetalert.css'); ?>">
		
		<!-- Carousel -->
		<link rel="stylesheet" href="<?php echo base_url('assets/vendor/owl-carousel/owl.carousel.css'); ?>" />		
		<link rel="stylesheet" href="<?php echo base_url('assets/vendor/owl-carousel/owl.theme.css'); ?>" />

		<!-- Dashboard -->
		<link rel="stylesheet" href="<?php echo base_url('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css'); ?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/vendor/morris/morris.css'); ?>" />
		
		<!-- Dropzone Uploader -->
		<link rel="stylesheet" href="<?php echo base_url('assets/css/image_uploader/dropzone.css'); ?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/css/image_uploader/basic.css'); ?>" />		

		<!-- HTML Editor -->
		<link rel="stylesheet" href="<?php echo base_url('assets/vendor/summernote/summernote.css'); ?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/vendor/summernote/summernote-bs3.css'); ?>" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="<?php echo base_url('assets/css/theme.css'); ?>" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="<?php echo base_url('assets/css/skins/default.css'); ?>" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="<?php echo base_url('assets/css/theme-custom.css'); ?>">
		
		<?php if($company['favicon']!="" && file_exists($company['favicon']) ){ ?>
		<link rel="shortcut icon" href="<?php echo $company['favicon']; ?>" type="image/x-icon">
		<?php }else{ ?>
		<link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.png'); ?>" type="image/x-icon">
		<?php } ?>
		
		
		<link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css'); ?>" />
		<!-- Head Libs -->
		<script src="<?php echo base_url('assets/vendor/modernizr/modernizr.js'); ?>?v=<?php echo time();?>"></script>

		<style>
			a[href^="http://maps.google.com/maps"]{display:none !important}
			a[href^="https://maps.google.com/maps"]{display:none !important}
		
			.gmnoprint a, .gmnoprint span, .gm-style-cc {
			    display:none;
			}

			.gmnoprint div {
			    background:none !important;
			}
			
			.sq-input {
				border: 1px solid rgb(223, 223, 223);
				outline-offset: -2px;
				margin-bottom: 5px;
			}
			
			.sq-input--focus {
				/* Indicates how form inputs should appear when they have focus */
				outline: 5px auto rgb(59, 153, 252);
			}
			
			.sq-input--error {
				/* Indicates how form inputs should appear when they contain invalid values */
				outline: 5px auto rgb(255, 97, 97);
			}
		</style>
		<?php
		function substring_words ($text, $max_length, $end = '...') 
		{
			if (strlen($text) > $max_length || $text == '')
			{
				$words = preg_split('/\s/', $text);
				$output = '';
				$i = 0;
				while (1) 
				{
					$length = strlen($output)+strlen($words[$i]);
					
					if ($length > $max_length) 
					{
						break;
					} 
					else 
					{
						$output .= " " . $words[$i];
						++$i;
					}
				}
				$output .= $end;
			} 
			else 
			{
				$output = $text;
			}

			return $output;
		}
		?>
	</head>
<?php 
include("config.php");
if(@$_REQUEST['q'])
{
	
	$make = str_replace("Make=[",'',$_REQUEST['q']);
	$make = str_replace("]",'',$make);
	//$make = @$_REQUEST['q']['make'];
	
}else
{
	
	$make = @$_REQUEST['Make'];
}			
	
$s = @$_REQUEST['s'];
$evnt = @$_REQUEST['evnt'];
?>
<!DOCTYPE html>
<html class="fixed sidebar-left-collapsed">
<head>
<!-- Basic -->
<meta charset="UTF-8">
<title>Car Quotes Online | Car Broker CRM</title>
<meta name="keywords" content="Car Quotes Online" />
<meta name="description" content="Customer Relationship Management for Car Brokers">
<meta name="author" content="Car Quotes Online">
<!-- Mobile Metas -->
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<!-- Web Fonts  -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet" type="text/css">
<!-- Vendor CSS -->
<link rel="stylesheet" href="<?php echo SITEURL ?>/assets/vendor/bootstrap/css/bootstrap.css" />
<link rel="stylesheet" href="<?php echo SITEURL ?>/assets/vendor/font-awesome/css/font-awesome.css" />
<link rel="stylesheet" href="<?php echo SITEURL ?>/assets/vendor/magnific-popup/magnific-popup.css" />
<link rel="stylesheet" href="<?php echo SITEURL ?>/assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
<link rel="stylesheet" href="<?php echo SITEURL ?>/assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
<!-- Specific Page Vendor CSS -->
<link rel="stylesheet" href="<?php echo SITEURL ?>/assets/vendor/select2/select2.css" />
<link rel="stylesheet" href="<?php echo SITEURL ?>/assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
<!-- Fixed Columns -->
<link rel="stylesheet" href="<?php echo SITEURL ?>/assets/vendor/jquery-datatables/extensions/FixedColumns/css/dataTables.fixedColumns.css" />
<!-- Tags -->
<link rel="stylesheet" href="<?php echo SITEURL ?>/assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css" />
<!-- Calendar -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.0/fullcalendar.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.0/fullcalendar.print.css" rel='stylesheet' media='print'>
<!-- JS Tree -->
<link rel="stylesheet" href="<?php echo SITEURL ?>/assets/vendor/jstree/themes/default/style.css" />
<!-- Time Picker -->
<link rel="stylesheet" href="<?php echo SITEURL ?>/assets/vendor/bootstrap-timepicker/css/bootstrap-timepicker.min.css" />
<!-- Color Picker -->
<link rel="stylesheet" href="<?php echo SITEURL ?>/assets/vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.css" />
<!-- Sweet Alert -->
<link rel="stylesheet" href="<?php echo SITEURL ?>/assets/vendor/sweetalert/sweetalert.css">
<!-- Carousel -->
<link rel="stylesheet" href="<?php echo SITEURL ?>/assets/vendor/owl-carousel/owl.carousel.css" />
<link rel="stylesheet" href="<?php echo SITEURL ?>/assets/vendor/owl-carousel/owl.theme.css" />
<!-- Dashboard -->
<link rel="stylesheet" href="<?php echo SITEURL ?>/assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
<link rel="stylesheet" href="<?php echo SITEURL ?>/assets/vendor/morris/morris.css" />
<!-- Dropzone Uploader -->
<link rel="stylesheet" href="<?php echo SITEURL ?>/assets/css/image_uploader/dropzone.css" />
<link rel="stylesheet" href="<?php echo SITEURL ?>/assets/css/image_uploader/basic.css" />
<!-- HTML Editor -->
<link rel="stylesheet" href="<?php echo SITEURL ?>/assets/vendor/summernote/summernote.css" />
<link rel="stylesheet" href="<?php echo SITEURL ?>/assets/vendor/summernote/summernote-bs3.css" />
<!-- Theme CSS -->
<link rel="stylesheet" href="<?php echo SITEURL ?>/assets/css/theme.css" />
<!-- Skin CSS -->
<link rel="stylesheet" href="<?php echo SITEURL ?>/assets/css/skins/default.css" />
<!-- Theme Custom CSS -->
<link rel="stylesheet" href="<?php echo SITEURL ?>/assets/css/theme-custom.css">
<link rel="shortcut icon" href="<?php echo SITEURL ?>/assets/img/favicon.png" type="image/x-icon">
<link rel="stylesheet" href="<?php echo SITEURL ?>/assets/css/custom.css" />
<!-- Head Libs -->
<script src="<?php echo SITEURL ?>/assets/vendor/modernizr/modernizr.js"></script>
<style>
.pagination {
  /*  position: absolute;*/
  float:right;
    right: 5px;
    top: 39px;
    z-index: 1000;
}
.pagination li {
    float: left;
    padding: 0 2px;
}
.pagination li span {
    font-weight: bold;
    font-size: 11px;
    padding: 2px 6px;
    background-color: #AA0A24;
    color: White;
}
.pagination li a {
    text-decoration: none;
    color: #333;
    font-size: 11px;
    font-weight: bold;
    padding: 2px 6px;
}
.hide{
	display:none;
}
</style>
</head>
<body>
<section class="body">
	<header class="header">
		<div class="logo-container"> <a href="<?php echo SITEURL ?>/index.php" class="logo"> <img src="http://staging-new.finquote.com.au/assets/logo.png" height="35" alt="FinQuote" /> </a>
			<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened"> <i class="fa fa-bars" aria-label="Toggle sidebar"></i> </div>
		</div>
		<div class="header-right">
			<form action="submit.php" class="search nav-form">
				<div class="input-group input-search">
					<input type="text" class="form-control" name="q" id="q" placeholder="Search...">
					<span class="input-group-btn">
					<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
					</span> </div>
			</form>
			<span class="separator"></span>
			
			<span class="separator"></span>
			<div id="userbox" class="userbox"> <a href="#" data-toggle="dropdown">
				<figure class="profile-picture"> <img src="<?php echo SITEURL ?>/assets/img/!logged-user.jpg" alt="Tese F name Test L name" class="img-circle" data-lock-picture="<?php echo SITEURL ?>/assets/img/!logged-user.jpg" /> </figure>
				<div class="profile-info" data-lock-name="Tese F name Test L name" data-lock-email="paul@finquote.net.au"> <span class="name">Tese F name Test L name</span> <span class="role">QM Staff</span> </div>
				<i class="fa custom-caret"></i> </a>
				<div class="dropdown-menu">
					<ul class="list-unstyled">
						<li class="divider"></li>
						<li><a role="menuitem" tabindex="-1" href="<?php echo SITEURL ?>/index.php/admin/profile"><i class="fa fa-user"></i> My Profile</a></li>
						<li><a role="menuitem" tabindex="-1" href="<?php echo SITEURL ?>/index.php/user/logout"><i class="fa fa-power-off"></i> Logout</a></li>
					</ul>
				</div>
			</div>
		</div>
	</header>
	<div class="inner-wrapper">
		<aside id="sidebar-left" class="sidebar-left">
			<div class="sidebar-header">
				<div class="sidebar-title"> Navigation </div>
				<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle"> <i class="fa fa-bars" aria-label="Toggle sidebar"></i> </div>
			</div>
			<div class="nano">
				<div class="nano-content">
					<nav id="menu" class="nav-main" role="navigation">
						<ul class="nav nav-main">
							<li class=""> <a href="<?php echo SITEURL ?>/"> <i class="fa fa-home" aria-hidden="true"></i> <span>Home</span> </a> </li>
							
						</ul>
					</nav>
				</div>
			</div>
		</aside>
		<section role="main" class="content-body">
			<header class="page-header">
				<h2>Get Data</h2>
				<div class="right-wrapper pull-right">
					<ol class="breadcrumbs">
						<li> <a href="<?php echo SITEURL ?>/index.php"> <i class="fa fa-home"></i> </a> </li>
					</ol>
					<a class="sidebar-right-toggle" data-open=""><i class="fa fa-chevron-left"></i></a> </div>
			</header>
			<section class="panel">
				<header class="panel-heading">
					<div class="panel-actions"> <a href="#" class="fa fa-caret-down"></a> </div>
					<h2 class="panel-title">Get Data</h2>
				</header>
				<div class="panel-body">
					<form action="<?php echo SITEURL; ?>/submit.php" method="post" accept-charset="utf-8">
						<div class="row">
							<div class="form-group">
								<div class="col-md-6 text-left">
									<label>*Make:</label>
									<select class="form-control input-md" id="make" name="make_id">
										<option>Make</option>
										<?php
											
											$make_r = 'SELECT * FROM makes ORDER BY  id_make ASC';
											$make_r = mysqli_query($con,$make_r);
											
											if(mysqli_num_rows($make_r ) > 0)
											{
												while($makes = mysqli_fetch_array($make_r))
												{?>
													<option value="<?php echo $makes['id_make'] ?>" <?php echo $makes['id_make']==$make?'selected':''; ?>><?php echo $makes['name'] ?></option>
												<?php }
												
											}
											?>
									</select>
								</div>
								<div class="col-md-12"></div>
								<div class="col-md-6 text-left hide">
									<label>* Model:</label>
									<select class="form-control input-md" id="model" name="model_id">
										<option>Select Model</option>
										
									</select>
								</div>
								<div class="col-md-2">
									<label>&nbsp;</label>
									<input value="Get Data" name="submit" class="form-control btn btn-primary  push-bottom" data-loading-text="Loading..." type="submit">
								</div>
								
								
								<div class="col-md-2">
									<label>&nbsp;</label>
									<a target="_blank" href="https://staging-new.finquote.com.au/db.php" class="form-control btn btn-primary  push-bottom" data-loading-text="Loading..."> Update to Live</a>
								</div>
								
								
							</div>
						</div>
					</form>
					<div class="events-text"  style="padding:10px;">
					<table border="1" width="100%" cellpadding="5">
<?php
	$j = 0;
	$k = 0;
	//print_r($make);
	if($make!="")
	{
		$str = urlencode("Make=[".$make."]");
		
		
		$url ='https://www.redbook.com.au/cars/results?s='.$s.'&evnt='.$evnt.'&q='.$str;
		
		//$url ='https://www.redbook.com.au/cars/results?q='.$str;
		
		$html = file_get_html($url);

		foreach($html->find('div.content') as $e) {
			foreach($e->find('a.item') as $e2){
				$k++;
				?>
				<tr>
					<?php
					foreach($e2->find('div.photos') as $e6){
					?>
						<td style="width:150px"><?php
							foreach($e6->find('img') as $e66){
							?>
							<img src="<?php echo $e66->src; ?>">
							<?php
							}
							?>
						</td>
						<?php
					}
					
					foreach($e2->find('div.desc h3') as $e5){
					?>
						<td  style="width:33%"><h5 style="text-align: left;"> <?php echo nl2br($e5->plaintext); ?> </h5></td>
						<?php
					}
					
					foreach($e2->find('div.info span.price') as $e4){
					?>
						<td  style="width:33%"><h5 style="text-align: left;"> <?php echo nl2br($e4->plaintext); ?> </h5></td>
						<?php
					}
					foreach($e2->find('ul.summary') as $e3){
					?>
						<td style="width:33%"><ul>
								<?php
							foreach($e3->find('li') as $e31){
							?>
								<li><?php echo nl2br($e31->plaintext); ?></li>
								<?php
							}
							?>
							</ul></td>
						<?php
					}
					?>
				</tr>
				<?php
			}
		}?>
		<tr><td colspan="4"><ul class="pagination">
		<?php 
		$array_page = array();
		foreach($html->find('.footer-paging ul.pagination') as $p) {
			foreach($p->find('li') as $p2){
				
				
				/*?>
					<li><?php echo nl2br($p2->plaintext); ?> </li>
				
				<?php
				*/
				foreach($p2->find('span') as $p4){
				?>
					<li><?php echo nl2br($p4->plaintext); ?> </li>
				<?php
				}
				foreach($p2->find('a') as $p3){
					$href = str_replace("/cars/results?","",$p3->href);
				?>
					<li><a href="<?php echo SITEURL."/index.php?" ?><?php echo $href; ?>"> <?php echo nl2br($p3->plaintext); ?> </a></li>
				<?php 
				}
				/*
				foreach($p2->find('.prev') as $p3){
					$href = str_replace("/cars/results?","",$p3->href);
					$array_page['0']['num'] = nl2br($p3->plaintext);
					$array_page['0']['href'] = $href ;
				}
					
				foreach($p2->find('span') as $p4){
					
					$array_page[intval(nl2br($p4->plaintext))]['num'] = nl2br($p4->plaintext);
				}
				foreach($p2->find('a') as $p3){
					if(nl2br($p3->plaintext)!="Prev" && nl2br($p3->plaintext)!="Next")
					{
						$href = str_replace("/cars/results?","",$p3->href);
						$count = count($array_page);
						$array_page[$count]['num'] = nl2br($p3->plaintext);
						$array_page[$count]['href'] = $href ;
					}
				}
				foreach($p2->find('.next') as $p3){
					$href = str_replace("/cars/results?","",$p3->href);
					$count = count($array_page);
					$array_page[$count]['num'] = nl2br($p3->plaintext);
					$array_page[$count]['href'] = $href ;
					
					break;
				}		*/	
				
			}break;
			
		}
		/*print_r($array_page);
		foreach($array_page as $val)
		{
			if(isset($val['href']))
			{?>
				<li><a href="<?php echo SITEURL."/index.php?" ?><?php echo $val['href']; ?>"><?php echo $val['num']; ?></a></li>
			<?php }
			else
			{?>
				<li><?php echo $val['num']; ?> </li>
			<?php }
		}
		*/
		?>
		</ul></td></tr>
		<?php 
	}


?>
						</tr>
						
					</table>
					</div>
				</div>
			</section>
			<!-- end: page -->
		</section>
	</div>
</section>
<!-- Vendor -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.2/jquery.js"></script>
<script src="<?php echo SITEURL ?>/assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
<script src="<?php echo SITEURL ?>/assets/vendor/bootstrap/js/bootstrap.js"></script>
<script src="<?php echo SITEURL ?>/assets/vendor/nanoscroller/nanoscroller.js"></script>
<script src="<?php echo SITEURL ?>/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo SITEURL ?>/assets/vendor/magnific-popup/magnific-popup.js"></script>
<script src="<?php echo SITEURL ?>/assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
<script src="<?php echo SITEURL ?>/assets/vendor/pnotify/pnotify.custom.js"></script>
<!-- Calendar -->
<script src="<?php echo SITEURL ?>/assets/vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
<script src="<?php echo SITEURL ?>/assets/vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.0/fullcalendar.min.js"></script>
<!-- Data Table -->
<script src="<?php echo SITEURL ?>/assets/vendor/select2/select2.js"></script>
<script src="<?php echo SITEURL ?>/assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
<script src="<?php echo SITEURL ?>/assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
<script src="<?php echo SITEURL ?>/assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
<!-- Sweet Alert -->
<script src="<?php echo SITEURL ?>/assets/vendor/sweetalert/sweetalert.min.js"></script>
<!-- Carousel -->
<script src="<?php echo SITEURL ?>/assets/vendor/owl-carousel/owl.carousel.js"></script>
<!-- Tags -->
<script src="<?php echo SITEURL ?>/assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
<!-- Fixed Columns -->
<script src="<?php echo SITEURL ?>/assets/vendor/jquery-datatables/extensions/FixedColumns/js/dataTables.fixedColumns.js"></script>
<!-- Switch IO7 -->
<script src="<?php echo SITEURL ?>/assets/vendor/ios7-switch/ios7-switch.js"></script>
<!-- Timepicker -->
<script src="<?php echo SITEURL ?>/assets/vendor/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<!-- Color Picker -->
<script src="<?php echo SITEURL ?>/assets/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<!-- HTML Editor -->
<script src="<?php echo SITEURL ?>/assets/vendor/summernote/summernote.js"></script>
<!-- Dashboard -->
<script src="<?php echo SITEURL ?>/assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<script src="<?php echo SITEURL ?>/assets/vendor/raphael/raphael.js"></script>
<script src="<?php echo SITEURL ?>/assets/vendor/morris/morris.js"></script>
<!-- JQuery Mask -->
<script src="<?php echo SITEURL ?>/assets/vendor/jquery-mask/jquery.mask.js"></script>
<!-- Dropzone Uploader -->
<script src="<?php echo SITEURL ?>/assets/js/image_uploader/dropzone.js"></script>
<script type="text/javascript">
			Dropzone.autoDiscover = false;
		</script>
<!-- Wizard -->
<script src="<?php echo SITEURL ?>/assets/vendor/bootstrap-wizard/jquery.bootstrap.wizard.js"></script>
<script src="<?php echo SITEURL ?>/assets/vendor/jquery-validation/jquery.validate.js"></script>
<!-- Canvas -->
<script src="<?php echo SITEURL ?>/assets/vendor/html2canvas/html2canvas.js"></script>
<!-- Theme Base, Components and Settings -->
<script src="<?php echo SITEURL ?>/assets/js/theme.js"></script>
<!-- Theme Custom -->
<script src="<?php echo SITEURL ?>/assets/js/theme.custom.js"></script>
<!-- Theme Initialization Files -->
<script src="<?php echo SITEURL ?>/assets/js/theme.init.js"></script>

<script>
	$(document).ready(function(){
		$('#make').on("change",function(){
			var make_id = $(this).val();
			if(make_id)
			{
				$.ajax({
					type: "POST",
					url: "<?php echo SITEURL; ?>/ajax_get_model.php",
					data: {make_id:make_id},
					success: function(res){
						$('#model').html(res);
					}
				});
			}
		});
	});
</script>
</body>
</html>

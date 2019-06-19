<?php
$image_1 = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/no_image.png";
$image_2 = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/no_image.png";
$image_3 = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/no_image.png";
$image_4 = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/no_image.png";
$image_5 = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/no_image.png";
$image_6 = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/no_image.png";
$image_7 = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/no_image.png";
$image_8 = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/no_image.png";

if ($tradein['image_1']<>"") { $image_1 = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/".$tradein['image_1']; }
if ($tradein['image_2']<>"") { $image_2 = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/".$tradein['image_2']; }
if ($tradein['image_3']<>"") { $image_3 = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/".$tradein['image_3']; }
if ($tradein['image_4']<>"") { $image_4 = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/".$tradein['image_4']; }
if ($tradein['image_5']<>"") { $image_5 = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/".$tradein['image_5']; }
if ($tradein['image_6']<>"") { $image_6 = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/".$tradein['image_6']; }
if ($tradein['image_7']<>"") { $image_7 = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/".$tradein['image_7']; }
if ($tradein['image_8']<>"") { $image_8 = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/".$tradein['image_8']; }

$tsh = ""; if (strlen($tradein['tradein_service_history']) > 50) { $tsh = ".."; }
$o1 = ""; if (strlen($tradein['options_1']) > 50) { $o1 = ".."; }
$a1 = ""; if (strlen($tradein['accessories_1']) > 50) { $a1 = ".."; }
?>
<html>
	<head>
		<title><?php echo $tradein['ti_number']; ?></title>
		<link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">
		<style>			
			body {
				font-family: Verdana, Geneva, sans-serif;
				color: #666;
				font-size: 10px;
			}

			.terms p {
				font-size: 20px;
			}
			
			table {
				border-spacing: 0px;
				border-collapse: collapse;
			}

			.content td {
				vertical-align: top;
				border: 1px solid #666;	
				border-top: 0px;
				padding: 3px 5px 3px 5px;
			}
			
			.tradedetails_1 {
				padding: 5px 7px; 
				border: 1px solid #666; 
				background: #eee; 
				border-radius: 5px; 
				float: left; 
				margin-bottom: 9px;
				font-weight: bold;				
				width: 18%;
			}
			
			.tradedetails_2 {
				padding: 5px 7px;
				border: 1px solid #666; 
				border-radius: 5px; 
				float: right; 
				margin-bottom: 9px;
				width: 75%;
			}
			
			.tradedetails_3 {
				padding: 6px 8px; 
				border: 1px solid #666; 
				background: #eee; 
				border-radius: 5px; 
				float: left; 
				margin-bottom: 9px;
				font-weight: bold;
				width: 63%;
			}
			
			.tradedetails_4 {
				padding: 6px 8px; 
				border: 1px solid #666; 
				border-radius: 5px; 
				float: right;
				margin-bottom: 9px;
				width: 29%;
			}
			
			th {
				vertical-align: top;
				border: 1px solid #666;
				border-bottom: 0px;
				background: #666;
				color: #fff;
				padding: 3px 5px 3px 5px;
				text-align: left;
			}
			
			.th_2 {
				border: 1px #666 solid;
				border-top: 0px;
				background: #ddd; 
				color: #666; 
			}			
			
			.blue_header {
				padding: 7px 10px 7px 10px;
				background: #58c603; 
				color: #fff; 
				font-size: 1.6em;
				margin-top: 18px;
				margin-bottom: 18px;
			}
			
			.details table > tbody tr > td {
				font-size: 0.9em;
			}
			
			.total table > tbody tr > td {
				font-size: 0.9em;
			}

			.license {
				text-align: right;
			}

			.delivery {
				padding: 5px 7px 4px 7px;
				background: #87C7F7; 
				font-size: 1.3em; 
				margin-top: 18px; 
				margin-bottom: 10px;			
			}
			
			.th_po_title {
				padding: 7px 25px 7px 25px;
			}
			
			.th_po_text {
				color: #fff; 
				margin: 0px; 
				font-size: 1.2em;
			}
			
			.th_po_num_title {
				padding: 9px 10px 9px 10px;
			}
			
			.th_po_num_text {
				margin: 0px;
			}
		</style>		
	</head>
	<body>
		<table width="100%">
			<tr>
				<td><p></p></td>
				<td align="right"><img src="http://www.mycqo.com.au/assets/img/logos/new_quoteme.png" alt="Quote Me" width="220px;" height="60px;" /></td>
			</tr>
		</table>
		<div class="blue_header">
			<strong>TRADE INFORMATION</strong>
		</div>
		<div style="width: 100%">
			<div class="tradedetails_1">Submitted</div>
			<div class="tradedetails_2">&nbsp;<?php echo $tradein['created_at']; ?></div>

			<div class="tradedetails_1">Arrival Date</div>
			<div class="tradedetails_2">&nbsp;<?php echo $tradein['delivery_date']; ?></div>

			<div class="tradedetails_1">Registration Plate</div>
			<div class="tradedetails_2">&nbsp;<?php echo $tradein['registration_plate']; ?></div>
			
			<div class="tradedetails_1">Make</div>
			<div class="tradedetails_2">&nbsp;<?php echo $tradein['tradein_make']; ?></div>
			
			<div class="tradedetails_1">Variant</div>
			<div class="tradedetails_2">&nbsp;<?php echo $tradein['tradein_variant']; ?></div>

			<div class="tradedetails_1">Current Kms</div>
			<div class="tradedetails_2">&nbsp;<?php echo $tradein['tradein_kms']; ?></div>

			<div class="tradedetails_1">Fuel Type</div>
			<div class="tradedetails_2">&nbsp;<?php echo $tradein['tradein_fuel_type']; ?></div>
			
			<div class="tradedetails_1">Transmission</div>
			<div class="tradedetails_2">&nbsp;<?php echo $tradein['tradein_transmission']; ?></div>
			
			<div class="tradedetails_1">Service History</div>
			<div class="tradedetails_2">&nbsp;<?php echo substr($tradein['tradein_service_history'], 0, 70).$tsh; ?></div>
			
			<div class="tradedetails_1">Vehicle Options</div>
			<div class="tradedetails_2">&nbsp;<?php echo substr($tradein['options_1'], 0, 40).$o1; ?></div>
			
			<div class="tradedetails_1">Rego Expiry</div>
			<div class="tradedetails_2">&nbsp;<?php echo $tradein['rego_expiry']; ?></div>

			<div class="tradedetails_1">Model</div>
			<div class="tradedetails_2">&nbsp;<?php echo $tradein['tradein_model']; ?></div>
			
			<div class="tradedetails_1">Build Date</div>
			<div class="tradedetails_2">&nbsp;<?php echo $tradein['tradein_build_date']; ?></div>
			
			<div class="tradedetails_1">Body Shape</div>
			<div class="tradedetails_2">&nbsp;<?php echo $tradein['tradein_body_type']; ?></div>
			
			<div class="tradedetails_1">Colour</div>
			<div class="tradedetails_2">&nbsp;<?php echo $tradein['tradein_colour']; ?></div>
			
			<div class="tradedetails_1">Drive Type</div>
			<div class="tradedetails_2">&nbsp;<?php echo $tradein['tradein_drive_type']; ?></div>
			
			<div class="tradedetails_1">Accessories</div>
			<div class="tradedetails_2">&nbsp;<?php echo substr($tradein['accessories_1'], 0, 40).$a1; ?></div>
			
			<div class="tradedetails_3">Warning lights while vehicle is running?</div>
			<div class="tradedetails_4">&nbsp;<?php echo substr($tradein['warning_lights'], 0, 40).$a1; ?></div>
			
			<div class="tradedetails_3">Was your vehicle ever a lease or rental?</div>
			<div class="tradedetails_4">&nbsp;<?php echo substr($tradein['lease'], 0, 40).$a1; ?></div>
			
			<div class="tradedetails_3">Do all the options & accessories work?</div>
			<div class="tradedetails_4">&nbsp;<?php echo substr($tradein['accessories_working'], 0, 40).$a1; ?></div>
			
			<div class="tradedetails_3">Has vehicle ever had any paint work?</div>
			<div class="tradedetails_4">&nbsp;<?php echo substr($tradein['paint_work'], 0, 40).$a1; ?></div>
			
			<div class="tradedetails_3">Is there existing damage on the vehicle?</div>
			<div class="tradedetails_4">&nbsp;<?php echo substr($tradein['damage'], 0, 40).$a1; ?></div>
			
			<div class="tradedetails_3">Did you buy the vehicle new?</div>
			<div class="tradedetails_4">&nbsp;<?php echo substr($tradein['bought_new'], 0, 40).$a1; ?></div>
			
			<div class="tradedetails_3">Has vehicle ever been in any accident?</div>
			<div class="tradedetails_4">&nbsp;<?php echo substr($tradein['accident'], 0, 40).$a1; ?></div>
		</div>
		<pagebreak />
		<table width="100%">
			<tr>
				<td><p></p></td>
				<td align="right"><img src="http://www.mycqo.com.au/assets/img/logos/new_quoteme.png" alt="Quote Me" width="220px;" height="60px;" /></td>
			</tr>
		</table>
		<div class="blue_header">
			<strong>TRADE PICTURES</strong>
		</div>		
		<table class="content" width="100%">
			<tbody>
				<tr>
					<th width="50%"><strong>PICTURE 01</strong></th>
					<th><strong>PICTURE 02</strong></th>
				</tr>										
				<tr>
					<td style="padding: 10px;"><img src="<?php echo $image_1; ?>" style="width: 340px; height: 210px;" /></td>
					<td style="padding: 10px;"><img src="<?php echo $image_2; ?>" style="width: 340px; height: 210px;" /></td>
				</tr>
				<tr>
					<th><strong>PICTURE 03</strong></th>
					<th><strong>PICTURE 04</strong></th>
				</tr>										
				<tr>
					<td style="padding: 10px;"><img src="<?php echo $image_3; ?>" style="width: 340px; height: 210px;" /></td>
					<td style="padding: 10px;"><img src="<?php echo $image_4; ?>" style="width: 340px; height: 210px;" /></td>
				</tr>
				<tr>
					<th><strong>PICTURE 05</strong></th>
					<th><strong>PICTURE 06</strong></th>
				</tr>										
				<tr>
					<td style="padding: 10px;"><img src="<?php echo $image_5; ?>" style="width: 340px; height: 210px;" /></td>
					<td style="padding: 10px;"><img src="<?php echo $image_6; ?>" style="width: 340px; height: 210px;" /></td>
				</tr>				
			</tbody>
		</table>
		<pagebreak />
		<table width="100%">
			<tr>
				<td><p></p></td>
				<td align="right"><img src="http://www.mycqo.com.au/assets/img/logos/new_quoteme.png" alt="Quote Me" width="220px;" height="60px;" /></td>
			</tr>
		</table>
		<div class="blue_header">
			<strong>TRADE PICTURES</strong>
		</div>		
		<table class="content" width="100%">
			<tbody>
				<tr>
					<th width="50%"><strong>PICTURE 07</strong></th>
					<th><strong>PICTURE 08</strong></th>
				</tr>										
				<tr>
					<td style="padding: 10px;"><img src="<?php echo $image_7; ?>" style="width: 340px; height: 210px;" /></td>
					<td style="padding: 10px;"><img src="<?php echo $image_8; ?>" style="width: 340px; height: 210px;" /></td>
				</tr>
			</tbody>
		</table>		
	</body>
</html>
<?php
$image_1 = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/no_image.png";
$image_2 = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/no_image.png";
$image_3 = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/no_image.png";
$image_4 = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/no_image.png";

if ($tradein['image_1']<>"") { $image_1 = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/".$tradein['image_1']; }
if ($tradein['image_2']<>"") { $image_2 = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/".$tradein['image_2']; }
if ($tradein['image_3']<>"") { $image_3 = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/".$tradein['image_3']; }
if ($tradein['image_4']<>"") { $image_4 = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/".$tradein['image_4']; }

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
				font-size: 1.3em;
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
				background: #3C94D6; 
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
				<td>
					<p style="font-size: 1.3em">
						Please email your valuation to the quote 
						<br />specialist who requested it or
						<br />Call: <b>1300 009 001</b>
						<br />Em: info@qteme.com.au
					</p>
				</td>
				<td align="right">
					<img src="http://www.mycqo.com.au/assets/img/logos/new_quoteme.png" alt="Quote Me" width="220px;" height="60px;" />
				</td>				
			</tr>
		</table>
		<div class="blue_header">
			&nbsp;
		</div>
		<table width="100%">
			<tr>
				<td width="50%" style="padding-right: 10px;">
					<p style="font-size: 1.3em;">
						Powered By: 
						<a href="http://www.mytradevaluation.com.au" target="_blank">www.mytradevaluation.com.au</a>
					</p>
					<br /><br />
					<table class="content" width="100%">								
						<tr>
							<td width="50%" style="border: 1px solid #666; background: #eeeeee">Postcode:</td>
							<td style="border: 1px solid #666; background: #eeeeee"><?php echo $tradein['postcode']; ?></td>
						</tr>
						<tr>
							<td style="background: #fdfdfd">State:</td>
							<td style="background: #fdfdfd"><?php echo $tradein['state']; ?></td>
						</tr>					
						<tr>
							<td style="background: #eeeeee">Registration Plate:</td>
							<td style="background: #eeeeee"><?php echo $tradein['registration_plate']; ?></td>
						</tr>
						<tr>
							<td style="background: #fdfdfd">Rego Expiry:</td>
							<td style="background: #fdfdfd"><?php echo $tradein['rego_expiry']; ?></td>
						</tr>
						<tr>
							<td style="background: #eeeeee">Make:</td>
							<td style="background: #eeeeee"><?php echo $tradein['tradein_make']; ?></td>
						</tr>
						<tr>
							<td style="background: #fdfdfd">Model:</td>
							<td style="background: #fdfdfd"><?php echo $tradein['tradein_model']; ?></td>
						</tr>
						<tr>
							<td style="background: #eeeeee">Variant:</td>
							<td style="background: #eeeeee"><?php echo $tradein['tradein_variant']; ?></td>
						</tr>							
						<tr>
							<td style="background: #fdfdfd">Build Date:</td>
							<td style="background: #fdfdfd"><?php echo $tradein['tradein_build_date']; ?></td>
						</tr>
						<tr>
							<td style="background: #eeeeee">Kms:</td>
							<td style="background: #eeeeee"><?php echo $tradein['tradein_kms']; ?></td>
						</tr>
						<tr>
							<td style="background: #fdfdfd">Fuel Type:</td>
							<td style="background: #fdfdfd"><?php echo $tradein['tradein_fuel_type']; ?></td>
						</tr>
						<tr>
							<td style="background: #eeeeee">Body Shape:</td>
							<td style="background: #eeeeee"><?php echo $tradein['tradein_body_type']; ?></td>
						</tr>
						<tr>
							<td style="background: #fdfdfd">Colour:</td>
							<td style="background: #fdfdfd"><?php echo $tradein['tradein_colour']; ?></td>
						</tr>
						<tr>
							<td style="background: #eeeeee">Drive Type:</td>
							<td style="background: #eeeeee"><?php echo $tradein['tradein_drive_type']; ?></td>
						</tr>
						<tr>
							<td style="background: #fdfdfd">Transmission:</td>
							<td style="background: #fdfdfd"><?php echo $tradein['tradein_transmission']; ?></td>
						</tr>
						<tr>
							<td style="background: #eeeeee">
								Service History:<br /><br /><br /><br /><br /><br />
							</td>
							<td style="background: #eeeeee"><?php echo substr($tradein['tradein_service_history'], 0, 70).$tsh; ?></td>
						</tr>
						<tr>
							<td style="background: #fdfdfd">
								Vehicle Options:<br /><br /><br /><br />
							</td>
							<td style="background: #fdfdfd"><?php echo substr($tradein['options_1'], 0, 40).$o1; ?></td>
						</tr>					
						<tr>
							<td style="background: #eeeeee">
								Accessories:<br /><br /><br /><br />
							</td>
							<td style="background: #eeeeee"><?php echo substr($tradein['accessories_1'], 0, 40).$a1; ?></td>
						</tr>
					</table>
					<br /><br />
					<img src="<?php echo $image_4; ?>" style="width: 330px; height: 200px; border: 1px solid #666" />
				</td>
				<td style="padding-left: 10px;">
					<p style="font-size: 1.2em;">
						<i>
							The Following Trade in is being submitted for valuation. The valuation is dependandant on final viewing and confirmation.
							<br />
							Please assume the following.
							<br /><br />$250 Reconditioning Spend. Tyres 50% damage or marks unless noted.
						</i>
					</p>
					<br /><br />
					<img src="<?php echo $image_1; ?>" style="width: 330px; height: 200px; border: 1px solid #666; margin-top: 20px;" />
					<br /><br /><br />
					<img src="<?php echo $image_2; ?>" style="width: 330px; height: 200px; border: 1px solid #666" />
					<br /><br /><br />
					<img src="<?php echo $image_3; ?>" style="width: 330px; height: 200px; border: 1px solid #666" />
				</td>
			</tr>
		</table>
	</body>
</html>
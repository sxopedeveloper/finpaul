<?php
date_default_timezone_set('Australia/Sydney');
ini_set('max_execution_time', -1);

$dealer_details = 
$deal['dealership_name'] . "<br />" .
"Attention: " . $deal['fleet_manager'] . "<br />" .
"E. " . $deal['dealer_email'] . "<br />" .
"P. " . $deal['dealer_phone'] . "<br />" .
"M. " . $deal['dealer_mobile'] . "<br />" .
$deal['dealer_address'] . " " . 
$deal['dealer_postcode'] . " " . $deal['dealer_state'] . "<br />" . 
"Dealer License: " . $deal['dealer_license'];

$car_care_specialist = 'Samm Clack';

if ($deal['variant'] <> '')
{
	$item_details = 
	$deal['build_date'] . " " . $deal['make'] . " " . $deal['model'] . " " . $deal['variant'] . " " . $deal['colour'];
}
else
{
	$item_details = 
	$deal['build_date'] . " " . $deal['make'] . " " . $deal['model'] . " " . $deal['series'] . " " . $deal['fuel_type'] . " " . $deal['transmission'] . " " . $deal['colour'];
}
?>
<html>
	<head>
		<title><?php echo $title; ?> - <?php echo $deal['po_number']; ?></title>
		<link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">
		<style>			
			body {
				font-family: Verdana, Geneva, sans-serif;
				color: #666;
				font-size: 10px;
				padding: 100px;				
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
				padding: 6px 9px; 
				border: 1px solid #666; 
				background: #eee; 
				border-radius: 5px; 
				float: left; 
				margin-bottom: 9px;
				font-weight: bold;				
				width: 18%;
			}
			
			.tradedetails_2 {
				padding: 6px 9px;
				border: 1px solid #666; 
				border-radius: 5px; 
				float: right; 
				margin-bottom: 9px;
				width: 75%;
			}
			
			.tradedetails_3 {
				padding: 7px 10px; 
				border: 1px solid #666; 
				background: #eee; 
				border-radius: 5px; 
				float: left; 
				margin-bottom: 9px;
				font-weight: bold;
				width: 63%;
			}
			
			.tradedetails_4 {
				padding: 7px 10px; 
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
				padding: 5px 10px 5px 10px; 
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
				background: #58c603;
				color: #fff;				
				font-size: 1.3em; 
				margin-top: 18px; 
				margin-bottom: 10px;
			}

			.special_conditions {
				padding: 5px 7px 4px 7px;
				background: #58c603; 
				color: #fff;
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
					<table class="content">
						<tr>
							<th class="th_po_title">
								<center><h2 class="th_po_text">PURCHASE ORDER</h2></center>
							</th>
						</tr>
						<tr>
							<td class="th_po_num_title">
								<center><h4 class="th_po_num_text"><?php echo $deal['po_number']."AC"; ?></h4></center>
							</td>
						</tr>
					</table>					
				</td>
				<td align="right">
					<img src="<?php echo $company_settings['company_logo']; ?>" alt="<?php echo $company_settings['company_name']; ?>" width="220px;" height="50px;" />
				</td>				
			</tr>
		</table>
		<div class="blue_header">
			<strong>ACCESSORIES ORDER</strong>
		</div>
		<div class="details">
			<table class="content" width="100%">
				<tbody>
					<tr>
						<th colspan="2" width="50%"><strong>DEALERSHIP</strong></th>
						<th colspan="2" width="50%"><strong><?php echo str_replace(' ', '', strtoupper($company_settings['company_short_name'])); ?> DETAILS</strong></th>
					</tr>										
					<tr>
						<td colspan="2">
							<?php echo $dealer_details; ?>
						</td>
						<td colspan="2">
							<?php echo $company_settings['company_name']; ?><br />
							Attention: Accounts<br />
							<?php echo $company_settings['company_postal_address_line_1']; ?><br />
							<?php echo $company_settings['company_postal_address_line_2']; ?><br />
							<?php echo $company_settings['company_postal_suburb'].", ".$company_settings['company_postal_state']." ".$company_settings['company_postal_postcode']; ?><br />
							<?php echo $company_settings['company_phone']; ?><br />
							ABN: <?php echo $company_settings['company_abn']; ?>
						</td>
					</tr>
					<tr>
						<th width="25%"><strong>ORDER DATE</strong></th>
						<th width="25%"><strong>JOB DATE</strong></th>
						<th width="25%"><strong>CLIENT NAME</strong></th>
						<th width="25%"><strong>CAR CARE SPECIALIST</strong></th>
					</tr>
					<tr>
						<?php
						$order_date = "";
						$job_date = "";							
						?>
						<td><?php echo $order_date; ?></td>
						<td><?php echo $job_date; ?></td>
						<td><?php echo $deal['name']; ?></td>
						<td><?php echo $car_care_specialist; ?></td>
					</tr>
				</tbody>
			</table>
		</div>
		<br />
		<div class="details">
			<table class="content" width="100%">
				<tr>
					<th><strong>ITEM INFORMATION</strong></th>
				</tr>										
				<tr>
					<td>
						Items to be affixed to the following vehicle:<br />
						<ul>
							<?php
							echo $item_details."<br /><br />";
							if (count($deal_accessories) > 0)
							{					
								foreach ($deal_accessories as $deal_accessory)
								{
									echo "<li>(".$deal_accessory['accessory_code'].") ".$deal_accessory['accessory_name']."</li>";
								}
							}
							?>
						<ul>
						<br />
						<br />
					</td>
				</tr>
			</table>
			<br />
			<div class="delivery">
				<strong>LOCATION OF VEHICLE</strong>
			</div>
			<table class="content" width="100%">
				<tbody>
					<tr>
						<th style="border: 1px #000 solid;"><strong>ADDRESS</strong></th>
						<th style="border: 1px #000 solid;"><strong>NAME</strong></th>
						<th style="border: 1px #000 solid;"><strong>TELEPHONE</strong></th>
						<th style="border: 1px #000 solid;"><strong>EMAIL</strong></th>
					</tr>
					<tr>
						<td><?php echo $deal['dealer_address'].", ".$deal['dealer_postcode']." ".$deal['dealer_state']; ?></td>
						<td><?php echo $deal['fleet_manager']; ?></td>
						<td><?php echo $deal['dealer_phone']; ?></td>
						<td><?php echo $deal['dealer_email']; ?></td>
					</tr>	
				</tbody>
			</table>
			<div class="special_conditions">
				<strong>SPECIAL CONDITIONS</strong>
			</div>
			<table class="content" width="100%">
				<tbody>
					<tr>
						<td style="border-top: 1px solid #666;">
							<?php 
							if ($deal['accessory_special_conditions']=="")
							{
								echo "<br /><center><i>N/A</i></center><br /><br />";
							}
							else
							{
								echo $deal['accessory_special_conditions'];
							}
							?>
						</td>
					</tr>						
				</tbody>
			</table>			
		</div>
	</body>
</html>
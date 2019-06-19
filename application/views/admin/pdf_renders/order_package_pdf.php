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

if ($deal['business_name']=="")
{
	$row_3_col_3 = "CLIENT NAME";
	$row_4_col_3 = $deal['name'];
}
else
{
	$row_3_col_3 = "BUSINESS NAME";
	$row_4_col_3 = $deal['business_name'];
}

if ($deal['variant'] <> '')
{
	$item_details = $deal['build_date'] . " " . $deal['make'] . " " . $deal['model'] . " " . $deal['variant'] . " " . $deal['colour'];
}
else
{
	$item_details = $deal['build_date'] . " " . $deal['make'] . " " . $deal['model'] . " " . $deal['series'] . " " . $deal['fuel_type'] . " " . $deal['transmission'] . " " . $deal['colour'];
}

$unit_price = $deal['sales_price'] - $deal['tradein_given'] + $deal['tradein_payout']; // Changeover
$unit_quantity = 1;
$unit_line_total = $unit_price * $unit_quantity;


// $refunds_total = $deal['refunds_total'];
// $deposit_trans_total = $deal['deposit_trans_total'];
// $deposits_total = $deal['deposits_total'];

$deposits_total = 0;
foreach ($deposits as $deposit)
{
	if ($deposit['show_status']==1)
	{
		$deposits_total += $deposit['amount'];
	}
}

$refunds_total = 0;
foreach ($refunds as $refund)
{
	if ($refund['show_status']==1)
	{
		$refunds_total += $refund['amount'];
	}
}

if ($deal['tradein_given']=="") { $tradein_given = 0; } else { $tradein_given = $deal['tradein_given']; }
if ($deal['tradein_payout']=="") { $tradein_payout = 0; } else { $tradein_payout = $deal['tradein_payout']; }

$tradein_amount = $tradein_given + $tradein_payout;
$tradein_quantity = 1;
$tradein_line_total = $tradein_amount * $tradein_quantity;

$balance_payable = $unit_line_total - $deposits_total + $refunds_total;

$lines_count = count($options) + count($accessories);
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
			
			.content_2 {
				border: 1px solid #666;
			}

			.content_2 td {
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
			
			.terms_text {
				font-size: 1.1em;
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
								<center><h4 class="th_po_num_text"><?php echo $deal['po_number']; ?></h4></center>
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
			<strong>NEW VEHICLE ORDER</strong>
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
						<th width="25%"><strong>PURCHASE ORDER DATE</strong></th>
						<th width="25%"><strong>DELIVERY DATE</strong></th>
						<th width="25%"><strong><?php echo $row_3_col_3; ?></strong></th>
						<th width="25%"><strong>QUOTE SPECIALIST</strong></th>
					</tr>
					<tr>
						<?php
						if ($deal['order_date']=='0000-00-00') { $order_date = ''; } 
						else {
							$order_date_d = date_create($deal['order_date']);
							$order_date = date_format($order_date_d, 'd F Y');
						}
						
						if ($deal['delivery_date']=='0000-00-00') { $delivery_date = ''; } 
						else { 
							$delivery_date_d = date_create($deal['delivery_date']);
							$delivery_date = date_format($delivery_date_d, 'd F Y');							
						}
						?>
						<td><?php echo $order_date; ?></td>
						<td><?php echo $delivery_date; ?></td>
						<td><?php echo $row_4_col_3; ?></td>
						<td><?php echo $deal['qs_name']; ?></td>
					</tr>
				</tbody>
			</table>
		</div>
		<br />
		<div class="details">
			<table class="content" width="100%">
				<tr>
					<th colspan="3"><strong>CAR INFORMATION</strong></th>
				</tr>										
				<tr>
					<td class="th_2" width="70%">Item</td>
					<td class="th_2" align="center">Quantity</td>
					<td class="th_2" align="center">Price</td>
				</tr>
				<tr>
					<td>
						<?php
						echo $item_details;
						if (count($options) > 0)
						{
							echo "<br /><br /><b>Optional Equipments:</b><br />";
							foreach ($options as $option)
							{
								if ($option->items=="")
								{
									echo $option->name."<br />";
								}
								else
								{
									echo $option->name.': '.$option->items."<br />";
								}
							}
						}
						
						if (count($accessories) > 0)
						{
							echo "<br /><br /><b>Accessories:</b><br />"; 
							foreach ($accessories as $accessory)
							{
								if ($accessory->description=="")
								{
									echo $accessory->name."<br />";
								}
								else
								{
									echo $accessory->name.': '.$accessory->description."<br />";
								}
							}						
						}
						?>
					</td>
					<td align="center"><?php echo $unit_quantity; ?></td>
					<td align="right">$ <?php echo number_format($unit_line_total, 2); ?></td>
				</tr>
				<?php 
				if (count($deposits) > 0)
				{
					foreach ($deposits as $deposit)
					{
						if ($deposit['show_status']==1)
						{									
							if ($deposit['payment_date'] == "")
							{
								$payment_date = "";
							}
							else
							{
								$payment_date = date('d F Y', strtotime($deposit['payment_date']));
							}
							?>
							<tr>
								<td>Deposit Made: <?php echo $payment_date."<br />Reference #: ".$deposit['reference_number']; ?></td>
								<td align="center">1</td>
								<td align="right">($ <?php echo number_format($deposit['amount'], 2); ?>)</td>
							</tr>
							<?php
						}
					}
				}

				if (count($refunds) > 0)
				{
					foreach ($refunds as $refund)
					{
						if ($refund['show_status']==1)
						{						
							if ($refund['payment_date'] == "")
							{
								$payment_date = "";
							}
							else
							{
								$payment_date = date('d F Y', strtotime($refund['payment_date']));
							}						
							?>
							<tr>
								<td>Refund Made: <?php echo $payment_date."<br />(".$refund['reference_number'].")"; ?></td>
								<td align="center">1</td>
								<td align="right">$ <?php echo number_format($refund['amount'], 2); ?></td>
							</tr>
							<?php
						}
					}
				}				

				foreach ($tradeins as $tradein)
				{
					$tradein_amount = $tradein->tradein_given + $tradein->tradein_payout;
					$tradein_quantity = 1;
					$tradein_line_total = $tradein_amount * $tradein_quantity;											
					?>
					<tr>
						<td>
							<?php 
							echo $tradein->tradein_build_date . " " . $tradein->tradein_make . " " . $tradein->tradein_model . " " . $tradein->tradein_variant; 
							?>
						</td>
						<td align="center"><?php echo $tradein_quantity; ?></td>
						<td align="right">(Included)</td>
					</tr>
					<?php
				}
				?>			
			</table>
			<br />
			<table class="content" width="50%" align="right">
				<tbody>
					<tr>
						<td align="right" style="border-top: 1px solid #666;"><strong>BALANCE PAYABLE (AUD)</strong></td>
						<td align="right" style="border-top: 1px solid #666;"><strong>$ <?php echo number_format($balance_payable, 2); ?></strong></td>
					</tr>											
				</tbody>								
			</table>
			<p align="right">
				<i>
					<?php
					if ($tradein_payout <> 0)
					{
						?>
						*Tradein Payout to a maximum of $<?php echo $tradein_payout; ?><br />
						<?php
					}
					?>
					*GST, stamp duty and on road costs are included in this order. However, <br />
					they are administered by the supplying dealer and are calculated <br />
					based on the individual state and territory laws that exist.
				</i>
			</p>
			<br />
			<?php
			if ($lines_count >= 25)
			{
				?>
				<pagebreak />
				<?php
			}
			?>
			<div class="delivery">
				<strong>DELIVERY DETAILS</strong>
			</div>
			<table class="content" width="100%">
				<tbody>
					<tr>
						<th style="border: 1px #000 solid;"><strong>DELIVERY ADDRESS</strong></th>
						<th style="border: 1px #000 solid;"><strong>NAME</strong></th>
						<th style="border: 1px #000 solid;"><strong>TELEPHONE</strong></th>
						<th style="border: 1px #000 solid;"><strong>EMAIL</strong></th>
					</tr>
					<tr>
						<td>
							<?php 
							if ($deal['delivery_address_map']==1)
							{
								echo $deal['address']." ".$deal['postcode']." ".$deal['state'];
							}
							else
							{
								echo $deal['delivery_address']; 
							}
							?>
						</td>
						<td><?php echo $deal['name']; ?></td>
						<td><?php echo $deal['phone']; ?></td>
						<td><?php echo $deal['email']; ?></td>
					</tr>
					<tr>
						<th colspan="4"><strong>DELIVERY INSTRUCTIONS</strong></th>
					</tr>
					<tr>
						<td colspan="4">
							<?php 
							$delivery_instructions = $deal['delivery_instructions'];

							if ($deposits_total <> 0)
							{
								if ($delivery_instructions<>"")
								{
									$delivery_instructions .= "<br />";
								}
								$delivery_instructions .= "
								<b>".$company_settings['company_short_name']."</b> has successfully taken a total 
								of $".number_format($deposits_total, 2)." deposit from the above client. 
								The deposit will be forwarded to the supplying dealer 48 hours before delivery when the dealer 
								submits an invoice with a VIN Chassis or Registration number listed. The Deposit will be funded 
								less the ".$company_settings['company_short_name']." invoice that is connected to the above 
								transaction.";
							}

							if ($delivery_instructions == "")
							{
								echo "<center><i>N/A</i></center><br />";
							}
							else
							{
								echo $delivery_instructions;
							}
							?>
						</td>
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
							if ($deal['special_conditions']=="")
							{
								echo "<br /><center><i>N/A</i></center><br /><br />";
							}
							else
							{
								echo $deal['special_conditions'];
							}
							?>
						</td>
					</tr>						
				</tbody>
			</table>			
		</div>
		<?php
		foreach ($tradeins as $tradein)
		{
			$image_1 = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/no_image.png";
			$image_2 = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/no_image.png";
			$image_3 = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/no_image.png";
			$image_4 = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/no_image.png";

			if ($tradein->image_1<>"") { $image_1 = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/".$tradein->image_1; }
			if ($tradein->image_2<>"") { $image_2 = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/".$tradein->image_2; }
			if ($tradein->image_3<>"") { $image_3 = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/".$tradein->image_3; }
			if ($tradein->image_4<>"") { $image_4 = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/".$tradein->image_4; }
			
			$tsh = ""; if (strlen($tradein->tradein_service_history) > 50) { $tsh = ".."; }
			$o1 = ""; if (strlen($tradein->options_1) > 50) { $o1 = ".."; }
			$a1 = ""; if (strlen($tradein->accessories_1) > 50) { $a1 = ".."; }										
			?>
			<pagebreak />
			<table width="100%">
				<tr>
					<td><p></p></td>
					<td align="right"><img src="<?php echo $company_settings['company_logo']; ?>" alt="<?php echo $company_settings['company_name']; ?>" width="220px;" height="50px;" /></td>
				</tr>
			</table>
			<div class="blue_header">
				<strong>TRADE INFORMATION</strong>
			</div>
			<div style="width: 100%">
				<div class="tradedetails_1">Registration Plate</div>
				<div class="tradedetails_2">&nbsp;<?php echo $tradein->registration_plate; ?></div>
				
				<div class="tradedetails_1">Make</div>
				<div class="tradedetails_2">&nbsp;<?php echo $tradein->tradein_make; ?></div>
				
				<div class="tradedetails_1">Variant</div>
				<div class="tradedetails_2">&nbsp;<?php echo $tradein->tradein_variant; ?></div>

				<div class="tradedetails_1">Current Kms</div>
				<div class="tradedetails_2">&nbsp;<?php echo $tradein->tradein_kms; ?></div>

				<div class="tradedetails_1">Fuel Type</div>
				<div class="tradedetails_2">&nbsp;<?php echo $tradein->tradein_fuel_type; ?></div>
				
				<div class="tradedetails_1">Transmission</div>
				<div class="tradedetails_2">&nbsp;<?php echo $tradein->tradein_transmission; ?></div>
				
				<div class="tradedetails_1">Service History</div>
				<div class="tradedetails_2">&nbsp;<?php echo substr($tradein->tradein_service_history, 0, 70).$tsh; ?></div>
				
				<div class="tradedetails_1">Vehicle Options</div>
				<div class="tradedetails_2">&nbsp;<?php echo substr($tradein->options_1, 0, 40).$o1; ?></div>
				
				<div class="tradedetails_1">Rego Expiry</div>
				<div class="tradedetails_2">&nbsp;<?php echo $tradein->rego_expiry; ?></div>

				<div class="tradedetails_1">Model</div>
				<div class="tradedetails_2">&nbsp;<?php echo $tradein->tradein_model; ?></div>
				
				<div class="tradedetails_1">Build Date</div>
				<div class="tradedetails_2">&nbsp;<?php echo $tradein->tradein_build_date; ?></div>
				
				<div class="tradedetails_1">Body Shape</div>
				<div class="tradedetails_2">&nbsp;<?php echo $tradein->tradein_body_type; ?></div>
				
				<div class="tradedetails_1">Colour</div>
				<div class="tradedetails_2">&nbsp;<?php echo $tradein->tradein_colour; ?></div>
				
				<div class="tradedetails_1">Drive Type</div>
				<div class="tradedetails_2">&nbsp;<?php echo $tradein->tradein_drive_type; ?></div>
				
				<div class="tradedetails_1">Accessories</div>
				<div class="tradedetails_2">&nbsp;<?php echo substr($tradein->accessories_1, 0, 40).$a1; ?></div>
				
				<br />

				<div class="tradedetails_3">Warning lights while vehicle is running?</div>
				<div class="tradedetails_4">&nbsp;<?php echo substr($tradein->warning_lights, 0, 40).$a1; ?></div>

				<div class="tradedetails_3">Was your vehicle ever a lease or rental?</div>
				<div class="tradedetails_4">&nbsp;<?php echo substr($tradein->lease, 0, 40).$a1; ?></div>

				<div class="tradedetails_3">Do all the options & accessories work?</div>
				<div class="tradedetails_4">&nbsp;<?php echo substr($tradein->accessories_working, 0, 40).$a1; ?></div>
				
				<div class="tradedetails_3">Has vehicle ever had any paint work?</div>
				<div class="tradedetails_4">&nbsp;<?php echo substr($tradein->paint_work, 0, 40).$a1; ?></div>
				
				<div class="tradedetails_3">Is there existing damage on the vehicle?</div>
				<div class="tradedetails_4">&nbsp;<?php echo substr($tradein->damage, 0, 40).$a1; ?></div>
				
				<div class="tradedetails_3">Did you buy the vehicle new?</div>
				<div class="tradedetails_4">&nbsp;<?php echo substr($tradein->bought_new, 0, 40).$a1; ?></div>
				
				<div class="tradedetails_3">Has vehicle ever been in any accident?</div>
				<div class="tradedetails_4">&nbsp;<?php echo substr($tradein->accident, 0, 40).$a1; ?></div>
			</div>
			<pagebreak />
			<table width="100%">
				<tr>
					<td><p></p></td>
					<td align="right"><img src="<?php echo $company_settings['company_logo']; ?>" alt="<?php echo $company_settings['company_name']; ?>" width="220px;" height="50px;" /></td>
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
				</tbody>
			</table>
			<?php
		}
		?>
		<pagebreak />
		<?php
		// CLIENT INVOICE //
		$client_details =
		"<b>" . $lead['name'] . "</b><br />" .
		"<b>" . $lead['email'] . "</b><br />" .
		$lead['address'] . "<br />" .
		$lead['state'] . " " . $lead['postcode'] . "<br />" .
		$lead['phone'];
		?>
		<table width="100%">
			<tr>
				<td align="right">
					<img src="<?php echo $company_settings['company_logo']; ?>" alt="<?php echo $company_settings['company_name']; ?>" width="220px;" height="50px;" />
				</td>				
			</tr>
		</table>
		<div class="blue_header">
			<strong><?php echo $lead['cq_number']; ?></strong>
		</div>
		<div class="details">
			<table width="100%">
				<tbody>
					<tr>
						<td width="100%" style="padding: 8px; padding-top: 0px; padding-bottom: 0px;">
							<table class="content" width="100%" style="height: 300px;">
								<tbody>
									<tr>
										<th><strong>DELIVER TO:</strong></th>
									</tr>										
									<tr>
										<td>
											<?php echo $client_details; ?>
										</td>
									</tr>			
								</tbody>
							</table>					
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<br /><br />
		<div class="details">
			<table width="100%">
				<tbody>
					<tr>
						<td width="60%" style="padding: 8px; padding-top: 0px; padding-bottom: 0px;">
							<table class="content" width="100%">
								<tr>
									<td style="border-top: 1px solid #666;"><b><p style="font-size: 1.1em;">List Price</p></b></td>
									<td style="border-top: 1px solid #666;" align="right"><p style="font-size: 1.1em;"><?php echo number_format($invoice_details['list_price'], 2); ?></p></td>
								</tr>
								<tr>
									<td>Options</td>
									<td align="right"><?php echo number_format($invoice_details['options_total'], 2); ?></td>
								</tr>
								<tr>
									<td>Accessories</td>
									<td align="right"><?php echo number_format($invoice_details['accessories_total'], 2); ?></td>
								</tr>
								<tr>
									<td>Dealer Delivery</td>
									<td align="right"><?php echo number_format($invoice_details['dealer_delivery'], 2); ?></td>
								</tr>
								<tr>
									<td><b><p style="font-size: 1.2em;">Price Plus Options & Delivery</p></b></td>
									<td align="right">
										<p style="font-size: 1.2em;">
											<?php echo number_format($invoice_details['subtotal_1'], 2); ?>
										</p>
									</td>
								</tr>
								<tr>
									<td>Discount</td>
									<td align="right">
										<?php echo number_format($invoice_details['dealer_discount'], 2); ?>
									</td>
								</tr>
								<tr>
									<td>Fleet Claim</td>
									<td align="right"><?php echo number_format($invoice_details['fleet_discount'], 2); ?></td>
								</tr>								
								<tr>
									<td><b><p style="font-size: 1.2em;">Sub Total</p></b></td>
									<td align="right"><p style="font-size: 1.2em;"><?php echo number_format($invoice_details['subtotal_2'], 2); ?></p></td>
								</tr>								
								<tr>
									<td>GST</td>
									<td align="right"><?php echo number_format($invoice_details['gst'], 2); ?></td>
								</tr>								
								<tr>
									<td><b><p style="font-size: 1.2em;">Price INC of GST</p></b></td>
									<td align="right"><p style="font-size: 1.2em;"><?php echo number_format($invoice_details['subtotal_3'], 2); ?></p></td>
								</tr>
								<tr>
									<td>LCT</td>
									<td align="right"><?php echo number_format($invoice_details['lct'], 2); ?></td>
								</tr>
								<tr>
									<td>Stamp Duty</td>
									<td align="right"><?php echo number_format($invoice_details['stamp_duty'], 2); ?></td>
								</tr>
								<tr>
									<td>Registration</td>
									<td align="right"><?php echo number_format($invoice_details['registration'], 2); ?></td>
								</tr>
								<tr>
									<td>CTP</td>
									<td align="right"><?php echo number_format($invoice_details['ctp'], 2); ?></td>
								</tr>
								<tr>
									<td>Premium Plate Fee</td>
									<td align="right"><?php echo number_format($invoice_details['premium_plate_fee'], 2); ?></td>
								</tr>								
								<tr>
									<td><b><p style="font-size: 1.2em;">Total Price (inc GST)</p></b></td>
									<td align="right"><p style="font-size: 1.2em;"><?php echo number_format($invoice_details['sales_price'], 2); ?></p></td>
								</tr>
								<?php
								$deposit_counter = 0;
								foreach ($deposits AS $deposit)
								{
									$deposit_counter ++;
									if ($deposit['payment_date'] == "0000-00-00") { $deposit_date = ""; }
									else { $deposit_date = date('d/m/Y', strtotime($deposit['payment_date'])); }									
									?>
									<tr>
										<td>Deposit (Receipt #<?php echo "DEP".$lead['id_lead']."".$deposit_counter; ?> Rec <?php echo $deposit_date; ?>)</td>
										<td align="right"><?php echo number_format($deposit['amount'], 2); ?></td>
									</tr>									
									<?php
								}
								?>
								<tr>
									<td>Allowance for Trade In</td>
									<td align="right"><?php echo number_format($invoice_details['tradein_given'], 2); ?></td>
								</tr>
								<tr>
									<td>Payout</td>
									<td align="right"><?php echo number_format($invoice_details['tradein_payout'], 2); ?></td>
								</tr>
								<?php
								$refund_counter = 0;
								foreach ($refunds AS $refund)
								{
									$refund_counter ++;
									if ($refund['payment_date'] == "0000-00-00") { $refund_date = ""; }
									else { $refund_date = date('d F Y', strtotime($refund['payment_date'])); }									
									?>
									<tr>
										<td>Refund made <?php echo $refund_date; ?> (<?php echo "REF".$lead['id_lead']."_".$refund_counter; ?>)</td>
										<td align="right"><?php echo number_format($refund['amount'], 2); ?></td>
									</tr>									
									<?php
								}
								?>
								<tr>
									<td>
										<b><p style="font-size: 1.3em;">Balance Required for Settlement</p></b>
									</td>
									<td align="right">
										<b><p style="font-size: 1.3em;">$ <?php echo number_format($invoice_details['balance'], 2); ?></p></b>
									</td>
								</tr>								
							</table>
						</td>
						<td width="40%" style="padding: 8px; padding-top: 0px; padding-bottom: 0px;">
							<table class="content_2" width="100%">
								<tr>
									<th colspan="2"><strong>VEHICLE DETAILS:</strong></th>
								</tr>
								<tr>
									<td width="40%"><b>Make:</b></td>
									<td><?php echo $lead['tender_make']; ?></td>
								</tr>
								<tr>
									<td><b>Model:</b></td>
									<td><?php echo $lead['tender_model']; ?></td>
								</tr>
								<tr>
									<td><b>Variant:</b></td>
									<td><?php echo $lead['tender_variant']; ?></td>
								</tr>
								<tr>
									<td><b>Build Date:</b></td>
									<td><?php echo $lead['build_date']; ?></td>
								</tr>
								<tr>
									<td><b>Compliance Date:</b></td>
									<td><?php echo $lead['compliance_date']; ?></td>
								</tr>
								<tr>
									<td><b>VIN:</b></td>
									<td><?php echo $lead['vin']; ?></td>
								</tr>
								<tr>
									<td><b>Km:</b></td>
									<td><?php echo $lead['kms']; ?></td>
								</tr>
								<tr>
									<td><b>Engine Number:</b></td>
									<td><?php echo $lead['engine']; ?></td>
								</tr>
								<tr>
									<td><b>Registration:</b></td>
									<td><?php echo $lead['registration_plate']; ?></td>
								</tr>
								<tr>
									<td><b>Colour:</b></td>
									<td><?php echo $lead['colour']; ?></td>
								</tr>
							</table>
							<br />
							<table class="content_2" width="100%">
								<tr>
									<td><b>New Car Dealership:</b></td>
									<td><?php echo $lead['dealership_name']; ?></td>
								</tr>
								<tr>
									<td><b>Address:</b></td>
									<td><?php echo $lead['dealer_address']; ?></td>
								</tr>
								<tr>
									<td><b>Postcode:</b></td>
									<td><?php echo $lead['dealer_postcode']; ?></td>
								</tr>
								<tr>
									<td><b>State:</b></td>
									<td><?php echo $lead['dealer_state']; ?></td>
								</tr>								
								<tr>
									<td><b>ABN:</b></td>
									<td><?php echo $lead['dealer_abn']; ?></td>
								</tr>
								<tr>
									<td><b>Phone:</b></td>
									<td><?php echo $lead['dealer_phone']; ?></td>
								</tr>
								<tr>
									<td><b>Email:</b></td>
									<td><?php echo $lead['dealer_email']; ?></td>
								</tr>
								<tr>
									<td><b>Fleet Manager:</b></td>
									<td><?php echo $lead['fleet_manager']; ?></td>
								</tr>								
							</table>
						</td>
					</tr>			
				</tbody>
			</table>
			<br />
			<?php 
			if (count($tradeins) > 0)
			{
				?>
				<div class="delivery">
					<strong>Tradeins</strong>
				</div>
				<table class="content" width="100%">
					<tbody>
						<tr>
							<th style="border: 1px #000 solid;"><strong>Car Details</strong></th>
						</tr>
						<?php
						foreach ($tradeins AS $tradein)
						{
							?>
							<tr>
								<td>
									<?php
									echo $tradein->tradein_make . " " . $tradein->tradein_model . " " . 
									$tradein->tradein_build_date . " " . $tradein->tradein_variant . " " . 
									$tradein->tradein_colour."<br /><b>Registration Plate:</b> ".$tradein->registration_plate;
									?>
								</td>
							</tr>							
							<?php
						}
						?>
					</tbody>
				</table>				
				<?php
			}
			?>
		</div>
		<pagebreak />
		<div class="details">
			<table class="content" width="100%" style="border-top: 1px solid #666;">
				<tbody>										
					<tr>
						<td width="50%">
							<p class="terms_text">		
								1.1 The Purchase Price of the motor vehicle is the amount shown as
								"Total Purchase Amount".
							</p>
							<p class="terms_text">
								1.2 The Purchase Price may be varied if before the delivery of the
								motor vehicle, there is a change in the manufacturer's recommended
								retail price, statutory charges or applicable taxes and duties. The
								Dealer shall give the Customer & Quote Me written notice of any
								variation in the Purchase Price. If the purchase price is varied due to
								an increase in the recommended retail price, the Customer may
								rescind this Contract any time within three (3) days after receipt of
								the written notice of the variation.
							</p>
							<p class="terms_text">
								2.1 The Dealer shall use its best endeavours to acquire the motor
								vehicle by the estimated delivery date, but shall not be liable to the
								customer for any damage or loss whatsoever arising either directly or
								indirectly from any such delay or failure of delivery.
							</p>
							<p class="terms_text">								
								2.2 The Customer shall take delivery of the motor vehicle at the
								Dealer's Premises within (7) days of the Dealer notifying the
								Customer that the motor vehicle is available for delivery.
							</p>
							<p class="terms_text">								
								2.3 If Dealer has not delivered the motor vehicle to the Customer
								within thirty (30) days of the estimated delivery date, the Customer
								may by notice in writing to the Dealer rescind this Contract.
							</p>
							<p class="terms_text">								
								2.4 Both the Dealer and the Customer acknowledge by signing this
								Clause in the space provided below that the motor vehicle is of
								unusual design or combines unusual options and that the Customer
								waives his right to rescission as provided in Clause 2.3.
								Dealer:............................................................................
								Customer:.......................................................................
							</p>
							<p class="terms_text">								
								3.1 At or before taking delivery of the motor vehicle the Customer
								shall pay to the Dealer the balance of the Purchase Price shown as
								“Total Purchase Amount".
							</p>
							<p class="terms_text">								
								3.2 Before taking delivery of the motor vehicle the Customer shall
								deliver to the Dealer the trade-in vehicle together with all
								accessories, extras and attachments fitted at the time of valuation. If
								the trade-in vehicle is not in substantially the same condition as when
								valued by the Dealer, the parties may negotiate a variation in the net
								trade-in allowance or either party may rescind this contract.
							</p>
							<p class="terms_text">								
								3.3 Until the Dealer has received payment in full of the Quoted Price
								issued to Quote Me, title in the motor vehicle shall not pass to the
								Customer and the Customer shall hold possession of it as bailee
								only.
							</p>
							<p class="terms_text">								
								3.4 The Customer shall be deemed not to have paid the purchase
								price until the Dealer receives payment and unencumbered title to
								any trade-in vehicle and all other payments are credited to the
								Dealer's account.
							</p>
							<p class="terms_text">								
								3.5 While the Customer holds possession of the motor vehicle as
								bailee he/she:
								(a) is responsible for its proper care and maintenance;
								(b) is liable for any loss or damage occasioned to it subject to the
								Customer’s obligations, if the contract is terminated under any
								Cooling Off Right applicable to the Contract; and
								(c) will indemnify the Dealer against any claim arising from its use.
							</p>
							<p class="terms_text">								
								3.6 Where the Dealer is entitled to reclaim possession of the motor
								vehicle, the Customer authorises the Dealer, its servants and agents
								to lawfully enter the Customers property for the purposes of retaking
								possession.
							</p>
							<p class="terms_text">								
								3.7 The Dealer and Customer acknowledge Quote Me P/L as the
								introducer of customer to dealership. Vehicle Payments or deposits
								taken by Quote Me are forwarded (less any outstanding associated
								invoices) to the dealer 48 hours before the delivery date shown.
							</p>
							<p class="terms_text">								
								3.8 The supplying new car dealer is not responsible for the trade
								vehicle if there is an alternate dealer licence nominated below.
								Instead the nominated purchasing agent will pay via eft the valued
								amount (less Quote Me Fees) to the dealer supplying the new car.
								(This amount is the dealer quoted price - the client changeover price)	
							</p>
						</td>
						<td width="50%">
							<p class="terms_text">		
								4.1 Where the Customer requires finance to be provided for the
								payment of the motor vehicle, the Customer shall promptly provide
								the Dealer and/or Financier with information necessary to allow a
								determination of the Customer's finance application.
							</p>
							<p class="terms_text">
								4.2 Where the Customer advises the Dealer before entering into this
								Contract that he/she requires credit to be provided for the payment of
								the motor vehicle and having taken reasonable steps has been
								unable to obtain credit, the Customer may within a reasonable period
								by notice in writing given to the Dealer rescind the contract.
							</p>
							<p class="terms_text">								
								5. Where the Customer refuses or fails to take delivery of the
								motor vehicle other than under the cooling off right under
								section 29CA the Motor Dealers Act 1974 (NSW) applicable to
								this contract (Cooling Off Right) or is otherwise in breach of his
								obligations under this Contract, the Dealer may terminate this
								Contract by written notice to the Customer.
								Thereafter any deposit paid or payable by the Customer to an
								amount not exceeding 5% of the total Purchase Price of the
								vehicle shall be forfeited to the Dealer. Both parties
								acknowledge that the Dealer shall be entitled to claim by way of
								pre-estimated liquidated damages from the Customer an amount
								equal to 5% of the “Total Purchase Amount” less any deposit
								forfeited.
							</p>
							<p class="terms_text">								
								6. Where this Contract is lawfully rescinded (otherwise than by
								exercise of the Cooling Off Right), the dealer shall refund any monies
								paid by the Customer and where possible return the trade-in vehicle
								PROVIDED THAT the Dealer shall retain from any monies due to the
								Customer the actual costs of repairs and improvements, including
								GST, to the trade-in vehicle and any payouts made or to be made by
								the Dealer to clear any encumbrances- Where the Dealer has
								disposed of the trade-in vehicle the Customer shall accept
								$……………….. which the parties agree is fair and reasonable
								compensation.
							</p>
							<p class="terms_text">								
								7. If the Customer is entitled and duly elects to terminate this contract
								under the Cooling Off Right;
							</p>
							<p class="terms_text">								
								7.1 the Customer is liable to the dealer for any damage to the motor
								vehicle while it was in the Customer’s possession, other than fair
								wear and tear;
							</p>
							<p class="terms_text">								
								7.2 the Dealer need not return any trade in vehicle if the dealer is
								unable to return it because of a defect in the trade in vehicle, not
								caused by the Dealer, that renders the trade in vehicle incapable of
								being driven or unroadworthy, but the Dealer must permit, and the
								Customer must arrange for, the collection of the trade in vehicle from
								the Dealer with in 24 hours of exercise of the Cooling Off Right;
							</p>
							<p class="terms_text">								
								7.3 the Customer (if the Customer has accepted delivery of the motor
								vehicle before termination) must return the motor vehicle to the
								Dealer unless the Customer is not able to return it because the motor
								vehicle because of a defect in the motor vehicle, not ceased by the
								Customer that has rendered the motor vehicle incapable of being
								driven or unroadworthy in which case the Customer must permit, and
								the Dealer must arrange for, the collection of the motor vehicle; and
							</p>
							<p class="terms_text">								
								7.4 any “tied loan contract” within the meaning of the Consumer
								Credit (New South Wales) Code is terminated and section 125(2)-(6
								of the Code applies to that termination as if it were a termination
								referred to in that section.
							</p>
							<p class="terms_text">								
								8. No warranties apply to this Contract with the exception of any
								which have been implied pursuant to any Commonwealth or State
								law and which may not by law be excluded there from together with
								any expressed warranties, the term of which are set out herein.
							</p>
							<p class="terms_text">								
								9. Any addition to or variation of these terms and conditions will have
								no effect unless made in writing and signed by the parties to this
								Contract.			
							</p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>		
		<pagebreak />
		<div class="details">
			<table class="content" width="100%" style="border-top: 1px solid #666;">
				<tbody>										
					<tr>
						<td width="50%">
							<p class="terms_text"><b>PRIVACY STATEMENT</b></p>
							<br />
							<p class="terms_text">	
								1. The Dealer is an organisation bound by the National Privacy Principles under the Privacy Act 1988. A copy of the Principles is available for
								perusal at the Dealer’s premises or from the Office of the National Privacy Commissioner.
								2. The kind of information the dealer holds is that detailed within this contract document or other information necessary to establish the
								Customer’s identification.
							</p>
							<p class="terms_text">
								3. The main purposes the Dealer will use this information will be to facilitate the delivery of the goods which are the subject of this contract;
								and to meet the requirements of government authorities and third party suppliers associated with the supply of the motor vehicle and related
								goods. Associated services will include the vehicle and the provision of warranty and servicing for the vehicle; insurance and registration of
								the vehicle; and the provision of information about new products related to vehicle use which becomes available from time to time.
							</p>
							<p class="terms_text">								
								4. The kinds of people that may be provided with information relating to you will include the NSW Roads and Traffic Authority, insurance
								companies, suppliers of cars and other automotive products and services.
							</p>
							<p class="terms_text">								
								5. If you have any query or concerns about the way the Dealer manages your personal information, you should contact your sales consultant.
							</p>
							<p class="terms_text">								
								6. You may request access to your personal information held by the Dealer, by contacting the person nominated in clause 5 above.
							</p>
							<p class="terms_text">								
								7. Please tick this box if you do not wish to receive any marketing material from the Manufacturer, Manufacturer Dealers or other
								Manufacturer entities. 						
							</p>
						</td>
						<td width="50%">
							<p class="terms_text"><b>DETERMINATION AS TO CREDIT Delete and initial as appropriate</b></p>
							<br />
							<p class="terms_text">	
								1. The Customer does not require credit from any source to be
								provided for the payment of the motor vehicle, OR
							</p>
							<p class="terms_text">							
								2. The customer requires credit to be provided before effect can be
								given to the Contract and will take reasonable steps themselves to
								arrange credit without delay. OR
							</p>
							<p class="terms_text">
								3. The customer requires credit to be provided before effect can be
								given to the Contract and authorises the Dealer to arrange credit on
								his/her behalf
							</p>
							<br />
							<p class="terms_text">
								This New Car Order Complies With <b>The Electronic
								Transactions Act 1999</b> And Is a Legally Binding
								Contract.
							</p>
						</td>						
					</tr>
				</tbody>
			</table>
		</div>
	</body>
</html>
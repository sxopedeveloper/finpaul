<?php
date_default_timezone_set('Australia/Sydney');
ini_set('max_execution_time', -1);

$dealer_details = 
"<b>" . $deal['dealership_name'] . "</b><br />" .
$deal['fleet_manager'] . "<br />" .
$deal['dealer_email'] . "<br />" .
$deal['dealer_address'] . "<br />" . 
$deal['dealer_state'] . " " . $deal['dealer_postcode'];

$client_details =
"<b>" . $deal['name'] . "</b><br />" .
"<b>" . $deal['email'] . "</b><br />" .
$deal['address'] . "<br />" .
$deal['state'] . " " . $deal['postcode'] . "<br />" .
$deal['phone'];
?>
<html>
	<head>
		<title><?php echo $deal['client_invoice_number']; ?></title>
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

			td {
				vertical-align: top;
			}

			.content td {
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
								<center><h2 class="th_po_text"><?php echo $deal['cq_number']; ?></h2></center>
							</th>
						</tr>
						<tr>
							<td class="th_po_num_title">
								<center><h4 class="th_po_num_text"><?php echo $deal['client_invoice_number']; ?></h4></center>
							</td>
						</tr>
					</table>					
				</td>
				<td>
					<?php
					if ($deal['approved_date'] == "0000-00-00") { $approved_date = ""; }
					else { $approved_date = date('d/m/Y', strtotime($deal['approved_date'])); }
					?>
					<h4 class="th_po_num_text"><?php // echo $approved_date; ?></h4>		
				</td>
				<td align="right">
					<img src="<?php echo $company_settings['company_logo']; ?>" alt="<?php echo $company_settings['company_name']; ?>" width="220px;" height="50px;" />
				</td>				
			</tr>
		</table>
		<div class="blue_header">
			<strong><?php echo $deal['cq_number']; ?></strong>
		</div>
		<div class="details">
			<table width="100%">
				<tbody>
					<tr>
						<td width="60%" style="padding: 8px; padding-top: 0px; padding-bottom: 0px;">
							<table class="content" width="100%" style="height: 300px;">
								<tbody>
									<tr>
										<th><strong>INVOICE TO:</strong></th>
									</tr>										
									<tr>
										<td>
											<?php echo $client_details; ?>
										</td>
									</tr>			
								</tbody>
							</table>					
						</td>
						<td width="40%" style="padding: 8px; padding-top: 0px; padding-bottom: 0px;">
							<table class="content" width="100%">
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
										<td>Deposit (Receipt #<?php echo "DEP".$deal['id_lead']."".$deposit_counter; ?> Rec <?php echo $deposit_date; ?>)</td>
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
										<td>Refund made <?php echo $refund_date; ?> (<?php echo "REF".$deal['id_lead']."_".$refund_counter; ?>)</td>
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
									<td><?php echo $deal['tender_make']; ?></td>
								</tr>
								<tr>
									<td><b>Model:</b></td>
									<td><?php echo $deal['tender_model']; ?></td>
								</tr>
								<tr>
									<td><b>Variant:</b></td>
									<td><?php echo $deal['tender_variant']; ?></td>
								</tr>
								<tr>
									<td><b>Build Date:</b></td>
									<td><?php echo $deal['build_date']; ?></td>
								</tr>
								<tr>
									<td><b>Compliance Date:</b></td>
									<td><?php echo $deal['compliance_date']; ?></td>
								</tr>
								<tr>
									<td><b>VIN:</b></td>
									<td><?php echo $deal['vin']; ?></td>
								</tr>
								<tr>
									<td><b>Km:</b></td>
									<td><?php echo $deal['kms']; ?></td>
								</tr>
								<tr>
									<td><b>Engine Number:</b></td>
									<td><?php echo $deal['engine']; ?></td>
								</tr>
								<tr>
									<td><b>Registration:</b></td>
									<td><?php echo $deal['registration_plate']; ?></td>
								</tr>
								<tr>
									<td><b>Colour:</b></td>
									<td><?php echo $deal['colour']; ?></td>
								</tr>
							</table>
							<br />
							<table class="content_2" width="100%">
								<tr>
									<td>
										<b><?php echo $deal['dealership_name']; ?></b><br />
										ABN : <b><?php echo $deal['dealer_abn']; ?></b>
										<br /><br />
										<b><?php echo $deal['dealer_address']; ?>,</b><br />
										<b><?php echo $deal['dealer_postcode'].", ".$deal['dealer_state']; ?></b>
										<br /><br /><br />
										<b>Phone:</b> <?php echo $deal['dealer_phone']; ?><br />
										<b>Mobile:</b> <?php echo $deal['dealer_mobile']; ?><br />
										<b>Fleet Manager:</b> <?php echo $deal['fleet_manager']; ?>
										<br /><br />
										<b>Due at delivery</b>
										<br /><br />
									</td>
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
			<div class="delivery">
				<strong>Bank Details</strong>
			</div>
			<table class="content" width="100%">
				<tbody>
					<tr>
						<th style="border: 1px #000 solid;"><strong>Dealer Bank Account</strong></th>
						<th style="border: 1px #000 solid;"><strong>BSB</strong></th>
						<th style="border: 1px #000 solid;"><strong>Account Number</strong></th>
					</tr>
					<tr>
						<td><b><?php echo $deal['bank_acct_name']; ?></b></td>
						<td><b><?php echo $deal['bank_acct_bsb']; ?></b></td>
						<td><b><?php echo $deal['bank_acct_num']; ?></b></td>
					</tr>					
				</tbody>
			</table>
			<!--
			<p style="font-size: 1.2em;">
				Please email remittances to <a href="mailto:<?php echo $deal['account_email']; ?>" target="_blank"><?php echo $deal['account_email']; ?></a>
			</p>
			-->
		</div>		
	</body>
</html>
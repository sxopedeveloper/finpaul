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
		<title><?php echo $title; ?> - <?php echo $deal['client_invoice_number']; ?></title>
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
				background: #0d75ba; 
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
				background: #0d75ba;
				color: #fff;				
				font-size: 1.3em; 
				margin-top: 18px; 
				margin-bottom: 10px;			
			}

			.special_conditions {
				padding: 5px 7px 4px 7px;
				background: #0d75ba; 
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
								<center><h2 class="th_po_text">TAX INVOICE</h2></center>
							</th>
						</tr>
						<tr>
							<td class="th_po_num_title">
								<center><h4 class="th_po_num_text"><?php echo $deal['client_invoice_number']; ?></h4></center>
							</td>
						</tr>
					</table>					
				</td>
				<td align="right">
					<img src="http://www.mycqo.com.au/assets/img/logos/new_quoteme.png" alt="Quote Me" width="220px;" height="60px;" />
				</td>				
			</tr>
		</table>
		<div class="blue_header">
			<strong>New Vehicle Tax Invoice</strong>
		</div>
		<div class="details">
			<table width="100%">
				<tbody>
					<tr>
						<td width="50%" style="padding: 8px; padding-top: 0px; padding-bottom: 0px;">
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
						<td width="50%" style="padding: 8px; padding-top: 0px; padding-bottom: 0px;">
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
						<td width="50%" style="padding: 8px; padding-top: 0px; padding-bottom: 0px;">
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
									<td align="right"><p style="font-size: 1.2em;"><?php echo number_format($invoice_details['subtotal_1'], 2); ?></p></td>
								</tr>
								<tr>
									<td>Discount</td>
									<td align="right"><?php echo number_format($invoice_details['discount'], 2); ?></td>
								</tr>

								<tr>
									<td><b><p style="font-size: 1.2em;">Sub Total</p></b></td>
									<td align="right"><p style="font-size: 1.2em;"><?php echo number_format($invoice_details['subtotal_2'], 2); ?></p></td>
								</tr>
								<tr>
									<td>GST Included in Sub Total</td>
									<td align="right"><?php echo number_format($invoice_details['subtotal_gst_inc'], 2); ?></td>
								</tr>
								<tr>
									<td>LCT</td>
									<td align="right"><?php echo number_format($invoice_details['lct_cpp'], 2); ?></td>
								</tr>

								<tr>
									<td>Stamp Duty</td>
									<td align="right"><?php echo number_format($invoice_details['stamp_duty_cpp'], 2); ?></td>
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
									<td><b><p style="font-size: 1.2em;">Total Price (inc GST)</p></b></td>
									<td align="right"><p style="font-size: 1.2em;"><?php echo number_format($invoice_details['total_price_gst_inc'], 2); ?></p></td>
								</tr>
								<tr>
									<td>Deposit</td>
									<td align="right"><?php echo number_format($invoice_details['deposits_total'], 2); ?></td>
								</tr>
								<tr>
									<td>Allowance for Trade In</td>
									<td align="right"><?php echo number_format($invoice_details['tradein_value'], 2); ?></td>
								</tr>
								<tr>
									<td>Payout</td>
									<td align="right"><?php echo number_format($invoice_details['tradein_payout'], 2); ?></td>
								</tr>
								<tr>
									<td>Refunds</td>
									<td align="right"><?php echo number_format($invoice_details['refunds_total'], 2); ?></td>
								</tr>
								<tr>
									<td>
										<b><p style="font-size: 1.3em;">Balance</p></b>
									</td>
									<td align="right">
										<b><p style="font-size: 1.3em;">$ <?php echo number_format($invoice_details['balance'], 2); ?></p></b>
									</td>
								</tr>								
							</table>
						</td>
						<td width="50%" style="padding: 8px; padding-top: 0px; padding-bottom: 0px;">
							<table class="content_2" width="100%">
								<tr>
									<th colspan="2" width="50%"><strong>VEHICLE DETAILS:</strong></th>
								</tr>
								<tr>
									<td><b>Make:</b></td>
									<td><?php echo $deal['make']; ?></td>
								</tr>
								<tr>
									<td><b>Model:</b></td>
									<td><?php echo $deal['model']; ?></td>
								</tr>
								<tr>
									<td><b>Variant:</b></td>
									<td><?php echo $deal['variant']; ?></td>
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
									<td><?php echo $deal['vin']; ?></td>
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
										<b>Car Quotes Online Pty Ltd</b> T/A Car Quotes Online<br />
										ABN : <b>13605078377</b>
										Dealer Lic: <b>MD 026386</b>
										<br /><br />
										<b>21 The Waterview Wharf Workshops</b><br />
										<b>37 Nicholson St East Balmain</b><br />
										<b>NSW 2041</b>
										<br /><br /><br />
										<b>Phone: 1300 073 065</b><br />
										<a href="http://www.carquote.net.au" target="_blank">www.carquote.net.au</a><br />
										<a href="mailto:accounts@cqo.com.au" target="_blank">accounts@cqo.com.au</a>
									</td>
								</tr>
							</table>
						</td>
					</tr>			
				</tbody>
			</table>
			<br />
			<div class="delivery">
				<strong>Bank Details</strong>
			</div>			
			<table class="content" width="100%">
				<tbody>
					<tr>
						<th style="border: 1px #000 solid;"><strong>Car Quotes Online Bank Account</strong></th>
						<th style="border: 1px #000 solid;"><strong>BSB</strong></th>
						<th style="border: 1px #000 solid;"><strong>Account Number</strong></th>
					</tr>
					<tr>
						<td><b>National Australia Bank</b></td>
						<td><b>082-167</b></td>
						<td><b>413780607</b></td>
					</tr>					
				</tbody>
			</table>
			<p style="font-size: 1.2em;">
				Please email remittances to <a href="mailto:accounts@cqo.com.au" target="_blank">accounts@cqo.com.au</a>
			</p>			
		</div>		
	</body>
</html>
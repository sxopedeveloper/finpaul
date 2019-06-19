<?php
date_default_timezone_set('Australia/Sydney');
ini_set('max_execution_time', -1);

$invoice_number = "TF".str_pad($tradein['fk_lead'], 5, '0', STR_PAD_LEFT)."_".$tradein['id_tradein'];

$from_details = 
"<b>".$company_settings['company_name']."</b><br />
".$company_settings['company_alternate_email']."<br />
".$company_settings['company_postal_address_line_1'].", ".$company_settings['company_postal_address_line_2'].",<br />
".$company_settings['company_postal_suburb'].", ".$company_settings['company_postal_state']." ".$company_settings['company_postal_postcode']."<br />
Call ".$company_settings['company_phone'];

$to_details = 
"<b>".$tradein['buyer_name']."</b><br />" .
$tradein['buyer_email'] . "<br />" .
$tradein['buyer_address'] . "<br />" . 
$tradein['buyer_state'] . " " . $tradein['buyer_postcode'] . "<br />" . 
$tradein['buyer_phone'];

$description = "
Tender Fee for the introduction of ".$tradein['tradein_make']." ".$tradein['tradein_model']." (".$tradein['registration_plate'].")";

$total_amount = $tradein['total_payment_amount'];
$gst = $total_amount / 11;
?>
<html>
	<head>
		<title>Tax Invoice - <?php echo $invoice_number; ?></title>
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
				background: #58c603; 
				color: #ffffff;
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
				<td width="18%">
					<table class="content">
						<tr>
							<th class="th_po_title">
								<center><h2 class="th_po_text">INVOICE</h2></center>
							</th>
						</tr>
						<tr>
							<td class="th_po_num_title">
								<center><h4 class="th_po_num_text"><?php echo $invoice_number; ?></h4></center>
							</td>
						</tr>
					</table>					
				</td>
				<td><!-- Paid Label --></td>
				<td align="right">
					<img src="<?php echo $company_settings['company_logo']; ?>" alt="<?php echo $company_settings['company_name']; ?>" width="220px;" height="50px;" />
				</td>
			</tr>
		</table>
		<div class="blue_header">
			<strong>TAX INVOICE FOR CAR TENDER FEE</strong>
		</div>
		<div class="details">
			<table class="content" width="100%">
				<tbody>
					<tr>
						<th colspan="2" width="50%"><strong>INVOICE TO:</strong></th>
						<th colspan="2" width="50%"><strong>INVOICE FROM:</strong></th>
					</tr>										
					<tr>
						<td colspan="2">
							<?php echo $to_details; ?>
						</td>
						<td colspan="2">
							<?php echo $from_details; ?>
						</td>
					</tr>
					<tr>
						<th width="25%"><strong>DATE TAX INVOICE ISSUED</strong></th>
						<th width="25%"><strong>PAYMENT DUE DATE</strong></th>
						<th width="50%"><strong><?php echo str_replace(' ', '', strtoupper($company_settings['company_short_name'])); ?> ABN</strong></th>
					</tr>
					<tr>
						<?php
						if ($tradein['invoice_date'] == "0000-00-00") { $invoice_date = ""; }
						else { $invoice_date = date('d F Y', strtotime($tradein['invoice_date'])); }
						
						if ($tradein['invoice_due_date'] == "0000-00-00") { $due_date = ""; }
						else { $due_date = date('d F Y', strtotime($tradein['invoice_due_date'])); }
						?>
						<td><?php echo $invoice_date; ?></td>
						<td><?php echo $due_date; ?></td>
						<td><?php echo $company_settings['company_abn']; ?></td>
					</tr>						
				</tbody>
			</table>
		</div>
		<br />
		<br />
		<div class="details">
			<table class="content" width="100%">
				<tr>
					<th colspan="5"><strong>DETAILS</strong></th>
				</tr>
				<tr>
					<td class="th_2" width="50%"><b>Description</b></td>
					<td class="th_2" width="12%"><b>Quantity</b></td>
					<td class="th_2" width="12%"><b>Unit Price</b></td>
					<td class="th_2" width="12%"><b>GST</b></td>
					<td class="th_2" width="14%" align="right"><b>Amount (AUD)</b></td>
				</tr>
				<tr>
					<td><?php echo $description; ?></td>
					<td>1</td>
					<td><?php echo number_format($total_amount, 2); ?></td>
					<td>10%</td>
					<td align="right"><?php echo number_format($total_amount, 2); ?></td>
				</tr>
			</table>
			<br />
			<table class="content" width="50%" align="right">
				<tbody>
					<tr>
						<td align="right" width="72%" style="border-top: 1px solid #666;"><strong>Includes GST 10%</strong></td>
						<td align="right" style="border-top: 1px solid #666;"><strong>$ <?php echo number_format($gst, 2); ?></strong></td>
					</tr>					
					<tr>
						<td align="right" style="border-top: 1px solid #666;"><strong>BALANCE PAYABLE (AUD)</strong></td>
						<td align="right" style="border-top: 1px solid #666;"><strong>$ <?php echo number_format($total_amount, 2); ?></strong></td>
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
						<th style="border: 1px #000 solid;"><strong><?php echo $company_settings['company_short_name']; ?> Bank Account</strong></th>
						<th style="border: 1px #000 solid;"><strong>BSB</strong></th>
						<th style="border: 1px #000 solid;"><strong>Account Number</strong></th>
					</tr>
					<tr>
						<td><b><?php echo $company_settings['bank']; ?></b></td>
						<td><b><?php echo $company_settings['bsb']; ?></b></td>
						<td><b><?php echo $company_settings['account_number']; ?></b></td>
					</tr>					
				</tbody>
			</table>
			<p style="font-size: 1.2em;">
				Please email remittances to <a href="mailto:<?php echo $company_settings['company_alternate_email']; ?>" target="_blank"><?php echo $company_settings['company_alternate_email']; ?></a>
			</p>
			<br />
			<p style="font-size: 1.2em;">
				<b>Terms and conditions regarding the use of this service:</b>
			</p>
			<ul>
				<li>
					This vehicle is being purchased from a private buyer (unless otherwise noted) the payment instructions
					listed below. Where a dealer is nominated as the contact and pickup point, they are allowing the client
					to have the car on the premises until it is picked up by the nominated wholesaler. 
				</li>
				<li>
					If the car is booked
					into stock and it is being purchased from the dealer, it will be clearly shown in the pickup instructions
					and a tax invoice issues by the selling dealer. <b>Quote Me</b> is not the supplier of the new or used 
					vehicles and acts as an adiministrator only.
				</li>
			</ul>			
		</div>
		<pagebreak />
		<table width="100%">
			<tr>
				<td><p></p></td>
				<td align="right"><img src="<?php echo $company_settings['company_logo']; ?>" alt="<?php echo $company_settings['company_name']; ?>" width="220px;" height="50px;" /></td>
			</tr>
		</table>
		<div class="blue_header">
			<strong>VEHICLE LOCATION AND PICKUP LOCATION</strong>
		</div>
		<div class="details">
			<table class="content" width="100%">
				<tr>
					<th colspan="5"><strong>DETAILS</strong></th>
				</tr>
				<tr>
					<td class="th_2" width="33.33%"><b>Owner's Name</b></td>
					<td class="th_2" width="33.33%"><b>Owner's Address</b></td>
					<td class="th_2" width="33.33%"><b>Owner's Phone Number</b></td>
				</tr>
				<?php 
				$client_address = $tradein['client_address']." ".$tradein['client_state']." ".$tradein['client_postcode'];
				$client_name = "";
				if ($tradein['business_name']<>"")
				{
					$client_name = $tradein['business_name'];
				}
				else
				{
					$client_name = $tradein['name'];
				}
				?>
				<tr>
					<td><?php echo $client_name; ?></td>
					<td><?php echo $client_address; ?></td>
					<td><?php echo $tradein['phone']; ?></td>
				</tr>
				<tr>
					<td class="th_2"><b>Contact Name For Pick Up</b></td>
					<td class="th_2"><b>Pick Up Address</b></td>
					<td class="th_2"><b>Contact Phone Number for Pick Up</b></td>
				</tr>
				<tr>
					<td><?php echo $tradein['contact_name']; ?></td>
					<td><?php echo $tradein['pickup_address']; ?></td>
					<td><?php echo $tradein['contact_number']; ?></td>
				</tr>
				<tr>
					<td class="th_2"><b>Date Of Pick Up</b></td>
					<td class="th_2"><b>Time Of Pick Up</b></td>
					<td class="th_2"><b>Special Requests</b></td>
				</tr>
				<tr>
					<td><?php echo $tradein['pickup_date']; ?></td>
					<td><?php echo $tradein['pickup_time']; ?></td>
					<td><?php echo $tradein['special_request']; ?></td>
				</tr>
				<tr>
					<td class="th_2"><b>Registration Papers Attached</b></td>
					<td class="th_2"><b>Vehicle Pictures Attached</b></td>
					<td class="th_2"><b>Declaration Attached</b></td>
				</tr>
				<?php 
				if ($tradein['document_1_count'] > 0) { $document_1_count = '<img width="10px" src="http://www.myelquoto.com.au/assets/img/check.png">'; }
				else { $document_1_count = "-"; }
				
				if ($tradein['document_4_count'] > 0) { $document_4_count = '<img width="10px" src="http://www.myelquoto.com.au/assets/img/check.png">'; }
				else { $document_4_count = "-"; }

				if ($tradein['document_3_count'] > 0) { $document_3_count = '<img width="10px" src="http://www.myelquoto.com.au/assets/img/check.png">'; }
				else { $document_3_count = "-"; }
				?>
				<tr>
					<td><?php echo $document_1_count; ?></td>
					<td><?php echo $document_4_count; ?></td>
					<td><?php echo $document_3_count; ?></td>
				</tr>				
			</table>
		</div>
		<br />
		<div class="blue_header">
			<strong>VEHICLE DESCRIPTION</strong>
		</div>
		<div class="details">
			<table class="content" width="100%">
				<tr>
					<th colspan="5"><strong>DETAILS</strong></th>
				</tr>
				<tr>
					<td class="th_2" width="20%"><b>Make</b></td>
					<td class="th_2" width="20%"><b>Model</b></td>
					<td class="th_2" width="20%"><b>Variant</b></td>
					<td class="th_2" width="20%"><b>Fuel Type</b></td>
					<td class="th_2" width="20%"><b>Km</b></td>
				</tr>
				<tr>
					<td><?php echo $tradein['tradein_make']; ?></td>
					<td><?php echo $tradein['tradein_model']; ?></td>
					<td><?php echo $tradein['tradein_variant']; ?></td>
					<td><?php echo $tradein['tradein_fuel_type']; ?></td>
					<td><?php echo $tradein['tradein_kms']; ?></td>
				</tr>
				<tr>
					<td class="th_2" width="20%"><b>Reg Expiry</b></td>
					<td class="th_2" width="20%"><b>Colour</b></td>
					<td class="th_2" width="20%"><b>Transmission</b></td>
					<td class="th_2" width="20%"><b>Build Date</b></td>
					<td class="th_2" width="20%"><b>Compliance</b></td>
				</tr>
				<tr>
					<td><?php echo $tradein['rego_expiry']; ?></td>
					<td><?php echo $tradein['tradein_colour']; ?></td>
					<td><?php echo $tradein['tradein_transmission']; ?></td>
					<td><?php echo $tradein['tradein_build_date']; ?></td>
					<td><?php echo $tradein['tradein_compliance_date']; ?></td>
				</tr>
				<tr>
					<td class="th_2" width="20%"><b>Valued Date</b></td>
					<td class="th_2" width="20%"><b>Valued By</b></td>
					<td class="th_2" width="20%"><b>Options</b></td>
					<td class="th_2" width="20%"><b>Quote Me Contact</b></td>
					<td class="th_2" width="20%"><b></b></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td><?php echo $tradein['options_1']; ?></td>
					<td>Param Vora</td>
					<td></td>
				</tr>				
			</table>
		</div>
		<br />
		<div class="blue_header">
			<strong>PAYMENT INSTRUCTIONS</strong>
		</div>
		<div class="details">
			<table class="content" width="100%">
				<tr>
					<th colspan="5"><strong>DETAILS</strong></th>
				</tr>
				<tr>
					<td class="th_2" width="50%"><b>Payment To Quote Me</b></td>
					<td class="th_2" width="50%"><b>Bank Details</b></td>
				</tr>
				<tr>
					<td><?php echo "$ ".number_format($tradein['total_payment_amount'],2 ); ?></td>
					<td><?php echo $tradein['bank_details']; ?></td>
				</tr>
				<tr>
					<td class="th_2" width="50%"><b>Dealer Payment</b></td>
					<td class="th_2" width="50%"><b>Bank Account</b></td>
				</tr>
				<tr>
					<td><?php echo "$ ".number_format($tradein['dealer_payment'], 2); ?></td>
					<td><?php echo $tradein['bank_account']; ?></td>
				</tr>
				<tr>
					<td class="th_2" width="50%"><b>Client Payment</b></td>
					<td class="th_2" width="50%"><b>BSB</b></td>
				</tr>
				<tr>
					<td><?php echo "$ ".number_format($tradein['client_payment'], 2); ?></td>
					<td><?php echo $tradein['bsb']; ?></td>
				</tr>
				<tr>
					<td class="th_2" width="50%"><b>TOTAL PAYMENT</b></td>
					<td class="th_2" width="50%"><b>Reference</b></td>
				</tr>
				<tr>
					<?php
					$total_payment = $tradein['total_payment_amount'] + $tradein['dealer_payment'] + $tradein['client_payment'];
					?>
					<td><?php echo "$ ".number_format($total_payment, 2); ?></td>
					<td><?php echo $tradein['reference']; ?></td>
				</tr>
				<tr>
					<td class="th_2" width="50%"><b>Payout Amount</b></td>
					<td class="th_2" width="50%"><b>PPSR</b></td>
				</tr>
				<tr>
					<td><?php echo "$ ".number_format($tradein['tradein_payout'], 2); ?></td>
					<td><?php echo $tradein['ppsr']; ?></td>
				</tr>				
			</table>
			<br />
			<p style="font-size: 1.2em;">
				<b>Quote Me</b> is not the supplier of New or Used Cars. The vehicles purchased are direct from
				the owner and no liability or responsibility is taken by <b>Quote Me</b> for the vehicle
				condition or value. Wholesalers are encouraged to view cars prior to payment or to get a vehicle
				inspection.
			</p>
			<p style="font-size: 1.2em;">
				<b>Quote Me</b> is not a motor dealer and participates as paid introducer only.
			</p>			
		</div>
	</body>
</html>
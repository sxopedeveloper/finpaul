<?php
date_default_timezone_set('Australia/Sydney');
ini_set('max_execution_time', -1);

$host = $_SERVER['HTTP_HOST'];
if ($host == "localhost")
{
	$db = mysqli_connect("109.73.228.248", "mycarquo_master", "McQ@yoU0854", "mycarquo_master");
}
else
{
	$db = mysqli_connect("109.73.228.248", "mycarquo_master", "McQ@yoU0854", "mycarquo_master");
}

$from_details = 
"<b>".$company_settings['company_name']."</b><br />
".$company_settings['company_alternate_email']."<br />
".$company_settings['company_postal_address_line_1'].", ".$company_settings['company_postal_address_line_2'].",<br />
".$company_settings['company_postal_suburb'].", ".$company_settings['company_postal_state']." ".$company_settings['company_postal_postcode']."<br />
Call ".$company_settings['company_phone'];

$to_details = "<b>".
$invoice['buyer_name'] . "</b><br />" .
$invoice['buyer_email'] . "<br />" .
$invoice['buyer_address'] . "<br />" . 
$invoice['buyer_state'] . " " . $invoice['buyer_postcode'] . "<br />";

if ($invoice['type']==1) { $purchase_type = "PMA Protection"; } else { $purchase_type = "Manual Lead Sale"; }
if ($invoice['status']==1) { $payment_status = "Paid"; } else { $payment_status = "Pending"; }
?>
<html>
	<head>
		<title><?php echo $title; ?> - <?php echo $invoice['lead_sale_invoice_number']; ?></title>
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
				<td width="18%">
					<table class="content">
						<tr>
							<th class="th_po_title">
								<center><h2 class="th_po_text">INVOICE</h2></center>
							</th>
						</tr>
						<tr>
							<td class="th_po_num_title">
								<center><h4 class="th_po_num_text"><?php echo $invoice['lead_sale_invoice_number']; ?></h4></center>
							</td>
						</tr>
					</table>		
				</td>
				<td>
					<?php
					if ($invoice['status']==1)
					{
						echo '<span style="font-size: 3.0em; border: 3px solid #ff706c; padding: 10px; border-radius: 10px; color: #ff706c;"><b> &nbsp;PAID&nbsp; </b></span>';
					}
					?>				
				</td>
				<td align="right">
					<img src="<?php echo $company_settings['company_logo']; ?>" alt="<?php echo $company_settings['company_name']; ?>" width="220px;" height="50px;" />
				</td>				
			</tr>
		</table>
		<div class="blue_header">
			<strong>LEAD SALES INVOICE - From <?php echo strtoupper($company_settings['company_name']); ?></strong>
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
						$invoice_date_d = date_create($invoice['invoice_date']);
						$invoice_date = date_format($invoice_date_d, 'd F Y');

						$payment_due_date_d = date_create($invoice['payment_due_date']);
						$payment_due_date = date_format($payment_due_date_d, 'd F Y');						
						?>
						<td><?php echo $invoice_date; ?></td>
						<td><?php echo $payment_due_date; ?></td>
						<td><?php echo $company_settings['company_abn']; ?></td>
					</tr>						
				</tbody>
			</table>
		</div>
		<br />
		<div class="details">
			<table class="content" width="100%">
				<tr>
					<th colspan="5"><strong>ITEM INFORMATION</strong></th>
				</tr>
				<tr>
					<td class="th_2"><b>Description</b></td>
					<td class="th_2" align="right"><b>Amount</b></td>
					<td class="th_2" align="right"><b>Discount</b></td>
					<td class="th_2" align="right"><b>Merchant Fee</b></td>
					<td class="th_2" align="right"><b>TOTAL</b></td>
				</tr>
				<?php
				$balance_payable = 0;
				foreach ($transactions AS $transaction)
				{
					$transaction_date_d = date_create($transaction['created_at']);
					$transaction_date = date_format($transaction_date_d, 'd F Y');				
					echo '
					<tr>
						<td>
							<b>Transaction #: '.$transaction['transaction_number'].'</b> - <i>'.$transaction_date.'</i><br />';
							$query = "
							SELECT 
							ti.id_transaction_item, 
							CONCAT('QM', LPAD(l.id_lead, 5, '0')) AS `cq_number`,
							ti.fk_transaction, l.make, l.model, 
							l.name AS `client_name`, l.email AS `client_email`, l.phone AS `client_phone`, 
							l.state AS `client_state`, l.postcode AS `client_postcode`, l.lead_price, ti.amount, ti.created_at
							FROM transaction_items ti 
							JOIN leads l ON ti.fk_lead = l.id_lead 
							WHERE 1 AND ti.fk_transaction = ".$transaction['id_transaction']."
							GROUP BY ti.id_transaction_item ORDER BY ti.created_at ASC";
							$result = mysqli_query($db, $query);
							while ($row = mysqli_fetch_array($result))
							{							
								echo $row['cq_number'].' - '.$row['make'].' '.$row['model'].' ('.$row['client_postcode'].')<br />';
							}
							echo '
						</td>
						<td align="right" width="12.5%">'.$transaction['original_amount'].'</td>
						<td align="right" width="12.5%">'.$transaction['discount'].'</td>
						<td align="right" width="12.5%">'.$transaction['merchant_fee'].'</td>
						<td align="right" width="12.5%">'.$transaction['amount'].'</td>
					</tr>';
					$balance_payable += $transaction['amount'];
				}
				?>
			</table>
			<br />
			<table class="content" width="50%" align="right">
				<tbody>
					<tr>
						<td align="right" width="75%" style="border-top: 1px solid #666;"><strong>BALANCE PAYABLE (AUD)</strong></td>
						<td align="right" style="border-top: 1px solid #666;"><strong>$ <?php echo number_format($balance_payable, 2); ?></strong></td>
					</tr>											
				</tbody>								
			</table>
			<br />
			<div class="delivery">
				<strong>&nbsp;</strong>
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
			<br /><br />
			<p style="font-size: 1.3em;">
				<i>
					Our relationship with you is important and we value you as a client.<br />
					You are on a 7 day account.<br />
				</i>
			</p>
			<p style="font-size: 1.3em;">
				<i>
					If this requires alteration please email <a href="mailto:<?php echo $company_settings['company_alternate_email']; ?>"><?php echo $company_settings['company_alternate_email']; ?></a>
				</i>
			</p>
		</div>
	</body>
</html>
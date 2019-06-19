<?php
date_default_timezone_set('Australia/Sydney');
ini_set('max_execution_time', -1);

$from_details = 
"<b>".$company_settings['company_name']."</b><br />
".$company_settings['company_alternate_email']."<br />
".$company_settings['company_postal_address_line_1'].", ".$company_settings['company_postal_address_line_2'].",<br />
".$company_settings['company_postal_suburb'].", ".$company_settings['company_postal_state']." ".$company_settings['company_postal_postcode']."<br />
Call ".$company_settings['company_phone'];

$to_details = 
"<b>".$lead['dealership_name'] . "</b><br />" .
$lead['fleet_manager'] . "<br />" .
$lead['dealer_email'] . "<br />" .
$lead['dealer_address'] . "<br />" . 
$lead['dealer_state'] . " " . $lead['dealer_postcode'] . "<br />";

$item_details = $lead['cq_number'] . ": " . $lead['name'] . "<br />" . $lead['tender_make'] . " " . $lead['tender_model'] . " " . $lead['tender_variant'];

$winning_price = $lead['winning_price'];
$deposits_total = $lead['shown_deposits_total'];
$refunds_total = $lead['shown_refunds_total'];
$deposit_trans_total = $lead['shown_deposit_trans_total'];
$other_costs_amount = $lead['other_costs_amount'];
$client_balance = $revenue_details['balance'];

if ($lead['tradein_count']==0)
{
	$item_cost = $lead['sales_price'] - $lead['winning_price'];
}
else
{
	if ($lead['trade_buyer_type']=="Wholesaler" OR $lead['trade_buyer_type']=="Quote Me")
	{
		if ($client_balance < $winning_price)
		{
			$item_cost = $deposits_total - $refunds_total;
		}
		else
		{
			$item_cost = $deposits_total - $refunds_total + ($client_balance - $winning_price);
		}
	}
	else
	{
		$item_cost = $revenue_details['changeover'] - $lead['dealer_changeover'];
	}	
}

if ($lead['deduct_to_dealer_invoice']==1)
{
	$item_cost = $item_cost - $lead['other_costs_amount'];
}

if ($lead['deposit_show_status']==1)
{
	$balance_payable = $item_cost - ($deposits_total - $refunds_total - $deposit_trans_total);	
}
else
{
	$balance_payable = $item_cost;
}
$gst = $item_cost / 11;
?>
<html>
	<head>
		<title><?php echo $title; ?> - <?php echo $lead['dealer_invoice_number']; ?></title>
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
								<center><h2 class="th_po_text">TAX INVOICE</h2></center>
							</th>
						</tr>
						<tr>
							<td class="th_po_num_title">
								<center><h4 class="th_po_num_text"><?php echo $lead['dealer_invoice_number']; ?></h4></center>
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
			<strong>TAX INVOICE - From <?php echo strtoupper($company_settings['company_name']); ?> </strong>
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
						<th width="25%"><strong>SUPPLYING DEALER'S LICENSE</strong></th>
						<th width="25%"><strong><?php echo str_replace(' ', '', strtoupper($company_settings['company_short_name'])); ?> ABN</strong></th>
					</tr>
					<tr>
						<?php
						if ($lead['order_date'] == "")
						{
							$issued_date = "";
							$payment_due_date = "";
						}
						else
						{
							$issued_date = date('d F Y', strtotime($lead['order_date']));
							$payment_due_date = date('d F Y', strtotime($lead['delivery_date']));
						}
						?>
						<td><?php echo $issued_date; ?></td>
						<td><?php echo $payment_due_date; ?></td>
						<td><?php echo $lead['dealer_license']; ?></td>
						<td><?php echo $company_settings['company_abn']; ?></td>
					</tr>						
				</tbody>
			</table>
		</div>
		<br />
		<div class="details">
			<table class="content" width="100%">
				<tr>
					<th colspan="5"><strong>CAR AND CLIENT INFORMATION</strong></th>
				</tr>
				<tr>
					<td class="th_2" width="50%"><b>Description</b></td>
					<td class="th_2" width="12%" align="right"><b>Quantity</b></td>
					<td class="th_2" width="12%" align="right"><b>Unit Price</b></td>
					<td class="th_2" width="12%" align="right"><b>GST</b></td>
					<td class="th_2" width="14%" align="right"><b>Amount AUD</b></td>
				</tr>
				<tr>
					<?php
					$unit_price = $item_cost - $gst;
					?>
					<td><?php echo $item_details."<br /><br />"; ?></td>
					<td align="right">1</td>
					<td align="right"><?php echo number_format($unit_price, 2); ?></td>
					<td align="right">10%</td>
					<td align="right">$ <?php echo number_format($item_cost, 2); ?></td>
				</tr>
				<?php
				foreach ($deposits AS $deposit)
				{
					if ($deposit['show_status']==1)
					{
						if ($deposit['payment_date'] == "") { $payment_date = ""; }
						else { $payment_date = date('d F Y', strtotime($deposit['payment_date'])); }
						?>
						<tr>
							<td>Deposit Made: <?php echo $payment_date."<br />Reference #: ".$deposit['reference_number']; ?></td>
							<td align="right">1</td>
							<td align="right"><?php echo number_format($deposit['amount'], 2); ?></td>
							<td align="right"></td>
							<td align="right">(-) $ <?php echo number_format($deposit['amount'], 2); ?></td>
						</tr>
						<?php						
					}
				}
				
				foreach ($refunds AS $refund)
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
							<td align="right">1</td>
							<td align="right"><?php echo number_format($refund['amount'], 2); ?></td>
							<td align="right"></td>
							<td align="right">$ <?php echo number_format($refund['amount'], 2); ?></td>
						</tr>
						<?php
					}
				}
				
				foreach ($deposit_trans AS $deposit_tran)
				{
					if ($deposit_tran['show_status']==1)
					{
						if ($deposit_tran['payment_date'] == "")
						{
							$payment_date = "";
						}
						else
						{
							$payment_date = date('d F Y', strtotime($deposit_tran['payment_date']));
						}
						?>
						<tr>
							<td>Eft made to Dealer: <?php echo $payment_date."<br />Reference: ".$deposit_tran['reference_number']; ?></td>
							<td align="right">1</td>
							<td align="right"><?php echo number_format($deposit_tran['amount'], 2); ?></td>
							<td align="right"></td>
							<td align="right">$ <?php echo number_format($deposit_tran['amount'], 2); ?></td>
						</tr>
						<?php
					}
				}
				?>
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
						<td align="right" style="border-top: 1px solid #666;"><strong>$ <?php echo number_format($balance_payable, 2); ?></strong></td>
					</tr>											
				</tbody>								
			</table>
			<p align="right">
				<i>
					<?php echo $company_settings['company_short_name']; ?> Invoices include transport, logistics, member fees, registration, CTP and Stamp Duty 
					(by agreement*). <?php echo $company_settings['company_short_name']; ?> also provides the fitment of non genuine accessories where required. 
					If the delivery requires a handover technician to run thru the operation <br />
					of the vehicle this will be invoiced separately.
				</i>
			</p>
			<br />
			<div class="delivery">
				<strong>&nbsp;</strong>
			</div>
			<table class="content" width="100%">
				<tbody>
					<tr>
						<th style="border: 1px #000 solid;"><strong>Bank Account Name</strong></th>
						<th style="border: 1px #000 solid;"><strong>BSB</strong></th>
						<th style="border: 1px #000 solid;"><strong>Account Number</strong></th>
					</tr>
					<tr>
						<td><b><?php echo $company_settings['account_name']; ?></b></td>
						<td><b><?php echo $company_settings['bsb']; ?></b></td>
						<td><b><?php echo $company_settings['account_number']; ?></b></td>
					</tr>					
				</tbody>
			</table>
			<br /><br />
			<p style="font-size: 1.3em;">
				<i>
					Our relationship with you is important and we value you as a client.<br />
					The invoice is due within 2 days of delivery.<br />
				</i>
			</p>
			<p style="font-size: 1.3em;">
				<i>
					If this requires alteration please email <a href="mailto:<?php echo $company_settings['company_alternate_email']; ?>" target="_blank"><?php echo $company_settings['company_alternate_email']; ?></a>
				</i>
			</p>
		</div>
	</body>
</html>
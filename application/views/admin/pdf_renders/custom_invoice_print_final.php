<?php
date_default_timezone_set('Australia/Sydney');
ini_set('max_execution_time', -1);
?>
<html>
	<head>
		<title><?php echo $invoice['invoice_name']; ?> - <?php echo $invoice['invoice_number']; ?></title>
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
				<td width="20%">
					<table class="content">
						<tr>
							<th class="th_po_title">
								<center><h2 class="th_po_text">TAX INVOICE</h2></center>
							</th>
						</tr>
						<tr>
							<td class="th_po_num_title">
								<center><h4 class="th_po_num_text"><?php echo $invoice['invoice_number']; ?></h4></center>
							</td>
						</tr>
					</table>					
				</td>
				<td> <!-- Paid Label -->
					<?php
					if ($invoice['paid_status']=="Paid")
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
			<strong><?php echo $title; ?></strong>
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
						if ($invoice['invoice_date'] == "0000-00-00") { $invoice_date = ""; }
						else { $invoice_date = date('d F Y', strtotime($invoice['invoice_date'])); }
						
						if ($invoice['due_date'] == "0000-00-00") { $due_date = ""; }
						else { $due_date = date('d F Y', strtotime($invoice['due_date'])); }
						?>
						<td><?php echo $invoice_date; ?></td>
						<td><?php echo $due_date; ?></td>
						<td><?php echo $company_settings['company_abn']; ?></td>
					</tr>						
				</tbody>
			</table>
		</div>
		<br /><br />
		<div class="details">
			<table class="content" width="100%">
				<tr>
					<th colspan="5"><strong>DETAILS</strong></th>
				</tr>
				<tr>
					<td class="th_2" width="75%"><b>Description</b></td>
					<td class="th_2" width="11%"><b>GST</b></td>
					<td class="th_2" width="14%" align="right"><b>Amount (AUD)</b></td>
				</tr>
				<?php
				foreach ($invoice_items AS $invoice_item)
				{
					?>
					<tr>
						<td><?php echo $invoice_item['description']; ?></td>
						<td>10%</td>
						<td align="right"><?php echo number_format($invoice_item['amount'], 2); ?></td>
					</tr>									
					<?php
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
						<td align="right" style="border-top: 1px solid #666;"><strong><?php echo number_format($invoice['amount'], 2); ?></strong></td>
					</tr>											
				</tbody>								
			</table>			
			<p align="right">
				<i>
					<?php echo $invoice['remarks']; ?>
				</i>
			</p>
			<br />
			<div class="delivery">
				<strong>Bank Details</strong>
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
			<p style="font-size: 1.2em;">
				Please email remittances to <a href="mailto:<?php echo $company_settings['company_alternate_email']; ?>" target="_blank"><?php echo $company_settings['company_alternate_email']; ?></a>
			</p>			
		</div>		
	</body>
</html>
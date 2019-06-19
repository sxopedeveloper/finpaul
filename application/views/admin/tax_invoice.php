<?php
date_default_timezone_set('Australia/Sydney');
ini_set('max_execution_time', -1);
?>
<html>
	<head>
		<title><?php echo $title; ?> </title>
		<link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">
		<style>			
			body {
				font-family: Verdana, Geneva, sans-serif;
				color: #666;
				font-size: 12px;
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
			
			.green_header {
				padding: 5px 10px 5px 10px; 
				background: #58C603; 
				color: #fff; 
				font-size: 1.6em;
				margin-top: 18px;
				margin-bottom: 18px;
				text-align: center;
			}
			.green_header_small {
				padding: 5px 10px 5px 10px; 
				background: #58C603; 
				color: #fff; 
				font-size: 1em;
				margin-top: 10px;
				margin-bottom: 10px;
			}
			/*.details table > tbody tr > td {
				font-size: 0.9em;
			}*/
			
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

			.green_hr {
				clear: both;
				color: #58C603;
				background-color: #58C603;
				height: 2px;
				border-width: 0;
			}
			.vehicle_details{
				font-size: 10px !important;
			}
		</style>		
	</head>
	<body>
		<table width="100%">
			<tr>
				<td align="left">
					<img src="http://finquote.com.au/img/logo_40.png" alt="Finquotes Online" width="160px;" height="45px;" />
				</td>				
			</tr>
		</table>
		<hr class="green_hr">
		<br />
		<div class="details">
			<table width="100%">
				<tbody>
					<tr>
						<td style="float: left; width: 50%; ">
							<strong>Finquote Pty Ltd</strong><br/>
							37 Nicholson Street, <br/>
							East Balmain NSW 2041 - 1300 073 251<br/>
						</td>
						<td style="float: left; width: 50%;">
							Dealer : <?= $fq_data['seller'] ?> <br />
							Attn: _______________________________ <br/>
							Fax/email: <?= $fq_data['supplier_email'] ?> <br />
						</td>
					</tr>	
				</tbody>
			</table>
		</div>
		<div class="green_header">
			<strong>Tax Invoice Request</strong>
		</div>
		<div class="details">
			<table width="100%">
				<tbody>
					<tr>
						<td style="float: left; width: 50%; ">
							<table width="100%">
								<tbody>
									<tr>
										<td><h4>Invoice to:</h4></td>
										<td>_______________</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>_______________</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>_______________</td>
									</tr>
								</tbody>
							</table>
						</td>
						<td style="float: left; width: 50%; ">
							<table width="100%">
								<tbody>
									<tr>
										<td><h4>Delivery to:</h4></td>
										<td>_______________</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>_______________</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>_______________</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="vehicle_details">
			<div class="green_header_small">
				<strong>Vehicle Details</strong>
			</div>
			<table width="100%" style="font-size: 10px !important;">
				<tbody>
					<tr>
						<td style="float: left; width: 40%; ">
							Year (Specify if New, Used or Demonstrator):
						</td>
						<td style="float: left; width: 60%; ">
							<?= $fq_data['year'] ?> &nbsp; ( <?= $fq_data['car'] ?> )
						</td>
						<hr>
					</tr>
					<tr>
						<td style="float: left; width: 40%; ">
							Make:
						</td>
						<td style="float: left; width: 60%; ">
							<?= $fq_data['make'] ?>
						</td>
						<hr>
					</tr>
					<tr>
						<td style="float: left; width: 40%; ">
							Model:
						</td>
						<td style="float: left; width: 60%; ">
							<?= $fq_data['model'] ?>
						</td>
						<hr>
					</tr>
					<tr>
						<td style="float: left; width: 40%; ">
							Color:
						</td>
						<td style="float: left; width: 60%; ">
							<?= $fq_data['color'] ?>
						</td>
						<hr>
					</tr>
					<tr>
						<td style="float: left; width: 40%; ">
							Kilometers:
						</td>
						<td style="float: left; width: 60%; ">
							<?= $fq_data['kms'] ?>
						</td>
						<hr>
					</tr>
					<tr>
						<td style="float: left; width: 40%; ">
							Build Date:
						</td>
						<td style="float: left; width: 60%; ">
							<?= $fq_data['year'] ?>
						</td>
						<hr>
					</tr>
					<tr>
						<td style="float: left; width: 40%; ">
							Compliance Date:
						</td>
						<td style="float: left; width: 60%; ">
							<?= $fq_data['year'] ?>
						</td>
						<hr>
					</tr>
					<tr>
						<td style="float: left; width: 40%; ">
							<strong>REGO#</strong>:
						</td>
						<td style="float: left; width: 60%; ">
							
						</td>
						<hr>
					</tr>
					<tr>
						<td style="float: left; width: 40%; ">
							<strong>VIN#</strong>:
						</td>
						<td style="float: left; width: 60%; ">
							
						</td>
						<hr>
					</tr>
					<tr>
						<td style="float: left; width: 40%; ">
							<strong>ENGINE#</strong>:
						</td>
						<td style="float: left; width: 60%; ">
							
						</td>
						<hr>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="vehicle_details">
			<div class="green_header_small">
				<strong>Pricing</strong>
			</div>
			<table width="100%" style="font-size: 10px !important;">
				<tbody>
					<tr>
						<td style="float: left; width: 40%; ">
							List Price ex-GST (excluding Rego, Stamp Duty &amp; CTP):
						</td>
						<td style="float: left; width: 60%; ">
							
						</td>
						<hr>
					</tr>
					<tr>
						<td style="float: left; width: 40%; ">
							Options:
						</td>
						<td style="float: left; width: 60%; ">
							
						</td>
						<hr>
					</tr>
					<tr>
						<td style="float: left; width: 40%; ">
							GST:
						</td>
						<td style="float: left; width: 60%; ">
							
						</td>
						<hr>
					</tr>
					<tr>
						<td style="float: left; width: 40%; ">
							Registration:
						</td>
						<td style="float: left; width: 60%; ">
							
						</td>
						<hr>
					</tr>
					<tr>
						<td style="float: left; width: 40%; ">
							CTP:
						</td>
						<td style="float: left; width: 60%; ">
							
						</td>
						<hr>
					</tr>
					<tr>
						<td style="float: left; width: 40%; ">
							Stamp Duty:
						</td>
						<td style="float: left; width: 60%; ">
							
						</td>
						<hr>
					</tr>
					<tr>
						<td style="float: left; width: 40%; ">
							LCT:
						</td>
						<td style="float: left; width: 60%; ">
							
						</td>
						<hr>
					</tr>
					<tr>
						<td style="float: left; width: 40%; ">
							Dealer Delivery Fee:
						</td>
						<td style="float: left; width: 60%; ">
							
						</td>
						<hr>
					</tr>
					<tr>
						<td style="float: left; width: 40%; ">
							Discount:
						</td>
						<td style="float: left; width: 60%; ">
							
						</td>
						<hr>
					</tr>
					<tr>
						<td style="float: left; width: 40%; ">
							Total Vehicle Price:
						</td>
						<td style="float: left; width: 60%; ">
							
						</td>
						<hr>
					</tr>
					<tr>
						<td style="float: left; width: 40%; ">
							Trade-In:
						</td>
						<td style="float: left; width: 60%; ">
							
						</td>
						<hr>
					</tr>
					<tr>
						<td style="float: left; width: 40%; ">
							Payout:
						</td>
						<td style="float: left; width: 60%; ">
							
						</td>
						<hr>
					</tr>
					<tr>
						<td style="float: left; width: 40%; ">
							Deposit:
						</td>
						<td style="float: left; width: 60%; ">
							
						</td>
						<hr>
					</tr>
					<tr>
						<td style="float: left; width: 40%; ">
							Total Payable to Dealer:
						</td>
						<td style="float: left; width: 60%; ">
							
						</td>
						<hr>
					</tr>
				</tbody>
			</table>
			<table width="100%">
				<tbody>
					<tr>
						<td style="float: left; width: 90%; "><strong>Please supply your BANKING DETAILS for Direct Deposit of Funds (BELOW).</strong></td>
					</tr>
					<tr>
						<td style="float: left; width: 40%; "><strong>Account Name:</strong></td>
						<td style="float: left; width: 60%; "><strong>____________________________________________</strong></td>
					</tr>
					<tr>
						<td style="float: left; width: 40%; "><strong>Bank:</strong></td>
						<td style="float: left; width: 60%; "><strong>____________________________________________</strong></td>
					</tr>
					<tr>
						<td style="float: left; width: 40%; "><strong>Account No:</strong></td>
						<td style="float: left; width: 60%; "><strong>____________________________________________</strong></td>
					</tr>
					<tr>
						<td style="float: left; width: 40%; "><strong>BSB:</strong></td>
						<td style="float: left; width: 60%; "><strong>____________________________________________</strong></td>
					</tr>
				</tbody>
			</table>
		</div>
	</body>
</html>
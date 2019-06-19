<?php
// echo "<pre>";
// print_r($master_array['credit_card_arr']); 
// die();
?>

<!DOCTYPE html>
<html>
<head>
	<title>PDF EXPORT</title>
	<style type="text/css">
		body 
		{
		    font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
		    font-size: 14px;
		    line-height: 1.42857143;
		    color: #333;
		    background-color: #fff;
		}
		table 
		{
			border-spacing: 0px;
			border-collapse: collapse;
		}
		th 
		{
			vertical-align: top;
			border: 1px solid #666;
			border-bottom: 0px;
			background: #666;
			color: #fff;
			padding: 3px 5px 3px 5px;
			text-align: left;
		}
		.content td 
		{
			border: 1px solid #666;
			border-top: 1px solid #666;
		}
		.green_header 
		{
			padding: 5px 10px 5px 10px; 
			background: #58C603; 
			color: #fff; 
			font-size: 1.6em;
			margin-top: 18px;
			margin-bottom: 18px;
			text-align: center;
		}
		.green_header_small 
		{
			padding: 5px 10px 5px 10px; 
			background: #58C603; 
			color: #fff; 
			font-size: 1em;
			margin-top: 10px;
			margin-bottom: 10px;
		}
		.green_hr 
		{
			clear: both;
			color: #58C603;
			background-color: #58C603;
			height: 2px;
			border-width: 0;
		}
		.col-4
		{
			float: left; 
			width: 33.05%;
		}
		.col-6
		{
			float: left; 
			width: 49.7%;
		}
		.col-3
		{
			float: left; 
			width: 24.72%;
		}
		.col-8
		{
			float: left; 
			width: 66.2%;
		}
		.col-9
		{
			float: left; 
			width: 75%;
		}
		.col-1
		{
			float: left; 
			width: 8.1%;	
		}
		.row 
		{
			margin-right: -5px;
			margin-left:  -5px;
		    margin-bottom: 5px;
		}
		.text-center
		{
			text-align: center;
		}
		.f-label 
		{
			display: inline-block;
			max-width: 100%;
			margin-bottom: 5px;
			font-weight: 700;
		}
		.green_header_small {
			padding: 5px 10px 5px 10px; 
			background: #58C603; 
			color: #fff; 
			font-size: 1em;
			margin-top: 10px;
			margin-bottom: 10px;
		}
		.green_header_smallest {
			padding: 3px 7px 3px 7px; 
			background: #58C603; 
			color: #fff; 
			font-size: .75em;
			margin-top: 10px;
			margin-bottom: 10px;
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
	<div class="content">
		<div class="green_header">
			<strong>Car Details</strong>
		</div>
		<table width="100%">
			<tbody>
				<tr class="row">
					<td class="col-3">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Car : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['car'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-3">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Year : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['year'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-3">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Make : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['make'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-3">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Model : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['model'] ?></p>
							</div>
						</div>
					</td>
				</tr>
				<tr class="row">
					<td class="col-6">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Variant : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['variant'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-3">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Color : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['color'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-3">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>KMs : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['kms'] ?></p>
							</div>
						</div>
					</td>
				</tr>
				<tr class="row">
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>VIN : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['vin'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Engine : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['engine'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Rego : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['rego'] ?></p>
							</div>
						</div>
					</td>
				</tr>
				<tr class="row">
					<td class="col-3">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Seller : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['seller'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-3">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Dealer : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['dealer'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-3">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Dealer Contact : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['supplier_contact'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-3">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Dealer Email : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['supplier_email'] ?></p>
							</div>
						</div>
					</td>
				</tr>
				<tr class="row">
					<td class="col-3">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Delivery Date : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['delivery_date'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-3">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Car in Stock : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['car_stock'] ?></p>
							</div>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		<div class="green_header">
			<strong>Deal Structure</strong>
		</div>
		<table width="100%">
			<tbody>
				<tr class="row">
					<td class="col-3">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Purchase Price : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['purchase_price'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-3">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Deposit : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['deposit'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-3">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Trade Value : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['trade'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-3">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Payout : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['payout'] ?></p>
							</div>
						</div>
					</td>
				</tr>
				<tr class="row">
					<td class="col-6">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Amount to Finance : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['amt_to_finance'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-3">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Term : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['term'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-3">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Balloon : </p>
							</div>
							<div class="col-4">
								<p><?= $master_array['row']['balloon_amt'] ?></p>
							</div>
							<div class="col-4">
								<p><?= $master_array['row']['balloon_percent'] ?> &nbsp; % </p>
							</div>
						</div>
					</td>
				</tr>
				<tr class="row">
					<td class="col-3">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Lender : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['lender'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-3">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Est Fee : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['est_fee'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-3">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Origination Fee : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['origination_fee'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-3">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>GAP : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['gap'] ?></p>
							</div>
						</div>
					</td>
				</tr>
				<tr class="row">
					<td class="col-3">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>LTI : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['lti'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-3">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Comprehensive : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['comprehensive'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-3">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Base Rate : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['cust_rate'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-3">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Base Rate : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['rate'] ?></p>
							</div>
						</div>
					</td>
				</tr>
				<tr class="row">
					<td class="col-3">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Customer Rate : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['cust_rate'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-3">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Frequency : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['frequency'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-3">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Payments : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['payments'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-3">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Commission : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['commision'] ?></p>
							</div>
						</div>
					</td>
				</tr>
				<tr class="row">
					<td class="col-3">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Total Outgoings : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['total_outgoings'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-3">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Total Expenses : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['total_expenses'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-6">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Surplus Deficit Position : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['surp_def_pos'] ?></p>
							</div>
						</div>
					</td>
				</tr>
				<!-- <tr class="row">
					<td class="col-6">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Net Amount Finance : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['naf'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-6">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Field Commission Inc. GST : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['naf'] ?></p>
							</div>
						</div>
					</td>
				</tr> -->
				<tr class="row">
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Loan Use : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['loan_use'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Customer Type : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['customer_type'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Directors : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['applicant_count'] ?></p>
							</div>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		<?php 
		if($master_array['row']['customer_type'] == "trust")
		{
		?>
		<div class="green_header">
			<strong>Beneficiaries</strong>
		</div>
		
		<?php
			foreach ($master_array['beneficiary_rows'] as $b_key => $b_val) 
			{
				?>
		<table width="100%">
			<tbody>
				<tr class="row">
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Beneficiary Type : </p>
							</div>
							<div class="col-8">
								<p><?= $b_val['b_type'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>First Name : </p>
							</div>
							<div class="col-8">
								<p><?= $b_val['b_first_name'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Last Name : </p>
							</div>
							<div class="col-8">
								<p><?= $b_val['b_last_name'] ?></p>
							</div>
						</div>
					</td>
				</tr>
				<tr class="row">
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Street Address : </p>
							</div>
							<div class="col-8">
								<p><?= $b_val['b_address'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>suburb : </p>
							</div>
							<div class="col-8">
								<p><?= $b_val['b_suburb'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Post Code : </p>
							</div>
							<div class="col-8">
								<p><?= $b_val['b_postcode'] ?></p>
							</div>
						</div>
					</td>
				</tr>
				<tr class="row">
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Mobile Number : </p>
							</div>
							<div class="col-8">
								<p><?= $b_val['b_mobile_number'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Other Number : </p>
							</div>
							<div class="col-8">
								<p><?= $b_val['b_other_number'] ?></p>
							</div>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		<br>
				<?php
			}
		}
		?>
		<pagebreak />
		<?php 
		if($master_array['row']['loan_use'] == "business")
		{
		?>
		<div class="green_header">
			<strong>Business Details</strong>
		</div>
		<table width="100%">
			<tbody>
				<tr class="row">
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Trading Name : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['trading_name'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>ABN : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['abn'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>ABR Name : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['abr_name'] ?></p>
							</div>
						</div>
					</td>
				</tr>
				<tr class="row">
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>ABN Active Since : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['abn_date'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Industry : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['industry'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>GST Registered : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['gst_registered'] ?></p>
							</div>
						</div>
					</td>
				</tr>
				<tr class="row">
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Turnover Gross : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['turnover_gross'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Net Profit : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['net_profit'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Addbacks : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['other_income'] ?></p>
							</div>
						</div>
					</td>
				</tr>
				<tr class="row">
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Business St. Address : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['trade_address'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Suburb : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['trade_suburb'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Postcode : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['trade_post_code'] ?></p>
							</div>
						</div>
					</td>
				</tr>
				<tr class="row">
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Accountant Practice : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['accountant'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Accountant Contact : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['accountant_contact'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Number : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['accountant_number'] ?></p>
							</div>
						</div>
					</td>
				</tr>
				<tr class="row">
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Address : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['accountant_address'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Suburb : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['accountant_suburb'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Postcode : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['accountant_post_code'] ?></p>
							</div>
						</div>
					</td>
				</tr>
				<tr class="row">
					<td class="col-6">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Business Banking Inst. : </p>
							</div>
							<div class="col-8">
								<p><?= $master_array['row']['banking_institution'] ?></p>
							</div>
						</div>
					</td>
				</tr>
			</tbody>
		</table>

		<pagebreak />
		<?php
		}
		?>
		<!-- <div class="green_header">
			<strong>Applicants</strong>
		</div> -->
		<!-- pagebreak here -->
		<?php

		foreach ($master_array['applicant_rows'] as $appl_key => $appl_val) 
		{
		?>
		<div class="green_header">
			<strong>Applicant <?= $appl_key + 1 ?></strong>
		</div>
		<table width="100%">
			<tbody>
				<tr class="row">
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Title : </p>
							</div>
							<div class="col-8">
								<p><?= $appl_val['title'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>First Name : </p>
							</div>
							<div class="col-8">
								<p><?= $appl_val['first_name'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Middle Name : </p>
							</div>
							<div class="col-8">
								<p><?= $appl_val['middle_name'] ?></p>
							</div>
						</div>
					</td>
				</tr>
				<tr class="row">
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Last Name : </p>
							</div>
							<div class="col-8">
								<p><?= $appl_val['last_name'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Date of Birth : </p>
							</div>
							<div class="col-8">
								<p><?= $appl_val['date_of_birth'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>DL Number : </p>
							</div>
							<div class="col-8">
								<p><?= $appl_val['dl_number'] ?></p>
							</div>
						</div>
					</td>
				</tr>
				<tr class="row">
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>DL Expiry : </p>
							</div>
							<div class="col-8">
								<p><?= $appl_val['dl_exp'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>DL State : </p>
							</div>
							<div class="col-8">
								<p><?= $appl_val['dl_state'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>DL Type : </p>
							</div>
							<div class="col-8">
								<p><?= $appl_val['dl_type'] ?></p>
							</div>
						</div>
					</td>
				</tr>
				<tr class="row">
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Marital Status : </p>
							</div>
							<div class="col-8">
								<p><?= $appl_val['marital_stat'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Dependents : </p>
							</div>
							<div class="col-8">
								<p><?= $appl_val['dependents'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Ages : </p>
							</div>
							<div class="col-8">
								<p><?= $appl_val['ages'] ?></p>
							</div>
						</div>
					</td>
				</tr>
				<tr class="row">
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Citizenship : </p>
							</div>
							<div class="col-8">
								<p><?= $appl_val['citizen_stat'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Visa Type : </p>
							</div>
							<div class="col-8">
								<p><?= $appl_val['visa_type'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Visa Exp Date : </p>
							</div>
							<div class="col-8">
								<p><?= $appl_val['visa_exp_date'] ?></p>
							</div>
						</div>
					</td>
				</tr>
				<tr class="row">
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Email : </p>
							</div>
							<div class="col-8">
								<p><?= $appl_val['email'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Primary Number : </p>
							</div>
							<div class="col-8">
								<p><?= $appl_val['mobile'] ?></p>
							</div>
						</div>
					</td>
					<td class="col-4">
						<div class="row">
							<div class="col-4 f-label text-center">
								<p>Secondary Number : </p>
							</div>
							<div class="col-8">
								<p><?= $appl_val['other_telephone'] ?></p>
							</div>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
			<?php
				foreach ($master_array['address_arr'][$appl_key] as $add_key => $addr_val) 
				{
			?>
				<div class="green_header_small">
					<strong>Address <?= $add_key + 1 ?></strong>
				</div>
				<table width="100%">
					<tbody>
						<tr class="row">
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Unit : </p>
									</div>
									<div class="col-8">
										<p><?= $addr_val['client_unit'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Street Address : </p>
									</div>
									<div class="col-8">
										<p><?= $addr_val['client_address'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Suburb : </p>
									</div>
									<div class="col-8">
										<p><?= $addr_val['client_suburb'] ?></p>
									</div>
								</div>
							</td>
						</tr>
						<tr class="row">
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Post Code : </p>
									</div>
									<div class="col-8">
										<p><?= $addr_val['client_suburb'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Residential Status : </p>
									</div>
									<div class="col-8">
										<p><?= $addr_val['client_res_stat'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Time at Address : </p>
									</div>
									<div class="col-8">
										<p><?= $addr_val['time_address_years'] ?> year(s) and <?= $addr_val['time_address_months'] ?> months</p>
									</div>
								</div>
							</td>
						</tr>
						<?php
						if($addr_val['client_res_stat'] == 'ownder' || $addr_val['client_res_stat'] == 'mortgage')
						{
						?>
							<tr class="row">
								<td class="col-4">
									<div class="row">
										<div class="col-4 f-label text-center">
											<p>Name on Title : </p>
										</div>
										<div class="col-8">
											<p><?= $addr_val['name_on_title'] ?></p>
										</div>
									</div>
								</td>
							</tr>
						<?php 
						}
						?>
						<?php 
						if($addr_val['client_res_stat'] == "renting"){
						?>
						<tr class="row">
							<td class="col-6">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Landlord / Realestate Agent : </p>
									</div>
									<div class="col-8">
										<p><?= $addr_val['landlord_realestate_name'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-6">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Landlord / Realestate Contact : </p>
									</div>
									<div class="col-8">
										<p><?= $addr_val['landlord_realestate_contact'] ?></p>
									</div>
								</div>
							</td>
						</tr>
						<tr class="row">
							<td class="col-6">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Landlord / Realestate Number : </p>
									</div>
									<div class="col-8">
										<p><?= $addr_val['landlord_realestate_number'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-6">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Monthly Commitment : </p>
									</div>
									<div class="col-8">
										<p><?= $addr_val['monthly_commitment'] ?></p>
									</div>
								</div>
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
			<?php
			if($master_array['row']['loan_use'] != "business")
			{
				foreach ($master_array['employee_arr'][$appl_key] as $emp_key => $emp_val) 
				{
			?>
				<div class="green_header_small">
					<strong>Employer <?= $emp_key + 1 ?></strong>
				</div>
				<table width="100%">
					<tbody>
						<tr class="row">
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Company Name : </p>
									</div>
									<div class="col-8">
										<p><?= $emp_val['employer_name'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Employment Status : </p>
									</div>
									<div class="col-8">
										<p><?= $emp_val['employment_status'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Position : </p>
									</div>
									<div class="col-8">
										<p><?= $emp_val['occ_position'] ?></p>
									</div>
								</div>
							</td>
						</tr>
						<tr class="row">
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Unit : </p>
									</div>
									<div class="col-8">
										<p><?= $emp_val['emp_unit'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Street Address : </p>
									</div>
									<div class="col-8">
										<p><?= $emp_val['emp_address'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Suburb : </p>
									</div>
									<div class="col-8">
										<p><?= $emp_val['emp_suburb'] ?></p>
									</div>
								</div>
							</td>
						</tr>
						<tr class="row">
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Postcode : </p>
									</div>
									<div class="col-8">
										<p><?= $emp_val['emp_post'] ?></p>
									</div>
								</div>
							</td>
						</tr>
						<tr class="row">
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Contact Person : </p>
									</div>
									<div class="col-8">
										<p><?= $emp_val['contact_person'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Contact Number : </p>
									</div>
									<div class="col-8">
										<p><?= $emp_val['contact_number'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Time with Employer : </p>
									</div>
									<div class="col-8">
										<p><p><?= $emp_val['time_employer_years'] ?> year(s) and <?= $emp_val['time_employer_month'] ?> months</p></p>
									</div>
								</div>
							</td>
						</tr>
						<tr class="row">
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Net Monthly Income : </p>
									</div>
									<div class="col-8">
										<p><?= $emp_val['net_income'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Salary Package Ded. : </p>
									</div>
									<div class="col-8">
										<p><?= $emp_val['sal_pax_ded'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Industry : </p>
									</div>
									<div class="col-8">
										<p><?= $emp_val['industry'] ?></p>
									</div>
								</div>
							</td>
						</tr>
						<tr class="row">
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Employer ABN : </p>
									</div>
									<div class="col-8">
										<p><?= $emp_val['emp_abn'] ?></p>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
				<?php
					foreach ($master_array['other_inc_array'][$appl_key][$emp_key] as $other_inc_key => $other_inc_val) 
					{
				?>
						<div class="green_header_smallest">
							<strong>Other Income <?= $other_inc_key + 1 ?> for Employer <?= $emp_key + 1 ?> </strong>
						</div>
						<table width="100%">
							<tbody>
								<tr class="row">
									<td class="col-4">
										<div class="row">
											<div class="col-4 f-label text-center">
												<p>Other Income : </p>
											</div>
											<div class="col-8">
												<p><?= $other_inc_val['other_income_name'] ?></p>
											</div>
										</div>
									</td>
									<td class="col-4">
										<div class="row">
											<div class="col-4 f-label text-center">
												<p>Details : </p>
											</div>
											<div class="col-8">
												<p><?= $other_inc_val['other_income_details'] ?></p>
											</div>
										</div>
									</td>
									<td class="col-4">
										<div class="row">
											<div class="col-4 f-label text-center">
												<p>Amount : </p>
											</div>
											<div class="col-8">
												<p><?= $other_inc_val['other_income_amount'] ?></p>
											</div>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
				<?php
					}
				?>
			<?php
				}
			}
			?>
			<!-- pagebreak here -->
			<br>
			<?php
				foreach ($master_array['liabilities_arr'][$appl_key] as $liab_key => $liab_val) 
				{
			?>
				<div class="green_header_small">
					<strong>Property <?= $liab_key + 1 ?></strong>
				</div>
				<table width="100%">
					<tbody>
						<tr class="row">
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Unit : </p>
									</div>
									<div class="col-8">
										<p><?= $liab_val['property_unit'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Street Address : </p>
									</div>
									<div class="col-8">
										<p><?= $liab_val['property_address'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Suburb : </p>
									</div>
									<div class="col-8">
										<p><?= $liab_val['property_suburb'] ?></p>
									</div>
								</div>
							</td>
						</tr>
						<tr class="row">
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Postcode : </p>
									</div>
									<div class="col-8">
										<p><?= $liab_val['property_postcode'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Mortgage Inst. : </p>
									</div>
									<div class="col-8">
										<p><?= $liab_val['mortgage_with'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Min Monthly Payment. : </p>
									</div>
									<div class="col-8">
										<p><?= $liab_val['mortgage_commitment'] ?></p>
									</div>
								</div>
							</td>
						</tr>
						<tr class="row">
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Min Monthly Payment : </p>
									</div>
									<div class="col-8">
										<p><?= $liab_val['balance'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Property Value : </p>
									</div>
									<div class="col-8">
										<p><?= $liab_val['property_value'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Rental Income : </p>
									</div>
									<div class="col-8">
										<p><?= $liab_val['monthly_rental_income'] ?></p>
									</div>
								</div>
							</td>
						</tr>
						<tr class="row">
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Managed : </p>
									</div>
									<div class="col-8">
										<p><?= $liab_val['managed'] ?></p>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			<?php
				}
			?>
			<br>
			<?php
				foreach($master_array['credit_card_arr'][$appl_key] as $cred_key => $cred_val)
				{
			?>
				<div class="green_header_small">
					<strong>Credit Card <?= $cred_key + 1 ?></strong>
				</div>
				<table width="100%">
					<tbody>
						<tr class="row">
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Credit Card Name : </p>
									</div>
									<div class="col-8">
										<p><?= $cred_val['credit_card_name'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Limit : </p>
									</div>
									<div class="col-8">
										<p><?= $cred_val['credit_card_limit'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Credit Card Balance : </p>
									</div>
									<div class="col-8">
										<p><?= $cred_val['credit_card_balance'] ?></p>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			<?php
				}
			?>
			<?php
				foreach($master_array['other_loans_arr'][$appl_key] as $o_loans_key => $o_loans_val)
				{
			?>
				<div class="green_header_small">
					<strong>Other Loans <?= $o_loans_key + 1 ?></strong>
				</div>
				<table width="100%">
					<tbody>
						<tr class="row">
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Lending Institution : </p>
									</div>
									<div class="col-8">
										<p><?= $o_loans_val['lending_institution'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Purpose : </p>
									</div>
									<div class="col-8">
										<p><?= $o_loans_val['purpose'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Amt. Borrowed : </p>
									</div>
									<div class="col-8">
										<p><?= $o_loans_val['amount_borrowed'] ?></p>
									</div>
								</div>
							</td>
						</tr>
						<tr class="row">
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Term : </p>
									</div>
									<div class="col-8">
										<p><?= $o_loans_val['o_term'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Start Date : </p>
									</div>
									<div class="col-8">
										<p><?= $o_loans_val['loan_start_date'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Balloon : </p>
									</div>
									<div class="col-4">
										<p><?= $o_loans_val['o_balloon_amt'] ?></p>
									</div>
									<div class="col-4">
										<p><?= $o_loans_val['o_balloon_percentage'] ?>% </p>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			<?php
				}
			?>
			<?php
				foreach($master_array['reference_arr'][$appl_key] as $ref_key => $ref_val)
				{
			?>
				<div class="green_header_small">
					<strong>Reference <?= $ref_key + 1 ?></strong>
				</div>
				<table width="100%">
					<tbody>
						<tr class="row">
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>First Name : </p>
									</div>
									<div class="col-8">
										<p><?= $ref_val['r_first_name'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Last Name : </p>
									</div>
									<div class="col-8">
										<p><?= $ref_val['r_last_name'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Telephone : </p>
									</div>
									<div class="col-8">
										<p><?= $ref_val['r_telephone'] ?></p>
									</div>
								</div>
							</td>
						</tr>
						<tr class="row">
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Unit : </p>
									</div>
									<div class="col-8">
										<p><?= $ref_val['r_unit'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Street Address : </p>
									</div>
									<div class="col-8">
										<p><?= $ref_val['r_address'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Suburb : </p>
									</div>
									<div class="col-8">
										<p><?= $ref_val['r_suburb'] ?></p>
									</div>
								</div>
							</td>
						</tr>
						<tr class="row">
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Postcode : </p>
									</div>
									<div class="col-8">
										<p><?= $ref_val['r_postcode'] ?></p>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			<?php
				}
			?>
			<?php 
			if($master_array['row']['loan_use'] != "business")
			{
			?>
				<div class="green_header_small">
					<strong>Living Costs</strong>
				</div>
				<table width="100%">
					<tbody>
						<tr class="row">
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Monthly Food Cost : </p>
									</div>
									<div class="col-8">
										<p><?= $appl_val['food_beverage'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Elec, Water, Gas : </p>
									</div>
									<div class="col-8">
										<p><?= $appl_val['power_gas'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Health Medical : </p>
									</div>
									<div class="col-8">
										<p><?= $appl_val['medical'] ?></p>
									</div>
								</div>
							</td>
						</tr>
						<tr class="row">
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Insurance Prem. : </p>
									</div>
									<div class="col-8">
										<p><?= $appl_val['insurance'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Transportation Fuel : </p>
									</div>
									<div class="col-8">
										<p><?= $appl_val['transportation_fuel'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Communications : </p>
									</div>
									<div class="col-8">
										<p><?= $appl_val['communications'] ?></p>
									</div>
								</div>
							</td>
						</tr>
						<tr class="row">
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Recreation : </p>
									</div>
									<div class="col-8">
										<p><?= $appl_val['recreation'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-4">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Total Living Cost : </p>
									</div>
									<div class="col-8">
										<p><?= $appl_val['tot_living_cost'] ?></p>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			<?php
			}
			?>
			<div class="green_header_small">
				<strong>Assets</strong>
			</div>
			<table width="100%">
				<tbody>
					<tr class="row">
						<td class="col-4">
							<div class="row">
								<div class="col-4 f-label text-center">
									<p>Total Property Value : </p>
								</div>
								<div class="col-8">
									<p><?= $appl_val['total_property_value'] ?></p>
								</div>
							</div>
						</td>
						<td class="col-4">
							<div class="row">
								<div class="col-4 f-label text-center">
									<p>Cash Savings : </p>
								</div>
								<div class="col-8">
									<p><?= $appl_val['cash_savings'] ?></p>
								</div>
							</div>
						</td>
						<td class="col-4">
							<div class="row">
								<div class="col-4 f-label text-center">
									<p>Personal Effects : </p>
								</div>
								<div class="col-8">
									<p><?= $appl_val['personal_effects'] ?></p>
								</div>
							</div>
						</td>
					</tr>
					<tr class="row">
						<td class="col-4">
							<div class="row">
								<div class="col-4 f-label text-center">
									<p>Superannuation : </p>
								</div>
								<div class="col-8">
									<p><?= $appl_val['superannuation'] ?></p>
								</div>
							</div>
						</td>
						<td class="col-4">
							<div class="row">
								<div class="col-4 f-label text-center">
									<p>Shares &amp; Investments : </p>
								</div>
								<div class="col-8">
									<p><?= $appl_val['shares_investments'] ?></p>
								</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<?php
				foreach($master_array['other_asset_arr'][$appl_key] as $o_asset_key => $o_asset_val)
				{
			?>
				<div class="green_header_small">
					<strong>Other Asset <?= $o_asset_key + 1 ?></strong>
				</div>
				<table width="100%">
					<tbody>
						<tr class="row">
							<td class="col-6">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Asset Description : </p>
									</div>
									<div class="col-8">
										<p><?= $o_asset_val['other_asset_name'] ?></p>
									</div>
								</div>
							</td>
							<td class="col-6">
								<div class="row">
									<div class="col-4 f-label text-center">
										<p>Asset Value : </p>
									</div>
									<div class="col-8">
										<p><?= $o_asset_val['other_asset_value'] ?></p>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			<?php
				}
			?>

			<?php

				$statement_label = [];

				$state_type_1 = [
				'Have you ever been registered with any Credit Reporting Agency as having a Credit Default or Court Judgement registered against you?',
				'If Yes, have the related debts been paid in full?',
				'Have you ever been declared Bankrupt or entered into any Part 9 / Debt Agreement?',
				'If Yes, have you since been discharged?'
				];

				$state_type_2 = [
				'Have you ever been declared bankrupt or insolvent, or has your estate been assigned for the benefit of creditors?',
				'Have you ever been shareholders or officer of any company of which a manager, receiver or liquidator has been appointed?',
				'Is there any unsatisfied court judgement entered against you or any company of which you are/were a shareholder or officer?',
				'Have you ever been registered with any Credit Reporting Agencies as in default?',
				'Are you the director or shareholder of any other companies? If yes, details:'
				];

				if($master_array['row']['customer_type'] == "sole_trader" || $master_array['row']['customer_type'] == "joint" || $master_array['row']['customer_type'] == "individual")
				{
					$statement_label = $state_type_1;
				}
				else
				{
					$statement_label = $state_type_2;
				}

			?>
			<div class="green_header_small">
				<strong>Borrower's Statement</strong>
			</div>
			<table width="100%">
				<tbody>
					
						
					<?php 
						foreach ($statement_label as $stat_key => $stat_val) 
						{
					?>
					<tr>
						<td class="col-12">
							<div>
								<div class="col-8 f-label" style="text-align: left">
									<p><?= $stat_val ?> : </p>
								</div>
								<div class="col-4">
									<p><?= $appl_val['statement_' . (string)($stat_key + 1)] ?></p>
								</div>
							</div>
						</td>
					</tr>
					<?php
						}
					?>
					
				</tbody>
			</table>
		<pagebreak />
		<?php
		}
		?>

	</div>
</body>
</html>



<style type="text/css">

/*floating menu start*/
.side_bar_buttons_container{
	right: 0px;
    top: 50px;
    position: fixed;
    z-index: 2147483647;
}

.side_bar_button{
	height: 50px;
	width: 40px;
	background-color: #000;
    opacity: .80;
    border-radius: 8px 0px 0px 8px;
    padding: 10px;
    color: #fff;
    cursor: pointer; 
	cursor: hand;
	display: inline-block;
    font-size: 30px;
    vertical-align:top;
    margin-bottom: 3px;
}
/*floating menu ends*/

.no-value{
	border: 1px solid #a94442;
}
.f-label {
	display: inline-block;
	max-width: 100%;
	margin-bottom: 5px;
	font-weight: 700;
}

.dealer-label{
	display: inline-block;
	max-width: 100%;
	margin-bottom: 5px;
	font-weight: 700;
	cursor: pointer;
	cursor: hand;
}

.panel-app-inputs{
	margin-top: 10px;
}
.row-input{
	margin-bottom: 10px;
}
.panel-body{
	box-shadow: 0 1px 2px rgba(0, 0, 0, 0.4);
	padding-bottom: 0px;
}
.panel-heading{
	box-shadow: 0 0px 2px rgba(0, 0, 0, 0.4);
	padding-top: 7px;
	padding-bottom: 5px;
}
.panel-title-fapplication{
	color: #33353f;
    font-size: 15px;
    font-weight: 700;
    padding: 0;
    text-transform: none;
}
.panel-title-3rd-dim{
	color: #33353f;
    font-size: 15px;
    font-weight: 700;
    padding: 0;
    text-transform: none;	
}

.requirements { 
	cursor: pointer; 
	cursor: hand;
	padding-top: 6px;
}
.requirements-temp { 
	cursor: pointer; 
	cursor: hand;
	padding-top: 6px;
}
.requirements-tempo{
	cursor: pointer; 
	cursor: hand;
	padding-top: 6px;
}
.requirements-temp2{
	cursor: pointer; 
	cursor: hand;
	padding-top: 6px;
}
.temp_dzone{
	cursor: pointer; 
	cursor: hand;
	padding-top: 6px;	
}
.requirements_green {
	background-color: #b2ffb2;
}
.del_file{
	cursor: pointer; 
	cursor: hand;
}
.del_all_req{
	cursor: pointer; 
	cursor: hand;
}
.all_req_button{
	cursor: pointer; 
	cursor: hand;
}
.all_req_row{
	margin-bottom: 10px;
}
.req_button{
	font-size: 20px;
	cursor: pointer; 
	cursor: hand;
}
.lead_email_send{
	color: #0088cc;
	cursor: pointer; 
	cursor: hand;
}
.del_req{
	font-size: 23px;
	cursor: pointer; 
	cursor: hand;
}
.pop_init{
	cursor: pointer; 
	cursor: hand;
}
.pop_sett{
	cursor: pointer;
	cursor: hand;
}
.f-label{
	cursor: pointer;
	cursor: hand;
}
.pac-container {
        z-index: 10000000000000000000000000000 !important;
    }
.tooltip{
  z-index: 1000000000000000000000 !important;
}
</style>
<div id="fapplication-modal-3" class="modal fade">
	<?php include 'fa_sidenote.php'; ?>
	<?php include 'floating_menu.php'; ?>
	<?php include 'fa_req_list_modal.php'; ?>
	<div class="modal-dialog" style="width: 95%;">
		<div class="panel-body">
			<div class="modal-wrapper">
				<div class="modal-text">
					<form method="post" action="" id="fapplication_main_form" name="fapplication_main_form">
						<input type="hidden" id="fapplication_status_id" name="fapplication_status" value="" />
						<input type="hidden" id="fqa_number" value="" />
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
								<thead>
									<tr>
										<td><i class="fa fa-file-pdf-o" data-toggle="tooltip" data-placement="top" title="Order PDF"></i></td>
										<td><b>FQ Number</b></td>
										<td><b>Source</b></td>
										<td><b>CQ Staff</b></td>
										<td><b>FQ Staff</b></td>
										<td><b>Client Name</b></td>
										<td><b>Email</b></td>
										<td><b>Phone</b></td>
										<td><b>Mobile</b></td>
										<td><b>State</b></td>
										<td><b>Make</b></td>
										<td><b>Model</b></td>
										<td><b>Date/Time</b></td>
									</tr>
								</thead>
								<tbody id="fapplication_summary"></tbody>
							</table>
						</div>
						<!-- <hr>
						<div class="row">
							<div class="col-md-3 pull-left">
								<div class='input-group'>
									<input type="text" name="diarize_date" id="diarize_date" class="form-control input-md input-group-addon diarize_date" placeholder="Choose date...">
									<span class='input-group-addon' style='width:0px; padding-left:0px; padding-right:0px; border:none;'></span>
									<span class='input-group-addon btn btn-primary btn-md diarize' id="diarize">Diarize</span>
								</div>
							</div>
						</div> -->
						<hr>
						<div class="toogle" data-plugin-toggle="">
							<section class="toggle">
								<label>REQUIREMENTS</label>
								<div class="toggle-content">
									<div class="row row-input all_req_row">
										<input type="hidden" value="" id="all_req_hidden_val">
										<div class="col-md-offset-6 col-md-6">
													<select id="new_req_temp_storage" class="" hidden>
															
													</select>
											<div class="row">
												
											</div>
										</div>
									</div>
									<div class="requirements_section">
										<input type="hidden" value="" id="req_hidden_val">
										<input type="hidden" value="" id="is_temp_hidden">
										<div class="req_sec_panel">
										</div>
										<!-- <div class="req_sett_panel">
										</div> -->
									</div>
								</div>
							</section>
						</div>
						<div class="toogle" data-plugin-toggle="">
							<section class="toggle active" id="application_section">
								<label>APPLICATION FIELDS</label>
								<div class="toggle-content" style="display: block;">
									<hr>
									<div class="car_details">
										<h3>CAR DETAILS</h3>
										<br>
										<div class="row row-input">
											<div class="col-md-4">
												
													<div class="row">
														<div class="col-md-4">
															<label for="car" class="f-label">Car</label>
															
														</div>
														<div class="col-md-8">	
															<select name="car" id="car" class="form-control input-sm">
																<option>New</option>
																<option>Near New</option>
																<option>Demo</option>
																<option>Used</option>
															</select>
														</div>
													</div>
												
											</div>
											<div class="col-md-4">
												
												<div class="row">
														<div class="col-md-4">
															<label for="year" class="f-label">Year</label>
														</div>
														<div class="col-md-8">
															<select name="year" id="year" class="form-control input-sm">
															<?php
																$curr_year = date('Y');
																for ($i=0; $i < 46; $i++) 
																{
																	$year_now = (int)$curr_year - $i;
																	echo "<option val='{$year_now}'>{$year_now}</option>";
																}
															?>
															</select>
														</div>
												</div>
											</div>
											<div class="col-md-4" id="makes_row">
												<div class="row">
													<div class="col-md-4">
														<label for="make" class="f-label">Make</label>
													</div>
													<div class="col-md-8">
														<select name="make" id="make" class="form-control input-sm">
															<option>Chery</option>
															<option>Chevrolet</option>
															<option>Daewoo</option>
															<option>Dodge</option>
														</select>
													</div>
												</div>
											</div>
										</div>
										
										<!-- second row -->
										<div class="row row-input">
											<div class="col-md-4" id="model_row">
												
													<div class="row">
														<div class="col-md-4">
															<label for="model" class="f-label">Model</label>
															
														</div>
														<div class="col-md-8">	
															<select name="model" id="model" class="form-control input-sm">
																
															</select>
														</div>
													</div>
												
											</div>
											
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="color" class="f-label">Color</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="color" class="form-control input-sm" id="color">
													</div>
												</div>
											</div>
											<div class="col-md-4">
												
												<div class="row">
														<div class="col-md-4">
															<label for="kms" class="f-label">KMs</label>
														</div>
														<div class="col-md-8">
															<input type="text" class="form-control input-sm" name="kms" id="kms" onkeypress="return isNumberKey(event)">
														</div>
												</div>
											</div>
										</div>
										
										<!-- third row -->
										<div class="row row-input">
											<div class="col-md-8" id="variant_row">
												
												<div class="row">
													<div class="col-md-2">
														<label for="variant" class="f-label">Variant</label>
													</div>
													<div class="col-md-10">
														<select name="variant" id="variant" class="form-control input-sm">
														
														</select>
													</div>
												</div>
												
											</div>
											<!-- <div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="options" class="f-label">Options</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="options" id="options" class="form-control input-sm">
													</div>
												</div>
											</div> -->
										</div>

										<div class="row row-input">
											<div class="col-md-4">
												
												<div class="row">
													<div class="col-md-4">
														<label for="vin" class="f-label">VIN Number</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="vin" class="form-control input-sm" id="fq_vin">
													</div>
												</div>
												
											</div>
											<div class="col-md-4">
												
												<div class="row">
													<div class="col-md-4">
														<label for="engine" class="f-label">Engine Number</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="engine" class="form-control input-sm" id="fq_engine">
													</div>
												</div>
												
											</div>
											<div class="col-md-4">
												
												<div class="row">
													<div class="col-md-4">
														<label for="rego" class="f-label">Rego Number</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="rego" class="form-control input-sm" id="fq_rego">
													</div>
												</div>
												
											</div>
										</div>
										
										<div class="row row-input" hidden>
											<div class="col-md-12">
												
													<div class="row">
														<div class="col-md-12">	
															<textarea name="further_details" id="further_details" class="form-control input-sm" rows="1" cols="50" placeholder="Further Details..."></textarea>
														</div>
													</div>
												
											</div>
											
										</div>
									</div>
									<!-- <hr> -->
									<div class="supplier_details">
										<!-- <h3>SUPPLIER DETAILS</h3>
										<br> -->
										<div class="row row-input">
											<div class="col-md-4">
												
												<div class="row">
													<div class="col-md-4">
														<label for="seller" class="f-label">Seller</label>
														
													</div>
													<div class="col-md-8">	
														<select name="seller" class="form-control input-sm" id="seller">
															<option value="PRIVATE">PRIVATE</option>
															<option value="FRANCHISED DEALER">FRANCHISED DEALER</option>
															<option value="OTHER DEALER">OTHER DEALER</option>
															<option value="SALE">SALE</option>
															<option value="LEASE BACK">LEASE BACK</option>
															<option value="CQO">CQO</option>
														</select>
													</div>
												</div>
												
											</div>
											<div class="col-md-4" id="dealers_name_dom">
												
												<div class="row">
													<div class="col-md-4">
														<label for="dealer" class="dealer-label">Dealer</label>
														
													</div>
													<div class="col-md-8">	
														<select name="dealer" class="form-control input-sm dealer" id="dealer">
															
														</select>
													</div>
												</div>
												
											</div>
											<div class="col-md-4">
												
												<div class="row">
													<div class="col-md-4">
														<label for="supplier_contact" class="f-label">Dealer Contact</label>
														
													</div>
													<div class="col-md-8">	
														<input type="text" name="supplier_contact" class="form-control input-sm" id="supplier_contact">
													</div>
												</div>
												
											</div>
										</div>
										<div class="row row-input">
											<div class="col-md-4">
												
												<div class="row">
													<div class="col-md-4">
														<label for="supplier_email" class="f-label">Dealer Email</label>
														
													</div>
													<div class="col-md-8">	
														<input type="text" name="supplier_email" class="form-control input-sm" id="supplier_email">
													</div>
												</div>
												
											</div>
											<div class="col-md-4">
												
												<div class="row">
													<div class="col-md-4">
														<label for="supplier_mobile" class="f-label">Dealer Mobile</label>
														
													</div>
													<div class="col-md-8">	
														<input type="text" name="supplier_mobile" class="form-control input-sm masked" id="supplier_mobile">
													</div>
												</div>
												
											</div>
											<div class="col-md-4">
												
												<div class="row">
													<div class="col-md-4">
														<label for="supplier_landline" class="f-label">Dealer Landline</label>
														
													</div>
													<div class="col-md-8">	
														<input type="text" name="supplier_landline" class="form-control input-sm masked" id="supplier_landline">
													</div>
												</div>
												
											</div>
										</div>
										<div class="row row-input">
											<div class="col-md-4">
												
												<div class="row">
													<div class="col-md-4">
														<label for="delivery_date" class="f-label">Delivery Date</label>
														
													</div>
													<div class="col-md-8">	
														<input type="text" name="delivery_date" class="form-control input-sm" id="date_delivered">
													</div>
												</div>
												
											</div>
											<div class="col-md-4">
												
												<div class="row">
													<div class="col-md-4">
														<label for="car_stock" class="f-label">Car in Stock</label>
														
													</div>
													<div class="col-md-8">	
														<select name="car_stock" class="form-control input-sm" id="car_stock">
															<option value="yes">YES</option>
															<option value="no">NO</option>
														</select>
													</div>
												</div>
												
											</div>
											<!-- <div class="col-md-4">
												
												<div class="row">
													<div class="col-md-4">
														<label for="car_arrival" class="f-label">Car Arrival</label>
														
													</div>
													<div class="col-md-8">	
														<input type="text" name="car_arrival" class="form-control input-sm" id="car_arrival">
													</div>
												</div>
												
											</div> -->
										</div>
										<div class="row row-input">
											<div class="col-md-12">
												
													<div class="row">
														<div class="col-md-12">	
															<textarea name="further_details_supplies" id="further_details_supplies" class="form-control input-sm" rows="1" cols="50" placeholder="Further Details..."></textarea>
														</div>
													</div>
												
											</div>
											
										</div>
									</div>
									<hr>
									<div class="deal_structure">
										<h3>DEAL STRUCTURE</h3>
										<br>
										<div class="row row-input">
											<div class="col-md-4">
												
												<div class="row">
													<div class="col-md-4">
														<label for="purchase_price" class="f-label">Purchase Price</label>
														
													</div>
													<div class="col-md-8">	
														<input type="text" name="purchase_price" class="form-control input-sm" id="purchase_price" onkeypress="return isNumberKey(event)" value="0.00">
													</div>
												</div>
												
											</div>
											<div class="col-md-4">
												
												<div class="row">
													<div class="col-md-4">
														<label for="deposit" class="f-label">Deposit</label>
														
													</div>
													<div class="col-md-8">	
														<input type="text" name="deposit" class="form-control input-sm" id="deposit" onkeypress="return isNumberKey(event)" value="0.00">
													</div>
												</div>
												
											</div>
											<div class="col-md-4">
												
												<div class="row">
													<div class="col-md-4">
														<label for="trade" class="f-label">Trade Value</label>
														
													</div>
													<div class="col-md-8">	
														<input type="text" name="trade" class="form-control input-sm" id="trade" onkeypress="return isNumberKey(event)" value="0.00">
													</div>
												</div>
												
											</div>
										</div>
										<div class="row row-input">
											<div class="col-md-4">
												
												<div class="row">
													<div class="col-md-4">
														<label for="payout" class="f-label">Payout</label>
														
													</div>
													<div class="col-md-8">	
														<input type="text" name="payout" class="form-control input-sm" id="payout" onkeypress="return isNumberKey(event)" value="0.00">
													</div>
												</div>
												
											</div>
										
											<div class="col-md-4">
												
												<div class="row">
													<div class="col-md-4">
														<label for="amt_to_finance" class="f-label">Amount to Finance</label>
														
													</div>
													<div class="col-md-8">	
														<input type="text" name="amt_to_finance" class="form-control input-sm" id="amt_to_finance" onkeypress="return isNumberKey(event)" value="0.00">
													</div>
												</div>
												
											</div>
										
											<div class="col-md-4">
												
												<div class="row">
													<div class="col-md-4">
														<label for="term" class="f-label">Term</label>
														
													</div>
													<div class="col-md-8">	
														<input type="text" name="term" class="form-control input-sm" id="term" onkeypress="return isNumberKey(event)">
													</div>
												</div>
												
											</div>
										</div>
										<div class="row row-input">
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label class="f-label">Balloon</label>
													</div>
													<div class="col-md-4">
														<input type="text" name="balloon_amt" id="balloon_amt" class="form-control input-sm" placeholder="$" onkeypress="return isNumberKey(event)">
													</div>
													<div class="col-md-4">
														<input type="text" name="balloon_percentage" id="balloon_percentage" class="form-control input-sm" placeholder="%" onkeypress="return isNumberKey(event)">
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="lender" class="f-label">Lender</label>
													</div>
													<div class="col-md-8">
														<select name="lender" id="lender" class="form-control input-sm">
															<option value="Esanda">Esanda</option>
															<option value="St. george">St. George</option>
															<option value="MacQuarie">Macquarie</option>
															<option value="Pepper">Pepper</option>
														</select>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="est_fee" class="f-label">Est Fee ($)</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="est_fee" id="est_fee" class="form-control input-sm" onkeypress="return isNumberKey(event)">
													</div>
												</div>
											</div>
										</div>
										<div class="row row-input">
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="origination_fee" class="f-label">Origination Fee</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="origination_fee" id="origination_fee" class="form-control input-sm" onkeypress="return isNumberKey(event)">
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="gap" class="f-label">GAP</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="gap" id="gap" class="form-control input-sm" onkeypress="return isNumberKey(event)">
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="lti" class="f-label">LTI</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="lti" id="lti" class="form-control input-sm" onkeypress="return isNumberKey(event)">
													</div>
												</div>
											</div>
										</div>
										<div class="row row-input">
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="comprehensive" class="f-label">Comprehensive</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="comprehensive" id="comprehensive" class="form-control input-sm">
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="rate" class="f-label">Base Rate</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="rate" id="rate" class="form-control input-sm" placeholder="%" onkeypress="return isNumberKey(event)">
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="cust_rate" class="f-label">Customer Rate</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="cust_rate" id="cust_rate" class="form-control input-sm" placeholder="%" onkeypress="return isNumberKey(event)">
													</div>
												</div>
											</div>
										</div>
										<div class="row row-input">
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="frequency" class="f-label">Frequency</label>
													</div>
													<div class="col-md-8">
														<select name="frequency" id="frequency" class="form-control input-sm">
															<option value="weekly">Weekly</option>
															<option value="fortnightly">Fortnightly</option>
															<option value="monthly">Monthly</option>
														</select>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="payments" class="f-label">Payments($)</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="payments" id="payments" class="form-control input-sm" onkeypress="return isNumberKey(event)">
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="commision" class="f-label">Commision ($)</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="commision" id="commision" class="form-control input-sm" onkeypress="return isNumberKey(event)">
													</div>
												</div>
											</div>
										</div>
										<div class="row row-input">
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="total_outgoings" class="f-label">Total Outgoings</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="total_outgoings" id="total_outgoings" class="form-control input-sm" onkeypress="return isNumberKey(event)">
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="total_expenses" class="f-label">Total Expenses</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="total_expenses" id="total_expenses" class="form-control input-sm" onkeypress="return isNumberKey(event)">
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="surp_def_pos" class="f-label">Surplus/Deficit Position</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="surp_def_pos" id="surp_def_pos" class="form-control input-sm" onkeypress="return isNumberKey(event)">
													</div>
												</div>
											</div>
										</div>
										<div class="row row-input">
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="naf" class="f-label">Net Amount Finance</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="naf" id="naf" class="form-control input-sm" onkeypress="return isNumberKey(event)">
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="fc_inc_gst" class="f-label">Field Commission Inc. GST</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="fc_inc_gst" id="fc_inc_gst" class="form-control input-sm">
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="fc_exc_gst" class="f-label">Field Commission Exc. GST</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="fc_exc_gst" id="fc_exc_gst" class="form-control input-sm">
													</div>
												</div>
											</div>
										</div>
										<div class="row row-input">
											<div class="col-md-12">
												
													<div class="row">
														<div class="col-md-12">	
															<textarea name="further_details_deals" id="further_details_deals" class="form-control input-sm" rows="1" cols="50" placeholder="Further Details..."></textarea>
														</div>
													</div>
												
											</div>
											
										</div>
									</div>
									<hr>
									<div class="loan_details">
										<div class="row row-input">
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="loan_use" class="f-label">Loan Use</label>
													</div>
													<div class="col-md-8">
														<select name="loan_use" id="loan_use" class="form-control input-sm loan_use">
															<option value="consumer">Consumer</option>
															<option value="business">Business</option>
														</select>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="cust_type" class="f-label">Customer Type</label>
													</div>
													<div class="col-md-8">
														<select name="cust_type" id="cust_type" class="form-control input-sm cust_type">
															<option></option>
															<option value="joint">Joint</option>
															<option value="individual">Individual</option>
														</select>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="applicant_count" class="f-label" id="f-label-guarantors">Applicants</label>
													</div>
													<div class="col-md-8">
														<select name="applicant_count" id="applicant_count" class="form-control input-sm">
															<option value="1">1</option>
															<option value="2">2</option>
															<option value="3">3</option>
															<option value="4">4</option>
															<option value="5">5</option>
														</select>
													</div>
												</div>
											</div>
										</div>
										<div class="beneficiaries_section" hidden>
											<hr>
											<div class="panel panel-default">
												<div class="panel-heading">
												    <label class="panel-title-fapplication new" hidden>Beneficiary 1</label>
												    <label class="panel-title-fapplication default">Add a Beneficiary?</label>
												    <button type="button" class="btn btn-danger btn-xs pull-right remove">Remove</button>
												    <button type="button" class="btn btn-primary btn-xs pull-right add">Add</button>
												</div>
												<input type="hidden" name="beneficiary_id[0]" class="form-control beneficiary_id">
												<div class="panel-body" hidden>
													<div class="row row-input">
														<div class="col-md-4">
															<div class="row">
																<div class="col-md-4">
																	<label for="b_type" class="f-label" id="f-label-guarantors">Beneficiary Type</label>
																</div>
																<div class="col-md-8">
																	<input type="text" name="b_type[0]" class="form-control input-sm b_type">
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="row">
																<div class="col-md-4">
																	<label for="b_first_name" class="f-label" id="f-label-guarantors">First Name</label>
																</div>
																<div class="col-md-8">
																	<input type="text" name="b_first_name[0]" class="form-control input-sm b_first_name">
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="row">
																<div class="col-md-4">
																	<label for="b_last_name" class="f-label" id="f-label-guarantors">Last Name</label>
																</div>
																<div class="col-md-8">
																	<input type="text" name="b_last_name[0]" class="form-control input-sm b_last_name">
																</div>
															</div>
														</div>
													</div>
													<div class="row row-input">
														<div class="col-md-4">
															<div class="row">
																<div class="col-md-4">
																	<label for="b_unit" class="f-label" id="f-label-guarantors">Unit</label>
																</div>
																<div class="col-md-8">
																	<input type="text" name="b_unit[0]" class="form-control input-sm b_unit">
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="row">
																<div class="col-md-4">
																	<label for="b_address" class="f-label" id="f-label-guarantors">Street Address</label>
																</div>
																<div class="col-md-8">
																	<input type="text" name="b_address[0]" class="form-control input-sm b_address">
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="row">
																<div class="col-md-4">
																	<label for="b_suburb" class="f-label" id="f-label-guarantors">Suburb</label>
																</div>
																<div class="col-md-8">
																	<input type="text" name="b_suburb[0]" class="form-control input-sm b_suburb">
																</div>
															</div>
														</div>
													</div>
													<div class="row row-input">
														<div class="col-md-4">
															<div class="row">
																<div class="col-md-4">
																	<label for="b_postcode" class="f-label" id="f-label-guarantors">Postcode</label>
																</div>
																<div class="col-md-8">
																	<input type="text" name="b_postcode[0]" class="form-control input-sm b_postcode">
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="row">
																<div class="col-md-4">
																	<label for="b_mobile_number" class="f-label" id="f-label-guarantors">Mobile Number</label>
																</div>
																<div class="col-md-8">
																	<input type="text" name="b_mobile_number[0]" class="form-control input-sm b_mobile_number masked">
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="row">
																<div class="col-md-4">
																	<label for="b_other_number" class="f-label" id="f-label-guarantors">Other Number</label>
																</div>
																<div class="col-md-8">
																	<input type="text" name="b_other_number[0]" class="form-control input-sm b_other_number masked">
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									<hr>	
									</div>
									
									<div class="business_details" hidden>
										<h3>BUSINESS DETAILS</h3>
										<br>
										<div class="row row-input">
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="trading_name" class="f-label">Trading Name</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="trading_name" class="form-control input-sm" id="trading_name">
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="abn" class="f-label">ABN</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="abn" id="abn" class="form-control input-sm">
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="abr_name" class="f-label">ABR Name</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="abr_name" id="abr_name" class="form-control input-sm">
													</div>
												</div>
											</div>
										</div>
										<div class="row row-input">
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="abn_date" class="f-label">ABN active since</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="abn_date" id="abn_date" class="form-control input-sm abn_date">
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="industry" class="f-label">Industry</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="industry" id="industry" class="form-control input-sm">
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="gst_registered" class="f-label">GST Registered</label>
													</div>
													<div class="col-md-8">
														<select name="gst_registered" id="gst_registered" class="form-control input-sm">
															<option value="yes">Yes</option>
															<option value="No">No</option>
														</select>
													</div>
												</div>
											</div>
										</div>
										<div class="row row-input">
											<div class="col-md-4">
												
												<div class="row">
													<div class="col-md-4">
														<label for="turnover_gross" class="f-label">Turnover Gross</label>
														
													</div>
													<div class="col-md-8">	
														<input type="text" name="turnover_gross" class="form-control input-sm" id="turnover_gross" onkeypress="return isNumberKey(event)">
													</div>
												</div>
												
											</div>
											<div class="col-md-4">
												
												<div class="row">
													<div class="col-md-4">
														<label for="net_profit" class="f-label">Net Profit</label>
														
													</div>
													<div class="col-md-8">	
														<input type="text" name="net_profit" class="form-control input-sm" id="net_profit" onkeypress="return isNumberKey(event)">
													</div>
												</div>
												
											</div>
											<div class="col-md-4">
												
												<div class="row">
													<div class="col-md-4">
														<label for="other_income" class="f-label">Addbacks</label>
														
													</div>
													<div class="col-md-8">	
														<input type="text" name="other_income" class="form-control input-sm" id="other_income" onkeypress="return isNumberKey(event)">
													</div>
												</div>
												
											</div>
										</div>
										<div class="row row-input">
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="trade_address" class="f-label">Business Street Address</label>
													</div>
													<div class="col-md-4">
														<input type="text" name="trade_unit_address" id="trade_unit_address" class="form-control input-sm" placeholder="Unit">
													</div>
													<div class="col-md-4">
														<input type="text" name="trade_address" id="trade_address" class="form-control input-sm">
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="trade_suburb" class="f-label">Suburb</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="trade_suburb" id="trade_suburb" class="form-control input-sm">
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="trade_post_code" class="f-label">Post Code</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="trade_post_code" id="trade_post_code" class="form-control input-sm">
													</div>
												</div>
											</div>
										</div>
										<div class="row row-input">
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="accountant" class="f-label">Accountant Practice</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="accountant" id="accountant" class="form-control input-sm">
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="accountant_contact" class="f-label">Accountant Contact</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="accountant_contact" id="accountant_contact" class="form-control input-sm">
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="accountant_number" class="f-label">Number</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="accountant_number" id="accountant_number" class="form-control input-sm">
													</div>
												</div>
											</div>
										</div>
										<div class="row row-input">
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="accountant_address" class="f-label">Address</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="accountant_address" id="accountant_address" class="form-control input-sm">
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="accountant_suburb" class="f-label">Suburb</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="accountant_suburb" id="accountant_suburb" class="form-control input-sm">
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="accountant_post_code" class="f-label">Post Code</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="accountant_post_code" id="accountant_post_code" class="form-control input-sm">
													</div>
												</div>
											</div>
										</div>
										<div class="row row-input">
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-4">
														<label for="banking_institution" class="f-label">Business Banking Institution</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="banking_institution" id="banking_institution" class="form-control input-sm">
													</div>
												</div>
											</div>
										</div>
									<hr>	
									</div>
									
									<div class="multiple_dynamic">
										<div class="panel panel-default panel-main">
											<div class="panel-heading panel-applicant">
											    <label class="panel-title-fapplication panel-title-main">Applicant 1</label>
											    <button type="button" class="btn btn-danger btn-xs pull-right applicant-remove">Remove</button>
											    <button type="button" class="btn btn-primary btn-xs pull-right applicant-add">Add</button>
											</div>
											<input type="hidden" name="applicant_id[0]" class="form-control applicant_id">
											<div class="panel-body panel-applicant-body">
												<!-- twentysecond row -->
												<div class="row row-input">
													<div class="col-md-4">
														<div class="row">
															<div class="col-md-4">
																<label for="title" class="f-label">Title</label>
															</div>
															<div class="col-md-8">
																<select name="title[0]" class="form-control input-sm title">
																	<option value="Mr.">Mr</option>
																	<option value="Mrs.">Mrs</option>
																	<option value="Ms.">Ms</option>
																</select>
															</div>
														</div>
													</div>
													<div class="col-md-4">
														<div class="row">
															<div class="col-md-4">
																<label for="first_name" class="f-label">First name</label>
															</div>
															<div class="col-md-8">
																<input type="text" name="first_name[0]" class="form-control input-sm first_name">
															</div>
														</div>
													</div>
													<div class="col-md-4">
														<div class="row">
															<div class="col-md-4">
																<label for="middle_name" class="f-label">Middle name</label>
															</div>
															<div class="col-md-8">
																<input type="text" name="middle_name[0]" class="form-control input-sm middle_name">
															</div>
														</div>
													</div>
												</div>
												<!-- twentythird row -->
												<div class="row row-input">
													<div class="col-md-4">
														<div class="row">
															<div class="col-md-4">
																<label for="last_name" class="f-label">Surname</label>
															</div>
															<div class="col-md-8">
																<input type="text" name="last_name[0]" class="form-control input-sm last_name">
															</div>
														</div>
													</div>
													<div class="col-md-4">
														<div class="row">
															<div class="col-md-4">
																<label for="date_of_birth" class="f-label">Date of Birth</label>
															</div>
															<div class="col-md-8">
																<input type="text" name="date_of_birth[0]" class="form-control input-sm date_of_birth">
															</div>
														</div>
													</div>
													<div class="col-md-4">
														<div class="row">
															<div class="col-md-4">
																<label for="dl_number" class="f-label">DL No.</label>
															</div>
															<div class="col-md-8">
																<input type="text" name="dl_number[0]" class="form-control input-sm dl_number">
															</div>
														</div>
													</div>
												</div>
												
												<div class="row row-input">
													<div class="col-md-4">
														<div class="row">
															<div class="col-md-4">
																<label for="dl_exp" class="f-label">DL Exp</label>
															</div>
															<div class="col-md-8">
																<input type="text" name="dl_exp[0]" class="form-control input-sm dl_exp">
															</div>
														</div>
													</div>
													<div class="col-md-4">
														<div class="row">
															<div class="col-md-4">
																<label for="dl_state" class="f-label">DL State</label>
															</div>
															<div class="col-md-8">
																<select name="dl_state[0]" class="form-control input-sm dl_state">
																	<option value="nsw">NSW</option>
																	<option value="vic">VIC</option>
																	<option value="qld">QLD</option>
																	<option value="wa">WA</option>
																	<option value="tas">TAS</option>
																	<option value="nt">NT</option>
																</select>
															</div>
														</div>
													</div>
													<div class="col-md-4">
														<div class="row">
															<div class="col-md-4">
																<label for="dl_type" class="f-label">DL Type</label>
															</div>
															<div class="col-md-8">
																<select name="dl_type[0]" class="form-control input-sm dl_type">
																	<option value="full">Full</option>
																	<option value="heavy_duty">Heavy Duty</option>
																	<option value="learner">Leaner</option>
																	<option value="private_plate">Private Plate</option>
																	<option value="pensioner">Pensioner</option>
																	<option value="professional">Professional</option>
																</select>
															</div>
														</div>
													</div>
												</div>
												
												<div class="row row-input">
													<div class="col-md-4">
														<div class="row">
															<div class="col-md-4">
																<label for="marital_stat" class="f-label">Marital Status</label>
															</div>
															<div class="col-md-8">
																<select name="marital_stat[0]" class="form-control input-sm marital_stat">
																	<option value="married">Married</option>
																	<option value="never_married">Never Married</option>
																	<option value="defacto">Defacto</option>
																	<option value="widowed">Widowed</option>
																	<option value="divorced">Divorced</option>
																	<option value="separated">Separated</option>
																</select>
															</div>
														</div>
													</div>
													<div class="col-md-4">
														<div class="row">
															<div class="col-md-4">
																<label for="dependents" class="f-label">Dependents</label>
															</div>
															<div class="col-md-8">
																<select name="dependents[0]" class="form-control input-sm dependents">
																<?php
																	for ($i=0; $i < 12; $i++) 
																	{ 
																		echo "<option value='{$i}'>{$i}</option>";
																	}
																?>	
																</select>
															</div>
														</div>
													</div>
													<div class="col-md-4">
														<div class="row">
															<div class="col-md-4">
																<label for="ages" class="f-label">Ages</label>
															</div>
															<div class="col-md-8">
																<input type="text" name="ages[0]" class="form-control input-sm ages">
															</div>
														</div>
													</div>
												</div>
												
												<div class="row row-input">
													<div class="col-md-4">
														<div class="row">
															<div class="col-md-4">
																<label for="citizen_stat" class="f-label">Citizenship</label>
															</div>
															<div class="col-md-8">
																<select name="citizen_stat[0]" class="form-control input-sm citizen_stat">
																	<option value="Citizen/Permanent Resident">Citizen/Permanent Resident</option>
																	<option value="Visitor">Visitor/Visa Holder</option>
																</select>
															</div>
														</div>
													</div>
													<div class="col-md-4">
														<div class="row">
															<div class="col-md-4">
																<label for="visa_type" class="f-label">Visa Type</label>
															</div>
															<div class="col-md-8">
																<input type="text" name="visa_type[0]" class="form-control input-sm visa_type" disabled>
															</div>
														</div>
													</div>
													<div class="col-md-4">
														<div class="row">
															<div class="col-md-4">
																<label for="visa_exp_date" class="f-label">Visa expiry date</label>
															</div>
															<div class="col-md-8">
																<input type="text" name="visa_exp_date[0]" class="form-control input-sm visa_exp_date" disabled>
															</div>
														</div>
													</div>
												</div>
												
												<div class="row row-input">
													<div class="col-md-4">
														<div class="row">
															<div class="col-md-4">
																<label for="email" class="f-label">Email</label>
															</div>
															<div class="col-md-8">
																<input type="text" name="email[0]" class="form-control input-sm email">
															</div>
														</div>
													</div>
													<div class="col-md-4">
														<div class="row">
															<div class="col-md-4">
																<label for="mobile" class="f-label">Primary Number</label>
															</div>
															<div class="col-md-8">
																<input type="text" name="mobile[0]" class="form-control input-sm mobile masked">
															</div>
														</div>
													</div>
													<div class="col-md-4">
														<div class="row">
															<div class="col-md-4">
																<label for="other_telephone" class="f-label">Secondary Number</label>
															</div>
															<div class="col-md-8">
																<input type="text" name="other_telephone[0]" class="form-control input-sm other_telephone masked">
															</div>
														</div>
													</div>
												</div>
												
												<hr>
												<!-- address clause -->
												<div class="address-clause">
													<div class="panel panel-default">
														<div class="panel-heading">
														    <label class="panel-title-fapplication">Address 1</label>
														    <button type="button" class="btn btn-danger btn-xs pull-right remove">Remove</button>
														</div>
														<input type="hidden" name="address_id[0][0]" class="form-control address_id">
														<div class="panel-body">
															<!-- twentyninth row -->
															<div class="row row-input">
																<div class="col-md-4">
																	<div class="row">
																		<div class="col-md-4">
																			<label for="client_unit" class="f-label">Unit</label>
																		</div>
																		<div class="col-md-8">
																			<input type="text" name="client_unit[0][0]" class="form-control input-sm client_unit">
																		</div>
																	</div>
																</div>
																<div class="col-md-4">
																	<div class="row">
																		<div class="col-md-4">
																			<label for="client_address" class="f-label">Street Address</label>
																		</div>
																		<div class="col-md-8">
																			<input type="text" name="client_address[0][0]" class="form-control input-sm client_address">
																		</div>
																	</div>
																</div>
																<div class="col-md-4">
																	<div class="row">
																		<div class="col-md-4">
																			<label for="client_suburb" class="f-label">Suburb</label>
																		</div>
																		<div class="col-md-8">
																			<input type="text" name="client_suburb[0][0]" class="form-control input-sm client_suburb">
																		</div>
																	</div>
																</div>
															</div>
															<div class="row row-input">
																<div class="col-md-4">
																	<div class="row">
																		<div class="col-md-4">
																			<label for="client_post_code" class="f-label">Post Code</label>
																		</div>
																		<div class="col-md-8">
																			<input type="text" name="client_post_code[0][0]" class="form-control input-sm client_post_code">
																		</div>
																	</div>
																</div>
																<div class="col-md-4">
																	<div class="row">
																		<div class="col-md-4">
																			<label for="client_res_stat" class="f-label">Residential Status</label>
																		</div>
																		<div class="col-md-8">
																			<select name="client_res_stat[0][0]" class="form-control input-sm client_res_stat">
																				<option value="buying">Buying</option>
																				<option value="mortgage">Mortgage</option>
																				<option value="renting">Renting</option>
																				<option value="owner">Owner</option>
																				<option value="living_with_parents">Living with parents</option>
																				<option value="boarding">Boarding</option>
																				<option value="emp_sub">Employer Subsidised</option>
																				<option value="other">Other</option>
																			</select>
																		</div>
																	</div>
																</div>
																
																<div class="col-md-4">	
																	<div class="row">
																		<div class="col-md-4">
																			<label for="time_address" class="f-label">Time at Address</label>
																		</div>
																		<div class="col-md-4">
																			<select name="time_address_years[0][0]" class="form-control input-sm time_address_years time_add">
																			<?php
																				for ($i=0; $i < 100; $i++) 
																				{ 
																					echo "<option value='{$i}'>{$i}</option>";
																				}
																			?>
																			</select>
																		</div>
																		<div class="col-md-4">
																			<select name="time_address_month[0][0]" class="form-control input-sm time_address_month time_add">
																			<?php
																				for ($i=0; $i < 13; $i++) 
																				{ 
																					echo "<option value='{$i}'>{$i}</option>";
																				}
																			?>
																			</select>
																		</div>
																	</div>
																</div>
															</div>
															<div class="row row-input name_on_title_row" hidden>
																<div class="col-md-4">
																	<div class="row">
																		<div class="col-md-4">
																			<label for="name_on_title" class="f-label">Name on Title?</label>
																		</div>
																		<div class="col-md-8">
																			<select name="name_on_title[0][0]" class="form-control input-sm name_on_title">
																				<option value="No">No</option>
																				<option value="Yes">Yes</option>
																			</select>
																		</div>
																	</div>
																</div>
															</div>
															<!-- hidden landlord thirtythird row-->
															<div class="row row-input landlord-hidden" hidden>
																<div class="col-md-4">
																	<div class="row">
																		<div class="col-md-4">
																			<label for="landlord_realestate_name" class="f-label">Landlord/Realestate Agent</label>
																		</div>
																		<div class="col-md-8">
																			<input type="text" name="landlord_realestate_name[0][0]" class="form-control input-sm landlord_realestate_name">
																		</div>
																	</div>
																</div>
																<div class="col-md-4">
																	<div class="row">
																		<div class="col-md-4">
																			<label for="landlord_realestate_contact" class="f-label">Landlord/Realestate Contact</label>
																		</div>
																		<div class="col-md-8">
																			<input type="text" name="landlord_realestate_contact[0][0]" class="form-control input-sm landlord_realestate_contact">
																		</div>
																	</div>
																	
																</div>
																<div class="col-md-4">
																	<div class="row">
																		<div class="col-md-4">
																			<label for="landlord_realestate_number" class="f-label">Landlord/Realestate Number</label>
																		</div>
																		<div class="col-md-8">
																			<input type="text" name="landlord_realestate_number[0][0]" class="form-control input-sm landlord_realestate_number">
																		</div>
																	</div>
																	
																</div>
															</div>
															<div class="row row-input landlord-hidden" hidden>
																<div class="col-md-4">
																	<div class="row">
																		<div class="col-md-4">
																			<label for="monthly_commitment" class="f-label">Monthly Commitment</label>
																		</div>
																		<div class="col-md-8">
																			<input type="text" name="monthly_commitment[0][0]" class="form-control input-sm monthly_commitment">
																		</div>
																	</div>
																</div>
															</div>
															
														</div>
													</div> 
												</div>												
												<div class="employer_clause" hidden>
													<div class="panel panel-default">
														<div class="panel-heading">
														    <label class="panel-title-fapplication">Employer 1</label>
														    <button type="button" class="btn btn-danger btn-xs pull-right remove">Remove</button>
														</div>
														<input type="hidden" name="employer_id[0][0]" class="form-control employer_id">
														<div class="panel-body">
															<!--  thirtysixth row -->
															<div class="row row-input">
																<div class="col-md-4">
																	<div class="row">
																		<div class="col-md-4">
																			<label for="employer_name" class="f-label">Company Name</label>
																		</div>
																		<div class="col-md-8">
																			<input type="text" name="employer_name[0][0]" class="form-control input-sm employer_name">
																		</div>
																	</div>
																</div>
																<div class="col-md-4">
																	<div class="row">
																		<div class="col-md-4">
																			<label for="employement_status" class="f-label">Employment Status</label>
																		</div>
																		<div class="col-md-8">
																			<select name="employment_status[0][0]" class="form-control input-sm employment_status">
																				<option value="full_time">Full Time</option>
																				<option value="contract">Contract</option>
																				<option value="part_time">Part Time</option>
																				<option value="perm_full_contract">Permanent Full time Contract</option>
																				<option value="perm_part_contract">Permanent Part time Contract</option>
																				<option value="unemployed">Unemployed</option>
																				<option value="casual">Casual</option>
																				<option value="seasonal">Seasonal</option>
																				<option value="probation">On Probation</option>
																				<option value="other">Other</option>
																			</select>
																		</div>
																	</div>
																</div>
																<div class="col-md-4">
																	<div class="row">
																		<div class="col-md-4">
																			<label for="occ_position" class="f-label">Occupation/Position</label>
																		</div>
																		<div class="col-md-8">
																			<input type="text" name="occ_position[0][0]" class="form-control input-sm occ_position">
																		</div>
																	</div>
																</div>
															</div>
															
															<div class="row row-input">
																<div class="col-md-4">
																	<div class="row">
																		<div class="col-md-4">
																			<label for="emp_unit" class="f-label">Unit</label>
																		</div>
																		<div class="col-md-8">
																			<input type="text" name="emp_unit[0][0]" class="form-control input-sm emp_unit">
																		</div>
																	</div>
																</div>
																<div class="col-md-4">
																	<div class="row">
																		<div class="col-md-4">
																			<label for="emp_address" class="f-label">Street Address</label>
																		</div>
																		<div class="col-md-8">
																			<input type="text" name="emp_address[0][0]" class="form-control input-sm emp_address">
																		</div>
																	</div>
																</div>
																<div class="col-md-4">
																	<div class="row">
																		<div class="col-md-4">
																			<label for="emp_suburb" class="f-label">Suburb</label>
																		</div>
																		<div class="col-md-8">
																			<input type="text" name="emp_suburb[0][0]" class="form-control input-sm emp_suburb">
																		</div>
																	</div>
																</div>
															</div>
															<div class="row row-input">
																<div class="col-md-4">
																	<div class="row">
																		<div class="col-md-4">
																			<label for="emp_post" class="f-label">Post Code</label>
																		</div>
																		<div class="col-md-8">
																			<input type="text" name="emp_post[0][0]" class="form-control input-sm emp_post">
																		</div>
																	</div>
																</div>
															</div>
															<div class="row row-input">
																<div class="col-md-4">
																	<div class="row">
																		<div class="col-md-4">
																			<label for="contact_person" class="f-label">Contact Person</label>
																		</div>
																		<div class="col-md-8">
																			<input type="text" name="contact_person[0][0]" class="form-control input-sm contact_person">
																		</div>
																	</div>
																</div>
																<div class="col-md-4">
																	<div class="row">
																		<div class="col-md-4">
																			<label for="contact_number" class="f-label">Contact Number</label>
																		</div>
																		<div class="col-md-8">
																			<input type="text" name="contact_number[0][0]" class="form-control input-sm contact_number" >
																		</div>
																	</div>
																</div>
																<div class="col-md-4">
																	<div class="row">
																		<div class="col-md-4">
																			<label for="time_employer" class="f-label">Time with Employer</label>
																		</div>
																		<div class="col-md-4">
																			<select name="time_employer_years[0][0]" class="form-control input-sm time_employer_years time_add_employer">
																			<?php
																				for ($i=0; $i < 100; $i++) 
																				{ 
																					echo "<option value='{$i}'>{$i}</option>";
																				}
																			?>
																			</select>
																		</div>
																		<div class="col-md-4">
																			<select name="time_employer_month[0][0]" class="form-control input-sm time_employer_month time_add_employer">
																			<?php
																				for ($i=0; $i < 13; $i++) 
																				{ 
																					echo "<option value='{$i}'>{$i}</option>";
																				}
																			?>
																			</select>
																		</div>
																	</div>
																</div>
															</div>
															<div class="row row-input">
																<div class="col-md-4">
																	<div class="row">
																		<div class="col-md-4">
																			<label for="net_income" class="f-label">Net Monthly Income ($)</label>
																		</div>
																		<div class="col-md-8">
																			<input type="text" name="net_income[0][0]" class="form-control input-sm net_income" onkeypress="return isNumberKey(event)">
																		</div>
																	</div>
																</div>
																<div class="col-md-4">
																	<div class="row">
																		<div class="col-md-4">
																			<label for="sal_pax_ded" class="f-label">Salary Package Deduction ($)</label>
																		</div>
																		<div class="col-md-8">
																			<input type="text" name="sal_pax_ded[0][0]" class="form-control input-sm sal_pax_ded" onkeypress="return isNumberKey(event)">
																		</div>
																	</div>
																</div>
																<div class="col-md-4 industry_col">
																	<div class="row">
																		<div class="col-md-4">
																			<label for="sal_pax_ded" class="f-label">Industry</label>
																		</div>
																		<div class="col-md-8">
																			<input type="text" name="emp_industry[0][0]" class="form-control input-sm emp_industry">
																		</div>
																	</div>
																</div>
															</div>
															<div class="row row-input emp_abn_panel" hidden>
																<div class="col-md-4">
																	<div class="row">
																		<div class="col-md-4">
																			<label for="emp_abn" class="f-label">Employer ABN</label>
																		</div>
																		<div class="col-md-8">
																			<input type="text" name="emp_abn[0][0]" class="form-control input-sm emp_abn" >
																		</div>
																	</div>
																</div>
															</div>
															<div class="other_income_clause" >
																<div class="false-panel" style="margin-bottom: 15px;">
																	<div class="panel-heading">
																	    <label class="panel-title-3rd-dim new" hidden>Other Income 1</label>
																	    <label class="panel-title-3rd-dim default">Add Other Income?</label>
																	    <button type="button" class="btn btn-danger btn-xs pull-right remove_other_income">Remove</button>
																	    <button type="button" class="btn btn-primary btn-xs pull-right add_other_income">Add</button>
																	</div>
																	<input type="hidden" name="other_income_id[0][0][0]" class="form-control other_income_id">
																	<div class="panel-body other_income_body" hidden>
																		<div class="row row-input">
																			<div class="col-md-4">
																				<div class="row">
																					<div class="col-md-4">
																						<label for="other_income_name" class="f-label">Other Income</label>
																					</div>
																					<div class="col-md-8">
																						<select name="other_income_name[0][0][0]" class="form-control input-sm other_income_name">
																							<option value=""></option>
																							<option value="Concurrent Employer">Concurrent Employer</option>
																							<option value="Overtime">Overtime</option>
																							<option value="Commission">Commission</option>
																							<option value="Interest">Interest</option>
																							<option value="Dividends">Dividends</option>
																							<option value="Pension">Pension</option>
																							<option value="Pension">Welfare</option>
																						</select>
																					</div>
																				</div>
																			</div>
																			<div class="col-md-4">
																				<div class="row">
																					<div class="col-md-4">
																						<label for="other_income_details" class="f-label">Details</label>
																					</div>
																					<div class="col-md-8">
																						<input type="text" name="other_income_details[0][0][0]" class="form-control input-sm other_income_details" >
																					</div>
																				</div>
																			</div>
																			<div class="col-md-4">
																				<div class="row">
																					<div class="col-md-4">
																						<label for="other_income_amount" class="f-label">Amount ($)</label>
																					</div>
																					<div class="col-md-8">
																						<input type="text" name="other_income_amount[0][0][0]" class="form-control input-sm other_income_amount" onkeypress="return isNumberKey(event)">
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<hr>
												<div class="liability_clause">
													<h4>Liabilities</h4>
													<br>
													<div class="property_clause">
														<div class="panel panel-default">
															<div class="panel-heading">
															    <label class="panel-title-fapplication">Property 1</label>
															    <button type="button" class="btn btn-danger btn-xs pull-right remove">Remove</button>
															    <button type="button" class="btn btn-primary btn-xs pull-right add">Add</button>
															</div>
															<input type="hidden" name="property_id[0][0]" class="form-control property_id">
															<div class="panel-body">
																<div class="row row-input">
																	<div class="col-md-4">
																		<div class="row">
																			<div class="col-md-4">
																				<label for="property_address" class="f-label">Property Unit</label>
																			</div>
																			<div class="col-md-8">
																				<input type="text" name="property_unit[0][0]" class="form-control input-sm property_unit">
																			</div>
																		</div>
																	</div>
																	<div class="col-md-4">
																		<div class="row">
																			<div class="col-md-4">
																				<label for="property_address" class="f-label">Property Street Address</label>
																			</div>
																			<div class="col-md-8">
																				<input type="text" name="property_address[0][0]" class="form-control input-sm property_address">
																			</div>
																		</div>
																	</div>
																	<div class="col-md-4">
																		<div class="row">
																			<div class="col-md-4">
																				<label for="property_suburb" class="f-label">Suburb</label>
																			</div>
																			<div class="col-md-8">
																				<input type="text" name="property_suburb[0][0]" class="form-control input-sm property_suburb">
																			</div>
																		</div>
																	</div>
																</div>
																<div class="row row-input">
																	<div class="col-md-4">
																		<div class="row">
																			<div class="col-md-4">
																				<label for="property_postcode" class="f-label">Postcode</label>
																			</div>
																			<div class="col-md-8">
																				<input type="text" name="property_postcode[0][0]" class="form-control input-sm property_postcode">
																			</div>
																		</div>
																	</div>
																	<div class="col-md-4">
																		<div class="row">
																			<div class="col-md-4">
																				<label for="mortgage_with" class="f-label">Mortgage Institution</label>
																			</div>
																			<div class="col-md-8">
																				<input type="text" name="mortgage_with[0][0]" class="form-control input-sm mortgage_with">
																			</div>
																		</div>
																	</div>
																	<div class="col-md-4">
																		<div class="row">
																			<div class="col-md-4">
																				<label for="mortgage_commitment" class="f-label">Minimum Monthly Payment</label>
																			</div>
																			<div class="col-md-8">
																				<input type="text" name="mortgage_commitment[0][0]" class="form-control input-sm mortgage_commitment">
																			</div>
																		</div>
																	</div>
																</div>
																<!--  fourtyninth row -->
																<div class="row row-input">
																	<div class="col-md-4">
																		<div class="row">
																			<div class="col-md-4">
																				<label for="balance" class="f-label">Mortgage Balance</label>
																			</div>
																			<div class="col-md-8">
																				<input type="text" name="balance[0][0]" class="form-control input-sm balance">
																			</div>
																		</div>
																	</div>
																	<div class="col-md-4">
																		<div class="row">
																			<div class="col-md-4">
																				<label for="property_value" class="f-label">Property Value</label>
																			</div>
																			<div class="col-md-8">
																				<input type="text" name="property_value[0][0]" class="form-control input-sm property_value">
																			</div>
																		</div>
																	</div>
																	<div class="col-md-4">
																		<div class="row">
																			<div class="col-md-4">
																				<label for="monthly_rental_income" class="f-label">Rental Income</label>
																			</div>
																			<div class="col-md-8">
																				<input type="text" name="monthly_rental_income[0][0]" class="form-control input-sm monthly_rental_income">
																			</div>
																		</div>
																	</div>
																</div>
																<div class="row row-input">
																	<div class="col-md-4">
																		<div class="row">
																			<div class="col-md-4">
																				<label for="managed" class="f-label">Managed</label>
																			</div>
																			<div class="col-md-8">
																				<input type="text" name="managed[0][0]" class="form-control input-sm managed">
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div> 
													</div>
													<div class="cred_card_clause">
														<div class="panel panel-default">
															<div class="panel-heading">
															    <label class="panel-title-fapplication new" hidden>Credit Card 1</label>
															    <label class="panel-title-fapplication default">Add a Credit Card?</label>
															    <button type="button" class="btn btn-danger btn-xs pull-right remove">Remove</button>
															    <button type="button" class="btn btn-primary btn-xs pull-right add">Add</button>
															</div>
															<input type="hidden" name="credit_card_id[0][0]" class="form-control credit_card_id">
															<div class="panel-body" hidden>
																<!--  fourtysecond row -->
																<div class="row row-input">
																	<div class="col-md-4">
																		<div class="row">
																			<div class="col-md-4">
																				<label for="credit_card_name" class="f-label">Credit Card Name</label>
																			</div>
																			<div class="col-md-8">
																				<input type="text" name="credit_card_name[0][0]" class="form-control input-sm credit_card_name">
																			</div>
																		</div>
																	</div>
																	<div class="col-md-4">
																		<div class="row">
																			<div class="col-md-4">
																				<label for="credit_card_limit" class="f-label">Limit ($)</label>
																			</div>
																			<div class="col-md-8">
																				<input type="text" name="credit_card_limit[0][0]" class="form-control input-sm credit_card_limit" onkeypress="return isNumberKey(event)">
																			</div>
																		</div>
																	</div>
																	<div class="col-md-4">
																		<div class="row">
																			<div class="col-md-4">
																				<label for="credit_card_balance" class="f-label">Credit Card Balance ($)</label>
																			</div>
																			<div class="col-md-8">
																				<input type="text" name="credit_card_balance[0][0]" class="form-control input-sm credit_card_balance" onkeypress="return isNumberKey(event)">
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div> 
													</div>
													<div class="loan_clause">
														<div class="panel panel-default">
															<div class="panel-heading">
															    <label class="panel-title-fapplication new" hidden>Other Loans 1</label>
															    <label class="panel-title-fapplication default">Add Other Loans?</label>
															    <button type="button" class="btn btn-danger btn-xs pull-right remove">Remove</button>
															    <button type="button" class="btn btn-primary btn-xs pull-right add">Add</button>
															</div>
															<input type="hidden" name="other_loans_id[0][0]" class="form-control other_loans_id">
															<div class="panel-body" hidden>
																
																<div class="row row-input">
																	<div class="col-md-4">
																		<div class="row">
																			<div class="col-md-4">
																				<label for="lending_institution" class="f-label">Lending Institution</label>
																			</div>
																			<div class="col-md-8">
																				<input type="text" name="lending_institution[0][0]" class="form-control input-sm lending_institution">
																			</div>
																		</div>
																	</div>
																	<div class="col-md-4">
																		<div class="row">
																			<div class="col-md-4">
																				<label for="purpose" class="f-label">Purpose for Loan</label>
																			</div>
																			<div class="col-md-8">
																				<input type="text" name="purpose[0][0]" class="form-control input-sm purpose">
																			</div>
																		</div>
																	</div>
																	<div class="col-md-4">
																		<div class="row">
																			<div class="col-md-4">
																				<label for="amount_borrowed" class="f-label">Amount Borrowed ($)</label>
																			</div>
																			<div class="col-md-8">
																				<input type="text" name="amount_borrowed[0][0]" class="form-control input-sm amount_borrowed" onkeypress="return isNumberKey(event)">
																			</div>
																		</div>
																	</div>
																</div>
																<div class="row row-input">
																	<div class="col-md-4">
																		<div class="row">
																			<div class="col-md-4">
																				<label for="o_term" class="f-label">Loan Term</label>
																			</div>
																			<div class="col-md-8">
																				<input type="text" name="o_term[0][0]" class="form-control input-sm o_term">
																			</div>
																		</div>
																	</div>
																	<div class="col-md-4">
																		<div class="row">
																			<div class="col-md-4">
																				<label for="loan_start_date" class="f-label">Start Date</label>
																			</div>
																			<div class="col-md-8">
																				<input type="text" name="loan_start_date[0][0]" class="form-control input-sm loan_start_date">
																			</div>
																		</div>
																	</div>
																	<div class="col-md-4">
																		<div class="row">
																			<div class="col-md-4">
																				<label class="f-label">Balloon</label>
																			</div>
																			<div class="col-md-4">
																				<input type="text" name="o_balloon_amt[0][0]" class="form-control input-sm o_balloon_amt" placeholder="$" onkeypress="return isNumberKey(event)">
																			</div>
																			<div class="col-md-4">
																				<input type="text" name="o_balloon_percentage[0][0]" class="form-control input-sm o_balloon_percentage" placeholder="%" onkeypress="return isNumberKey(event)">
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div> 
													</div>
												</div>
												<div class="cred_reference_clause">
													<div class="panel panel-default">
														<div class="panel-heading">
														    <label class="panel-title-fapplication new" hidden>Reference 1</label>
														    <label class="panel-title-fapplication default">Add a Reference?</label>
														    <button type="button" class="btn btn-danger btn-xs pull-right remove">Remove</button>
														    <button type="button" class="btn btn-primary btn-xs pull-right add">Add</button>
														</div>
														<input type="hidden" name="credit_reference_id[0][0]" class="form-control credit_reference_id">
														<div class="panel-body" hidden>
															<!--  fourtyfourth row -->
															<div class="row row-input">
																<div class="col-md-4">
																		<div class="row">
																			<div class="col-md-4">
																				<label for="r_first_name" class="f-label">First Name</label>
																			</div>
																			<div class="col-md-8">
																				<input type="text" name="r_first_name[0][0]" class="form-control input-sm r_first_name">
																			</div>
																		</div>
																</div>
																<div class="col-md-4">
																	<div class="row">
																		<div class="col-md-4">
																			<label for="r_last_name" class="f-label">Last Name</label>
																		</div>
																		<div class="col-md-8">
																			<input type="text" name="r_last_name[0][0]" class="form-control input-sm r_last_name">
																		</div>
																	</div>
																</div>
																<div class="col-md-4">
																	<div class="row">
																		<div class="col-md-4">
																			<label for="r_telephone" class="f-label">Telephone</label>
																		</div>
																		<div class="col-md-8">
																			<input type="text" name="r_telephone[0][0]" class="form-control input-sm r_telephone" >
																		</div>
																	</div>
																</div>
															</div>
															<!--  fourtyfifth row -->
															<div class="row row-input">
																<div class="col-md-4">
																	<div class="row">
																		<div class="col-md-4">
																			<label for="r_unit" class="f-label">Unit</label>
																		</div>
																		<div class="col-md-8">
																			<input type="text" name="r_unit[0][0]" class="form-control input-sm r_unit" >
																		</div>
																	</div>
																</div>
																<div class="col-md-4">
																	<div class="row">
																		<div class="col-md-4">
																			<label for="r_address" class="f-label">Street Address</label>
																		</div>
																		<div class="col-md-8">
																			<input type="text" name="r_address[0][0]" class="form-control input-sm r_address" >
																		</div>
																	</div>
																</div>
																<div class="col-md-4">
																	<div class="row">
																		<div class="col-md-4">
																			<label for="r_suburb" class="f-label">Suburb</label>
																		</div>
																		<div class="col-md-8">
																			<input type="text" name="r_suburb[0][0]" class="form-control input-sm r_suburb">
																		</div>
																	</div>
																</div>
															</div>
															<div class="row row-input">
																<div class="col-md-4">
																	<div class="row">
																		<div class="col-md-4">
																			<label for="r_postcode" class="f-label">Postcode</label>
																		</div>
																		<div class="col-md-8">
																			<input type="text" name="r_postcode[0][0]" class="form-control input-sm r_postcode">
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div> 
												<hr>	
												</div>
												
												<hr>
												<div class="living_cost_clause" hidden>
													<h4>Living Costs</h4>
													<br>
													<div class="row row-input">
														<div class="col-md-4">
															<div class="row">
																<div class="col-md-4">
																	<label for="food_beverage" class="f-label">Monthly Food Cost ($)</label>
																</div>
																<div class="col-md-8">
																	<input type="text" name="food_beverage[0]" class="form-control input-sm food_beverage living_cost" onkeypress="return isNumberKey(event)">
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="row">
																<div class="col-md-4">
																	<label for="power_gas" class="f-label">Eletricity, water, gas ($)</label>
																</div>
																<div class="col-md-8">
																	<input type="text" name="power_gas[0]" class="form-control input-sm power_gas living_cost" onkeypress="return isNumberKey(event)">
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="row">
																<div class="col-md-4">
																	<label for="medical" class="f-label">Health/Medical ($)</label>
																</div>
																<div class="col-md-8">
																	<input type="text" name="medical[0]" class="form-control input-sm medical living_cost" onkeypress="return isNumberKey(event)">
																</div>
															</div>
														</div>
													</div>
													<div class="row row-input">
														<div class="col-md-4">
															<div class="row">
																<div class="col-md-4">
																	<label for="insurance" class="f-label">Insurance Premium ($)</label>
																</div>
																<div class="col-md-8">
																	<input type="text" name="insurance[0]" class="form-control input-sm insurance living_cost" onkeypress="return isNumberKey(event)">
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="row">
																<div class="col-md-4">
																	<label for="transportation_fuel" class="f-label">Transportation &amp; Fuel ($)</label>
																</div>
																<div class="col-md-8">
																	<input type="text" name="transportation_fuel[0]" class="form-control input-sm transportation_fuel living_cost" onkeypress="return isNumberKey(event)">
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="row">
																<div class="col-md-4">
																	<label for="communications" class="f-label">Communications</label>
																</div>
																<div class="col-md-8">
																	<input type="text" name="communications[0]" class="form-control input-sm communications living_cost" onkeypress="return isNumberKey(event)">
																</div>
															</div>
														</div>
													</div>
													<div class="row row-input">
														<div class="col-md-4">
															<div class="row">
																<div class="col-md-4">
																	<label for="recreation" class="f-label">Recreation</label>
																</div>
																<div class="col-md-8">
																	<input type="text" name="recreation[0]" class="form-control input-sm recreation living_cost" onkeypress="return isNumberKey(event)">
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="row">
																<div class="col-md-4">
																	<label for="tot_living_cost" class="f-label">Total Living Cost</label>
																</div>
																<div class="col-md-8">
																	<input type="text" name="tot_living_cost[0]" class="form-control input-sm tot_living_cost" onkeypress="return isNumberKey(event)">
																</div>
															</div>
														</div>
													</div>
													<hr>
												</div>
												<div class="assets">
													<h4>Assets</h4>
													<br>
													<div class="row row-input">
														<div class="col-md-4">
															<div class="row">
																<div class="col-md-4">
																	<label for="tot_prop_value" class="f-label">Total Property Value ($)</label>
																</div>
																<div class="col-md-8">
																	<input type="text" name="tot_prop_value[0]" class="form-control input-sm tot_prop_value">
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="row">
																<div class="col-md-4">
																	<label for="cash_savings" class="f-label">Cash Savings ($)</label>
																</div>
																<div class="col-md-8">
																	<input type="text" name="cash_savings[0]" class="form-control input-sm cash_savings">
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="row">
																<div class="col-md-4">
																	<label for="personal_effects" class="f-label">Personal Effects</label>
																</div>
																<div class="col-md-8">
																	<input type="text" name="personal_effects[0]" class="form-control input-sm personal_effects">
																</div>
															</div>
														</div>
													</div>
													<div class="row row-input">
														<div class="col-md-4">
															<div class="row">
																<div class="col-md-4">
																	<label for="superannuation" class="f-label">Superannuation</label>
																</div>
																<div class="col-md-8">
																	<input type="text" name="superannuation[0]" class="form-control input-sm superannuation">
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="row">
																<div class="col-md-4">
																	<label for="shares_investments" class="f-label">Shares and Investments</label>
																</div>
																<div class="col-md-8">
																	<input type="text" name="shares_investments[0]" class="form-control input-sm shares_investments">
																</div>
															</div>
														</div>
													</div>
													<hr>
													<div class="asset_clause">
														<div class="panel panel-default">
															<div class="panel-heading">
															    <label class="panel-title-fapplication new" hidden>Other Asset 1</label>
															    <label class="panel-title-fapplication default">Add an Asset?</label>
															    <button type="button" class="btn btn-danger btn-xs pull-right remove">Remove</button>
															    <button type="button" class="btn btn-primary btn-xs pull-right add">Add</button>
															</div>
															<input type="hidden" name="other_asset_id[0][0]" class="form-control other_asset_id">
															<div class="panel-body" hidden>
																
																<div class="row row-input">
																	<div class="col-md-4">
																		<div class="row">
																			<div class="col-md-4">
																				<label for="other_asset_name" class="f-label">Asset Description</label>
																			</div>
																			<div class="col-md-8">
																				<input type="text" name="other_asset_name[0][0]" class="form-control input-sm other_asset_name">
																			</div>
																		</div>
																	</div>
																	<div class="col-md-4">
																		<div class="row">
																			<div class="col-md-4">
																				<label for="other_asset_value" class="f-label">Asset Value ($)</label>
																			</div>
																			<div class="col-md-8">
																				<input type="text" name="other_asset_value[0][0]" class="form-control input-sm other_asset_value" onkeypress="return isNumberKey(event)">
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<hr>
												<div class="borrowers_statement">
													<h4>Borrowers Statement</h4>
													<br>
													<div class="row row-input" hidden>
														<div class="col-md-10 statement_label">
															<p></p>
														</div>
														<div class="col-md-2">
															<select name="statement_1[0]" class="form-control input-sm statement_1">
																<option value="yes">Yes</option>
																<option value="no">No</option>
															</select>
														</div>
													</div>
													<div class="row row-input" hidden>
														<div class="col-md-10 statement_label">
															<p></p>
														</div>
														<div class="col-md-2">
															<select name="statement_2[0]" class="form-control input-sm statement_2">
																<option value="yes">Yes</option>
																<option value="no">No</option>
															</select>
														</div>
													</div>
													<div class="row row-input" hidden>
														<div class="col-md-10 statement_label">
															<p></p>
														</div>
														<div class="col-md-2">
															<select name="statement_3[0]" class="form-control input-sm statement_3">
																<option value="yes">Yes</option>
																<option value="no">No</option>
															</select>
														</div>
													</div>
													<div class="row row-input" hidden>
														<div class="col-md-10 statement_label">
															<p></p>
														</div>
														<div class="col-md-2">
															<select name="statement_4[0]" class="form-control input-sm statement_4">
																<option value="yes">Yes</option>
																<option value="no">No</option>
															</select>
														</div>
													</div>
													<div class="row row-input" hidden>
														<div class="col-md-10 statement_label">
															<p></p>
														</div>
														<div class="col-md-2">
															<select name="statement_5[0]" class="form-control input-sm statement_5">
																<option value="yes">Yes</option>
																<option value="no">No</option>
															</select>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<hr>
								</div>
							</section>
						</div>
						<div class="toogle" data-plugin-toggle="">
							<section class="toggle">
								<label>ACTIONS HISTORY</label>
								<div class="toggle-content">
									<div class="table-responsive">
										<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
											<thead>
												<tr>
													<td width="80%"><b>Action</b></td>
													<td><b>User</b></td>
													<td><b>Timestamp</b></td>
												</tr>
											</thead>
											<tbody id="fapplication_actions_history"></tbody>
										</table>
									</div>
								</div>
							</section>
						</div>
						<br />
						<div id="fapplication_comments"></div>
						<br />
						<div class="col-md-12 text-left" id="fapplication_email_actions"></div>
						<div class="col-md-12 text-left">
							<br />
							<input type="hidden" id="fapplication_id" name="fapplication_id" value="" />
							<input type="hidden" id="lead_id_fq" name="lead_id_fq" value="" />
							<input type="hidden" id="fapplication_details" name="fapplication_details" />
							<br />
						</div>
					</form>
				</div>
			</div>
		</div>
		<footer class="panel-footer">
			<div class="row">
				<div class="col-md-12 text-right">
					<div id="fapplication_actions"></div>
				</div>
			</div>
		</footer>
	</div>
</div>


<div class="deal_structure">
<h3>DEAL STRUCTURE</h3>
<br>
<table>
	<tbody>
		<tr>
			<td class="p-all-10 p-top-15">
				<label for="purchase_price" class="f-label">Purchase Price</label>
			</td>
			<td class="p-all-10">
				<input type="text" name="purchase_price" class="form-control input-sm" id="purchase_price" onkeypress="return isNumberKey(event)" value="0.00">
			</td>
			<td class="p-all-10 p-top-15">
				<label for="deposit" class="f-label">Deposit</label>
			</td>
			<td class="p-all-10">
				<input type="text" name="deposit" class="form-control input-sm" id="deposit" onkeypress="return isNumberKey(event)" value="0.00">
			</td>
			<td class="p-all-10 p-top-15">
				<label for="trade" class="f-label">Trade Value</label>
			</td>
			<td class="p-all-10">
				<input type="text" name="trade" class="form-control input-sm" id="trade" onkeypress="return isNumberKey(event)" value="0.00">
			</td>
			<td class="p-all-10 p-top-15">
				<label for="payout" class="f-label">Payout</label>
			</td>
			<td class="p-all-10">
				<input type="text" name="payout" class="form-control input-sm" id="payout" onkeypress="return isNumberKey(event)" value="0.00">
			</td>
			<td class="p-all-10 p-top-15">
				<label for="amt_to_finance" class="f-label">Amount to Finance</label>
			</td>
			<td class="p-all-10">
				<input type="text" name="amt_to_finance" class="form-control input-sm" id="amt_to_finance" onkeypress="return isNumberKey(event)" value="0.00">
			</td>
			<td class="p-all-10 p-top-15">
				<label for="term" class="f-label">Term</label>
			</td>
			<td class="p-all-10">
				<input type="text" name="term" class="form-control input-sm" id="term" onkeypress="return isNumberKey(event)">
			</td>
		</tr>
	</tbody>
</table>
<table>
	<tbody>
		<tr>
			<td class="p-all-10 p-top-15">
				<label class="f-label">Balloon</label>
			</td>
			<td>
				<input type="text" name="balloon_amt" id="balloon_amt" class="form-control input-sm" placeholder="$" onkeypress="return isNumberKey(event)">
			</td>
			<td class="p-all-10">
				<input type="text" name="balloon_percentage" id="balloon_percentage" class="form-control input-sm" placeholder="%" onkeypress="return isNumberKey(event)">
			</td>
			<td class="p-all-10 p-top-15">
				<label for="lender" class="f-label">Lender</label>
			</td>
			<td class="p-all-10">
				<select name="lender" id="lender" class="form-control input-sm">
					<option value="Esanda">Esanda</option>
					<option value="St. george">St. George</option>
					<option value="MacQuarie">Macquarie</option>
					<option value="Pepper">Pepper</option>
				</select>
			</td>
			<td class="p-all-10 p-top-15">
				<label for="est_fee" class="f-label">Est Fee ($)</label>
			</td>
			<td class="p-all-10">
				<input type="text" name="est_fee" id="est_fee" class="form-control input-sm" onkeypress="return isNumberKey(event)">
			</td>
			<td class="p-all-10 p-top-15">
				<label for="origination_fee" class="f-label">Origination Fee</label>
			</td>
			<td class="p-all-10">
				<input type="text" name="origination_fee" id="origination_fee" class="form-control input-sm" onkeypress="return isNumberKey(event)">
			</td>
			<td class="p-all-10 p-top-15">
				<label for="gap" class="f-label">GAP</label>
			</td>
			<td class="p-all-10">
				<input type="text" name="gap" id="gap" class="form-control input-sm" onkeypress="return isNumberKey(event)">
			</td>
			<td class="p-all-10 p-top-15">
				<label for="lti" class="f-label">LTI</label>
			</td>
			<td class="p-all-10">
				<input type="text" name="lti" id="lti" class="form-control input-sm" onkeypress="return isNumberKey(event)">
			</td>
		</tr>
	</tbody>
</table>
<table>
	<tbody>
		<tr>
			<td class="p-all-10 p-top-15">
				<label for="comprehensive" class="f-label">Comprehensive</label>
			</td>
			<td class="p-all-10">
				<input type="text" name="comprehensive" id="comprehensive" class="form-control input-sm">
			</td>
			<td class="p-all-10 p-top-15">
				<label for="rate" class="f-label">Base Rate</label>
			</td>
			<td class="p-all-10">
				<input type="text" name="rate" id="rate" class="form-control input-sm" placeholder="%" onkeypress="return isNumberKey(event)">
			</td>
			<td class="p-all-10 p-top-15">
				<label for="cust_rate" class="f-label">Customer Rate</label>
			</td>
			<td class="p-all-10">
				<input type="text" name="cust_rate" id="cust_rate" class="form-control input-sm" placeholder="%" onkeypress="return isNumberKey(event)">
			</td>
			<td class="p-all-10 p-top-15">
				<label for="frequency" class="f-label">Frequency</label>
			</td>
			<td class="p-all-10">
				<select name="frequency" id="frequency" class="form-control input-sm">
					<option value="weekly">Weekly</option>
					<option value="fortnightly">Fortnightly</option>
					<option value="monthly">Monthly</option>
				</select>
			</td>
			<td class="p-all-10 p-top-15">
				<label for="payments" class="f-label">Payments($)</label>
			</td>
			<td class="p-all-10">
				<input type="text" name="payments" id="payments" class="form-control input-sm" onkeypress="return isNumberKey(event)">
			</td>
			<td class="p-all-10 p-top-15">
				<label for="commision" class="f-label">Commision ($)</label>
			</td>
			<td class="p-all-10">
				<input type="text" name="commision" id="commision" class="form-control input-sm" onkeypress="return isNumberKey(event)">
			</td>
		</tr>
	</tbody>
</table>
<table>
	<tbody>
		<tr>
			<td class="p-all-10 p-top-15">
				<label for="total_outgoings" class="f-label">Total Outgoings</label>
			</td>
			<td class="p-all-10">
				<input type="text" name="total_outgoings" id="total_outgoings" class="form-control input-sm" onkeypress="return isNumberKey(event)">
			</td>
			<td class="p-all-10 p-top-15">
				<label for="total_expenses" class="f-label">Total Expenses</label>
			</td>
			<td class="p-all-10">
				<input type="text" name="total_expenses" id="total_expenses" class="form-control input-sm" onkeypress="return isNumberKey(event)">
			</td>
			<td class="p-all-10 p-top-15">
				<label for="surp_def_pos" class="f-label">Surplus/Deficit Position</label>
			</td>
			<td class="p-all-10">
				<input type="text" name="surp_def_pos" id="surp_def_pos" class="form-control input-sm" onkeypress="return isNumberKey(event)">
			</td>
			<td class="p-all-10 p-top-15">
				<label for="naf" class="f-label">Net Amount Finance</label>
			</td>
			<td class="p-all-10">
				<input type="text" name="naf" id="naf" class="form-control input-sm" onkeypress="return isNumberKey(event)">
			</td>
			<td class="p-all-10 p-top-15">
				<label for="fc_inc_gst" class="f-label">Field Commission Inc. GST</label>
			</td>
			<td class="p-all-10">
				<input type="text" name="fc_inc_gst" id="fc_inc_gst" class="form-control input-sm">
			</td>
			<td class="p-all-10 p-top-15">
				<label for="fc_exc_gst" class="f-label">Field Commission Exc. GST</label>
			</td>
			<td class="p-all-10">
				<input type="text" name="fc_exc_gst" id="fc_exc_gst" class="form-control input-sm">
			</td>
		</tr>
	</tbody>
</table>
<table style="width: 100%">
	<tbody>
		<tr>
			<td class="p-all-10">
				<textarea name="further_details_deals" id="further_details_deals" class="form-control input-sm" rows="1" cols="50" placeholder="Further Details..."></textarea>
			</td>
		</tr>
	</tbody>
</table>
</div>
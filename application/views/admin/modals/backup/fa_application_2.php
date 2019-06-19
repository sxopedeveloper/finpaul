<style type="text/css">

.f-label {
	display: inline-block;
	max-width: 100%;
	margin-bottom: 5px;
	font-weight: 700;
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

</style>
<div id="fapplication-modal-2" class="modal fade">
	<?php include 'fa_sidenote.php'; ?>
	<div class="modal-dialog" style="width: 95%;">
		<div class="panel-body">
			<div class="modal-wrapper">
				<div class="modal-text">
					<form method="post" action="" id="fapplication_main_form" name="fapplication_main_form">
						<input type="hidden" id="fapplication_status_id" name="fapplication_status" value="" />
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
								<thead>
									<tr>
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

						<div class="panel panel-default panel-app-inputs">
							<div class="panel-body">

								<div class="row row-input all_req_row">
									<input type="hidden" value="" id="all_req_hidden_val">
									<div class="col-md-offset-6 col-md-6">
												<select id="new_req_temp_storage" class="" hidden>
														
												</select>
										<div class="row">
											<!-- <div class="col-md-4">
												<div class="btn-group">
													<a id="pop_init" class="btn btn-primary btn-md pop_init">Init Req</a>
													<a id="pop_sett" class="btn btn-default btn-md pop_sett">Sett Req</a>
												</div>
											</div> -->
											<!-- <div class="col-md-8">
												<div class="input-group pull-right">
													<span class="input-group-addon btn btn-primary btn-md" id="add_req">Add</span>
													 <span class="input-group-addon" style="width:0px; padding-left:0px; padding-right:0px; border:none;"></span>
													<select id="new_req" class="input-group-addon form-control input-xs " style="text-align: left;">
														
													</select>
												</div>
											</div> -->
											<div class="col-md-4 col-md-offset-8">
												<a id="all_req" data-req="99" class="btn btn-primary btn-md all_req_button pull-right">Document Merger</a>
											</div>
										</div>

									</div>
								</div>
								<!-- <div class="row row-input">
									<div class="col-md-offset-8 col-md-4">

										<div class="row">
											<div class="col-md-6">
												<select class="form-control input-sm dzone_sel pull-right" name="dzone_select">
													
												</select>
											</div>
											<div class="col-md-6">
												<a id="dzone_upload"  class="btn btn-primary btn-md dzone_upload pull-right">
													Upload Requirement
												</a>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="panel panel-default">
													<div class="panel-body requirements dzone_upload" id="dzone_upload">
														<div class="row">
															<div class="col-md-6">
																<label class="f-label">Upload Requirement</label>
															</div>	
															<div class="col-md-6">
																<select class="form-control input-sm dzone_sel pull-right" name="dzone_select">
															
																</select>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div> -->
								<div class="requirements_section">
									<input type="hidden" value="" id="req_hidden_val">
									<input type="hidden" value="" id="is_temp_hidden">

									<div class="req_sec_panel">
									</div>

									<div class="req_sett_panel">
									</div>
									
									<!--  fiftyeight row -->
									<!-- <div class="row row-input">
										<input type="hidden" value="" id="req_hidden_val">
										<div class="col-md-4">

											<div class="row">
												<div class="col-md-12">
													<div class="panel panel-default">
														<div class="panel-body requirements" id="trust_deeds" data-req="1">
															<label class="f-label">Trust Deed Requested</label>
															<a class="btn btn-success btn-xs pull-right req_button">Open</a>
														</div>
													</div>
												</div>
											</div>

										</div>

										<div class="col-md-4">

											<div class="row">
												<div class="col-md-12">
													<div class="panel panel-default">
														<div class="panel-body requirements" id="privacy_consent" data-req="2">
															<label class="f-label">Send Privacy Consent</label>
															<a class="btn btn-success btn-xs pull-right req_button">Open</a>
														</div>
													</div>
												</div>
											</div>

										</div>

										<div class="col-md-4">

											<div class="row">
												<div class="col-md-12">
													<div class="panel panel-default">
														<div class="panel-body requirements" id="electronic_consent" data-req="3">
															<label class="f-label" >Electronic Privacy Consent</label>
															<a class="btn btn-success btn-xs pull-right req_button">Open</a>
														</div>
													</div>
												</div>
											</div>

										</div>

									</div> -->
									<!--  fiftyninth row -->
									<!-- <div class="row row-input">

										<div class="col-md-4">

											<div class="row">
												<div class="col-md-12">
													<div class="panel panel-default">
														<div class="panel-body requirements" id="license" data-req="4">
															<label class="f-label" >Copy of Drivers License </label>
															<a class="btn btn-success btn-xs pull-right req_button">Open</a>
														</div>
													</div>
												</div>
											</div>

										</div>

										<div class="col-md-4">

											<div class="row">
												<div class="col-md-12">
													<div class="panel panel-default">
														<div class="panel-body requirements" id="payslips" data-req="5">
															<label class="f-label" >2 x Recent Payslips</label>
															<a class="btn btn-success btn-xs pull-right req_button">Open</a>
														</div>
													</div>
												</div>
											</div>

										</div>

										<div class="col-md-4">

											<div class="row">
												<div class="col-md-12">
													<div class="panel panel-default">
														<div class="panel-body requirements" id="company_financials" data-req="6">
															<label class="f-label" >Company Financials</label>
															<a class="btn btn-success btn-xs pull-right req_button">Open</a>
														</div>
													</div>
												</div>
											</div>

										</div>

									</div> -->
									<!--  sixtieth row -->
									<!-- <div class="row row-input">

										<div class="col-md-4">

											<div class="row">
												<div class="col-md-12">
													<div class="panel panel-default">
														<div class="panel-body requirements" id="evidence_income" data-req="7">
															<label class="f-label" >Evidence of Other Income</label>
															<a class="btn btn-success btn-xs pull-right req_button">Open</a>
														</div>
													</div>
												</div>
											</div>

										</div>

									</div> -->
								</div>
								<hr>
								<div class="row row-input first_row">

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
									<div class="col-md-4">

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
								<div class="row row-input second_row">

									<div class="col-md-4">
										
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
													<label for="variant" class="f-label">Variant</label>
												</div>
												<div class="col-md-8">
													<select name="variant" id="variant" class="form-control input-sm">
													
													</select>
												</div>
										</div>

									</div>
									<div class="col-md-4">

										<div class="row">
											<div class="col-md-4">
												<label for="transmission" class="f-label">Transmission</label>
											</div>
											<div class="col-md-8">
												<select name="transmission" id="transmission" class="form-control input-sm">
													<option>Automatic</option>
													<option>Manual</option>
												</select>
											</div>
										</div>

									</div>

								</div>
								
								<!-- third row -->
								<div class="row row-input third_row">

									<div class="col-md-4">
										
											<div class="row">
												<div class="col-md-4">
													<label for="fuel" class="f-label">Fuel</label>
													
												</div>
												<div class="col-md-8">	
													<select name="fuel" id="fuel" class="form-control input-sm">
														<option value="petrol">Petrol</option>
														<option value="diesel">Diesel</option>
														<option value="hybrid">Hybrid</option>
														<option value="lpg">LPG</option>
													</select>
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
									<div class="col-md-4">

										<div class="row">
											<div class="col-md-4">
												<label for="options" class="f-label">Options</label>
											</div>
											<div class="col-md-8">
												<input type="text" name="options" id="options" class="form-control input-sm">
											</div>
										</div>

									</div>

								</div>
								
								<!-- fourth row -->
								<div class="row row-input fourth_row">

									<div class="col-md-12">
										
											<div class="row">
												<div class="col-md-12">	
													<textarea name="further_details" id="further_details" class="form-control input-sm" rows="4" cols="50" placeholder="Further Details..."></textarea>
												</div>
											</div>
										
									</div>
									
								</div>
								<hr>
								<!-- fifth row -->
								<div class="row row-input fifth_row">

									<div class="col-md-4">
										
										<div class="row">
												<div class="col-md-4">
													<label for="dealer" class="f-label">Dealer</label>
												</div>
												<div class="col-md-8">
													<input type="text" name="dealer" id="dealer" class="form-control input-sm">
												</div>
										</div>

									</div>
									<div class="col-md-4">

										<div class="row">
											<div class="col-md-4">
												<label for="delivery_date" class="f-label">Delivery Date</label>
											</div>
											<div class="col-md-8">
												<input type="delivery_date" name="delivery_date" id="delivery_date" class="form-control input-sm delivery_date">
											</div>
										</div>

									</div>

									<div class="col-md-4">
										
											<div class="row">
												<div class="col-md-4">
													<label for="dealer_contact" class="f-label">Dealer Contact</label>
													
												</div>
												<div class="col-md-8">	
													<input type="text" name="dealer_contact" id="dealer_contact" class="form-control input-sm">
												</div>
											</div>
										
									</div>

								</div>
								<!-- sixth row -->
								<div class="row row-input sixth_row">

									
									<div class="col-md-4">
										
										<div class="row">
												<div class="col-md-4">
													<label for="dealer_email" class="f-label">Dealer Email</label>
												</div>
												<div class="col-md-8">
													<input type="text" name="dealer_email" id="dealer_email" class="form-control input-sm">
												</div>
										</div>

									</div>
									<div class="col-md-4">

										<div class="row">
											<div class="col-md-4">
												<label for="dealer_mobile" class="f-label">Dealer Mobile</label>
											</div>
											<div class="col-md-8">
												<input type="text" name="dealer_mobile" id="dealer_mobile" class="form-control input-sm">
											</div>
										</div>

									</div>
									<div class="col-md-4">

										<div class="row">
											<div class="col-md-4">
												<label for="dealer_landline" class="f-label">Dealer Landline</label>
											</div>
											<div class="col-md-8">
												<input type="text" name="dealer_landline" id="dealer_landline" class="form-control input-sm">
											</div>
										</div>

									</div>

								</div>
								<hr>
								<!-- seventh row -->
								<div class="row row-input seventh_row">

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
												<label for="guarantor" class="f-label" id="f-label-guarantors">Applicants</label>
											</div>
											<div class="col-md-8">
												<select name="guarantor" id="guarantor" class="form-control input-sm">
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
								<!-- eight row -->
								<div class="row row-input eight_row">

									<div class="col-md-4">

										<div class="row">
											<div class="col-md-4">
												<label for="purchase_price" class="f-label">Purchase Price ($)</label>
											</div>
											<div class="col-md-8">
												<input type="text" name="purchase_price" id="purchase_price" class="form-control input-sm" onkeypress="return isNumberKey(event)">
											</div>
										</div>

									</div>

									<div class="col-md-4">

										<div class="row">
											<div class="col-md-4">
												<label for="deposit" class="f-label">Deposit ($)</label>
											</div>
											<div class="col-md-8">
												<input type="text" name="deposit" id="deposit" class="form-control input-sm" onkeypress="return isNumberKey(event)">
											</div>
										</div>

									</div>

									<div class="col-md-4">

										<div class="row">
											<div class="col-md-4">
												<label for="trade" class="f-label">Trade ($)</label>
											</div>
											<div class="col-md-8">
												<input type="text" name="trade" id="trade" class="form-control input-sm" onkeypress="return isNumberKey(event)">
											</div>
										</div>

									</div>

								</div>
								<!-- ninth row -->
								<div class="row row-input ninth_row">

									<div class="col-md-4">

										<div class="row">
											<div class="col-md-4">
												<label for="amt_finance" class="f-label">Amount to Finance($)</label>
											</div>
											<div class="col-md-8">
												<input type="text" name="amt_finance" id="amt_finance" class="form-control input-sm" onkeypress="return isNumberKey(event)">
											</div>
										</div>

									</div>

									<div class="col-md-4">

										<div class="row">
											<div class="col-md-4">
												<label for="term" class="f-label">Term</label>
											</div>
											<div class="col-md-8">
												<input type="text" name="term" id="term" class="form-control input-sm">
											</div>
										</div>

									</div>

									<div class="col-md-4">

										<div class="row">
											<div class="col-md-4">
												<label class="f-label">Balloon</label>
											</div>
											<div class="col-md-4">
												<input type="text" name="balloon_percentage" id="balloon_percentage" class="form-control input-sm" placeholder="%" onkeypress="return isNumberKey(event)">
											</div>
											<div class="col-md-4">
												<input type="text" name="balloon_amt" id="balloon_amt" class="form-control input-sm" placeholder="$" onkeypress="return isNumberKey(event)">
											</div>
										</div>

									</div>

								</div>
								<!-- tenth row -->
								<div class="row row-input tenth_row">

									<div class="col-md-4">

										<div class="row">
											<div class="col-md-4">
												<label for="dof" class="f-label">DOF ($)</label>
											</div>
											<div class="col-md-8">
												<input type="text" name="dof" id="dof" class="form-control input-sm">
											</div onkeypress="return isNumberKey(event)">
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

									<div class="col-md-4">

										<div class="row">
											<div class="col-md-4">
												<label for="rate" class="f-label">Rate</label>
											</div>
											<div class="col-md-8">
												<input type="text" name="rate" id="rate" class="form-control input-sm" placeholder="%" onkeypress="return isNumberKey(event)">
											</div>
										</div>

									</div>

								</div>
								<!-- eleventh row -->
								<div class="row row-input eleventh_row">

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
												<label for="gap" class="f-label">GAP</label>
											</div>
											<div class="col-md-8">
												<input type="text" name="gap" id="gap" class="form-control input-sm">
											</div>
										</div>

									</div>

									<div class="col-md-4">

										<div class="row">
											<div class="col-md-4">
												<label for="lti" class="f-label">LTI</label>
											</div>
											<div class="col-md-8">
												<input type="text" name="lti" id="lti" class="form-control input-sm">
											</div>
										</div>

									</div>

								</div>
								<!-- twelfth row -->
								<div class="row row-input twelfth_row">

									<div class="col-md-4">

										<div class="row">
											<div class="col-md-4">
												<label for="tyre_rim" class="f-label">Tyre &amp; Rim</label>
											</div>
											<div class="col-md-8">
												<input type="text" name="tyre_rim" id="tyre_rim" class="form-control input-sm">
											</div>
										</div>

									</div>

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
												<label for="lender" class="f-label">Lender</label>
											</div>
											<div class="col-md-8">
												<select name="lender" id="lender" class="form-control input-sm">
													<option value="Esanda">Esanda</option>
													<option value="St. george">St. George</option>
													<option value="Macquarie">Macquarie</option>
													<option value="Pepper">Pepper</option>
												</select>
											</div>
										</div>

									</div>

								</div>
								<!-- thirteenth row -->
								<div class="row row-input thirteenth_row">

									<div class="col-md-4">

										<div class="row">
											<div class="col-md-4">
												<label for="interest" class="f-label">Interest Paid ($)</label>
											</div>
											<div class="col-md-8">
												<input type="text" name="interest" id="interest" class="form-control input-sm" onkeypress="return isNumberKey(event)">
											</div>
										</div>

									</div>

									<div class="col-md-4">

										<div class="row">
											<div class="col-md-4">
												<label for="total_paid" class="f-label">Total Paid($)</label>
											</div>
											<div class="col-md-8">
												<input type="text" name="total_paid" id="total_paid" class="form-control input-sm" onkeypress="return isNumberKey(event)">
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

								</div>
								<!-- fourteenth row -->
								<div class="row row-input fourteenth_row">

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
								<div class="panel panel-default business-loan" hidden>
									<div class="panel-body">
										<!-- fifteenth row -->
										<div class="row row-input">

											<div class="col-md-4">

												<div class="row">
													<div class="col-md-4">
														<label for="entity_name" class="f-label">Entity Name</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="entity_name" id="entity_name" class="form-control input-sm">
													</div>
												</div>

											</div>

											<div class="col-md-4">

												<div class="row">
													<div class="col-md-4">
														<label for="trade_name" class="f-label">Trading Name</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="trade_name" id="trade_name" class="form-control input-sm">
													</div>
												</div>

											</div>

										</div>
										<!-- sixteenth row -->
										<div class="row row-input">

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
														<label for="abn_active" class="f-label">ABN active since</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="abn_active" id="abn_active" class="form-control input-sm abn_active">
													</div>
												</div>

											</div>

											<div class="col-md-4">

												<div class="row">
													<div class="col-md-4">
														<label for="gst" class="f-label">GST Registered</label>
													</div>
													<div class="col-md-8">
														<select name="gst" id="gst" class="form-control input-sm">
															<option value="yes">Yes</option>
															<option value="No">No</option>
														</select>
													</div>
												</div>

											</div>

										</div>
										<!-- seventeenth row -->
										<div class="row row-input">

											<div class="col-md-4">

												<div class="row">
													<div class="col-md-4">
														<label for="trade_add" class="f-label">Trading Address</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="trade_add" id="trade_add" class="form-control input-sm">
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
										<!-- eigteenth row -->
										<div class="row row-input">

											<div class="col-md-4">

												<div class="row">
													<div class="col-md-4">
														<label for="trade_state" class="f-label">State</label>
													</div>
													<div class="col-md-8">
														<select name="trade_state" id="trade_state" class="form-control input-sm">
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

										</div>
										<!-- nineteenth row -->
										<div class="row row-input">

											<div class="col-md-4">

												<div class="row">
													<div class="col-md-4">
														<label for="acountant" class="f-label">Acountant</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="accountant" id="acountant" class="form-control input-sm">
													</div>
												</div>

											</div>

											<div class="col-md-4">

												<div class="row">
													<div class="col-md-4">
														<label for="accountant_contact" class="f-label">Contact</label>
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
										<!-- twentieth row -->
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
										<!-- twentyfirst row -->
										<div class="row row-input">

											<div class="col-md-4">

												<div class="row">
													<div class="col-md-4">
														<label for="accountant_state" class="f-label">State</label>
													</div>
													<div class="col-md-8">
														<select name="accountant_state" id="accountant_state" class="form-control input-sm">
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

										</div>
									</div>
								</div>
								<hr>
								<!-- multiple dynamic input starts here -->
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
															<input type="text" name="title[0]" class="form-control input-sm title">
														</div>
													</div>

												</div>

											</div>
											<!-- twentythird row -->
											<div class="row row-input">

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

												<div class="col-md-4">

													<div class="row">
														<div class="col-md-4">
															<label for="surname" class="f-label">Surname</label>
														</div>
														<div class="col-md-8">
															<input type="text" name="surname[0]" class="form-control input-sm surname[0]">
														</div>
													</div>

												</div>

											</div>
											<!-- twentyfourth row -->
											<div class="row row-input">

												<div class="col-md-4">

													<div class="row">
														<div class="col-md-4">
															<label for="dob" class="f-label">Date of Birth</label>
														</div>
														<div class="col-md-8">
															<input type="text" name="dob[0]" class="form-control input-sm dob">
														</div>
													</div>

												</div>

											</div>
											<!-- twentyfifth row -->
											<div class="row row-input">

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

											</div>
											<!-- twentysixth row -->
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
															<select name="dependents[0]" class="form-control input-sm">
															<?php
																for ($i=1; $i < 11; $i++) 
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
											<!-- twentyseventh row -->
											<div class="row row-input">

												<div class="col-md-4">

													<div class="row">
														<div class="col-md-4">
															<label for="citizen_stat" class="f-label">Citizen Status</label>
														</div>
														<div class="col-md-8">
															<select name="citizen_stat[0]" class="form-control input-sm citizen_stat">
																<option value="citizen">Citizen/Permanent Resident</option>
																<option value="visitor">Visitor/Visa Holder</option>
															</select>
														</div>
													</div>

												</div>

												<div class="col-md-4">

													<div class="row">
														<div class="col-md-4">
															<label for="sex" class="f-label">Sex</label>
														</div>
														<div class="col-md-8">
															<select name="sex[0]" class="form-control input-sm sex">
																<option value="male">Male</option>
																<option value="female">Female</option>
															</select>
														</div>
													</div>

												</div>

											</div>
											<!-- twentyseventh row -->
											<div class="row row-input">

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
															<label for="visa_date" class="f-label">Visa expiry date</label>
														</div>
														<div class="col-md-8">
															<input type="text" name="visa_date[0]" class="form-control input-sm visa_date" disabled>
														</div>
													</div>

												</div>

											</div>
											<!-- twentyeight row -->
											<div class="row row-input">

												<div class="col-md-4">

													<div class="row">
														<div class="col-md-4">
															<label for="client_mobile" class="f-label">Mobile</label>
														</div>
														<div class="col-md-8">
															<input type="text" name="client_mobile[0]" class="form-control input-sm client_mobile">
														</div>
													</div>

												</div>

												<div class="col-md-4">

													<div class="row">
														<div class="col-md-4">
															<label for="client_email" class="f-label">Email</label>
														</div>
														<div class="col-md-8">
															<input type="text" name="client_email[0]" class="form-control input-sm client_email">
														</div>
													</div>

												</div>

												<div class="col-md-4">

													<div class="row">
														<div class="col-md-4">
															<label for="client_other_tel" class="f-label">Other Telephone</label>
														</div>
														<div class="col-md-8">
															<input type="text" name="client_other_tel[0]" class="form-control input-sm client_other_tel">
														</div>
													</div>

												</div>

											</div>
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
																		<label for="client_address" class="f-label">Residential Address</label>
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

														</div>
														<!-- thirtieth row -->
														<div class="row row-input">

															<div class="col-md-4">

																<div class="row">
																	<div class="col-md-4">
																		<label for="client_state" class="f-label">State</label>
																	</div>
																	<div class="col-md-8">
																		<select name="client_state[0][0]" class="form-control input-sm client_state">
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

														</div>
														<!-- thirtyfirst row -->
														<div class="row row-input">

															<div class="col-md-4">

																<div class="row">
																	<div class="col-md-4">
																		<label for="client_res_stat" class="f-label">Residential Status</label>
																	</div>
																	<div class="col-md-8">
																		<select name="client_res_stat[0][0]" class="form-control input-sm client_res_stat">
																			<option value="buying">Buying</option>
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
														<!-- hidden landlord thirtythird row-->
														<div class="row row-input landlord-hidden" hidden>

															<div class="col-md-4">

																<div class="row">
																	<div class="col-md-4">
																		<label for="landlord" class="f-label">Landlord/Realestate Name</label>
																	</div>
																	<div class="col-md-8">
																		<input type="text" name="landlord[0][0]" class="form-control input-sm landlord">
																	</div>
																</div>

															</div>

															<div class="col-md-4">

																<div class="row">
																	<div class="col-md-4">
																		<label for="landlord_number" class="f-label">Landlord/Realestate Number</label>
																	</div>
																	<div class="col-md-8">
																		<input type="text" name="landlord_number[0][0]" class="form-control input-sm landlord_number">
																	</div>
																</div>
																
															</div>

														</div>
														<!--  thirtyfourth row -->
														<div class="row row-input">

															<div class="col-md-4">

																<div class="row">
																	<div class="col-md-4">
																		<label for="monthly_commitment" class="f-label">Monthly Commitment ($)</label>
																	</div>
																	<div class="col-md-8">
																		<input type="text" name="monthly_commitment[0][0]" class="form-control input-sm monthly_commitment" onkeypress="return isNumberKey(event)">
																	</div>
																</div>

															</div>

															<div class="col-md-4">

																<div class="row">
																	<div class="col-md-4">
																		<label for="mortgage_with" class="f-label">Mortgage with</label>
																	</div>
																	<div class="col-md-8">
																		<input type="text" name="mortgage_with[0][0]" class="form-control input-sm mortgage_with">
																	</div>
																</div>

															</div>

															<div class="col-md-4">

																<div class="row">
																	<div class="col-md-4">
																		<label for="mortgage_balance" class="f-label">Mortgage Balance ($)</label>
																	</div>
																	<div class="col-md-8">
																		<input type="text" name="mortgage_balance[0][0]" class="form-control input-sm mortgage_balance" onkeypress="return isNumberKey(event)">
																	</div>
																</div>

															</div>

														</div>
														<!--  thirtyfifth row -->
														<div class="row row-input">

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
																		<label for="bank_of_applicant" class="f-label">Bank of Applicant</label>
																	</div>
																	<div class="col-md-8">
																		<input type="text" name="bank_of_applicant[0][0]" class="form-control input-sm bank_of_applicant">
																	</div>
																</div>

															</div>

														</div>
													</div>
												</div> 
											</div>
											<!-- address calause end -->
											<!-- employer clause -->
											<div class="employer_clause">
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
																		<label for="employer" class="f-label">Employer Name</label>
																	</div>
																	<div class="col-md-8">
																		<input type="text" name="employer[0][0]" class="form-control input-sm employer">
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
														<!--  thirtyseventh row -->
														<div class="row row-input">

															<div class="col-md-4">

																<div class="row">
																	<div class="col-md-4">
																		<label for="emp_address" class="f-label">Address</label>
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
														<!--  thirtyeighth row -->
														<div class="row row-input">

															<div class="col-md-4">

																<div class="row">
																	<div class="col-md-4">
																		<label for="emp_state" class="f-label">State</label>
																	</div>
																	<div class="col-md-8">
																		<select name="emp_state[0][0]" class="form-control input-sm emp_state">
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

														</div>
														<!--  thirtyninth row -->
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
																		<label for="contact_net_income" class="f-label">Net Income ($)</label>
																	</div>
																	<div class="col-md-8">
																		<input type="text" name="contact_net_income[0][0]" class="form-control input-sm contact_net_income" onkeypress="return isNumberKey(event)">
																	</div>
																</div>

															</div>

															<div class="col-md-4">

																<div class="row">
																	<div class="col-md-4">
																		<label for="overtime" class="f-label">Overtime ($)</label>
																	</div>
																	<div class="col-md-8">
																		<input type="text" name="overtime[0][0]" class="form-control input-sm overtime" onkeypress="return isNumberKey(event)">
																	</div>
																</div>

															</div>

														</div>
														<!--  fourtieth row -->
														<div class="row row-input">

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
														<!--  fourtyfirst row -->
														<div class="row row-input">

															<div class="col-md-4">

																<div class="row">
																	<div class="col-md-4">
																		<label for="other_incom" class="f-label">Other Income</label>
																	</div>
																	<div class="col-md-8">
																		<select name="other_income[0][0]" class="form-control input-sm other_income">
																			<option value="dividends">Dividends</option>
																			<option value="spouse_income">Spouse Income</option>
																			<option value="rental_income">Rental Income</option>
																			<option value="interest">Interest</option>
																			<option value="others">Others</option>
																		</select>
																	</div>
																</div>

															</div>

															<div class="col-md-4">

																<div class="row">
																	<div class="col-md-4">
																		<label for="net_per_month_other" class="f-label">Net Per Month ($)</label>
																	</div>
																	<div class="col-md-8">
																		<input type="text" name="net_per_month_other[0][0]" class="form-control input-sm net_per_month_other" onkeypress="return isNumberKey(event)">
																	</div>
																</div>

															</div>

														</div>
													</div>
												</div>
											</div>
											<!-- employer clause end-->
											<!-- credit card clause -->
											<div class="cred_card_clause">
												<div class="panel panel-default">
													<div class="panel-heading">
													    <label class="panel-title-fapplication">Credit Card 1</label>
													    <button type="button" class="btn btn-danger btn-xs pull-right remove">Remove</button>
													    <button type="button" class="btn btn-primary btn-xs pull-right add">Add</button>
													</div>
													<input type="hidden" name="credit_card_id[0][0]" class="form-control credit_card_id">
													<div class="panel-body">
														<!--  fourtysecond row -->
														<div class="row row-input">

															<div class="col-md-4">

																<div class="row">
																	<div class="col-md-4">
																		<label for="cred_card" class="f-label">Credit Card Name</label>
																	</div>
																	<div class="col-md-8">
																		<input type="text" name="cred_card[0][0]" class="form-control input-sm cred_card">
																	</div>
																</div>

															</div>

															<div class="col-md-4">

																<div class="row">
																	<div class="col-md-4">
																		<label for="cred_card_limit" class="f-label">Limit ($)</label>
																	</div>
																	<div class="col-md-8">
																		<input type="text" name="cred_card_limit[0][0]" class="form-control input-sm cred_card_limit" onkeypress="return isNumberKey(event)">
																	</div>
																</div>

															</div>

														</div>
													</div>
												</div> 
											</div>
											<!-- credit card clause end -->
											<!-- loan clause -->
											<div class="loan_clause">
												<div class="panel panel-default">
													<div class="panel-heading">
													    <label class="panel-title-fapplication">Other Loans 1</label>
													    <button type="button" class="btn btn-danger btn-xs pull-right remove">Remove</button>
													    <button type="button" class="btn btn-primary btn-xs pull-right add">Add</button>
													</div>
													<input type="hidden" name="other_loans_id[0][0]" class="form-control other_loans_id">
													<div class="panel-body">
														<!--  fourtythird row -->
														<div class="row row-input">

															<div class="col-md-4">

																<div class="row">
																	<div class="col-md-4">
																		<label for="other_loans" class="f-label">Loan Name</label>
																	</div>
																	<div class="col-md-8">
																		<input type="text" name="other_loans[0][0]" class="form-control input-sm other_loans">
																	</div>
																</div>

															</div>

															<div class="col-md-4">

																<div class="row">
																	<div class="col-md-4">
																		<label for="loan_commitment" class="f-label">Monthly Commitment ($)</label>
																	</div>
																	<div class="col-md-8">
																		<input type="text" name="loan_commitment[0][0]" class="form-control input-sm loan_commitment" onkeypress="return isNumberKey(event)">
																	</div>
																</div>

															</div>

															<div class="col-md-4">

																<div class="row">
																	<div class="col-md-4">
																		<label for="loan_financier" class="f-label">Financier</label>
																	</div>
																	<div class="col-md-8">
																		<input type="text" name="loan_financier[0][0]" class="form-control input-sm loan_financier">
																	</div>
																</div>

															</div>

														</div>

													</div>
												</div> 
											</div>
											<!--loan clause end-->
											<!-- credit reference clause -->
											<div class="cred_reference_clause">
												<div class="panel panel-default">
													<div class="panel-heading">
													    <label class="panel-title-fapplication">Credit Reference 1</label>
													    <button type="button" class="btn btn-danger btn-xs pull-right remove">Remove</button>
													    <button type="button" class="btn btn-primary btn-xs pull-right add">Add</button>
													</div>
													<input type="hidden" name="credit_reference_id[0][0]" class="form-control credit_reference_id">
													<div class="panel-body">
														<!--  fourtyfourth row -->
														<div class="row row-input">

															<div class="col-md-4">

																	<div class="row">
																		<div class="col-md-4">
																			<label for="goods_financed" class="f-label">Goods Financed</label>
																		</div>
																		<div class="col-md-8">
																			<input type="text" name="goods_financed[0][0]" class="form-control input-sm goods_financed">
																		</div>
																	</div>

															</div>

															<div class="col-md-4">

																<div class="row">
																	<div class="col-md-4">
																		<label for="goods_financier" class="f-label">Goods Financier</label>
																	</div>
																	<div class="col-md-8">
																		<input type="text" name="goods_financier[0][0]" class="form-control input-sm goods_financier">
																	</div>
																</div>

															</div>

															<div class="col-md-4">

																<div class="row">
																	<div class="col-md-4">
																		<label for="goods_amt_financed" class="f-label">Amount Financed ($)</label>
																	</div>
																	<div class="col-md-8">
																		<input type="text" name="goods_amt_financed[0][0]" class="form-control input-sm goods_amt_financed" onkeypress="return isNumberKey(event)">
																	</div>
																</div>

															</div>

														</div>
														<!--  fourtyfifth row -->
														<div class="row row-input">

															<div class="col-md-4">

																<div class="row">
																	<div class="col-md-4">
																		<label for="goods_repayments" class="f-label">Repayments ($)</label>
																	</div>
																	<div class="col-md-8">
																		<input type="text" name="goods_repayments[0][0]" class="form-control input-sm goods_repayments" onkeypress="return isNumberKey(event)">
																	</div>
																</div>

															</div>

															<div class="col-md-4">

																<div class="row">
																	<div class="col-md-4">
																		<label for="goods_term" class="f-label">Term</label>
																	</div>
																	<div class="col-md-8">
																		<input type="text" name="goods_term[0][0]" class="form-control input-sm goods_term">
																	</div>
																</div>

															</div>

															<div class="col-md-4">

																<div class="row">
																	<div class="col-md-4">
																		<label for="goods_date_finalized" class="f-label">Date Finalized</label>
																	</div>
																	<div class="col-md-8">
																		<input type="text" name="goods_date_finalized[0][0]" class="form-control input-sm goods_date_finalized">
																	</div>
																</div>

															</div>

														</div>

													</div>
												</div> 
											</div>	
											<!--credit reference clause end-->
											<!-- property clause -->
											<div class="property_clause">
												<div class="panel panel-default">
													<div class="panel-heading">
													    <label class="panel-title-fapplication">Property Assets 1</label>
													    <button type="button" class="btn btn-danger btn-xs pull-right remove">Remove</button>
													    <button type="button" class="btn btn-primary btn-xs pull-right add">Add</button>
													</div>
													<input type="hidden" name="property_id[0][0]" class="form-control property_id">
													<div class="panel-body">
														<!--  fourtysixth row -->
														<div class="row row-input">

															<div class="col-md-4">

																<div class="row">
																	<div class="col-md-4">
																		<label for="property_add" class="f-label">Property Address</label>
																	</div>
																	<div class="col-md-8">
																		<input type="text" name="property_add[0][0]" class="form-control input-sm property_add">
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

														</div>
														<!--  fourtyseventh row -->
														<div class="row row-input">

															<div class="col-md-4">

																<div class="row">
																	<div class="col-md-4">
																		<label for="property_state" class="f-label">State</label>
																	</div>
																	<div class="col-md-8">
																		<select name="property_state[0][0]" class="form-control input-sm property_state">
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

														</div>
														<!--  fourtyeight row -->
														<div class="row row-input">

															<div class="col-md-4">

																<div class="row">
																	<div class="col-md-4">
																		<label for="property_mortgage" class="f-label">Mortgage With</label>
																	</div>
																	<div class="col-md-8">
																		<input type="text" name="property_mortgage[0][0]" class="form-control input-sm property_mortgage">
																	</div>
																</div>

															</div>

															<div class="col-md-4">

																<div class="row">
																	<div class="col-md-4">
																		<label for="property_mortgage_commitment" class="f-label">Mortgage Commitment</label>
																	</div>
																	<div class="col-md-8">
																		<input type="text" name="property_mortgage_commitment[0][0]" class="form-control input-sm property_mortgage_commitment">
																	</div>
																</div>

															</div>

															<div class="col-md-4">

																<div class="row">
																	<div class="col-md-4">
																		<label for="property_mortgage_balance" class="f-label">Balance</label>
																	</div>
																	<div class="col-md-8">
																		<input type="text" name="property_mortgage_balance[0][0]" class="form-control input-sm property_mortgage_balance">
																	</div>
																</div>

															</div>

														</div>
														<!--  fourtyninth row -->
														<div class="row row-input">

															<div class="col-md-4">

																<div class="row">
																	<div class="col-md-4">
																		<label for="property_rental_income" class="f-label">Monthly Rental Income</label>
																	</div>
																	<div class="col-md-8">
																		<input type="text" name="property_rental_income[0][0]" class="form-control input-sm property_rental_income">
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

														</div>

													</div>
												</div> 
											</div>
											<!--property clause ends-->
											<!--  fiftieth row -->
											<div class="row row-input">

												<div class="col-md-4">

													<div class="row">
														<div class="col-md-4">
															<label for="cash_savings" class="f-label">Cash Savings ($)</label>
														</div>
														<div class="col-md-8">
															<input type="text" name="cash_savings[0]" class="form-control input-sm cash_savings" onkeypress="return isNumberKey(event)">
														</div>
													</div>

												</div>

												<div class="col-md-4">

													<div class="row">
														<div class="col-md-4">
															<label for="personal_effects" class="f-label">Personal Effects</label>
														</div>
														<div class="col-md-8">
															<input type="text" name="personal_effects[0]" class="form-control input-sm personal_effects" onkeypress="return isNumberKey(event)">
														</div>
													</div>

												</div>

												<div class="col-md-4">

													<div class="row">
														<div class="col-md-4">
															<label for="shares_investments" class="f-label">Shares &amp; Investments ($)</label>
														</div>
														<div class="col-md-8">
															<input type="text" name="shares_investments[0]" class="form-control input-sm shares_investments" onkeypress="return isNumberKey(event)">
														</div>
													</div>

												</div>

											</div>
											<!--  fiftyfirst row -->
											<div class="row row-input">

												<div class="col-md-4">

													<div class="row">
														<div class="col-md-4">
															<label for="superannuation" class="f-label">Superannuation ($)</label>
														</div>
														<div class="col-md-8">
															<input type="text" name="superannuation[0]" class="form-control input-sm superannuation" onkeypress="return isNumberKey(event)">
														</div>
													</div>

												</div>

											</div>
											<!-- personal vehicle clause -->
											<div class="personal_vehicle_clause">
												<div class="panel panel-default">
													<div class="panel-heading">
													    <label class="panel-title-fapplication">Vehicle Asset 1</label>
													    <button type="button" class="btn btn-danger btn-xs pull-right remove">Remove</button>
													    <button type="button" class="btn btn-primary btn-xs pull-right add">Add</button>
													</div>
													<input type="hidden" name="personal_vehicle_id[0][0]" class="form-control personal_vehicle_id">
													<div class="panel-body">
														<!--  fiftysecond row -->
														<div class="row row-input">

															<div class="col-md-4">

																<div class="row">
																	<div class="col-md-4">
																		<label for="personal_vehicle" class="f-label">Motor Vehicle</label>
																	</div>
																	<div class="col-md-8">
																		<input type="text" name="personal_vehicle[0][0]" class="form-control input-sm personal_vehicle">
																	</div>
																</div>

															</div>

															<div class="col-md-4">

																<div class="row">
																	<div class="col-md-4">
																		<label for="personal_vehicle_value" class="f-label">Value ($)</label>
																	</div>
																	<div class="col-md-8">
																		<input type="text" name="personal_vehicle_value[0][0]" class="form-control input-sm personal_vehicle_value" onkeypress="return isNumberKey(event)">
																	</div>
																</div>

															</div>

														</div>
													</div>
												</div>
											</div>
											<!-- personal vehicle clause end -->
											<!--  asset clause -->
											<div class="asset_clause">
												<div class="panel panel-default">
													<div class="panel-heading">
													    <label class="panel-title-fapplication">Other Asset 1</label>
													    <button type="button" class="btn btn-danger btn-xs pull-right remove">Remove</button>
													    <button type="button" class="btn btn-primary btn-xs pull-right add">Add</button>
													</div>
													<input type="hidden" name="other_asset_id[0][0]" class="form-control other_asset_id">
													<div class="panel-body">
														<!--  fiftythird row -->
														<div class="row row-input">

															<div class="col-md-4">

																<div class="row">
																	<div class="col-md-4">
																		<label for="asset" class="f-label">Goods</label>
																	</div>
																	<div class="col-md-8">
																		<input type="text" name="asset[0][0]" class="form-control input-sm asset">
																	</div>
																</div>

															</div>

															<div class="col-md-4">

																<div class="row">
																	<div class="col-md-4">
																		<label for="asset_value" class="f-label">Value ($)</label>
																	</div>
																	<div class="col-md-8">
																		<input type="text" name="asset_value[0][0]" class="form-control input-sm asset_value" onkeypress="return isNumberKey(event)">
																	</div>
																</div>

															</div>

														</div>
													</div>
												</div>
											</div>
											<!-- asset clause end -->
											<!-- consumer clause -->
											<div class="consumer_clause">

												<!--  fiftyfourth row -->
												<div class="row row-input">

													<div class="col-md-4">

														<div class="row">
															<div class="col-md-4">
																<label for="food_beverage" class="f-label">Food and Beverage per month ($)</label>
															</div>
															<div class="col-md-8">
																<input type="text" name="food_beverage[0]" class="form-control input-sm food_beverage" onkeypress="return isNumberKey(event)">
															</div>
														</div>

													</div>

													<div class="col-md-4">

														<div class="row">
															<div class="col-md-4">
																<label for="fuel_power" class="f-label">Fuel &amp; Power per month ($)</label>
															</div>
															<div class="col-md-8">
																<input type="text" name="fuel_power[0]" class="form-control input-sm fuel_power" onkeypress="return isNumberKey(event)">
															</div>
														</div>

													</div>

													<div class="col-md-4">

														<div class="row">
															<div class="col-md-4">
																<label for="communications" class="f-label">Communications per month ($)</label>
															</div>
															<div class="col-md-8">
																<input type="text" name="communications[0]" class="form-control input-sm communications" onkeypress="return isNumberKey(event)">
															</div>
														</div>

													</div>

												</div>
												<!--  fiftyfith row -->
												<div class="row row-input">

													<div class="col-md-4">

														<div class="row">
															<div class="col-md-4">
																<label for="clothing_footwear" class="f-label">Clothing &amp; Footwear per month ($)</label>
															</div>
															<div class="col-md-8">
																<input type="text" name="clothing_footwear[0]" class="form-control input-sm clothing_footwear" onkeypress="return isNumberKey(event)">
															</div>
														</div>

													</div>

													<div class="col-md-4">

														<div class="row">
															<div class="col-md-4">
																<label for="medical_health" class="f-label">Medical &amp; Health per month ($)</label>
															</div>
															<div class="col-md-8">
																<input type="text" name="medical[0]" class="form-control input-sm medical" onkeypress="return isNumberKey(event)">
															</div>
														</div>

													</div>

													<div class="col-md-4">

														<div class="row">
															<div class="col-md-4">
																<label for="transportation" class="f-label">Transportation per month ($)</label>
															</div>
															<div class="col-md-8">
																<input type="text" name="transportation[0]" class="form-control input-sm transportation" onkeypress="return isNumberKey(event)">
															</div>
														</div>

													</div>

												</div>

												<!--  fiftysixth row -->
												<div class="row row-input">

													<div class="col-md-4">

														<div class="row">
															<div class="col-md-4">
																<label for="recreation" class="f-label">Recreation per month ($)</label>
															</div>
															<div class="col-md-8">
																<input type="text" name="recreation[0]" id="recreation" class="form-control input-sm recreation" onkeypress="return isNumberKey(event)">
															</div>
														</div>

													</div>

												</div>

											</div>
											<!--consumer clause end-->
										</div>
									</div>
								</div>
								<!-- multiple dynamic input ends here -->
								<hr>
								<!-- fiftyseventh row -->
								<div class="row row-input fiftyseventh_row">

									<div class="col-md-12">
										
											<div class="row">
												<div class="col-md-12">	
													<textarea name="borrowers_statement" id="borrowers_statement" class="form-control input-sm" rows="4" cols="50" placeholder="Borrowers Statement..."></textarea>
												</div>
											</div>
										
									</div>
									
								</div>

								

							</div>
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
<!-- 						<div class="panel panel-default">
							<div class="panel-heading">
							    <label class="panel-title-fapplication">Files Uploaded</label>
							</div>
							<div class="panel-body panel-filters">
								<div class="row">
									<div class="col-md-12">
										<div id="dropzone_fapplication" class="dropzone dropzone-previews dz-clickable"></div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12" id="file_attachments_panel">
										<ul></ul>
									</div>
								</div>
							</div>
						</div> -->
						<br />
						<div id="fapplication_comments"></div>
						<br />
						<div class="col-md-12 text-left" id="fapplication_email_actions"></div>
						<div class="col-md-12 text-left">
							<br />
							<input type="hidden" id="fapplication_id" name="fapplication_id" value="" />
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




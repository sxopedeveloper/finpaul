<style type="text/css">

	/*floating menu start*/
	.side_bar_buttons_container{
		right: 0px;
	    top: 10px;
	    position: fixed;
	    z-index: 2147483647;
	}

	.side_bar_button{
		height: 43px;
		width: 40px;
		background-color: #000;
	    opacity: .80;
	    border-radius: 8px 0px 0px 8px;
	    padding: 7px;
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
		margin-bottom: 2px;
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
	.hide_req{
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

	.ui-state-default{
		cursor: pointer;
		cursor: hand;
	}
	.email_popup{
		cursor: pointer;
		cursor: hand;	
	}
	.abn_popup{
		cursor: pointer;
		cursor: hand;	
	}
	.pac-container {
	    z-index: 10000000000000000000000000000 !important;
	}
	.tooltip{
	  z-index: 1000000000000000000000 !important;
	}

	.full_loader{
		z-index: 10000000000000000000000000000 !important;	
	}

	.p-all-10{
		padding-left: 7px;
		padding-right: 7px
	}
	.p-top-15{
		padding-top: 10px;
	}

	#make{
		width: 134px;
	}
	#model{
		width: 134px;
	}

	.panel-body{
		padding-bottom: 5px !important;
	}

	.google_address{
		width: 250px;
	}

	#fapplication_main_form .form-control input-sm{
		font-weight: bold;
	}

	.bootstrap-tagsinput{
		margin-bottom: 0px !important;
		line-height: 24px !important;
		border-radius: 0px !important;
	}
	.label-info{
		background: #58c603 !important;
	}
	.dz-upload { 
	    display: block; 
	    background-color: red; 
	    height: 10px;
	    width: 0%;
	}
	.form-group{
		padding-left: 5px !important;
		padding-right: 5px !important;
		margin-bottom: 5px !important;
	}
	.btn-full{
		width: 100% !important;
	}
</style>
<div id="fapplication-modal-4" class="modal fade">
	<?php include 'fa_sidenote.php'; ?>
	<?php include 'floating_menu.php'; ?>
	<?php include 'fa_req_list_modal.php'; ?>
	<div class="modal-dialog" style="width: 95%;">
		<div class="panel-body">
			<div class="modal-wrapper">
				<div class="modal-text">
					<form method="post" action="" id="fapplication_main_form" name="fapplication_main_form">
						<input type="hidden" id="fapplication_status_id" name="fapplication_status" value="" />
						<input type="hidden" id="fq_admin_flag" value="" >
						<input type="hidden" id="fqa_number" value="" />
						<div class="alert alert-warning" id="temp_user_div" hidden>
							Temporarily assigned to <strong id="temp_user_name"></strong> 
						</div>
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
						<hr>
						<div class="toogle" data-plugin-toggle="">
							<section class="toggle" id="requirements_tab_panel">
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
							<section class="toggle" id="deal_structure">
								<label>DEAL STRUCTURE</label>
								<div class="toggle-content" style="padding: 10px;">

									<div class="row row-input">
										<div class="col-md-2">
											
											<div class="row">
												<div class="col-md-5">
													<label for="purchase_price" class="f-label">Purchase Price</label>
													
												</div>
												<div class="col-md-7">	
													<input type="text" name="purchase_price" class="form-control input-sm" id="purchase_price" onkeypress="return isNumberKey(event)" value="0.00">
												</div>
											</div>
											
										</div>
										<div class="col-md-2">
											
											<div class="row">
												<div class="col-md-5">
													<label for="book_value" class="f-label">Book Value</label>
													
												</div>
												<div class="col-md-7">	
													<input type="text" name="book_value" class="form-control input-sm" id="book_value" onkeypress="return isNumberKey(event)" value="0.00">
												</div>
											</div>
											
										</div>
										<div class="col-md-2">
											
											<div class="row">
												<div class="col-md-5">
													<label for="deposit" class="f-label">Deposit</label>
												</div>
												<div class="col-md-7">
													<div class="input-group">
														<input type="text" name="deposit" class="form-control input-sm" id="deposit" value="0.00">
														<span class="input-group-addon">
															<input type="checkbox" name="deposit_check" id="deposit_check" value="1" data-toggle="tooltip" data-placement="top" title="By ticking this box, the deposit refunded back to the client and not taken into the account.">
														</span>
													</div>
												</div>
											</div>
											
										</div>
										<div class="col-md-2">
											
											<div class="row">
												<div class="col-md-5">
													<label for="trade" class="f-label">Trade Value</label>
													
												</div>
												<div class="col-md-7">	
													<!-- <input type="text" name="trade" class="form-control input-sm" id="trade" onkeypress="return isNumberKey(event)" value="0.00"> -->
													<div class="input-group">
														<input type="text" name="trade" class="form-control input-sm" id="trade" onkeypress="return isNumberKey(event)" value="0.00">
														<span class="input-group-addon">
															<input type="checkbox" name="trade_check" id="trade_check" value="1" data-toggle="tooltip" data-placement="top" title="By ticking this box, tradein value will not be included in the tax invoice.">
														</span>
													</div>
												</div>
											</div>
											
										</div>
										<div class="col-md-2">
											
											<div class="row">
												<div class="col-md-5">
													<label for="payout" class="f-label">Payout</label>
													
												</div>
												<div class="col-md-7">	
													<input type="text" name="payout" class="form-control input-sm" id="payout" onkeypress="return isNumberKey(event)" value="0.00">
												</div>
											</div>
											
										</div>
									
										<!-- <div class="col-md-2">
											
											<div class="row">
												<div class="col-md-5">
													<label for="amt_to_finance" class="f-label">Amt to Finance</label>
													
												</div>
												<div class="col-md-7">	
													<input type="text" name="amt_to_finance" class="form-control input-sm" id="amt_to_finance" onkeypress="return isNumberKey(event)" value="0.00">
												</div>
											</div>
											
										</div> -->
									
										<div class="col-md-2">
											
											<div class="row">
												<div class="col-md-5">
													<label for="term" class="f-label">Term</label>
													
												</div>
												<div class="col-md-7">	
													<select class="form-control input-sm" id="term" name="term">
														<option value="12">12</option>
														<option value="24">24</option>
														<option value="36">36</option>
														<option value="48">48</option>
														<option value="60">60</option>
														<option value="72">72</option>
														<option value="84">84</option>
													</select>
												</div>
											</div>
											
										</div>
									</div>
									<div class="row row-input">
										<div class="col-md-2">
											<div class="row">
												<div class="col-md-5">
													<label class="f-label">Balloon $</label>
												</div>
												<div class="col-md-7">
													<input type="text" name="balloon_amt" id="balloon_amt" class="form-control input-sm" placeholder="$" onkeypress="return isNumberKey(event)" value="0.00">
												</div>
											</div>
										</div>
										<div class="col-md-2">
											<div class="row">
												<div class="col-md-5">
													<label class="f-label">Balloon %</label>
												</div>
												<div class="col-md-7">
													<input type="text" name="balloon_percentage" id="balloon_percentage" class="form-control input-sm" placeholder="%" onkeypress="return isNumberKey(event)" value="0.00">
												</div>
											</div>
										</div>
										<div class="col-md-2">
											<div class="row">
												<div class="col-md-5">
													<label for="lender" class="f-label">Lender</label>
												</div>
												<div class="col-md-7">
													<select name="lender" id="lender" class="form-control input-sm">
														<option value="ANZ">ANZ</option>
														<option value="St. George">St. George</option>
														<option value="Macquarie">Macquarie</option>
														<option value="Pepper">Pepper</option>
														<option value="PCCU">PCCU</option>
														<option value="Liberty">Liberty</option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-md-2">
											<div class="row">
												<div class="col-md-5">
													<label for="est_fee" class="f-label">Est Fee ($)</label>
												</div>
												<div class="col-md-7">
													<input type="text" name="est_fee" id="est_fee" class="form-control input-sm" onkeypress="return isNumberKey(event)">
												</div>
											</div>
										</div>
										<div class="col-md-2">
											<div class="row">
												<div class="col-md-5">
													<label for="origination_fee" class="f-label">Orig Fee</label>
												</div>
												<div class="col-md-7">
													<input type="text" name="origination_fee" id="origination_fee" class="form-control input-sm" onkeypress="return isNumberKey(event)">
												</div>
											</div>
										</div>
										<div class="col-md-2">
											<div class="row">
												<div class="col-md-5">
													<label for="gap" class="f-label">GAP</label>
												</div>
												<div class="col-md-7">
													<input type="text" name="gap" id="gap" class="form-control input-sm" onkeypress="return isNumberKey(event)">
												</div>
											</div>
										</div>
									</div>
									<div class="row row-input">
										
										<div class="col-md-2">
											<div class="row">
												<div class="col-md-5">
													<label for="lti" class="f-label">LTI</label>
												</div>
												<div class="col-md-7">
													<input type="text" name="lti" id="lti" class="form-control input-sm" onkeypress="return isNumberKey(event)">
												</div>
											</div>
										</div>
										<div class="col-md-2">
											<div class="row">
												<div class="col-md-5">
													<label for="comprehensive" class="f-label">Comp Ins.</label>
												</div>
												<div class="col-md-7">
													<input type="text" name="comprehensive" id="comprehensive" class="form-control input-sm">
												</div>
											</div>
										</div>
										<div class="col-md-2">
											<div class="row">
												<div class="col-md-5">
													<label for="rate" class="f-label">Base Rate</label>
												</div>
												<div class="col-md-7">
													<input type="text" name="rate" id="rate" class="form-control input-sm" placeholder="%" onkeypress="return isNumberKey(event)">
												</div>
											</div>
										</div>
										<div class="col-md-2">
											<div class="row">
												<div class="col-md-5">
													<label for="cust_rate" class="f-label">Cust Rate</label>
												</div>
												<div class="col-md-7">
													<input type="text" name="cust_rate" id="cust_rate" class="form-control input-sm" placeholder="%" onkeypress="return isNumberKey(event)">
												</div>
											</div>
										</div>
										<div class="col-md-2">
											<div class="row">
												<div class="col-md-5">
													<label for="frequency" class="f-label">Frequency</label>
												</div>
												<div class="col-md-7">
													<select name="frequency" id="frequency" class="form-control input-sm">
														<option value="weekly">Weekly</option>
														<option value="fortnightly">Fortnightly</option>
														<option value="monthly">Monthly</option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-md-2">
											<div class="row">
												<div class="col-md-5">
													<label for="fc_inc_gst" class="f-label">Arrears/Ad</label>
												</div>
												<div class="col-md-7">
													<select class="form-control input-sm" id="arrears" name="arrears">
														<option value="Arrears" data-type="0" selected="selected">Arrears</option>
														<option value="Advance" data-type="1">Advance</option>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="row row-input">
										
										<div class="col-md-2">
											<div class="row">
												<div class="col-md-5">
													<label for="total_outgoings" class="f-label">Outgoings</label>
												</div>
												<div class="col-md-7">
													<input type="text" name="total_outgoings" id="total_outgoings" class="form-control input-sm" onkeypress="return isNumberKey(event)">
												</div>
											</div>
										</div>
										<div class="col-md-2">
											<div class="row">
												<div class="col-md-5">
													<label for="total_income" class="f-label">Income</label>
												</div>
												<div class="col-md-7">
													<input type="text" name="total_income" id="total_income" class="form-control input-sm" onkeypress="return isNumberKey(event)">
												</div>
											</div>
										</div>
										<div class="col-md-2">
											<div class="row">
												<div class="col-md-5">
													<label for="surp_def_pos" class="f-label">Surp/Def</label>
												</div>
												<div class="col-md-7">
													<input type="text" name="surp_def_pos" id="surp_def_pos" class="form-control input-sm" onkeypress="return isNumberKey(event)">
												</div>
											</div>
										</div>
										<div class="col-md-2">
											<div class="row">
												<div class="col-md-5">
													<label for="naf" class="f-label">NAF</label>
												</div>
												<div class="col-md-7">
													<input type="text" name="naf" id="naf" class="form-control input-sm" onkeypress="return isNumberKey(event)">
												</div>
											</div>
										</div>
										<div class="col-md-2">
											<div class="row">
												<div class="col-md-5">
													<label for="commision" class="f-label">Commision</label>
												</div>
												<div class="col-md-7">
													<input type="text" name="commision" id="commision" class="form-control input-sm" onkeypress="return isNumberKey(event)">
												</div>
											</div>
										</div>
										<div class="col-md-2">
											<div class="row">
												<div class="col-md-5">
													<label for="payments" class="f-label">Payments($)</label>
												</div>
												<div class="col-md-7">
													<input type="text" name="payments" id="payments" class="form-control input-sm" onkeypress="return isNumberKey(event)">
												</div>
											</div>
										</div>
									</div>
								</div>
							</section>
						</div>
						<div class="toogle" data-plugin-toggle="">
							<section class="toggle" id="application_section">
								<label>APPLICATION FIELDS</label>
								<div class="toggle-content" style="display: block; margin-top: 15px;" id="application_fields">
									<div class="row temp_parent_panel">
										<div class="col-md-6 left">
											<div class="row top-fields" style="margin-left: -5px; margin-right: -5px;">
												<div class="form-group col-md-6">
													<label for="loan_use" class="f-label">Loan Use</label>
													<select name="loan_use" id="loan_use" class="form-control input-sm loan_use">
														<option value="consumer">Consumer</option>
														<option value="business">Business</option>
													</select>
												</div>
												<div class="form-group col-md-6">
													<label for="cust_type" class="f-label">Customer Type</label>
													<select name="cust_type" id="cust_type" class="form-control input-sm cust_type">
														<option></option>
														<option value="joint">Joint</option>
														<option value="individual">Individual</option>
													</select>
												</div>
											</div>
											<div class="multiple_dynamic" id="multiple_dynamic">
												<div class="panel panel-default panel-main">
													<div class="panel-heading panel-applicant">
													    <label class="panel-title-fapplication panel-title-main" >Applicant 1</label>
													    <button type="button" class="btn btn-danger btn-xs pull-right applicant-remove">Remove</button>
													    <button type="button" class="btn btn-primary btn-xs pull-right applicant-add">Add</button>
													</div>
													<input type="hidden" name="applicant_id[0]" class="form-control input-sm applicant_id">
													<div class="panel-body panel-applicant-body" style="background: #d2ffbf">
														<!-- twentysecond row -->
														<div class="applicant_info">
															<div class="row">
																<div class="form-group col-md-3">
																	<label for="title" class="f-label">Title</label>
																	<select name="title[0]" class="form-control input-sm title">
																		<option value="Mr.">Mr</option>
																		<option value="Mrs.">Mrs</option>
																		<option value="Ms.">Ms</option>
																	</select>
																</div>
																<div class="form-group col-md-3">
																	<label for="first_name" class="f-label">First name</label>
																	<input type="text" name="first_name[0]" class="form-control input-sm first_name">
																</div>
																<div class="form-group col-md-3">
																	<label for="middle_name" class="f-label">Middle name</label>
																	<input type="text" name="middle_name[0]" class="form-control input-sm middle_name">
																</div>
																<div class="form-group col-md-3">
																	<label for="last_name" class="f-label">Surname</label>
																	<input type="text" name="last_name[0]" class="form-control input-sm last_name">
																</div>
															</div>
															<div class="row">
																<div class="form-group col-md-4">
																	<label for="mobile" class="f-label">Primary Number</label>
																	<input type="text" name="mobile[0]" class="form-control input-sm mobile masked">
																</div>
																<div class="form-group col-md-4">
																	<label for="other_telephone" class="f-label">Secondary Number</label>
																	<input type="text" name="other_telephone[0]" class="form-control input-sm other_telephone masked">
																</div>
																<div class="form-group col-md-4">
																	<label for="email" class="f-label">Email</label>
																	<div class="input-group email_group">
																		<input type="text" name="email[0]" class="form-control input-sm email">
																		<span class="input-group-addon email_popup">@</span>
																	</div>
																</div>
															</div>
															<div class="row">
																<div class="form-group col-md-3">
																	<label for="date_of_birth" class="f-label">Date of Birth</label>
																	<input type="text" name="date_of_birth[0]" class="form-control input-sm date_of_birth" >
																</div>
																<div class="form-group col-md-3">
																	<label for="marital_stat" class="f-label">Marital Status</label>
																	<select name="marital_stat[0]" class="form-control input-sm marital_stat">
																		<option value=""> - Please Choose - </option>
																		<option value="married">Married</option>
																		<option value="single">Single</option>
																		<option value="defacto">Defacto</option>
																		<option value="widowed">Widowed</option>
																		<option value="divorced">Divorced</option>
																		<option value="separated">Separated</option>
																	</select>
																</div>
																<div class="form-group col-md-3">
																	<label for="dependents" class="f-label">Dependents</label>
																	<select name="dependents[0]" class="form-control input-sm dependents">
																	<?php
																		for ($i=0; $i < 12; $i++) 
																		{ 
																			echo "<option value='{$i}'>{$i}</option>";
																		}
																	?>	
																	</select>
																</div>
																<div class="form-group col-md-3">
																	<label for="ages" class="f-label">Ages</label>
																	<input type="text" name="ages[0]" class="form-control input-sm ages">
																</div>
															</div>
															<div class="row">
																<div class="form-group col-md-3">
																	<label for="dl_number" class="f-label">Driving License No.</label>
																	<input type="text" name="dl_number[0]" class="form-control input-sm dl_number">
																</div>
																<div class="form-group col-md-3">
																	<label for="dl_exp" class="f-label">Expiry Date</label>
																	<input type="text" name="dl_exp[0]" class="form-control input-sm dl_exp">
																</div>
																<div class="form-group col-md-3">
																	<label for="dl_state" class="f-label">State</label>
																	<select name="dl_state[0]" class="form-control input-sm dl_state">
																		<option value=""> - Please Choose - </option>
																		<option value="nsw">NSW</option>
																		<option value="vic">VIC</option>
																		<option value="qld">QLD</option>
																		<option value="wa">WA</option>
																		<option value="tas">TAS</option>
																		<option value="nt">NT</option>
																	</select>
																</div>
																<div class="form-group col-md-3">
																	<label for="dl_type" class="f-label">License Type</label>
																	<select name="dl_type[0]" class="form-control input-sm dl_type">
																		<option value="full">Full</option>
																		<option value="heavy_duty">Heavy Duty</option>
																		<option value="learner">Learner</option>
																		<option value="private_plate">Private Plate</option>
																		<option value="pensioner">Pensioner</option>
																		<option value="professional">Professional</option>
																	</select>
																</div>
															</div>
															<div class="address-clause">
																<div class="initial_address_panel">
																	<input type="hidden" name="address_id[0][0]" class="form-control address_id">
																	<div class="row">
																		<div class="form-group col-md-12">
																			<label for="client_address" class="f-label">Street Address</label>
																			<div class="input-group email_group">
																				<input type="text" name="client_address[0][0]" class="form-control input-sm client_address google_address" style="width: 100%">
																				<span class="input-group-addon">
																					<input type="checkbox" data-toggle="tooltip" data-placement="top" title="Visa Holder" name="visa_holder[0]" class="visa_holder">
																				</span>
																			</div>
																		</div>
																	</div>
																	<div class="row">
																		<div class="form-group col-md-4">
																			<label for="client_suburb" class="f-label">Suburb</label>
																			<input type="text" name="client_suburb[0][0]" class="form-control input-sm client_suburb google_suburb">
																		</div>
																		<div class="form-group col-md-4">
																			<label for="client_post_code" class="f-label">Post Code</label>
																			<input type="text" name="client_post_code[0][0]" class="form-control input-sm client_post_code google_postcode">
																		</div>
																		<div class="form-group col-md-4">
																			<label for="client_state" class="f-label">State</label>
																			<select name="client_state[0][0]" class="form-control input-sm client_state">
																				<option name="state" value="">-State-</option>
																				<option name="state" value="ACT" >ACT</option>
																				<option name="state" value="NSW" >NSW</option>
																				<option name="state" value="NT" >NT</option>
																				<option name="state" value="QLD" >QLD</option>
																				<option name="state" value="SA" >SA</option>
																				<option name="state" value="TAS" >TAS</option>
																				<option name="state" value="VIC" >VIC</option>
																				<option name="state" value="WA" >WA</option>
																			</select>
																		</div>
																	</div>
																	<div class="row">
																		<div class="form-group col-md-2">
																			<label  class="f-label">Time</label>
																			<select name="time_address_years[0][0]" class="form-control input-sm time_address_years time_add">
																			<?php
																				for ($i=0; $i < 100; $i++) 
																				{ 
																					echo "<option value='{$i}'>{$i}</option>";
																				}
																			?>
																			</select>
																		</div>
																		<div class="form-group col-md-2">
																			<label  class="f-label">-</label>
																			<select name="time_address_month[0][0]" class="form-control input-sm time_address_month time_add">
																			<?php
																				for ($i=0; $i < 13; $i++) 
																				{ 
																					echo "<option value='{$i}'>{$i}</option>";
																				}
																			?>
																			</select>
																		</div>
																		<div class="form-group col-md-2">
																			<label  class="f-label">-</label>
																			<span class="btn btn-primary add_address" style="height: 30px; width: 100%">Add</span>
																		</div>
																		<div class="form-group col-md-3">
																			<label for="client_res_stat" class="f-label">Res. Status</label>
																			<select name="client_res_stat[0][0]" class="form-control input-sm client_res_stat">
																				<option value="">--Please Choose--</option>
																				<option value="mortgage">Mortgage</option>
																				<option value="renting">Renting</option>
																				<option value="owner">Owner</option>
																				<option value="Living with parents">Living with parents</option>
																				<option value="Boarding">Boarding</option>
																				<option value="Employer Subsidised">Employer Subsidised</option>
																				<option value="other">Other</option>
																			</select>
																		</div>
																		<div class="form-group col-md-3">
																			<label for="monthly_commitment" class="f-label">Monthly Comm.</label>
																			<input type="text" name="monthly_commitment[0][0]" class="form-control input-sm monthly_commitment">
																		</div>
																	</div>
																</div>
																<div class="row prev_panel_parent" style="margin-right: -9px; margin-left: -9px; margin-top: 5px;">
																	<div class="panel panel-default prev_address_panel" hidden>
																		<div class="panel-heading" style="padding: 10px; ">
																		    <label  style="font-weight: bold;" class="panel-title-fapplication">Previous Address 1</label>
																		    <button type="button" class="btn btn-danger btn-xs pull-right remove">Remove</button>
																		</div>
																		<input type="hidden" name="address_id[0][1]" class="form-control address_id">
																		<div class="panel-body" style="background: #7fffff">
																			<div class="row">
																				<div class="form-group col-md-12">
																					<label for="client_address" class="f-label">Street Address</label>
																					<input type="text" name="client_address[0][1]" class="form-control input-sm client_address google_address" style="width: 100%">
																				</div>
																			</div>
																			<div class="row">
																				<div class="form-group col-md-4">
																					<label for="client_suburb" class="f-label">Suburb</label>
																					<input type="text" name="client_suburb[0][1]" class="form-control input-sm client_suburb google_suburb">
																				</div>
																				<div class="form-group col-md-4">
																					<label for="client_post_code" class="f-label">Post Code</label>
																					<input type="text" name="client_post_code[0][1]" class="form-control input-sm client_post_code google_postcode">
																				</div>
																				<div class="form-group col-md-2">
																					<label  class="f-label">Time</label>
																					<select name="time_address_years[0][1]" class="form-control input-sm time_address_years time_add">
																					<?php
																						for ($i=0; $i < 100; $i++) 
																						{ 
																							echo "<option value='{$i}'>{$i}</option>";
																						}
																					?>
																					</select>
																				</div>
																				<div class="form-group col-md-2">
																					<label  class="f-label">-</label>
																					<select name="time_address_month[0][1]" class="form-control input-sm time_address_month time_add">
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
																</div>
															</div>

														</div>

													</div>
												</div>
											</div>
											<div class="property_clause">
												<div class="panel panel-default">
													<div class="panel-heading">
													    <label class="panel-title-fapplication new" hidden>Property 1</label>
													    <label class="panel-title-fapplication default">Add a Property?</label>
													    <button type="button" class="btn btn-danger btn-xs pull-right remove" data-flag="property_claue" disabled>Remove</button>
													    <button type="button" class="btn btn-primary btn-xs pull-right add" data-flag="property_claue">Add</button>
													</div>
													<input type="hidden" name="property_id[0][0]" class="form-control property_id">
													<div class="panel-body" hidden style="background: #d2ffbf">
														<div class="row">
															<div class="form-group col-md-12">
																<label for="property_address" class="f-label">Street Address</label>
																<div class="input-group">
																	<input type="text" name="property_address[0][0]" class="form-control input-sm property_address google_address" style="width: 100%">
																	<span class="input-group-addon">
																		<input type="checkbox" data-toggle="tooltip" data-placement="top" title="Name on Title" class="name_on_title" name="name_on_title[0][0]">
																	</span>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="form-group col-md-4">
																<label for="property_suburb" class="f-label">Suburb</label>
																<input type="text" name="property_suburb[0][0]" class="form-control input-sm property_suburb google_suburb">
															</div>
															<div class="form-group col-md-4">
																<label for="property_postcode" class="f-label">Postcode</label>
																<input type="text" name="property_postcode[0][0]" class="form-control input-sm property_postcode google_postcode">
															</div>
															<div class="form-group col-md-4">
																<label for="mortgage_with" class="f-label">Mortgage Institution</label>
																<input type="text" name="mortgage_with[0][0]" class="form-control input-sm mortgage_with">
															</div>
														</div>
														<div class="row">
															<div class="form-group col-md-3">
																<label for="balance" class="f-label">Mortgage Balance</label>
																<input type="text" name="balance[0][0]" class="form-control input-sm balance">
															</div>
															<div class="form-group col-md-3">
																<label for="property_value" class="f-label">Property Value</label>
																<input type="text" name="property_value[0][0]" class="form-control input-sm property_value">
															</div>
															<div class="form-group col-md-3">
																<label for="mortgage_commitment" class="f-label">Monthly Rental Income</label>
																<div class="input-group">
																	<input type="text" name="mortgage_commitment[0][0]" class="form-control input-sm mortgage_commitment">
																	<span class="input-group-addon">
																		<input type="checkbox" data-toggle="tooltip" data-placement="top" title="Managed with statements available" class="managed" name="managed[0][0]">
																	</span>
																</div>
															</div>
															<div class="form-group col-md-3">
																<label for="monthly_payment" class="f-label">Monthly Payment</label>
																<input type="text" name="monthly_payment[0][0]" class="form-control input-sm monthly_payment">
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
													    <button type="button" class="btn btn-danger btn-xs pull-right remove" data-flag="loan_clause" disabled>Remove</button>
													    <button type="button" class="btn btn-primary btn-xs pull-right add" data-flag="loan_clause">Add</button>
													</div>
													<input type="hidden" name="other_loans_id[0][0]" class="form-control other_loans_id">
													<div class="panel-body" hidden style="background: #d2ffbf">
														<div class="row">
															<div class="form-group col-md-4">
																<label for="lending_institution" class="f-label">Lending Institution</label>
																<input type="text" name="lending_institution[0][0]" class="form-control input-sm lending_institution">
															</div>
															<div class="form-group col-md-4">
																<label for="purpose" class="f-label">Purpose for Loan</label>
																<input type="text" name="purpose[0][0]" class="form-control input-sm purpose">
															</div>
															<div class="form-group col-md-4">
																<label class="f-label">Monthly Payment</label>
																<input type="text" name="o_monthly_payment[0][0]" class="form-control input-sm o_monthly_payment outgoing_calc">
															</div>
														</div>
														<div class="row">
															<div class="form-group col-md-4">
																<label for="loan_start_date" class="f-label">Start Date</label>
																<input type="text" name="loan_start_date[0][0]" class="form-control input-sm loan_start_date">
															</div>
															<div class="form-group col-md-4">
																<label for="o_term" class="f-label">Loan Term</label>
																<input type="text" name="o_term[0][0]" class="form-control input-sm o_term">
															</div>
															<div class="form-group col-md-4">
																<label for="amount_borrowed" class="f-label">Balance</label>
																<input type="text" name="amount_borrowed[0][0]" class="form-control input-sm amount_borrowed" onkeypress="return isNumberKey(event)">
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
													    <button type="button" class="btn btn-danger btn-xs pull-right remove" data-flag="credit_card_clause" disabled>Remove</button>
													    <button type="button" class="btn btn-primary btn-xs pull-right add" data-flag="credit_card_clause">Add</button>
													</div>
													<input type="hidden" name="credit_card_id[0][0]" class="form-control credit_card_id">
													<div class="panel-body" hidden style="background: #d2ffbf">
														<div class="row">
															<div class="form-group col-md-3">
																<label for="credit_card_name" class="f-label">Provider</label>
																<input type="text" name="credit_card_name[0][0]" class="form-control input-sm credit_card_name" >
															</div>
															<div class="form-group col-md-3">
																<label for="credit_card_limit" class="f-label">Limit ($)</label>
																<input type="text" name="credit_card_limit[0][0]" class="form-control input-sm credit_card_limit outgoing_calc" onkeypress="return isNumberKey(event)">
															</div>
															<div class="form-group col-md-3">
																<label for="credit_card_balance" class="f-label">Balance</label>
																<input type="text" name="credit_card_balance[0][0]" class="form-control input-sm credit_card_balance" >
															</div>
															<div class="form-group col-md-3">
																<label for="credit_card_monthly" class="f-label">Monthly Payment</label>
																<input type="text" name="credit_card_monthly[0][0]" class="form-control input-sm credit_card_monthly" >
															</div>
														</div>
													</div>
												</div> 
											</div>

											<div class="living_cost_clause">
												<div class="panel panel-default">
													<div class="panel-heading">
													    <label class="panel-title-fapplication">Living Cost</label>
													</div>
													<input type="hidden" name="other_loans_id[0][0]" class="form-control other_loans_id">
													<div class="panel-body" style="background: #d2ffbf">
														<div class="row">
															<div class="form-group col-md-4">
																<label for="food_beverage" class="f-label">Food</label>
																<input type="text" name="food_beverage[0]" class="form-control input-sm food_beverage living_cost" onkeypress="return isNumberKey(event)">
															</div>
															<div class="form-group col-md-4">
																<label for="power_gas" class="f-label">Utilities</label>
																<input type="text" name="power_gas[0]" class="form-control input-sm power_gas living_cost" onkeypress="return isNumberKey(event)">
															</div>
															<div class="form-group col-md-4">
																<label for="insurance" class="f-label">Insurance Prem</label>
																<input type="text" name="insurance[0]" class="form-control input-sm insurance living_cost" onkeypress="return isNumberKey(event)">
															</div>
														</div>
														<div class="row">
															<div class="form-group col-md-4">
																<label for="transportation_fuel" class="f-label">Transport</label>
																<input type="text" name="transportation_fuel[0]" class="form-control input-sm transportation_fuel living_cost" onkeypress="return isNumberKey(event)">
															</div>
															<div class="form-group col-md-4">
																<label for="recreation" class="f-label">Recreation</label>
																<input type="text" name="recreation[0]" class="form-control input-sm recreation living_cost" onkeypress="return isNumberKey(event)">
															</div>
															<div class="form-group col-md-4">
																<label for="tot_living_cost" class="f-label">Total Living Cost</label>
																<div class="input-group">
																	<input type="text" name="tot_living_cost[0]" class="form-control input-sm tot_living_cost" onkeypress="return isNumberKey(event)">
																	<!-- <span class="input-group-addon">
																		<input type="checkbox" class="tot_living_cost_check" name="tot_living_cost_check[0]" value="1" data-toggle="tooltip" data-placement="top" title="15% - Recreation, 10% - Communications, 20% - Transportation, 25% - Food, 20% - Utilities, 10% - Insurance.">
																	</span> -->
																	<span class="input-group-addon tot_living_cost_check" data-toggle="tooltip" data-placement="top" title="15% - Recreation, 10% - Communications, 20% - Transportation, 25% - Food, 20% - Utilities, 10% - Insurance.">+/-</span>
																</div>
															</div>
														</div>
													</div>
												</div> 
											</div>
											
										</div>
										<div class="col-md-6 right">

											<div class="row top-fields" style="margin-left: -5px; margin-right: -5px;">
												<div class="form-group col-md-6">
													<label for="assessment_type" class="f-label">Assessment Type</label>
													<select name="assessment_type" id="assessment_type" class="form-control input-sm">
														<option value="Fast Track/Replacement">Fast Track/Replacement</option>
														<option value="Express/Replacement"> Express/Replacement</option>
														<option value="Low doc/Replacement">Low doc/Replacement</option>
														<option value="Full Doc" selected="selected">Full Doc</option>
													</select>
												</div>
												<div class="form-group col-md-6">
													<label for="rego" class="f-label">Current Date</label>
													<input type="text" class="form-control input-sm"  id="current_date">
												</div>
											</div>
											<div class="car_details" id="car_details">
												<div class="panel panel-default ">
													<div class="panel-heading ">
													    <label class="panel-title-fapplication" >Car &amp; Supplier</label>
													</div>
													<div class="panel-body panel-applicant-body" style="background: #d2ffbf">
														<div class="row">
															<div class="form-group col-md-3">
																<label for="car" class="f-label ">Car</label>
																<select name="car" id="car" class="form-control input-sm">
																	<option value="Demo" selected>Demo</option>
																	<option value="New">New</option>
																	<option value="Used">Used</option>
																</select>
															</div>
															<div class="form-group col-md-3" id="makes_row">
																<label for="make" class="f-label">Make</label>
																<select name="make" id="make" class="form-control input-sm">
														
																</select>
															</div>
															<div class="form-group col-md-3" id="model_row">
																<label for="model" class="f-label">Model</label>
																<select name="model" id="model" class="form-control input-sm">
														
																</select>
															</div>
															<div class="form-group col-md-3">
																<label for="year" class="f-label">Year</label>
																<select name="year" id="year" class="form-control input-sm">
																
																</select>
															</div>
														</div>
														<div class="row">
															<div class="form-group col-md-12" id="variant_row">
																<label for="variant" class="f-label">Variant</label>
																<select name="variant" id="variant" class="form-control input-sm" style="width: 100%">
													
																</select>
															</div>
														</div>
														<div class="row">
															<div class="form-group col-md-12">
																<label class="f-label">Color, Options &amp; Further Details</label>
																<div class="input-group">
																	<textarea name="further_details_supplies" id="further_details_supplies" class="form-control input-sm" rows="1" cols="50" placeholder="Color, Options &amp; Further Details..."></textarea>
																	<span class="input-group-addon">
																		<input type="checkbox" data-toggle="tooltip" data-placement="top" title="Replacement" name="replacement" id="replacement" class="replacement">
																	</span>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="form-group col-md-4">
																<label for="seller" class="f-label">Seller</label>
																<select name="seller" class="form-control input-sm" id="seller">
																	<option value="PRIVATE">PRIVATE</option>
																	<option value="FRANCHISED DEALER">FRANCHISED DEALER</option>
																	<option value="OTHER DEALER">OTHER DEALER</option>
																	<option value="SALE">SALE</option>
																	<option value="LEASE BACK">LEASE BACK</option>
																	<option value="CQO">CQO</option>
																</select>
															</div>
															<div class="form-group col-md-4" id="dealers_name_dom">
																<label for="dealer" class="dealer-label">Dealer</label>
																<select name="dealer" class="form-control input-sm dealer" id="dealer">
														
																</select>
															</div>
															<div class="form-group col-md-4">
																<label for="supplier_contact" class="f-label">Dealer Contact</label>
																<input type="text" name="supplier_contact" class="form-control input-sm" id="supplier_contact">
															</div>
														</div>
														<div class="row">
															<div class="form-group col-md-4">
																<label for="supplier_email" class="f-label">Dealer Email</label>
																<div class="input-group email_group">
																	<input type="text" name="supplier_email" class="form-control input-sm" id="supplier_email">
																	<span class="input-group-addon email_popup">@</span>
																</div>
															</div>
															<div class="form-group col-md-4">
																<label for="supplier_mobile" class="f-label">Mobile</label>
																<input type="text" name="supplier_mobile" class="form-control input-sm masked" id="supplier_mobile" >
														
																</select>
															</div>
															<div class="form-group col-md-4">
																<label for="supplier_landline" class="f-label">Landline</label>
																<input type="text" name="supplier_landline" class="form-control input-sm masked" id="supplier_landline" >
															</div>
														</div>
														<div class="row">
															<div class="form-group col-md-12">
																<label for="dealer_street_address" class="f-label">Street Address</label>
																<input type="text" name="dealer_street_address" class="form-control input-sm dealer_street_address google_address" style="width: 100%" id="dealer_street_address">
															</div>
														</div>
														<div class="row">
															<div class="form-group col-md-4">
																<label for="dealer_suburb" class="f-label">Suburb</label>
																<input type="text" name="dealer_suburb" class="form-control input-sm dealer_suburb google_suburb" id="dealer_suburb">
															</div>
															<div class="form-group col-md-4">
																<label for="dealer_postcode" class="f-label">Post Code</label>
																<input type="text" name="dealer_postcode" class="form-control input-sm dealer_postcode google_postcode">
															</div>
															<div class="form-group col-md-4">
																<label for="delivery_date" class="f-label">Delivery Date</label>
																<input type="text" name="delivery_date" class="form-control input-sm" id="date_delivered" >
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="employer_clause">
												<div class="panel panel-default ">
													<div class="panel-heading ">
													    <label class="panel-title-fapplication" >Employer Details</label>
													</div>
													<div class="panel-body" style="background: #d2ffbf">
														<div class="initial_employer_panel">
															<input type="hidden" name="employer_id[0][0]" class="form-control employer_id">
															<div class="row">
																<div class="form-group col-md-4">
																	<label for="employer_name" class="f-label">Company Name</label>
																	<input type="text" name="employer_name[0][0]" class="form-control input-sm employer_name">
																</div>
																<div class="form-group col-md-4">
																	<label for="employement_status" class="f-label">Employment Status</label>
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
																<div class="form-group col-md-4">
																	<label for="occ_position" class="f-label">Occupation/Position</label>
																	<input type="text" name="occ_position[0][0]" class="form-control input-sm occ_position">
																</div>
															</div>
															<div class="row">
																<div class="form-group col-md-3">
																	<label for="emp_industry" class="f-label">Industry</label>
																	<input type="text" name="emp_industry[0][0]" class="form-control input-sm emp_industry">
																</div>
																<div class="form-group col-md-2">
																	<label  class="f-label">Time</label>
																	<select name="time_employer_years[0][0]" class="form-control input-sm time_employer_years time_add_employer">
																	<?php
																		for ($i=0; $i < 100; $i++) 
																		{ 
																			echo "<option value='{$i}'>{$i}</option>";
																		}
																	?>
																	</select>
																</div>
																<div class="form-group col-md-2">
																	<label  class="f-label">-</label>
																	<select name="time_employer_month[0][0]" class="form-control input-sm time_employer_month time_add_employer">
																	<?php
																		for ($i=0; $i < 13; $i++) 
																		{ 
																			echo "<option value='{$i}'>{$i}</option>";
																		}
																	?>
																	</select>
																</div>
																<div class="form-group col-md-2">
																	<label  class="f-label">-</label>
																	<span class="btn btn-primary add_employer" style="height: 30px; width: 100%;">Add</span>
																</div>
																<div class="form-group col-md-3">
																	<label for="net_income" class="f-label">Net Income ($)</label>
																	<input type="text" name="net_income[0][0]" class="form-control input-sm net_income income_calc" onkeypress="return isNumberKey(event)">
																</div>
															</div>
															<div class="row">
																<div class="form-group col-md-12">
																	<label for="emp_address" class="f-label">Street Address</label>
																	<input type="text" name="emp_address[0][0]" class="form-control input-sm emp_address google_address" style="width: 100%;">
																</div>
															</div>
															<div class="row">
																<div class="form-group col-md-4">
																	<label for="emp_suburb" class="f-label">Suburb</label>
																	<input type="text" name="emp_suburb[0][0]" class="form-control input-sm emp_suburb google_suburb">
																</div>
																<div class="form-group col-md-4">
																	<label for="emp_post" class="f-label">Post Code</label>
																	<input type="text" name="emp_post[0][0]" class="form-control input-sm emp_post google_postcode">
																</div>
																<div class="form-group col-md-4">
																	<label for="emp_state" class="f-label">State</label>
																	<input type="text" name="emp_state[0][0]" class="form-control input-sm emp_state google_state">
																</div>
															</div>
															<div class="row">
																<div class="form-group col-md-4">
																	<label for="contact_person" class="f-label">Contact Person</label>
																	<input type="text" name="contact_person[0][0]" class="form-control input-sm contact_person">
																</div>
																<div class="form-group col-md-4">
																	<label for="contact_number" class="f-label">Contact Number</label>
																	<input type="text" name="contact_number[0][0]" class="form-control input-sm contact_number" >
																</div>
																<div class="form-group col-md-4">
																	<label for="emp_abn" class="f-label">Employer ABN</label>
																	<input type="text" name="emp_abn[0][0]" class="form-control input-sm emp_abn" >
																</div>
															</div>
														</div>
														<div class="prev_emp_panel_parent">
															<div class="row prev_employer_panel" style="margin-right: -9px; margin-left: -9px; margin-top: 5px;" hidden>
																<div class="panel panel-default ">
																	<div class="panel-heading" style="padding: 10px; ">
																	    <label  style="font-weight: bold;" class="panel-title-fapplication">Previous Employer 1</label>
																	    <button type="button" class="btn btn-danger btn-xs pull-right remove">Remove</button>
																	</div>
																	<input type="hidden" name="employer_id[0][1]" class="form-control employer_id">
																	<div class="panel-body" style="background-color: #7fffff">
																		<div class="row">
																			<div class="form-group col-md-3">
																				<label for="employer_name" class="f-label">Company Name</label>
																				<input type="text" name="employer_name[0][1]" class="form-control input-sm employer_name">
																			</div>
																			<div class="form-group col-md-3">
																				<label for="occ_position" class="f-label">Occupation/Position</label>
																				<input type="text" name="occ_position[0][1]" class="form-control input-sm occ_position">
																			</div>
																			<div class="form-group col-md-2">
																				<label  class="f-label">Time</label>
																				<select name="time_employer_years[0][1]" class="form-control input-sm time_employer_years time_add_employer">
																				<?php
																					for ($i=0; $i < 100; $i++) 
																					{ 
																						echo "<option value='{$i}'>{$i}</option>";
																					}
																				?>
																				</select>
																			</div>
																			<div class="form-group col-md-2">
																				<label  class="f-label">-</label>
																				<select name="time_employer_month[0][1]" class="form-control input-sm time_employer_month time_add_employer">
																				<?php
																					for ($i=0; $i < 13; $i++) 
																					{ 
																						echo "<option value='{$i}'>{$i}</option>";
																					}
																				?>
																				</select>
																			</div>
																			<div class="form-group col-md-2">
																				<label  class="f-label">-</label>
																				<span class="btn btn-primary add_employer" style="height: 30px; width: 100%;">Add</span>
																			</div>
																		</div>
																		<div class="row">
																			<div class="form-group col-md-3">
																				<label for="contact_number" class="f-label">Contact Number</label>
																				<input type="text" name="contact_number[0][1]" class="form-control input-sm contact_number" >
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="">
															<div class="row other_income_clause employer_hidden_panels" style="margin-right: -9px; margin-left: -9px; margin-top: 5px;">
																<div class="panel panel-default false-panel">
																	<div class="panel-heading" style="padding: 10px; ">
																	    <label class="panel-title-3rd-dim new" hidden>Other Income 1</label>
																	    <label class="panel-title-3rd-dim default">Add Other Income?</label>
																	    <button type="button" class="btn btn-danger btn-xs pull-right remove_other_income" data-flag="other_income_clause" disabled="">Remove</button>
																	    <button type="button" class="btn btn-primary btn-xs pull-right add_other_income" data-flag="other_income_clause">Add</button>
																	</div>
																	<input type="hidden" name="other_income_id[0][0][0]" class="form-control other_income_id">
																	<div class="panel-body" style="background-color: #7fffff" hidden>
																		<div class="row">
																			<div class="form-group col-md-4">
																				<label for="other_income_name" class="f-label">Other Income</label>
																				<select name="other_income_name[0][0][0]" class="form-control input-sm other_income_name">
																					<option value=""></option>
																					<option value="Concurrent Employer">Concurrent Employer</option>
																					<option value="Overtime">Overtime</option>
																					<option value="Commission">Commission</option>
																					<option value="Interest">Interest</option>
																					<option value="Dividends">Dividends</option>
																					<option value="Pension">Pension</option>
																					<option value="Pension">Welfare</option>
																					<option value="Partner Income">Partner's Income</option>
																				</select>
																			</div>
																			<div class="form-group col-md-4">
																				<label for="other_income_details" class="f-label">Details</label>
																				<input type="text" name="other_income_details[0][0][0]" class="form-control input-sm other_income_details" >
																			</div>
																			<div class="form-group col-md-4">
																				<label for="other_income_amount" class="f-label">Amount ($)</label>
																				<input type="text" name="other_income_amount[0][0][0]" class="form-control input-sm other_income_amount income_calc" onkeypress="return isNumberKey(event)">
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="business_details">
												<div class="panel panel-default">
													<div class="panel-heading">
													    <label class="panel-title-fapplication">BUSINESS DETAILS</label>
													</div>
													<div class="panel-body" style="background: #d2ffbf">
														
														<div class="row">
															<div class="form-group col-md-4">
																<label for="trading_name" class="f-label">Trading Name</label>
																<input type="text" name="trading_name" class="form-control input-sm" id="trading_name">
															</div>
															<div class="form-group col-md-4">
																<label for="abr_name" class="f-label">Entity Name</label>
																<input type="text" name="abr_name" id="abr_name" class="form-control input-sm">
															</div>
															<div class="form-group col-md-4">
																<label for="industry" class="f-label">Industry</label>
																<input type="text" name="industry" id="industry" class="form-control input-sm">
															</div>
														</div>
														<div class="row">
															<div class="form-group col-md-4">
																<label for="supplier_email" class="f-label">ABN</label>
																<div class="input-group email_group">
																	<input type="text" name="abn" id="abn" class="form-control input-sm">
																	<span class="input-group-addon abn_popup"><i class="fa fa-search"></i></span>
																</div>
															</div>
															<div class="form-group col-md-4">
																<label for="abn_date" class="f-label">ABN active since</label>
																<input type="text" name="abn_date" id="abn_date" class="form-control input-sm abn_date" >
															</div>
															<div class="form-group col-md-4">
																<label for="gst_registered" class="f-label">GST Registered</label>
																<input type="text" name="gst_registered" id="gst_registered" class="form-control input-sm">
															</div>
														</div>
														<div class="row">
															<div class="form-group col-md-12">
																<label class="f-label">Street Address</label>
																<input type="text" name="trade_address" id="trade_address" class="form-control input-sm google_address" style="width: 100%">
															</div>
														</div>
														<div class="row">
															<div class="form-group col-md-4">
																<label for="trade_suburb" class="f-label">Suburb</label>
																<input type="text" name="trade_suburb" id="trade_suburb" class="form-control input-sm google_suburb">
															</div>
															<div class="form-group col-md-4">
																<label for="trade_post_code" class="f-label" >Postcode</label>
																<input type="text" name="trade_post_code" id="trade_post_code" class="form-control input-sm google_postcode" >
															</div>
															<div class="form-group col-md-4">
																<label class="f-label">Telephone</label>
																<input class="form-control input-sm masked" id="bank_addr_titled" name="bank_addr_titled" type="text">
															</div>
														</div>
														<div class="row">
															<div class="form-group col-md-4">
																<label for="other_income" class="f-label">Gross Annual Turnover</label>
																<input type="text" name="other_income" class="form-control input-sm" id="other_income" onkeypress="return isNumberKey(event)">
															</div>
															<div class="form-group col-md-4">
																<label for="net_profit" class="f-label">Net Annual Income</label>
																<input type="text" name="net_profit" class="form-control input-sm" id="net_profit" onkeypress="return isNumberKey(event)">
															</div>
															<div class="form-group col-md-4">
																<label for="banking_institution" class="f-label">Banking Institution</label>
																<input type="text" name="banking_institution" id="banking_institution" class="form-control input-sm">
															</div>
														</div>
														<div class="row">
															<div class="form-group col-md-4">
																<label for="accountant" class="f-label">Accountant</label>
																<input type="text" name="accountant" id="accountant" class="form-control input-sm">
															</div>
															<div class="form-group col-md-4">
																<label for="accountant_contact" class="f-label">Contact</label>
																<input type="text" name="accountant_contact" id="accountant_contact" class="form-control input-sm">
															</div>
															<div class="form-group col-md-4">
																<label for="accountant_number" class="f-label">Number</label>
																<input type="text" name="accountant_number" id="accountant_number" class="form-control input-sm masked" >
															</div>
														</div>
														<div class="row">
															<div class="form-group col-md-12">
																<label for="accountant_address" class="f-label">Address</label>
																<input type="text" name="accountant_address" id="accountant_address" class="form-control input-sm google_address" style="width: 100%">
															</div>
														</div>
														<div class="row">
															<div class="form-group col-md-4">
																<label for="accountant_suburb" class="f-label">Suburb</label>
																<input type="text" name="accountant_suburb" id="accountant_suburb" class="form-control input-sm google_suburb">
															</div>
															<div class="form-group col-md-4">
																<label for="accountant_post_code" class="f-label">Post Code</label>
																<input type="text" name="accountant_post_code" id="accountant_post_code" class="form-control input-sm google_postcode">
															</div>
															<div class="form-group col-md-4">
																<label for="accountant_number" class="f-label">Email</label>
																<input type="text" name="accountant_email" id="accountant_email" class="form-control input-sm" >
															</div>
														</div>
														<div class="beneficiaries_section" style="margin-top: 10px;">
															<div class="panel panel-default">
																<div class="panel-heading">
																    <label class="panel-title-fapplication">TRUST DETAILS</label>
																</div>
																<input type="hidden" name="beneficiary_id[0]" class="form-control beneficiary_id">
																<div class="panel-body" style="background: #7fffff">
																	<div class="row">
																		<div class="form-group col-md-4">
																			<label for="trust_name" class="f-label" >Trust Name</label>
																			<input type="text" name="trust_name" class="form-control input-sm trust_name">
																		</div>
																		<div class="form-group col-md-4">
																			<label for="trust_type" class="f-label" >Trust Type</label>
																			<select class="form-control input-sm" name="trust_type">
																				<option value="Constructive Trust">Constructive Trust</option>
																				<option value="Family Discretionary Trust">Family Discretionary Trust</option>
																				<option value="Other">Other</option>
																				<option value="Resulting Trust">Resulting Trust</option>
																				<option value="Service Trust">Serice Trust</option>
																				<option value="Unit Trust">Unit Trust</option>
																			</select>
																		</div>
																		<div class="form-group col-md-4">
																			<label for="acn" class="f-label" >ACN</label>
																			<input type="text" name="acn" class="form-control input-sm acn">
																		</div>
																	</div>
																	<div class="row">
																		<div class="form-group col-md-5">
																			<label for="settlor" class="f-label" >Settlor</label>
																			<input type="text" name="settlor[0][0]" class="form-control input-sm settlor">
																		</div>
																		<div class="form-group col-md-1">
																			<label>-</label>
																			<button type="button" class="btn btn-primary btn-xs pull-right " style="width: 100%">Add</button>
																		</div>
																		<div class="form-group col-md-5">
																			<label for="appointer" class="f-label" >Appointer</label>
																			<input type="text" name="appointer[0][0]" class="form-control input-sm appointer">
																		</div>
																		<div class="form-group col-md-1">
																			<label>-</label>
																			<button type="button" class="btn btn-primary btn-xs pull-right " style="width: 100%">Add</button>
																		</div>
																	</div>
																	<div class="new_beneficiary_parent">
																		<div class="beneficiary_panel panel">
																			<input type="hidden" name="beneficiary_id[0]" class="form-control beneficiary_id">
																			<div class="row">
																				<div class="form-group col-md-5">
																					<label for="b_first_name" class="f-label" >Additional Beneficiary/Entity</label>
																					<input type="text" name="b_first_name[0]" class="form-control input-sm b_first_name">
																				</div>
																				<div class="form-group col-md-4">
																					<label for="b_type" class="f-label" >Type</label>
																					<select class="form-control input-sm b_type" name="b_type">
																						<option value="BE">Beneficiary</option>
																						<option value="BO">Beneficial Owner</option>
																						<option value="DI">Directory</option>
																						<option value="IB">Intermediate Benficial Owner</option>
																						<option value="SG">Signatory</option>
																						<option value="SM">Senior Manging Official</option>
																						<option value="TR">Trustee</option>
																					</select>
																				</div>
																				<div class="form-group col-md-3">
																					<label for="b_acn" class="f-label" >ACN</label>
																					<input type="text" name="b_acn[0]" class="form-control input-sm b_acn">
																				</div>
																			</div>
																			<div class="row">
																				<div class="form-group col-md-12">
																					<label for="b_address" class="f-label" >Street Address</label>
																					<input type="text" name="b_address[0]" class="form-control input-sm b_address google_address" style="width: 100%">
																				</div>
																			</div>
																			<div class="row">
																				<div class="form-group col-md-4">
																					<label for="b_suburb" class="f-label">Suburb</label>
																					<input type="text" name="b_suburb[0]" class="form-control input-sm b_suburb google_suburb">
																				</div>
																				<div class="form-group col-md-4">
																					<label for="b_postcode" class="f-label">Postcode</label>
																					<input type="text" name="b_postcode[0]" class="form-control input-sm b_postcode google_postcode">
																				</div>
																				<div class="form-group col-md-2">
																					<label>-</label>
																					<button type="button" class="btn btn-primary btn-xs btn-full add_beneficiary">Add</button>
																				</div>
																				<div class="form-group col-md-2">
																					<label>-</label>
																					<button type="button" class="btn btn-danger btn-xs btn-full remove">Remove</button>
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
											<div class="cred_reference_clause">
												<div class="panel panel-default">
													<div class="panel-heading">
													    <label class="panel-title-fapplication new" hidden>Reference 1</label>
													    <label class="panel-title-fapplication default">Add a Reference?</label>
													    <button type="button" class="btn btn-danger btn-xs pull-right remove" data-flag="reference_clause" disabled>Remove</button>
													    <button type="button" class="btn btn-primary btn-xs pull-right add" data-flag="reference_clause">Add</button>
													</div>
													<input type="hidden" name="credit_reference_id[0][0]" class="form-control credit_reference_id">
													<div class="panel-body" hidden style="background: #d2ffbf">
														<div class="row">
															<div class="form-group col-md-4">
																<label for="r_first_name" class="f-label">First Name</label>
																<input type="text" name="r_first_name[0][0]" class="form-control input-sm r_first_name">
															</div>
															<div class="form-group col-md-4">
																<label for="r_last_name" class="f-label">Last Name</label>
																<input type="text" name="r_last_name[0][0]" class="form-control input-sm r_last_name">
															</div>
															<div class="form-group col-md-4">
																<label for="r_business_name" class="f-label">Business Name</label>
																<input type="text" name="r_business_name[0][0]" class="form-control input-sm r_business_name">
															</div>
														</div>
														<div class="row">
															<div class="form-group col-md-12">
																<label for="r_address" class="f-label">Street Address</label>
																<input type="text" name="r_address[0][0]" class="form-control input-sm r_address google_address" style="width: 100%">
															</div>
														</div>
														<div class="row">
															<div class="form-group col-md-4">
																<label for="r_suburb" class="f-label">Suburb</label>
																<input type="text" name="r_suburb[0][0]" class="form-control input-sm r_suburb google_suburb">
															</div>
															<div class="form-group col-md-4">
																<label for="r_postcode" class="f-label">Postcode</label>
																<input type="text" name="r_postcode[0][0]" class="form-control input-sm r_postcode google_postcode">
															</div>
															<div class="form-group col-md-4">
																<label for="r_telephone" class="f-label">Telephone</label>
																<input type="text" name="r_telephone[0][0]" class="form-control input-sm r_telephone" >
															</div>
														</div>
													</div>
												</div> 
											</div>

											<div class="assets">
												<div class="panel panel-default">
													<div class="panel-heading">
													    <label class="panel-title-fapplication ">Assets</label>
													</div>
													<div class="panel-body" style="background: #d2ffbf">
														<div class="row">
															<div class="form-group col-md-4">
																<label for="tot_prop_value" class="f-label">Total Property Value ($)</label>
																<input type="text" name="tot_prop_value[0]" class="form-control input-sm tot_prop_value comp_asset" onkeypress="return isNumberKey(event)"s>
															</div>
															<div class="form-group col-md-4">
																<label for="cash_savings" class="f-label">Cash Savings ($)</label>
																<input type="text" name="cash_savings[0]" class="form-control input-sm cash_savings comp_asset" onkeypress="return isNumberKey(event)">
															</div>
															<div class="form-group col-md-4">
																<label for="personal_effects" class="f-label">Personal Effects</label>
																<input type="text" name="personal_effects[0]" class="form-control input-sm personal_effects comp_asset" onkeypress="return isNumberKey(event)">
															</div>
														</div>
														<div class="row">
															<div class="form-group col-md-4">
																<label for="superannuation" class="f-label">Superannuation</label>
																<input type="text" name="superannuation[0]" class="form-control input-sm superannuation comp_asset" onkeypress="return isNumberKey(event)">
															</div>
															<div class="form-group col-md-4">
																<label for="shares_investments" class="f-label">Shares and Investments
																<input type="text" name="shares_investments[0]" class="form-control input-sm shares_investments" onkeypress="return isNumberKey(event)">
															</div>
															<div class="form-group col-md-4">
																<label for="asset_vehicles" class="f-label">Vehicles</label>
																<input type="text" name="asset_vehicles[0]" class="form-control input-sm asset_vehicles comp_asset" onkeypress="return isNumberKey(event)">
															</div>
														</div>
														<div class="row">
															<div class="form-group col-md-4">
																<label for="total_assets" class="f-label">Total</label>
																<input type="text" name="total_assets[0]" class="form-control input-sm total_assets" onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
												</div> 
											</div>

											<div class="borrowers_statement">
												<div class="panel panel-default">
													<div class="panel-heading">
													    <label class="panel-title-fapplication ">Applicant Declaration</label>
													</div>
													<div class="panel-body" style="background: #d2ffbf">
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
													</div>
												</div> 
											</div>
										</div>
									</div>
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
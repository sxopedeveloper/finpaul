<?php
/*------Commented by - RJ - Start 27-04-18 --------*/ 
/*<div id="add_quote_modal" class="modal fade"> <!-- Add Quote Modal -->
	<div class="modal-dialog" style="width: 95%;">
		<section class="panel">
			<form method="post" action="" id="add_quote_form" name="add_quote_form">
				<input type="hidden" id="id_lead" name="id_lead" value="">
				<input type="hidden" id="id_quote_request" name="id_quote_request">
				<input type="hidden" id="id_quote" name="id_quote">
				<input type="hidden" id="process" name="process">
				<input type="hidden" id="registration_type" name="registration_type">
				<input type="hidden" id="dealer_state" name="dealer_state">
				<input type="hidden" id="client_state" name="client_state">
				<input type="hidden" id="tradein_count" name="tradein_count">									
				<div class="panel-body">
					<div class="modal-wrapper">
						<div class="modal-text">
							<div class="row">
								<div class="col-md-12 text-center">
									<h4 id="label_name" style="line-height: 1px;"></h4>
									<p id="label_email" style="color: #cccccc; font-size: 0.9em;"></p>
									<hr class="solid mt-sm mb-lg">							
								</div>
							</div>
							<div class="row" id="quote_form_demo_container">													
								<div class="col-md-12">
									<div style="padding: 20px; border: 1px solid #ddd;">
										<div class="form-group">
											<label class="control-label">Is the vehicle brand new or a demonstrator?</label>
											<select class="form-control" id="demo" name="demo">
												<option value="New">New</option>
												<option value="Demo">Demo</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<!--div class="row" style="margin-top: 20px;">
								<div class="col-md-12">
									<div style="padding: 20px; border: 1px solid #ddd;">
										<div class="row">
											<div class="col-md-6">
												<h5><b>Vehicle:</b></h5>
												<p><span id="vehicle_label"></span></p>
											</div>
											<div class="col-md-6">
												<h5><b>Registration Type:</b></h5>
												<p><span id="registration_type_label"></span></p>
											</div>																
										</div>
									</div>
								</div>
							</div-->
							<div class="row" id="quote_form_dealer_selector_container" style="margin-top: 20px;" hidden>
								<div class="col-md-12">
									<div style="padding: 20px; border: 1px solid #ddd;">
										<div class="row">
											<div class="col-md-4">
												<label class="control-label">Dealership Make:</label>
												<select class="form-control input-md" id="make_ds" type="text" onchange="load_suggested_dealers('add_quote_modal')">
													<option name="make" value=""></option>
													<?php
													foreach ($makes as $make)
													{
														?>
														<option name="make" value="<?php echo $make->name; ?>"><?php echo $make->name; ?></option>
														<?php
													}
													?>
												</select>
												<br />
											</div>
											<div class="col-md-4">
												<label class="control-label">State:</label>
												<select class="form-control input-md" id="state_ds" type="text" onchange="load_suggested_dealers('add_quote_modal')">
													<option value=""></option>
													<option value="ACT">Australian Capital Territory</option>
													<option value="NSW">New South Wales</option>
													<option value="NT">Northern Territory</option>
													<option value="QLD">Queensland</option>
													<option value="SA">South Australia</option>
													<option value="TAS">Tasmania</option>
													<option value="VIC">Victoria</option>
													<option value="WA">Western Australia</option>
												</select>
											</div>
											<div class="col-md-4">
												<label class="control-label">Postcode:</label>
												<input class="form-control input-md" id="postcode_ds" type="text" value="" placeholder="Postcode" onchange="load_suggested_dealers('add_quote_modal')"><br />
											</div>
										</div>
										<div class="row">
											<div class="col-md-12 text-left" id="suggested_dealers"></div>
										</div>
										<div class="row">
											<div class="col-md-12 text-left">
												<br />
												<table class="table table-bordered table-striped table-condensed mb-none">
													<thead>
														<tr><td><b>SELECTED DEALERS</b></td><td></td></tr>
													</thead>
													<tbody id="selected_dealers">
														<tr class="norecord"><td colspan="2"><center>No dealer is selected!</center></td></tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div id="quote_form_warning_container" hidden> <!-- Quote Form Warning -->
								<div class="row" style="margin-top: 20px;">
									<div class="col-md-12">
										<div class="alert alert-danger" id="quote_form_warning_message">
											
										</div>
									</div>
								</div>
							</div>
							<div id="quote_form_container" hidden> <!-- Quote Form -->
								<div class="row" style="margin-top: 20px;">
									<div class="col-md-12">
										<div style="padding: 20px; border: 1px solid #ddd;">
											<div class="table-responsive">
												<table class="table table-bordered table-striped table-condensed mb-none">
													<tbody>
														<tr>
															<td width="70%">Delivery Date</td>
															<td><input value="" class="form-control input-sm datepicker" data-date-format="yyyy-mm-dd" id="delivery_date" name="delivery_date" type="text"></td>
														</tr>
														<tr>
															<td width="70%">Compliance Date</td>
															<td><input value="" class="form-control input-sm" id="compliance_date" name="compliance_date" type="text"></td>
														</tr>																			
														<tr>
															<td width="70%">VIN</td>
															<td><input value="" class="form-control input-sm" id="vin" name="vin" type="text"></td>
														</tr>
														<tr>
															<td width="70%">Engine Number</td>
															<td><input value="" class="form-control input-sm" id="engine" name="engine" type="text"></td>
														</tr>
														<tr>
															<td width="70%">Registration Plate</td>
															<td><input value="" class="form-control input-sm" id="registration_plate" name="registration_plate" type="text"></td>
														</tr>
														<tr>
															<td width="70%">Registration Expiry</td>
															<td><input value="" class="form-control input-sm" id="registration_expiry" name="registration_expiry" type="text"></td>
														</tr>
														<tr>
															<td width="70%">KMS</td>
															<td><input value="0" class="form-control input-sm" id="kms" name="kms" type="text" onkeypress="return isNumberKey(event)"></td>
														</tr>
														<tr>
															<td width="70%">Dealer Note</td>
															<td><textarea class="form-control input-sm" id="notes" name="notes"></textarea></td>
														</tr>																			
													</tbody>
												</table>
											</div>														
										</div>
									</div>
								</div>
								<div class="row" style="margin-top: 20px;">
									<div class="col-md-12">
										<div style="padding: 20px; border: 1px solid #ddd;">
											<div class="table-responsive">
												<table class="table table-bordered table-striped table-condensed mb-none">
													<tbody>
														<tr>
															<td width="70%">List Price</td>
															<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="retail_price" name="retail_price" type="text" onchange="calculate_quote_new('#add_quote_modal')" required></td>
														</tr>
														<tr>
															<td>Metallic Paint</td>
															<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="metallic_paint" name="metallic_paint" type="text" onchange="calculate_quote_new('#add_quote_modal')" required></td>
														</tr>																			
														<tr>
															<td>Discount</td>
															<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="dealer_discount" name="dealer_discount" type="text" onchange="calculate_quote_new('#add_quote_modal')" required></td>
														</tr>													
														<tr>
															<td>Fleet Claim</td>
															<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="fleet_discount" name="fleet_discount" type="text" onchange="calculate_quote_new('#add_quote_modal')" required></td>
														</tr>
														<tr>
															<td><b>SUBTOTAL</b></td>
															<td><input value="0" class="form-control input-sm subtotal_1" id="subtotal_1" name="subtotal_1" type="text" readonly></td>
														</tr>
													</tbody>
												</table>
											</div>
											<br />
											<div id="options_content"></div>
											<div id="accessories_content"></div>
											<div class="table-responsive">
												<table class="table table-bordered table-striped table-condensed mb-none">
													<tbody>										
														<tr>
															<td width="70%">Delivery Charge</td>
															<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="predelivery" name="predelivery" type="text" onchange="calculate_quote_new('#add_quote_modal')" required></td>
														</tr>
														<tr>
															<td><b>SUBTOTAL</b></td>
															<td><input value="0" class="form-control input-sm subtotal_2" id="subtotal_2" name="subtotal_2" type="text" readonly></td>
														</tr>
													</tbody>
												</table>
											</div>
											<br />
											<div class="table-responsive">
												<table class="table table-bordered table-striped table-condensed mb-none">
													<tbody>																								
														<tr>
															<td width="70%">GST</td>
															<td><input value="0" class="form-control input-sm" id="gst" name="gst" type="text" readonly></td>
														</tr>																
														<tr>
															<td><b>SUBTOTAL</b></td>
															<td><input value="0" class="form-control input-sm" id="subtotal_3" name="subtotal_3" type="text" readonly></td>
														</tr>
													</tbody>
												</table>
											</div>
											<br />
											<div class="table-responsive">														
												<table class="table table-bordered table-striped table-condensed mb-none">
													<tbody>																	
														<tr>
															<td width="70%">Luxury Tax</td>
															<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="luxury_tax" name="luxury_tax" type="text" onchange="calculate_quote_new('#add_quote_modal')" required></td>
														</tr>
														<tr>
															<td>CTP</td>
															<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm ctp" id="ctp" name="ctp" type="text" onchange="calculate_quote_new('#add_quote_modal')" required></td>
														</tr>																																
														<tr>
															<td>Registration</td>
															<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm registration" id="registration" name="registration" type="text" onchange="calculate_quote_new('#add_quote_modal')" required></td>
														</tr>
														<tr>
															<td>Premium Plate Fee</td>
															<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="premium_plate_fee" name="premium_plate_fee" type="text" onchange="calculate_quote_new('#add_quote_modal')" required></td>
														</tr>
														<tr>
															<td>Stamp Duty</td>
															<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm stamp_duty" id="stamp_duty" name="stamp_duty" type="text" onchange="calculate_quote_new('#add_quote_modal')" required></td>
														</tr>
														<tr>
															<td><b>TOTAL INC GST</b></td>
															<td><input value="0" class="form-control input-sm" id="total" name="total" type="text" readonly></td>
														</tr>
														<tr>
															<td>Tradein Value (-)</td>
															<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="dealer_tradein_value" name="dealer_tradein_value" type="text" onchange="calculate_quote_new('#add_quote_modal')" required></td>
														</tr>
														<tr>
															<td>Tradein Payout (+)</td>
															<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="dealer_tradein_payout" name="dealer_tradein_payout" type="text" onchange="calculate_quote_new('#add_quote_modal')" required></td>
														</tr>
														<tr>
															<td>Refund to Client (+)</td>
															<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="dealer_client_refund" name="dealer_client_refund" type="text" onchange="calculate_quote_new('#add_quote_modal')" required></td>
														</tr>
														<tr>
															<td><b>Changeover</b></td>
															<td><input value="0" class="form-control input-sm" id="dealer_changeover" name="dealer_changeover" type="text" readonly></td>
														</tr>												
													</tbody>
												</table>
											</div>
											<br />
											<div class="table-responsive" id="transport_checkbox_container">	
												<table class="table table-bordered table-striped table-condensed mb-none">
													<tbody>
														<tr>
															<td width="70%">Is the Dealer paying for the transport of the Trade-in Vehicle?</td>
															<td>
																<select class="form-control" id="transport_checkbox" name="transport_checkbox">
																	<option value=""></option>
																	<option value="Yes">Yes</option>
																	<option value="Now">No</option>
																</select>																					
															</td>
														</tr>
													</tbody>
												</table>																
											</div>															
										</div>
									</div>
								</div>																								
							</div>
						</div>
					</div>
				</div>
				<div class="panel-footer text-right">
					<button type="submit" class="btn btn-primary" id="add_quote_submit_button" disabled>
						Submit
					</button>
					<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
						Cancel
					</button>
				</div>									
			</form>
		</section>					
	</div>
</div>*/ 
/*------Commented by - RJ - End 27-04-18 --------*/ 
?>
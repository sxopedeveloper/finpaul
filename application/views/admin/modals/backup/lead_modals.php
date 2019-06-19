<style type="text/css">
	.img-details {
		max-width: 283px;
		max-height: 212px;
	}
	.dropzone-image {
		background-color: #d3d3d3;
		cursor: pointer;
		cursor: hand;
		border-radius: 0px !important;
		max-width: 283px;
	}
	.delete-image {
		z-index: 9999999;
	}
	.non-form-control {
		width: 25px;
		height: 25px;
	}
	.other_info_textarea {
		resize: none !important;
		width: 100%;
		height: 100%;
	}
	.tradein-doc-panel-body{
		box-shadow: 0 1px 2px rgba(0, 0, 0, 0.4);
		padding-bottom: 0px;
	}
	.documents { 
		cursor: pointer; 
		cursor: hand;
		padding-top: 6px;
	}
	.documents_temp{
		cursor: pointer; 
		cursor: hand;
		padding-top: 6px;	
	}
	.documents_temp_tile{
		cursor: pointer; 
		cursor: hand;
		padding-top: 6px;		
	}
	.documents_green {
		background-color: #b2ffb2;
	}
	.tradein_doc_button{
		cursor: pointer; 
		cursor: hand;
	}
	.panel-up-tradein{
		margin-bottom: 5px;
	}
	.wh{
		cursor: pointer; 
		cursor: hand;
		padding-top: 6px;
	}

	.row-input{
		margin-bottom: 10px;
	}

</style>
<div id="lead-modal" class="modal fade">
	<div class="modal-dialog" style="width: 95%;">
		<div class="panel-body">
			<div class="modal-wrapper">
				<div class="modal-text">
					<form method="post" action="" id="main_form" name="main_form">
						<input type="hidden" id="lead_id" name="id_lead" value="" />
						<input type="hidden" id="lead_status_id" name="lead_status" value="" />
						<input type="hidden" id="lead_email_value" name="lead_email_value" value="" />
						<input type="hidden" id="hidden_tradein_flag" name="hidden_tradein_flag" value="" />
						<div class="toogle" data-plugin-toggle="">
							<section class="toggle active">
								<label>PRELIMINARY DETAILS</label>
								<div class="toggle-content">
									<div class="table-responsive">
										<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
											<thead>
												<tr>
													<td><b>CQ Number</b></td>
													<td><b>Name</b></td>
													<td><b>Email</b></td>
													<td><b>Phone</b></td>
													<td><b>Mobile</b></td>
													<td><b>State</b></td>
													<td><b>Postcode</b></td>
													<td><b>Make</b></td>
													<td><b>Model</b></td>
													<td><b>Date/Time</b></td>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td id="lead_cq_number"></td>
													<td id="lead_name"></td>
													<td id="lead_email"></td>
													<td id="lead_phone"></td>
													<td id="lead_mobile"></td>
													<td id="lead_state"></td>
													<td id="lead_postcode"></td>
													<td id="lead_make"></td>
													<td id="lead_model"></td>
													<td id="lead_created_at"></td>
												</tr>
											</tbody>
										</table>
									</div>
									<textarea id="lead_details" name="details" class="form-control" rows="3" placeholder="Remarks" style="margin-top: 10px;"></textarea>
								</div>
							</section>
						</div>
						<!-- <div class="toogle" data-plugin-toggle="">
							<section class="toggle active">
								<label>LEAD DOCUMENTS</label>
								<input type="hidden" value="" id="doc_hidden_val">
								<div class="toggle-content">
									<div class="row" id="document_row">
									</div>
								</div>
							</section>
						</div> -->
						<?php
						if ($login_type=="Admin")
						{
							?>
							<div class="toogle" data-plugin-toggle="">
								<section class="toggle">
									<label>ADMIN SECTION</label>
									<div class="toggle-content">
										<div id="lead_admin_section"></div>
									</div>
								</section>
							</div>
							<?php
						}
						?>
						<div class="toogle" data-plugin-toggle="">
							<section class="toggle">
								<label>CLIENT DETAILS</label>
								<div class="toggle-content">
									<div id="lead_client_details"></div>
								</div>
							</section>
						</div>
						<div class="toogle" data-plugin-toggle="">
							<section class="toggle">
								<label>TRADEIN DETAILS</label>
								<div class="toggle-content">
									<input type="hidden" value="" id="tradein_doc_hidden_val">
									<input type="hidden" value="" id="tradein_id_hidden">
									<!-- <div class="row" id="tradein_document_row"></div> -->
									<div id="lead_tradein_details"></div>
								</div>
							</section>
						</div>										
						<div class="toogle" data-plugin-toggle="">
							<section class="toggle">
								<label>TENDER DETAILS</label>
								<div class="toggle-content">
									<div id="lead_quote_request_details"></div>
								</div>
							</section>
						</div>
						<div class="toogle" data-plugin-toggle="">
							<section class="toggle">
								<label>WINNING QUOTE</label>
								<div class="toggle-content">
									<div id="lead_winning_quote_details"></div>
								</div>
							</section>
						</div>
						<div class="toogle" data-plugin-toggle="">
							<section class="toggle">
								<label>ACCESSORIES DETAILS</label>
								<div class="toggle-content">
									<div id="lead_accessories_details"></div>
								</div>
							</section>
						</div>
						<div class="toogle" data-plugin-toggle="">
							<section class="toggle">
								<label>COMPUTATION</label>
								<div class="toggle-content">
									<div id="lead_calculation_details"></div>
								</div>
							</section>
						</div>
						<div class="toogle" data-plugin-toggle="">
							<section class="toggle">
								<label>DELIVERY DETAILS</label>
								<div class="toggle-content">
									<div id="lead_delivery_details"></div>
								</div>
							</section>
						</div>
						<div class="toogle" data-plugin-toggle="">
							<section class="toggle">
								<label>SETTLEMENT DETAILS</label>
								<div class="toggle-content">
									<div id="lead_settlement_details"></div>
								</div>
							</section>
						</div>
						<div class="toogle" data-plugin-toggle="">
							<section class="toggle">
								<label>FILE ATTACHMENTS</label>
								<input type="hidden" id="hidden_lead_id">
								<div class="toggle-content">
									<div id="file_attachments">
										<div class="row">
								      		<div class="col-md-12" id="attachment_table_id">
								      		</div>
								      	</div>
								      	<hr>
								      	<div class="row">
								      		<div class="col-md-12">
										        <div class="dropzone upload_file_attachment"></div>
									        </div>
								        </div>
									</div>
								</div>
							</section>
						</div>
						<div class="toogle" data-plugin-toggle="">
							<section class="toggle">
								<label>DEALER FILES</label>
								<div class="toggle-content">
									<div id="dealer_file_attachments">
										<div class="row">
								      		<div class="col-md-12" id="dealer_table">
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
											<tbody id="lead_actions_history"></tbody>
										</table>
									</div>
								</div>
							</section>
						</div>
						<div class="toogle" data-plugin-toggle="">
							<section class="toggle active">
								<label>STAGE HISTORY</label>
								<div class="toggle-content">
									<div id="lead_stage_history"></div>
								</div>
							</section>
						</div>
						<br />
						<div id="lead_comments"></div>
						<br />
						<div class="col-md-12 text-left" id="lead_email_actions"></div>
						<div class="col-md-12 text-left"><br /></div>
					</form>
				</div>
			</div>
		</div>
		<footer class="panel-footer">
			<div class="row">
				<div class="col-md-12 text-right">
					<div id="lead_actions"></div>
				</div>
			</div>
		</footer>
	</div>
</div>
<div id="sendorderpdf-modal" class="modal fade">
	<div class="modal-dialog" style="width: 80%;">
		<section class="panel">
			<header class="panel-heading">
				<h2 class="panel-title">Send Order PDF</h2>
			</header>
			<div class="panel-body">
				<div class="modal-wrapper">
					<div class="modal-text">
						<div class="form-group">
							<input value="0" id="lead_id" name="id_lead" type="hidden">
							<input value="" id="client_email" name="client_email" type="hidden">
							<input value="" id="dealer_email" name="dealer_email" type="hidden">
							<div class="col-md-4 text-left">
								<select class="form-control mb-md" id="user_type" name="user_type" title="Lead Status" onchange="load_email(this.value)">
									<option name="user_type" value="">-User type-</option>
									<option name="user_type" value="1">Client</option>
									<option name="user_type" value="2">Dealer</option>
								</select>
							</div>							
							<div class="col-md-8 text-left">
								<input class="form-control input-md" id="email" name="email" type="email" value="" placeholder="Email Address" required>
							</div>
							<div class="col-md-12 text-left"></div>
							<div class="col-md-12 text-left">
								<br />
								<table class="table table-bordered table-striped table-condensed mb-none">
									<thead>
										<tr><td colspan="4"><b>ORDER PDF RECIPIENTS</b></td></tr>
									</thead>
									<tbody id="order_recipients"></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-md-12 text-right">
						<button type="button" class="btn btn-primary" onclick="send_order_pdf()">Send</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</footer>
		</section>					
	</div>
</div>
<div id="send-clientconfirmation-modal" class="modal fade">
	<div class="modal-dialog" style="width: 80%;">
		<section class="panel">
			<header class="panel-heading">
				<h2 class="panel-title">Send Client Confirmation Link</h2>
			</header>
			<div class="panel-body">
				<div class="modal-wrapper">
					<div class="modal-text">
						<div class="form-group">
							<input value="0" id="lead_id" name="id_lead" type="hidden">
							<input value="" id="client_email" name="client_email" type="hidden">					
							<div class="col-md-6 text-left">
								<input class="form-control input-md" id="email" name="email" type="email" value="" placeholder="Email Address" required>
							</div>
							<div class="col-md-6 text-left"></div>
							<div class="col-md-12 text-left"></div>
							<div class="col-md-12 text-left">
								<br />
								<table class="table table-bordered table-striped table-condensed mb-none">
									<thead>
										<tr><td colspan="4"><b>EMAIL RECIPIENTS</b></td></tr>
									</thead>
									<tbody id="order_recipients"></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-md-12 text-right">
						<button type="button" class="btn btn-primary" onclick="send_clientconfirmation_email()">Send</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</footer>
		</section>					
	</div>
</div>
<div id="addleadticket-modal" class="modal fade">
	<div class="modal-dialog" style="width: 95%;">
		<div class="panel-body">
			<div class="modal-wrapper">
				<div class="modal-text">
					<form method="post" action="" id="main_form" name="main_form">
						<div class="form-group">
							<input value="" id="lead_id" name="id_lead" type="hidden">
							<input value="" id="cq_reference" name="cq_reference" type="hidden">
							<div class="col-md-4 text-left">
								<label>Type:</label>
								<select class="form-control input-md" id="ticket_type" name="ticket_type" type="text" required>
									<option name="ticket_type" value=""></option>
									<?php 
									foreach ($ticket_types as $ticket_type)
									{
										?>
										<option name="ticket_type" value="<?php echo $ticket_type->id_ticket_type; ?>"><?php echo $ticket_type->name; ?></option>
										<?php
									}
									?>
								</select>
							</div>
							<div class="col-md-4 text-left">
								<label>Priority:</label>
								<select class="form-control input-md" id="priority" name="priority" type="text" required>
									<option name="priority" value=""></option>
									<option name="priority" value="1">Urgent</option>
									<option name="priority" value="2">High</option>
									<option name="priority" value="3">Low</option>
								</select>
							</div>										
							<div class="col-md-4 text-left">
								<label>Module:</label>
								<select class="form-control input-md" id="module" name="module" type="text" required>
									<option name="module" value=""></option>
									<?php 
									foreach ($modules as $module)
									{
										?>
										<option name="module" value="<?php echo $module->id_module; ?>"><?php echo $module->name; ?></option>
										<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-6 text-left">
								<label>Subject:</label>
								<input class="form-control input-md" id="name" name="name" type="text" placeholder="Subject" maxlength="60"  required>
							</div>
							<div class="col-md-6 text-left">
								<label>Scheduled Start Date:</label>
								<?php $now = date("Y-m-d"); ?>
								<input class="form-control input-md datepicker" id="assignment_date" name="assignment_date" data-date-format="yyyy/mm/dd" value="<?php echo $now; ?>" required>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-12 text-left">
								<label>Assign to:</label>
								<select class="form-control input-md" id="user_id_to" name="user_id_to[]" type="text" required multiple data-plugin-selectTwo>
									<?php 
									foreach ($admins as $admin)
									{
										?>
										<option name="user_id_to" value="<?php echo $admin->id_user; ?>"><?php echo $admin->name; ?></option>
										<?php
									}
									?>
								</select>
							</div>
						</div>							
						<div class="form-group">										
							<div class="col-md-12 text-left">
								<label>Description:</label>
								<textarea id="description" name="description" class="form-control" rows="3" placeholder="Description" required></textarea>
							</div>								
						</div>
						<br />
						<div class="form-group">
							<div class="col-md-12 text-right">
								<button type="button" class="btn btn-primary" onclick="add_lead_ticket_action()">Submit</button>
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="addleadcomment-modal" class="modal fade">
	<div class="modal-dialog" style="width: 95%;">
		<div class="panel-body">
			<div class="modal-wrapper">
				<div class="modal-text">
					<form method="post" action="" id="main_form" name="main_form">
						<input type="hidden" id="lead_id" name="id_lead" value="" />
						<input type="hidden" id="lead_status_id" name="lead_status" value="" />										
						<div class="row">
							<div class="col-md-12">										
								<textarea id="lead_comment" name="comment" class="form-control" placeholder="Add a Comment"></textarea><br />
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div id="dz_al_comment_file" class="dropzone dz_al_comment_file"></div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">										
								<div id="al_uploaded_comment_files"></div>	
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<footer class="panel-footer">
			<div class="row">
				<div class="col-md-12 text-right">
					<button type="button" class="btn btn-primary" onclick="add_lead_comment_action()">Submit</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</footer>
	</div>
</div>
<div id="addquote-modal" class="modal fade">
	<div class="modal-dialog" style="width: 95%;">
		<section class="panel">
			<header class="panel-heading">
				<h2 class="panel-title">Add Dealer Quote</h2>
			</header>
			<div class="panel-body">
				<div class="modal-wrapper">
					<div class="modal-text">
						<div class="addquote">
							<form method="post" action="" id="main_form" name="main_form">
								<input type="hidden" name="hidden_process" id="hidden_process_old" value="insert">
								<input type="hidden" name="hidden_quote_request_id" id="hidden_quote_request_id_old">
								<input type="hidden" name="hidden_quote_id_sub" id="hidden_quote_id_sub_old">
								<input type="hidden" name="hidden_dealer_state" id="hidden_dealer_state">
								<input type="hidden" name="hidden_lead_state" id="hidden_lead_state">
								<input type="hidden" name="hidden_tradein_count" id="hidden_tradein_count">
								<input type="hidden" name="hidden_quote_request_lead_id" id="hidden_quote_request_lead_id">
								<div class="form-group">
									<div class="col-md-12 text-center">
										<h4>DEALER SELECTOR</h4><br />											
										<div class="col-md-4 text-left">
											<select class="form-control input-md" id="make_ds" name="make" type="text" onchange="load_dealers('addquote')">
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
										<div class="col-md-4 text-left">
											<select class="form-control input-md" id="state_ds" name="state" type="text" onchange="load_dealers('addquote')">
												<option name="state_ds" value="">Select State</option>
												<option name="state_ds" value="ACT">ACT - Australian Capital Territory</option>
												<option name="state_ds" value="NSW">NSW - New South Wales</option>
												<option name="state_ds" value="NT">NT - Northern Territory</option>
												<option name="state_ds" value="QLD">QLD - Queensland</option>
												<option name="state_ds" value="SA">SA - South Australia</option>
												<option name="state_ds" value="TAS">TAS - Tasmania</option>
												<option name="state_ds" value="VIC">VIC - Victoria</option>
												<option name="state_ds" value="WA">WA - Western Australia</option>
											</select>
										</div>
										<div class="col-md-4 text-left">
											<input class="form-control input-md" id="postcode_ds" name="postcode" type="text" value="" placeholder="Postcode" onchange="load_dealers('addquote')"><br />
										</div>
										<div class="col-md-12 text-left" id="suggested_dealers"></div>
										<div class="col-md-12 text-left">
											<br />
											<table class="table table-bordered table-striped table-condensed mb-none">
												<thead>
													<tr><td><b>SELECTED DEALER</b></td></tr>
												</thead>
												<tbody id="selected_dealers">
													<input type="hidden" value="0" id="dealer_id_inp" name="dealer_id">
												</tbody>
											</table>
											<hr />
											<br />
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-12 text-left">
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-condensed mb-none">
												<tbody>
													<tr>
														<td width="70%">Demo</td>
														<td>
															<select class="form-control input-sm" id="demo_lead_modals" name="demo" type="text">
																<option value="New">New</option>
																<option value="Demo">Demo</option>
															</select>
														</td>
													</tr>
													<tr>
														<td width="70%">VIN</td>
														<td><input value="" class="form-control input-sm" id="vin" name="vin" type="text" placeholder="VIN"></td>
													</tr>
													<tr>
														<td width="70%">Engine Number</td>
														<td><input value="" class="form-control input-sm" id="engine" name="engine" type="text" placeholder="Engine"></td>
													</tr>
													<tr>
														<td width="70%">Registration Plate</td>
														<td><input value="" class="form-control input-sm" id="registration_plate" name="registration_plate" type="text" placeholder="Registration Plate"></td>
													</tr>
													<tr>
														<td width="70%">Registration Expiry</td>
														<td><input value="" class="form-control input-sm" id="registration_expiry" name="registration_expiry" type="text" placeholder="Registration Expiry"></td>
													</tr>
													<tr id="tr_kms_lead_modal" hidden>
														<td width="70%">KMS</td>
														<td><input value="0" class="form-control input-sm" id="kms" name="kms" type="text" placeholder="KMS" onkeypress="return isNumberKey(event)"></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-12 text-left">
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-condensed mb-none">
												<tbody>	
													<tr>
														<td width="70%">List Price</td>
														<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="retail_price" name="retail_price" type="text" placeholder="0" onchange="calculate_modal_quote()" required></td>
													</tr>
													<tr>
														<td>Discount</td>
														<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="dealer_discount" name="dealer_discount" type="text" placeholder="0" onchange="calculate_modal_quote()" required></td>
													</tr>													
													<tr>
														<td>Fleet Claim</td>
														<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="fleet_discount" name="fleet_discount" type="text" placeholder="0" onchange="calculate_modal_quote()" required></td>
													</tr>
													<tr>
														<td><b>SUBTOTAL</b></td>
														<td><input value="0" class="form-control input-sm subtotal_1" id="subtotal_1" name="subtotal_1" type="text" placeholder="0" onchange="calculate_modal_quote()" readonly></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<!-- <div class="form-group">
									<div class="col-md-12 text-left">
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-condensed mb-none">
												<tbody>	
													<tr>
														<td><b>Metallic Paint</b></td>
														<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="metallic_paint" name="metallic_paint" type="text" placeholder="0" onchange="calculate_modal_quote()" required></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div> -->
								<div class="form-group">
									<div class="col-md-12 text-left" id="options_content"></div>
								</div>													
								<div class="form-group">
									<div class="col-md-12 text-left" id="accessories_content"></div>
								</div>
								<div class="form-group">
									<div class="col-md-12 text-left">
										<div class="table-responsive">							
											<table class="table table-bordered table-striped table-condensed mb-none">
												<tbody>										
													<tr>
														<td width="70%">Delivery Charge</td>
														<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="predelivery" name="predelivery" type="text" placeholder="0"onchange="calculate_modal_quote()" required></td>
													</tr>
													<tr>
														<td><b>SUBTOTAL</b></td>
														<td><input value="0" class="form-control input-sm subtotal_2" id="subtotal_2" name="subtotal_2" type="text" placeholder="0" onchange="calculate_modal_quote()" readonly></td>
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
														<td><input value="0" class="form-control input-sm" id="gst" name="gst" type="text" placeholder="0" onchange="calculate_modal_quote()" readonly></td>
													</tr>																
													<tr>
														<td><b>SUBTOTAL</b></td>
														<td><input value="0" class="form-control input-sm" id="subtotal_3" name="subtotal_3" type="text" placeholder="0" onchange="calculate_modal_quote()" readonly></td>
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
														<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="luxury_tax" name="luxury_tax" type="text" placeholder="0" onchange="calculate_modal_quote()" required></td>
													</tr>
													<tr>
														<td>CTP</td>
														<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm ctp" id="ctp" name="ctp" type="text" placeholder="0" onchange="calculate_modal_quote()" required></td>
													</tr>																																
													<tr>
														<td>Registration</td>
														<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm registration" id="registration" name="registration" type="text" placeholder="0" onchange="calculate_modal_quote()" required></td>
													</tr>
													<tr>
														<td>Premium Plate Fee</td>
														<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="premium_plate_fee" name="premium_plate_fee" type="text" placeholder="0" onchange="calculate_modal_quote()" required></td>
													</tr>
													<tr>
														<td>Stamp Duty</td>
														<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm stamp_duty" id="stamp_duty" name="stamp_duty" type="text" placeholder="0" onchange="calculate_modal_quote()" required></td>
													</tr>
													<tr>
														<td><b>TOTAL INC GST</b></td>
														<td><input value="0" class="form-control input-sm" id="total" name="total" type="text" placeholder="0" readonly></td>
													</tr>
													<tr>
														<td>Tradein Value (-)</td>
														<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="dealer_tradein_value" name="dealer_tradein_value" type="text" placeholder="0" onchange="calculate_modal_quote()" required></td>
													</tr>
													<tr>
														<td>Tradein Payout (+)</td>
														<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="dealer_tradein_payout" name="dealer_tradein_payout" type="text" placeholder="0" onchange="calculate_modal_quote()" required></td>
													</tr>
													<tr>
														<td>Refund to Client (+)</td>
														<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="dealer_client_refund" name="dealer_client_refund" type="text" placeholder="0" onchange="calculate_modal_quote()" required></td>
													</tr>
													<tr>
														<td><b>Changeover</b></td>
														<td><input value="0" class="form-control input-sm" id="dealer_changeover" name="dealer_changeover" type="text" placeholder="0" readonly></td>
													</tr>												
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="form-group" id="checkbox_form" hidden>
									<div class="col-md-12 text-left">
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-condensed mb-none" >
												<tbody>
													<tr>
														<td>Is the Dealer paying for the transport of the Trading Vehicle?</td>
														<td><center><input type="checkbox" class="transport_checkbox" name="transport_checkbox" value="Yes"></center></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-12 text-left">									
										<div class="table-responsive">												
											<table class="table table-bordered table-striped table-condensed mb-none">
												<tbody>
													<tr>
														<td width="30%">Estimated Date of Delivery</td>
														<td><input class="datepicker form-control input-sm" id="delivery_date" name="delivery_date" data-date-format="yyyy/mm/dd" style="width: 100%" required></td>
													</tr>
													<tr>
														<td>Compliance Date</td>
														<td><input value="" class="form-control input-sm" id="compliance_date" name="compliance_date" type="text" placeholder="(MM/YY)" style="width: 100%" required></td>
													</tr>
													<tr>
														<td><b>Dealer Notes</b></td>
														<td><textarea id="notes" name="notes" class="form-control" rows="5" placeholder=""></textarea></td>
													</tr>																
												</tbody>
											</table>													
										</div>												
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-md-12 text-right">
						<span id="starttender_loader"></span>
						<button type="button" class="btn btn-primary" onclick="submit_quote()">Submit</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</footer>
		</section>					
	</div>
</div>
<div id="addquote-modal-request" class="modal fade">
	<div class="modal-dialog" style="width: 90%;">
		<section class="panel">
			<header class="panel-heading">
				<h2 class="panel-title">Dealer Quote</h2>
			</header>
			<div class="panel-body">
				<div class="modal-wrapper">
					<div class="modal-text">
						<div class="quote">
							<form method="post" id="addquote-modal-form">
							<span class="btn btn-primary btn-xs pull-right open-audit-trail" style="cursor: pointer; cursor: hand;">View Changes</span>
							<h4 id="title">CAR<small id="demo_new_flag"></small></h4>
								<br/>
								<div class="row">
									<input type="hidden" name="hidden_process" id="hidden_process">
									<input type="hidden" name="hidden_quote_id_sub" id="hidden_quote_id_sub">
									<input type="hidden" name="hidden_quote_request_id" id="hidden_quote_request_id">
									<input type="hidden" name="hidden_dealer_id" id="hidden_dealer_id">
									<input type="hidden" name="hidden_quote_request_lead_id" id="hidden_quote_request_lead_id">
									<div class="col-md-5">
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-condensed mb-none">
												<tr><td>Make</td><td id="make"></td></tr>
												<tr><td>Model</td><td id="model"></td></tr>
												<tr><td>Variant</td><td id="variant"></td></tr>
												<tr><td>Build Date</td><td id="build_date"></td></tr>
												<tr><td>Series</td><td id="series"></td></tr>
												<tr><td>Body Type</td><td id="series"></td></tr>
												<tr><td>Transmission</td><td id="transmission"></td></tr>
												<tr><td>Fuel Type</td><td id="fuel_type"></td></tr>
												<tr><td>Colour</td><td id="colour"></td></tr>
												<tr><td>Registration Type</td><td id="registration_type"></td></tr>
												<tr id="kms_tr"><td>KMS</td><td ><input class="form-control input-sm" id="kms" name="kms" type="text" required>
												<input type="hidden" name="demo" value="" id="demo">
												</td></tr>
												<tr><td>VIN</td><td ><input class="form-control input-sm" id="vin" name="vin" type="text" required></td></tr>
												<tr><td>Engine Number</td><td ><input class="form-control input-sm" id="engine" name="engine" type="text" required></td></tr>
												<tr><td>Registration Plate</td><td ><input class="form-control input-sm" id="registration_plate" name="registration_plate" type="text" required></td></tr>
												<tr><td>Registration Expiry</td><td ><input class="form-control input-sm" id="registration_expiry" name="registration_expiry" type="text" required></td></tr>
											</table>
										</div>						
										<br />
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-condensed mb-none">
												<tbody>	
													<tr>
														<td width="70%">List Price</td>
														<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="retail_price" name="retail_price" type="text" placeholder="0" onchange="calculate_quote()" required></td>
													</tr>
													<tr>
														<td>Discount (-)</td>
														<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="dealer_discount" name="dealer_discount" type="text" placeholder="0" onchange="calculate_quote()" required></td>
													</tr>														
													<tr>
														<td>Fleet Claim (-)</td>
														<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="fleet_discount" name="fleet_discount" type="text" placeholder="0" onchange="calculate_quote()" required></td>
													</tr>
													<tr>
														<td><b>SUBTOTAL</b></td>
														<td><input value="0" class="form-control input-sm" id="subtotal_1" name="subtotal_1" type="text" placeholder="0" onchange="calculate_quote()" readonly></td>
													</tr>
												</tbody>
											</table>
										</div>
										<!-- <br />
										<table class="table table-bordered table-striped table-condensed mb-none">
											<tbody>	
												<tr>
													<td><b>Metallic Paint</b></td>
													<td><input value="0" class="form-control input-sm" id="metallic_paint" name="metallic_paint" type="text" placeholder="0" onchange="calculate_quote()"></td>
												</tr>
											</tbody>
										</table> -->
										<br />
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-condensed mb-none">
												<table class="table table-bordered table-striped table-condensed mb-none">
													<tbody>										
														<tr>
															<td width="70%">Delivery Charge</td>
															<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="predelivery" name="predelivery" type="text" placeholder="0"onchange="calculate_quote()" required></td>
														</tr>
														<tr>
															<td><b>SUBTOTAL</b></td>
															<td><input value="0" class="form-control input-sm" id="subtotal_2" name="subtotal_2" type="text" placeholder="0" onchange="calculate_quote()" readonly></td>
														</tr>
													</tbody>
												</table>
											</table>
										</div>
										<br/>
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-condensed mb-none">
												<tbody>																								
													<tr>
														<td width="70%">GST</td>
														<td><input value="0" class="form-control input-sm" id="gst" name="gst" type="text" placeholder="0" onchange="calculate_quote()" readonly></td>
													</tr>
													<tr>
														<td><b>SUBTOTAL</b></td>
														<td><input value="0" class="form-control input-sm" id="subtotal_3" name="subtotal_3" type="text" placeholder="0" onchange="calculate_quote()" readonly></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
									<div class="col-md-7">
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-condensed mb-none" id="options_dom">
												
											</table>
										</div>
										<br />
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-condensed mb-none" id="accessories_dom">
												
											</table>
										</div>
										<br />
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-condensed mb-none">
												<tr>
													<td width="70%">Luxury Tax</td>
													<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="luxury_tax" name="luxury_tax" type="text" placeholder="0" onchange="calculate_quote()" required></td>
												</tr>
												<tr>
													<td>CTP</td>
													<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="ctp" name="ctp" type="text" placeholder="0" onchange="calculate_quote()" required></td>
												</tr>																																
												<tr>
													<td>Registration</td>
													<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="registration" name="registration" type="text" placeholder="0" onchange="calculate_quote()" required></td>
												</tr>
												<tr>
													<td>Premium Plate Fee</td>
													<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="premium_plate_fee" name="premium_plate_fee" type="text" placeholder="0" onchange="calculate_quote()" required></td>
												</tr>
												<tr>
													<td>Stamp Duty</td>
													<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="stamp_duty" name="stamp_duty" type="text" placeholder="0" onchange="calculate_quote()" required></td>
												</tr>
												<tr>
													<td><b>TOTAL INC GST</b></td>
													<td><input value="0" class="form-control input-sm" id="total" name="total" type="text" placeholder="0" readonly></td>
												</tr>
												<tr>
													<td>Tradein Value (-)</td>
													<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="dealer_tradein_value" name="dealer_tradein_value" type="text" placeholder="0" onchange="calculate_quote()" required></td>
												</tr>
												<tr>
													<td>Tradein Payout (+)</td>
													<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="dealer_tradein_payout" name="dealer_tradein_payout" type="text" placeholder="0" onchange="calculate_quote()" required></td>
												</tr>
												<tr>
													<td>Refund to Client (+)</td>
													<td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="dealer_client_refund" name="dealer_client_refund" type="text" placeholder="0" onchange="calculate_quote()" required></td>
												</tr>
												<tr>
													<td><b>Changeover</b></td>
													<td><input value="0" class="form-control input-sm" id="dealer_changeover" name="dealer_changeover" type="text" placeholder="0" readonly></td>
												</tr>
											</table>
										</div>
										<br/>
										<table class="table table-bordered table-striped table-condensed mb-none" id="checkbox_tbl">
											<tbody>
												<tr>
													<td>Is the Dealer paying for the transport of the Trading Vehicle?</td>
													<td><center><input type="checkbox" class="transport_checkbox" id="transport_checkbox" name="transport_checkbox" value="Yes"></center></td>
												</tr>
											</tbody>
										</table>
										<br/>
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-condensed mb-none">
												<tbody>
													<tr>
														<td width="30%">Estimated Date of Delivery</td>
														<td><input class="datepicker form-control input-sm" id="delivery_date" name="delivery_date" data-date-format="yyyy-mm-dd" style="width: 100%" required></td>
													</tr>
													<tr>
														<td>Compliance Date</td>
														<td><input value="" class="form-control input-sm" id="compliance_date" name="compliance_date" type="text" placeholder="(MM/YY)" style="width: 100%" required></td>
													</tr>
													<tr>
														<td><b>Dealer Notes</b></td>
														<td><textarea id="notes" name="notes" class="form-control" rows="5" id="textareaDefault" placeholder=""></textarea></td>
													</tr>																
												</tbody>
											</table>
										</div>
									</div>

								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-md-12 text-right">
						<button type="button" class="btn btn-primary" onclick="submit_new_edit_quote()">Submit</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</footer>
		</section>
	</div>
</div>
<div id="audit_trail" class="modal fade">
	<div class="modal-dialog" style="width: 70%;">
		<section class="panel">
			<header class="panel-heading">
				<h2 class="panel-title">Quote Audit Trail</h2>
			</header>
			<div class="panel-body">
				<div class="modal-wrapper">
					<div class="modal-text" id="audit_body">
						
					</div>
				</div>
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-md-12 text-right">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</footer>
		</section>
	</div>
</div>
<div id="adddealers-modal" class="modal fade">
	<div class="modal-dialog" style="width: 95%;">
		<section class="panel">
			<header class="panel-heading">
				<h2 class="panel-title">Add Dealers</h2>
			</header>
			<div class="panel-body">
				<div class="modal-wrapper">
					<div class="modal-text">
						<div class="addealers">
							<div class="form-group">
								<div class="col-md-4 text-left">
									<select class="form-control input-md" id="make_ds" name="make" type="text" onchange="load_dealers('adddealers')">
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
								<div class="col-md-4 text-left">
									<select class="form-control input-md" id="state_ds" name="state" type="text" onchange="load_dealers('adddealers')">
										<option name="state" value="">Select State</option>
										<option name="state" value="ACT">ACT - Australian Capital Territory</option>
										<option name="state" value="NSW">NSW - New South Wales</option>
										<option name="state" value="NT">NT - Northern Territory</option>
										<option name="state" value="QLD">QLD - Queensland</option>
										<option name="state" value="SA">SA - South Australia</option>
										<option name="state" value="TAS">TAS - Tasmania</option>
										<option name="state" value="VIC">VIC - Victoria</option>
										<option name="state" value="WA">WA - Western Australia</option>
									</select>
								</div>
								<div class="col-md-4 text-left">
									<input class="form-control input-md" id="postcode_ds" name="postcode" type="text" value="" placeholder="Postcode" onchange="load_dealers('adddealers')"><br />
								</div>
								<div class="col-md-12 text-left" id="suggested_dealers"></div>
								<div class="col-md-12 text-left">
									<br />
									<table class="table table-bordered table-striped table-condensed mb-none">
										<thead>
											<tr><td><b>SELECTED DEALERS</b></td><td></td></tr>
										</thead>
										<tbody id="selected_dealers"></tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-md-12 text-right">
						<input value="0" id="dealer_ids_inp" name="dealer_ids" type="hidden">
						<button type="button" class="btn btn-primary" onclick="add_dealer_request()">Send</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</footer>
		</section>					
	</div>
</div>
<div id="starttender-modal" class="modal fade">
	<div class="modal-dialog" style="width: 95%;">
		<section class="panel">
			<header class="panel-heading">
				<h2 class="panel-title">Tender Form</h2>
			</header>
			<div class="panel-body">
				<div class="modal-wrapper">
					<div class="modal-text">
						<div class="addealers">
							<form method="post" action="" id="main_form" name="main_form">
								<input type="hidden" value="" id="lead_id" name="id_lead" />
								<input type="hidden" value="0" id="dealer_ids_inp" name="dealer_ids">
								<div class="form-group">
									<div class="col-md-3 text-left">
										<label>CQ Number:</label>
										<input value="" class="form-control input-md" id="cq_number" name="cq_number" type="text" required readonly><br />
									</div>
									<div class="col-md-3 text-left">
										<label>Client Email:</label>
										<input value="" class="form-control input-md" id="email" name="email" type="text" required><br />
									</div>									
									<div class="col-md-3 text-left">
										<label>Client Name:</label>
										<input value="" class="form-control input-md" id="name" name="name" type="text" required><br />
									</div>													
									<div class="col-md-3 text-left">
										<label>Postcode:</label>
										<input value="" class="form-control input-md" id="postcode" name="postcode" type="text" required><br />
									</div>
									<div class="col-md-3 text-left">
										<label><font color="red">*</font> Make:</label>
										<select class="form-control" id="make" name="make" title="Make" onchange="load_families(this.options[this.selectedIndex].value, 'starttender')" required>
											<option name="make" value="0"></option>
											<?php 
											foreach ($makes as $make)
											{
												?>
												<option name="make" value="<?php echo $make->id_make; ?>"><?php echo $make->name; ?></option>
												<?php
											}
											?>
										</select>
										<br />
									</div>
									<div class="col-md-3 text-left">
										<label><font color="red">*</font> Model:</label>
										<select class="form-control" id="family" name="family" title="Model" onchange="load_build_dates(this.options[this.selectedIndex].value, 'starttender')" disabled>
											<option name="family" value=""><span class="loader"></span></option>
										</select>
										<br />
									</div>
									<div class="col-md-3 text-left">
										<label><font color="red">*</font> Build Date:</label>
										<select class="form-control" id="build_date" name="build_date" title="Build Date" onchange="load_vehicles(this.options[this.selectedIndex].value, 'starttender')" disabled>
											<option name="build_date" value=""><span class="loader"></span></span></option>
										</select>
										<br />
									</div>													
									<div class="col-md-3 text-left">
										<label><font color="red">*</font> Variant:</label>
										<select class="form-control" id="vehicle" name="vehicle" title="Variant" onchange="load_options(this.options[this.selectedIndex].value, 'starttender')" disabled>
											<option name="vehicle" value=""><span class="loader"></span></option>
										</select>
										<br />
									</div>
									<div class="col-md-6 text-left">
										<label><font color="red">*</font> Colour:</label>
										<input value="" class="form-control input-md" id="colour" name="colour" type="text" required><br />
									</div>													
									<div class="col-md-6 text-left">
										<label><font color="red">*</font> Registration Type:</label>
										<select class="form-control input-md" id="registration_type" name="registration_type" type="text" required>
											<option name="registration_type" value=""></option>
											<option name="registration_type" value="Business">Business</option>
											<option name="registration_type" value="Private">Private</option>
											<option name="registration_type" value="Pensioner">Pensioner</option>
											<option name="registration_type" value="Exempt">Exempt</option>
											<option name="registration_type" value="TPI/Gold Card">TPI/Gold Card</option>
										</select>
									</div>
									<div class="col-md-12 text-left">
										<hr /><h4>OPTIONS</h4><br />
									</div>
									<div class="col-md-12 text-left" id="options">
										
									</div>
									<div class="col-md-12 text-left" id="accessory_container">
										<hr /><h4>ACCESSORIES</h4><br />
										<div class="col-md-12 text-left">
											<input class="form-control input-md" name="accessory_name[]" type="text" placeholder="Accessory"><br />
										</div>
										<div class="col-md-12 text-left">
											<textarea class="form-control" name="accessory_desc[]" rows="3" id="textareaDefault" placeholder="Description"></textarea>
										</div>
									</div>
									<div class="col-md-12 text-right">
										<br /><button type="button" class="btn btn-default" onclick="add_accessory('starttender')">Add Accessory</button>
									</div>

									<div class="col-md-12 text-left">
										<hr /><h4>DEALER SELECTOR</h4><br />											
									</div>
									<div class="col-md-4 text-left">
										<select class="form-control input-md" id="make_ds" name="make_ds" type="text" onchange="load_dealers('starttender')">
											<option name="make_ds_st" value=""></option>
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
									<div class="col-md-4 text-left">
										<select class="form-control input-md" id="state_ds" name="state_ds" type="text" onchange="load_dealers('starttender')">
											<option name="state_ds_st" value="">Select State</option>
											<option name="state_ds_st" value="ACT">ACT - Australian Capital Territory</option>
											<option name="state_ds_st" value="NSW">NSW - New South Wales</option>
											<option name="state_ds_st" value="NT">NT - Northern Territory</option>
											<option name="state_ds_st" value="QLD">QLD - Queensland</option>
											<option name="state_ds_st" value="SA">SA - South Australia</option>
											<option name="state_ds_st" value="TAS">TAS - Tasmania</option>
											<option name="state_ds_st" value="VIC">VIC - Victoria</option>
											<option name="state_ds_st" value="WA">WA - Western Australia</option>
										</select>
									</div>
									<div class="col-md-4 text-left">
										<input class="form-control input-md" id="postcode_ds" name="postcode_ds" type="text" value="" placeholder="Postcode" onchange="load_dealers('starttender')"><br />
									</div>
									<div class="col-md-12 text-left" id="suggested_dealers"><span id="loader"></span></div>
									<div class="col-md-12 text-left">
										<br />
										<table class="table table-bordered table-striped table-condensed mb-none">
											<thead>
												<tr><td><b>SELECTED DEALERS</b></td><td></td></tr>
											</thead>
											<tbody id="selected_dealers"></tbody>
										</table>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-md-12 text-right">
						<button type="button" class="btn btn-primary" onclick="start_tender()">Send</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</footer>
		</section>					
	</div>
</div>
<div id="submit-deal-modal" class="modal fade">
	<div class="modal-dialog" style="width: 60%;">
		<section class="panel">
			<header class="panel-heading">
				<h2 class="panel-title">Deal Submission</h2>
			</header>
			<div class="panel-body">
				<div class="modal-wrapper">
					<div class="modal-text">
						<div id="submitdeal"></div>
					</div>
				</div>
			</div>
		</section>					
	</div>
</div>
<div id="emailinvite-modal" class="modal fade">
	<div class="modal-dialog" style="width: 80%;">
		<section class="panel">
			<header class="panel-heading">
				<h2 class="panel-title">Email Invite</h2>
			</header>
			<div class="panel-body">
				<div class="modal-wrapper">
					<div class="modal-text">
						<div class="form-group">
							<div class="col-md-12 text-left">
								<input value="0" id="id_quote_request" name="id_quote_request" type="hidden">
								<input class="form-control input-md" id="email" name="email" type="email" value="" placeholder="Email Address" required>
							</div>
							<div class="col-md-12 text-left"></div>
							<div class="col-md-12 text-left">
								<br />
								<table class="table table-bordered table-striped table-condensed mb-none">
									<thead>
										<tr><td><b>INVITED EMAIL ADDRESSES</b></td></tr>
									</thead>
									<tbody id="email_invites"></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-md-12 text-right">
						<button type="button" class="btn btn-primary" onclick="add_email_invite()">Send</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</footer>
		</section>					
	</div>
</div>
<div id="editvehicle-modal" class="modal fade">
	<div class="modal-dialog" style="width: 95%;">
		<section class="panel">
			<header class="panel-heading">
				<h2 class="panel-title">Edit Vehicle</h2>
			</header>
			<div class="panel-body">
				<div class="modal-wrapper">
					<div class="modal-text">
						<div class="editvehicle">
							<form method="post" action="" id="main_form" name="main_form">
								<input value="" id="id_quote_request" name="id_quote_request" type="hidden">
								<div class="form-group">
									<div class="col-md-3 text-left">
										<label><font color="red">*</font> Make:</label>
										<select class="form-control" id="make" name="make" title="Make" onchange="load_families(this.options[this.selectedIndex].value, 'editvehicle', 0)" required>
											<option name="make" value="0"></option>
										</select>
										<br />
									</div>
									<div class="col-md-3 text-left">
										<label><font color="red">*</font> Model:</label>
										<select class="form-control" id="family" name="family" title="Model" onchange="load_build_dates(this.options[this.selectedIndex].value, 'editvehicle', 0)">
											<option name="family" value="0"></option>
										</select>
										<br />
									</div>
									<div class="col-md-3 text-left">
										<label><font color="red">*</font> Build Date:</label>
										<select class="form-control" id="build_date" name="build_date" title="Build Date" onchange="load_vehicles(this.options[this.selectedIndex].value, 'editvehicle', 0)">
											<option name="build_date" value="0"></option>
										</select>
										<br />
									</div>			
									<div class="col-md-3 text-left">
										<label><font color="red">*</font> Variant:</label>
										<select class="form-control" id="vehicle" name="vehicle" title="Variant" onchange="load_options(this.options[this.selectedIndex].value, 'editvehicle', 0)">
											<option name="vehicle" value="0"></option>
										</select>
										<br />
									</div>
									<div class="col-md-6 text-left">
										<label><font color="red">*</font> Colour:</label>
										<input value="" class="form-control input-md" id="colour" name="colour" type="text" required><br />
									</div>													
									<div class="col-md-6 text-left">
										<label><font color="red">*</font> Registration Type:</label>
										<select class="form-control input-md" id="registration_type" name="registration_type" type="text" required>
											<option name="registration_type" value=""></option>
											<option name="registration_type" value="Business">Business</option>
											<option name="registration_type" value="Private">Private</option>
											<option name="registration_type" value="Pensioner">Pensioner</option>
											<option name="registration_type" value="Exempt">Exempt</option>
										</select>
									</div>
									<div class="col-md-12 text-left">
										<hr /><h4>OPTIONS</h4><br />
									</div>
									<div class="col-md-12 text-left" id="options">
									</div>
									<div class="col-md-12 text-left" id="accessory_container">
										<hr /><h4>ACCESSORIES</h4><br />
										<div id="accessories"></div>
									</div>
									<div class="col-md-12 text-right">
										<br /><button type="button" class="btn btn-default" onclick="add_accessory('editvehicle')">Add Accessory</button>
									</div>													
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-md-12 text-right">
						<span id="starttender_loader"></span>
						<button type="button" class="btn btn-primary" onclick="update_vehicle()">Send</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</footer>
		</section>					
	</div>
</div>
<div id="quote-modal" class="modal fade">
	<div class="modal-dialog" style="width: 90%;">
		<section class="panel">
			<header class="panel-heading">
				<h2 class="panel-title">Dealer Quote</h2>
			</header>
			<div class="panel-body">
				<div class="modal-wrapper">
					<div class="modal-text">
						<div class="quote"></div>
					</div>
				</div>
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-md-12 text-right">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</footer>
		</section>
	</div>
</div>
<div id="tradeindetails-modal" class="modal fade">
	<div class="modal-dialog" style="width: 95%;">
		<section class="panel">
			<header class="panel-heading">
				<h2 class="panel-title">Trade Details</h2>
			</header>
			<div class="panel-body">
				<div class="modal-wrapper">
					<div class="modal-text">
						<input type="hidden" id="image-no">
						<input type="hidden" id="image-oldname">
						<input type="hidden" id="modal-id">
						<input type="hidden" id="modal-id-2">
						<form method="post" action="" id="tradein_form" name="tradein_form">
							<div class="tradein_details" id="tradein_details"></div>
						</form>
					</div>
				</div>
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-md-12 text-right">
						<?php
						if ($login_type=="Admin")
						{
							?>
							<button type="button" class="btn btn-primary" onclick="save_tradein_info()">Save</button>
							<?php
						}
						?>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</footer>
		</section>
	</div>
</div>
<div id="add-dep-modal" class="modal fade">
	<div class="modal-dialog" style="width: 95%;">
		<div class="panel-body">
			<div class="modal-wrapper">
				<div class="modal-text">
					<form method="post" action="<?= site_url('deal/add_payment'); ?>" class="main_form" name="main_form" id="nonce-form">
						<input type="hidden" class="lead_id" name="lead_id" value="" />
						<input type="hidden" class="code" name="code" value="2" />
						<input type="hidden" class="parent_modal" name="parent_modal" value="2" />
						<input type="hidden" class="status_flag" name="status_flag" value="0" />
						<input type="hidden" class="nonce" name="nonce" value="" id="card-nonce" >
						<div class="row" style="border: 1px solid #ccc; padding-top: 15px; padding-bottom: 15px; margin-left: 0px; margin-right: 0px;">
							<div class="col-md-4">
								<input type="text" name="amount" onkeypress="return isNumberKey(event)" class="form-control mb-md amount_inp" placeholder="Amount" />
							</div>
							<div class="col-md-8">
							</div>

							<div class="col-md-12" style="margin-top: 10px; margin-bottom: 10px;" >

								<!-- <div><input type="radio" name="deposit_method" class="deposit_method cred-card" value="1" disabled=""> Credit Card Payment (<i>Eway</i>)</div>
								<div><input  <?= ($this->session->userdata('user_id')!="255") ? "disabled=''" : "" ?> type="radio" name="deposit_method" class="deposit_method cred-card-squareup" value="3"> Credit Card Payment (<i>Squareup</i>) UNDER CONSTRUCTION</div> -->
								<div><input type="radio" name="deposit_method" class="deposit_method ref-number" value="2"> External Payment</div>

							</div>
							<div class="col-md-12 hidden-credit-card" hidden>

								<div class="table-responsive">
									<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
										<tbody>
											<tr>
												<td><font color="red">*</font> First Name</td>
												<td><input type="text" class="form-control input-sm first_name_inp" name="first_name"></td>
											</tr>
											<tr>
												<td><font color="red">*</font> Last Name</td>
												<td><input type="text" class="form-control input-sm last_name_inp" name="last_name"></td>
											</tr>
											<tr>
												<td><font color="red">*</font> Credit Card Number</td>
												<td><input type="text" class="form-control input-sm credit_card_number_inp" name="credit_card_number"></td>
											</tr>
											<tr>
												<td><font color="red">*</font> Credit Card Type</td>
												<td><input type="text" class="form-control input-sm card_type" name="card_type" disabled></td>
											</tr>
											<tr>
												<td><font color="red">*</font> Expiry (Month)</td>
												<td><input type="text" class="form-control input-sm expiry_month_inp" name="expiry_month"></td>
											</tr>
											<tr>
												<td><font color="red">*</font> Expiry (Year)</td>
												<td><input type="text" class="form-control input-sm expiry_year_inp" name="expiry_year"></td>
											</tr>
											<tr>
												<td><font color="red">*</font> CVN</td>
												<td><input type="text" class="form-control input-sm cvn_inp" name="cvn"></td>
											</tr>
										</tbody>
									</table>
								</div>

							</div>
							<div class="col-md-12 hidden-squareup-card" hidden>

								<div class="table-responsive">
									<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
										<tbody>
											<tr>
												<td><font color="red">*</font> First Name</td>
												<td><input type="text" class="form-control input-sm firstname_squareup" name="first_name" id="firstname_squareup"></td>
											</tr>
											<tr>
												<td><font color="red">*</font> Last Name</td>
												<td><input type="text" class="form-control input-sm lastname_squareup" name="last_name" id="lastname_squareup"></td>
											</tr>
											<tr>
												<td><font color="red">*</font> Credit Card Number</td>
												<td><input type="text" class="form-control input-sm cc_number_squareup" name="credit_card_number" id="cc_number_squareup"></td>
											</tr>
											<tr>
												<td><font color="red">*</font> Expiration</td>
												<td><input type="text" class="form-control input-sm expiration_squareup" name="expiry_month" id="expiration_squareup"></td>
											</tr>
											<tr>
												<td><font color="red">*</font> CVN</td>
												<td><input type="text" class="form-control input-sm cvn_squareup" name="cvn" id="cvn_squareup"></td>
											</tr>
											<tr>
												<td><font color="red">*</font> Postcode</td>
												<td><input type="text" class="form-control input-sm postcode_squareup" name="postcode" id="postcode_squareup"></td>
											</tr>
										</tbody>
									</table>
								</div>

							</div>
							<div class="col-md-12 hidden-reference" hidden>

								<div class="table-responsive">
									<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
										<tbody>
											<tr>
												<td><font color="red">*</font> Bank Account</td>
												<td>
													<select class="form-control input-sm bank_account" name="bank_account">
													<?php
													foreach ($bank_accounts as $bank_account)
													{
														?>
														<option value="<?php echo $bank_account->id_bank_account; ?>">
															<?php echo $bank_account->name; ?>
														</option>
														<?php
													}
													?>	
													</select>
												</td>
											</tr>
											<tr>
												<td><font color="red">*</font> Reference Number</td>
												<td><input type="text" class="form-control input-sm reference_number" name="reference_number"></td>
											</tr>
											<tr>
												<td>Admin Fee</td>
												<td><input type="text" class="form-control input-sm optional_ad_fee" name="optional_ad_fee" placeholder="Optional" onkeypress="return isNumberKey(event)"></td>
											</tr>
											<tr>
												<td>Remarks</td>
												<td><textarea class="form-control payment_remarks" placeholder="Remarks..." name="payment_remarks"></textarea></td>
											</tr>
											<tr>
												<td><font color="red">*</font> Payment Date</td>
												<td><input type="text" class="form-control input-sm payment_date" name="payment_date" value="<?php echo $now; ?>" data-date-format="yyyy-mm-dd"></td>
											</tr>
										</tbody>
									</table>
								</div>

							</div>
							<div class="col-md-2 col-md-offset-10" style="margin-top: 10px;">
								<button type="button" class="btn btn-primary btn-block add_deposit" >Add Deposit</button>
								<!-- <button type="button" class="btn btn-success btn-block squareup_auth"  disabled>Authorize Card (for Squareup Transactions)</button> -->
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<br />
								<div class="table-responsive">
									<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
										<thead>
											<tr>
												<th></th>
												<th></th>
												<th></th>
												<th ><b>Payment Code</b></th>
												<th ><b>Reference No.</b></th>
												<th ><b>Amount</b></th>
												<th ><b>User</b></th>
												<th ><b>Payment Date</b></th>
												<th ><b>Admin Fee</b></th>
												<th ><b>Refunded Status</b></th>
												<td><b>Show Status</b></td>
												<th ><b>Merchant Cost</b></th>
												<th ><b>Status</b></th>
												<th ><b>Date Created</b></th>
											</tr>
										</thead>
										<tbody class="deposits"></tbody>
									</table>
									<br />
								</div>
							</div>
						</div>		
					</form>
				</div>
			</div>
		</div>
		<footer class="panel-footer">
			<div class="row">
				<div class="col-md-12 text-right">
					<div class="actions"></div>
				</div>
			</div>
		</footer>
	</div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="tradein_documents_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <input type="hidden" id="doc_modal_id" value="">
      <div class="modal-body" id="tradein_doc_modal_body">
        <i>You have not uploaded anything here yet...</i>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="wh_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <header class="panel-heading">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">ADMIN TRADE CHECKLIST</h4>
      </header>
      <div class="modal-body" id="wh_modal_body">
      	<form action="post" id="trade_cl_form">
      		<input type="hidden" id="wh_modal_id" value="" name="hidden_id">
	        <div class="row row-input">
	        	<div class="col-md-4">
	        		Date / Time of Pickup
	        	</div>
	        	<div class="col-md-4">
	        		<input class="form-control input-sm pickup_date" id="pickup_date" name="pickup_date" data-date-format="yyyy-mm-dd" >
	        	</div>
	        	<div class="col-md-4">
	        		<input class="form-control input-sm pickup_time" id="pickup_time" name="pickup_time">
	        	</div>
	        </div>
	        <div class="row row-input">
	        	<div class="col-md-4">
	        		Type of Contact
	        	</div>
	        	<div class="col-md-8">
		        	<select class="form-control input-sm contact_type" id="contact_type" name="contact_type">
		        		<option value="dealer">Dealer</option>
		        		<option value="client">Client</option>
		        		<option value="other">Other</option>
		        	</select>
	        	</div>
	        </div>
	        <div class="row row-input">
	        	<div class="col-md-4">
	        		Name of Contact
	        	</div>
	        	<div class="col-md-8">
		        	<input type="text" class="form-control input-sm contact_name" id="contact_name" name="contact_name" >
	        	</div>
	        </div>
	        <div class="row row-input">
	        	<div class="col-md-4">
	        		Contact Number
	        	</div>
	        	<div class="col-md-8">
		        	<input type="text" class="form-control input-sm contact_number" id="contact_number" name="contact_number" >
	        	</div>
	        </div>
	        <div class="row row-input">
	        	<div class="col-md-4">
	        		Transport being booked by Quote Me?
	        	</div>
	        	<div class="col-md-4">
	        		Yes <input type="radio" name="trans_flag" class="trans_flag" value="1">
	        	</div>
	        	<div class="col-md-4">
	        		No <input type="radio" name="trans_flag" class="trans_flag" value="0">
	        	</div>
	        </div>
	        <div class="hidden_div" hidden>
	        	<div  class="row row-input">
	        		<div class="col-md-4">
		        		Transport Company
		        	</div>
		        	<div class="col-md-8">
			        	<input type="text" class="form-control input-sm transport_company" id="transport_company" name="transport_company" >
		        	</div>
	        	</div>
	        	<div  class="row row-input">
	        		<div class="col-md-4">
		        		Contact Number
		        	</div>
		        	<div class="col-md-8">
			        	<input type="text" class="form-control input-sm transport_contact_number" id="transport_contact_number" name="transport_contact_number" >
		        	</div>
	        	</div>
	        	<div  class="row row-input">
	        		<div class="col-md-4">
		        		Cost of Transport
		        	</div>
		        	<div class="col-md-8">
			        	<input type="text" class="form-control input-sm cost_of_transport" id="cost_of_transport" name="cost_of_transport" >
		        	</div>
	        	</div>
	        	<div  class="row row-input">
	        		<div class="col-md-4">
		        		Booking Made
		        	</div>
		        	<div class="col-md-8">
			        	<select class="form-control input-sm booking_made" id="booking_made" name="booking_made">
			        		<option value="Yes">Yes</option>
			        		<option value="No">No</option>
			        	</select>
		        	</div>
	        	</div>
	        	<div  class="row row-input">
	        		<div class="col-md-4">
		        		Reference Number of Booking
		        	</div>
		        	<div class="col-md-8">
			        	<input type="text" class="form-control input-sm booking_ref_number" id="booking_ref_number" name="booking_ref_number" >
		        	</div>
	        	</div>
	        </div>
	        <div  class="row row-input">
        		<div class="col-md-4">
	        		Buyer
	        	</div>
	        	<div class="col-md-8">
		        	<select class="form-control input-sm tradein_buyer" id="tradein_buyer" name="tradein_buyer">
		        		
		        	</select>
	        	</div>
        	</div>
	      </div>
      	</form>
      <footer class="panel-footer">
		<button type="button" class="btn btn-primary save_wh" >Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </footer>
    </div>
  </div>
</div>
<div id="search_tradein_modal" class="modal fade">
	<div class="modal-dialog" style="width: 95%;">
		<section class="panel">
			<header class="panel-heading">
				<h2 class="panel-title">Search Tradein</h2>
			</header>
			<div class="panel-body">
				<div class="modal-wrapper">
					<div class="modal-text">
						<div class="addealers">
							<div class="form-group">
								<div class="col-md-4 text-left">
									<input class="form-control input-md search_tradein_field" id="t_s_email" name="t_s_email" type="text" value="" placeholder="Email" ><br />
								</div>
								<div class="col-md-2 text-left">
									<input class="form-control input-md search_tradein_field" id="t_s_firstname" name="t_s_firstname" type="text" value="" placeholder="First Name" ><br />
								</div>
								<div class="col-md-2 text-left">
									<input class="form-control input-md search_tradein_field" id="t_s_lastname" name="t_s_lastname" type="text" value="" placeholder="Last Name" ><br />	
								</div>
								<div class="col-md-2 text-left">
									<input class="form-control input-md search_tradein_field" id="t_s_make" name="t_s_make" type="text" value="" placeholder="Make" ><br />	
								</div>
								<div class="col-md-2 text-left">
									<input class="form-control input-md search_tradein_field" id="t_s_model" name="t_s_model" type="" value="" placeholder=Model ><br />	
								</div>
								<div class="col-md-12 text-left" id="filtered_tradein_result"></div>
								<!-- <div class="col-md-12 text-left">
									<br />
									<table class="table table-bordered table-striped table-condensed mb-none">
										<thead>
											<tr><td><b>FILTERED RESULTS</b></td><td></td></tr>
										</thead>
										<tbody id="filtered_tradein_result"></tbody>
									</table>
								</div> -->
							</div>
						</div>
					</div>
				</div>
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-md-12 text-right">
						<input value="0" id="dealer_ids_inp" name="dealer_ids" type="hidden">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</footer>
		</section>					
	</div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="refund_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body" style="padding-top: 25px !important;">
		<input type="hidden" name="hidden_ref_payment_id" id="hidden_ref_payment_id" class="hidden_ref_payment_id">
        <div class="form-group">
			<label class="col-md-3 control-label" for="refund_amount">Refund Amount</label>
			<div class="col-md-6">
				<input type="text" class="form-control refund_amount" >
			</div>
		</div>
      </div>
      <div class="modal-footer" style="padding-top: 10px !important; padding-bottom: 10px !important; margin-top: 0px !important;">
      	<button class="btn btn-primary modal-confirm confirm_refund">Confirm</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="add_accessory_modal">
  <div class="modal-dialog" style="width: 70%;">
    <div class="modal-content">
    	<header class="panel-heading">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">ADD ACCESSORIES</h4>
		</header>
		<div class="modal-body" style="padding-top: 25px !important;">
			<div class="row">
				<div class="col-md-12" style="margin-top: 10px; margin-bottom: 10px;" >
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
							<thead>
								<td></td>
								<td>Code</td>
								<td>Name</td>
								<td>Cost</td>
							</thead>
							<tbody id="add_acc_table_body">
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer" style="padding-top: 10px !important; padding-bottom: 10px !important; margin-top: 0px !important;">
			<span class="btn btn-default" id="lead_add_new_accessory_btn">Add New Accessory</span>
			<span class="btn btn-primary" id="acc_btn_confirm">Confirm</span>
			<span class="btn btn-default" data-dismiss="modal">Close</span>
		</div>
    </div>
  </div>
</div>
<div id="add_new_accessory_modal" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width: 80%;">
		<div class="modal-content">
			<header class="panel-heading">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
		        <h4 class="modal-title">ADD NEW ACCESSORY MODAL</h4>
			</header>
			<div class="modal-body" style="padding-top: 25px !important;" >
				<form method="post" class="add_new_accessory_form">
					<div class="row">
						<div class="col-md-3">
							<select class="form-control input-sm" id="fk_accessory_supplier" name="fk_accessory_supplier">
								
							</select>
						</div>
						<div class="col-md-3">
							<input type="text" class="form-control input-sm" placeholder="Code" name="code">
						</div>
						<div class="col-md-3">
							<input type="text" class="form-control input-sm" placeholder="Name" name="name">
						</div>
						<div class="col-md-3">
							<input type="text" class="form-control input-sm" placeholder="Cost" name="cost" onkeypress="return isNumberKey(event)">
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-12">
							<textarea class="form-control" width="100%" row="5" placeholder="Description..." name="description"></textarea>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer" style="padding-top: 10px !important; padding-bottom: 10px !important; margin-top: 0px !important;">
				<span class="btn btn-default" id="lead_add_new_supplier">Add New Supplier</span>
				<span class="btn btn-default" data-dismiss="modal">Close</span>
				<span class="btn btn-primary" id="add_new_accessory_confirm">Confirm</span>
			</div>
		</div>
	</div>
</div>
<div id="add_new_supplier_modal" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width: 80%;">
		<div class="modal-content">
			<header class="panel-heading">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
		        <h4 class="modal-title">ADD NEW ACCESSORY SUPPLIER MODAL</h4>
			</header>
			<div class="modal-body" style="padding-top: 25px !important;" >
				<form method="post" class="add_new_accessory_supplier_form">
					<div class="row">
						<div class="col-md-3">
							<input type="text" class="form-control input-sm" placeholder="Name" name="name">
						</div>
						<div class="col-md-3">
							<input type="text" class="form-control input-sm" placeholder="ABN" name="abn">
						</div>
						<div class="col-md-3">
							<input type="text" class="form-control input-sm" placeholder="Email" name="email">
						</div>
						<div class="col-md-3">
							<input type="text" class="form-control input-sm" placeholder="Phone" name="phone">
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-3">
							<input type="text" class="form-control input-sm" placeholder="Address Line 1" name="address_line_1">
						</div>
						<div class="col-md-3">
							<input type="text" class="form-control input-sm" placeholder="Address Line 2" name="address_line_2">
						</div>
						<div class="col-md-3">
							<input type="text" class="form-control input-sm" placeholder="Suburb" name="suburb">
						</div>
						<div class="col-md-3">
							<input type="text" class="form-control input-sm" placeholder="Postcode" name="postcode">
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-3">
							<select class="form-control input-md" name="state">
								<option value="">--State--</option>
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
					</div>
					<br>
					<div class="row">
						<div class="col-md-12">
							<textarea class="form-control" width="100%" row="5" placeholder="Description..." name="description"></textarea>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer" style="padding-top: 10px !important; padding-bottom: 10px !important; margin-top: 0px !important;">
				<span class="btn btn-default" data-dismiss="modal">Close</span>
				<span class="btn btn-primary" id="add_new_accessory_supplier_confirm">Confirm</span>
			</div>
		</div>
	</div>
</div>
<div id="lead_email_modal_gmail" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width: 80%;">
		<div class="modal-content">
			<header class="panel-heading">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title">EMAILS</h4>
			</header>
			<input type="hidden" name="hidden_lead_id_email" id="hidden_lead_id_email">
			<input type="hidden" name="hidden_qm_number" id="hidden_qm_number">
			<input type="hidden" name="hidden_email" id="hidden_email">
			<div class="modal-body" style="padding-top: 25px !important;" id="lead_email_modal_gmail_body">
				
			</div>
			<div class="modal-footer" style="padding-top: 10px !important; padding-bottom: 10px !important; margin-top: 0px !important;">
				<span class="btn btn-default" data-dismiss="modal">Close</span>
			</div>
		</div>
	</div>
</div>
<div id="lead_audit_trail_modal" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width: 80%;">
		<div class="modal-content">
			<header class="panel-heading">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
		        <h4 class="modal-title">HISTORY</h4>
			</header>
			<div class="modal-body" style="padding-top: 25px !important;" id="lead_audit_trail_modal_body">
			</div>
			<div class="modal-footer" style="padding-top: 10px !important; padding-bottom: 10px !important; margin-top: 0px !important;">
				<span class="btn btn-default" data-dismiss="modal">Close</span>
			</div>
		</div>
	</div>
</div>
<div id="email_accountant_modal" class="modal fade">
  <div class="modal-dialog" style="width: 80%;">
    <section class="panel">
      <header class="panel-heading">
        <h2 class="panel-title">SEND DEALER EMAIL</h2>
      </header>
      <div class="panel-body">
        <div class="modal-wrapper">
          <div class="modal-text">
	        <div class="row">
	        	<div class="col-md-4">
	        		<select class="form-control input-sm" id="dealer_email_dropdown">
	        			
	        		</select>
	        	</div>
	        	<div class="col-md-4">
	        		<i><small id="show_status" style="color: #707070;"></small></i>
	        	</div>
	        </div>
	        <br>
	        <div class="row">
	        	<div class="col-md-12">
	        		<div class="form-group">
		              <input value="" class="form-control" id="dealer_email_recipients" name="dealer_email_recipients" type="text" placeholder="Recipients">
		            </div>
		            <div class="form-group">
		              <input value="" class="form-control" id="dealer_email_subject" name="dealer_email_subject" type="text" placeholder="Subject">
		            </div>
		            <div class="form-group">
		            	<input type="checkbox" name="email_attachment" id="dealer_email_attachment_flag"> <i>Tick to exclude the dealer invoice pdf.</i>
		            </div>
		            <div class="form-group">
		            	<div class="dropzone dealer_email_uploader" style="min-height: 160px;"></div>
		            </div>          
		            <div class="form-group">
		              <div class="summernote" id="dealer_email_content" name="dealer_email_content" data-plugin-summernote data-plugin-options='{ "height": 240, "codemirror": { "theme": "ambiance" } }'></div>
		            </div>
	        	</div>
	        </div>
	        <div hidden="hidden" id="hidden_images">
	        </div>
          </div>
        </div>
      </div>
      <footer class="panel-footer">
        <div class="row">
          <div class="col-md-12 text-right">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="dealer_email_send_btn">Send Email</button>                     
          </div>
        </div>
      </footer>
    </section>          
  </div>
</div>
<div id="add-payment-modal" class="modal fade">
	<div class="modal-dialog" style="width: 95%;">
		<div class="panel-body">
			<div class="modal-wrapper">
				<div class="modal-text">
					<form method="post" action="" class="main_form" name="main_form">
						<input type="hidden" class="lead_id" name="lead_id" value="" />
						<input type="hidden" class="nonce" name="nonce" value="" >
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label class="control-label"><b>Payment Type:</b></label>
									<select class="form-control input-md payment-type-select" name="code" type="text">
										<option name="code" value=""></option>
										<?php
										foreach ($payment_types as $payment_type)
										{
											?>
											<option name="code" data-sign="<?php echo $payment_type->sign; ?>" value="<?php echo $payment_type->id_payment_type; ?>">
												<?php echo $payment_type->description; ?>
											</option>
											<?php
										}
										?>
									</select>
								</div>
							</div>									
													
							<div class="col-md-4">
								<div class="form-group">
									<label class="control-label"><b>Amount:</b></label>
									<input type="text" name="amount" onkeypress="return isNumberKey(event)" class="form-control mb-md amount_tb" placeholder="Amount" disabled="disabled" />
								</div>
							</div>
							<div class="col-md-12" style="margin-top: 10px; margin-bottom: 10px;" >
								<div class="table-responsive">
									<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
										<thead>
											<td></td>
											<td>Amount</td>
											<td><b>Invoice #</b></td>
											<td><b>Invoice Name</b></td>
											<td><b>Type</b></td>
											<td><b>Invoice Date</b></td>
											<td><b>Due Date</b></td>
											<td><b>Promised Date</b></td>
											<td><b>Amount Due</b></td>
											<td><b>Amount Paid</b></td>
											<td><b>User</b></td>
											<td><b>Created</b></td>
										</thead>
										<tbody id="add_payment_invoice_tbl">
											
										</tbody>
									</table>
								</div>
							</div>
							<div class="col-md-12" style="margin-top: 10px; margin-bottom: 10px;" >
								
								<div hidden>
									<input type="radio" name="payment_method" class="payment-method-radio reference-number" value="2"> External Payment
								</div>
							</div>
							<div class="col-md-12 hidden-credit-card" hidden>
								<ul class="nav nav-tabs" role="tablist">
									<li role="presentation" class="active">
										<a href="#new_credit_card" aria-controls="new_credit_card" role="tab" data-toggle="tab">
											New Credit Card
										</a>
									</li>
									<li role="presentation">
										<a href="#saved_credit_cards" aria-controls="saved_credit_cards" role="tab" data-toggle="tab">
											Saved Credit Cards
										</a>
									</li>
								</ul>
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane active" id="new_credit_card">
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
												<tbody>
													<tr>
														<td><font color="red">*</font> First Name</td>
														<td><input type="text" class="form-control input-sm first_name_inp" name="first_name"></td>
													</tr>
													<tr>
														<td><font color="red">*</font> Last Name</td>
														<td><input type="text" class="form-control input-sm last_name_inp" name="last_name"></td>
													</tr>
													<tr>
														<td><font color="red">*</font> Credit Card Number</td>
														<td><input type="text" class="form-control input-sm credit_card_number_inp" name="credit_card_number"></td>
													</tr>
													<tr>
														<td><font color="red">*</font> Credit Card Type</td>
														<td><input type="text" class="form-control input-sm card_type" name="card_type" disabled></td>
													</tr>
													<tr>
														<td><font color="red">*</font> Expiry (Month)</td>
														<td><input type="text" class="form-control input-sm expiry_month_inp" name="expiry_month"></td>
													</tr>
													<tr>
														<td><font color="red">*</font> Expiry (Year)</td>
														<td><input type="text" class="form-control input-sm expiry_year_inp" name="expiry_year"></td>
													</tr>
													<tr>
														<td><font color="red">*</font> CVN</td>
														<td><input type="text" class="form-control input-sm cvn_inp" name="cvn"></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
									<div role="tabpanel" class="tab-pane" id="saved_credit_cards">
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
												<thead>
													<tr>
														<th>
															<center>
																<a class="uncheck_tokens" style="cursor: pointer;cursor: hand;" data-toggle="tooltip" data-placement="top" title="Uncheck Credit Card">
																	<i class="fa fa-times"></i>
																</a>
															</center>
														</th>
														<th>Credit Card Number</th>
														<th>Card Holder's Name</th>
														<th>Expiration Date</th>
													</tr>
												</thead>
												<tbody class="eway_token_body">
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12 hidden-reference" hidden>
								<div class="table-responsive">
									<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
										<tbody>
											<tr>
												<td><font color="red">*</font> Bank Account</td>
												<td>
													<select class="form-control input-sm bank_account" name="bank_account">
													<?php
													foreach ($bank_accounts as $bank_account)
													{
														?>
														<option value="<?php echo $bank_account->id_bank_account; ?>">
															<?php echo $bank_account->name; ?>
														</option>
														<?php
													}
													?>	
													</select>
												</td>
											</tr>
											<tr>
												<td><font color="red">*</font> Reference Number</td>
												<td><input type="text" class="form-control input-sm reference_number" name="reference_number"></td>
											</tr>
											<tr>
												<td>Admin Fee</td>
												<td><input type="text" class="form-control input-sm optional_ad_fee" name="optional_ad_fee" placeholder="Optional" onkeypress="return isNumberKey(event)"></td>
											</tr>
											<tr>
												<td>Merchant Fee</td>
												<td>
													<div class="input-group">
														<span class="input-group-addon">
															<input type="checkbox" name="merchant_cost_check" id="merchant_cost_check" value="1" >
														</span>
														<input type="text" name="merchant_cost" class="form-control input-sm merchant_cost" id="merchant_cost" value="0.00" onkeypress="return isNumberKey(event)" disabled>
													</div>
												</td>
											</tr>
											<tr>
												<td>Remarks</td>
												<td><textarea class="form-control payment_remarks" placeholder="Remarks..." name="payment_remarks"></textarea></td>
											</tr>
											<tr>
												<td><font color="red">*</font> Payment Date</td>
												<?php $now = date("Y-m-d"); ?>
												<td><input type="text" class="form-control input-sm payment_date datepicker" name="payment_date" data-date-format="yyyy-mm-dd" style="padding: 7px !important;" value="<?php echo $now; ?>"></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="col-md-12" style="margin-top: 10px;"></div>
						</div>
					</form>								
				</div>
			</div>
		</div>
		<footer class="panel-footer">
			<div class="row">
				<div class="col-md-12 text-right">
					<div class="actions">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary add-payment-btn" onclick="add_payment_action()" disabled="">Submit</button>
					</div>
				</div>
			</div>
		</footer>
	</div>
</div>
<div id="add-invoice-item-modal" class="modal fade">
	<div class="modal-dialog" style="width: 95%;">
		<div class="panel-body">
			<div class="modal-wrapper">
				<div class="modal-text">
					<form method="post" action="" class="main_form" name="main_form">
						<div class="row">
							<div class="col-md-12" id="invoice_item_div">
								<h4><b>INVOICE ITEMS</b></h4>
								<br />
								<div style="border: 1px solid #ddd; border-radius: 5px; padding: 15px;" class="invoice_item_parent_panel">
									<div class="row invoice_item_child_panel">
										<div class="col-md-12">
											<div class="form-group">
												<label><b>Amount:</b></label>
												<input type="text" class="form-control mb-md invoice_item_amount" name="invoice_item_amount[]" onkeypress="return isNumberKey(event)" value="0.00">
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group invoice_item_type_parent_panel">
												<label><b>Invoice Item Type:</b></label>
												<select class="form-control input-xs invoice_item" name="invoice_item[0][0]" style="margin-bottom: 10px;" multiple="multiple">
													
												</select>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label><b>Description:</b></label>
												<textarea name="invoice_item_description[]" class="form-control invoice_item_description" placeholder="Description"></textarea>
												<br />
											</div>
										</div>
										<!-- 
										<div class="col-md-12">
											<hr>
										</div> 
										-->
									</div>
								</div>
								<br />
							</div>	
							<div class="col-md-12">
								<button type="button" class="btn btn-primary add_invoice_item" >Add Item</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<footer class="panel-footer">
			<div class="row">
				<div class="col-md-12 text-right">
					<div class="actions">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary sample_submit" >Submit</button>
					</div>
				</div>
			</div>
		</footer>
	</div>
</div>
			<!-- Balcqo Modal-->
			<div id="balcqo-modal" class="modal fade">
				<div class="modal-dialog" style="width: 95%;">
					<div class="panel-body">
						<div class="modal-wrapper">
							<div class="modal-text">
								<form method="post" action="" class="main_form" name="main_form">
									<input type="hidden" class="lead_id" name="lead_id" value="" />
									<div class="col-md-12"> <!-- Payments -->
										<h5><b>PAYMENTS</b></h5>
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
												<thead>
													<tr>
														<td align="center"><i class="fa fa-trash-o"></i></td>
														<td align="center"><i class="fa fa-pencil-square-o"></i></td>
														<td align="center"><i class="fa fa-reply"></i></td>
														<td align="center"><i class="fa fa-eye"></i></td>
														<td align="center"><i class="fa fa-check-circle"></i></td>
														<td><b>Type</b></td>
														<td><b>Method</b></td>
														<td><b>Reference No.</b></td>
														<td><b>User</b></td>														
														<td><b>Amount</b></td>
														<td><b>Admin Fee</b></td>														
														<td><b>Payment Date</b></td>
														<td><b>Total Refunded</b></td>
														<td><b>Refunded From</b></td>
														<td><b>Merchant Cost</b></td>
														<td><b>Status</b></td>
														<td><b>PDF Status</b></td>
													</tr>
												</thead>
												<tbody class="payments_table"></tbody>
											</table>
										</div>
										<br />
										<a href="#" class="btn btn-primary open-add-payment">
											<i class="fa fa-plus"></i>&nbsp; New Payment
										</a>
										<a href="#" class="btn btn-primary open-search-payment">
											Attach an Existing Payment
										</a>
										<br />
										<br />
										<br />
									</div>
									<div class="col-md-12"> <!-- Invoices -->
										<h5><b>INVOICES</b></h5>
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
												<thead>
													<tr>
														<td align="center"><i class="fa fa-trash-o"></i></td>
														<td align="center"><i class="fa fa-pencil-square-o"></i></td>
														<td align="center"><i class="fa fa-dollar"></i></td>
														<td align="center"><i class="fa fa-file-pdf-o"></i></td>
														<td align="center"><i class="fa fa-envelope"></i></td>
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
													</tr>
												</thead>
												<tbody class="invoices_table"></tbody>
											</table>
										</div>
										<br />
										<a href="#" class="btn btn-primary open-add-invoice">
											<i class="fa fa-plus"></i>&nbsp; Add Invoice
										</a>
										<br />
										<br />
										<br />										
									</div>
									<div class="col-md-4"> <!-- BalCQO Figures -->
										<div class="row">
											<div class="col-md-12">
												<div class="table-responsive">
													<table class="table table-condensed mb-none table-cont-mid" style="white-space: nowrap;">
														<tr>
															<td><h5>Revenue Total:</h5></td>
															<td class="td-number"><h4>$<span class="revenue_total_td"></span></h4></td>
														</tr>
														<tr>
															<td><h5>BalCQO Total:</h5></td>
															<td class="td-number"><h4>$<span class="balcqo_total_td"></span></h4></td>
														</tr>													
														<tr>
															<td><h5>Received Total:</h5></td>
															<td class="td-number"><h4>$<span class="received_total_td"></span></h4></td>
														</tr>
														<tr>
															<td><h5><b>REMAINING BALANCE:</b></h5></td>
															<td class="td-number"><h4><b>$<span class="remaining_balance_td"></span></b></h4></td>
														</tr>
													</table>
												</div>
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
			<!-- /.Balcqo Modal -->
			<!-- Add Payment Modal-->
			<!-- transferred to lead_modals.php -->
			<!-- <div id="add-payment-modal" class="modal fade">
				<div class="modal-dialog" style="width: 95%;">
					<div class="panel-body">
						<div class="modal-wrapper">
							<div class="modal-text">
								<form method="post" action="" class="main_form" name="main_form">
									<input type="hidden" class="lead_id" name="lead_id" value="" />
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
			</div> -->
			<!-- /.Add Payment Modal -->
			<!-- Edit Payment Modal-->
			<div id="edit-payment-modal" class="modal fade">
				<div class="modal-dialog" style="width: 95%;">
					<div class="panel-body">
						<div class="modal-wrapper">
							<div class="modal-text">
								<form method="post" action="" class="main_form" name="main_form">
									<input type="hidden" id="payment_id" name="payment_id" value="" />
									<input type="hidden" id="hidden_sign" name="hidden_sign" value="" />
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label"><font color="red">*</font> <b>Payment Type:</b></label>
												<select class="form-control input-sm" id="fk_payment_type" name="fk_payment_type" type="text">
													<option name="fk_payment_type" value=""></option>
													<?php
													foreach ($payment_types as $payment_type)
													{
														?>
														<option name="fk_payment_type" data-sign="<?php echo $payment_type->sign; ?>" value="<?php echo $payment_type->id_payment_type; ?>">
															<?php echo $payment_type->description; ?>
														</option>
														<?php
													}
													?>
												</select>	
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label"><font color="red">*</font> <b>Amount:</b></label>
												<input type="text" class="form-control input-sm" id="amount" name="amount" onkeypress="return isNumberKey(event)" />
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label"><b>Admin Fee:</b></label>
												<input type="text" class="form-control input-sm optional_ad_fee_edit" name="optional_ad_fee_edit" id="optional_ad_fee_edit" placeholder="Optional" onkeypress="return isNumberKey(event)">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label"><b>Merchat Cost:</b></label>
												<div class="input-group">
													<span class="input-group-addon">
														<input type="checkbox" name="edit_merchant_cost_check" id="edit_merchant_cost_check" value="1" >
													</span>
													<input type="text" name="edit_merchant_cost" class="form-control input-sm edit_merchant_cost" id="edit_merchant_cost" value="0.00" onkeypress="return isNumberKey(event)" disabled>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label"><font color="red">*</font> <b>Reference Number:</b></label>
												<input type="text" class="form-control input-sm" id="reference_number" name="reference_number">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label"><font color="red">*</font> <b>Payment Date:</b></label>
												<input type="text" class="form-control input-sm datepicker" data-date-format="yyyy-mm-dd" id="payment_date" name="payment_date" />
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label"><b>Remarks:</b></label>
												<textarea class="form-control" placeholder="Remarks..." name="payment_remarks" id="payment_remarks" name="payment_remarks"></textarea>
											</div>
										</div>
									</div>
									<div class="row">
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
													<tbody id="edit_payment_invoice_tbl">
														
													</tbody>
												</table>
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
								<div class="actions">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									<button type="button" class="btn btn-primary add-payment-btn" onclick="update_payment_action()">Submit</button>
								</div>
							</div>
						</div>
					</footer>
				</div>
			</div>
			<!-- /.Edit Payment Modal -->
			<!-- Add Invoice Modal-->
			<div id="add-invoice-modal" class="modal fade">
				<div class="modal-dialog" style="width: 95%;">
					<div class="panel-body">
						<div class="modal-wrapper">
							<div class="modal-text">
								<form method="post" action="" class="main_form" name="main_form">
									<input type="hidden" class="lead_id" name="lead_id" value="" />
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label><font color="red">*</font> <b>Invoice Number:</b></label>
												<input type="text" class="form-control mb-md" id="invoice_number" name="invoice_number">
												<br />
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label><font color="red">*</font> <b>Invoice To:</b></label>
												<select class="form-control mb-md" id="invoice_type" name="invoice_type" title="Invoice To">
													<option name="invoice_type" value=""></option>
													<option name="invoice_type" value="Dealer">Dealer</option>
													<option name="invoice_type" value="Wholesaler">Wholesaler</option>
													<option name="invoice_type" value="Client">Client</option>
												</select>
												<br />
											</div>
										</div>										
										<div class="col-md-4">
											<div class="form-group">
												<label><font color="red">*</font> <b>Total Amount:</b></label>
												<input type="text" class="form-control mb-md" id="amount" name="amount" onkeypress="return isNumberKey(event)" >
												<br />
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label><font color="red">*</font> <b>Invoice Date:</b></label>
												<input class="form-control input-md datepicker" id="invoice_date" name="invoice_date" data-date-format="yyyy-mm-dd" value="">
												<br />
											</div>
										</div>									
										<div class="col-md-4">
											<div class="form-group">
												<label><font color="red">*</font> <b>Due Date:</b></label>
												<input class="form-control input-md datepicker" id="due_date" name="due_date" data-date-format="yyyy-mm-dd" value="">
												<br />
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label><b>Promised Date:</b></label>
												<input class="form-control input-md datepicker" id="promised_date" name="promised_date" data-date-format="yyyy-mm-dd" value="">
												<br />
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label><font color="red">*</font> <b>Invoice Name:</b></label>
												<input type="text" class="form-control mb-md" id="invoice_name" name="invoice_name">
												<br />
											</div>
										</div>										
										<div class="col-md-12">
											<div class="form-group">
												<label><b>Additional Remarks to the Receiver (Will be shown on the PDF):</b></label>
												<textarea id="remarks" name="remarks" class="form-control" placeholder="Remarks"></textarea>
												<br />
											</div>
										</div>										
										<div class="col-md-12">
											<div class="form-group">
												<label><b>Details:</b></label>
												<textarea id="details" name="details" class="form-control" placeholder="Details"></textarea>
												<br />
												<br />
												<br />
											</div>
										</div>
										<div class="col-md-12" id="invoice_item_div">
											<h4><b>INVOICE ITEMS:</b></h4>
											<div style="border: 1px solid #ddd; border-radius: 5px; padding: 15px;">
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label><b>Amount:</b></label>
															<input type="text" class="form-control mb-md" id="invoice_item_amount" name="invoice_item_amount[]" onkeypress="return isNumberKey(event)" >
															<br />
														</div>
													</div>												
													<div class="col-md-12">
														<div class="form-group">
															<label><b>Description:</b></label>
															<textarea id="invoice_item_description" name="invoice_item_description[]" class="form-control" placeholder="Description"></textarea>
															<br />
														</div>
													</div>												
												</div>
											</div>
											<br />
										</div>	
										<div class="col-md-12">
											<button type="button" class="btn btn-primary" onclick="add_invoice_item()">Add Item</button>
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
									<button type="button" class="btn btn-primary" onclick="add_invoice_action()">Submit</button>
								</div>
							</div>
						</div>
					</footer>
				</div>
			</div>
			<!-- /.Add Invoice Modal -->
			<!-- Edit Invoice Modal-->
			<div id="edit-invoice-modal" class="modal fade">
				<div class="modal-dialog" style="width: 95%;">
					<div class="panel-body">
						<div class="modal-wrapper">
							<div class="modal-text">
								<form method="post" action="" class="main_form" name="main_form">
									<input type="hidden" id="invoice_id" name="invoice_id" value="" />
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label><font color="red">*</font> <b>Invoice Number:</b></label>
												<input type="text" class="form-control mb-md" id="invoice_number" name="invoice_number">
												<br />
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label><font color="red">*</font> <b>Invoice To:</b></label>
												<select class="form-control mb-md" id="invoice_type" name="invoice_type" title="Invoice To">
													<option name="invoice_type" value=""></option>
													<option name="invoice_type" value="Dealer">Dealer</option>
													<option name="invoice_type" value="Wholesaler">Wholesaler</option>
													<option name="invoice_type" value="Client">Client</option>
												</select>
												<br />
											</div>
										</div>										
										<div class="col-md-4">
											<div class="form-group">
												<label><font color="red">*</font> <b>Total Amount:</b></label>
												<input type="text" class="form-control mb-md" id="amount" name="amount" onkeypress="return isNumberKey(event)" >
												<br />
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label><font color="red">*</font> <b>Invoice Date:</b></label>
												<input class="form-control input-md datepicker" id="invoice_date" name="invoice_date" data-date-format="yyyy-mm-dd" value="">
												<br />
											</div>
										</div>									
										<div class="col-md-4">
											<div class="form-group">
												<label><font color="red">*</font> <b>Due Date:</b></label>
												<input class="form-control input-md datepicker" id="due_date" name="due_date" data-date-format="yyyy-mm-dd" value="">
												<br />
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label><b>Promised Date:</b></label>
												<input class="form-control input-md datepicker" id="promised_date" name="promised_date" data-date-format="yyyy-mm-dd" value="">
												<br />
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label><font color="red">*</font> <b>Invoice Name:</b></label>
												<input type="text" class="form-control mb-md" id="invoice_name" name="invoice_name">
												<br />
											</div>
										</div>										
										<div class="col-md-12">
											<div class="form-group">
												<label><b>Additional Remarks:</b></label>
												<textarea id="remarks" name="remarks" class="form-control" placeholder="Remarks"></textarea>
												<br />
											</div>
										</div>										
										<div class="col-md-12">
											<div class="form-group">
												<label><b>Details:</b></label>
												<textarea id="details" name="details" class="form-control" placeholder="Details"></textarea>
												<br />
												<br />
												<br />
											</div>
										</div>
										<div class="col-md-12" id="invoice_item_div">
										</div>
										<!--
										<div class="col-md-12">
											<button type="button" class="btn btn-primary" onclick="add_invoice_item()">Add Item</button>
										</div>
										-->
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
									<button type="button" class="btn btn-primary" onclick="update_invoice_action()">Save</button>
								</div>
							</div>
						</div>
					</footer>
				</div>
			</div>
			<!-- /.Edit Invoice Modal -->
			<!-- Send Invoice Modal-->
			<div id="send-invoice-modal" class="modal fade">
				<div class="modal-dialog" style="width: 95%;">
					<div class="panel-body">
						<div class="modal-wrapper">
							<div class="modal-text">
								<form method="post" action="" class="main_form" name="main_form">
									<input type="hidden" id="invoice_id" name="invoice_id" value="" />
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label><font color="red">*</font> <b>Email Address:</b></label>
												<input type="text" class="form-control mb-md" id="email" name="email">
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label><font color="red">*</font> <b>Subject:</b></label>
												<input type="text" class="form-control mb-md" id="subject" name="subject" value="Invoice from Quote Me">
											</div>
										</div>										
										<div class="col-md-12">
											<div class="form-group">
												<label><b>Message:</b></label>
												<textarea id="message" name="message" class="form-control" placeholder="Message"></textarea>
												<br />
												<br />
											</div>
										</div>
										<div class="col-md-12" id="invoice_sent_emails_div"></div>
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
									<button type="button" class="btn btn-primary" onclick="send_invoice_action()">Save</button>
								</div>
							</div>
						</div>
					</footer>
				</div>
			</div>
			<!-- /.Send Invoice Modal -->
			<!-- Add Invoice Payment Modal-->
			<div id="add-invoice-payment-modal" class="modal fade">
				<div class="modal-dialog" style="width: 95%;">
					<div class="panel-body">
						<div class="modal-wrapper">
							<div class="modal-text">
								<form method="post" action="" class="main_form" name="main_form">
									<input type="hidden" class="lead_id" name="lead_id" value="" />
									<div class="row">
										<div class="col-md-12 invoice_body">
											
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
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
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label"><b>Amount:</b></label>
												<input type="text" name="amount" onkeypress="return isNumberKey(event)" class="form-control mb-md amount_tb" placeholder="Amount" disabled="disabled" />
											</div>
										</div>
										<div class="col-md-12" style="margin-top: 10px; margin-bottom: 10px;" >
											<div hidden>
												<input type="radio" name="payment_method" class="payment-method-radio credit-card" value="1"> Credit Card Payment (<i>Eway</i>)
											</div>
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
															<td><font color="red">*</font> Reference Number</td>
															<td><input type="text" class="form-control input-sm reference_number" name="reference_number"></td>
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
									<button type="button" class="btn btn-primary add-payment-btn" onclick="add_invoice_payment_action()" disabled="">Submit</button>
								</div>
							</div>
						</div>
					</footer>
				</div>
			</div>
			<!-- /.Add Invoice Payment Modal -->
			<div class="modal fade" role="dialog" id="search_payment_modal">
				<div class="modal-dialog" style="width: 70%;">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">Assign Lead</h4>
						</div>
						<div class="modal-body" >
							<div class="search_payment_div_form">
								<div class="form-group">
									<div class="col-md-3 text-left">
										<input class="form-control input-md search_payment_field" id="search_payment_reference" name="search_payment_reference" type="text" value="" placeholder="Reference" ><br />
									</div>
									<div class="col-md-3 text-left">
										<input class="form-control input-md search_payment_field" id="search_payment_amount" name="search_payment_amount" type="text" value="" placeholder="Amount" ><br />
									</div>
									<div class="col-md-3 text-left">
										<input class="form-control input-md search_payment_field" id="search_payment_created_at" name="search_payment_created_at" type="text" value="" placeholder="Created Date" ><br />
									</div>
									<div class="col-md-12 text-left" id="filtered_payment_search_result">
										
									</div>
									<br>
								</div>
							</div>
						</div>
						<div class="modal-footer">
						
						</div>
					</div>
				</div>
			</div>
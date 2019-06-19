<?php include 'template/head.php'; ?>
	<body>
		<section class="body">
			<?php include 'template/header.php'; ?>
			<div class="inner-wrapper">
				<?php include 'template/left_sidebar.php'; ?>
				<section role="main" class="content-body">
					<?php include 'template/header_2.php'; ?>
					<!-- start: page -->
					<!-- 
					<section class="panel">
						<div class="panel-body">
							<div class="col-lg-6 col-sm-6 col-12">
								<h4>Import CSV</h4>
								<div class="input-group input-sm">
									<label class="input-group-btn">
										<span class="btn btn-primary input-sm">
											Browse… <input type="file" style="display: none;" multiple="">
										</span>
									</label>
									<input type="text" class="form-control input-sm" readonly="">
								</div>
								<span class="help-block">
									Try selecting one or more files and watch the feedback
								</span>
							</div>
						</div>
					</section> 
					-->
					<section class="panel">
						<header class="panel-heading">
							<div class="panel-actions">
								<a href="#" class="fa fa-caret-down"></a>
							</div>
							<h2 class="panel-title">
								<span class="label label-primary label-sm text-normal va-middle mr-sm"></span>
								<span class="va-middle">Search Filters</span>
							</h2>
						</header>
						<form action="<?php echo site_url('deal/payments_view'); ?>" method="get" accept-charset="utf-8" id="main_list_filter_form">
							<div class="panel-body">
								<br />
								<?php
								$cq_number = isset($_GET['cq_number']) ? $_GET['cq_number'] : '';
								
								$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';

								$name = isset($_GET['name']) ? $_GET['name'] : '';
								$email = isset($_GET['email']) ? $_GET['email'] : '';
								$phone = isset($_GET['phone']) ? $_GET['phone'] : '';
									
								$state = isset($_GET['state']) ? $_GET['state'] : '';
								$postcode = isset($_GET['postcode']) ? $_GET['postcode'] : '';
								$address = isset($_GET['address']) ? $_GET['address'] : '';
									
								$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
								$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';
								$lead_flag = isset($_GET['lead_flag']) ? $_GET['lead_flag'] : '';
								

								$selected_state_ACT = ""; if ($state == 'ACT') { $selected_state_ACT = " selected"; }
								$selected_state_NSW = ""; if ($state == 'NSW') { $selected_state_NSW = " selected"; }
								$selected_state_NT = ""; if ($state == 'NT') { $selected_state_NT = " selected"; }
								$selected_state_QLD = ""; if ($state == 'QLD') { $selected_state_QLD = " selected"; }
								$selected_state_SA = ""; if ($state == 'SA') { $selected_state_SA = " selected"; }
								$selected_state_TAS = ""; if ($state == 'TAS') { $selected_state_TAS = " selected"; }
								$selected_state_VIC = ""; if ($state == 'VIC') { $selected_state_VIC = " selected"; }
								$selected_state_WA = ""; if ($state == 'WA') { $selected_state_WA = " selected"; }									
								?>
								<div class="form-group">									
									<?php
									if ($admin_type==2 OR $admin_type==5)
									{
										?>
										<div class="col-md-12">
											<h5><b>Lead Details:</b></h5>
											<div style="border: 1px solid #eeeeee; padding: 15px 15px 0px 15px; border-radius: 5px; background: #f5f5f5;">
												<div class="row">
													<div class="col-md-4">
														<input type="text" class="form-control mb-md" name="cq_number" title="QM Number" placeholder="QM Number" value="<?php echo $cq_number;?>">
													</div>
													<div class="col-md-4">
														<select class="form-control mb-md" name="user_id" title="Quote Specialist">
															<option name="user_id" value="">-Quote Specialist-</option>
															<?php
															if ($admin_type==2 OR $admin_type==5)
															{										
																foreach ($admins as $admin)
																{
																	$selected_user_id = "";
																	if ($admin->id_user == $user_id)
																	{
																		$selected_user_id = " selected";
																	}
																	?>
																	<option name="user_id" value="<?php echo $admin->id_user; ?>" <?php echo $selected_user_id; ?>>
																		<?php echo $admin->name; ?>
																	</option>
																	<?php
																}
															}
															?>
														</select>
													</div>
													<div class="col-md-4">
														<select class="form-control mb-md" name="lead_flag" title="Quote Specialist">
															<option value="">-With or Without Lead No.-</option>
															<option value="1" <?= ($lead_flag=="1") ? "selected" : "" ?> >Without</option>
															<option value="0" <?= ($lead_flag=="0") ? "selected" : "" ?> >With</option>
														</select>
													</div>										
												</div>
											</div>
											<br />
										</div>
										<?php
									}
									else
									{
										?>
										<div class="col-md-12">
											<h5><b>Lead Details:</b></h5>
											<div style="border: 1px solid #eeeeee; padding: 15px 15px 0px 15px; border-radius: 5px; background: #f5f5f5;">
												<div class="row">
													<div class="col-md-6">
														<input type="text" class="form-control mb-md" name="cq_number" title="QM Number" placeholder="QM Number" value="<?php echo $cq_number;?>">
													</div>
												</div>
											</div>
											<br />											
										</div>
										<?php
									}
									?>
									<div class="col-md-12">
										<h5><b>Client Details:</b></h5>
										<div style="border: 1px solid #eeeeee; padding: 15px 15px 0px 15px; border-radius: 5px; background: #f5f5f5;">
											<div class="row">
												<div class="col-md-4">
													<input type="text" class="form-control mb-md" name="name" title="Name" placeholder="Name" value="<?php echo $name;?>">
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control mb-md" name="email" title="Email Address" placeholder="Email Address" value="<?php echo $email;?>">
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control mb-md" name="phone" title="Phone" placeholder="Phone" value="<?php echo $phone;?>">
												</div>
												<div class="col-md-4">
													<select class="form-control mb-md" name="state" title="State">
														<option name="state" value="">-State-</option>
														<option name="state" value="ACT" <?php echo $selected_state_ACT; ?>>ACT - Australian Capital Territory</option>
														<option name="state" value="NSW" <?php echo $selected_state_NSW; ?>>NSW - New South Wales</option>
														<option name="state" value="NT" <?php echo $selected_state_NT; ?>>NT - Northern Territory</option>
														<option name="state" value="QLD" <?php echo $selected_state_QLD; ?>>QLD - Queensland</option>
														<option name="state" value="SA" <?php echo $selected_state_SA; ?>>SA - South Australia</option>
														<option name="state" value="TAS" <?php echo $selected_state_TAS; ?>>TAS - Tasmania</option>
														<option name="state" value="VIC" <?php echo $selected_state_VIC; ?>>VIC - Victoria</option>
														<option name="state" value="WA" <?php echo $selected_state_WA; ?>>WA - Western Australia</option>
													</select>
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control mb-md" name="postcode" title="Postcode" placeholder="Postcode" value="<?php echo $postcode;?>">
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control mb-md" name="address" title="Address" placeholder="Address" value="<?php echo $address;?>">
												</div>											
											</div>
										</div>
										<br />
									</div>				
								</div>
								<div class="form-group">
									<div class="col-md-12 text-right">
										<input value="Apply Filters" name="submit" class="btn btn-primary" type="submit">
										<a class="btn btn-default" href="<?php echo site_url('deal/payments'); ?>">Clear Filters</a>
										<br />
										<br />
									</div>
								</div>
							</div>
						</form>
					</section>
					<section class="panel">
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;" id="datatable" data-swf-path="<?= base_url('assets/vendor/jquery-datatables/extras/TableTools/swf/copy_csv_xls_pdf.swf'); ?>">
									<thead>
										<tr>
											<td><i class="fa fa-trash-o"></i></td>
											<td><i class="fa fa-dollar"></i></td>
											<td><i class="fa fa-pencil-square-o"></i></td>
											<td><b>QM Number</b></td>
											<td><b>Payment Type</b></td>
											<td><b>Type</b></td>
											<td><b>Reference No.</b></td>
											<td><b>Amount</b></td>
											<td><b>User</b></td>
											<td><b>Payment Date</b></td>
											<td><b>Refund Status</b></td>
											<td><b>Refund Date</b></td>
											<td><b>Admin Fee</b></td>
											<td><b>Merchant Cost</b></td>
											<td><b>Status</b></td>
											<td><b>Created</b></td>
											
										</tr>
									</thead>
									<tbody>
										<?php
										if(count($payments) > 0)
										{
											foreach ($payments as $payment)
											{
												$hidden     = "";
												$type       = "";
												$ref_status = "";
												$ref_date   = "";

												$hidden_assign_btn = "";

												if( in_array($payment['reference_number'], $eway_trans) )
												{
													$hidden = 'hidden="hidden"';
													$type   = "Eway";

													if($payment['refund_status'] == 1)
													{
														$ref_status = "Refunded";
													}
												}
												else
												{
													$type = "External";
												}

												if($payment['refund_date']=="0000-00-00 00:00:00")
													$ref_date = "";
												else
													$ref_date = $payment['refund_date'];

												if($payment['lead_id'] == 0)
													$hidden_assign_btn = '';
												else
													$hidden_assign_btn = 'hidden="hidden"';

												if($payment['trans_id'] == 0)
													$edit_btn_hidden = "";
												else
													$edit_btn_hidden = "hidden";

												?>
												<tr id="payment_row_<?php echo $payment['id_payment']; ?>">
													<td align="center"><a href="#" onclick="delete_payment('<?= $payment['id_payment'] ?>')" <?= $hidden ?> ><i class="fa fa-trash-o" data-toggle="tooltip" data-placement="top" data-original-title="Delete"></i></a></td>
													<td align="center"><a <?= $hidden_assign_btn ?> href="#" class="open_search_lead_modal" data-paymenttype="<?= $payment['fk_payment_type'] ?>" data-idpayment="<?= $payment['id_payment'] ?>"><i class="fa fa-dollar" data-toggle="tooltip" data-placement="top" data-original-title="Attach to Lead"></i></a></td>
													<td align="center">
														<a href="#" class="open-edit-payment-page" data-payment_id="<?php echo $payment['id_payment']; ?>"  <?= $edit_btn_hidden ?> data-toggle="tooltip" data-placement="top" title="Edit Payment">
															<i class="fa fa-pencil-square-o"></i>
														</a>
													</td>
													<td><?= $payment['lead_cq_number']; ?></td>
													<td class="payment_type_td"><?= $payment['description']; ?></td>
													<td><?= $type ?></td>
													<td class="referencet_td"><?= $payment['reference_number']; ?></td>
													<td class="payment_amount_td"><?= $payment['amount']; ?></td>
													<td><?= $payment['name']; ?></td>
													<!-- <td><input type="text" data-idpayment="<?= $payment['payment_date'] ?>" value="<?= $payment['payment_date'] ?>" class="input-xs payment_input" data-date-format="yyyy-mm-dd" disabled> &nbsp; &nbsp; &nbsp;<a href="#" class="edit_payment_date" ><i class="fa fa-pencil-square-o"></td> -->
													<td class="payment_date_td"><?= $payment['payment_date'] ?></td>
													<td><?= $ref_status; ?></td>
													<td><?= $ref_date; ?></td>
													<td class="admin_fee"><?= $payment['admin_fee'] ?></td>
													<td><?= $payment['merchant_cost']; ?></td>
													<td><?= $payment['status']; ?></td>
													<td><?= $payment['created_at']; ?></td>
												</tr>
										<?php
											}
										}
										else
										{
										?>
										<tr><td colspan="13"><center><i>No Records Found!</i></center></td></tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
							<?php echo $links; ?>
						</div>
					</section>
					<!-- end: page -->
					<?php include 'modals/ticket_modals.php'; ?>
					<!-- Map Payment To Lead Modal (Start) -->
					<div class="modal fade" role="dialog" id="map_payment_to_lead_modal">
						<div class="modal-dialog" style="width: 80%;">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
									<h4 class="modal-title">Assign Lead</h4>
								</div>
								<div class="modal-body" >
									<input type="hidden" name="hidden_payment_id_lead_search" id="hidden_payment_id_lead_search" value="">
									<div class="search_lead_div_form">
										<div class="form-group">
											<div class="col-md-4 text-left">
												<input class="form-control input-md search_lead_field" id="search_lead_email" name="search_lead_email" type="text" value="" placeholder="Email"><br />
											</div>
											<div class="col-md-4 text-left">
												<input class="form-control input-md search_lead_field" id="search_lead_name" name="search_lead_name" type="text" value="" placeholder="Name"><br />
											</div>
											<div class="col-md-4 text-left">
												<input class="form-control input-md search_lead_field" id="search_lead_qm" name="search_lead_qm" type="text" value="" placeholder="QM Number"><br />
											</div>
											<div class="col-md-12 text-left" id="payment_filtered_lead_search_result">
											</div>
											<br />
											<div class="col-md-3 text-left" hidden id="payment_type_panel" style="margin-bottom: 20px;">
												<label>Payment Type</label>
												<select class="form-control" id="payment_type_assign_lead" >
													<option value="0">-Choose-</option>
													<?php
													foreach ($payment_types as $pkey => $p_val) 
													{
													?>
														<option data-sign="<?php echo $p_val->sign; ?>" value="<?= $p_val->id_payment_type ?>"><?= $p_val->description ?></option>
													<?php 
													}
													?>
												</select>
											</div>
											<br />
											<div class="col-md-12 text-left" id="payment_final_search_result">	
											</div>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-primary" id="assign_lead_to_payment_btn">Assign</button>
								</div>
							</div>
						</div>
					</div>
					<!-- Map Payment To Lead Modal (End) -->
					<!-- Edit Payment Modal (Start) -->
					<div id="edit-payment-modal-payment-page" class="modal fade">
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
														<select class="form-control input-sm" id="fk_payment_type_view" name="fk_payment_type" type="text">
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
														<input type="text" class="form-control input-sm" id="amount_view" name="amount" onkeypress="return isNumberKey(event)" />
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
														<label class="control-label"><b>Merchant Cost:</b></label>
														<div class="input-group">
															<span class="input-group-addon">
																<input type="checkbox" name="edit_merchant_cost_check" id="edit_merchant_cost_check_2" value="1" >
															</span>
															<input type="text" name="edit_merchant_cost" class="form-control input-sm edit_merchant_cost" id="edit_merchant_cost_2" value="0.00" onkeypress="return isNumberKey(event)" disabled>
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
										</form>								
									</div>
								</div>
							</div>
							<footer class="panel-footer">
								<div class="row">
									<div class="col-md-12 text-right">
										<div class="actions">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											<button type="button" class="btn btn-primary add-payment-btn" onclick="view_update_payment_action()">Submit</button>
										</div>
									</div>
								</div>
							</footer>
						</div>
					</div>
					<!-- Edit Payment Modal (End) -->					
				</section>
			</div>
			<?php include 'template/right_sidebar.php'; ?>
		</section>
		<?php include 'template/scripts.php'; ?>
		<script type="text/javascript">

			$(function(){
				
				$(document).on("change", ":file", function(){ // We can attach the `fileselect` event to all file inputs on the page
					var input = $(this),
					numFiles = input.get(0).files ? input.get(0).files.length : 1,
					label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
					input.trigger("fileselect", [numFiles, label]);
				});
				
				$(document).ready(function(){ // We can watch for our custom `fileselect` event like this
					$(":file").on("fileselect", function(event, numFiles, label){

						var input = $(this).parents(".input-group").find(":text"),
						log = numFiles > 1 ? numFiles + " files selected" : label;

						if (input.length)
						{
							input.val(log);
						}
						else
						{
							if (log)
							{
								alert(log);
							}
						}

					});
				});
			});
			
			$(document).ready(function(){
				$(document).on("click", ".open-edit-payment-page", function(data){

					var payment_id = $(this).data("payment_id");
					
					$.post("<?php echo site_url("deal/edit_payment_modal"); ?>/" + payment_id, function(data){
						$("#edit-payment-modal-payment-page").find("#payment_id").val(payment_id);
						$("#edit-payment-modal-payment-page").find("#hidden_sign").val(data.sign);
						$("#edit-payment-modal-payment-page").find("#fk_payment_type_view").val(data.fk_payment_type);
						$("#edit-payment-modal-payment-page").find("#amount_view").val(data.amount);
						$("#edit-payment-modal-payment-page").find("#reference_number").val(data.reference_number);
						$("#edit-payment-modal-payment-page").find("#payment_date").val(data.payment_date);
						$("#edit-payment-modal-payment-page").find("#optional_ad_fee_edit").val(data.admin_fee);
						$("#edit-payment-modal-payment-page").find("#edit_payment_invoice_tbl").html(data.invoices_html);
						$("#edit-payment-modal-payment-page").find("#payment_remarks").val(data.remarks);

						var sign = $("#edit-payment-modal-payment-page").find("#fk_payment_type_view").find(":selected").data("sign");

						if (data.merchant_cost == 0.00 || data.merchant_cost == "0.00" || data.merchant_cost == "")
						{
							$("#edit_merchant_cost_check_2").prop("checked", false);
							$("#edit_merchant_cost_2").prop("disabled", true);
						}
						else
						{
							$("#edit_merchant_cost_check_2").prop("checked", true);
							$("#edit_merchant_cost_2").prop("disabled", false);
							$("#edit_merchant_cost_2").val(data.merchant_cost);
						}

						if(data.fk_facility == 3)
							$("#edit_merchant_cost_check_2").prop("disabled", true);
						else
							$("#edit_merchant_cost_check_2").prop("disabled", false);

						$("#fk_payment_type_view option").each(function(){
							$(this).prop("hidden", false);
						});

						if (data.fk_facility != 0)
						{
							if (sign == 1)
							{
								//console.log(sign);
								$("#fk_payment_type_view option").each(function(){
									var this_sign = $(this).data("sign");
									if (this_sign == -1)
									{
										$(this).prop("hidden", true);
									}
									else
									{
										$(this).prop("hidden", false);	
									}
								});
							}
							else
							{
								//console.log(sign);
								$("#fk_payment_type_view option").each(function(){
									var this_sign = $(this).data("sign");
									if (this_sign == 1)
									{
										$(this).prop("hidden", true);
									}
									else
									{
										$(this).prop("hidden", false);	
									}
								});
							}

							$("#amount_view").prop("readonly", true);
							$("#reference_number").prop("readonly", true);
							$("#payment_date").prop("readonly", true);
							$("#payment_remarks").prop("readonly", true);
							$("#optional_ad_fee_edit").prop("readonly", true);
						}
						else
						{
							$("#amount_view").prop("readonly", false);
							$("#reference_number").prop("readonly", false);
							$("#payment_date").prop("readonly", false);
							$("#payment_remarks").prop("readonly", false);
							$("#optional_ad_fee_edit").prop("readonly", false);
						}

						$("#edit-payment-modal-payment-page").modal();
					}, "json");
				});

				$(document).on("change", "#edit_merchant_cost_check_2", function(){
					var this_status = $(this).prop("checked");
					var amount = $("#amount_view").val();
					var sign = $("#fk_payment_type_view option:selected").data("sign");
					var temp_cost = 0.00;
					
					if (amount == 0.00 || amount == "0.00" || amount == "")
					{
						amount = 0.00;				
					}

					if (this_status == true && sign == 1)
					{
						$("#edit_merchant_cost_2").prop("disabled", false);
						temp_cost = 0.3 + (0.0175 * parseFloat(amount));
						$("#edit_merchant_cost_2").val(temp_cost.toFixed(2));
					}
					else
					{
						$("#edit_merchant_cost_2").val("0.00");
						$("#edit_merchant_cost_2").prop("disabled", true);
					}
				});

				$(document).on("click", ".open_search_lead_modal",function(){
					var payment_id = $(this).data("idpayment");
					var payment_type = $(this).data("paymenttype");
					$(document).find("#hidden_payment_id_lead_search").val(payment_id);

					$("#payment_filtered_lead_search_result").html("");
					$("#payment_final_search_result").html("");

					$("#payment_type_assign_lead option").each(function(){
						$(this).prop("hidden", false);
					});
					
					$("#payment_type_assign_lead").val(payment_type);

					var sign = $("#map_payment_to_lead_modal").find("#payment_type_assign_lead").find(":selected").data("sign");

					if(sign == 1)
					{
						$("#payment_type_assign_lead option").each(function(){
							var this_sign = $(this).data("sign");
							if(this_sign == -1)
							{
								$(this).prop("hidden", true);
							}
							else
							{
								$(this).prop("hidden", false);	
							}
						});
					}
					else
					{
						$("#payment_type_assign_lead option").each(function(){
							var this_sign = $(this).data("sign");
							if(this_sign == 1)
							{
								$(this).prop("hidden", true);
							}
							else
							{
								$(this).prop("hidden", false);	
							}
						});
					}

					$("#payment_type_panel").prop("hidden", true);
					$("#map_payment_to_lead_modal").modal();
				});

				$(document).on("change", ".search_lead_field",function(){
					
					$("#payment_filtered_lead_search_result").html("");
					$("#payment_type_panel").prop("hidden", true);
					var search_lead_email = $("#search_lead_email").val();
					var search_lead_name  = $("#search_lead_name").val();
					var search_lead_qm  = $("#search_lead_qm").val();

					var data = {
						search_lead_email: search_lead_email,
						search_lead_name : search_lead_name,
						search_lead_qm   : search_lead_qm
					};

					$.ajax({
						type: "POST",
						url: "<?php echo site_url('deal/search_lead'); ?>",
						cache: false,
						data: data,
						success: function(result) {
							$("#payment_filtered_lead_search_result").html(result);
							$("#payment_final_search_result").html("");
						}
					});
				});

				$(document).on("click", ".select_lead", function(){
					var lead_id = $(this).data("lead_id");

					var data = {
						lead_id: lead_id
					}

					$("#payment_final_search_result").html("");
					$("#payment_type_panel").prop("hidden", true);
					$.ajax({
						type: "POST",
						url: "<?php echo site_url("deal/get_specific_lead"); ?>",
						data: data,
						cache: false,
						success: function(result){
							$("#payment_filtered_lead_search_result").html("");
							$("#payment_final_search_result").html(result);
							$("#payment_type_panel").prop("hidden", false);
						}
					});
				});

				$(document).on("click", "#assign_lead_to_payment_btn", function(){
					var payment_id = $(document).find("#hidden_payment_id_lead_search").val();
					var lead_id = $(document).find("#payment_hidden_assign_lead_id").val();
					var payment_type = $(document).find("#payment_type_assign_lead").val();

					var data ={
						lead_id     : lead_id,
						payment_id  : payment_id,
						payment_type: payment_type
					};

					$.ajax({
						type: "POST",
						url: "<?php echo site_url("deal/assign_payment_to_lead"); ?>",
						data: data,
						cache: false,
						success: function(result){
							$("#payment_filtered_lead_search_result").html("");
							$("#payment_final_search_result").html("");
						}
					});
				});
			});			

			function view_update_payment_action ()
			{
				var payment_id           = $("#edit-payment-modal-payment-page").find("#payment_id").val();
				var fk_payment_type      = $("#edit-payment-modal-payment-page").find("#fk_payment_type").val();
				var amount               = $("#edit-payment-modal-payment-page").find("#amount_view").val();
				var reference_number     = $("#edit-payment-modal-payment-page").find("#reference_number").val();
				var payment_date         = $("#edit-payment-modal-payment-page").find("#payment_date").val();
				var orig_amount          = $("#payment_row_"+payment_id).find(".payment_amount_td").text();
				var optional_ad_fee_edit = $("#edit-payment-modal-payment-page").find("#optional_ad_fee_edit").val();

				orig_amount = parseFloat(orig_amount.replace('$ ', ''));

				var sign = $("#edit-payment-modal-payment-page").find("#fk_payment_type option:selected").data("sign");
				var orig_sign = parseFloat($("#edit-payment-modal").find("#hidden_sign").val());

				var fk_payment_type_text  = $("#edit-payment-modal-payment-page").find("#fk_payment_type_view option:selected").text();

				if (fk_payment_type == "" || amount == "" || reference_number == "" || payment_date == "")
				{
					alert ("Please complete all the required fields!");
					return false;
				}

				var user = "<?php echo $session_data['name']; ?>";

				$.ajax({
					type: "POST",
					url: "<?php echo site_url('deal/update_payment'); ?>/" + payment_id,
					data: $("#edit-payment-modal-payment-page").find(".main_form").serialize(),
					cache: false,
					success: function(result) {

						$("#payment_row_"+payment_id).find('.payment_type_td').text(fk_payment_type_text);
						$("#payment_row_"+payment_id).find('.referencet_td').text(reference_number);
						$("#payment_row_"+payment_id).find('.payment_amount_td').text(amount);
						$("#payment_row_"+payment_id).find('.payment_date_td').text(payment_date);
						$("#payment_row_"+payment_id).find('.admin_fee').text(optional_ad_fee_edit);

						$("#edit-payment-modal-payment-page").modal("hide");
					}
				});
			}

			function delete_payment (payment_id)
			{
				if (confirm("Are you sure you want to delete this?"))
				{
					$.ajax({
						type: "POST",
						url: "<?php echo site_url('deal/delete_payment'); ?>/"+payment_id,
						cache: false,
						success: function(result){
							$(document).find("#payment_row_"+String(payment_id)).remove();
						}
					});
				}
			}
		</script>
	</body>
</html>
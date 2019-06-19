<?php include 'template/head.php'; ?>
	<body>
		<style>
			.slim_alert { 
				padding: 3px 12px;
				margin: 5px 0px;
			}
			
			.figure_text {
				font-size: 1.1em; 
				font-weight: bold;
			}
		</style>
		<section class="body">
			<?php include 'template/header.php'; ?>
			<div class="inner-wrapper">
				<?php include 'template/left_sidebar.php'; ?>
				<section role="main" class="content-body">
					<?php include 'template/header_2.php'; ?>
					<!-- start: page -->					
					<div class="row">
						<div class="col-md-3">
							<section class="panel"> <!-- Image + Notifications -->	
								<div class="panel-body">
									<div class="thumb-info mb-md">
										<img src="<?php echo $user_image; ?>" class="rounded img-responsive" alt="Profile Image" style="width: 100%;" />
										<div class="thumb-info-title">
											<span class="thumb-info-inner"><?php echo $home_user_type; ?></span>
											<span class="thumb-info-type"><?php echo $name; ?></span>
										</div>
									</div>
									<div class="widget-toggle-expand mb-md">
										<div class="widget-header">
											<h6>Progress</h6>
											<div class="widget-toggle">+</div>
										</div>
										<div class="widget-content-collapsed">
											<div class="progress progress-xs light">
												<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $progress_percentage; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $progress_percentage; ?>%;">
													<?php echo $progress_percentage; ?>%
												</div>
											</div>
										</div>
										<div class="widget-content-expanded">
											<?php
											foreach ($home_notifications AS $home_notification)
											{
												?>
												<p><span class="badge" style="background: #d64b4b"><?php echo $home_notification['count']; ?></span> <?php echo $home_notification['label']; ?></p>
												<?php
											}
											?>
										</div>
									</div>
								</div>
							</section>
							<ul class="simple-card-list mb-xlg"> <!-- Stats -->				
								<li class="danger">
									<h3>$ <?php echo number_format($commissionable_gross, 2); ?></h3>
									<p>Commissionable Gross</p>
								</li>
								<?php
								foreach ($home_stats AS $home_stat)
								{
									?>
									<li class="primary">
										<h3><?php echo $home_stat['count']; ?></h3>
										<p><?php echo $home_stat['label']; ?></p>
									</li>
									<?php
								}
								?>
							</ul>
						</div>
						<div class="col-md-9">
							<div class="tabs">
								<ul class="nav nav-tabs tabs-primary"> <!-- Tabs -->	
									<li class="active">
										<a href="#tab_timeline" onclick="load_timeline()" data-toggle="tab">Timeline</a>
									</li>
									<?php 
									foreach ($home_tabs AS $home_tab)
									{
										?>
										<li>
											<a href="#tab_<?php echo $home_tab['id']; ?>" onclick="<?php echo $home_tab['function']; ?>(<?php echo $home_tab['id']; ?>)" class="tab-head" data-status="<?php echo $home_tab['id']; ?>" data-toggle="tab">
												<?php echo $home_tab['label']; ?>
											</a>
										</li>										
										<?php
									}
									?>
								</ul>
								<div class="tab-content">
									<div id="tab_timeline" class="tab-pane active">
										<section class="simple-compose-box mb-xlg" style="margin-top: 10px;">
											<form method="post" id="leave_message_form" name="leave_message_form" action="">
												<textarea data-plugin-textarea-autosize placeholder="Post on the timeline" rows="1" id="user_message" name="message"></textarea>
												<div class="compose-box-footer">
													<ul class="compose-btn">
														<li>
															<a class="btn btn-primary btn-xs" onclick="post_to_timeline()">Send</a>
														</li>
													</ul>
												</div>
											</form>
										</section>
										<div id="tab_timeline_content">
										</div>
									</div>
									<?php 
									foreach ($home_tabs AS $home_tab)
									{
										?>
										<div id="tab_<?php echo $home_tab['id']; ?>" class="tab-pane" data-status="<?php echo $home_tab['id']; ?>">
											<center>
												<i class="fa fa-refresh fa-spin" style="font-size: 50px; margin-top: 20px; margin-bottom: 20px;"></i>
											</center>
										</div>
										<?php
									}
									?>
									
								</div>
							</div>
						</div>
					</div>					
					<!-- end: page -->
					<?php include 'modals/ticket_modals.php'; ?>	
					<div id="edit-call-back-modal" class="modal fade"> <!-- Edit Call Back Modal-->
						<div class="modal-dialog" style="width: 80%;">
							<section class="panel">
								<div class="panel-body">
									<div class="modal-wrapper">
										<div class="modal-text">
											<form method="post" action="" id="edit_form" name="edit_form">
												<input type="hidden" id="edit_lead_id" name="edit_lead_id" value="" />
												<input type="hidden" id="callback_type" name="callback_type" value="" />
												<div class="form-group">
													<div class="col-md-6 text-left">
														<label>Call Back Date:</label>
														<?php $now = date("Y-m-d"); ?>
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-calendar"></i>
															</span>
															<input class="form-control input-md datepicker" id="edit_assignment_date" name="edit_assignment_date" data-date-format="yyyy-mm-dd" value="<?php // echo $now; ?>" required>
														</div>
													</div>
													<div class="col-md-6 text-left">
														<label>Call Back Time:</label>
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-clock-o"></i>
															</span>
															<input type="text" class="form-control input-md timepicker" id="edit_assignment_time" name="edit_assignment_time" required>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="col-md-12 text-left">
														<label>Assign to:</label>
														<select class="form-control" name="edit_quote_specialist" title="Quote Specialist" id="edit_quote_specialist">
															<?php 
															foreach ($admins as $admin)
															{					
																?>
																<option value="<?php echo $admin->id_user; ?>" name="quote_specialist">
																	<?php echo $admin->name; ?>
																</option>
																<?php
															}
															?>
														</select>
													</div>
												</div>												
												<div class="form-group">										
													<div class="col-md-12 text-left">
														<label>Remarks:</label>
														<textarea id="edit_lead_details" name="edit_lead_details" class="form-control" rows="3" placeholder="Lead Details" required></textarea>
													</div>								
												</div>												
											</form>
										</div>										
									</div>
								</div>
								<footer class="panel-footer">
									<div class="row">
										<div class="col-md-12 text-right">
											<button type="button" class="btn btn-primary" id="save_callback">Save</button>
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										</div>
									</div>
								</footer>
							</section>					
						</div>
					</div>
					<div class="modal fade" tabindex="-1" role="dialog" id="aftersales_accessory_modal"> <!-- Aftersales Attached Accessories Modal -->
						<div class="modal-dialog" style="width: 80%;">
							<div class="modal-content">
								<header class="panel-heading">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title">ACCESSORIES BUYING FORM</h4>
								</header>
								<input type="hidden" name="hidden_lead_id_aftersales_modal" id="hidden_lead_id_aftersales_modal">
								<input type="hidden" name="hidden_status_aftersales_modal" id="hidden_status_aftersales_modal">
								<div class="modal-body" style="padding-top: 25px !important;" id="aftersales_accessory_body">
								</div>
								<div class="modal-footer" style="padding-top: 10px !important; padding-bottom: 10px !important; margin-top: 0px !important;">
									<span class="btn btn-default" data-dismiss="modal">Close</span>
								</div>
							</div>
						</div>
					</div>
					<div class="modal fade" tabindex="-1" role="dialog" id="aftersales_add_accessory_modal_choose"> <!-- Aftersales Add Accessory Modal -->
						<div class="modal-dialog" style="width: 70%;">
							<div class="modal-content">
								<header class="panel-heading">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title">ADD ACCESSORIES</h4>
								</header>
								<input type="hidden" name="hidden_lead_id_modal_choose" id="hidden_lead_id_modal_choose">
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
													<tbody id="aftersales_add_accessory_table_body">
														
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
								<div class="modal-footer" style="padding-top: 10px !important; padding-bottom: 10px !important; margin-top: 0px !important;">
									<span class="btn btn-default" id="aftersales_lead_add_new_accessory_btn">Add New Accessory</span>
									<span class="btn btn-primary" id="aftersales_accessory_btn_confirm">Confirm</span>
									<span class="btn btn-default" data-dismiss="modal">Close</span>
								</div>
							</div>
						</div>
					</div>
					<div class="modal fade" tabindex="-1" role="dialog" id="additional_remarks_modal"> <!-- Remarks Modal -->
						<div class="modal-dialog" style="width: 60%;">
							<div class="modal-content">
								<header class="panel-heading">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title">REMARKS</h4>
								</header>
								<input type="hidden" name="hidden_add_remarks_status" id="hidden_add_remarks_status">
								<input type="hidden" name="hidden_add_remarks_lead_id" id="hidden_add_remarks_lead_id">
								<div class="modal-body" style="padding-top: 25px !important;">
									<div class="row">
										<div class="col-md-12" style="margin-top: 10px; margin-bottom: 10px;" >
											<div class="table-responsive">
												<textarea class="form-control" width="100%" rows="10" placeholder="Remarks..." id="afterales_remarks"></textarea>
											</div>
										</div>
									</div>
								</div>
								<div class="modal-footer" style="padding-top: 10px !important; padding-bottom: 10px !important; margin-top: 0px !important;">
									<span class="btn btn-primary" id="additional_remarks_confirm">Confirm</span>
									<span class="btn btn-default" data-dismiss="modal">Close</span>
								</div>
							</div>
						</div>
					</div>
					<div class="modal fade" " role="dialog" id="aftersales_add_new_accessory_modal"> <!-- Add New Accessory Modal -->
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
												<select class="form-control input-sm" id="aftersales_fk_accessory_supplier" name="fk_accessory_supplier">
													
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
									<span class="btn btn-default" id="aftersales_lead_add_new_supplier">Add New Supplier</span>
									<span class="btn btn-default" data-dismiss="modal">Close</span>
									<span class="btn btn-primary" id="aftersales_add_new_accessory_confirm">Confirm</span>
								</div>
							</div>
						</div>
					</div>
					<div class="modal fade" " role="dialog" id="aftersales_add_new_supplier_modal"> <!-- Add New Supplier Modal -->
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
									<span class="btn btn-primary" id="aftersales_add_new_accessory_supplier_confirm">Confirm</span>
								</div>
							</div>
						</div>
					</div>					
				</section>	
			</div>
			<?php include 'template/right_sidebar.php'; ?>
		</section>
		<?php include 'template/scripts.php'; ?>
		<script type="text/javascript">
			$(document).ready(function(){
				
				load_timeline();
				
				$(document).on("click", "#aftersales_lead_add_new_accessory_btn", function(){
		
					$.ajax({
						type: "POST",
						url: "<?php echo site_url("accessory/initialize_create_accessory_modal"); ?>",
						data: {},
						dataType: 'json',
						cache: false,
						success: function(data){
							$("#aftersales_fk_accessory_supplier").html(data.suppliers_html);

							$("#aftersales_add_new_accessory_modal").modal();
						}
					});
				});

				$(document).on("click", "#aftersales_add_new_accessory_confirm", function(){
					var form = $(".add_new_accessory_form").serialize();

					if($("#aftersales_fk_accessory_supplier").val() == ""){
						alert("Please choose an accessory supplier!");
						return false;
					}

					$.ajax({
						type: "POST",
						url: "<?php echo site_url("accessory/insert_new_accessory"); ?>",
						data: form,
						cache: false,
						success: function(response){
							$("#aftersales_add_accessory_table_body").append(response);
							$("#aftersales_add_new_accessory_modal").modal("hide");
						}
					});
				});

				$(document).on("click", "#aftersales_add_new_accessory_supplier_confirm", function(){
					var form = $(".add_new_accessory_supplier_form").serialize();

					$.ajax({
						type: "POST",
						url: "<?php echo site_url("accessory/insert_new_accessory_supplier"); ?>",
						data: form,
						cache: false,
						success: function(response){
							$("#aftersales_fk_accessory_supplier").append(response);
							$("#aftersales_add_new_supplier_modal").modal("hide");
						}
					});
				});

				$(document).on("click", "#aftersales_lead_add_new_supplier", function(){
					$("#aftersales_add_new_supplier_modal").modal();
				});

				$(document).on("click", ".as_buying_btn", function(){
					var lead_id = $(this).data("lead_id");
					var status = $(this).data("status");

					var data = {
						lead_id: lead_id,
						status: status
					};
					$(document).find("#aftersales_accessory_body").html("");
					$.ajax({
						type: "POST",
						url: "<?php echo site_url('deal/after_sales_accessory_modal'); ?>",
						data: data,
						dataType: 'json',
						cache: false,
						success: function(data){
							$(document).find("#hidden_lead_id_aftersales_modal").val(data.lead_id);
							$(document).find("#hidden_status_aftersales_modal").val(data.status);
							$(document).find("#aftersales_accessory_body").html(data.accessory_dom);
							$("#aftersales_accessory_modal").modal("show");
						}
					});
				});

				$(document).on("click", "#aftersales_add_accessory_btn", function(){
					var lead_id = $(this).data("leadid");
					
					var data = {
						lead_id: lead_id
					}
					
					$(document).find("#hidden_lead_id_modal_choose").val(lead_id);
					$("#aftersales_add_accessory_table_body").html("");

					$.ajax({
						type: "POST",
						url: "<?php echo site_url("lead/get_all_accessories"); ?>",
						data: data,
						cache: false,
						success: function(result){
							$("#aftersales_add_accessory_table_body").html(result);
							$(document).find(".acc_check").prop("checked", false);
							$("#aftersales_add_accessory_modal_choose").modal();	
						}
					});
				});

				$(document).on("click", "#aftersales_accessory_btn_confirm", function(){
					var id_arr       = [];
					var supplier_arr = [];
					var code_arr     = [];
					var name_arr     = [];
					var cost_arr     = [];
					var lead_id      = $(document).find("#hidden_lead_id_modal_choose").val();

					$(document).find(".acc_check").each(function(index, value){
						var id = $(this).val();
						
						if($(this).prop("checked") == true)
						{
							id_arr.push(id);
							supplier_arr.push($(this).closest("tr").data("supplier"));
							code_arr.push($(this).closest("tr").data("code"));
							name_arr.push($(this).closest("tr").data("name"));
							cost_arr.push($(this).closest("tr").data("cost"));
						}
					});

					var data = {
						id_arr: id_arr,
						lead_id: lead_id
					};
					
					$.ajax({
						type: "POST",
						url: "<?php echo site_url("lead/insert_lead_accessory"); ?>",
						data: data,
						dataType: "json",
						cache: false,
						success: function(data){
							if(data.length > 0)
							{
								$(document).find("#aftersales_accessory_no_record").remove();
							}

							var i;
							var html = ""; 
							for (i in data)
							{
								var temp_cost = 0;
								var temp_cost = parseInt(cost_arr[i]);

								html += '<tr id="acc_tr_id_'+data[i]+'" data-idacc="'+data[i]+'">\
											<td><a href="#" class="del_lead_acc_aftersales" data-idacc="'+data[i]+'"><i class="fa fa-trash-o"></i></a></td>\
											<td>'+supplier_arr[i]+'</td>\
											<td>'+code_arr[i]+'</td>\
											<td>'+name_arr[i]+'</td>\
											<td class="supplier_price_td">'+cost_arr[i]+'</td>\
											<td>\
												<input value="0.00" class="form-control input-sm acc_price" type="text" name="deal_accessory_price['+data[i]+']" onkeypress="return isNumberKey(event)" style="text-align: right !important;">\
											</td>\
											<td>\
												<input value="1" class="form-control input-sm acc_quantity" type="text" name="deal_accessory_quantity['+data[i]+']" onkeypress="return isNumberKey(event)" style="text-align: right !important;">\
											</td>\
											<td>\
												<input value="0.00" class="form-control input-sm total_price" type="text" name="total_price" onkeypress="return isNumberKey(event)" readonly style="text-align: right !important;">\
											</td>\
											<td hidden>\
												<input type="hidden" class="hidden_total_cost" value="'+temp_cost+'">\
											</td>\
										</tr>';
							}

							$(document).find("#modal_aftersales_accessory_table_body").append(html);
							$("#aftersales_add_accessory_modal_choose").modal("hide");
							compute_total_price_revenue();
						}
					});
				});

				$(document).on("click", "#update_aftersales_accessory_btn", function(){
					var id_arr       = [];
					var quantity_arr = [];
					var price_arr    = [];
					var lead_id      = $(document).find("#hidden_lead_id_aftersales_modal").val();
					var status       = $(document).find("#hidden_status_aftersales_modal").val();
					var acc_spec_con = $(document).find("#aftersales_accessory_special_conditions").val();
					var acc_job_date = $(document).find("#aftersales_accessory_job_date").val();
					var acc_status   = 0;

					var buyflag = $(this).data("buyflag");

					if($(document).find("#aftersales_accessory_status").prop("checked") == true)
						acc_status = 1;

					$(document).find(".acc_quantity").each(function(index, value){
						var quantity    = $(this).val();
						var price       = $(this).closest("tr").find(".acc_price").val();
						var id_deal_acc = $(this).closest("tr").data("idacc");

						id_arr.push(id_deal_acc);
						quantity_arr.push(quantity);
						price_arr.push(price);
					});

					var data = {
						id_arr      : id_arr,
						quantity_arr: quantity_arr,
						price_arr   : price_arr,
						lead_id     : lead_id,
						acc_spec_con: acc_spec_con,
						acc_job_date: acc_job_date,
						acc_status  : acc_status
					};

					$.ajax({
						type: "POST",
						url: "<?php echo site_url("lead/update_lead_accessory"); ?>",
						data: data,
						cache: false,
						success: function(result){
							if (result === "success")
							{
								update_aftersales_status(status, lead_id, $("#aftersales_row_"+String(lead_id)), buyflag);
								$("#aftersales_accessory_modal").modal("hide");
							}
							else
							{
								alert("Update Failed!");
							}
						}
					});
				});

				$(document).on("change", ".acc_price", function(){
					var this_row          = $(this).closest('tr');
					var total_price_field = this_row.find('.total_price');
					var price             = parseFloat($(this).val());
					var qty               = parseInt(this_row.find('.acc_quantity').val());
					var total_price       = 0.00;

					total_price = price * qty;

					var total_cost_field = this_row.find('.hidden_total_cost');
					var cost = this_row.find(".supplier_price_td").text();
					var total_cost = 0.00

					total_cost = parseInt(cost) * qty;

					$(total_cost_field).val( (parseFloat(total_cost)).toFixed(2) );

					$(total_price_field).val( (parseFloat(total_price)).toFixed(2) );

					compute_total_price_revenue();
				});

				$(document).on("change", ".acc_quantity", function(){
					var this_row          = $(this).closest('tr');
					var total_price_field = this_row.find('.total_price');
					var qty               = parseFloat($(this).val());
					var price             = parseInt(this_row.find('.acc_price').val());
					var total_price       = 0.00;

					total_price = price * qty;

					var total_cost_field = this_row.find('.hidden_total_cost');
					var cost = $(this_row).find(".supplier_price_td").text();
					var total_cost = 0.00

					total_cost = parseInt(cost) * qty;

					$(total_cost_field).val( (parseFloat(total_cost)).toFixed(2) );

					$(total_price_field).val( (parseFloat(total_price)).toFixed(2) );

					compute_total_price_revenue();
				});

				$(document).on("click", ".as_undecided_btn", function(){
					var lead_id = $(this).data("lead_id");
					var status  = $(this).data("status");

					$("#hidden_add_remarks_status").val(status);
					$("#hidden_add_remarks_lead_id").val(lead_id);
					$("#afterales_remarks").val("");
					$("#additional_remarks_modal").modal();
				});	

				$(document).on("click", ".as_notinterested_btn", function(){
					var lead_id = $(this).data("lead_id");
					var status  = $(this).data("status");

					$("#hidden_add_remarks_status").val(status);
					$("#hidden_add_remarks_lead_id").val(lead_id);
					$("#afterales_remarks").val("");
					$("#additional_remarks_modal").modal();
				});

				$(document).on("click", "#additional_remarks_confirm", function(){
					var status  = $("#hidden_add_remarks_status").val();
					var lead_id = $("#hidden_add_remarks_lead_id").val();

					var div_obj = $("#aftersales_row_"+String(lead_id));
					var remarks = $.trim($("#afterales_remarks").val());

					$("#additional_remarks_modal").modal("hide");
					update_aftersales_status(status, lead_id, div_obj, 0, remarks);
				});

				$(document).on("click", ".del_lead_acc_aftersales", function(){
					var id_acc = $(this).data("idacc");
					var this_row = $(this).closest("tr");
					var data = {
						id_acc: id_acc
					};

					if(confirm("Are you sure you want to delete this accessory?"))
					{
						$.ajax({
							type: "POST",
							url: "<?php echo site_url("lead/delete_lead_accessory"); ?>",
							data: data,
							cache: false,
							success: function(result){
								if(result === "success"){
									this_row.remove();
									compute_total_price_revenue();
								}
								else
									alert("Accessory deletion failed!");
							}
						});
					}
					else
					{
						return false;
					}
				});	

				$(document).on("click", ".refresh_aftersales_tab", function(){
					var status = $(this).data("status");
					$("#tab_"+status).html('<center><i class="fa fa-refresh fa-spin" style="font-size: 50px; margin-top: 20px; margin-bottom: 20px;"></i></center>');
					load_aftersales_tab(status);
				});
				
				$(document).on("click", ".refresh_sales_tab", function(){
					var status = $(this).data("status");
					$("#tab_"+status).html('<center><i class="fa fa-refresh fa-spin" style="font-size: 50px; margin-top: 20px; margin-bottom: 20px;"></i></center>');
					load_sales_tab(status, "", "");
				});				

				$(document).on("click", ".tab-head", function(){
					var status = $(this).data("status");
					$("#tab_"+status).html('<center><i class="fa fa-refresh fa-spin" style="font-size: 50px; margin-top: 20px; margin-bottom: 20px;"></i></center>');
				});
				
				$(document).on("click", ".edit-callback", function(){
					var $this         = $(this);
					var lead_id       = $this.data("lead_id");
					var edit_modal    = $("#edit-call-back-modal");
					var callback_type = $(this).data("callbacktype");

					var data = {
						lead_id: lead_id
					};

					$.ajax({
						type: "POST",
						url: "<?php echo site_url("lead/get_single_lead_call_back"); ?>",
						data: data,
						cache: false,
						dataType: 'json',
						success: function(data){
							edit_modal.find("#edit_lead_id").val(lead_id);
							edit_modal.find("#edit_assignment_date").val(data.assignment_date);
							edit_modal.find("#edit_assignment_time").val(data.assignment_time);
							edit_modal.find("#edit_quote_specialist").val(data.fk_user);
							edit_modal.find("#edit_lead_details").val(data.details);
							edit_modal.find("#callback_type").val(callback_type);
							edit_modal.modal();
						}
					});
				});
				
				$(document).on("click", "#save_callback", function(){
					var edit_modal = $("#edit-call-back-modal");
					var form = $("#edit_form");
					var data = form.serialize();
					var lead_id = $("#edit_lead_id").val();
					$.ajax({
						type: "POST",
						url: "<?php echo site_url("lead/update_single_call_back"); ?>",
						data: data,
						cache: false,
						success: function(response){
							
							if(response=="pre-tender"){
								$("#aftersales_row_"+String(lead_id)).remove();
								edit_modal.modal("hide");
							}
							else
								alert ("Success!");
						}
					});
				});

				$(document).on("change", "#client", function(){
					var status = $(this).closest(".tab-pane").data("status");
					var client = $.trim($(this).val());
					$("#tab_"+status).html('<center><i class="fa fa-refresh fa-spin" style="font-size: 50px; margin-top: 20px; margin-bottom: 20px;"></i></center>');
					load_sales_tab(status, client, "");
				});

				$(document).on("click", ".filter_button", function(){
					var filter_body = $(this).closest(".panel").find(".filter_body");
					//console.log($(filter_body).prop("class"));
					if( $(filter_body).hasClass("active") == true )
					{
						$(filter_body).slideUp(300);
						$(filter_body).removeClass("active");
						$(this).text("Show Filters");
					}
					else
					{
						$(filter_body).slideDown(300);	
						$(filter_body).addClass("active");
						$(this).text("Hide Filters");
					}
				});
			});

			function compute_total_price_revenue ()
			{
				var total_price_obj = $("#aftersales_accessory_modal").find(".total_price");
				var cost_obj        = $("#aftersales_accessory_modal").find(".hidden_total_cost");
				var total_price     = 0.00;
				var total_cost      = 0.00;
				var total_revenue   = 0.00;

				$(total_price_obj).each(function(index, value){
					var temp_val = parseFloat($(this).val());
					total_price = total_price + temp_val;
				});

				$(cost_obj).each(function(index, value){
					var temp_val = parseFloat($(this).val());
					total_cost = total_cost + temp_val;
				});

				total_revenue = parseInt(total_price) - parseInt(total_cost);
				total_revenue = (parseFloat(total_revenue)).toFixed(2);

				$(document).find("#total_deal_accessory_price").text((parseFloat(total_price)).toFixed(2));
				$(document).find("#total_revenue").text(total_revenue);
			}

			function update_aftersales_status (status, lead_id, div_obj, buyflag, remarks)
			{
				if (typeof(remarks) == 'undefine')
				{
					remarks = "";
				}

				var data ={
					status : status,
					lead_id: lead_id,
					remarks: remarks
				}
				
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('deal/update_aftersales_status'); ?>",
					data: data,
					cache: false,
					success: function(result){
						if(typeof(buyflag) != 'undefined' ){
							if(buyflag != 3)
								$(div_obj).remove();
						}
					}
				});
			}

			function post_to_timeline ()
			{
				var user_message = $("#user_message").val();
				
				if (user_message != "")
				{
					$.ajax({
						type: "POST",
						url: "<?php echo site_url('admin/timeline_post'); ?>",
						data: $("#leave_message_form").serialize(),
						cache: false,
						success: function(result){
							$("#user_message").val("");
							load_timeline();
						}
					});
				}
				else
				{
					alert ("Your message cannot be blank!");
				}				
			}
			
			function load_aftersales_tab (status)
			{
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("lead/load_home_aftersales_tab_html"); ?>/"+status,
					cache: false,
					success: function(data){
						$("#tab_"+status).html(data);
					}
				});
			}
			
			function load_sales_tab (home_status, client, date)
			{
				if (client == "")
				{
					var data = {
						home_status: home_status,
						date: date
					}
				}
				else
				{
					var data = {
						home_status: home_status,
						date: date,
						client: client
					}
				}

				$.ajax({
					type: "POST",
					url: "<?php echo site_url("lead/load_home_sales_tab_html"); ?>",
					data: data,
					cache: false,
					success: function(data){
						$("#tab_"+home_status).html(data);
					}
				});
			}

			function load_timeline ()
			{
				$("#calendar_container").prop("hidden", true);
				$("#tab_timeline_content").html('<center><i class="fa fa-refresh fa-spin" style="font-size: 50px; margin-top: 20px; margin-bottom: 20px;"></i></center>');
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("admin/get_timeline"); ?>/"+status,
					cache: false,
					success: function(data){
						$("#tab_timeline_content").html(data);
					}
				});
			}			
		</script>		
	</body>
</html>
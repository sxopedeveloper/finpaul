<?php include 'template/head.php'; ?>
	<body>
		<section class="body">
			<?php include 'template/header.php'; ?>
			<div class="inner-wrapper">
				<?php include 'template/left_sidebar.php'; ?>
				<section role="main" class="content-body">
					<?php include 'template/header_2.php'; ?>
					<!-- start: page -->						
					<section class="panel">
						<?php /*?><header class="panel-heading">
							<div class="panel-actions">
								<a href="#" class="fa fa-caret-down"></a>
							</div>
							<h2 class="panel-title">
								<span class="label label-primary label-sm text-normal va-middle mr-sm"><?php echo $result_count; ?></span>
								<span class="va-middle">Search Filters</span>
							</h2>
						</header><?php */?>
						<form action="<?php echo site_url('account/staffs'); ?>" id="main_list_filter_form" class="form-horizontal form-bordered" method="get" accept-charset="utf-8">
							<div class="panel-body">
									<h5><b>Search Filters</b></h5>
								<?php
								$status = isset($_GET['status']) ? $_GET['status'] : '';
								$email = isset($_GET['email']) ? $_GET['email'] : '';
								$name = isset($_GET['name']) ? $_GET['name'] : '';
								$abn = isset($_GET['abn']) ? $_GET['abn'] : '';
								$state = isset($_GET['state']) ? $_GET['state'] : '';
								$postcode = isset($_GET['postcode']) ? $_GET['postcode'] : '';
								$address = isset($_GET['address']) ? $_GET['address'] : '';
								$phone = isset($_GET['phone']) ? $_GET['phone'] : '';
								$mobile = isset($_GET['mobile']) ? $_GET['mobile'] : '';

								$selected_status_0 = ""; if ($status == "0") { $selected_status_0 = " selected"; }
								$selected_status_1 = ""; if ($status == "1") { $selected_status_1 = " selected"; }								
								?>
								<div class="form-group">
									<div class="col-md-2">
										<select class="form-control input-md" name="status" title="User Status">
											<option name="status" value="">-User Status-</option>
											<option name="status" value="1" <?php echo $selected_status_1; ?>>Activated</option>
											<option name="status" value="0" <?php echo $selected_status_0; ?>>Deactivated</option>
										</select>
									</div>
									<div class="col-md-2">
										<input value="<?php echo $email; ?>" class="form-control mb-md" name="email" type="text" placeholder="Email Address">
									</div>
									<div class="col-md-2">
										<input value="<?php echo $name; ?>" class="form-control mb-md" name="name" type="text" placeholder="Manager Name">
									</div>

									<div class="col-md-2">
										<input value="<?php echo $abn; ?>" class="form-control mb-md" name="abn" type="text" placeholder="ABN">
									</div>
									<div class="col-md-2">
										<input value="<?php echo $phone; ?>" class="form-control mb-md" name="phone" type="text" placeholder="Phone">
									</div>
									<div class="col-md-2">
										<input value="<?php echo $mobile; ?>" class="form-control mb-md" name="mobile" type="text" placeholder="Mobile">
									</div>

									<div class="col-md-2">
										<input value="<?php echo $state; ?>" class="form-control mb-md" name="state" type="text" placeholder="State">
									</div>
									<div class="col-md-2">
										<input value="<?php echo $postcode; ?>" class="form-control mb-md" name="postcode" type="text" placeholder="Postcode">
									</div>
									<div class="col-md-2">
										<input value="<?php echo $address; ?>" class="form-control mb-md" name="address" type="text" placeholder="Address">
									</div>
									<div class="col-md-2 pull-right">
										<button class="btn btn-primary search-filter-btn  col-md-12 col-sm-12 col-xs-12" value="Search" name="submit">Apply Filters</button>
									</div>
								</div>
							</div>
						<?php /*?>	<footer class="panel-footer text-right">
								<button class="btn btn-primary" value="Search" name="submit">Apply Filters</button>
							</footer><?php */?>
						</form>
					</section>
					<section class="panel" id="tableData">
						<div class="panel-body">			
							<div class="table-responsive">
								<?php
								if (count($staffs)==0)
								{
									echo "<br /><center><i>No results found!</i></center><br /><br /><br /><br />";
								}
								else
								{
								?>
									<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
										<thead>
											<tr>
												<?php
												if ($admin_type == 2)
												{
													?>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<?php
												}
												?>
												<th>Lead Stack</th>
												<th>Status</th>
												<th>Type</th>
												<th>Name</th>
												<th>Email</th>
												<th>ABN</th>
												<th>Phone</th>
												<th>Mobile</th>
												<th>State</th>												
												<th>Postcode</th>
												<th>Address</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach($staffs as $staff)
											{
												?>
												<tr id="staff_row_<?php echo $staff->id_user; ?>">
													<?php
													if ($admin_type == 2)
													{
														?>
														<td class="text-center">
															<?php
															$deactivate_button_hidden = "";
															$activate_button_hidden = "";
															if ($staff->status == 0) { $deactivate_button_hidden = " hidden"; }
															else { $activate_button_hidden = " hidden";	}
															?>													
															<a href="#" id="activate_button_<?php echo $staff->id_user; ?>" onClick="activate_staff(<?php echo $staff->id_user; ?>)" data-toggle="tooltip" data-placement="top" title="Activate staff" <?php echo $activate_button_hidden; ?>>
																<i class="fa fa-check"></i>
															</a>
															<a href="#" id="deactivate_button_<?php echo $staff->id_user; ?>" onClick="deactivate_staff(<?php echo $staff->id_user; ?>)" data-toggle="tooltip" data-placement="top" title="Deactivate staff" <?php echo $deactivate_button_hidden; ?>>
																<i class="fa fa-times"></i>
															</a>
														</td>
														<td class="text-center">
															<?php
															$lead_deactivate_button_hidden = "";
															$lead_activate_button_hidden = "";
															if ($staff->lead_stack == 1) { $lead_deactivate_button_hidden = " hidden"; }
															else { $lead_activate_button_hidden = " hidden";	}
															?>													
															<a href="#" id="lead_stack_activate_button_<?php echo $staff->id_user; ?>" onClick="activate_lead_stack(<?php echo $staff->id_user; ?>)" data-toggle="tooltip" data-placement="top" title="Activate Lead Stack" <?php echo $lead_activate_button_hidden; ?>>
																<i class="fa fa-check"></i>
															</a>
															<a href="#" id="lead_stack_deactivate_button_<?php echo $staff->id_user; ?>" onClick="deactivate_lead_stack(<?php echo $staff->id_user; ?>)" data-toggle="tooltip" data-placement="top" title="Deactivate Lead Stack" <?php echo $lead_deactivate_button_hidden; ?>>
																<i class="fa fa-times"></i>
															</a>
														</td>												
														<td class="text-center">
															<a href="#" class="open-editstaff" data-staff_id="<?php echo $staff->id_user; ?>">
																<i class="fa fa-pencil-square-o" data-toggle="tooltip" data-placement="top" title="Edit Staff"></i>
															</a>
														</td>
														<td class="text-center">
															<a href="#" onClick="delete_staff(<?php echo $staff->id_user; ?>)">
																<i class="fa fa-trash-o" data-toggle="tooltip" data-placement="top" title="Delete Staff Permanently"></i>
															</a>
														</td>
														<?php
													}
													?>
													<td id="staff_status_<?php echo $staff->id_user; ?>"><?php echo $staff->status_text; ?></td>
													<td id="staff_leadstack_<?php echo $staff->id_user; ?>"><?php echo $staff->lead_stack_text; ?></td>
													<td id="staff_admin_type_<?php echo $staff->id_user; ?>"><?php echo $staff->admin_type_text; ?></td>
													<td id="staff_name_<?php echo $staff->id_user; ?>">
														<a href="<?php echo site_url('user/record/'.$staff->id_user); ?>" target="_blank">
															<?php echo $staff->name; ?>
														</a>
													</td>
													<td id="staff_email_<?php echo $staff->id_user; ?>">
														<a href="mailto:<?php echo $staff->username; ?>" target="_top"><?php echo $staff->username; ?></a>
													</td>
													<td id="staff_abn_<?php echo $staff->id_user; ?>"><?php echo $staff->abn; ?></td>
													<td id="staff_phone_<?php echo $staff->id_user; ?>"><?php echo $staff->phone; ?></td>
													<td id="staff_mobile_<?php echo $staff->id_user; ?>"><?php echo $staff->mobile; ?></td>
													<td id="staff_state_<?php echo $staff->id_user; ?>"><?php echo $staff->state; ?></td>
													<td id="staff_postcode_<?php echo $staff->id_user; ?>"><?php echo $staff->postcode; ?></td>
													<td id="staff_address_<?php echo $staff->id_user; ?>"><?php echo $staff->address; ?></td>
												</tr>											
												<?php
											}
											?>
										</tbody>
									</table>														
								<?php
								}
								?>
							</div>
							<?php echo $links; ?>
						</div>
					</section>
					<!-- end: page -->
					<?php include 'modals/ticket_modals.php'; ?>
					<div id="staff-modal" class="modal fade">
						<div class="modal-dialog" style="width: 95%;">
							<div class="panel-body">
								<div class="modal-wrapper">
									<div class="modal-text">
										<form method="post" action="" id="staff_main_form" name="staff_main_form">
											<input type="hidden" id="staff_id" name="staff_id" value="" />
											<div class="table-responsive">
												<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
													<tbody id="staff_details"></tbody>
												</table>
											</div>
										</form>
									</div>
								</div>
							</div>
							<footer class="panel-footer">
								<div class="row">
									<div class="col-md-12 text-right">
										<div id="staff_actions"></div>
									</div>
								</div>
							</footer>
						</div>
					</div>					
				</section>
			</div>
			<?php include 'template/right_sidebar.php'; ?>
		</section>
		<?php include 'template/scripts.php'; ?>
		<script>
			$(document).ready(function(){
				$(document).on("click", ".open-editstaff", function(data)
				{
					var staff_id = $(this).data("staff_id");
					$.post("<?php echo site_url("account/staff"); ?>/" + staff_id, function(data)
					{
						$(".full_loader").hide();
						$("#staff_id").val(data.id);
						$("#staff_details").html(data.details);
						$("#staff_actions").html(data.actions);
						$("#staff-modal").modal();
					}, "json");
				});
			});

			function activate_lead_stack (staff_id)
			{
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('account/activate_lead_stack'); ?>/" + staff_id,
					cache: false,
					success: function(result){
						$("#lead_stack_activate_button_"+staff_id).hide();
						$("#lead_stack_deactivate_button_"+staff_id).show();
						$("#staff_leadstack_"+staff_id).html("Activated");
					}
				});
			}

			function deactivate_lead_stack (staff_id)
			{
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('account/deactivate_lead_stack'); ?>/" + staff_id,
					cache: false,
					success: function(result){
						$("#lead_stack_activate_button_"+staff_id).show();
						$("#lead_stack_deactivate_button_"+staff_id).hide();
						$("#staff_leadstack_"+staff_id).html("Deactivated");
					}
				});
			}

			function activate_staff (staff_id)
			{
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('account/activate'); ?>/" + staff_id,
					cache: false,
					success: function(result){
						$("#activate_button_"+staff_id).hide();
						$("#deactivate_button_"+staff_id).show();
						$("#staff_status_"+staff_id).html("Activated");
					}
				});
			}

			function deactivate_staff (staff_id)
			{
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('account/deactivate'); ?>/" + staff_id,
					cache: false,
					success: function(result){
						$("#deactivate_button_"+staff_id).hide();
						$("#activate_button_"+staff_id).show();
						$("#staff_status_"+staff_id).html("Deactivated");
					}
				});
			}

			function delete_staff (staff_id)
			{
				if (confirm("Are you sure you want to delete this staff?")) 
				{				
					$.ajax({
						type: "POST",
						url: "<?php echo site_url('account/delete'); ?>/" + staff_id,
						cache: false,
						success: function(result){
							$("#staff_row_"+staff_id).remove();
						}
					});
				}
			}

			function save_staff_info ()
			{
				var staff_id = $("#staff_id").val();
				var abn = $("#staff_abn_in").val();
				var name = $("#staff_name_in").val();
				var state = $("#staff_state_in").val();
				var postcode = $("#staff_postcode_in").val();
				var address = $("#staff_address_in").val();
				var phone = $("#staff_phone_in").val();
				var mobile = $("#staff_mobile_in").val();

				$.ajax({
					type: "POST",
					url: "<?php echo site_url('account/update_staff_profile'); ?>",
					data: $("#staff_main_form").serialize(),
					cache: false,
					success: function(result){
						$("#staff_abn_"+staff_id).html(abn);
						$("#staff_name_"+staff_id).html(name);
						$("#staff_state_"+staff_id).html(state);
						$("#staff_postcode_"+staff_id).html(postcode);
						$("#staff_address_"+staff_id).html(address);
						$("#staff_phone_"+staff_id).html(phone);
						$("#staff_mobile_"+staff_id).html(mobile);
						$("#staff-modal").modal("hide");
					}
				});
			}			
		</script>
	</body>
</html>
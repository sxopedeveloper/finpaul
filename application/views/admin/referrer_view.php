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
						<form action="<?php echo site_url('account/referrers'); ?>" id="main_list_filter_form" class="form-horizontal form-bordered" method="get" accept-charset="utf-8">
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
							<?php /*?><footer class="panel-footer text-right">
								<button class="btn btn-primary" value="Search" name="submit">Apply Filters</button>
							</footer><?php */?>
						</form>
					</section>
					<section class="panel" id="tableData">
						<div class="panel-body">			
							<div class="table-responsive">
								<?php
								if (count($referrers)==0)
								{
									echo "<br /><center><i>No results found!</i></center><br />";
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
													<?php
												}
												?>
												<th>Status</th>																		
												<th>Name</th>
												<th>Email</th>
												<th>Phone</th>
												<th>Mobile</th>
												<th>State</th>												
												<th>Postcode</th>
												<th>Address</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach($referrers as $referrer)
											{
												?>
												<tr id="referrer_row_<?php echo $referrer->id_user; ?>">
													<?php
													if ($admin_type == 2)
													{
														?>
														<td class="text-center">
															<?php
															$deactivate_button_hidden = "";
															$activate_button_hidden = "";
															if ($referrer->status == 0) { $deactivate_button_hidden = " hidden"; }
															else { $activate_button_hidden = " hidden";	}
															?>													
															<a href="#" id="activate_button_<?php echo $referrer->id_user; ?>" onClick="activate_referrer(<?php echo $referrer->id_user; ?>)" data-toggle="tooltip" data-placement="top" title="Activate referrer" <?php echo $activate_button_hidden; ?>>
																<i class="fa fa-check"></i>
															</a>
															<a href="#" id="deactivate_button_<?php echo $referrer->id_user; ?>" onClick="deactivate_referrer(<?php echo $referrer->id_user; ?>)" data-toggle="tooltip" data-placement="top" title="Deactivate referrer" <?php echo $deactivate_button_hidden; ?>>
																<i class="fa fa-times"></i>
															</a>
														</td>														
														<td class="text-center">
															<a href="#" class="open-editreferrer" data-referrer_id="<?php echo $referrer->id_user; ?>">
																<i class="fa fa-pencil-square-o" data-toggle="tooltip" data-placement="top" title="Edit referrer"></i>
															</a>
														</td>
														<td class="text-center">
															<a href="#" onClick="delete_referrer(<?php echo $referrer->id_user; ?>)">
																<i class="fa fa-trash-o" data-toggle="tooltip" data-placement="top" title="Delete referrer Permanently"></i>
															</a>
														</td>
														<?php
													}
													?>
													<td id="referrer_status_<?php echo $referrer->id_user; ?>"><?php echo $referrer->status_text; ?></td>
													<td id="referrer_name_<?php echo $referrer->id_user; ?>"><?php echo $referrer->name; ?></td>
													<td id="referrer_email_<?php echo $referrer->id_user; ?>">
														<a href="mailto:<?php echo $referrer->username; ?>" target="_top"><?php echo $referrer->username; ?></a>
													</td>
													<td id="referrer_phone_<?php echo $referrer->id_user; ?>"><?php echo $referrer->phone; ?></td>
													<td id="referrer_mobile_<?php echo $referrer->id_user; ?>"><?php echo $referrer->mobile; ?></td>
													<td id="referrer_state_<?php echo $referrer->id_user; ?>"><?php echo $referrer->state; ?></td>
													<td id="referrer_postcode_<?php echo $referrer->id_user; ?>"><?php echo $referrer->postcode; ?></td>
													<td id="referrer_address_<?php echo $referrer->id_user; ?>"><?php echo $referrer->address; ?></td>
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
					<?php include 'modals/ticket_modals.php'; ?>
					<div id="referrer-modal" class="modal fade">
						<div class="modal-dialog" style="width: 95%;">
							<div class="panel-body">
								<div class="modal-wrapper">
									<div class="modal-text">
										<form method="post" action="" id="referrer_main_form" name="referrer_main_form">
											<input type="hidden" id="referrer_id" name="referrer_id" value="" />
											<div class="table-responsive">
												<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
													<tbody id="referrer_details"></tbody>
												</table>
											</div>
										</form>
									</div>
								</div>
							</div>
							<footer class="panel-footer">
								<div class="row">
									<div class="col-md-12 text-right">
										<div id="referrer_actions"></div>
									</div>
								</div>
							</footer>
						</div>
					</div>		
					<!-- end: page -->
					<?php include 'modals/ticket_modals.php'; ?>
				</section>
			</div>
			<?php include 'template/right_sidebar.php'; ?>
		</section>
		<?php include 'template/scripts.php'; ?>
		<script>

			$(document).ready(function(){
				$(document).on("click", ".datepicker_referrer", function () {
					$(this).toggleClass("clicked").datepicker("setDate", new Date()).datepicker("show");
					$(this).datepicker("update");
				});
			});
		
			function activate_referrer (referrer_id)
			{
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('account/activate'); ?>/" + referrer_id,
					cache: false,
					success: function(result){
						$("#activate_button_"+referrer_id).hide();
						$("#deactivate_button_"+referrer_id).show();
						$("#referrer_status_"+referrer_id).html("Activated");
					}
				});
			}

			function deactivate_referrer (referrer_id)
			{
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('account/deactivate'); ?>/" + referrer_id,
					cache: false,
					success: function(result){
						$("#deactivate_button_"+referrer_id).hide();
						$("#activate_button_"+referrer_id).show();
						$("#referrer_status_"+referrer_id).html("Deactivated");
					}
				});
			}

			function delete_referrer (referrer_id)
			{
				if (confirm("Are you sure you want to delete this wholesaler?")) 
				{				
					$.ajax({
						type: "POST",
						url: "<?php echo site_url('account/delete'); ?>/" + referrer_id,
						cache: false,
						success: function(result){
							$("#referrer_row_"+referrer_id).remove();
						}
					});
				}
			}
			
			$(document).on("click", ".open-editreferrer", function(data){
				var referrer_id = $(this).data("referrer_id");
				$.post("<?php echo site_url("account/referrer"); ?>/" + referrer_id, function(data)
				{
					$(".full_loader").hide();
					$("#referrer_id").val(data.id);
					$("#referrer_details").html(data.details);
					$("#referrer_actions").html(data.actions);
					$("#referrer-modal").modal();
				}, "json");
			});
			
			function save_referrer_info ()
			{
				var referrer_id = $("#referrer_id").val();
				var name = $("#referrer_name_in").val();
				var state = $("#referrer_state_in").val();
				var postcode = $("#referrer_postcode_in").val();
				var address = $("#referrer_address_in").val();
				var phone = $("#referrer_phone_in").val();
				var mobile = $("#referrer_mobile_in").val();
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('account/update_referrer_profile'); ?>",
					data: $("#referrer_main_form").serialize(),
					cache: false,
					success: function(result){
						$("#referrer-modal").modal("hide");
						$("#referrer_name_"+referrer_id).html(name);
						$("#referrer_state_"+referrer_id).html(state);
						$("#referrer_postcode_"+referrer_id).html(postcode);
						$("#referrer_address_"+referrer_id).html(address);
						$("#referrer_phone_"+referrer_id).html(phone);
						$("#referrer_mobile_"+referrer_id).html(mobile);						
					}
				});
			}			
		</script>
	</body>
</html>
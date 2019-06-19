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
						<form action="<?php echo site_url('account/wholesalers'); ?>" id="main_list_filter_form" class="form-horizontal form-bordered" method="get" accept-charset="utf-8">
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
									<div class="col-md-4">
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
							
						</form>
					</section>
					<section class="panel" id="main_list_filter_form">
						<?php /*?><header class="panel-heading">
							<div class="panel-actions">
								<a href="#" class="fa fa-caret-down"></a>
							</div>
							<h2 class="panel-title">
								<span class="label label-primary label-sm text-normal va-middle mr-sm"><?php echo $user_invite_count; ?></span>
								<span class="va-middle">Wholesaler Invitations</span>
							</h2>
						</header>	<?php */?>				
						<div class="panel-body" id="tableData">	
							<h5><b> Wholesaler Invitations</b></h5>		
							<div class="table-responsive">
								<?php
								if (count($user_invites)==0)
								{
									echo "<br /><center><i>No results found!</i></center><br />";
								}
								else
								{
									?>
									<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
										<thead>
											<tr>
												<th>Status</th>
												<th>Email</th>
												<th>Date Sent</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach($user_invites as $user_invite)
											{
												?>
												<tr id="user_invite_row_<?php echo $user_invite->id_user_invite; ?>">
													<td id="user_invite_status_<?php echo $user_invite->id_user_invite; ?>">
														<?php echo $user_invite->status_text; ?>
													</td>
													<td id="user_invite_email_<?php echo $user_invite->id_user_invite; ?>">
														<a href="mailto:<?php echo $user_invite->email; ?>" target="_top"><?php echo $user_invite->email; ?></a>
													</td>
													<td id="user_invite_created_at_<?php echo $user_invite->id_user_invite; ?>">
														<?php echo $user_invite->created_at; ?>
													</td>
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
						</div>
						<footer class="panel--footer text-right col-sm-2 pull-right">
							<button class="btn btn-primary open-user-invite-modal search-filter-btn  col-md-12 col-sm-12 col-xs-12" value="Invite Wholesaler"><i class="fa fa-plus"></i> Invite Wholesaler</button>
						</footer>	
						<div style="clear:both"></div>					
					</section>										
					<section class="panel" id="tableData">
						<div class="panel-body">			
							<div class="table-responsive">
								<?php
								if (count($wholesalers)==0)
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
											foreach($wholesalers as $wholesaler)
											{
												?>
												<tr id="wholesaler_row_<?php echo $wholesaler->id_user; ?>">
													<?php
													if ($admin_type == 2)
													{
														?>
														<td class="text-center">
															<?php
															$deactivate_button_hidden = "";
															$activate_button_hidden = "";
															if ($wholesaler->status == 0) { $deactivate_button_hidden = " hidden"; }
															else { $activate_button_hidden = " hidden";	}
															?>													
															<a href="#" id="activate_button_<?php echo $wholesaler->id_user; ?>" onClick="activate_wholesaler(<?php echo $wholesaler->id_user; ?>)" data-toggle="tooltip" data-placement="top" title="Activate wholesaler" <?php echo $activate_button_hidden; ?>>
																<i class="fa fa-check"></i>
															</a>
															<a href="#" id="deactivate_button_<?php echo $wholesaler->id_user; ?>" onClick="deactivate_wholesaler(<?php echo $wholesaler->id_user; ?>)" data-toggle="tooltip" data-placement="top" title="Deactivate wholesaler" <?php echo $deactivate_button_hidden; ?>>
																<i class="fa fa-times"></i>
															</a>
														</td>														
														<td class="text-center">
															<a href="#" class="open-edit-wholesaler" data-wholesaler_id="<?php echo $wholesaler->id_user; ?>">
																<i class="fa fa-pencil-square-o" data-toggle="tooltip" data-placement="top" title="Edit wholesaler"></i>
															</a>
														</td>
														<td class="text-center">
															<a href="#" onClick="delete_wholesaler(<?php echo $wholesaler->id_user; ?>)">
																<i class="fa fa-trash-o" data-toggle="tooltip" data-placement="top" title="Delete wholesaler Permanently"></i>
															</a>
														</td>
														<?php
													}
													?>
													<td id="wholesaler_status_<?php echo $wholesaler->id_user; ?>"><?php echo $wholesaler->status_text; ?></td>
													<td id="wholesaler_name_<?php echo $wholesaler->id_user; ?>">
														<a href="<?php echo site_url('user/record/'.$wholesaler->id_user); ?>" target="_blank">
															<?php echo $wholesaler->name; ?>
														</a>
													</td>
													<td id="wholesaler_email_<?php echo $wholesaler->id_user; ?>">
														<a href="mailto:<?php echo $wholesaler->username; ?>" target="_top"><?php echo $wholesaler->username; ?></a>
													</td>
													<td id="wholesaler_abn_<?php echo $wholesaler->id_user; ?>"><?php echo $wholesaler->abn; ?></td>
													<td id="wholesaler_phone_<?php echo $wholesaler->id_user; ?>"><?php echo $wholesaler->phone; ?></td>
													<td id="wholesaler_mobile_<?php echo $wholesaler->id_user; ?>"><?php echo $wholesaler->mobile; ?></td>
													<td id="wholesaler_state_<?php echo $wholesaler->id_user; ?>"><?php echo $wholesaler->state; ?></td>
													<td id="wholesaler_postcode_<?php echo $wholesaler->id_user; ?>"><?php echo $wholesaler->postcode; ?></td>
													<td id="wholesaler_address_<?php echo $wholesaler->id_user; ?>"><?php echo $wholesaler->address; ?></td>
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
					<!-- Wholesaler Modal (Start) -->
					<div id="wholesaler-modal" class="modal fade">
						<div class="modal-dialog" style="width: 95%;">
							<div class="panel-body">
								<div class="modal-wrapper">
									<div class="modal-text">
										<form method="post" action="" id="wholesaler_main_form" name="wholesaler_main_form">
											<input type="hidden" id="wholesaler_id" name="wholesaler_id" value="" />
											<div class="table-responsive">
												<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
													<tbody id="wholesaler_details"></tbody>
												</table>
											</div>
										</form>
									</div>
								</div>
							</div>
							<footer class="panel-footer">
								<div class="row">
									<div class="col-md-12 text-right">
										<div id="wholesaler_actions"></div>
									</div>
								</div>
							</footer>
						</div>
					</div>
					<!-- Wholesaler Modal (End) -->					
					<!-- Email Invite Modal (Start) -->
					<div id="user-invite-modal" class="modal fade">
						<div class="modal-dialog" style="width: 50%;">
							<section class="panel">
								<header class="panel-heading">
									<h2 class="panel-title">Send Email Invitation</h2>
								</header>
								<div class="panel-body">
									<div class="modal-wrapper">
										<div class="modal-text">
											<div class="deal_agreement">
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label><h5>Email Address:</h5></label>
															<input value="" class="form-control" id="email_invite_input" name="email" />
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<footer class="panel-footer">
									<div class="row">
										<div class="col-md-12 text-right">
											<button type="button" class="btn btn-primary" onClick="send_email_invite()">Send</button>
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										</div>
									</div>
								</footer>
							</section>
						</div>
					</div>		
					<!-- /.Email Invite Modal (End) -->
				</section>
			</div>
			<?php include 'template/right_sidebar.php'; ?>
		</section>
		<?php include 'template/scripts.php'; ?>
		<script>
			$(document).ready(function(){
				$(document).on("click", ".datepicker_wholesaler", function () {
					$(this).toggleClass("clicked").datepicker("setDate", new Date()).datepicker("show");
					$(this).datepicker("update");
				});
			});

			$(document).on("click", ".open-edit-wholesaler", function(data){
				var wholesaler_id = $(this).data("wholesaler_id");
				$.post("<?php echo site_url("account/wholesaler"); ?>/" + wholesaler_id, function(data)
				{
					$(".full_loader").hide();
					$("#wholesaler_id").val(data.id);
					$("#wholesaler_details").html(data.details);
					$("#wholesaler_actions").html(data.actions);
					$("#wholesaler-modal").modal();
				}, "json");
			});
			
			$(document).on("click", ".open-user-invite-modal", function(data){
				$("#user-invite-modal").modal();
			});
			
			function send_email_invite ()
			{
				var email = $("#user-invite-modal").find("#email_invite_input").val();
				
				var data = {
					email: email
				}

				$.ajax({
					type: "POST",
					url: "<?php echo site_url('account/send_user_invite'); ?>/3",
					data: data,
					cache: false,
					datType: 'json',
					success: function(result){
						alert (result);
						$("#user-invite-modal").find("#email_invite_input").val("");
						$("#user-invite-modal").modal("hide");
					}
				});
			}

			function save_wholesaler_info ()
			{
				var wholesaler_id = $("#wholesaler_id").val();
				var abn = $("#wholesaler_abn_in").val();
				var name = $("#wholesaler_name_in").val();
				var state = $("#wholesaler_state_in").val();
				var postcode = $("#wholesaler_postcode_in").val();
				var address = $("#wholesaler_address_in").val();
				var phone = $("#wholesaler_phone_in").val();
				var mobile = $("#wholesaler_mobile_in").val();
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('account/update_wholesaler_profile'); ?>",
					data: $("#wholesaler_main_form").serialize(),
					cache: false,
					success: function(result){
						$("#wholesaler_abn_"+wholesaler_id).html(abn);
						$("#wholesaler_name_"+wholesaler_id).html(name);
						$("#wholesaler_state_"+wholesaler_id).html(state);
						$("#wholesaler_postcode_"+wholesaler_id).html(postcode);
						$("#wholesaler_address_"+wholesaler_id).html(address);
						$("#wholesaler_phone_"+wholesaler_id).html(phone);
						$("#wholesaler_mobile_"+wholesaler_id).html(mobile);
						$("#wholesaler-modal").modal("hide");
					}
				});
			}

			function activate_wholesaler (wholesaler_id)
			{
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('account/activate'); ?>/" + wholesaler_id,
					cache: false,
					success: function(result){
						$("#activate_button_"+wholesaler_id).hide();
						$("#deactivate_button_"+wholesaler_id).show();
						$("#wholesaler_status_"+wholesaler_id).html("Activated");
					}
				});
			}

			function deactivate_wholesaler (wholesaler_id)
			{
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('account/deactivate'); ?>/" + wholesaler_id,
					cache: false,
					success: function(result){
						$("#deactivate_button_"+wholesaler_id).hide();
						$("#activate_button_"+wholesaler_id).show();
						$("#wholesaler_status_"+wholesaler_id).html("Deactivated");
					}
				});
			}

			function delete_wholesaler (wholesaler_id)
			{
				if (confirm("Are you sure you want to delete this wholesaler?")) 
				{				
					$.ajax({
						type: "POST",
						url: "<?php echo site_url('account/delete'); ?>/" + wholesaler_id,
						cache: false,
						success: function(result){
							$("#wholesaler_row_"+wholesaler_id).remove();
						}
					});
				}
			}			
		</script>
	</body>
</html>
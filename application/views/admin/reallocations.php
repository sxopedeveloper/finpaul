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
						<header class="panel-heading">
							<div class="panel-actions">
								<a href="#" class="fa fa-caret-down"></a>
								<a href="#" class="fa fa-times"></a>
							</div>
							<h2 class="panel-title">Lead Reallocations</h2>
						</header>
						<div class="panel-body">
							<form action="<?php echo site_url('lead/reallocations'); ?>" method="get" accept-charset="utf-8">
								<div class="row">										
									<div class="form-group">
										<?php
										$name = isset($_GET['name']) ? $_GET['name'] : '';
										$email = isset($_GET['email']) ? $_GET['email'] : '';
										$phone = isset($_GET['phone']) ? $_GET['phone'] : '';
										$state = isset($_GET['state']) ? $_GET['state'] : '';
										
										$r_status = isset($_GET['r_status']) ? $_GET['r_status'] : '';
										$l_status = isset($_GET['l_status']) ? $_GET['l_status'] : '';
										?>
										<div class="col-md-4 text-left">
											<input type="text" class="form-control input-md" name="name" id="name_tb" title="Client Name" placeholder="Client Name" value="<?php echo $name;?>"><br />
										</div>
										<div class="col-md-4 text-left">
											<input type="text" class="form-control input-md" name="email" id="email_tb" title="Client Email Address" placeholder="Client Email Address" value="<?php echo $email;?>"><br />
										</div>
										<div class="col-md-4 text-left">
											<input type="text" class="form-control input-md" name="phone" id="phone_tb" title="Client Phone" placeholder="Client Phone" value="<?php echo $phone;?>"><br />
										</div>												
										
										<?php
										$selected_state_ACT = ""; if ($state == 'ACT') { $selected_state_ACT = " selected"; }
										$selected_state_NSW = ""; if ($state == 'NSW') { $selected_state_NSW = " selected"; }
										$selected_state_NT = ""; if ($state == 'NT') { $selected_state_NT = " selected"; }
										$selected_state_QLD = ""; if ($state == 'QLD') { $selected_state_QLD = " selected"; }
										$selected_state_SA = ""; if ($state == 'SA') { $selected_state_SA = " selected"; }
										$selected_state_TAS = ""; if ($state == 'TAS') { $selected_state_TAS = " selected"; }
										$selected_state_VIC = ""; if ($state == 'VIC') { $selected_state_VIC = " selected"; }
										$selected_state_WA = ""; if ($state == 'WA') { $selected_state_WA = " selected"; }

										$selected_r_status_0 = ""; if ($r_status == "0") { $selected_r_status_0 = " selected"; }
										$selected_r_status_1 = ""; if ($r_status == "1") { $selected_r_status_1 = " selected"; }
										
										$selected_l_status_0 = ""; if ($l_status == "0") { $selected_l_status_0 = " selected"; }
										$selected_l_status_1 = ""; if ($l_status == "1") { $selected_l_status_1 = " selected"; }
										$selected_l_status_2 = ""; if ($l_status == "2") { $selected_l_status_2 = " selected"; }
										$selected_l_status_99 = ""; if ($l_status == "99") { $selected_l_status_99 = " selected"; }
										$selected_l_status_3 = ""; if ($l_status == "3") { $selected_l_status_3 = " selected"; }
										$selected_l_status_4 = ""; if ($l_status == "4") { $selected_l_status_4 = " selected"; }
										$selected_l_status_5 = ""; if ($l_status == "5") { $selected_l_status_5 = " selected"; }
										$selected_l_status_6 = ""; if ($l_status == "6") { $selected_l_status_6 = " selected"; }
										$selected_l_status_7 = ""; if ($l_status == "7") { $selected_l_status_7 = " selected"; }
										$selected_l_status_100 = ""; if ($l_status == "100") { $selected_l_status_100 = " selected"; }									
										?>
										<div class="col-md-4 text-left">
											<select class="form-control input-md" id="l_status_dropdown" name="l_status" title="Lead Status">
												<option name="l_status" value="">-Lead Status-</option>
												<option name="l_status" value="0" <?php echo $selected_l_status_0; ?>>Unallocated</option>
												<option name="l_status" value="1" <?php echo $selected_l_status_1; ?>>Allocated</option>
												<option name="l_status" value="2" <?php echo $selected_l_status_2; ?>>Attempted</option>
												<option name="l_status" value="99" <?php echo $selected_l_status_99; ?>>Reallocated</option>
												<option name="l_status" value="3" <?php echo $selected_l_status_3; ?>>Tendering</option>
												<option name="l_status" value="4" <?php echo $selected_l_status_4; ?>>Sold</option>
												<option name="l_status" value="5" <?php echo $selected_l_status_5; ?>>Delivery Pending</option>
												<option name="l_status" value="6" <?php echo $selected_l_status_6; ?>>Delivered</option>
												<option name="l_status" value="7" <?php echo $selected_l_status_7; ?>>Settled</option>
												<option name="l_status" value="100" <?php echo $selected_l_status_100; ?>>Deleted</option>
											</select>												
										</div>
										<div class="col-md-4 text-left">
											<select class="form-control input-md" id="r_status_dropdown" name="r_status" title="Reallocation Status">
												<option name="r_status" value="">-Reallocation Status-</option>
												<option name="r_status" value="0" <?php echo $selected_r_status_0; ?>>Pending</option>
												<option name="r_status" value="1" <?php echo $selected_r_status_1; ?>>Approved</option>
											</select>												
										</div>
										<div class="col-md-4 text-left">											
											<select class="form-control input-md" name="state" id="state_dropdown" title="State">
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
										<div class="col-md-12 text-right">
											<br />
											<input value="Apply Filters" name="submit" class="btn btn-primary" type="submit">
											<button type="button" class="btn btn-primary" onclick="get_selected_leads()">Approve</button>
										</div>								
									</div>
								</div>
							</div>
						</form>
					</section>
					<section class="panel">
						<div class="panel-body">
							<div class="table-responsive">
								<?php
								if (count($reallocations)==0)
								{
									echo "<center><i>No results found!</i></center>";
								}
								else
								{
								?>
									<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
										<thead>
											<tr>
												<td><input type="checkbox" id="checkAll"/></td>
												<td><b>CQ Number</b></td>
												<td><b>Lead Status</b></td>
												<td><b>Reallocation Status</b></td>
												<td><b>Lead From</b></td>
												<td><b>Lead To</b></td>
												<td><b>Approved By</b></td>
												<td><b>Client Name</b></td>
												<td><b>Email</b></td>
												<td><b>Phone / Mobile</b></td>
												<td><b>State</b></td>
												<td><b>Make</b></td>
												<td><b>Model</b></td>
												<td><b>Date</b></td>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach ($reallocations as $reallocation)
											{
												if ($reallocation->lead_status == 0) { $l_css = 'style="color: #57DC75"'; }
												else if ($reallocation->lead_status == 1){ $l_css = 'style="color: #3c94d6"'; }
												else if ($reallocation->lead_status == 2){ $l_css = 'style="color: #cc3333"'; }
												else if ($reallocation->lead_status == 3){ $l_css = 'style="color: #6600cc"'; }
												else if ($reallocation->lead_status == 4){ $l_css = 'style="color: #9933cc"'; }
												else if ($reallocation->lead_status == 5){ $l_css = 'style="color: #cc00cc"'; }
												else if ($reallocation->lead_status == 6){ $l_css = 'style="color: #ff6633"'; }
												else if ($reallocation->lead_status == 7){ $l_css = 'style="color: #009900"'; }
												else if ($reallocation->lead_status == 99){ $l_css = 'style="color: #222222"'; }
												else if ($reallocation->lead_status == 100){ $l_css = 'style="color: #CCCCCC"'; }
												else { $l_css = ''; }
												
												if ($reallocation->reallocation_status == 0) { $r_css = 'style="color: #3c94d6"'; }
												else if ($reallocation->reallocation_status == 1){ $r_css = 'style="color: #57DC75"'; }
												else { $r_css = ''; }
												?>
												<tr>
													<td>
														<?php
														if ($user_id == $reallocation->lead_to_id)
														{
															?>
															<input type="checkbox" value="<?php echo $reallocation->id_lead_reallocation; ?>">
															<?php
														}	
														?>
													</td>
													<td><?php echo $reallocation->cq_number; ?></td>
													<td <?php echo $l_css; ?>><?php echo $reallocation->lead_status_text; ?></td>
													<td id="r_td_<?php echo $reallocation->id_lead_reallocation; ?>" <?php echo $r_css; ?>>
														<?php echo $reallocation->reallocation_status_text; ?>
													</td>
													<td><?php echo $reallocation->lead_from; ?></td>
													<td><?php echo $reallocation->lead_to; ?></td>
													<td><?php echo $reallocation->lead_approver; ?></td>
													<td><?php echo $reallocation->name; ?></td>
													<td><?php echo $reallocation->email; ?></td>
													<td><?php echo $reallocation->mobile; ?></td>
													<td><?php echo $reallocation->state; ?></td>
													<td><?php echo $reallocation->make; ?></td>
													<td><?php echo $reallocation->model; ?></td>
													<td><?php echo $reallocation->r_created_at; ?></td>
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
					<!-- Title Modal (Start)-->
					<div id="title-modal" class="modal fade">
						<div class="modal-dialog" style="width: 80%;">
							<section class="panel">
								<header class="panel-heading">
									<h2 class="panel-title"></h2>
								</header>
								<div class="panel-body">
									<div class="modal-wrapper">
										<div class="modal-text">
											<div class="title">CONTENT</div>
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
					<!-- Title Modal (End) -->					
				</section>
			</div>
			<?php include 'template/right_sidebar.php'; ?>
		</section>
		<?php include 'template/scripts.php'; ?>
		<script>
			function get_selected_leads ()
			{
				var checkbox_values = [];
				$('input[type="checkbox"]:checked').each(function(index, elem){
					checkbox_values.push($(elem).val());
				});
				
				var reallocation_ids = checkbox_values.join(',');
				var reallocation_id_arr = reallocation_ids.split(',');
				var reallocation_count = reallocation_id_arr.length;				

				var dataString = '&reallocation_ids='+reallocation_ids;

				$("#reallocation_loader").show();
				$("#reallocation_loader").fadeIn(400).html('Sending...');
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('lead/approve_reallocation'); ?>",
					data: dataString,
					cache: false,
					success: function(result){
						$("#reallocation_loader").hide();
						var reallocation_index = 0;
						while (reallocation_index < reallocation_count) 
						{
							$("#r_td_"+reallocation_id_arr[reallocation_index]).html("Approved");
							$("#r_td_"+reallocation_id_arr[reallocation_index]).css({"color": "#57DC75"});
							$("input:checkbox").removeAttr("checked");
							reallocation_index++;
						}
						alert ('Success! Reallocations were approved.');
					}
				});				
			}

			$("#checkAll").change(function(){
				$("input:checkbox").prop("checked", $(this).prop("checked"));
			});	
		</script>		
	</body>
</html>
<?php include 'template/head.php'; ?>
<?php 
	$now = date("Y-m-d");
	$time_now = date("H:i:s");
	$day_now = date('l');
	$sched_flag = null;
	$weekend_array = ['Sunday', 'Saturday'];
	if ($time_now >= "09:00:00" && $time_now <= "17:00:00")
	{
		if (in_array($day_now, $weekend_array))
		{
			$sched_flag = FALSE;
		}
		else
		{
			$sched_flag = TRUE;
		}
	}
	else
	{
		$sched_flag = FALSE;
	}
?>
	<body>
		<section class="body">
			<?php include 'template/header.php'; ?>
			<div class="inner-wrapper">
				<?php include 'template/left_sidebar.php'; ?>
				<section role="main" class="content-body">
					<?php include 'template/header_2.php'; ?>
					<!-- start: page -->
					<div class="row">
						<div class="col-md-8">
							<?php 
							if ($sched_flag)
							{
								?>
								<section class="panel panel-featured-left panel-featured-primary">
									<div class="panel-body">
										<div class="widget-summary" style="padding: 3px 20px 3px 20px;">
											<div class="row">
												<?php
												if ($lead_count == 0)
												{
													?>
													<br /><br /><br /><br />
													<center>No more leads to work on at the moment!</center>
													<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
													<?php
												}
												else
												{
													$actions_btn_disabled = "";
													if ($lead['status']==100)
													{
														$actions_btn_disabled = " disabled";
													}
													?>
													<div class="col-md-5" style="border: 1px solid #ddd; border-radius: 5px;">
														<img src="http://www.myelquoto.com.au/global_images/makes/<?php echo strtolower($lead['image_url']); ?>" width="100%" />
													</div>
													<div class="col-md-7">
														<div class="summary">											
															<h4 class="title" style="margin-top: 8px;"><?php echo $lead['make']; ?></h4>
															<div class="info">
																<strong class="amount"><?php echo strtoupper($lead['name']); ?></strong>
																<span id="lead_main_name" style="display: none;"><?php echo $lead['name']; ?></span>
																<span id="lead_main_cq_number" style="display: none;"><?php echo $lead['cq_number']; ?></span>
																<br />
																<?php
																if ($lead['attempt_flag']==1)
																{
																	$status_text = strtoupper($lead['status_text']);
																}
																else
																{
																	$status_text = "Unallocated";
																}

																$tender_btn_disabled = "";
																if ($lead['status']==3)
																{
																	$status_text = "Tendering";
																	$actions_btn_disabled = " disabled";
																}
																?>
																<span class="highlight" id="lead_status_text"><?php echo $status_text; ?></span>
																<br />
																<br />
																<i class="fa fa-map-marker"></i>&nbsp;&nbsp;&nbsp;&nbsp; 
																	<span id="lead_main_postcode"><?php echo $lead['postcode']; ?></span>
																	<span id="lead_main_state"><?php echo $lead['state']; ?></span>
																<br />
																<i class="fa fa-envelope"></i>&nbsp;&nbsp; 
																	<a href="mailto:<?php echo $lead['email']; ?>">
																		<span id="lead_main_email"><?php echo $lead['email']; ?></span>
																	</a>
																<br />
																<i class="fa fa-phone"></i>&nbsp;&nbsp;&nbsp; <?php echo $lead['phone']; ?>
																<br />
																<i class="fa fa-mobile"></i>&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $lead['mobile']; ?>
																<br />
																<br />
															</div>
														</div>
														<div class="summary-footer" style="padding: 15px 0 0; margin-top: 7px;"></div>
													</div>
													<div class="col-md-12 text-right">
														<button type="button" id="not_proceeding_btn" class="mb-xs mt-xs mr-xs btn btn-danger" onclick="delete_lead(<?php echo $lead['id_lead']; ?>)" <?php echo $actions_btn_disabled; ?>>
															Not Proceeding
														</button>											
														<button type="button" id="no_answer_btn" class="mb-xs mt-xs mr-xs btn btn-primary" onclick="send_email(<?php echo $lead['id_lead'].", ".$lead['status']; ?>, 2)" <?php echo $actions_btn_disabled; ?>>
															No Answer
														</button>
														<button type="button" id="wrong_number_btn" class="mb-xs mt-xs mr-xs btn btn-primary" onclick="send_email(<?php echo $lead['id_lead'].", ".$lead['status']; ?>, 3)" <?php echo $actions_btn_disabled; ?>>
															Wrong Number
														</button>
														<button type="button" id="call_back_btn" class="mb-xs mt-xs mr-xs btn btn-primary" onclick="call_back_modal(<?php echo $lead['id_lead']; ?>)" <?php echo $actions_btn_disabled; ?>>
															Call Back
														</button>												
														<button type="button" id="start_tender_btn" class="mb-xs mt-xs mr-xs btn btn-success open-starttender" data-lead_id="<?php echo $lead['id_lead']; ?>" <?php echo $actions_btn_disabled; ?>>
															Start Tender
														</button>
														<?php
														$next_btn_disabled = "";
														if ($lead['attempt_flag']==0 AND $lead['status']<>3)
														{
															$next_btn_disabled = ' disabled';
														}
														?>
														<a class="mb-xs mt-xs mr-xs btn btn-default" id="next_lead_btn" href="<?php echo site_url('lead/next_record/'.$lead['id_lead']); ?>" <?php echo $next_btn_disabled; ?>>
															Next &nbsp;<i class="fa fa-arrow-right"></i>
														</a>
													</div>												
													<?php
												}
												?>
											</div>									
										</div>
									</div>
								</section>
								<?php 
							}
							else
							{
								?>
								<section class="panel panel-featured-left panel-featured-primary">
									<div class="panel-body">
										<div class="row">
											<div class="col-md-12">
												<center>
													<img src="<?= base_url('assets/img/close_icon.png'); ?>" class="img-responsive" alt="Responsive image"><br />
													The Leads Stack is not available at the moment.<br />
													Schedule: Monday to Friday (9 AM to 5 PM)
												</center>
											</div>
										</div>
										<br />
									</div>
								</section>
								<?php 
							}
							?>
						</div>
						<div class="col-md-4">
							<section class="panel">
								<div class="panel-body">
									<h4 style="margin-bottom: 19px; margin-top: 0px;">Assigned Leads: <?php echo $assigned_count; ?></h4>
									<ul>
										<li>
											<span class="stats-title">Not Proceeding</span>
											<span class="stats-complete">(<?php echo $deleted_count; ?>)</span>
											<div class="progress">
												<div class="progress-bar progress-bar-primary progress-without-number" role="progressbar" aria-valuenow="<?php echo $deleted_percent; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $deleted_percent; ?>%;">
													<span class="sr-only"><?php echo $deleted_percent; ?>%</span>
												</div>
											</div>
										</li>
										<li>
											<span class="stats-title">No Answer</span>
											<span class="stats-complete">(<?php echo $no_answer_count; ?>)</span>
											<div class="progress">
												<div class="progress-bar progress-bar-primary progress-without-number" role="progressbar" aria-valuenow="<?php echo $no_answer_percent; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $no_answer_percent; ?>%;">
													<span class="sr-only"><?php echo $no_answer_percent; ?>%</span>
												</div>
											</div>
										</li>
										<li>
											<span class="stats-title">Wrong Number</span>
											<span class="stats-complete">(<?php echo $wrong_number_count; ?>)</span>
											<div class="progress">
												<div class="progress-bar progress-bar-primary progress-without-number" role="progressbar" aria-valuenow="<?php echo $wrong_number_percent; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $wrong_number_percent; ?>%;">
													<span class="sr-only"><?php echo $wrong_number_percent; ?>%</span>
												</div>
											</div>
										</li>
										<li>
											<span class="stats-title">Call Back</span>
											<span class="stats-complete">(<?php echo $call_back_count; ?>)</span>
											<div class="progress">
												<div class="progress-bar progress-bar-primary progress-without-number" role="progressbar" aria-valuenow="<?php echo $call_back_percent; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $call_back_percent; ?>%;">
													<span class="sr-only"><?php echo $call_back_percent; ?>%</span>
												</div>
											</div>
										</li>
										<li>
											<span class="stats-title">Tender</span>
											<span class="stats-complete">(<?php echo $tender_count; ?>)</span>
											<div class="progress">
												<div class="progress-bar progress-bar-primary progress-without-number" role="progressbar" aria-valuenow="<?php echo $tender_percent; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $tender_percent; ?>%;">
													<span class="sr-only"><?php echo $tender_percent; ?>%</span>
												</div>
											</div>
										</li>										
									</ul>
								</div>
							</section>
						</div>
					</div>
					<div class="row">				
						<div class="col-md-12">
							<section class="panel">
								<header class="panel-heading">
									<h2 class="panel-title">CALL BACKS</h2>
								</header>							
								<div class="panel-body">
									<div style="border: 1px solid #eeeeee; padding: 15px 15px 15px 15px; border-radius: 5px; background: #f5f5f5;">
										<form action="<?php echo site_url('lead/main'); ?>" method="get" accept-charset="utf-8">
											<div class="row">
												<div class="col-md-5">
													<input class="form-control input-md datepicker" id="start_date" name="start_date" data-date-format="yyyy-mm-dd" value="<?php echo $start_date; ?>">
												</div>
												<div class="col-md-5">
													<input class="form-control input-md datepicker" id="end_date" name="end_date" data-date-format="yyyy-mm-dd" value="<?php echo $end_date; ?>">
												</div>
												<div class="col-md-2">
													<input value="Apply Filters" name="submit" class="btn btn-primary btn-block" type="submit">
												</div>
											</div>										
										</form>
									</div>
									<div class="col-md-12">
										<br />
										<table class="table table-bordered table-striped mb-none" style="white-space: nowrap;" id="datatable_1">
											<thead>
												<tr>
													<th></td>
													<th></td>
													<th>DATE</th>
													<th>TIME</th>
													<th>NOTE</th>
													<th>NAME</th>
													<th>PHONE</th>
													<th>MAKE</th>
													<th>MODEL</th>
													<th>LOCATION</th>
												</tr>
											</thead>
											<tbody>
												<?php
												foreach ($lead_call_backs as $lead_call_back)
												{
													?>
													<tr id="lead_main_row_<?php echo $lead_call_back['id_lead']; ?>">
														<td>
															<center>
																<span class="open-lead-details" data-lead_id="<?php echo $lead_call_back['id_lead']; ?>" style="cursor: pointer; cursor: hand; color: #58c603;"><i class="fa fa-pencil-square-o" data-toggle="tooltip" data-placement="top" data-original-title="View Details"></i></span>
															</center>
														</td>
														<td>
															<center>
																<span class="edit-callback" data-lead_id="<?php echo $lead_call_back['id_lead']; ?>" style="cursor: pointer; cursor: hand; color: #58c603;"><i class="fa fa-calendar" data-toggle="tooltip" data-placement="top" data-original-title="Edit Callback"></i></span>
															</center>
														</td>
														<td><?php echo $lead_call_back['assignment_date']; ?></td>
														<td>
														<?php
															echo date('h:i A', strtotime($lead_call_back['assignment_time']));
														?>
														</td>
														<?php 
														if (strlen($lead_call_back['details'])>20)
														{
															$notes = substr($lead_call_back['details'], 0, 20).' ...';
														}
														else
														{
															$notes = $lead_call_back['details'];
														}
														?>
														<td><?php echo $notes; ?></td>													
														<td><?php echo $lead_call_back['name']; ?></td>
														<td><?php echo $lead_call_back['phone']; ?></td>
														<td><?php echo $lead_call_back['make']; ?></td>
														<td><?php echo $lead_call_back['model']; ?></td>
														<td><?php echo $lead_call_back['postcode'] . " " . $lead_call_back['state']; ?></td>
													</tr>
													<?php
												}
												?>
											</tbody>
										</table>							
									</div>
								</div>							
							</section>
						</div>						
					</div>
					<div class="row">				
						<div class="col-md-12">
							<section class="panel">
								<header class="panel-heading">
									<h2 class="panel-title">TENDERS</h2>
								</header>							
								<div class="panel-body">
									<table class="table table-bordered table-striped mb-none" style="white-space: nowrap;" id="datatable_2">
										<thead>
											<tr>
												<th></td>
												<th>DATE</th>
												<th>NAME</th>
												<th>PHONE</th>
												<th>MOBILE</th>
												<th>STATE</th>
												<th>POST</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach ($lead_tenders as $lead_tender)
											{
												?>
												<tr id="lead_main_row_<?php echo $lead_tender['id_lead']; ?>">
													<td>
														<center>
															<span class="open-lead-details" data-lead_id="<?php echo $lead_tender['id_lead']; ?>" style="cursor: pointer; cursor: hand; color: #58c603;"><i class="fa fa-pencil-square-o" data-toggle="tooltip" data-placement="top" data-original-title="View Details"></i></span>
														</center>
													</td>
													<td><?php echo $lead_tender['assignment_date']; ?></td>
													<td id="name_td_"><?php echo $lead_tender['name']; ?></td>
													<td id="phone_td_"><?php echo $lead_tender['phone']; ?></td>
													<td id="mobile_td_"><?php echo $lead_tender['mobile']; ?></td>
													<td id="state_td_"><?php echo $lead_tender['state']; ?></td>
													<td id="postcode_td_"><?php echo $lead_tender['postcode']; ?></td>
												</tr>
												<?php
											}
											?>
										</tbody>
									</table>
								</div>							
							</section>
						</div>						
					</div>					
					<!-- end: page -->
					<?php include 'modals/ticket_modals.php'; ?>
					<!-- Call Back Modal-->
					<div id="call-back-modal" class="modal fade">
						<div class="modal-dialog" style="width: 80%;">
							<section class="panel">
								<div class="panel-body">
									<div class="modal-wrapper">
										<div class="modal-text">
											<form method="post" action="" id="main_form" name="main_form">
												<input type="hidden" id="lead_id" name="id_lead" value="" />
												<div class="form-group">
													<div class="col-md-6 text-left">
														<label>Call Back Date:</label>
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-calendar"></i>
															</span>
															<input class="form-control input-md datepicker" id="assignment_date" name="assignment_date" data-date-format="yyyy/mm/dd" value="<?php echo $now; ?>" required>
														</div>
													</div>
													<div class="col-md-6 text-left">
														<label>Call Back Time:</label>
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-clock-o"></i>
															</span>
															<input type="text" class="form-control input-md timepicker" id="assignment_time" name="assignment_time" required>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="col-md-12 text-left">
														<label>Assign to:</label>
														<select class="form-control" name="quote_specialist" title="Quote Specialist">
															<?php 
															foreach ($admins as $admin)
															{
																$selected_user_id = "";
																if ($admin->id_user == $user_id)
																{
																	$selected_user_id = " selected";
																}															
																?>
																<option value="<?php echo $admin->id_user; ?>" name="quote_specialist" <?php echo $selected_user_id; ?>>
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
														<label>Details:</label>
														<textarea id="lead_details" name="lead_details" class="form-control" rows="3" placeholder="Lead Details" required></textarea>
													</div>								
												</div>												
											</form>
										</div>										
									</div>
								</div>
								<footer class="panel-footer">
									<div class="row">
										<div class="col-md-12 text-right">
											<button type="button" class="btn btn-primary" onclick="call_back_action()">Save</button>
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										</div>
									</div>
								</footer>
							</section>					
						</div>
					</div>
					<!-- /.Call Back Modal -->
					<!-- Edit Call Back Modal-->
					<div id="edit-call-back-modal" class="modal fade">
						<div class="modal-dialog" style="width: 80%;">
							<section class="panel">
								<div class="panel-body">
									<div class="modal-wrapper">
										<div class="modal-text">
											<form method="post" action="" id="edit_form" name="edit_form">
												<input type="hidden" id="edit_lead_id" name="edit_lead_id" value="" />
												<div class="form-group">
													<div class="col-md-6 text-left">
														<label>Call Back Date:</label>
														<?php $now = date("Y-m-d"); ?>
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-calendar"></i>
															</span>
															<input class="form-control input-md datepicker" id="edit_assignment_date" name="edit_assignment_date" data-date-format="yyyy-mm-dd" value="<?php echo $now; ?>" required>
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
														<label>Details:</label>
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
											<button type="button" class="btn btn-primary" id="save_edit_callback">Save</button>
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										</div>
									</div>
								</footer>
							</section>					
						</div>
					</div>
					<!-- /.Edit Call Back Modal -->					
				</section>
			</div>
			<?php include 'template/right_sidebar.php'; ?>
		</section>		
		<?php include 'template/scripts.php'; ?>
		<script src="<?php echo base_url('assets/vendor/jquery-appear/jquery.appear.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets/vendor/jquery-easypiechart/jquery.easypiechart.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets/vendor/flot/jquery.flot.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets/vendor/flot-tooltip/jquery.flot.tooltip.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets/vendor/flot/jquery.flot.pie.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets/vendor/flot/jquery.flot.categories.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets/vendor/flot/jquery.flot.resize.js'); ?>?v=<?php echo time();?>"></script>
		<script>
			$(document).ready(function(){
		    	$(document).on('click','#assignment_time',function(){
					var time = $('#assignment_time').timepicker('showWidget');
		    	});

		    	$(document).on('click','#edit_assignment_time',function(){
					var time = $('#edit_assignment_time').timepicker('showWidget');
		    	});
			});

			var datatable_1 = $('#datatable_1').DataTable({
				"pageLength": 10,
				"lengthMenu": [5, 10, 15],
				"language": {
	 				"lengthMenu": '<select>'+
	 					'<option value="5">5</option>'+
	 					'<option value="10">10</option>'+
	 					'<option value="15">15</option>'+
	 				'</select> Records per page'
				}
			});

			var datatable_2 = $('#datatable_2').DataTable({
				"pageLength": 10,
				"lengthMenu": [5, 10, 15],
				"language": {
	 				"lengthMenu": '<select>'+
	 					'<option value="5">5</option>'+
	 					'<option value="10">10</option>'+
	 					'<option value="15">15</option>'+
	 				'</select> Records per page'
				}			
			});

			$(document).on('click','.edit-callback', function(){
				var $this      = $(this);
				var lead_id    = $this.data("lead_id");
				var edit_modal = $("#edit-call-back-modal");

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
						edit_modal.modal();
					}
				});
			});

			$(document).on('click','#save_edit_callback', function(){
				var edit_modal = $("#edit-call-back-modal");
				var form       = $("#edit_form");
				var data       = form.serialize();

				$.ajax({
					type: "POST",
					url: "<?php echo site_url("lead/update_single_call_back"); ?>",
					data: data,
					cache: false,
					success: function(response){
						location.reload();
					}
				});
			});

			function call_back_modal (lead_id)
			{
				$.post("<?php echo site_url("lead/open_note"); ?>/" + lead_id, function(data)
				{
					$("#call-back-modal").find("#lead_details").val(data.lead_note);
					$("#call-back-modal").find("#assignment_date").val(data.assignment_date);
					$("#call-back-modal").find("#assignment_time").val(data.assignment_time);
					$("#call-back-modal").find("#lead_id").val(lead_id);
					$("#call-back-modal").modal();
				}, "json");				
			}

			function call_back_action ()
			{
				var lead_id = $("#call-back-modal").find("#lead_id").val();
				var assignment_date = $("#call-back-modal").find("#assignment_date").val();
				if (assignment_date=="")
				{
					alert ("Please choose a date!");
				}
				else
				{
					$.ajax({
						type: "POST",
						url: "<?php echo site_url("lead/update_call_back"); ?>/" + lead_id,
						data: $("#call-back-modal").find("#main_form").serialize(),
						cache: false,
						success: function(result){
							$("#call-back-modal").modal("hide");
							$('#next_lead_btn').removeAttr("disabled");
							$("#lead_status_text").html("Attempted");
							location.reload();
						}
					});						
				}
			}
		</script>
	</body>
</html>
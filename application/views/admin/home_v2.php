<?php include 'template/head.php'; ?>
	<style>
		.text-line {
			background-color: transparent;
			color: #888;
			outline: none;
			outline-style: none;
			border-top: none;
			border-left: none;
			border-right: none;
			border-bottom: solid #ddd 1px;
			padding: 0px 0px;
			height: 22px;
			width: 100%;
		}	
		
		.ajax_button {
			cursor: pointer; 
			cursor: hand; 
			margin-bottom: 10px;
		}
		
		.ajax_button_primary {
			cursor: pointer; 
			cursor: hand; 
			margin-bottom: 10px;
			color: #58c603;
		}
		
		.item_details_button {
			cursor: pointer; 
			cursor: hand; 
			padding: 5px;
			margin-bottom: 5px;
		}		
		
		.container_bordered_round {
			padding: 20px; 
			border: 1px solid #ccc;			
			border-radius: 5px;
		}
	</style>
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
			
			.tab_spinner {
				font-size: 50px; 
				margin-top: 30px;
				margin-bottom: 150px;
			}
			
			.tab_spinner_small {
				font-size: 30px; 
				margin-top: 20px;
				margin-bottom: 20px;
			}

			.notification_flag_small {
				color: #D2312D; 
				font-size: 0.9em;
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
						<div class="col-md-8">
							<div class="tabs">
								<ul class="nav nav-tabs tabs-primary"> <!-- Tabs -->	
									<li class="active">
										<a href="#tab_summary" onClick="load_summary()" data-toggle="tab">Summary</a>
									</li>
									<li>
										<a href="#tab_timeline" onClick="load_timeline()" data-toggle="tab">Timeline</a>
									</li>									
									<?php 
									foreach ($home_tabs AS $home_tab)
									{
										?>
										<li>
											<a href="#tab_<?php echo $home_tab['tab_name']; ?>" onClick="<?php echo $home_tab['function']; ?>('<?php echo $home_tab['tab_name']; ?>', '', '')" class="tab-head" data-tab_name="<?php echo $home_tab['tab_name']; ?>" data-toggle="tab">
												<?php echo $home_tab['label']; ?>
											</a>
										</li>										
										<?php
									}
									?>
								</ul>
								<div class="tab-content">
									<div id="tab_summary" class="tab-pane active">
										<div id="tab_summary_content">
											<center>
												<i class="fa fa-refresh fa-spin tab_spinner"></i>
											</center>
										</div>
									</div>
									<div id="tab_timeline" class="tab-pane">
										<section class="simple-compose-box mb-xlg" style="margin-top: 10px;">
											<form method="post" id="leave_message_form" name="leave_message_form" action="">
												<textarea data-plugin-textarea-autosize placeholder="Post on the timeline" rows="1" id="user_message" name="message"></textarea>
												<div class="compose-box-footer">
													<ul class="compose-btn">
														<li>
															<a class="btn btn-primary btn-xs" onClick="post_to_timeline()">Send</a>
														</li>
													</ul>
												</div>
											</form>
										</section>
										<div id="tab_timeline_content">
											<center>
												<i class="fa fa-refresh fa-spin tab_spinner"></i>
											</center>										
										</div>
									</div>
									<?php 
									foreach ($home_tabs AS $home_tab)
									{
										?>
										<div id="tab_<?php echo $home_tab['tab_name']; ?>" class="tab-pane" data-tab_name="<?php echo $home_tab['tab_name']; ?>">
											<center>
												<i class="fa fa-refresh fa-spin tab_spinner"></i>
											</center>
										</div>
										<?php
									}
									?>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="row" style="margin-bottom: 20px;" id="calendar_container"> <!-- Calendar Controller -->
								<div class="col-md-12">
									<div data-plugin-datepicker data-plugin-skin="primary" id="item_date"></div>
								</div>
							</div>
							<div class="row" style="margin-bottom: 20px;"> <!-- Unscheduled Leads Controller -->
								<div class="col-md-12">
									<section class="panel">
										<div class="panel-body">
											<div class="row">
												<div class="col-md-12">
													<center>
													<h5 style="font-size: 1.3em; margin-bottom: 3px; color: #58c603"><b>UNSCHEDULED LEADS</b></h5>
													<p style="font-size: 0.9em; margin-bottom: 15px;">Drag and drop to the calendar to schedule</p>
													</center>
													<?php 
													if (count($unscheduled_leads) > 0)
													{
														foreach ($unscheduled_leads AS $unscheduled_lead)
														{
															if ($unscheduled_lead['status']==1)
															{
																$unscheduled_lead_type = "attempted_lead";
																$unscheduled_lead_class = "alert-default";
															}
															else
															{
																$unscheduled_lead_type = "unattempted_lead";
																$unscheduled_lead_class = "alert-info";
															}
															?>
															<div class="alert <?php echo $unscheduled_lead_class; ?> item_details_button" id="unscheduled_lead_<?php echo $unscheduled_lead['id_lead']; ?>" data-id="<?php echo $unscheduled_lead['id_lead']; ?>" data-id_prefix="unscheduled_lead" data-item_type="lead">
																<i class="fa fa-calendar unscheduled_lead" data-id="<?php echo $unscheduled_lead['id_lead']; ?>" data-type="<?php echo $unscheduled_lead_type; ?>"></i>&nbsp;
																<?php echo $unscheduled_lead['age']; ?> - <?php echo $unscheduled_lead['make']; ?> <?php echo $unscheduled_lead['model']; ?> (<?php echo $unscheduled_lead['attempt_count']; ?>)
															</div>						
															<?php
														}												
													}
													else
													{
														?>	
														<div class="alert text-center">
															<br />
															<br />
															No records found!
															<br />
															<br />
															<br />
														</div>												
														<?php
													}
													?>												
												</div>
											</div>
										</div>
									</section>
								</div>
							</div>
						</div>						
					</div>					
					<!-- end: page -->
					<?php include 'modals/ticket_modals.php'; ?>
					<div id="call_modal" class="modal fade"> <!-- Call Modal -->
						<div class="modal-dialog" style="width: 80%;">
							<section class="panel">
								<form method="post" id="call_form" name="call_form" action="">
									<input type="hidden" id="id_lead" name="id_lead" value="">
									<div class="panel-body">
										<div class="modal-wrapper">
											<div class="modal-text">
												<div class="row">
													<div class="col-md-4">
														<section class="panel panel-horizontal" style="border: 1px solid #ddd;">
															<header class="panel-heading bg-primary">
																<div class="panel-heading-icon">
																	<i class="fa fa-phone"></i>
																</div>
															</header>
															<div class="panel-body p-lg">
																<h3 class="text-semibold mt-sm">PHONE</h3>
																<p><span id="phone_text"></span></p>
															</div>
														</section>
														<section class="panel panel-horizontal" style="border: 1px solid #ddd;">
															<header class="panel-heading bg-primary">
																<div class="panel-heading-icon">
																	<i class="fa fa-mobile"></i>
																</div>
															</header>
															<div class="panel-body p-lg">
																<h3 class="text-semibold mt-sm">MOBILE</h3>
																<p><span id="mobile_text"></span></p>
															</div>
														</section>														
													</div>
													<div class="col-md-8">
														<div class="row">
															<div class="col-md-12">													
																<div class="form-group">
																	<label class="control-label">Call Status:</label>
																	<select class="form-control" name="fk_call_status">
																		<option value=""></option>
																		<?php
																		foreach ($lead_call_status AS $call_status)
																		{
																			?>			
																			<option value="<?php echo $call_status['id_call_status']; ?>">
																				<?php echo $call_status['name']; ?>
																			</option>
																			<?php
																		}
																		?>									
																	</select>
																</div>	
															</div>
														</div>
														<div class="row" style="margin-top: 14px;">													
															<div class="col-md-12">
																<div class="form-group">
																	<label class="control-label">Details:</label>							
																	<textarea class="form-control" name="details" rows="8"></textarea>
																</div>
															</div>
														</div>														
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel-footer">
										<button type="submit" class="btn btn-primary">
											<i class="fa fa-save"></i> Save
										</button>
										<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
											Cancel
										</button>
									</div>
								</form>
							</section>
						</div>
					</div>	
					<div id="sms_modal" class="modal fade"> <!-- SMS Modal -->
						<div class="modal-dialog" style="width: 80%;">
							<section class="panel">
								<form method="post" id="sms_form" name="sms_form" action="">
									<input type="hidden" id="id_lead" name="id_lead" value="">
									<input type="hidden" id="mobile">
									<div class="panel-body">
										<div class="modal-wrapper">
											<div class="modal-text">
												<div class="row">													
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label">Message:</label>							
															<textarea class="form-control" name="message"></textarea>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel-footer">
										<button type="submit" class="btn btn-primary">
											<i class="fa fa-save"></i> Send
										</button>
										<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
											Cancel
										</button>
									</div>
								</form>
							</section>
						</div>
					</div>					
					<div id="not_proceeding_modal" class="modal fade"> <!-- Not Proceeding Modal -->
						<div class="modal-dialog" style="width: 80%;">
							<section class="panel">
								<form method="post" id="not_proceeding_form" name="not_proceeding_form" action="">
									<input type="hidden" id="id_lead" name="id_lead" value="">
									<input type="hidden" id="status" name="status" value="100">
									<div class="panel-body">
										<div class="modal-wrapper">
											<div class="modal-text">					
												<div class="row">													
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label">Please indicate the reason why the client is not proceeding:</label>							
															<textarea class="form-control" name="detele_reason"></textarea>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel-footer">
										<button type="submit" class="btn btn-primary">
											<i class="fa fa-save"></i> Save
										</button>
										<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
											Cancel
										</button>
									</div>
								</form>
							</section>
						</div>
					</div>
				</section>	
			</div>
			<?php include 'template/right_sidebar.php'; ?>
		</section>
		<?php include 'template/scripts.php'; ?>
		<script type="text/javascript">
			$(document).ready(function(){
				
				load_summary();

				$(document).on("click", ".refresh_home_tab", function(){
					var tab_name = $(this).data("tab_name");
					$("#tab_"+tab_name).html('<center><i class="fa fa-refresh fa-spin" style="font-size: 50px; margin-top: 20px; margin-bottom: 20px;"></i></center>');
					load_home_tab(tab_name, "", "");
				});				

				$(document).on("click", ".tab-head", function(){
					var tab_name = $(this).data("tab_name");
					$("#tab_"+tab_name).html('<center><i class="fa fa-refresh fa-spin" style="font-size: 50px; margin-top: 20px; margin-bottom: 20px;"></i></center>');
				});

				$(document).on("change", "#client", function(){
					var status = $(this).closest(".tab-pane").data("status");
					var client = $.trim($(this).val());
					$("#tab_"+status).html('<center><i class="fa fa-refresh fa-spin" style="font-size: 50px; margin-top: 20px; margin-bottom: 20px;"></i></center>');
					load_calendar_tab(status, client, "");
				});

				$(document).on("click", ".filter_button", function(){
					var filter_body = $(this).closest(".panel").find(".filter_body");
					if($(filter_body).hasClass("active") == true)
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
				
				$(document).on("click", ".item_details_button", function(){
					var id = $(this).data("id");
					var id_prefix = $(this).data("id_prefix");
					var item_type = $(this).data("item_type");

					load_home_calendar_tab_item(id, id_prefix, item_type);				
				});
				
				$(document).on("click", ".day", function(){
					var month_year = $("#item_date .datepicker-switch").html();
					var day = $("#item_date .active").html();

					load_home_tab("calendar", "", day+" "+month_year);
				});				

				$(".unscheduled_lead").draggable({
					zIndex: 1111999,
					revert: true,
					revertDuration: 0
				});				
				
				// Lead Actions //
				
				// Straight Actions (Start) //
				$(document).on("click", ".update_quote_seen_status_button", function(e) {

					var id_quote = $(this).data("id_quote");
					var seen_status = $(this).data("seen_status");
					
					var data = {
						id_quote: id_quote,
						seen_status: seen_status
					};				
					
					$.ajax({
						type: "POST",
						url: "<?php echo site_url("lead/update_quote_seen_status"); ?>",
						data: data,
						cache: false,
						success: function(response){
							if (response === "success")
							{
								swal("SUCCESS", "", "success");
								
							}						
							else
							{
								swal("ERROR", "An error occurred! Please try again", "error");
							}
						}
					});				
					e.preventDefault();
				});
				// Straight Actions (End) //				
				
				$(document).on("click", ".call_modal_button", function(e) {
					var id_lead = $(this).data("id_lead");
					var phone = $(this).data("phone");
					var mobile = $(this).data("mobile");

					$("#call_form").find("#id_lead").val(id_lead);
					$("#call_form").find("#phone_text").html(phone);
					$("#call_form").find("#mobile_text").html(mobile);

					$("#call_form").find("#phone_button").attr("href", "tel:" + phone);
					$("#call_form").find("#mobile_button").attr("href", "tel:" + mobile);				

					$("#call_modal").modal();
				});
				
				$("#call_form").submit(function(e) {
					$.ajax({
						type: "POST",
						url: "<?php echo site_url('lead/add_call_log'); ?>",
						data: $("#call_form").serialize(),
						cache: false,
						success: function(response) {
							if (response === "success")
							{
								$("#call_form").find("input,textarea,select").val("");
								$("#call_modal").modal("hide");
			
								swal("SUCCESS", "", "success");
								
								refresh_home_calendar_tab();
							}				
							else
							{
								swal("ERROR", "An error occurred! Please try again", "error");
							}
						}
					});
					e.preventDefault();
				});		
				
				$(document).on("click", ".sms_modal_button", function(e) {		
					swal("UNDER CONSTRUCTION", "This feature is under construction!", "info");
				});

				$("#sms_form").submit(function(e) {
					$("#sms_modal").find("input,textarea,select").val("");
					$("#sms_modal").modal("hide");
					
					swal("SUCCESS", "", "success");
					e.preventDefault();
				});	

				$(document).on("click", ".not_proceeding_modal_button", function(e) {	
					var id_lead = $(this).data("id_lead");
					
					$("#not_proceeding_form").find("#id_lead").val(id_lead);
					
					$("#not_proceeding_modal").modal();
				});

				$("#not_proceeding_form").submit(function(e) {
					
					var id_lead = $("#not_proceeding_form").find("#id_lead").val();
					
					$.ajax({
						type: "POST",
						url: "<?php echo site_url('lead/update_record'); ?>",
						data: $("#not_proceeding_form").serialize(),
						cache: false,
						success: function(response) {
							if (response === "success")
							{
								$("#not_proceeding_form").find("input,textarea,select").val("");
								$("#not_proceeding_modal").modal("hide");	
								$("#unscheduled_lead_"+id_lead).remove();								
								
								swal("SUCCESS", "", "success");
								
								
								refresh_home_calendar_tab();
							}						
							else
							{
								swal("ERROR", "An error occurred! Please try again", "error");
							}
						}
					});
					e.preventDefault();
				});
			});
			
			function refresh_home_calendar_tab ()
			{
				var month_year = $("#item_date .datepicker-switch").html();
				var day = $("#item_date .active").html();
				load_home_tab("calendar", "", day+" "+month_year);				
			}

			function load_home_calendar_tab_item (id, id_prefix, item_type)
			{
				$("#item_preview").html('<center><i class="fa fa-refresh fa-spin tab_spinner_small"></i></center>');				
				
				var data = {
					id: id,
					item_type: item_type
				};
				
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("lead/load_home_calendar_tab_item_html"); ?>",
					cache: false,
					data: data,
					success: function(response){
						$("#item_preview").html(response);
						$(".item_details_button").css("background-color", "");
						$(".item_details_button").css("color", "");
						$(".item_details_button").removeClass("active");
						
						$("#"+id_prefix+"_"+id).addClass("active");
						$("#"+id_prefix+"_"+id).css("background-color", "#58c603");
						$("#"+id_prefix+"_"+id).css("color", "#ffffff");
					}
				});				
			}
			
			function load_home_tab (tab_name, client, date)
			{
				if (date == "")
				{
					var month_names = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
					
					var now = new Date();
					var day = now.getDate();
					var month = now.getMonth();
					var year = now.getFullYear();		

					date = day + " " + month_names[month] + " " + year;
				}
				
				if (date.indexOf("undefined") != -1)
				{
					exit();
				}
				
				if (client == "")
				{
					var data = {
						tab_name: tab_name,
						date: date
					}
				}
				else
				{
					var data = {
						tab_name: tab_name,
						date: date,
						client: client
					}
				}

				$("#tab_"+tab_name).html('<center><i class="fa fa-refresh fa-spin tab_spinner"></i></center>');
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("lead/load_home_tab_html"); ?>",
					data: data,
					cache: false,
					success: function(data){
						$("#tab_"+tab_name).html(data);
						
						var id = $(".item_details_button.active").data("id");
						var item_type = $(".item_details_button.active").data("item_type");
						var id_prefix = $(".item_details_button.active").data("id_prefix");

						if (id == 0 || id == "" || typeof(id) == "undefined")
						{
							
						}
						else
						{
							load_home_calendar_tab_item(id, id_prefix, item_type);					
						}

						$(".unscheduled_lead").draggable({
							zIndex: 1111999,
							revert: true,
							revertDuration: 0
						});
						$(".scheduled_lead").draggable({
							zIndex: 1111999,
							revert: true,
							revertDuration: 0
						});
						$(".day").droppable({
							drop: function(event, ui) {								
								var month_year = $("#item_date .datepicker-switch").html();
								var day = $(event.target).text();
								var id_lead = $(ui.draggable).data("id");

								var data = {
									id_lead: id_lead,							
									date: day + " " + month_year
								};
								
								$.ajax({
									type: "POST",
									url: "<?php echo site_url('lead/set_lead_schedule'); ?>",
									data: data,
									cache: false,
									success: function(data){
										$("#unscheduled_lead_"+id_lead).remove();
										$(".day").attr("class", "day");
										$(event.target).attr("class", "day active");
										load_home_tab("calendar", "", day+" "+month_year);
									}
								});
							}
						});
					}
				});
			}

			function load_summary ()
			{
				$("#tab_summary_content").html('<center><i class="fa fa-refresh fa-spin tab_spinner"></i></center>');			
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("admin/load_summary_tab_html"); ?>/"+status,
					cache: false,
					success: function(data){
						$("#tab_summary_content").html(data);
					}
				});				
			}
			
			function load_timeline ()
			{
				$("#tab_timeline_content").html('<center><i class="fa fa-refresh fa-spin tab_spinner"></i></center>');			
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("admin/load_timeline_tab_html"); ?>/"+status,
					cache: false,
					success: function(data){
						$("#tab_timeline_content").html(data);
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
		</script>		
	</body>
</html>
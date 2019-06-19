<?php include 'template/head.php'; ?>
<?php 
$fq_page_flag = 1;
?>
	<body>
		<style type="text/css">
			.panel-filters {
				padding-bottom: 15px !important;
			}
		</style>
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
							</div>
							<h2 class="panel-title">
								<span class="label label-primary label-sm text-normal va-middle mr-sm"><?php echo $result_count; ?></span>
								<span class="va-middle">Search Filters</span>
							</h2>
						</header>
						<div class="panel-body panel-filters">
							<br />
							<form action="<?php echo site_url('fapplication/admin_list_view'); ?>" method="get" accept-charset="utf-8">
								<div class="row">										
									<?php
									$status  = isset($_GET['status']) ? $_GET['status'] : '';
									$fk_user = isset($_GET['user_id']) ? $_GET['user_id'] : '';
									$state   = isset($_GET['state']) ? $_GET['state'] : '';
									$name    = isset($_GET['name']) ? $_GET['name'] : '';
									$email   = isset($_GET['email']) ? $_GET['email'] : '';
									$phone   = isset($_GET['phone']) ? $_GET['phone'] : '';
									$mobile  = isset($_GET['mobile']) ? $_GET['mobile'] : '';
									?>
									<div class="form-group">
										<div class="col-md-4 text-left">
											<input type="text" class="form-control input-md" name="name" title="Client Name" placeholder="Client Name" value="<?php echo $name;?>"><br />
										</div>
										<div class="col-md-4 text-left">
											<input type="text" class="form-control input-md" name="email" title="Client Email Address" placeholder="Client Email Address" value="<?php echo $email;?>"><br />
										</div>
										<div class="col-md-4 text-left">
											<input type="text" class="form-control input-md" name="phone" title="Client Phone" placeholder="Client Phone" value="<?php echo $phone;?>"><br />
										</div>
									</div>
									<?php
									$selected_status_0   = ""; if ($status == "0") { $selected_status_0 = " selected"; }
									$selected_status_1   = ""; if ($status == "1") { $selected_status_1 = " selected"; }
									$selected_status_2   = ""; if ($status == "2") { $selected_status_2 = " selected"; }
									$selected_status_100 = ""; if ($status == "100") { $selected_status_100 = " selected"; }
									
									$selected_state_ACT  = ""; if ($state == 'ACT') { $selected_state_ACT = " selected"; }
									$selected_state_NSW  = ""; if ($state == 'NSW') { $selected_state_NSW = " selected"; }
									$selected_state_NT   = ""; if ($state == 'NT') { $selected_state_NT = " selected"; }
									$selected_state_QLD  = ""; if ($state == 'QLD') { $selected_state_QLD = " selected"; }
									$selected_state_SA   = ""; if ($state == 'SA') { $selected_state_SA = " selected"; }
									$selected_state_TAS  = ""; if ($state == 'TAS') { $selected_state_TAS = " selected"; }
									$selected_state_VIC  = ""; if ($state == 'VIC') { $selected_state_VIC = " selected"; }
									$selected_state_WA   = ""; if ($state == 'WA') { $selected_state_WA = " selected"; }
									?>
									<div class="form-group">
										<div class="col-md-4 text-left">
											<select class="form-control input-md" name="user_id" title="Quote Specialist">
												<option name="user_id" value="">-FQ Staff-</option>
												<?php 
												foreach ($admins as $admin)
												{
													$selected_user_id = "";
													if ($admin->id_user == $fk_user)
													{
														$selected_user_id = " selected";
													}
													?>
													<option name="user_id" value="<?php echo $admin->id_user; ?>" <?php echo $selected_user_id; ?>>
														<?php echo $admin->name; ?>
													</option>
													<?php
												}
												?>
											</select><br />
										</div>
										<div class="col-md-4 text-left">
											<select class="form-control input-md" name="state" title="State">
												<option name="state" value="">-State-</option>
												<option name="state" value="ACT" <?php echo $selected_state_ACT; ?>>ACT - Australian Capital Territory</option>
												<option name="state" value="NSW" <?php echo $selected_state_NSW; ?>>NSW - New South Wales</option>
												<option name="state" value="NT" <?php echo $selected_state_NT; ?>>NT - Northern Territory</option>
												<option name="state" value="QLD" <?php echo $selected_state_QLD; ?>>QLD - Queensland</option>
												<option name="state" value="SA" <?php echo $selected_state_SA; ?>>SA - South Australia</option>
												<option name="state" value="TAS" <?php echo $selected_state_TAS; ?>>TAS - Tasmania</option>
												<option name="state" value="VIC" <?php echo $selected_state_VIC; ?>>VIC - Victoria</option>
												<option name="state" value="WA" <?php echo $selected_state_WA; ?>>WA - Western Australia</option>
											</select><br />										
										</div>
									</div>
									<div class="col-md-12 text-right">
										<br />
										<input value="Apply Filters" name="submit" class="btn btn-primary" type="submit">
										<?php
										if ($admin_type == 3 || $user_id == 259)
										{
											?>													
											<button type="button" class="btn btn-primary" onclick="get_selected_fapplications_al()" disabled="">Allocate</button>
											<?php
										}
										?>
									</div>
								</div>
							</form>
						</div>
					</section>
					<section class="panel">
						<div class="panel-body">
							<div class="table-responsive">
								<?php
								if (count($fapplications)==0)
								{
									echo "<br /><center><i>No results found!</i></center><br /><br /><br /><br />";
								}
								else
								{
								?>
									<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
										<thead>
											<tr>
												<td><input type="checkbox" id="checkAll"/></td>
												<td><i class="fa fa-pencil-square-o"></i></td>
												<td><b>FQ Number</b></td>
												<td><b>Source</b></td>
												<td><b>FQ Staff</b></td>
												<td><b>CQ Status</b></td>
												<td><b>CQ Staff</b></td>
												<!--<td><b>Note</b></td>-->
												<td><b>Client Name</b></td>
												<td><b>Email</b></td>
												<td><b>Phone</b></td>
												<td><b>Mobile</b></td>
												<td><b>State</b></td>
												<td><b>Date</b></td>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach ($fapplications as $fapplication)
											{
												if ($fapplication->status == 0) { $css = 'style="color: #57DC75"'; }
												else if ($fapplication->status == 1){ $css = 'style="color: #3c94d6"'; }
												else if ($fapplication->status == 2){ $css = 'style="color: #cc3333"'; }
												else if ($fapplication->status == 3){ $css = 'style="color: #6600cc"'; }
												else if ($fapplication->status == 4){ $css = 'style="color: #9933cc"'; }
												else if ($fapplication->status == 5){ $css = 'style="color: #cc00cc"'; }
												else if ($fapplication->status == 6){ $css = 'style="color: #ff6633"'; }
												else if ($fapplication->status == 7){ $css = 'style="color: #009900"'; }
												else if ($fapplication->status == 99){ $css = 'style="color: #aaaaaa"'; }
												else if ($fapplication->status == 99){ $css = 'style="color: #222222"'; }
												else if ($fapplication->status == 100){ $css = 'style="color: #CCCCCC"'; }
												else { $css = ''; }
												
												if ($fapplication->cq_status == 0) { $cq_css = 'style="color: #57DC75"'; }
												else if ($fapplication->cq_status == 1){ $cq_css = 'style="color: #3c94d6"'; }
												else if ($fapplication->cq_status == 2){ $cq_css = 'style="color: #cc3333"'; }
												else if ($fapplication->cq_status == 3){ $cq_css = 'style="color: #6600cc"'; }
												else if ($fapplication->cq_status == 4){ $cq_css = 'style="color: #9933cc"'; }
												else if ($fapplication->cq_status == 5){ $cq_css = 'style="color: #cc00cc"'; }
												else if ($fapplication->cq_status == 6){ $cq_css = 'style="color: #ff6633"'; }
												else if ($fapplication->cq_status == 7){ $cq_css = 'style="color: #009900"'; }
												else if ($fapplication->cq_status == 99){ $cq_css = 'style="color: #aaaaaa"'; }
												else if ($fapplication->cq_status == 99){ $cq_css = 'style="color: #222222"'; }
												else if ($fapplication->cq_status == 100){ $cq_css = 'style="color: #CCCCCC"'; }
												else { $cq_css = ''; }												
												?>
												<tr id="fapplication_row_<?php echo $fapplication->id_fq_account; ?>">
													<td>
														<input type="checkbox" value="<?php echo $fapplication->id_fq_account; ?>">
													</td>
													<td>
														<a href="#" class="open-fapplication-details" data-fapplication_id="<?php echo $fapplication->id_fq_account; ?>"><i class="fa fa-pencil-square-o"></i></a>
													</td>
													<?php
													if ($fapplication->cq_status == 5 OR $fapplication->cq_status == 6 OR $fapplication->cq_status == 7 OR $fapplication->cq_status == 8)
													{
														?>
														<?php
													}
													else
													{
														?>
														<?php
													}
													?>
													<td><?php echo $fapplication->fq_number; ?></td>
													<td><?php echo $fapplication->source; ?></td>
													<td id="qs_td_<?php echo $fapplication->id_fq_account; ?>"><?php echo $fapplication->fq_staff; ?></td>
													<td <?php echo $cq_css; ?>><?php echo $fapplication->cq_status_text; ?></td>
													<td><?php echo $fapplication->cq_staff; ?></td>
													<?php 
													$note_link = "";
													if (strlen($fapplication->details) > 10)
													{
														$note_link = '
														<a href="#" class="open-fapplication-note" data-fapplication_id="'.$fapplication->id_fq_account.'"> ...</a>';
													}
													?>
													<!--
													<td><?php echo substr($fapplication->details, 0, 10).$note_link; ?></td>
													-->
													<td><?php echo $fapplication->name; ?></td>
													<td><a href="mailto:<?php echo $fapplication->email; ?>" target="_top"><?php echo $fapplication->email; ?></a></td>
													<td><?php echo $fapplication->phone; ?></td>
													<td><?php echo $fapplication->mobile; ?></td>
													<td><?php echo $fapplication->state; ?></td>
													<td>
														<?php 
														if ($fapplication->created_at == '0000-00-00 00:00:00')
														{
															echo $fapplication->last_updated; 
														}
														else
														{
															echo $fapplication->created_at;
														}
														?>
													</td>
												</tr>
												<?php
											}
											?>
										</tbody>
									</table>
									<br />
									<?php
								}
								?>
							</div>
							<?php echo $links; ?>
						</div>
					</section>
					<!-- end: page -->
					<?php include 'modals/ticket_modals.php'; ?>
					
					<!--FQ Application Modal-->
					<?php include 'modals/fa_application_3.php'; ?>
					<?php include 'modals/fa_requirements.php'; ?>
					<?php include 'modals/all_req_modal.php'; ?>
					<?php include 'modals/fa_add_comment.php'; ?>
					<?php include 'modals/new_cal_item.php'; ?>
					<?php include 'modals/fq_emailer.php'; ?>
					<!-- /. FQ Application Modal -->
					
					<!--Allocate FApplication Modal-->
					<div id="allocate-fapplication-modal" class="modal fade">
						<div class="modal-dialog" style="width: 60%;">
							<section class="panel">
								<header class="panel-heading">
									<h2 class="panel-title">Allocate Application</h2>
								</header>
								<div class="panel-body">
									<div class="modal-wrapper">
										<div class="modal-text">
											<div class="form-group">
												<input value="" id="fapplication_ids_val" name="fapplication_id" type="hidden">
												<select class="form-control" id="qs_dd" name="qs" title="Quote Specialist">
													<option name="qs" value=""></option>
													<?php 
													foreach ($admins as $admin)
													{
														?>
														<option name="qs" id="qs_s_val_<?php echo $admin->id_user; ?>" value="<?php echo $admin->id_user; ?>">
															<?php echo $admin->name; ?>
														</option>
														<?php
													}
													?>
												</select>
											</div>
										</div>
									</div>
								</div>
								<footer class="panel-footer">
									<div class="row">
										<div class="col-md-12 text-right">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											<button type="button" class="btn btn-primary" onclick="allocate_fapplications()">Allocate</button>
										</div>
									</div>
								</footer>
							</section>					
						</div>
					</div>
					<!-- /.Allocate FApplication Modal -->
					<!--Email FApplication Modal-->
					<div id="email-fapplication-modal" class="modal fade">
						<div class="modal-dialog" style="width: 80%;">
							<section class="panel">
								<header class="panel-heading">
									<h2 class="panel-title">Send Email</h2>
								</header>
								<div class="panel-body">
									<div class="modal-wrapper">
										<div class="modal-text">
											<div class="form-group">
												<input value="" id="el_fapplication_ids_val" name="fapplication_id" type="hidden">
												<input value="" class="form-control" id="el_email_subject" name="email_subject" type="text" placeholder="Subject">
											</div>
											<div class="form-group">
												<div id="el_email_message" name="email_message" class="summernote" data-plugin-summernote data-plugin-options='{ "height": 240, "codemirror": { "theme": "ambiance" } }'></div>

											</div>
										</div>
									</div>
								</div>
								<footer class="panel-footer">
									<div class="row">
										<div class="col-md-12 text-right">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											<button type="button" class="btn btn-primary" onclick="email_fapplications()">Send Email</button>
										</div>
									</div>
								</footer>
							</section>
						</div>
					</div>
					<!-- /.Email FApplication Modal -->
					<!--Note Modal-->
					<div id="note-modal" class="modal fade">
						<div class="modal-dialog">
							<section class="panel">
								<header class="panel-heading">
									<h2 class="panel-title">Note from Quote Specialist</h2>
								</header>
								<div class="panel-body">
									<div class="modal-wrapper">
										<div class="modal-text">
											<div class="note_area" id="note_area"></div>
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
					<!-- /.Note Modal -->
				</section>
			</div>
			<?php include 'template/right_sidebar.php'; ?>
		</section>
		<?php include 'template/scripts.php'; ?>
		<?php include 'js/fapplication_scripts.php'; ?>
		<?php include 'js/fapplication_calendar.php'; ?>
		<script>
			function allocate_fapplications ()
			{
				var fapplication_ids = $("#fapplication_ids_val").val();
				var fapplication_id_arr = fapplication_ids.split(",");
				var fapplication_count = fapplication_id_arr.length;

				var qs_id = $("#qs_dd").val();
				var qs_name = $("#qs_s_val_"+qs_id).html();
				var dataString = "&fapplication_ids="+fapplication_ids+"&user_id="+qs_id;

				if (qs_id.length == 0)
				{
					alert ("Please choose an FQ Staff");
				}
				else
				{
					$("#allocate_fapplication_loader").show();
					$("#allocate_fapplication_loader").fadeIn(400).html("Sending...");
					$.ajax({
						type: "POST",
						url: "<?php echo site_url("fapplication/allocate"); ?>",
						data: dataString,
						cache: false,
						success: function(result){
							$("#allocate_fapplication_loader").hide();
							var fapplication_index = 0;
							while (fapplication_index < fapplication_count) {
								$("#qs_td_"+fapplication_id_arr[fapplication_index]).html(qs_name);
								$("#ls_td_"+fapplication_id_arr[fapplication_index]).html("Allocated");
								$("#ls_td_"+fapplication_id_arr[fapplication_index]).css({"color": "#3c94d6"});
								$("input:checkbox").removeAttr("checked");
								fapplication_index++;
							}
							$("#allocate-fapplication-modal").modal("hide");
						}
					});
				}
			}

			function email_fapplications ()
			{
				var fapplication_ids = $("#el_fapplication_ids_val").val();
				var fapplication_id_arr = fapplication_ids.split(",");
				var fapplication_count = fapplication_id_arr.length;

				var email_subject = $("#el_email_subject").val();				
				var email_message = $("#el_email_message").code();

				var dataString = "&fapplication_ids="+fapplication_ids+"&email_subject="+email_subject+"&email_message="+email_message;

				$("#email_fapplication_loader").show();
				$("#email_fapplication_loader").fadeIn(400).html("Sending...");
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("fapplication/send_email"); ?>",
					data: dataString,
					cache: false,
					success: function(result){
						$("#email_fapplication_loader").hide();
						alert ("Success! Your email has been sent!");
						$("#email-fapplication-modal").modal("hide");
					}
				});
			}			

			function get_selected_fapplications_el ()
			{
				var checkbox_values = [];
				$('input[type="checkbox"]:checked').each(function(index, elem){
					checkbox_values.push($(elem).val());
				});
				$("#el_fapplication_ids_val").val(checkbox_values.join(","));
				$("#email-fapplication-modal").modal();
			}

			function get_selected_fapplications_al ()
			{
				var checkbox_values = [];
				$('input[type="checkbox"]:checked').each(function(index, elem){
					checkbox_values.push($(elem).val());
				});
				$("#fapplication_ids_val").val(checkbox_values.join(","));
				$("#allocate-fapplication-modal").modal();
			}			

			function delete_fapplications ()
			{
				if (confirm("Are you sure you want to delete this Application?"))
				{			
					var checkbox_values = [];
					$('input[type="checkbox"]:checked').each(function(index, elem){
						checkbox_values.push($(elem).val());
					});
					
					var fapplication_ids = checkbox_values.join(',');
					var fapplication_id_arr = fapplication_ids.split(',');
					var fapplication_count = fapplication_id_arr.length;				
					
					var dataString = "&fapplication_ids="+fapplication_ids;

					$("#delete_fapplication_loader").show();
					$("#delete_fapplication_loader").fadeIn(400).html("Sending...");
					$.ajax({
						type: "POST",
						url: "<?php echo site_url("fapplication/delete"); ?>",
						data: dataString,
						cache: false,
						success: function(result){
							$("#delete_fapplication_loader").hide();
							var fapplication_index = 0;
							while (fapplication_index < fapplication_count)
							{
								$("#fapplication_row_"+fapplication_id_arr[fapplication_index]).remove();
								fapplication_index++;
							}
						}
					});
				}
			}

			$(document).on("click", ".open-fapplication-note", function(data){
				var fapplication_id = $(this).data("fapplication_id");
				$.post("<?php echo site_url("fapplication/open_note"); ?>/" + fapplication_id, function(data){
					$("#note-modal").find("#note_area").html(data.fapplication_note);
					$("#note-modal").modal();
				}, "json");
			});

			$(document).on("click", ".open-fapplication-details", function(data){
				var fapplication_id = $(this).data("fapplication_id");
				var modal_data = null;
				$.post("<?php echo site_url("fapplication/record"); ?>/" + fapplication_id, function(data){
					<?php include 'js/full_calendar.php'; ?>
				}, 'json');
			});

			$("#checkAll").change(function(){
				$("input:checkbox").prop("checked", $(this).prop("checked"));
			});
		</script>
	</body>
</html>
<?php
echo $user_id;
?>
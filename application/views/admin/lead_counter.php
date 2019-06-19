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
							</div>
							<h2 class="panel-title">Search Filters</h2>
						</header>
						<div class="panel-body">
							<br />
							<form action="<?php echo site_url('lead/stats'); ?>" method="get" accept-charset="utf-8">
								<div class="row">										
									<?php
									$date_type = isset($_GET['date_type']) ? $_GET['date_type'] : '';
									$period_type = isset($_GET['period_type']) ? $_GET['period_type'] : '';

									$selected_date_type_1 = ""; if ($date_type == "1") { $selected_date_type_1 = " selected"; }
									$selected_date_type_2 = ""; if ($date_type == "2") { $selected_date_type_2 = " selected"; }
									$selected_date_type_3 = ""; if ($date_type == "3") { $selected_date_type_3 = " selected"; }
									$selected_date_type_4 = ""; if ($date_type == "4") { $selected_date_type_4 = " selected"; }
									$selected_date_type_5 = ""; if ($date_type == "5") { $selected_date_type_5 = " selected"; }
									$selected_date_type_6 = ""; if ($date_type == "6") { $selected_date_type_6 = " selected"; }
									$selected_date_type_7 = ""; if ($date_type == "7") { $selected_date_type_7 = " selected"; }
									$selected_date_type_8 = ""; if ($date_type == "8") { $selected_date_type_8 = " selected"; }

									$selected_period_type_1 = ""; if ($period_type == '1') { $selected_period_type_1 = " selected"; }
									$selected_period_type_2 = ""; if ($period_type == '2') { $selected_period_type_2 = " selected"; }
									?>
									<div class="form-group">
										<div class="col-md-5 text-left">
											<select class="form-control input-md" id="date_type_dropdown" name="date_type" title="Lead Status">
												<option name="date_type" value="1" <?php echo $selected_date_type_1; ?>>Allocated Lead</option>
												<option name="date_type" value="2" <?php echo $selected_date_type_2; ?>>Attempted Lead</option>
												<option name="date_type" value="3" <?php echo $selected_date_type_3; ?>>Tender Started</option>
												<option name="date_type" value="4" <?php echo $selected_date_type_4; ?>>Tender Ended</option>
												<option name="date_type" value="5" <?php echo $selected_date_type_5; ?>>Submitted Deal</option>
												<option name="date_type" value="6" <?php echo $selected_date_type_6; ?>>Deal Approved</option>
												<option name="date_type" value="7" <?php echo $selected_date_type_7; ?>>Deal Declined</option>
												<option name="date_type" value="8" <?php echo $selected_date_type_8; ?>>Deleted</option>
											</select><br />
										</div>
										<div class="col-md-5 text-left">
											<select class="form-control input-md" id="period_type_dropdown" name="period_type" title="Period Type">
												<option name="period_type" value="1" <?php echo $selected_period_type_1; ?>>Day</option>
												<option name="period_type" value="2" <?php echo $selected_period_type_2; ?>>Week</option>
											</select><br />										
										</div>
										<div class="col-md-2 text-right">
											<input value="Apply Filters" name="submit" class="btn btn-primary" type="submit">
										</div>										
									</div>
								</div>
							</form>
						</div>
					</section>					
					<section class="panel">
						<div class="panel-body">
							<div class="table-responsive">
								<?php
								if (count($lead_counter)==0)
								{
									echo "<br /><center><i>No results found!</i></center><br /><br /><br /><br />";
								}
								else
								{
								?>
									<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
										<thead>
											<tr>
												<td><b>User</b></td>
												<td><center><b><?php echo $d[0]; ?></b></center></td>
												<td><center><b><?php echo $d[1]; ?></b></center></td>
												<td><center><b><?php echo $d[2]; ?></b></center></td>
												<td><center><b><?php echo $d[3]; ?></b></center></td>
												<td><center><b><?php echo $d[4]; ?></b></center></td>
												<td><center><b><?php echo $d[5]; ?></b></center></td>
												<td><center><b><?php echo $d[6]; ?></b></center></td>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach ($lead_counter as $lead_c)
											{
												?>
												<tr>
													<td><?php echo $lead_c->name; ?></td>
													<td><?php echo $lead_c->val_1; ?></td>
													<td><?php echo $lead_c->val_2; ?></td>
													<td><?php echo $lead_c->val_3; ?></td>
													<td><?php echo $lead_c->val_4; ?></td>
													<td><?php echo $lead_c->val_5; ?></td>
													<td><?php echo $lead_c->val_6; ?></td>
													<td><?php echo $lead_c->val_7; ?></td>
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
					</section>
					<!-- end: page -->
					<?php include 'modals/ticket_modals.php'; ?>
				</section>
			</div>
			<?php include 'template/right_sidebar.php'; ?>
		</section>
		<?php include 'template/scripts.php'; ?>
	</body>
</html>
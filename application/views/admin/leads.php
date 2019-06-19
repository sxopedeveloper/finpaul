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
							<h2 class="panel-title">
								<span class="label label-primary label-sm text-normal va-middle mr-sm"><?php echo $result_count; ?></span>
								<span class="va-middle">Search Filters</span>
							</h2>
						</header>
						<form action="<?php echo site_url('lead/list_view'); ?>" method="get" accept-charset="utf-8" id="main_list_filter_form">
							<div class="panel-body">
								<br />
								<?php
								$cq_number = isset($_GET['cq_number']) ? $_GET['cq_number'] : '';
								$current_status = isset($_GET['current_status']) ? $_GET['current_status'] : '';
								$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';

								$name = isset($_GET['name']) ? $_GET['name'] : '';
								$email = isset($_GET['email']) ? $_GET['email'] : '';
								$phone = isset($_GET['phone']) ? $_GET['phone'] : '';
									
								$state = isset($_GET['state']) ? $_GET['state'] : '';
								$postcode = isset($_GET['postcode']) ? $_GET['postcode'] : '';
								$address = isset($_GET['address']) ? $_GET['address'] : '';
									
								$make = isset($_GET['make']) ? $_GET['make'] : '';
								$model = isset($_GET['model']) ? $_GET['model'] : '';
								$hidden_make_id = isset($_GET['hidden_make_id']) ? $_GET['hidden_make_id'] : '';
								$source = isset($_GET['source']) ? $_GET['source'] : '';

								$filter_date_from = isset($_GET['filter_date_from']) ? $_GET['filter_date_from'] : "";
								$filter_date_to   = isset($_GET['filter_date_to']) ? $_GET['filter_date_to'] : "";

								$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
								$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';

								$selected_current_status_0 = ""; if ($current_status == "0") { $selected_current_status_0 = " selected"; }
								$selected_current_status_1 = ""; if ($current_status == "1") { $selected_current_status_1 = " selected"; }
								$selected_current_status_2 = ""; if ($current_status == "2") { $selected_current_status_2 = " selected"; }
								$selected_current_status_3 = ""; if ($current_status == "3") { $selected_current_status_3 = " selected"; }
								$selected_current_status_4 = ""; if ($current_status == "4") { $selected_current_status_4 = " selected"; }
								$selected_current_status_100 = ""; if ($current_status == "100") { $selected_current_status_100 = " selected"; }

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
										<div class="col-md-12"> <!-- Lead Details Filter -->
											<h5><b>Lead Details:</b></h5>
											<div style="border: 1px solid #eeeeee; padding: 15px 15px 0px 15px; border-radius: 5px; background: #f5f5f5;">
												<div class="row">
													<div class="col-md-4">
														<input type="text" class="form-control mb-md" name="cq_number" title="QM Number" placeholder="QM Number" value="<?php echo $cq_number;?>">
													</div>
													<div class="col-md-4">
														<select class="form-control mb-md" name="current_status" title="Current Lead Status">
															<option name="current_status" value="">-Current Lead Status-</option>
															<option name="current_status" value="0" <?php echo $selected_current_status_0; ?>>Unallocated</option>
															<option name="current_status" value="1" <?php echo $selected_current_status_1; ?>>Allocated</option>
															<option name="current_status" value="2" <?php echo $selected_current_status_2; ?>>Attempted</option>
															<option name="current_status" value="3" <?php echo $selected_current_status_3; ?>>Tendering</option>
															<option name="current_status" value="4" <?php echo $selected_current_status_4; ?>>Converted to Deal</option>
															<option name="current_status" value="100" <?php echo $selected_current_status_100; ?>>Deleted</option>
														</select>
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
												</div>
											</div>
											<br />
										</div>
										<?php
									}
									else
									{
										?>
										<div class="col-md-12"> <!-- Lead Details Filter -->
											<h5><b>Lead Details:</b></h5>
											<div style="border: 1px solid #eeeeee; padding: 15px 15px 0px 15px; border-radius: 5px; background: #f5f5f5;">
												<div class="row">
													<div class="col-md-6">
														<input type="text" class="form-control mb-md" name="cq_number" title="QM Number" placeholder="QM Number" value="<?php echo $cq_number;?>">
													</div>
													<div class="col-md-6">
														<select class="form-control mb-md" name="current_status" title="Current Lead Status">
															<option name="current_status" value="">-Current Lead Status-</option>
															<option name="current_status" value="0" <?php echo $selected_current_status_0; ?>>Unallocated</option>
															<option name="current_status" value="1" <?php echo $selected_current_status_1; ?>>Allocated</option>
															<option name="current_status" value="2" <?php echo $selected_current_status_2; ?>>Attempted</option>
															<option name="current_status" value="3" <?php echo $selected_current_status_3; ?>>Tendering</option>
															<option name="current_status" value="4" <?php echo $selected_current_status_4; ?>>Converted to Deal</option>
															<option name="current_status" value="100" <?php echo $selected_current_status_100; ?>>Deleted</option>
														</select>
													</div>												
												</div>
											</div>
											<br />											
										</div>
										<?php
									}
									?>
									<div class="col-md-12"> <!-- Client Details Filter -->
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
									<div class="col-md-12"> <!-- Vehicle Details Filter -->
										<h5><b>Vehicle Details:</b></h5>
										<div style="border: 1px solid #eeeeee; padding: 15px 15px 0px 15px; border-radius: 5px; background: #f5f5f5;">
											<div class="row">
												<div class="col-md-4">
													<select class="form-control input-md" id="make" name="make">
														<option></option>
														<?php 
															foreach ($makes_row as $m_key => $m_val) 
															{
																?>
																<option <?= ((trim($make)==trim($m_val['name'])) ? "selected":"") ?> value='<?= $m_val["name"] ?>' data-id='<?= $m_val['id_make'] ?>'><?= $m_val['name'] ?></option>
																<?php
															}
														?>
													</select>
												</div>
												<input type="hidden" name="hidden_make_id" id="hidden_make_id" value="">
												<div class="col-md-4">
													<!-- <input type="text" class="form-control mb-md" name="model" title="Model" placeholder="Model" value="<?php echo $model;?>"> -->
													<select class="form-control input-md" id="model" name="model">
													</select>
												</div>
												<div class="col-md-4">
													<select class="form-control mb-md" name="source" title="Lead Source">
														<option name="source" value="">-Lead Source-</option>
														<?php							
														foreach ($lead_sources as $lead_source)
														{
															$selected_lead_source = "";
															if ($lead_source['source'] == $source)
															{
																$selected_lead_source = " selected";
															}
															?>
															<option name="source" value="<?php echo $lead_source['source']; ?>" <?php echo $selected_lead_source; ?>>
																<?php echo $lead_source['source']; ?>
															</option>
															<?php
														}
														?>
													</select>
												</div>													
											</div>
										</div>
										<br />
									</div>
									<div class="col-md-12"> <!-- Date Filter -->
										<h5><b>Filter by Date:</b></h5>
										<div style="border: 1px solid #eeeeee; padding: 15px 15px 0px 15px; border-radius: 5px; background: #f5f5f5;">
											<div class="row">
												<div class="col-md-3">
													<select class="form-control mb-md date_filter_by" name="date_filter_by">
														<option value="0">--Please Select--</option>
														<option value="1" <?= (isset($_GET['date_filter_by']) && $_GET['date_filter_by'] == 1) ? "selected" : ""; ?> >This Week</option>
														<option value="2" <?= (isset($_GET['date_filter_by']) && $_GET['date_filter_by'] == 2) ? "selected" : ""; ?>>Last Week</option>
														<option value="3" <?= (isset($_GET['date_filter_by']) && $_GET['date_filter_by'] == 3) ? "selected" : ""; ?>>This Month</option>
														<option value="4" <?= (isset($_GET['date_filter_by']) && $_GET['date_filter_by'] == 4) ? "selected" : ""; ?>>Last Month</option>
														<option value="5" <?= (isset($_GET['date_filter_by']) && $_GET['date_filter_by'] == 5) ? "selected" : ""; ?>>Today</option>
														<option value="6" <?= (isset($_GET['date_filter_by']) && $_GET['date_filter_by'] == 6) ? "selected" : ""; ?>>Yesterday</option>
														<option value="7" <?= (isset($_GET['date_filter_by']) && $_GET['date_filter_by'] == 7) ? "selected" : ""; ?>>Select Date</option>
													</select>
												</div>
												<div class="col-md-3">
													<select class="form-control mb-md filter_column" name="filter_column">
														<option value="">--Please Select--</option>
														<option value="created_at" <?= (isset($_GET['filter_column']) && $_GET['filter_column'] == "created_at") ? "selected" : ""; ?> >Lead Recieved Date</option>
														<option value="purchase_date" <?= (isset($_GET['filter_column']) && $_GET['filter_column'] == "purchase_date") ? "selected" : ""; ?> >Purchase Date</option>
														<option value="allocated_date" <?= (isset($_GET['filter_column']) && $_GET['filter_column'] == "allocated_date") ? "selected" : ""; ?> >Allocated Date</option>
														<option value="attempted_date" <?= (isset($_GET['filter_column']) && $_GET['filter_column'] == "attempted_date") ? "selected" : ""; ?> >Attempted Date</option>
														<option value="tender_date" <?= (isset($_GET['filter_column']) && $_GET['filter_column'] == "tender_date") ? "selected" : ""; ?> >Tender Date</option>
														<option value="winner_date" <?= (isset($_GET['filter_column']) && $_GET['filter_column'] == "winner_date") ? "selected" : ""; ?> >Winner Date</option>
														<option value="decline_date" <?= (isset($_GET['filter_column']) && $_GET['filter_column'] == "decline_date") ? "selected" : ""; ?> >Decline Date</option>
														<option value="approved_date" <?= (isset($_GET['filter_column']) && $_GET['filter_column'] == "approved_date") ? "selected" : ""; ?> >Approved Date</option>
														<option value="settled_date" <?= (isset($_GET['filter_column']) && $_GET['filter_column'] == "settled_date") ? "selected" : ""; ?> >Settled Date</option>
														<option value="order_date" <?= (isset($_GET['filter_column']) && $_GET['filter_column'] == "order_date") ? "selected" : ""; ?> >Order Date</option>
														<option value="delivery_date" <?= (isset($_GET['filter_column']) && $_GET['filter_column'] == "delivery_date") ? "selected" : ""; ?> >Delivery Date</option>
														<option value="deleted_date" <?= (isset($_GET['filter_column']) && $_GET['filter_column'] == "deleted_date") ? "selected" : ""; ?> >Deleted Date</option>
														<option value="cancelled_date" <?= (isset($_GET['filter_column']) && $_GET['filter_column'] == "cancelled_date") ? "selected" : ""; ?> >Cancelled Date</option>
													</select>
												</div>
												<div class="col-md-3">
													<input type="text" class="form-control input-md datepicker filter_date_from filter_date_textbox" name="filter_date_from" placeholder="Date From" disabled="" value="<?=  $filter_date_from; ?>">
												</div>
												<div class="col-md-3">
													<input type="text" class="form-control input-md datepicker filter_date_to filter_date_textbox" name="filter_date_to" placeholder="Date To" disabled="" value="<?=  $filter_date_to; ?>">
												</div>
											</div>
										</div>
										<br />
									</div>
									<div class="col-md-12"> <!-- Sort -->
										<h5><b>Sort: </b></h5>
										<div style="border: 1px solid #eeeeee; padding: 15px 15px 0px 15px; border-radius: 5px; background: #f5f5f5;">
											<div class="row">
												<div class="col-md-3">
													<select class="form-control mb-md order_by_filter" name="order_by_filter">
														<option value="">--Order By--</option>
														<option value="id_lead" <?= (isset($_GET['order_by_filter']) && $_GET['order_by_filter'] == "id_lead") ? "selected" : ""; ?> >QM Number</option>
														<option value="created_at" <?= (isset($_GET['order_by_filter']) && $_GET['order_by_filter'] == "created_at") ? "selected" : ""; ?> >Created Date</option>
														<option value="status" <?= (isset($_GET['order_by_filter']) && $_GET['order_by_filter'] == "status") ? "selected" : ""; ?> >Status</option>
														<option value="finance" <?= (isset($_GET['order_by_filter']) && $_GET['order_by_filter'] == "finance") ? "selected" : ""; ?> >Finance</option>
														<option value="attempts" <?= (isset($_GET['order_by_filter']) && $_GET['order_by_filter'] == "attempts") ? "selected" : ""; ?> >Attempts</option>
														<option value="name" <?= (isset($_GET['order_by_filter']) && $_GET['order_by_filter'] == "name") ? "selected" : ""; ?> >Client Name</option>
														<option value="state" <?= (isset($_GET['order_by_filter']) && $_GET['order_by_filter'] == "state") ? "selected" : ""; ?> >State</option>
														<option value="make" <?= (isset($_GET['order_by_filter']) && $_GET['order_by_filter'] == "make") ? "selected" : ""; ?> >Make</option>
														<option value="model" <?= (isset($_GET['order_by_filter']) && $_GET['order_by_filter'] == "model") ? "selected" : ""; ?> >Model</option>
														<option value="fk_user" <?= (isset($_GET['order_by_filter']) && $_GET['order_by_filter'] == "fk_user") ? "selected" : ""; ?> >QM Staff</option>
														<option value="sale_status" <?= (isset($_GET['order_by_filter']) && $_GET['order_by_filter'] == "sale_status") ? "selected" : ""; ?> >Sale Status</option>
													</select>
												</div>
												<div class="col-md-3">
													<select class="form-control mb-md order_filter" name="order_filter">
														<option value="">--Order--</option>
														<option value="ASC" <?= (isset($_GET['order_filter']) && $_GET['order_filter'] == "ASC") ? "selected" : ""; ?> >Ascending</option>
														<option value="DESC" <?= (isset($_GET['order_filter']) && $_GET['order_filter'] == "DESC") ? "selected" : ""; ?> >Descending</option>
													</select>
												</div>
											</div>
										</div>
										<br />
									</div>
								</div>
								<div class="form-group"> <!-- Clear Filter -->
									<div class="col-md-12 text-right">
										<input value="Apply Filters" name="submit" class="btn btn-primary" type="submit">
										<a class="btn btn-default" href="<?php echo site_url('lead'); ?>">Clear Filters</a>
										<br />
										<br />
									</div>
								</div>
							</div>
						</form>
					</section>
					<section class="panel">
						<header class="panel-heading">
							<div class="panel-actions">
								<a href="#" class="fa fa-caret-down"></a>
							</div>
							<h2 class="panel-title">
								<span class="va-middle">Actions</span>
							</h2>
						</header>
						<div class="panel-body">
							<?php									
							if ($admin_type==2 OR $admin_type==5)
							{
								$initial_flag = "";
								if ($this->session->userdata('chkbx_flag') !== FALSE)
								{
									if ($this->session->userdata('chkbx_flag') == 1)
									{
										$initial_flag = "checked";
									}
									else
									{
										$initial_flag = "";
									}
								}
								?>
								<div class="switch switch-sm switch-primary">	
									<input type="checkbox" name="switch" data-plugin-ios-switch <?php echo $initial_flag; ?> id="check_all" />
								</div>
								&nbsp;&nbsp;
								<label><h4><b>Select all filtered results</b></h4></label>
								<br />
								<?php 
							}
							?>						
							<?php
							if ($admin_type == 2 OR $admin_type==5)
							{
								?>
								<button type="button" class="btn btn-primary" onclick="allocate_leads_modal()">Allocate</button>
								<button type="button" class="btn btn-warning" onclick="email_leads_modal()">Send Email</button>
								<button type="button" class="btn btn-success" onclick="update_lead_price_modal()">Sale Price</button>
								<button type="button" class="btn btn-danger" onclick="delete_leads()">Delete</button>
								<?php
							}
							else
							{
								?>
								<button type="button" class="btn btn-primary" onclick="reallocate_leads_modal()">Reallocate</button>
								<?php
							}
							?>
							<a class="btn btn-primary" href="<?php echo site_url('lead/export_csv_leads/?'.$export_url); ?>" target="_blank">Export</a>
						</div>						
					</section>
					<?php
					if ($admin_type == 2 OR $admin_type==5)
					{
						?>					
						<section class="panel">
							<header class="panel-heading">
								<div class="panel-actions">
									<a href="#" class="fa fa-caret-down"></a>
								</div>
								<h2 class="panel-title">
									<span class="va-middle">Received Leads</span>
								</h2>
							</header>
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
										<thead>
											<tr>
												<td width="20%">Today</td>
												<td width="20%">Yesterday</td>
												<td width="20%">This Week</td>
												<td width="20%">This Month</td>
												<td width="20%">Last Month</td>
											</tr>									
										</thead>
										<tbody>
											<tr>
												<td><?php echo $leads_summary['received_today']; ?></td>
												<td><?php echo $leads_summary['received_yesterday']; ?></td>
												<td><?php echo $leads_summary['received_this_week']; ?></td>
												<td><?php echo $leads_summary['received_this_month']; ?></td>
												<td><?php echo $leads_summary['received_last_month']; ?></td>
											</tr>
										</tbody>
									</table>
								</div>
								<br /><i>*This does not include leads that came from OLD CQO</i>
							</div>
						</section>
						<?php
					}
					?>						
					<section class="panel">
						<input type="hidden" name="hidden_ids" id="hidden_ids">
						<div class="panel-body">
							<div class="table-responsive">
								<?php
								if (count($leads)==0)
								{
									echo "<br /><center><i>No results found!</i></center><br />";
								}
								else
								{
									?>
									<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
										<thead>
											<tr>
												<td><input type="checkbox" id="false_check_all" /></td>
												<td><b>QM Number</b></td>
												<td><b>Source</b></td>
												<td><b>Lead Status</b></td>
												<td><b>Financing</b></td>
												<td><b>Attempts</b></td>
												<td><b>Remarks</b></td>												
												<td><b>Available Trades</b></td>
												<td><b>Quotes</b></td>
												<td><b>CQ Staff</b></td>
												<td><b>FQ Staff</b></td>
												<td><b>Client Name</b></td>
												<td><b>Email</b></td>
												<td><b>Phone</b></td>
												<td><b>Mobile</b></td>
												<td><b>State</b></td>
												<td><b>Postcode</b></td>
												<td><b>Make</b></td>
												<td><b>Model</b></td>
												<td><b>Date</b></td>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach ($leads as $lead)
											{
												if ($lead['status'] == 0) { $ls_css = 'style="color: #99cc66"'; }
												else if ($lead['status'] == 1){ $ls_css = 'style="color: #66cc66"'; }
												else if ($lead['status'] == 2){ $ls_css = 'style="color: #33cc66"'; }
												else if ($lead['status'] == 3){ $ls_css = 'style="color: #6600cc"'; }
												else if ($lead['status'] == 4){ $ls_css = 'style="color: #9933cc"'; }
												else if ($lead['status'] == 5){ $ls_css = 'style="color: #cc00cc"'; }
												else if ($lead['status'] == 6){ $ls_css = 'style="color: #ff6633"'; }
												else if ($lead['status'] == 7){ $ls_css = 'style="color: #009900"'; }
												else if ($lead['status'] == 8){ $ls_css = 'style="color: #2baab1"'; }
												else if ($lead['status'] == 10){ $ls_css = 'style="color: #0000FF"'; }
												else if ($lead['status'] == 100){ $ls_css = 'style="color: #cccccc"'; }
												else { $ls_css = ''; }

												$flag           = 0;
												$checked_status = "";
												$array_id       = [];

												if ($this->session->userdata('chkbx_flag') !== FALSE)
												{
													$flag = $this->session->userdata('chkbx_flag');
													if ($flag == 1)
													{
														if ($this->session->userdata('chkbx_ids') !== FALSE)
														{
															$array_id = $this->session->userdata('chkbx_ids');

															if (in_array($lead['id_lead'], $array_id))
															{
																$checked_status = "";
															}
															else
															{
																$checked_status = "checked";
															}
														}
														else
														{
															$checked_status = "checked";
														}
													}
													else
													{
														if ($this->session->userdata('chkbx_ids') !== FALSE)
														{
															$array_id = $this->session->userdata('chkbx_ids');

															if (in_array($lead['id_lead'], $array_id))
															{
																$checked_status = "checked";
															}
															else
															{
																$checked_status = "";
															}
														}
														else
														{
															$checked_status = "";
														}
													}
												}
												else
												{
													if ($this->session->userdata('chkbx_ids') !== FALSE)
													{
														$array_id = $this->session->userdata('chkbx_ids');

														if (in_array($lead['id_lead'], $array_id))
														{
															$checked_status = "checked";
														}
														else
														{
															$checked_status = "";
														}
													}
													else
													{
														$checked_status = "";
													}
												}
												?>
												<tr id="lead_main_row_<?php echo $lead['id_lead']; ?>">
													<td>
														<input class="checkbox_sess" type="checkbox" value="<?php echo $lead['id_lead']; ?>" <?= $checked_status; ?> >
													</td>
													<td>
														<?php 
														echo '<a href="'.site_url('lead/record_final/'.$lead['id_lead']).'" target="_blank">'.$lead['cq_number'] . "</a> "; 
														echo ($lead['attachment_flag'] > 0) ? '<i class="fa fa-paperclip" data-toggle="tooltip" data-placement="top" data-original-title="With Attachments" ></i>' : ''; ?>
													</td>
													<td><?php echo $lead['source']; ?></td>
													<td id="lead_status_main_td_<?php echo $lead['id_lead']; ?>" <?php echo $ls_css; ?>><?php echo $lead['status_text']; ?></td>
													<td>
														<?php
														if ($lead['finance']==1)
														{
															echo "Yes";
														}
														else
														{
															echo "No";
														}
														?>
													</td>
													<td><?php echo $lead['attempts']; ?></td>
													<td>
														<?php
														$raw_details_text = str_replace('\n', ' ', $lead['details']);
														if (strlen($raw_details_text) >= 20) 
														{ 
															$details_text = substr($raw_details_text, 0, 20) . "..."; 
														}
														else
														{
															$details_text = $raw_details_text; 
														}
														echo $details_text;
														?>
													</td>
													<td><?php echo $lead['available_trades']; ?></td>
													<td>
														<?php 
														if ($lead['quote_count'] <> 0)
														{
															echo $lead['quote_count'];
														}
														else
														{
															echo "0";
														}
														?>
													</td>
													<td id="quote_specialist_main_td_<?php echo $lead['id_lead']; ?>"><?php echo $lead['cq_staff']; ?></td>
													<td><?php echo $lead['fq_staff']; ?></td>
													<td id="name_td_<?php echo $lead['id_lead']; ?>"><?php echo $lead['name']; ?></td>
													<td id="email_td_<?php echo $lead['id_lead']; ?>">
														<a href="mailto:<?php echo $lead['email']; ?>" target="_top"><?php echo $lead['email']; ?></a>
													</td>
													<td id="phone_td_<?php echo $lead['id_lead']; ?>"><?php echo $lead['phone']; ?></td>
													<td id="mobile_td_<?php echo $lead['id_lead']; ?>"><?php echo $lead['mobile']; ?></td>
													<td id="state_td_<?php echo $lead['id_lead']; ?>"><?php echo $lead['state']; ?></td>
													<td id="postcode_td_<?php echo $lead['id_lead']; ?>"><?php echo $lead['postcode']; ?></td>
													<td id="make_td_<?php echo $lead['id_lead']; ?>"><?php echo $lead['make']; ?></td>
													<td id="model_td_<?php echo $lead['id_lead']; ?>"><?php echo $lead['model']; ?></td>
													<td>
													<?php 
													if ($lead['shown_created_at'] == '0000-00-00 00:00:00')
													{
														if ($lead['created_at'] == '0000-00-00 00:00:00')
														{
															echo $lead['last_updated']; 
														}
														else
														{
															echo $lead['created_at'];
														}  
													}
													else
													{
														echo $lead['shown_created_at']; 
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
					<!--Allocate Lead Modal-->
					<div id="allocate-lead-modal" class="modal fade">
						<div class="modal-dialog" style="width: 60%;">
							<section class="panel">
								<header class="panel-heading">
									<h2 class="panel-title">Allocate Lead</h2>
								</header>
								<div class="panel-body">
									<div class="modal-wrapper">
										<div class="modal-text">
											<div class="form-group">
												<input value="" class="lead_ids_inp" name="lead_id" type="hidden">
												<select class="form-control quote_specialist_id_inp" name="quote_specialist" title="Quote Specialist">
													<option name="qs" value=""></option>
													<?php 
													foreach ($admins as $admin)
													{
														?>
														<option id="quote_specialist_name_inp_<?php echo $admin->id_user; ?>" value="<?php echo $admin->id_user; ?>" name="quote_specialist">
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
											<button type="button" class="btn btn-primary" onclick="allocate_leads()">Allocate</button>
										</div>
									</div>
								</footer>
							</section>					
						</div>
					</div>
					<!-- /.Allocate Lead Modal -->
					<!--Reallocate Lead Modal-->
					<div id="reallocate-lead-modal" class="modal fade">
						<div class="modal-dialog" style="width: 80%;">
							<section class="panel">
								<header class="panel-heading">
									<h2 class="panel-title"></h2>
								</header>
								<div class="panel-body">
									<div class="modal-wrapper">
										<div class="modal-text">
											<div class="form-group">
												<input value="" class="lead_ids_inp" name="lead_id" type="hidden">
												<select class="form-control quote_specialist_id_inp" name="quote_specialist" title="Quote Specialist">
													<option name="qs" value=""></option>
													<?php 
													foreach ($rl_admins as $rl_admin)
													{
														?>
														<option id="quote_specialist_name_inp_<?php echo $rl_admin->id_user; ?>" value="<?php echo $rl_admin->id_user; ?>" name="quote_specialist">
															<?php echo $rl_admin->name; ?>
														</option>
														<?php
													}
													?>
												</select>
											</div>
											<div class="form-group">
												<textarea name="reallocation_details" class="form-control reallocation_details_inp" placeholder="Reallocation Note"></textarea><br />
											</div>											
										</div>
									</div>
								</div>
								<footer class="panel-footer">
									<div class="row">
										<div class="col-md-12 text-right">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											<button type="button" class="btn btn-primary" onclick="reallocate_leads()">Reallocate</button>
										</div>
									</div>
								</footer>
							</section>					
						</div>
					</div>
					<!-- /.Reallocate Lead Modal -->
					<!--Email Lead Modal-->
					<div id="email-lead-modal" class="modal fade">
						<div class="modal-dialog" style="width: 80%;">
							<section class="panel">
								<header class="panel-heading">
									<h2 class="panel-title">Send Email</h2>
								</header>
								<div class="panel-body">
									<div class="modal-wrapper">
										<div class="modal-text">
											<div class="form-group">
												<input value="" class="lead_ids_inp" name="lead_id" type="hidden">
												<input value="" class="form-control email_subject_inp" name="email_subject" type="text" placeholder="Subject">
											</div>
											<div class="form-group">
												<div name="email_message" class="summernote email_message_inp" data-plugin-summernote data-plugin-options='{ "height": 240, "codemirror": { "theme": "ambiance" } }'></div>
											</div>
										</div>
									</div>
								</div>
								<footer class="panel-footer">
									<div class="row">
										<div class="col-md-12 text-right">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											<button type="button" class="btn btn-primary" onclick="email_leads()">Send Email</button>											
										</div>
									</div>
								</footer>
							</section>					
						</div>
					</div>
					<!-- /.Email Lead Modal -->
					<!--Sell Lead Modal-->
					<div id="update-lead-price-modal" class="modal fade">
						<div class="modal-dialog">
							<section class="panel">
								<header class="panel-heading">
									<h2 class="panel-title">Sell Leads</h2>
								</header>
								<div class="panel-body">
									<div class="modal-wrapper">
										<div class="modal-text">
											<div class="form-group">
												<input value="" class="lead_ids_inp" name="lead_id" type="hidden">
												<input value="" class="form-control lead_price_inp" name="lead_price" type="text" onkeypress="return isNumberKey(event)" placeholder="Lead Price">
											</div>
										</div>
									</div>
								</div>
								<footer class="panel-footer">
									<div class="row">
										<div class="col-md-12 text-right">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											<button type="button" class="btn btn-primary" onclick="update_lead_price()">Save</button>											
										</div>
									</div>
								</footer>
							</section>					
						</div>
					</div>
					<!-- /.Sell Lead Modal -->					
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
		<script>
			$(document).ready(function(){

				var model = "<?= $model ?>";
				var hidden_make_id = "<?= $hidden_make_id; ?>";
				var dealer = $("#make").select2();

				if (model != "")
				{
					var false_id = hidden_make_id;
					
					var data_2 = {
						code: 2,
						id_make: false_id
					}

					$.ajax({
						type: "POST",
						url: "<?php echo site_url("fapplication/get_dropdown_data"); ?>",
						cache: false,
						data: data_2,
						dataType: 'json',
						success: function(result){
							var option = '<option></option>';
							var selected = "";
							for (var i in result) 
							{
								if(model != "")
								{
									if (model == result[i].name)
									{
										selected = "selected";
									}
									else
									{
										selected = "";
									}
								}
								
								option = option+'<option '+selected+' data-id="'+result[i].id_family+'" value="'+result[i].name+'">'+result[i].name+'</option>';
							}

							$(document).find('#model').html(option);
							$(document).find('#hidden_make_id').val(false_id);
						}
					});
				}

				$(document).on("change", "#make", function(){
					model = "";
					var id = $("#make option:selected").attr("data-id");
					
					var data = {
						code: 2,
						id_make: id
					}

					$.ajax({
						type: "POST",
						url: "<?php echo site_url("fapplication/get_dropdown_data"); ?>",
						cache: false,
						data: data,
						dataType: 'json',
						success: function(result){
							var option = '<option></option>';
							
							for (var i in result) 
							{
								option = option+'<option data-id="'+result[i].id_family+'" value="'+result[i].name+'">'+result[i].name+'</option>';
							}

							$(document).find("#model").html(option);
							$(document).find("#hidden_make_id").val(id);
						}
					});
				});

				$(document).on("click", ".checkbox_sess", function(){
					var id = $(this).val();

					var data = {
						id: id
					}

					$.ajax({
						type: "POST",
						url: "<?php echo site_url("lead/maintain_pagination"); ?>",
						data: data,
						cache: false,
						datType: "json",
						success: function(data){
							//console.log(data);
						}
					});
				});
				
				$("#check_all").change(function(){

					var $this = $(this);
					var total_count = "<?= $result_count; ?>";
					var message = "";
					
					if ($this.prop('checked', true))
					{
						message = "You have unselected all the "+total_count+" of filtered results. Do you wish to proceed?";
					}
					else
					{
						message = "You have selected all the "+total_count+" filtered results. Do you wish to proceed?";
					}
					
					if (confirm(message))
					{
						$.ajax({
							type: "POST",
							url: "<?php echo site_url("lead/check_all_control"); ?>",
							cache: false,
							success: function(data){
								if($this.prop('checked') == true)
									$(document).find("#check_all").closest(".switch").find(".ios-switch").removeClass("off").addClass("on");
								else if($this.prop('checked') == false)
									$(document).find("#check_all").closest(".switch").find(".ios-switch").removeClass("on").addClass("off");

								location.reload();
							}
						});
					}
					else
					{
						if($this.prop('checked') == true)
							$(document).find("#check_all").closest(".switch").find(".ios-switch").removeClass("on").addClass("off");
						else if($this.prop('checked') == false)
							$(document).find("#check_all").closest(".switch").find(".ios-switch").removeClass("off").addClass("on");
						
					}
				});

				$(document).on('click','#false_check_all', function(){
					var $this_prop = $(this).prop('checked');
					var this_val = $(this).prop('checked');
					var id_array = [];

					if ($this_prop == true)
					{
						$(document).find('.checkbox_sess').prop('checked', true);
					}
					else
					{
						$(document).find('.checkbox_sess').prop('checked', false);
					}

					$(document).find('.checkbox_sess').each(function(index, value){
						id_array.push($(this).val());
					});
					
					var data = {
						id_array: id_array,
						this_val: this_val
					}

					$.ajax({
						type: "POST",
						url: "<?php echo site_url("lead/select_all_curr_checked"); ?>",
						data: data,
						cache: false,
						success: function(data){
							
						}
					});
				});
				
				$(document).on("change", ".date_filter_by", function(data){
					var this_val = $(this).val();

					$(document).find(".filter_date_textbox").val("");

					if(this_val == 7)
					{
						$(document).find(".filter_date_textbox").prop("disabled", false);
					}
					else
					{
						$(document).find(".filter_date_textbox").prop("disabled", true);
					}
				});

				var date_filter_val = $(document).find(".date_filter_by").val();

				if(date_filter_val == 7)
				{
					$(document).find(".filter_date_textbox").prop("disabled", false);
				}
				else
				{
					$(document).find(".filter_date_textbox").val("");
					$(document).find(".filter_date_textbox").prop("disabled", true);
				}				
			});

			function remove_all_checked ()
			{
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("lead/remove_all_checked"); ?>",
					cache: false,
					success: function(data){
					}
				});
			}

			function email_leads_modal ()
			{
				var checkbox_values = [];
				$('input[type="checkbox"]:checked').each(function(index, elem) {
					checkbox_values.push($(elem).val());
				});

				$("#email-lead-modal").find(".lead_ids_inp").val(checkbox_values.join(","));
				$("#email-lead-modal").modal();
			}

			function email_leads ()
			{
				var query_filter = $("#main_list_filter_form").serialize();
				var email_subject = $("#email-lead-modal").find(".email_subject_inp").val();				
				var email_message = $("#email-lead-modal").find(".email_message_inp").code();

				email_message = replaceAll(email_message, '&quot;', '%27');
				email_message = replaceAll(email_message, '&lt;', '%3C');
				email_message = replaceAll(email_message, '&qt;', '%3E');
				email_message = replaceAll(email_message, '&amp;', '%26');
				email_message = replaceAll(email_message, '&', '%26');

				var data = {
					email_subject: email_subject,
					email_message: email_message,
					query_filter: query_filter
				}

				$.ajax({
					type: "POST",
					url: "<?php echo site_url("lead/send_email"); ?>",
					data: data,
					cache: false,
					success: function(result){
						alert ("Success! Your email has been sent!");
						$("#email-lead-modal").modal("hide");
					}
				});
			}

			function select_model (brand_id)
			{
				if (brand_id != "" && brand_id != 0)
				{
					load_models(brand_id);
				}
			}

			function load_models (brand_id)
			{
				if (brand_id != "" && brand_id != 0)
				{
					var dataString = "&brand_id="+brand_id;
					$("#model_loader").show();
					$("#model_loader").fadeIn(400).html("Loading...");
					$.ajax({
						type: "POST",
						url: "<?php echo site_url("cars/load_models"); ?>",
						data: dataString,
						cache: false,
						success: function(result){
							$("#model_loader").hide();
							$("#model_dropdown").removeAttr("disabled");
							$("#model_dropdown").html("<option name='model' value='0'></option>");
							$("#model_dropdown").append(result);
						}
					});
				}
			}

			function allocate_leads_modal ()
			{
				var checkbox_values = [];
				$('input[type="checkbox"]:checked').each(function(index, elem) {
					checkbox_values.push($(elem).val());
				});
				$("#allocate-lead-modal").find(".lead_ids_inp").val(checkbox_values.join(","));
				$("#allocate-lead-modal").modal();
			}

			function allocate_leads ()
			{
				var query_filter = $("#main_list_filter_form").serialize();
				var quote_specialist_id = $("#allocate-lead-modal").find(".quote_specialist_id_inp").val();
				var quote_specialist_name = $("#allocate-lead-modal").find("#quote_specialist_name_inp_"+quote_specialist_id).html();

				var data = {
					quote_specialist_id: quote_specialist_id,
					query_filter: query_filter
				}

				if (quote_specialist_id.length == 0)
				{
					alert ("Please choose a Quote Specialist");
				}
				else
				{
					$.ajax({
						type: "POST",
						url: "<?php echo site_url("lead/allocate"); ?>",
						data: data,
						cache: false,
						dataType: 'json',
						success: function(data){
							var lead_index = 0;
							var lead_status = "";
							while (lead_index < data.lead_count)
							{
								if ($("#lead_status_main_td_"+data.lead_id_arr[lead_index]).html()=="Unallocated")
								{
									$("#lead_status_main_td_"+data.lead_id_arr[lead_index]).html("Allocated");
									$("#lead_status_main_td_"+data.lead_id_arr[lead_index]).css({"color": "#66cc66"});								
								}

								$("#quote_specialist_main_td_"+data.lead_id_arr[lead_index]).html(quote_specialist_name);								
								$("input:checkbox").removeAttr("checked");
								lead_index++;
							}
							remove_all_checked();
							$("#allocate-lead-modal").modal("hide");
						}
					});
				}
			}

			function reallocate_leads_modal ()
			{
				var checkbox_values = [];
				$('input[type="checkbox"]:checked').each(function(index, elem) {
					checkbox_values.push($(elem).val());
				});
				$("#reallocate-lead-modal").find(".lead_ids_inp").val(checkbox_values.join(","));
				$("#reallocate-lead-modal").modal();
			}

			function reallocate_leads ()
			{
				var query_filter = $("#main_list_filter_form").serialize();
				var quote_specialist_id = $("#reallocate-lead-modal").find(".quote_specialist_id_inp").val();
				var details = $("#reallocate-lead-modal").find(".reallocation_details_inp").val();				

				var data = {
					query_filter: query_filter,
					quote_specialist_id: quote_specialist_id,
					details: details
				};
				
				if (quote_specialist_id.length == 0)
				{
					alert ("Please choose a Quote Specialist");
				}
				else
				{
					$.ajax({
						type: "POST",
						url: "<?php echo site_url("lead/reallocate"); ?>",
						data: data,
						cache: false,
						dataType: 'json',
						success: function(data){
							var lead_index = 0;
							while (lead_index < data.lead_count) 
							{
								$("input:checkbox").removeAttr("checked");
								lead_index++;
							}
							remove_all_checked();
							alert ("Success! Reallocation request has been sent!");
							$("#reallocate-lead-modal").modal("hide");
						}
					});
				}
			}

			function update_lead_price_modal () // CHECKED
			{
				var checkbox_values = [];
				$('input[type="checkbox"]:checked').each(function(index, elem) {
					checkbox_values.push($(elem).val());
				});
				$("#update-lead-price-modal").find(".lead_ids_inp").val(checkbox_values.join(","));
				$("#update-lead-price-modal").modal();
			}

			function update_lead_price ()
			{
				var query_filter = $("#main_list_filter_form").serialize();
				var lead_price = $("#update-lead-price-modal").find(".lead_price_inp").val();

				var data = {
					query_filter: query_filter,
					lead_price: lead_price
				};

				$.ajax({
					type: "POST",
					url: "<?php echo site_url("lead/update_lead_price"); ?>",
					data: data,
					cache: false,
					dataType: 'json',
					success: function(data){
						var lead_index = 0;
						lead_price = parseFloat(lead_price);
						lead_price_text = lead_price.toFixed(2);
						while (lead_index < data.lead_count)
						{
							$("#lead_sale_price_main_td_"+data.lead_id_arr[lead_index]).html("$"+lead_price_text);
							$("input:checkbox").removeAttr("checked");
							lead_index++;
						}
						remove_all_checked();
						$("#update-lead-price-modal").modal("hide");
					}
				});
			}

			function remove_sale_status ()
			{
				if (confirm("Are you sure you want to remove these leads from the Leads for Sale List?")) 
				{
					var query_filter = $("#main_list_filter_form").serialize();

					var data = {
						query_filter: query_filter
					};

					$.ajax({
						type: "POST",
						url: "<?php echo site_url("lead/update_lead_sale_status/0"); ?>",
						data: data,
						cache: false,
						dataType: 'json',
						success: function(data){
							var lead_index = 0;
							while (lead_index < data.lead_count) {
								$("#lead_sale_status_main_td_"+data.lead_id_arr[lead_index]).html("");
								$("#lead_sale_price_main_td_"+data.lead_id_arr[lead_index]).html("");
								$("input:checkbox").removeAttr("checked");
								lead_index++;
							}
							remove_all_checked();
						}
					});
				}
			}
			
			function delete_leads ()
			{
				if (confirm("Are you sure you want to delete these leads?")) 
				{
					var query_filter = $("#main_list_filter_form").serialize();

					var data = {
						query_filter: query_filter
					};

					$.ajax({
						type: "POST",
						url: "<?php echo site_url("lead/delete"); ?>",
						data: data,
						cache: false,
						dataType: 'json',
						success: function(data){
							var lead_index = 0;
							while (lead_index < data.lead_count)
							{
								$("#lead_main_row_"+data.lead_id_arr[lead_index]).remove();
								lead_index++;
							}
							remove_all_checked();
						}
					});
				}
			}
		</script>
	</body>
</html>
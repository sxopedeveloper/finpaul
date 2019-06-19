<?php include 'template/head.php'; ?>
<?php
$fq_page_flag = 1;
$save_flag = 0;
?>
	<body>
		<style type="text/css">
			.panel-filters{
				padding-bottom: 15px !important;
			}
			
			.fapplicationfilter .form-control{
				width:100% !important;
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
						<!--<header class="panel-heading">
							<div class="panel-actions">
								<a href="#" class="fa fa-caret-down"></a>
							</div>
							<h2 class="panel-title">
								<span class="label label-primary label-sm text-normal va-middle mr-sm"><?//php echo $result_count; ?></span>
								<span class="va-middle">Search Filters</span>
							</h2>
						</header>-->
						
						<form action="<?php echo site_url('fapplication/list_view'); ?>" method="get" accept-charset="utf-8" id="main_list_filter_form">
							<div class="panel-body">
								<h5><b>Search Filters</b></h5>
								
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
										<div class="col-md-12"> <!-- Lead Details Filter
											<h5><b>Search Filters</b></h5> -->
												<div class="row">
													<div class="col-md-2">
														<input type="text" class="form-control mb-md" name="cq_number" title="FQ Number" placeholder="-FQ Number" value="<?php echo $cq_number;?>">
													</div>
													<div class="col-md-2">
														<select class="form-control mb-md" name="current_status" title="Current Lead Status">
															<option name="current_status" value="">-Lead Status-</option>
															<option name="current_status" value="0" <?php echo $selected_current_status_0; ?>>Unallocated</option>
															<option name="current_status" value="1" <?php echo $selected_current_status_1; ?>>Allocated</option>
															<option name="current_status" value="2" <?php echo $selected_current_status_2; ?>>Attempted</option>
															<option name="current_status" value="3" <?php echo $selected_current_status_3; ?>>Tendering</option>
															<option name="current_status" value="4" <?php echo $selected_current_status_4; ?>>Converted to Deal</option>
															<option name="current_status" value="100" <?php echo $selected_current_status_100; ?>>Deleted</option>
														</select>
													</div>
													<div class="col-md-2">
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
													<div class="col-md-2">
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
													<div class="col-md-2">
														<select class="form-control input-md" id="make" name="make">
															<option value="">-Make-</option>
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
													<div class="col-md-2">
														<!-- <input type="text" class="form-control mb-md" name="model" title="Model" placeholder="Model" value="<?php echo $model;?>"> -->
														<select class="form-control input-md" id="model" name="model">
															<option value="">-Model-</option>
														</select>
													</div>
												</div>
										</div>
										<?php
									}
									else
									{
										?>
										<div class="col-md-12"> <!-- Lead Details Filter -->
											<h5><b>Search Filters</b></h5>
											<div style="">
												<div class="row">
													<div class="col-md-2">
														<input type="text" class="form-control mb-md" name="cq_number" title="QM Number" placeholder="QM Number" value="<?php echo $cq_number;?>">
													</div>
													<div class="col-md-2">
														<select class="form-control mb-md" name="current_status" title="Current Lead Status">
															<option name="current_status" value="">-Lead Status-</option>
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
																				
										</div>
										<?php
									}
									?>
									<div class="col-md-12"> <!-- Client Details Filter -->
										
										<div style="">
											<div class="row">
												<div class="col-md-2">
													<input type="text" class="form-control mb-md" name="name" title="Name" placeholder="-Client Name" value="<?php echo $name;?>">
												</div>
												<div class="col-md-2">
													<input type="text" class="form-control mb-md" name="email" title="Email Address" placeholder="-Client Email" value="<?php echo $email;?>">
												</div>
												<div class="col-md-2">
													<input type="text" class="form-control mb-md" name="phone" title="Phone" placeholder="-Client Phone" value="<?php echo $phone;?>">
												</div>
												<div class="col-md-2">
													<input type="text" class="form-control mb-md" name="address" title="Address" placeholder="-Client Address" value="<?php echo $address;?>">
												</div>	
												<div class="col-md-2">
													<select class="form-control mb-md" name="state" title="State">
														<option name="state" value="">-Client State</option>
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
												<div class="col-md-2">
													<input type="text" class="form-control mb-md" name="postcode" title="Postcode" placeholder="-Client Postcode" value="<?php echo $postcode;?>">
												</div>								
											</div>
										</div>
										
									</div>				
									<!--<div class="col-md-12"> 
										<h5><b>Vehicle Details:</b></h5>
										<div style="border: 1px solid #eeeeee; padding: 15px 15px 0px 15px; border-radius: 5px; background: #f5f5f5;">
											<div class="row">
												<div class="col-md-4">
													<select class="form-control input-md" id="make" name="make">
														<option></option>
														<?//php 
															foreach ($makes_row as $m_key => $m_val) 
															{
																?>
																<option <?= ((trim($make)==trim($m_val['name'])) ? "selected":"") ?> value='<?= $m_val["name"] ?>' data-id='<?= $m_val['id_make'] ?>'><?= $m_val['name'] ?></option>
																<?//php
															}
														?>
													</select>
												</div>
												<input type="hidden" name="hidden_make_id" id="hidden_make_id" value="">
												<div class="col-md-4">
													
													<select class="form-control input-md" id="model" name="model">
													</select>
												</div>
												<div class="col-md-4">
													<select class="form-control mb-md" name="source" title="Lead Source">
														<option name="source" value="">-Lead Source-</option>
														<?//php							
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
															<?//php
														}
														?>
													</select>
												</div>													
											</div>
										</div>
										
									</div>-->
									<div class="col-md-12"> <!-- Date Filter -->
										
										<div>
											<div class="row">
												<div class="col-md-2">
													<select class="form-control mb-md date_filter_by" name="date_filter_by">
														<option value="0">-Filter Date</option>
														<option value="1" <?= (isset($_GET['date_filter_by']) && $_GET['date_filter_by'] == 1) ? "selected" : ""; ?> >This Week</option>
														<option value="2" <?= (isset($_GET['date_filter_by']) && $_GET['date_filter_by'] == 2) ? "selected" : ""; ?>>Last Week</option>
														<option value="3" <?= (isset($_GET['date_filter_by']) && $_GET['date_filter_by'] == 3) ? "selected" : ""; ?>>This Month</option>
														<option value="4" <?= (isset($_GET['date_filter_by']) && $_GET['date_filter_by'] == 4) ? "selected" : ""; ?>>Last Month</option>
														<option value="5" <?= (isset($_GET['date_filter_by']) && $_GET['date_filter_by'] == 5) ? "selected" : ""; ?>>Today</option>
														<option value="6" <?= (isset($_GET['date_filter_by']) && $_GET['date_filter_by'] == 6) ? "selected" : ""; ?>>Yesterday</option>
														<option value="7" <?= (isset($_GET['date_filter_by']) && $_GET['date_filter_by'] == 7) ? "selected" : ""; ?>>Select Date</option>
													</select>
												</div>
												<div class="col-md-2">
													<select class="form-control mb-md filter_column" name="filter_column">
														<option value="">-Filter By</option>
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
												<div class="col-md-2">
													<input type="text" class="form-control input-md datepicker filter_date_from filter_date_textbox" name="filter_date_from" placeholder="-Date From" disabled="" value="<?=  $filter_date_from; ?>">
												</div>
												<div class="col-md-2">
													<input type="text" class="form-control input-md datepicker filter_date_to filter_date_textbox" name="filter_date_to" placeholder="-Date To" disabled="" value="<?=  $filter_date_to; ?>">
												</div>
												<div class="col-md-2">
													<select class="form-control mb-md order_by_filter" name="order_by_filter">
														<option value="">-Order By</option>
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
												<div class="col-md-2">
													<select class="form-control mb-md order_filter" name="order_filter">
														<option value="">-Order</option>
														<option value="ASC" <?= (isset($_GET['order_filter']) && $_GET['order_filter'] == "ASC") ? "selected" : ""; ?> >Ascending</option>
														<option value="DESC" <?= (isset($_GET['order_filter']) && $_GET['order_filter'] == "DESC") ? "selected" : ""; ?> >Descending</option>
													</select>
												</div>
											</div>
										</div>
										
									</div>
									<!--
									<div class="col-md-12"> 
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
										
									</div>
									-->
									<div class="col-md-12 mt10"> 
											<div class="row">
												<div class="col-md-6 pull-right">
													<div class="row">
														<div class="col-md-4">
															
														</div>
														<div class="col-md-4">
															<input value="Apply Filters" name="submit" class="btn btn-primary search-filter-btn col-md-12 col-sm-12 col-xs-12" type="submit">
														</div>
														<div class="col-md-4">
															<a class="btn btn-default search-filter-btn col-md-12 col-sm-12 col-xs-12" href="<?php echo site_url('fapplication'); ?>">Clear Filters</a>
														</div>
													</div>
												</div>
												<div class="col-md-6">
												</div>
											</div>
											<hr>
											<div class="row">
												<div class="col-md-7">
													<?php if ($admin_type==2 OR $admin_type==5)
													{?>
													<div class="row">
														<div class="col-md-2">
														<select class="form-control mb-md" name="change_count" id="change_count" title="Current Lead Status">
															<option  value="3">3</option>
															<option  value="5">5</option>
															<option  value="7">7</option>
															<option  value="10">10</option>
															<option  value="12">12</option>
															<option  value="15">15</option>
															<option  value="20">20</option>
															<option  value="25">25</option>
															<option  value="30">30</option>
															
														</select>
														</div>
														<div class="col-md-3">
														<select class="form-control mb-md" name="change_status" id="change_status" title="Current Lead Status">
															<option name="current_status" value="">Lead Status</option>
															<option name="current_status" value="0" >Unallocated</option>
															<option name="current_status" value="1" >Allocated</option>
															<option name="current_status" value="2" >Attempted</option>
															<option name="current_status" value="3" >Tendering</option>
															<option name="current_status" value="4" >Converted to Deal</option>
															<option name="current_status" value="100" >Deleted</option>
														</select>
														</div>
														<div class="col-md-4">
														<select class="form-control mb-md" name="allocated_to" id="allocated_to" title="Quote Specialist">
																<option  value="">-Quote Specialist-</option>
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
																		<option  value="<?php echo $admin->id_user; ?>" <?php echo $selected_user_id; ?>>
																			<?php echo $admin->name; ?>
																		</option>
																		<?php
																	}
																}
																?>
															</select>
														</div>
														<div class="col-md-3">
															<input value="Allocate" name="submit" id="allocation" class="btn btn-primary search-filter-btn col-md-12 col-sm-12 col-xs-12" type="button">
														</div>
													</div>
													<?php } ?>
												</div>
												<div class="col-md-5">
												</div>
											</div>
									</div>
								</div>
								<!--
								<div class="form-group"> 
									<div class="col-md-12 text-right">
										<input value="Apply Filters" name="submit" class="btn btn-primary" type="submit">
										<a class="btn btn-default" href="<?php echo site_url('lead'); ?>">Clear Filters</a>
										
										<br />
									</div>
								</div>
								-->
							</div>
						</form>
					</section>
					
											
					<section class="panel" id="tableData">
						<input type="hidden" name="hidden_ids" id="hidden_ids">
						<div class="panel-body" style="   ">
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
												<th><input type="checkbox" id="checkAll"/></th>
												<th><i class="fa fa-pencil-square-o"></i></th>
												<th><i class="fa fa-trash-o"></i></th>
												<th>
													<i class="fa fa-file-pdf-o" data-toggle="tooltip" data-placement="top" title="Order PDF"></i>
												</th>
												
												<th><b>FQ Number</b></th>
												<th><b>Landing Page URL</b></th>
												<th><b>Lead Status</b></th>
												<th><b>Financing</b></th>
												<?php /*?><th><b>Remarks</b></th>												
												<th><b>Available Trades</b></th>
												<th><b>Quotes</b></th><?php */?>
												<th><b>CQ Staff</b></th>
												<th><b>Client Name</b></th>
												<th><b>Email</b></th>
												<th><b>Phone</b></th>
												<?php /*?><th><b>Mobile</b></th>
												<th><b>State</b></th><?php */?>
												<th><b>Postcode</b></th>
												<?php /*?><th><b>Make</b></th><?php */?>
												<th><b>Model</b></th>
												<th><b>Lead Date & time</b></th>
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
												else if ($lead['status'] == 100){ $ls_css = 'style="color: #ff0000"'; }
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

															if (isset($lead['id_lead']) &&  in_array($lead['id_lead'], $array_id))
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

															if (in_array($lead['id_fq_account'], $array_id))
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

														if (in_array($lead['id_fq_account'], $array_id))
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
												<tr id="lead_main_row_<?php echo $lead['id_fq_account']; ?>">
													<td>
														<input class="statusAlocation" type="checkbox" value="<?php echo $lead['id_fq_account']; ?>">
													</td>
													<td>
														<a href="javascript:;" class="open-fapplication-details" data-fapplication_id="<?php echo $lead['id_fq_account']; ?>"><i class="fa fa-pencil-square-o"></i></a>
													</td>
													
													<td>
														<?php //if ($lead['status'] == 5 OR $lead['status'] == 6 OR $lead['status'] == 7 OR $lead['status'] == 8){
														if ($lead['status'] != 100){
														?>
															<a href="javascript:;" onClick="return delete_fapplications_page(<?php echo $lead['id_fq_account']; ?>);" class="" data-fapplication_id="<?php echo $lead['id_fq_account']; ?>"><i class="fa fa-trash-o"></i></a>
														<?php }else{ 
														if ($admin_type==3 || !$user_id==259)
														{
															if($lead['status']==100)
															{ 															
														?>
															<a href="javascript:;" onClick="return delete_fapplications_page(<?php echo $lead['id_fq_account']; ?>,'true');" class="text-danger" data-fapplication_id="<?php echo $lead['id_fq_account']; ?>"><i class="fa fa-trash-o"></i></a>

														<?php } } else { ?>
															<i class="fa fa-trash-o"></i>
														<?php  } } ?>
													</td>
													
													<?php if ($lead['status'] == 5 OR $lead['status'] == 6 OR $lead['status'] == 7 OR $lead['status'] == 8)
													{
													?>
													<td>
														<a href="<?php echo site_url("deal/pdf_export/".$lead['id_fq_account']); ?>"  target="_blank">
															<i class="fa fa-file-pdf-o" data-toggle="tooltip" data-placement="top" title="Order PDF"></i>
														</a>
													</td>													
													<?php
													}
													else
													{
													?>
													<td>
														<i class="fa fa-file-pdf-o" data-toggle="tooltip" data-placement="top" title="Order PDF"></i>
													</td>													
													<?php
													}
													?>
													<td><?php print_r($lead['fq_number']); ?></td>
													<td><?php echo $lead['landing_page_url']; ?></td>
													<td id="lead_status_main_td_<?php echo $lead['id_fq_account']; ?>" <?php echo $ls_css; ?>>
														<?php 
															$extra_btn = '';
															if($lead['status']==100)
															{
																if ($admin_type==3 || !$user_id==259)
																{
																	$extra_btn = ' <a href="javascript:;" onClick="return reallocate_lead('.$lead['id_fq_account'].');" class=""><i class="fa fa-undo"></i></a>';
																}
															}
															
															echo $lead['status_text'].$extra_btn; 
														?>
													</td>
													<td>
														<?php
														/*if ($lead['finance']==1)
														{
															echo "Yes";
														}
														else
														{
															echo "No";
														}*/
														
													//print_r($lead['get_fq_dealer_data']);
													if(!empty($lead['get_fq_dealer_data']) && $lead['get_fq_dealer_data']['finance']!="" ){
														echo stripslashes( $lead['get_fq_dealer_data']['finance']);
													}
													else
													{ echo "-"; } ?>
														
													</td>
												
													<?php /*?><td>
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
													</td><?php */?>
													<td id="quote_specialist_main_td_<?php echo $lead['id_fq_account']; ?>"><?php echo $lead['cq_staff']; ?></td>
													
													<td id="name_td_<?php echo $lead['id_fq_account']; ?>"><?php echo $lead['lead_name']; ?></td>
													<td id="email_td_<?php echo $lead['id_fq_account']; ?>">
														<a href="mailto:<?php echo $lead['lead_email']; ?>" target="_top"><?php echo $lead['lead_email']; ?></a>
													</td>
													<td id="phone_td_<?php echo $lead['id_fq_account']; ?>"><?php echo $lead['lead_phone']; ?></td>
													
													<?php /*?><td id="mobile_td_<?php echo $lead['id_fq_account']; ?>"><?php echo $lead['lead_mobile']; ?></td>
													<td id="state_td_<?php echo $lead['id_fq_account']; ?>"><?php echo $lead['lead_state']; ?></td><?php */?>
													
													<td id="postcode_td_<?php echo $lead['id_fq_account']; ?>"><?php 
													
													if(!empty($lead['get_fq_dealer_data']) && $lead['get_fq_dealer_data']['postcode']!="" ){
														echo $lead['get_fq_dealer_data']['postcode'];
													}
													else
													{ echo $lead['lead_postcode']; } ?></td>
													<?php /*?><td id="make_td_<?php echo $lead['id_fq_account']; ?>"><?php echo $lead['lead_make']; ?></td><?php */?>
													<td id="model_td_<?php echo $lead['id_fq_account']; ?>">
													<?php 
													if(!empty($lead['get_fq_dealer_data']) && $lead['get_fq_dealer_data']['modal']!="" ){
														echo $lead['get_fq_dealer_data']['modal'];
													}
													else
													{ echo $lead['lead_model']; } ?></td>
													<td id="model_td_<?php echo $lead['id_fq_account']; ?>">
													<?php if($lead['landing_date_time']!="0000-00-00 00:00:00")
													{ echo date("m-d-Y h:i: A",strtotime($lead['landing_date_time'])); } 
													else
													{ echo '-';}?></td>
												
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
				<!-- /.Note Modal -->
				
                <?php include 'modals/ticket_modals.php'; ?>

				<!--FQ Application Modal-->
				<?php include 'modals/fa_application_3.php'; ?>
				<?php include 'modals/fa_requirements.php'; ?>
				<?php include 'modals/all_req_modal.php'; ?>
				<?php include 'modals/new_cal_item.php'; ?>
				<?php include 'modals/fq_emailer.php'; ?>
				
				<!-- /.Add FQ Application Comment Modal -->
			</div>
			<?php include 'template/right_sidebar.php'; ?>
		</section>
		<?php include 'template/scripts.php'; ?>
		<?php include 'js/fapplication_scripts.php'; ?>
		<?php include 'js/fapplication_calendar.php'; ?>
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
							//console.log(result);
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
				
				
				
			
			
						
			});;
				
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
				$('input[type="checkbox"]:checked').each(function(index, elem) {
					checkbox_values.push($(elem).val());
				});
				$("#el_fapplication_ids_val").val(checkbox_values.join(","));
				$("#email-fapplication-modal").modal();
			}

			function get_selected_fapplications_al ()
			{
				var checkbox_values = [];
				$('input[type="checkbox"]:checked').each(function(index, elem) {
					checkbox_values.push($(elem).val());
				});
				$("#fapplication_ids_val").val(checkbox_values.join(","));
				$("#allocate-fapplication-modal").modal();
			}			
			function delete_fapplications_page (id,isDelete='false')
			{
				//alert(id)
				var fapplication_id = id;
				var data = {
					fapplication_id: fapplication_id,
					isDelete : isDelete
				};
				if( confirm( "Are you sure you want to delete this calendar item?" ) )
				{
					$.ajax({
						type: "POST",
						url: "<?php echo site_url("fapplication/delete_cal_item"); ?>",
						data: data,
						cache: false,
						success: function(data){
							if(data == '1' || data == 1)
							{
								location.reload();
							}
						}
					});
				}
			}
			function reallocate_lead (id)
			{
				//alert(id)
				var fapplication_id = id;
				var data = {
					fapplication_id: fapplication_id
				};
				if( confirm( "Are you sure you want to reallocate this calendar item?" ) )
				{
					$.ajax({
						type: "POST",
						url: "<?php echo site_url("fapplication/reallocate_cal_item"); ?>",
						data: data,
						cache: false,
						success: function(data){
							if(data == '1' || data == 1)
							{
								location.reload();
							}
						}
					});
				}
			}
			
			function delete_fapplications ()
			{
				if (confirm("Are you sure you want to delete this Application?"))
				{			
					var ids = [];
					$('input[type="checkbox"]:checked').each(function(index, elem) {
						if($(this).val() != "on")
							ids.push($(this).val());
					});
					
					var data = {
						ids: ids
					};

					$("#delete_fapplication_loader").show();
					$("#delete_fapplication_loader").fadeIn(400).html("Sending...");
					$.ajax({
						type: "POST",
						url: "<?php echo site_url("fapplication/delete"); ?>",
						data: data,
						cache: false,
						success: function(result){

							$(ids).each(function(index, val){
								$("#ls_td_"+val).text("Deleted");
								$("#ls_td_"+val).css("color", "#ff0000");
							});

							$("input:checkbox").prop("checked", false);
						}
					});
				}
			}

			function restore_status()
			{
				if (confirm("Are you sure you want to restore these Applications?"))
				{			
					var ids = [];
					$('input[type="checkbox"]:checked').each(function(index, elem) {
						if($(this).val() != "on")
							ids.push($(this).val());
					});
					
					var data = {
						ids: ids
					};

					
					$.ajax({
							type: "POST",
						url: "<?php echo site_url("fapplication/restore_record_status"); ?>",
						data: data,
						cache: false,
						success: function(result){
							$(ids).each(function(index, val){
								$("#ls_td_"+val).text("Allocated");
								$("#ls_td_"+val).css("color", "#3c94d6");
							});

							$("input:checkbox").prop("checked", false);
						}
					});
				}
			}

			$(document).on("click", ".open-fapplication-note", function(data)
			{
				var fapplication_id = $(this).data("fapplication_id");
				$.post("<?php echo site_url("fapplication/open_note"); ?>/" + fapplication_id, function(data)
				{
					$("#note-modal").find("#note_area").html(data.fapplication_note);
					$("#note-modal").modal();
				}, "json");
			});
			$(document).on("click","#allocation",function(){
				/*
				var st = $("#change_status").val();
				if(st =='')
				{
					alert("Select Status");
					$( "#change_status" ).focus();
					return false;
				}*/
				
				//var cnt = $("#change_count").val();
				var allto = $('#allocated_to').val();
				if(allto =='')
				{
					alert("Select Quote Specialist");
					$( "#allocated_to" ).focus();
					return false;
				}
				
				
					var ids = [];
					var tempCount = 0;
					/*$('input[type="checkbox"]:checked').each(function(index, elem) {
						if($(this).val() != "on")
							ids.push($(this).val());
					});*/
					$('input[type="checkbox"]:checked').each(function(index, elem) {
						if($(this).val() != "on")
						{
								ids.push($(this).val());
						}
						/*if(tempCount<cnt)	
						{
							ids.push($(this).val());
							tempCount++;
						}*/
							
					});
					if (ids.length <= 0) {
					  	alert("Please Select lead first");
						
						return false;
					}
					//console.log(ids);
					//return false;
					
					var data = {
						ids: ids,
						status:1,
						allto:allto,
						/*cnt:cnt*/
					};

					
					$.ajax({
						type: "POST",
						url: "<?php echo site_url("fapplication/allocation_status_change"); ?>",
						data: data,
						cache: false,
						success: function(result){
							if(result == '1' || result == 1)
							{
								alert("Leads Allocated Successfully !");
								location.reload();
							}
						}
					});
				
			});
			$(document).on("click", ".open-fapplication-details", function(data)
			{
				//alert();
				var fapplication_id = $(this).data("fapplication_id");
				var modal_data = null;
				//alert(fapplication_id);
				$.post("<?php echo site_url("fapplication/record"); ?>/" + fapplication_id, function(data)
				{
					//console.log(data);
					<?php include 'js/full_calendar.php'; ?>
					set_applicant_count_values();
					
				}, 'json');
				
			});

			$("#checkAll").change(function () {
				$("input:checkbox").prop("checked", $(this).prop("checked"));
			});
			
			
			function select_suggested_dealer (container, id_user)
			{
				if (container == "add_quote_modal")
				{
					var username = $("#"+container).find("#dealer_"+id_user).html();
					var id_quote_request = $("#"+container).find("#id_quote_request").val();
					var demo = $("#"+container).find("#demo").val();			

					var data = {
						id_user: id_user
					};

					$.ajax({
						type: "POST",
						url: "<?php echo site_url('user/get_dealer_state'); ?>",
						data: data,
						cache: false,
						success: function(response){
							$("#"+container).find("#selected_dealers .norecord").prop("hidden", true);
							$("#"+container).find("#selected_dealers").html('<tr><td><input type="hidden" value="'+id_user+'" id="dealer_id_inp" name="dealer_id">'+username+'</td><td></td></tr>');
							
							$("#"+container).find("#dealer_state").val(response);
							$("#"+container).find("#transport_checkbox").val("");
							if ($("#dealer_state").val() != $("#client_state").val() && parseInt($("#tradein_count").val()) > 0)
							{
								$("#"+container).find("#transport_checkbox_container").prop("hidden", false);
							}
							else
							{
								$("#"+container).find("#transport_checkbox_container").prop("hidden", true);
							}
							
							check_existing_quote(container);
						}
					});
				}
			else if (container == "add_dealers_modal" || container == "start_tender_modal")
				{
					var dealer_ids = $("#"+container).find("#dealer_ids_inp").val();
					var username = $("#"+container).find("#dealer_"+id_user).html();

					$("#"+container).find("#selected_dealers .norecord").prop("hidden", true);
					$("#"+container).find("#selected_dealers").append('<tr id="selected_dealer_'+id_user+'"><td width="90%">'+username+'</td><td><center><span style="cursor: pointer; cursor: hand; color: #58c603;" onclick="delete_dealer(\''+container+'\', '+id_user+')"><i class="fa fa-times"></i></span></center></td></tr>');
					
					$("#"+container).find("#dealer_ids_inp").val(dealer_ids+"-"+id_user);
					$("#"+container).find("#suggested_dealer_"+id_user).remove();

					if(container == 'add_dealers_modal') {
                    	// $("#email_dealer_trade_model").find("#dealer_id").val(id_user);
                    	get_email_template_add_dealer('add_dealers');
                    }
				}
			}

			function get_email_template_add_dealer(container)
			{
				var fq_acct_id = $("#fapplication_id").val();
			    let id_lead = $("#"+container+"_form").find("#id_lead").val();
			    let id_quote_request = $("#"+container+"_form").find("#id_quote_request").val();
			    let email_template_id = $("#"+container+"_modal").find("#email_template_id").val();
			    let dealer_id = $("#"+container+"_modal").find("#dealer_ids_inp").val();
			    
			    var data = {
			        id: email_template_id,
			        fq_acct_id: fq_acct_id,
			        id_lead: id_lead,
			        id_quote_request: id_quote_request,
			        dealer_id: dealer_id
			    };

			    let type = container.split('_')[1];

			    $('textarea.add_dealer_email_template_content').ckeditor({ 
		            height: 300,
		            allowedContent:true
		        });

		        $('#'+container+'_edit_template').show();

			    $.ajax({
			        type: "POST",
			        url: "<?php echo site_url(); ?>/fapplication/get_system_email_template/add_dealer_modal",
			        data: data,
			        cache: false,
			        dataType: 'json',
			        success: function(data){
			        	CKEDITOR.instances.add_dealer_email_template_content.setData(data.content); 
			        },
			        error: function(data) {
			        	swal("ERROR", "An error occurred! Please try again", "error");
			        }
			    });
			}
			
			function load_suggested_dealers (container)
			{
				var make = $("#"+container).find("#make_ds").val();
				var state = $("#"+container).find("#state_ds").val();
				//var postcode = $("#"+container).find("#postcode_ds").val();
				
				var data = {
					container: container,
					make: make,
					state: state,
					//postcode: postcode
				};
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("fapplication/get_suggested_dealers"); ?>",
					data: data,
					cache: false,
					success: function(response){
						//console.log(response);
						$("#"+container).find("#suggested_dealers").html("");
						$("#"+container).find("#suggested_dealers").append(response);
					}
				});
			}
			function delete_dealer (container, dealer_id)
			{
				$("#"+container).find("#selected_dealer_"+dealer_id).remove();
			}
			
			
			function load_build_dates (container, family_id, build_date)
			{
				if(family_id != "")
				{
					if (build_date == 0 || typeof(build_date) == "undefined")
					{
						$("#"+container).find("#vehicle").html("<option value='0'></option>");
						$("#"+container).find("#vehicle").prop("disabled", true);
						$("#"+container).find("#option").html("");
						
						var data = {
							family_id: family_id
						};						
					}
					else
					{
						var data = {
							family_id: family_id,
							build_date: build_date
						};						
					}

					$.ajax({
						type: "POST",
						url: "<?php echo site_url("cars/load_build_dates"); ?>",
						cache: false,
						data: data,
						success: function(response){
							$("#"+container).find("#build_date").removeAttr("disabled");
							$("#"+container).find("#build_date").html("<option value='0'></option>");
							$("#"+container).find("#build_date").append(response);
						}
					});				
				}
				var defaultParagraph = "As discussed multiple dealers will be given the opportunity to quote on your new vehicle detailed below. Please take a moment to review the details, if there is an error or an amendment required please reply to this email. To proceed click Confirm & Start Tender below to initiate the request for quotes."; // email default paragraph
				$("#email_paragraph").val(defaultParagraph);
			}
			function check_existing_quote (container)
			{		
				var id_user = $("#"+container).find("#dealer_id_inp").val();
				var id_quote_request = $("#"+container).find("#id_quote_request").val();
				var demo = $("#"+container).find("#demo").val();

				if (id_user && id_quote_request && demo && id_user != "" && id_quote_request != "" && demo != "" && id_user != "0" && id_quote_request != "0")
				{
					var data = {
						id_user: id_user,
						id_quote_request: id_quote_request,
						demo: demo
					};
					
					$.ajax({
						type: "POST",
						url: "<?php echo site_url('lead/get_dealer_existing_quote'); ?>",
						data: data,
						cache: false,
						success: function(response){
							if (response == 0)
							{
								$("#add_quote_modal").find("#quote_form_container").prop("hidden", false);
								$("#add_quote_modal").find("#quote_form_warning_container").prop("hidden", true);
								$("#add_quote_modal").find("#quote_form_warning_message").html();
								$("#add_quote_modal").find("#add_quote_submit_button").prop("disabled", false);
							}
							else
							{
								$("#add_quote_modal").find("#quote_form_container").prop("hidden", true);
								$("#add_quote_modal").find("#quote_form_warning_container").prop("hidden", false);
								$("#add_quote_modal").find("#quote_form_warning_message").html("There is already an existing "+demo+" Vehicle Quote from this Dealer");
								$("#add_quote_modal").find("#add_quote_submit_button").prop("disabled", true);
							}						
						}		
					});					
				}
			}
			$("#start_tender_form").submit(function(e) { // Reload //
				//console.log("mm - fapplication.php - 1398");return false;
				var make = $("#start_tender_form").find("#make").val();
				var family = $("#start_tender_form").find("#family").val();
				var build_date = $("#start_tender_form").find("#build_date").val();
				var vehicle = $("#start_tender_form").find("#vehicle").val();
				var colour = $("#start_tender_form").find("#colour").val();
				var registration_type = $("#start_tender_form").find("#registration_type").val();
				var rb_data =  $("#start_tender_form").find("#rb_data").val();
                var id_lead =  $("#start_tender_form").find("#id_leads").val();
				
				// alert(make);
				// alert(family);
				// alert(build_date);
				// alert(vehicle);
				// alert(colour);
				// alert(registration_type);  || build_date == 0 || build_date == "" || vehicle == 0 || vehicle == ""
				if (rb_data == "" || rb_data == 0 ||  make == 0 || make == "" || family == 0 || family == "" || colour == "" || registration_type == "")
				{
					swal("ERROR", "Please complete all the required fields!", "error");
				}
				else
				{
					$.ajax({
						type: "POST",
						url: "<?php echo site_url("fapplication/start_tender_new"); ?>",
						data: $("#start_tender_form").serialize(),
						cache: false,
						success: function(response) {
							//console.log(response); 
							var res = response.trim();
							if (res === "success" || res === "successsuccess")
							{
								$("#start_tender_modal").find("#selected_dealers").html("");
								$("#start_tender_modal").find("#suggested_dealers").html("");
								$("#start_tender_modal").find("input,textarea,select").val("");
								$("#start_tender_modal").find("#dealer_ids_inp").val("0");
								$("#start_tender_modal").modal("hide");

								swal("SUCCESS", "", "success");
								//location.reload(true);
                                $.post("<?php echo site_url("fapplication/record"); ?>/" + id_lead, function(data) {
                                    //console.log(data);
                                    <?php $this->load->view('admin/js/full_calendar'); ?>
                                    set_applicant_count_values();
                                    set_car_data();
                                    //historical_quotes_table.draw();
                                }, 'json');


                                setTimeout(function(){
                                    historical_quotes_datatable(id_lead);
                                }, 2000);
							}
							else
							{
								swal("ERROR", "An error occurred! Please contact the administrator", "error");
							}							
						}
					});
				}
				e.preventDefault();
			});			
		</script>
	</body>
</html>
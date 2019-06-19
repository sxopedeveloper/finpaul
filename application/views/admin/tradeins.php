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
						<form  id="main_list_filter_form"  action="<?php echo site_url('tradein/list_view'); ?>" method="GET" accept-charset="utf-8">
							<div class="panel-body">
								<h5><b>Search Filters</b></h5>
								<?php
								$ti_number = isset($_GET['ti_number']) ? $_GET['ti_number'] : '';
								$status = isset($_GET['status']) ? $_GET['status'] : '';

								$email = isset($_GET['email']) ? $_GET['email'] : '';		
								$name = isset($_GET['name']) ? $_GET['name'] : '';
								$phone = isset($_GET['phone']) ? $_GET['phone'] : '';

								$registration_plate = isset($_GET['registration_plate']) ? $_GET['registration_plate'] : '';
								$state = isset($_GET['state']) ? $_GET['state'] : '';
								$postcode = isset($_GET['postcode']) ? $_GET['postcode'] : '';
									
								$make = isset($_GET['make']) ? $_GET['make'] : '';
								$model = isset($_GET['model']) ? $_GET['model'] : '';
								$variant = isset($_GET['variant']) ? $_GET['variant'] : '';

								$selected_status_1 = ""; if ($status == "1") { $selected_status_1 = " selected"; }
								$selected_status_2 = ""; if ($status == "2") { $selected_status_2 = " selected"; }
								$selected_status_3 = ""; if ($status == "3") { $selected_status_3 = " selected"; }
								$selected_status_4 = ""; if ($status == "4") { $selected_status_4 = " selected"; }
								$selected_status_5 = ""; if ($status == "5") { $selected_status_5 = " selected"; }

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
									if ($admin_type==2)
									{
										?>
										<div class="col-md-2">
											<input type="text" class="form-control mb-md" name="ti_number" title="TI Number" placeholder="TI Number" value="<?php echo $ti_number;?>">
										</div>
										<div class="col-md-2">
											<input type="text" class="form-control mb-md" name="email" title="Client Email Address" placeholder="Client Email Address" value="<?php echo $email;?>">
										</div>									
										<div class="col-md-2">
											<input type="text" class="form-control mb-md" name="name" title="Client Name" placeholder="Client Name" value="<?php echo $name;?>">
										</div>
										<div class="col-md-2">
											<input type="text" class="form-control mb-md" name="phone" title="Client Phone" placeholder="Client Phone" value="<?php echo $phone;?>">
										</div>
										<div class="col-md-2">
											<input type="text" class="form-control mb-md" name="registration_plate" title="Registration Plate" placeholder="Registration Plate" value="<?php echo $registration_plate; ?>">
										</div>									
										<div class="col-md-2">
											<select class="form-control mb-md" name="state" id="state_dropdown" title="Client State">
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
										<div class="col-md-2">
											<input type="text" class="form-control mb-md" name="postcode" title="Client Postcode" placeholder="Client Postcode" value="<?php echo $postcode;?>">
										</div>
										<div class="col-md-2">
											<select class="form-control mb-md" name="status" title="Lead Status">
												<option name="status" value="1" <?php echo $selected_status_1; ?>>Cars Submitted for Valuation</option>
												<option name="status" value="2" <?php echo $selected_status_2; ?>>Tendering Currently (Needs Urgent Valuation)</option>
												<option name="status" value="3" <?php echo $selected_status_3; ?>>Confirmed as Trade</option>
												<option name="status" value="4" <?php echo $selected_status_4; ?>>Valuations with Winners</option>
												<option name="status" value="5" <?php echo $selected_status_5; ?>>Cars Delivered</option>
											</select>
										</div>										
										<?php
									}
									else
									{
										?>
										<div class="col-md-2">
											<select class="form-control mb-md" name="status" title="Lead Status">
												<option name="status" value="1" <?php echo $selected_status_1; ?>>Cars Submitted for Valuation</option>
												<option name="status" value="2" <?php echo $selected_status_2; ?>>Tendering Currently (Needs Urgent Valuation)</option>
												<option name="status" value="3" <?php echo $selected_status_3; ?>>Confirmed as Trade</option>
												<option name="status" value="4" <?php echo $selected_status_4; ?>>Valuations Won</option>
												<option name="status" value="5" <?php echo $selected_status_5; ?>>Cars Delivered</option>
											</select>
										</div>
										<?php
									}
									?>
									<div class="col-md-2">
										<input type="text" class="form-control mb-md" name="make" id="make" title="Make" placeholder="Make" value="<?php echo $make;?>">
									</div>
									<div class="col-md-2">
										<input type="text" class="form-control mb-md" name="model" id="model" title="Model" placeholder="Model" value="<?php echo $model;?>">
									</div>
									<div class="col-md-2">
										<input type="text" class="form-control mb-md" name="variant" id="variant" title="Variant" placeholder="Variant" value="<?php echo $variant;?>">
									</div>			
								</div>
								<div class="form-group">		
									
									<?php
									if ($admin_type == 2)
									{ ?>													
										<div class="col-md-2 pull-right">
											<button type="button" class="btn btn-primary search-filter-btn  col-md-12 col-sm-12 col-xs-12" onClick="delete_tradeins()">Delete</button>
										</div>
									<?php
									}
									?>	
									<div class="col-md-2 pull-right">
										<input value="Apply Filters" name="submit" class="btn btn-primary search-filter-btn  col-md-12 col-sm-12 col-xs-12" type="submit">
									</div>
								</div>
							</div>
							
						</form>
					</section>
					<section class="panel" id="tableData">
						<div class="panel-body">
							<div class="table-responsive">
								<?php
								if (count($tradeins)==0)
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
												if ($login_type=="Admin")						
												{
													?>
													<td></td>
													<?php													
												}
												?>
												<td><b>TI Number</b></td>
												<td><b>Submitted</b></td>
												<td><b>Arrival Date</b></td>
												<td><b>Consultant Name</b></td>
												<td><b>Consultant Mobile</b></td>
												<?php
												if ($login_type=="Admin")						
												{
													?>
													<td><b>Status</b></td>
													<td><b>Valuations</b></td>
													<td><b>Highest Valuation</b></td>
													<td><b>Winning Valuation</b></td>
													<td><b>Buyer</b></td>
													<?php
													if ($admin_type==2)
													{
														?>
														<td><b>Trade Value</b></td>
														<?php
													}
													?>
													<td><b>Client Name</b></td>
													<td><b>Email</b></td>
													<td><b>Phone</b></td>
													<td><b>State</b></td>
													<td><b>Postcode</b></td>
													<?php													
												}
												else
												{
													?>
													<td><b>My Valuation</b></td>
													<?php
												}
												?>
												<td><b>Make</b></td>
												<td><b>Model</b></td>
												<td><b>Build Date</b></td>
												<td><b>Variant</b></td>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach ($tradeins as $tradein)
											{
												?>
												<tr id="tradein_row_<?php echo $tradein['id_tradein']; ?>">
													<?php
													if ($login_type=="Admin")						
													{
														?>
														<td>
															<input type="checkbox" value="<?php echo $tradein['id_tradein']; ?>">
														</td>
														<?php													
													}
													?>
													<td>
														<a href="<?php echo site_url('tradein/record_final/'.$tradein['id_tradein']); ?>" target="_blank">
															<?php echo $tradein['ti_number']; ?>
														</a>
													</td>
													<td><?php echo $tradein['created_at']; ?></td>													
													<td><?php echo $tradein['delivery_date']; ?></td>
													<td><?php echo $tradein['consultant_name']; ?></td>
													<td><?php echo $tradein['consultant_mobile']; ?></td>													
													<?php
													if ($login_type=="Admin")
													{
														if ($tradein['status'] == 0) 
														{
															$css = 'style="color: #57DC75"'; 
														}
														else if ($tradein['status'] == 1)
														{
															$css = 'style="color: #9933cc"'; 
														}
														else 
														{
															$css = ''; 
														}
														?>
														<td id="ls_td_<?php echo $tradein['id_tradein']; ?>" <?php echo $css; ?>>
															<?php echo $tradein['status_text']; ?>
														</td>
														<td><?php echo $tradein['valuations']; ?></td>
														<td><?php echo $tradein['highest_valuation']; ?></td>
														<td><?php echo $tradein['trade_value']; ?></td>
														<td id="ti_buyer_<?php echo $tradein['id_tradein']; ?>"><?php echo $tradein['buyer']; ?></td>
														<?php
														if ($admin_type==2)
														{
															?>
															<td id="ti_trade_value_<?php echo $tradein['id_tradein']; ?>"><?php echo $tradein['trade_value']; ?></td>
															<?php
														}
														?>
														<td><?php echo $tradein['name']; ?></td>
														<td><a href="mailto:<?php echo $tradein['email']; ?>" target="_top"><?php echo $tradein['email']; ?></a></td>
														<td><?php echo $tradein['phone']; ?></td>
														<td><?php echo $tradein['state']; ?></td>
														<td><?php echo $tradein['postcode']; ?></td>
														<?php
													}
													else
													{
														?>
														<td id="ti_my_valuation_<?php echo $tradein['id_tradein']; ?>"><?php echo $tradein['my_valuation']; ?></td>
														<?php
													}
													?>
													<td><?php echo $tradein['tradein_make']; ?></td>
													<td><?php echo $tradein['tradein_model']; ?></td>
													<td><?php echo $tradein['tradein_build_date']; ?></td>
													<td><?php echo $tradein['tradein_variant']; ?></td>
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
				</section>
			</div>
			<?php include 'template/right_sidebar.php'; ?>
		</section>
		<?php include 'template/scripts.php'; ?>
	</body>
</html>
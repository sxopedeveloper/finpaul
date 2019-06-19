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
		
		.container_bordered_round {
			padding: 20px; 
			border: 1px solid #ccc;			
			border-radius: 5px;
		}
	</style>
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
						<form action="<?php echo site_url('quote/search'); ?>" method="get" accept-charset="utf-8">
							<div class="panel-body">
								<div class="form-group">
									<?php
									$quote_number = isset($_GET['quote_number']) ? $_GET['quote_number'] : '';
									$quote_specialist = isset($_GET['quote_specialist']) ? $_GET['quote_specialist'] : '';
									$client_name = isset($_GET['client_name']) ? $_GET['client_name'] : '';
									$client_email = isset($_GET['client_email']) ? $_GET['client_email'] : '';
									
									$make_value = isset($_GET['make']) ? $_GET['make'] : '';
									$model_value = isset($_GET['model']) ? $_GET['model'] : '';
									$build_date_value = isset($_GET['build_date']) ? $_GET['build_date'] : '';
									$variant_value = isset($_GET['vehicle']) ? $_GET['vehicle'] : '';
									
									$series = isset($_GET['series']) ? $_GET['series'] : '';
									$body_type = isset($_GET['body_type']) ? $_GET['body_type'] : '';
									$transmission = isset($_GET['transmission']) ? $_GET['transmission'] : '';
									$colour = isset($_GET['colour']) ? $_GET['colour'] : '';
									$fuel_type = isset($_GET['fuel_type']) ? $_GET['fuel_type'] : '';
									$postcode = isset($_GET['postcode']) ? $_GET['postcode'] : '';
									$state = isset($_GET['state']) ? $_GET['state'] : '';
									$dealership_name = isset($_GET['dealership_name']) ? $_GET['dealership_name'] : '';
									$manager_name = isset($_GET['manager_name']) ? $_GET['manager_name'] : '';
									$username = isset($_GET['username']) ? $_GET['username'] : '';
									
									$winner = isset($_GET['winner']) ? $_GET['winner'] : '';
									?>
									<div class="col-md-6 text-left">
										<label>CQ Number:</label>
										<input value="<?php echo $quote_number; ?>" class="form-control input-md" id="quote_number" name="quote_number" type="text"><br />
									</div>			
									<div class="col-md-6 text-left">
										<label>Quote Specialist Email:</label>
										<input value="<?php echo $quote_specialist; ?>" class="form-control input-md" id="quote_specialist" name="quote_specialist" type="text"><br />
									</div>
									
									<div class="col-md-3 text-left">
										<label>Client Email:</label>
										<input value="<?php echo $client_email; ?>" class="form-control input-md" id="client_email" name="client_email" type="text"><br />
									</div>
									<div class="col-md-3 text-left">
										<label>Client Name:</label>
										<input value="<?php echo $client_name; ?>" class="form-control input-md" id="client_name" name="client_name" type="text"><br />
									</div>
									<div class="col-md-3 text-left">
										<label>Postcode:</label>
										<input value="<?php echo $postcode; ?>" class="form-control input-md" id="postcode" name="postcode" type="text"><br />
									</div>
									<div class="col-md-3 text-left">
										<label>State:</label>
										<input value="<?php echo $state; ?>" class="form-control input-md" id="state" name="state" type="text"><br />
									</div>

									<div class="col-md-3 text-left">
										<label>Make:</label>				
										<select class="form-control" id="make_dropdown" name="make" title="Make" onchange="load_families(this.options[this.selectedIndex].value)">
											<option name="make" value=""></option>
											<?php 
											foreach ($makes as $make)
											{
												$selected_make = "";
												if ($make->id_make == $make_value) { $selected_make = " selected "; }
												?>
												<option name="make" value="<?php echo $make->id_make; ?>" <?php echo $selected_make; ?>>
													<?php echo $make->name; ?>
												</option>
												<?php
											}
											?>
										</select>
										<br />
									</div>
									<div class="col-md-3 text-left">
										<label>Model:</label>										
										<select class="form-control" id="family_dropdown" name="family" title="Model" onchange="load_build_dates(this.options[this.selectedIndex].value)" disabled>
											<option name="family" value=""><span id="family_loader"></span></option>
										</select>
										<br />
									</div>
									<div class="col-md-3 text-left">
										<label>Build Date:</label>
										<select class="form-control" id="build_date_dropdown" name="build_date" title="Build Date" onchange="load_vehicles(this.options[this.selectedIndex].value)" disabled>
											<option name="build_date" value=""><span id="build_date_loader"></span></option>
										</select>
										<br />
									</div>													
									<div class="col-md-3 text-left">
										<label>Variant:</label>
										<select class="form-control" id="vehicle_dropdown" name="vehicle" title="Variant" disabled>
											<option name="vehicle" value=""><span id="vehicle_loader"></span></option>
										</select>
										<br />
									</div>

									<div class="col-md-6 text-left">
										<label>Series:</label>
										<input value="<?php echo $series; ?>" class="form-control input-md" id="series" name="series" type="text"><br />
									</div>
									<div class="col-md-6 text-left">
										<label>Body Type:</label>
										<input value="<?php echo $body_type; ?>" class="form-control input-md" id="body_type" name="body_type" type="text"><br />
									</div>

									<div class="col-md-4 text-left">
										<label>Transmission:</label>
										<input value="<?php echo $transmission; ?>" class="form-control input-md" id="transmission" name="transmission" type="text"><br />
									</div>
									<div class="col-md-4 text-left">
										<label>Colour:</label>
										<input value="<?php echo $colour; ?>" class="form-control input-md" id="colour" name="colour" type="text"><br />
									</div>
									<div class="col-md-4 text-left">
										<label>Fuel Type:</label>
										<input value="<?php echo $fuel_type; ?>" class="form-control input-md" id="fuel_type" name="fuel_type" type="text"><br />
									</div>
									
									<div class="col-md-4 text-left">
										<label>Dealership Name:</label>
										<input value="<?php echo $dealership_name; ?>" class="form-control input-md" id="dealership_name" name="dealership_name" type="text"><br />
									</div>
									<div class="col-md-4 text-left">
										<label>Fleet Manager:</label>
										<input value="<?php echo $manager_name; ?>" class="form-control input-md" id="manager_name" name="manager_name" type="text"><br />
									</div>
									<div class="col-md-4 text-left">
										<label>Dealer Email:</label>
										<input value="<?php echo $username; ?>" class="form-control input-md" id="username" name="username" type="text"><br />
									</div>									

									<?php 
									$winner_checked = "";
									if ($winner == 1)
									{
										$winner_checked = " checked";
									}
									?>

									<div class="col-md-12 text-right">
										<input type="checkbox" name="winner" id="winner" value="1" <?php echo $winner_checked; ?>> Winning Quotes Only
									</div>
									<div class="col-md-12 text-center">
										<br />
										<input value="Search" name="submit" class="btn btn-primary pull-right push-bottom" type="submit">
									</div>
								</div>
							</div>
						</form>
					</section>
					<section class="panel">
						<div class="panel-body">
							<div class="table-responsive">
								<?php
								if (count($quotes)==0)
								{
									echo "<br /><center><i>No results found!</i></center><br /><br /><br /><br />";
								}
								else
								{
								?>
									<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
										<thead>
											<tr>
												<td><i class="fa fa-desktop"></i></td>
												<?php
												if ($admin_type == 2)
												{
													?>
													<th></th>
													<?php
												}
												?>
												<td><b><i class="fa fa-trophy"></i></b></td>
												<td><b>Quote Number</b></td>
												<td><b>Consultant</b></td>
												<td><b>Registration</b></td>												
												<td><b>Client Name</b></td>
												<td><b>Client Email</b></td>
												<td><b>Dealer</b></td>
												<td><b>List Price</b></td>
												<td><b>Total Price</b></td>
												<td><b>Make</b></td>
												<td><b>Model</b></td>
												<td><b>Build Date</b></td>
												<td><b>Variant</b></td>
												<td><b>Series</b></td>
												<td><b>Body Type</b></td>
												<td><b>Transmission</b></td>
												<td><b>Colour</b></td>
												<td><b>Fuel Type</b></td>
												<td><b>Postcode</b></td>
												<td><b>State</b></td>
												<td><b>Date</b></td>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach ($quotes as $quote)
											{
											?>
												<tr>
													<td>
														<span class="ajax_button_primary quote_modal_button" data-id_lead="<?php echo $quote['id_lead']; ?>" data-id_quote_request="<?php echo $quote['id_quote_request']; ?>" data-id_quote="<?php echo $quote['id_quote']; ?>" data-process="view">
															<i class="fa fa-edit" data-toggle="tooltip" title="View Quote"></i>
														</span>
													</td>
													<?php
													if ($admin_type == 2)
													{
														echo '
														<td>
															<a href="'.site_url('quote/delete/'.$quote['id_quote']).'">
																<i class="fa fa-trash-o" data-toggle="tooltip" data-placement="top" title="Delete Quote"></i>
															</a>
														</td>';
													}
													?>
													<td>
														<b>
															<?php 
															if ($quote['winner'] > 0)
															{
																echo ' <i class="fa fa-trophy"></i>';
															}
															?>
														</b>
													</td>
													<td><?php echo $quote['quote_number']; ?></td>
													<td><?php echo $quote['quote_specialist']; ?></td>
													<td><?php echo $quote['registration_type']; ?></td>
													<td><?php echo $quote['client_name']; ?></td>
													<td><?php echo $quote['client_email']; ?></td>
													<td><?php echo $quote['dealer']; ?></td>
													<td><?php echo $quote['list_price']; ?></td>
													<td><?php echo $quote['total']; ?></td>
													<td><?php echo $quote['make']; ?></td>
													<td><?php echo $quote['model']; ?></td>
													<td><?php echo $quote['build_date']; ?></td>
													<td><?php echo $quote['variant']; ?></td>
													<td><?php echo $quote['series']; ?></td>
													<td><?php echo $quote['body_type']; ?></td>
													<td><?php echo $quote['transmission']; ?></td>
													<td><?php echo $quote['colour']; ?></td>
													<td><?php echo $quote['fuel_type']; ?></td>
													<td><?php echo $quote['postcode']; ?></td>
													<td><?php echo $quote['state']; ?></td>
													<td><?php echo $quote['created_at']; ?></td>
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
					<?php include 'template/modals.php'; ?>
				</section>
			</div>
			<?php include 'template/right_sidebar.php'; ?>
		</section>
		<?php include 'template/scripts.php'; ?>
		<script>
			function load_families (make_id)
			{
				$("#build_date_dropdown").html("<option name='build_date' value=''></option>");
				$("#build_date_dropdown").prop("disabled", true);
				$("#vehicle_dropdown").html("<option name='vehicle' value=''></option>");
				$("#vehicle_dropdown").prop("disabled", true);	
				
				if (make_id != "")
				{			
					var dataString = "&make_id="+make_id;
					$("#family_loader").show();
					$("#family_loader").fadeIn(400).html("Loading...");
					$.ajax({
						type: "POST",
						url: "<?php echo site_url('cars/load_families'); ?>",
						data: dataString,
						cache: false,
						success: function(result){
							$("#family_loader").hide();
							$("#family_dropdown").removeAttr("disabled");
							$("#family_dropdown").html("<option name='family' value=''></option>");
							$("#family_dropdown").append(result);
						}
					});
				}
			}
			
			function load_build_dates (family_id)
			{
				$("#vehicle_dropdown").html("<option name='vehicle' value=''></option>");
				$("#vehicle_dropdown").prop("disabled", true);
				
				if (family_id != "")
				{
					var dataString = "&family_id="+family_id;
					$("#build_date_loader").show();
					$("#build_date_loader").fadeIn(400).html("Loading...");
					$.ajax({
						type: "POST",
						url: "<?php echo site_url("cars/load_build_dates"); ?>",
						data: dataString,
						cache: false,
						success: function(result){
							$("#build_date_loader").hide();
							$("#build_date_dropdown").removeAttr("disabled");
							$("#build_date_dropdown").html("<option name='build_date' value=''></option>");
							$("#build_date_dropdown").append(result);
						}
					});				
				}
			}			
			
			function load_vehicles (code)
			{
				if (code != "")
				{
					var dataString = "&code="+code;
					$("#vehicle_loader").show();
					$("#vehicle_loader").fadeIn(400).html("Loading...");
					$.ajax({
						type: "POST",
						url: "<?php echo site_url("cars/load_vehicles"); ?>",
						data: dataString,
						cache: false,
						success: function(result){
							$("#vehicle_loader").hide();
							$("#vehicle_dropdown").removeAttr("disabled");
							$("#vehicle_dropdown").html("<option name='vehicle' value=''></option>");
							$("#vehicle_dropdown").append(result);
						}
					});				
				}
			}			
		</script>
	</body>
</html>
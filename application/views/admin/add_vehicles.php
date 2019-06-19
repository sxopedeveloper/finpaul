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
							<h2 class="panel-title">New Vehicle Information</h2>
						</header>
						<div class="panel-body">
							<form action="" method="POST" class="form-horizontal" role="form">
								<div class="featured-box featured-box-secundary default">
									<div class="box-content">
										<div class="toogle" data-plugin-toggle="">
											<section class="toggle">
												<label>Add Make</label>
												<div class="toggle-content">
													<form name="makes" method="post">
														<div class="form-group">
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> Name : </label>
																<input class="form-control input-sm" id="make_name" name="make_name" type="text" required>
															</div>
														</div>
														<br/>
														<span class="btn btn-primary btn-sm" id="submit_make">Submit</span>
													</form>
												</div>
											</section>
											<section class="toggle">
												<label>Add Model</label>
												<div class="toggle-content">
													<form name="makes" method="post">
														<div class="form-group">
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> Vehicle Type : </label>
																<select class="form-control input-sm" name="fk_vehicle_type">
																	<option value="1">Passenger</option>
																	<option value="2">Light Commercial</option>
																	<option value="3">Heavy Commercial</option>
																	<option value="4">Passenger and Light Commercial (Combined)</option>
																</select>
															</div>
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> Makes : </label>
																<select class="form-control input-sm" name="fk_make">
																	<option></option>
																<?php
																	foreach ($makes as $make_key => $make_val) 
																	{
																		echo "<option value='{$make_val['id_make']}'>{$make_val['name']}</option>";
																	}
																?>
																</select>
															</div>
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> Name : </label>
																<input class="form-control input-sm" name="model_name" type="text" required>
															</div>
														</div>
														<div class="form-group">
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> Latest Year : </label>
																<select class="form-control input-sm" name="latest_year">
																<?php
																	$curr_year = date('Y');

																	$adv_year = (int)$curr_year + 1;
																	echo "<option val='{$adv_year}'>{$adv_year}</option>";

																	for ($i=0; $i < 46; $i++) 
																	{
																		$year_now = (int)$curr_year - $i;
																		echo "<option val='{$year_now}'>{$year_now}</option>";
																	}
																?>
																</select>
															</div>
														</div>
														<br/>
														<span class="btn btn-primary btn-sm" id="submit_model">Submit</span>
													</form>
												</div>
											</section>
											<section class="toggle">
												<label>Add Variant</label>
												<div class="toggle-content">
													<form name="makes" method="post">
														<div class="form-group">
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> Makes : </label>
																<select class="form-control input-sm make">
																	<option></option>
																	<?php
																	foreach ($makes as $make_key => $make_val) 
																	{
																		echo "<option value='{$make_val['id_make']}'>{$make_val['name']}</option>";
																	}
																	?>
																</select>
															</div>
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> Family : </label>
																<select class="form-control input-sm model" name="fk_family">
																
																</select>
															</div>
															<div class="col-md-4 text-left">
																<label><font color="red">*</font>  Year : </label>
																<select class="form-control input-sm" name="vehicle_year">
																<?php
																	$curr_year = date('Y');

																	$adv_year = (int)$curr_year + 1;
																	echo "<option val='{$adv_year}'>{$adv_year}</option>";

																	for ($i=0; $i < 46; $i++) 
																	{
																		$year_now = (int)$curr_year - $i;
																		echo "<option val='{$year_now}'>{$year_now}</option>";
																	}
																?>
																</select>
															</div>
														</div>
														<div class="form-group">
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> Name : </label>
																<input class="form-control input-sm" name="vehicle_name" type="text" required>
															</div>
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> Series : </label>
																<input class="form-control input-sm" name="series" type="text" required>
															</div>
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> Body Style : </label>
																<input class="form-control input-sm" name="bodystyle" type="text" required>
															</div>
														</div>
														<div class="form-group">
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> Transmission : </label>
																<input class="form-control input-sm" name="transmission" type="text" required>
															</div>
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> Fuel Type : </label>
																<input class="form-control input-sm" name="fueltype" type="text" required>
															</div>
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> New Price : </label>
																<input class="form-control input-sm" name="newprice" type="text" required onkeypress="return isNumberKey(event)">
															</div>
														</div>
														<br/>
														<span class="btn btn-primary btn-sm" id="submit_vehicle">Submit</span>
													</form>
												</div>
											</section>
											<section class="toggle">
												<label>Add Option</label>
												<div class="toggle-content">
													<form name="makes" method="post">
														<div class="form-group">
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> Makes : </label>
																<select class="form-control input-sm make">
																	<option></option>
																	<?php
																	foreach ($makes as $make_key => $make_val) 
																	{
																		echo "<option value='{$make_val['id_make']}'>{$make_val['name']}</option>";
																	}
																	?>
																</select>
															</div>
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> Family : </label>
																<select class="form-control input-sm model">
																
																</select>
															</div>
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> Vehicles : </label>
																<select class="form-control input-sm variant" name="fk_vehicle">

																</select>
															</div>
														</div>
														<div class="form-group">
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> Name : </label>
																<input class="form-control input-sm" name="option_name" type="text" required>
															</div>
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> Items : </label>
																<input class="form-control input-sm" name="option_items" type="text" required>
															</div>
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> Add/Deduct : </label>
																<select class="form-control input-sm" name="adddeduct">
																	<option value="A">Add</option>
																	<option value="D">Deduct</option>
																</select>
															</div>
														</div>
														<div class="form-group">
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> New Price : </label>
																<input class="form-control input-sm" name="option_newprice" type="text" required onkeypress="return isNumberKey(event)">
															</div>
														</div>
														<br/>
														<span class="btn btn-primary btn-sm" id="submit_option">Submit</span>
													</form>
												</div>
											</section>
										</div>
									</div>
								</div>
							</form>
							
						</div>
					</section>
					<!-- end: page -->
					<?php include 'modals/ticket_modals.php'; ?>
				</section>
			</div>
			<?php include 'template/right_sidebar.php'; ?>
		</section>
		<?php include 'template/scripts.php'; ?>
		<script type="text/javascript">
			$(document).ready(function(){
				$(document).on('click', '#submit_make', function(){
					var data = $(this).closest("form").serialize();

					$.ajax({
						type: "POST",
						url: "<?php echo site_url("add_vehicle/add_make"); ?>",
						cache: false,
						data: data,
						success: function(response){
							alert("Inserted to database successfully!");
							$(document).find("input").val("");
						}
					});
				});

				$(document).on('click', '#submit_model', function(){
					var data = $(this).closest("form").serialize();

					$.ajax({
						type: "POST",
						url: "<?php echo site_url("add_vehicle/add_model"); ?>",
						cache: false,
						data: data,
						success: function(response){
							alert("Inserted to database successfully!");
							$(document).find("input").val("");
							location.reload();
						}
					});
				});

				$(document).on('click', '#submit_vehicle', function(){
					var data = $(this).closest("form").serialize();

					$.ajax({
						type: "POST",
						url: "<?php echo site_url("add_vehicle/add_vehicles"); ?>",
						cache: false,
						data: data,
						success: function(response){
							alert("Inserted to database successfully!");
							$(document).find("input").val("");
							location.reload();
						}
					});
				});

				$(document).on('click', '#submit_option', function(){
					var data = $(this).closest("form").serialize();

					$.ajax({
						type: "POST",
						url: "<?php echo site_url("add_vehicle/add_option"); ?>",
						cache: false,
						data: data,
						success: function(response){
							alert("Inserted to database successfully!");

							$(document).find("input").val("");
							location.reload();
						}
					});
				});

				$(document).on('change', '.make', function(){
					var selected = $(this).find('option:selected');

					var id = $(this).val();
					var that = $(this);

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
								option = option+'<option data-id="'+result[i].id_family+'" value="'+result[i].id_family+'">'+result[i].name+'</option>';
							}

							$(document).find($(that)).closest("section").find('.model').html(option);
						}
					});
				});

				$(document).on('change', '.model', function(){
					var selected = $(this).find('option:selected');
					var id = selected.data('id');
					var that = $(this);
					
					var data = {
						code: 3,
						id_model: id
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
								option = option+'<option data-id="'+result[i].id_vehicle+'" value="'+result[i].id_vehicle+'">'+result[i].name+'</option>';
							}

							$(document).find($(that)).closest("section").find('.variant').html(option);
						}
					});
				});
			});
		</script>
	</body>
</html>
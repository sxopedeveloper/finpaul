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
						<?php 
						if ($this->session->flashdata('message') == "success")
						{
							?>
							<div class="alert alert-success alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<strong>Success!</strong> Data successfully added to database!
							</div>
							<?php 
						}
						?>
						<header class="panel-heading">
							<div class="panel-actions">
								<a href="#" class="fa fa-caret-down"></a>
							</div>
							<h2 class="panel-title">New Trade in</h2>
						</header>
						<div class="panel-body">
							<form action="" method="POST" class="form-horizontal" role="form" id="tradein_form_main">
								<div class="featured-box featured-box-secundary default">
									<div class="box-content">
										<div class="toogle" data-plugin-toggle="">
											<section class="toggle active">
												<label>PERSONAL INFORMATION</label>
												<div class="toggle-content" style="display: block;">
													<p>
														<div class="form-group">
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> Email Address:</label>
																<input class="form-control input-sm" id="email" name="email" type="text" required>
															</div>									
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> First Name:</label>
																<input class="form-control input-sm" id="first_name" name="first_name" type="text" required>
															</div>
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> Last Name:</label>
																<input class="form-control input-sm" id="last_name" name="last_name" type="text" required>
															</div>										
														</div>
														<div class="form-group">									
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> Phone:</label>
																<input class="form-control input-sm" id="phone" name="phone" type="text" required>
															</div>					
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> Postcode:</label>
																<input class="form-control input-sm" id="postcode" name="postcode" type="text" required>
															</div>
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> State:</label>
																<select class="form-control input-sm" name="state" title="State">
																	<option name="state" value=""></option>
																	<option name="state" value="ACT">
																		ACT - Australian Capital Territory
																	</option>
																	<option name="state" value="NSW">
																		NSW - New South Wales
																	</option>
																	<option name="state" value="NT">
																		NT - Northern Territory
																	</option>
																	<option name="state" value="QLD">
																		QLD - Queensland
																	</option>
																	<option name="state" value="SA">
																		SA - South Australia
																	</option>
																	<option name="state" value="TAS">
																		TAS - Tasmania
																	</option>
																	<option name="state" value="VIC">
																		VIC - Victoria
																	</option>
																	<option name="state" value="WA">
																		WA - Western Australia
																	</option>
																</select>																		
															</div>
														</div>
													</p>
												</div>
											</section>
											<section class="toggle active">
												<label>CAR DETAILS</label>
												<div class="toggle-content" style="display: block;">
													<p>
														<div class="form-group">
															<div class="col-md-3 text-left">
																<label><font color="red">*</font> Registration Plate:</label>
																<input class="form-control input-sm" id="registration_plate" name="registration_plate" type="text" required>
															</div>									
															<div class="col-md-3 text-left">
																<label><font color="red">*</font> Rego Expiry:</label>
																<input class="form-control input-sm" id="rego_expiry" name="rego_expiry" type="text" required>
															</div>
															<div class="col-md-3 text-left">
																<label><font color="red">*</font> Vin:</label>
																<input class="form-control input-sm" id="tradein_vin" name="tradein_vin" type="text" required>
															</div>
															<div class="col-md-3 text-left">
																<label><font color="red">*</font> Engine No.:</label>
																<input class="form-control input-sm" id="tradein_eng" name="tradein_eng" type="text" required>
															</div>
														</div>
														<hr />
														<div class="form-group">
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> Make:</label>
																<input class="form-control input-sm" id="tradein_make" name="tradein_make" type="text" required>
															</div>
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> Model:</label>
																<input class="form-control input-sm" id="tradein_model" name="tradein_model" type="text" required>
															</div>
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> Variant:</label>
																<input class="form-control input-sm" id="tradein_variant" name="tradein_variant" type="text" required>
															</div>										
														</div>
														<div class="form-group">
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> Build Date:</label>
																<input class="form-control input-sm" id="tradein_build_date" name="tradein_build_date" type="text" required>
															</div>
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> Compliance Date:</label>
																<input class="form-control input-sm" id="tradein_compliance_date" name="tradein_compliance_date" type="text" required>
															</div>																	
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> Kms:</label>
																<input class="form-control input-sm" id="tradein_kms" name="tradein_kms" type="text" required>
															</div>					
														</div>
														<div class="form-group">
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> Fuel Type:</label>
																<input class="form-control input-sm" id="tradein_fuel_type" name="tradein_fuel_type" type="text" required>
															</div>																
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> Body Shape:</label>
																<input class="form-control input-sm" id="tradein_body_type" name="tradein_body_type" type="text" required>
															</div>
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> Colour:</label>
																<input class="form-control input-sm" id="tradein_colour" name="tradein_colour" type="text" required>
															</div>								
														</div>
														<div class="form-group">
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> Drive Type:</label>
																<input class="form-control input-sm" id="tradein_drive_type" name="tradein_drive_type" type="text" required>
															</div>																
															<div class="col-md-4 text-left">
																<label><font color="red">*</font> Transmission:</label>
																<input class="form-control input-sm" id="tradein_transmission" name="tradein_transmission" type="text" required>
															</div>
														</div>
														<br />
														<div class="form-group">
															<div class="col-md-12 text-left">
																<label>Service History:</label>
																<textarea class="form-control input-sm" id="tradein_service_history" name="tradein_service_history"></textarea>
															</div>									
														</div>
														<div class="form-group">
															<div class="col-md-12 text-left">
																<label>Vehicle Options:</label>
																<textarea class="form-control input-sm" id="options_1" name="options_1"></textarea>
															</div>									
														</div>
														<div class="form-group">
															<div class="col-md-12 text-left">
																<label>Accessories:</label>
																<textarea class="form-control input-sm" id="accessories_1" name="accessories_1"></textarea>
															</div>									
														</div>
														<br />
														<div class="form-group">
															<label class="col-md-4 control-label" for="">
																<font color="red"></font> Warning lights while vehicle is running?<br>
															</label>
															<div class="col-md-8">
																<div class="row">
																	<div class="col-md-2">
																		<input type="radio" name="warning_lights" id="warning_lights" value="Yes"> Yes
																	</div>
																	<div class="col-md-2">
																		<input type="radio" name="warning_lights" id="warning_lights" value="No"> No
																	</div>
																</div>
															</div>
														</div>	
														<hr />
														<div class="form-group">
															<label class="col-md-4 control-label" for="">
																<font color="red"></font> Is there existing damage on the vehicle?<br>
															</label>
															<div class="col-md-8">
																<div class="row">
																	<div class="col-md-2">
																		<input type="radio" name="damage" id="damage" value="Yes"> Yes
																	</div>
																	<div class="col-md-2">
																		<input type="radio" name="damage" id="damage" value="No"> No
																	</div>
																</div>
															</div>
														</div>			
														<hr />
														<div class="form-group">
															<label class="col-md-4 control-label" for="">
																<font color="red"></font> Was your vehicle ever a lease or rental?<br>
															</label>
															<div class="col-md-8">
																<div class="row">
																	<div class="col-md-2">
																		<input type="radio" name="lease" id="lease" value="Yes"> Yes
																	</div>
																	<div class="col-md-2">
																		<input type="radio" name="lease" id="lease" value="No"> No
																	</div>
																</div>
															</div>
														</div>
														<hr />
														<div class="form-group">
															<label class="col-md-4 control-label" for="">
																<font color="red"></font> Did you buy the vehicle new?<br>
															</label>
															<div class="col-md-8">
																<div class="row">
																	<div class="col-md-2">
																		<input type="radio" name="bought_new" id="bought_new" value="Yes"> Yes
																	</div>
																	<div class="col-md-2">
																		<input type="radio" name="bought_new" id="bought_new" value="No"> No
																	</div>
																</div>
															</div>
														</div>
														<hr />
														<div class="form-group">
															<label class="col-md-4 control-label" for="">
																<font color="red"></font> Do all the options &amp; accessories work?<br>
															</label>
															<div class="col-md-8">
																<div class="row">
																	<div class="col-md-2">
																		<input type="radio" name="accessories_working" id="accessories_working" value="Yes"> Yes
																	</div>
																	<div class="col-md-2">
																		<input type="radio" name="accessories_working" id="accessories_working" value="No"> No
																	</div>
																</div>
															</div>
														</div>
														<hr />
														<div class="form-group">
															<label class="col-md-4 control-label" for="">
																<font color="red"></font> Has vehicle ever been in any accident?<br>
															</label>
															<div class="col-md-8">
																<div class="row">
																	<div class="col-md-2">
																		<input type="radio" name="accident" id="accident" value="Yes"> Yes
																	</div>
																	<div class="col-md-2">
																		<input type="radio" name="accident" id="accident" value="No"> No
																	</div>
																</div>
															</div>
														</div>
														<hr />
														<div class="form-group">
															<label class="col-md-4 control-label" for="">
																<font color="red"></font> Has vehicle ever had any paint work?<br>
															</label>
															<div class="col-md-8">
																<div class="row">
																	<div class="col-md-2">
																		<input type="radio" name="paint_work" id="paint_work" value="Yes"> Yes
																	</div>
																	<div class="col-md-2">
																		<input type="radio" name="paint_work" id="paint_work" value="No"> No
																	</div>
																</div>
															</div>
														</div>																
													</p>
												</div>
											</section>
											<section class="toggle active">
												<label>CAR PHOTOS</label>
												<div class="toggle-content" style="display: block;">
													<div class="dropzone dp_image" ></div>
												</div>
												<div id="car_photos"></div>
											</section>
											<section class="toggle active">
												<label>OTHER INFORMATION</label>
												<div class="toggle-content" style="display: block;">
													<p>
														<div class="form-group">
															<div class="col-md-12 text-left">
																<label>Is there any information that you feel we should know regarding this vehicle?</label>
																<textarea class="form-control input-sm" id="other_info" name="other_info"></textarea>
															</div>
														</div>
													</p>
												</div>
											</section>
										</div>
										<div class="row">
											<div class="col-md-12">
												<br />
												<input value="Submit" class="btn btn-primary pull-right push-bottom submit" name="submit">
											</div>
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
				$(".dp_image").dropzone ({
			        url: '<?php echo site_url('tradein/upload_image_form'); ?>',
			        init: function() {
			            this.on("sending", function(file, xhr, formData){
							
						}),
						this.on("success", function(file, response){
							$("#car_photos").append('<input type="hidden" class="hidden_photo" name="photo[]" value="'+response+'">');
						}),
						this.on("queuecomplete", function () {

						});
					},
				});

				$(document).on("click", ".submit", function(){
					var data = $(document).find("#tradein_form_main").serialize();
					$.ajax({
						type: "POST",
						url: "<?php echo site_url("tradein/new_trade_form"); ?>",
						cache: false,
						data: data,
						success: function(response){
							$(document).find(".form-control").each(function(){
								$(this).val("");
							});
							$(document).find("hidden_photo").remove();
							alert("Added to the database successfully!");
						}
					});
				});
			});

			function delete_image()
			{
				var data = $(document).find("form").serialize();
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("tradein/delete_image_unload"); ?>",
					cache: false,
					data: data,
					success: function(response){
					}
				});
			}

			$(window).bind("beforeunload", function(){
				delete_image();
			});
		</script>
	</body>
</html>
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
							<h2 class="panel-title">New Lead</h2>
						</header>
						<div class="panel-body">
							<form action="<?php echo site_url('fapplication/add_fq_record'); ?>" method="post" id="main_form" accept-charset="utf-8">
								<div class="row">
									<div class="form-group">
										<div class="col-md-12 text-left">
											<label><font color="red">*</font> Allocate to:</label>
											<select class="form-control input-md" name="user_id" title="Quote Specialist">
												<?php
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
												?>
											</select>
										</div>
									</div>								
									<div class="form-group">
										<div class="col-md-6 text-left">
											<label><font color="red">*</font> Name:</label>
											<input class="form-control input-md" id="name" name="name" type="text" placeholder="Name" maxlength="200"  required>
										</div>
										<div class="col-md-6 text-left">
											<label><font color="red">*</font> Email Address:</label>
											<input class="form-control input-md" id="email" name="email" type="text" placeholder="Emai Address" maxlength="254" required>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-6 text-left">
											<label><font color="red">*</font> Phone:</label>
											<input class="form-control input-md" id="phone" name="phone" type="text" placeholder="Phone" maxlength="30" required>
										</div>
										<div class="col-md-6 text-left">
											<label>Mobile:</label>
											<input class="form-control input-md" id="mobile" name="mobile" type="text" placeholder="Mobile" maxlength="30">
										</div>
									</div>
									<div class="form-group">					
										<div class="col-md-6 text-left">
											<label><font color="red">*</font> State:</label>
											<select class="form-control input-md" id="state" name="state">
												<option value=""></option>
												<option value="ACT">Australian Capital Territory</option>
												<option value="NSW">New South Wales</option>
												<option value="NT">Northern Territory</option>
												<option value="QLD">Queensland</option>
												<option value="SA">South Australia</option>
												<option value="TAS">Tasmania</option>
												<option value="VIC">Victoria</option>
												<option value="WA">Western Australia</option>											
											</select>
										</div>
										<div class="col-md-6 text-left">
											<label><font color="red">*</font> Postcode:</label>
											<input class="form-control input-md" id="postcode" name="postcode" type="text" placeholder="Postcode" maxlength="4"  required>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-6 text-left">
											<label><font color="red">*</font> Make:</label>
											<select class="form-control" id="make_dropdown" name="make" title="Make" onchange="select_model(this.options[this.selectedIndex].value)">
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
										</div>
										<div class="col-md-6 text-left">
											<label><font color="red">*</font> Model:</label>
											<select class="form-control" id="model_dropdown" name="family" title="Model" disabled>
												<option name="family" value=""><span id="model_loader"></span></option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12 text-left">
											<br />
											<input value="Submit Lead" name="submit" class="btn btn-primary pull-right push-bottom" data-loading-text="Loading..." type="submit">
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
		<script>
			function select_model(make_id)
			{
				if (make_id != "")
				{
					load_families(make_id);
				}
			}

			function load_families(make_id)
			{
				var dataString = '&make_id='+make_id;
				$("#model_loader").show();
				$("#model_loader").fadeIn(400).html('Loading...');
				
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('cars/load_families'); ?>",
					data: dataString,
					cache: false,
					success: function(result){
						$("#model_loader").hide();
						$("#model_dropdown").removeAttr("disabled");
						$("#model_dropdown").html("<option name='family' value=''></option>");
						$("#model_dropdown").append(result);
					}
				});
			}
		</script>
	</body>
</html>
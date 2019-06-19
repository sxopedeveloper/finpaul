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
							<h2 class="panel-title">Profile</h2>
						</header>
						<div class="panel-body">
							<form action="<?php echo site_url('admin/update_profile'); ?>" method="post" accept-charset="utf-8">
								<div class="row">
									<div class="form-group">
										<div class="col-md-12 text-left">
											<label>Name:</label>
											<input value="<?php echo $admin['name']; ?>" class="form-control input-md" id="name" name="name" type="text" required><br />
										</div>
										<div class="col-md-12 text-left">
											<label>ABN:</label>
											<input value="<?php echo $admin['abn']; ?>" class="form-control input-md" id="abn" name="abn" type="text" required><br />
										</div>
										<div class="col-md-12 text-left">
											<label>State:</label>
											<?php 
											$act = ''; if ($admin['state']=='ACT') { $act = ' selected'; }
											$nsw = ''; if ($admin['state']=='NSW') { $nsw = ' selected'; }
											$nt = ''; if ($admin['state']=='NT') { $nt = ' selected'; }
											$qld = ''; if ($admin['state']=='QLD') { $qld = ' selected'; }
											$sa = ''; if ($admin['state']=='SA') { $sa = ' selected'; }
											$tas = ''; if ($admin['state']=='TAS') { $tas = ' selected'; }
											$vic = ''; if ($admin['state']=='VIC') { $vic = ' selected'; }
											$wa = ''; if ($admin['state']=='WA') { $wa = ' selected'; }
											?>
											<select class="form-control input-md" name="state" id="state" type="text" required>
												<option name="state" value="">-Select State-</option>
												<option name="state" value="ACT" <?php echo $act; ?>>ACT - Australian Capital Territory</option>
												<option name="state" value="NSW" <?php echo $nsw; ?>>NSW - New South Wales</option>
												<option name="state" value="NT" <?php echo $nt; ?>>NT - Northern Territory</option>
												<option name="state" value="QLD" <?php echo $qld; ?>>QLD - Queensland</option>
												<option name="state" value="SA" <?php echo $sa; ?>>SA - South Australia</option>
												<option name="state" value="TAS" <?php echo $tas; ?>>TAS - Tasmania</option>
												<option name="state" value="VIC" <?php echo $vic; ?>>VIC - Victoria</option>
												<option name="state" value="WA" <?php echo $wa; ?>>WA - Western Australia</option>
											</select><br />
										</div>
										<div class="col-md-12 text-left">
											<label>Postcode:</label>
											<input value="<?php echo $admin['postcode']; ?>" class="form-control input-md" id="postcode" name="postcode" type="text" required><br />
										</div>
										<div class="col-md-12 text-left">
											<label>Address:</label>
											<input value="<?php echo $admin['address']; ?>" class="form-control input-md" id="address" name="address" type="text" required><br />
										</div>
										<div class="col-md-12 text-left">
											<label>Phone:</label>
											<input value="<?php echo $admin['phone']; ?>" class="form-control input-md" id="phone" name="phone" type="text" required><br />
										</div>
										<div class="col-md-12 text-left">
											<label>Mobile:</label>
											<input value="<?php echo $admin['mobile']; ?>" class="form-control input-md" id="mobile" name="mobile" type="text" required><br />
										</div>
										<div class="col-md-12 text-left">
											<label>Other Info:</label>
											<textarea id="description" name="description" class="form-control" rows="3" id="textareaDefault"><?php echo $admin['description']; ?></textarea><br />
										</div>										
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<input value="Update" name="submit" class="btn btn-primary pull-right push-bottom" data-loading-text="Loading..." type="submit">
									</div>
								</div>
							</form>
							<?php echo validation_errors("<div style='font-size: 0.8em; margin-bottom: 10px; padding: 10px; color: #E85454; border-radius: 3px; border: 1px solid #E45D5D; background-color: #F9D9D9;'>", "</div>"); ?>								
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
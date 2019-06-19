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
							<h2 class="panel-title">New Ticket</h2>
						</header>
						<div class="panel-body">
							<form action="<?php echo site_url('ticket/add_record'); ?>" method="post" id="main_form" accept-charset="utf-8">
								<div class="row">
									<div class="form-group">
										<div class="col-md-4 text-left">
											<label>Type:</label>
											<select class="form-control input-md" id="ticket_type" name="ticket_type" type="text" required>
												<option name="ticket_type" value=""></option>
												<?php 
												foreach ($ticket_types as $ticket_type)
												{
													?>
													<option name="ticket_type" value="<?php echo $ticket_type->id_ticket_type; ?>"><?php echo $ticket_type->name; ?></option>
													<?php
												}
												?>
											</select>
										</div>
										<div class="col-md-4 text-left">
											<label>Priority:</label>
											<select class="form-control input-md" id="priority" name="priority" type="text" required>
												<option name="priority" value=""></option>
												<option name="priority" value="1">Urgent</option>
												<option name="priority" value="2">High</option>
												<option name="priority" value="3">Low</option>
											</select>
										</div>										
										<div class="col-md-4 text-left">
											<label>Module:</label>
											<select class="form-control input-md" id="module" name="module" type="text" required>
												<option name="module" value=""></option>
												<?php 
												foreach ($modules as $module)
												{
													?>
													<option name="module" value="<?php echo $module->id_module; ?>"><?php echo $module->name; ?></option>
													<?php
												}
												?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-6 text-left">
											<label>Subject:</label>
											<input class="form-control input-md" id="name" name="name" type="text" placeholder="Subject" maxlength="60"  required>
										</div>
										<div class="col-md-6 text-left">
											<label>Scheduled Start Date:</label>
											<?php 
											$now = date("Y-m-d");
											?>
											<input class="form-control input-md datepicker" id="assignment_date" name="assignment_date" data-date-format="yyyy/mm/dd" value="<?php echo $now; ?>" required>
										</div>
									</div>									
									<div class="form-group">
										<div class="col-md-12 text-left">
											<label>Assign to:</label>
											<select class="form-control input-md" id="user_id_to" name="user_id_to[]" type="text" required multiple data-plugin-selectTwo>
												<?php 
												foreach ($admins as $admin)
												{
													?>
													<option name="user_id_to" value="<?php echo $admin->id_user; ?>"><?php echo $admin->name; ?></option>
													<?php
												}
												?>
											</select>
										</div>
									</div>
									<div class="form-group">										
										<div class="col-md-12 text-left">
											<label>Description:</label>
											<textarea id="description" name="description" class="form-control" rows="3" id="textareaDefault" placeholder="Description" required></textarea>
										</div>										
									</div>
									<br />
									<div class="form-group">
										<div class="col-md-12 text-left">
											<input value="Submit Ticket" name="submit" class="btn btn-primary pull-right push-bottom" data-loading-text="Loading..." type="submit">
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
	</body>
</html>
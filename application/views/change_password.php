<?php include 'admin/template/head.php'; ?>
	<body>
		<section class="body">
			<!-- start: header -->
			<?php include 'admin/template/header.php'; ?>
			<!-- end: header -->
			<div class="inner-wrapper">
				<!-- start: sidebar -->
				<?php include 'admin/template/left_sidebar.php'; ?>
				<!-- end: sidebar -->
				<section role="main" class="content-body">
					<?php include 'admin/template/header_2.php'; ?>
					<!-- start: page -->
					<section class="panel">
						<header class="panel-heading">
							<div class="panel-actions">
								<a href="#" class="fa fa-caret-down"></a>
								<a href="#" class="fa fa-times"></a>
							</div>
							<h2 class="panel-title">Change Password</h2>
						</header>
						<div class="panel-body">
							<form id="change_password" class="form" action="<?php echo site_url('user/update_password') ?>" method="POST">
								<div class="featured-box featured-box-secundary default info-content">
									<div class="box-content">
										<div class="row">
											<div class="form-group">
												<div class="form-group col-md-12">
													<label>* Current Password</label>
													<input type="password" name="current_password" class="form-control" required="required" value="" />
												</div>
												<div class="form-group col-md-12">
													<label>* New Password</label>
													<input type="password" name="password" class="form-control" required="required" value="">
												</div>	
												<div class="form-group col-md-12">
													<label>* Confirm Password</label>
													<input type="password" name="confirm_password" class="form-control" required="required" value="">
												</div>
												<div class="form-group col-md-12">
													<input type="submit" name="submit" class="btn btn-primary pull-right" value="Update">
												</div>
											</div>
										</div>
									</div>
								</div>
							</form>
							<?php 
							echo $this->session->flashdata("message");
							echo validation_errors("<div style='font-size: 0.8em; margin: 10px; padding: 10px; color: #E85454; border-radius: 3px; border: 1px solid #E45D5D; background-color: #F9D9D9;'>", "</div>"); ?>
						</div>
					</section>
					<!-- end: page -->
				</section>
			</div>
			<?php include 'admin/template/right_sidebar.php'; ?>
		</section>		
		<?php include 'admin/template/scripts.php'; ?>
	</body>
</html>
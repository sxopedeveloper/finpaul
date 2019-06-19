<?php include 'admin/template/login_head.php'; ?>
	<body>
		<div class="body">
			<?php include 'admin/template/login_header.php'; ?>
			<div role="main" class="main" style="border-top: 5px solid #58c603; padding-top: 40px;">
				<div class="container">
					<div class="row">
						<div class="col-md-offset-3 col-md-6">
							<div class="featured-box featured-box-secundary default">
								<div class="box-content text-left">
									<h3>Reset your password</h3>
									<?php if( isset( $users ) ): ?>
										<form class="form-horizontal" method="post" name="password_form" id="password_form">
											<div class="form-group">
												<label class="col-md-12">Username: <br><b><?php echo $users->username; ?></b></label>
												<input type="hidden" name="id_user" value="<?php echo $users->id_user; ?>" />
											</div>
											<div class="form-group">
												<label class="col-md-12">New Password:</label>
												<div class="col-md-12">
													<input type="password" class="form-control form-control-line" name="new_password" value="" />
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-12">Confirm Password:</label>
												<div class="col-md-12">
													<input type="password" class="form-control form-control-line" name="confirm_password" value="" />
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-12">
													<button type="submit" class="btn btn-success">Save</button>
												</div>
											</div>
										</form>
									<?php else: ?>
										<div class="alert alert-danger fade in alert-dismissable" style="margin-top:18px;"><strong>Invalid Key Value!</strong><br />Please try to re-send email on the forgot password link.</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<!--/section-->			
			</div>
			<?php include 'admin/template/login_footer.php'; ?>
		</div>
		<!-- Member Login Modal -->
		<div class="modal fade" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="login_modal">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<form method="post" name="login_form" id="login_form">
						<div class="modal-header">
							<center><h4 class="modal-title" id=""><b>MEMBER LOGIN</b></h4></center>
						</div>
						<div class="modal-body" style="padding: 25px 45px 25px 45px">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="email">Email Address:</label>
										<input type="email" class="form-control" id="email" name="email" placeholder="Email Address">
									</div>
									<div class="form-group">
										<label for="password">Password:</label>
										<input type="password" class="form-control" id="password" name="password" placeholder="Password">
									</div>
									<div class="form-group text-right">
										<button type="button" class="btn btn-default" data-dismiss="modal">
											Close
										</button>
										<button type="submit" class="btn btn-primary">
											Login
										</button>									
									</div>
								</div>
							</div>
						</div>
					</form>	
				</div>
			</div>
		</div>
		<!-- Private Registration Modal -->
		<div class="modal fade" id="private_registration_modal" tabindex="-1" role="dialog" aria-labelledby="private_registration_modal">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<form method="post" name="private_registration_form" id="private_registration_form">
						<div class="modal-header">
							<center>
								<br />
								<h4 class="modal-title" id=""><b>MEMBER REGISTRATION</b></h4>
								<p>Private</p>
							</center>
						</div>
						<div class="modal-body" style="padding: 25px 45px 25px 45px">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="email">*Email Address:</label>
										<input type="email" class="form-control" id="email" name="email" placeholder="Email Address">
										<input type="hidden" name="type" value="4">
									</div>
									<div class="form-group">
										<label for="password">*Password:</label>
										<input type="password" class="form-control" id="password" name="password" placeholder="Password">
									</div>
									<div class="form-group">
										<label for="confirm_password">*Confirm Password:</label>
										<input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
									</div>
									<div class="form-group">
										<label for="name">*Full Name:</label>
										<input type="text" class="form-control" id="name" name="name" placeholder="Full Name">
									</div>
									<div class="form-group text-right">
										<button type="button" class="btn btn-default" data-dismiss="modal">
											Close
										</button>
										<button type="submit" class="btn btn-primary">
											Register
										</button>
									</div>
								</div>
							</div>
						</div>
					</form>	
				</div>
			</div>
		</div>
		<!-- Business Registration Modal -->
		<div class="modal fade" id="business_registration_modal" tabindex="-1" role="dialog" aria-labelledby="business_registration_modal">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<form method="post" name="business_registration_form" id="business_registration_form">
						<div class="modal-header">
							<center>
								<br />
								<h4 class="modal-title" id=""><b>MEMBER REGISTRATION</b></h4>
								<p>Business</p>
							</center>
						</div>
						<div class="modal-body" style="padding: 25px 45px 25px 45px">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="email">*Email Address:</label>
										<input type="email" class="form-control" id="email" name="email" placeholder="Email Address">
										<input type="hidden" name="type" value="5">
									</div>
									<div class="form-group">
										<label for="password">*Password:</label>
										<input type="password" class="form-control" id="password" name="password" placeholder="Password">
									</div>
									<div class="form-group">
										<label for="confirm_password">*Confirm Password:</label>
										<input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
									</div>
									<div class="form-group">
										<label for="name">*Full Name:</label>
										<input type="text" class="form-control" id="name" name="name" placeholder="Full Name">
									</div>									
									<br />
									<h4>Business Details</h4>
									<hr />
									<div class="form-group">
										<label for="business_name">*Business Name:</label>
										<input type="text" class="form-control" id="business_name" name="business_name" placeholder="Business Name">
									</div>
									<div class="form-group">
										<label for="abn">*ABN:</label>
										<input type="text" class="form-control" id="abn" name="abn" placeholder="ABN">
									</div>
									<div class="form-group text-right">
										<button type="button" class="btn btn-default" data-dismiss="modal">
											Close
										</button>
										<button type="submit" class="btn btn-primary">
											Register
										</button>
									</div>																
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- Head Libs -->
		<script src="<?php echo base_url('assets_login/vendor/modernizr/modernizr.js'); ?>?v=<?php echo time();?>"></script>
		<!--script src="<?php echo base_url('assets/editor/ckeditor.js'); ?>"></script-->
		<!-- Vendor -->
		<script src="<?php echo base_url('assets_login/vendor/jquery/jquery.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets_login/vendor/jquery.appear/jquery.appear.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets_login/vendor/jquery.easing/jquery.easing.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets_login/vendor/jquery-cookie/jquery-cookie.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets_login/vendor/bootstrap/bootstrap.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets_login/vendor/common/common.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets_login/vendor/jquery.validation/jquery.validation.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets_login/vendor/jquery.stellar/jquery.stellar.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets_login/vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets_login/vendor/jquery.gmap/jquery.gmap.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets_login/vendor/isotope/jquery.isotope.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets_login/vendor/owlcarousel/owl.carousel.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets_login/vendor/jflickrfeed/jflickrfeed.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets_login/vendor/magnific-popup/jquery.magnific-popup.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets_login/vendor/vide/vide.js'); ?>?v=<?php echo time();?>"></script>
		<!-- Theme Base, Components and Settings -->
		<script src="<?php echo base_url('assets_login/js/theme.js'); ?>?v=<?php echo time();?>"></script>
		<!-- Specific Page Vendor and Views -->
		<script src="<?php echo base_url('assets_login/vendor/rs-plugin/js/jquery.themepunch.tools.min.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets_login/vendor/rs-plugin/js/jquery.themepunch.revolution.min.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets_login/vendor/circle-flip-slideshow/js/jquery.flipshow.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets_login/js/views/view.home.js'); ?>"></script>
		<!-- Theme Custom -->
		<script src="<?php echo base_url('assets_login/js/custom.js'); ?>?v=<?php echo time();?>"></script>
		<!-- Theme Initialization Files -->
		<script src="<?php echo base_url('assets_login/js/theme.init.js'); ?>?v=<?php echo time();?>"></script>
		<!-- Model selector -->
		<script>
			$("#password_form").submit(function(e){
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('forgot_password/update_password'); ?>",
					data: $("#password_form").serialize(),
					success: function(response)
					{
						if (response === "success")
						{
							alert("SUCCESS! Your password was successfully updated.");
							window.location = "<?php echo site_url('login'); ?>";
						}
						else if (response === "fail1")
						{
							alert("ERROR! The passwords do not match.");
						}	
						else
						{
							alert("ERROR! An error occured! Please try again.");
						}
					}
				});
				e.preventDefault();
			});	
		
			$("#login_form").submit(function(e){
				var email = $("#login_modal").find("#email").val();
				var password = $("#login_modal").find("#password").val();

				if (email === "")
				{
					swal("ERROR!", "Please enter a valid Email Address", "error");
					return false;
				}

				if (password === "")
				{
					swal("ERROR!", "Password is empty", "error");
					return false;
				}

				$.ajax({
					type: "POST",
					url: "<?php echo site_url('login/process');?>",
					data: $("#login_form").serialize(),
					success: function(response)
					{
						if (response === "success")
						{
							swal("SUCCESS!", "Login successful", "success");
							window.location = "";
							return false;
						}
						else
						{
							swal("ERROR!", "Incorrect Email Address / Password combination", "error");
						}
					}
				});
				e.preventDefault();
			});

			$("#private_registration_form").submit(function(e){
				var name = $("#private_registration_modal").find("#name").val();
				var email = $("#private_registration_modal").find("#email").val();
				var password = $("#private_registration_modal").find("#password").val();
				var confirm_password = $("#private_registration_modal").find("#confirm_password").val();

				if (email === "")
				{
					swal("ERROR!", "Please enter a valid Email Address", "error");
					return false;
				}

				if (password === "")
				{
					swal("ERROR!", "Password is empty", "error");
					return false;
				}

				if (confirm_password === "")
				{
					swal("ERROR!", "Please re-type your password on the Confirm Passwor field", "error");
					return false;
				}

				if (name === "")
				{
					swal("ERROR!", "Please enter your full name", "error");
					return false;
				}				

				if (password !== confirm_password)
				{
					swal("ERROR!", "Passwords do not match", "error");
					return false;
				}

				$.ajax({
					type: "POST",
					url: "<?php echo site_url('register/process');?>",
					data: $("#private_registration_form").serialize(),
					success: function(response)
					{
						if (response === "success")
						{
							swal("SUCCESS!", "Registration successful", "success");
							window.location = "";
							return false;
						}
						else if (response === "duplicate")
						{
							swal("ERROR!", "Email Address is already in use", "error");
						}						
						else
						{
							swal("ERROR!", "An error occured! Please try again", "error");
						}
					}
				});
				e.preventDefault();
			});

			$("#business_registration_form").submit(function(e){
				var name = $("#business_registration_modal").find("#name").val();
				var business_name = $("#business_registration_modal").find("#business_name").val();
				var abn = $("#business_registration_modal").find("#abn").val();
				var email = $("#business_registration_modal").find("#email").val();
				var password = $("#business_registration_modal").find("#password").val();
				var confirm_password = $("#business_registration_modal").find("#confirm_password").val();

				if (email === "")
				{
					swal("ERROR!", "Please enter a valid Email Address", "error");
					return false;
				}

				if (password === "")
				{
					swal("ERROR!", "Password is empty", "error");
					return false;
				}

				if (confirm_password === "")
				{
					swal("ERROR!", "Please re-type your password on the Confirm Passwor field", "error");
					return false;
				}

				if (name === "")
				{
					swal("ERROR!", "Please enter your full name", "error");
					return false;
				}

				if (business_name === "")
				{
					swal("ERROR!", "Please enter your business name", "error");
					return false;
				}

				if (abn === "")
				{
					swal("ERROR!", "Please enter your ABN", "error");
					return false;
				}		

				if (password !== confirm_password)
				{
					swal("ERROR!", "Passwords do not match", "error");
					return false;
				}

				$.ajax({
					type: "POST",
					url: "<?php echo site_url('register/process');?>",
					data: $("#business_registration_form").serialize(),
					success: function(response)
					{
						if (response === "success")
						{
							swal("SUCCESS!", "Registration successful", "success");
							window.location = "";
							return false;
						}
						else if (response === "duplicate")
						{
							swal("ERROR!", "Email Address is already in use", "error");
						}
						else
						{
							swal("ERROR!", "An error occured! Please try again", "error");
						}
					}
				});
				e.preventDefault();
			});
		</script>
</body>
</html>
<?php

include 'admin/template/login_head.php'; ?>
	<body>
		<div class="body">
			<?php include 'admin/template/login_header.php'; ?>
			<div role="main" class="main" style="border-top: 5px solid #58c603; padding-top: 40px;">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="row featured-boxes login">
								<div class="col-md-3"></div>
								<div class="col-md-6">
									<div class="featured-box featured-box-secundary default">
										<div class="box-content">
											<form action="<?php echo site_url('verifylogin'); ?>" method="post" accept-charset="utf-8">	
												<h3>User Login</h3>
												<?php echo $this->session->flashdata('test'); ?>
												<div class="row">
													<div class="form-group">
														<div class="col-md-12">
															<label>Username:</label>
															<input name="username" class="form-control input-lg" type="email" required>
														</div>
													</div>
												</div>
												<div class="row" style="margin-top: 15px;">
													<div class="form-group">
														<div class="col-md-12">
															<label>Password:</label>
															<input name="password" class="form-control input-lg" type="password" required>
														</div>
													</div>
												</div>
												<div class="row" style="margin-top: 10px;">
													<div class="col-md-12 text-left">
														<a type="button" href="#" onClick="forgot_password()">Forgot Password?</a>
													</div>												
													<div class="col-md-12">
														<input value="Login" class="btn btn-primary pull-right push-bottom" data-loading-text="Loading..." type="submit">
													</div>									
												</div>
											</form>
											<?php echo validation_errors("<div style='font-size: 0.8em; margin-bottom: 10px; padding: 10px; color: #E85454; border-radius: 3px; border: 1px solid #E45D5D; background-color: #F9D9D9;'>", "</div>");
												echo ($this->session->flashdata('message') !== '') ? $this->session->flashdata('message')  : '';
											 ?>
										</div>
									</div>
								</div>
								<div class="col-md-3"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Forget Password -->
			<div id="forgot-password-modal" class="modal fade">
				<div class="modal-dialog">
					<section class="panel">
						<form id="forget_pass" method="post">
							<div class="panel-body">
								<div class="modal-wrapper">
									<div class="modal-text">
										<div class="row">
											<div class="form-group">
												<div class="col-md-12">
													<h4>Forgot your password?</h4>
													<p>We will be sending a password reset link to the email address associated with your account.</p>
												</div>
												<div class="col-md-12">
													<label>E-mail Address</label>
													<input type="text" name="email" id="email" value="" class="form-control input-lg">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<footer class="panel-footer">
								<div class="row">
									<div class="col-md-12 text-right">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
										<button type="submit" class="btn btn-primary">Submit</button> 
									</div>
								</div>
							</footer>
						</form>
					</section>					
				</div>
			</div>
			<!-- /.Forget Password -->	
			<?php include 'admin/template/login_footer.php'; ?>
		</div>
		<?php include 'admin/template/login_scripts.php'; ?>
		<script>
			function forgot_password ()
			{
				$("#forgot-password-modal").modal();
			}
			
			$("#forget_pass").submit( function( e ) {
				
				var email = $("#forget_pass").find("#email").val();
				
				if (email === "") {
					alert("ERROR! Please enter a valid Email Address.");
					return false;
				}
				
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('forgot_password/send_email');?>",
					data: $("#forget_pass").serialize(),
					success: function(response)
					{
						if (response === "success")
						{
							alert("SUCCESS! Link was sent to email!");
							window.location = "";
							return false;
						}
						else
						{
							alert( "ERROR!" + response );
						}
					}
				});
				
				e.preventDefault();
			});

			function reset_password ()
			{
				var email = $("#forgot-password-modal").find("#email").val();
				var dataString = "&email="+email;
				if (email.length == 0)
				{
					alert ("Please enter your Email Address");
				}
				else
				{
					$.ajax({
						type: "POST",
						url: "<?php echo site_url('register/reset_password'); ?>",
						data: dataString,
						cache: false,
						success: function(result){
							alert ("We sent you an email with your new password");
							$("#forgot-password-modal").modal("hide");
						}
					});
				}				
			}
		</script>
	</body>
</html>
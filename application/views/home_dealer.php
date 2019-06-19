<?php include 'admin/template/head.php'; ?>
	<body>
		<style type="text/css">
			#add-cc{
				cursor: pointer; 
				cursor: hand;
			}
			#insert_cc{
				cursor: pointer; 
				cursor: hand;	
			}
			.row-input{
				margin-bottom: 10px;
			}
			.panel-cc{
				margin-bottom: 10px;
			}
			.panel-body-cc{
				background-color: #e5e5e5;
			}
			.del_token { 
				cursor: pointer; 
				cursor: hand;
			}
		</style>
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
					<div class="row">
						<div class="col-md-4 col-lg-3">
							<section class="panel">
								<div class="panel-body">
									<div class="thumb-info mb-md">
										<img src="<?php echo $user_image; ?>" class="rounded img-responsive" alt="Profile Image" style="width: 100%;" />
										<div class="thumb-info-title">
											<span class="thumb-info-inner">CAR DEALER</span>
											<span class="thumb-info-type"><?php echo $name; ?></span>
										</div>
									</div>									
								</div>
							</section>
							<section class="dealer-contact-detail-main">
								<div class="dealer-contact-form">
									<form method="post">
										<div class="form-group">
											<p>Dealership</p>
											<input type="text" name="dealership_type" class="form-control" value="<?php echo $user['dealership_name']; ?>">
										</div>
										<div class="form-group">
											<p>Fleet Contact</p>
											<input type="text" name="fleet_contact" class="form-control" value="<?php echo $user['manager_name']; ?>">
										</div>
										<div class="form-group">
											<p>Fleet Contact Email</p>
											<input type="text" name="fleet_contact_email" class="form-control" value="<?php echo $user['manager_email']; ?>">
										</div>
										<div class="form-group">
											<p>Fleet Contact Landline</p>
											<input type="text" name="fleet_contact_landline" class="form-control" value="<?php echo $user['manager_phone']; ?>">
										</div>
										<div class="form-group">
											<p>Fleet Contact Mobile</p>
											<input type="text" name="fleet_contact_mobile" class="form-control" value="<?php echo $user['manager_mobile']; ?>">
										</div>
									</form>
								</div>
							</section>							
						</div>
						<div class="col-md-8 col-lg-9">
							<div class="dealer-account-notifiy-main">
								<div class="dealer-account-message">
									<div class="panel">
										<a href="<?php echo site_url("user/quotation_requests/0"); ?>">Quote Requests</a>
										<span class="badge"><?php echo $quote_requests_count; ?></span>
									</div>
									<div class="panel">
										<a href="#">Tax Invoice Requests</a>
										<span class="badge">9</span>
									</div>
									<div class="panel">
										<a href="#">Invoices Outstanding</a>
										<span class="badge">5</span>
									</div>
									<div class="panel">
										<a href="<?php echo site_url("user/orders?status=1"); ?>">Deliveries Pending</a>
										<span class="span-pending"><?php echo $deliveries_pending_count; ?></span>
									</div>
									<div class="panel">
										<a href="#">Payments Outstanding</a>
										<span class="span-pending">8</span>
									</div>
									<div class="panel">
										<a href="<?php echo site_url("user/orders?status=0"); ?>">Orders</a>
										<span class="span-pending"><?php echo $new_orders_count; ?></span>
									</div>
								</div>
							</div>
							<div class="row" style="margin-bottom: 20px;" id="calendar_container"> <!-- Calendar Controller -->
								<div class="col-md-12">
									<div data-plugin-datepicker data-plugin-skin="primary" id="item_date"></div>
								</div>
							</div>
						</div>						
					</div>
				</section>	
			</div>
			<?php include 'admin/template/right_sidebar.php'; ?>
		</section>
		<?php include 'admin/template/scripts.php'; ?>
		<script type="text/javascript">
			function leave_message ()
			{
				var user_message = $("#user_message").val();
				if (user_message != "")
				{
					$.ajax({
						type: "POST",
						url: "<?php echo site_url('user/leave_message'); ?>",
						data: $("#leave_message_form").serialize(),
						cache: false,
						success: function(result){
							$("#user_message").val("");
							alert ("Your message has been sent to the Administrator");
						}
					});					
				}
				else
				{
					alert ("Your message cannot be blank!");
				}				
			}

			function update_profile ()
			{
				var name = $("#name").val();
				var mobile = $("#mobile").val();
				var phone = $("#phone").val();
				var dealership_name = $("#dealership_name").val();
				var dealership_brand = $("#dealership_brand").val();
				var abn = $("#abn").val();
				var state = $("#state").val();
				var postcode = $("#postcode").val();
				var description = $("#description").val();
				if (name != "" && mobile != "" && phone != "" && dealership_name != "" && dealership_brand != "" && abn != "" && state != "" && postcode != "")
				{
					$.ajax({
						type: "POST",
						url: "<?php echo site_url('user/update_dealer_profile_old'); ?>",
						data: $("#edit_profile_form").serialize(),
						cache: false,
						success: function(result){
							$("#user_message").val("");
							$("#dealer_about").html(description)
							alert ("Your profile has been successfully updated");
						}
					});				
				}
				else
				{
					alert ("Please fill up all the required fields!");
				}
			}

			function update_password ()
			{
				var current_password = $("#current_password").val();				
				var password = $("#password").val();
				var confirm_password = $("#confirm_password").val();
				if (current_password != "" && password != "" && confirm_password != "")
				{
					if (password != confirm_password)
					{
						alert ("Passwords do not match!");
					}
					else
					{
						$.ajax({
							type: "POST",
							url: "<?php echo site_url('user/update_user_password'); ?>",
							data: $("#change_password_form").serialize(),
							cache: false,
							success: function(result){
								if (result)
								{
									$("#current_password").val("");
									$("#password").val("");
									$("#confirm_password").val("");
									alert ("Your password has been successfully updated");
								}
								else
								{
									alert ("Please make sure the Current Password is correct!");
								}
							}
						});
					}
				}
				else
				{
					alert ("Please fill up all the required fields!");
				}
			}

			$(document).on('click', '.datepicker_login', function () {
				$(this).toggleClass('clicked').datepicker({format: 'yyyy-mm-dd'}).datepicker('show');
			});
		</script>		
	</body>
</html>
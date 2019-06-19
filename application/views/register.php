<?php include 'admin/template/login_head.php'; ?>
	<style type="text/css">
		.tab_top{
			font-size: 25px !important;
		}
		.active .tab_top{
			color: #58c603 !important;
		}
		.nav-tabs.nav-justified li.active a, .nav-tabs.nav-justified li.active a:hover, .nav-tabs.nav-justified li.active a:focus{
			border-top: 3px solid #58c603; 
		}
	</style>
	<body>
		<div class="body">
			<?php include 'admin/template/login_header.php'; ?>
			<div role="main" class="main">
				<section>
					<div class="container">
						<div class="row">
							<div class="col-sm-12">
								<ul class="nav nav-tabs nav-justified" role="tablist">
									<li role="presentation" class="active">
										<a class="tab_top" href="#dealer" aria-controls="dealer" role="tab" data-toggle="tab">
											<br />DEALER REGISTRATION FORM
										</a>
									</li>
								</ul>
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane active" id="dealer">
										<div class="box-content" style="padding-left: 30px; padding-right: 30px;">
											<br />
											<form action="<?php echo site_url('verifyregistration/verifyDealer'); ?>" method="post" accept-charset="utf-8">
												<div class="row">
													<div class="form-group">
														<div class="col-md-12 text-left">
															<h5>ACCOUNT DETAILS</h5>
														</div>
														<div class="col-md-4 text-left">
															<label>* Email / Username:</label>
															<input value="" class="form-control input-md" id="username" name="username" type="email" required><br />
														</div>
														<div class="col-md-4 text-left">
															<label>* Password:</label>
															<input value="" class="form-control input-md" id="password" name="password" type="password" required><br />
														</div>
														<div class="col-md-4 text-left">
															<label>* Re-enter Password:</label>
															<input value="" class="form-control input-md" id="confirm-password" name="confirm-password" type="password" required><br />
														</div>
														<div class="col-md-12 text-left">
															<br />
															<br />
															<h5>DEALERSHIP DETAILS</h5>
														</div>
														<div class="col-md-4 text-left">
															<label>* Dealership Name:</label>
															<input value="" class="form-control input-md" id="dealership_name" name="dealership_name" type="text" required><br />
														</div>
														<div class="col-md-4 text-left">
															<label>* Dealer License Number:</label>
															<input value="" class="form-control input-md" id="dealer_license" name="dealer_license" type="text" required><br />
														</div>
														<div class="col-md-4 text-left">
															<label>* ABN:</label>
															<input value="" class="form-control input-md" id="abn" name="abn" type="text" required><br />
														</div>
														<div class="col-md-4 text-left">
															<label>* State:</label>
															<select class="form-control input-md" name="state" id="state" type="text" required>
																<option name="state" value="">-Select State-</option>
																<option name="state" value="ACT">Australian Capital Territory</option>
																<option name="state" value="NSW">New South Wales</option>
																<option name="state" value="NT">Northern Territory</option>
																<option name="state" value="QLD">Queensland</option>
																<option name="state" value="SA">South Australia</option>
																<option name="state" value="TAS">Tasmania</option>
																<option name="state" value="VIC">Victoria</option>
																<option name="state" value="WA">Western Australia</option>
															</select>
															<br />
														</div>														
														<div class="col-md-4 text-left">
															<label>* Postcode:</label>
															<input value="" class="form-control input-md" id="postcode" name="postcode" type="text" required><br />
														</div>
														<div class="col-md-4 text-left">
															<label>* Address:</label>
															<input value="" class="form-control input-md" id="address" name="address" type="text" required><br />
														</div>														
														<div class="col-md-12 text-left">
															<br />
															<br />
															<h5>CONTACT PERSON (FLEET MANAGER)</h5>
														</div>														
														<div class="col-md-4 text-left">
															<label>* Name:</label>
															<input value="" class="form-control input-md" id="manager_name" name="manager_name" type="text" required><br />
														</div>
														<div class="col-md-4 text-left">
															<label>* Mobile:</label>
															<input value="" class="form-control input-md" id="manager_mobile" name="manager_mobile" type="text" required><br />
														</div>
														<div class="col-md-4 text-left">
															<label>* Landline:</label>
															<input value="" class="form-control input-md" id="manager_phone" name="manager_phone" type="text" required><br />
														</div>
														<div class="col-md-4 text-left">
															<label>* Email:</label>
															<input value="" class="form-control input-md" id="manager_email" name="manager_email" type="email" readonly="readonly" required><br />
														</div>
														<div class="col-md-12 text-left">
															<br />
															<br />
															<h5>CONTACT PERSON (ACCOUNTS PAYABLE)</h5>
														</div>														
														<div class="col-md-4 text-left">
															<label>* Name:</label>
															<input value="" class="form-control input-md" id="account_name" name="account_name" type="text" required><br />
														</div>
														<div class="col-md-4 text-left">
															<label>* Mobile:</label>
															<input value="" class="form-control input-md" id="account_mobile" name="account_mobile" type="text" required><br />
														</div>
														<div class="col-md-4 text-left">
															<label>* Landline:</label>
															<input value="" class="form-control input-md" id="account_phone" name="account_phone" type="text" required><br />
														</div>
														<div class="col-md-4 text-left">
															<label>* Email:</label>
															<input value="" class="form-control input-md" id="account_email" name="account_email" type="email" required><br />
														</div>																												
														<div class="col-md-12 text-left">
															<br />
															<br />
															<h5>DEALER PRINCIPAL</h5>
														</div>														
														<div class="col-md-4 text-left">
															<label>* Name:</label>
															<input value="" class="form-control input-md" id="dealer_principal_name" name="dealer_principal_name" type="text" required><br />
														</div>
														<div class="col-md-4 text-left">
															<label>* Mobile:</label>
															<input value="" class="form-control input-md" id="dealer_principal_mobile" name="dealer_principal_mobile" type="text" required><br />
														</div>														
														<div class="col-md-4 text-left">
															<label>* Landline:</label>
															<input value="" class="form-control input-md" id="dealer_principal_phone" name="dealer_principal_phone" type="text" required><br />
														</div>
														<div class="col-md-4 text-left">
															<label>* Email:</label>
															<input value="" class="form-control input-md" id="dealer_principal_email" name="dealer_principal_email" type="email" required><br />
														</div>														
														<div class="col-md-12 text-left">
															<br />
															<br />
															<h5>BRANDS OF DEALERSHIP</h5>
														</div>
														<?php 
														foreach ($makes as $make)
														{
															?>
															<div class="col-md-2 text-left">
																<label class="checkbox-inline">
																	<input type="checkbox" name="make_<?php echo $make->id_make; ?>" id="make_<?php echo $make->id_make; ?>" value="<?php echo $make->name; ?>"> <?php echo $make->name; ?>
																</label>														
															</div>														
															<?php
														}
														?>
														<div class="col-md-12 text-left">
															<br />
															<br />
															<br />
														</div>
														<div class="col-md-12 text-left">
															<h5>DEALER BANK DETAILS</h5>
														</div>	
														<div class="col-md-4 text-left">
															<label> Bank Account Name:</label>
															<input value="" class="form-control input-md" id="bank_acct_name" name="bank_acct_name" type="text" ><br />
														</div>
														<div class="col-md-4 text-left">
															<label> Bank Account Number:</label>
															<input value="" class="form-control input-md" id="bank_acct_num" name="bank_acct_num" type="text" ><br />
														</div>
														<div class="col-md-4 text-left">
															<label> BSB Number:</label>
															<input value="" class="form-control input-md" id="bank_acct_bsb" name="bank_acct_bsb" type="text" ><br />
														</div>
														<div class="col-md-12 text-left">
															<br />
															<br />
															<h5>ADDITIONAL INFO</h5>
														</div>														
														<div class="col-md-12 text-left">
															<textarea id="description" name="description" class="form-control" rows="3" id="textareaDefault"></textarea><br />
														</div>													
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<input value="Register" name="submit" class="btn btn-primary pull-right push-bottom" data-loading-text="Loading..." type="submit">
													</div>
												</div>
											</form>
											<?php echo validation_errors("<div style='font-size: 0.8em; margin-bottom: 10px; padding: 10px; color: #E85454; border-radius: 3px; border: 1px solid #E45D5D; background-color: #F9D9D9;'>", "</div>"); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
			<?php include 'admin/template/login_footer.php'; ?>
		</div>
		<?php include 'admin/template/login_scripts.php'; ?>
		<script>
			$(document).ready(function(){
				$(document).on("change", "#username", function () {
					$("#manager_email").val($(this).val());
				});
			});		
		</script>
	</body>
</html>

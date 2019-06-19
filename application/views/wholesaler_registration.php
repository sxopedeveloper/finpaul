<?php include 'admin/template/login_head.php'; ?>
	<body>
		<div class="body">
			<?php include 'admin/template/login_header.php'; ?>
			<div role="main" class="main" style="border-top: 5px solid #58c603; padding-top: 40px;">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="panel form-wizard" id="wholesaler_registration_wizard">
								<div class="panel-body" style="border-radius: 0px; padding: 0px 30px;">
									<div class="row">
										<div class="col-md-12">
											<center>
												<br />
												<br />
												<br />
												<h3 style="color: #58c603; font-size: 2.3em;">
													<b>Wholesaler Registration</b>
												</h3>												
												<br />
											</center>
										</div>
									</div>
									<div class="wizard-progress wizard-progress-lg">
										<div class="steps-progress">
											<div class="progress-indicator"></div>
										</div>
										<ul class="wizard-steps">
											<li class="active">
												<a href="#introduction" data-toggle="tab"><span>1</span>Introduction</a>
											</li>									
											<li>
												<a href="#account_details" data-toggle="tab"><span>2</span>Account Details</a>
											</li>
											<li>
												<a href="#confirmation" data-toggle="tab"><span>3</span>Confirmation</a>
											</li>
										</ul>
									</div>
									<form class="form-bordered">
										<div class="tab-content">
											<div id="introduction" class="tab-pane active">
												<div class="row">
													<div class="col-md-12">
														<div class="alert alert-success alert-admin">
															<p style="font-size: 1.2em">
																<strong><span style="color: #58c603;">IMPORTANT:</span></strong>
															</p>
															<p style="font-size: 1.2em">
																Wholesalers must have a valid Motor dealers license.
															</p>
															<p style="font-size: 1.2em">
																<b>Quote Me</b> approved wholesalers can value and buy used vehicles 
																that would normally be traded in when our clients buy their 
																new car.														
															</p>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-12 text-center">
														<br />
														<br />
														<h3 style="color: #58c603; font-size: 2.3em;">
															<b>DOCUMENT LIST</b>
														</h3>
														<p style="font-size: 1.2em">
															Vehicle wholesalers will be given the following documents
														</p>
														<br />
													</div>
												</div>
												<div class="row">											
													<div class="col-md-4 text-center">
														<div style="background: #f4f7f8; padding: 15px; border-radius: 10px; margin-bottom: 30px;">
															<h4 style="color: #58c603;">
																<strong>DESCRIPTION OF VEHICLE</strong>
															</h4>
															<br />
															<img src="<?php echo base_url('assets/img/wholesaler/document_1.png'); ?>">
															<br />
															<br />
															<p style="font-size: 1.1em">
																PDF with full description of trade
															</p>
														</div>
													</div>
													<div class="col-md-4 text-center">
														<div style="background: #f4f7f8; padding: 15px; border-radius: 10px; margin-bottom: 30px;">
															<h4 style="color: #58c603;">
																<strong>PICTURES OF VEHICLE</strong>
															</h4>
															<br />
															<img src="<?php echo base_url('assets/img/wholesaler/document_2.png'); ?>">
															<br />
															<br />
															<p style="font-size: 1.1em">
																4 pictures will be supplied
															</p>
														</div>
													</div>
													<div class="col-md-4 text-center">
														<div style="background: #f4f7f8; padding: 15px; border-radius: 10px; margin-bottom: 30px;">
															<h4 style="color: #58c603;">
																<strong>REGISTRATION PAPERS</strong>
															</h4>
															<br />
															<img src="<?php echo base_url('assets/img/wholesaler/document_3.png'); ?>">
															<br />
															<br />
															<p style="font-size: 1.1em">
																Signed registration papers in JPEG form
															</p>
														</div>
													</div>
													<div class="col-md-4 text-center">
														<div style="background: #f4f7f8; padding: 15px; border-radius: 10px; margin-bottom: 30px;">
															<h4 style="color: #58c603;">
																<strong>PAYOUT LETTER</strong>
															</h4>
															<br />
															<img src="<?php echo base_url('assets/img/wholesaler/document_4.png'); ?>">
															<br />
															<br />
															<p style="font-size: 1.1em">
																If there is a financial encumbrance
															</p>
														</div>
													</div>
													<div class="col-md-4 text-center">
														<div style="background: #f4f7f8; padding: 15px; border-radius: 10px; margin-bottom: 30px;">
															<h4 style="color: #58c603;">
																<strong>TRADE DECLARATION</strong>
															</h4>
															<br />
															<img src="<?php echo base_url('assets/img/wholesaler/document_5.png'); ?>">
															<br />
															<br />
															<p style="font-size: 1.1em">
																Ownership and tax invoice instructions
															</p>
														</div>
													</div>
													<div class="col-md-4 text-center">
														<div style="background: #f4f7f8; padding: 15px; border-radius: 10px; margin-bottom: 30px;">
															<h4 style="color: #58c603;">
																<strong>DRIVERS LICENCE</strong>
															</h4>
															<br />
															<img src="<?php echo base_url('assets/img/wholesaler/document_6.png'); ?>">
															<br />
															<br />
															<p style="font-size: 1.1em">
																Drivers Licence front and back
															</p>
														</div>
													</div>		
													<div class="col-md-12">
														<br />
														<div class="alert alert-danger">
															<p style="font-size: 1.1em">
																<strong>Qteme is not the supplier of new or used cars and 
																acts as paid introducer only.</strong> 
															</p>
															<p style="font-size: 1.1em">
																Wholesale buyers
																agents are to buy the vehicle direct from the Qteme client 
																and they must pay the dealership that is supplying the 
																replacement car to the one purchased. All payments must 
																take place prior to pick up.													
															</p>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<br />
													</div>
													<div class="col-md-12">
														<h3 style="color: #58c603; font-size: 2.0em;">
															<b>Valuation Process</b>
														</h3>												
														<p style="font-size: 1.2em;">
															Examine the pictures and having read the description, please nominate a
															value that you will pay for the car if you are the nominated receiver.
															Valuations must be valid for 30 days.													
														</p>
														<br />
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<h3 style="color: #58c603; font-size: 2.0em;">
															<b>Qteme Portal</b>
														</h3>												
														<p style="font-size: 1.2em;">
															www.myelquoto.com.au login using your email address and the nominated
															password. Here you can look at all cars needing your valuation and check
															cars that are arriving that you own												
														</p>
														<br />
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<h3 style="color: #58c603; font-size: 2.0em;">
															<b>Trade confirmed</b>
														</h3>												
														<p style="font-size: 1.2em;">
															The wholesaler that is nominated by Quote me will be emailed and
															informed of their success. A document list is outlined below. The documents
															and instructions for pick up will be emailed no later than 5 working days
															from arrival date estimate.													
														</p>
														<br />
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<h3 style="color: #58c603; font-size: 2.0em;">
															<b>Payment Instructions</b>
														</h3>
														<p style="font-size: 1.2em;">
															Emailed to wholesale buyer who is responsible for confirming by
															phone the date time and location that is specified. If there is any
															changes please email accounts@qteme.com.au cars must be funded and
															clear prior to pick up.												
														</p>
														<br />
													</div>
													<div class="col-md-12">
														<br />
														<br />
													</div>												
												</div>
											</div>
											<div id="account_details" class="tab-pane">
												<div class="row">
													<div class="col-md-6">
														<h4 style="color: #58c603; margin-bottom: 10px;">
															<b><i class="fa fa-user"></i> WHOLESALER DETAILS</b>
														</h4>
														<br />
														<div style="padding: 20px;">
															<div class="form-group">
																<label class="col-md-4 control-label"><span class="required">*</span> Full Name:</label>
																<div class="col-md-8">
																	<input class="form-control" id="name" name="name" type="text" placeholder="" required>
																</div>
															</div>
															<div class="form-group">
																<label class="col-md-4 control-label"><span class="required">*</span> Business Name:</label>
																<div class="col-md-8">
																	<input class="form-control" id="business_name" name="business_name" type="text" placeholder="" required>
																</div>
															</div>
															<div class="form-group">
																<label class="col-md-4 control-label"><span class="required">*</span> ABN:</label>
																<div class="col-md-8">
																	<input class="form-control" id="abn" name="abn" type="text" placeholder="" required>
																</div>
															</div>
															<div class="form-group">
																<label class="col-md-4 control-label"><span class="required">*</span> Dealer License:</label>
																<div class="col-md-8">
																	<input class="form-control" id="dealer_license" name="dealer_license" type="text" placeholder="" required>
																</div>
															</div>
														</div>
														<br />
														<br />
														<h4 style="color: #58c603; margin-bottom: 10px;">
															<b><i class="fa fa-map-marker"></i> ADDRESS DETAILS</b>
														</h4>
														<br />
														<div style="padding: 20px;">
															<div class="form-group">
																<label class="col-md-4 control-label"><span class="required">*</span> Address:</label>
																<div class="col-md-8">
																	<input class="form-control" id="address" name="address" type="text" placeholder="" required>
																</div>
															</div>
															<div class="form-group">
																<label class="col-md-4 control-label"><span class="required">*</span> Postcode:</label>
																<div class="col-md-8">
																	<input class="form-control" id="postcode" name="postcode" type="text" placeholder="" required>
																</div>
															</div>
															<div class="form-group">
																<label class="col-md-4 control-label"><span class="required">*</span> State:</label>
																<div class="col-md-8">
																	<input class="form-control" id="state" name="state" type="text" placeholder="" required>
																</div>
															</div>														
														</div>													
													</div>
													<div class="col-md-6">
														<h4 style="color: #58c603; margin-bottom: 10px;">
															<b><i class="fa fa-bank"></i> BANK DETAILS</b>
														</h4>
														<br />
														<div style="padding: 20px;">
															<div class="form-group">
																<label class="col-md-4 control-label"><span class="required">*</span> Account Holder:</label>
																<div class="col-md-8">
																	<input class="form-control" id="account_holders_name" name="account_holders_name" type="text" placeholder="" required>
																</div>
															</div>
															<div class="form-group">
																<label class="col-md-4 control-label"><span class="required">*</span> Account Name:</label>
																<div class="col-md-8">
																	<input class="form-control" id="bank_acct_name" name="bank_acct_name" type="text" placeholder="" required>
																</div>
															</div>
															<div class="form-group">
																<label class="col-md-4 control-label"><span class="required">*</span> Account BSB:</label>
																<div class="col-md-8">
																	<input class="form-control" id="bank_acct_bsb" name="bank_acct_bsb" type="text" placeholder="" required>
																</div>
															</div>
															<div class="form-group">
																<label class="col-md-4 control-label"><span class="required">*</span> Account Number:</label>
																<div class="col-md-8">
																	<input class="form-control" id="bank_acct_num" name="bank_acct_num" type="text" placeholder="" required>
																</div>
															</div>														
														</div>
														<br />
														<br />
														<h4 style="color: #58c603; margin-bottom: 10px;">
															<b><i class="fa fa-phone"></i> CONTACT DETAILS</b>
														</h4>
														<br />
														<div style="padding: 20px;">
															<div class="form-group">
																<label class="col-md-4 control-label"><span class="required">*</span> Mobile:</label>
																<div class="col-md-8">
																	<input class="form-control" id="mobile" name="mobile" type="text" placeholder="" required>
																</div>
															</div>														
															<div class="form-group">
																<label class="col-md-4 control-label">Phone:</label>
																<div class="col-md-8">
																	<input class="form-control" id="phone" name="phone" type="text" placeholder="">
																</div>
															</div>														
														</div>
													</div>
												</div>
											</div>
											<div id="confirmation" class="tab-pane">
												<div class="row">
													<div class="col-md-2">
													</div>
													<div class="col-md-8">
														<center>
														<h4 style="color: #58c603; margin-bottom: 10px;">
															<b><i class="fa fa-key"></i> LOGIN DETAILS</b>
														</h4>
														<p>Please make sure all the details are accurate</p>
														</center>
														<div style="border: 1px solid #fff; border-radius: 3px; padding: 20px;">
															<div class="form-group" id="username_form_group">
																<label class="col-md-4 control-label"><span class="required">*</span> E-mail Address:</label>
																<div class="col-md-8">
																	<input class="form-control" type="text" id="username" name="username" onchange="check_login_details()">
																	<label for="username" class="error" id="username_error_label"></label>
																</div>
															</div>
															<div class="form-group" id="password_form_group">
																<label class="col-md-4 control-label"><span class="required">*</span> Password:</label>
																<div class="col-md-8">
																	<input class="form-control" type="password" id="password" name="password" onchange="check_login_details()">
																	<label for="password" class="error" id="password_error_label"></label>
																</div>
															</div>
															<div class="form-group" id="confirm_password_form_group">
																<label class="col-md-4 control-label"><span class="required">*</span> Confirm Password:</label>
																<div class="col-md-8">
																	<input class="form-control" type="password" id="confirm_password" name="confirm_password" onchange="check_login_details()">
																	<label for="confirm_password" class="error" id="confirm_password_error_label"></label>
																</div>
															</div>
														</div>
														<br />
														<center>
															<h4><b>TERMS AND CONDITIONS</b></h4>
														</center>														
														<div class="well well-sm pre-scrollable">
															<p align="justify">
																<b>Quote me</b> is not the supplier of new or used cars. Our invoice is for the introduction 
																of the owner to the wholesaler that is purchasing the car. Our invoice when added to the 
																wholesale purchase payment will not exceed the vehicles value as placed by the nominated 
																purchaser of the wholesaler. 
															</p>
															<p align="justify">
																<b>Quote me</b> is not liable for any loss or liability that any wholesaler incurs buying any car 
																from a <b>Quote me</b> introduction. 
															</p>
															<p align="justify">
																Wholesalers are encouraged to inspect all cars or have a vehicle inspection take place prior 
																to payment. 
															</p>
															<p align="justify">
																All payments for cars are made to the owner or the owners nominated bank account. Authority 
																forms are provided.
															</p>
															<p align="justify">
																Cars must be paid for and funds clear by the date of arrival. 
															</p>
															<p align="justify">
																Owners details are provided and wholesale buyers should contact them in advance of the 
																delivery date.															
															</p>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label"></label>
															<div class="col-md-8">
																<input type="checkbox" name="agreement_check" required>
																&nbsp;&nbsp;&nbsp;I accept our Terms and Conditions
															</div>
														</div>														
													</div>
													<div class="col-md-2">
													</div>
												</div>
												<div class="row">
													<div class="col-md-2">
													</div>											
													<div class="col-md-8">
														<br />
														<div style="background: #eee; border-radius: 10px; padding: 25px;">
															<center>
																<br />
																<p style="font-size: 1.1em;">
																	Draw your signature on the box below:
																</p>
																<canvas id="signature_canvas" style="background: #fff; border-radius: 5px; border: 1px solid #eee; z-index: 99999999999 !important;"></canvas>
																<br />
																<br />
																<button type="button" class="btn btn-default clear_signature">Clear Signature</button>
																<br />
															</center>
														</div>
														<br />
														<br />
													</div>
													<div class="col-md-2">
													</div>												
												</div>
											</div>
										</div>
									</form>
								</div>
								<div class="panel-footer" style="border: 1px solid #eee;">
									<ul class="pager">
										<li class="previous disabled">
											<a href="#">Previous</a>
										</li>
										<li class="finish hidden pull-right">
											<a id="submit_form">Finish</a>
										</li>
										<li class="next">
											<a href="#">Next</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php include 'admin/template/login_footer.php'; ?>
		</div>
		<?php include 'admin/template/login_scripts.php'; ?>
		<script type="text/javascript">
			var canvasWidth = 500;
			var canvasHeight = 200;
			var signature_context = document.getElementById("signature_canvas").getContext("2d");
			var signature_canvas = null;
			var signature_canvas = document.getElementById("signature_canvas");

			signature_canvas.setAttribute("width", canvasWidth);
			signature_canvas.setAttribute("height", canvasHeight);
			signature_canvas.setAttribute("id", "signature_canvas");
			signature_context = signature_canvas.getContext("2d");

			$("#signature_canvas").mousedown(function(e){
				var rect = signature_canvas.getBoundingClientRect();
				var mouseX = e.clientX - rect.left;
				var mouseY = e.clientY - rect.top;
				paint = true;
				addClick(e.clientX - rect.left, e.clientY - rect.top);
				redraw();
			});

			$("#signature_canvas").mousemove(function(e){
				if(paint)
				{
					var rect = signature_canvas.getBoundingClientRect();
					addClick(e.clientX - rect.left, e.clientY - rect.top, true);
					redraw();
				}
			});

			$("#signature_canvas").mouseup(function(e){
				paint = false;
			});

			$("#signature_canvas").mouseleave(function(e){
				paint = false;
			});

			var clickXsig = new Array();
			var clickYsig = new Array();
			var clickDragsig = new Array();
			var paint;

			function addClick (x, y, dragging)
			{
				clickXsig.push(x);
				clickYsig.push(y);
				clickDragsig.push(dragging);
			}

			function redraw ()
			{
				signature_context.clearRect(0, 0, signature_context.canvas.width, signature_context.canvas.height); // Clears the canvas
				signature_context.strokeStyle = "#000";
				signature_context.lineJoin = "round";
				signature_context.lineWidth = 3;
				for(var i=0; i < clickXsig.length; i++) 
				{		
					signature_context.beginPath();
					if(clickDragsig[i] && i)
					{
						signature_context.moveTo(clickXsig[i-1], clickYsig[i-1]);
					}
					else
					{
						signature_context.moveTo(clickXsig[i]-1, clickYsig[i]);
					}
					signature_context.lineTo(clickXsig[i], clickYsig[i]);
					signature_context.closePath();
					signature_context.stroke();
				}
			}

			$(document).on("click", ".clear_signature", function(){
		    	signature_context.clearRect(0, 0, signature_canvas.width, signature_canvas.height);
		    	clickXsig    = new Array();
				clickYsig    = new Array();
				clickDragsig = new Array();
		    });			
			
			$("#submit_form").click(function(){

				var name = $("#name").val();
				var business_name = $("#business_name").val();
				var abn = $("#abn").val();
				var dealer_license = $("#dealer_license").val();
				var address = $("#address").val();
				var postcode = $("#postcode").val();
				var state = $("#state").val();
				var account_holders_name = $("#account_holders_name").val();
				var bank_acct_name = $("#bank_acct_name").val();
				var bank_acct_bsb = $("#bank_acct_bsb").val();
				var bank_acct_num = $("#bank_acct_num").val();
				var phone = $("#phone").val();
				var mobile = $("#mobile").val();
				var username = $("#username").val();
				var password = $("#password").val();
				var confirm_password = $("#confirm_password").val();
				var signature_image = signature_canvas.toDataURL();
				document.getElementById("signature_canvas").src = signature_image;

				var data = {
					name: name,
					business_name: business_name,
					abn: abn,
					dealer_license: dealer_license,
					address: address,
					postcode: postcode,
					state: state,
					account_holders_name: account_holders_name,
					bank_acct_name: bank_acct_name,
					bank_acct_bsb: bank_acct_bsb,
					bank_acct_num: bank_acct_num,
					phone: phone,
					mobile: mobile,
					username: username,
					password: password,
					confirm_password: confirm_password,
					signature_image: signature_image
				};
				
				if (password != confirm_password)
				{
					alert("Passwords did not match!");
				}

				$.ajax({
					type: "POST",
					url: "<?php echo site_url('verifyregistration/verifyWholesaler'); ?>",
					data: data,
					cache: false,
					success: function(response){
						if (response === "success")
						{
							alert("Registration successful!");
							window.location.href = "<?php echo site_url(); ?>";
							return false;
						}
						else
						{
							alert("An error has occured! Please make sure all your inputs are correct");
						}
					}
				});
			});

			var $wizard_finish = $("#wholesaler_registration_wizard").find("ul.pager li.finish"),
			$wizard_validator = $("#wholesaler_registration_wizard form").validate({
				highlight: function(element) {
					$(element).closest(".form-group").removeClass("has-success").addClass("has-error");
				},
				success: function(element) {
					$(element).closest(".form-group").removeClass("has-error");
					$(element).remove();
				},
				errorPlacement: function( error, element ) {
					element.parent().append(error);
				}
			});
	
			function check_login_details ()
			{
				var username = $("#username").val();
				var password = $("#password").val();
				var confirm_password = $("#confirm_password").val();
						
				if (password === "")
				{
					$("#password_form_group").addClass("has-error");
					$("#password_error_label").html("Please enter a password");
					$("#password_error_label").show();					
				}
				else
				{
					$("#password_form_group").removeClass("has-error");
					$("#password_error_label").html("");
					$("#password_error_label").hide();						
				}
				
				if (confirm_password === "")
				{
					$("#confirm_password_form_group").addClass("has-error");
					$("#confirm_password_error_label").html("Please re-type the password");
					$("#confirm_password_error_label").show();					
				}
				else
				{
					$("#confirm_password_form_group").removeClass("has-error");
					$("#confirm_password_error_label").html("");
					$("#confirm_password_error_label").hide();						
				}

				if (password !== "" && confirm_password !== "")
				{
					if (password !== confirm_password)
					{						
						$("#confirm_password_form_group").addClass("has-error");
						$("#confirm_password_error_label").html("Passwords don't match!");
						$("#confirm_password_error_label").show();					
					}
					else
					{
						$("#confirm_password_form_group").removeClass("has-error");
						$("#confirm_password_error_label").html("");
						$("#confirm_password_error_label").hide();						
					}					
				}
				
				if (username === "")
				{
					$("#username_form_group").addClass("has-error");
					$("#username_error_label").html("Please enter a password");
					$("#username_error_label").show();					
				}
				else
				{
					var data = { username: username };
					$.ajax({
						type: "POST",
						url: "<?php echo site_url('verifyregistration/check_username_availability'); ?>",
						data: data,
						cache: false,
						success: function(response){	
							if (response === "success")
							{
								$("#username_form_group").removeClass("has-error");
								$("#username_error_label").html("");
								$("#username_error_label").hide();
							}
							else
							{
								$("#username_form_group").addClass("has-error");
								$("#username_error_label").html("Username is already in use!");
								$("#username_error_label").show();
							}
						}
					});					
				}			
			}

			$("#wholesaler_registration_wizard").bootstrapWizard({
				tabClass: 'wizard-steps',
				nextSelector: 'ul.pager li.next',
				previousSelector: 'ul.pager li.previous',
				firstSelector: null,
				lastSelector: null,
				onNext: function(tab, navigation, index, newindex) {
					var validated = $('#wholesaler_registration_wizard form').valid();
					if(!validated)
					{
						$wizard_validator.focusInvalid();
						return false;
					}
				},
				onTabClick: function(tab, navigation, index, newindex) {
					/*
					if (newindex == index + 1) 
					{
						return this.onNext(tab, navigation, index, newindex);
					} 
					else if (newindex > index + 1)
					{
						return false;
					}
					else
					{
						return true;
					}
					*/
					return false;
				},
				onTabChange: function(tab, navigation, index, newindex) {
					var $total = navigation.find('li').size() - 1;
					$wizard_finish[ newindex != $total ? 'addClass' : 'removeClass' ]( 'hidden' );
					$('#wholesaler_registration_wizard').find(this.nextSelector)[ newindex == $total ? 'addClass' : 'removeClass' ]( 'hidden' );
				},
				onTabShow: function(tab, navigation, index) {
					var $total = navigation.find('li').length - 1;
					var $current = index;
					var $percent = Math.floor(( $current / $total ) * 100);
					$('#wholesaler_registration_wizard').find('.progress-indicator').css({ 'width': $percent + '%' });
					tab.prevAll().addClass('completed');
					tab.nextAll().removeClass('completed');
				}
			});
		</script>
	</body>
</html>
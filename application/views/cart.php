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
						<div class="panel-body">
							<div class="col-md-12">
								<div class="table-responsive cart_contents">
									<?php
									if (count($this->cart->contents())==0)
									{
										echo '<br /><br /><br /><center>There are no items found! <br />Check the available Leads <a href="'.site_url('user/available_leads').'">here</a></center><br /><br /><br /><br />';
									}
									else
									{
										?>
										<br />
										<h4><b>ORDER ITEMS</b></h4>
										<table class="table table-condensed mb-none table-cont-mid" style="white-space: nowrap;">
											<tbody>
												<?php
												foreach ($this->cart->contents() as $item)
												{
													if ($item['qty'] <> 0) 
													{
														?>
														<tr id="cart_row_<?php echo $item['rowid']; ?>">
															<td align="left">
																<a href="#" onclick="remove_item('<?php echo $item['rowid']; ?>')">
																	<i class="fa fa-trash-o"></i>
																</a>
															</td>														
															<td><?php echo $item['name']; ?> Lead</td>
															<td class="td-number">$<span id="cart_row_price_<?php echo $item['rowid']; ?>"><?php echo number_format($item['price'], 2, '.', ','); ?></span></td>
														</tr>
														<?php
													}
												}
												?>
												<tr>
													<td class="td-number" colspan="3"><h4>TOTAL: &nbsp;&nbsp;<b>$<span class="cart_total"><?php echo $this->cart->format_number($this->cart->total()); ?></span></h4></td>
													
												</tr>
											</tbody>
										</table>
										<br />
										<div class="col-md-12 text-left">
											<h5>TOTAL ITEMS: <strong><span class="item_count"><?php echo $this->cart->total_items(); ?></span></strong></h5>
											<p>
												- The leads will be accessible on the <a href="<?php echo site_url('user/purchased_leads'); ?>"><b>Purchased Leads</b></a> page upon checkout.<br />
												- Phone numbers that do not work and email addresses that bounce are to be replaced.<br />
												- Please let Quote Me know on info@qteme.com.au if there is any issues with the Leads purchased.
											</p>
											<br />
											<a href="<?php echo site_url('user/available_leads'); ?>" class="btn btn-default" onclick="add_leads_to_cart()"><i class="fa fa-arrow-left"></i> BACK</a>
											<button type="button" class="btn btn-success" onclick="checkout()"><i class="fa fa-check-square-o"></i> CHECKOUT</button>
											<br />
											<br />
											<br />
										</div>
									<?php
									}
									?>
								</div>							
							</div>
						</div>
					</section>
					<!-- end: page -->
					<!--Checkout Modal-->
					<div id="checkout-modal" class="modal fade">
						<div class="modal-dialog" style="width: 80%;">
							<section class="panel">
								<header class="panel-heading">
									<h2 class="panel-title">Checkout</h2>
								</header>
								<div class="panel-body">
									<div class="modal-wrapper">
										<div class="modal-text">
											<div class="cart">
												<div class="payment_method">
													<div class="row">
														<div class="col-md-12">
															<h4 style="margin-bottom: 15px;">HOW DO YOU WANT TO PAY?</h4>
															<input type="radio" name="payment_method" value="1" onclick="choose_payment_menthod(1)"> 7 Day Account &nbsp;&nbsp;&nbsp;
															<input type="radio" name="payment_method" value="2" onclick="choose_payment_menthod(2)"> Credit Card
															<hr />
														</div>								
													</div>
												</div>
												<div class="credit_card_details" hidden>
													<div class="row">
														<div class="col-md-12">
															<h4 style="margin-bottom: 15px;">CREDIT CARD DETAILS</h4>
															<input type="radio" name="cc_method" class="cc_method" value="1"> Use existing credit card
															<br>
															<input type="radio" name="cc_method" class="cc_method" value="2"> New Credit Card
															<div class="row tokens" hidden>
																<hr>
																<div class="col-md-12">
																	<div class="table-responsive">
																		<table class="table table-striped">
																			<thead>
																				<tr>
																					<th>&nbsp;</th>
																					<th>Credit Card Type</th>
																					<th>Credit Card Number</th>
																					<th>Card Holder's Name</th>
																					<th>Expiration Date</th>
																				</tr>
																			</thead>
																			<tbody>
																				<?php
																				if(count($token_infos) > 0)
																				{
																					foreach ($token_infos as $token_key => $token_value) 
																					{
																						$radio_value = $token_key + 1;
																						?>
																							<tr class="parent_tr">
																								<td>
																									<div class="btn-group">
																										<input type="radio" name="token_info" class="token_info" value="<?= $radio_value ?>">
																									</div>
																								</td>
																								<td><?= $token_value['card_type'] ?></td>
																								<td class="child_td" data-id="<?= $token_value['id'] ?>">************<i><?= $token_value['cc_ending']; ?></i></td>
																								<td><?= $token_value['first_name'] ?> &nbsp; <?= $token_value['last_name'] ?></td>
																								<td><?= $token_value['exp_month'] ?>&nbsp;/&nbsp;<?= $token_value['exp_year'] ?></td>
																							</tr>
																						<?php
																					}
																				}
																				else
																				{
																					?>
																					<tr><td colspan=5><p><i>No Credit Card information added yet...</i></p></td></tr>
																					<?php
																				}
																				?>
																			</tbody>
																		</table>
																	</div>
																</div>
															</div>
															<div class="row new-cred" hidden>
																<hr>
																<div class="col-md-12">
																	<div class="table-responsive">
																		<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
																			<tbody>
																				<tr>
																					<td><font color="red">*</font> First Name</td>
																					<td><input type="text" class="form-control input-sm first_name_inp" name="first_name"></td>
																				</tr>
																				<tr>
																					<td><font color="red">*</font> Last Name</td>
																					<td><input type="text" class="form-control input-sm last_name_inp" name="last_name"></td>
																				</tr>
																				<tr>
																					<td><font color="red">*</font> Credit Card Number</td>
																					<td><input type="text" class="form-control input-sm credit_card_number_inp" name="credit_card_number"></td>
																				</tr>
																				<tr>
																					<td><font color="red">*</font> Credit Card Type</td>
																					<td><input type="text" class="form-control input-sm card_type" name="card_type" disabled></td>
																				</tr>
																				<tr>
																					<td><font color="red">*</font> Expiry (Month)</td>
																					<td><input type="text" class="form-control input-sm expiry_month_inp" name="expiry_month"></td>
																				</tr>
																				<tr>
																					<td><font color="red">*</font> Expiry (Year)</td>
																					<td><input type="text" class="form-control input-sm expiry_year_inp" name="expiry_year"></td>
																				</tr>
																				<tr>
																					<td><font color="red">*</font> CVN</td>
																					<td><input type="text" class="form-control input-sm cvn_inp" name="cvn"></td>
																				</tr>
																			</tbody>
																		</table>
																		<div class="pull-right">
																			<input type="checkbox" class="cc_keep" name="cc_keep" value="1">&nbsp;&nbsp;<i>Keep this credit card for future use?</i>&nbsp;
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="account_details" hidden>
													<div class="row">
														<div class="col-md-12">
															<h4 style="margin-bottom: 15px;">7 DAY ACCOUNT</h4>
															<div class="table-responsive">
																<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
																	<tbody>
																		<tr>
																			<td>Account Name</td>
																			<td><?php echo $name;?></td>
																		</tr>
																		<tr>
																			<td>Balance</td>
																			<td>$<span class="account_balance"><?php echo $balance;?></span></td>
																		</tr>																		
																	</tbody>
																</table>
																<br />
																<span class="balance_warning" style="color: red;"></span>
															</div>
														</div>								
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
											<button type="button" class="btn btn-primary submit_payment" onclick="submit_payment()" disabled>SUBMIT</button>
										</div>
									</div>
								</footer>
							</section>					
						</div>
					</div>
					<!-- /.Checkout Modal -->					
				</section>
			</div>
			<?php include 'admin/template/right_sidebar.php'; ?>
		</section>
		<?php include 'admin/template/scripts.php'; ?>
		<script>
			$(document).ready(function(){

				$(document).on('click', '.cc_method', function(){
					var that = $(this);

					if(that.val() == 1)
					{
						$('.tokens').prop('hidden', false);
						$('.new-cred').prop('hidden',true);
					}
					else if(that.val() == 2)
					{
						$('.new-cred').prop('hidden',false);
						$('.tokens').prop('hidden', true);
					}

				});

			});

			function remove_item (cart_id)
			{
				var cart_price = parseFloat($("#cart_row_price_"+cart_id).html());
				var cart_total = parseFloat($(".cart_total").html());
				var item_count = parseInt($(".item_count").html());
				var new_cart_total = cart_total - cart_price;
				var new_item_count = item_count - 1;

				var dataString = '&cart_id='+cart_id;
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('cart/remove_item'); ?>",
					data: dataString,
					cache: false,
					success: function(result) {
						new_cart_total = new_cart_total.toFixed(2);
						$("#cart_row_"+cart_id).remove();
						$(".cart_total").html(new_cart_total);

						if (new_item_count == 0)
						{
							$(".cart_contents").html('<br /><br /><br /><center>There are no items found! <br />Check the available Leads <a href="<?php echo site_url('user/available_leads'); ?>">here</a></center><br /><br /><br /><br />');
						}
						else
						{
							$(".item_count").html(new_item_count);	
						}

						return true;
					}
				})
			}

			function checkout ()
			{
				$("#checkout-modal").modal();
			}

			function choose_payment_menthod (payment_method)
			{
				if (payment_method == 1)
				{
					var account_balance = parseFloat($("#checkout-modal").find(".account_balance").html());
					var cart_total = parseFloat($(".cart_total").html());
					$(".submit_payment").prop("disabled", false);
					$(".account_details").prop("hidden", false);
					$(".credit_card_details").prop("hidden", true);
				}
				else if (payment_method == 2)
				{
					$(".submit_payment").prop("disabled", false);
					$(".credit_card_details").prop("hidden", false);
					$(".account_details").prop("hidden", true);
				}
			}

			function submit_payment ()
			{
				var error_message = "";
				var payment_method = $('input[name="payment_method"]:checked').val();
				var cc_method = $('.cc_method:checked').val();
				
				if (payment_method==2)
				{
					if(cc_method == 1)
					{
						if($('input[name="token_info"]:checked').length > 0)
						{
							var token_radio = $('input[name="token_info"]:checked');
							var token_id = token_radio.closest('.parent_tr').find('.child_td').data('id');
							var data = {
								payment_method: payment_method,
								token_id      : token_id,
								cc_method     : cc_method
							};
						}
						else
						{
							error_message = "Please select one saved credit card info!";
						}
					}
					else if(cc_method==2)
					{
						$(".card_type").attr('disabled', false);
						
						var first_name         = $("#checkout-modal").find(".first_name_inp").val();
						var last_name          = $("#checkout-modal").find(".last_name_inp").val();
						var credit_card_number = $("#checkout-modal").find(".credit_card_number_inp").val();
						var expiry_month       = $("#checkout-modal").find(".expiry_month_inp").val();
						var expiry_year        = $("#checkout-modal").find(".expiry_year_inp").val();
						var cvn                = $("#checkout-modal").find(".cvn_inp").val();
						var card_type          = $("#checkout-modal").find(".card_type").val();
						var is_checked         = 0;

						if($('.cc_keep').is(":checked"))
						{
							is_checked = 1;
						}

						if (last_name=="" || first_name=="" || credit_card_number=="" || expiry_month=="" || expiry_year=="" || cvn=="")
						{
							error_message = "Please complete the required fields!";
						}

						var data = {
							payment_method    : payment_method,
							first_name        : first_name,
							last_name         : last_name,
							credit_card_number: credit_card_number,
							expiry_month      : expiry_month,
							expiry_year       : expiry_year,
							cvn               : cvn,
							is_checked        : is_checked,
							cc_method         : cc_method,
							card_type         : card_type
						};
					}
				}
				else
				{
					var data = {
						payment_method: payment_method
					};
				}

				if (error_message=="")
				{
					$.ajax({
						type: "POST",
						url: "<?php echo site_url('cart/submit_payment'); ?>",
						data: data,
						cache: false,
						dataType: 'json',
						success: function(result) {
							if(result.status)
							{
								alert ("Thank you for purchasing! Check out your leads on the Purchased Leads screen.");
								location.reload();
							}
							else
							{
								alert (result.message);
							}
						}
					})					
				}
				else
				{
					alert (error_message);
				}
			}

			$(document).on('change','.credit_card_number_inp', function(){
				var master = /^(?:5[1-5][0-9]{14})$/;
				var visa = /^(?:4[0-9]{12}(?:[0-9]{3})?)$/;  
				var inputtxt = $(this).val().replace(' ', '');
				if(inputtxt.match(master))  
				{  
					$(".card_type").val("Mastercard");
				}
				else if(inputtxt.match(visa))
				{
					$(".card_type").val("Visa");
				}
				else
				{
					alert("Not a valid Mastercard or Visa number!");
				}
			});

			$("#cc_number").on('keydown', function (e){
				if(e.which === 32)
				{
					return false;
				}
			});
		</script>
	</body>
</html>
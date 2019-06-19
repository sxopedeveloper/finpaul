<?php
function cq_date_format ($date_string)
{
	$date = date_create($date_string);
	return date_format($date, 'd F Y');
}

function date_difference_text ($date_difference_count)
{
	if ($date_difference_count == 0) { $date_difference_text = "today"; }
	else if ($date_difference_count == 1) { $date_difference_text = abs($date_difference_count)." day from now"; }
	else if ($date_difference_count > 1) { $date_difference_text = abs($date_difference_count)." days from now"; }
	else if ($date_difference_count == -1) { $date_difference_text = abs($date_difference_count)." day ago"; }
	else if ($date_difference_count < -1) { $date_difference_text = abs($date_difference_count)." days ago"; }
	
	return $date_difference_text;
}

function date_difference_count ($date_string)
{
	$now = time();
	$date = strtotime($date_string);
	$date_difference = $date - $now;
	$date_difference_count = (floor($date_difference / (60 * 60 * 24)) + 1);
	
	return $date_difference_count;
}
?>
<?php include 'template/head.php'; ?>
	<body>
		<section class="body">
			<?php include 'template/header.php'; ?>
			<div class="inner-wrapper">
				<?php include 'template/left_sidebar.php'; ?>
				<section role="main" class="content-body has-toolbar">
					<?php include 'template/header_2.php'; ?>
					<!-- start: page -->
					<div class="inner-toolbar clearfix"> <!-- Deal Status Menu -->
						<ul>
							<li class="right">
								<ul class="nav nav-pills nav-pills-primary">
									<?php 
									$status = isset($_GET['status']) ? $_GET['status'] : '4';

									$pending_active = " ";
									$approved_active = " ";
									$delivered_active = " ";
									$settled_active = " ";
									$onhold_active = " ";
									$cancelled_active = " ";
									if ($status == 4) { $pending_active = ' class="active"'; }
									else if ($status == 5) { $approved_active = ' class="active"'; }
									else if ($status == 6) { $delivered_active = ' class="active"'; }
									else if ($status == 7) { $settled_active = ' class="active"'; }
									else if ($status == 8) { $onhold_active = ' class="active"'; }
									else if ($status == 9) { $cancelled_active = ' class="active"'; }
									?>
									<li <?php echo $pending_active; ?>>
										<a href="<?php echo site_url('deal/tile_view?status=4'); ?>">Pending</a>
									</li>
									<li <?php echo $approved_active; ?>>
										<a href="<?php echo site_url('deal/tile_view?status=5'); ?>">Approved</a>
									</li>
									<li <?php echo $delivered_active; ?>>
										<a href="<?php echo site_url('deal/tile_view?status=6'); ?>">Delivered</a>
									</li>
									<li <?php echo $settled_active; ?>>
										<a href="<?php echo site_url('deal/tile_view?status=7'); ?>">Settled</a>
									</li>
									<li <?php echo $onhold_active; ?>>
										<a href="<?php echo site_url('deal/tile_view?status=8'); ?>">On Hold</a>
									</li>									
									<li <?php echo $cancelled_active; ?>>
										<a href="<?php echo site_url('deal/tile_view?status=9'); ?>">Cancelled</a>
									</li>																		
								</ul>
							</li>
						</ul>
					</div>
					<section class="panel panel-collapsed">
						<header class="panel-heading">
							<div class="panel-actions">
								<a href="#" class="fa fa-caret-down"></a>
							</div>
							<h2 class="panel-title">
								<span class="label label-primary label-sm text-normal va-middle mr-sm">
									<?php echo $result_count; ?>
								</span>
								<span class="va-middle">Search Filters</span>
							</h2>
						</header>
						<form action="<?php echo site_url('deal/tile_view'); ?>" method="get" accept-charset="utf-8"> <!-- Filters -->
							<div class="panel-body">
								<div class="row">
									<?php
									$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
									$direction = isset($_GET['direction']) ? $_GET['direction'] : '';
									
									$cq_number = isset($_GET['cq_number']) ? $_GET['cq_number'] : '';
									
									$finance = isset($_GET['finance']) ? $_GET['finance'] : '';
									
									$client = isset($_GET['client']) ? $_GET['client'] : '';
									$quote_specialist = isset($_GET['quote_specialist']) ? $_GET['quote_specialist'] : '';
									$dealer = isset($_GET['dealer']) ? $_GET['dealer'] : '';
									$interstate = isset($_GET['interstate']) ? $_GET['interstate'] : '';
									
									$make = isset($_GET['make']) ? $_GET['make'] : '';
									$model = isset($_GET['make']) ? $_GET['model'] : '';
									
									$tradein = isset($_GET['tradein']) ? $_GET['tradein'] : '';
									$tradein_buyer = isset($_GET['tradein_buyer']) ? $_GET['tradein_buyer'] : '';

									$incomplete_details = isset($_GET['incomplete_details']) ? $_GET['incomplete_details'] : '';
									$revenue_low = isset($_GET['revenue_low']) ? $_GET['revenue_low'] : '';
									$commissionable_gross_low = isset($_GET['commissionable_gross_low']) ? $_GET['commissionable_gross_low'] : '';
									
									$invoice_number = isset($_GET['invoice_number']) ? $_GET['invoice_number'] : '';
									$reference_number = isset($_GET['reference_number']) ? $_GET['reference_number'] : '';									

									// For Markup //
									$selected_finance_0 = ""; if ($finance == "0") { $selected_finance_0 = ' selected="selected" '; }
									$selected_finance_1 = ""; if ($finance == "1") { $selected_finance_1 = ' selected="selected" '; }
									
									$selected_sort_revenue = ""; if ($sort == "revenue") { $selected_sort_revenue = ' selected="selected" '; }
									$selected_sort_commissionable_gross = ""; if ($sort == "commissionable_gross") { $selected_sort_commissionable_gross = ' selected="selected" '; }
									$selected_sort_balcqo = ""; if ($sort == "balcqo") { $selected_sort_balcqo = ' selected="selected" '; }
									$selected_sort_order_date = ""; if ($sort == "order_date") { $selected_sort_order_date = ' selected="selected" '; }
									$selected_sort_approved_date = ""; if ($sort == "approved_date") { $selected_sort_approved_date = ' selected="selected" '; }
									$selected_sort_delivery_date = ""; if ($sort == "delivery_date") { $selected_sort_delivery_date = ' selected="selected" '; }
									$selected_sort_settled_date = ""; if ($sort == "settled_date") { $selected_sort_settled_date = ' selected="selected" '; }
									$selected_sort_cancelled_date = ""; if ($sort == "cancelled_date") { $selected_sort_cancelled_date = ' selected="selected" '; }
									
									$selected_direction_asc = ""; if ($direction == "ASC") { $selected_direction_asc = ' selected="selected" '; }
									$selected_direction_desc = ""; if ($direction == "DESC") { $selected_direction_desc = ' selected="selected" '; }
									
									$selected_interstate_0 = ""; if ($interstate == "0") { $selected_interstate_0 = ' selected="selected" '; }
									$selected_interstate_1 = ""; if ($interstate == "1") { $selected_interstate_0 = ' selected="selected" '; }
									
									$selected_tradein_0 = ""; if ($tradein == "0") { $selected_tradein_0 = ' selected="selected" '; }
									$selected_tradein_1 = ""; if ($tradein == "1") { $selected_tradein_1 = ' selected="selected" '; }

									$selected_tradein_buyer_1 = ""; if ($tradein_buyer == "1") { $selected_tradein_buyer_1 = ' selected="selected" '; }																	
									$selected_tradein_buyer_2 = ""; if ($tradein_buyer == "2") { $selected_tradein_buyer_2 = ' selected="selected" '; }
									$selected_tradein_buyer_3 = ""; if ($tradein_buyer == "3") { $selected_tradein_buyer_3 = ' selected="selected" '; }
									
									$checked_incomplete_details = ""; if ($incomplete_details == "1") { $checked_incomplete_details = ' checked="checked" '; }
									$checked_revenue_low = ""; if ($revenue_low == "1") { $checked_revenue_low = ' checked="checked" '; }
									$checked_commissionable_gross_low = ""; if ($commissionable_gross_low == "1") { $checked_commissionable_gross_low = ' checked="checked" '; }	
									?>
									<input type="hidden" name="status" value="<?php echo $status;?>">
									<div class="col-md-12"> <!-- Sort -->
										<div style="border: 1px solid #ddd; padding: 15px 15px 0px 15px; margin-bottom: 15px; border-radius: 0px;">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label"><b>Sort By:</b></label>
														<select class="form-control mb-md" name="sort">
															<option name="sort" value=""></option>
															<option name="sort" value="revenue" <?php echo $selected_sort_revenue; ?>>Revenue</option>
															<option name="sort" value="commissionable_gross" <?php echo $selected_sort_commissionable_gross; ?>>Commissionable Gross</option>
															<option name="sort" value="balcqo" <?php echo $selected_sort_balcqo; ?>>BalCQO</option>
															<option name="sort" value="order_date" <?php echo $selected_sort_order_date; ?>>Order Date</option>
															<option name="sort" value="approved_date" <?php echo $selected_sort_approved_date; ?>>Approved Date</option>																
															<option name="sort" value="delivery_date" <?php echo $selected_sort_delivery_date; ?>>Delivery Date</option>
															<option name="sort" value="settled_date" <?php echo $selected_sort_settled_date; ?>>Settled Date</option>
															<option name="sort" value="cancelled_date" <?php echo $selected_sort_cancelled_date; ?>>Cancelled Date</option>
														</select>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label"><b>Direction:</b></label>
														<select class="form-control mb-md" name="direction">
															<option name="direction" value=""></option>
															<option name="direction" value="ASC" <?php echo $selected_direction_asc; ?>>Ascending</option>
															<option name="direction" value="DESC" <?php echo $selected_direction_desc; ?>>Descending</option>
														</select>
													</div>
												</div>													
											</div>
										</div>
									</div>
									<div class="col-md-6"> <!-- Deal Filter -->
										<div style="border: 1px solid #ddd; padding: 15px 15px 0px 15px; margin-bottom: 15px; border-radius: 0px;">
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label class="control-label"><b>Finance:</b></label>
														<select class="form-control mb-md" name="finance">
															<option name="finance" value=""></option>
															<option name="finance" value="1" <?php echo $selected_finance_1; ?>>Yes</option>
															<option name="finance" value="0" <?php echo $selected_finance_0; ?>>No</option>
														</select>
													</div>										
												</div>											
												<div class="col-md-12">
													<div class="form-group">
														<label class="control-label"><b>ID or CQ Number:</b></label>
														<input type="text" class="form-control mb-md" name="cq_number" placeholder="ID or CQ Number" value="<?php echo $cq_number;?>">
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<label class="control-label"><b>Client:</b> (Name or Email)</label>
														<input type="text" class="form-control mb-md" name="client" placeholder="Client (Name or Email)" value="<?php echo $client;?>">
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<label class="control-label"><b>Quote Specialist:</b> (Name or Email)</label>
														<input type="text" class="form-control mb-md" name="quote_specialist" placeholder="Quote Specialist (Name or Email)" value="<?php echo $quote_specialist;?>">
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<label class="control-label"><b>Dealer:</b> (Dealership or Fleet Manager)</label>
														<input type="text" class="form-control mb-md" name="dealer" placeholder="Dealer (Dealership or Fleet Manager)" value="<?php echo $dealer;?>">
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<label class="control-label"><b>Interstate:</b></label>
														<select class="form-control mb-md" name="interstate">
															<option name="interstate" value=""></option>
															<option name="interstate" value="1" <?php echo $selected_interstate_1; ?>>Yes</option>
															<option name="interstate" value="0" <?php echo $selected_interstate_0; ?>>No</option>
														</select>
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<label class="control-label"><b>With Invoice Number of:</b></label>
														<input type="text" class="form-control mb-md" name="invoice_number" placeholder="Invoice Number" value="<?php echo $invoice_number;?>">
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<label class="control-label"><b>With Payment Reference Number of:</b></label>
														<input type="text" class="form-control mb-md" name="reference_number" placeholder="Payment Reference Number" value="<?php echo $reference_number;?>">
													</div>
												</div>												
												<div class="col-md-12">
													<b>Warnings:</b>
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<input type="checkbox" name="incomplete_details" value="1" <?php echo $checked_incomplete_details; ?>>
														<label class="control-label">Incomplete Client Details</label>
													</div>													
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<input type="checkbox" name="commissionable_gross_low" value="1" <?php echo $checked_commissionable_gross_low; ?>>
														<label class="control-label">Low Commissionable Gross</label>
													</div>
												</div>													
												<div class="col-md-12">
													<div class="form-group">
														<input type="checkbox" name="revenue_low" value="1" <?php echo $checked_revenue_low; ?>>
														<label class="control-label">Low Revenue</label>
													</div>													
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6"> <!-- Tradein and Car Filter -->
										<div style="border: 1px solid #ddd; padding: 15px 15px 0px 15px; margin-bottom: 15px; border-radius: 0px;">
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label class="control-label"><b>Tradein:</b></label>										
														<select class="form-control mb-md" name="tradein" id="tradein_select">
															<option name="tradein" value=""></option>
															<option name="tradein" value="1" <?php echo $selected_tradein_1; ?>>With Tradein</option>
															<option name="tradein" value="0" <?php echo $selected_tradein_0; ?>>Without Tradein</option>
														</select>
													</div>
												</div>
												<?php
												$trade_buyer_div_class = "";
												if ($tradein<>1)
												{
													$trade_buyer_div_class = "hidden";
												}
												?>
												<div class="col-md-12 <?php echo $trade_buyer_div_class; ?>" id="trade_buyer_div">
													<div class="form-group">
														<label class="control-label"><b>Buyer of Tradein:</b></label>										
														<select class="form-control mb-md" name="tradein_buyer">
															<option name="tradein_buyer" value=""></option>
															<option name="tradein_buyer" value="1" <?php echo $selected_tradein_buyer_1; ?>>Dealer</option>
															<option name="tradein_buyer" value="2" <?php echo $selected_tradein_buyer_2; ?>>Wholesaler</option>
															<option name="tradein_buyer" value="3" <?php echo $selected_tradein_buyer_3; ?>>Quote Me</option>
														</select>
													</div>
												</div>													
											</div>
										</div>												
										<div style="border: 1px solid #ddd; padding: 15px 15px 0px 15px; margin-bottom: 15px; border-radius: 0px;">
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label class="control-label"><b>Car Make:</b></label>
														<input type="text" class="form-control mb-md" name="make" placeholder="Car Make" value="<?php echo $make;?>">
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<label class="control-label"><b>Car Model:</b></label>
														<input type="text" class="form-control mb-md" name="model" placeholder="Car Model" value="<?php echo $model;?>">
													</div>
												</div>													
											</div>
										</div>
										<div style="border: 1px solid #ddd; padding: 15px 15px 0px 15px; margin-bottom: 15px; border-radius: 0px;">
											<div class="row">
												<div class="col-md-12">
													<b>Total Revenue: </b>
													<p>$ <?php echo number_format($total_revenue, 2); ?></p>
												</div>
												<div class="col-md-12">
													<b>Total Commissionable Gross: </b>
													<p>$ <?php echo number_format($total_commissionable_gross, 2); ?></p>
												</div>
											</div>
										</div>
										<div style="border: 1px solid #ddd; padding: 15px 15px 0px 15px; margin-bottom: 15px; border-radius: 0px;">
											<div class="row">												
												<div class="col-md-12">
													<b>Total BalCQO: </b>
													<p>$ <?php echo number_format($total_balcqo, 2); ?></p>
												</div>
												<div class="col-md-12">
													<b>Total Payments: </b>
													<p>$ <?php echo number_format($total_payments, 2); ?></p>
												</div>
												<div class="col-md-12">
													<b>Total Remaining Balance: </b>
													<p>$ <?php echo number_format($total_remaining_balance, 2); ?></p>
												</div>												
											</div>
										</div>
									</div>
								</div>
							</div>
							<footer class="panel-footer text-right">
								<input value="Apply Filters" name="submit" class="btn btn-primary" type="submit">
							</footer>							
						</form>
					</section>					
					<?php
					if ($result_count==0)
					{
						echo "<br /><br /><br /><center>No records found..</center>";
					}
					else
					{
						foreach ($deals AS $deal)
						{
							if ($deal['delivery_date']=="0000-00-00")
							{
								$delivery_difference = "";
								$delivery_notification_text = "";
							}
							else
							{
								$delivery_difference = date_difference_count($deal['delivery_date']);
								$delivery_notification_text = "<b>Delivery</b> is ".date_difference_text($delivery_difference);
							}
							
							if ($deal['settled_date']=="0000-00-00")
							{
								$settled_difference = "";
								$settled_notification_text = "";
							}
							else
							{
								$settled_difference = date_difference_count($deal['settled_date']);
								$settled_notification_text = "<b>Settled</b> ".date_difference_text($settled_difference);
							}

							if ($deal['cancelled_date']=="0000-00-00")
							{
								$cancelled_difference = "";
								$cancelled_notification_text = "";
							}
							else
							{
								$cancelled_difference = date_difference_count($deal['cancelled_date']);
								$cancelled_notification_text = "<b>Cancelled</b> ".date_difference_text($cancelled_difference);
							}							
							
							$warning_arr = [];
							$reminder_arr = [];

							if ($deal['delivery_date'] == "0000-00-00") { $warning_arr[] = "<b>Delivery date</b> is not set"; }
							if ($deal['revenue'] <= 0) { $warning_arr[] = "<b>Revenue</b> is very low"; }
							if ($deal['commissionable_gross'] <= 0) { $warning_arr[] = "<b>Commissionable gross</b> is very low"; }
							if ($deal['name'] == "") { $warning_arr[] = "<b>Client name</b> is missing"; }
							if ($deal['email'] == "") { $warning_arr[] = "<b>Client email</b> address is missing"; }
							if ($deal['phone'] == "" AND $deal['mobile'] == "") { $warning_arr[] = "<b>Client contact number<b/> is missing"; }
							if ($deal['state'] == "" OR $deal['postcode'] == "" OR $deal['address'] == "") { $warning_arr[] = "<b>Client address</b> is incomplete"; }
							if ($deal['delivery_address'] == "") { $warning_arr[] = "<b>Delivery address</b> is missing"; }
							
							if (($status == 4 OR $status == 5 OR $status == 6) AND ($delivery_difference >= 0 AND $delivery_difference <= 7))
							{
								$reminder_arr[] = $delivery_notification_text;
							}
							
							if (($status == 4 OR $status == 5 OR $status == 6) AND ($delivery_difference < 0))
							{
								$warning_arr[] = $delivery_notification_text;
							}				
							
							if ($status == 7 AND $delivery_difference > 0)
							{
								$warning_arr[] = "Marked as <b>Settled</b> but delivery date hasn't arrived yet!";
							}
							?>
							<section class="panel" id="deal_record_<?php echo $deal['id_lead']; ?>">
								<div class="panel-body">
									<div class="row">
										<div class="col-md-12"> <!-- Deal Header -->
											<h4>
												<b>
													<a href="<?php echo site_url('lead/record_final/'.$deal['id_lead']); ?>">
														<?php echo $deal['cq_number'] . " - " . $deal['tender_make'] . " " . $deal['tender_model']; ?>
													</a>
													<?php
													if ($deal['finance']==1)
													{
														echo '<span>(Finance)</span>';
													}
													?>
												</b>
											</h4>
											<h5 style="margin-bottom: 25px;">
												<?php echo $deal['tender_variant'] ." (" . $deal['colour'] . ")"; ?>
											</h5>
											<p>
												<i class="fa fa-user"></i> <b><?php echo $deal['qs_name']; ?></b></i>
											</p>
										</div>
										<?php
										if (count($warning_arr)>0)
										{
											?>
											<div class="col-md-12">
												<div class="alert alert-danger fade in nomargin">
													<ul>
													<?php
													foreach ($warning_arr AS $warning)
													{
														?>
														<li><?php echo $warning; ?></li>
														<?php
													}													
													?>
													</ul>
												</div>
											</div>												
											<?php
										}
										
										if (count($reminder_arr)>0)
										{
											?>
											<div class="col-md-12">
												<div class="alert alert-info fade in nomargin">
													<ul>
													<?php
													foreach ($reminder_arr AS $reminder)
													{
														?>
														<li><?php echo $reminder; ?></li>
														<?php
													}													
													?>
													</ul>
												</div>
											</div>												
											<?php
										}										
										?>
									</div>
									<div class="row">
										<div class="col-md-6"> <!-- DEAL DETAILS 1 -->
											<div class="table-responsive">
												<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
													<tbody>
														<?php
														if ($status == 9)
														{
															?>
															<tr>
																<td>Order Date:</td>
																<td id="order_date_td_<?php echo $deal['id_lead']; ?>">
																	<?php 
																	if ($deal['order_date']=="0000-00-00")
																	{
																		echo ""; 
																	}
																	else
																	{
																		echo cq_date_format($deal['order_date']);
																	}
																	?>
																</td>
															</tr>
															<tr>
																<td>Delivery Date:</td>
																<td id="delivery_date_td_<?php echo $deal['id_lead']; ?>">
																	<?php 
																	if ($deal['delivery_date']=="0000-00-00")
																	{
																		echo ""; 
																	}
																	else
																	{
																		echo cq_date_format($deal['delivery_date']) . " (".date_difference_text($delivery_difference).")";
																	}
																	?>
																</td>
															</tr>															
															<tr>
																<td>Cancelled Date:</td>
																<td id="cancelled_date_td_<?php echo $deal['id_lead']; ?>">
																	<?php 
																	if ($deal['cancelled_date']=="0000-00-00")
																	{
																		echo ""; 
																	}
																	else
																	{
																		echo cq_date_format($deal['cancelled_date']);
																	}
																	?>
																</td>
															</tr>															
															<?php
														}
														else
														{
															?>
															<tr>
																<td>Order Date:</td>
																<td id="order_date_td_<?php echo $deal['id_lead']; ?>">
																	<?php 
																	if ($deal['order_date']=="0000-00-00")
																	{
																		echo ""; 
																	}
																	else
																	{
																		echo cq_date_format($deal['order_date']);
																	}
																	?>
																</td>
															</tr>
															<tr>
																<td>Delivery Date:</td>
																<td id="delivery_date_td_<?php echo $deal['id_lead']; ?>">
																	<?php 
																	if ($deal['delivery_date']=="0000-00-00")
																	{
																		echo ""; 
																	}
																	else
																	{
																		echo cq_date_format($deal['delivery_date']) . " (".date_difference_text($delivery_difference).")";
																	}
																	?>
																</td>
															</tr>
															<tr>
																<td>Settled Date:</td>
																<td id="settled_date_td_<?php echo $deal['id_lead']; ?>">
																	<?php 
																	if ($deal['settled_date']=="0000-00-00")
																	{
																		echo ""; 
																	}
																	else
																	{
																		echo cq_date_format($deal['settled_date']);
																	}
																	?>
																</td>
															</tr>
															<tr>
																<td>Delivery Address:</td>
																<td>
																	<?php echo $deal['delivery_address']; ?>
																</td>
															</tr>
															<?php
														}
														?>
													</tbody>
												</table>
											</div>
											<br />
										</div>
										<div class="col-md-6"> <!-- DEAL DETAILS 2 -->
											<div class="table-responsive">
												<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
													<tbody>
														<?php
														if ($deal['commissionable_gross']<>"") { $deal['commissionable_gross'] = "$ ".number_format($deal['commissionable_gross'], 2); }
														if ($deal['revenue']<>"") { $deal['revenue'] = "$ ".number_format($deal['revenue'], 2); }
														if ($deal['remaining_balance']<>"") { $deal['remaining_balance'] = "$ ".number_format($deal['remaining_balance'], 2); }
														?>
														<tr>
															<td>Commissionable Gross:</td>
															<td align="right"><?php echo $deal['commissionable_gross']; ?></td>
														</tr>
														<tr>
															<td>Revenue:</td>
															<td align="right"><?php echo $deal['revenue']; ?></td>
														</tr>
														<tr>
															<td>Remaining Balance:</td>
															<td align="right"><?php echo $deal['remaining_balance']; ?></td>
														</tr>
														<tr>
															<td>Unpaid Invoices:</td>
															<td align="right"><i>Under construction</i></td>
														</tr>														
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div class="row">										
										<div class="col-md-6"> <!-- CLIENT DETAILS -->
											<h5>CLIENT</h5>
											<div class="table-responsive">
												<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
													<tbody>
														<?php
														$business_name = "";
														if ($deal['business_name']<>"")
														{
															$business_name = " (".$deal['business_name'].")";
														}
														
														$client_phone = "";
														if ($deal['phone']<>"")
														{
															$client_phone = '<i class="fa fa-phone"></i> '.$deal['phone'];
														}
														
														$client_mobile = "";
														if ($deal['mobile']<>"")
														{
															$client_phone = '<i class="fa fa-mobile"></i> '.$deal['phone'];
														}														
														?>
														<tr>
															<td width="20%">Name:</td>
															<td><?php echo $deal['name'].$business_name; ?></td>
														</tr>		
														<tr>
															<td>Email:</td>
															<td><a href="mailto:<?php echo $deal['email']; ?>"><?php echo $deal['email']; ?></a></td>
														</tr>
														<tr>
															<td>Phone:</td>
															<td><?php echo $deal['phone']; ?></td>
														</tr>
														<tr>
															<td>Mobile:</td>
															<td><?php echo $deal['mobile']; ?></td>
														</tr>
														<?php
														$client_address = "";
														if ($deal['address'] <> "")
														{
															$client_address .= $deal['address'].", ";
														}
														
														if ($deal['postcode'] <> "")
														{
															$client_address .= "<br />".$deal['postcode']." ";
														}
														
														if ($deal['state'] <> "")
														{
															$client_address .= $deal['state'].", ";
														}
														$client_address .= "Australia";														
														?>
														<tr>
															<td>Address:</td>
															<td><?php echo $client_address; ?><br /><br /></td>
														</tr>														
													</tbody>
												</table>
											</div>
										</div>
										<div class="col-md-6"> <!-- DEALER DETAILS -->
											<h5>DEALER</h5>
											<div class="table-responsive">
												<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
													<tbody>
														<?php
														$dealership_name = "";
														if ($deal['dealership_name']<>"")
														{
															$dealership_name = " (".$deal['dealership_name'].")";
														}
														?>													
														<tr>
															<td width="20%">Name:</td>
															<td>
																<a href="<?php echo site_url('user/record/'.$deal['dealer_id']); ?>" target="_blank">
																	<?php echo $deal['fleet_manager'].$dealership_name; ?>
																</a>
															</td>
														</tr>														
														<tr>
															<td>Email:</td>
															<td>
																<a href="mailto:<?php echo $deal['dealer_email']; ?>">
																	<?php echo $deal['dealer_email']; ?>
																</a>
															</td>
														</tr>
														<tr>
															<td>Phone:</td>
															<td><?php echo $deal['dealer_phone']; ?></td>
														</tr>
														<tr>
															<td>Mobile:</td>
															<td><?php echo $deal['dealer_mobile']; ?></td>
														</tr>
														<?php
														$dealer_address = "";
														if ($deal['dealer_address'] <> "")
														{
															$dealer_address .= $deal['dealer_address'].", ";
														}
														
														if ($deal['dealer_postcode'] <> "")
														{
															$dealer_address .= "<br />".$deal['dealer_postcode']." ";
														}
														
														if ($deal['dealer_state'] <> "")
														{
															$dealer_address .= $deal['dealer_state'].", ";
														}
														$dealer_address .= "Australia";														
														?>
														<tr>
															<td>Address:</td>
															<td><?php echo $dealer_address; ?><br /><br /></td>
														</tr>														
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<?php
									$tradein_details = "";
									if ($deal['tradein_count'] > 0)
									{
										$root_url = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/";
										$tradein_details .= '
										<div class="row">
											<div class="col-md-12">
												<br />
												<h5>TRADEINS</h5>
												<div class="table-responsive">
													<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">										
														<tr>
															<td></td>
															<td><b>Vehicle</b></td>
															<td><b>TradeIn Value</b></td>
															<td><b>Buyer</b></td>
														</tr>';					
														$tradein_query = "
														SELECT
														t.id_tradein, 
														CONCAT('TI', LPAD(t.id_tradein, 5, '0')) AS `ti_number`,
														t.dealer_visibility,
														t.tradein_value, t.tradein_given, t.tradein_payout,
														t.tradein_make, t.tradein_model, t.tradein_variant, t.tradein_build_date, t.tradein_kms,
														t.tradein_colour, t.tradein_transmission, tv.value,
														u.id_user, u.username, u.name, u.phone, u.state, u.postcode, t.image_1
														FROM tradeins t
														LEFT JOIN trade_valuations tv ON t.fk_trade_valuation = tv.id_trade_valuation
														LEFT JOIN users u ON tv.fk_user = u.id_user
														WHERE t.fk_lead = '".$deal['id_lead']."'
														ORDER BY t.id_tradein DESC";
														$tradein_result = $this->db->query($tradein_query)->result_array();										
														foreach ($tradein_result as $tradein_row)
														{
															if ($tradein_row['image_1']=="") { $tradein_row['image_1'] = "no_image.png"; }
															$tradein_details .= '
															<tr>
																<td width="20%">
																	<center>
																		<br />
																		<img src="'.$root_url.$tradein_row['image_1'].'" class="img-responsive" width="90%">
																		<br />		
																		<a href="'.site_url('tradein/record_final/'.$tradein_row['id_tradein']).'" target="_blank">
																			'.$tradein_row['ti_number'].'
																		</a>
																		<br />
																	</center>
																</td>
																<td>
																	'.$tradein_row['tradein_make'].' '.$tradein_row['tradein_model'].'
																	<br />
																	'.$tradein_row['tradein_build_date'].' '.$tradein_row['tradein_variant'].'
																	<br />
																	'.$tradein_row['tradein_transmission'].' ('.$tradein_row['tradein_colour'].')
																</td>
																<td>
																	Real:
																	<br />
																	$ '.$tradein_row['tradein_value'].'
																	<br />
																	<br />
																	Shown:
																	<br />
																	$ '.$tradein_row['tradein_given'].'
																	<br />
																	<br />
																	Payout:
																	<br />
																	$ '.$tradein_row['tradein_payout'].'
																</td>';
																if ($tradein_row['id_user']==0)
																{
																	$tradein_details .= '<td>No selected buyer..</td>';
																}
																else
																{
																	$tradein_details .= '
																	<td>
																		'.$tradein_row['name'].'
																		<br />
																		<a href="mailto:'.$tradein_row['username'].'">
																			'.$tradein_row['username'].'
																		</a>
																		<br />
																		'.$tradein_row['phone'].'
																		<br />
																		'.$tradein_row['state'].'
																		<br />
																		'.$tradein_row['postcode'].'
																		<br />
																		<br />																	
																		Trade Value: <b>'.$tradein_row['value'].'</b>
																	</td>';																	
																}
																$tradein_details .= '
															</tr>';
														}
														$tradein_details .= '
													</table>
												</div>
											</div>
										</div>';
									}
									echo $tradein_details;
									?>
									<?php
									if ($status == 5 OR $status == 6 OR $status == 7)
									{
										?>
										<div class="row"> <!-- Actions -->
											<div class="col-md-12">
												<br />
												<a class="btn btn-primary" href="<?php echo site_url("deal/pdf_export/".$deal['id_lead']); ?>"  target="_blank">
													<i class="fa fa-file-pdf-o"></i> Purchase Order
												</a>
												<a class="btn btn-primary" href="<?php echo site_url("deal/dealer_invoice_pdf/".$deal['id_lead']); ?>"  target="_blank">
													<i class="fa fa-file-pdf-o"></i> Dealer Invoice
												</a>
												<a class="btn btn-primary" href="<?php echo site_url("deal/client_automated_invoice_pdf/".$deal['id_lead']); ?>"  target="_blank">
													<i class="fa fa-file-pdf-o"></i> Client Invoice
												</a>
											</div>
										</div>
										<?php
									}
									?>
								</div>
							</section>
							<?php
						}
					}
					?>
					<?php echo $links; ?>
					<!-- end: page -->
					<?php include 'modals/ticket_modals.php'; ?>
				</section>
			</div>
			<?php include 'template/right_sidebar.php'; ?>
		</section>		
		<?php include 'template/scripts.php'; ?>
	</body>
</html>
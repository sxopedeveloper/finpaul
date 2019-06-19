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
							<h2 class="panel-title">Quotations - <?php echo $quote_request['quote_number']; ?></h2>
						</header>
						<div class="panel-body">
							<div class="table-responsive">
								<h4>
									<?php
										echo $quote_request['make'] . ' ' . $quote_request['model'] . ' ' . $quote_request['variant'] . ' (' .  $quote_request['colour'] . ') '; 
									?>
								</h4>
								[ <a href="#" id="reverse-table">Change View</a> ]
								<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
									<tbody>
										<tr>
											<td><b>Sent by</b></td>
											<td><b>Status</b></td>
											<td><b>Dealership</b></td>
											<td><b>Fleet Manager</b></td>
											<td><b>Postcode</b></td>
											<td><b>State</b></td>
											<td><b>Mobile</b></td>
											<td><b>Phone</b></td>
											<td><b>Email</b></td>
											<td><b>Delivery Date</b></td>
											<td><b>Compliance Date</b></td>
											<td><b>List Price</b></td>
											<td><b>Fleet Manager's Discount</b></td>
											<td><b>Dealer Discount</b></td>
											<?php
											foreach ($options as $option)
											{
												echo "<td><b>Option</b>: ".$option->name."</td>";
											}											
											foreach ($accessories as $accessory)
											{
												echo "<td><b>Accessory</b>: ".$accessory->name."</td>";
											}			
											?>
											<td><b>Delivery Charge</b></td>
											<td><b>GST</b></td>
											<td><b>Luxury tax</b></td>
											<td><b>CTP</b></td>
											<td><b>Registration</b></td>
											<td><b>Premium Plate Fee</b></td>
											<td><b>Stamp Duty</b></td>
											<td><b>TOTAL INC GST</b></td>
											<td><b>Status</b></td>
										</tr>
										<?php
										foreach ($quotes as $quote)
										{
											if ($quote->status==0)
											{
												$quote_status = '<i><font color="#F00">Needs dealer confirmation</font></i>';
											}
											else
											{
												$quote_status = '<i class="fa fa-check"></i>';
											}
											?>
											<tr>
												<td><?php echo $quote->sender; ?> <i>(<?php echo $quote->created_at; ?>)</i></td>
												<td><?php echo $quote_status; ?></td>
												<td><?php echo $quote->dealership_name; ?></td>
												<td><?php echo $quote->manager_name; ?></td>																	
												<td><?php echo $quote->postcode; ?></td>
												<td><?php echo $quote->state; ?></td>
												<td><?php echo $quote->manager_mobile; ?></td>
												<td><?php echo $quote->manager_phone; ?></td>
												<td><?php echo $quote->username; ?></td>
												<td><?php echo $quote->delivery_date; ?></td>
												<td><?php echo $quote->compliance_date; ?></td>

												<td>$ <?php echo $quote->retail_price; ?></td>
												<td>(-) $ <?php echo $quote->fleet_discount; ?></td>
												<td>(-) $ <?php echo $quote->dealer_discount; ?></td>

												<?php
												$options_total = 0;
												foreach ($quote_options as $quote_option)
												{
													if ($quote_option->fk_quote == $quote->id_quote)
													{
														echo "<td>$ ".$quote_option->price."</td>";
														$options_total = $options_total + $quote_option->price;
													}
												}

												$accessories_total = 0;
												foreach ($quote_accessories as $quote_accessory)
												{
													if ($quote_accessory->fk_quote == $quote->id_quote)
													{												
														echo "<td>$ ".$quote_accessory->price."</td>";
														$accessories_total = $accessories_total + $quote_accessory->price;
													}
												}

												$subtotal_1 = $quote->retail_price - $quote->fleet_discount - $quote->dealer_discount;
												$subtotal_2 = $subtotal_1 + $options_total + $accessories_total + $quote->predelivery;
												$gst = ($subtotal_2) * 0.10;
												$subtotal_3 = $subtotal_2 + $gst;
												$total = $subtotal_3 + $quote->luxury_tax + $quote->ctp + $quote->registration + $quote->premium_plate_fee + $quote->stamp_duty;

												?>
												<td>$ <?php echo $quote->predelivery; ?></td>
												<td>$ <?php echo $gst; ?></td>
												<td>$ <?php echo $quote->luxury_tax; ?></td>
												<td>$ <?php echo $quote->ctp; ?></td>
												<td>$ <?php echo $quote->registration; ?></td>
												<td>$ <?php echo $quote->premium_plate_fee; ?></td>
												<td>$ <?php echo $quote->stamp_duty; ?></td>
												<td><b>$  <?php echo $total; ?></b></td>
												<td>
													<?php
													if ($quote_request['winner'] == $quote->id_quote)
													{
														?>
														<i class="fa fa-trophy"></i> Winner
														<?php
													}
													else
													{
														if ($quote->lead_status <= 3 OR $admin_type==2)
														{
															?>
															<a href="<?php echo site_url('lead/select_winner/'.$quote_request['id_quote_request'].'/'.$quote->id_quote); ?>">
																<i class="fa fa-star"></i> Select as Winner
															</a>
															<?php
														}
													}
													?>
												</td>
											</tr>		
											<?php
										}
										?>
									</tbody>
								</table>
								<br />
							</div>							
						</div>
					</section>
					<!-- end: page -->
					<?php include 'modals/ticket_modals.php'; ?>
				</section>
			</div>
			<?php include 'template/right_sidebar.php'; ?>
		</section>
		<?php include 'template/scripts.php'; ?>
		<script>
			$("#reverse-table").click(function(){
				$("table").each(function(){
					var $this = $(this);
					var newrows = [];
					
					$this.find("tr").each(function(){
						var i = 0;
						$(this).find("td, th").each(function(){
							
							i++;

							if (newrows[i] === undefined)
							{
								newrows[i] = $("<tr></tr>"); 
							}
							
							if (i == 1)
							{
								newrows[i].append("<th>" + this.innerHTML  + "</th>");
							}
							else
							{
								newrows[i].append("<td>" + this.innerHTML  + "</td>");
							}
						});
					});
					
					$this.find("tr").remove();
					
					$.each(newrows, function(){
						$this.append(this);
					});
				});
				return false;
			});			
		</script>		
	</body>
</html>
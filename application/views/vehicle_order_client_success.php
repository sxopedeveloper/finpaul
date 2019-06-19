<?php 
include 'admin/template/login_head.php'; 
?>
	<body>
		<div class="body">
			<?php include 'admin/template/login_header.php'; ?>
			<div role="main" class="main" style="border-top: 5px solid #58c603; padding-top: 40px;">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div id="car_details">
								<div class="row">
									<div class="col-md-12">
										<br />
										<center>
											<h3 style="color: #58c603; font-size: 2.3em;">
												<b>ORDER SUMMARY</b>
											</h3>
										</center>
										<div class="alert alert-warning">
											Your order has now been sent to the dealer and your documents will be sent to your email soon.
										</div>
										<br />	
									</div>
									<div class="col-md-7">
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
												<tbody>
													<tr>
														<td width="30%"><b>Make:</b></td>
														<td><?php echo $lead['tender_make']; ?></td>
													</tr>
													<tr>
														<td width="30%"><b>Model:</b></td>
														<td><?php echo $lead['tender_model']; ?></td>
													</tr>
													<tr>
														<td width="30%"><b>Variant:</b></td>
														<td><?php echo $lead['tender_variant']; ?></td>
													</tr>																
													<tr>
														<td><b>Build Date:</b></td>
														<td><?php echo $lead['build_date']; ?></td>
													</tr>																
													<tr>
														<td><b>Series:</b></td>
														<td><?php echo $lead['series']; ?></td>
													</tr>																
													<tr>
														<td><b>Colour:</b></td>
														<td><?php echo $lead['colour']; ?></td>
													</tr>
													<tr>
														<td><b>Body Type:</b></td>
														<td><?php echo $lead['body_type']; ?></td>																
													</tr>
													<tr>
														<td><b>Fuel Type:</b></td>
														<td><?php echo $lead['fuel_type']; ?></td>																
													</tr>																
													<tr>
														<td><b>Transmission:</b></td>
														<td><?php echo $lead['transmission']; ?></td>																
													</tr>
													<tr>
														<td><b>Registration Type:</b></td>
														<td><?php echo $lead['registration_type']; ?></td>																
													</tr>																
													<tr>
														<td><b>Rego Number:</b></td>
														<td><?php echo $lead['registration_plate']; ?></td>																
													</tr>
													<tr>
														<td><b>Rego Expiry:</b></td>
														<td><?php echo $lead['registration_expiry']; ?></td>																
													</tr>
													<tr>
														<td><b>New / Demo:</b></td>
														<td>
															<?php
															echo $lead['demo'];
															if ($lead['demo']=="Demo")
															{
																
																echo "<br />Odometer: ".$lead['kms'];
															}
															?>
														</td>																
													</tr>
													<tr>
														<td><b>Odometer:</b></td>
														<td><?php echo $lead['kms']; ?></td>																
													</tr>																
												</tbody>
											</table>
										</div>
										<br />
									</div>
									<div class="col-md-5">
										<h5><b>Factory-Fitted Options:</b></h5>
										<?php
										if (count($options)==0)
										{
											echo "<p><i>No records found..</i></p>";
										}
										else
										{
											echo "<ul>";											
											foreach ($options AS $option)
											{
												echo "<li>".$option->name."</li>";
											}
											echo "</ul>";											
										}
										?>
										<br />
										<h5><b>Dealer-Fitted Accessories:</b></h5>
										<?php						
										if (count($accessories)==0)
										{
											echo "<p><i>No records found..</i></p>";
										}
										else
										{
											echo "<ul>";
											foreach ($accessories AS $accessory)
											{
												echo "<li>".$accessory->name."</li>";
											}																											
											echo "</ul>";
										}
										?>
										<br />
										<h5><b>Price:</b></h5>
										<h4 style="color: #58c603">
											<?php echo "$ ".number_format($lead['sales_price'], 2); ?>
										</h4>
										<br />
										<p>
											<i>The price includes GST, Stamp Duty, CTP Insurance, 
											Registration, Plate Fees and is a "Drive Away" Price.
											The supplying dealer will supply a tax invoice showing
											the break-up of costs in accordance with individual
											state and territory laws.</i>
										</p>											
									</div>
								</div>
							</div>
							<?php
							if ($tradein_count > 0)
							{
								?>								
								<div id="tradein_details" class="tab-pane">								
									<div class="row">
										<div class="col-md-12">
											<br />
											<br />
											<br />
											<br />
											<center>
												<h3 style="color: #58c603; font-size: 2.0em;">
													<b>TRADE-IN DETAILS</b>
												</h3>							
											</center>
											<div class="alert alert-warning">
												Your trade-in details has now been sent to the buyer.
											</div>											
											<br />
										</div>
										<?php												
										foreach ($tradeins as $tradein)
										{
											if ($tradein['image_1']=="") { $tradein['image_1'] = "no_image.png"; }
											if ($tradein['image_2']=="") { $tradein['image_2'] = "no_image.png"; }
											if ($tradein['image_3']=="") { $tradein['image_3'] = "no_image.png"; }
											if ($tradein['image_4']=="") { $tradein['image_4'] = "no_image.png"; }
											?>
											<div class="col-md-5">
												<div class="owl-carousel" data-plugin-options='{"items": 1}'>
													<div>
														<div class="thumbnail">
															<img alt="Tradein Image 1" height="300" class="img-responsive" src="http://www.mytradevaluation.com.au/uploads/thumbnails_m/<?php echo $tradein['image_1']; ?>">
														</div>
													</div>
													<div>
														<div class="thumbnail">
															<img alt="Tradein Image 2" height="300" class="img-responsive" src="http://www.mytradevaluation.com.au/uploads/thumbnails_m/<?php echo $tradein['image_2']; ?>">
														</div>
													</div>
													<div>
														<div class="thumbnail">
															<img alt="Tradein Image 3" height="300" class="img-responsive" src="http://www.mytradevaluation.com.au/uploads/thumbnails_m/<?php echo $tradein['image_3']; ?>">
														</div>
													</div>
													<div>
														<div class="thumbnail">
															<img alt="Tradein Image 4" height="300" class="img-responsive" src="http://www.mytradevaluation.com.au/uploads/thumbnails_m/<?php echo $tradein['image_4']; ?>">
														</div>
													</div>												
												</div>
											</div>
											<div class="col-md-7">
												<p>
													<span style="font-size: 1.3em;"><b><?php echo $tradein['tradein_make']." ".$tradein['tradein_model']." (".$tradein['tradein_variant'].")"; ?></b></span>
													<br />
													Kms: <b><?php echo $tradein['tradein_kms']; ?></b>
												</p>
												<div class="table-responsive">
													<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
														<tbody>
															<tr>
																<td width="30%"><b>Build Date:</b></td>
																<td><?php echo $tradein['tradein_build_date']; ?></td>
															</tr>														
															<tr>
																<td><b>Compliance Date:</b></td>
																<td><?php echo $tradein['tradein_compliance_date']; ?></td>
															</tr>													
															<tr>
																<td><b>Colour:</b></td>
																<td><?php echo $tradein['tradein_colour']; ?></td>
															</tr>
															<tr>
																<td><b>Transmission:</b></td>
																<td><?php echo $tradein['tradein_transmission']; ?></td>
															</tr>
															<tr>
																<td><b>Body Type:</b></td>
																<td><?php echo $tradein['tradein_body_type']; ?></td>
															</tr>
															<tr>
																<td><b>Fuel Type:</b></td>
																<td><?php echo $tradein['tradein_fuel_type']; ?></td>
															</tr>
															<tr>
																<td><b>Drive Type:</b></td>
																<td><?php echo $tradein['tradein_drive_type']; ?></td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>										
											<?php
										}
										?>
									</div>
								</div>
								<?php												
							}
							?>
						</div>
					</div>
				</div>
			</div>
			<?php include 'admin/template/login_footer.php'; ?>
		</div>
		<?php include 'admin/template/login_scripts.php'; ?>
	</body>
</html>
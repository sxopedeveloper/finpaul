<?php include 'admin/template/login_head.php'; ?>
	<style>
		.text-line {
			background-color: transparent;
			color: #888;
			outline: none;
			outline-style: none;
			border-top: none;
			border-left: none;
			border-right: none;
			border-bottom: solid #ddd 1px;
			padding: 0px 0px;
			height: 22px;
			width: 100%;
		}	
		
		.ajax_button {
			cursor: pointer; 
			cursor: hand; 
			margin-bottom: 10px;
			width: 280px;
		}
		
		.ajax_button_primary {
			cursor: pointer; 
			cursor: hand; 
			margin-bottom: 10px;
			color: #58c603;
		}
		
		.container_bordered_round {
			padding: 20px; 
			border: 1px solid #ccc;			
			border-radius: 5px;
		}
	</style>
	<body>
		<div class="body">
			<?php include 'admin/template/login_header.php'; ?>
			<div role="main" class="main" style="border-top: 5px solid #58c603; padding-top: 40px;">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-12">
									<div id="step_1"> <!-- Introduction -->
										<div class="row">
											<div class="col-md-12 text-center">
												<input class="form-control" type="hidden" name="id" id="id" value="<?php echo $id; ?>" required>
												<input class="form-control" type="hidden" name="key" id="key" value="<?php echo $key; ?>" required>
												<h3 style="font-size: 2.1em; margin-top: 50px; line-height: 1.4em; margin-bottom: 15px;">
													<strong><span style="color: #58c603;">CONGRATULATIONS ON YOUR NEW CAR!</span></strong>
												</h3>
												<p style="font-size: 1.2em">
													Please click NEXT below to check and confirm your details and view your new car order.													
												</p>
												<br />
												<span class="btn btn-primary btn-lg ajax_button transfer_tab_button" data-id_lead="<?php echo $lead['id_lead']; ?>" data-step_number="1" data-direction="next">
													NEXT <i class="fa fa-caret-right"></i>
												</span>
												<br />
												<br />
												<br />
												<br />
											</div>									
										</div>
									</div>
									<div id="step_2" hidden="hidden"> <!-- Client Details-->
										<div class="row">
											<div class="col-md-6">
												<center>
													<h4 style="color: #58c603;">
														<b><i class="fa fa-user"></i> REGISTERED OWNER'S DETAILS</b>
													</h4>
												</center>
												<div style="border: 1px solid #fff; border-radius: 3px; padding: 20px;">
													<div class="form-group">
														<label class="col-md-4 control-label" for="inputDisabled">Full Name: <span class="required">*</span></label>
														<div class="col-md-8">
															<input class="form-control" type="text" name="name" id="name" value="<?php echo $lead['name']; ?>" required>
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label" for="inputDisabled">Occupation:</label>
														<div class="col-md-8">
															<input class="form-control" type="text" name="occupation" id="occupation" value="<?php echo $lead['occupation']; ?>">
														</div>
													</div>											
													<div class="form-group">
														<label class="col-md-4 control-label" for="inputDisabled">Business Name:</label>
														<div class="col-md-8">
															<input class="form-control" type="text" name="business_name" id="business_name" value="<?php echo $lead['business_name']; ?>">
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label" for="inputDisabled">ABN:</label>
														<div class="col-md-8">
															<input class="form-control" type="text" name="abn" id="abn" value="<?php echo $lead['abn']; ?>">
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label" for="inputDisabled">Date of Birth: <span class="required">*</span></label>
														<div class="col-md-8">
															<input class="main_datepicker form-control" type="text" name="date_of_birth" id="date_of_birth" value="<?php echo $lead['date_of_birth']; ?>" required>
														</div>
													</div>		
													<div class="form-group">
														<label class="col-md-4 control-label" for="inputDisabled">License Number: <span class="required">*</span></label>
														<div class="col-md-8">
															<input class="form-control" type="text" name="driver_license" id="driver_license" value="<?php echo $lead['driver_license']; ?>" required>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<center>
													<h4 style="color: #58c603;">
														<b><i class="fa fa-phone"></i> CONTACT DETAILS</b>
													</h4>
												</center>
												<div style="border: 1px solid #fff; border-radius: 3px; padding: 20px;">
													<div class="form-group">
														<label class="col-md-4 control-label" for="inputDisabled">Email: <span class="required">*</span></label>
														<div class="col-md-8">
															<input class="form-control" type="text" name="email" id="email" value="<?php echo $lead['email']; ?>" required>
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label" for="inputDisabled">Mobile: <span class="required">*</span></label>
														<div class="col-md-8">
															<input class="form-control" type="text" name="mobile" id="mobile" value="<?php echo $lead['mobile']; ?>" required>
														</div>
													</div>															
													<div class="form-group">
														<label class="col-md-4 control-label" for="inputDisabled">Phone: <span class="required">*</span></label>
														<div class="col-md-8">
															<input class="form-control" type="text" name="phone" id="phone" value="<?php echo $lead['phone']; ?>" required>
														</div>
													</div>											
													<div class="form-group">
														<label class="col-md-4 control-label" for="inputDisabled">Address: <span class="required">*</span></label>
														<div class="col-md-8">
															<input class="form-control" type="text" name="address" id="address" value="<?php echo $lead['address']; ?>" required>
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label" for="inputDisabled">Postcode: <span class="required">*</span></label>
														<div class="col-md-8">
															<input class="form-control" type="text" name="postcode" id="postcode" value="<?php echo $lead['postcode']; ?>" required>
														</div>
													</div>															
													<div class="form-group">
														<label class="col-md-4 control-label" for="inputDisabled">State: <span class="required">*</span></label>
														<div class="col-md-8">
															<?php
															if ($lead['state']=="ACT") { $selected_state_act = ' selected="selected"'; } else { $selected_state_act = ''; }
															if ($lead['state']=="NSW") { $selected_state_nsw = ' selected="selected"'; } else { $selected_state_nsw = ''; }
															if ($lead['state']=="NT") { $selected_state_nt = ' selected="selected"'; } else { $selected_state_nt = ''; }
															if ($lead['state']=="QLD") { $selected_state_qld = ' selected="selected"'; } else { $selected_state_qld = ''; }
															if ($lead['state']=="SA") { $selected_state_sa = ' selected="selected"'; } else { $selected_state_sa = ''; }
															if ($lead['state']=="TAS") { $selected_state_tas = ' selected="selected"'; } else { $selected_state_tas = ''; }
															if ($lead['state']=="VIC") { $selected_state_vic = ' selected="selected"'; } else { $selected_state_vic = ''; }
															if ($lead['state']=="WA") { $selected_state_wa = ' selected="selected"'; } else { $selected_state_wa = ''; }
															?>
															<select class="form-control" name="state" id="state" type="text" required>
																<option value="">-Select State-</option>
																<option value="ACT" <?php echo $selected_state_act ; ?>>Australian Capital Territory</option>
																<option value="NSW" <?php echo $selected_state_nsw ; ?>>New South Wales</option>
																<option value="NT" <?php echo $selected_state_nt ; ?>>Northern Territory</option>
																<option value="QLD" <?php echo $selected_state_qld ; ?>>Queensland</option>
																<option value="SA" <?php echo $selected_state_sa ; ?>>South Australia</option>
																<option value="TAS" <?php echo $selected_state_tas ; ?>>Tasmania</option>
																<option value="VIC" <?php echo $selected_state_vic ; ?>>Victoria</option>
																<option value="WA" <?php echo $selected_state_wa ; ?>>Western Australia</option>
															</select>					
														</div>
													</div>
												</div>
											</div>													
											<div class="col-md-12 text-center" style="margin-top: 15px;">
												<center>
													<span class="btn btn-primary btn-lg ajax_button transfer_tab_button" data-id_lead="<?php echo $lead['id_lead']; ?>" data-step_number="2" data-direction="previous">
														<i class="fa fa-caret-left"></i> PREVIOUS
													</span>															
													<span class="btn btn-primary btn-lg ajax_button transfer_tab_button" data-id_lead="<?php echo $lead['id_lead']; ?>" data-step_number="2" data-direction="next">
														NEXT <i class="fa fa-caret-right"></i>
													</span>
												</center>
											</div>
										</div>
									</div>
									<div id="step_3" hidden="hidden"> <!-- Car Details -->
										<div class="row">
											<div class="col-md-3">
												<?php $make_logo = base_url("assets/img/makes/".str_replace(' ', '_', strtolower($lead['tender_make'])).".png"); ?>
												<img src="<?php echo $make_logo; ?>" style="border: 1px solid #ddd;" width="100%">
												<br />
												<br />
												<?php
												if ($lead['delivery_date'] == "") { $lead['delivery_date'] = "N/A"; }
												if ($lead['delivery_address'] == "") { $lead['delivery_address'] = "N/A"; }
												if ($lead['delivery_instructions'] == "") { $lead['delivery_instructions'] = "N/A"; }
												if ($lead['special_conditions'] == "") { $lead['special_conditions'] = "N/A"; }
												?>
												<h5 style="margin-bottom: 5px;"><b>Price:</b></h5>
												<h4 style="color: #58c603">
													<?php echo "$ ".number_format($lead['sales_price'], 2); ?>
												</h4>
												<p>
													The price includes GST, Stamp Duty, CTP Insurance, 
													Registration, Plate Fees and is a "Drive Away" Price.
												</p>												
											</div>
											<div class="col-md-6">
												<h3 style="margin-bottom: 10px;"><b><?php echo $lead['build_date']." ".$lead['tender_make']." ".$lead['tender_model']; ?></b></h3>
												<p><?php echo $lead['tender_variant']; ?></p>
												<div class="table-responsive">
													<table class="table table-bordered table-condensed mb-none">
														<tbody>															
															<tr>
																<td width="30%"><b>Series:</b></td>
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
														</tbody>
													</table>
												</div>
												<br />
												<div class="table-responsive">
													<table class="table table-bordered table-condensed mb-none" style="white-space: nowrap;">																	
														<tbody>															
															<tr>
																<td width="30%"><b>Registration Type:</b></td>
																<td><?php echo $lead['registration_type']; ?></td>																
															</tr>
															<tr>
																<td><b>New / Demo:</b></td>
																<td><?php echo $lead['demo']; ?></td>																
															</tr>
															<?php
															if ($lead['demo']=="Demo")
															{	
																?>
																<tr>
																	<td><b>Odometer:</b></td>
																	<td><?php echo $lead['kms']; ?></td>																
																</tr>																																
																<?php
															}
															?>															
														</tbody>
													</table>
												</div>
												<br />
												<p>
													The supplying dealer will supply a tax invoice showing
													the break-up of costs in accordance with individual
													state and territory laws.
												</p>												
											</div>
											<div class="col-md-3">
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
											</div>
											<div class="col-md-12">			
												<center>
													<span class="btn btn-primary btn-lg ajax_button transfer_tab_button" data-id_lead="<?php echo $lead['id_lead']; ?>" data-step_number="3" data-direction="previous">
														 <i class="fa fa-caret-left"></i> PREVIOUS
													</span>															
													<span class="btn btn-primary btn-lg ajax_button transfer_tab_button" data-id_lead="<?php echo $lead['id_lead']; ?>" data-step_number="3" data-direction="next">
														NEXT <i class="fa fa-caret-right"></i>
													</span>
												</center>
											</div>
										</div>
									</div>
									<div id="step_4" hidden="hidden"> <!-- Delivery Details-->
										<div class="row">
											<div class="col-md-3">
											</div>											
											<div class="col-md-6">
												<center>
													<h3 style="margin-bottom: 10px;">
														<b>
															DELIVERY DETAILS
														</b>
													</h3>												
													<br />
													<p>
														The estimated delivery of your vehicle order is on <?php echo date('F d, Y', strtotime($lead['delivery_date'])); ?>
													</p>
													<br />
												</center>
												<h5><b>Delivery Address:</b></h5>
												<p><?php echo $lead['delivery_address']; ?></p>
												<h5><b>Delivery Instructions:</b></h5>
												<p><?php echo $lead['delivery_instructions']; ?></p>
												<h5><b>Special Conditions:</b></h5>
												<p><?php echo $lead['special_conditions']; ?></p>							
											</div>
											<div class="col-md-3">
											</div>																						
											<div class="col-md-12 text-center" style="margin-top: 15px;">
												<center>
													<span class="btn btn-primary btn-lg ajax_button transfer_tab_button" data-id_lead="<?php echo $lead['id_lead']; ?>" data-step_number="4" data-direction="previous">
														<i class="fa fa-caret-left"></i> PREVIOUS
													</span>															
													<span class="btn btn-primary btn-lg ajax_button transfer_tab_button" data-id_lead="<?php echo $lead['id_lead']; ?>" data-step_number="4" data-direction="next">
														NEXT <i class="fa fa-caret-right"></i>
													</span>
												</center>
											</div>
										</div>
									</div>									
									<?php
									if ($tradein_count > 0)
									{
										?>
										<div id="step_5" hidden="hidden"> <!-- Tradein Details -->
											<div class="row">											
												<?php
												foreach ($tradeins as $tradein)
												{
													if ($tradein['image_1']=="") { $tradein['image_1'] = "no_image.png"; }
													if ($tradein['image_2']=="") { $tradein['image_2'] = "no_image.png"; }
													if ($tradein['image_3']=="") { $tradein['image_3'] = "no_image.png"; }
													if ($tradein['image_4']=="") { $tradein['image_4'] = "no_image.png"; }
													?>
													<div class="col-md-12">
														<p style="margin-bottom: 5px;"><b>Trade-In Vehicle:</b></p>
														<h3 style="margin-bottom: 15px;">
															<b><?php echo $tradein['tradein_make']." ".$tradein['tradein_model']; ?></b>
														</h3>
													</div>
													<div class="col-md-4">
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
														<br />
													</div>
													<div class="col-md-8">
														<div class="table-responsive">
															<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
																<tbody>
																	<tr>
																		<td width="30%"><b>Variant:</b></td>
																		<td><?php echo $tradein['tradein_variant']; ?></td>
																	</tr>	
																	<tr>
																		<td><b>Kms:</b></td>
																		<td><?php echo $tradein['tradein_kms']; ?></td>
																	</tr>																		
																	<tr>
																		<td><b>Build Date:</b></td>
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
														<br />
														<br />														
													</div>
													<?php
												}
												?>
											</div>
											<div class="row">
												<div class="col-md-12">			
													<center>
														<span class="btn btn-primary btn-lg ajax_button transfer_tab_button" data-id_lead="<?php echo $lead['id_lead']; ?>" data-step_number="5" data-direction="previous">
															 <i class="fa fa-caret-left"></i> PREVIOUS
														</span>															
														<span class="btn btn-primary btn-lg ajax_button transfer_tab_button" data-id_lead="<?php echo $lead['id_lead']; ?>" data-step_number="5" data-direction="next">
															NEXT <i class="fa fa-caret-right"></i>
														</span>
													</center>
												</div>													
											</div>
										</div>
										<div id="step_6" hidden="hidden"> <!-- Tradein Declaration -->
											<div class="row">
												<div class="col-md-12">
													<center>
														<h3 style="margin-bottom: 15px;">
															<b>Tradein Declaration</b>
														</h3>
													</center>
													<br />
													<b>I declare that:</b>
													<br />
													<div class="form-group">
														<input type="hidden" name="id_tradein" id="id_tradein" value="<?php echo $tradein['id_tradein']; ?>"> 
														<input type="radio" name="declaration_1" value="2" class="declaration_radio_1" required> 
														The trade-in vehicle is not my property and I have the full authority of the owner to transfer all 
														right, title and interest in the vehicle to the Dealer
														<br />
														<input type="radio" name="declaration_1" value="1" class="declaration_radio_1" required> 
														The trade-in vehicle is my own property
														<span id="tradein_purchased_from" hidden>
															and was purchased from:
															<input style="margin-top: 8px;" type="text" class="form-control input-sm" name="tradein_purchased_from" id="tradein_purchased_from">
														</span>
														<br />
													</div>																		
													<div class="form-group">
														<b>I declare that:</b>
														<br />
														<input type="radio" name="declaration_2" value="1" class="declaration_radio_2" required> 
														Title to the trade-in vehicle is not encumbered in any way and there are no monies owing to any person 
														in respect to it.
														<br />
														<input type="radio" name="declaration_2" value="2" class="declaration_radio_2"> 
														The trade-in vehicle is encumbered
														<span id="tradein_encumbered_by" hidden>
															by:
															<input style="margin-top: 8px;" type="text" class="form-control input-sm" name="tradein_encumbered_by">
														</span>
														<br />
													</div>
													<div class="form-group">
														<b>The supplier of the trade-in vehicle clearly declares that the supplying entity:</b>
														<br />
														<input type="radio" name="declaration_payg" value="1" class="declaration_radio_3" required>
														Will provide a Tax Invoice for the supply of the above described trade-in vehicle as it holds an ABN 
														<span id="tradein_abn_holder" hidden>
															which is
															<input style="margin-top: 8px; margin-bottom: 8px;" type="text" name="tradein_abn_holder" class="form-control input-sm" placeholder="ABN">
														</span>																
														and it is registered for GST purposes.
														<br />
														<input type="radio" name="declaration_payg" value="2" class="declaration_radio_3"> 
														Will not be providing a Tax Invoice for the supply of the above described trade-in vehicle
														<br />
														<p id="tradein_not_providing_abn_span" style="margin-left: 30px;" hidden>
															<input type="radio" name="tradein_not_providing" value="1" class="declaration_radio_4">
															Because the supply is made by it as an individual and is wholly private or domestic in nature
															<br />
															<input type="radio" name="tradein_not_providing" value="2" class="declaration_radio_4">
															Because it holds an ABN
															<span id="tradein_not_providing_abn" hidden>
																which is
																<input style="margin-top: 8px; margin-bottom: 8px;" type="text" name="tradein_not_providing_abn" class="form-control input-sm" placeholder="ABN">
															</span>
															but is not registered for GST purposes.
														</p>
													</div>
													<div class="form-group">
														<ul>
															<li>
																To the best of my knowledge, the odometer reading detailed above is a true 
																representation of the distance travelled by the trade-in vehicle.
															</li>
															<li>
																I am not bankrupt and have not committed any act of bankruptcy. If I sign 
																these particulars on behalf of a company, I declare that the company is not
																in liquidation or under receivership or under official management
															</li>
															<li>
																To the best of my knowledge, the trade-in vehicle has never been used as a 
																taxi, hire car or rental car and has never been subject to flood conditions, 
																hail damage or insurance write-off.
															</li>
															<li>
																The registration on the trade-in vehicle has not been cancelled nor am I 
																aware of any circumstances which would cause the registration to be cancelled 
																and no pension or other concessional rebate is applicable to the registration 
																of the trade-in vehicle.
															</li>
															<li>
																To the best of my knowledge there are no fines or infringement notices 
																outstanding in relation to the trade-in vehicle.
															</li>
														</ul>
													</div>												
												</div>
												<div class="col-md-12">		
													<br />
													<center>
														<span class="btn btn-primary btn-lg ajax_button transfer_tab_button" data-id_lead="<?php echo $lead['id_lead']; ?>" data-step_number="6" data-direction="previous">
															 <i class="fa fa-caret-left"></i> PREVIOUS
														</span>															
														<span class="btn btn-primary btn-lg ajax_button transfer_tab_button" data-id_lead="<?php echo $lead['id_lead']; ?>" data-step_number="6" data-direction="next" data-tab_type="tradein_declaration">
															NEXT <i class="fa fa-caret-right"></i>
														</span>
													</center>
												</div>										
											</div>
										</div>
										<?php
										$next_step_number = 7;
									}
									else
									{
										$next_step_number = 5;
									}
									?>
									<div id="step_<?php echo $next_step_number; ?>" hidden="hidden"> <!-- Order Confirmation -->
										<div class="row">
											<div class="col-md-2">
											</div>
											<div class="col-md-8">
												<center>
													<h3 style="margin-bottom: 10px;"><b>TERMS AND CONDITIONS</b></h3>
													<p>Unless otherwise stated, the Customer and Dealer agree as follows:</p>														
												</center>
												<div class="well well-sm pre-scrollable">
													<p align="justify">
														<b>1.1</b> The Purchase Price of the motor vehicle is the amount shown as <b>"Total Purchase Amount"</b>.
													</p>
													<p align="justify">
														<b>1.2</b> The Purchase Price may be varied if before the delivery of the motor vehicle, there is a change 
														in the manufacturer's recommended retail price, statutory charges or applicable taxes and duties. The Dealer 
														shall give the Customer & <?php echo $company['company_name']; ?> written notice of any variation in the Purchase Price. If the purchase 
														price is varied due to an increase in the recommended retail price, the Customer may rescind this Contract 
														any time within three (3) days after receipt of the written notice of the variation.
													</p>
													<p align="justify">
														<b>2.1</b> The Dealer shall use its best endeavours to acquire the motor vehicle by the estimated delivery 
														date, but shall not be liable to the customer for any damage or loss whatsoever arising either directly or 
														indirectly from any such delay or failure of delivery.
													</p>
													<p align="justify">
														<b>2.2</b> The Customer shall take delivery of the motor vehicle at the Dealer's Premises within (7) 
														days of the Dealer notifying the Customer that the motor vehicle is available for delivery.
													</p>
													<p align="justify">
														<b>2.3</b> If Dealer has not delivered the motor vehicle to the Customer within thirty (30) days of 
														the estimated delivery date, the Customer may by notice in writing to the Dealer rescind this Contract.
													</p>
													<p align="justify">
														<b>2.4</b> Both the Dealer and the Customer acknowledge by signing this Clause in the space provided 
														below that the motor vehicle is of unusual design or combines unusual options and that the Customer 
														waives his right to rescission as provided in Clause 2.3.
													</p>
													<p align="justify">
														<b>3.1</b> At or before taking delivery of the motor vehicle the Customer shall pay to the Dealer the 
														balance of the Purchase Price shown as "Total Purchase Amount".
													</p>
													<p align="justify">
														<b>3.2</b> Before taking delivery of the motor vehicle the Customer shall deliver to the Dealer the 
														trade-in vehicle together with all accessories, extras and attachments fitted at the time of valuation. 
														If the trade-in vehicle is not in substantially the same condition as when valued by the Dealer, the 
														parties may negotiate a variation in the net trade-in allowance or either party may rescind this 
														contract.
													</p>
													<p align="justify">
														<b>3.3</b> Until the Dealer has received payment in full of the quoted price issued to <?php echo $company['company_name']; ?>, 
														title in the motor vehicle shall not pass to the Customer and the Customer shall hold possession 
														of it as bailee only.
													</p>
													<p align="justify">
														<b>3.4</b> The Customer shall be deemed not to have paid the purchase price until the Dealer 
														receives payment and unencumbered title to any trade-in vehicle and all other payments are credited 
														to the Dealer's account.
													</p>
													<p align="justify">
														<b>3.5</b> While the Customer holds possession of the motor vehicle as bailee he/she:
													</p>		
													<p align="justify">
														<b>(a)</b> is responsible for its proper care and maintenance;
													</p>
													<p align="justify">
														<b>(b)</b> is liable for any loss or damage occasioned to it subject to the Customer's obligations, 
														if the contract is terminated under any Cooling Off Right applicable to the Contract; and
													</p>	
													<p align="justify">
														<b>(c)</b> will indemnify the Dealer against any claim arising from its use.
													</p>
													<p align="justify">
														<b>3.6</b> Where the Dealer is entitled to reclaim possession of the motor vehicle, the Customer 
														authorises the Dealer, its servants and agents to lawfully enter the Customers property for the 
														purposes of retaking possession.
													</p>
													<p align="justify">
														<b>3.7</b> The Dealer and Customer acknowledge <?php echo $company['company_name']; ?> P/L as the introducer of customer to 
														dealership. Vehicle Payments or deposits taken by <?php echo $company['company_name']; ?> are forwarded (less any outstanding 
														associated invoices) to the dealer 48 hours before the delivery date shown.
													</p>
													<p align="justify">
														<b>3.8</b> The supplying new car dealer is not responsible for the trade vehicle if there is an 
														alternate dealer licence nominated below. Instead the nominated purchasing agent will pay via eft 
														the valued amount (less <?php echo $company['company_name']; ?> Fees) to the dealer supplying the new car. (This amount is the 
														dealer quoted price - the client changeover price)
													</p>															
													<p align="justify">
														<b>4.1</b> Where the Customer requires finance to be provided for the payment of the motor vehicle, 
														the Customer shall promptly provide the Dealer and/or Financier with information necessary to allow 
														a determination of the Customer's finance application.
													</p>
													<p align="justify">
														<b>4.2</b> Where the Customer advises the Dealer before entering into this Contract that he/she 
														requires credit to be provided for the payment of the motor vehicle and having taken reasonable 
														steps has been unable to obtain credit, the Customer may within a reasonable period by notice in 
														writing given to the Dealer rescind the contract.
													</p>
													<p align="justify">
														<b>5.</b> Where the Customer refuses or fails to take delivery of the motor vehicle other than 
														under the cooling off right under section 29CA the Motor Dealers Act 1974 (NSW) applicable to this 
														contract (Cooling Off Right) or is otherwise in breach of his obligations under this Contract, the 
														Dealer may terminate this Contract by written notice to the Customer.
														<br />
														Thereafter any deposit paid or payable by the Customer to an amount not exceeding 5% of the total 
														Purchase Price of the vehicle shall be forfeited to the Dealer. Both parties acknowledge that the 
														Dealer shall be entitled to claim by way of pre-estimated liquidated damages from the Customer an 
														amount equal to 5% of the "Total Purchase Amount" less any deposit forfeited.
													</p>
													<p align="justify">
														<b>6.</b> Where this Contract is lawfully rescinded (otherwise than by exercise of the Cooling 
														Off Right), the dealer shall refund any monies paid by the Customer and where possible return the 
														trade-in vehicle PROVIDED THAT the Dealer shall retain from any monies due to the Customer the 
														actual costs of repairs and improvements, including GST, to the trade-in vehicle and any payouts 
														made or to be made by the Dealer to clear any encumbrances- Where the Dealer has disposed of the 
														trade-in vehicle the Customer shall accept $________ which the parties agree is fair and reasonable
														compensation.
													</p>
													<p align="justify">
														<b>7.</b> If the Customer is entitled and duly elects to terminate this contract under the Cooling 
														Off Right;
													</p>
													<p align="justify">
														<b>7.1</b> the Customer is liable to the dealer for any damage to the motor vehicle while it was in 
														the Customer's possession, other than fair wear and tear;
													</p>		
													<p align="justify">
														<b>7.2</b> the Dealer need not return any trade in vehicle if the dealer is unable to return it because 
														of a defect in the trade in vehicle, not caused by the Dealer, that renders the trade in vehicle 
														incapable of being driven or unroadworthy, but the Dealer must permit, and the Customer must arrange 
														for, the collection of the trade in vehicle from the Dealer with in 24 hours of exercise of the Cooling 
														Off Right;
													</p>
													<p align="justify">
														<b>7.3</b> the Customer (if the Customer has accepted delivery of the motor vehicle before termination) 
														must return the motor vehicle to the Dealer unless the Customer is not able to return it because the 
														motor vehicle because of a defect in the motor vehicle, not ceased by the Customer that has rendered 
														the motor vehicle incapable of being driven or unroadworthy in which case the Customer must permit, 
														and the Dealer must arrange for, the collection of the motor vehicle; and
													</p>
													<p align="justify">
														<b>7.4</b> any "tied loan contract" within the meaning of the Consumer Credit (New South Wales) Code 
														is terminated and section 125(2)-(6 of the Code applies to that termination as if it were a termination 
														referred to in that section.
													</p>
													<p align="justify">
														<b>8.</b> No warranties apply to this Contract with the exception of any which have been implied pursuant 
														to any Commonwealth or State law and which may not by law be exclused therefrom together with any expressed 
														warranties, the term of which are set out herein.
													</p>
													<p align="justify">
														<b>9.</b> Any addition to or variation of these terms and conditions will have no effect unless made in 
														writing and signed by the parties to this Contract.
													</p>
													<hr />
													<center>
														<p><b>PRIVACY STATEMENT</b></p>
													</center>
													<p align="justify">
														<b>1.</b> The Dealer is an organisation bound by the National Privacy Principles under the Privacy Act 
														1988. A copy of the Principles is available for perusal at the Dealer's premises or from the Office of 
														the National Privacy Commissioner.
													</p>
													<p align="justify">
														<b>2.</b> The kind of information the dealer holds is that detailed within this contract document or 
														other information necessary to establish the Customer's identification.
													</p>
													<p align="justify">
														<b>3.</b> The main purposes the Dealer will use this information will be to facilitate the delivery of 
														the goods which are the subject of this contract; and to meet the requirements of government authorities 
														and third party suppliers associated with the supply of the motor vehicle and related goods. Associated 
														services will include the vehicle and the provision of warranty and servicing for the vehicle; insurance 
														and registration of the vehicle; and the provision of information about new products related to vehicle 
														use which becomes available from time to time.
													</p>								
													<p align="justify">
														<b>4.</b> The kinds of people that may be provided with information relating to you will include the NSW 
														Roads and Traffic Authority, insurance companies, suppliers of cars and other automotive products and 
														services.
													</p>
													<p align="justify">
														<b>5.</b> If you have any query or concerns about the way the Dealer manages your personal information, 
														you should contact your sales consultant.
													</p>
													<p align="justify">
														<b>6.</b> You may request access to your personal information held by the Dealer, by contacting the person 
														nominated in clause 5 above.
													</p>
													<hr />
													<center>
														<p><b>DETERMINATION AS TO CREDIT</b></p>
													</center>
													<p align="justify">
														<b>1.</b> The Customer does not require credit from any source to be provided for the payment of the motor 
														vehicle, OR
													</p>															
													<p align="justify">
														<b>2.</b> The customer requires credit to be provided before effect can be given to the Contract and will 
														take reasonable steps themselves to arrange credit without delay. OR
													</p>
													<p align="justify">
														<b>3.</b> The customer requires credit to be provided before effect can be given to the Contract and authorises 
														the Dealer to arrange credit on his/her behalf
													</p>
													<hr />
													<p>
														<b><i>Where the dealer supplying the new car is not the dealer or wholesaler that is purchasing the trade vehicle.</i></b>
													</p>
													<p style="color: red">
														<b>THE RED TERMS AND CONDITIONS ARE ONLY IN THE AGREEMENT IF THERE IS A TRADE AND ITS THE DEALER TAKING IT</b>
													</p>
													<p style="color: red" align="justify">
														<b>3.2</b> Before taking delivery of the motor vehicle the Customer shall deliver to the Dealer the trade-in vehicle 
														together with all accessories, extras and attachments fitted at the time of valuation. If the trade-in vehicle is not 
														in substantially the same condition as when valued by the Dealer, the parties may negotiate a variation in the net 
														trade-in allowance or either party may rescind this contract. In the event that the trade vehicle
													</p>
													<p style="color: red" align="justify">
														<b>3.3</b> Until the Dealer has received payment in full of the Quoted Price issued to <?php echo $company['company_name']; ?>, title in the motor 
														vehicle shall not pass to the Customer and the Customer shall hold possession of it as bailee only.
													</p>															
													<p style="color: red" align="justify">
														<b>3.4</b> The Customer shall be deemed not to have paid the purchase price until the Dealer receives payment and 
														unencumbered title to any trade-in vehicle and all other payments are credited to the Dealer's account.															
													</p>
													<p align="justify">
														<b>3.2</b> If the trade in vehicle is not being traded by the supplying dealer <?php echo $company['company_name']; ?> will have nominated an alternate wholesaler to purchase the
														vehicle. The new car supplying dealer agrees to hold the traded vehicle and release it to the nominated wholesale buyer upon receiving
														payments totalling the dealers quoted price on the new car. On behalf of the nominated buying dealer <?php echo $company['company_name']; ?> will provisionally value the
														trade in vehicle based on the customer’s description of it. Subject to the following, the valuation will be valid for 30 days, after which the tradein
														vehicle will need to be re-valued. As the customer is permitted to use the vehicle between initial valuation and delivery of new car, the
														customer is responsible for the following whilst the trade-in is in their possession; proper care and maintenance (including but not exclusive to
														the following: servicing, tyres, and mechanical repairs), registration renewals, loss or damage to the vehicle, insurance claims, and
														depreciation. Any kilometres travelled above the odometer cap provided will be charged at 25c/kilometre, further depreciation may also be
														charged beyond this following the aforementioned 30 day period. Despite the foregoing, the sum to be paid or allowed to the customer for the
														trade in vehicle will be its actual value (determined by <?php echo $company['company_name']; ?>) at the time of delivery of the trade in vehicle to <?php echo $company['company_name']; ?> or a wholesale
														agent nominated by <?php echo $company['company_name']; ?>. Variations in value may be caused by errors in description of vehicles details (including but not limited to the
														following examples) Build Year, Make, Model, Series, Fuel Type, Transmission, Body Shape, Odometer, External Condition, Interior
														Condition, Mechanical & Electrical Performance. Please ensure that the description contained within this contract is a true and accurate
														representation of your vehicle.
													</p>
													<p align="justify">
														<b>3.3a</b> The customer must pay or allow to <?php echo $company['company_name']; ?> on demand the difference (if any) between the value of the
														trade in vehicle provisionally determined by <?php echo $company['company_name']; ?> and the actual value of the trade in vehicle when delivered to <?php echo $company['company_name']; ?> or its
														nominated wholesale agent. Variations in the actual value up to three thousand dollars will be immediately charged to your nominated credit
														card where possible. Variations that are greater than three thousand dollars in value will require an EFT transfer to <?php echo $company['company_name']; ?>, upon request.																
													</p>
													<p align="justify">
														<b>3.3b</b> Until the Dealer has received payment in full of the Quoted Price issued to <?php echo $company['company_name']; ?>, title in the 
														motor vehicle shall not pass to the Customer and the Customer shall hold possession of it as bailee only. 3.3c The Customer shall be 
														deemed not to have paid the purchase price until the Dealer receives payment and the nominated wholesaler buying the traded vehicle has 
														unencumbered title to any trade-in vehicle and all other payments are credited to the Dealer's account.
													</p>
												</div>
												<div class="form-group">
													<div class="col-md-12 text-center">
														<input type="checkbox" id="order_details_confirmation" name="order_details_confirmation">
														&nbsp;&nbsp;I confirm that all the details on this order are accurate
													</div>												
													<div class="col-md-12 text-center">
														<input type="checkbox" id="terms_confirmation" name="terms_confirmation">
														&nbsp;&nbsp;I accept <?php echo $company['company_name']; ?>'s Terms and Conditions
													</div>
												</div>														
											</div>
											<div class="col-md-2">
											</div>
											<div class="col-md-12">
												<br />											
												<center>
													<span class="btn btn-primary btn-lg ajax_button transfer_tab_button" data-id_lead="<?php echo $lead['id_lead']; ?>" data-step_number="<?php echo $next_step_number; ?>" data-direction="previous">
														 <i class="fa fa-caret-left"></i> PREVIOUS
													</span>																											
													<span class="btn btn-primary btn-lg ajax_button confirm_button" data-id_lead="<?php echo $lead['id_lead']; ?>" data-step_number="<?php echo $next_step_number; ?>">
														NEXT <i class="fa fa-caret-right"></i>
													</span>			
												</center>
											</div>
										</div>
									</div>
									<div id="congratulations_tab" hidden="hidden"> <!-- Congratulations -->
										<div class="row">
											<div class="col-md-12 text-center">
												<h3 style="font-size: 2.1em; margin-top: 50px; line-height: 1.4em; margin-bottom: 15px;">
													<strong><span style="color: #58c603;">Congratulations on your new car purchase</span></strong>
												</h3>
												<p style="font-size: 1.2em">
													Your purchase order has been sent to your email account, your deposit has been processed 
													successfully. 
													<br />
													Please expect a call from your suppling dealer within 24 hours. Your suppling 
													dealer contact details <br />can be found on your purchase order sent to your email account.												
												</p>
												<p style="font-size: 1.2em">
													Please contact your <b><?php echo $company['company_name']; ?></b> consultant should you need.												
												</p>
												<p style="font-size: 1.2em">
													We wish you many happy and safe kilometres in your new car.									
												</p>												
												<br />
												<br />
											</div>									
										</div>
									</div>									
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
			$("#submit_form").click(function() {

				var id = $("#id").val();
				var key = $("#key").val();
				var name = $("#name").val();
				var occupation = $("#occupation").val();
				var business_name = $("#business_name").val();
				var abn = $("#abn").val();
				var date_of_birth = $("#date_of_birth").val();
				var driver_license = $("#driver_license").val();
				var email = $("#email").val();
				var phone = $("#phone").val();
				var mobile = $("#mobile").val();
				var address = $("#address").val();
				var postcode = $("#postcode").val();
				var state = $("#state").val();
				var id_tradein = $("#id_tradein").val();
				var declaration_1 = $("input[name=declaration_1]:checked").val();
				var tradein_purchased_from = $("input[name=tradein_purchased_from]").val();
				var declaration_2 = $("input[name=declaration_2]:checked").val();
				var tradein_encumbered_by = $("input[name=tradein_encumbered_by]").val();
				var declaration_payg = $("input[name=declaration_payg]:checked").val();
				var tradein_abn_holder = $("input[name=tradein_abn_holder]").val();
				var tradein_not_providing = $("input[name=tradein_not_providing]:checked").val();
				var tradein_not_providing_abn = $("input[name=tradein_not_providing_abn]").val();
				var data = {
					id: id,
					key: key,
					name: name,
					occupation: occupation,
					business_name: business_name,
					abn: abn,
					date_of_birth: date_of_birth,
					driver_license: driver_license,
					email: email,
					phone: phone,
					mobile: mobile,					
					address: address,
					postcode: postcode,
					state: state,
					id_tradein: id_tradein,
					declaration_1: declaration_1,
					tradein_encumbered_by: tradein_encumbered_by,
					declaration_2: declaration_2,
					tradein_purchased_from: tradein_purchased_from,
					declaration_payg: declaration_payg,
					tradein_abn_holder: tradein_abn_holder,
					tradein_not_providing: tradein_not_providing,
					tradein_not_providing_abn: tradein_not_providing_abn
				};

				$.ajax({
					type: "POST",
					url: "<?php echo site_url('vehicle_order/confirm_deal'); ?>",
					data: data,
					cache: false,
					success: function(response){
						if (response === "success")
						{
							alert ("Thank you for confirming your order!");
							window.location.href = "<?php echo site_url("vehicle_order/client_agreement?id=".$id."&key=".$key); ?>";
							return false;
						}
						else
						{
							alert("An error has occured! Please make sure all your inputs are correct");
						}
					}
				});
			});
			
			$(document).ready(function(){
				$(document).on("change", ".declaration_radio_1", function(){
					var this_val = $(this).val();
					if(this_val == 1)
					{
						$("#tradein_purchased_from").prop("hidden", false);
					}
					else
					{
						$("#tradein_purchased_from").prop("hidden", true);	
					}
				});
				
				$(document).on("change", ".declaration_radio_2", function(){
					var this_val = $(this).val();
					if(this_val == 2)
					{
						$("#tradein_encumbered_by").prop("hidden", false);
					}
					else
					{
						$("#tradein_encumbered_by").prop("hidden", true);	
					}
				});				

				$(document).on("change", ".declaration_radio_3", function(){
					var this_val = $(this).val();
					if(this_val == 1)
					{
						$("#tradein_abn_holder").prop("hidden", false);
						$("#tradein_not_providing_abn_span").prop("hidden", true);
					}
					else
					{
						$("#tradein_abn_holder").prop("hidden", true);
						$("#tradein_not_providing_abn_span").prop("hidden", false);
					}
				});

				$(document).on("change", ".declaration_radio_4", function(){
					var this_val = $(this).val();
					if(this_val == 1)
					{
						$("#tradein_not_providing_abn").prop("hidden", true);
					}
					else
					{
						$("#tradein_not_providing_abn").prop("hidden", false);
					}
				});
				
				$(document).on("click", ".transfer_tab_button", function(){
					var step_number = $(this).data("step_number");
					var direction = $(this).data("direction");
					var tab_type = $(this).data("tab_type");

					var previous_step_number = step_number - 1;
					var next_step_number = step_number + 1;
					
					if (tab_type=="tradein_declaration")
					{
						var declaration_1 = $("input[name=declaration_1]:checked").val();
						var tradein_purchased_from = $("input[name=tradein_purchased_from]").val();
						
						var declaration_2 = $("input[name=declaration_2]:checked").val();
						var tradein_encumbered_by = $("input[name=tradein_encumbered_by]").val();

						var declaration_payg = $("input[name=declaration_payg]:checked").val();
						var tradein_abn_holder = $("input[name=tradein_abn_holder]").val();
						var tradein_not_providing = $("input[name=tradein_not_providing]:checked").val();
						var tradein_not_providing_abn = $("input[name=tradein_not_providing_abn]").val();
						
						var error = 0;
						
						if (typeof(declaration_1) == "undefined" || typeof(declaration_2) == "undefined" || typeof(declaration_payg) == "undefined")
						{
							swal("", "Please complete the Tradein Declaration Form", "error");
							exit();
						}
						
						if (declaration_1 == 1)
						{
							if (tradein_purchased_from == "")
							{
								swal("", "Please indicate where the vehicle was purchased from", "error");
								exit();
							}
						}
						
						if (declaration_2 == 2)
						{
							if (tradein_encumbered_by == "")
							{
								swal("", "Please indicate where the vehicle was emcumbered from", "error");
								exit();
							}
						}
						
						if (declaration_payg == 1)
						{
							if (tradein_abn_holder == "")
							{
								swal("", "Please indicate the ABN", "error");
								exit();
							}
						}
						else if (declaration_payg == 2)
						{
							if (typeof(tradein_not_providing) == "undefined")
							{
								swal("", "Please complete the Tradein Declaration Form", "error");
								exit();
							}
							else
							{
								if (tradein_not_providing == 2)
								{
									if (tradein_not_providing_abn == "")
									{
										swal("", "Please indicate the ABN", "error");
										exit();
									}									
								}
							}
						}	
					}
					
					$("#step_"+step_number).prop("hidden", true);
					if (direction == "next")
					{
						$("#step_"+next_step_number).prop("hidden", false);
					}
					else
					{
						$("#step_"+previous_step_number).prop("hidden", false);
					}											
				});
				
				$(document).on("click", ".confirm_button", function(){
					var step_number = $(this).data("step_number");
					
					if ($("#order_details_confirmation").prop("checked"))
					{
						
					}
					else
					{
						swal("", "Please click on the checkbox if you confirm all the details are correct", "error");
						exit();						
					}
					
					if ($("#terms_confirmation").prop("checked"))
					{
						
					}
					else
					{
						swal("", "Please click on the checkbox if you agree to our Terms and Conditions", "error");
						exit();						
					}					

					var id = $("#id").val();
					var key = $("#key").val();
					var name = $("#name").val();
					var occupation = $("#occupation").val();
					var business_name = $("#business_name").val();
					var abn = $("#abn").val();
					var date_of_birth = $("#date_of_birth").val();
					var driver_license = $("#driver_license").val();
					var email = $("#email").val();
					var phone = $("#phone").val();
					var mobile = $("#mobile").val();
					var address = $("#address").val();
					var postcode = $("#postcode").val();
					var state = $("#state").val();
					var id_tradein = $("#id_tradein").val();
					var declaration_1 = $("input[name=declaration_1]:checked").val();
					var tradein_purchased_from = $("input[name=tradein_purchased_from]").val();
					var declaration_2 = $("input[name=declaration_2]:checked").val();
					var tradein_encumbered_by = $("input[name=tradein_encumbered_by]").val();
					var declaration_payg = $("input[name=declaration_payg]:checked").val();
					var tradein_abn_holder = $("input[name=tradein_abn_holder]").val();
					var tradein_not_providing = $("input[name=tradein_not_providing]:checked").val();
					var tradein_not_providing_abn = $("input[name=tradein_not_providing_abn]").val();
					var data = {
						id: id,
						key: key,
						name: name,
						occupation: occupation,
						business_name: business_name,
						abn: abn,
						date_of_birth: date_of_birth,
						driver_license: driver_license,
						email: email,
						phone: phone,
						mobile: mobile,					
						address: address,
						postcode: postcode,
						state: state,
						id_tradein: id_tradein,
						declaration_1: declaration_1,
						tradein_encumbered_by: tradein_encumbered_by,
						declaration_2: declaration_2,
						tradein_purchased_from: tradein_purchased_from,
						declaration_payg: declaration_payg,
						tradein_abn_holder: tradein_abn_holder,
						tradein_not_providing: tradein_not_providing,
						tradein_not_providing_abn: tradein_not_providing_abn
					};
			
					$.ajax({
						type: "POST",
						url: "<?php echo site_url('vehicle_order/confirm_deal'); ?>",
						data: data,
						cache: false,
						success: function(response){
							if (response === "success")
							{
								$("#step_"+step_number).prop("hidden", true);
								$("#congratulations_tab").prop("hidden", false);
							}
							else
							{
								swal("ERROR", "Please contact the administrator.", "error");
							}
						}
					});
				});				
			});			
		</script>
	</body>
</html>
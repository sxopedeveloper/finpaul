<?php include 'admin/template/head.php'; ?>
	<body>
		<div class="full_loader"></div>
		<section class="body">
			<?php include 'admin/template/header.php'; ?>
			<div class="inner-wrapper">
				<?php include 'admin/template/left_sidebar.php'; ?>
				<section role="main" class="content-body has-toolbar">
					<?php include 'admin/template/header_2.php'; ?>
					<div class="inner-toolbar clearfix">
						<ul>
							<li class="right">
								<ul class="nav nav-pills nav-pills-primary">
									<?php 
									$new_active = " ";
									$delivery_pending_active = " ";
									$delivered_active = " ";
									$label_text = "";
									if ($order_status == 0)
									{
										$new_active = ' class="active"'; 
										$label_text = "new orders";
									}
									else if ($order_status == 1) 
									{
										$delivery_pending_active = ' class="active"'; 
										$label_text = "deliveries pending";
									}
									else if ($order_status == 2)
									{
										$delivered_active = ' class="active"'; 
										$label_text = "delivered orders";
									}
									?>
									<li <?php echo $new_active; ?>>
										<a href="<?php echo site_url('user/orders?status=0'); ?>">New Orders</a>
									</li>
									<li <?php echo $delivery_pending_active; ?>>
										<a href="<?php echo site_url('user/orders?status=1'); ?>">Deliveries Pending</a>
									</li>
									<li <?php echo $delivered_active; ?>>
										<a href="<?php echo site_url('user/orders?status=2'); ?>">Delivered</a>
									</li>									
								</ul>
							</li>
						</ul>
					</div>
					<?php
					if (count($orders)==0)
					{
						echo "<br /><br /><br /><center>There are no ".$label_text."!</center>";
					}
					else
					{
						foreach ($orders AS $order)
						{
							$make_logo = "http://www.myelquoto.com.au/global_images/makes/".str_replace(' ', '_', strtolower($order['make'])).".png";
							if ($order_status == 0)
							{
								?>
								<section class="panel" id="order_record_<?php echo $order['id_lead']; ?>">
									<div class="panel-body">
										<div class="row">
											<div class="col-md-1">
												<img src="<?php echo $make_logo; ?>" style="border: 1px solid #ddd;" width="100%">
											</div>
											<div class="col-md-11">
												<p>
													<b>You have an order of a <span style="color: #58c603"><?php echo $order['make'] . " " . $order['model']; ?>
													<?php echo " (" . $order['colour'] . ") " . $order['variant']; ?></span>
													</b>
													<br />
													Please click <a href="#" class="open-deal-agreement" data-order_id="<?php echo $order['id_lead']; ?>">here</a> 
													to check the details and confirm the order
												</p>
											</div>										
										</div>
									</div>
								</section>							
								<?php
							}
							else
							{
								?>
								<section class="panel" id="order_record_<?php echo $order['id_lead']; ?>">
									<div class="panel-body">
										<div class="row">
											<div class="col-md-12">
												<h4><b><?php echo $order['make'] . " " . $order['model']; ?></b></h4>
												<h5 style="margin-bottom: 25px;"><?php echo $order['variant'] ." (" . $order['colour'] . ")"; ?></h5>
											</div>										
											<div class="col-md-7">
												<div class="table-responsive">
													<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
														<thead>
															<tr><td colspan="2"><b>CLIENT</b></td></tr>
														</thead>
														<tbody>
															<tr>
																<td width="20%">Name:</td>
																<td><?php echo $order['name']; ?></td>
															</tr>
															<tr>
																<td>Email:</td>
																<td><?php echo $order['email']; ?></td>
															</tr>
															<tr>
																<td>Phone:</td>
																<td><?php echo $order['phone']; ?></td>
															</tr>
															<tr>
																<td>Mobile:</td>
																<td><?php echo $order['mobile']; ?></td>
															</tr>
															<tr>
																<td>State:</td>
																<td><?php echo $order['state']; ?></td>
															</tr>
															<tr>
																<td>Postcode:</td>
																<td><?php echo $order['postcode']; ?></td>
															</tr>
															<tr>
																<td>Address:</td>
																<td><?php echo $order['address']; ?><br /><br /></td>
															</tr>														
														</tbody>
													</table>
												</div>									
											</div>
											<div class="col-md-5">
												<div class="table-responsive">
													<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
														<thead>
															<tr><td colspan="2"><b>DEAL DETAILS</b></td></tr>
														</thead>
														<tbody>
															<tr>
																<td width="20%">Price:</td>
																<td><?php echo "$".number_format($order['cpp'], 2); ?></td>
															</tr>
															<tr>
																<td>Delivery Date:</td>
																<td id="delivery_date_td_<?php echo $order['id_lead']; ?>"><?php echo $order['delivery_date']; ?></td>
															</tr>												
														</tbody>
													</table>
												</div>
												<div class="table-responsive" style="margin-top: 16px;">
													<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
														<thead>
															<tr><td colspan="2"><b>CONSULTANT</b></td></tr>
														</thead>
														<tbody>
															<tr>
																<td width="20%">Name:</td>
																<td><?php echo $order['qs_name']; ?></td>
															</tr>
															<tr>
																<td>Email:</td>
																<td><?php echo $order['qs_email']; ?></td>
															</tr>
															<tr>
																<td>Phone:</td>
																<td><?php echo $order['qs_phone']; ?></td>
															</tr>
															<tr>
																<td>Mobile:</td>
																<td><?php echo $order['qs_mobile']; ?></td>
															</tr>											
														</tbody>
													</table>
												</div>
												<br />
											</div>	
											<div class="col-md-12">
												<?php 
												if ($order_status == 1)
												{
													?>
													<a class="btn btn-primary" href="<?php echo site_url("user/deal_export/".$order['id_lead']); ?>" target="_blank">
														<i class="fa fa-file-pdf-o"></i> &nbsp;Order Download
													</a>
													<button type="button" class="btn btn-danger delivery_date_modal_button" data-id_lead="<?php echo $order['id_lead']; ?>">
														<i class="fa fa-calendar"></i> &nbsp;Update Delivery
													</button>
													<button type="button" class="btn btn-success deliver_order_button" data-id_lead="<?php echo $order['id_lead']; ?>">
														<i class="fa fa-truck"></i> &nbsp;Mark as Delivered
													</button>												
													<button type="button" class="btn btn-warning quote_modal_button" data-quote_id="<?php echo $order['id_quote']; ?>">
														<i class="fa fa-dollar"></i> &nbsp;My Quotation
													</button>
													<button type="button" class="btn btn-default dealer_files_modal_button" data-id_lead="<?php echo $order['id_lead']; ?>">
														<i class="fa fa-paperclip"></i> &nbsp;Uploads
													</button>
													<?php
												}
												else if ($order_status == 2)
												{
													?>
													<a class="btn btn-primary" href="<?php echo site_url("user/deal_export/".$order['id_lead']); ?>" target="_blank">
														<i class="fa fa-file-pdf-o"></i> &nbsp;Order Download
													</a>
													<button type="button" class="btn btn-success quote_modal_button" data-quote_id="<?php echo $order['id_quote']; ?>">
														<i class="fa fa-dollar"></i> &nbsp;My Quotation
													</button>
													<button type="button" class="btn btn-default dealer_files_modal_button" data-id_lead="<?php echo $order['id_lead']; ?>">
														<i class="fa fa-paperclip"></i> &nbsp;Uploads
													</button>
													<?php
												}
												?>											
											</div>
										</div>
									</div>
								</section>
								<?php								
							}							
						}
					}
					?>
					<?php echo $links; ?>
					<div id="delivery_date_modal" class="modal fade"> <!--Delivery Date Modal-->
						<div class="modal-dialog">
							<section class="panel">
								<header class="panel-heading">
									<h2 class="panel-title">Delivery Date</h2>
								</header>
								<div class="panel-body">
									<div class="modal-wrapper">
										<div class="modal-text">
											<div class="delivery_date_div">
												<input type="hidden" id="id_lead" name="id_lead" />
												<input value="" class="form-control input-sm datepicker" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" id="delivery_date" name="delivery_date" style="width: 100%" />
											</div>
										</div>
									</div>
								</div>
								<footer class="panel-footer">
									<div class="row">
										<div class="col-md-12 text-right">
											<button type="button" class="btn btn-primary" onclick="update_delivery_date()">Save</button>
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										</div>
									</div>
								</footer>
							</section>					
						</div>
					</div>
					<div id="quote_modal" class="modal fade"> <!-- Quote Modal -->
						<div class="modal-dialog" style="width: 90%;">
							<section class="panel">
								<header class="panel-heading">
									<h2 class="panel-title">Dealer Quote</h2>
								</header>
								<div class="panel-body">
									<div class="modal-wrapper">
										<div class="modal-text">
											<div class="quote"></div>
										</div>
									</div>
								</div>
								<footer class="panel-footer">
									<div class="row">
										<div class="col-md-12 text-right">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										</div>
									</div>
								</footer>
							</section>
						</div>
					</div>
					<div id="dealer_files_modal" class="modal fade"> <!-- File Upload Modal -->
						<div class="modal-dialog" style="width: 90%;">
							<section class="panel">
								<header class="panel-heading">
									<h2 class="panel-title">File Upload</h2>
								</header>
								<div class="panel-body">
									<div class="modal-wrapper">
										<div class="modal-text">
											<div class="file_upload">
												<input type="hidden" id="dealer_up_lead_id" value="<?php echo $order['id_lead']; ?>">
											</div>
											<div id="file_attachments">
												<div class="row">
													<div class="col-md-12" id="attachment_table_id"></div>
												</div>
												<hr />
												<div class="row">
													<div class="col-md-12">
														<div class="dropzone upload_file_attachment"></div>
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
										</div>
									</div>
								</footer>
							</section>
						</div>
					</div>		
					<div id="deal-agreement-modal" class="modal fade"> <!-- Deal Agreement Modal -->
						<div class="modal-dialog" style="width: 95%;">
							<section class="panel">
								<div class="panel form-wizard" id="deal_agreement_wizard">
									<div class="panel-body" style="border-radius: 0px; padding: 0px 30px;">
										<div class="row">
											<div class="col-md-12">
												<center>
													<br />
													<br />
													<h3 style="color: #58c603; font-size: 2.3em;">
														<b>New Car Order Confirmation</b>
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
													<a href="#order_details" data-toggle="tab"><span>1</span>Order Details</a>
												</li>			
												<li>
													<a href="#delivery_details" data-toggle="tab"><span>2</span>Delivery</a>
												</li>																								
												<li>
													<a href="#confirmation_details" data-toggle="tab"><span>3</span>Confimation</a>
												</li>												
											</ul>
										</div>
										<form class="form-bordered">
											<input type="hidden" id="order_id" name="id_lead" />
											<div class="tab-content">
												<div id="order_details" class="tab-pane active" style="padding-bottom: 50px;">
												</div>
												<div id="delivery_details" class="tab-pane" style="padding-bottom: 50px;">
												</div>											
												<div id="confirmation_details" class="tab-pane" style="padding-bottom: 50px;">
													<div class="row">
														<div class="col-md-1">
														</div>
														<div class="col-md-10">
															<center>
																<h4>TERMS AND CONDITIONS</h4>
																<p style="margin-bottom: 30px;">Unless otherwise stated, the Customer and Dealer agree as follows:</p>														
															</center>
															<div class="well well-sm pre-scrollable" style="font-size: 0.9em;">
																<p align="justify">
																	<b>1.1</b> The Purchase Price of the motor vehicle is the amount shown as <b>"Total Purchase Amount"</b>.
																</p>
																<p align="justify">
																	<b>1.2</b> The Purchase Price may be varied if before the delivery of the motor vehicle, there is a change 
																	in the manufacturer's recommended retail price, statutory charges or applicable taxes and duties. The Dealer 
																	shall give the Customer & Quote Me written notice of any variation in the Purchase Price. If the purchase 
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
																	<b>3.3</b> Until the Dealer has received payment in full of the Quoted Price issued to Quote Me, 
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
																	<b>3.7</b> The Dealer and Customer acknowledge Quote Me P/L as the introducer of customer to 
																	dealership. Vehicle Payments or deposits taken by Quote Me are forwarded (less any outstanding 
																	associated invoices) to the dealer 48 hours before the delivery date shown.
																</p>
																<p align="justify">
																	<b>3.8</b> The supplying new car dealer is not responsible for the trade vehicle if there is an 
																	alternate dealer licence nominated below. Instead the nominated purchasing agent will pay via eft 
																	the valued amount (less Quote Me Fees) to the dealer supplying the new car. (This amount is the 
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
																	<b>3.3</b> Until the Dealer has received payment in full of the Quoted Price issued to Quote Me, title in the motor 
																	vehicle shall not pass to the Customer and the Customer shall hold possession of it as bailee only.
																</p>															
																<p style="color: red" align="justify">
																	<b>3.4</b> The Customer shall be deemed not to have paid the purchase price until the Dealer receives payment and 
																	unencumbered title to any trade-in vehicle and all other payments are credited to the Dealer's account.															
																</p>
																<p align="justify">
																	<b>3.2</b> If the trade in vehicle is not being traded by the supplying dealer Quote me will have nominated an alternate wholesaler to purchase the
																	vehicle. The new car supplying dealer agrees to hold the traded vehicle and release it to the nominated wholesale buyer upon receiving
																	payments totalling the dealers quoted price on the new car. On behalf of the nominated buying dealer Quote me will provisionally value the
																	trade in vehicle based on the customer’s description of it. Subject to the following, the valuation will be valid for 30 days, after which the tradein
																	vehicle will need to be re-valued. As the customer is permitted to use the vehicle between initial valuation and delivery of new car, the
																	customer is responsible for the following whilst the trade-in is in their possession; proper care and maintenance (including but not exclusive to
																	the following: servicing, tyres, and mechanical repairs), registration renewals, loss or damage to the vehicle, insurance claims, and
																	depreciation. Any kilometres travelled above the odometer cap provided will be charged at 25c/kilometre, further depreciation may also be
																	charged beyond this following the aforementioned 30 day period. Despite the foregoing, the sum to be paid or allowed to the customer for the
																	trade in vehicle will be its actual value (determined by Quote me ) at the time of delivery of the trade in vehicle to Quote Me or a wholesale
																	agent nominated by Quote Me . Variations in value may be caused by errors in description of vehicles details (including but not limited to the
																	following examples) Build Year, Make, Model, Series, Fuel Type, Transmission, Body Shape, Odometer, External Condition, Interior
																	Condition, Mechanical & Electrical Performance. Please ensure that the description contained within this contract is a true and accurate
																	representation of your vehicle.
																</p>
																<p align="justify">
																	<b>3.3a</b> The customer must pay or allow to Quote Me on demand the difference (if any) between the value of the
																	trade in vehicle provisionally determined by Quote Me and the actual value of the trade in vehicle when delivered to Quote Me or its
																	nominated wholesale agent. Variations in the actual value up to three thousand dollars will be immediately charged to your nominated credit
																	card where possible. Variations that are greater than three thousand dollars in value will require an EFT transfer to Quote Me, upon request.																
																</p>
																<p align="justify">
																	<b>3.3b</b> Until the Dealer has received payment in full of the Quoted Price issued to Quote Me, title in the motor vehicle shall not pass to the
																	Customer and the Customer shall hold possession of it as bailee only. 3.3c The Customer shall be deemed not to have paid the purchase
																	price until the Dealer receives payment and the nominated wholesaler buying the traded vehicle has unencumbered title to any trade-in
																	vehicle and all other payments are credited to the Dealer's account.
																</p>
															</div>
														</div>
														<div class="col-md-1">
														</div>														
													</div>
													<div class="row">
														<div class="col-md-1">
														</div>
														<div class="col-md-10">
															<div class="alert alert-info">
																<ul>
																	<li>
																		The dealership accepts Qteme's terms and conditions as stated in the 
																		dealer portal
																	</li>
																	<li>
																		The acceptance of the order also accepts the corresponding Qteme invoice 
																		and it's due date 5 days post the new car delivery. (Where applicable)
																	</li>
																</ul>
															</div>
														</div>
														<div class="col-md-1">
														</div>														
													</div>
													<div class="row">
														<div class="col-md-1">
														</div>													
														<div class="col-md-10">
															<p style="margin-bottom: 10px;">
																Confirm the order and either 1) authorise <b>Quote Me</b> to send the client an 
																order with your dealership details showing as the supplying dealer or 
																2) confirm you will send one immediately to the client's email address.
																A signed order for your acceptance will be sent to your nominated email 
																address regardless.
															</p>					
															<input type="radio" name="send_to_client" value="1" required>
															We accept the order. Please send an order to the client showing our details 
															as the supplying dealer.
															<br />
															<input type="radio" name="send_to_client" value="0" required>
															We accept the order and will send the client an order immediately.																	
														</div>		
														<div class="col-md-1">
														</div>														
													</div>
													<div class="row">
														<div class="col-md-1">
														</div>													
														<div class="col-md-10 text-right">
															<br />
															<br />
															<br />
															<input type="checkbox" name="client_details_confirmation" required>
															I confirm and accept this order
														</div>	
														<div class="col-md-1">
														</div>																											
													</div>															
												</div>												
											</div>
										</form>
									</div>
									<div class="panel-footer" style="border: 1px solid #eee;">
										<ul class="pager">
											<li class="previous disabled">
												<a href="#">Back</a>
											</li>
											<li class="finish hidden pull-right">
												<a id="confirm_order">Finish</a>
											</li>
											<li class="next">
												<a href="#">Next</a>
											</li>
										</ul>
									</div>
								</div>
							</section>
						</div>
					</div>
				</section>
			</div>
			<?php include 'admin/template/right_sidebar.php'; ?>
		</section>		
		<?php include 'admin/template/scripts.php'; ?>
		<script>
			var $wizard_finish = $("#deal_agreement_wizard").find("ul.pager li.finish"),
			$wizard_validator = $("#deal_agreement_wizard form").validate({
				highlight: function(element) {
					$(element).closest(".form-group").removeClass("has-success").addClass("has-error");
				},
				success: function(element) {
					$(element).closest(".form-group").removeClass("has-error");
					$(element).remove();
				},
				errorPlacement: function(error, element) {
					element.parent().append(error);
				}
			});

			$("#deal_agreement_wizard").bootstrapWizard({
				tabClass: 'wizard-steps',
				nextSelector: 'ul.pager li.next',
				previousSelector: 'ul.pager li.previous',
				firstSelector: null,
				lastSelector: null,
				onNext: function(tab, navigation, index, newindex) {
					var validated = $('#deal_agreement_wizard form').valid();
					if(!validated)
					{
						$wizard_validator.focusInvalid();
						return false;
					}
				},
				onTabClick: function(tab, navigation, index, newindex) {
					return false;
				},
				onTabChange: function(tab, navigation, index, newindex) {
					var $total = navigation.find('li').size() - 1;
					$wizard_finish[ newindex != $total ? 'addClass' : 'removeClass' ]( 'hidden' );
					$('#deal_agreement_wizard').find(this.nextSelector)[ newindex == $total ? 'addClass' : 'removeClass' ]( 'hidden' );
				},
				onTabShow: function(tab, navigation, index) {
					var $total = navigation.find('li').length - 1;
					var $current = index;
					var $percent = Math.floor(( $current / $total ) * 100);
					$('#deal_agreement_wizard').find('.progress-indicator').css({ 'width': $percent + '%' });
					tab.prevAll().addClass('completed');
					tab.nextAll().removeClass('completed');
				}
			});		
		
			$(document).ready(function(){				
				$(document).find(".upload_file_attachment").dropzone({
			        url: '<?php echo site_url('user/dealer_upload'); ?>',
			        init: function() {
			            this.on("sending", function(file, xhr, formData){
							var id = $("#dealer_up_lead_id").val();
							formData.append("id", id);
						}),
						this.on("success", function(file, response){
							var obj = jQuery.parseJSON(response);
							if (obj.status == "success")
							{
								var html = "<tr class='dealer_files_tbl' data-abspath='"+obj.file_name+"' data-fileid='"+obj.insert_id+"'><td><a target='_blank' href='"+obj.abspath+"'>"+obj.file_name+"</a></td><td><a class='fa fa-trash-o del_dealer_file' ></a></td></tr>";
								$(document).find("#attachment_table_id").find(".table").append(html);
							}
							else
							{
								alert("The file type you are trying to upload is not allowed! PDF and images are the safest file to upload..");
							}
						}),
						this.on("queuecomplete", function () {
						    this.removeAllFiles();
						});
					},
				});			
			
				$(document).on("click", ".open-deal-agreement", function(data){
					var order_id = $(this).data("order_id");
					$.post("<?php echo site_url("user/generate_deal_agreement_wizard_json"); ?>/" + order_id, function(data)
					{
						$("#deal-agreement-modal").find("#order_details").html(data.order_details);
						$("#deal-agreement-modal").find("#delivery_details").html(data.delivery_details);
						$("#deal-agreement-modal").find("#order_id").val(order_id);
						$("#deal-agreement-modal").modal("show");
					}, "json");
				});

				$(document).on("click", ".dealer_files_modal_button", function(){
					var id_lead = $(this).data("id_lead");
					
					var data = {
						id_lead: id_lead
					}

					$.ajax({
						type: "POST",
						url: "<?php echo site_url('user/dealer_uploads'); ?>",
						data: data,
						cache: false,
						dataType: "json",
						success: function(data){
							$("#dealer_files_modal").find("#attachment_table_id").html(data.files_table);
							$("#dealer_files_modal").modal("show");
						}
					});
				});

				$(document).on("click", "#confirm_order", function(){
					var order_id = $("#deal-agreement-modal").find("#order_id").val();
					var order_date = $("#deal-agreement-modal").find("#order_date").val();
					var delivery_date = $("#deal-agreement-modal").find("#delivery_date_input").val();
					
					if (delivery_date == "" || delivery_date < order_date)
					{
						alert("The delivery date cannot be set to a date which is before the order date!");
					}
					else
					{
						var data = {
							id_lead: order_id,
							delivery_date: delivery_date
						};					
						
						$.ajax({
							type: "POST",
							url: "<?php echo site_url("user/confirm_order"); ?>",
							cache: false,
							data: data,
							success: function(response){
								if (response === "success")
								{
									alert ("Thank you for confirming your order! You can find the details of this order under your Deliveries Pending tab.");
									$("#order_record_"+order_id).remove();
									$("#deal-agreement-modal").modal("hide");
								}
								else
								{
									alert("An error has occured! Please make sure all your inputs are correct");
								}							
							}
						});
					}
				});
				
				$(document).on("click", ".quote_modal_button", function(data){
					var quote_id = $(this).data("quote_id");
					$.post('<?php echo site_url("user/quotation"); ?>/' + quote_id, function(data)
					{
						$("#quote_modal").find(".quote").html(data.quotation);
						$("#quote_modal").modal();
					}, "json");
				});

				$(document).on("click", ".delivery_date_modal_button", function(data){
					var id_lead = $(this).data("id_lead");
					var delivery_date = $("#delivery_date_td_"+id_lead).html();
					
					$("#delivery_date_modal").find("#delivery_date").val(delivery_date);
					$("#delivery_date_modal").find("#id_lead").val(id_lead);
					$("#delivery_date_modal").modal();
				});			
				
				$(document).on("click", ".deliver_order_button", function(data){
					var id_lead = $(this).data("id_lead");
					
					var data = {
						id_lead: id_lead
					};					
					
					$.ajax({
						type: "POST",
						url: "<?php echo site_url('user/deliver_order'); ?>",
						data: data,
						cache: false,
						success: function(result){
							$("#order_record_"+id_lead).remove();
							alert ("The Order has been marked as Delivered");
						}
					});
				});				
			});

			function update_delivery_date ()
			{
				var id_lead = $("#delivery_date_modal").find("#id_lead").val();
				var current_delivery_date = $("#delivery_date_td_"+id_lead).html();
				var new_delivery_date = $("#delivery_date_modal").find("#delivery_date").val();

				var data = {
					id_lead: id_lead,
					current_delivery_date: current_delivery_date,
					new_delivery_date: new_delivery_date
				};
				
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('user/update_delivery_date'); ?>",
					data: data,
					cache: false,
					success: function(result){
						$("#delivery_date_td_"+id_lead).html(new_delivery_date);
						$("#delivery_date_modal").find("#id_lead").val("");						
						$("#delivery_date_modal").find("#delivery_date").val("");				
						$("#delivery_date_modal").modal("hide");
						alert ("Update successful!");
					}
				});
			}			
		</script>
	</body>
</html>
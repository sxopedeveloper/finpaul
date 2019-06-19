<?php include 'template/head.php'; ?>
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
		<section class="body">
			<?php include 'template/header.php'; ?>
			<div class="inner-wrapper">
				<?php include 'template/left_sidebar.php'; ?>
<section role="main" class="content-body">
<?php include 'template/header_2.php'; ?>
<!-- start: page -->
<div class="row">
	<div class="col-md-8">
		<section class="panel panel-group">
			<header class="panel-heading bg-primary"> <!-- Green Header -->
				<div class="widget-profile-info">
					<div class="profile-picture">
						<img src="<?php echo $make_logo; ?>">
					</div>
					<div class="profile-info">
						<h4 class="name text-weight-semibold"><b><?php echo $lead['name']; ?></b></h4>
						<h5 class="role">
							<?php echo $lead['email']; ?>&nbsp;&nbsp;
							<i class="fa fa-phone"></i> <?php echo $lead['phone']; ?>
						</h5>
						<div class="profile-footer">
							<span id="cq_number"><?php echo $lead['cq_number']; ?></span>
						</div>
						<input type="hidden" id="client_email" value="<?php echo $lead['email']; ?>">
						<input type="hidden" id="dealer_email" value="<?php echo $lead['dealer_email']; ?>">
					</div>
				</div>
			</header>
			<div id="accordion">
				<div class="panel panel-accordion panel-accordion-first"> <!-- Summary + Buttons -->
					<div class="panel-heading" style="border-bottom: 1px solid #ddd;"> <!-- Status -->
						<h4 class="panel-title">
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse_1">
								<b><?php echo $lead['status_text']; ?></b>
							</a>
						</h4>
					</div>
					<div id="collapse_1" class="accordion-body collapse in">
						<div class="panel-body">
							<div class="row"> <!-- General Actions -->
								<div class="col-sm-12">
									<b>Submitted:</b> <?php echo $lead['created_at']; ?>
									<br />
									<b>Owner:</b> <?php echo $lead['qs_name']; ?>
									<br />
									<br />
									<?php
									if ($previous_lead_id <> "")
									{
										$previous_button = '
										<a href="'.site_url('lead/record_final/'.$previous_lead_id).'" class="btn btn-default btn-sm ajax_button">
											<i class="fa fa-arrow-left"></i>&nbsp; Previous Lead
										</a>';
									}
									else
									{
										$previous_button = '
										<a href="#" class="btn btn-default btn-sm ajax_button" disabled>
											<i class="fa fa-arrow-left"></i>&nbsp; Previous Lead
										</a>';															
									}
									
									if ($next_lead_id <> "")
									{
										$next_button = '
										<a href="'.site_url('lead/record_final/'.$next_lead_id).'" class="btn btn-default btn-sm ajax_button">
											<i class="fa fa-arrow-right"></i>&nbsp; Next Lead
										</a>';
									}		
									else
									{
										$next_button = '
										<a href="#" class="btn btn-default btn-sm ajax_button" disabled>
											<i class="fa fa-arrow-right"></i>&nbsp; Next Lead
										</a>';															
									}
									
									echo $previous_button;
									
									if ($lead['status']==0 OR $lead['status']==1 OR $lead['status']==2)
									{
										?>
										<span class="btn btn-default btn-sm ajax_button start_tender_modal_button" data-id_lead="<?php echo $lead['id_lead']; ?>">
											Start Tender
										</span>
										<span class="btn btn-default btn-sm ajax_button not_proceeding_modal_button" data-id_lead="<?php echo $lead['id_lead']; ?>">
											Not Proceeding
										</span>
										<?php
									}
									else if ($lead['status']==10)
									{
										?>													
										<span class="btn btn-default btn-sm ajax_button restart_tender_button" data-id_lead="<?php echo $lead['id_lead']; ?>">
											Restart Tender
										</span>
										<span class="btn btn-default btn-sm ajax_button not_proceeding_modal_button" data-id_lead="<?php echo $lead['id_lead']; ?>">
											Not Proceeding
										</span>
										<?php															
									}
									else if ($lead['status']==3)
									{
										?>
										<span class="btn btn-default btn-sm ajax_button pretender_button" data-id_lead="<?php echo $lead['id_lead']; ?>">
											Pre-Tender
										</span>
										<?php
										if (count($deal_requirements['errors'])==0)
										{
											?>															
											<span class="btn btn-default btn-sm ajax_button submit_deal_button" data-id_lead="<?php echo $lead['id_lead']; ?>">
												Submit Deal
											</span>
											<?php
										}
										?>
										<span class="btn btn-default btn-sm ajax_button not_proceeding_modal_button" data-id_lead="<?php echo $lead['id_lead']; ?>">
											Not Proceeding
										</span>
										<?php															
									}
									else if ($lead['status']==4)
									{
										?>
										<?php
										if ($user_id == 427 OR $user_id == 255) // Param and Jeno (Hardcoded for Now)
										{
											?>												
											<span class="btn btn-default btn-sm ajax_button accountant_email_modal_button" data-id_lead="<?php echo $lead['id_lead']; ?>">
												Dealer Email
											</span>															
											<?php
										}															
										?>
										<span class="btn btn-default btn-sm ajax_button cancel_deal_modal_button" data-id_lead="<?php echo $lead['id_lead']; ?>">
											Cancel Deal
										</span>
										<?php
										if ($login_type=="Admin")
										{
											?>
											<span class="btn btn-default btn-sm ajax_button approve_deal_button" data-id_lead="<?php echo $lead['id_lead']; ?>">
												Approve Deal
											</span>
											<?php
										}
									}												
									else if ($lead['status']==5)
									{
										?>	
										<?php
										if ($user_id == 427 OR $user_id == 255) // Param and Jeno (Hardcoded for Now)
										{
											?>												
											<span class="btn btn-default btn-sm ajax_button accountant_email_modal_button" data-id_lead="<?php echo $lead['id_lead']; ?>">
												Dealer Email
											</span>															
											<?php
										}															
										?>															
										<span class="btn btn-default btn-sm ajax_button cancel_deal_modal_button" data-id_lead="<?php echo $lead['id_lead']; ?>">
											Cancel Deal
										</span>
										<span class="btn btn-default btn-sm ajax_button deliver_button" data-id_lead="<?php echo $lead['id_lead']; ?>">
											Delivered
										</span>
										<?php															
									}																											
									else if ($lead['status']==6)
									{
										?>					
										<?php
										if ($user_id == 427 OR $user_id == 255) // Param and Jeno (Hardcoded for Now)
										{
											?>												
											<span class="btn btn-default btn-sm ajax_button accountant_email_modal_button" data-id_lead="<?php echo $lead['id_lead']; ?>">
												Dealer Email
											</span>															
											<?php
										}															
										?>															
										<span class="btn btn-default btn-sm ajax_button cancel_deal_modal_button" data-id_lead="<?php echo $lead['id_lead']; ?>">
											Cancel Deal
										</span>																
										<span class="btn btn-default btn-sm ajax_button settle_button" data-id_lead="<?php echo $lead['id_lead']; ?>">
											Settled
										</span>																
										<?php															
									}
									else if ($lead['status']==7)
									{
										?>			
										<?php
										if ($user_id == 427 OR $user_id == 255) // Param and Jeno (Hardcoded for Now)
										{
											?>												
											<span class="btn btn-default btn-sm ajax_button accountant_email_modal_button" data-id_lead="<?php echo $lead['id_lead']; ?>">
												Dealer Email
											</span>															
											<?php
										}															
										?>															
										<span class="btn btn-default btn-sm ajax_button cancel_deal_modal_button" data-id_lead="<?php echo $lead['id_lead']; ?>">
											Cancel Deal
										</span>															
										<?php															
									}		
									echo $next_button;														
									?>
								</div>
							</div>
							<br />
							<?php
							if ($lead['status']==3 OR $lead['status']==4 OR $lead['status']==5 OR $lead['status']==6 OR $lead['status']==7 OR $lead['status']==8 OR $lead['status']==9)
							{
								?>
								<div class="row"> <!-- Deal Requirements and Warnings -->
									<div class="col-sm-12">
										<?php
										if (count($deal_requirements['errors'])>0)
										{
											?>
											<div class="alert alert-danger">
												<i class="fa fa-exclamation-circle"></i>&nbsp;<strong>Deal Submission Requirements:</strong>
												<ul>
													<?php
													foreach ($deal_requirements['errors'] AS $deal_error)
													{
														?>
														<li><?php echo $deal_error; ?></li>
														<?php
													}
													?>
												</ul>
											</div>
											<?php															
										}
										
										if (count($deal_requirements['warnings'])>0)
										{
											?>
											<div class="alert alert-warning">
												<i class="fa fa-warning"></i>&nbsp; <strong>Deal Warnings:</strong>
												<ul>
													<?php
													foreach ($deal_requirements['warnings'] AS $deal_warning)
													{
														?>
														<li><?php echo $deal_warning; ?></li>
														<?php
													}
													?>
												</ul>
											</div>
											<?php															
										}														
										?>
									</div>
								</div>
								<?php
							}
							?>
<div class="row" id="lead_events_container"> <!-- Unactioned Events -->
	<div class="col-sm-12">
		<div class="alert alert-warning">
			<i class="fa fa-calendar"></i>&nbsp; <strong>Unactioned Events</strong> 
			<br />
			<div class="table-responsive" style="margin-top: 10px;">
				<table class="table table-condensed mb-none">
					<tbody>
						<?php
						if (count($lead_events)==0)
						{
							?>
							<tr><td>There are no unactioned events!</td></tr>
							<?php
						}
						else
						{
							foreach ($lead_events AS $lead_event)
							{
								?>
								<tr id="lead_event_<?php echo $lead_event['id_lead_event']; ?>">
									<td>
										<span class="ajax_button_primary update_lead_event_status_button" data-id_lead="<?php echo $lead['id_lead']; ?>" data-id_lead_event="<?php echo $lead_event['id_lead_event']; ?>" data-status="1">
											<i class="fa fa-check" data-toggle="tooltip" title="Mark as Actioned"></i>
										</span>
									</td>
									<td>
										<span class="ajax_button_primary edit_lead_event_modal_button" data-id_lead="<?php echo $lead['id_lead']; ?>" data-id_lead_event="<?php echo $lead_event['id_lead_event']; ?>">
											<i class="fa fa-edit" data-toggle="tooltip" title="Edit Event"></i>
										</span>
									</td>
									<td>
										<span class="ajax_button_primary delete_lead_event_button" data-id_lead="<?php echo $lead['id_lead']; ?>" data-id_lead_event="<?php echo $lead_event['id_lead_event']; ?>">
											<i class="fa fa-trash-o" data-toggle="tooltip" title="Delete Event"></i>
										</span>
									</td>																						
									<td><?php echo $lead_event['user']; ?></td>
									<td><?php echo $lead_event['date']; ?></td>
									<td><?php echo $lead_event['time']; ?></td>
									<td><?php echo substring_words($lead_event['details'], 35); ?></td>
								</tr>
								<?php
							}
						}
						?>
					</tbody>
				</table>
			</div>															
			<span class="btn btn-default btn-sm ajax_button event_modal_button" style="margin-top: 20px;" data-id_lead="<?php echo $lead['id_lead']; ?>">
				<i class="fa fa-plus"></i> Add Event
			</span>
		</div>	
	</div>
</div>
							<?php
							if ($lead['status']==3 OR $lead['status']==4 OR $lead['status']==5 OR $lead['status']==6 OR $lead['status']==7 OR $lead['status']==8 OR $lead['status']==9)
							{
								?>
								<div class="row"> <!-- Tender Actions -->		
									<div class="col-sm-12">
										<div class="alert alert-default">
											<i class="fa fa-car"></i>&nbsp; <strong>Tender Actions</strong> 
											<br />
											<br />
											<span class="btn btn-default btn-sm ajax_button send_tender_confirmation_button" data-id_lead="<?php echo $lead['id_lead']; ?>" data-id_quote_request="<?php echo $lead['id_quote_request']; ?>">
												Send Tender Confirmation
											</span>
											<span class="btn btn-default btn-sm ajax_button add_dealers_modal_button" data-id_lead="<?php echo $lead['id_lead']; ?>" data-id_quote_request="<?php echo $lead['id_quote_request']; ?>">
												Add Dealers
											</span>
											<span class="btn btn-default btn-sm ajax_button edit_tender_modal_button" data-id_lead="<?php echo $lead['id_lead']; ?>" data-id_quote_request="<?php echo $lead['id_quote_request']; ?>">
												Edit Tender
											</span>
											<span class="btn btn-default btn-sm ajax_button remind_dealers_button" data-id_lead="<?php echo $lead['id_lead']; ?>" data-id_quote_request="<?php echo $lead['id_quote_request']; ?>">
												Remind Dealers
											</span>
											<span class="btn btn-default btn-sm ajax_button email_invite_modal_button" data-id_lead="<?php echo $lead['id_lead']; ?>" data-id_quote_request="<?php echo $lead['id_quote_request']; ?>">
												Email Invitation
											</span>
											<span class="btn btn-default btn-sm ajax_button quote_modal_button" data-id_lead="<?php echo $lead['id_lead']; ?>" data-id_quote_request="<?php echo $lead['id_quote_request']; ?>">
												Add Quote
											</span>																
										</div>
									</div>
								</div>
								<?php														
							}													
							?>												
							<div class="row"> <!-- Lead Summary -->
								<div class="col-sm-12">
									<h5 style="color: #58c603"><b>Lead Summary</b></h5>
								</div>
								<div class="col-sm-4">
									<p>
										<b>Source</b><br />
										<?php echo $lead['source']; ?>
									</p>														
								</div>
								<div class="col-sm-4">
									<p>
										<b>Vehicle</b><br />
										<?php echo $lead['make']." ".$lead['model']; ?>
									</p>
								</div>
								<div class="col-sm-4">
									<p>
										<b>Financing</b><br />
										<?php 
										if ($lead['finance']==1)
										{
											echo "Yes";
										}
										else
										{
											echo "No";
										}
										?>
									</p>
								</div>																								
							</div>
							<hr class="solid mt-sm mb-lg">
							<div class="row"> <!-- Tradein Summary -->
								<div class="col-sm-12">
									<h5 style="color: #58c603"><b>Trade-In Summary</b></h5>
								</div>												
								<div class="col-sm-4">
									<p>
										<b>Suggested:</b><br />
										<i>To follow</i>
									</p>														
								</div>
								<div class="col-sm-4">
									<p>
										<b>Attached:</b><br />
										<?php echo $lead['tradein_count']; ?>
									</p>													
								</div>	
								<div class="col-sm-4">
									<p>
										<b>Trade-In Buyer:</b><br />
										<?php echo $lead['trade_buyer_type']; ?>
									</p>
								</div>
							</div>												
							<?php
							if ($lead['status']==3 OR $lead['status']==4 OR $lead['status']==5 OR $lead['status']==6 OR $lead['status']==7 OR $lead['status']==8 OR $lead['status']==9)
							{
								?>
								<hr class="solid mt-sm mb-lg">
								<div class="row"> <!-- Tender Summary -->
									<div class="col-sm-12">
										<h5 style="color: #58c603"><b>Tender Summary</b></h5>
									</div>		
									<div class="col-sm-4">
										<p>
											<b>Start Date</b><br />
											<?php echo date('d F Y', strtotime($lead['tender_date'])); ?>
										</p>
										<p>
											<b>Registration</b><br />
											<?php echo $lead['registration_type']; ?>
										</p>														
									</div>													
									<div class="col-sm-4">
										<p>
											<b>Vehicle</b><br />
											<?php echo $lead['build_date']." ".$lead['tender_make']." ".$lead['tender_model']; ?>
										</p>														
										<p>
											<b>Winning Dealer</b><br />
											<?php echo $lead['fleet_manager']; ?>
										</p>														
									</div>											
									<div class="col-sm-4">
										<p>
											<b>Quotes / Invites</b><br />
											<?php echo $lead['quote_count']." / ".$lead['invite_dealer_count']; ?>
										</p>													
										<p>
											<b>Dealer Price</b><br />
											<?php echo $lead['winning_price']; ?>
										</p>														
									</div>										
								</div>													
								<?php
							}
							?>
							<?php
							if ($lead['status']==4 OR $lead['status']==5 OR $lead['status']==6 OR $lead['status']==7 OR $lead['status']==8 OR $lead['status']==9)
							{
								?>
								<hr class="solid mt-sm mb-lg">												
								<div class="row"> <!-- Deal Summary -->
									<div class="col-sm-12">
										<h5 style="color: #58c603"><b>Deal Summary</b></h5>
									</div>													
									<div class="col-sm-4">
										<p>
											<b>Sales Price:</b><br />
											<?php echo $lead['sales_price']; ?>
										</p>														
									</div>
									<div class="col-sm-4">
										<p>
											<b>QM Changeover:</b><br />
											<?php echo $lead_calculation_details['changeover']; ?>
										</p>														
									</div>		
									<div class="col-sm-4">
										<p>
											<b>Dealer Changeover:</b><br />
											<?php echo $lead['dealer_changeover']; ?>
										</p>														
									</div>
								</div>
								<?php 
								if ($lead['client_key'] <> "")
								{
									?>
									<hr class="solid mt-sm mb-lg">
									<div class="row"> <!-- Client Confirmation Page -->
										<div class="col-sm-12">
											<p>
												<b>Client Confirmation Page:</b>
												<br />
												<a href="http://www.myelquoto.com.au/vehicle_order/client_agreement?id=<?php echo $lead['id_lead']; ?>&key=<?php echo $lead['client_key']; ?>" target="_blank">
													http://www.myelquoto.com.au/vehicle_order/client_agreement?id=<?php echo $lead['id_lead']; ?>&key=<?php echo $lead['client_key']; ?>
												</a>																
											</p>
										</div>
									</div>																											
									<?php
								}	
								?>
								<?php
							}
							?>
							<?php
							if ($lead['status']==4 OR $lead['status']==5 OR $lead['status']==6 OR $lead['status']==7 OR $lead['status']==8 OR $lead['status']==9)
							{
								?>			
								<hr class="solid mt-sm mb-lg">
								<div class="row"> <!-- Documents -->
									<div class="col-sm-12">
										<a href="<?php echo site_url('deal/pdf_export/'.$lead['id_lead']); ?>" target="_blank" class="btn btn-default btn-sm ajax_button">
											<i class="fa fa-file-pdf-o"></i> Purchase Order PDF
										</a>
										<a href="<?php echo site_url('deal/order_package_pdf/'.$lead['id_lead']); ?>" target="_blank" class="btn btn-default btn-sm ajax_button">
											<i class="fa fa-file-pdf-o"></i> Order Package PDF
										</a>															
									</div>
								</div>													
								<?php
							}
							?>													
							<br />
						</div>
					</div>
					<div class="panel-footer panel-footer-btn-group"> <!-- Actions -->
						<a href="#" style="border-top: 1px solid #ddd;" class="call_modal_button">
							<i class="fa fa-phone mr-xs"></i> Log Call
						</a>
						<a href="#" style="border-top: 1px solid #ddd;" class="sms_modal_button">
							<i class="fa fa-mobile mr-xs"></i> Send SMS
						</a>
						<a href="#" style="border-top: 1px solid #ddd;"  class="send_email_modal_button">
							<i class="fa fa-envelope mr-xs"></i> Send Email
						</a>
					</div>										
				</div>
				<div class="panel panel-accordion"> <!-- Chatter -->
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse_2">
								 <i class="fa fa-comment"></i> Chatter (<span id="lead_comment_count"><?php echo count($lead_comments); ?></span>)
							</a>
						</h4>
					</div>
					<div id="collapse_2" class="accordion-body collapse">
						<div class="panel-body">
							<ul class="simple-user-list mb-xlg">
								<?php 
								if (count($lead_comments)==0)
								{
									?>
									<li id="norecords"><center><p>No records found!</p></center></li>
									<?php
								}
								else
								{
									foreach ($lead_comments AS $lead_comment)
									{
										?>
										<li>
											<figure class="image rounded">
												<img src="<?php echo base_url('assets/img/!sample-user.jpg'); ?>" alt="<?php echo $lead_comment['sender'];?>" class="img-circle">
											</figure>
											<span class="title">
												<?php echo $lead_comment['sender'];?> 
												<span style="font-size: 0.8em; color: #58c603;"><?php echo date('d F Y', strtotime($lead_comment['created_at'])); ?></span>
											</span>
											<span class="message">
												<?php echo $lead_comment['comment'];?>
											</span>
										</li>														
										<?php
									}												
								}
								?>
							</ul>
							<hr class="solid mt-sm mb-lg">
							<form method="post" id="add_comment_form" name="add_comment_form" action="">
								<input type="hidden" id="id_lead" name="id_lead" value="<?php echo $lead['id_lead']; ?>" />
								<div class="form-group">
									<div class="col-sm-12">
										<div class="input-group mb-md">
											<input type="text" class="form-control" id="comment" name="comment">
											<div class="input-group-btn">
												<button type="submit" class="btn btn-primary" tabindex="-1">Submit</button>
												<!--
												<button type="submit" class="btn btn-default btn-outline">
													<i class="fa fa-save"></i> Save
												</button>																	
												-->
											</div>
										</div>
									</div>
								</div>
							</form>												
						</div>
					</div>
				</div>
				<div class="panel panel-accordion"> <!-- Activity -->
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse_3">
								 <i class="fa fa-edit"></i> Activity (<span id="lead_audit_trail_count"><?php echo count($lead_audit_trails); ?></span>)
							</a>
						</h4>
					</div>
					<div id="collapse_3" class="accordion-body collapse">
						<div class="panel-body">
							<?php
							$html = '';
							foreach ($lead_audit_trails AS $lead_audit_trail)
							{
								$link = "";
								if ($lead_audit_trail['table_name']=="leads")
								{
									$cq_number = "QM".str_pad($lead_audit_trail['fk_main'], 5, '0', STR_PAD_LEFT);
								}
								$html .= '
								<div style="border: 1px solid #ddd; border-radius: 5px; padding: 10px;">
									<b>'.$lead_audit_trail['user'].'</b>
									'.$lead_audit_trail['action_text'].' '.$cq_number.'
									<br /><span style="font-size: 0.8em;">'.$lead_audit_trail['created_at'].'</span>';
									if ($lead_audit_trail['description'] <> '')
									{
										if ($lead_audit_trail['action']==2)
										{
											$html .= '
											<div class="table-responsive">
												<table class="table table-bordered table-striped table-condensed mb-none">
													<tr>
														<td width="20%"><b>Field</b></td>
														<td width="40%"><b>Value From</b></td>
														<td width="40%"><b>Value To</b></td>
													</tr>';
													$audit_trail_value_arr = json_decode($lead_audit_trail['description'], true);
													foreach ($audit_trail_value_arr AS $audit_trail_values)
													{
														$html .= '
														<tr>
															<td>'.$audit_trail_values['field'].'</td>
															<td>'.nl2br($audit_trail_values['value_from']).'</td>
															<td>'.nl2br($audit_trail_values['value_to']).'</td>
														</tr>';
													}				
													$html .= '
												</table>
											</div>';
										}
										else if ($lead_audit_trail['action']==30)
										{
											$html .= '
											<div class="table-responsive">
												<table class="table table-bordered table-striped table-condensed mb-none">
													<tr>
														<td width="30%"><b>Field</b></td>
														<td width="70%"><b>Value</b></td>
													</tr>';
													$audit_trail_value_arr = json_decode($lead_audit_trail['description'], true);
													foreach ($audit_trail_value_arr AS $audit_trail_values)
													{
														foreach ($audit_trail_values AS $audit_trail_field => $audit_trail_value);
														{
															if ($audit_trail_value==0)
															{
																$audit_trail_value = "Uncontacted";
															}
															else if ($audit_trail_value==1)
															{
																$audit_trail_value = "Undecided";
															}
															else if ($audit_trail_value==2)
															{
																$audit_trail_value = "Not Interested";
															}
															else if ($audit_trail_value==3)
															{
																$audit_trail_value = "Buying";
															}
															
															$html .= '
															<tr>
																<td>'.$audit_trail_field.'</td>
																<td>'.$audit_trail_value.'</td>
															</tr>';
														}
													}
													$html .= '
												</table>
											</div>';
										}
										else if ($lead_audit_trail['action']==31)
										{
											$audit_trail_value_arr = json_decode($lead_audit_trail['description'], true);
											foreach ($audit_trail_value_arr AS $audit_trail_values)
											{
												foreach ($audit_trail_values AS $audit_trail_field => $audit_trail_value);
												{
													$html .= '<br /><br /><i>"'.$audit_trail_value.'"</i>';
												}
											}
										}
										else
										{
											$html .= '
											<div class="table-responsive">
												<table class="table table-bordered table-striped table-condensed mb-none">
													<tr>
														<td width="30%"><b>Field</b></td>
														<td width="70%"><b>Value</b></td>
													</tr>';
													$audit_trail_value_arr = json_decode($lead_audit_trail['description'], true);
													foreach ($audit_trail_value_arr AS $audit_trail_values)
													{
														foreach ($audit_trail_values AS $audit_trail_field => $audit_trail_value);
														{
															$html .= '
															<tr>
																<td>'.$audit_trail_field.'</td>
																<td>'.$audit_trail_value.'</td>
															</tr>';
														}
													}
													$html .= '
												</table>
											</div>';
										}
									}
									$html .= '
								</div>
								<br />';
							}
							echo $html;
							?>
						</div>
					</div>
				</div>									
			</div>
		</section>
<div class="toogle" data-plugin-toggle="">
<section class="toggle active"> <!-- Details -->
	<label>Details</label>
	<div class="toggle-content">
		<section class="panel"> <!-- Client Details -->
			<form method="post" id="client_details_form" name="client_details_form" action="">
				<input type="hidden" name="id_lead" value="<?php echo $lead['id_lead']; ?>" />
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<h5><b>Client Details</b></h5>
							<hr class="solid mt-sm mb-lg">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label">Name</label><br />
								<input value="<?php echo $lead['name']; ?>" class="text-line" id="name" name="name" type="text">
							</div>													
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label">Business Name</label><br />
								<input value="<?php echo $lead['business_name']; ?>" class="text-line" id="business_name" name="business_name" type="text">
							</div>
						</div>	
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label">ABN</label><br />
								<input value="<?php echo $lead['abn']; ?>" class="text-line" id="abn" name="abn" type="text">
							</div>
						</div>														
					</div>
					<div class="row" style="margin-top: 10px;">
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label">Email</label><br />
								<input value="<?php echo $lead['email']; ?>" class="text-line" id="email" name="email" type="text">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label">Alternate Email 1</label><br />
								<input value="<?php echo $lead['alternate_email_1']; ?>" class="text-line" id="alternate_email_1" name="alternate_email_1" type="text">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label">Alternate Email 2</label><br />
								<input value="<?php echo $lead['alternate_email_2']; ?>" class="text-line" id="alternate_email_2" name="alternate_email_2" type="text">
							</div>
						</div>													
					</div>		
					<div class="row" style="margin-top: 10px;">
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label">Phone</label><br />
								<input value="<?php echo $lead['phone']; ?>" class="text-line" id="phone" name="phone" type="text">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label">Alternate Phone</label><br />
								<input value="<?php echo $lead['alternate_phone']; ?>" class="text-line" id="alternate_phone" name="alternate_phone" type="text">
							</div>
						</div>											
					</div>
					<div class="row" style="margin-top: 10px;">
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label">Mobile</label><br />
								<input value="<?php echo $lead['mobile']; ?>" class="text-line" id="mobile" name="mobile" type="text">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label">Alternate Mobile</label><br />
								<input value="<?php echo $lead['alternate_mobile']; ?>" class="text-line" id="alternate_mobile" name="alternate_mobile" type="text">
							</div>
						</div>											
					</div>
					<div class="row" style="margin-top: 10px;">
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label">State</label><br />
								<select class="text-line" id="state" name="state">
									<option value=""></option>
									<option value="ACT" <?php echo (($lead["state"]=="ACT") ? "selected" : ""); ?> >Australian Capital Territory</option>
									<option value="NSW" <?php echo (($lead["state"]=="NSW") ? "selected" : ""); ?> >New South Wales</option>
									<option value="NT" <?php echo (($lead["state"]=="NT") ? "selected" : ""); ?> >Northern Territory</option>
									<option value="QLD" <?php echo (($lead["state"]=="QLD") ? "selected" : ""); ?> >Queensland</option>
									<option value="SA" <?php echo (($lead["state"]=="SA") ? "selected" : ""); ?> >South Australia</option>
									<option value="TAS" <?php echo (($lead["state"]=="TAS") ? "selected" : ""); ?> >Tasmania</option>
									<option value="VIC" <?php echo (($lead["state"]=="VIC") ? "selected" : ""); ?> >Victoria</option>
									<option value="WA"  <?php echo (($lead["state"]=="WA") ? "selected" : ""); ?> >Western Australia</option>
								</select>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label">Postcode</label><br />
								<input value="<?php echo $lead['postcode']; ?>" class="text-line" id="postcode" name="postcode" type="text">
							</div>
						</div>		
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label">Address</label><br />
								<input value="<?php echo $lead['address']; ?>" class="text-line" id="address" name="address" type="text">
							</div>
						</div>													
					</div>
					<div class="row" style="margin-top: 10px;">
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label">Date of Birth</label><br />
								<input value="<?php echo $lead['date_of_birth']; ?>" class="text-line datepicker" data-date-format="yyyy-mm-dd" id="date_of_birth" name="date_of_birth" type="text">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label">Driver's License</label><br />
								<input value="<?php echo $lead['driver_license']; ?>" class="text-line" id="driver_license" name="driver_license" type="text">
							</div>
						</div>											
					</div>
					<br />
					<div class="row" style="margin-top: 10px;">
						<div class="col-sm-12">
							<button type="submit" class="btn btn-primary">
								<i class="fa fa-save"></i> Save
							</button>																													
						</div>
					</div>
				</div>
			</form>
		</section>
<?php
if ($lead['status']==3 OR $lead['status']==4 OR $lead['status']==5 OR $lead['status']==6 OR $lead['status']==7 OR $lead['status']==8 OR $lead['status']==9)
{
	?>
<section class="panel"> <!-- Tender Details -->
<form method="post" id="tender_details_form" name="tender_details_form" action="">
	<input type="hidden" id="id_lead" name="id_lead" value="<?php echo $lead['id_lead']; ?>" />
	<input type="hidden" id="id_quote_request" name="id_quote_request" value="<?php echo $lead['id_quote_request']; ?>" />
	<input type="hidden" id="id_make" name="id_make" value="<?php echo $lead['id_make']; ?>" />
	<input type="hidden" id="id_family" name="id_family" value="<?php echo $lead['id_family']; ?>" />
	<input type="hidden" id="id_vehicle" name="id_vehicle" value="<?php echo $lead['id_vehicle']; ?>" />
	<input type="hidden" id="build_date" name="build_date" value="<?php echo $lead['build_date']; ?>" />
	<input type="hidden" id="colour" name="colour" value="<?php echo $lead['colour']; ?>" />
	<input type="hidden" id="registration_type" name="registration_type" value="<?php echo $lead['registration_type']; ?>" />
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<h5><b>Tender Details</b></h5>
						<hr class="solid mt-sm mb-lg">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<h5><b>Vehicle:</b></h5>
							<p><?php echo $lead['build_date']." ".$lead['tender_make']." ".$lead['tender_model']." ".$lead['tender_variant']; ?></p>
						</div>
					</div>
				</div>
				<div class="row" style="margin-top: 20px;">
					<div class="col-md-12">
						<h5><b>Invited Dealers</b></h5>
						<hr class="solid mt-sm mb-lg">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-condensed mb-none">
								<tbody>
									<tr>
										<td><b>Name</b></td>
										<td><b>Invites</b></td>
										<td><b>Quotes</b></td>
										<td><b>Won</b></td>
										<td><b>Orders</b></td>
									</tr>
									<?php
									if (count($tender_dealers)==0)
									{
										?>
										<tr id="norecord"><td colspan="5"><center>No records found!</center></td></tr>
										<?php
									}
									else
									{
										foreach ($tender_dealers as $tender_dealer)
										{
											?>
											<tr>
												<td><a href="<?php echo site_url('user/record/'.$tender_dealer['user_id']); ?>" target="_blank"><?php echo $tender_dealer['name']; ?></a></td>
												<td><?php echo $tender_dealer['tender_count']; ?></td>
												<td><?php echo $tender_dealer['quote_count']; ?></td>
												<td><?php echo $tender_dealer['won_count']; ?></td>
												<td><?php echo $tender_dealer['order_count']; ?></td>
											</tr>
											<?php
										}																			
									}
									?>
								</tbody>																	
							</table>
						</div>
					</div>
				</div>	
				<div class="row" style="margin-top: 20px;">
					<div class="col-md-12">
						<h5><b>Email Invitations</b></h5>
						<hr class="solid mt-sm mb-lg">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-condensed mb-none">
								<tbody>
									<tr>
										<td><b>Email</b></td>
										<td><b>Date</b></td>
									</tr>
									<?php
									if (count($tender_email_invites)==0)
									{
										?>
										<tr id="norecord"><td colspan="2"><center>No records found!</center></td></tr>
										<?php
									}
									else
									{
										foreach ($tender_email_invites as $tender_email_invite)
										{
											?>
											<tr>
												<td><?php echo $tender_email_invite['email']; ?></td>
												<td><?php echo $tender_email_invite['invite_date']; ?></td>
											</tr>
											<?php
										}																			
									}
									?>
								</tbody>																	
							</table>
						</div>
					</div>
				</div>
				<br />
			</div>
		</form>
	</section>											
<section class="panel"> <!-- Dealer Quotes -->
	<form method="post" id="dealer_quotes_form" name="dealer_quotes_form" action="">
		<input type="hidden" id="id_lead" name="id_lead" value="<?php echo $lead['id_lead']; ?>" />
		<input type="hidden" id="id_quote_request" name="id_quote_request" value="<?php echo $lead['id_quote_request']; ?>" />
		<div class="panel-body">
			<div class="row">
				<div class="col-md-12">
					<h5><b>Dealer Quotes</b></h5>
					<hr class="solid mt-sm mb-lg">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-condensed mb-none">
							<tbody>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<?php
									if ($admin_type == 2)
									{
										?>
										<td></td>
										<?php
									}
									?>
									<td><b>Sender</b></td>
									<td><b>Type</b></td>
									<td><b>Dealer</b></td>
									<td><b>List Price</b></td>
									<td><b>Total Price</b></td>
									<td><b>Date</b></td>
								</tr>
								<?php
								if (count($tender_quotes)==0)
								{
									?>
									<tr id="norecord"><td colspan="10"><center>No records found!</center></td></tr>
									<?php
								}
								else
								{
									foreach ($tender_quotes as $tender_quote)
									{															
										$warning_flag = "";
										if ($tender_quote['total'] < 5000 OR $tender_quote['retail_price'] < 5000)
										{
											$warning_flag = '&nbsp;<span style="color: red"><i class="fa fa-exclamation-triangle" data-toggle="tooltip" title="Quote is too low"></i></span>';
										}
										
										$new_flag = "";
										if ($tender_quote['seen_status']==0)
										{
											$new_flag = '&nbsp;<span style="color: red; font-size: 0.9em;">New</span>';
										}
										?>
										<tr>
											<td align="center">
												<span class="ajax_button_primary quote_modal_button" data-id_lead="<?php echo $lead['id_lead']; ?>" data-id_quote_request="<?php echo $tender_quote['id_quote_request']; ?>" data-id_quote="<?php echo $tender_quote['id_quote']; ?>">
													<i class="fa fa-edit" data-toggle="tooltip" title="Edit Quote"></i>
												</span>
											</td>
											<?php
											if ($tender_quote['seen_status'] == 1) 
											{
												?>																			
												<td align="center">
													<i class="fa fa-eye"></i>																																										
												</td>
												<?php
											}
											else
											{
												?>
												<td align="center">
													<span class="ajax_button_primary update_quote_seen_status_button" data-id_lead="<?php echo $lead['id_lead']; ?>" data-id_quote_request="<?php echo $tender_quote['id_quote_request']; ?>" data-id_quote="<?php echo $tender_quote['id_quote']; ?>" data-seen_status="1">
														<i class="fa fa-eye" data-toggle="tooltip" title="Mark as Seen"></i>
													</span>																																												
												</td>
												<?php																							
											}
											?>																						
											<?php
											if ($tender_quote['winner']==$tender_quote['id_quote']) 
											{
												?>																			
												<td align="center">
													<i class="fa fa-trophy"></i>																																										
												</td>
												<?php
											}
											else
											{
												?>
												<td align="center">
													<span class="ajax_button_primary select_winning_quote_button" data-id_lead="<?php echo $lead['id_lead']; ?>" data-id_quote_request="<?php echo $tender_quote['id_quote_request']; ?>" data-id_quote="<?php echo $tender_quote['id_quote']; ?>">
														<i class="fa fa-trophy" data-toggle="tooltip" title="Nominate as Winning Quote"></i>
													</span>																																												
												</td>
												<?php																							
											}
											?>
											<?php
											if ($admin_type == 2)
											{
												?>
												<td align="center">
													<span class="ajax_button_primary delete_quote_button" data-id_lead="<?php echo $lead['id_lead']; ?>" data-id_quote_request="<?php echo $tender_quote['id_quote_request']; ?>" data-id_quote="<?php echo $tender_quote['id_quote']; ?>">
														<i class="fa fa-trash-o" data-toggle="tooltip" title="Delete Quote"></i>
													</span>
												</td>	
												<?php
											}
											?>																							
											<td style="vertical-align: middle"><?php echo $tender_quote['sender']; ?></td>
											<td style="vertical-align: middle"><?php echo $tender_quote['demo']; ?></td>
											<td style="vertical-align: middle"><a href="<?php echo site_url('user/record/'.$tender_quote['dealer_id']); ?>" target="_blank"><?php echo $tender_quote['name']; ?></a> <?php echo $warning_flag . " " . $new_flag; ?></td>
											<td style="vertical-align: middle"><?php echo $tender_quote['retail_price']; ?></td>
											<td style="vertical-align: middle"><?php echo $tender_quote['total']; ?></td>
											<td style="vertical-align: middle"><?php echo $tender_quote['date_submitted']; ?></td>
										</tr>
										<?php
									}																			
								}
								?>
							</tbody>																	
						</table>
					</div>
				</div>
			</div>
		</div>
	</form>
</section>	
<section class="panel"> <!-- Previous Quotes (Same Variant) -->
	<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
				<h5><b>Previous Quotes (Same Variant)</b></h5>
				<hr class="solid mt-sm mb-lg">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-condensed mb-none">
						<tbody>
							<tr>
								<td><b></b></td>
								<td><b>Type</b></td>
								<td><b>Dealer</b></td>
								<td><b>List Price</b></td>
								<td><b>Total Price</b></td>
								<td><b>Date</b></td>
							</tr>
							<?php
							if (count($tender_same_variant_quotes)==0)
							{
								?>
								<tr id="norecord"><td colspan="6"><center>No records found!</center></td></tr>
								<?php
							}
							else
							{
								foreach ($tender_same_variant_quotes as $tender_same_variant_quote)
								{
									$warning_flag = "";
									if ($tender_same_variant_quote['total'] < 5000 OR $tender_same_variant_quote['retail_price'] < 5000)
									{
										$warning_flag .= '&nbsp;<span style="color: red"><i class="fa fa-exclamation-triangle" data-toggle="tooltip" title="Quote is too low"></i></span>';
									}

									if ($tender_same_variant_quote['tradein_count'] > 0)
									{
										$warning_flag .= '&nbsp;<span style="color: red"><i class="fa fa-exclamation-triangle" data-toggle="tooltip" title="This quote has a tradein"></i></span>';
									}																							
									?>
									<tr>
										<td align="center">
											<span class="ajax_button_primary quote_modal_button" data-id_lead="<?php echo $lead['id_lead']; ?>" data-id_quote_request="<?php echo $tender_same_variant_quote['id_quote_request']; ?>" data-id_quote="<?php echo $tender_same_variant_quote['id_quote']; ?>" data-process="view">
												<i class="fa fa-edit" data-toggle="tooltip" title="View Quote"></i>
											</span>
										</td>
										<td style="vertical-align: middle">
											<?php echo $tender_same_variant_quote['demo']; ?>
										</td>
										<td style="vertical-align: middle">
											<a href="<?php echo site_url('user/record/'.$tender_same_variant_quote['dealer_id']); ?>" target="_blank">
												<?php echo $tender_same_variant_quote['name']; ?>
											</a> <?php echo $warning_flag; ?>
										</td>
										<td style="vertical-align: middle"><?php echo $tender_same_variant_quote['retail_price']; ?></td>
										<td style="vertical-align: middle"><?php echo $tender_same_variant_quote['total']; ?></td>
										<td style="vertical-align: middle"><?php echo $tender_same_variant_quote['date_submitted']." days ago"; ?></td>
									</tr>
									<?php
								}																			
							}
							?>
						</tbody>																	
					</table>
				</div>
			</div>
		</div>
	</div>
</section>		
	<section class="panel"> <!-- Previous Quotes (Same Model) -->
		<div class="panel-body">
			<div class="row">
				<div class="col-md-12">
					<h5><b>Previous Quotes (Same Model)</b></h5>
					<hr class="solid mt-sm mb-lg">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-condensed mb-none">
							<tbody>
								<tr>
									<td></td>
									<td><b>Type</b></td>
									<td><b>Dealer</b></td>
									<td><b>List Price</b></td>
									<td><b>Total Price</b></td>
									<td><b>Date</b></td>
								</tr>
								<?php
								if (count($tender_same_model_quotes)==0)
								{
									?>
									<tr id="norecord"><td colspan="6"><center>No records found!</center></td></tr>
									<?php
								}
								else
								{
									foreach ($tender_same_model_quotes as $tender_same_model_quote)
									{
										$warning_flag = "";
										if ($tender_same_model_quote['total'] < 5000 OR $tender_same_model_quote['retail_price'] < 5000)
										{
											$warning_flag .= '&nbsp;<span style="color: red"><i class="fa fa-exclamation-triangle" data-toggle="tooltip" title="Quote is too low"></i></span>';
										}				

										if ($tender_same_model_quote['tradein_count'] > 0)
										{
											$warning_flag .= '&nbsp;<span style="color: red"><i class="fa fa-exclamation-triangle" data-toggle="tooltip" title="This quote has a tradein"></i></span>';
										}																																											
										?>
										<tr>
											<td align="center">
												<span class="ajax_button_primary quote_modal_button" data-id_lead="<?php echo $lead['id_lead']; ?>" data-id_quote_request="<?php echo $tender_same_model_quote['id_quote_request']; ?>" data-id_quote="<?php echo $tender_same_model_quote['id_quote']; ?>" data-process="view">
													<i class="fa fa-edit" data-toggle="tooltip" title="View Quote"></i>
												</span>
											</td>																				
											<td style="vertical-align: middle"><?php echo $tender_same_model_quote['demo']; ?></td>
											<td style="vertical-align: middle">
												<a href="<?php echo site_url('user/record/'.$tender_same_model_quote['dealer_id']); ?>" target="_blank">
													<?php echo $tender_same_model_quote['name']; ?>
												</a> <?php echo $warning_flag; ?>
											</td>
											<td style="vertical-align: middle"><?php echo $tender_same_model_quote['retail_price']; ?></td>
											<td style="vertical-align: middle"><?php echo $tender_same_model_quote['total']; ?></td>
											<td style="vertical-align: middle"><?php echo $tender_same_model_quote['date_submitted']." days ago"; ?></td>
										</tr>
										<?php
									}																			
								}
								?>
							</tbody>																	
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>											
<?php
}
?>
<?php
if ($lead['status']==3 OR $lead['status']==4 OR $lead['status']==5 OR $lead['status']==6 OR $lead['status']==7 OR $lead['status']==8 OR $lead['status']==9)
{
	?>
	<section class="panel"> <!-- Delivery Details -->
		<form method="post" id="delivery_details_form" name="delivery_details_form" action="">
			<input type="hidden" name="id_lead" value="<?php echo $lead['id_lead']; ?>" />										
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<h5><b>Delivery Details</b></h5>
						<hr class="solid mt-sm mb-lg">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">Delivery Date</label><br />
							<input value="<?php echo $lead['delivery_date']; ?>" class="text-line datepicker" data-date-format="yyyy-mm-dd" id="delivery_date" name="delivery_date" type="text">
						</div>
					</div>
				</div>			
				<div class="row" style="margin-top: 10px;">
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">Delivery Address</label><br />
							<?php
							$delivery_address_hidden = '';
							if ($lead['delivery_address_map']==1)
							{
								$delivery_address_hidden = ' hidden="hidden" ';
							}
							?>
							Same as the Client Address? &nbsp; 
							<select class="text-line" name="delivery_address_map" id="delivery_address_map" style="width: 100px;" data-container="delivery_details_form">
								<option value="0" <?php if ($lead['delivery_address_map'] == 0) { echo 'selected="selected"'; } ?>>No</option>
								<option value="1" <?php if ($lead['delivery_address_map'] == 1) { echo 'selected="selected"'; } ?>>Yes</option>
							</select>
							<br />
							<br />
							<input value="<?php echo $lead['delivery_address']; ?>" class="text-line" id="delivery_address" name="delivery_address" type="text" <?php echo $delivery_address_hidden; ?>>
						</div>
					</div>
				</div>
				<div class="row" style="margin-top: 10px;">
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">Delivery Instructions</label><br />
							<input value="<?php echo $lead['delivery_instructions']; ?>" class="text-line" id="delivery_instructions" name="delivery_instructions" type="text">
						</div>
					</div>
				</div>
				<div class="row" style="margin-top: 10px;">
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">Special Conditions</label><br />
							<input value="<?php echo $lead['special_conditions']; ?>" class="text-line" id="special_conditions" name="special_conditions" type="text">
						</div>
					</div>													
				</div>	
				<div class="row" style="margin-top: 10px;">
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">Transport</label><br />
							<select class="text-line" name="transport" id="transport">
								<option value="0" <?php if ($lead['transport'] == 0) { echo 'selected="selected"'; } ?>></option>
								<option value="1" <?php if ($lead['transport'] == 1) { echo 'selected="selected"'; } ?>>Dealer will deliver the car to the client</option>
								<option value="2" <?php if ($lead['transport'] == 2) { echo 'selected="selected"'; } ?>>Client will attend the dealership to take delivery</option>
								<option value="3" <?php if ($lead['transport'] == 3) { echo 'selected="selected"'; } ?>>Quote me is organising the transport to the client</option>
							</select>
							<!--
							<label class="control-label">Transport Cost</label><br />
							<input type="text" value="<?php echo $lead['transport_cost']; ?>" class="text-line" name="transport_cost" id="transport_cost" onkeypress="return isNumberKey(event)"></td>
							-->
						</div>
					</div>													
				</div>													
				<br />
				<div class="row" style="margin-top: 10px;">
					<div class="col-sm-12">
						<button type="submit" class="btn btn-primary">
							<i class="fa fa-save"></i> Save
						</button>																													
					</div>
				</div>											
			</div>
		</form>
	</section>
	<?php
}
?>											
<?php
if ($lead['status']==3 OR $lead['status']==4 OR $lead['status']==5 OR $lead['status']==6 OR $lead['status']==7 OR $lead['status']==8 OR $lead['status']==9)
{
?>											
<section class="panel"> <!-- Settlement Details -->
<form method="post" id="settlement_details_form" name="settlement_details_form" action="">
<input type="hidden" name="id_lead" value="<?php echo $lead['id_lead']; ?>" />
<div class="panel-body">
<div class="row">
	<div class="col-md-12">
		<h5><b>Settlement Details</b></h5>
		<hr class="solid mt-sm mb-lg">
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="form-group">
			<label class="control-label">Settled Date</label><br />
			<input value="<?php echo $lead['settled_date']; ?>" class="text-line datepicker" data-date-format="yyyy-mm-dd" id="settled_date" name="settled_date" type="text">
		</div>
	</div>
</div>
<div class="row" style="margin-top: 10px;">
	<div class="col-sm-12">
		<div class="form-group">
			<label class="control-label">Bank account to be used on Invoice</label><br />
			<select class="text-line" id="fk_bank_account" name="fk_bank_account">
				<option value="0"></option>
				<?php
				$bank_account_selected = '';
				foreach ($bank_accounts as $bank_account) 
				{
					if ($lead['fk_bank_account']==$bank_account->id_bank_account)
					{
						$bank_account_selected = ' selected="selected"';
					}
					?>
					<option value="<?php echo $bank_account->id_bank_account; ?>" <?php echo $bank_account_selected; ?>>
						<?php echo $bank_account->name; ?>
					</option>
					<?php
				}
				?>
			</select>
		</div>
	</div>
</div>
<div class="row" style="margin-top: 10px;">
	<div class="col-sm-12">
		<div class="form-group">
			<label class="control-label">Exempt from LCT and Stamp Duty</label><br />
			<select class="text-line" id="client_invoice_taxes" name="client_invoice_taxes">
				<option value="0" <?php if ($lead['client_invoice_taxes'] == 0) { echo 'selected="selected"'; } ?>>No</option>
				<option value="1" <?php if ($lead['client_invoice_taxes'] == 1) { echo 'selected="selected"'; } ?>>Yes</option>
			</select>
		</div>
	</div>
</div>
<br />
<div class="row" style="margin-top: 10px;">
	<div class="col-sm-12">
		<div class="form-group">
			<label class="control-label">Deposit</label><br />
			<select class="text-line" id="deposit" name="deposit">
				<option value="0" <?php if ($lead['deposit'] == 0) { echo 'selected="selected"'; } ?>></option>
				<option value="1" <?php if ($lead['deposit'] == 1) { echo 'selected="selected"'; } ?>>Case 1</option>
				<option value="2" <?php if ($lead['deposit'] == 2) { echo 'selected="selected"'; } ?>>Case 2</option>
				<option value="3" <?php if ($lead['deposit'] == 3) { echo 'selected="selected"'; } ?>>Case 3</option>
				<option value="4" <?php if ($lead['deposit'] == 4) { echo 'selected="selected"'; } ?>>Case 4</option>
			</select>
		</div>
	</div>
</div>
<br />
<div class="row" style="margin-top: 10px;">
	<div class="col-sm-12">
		<div class="alert alert-info">														
			<strong>Case 1:</strong>
			<p>Qteme will refund the client in full his deposit once the
			car is confirmed in the portal as delivered and paid for in
			full. Qteme me invoice being paid by the dealer
			is the action that releases the deposit</p>
			<br />
			<strong>Case 2:</strong>
			<p>Deposit will be transferred to the dealer 24 hours before
			delivery when the dealer sends a copy of the tax
			invoice showing the vin chassis or registration number. This 
			deposit is forwarded less any corresponding
			Qteme invoice to the dealer</p>
			<br />
			<strong>Case 3:</strong>
			<p>The dealership has taken the deposit and will fund
			qteme a invoice of $XXX.XX 3 - 5 days post delivery</p>
			<br />
			<strong>Case 4:</strong>
			<p>Deposit will be transferred to the dealer 24
			hours before delivery when the dealer sends a
			copy of the tax invoice showing the vin chassis
			or registration number. The dealer is to fund 
			any corresponding qteme invoice
			24 hours after delivery</p>	
		</div>
	</div>
</div>
<div class="row" style="margin-top: 10px;">
	<div class="col-sm-12">
		<button type="submit" class="btn btn-primary">
			<i class="fa fa-save"></i> Save
		</button>																													
	</div>
</div>												
</div>
</form>
</section>
<section class="panel"> <!-- Aftersales Accessories Details -->
<form method="post" id="aftersales_accessories_form" name="aftersales_accessories_form" action="">
<input type="hidden" name="id_lead" value="<?php echo $lead['id_lead']; ?>" />										
<div class="panel-body">
<div class="row">
	<div class="col-md-12">
		<h5><b>Aftersales Accessories</b></h5>
		<hr class="solid mt-sm mb-lg">
	</div>
</div>		
<div class="row">
	<div class="col-sm-12">
		<div class="form-group">
			<label class="control-label">Job Date</label><br />
			<input value="<?php echo $lead['accessory_job_date']; ?>" class="text-line datepicker" data-date-format="yyyy-mm-dd" id="accessory_job_date" name="accessory_job_date" type="text">
		</div>
	</div>
</div>
<div class="row" style="margin-top: 10px;">														
	<div class="col-sm-12">
		<div class="form-group">
			<label class="control-label">Special Conditions</label><br />
			<input value="<?php echo $lead['accessory_special_conditions']; ?>" class="text-line" id="accessory_special_conditions" name="accessory_special_conditions" type="text">
		</div>
	</div>														
</div>																										
<div class="row" style="margin-top: 25px;">
	<div class="col-md-12">													
		<div class="table-responsive">
			<table class="table table-bordered table-striped table-condensed mb-none">
				<thead>
					<tr>
						<td align="center"><b><i class="fa fa-trash-o"></i></b></td>
						<td><b>Item</b></td>
						<td><b>Price</b></td>
						<td><b>Quantity</b></td>
						<td><b>Total</b></td>
					</tr>
				</thead>
				<tbody>
					<?php
					if (count($lead_aftersales_accessories)==0)
					{
						?>
						<tr><td colspan="6" align="center"><center>No records found!</center></td></tr>
						<?php
					}
					else
					{
						foreach ($lead_aftersales_accessories AS $lead_aftersales_accessory)
						{
							$after_sales_item = '<span style="color: #58c603;">'.$lead_aftersales_accessory['accessory_name'].'</span>';
							if ($lead_aftersales_accessory['accessory_code']<>"")
							{
								$after_sales_item .= ' ('.$lead_aftersales_accessory['accessory_code'].')';
							}
							
							if ($lead_aftersales_accessory['accessory_supplier_name']<>"")
							{
								$after_sales_item .= '<br /><span style="font-size: 0.9em;"><i>'.$lead_aftersales_accessory['accessory_supplier_name'].'</i>';
							}
							
							$after_sales_item .= '<br />Supplier Cost: $<b>'.$lead_aftersales_accessory['accessory_cost']."</b>";

							$lead_aftersales_accessory_line_price = $lead_aftersales_accessory['price'] * $lead_aftersales_accessory['quantity'];
							?>
							<tr>
								<td align="center"></td>
								<td><?php echo $after_sales_item; ?></td>
								<td align="right"><?php echo $lead_aftersales_accessory['price']; ?></td>
								<td align="right"><?php echo $lead_aftersales_accessory['quantity']; ?></td>
								<td align="right"><?php echo $lead_aftersales_accessory_line_price; ?></td>
							</tr>
							<?php																			
						}
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
					<!--
					<div class="row" style="margin-top: 10px;">
						<div class="col-sm-12">
							<span class="btn btn-primary ajax_button aftersales_accessories_modal_button" data-id_lead="<?php echo $lead['id_lead']; ?>">
								Add Accessory
							</span>																													
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">	
							<br />
							<p><b>Total Price:</b> </p>
						</div>
						<div class="col-md-6">	
							<br />
							<p><b>Total Revenue:</b> </p>
						</div>														
					</div>
					<br />		
					<div class="row" style="margin-top: 10px;">
						<div class="col-sm-12">
							<button type="submit" class="btn btn-primary">
								<i class="fa fa-save"></i> Save
							</button>																													
						</div>
					</div>
					-->
				</div>
			</form>
		</section>											
		<section class="panel"> <!-- Computation -->
			<form method="post" id="computation_form" name="computation_form" action="">
				<input type="hidden" name="id_lead" value="<?php echo $lead['id_lead']; ?>" />										
				<input type="hidden" id="membership" name="membership" value="<?php echo $lead['gross_subtractor']; ?>">
				<input type="hidden" id="membership_lower" name="membership_lower" value="<?php echo $lead['gross_subtractor_lower']; ?>">
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<h5><b>Computation</b></h5>
							<hr class="solid mt-sm mb-lg">
							<?php
							if ($lead['state']=="ACT") { $answer_act_hidden = ''; } else { $answer_act_hidden = 'hidden="hidden"'; }
							if ($lead['state']=="VIC") { $answer_vic_hidden = ''; } else { $answer_vic_hidden = 'hidden="hidden"'; }
							if ($lead['state']=="QLD") { $answer_qld_hidden = ''; } else { $answer_qld_hidden = 'hidden="hidden"'; }
							
							$answer_act_1_selected = "";
							$answer_act_2_selected = "";
							$answer_act_3_selected = "";
							$answer_act_4_selected = "";
							if ($lead['answer_act']=="A-rated") { $answer_act_1_selected = ' selected="selected" '; }
							else if ($lead['answer_act']=="B-rated") { $answer_act_2_selected = ' selected="selected" '; }
							else if ($lead['answer_act']=="C-rated and Non-rated") { $answer_act_3_selected = ' selected="selected" '; }
							else if ($lead['answer_act']=="D-rated") { $answer_act_4_selected = ' selected="selected" '; }

							$answer_vic_1_selected = "";
							$answer_vic_2_selected = "";
							$answer_vic_3_selected = "";
							if ($lead['answer_vic']=="New Vehicle - Passenger") { $answer_vic_1_selected = ' selected="selected" '; }
							else if ($lead['answer_vic']=="New Vehicle - Non Passenger") { $answer_vic_2_selected = ' selected="selected" '; }
							else if ($lead['answer_vic']=="Used Vehicle (Previously Registered)") { $answer_vic_3_selected = ' selected="selected" '; }

							$answer_qld_1_selected = "";
							$answer_qld_2_selected = "";
							$answer_qld_3_selected = "";
							$answer_qld_4_selected = "";			
							if ($lead['answer_qld']=="Hybrid and electric vehicles") { $answer_qld_1_selected = ' selected="selected" '; }
							else if ($lead['answer_qld']=="1 to 4 cylinders -2 rotors or a steam vehicle") { $answer_qld_2_selected = ' selected="selected" '; }
							else if ($lead['answer_qld']=="5 to 6 cylinders -3 rotors") { $answer_qld_3_selected = ' selected="selected" '; }
							else if ($lead['answer_qld']=="7 or more cylinders") { $answer_qld_4_selected = ' selected="selected" '; }
							
							$deduct_to_dealer_invoice_check = "";
							if ($lead['deduct_to_dealer_invoice'] == 1)
							{
								$deduct_to_dealer_invoice_check = 'checked="checked"';
							}
							else
							{
								$deduct_to_dealer_invoice_check = '';
							}
							?>
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-condensed mb-none">
									<tr>
										<td width="70%">Client State:</td>
										<td><?php echo $lead['state']; ?></td>
									</tr>
									<tr>
										<td>Dealer State:</td>
										<td><?php echo $lead['dealer_state']; ?></td>
									</tr>							
									<tr id="vehicle_type_act" <?php echo $answer_act_hidden; ?>>
										<td>Vehicle Type:</td>
										<td>
											<select class="form-control input-sm" name="answer_act" id="answer_act">
												<option value=""></option>
												<option value="A-rated" <?php echo $answer_act_1_selected; ?>>A-rated</option>
												<option value="B-rated" <?php echo $answer_act_2_selected; ?>>B-rated</option>
												<option value="C-rated and Non-rated" <?php echo $answer_act_3_selected; ?>>C-rated and Non-rated</option>
												<option value="D-rated" <?php echo $answer_act_4_selected; ?>>D-rated</option>
											</select>
										</td>
									</tr>
									<tr id="vehicle_type_vic" <?php echo $answer_vic_hidden; ?>>
										<td>Vehicle Type:</td>
										<td>
											<select class="form-control input-sm" name="answer_vic" id="answer_vic">
												<option value=""></option>
												<option value="New Vehicle - Passenger" <?php echo $answer_vic_1_selected; ?>>New Vehicle - Passenger</option>
												<option value="New Vehicle - Non Passenger" <?php echo $answer_vic_2_selected; ?>>New Vehicle - Non Passenger</option>
												<option value="Used Vehicle (Previously Registered)" <?php echo $answer_vic_3_selected; ?>>Used Vehicle (Previously Registered)</option>
											</select>
										</td>
									</tr>							
									<tr id="vehicle_type_qld" <?php echo $answer_qld_hidden; ?>>
										<td>Vehicle Type:</td>
										<td>								
											<select class="form-control input-sm" name="answer_qld" id="answer_qld">
												<option value=""></option>
												<option value="Hybrid and electric vehicles" <?php echo $answer_qld_1_selected; ?>>Hybrid and electric vehicles</option>
												<option value="1 to 4 cylinders -2 rotors or a steam vehicle" <?php echo $answer_qld_2_selected; ?>>1 to 4 cylinders -2 rotors or a steam vehicle</option>
												<option value="5 to 6 cylinders -3 rotors" <?php echo $answer_qld_3_selected; ?>>5 to 6 cylinders -3 rotors</option>
												<option value="7 or more cylinders" <?php echo $answer_qld_4_selected; ?>>7 or more cylinders</option>
											</select>							
										</td>
									</tr>
								</table>
							</div>
							<br />
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-condensed mb-none">
									<tr>
										<td width="70%">Dealer Quote</td>
										<td><input value="<?php echo $lead['winning_price']; ?>" class="form-control input-sm" id="dqp" name="dqp" type="text" readonly="readonly"></td>
									</tr>
									<tr>
										<td>Attached Trades</td>
										<td><input value="<?php echo $lead['tradein_count']; ?>" class="form-control input-sm" id="tradein_count" name="tradein_count" type="text" readonly="readonly"></td>
									</tr>
									<tr>
										<td>Trades the dealer is taking</td>
										<td><input value="<?php echo $lead['dealer_tradein_count']; ?>" class="form-control input-sm" id="dealer_tradein_count" name="dealer_tradein_count" type="text" readonly="readonly"></td>
									</tr>																
								</table>
							</div>
							<br />
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-condensed mb-none">							
									<tr>
										<td colspan="2"><b>If the dealer is taking the trade</b></td>
									</tr>
									<tr>
										<td width="70%">Dealer Trade Value</td>
										<td><input value="<?php echo round($lead['dealer_tradein_value'], 2); ?>" class="form-control input-sm" id="dealer_tradein_value" name="dealer_tradein_value" type="text" readonly="readonly"></td>
									</tr>
									<tr>
										<td>Dealer Trade Payout</td>
										<td><input value="<?php echo round($lead['dealer_tradein_payout'], 2); ?>" class="form-control input-sm" id="dealer_tradein_payout" name="dealer_tradein_payout" type="text" readonly="readonly"></td>
									</tr>
									<tr>
										<td>Dealer Refund to Client</td>
										<td><input value="<?php echo round($lead['dealer_client_refund'], 2); ?>" class="form-control input-sm" id="dealer_client_refund" name="dealer_client_refund" type="text" readonly="readonly"></td>
									</tr>							
								</table>
							</div>
							<br />														
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-condensed mb-none">							
									<tr>
										<td width="70%"><b>DEALER CHANGEOVER PRICE:</b></td>
										<td><input value="<?php echo round($lead['dealer_changeover'], 2); ?>" class="form-control input-sm" id="dealer_changeover" name="dealer_changeover" type="text" readonly="readonly"></td>
									</tr>							
									<tr>
										<td>Sale Price:</td>
										<td><input value="<?php echo round($lead['sales_price'], 2); ?>" class="form-control input-sm" id="sales_price" name="sales_price" type="text" onKeyPress="return isNumberKey(event)" onChange="calculate_revenue('#computation_form')"></td>
									</tr>
									<tr>
										<td>Trade Value Real:</td>
										<td><input value="<?php echo round($lead['tradein_value'], 2); ?>" class="form-control input-sm" id="real_tradein_value" name="tradein_value" type="text" onKeyPress="return isNumberKey(event)" onChange="calculate_revenue('#computation_form')"></td>
									</tr>						
									<tr>
										<td>Trade Value Shown:</td>
										<td><input value="<?php echo round($lead['tradein_given'], 2); ?>" class="form-control input-sm" id="real_tradein_given" name="tradein_given" type="text" onKeyPress="return isNumberKey(event)" onChange="calculate_revenue('#computation_form')"></td>
									</tr>
									<tr>
										<td>Trade Payout:</td>
										<td><input value="<?php echo round($lead['tradein_payout'], 2); ?>" class="form-control input-sm" id="real_tradein_payout" name="tradein_payout" type="text" onKeyPress="return isNumberKey(event)" onChange="calculate_revenue('#computation_form')"></td>
									</tr>
									<tr>
										<td>Changeover:</td>
										<td><input value="<?php echo round($lead_calculation_details['changeover'], 2); ?>" class="form-control input-sm" id="cpp" name="cpp" type="text" readonly="readonly"></td>
									</tr>					
									<tr>
										<td>Total Deposits:</td>
										<td><input value="<?php echo round($lead['deposits_total'], 2); ?>" class="form-control input-sm" id="deposits_total" name="deposits_total" type="text" readonly="readonly"></td>
									</tr>
									<tr>
										<td>Total Refunds:</td>
										<td><input value="<?php echo round($lead['refunds_total'], 2); ?>" class="form-control input-sm" id="refunds_total" name="refunds_total" type="text" readonly="readonly"></td>
									</tr>
									<tr>
										<td><b>CLIENT BALANCE PAYABLE:</b></td>
										<td><input value="<?php echo round($lead_calculation_details['balance'], 2); ?>" class="form-control input-sm" id="balance" name="balance" type="text" readonly="readonly"></td>
									</tr>
									<tr>
										<td><b>DEALER BALCQO:</b></td>
										<td><input value="<?php echo round($lead_calculation_details['dealer_balance'], 2); ?>" class="form-control input-sm" id="dealer_balance" name="dealer_balance" type="text" readonly="readonly"></td>
									</tr>
									<tr>
										<td><b>CLIENT BALCQO:</b></td>
										<td><input value="<?php echo round($lead['balcqo_client'], 2); ?>" class="form-control input-sm" id="balcqo_client" name="balcqo_client" type="text"></td>
									</tr>							
								</table>
							</div>
							<br />	
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-condensed mb-none">					
									<tr>
										<td width="70%">
											Other Costs Amount:
											<br />
											<br />
											<input <?php echo $deduct_to_dealer_invoice_check; ?> value="1" id="deduct_to_dealer_invoice" name="deduct_to_dealer_invoice" type="checkbox">
											Deduct this from Dealer Invoice?																			
										</td>
										<td>
											<input value="<?php echo $lead['other_costs_amount']; ?>" class="form-control input-sm" id="other_costs_amount" name="other_costs_amount" onKeyPress="return isNumberKey(event)" onChange="calculate_revenue('#computation_form')" type="text">
										</td>
									</tr>
									<tr>
										<td>Transport Cost:</td>
										<td>
											<input value="<?php echo $lead['transport_cost']; ?>" class="form-control input-sm" id="transport_cost" name="transport_cost" onKeyPress="return isNumberKey(event)" onChange="calculate_revenue('#computation_form')" type="text">
											<?php
											$estimated_trasnport_cost = 0;
											
											if ($lead['dealer_state']=="NSW" AND $lead['state']=="ACT") { $estimated_trasnport_cost = 614.00; }
											if ($lead['dealer_state']=="NSW" AND $lead['state']=="VIC") { $estimated_trasnport_cost = 510.00; }
											if ($lead['dealer_state']=="NSW" AND $lead['state']=="QLD ") { $estimated_trasnport_cost = 632.00; }
											if ($lead['dealer_state']=="NSW" AND $lead['state']=="SA") { $estimated_trasnport_cost = 749.00; }
											if ($lead['dealer_state']=="NSW" AND $lead['state']=="WA") { $estimated_trasnport_cost = 1623.00; }
											if ($lead['dealer_state']=="NSW" AND $lead['state']=="TAS") { $estimated_trasnport_cost = 1654.00; }
											if ($lead['dealer_state']=="NSW" AND $lead['state']=="NT") { $estimated_trasnport_cost = 2428.00; }
											
											if ($lead['dealer_state']=="ACT" AND $lead['state']=="NSW") { $estimated_trasnport_cost = 655.00; }
											if ($lead['dealer_state']=="ACT" AND $lead['state']=="VIC") { $estimated_trasnport_cost = 428.00; }
											if ($lead['dealer_state']=="ACT" AND $lead['state']=="QLD ") { $estimated_trasnport_cost = 851.00; }
											if ($lead['dealer_state']=="ACT" AND $lead['state']=="SA") { $estimated_trasnport_cost = 396.00; }
											if ($lead['dealer_state']=="ACT" AND $lead['state']=="WA") { $estimated_trasnport_cost = 1211.00; }
											if ($lead['dealer_state']=="ACT" AND $lead['state']=="TAS") { $estimated_trasnport_cost = 1576.00; }
											if ($lead['dealer_state']=="ACT" AND $lead['state']=="NT") { $estimated_trasnport_cost = 1680.00; }

											if ($lead['dealer_state']=="VIC" AND $lead['state']=="NSW") { $estimated_trasnport_cost = 861.00; }
											if ($lead['dealer_state']=="VIC" AND $lead['state']=="ACT") { $estimated_trasnport_cost = 942.00; }
											if ($lead['dealer_state']=="VIC" AND $lead['state']=="QLD ") { $estimated_trasnport_cost = 1018.00; }
											if ($lead['dealer_state']=="VIC" AND $lead['state']=="SA") { $estimated_trasnport_cost = 451.00; }
											if ($lead['dealer_state']=="VIC" AND $lead['state']=="WA") { $estimated_trasnport_cost = 1387.00; }
											if ($lead['dealer_state']=="VIC" AND $lead['state']=="TAS") { $estimated_trasnport_cost = 1313.00; }
											if ($lead['dealer_state']=="VIC" AND $lead['state']=="NT") { $estimated_trasnport_cost = 1826.00; }
											
											if ($lead['dealer_state']=="QLD" AND $lead['state']=="NSW") { $estimated_trasnport_cost = 725.00; }
											if ($lead['dealer_state']=="QLD" AND $lead['state']=="ACT") { $estimated_trasnport_cost = 994.00; }
											if ($lead['dealer_state']=="QLD" AND $lead['state']=="VIC ") { $estimated_trasnport_cost = 1046.00; }
											if ($lead['dealer_state']=="QLD" AND $lead['state']=="SA") { $estimated_trasnport_cost = 893.00; }
											if ($lead['dealer_state']=="QLD" AND $lead['state']=="WA") { $estimated_trasnport_cost = 1855.00; }
											if ($lead['dealer_state']=="QLD" AND $lead['state']=="TAS") { $estimated_trasnport_cost = 1902.00; }
											if ($lead['dealer_state']=="QLD" AND $lead['state']=="NT") { $estimated_trasnport_cost = 2326.00; }																				
											
											if ($lead['dealer_state']=="SA" AND $lead['state']=="NSW") { $estimated_trasnport_cost = 1214.00; }
											if ($lead['dealer_state']=="SA" AND $lead['state']=="ACT") { $estimated_trasnport_cost = 1353.00; }
											if ($lead['dealer_state']=="SA" AND $lead['state']=="VIC ") { $estimated_trasnport_cost = 817.00; }
											if ($lead['dealer_state']=="SA" AND $lead['state']=="QLD") { $estimated_trasnport_cost = 1294.00; }
											if ($lead['dealer_state']=="SA" AND $lead['state']=="WA") { $estimated_trasnport_cost = 1075.00; }
											if ($lead['dealer_state']=="SA" AND $lead['state']=="TAS") { $estimated_trasnport_cost = 1740.00; }
											if ($lead['dealer_state']=="SA" AND $lead['state']=="NT") { $estimated_trasnport_cost = 1654.00; }
											
											if ($lead['dealer_state']=="WA" AND $lead['state']=="NSW") { $estimated_trasnport_cost = 1242.00; }
											if ($lead['dealer_state']=="WA" AND $lead['state']=="ACT") { $estimated_trasnport_cost = 1497.00; }
											if ($lead['dealer_state']=="WA" AND $lead['state']=="VIC ") { $estimated_trasnport_cost = 908.00; }
											if ($lead['dealer_state']=="WA" AND $lead['state']=="QLD") { $estimated_trasnport_cost = 1466.00; }
											if ($lead['dealer_state']=="WA" AND $lead['state']=="SA") { $estimated_trasnport_cost = 512.00; }
											if ($lead['dealer_state']=="WA" AND $lead['state']=="TAS") { $estimated_trasnport_cost = 2092.00; }
											if ($lead['dealer_state']=="WA" AND $lead['state']=="NT") { $estimated_trasnport_cost = 1678.00; }
											
											if ($lead['dealer_state']=="TAS" AND $lead['state']=="NSW") { $estimated_trasnport_cost = 1702.00; }
											if ($lead['dealer_state']=="TAS" AND $lead['state']=="ACT") { $estimated_trasnport_cost = 1763.00; }
											if ($lead['dealer_state']=="TAS" AND $lead['state']=="VIC ") { $estimated_trasnport_cost = 1018.00; }
											if ($lead['dealer_state']=="TAS" AND $lead['state']=="QLD") { $estimated_trasnport_cost = 1820.00; }
											if ($lead['dealer_state']=="TAS" AND $lead['state']=="SA") { $estimated_trasnport_cost = 1456.00; }
											if ($lead['dealer_state']=="TAS" AND $lead['state']=="WA") { $estimated_trasnport_cost = 2249.00; }
											if ($lead['dealer_state']=="TAS" AND $lead['state']=="NT") { $estimated_trasnport_cost = 2683.00; }
											
											if ($lead['dealer_state']=="NT" AND $lead['state']=="NSW") { $estimated_trasnport_cost = 1430.00; }
											if ($lead['dealer_state']=="NT" AND $lead['state']=="ACT") { $estimated_trasnport_cost = 1534.00; }
											if ($lead['dealer_state']=="NT" AND $lead['state']=="VIC ") { $estimated_trasnport_cost = 1085.00; }
											if ($lead['dealer_state']=="NT" AND $lead['state']=="QLD") { $estimated_trasnport_cost = 1489.00; }
											if ($lead['dealer_state']=="NT" AND $lead['state']=="SA") { $estimated_trasnport_cost = 652.00; }
											if ($lead['dealer_state']=="NT" AND $lead['state']=="WA") { $estimated_trasnport_cost = 1395.00; }
											if ($lead['dealer_state']=="NT" AND $lead['state']=="TAS") { $estimated_trasnport_cost = 2156.00; }
											?>
										</td>
									</tr>																		
									<tr>
										<td><i>Estimated Prixcar Quote from <?php echo $lead['dealer_state']; ?> to <?php echo $lead['state']; ?>:</i></td>
										<td>
											&nbsp;&nbsp;<i>$<?php echo $estimated_trasnport_cost; ?></i>
										</td>
									</tr>																		
									<tr>
										<td>Other Costs Description:</td>
										<td>
											<textarea class="form-control input-sm" id="other_costs_description" name="other_costs_description"><?php echo $lead['other_costs_description']; ?></textarea>
										</td>
									</tr>
									<tr>
										<td>Aftersales Accessories Revenue:</td>
										<td><input value="<?php echo $lead['aftersales_accessory_revenue']; ?>" class="form-control input-sm" id="aftersales_accessory_revenue" name="aftersales_accessory_revenue" onKeyPress="return isNumberKey(event)" onChange="calculate_revenue('#computation_form')" type="text"></td>
									</tr>																		
									<tr>
										<td>Other Revenue Amount:</td>
										<td><input value="<?php echo $lead['other_qs_revenue_amount']; ?>" class="form-control input-sm" id="other_qs_revenue_amount" name="other_qs_revenue_amount" onKeyPress="return isNumberKey(event)" onChange="calculate_revenue('#computation_form')" type="text"></td>
									</tr>
									<tr>
										<td>Other Revenue Description:</td>
										<td>
											<textarea class="form-control input-sm" id="other_qs_revenue_description" name="other_qs_revenue_description"><?php echo $lead['other_qs_revenue_description']; ?></textarea>
										</td>
									</tr>																		
									<tr>
										<td>Commissionable Gross:</td>
										<td><input value="<?php echo $lead_calculation_details['commissionable_gross']; ?>" class="form-control input-sm" type="text" id="commissionable_gross" name="commissionable_gross" readonly></td>
									</tr>
									
									<?php
									if ($admin_type==2)
									{
										?>
										<tr>
											<td>Other Revenue Amount (Not included on the Commissionable Gross):</td>
											<td><input value="<?php echo $lead['other_revenue_amount']; ?>" class="form-control input-sm" id="other_revenue_amount" name="other_revenue_amount" onKeyPress="return isNumberKey(event)" onChange="calculate_revenue('#computation_form')" type="text"></td>
										</tr>
										<tr>
											<td>Other Revenue Description:</td>
											<td>
												<textarea class="form-control input-sm" id="other_revenue_description" name="other_revenue_description"><?php echo $lead['other_revenue_description']; ?></textarea>
											</td>
										</tr>																			
										<?php
									}
									?>

									<tr>
										<td><b>TOTAL REVENUE:</b></td>
										<td><input value="<?php echo $lead_calculation_details['revenue']; ?>" class="form-control input-sm" type="text" id="revenue" name="revenue" readonly></td>
									</tr>																	
									<!--
									if ($data['admin_type'] == 2)
									{
										$calculation_details .= '
										<tr>
											<td>Other Revenue (Amount):</td>
											<td><input value="<?php echo $lead['other_revenue_amount']; ?>" class="form-control input-sm" id="other_revenue_amount" name="other_revenue_amount" onchange="calculate_revenue()" onkeypress="return isNumberKey(event)" type="text"></td>
										</tr>
										<tr>
											<td>Other Revenue (Description):</td>
											<td>
												<textarea class="form-control input-sm" id="other_revenue_description" name="other_revenue_description"><?php echo $lead['other_revenue_description']; ?></textarea>
											</td>
										</tr>						
										<tr>
											<td><b>TOTAL REVENUE:</b></td>
											<td><input value="<?php echo $lead_calculation_details['revenue']; ?>" class="form-control input-sm" type="text" id="revenue" name="revenue" readonly></td>
										</tr>';
									}
									else
									{
										$calculation_details .= '
										<input value="'.$lead['other_revenue_amount'].'" id="other_revenue_amount" name="other_revenue_amount" type="hidden">
										<input value="'.$lead['other_revenue_description'].'" id="other_revenue_description" name="other_revenue_description" type="hidden">';
									}
									$calculation_details .= '
									-->
								</table>
							</div>
							<br />
						</div>
					</div>
					<br />
					<div class="row" style="margin-top: 10px;">
						<div class="col-sm-12">
							<button type="submit" class="btn btn-primary">
								<i class="fa fa-save"></i> Save
							</button>																													
						</div>
					</div>
				</div>
			</form>
		</section>											
		<?php
	}
	?>
</div>
</section>
								<section class="toggle active" id="attached_tradeins_container"> <!-- Tradeins -->
									<label>Tradeins (<?php echo count($lead_attached_tradeins); ?>)</label>
									<div class="toggle-content">
										<section class="panel">
											<?php
											$root_url = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/"; // $root_url = "http://localhost/quoteme/assets/img/"; // REMOVE THIS ON LIVE
											?>
											<div class="panel-body">									
												<div class="row">
													<div class="col-md-12">
														<div class="table-responsive">
															<table class="table table-bordered table-striped table-condensed mb-none">
																<tbody>	
																	<tr>
																		<td><b>Vehicle</b></td>
																		<td><b>Client</b></td>
																		<td><b>Valuations</b></td>
																		<td><b>Winner</b></td>
																	</tr>																
																	<?php
																	if (count($lead_attached_tradeins)==0)
																	{
																		?>
																		<tr class="norecords"><td colspan="4"><center>No records found!</center></td></tr>
																		<?php														
																	}
																	else
																	{
																		foreach ($lead_attached_tradeins AS $lead_attached_tradein)
																		{
																			if ($lead_attached_tradein['image_1']=="") { $lead_attached_tradein['image_1'] = "no_image.png"; } // $lead_attached_tradein['image_1'] = "default_car_photo.png";  // REMOVE THIS ON LIVE															
																			?>
																			<tr>
																				<td>
																					<a href="<?php echo site_url('tradein/record_final/'.$lead_attached_tradein['id_tradein']); ?>" target="_blank">
																						<?php echo strtoupper($lead_attached_tradein['tradein_make'])." ".strtoupper($lead_attached_tradein['tradein_model'])." ".strtoupper($lead_attached_tradein['tradein_variant']); ?>
																					</a>
																				</td>
																				<td><?php echo $lead_attached_tradein['first_name']." ".$lead_attached_tradein['last_name']; ?></td>
																				<td><?php echo $lead_attached_tradein['trade_valuation_count']; ?></td>
																				<td><?php echo $lead_attached_tradein['name']; ?></td>
																			</tr>													
																			<?php
																		}
																	}
																	?>
																</tbody>
															</table>
														</div>
													</div>
													<!--
													<?php
													if (count($lead_attached_tradeins)==0)
													{
														?>
														<center>No records found!</center><br />
														<?php														
													}
													else
													{
														foreach ($lead_attached_tradeins AS $lead_attached_tradein)
														{
															if ($lead_attached_tradein['image_1']=="") { $lead_attached_tradein['image_1'] = "no_image.png"; } // $lead_attached_tradein['image_1'] = "default_car_photo.png";  // REMOVE THIS ON LIVE															
															?>
															<div class="col-md-4 text-center">
																<img src="<?php echo $root_url.$lead_attached_tradein['image_1']; ?>" class="img-responsive" width="90%">
																<p>
																	<b>
																		<?php echo strtoupper($lead_attached_tradein['tradein_make'])." ".
																		strtoupper($lead_attached_tradein['tradein_model'])." ".
																		strtoupper($lead_attached_tradein['tradein_variant'])."</b>"; ?>
																	</b>
																</p>
															</div>													
															<?php
														}
													}
													?>
													-->
												</div>												
											</div>
										</section>
									</div>
								</section>
								<section class="toggle active" id="invoices_container"> <!-- Invoices -->
									<label>Invoices</label>
									<div class="toggle-content">
										<section class="panel">
											<div class="panel-body">									
												<div class="row">
													<div class="col-md-12">
														<div class="table-responsive">
															<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
																<tbody>	
																	<tr>
																		<!--<td align="center"><i class="fa fa-pencil-square-o"></i></td>-->
																		<td align="center"><i class="fa fa-trash-o"></i></td>
																		<td align="center"><i class="fa fa-file-pdf-o"></i></td>
																		<td><b>Invoice #</b></td>
																		<td><b>Name</b></td>
																		<td><b>To</b></td>
																		<td><b>Invoice Date</b></td>
																		<td><b>Due Date</b></td>
																		<td><b>Promised Date</b></td>
																		<td><b>Amount Due</b></td>
																		<td><b>Amount Paid</b></td>
																		<td><b>User</b></td>
																		<td><b>Created</b></td>
																	</tr>
																	<tr id="admin_fee_invoice">
																		<!--<td align="center"><i class="fa fa-pencil-square-o"></i></td>-->
																		<td align="center"><i class="fa fa-trash-o"></i></td>
																		<td align="center"><i class="fa fa-file-pdf-o"></i></td>
																		<td>AI_<?php echo $lead['cq_number_only']; ?></td>
																		<td>Admin Fee Invoice</td>
																		<td>Client</td>
																		<td><?php echo $lead['order_date']; ?></td>
																		<td><?php echo date('Y-m-d', strtotime($lead['order_date'] . ' +1 day')); ?></td>
																		<td></td>
																		<td>165.00</td>
																		<td></td>
																		<td><?php echo $lead['qs_name']; ?></td>
																		<td><?php echo $lead['order_date']; ?></td>
																	</tr>																	
																	<tr id="dealer_invoice">
																		<!--<td align="center"><i class="fa fa-pencil-square-o"></i></td>-->
																		<td align="center"><i class="fa fa-trash-o"></i></td>
																		<td align="center">
																			<a href="<?php echo site_url('invoice/pdf_dealer_invoice/'.$lead['id_lead']); ?>" target="_blank">
																				<i class="fa fa-file-pdf-o" data-toggle="tooltip" title="Generate PDF"></i>
																			</a>
																		</td>
																		<td>DI_<?php echo $lead['cq_number_only']; ?></td>
																		<td>Dealer Invoice</td>
																		<td>Dealer</td>
																		<td><?php echo $lead['order_date']; ?></td>
																		<td><?php echo $lead['delivery_date']; ?></td>
																		<td></td>
																		<td></td>
																		<td></td>
																		<td><?php echo $lead['qs_name']; ?></td>
																		<td><?php echo $lead['order_date']; ?></td>
																	</tr>
																	<?php
																	foreach ($lead_attached_tradeins AS $lead_attached_tradein)
																	{
																		?>
																		<tr id="wholesaler_invoice_<?php echo $lead_attached_tradein['id_tradein']; ?>">
																			<td align="center"><i class="fa fa-trash-o"></i></td>
																			<td align="center">
																				<a href="<?php echo site_url('deal/tradein_invoice_pdf/'.$lead_attached_tradein['id_tradein']); ?>" target="_blank">
																					<i class="fa fa-file-pdf-o" data-toggle="tooltip" title="Generate PDF"></i>
																				</a>
																			</td>
																			<td>WI_<?php echo $lead['cq_number_only']; ?></td>
																			<td>Wholesaler Invoice</td>
																			<td>Wholesaler</td>
																			<td><?php echo $lead['order_date']; ?></td>
																			<td><?php echo date('Y-m-d', strtotime($lead['delivery_date'] . ' -2 days')); ?></td>
																			<td></td>
																			<td></td>
																			<td></td>
																			<td><?php echo $lead['qs_name']; ?></td>
																			<td><?php echo $lead['order_date']; ?></td>
																		</tr>																		
																		<?php
																	}
																	?>
																	<?php
																	foreach ($lead_invoices AS $lead_invoice)
																	{
																		?>
																		<tr id="lead_invoice_<?php echo $lead_invoice['id_invoice']; ?>">
																			<!--
																			<td align="center">
																				<span class="ajax_button_primary edit_invoice_modal_button" data-id_lead="<?php echo $lead['id_lead']; ?>" data-id_invoice="<?php echo $lead_invoice['id_invoice']; ?>">
																					<i class="fa fa-pencil-square-o"></i>
																				</span>
																			</td>
																			-->
																			<td align="center">
																				<span class="ajax_button_primary delete_invoice_button" data-id_lead="<?php echo $lead['id_lead']; ?>" data-id_invoice="<?php echo $lead_invoice['id_invoice']; ?>">
																					<i class="fa fa-trash-o" data-toggle="tooltip" title="Delete Invoice"></i>
																				</span>
																			</td>
																			<td align="center">
																				<a href="<?php echo site_url('invoice/pdf_custom_invoice/'.$lead_invoice['id_invoice']); ?>" target="_blank">
																					<i class="fa fa-file-pdf-o" data-toggle="tooltip" title="Generate PDF"></i>
																				</a>
																			</td>
																			<td><?php echo $lead_invoice['invoice_number']; ?></td>
																			<td><?php echo $lead_invoice['invoice_name']; ?></td>
																			<td><?php echo $lead_invoice['invoice_type']; ?></td>
																			<td><?php echo $lead_invoice['invoice_date']; ?></td>
																			<td><?php echo $lead_invoice['due_date']; ?></td>
																			<td><?php echo $lead_invoice['promised_date']; ?></td>
																			<td><?php echo $lead_invoice['amount_due']; ?></td>
																			<td><?php echo $lead_invoice['amount_paid']; ?></td>
																			<td><?php echo $lead_invoice['name']; ?></td>
																			<td><?php echo date('Y-m-d', strtotime($lead_invoice['created_at'])); ?></td>
																		</tr>													
																		<?php
																	}
																	?>
																</tbody>
															</table>
															<br />
														</div>														
													</div>
												</div>	
												<br />
												<div class="row" style="margin-top: 10px;">
													<div class="col-sm-12">
														<span class="btn btn-primary ajax_button add_invoice_modal_button" data-id_lead="<?php echo $lead['id_lead']; ?>">
															Add Invoice
														</span>																													
													</div>
												</div>												
											</div>
										</section>
									</div>
								</section>
								<section class="toggle active" id="payments_container"> <!-- Payments -->
									<label>Payments</label>
									<div class="toggle-content">
										<section class="panel">
											<div class="panel-body">									
												<div class="row">
													<div class="col-md-12">
														<div class="table-responsive">
															<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
																<tbody>	
																	<tr>
																		<td align="center"><b><i class="fa fa-pencil-square-o"></i></b></td>
																		<td align="center"><b><i class="fa fa-trash-o"></i></b></td>
																		<td align="center"><b><i class="fa fa-eye"></i></b></td>
																		<td><b>Type</b></td>
																		<td><b>Method</b></td>
																		<td><b>Credit Card</b></td>
																		<td><b>Bank</b></td>
																		<td><b>Reference</b></td>
																		<td><b>Amount</b></td>
																		<td><b>Admin Fee</b></td>
																		<td><b>Merchant Cost</b></td>
																		<td><b>Processed</b></td>
																		<td><b>Received</b></td>
																		<td><b>User</b></td>
																		<td><b>Created</b></td>
																	</tr>																
																	<?php
																	if (count($lead_payments)==0)
																	{
																		?>
																		<tr class="norecords"><td colspan="15"><center>No records found!</center></td></tr>
																		<?php														
																	}
																	else
																	{
																		foreach ($lead_payments AS $lead_payment)
																		{
																			if ($lead_payment['payment_date']=="")
																			{
																				$lead_payment['payment_date'] = "";
																			}
																			
																			if ($lead_payment['received_date']=="")
																			{
																				$lead_payment['received_date'] = "";
																			}
																			
																			if ($lead_payment['show_status']==1)
																			{
																				$show_status_action = 0;
																				$show_status_action_text = "Hide";
																				$show_status_icon = "fa fa-eye-slash";
																			}
																			else
																			{
																				$show_status_action = 1;
																				$show_status_action_text = "Show";
																				$show_status_icon = "fa fa-eye";
																			}
																			?>
																			<tr id="lead_payment_<?php echo $lead_payment['id_payment']; ?>">
																				<td align="center">
																					<span class="ajax_button_primary edit_payment_modal_button" data-id_lead="<?php echo $lead['id_lead']; ?>" data-id_payment="<?php echo $lead_payment['id_payment']; ?>">
																						<i class="fa fa-pencil-square-o" data-toggle="tooltip" title="Edit Payment"></i>
																					</span>
																				</td>
																				<td align="center">
																					<span class="ajax_button_primary delete_payment_button" data-id_lead="<?php echo $lead['id_lead']; ?>" data-id_payment="<?php echo $lead_payment['id_payment']; ?>">
																						<i class="fa fa-trash-o" data-toggle="tooltip" title="Delete Payment"></i>
																					</span>
																				</td>
																				<td align="center">
																					<span class="ajax_button_primary update_payment_show_status_button" data-id_lead="<?php echo $lead['id_lead']; ?>" data-id_payment="<?php echo $lead_payment['id_payment']; ?>" data-show_status="<?php echo $show_status_action; ?>">
																						<i class="<?php echo $show_status_icon; ?>" data-toggle="tooltip" title="<?php echo $show_status_action_text; ?>"></i>
																					</span>																					
																				</td>
																				<td><?php echo $lead_payment['payment_type']; ?></td>
																				<td><?php echo $lead_payment['method']; ?></td>
																				<td><?php echo $lead_payment['credit_card']; ?></td>
																				<td><?php echo $lead_payment['bank_account']; ?></td>
																				<td><?php echo $lead_payment['reference_number']; ?></td>
																				<td><?php echo $lead_payment['amount']; ?></td>
																				<td><?php echo $lead_payment['admin_fee']; ?></td>
																				<td><?php echo $lead_payment['merchant_cost']; ?></td>
																				<td><?php echo $lead_payment['payment_date']; ?></td>
																				<td><?php echo $lead_payment['received_date']; ?></td>
																				<td><?php echo $lead_payment['user']; ?></td>
																				<td><?php echo $lead_payment['created_at']; ?></td>
																			</tr>													
																			<?php
																		}
																	}
																	?>
																</tbody>
															</table>
															<br />
														</div>														
													</div>
												</div>		
												<br />
												<div class="row" style="margin-top: 10px;">
													<div class="col-sm-12">
														<span class="btn btn-primary ajax_button add_payment_modal_button" data-id_lead="<?php echo $lead['id_lead']; ?>">
															Add Payment
														</span>																													
													</div>
												</div>												
											</div>
										</section>
									</div>
								</section>									
								<section class="toggle active"> <!-- Emails -->
									<label>Emails (<?php echo count($lead_emails); ?>)</label>
									<div class="toggle-content">
										<section class="panel">
											<div class="panel-body">
												<ul class="simple-user-list mb-xlg">
													<?php 
													if (count($lead_emails)==0)
													{
														?>
														<li><center>No records found!</center></li>
														<?php
													}
													else
													{
														foreach ($lead_emails AS $lead_email)
														{
															$lead_email_attachments = explode(",", $lead_email['files']);
															?>
															<li>
																<span class="title">
																	<a href="mailto:<?php echo $lead_email['sender_email']; ?>"><b><?php echo $lead_email['sender_name']; ?></b></a>
																	<i class="fa fa-arrow-right" style="color: #aaa;"></i>
																	<a href="mailto:<?php echo $lead_email['recipient_email']; ?>"><b><?php echo $lead_email['recipient_name']; ?></b></a>
																</span>
																<span class="message">
																	<?php
																	echo $lead_email['subject']."<br />";
																	?>
																</span>
																<span class="message pull-right">
																	<?php echo date('d F Y (H:i)', strtotime($lead_email['received_date'])); ?>
																</span>
																<span class="message">
																	<?php
																	if (count($lead_email_attachments)>0)
																	{
																		?>
																		<br />
																		<span style="margin-bottom: 10px;"><b>Attachments:</b></span>
																		<br />
																		<?php
																		foreach ($lead_email_attachments AS $lead_email_attachment)
																		{
																			$lead_email_attachment_filename = $lead_email['id_email']."_".$lead_email_attachment;
																			?>
																			<a href="<?php echo base_url("./uploads/email_attachments/".$lead_email_attachment_filename); ?>" target="_blank">
																				<?php echo $lead_email_attachment_filename; ?>
																			</a>
																			<br />
																			<?php
																		}
																	}
																	?>																
																</span>													
																<hr class="solid mt-sm mb-lg">
															</li>														
															<?php
														}														
													}
													?>
												</ul>
											</div>
										</section>
									</div>
								</section>
							</div>
						</div>
						<div class="col-md-4">
							<?php
							if ($lead['status']==4 OR $lead['status']==5 OR $lead['status']==6 OR $lead['status']==7 OR $lead['status']==8 OR $lead['status']==9)
							{
								?>
								<section class="panel panel-featured-left panel-featured-primary"> <!-- Total Revenue -->
									<div class="panel-body">
										<div class="widget-summary widget-summary-sm">
											<div class="widget-summary-col widget-summary-col-icon">
												<div class="summary-icon bg-primary">
													<i class="fa fa-life-ring"></i>
												</div>
											</div>
											<div class="widget-summary-col">
												<div class="summary">
													<h4 class="title">Total Revenue</h4>
													<div class="info">
														<strong class="amount"><?php echo number_format($lead_calculation_details['revenue'], 2); ?></strong>
														<span class="text-primary"></span>
													</div>
												</div>
												<div class="summary-footer">
													<a class="text-muted text-uppercase"></a>
												</div>
											</div>
										</div>
									</div>
								</section>
								<section class="panel panel-featured-left panel-featured-primary"> <!-- Commissionable Gross -->
									<div class="panel-body">
										<div class="widget-summary widget-summary-sm">
											<div class="widget-summary-col widget-summary-col-icon">
												<div class="summary-icon bg-primary">
													<i class="fa fa-life-ring"></i>
												</div>
											</div>
											<div class="widget-summary-col">
												<div class="summary">
													<h4 class="title">Commissionable Gross</h4>
													<div class="info">
														<strong class="amount"><?php echo number_format($lead_calculation_details['commissionable_gross'], 2); ?></strong>
														<span class="text-primary"></span>
													</div>
												</div>
												<div class="summary-footer">
													<a class="text-muted text-uppercase"></a>
												</div>
											</div>
										</div>
									</div>
								</section>
								<?php
								if ($lead['status']==5 OR $lead['status']==6 OR $lead['status']==7 OR $lead['status']==8 OR $lead['status']==9)
								{
									?>
									<section class="panel panel-featured-left panel-featured-primary"> <!-- Client Status -->
										<div class="panel-body">
											<div class="widget-summary widget-summary-sm">
												<div class="widget-summary-col widget-summary-col-icon">
													<div class="summary-icon bg-primary">
														<i class="fa fa-life-ring"></i>
													</div>
												</div>
												<div class="widget-summary-col">
													<div class="summary">
														<h4 class="title">Client Status</h4>
														<div class="info">
															<strong class="amount"><?php echo $lead['client_status_text']; ?></strong>
															<span class="text-primary"></span>
														</div>
													</div>
													<div class="summary-footer">
														<a class="text-muted text-uppercase"></a>
													</div>
												</div>
											</div>
										</div>
									</section>	
									<section class="panel panel-featured-left panel-featured-primary"> <!-- Dealer Status -->
										<div class="panel-body">
											<div class="widget-summary widget-summary-sm">
												<div class="widget-summary-col widget-summary-col-icon">
													<div class="summary-icon bg-primary">
														<i class="fa fa-life-ring"></i>
													</div>
												</div>
												<div class="widget-summary-col">
													<div class="summary">
														<h4 class="title">Dealer Status</h4>
														<div class="info">
															<strong class="amount"><?php echo $lead['dealer_status_text']; ?></strong>
															<span class="text-primary"></span>
														</div>
													</div>
													<div class="summary-footer">
														<a class="text-muted text-uppercase"></a>
													</div>
												</div>
											</div>
										</div>
									</section>									
									<?php
								}
								?>									
								<?php
							}
							?>								
							<section class="panel"> <!-- Quick Note -->
								<header class="panel-heading">
									<div class="panel-actions">
										<a href="#" class="fa fa-caret-down"></a>
									</div>
									<h2 class="panel-title">
										<i class="fa fa-book"></i>&nbsp;
										Quick Note
									</h2>
								</header>
								<form method="post" id="quick_note_form" name="quick_note_form" action="">
									<input type="hidden" name="id_lead" value="<?php echo $lead['id_lead']; ?>" />
									<div class="panel-body">
										<textarea class="form-control input-sm" name="details"><?php echo $lead['details']; ?></textarea>
									</div>								
									<div class="panel-footer">
										<button type="submit" class="btn btn-default btn-outline">
											<i class="fa fa-save"></i> Save
										</button>										
									</div>
								</form>
							</section>						
							<section class="panel"> <!-- Suggested Trades -->
								<header class="panel-heading">
									<div class="panel-actions">
										<a href="#" class="fa fa-caret-down"></a>
									</div>
									<h2 class="panel-title">
										<i class="fa fa-car"></i>&nbsp;
										Suggested Trades (<span id="lead_suggested_tradein_count"><?php echo count($lead_suggested_tradeins); ?></span>)
									</h2>
								</header>
								<div class="panel-body">
									<?php
									if (count($lead_suggested_tradeins)==0)
									{
										echo '<span id="norecords"><center>No records found!</center></span>';
									}
									else
									{
										foreach ($lead_suggested_tradeins AS $lead_suggested_tradein_index => $lead_suggested_tradein)
										{
											if ($lead_suggested_tradein['image_1']=="") 
											{
												$lead_suggested_tradein['image_1'] = "no_image.png"; 
											}
											
											if ($lead_suggested_tradein_index > 0)
											{
												$hr = '<hr class="solid mt-sm mb-lg">';
											}
											else
											{
												$hr = '';
											}
											?>
											<?php echo $hr; ?>
											<div class="row">
												<div class="col-md-4">
													<img src="<?php echo $root_url.$lead_suggested_tradein['image_1']; ?>" alt="<?php echo $lead_suggested_tradein['tradein_make']." ".$lead_suggested_tradein['tradein_model']; ?>" width="100%" style="border: 1px solid #ddd; margin-top: 7px;">
												</div>
												<div class="col-md-8">
													<span class="title">
														<a href="<?php echo site_url('tradein/record_final/'.$lead_suggested_tradein['id_tradein']); ?>" target="_blank">
															<?php echo $lead_suggested_tradein['tradein_make']." ".$lead_suggested_tradein['tradein_model']; ?>
														</a>
														<br />
													</span>
													<span class="message">
														<?php echo $lead_suggested_tradein['first_name']." ".$lead_suggested_tradein['last_name']; ?>
													</span>
													<br />
													<?php
													if ($lead_suggested_tradein['fk_lead'] == $lead['id_lead'])
													{
														?>
														<span class="btn btn-primary btn-sm unattach_trade_button" style="cursor: pointer; cursor: hand; margin-top: 5px;" data-id_lead="<?php echo $lead['id_lead']; ?>" data-id_tradein="<?php echo $lead_suggested_tradein['id_tradein']; ?>">
															Unattach
														</span>														
														<?php
													}
													else if ($lead_suggested_tradein['fk_lead'] <> $lead['id_lead'] AND $lead_suggested_tradein['fk_lead'] <> 0)
													{
														?>
														<p>Unavailable</p>
														<?php
													}
													else
													{
														?>
														<span class="btn btn-primary btn-sm attach_trade_button" style="cursor: pointer; cursor: hand; margin-top: 5px;" data-id_lead="<?php echo $lead['id_lead']; ?>" data-id_tradein="<?php echo $lead_suggested_tradein['id_tradein']; ?>">
															Attach
														</span>														
														<?php
													}
													?>

												</div>
											</div>
											<?php
										}
									}									
									?>
								</div>
							</section>
							<section class="panel" id="lead_files_section"> <!-- Files -->
								<header class="panel-heading">
									<div class="panel-actions">
										<a href="#" class="fa fa-caret-down"></a>
									</div>
									<h2 class="panel-title">
										<i class="fa fa-file"></i>&nbsp;
										Files (<span id="lead_file_count"><?php echo count($lead_files); ?></span>)
									</h2>
								</header>
								<div class="panel-body">
									<?php
									if (count($lead_files)==0)
									{
										echo "<center>No records found!</center>";
									}
									else
									{
										foreach ($lead_files AS $lead_file)
										{
											if (strlen($lead_file['file_name'] > 32))
											{
												$el = "..";
											}
											else
											{
												$el = "";
											}
											?>
											<p><a href="<?php echo base_url('uploads/cq_files/'.$lead_file['file_name']);?>" target="_blank"><?php echo substr($lead_file['file_name'], 0, 32).$el; ?></a></p>
											<?php
										}
									}
									?>
								</div>
								<div class="panel-footer">
									<span class="btn btn-default btn-sm add_lead_files_modal_button" style="cursor: pointer; cursor: hand;">
										Upload File
									</span>
								</div>
							</section>
							<section class="panel"> <!-- Call Logs -->
								<header class="panel-heading">
									<div class="panel-actions">
										<a href="#" class="fa fa-caret-down"></a>
									</div>
									<h2 class="panel-title">
										<i class="fa fa-phone"></i>&nbsp;
										Call Logs (<span id="lead_call_log_count"><?php echo count($lead_call_logs); ?></span>)
									</h2>
								</header>
								<div class="panel-body">
									<?php
									if (count($lead_call_logs)==0)
									{
										echo '<span id="norecords"><center>No records found!</center></span>';
									}
									else
									{
										foreach ($lead_call_logs AS $lead_call_log_index => $lead_call_log)
										{
											if ($lead_call_log_index > 0)
											{
												$hr = '<hr class="solid mt-sm mb-lg">';
											}
											else
											{
												$hr = '';
											}											
											?>
											<?php echo $hr; ?>
											<p>
												<?php echo $lead_call_log['user']; ?><br />
												<b><?php echo $lead_call_log['call_status']; ?></b><br />
												<i><?php echo $lead_call_log['details']; ?></i><br />
												<span style="font-size: 0.8em;"><?php echo date('d F Y (H:i)', strtotime($lead_call_log['created_at'])); ?></span>
											</p>
											<?php
										}
									}
									?>
								</div>							
							</section>								
						</div>
					</div>
					<?php include 'modals/ticket_modals.php'; ?>
					<?php include 'template/modals.php'; ?>	
					<!-- Move Out (Start) -->
					<div id="call_modal" class="modal fade"> <!-- Call Modal -->
						<div class="modal-dialog" style="width: 80%;">
							<section class="panel">
								<form method="post" id="call_form" name="call_form" action="">
									<input type="hidden" id="id_lead" name="id_lead" value="<?php echo $lead['id_lead']; ?>">
									<div class="panel-body">
										<div class="modal-wrapper">
											<div class="modal-text">
												<div class="row">
													<div class="col-md-12 text-center">
														<h4 id="label_name" style="line-height: 1px;"></h4>
														<p id="label_email" style="color: #cccccc; font-size: 0.9em;"></p>
														<hr class="solid mt-sm mb-lg">							
													</div>
												</div>
												<div class="row">
													<div class="col-md-6 text-center">
														<a href="" id="phone_button">
															<p><span id="phone_text"></span></p>
														</a>
													</div>							
													<div class="col-md-6 text-center">
														<a href="" id="mobile_button">
															<p><span id="mobile_text"></span></p>
														</a>
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label">Call Status:</label>
															<select class="form-control" name="fk_call_status">
																<option value=""></option>
																<?php
																foreach ($lead_call_status AS $call_status)
																{
																	?>			
																	<option value="<?php echo $call_status['id_call_status']; ?>">
																		<?php echo $call_status['name']; ?>
																	</option>
																	<?php
																}
																?>									
															</select>
														</div>
													</div>
												</div>
												<div class="row" style="margin-top: 10px;">													
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label">Details:</label>							
															<textarea class="form-control" name="details"></textarea>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel-footer">
										<button type="submit" class="btn btn-primary">
											<i class="fa fa-save"></i> Save
										</button>
										<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
											Cancel
										</button>
									</div>
								</form>
							</section>
						</div>
					</div>
					<div id="sms_modal" class="modal fade"> <!-- SMS Modal -->
						<div class="modal-dialog" style="width: 80%;">
							<section class="panel">
								<form method="post" id="sms_form" name="sms_form" action="">
									<input type="hidden" id="id_lead" name="id_lead" value="<?php echo $lead['id_lead']; ?>">
									<input type="hidden" id="mobile">
									<div class="panel-body">
										<div class="modal-wrapper">
											<div class="modal-text">
												<div class="row">
													<div class="col-md-12 text-center">
														<h4 id="label_name" style="line-height: 1px;"></h4>
														<p id="label_email" style="color: #cccccc; font-size: 0.9em;"></p>
														<hr class="solid mt-sm mb-lg">							
													</div>
												</div>
												<div class="row" style="margin-top: 10px;">													
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label">Message:</label>							
															<textarea class="form-control" name="message"></textarea>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel-footer">
										<button type="submit" class="btn btn-primary">
											<i class="fa fa-save"></i> Send
										</button>
										<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
											Cancel
										</button>
									</div>
								</form>
							</section>
						</div>
					</div>
					<div id="not_proceeding_modal" class="modal fade"> <!-- Not Proceeding Modal -->
						<div class="modal-dialog" style="width: 80%;">
							<section class="panel">
								<form method="post" id="not_proceeding_form" name="not_proceeding_form" action="">
									<input type="hidden" id="id_lead" name="id_lead" value="<?php echo $lead['id_lead']; ?>">
									<input type="hidden" id="status" name="status" value="100">
									<div class="panel-body">
										<div class="modal-wrapper">
											<div class="modal-text">
												<div class="row">
													<div class="col-md-12 text-center">
														<h4 id="label_name" style="line-height: 1px;"></h4>
														<p id="label_email" style="color: #cccccc; font-size: 0.9em;"></p>
														<hr class="solid mt-sm mb-lg">							
													</div>
												</div>											
												<div class="row">													
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label">Please indicate the reason why the client is not proceeding:</label>							
															<textarea class="form-control" name="detele_reason"></textarea>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel-footer">
										<button type="submit" class="btn btn-primary">
											<i class="fa fa-save"></i> Save
										</button>
										<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
											Cancel
										</button>
									</div>
								</form>
							</section>
						</div>
					</div>
					<!-- Move Out (End) -->

					<div id="send_email_modal" class="modal fade"> <!-- Send Email Modal -->
						<div class="modal-dialog" style="width: 80%;">
							<section class="panel">
								<form method="post" id="send_email_form" name="send_email_form" action="">
									<input type="hidden" id="id_lead" name="id_lead" value="<?php echo $lead['id_lead']; ?>">
									<input type="hidden" id="email" name="email" value="<?php echo $lead['email']; ?>">
									<div class="panel-body">
										<div class="modal-wrapper">
											<div class="modal-text">
												<div class="row">
													<div class="col-md-12 text-center">
														<h4 id="label_name" style="line-height: 1px;"></h4>
														<p id="label_email" style="color: #cccccc; font-size: 0.9em;"></p>
														<hr class="solid mt-sm mb-lg">							
													</div>
												</div>
												<div class="row" style="margin-top: 10px;">
													<div class="col-md-12">
														<div class="container_bordered_round">
															<div class="row">
																<div class="col-md-12">
																	<h5>Recipient:</h5>
																	<div class="row" style="margin-top: 10px;">
																		<div class="col-md-4">																
																			<div class="form-group">
																				<select class="form-control" id="recipient_type" name="recipient_type" type="text">
																					<option value=""></option>
																					<option value="Client">Client</option>
																					<option value="Dealer">Dealer</option>
																				</select>
																			</div>
																		</div>
																		<div class="col-md-8">																
																			<div class="form-group">
																				<input class="form-control" id="recipient_email" name="recipient_email" type="text" placeholder="Email Address">
																			</div>
																		</div>																		
																	</div>
																</div>
															</div>														
															<div class="row" style="margin-top: 10px;">
																<div class="col-md-12">
																	<div class="form-group">
																		<label class="control-label">Subject:</label>
																		<input type="text" value="" class="form-control" id="subject" name="subject">
																	</div>
																</div>
															</div>
															<div class="row" style="margin-top: 10px;">													
																<div class="col-md-12">
																	<div class="form-group">
																		<label class="control-label">Message:</label>							
																		<textarea class="form-control" id="message" name="message" rows="8"></textarea>
																	</div>
																</div>
															</div>
															<div class="row" style="margin-top: 30px;">													
																<div class="col-md-12">
																	<div class="form-group">
																		<label class="control-label">Attachments:</label><br />
																		<input type="checkbox" name="purchase_order_attachment_flag" id="purchase_order_attachment_flag"> Purchase Order PDF <br />
																		<input type="checkbox" name="order_package_attachment_flag" id="order_package_attachment_flag"> Order Package PDF <br />
																		<?php 
																		if ($admin_type==2)
																		{
																			?>
																			<input type="checkbox" name="dealer_invoice_attachment_flag" id="dealer_invoice_attachment_flag"> Dealer Invoice PDF <br />
																			<?php
																		}
																		else
																		{
																			?>
																			<input type="hidden" name="dealer_invoice_attachment_flag" id="dealer_invoice_attachment_flag">
																			<?php
																		}
																		?>
																	</div>
																</div>
															</div>															
															<div class="row" style="margin-top: 30px;">													
																<div class="col-md-12">
																	<div class="form-group">
																		<label class="control-label">Other Attachments:</label>	
																		<div class="dropzone email_attachments" style="min-height: 160px;"></div>
																	</div>
																</div>
															</div>	
															<div hidden="hidden" id="hidden_images"></div>															
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel-footer">
										<button type="submit" class="btn btn-primary">
											Send
										</button>
										<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
											Cancel
										</button>
									</div>
								</form>
							</section>
						</div>
					</div>
					<div id="add_lead_files_modal" class="modal fade"> <!-- Upload Lead File Modal -->
						<div class="modal-dialog" style="width: 80%;">
							<section class="panel">
								<form method="post" id="add_lead_files_form" name="add_lead_files_form" action="">
									<input type="hidden" id="id_lead" name="id_lead" value="<?php echo $lead['id_lead']; ?>">
									<div class="panel-body">
										<div class="modal-wrapper">
											<div class="modal-text">
												<div class="row">
													<div class="col-md-12 text-center">
														<h4 id="label_name" style="line-height: 1px;"></h4>
														<p id="label_email" style="color: #cccccc; font-size: 0.9em;"></p>
														<hr class="solid mt-sm mb-lg">							
													</div>
												</div>
												<div class="row" style="margin-top: 10px;">
													<div class="col-md-12">
														<div class="form-group">
															<div class="dropzone lead_files" style="min-height: 160px;"></div>
														</div>
														<div hidden="hidden" id="hidden_images"></div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel-footer">
										<button type="submit" class="btn btn-primary">
											Save
										</button>
										<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
											Cancel
										</button>
									</div>
								</form>
							</section>
						</div>
					</div>
					<div id="event_modal" class="modal fade"> <!-- Event Modal -->
						<div class="modal-dialog" style="width: 80%;">
							<section class="panel">
								<form method="post" id="event_form" name="event_form" action="">
									<input type="hidden" id="id_lead" name="id_lead" value="<?php echo $lead['id_lead']; ?>">
									<input type="hidden" id="id_lead_event" name="id_lead_event" value="">
									<div class="panel-body">
										<div class="modal-wrapper">
											<div class="modal-text">
												<div class="row">
													<div class="col-md-12 text-center">
														<h4 id="label_name" style="line-height: 1px;"></h4>
														<p id="label_email" style="color: #cccccc; font-size: 0.9em;"></p>
														<hr class="solid mt-sm mb-lg">							
													</div>
												</div>
												<div class="row" style="margin-top: 10px;">													
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label">Date:</label>	
															<input value="" class="form-control datepicker" data-date-format="yyyy-mm-dd" id="date" name="date" type="text">
														</div>
													</div>
												</div>
												<div class="row" style="margin-top: 10px;">													
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label">Time:</label>	
															<input value="09:00" class="form-control" id="time" name="time" type="text" readonly="readonly">
														</div>
													</div>
												</div>												
												<div class="row" style="margin-top: 10px;">													
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label">Details:</label>							
															<input type="text" class="form-control" id="details" name="details">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel-footer text-right">
										<button type="submit" class="btn btn-primary">
											<i class="fa fa-save"></i> Save
										</button>
										<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
											Cancel
										</button>
									</div>
								</form>
							</section>
						</div>
					</div>					
					<div id="aftersales_accessories_modal" class="modal fade"> <!-- Aftersales Accessories Modal -->
						<div class="modal-dialog" style="width: 95%;">
							<section class="panel">
								<form method="post" id="aftersales_accessories_form" name="aftersales_accessories_form" action="">
									<input type="hidden" id="id_lead" name="id_lead" value="<?php echo $lead['id_lead']; ?>">
									<div class="panel-body">
										<div class="modal-wrapper">
											<div class="modal-text">
												<div class="row">
													<div class="col-md-12 text-center">
														<h4 id="label_name" style="line-height: 1px;"></h4>
														<p id="label_email" style="color: #cccccc; font-size: 0.9em;"></p>
														<hr class="solid mt-sm mb-lg">
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div id="aftersales_accessories_container">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel-footer">
										<button type="submit" class="btn btn-primary">
											<i class="fa fa-save"></i> Submit
										</button>
										<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
											Cancel
										</button>
									</div>									
								</form>
							</section>
						</div>
					</div>
					<div id="cancel_deal_modal" class="modal fade"> <!-- Cancel Deal Modal -->
						<div class="modal-dialog" style="width: 80%;">
							<section class="panel">
								<form method="post" id="cancel_deal_form" name="cancel_deal_form" action="">
									<input type="hidden" id="id_lead" name="id_lead" value="<?php echo $lead['id_lead']; ?>">
									<input type="hidden" id="status" name="status" value="9">
									<div class="panel-body">
										<div class="modal-wrapper">
											<div class="modal-text">
												<div class="row">
													<div class="col-md-12 text-center">
														<h4 id="label_name" style="line-height: 1px;"></h4>
														<p id="label_email" style="color: #cccccc; font-size: 0.9em;"></p>
														<hr class="solid mt-sm mb-lg">							
													</div>
												</div>											
												<div class="row">													
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label">Please indicate the reason why the deal is being cancelled:</label>							
															<textarea class="form-control" name="deal_cancel_reason"></textarea>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel-footer">
										<button type="submit" class="btn btn-primary">
											<i class="fa fa-save"></i> Save
										</button>
										<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
											Cancel
										</button>
									</div>
								</form>
							</section>
						</div>
					</div>					
					<div id="start_tender_modal" class="modal fade"> <!-- Start Tender Modal -->
						<div class="modal-dialog" style="width: 95%;">
							<section class="panel">
								<form method="post" action="" id="start_tender_form" name="start_tender_form">
									<input type="hidden" id="id_lead" name="id_lead" value="<?php echo $lead['id_lead']; ?>">
									<input type="hidden" id="dealer_ids_inp" name="dealer_ids" value="0">
									<div class="panel-body">
										<div class="modal-wrapper">
											<div class="modal-text">
												<div class="row">
													<div class="col-md-12 text-center">
														<h4 id="label_name" style="line-height: 1px;"></h4>
														<p id="label_email" style="color: #cccccc; font-size: 0.9em;"></p>
														<hr class="solid mt-sm mb-lg">							
													</div>
												</div>
												<div class="row"> <!-- Dealer Selector -->
													<div class="col-md-12">
														<div class="container_bordered_round">
															<div class="row">
																<div class="col-md-4">
																	<select class="form-control input-sm" id="make_ds" type="text" onChange="load_suggested_dealers('start_tender_modal')">
																		<option value=""></option>
																		<?php 
																		foreach ($makes as $make)
																		{
																			?>
																			<option value="<?php echo $make->name; ?>"><?php echo $make->name; ?></option>
																			<?php
																		}
																		?>
																	</select>
																	<br />
																</div>
																<div class="col-md-4">
																	<select class="form-control input-sm" id="state_ds" type="text" onChange="load_suggested_dealers('start_tender_modal')">
																		<option value="">Select State</option>
																		<option value="ACT">Australian Capital Territory</option>
																		<option value="NSW">New South Wales</option>
																		<option value="NT">Northern Territory</option>
																		<option value="QLD">Queensland</option>
																		<option value="SA">South Australia</option>
																		<option value="TAS">Tasmania</option>
																		<option value="VIC">Victoria</option>
																		<option value="WA">Western Australia</option>
																	</select>
																	<br />
																</div>
																<div class="col-md-4">
																	<input class="form-control input-sm" id="postcode_ds" type="text" value="" placeholder="Postcode" onChange="load_suggested_dealers('start_tender_modal')"><br />
																</div>
																<div class="col-md-12" id="suggested_dealers"></div>
																<div class="col-md-12">
																	<br />
																	<table class="table table-bordered table-striped table-condensed mb-none">
																		<thead>
																			<tr><td><b>SELECTED DEALERS</b></td><td></td></tr>
																		</thead>
																		<tbody id="selected_dealers">
																			<tr class="norecord"><td colspan="2"><center>No dealer is selected!</center></td></tr>
																		</tbody>																		
																	</table>
																</div>																															
															</div>
														</div>
													</div>
												</div>
												<div class="row" style="margin-top: 20px;"> <!-- Tender Details -->
													<div class="col-md-4">
														<div class="container_bordered_round">
															<div class="form-group">
																<label><font color="red">*</font> Registration Type:</label>
																<select class="form-control input-md" id="registration_type" name="registration_type" type="text">
																	<option value=""></option>
																	<option value="Business">Business</option>
																	<option value="Private">Private</option>
																	<option value="Pensioner">Pensioner</option>
																	<option value="Exempt">Exempt</option>
																	<option value="TPI/Gold Card">TPI/Gold Card</option>
																</select>
															</div>												
														</div>
														<br />
														<div class="container_bordered_round">
															<div class="form-group">
																<label><font color="red">*</font> Make:</label>
																<select class="form-control input-sm" id="make" name="make" onChange="load_families('start_tender_modal', this.options[this.selectedIndex].value)">
																	<option value="0"></option>
																	<?php 
																	foreach ($makes as $make)
																	{
																		?>
																		<option value="<?php echo $make->id_make; ?>"><?php echo $make->name; ?></option>
																		<?php
																	}
																	?>
																</select>
															</div>
															<div class="form-group">
																<label><font color="red">*</font> Model:</label>
																<select class="form-control input-sm" id="family" name="family" onChange="load_build_dates('start_tender_modal', this.options[this.selectedIndex].value)" disabled>
																	<option value="">
																		<span class="loader"></span>
																	</option>
																</select>
															</div>
															<div class="form-group">
																<label><font color="red">*</font> Build Date:</label>
																<select class="form-control input-sm" id="build_date" name="build_date" onChange="load_vehicles('start_tender_modal', this.options[this.selectedIndex].value)" disabled>
																	<option value="">
																		<span class="loader"></span>
																	</option>
																</select>
															</div>													
															<div class="form-group">
																<label><font color="red">*</font> Variant:</label>
																<select class="form-control input-sm" id="vehicle" name="vehicle" onChange="load_options('start_tender_modal', this.options[this.selectedIndex].value)" disabled>
																	<option value="">
																		<span class="loader"></span>
																	</option>
																</select>
															</div>
															<div class="form-group">
																<label><font color="red">*</font> Colour:</label>
																<input value="" class="form-control input-sm" id="colour" name="colour" type="text"><br />
															</div>
														</div>
														<br />
													</div>
													<div class="col-md-8">
														<div class="container_bordered_round">
															<label>Options:</label><br />
															<div class="row">
																<div id="options"></div>
															</div>
														</div>
														<br />
														<div class="container_bordered_round">															
															<label>Accessories:</label><br />
															<div id="accessory_container">
																<input class="form-control input-md" name="accessory_name[]" type="text" placeholder="Accessory"><br />
																<textarea class="form-control" name="accessory_desc[]" id="textareaDefault" placeholder="Description"></textarea>
															</div>
															<div class="row">										
																<div class="col-md-12">
																	<br />
																	<span class="btn btn-default btn-sm ajax_button add_accessory_button" data-container="start_tender_modal">
																		Add Accessory
																	</span>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel-footer text-right"> <!-- Actions -->
										<button type="submit" class="btn btn-primary">
											Start
										</button>
										<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
											Cancel
										</button>
									</div>
								</form>
							</section>					
						</div>
					</div>
					<div id="edit_tender_modal" class="modal fade"> <!-- Edit Tender Modal -->
						<div class="modal-dialog" style="width: 95%;">
							<section class="panel">
								<form method="post" action="" id="edit_tender_form" name="edit_tender_form">
									<input type="hidden" id="id_lead" name="id_lead" value="<?php echo $lead['id_lead']; ?>">
									<input type="hidden" id="id_quote_request" name="id_quote_request">
									<div class="panel-body">
										<div class="modal-wrapper">
											<div class="modal-text">
												<div class="row">
													<div class="col-md-12 text-center">
														<h4 id="label_name" style="line-height: 1px;"></h4>
														<p id="label_email" style="color: #cccccc; font-size: 0.9em;"></p>
														<hr class="solid mt-sm mb-lg">							
													</div>
												</div>											
												<div class="row">
													<div class="col-md-4">
														<div style="padding: 20px; border: 1px solid #ddd;">
															<div class="form-group">
																<label><font color="red">*</font> Registration Type:</label>
																<select class="form-control input-md" id="registration_type" name="registration_type" type="text">
																	<option value=""></option>
																	<option value="Business">Business</option>
																	<option value="Private">Private</option>
																	<option value="Pensioner">Pensioner</option>
																	<option value="Exempt">Exempt</option>
																	<option value="TPI/Gold Card">TPI/Gold Card</option>
																</select>
															</div>												
														</div>										
														<br />
														<div style="padding: 20px; border: 1px solid #ddd;">	
															<div class="form-group">
																<label><font color="red">*</font> Make:</label>
																<select class="form-control" id="make" name="make" onChange="load_families('edit_tender_modal', this.options[this.selectedIndex].value, 0)" required>
																	<option value="0"></option>
																</select>
															</div>
															<div class="form-group">
																<label><font color="red">*</font> Model:</label>
																<select class="form-control" id="family" name="family" onChange="load_build_dates('edit_tender_modal', this.options[this.selectedIndex].value, 0)">
																	<option value="0"></option>
																</select>
															</div>															
															<div class="form-group">
																<label><font color="red">*</font> Build Date:</label>
																<select class="form-control" id="build_date" name="build_date" onChange="load_vehicles('edit_tender_modal', this.options[this.selectedIndex].value, 0)">
																	<option name="build_date" value="0"></option>
																</select>
															</div>
															<div class="form-group">
																<label><font color="red">*</font> Variant:</label>
																<select class="form-control" id="vehicle" name="vehicle" onChange="load_options('edit_tender_modal', this.options[this.selectedIndex].value, 0)">
																	<option name="vehicle" value="0"></option>
																</select>																
															</div>
															<div class="form-group">
																<label><font color="red">*</font> Colour:</label>
																<input value="" class="form-control input-md" id="colour" name="colour" type="text">																
															</div>
														</div>
														<br />
													</div>
													<div class="col-md-8">
														<div style="padding: 20px; border: 1px solid #ddd;">
															<label>Options:</label><br />
															<div class="row">
																<div id="options"></div>
															</div>
														</div>
														<br />
														<div style="padding: 20px; border: 1px solid #ddd;">															
															<label>Accessories:</label><br />
															<div id="accessory_container">

															</div>
															<div class="row">																
																<div class="col-md-12">
																	<br />
																	<span class="btn btn-default btn-sm ajax_button add_accessory_button" data-container="edit_tender_modal">
																		Add Accessory
																	</span>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel-footer text-right">
										<button type="submit" class="btn btn-primary">
											Save
										</button>
										<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
											Cancel
										</button>
									</div>									
								</form>
							</section>					
						</div>
					</div>
					<div id="add_dealers_modal" class="modal fade"> <!-- Add Dealers Modal -->
						<div class="modal-dialog" style="width: 95%;">
							<section class="panel">
								<form method="post" action="" id="add_dealers_form" name="add_dealers_form">
									<input type="hidden" id="id_lead" name="id_lead" value="<?php echo $lead['id_lead']; ?>">
									<input type="hidden" id="id_quote_request" name="id_quote_request">
									<input type="hidden" id="dealer_ids_inp" name="dealer_ids" value="0">
									<div class="panel-body">
										<div class="modal-wrapper">
											<div class="modal-text">
												<div class="row">
													<div class="col-md-12 text-center">
														<h4 id="label_name" style="line-height: 1px;"></h4>
														<p id="label_email" style="color: #cccccc; font-size: 0.9em;"></p>
														<hr class="solid mt-sm mb-lg">							
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div style="padding: 20px; border: 1px solid #ddd;">
															<div class="row">
																<div class="col-md-4">
																	<select class="form-control input-md" id="make_ds" type="text" onChange="load_suggested_dealers('add_dealers_modal')">
																		<option name="make" value=""></option>
																		<?php
																		foreach ($makes as $make)
																		{
																			?>
																			<option value="<?php echo $make->name; ?>"><?php echo $make->name; ?></option>
																			<?php
																		}
																		?>
																	</select>											
																	<br />
																</div>
																<div class="col-md-4">
																	<select class="form-control input-md" id="state_ds" type="text" onChange="load_suggested_dealers('add_dealers_modal')">
																		<option value="">Select State</option>
																		<option value="ACT">Australian Capital Territory</option>
																		<option value="NSW">New South Wales</option>
																		<option value="NT">Northern Territory</option>
																		<option value="QLD">Queensland</option>
																		<option value="SA">South Australia</option>
																		<option value="TAS">Tasmania</option>
																		<option value="VIC">Victoria</option>
																		<option value="WA">Western Australia</option>
																	</select>
																</div>
																<div class="col-md-4">
																	<input class="form-control input-md" id="postcode_ds" type="text" value="" placeholder="Postcode" onChange="load_suggested_dealers('add_dealers_modal')"><br />
																</div>
																<div class="col-md-12" id="suggested_dealers"></div>
																<div class="col-md-12">
																	<br />
																	<table class="table table-bordered table-striped table-condensed mb-none">
																		<thead>
																			<tr><td><b>SELECTED DEALERS</b></td><td></td></tr>
																		</thead>
																		<tbody id="selected_dealers">
																			<tr class="norecord"><td colspan="2"><center>No dealer is selected!</center></td></tr>
																		</tbody>																		
																	</table>
																</div>															
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel-footer text-right">
										<button type="submit" class="btn btn-primary">
											Submit
										</button>
										<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
											Cancel
										</button>
									</div>									
								</form>
							</section>					
						</div>
					</div>
					<div id="email_invite_modal" class="modal fade"> <!-- Email Invite Modal -->
						<div class="modal-dialog" style="width: 95%;">
							<section class="panel">
								<form method="post" action="" id="email_invite_form" name="email_invite_form">
									<input type="hidden" id="id_lead" name="id_lead" value="<?php echo $lead['id_lead']; ?>">
									<input type="hidden" id="id_quote_request" name="id_quote_request">
									<div class="panel-body">
										<div class="modal-wrapper">
											<div class="modal-text">
												<div class="row">
													<div class="col-md-12 text-center">
														<h4 id="label_name" style="line-height: 1px;"></h4>
														<p id="label_email" style="color: #cccccc; font-size: 0.9em;"></p>
														<hr class="solid mt-sm mb-lg">							
													</div>
												</div>				
												<div class="row" style="margin-top: 10px;">													
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label">Email Address:</label>							
															<input type="text" class="form-control" name="email">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel-footer text-right">
										<button type="submit" class="btn btn-primary">
											Start
										</button>
										<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
											Cancel
										</button>
									</div>									
								</form>
							</section>					
						</div>
					</div>
					<div id="add_invoice_modal" class="modal fade"> <!-- Add Custom Invoice Modal -->
						<div class="modal-dialog" style="width: 95%;">
							<section class="panel">
								<form method="post" action="" id="add_invoice_form" name="add_invoice_form">
									<input type="hidden" id="id_lead" name="id_lead" value="<?php echo $lead['id_lead']; ?>">
									<div class="panel-body">
										<div class="modal-wrapper">
											<div class="modal-text">
												<div class="row">
													<div class="col-md-12 text-center">
														<h4 id="label_name" style="line-height: 1px;"></h4>
														<p id="label_email" style="color: #cccccc; font-size: 0.9em;"></p>
														<hr class="solid mt-sm mb-lg">							
													</div>
												</div>
												<div class="row">													
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label">Description:</label>							
															<textarea type="text" class="form-control" name="details"></textarea>
														</div>
													</div>
												</div>												
												<div class="row" style="margin-top: 10px;">													
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label">Remarks to the Recipient:</label>							
															<textarea type="text" class="form-control" name="remarks"></textarea>
														</div>
													</div>
												</div>			
												<div class="row" style="margin-top: 70px;">
													<div class="col-md-12">
														<h5><b>Invoice Items</b></h5>
													</div>
												</div>
												<div class="row" style="margin-top: 15px;">													
													<div class="col-md-12">
														<div id="invoice_items_container">
															<div style="padding: 15px; border: 1px solid #ddd;">
																<div class="row">													
																	<div class="col-md-6">
																		<div class="form-group">
																			<label class="control-label">Amount:</label>							
																			<input type="text" class="form-control" name="invoice_item_amount[]" onKeyPress="return isNumberKey(event)">
																		</div>
																	</div>
																</div>
																<div class="row" style="margin-top: 10px;">													
																	<div class="col-md-12">
																		<div class="form-group">
																			<label class="control-label">Item Description:</label>
																			<textarea type="text" class="form-control" name="invoice_item_description[]"></textarea>
																		</div>
																	</div>
																</div>																
															</div>															
														</div>
													</div>
												</div>
												<div class="row">																
													<div class="col-md-12">
														<br />
														<span class="btn btn-default btn-sm add_invoice_item_button" style="cursor: pointer; cursor: hand;" data-container="add_invoice_form">
															Add Item
														</span>
													</div>
												</div>												
											</div>
										</div>
									</div>
									<div class="panel-footer text-right">
										<button type="submit" class="btn btn-primary">
											Submit
										</button>
										<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
											Cancel
										</button>
									</div>									
								</form>
							</section>					
						</div>
					</div>		
					<div id="add_payment_modal" class="modal fade"> <!-- Add Payment Modal -->
						<div class="modal-dialog" style="width: 95%;">
							<section class="panel">
								<form method="post" action="" id="add_payment_form" name="add_payment_form">
									<input type="hidden" id="id_lead" name="id_lead" value="<?php echo $lead['id_lead']; ?>">
									<div class="panel-body">
										<div class="modal-wrapper">
											<div class="modal-text">
												<div class="row">
													<div class="col-md-12 text-center">
														<h4 id="label_name" style="line-height: 1px;"></h4>
														<p id="label_email" style="color: #cccccc; font-size: 0.9em;"></p>
														<hr class="solid mt-sm mb-lg">							
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div style="padding: 20px; border: 1px solid #ddd;">
															<div class="row">
																<div class="col-md-4">
																	<div class="form-group">
																		<label class="control-label">Payment Type:</label>
																		<select class="form-control" name="fk_payment_type" type="text">
																			<option value=""></option>
																			<?php
																			foreach ($payment_types as $payment_type)
																			{
																				?>
																				<option data-sign="<?php echo $payment_type->sign; ?>" value="<?php echo $payment_type->id_payment_type; ?>">
																					<?php echo $payment_type->description; ?>
																				</option>
																				<?php
																			}
																			?>
																		</select>
																	</div>
																</div>																
																<div class="col-md-4">
																	<div class="form-group">
																		<label class="control-label">Reference Number:</label>
																		<input type="text" class="form-control" name="reference_number">
																	</div>
																</div>														
																<div class="col-md-4">
																	<div class="form-group">
																		<label class="control-label">Payment Date:</label>
																		<input type="text" class="form-control datepicker" data-date-format="yyyy-mm-dd" name="payment_date" value="<?php echo date("Y-m-d"); ?>">
																	</div>
																</div>																														
															</div>
														</div>
													</div>
												</div>												
												<div class="row" style="margin-top: 20px;">
													<div class="col-md-12">
														<div style="padding: 20px; border: 1px solid #ddd;">
															<div class="row">
																<div class="col-md-4">
																	<div class="form-group">
																		<label class="control-label">Amount:</label>
																		<input type="text" class="form-control" name="amount" onKeyPress="return isNumberKey(event)">
																	</div>
																</div>
																<div class="col-md-4">
																	<div class="form-group">
																		<label class="control-label">Admin Fee:</label>
																		<input type="text" class="form-control" name="admin_fee">
																	</div>
																</div>
																<div class="col-md-4">
																	<div class="form-group">
																		<label class="control-label">Merchant Cost:</label>
																		<input type="text" class="form-control" name="merchant_cost">
																	</div>
																</div>																
															</div>
														</div>
													</div>
												</div>
												<div class="row" style="margin-top: 20px;">	
													<div class="col-md-12">
														<div style="padding: 20px; border: 1px solid #ddd;">
															<div class="row">
																<div class="col-md-4">
																	<div class="form-group">
																		<label class="control-label">Method:</label>							
																		<select class="form-control" name="method" type="text">
																			<option value=""></option>
																			<option value="Bendigo">Bendigo</option>
																			<option value="Square">Square</option>
																			<option value="EFT">EFT</option>
																			<option value="Other">Other</option>
																		</select>
																	</div>
																</div>
																<div class="col-md-4">
																	<div class="form-group">
																		<label class="control-label">Credit Card:</label>							
																		<select class="form-control" name="credit_card" type="text">
																			<option value=""></option>
																			<option value="MasterCard">MasterCard</option>
																			<option value="Visa">Visa</option>
																			<option value="Amex">Amex</option>
																			<option value="Other">Other</option>
																		</select>
																	</div>
																</div>
																<div class="col-md-4">
																	<div class="form-group">
																		<label class="control-label">Bank Account:</label>							
																		<select class="form-control" name="bank_account" type="text">
																			<option value=""></option>
																			<option value="Bendigo">Bendigo</option>
																			<option value="WestPac">Westpac</option>
																		</select>
																	</div>
																</div>	
															</div>
														</div>
													</div>
												</div>	
												<div class="row" style="margin-top: 20px;">
													<div class="col-md-12">
														<div style="padding: 20px; border: 1px solid #ddd;">
															<div class="row">
																<div class="col-md-12">
																	<div class="form-group">
																		<label class="control-label">Remarks:</label>
																		<textarea type="text" class="form-control" name="remarks"></textarea>
																	</div>
																</div>																					
															</div>
														</div>
													</div>
												</div>														
											</div>
										</div>
									</div>
									<div class="panel-footer text-right">
										<button type="submit" class="btn btn-primary">
											Submit
										</button>
										<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
											Cancel
										</button>
									</div>									
								</form>
							</section>					
						</div>
					</div>
					<div id="edit_payment_modal" class="modal fade"> <!-- Edit Payment Modal -->
						<div class="modal-dialog" style="width: 95%;">
							<section class="panel">
								<form method="post" action="" id="edit_payment_form" name="edit_payment_form">
									<input type="hidden" id="id_lead" name="id_lead" value="<?php echo $lead['id_lead']; ?>">
									<input type="hidden" id="id_payment" name="id_payment" value="">
									<div class="panel-body">
										<div class="modal-wrapper">
											<div class="modal-text">
												<div class="row">
													<div class="col-md-12 text-center">
														<h4 id="label_name" style="line-height: 1px;"></h4>
														<p id="label_email" style="color: #cccccc; font-size: 0.9em;"></p>
														<hr class="solid mt-sm mb-lg">							
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div style="padding: 20px; border: 1px solid #ddd;">
															<div class="row">
																<div class="col-md-4">
																	<div class="form-group">
																		<label class="control-label">Payment Type:</label>
																		<select class="form-control" id="fk_payment_type" name="fk_payment_type" type="text">
																			<option value=""></option>
																			<?php
																			foreach ($payment_types as $payment_type)
																			{
																				?>
																				<option data-sign="<?php echo $payment_type->sign; ?>" value="<?php echo $payment_type->id_payment_type; ?>">
																					<?php echo $payment_type->description; ?>
																				</option>
																				<?php
																			}
																			?>
																		</select>
																	</div>
																</div>																
																<div class="col-md-4">
																	<div class="form-group">
																		<label class="control-label">Reference Number:</label>
																		<input type="text" class="form-control" id="reference_number" name="reference_number">
																	</div>
																</div>														
																<div class="col-md-4">
																	<div class="form-group">
																		<label class="control-label">Payment Date:</label>
																		<input type="text" class="form-control datepicker" data-date-format="yyyy-mm-dd" id="payment_date" name="payment_date">
																	</div>
																</div>																														
															</div>
														</div>
													</div>
												</div>												
												<div class="row" style="margin-top: 20px;">
													<div class="col-md-12">
														<div style="padding: 20px; border: 1px solid #ddd;">
															<div class="row">
																<div class="col-md-4">
																	<div class="form-group">
																		<label class="control-label">Amount:</label>
																		<input type="text" class="form-control" id="amount" name="amount" onKeyPress="return isNumberKey(event)">
																	</div>
																</div>
																<div class="col-md-4">
																	<div class="form-group">
																		<label class="control-label">Admin Fee:</label>
																		<input type="text" class="form-control" id="admin_fee" name="admin_fee">
																	</div>
																</div>
																<div class="col-md-4">
																	<div class="form-group">
																		<label class="control-label">Merchant Cost:</label>
																		<input type="text" class="form-control" id="merchant_cost" name="merchant_cost">
																	</div>
																</div>																
															</div>
														</div>
													</div>
												</div>
												<div class="row" style="margin-top: 20px;">	
													<div class="col-md-12">
														<div style="padding: 20px; border: 1px solid #ddd;">
															<div class="row">
																<div class="col-md-4">
																	<div class="form-group">
																		<label class="control-label">Method:</label>							
																		<select class="form-control" id="method" name="method" type="text">
																			<option value=""></option>
																			<option value="Bendigo">Bendigo</option>
																			<option value="Square">Square</option>
																			<option value="EFT">EFT</option>
																			<option value="Other">Other</option>
																		</select>
																	</div>
																</div>
																<div class="col-md-4">
																	<div class="form-group">
																		<label class="control-label">Credit Card:</label>							
																		<select class="form-control" id="credit_card" name="credit_card" type="text">
																			<option value=""></option>
																			<option value="MasterCard">MasterCard</option>
																			<option value="Visa">Visa</option>
																			<option value="Amex">Amex</option>
																			<option value="Other">Other</option>
																		</select>
																	</div>
																</div>
																<div class="col-md-4">
																	<div class="form-group">
																		<label class="control-label">Bank Account:</label>							
																		<select class="form-control" id="bank_account" name="bank_account" type="text">
																			<option value=""></option>
																			<option value="Bendigo">Bendigo</option>
																			<option value="WestPac">Westpac</option>
																		</select>
																	</div>
																</div>	
															</div>
														</div>
													</div>
												</div>	
												<div class="row" style="margin-top: 20px;">
													<div class="col-md-12">
														<div style="padding: 20px; border: 1px solid #ddd;">
															<div class="row">
																<div class="col-md-12">
																	<div class="form-group">
																		<label class="control-label">Remarks:</label>
																		<textarea type="text" class="form-control" name="remarks"></textarea>
																	</div>
																</div>																					
															</div>
														</div>
													</div>
												</div>														
											</div>
										</div>
									</div>
									<div class="panel-footer text-right">
										<button type="submit" class="btn btn-primary">
											Submit
										</button>
										<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
											Cancel
										</button>
									</div>									
								</form>
							</section>					
						</div>
					</div>			
					<div id="accountant_email_modal" class="modal fade"> <!-- Accountant Email Modal -->
						<div class="modal-dialog" style="width: 80%;">
							<section class="panel">
								<form method="post" id="accountant_email_form" name="accountant_email_form" action="">
									<input type="hidden" id="id_lead" name="id_lead" value="<?php echo $lead['id_lead']; ?>">
									<div class="panel-body">
										<div class="modal-wrapper">
											<div class="modal-text">
												<div class="row">
													<div class="col-md-12 text-center">
														<h4 id="label_name" style="line-height: 1px;"></h4>
														<p id="label_email" style="color: #cccccc; font-size: 0.9em;"></p>
														<hr class="solid mt-sm mb-lg">							
													</div>
												</div>
												<div class="row" style="margin-top: 10px;">													
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label">Template:</label>	
															<select class="form-control" id="email_template" name="email_template"></select>
															<small id="show_status" style="color: red"></small>
														</div>
													</div>
												</div>
												<div class="row" style="margin-top: 10px;">													
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label">Recipients:</label>	
															<input type="text" class="form-control" id="recipients" name="recipients">
														</div>
													</div>
												</div>												
												<div class="row" style="margin-top: 10px;">													
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label">Subject:</label>							
															<input type="text" class="form-control" id="subject" name="subject">
														</div>
													</div>
												</div>
												<div class="row" style="margin-top: 10px;">													
													<div class="col-md-12">
														<div class="form-group">
															<input type="checkbox" name="dealer_invoice_flag" id="dealer_invoice_flag">
															Exclude the dealer invoice pdf
														</div>
													</div>
												</div>
												<div class="row" style="margin-top: 10px;">													
													<div class="col-md-12">
														<div class="form-group">
															<div class="dropzone accountant_email_attachments" style="min-height: 160px;"></div>
														</div>
													</div>
												</div>
												<div class="row" style="margin-top: 10px;">													
													<div class="col-md-12">
														<div class="form-group">
															<div class="summernote" id="content" name="content" data-plugin-summernote data-plugin-options='{ "height": 240, "codemirror": { "theme": "ambiance" } }'></div>
														</div>
													</div>
												</div>												
												<div hidden="hidden" id="hidden_images"></div>
											</div>
										</div>
									</div>
									<div class="panel-footer text-right">
										<button type="submit" class="btn btn-primary">
											Send
										</button>
										<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
											Cancel
										</button>
									</div>
								</form>
							</section>
						</div>
					</div>
					<!-- end: page -->
				</section>
			</div>
			<?php include 'template/right_sidebar.php'; ?>
		</section>
		<?php include 'template/scripts.php'; ?>
		<script>
			// Move Out (Start) //
			
			// Straight Actions (Start) //
			$(".update_quote_seen_status_button").click(function(e) { // Reload //
				
				var id_lead = $(this).data("id_lead");
				var id_quote_request = $(this).data("id_quote_request");
				var id_quote = $(this).data("id_quote");
				var seen_status = $(this).data("seen_status");
				
				var data = {
					id_lead: id_lead,
					id_quote_request: id_quote_request,
					id_quote: id_quote,
					seen_status: seen_status
				};				
				
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("lead/update_quote_seen_status"); ?>",
					data: data,
					cache: false,
					success: function(response){
						if (response === "success")
						{
							swal("SUCCESS", "", "success");
							location.reload(true);
						}						
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});				
				e.preventDefault();
			});	
			// Straight Actions (End) //

			$(".call_modal_button").click(function(e) {
				var name = $("#client_details_form").find("#name").val();
				var email = $("#client_details_form").find("#email").val();
				$("#call_form").find("#label_name").html(name);
				$("#call_form").find("#label_email").html(email);
				
				var phone = $("#client_details_form").find("#phone").val();
				var mobile = $("#client_details_form").find("#mobile").val();

				$("#call_form").find("#phone_text").html(phone);
				$("#call_form").find("#mobile_text").html(mobile);
				$("#call_form").find("#phone_button").attr("href", "tel:" + phone);
				$("#call_form").find("#mobile_button").attr("href", "tel:" + mobile);				

				$("#call_modal").modal();
			});

			$("#call_form").submit(function(e) {
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('lead/add_call_log'); ?>",
					data: $("#call_form").serialize(),
					cache: false,
					success: function(response) {
						if (response === "success")
						{
							$("#call_modal").find("input,textarea,select").val("");
							$("#call_modal").modal("hide");
		
							swal("SUCCESS", "", "success");
							location.reload(true);
						}				
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});
				e.preventDefault();
			});

			$(".sms_modal_button").click(function(e) {
				
				swal("UNDER CONSTRUCTION", "This feature is under construction!", "info");
				
				/*
				var name = $("#client_details_form").find("#name").val();
				var email = $("#client_details_form").find("#email").val();	
				$("#sms_form").find("#label_name").html(name);
				$("#sms_form").find("#label_email").html(email);				
				
				var mobile = $("#client_details_form").find("#mobile").val();

				$("#sms_form").find("#mobile").html(mobile);

				$("#sms_modal").modal();
				*/
			});

			$("#sms_form").submit(function(e) {
				$("#sms_modal").find("input,textarea,select").val("");
				$("#sms_modal").modal("hide");
				
				swal("SUCCESS", "", "success");
				e.preventDefault();
			});	

			$(".not_proceeding_modal_button").click(function(e) {
				var name = $("#client_details_form").find("#name").val();
				var email = $("#client_details_form").find("#email").val();
				$("#not_proceeding_form").find("#label_name").html(name);
				$("#not_proceeding_form").find("#label_email").html(email);
				
				$("#not_proceeding_modal").modal();
			});

			$("#not_proceeding_form").submit(function(e) { // Reload //
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('lead/update_record'); ?>",
					data: $("#not_proceeding_form").serialize(),
					cache: false,
					success: function(response) {
						if (response === "success")
						{
							swal("SUCCESS", "", "success");
							location.reload(true);
						}	
						else if (response === "nochanges")
						{
							swal("", "No changes were made", "info");
						}								
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});
				e.preventDefault();
			});
			// Move Out (End) //

			function lead_compute_total_price_revenue ()
			{
				var total_price_obj = $("#aftersales_accessories_form").find(".total_price");
				var cost_obj        = $("#aftersales_accessories_form").find(".hidden_total_cost");
				var total_price     = 0.00;
				var total_cost      = 0.00;
				var total_revenue   = 0.00;

				$(total_price_obj).each(function(index, value){
					var temp_val = parseFloat($(this).val());
					total_price = total_price + temp_val;
				});

				$(cost_obj).each(function(index, value){
					var temp_val = parseFloat($(this).val());
					total_cost = total_cost + temp_val;
				});

				total_revenue = parseInt(total_price) - parseInt(total_cost);
				total_revenue = (parseFloat(total_revenue)).toFixed(2);

				$(document).find("#lead_total_deal_accessory_price").text((parseFloat(total_price)).toFixed(2));
				$(document).find("#lead_total_revenue").text(total_revenue);
			}		
			
			function calculate_revenue (container)
			{
				var membership = parseFloat(($(container).find("#membership").val() != '') ? $(container).find("#membership").val() : 0);
				var membership_lower = parseFloat(($(container).find("#membership_lower").val() != '') ? $(container).find("#membership_lower").val() : 0);

				var dqp = parseFloat(($(container).find("#dqp").val() != '') ? $(container).find("#dqp").val() : 0);
				var tradein_count = parseFloat(($(container).find("#tradein_count").val() != '') ? $(container).find("#tradein_count").val() : 0);
				var dealer_tradein_count = parseFloat(($(container).find("#dealer_tradein_count").val() != '') ? $(container).find("#dealer_tradein_count").val() : 0);
				var dealer_tradein_value = parseFloat(($(container).find("#dealer_tradein_value").val() != '') ? $(container).find("#dealer_tradein_value").val() : 0);
				var dealer_tradein_payout = parseFloat(($(container).find("#dealer_tradein_payout").val() != '') ? $(container).find("#dealer_tradein_payout").val() : 0);
				var dealer_client_refund = parseFloat(($(container).find("#dealer_client_refund").val() != '') ? $(container).find("#dealer_client_refund").val() : 0);
				var dealer_changeover = parseFloat(($(container).find("#dealer_changeover").val() != '') ? $(container).find("#dealer_changeover").val() : 0);		

				var sales_price = parseFloat(($(container).find("#sales_price").val() != '') ? $(container).find("#sales_price").val() : 0);
				var tradein_value = parseFloat(($(container).find("#real_tradein_value").val() != '') ? $(container).find("#real_tradein_value").val() : 0);
				var tradein_given = parseFloat(($(container).find("#real_tradein_given").val() != '') ? $(container).find("#real_tradein_given").val() : 0);
				var tradein_payout = parseFloat(($(container).find("#real_tradein_payout").val() != '') ? $(container).find("#real_tradein_payout").val() : 0);
				var deposits_total = parseFloat(($(container).find("#deposits_total").val() != '') ? $(container).find("#deposits_total").val() : 0);
				var refunds_total = parseFloat(($(container).find("#refunds_total").val() != '') ? $(container).find("#refunds_total").val() : 0);
				var transport_cost = parseFloat(($(container).find("#transport_cost").val() != '') ? $(container).find("#transport_cost").val() : 0);
				var other_costs_amount = parseFloat(($(container).find("#other_costs_amount").val() != '') ? $(container).find("#other_costs_amount").val() : 0);
				var other_qs_revenue_amount = parseFloat(($(container).find("#other_qs_revenue_amount").val() != '') ? $(container).find("#other_qs_revenue_amount").val() : 0);				
				var other_revenue_amount = parseFloat(($(container).find("#other_revenue_amount").val() != '') ? $(container).find("#other_revenue_amount").val() : 0);
				var aftersales_accessory_revenue = parseFloat(($(container).find("#aftersales_accessory_revenue").val() != '') ? $(container).find("#aftersales_accessory_revenue").val() : 0);

				var balance = 0;
				var price_difference = 0;
				var changeover = 0;
				var commissionable_gross = 0;
				var revenue = 0;
				var revenue_threshold = 1000;
				var final_membership = 0;

				balance = sales_price - tradein_given + tradein_payout - deposits_total + refunds_total;
				changeover = sales_price - tradein_given + tradein_payout;

				if (dealer_tradein_count >= 1)
				{
					price_difference = changeover - dealer_changeover;
					revenue = changeover - dealer_changeover - transport_cost - other_costs_amount + aftersales_accessory_revenue + other_qs_revenue_amount + other_revenue_amount;
					
					if (revenue <= revenue_threshold)
					{
						final_membership = membership_lower;
					}
					else
					{
						final_membership = membership;
					}
					commissionable_gross = ((changeover - dealer_changeover - transport_cost - other_costs_amount + aftersales_accessory_revenue + other_qs_revenue_amount - final_membership) / 11) * 10;
				}
				else
				{
					price_difference = sales_price - dqp;
					revenue = sales_price + (tradein_value - tradein_given) - dqp - transport_cost - other_costs_amount + aftersales_accessory_revenue + other_qs_revenue_amount + other_revenue_amount;
					
					if (revenue <= revenue_threshold)
					{
						final_membership = membership_lower;
					}
					else
					{
						final_membership = membership;
					}			
					commissionable_gross = ((sales_price + (tradein_value - tradein_given) - dqp - transport_cost - other_costs_amount + aftersales_accessory_revenue + other_qs_revenue_amount - final_membership) / 11) * 10;
				}

				$(container).find("#balance").val(balance.toFixed(2));
				$(container).find("#cpp").val(changeover.toFixed(2));
				$(container).find("#commissionable_gross").val(commissionable_gross.toFixed(2));
				$(container).find("#revenue").val(revenue.toFixed(2));								
			}

			function load_makes (container, make_id)
			{
				if(make_id != "" && make_id != 0)
				{
					$.ajax({
						type: "POST",
						url: "<?php echo site_url("cars/load_makes"); ?>/"+make_id,
						cache: false,
						success: function(response){
							$("#"+container).find("#make").html("<option value='0'></option>");
							$("#"+container).find("#make").append(response);
						}
					});					
				}
			}			

			function load_families (container, make_id, family_id)
			{
				if(make_id != "")
				{
					if (family_id == 0 || typeof(family_id) == "undefined")
					{
						$("#"+container).find("#build_date").html("<option value='0'></option>");
						$("#"+container).find("#build_date").prop("disabled", true);
						$("#"+container).find("#vehicle").html("<option value='0'></option>");
						$("#"+container).find("#vehicle").prop("disabled", true);
						$("#"+container).find("#option").html("");

						var data = {
							make_id: make_id
						};						
					}
					else
					{
						var data = {
							make_id: make_id,
							family_id: family_id
						};
					}

					$.ajax({
						type: "POST",
						url: "<?php echo site_url("cars/load_families"); ?>",
						cache: false,
						data: data,
						success: function(response){
							$("#"+container).find("#family").removeAttr("disabled");
							$("#"+container).find("#family").html("<option value='0'></option>");
							$("#"+container).find("#family").append(response);
						}
					});				
				}
			}			

			function load_build_dates (container, family_id, build_date)
			{
				if(family_id != "")
				{
					if (build_date == 0 || typeof(build_date) == "undefined")
					{
						$("#"+container).find("#vehicle").html("<option value='0'></option>");
						$("#"+container).find("#vehicle").prop("disabled", true);
						$("#"+container).find("#option").html("");
						
						var data = {
							family_id: family_id
						};						
					}
					else
					{
						var data = {
							family_id: family_id,
							build_date: build_date
						};						
					}

					$.ajax({
						type: "POST",
						url: "<?php echo site_url("cars/load_build_dates"); ?>",
						cache: false,
						data: data,
						success: function(response){
							$("#"+container).find("#build_date").removeAttr("disabled");
							$("#"+container).find("#build_date").html("<option value='0'></option>");
							$("#"+container).find("#build_date").append(response);
						}
					});				
				}
			}
			
			function load_vehicles (container, code, vehicle_id)
			{
				if(code != "")
				{
					if (vehicle_id == 0 || typeof(vehicle_id) == "undefined") 
					{
						$("#"+container).find("#options").html("");

						var data = {
							code: code
						};							
					}
					else
					{
						var data = {
							code: code,
							vehicle_id: vehicle_id
						};							
					}

					$.ajax({
						type: "POST",
						url: "<?php echo site_url("cars/load_vehicles"); ?>",
						cache: false,
						data: data,
						success: function(response){
							$("#"+container).find("#vehicle").removeAttr("disabled");
							$("#"+container).find("#vehicle").html("<option value='0'></option>");
							$("#"+container).find("#vehicle").append(response);
						}
					});				
				}
			}

			function load_options (container, vehicle_id, quote_request_id)
			{
				if(vehicle_id != "" )
				{
					if (quote_request_id == 0 || typeof(quote_request_id) == "undefined")
					{
						var data = {
							vehicle_id: vehicle_id
						};													
					}	
					else
					{
						var data = {
							vehicle_id: vehicle_id,
							quote_request_id: quote_request_id
						};				
					}

					$("#"+container).find("#options").html("");
					$.ajax({
						type: "POST",
						url: "<?php echo site_url('cars/load_options'); ?>",
						cache: false,
						data: data,
						success: function(response){
							$("#"+container).find("#options").append(response);
						}
					});
				}
			}

			function load_accessories (container, quote_request_id)
			{
				$("#"+container).find("#accessory_container").html("");

				var data = {
					quote_request_id: quote_request_id
				};
				
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('cars/load_accessories'); ?>",
					cache: false,
					data: data,
					success: function(response){
						$("#"+container).find("#accessory_container").append(response);
					}
				});
			}		
			
			function load_dealer_selector_parameters (container, id_lead, type)
			{
				var data = {
					id_lead: id_lead,
					type: type
				};

				$.ajax({
					type: "POST",
					url: "<?php echo site_url("lead/get_dealer_selector_parameters"); ?>",
					data: data,
					cache: false,
					dataType: "json",
					success: function(response){
						$("#"+container).find("#make_ds").val(response.make);
						$("#"+container).find("#state_ds").val(response.state);
						load_suggested_dealers(container);
					}
				});
			}

			function load_suggested_dealers (container)
			{
				var make = $("#"+container).find("#make_ds").val();
				var state = $("#"+container).find("#state_ds").val();
				var postcode = $("#"+container).find("#postcode_ds").val();
				
				var data = {
					container: container,
					make: make,
					state: state,
					postcode: postcode
				};				
				
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("lead/get_suggested_dealers"); ?>",
					data: data,
					cache: false,
					success: function(response){
						$("#"+container).find("#suggested_dealers").html("");
						$("#"+container).find("#suggested_dealers").append(response);
					}
				});
			}
			
			function select_suggested_dealer (container, id_user)
			{
				if (container == "add_quote_modal")
				{
					var username = $("#"+container).find("#dealer_"+id_user).html();
					var id_quote_request = $("#"+container).find("#id_quote_request").val();
					var demo = $("#"+container).find("#demo").val();			

					var data = {
						id_user: id_user
					};

					$.ajax({
						type: "POST",
						url: "<?php echo site_url('user/get_dealer_state'); ?>",
						data: data,
						cache: false,
						success: function(response){
							$("#"+container).find("#selected_dealers .norecord").prop("hidden", true);
							$("#"+container).find("#selected_dealers").html('<tr><td><input type="hidden" value="'+id_user+'" id="dealer_id_inp" name="dealer_id">'+username+'</td><td></td></tr>');
							
							$("#"+container).find("#dealer_state").val(response);
							$("#"+container).find("#transport_checkbox").val("");
							if ($("#dealer_state").val() != $("#client_state").val() && parseInt($("#tradein_count").val()) > 0)
							{
								$("#"+container).find("#transport_checkbox_container").prop("hidden", false);
							}
							else
							{
								$("#"+container).find("#transport_checkbox_container").prop("hidden", true);
							}
							
							check_existing_quote(container);
						}
					});
				}
				else if (container == "add_dealers_modal" || container == "start_tender_modal")
				{
					var dealer_ids = $("#"+container).find("#dealer_ids_inp").val();
					var username = $("#"+container).find("#dealer_"+id_user).html();

					$("#"+container).find("#selected_dealers .norecord").prop("hidden", true);
					$("#"+container).find("#selected_dealers").append('<tr id="selected_dealer_'+id_user+'"><td width="90%">'+username+'</td><td><center><span style="cursor: pointer; cursor: hand; color: #58c603;" onclick="delete_dealer(\''+container+'\', '+id_user+')"><i class="fa fa-times"></i></span></center></td></tr>');
					
					$("#"+container).find("#dealer_ids_inp").val(dealer_ids+"-"+id_user);
					$("#"+container).find("#suggested_dealer_"+id_user).remove();
				}
			}

			function check_existing_quote (container)
			{		
				var id_user = $("#"+container).find("#dealer_id_inp").val();
				var id_quote_request = $("#"+container).find("#id_quote_request").val();
				var demo = $("#"+container).find("#demo").val();

				if (id_user && id_quote_request && demo && id_user != "" && id_quote_request != "" && demo != "" && id_user != "0" && id_quote_request != "0")
				{
					var data = {
						id_user: id_user,
						id_quote_request: id_quote_request,
						demo: demo
					};
					
					$.ajax({
						type: "POST",
						url: "<?php echo site_url('lead/get_dealer_existing_quote'); ?>",
						data: data,
						cache: false,
						success: function(response){
							if (response == 0)
							{
								$("#add_quote_modal").find("#quote_form_container").prop("hidden", false);
								$("#add_quote_modal").find("#quote_form_warning_container").prop("hidden", true);
								$("#add_quote_modal").find("#quote_form_warning_message").html();
								$("#add_quote_modal").find("#add_quote_submit_button").prop("disabled", false);
							}
							else
							{
								$("#add_quote_modal").find("#quote_form_container").prop("hidden", true);
								$("#add_quote_modal").find("#quote_form_warning_container").prop("hidden", false);
								$("#add_quote_modal").find("#quote_form_warning_message").html("There is already an existing "+demo+" Vehicle Quote from this Dealer");
								$("#add_quote_modal").find("#add_quote_submit_button").prop("disabled", true);
							}						
						}		
					});					
				}
			}
			
			function delete_dealer (container, dealer_id)
			{
				$("#"+container).find("#selected_dealer_"+dealer_id).remove();
			}		
			
			$(document).on("click",".restart_tender_button",function(e){
			//$(".restart_tender_button").click(function(e) { // Reload //
				
				var id_lead = $(this).data("id_lead");
				
				var data = {
					id_lead: id_lead,
					status: 3
				};				
				
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("lead/update_record"); ?>",
					data: data,
					cache: false,
					success: function(response){
						if (response === "success")
						{
							swal("SUCCESS", "", "success");
							location.reload(true);
						}						
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});				
				e.preventDefault();
			});
			
			$(document).on("click",".pretender_button",function(e) { // Reload //
				
				var id_lead = $(this).data("id_lead");
				
				var data = {
					id_lead: id_lead,
					status: 10
				};				
				
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("lead/update_record"); ?>",
					data: data,
					cache: false,
					success: function(response){
						if (response === "success")
						{
							swal("SUCCESS", "", "success");
							location.reload(true);
						}						
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});				
				e.preventDefault();
			});
			
			$(".approve_deal_button").click(function(e) { // Reload //
				
				var id_lead = $(this).data("id_lead");
				
				var data = {
					id_lead: id_lead,
					status: 5
				};				
				
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("lead/update_status"); ?>",
					data: data,
					cache: false,
					success: function(response){
						if (response === "success")
						{
							swal("SUCCESS", "", "success");
							location.reload(true);
						}						
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});				
				e.preventDefault();
			});

			$(".deliver_button").click(function(e) { // Reload //
				
				var id_lead = $(this).data("id_lead");
				
				var data = {
					id_lead: id_lead,
					status: 6
				};				
				
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("lead/update_status"); ?>",
					data: data,
					cache: false,
					success: function(response){
						if (response === "success")
						{
							swal("SUCCESS", "", "success");
							location.reload(true);
						}						
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});				
				e.preventDefault();
			});
			
			$(".settle_button").click(function(e) { // Reload //
				
				var id_lead = $(this).data("id_lead");
				
				var data = {
					id_lead: id_lead,
					status: 7
				};				
				
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("lead/update_status"); ?>",
					data: data,
					cache: false,
					success: function(response){
						if (response === "success")
						{
							swal("SUCCESS", "", "success");
							location.reload(true);
						}						
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});				
				e.preventDefault();
			});
			
			$(".select_winning_quote_button").click(function(e) { // Reload //
				
				var id_lead = $(this).data("id_lead");
				var id_quote_request = $(this).data("id_quote_request");
				var id_quote = $(this).data("id_quote");
				
				var data = {
					id_lead: id_lead,
					id_quote_request: id_quote_request,
					id_quote: id_quote
				};				
				
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("lead/select_winning_quote_new"); ?>",
					data: data,
					cache: false,
					success: function(response){
						
						if (response === "success")
						{
							/*swal("SUCCESS", "", "success");
							location.reload(true);*/
							//save_fapplication_info_2(22);
							reopen_lead(id_lead);
					
						}						
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});				
				e.preventDefault();
			});			
			
			$(".delete_lead_event_button").click(function(e) { // Reload //
				
				var id_lead = $(this).data("id_lead");
				var id_lead_event = $(this).data("id_lead_event");
				
				var data = {
					id_lead: id_lead,
					id_lead_event: id_lead_event
				};				
				
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("lead/delete_lead_event"); ?>",
					data: data,
					cache: false,
					success: function(response){
						if (response === "success")
						{
							swal("SUCCESS", "", "success");
							$("#lead_events_container").find("#lead_event_"+id_lead_event).remove();
						}						
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});				
				e.preventDefault();
			});
			
			$(".update_lead_event_status_button").click(function(e) { // Reload //
				
				var id_lead = $(this).data("id_lead");
				var id_lead_event = $(this).data("id_lead_event");
				var status = $(this).data("status");
				
				var data = {
					id_lead: id_lead,
					id_lead_event: id_lead_event,
					status: status
				};				
				
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("lead/update_lead_event_status"); ?>",
					data: data,
					cache: false,
					success: function(response){
						if (response === "success")
						{
							swal("SUCCESS", "", "success");
							$("#lead_events_container").find("#lead_event_"+id_lead_event).remove();
						}						
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});				
				e.preventDefault();
			});			

			$(".delete_quote_button").click(function(e) { // Reload //
				alert();
				var id_lead = $(this).data("id_lead");
				var id_quote_request = $(this).data("id_quote_request");
				var id_quote = $(this).data("id_quote");
				
				var data = {
					id_lead: id_lead,
					id_quote_request: id_quote_request,
					id_quote: id_quote
				};				
				
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("lead/delete_quote"); ?>",
					data: data,
					cache: false,
					success: function(response){
						if (response === "success")
						{
							swal("SUCCESS", "", "success");
							location.reload(true);
						}						
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});				
				e.preventDefault();
			});

			$(".submit_deal_button").click(function(e) { // Reload //
				
				var id_lead = $(this).data("id_lead");
				
				var data = {
					id_lead: id_lead
				};				
				
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("lead/submit_deal_new"); ?>",
					data: data,
					cache: false,
					success: function(response){
						if (response === "success")
						{
							swal("SUCCESS", "", "success");
							location.reload(true);
						}						
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});				
				e.preventDefault();
			});

			$(".send_tender_confirmation_button").click(function(e) {
				
				var id_lead = $(this).data("id_lead");
				var id_quote_request = $(this).data("id_quote_request");
				
				var data = {
					id_lead: id_lead,
					id_quote_request: id_quote_request
				};				
				
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("lead/send_tender_confirmation_email"); ?>" + "/" + id_lead,
					data: data,
					cache: false,
					success: function(response){
						if (response === "success")
						{
							swal("SUCCESS", "", "success");
						}						
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});				
				e.preventDefault();
			});				
			
			$(".remind_dealers_button").click(function(e) {
				
				var id_lead = $(this).data("id_lead");
				var id_quote_request = $(this).data("id_quote_request");
				
				var data = {
					id_lead: id_lead,
					id_quote_request: id_quote_request
				};				
				
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("lead/remind_dealers_new"); ?>",
					data: data,
					cache: false,
					success: function(response){
						if (response === "success")
						{
							swal("SUCCESS", "", "success");
						}						
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});				
				e.preventDefault();
			});				
			
			$(".delete_invoice_button").click(function(e) { // Remove record
				
				var id_lead = $(this).data("id_lead");
				var id_invoice = $(this).data("id_invoice");
				
				var data = {
					id_lead: id_lead,
					id_invoice: id_invoice
				};
				
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("invoice/delete_invoice"); ?>",
					data: data,
					cache: false,
					success: function(response){
						if (response === "success")
						{
							swal("SUCCESS", "", "success");
							$("#invoices_container").find("#lead_invoice_"+id_invoice).remove();
						}						
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});				
				e.preventDefault();
			});			
		
			$(".delete_payment_button").click(function(e) { // Remove record
				
				var id_lead = $(this).data("id_lead");
				var id_payment = $(this).data("id_payment");
				
				var data = {
					id_lead: id_lead,
					id_payment: id_payment
				};
				
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("payment/delete_payment"); ?>",
					data: data,
					cache: false,
					success: function(response){
						if (response === "success")
						{
							swal("SUCCESS", "", "success");
							$("#payments_container").find("#lead_payment_"+id_payment).remove();
						}						
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});				
				e.preventDefault();
			});			
			
			$(".update_payment_show_status_button").click(function(e) { // Remove record
				
				var id_lead = $(this).data("id_lead");
				var id_payment = $(this).data("id_payment");
				var show_status = $(this).data("show_status");
				
				var data = {
					id_lead: id_lead,
					id_payment: id_payment,
					show_status: show_status
				};
				
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("payment/update_payment_show_status"); ?>",
					data: data,
					cache: false,
					success: function(response){
						if (response === "success")
						{
							swal("SUCCESS", "", "success");
							location.reload(true);
						}						
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});				
				e.preventDefault();
			});

			$(".attach_trade_button").click(function(e) { // Reload //
				
				var id_lead = $(this).data("id_lead");
				var id_tradein = $(this).data("id_tradein");

				var data = {
					id_lead: id_lead,
					id_tradein: id_tradein
				};				

				$.ajax({
					type: "POST",
					url: "<?php echo site_url('lead/attach_trade'); ?>",
					cache: false,
					data: data,
					success: function(response){
						if (response === "success")
						{
							swal("SUCCESS", "", "success");
							location.reload(true);
						}						
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});
			});
		
			$(".unattach_trade_button").click(function(e) { // Reload //
				
				var id_lead = $(this).data("id_lead");
				var id_tradein = $(this).data("id_tradein");

				var data = {
					id_lead: id_lead,
					id_tradein: id_tradein
				};

				$.ajax({
					type: "POST",
					url: "<?php echo site_url('lead/unattach_trade'); ?>",
					cache: false,
					data: data,
					success: function(response){
						if (response === "success")
						{
							swal("SUCCESS", "", "success");
							location.reload(true);
						}						
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});
			});

            $(document).on("click",".add_accessory_button",function(evt){
                evt.stopPropagation();
                var container = $(this).data("container");
				var item = '<hr />\
				<input class="form-control input-md" name="accessory_name[]" type="text" placeholder="Accessory"><br />\
				<textarea class="form-control" name="accessory_desc[]" id="textareaDefault" placeholder="Description"></textarea>';
				$("#"+container).find("#accessory_container").append(item);
            });
			
			$(".add_invoice_item_button").click(function(e) {
				var container = $(this).data("container");
				var item = '\
				<div style="padding: 15px; border: 1px solid #ddd; margin-top: 15px;">\
					<div class="row">\
						<div class="col-md-6">\
							<div class="form-group">\
								<label class="control-label">Amount:</label>\
								<input type="text" class="form-control" name="invoice_item_amount[]" onkeypress="return isNumberKey(event)">\
							</div>\
						</div>\
					</div>\
					<div class="row" style="margin-top: 10px;">\
						<div class="col-md-12">\
							<div class="form-group">\
								<label class="control-label">Item Description:</label>\
								<textarea type="text" class="form-control" name="invoice_item_description[]"></textarea>\
							</div>\
						</div>\
					</div>\
				</div>';
				$("#"+container).find("#invoice_items_container").append(item);
			});				

			$(".add_recipient_button").click(function(e) {
				var container = $(this).data("container");
				var item = '<br />\
				<input class="form-control" name="recipient[]" type="text" placeholder="Email Address">';
				$("#"+container).find("#recipient_container").append(item);
			});			
			
			$("#delivery_address_map").change(function(e) {
				var container = $(this).data("container");
				
				alert ($("#"+container).find("#delivery_address_map").val());
				
				if ($("#"+container).find("#delivery_address_map").val() == 1)
				{
					$("#"+container).find("#delivery_address").hide();
				}
				else
				{
					$("#"+container).find("#delivery_address").show();
				}
			});			
			
			// MODAL OPENERS (Start) //
			$(".add_invoice_modal_button").click(function(e) {
				var name = $("#client_details_form").find("#name").val();
				var email = $("#client_details_form").find("#email").val();
				$("#add_invoice_modal").find("#label_name").html(name);
				$("#add_invoice_modal").find("#label_email").html(email);	
				
				$("#add_invoice_modal").modal();
			});
			
			$(".add_payment_modal_button").click(function(e) {
				var name = $("#client_details_form").find("#name").val();
				var email = $("#client_details_form").find("#email").val();
				$("#add_payment_modal").find("#label_name").html(name);
				$("#add_payment_modal").find("#label_email").html(email);	
				
				$("#add_payment_modal").modal();
			});

			$(".edit_payment_modal_button").click(function(e) {
				var name = $("#client_details_form").find("#name").val();
				var email = $("#client_details_form").find("#email").val();	
				$("#edit_payment_form").find("#label_name").html(name);
				$("#edit_payment_form").find("#label_email").html(email);				

				var id_lead = $(this).data("id_lead");
				var id_payment = $(this).data("id_payment");
				
				$("#edit_payment_form").find("#id_payment").val(id_payment);
				
				var data = {
					id_lead: id_lead,
					id_payment: id_payment
				};

				$.ajax({
					type: "POST",
					url: "<?php echo site_url('payment/get_payment'); ?>",
					data: data,
					dataType: "json",
					cache: false,
					success: function(response){
						$("#edit_payment_modal").find("#fk_payment_type").val(response.fk_payment_type);
						$("#edit_payment_modal").find("#reference_number").val(response.reference_number);
						$("#edit_payment_modal").find("#payment_date").val(response.payment_date);
						$("#edit_payment_modal").find("#amount").val(response.amount);
						$("#edit_payment_modal").find("#admin_fee").val(response.admin_fee);
						$("#edit_payment_modal").find("#merchant_cost").val(response.merchant_cost);
						$("#edit_payment_modal").find("#method").val(response.method);
						$("#edit_payment_modal").find("#credit_card").val(response.credit_card);
						$("#edit_payment_modal").find("#bank_account").val(response.bank_account);
						$("#edit_payment_modal").find("#remarks").val(response.remarks);
						$("#edit_payment_modal").modal();	
					}
				});
			});
			
			$(".aftersales_accessories_modal_button").click(function(e) { // NOT DONE YET
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("accessory/generate_accessories_json"); ?>",
					dataType: "json",
					cache: false,
					success: function(response){
						$("#aftersales_accessories_container").html(response.html);
						$("#aftersales_accessories_modal").modal();	
					}
				});	
			});

			$(".event_modal_button").click(function(e) {
				var name = $("#client_details_form").find("#name").val();
				var email = $("#client_details_form").find("#email").val();
				$("#event_modal").find("#label_name").html(name);
				$("#event_modal").find("#label_email").html(email);	
				
				var id_lead = $(this).data("id_lead");
				
				$("#event_modal").find("#id_lead").val(id_lead);
				
				$("#event_modal").modal();
			});
			
			$(".edit_lead_event_modal_button").click(function(e) {
				var name = $("#client_details_form").find("#name").val();
				var email = $("#client_details_form").find("#email").val();	
				$("#event_modal").find("#label_name").html(name);
				$("#event_modal").find("#label_email").html(email);				

				var id_lead = $(this).data("id_lead");
				var id_lead_event = $(this).data("id_lead_event");
				
				$("#event_form").find("#id_lead").val(id_lead);
				$("#event_form").find("#id_lead_event").val(id_lead_event);
				
				var data = {
					id_lead: id_lead,
					id_lead_event: id_lead_event
				};

				$.ajax({
					type: "POST",
					url: "<?php echo site_url('lead/generate_lead_event_json'); ?>",
					data: data,
					dataType: "json",
					cache: false,
					success: function(response){
						$("#event_modal").find("#date").val(response.date);
						$("#event_modal").find("#time").val(response.time);
						$("#event_modal").find("#details").val(response.details);
						$("#event_modal").modal();	
					}
				});
			});			

			$(".send_email_modal_button").click(function(e) {
				var name = $("#client_details_form").find("#name").val();
				var email = $("#client_details_form").find("#email").val();	
				$("#send_email_form").find("#label_name").html(name);
				$("#send_email_form").find("#label_email").html(email);

				$("#send_email_modal").modal();
			});			
			
			$(".add_lead_files_modal_button").click(function(e) {
				var name = $("#client_details_form").find("#name").val();
				var email = $("#client_details_form").find("#email").val();	
				$("#add_lead_files_form").find("#label_name").html(name);
				$("#add_lead_files_form").find("#label_email").html(email);

				$("#add_lead_files_modal").modal();
			});				
			
			$(".start_tender_modal_button").click(function(e) {
				var name = $("#client_details_form").find("#name").val();
				var email = $("#client_details_form").find("#email").val();
				$("#start_tender_form").find("#label_name").html(name);
				$("#start_tender_form").find("#label_email").html(email);			
				
				var id_lead = $(this).data("id_lead");

				var data = {
					id_lead: id_lead
				};

				$.ajax({
					type: "POST",
					url: "<?php echo site_url("lead/get_lead_car_ids"); ?>",
					data: data,
					cache: false,
					dataType: "json",
					success: function(response){
						load_makes("start_tender_modal", response.id_make);
						load_families("start_tender_modal", response.id_make, response.id_family);
						load_build_dates("start_tender_modal", response.id_family);
					}
				});

				load_dealer_selector_parameters("start_tender_modal", id_lead, "tender");

				$("#start_tender_modal").modal();
			});	

			$(".cancel_deal_modal_button").click(function(e) {
				var name = $("#client_details_form").find("#name").val();
				var email = $("#client_details_form").find("#email").val();
				$("#cancel_deal_form").find("#label_name").html(name);
				$("#cancel_deal_form").find("#label_email").html(email);
				
				$("#cancel_deal_modal").modal();
			});			
			
			$(".edit_tender_modal_button").click(function(e) {
				var name = $("#client_details_form").find("#name").val();
				var email = $("#client_details_form").find("#email").val();
				$("#edit_tender_form").find("#label_name").html(name);
				$("#edit_tender_form").find("#label_email").html(email);
				
				var id_lead = $(this).data("id_lead");
				var id_quote_request = $(this).data("id_quote_request");
				
				var id_make = $("#tender_details_form").find("#id_make").val();
				var id_family = $("#tender_details_form").find("#id_family").val();
				var id_vehicle = $("#tender_details_form").find("#id_vehicle").val();
				var build_date = $("#tender_details_form").find("#build_date").val();
				var colour = $("#tender_details_form").find("#colour").val();
				var registration_type = $("#tender_details_form").find("#registration_type").val();

				load_makes("edit_tender_modal", id_make);
				load_families("edit_tender_modal", id_make, id_family);
				load_build_dates("edit_tender_modal", id_family, build_date);
				load_vehicles("edit_tender_modal", id_family+'-'+build_date, id_vehicle);
				load_options("edit_tender_modal", id_vehicle, id_quote_request);
				load_accessories("edit_tender_modal", id_quote_request);
				
				$("#edit_tender_modal").find("#colour").val(colour);
				$("#edit_tender_modal").find("#registration_type [value='"+registration_type+"']").attr("selected", true);
				
				$("#edit_tender_modal").find("#id_quote_request").val(id_quote_request);
				$("#edit_tender_modal").modal();
			});			
			
			$(".add_dealers_modal_button").click(function(e) {
				var name = $("#client_details_form").find("#name").val();
				var email = $("#client_details_form").find("#email").val();
				$("#add_dealers_form").find("#label_name").html(name);
				$("#add_dealers_form").find("#label_email").html(email);
			
				var id_lead = $(this).data("id_lead");
				var id_quote_request = $(this).data("id_quote_request");

				load_dealer_selector_parameters("add_dealers_modal", id_lead, "quote_request");

				$("#add_dealers_modal").find("#id_quote_request").val(id_quote_request);
				$("#add_dealers_modal").modal();
			});		

			$(".email_invite_modal_button").click(function(e) {
				var name = $("#client_details_form").find("#name").val();
				var email = $("#client_details_form").find("#email").val();
				$("#email_invite_form").find("#label_name").html(name);
				$("#email_invite_form").find("#label_email").html(email);			
			
				var id_lead = $(this).data("id_lead");
				var id_quote_request = $(this).data("id_quote_request");
				
				$("#email_invite_modal").find("#id_quote_request").val(id_quote_request);
				$("#email_invite_modal").modal();
			});		
			
			$(".accountant_email_modal_button").click(function(e) {
				var name = $("#client_details_form").find("#name").val();
				var email = $("#client_details_form").find("#email").val();	
				$("#accountant_email_form").find("#label_name").html(name);
				$("#accountant_email_form").find("#label_email").html(email);				

				var id_lead = $(this).data("id_lead");
				
				var data = {
					id_lead: id_lead
				};				
				
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('lead/get_accountant_email_templates'); ?>",
					data: data,
					dataType: "json",
					cache: false,
					success: function(data){
						$("#accountant_email_modal").find("#email_template").html(data.email_options);
						$("#accountant_email_modal").find("#show_status").html(data.show_status);
						$("#accountant_email_modal").modal();	
					}
				});
				
				var data = {
					id_lead: id_lead,
					user_type: "Dealer"
				};				

				$.ajax({
					type: "POST",
					url: "<?php echo site_url('deal/generate_lead_email_recipient_string'); ?>",
					data: data,
					cache: false,
					success: function(response) {
						$("#accountant_email_form").find("#recipients").val(response);
					}
				});					
			});
			// MODAL OPENERS (End) //

			// ON CHANGE (Start) //
			$("#accountant_email_modal").find("#email_template").change(function(e) {
				var id_template = $(this).val();
				var id_lead = $("#accountant_email_form").find("#id_lead").val();
				var dealer_balance = $("#computation_form").find("#dealer_balance").val();

				$("#accountant_email_form").find("#subject").val("");	
				$("#accountant_email_form").find("#content").code("");

				var data = {
					id_template: id_template,
					id_lead: id_lead,
					dealer_balance: dealer_balance
				};
				
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('lead/get_accountant_email_template'); ?>",
					cache: false,
					data: data,
					dataType: "json",
					success: function(data){
						$("#accountant_email_form").find("#subject").val(data.subject);
						$("#accountant_email_form").find("#content").code(data.content);
					}
				});
			});		

			$("#send_email_modal").find("#recipient_type").change(function(e) {
				var recipient_type = $(this).val();
				var id_lead = $("#send_email_form").find("#id_lead").val();
	
				var data = {
					id_lead: id_lead,
					user_type: recipient_type
				};				

				$.ajax({
					type: "POST",
					url: "<?php echo site_url('deal/generate_lead_email_recipient_string'); ?>",
					data: data,
					cache: false,
					success: function(response) {
						$("#send_email_form").find("#recipient_email").val(response);
					}
				});				
			});
			// ON CHANGE (End) //
				
			// DROPZONE UPLOADERS (Start) //
			$("#add_lead_files_form").find(".lead_files").dropzone({
				url: '<?php echo site_url('lead/upload_file/cq_files'); ?>',
				init: function() {
					this.on("sending", function(file, xhr, formData){}),
					this.on("success", function(file, response){
						$("#add_lead_files_form").find("#hidden_images").append('<input class="hidden_image" type="hidden" name="email_file[]" value="'+response+'">');
					}),
					this.on("queuecomplete", function(){});
				},
			});			
			
			$("#send_email_form").find(".email_attachments").dropzone({
				url: '<?php echo site_url('lead/upload_email_attachments/'); ?>',
				init: function() {
					this.on("sending", function(file, xhr, formData){}),
					this.on("success", function(file, response){
						$("#send_email_form").find("#hidden_images").append('<input class="hidden_image" type="hidden" name="email_file[]" value="'+response+'">');
					}),
					this.on("queuecomplete", function(){});
				},
			});
			
			$("#accountant_email_form").find(".accountant_email_attachments").dropzone({
				url: '<?php echo site_url('lead/upload_email_attachments/'); ?>',
				init: function() {
					this.on("sending", function(file, xhr, formData){}),
					this.on("success", function(file, response){
						$("#accountant_email_form").find("#hidden_images").append('<input class="hidden_image" type="hidden" name="email_file[]" value="'+response+'">');
					}),
					this.on("queuecomplete", function(){});
				},
			});			
			// DROPZONE UPLOADERS (End) //
				
			// FORM SUBMISSIONS (Start) //	
			$("#accountant_email_form").submit(function(e) { // Reload //

				var id_lead = $("#accountant_email_form").find("#id_lead").val();
				var email_template = $("#accountant_email_form").find("#email_template").val();
				var subject = $("#accountant_email_form").find("#subject").val();
				var recipients = $("#accountant_email_form").find("#recipients").val();
				var message = $("#accountant_email_form").find("#content").code();
				var attachment_array = [];
				var dealer_invoice_flag = 0;

				if ($("#accountant_email_form").find("#dealer_invoice_flag").prop("checked") == true)
				{
					dealer_invoice_flag = 1;
				}
				else
				{
					dealer_invoice_flag = 0;
				}

				message = replaceAll(message, '&quot;', '%27');
				message = replaceAll(message, '&lt;', '%3C');
				message = replaceAll(message, '&qt;', '%3E');
				message = replaceAll(message, '&amp;', '%26');
				message = replaceAll(message, '&', '%26');

				$("#accountant_email_form").find("#hidden_images").find(".hidden_image").each(function(){
					var image = $(this).val();
					attachment_array.push(image);
				});

				var data = {
					email_template: email_template,
					message: message,
					subject: subject,
					recipients: recipients,
					id_lead: id_lead,
					dealer_invoice_flag: dealer_invoice_flag,
					attachment_array: attachment_array
				};			
			
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('deal/send_accountant_email'); ?>",
					data: data,
					cache: false,
					success: function(response) {
						if (response === "success")
						{
							$("#accountant_email_modal").find("input,textarea,select").val("");
							// $("#accountant_email_modal").find("#content").code("");
							$("#accountant_email_modal").modal("hide");
							
							swal("SUCCESS", "", "success");
							location.reload(true);
						}				
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});
				e.preventDefault();
			});
			
			$("#event_form").submit(function(e) { // Reload //
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('lead/send_lead_event'); ?>",
					data: $("#event_form").serialize(),
					cache: false,
					success: function(response) {
						if (response === "success")
						{
							$("#event_modal").find("input,textarea,select").val("");
							$("#event_modal").modal("hide");
							
							swal("SUCCESS", "", "success");
							location.reload(true);
						}				
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});
				e.preventDefault();
			});

			$("#send_email_form").submit(function(e) { // Reload //

				var id_lead = $("#send_email_form").find("#id_lead").val();
				var recipient = $("#send_email_form").find("#recipient_email").val();
				var subject = $("#send_email_form").find("#subject").val();
				var message = $("#send_email_form").find("#message").val();

				var purchase_order_attachment_flag = 0;
				var order_package_attachment_flag = 0;
				var dealer_invoice_attachment_flag = 0;
				var admin_fee_invoice_attachment_flag = 0;	

				var attachment_array = [];				

				if ($("#send_email_form").find("#purchase_order_attachment_flag").prop("checked") == true)
				{
					purchase_order_attachment_flag = 1;
				}
				
				if ($("#send_email_form").find("#order_package_attachment_flag").prop("checked") == true)
				{
					order_package_attachment_flag = 1;
				}

				if ($("#send_email_form").find("#dealer_invoice_attachment_flag").prop("checked") == true)
				{
					dealer_invoice_attachment_flag = 1;
				}

				if ($("#send_email_form").find("#admin_fee_invoice_attachment_flag").prop("checked") == true)
				{
					admin_fee_invoice_attachment_flag = 1;
				}

				$("#send_email_form").find("#hidden_images").find(".hidden_image").each(function(){
					var image = $(this).val();
					attachment_array.push(image);
				});

				var data = {
					id_lead: id_lead,
					recipient: recipient,
					subject: subject,
					message: message,
					purchase_order_attachment_flag: purchase_order_attachment_flag,
					order_package_attachment_flag: order_package_attachment_flag,
					dealer_invoice_attachment_flag: dealer_invoice_attachment_flag,
					admin_fee_invoice_attachment_flag: admin_fee_invoice_attachment_flag,
					attachment_array: attachment_array
				};			

				$.ajax({
					type: "POST",
					url: "<?php echo site_url('deal/send_email'); ?>",
					data: data,
					cache: false,
					success: function(response) {
						if (response === "success")
						{
							$("#send_email_modal").find("input,textarea,select").val("");
							$("#send_email_modal").modal("hide");
							
							swal("SUCCESS", "", "success");
							location.reload(true);
						}				
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});
				e.preventDefault();
			});
			
			$("#add_lead_files_form").submit(function(e) {

				var id_lead = $("#add_lead_files_form").find("#id_lead").val();

				var attachment_array = [];				

				$("#add_lead_files_form").find("#hidden_images").find(".hidden_image").each(function(){
					var image = $(this).val();
					attachment_array.push(image);
				});

				var data = {
					id_lead: id_lead,
					attachment_array: attachment_array
				};			

				$.ajax({
					type: "POST",
					url: "<?php echo site_url('lead/add_lead_files'); ?>",
					data: data,
					cache: false,
					success: function(response) {
						if (response === "success")
						{
							$("#add_lead_files_modal").find("input,textarea,select").val("");
							$("#add_lead_files_modal").modal("hide");
							
							swal("SUCCESS", "", "success");
							location.reload(true);
						}				
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});
				e.preventDefault();
			});
			
			$("#add_comment_form").submit(function(e) { // Reload //
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('lead/add_comment_new'); ?>",
					data: $("#add_comment_form").serialize(),
					cache: false,
					success: function(response) {
						if (response === "success")
						{
							$("#add_comment_form").find("input,textarea,select").val("");
							$("#add_comment_modal").modal("hide");
		
							swal("SUCCESS", "", "success");
							location.reload(true);
						}				
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});
				e.preventDefault();
			});				

			$("#add_invoice_form").submit(function(e) { // Reload //
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('invoice/add_invoice'); ?>",
					data: $("#add_invoice_form").serialize(),
					cache: false,
					success: function(response) {
						if (response === "success")
						{
							$("#add_invoice_form").find("input,textarea,select").val("");
							$("#add_invoice_modal").modal("hide");

							swal("SUCCESS", "", "success");
							location.reload(true);
						}				
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});
				e.preventDefault();
			});		

			$("#add_payment_form").submit(function(e) { // Reload //
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('payment/add_payment'); ?>",
					data: $("#add_payment_form").serialize(),
					cache: false,
					success: function(response) {
						if (response === "success")
						{
							$("#add_payment_form").find("input,textarea,select").val("");
							$("#add_payment_modal").modal("hide");

							swal("SUCCESS", "", "success");
							location.reload(true);
						}				
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});
				e.preventDefault();
			});			

			$("#edit_payment_form").submit(function(e) { // Reload //
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('payment/update_payment'); ?>",
					data: $("#edit_payment_form").serialize(),
					cache: false,
					success: function(response) {
						if (response === "success")
						{
							$("#edit_payment_form").find("input,textarea,select").val("");
							$("#edit_payment_modal").modal("hide");

							swal("SUCCESS", "", "success");
							// location.reload(true);
						}				
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});
				e.preventDefault();
			});					
			
			$("#start_tender_form").submit(function(e) { // Reload //
				
				var make = $("#start_tender_form").find("#make").val();
				var family = $("#start_tender_form").find("#family").val();
				var build_date = $("#start_tender_form").find("#build_date").val();
				var vehicle = $("#start_tender_form").find("#vehicle").val();
				var colour = $("#start_tender_form").find("#colour").val();
				var registration_type = $("#start_tender_form").find("#registration_type").val();

				if (make == 0 || make == "" || family == 0 || family == "" || build_date == 0 || build_date == "" || vehicle == 0 || vehicle == "" || colour == "" || registration_type == "")
				{
					swal("ERROR", "Please complete all the required fields!", "error");
				}
				else
				{
					$.ajax({
						type: "POST",
						url: "<?php echo site_url("lead/start_tender_new"); ?>",
						data: $("#start_tender_form").serialize(),
						cache: false,
						success: function(response) {
							if (response === "success" || response === "successsuccess")
							{
								$("#start_tender_modal").find("#selected_dealers").html("");
								$("#start_tender_modal").find("#suggested_dealers").html("");
								$("#start_tender_modal").find("input,textarea,select").val("");
								$("#start_tender_modal").find("#dealer_ids_inp").val("0");
								$("#start_tender_modal").modal("hide");

								swal("SUCCESS", "", "success");
								location.reload(true);
							}
							else
							{
								swal("ERROR", "An error occurred! Please contact the administrator", "error");
							}							
						}
					});
				}
				e.preventDefault();
			});	

			$("#cancel_deal_form").submit(function(e) { // Reload //
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('lead/update_record'); ?>",
					data: $("#cancel_deal_form").serialize(),
					cache: false,
					success: function(response) {
						if (response === "success")
						{
							swal("SUCCESS", "", "success");
							location.reload(true);
						}	
						else if (response === "nochanges")
						{
							swal("", "No changes were made", "info");
						}								
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});
				e.preventDefault();
			});				
			
			$("#edit_tender_form").submit(function(e) { // Reload //

				var make = $("#edit_tender_modal").find("#make").val();
				var family = $("#edit_tender_modal").find("#family").val();
				var build_date = $("#edit_tender_modal").find("#build_date").val();
				var vehicle = $("#edit_tender_modal").find("#vehicle").val();
				var colour = $("#edit_tender_modal").find("#colour").val();
				var registration_type = $("#edit_tender_modal").find("#registration_type").val();

				if (make == 0 || make == "" || family == 0 || family == "" || build_date == 0 || build_date == "" || vehicle == 0 || vehicle == "" || colour == "" || registration_type == "")
				{
					swal("ERROR", "Please complete all the required fields!", "error");
				}
				else
				{
					$.ajax({
						type: "POST",
						url: "<?php echo site_url("lead/update_tender"); ?>",
						data: $("#edit_tender_form").serialize(),
						cache: false,
						success: function(response) {
							if (response === "success")
							{
								$("#edit_tender_modal").modal("hide");
								
								swal("SUCCESS", "", "success");
								location.reload(true);
							}				
							else
							{
								swal("ERROR", "An error occurred! Please contact the administrator", "error");
							}								
						}
					});
				}
				e.preventDefault();
			});	
			
			/*$("#add_dealers_form").submit(function(e) { // Reload //
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("lead/add_dealers"); ?>",
					data: $("#add_dealers_form").serialize(),
					cache: false,
					success: function(response) {
						if (response === "success")
						{
							$("#add_dealers_modal").modal("hide");
							$("#add_dealers_modal").find("#selected_dealers").html("");
							$("#add_dealers_modal").find(".norecord").prop("hidden", false);							
							
							swal("SUCCESS", "", "success");
							location.reload(true);
						}
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});
				e.preventDefault();
			});*/
			
			$("#email_invite_form").submit(function(e) { // Reload //
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("lead/send_email_invite"); ?>",
					data: $("#email_invite_form").serialize(),
					cache: false,
					success: function(response) {
						if (response === "success")
						{
							$("#email_invite_modal").modal("hide");
							
							swal("SUCCESS", "", "success");
							location.reload(true);
						}
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});
				e.preventDefault();
			});			
				
			$("#quick_note_form").submit(function(e) {
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('lead/update_record'); ?>",
					data: $("#quick_note_form").serialize(),
					success: function(response) {
						if (response === "success")
						{
							swal("SUCCESS", "", "success");
						}
						else if (response === "nochanges")
						{
							swal("", "No changes were made", "info");
						}						
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});
				e.preventDefault();
			});	

			$("#client_details_form").submit(function(e) { // Reload //
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('lead/update_record'); ?>",
					data: $("#client_details_form").serialize(),
					success: function(response) {
						if (response === "success")
						{
							swal("SUCCESS", "", "success");
							location.reload(true);
						}	
						else if (response === "nochanges")
						{
							swal("", "No changes were made", "info");
						}								
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});
				e.preventDefault();
			});
			
			$("#delivery_details_form").submit(function(e) { // Reload //
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('lead/update_record'); ?>",
					data: $("#delivery_details_form").serialize(),
					success: function(response) {
						if (response === "success")
						{
							swal("SUCCESS", "", "success");
							location.reload(true);
						}	
						else if (response === "nochanges")
						{
							swal("", "No changes were made", "info");
						}								
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});
				e.preventDefault();
			});
			
			$("#settlement_details_form").submit(function(e) {
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('lead/update_record'); ?>",
					data: $("#settlement_details_form").serialize(),
					success: function(response) {
						if (response === "success")
						{
							swal("SUCCESS", "", "success");
						}	
						else if (response === "nochanges")
						{
							swal("", "No changes were made", "info");
						}								
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});
				e.preventDefault();
			});
			
			$("#aftersales_accessories_form").submit(function(e) { // Reload ? //
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('lead/update_record'); ?>",
					data: $("#aftersales_accessories_form").serialize(),
					success: function(response) {
						if (response === "success")
						{
							swal("SUCCESS", "", "success");
							location.reload(true);
						}	
						else if (response === "nochanges")
						{
							swal("", "No changes were made", "info");
						}								
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});
				e.preventDefault();
			});			

			$("#computation_form").submit(function(e) {
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('lead/update_record'); ?>",
					data: $("#computation_form").serialize(),
					success: function(response) {
						if (response === "success")
						{
							swal("SUCCESS", "", "success");
							location.reload(true);
						}	
						else if (response === "nochanges")
						{
							swal("", "No changes were made", "info");
						}								
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});
				e.preventDefault();
			});
			// FORM SUBMISSIONS (End) //
		</script>
	</body>
</html>
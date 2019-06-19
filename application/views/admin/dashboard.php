<?php include 'template/head.php'; ?>
	<body>
		<section class="body">
			<?php include 'template/header.php'; ?>
			<div class="inner-wrapper">
				<?php include 'template/left_sidebar.php'; ?>
				<section role="main" class="content-body">
					<?php include 'template/header_2.php'; ?>
					<!-- start: page -->
					<div class="col-md-6 col-lg-12 col-xl-12">
						<div class="row">
							<div class="col-md-12 col-lg-6 col-xl-6">
								<section class="panel panel-featured-left panel-featured-primary">
									<div class="panel-body">
										<div class="widget-summary">
											<div class="widget-summary-col widget-summary-col-icon">
												<div class="summary-icon bg-primary">
													<i class="fa fa-ticket"></i>
												</div>
											</div>
											<div class="widget-summary-col">
												<div class="summary">
													<h4 class="title">OPEN TICKETS</h4>
													<div class="info">
														<strong class="amount"><a href="<?php echo site_url('ticket/list_view?ticket_status=1'); ?>"><?php echo $ticket_count; ?></a></strong>
													</div>
												</div>
												<div class="summary-footer"><a href="<?php echo site_url('ticket/list_view?ticket_status=1&priority=1'); ?>"><?php echo $urgent_ticket_count; ?> Urgent Tickets</a></div>
											</div>
										</div>
									</div>
								</section>
							</div>						
							<div class="col-md-12 col-lg-6 col-xl-6">
								<section class="panel panel-featured-left panel-featured-primary">
									<div class="panel-body">
										<div class="widget-summary">
											<div class="widget-summary-col widget-summary-col-icon">
												<div class="summary-icon bg-primary">
													<i class="fa fa-usd"></i>
												</div>
											</div>
											<div class="widget-summary-col">
												<div class="summary">
													<h4 class="title">COMMISSION</h4>
													<div class="info">
														<strong class="amount">$<?php echo $settled_commission; ?></strong>
													</div>
												</div>
												<div class="summary-footer"><b>$<?php echo $projected_commission; ?></b> Projected based on delivery dates</div>
											</div>
										</div>
									</div>
								</section>
							</div>						
							<div class="col-md-12 col-lg-4 col-xl-4">
								<section class="panel panel-featured-left panel-featured-primary">
									<div class="panel-body">
										<div class="widget-summary">
											<div class="widget-summary-col widget-summary-col-icon">
												<div class="summary-icon bg-primary">
													<i class="fa fa-user"></i>
												</div>
											</div>
											<div class="widget-summary-col">
												<div class="summary">
													<h4 class="title">LEADS TAKEN / DEALS</h4>
													<div class="info">
														<strong class="amount">
															<?php 
															if ($lead_count==0) { $leads_over_deals = 0; }
															else { $leads_over_deals = ($approved_deal_count / $lead_count) * 100; }
															echo $lead_count . " / " . $approved_deal_count; 
															?>
														</strong>
													</div>
												</div>
												<div class="summary-footer"><?php echo number_format($leads_over_deals, 2); ?>%</div>
											</div>
										</div>
									</div>
								</section>
							</div>						
							<div class="col-md-12 col-lg-4 col-xl-4">
								<section class="panel panel-featured-left panel-featured-primary">
									<div class="panel-body">
										<div class="widget-summary">
											<div class="widget-summary-col widget-summary-col-icon">
												<div class="summary-icon bg-primary">
													<i class="fa fa-tags"></i>
												</div>
											</div>
											<div class="widget-summary-col">
												<div class="summary">
													<h4 class="title">TENDERS / DEALS</h4>
													<div class="info">
														<strong class="amount">
															<?php 
															if ($tender_count==0) { $tenders_over_deals = 0; }
															else { $tenders_over_deals = ($approved_deal_count / $tender_count) * 100; }
															echo $tender_count . " / " . $approved_deal_count; 
															?>
														</strong>
													</div>
												</div>
												<div class="summary-footer"><?php echo number_format($tenders_over_deals, 2); ?>%</div>
											</div>
										</div>
									</div>
								</section>
							</div>
							<div class="col-md-12 col-lg-4 col-xl-4">
								<section class="panel panel-featured-left panel-featured-primary">
									<div class="panel-body">
										<div class="widget-summary">
											<div class="widget-summary-col widget-summary-col-icon">
												<div class="summary-icon bg-primary">
													<i class="fa fa-shopping-cart"></i>
												</div>
											</div>
											<div class="widget-summary-col">
												<div class="summary">
													<h4 class="title">SETTLED DEALS</h4>
													<div class="info">
														<strong class="amount">$<?php echo $total_settled_commissionable_gross; ?></strong>
													</div>
												</div>
												<div class="summary-footer"><b>$<?php echo $total_approved_commissionable_gross; ?></b> Approved Deals</div>
											</div>
										</div>
									</div>
								</section>
							</div>
						</div>
					</div>
					<!--
					<div class="col-md-12">
						<section class="panel">
							<header class="panel-heading">
								<div class="panel-actions">
									<a href="#" class="fa fa-caret-down"></a>
									<a href="#" class="fa fa-times"></a>
								</div>
								<h2 class="panel-title">Hall of Fame</h2>
							</header>						
							<div class="panel-body">
								<br />
								<div class="col-md-2 text-center">
									<span><b>Most Deals (Day)</b></span><br />
									<i class="fa fa-trophy" style="font-size: 4.5em;"></i><br />
									<?php echo $highest_day_deals_name; ?><br />
									<?php echo $highest_day_deals_count; ?> Deals<br />
									<?php echo $highest_day_deals_record_date; ?>
								</div>							
								<div class="col-md-2 text-center">
									<span><b>Most Deals (Month)</b></span><br />
									<i class="fa fa-trophy" style="font-size: 7.5em;"></i><br />
									Johnathon Smale<br />
									42 Deals<br />
									August 2013
								</div>
								<div class="col-md-4 text-center">
									<span><b>Highest Gross (Month)</b></span><br />
									<i class="fa fa-trophy" style="font-size: 10.5em;"></i><br />
									Robert Kauter<br />
									$43800.00<br />
									October 2015
								</div>
								<div class="col-md-2 text-center">
									<span><b>Highest Gross (Unit)</b></span><br />
									<i class="fa fa-trophy" style="font-size: 7.5em;"></i><br />
									Audi Q7 Wagon<br />
									$15720.00<br />
									December 2015
								</div>
								<div class="col-md-2 text-center">
									<span><b>Most Leads (Month)</b></span><br />
									<i class="fa fa-trophy" style="font-size: 4.5em;"></i><br />
									<?php echo $highest_month_leads_name; ?><br />
									<?php echo $highest_month_leads_count; ?> Leads<br />
									<?php echo $highest_month_leads_record_date; ?>
								</div>
								<br />
							</div>
						</section>
					</div>
					-->					
					<div class="col-md-12">
						<section class="panel">
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
										<thead>
											<tr>
												<td colspan="10" style="background: #eee;">
													<center>
														<h4><b>TENDERS RUNNING REPORT</b></h4>
													</center>
												</td>
											</tr>
											<tr>
												<td><b>QUOTE SPECIALIST</b></td>
												<td><b>ALL RUNNING TENDERS</b></td>
												<td><b>TENDERS WITH WINNERS</b></td>
												<td><b>TENDERS STARTED TODAY</b></td>
											</tr>
										</thead>
										<tbody>
											<?php
											$tender_count_all = 0;
											$tender_with_winners_count_all = 0;
											$tender_count_today = 0;
											foreach ($running_tenders_report AS $running_tenders_record)
											{
												if ($running_tenders_record['tender_count_all'] > 0)
												{
													echo '<tr>';
													echo '<td>'.$running_tenders_record['name'].'</td>';
													echo '<td align="right">'.$running_tenders_record['tender_count_all'].'</td>';
													echo '<td align="right">'.$running_tenders_record['tender_with_winners_count_all'].'</td>';
													echo '<td align="right">'.$running_tenders_record['tender_count_today'].'</td>';
													echo '</tr>';
													$tender_count_all += $running_tenders_record['tender_count_all'];
													$tender_with_winners_count_all += $running_tenders_record['tender_with_winners_count_all'];
													$tender_count_today += $running_tenders_record['tender_count_today'];
												}
											}
											?>
											<tr>
												<td><b>TOTAL</b></td>
												<td align="right"><b><?php echo $tender_count_all; ?></b></td>
												<td align="right"><b><?php echo $tender_with_winners_count_all; ?></b></td>
												<td align="right"><b><?php echo $tender_count_today; ?></b></td>
											</tr>
										</tbody>
									</table>
								</div>
								<br />							
								<div class="table-responsive">
									<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
										<thead>
											<tr>
												<td colspan="10" style="background: #eee;">
													<center>
														<h4><b>APPROVED DEALS REPORT</b></h4>
														<p>Deals approved <?php echo date('F Y'); ?></p>
													</center>
												</td>
											</tr>
											<tr>
												<td><b>QUOTE SPECIALIST</b></td>
												<td><b>MONTHLY DEALS</b></td>
												<td><b>MONTHLY GROSS</b></td>
												<td><b>LAST MONTH GROSS</b></td>
												<td><b>THIS WEEK GROSS</b></td>
												<td><b>Monday</b></td>
												<td><b>Tuesday</b></td>
												<td><b>Wednesday</b></td>
												<td><b>Thursday</b></td>
												<td><b>Friday</b></td>
											</tr>
										</thead>
										<tbody>
											<?php
											$total_monthly_deals = 0;
											$total_monthly_gross = 0;
											$total_last_month_gross = 0;
											$total_this_week_gross = 0;
											$total_day_1 = 0;
											$total_day_2 = 0;
											$total_day_3 = 0;
											$total_day_4 = 0;
											$total_day_5 = 0;
											foreach ($approved_deals_report AS $approved_deal_record)
											{
												if ($approved_deal_record->val_1=="") { $rec_1 = 0; } else { $rec_1 = $approved_deal_record->val_1; }
												if ($approved_deal_record->val_2=="") { $rec_2 = 0; } else { $rec_2 = $approved_deal_record->val_2; }
												if ($approved_deal_record->val_3=="") { $rec_3 = 0; } else { $rec_3 = $approved_deal_record->val_3; }
												if ($approved_deal_record->val_4=="") { $rec_4 = 0; } else { $rec_4 = $approved_deal_record->val_4; }
												if ($approved_deal_record->val_5=="") { $rec_5 = 0; } else { $rec_5 = $approved_deal_record->val_5; }

												if ($approved_deal_record->monthly_deals > 0)
												{
													$this_week_gross = $rec_1 + $rec_2 + $rec_3 + $rec_4 + $rec_5;
													echo '<tr>';
													echo '<td>'.$approved_deal_record->name.'</td>';
													echo '<td align="right">'.$approved_deal_record->monthly_deals.'</td>';
													echo '<td align="right">'.number_format($approved_deal_record->monthly_gross, 2).'</td>';
													echo '<td align="right">'.number_format($approved_deal_record->last_month_gross, 2).'</td>';
													echo '<td align="right">'.number_format($this_week_gross, 2).'</td>';
													echo '<td align="right">'.number_format($rec_1, 2).'</td>';
													echo '<td align="right">'.number_format($rec_2, 2).'</td>';
													echo '<td align="right">'.number_format($rec_3, 2).'</td>';
													echo '<td align="right">'.number_format($rec_4, 2).'</td>';
													echo '<td align="right">'.number_format($rec_5, 2).'</td>';
													echo '</tr>';

													$total_monthly_deals += round($approved_deal_record->monthly_deals, 2);
													$total_monthly_gross += round($approved_deal_record->monthly_gross, 2);
													$total_last_month_gross += round($approved_deal_record->last_month_gross, 2);
													$total_this_week_gross += round($this_week_gross, 2);
													$total_day_1 += round($rec_1, 2);
													$total_day_2 += round($rec_2, 2);
													$total_day_3 += round($rec_3, 2);
													$total_day_4 += round($rec_4, 2);
													$total_day_5 += round($rec_5, 2);
												}
											}
											?>
											<tr>
												<td><b>TOTAL</b></td>
												<td align="right"><b><?php echo number_format($total_monthly_deals); ?></b></td>
												<td align="right"><b><?php echo number_format($total_monthly_gross, 2); ?></b></td>
												<td align="right"><b><?php echo number_format($total_last_month_gross, 2); ?></b></td>
												<td align="right"><b><?php echo number_format($total_this_week_gross, 2); ?></b></td>
												<td align="right"><b><?php echo number_format($total_day_1, 2); ?></b></td>
												<td align="right"><b><?php echo number_format($total_day_2, 2); ?></b></td>
												<td align="right"><b><?php echo number_format($total_day_3, 2); ?></b></td>
												<td align="right"><b><?php echo number_format($total_day_4, 2); ?></b></td>
												<td align="right"><b><?php echo number_format($total_day_5, 2); ?></b></td>
											</tr>
										</tbody>
									</table>
								</div>
								<br />
								<div class="table-responsive">
									<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
										<thead>
											<tr>
												<td colspan="10" style="background: #eee;">
													<center>
														<h4><b>SUBMITTED DEALS REPORT</b></h4>
														<p>Deals submitted <?php echo date('F Y'); ?></p>
													</center>
												</td>
											</tr>
											<tr>
												<td><b>QUOTE SPECIALIST</b></td>
												<td><b>MONTHLY DEALS</b></td>
												<td><b>MONTHLY GROSS</b></td>
												<td><b>LAST MONTH GROSS</b></td>
												<td><b>THIS WEEK GROSS</b></td>
												<td><b>Monday</b></td>
												<td><b>Tuesday</b></td>
												<td><b>Wednesday</b></td>
												<td><b>Thursday</b></td>
												<td><b>Friday</b></td>
											</tr>
										</thead>
										<tbody>
											<?php
											$total_monthly_deals = 0;
											$total_monthly_gross = 0;
											$total_last_month_gross = 0;
											$total_this_week_gross = 0;
											$total_day_1 = 0;
											$total_day_2 = 0;
											$total_day_3 = 0;
											$total_day_4 = 0;
											$total_day_5 = 0;
											foreach ($submitted_deals_report AS $submitted_deal_record)
											{
												if ($submitted_deal_record->val_1=="") { $rec_1 = 0; } else { $rec_1 = $submitted_deal_record->val_1; }
												if ($submitted_deal_record->val_2=="") { $rec_2 = 0; } else { $rec_2 = $submitted_deal_record->val_2; }
												if ($submitted_deal_record->val_3=="") { $rec_3 = 0; } else { $rec_3 = $submitted_deal_record->val_3; }
												if ($submitted_deal_record->val_4=="") { $rec_4 = 0; } else { $rec_4 = $submitted_deal_record->val_4; }
												if ($submitted_deal_record->val_5=="") { $rec_5 = 0; } else { $rec_5 = $submitted_deal_record->val_5; }

												if ($submitted_deal_record->monthly_deals > 0)
												{
													$this_week_gross = $rec_1 + $rec_2 + $rec_3 + $rec_4 + $rec_5;
													echo '<tr>';
													echo '<td>'.$submitted_deal_record->name.'</td>';
													echo '<td align="right">'.$submitted_deal_record->monthly_deals.'</td>';
													echo '<td align="right">'.number_format($submitted_deal_record->monthly_gross, 2).'</td>';
													echo '<td align="right">'.number_format($submitted_deal_record->last_month_gross, 2).'</td>';
													echo '<td align="right">'.number_format($this_week_gross, 2).'</td>';
													echo '<td align="right">'.number_format($rec_1, 2).'</td>';
													echo '<td align="right">'.number_format($rec_2, 2).'</td>';
													echo '<td align="right">'.number_format($rec_3, 2).'</td>';
													echo '<td align="right">'.number_format($rec_4, 2).'</td>';
													echo '<td align="right">'.number_format($rec_5, 2).'</td>';
													echo '</tr>';

													$total_monthly_deals += round($submitted_deal_record->monthly_deals, 2);
													$total_monthly_gross += round($submitted_deal_record->monthly_gross, 2);
													$total_last_month_gross += round($submitted_deal_record->last_month_gross, 2);
													$total_this_week_gross += round($this_week_gross, 2);
													$total_day_1 += round($rec_1, 2);
													$total_day_2 += round($rec_2, 2);
													$total_day_3 += round($rec_3, 2);
													$total_day_4 += round($rec_4, 2);
													$total_day_5 += round($rec_5, 2);												
												}
											}
											?>
											<tr>
												<td><b>TOTAL</b></td>
												<td align="right"><b><?php echo number_format($total_monthly_deals); ?></b></td>
												<td align="right"><b><?php echo number_format($total_monthly_gross, 2); ?></b></td>
												<td align="right"><b><?php echo number_format($total_last_month_gross, 2); ?></b></td>
												<td align="right"><b><?php echo number_format($total_this_week_gross, 2); ?></b></td>
												<td align="right"><b><?php echo number_format($total_day_1, 2); ?></b></td>
												<td align="right"><b><?php echo number_format($total_day_2, 2); ?></b></td>
												<td align="right"><b><?php echo number_format($total_day_3, 2); ?></b></td>
												<td align="right"><b><?php echo number_format($total_day_4, 2); ?></b></td>
												<td align="right"><b><?php echo number_format($total_day_5, 2); ?></b></td>
											</tr>
										</tbody>
									</table>
								</div>
								<br />
								<div class="table-responsive">
									<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
										<thead>
											<tr>
												<td colspan="10" style="background: #eee;">
													<center>
														<h4><b>THIS MONTH SETTLEMENT REPORT</b></h4>
														<p>Deals settled <?php echo date('F Y'); ?></p>
													</center>
												</td>
											</tr>											
											<tr>
												<td><b>QUOTE SPECIALIST</b></td>
												<td><b>TOTAL SETTLED</b></td>
												<td><b>APPROVED DEALS</b></td>
												<td><b>SETTLED DEALS</b></td>
												<td><b>TENDERS RUN</b></td>
												<td><b>EMAILS SENT</b></td>
												<td><b>WINNING DEALERS SELECTED</b></td>
											</tr>
										</thead>
										<tbody>
											<?php
											$total_monthly_gross = 0;
											$total_approved_deals = 0;
											$total_settled_deals = 0;
											$total_tenders_run = 0;
											$total_emails_sent = 0;
											$total_winning_dealers_selected = 0;
											foreach ($settled_deals_report AS $settled_deal_record)
											{
												if ($settled_deal_record->settled_deals > 0)
												{
													echo '<tr>';
													echo '<td>'.$settled_deal_record->name.'</td>';
													echo '<td align="right">'.number_format($settled_deal_record->monthly_gross, 2).'</td>';
													echo '<td align="right">'.$settled_deal_record->approved_deals.'</td>';
													echo '<td align="right">'.$settled_deal_record->settled_deals.'</td>';
													echo '<td align="right">'.$settled_deal_record->tenders_run.'</td>';
													echo '<td align="right">'.$settled_deal_record->emails_sent.'</td>';
													echo '<td align="right">'.$settled_deal_record->winning_dealers_selected.'</td>';
													echo '</tr>';

													$total_monthly_gross += round($settled_deal_record->monthly_gross, 2);
													$total_approved_deals += $settled_deal_record->approved_deals;
													$total_settled_deals += $settled_deal_record->settled_deals;
													$total_tenders_run += $settled_deal_record->tenders_run;
													$total_emails_sent += $settled_deal_record->emails_sent;
													$total_winning_dealers_selected += $settled_deal_record->winning_dealers_selected;
												}
											}
											?>
											<tr>
												<td><b>TOTAL</b></td>
												<td align="right"><b><?php echo number_format($total_monthly_gross, 2); ?></b></td>
												<td align="right"><b><?php echo number_format($total_approved_deals); ?></b></td>
												<td align="right"><b><?php echo number_format($total_settled_deals); ?></b></td>
												<td align="right"><b><?php echo number_format($total_tenders_run); ?></b></td>
												<td align="right"><b><?php echo number_format($total_emails_sent); ?></b></td>
												<td align="right"><b><?php echo number_format($total_winning_dealers_selected); ?></b></td>
											</tr>
										</tbody>
									</table>
								</div>
								<br />
								<div class="table-responsive">
									<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
										<thead>
											<tr>
												<td colspan="10" style="background: #eee;">
													<center>
														<h4><b>LAST MONTH SETTLEMENT REPORT</b></h4>
														<?php
														$datestring = date('Y-m-d');
														$datestring = $datestring . ' first day of last month';
														$dt = date_create($datestring);
														$last_month_label = $dt->format('F Y');
														?>
														<p>Deals settled <?php echo $last_month_label; ?></p>
													</center>
												</td>
											</tr>											
											<tr>
												<td><b>QUOTE SPECIALIST</b></td>
												<td><b>TOTAL SETTLED</b></td>
												<td><b>APPROVED DEALS</b></td>
												<td><b>SETTLED DEALS</b></td>
												<td><b>TENDERS RUN</b></td>
												<td><b>EMAILS SENT</b></td>
												<td><b>WINNING DEALERS SELECTED</b></td>
											</tr>
										</thead>
										<tbody>
											<?php
											$total_monthly_gross = 0;
											$total_approved_deals = 0;
											$total_settled_deals = 0;
											$total_tenders_run = 0;
											$total_emails_sent = 0;
											$total_winning_dealers_selected = 0;
											foreach ($last_settled_deals_report AS $settled_deal_record)
											{
												if ($settled_deal_record->settled_deals > 0)
												{
													echo '<tr>';
													echo '<td>'.$settled_deal_record->name.'</td>';
													echo '<td align="right">'.number_format($settled_deal_record->monthly_gross, 2).'</td>';
													echo '<td align="right">'.$settled_deal_record->approved_deals.'</td>';
													echo '<td align="right">'.$settled_deal_record->settled_deals.'</td>';
													echo '<td align="right">'.$settled_deal_record->tenders_run.'</td>';
													echo '<td align="right">'.$settled_deal_record->emails_sent.'</td>';
													echo '<td align="right">'.$settled_deal_record->winning_dealers_selected.'</td>';
													echo '</tr>';

													$total_monthly_gross += round($settled_deal_record->monthly_gross, 2);
													$total_approved_deals += $settled_deal_record->approved_deals;
													$total_settled_deals += $settled_deal_record->settled_deals;
													$total_tenders_run += $settled_deal_record->tenders_run;
													$total_emails_sent += $settled_deal_record->emails_sent;
													$total_winning_dealers_selected += $settled_deal_record->winning_dealers_selected;
												}
											}
											?>
											<tr>
												<td><b>TOTAL</b></td>
												<td align="right"><b><?php echo number_format($total_monthly_gross, 2); ?></b></td>
												<td align="right"><b><?php echo number_format($total_approved_deals); ?></b></td>
												<td align="right"><b><?php echo number_format($total_settled_deals); ?></b></td>
												<td align="right"><b><?php echo number_format($total_tenders_run); ?></b></td>
												<td align="right"><b><?php echo number_format($total_emails_sent); ?></b></td>
												<td align="right"><b><?php echo number_format($total_winning_dealers_selected); ?></b></td>
											</tr>
										</tbody>
									</table>
								</div>								
							</div>
						</section>
					</div>					
					<div class="col-md-12">
						<section class="panel">
							<div class="panel-body">
								<div class="chart-data-selector" id="salesSelectorWrapper3">
									<h2>
										Leads: 
										<strong>
											<select class="form-control" id="salesSelector3">
												<option value="Day" selected>This Week</option>
												<!--
												<option value="Week">Week</option>
												<option value="Month">Month</option>
												-->
											</select>
										</strong>
									</h2>
									<div id="salesSelectorItems3" class="chart-data-selector-items mt-sm">
										<div class="chart chart-md" id="leads_day" data-sales-rel="Day" class="chart-active"></div>
										<!--
										<div class="chart chart-md" id="leads_week" data-sales-rel="Week" class="chart-active"></div>
										<div class="chart chart-md" id="leads_month" data-sales-rel="Month" class="chart-active"></div>
										-->
									</div>
								</div>
							</div>
						</section>
					</div>
					<div class="col-md-12">
						<section class="panel">
							<div class="panel-body">
								<div class="chart-data-selector" id="salesSelectorWrapper2">
									<h2>
										Tenders: 
										<strong>
											<select class="form-control" id="salesSelector2">
												<option value="Day" selected>This Week</option>
												<!--
												<option value="Week">Week</option>
												<option value="Month">Month</option>
												-->
											</select>
										</strong>
									</h2>
									<div id="salesSelectorItems2" class="chart-data-selector-items mt-sm">
										<div class="chart chart-md" id="tenders_day" data-sales-rel="Day" class="chart-active"></div>
										<!--
										<div class="chart chart-md" id="tenders_week" data-sales-rel="Week" class="chart-active"></div>
										<div class="chart chart-md" id="tenders_month" data-sales-rel="Month" class="chart-active"></div>
										-->
									</div>
								</div>
							</div>
						</section>
					</div>					
					<div class="col-md-12">
						<section class="panel">
							<div class="panel-body">
								<div class="chart-data-selector" id="salesSelectorWrapper1">
									<h2>
										Deals: 
										<strong>
											<select class="form-control" id="salesSelector1">
												<option value="Day" selected>This Week</option>
												<!--
												<option value="Week">Week</option>
												<option value="Month">Month</option>
												-->
											</select>
										</strong>
									</h2>
									<div id="salesSelectorItems1" class="chart-data-selector-items mt-sm">
										<div class="chart chart-md" id="orders_day" data-sales-rel="Day" class="chart-active"></div>
										<!--
										<div class="chart chart-md" id="orders_week" data-sales-rel="Week" class="chart-active"></div>
										<div class="chart chart-md" id="orders_month" data-sales-rel="Month" class="chart-active"></div>
										-->
									</div>
								</div>
							</div>
						</section>
					</div>
					<!-- end: page -->
					<?php include 'modals/ticket_modals.php'; ?>
				</section>
			</div>
			<?php include 'template/right_sidebar.php'; ?>
		</section>		
		<?php include 'template/scripts.php'; ?>
		<script>
			(function( $ )
			{
				'use strict';
				$('#salesSelector1').themePluginMultiSelect().on('change', function() {
					var rel = $(this).val();
					$('#salesSelectorItems1 .chart').removeClass('chart-active').addClass('chart-hidden');
					$('#salesSelectorItems1 .chart[data-sales-rel="' + rel + '"]').addClass('chart-active').removeClass('chart-hidden');
				});
				$('#salesSelector1').trigger('change');
				$('#salesSelectorWrapper1').addClass('ready');
				
				$('#salesSelector2').themePluginMultiSelect().on('change', function() {
					var rel = $(this).val();
					$('#salesSelectorItems2 .chart').removeClass('chart-active').addClass('chart-hidden');
					$('#salesSelectorItems2 .chart[data-sales-rel="' + rel + '"]').addClass('chart-active').removeClass('chart-hidden');
				});
				$('#salesSelector2').trigger('change');
				$('#salesSelectorWrapper2').addClass('ready');

				$('#salesSelector3').themePluginMultiSelect().on('change', function() {
					var rel = $(this).val();
					$('#salesSelectorItems3 .chart').removeClass('chart-active').addClass('chart-hidden');
					$('#salesSelectorItems3 .chart[data-sales-rel="' + rel + '"]').addClass('chart-active').removeClass('chart-hidden');
				});
				$('#salesSelector3').trigger('change');
				$('#salesSelectorWrapper3').addClass('ready');				
				
				new Morris.Line({
					resize: true,
					element: 'orders_day',
					data: [					
						<?php 
						$day_data_string = "";
						foreach ($d as $index => $day_row)
						{
							$day_data_string .= "{ d: '".$day_row."', ";
							foreach ($order_counter as $order)
							{
								$this_value = 0;
								if ($index == 0) { $this_value = $order->val_1; }
								else if ($index == 1) { $this_value = $order->val_2; }
								else if ($index == 2) { $this_value = $order->val_3; }
								else if ($index == 3) { $this_value = $order->val_4; }
								else if ($index == 4) { $this_value = $order->val_5; }
								else if ($index == 5) { $this_value = $order->val_6; }
								else if ($index == 6) { $this_value = $order->val_7; }
								$day_data_string .= $order->qs_id.": ".$this_value.", ";
							}
							$day_data_string .= " },";
						}
						echo $final_day_data_string = rtrim($day_data_string, ',');
						?>
					],
					xkey: 'd',
					ykeys: [
						<?php
						$day_ykeys_string = "";
						foreach ($order_counter as $order)
						{
							$day_ykeys_string .= "'".$order->qs_id."',";
						}
						echo $final_day_ykeys_string = rtrim($day_ykeys_string, ',');
						?>
					],
					labels: [
						<?php
						$day_labels_string = "";
						foreach ($order_counter as $order)
						{
							$day_labels_string .= "'".$order->name."',";
						}
						echo $final_day_labels_string = rtrim($day_labels_string, ',');
						?>
					],
					xLabels: ['day'],
					hideHover: true
				});
				
				new Morris.Line({
					resize: true,
					element: 'tenders_day',
					data: [					
						<?php 
						$day_data_string = "";
						foreach ($d as $index => $day_row)
						{
							$day_data_string .= "{ d: '".$day_row."', ";
							foreach ($tender_counter as $tender)
							{
								$this_value = 0;
								if ($index == 0) { $this_value = $tender->val_1; }
								else if ($index == 1) { $this_value = $tender->val_2; }
								else if ($index == 2) { $this_value = $tender->val_3; }
								else if ($index == 3) { $this_value = $tender->val_4; }
								else if ($index == 4) { $this_value = $tender->val_5; }
								else if ($index == 5) { $this_value = $tender->val_6; }
								else if ($index == 6) { $this_value = $tender->val_7; }
								$day_data_string .= $tender->qs_id.": ".$this_value.", ";
							}
							$day_data_string .= " },";
						}
						echo $final_day_data_string = rtrim($day_data_string, ',');
						?>
					],
					xkey: 'd',
					ykeys: [
						<?php
						$day_ykeys_string = "";
						foreach ($tender_counter as $tender)
						{
							$day_ykeys_string .= "'".$tender->qs_id."',";
						}
						echo $final_day_ykeys_string = rtrim($day_ykeys_string, ',');
						?>
					],
					labels: [
						<?php
						$day_labels_string = "";
						foreach ($tender_counter as $tender)
						{
							$day_labels_string .= "'".$tender->name."',";
						}
						echo $final_day_labels_string = rtrim($day_labels_string, ',');
						?>
					],
					xLabels: ['day'],
					hideHover: true
				});
				
				new Morris.Line({
					resize: true,
					element: 'leads_day',
					data: [					
						<?php 
						$day_data_string = "";
						foreach ($d as $index => $day_row)
						{
							$day_data_string .= "{ d: '".$day_row."', ";
							foreach ($lead_counter as $lead)
							{
								$this_value = 0;
								if ($index == 0) { $this_value = $lead->val_1; }
								else if ($index == 1) { $this_value = $lead->val_2; }
								else if ($index == 2) { $this_value = $lead->val_3; }
								else if ($index == 3) { $this_value = $lead->val_4; }
								else if ($index == 4) { $this_value = $lead->val_5; }
								else if ($index == 5) { $this_value = $lead->val_6; }
								else if ($index == 6) { $this_value = $lead->val_7; }
								$day_data_string .= $lead->qs_id.": ".$this_value.", ";
							}
							$day_data_string .= " },";
						}
						echo $final_day_data_string = rtrim($day_data_string, ',');
						?>
					],
					xkey: 'd',
					ykeys: [
						<?php
						$day_ykeys_string = "";
						foreach ($lead_counter as $lead)
						{
							$day_ykeys_string .= "'".$lead->qs_id."',";
						}
						echo $final_day_ykeys_string = rtrim($day_ykeys_string, ',');
						?>
					],
					labels: [
						<?php
						$day_labels_string = "";
						foreach ($lead_counter as $lead)
						{
							$day_labels_string .= "'".$lead->name."',";
						}
						echo $final_day_labels_string = rtrim($day_labels_string, ',');
						?>
					],
					xLabels: ['day'],
					hideHover: true
				});				
				
				new Morris.Line({
					resize: true,
					element: 'orders_week',
					data: [
						{ w: '2016 W1', a: 0 }
					],
					xkey: 'w',
					ykeys: ['a', 'b', 'c'],
					labels: [
						'John Smale'
					],
					xLabels: ['week'],
					hideHover: true
				});
				
				var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
				new Morris.Line({
					resize: true,
					element: 'orders_month',
					data: [
						{ m: '2016-01', a: 20 }
					],
					xkey: 'm',
					ykeys: ['a'],
					labels: [
						'John Smale'
					],
					hideHover: true,
					xLabelFormat: function(x) {
						var month = months[x.getMonth()];
						return month;
					},
					dateFormat: function(x) {
						var month = months[new Date(x).getMonth()];
						return month;
					}
				});				
				
			}).apply( this, [ jQuery ]);		
		</script>
	</body>
</html>
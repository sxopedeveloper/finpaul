				<aside id="sidebar-left" class="sidebar-left">
					<div class="sidebar-header">
						<div class="sidebar-title">
							Navigation
						</div>
						<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
							<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
						</div>
					</div>
					<div class="nano">
						<div class="nano-content">
							<nav id="menu" class="nav-main" role="navigation">
								<ul class="nav nav-main">
									<?php
									if (!isset($admin_type))
									{
										$admin_type = 0;
									}

									if ($admin_type==3 || $user_id==259)
									{
										$calendar_url = 'full_calendar?t_open=1&s_open=1&l_new=1&l_attempted=1&l_tendering=1&l_submitted=1&l_onhold=1&l_approved=1&fa_new=1&fa_attempted=1';
									}
									else
									{
										$calendar_url = 'full_calendar';
									}
									
									if ($login_type == 'Admin')
									{
										$home_nav = ""; if ($title=='Home') { $home_nav = " nav-active"; }
										$dashboard_nav = ""; if ($title=='Dashboard') { $dashboard_nav = " nav-active"; }
										$calendar_nav = ""; if ($title=='Calendar') { $calendar_nav = " nav-active"; }
										$carsales_nav = ""; if ($title=='Car Sales - List View') { $carsales_nav = " nav-active"; }
										$quotes_nav = ""; if ($title=='Quote Search') { $quotes_nav = " nav-active"; }

										$vehicle_nav = ""; 
										if ($title=='Add Vehicle')
										{
											$vehicle_nav = " nav-expanded nav-active"; 
										}										
										
										$profile_nav = ""; 
										if ($title=='Profile' OR $title=='Change Password') 
										{
											$profile_nav = " nav-expanded nav-active"; 
										}

										$accounts_nav = ""; 
										if ($title=='Dealers' OR $title=='Wholesalers' OR $title=='Staffs' OR $title=='Accounts - Create New' OR $title=='FQ User Account')
										{
											$accounts_nav = " nav-expanded nav-active"; 
										}

										$administration_nav = ""; 
										if ($title=='Logs' OR $title=='Google Ads' OR $title=='Landing Pages - Quote Me' OR $title=='Landing Pages - FinQuote' OR $title=='Email Templates - List View' OR $title=='Stats - Quote Me' OR $title=='Clients')
										{
											$administration_nav = " nav-expanded nav-active"; 
										}										

										$leads_nav = ""; 
										if ($title=='Leads - Create New' OR $title=='Leads - List View' OR $title=='Leads - Reallocations')
										{
											$leads_nav = " nav-expanded nav-active";
										}

										$deals_nav = ""; 
										if ($title=='Deals - List View' OR $title=='Deals - Tile View' OR $title=='Deals - Invoices'  OR $title=='Deals - Transactions')
										{
											$deals_nav = " nav-expanded nav-active";
										}				
										
										$fleads_nav = "";
										if ($title=='FinQuote Applications - Create New' OR $title=='FinQuote Applications - List View')
										{
											$fleads_nav = " nav-expanded nav-active";
										}	

										$tradeins_nav = "";
										if ($title=='Trade-In - List View' OR $title=='Trade-In - Tile View' OR $title=='Trade-In - Create New')
										{
											$tradeins_nav = " nav-expanded nav-active";
										}

										$tickets_nav = "";
										if ($title=='Tickets - Create New' OR $title=='Tickets - List View')
										{
											$tickets_nav = " nav-expanded nav-active";
										}
										?>

										<?php
										if ($user_id <> 554)
										{
											?>
											<li class="<?php echo $home_nav; ?>">
												<a href="<?php echo site_url(); ?>">
													<i class="fa fa-home" aria-hidden="true"></i>
													<span>Home</span>
												</a>
											</li>											
											<li class="<?php echo $dashboard_nav; ?>">
												<a href="<?php echo site_url('dashboard'); ?>">
													<i class="fa fa-tachometer" aria-hidden="true"></i>
													<span>Dashboard</span>
												</a>
											</li>
											<li class="<?php echo $calendar_nav; ?>">
												<a href="<?php echo site_url($calendar_url); ?>">
													<i class="fa fa-calendar" aria-hidden="true"></i>
													<span>Calendar</span>
												</a>
											</li>
											<!--
											<li class="<?php echo $carsales_nav; ?>">
												<a href="<?php echo site_url('carsales/list_view?status=0'); ?>">
													<i class="fa fa-car" aria-hidden="true"></i>
													<span>Car Sales Ads</span>
												</a>
											</li>
											-->
											<li class="nav-parent<?php echo $vehicle_nav; ?>">
												<a>
													<i class="fa fa-car" aria-hidden="true"></i>
													<span>Vehicles</span>
												</a>
												<ul class="nav nav-children">
													<li><a href="<?php echo site_url('add_vehicle'); ?>">Add Vehicle</a></li>
													<li><a href="<?php echo site_url('rb_data'); ?>">RB Data</a></li>
												</ul>
											
											</li>											
											<?php
										}
										?>
										<li class="nav-parent<?php echo $profile_nav; ?>">
											<a>
												<i class="fa fa-user" aria-hidden="true"></i>
												<span>User</span>
											</a>
											<ul class="nav nav-children">
												<li><a href="<?php echo site_url('admin/profile'); ?>">Profile</a></li>
												<li><a href="<?php echo site_url('user/change_password'); ?>">Change Password</a></li>
											</ul>
										</li>
										<?php
										if ($admin_type==2 OR $admin_type==5)
										{
											?>										
											<li class="nav-parent<?php echo $accounts_nav; ?>">
												<a>
													<i class="fa fa-users" aria-hidden="true"></i>
													<span>Accounts</span>
												</a>
												<ul class="nav nav-children">
													<li><a href="<?php echo site_url('account/new_account'); ?>">Add New Account</a></li>
													<li><a href="<?php echo site_url('account/new_record'); ?>">Create New User</a></li>
													<li><a href="<?php echo site_url('account/dealers'); ?>">Dealers</a></li>
													<li><a href="<?php echo site_url('account/wholesalers'); ?>">Wholesalers</a></li>
													<li><a href="<?php echo site_url('account/referrers'); ?>">Referrers</a></li>
													<li><a href="<?php echo site_url('account/staffs'); ?>">Staffs</a></li>
													<li><a href="<?php echo site_url('account/fquser'); ?>">FQ User Account</a></li>
												</ul>
											</li>
											<?php
										}
										?>
										<?php
										if ($admin_type==2)
										{
											?>											
											<li class="nav-parent<?php echo $administration_nav; ?>">
												<a>
													<i class="fa fa-gear" aria-hidden="true"></i>
													<span>Administration</span>
												</a>
												<ul class="nav nav-children">
													<li><a href="<?php echo site_url('google_ad'); ?>">Google Ads</a></li>
													<li><a href="<?php echo site_url('email_template'); ?>">Email Templates</a></li>
													<?php /*?><li><a href="<?php echo site_url('cq_landing_page/list_view'); ?>">QM Landing Pages</a></li><?php */?>
													<li><a href="<?php echo site_url('fq_landing_page/list_view'); ?>">FQ Landing Pages</a></li>
													<li><a href="<?php echo site_url('logs'); ?>">User Logs</a></li>
													<?php /*?><li><a href="<?php echo site_url('admin/stats'); ?>">QM Stats</a></li><?php */?>
													<li><a href="<?php echo site_url('client'); ?>">Clients</a></li>													
												</ul>
											</li>
											<?php
										}
										?>
										<?php
										// if ($user_id <> 554)
										// {
											?>										
											<!--li class="<?php// echo $quotes_nav; ?>">
												<a href="<?php //echo site_url('quote'); ?>">
													<i class="fa fa-search" aria-hidden="true"></i>
													<span>Quote Search</span>
												</a>
											</li>
											<li class="nav-parent<?php// echo $leads_nav; ?>">
												<a>
													<i class="fa fa-crosshairs" aria-hidden="true"></i>
													<span>QM Leads</span>
												</a>
												<ul class="nav nav-children">
													<li><a href="<?php //echo site_url('lead/new_record'); ?>">Create New</a></li>
													<li><a href="<?php //echo site_url('lead/list_view'); ?>">List View</a></li>
													<li><a href="<?php //echo site_url('lead/reallocations'); ?>">Reallocations</a></li>
												</ul>
											</li-->
											<?php
										//}
										?>
										<?php
										if ($admin_type==3 || $user_id==259)
										{		
											?>
											<li class="nav-parent<?php echo $fleads_nav; ?>">
												<a>
													<i class="fa fa-crosshairs" aria-hidden="true"></i>
													<span>FQ Leads</span>
												</a>
												<ul class="nav nav-children">
												<li><a href="<?php echo site_url('fapplication/fq_new_record'); ?>">Create New</a></li>
												<li><a href="<?php echo site_url('fapplication/list_view'); ?>">List View</a></li>
												</ul>
											</li>											
											<?php
										} ?>
										<?php
										if ($user_id <> 554)
										{
											?>				
											<li class="nav-parent<?php echo $deals_nav; ?>">
												<a>
													<i class="fa fa-dollar" aria-hidden="true"></i>
													<span>Deals</span>
												</a>
												<ul class="nav nav-children">
													<li><a href="<?php echo site_url('deal/tile_view'); ?>">Tile View</a></li>
													<li><a href="<?php echo site_url('deal/list_view'); ?>">List View</a></li>
													<li><a href="<?php echo site_url('invoice'); ?>">Invoices</a></li>
													<li><a href="<?php echo site_url('deal/payments_view'); ?>">Payments</a></li>
												</ul>
											</li>
											<?php
										}
										?>
										<li class="nav-parent<?php echo $tradeins_nav; ?>">
											<a>
												<i class="fa fa-crosshairs" aria-hidden="true"></i>
												<span>Trade-Ins</span>
											</a>
											<ul class="nav nav-children">
												<li><a href="<?php echo site_url('tradein/new_record'); ?>">Create New</a></li>
												<li><a href="<?php echo site_url('tradein/list_view'); ?>">List View</a></li>
											</ul>
										</li>
										<li class="nav-parent<?php echo $tickets_nav; ?>">
											<a>
												<i class="fa fa-ticket" aria-hidden="true"></i>
												<span>Tickets</span>
											</a>
											<ul class="nav nav-children">
												<li><a href="<?php echo site_url('ticket/new_record'); ?>">Create New</a></li>
												<li><a href="<?php echo site_url('ticket/list_view'); ?>">List View</a></li>
											</ul>
										</li>	
										
										<li class="">
											<a href="<?php echo site_url('fapplication/excelDownload'); ?>">
												<i class="fa fa-download" aria-hidden="true"></i>
												<span>Download Reedbook Data</span>
											</a>
										</li>									
										<?php
									}
									else if ($login_type == 4)
									{
										?>
										<li class="nav-active">
											<a href="<?php echo site_url('user/referrals'); ?>">
												<i class="fa fa-home" aria-hidden="true"></i>
												<span>Referrals</span>
											</a>
										</li>
										<li class="">
											<a href="<?php echo site_url('user/logout'); ?>">
												<i class="fa fa-power-off" aria-hidden="true"></i>
												<span>Logout</span>
											</a>
										</li>										
										<?php
									}
									else if ($login_type == 1)
									{
										$home_nav = ""; if ($title=='Home') { $home_nav = " nav-active"; }
										$tenders_nav = ""; if ($title=='Tenders' OR $title=='Quotes') { $tenders_nav = " nav-active"; }			
										$orders_nav = ""; if ($title=='Orders') { $orders_nav = " nav-active"; }

										$profile_nav = ""; 
										if ($title=='Profile' OR $title=='Change Password' OR $title=='Payment Details')
										{
											$profile_nav = " nav-expanded nav-active"; 
										}

										$lead_sales_nav = ""; 
										if ($title=='PMA Protection' OR $title=='Available Leads' OR $title=='Purchased Leads' OR $title=='Transaction History' OR $title=='How Lead Sales Work' OR $title=='Purchase Confirmation')
										{
											$lead_sales_nav = " nav-expanded nav-active"; 
										}
										?>
										<li class="<?php echo $home_nav; ?>">
											<a href="<?php echo site_url('user/home'); ?>">
												<i class="fa fa-home" aria-hidden="true"></i>
												<span>Home</span>
											</a>
										</li>
										<li class="nav-parent<?php echo $profile_nav; ?>">
											<a>
												<i class="fa fa-user" aria-hidden="true"></i>
												<span>User</span>
											</a>
											<ul class="nav nav-children">
												<li><a href="<?php echo site_url('user/profile'); ?>">Profile</a></li>
												<li><a href="<?php echo site_url('user/change_password'); ?>">Change Password</a></li>
											</ul>
										</li>
										<li class="<?php echo $tenders_nav; ?>">
											<a href="<?php echo site_url('user/quotation_requests/0'); ?>">
												<i class="fa fa-tags" aria-hidden="true"></i>
												<span>Quotes</span>
											</a>
										</li>	
																			
										<?php
										if ($user_id == 217 OR 1 == 1)
										{
											?>
											<li class="<?php echo $orders_nav; ?>">
												<a href="<?php echo site_url('user/orders'); ?>">
													<i class="fa fa-car" aria-hidden="true"></i>
													<span>Orders</span>
												</a>
											</li>
											<?php
										}
										?>
										<!--
										<li class="nav-parent<?php echo $lead_sales_nav; ?> nav-expanded">
											<a>
												<i class="fa fa-users" aria-hidden="true"></i>
												<span>
													Leads
												</span>
											</a>
											<ul class="nav nav-children">
												<li><a href="<?php echo site_url('user/pma_protection'); ?>">PMA Protection</a></li>
												<li><a href="<?php echo site_url('user/available_leads'); ?>">Available Leads</a></li>
												<li><a href="<?php echo site_url('user/purchased_leads'); ?>">Purchased Leads</a></li>
												<li><a href="<?php echo site_url('user/transaction_history'); ?>">Transaction History</a></li>
												<li><a href="<?php echo site_url('user/how_lead_sales_work'); ?>">How it Works?</a></li>
											</ul>
										</li>
										-->
									<?php
									}
									else if ($login_type == 3)
									{
										$profile_nav = ""; 
										if ($title=='Profile' OR $title=='Change Password') 
										{
											$profile_nav = " nav-expanded nav-active"; 
										}

										$tradeins_nav = "";
										if ($title=='Trade-In - List View' OR $title=='Trade-In - Tile View')
										{
											$tradeins_nav = " nav-expanded nav-active";
										}
										?>
										<li class="nav-parent<?php echo $profile_nav; ?>">
											<a>
												<i class="fa fa-user" aria-hidden="true"></i>
												<span>Account</span>
											</a>
											<ul class="nav nav-children">
												<li><a href="<?php echo site_url('user/profile'); ?>">Profile</a></li>
												<li><a href="<?php echo site_url('user/change_password'); ?>">Change Password</a></li>
											</ul>
										</li>
										<li class="nav-parent<?php echo $tradeins_nav; ?>">
											<a>
												<i class="fa fa-crosshairs" aria-hidden="true"></i>
												<span>Trade-Ins</span>
											</a>
											<ul class="nav nav-children">
												<li><a href="<?php echo site_url('tradein/list_view'); ?>">List View</a></li>
											</ul>
										</li>
										<?php
									}
									?>
								</ul>
							</nav>
							<?php
							if ($login_type == 1)
							{
								?>
								<!--
								<div class="sidebar-widget widget-tasks" style="margin-top: 10px;">
									<div class="widget-content">
									<div class="alert alert-info fade in nomargin">
										<center>
										<p>Secure your PMA!</p>
										<p><a class="btn btn-primary mt-xs mb-xs" href="<?php echo site_url('user/pma_protection'); ?>">PMA Protect</a></p>
										</center>
									</div>	
									</div>
								</div>
								<div class="sidebar-widget widget-tasks" style="margin-top: 0px;">
									<div class="widget-content">
									<div class="alert alert-primary fade in nomargin">
										<center>
										<h4><b>NEW LEADS</b></h4>
										<p>are available on the Leads Store!</p>
										<p><a class="btn btn-warning mt-xs mb-xs" href="<?php echo site_url('user/available_leads'); ?>">Shop now</a></p>
										</center>
									</div>	
									</div>
								</div>		
								-->
								<?php
							}
							?>
						</div>
					</div>
				</aside>
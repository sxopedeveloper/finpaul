			<aside id="sidebar-right" class="sidebar-right">
				<div class="nano">
					<div class="nano-content">
						<a href="#" class="mobile-close visible-xs">
							Collapse <i class="fa fa-chevron-right"></i>
						</a>
						<div class="sidebar-right-wrapper">
							<!--
							<div class="sidebar-widget widget-calendar">
								<div data-plugin-datepicker data-plugin-skin="dark" ></div>
							</div>
							-->
							<div class="row">
								<div class="col-md-12">
									<p><b>Unactioned Events</b></p>
									<div id="left_sidebar_unactioned_events_container">
										<?php 
										if ($login_type == "Admin")
										{
											echo $left_sidebar_lead_events_html; 
										}
										?>
									</div>
								</div>
							</div>
							<div class="row" style="margin-top: 20px;">
								<div class="col-md-12">
									<p><b>Tenders</b></p>
									<div id="left_sidebar_tenders_container">
										<?php 
										if ($login_type == "Admin")
										{
											echo $left_sidebar_tenders_html; 
										}
										?>										
									</div>
								</div>
							</div>							
						</div>
					</div>
				</div>
			</aside>
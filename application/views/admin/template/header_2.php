					<header class="page-header">
						<h2><?php echo $title; ?></h2>
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="<?php echo site_url(); ?>">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<?php
								$login_type_text = $login_type;
								if ($login_type==1)
								{
									$login_type_text = "Dealer";
								}
								else if ($login_type==3)
								{
									$login_type_text = "Wholesaler";
								}
								?>
							</ol>
							<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
						</div>
					</header>
					<?php
					if ($login_type == "Admin" AND $user_id <> 554)
					{
						?>
						<!-- Tender Carousel -->
						<!--
						<div class="row"> 
							<div class="col-md-12">
								<div class="owl-carousel owl-theme" data-plugin-carousel data-plugin-options='{ "dots": true, "autoplay": true, "autoplayTimeout": 3000, "loop": true, "margin": 10, "nav": false, "responsive": {"0":{"items":1 }, "600":{"items":3 }, "1000":{"items":6 } }  }'>
									<?php
									if (count($tender_alerts)>0)
									{
										foreach ($tender_alerts AS $tender_alert)
										{
											$tender_alert_name_el = "";
											if (strlen($tender_alert['name'])>20)
											{
												$tender_alert_name_el = "..";
											}						
											
											$tender_alert_vehicle_el = "";
											$tender_alert_vehicle = $tender_alert['build_date']." ".$tender_alert['tender_make']." ".$tender_alert['tender_model']." (".$tender_alert['tender_body_type'].")";
											if (strlen($tender_alert_vehicle)>20)
											{
												$tender_alert_vehicle_el = "..";
											}
											?>
											<div class="item">
												<div class="tender_alert alert alert-danger" data-tender_id="<?php echo $tender_alert['id_quote_request']; ?>" style="cursor: pointer; cursor: hand; font-size: 0.9em; margin-right: 4px; margin-bottom: 0px;">
													<strong><?php echo substr($tender_alert['name'], 0, 20).$tender_alert_name_el; ?></strong><br />
													<?php echo substr($tender_alert_vehicle, 0, 20).$tender_alert_vehicle_el; ?>
												</div>
											</div>
											<?php											
										}
									}
									?>
								</div>
								<hr class="solid mt-sm mb-lg">
							</div>	
						</div>
						-->
						<?php
					}
					?>
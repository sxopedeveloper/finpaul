			<footer id="footer">
				<div class="container">
					<div class="row">
						<div class="col-md-3">
							<div class="newsletter">
								<h4><?php echo $company['company_name']; ?></h4>
								<p>
									This service is independent and not influenced, owned or operated by any Manufacturer, Dealer, 
									Distributor or Agent.
								</p>
							</div>
						</div>
						<div class="col-md-3">
							<h4>Business Hours</h4>
							<p>
								<?php echo $company['business_hour']; ?>
							</p>
						</div>
						<div class="col-md-4">
							<div class="contact-details">
								<h4>Contact Us</h4>
								<ul class="contact">
									<li>
										<p>
											<i class="fa fa-phone"></i> <strong>Phone:</strong>
											<?php echo $company['company_phone']; ?>
										</p>
									</li>
									<li>
										<p>
											<i class="fa fa-envelope"></i> <strong>Email:</strong> 
											<a href="mailto:info@qteme.com.au"><?php echo $company['company_email']; ?></a>
										</p>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-md-2">
							<h4>Follow Us</h4>
							<div class="social-icons">
								<ul class="social-icons">
									<li class="facebook">
										<a href="<?php echo $company['social_facebook']; ?>" target="_blank" data-placement="bottom" data-tooltip title="Facebook">Facebook</a>
									</li>
									<li class="googleplus">
										<a href="<?php echo $company['social_google']; ?>" target="_blank" data-placement="bottom" data-tooltip title="Google+">Google+</a>
									</li>
									<li class="youtube">
										<a href="<?php echo $company['social_youtube']; ?>" target="_blank" title="Youtube">Youtube</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="footer-copyright">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<nav id="sub-menu">
									<ul>
										<li>Powered by <a href="http://www.carquotesonline.com.au">Car Quotes Online</a></li>
									</ul>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</footer>
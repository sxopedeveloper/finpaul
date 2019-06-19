			<header id="header" style="background: #fff">
				<div class="container">
					<div class="logo">
						<a href="<?php echo site_url(); ?>">
							<img alt="<?php echo $company['company_name']; ?>" width="275" height="64" data-sticky-width="172" data-sticky-height="40" src="<?php echo $company['company_logo']; ?>" />
						</a>
					</div>
					<div class="search">
						<form id="searchForm" action="" method="get">
							<div class="input-group">
								<input type="text" class="form-control search" name="q" id="q" placeholder="Search..." required>
								<span class="input-group-btn">
									<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
								</span>
							</div>
						</form>
					</div>
					<nav>
						<ul class="nav nav-pills nav-top">
							<li class="phone" style="font-size: 1.7em; top: -5px;">
								<span style="color: #58c603;"><i class="fa fa-phone"></i><?php echo $company['company_phone']; ?></span>
							</li>
						</ul>
					</nav>
					<button class="btn btn-responsive-nav btn-inverse" data-toggle="collapse" data-target=".nav-main-collapse">
						<i class="fa fa-bars"></i>
					</button>
				</div>
				<div class="navbar-collapse nav-main-collapse collapse">
					<div class="container">
						<ul class="social-icons">
							<li class="facebook"><a href="" target="_blank" title="Facebook">Facebook</a></li>
							<li class="googleplus"><a href="" target="_blank" title="Google+">Youtube</a></li>
							<li class="youtube"><a href="" target="_blank" title="Youtube">Youtube</a></li>
						</ul>					
						<nav class="nav-main mega-menu">
							<ul class="nav nav-pills nav-main" id="mainMenu">
								<li>
									<a href="<?php echo site_url('login'); ?>">
										<i class="fa fa-user"></i> &nbsp;Login
									</a>
								</li>
								<li>
									<a href="<?php echo site_url('register'); ?>">
										<i class="fa fa-briefcase"></i> &nbsp;Dealer Registration
									</a>
								</li>
							</ul>
						</nav>
					</div>
				</div>
			</header>
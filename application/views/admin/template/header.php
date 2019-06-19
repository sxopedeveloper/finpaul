			<header class="header">
				<div class="logo-container">
					<a href="<?php echo site_url(); ?>" class="logo">
						<img src="<?php echo $company['company_logo']; ?>" height="35" alt="<?php echo $company['company_name']; ?>" />
					</a>
					<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
						<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
					</div>
				</div>
				<div class="header-right">
					<form action="" class="search nav-form">
						<div class="input-group input-search">
							<input type="text" class="form-control" name="q" id="q" placeholder="Search...">
							<span class="input-group-btn">
								<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
							</span>
						</div>
					</form>
					<span class="separator"></span>
					<ul class="notifications">
						<?php 
						if ($login_type == 'Admin')
						{
							?>
							<li>
								<a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown" onclick="return get_notifications()">
									<i class="fa fa-bell"></i>
									<span class="badge" id="notification_count"></span>
								</a>
								<div class="dropdown-menu notification-menu">
									<div class="notification-title">
										<span class="pull-right label label-default" id="notification_count_label"></span>
										Notifications
									</div>
									<div class="content">
										<ul id="ticket_notifications_content"></ul>
										<hr />
										<div class="text-right">
											<a href="#" class="view-more">View All</a>
										</div>
									</div>
								</div>
							</li>
							<?php
						}
						else if ($login_type == 1)
						{
							?>
							<li>
								<a href="<?php echo site_url('cart'); ?>" class="notification-icon">
									<i class="fa fa-shopping-cart"></i>
									<span class="badge" id="cart_item_count"></span>
								</a>
							</li>
							<li>
								<a href="<?php echo site_url('user/orders'); ?>" class="notification-icon">
									<i class="fa fa-car"></i>
									<span class="badge" id="new_order_count"></span>
								</a>
							</li>							
							<?php
						}
						else if ($login_type == 3)
						{
							
						}
						?>
					</ul>
					<span class="separator"></span>
					<div id="userbox" class="userbox">
						<a href="#" data-toggle="dropdown">
							<figure class="profile-picture">
								<img src="<?php echo base_url('assets/img/!logged-user.jpg'); ?>" alt="<?php echo $name; ?>" class="img-circle" data-lock-picture="<?php echo base_url('assets/img/!logged-user.jpg'); ?>" />
							</figure>
							<div class="profile-info" data-lock-name="<?php echo $name; ?>" data-lock-email="<?php echo $username; ?>">
								<span class="name"><?php echo $name; ?></span>
								<?php
								if ($login_type == 'Admin')
								{
								?>
									<span class="role">QM Staff</span>
								<?php
								}
								else if ($login_type == 1)
								{
								?>
									<span class="role">Dealer</span>
								<?php
								}
								else if ($login_type == 3)
								{
								?>
									<span class="role">Wholesaler</span>
								<?php
								}								
								?>
							</div>
							<i class="fa custom-caret"></i>
						</a>
						<div class="dropdown-menu">
							<ul class="list-unstyled">
								<li class="divider"></li>
								<?php 
								if ($login_type == 'Admin')
								{
								?>
									<li><a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/profile'); ?>"><i class="fa fa-user"></i> My Profile</a></li>
									<li><a role="menuitem" tabindex="-1" href="<?php echo site_url('user/logout'); ?>"><i class="fa fa-power-off"></i> Logout</a></li>
								<?php
								}
								else if ($login_type == 3)
								{
								?>
									<li><a role="menuitem" tabindex="-1" href="<?php echo site_url('user/profile'); ?>"><i class="fa fa-user"></i> My Profile</a></li>
									<li><a role="menuitem" tabindex="-1" href="<?php echo site_url('user/logout'); ?>"><i class="fa fa-power-off"></i> Logout</a></li>
								<?php
								}
								else
								{
									?>
									<li><a role="menuitem" tabindex="-1" href="<?php echo site_url('user/logout'); ?>"><i class="fa fa-power-off"></i> Logout</a></li>
									<?php
								}
								?>
							</ul>
						</div>
					</div>
				</div>
			</header>
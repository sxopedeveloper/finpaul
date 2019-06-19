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
					<img src="<?php echo $thumb_image; ?>">
				</div>
				<div class="profile-info">
					<h4 class="name text-weight-semibold"><b><?php echo $tradein['tradein_make']." ".$tradein['tradein_model']; ?></b></h4>
					<h5 class="role"><?php echo $tradein['tradein_build_date']." ".$tradein['tradein_variant']; ?></h5>
					<div class="profile-footer">
						<?php echo date('d F Y', strtotime($tradein['created_at'])); ?>
					</div>
				</div>
			</div>
		</header>
<div id="accordion">
<div class="panel panel-accordion panel-accordion-first"> <!-- Summary + Buttons -->
	<div class="panel-heading" style="border-bottom: 1px solid #ddd;">
		<h4 class="panel-title">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse_1">
				<b><?php echo $tradein['tradein_make']." ".$tradein['tradein_model']; ?></b>
			</a>
		</h4>
	</div>
	<div id="collapse_1" class="accordion-body collapse in">
		<div class="panel-body">
			<div class="row"> <!-- Tradein Summary -->
				<div class="col-sm-12">
					<h5 style="color: #58c603"><b></b></h5>
					<p></p>
					<?php
					if ($tradein['image_1']=="") { $tradein['image_1'] = "no_image.png"; }
					if ($tradein['image_2']=="") { $tradein['image_2'] = "no_image.png"; }
					if ($tradein['image_3']=="") { $tradein['image_3'] = "no_image.png"; }
					if ($tradein['image_4']=="") { $tradein['image_4'] = "no_image.png"; }														
					?>
					<div class="row"> <!-- Tradein Images -->
						<div class="col-sm-3">
							<a href="http://www.mytradevaluation.com.au/uploads/thumbnails_m/<?php echo $tradein['image_1']; ?>" target="_blank"><img alt="Tradein Image 1" height="300" class="img-responsive" src="http://www.mytradevaluation.com.au/uploads/thumbnails_m/<?php echo $tradein['image_1']; ?>"></a>
						</div>
						<div class="col-sm-3">
							<a href="http://www.mytradevaluation.com.au/uploads/thumbnails_m/<?php echo $tradein['image_2']; ?>" target="_blank"><img alt="Tradein Image 2" height="300" class="img-responsive" src="http://www.mytradevaluation.com.au/uploads/thumbnails_m/<?php echo $tradein['image_2']; ?>"></a>
						</div>
						<div class="col-sm-3">
							<a href="http://www.mytradevaluation.com.au/uploads/thumbnails_m/<?php echo $tradein['image_3']; ?>" target="_blank"><img alt="Tradein Image 3" height="300" class="img-responsive" src="http://www.mytradevaluation.com.au/uploads/thumbnails_m/<?php echo $tradein['image_3']; ?>"></a>
						</div>
						<div class="col-sm-3">
							<a href="http://www.mytradevaluation.com.au/uploads/thumbnails_m/<?php echo $tradein['image_4']; ?>" target="_blank"><img alt="Tradein Image 4" height="300" class="img-responsive" src="http://www.mytradevaluation.com.au/uploads/thumbnails_m/<?php echo $tradein['image_4']; ?>"></a>
						</div>															
					</div>
					<?php 
					if ($login_type=="Admin")
					{
						?>
						<div class="row" style="margin-top: 20px;"> <!-- Tradein Valuations -->
							<div class="col-sm-12">
								<div class="table-responsive">
									<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
										<thead>
											<tr>
												<td><center><i class="fa fa-trash-o"></i></center></td>
												<td><center><i class="fa fa-trophy"></i></center></td>
												<td>Name</td>
												<td>Value</td>
												<td>Date</td>
											</tr>
										</thead>
										<tbody id="tradein_valuations">
											<?php
											if (count($trade_valuations)==0)
											{
												?>
												<tr id="norecords">
													<td colspan="5"><center><i>No valuations found!</i></center></td>
												</tr>																				
												<?php
											}
											else
											{
												foreach ($trade_valuations AS $trade_valuation)
												{																						
													?>																						
													<tr>
														<td>
															<center>
																<!--
																<span class="ajax_button_primary delete_trade_valuation_button" data-id_tradein="<?php echo $tradein['id_tradein']; ?>" data-id_trade_valuation="<?php echo $trade_valuation['id_trade_valuation']; ?>">
																	<i class="fa fa-trash-o"></i>
																</span>
																-->
																<i class="fa fa-trash-o"></i>
															</center>
														</td>
														<?php
														if ($tradein['id_trade_valuation']==$trade_valuation['id_trade_valuation']) 
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
																<span class="ajax_button_primary select_winning_trade_valuation_button" data-id_tradein="<?php echo $tradein['id_tradein']; ?>" data-id_trade_valuation="<?php echo $trade_valuation['id_trade_valuation']; ?>">
																	<i class="fa fa-trophy"></i>
																</span>																																												
															</td>
															<?php																							
														}
														?>
														<td><a href="<?php echo site_url('user/record/'.$trade_valuation['id_user']); ?>"><?php echo $trade_valuation['name']; ?></a></td>
														<td><?php echo $trade_valuation['value']; ?></td>
														<td><?php echo $trade_valuation['created_at']; ?></td>
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
						<?php
					}
					else
					{
						if ($user_trade_valuation_id==0)
						{
							?>
							<div class="row" style="margin-top: 20px;">
								<div class="col-sm-12">
									<div class="alert alert-danger">
										You haven't valued this vehicle yet!
										<br />
										<br />
										<span class="btn btn-danger btn-sm ajax_button add_trade_valuation_modal_button" data-id_tradein="<?php echo $tradein['id_tradein']; ?>">
											<i class="fa fa-dollar"></i>&nbsp; VALUE THIS CAR
										</span>
									</div>
								</div>
							</div>
							<?php
						}
						else
						{
							?>
							<div class="row" style="margin-top: 20px;">
								<div class="col-sm-12">
									<div class="alert alert-danger">
										Thank you for sending your valuation!
										<br />
										<br />
										<span class="btn btn-danger btn-sm ajax_button edit_trade_valuation_modal_button" data-id_tradein="<?php echo $tradein['id_tradein']; ?>" data-id_trade_valuation="<?php echo $user_trade_valuation_id; ?>">
											<i class="fa fa-dollar"></i>&nbsp; CHANGE VALUE
										</span>																			
									</div>
								</div>
							</div>
							<?php																
						}
					}
					?>
				</div>
			</div>
			<br />
		</div>
	</div>
				<?php 
				if ($login_type=="Admin")
				{
					?>
					<div class="panel-footer panel-footer-btn-group"> <!-- Actions -->
						<a href="#" style="border-top: 1px solid #ddd;" class="add_trade_valuation_modal_button" data-id_tradein="<?php echo $tradein['id_tradein']; ?>">
							<i class="fa fa-dollar mr-xs"></i> Add Valuation
						</a>
						<a href="<?php echo site_url('tradein/pdf_export/'.$tradein['id_tradein']); ?>" target="_blank" style="border-top: 1px solid #ddd;">
							<i class="fa fa-file-pdf-o"></i> PDF Export
						</a>
						<a href="#" style="border-top: 1px solid #ddd;" class="forward_pdf_modal_button" data-id_tradein="<?php echo $tradein['id_tradein']; ?>">
							<i class="fa fa-envelope mr-xs"></i> Forward PDF
						</a>
					</div>
					<?php
				}
				?>
			</div>
			<?php 
			if ($login_type=="Admin")
			{
				?>			
				<div class="panel panel-accordion"> <!-- Comments -->
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse_2">
								 <i class="fa fa-comment"></i> Comments (<span id="comment_count"><?php echo count($comments); ?></span>)
							</a>
						</h4>
					</div>
					<div id="collapse_2" class="accordion-body collapse">
						<div class="panel-body">
							<ul class="simple-user-list mb-xlg">
								<?php 
								if (count($comments)==0)
								{
									?>
									<li id="norecords"><center><p>No records found!</p></center></li>
									<?php
								}
								else
								{
									foreach ($comments AS $comment)
									{
										?>
										<li>
											<figure class="image rounded">
												<img src="<?php echo base_url('assets/img/!sample-user.jpg'); ?>" alt="<?php echo $comment['sender'];?>" class="img-circle">
											</figure>
											<span class="title">
												<?php echo $comment['sender'];?>
											</span>
											<span class="message">
												<?php echo $comment['comment'];?>
												<br />
												<span style="font-size: 0.8em;"><?php echo date('d F Y', strtotime($comment['created_at'])); ?></span>
											</span>
										</li>														
										<?php
									}
								}
								?>
							</ul>
						</div>
					</div>
				</div>
				<div class="panel panel-accordion"> <!-- Activity -->
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse_3">
								 <i class="fa fa-comment"></i> Activity (<span id="audit_trail_count"><?php echo count($audit_trails); ?></span>)
							</a>
						</h4>
					</div>
					<div id="collapse_3" class="accordion-body collapse">
						<div class="panel-body">
							<?php
							if (count($audit_trails)==0)
							{
								?>
								<center><p>No records found!</p></center><br />
								<?php													
							}
							else
							{
								$html = '';
								foreach ($audit_trails AS $audit_trail)
								{

								}
								echo $html;
							}
							?>
						</div>
					</div>
				</div>
				<?php
			}
			?>
</div>
	</section>
	<div class="toogle" data-plugin-toggle="">
		<section class="toggle active"> <!-- Details -->
			<label>Details</label>
			<div class="toggle-content">
				<section class="panel">
					<form method="post" id="details_form" name="details_form" action="">
						<input type="hidden" name="id_tradein" value="<?php echo $tradein['id_tradein']; ?>" />
						<div class="panel-body">
							<?php
							if ($login_type != "Admin")
							{
								$details_disabled = 'disabled="disabled"';
							}
							else
							{
								$details_disabled = '';
							}
							
							if ($login_type == "Admin")
							{
								?>
								<div id="client_details"> <!-- Client Details -->
									<div class="row">
										<div class="col-md-12">
											<h5><b>Client Details</b></h5>
											<hr class="solid mt-sm mb-lg">
										</div>
									</div>
									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label class="control-label">First Name:</label><br />
												<input value="<?php echo $tradein['first_name']; ?>" class="text-line" id="first_name" name="first_name" type="text">
											</div>													
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label class="control-label">Last Name:</label><br />
												<input value="<?php echo $tradein['last_name']; ?>" class="text-line" id="last_name" name="last_name" type="text">
											</div>
										</div>													
										<div class="col-sm-4">
											<div class="form-group">
												<label class="control-label">Email Address:</label><br />
												<input value="<?php echo $tradein['email']; ?>" class="text-line" id="email" name="email" type="text">
											</div>													
										</div>														
									</div>
									<div class="row" style="margin-top: 10px;">
										<div class="col-sm-4">
											<div class="form-group">
												<label class="control-label">Phone:</label><br />
												<input value="<?php echo $tradein['phone']; ?>" class="text-line" id="phone" name="phone" type="text">
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label class="control-label">State:</label><br />
												<select class="text-line" id="state" name="state">
													<option value=""></option>
													<option value="ACT" <?php echo (($tradein["state"]=="ACT") ? "selected" : ""); ?> >Australian Capital Territory</option>
													<option value="NSW" <?php echo (($tradein["state"]=="NSW") ? "selected" : ""); ?> >New South Wales</option>
													<option value="NT" <?php echo (($tradein["state"]=="NT") ? "selected" : ""); ?> >Northern Territory</option>
													<option value="QLD" <?php echo (($tradein["state"]=="QLD") ? "selected" : ""); ?> >Queensland</option>
													<option value="SA" <?php echo (($tradein["state"]=="SA") ? "selected" : ""); ?> >South Australia</option>
													<option value="TAS" <?php echo (($tradein["state"]=="TAS") ? "selected" : ""); ?> >Tasmania</option>
													<option value="VIC" <?php echo (($tradein["state"]=="VIC") ? "selected" : ""); ?> >Victoria</option>
													<option value="WA"  <?php echo (($tradein["state"]=="WA") ? "selected" : ""); ?> >Western Australia</option>
												</select>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label class="control-label">Postcode:</label><br />
												<input value="<?php echo $tradein['postcode']; ?>" class="text-line" id="postcode" name="postcode" type="text">
											</div>
										</div>		
									</div>														
								</div>
								<?php
							}
							?>
							<div id="vehicle_details"> <!-- Vehicle Details -->
								<div class="row" style="margin-top: 30px;">
									<div class="col-md-12">
										<h5><b>Vehicle Details</b></h5>
										<hr class="solid mt-sm mb-lg">
									</div>
								</div>
								<div class="row">
									
									<div class="col-sm-4">
										<div class="form-group">
											<label class="control-label">Registration Plate:</label><br />
											<input value="<?php echo $tradein['registration_plate']; ?>" class="text-line" id="registration_plate" name="registration_plate" type="text" <?php echo $details_disabled; ?>>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label class="control-label">Rego Expiry:</label><br />
											<input value="<?php echo $tradein['rego_expiry']; ?>" class="text-line" id="rego_expiry" name="rego_expiry" type="text" <?php echo $details_disabled; ?>>
										</div>
									</div>					
								</div>
								<div class="row" style="margin-top: 10px;">														
									<div class="col-sm-4">
										<div class="form-group">
											<label class="control-label">VIN:</label><br />
											<input value="<?php echo $tradein['tradein_vin']; ?>" class="text-line" id="tradein_vin" name="tradein_vin" type="text" <?php echo $details_disabled; ?>>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label class="control-label">Engine Number:</label><br />
											<input value="<?php echo $tradein['tradein_eng']; ?>" class="text-line" id="tradein_eng" name="tradein_eng" type="text" <?php echo $details_disabled; ?>>
										</div>
									</div>														
								</div>										
								<div class="row" style="margin-top: 40px;">
									<div class="col-sm-4">
										<div class="form-group">
											<label class="control-label">Make:</label><br />
											<input value="<?php echo $tradein['tradein_make']; ?>" class="text-line" id="tradein_make" name="tradein_make" type="text" <?php echo $details_disabled; ?>>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label class="control-label">Model:</label><br />
											<input value="<?php echo $tradein['tradein_model']; ?>" class="text-line" id="tradein_model" name="tradein_model" type="text" <?php echo $details_disabled; ?>>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label class="control-label">Variant:</label><br />
											<input value="<?php echo $tradein['tradein_variant']; ?>" class="text-line" id="tradein_variant" name="tradein_variant" type="text" <?php echo $details_disabled; ?>>
										</div>
									</div>														
								</div>
								<div class="row" style="margin-top: 10px;">												
									<div class="col-sm-4">
										<div class="form-group">
											<label class="control-label">Build Date:</label><br />
											<input value="<?php echo $tradein['tradein_build_date']; ?>" class="text-line" id="tradein_build_date" name="tradein_build_date" type="text" <?php echo $details_disabled; ?>>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label class="control-label">Compliance Date:</label><br />
											<input value="<?php echo $tradein['tradein_compliance_date']; ?>" class="text-line" id="tradein_compliance_date" name="tradein_compliance_date" type="text" <?php echo $details_disabled; ?>>
										</div>
									</div>		
									<div class="col-sm-4">
										<div class="form-group">
											<label class="control-label">Kms:</label><br />
											<input value="<?php echo $tradein['tradein_kms']; ?>" class="text-line" id="tradein_kms" name="tradein_kms" type="text" <?php echo $details_disabled; ?>>
										</div>
									</div>														
								</div>
								<div class="row" style="margin-top: 10px;">												
									<div class="col-sm-4">
										<div class="form-group">
											<label class="control-label">Fuel Type:</label><br />
											<input value="<?php echo $tradein['tradein_fuel_type']; ?>" class="text-line" id="tradein_fuel_type" name="tradein_fuel_type" type="text" <?php echo $details_disabled; ?>>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label class="control-label">Body Shape:</label><br />
											<input value="<?php echo $tradein['tradein_body_type']; ?>" class="text-line" id="tradein_body_type" name="tradein_body_type" type="text" <?php echo $details_disabled; ?>>
										</div>
									</div>		
									<div class="col-sm-4">
										<div class="form-group">
											<label class="control-label">Colour:</label><br />
											<input value="<?php echo $tradein['tradein_colour']; ?>" class="text-line" id="tradein_colour" name="tradein_colour" type="text" <?php echo $details_disabled; ?>>
										</div>
									</div>														
								</div>													
								<div class="row" style="margin-top: 10px;">												
									<div class="col-sm-4">
										<div class="form-group">
											<label class="control-label">Drive Type:</label><br />
											<input value="<?php echo $tradein['tradein_drive_type']; ?>" class="text-line" id="tradein_drive_type" name="tradein_drive_type" type="text" <?php echo $details_disabled; ?>>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label class="control-label">Transmission:</label><br />
											<input value="<?php echo $tradein['tradein_transmission']; ?>" class="text-line" id="tradein_transmission" name="tradein_transmission" type="text" <?php echo $details_disabled; ?>>
										</div>
									</div>														
								</div>		
								<div class="row" style="margin-top: 30px;">												
									<div class="col-sm-12">		
										<div class="form-group">
											<label class="control-label">Vehicle Options:</label><br />														
											<input value="<?php echo $tradein['options_1']; ?>" class="text-line" id="options_1" name="options_1" type="text" <?php echo $details_disabled; ?>>
										</div>
									</div>
								</div>						
								<div class="row" style="margin-top: 30px;">												
									<div class="col-sm-12">		
										<div class="form-group">
											<label class="control-label">Accessories:</label><br />														
											<input value="<?php echo $tradein['accessories_1']; ?>" class="text-line" id="accessories_1" name="accessories_1" type="text" <?php echo $details_disabled; ?>>
										</div>
									</div>
								</div>
								<div class="row" style="margin-top: 30px;">
									<div class="col-sm-9">		
										Warning lights while vehicle is running?
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<select class="text-line" id="warning_lights" name="warning_lights" <?php echo $details_disabled; ?>>
												<option value=""></option>
												<option value="Yes" <?php echo (($tradein["warning_lights"]=="Yes") ? "selected" : ""); ?> >Yes</option>
												<option value="No" <?php echo (($tradein["warning_lights"]=="No") ? "selected" : ""); ?> >No</option>
											</select>
										</div>
									</div>
								</div>																			
								<div class="row" style="margin-top: 10px;">
									<div class="col-sm-9">		
										Is there existing damage on the vehicle?
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<select class="text-line" id="damage" name="damage" <?php echo $details_disabled; ?>>
												<option value=""></option>
												<option value="Yes" <?php echo (($tradein["damage"]=="Yes") ? "selected" : ""); ?> >Yes</option>
												<option value="No" <?php echo (($tradein["damage"]=="No") ? "selected" : ""); ?> >No</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row" style="margin-top: 10px;">
									<div class="col-sm-9">		
										Was your vehicle ever a lease or rental?
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<select class="text-line" id="lease" name="lease" <?php echo $details_disabled; ?>>
												<option value=""></option>
												<option value="Yes" <?php echo (($tradein["lease"]=="Yes") ? "selected" : ""); ?> >Yes</option>
												<option value="No" <?php echo (($tradein["lease"]=="No") ? "selected" : ""); ?> >No</option>
											</select>
										</div>
									</div>
								</div>															
								<div class="row" style="margin-top: 10px;">
									<div class="col-sm-9">		
										Did you buy the vehicle new?
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<select class="text-line" id="bought_new" name="bought_new" <?php echo $details_disabled; ?>>
												<option value=""></option>
												<option value="Yes" <?php echo (($tradein["bought_new"]=="Yes") ? "selected" : ""); ?> >Yes</option>
												<option value="No" <?php echo (($tradein["bought_new"]=="No") ? "selected" : ""); ?> >No</option>
											</select>
										</div>
									</div>
								</div>		
								<div class="row" style="margin-top: 10px;">
									<div class="col-sm-9">		
										Do all the options & accessories work?
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<select class="text-line" id="accessories_working" name="accessories_working" <?php echo $details_disabled; ?>>
												<option value=""></option>
												<option value="Yes" <?php echo (($tradein["accessories_working"]=="Yes") ? "selected" : ""); ?> >Yes</option>
												<option value="No" <?php echo (($tradein["accessories_working"]=="No") ? "selected" : ""); ?> >No</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row" style="margin-top: 10px;">
									<div class="col-sm-9">		
										Has vehicle ever been in any accident?
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<select class="text-line" id="accident" name="accident" <?php echo $details_disabled; ?>>
												<option value=""></option>
												<option value="Yes" <?php echo (($tradein["accident"]=="Yes") ? "selected" : ""); ?> >Yes</option>
												<option value="No" <?php echo (($tradein["accident"]=="No") ? "selected" : ""); ?> >No</option>
											</select>
										</div>
									</div>
								</div>

								<div class="row" style="margin-top: 10px;">
									<div class="col-sm-9">		
										Has vehicle ever had any paint work?
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<select class="text-line" id="paint_work" name="paint_work" <?php echo $details_disabled; ?>>
												<option value=""></option>
												<option value="Yes" <?php echo (($tradein["paint_work"]=="Yes") ? "selected" : ""); ?> >Yes</option>
												<option value="No" <?php echo (($tradein["paint_work"]=="No") ? "selected" : ""); ?> >No</option>
											</select>
										</div>
									</div>
								</div>													
								<div class="row" style="margin-top: 30px;">												
									<div class="col-sm-12">		
										<div class="form-group">
											<label class="control-label">Service History:</label><br />														
											<textarea class="form-control input-sm" id="tradein_service_history" name="tradein_service_history" <?php echo $details_disabled; ?>><?php echo $tradein['tradein_service_history']; ?></textarea>
										</div>
									</div>
								</div>
								<div class="row" style="margin-top: 10px;">												
									<div class="col-sm-12">		
										<div class="form-group">
											<label class="control-label">Other Information:</label><br />														
											<textarea class="form-control input-sm" id="other_info" name="other_info" <?php echo $details_disabled; ?>><?php echo $tradein['other_info']; ?></textarea>
										</div>
									</div>
								</div>
								<br />
								<?php
								if ($login_type == "Admin")
								{
									?>														
									<div class="row" style="margin-top: 10px;">
										<div class="col-sm-12">
											<button type="submit" class="btn btn-primary">
												<i class="fa fa-save"></i> Save
											</button>																													
										</div>
									</div>	
									<?php
								}
								?>															
							</div>
						</div>
					</form>
				</section>
			</div>
		</section>
		<?php 
		if ($login_type == "Admin")
		{
			?>								
			<section class="toggle active"> <!-- Pickup Details -->
				<label>Pickup Details</label>
				<div class="toggle-content">
					<section class="panel">
						<form method="post" id="pickup_details_form" name="pickup_details_form" action="">
							<input type="hidden" name="id_tradein" value="<?php echo $tradein['id_tradein']; ?>" />
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-12">						
										<p>Calculated Total Payment Amount: <?php echo $tradein['real_total_payment_amount']; ?> AUD</p>
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
												<tbody>
													<tr>
														<td width="50%"><b>Total Payment Amount:</b></td>
														<td><input value="<?php echo $tradein['total_payment_amount']; ?>" id="total_payment_amount" name="total_payment_amount" class="form-control input-sm" type="text"></td>
													</tr>
													<tr>
														<td><b>Dealer Payment:</b></td>
														<td><input value="<?php echo $tradein['dealer_payment']; ?>" id="dealer_payment" name="dealer_payment" class="form-control input-sm" type="text"></td>
													</tr>
													<tr>
														<td><b>Client Payment:</b></td>
														<td><input value="<?php echo $tradein['client_payment']; ?>" id="client_payment" name="client_payment" class="form-control input-sm" type="text"></td>
													</tr>
												</tbody>
											</table>
										</div>
										<br />
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
												<tbody>
													<tr>
														<td width="50%"><b>Bank Details:</b></td>
														<td><input value="<?php echo $tradein['bank_details']; ?>" id="bank_details" name="bank_details" class="form-control input-sm" type="text"></td>
													</tr>
													<tr>
														<td><b>Bank Account:</b></td>
														<td><input value="<?php echo $tradein['bank_account']; ?>" id="bank_account" name="bank_account" class="form-control input-sm" type="text"></td>
													</tr>
													<tr>
														<td><b>BSB:</b></td>
														<td><input value="<?php echo $tradein['bsb']; ?>" id="bsb" name="bsb" class="form-control input-sm" type="text"></td>
													</tr>
													<tr>
														<td><b>Reference:</b></td>
														<td><input value="<?php echo $tradein['reference']; ?>" id="reference" name="reference" class="form-control input-sm" type="text"></td>
													</tr>
													<tr>
														<td><b>PPSR:</b></td>
														<td><input value="<?php echo $tradein['ppsr']; ?>" id="ppsr" name="ppsr" class="form-control input-sm" type="text"></td>
													</tr>
												</tbody>
											</table>
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
				</div>
			</section>
			<section class="toggle active"> <!-- Payment Instructions -->
				<label>Payment Instructions</label>
				<div class="toggle-content">
					<section class="panel">
						<form method="post" id="payment_instructions_form" name="payment_instructions_form" action="">
							<input type="hidden" name="id_tradein" value="<?php echo $tradein['id_tradein']; ?>" />
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<label class="control-label">Pickup Date:</label><br />
											<input value="<?php echo $tradein['pickup_date']; ?>" class="text-line datepicker" id="pickup_date" name="pickup_date" data-date-format="yyyy-mm-dd" type="text">
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label class="control-label">Pickup Time:</label><br />
											<input value="<?php echo $tradein['pickup_time']; ?>" class="text-line timepicker" id="pickup_time" name="pickup_time" type="text">
										</div>
									</div>
								</div>
								<div class="row" style="margin-top: 10px;">
									<div class="col-sm-4">
										<div class="form-group">
											<label class="control-label">Name of Contact:</label><br />
											<input value="<?php echo $tradein['contact_name']; ?>" class="text-line" id="contact_name" name="contact_name" type="text">
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label class="control-label">Contact Number:</label><br />
											<input value="<?php echo $tradein['contact_number']; ?>" class="text-line" id="contact_number" name="contact_number" type="text">
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label class="control-label">Pickup Address:</label><br />
											<input value="<?php echo $tradein['pickup_address']; ?>" class="text-line" id="pickup_address" name="pickup_address" type="text">
										</div>
									</div>														
								</div>	
								<div class="row" style="margin-top: 10px;">
									<div class="col-sm-12">
										<div class="form-group">
											<label class="control-label">Special Request:</label><br />
											<input value="<?php echo $tradein['special_request']; ?>" class="text-line" id="special_request" name="special_request" type="text">
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
				</div>
			</section>
			<?php
		}
		?>
	</div>							
</div>
<div class="col-md-4">
	<?php 
	if ($login_type == "Admin")
	{
		?>						
		<section class="panel panel-featured-left panel-featured-primary"> <!-- Highest Valuation -->
			<div class="panel-body">
				<div class="widget-summary widget-summary-sm">
					<div class="widget-summary-col widget-summary-col-icon">
						<div class="summary-icon bg-primary">
							<i class="fa fa-life-ring"></i>
						</div>
					</div>
					<div class="widget-summary-col">
						<div class="summary">
							<h4 class="title">Highest Valuation</h4>
							<div class="info">
								<strong class="amount"><?php echo number_format($tradein['winning_valuation'], 2); ?></strong>
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
		<section class="panel panel-featured-left panel-featured-primary"> <!-- Winning Wholesaler -->
			<div class="panel-body">
				<div class="widget-summary widget-summary-sm">
					<div class="widget-summary-col widget-summary-col-icon">
						<div class="summary-icon bg-primary">
							<i class="fa fa-life-ring"></i>
						</div>
					</div>
					<div class="widget-summary-col">
						<div class="summary">
							<h4 class="title">Winning Wholesaler</h4>
							<div class="info">
								<strong class="amount"><?php echo $tradein['buyer_name']; ?></strong>
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
				<input type="hidden" name="id_tradein" value="<?php echo $tradein['id_tradein']; ?>" />
				<div class="panel-body">
					<textarea class="form-control input-sm" name="details"><?php echo $tradein['details']; ?></textarea>
				</div>								
				<div class="panel-footer">
					<button type="submit" class="btn btn-default btn-outline">
						<i class="fa fa-save"></i> Save
					</button>										
				</div>
			</form>
		</section>				
		<section class="panel" id="tradein_files_section"> <!-- Files -->
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h2 class="panel-title">
					<i class="fa fa-file"></i>&nbsp;
					Files (<span id="tradein_file_count"><?php echo count($tradein_files); ?></span>)
				</h2>
			</header>
			<div class="panel-body">
				<?php
				if (count($tradein_files)==0)
				{
					echo "<center>No records found!</center>";
				}
				?>
			</div>
			<!--
			<div class="panel-footer">
				<span class="btn btn-default btn-sm" style="cursor: pointer; cursor: hand;">
					Upload File
				</span>
			</div>									
			-->
		</section>								
		<?php
	}
	else
	{
		?>
		<section class="panel panel-featured-left panel-featured-primary"> <!-- My Valuation -->
			<div class="panel-body">
				<div class="widget-summary widget-summary-sm">
					<div class="widget-summary-col widget-summary-col-icon">
						<div class="summary-icon bg-primary">
							<i class="fa fa-life-ring"></i>
						</div>
					</div>
					<div class="widget-summary-col">
						<div class="summary">
							<h4 class="title">My Valuation</h4>
							<div class="info">
								<strong class="amount" id="user_trade_valuation"><?php echo $user_trade_valuation; ?></strong>
								<span class="text-primary"></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="panel"> <!-- Service History -->
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>
				<h2 class="panel-title">
					<i class="fa fa-book"></i>&nbsp;
					Service History
				</h2>
			</header>
			<div class="panel-body">
				<?php 
				if ($tradein['tradein_service_history']=="")
				{
					echo "N/A";
				}
				else
				{
					echo $tradein['tradein_service_history']; 
				}
				?>
			</div>
		</section>							
		<?php
	}
	?>							
	<?php 
	if ($login_type == "Admin")
	{
		?>
	
		<?php
	}
	?>
	<section class="panel"> <!-- Same Make Tradein -->
		<header class="panel-heading">
			<div class="panel-actions">
				<a href="#" class="fa fa-caret-down"></a>
			</div>
			<h2 class="panel-title">
				<i class="fa fa-book"></i>&nbsp;
				Other Tradeins
			</h2>
		</header>
		<div class="panel-body">
			<ul class="simple-user-list mb-xlg">
				<?php 											
				if (count($same_make_tradeins)==0)
				{
					?>
					<li id="norecords"><center><p>No records found!</p></center></li>
					<?php
				}
				else
				{
					foreach ($same_make_tradeins AS $same_make_tradein_index => $same_make_tradein)
					{
						if ($same_make_tradein_index > 0)
						{
							$hr = '<hr class="solid mt-sm mb-lg">';
						}
						else
						{
							$hr = '';
						}													
						
						if ($same_make_tradein['image_1']=="") { $same_make_tradein['image_1'] = "no_image.png"; }
						?>
						<li>
							<?php echo $hr; ?>
							<figure class="image rounded">
								<a href="<?php echo site_url('tradein/record_final/'.$same_make_tradein['id_tradein']); ?>" target="_blank">
									<img style="width: 35px; height: 35px;" src="http://www.mytradevaluation.com.au/uploads/thumbnails_m/<?php echo $same_make_tradein['image_1']; ?>" alt="<?php echo $same_make_tradein['tradein_make']." ".$same_make_tradein['tradein_model']; ?>" class="img-circle">
								</a>
							</figure>
							<span class="title">
								<a href="<?php echo site_url('tradein/record_final/'.$same_make_tradein['id_tradein']); ?>" target="_blank">
									<?php echo $same_make_tradein['tradein_make']." ".$same_make_tradein['tradein_model']; ?> 
								</a>
								<br />
								<span style="font-size: 0.8em;"><?php echo $same_make_tradein['tradein_variant']; ?></span>
							</span>
						</li>												
						<?php
					}												
				}
				?>
		</div>
		</form>
	</section>								
</div>						
</div>
<!-- end: page -->
<?php include 'modals/ticket_modals.php'; ?>
<div id="add_trade_valuation_modal" class="modal fade"> <!-- Add Trade Valuation Modal -->
<div class="modal-dialog" style="width: 80%;">
	<section class="panel">
		<form method="post" id="add_trade_valuation_form" name="add_trade_valuation_form" action="">
			<input type="hidden" id="id_tradein" name="id_tradein" value="<?php echo $tradein['id_tradein']; ?>">
			<div class="panel-body">
				<div class="modal-wrapper">
					<div class="modal-text">
						<div class="row">
							<div class="col-md-12 text-center">
								<h4 id="label_1" style="line-height: 1px;"></h4>
								<p id="label_2" style="color: #cccccc; font-size: 0.9em;"></p>
								<hr class="solid mt-sm mb-lg">							
							</div>
						</div>
						<?php
						if ($login_type=="Admin")
						{
							?>
							<div class="row">
								<div class="col-md-12">
									<div style="padding: 20px; border: 1px solid #ddd;">
										<div class="row">
											<div class="col-md-12">
												<div class="alert alert-info">
													<p>Please indicate the user who is valuing the vehicle</p>
												</div>
												<input class="form-control input-md" id="name" type="text" value="" autocomplete="off" placeholder="Name" onKeyPress="load_users('add_trade_valuation_modal')"><br />
											</div>
											<div class="col-md-12" id="users"></div>
											<div class="col-md-12">
												<br />
												<table class="table table-bordered table-striped table-condensed mb-none">
													<thead>
														<tr>
															<td colspan="3"><b>Selected User</b></td>
														</tr>
													</thead>
													<tbody id="selected_user">
														<tr class="norecord"><td colspan="3"><center>No user is selected!</center></td></tr>
													</tbody>																		
												</table>
											</div>															
										</div>
									</div>
								</div>
							</div>													
							<?php
						}
						?>
						<div class="row" style="margin-top: 30px;">													
							<div class="col-md-12">
								<div style="padding: 20px; border: 1px solid #ddd;">
									<div class="form-group">
										<div class="alert alert-info">
											<p>Enter the value of the vehicle</p>
										</div>
										<input class="form-control input-md" id="value" name="value" type="text" onKeyPress="return isNumberKey(event)">
									</div>
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
<div id="edit_trade_valuation_modal" class="modal fade"> <!-- Edit Trade Valuation Modal -->
<div class="modal-dialog" style="width: 80%;">
	<section class="panel">
		<form method="post" id="edit_trade_valuation_form" name="edit_trade_valuation_form" action="">
			<input type="hidden" id="id_tradein" name="id_tradein" value="<?php echo $tradein['id_tradein']; ?>">
			<input type="hidden" id="id_trade_valuation" name="id_trade_valuation" value="">
			<div class="panel-body">
				<div class="modal-wrapper">
					<div class="modal-text">
						<div class="row">
							<div class="col-md-12 text-center">
								<h4 id="label_1" style="line-height: 1px;"></h4>
								<p id="label_2" style="color: #cccccc; font-size: 0.9em;"></p>
								<hr class="solid mt-sm mb-lg">							
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">													
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label">Value:</label>							
									<input class="form-control input-md" id="value" name="value" type="text" onKeyPress="return isNumberKey(event)">
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
<div id="forward_pdf_modal" class="modal fade"> <!-- Send Email Modal -->
<div class="modal-dialog" style="width: 80%;">
	<section class="panel">
		<form method="post" id="forward_pdf_form" name="forward_pdf_form" action="">
			<input type="hidden" id="idtradein" name="id_tradein" >
			<div class="panel-body">
				<div class="modal-wrapper">
					<div class="modal-text">
						<div class="row">
							<div class="col-md-12 text-center">
								<h4 id="label_1" style="line-height: 1px;"></h4>
								<p id="label_2" style="color: #cccccc; font-size: 0.9em;"></p>
								<hr class="solid mt-sm mb-lg">
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-md-12">
								<div class="container_bordered_round">
									<div class="row">
										<div class="col-md-12">
											<h5></h5>
											<div class="row" style="margin-top: 10px;">
												<div class="col-md-12">																
													<div class="form-group">
														<select class="text-line" id="" name="">
															<option value=""></option>
															<option value="" <?php echo ""; ?> ></option>
															<option value="" <?php echo ""; ?> ></option>
														</select>
													</div>
												</div>																		
											</div>
										</div>
									</div>														
									<div class="row">
										<div class="col-md-12">
											<h5>Recipient:</h5>
											<div class="row" style="margin-top: 10px;">
												<div class="col-md-12">																
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
												<i class="fa fa-check"></i> Tradein Details PDF <br />
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
</section>
</div>
<?php include 'template/right_sidebar.php'; ?>
</section>
<?php include 'template/scripts.php'; ?>
<script>
function load_users (container)
{
var name = $("#"+container).find("#name").val();

if (name.length > 2)
{
var data = {
container: container,
name: name
};				

$.ajax({
type: "POST",
url: "<?php echo site_url("user/generate_users_html"); ?>",
data: data,
cache: false,
success: function(response){
	$("#"+container).find("#users").html("");
	$("#"+container).find("#users").append(response);
}
});					
}
else
{
$("#"+container).find("#users").html("");
}
}

function select_user (container, id_user)
{
var type = $("#"+container).find("#type_"+id_user).html();
var email = $("#"+container).find("#email_"+id_user).html();
var name = $("#"+container).find("#name_"+id_user).html();

$("#"+container).find("#selected_user .norecord").prop("hidden", true);
$("#"+container).find("#selected_user").html('<tr><td><input type="hidden" value="'+id_user+'" id="id_user" name="id_user">'+type+'</td><td>'+name+'</td><td>'+email+'</td></tr>');
}		

$(".select_winning_trade_valuation_button").click(function(e) {
var id_tradein = $(this).data("id_tradein");
var id_trade_valuation = $(this).data("id_trade_valuation");

var data = {
id_tradein: id_tradein,
id_trade_valuation: id_trade_valuation
};

$.ajax({
type: "POST",
url: "<?php echo site_url("tradein/select_winner"); ?>",
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

$(".delete_trade_valuation_button").click(function(e) {
var id_tradein = $(this).data("id_tradein");
var id_trade_valuation = $(this).data("id_trade_valuation");

var data = {
id_tradein: id_tradein,
id_trade_valuation: id_trade_valuation
};				

$.ajax({
type: "POST",
url: "<?php echo site_url("tradein/delete_trade_valuation"); ?>",
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

// MODAL OPENERS (Start) //
$(".add_trade_valuation_modal_button").click(function(e) {
var make = $("#details_form").find("#tradein_make").val();
var model = $("#details_form").find("#tradein_model").val();
var variant = $("#details_form").find("#tradein_variant").val();
$("#add_trade_valuation_form").find("#label_1").html(make+" "+model);
$("#add_trade_valuation_form").find("#label_2").html(variant);

var id_tradein = $(this).data("id_tradein");

$("#add_trade_valuation_form").find("#id_tradein").val(id_tradein);
$("#add_trade_valuation_modal").modal();
});

$(".edit_trade_valuation_modal_button").click(function(e) {
var make = $("#details_form").find("#tradein_make").val();
var model = $("#details_form").find("#tradein_model").val();
var variant = $("#details_form").find("#tradein_variant").val();
$("#edit_trade_valuation_form").find("#label_1").html(make+" "+model);
$("#edit_trade_valuation_form").find("#label_2").html(variant);

var id_tradein = $(this).data("id_tradein");
var id_trade_valuation = $(this).data("id_trade_valuation");
var trade_valuation = $("#user_trade_valuation").html();

$("#edit_trade_valuation_form").find("#id_tradein").val(id_tradein);
$("#edit_trade_valuation_form").find("#id_trade_valuation").val(id_trade_valuation);
$("#edit_trade_valuation_form").find("#value").val(trade_valuation);
$("#edit_trade_valuation_modal").modal();
});					

$(".forward_pdf_modal_button").click(function(e) {
var make = $("#details_form").find("#tradein_make").val();
var model = $("#details_form").find("#tradein_model").val();
var variant = $("#details_form").find("#tradein_variant").val();
var id_tradein = $("#details_form").find("#trade").val();
$("#forward_pdf_form").find("#label_1").html(make+" "+model);
$("#forward_pdf_form").find("#label_2").html(variant);
$("#forward_pdf_form").find("#id_tradeinv").html(id_tradein);

$("#forward_pdf_modal").modal();
});	
// MODAL OPENERS (End) //

// DROPZONE UPLOADERS (Start) //
$("#forward_pdf_form").find(".email_attachments").dropzone({
url: '<?php echo site_url('tradein/upload_email_attachments/'); ?>',
init: function() {
this.on("sending", function(file, xhr, formData){}),
this.on("success", function(file, response){
$("#forward_pdf_form").find("#hidden_images").append('<input class="hidden_image" type="hidden" name="email_file[]" value="'+response+'">');
}),
this.on("queuecomplete", function(){});
},
});
// DROPZONE UPLOADERS (End) //			

$("#add_trade_valuation_form").submit(function(e) {

var id_user = $("#add_trade_valuation_form").find("#id_user").val();
var trade_valuation = $("#add_trade_valuation_form").find("#value").val();

if (id_user == "" || id_user == 0 || typeof(id_user) == "undefined")
{
swal("ERROR", "Please indicate the user", "error");
}
else
{
if (trade_valuation == "" || trade_valuation == 0 || typeof(trade_valuation) == "undefined")
{
swal("ERROR", "Please enter the value", "error");
}
else
{
$.ajax({
	type: "POST",
	url: "<?php echo site_url('tradein/add_trade_valuation'); ?>",
	data: $("#add_trade_valuation_form").serialize(),
	success: function(response) {
		if (response === "success")
		{
			$("#add_trade_valuation_modal").modal("hide");
			
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
}
}
e.preventDefault();
});

$("#edit_trade_valuation_form").submit(function(e) {
$.ajax({
type: "POST",
url: "<?php echo site_url('tradein/update_trade_valuation'); ?>",
data: $("#edit_trade_valuation_form").serialize(),
success: function(response) {
if (response === "success")
{
	$("#edit_trade_valuation_modal").modal("hide");
	
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

$("#forward_pdf_form").submit(function(e) {

var id_tradein = $("#forward_pdf_form").find("#id_tradein").val();
var recipient = $("#forward_pdf_form").find("#recipient_email").val();
var subject = $("#forward_pdf_form").find("#subject").val();
var message = $("#forward_pdf_form").find("#message").val();

var attachment_array = [];

$("#forward_pdf_form").find("#hidden_images").find(".hidden_image").each(function(){
var image = $(this).val();
attachment_array.push(image);
});

var data = {
id_tradein: id_tradein,
recipient: recipient,
subject: subject,
message: message,
attachment_array: attachment_array
};			

$.ajax({
type: "POST",
url: "<?php echo site_url('tradein/forward_pdf'); ?>",
data: data,
cache: false,
success: function(response) {
if (response === "success")
{
	$("#forward_pdf_modal").find("input,textarea,select").val("");
	$("#forward_pdf_modal").find(".email_attachments").html("");
	$("#forward_pdf_modal").modal("hide");
	
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

$("#quick_note_form").submit(function(e) {
$.ajax({
type: "POST",
url: "<?php echo site_url('tradein/update_record_new'); ?>",
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

$("#details_form").submit(function(e) {
$.ajax({
type: "POST",
url: "<?php echo site_url('tradein/update_record_new'); ?>",
data: $("#details_form").serialize(),
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

$("#pickup_details_form").submit(function(e) {
$.ajax({
type: "POST",
url: "<?php echo site_url('tradein/update_record_new'); ?>",
data: $("#pickup_details_form").serialize(),
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

$("#payment_instructions_form").submit(function(e) {
$.ajax({
type: "POST",
url: "<?php echo site_url('tradein/update_record_new'); ?>",
data: $("#payment_instructions_form").serialize(),
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
</script>
</body>
</html>
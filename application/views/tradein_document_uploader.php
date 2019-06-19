<?php 
include 'admin/template/login_head.php'; 
?>
	<body>
		<div class="body">
			<?php include 'admin/template/login_header.php'; ?>
			<div role="main" class="main" style="border-top: 5px solid #58c603; padding-top: 40px;">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div id="car_details">
								<div class="row">
									<div class="col-md-12">
										<br />
										<center>
											<h3 style="color: #58c603; font-size: 2.3em;">
												<b>TRADEIN DOCUMENT UPLOADER</b>
											</h3>
											<input type="hidden" name="hidden_id" id="hidden_id" value="<?= $tradein_id; ?>">
											<input type="hidden" name="hidden_type" id="hidden_type" value="">											
										</center>
										<div class="alert alert-warning">
											Please upload all the Trade-In Requirements to ensure that there would be no delay on the delivery of your new car.
										</div>
										<h4>
											<b>
												<?php echo strtoupper($tradein['first_name']); ?> 
												<?php echo strtoupper($tradein['last_name']); ?>
											</b>
										</h4>
										<h5>
											<?php echo $tradein['tradein_build_date']; ?>
											<?php echo $tradein['make']; ?>
											<?php echo $tradein['model']; ?>
											<?php echo $tradein['variant']; ?>																						
										</h5>
										<br />
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<p>
											<b>1) Registration Papers</b>
											<br />
											Please upload the current Registration Papers of your car (Both Front and Back).
										</p>
										<div class="panel panel-default">
											<div class="panel-heading">
												Uploaded Files
											</div>
											<div class="panel-body">
												<ul id="upload_file_1_panel">
													<?php
													foreach ($tradein_docs as $t_key => $t_val) 
													{
														if($t_val['fk_lead_doc'] == 1)
														{
															echo "<li><a target='_blank' href='http://myelquoto.com.au/uploads/tradein_documents/{$t_val['file_name']}'>{$t_val['orig_filename']}</a></li>";
														}
													}
													?>
												</ul>
											</div>
										</div>
										<div class="dropzone upload_file" data-doc='1' id="upload_file_1"></div>
										<br />
										<br />
									</div>								
								</div>
								<div class="row">
									<div class="col-md-12">
										<p>
											<b>2) Payout Letters</b>
											<br />
											Please upload a Payout Letter which is valid until one week post the delivery of your vehicle. 
											If the Payout Letter is not valid one week post the delivery date of your vehicle, the delivery 
											might be delayed.
										</p>
										<div class="panel panel-default">
											<div class="panel-heading upload_title">
												Uploaded Files
											</div>
											<div class="panel-body">
												<ul id="upload_file_2_panel">
													<?php 
														foreach ($tradein_docs as $t_key => $t_val) 
														{
															if($t_val['fk_lead_doc'] == 2)
															{
																echo "<li><a target='_blank' href='http://myelquoto.com.au/uploads/tradein_documents/{$t_val['file_name']}'>{$t_val['orig_filename']}</a></li>";
															}
														}
													?>
												</ul>
											</div>
										</div>
										<div class="dropzone upload_file" data-doc='2' id="upload_file_2"></div>
										<br />
										<br />								
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<p>
											<b>3) Pictures of the speedometer, build plate and compliance plate</b>
											<br />
											The compliance date and build date are two separate plates located on your vehicle. A photograph 
											of each is required, as well as a photograph of the speedometer. These photos should be uploaded
											within two weeks before delivery date.
										</p>
										<div class="panel panel-default">
											<div class="panel-heading upload_title">
												Uploaded Files
											</div>
											<div class="panel-body">
												<ul id="upload_file_3_panel">
													<?php 
														foreach ($tradein_docs as $t_key => $t_val) 
														{
															if($t_val['fk_lead_doc'] == 3)
															{
																echo "<li><a target='_blank' href='http://myelquoto.com.au/uploads/tradein_documents/{$t_val['file_name']}'>{$t_val['orig_filename']}</a></li>";
															}
														}
													?>
												</ul>
											</div>
										</div>
										<div class="dropzone upload_file" data-doc='3' id="upload_file_3"></div>
										<br />
										<br />								
									</div>								
								</div>
								<div class="row">
									<div class="col-md-12">
										<p>
											<b>4) Tradein Declaration</b>
											<br />
											Please download the Tradein Declaration <a href="http://www.myelquoto.com.au/uploads/Trade_Declaration_Quote_ME.pdf" target="_blank">here</a>, sign it, and upload here.
										</p>
										<div class="panel panel-default">
											<div class="panel-heading upload_title">
												Uploaded Files
											</div>
											<div class="panel-body">
												<ul id="upload_file_4_panel">
													<?php 
														foreach ($tradein_docs as $t_key => $t_val) 
														{
															if($t_val['fk_lead_doc'] == 4)
															{
																echo "<li><a target='_blank' href='http://myelquoto.com.au/uploads/tradein_documents/{$t_val['file_name']}'>{$t_val['orig_filename']}</a></li>";
															}
														}
													?>
												</ul>
											</div>
										</div>
										<div class="dropzone upload_file" data-doc='4' id="upload_file_4"></div>
									</div>								
								</div>
								<div class="row">
									<?php
									// $root_url = "http://localhost/tradevaluation.com.au/uploads/thumbnails_m/";
									$root_url = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/";
									if ($tradein['image_1']=="") { $tradein['image_1'] = "no_image.png"; }
									if ($tradein['image_2']=="") { $tradein['image_2'] = "no_image.png"; }
									if ($tradein['image_3']=="") { $tradein['image_3'] = "no_image.png"; }
									if ($tradein['image_4']=="") { $tradein['image_4'] = "no_image.png"; }
									?>
									<div class="col-md-12">
										<input type="hidden" id="id_tradein" name="id_tradein" value="<?php echo $tradein_id; ?>" class="form-control input-sm" />
										<input type="hidden" id="image-no">
										<input type="hidden" id="image-oldname">
										<input type="hidden" id="modal-id" value="<?php echo $tradein_id; ?>">
										<input type="hidden" id="modal-id-2" value="<?php echo $tradein_id; ?>">
										<br />
										<br />
									</div>
									<div class="col-md-3">
										<div class="img-responsive img-div">
											<img src="<?php echo $root_url . $tradein['image_1']; ?>" class="img-responsive img-details img-1" data-img="<?php echo $tradein['image_1']; ?>" data-img-no="1">
										</div>
										<div class="panel panel-default">
											<div class="panel-body text-center dropzone-image clickable" data-image-no="1" data-image-oldname="<?php echo $tradein['image_1']; ?>" id="dropzone-image-1">
												Replace Image
											</div>
										</div>								
									</div>
									<div class="col-md-3">
										<div class="img-responsive img-div">
											<img src="<?php echo $root_url . $tradein['image_2']; ?>" class="img-responsive img-details img-2" data-img="<?php echo $tradein['image_2']; ?>" data-img-no="2">
										</div>
										<div class="panel panel-default">
											<div class="panel-body text-center dropzone-image clickable" data-image-no="2" data-image-oldname="<?php echo $tradein['image_2']; ?>" id="dropzone-image-2">
												Replace Image
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="img-responsive img-div">
											<img src="<?php echo $root_url . $tradein['image_3']; ?>" class="img-responsive img-details img-3" data-img="<?php echo $tradein['image_3']; ?>" data-img-no="3">
										</div>
										<div class="panel panel-default">
											<div class="panel-body text-center dropzone-image clickable" data-image-no="3" data-image-oldname="<?php echo $tradein['image_3']; ?>" id="dropzone-image-3">
												Replace Image
											</div>
										</div>								
									</div>
									<div class="col-md-3">
										<div class="img-responsive img-div">
											<img src="<?php echo $root_url . $tradein['image_4']; ?>" class="img-responsive img-details img-4" data-img="<?php echo $tradein['image_4']; ?>" data-img-no="4">
										</div>
										<div class="panel panel-default">
											<div class="panel-body text-center dropzone-image clickable" data-image-no="4" data-image-oldname="<?php echo $tradein['image_4']; ?>" id="dropzone-image-4">
												Replace Image
											</div>
										</div>								
									</div>									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php include 'admin/template/login_footer.php'; ?>
		</div>
		<?php include 'admin/template/login_scripts.php'; ?>
	</body>
</html>
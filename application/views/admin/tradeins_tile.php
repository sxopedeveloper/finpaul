<?php include 'template/head.php'; ?>
	<body>
		<section class="body">
			<?php include 'template/header.php'; ?>
			<div class="inner-wrapper">
				<?php include 'template/left_sidebar.php'; ?>
				<section role="main" class="content-body">
					<?php include 'template/header_2.php'; ?>
					<!-- start: page -->
					<section class="panel">
						<input type="hidden" name="hidden_tr_id" id="hidden_tr_id">
						<input type="hidden" name="hidden_tr_doc" id="hidden_tr_doc">
						<div class="panel-body">
							<?php
							if (count($tradeins)==0)
							{
								echo "<br /><center><i>No results found!</i></center><br />";
							}
							else
							{
							?>
								<?php
								$root_url = "http://www.mytradevaluation.com.au/"; 
								
								foreach ($tradeins as $tradein)
								{
									?>
									<div class="row">
										<div class="col-md-5">
											<?php 
											if ($tradein['image_1']=="") 
											{
												$tradein['image_1'] = "no_image.png"; 
											}
											?>										
											<img src="<?php echo $root_url."uploads/thumbnails_m/".$tradein['image_2']; ?>" style="width: 100%; border: 1px solid #848484;">
											<br />
											<!--
											<div class="row">
												<div class="col-md-12">
													<div class='row'>
														<div class='col-md-12'>
															<div class='panel panel-default panel-up-tradein'>
																<div class='tradein-doc-panel panel-body  <?= (in_array(1, $doc_type_arr[$tradein['id_tradein']])) ? 'documents_green' : ''; ?> documents_temp_tile documents_temp_<?= $tradein['id_tradein']; ?> tradein-doc-panel-body' data-doc='1' data-tradein_id='<?= $tradein['id_tradein']; ?>'>
																	<label class='tradein_doc_name' >REG</label>
																	<a class='fa fa-desktop tradein_doc_button' data-toggle='tooltip' data-placement='top' data-original-title='View Uploads' data-tradein_id='<?= $tradein['id_tradein']; ?>'></a>
																</div>
															</div>
														</div>
													</div>
													<div class='row'>
														<div class='col-md-12'>
															<div class='panel panel-default panel-up-tradein'>
																<div class='tradein-doc-panel panel-body  <?= (in_array(2, $doc_type_arr[$tradein['id_tradein']])) ? 'documents_green' : ''; ?> documents_temp_tile documents_temp_<?= $tradein['id_tradein']; ?> tradein-doc-panel-body' data-doc='2' data-tradein_id='<?= $tradein['id_tradein']; ?>'>
																	<label class='tradein_doc_name' >P/O</label>
																	<a class='fa fa-desktop tradein_doc_button' data-toggle='tooltip' data-placement='top' data-original-title='View Uploads' data-tradein_id='<?= $tradein['id_tradein']; ?>'></a>
																</div>
															</div>
														</div>
													</div>
													<div class='row'>
														<div class='col-md-12'>
															<div class='panel panel-default panel-up-tradein'>
																<div class='tradein-doc-panel panel-body  <?= (in_array(3, $doc_type_arr[$tradein['id_tradein']])) ? 'documents_green' : ''; ?> documents_temp_tile documents_temp_<?= $tradein['id_tradein']; ?> tradein-doc-panel-body' data-doc='3' data-tradein_id='<?= $tradein['id_tradein']; ?>'>
																	<label class='tradein_doc_name' >DEC</label>
																	<a class='fa fa-desktop tradein_doc_button' data-toggle='tooltip' data-placement='top' data-original-title='View Uploads' data-tradein_id='<?= $tradein['id_tradein']; ?>'></a>
																</div>
															</div>
														</div>
													</div>
													<div class='row'>
														<div class='col-md-12'>
															<div class='panel panel-default panel-up-tradein'>
																<div class='tradein-doc-panel panel-body  <?= (in_array(4, $doc_type_arr[$tradein['id_tradein']])) ? 'documents_green' : ''; ?>  documents_temp_tile documents_temp_<?= $tradein['id_tradein']; ?> tradein-doc-panel-body' data-doc='4' data-tradein_id='<?= $tradein['id_tradein']; ?>'>
																	<label class='tradein_doc_name' >PIC</label>
																	<a class='fa fa-desktop tradein_doc_button' data-toggle='tooltip' data-placement='top' data-original-title='View Uploads' data-tradein_id='<?= $tradein['id_tradein']; ?>'></a>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											-->
											<br />
											<?php 
											$hidden_tr = ""; 
											if ($tradein['trans_flag'] == "0")
											{
												$hidden_tr = "hidden";
											}
											else
											{
												$hidden_tr = "";
											}
											?>
											<!--
											<div class="row">
												<div class="col-md-12">
													<div class="table-responsive">
														<table class="table table-bordered table-striped table-condensed mb-none">
													        <tbody>
													        	<tr>
													        		<td>Date / Time of Pickup</td>
													        		<td><p><?= $tradein['pickup_date'] ?>&nbsp;<?=$tradein['pickup_time'] ?></p></td>
													        	</tr>
													        	<tr>
													        		<td>Name of Contact</td>
													        		<td><p><?= $tradein['contact_name'] ?></p></td>
													        	</tr>
													        	<tr>
													        		<td>Contact Number</td>
													        		<td><p><?= $tradein['contact_number'] ?></p></td>
													        	</tr>
													        	<tr>
													        		<td>Transport being booked by Quote Me?</td>
													        		<td><p><?= ($tradein['trans_flag'] == "0") ? "No" : "Yes"; ?></p></td>
													        	</tr>
													        	<tr <?= $hidden_tr; ?> >
													        		<td>Transport Company</td>
													        		<td><p><?= $tradein['transport_company'] ?></p></td>
													        	</tr>
													        	<tr <?= $hidden_tr; ?> >
													        		<td>Contact Number</td>
													        		<td><p><?= $tradein['transport_contact_num'] ?></p></td>
													        	</tr>
													        	<tr <?= $hidden_tr; ?> >
													        		<td>Cost of Transport</td>
													        		<td><p><?= $tradein['cost_of_transport'] ?></p></td>
													        	</tr>
													        	<tr <?= $hidden_tr; ?> >
													        		<td>Booking Made</td>
													        		<td><p><?= $tradein['booking_made'] ?></p></td>
													        	</tr>
													        	<tr <?= $hidden_tr; ?> >
														        	<td>Reference Number of Booking</td>
														        	<td><p><?= $tradein['book_ref_number'] ?></p></td>
													        	</tr>
													        	<tr <?= $hidden_tr; ?> >
													        		<td>Buyer</td>
													        		<td><p><?= $tradein['qs_name'] ?></p></td>
													        	</tr>
													        </tbody>
													  	</table>
													  </div>
											    </div>
											</div>
											-->
										</div>
										<div class="col-md-7">
											<h4>
												<?php
												if ($tradein['tradein_build_date'] == "")
												{
													$tradein['tradein_build_date'] = "N/A";
												}
												?>
												<?php echo '<a href="'.site_url('tradein/record_final/'.$tradein['id_tradein']).'">'.$tradein['tradein_make'].' '.$tradein['tradein_model'].' '.$tradein['tradein_variant'].' ('.$tradein['tradein_build_date'].')</a>'; ?>
											</h4>
											<?php
											if ($tradein['fk_lead'] <> 0)
											{
												$trade_status = "Unavailable";
											}
											else
											{
												$trade_status = "Available";
											}
											
											if ($login_type=="Admin")
											{
												$name = "";
												if (trim($tradein['first_name'])=="" AND trim($tradein['last_name'])=="")
												{
													$name = "N/A";
												}
												else
												{
													$name = $tradein['first_name'] . ' ' . $tradein['last_name'];
												}
												echo '<p><span class="label label-primary">'.$name.'</span></p>';
											}
											?>
											<div class="table-responsive">
												<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
													<tr><td width="20%"><b>Submitted:</b></td><td><?php echo $tradein['created_at']; ?></td></tr>
													<tr><td width="20%"><b>Arrival Date:</b></td><td><?php echo $tradein['delivery_date']; ?></td></tr>
													<tr><td width="20%"><b>Colour:</b></td><td><?php echo $tradein['tradein_colour']; ?></td></tr>
													<tr><td width="20%"><b>Transmission:</b></td><td><?php echo $tradein['tradein_transmission']; ?></td></tr>
													<tr><td width="20%"><b>Kms:</b></td><td><?php echo $tradein['tradein_kms']; ?></td></tr>
													<tr><td width="20%"><b>Fuel Type:</b></td><td><?php echo $tradein['tradein_fuel_type']; ?></td></tr>
													<tr><td width="20%"><b>Body Type:</b></td><td><?php echo $tradein['tradein_body_type']; ?></td></tr>
												</table>
											</div>							
										</div>
									</div>
									<div class="col-md-12">
										<hr />
									</div>
									<?php
								}
								?>
								<br />
							<?php
							}
							?>
							<?php echo $links; ?>
						</div>
					</section>
					<!-- end: page -->					
					<?php include 'modals/ticket_modals.php'; ?>
				</section>
			</div>
			<?php include 'template/right_sidebar.php'; ?>
		</section>
		<?php include 'template/scripts.php'; ?>
		<script type="text/javascript">
			$(document).ready(function(){
				var tr_doc = "";

				$(document).on("click", ".documents_temp_tile", function(){
					$(document).find("#hidden_tr_doc").val($(this).data("doc"));
					$(document).find("#hidden_tr_id").val($(this).data("tradein_id"));
					tr_doc = $(this);
				});

				$(document).find(".documents_temp_tile").dropzone ({
			        url: '<?php echo site_url('lead/upload_tradein_documents/'); ?>',
			        init: function() {
			            this.on("sending", function(file, xhr, formData){
							var lead_id = $("#hidden_tr_id").val();
							var doc_id  = $("#hidden_tr_doc").val();
							formData.append("lead_id", lead_id);
							formData.append("doc_id", doc_id);
						}),
						this.on("success", function(file, response){
							if (!tr_doc.hasClass("documents_green"))
							{
								tr_doc.addClass("documents_green");
							}
						}),
						this.on("queuecomplete", function(){
						    this.removeAllFiles();
						});
					},
				});
			});			
		</script>
	</body>
</html>



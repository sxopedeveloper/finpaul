<?php include 'template/head.php'; ?>
	<body>
		<section class="body">
			<?php include 'template/header.php'; ?>
			<div class="inner-wrapper">
				<?php include 'template/left_sidebar.php'; ?>
				<section role="main" class="content-body has-toolbar">
					<?php include 'template/header_2.php'; ?>
					<div class="inner-toolbar clearfix">
						<ul>
							<li class="right">
								<ul class="nav nav-pills nav-pills-primary">
									<?php 
									$new_active = " ";
									$called_active = " ";
									$deleted_active = " ";

									$label_text = "";
									if ($carsales_status == 0)
									{
										$new_active = ' class="active"'; 
										$label_text = "new ads";
									}
									else if ($carsales_status == 1) 
									{
										$called_active = ' class="active"'; 
										$label_text = "called";
									}
									else if ($carsales_status == 100) 
									{
										$deleted_active = ' class="active"'; 
										$label_text = "deleted ads";
									}									
									else
									{
										$new_active = ' class="active"'; 
										$label_text = "new ads";									
									}
									?>
									<li <?php echo $new_active; ?>>
										<a href="<?php echo site_url('carsales/list_view?status=0'); ?>">New</a>
									</li>
									<li <?php echo $called_active; ?>>
										<a href="<?php echo site_url('carsales/list_view?status=1'); ?>">Called</a>
									</li>
									<li <?php echo $deleted_active; ?>>
										<a href="<?php echo site_url('carsales/list_view?status=100'); ?>">Deleted</a>
									</li>									
								</ul>
							</li>
						</ul>
					</div>
					<!-- start: page -->
					<?php
					if (count($carsales)==0)
					{
						echo "<br /><br /><br /><center>There are no ".$label_text."!</center>";
					}
					else
					{
						foreach ($carsales AS $carsale)
						{
							?>					
							<section class="panel" id="carsales_record_<?php echo $carsale['id']; ?>">
								<div class="panel-body">
									<div class="row">
										<div class="col-md-12">
											<h4><b><a href="<?php echo $carsale['url']; ?>" target="_blank"><?php echo $carsale['name']; ?></a></b></h4>
											<?php
											if (is_numeric($carsale['price']))
											{
												$price = "$ " . number_format($carsale['price'], 2);
											}
											else
											{
												$price = "Price not available!";
											}
											?>
											<h5 style="margin-bottom: 25px;"><?php echo $price; ?></h5>
										</div>
									</div>
									<div class="row">
										<div class="col-md-3">
											<?php 
											if ($carsale['image_url']=="")
											{
												$image_url = base_url('assets/img/default_car_photo.png');
											}
											else
											{
												$image_url = $carsale['image_url'];
											}
											?>
											<img src="<?php echo $image_url; ?>" style="width: 100%;" />						
										</div>
										<div class="col-md-9">
											<div class="table-responsive">
												<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
													<tbody>
														<tr>
															<td width="30%">Valuation:</td>
															<?php
															if ($carsale['valuation']<>0)
															{
																$valuation = "$ " . number_format($carsale['valuation'], 2);
															}
															else
															{
																$valuation = "No valuation set";
															}
															?>															
															<td id="td_valuation_<?php echo $carsale['id']; ?>"><?php echo $valuation; ?></td>
														</tr>													
													</tbody>
												</table>
											</div>
											<br />										
											<div class="table-responsive">
												<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
													<tbody>
														<tr>
															<td width="30%">Type:</td>
															<td><?php echo strtoupper($carsale['type']); ?></td>
														</tr>													
														<tr>
															<td>Compliance Date:</td>
															<td><?php echo $carsale['compliance_date']; ?></td>
														</tr>
														<tr>
															<td>Build Date:</td>
															<td><?php echo $carsale['build_date']; ?></td>
														</tr>
													</tbody>
												</table>
											</div>
											<br />
											<div class="table-responsive">
												<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
													<tbody>
														<tr>
															<td width="30%">Odometer:</td>
															<td><?php echo $carsale['odometer']; ?></td>
														</tr>														
														<tr>
															<td>Transmission:</td>
															<td><?php echo $carsale['transmission']; ?></td>
														</tr>
														<tr>
															<td>Body Type:</td>
															<td><?php echo $carsale['body_type']; ?></td>
														</tr>
														<tr>
															<td>Engine:</td>
															<td><?php echo $carsale['engine']; ?></td>
														</tr>														
													</tbody>
												</table>
											</div>
											<br />										
											<div class="table-responsive">
												<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
													<tbody>
														<tr>
															<td>Remarks:</td>
														</tr>													
														<tr>
															<?php
															if ($carsale['remarks']=="")
															{
																$remarks = "N/A";
															}
															else
															{
																$remarks = $carsale['remarks'];
															}
															?>
															<td><?php echo $remarks; ?></td>
														</tr>
													</tbody>
												</table>
											</div>
											<br />
										</div>
									</div>
									<div class="row">		
										<div class="col-md-12 text-right">
											<?php
											if ($carsale['status']==0)
											{
												?>
												<button type="button" class="btn btn-danger" onclick="update_status(<?php echo $carsale['id']; ?>, 100)">
													<i class="fa fa-trash-o"></i> &nbsp;Delete
												</button>
												<button type="button" class="btn btn-success" onclick="update_status(<?php echo $carsale['id']; ?>, 1)">
													<i class="fa fa-phone"></i> &nbsp;Mark as Called
												</button>
												<button type="button" class="btn btn-primary open-remarks" data-id="<?php echo $carsale['id']; ?>">
													<i class="fa fa-pencil-square-o"></i> &nbsp;Remarks
												</button>												
												<button type="button" class="btn btn-primary open-valuation" data-id="<?php echo $carsale['id']; ?>">
													<i class="fa fa-dollar"></i> &nbsp;Valuation
												</button>												
												<?php
											}
											else if ($carsale['status']==1)
											{
												?>
												<button type="button" class="btn btn-danger" onclick="update_status(<?php echo $carsale['id']; ?>, 100)">
													<i class="fa fa-trash-o"></i> &nbsp;Delete
												</button>
												<button type="button" class="btn btn-primary open-remarks" data-id="<?php echo $carsale['id']; ?>">
													<i class="fa fa-pencil-square-o"></i> &nbsp;Remarks
												</button>
												<button type="button" class="btn btn-primary open-valuation" data-id="<?php echo $carsale['id']; ?>">
													<i class="fa fa-dollar"></i> &nbsp;Valuation
												</button>
												<?php									
											}
											else if ($carsale['status']==100)
											{
												?>
												
												<?php									
											}
											?>
										</div>												
									</div>
								</div>
							</section>
							<?php							
						}
					}
					?>
					<?php echo $links; ?>
					<!-- end: page -->
					<?php include 'modals/ticket_modals.php'; ?>
					<div id="remarks-modal" class="modal fade">
						<div class="modal-dialog" style="width: 95%;">
							<header class="panel-heading">
								<h2 class="panel-title">Remarks</h2>
							</header>						
							<div class="panel-body">
								<div class="modal-wrapper">
									<div class="modal-text">
										<form method="post" action="" id="main_form" name="main_form">
											<input type="hidden" id="id" name="id" value="" />
											<div class="row">
												<div class="col-md-12">										
													<textarea id="remarks" name="remarks" class="form-control" placeholder="Remarks"></textarea><br />
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
							<footer class="panel-footer">
								<div class="row">
									<div class="col-md-12 text-right">
										<button type="button" class="btn btn-primary" onclick="update_remarks()">Submit</button>
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
								</div>
							</footer>
						</div>
					</div>
					<div id="valuation-modal" class="modal fade">
						<div class="modal-dialog" style="width: 95%;">
							<header class="panel-heading">
								<h2 class="panel-title">Valuation</h2>
							</header>						
							<div class="panel-body">
								<div class="modal-wrapper">
									<div class="modal-text">
										<form method="post" action="" id="main_form" name="main_form">
											<input type="hidden" id="id" name="id" value="" />
											<div class="row">
												<div class="col-md-12">										
													<input onkeypress="return isNumberKey(event)" class="form-control" id="valuation" name="valuation" type="text">
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
							<footer class="panel-footer">
								<div class="row">
									<div class="col-md-12 text-right">
										<button type="button" class="btn btn-primary" onclick="update_valuation()">Submit</button>
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
								</div>
							</footer>
						</div>
					</div>
				</section>
			</div>
			<?php include 'template/right_sidebar.php'; ?>
		</section>		
		<?php include 'template/scripts.php'; ?>
		<script>
			$(document).on('click', '.open-valuation', function(data)
			{
				var id = $(this).data('id');
				$.post('<?php echo site_url("carsales/valuation"); ?>/' + id, function(data)
				{
					$('#valuation-modal').find('#id').val(id);
					$('#valuation-modal').find('#valuation').val(data.valuation);
					$('#valuation-modal').modal();
				}, 'json');
			});
		
			$(document).on('click', '.open-remarks', function(data)
			{
				var id = $(this).data('id');
				$.post('<?php echo site_url("carsales/remarks"); ?>/' + id, function(data)
				{
					$('#remarks-modal').find('#id').val(id);
					$('#remarks-modal').find('#remarks').val(data.remarks);
					$('#remarks-modal').modal();
				}, 'json');
			});
			
			function update_valuation ()
			{
				var id = $('#valuation-modal').find('#id').val();
				var valuation = $('#valuation-modal').find('#valuation').val();
				var dataString = "&valuation="+valuation;
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('carsales/update_details'); ?>/" + id,
					data: dataString,
					cache: false,
					success: function(result){
						$("#td_valuation_"+id).html(valuation);
						alert ("Update successful!");
						$("#valuation-modal").modal("hide");
					}
				});			
			}
			
			function update_remarks ()
			{
				var id = $('#remarks-modal').find('#id').val();
				var remarks = $('#remarks-modal').find('#remarks').val();
				var dataString = "&remarks="+remarks;
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('carsales/update_details'); ?>/" + id,
					data: dataString,
					cache: false,
					success: function(result){
						$("#remarks_"+id).html(remarks);
						alert ("Update successful!");
						$("#remarks-modal").modal("hide");						
					}
				});			
			}

			function update_status (id, status)
			{
				if(!confirm("Are you sure you want to perform this action?"))
				{
					return false;
				}

				var dataString = "&status="+status;
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('carsales/update_status'); ?>/" + id,
					data: dataString,
					cache: false,
					success: function(result){
						$("#carsales_record_"+id).remove();
						alert ("Action successful!");
					}
				});
			}		
		</script>
	</body>
</html>
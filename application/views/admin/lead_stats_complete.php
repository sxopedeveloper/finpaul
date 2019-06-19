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
						<div class="panel-body">
							<div class="table-responsive">
								<?php
								if (count($leads_summary)==0)
								{
									echo "<br /><center><i>No results found!</i></center><br /><br /><br /><br />";
								}
								else
								{
								?>
									<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
										<thead>
											<tr>
												<td><b>User</b></td>
												<td><b>TOTAL</b></td>
												<td><b>CONTACTED</b></td>																		
												<td><b>Rescheduled</b></td>
												<td><b>Tendering</b></td>
												<td><b>Submitted as Deal</b></td>
												<td><b>Delivery Pending</b></td>
												<td><b>Delivered</b></td>
												<td><b>Settled</b></td>
												<td><b>Deleted</b></td>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach ($leads_summary as $lead_summary)
											{
												?>
												<tr>
													<td><?php echo $lead_summary->name; ?></td>
													<td><?php echo $lead_summary->allocated; ?></td>
													<td><?php echo $lead_summary->total_attempted; ?></td>
													<td><?php echo $lead_summary->attempted_rescheduled; ?></td>
													<td><?php echo $lead_summary->tendering; ?></td>
													<td><?php echo $lead_summary->converted_to_deal; ?></td>
													<td><?php echo $lead_summary->delivery_pending; ?></td>
													<td><?php echo $lead_summary->delivered; ?></td>
													<td><?php echo $lead_summary->settled; ?></td>
													<td><?php echo $lead_summary->deleted; ?></td>
												</tr>
											<?php
											}
											?>
										</tbody>
									</table>
								<?php
								}
								?>
							</div>				
						</div>
					</section>
					<!-- end: page -->
					<?php include 'modals/ticket_modals.php'; ?>
				</section>
			</div>
			<?php include 'template/right_sidebar.php'; ?>
		</section>
		<?php include 'template/scripts.php'; ?>
	</body>
</html>
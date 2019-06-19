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
								if (count($lead_actions)==0)
								{
									echo "<br /><center><i>No results found!</i></center><br /><br /><br /><br />";
								}
								else
								{
								?>
									<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
										<thead>
											<tr>
												<td><b>Quote Specialist</b></td>
												<td><b>CQ Number</b></td>
												<td><b>Action</b></td>
												<td><b>Date</b></td>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach ($lead_actions as $lead_action)
											{
												?>
												<tr>
													<td><?php echo $lead_action->quote_specialist; ?></td>
													<td><?php echo $lead_action->cq_number; ?></td>
													<td><?php echo $lead_action->details; ?></td>
													<td><?php echo $lead_action->created_at; ?></td>
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
	</body>
</html>
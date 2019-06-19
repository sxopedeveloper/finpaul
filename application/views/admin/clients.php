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
								if (count($clients)==0)
								{
									echo "<br /><center><i>No results found!</i></center><br /><br /><br /><br />";
								}
								else
								{
								?>
									<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
										<thead>
											<tr>
												<th>Name</th>
												<th>Email</th>
												<th>Mobile</th>
												<th>State</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach($clients as $client)
											{
												?>
												<tr>
													<td><?php echo $client->name; ?></td>
													<td><?php echo $client->email; ?></td>
													<td><?php echo $client->mobile; ?></td>
													<td><?php echo $client->state; ?></td>
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
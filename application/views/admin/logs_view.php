<?php include 'template/head.php'; ?>
	<body>
		<style type="text/css">
			#add-cc{
				cursor: pointer; 
				cursor: hand;
			}
			#insert_cc{
				cursor: pointer; 
				cursor: hand;	
			}
			.row-input{
				margin-bottom: 10px;
			}
			.panel-cc{
				margin-bottom: 10px;
			}
			.panel-body-cc{
				background-color: #e5e5e5;
			}
			.del_token { 
				cursor: pointer; 
				cursor: hand;
			}
		</style>	
		<section class="body">
			<?php include 'template/header.php'; ?>
			<div class="inner-wrapper">
				<?php include 'template/left_sidebar.php'; ?>
				<section role="main" class="content-body">
					<?php include 'template/header_2.php'; ?>
					<!-- start: page -->
					<section class="panel">
						<header class="panel-heading">
							<h2 class="panel-title">Logs</h2>
						</header>
						<div class="panel-body">
							<div id="datatable-tabletools_wrapper" class="dataTables_wrapper no-footer">
								<table id="main_table" class="display nowrap table table-bordered table-striped table-condensed mb-none" cellspacing="0" width="100%" style="white-space: nowrap;">
									<thead>
										<tr>
											<td>Log Date</td>
											<td>Username</td>
											<td>IP Address</td>
											<td>Country Location</td>
											<td>Type</td>
											<td>Status</td>
											<td>Description</td>
										</tr>
									</thead>
									<tbody>
										<?php 
										if( isset( $logs ) ): foreach( $logs as $log ):
											?>
											<tr>
												<td><?php echo $log['date_created']; ?></td>
												<td><?php echo $log['username']; ?></td>
												<td><?php echo $log['ip_address']; ?></td>
												<td><?php echo $log['location']; ?></td>
												<td>
													<?php
														if( $log['type'] == 1 ){
															echo 'Login';
														}
														elseif( $log['type'] == 2 ){
															echo 'Logout';
														}
														else {
															echo 'Register';
														}
													?>
												</td>
												<td>
													<?php echo ( $log['status'] == 1 ) ? 'Success' : 'Failed'; ?>
												</td>
												<td><?php echo $log['description']; ?></td>
											</tr>
											<?php
										endforeach; endif;
										?>
									</tbody>
								</table>
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
		<script>
			$('#main_table').DataTable();
		</script>		
	</body>
</html>
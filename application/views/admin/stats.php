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
						<header class="panel-heading">
							<div class="panel-actions">
								<a href="#" class="fa fa-caret-down"></a>
							</div>
							<h2 class="panel-title">
								<span class="va-middle">Search Filters</span>
							</h2>
						</header>
						<form action="<?php echo site_url('admin/stats'); ?>" method="get" accept-charset="utf-8">
							<div class="panel-body">
								<br />
								<?php
								$now = date("Y-m-d");

								$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : $now;
								$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : $now;
								?>
								<div class="form-group">								
									<div class="col-md-12">
										<div style="border: 1px solid #eeeeee; padding: 15px 15px 0px 15px; border-radius: 5px; background: #f5f5f5;">
											<div class="row">
												<div class="col-md-6">
													<input class="datepicker form-control mb-md" name="date_from" data-date-format="yyyy-mm-dd" style="width: 100%" placeholder="Start Date" value="<?php echo $date_from; ?>">
												</div>
												<div class="col-md-6">
													<input class="datepicker form-control mb-md" name="date_to" data-date-format="yyyy-mm-dd" style="width: 100%" placeholder="End Date" value="<?php echo $date_to; ?>">
												</div>
											</div>
										</div>
										<br />
									</div>
								</div>
							</div>
							<footer class="panel-footer text-right">
								<input value="Apply Filters" name="submit" class="btn btn-primary" type="submit">
							</footer>
						</form>
					</section>
					<section class="panel">
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
									<thead>
										<tr>
											<td colspan="2" style="background: #eee;">
												<center><h4><b>REVENUE PER BRAND</b></h4></center>
											</td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><b>Make</b></td>
											<td><b>Revenue</b></td>
										</tr>									
										<?php
										foreach ($revenue_per_brand as $record)
										{
											if ($record['revenue']<>"" AND $record['revenue']<> 0)
											{
												?>
												<tr>
													<td><?php echo $record['make']; ?></td>
													<td><?php echo $record['revenue']; ?></td>
												</tr>
												<?php
											}
										}
										?>
									</tbody>
								</table>
								<br />								
							</div>
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
									<thead>
										<tr>
											<td colspan="3" style="background: #eee;">
												<center><h4><b>REVENUE PER MODEL</b></h4></center>
											</td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><b>Make</b></td>
											<td><b>Model</b></td>
											<td><b>Revenue</b></td>
										</tr>									
										<?php
										foreach ($revenue_per_model as $record)
										{
											if ($record['revenue']<>"" AND $record['revenue']<> 0)
											{											
												?>
												<tr>
													<td><?php echo $record['make']; ?></td>
													<td><?php echo $record['model']; ?></td>
													<td><?php echo $record['revenue']; ?></td>
												</tr>
												<?php
											}
										}
										?>
									</tbody>
								</table>
								<br />								
							</div>	
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
									<thead>
										<tr>
											<td colspan="2" style="background: #eee;">
												<center><h4><b>REVENUE PER SALESPERSON</b></h4></center>
											</td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><b>Name</b></td>
											<td><b>Revenue</b></td>
										</tr>									
										<?php
										foreach ($revenue_per_salesperson as $record)
										{
											?>
											<tr>
												<td><?php echo $record['name']; ?></td>
												<td><?php echo $record['revenue']; ?></td>
											</tr>
											<?php
										}
										?>
									</tbody>
								</table>
								<br />								
							</div>
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
									<thead>
										<tr>
											<td colspan="6" style="background: #eee;">
												<center><h4><b>LEADS ATTEMPTED BY SALESPERSON</b></h4></center>
											</td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><b>Name</b></td>
											<td><b>Attempted</b></td>
											<td><b>No Answer</b></td>
											<td><b>Wrong Number</b></td>
											<td><b>Tender Started</b></td>
											<td><b>Deleted</b></td>
										</tr>									
										<?php
										foreach ($lead_attempts as $record)
										{
											?>
											<tr>
												<td><?php echo $record['name']; ?></td>
												<td><?php echo $record['assigned']; ?></td>
												<td><?php echo $record['no_answer']; ?></td>
												<td><?php echo $record['wrong_number']; ?></td>
												<td><?php echo $record['tender_started']; ?></td>
												<td><?php echo $record['deleted']; ?></td>
											</tr>
										<?php
										}
										?>
									</tbody>
								</table>
								<br />								
							</div>
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
									<thead>
										<tr>
											<td colspan="2" style="background: #eee;">
												<center><h4><b>LEADS BY SOURCE</b></h4></center>
											</td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><b>Source</b></td>
											<td><b>Lead Count</b></td>
										</tr>									
										<?php
										foreach ($lead_sources as $record)
										{
											?>
											<tr>
												<td><?php echo $record['source']; ?></td>
												<td><?php echo $record['record_count']; ?></td>
											</tr>
										<?php
										}
										?>
									</tbody>
								</table>
								<br />								
							</div>							
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
									<thead>
										<tr>
											<td colspan="2" style="background: #eee;">
												<center><h4><b>LEADS BY POSTCODE</b></h4></center>
											</td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><b>Postcode</b></td>
											<td><b>Lead Count</b></td>
										</tr>									
										<?php
										foreach ($lead_postcodes as $record)
										{
											?>
											<tr>
												<td><?php echo $record['postcode']; ?></td>
												<td><?php echo $record['record_count']; ?></td>
											</tr>
										<?php
										}
										?>
									</tbody>
								</table>
								<br />								
							</div>
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
									<thead>
										<tr>
											<td colspan="2" style="background: #eee;">
												<center><h4><b>LEADS BY STATE</b></h4></center>
											</td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><b>State</b></td>
											<td><b>Lead Count</b></td>
										</tr>									
										<?php
										foreach ($lead_states as $record)
										{
											?>
											<tr>
												<td><?php echo $record['state']; ?></td>
												<td><?php echo $record['record_count']; ?></td>
											</tr>
										<?php
										}
										?>
									</tbody>
								</table>
								<br />								
							</div>
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
									<thead>
										<tr>
											<td colspan="2" style="background: #eee;">
												<center><h4><b>LEADS BY MAKE</b></h4></center>
											</td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><b>Make</b></td>
											<td><b>Lead Count</b></td>
										</tr>									
										<?php
										foreach ($lead_makes as $record)
										{
											?>
											<tr>
												<td><?php echo $record['make']; ?></td>
												<td><?php echo $record['record_count']; ?></td>
											</tr>
										<?php
										}
										?>
									</tbody>
								</table>
								<br />
							</div>
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
									<thead>
										<tr>
											<td colspan="2" style="background: #eee;">
												<center><h4><b>LEADS BOUGHT</b></h4></center>
											</td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><b>Dealer</b></td>
											<td><b>Lead Count</b></td>
										</tr>									
										<?php
										foreach ($lead_bought as $record)
										{
											?>
											<tr>
												<td><?php echo $record['name']; ?></td>
												<td><?php echo $record['record_count']; ?></td>
											</tr>
										<?php
										}
										?>
									</tbody>
								</table>
								<br />
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
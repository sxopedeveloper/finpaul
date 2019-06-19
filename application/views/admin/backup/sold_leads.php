<?php include 'template/head.php'; ?>
	<body>
	<style type="text/css">
		.table-condensed > thead > tr > th, .table-condensed > tbody > tr > th, .table-condensed > tfoot > tr > th, .table-condensed > thead > tr > td, .table-condensed > tbody > tr > td, .table-condensed > tfoot > tr > td {
		    padding: 6px !important;
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
						<div class="panel-body">
							<table class="table table-bordered table-striped table-condensed" style="white-space: nowrap;" id="datatable" data-swf-path="<?= base_url('assets/vendor/jquery-datatables/extras/TableTools/swf/copy_csv_xls_pdf.swf'); ?>">
								<thead>
									<tr>
										<td><b>Purchaser (Dealer)</b></td>
										<td><b>Client Name</b></td>
										<td><b>Client Email</b></td>
										<td><b>Postcode</b></td>
										<td><b>Make</b></td>
										<td><b>Model</b></td>
										<td><b>Purchase Type</b></td>
										<td><b>Purchase Date</b></td>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($sold_leads as $sold_lead)
									{
										?>
										<tr id="sold_lead_row_<?php echo $sold_lead['id_lead']; ?>" data-idinv="<?php echo $sold_lead['id_lead']; ?>">
											<td><?php echo $sold_lead['dealer_name']; ?></td>
											<td><?php echo $sold_lead['name']; ?></td>
											<td><?php echo $sold_lead['email']; ?></td>
											<td><?php echo $sold_lead['postcode']; ?></td>
											<td><?php echo $sold_lead['make']; ?></td>
											<td><?php echo $sold_lead['model']; ?></td>
											<td><?php echo $sold_lead['purchase_type']; ?></td>
											<td><?php echo $sold_lead['purchase_date']; ?></td>
										</tr>
									<?php
									}
									?>
								</tbody>
							</table>

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
			var datatables = null;
			
			(function($){
				'use strict';
				var datatableInit = function(){
					datatables = $("#datatable");
					datatables.dataTable({
						sDom: "<'text-right mb-md'T>" + $.fn.dataTable.defaults.sDom,
						oTableTools: {
							sSwfPath: datatables.data("swf-path"),
							aButtons: [
								{
									sExtends: 'pdf',
									sButtonText: 'PDF'
								},
								{
									sExtends: 'csv',
									sButtonText: 'CSV'
								}
							]
						}
					});
				};
				
				$(function(){
					datatableInit();
				});
		
			}).apply(this, [jQuery]);
		</script>
	</body>
</html>
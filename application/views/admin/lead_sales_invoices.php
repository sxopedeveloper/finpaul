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
										<td></td>
										<td><b>Name</b></td>
										<td><b>Email</b></td>
										<td><b>Type</b></td>
										<td><b>Quantity</b></td>
										<td><b>Price</b></td>
										<td><b>Invoice Date</b></td>
										<td><b>Payment Due Date</b></td>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($invoices as $invoice)
									{
										?>
										<tr id="invoice_row_<?php echo $invoice['id_lead_sale_invoice']; ?>" data-idinv="<?php echo $invoice['id_lead_sale_invoice']; ?>">
											<td>
												<a href="<?php echo site_url("lead/lead_sales_invoice_pdf/".$invoice['id_lead_sale_invoice']); ?>"  target="_blank">
													<i class="fa fa-file-pdf-o" data-toggle="tooltip" data-placement="top" title="Lead Sales Invoice"></i>
												</a>
											</td>										
											<td><?php echo $invoice['buyer_name']; ?></td>
											<td><?php echo $invoice['buyer_email']; ?></td>
											<?php
											if ($invoice['type']==1)
											{
												$purchase_type = "PMA Protection";
											}
											else
											{
												$purchase_type = "Manual Lead Sale";
											}
											?>
											<td><?php echo $purchase_type; ?></td>
											<td><?php echo $invoice['quantity']; ?></td>
											<td><?php echo $invoice['amount']; ?></td>
											<td><?php echo $invoice['invoice_date']; ?></td>
											<td><?php echo $invoice['payment_due_date']; ?></td>
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
			(function( $ ) {
				'use strict';
				var datatableInit = function() {
					datatables = $('#datatable');
					datatables.dataTable({
						sDom: "<'text-right mb-md'T>" + $.fn.dataTable.defaults.sDom,
						oTableTools: {
							sSwfPath: datatables.data('swf-path'),
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

				$(function() {
					datatableInit();
				});
			}).apply( this, [ jQuery ]);
		</script>
	</body>
</html>
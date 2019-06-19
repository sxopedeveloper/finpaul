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
										<td></td>
										<td><b>Number</b></td>
										<td><b>To</b></td>
										<td><b>Type</b></td>
										<td><b>Due</b></td>
										<td><b>Payment</b></td>
										<td><b>Invoice Date</b></td>
										<td><b>Due Date</b></td>
										<td><b>Overdue By</b></td>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($invoices as $invoice)
									{
										?>
										<tr id="invoice_row_<?php echo $invoice['id_lead_sale_invoice']; ?>" data-idinv="<?php echo $invoice['id_lead_sale_invoice']; ?>">
											<td align="center">
												<a href="<?php echo site_url("lead/lead_sale_invoice_pdf/".$invoice['id_lead_sale_invoice']); ?>"  target="_blank">
													<i class="fa fa-file-pdf-o" data-toggle="tooltip" data-placement="top" title="Lead Sales Invoice"></i>
												</a>
											</td>
											<td align="center">
												<a href="#"  class="update_lead_sales_status"  data-idinv="<?php echo $invoice['id_lead_sale_invoice']; ?>" data-status="<?php echo $invoice['status']; ?>">
													<i class="fa fa-refresh" data-toggle="tooltip" data-placement="top" title="Update Payment Status"></i>
												</a>
											</td>
											<td><?php echo $invoice['lead_sale_invoice_number']; ?></td>
											<td><a href="mailto:<?php echo $invoice['buyer_email']; ?>"><?php echo $invoice['buyer_name']; ?></a></td>
											<?php if ($invoice['type']==1) { $purchase_type = "PMA Protection"; } else { $purchase_type = "Manual Lead Sale"; } ?>
											<td><?php echo $purchase_type; ?></td>
											<td><?php echo $invoice['amount']; ?></td>
											<?php if ($invoice['status']==1) { $payment_status = "Paid"; } else { $payment_status = "Pending"; } ?>
											<td id="payment_status_td_<?php echo $invoice['id_lead_sale_invoice']; ?>"><?php echo $payment_status; ?></td>
											<td><?php echo $invoice['invoice_date']; ?></td>
											<td><?php echo $invoice['payment_due_date']; ?></td>
											<td></td>
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

			$(document).ready(function(){
				$(document).on('click', ".update_lead_sales_status", function () {
					var $this = $(this);
					var id = $(this).data("idinv");
					var old_status = $(this).data("status");

					var data = {
						id: id,
						old_status: old_status
					}

					$.ajax({
						type: "POST",
						url: "<?php echo site_url("lead/update_lead_sale_invoice_status"); ?>",
						cache: false,
						data: data,
						success: function(response){
							if(old_status == 1){
								$("#payment_status_td_"+id).text("Pending");
								$this.data("status", 0);
							}
							else{
								$this.data("status", 1);
								$("#payment_status_td_"+id).text("Paid");
							}

							alert("Payment status updated!");
						}
					});
				});
			});

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
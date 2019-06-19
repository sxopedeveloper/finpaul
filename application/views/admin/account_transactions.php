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
										<td><b>Journal Date</b></td>
										<td><b>Created Date</b></td>
										<td><b>Reference</b></td>
										<td><b>Source Type</b></td>
										<td><b>Account Code</b></td>
										<td><b>Account Type</b></td>
										<td><b>Account Name</b></td>
										<td><b>Description</b></td>
										<td><b>Net Amount</b></td>
										<td><b>Gross Amount</b></td>
										<td><b>Tax Amount</b></td>
										<td><b>Tax Type</b></td>
										<td><b>Tax Name</b></td>
										<td><b>Tracking Category Name</b></td>
										<td><b>Tracking Category Option</b></td>
										<td><b>Date Inserted</b></td>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($transactions as $transaction)
									{
										?>
										<tr>
											<td><?= date('Y-m-d',strtotime($transaction['journal_date'])) ?></td>
											<td><?= $transaction['created_date'] ?></td>
											<td><?= $transaction['reference'] ?></td>
											<td><?= $transaction['source_type'] ?></td>
											<td><?= $transaction['account_code'] ?></td>
											<td><?= $transaction['account_type'] ?></td>
											<td><?= $transaction['account_name'] ?></td>
											<td><?= $transaction['description'] ?></td>
											<td><?= $transaction['net_amount'] ?></td>
											<td><?= $transaction['gross_amount'] ?></td>
											<td><?= $transaction['tax_amount'] ?></td>
											<td><?= $transaction['tax_type'] ?></td>
											<td><?= $transaction['tax_name'] ?></td>
											<td><?= $transaction['tracking_category_name'] ?></td>
											<td><?= $transaction['tracking_category_option'] ?></td>
											<td><?= date('Y-m-d',strtotime($transaction['created_at'])) ?></td>
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
		<?php include 'js/ticket_calendar.php'; ?>
		<script type="text/javascript">
			$(document).ready(function(){
				$(document).on('click','.view_details', function () {
					var $this = $(this);
					var details = $this.closest("tr").find(".hidden_details").text();

					$("#details_area").text(details);
					$("#view_details").modal('show');
				});
			});

			var datatables = null;

			(function($){

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

			}).apply(this, [jQuery]);
		</script>
	</body>
</html>
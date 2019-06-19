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
										<td></td>
										<td><b>Invoice #</b></td>
										<td><b>Type</b></td>
										<td><b>Invoice Date</b></td>
										<td><b>Due Date</b></td>
										<td><b>Received Date</b></td>
										<td><b>Details</b></td>
										<td><b>Amount</b></td>
										<td><b>Status</b></td>
										<td><b>Client Name</b></td>
										<td><b>User</b></td>
										<td><b>Created</b></td>
										<td hidden> Complete Details</td>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($invoices as $invoice)
									{
										?>
										<tr id="invoice_row_<?php echo $invoice['id_invoice']; ?>" data-idinv="<?php echo $invoice['id_invoice']; ?>">
											<td><a href="#" onclick="delete_invoice(<?= $invoice['id_invoice'] ?>)"><i class="fa fa-trash-o"></i></a></td>
											<td><a href="#" class="edit_invoice" ><i class="fa fa-pencil-square-o"></i></a></td>
											<td><a href="#" class="view_details" ><i class="fa fa-eye"></i></a></td>
											<td><?= $invoice['invoice_number']; ?></td>
											<td><?= $invoice['invoice_type']; ?></td>
											<td><?= $invoice['invoice_date']; ?></td>
											<td><?= $invoice['due_date']; ?></td>
											<td><?= $invoice['received_date']; ?></td>
											<td>
												<?php 
													if(strlen($invoice['details']) >= 16)
														echo substr($invoice['details'], 0, 15) . "...";
													else
														echo $invoice['details'];
												?>
											</td>
											<td><?= $invoice['amount']; ?></td>
											<td><?= $invoice['status']; ?></td>
											<td><?= $invoice['client_name']; ?></td>
											<td><?= $invoice['name']; ?></td>
											<td><?= $invoice['created_at']; ?></td>
											<td hidden class="hidden_details"><?= $invoice['details']; ?></td>
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
					<!-- Edit Invoice Modal (Start) -->
					<div id="edit-invoice-modal" class="modal fade">
						<div class="modal-dialog" style="width: 95%;">
							<div class="panel-body">
								<div class="modal-wrapper">
									<div class="modal-text">
										<form method="post" action="" class="edit_form" name="edit_form">
											<input type="hidden" name="hidden_id" id="hidden_id" value="">
											<input type="hidden" name="hidden_row_id" id="hidden_row_id" value="">
											<div class="row">
												<div class="col-md-4">
													<label><font color="red">*</font> Invoice Number:</label>
													<input type="text" class="form-control input-sm" id="invoice_number_edit" name="invoice_number_edit"><br />
												</div>
												<div class="col-md-4">
													<label><font color="red">*</font> Amount:</label>
													<input type="text" class="form-control input-sm" id="amount_edit" name="amount_edit" onkeypress="return isNumberKey(event)" ><br />
												</div>
												<div class="col-md-4">
													<label><font color="red">*</font> Invoice Type:</label>
													<select class="form-control mb-md" id="invoice_type_edit" name="invoice_type_edit" title="Invoice Type">
														<option name="invoice_type" value=""></option>
														<option name="invoice_type" value="Dealer">Dealer Invoice</option>
														<option name="invoice_type" value="Wholesaler">Wholesaler Invoice</option>
														<option name="invoice_type" value="Client">Client Invoice</option>
													</select><br />
												</div>
												<div class="col-md-4">
													<label><font color="red">*</font> Invoice Date:</label>
													<input class="form-control input-md datepicker" id="invoice_date_edit" name="invoice_date_edit" data-date-format="yyyy/mm/dd" value=""><br />
												</div>
												<div class="col-md-4">
													<label><font color="red">*</font> Due Date:</label>
													<input class="form-control input-md datepicker" id="due_date_edit" name="due_date_edit" data-date-format="yyyy/mm/dd" value=""><br />
												</div>
												<div class="col-md-4">
													<label>Received Date:</label>
													<input class="form-control input-md datepicker" id="received_date_edit" name="received_date_edit" data-date-format="yyyy/mm/dd" value=""><br />
												</div>
												<div class="col-md-12">
													<label>Details:</label>
													<textarea id="details_edit" name="details_edit" class="form-control" placeholder="Details"></textarea><br />
												</div>
												<div class="col-md-12">
													<input type="checkbox" id="paid_cb_edit" class="paid_cb_edit" name="paid_cb_edit" value="1">&nbsp;&nbsp;Paid&nbsp;
												</div>											
											</div>
										</form>
									</div>
								</div>
							</div>
							<footer class="panel-footer">
								<div class="row">
									<div class="col-md-12 text-right">
										<button type="button" class="btn btn-primary submit_edit">Submit</button>
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
								</div>
							</footer>
						</div>
					</div>
					<!-- Edit Invoice Modal (End) -->
					<!-- View Details Modal (Start) -->
					<div id="view_details" class="modal fade">
						<div class="modal-dialog">
							<div class="panel-body">
								<div class="modal-wrapper">
									<p id="details_area">
									</p>
								</div>
							</div>
						</div>
					</div>	
					<!-- View Details Modal (End) -->
				</section>
			</div>
			<?php include 'template/right_sidebar.php'; ?>
		</section>
		<?php include 'template/scripts.php'; ?>
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

			}).apply(this, [jQuery]);

			function delete_invoice (invoice_id)
			{
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('deal/delete_invoice'); ?>/"+invoice_id,
					cache: false,
					success: function(result) {
						datatables.fnDeleteRow("#invoice_row_"+String(invoice_id));
					}
				});
			}

			$(document).on('click','.edit_invoice', function(){
				var that = $(this);
				var this_id = that.closest("tr").data("idinv");
				var row_id = that.closest("tr").attr("id");
				
				$("#hidden_row_id").val(row_id);

				var data = {
					this_id: this_id
				};

				$.ajax({
					type: "POST",
					url: "<?php echo site_url('deal/get_single_invoice'); ?>/",
					cache: false,
					data: data,
					dataType: 'json',
					success: function(data) {
						$("#hidden_id").val(data.id_invoice);
						$("#invoice_number_edit").val(data.invoice_number);
						$("#amount_edit").val(data.amount);
						$("#invoice_type_edit").val(data.invoice_type);
						$("#invoice_date_edit").val(data.invoice_date);
						$("#due_date_edit").val(data.due_date);
						$("#received_date_edit").val(data.received_date);
						$("#details_edit").val(data.details);

						if(data.status==1)
							$("#paid_cb_edit").prop('checked', true);
						else
							$("#paid_cb_edit").prop('checked', false);

						$("#edit-invoice-modal").modal();
					}
				});
			});

			$(document).on('click','.submit_edit', function(){
				var id_tr_string = $("#hidden_row_id").val();
				var parent_tr    = $("#"+id_tr_string);
				var data         = $(".edit_form").serialize();
				var inv_num      = $("#invoice_number_edit").val();
				var amt          = $("#amount_edit").val();
				var det          = $("#details_edit").val();
				var inv_type     = $("#invoice_type_edit").val();
				var inv_date     = $("#invoice_date_edit").val();
				var due_date     = $("#due_date_edit").val();
				var rec_date     = $("#received_date_edit").val();

				var status = "";

				if($("#paid_cb_edit").is(":checked"))
				{
					status = "Paid";
				}
				else
				{
					status = "Unpaid";
				}

				$.ajax({
					type: "POST",
					url: "<?php echo site_url('deal/submit_edit_invoice'); ?>",
					cache: false,
					data: data,
					success: function(response) {
						location.reload();
					}
				});
			});
		</script>
	</body>
</html>
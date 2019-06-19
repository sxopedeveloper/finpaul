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
										<td><b>Dealership</b></td>
										<td><b>Manager</b></td>
										<td><b>Email</b></td>
										<td><b>Makes</b></td>
										<td><b>Postcodes</b></td>
										<td><b>Lead Cap</b></td>
										<td><b>Purchased Leads</b></td>
										<td><b>Remaining</b></td>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($protected_postcodes as $protected_postcode)
									{
										?>
										<tr>
											<td> <a href="#" data-id="<?= $protected_postcode['user_id'] ?>" class="edit_protected_postcode"><i class="fa fa-pencil-square-o"></i></a> </td>
											<td><?php echo $protected_postcode['dealership_name']; ?></td>
											<td><?php echo $protected_postcode['name']; ?></td>
											<td><?php echo $protected_postcode['email']; ?></td>
											<td><?php echo $protected_postcode['dealership_brand']; ?></td>
											<td><?php echo $protected_postcode['all_postcodes']; ?></td>
											<td><?php echo $protected_postcode['monthly_lead_cap']; ?></td>
											<td><?php echo $protected_postcode['purchased_leads']; ?></td>
											<td><?php echo $protected_postcode['remaining_leads']; ?></td>
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
					<div class="modal fade" id="edit_protected_postcode_modal" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="myModalLabel">Edit Protected Postcodes</h4>
								</div>
								<div class="modal-body">
									<div class="row">
										<div class="col-md-12">
											<input type="hidden" name="hidden_dealer_id" id="hidden_dealer_id">
											<select multiple class="form-control dealer_postcodes" id="dealer_postcodes"></select>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									<button type="button" class="btn btn-primary" id="save_edited_postcodes">Save</button>
								</div>
							</div>
						</div>
					</div>					
				</section>
			</div>
			<?php include 'template/right_sidebar.php'; ?>
		</section>
		<?php include 'template/scripts.php'; ?>
		<script type="text/javascript">
			$(document).ready(function(){

				$(document).on("click", ".edit_protected_postcode", function(){
					
					var id = $(this).data("id");

					var data = {
						id: id
					};

					$.ajax({
						type: "POST",
						url: "<?php echo site_url("lead/open_edit_protected_postcode"); ?>",
						data: data,
						cache: false,
						dataType: "json",
						success: function(data){

							$("#dealer_postcodes").html(data.option_string);
							var dealer_postcodes = $("#dealer_postcodes").select2();

							$("#hidden_dealer_id").val(id);
							$("#edit_protected_postcode_modal").modal();
						}
					});
				});

				$(document).on("click", "#save_edited_postcodes", function(){
					var id = $("#hidden_dealer_id").val();

					var postcodes = [];

					$("#dealer_postcodes :selected").each(function(i, selected){
						var val = $(this).val();

						postcodes.push(val);
					});

					var data = {
						id: id,
						postcodes: postcodes
					};

					$.ajax({
						type: "POST",
						url: "<?php echo site_url("lead/update_pma_protection"); ?>",
						data: data,
						cache: false,
						success: function(data){
							$("#edit_protected_postcode_modal").modal("hide");
						}
					});
				});
			});

			var datatables = null;

			(function($){
				"use strict";
				var datatableInit = function(){
					datatables = $("#datatable");
					datatables.dataTable({
						sDom: "<'text-right mb-md'T>" + $.fn.dataTable.defaults.sDom,
						oTableTools: {
							sSwfPath: datatables.data("swf-path"),
							aButtons: [
								{
									sExtends: "pdf",
									sButtonText: "PDF"
								},
								{
									sExtends: "csv",
									sButtonText: "CSV"
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
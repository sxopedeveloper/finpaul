<?php include 'template/head.php'; ?>
<?php 
$get_data = $this->input->get();
?>
	<body>
		<style type="text/css">
			.row-input{
				margin-bottom: 10px;
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
							<div class="panel-actions">
								<a href="#" class="fa fa-caret-down"></a>
							</div>
							<h2 class="panel-title">
								<span class="va-middle">Search Filters</span>
							</h2>
						</header>
						<form action="<?php echo site_url('eway_transactions/list_view'); ?>" method="get" accept-charset="utf-8" id="form">
							<div class="panel-body">
								<div class="row row-input">
									<div class="col-md-3">
										<select data-plugin-selectTwo class="form-control populate input-sm" name="name">
											<option value="0">---------</option>
											<?php 
												foreach ($users as $user_key => $user_val) 
												{
													echo "<option value='{$user_val['id_user']}' ".((isset($get_data['name'])) ? (($get_data['name']==$user_val['id_user']) ? "selected" : "" ) : "" ).">{$user_val['name']}</option>";
												}
											?>
										</select>
									</div>
									<div class="col-md-3">
										<input type="text" class="form-control input-sm" name="trans_id" placeholder="Transaction ID" value="<?= (isset($get_data['trans_id']) ? $get_data['trans_id'] : '' ) ?>">
									</div>
									<div class="col-md-3">
										<select class="form-control input-sm" name="cq_trans">
											<option value="0"> -- CQ Transaction Type -- </option>
											<?php
											foreach ($cq_trans as $trans_key => $trans_val) 
											{
												echo "<option value='{$trans_val["trans_type"]}' ".((isset($get_data['cq_trans'])) ? (($get_data['cq_trans']==$trans_val['trans_type']) ? "selected" : "" ) : "" ).">{$trans_val["trans_text"]}</option>";
											}
											?>
										</select>
									</div>
									<div class="col-md-3">
										<select class="form-control input-sm" name="trans_type">
											<option value="0"> -- Eway Transaction -- </option>
											<?php
											foreach ($trans_type as $type_key => $type_val) 
											{
												echo "<option value='{$type_val["id"]}' ".((isset($get_data['trans_type'])) ? (($get_data['trans_type']==$type_val['id']) ? "selected" : "" ) : "" ).">{$type_val["trans_name"]}</option>";
											}
											?>
										</select>
									</div>
								</div>
								<div class="row row-input">
									<div class="col-md-3">
										<input type="text" class="form-control input-sm date_from" name="date_from" placeholder="Date From" id="date_from" value="<?= (isset($get_data['date_from']) ? $get_data['date_from'] : '' ) ?>" data-date-format="yyyy-mm-dd">
									</div>
									<div class="col-md-3">
										<input type="text" class="form-control input-sm date_to" name="date_to" placeholder="Date To" id="date_to" value="<?= (isset($get_data['date_to']) ? $get_data['date_to'] : '' ) ?>" data-date-format="yyyy-mm-dd">
									</div>
								</div>
							</div>
							<footer class="panel-footer text-right">
								<input value="Apply Filters" name="submit" class="btn btn-primary" type="submit" id="submit">
							</footer>
						</form>
					</section>
					<section>
						<div class="panel panel-default">
							<div class="panel-body">
								<table class="table table-responsive table-striped" id="datatable">
									<thead>
										<tr>
											<th>Name</th>
											<th>Transaction ID</th>
											<th>Auth Code</th>
											<th>Status</th>
											<th>Transaction Type</th>
											<th>Eway Type</th>
											<th>Amount</th>
											<th>Date</th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach ($transactions as $trans_key => $trans_val) 
										{
											?>
												<tr class="parent_tr">
													<td><?= $trans_val['name'] ?></td>
													<td><?= $trans_val['trans_id'] ?></td>
													<td><?= $trans_val['auth_code'] ?></td>
													<td><?= $trans_val['status'] ?></td>
													<td><?= $trans_val['trans_text'] ?></td>
													<td><?= $trans_val['trans_name'] ?></td>
													<td><?= $trans_val['trans_amount'] ?></td>
													<td><?= $trans_val['date_created'] ?></td>
												</tr>
											<?php
										}
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
		<script type="text/javascript">
			$(document).ready(function(){
				$("#date_from").datepicker(); 
				$("#date_to").datepicker();

				$(document).on("click", "#submit", function(){

				});
			});

			var datatables = $("#datatable").DataTable({
				"pageLength": 10,
				"lengthMenu": [10, 20, 50],
				"language": {
	 				"lengthMenu": '<select>'+
						'<option value="10">10</option>'+
	 					'<option value="20">20</option>'+
	 					'<option value="50">50</option>'+
	 				'</select> Records per page'
				}
			});
		</script>
	</body>
</html>
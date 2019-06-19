<?php

 include 'admin/template/head.php'; ?>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<style type="text/css">
		.del_file {
			cursor: pointer; 
			cursor: hand;
		}
	</style>
	<body>
		<section class="body">
			<!-- start: header -->
			<?php include 'admin/template/header.php'; ?>
			<!-- end: header -->
			<div class="inner-wrapper">
				<!-- start: sidebar -->
				<?php include 'admin/template/left_sidebar.php'; ?>
				<!-- end: sidebar -->
				<section role="main" class="content-body has-toolbar">
					<?php include 'admin/template/header_2.php'; ?>
					<div class="inner-toolbar clearfix">
						<ul>
							<li class="right">
								<ul class="nav nav-pills nav-pills-primary">
									<?php 
									$active_active = " ";
									$finished_active = " ";
									$won_active = " ";
									$label_text = "";
									if ($status == 0)
									{
										$active_active = ' class="active"'; 
										$label_text = "active tenders";
									}
									else if ($status == 2)
									{
										$won_active = ' class="active"'; 
										$label_text = "won tenders";
									}
									?>
									<li <?php echo $active_active; ?>>
										<a href="<?php echo site_url('user/quotation_requests/0'); ?>">Active</a>
									</li>
									<li <?php echo $won_active; ?>>
										<a href="<?php echo site_url('user/quotation_requests/2'); ?>">Won</a>
									</li>									
								</ul>
							</li>
						</ul>
					</div>
					<!-- start: page -->
					<section class="panel dealer-quote-list-main">						
						<div class="panel-body dealer-list-body">
							<h5 class="panel-title">Quote Requests</h5>
							<div class="dealer-list-filter">
								<form  action="<?php echo site_url('user/quotation_requests/0'); ?>" method="get" accept-charset="utf-8" id="main_list_filter_form">
									<?php
									$dealer_status = isset($_GET['dealer_status']) ? $_GET['dealer_status'] : '';
									$qn_no = isset($_GET['qn_no']) ? $_GET['qn_no'] : '';
									$newLead_make = isset($_GET['newLead_make']) ? $_GET['newLead_make'] : '';
	
									$newLead_model = isset($_GET['newLead_model']) ? $_GET['newLead_model'] : '';
									$newLead_car_year = isset($_GET['newLead_car_year']) ? $_GET['newLead_car_year'] : '';
									$newLead_car_variant = isset($_GET['newLead_car_variant']) ? $_GET['newLead_car_variant'] : '';
									?>									
									<div class="row">
										<div class="dealer-list-filter-content">
											<div class="col-md-3">
												<div class="form-group">
													<input type="text" name="dealer_status" class="form-control" value="<?php echo $dealer_status; ?>" placeholder="Status">	
												</div>
											</div>										
											<div class="col-md-3">
												<div class="form-group">
													<input type="text" name="qn_no" class="form-control" value="<?php echo $qn_no; ?>" placeholder="QN">	
												</div>
											</div>										
											<div class="col-md-3">
												<div class="form-group">
													<select class="form-control" id="newLead_make" name="newLead_make"  placeholder="Make">
														<option value="">Make</option>
														<?php $makes_row = $this->fapplication_model->get_dropdown_data(array("code"=>1));
												$make_id ='';$model_id ='';
												foreach ($makes_row as $make_key => $make_val) 
												{	$selected = '';
													if(trim($newLead_make) == trim($make_val['name'])){
																$make_id = $make_val['id_make']; 
																$selected = 'selected';
														}
														 echo "<option data-id='{$make_val['id_make']}'  value='{$make_val['name']}' ".$selected.">{$make_val['name']}</option>";
														
														
												}?>
													</select>
												</div>
											</div>										
											<div class="col-md-3">
												<div class="form-group">
													<select name="newLead_model" id="newLead_model"  class="form-control  " >
														<option value="">Model</option>	
														<?php if( $make_id!=""){
															$model_row = $this->fapplication_model->get_dropdown_data(array("code"=>2, "id_make" => $make_id));
										
															
															foreach ($model_row as $model_key => $model_val) 
															{	$selected = '';
																if( md5( trim($newLead_model ) ) == md5( trim($model_val['name']) ) )
																{		$model_id = $model_val['id_family']; $selected = 'selected';}
																	echo "<option data-id='{$model_val['id_family']}' value='{$model_val['name']}' ".$selected.">{$model_val['name']}</option>";
															}
														}
														?>
													</select>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<select name="newLead_car_year" id="newLead_car_year" class="form-control address_inp">
														<option value=""> Year</option>	
														<?php if($model_id!=""){
														$build_date_row = $this->fapplication_model->get_dropdown_data(array("code"=>4,"id_model"=>$model_id));
									
									
														foreach ($build_date_row as $b_key => $b_val) 
														{
															echo "<option data-code='{$b_val['code']}' value='{$b_val['year']}' ".((md5($newLead_car_year)==md5($b_val['year'])) ? "selected":"").">{$b_val['year']}</option>";
														}
														$code = $model_id . "-" . $newLead_car_year;
														} ?>
													</select>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<select name="newLead_car_variant" id="newLead_car_variant" class="form-control address_inp">
													<option value="">Varient</option>
													<?php if($code!='')
													{
													$variant_row = $this->fapplication_model->get_dropdown_data(array("code"=>3,"var_code"=>md5($code)));
						
								
														foreach ($variant_row as $var_key => $var_val) 
														{
															 echo "<option data-id='{$var_val['id_vehicle']}' value='{$var_val['name']}' ".((md5($newLead_car_variant)==md5($var_val['name'])) ? "selected":"").">{$var_val['name']}</option>";
														}
													} ?>
													</select>
												</div>
											</div>
											<?php /*?><div class="col-md-3">
												<div class="form-group">
													<input type="date" name="date_from" class="form-control">	
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<input type="date" name="date_to" class="form-control">	
												</div>
											</div><?php */?>
										</div>
									</div>
									<div class="quote-list-filter text-right">
										<button type="submit" name="apply_filter" class="btn btn-default" id="apply">Apply Filters</button>
										<a class="btn btn-default clear-btn" href="<?php echo site_url('user/quotation_requests/0'); ?>">Clear Filters</a>
									</div>
								</form>
							</div>
							<table class="table table-bordered mb-none dealer-quote-list-table" id="datatable-tabletools" style="white-space: nowrap;" data-swf-path="<?php echo base_url('assets/vendor/jquery-datatables/extras/TableTools/swf/copy_csv_xls_pdf.swf'); ?>">
								<thead>
									<tr>
										<th>Quote</th>
										<th>Edit Quote</th>
										<!--<th></th>-->
										<th>QN</th>
										<th>Status</th>
										<th>Purchase Order</th>
										<th>Vehicle</th>										
										<th>Registration</th>										
										<th>Postcode</th>
										<th>Tax Invoice Request</th>
										<th>Date & Time</th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($quote_requests as $quote_request)
									{					
										?>
										<tr>
											<td>
												<center>
													<a href="#" class="quote_modal_button" data-id_lead="<?php echo $quote_request['id_lead']; ?>" data-id_quote_request="<?php echo $quote_request['id_quote_request']; ?>" data-id_quote="<?php echo $quote_request['id_quote_new']; ?>" data-demo="New">
														<i class="fa fa-envelope-open-o fa-lg" data-toggle="tooltip" data-placement="top" title="Quote"></i>
													</a>
												</center>
											</td>
											<td>
												<center>
													<a href="#" class="quote_modal_button" data-id_lead="<?php echo $quote_request['id_lead']; ?>" data-id_quote_request="<?php echo $quote_request['id_quote_request']; ?>" data-id_quote="<?php echo $quote_request['id_quote_demo']; ?>" data-demo="Demo">
														<i class="fa fa-pencil-square-o fa-lg" data-toggle="tooltip" data-placement="top" title="Quote Edit for vehicle"></i>
													</a>
												</center>
											</td>
											<!--
											<td>
												<center>
													<a href="#" title="Upload PDF">
														<i class="fa fa-file-image-o up_img_modal" data-toggle="tooltip" data-placement="top" title="Upload PDF" data-idquote="<?= $quote_request['id_quote_request']; ?>"></i>
													</a>
												</center>
											</td>
											-->
											<td><?php echo $quote_request['cq_number']; ?></td>
											<td class="text-left dealer-status">Awaiting</td>
											<td>
												<center>
													<a href="#" class="quote_modal_button">
														<i class="fa fa-eye fa-lg" data-toggle="tooltip" data-placement="top" title="View Purchase Order"></i>
													</a>
													<a href="#" class="quote_modal_button quote-download-button">
														<i class="fa fa-download fa-lg" data-toggle="tooltip" data-placement="top" title="Doanload Purchase Order"></i>
													</a>
												</center>
											</td>
											<td class="dealer-status">
												<?php echo $quote_request['build_date']." ".$quote_request['make']." ".$quote_request['model']." ".$quote_request['variant']." (".$quote_request['colour'].")"; ?>
												
											</td>
											<td><?php echo $quote_request['registration_type']; ?></td>
											<td><?php echo $quote_request['postcode']; ?></td>
											<td>
												<center>
													<a href="#" class="quote_modal_button">
														<i class="fa fa-eye fa-lg" data-toggle="tooltip" data-placement="top" title="Tax Invoice Request"></i>
													</a>
												</center>
											</td>
											<td>Tue 15 Jan - 02:55 PM</td>
										</tr>
										<?php
									}
									?>
								</tbody>
							</table>
						</div>
					</section>
					<div class="modal fade" id="upload_pdf_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <!-- Upload PDF Modal -->
						<div class="modal-dialog modal-sm" role="document" id="modal-dialog-menu">
							<div class="modal-content">
								<div class="modal-header">
									<input type="hidden" id="hidden_quote_id">
									<h4 class="modal-title">Upload PDF</h4>
								</div>
								<div class="modal-body">
									<div class="row">
										<div class="col-md-12" id="file_table_id">
										</div>
									</div>
									<hr>
									<div class="row">
										<div class="col-md-12">
											<div class="dropzone upload_pdf"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="audit_trail" class="modal fade"> <!-- Audit Trail Modal -->
						<div class="modal-dialog" style="width: 70%;">
							<section class="panel">
								<header class="panel-heading">
									<h2 class="panel-title">Quote Audit Trail</h2>
								</header>
								<div class="panel-body">
									<div class="modal-wrapper">
										<div class="modal-text" id="audit_body">
											
										</div>
									</div>
								</div>
								<footer class="panel-footer">
									<div class="row">
										<div class="col-md-12 text-right">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										</div>
									</div>
								</footer>
							</section>
						</div>
					</div>
				</section>
				<?php include 'admin/template/modals.php'; ?>
			</div>
			<?php include 'admin/template/right_sidebar.php'; ?>
		</section>
		<?php include 'admin/template/scripts.php'; ?>
		<script type="text/javascript">
	
		$(document).ready(function(){		
			
			$(document).on('change', '#main_list_filter_form #newLead_make', function() {
			var selected = $(this).find('option:selected'); 
			
			var id = selected.data('id');
			var data = {
	    		code: 2,
	    		id_make: id
				    }
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("user/get_dropdown_data"); ?>",
				cache: false,
				data: data,
				dataType: 'json',
				success: function(result){
					var option = '<option></option>';
					
					for (var i in result) {
			            option = option+'<option data-id="'+result[i].id_family+'" value="'+result[i].name+'">'+result[i].name+'</option>';
			          }
					$(document).find("#main_list_filter_form").find('#newLead_model').html(option);
					
				}
			});
	    });
			$(document).on('change', '#main_list_filter_form #newLead_model', function() {
			var selected = $(this).find('option:selected');
			var id = selected.data('id');
			
			// var data = {
	  //   		code: 3,
	  //   		id_model: id
			// 	    }
			var data = {
	    		code: 4,
	    		id_model: id
				    }
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("user/get_dropdown_data"); ?>",
				cache: false,
				data: data,
				dataType: 'json',
				success: function(result){
					var option = '<option value="">--Choose--</option>';
					
					// for (var i in result) {
			  //           option = option+'<option data-id="'+result[i].id_vehicle+'" value="'+result[i].name+'">'+result[i].name+'</option>';
			  //         }
					// $(document).find("#application_section").find('#variant').html(option);
					for (var i in result) {
			            option = option+'<option data-code="'+result[i].code+'" value="'+result[i].year+'">'+result[i].year+'</option>';
			          }
					$(document).find("#main_list_filter_form").find('#newLead_car_year').html(option);
				}
			});
	    });
			$(document).on('change', '#main_list_filter_form #newLead_car_year', function() {
			var selected = $(this).find('option:selected');
			var var_code = selected.data('code');
			
			var data = {
	    		code: 3,
	    		var_code: var_code
				    }
			//console.log(var_code);
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("user/get_dropdown_data"); ?>",
				cache: false,
				data: data,
				dataType: 'json',
				success: function(result){
					var option = '<option value="">--Choose--</option>';
					
					for (var i in result) {
			            option = option+'<option data-id="'+result[i].id_vehicle+'" value="'+result[i].name+'">'+result[i].name+'</option>';
			          }
					$(document).find("#main_list_filter_form").find('#newLead_car_variant').html(option);
				}
			});
	    });
		});
		
			$(document).ready(function(){

				(function($){
					"use strict";
					var datatableInit = function() {
						var $table = $("#datatable-tabletools");
						$table.dataTable({
							sDom: "<'text-right mb-md'T>" + $.fn.dataTable.defaults.sDom,
							oTableTools: {
								sSwfPath: $table.data("swf-path"),
								aButtons: [
									{
										sExtends: "pdf",
										sButtonText: "PDF"
									},
									{
										sExtends: "csv",
										sButtonText: "CSV"
									},
									{
										sExtends: "print",
										sButtonText: "Print",
										sInfo: "Please press CTR+P to print or ESC to quit"
									}
								]
							}
						});
					};

					$(function() {
						datatableInit();
					});
					
				}).apply(this, [jQuery]);		
			});
		</script>
	</body>
</html>
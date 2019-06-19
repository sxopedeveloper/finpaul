<?php include 'template/head.php'; ?>

	<body>
		<section class="body">
			<?php include 'template/header.php'; ?>
			<div class="inner-wrapper">
				<?php include 'template/left_sidebar.php'; ?>
				<section role="main" class="content-body">
					<?php include 'template/header_2.php'; ?>
					<!-- start: page -->						
				
					<div>
						<?php
						if($this->session->flashdata('error'))
						{
						?>
							<div class="alert alert-danger alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><?php echo $this->session->flashdata('error');?>
							</div>
						<?php
						}
						if($this->session->flashdata('success'))
						{
							?>
							<div class="alert alert-success alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><?php echo $this->session->flashdata('success');?>
							</div>
							<?php
						}
						?>
					</div>
					<div class="row">
						<div class="col-md-6 pull-right">
							<div class="row">
								<div class="col-md-4">
									
								</div>
								<div class="col-md-4">
									
								</div>
								<div class="col-md-4">
									<button type="button" class="btn btn-primary  class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Create New</button>
								</div>
							</div>
						</div>
						<div class="col-md-6">
						</div>
					</div>
					<hr>

					<section class="panel" >
						<div class="panel-body">
						
							<div class="table-responsive">
									<style>
									table.dataTable tbody tr {
										 color: black;
									}
									</style>
									<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;" id="rb_data_table">
										<thead>
											<tr>
												<th>Sr. No</th>
												<th>Action</th>
												<th>Make</th>
												<th>Model</th>
												<th>Car Id</th>
												<th>Name</th>
												<th>Price</th>
												<th>Description</th>
												<th>Month - Year</th>
											</tr>
										</thead>
										<tbody>
											
										</tbody>
									</table>
																				
								
							</div>
												
						</div>
					</section>
									
				</section>
			</div>
			
			<?php include 'template/right_sidebar.php'; ?>
		</section>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">RB Data</h4>
      </div>
      <div class="modal-body">
		<form action="<?php echo base_url().'index.php/rb_data/save';?>" method="post" enctype='multipart/form-data' id="frm">
			<div class="row" style="margin-bottom:2%">
				<input type="hidden" name="type" id="type" value="insert">
				<input type="hidden" name="id" id="id" value="">
				<div class="col-md-6">
					<label ><b>Make :</b>  </label>
					<?php
					$carmakes = $this->car_model->get_makes();
					?>
						<select required class="form-control input-md" id="search_make" name="search_make">
						<option value="">-Make-</option>
						<?php 
						
							foreach ($carmakes as $m_key => $m_val) 
							{
							?>
							<option value="<?php echo $m_val->id_make;?>" data-id="<?php echo $m_val->id_make;?>"><?php echo $m_val->name;?></option>
							<?php
							}
						?>
					</select>
				</div>

			
				<div class="col-md-6">

					<label ><b>Model :</b> </label>
					<select required class="form-control input-md" id="search_model" name="search_model">
                		<option value="">-Model-</option>
              		</select>
				</div>
			</div>

			<div class="row" style="margin-bottom:2%">
				<div class="col-md-6">
					<label ><b>Car Id :</b>  </label>
					<input required name="car_id" id="car_id" class="form-control input-md">
				</div>

				<div class="col-md-6">
					<label ><b>Name :</b>  </label>
					<input required name="name" id="name" class="form-control input-md">
				</div>
			</div>

			<div class="row" style="margin-bottom:2%">
				<div class="col-md-6">
					<label ><b>Price :</b>  </label>
					<input required type="number" name="price" id="price" class="form-control input-md">
				</div>

				<div class="col-md-6">
					<label ><b>Image :</b>  </label>
					<input type="file" name="image" id="image" class="form-control input-md">
					<input type="hidden" value="" name="old_image" id="old_image" class="form-control input-md">
				</div>
			</div>

			<div class="row" style="margin-bottom:2%">
				
				<div class="col-md-6">
					<label ><b>Description 1 :</b>  </label>
					<input   name="des[]" id="desc1" class="form-control input-md">
				</div>

				<div class="col-md-6">
					<label ><b>Description 2 :</b>  </label>
					<input    name="des[]" id="desc2" class="form-control input-md">
				</div>
			</div>

			<div class="row" style="margin-bottom:2%">
				
				<div class="col-md-6">
					<label ><b>Description 3 :</b>  </label>
					<input  name="des[]" id="desc3" class="form-control input-md">
				</div>

				<div class="col-md-6">
					<label ><b>Description 4 :</b>  </label>
					<input  name="des[]" id="desc4" class="form-control input-md">
				</div>
			</div>

			<div class="row" style="margin-bottom:2%">
				
				<div class="col-md-6">
					<label ><b>Month :</b>  </label>
					<input required  type="number" name="month" id="month" class="form-control input-md">
				</div>

				<div class="col-md-6">
					<label ><b>Year :</b>  </label>
					<input required  type="number" name="year" id="year" class="form-control input-md">
				</div>
			</div>
      </div>
      <div class="modal-footer">
	  	<button type="submit" class="btn btn-success">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
	  </form>
    </div>

  </div>
</div>

		<?php include 'template/scripts.php'; ?>
		<script type="text/javascript">
    	$( document ).ready(function() {
		
			$('#rb_data_table').DataTable({
					//"destroy":true,
					"processing": true,
					"serverSide": true,
					//"ordering": false,
					//"searching": false,
					"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
					pageLength: 10,
					"language": {
              			processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
          			},
					"ajax":{
					"url": "<?php echo site_url("rb_data/getData"); ?>",
					"dataType": "json",
					"type": "POST",
					"data":{},
					},
					
				});

				$(document).on("change", "#search_make", function(){
					var id = $("#search_make option:selected").attr("data-id");
					var data = {
						code: 2,
						id_make: id
					}
					$.ajax({
						type: "POST",
						url: "<?php echo site_url("fapplication/get_dropdown_data"); ?>",
						cache: false,
						data: data,
						dataType: 'json',
						success: function(result){
								var option = '<option value="">-Model-</option>';
								for (var i in result) 
								{
									option = option+'<option  value="'+result[i].id_family+'">'+result[i].name+'</option>';
								}
								$("#search_model").html(option);
							}
						});

					
					});

					$(document).on("click", ".rb-data-edit", function(){
						var id = $(this).attr("data-id");
						$.ajax({
						type: "POST",
						url: "<?php echo site_url("rb_data/get_rb_detail"); ?>",
						cache: false,
						data: {id:id},
						dataType: 'json',
						success: function(result){
								$("#type").val('update');
								$("#id").val(id);
								$("#search_make").val(result.make_id);
								$("#search_model").empty().html(result.model_data);
								$("#car_id").val(result.car_id);
								$("#name").val(result.name);
								$("#price").val(result.price);
								$("#old_image").val(result.img);
								$("#desc1").val(result.desc1);
								$("#desc2").val(result.desc2);
								$("#desc3").val(result.desc3);
								$("#desc4").val(result.desc4);
								$("#month").val(result.month);
								$("#year").val(result.year);
								$('#myModal').modal('show');
							}
						});
					});
					$('#myModal').on('hidden.bs.modal', function () {
						var option = '<option value="">-Model-</option>';
						$("#search_make").val('');
						$("#search_model").empty().html(option);
						$("#car_id").val('');
						$("#name").val('');
						$("#price").val('');
						//$("#image").val('');
						$("#old_image").val('');
						$("#desc1").val('');
						$("#desc2").val('');
						$("#desc3").val('');
						$("#desc4").val('');
						$("#month").val('');
						$("#year").val('');
					});
					

		});


		</script>
	</body>
</html>
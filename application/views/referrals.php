<?php include 'admin/template/head.php'; ?>
	<body>
		<section class="body">
			<!-- start: header -->
			<?php include 'admin/template/header.php'; ?>
			<!-- end: header -->
			<div class="inner-wrapper">
				<!-- start: sidebar -->
				<?php include 'admin/template/left_sidebar.php'; ?>
				<!-- end: sidebar -->
				<section role="main" class="content-body">
					<?php include 'admin/template/header_2.php'; ?>
					<section class="panel">
						<div class="panel-body">
							<button type="button" class="btn btn-primary" id="new_referral_btn"><i class="fa fa-plus"></i>&nbsp; Refer a car buyer</button><br /><br />
							<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;" id="datatable" >
								<thead>
									<tr>
										<td><center><i class="fa fa-pencil-square-o"></i></center></td>
										<td><b>Status</b></td>
										<td><b>First Name</b></td>
										<td><b>Last Name</b></td>
										<td><b>State</b></td>
										<td><b>Postcode</b></td>
										<td><b>Mobile Number</b></td>
										<td><b>Email</b></td>
										<td><b>Make</b></td>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($referrals as $ref_key => $ref_val)
									{
										?>
										<tr class="tr" data-id="<?= $ref_val['id_referral'] ?>" id="tr_<?= $ref_val['id_referral'] ?>">
											<td align="center"><a href="#" data-id="<?= $ref_val['id_referral'] ?>" class="edit_referral_btn"><i class="fa fa-pencil-square-o"></i></a></td>
											<td><?=  $ref_val['status_text'] ?></td>
											<td id="first_<?= $ref_val['id_referral'] ?>"><?=  $ref_val['first_name'] ?></td>
											<td id="last_<?= $ref_val['id_referral'] ?>"><?=  $ref_val['last_name'] ?></td>
											<td id="state_<?= $ref_val['id_referral'] ?>"><?=  $ref_val['state'] ?></td>
											<td id="postcode_<?= $ref_val['id_referral'] ?>"><?=  $ref_val['postcode'] ?></td>
											<td id="mobile_<?= $ref_val['id_referral'] ?>"><?=  $ref_val['mobile_number'] ?></td>
											<td id="email_<?= $ref_val['id_referral'] ?>"><?=  $ref_val['email_address'] ?></td>
											<td id="make_<?= $ref_val['id_referral'] ?>"><?=  $ref_val['name'] ?></td>
										</tr>
										<?php
									}
									?>
								</tbody>
							</table>

						</div>
					</section>
				</section>	
			</div>
			<?php include 'admin/template/right_sidebar.php'; ?>
			<div id="new_referral_modal" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">REFERRAL FORM</h4>
                        </div>
                        <div class="modal-body">
                            <form method="post" id="new_referral_form" name="new_referral_form">
								<h4>Client Information</h4><br />
                            	<div class="form-group">
									<label class="col-md-4 control-label" for="first_name"><strong>First Name:</strong></label>
									<div class="col-md-8">
										<input type="text" class="form-control input-sm" name="first_name" id="first_name">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="last_name"><strong>Last Name:</strong></label>
									<div class="col-md-8">
										<input type="text" class="form-control input-sm" name="last_name" id="last_name">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="address"><strong>Address:</strong></label>
									<div class="col-md-8">
										<textarea class="form-control input-sm" name="address" id="address"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="state"><strong>State:</strong></label>
									<div class="col-md-8">
										<select name="state" id="state" class="form-control input-sm">
											<option value="NSW">NSW</option>
											<option value="VIC">VIC</option>
											<option value="QLD">QLD</option>
											<option value="WA">WA</option>
											<option value="TAS">TAS</option>
											<option value="NT">NT</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="postcode"><strong>Postcode:</strong></label>
									<div class="col-md-8">
										<input type="text" class="form-control input-sm" name="postcode" id="postcode">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="mobile_number"><strong>Mobile Number:</strong></label>
									<div class="col-md-8">
										<input type="text" class="form-control input-sm" name="mobile_number" id="mobile_number">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="secondary_number"><strong>Secondary Number:</strong></label>
									<div class="col-md-8">
										<input type="text" class="form-control input-sm" name="secondary_number" id="secondary_number">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="email_address"><strong>Email Address:</strong></label>
									<div class="col-md-8">
										<input type="text" class="form-control input-sm" name="email_address" id="email_address">
									</div>
								</div>
								<hr />
								<h4>Vehicle Information</h4><br />
								<div class="form-group">
									<label class="col-md-4 control-label" for="make"><strong>Make:</strong></label>
									<div class="col-md-8">
										<select class="form-control input-sm make" id="make" name="make">
											<option></option>
											<?php
											foreach ($makes as $make_key => $make_val) 
											{
												?>
												<option data-id="<?= $make_val['id_make'] ?>" value="<?= $make_val['id_make'] ?>"><?= $make_val['name'] ?></option>
												<?php
											}
											?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="model"><strong>Model:</strong></label>
									<div class="col-md-8">
										<select class="form-control input-sm model" id="model" name="model">
										
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="variant"><strong>Variant:</strong></label>
									<div class="col-md-8">
										<select class="form-control input-sm variant" id="variant" name="variant"></select>
									</div>
								</div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <span type="button" class="btn btn-primary" id="add_new_referral">Save</span>
                        </div>
                    </div>
                </div>
            </div>		
            <div id="edit_referral_modal" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Edit Referral Details</h4>
                        </div>
                        <div class="modal-body">
                            <form method="post" id="edit_referral_form" name="edit_referral_form">
                            	<input type="hidden" name="hidden_id" id="hidden_id">
								<h4>Client Information</h4><br />
                            	<div class="form-group">
									<label class="col-md-4 control-label" for="first_name"><strong>First Name:</strong></label>
									<div class="col-md-8">
										<input type="text" class="form-control input-sm" name="first_name" id="edit_first_name">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="last_name"><strong>Last Name:</strong></label>
									<div class="col-md-8">
										<input type="text" class="form-control input-sm" name="last_name" id="edit_last_name">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="address"><strong>Address:</strong></label>
									<div class="col-md-8">
										<textarea class="form-control input-sm" name="address" id="edit_address"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="edit_state"><strong>State:</strong></label>
									<div class="col-md-8">
										<select name="state" id="edit_state" class="form-control input-sm">
											<option value="NSW">NSW</option>
											<option value="VIC">VIC</option>
											<option value="QLD">QLD</option>
											<option value="WA">WA</option>
											<option value="TAS">TAS</option>
											<option value="NT">NT</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="postcode"><strong>Postcode:</strong></label>
									<div class="col-md-8">
										<input type="text" class="form-control input-sm" name="postcode" id="edit_postcode">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="mobile_number"><strong>Mobile Number:</strong></label>
									<div class="col-md-8">
										<input type="text" class="form-control input-sm" name="mobile_number" id="edit_mobile_number">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="secondary_number"><strong>Secondary Number:</strong></label>
									<div class="col-md-8">
										<input type="text" class="form-control input-sm" name="secondary_number" id="edit_secondary_number">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="email_address"><strong>Email Address:</strong></label>
									<div class="col-md-8">
										<input type="text" class="form-control input-sm" name="email_address" id="edit_email_address">
									</div>
								</div>
								<h4>Vehicle Information</h4><br />
								<div class="form-group">
									<label class="col-md-4 control-label" for="make"><strong>Make:</strong></label>
									<div class="col-md-8">
										<select class="form-control input-sm make" id="edit_make" name="make">
											<option></option>
											<?php
											foreach ($makes as $make_key => $make_val) 
											{
												?>
												<option data-id="<?= $make_val['id_make'] ?>" value="<?= $make_val['id_make'] ?>"><?= $make_val['name'] ?></option>
												<?php
											}
											?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="model"><strong>Model:</strong></label>
									<div class="col-md-8">
										<select class="form-control input-sm model" id="edit_model" name="model">
										
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="edit_variant"><strong>Variant:</strong></label>
									<div class="col-md-8">
										<select class="form-control input-sm variant" id="edit_variant" name="variant"></select>
									</div>
								</div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <span type="button" class="btn btn-primary" id="submit_edit_referral">Save</span>
                        </div>
                    </div>
                </div>
            </div>
		</section>
		<?php include 'admin/template/scripts.php'; ?>
		<script type="text/javascript">

			var datatables = $('#datatable').DataTable({
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

			$(document).ready(function(){

				$(document).on('change', '.make', function() {
					var selected = $(this).find('option:selected');
					var id = selected.data('id');
					var $this = $(this);
					var this_form = $this.closest("form");

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
					            option = option+'<option data-id="'+result[i].id_family+'" value="'+result[i].id_family+'">'+result[i].name+'</option>';
					          }

							$(document).find(this_form).find(".model").html(option);
						}
					});
			    });

			    $(document).on('change', '.model', function() {
					var selected = $(this).find('option:selected');
					var id = selected.data('id');
					var $this = $(this);
					var this_form = $this.closest("form");
					
					var data = {
			    		code: 3,
			    		id_model: id
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
					            option = option+'<option data-id="'+result[i].id_vehicle+'" value="'+result[i].id_vehicle+'">'+result[i].name+'</option>';
					          }

							$(document).find(this_form).find(".variant").html(option);
						}
					});
			    });

				$(document).on('click', '#new_referral_btn', function(){
					$('#new_referral_modal').modal({
	                    backdrop: 'static',
	                    keyboard: false
	                });
				});

				$(document).on('click', '#add_new_referral', function(){
					var form          = $("#new_referral_form").serialize();
					var this_modal    = $("#new_referral_modal");
					var postcode      = $.trim($("#postcode").val());
					var first_name    = $.trim($("#first_name").val());
					var last_name     = $.trim($("#last_name").val());
					var mobile_number = $.trim($("#mobile_number").val());
					var state         = $.trim($("#state").val());
					var email         = $.trim($("#email_address").val());
					var make          = $.trim($("#make option:selected").text());

					if(postcode == "")
					{
						alert("Postcode must not be blank!");
						return false;
					}
					if(first_name == "")
					{
						alert("First Name must not be blank!");
						return false;
					}
					if(last_name == "")
					{
						alert("Last Name must not be blank!");
						return false;
					}
					if(mobile_number == "")
					{
						alert("Mobile Number must not be blank!");
						return false;
					}

					$.ajax({
						type: "POST",
						url: "<?php echo site_url('user/insert_new_referral'); ?>/",
						data: form,
						cache: false,
						success: function(id) {
							var new_row = '<tr class="tr" data-id="'+id+'" id="tr_'+id+'">\
												<td align="center"><a href="#" data-id="'+id+'" class="edit_referral_btn"><i class="fa fa-pencil-square-o"></i></a></td>\
												<td> Unallocated </td>\
												<td id="first_'+id+'">'+first_name+'</td>\
												<td id="last_'+id+'">'+last_name+'</td>\
												<td id="state_'+id+'">'+state+'</td>\
												<td id="postcode_'+id+'">'+postcode+'</td>\
												<td id="mobile_'+id+'">'+mobile_number+'</td>\
												<td id="email_'+id+'">'+email+'</td>\
												<td id="make_'+id+'">'+make+'</td>\
											</tr>';
							datatables.row.add($(new_row)).draw();
							this_modal.modal('hide');
						}
					});
				});

				$(document).on('click', '.edit_referral_btn', function(){
					var this_modal = $("#edit_referral_modal");
					var id = $(this).data("id");

					var data ={
						id:id
					}

					$.ajax({
						type: "POST",
						url: "<?php echo site_url('user/get_referral'); ?>/",
						data: data,
						cache: false,
						dataType: 'json',
						success: function(data) {
							this_modal.find("#hidden_id").val(id);
							this_modal.find("#edit_first_name").val(data.first_name);
							this_modal.find("#edit_last_name").val(data.last_name);
							this_modal.find("#edit_address").val(data.address);
							this_modal.find("#edit_state").val(data.state);
							this_modal.find("#edit_postcode").val(data.postcode);
							this_modal.find("#edit_mobile_number").val(data.mobile_number);
							this_modal.find("#edit_secondary_number").val(data.secondary_number);
							this_modal.find("#edit_email_address").val(data.email_address);
							this_modal.find("#edit_make").val(data.make_id);
							this_modal.find("#edit_model").html(data.model_string);
							this_modal.find("#edit_variant").html(data.variant_string);

							$('#edit_referral_modal').modal({
			                    backdrop: 'static',
			                    keyboard: false
			                });
						}
					});
				});

				$(document).on('click', '#submit_edit_referral', function(){
					var form = $("#edit_referral_form").serialize();

					var id = $("#hidden_id").val();

					var this_modal = $("#edit_referral_modal");

					var postcode      = $.trim($("#edit_postcode").val());
					var first_name    = $.trim($("#edit_first_name").val());
					var last_name     = $.trim($("#edit_last_name").val());
					var mobile_number = $.trim($("#edit_mobile_number").val());
					var state         = $.trim($("#edit_state").val());
					var email         = $.trim($("#edit_email_address").val());
					var make          = $.trim($("#edit_make option:selected").text());

					if(postcode == "")
					{
						alert("Postcode must not be blank!");
						return false;
					}
					if(first_name == "")
					{
						alert("First Name must not be blank!");
						return false;
					}
					if(last_name == "")
					{
						alert("Last Name must not be blank!");
						return false;
					}
					if(mobile_number == "")
					{
						alert("Mobile Number must not be blank!");
						return false;
					}

					$.ajax({
						type: "POST",
						url: "<?php echo site_url('user/update_referral'); ?>/",
						data: form,
						cache: false,
						success: function(result) {
							$("#status_"+String(id)).text(status);
							$("#first_"+String(id)).text(first_name);
							$("#last_"+String(id)).text(last_name);
							$("#mobile_"+String(id)).text(mobile_number);
							$("#state_"+String(id)).text(state);
							$("#email_"+String(id)).text(email);
							$("#make_"+String(id)).text(make);
							datatables.draw();
							this_modal.modal('hide');
						}
					});
				});
			});
		</script>
	</body>
</html>
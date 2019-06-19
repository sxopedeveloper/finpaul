<?php include 'template/head.php'; ?>
	<body>
		<style type="text/css">
			#add-cc {
				cursor: pointer; 
				cursor: hand;
			}

			#insert_cc {
				cursor: pointer; 
				cursor: hand;	
			}

			.row-input {
				margin-bottom: 10px;
			}

			.panel-cc {
				margin-bottom: 10px;
			}

			.panel-body-cc {
				background-color: #e5e5e5;
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
						<div class="panel panel-default">
							<div class="panel-body">
								<h4>Balance: </h4>
								<p><h5>AUD <?= $balance ?></h5></p>
							</div>
						</div>
						<span class="btn btn-primary btn-sm pull-right" id="add-cc"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Add a credit card</span> <br><br>
						<div class="panel panel-default">
							<div class="panel-body">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>Credit Card Type</th>
											<th>Credit Card Number</th>
											<th>Card Holder's Name</th>
											<th>Expiration Date</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if (count($token_infos) > 0)
										{
											foreach ($token_infos as $token_key => $token_value) 
											{
												?>
												<tr class="parent_tr">
													<td><?= $token_value['card_type'] ?></td>
													<td class="child_td" data-id="<?= $token_value['id'] ?>">************<i><?= $token_value['cc_ending']; ?></i></td>
													<td><?= $token_value['first_name'] ?> &nbsp; <?= $token_value['last_name'] ?></td>
													<td><?= $token_value['exp_month'] ?>&nbsp;/&nbsp;<?= $token_value['exp_year'] ?></td>
													<td>
														<div class="btn-group">
															<i class="fa fa-trash-o"></i>
														</div>
													</td>
												</tr>
												<?php
											}
										}
										else
										{
											?>
											<tr><td colspan=5><p><i>No Credit Card information added yet...</i></p></td></tr>
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
					<div id="payment-insert" class="modal fade" tabindex="-1" role="dialog">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="myModalLabel">Add a new Credit Card</h4>
								</div>
								<div class="modal-body">
									<form method="post" id="insert_cc_info" name="insert_cc_info">
										<input type="hidden" id="user_id" value="<?= $user_id; ?>" name="user_id">
										<div class="row row-input">
											<div class="col-md-4">
												<label>Title: </label>
											</div>
											<div class="col-md-8">
												<select class="form-control input-sm" id="title" name="title">
													<option value="Mr">Mr</option>
													<option value="Mrs">Mrs</option>
													<option value="Mss">Ms</option>
												</select>
											</div>
										</div>
										<div class="row row-input">
											<div class="col-md-4">
												<label>First Name: </label>
											</div>
											<div class="col-md-8">
												<input type="text" class="form-control input-sm" name="first_name" id="first_name">
											</div>
										</div>
										<div class="row row-input">
											<div class="col-md-4">
												<label>Last Name: </label>
											</div>
											<div class="col-md-8">
												<input type="text" class="form-control input-sm" name="last_name" id="last_name">
											</div>
										</div>
										<div class="row row-input">
											<div class="col-md-4">
												<label>Credit Card Number: </label>
											</div>
											<div class="col-md-8">
												<input type="text" class="form-control input-sm" name="cc_number" id="cc_number" placeholder="Visa or Mastercard only. No spaces and/or dashes">
											</div>
										</div>
										<div class="row row-input">
											<div class="col-md-4">
												<label>Credit Card Type: </label>
											</div>
											<div class="col-md-8">
												<input type="text" class="form-control input-sm" name="card_type" id="card_type" disabled>
											</div>
										</div>
										<div class="row row-input">
											<div class="col-md-4">
												<label>Card Expiry: </label>
											</div>
											<div class="col-md-4">
												<select class="form-control input-sm" id="exp_month" name="exp_month">
													<?php
													for ($i=1; $i < 13; $i++) 
													{ 
														echo "<option value='{$i}'>{$i}</option>";
													}
													?>
												</select>
											</div>
											<div class="col-md-4">
												<select class="form-control input-sm" id="exp_year" name="exp_year">
													<?php
													for ($i=16; $i < 51; $i++) 
													{ 
														echo "<option value='{$i}'>{$i}</option>";
													}
													?>
												</select>
											</div>
										</div>
										<div class="row row-input">
											<div class="col-md-4">
												<label>CVN: </label>
											</div>
											<div class="col-md-8">
												<input type="text" class="form-control input-sm" name="cvn" id="cvn">
											</div>
										</div>
									</form>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									<span type="button" class="btn btn-primary" id="insert_cc" disabled>Save Info</span>
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
				$("#add-cc").click(function(){
					$("#payment-insert").modal({
		                    backdrop: "static",
		                    keyboard: false
	                });
				});

				$("#insert_cc").click(function(){
					$("#card_type").attr("disabled", false);
					
					var form_data = $("#insert_cc_info").serialize();

					$.ajax({
						type: "POST",
						url: "<?php echo site_url("payment/insert_token_info"); ?>",
						cache: false,
						data: form_data,
						dataType: "json",
						success: function(response){
							alert(response.message);
							
							if (response.message != "fail")
							{
								$("#payment-insert").modal("hide");

								$("#insert_cc_info").find(".form-control").each(function(){
									$(this).val('');
								});

								location.reload();
							}
						}
					});
				});

				$(document).on("click", ".del_token", function(){
					var that = $(this);
					var id = that.closest(".parent_tr").find(".child_td").data("id");

					if (! confirm("Are you sure you want to delete this credit card info?"))
					{
						return false;
					}
					
					var data = {
						id: id
					}

					$.ajax({
						type: "POST",
						url: "<?php echo site_url("payment/delete_token"); ?>",
						cache: false,
						data: data,
						success: function(response){
							if(response == "success")
							{
								that.closest(".parent_tr").remove();
							}
							else
							{
								alert("Something went wrong! Please report this problem immediately!");
							}
						}
					});
				});

				$(document).on("change", "#cc_number", function(){
					var master = /^(?:5[1-5][0-9]{14})$/;
					var visa = /^(?:4[0-9]{12}(?:[0-9]{3})?)$/;  
					var inputtxt = $(this).val().replace(' ', '');
					if(inputtxt.match(master))  
			        {  
						$("#card_type").val("Mastercard");
						$("#insert_cc").attr("disabled", false);
			        }
			        else if(inputtxt.match(visa))
			        {
			        	$("#card_type").val("Visa");
			        	$("#insert_cc").attr("disabled", false);
			        }
					else  
			        {  
			        	$("#insert_cc").attr("disabled", true);
				        alert("Not a valid Mastercard or Visa number!");
			        }
				});

				$("#cc_number").on("keydown", function (e){
				    if (e.which === 32)
					{
						return false;
					}
				});
			});
		</script>
	</body>
</html>
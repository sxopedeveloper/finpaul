<?php include 'template/head.php'; ?>
	<body>
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
							<h2 class="panel-title">Get Data</h2>
						</header>
						<div class="panel-body"> <?php //print_r($makes_row); ?>
							<form action="" method="post" accept-charset="utf-8">
								<div class="row">
									<div class="form-group">
										<div class="col-md-6 text-left">
											<label>* User Type:</label>
											<select class="form-control input-md" id="make" name="make">
											<option>Make</option>
											<?php 
											
												foreach ($makes_row as $m_key => $m_val) 
												{
													?>
													<option <?= ((trim($make)==trim($m_val->name)) ? "selected":"") ?> value='<?= $m_val->name ?>'  ><?= $m_val->name ?></option>
													<?php
												}
											?>
										</select>
										</div>
										<div class="col-md-2"><label>&nbsp;</label>
										<input value="Get Data" name="submit" class="form-control btn btn-primary  push-bottom" data-loading-text="Loading..." type="submit">
									</div>
									</div>
								</div>
								
							</form>
							
							<?php  if(!empty($cars_list)){?><br><br>
							<table border="1" cellpadding="5px" cellspacing="5px" style="width: 80%; border: 1px solid #ccc;  margin: 0 auto;">	
								<tr>
									<th  style="text-align:center"></th>
									<th  style="text-align:center">Name </th>
									<th  style="text-align:center">Price</th>
									<th  style="text-align:center">Desc</th>
								</tr>	
							<?php foreach($cars_list as $key => $val){ ?>
								<tr>
									<td></td>
									<td><?php echo $val['name']; ?></td>
									<td><?php echo $val['price']; ?></td>
									<td>
										<?php  if(!empty( $val['desc'])){?><ul>
											<?php foreach( $val['desc'] as $v){ ?>
											<li><?php echo $v ?></li>
										<?php }?>
										</ul>
										<?php } ?>
									</td>
								</tr>	
							<?php } ?>
							</table>
							<?php } ?>				
						</div>
					</section>
					<!-- end: page -->
					
				</section>
			</div>
			<?php include 'template/right_sidebar.php'; ?>
		</section>
		<?php include 'template/scripts.php'; ?>
		<script>
			function check_user_type (user_type)
			{
				if (user_type == 1)
				{
					$("#dealership_details").show();
					$("#staff_details").hide();
				}
				else if (user_type == 2)
				{
					$("#staff_details").show();
					$("#dealership_details").hide();
				}
				else if (user_type==4 || user_type==3)
				{
					$("#staff_details").hide();
					$("#dealership_details").hide();
				}
			}
		</script>
	</body>
</html>
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
						<div class="panel-body">
							<div class="row">
								<section class="col-lg-12">
									<div class="box box-primary" id="">
										<div class="box-group" id="accordion">
											<div class="box-header" style="padding-right: 20px;">
												<h4 class="box-title pull-right">
													<span style="cursor: pointer; cursor: hand;" class="collapsed add_new_button_modal" id="add_new_button_modal">
														<i class="fa fa-fw fa-plus-square"></i> Add New
													</span>
												</h4>
											</div>
										</div>
									</div>
								</section>
							</div>
							<div class="row">
								<section class="col-xs-12"> 
									<div class="box box-primary">
										<div class="box-header">
											<h3 class="box-title">Advertisements</h3>                                    
										</div>
										<div class="box-body table-responsive">
											<form class="form-inline pull-right" action="<?php echo site_url('google_ad/list_view'); ?>" method="get" accept-charset="utf-8">
												<?php
												$heading_1_line_1 = isset($_GET['heading_1_line_1']) ? $_GET['heading_1_line_1'] : '';
												$heading_1_line_2 = isset($_GET['heading_1_line_2']) ? $_GET['heading_1_line_2'] : '';
												?>
												<div class="form-group">
													<label class="sr-only">Heading 1 Line 1</label>
													<input type="text" class="form-control" placeholder="Heading Line 1" name="heading_1_line_1" value="<?php echo $heading_1_line_1; ?>">
												</div>
												<div class="form-group">
													<label class="sr-only">Heading 1 Line 2</label>
													<input type="text" class="form-control" placeholder="Heading Line 2" name="heading_1_line_2" value="<?php echo $heading_1_line_2; ?>">
												</div>
												<button type="submit" class="btn btn-default">Search</button>
											</form>
											<br /><br />
											<?php echo $links; ?>
											<table id="table_pages" class="table table-bordered table-hover">
												<thead>
													<tr>
														<th>AD</th>
														<th colspan="2" class="text-center">Action</th>
													</tr>
												</thead>
												<tbody id="table_body">
													<?php if( isset($google_ads) ):  foreach( $google_ads as $ad ): ?>
														<tr class="tr_ads" id="tr_ads_<?= $ad->id_advertisement ?>">
															<td id="td_<?= $ad->id_advertisement ?>">
																<a class="header_url" href="<?php echo $ad->root.'/'.$ad->id_advertisement.'/'.$ad->slug; ?>" target="_blank">
																	<?php echo '<span class="heading_1" style="display:block; color: #1a0dab; font-size: 18px;">'.$ad->heading_1_line_1_text.' '.$ad->heading_1_line_2_text.'</span>'; ?>
																</a>
																<?php echo '<span  style="display:block; color: #1a0dab;" class="heading_2">'.$ad->heading_2_text.'</span>'; ?>
																<?php echo '<span style="display:block; color: #006621;" class="heading_2_url">'.$ad->root.'/'.$ad->id_advertisement.'/'.$ad->slug.'</span>'; ?>
																<?php echo '<span style="display:block; color: #545454;" class="lists">'.$ad->description.'</span>'; ?>
															</td>
															<td class="text-center">
																<span style="cursor: pointer; cursor: hand;" title="Edit" class="edit_button" data-id="<?php echo $ad->id_advertisement; ?>">
																	<i class="fa fa-pencil"></i>
																</span>
															</td>
															<td class="text-center">
																<span style="cursor: pointer; cursor: hand;" title="Delete" class="delete_button" data-id="<?php echo $ad->id_advertisement; ?>">
																	<i class="fa fa-trash-o"></i>
																</span>
															</td>
														</tr>
													<?php endforeach; endif; ?>
												</tbody>
											</table>
											<?php echo $links; ?>
										</div>
									</div>
								</section>
							</div>
						</div>
					</section>
					<!-- end: page -->
					<?php include 'modals/ticket_modals.php'; ?>
					<div id="google_ad" class="modal fade"> <!-- Add Modal -->
						<div class="modal-dialog" style="width: 90%;">
							<section class="panel">
								<form method="post" id="google_ad_form" name="google_ad_form" action="">
									<div class="panel-body">
										<div class="modal-wrapper">
											<div class="modal-text">
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label">Landing Page:</label>
															<select class="form-control" id="fk_landing_page" name="fk_landing_page" required>
																<option value="0"></option>
																<?php
																if (isset($landing_pages))
																{
																	foreach ($landing_pages as $landing_page)
																	{
																		?>
																		<option value="<?php echo $landing_page->id_landing_page; ?>"><?php echo $landing_page->root; ?></option>
																		<?php
																	}
																}
																?>
															</select>
														</div>	
														<br />
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label">Make:</label>
															<select class="form-control" id="fk_make" name="fk_make" disabled>
																<option value="0"></option>
																<?php
																if (isset($makes))
																{
																	foreach ($makes as $make)
																	{
																		?>
																		<option value="<?php echo $make->id_make; ?>"><?php echo $make->name; ?></option>
																		<?php
																	}
																}
																?>
															</select>
														</div>	
														<br />
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label">Model:</label>
															<select class="form-control" id="fk_family" name="fk_family" disabled>
																<option value="0"></option>
															</select>
														</div>	
														<br />
													</div>
												</div>												
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label">Description:</label>
															<input type="text" id="description" class="form-control" name="description" value="">
														</div>	
														<br />
													</div>
												</div>												
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Heading 1 Line 1:</label>
															<input type="text" class="form-control" id="heading_1_line_1_text" name="heading_1_line_1_text" value="" required>
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Size (em)</label>
															<input type="text" class="form-control" name="heading_1_line_1_font_size" value="1.70">
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Weight</label>
															<select class="form-control" name="heading_1_line_1_font_weight">
																<option value="">-Select-</option>
																<option value="100">100</option>
																<option value="200">200</option>
																<option value="300">300</option>
																<option value="400" selected>400</option>
																<option value="500">500</option>
																<option value="600">600</option>
																<option value="700">700</option>
																<option value="800">800</option>
																<option value="900">900</option>
															</select>
														</div>
														<br />
													</div>								
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Heading 1 Line 2:</label>
															<input type="text" class="form-control" id="heading_1_line_2_text" name="heading_1_line_2_text" value="Clients Saved $3722 Per Car" required>
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Size (em)</label>
															<input type="text" class="form-control" name="heading_1_line_2_font_size" value="3.00">
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Weight</label>
															<select class="form-control" name="heading_1_line_2_font_weight">
																<option value="">-Select-</option>
																<option value="100">100</option>
																<option value="200">200</option>
																<option value="300">300</option>
																<option value="400">400</option>
																<option value="500">500</option>
																<option value="600">600</option>
																<option value="700">700</option>
																<option value="800">800</option>
																<option value="900" selected>900</option>
															</select>
														</div>
														<br />
													</div>								
												</div>
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label">Slug:</label>
															<input type="text" id="slug" class="form-control" name="slug">
														</div>	
														<br />
													</div>
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Heading 2:</label>
															<input type="text" class="form-control" id="heading_2_text" name="heading_2_text" value="" required>
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Size (em)</label>
															<input type="text" class="form-control" name="heading_2_font_size" value="1.30">
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Weight</label>
															<select class="form-control" name="heading_2_font_weight">
																<option value="">-Select-</option>
																<option value="100">100</option>
																<option value="200">200</option>
																<option value="300">300</option>
																<option value="400" selected>400</option>
																<option value="500">500</option>
																<option value="600">600</option>
																<option value="700">700</option>
																<option value="800">800</option>
																<option value="900">900</option>
															</select>
														</div>
														<br />
													</div>								
												</div>	
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Heading 3:</label>
															<input type="text" class="form-control" id="heading_3_text" name="heading_3_text" value="Quotes Are Free" required>
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Size (em)</label>
															<input type="text" class="form-control" name="heading_3_font_size" value="1.30">
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Weight</label>
															<select class="form-control" name="heading_3_font_weight">
																<option value="">-Select-</option>
																<option value="100">100</option>
																<option value="200">200</option>
																<option value="300">300</option>
																<option value="400" selected>400</option>
																<option value="500">500</option>
																<option value="600">600</option>
																<option value="700">700</option>
																<option value="800">800</option>
																<option value="900">900</option>
															</select>
														</div>
														<br />
													</div>								
												</div>		
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">List 1:</label>
															<input type="text" class="form-control" id="list_1_text" name="list_1_text" value="Get Multiple Quotes Without Going To Dealership" required>
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Size (em)</label>
															<input type="text" class="form-control" name="list_1_font_size" value="1.05">
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Weight</label>
															<select class="form-control" name="list_1_font_weight">
																<option value="">-Select-</option>
																<option value="100">100</option>
																<option value="200">200</option>
																<option value="300">300</option>
																<option value="400" selected>400</option>
																<option value="500">500</option>
																<option value="600">600</option>
																<option value="700">700</option>
																<option value="800">800</option>
																<option value="900">900</option>
															</select>
														</div>
														<br />
													</div>								
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">List 2:</label>
															<input type="text" class="form-control" id="list_2_text" name="list_2_text" value="Free To Try & No Obligation" required>
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Size (em)</label>
															<input type="text" class="form-control" name="list_2_font_size" value="1.05">
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Weight</label>
															<select class="form-control" name="list_2_font_weight">
																<option value="">-Select-</option>
																<option value="100">100</option>
																<option value="200">200</option>
																<option value="300">300</option>
																<option value="400" selected>400</option>
																<option value="500">500</option>
																<option value="600">600</option>
																<option value="700">700</option>
																<option value="800">800</option>
																<option value="900">900</option>
															</select>
														</div>
														<br />
													</div>								
												</div>	
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">List 3:</label>
															<input type="text" class="form-control" id="list_3_text" name="list_3_text" value="Expert Advice & Guidance" required>
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Size (em)</label>
															<input type="text" class="form-control" name="list_3_font_size" value="1.05">
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Weight</label>
															<select class="form-control" name="list_3_font_weight">
																<option value="">-Select-</option>
																<option value="100">100</option>
																<option value="200">200</option>
																<option value="300">300</option>
																<option value="400" selected>400</option>
																<option value="500">500</option>
																<option value="600">600</option>
																<option value="700">700</option>
																<option value="800">800</option>
																<option value="900">900</option>
															</select>
														</div>
														<br />
													</div>								
												</div>	
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">List 4:</label>
															<input type="text" class="form-control" id="list_4_text" name="list_4_text" value="Find Out Who Valued Your Car Highest" required>
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Size (em)</label>
															<input type="text" class="form-control" name="list_4_font_size" value="1.05">
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Weight</label>
															<select class="form-control" name="list_4_font_weight">
																<option value="">-Select-</option>
																<option value="100">100</option>
																<option value="200">200</option>
																<option value="300">300</option>
																<option value="400" selected>400</option>
																<option value="500">500</option>
																<option value="600">600</option>
																<option value="700">700</option>
																<option value="800">800</option>
																<option value="900">900</option>
															</select>
														</div>
														<br />
													</div>								
												</div>	
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Heading 4 Line 1:</label>
															<input type="text" class="form-control" id="heading_4_line_1_text" name="heading_4_line_1_text" value="Just car dealers bidding for your business" required>
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Size (em)</label>
															<input type="text" class="form-control" name="heading_4_line_1_font_size" value="1.30">
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Weight</label>
															<select class="form-control" name="heading_4_line_1_font_weight">
																<option value="">-Select-</option>
																<option value="100">100</option>
																<option value="200">200</option>
																<option value="300">300</option>
																<option value="400">400</option>
																<option value="500" selected>500</option>
																<option value="600">600</option>
																<option value="700">700</option>
																<option value="800">800</option>
																<option value="900">900</option>
															</select>
														</div>
														<br />
													</div>								
												</div>							
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Heading 4 Line 2:</label>
															<input type="text" class="form-control" id="heading_4_line_2_text" name="heading_4_line_2_text" value="Find out how much you can save now today!" required>
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Size (em)</label>
															<input type="text" class="form-control" name="heading_4_line_2_font_size" value="1.30">
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Weight</label>
															<select class="form-control" name="heading_4_line_2_font_weight">
																<option value="">-Select-</option>
																<option value="100">100</option>
																<option value="200">200</option>
																<option value="300">300</option>
																<option value="400">400</option>
																<option value="500" selected>500</option>
																<option value="600">600</option>
																<option value="700">700</option>
																<option value="800">800</option>
																<option value="900">900</option>
															</select>
														</div>
														<br />
													</div>								
												</div>	
												<div class="row">
													<div class="col-md-12">
														<div class="dropzone upload_add_ads_image"></div>
														<div id="add_car_photos" hidden></div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel-footer text-right">
										<span class="btn btn-primary" id="submit_ad">Submit</span>
										<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
											Cancel
										</button>
									</div>					
								</form>
							</section>
						</div>
					</div>
					<div id="google_edit" class="modal fade"> <!-- Edit Modal -->
						<div class="modal-dialog" style="width: 90%;">
							<section class="panel">
								<form method="post" id="google_ad_update_form" name="google_ad_update_form" action="">
									<input type="hidden" id="ads_id" name="ads_id" value="" />
									<div class="panel-body">
										<div class="modal-wrapper">
											<div class="modal-text">
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label">Landing Page:</label>
															<select class="form-control" id="fk_landing_page" name="fk_landing_page" required>
																<option value="0"></option>
																<?php
																if (isset($landing_pages))
																{
																	foreach ($landing_pages as $landing_page)
																	{
																		?>
																		<option value="<?php echo $landing_page->id_landing_page; ?>"><?php echo $landing_page->root; ?></option>
																		<?php
																	}
																}
																?>
															</select>
														</div>	
														<br />
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label">Make:</label>
															<select class="form-control" id="fk_make" name="fk_make" required>
																<option value="0"></option>
																<?php
																if (isset($makes))
																{
																	foreach ($makes as $make)
																	{
																		?>
																		<option value="<?php echo $make->id_make; ?>"><?php echo $make->name; ?></option>
																		<?php
																	}
																}
																?>
															</select>
														</div>	
														<br />
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label">Model:</label>
															<select class="form-control" id="fk_family" name="fk_family">
																<option value="0"></option>
															</select>
														</div>	
														<br />
													</div>
												</div>												
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label">Description:</label>
															<input type="text" id="description" class="form-control" name="description" value="">
														</div>	
														<br />
													</div>
												</div>												
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Heading 1 Line 1:</label>
															<input type="text" class="form-control" id="heading_1_line_1_text" name="heading_1_line_1_text" value="" required>
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Size (em)</label>
															<input type="text" class="form-control" name="heading_1_line_1_font_size" value="1.70">
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Weight</label>
															<select class="form-control" name="heading_1_line_1_font_weight">
																<option value="">-Select-</option>
																<option value="100">100</option>
																<option value="200">200</option>
																<option value="300">300</option>
																<option value="400" selected>400</option>
																<option value="500">500</option>
																<option value="600">600</option>
																<option value="700">700</option>
																<option value="800">800</option>
																<option value="900">900</option>
															</select>
														</div>
														<br />
													</div>								
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Heading 1 Line 2:</label>
															<input type="text" class="form-control" id="heading_1_line_2_text" name="heading_1_line_2_text" value="" required>
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Size (em)</label>
															<input type="text" class="form-control" name="heading_1_line_2_font_size" value="2.30">
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Weight</label>
															<select class="form-control" name="heading_1_line_2_font_weight">
																<option value="">-Select-</option>
																<option value="100">100</option>
																<option value="200">200</option>
																<option value="300">300</option>
																<option value="400">400</option>
																<option value="500">500</option>
																<option value="600">600</option>
																<option value="700">700</option>
																<option value="800">800</option>
																<option value="900" selected>900</option>
															</select>
														</div>
														<br />
													</div>								
												</div>
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label">Slug:</label>
															<input type="text" id="slug" class="form-control" name="slug">
														</div>	
														<br />
													</div>
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Heading 2:</label>
															<input type="text" class="form-control" id="heading_2_text" name="heading_2_text" value="" required>
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Size (em)</label>
															<input type="text" class="form-control" name="heading_2_font_size" value="1.30">
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Weight</label>
															<select class="form-control" name="heading_2_font_weight">
																<option value="">-Select-</option>
																<option value="100">100</option>
																<option value="200">200</option>
																<option value="300">300</option>
																<option value="400" selected>400</option>
																<option value="500">500</option>
																<option value="600">600</option>
																<option value="700">700</option>
																<option value="800">800</option>
																<option value="900">900</option>
															</select>
														</div>
														<br />
													</div>								
												</div>	
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Heading 3:</label>
															<input type="text" class="form-control" id="heading_3_text" name="heading_3_text" value="" required>
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Size (em)</label>
															<input type="text" class="form-control" name="heading_3_font_size" value="1.30">
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Weight</label>
															<select class="form-control" name="heading_3_font_weight">
																<option value="">-Select-</option>
																<option value="100">100</option>
																<option value="200">200</option>
																<option value="300">300</option>
																<option value="400" selected>400</option>
																<option value="500">500</option>
																<option value="600">600</option>
																<option value="700">700</option>
																<option value="800">800</option>
																<option value="900">900</option>
															</select>
														</div>
														<br />
													</div>								
												</div>		
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">List 1:</label>
															<input type="text" class="form-control" id="list_1_text" name="list_1_text" value="Get Multiple Quotes Without Going To Dealership" required>
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Size (em)</label>
															<input type="text" class="form-control" name="list_1_font_size" value="1.05">
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Weight</label>
															<select class="form-control" name="list_1_font_weight">
																<option value="">-Select-</option>
																<option value="100">100</option>
																<option value="200">200</option>
																<option value="300">300</option>
																<option value="400" selected>400</option>
																<option value="500">500</option>
																<option value="600">600</option>
																<option value="700">700</option>
																<option value="800">800</option>
																<option value="900">900</option>
															</select>
														</div>
														<br />
													</div>								
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">List 2:</label>
															<input type="text" class="form-control" id="list_2_text" name="list_2_text" value="Free To Try & No Obligation" required>
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Size (em)</label>
															<input type="text" class="form-control" name="list_2_font_size" value="1.05">
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Weight</label>
															<select class="form-control" name="list_2_font_weight">
																<option value="">-Select-</option>
																<option value="100">100</option>
																<option value="200">200</option>
																<option value="300">300</option>
																<option value="400" selected>400</option>
																<option value="500">500</option>
																<option value="600">600</option>
																<option value="700">700</option>
																<option value="800">800</option>
																<option value="900">900</option>
															</select>
														</div>
														<br />
													</div>								
												</div>	
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">List 3:</label>
															<input type="text" class="form-control" id="list_3_text" name="list_3_text" value="Expert Advice & Guidance" required>
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Size (em)</label>
															<input type="text" class="form-control" name="list_3_font_size" value="1.05">
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Weight</label>
															<select class="form-control" name="list_3_font_weight">
																<option value="">-Select-</option>
																<option value="100">100</option>
																<option value="200">200</option>
																<option value="300">300</option>
																<option value="400" selected>400</option>
																<option value="500">500</option>
																<option value="600">600</option>
																<option value="700">700</option>
																<option value="800">800</option>
																<option value="900">900</option>
															</select>
														</div>
														<br />
													</div>								
												</div>	
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">List 4:</label>
															<input type="text" class="form-control" id="list_4_text" name="list_4_text" value="Find Out Who Valued Your Car Highest" required>
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Size (em)</label>
															<input type="text" class="form-control" name="list_4_font_size" value="1.05">
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Weight</label>
															<select class="form-control" name="list_4_font_weight">
																<option value="">-Select-</option>
																<option value="100">100</option>
																<option value="200">200</option>
																<option value="300">300</option>
																<option value="400" selected>400</option>
																<option value="500">500</option>
																<option value="600">600</option>
																<option value="700">700</option>
																<option value="800">800</option>
																<option value="900">900</option>
															</select>
														</div>
														<br />
													</div>								
												</div>	
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Heading 4 Line 1:</label>
															<input type="text" class="form-control" id="heading_4_line_1_text" name="heading_4_line_1_text" value="Just car dealers bidding for your business" required>
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Size (em)</label>
															<input type="text" class="form-control" name="heading_4_line_1_font_size" value="1.30">
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Weight</label>
															<select class="form-control" name="heading_4_line_1_font_weight">
																<option value="">-Select-</option>
																<option value="100">100</option>
																<option value="200">200</option>
																<option value="300">300</option>
																<option value="400">400</option>
																<option value="500" selected>500</option>
																<option value="600">600</option>
																<option value="700">700</option>
																<option value="800">800</option>
																<option value="900">900</option>
															</select>
														</div>
														<br />
													</div>								
												</div>							
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Heading 4 Line 2:</label>
															<input type="text" class="form-control" id="heading_4_line_2_text" name="heading_4_line_2_text" value="Find out how much you can save now today!" required>
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Size (em)</label>
															<input type="text" class="form-control" name="heading_4_line_2_font_size" value="1.30">
														</div>
														<br />
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="control-label">Font Weight</label>
															<select class="form-control" name="heading_4_line_2_font_weight">
																<option value="">-Select-</option>
																<option value="100">100</option>
																<option value="200">200</option>
																<option value="300">300</option>
																<option value="400">400</option>
																<option value="500" selected>500</option>
																<option value="600">600</option>
																<option value="700">700</option>
																<option value="800">800</option>
																<option value="900">900</option>
															</select>
														</div>
														<br />
													</div>								
												</div>	
												<div class="row">
													<div class="col-md-12">
														<img id="edit_img_display" src="http://www.mytradevaluation.com.au/uploads/no_image.png" class="img-responsive" style="width: 100%; border: 1px solid #ddd; border-radius: 5px;">
														<br />
														<div class="dropzone upload_edit_ads_image"></div>														
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel-footer text-right">
										<span class="btn btn-primary" id="submit_ad_edit">Submit</span>
										<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
											Cancel
										</button>
									</div>					
								</form>
							</section>
						</div>
					</div>					
				</section>
			</div>
			<?php include 'template/right_sidebar.php'; ?>
		</section>
		<?php include 'template/scripts.php'; ?>
		<script>
			Dropzone.autoDiscover = false;
			
			$(document).find('.upload_add_ads_image').dropzone ({
			    url: '<?php echo site_url('google_ad/temp_upload'); ?>',
			    init: function() {
			        this.on("sending", function(file, xhr, formData){
						
					}),
					this.on("success", function(file, response){
						$("#add_car_photos").append('<input type="hidden" name="add_ad_car_photo" value="'+response+'">');
					}),
					this.on("queuecomplete", function () {
					    
					});
				},
			});

			$(document).find('.upload_edit_ads_image').dropzone ({
			    url: '<?php echo site_url('google_ad/edit_upload'); ?>',
			    init: function() {
			        this.on("sending", function(file, xhr, formData){
						var id = $("#google_edit").find('#ads_id').val();
						formData.append("id", id);
					}),
					this.on("success", function(file, response){
						$("#google_edit").find("#edit_img_display").attr("src", response)
					}),
					this.on("queuecomplete", function () {
					    this.removeAllFiles();
					});
				},
			});

			$(document).ready(function() {
				
				$(document).on("click", "#add_new_button_modal", function(){
					$("#google_ad").modal();
				});

				$(document).on("click", "#submit_ad", function(event){

					var panel = $(document).find("#table_body").find(".tr_ads:first").clone();
					var heading_1_line_1_text = $("#google_ad").find("#heading_1_line_1_text").val();
					var heading_1_line_2_text = $("#google_ad").find("#heading_1_line_2_text").val();
					var heading_2_text        = $("#google_ad").find("#heading_2_text").val();
					var description           = $("#google_ad").find("#description").val();
					var list_1_text           = $("#google_ad").find("#list_1_text").val();
					var list_2_text           = $("#google_ad").find("#list_2_text").val();
					var list_3_text           = $("#google_ad").find("#list_3_text").val();
					var landing_root          = $("#google_ad").find("#fk_landing_page option:selected").text();
					var slug                  = $("#google_ad").find("#slug").val();
					var header_url_text       = heading_1_line_1_text + " " + heading_1_line_2_text;
					
					$.ajax({
						type: "post",
						url: "<?php echo site_url('google_ad/insert_record'); ?>",
						data: $("#google_ad_form").serialize(),
						cache: false,
						success: function(id) {
							
							var url = landing_root +"/"+id +"/"+ slug;

							panel.find(".header_url").attr("href", url);
							panel.find(".heading_1").text(header_url_text);
							panel.find(".heading_2").text(heading_2_text);
							panel.find(".heading_2_url").text(url);
							panel.find(".lists").text(description);
							panel.find(".edit_button").data("id", id);
							panel.find(".delete_button").data("id", id);

							panel.find(".heading_2_url").text(url);
							
							$("#table_body").prepend(panel);
							$("#google_ad").modal("hide");
						}
					});
					event.preventDefault();
				});

				$(document).on("click", ".edit_button", function(){

					var ads_id = $(this).data("id");

					$("#google_edit img").attr("src", "");
					$.ajax({
						type: "post",
						url: "<?php echo site_url('google_ad/get_ads'); ?>",
						data: { id: ads_id },
						dataType: "json",
						success: function(test) {
							$("#google_edit").find("#fk_landing_page").val(test[0]["fk_landing_page"]);
							$("#google_edit").find("#fk_make").val(test[0]["fk_make"]);
							
							if (test[0]["fk_make"] != "0" || test[0]["fk_make"] != "")
							{
								load_model(test[0]["fk_make"], "#google_edit", test[0]["fk_family"]);
							}
							
							$("#google_edit input#ads_id").val(ads_id);
							$("#upload_slider input#ads_id").val(ads_id);
							$("#upload_slider img").attr("src",test[0]["img"]);
							$("#google_edit input#slug").val(test[0]["slug"]);
							
							$("#google_edit input#description").val(test[0]["description"]);
							
							$("#google_edit input#heading_1_line_1_text").val(test[0]["heading_1_line_1_text"]);
							$("#google_edit input#heading_1_line_1_font_size").val(test[0]["heading_1_line_1_font_size"]);
							$("#google_edit select#heading_1_line_1_font_weight").val(test[0]["heading_1_line_1_font_weight"]);
							
							$("#google_edit input#heading_1_line_2_text").val(test[0]["heading_1_line_2_text"]);
							$("#google_edit input#heading_1_line_2_font_size").val(test[0]["heading_1_line_2_font_size"]);
							$("#google_edit select#heading_1_line_2_font_weight").val(test[0]["heading_1_line_2_font_weight"]);
							
							$("#google_edit input#heading_2_text").val(test[0]["heading_2_text"]);
							$("#google_edit input#heading_2_font_size").val(test[0]["heading_2_font_size"]);
							$("#google_edit select#heading_2_font_weight").val(test[0]["heading_2_font_weight"]);
							
							$("#google_edit input#heading_3_text").val(test[0]["heading_3_text"]);
							$("#google_edit input#heading_3_font_size").val(test[0]["heading_3_font_size"]);
							$("#google_edit select#heading_3_font_weight").val(test[0]["heading_3_font_weight"]);
							
							$("#google_edit input#list_1_text").val(test[0]["list_1_text"]);
							$("#google_edit input#list_1_font_size").val(test[0]["list_1_font_size"]);
							$("#google_edit select#list_1_font_weight").val(test[0]["list_1_font_weight"]);
							
							$("#google_edit input#list_2_text").val(test[0]["list_2_text"]);
							$("#google_edit input#list_2_font_size").val(test[0]["list_2_font_size"]);
							$("#google_edit select#list_2_font_weight").val(test[0]["list_2_font_weight"]);
							
							$("#google_edit input#list_3_text").val(test[0]["list_3_text"]);
							$("#google_edit input#list_3_font_size").val(test[0]["list_3_font_size"]);
							$("#google_edit select#list_3_font_weight").val(test[0]["list_3_font_weight"]);
							
							$("#google_edit input#list_4_text").val(test[0]["list_4_text"]);
							$("#google_edit input#list_4_font_size").val(test[0]["list_4_font_size"]);
							$("#google_edit select#list_4_font_weight").val(test[0]["list_4_font_weight"]);
							
							$("#google_edit input#heading_4_line_1_text").val(test[0]["heading_4_line_1_text"]);
							$("#google_edit input#heading_4_line_1_font_size").val(test[0]["heading_4_line_1_font_size"]);
							$("#google_edit select#heading_4_line_1_font_weight").val(test[0]["heading_4_line_1_font_weight"]);
							
							$("#google_edit input#heading_4_line_2_text").val(test[0]["heading_4_line_2_text"]);
							$("#google_edit input#heading_4_line_2_font_size").val(test[0]["heading_4_line_2_font_size"]);
							$("#google_edit select#heading_4_line_2_font_weight").val(test[0]["heading_4_line_2_font_weight"]);
						
							$("#google_edit img").attr("src", test[0]["img"]);
							
							$("#google_edit").modal();
						}
					});
				});

				$(document).on("click", "#submit_ad_edit", function(event){

					var edit_id = $("#google_edit").find("#ads_id").val();
					var this_panel            = $("#td_"+edit_id);
					var heading_1_line_1_text = $("#google_edit").find("#heading_1_line_1_text").val();
					var heading_1_line_2_text = $("#google_edit").find("#heading_1_line_2_text").val();
					var heading_2_text        = $("#google_edit").find("#heading_2_text").val();
					var description           = $("#google_edit").find("#description").val();
					var list_1_text           = $("#google_edit").find("#list_1_text").val();
					var list_2_text           = $("#google_edit").find("#list_2_text").val();
					var list_3_text           = $("#google_edit").find("#list_3_text").val();
					var landing_root          = $("#google_edit").find("#fk_landing_page option:selected").text();
					var slug                  = $("#google_edit").find("#slug").val();
					var url                   = landing_root +"/"+edit_id +"/"+ slug;
					var header_url_text       = heading_1_line_1_text + " " + heading_1_line_2_text;

					$.ajax({
						type: "post",
						url: "<?php echo base_url('google_ad/update_record'); ?>",
						data: $("#google_ad_update_form").serialize(),
						success: function(result) {
							this_panel.find(".header_url").attr("href", url);
							this_panel.find(".heading_1").text(header_url_text);
							this_panel.find(".heading_2").text(heading_2_text);
							this_panel.find(".heading_2_url").text(url);
							this_panel.find(".lists").text(description);
							$("#google_edit").modal("hide");
						}
					});
					event.preventDefault();
				});

				$(document).on("click", ".delete_button", function(){
					var ads_id = $(this).data("id");
					var $this = $(this);
					var conf = confirm("Are you sure you want to delete this item?");
					if(conf)
					{
						$.ajax({
							type: "post",
							url: "<?php echo base_url('google_ad/delete_record'); ?>",
							data: { ads_id: ads_id },
							success: function(result) {
								$this.closest(".tr_ads").remove();
							}
						});
					}
				});
			});
			
			$("#google_ad").find("#fk_landing_page").change(function(){

				var landing_page_id = $("#google_ad").find("#fk_landing_page").val();

				var data = {
					landing_page_id: landing_page_id
				};		
				
				$.ajax({
					type: "post",
					url: "<?php echo site_url('google_ad/get_landing_page_make'); ?>",
					data: data,
					cache: false,
					dataType: "json",
					success: function(data) {
						if (landing_page_id != 0)
						{
							$("#google_ad").find("#fk_make").removeAttr("disabled");
							$("#google_ad").find("#fk_make").val(data.id_make);					
							
							if (data.id_make != 0)
							{
								$("#google_ad").find("#fk_family").removeAttr("disabled");
								load_model(data.id_make, "#google_ad");
							}
							else
							{
								$("#google_ad").find("#fk_family").val(0);
								$("#google_ad").find("#fk_family").attr("disabled", "disabled");							
							}							
							
							$("#google_ad").find("#description").val("Qteme New Car Quotes. Experts In "+data.make+" Discounts. Quotes Are Free & No Obligation.");
							$("#google_ad").find("#heading_2_text").val("Experts At Discounting New "+data.make);							
						}
						else
						{
							$("#google_ad").find("#fk_family").val(0);
							$("#google_ad").find("#fk_make").val(0);
							$("#google_ad").find("#fk_make").attr("disabled", "disabled");
							$("#google_ad").find("#fk_family").attr("disabled", "disabled");					
						}
					}
				});			
			});
			
			$("#google_ad").find("#fk_make").change(function(){

				var make_id = $("#google_ad").find("#fk_make").val();
				var make = $("#google_ad").find("#fk_make option:selected").text();
				
				$("#google_ad").find("#description").val("Qteme New Car Quotes. Experts In "+make+" Discounts. Quotes Are Free & No Obligation.");				
				$("#google_ad").find("#heading_2_text").val("Experts At Discounting New "+make);
				
				if (make_id != "")
				{
					load_model(make_id, "#google_ad");
				}
			});
			
			$("#google_edit").find("#fk_landing_page").change(function(){

				var landing_page_id = $("#google_edit").find("#fk_landing_page").val();

				var data = {
					landing_page_id: landing_page_id
				};		
				
				$.ajax({
					type: "post",
					url: "<?php echo site_url('google_ad/get_landing_page_make'); ?>",
					data: data,
					cache: false,
					dataType: "json",
					success: function(data) {
						if (landing_page_id != 0)
						{
							$("#google_edit").find("#fk_make").removeAttr("disabled");
							$("#google_edit").find("#fk_make").val(data.id_make);					
							
							if (data.id_make != 0)
							{
								$("#google_edit").find("#fk_family").removeAttr("disabled");
								load_model(data.id_make, "#google_edit");
							}
							else
							{
								$("#google_edit").find("#fk_family").val(0);
								$("#google_edit").find("#fk_family").attr("disabled", "disabled");							
							}							
							
							$("#google_edit").find("#description").val("Qteme New Car Quotes. Experts In "+data.make+" Discounts. Quotes Are Free & No Obligation.");
							$("#google_edit").find("#heading_2_text").val("Experts At Discounting New "+data.make);							
						}
						else
						{
							$("#google_edit").find("#fk_family").val(0);
							$("#google_edit").find("#fk_make").val(0);
							$("#google_edit").find("#fk_make").attr("disabled", "disabled");
							$("#google_edit").find("#fk_family").attr("disabled", "disabled");					
						}
					}
				});			
			});
			
			$("#google_edit").find("#fk_make").change(function(){

				var make_id = $("#google_edit").find("#fk_make").val();
				var make = $("#google_edit").find("#fk_make option:selected").text();
				
				$("#google_edit").find("#description").val("Qteme New Car Quotes. Experts In "+make+" Discounts. Quotes Are Free & No Obligation.");				
				$("#google_edit").find("#heading_2_text").val("Experts At Discounting New "+make);
				
				if (make_id != "")
				{
					load_model(make_id, "#google_edit");
				}
			});

			function load_model (make_id, container, fk_family)
			{
				var data = {
					make_id: make_id
				};						
				
				$.ajax({
					type: "post",
					url: "<?php echo site_url("cars/load_families"); ?>",
					cache: false,
					data: data,
					success: function(result){
						$(container).find("#fk_family").removeAttr("disabled");
						$(container).find("#fk_family").html("<option value='0'></option>");
						$(container).find("#fk_family").append(result);

						if(fk_family != 0 && fk_family != "")
						{
							$(document).find(container).find("#fk_family").val(fk_family);
						}
					}
				});	
			}
			
			$("#google_ad").find("#heading_1_line_1_text").change(function(){
				add_generate_url();
			});
			
			$("#google_ad").find("#heading_1_line_2_text").change(function(){
				add_generate_url();
			});

			$("#google_edit").find("#heading_1_line_1_text").change(function(){
				edit_generate_url();
			});
			
			$("#google_edit").find("#heading_1_line_2_text").change(function(){
				edit_generate_url();
			});
			
			function add_generate_url () 
			{
				$("#google_ad").find('#slug').val( ToSeoUrl( $("#google_ad").find('#heading_1_line_1_text').val() +"-"+ $("#google_ad").find('#heading_1_line_2_text').val() ) );
			}

			function edit_generate_url () 
			{
				$("#google_edit").find('#slug').val( ToSeoUrl( $("#google_edit").find('#heading_1_line_1_text').val() +"-"+ $("#google_edit").find('#heading_1_line_2_text').val() ) );	
			}

			function ToSeoUrl(url) 
			{				     
				var encodedUrl = "";

				encodedUrl = String(url).toLowerCase().trim(); // make the url lowercase   
				encodedUrl = encodedUrl.split(/\&+/).join(" and ") // replace & with and     
				encodedUrl = encodedUrl.split(/[^a-z0-9]/).join("-"); // remove invalid characters 
				encodedUrl = encodedUrl.split(/-+/).join("-"); // remove duplicates 
				encodedUrl = encodedUrl.replace(/^[^a-z0-9]+/,""); // trim leading & trailing characters
				encodedUrl = encodedUrl.replace(/-$/,"");
			
				return encodedUrl;
			}
		</script>
	</body>
</html>
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
							<div class="table-responsive">
								<?php
								if (count($landing_pages)==0)
								{
									echo "<br /><center><i>No results found!</i></center><br /><br /><br /><br />";
								}
								else
								{
								?>
									<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
										<thead>
											<tr>
												<th></th>
												<th>Root</th>
												<th>Website URL</th>
												<th>Date Created</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach($landing_pages as $landing_page)
											{
												?>
												<tr>
													<td>
														<center><a href="#" class="open-edit-lp" data-lp_id="<?php echo $landing_page->id_landing_page; ?>"><i class="fa fa-edit"></i></a></center>
													</td>
													<td id="lp_root_<?php echo $landing_page->id_landing_page; ?>">
														<a href="<?php echo $landing_page->root; ?>" target="_blank">
															<?php echo $landing_page->root; ?>
														</a>
													</td>
													<td id="lp_website_url_<?php echo $landing_page->id_landing_page; ?>"><?php echo $landing_page->website_url; ?></td>
													<td><?php echo $landing_page->created_at; ?></td>
												</tr>											
												<?php
											}
											?>
										</tbody>
									</table>														
								<?php
								}
								?>
							</div>
							<?php echo $links; ?>						
						</div>
					</section>
					<!-- end: page -->
					<?php include 'modals/ticket_modals.php'; ?>
					<!--Edit LP Modal-->
					<div id="edit-lp-modal" class="modal fade">
						<div class="modal-dialog" style="width: 80%;">
							<section class="panel">
								<header class="panel-heading">
									<h2 class="panel-title">Edit Landing Page</h2>
								</header>
								<div class="panel-body">
									<div class="modal-wrapper">
										<div class="modal-text">
											<div class="form-group">
												<input value="" id="lp_id_val" name="lp_id" type="hidden">
												<label class="control-label">Root</label>
												<input value="" class="form-control" id="lp_root" name="lp_root" type="text" placeholder="Root">
											</div>
											<div class="form-group">
												<label class="control-label">Website URL</label>
												<input value="" class="form-control" id="lp_website_url" name="lp_website_url" type="text" placeholder="Website URL">
											</div>
											<div class="form-group">
												<label class="control-label">Make</label>
												<input value="" class="form-control" id="lp_make" name="make" type="text" placeholder="Make">
											</div>
											<div class="form-group">
												<label class="control-label">Model</label>
												<input value="" class="form-control" id="lp_model" name="model" type="text" placeholder="Model">
											</div>											
											<div class="form-group">
												<label class="control-label">Main Image</label>
												<input value="" class="form-control" id="lp_img" name="img" type="text" placeholder="Main Image">
											</div>
											<div class="form-group">
												<label class="control-label">Hex Color Code</label>
												<input value="" class="form-control" id="lp_main_color" name="main_color" type="text" placeholder="Hex Color Code">
											</div>			
											<div class="form-group">
												<label class="control-label">Form Text Size</label>
												<input value="" class="form-control" id="lp_get_quotes_size" name="get_quotes_size" type="text" placeholder="Form Text Size">
											</div>
											<div class="form-group">
												<label class="control-label">Bing</label>
												<input value="" class="form-control" id="lp_bing" name="bing" type="text" placeholder="Bing">
											</div>
											<div class="form-group">
												<label class="control-label">Google Analytics</label>
												<input value="" class="form-control" id="lp_google_analytics" name="google_analytics" type="text" placeholder="Google Analytics">
											</div>
											<div class="form-group">
												<label class="control-label">Google Conversion ID</label>
												<input value="" class="form-control" id="lp_google_conversion_id" name="google_conversion_id" type="text" placeholder="Google Conversion ID">
											</div>
											<div class="form-group">
												<label class="control-label">Google Conversion Label</label>
												<input value="" class="form-control" id="lp_google_conversion_label" name="google_conversion_label" type="text" placeholder="Google Conversion Label">
											</div>											
											<div class="form-group">
												<div id="lp_content" name="lp_content" class="summernote" data-plugin-summernote data-plugin-options='{ "height": 180, "codemirror": { "theme": "ambiance" } }'></div>
											</div>
											<div class="form-group">
												<img id="image_display" src="" class="img-responsive" style="width: 100%; border: 1px solid #ddd; border-radius: 5px;">
												<br />
												<div class="panel panel-default" style="width: 100%;">
													<div class="panel-body dropzone-landing-image" data-image-oldname="" style="width: 100%; background-color: #0088cc; cursor: pointer; color: #fff">
														<i class="fa fa-file-image-o"></i> REPLACE IMAGE
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<footer class="panel-footer">
									<div class="row">
										<div class="col-md-12 text-right">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											<button type="button" class="btn btn-primary" onclick="update_lp()">Update Info</button>											
										</div>
									</div>
								</footer>
							</section>
						</div>
					</div>
					<!-- /.Edit LP Modal -->
				</section>
			</div>
			<?php include 'template/right_sidebar.php'; ?>
		</section>
		<?php include 'template/scripts.php'; ?>
		<script>
			$(document).ready(function(){

				var root_url = 'http://www.mazdadiscount.com.au/intro/';

				$(document).find('.dropzone-landing-image').dropzone ({
					url: '<?php echo site_url('cq_landing_page/upload_landing_image'); ?>',
					init: function() {
						this.on("sending", function(file, xhr, formData){
							var image_oldname = $('.dropzone-landing-image').data("image-oldname");
							var modal_id      = $('#lp_id_val').val();
				
							formData.append("image_oldname", image_oldname);
							formData.append("modal_id", modal_id);
						}),
						this.on("success", function(file, response){
							$(document).find("#image_display").attr('src','');
							$(document).find("#image_display").attr('src',root_url+response);
							$(document).find("#image_display").data('img',response);
							$(document).find(".dropzone-landing-image").data('image-oldname',response);
						}),
						this.on("queuecomplete", function () {
							this.removeAllFiles();
						});
					},
				
				});
			});

			function update_lp ()
			{
				var lp_id = $("#lp_id_val").val();
				var root = $("#lp_root").val();
				var website_url = $("#lp_website_url").val();				
				var make = $("#lp_make").val();
				var model = $("#lp_model").val();
				var img = $("#lp_img").val();
				var main_color = $("#lp_main_color").val();
				var get_quotes_size = $("#lp_get_quotes_size").val();
				var bing = $("#lp_bing").val();
				var google_analytics = $("#lp_google_analytics").val();
				var google_conversion_id = $("#lp_google_conversion_id").val();
				var google_conversion_label = $("#lp_google_conversion_label").val();
				var content = $("#lp_content").code();
				
				var dataString = "&lp_id="+lp_id+"&root="+root+"&website_url="+website_url+"&make="+make+"&model="+model+"&img="+img+"&main_color="+main_color+"&get_quotes_size="+get_quotes_size+"&bing="+bing+"&google_analytics="+google_analytics+"&google_conversion_id="+google_conversion_id+"&google_conversion_label="+google_conversion_label+"&content="+content;

				$("#editlp_loader").show();
				$("#editlp_loader").fadeIn(400).html("Sending...");
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("cq_landing_page/update_record"); ?>",
					data: dataString,
					cache: false,
					success: function(result){
						$("#editlp_loader").hide();
						$("#lp_root_"+lp_id).html(root);
						$("#lp_website_url_"+lp_id).html(website_url);
						$("#edit-lp-modal").modal("hide");
						parent.reload();
					}
				});
			}
		
			$(document).on("click", ".open-edit-lp", function(data)
			{
				var lp_id = $(this).data("lp_id");
				$.post("<?php echo site_url("cq_landing_page/record"); ?>/" + lp_id, function(data)
				{
					$("#lp_id_val").val(lp_id);
					$("#lp_root").val(data.lp_root);
					$("#lp_website_url").val(data.lp_website_url);
					$("#lp_make").val(data.lp_make);
					$("#lp_model").val(data.lp_model);
					$("#lp_img").val(data.lp_img);
					$("#lp_main_color").val(data.lp_main_color);
					$("#lp_get_quotes_size").val(data.lp_get_quotes_size);
					$("#lp_bing").val(data.lp_bing);
					$("#lp_google_analytics").val(data.lp_google_analytics);
					$("#lp_google_conversion_id").val(data.lp_google_conversion_id);
					$("#lp_google_conversion_label").val(data.lp_google_conversion_label);
					$("#lp_content").code(data.lp_content);

					var abspath = "http://www.mazdadiscount.com.au/intro/";

					$("#image_display").attr('src', abspath + data.lp_img);

					$(".dropzone-landing-image").data("image-oldname", data.lp_img);

					$("#edit-lp-modal").modal();
				}, "json");
			});
		</script>
	</body>
</html>
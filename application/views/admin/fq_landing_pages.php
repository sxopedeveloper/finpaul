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
												<th>Title</th>
												<th>Subtitle</th>																		
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
														<a href="#" class="open-edit-lp" data-lp_id="<?php echo $landing_page->id_fq_landing_page; ?>"><i class="fa fa-edit"></i></a>
													</td>
													<td id="lp_title_<?php echo $landing_page->id_fq_landing_page; ?>"><?php echo $landing_page->title; ?></td>
													<td id="lp_subtitle_<?php echo $landing_page->id_fq_landing_page; ?>"><?php echo $landing_page->subtitle; ?></td>
													<td id="lp_root_<?php echo $landing_page->id_fq_landing_page; ?>"><?php echo $landing_page->root; ?></td>
													<td id="lp_website_url_<?php echo $landing_page->id_fq_landing_page; ?>"><?php echo $landing_page->website_url; ?></td>
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
												<input value="" class="form-control" id="lp_title" name="lp_title" type="text" placeholder="Title">
											</div>
											<div class="form-group">
												<input value="" class="form-control" id="lp_subtitle" name="lp_subtitle" type="text" placeholder="Subtitle">
											</div>
											<div class="form-group">
												<input value="" class="form-control" id="lp_root" name="lp_root" type="text" placeholder="Root">
											</div>
											<div class="form-group">
												<input value="" class="form-control" id="lp_website_url" name="lp_website_url" type="text" placeholder="Website URL">
											</div>
											<div class="form-group">
												<div id="lp_content" name="lp_content" class="summernote" data-plugin-summernote data-plugin-options='{ "height": 180, "codemirror": { "theme": "ambiance" } }'></div>
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
			function update_lp ()
			{
				var lp_id = $("#lp_id_val").val();
				var title = $("#lp_title").val();
				var subtitle = $("#lp_subtitle").val();
				var root = $("#lp_root").val();
				var website_url = $("#lp_website_url").val();
				var content = $("#lp_content").code();

				var dataString = "&lp_id="+lp_id+"&title="+title+"&subtitle="+subtitle+"&root="+root+"&website_url="+website_url+"&content="+content;

				$("#editlp_loader").show();
				$("#editlp_loader").fadeIn(400).html("Sending...");
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("fq_landing_page/update_record"); ?>",
					data: dataString,
					cache: false,
					success: function(result){
						$("#editlp_loader").hide();
						$("#lp_title_"+lp_id).html(title);
						$("#lp_subtitle_"+lp_id).html(subtitle);
						$("#lp_root_"+lp_id).html(root);
						$("#lp_website_url_"+lp_id).html(website_url);
						$("#edit-lp-modal").modal("hide");
					}
				});
			}
		
			$(document).ready(function()
			{		
				$(document).on("click", ".open-edit-lp", function(data)
				{
					var lp_id = $(this).data("lp_id");
					$.post("<?php echo site_url("fq_landing_page/record"); ?>/" + lp_id, function(data)
					{
						$("#lp_id_val").val(lp_id);
						$("#lp_title").val(data.lp_title);
						$("#lp_subtitle").val(data.lp_subtitle);
						$("#lp_root").val(data.lp_root);
						$("#lp_website_url").val(data.lp_website_url);
						$("#lp_content").code(data.lp_content);
						$("#edit-lp-modal").modal();
					}, "json");
				});
			});
		</script>
	</body>
</html>
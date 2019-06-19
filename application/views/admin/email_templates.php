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
							<button type="button" class="btn btn-primary" onClick="new_template()"><i class="fa fa-plus"></i> Add Template</button><br /><br />
							<div class="table-responsive">
								<?php
								if (count($email_templates)==0)
								{
									echo "<br /><center><i>No results found!</i></center><br />";
								}
								else
								{
									?>
									<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
										<thead>
											<tr>
												<td><i class="fa fa-pencil-square-o"></i></td>
												<td><b>ID</b></td>
												<td><b>Description</b></td>
												<td><b>Function</b></td>
												<td><b>Subject</b></td>
												<td><b>Attachment Path</b></td>												
												<td><b>Created</b></td>
												<td><b>Last Updated</b></td>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach ($email_templates as $email_template)
											{											
												?>
												<tr id="email_template_main_row_<?php echo $email_template->id_email_template; ?>">
													<td>
														<span class="open-emailtemplate-details" data-email_template_id="<?php echo $email_template->id_email_template; ?>" style="cursor: pointer; cursor: hand; color: #58c603;">
															<i class="fa fa-pencil-square-o" data-toggle="tooltip" data-placement="top" data-original-title="Edit Email Template"></i>
														</span>
													</td>
													<td><?php echo $email_template->id_email_template; ?></td>
													<td id="email_description_main_row_<?php echo $email_template->id_email_template; ?>">
														<?php echo $email_template->description; ?>
													</td>
													<td id="email_function_main_row_<?php echo $email_template->id_email_template; ?>">
														<?php echo $email_template->eq_function; ?>
													</td>
													<td id="email_subject_main_row_<?php echo $email_template->id_email_template; ?>">
														<?php echo $email_template->subject; ?>
													</td>
													<td id="email_attachment_main_row_<?php echo $email_template->id_email_template; ?>">
														<?php echo $email_template->attachment; ?>
													</td>
													<td><?php echo $email_template->created_at; ?></td>
													<td><?php echo $email_template->last_updated; ?></td>
												</tr>
											<?php
											}
											?>
										</tbody>
									</table>
									<br />
								<?php
								}
								?>
							</div>
							<?php echo $links; ?>
						</div>
					</section>					
					<!-- end: page -->
					<?php include 'modals/ticket_modals.php'; ?>
					<!--Add Email Template Modal-->
					<div id="add-email-template-modal" class="modal fade">
						<div class="modal-dialog" style="width: 80%;">
							<section class="panel">
								<header class="panel-heading">
									<h2 class="panel-title">Send Email</h2>
								</header>
								<div class="panel-body">
									<div class="modal-wrapper">
										<div class="modal-text">
											<div class="form-group">
												<input value="" id="email_template_id" name="email_template_id" type="hidden">
												<input value="" class="form-control" id="email_description" name="email_description" type="text" placeholder="Description">
											</div>										
											<div class="form-group">
												<input value="" class="form-control" id="email_subject" name="email_subject" type="text" placeholder="Subject">
											</div>
											<div class="form-group">
												<input value="" class="form-control" id="email_function" name="email_function" type="text" placeholder="EQ Function">
											</div>
											<div class="form-group">
												<input value="" class="form-control" id="email_attachment" name="email_attachment" type="text" placeholder="Attachment Path">
											</div>											
											<div class="form-group">
												<div class="summernote" id="email_content" name="email_content" data-plugin-summernote data-plugin-options='{ "height": 240, "codemirror": { "theme": "ambiance" } }'></div>
											</div>
										</div>
									</div>
								</div>
								<footer class="panel-footer">
									<div class="row">
										<div class="col-md-12 text-right">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											<button type="button" class="btn btn-primary" onClick="add_email_template()">Send Email</button>
										</div>
									</div>
								</footer>
							</section>					
						</div>
					</div>
					<!-- /.Add Email Template Modal -->					
					<!--Edit Email Template Modal-->
					<div id="edit-email-template-modal" class="modal fade">
						<div class="modal-dialog" style="width: 80%;">
							<section class="panel">
								<header class="panel-heading">
									<h2 class="panel-title">Send Email</h2>
								</header>
								<div class="panel-body">
									<div class="modal-wrapper">
										<div class="modal-text">
											<div class="form-group">
												<input value="" id="email_template_id" name="email_template_id" type="hidden">
												<input value="" class="form-control" id="email_description" name="email_description" type="text" placeholder="Description">
											</div>										
											<div class="form-group">
												<input value="" class="form-control" id="email_subject" name="email_subject" type="text" placeholder="Subject">
											</div>
											<div class="form-group">
												<input value="" class="form-control" id="email_function" name="email_function" type="text" placeholder="EQ Function">
											</div>
											<div class="form-group">
												<input value="" class="form-control" id="email_attachment" name="email_attachment" type="text" placeholder="Attachment Path">
											</div>						
											<div class="form-group">
												<div class="summernote" id="email_content" name="email_content" data-plugin-summernote data-plugin-options='{ "height": 240, "codemirror": { "theme": "ambiance" } }'></div>
											</div>
										</div>
									</div>
								</div>
								<footer class="panel-footer">
									<div class="row">
										<div class="col-md-12 text-right">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											<button type="button" class="btn btn-primary" onClick="edit_email_template()">Send Email</button>											
										</div>
									</div>
								</footer>
							</section>					
						</div>
					</div>
					<!-- /.Edit Email Template Modal -->					
				</section>
			</div>
			<?php include 'template/right_sidebar.php'; ?>
		</section>
		<?php include 'template/scripts.php'; ?>
		<script>
			$(document).on("click", ".open-emailtemplate-details", function(data)
			{
				var email_template_id = $(this).data("email_template_id");
				$('#edit-email-template-modal').find('#email_content').code('');
				$('#edit-email-template-modal').find('.note-codable').val('');
				$.post("<?php echo site_url("email_template/record"); ?>/" + email_template_id, function(data)
				{
					$('.full_loader').hide();
					$('#edit-email-template-modal').find('#email_template_id').val(email_template_id);
					$('#edit-email-template-modal').find('#email_subject').val(data.subject);
					$('#edit-email-template-modal').find('#email_description').val(data.description);
					$('#edit-email-template-modal').find('#email_function').val(data.eq_function);
					$('#edit-email-template-modal').find('#email_content').code(data.content);
					$('#edit-email-template-modal').find('.note-codable').val(data.content);
					$('#edit-email-template-modal').find('#email_function').val(data.attachment);
					$('#edit-email-template-modal').modal();
				}, 'json');
			});

			function new_template ()
			{
				$('#add-email-template-modal').modal();
			}

			function add_email_template ()
			{
				var email_template_id = $("#add-email-template-modal").find("#email_template_id").val();
				var email_description = $("#add-email-template-modal").find("#email_description").val();
				var email_subject = $("#add-email-template-modal").find("#email_subject").val();
				var email_function = $("#add-email-template-modal").find("#email_function").val();
				var email_content = $("#add-email-template-modal").find("#email_content").code();
				var email_attachment = $("#edit-email-template-modal").find("#email_attachment").val();

				email_content = replaceAll(email_content, '&quot;', '%27');
				email_content = replaceAll(email_content, '&lt;', '%3C');
				email_content = replaceAll(email_content, '&qt;', '%3E');
				email_content = replaceAll(email_content, '&amp;', '%26');
				email_content = replaceAll(email_content, '&', '%26');
				
				var dataString = "&email_template_id="+email_template_id+"&email_description="+email_description+"&email_subject="+email_subject+"&email_function="+email_function+"&email_content="+email_content+"&email_attachment="+email_attachment;

				$.ajax({
					type: "POST",
					url: "<?php echo site_url("email_template/add_record"); ?>",
					data: dataString,
					cache: false,
					success: function(result){
						alert ("The new template was successfully saved!");
						$("#add-email-template-modal").modal("hide");
					}
				});
			}

			function edit_email_template ()
			{
				var email_template_id = $("#edit-email-template-modal").find("#email_template_id").val();
				var email_description = $("#edit-email-template-modal").find("#email_description").val();
				var email_subject = $("#edit-email-template-modal").find("#email_subject").val();
				var email_function = $("#edit-email-template-modal").find("#email_function").val();
				var email_content = $("#edit-email-template-modal").find("#email_content").code();
				var email_attachment = $("#edit-email-template-modal").find("#email_attachment").val();

				email_content = replaceAll(email_content, '&quot;', '%27');
				email_content = replaceAll(email_content, '&lt;', '%3C');
				email_content = replaceAll(email_content, '&qt;', '%3E');
				email_content = replaceAll(email_content, '&amp;', '%26');
				email_content = replaceAll(email_content, '&', '%26');
				
				var dataString = "&email_template_id="+email_template_id+"&email_description="+email_description+"&email_subject="+email_subject+"&email_function="+email_function+"&email_content="+email_content+"&email_attachment="+email_attachment;

				$.ajax({
					type: "POST",
					url: "<?php echo site_url("email_template/update_record"); ?>",
					data: dataString,
					cache: false,
					success: function(result){
						alert ("Update successful!");
						$("#email_description_main_row_"+email_template_id).val(email_description);
						$("#email_subject_main_row_"+email_template_id).val(email_subject);
						$("#email_function_main_row_"+email_template_id).val(email_function);
						$("#email_attachment_main_row_"+email_template_id).val(email_attachment);
						$("#edit-email-template-modal").modal("hide");
					}
				});
			}
		</script>
	</body>
</html>
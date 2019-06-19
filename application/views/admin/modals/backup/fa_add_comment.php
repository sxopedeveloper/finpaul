				<div id="addfapplicationcomment-modal" class="modal fade">
					<div class="modal-dialog" style="width: 95%;">
						<div class="panel-body">
							<div class="modal-wrapper">
								<div class="modal-text">
									<form method="post" action="" id="fapplication_comment_form" name="fapplication_comment_form">
										<input type="hidden" id="fapplication_id_ac" name="id_fapplication" />
										<input type="hidden" id="fapplication_status_id_ac" name="fapplication_status" />									
										<textarea id="fapplication_comment" name="comment" class="form-control" placeholder="Add a Comment"></textarea><br />
										<div id="dz_fa_comment_file" class="dropzone dz_fa_comment_file"></div>
										<div id="fa_uploaded_comment_files"></div>	
									</form>
								</div>
							</div>
						</div>
						<footer class="panel-footer">
							<div class="row">
								<div class="col-md-12 text-right">
									<button type="button" class="btn btn-primary" onclick="add_fa_comment_action()">Submit</button>
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								</div>
							</div>
						</footer>
					</div>
				</div>
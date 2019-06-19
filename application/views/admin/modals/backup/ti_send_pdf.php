				<div id="sendpdf-modal" class="modal fade">
					<div class="modal-dialog" style="width: 40%;">
						<section class="panel">
							<header class="panel-heading">
								<h2 class="panel-title">Send PDF</h2>
							</header>
							<div class="panel-body">
								<div class="modal-wrapper">
									<div class="modal-text">
										<form method="post" action="" id="sendpdf_form" name="sendpdf_form">
											<input type="hidden" id="id_tradein_sp" name="id_tradein" value="" />
											<div class="form-group">
												<div class="col-md-12 text-left">
													<input class="form-control input-md" id="ti_email" name="ti_email" type="text" value="" placeholder="Email Address">
												</div>
											</div>
										</form>
										<div class="col-md-12 text-left">
											<span id="sendpdf_loader"></span>
										</div>													
										<div class="col-md-12 text-left">
											<br />
											<table class="table table-bordered table-striped table-condensed mb-none">
												<thead>
													<tr><td><b>PDF RECIPIENTS</b></td></tr>
												</thead>
												<tbody id="pdf_recipients"></tbody>
											</table>
											<br />
										</div>								
									</div>
								</div>
							</div>
							<footer class="panel-footer">
								<div class="row">
									<div class="col-md-12 text-right">
										<button type="button" class="btn btn-primary" onclick="submit_pdf()">Submit</button>
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
								</div>
							</footer>
						</section>					
					</div>
				</div>
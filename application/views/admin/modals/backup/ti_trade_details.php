				<style type="text/css">
					.img-details{
						max-width: 283px;
						max-height: 212px;
					}
					.dropzone-image{
						background-color: #d3d3d3;
						cursor: pointer;
						cursor: hand;
						border-radius: 0px !important;
						max-width: 283px;
					}
					.delete-image{
						z-index: 9999999;
						/*position: relative;*/
					}
					.non-form-control{
						width: 25px;
						height: 25px;
					}
					.other_info_textarea{
						resize: none !important;
						width: 100%;
						height: 100%;
					}
				</style>
				<div id="tradeindetails-modal" class="modal fade">
					<div class="modal-dialog" style="width: 95%;">
						<section class="panel">
							<header class="panel-heading">
								<h2 class="panel-title">Trade Details</h2>
							</header>
							<div class="panel-body">
								<div class="modal-wrapper">
									<div class="modal-text">
										<input type="hidden" id="image-no">
										<input type="hidden" id="image-oldname">
										<input type="hidden" id="modal-id">
										<input type="hidden" id="modal-id-2">
										<form method="post" action="" id="tradein_form" name="tradein_form">
											<div class="tradein_details" id="tradein_details"></div>
										</form>
									</div>
								</div>
							</div>
							<footer class="panel-footer">
								<div class="row">
									<div class="col-md-12 text-right">
										<?php
										if ($login_type=="Admin")
										{
											?>
											<button type="button" class="btn btn-primary" onclick="save_tradein_info()">Save</button>
											<?php
										}
										?>
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
								</div>
							</footer>
						</section>					
					</div>
				</div>
				<div id="entervaluation-modal" class="modal fade">
					<div class="modal-dialog" style="width: 40%;">
						<section class="panel">
							<header class="panel-heading">
								<h2 class="panel-title">Enter Valuation</h2>
							</header>
							<div class="panel-body">
								<div class="modal-wrapper">
									<div class="modal-text">
										<form method="post" action="" id="entervaluation_form" name="entervaluation_form">
											<input type="hidden" id="id_tradein" name="id_tradein" value="" />
											<div class="form-group">
												<?php
												if ($login_type=="Admin")
												{
													?>
													<div class="col-md-12 text-left">
														<select class="form-control input-md" id="wholesaler_dropdown" name="wholesaler_id" title="Wholesaler">
														</select>														
														<br />
													</div>
													<?php
												}
												?>							
												<div class="col-md-12 text-left">
													<input class="form-control input-md" id="entered_value" name="entered_value" type="text" value="" placeholder="Value" onkeypress="return isNumberKey(event)">
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
							<footer class="panel-footer">
								<div class="row">
									<div class="col-md-12 text-right">
										<button type="button" class="btn btn-primary" onclick="submit_valuation()">Submit</button>
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
								</div>
							</footer>
						</section>					
					</div>
				</div>
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
				<div id="tradeinvaluations-modal" class="modal fade">
					<div class="modal-dialog" style="width: 95%;">
						<section class="panel">
							<header class="panel-heading">
								<h2 class="panel-title">Trade-In Valuations</h2>
							</header>
							<div class="panel-body">
								<div class="modal-wrapper">
									<div class="modal-text">
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
												<thead>
													<tr>
														<td><i class="fa fa-trophy"></i></td>
														<td>Email</td>
														<td>Name</td>
														<td>Value</td>
														<td>Date</td>
													</tr>
												</thead>
												<tbody id="tradein_valuations"></tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<footer class="panel-footer">
								<div class="row">
									<div class="col-md-12 text-right">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
								</div>
							</footer>
						</section>					
					</div>
				</div>
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
				<div id="sendpdf-modal" class="modal fade">
					<div class="modal-dialog" style="width: 40%;">
						<section class="panel">
							<header class="panel-heading">
								<h2 class="panel-title">Send PDF</h2>
							</header>
							<div class="panel-body">
								<div class="modal-wrapper">
									<div class="modal-text">
										<div>
											<div>
												<input type="radio" name="email_method" class="email_method_radio credit-card" value="1"> Enter an Email Address
											</div>
											<div >
												<input type="radio" name="email_method" class="email_method_radio reference-number" value="2" checked> Browse the Wholesalers
											</div>
											<hr />
										</div>
										<div class="email_text_panel" hidden>
											<form method="post" action="" id="sendpdf_form" name="sendpdf_form">
												<input type="hidden" id="id_tradein_sp" name="id_tradein" value="" />
												<div class="form-group">
													<div class="col-md-12 text-left">
														<input class="form-control input-md" id="ti_email" name="ti_email" type="text" value="" placeholder="Email Address">
													</div>
												</div>
											</form>
										</div>
										<div class="multi_email_panel" hidden>
											<div class="form-group">
												<div class="col-md-12 text-left">
													<select class="form-control input-sm" id="state_filter">
														<option name="state" value="">-Select State-</option>
														<option name="state" value="ACT" >Australian Capital Territory</option>
														<option name="state" value="NSW" >New South Wales</option>
														<option name="state" value="NT" >Northern Territory</option>
														<option name="state" value="QLD" >Queensland</option>
														<option name="state" value="SA" >South Australia</option>
														<option name="state" value="TAS" >Tasmania</option>
														<option name="state" value="VIC" >Victoria</option>
														<option name="state" value="WA" >Western Australia</option>
													</select>
												</div>
											</div>
											<div class="col-md-12 text-left" id="suggested_wholesalers"><span id="loader"></span></div>
											<div class="col-md-12 text-left">
												<br />
												<table class="table table-bordered table-striped table-condensed mb-none">
													<thead>
														<tr><td colspan="2"><b>SELECTED WHOLESALERS</b></td><td></td></tr>
													</thead>
													<tbody id="selected_wholesalers"></tbody>
												</table>
											</div>
										</div>
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
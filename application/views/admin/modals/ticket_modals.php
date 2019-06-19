<div id="tender_alert_modal" class="modal fade"> <!-- Tender Alert Modal -->
	<div class="modal-dialog" style="width: 95%;">
		<section class="panel">
			<form method="post" id="tender_alert_form" name="tender_alert_form" action="">
				<div class="panel-body">
					<div class="modal-wrapper">
						<div class="modal-text">
							<div class="row" id="tender_alert_details">
							</div>
						</div>
					</div>
				</div>
			</form>
		</section>
	</div>
</div>
<div id="ticket-modal" class="modal fade"> <!-- Ticket Modal -->
	<div class="modal-dialog" style="width: 95%;">
		<div class="panel-body">
			<div class="modal-wrapper">
				<div class="modal-text">
					<form method="post" action="" id="ticket_main_form" name="ticket_main_form">
						<input type="hidden" id="ticket_status_id" name="ticket_status_id" value="" />
						<input type="hidden" id="ticket_id" name="ticket_id" value="" />
						<h3 id="ticket_name"></h3><hr />
						<div class="table-responsive">
							<table class="table table-condensed mb-none" style="white-space: nowrap;">
							  	<thead>
							  		<tr>
								  		<th>Assigned By</th>
								  		<th>Assigned To</th>
							  		</tr>
							  	</thead>
							  	<tbody id="ticket_tbody_ass_to">
							  	</tbody>
							</table>
							<hr>
						</div>
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
								<tbody>
									<tr>
										<td><b>TICKET NUMBER</b></td>
										<td><b>STATUS</b></td>
										<td><b>PRIORITY</b></td>
										<td><b>TYPE</b></td>
										<td><b>MODULE</b></td>
										<td><b>START DATE</b></td>
										<td><b>ETA (# DAYS)</b></td>
									</tr>
									<tr>
										<td id="ticket_number"></td>
										<td id="ticket_status"></td>
										<td id="ticket_priority"></td>
										<td id="ticket_type"></td>
										<td id="ticket_module"></td>
										<td id="assignment_date"></td>
										<td><a href="#" class="open-edittoc"><i class="fa fa-pencil"></i></a> <span id="toc"></span></td>
									</tr>
								</tbody>											
							</table>
						</div>
						<br />
						<div class="well well-sm" id="ticket_description"></div>
						<br />
						<div id="ticket_comments"></div>
						<br />
					</form>
				</div>
			</div>
		</div>
		<footer class="panel-footer">
			<div class="row">
				<div class="col-md-12 text-right">
					<div id="ticket_actions"></div>
				</div>
			</div>
		</footer>
	</div>
</div>
<div id="addticketcomment-modal" class="modal fade"> <!-- Add Ticket Modal -->
	<div class="modal-dialog" style="width: 95%;">
		<div class="panel-body">
			<div class="modal-wrapper">
				<div class="modal-text">
					<form method="post" action="" id="ticket_comment_form" name="ticket_comment_form">
						<textarea id="ticket_comment" name="comment" class="form-control" placeholder="Add a Comment"></textarea><br />
						<div id="dz_t_comment_file" class="dropzone dz_t_comment_file"></div>
						<div id="t_uploaded_comment_files"></div>	
					</form>
				</div>
			</div>
		</div>
		<footer class="panel-footer">
			<div class="row">
				<div class="col-md-12 text-right">
					<button type="button" class="btn btn-primary" onclick="add_t_comment_action()">Submit</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</footer>
	</div>
</div>
<div id="edittoc-modal" class="modal fade"> <!-- Edit Ticket TOC Modal -->
	<div class="modal-dialog" style="width: 40%;">
		<section class="panel">
			<header class="panel-heading">
				<h2 class="panel-title">ETA (# DAYS)</h2>
			</header>
			<div class="panel-body">
				<div class="modal-wrapper">
					<div class="modal-text">
						<div class="form-group">
							<div class="col-md-12 text-left">
								<input class="form-control input-md" id="eta_val" name="eta_val" type="text" value="" placeholder="ETA" required>
							</div>
							<div class="col-md-12 text-left">
								<span id="edittoc_loader"></span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-md-12 text-right">
						<button type="button" class="btn btn-primary" onclick="update_toc()">Save</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</footer>
		</section>					
	</div>
</div>
<div id="edit_ticket_modal" class="modal fade"> <!-- Edit Ticket Modal -->
	<div class="modal-dialog" style="width: 95%;">
		<div class="panel-body">
			<div class="modal-wrapper">
				<div class="modal-text">
					<form id="edit_form" method="post">
						<input id="hidden_edit_ticket_id" value="" type="hidden" name="ticket_id">
						<div class="row">
							<div class="form-group">
								<div class="col-md-4 text-left">
									<label>Type:</label>
									<select class="form-control input-md" name="ticket_type" type="text" required id="ticket_edit_ticket_type">
										<option name="ticket_type" value=""></option>
										<?php 
										foreach ($ticket_types as $ticket_type)
										{
											?>
											<option name="ticket_type" value="<?php echo $ticket_type->id_ticket_type; ?>"><?php echo $ticket_type->name; ?></option>
											<?php
										}
										?>
									</select>
								</div>
								<div class="col-md-4 text-left">
									<label>Priority:</label>
									<select class="form-control input-md" id="ticket_edit_priority" name="priority" type="text" required>
										<option name="priority" value=""></option>
										<option name="priority" value="1">Urgent</option>
										<option name="priority" value="2">High</option>
										<option name="priority" value="3">Low</option>
									</select>
								</div>										
								<div class="col-md-4 text-left">
									<label>Module:</label>
									<select class="form-control input-md" id="ticket_edit_module" name="module" type="text" required>
										<option name="module" value=""></option>
										<?php 
										foreach ($modules as $module)
										{
											?>
											<option name="module" value="<?php echo $module->id_module; ?>"><?php echo $module->name; ?></option>
											<?php
										}
										?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6 text-left">
									<label>Subject:</label>
									<input class="form-control input-md" id="ticket_edit_name" name="name" type="text" placeholder="Subject" maxlength="60"  required>
								</div>
								<div class="col-md-6 text-left">
									<label>Scheduled Start Date:</label>
									<?php 
									$now = date("Y-m-d");
									?>
									<input class="form-control input-md datepicker" id="ticket_edit_assignment_date" name="assignment_date" data-date-format="yyyy/mm/dd" value="<?php echo $now; ?>" required>
								</div>
							</div>									
							<div class="form-group">
								<div class="col-md-12 text-left">
									<label>Assign to:</label>
									<select class="form-control input-md" id="ticket_edit_user_id_to" name="user_id_to[]" type="text" required multiple data-plugin-selectTwo disabled>
										<?php 
										foreach ($admins as $admin)
										{
											?>
											<option name="user_id_to" value="<?php echo $admin->id_user; ?>"><?php echo $admin->name; ?></option>
											<?php
										}
										?>
									</select>
								</div>
							</div>
							<div class="form-group">										
								<div class="col-md-12 text-left">
									<label>Description:</label>
									<textarea id="ticket_edit_description" name="description" class="form-control" rows="3" placeholder="Description" required></textarea>
								</div>										
							</div>
							<br />
							<div class="form-group">
								<div class="col-md-12 text-left">
									<span class="btn btn-primary btn-sm ticket_submit_edit">Submit</span>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<footer class="panel-footer">
			<div class="row">
				<div class="col-md-12 text-right">
					
				</div>
			</div>
		</footer>
	</div>
</div>
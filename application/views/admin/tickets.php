<?php include 'template/head.php'; ?>
	<body>
	<style type="text/css">
		.table-condensed > thead > tr > th, .table-condensed > tbody > tr > th, .table-condensed > tfoot > tr > th, .table-condensed > thead > tr > td, .table-condensed > tbody > tr > td, .table-condensed > tfoot > tr > td {
		    padding: 6px !important;
		}
	</style>
		<section class="body">
			<?php include 'template/header.php'; ?>
			<div class="inner-wrapper">
				<?php include 'template/left_sidebar.php'; ?>			
				<section role="main" class="content-body">
					<?php include 'template/header_2.php'; ?>
					<!-- start: page -->
					<section class="panel">
						<!--<header class="panel-heading">
							<div class="panel-actions">
								<a href="#" class="fa fa-caret-down"></a>
							</div>
							<h2 class="panel-title">
								<span class="va-middle">Search Filters</span>
							</h2>
						</header>-->
						
						<form action="<?php echo site_url('ticket/list_view'); ?>" method="get" accept-charset="utf-8"  id="main_list_filter_form" >
						<div class="panel-body">
							<h5><b>Search Filters</b></h5>
							
								<div class="row">										
									<?php
									$t_number = isset($_GET['t_number']) ? $_GET['t_number'] : '';

									$status = isset($_GET['ticket_status']) ? $_GET['ticket_status'] : '';
									$user_from = isset($_GET['user_from']) ? $_GET['user_from'] : '';
									$user_to = isset($_GET['user_to']) ? $_GET['user_to'] : '';
									
									$type = isset($_GET['ticket_type']) ? $_GET['ticket_type'] : '';
									$module = isset($_GET['module']) ? $_GET['module'] : '';
									$priority = isset($_GET['priority']) ? $_GET['priority'] : '';
									?>
									<div class="col-md-12"> <!-- Client Details Filter -->
										
											<div class="row">
										<div class="col-md-2 text-left">
											<input type="text" class="form-control input-md" name="t_number" title="Ticket Number" placeholder="Ticket Number" value="<?php echo $t_number;?>"><br />
										</div>
														
									
										<div class="col-md-2 text-left">
											<select class="form-control input-md" name="ticket_status" title="Ticket Status">
												<option name="ticket_status" value="">-Ticket Status-</option>
												<?php
												foreach ($ticket_status as $t_status)
												{
													$selected = "";
													if ($t_status->id_ticket_status==$status)
													{
														$selected = "selected";
													}
													?>
													<option name="ticket_status" value="<?php echo $t_status->id_ticket_status; ?>" <?php echo $selected; ?>>
														<?php echo $t_status->name; ?>
													</option>
													<?php
												}
												?>
											</select><br />
										</div>
										<div class="col-md-2 text-left">
											<select class="form-control input-md" name="user_from" title="Assigned by">
												<option name="user_from" value="">-Assigned by-</option>
												<?php
												foreach ($admins as $admin)
												{
													$selected = "";
													if ($admin->id_user==$user_from)
													{
														$selected = "selected";
													}
													?>
													<option name="user_from" value="<?php echo $admin->id_user; ?>" <?php echo $selected; ?>>
														<?php echo $admin->name; ?>
													</option>													
													<?php
												}
												?>
											</select><br />
										</div>
										<div class="col-md-2 text-left">
											<select class="form-control input-md" name="user_to" title="Assigned to">
												<option name="user_to" value="">-Assigned to-</option>
												<?php
												foreach ($admins as $admin)
												{
													$selected = "";
													if ($admin->id_user==$user_to)
													{
														$selected = "selected";
													}
													?>
													<option name="user_to" value="<?php echo $admin->id_user; ?>" <?php echo $selected; ?>>
														<?php echo $admin->name; ?>
													</option>													
													<?php
												}
												?>
											</select><br />
										</div>										
									
										<div class="col-md-2 text-left">
											<select class="form-control input-md" name="ticket_type" title="Ticket Type">
												<option name="ticket_type" value="">-Ticket Type-</option>
												<?php
												foreach ($ticket_types as $t_type)
												{
													$selected = "";
													if ($t_type->id_ticket_type==$type)
													{
														$selected = "selected";
													}
													?>
													<option name="ticket_type" value="<?php echo $t_type->id_ticket_type; ?>" <?php echo $selected; ?>>
														<?php echo $t_type->name; ?>
													</option>
													<?php
												}
												?>
											</select><br />
										</div>
										<div class="col-md-2 text-left">
											<select class="form-control input-md" name="module" title="Module">
												<option name="module" value="">-Module-</option>
												<?php
												foreach ($modules as $t_module)
												{
													$selected = "";
													if ($t_module->id_module==$module)
													{
														$selected = "selected";
													}
													?>
													<option name="module" value="<?php echo $t_module->id_module; ?>" <?php echo $selected; ?>>
														<?php echo $t_module->name; ?>
													</option>
													<?php
												}
												?>
											</select><br />
										</div>
										<div class="col-md-2 text-left">
											<?php
											if ($priority==1) { $selected_priority_1 = ' selected'; } else { $selected_priority_1 = ''; }
											if ($priority==2) { $selected_priority_2 = ' selected'; } else { $selected_priority_2 = ''; }
											if ($priority==3) { $selected_priority_3 = ' selected'; } else { $selected_priority_3 = ''; }
											?>
											<select class="form-control input-md" name="priority" title="Priority">
												<option name="priority" value="">-Priority-</option>
												<option name="priority" value="1" <?php echo $selected_priority_1; ?>>Urgent</option>
												<option name="priority" value="2" <?php echo $selected_priority_2; ?>>High</option>
												<option name="priority" value="3" <?php echo $selected_priority_3; ?>>Low</option>
											</select><br />
										</div>
														
										<div class="col-md-2 text-right pull-right">
											<input value="Apply Filters" name="submit" class="btn btn-primary  search-filter-btn  col-md-12 col-sm-12 col-xs-12" type="submit">
										</div>										
									</div></div>
								</div>
							
						</div></form>
					</section>
					<section class="panel " id="tableData" >
						
							<?php
							if (count($tickets)==0)
							{
								echo "<div class='panel-body '><br /><center><i>No results found!</i></center><br />";
							}
							else
							{
							?>
						<div class="panel-body no-border">
								<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;" id="datatable">
									<thead>
										<tr>
											<th></th>
											<th></th>
											<th><b>TICKET #</b></th>
											<th><b>STATUS</b></th>
											<th><b>PRIORITY</b></th>
											<th><b>TYPE</b></th>
											<th><b>MODULE</b></th>
											<th><b>NAME</b></th>
											<th><b>ASSIGNED BY</b></th>
											<th><b>START DATE</b></th>
											<th><b>ETA (# DAYS)</b></th>
											<th hidden></th>
											<th hidden></th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach ($tickets as $ticket)
										{
											$hidden_string = "";

											if($ticket->fk_user_from != $user_id)
												$hidden_string = "hidden";
											else
												$hidden_string = "";

											?>
											<tr id="ticket_row_<?php echo $ticket->id_ticket; ?>">
												<td align="center"><a <?= $hidden_string; ?> href="#" class="edit-ticket" data-ticket_id="<?php echo $ticket->id_ticket; ?>"><i class="fa fa-pencil-square-o"></i></a></td>
												<td align="center"><a href="#" class="open-ticket" data-ticket_id="<?php echo $ticket->id_ticket; ?>"><i class="fa fa-desktop"></i></a></td>
												<td><?php echo $ticket->ticket_number; ?></td>
												<td id="ticket_status_<?php echo $ticket->id_ticket; ?>"><?php echo $ticket->ticket_status; ?></td>
												<td class="ticket_priority"><?php echo $ticket->priority; ?></td>
												<td class="ticket_type"><?php echo $ticket->ticket_type; ?></td>
												<td class="ticket_module"><?php echo $ticket->module; ?></td>
												<td class="ticket_name"><?php echo $ticket->name; ?></td>
												<td><?php echo $ticket->assigned_by; ?></td>
												<td class="ticket_start_date"><?php echo $ticket->assignment_date; ?></td>
												<td><?php echo $ticket->toc; ?></td>
												<td hidden> <?php echo $ticket->description; ?> </td>
												<td hidden> <?php echo $ticket->assigned_to_names; ?> </td>
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
					</section> 
					<!-- end: page -->
					<?php include 'modals/ticket_modals.php'; ?>
				</section>
			</div>
			<?php include 'template/right_sidebar.php'; ?>
		</section>
		<?php include 'template/scripts.php'; ?>
		<script>
			function delete_tickets ()
			{
				if (confirm("Are you sure you want to delete this Ticket?")) 
				{
					var checkbox_values = [];

					$('input[type="checkbox"]:checked').each(function(index, elem) {
						checkbox_values.push($(elem).val());
					});
					
					var ticket_ids = checkbox_values.join(",");
					var ticket_id_arr = ticket_ids.split(",");
					var ticket_count = ticket_id_arr.length;
					var dataString = "&ticket_ids="+ticket_ids;

					$.ajax({
						type: "POST",
						url: "<?php echo site_url("ticket/delete"); ?>",
						data: dataString,
						cache: false,
						success: function(result){
							var ticket_index = 0;
							while (ticket_index < ticket_count) 
							{
								$("#ticket_row_"+ticket_id_arr[ticket_index]).remove();
								ticket_index++;
							}
						}
					});
				}
			}

			(function($){
				
				'use strict';
				
				var datatableInit = function(){
					var $table = $('#datatable');

					// Format function for row details
					var fnFormatDetails = function( datatable, tr ) {
						var data = datatable.fnGetData( tr );

						 return [
							'<table class="table mb-none">',
								'<tr class="b-top-none">',
									'<td><label class="mb-none">Assigned to:</label></td>',
									'<td>' + data[12] + '</td>',
								'</tr>',
								'<tr>',
									'<td><label class="mb-none">Description:</label></td>',
									'<td>' + data[11] + '</td>',
								'</tr>',
							'</div>'
						].join('');
					};

					// Insert the expand/collapse column
					var th = document.createElement( 'th' );
					var td = document.createElement( 'td' );
					td.innerHTML = '<i data-toggle class="fa fa-plus-square-o text-primary h5 m-none" style="cursor: pointer;"></i>';
					td.className = "text-center";

					$table
						.find( 'thead tr' ).each(function(){
							this.insertBefore( th, this.childNodes[0] );
						});

					$table
						.find( 'tbody tr' ).each(function(){
							this.insertBefore(  td.cloneNode( true ), this.childNodes[0] );
						});

					// Initialize
					var datatable = $table.dataTable({
						aoColumnDefs: [{
							bSortable: false,
							aTargets: [ 0 ]
						}],
						aaSorting: [
							[1, 'asc']
						]
					});

					// Add a listener
					$table.on('click', 'i[data-toggle]', function() {
						var $this = $(this),
							tr = $(this).closest( 'tr' ).get(0);

						if (datatable.fnIsOpen(tr))
						{
							$this.removeClass('fa-minus-square-o').addClass('fa-plus-square-o');
							datatable.fnClose(tr);
						}
						else
						{
							$this.removeClass('fa-plus-square-o').addClass('fa-minus-square-o');
							datatable.fnOpen(tr, fnFormatDetails(datatable, tr), 'details');
						}
					});
				};

				$(function(){
					datatableInit();
				});

			}).apply(this, [jQuery]);
		</script>
	</body>
</html>
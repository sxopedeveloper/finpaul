<?php include 'template/head.php'; ?>
	<body>
		<?php
		$fq_page_flag = 1;
		$save_flag = 1;		
		
		if ($this->session->userdata('admin_type') == 3 || $this->session->userdata('user_id') == 259)
		{
			?>
			<style type="text/css">
				.fc-title {
					font-size: 1.1em !important;
				}
				
				.fc-event{
					color: #000;
					padding: 4px;
					border: 1px solid #808080;
				}
				
				.fc-event-time{
					display: none !important;
				}
				
				.fc-content .fc-time{
					display: none !important;	
				}
				
				.fc-agendaWeek-view .fc-content .fc-time{
				   display : none !important;
				}
				
				.fc-month-view .fc-content .fc-time{
				   display : none !important;
				}
				
				.ajax_button_primary {
			cursor: pointer; 
			cursor: hand; 
			margin-bottom: 10px;
			color: #58c603;
		}
			</style>
			<?php
			$default_view = 'agendaWeek';
		}
		else
		{
			$default_view = 'agendaDay';
		}	

		if (isset($_GET['action']))
		{
			$event		 = isset($_GET['event_filter']) ? "1" : "0";
			$order       = isset($_GET['order_filter']) ? "1" : "0";
			$tradein     = isset($_GET['tradein_filter']) ? "1" : "0";
			$ticket      = isset($_GET['ticket_filter']) ? "1" : "0";
			$tender      = isset($_GET['tender_filter']) ? "1" : "0";
			$unattempted = isset($_GET['unattempted_filter']) ? "1" : "0";
			$attempted   = isset($_GET['attempted_filter']) ? "1" : "0";
		}
		else
		{
			$event    	 = "1";
			$order       = "1";
			$tradein     = "1";
			$ticket      = "1";
			$tender      = "1";
			$unattempted = "1";
			$attempted   = "1";
		}

		$event_checked = ''; if ($event == "1") { $event_checked = 'checked="checked"'; }
		$order_checked = ''; if ($order == "1") { $order_checked = 'checked="checked"'; }
		$tradein_checked = ''; if ($tradein == "1") { $tradein_checked = 'checked="checked"'; }
		$ticket_checked = ''; if ($ticket == "1") { $ticket_checked = 'checked="checked"'; }
		$tender_checked = ''; if ($tender == "1") { $tender_checked = 'checked="checked"'; }
		$unattempted_checked = ''; if ($unattempted == "1") { $unattempted_checked = 'checked="checked"'; }
		$attempted_checked = ''; if ($attempted == "1") { $attempted_checked = 'checked="checked"'; }
		?>
		<style type="text/css">
			.fc-event{
				color: #000;
			}
			.checkbox{
				padding: 10px !important;
			}
			.fc-event-title {
			
			    line-height: 1 !important;
			}
			.fc-event .fc-event-inner {
			    padding: 1px 3px;
			}
			.fc-list-heading .fc-widget-header{
				background: #58c603 !important;
				border-color: #58c603 !important;
			}
		</style>
		<div class="full_loader"></div>
		<section class="body">
			<?php include 'template/header.php'; ?>
			<div class="inner-wrapper">
				<?php include 'template/left_sidebar.php'; ?>
				<section role="main" class="content-body">
					<?php include 'template/header_2.php'; ?>
					<!-- start: page -->
					<section class="panel">
						<div class="panel-body" style="padding-bottom: 12px !important;">
							<div class="row">
								<div class="col-md-10">
									<div id="calendar"></div>
								</div>
								<div class="col-md-2">
									<form id="view_options_form" action="<?php echo site_url('full_calendar'); ?>">
										<div class="row">
											<div class="col-md-12">
												<p class="h4 text-light">
													DISPLAY FILTERS
												</p>
												<div class="form-group">
													<div class="checkbox" style="background: #fff">
														<label>
															<input type="checkbox" name="unattempted_filter" value="1" class="unattempted_filter display_filter" data-filter="unattempted" <?php echo $unattempted_checked; ?>> Unattempted Leads
														</label>
													</div>
													<div class="checkbox" style="background: #f0ffff">
														<label>
															<input type="checkbox" name="attempted_filter" value="1" class="attempted_filter display_filter" data-filter="attempted" <?php echo $attempted_checked; ?>> Attempted Leads
														</label>
													</div>
													<div class="checkbox" style="background: #f8ffbf">
														<label>
															<input type="checkbox" name="event_filter" value="1" class="event_filter display_filter" data-filter="event" <?php echo $event_checked; ?>> Scheduled Events
														</label>
													</div>
													<div class="checkbox" style="background: #e9d1ff">
														<label>
															<input type="checkbox" name="tender_filter" value="1" class="tender_filter display_filter" data-filter="tender" <?php echo $tender_checked; ?>> Running Tenders
														</label>
													</div>
													<div class="checkbox" style="background: #d2ffbf">
														<label>
															<input type="checkbox" name="order_filter" value="1" class="order_filter display_filter" data-filter="order" <?php echo $order_checked; ?>> New Vehicle Deliveries
														</label>
													</div>
													<div class="checkbox" style="background: #ffd1d1">
														<label>
															<input type="checkbox" name="tradein_filter" value="1" class="tradein_filter display_filter" data-filter="tradein" <?php echo $tradein_checked; ?>> Tradein Deliveries
														</label>
													</div>
													<div class="checkbox" style="background: #e6e6e6">
														<label>
															<input type="checkbox" name="ticket_filter" value="1" class="ticket_filter display_filter" data-filter="ticket" <?php echo $ticket_checked; ?>> Tickets
														</label>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<center>
													<div class="btn-group-">
														<input type="submit" class="btn btn-primary btn-sm" value="Apply Filter" name="action">
														<br><br>
														<span class="btn btn-default btn-sm new-cal-item" >New FQ Item</span>
													</div>	
												</center>
											</div>
										</div>
									</form>										
								</div>
							</div>
						</div>
					</section>
					<!-- end: page -->
				</section>
				<div class="modal fade" id="samp_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <!-- Modal -->
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<h4 class="modal-title" id="myModalLabel">
									Modal title
								</h4>
							</div>
							<div class="modal-body">
								...
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button type="button" class="btn btn-primary">Save changes</button>
							</div>
						</div>
					</div>
				</div>		
				<?php include 'modals/ticket_modals.php'; ?>
				<!-- FinQuote (Start) -->
				<?php include 'modals/fa_application_3.php'; ?>
				<?php include 'modals/fa_requirements.php'; ?>
				<?php include 'modals/all_req_modal.php'; ?>
				<?php include 'modals/new_cal_item.php'; ?>
				<?php include 'modals/fq_emailer.php'; ?>
				<!-- FinQuote (End) -->
			</div>
			<?php include 'template/right_sidebar.php'; ?>
		</section>
		<?php include 'template/scripts.php'; ?>
		<?php include 'template/modals.php'; ?>
		<!-- FinQuote (Start) -->
		<?php include 'js/fapplication_scripts.php'; ?>
		<?php include 'js/fapplication_calendar.php'; ?>
		<!-- FinQuote (End) -->
		<script type="text/javascript">
			$(document).ready(function(){
				
				<?php //$this->load->view('admin/js/my_custom'); ?>

				var all_day_height = 0;
				var day_total_count = 0;
				var date = new Date();
				var d = date.getDate();
				var m = date.getMonth();
				var y = date.getFullYear();

				var html = "";

				var user_id = "<?php echo $session_data['user_id']; ?>";

				var event_params = {
					user_id     : user_id,
					query_flag  : "event",
					display_flag: "<?php echo $event; ?>"
				};

				var order_params = {
					user_id     : user_id,
					query_flag  : "order",
					display_flag: "<?php echo $order; ?>"
				};

				var tradein_params = {
					user_id     : user_id,
					query_flag  : "tradein",
					display_flag: "<?php echo $tradein; ?>"
				};

				var ticket_params = {
					user_id     : user_id,
					query_flag  : "ticket",
					display_flag: "<?php echo $ticket; ?>"
				};

				var tender_params = {
					user_id     : user_id,
					query_flag  : "tender",
					display_flag: "<?php echo $tender; ?>"
				};

				var unattempted_params = {
					user_id     : user_id,
					query_flag  : "unattempted",
					display_flag: "<?php echo $unattempted; ?>"
				};

				var attempted_params = {
					user_id     : user_id,
					query_flag  : "attempted",
					display_flag: "<?php echo $attempted; ?>"
				};
				
				$(document).on("click", ".fc-button-agendaDay", function(){
					$("#calendar").fullCalendar("refetchEvents");
				});

				$(document).on("click", ".fc-button-agendaWeek", function(){
					$("#calendar").fullCalendar("refetchEvents");
				});

				$(document).on("click", ".fc-button-month", function(){
					$("#calendar").fullCalendar("refetchEvents");
				});	
				
				$("#calendar").fullCalendar({
					eventLimit: 5,
					views: 
					{
				        month: 
						{
				            title: "QM",
							url: "http://www.qteme.com.au",
							backgroundColor: "#ffffff",
							description: "Quote Me - New Car Discounts",
							start: "2010-01-01"
				        }
			        },
					header: 
					{
						left: "title",
						right: "prev,today,next,agendaDay,agendaWeek,month,listMonth"
					},
					themeButtonIcons: 
					{
						prev: "fa fa-caret-left",
						next: "fa fa-caret-right",
					},
					defaultDate: '<?php echo date("Y-m-d"); ?>',
					defaultView: '<?php echo $default_view; ?>',
					editable: true,
					droppable: true,
					draggable: true,
					resizable: false,
					dragScroll: true,
					disableResizing :true,
			        events: 
					[
						<?php
						foreach ($fapplications as $fapplication)
						{
							$curr_now_1 = date("Y-m-d") . " " . "09:00:00";
							$curr_now_2 = date("Y-m-d") . " " . "09:30:00";

							if (date("H:i:s", strtotime($fapplication['assignment_date'])) == "00:00:00" && date("H:i:s", strtotime($fapplication['assignment_date_end'])) == "00:00:00")
							{
								$assignment_date = $curr_now_1;
								$assignment_date_end = $curr_now_2;
							}
							else
							{
								$assignment_date = $fapplication['assignment_date'];
								
								if ($fapplication['assignment_date_end'] == "0000-00-00 00:00:00")
								{
									$temp_1 = date("Y-m-d", strtotime($fapplication['assignment_date']));
									$temp_2 = date("H:i:s", strtotime($fapplication['assignment_date']) + 60*30);
									
									$assignment_date_end = $temp_1 . " " . $temp_2;
								}
								elseif( date('Y', strtotime($fapplication['assignment_date_end'])) == "1970" )
								{
									$temp_1 = date("Y-m-d", strtotime($fapplication['assignment_date']));
									$temp_2 = date("H:i:s", strtotime($fapplication['assignment_date']) + 60*30);
									
									$assignment_date_end = $temp_1 . " " . $temp_2;
								}
								else
								{
									$assignment_date_end = $fapplication['assignment_date_end'];
								}
							}
							// $assignment_date;
							 //echo '<br>';
							$sDate = date("Y-m-d H:i:s", strtotime($assignment_date));
							$sDate = explode (":",$sDate );
							//print_r($sDate ); 
							if($sDate[1]  >= 00 && $sDate[1] <= 29)
							{
								$sDate[1] = 00;
							}else if($sDate[1]  >= 30 && $sDate[1] <= 59)
							{
								$sDate[1] = 30;
							}
							//echo $sDate[0];
							 $assignment_date =  date("Y-m-d H:i:s", strtotime($sDate[0].":".$sDate[1].":00"));
							//echo '<br>';
							/* $assignment_date_end ;
							 //echo '<br>';
							$eDate = date("Y-m-d H:i:s", strtotime($assignment_date_end));
							$eDate = explode (":",$eDate );
							//print_r($sDate ); 
							if($eDate[1]  >= 00 && $eDate[1] <= 30)
							{
								$eDate[1] = 30;
							}else if($eDate[1]  >= 31 && $eDate[1] <= 59)
							{
								$eDate[1] = 59;
							}
							 $assignment_date_end =  date("Y-m-d H:i:s", strtotime($eDate[0].":".$eDate[1].":00"));
							
							//exit;*/
							
							 $assignment_date_end =  date("Y-m-d H:i:s", strtotime("+30 minutes", strtotime($assignment_date)));
								
							$color = "#3c94d6";
							
							if ($fapplication['lead_phone']=="")
							{
                                $fapplication['lead_phone'] = "N/A";
							}
							
							if ($fapplication['lead_make']=="" AND $fapplication['lead_model']=="")
							{
								$car = "N/A";
							}
							else
							{
								$car = $fapplication['lead_make']." ".$fapplication['lead_model'];
							}
							?>
							{
								id: <?php echo $fapplication['id_fq_account']; ?>,
								title: '<?php echo addslashes($fapplication['lead_name']).' ('.$car.')' . ' - ' . $fapplication['lead_phone'] . ' - ' . $fapplication['lead_email'] . ' - ' . $fapplication['lead_state']; ?>',
								<?php $status_label = $fapplication['status_text']; ?>
								url: "fapplication",
								backgroundColor: '<?php echo $fapplication['color_status']; ?>',
								start: '<?php echo $assignment_date; ?>',
								end: '<?php echo $assignment_date_end ?>',
								className: "cal_item_" + <?php echo $fapplication['id_fq_account']; ?>
							},
							<?php
						}
						?>
			        ],
			        eventSources: 
					[
			        	{
							url: '<?php echo site_url("full_calendar/get_calendar_items"); ?>',
				            type: "POST",
				            data: event_params,
				            error: function(){
				                alert("There was an error while fetching events!");
				            }
						},
						{
							url: '<?php echo site_url("full_calendar/get_calendar_items"); ?>',
				            type: "POST",
				            data: order_params,
				            error: function(){
				                alert("There was an error while fetching orders!");
				            }
						},
						{
							url: '<?php echo site_url("full_calendar/get_calendar_items"); ?>',
				            type: "POST",
				            data: tradein_params,
				            error: function(){
				                alert("There was an error while fetching tradeins!");
				            }
						},
						{
							url: '<?php echo site_url("full_calendar/get_calendar_items"); ?>',
				            type: "POST",
				            data: ticket_params,
				            error: function(){
				                alert("There was an error while fetching tickets!");
				            }
						},
						{
							url: '<?php echo site_url("full_calendar/get_calendar_items"); ?>',
				            type: "POST",
				            data: tender_params,
				            error: function(){
				                alert("There was an error while fetching tenders!");
				            }
						},
						{
							url: '<?php echo site_url("full_calendar/get_calendar_items"); ?>',
				            type: "POST",
				            data: unattempted_params,
				            error: function(){
				                alert("There was an error while fetching unattempted leads!");
				            }
						},
						{
							url: '<?php echo site_url("full_calendar/get_calendar_items"); ?>',
				            type: "POST",
				            data: attempted_params,
				            error: function(){
				                alert("There was an error while fetching attempted leads!");
				            }
						},
			        ],				
				  	eventResize: function(event, delta, revertFunc, jsEvent, ui, view) 
					{
						var time_start = "start: " + event.start.format();
						var time_end = "end: " + event.end.format();
					},
					navLinkDayClick: function(date, jsEvent) 
					{
				        console.log("day", date.format());
				        console.log("coords", jsEvent.pageX, jsEvent.pageY);
				    },
					eventDrop: function(event, delta, revertFunc) 
					{
						var dataString = "&new_date="+event.start.format();
						var time_start = event.start.format();

						if (event.end != null && event.url == "fapplication")
						{
							var time_end   = event.end.format();
							
							var data = {
								time_start: time_start,
								time_end: time_end
							};
						}
						else
						{
							var data = {
								time_start: time_start
							}

							if (event.url == "fapplication")
							{
								revertFunc();
							}
						}

						if (event.className[0] == "tender" || event.className[0] == "attempted_lead" || event.className[0] == "unattempted_lead")
						{
							$.ajax({
								type: "POST",
								url: "<?php echo site_url('lead/update_assignment_date'); ?>/" + event.id,
								data: dataString,
								cache: false
							});
						}
						else if (event.className[0] == "event")
						{
							
						}						
						else if (event.url == "fapplication")
						{
							$.ajax({
								type: "POST",
								url: "<?php echo site_url('full_calendar/update_record_date'); ?>/" + event.id,
								data: data,
								cache: false
							});
						}
						else
						{
							revertFunc();	
						}
					},
					eventRender: function (event, element, view) 
					{
						$(element).find(".fc-event-time").remove();
						element.attr("href", "javascript:void(0);");

						if (element.hasClass("open-lead-details"))
						{
							element.attr("data-lead_id", event.id);
						}

						if (element.hasClass("open-tradeindetails"))
						{
							element.attr("data-tradein_id", event.id);
						}
						
						element.click(function(){
							if (event.url == "fapplication")
							{
								//alert(event.id);
								var modal_data = null;
								$.post("<?php echo site_url("fapplication/record"); ?>/" + event.id, function(data)
								{
									
									//console.log(data);
									<?php include 'js/full_calendar.php'; ?>
									set_applicant_count_values();
									
									
								}, "json");
                                
                                setTimeout(function(){
                                   // historical_quotes_table.draw();alert('1'); 
                                    historical_quotes_table = $('#account_table').DataTable({
                                        "destroy": true,
                                        "processing": true,
                                        "searching": false,
                                        "language": {
                                            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                                        },
                                        "serverSide": true,
                                        "ordering": true,
                                        "aaSorting": [[1, 'asc']],
                                        "ajax": {
                                            "url": "<?php echo base_url('index.php/fapplication/redbook_data_datatable')?>",
                                            "type": "POST",
                                            "data":function(d){
														d.id_make = $("#id_make").val();
														d.id_modal = $("#id_family").val();
                                                        d.id_rbdata = $("#id_rbdata").val();
                                                        d.fapplication_id = event.id;
                                                        d.state_id = $('#sel_state_hquote').val();
                                                    }
                                        },
                                        "columnDefs": [
                                            {"targets": 0, "orderable": false },
                                            {"targets": 1, "orderable": false },
                                            {"targets": 2, "orderable": false },
                                            {"targets": 3, "orderable": false },
                                            {"targets": 4, "orderable": false },
                                            {"targets": 5, "orderable": false },
                                            {"targets": 6, "orderable": false },
                                            {"targets": 7, "orderable": false },
                                            {"targets": 8, "orderable": false },
                                            {"targets": 9, "orderable": false },
                                            {"targets": 10, "orderable": false },
                                        ],
                                    });

                                }, 2000);
                                
							}setTimeout(function(){$(".toggle.active > label").trigger("click"); console.log(2) }, 1000);
						});
					},
					eventClick: function(event) 
					{
						//alert();
						//console.log(event.className[0]);
						if (event.className[0] == "attempted_lead" || event.className[0] == "unattempted_lead" || event.className[0] == "event" || event.className[0] == "tender" || event.className[0] == "order" || event.className[0] == "tradein")
						{
					        window.open(event.url, "_blank");
					        return false;
					    }
					}
				});
				$("#calendar").fullCalendar("option", "height", 1350);
				
				$(document).on("click", ".lead_details_button", function(){
					$("#calendar_tile_lead_modal").modal();
				});
                
                $(document).on('change', '#sel_state_hquote', function () {
                    historical_quotes_table.draw();                
                });
			});
			
			//QM requied script T
			
			function load_suggested_dealers (container)
			{
				//alert();
				var make = $("#"+container).find("#make_ds").val();
				var state = $("#"+container).find("#state_ds").val();
				var postcode = $("#"+container).find("#postcode_ds").val();
				
				var data = {
					container: container,
					make: make,
					state: state,
					postcode: postcode
				};				
				
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("fapplication/get_suggested_dealers"); ?>",
					data: data,
					cache: false,
					success: function(response){
						//console.log(response);
						$("#"+container).find("#suggested_dealers").html("");
						$("#"+container).find("#suggested_dealers").append(response);
					}
				});
			}	


            function select_suggested_dealer (container, id_user)
			{
				//alert(container);
				if (container == "add_quote_modal")
				{
					var username = $("#"+container).find("#dealer_"+id_user).html();
					var id_quote_request = $("#"+container).find("#id_quote_request").val();
					var demo = $("#"+container).find("#demo").val();			

					var data = {
						id_user: id_user
					};

					$.ajax({
						type: "POST",
						url: "<?php echo site_url('user/get_dealer_state'); ?>",
						data: data,
						cache: false,
						success: function(response){
							$("#"+container).find("#selected_dealers .norecord").prop("hidden", true);
							$("#"+container).find("#selected_dealers").html('<tr><td><input type="hidden" value="'+id_user+'" id="dealer_id_inp" name="dealer_id">'+username+'</td><td></td></tr>');
							
							$("#"+container).find("#dealer_state").val(response);
							$("#"+container).find("#transport_checkbox").val("");
							if ($("#dealer_state").val() != $("#client_state").val() && parseInt($("#tradein_count").val()) > 0)
							{
								$("#"+container).find("#transport_checkbox_container").prop("hidden", false);
							}
							else
							{
								$("#"+container).find("#transport_checkbox_container").prop("hidden", true);
							}
							
							check_existing_quote(container);
						}
					});
				}
                else if (container == "add_dealers_modal" || container == "start_tender_modal" || container == "invited_dealers_modal")
				{
					var dealer_ids = $("#"+container).find("#dealer_ids_inp").val();
					var username = $("#"+container).find("#dealer_"+id_user).html();

					$("#"+container).find("#selected_dealers .norecord").prop("hidden", true);
					$("#"+container).find("#selected_dealers").append('<tr></tr><tr id="selected_dealer_'+id_user+'"><td width="90%">'+username+'</td><td><center><span style="cursor: pointer; cursor: hand; color: #58c603;" onclick="delete_dealer(\''+container+'\', '+id_user+')"><i class="fa fa-times"></i></span></center></td></tr>');
					
					$("#"+container).find("#dealer_ids_inp").val(dealer_ids+"-"+id_user);
					$("#"+container).find("#suggested_dealer_"+id_user).remove();

					if(container == 'add_dealers_modal') {
                    	// $("#email_dealer_trade_model").find("#dealer_id").val(id_user);
                    	get_email_template_add_dealer('add_dealers');
                    }

                    if(container == 'invited_dealers_modal') {
                    	// $("#email_dealer_trade_model").find("#dealer_id").val(id_user);
                    	get_email_template_invited_dealer('invited_dealers');
                    }
                }
                else if(container == "add_trade_valuation_modal" || container == "email_dealer_trade_model")
                {
                    var dealer_ids = $("#"+container).find("#dealer_ids_inp").val();
                    var username = $("#"+container).find("#dealer_"+id_user).html();

                    $("#"+container).find("#selected_dealers .norecord").prop("hidden", true);
                    $("#"+container).find("#selected_dealers").html('<tr></tr><tr><td><input type="hidden" value="'+id_user+'" id="dealer_id_inp" name="dealer_id">'+username+'</td><td></td></tr>');

                    $("#email_dealer_trade_model").find("#dealer_id").val(id_user);
                    if(container == 'email_dealer_trade_model') {
                    	get_email_template('email_dealer_trade');
                    }
                }
			}

			function select_suggested_wholesaler (container, id_user) {
				/*if (container == "add_quote_modal") {
                    var username = $("#"+container).find("#dealer_"+id_user).html();
                    var id_quote_request = $("#"+container).find("#id_quote_request").val();
                    var demo = $("#"+container).find("#demo").val();			

                    var data = {
                        id_user: id_user
                    };

                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('user/get_dealer_state'); ?>",
                        data: data,
                        cache: false,
                        success: function(response){
                            $("#"+container).find("#selected_dealers .norecord").prop("hidden", true);
                            $("#"+container).find("#selected_dealers").html('<tr><td><input type="hidden" value="'+id_user+'" id="dealer_id_inp" name="dealer_id">'+username+'</td><td></td></tr>');

                            $("#"+container).find("#dealer_state").val(response);
                            $("#"+container).find("#transport_checkbox").val("");
                            if ($("#dealer_state").val() != $("#client_state").val() && parseInt($("#tradein_count").val()) > 0) {
                                $("#"+container).find("#transport_checkbox_container").prop("hidden", false);
                            } else {
                                $("#"+container).find("#transport_checkbox_container").prop("hidden", true);
                            }

                            check_existing_quote(container);
                        }
                    });

                    
                } else if (container == "add_dealers_modal" || container == "start_tender_modal" || container == "invited_dealers_modal") {
                    var dealer_ids = $("#"+container).find("#dealer_ids_inp").val();
                    var username = $("#"+container).find("#dealer_"+id_user).html();

                    $("#"+container).find("#selected_dealers .norecord").prop("hidden", true);
                    $("#"+container).find("#selected_dealers").append('<tr id="selected_dealer_'+id_user+'"><td width="90%">'+username+'</td><td><center><span style="cursor: pointer; cursor: hand; color: #58c603;" onclick="delete_dealer(\''+container+'\', '+id_user+')"><i class="fa fa-times"></i></span></center></td></tr>');

                    $("#"+container).find("#dealer_ids_inp").val(dealer_ids+"-"+id_user);
                    $("#"+container).find("#suggested_dealer_"+id_user).remove();
                }else*/ if(container == "add_trade_valuation_modal" || container == "email_wholesaler_trade_model"){
                    
                    var dealer_ids = $("#"+container).find("#dealer_ids_inp").val();
                    var username = $("#"+container).find("#dealer_"+id_user).html();
                    
                    $("#"+container).find("#selected_wholesalers .norecord").prop("hidden", true);
                    $("#"+container).find("#selected_wholesalers").html('<tr></tr><tr><td><input type="hidden" value="'+id_user+'" id="dealer_id_inp" name="dealer_id">'+username+'</td><td></td></tr>');
                    
                    $("#email_wholesaler_trade_model").find("#dealer_id").val(id_user);
                    get_email_template('email_wholesaler_trade');

                }
            }

			function get_email_template(container)
			{
				var fq_acct_id = $("#fapplication_id").val();
			    let id_tradein = $("#"+container+"_form").find("#id_tradein").val();
			    let id_lead = $("#"+container+"_form").find("#id_lead").val();
			    let id_quote_request = $("#"+container+"_form").find("#id_quote_request").val();
			    let email_template_id = $("#"+container+"_model").find("#email_template_id").val();
			    let dealer_id = $("#"+container+"_model").find("#dealer_id").val();
			    
			    var data = {
			        id: email_template_id,
			        fq_acct_id: fq_acct_id,
			        id_lead: id_lead,
			        id_tradein: id_tradein,
			        id_quote_request: id_quote_request,
			        dealer_id: dealer_id
			    };

			    let type = container.split('_')[1];
			    
			    $('textarea.email_'+type+'_template').ckeditor({ 
		            height: 300,
		            allowedContent:true
		        });

		        $('#'+type+'_edit_template').show();

		        $.ajax({
			        type: "POST",
			        url: "<?php echo site_url(); ?>/fapplication/get_system_email_template/"+type+"_modal",
			        data: data,
			        cache: false,
			        dataType: 'json',
			        success: function(data){
			        	if(type == 'dealer') {
			        		setTimeout(function() {
			        			CKEDITOR.instances.email_dealer_template.setData(data.content); 
			        		}, 1500);
			        	}
			        	if(type == 'wholesaler') {
			        		setTimeout(function() {
			        			CKEDITOR.instances.email_wholesaler_template.setData(data.content); 
			        		},1500);
			        	}
			        },
			        error: function(data) {
			        	swal("ERROR", "An error occurred! Please try again", "error");
			        }
			    });
			}

			function get_email_template_invited_dealer(container)
			{
				var fq_acct_id = $("#fapplication_id").val();
			    let id_lead = $("#"+container+"_form").find("#id_lead").val();
			    let id_quote_request = $("#"+container+"_form").find("#id_quote_request").val();
			    let email_template_id = $("#"+container+"_modal").find("#email_template_id").val();
			    let dealer_id = $("#"+container+"_modal").find("#dealer_ids_inp").val();
			    
			    var data = {
			        id: email_template_id,
			        fq_acct_id: fq_acct_id,
			        id_lead: id_lead,
			        id_quote_request: id_quote_request,
			        dealer_id: dealer_id
			    };

			    let type = container.split('_')[1];
			    
			    $('textarea.resend_quote_email_template_content').ckeditor({ 
		            height: 300,
		            allowedContent:true
		        });

		        $('#'+type+'_edit_template').show();

			    $.ajax({
			        type: "POST",
			        url: "<?php echo site_url(); ?>/fapplication/get_system_email_template/"+container+"_modal",
			        data: data,
			        cache: false,
			        dataType: 'json',
			        success: function(data){
			        	setTimeout(function() {
			        		CKEDITOR.instances.resend_quote_email_template_content.setData(data.content); 
			        	}, 1500);
			        },
			        error: function(data) {
			        	swal("ERROR", "An error occurred! Please try again", "error");
			        }
			    });
			}

			function get_email_template_add_dealer(container)
			{
				var fq_acct_id = $("#fapplication_id").val();
			    let id_lead = $("#"+container+"_form").find("#id_lead").val();
			    let id_quote_request = $("#"+container+"_form").find("#id_quote_request").val();
			    let email_template_id = $("#"+container+"_modal").find("#email_template_id").val();
			    let dealer_id = $("#"+container+"_modal").find("#dealer_ids_inp").val();
			    
			    var data = {
			        id: email_template_id,
			        fq_acct_id: fq_acct_id,
			        id_lead: id_lead,
			        id_quote_request: id_quote_request,
			        dealer_id: dealer_id
			    };

			    // let type = container.split('_')[1];

			    $('textarea.add_dealer_email_template_content').ckeditor({ 
		            height: 300,
		            allowedContent:true
		        });

			    // $('#'+container+'_edit_template').show();

			    $.ajax({
			        type: "POST",
			        url: "<?php echo site_url(); ?>/fapplication/get_system_email_template/add_dealer_modal",
			        data: data,
			        cache: false,
			        dataType: 'json',
			        success: function(data){
			        	// console.log(data);
			        	setTimeout(function() {
			        		CKEDITOR.instances.add_dealer_email_template_content.setData(data.content); 
			        	}, 1500);
			        },
			        error: function(data) {
			        	swal("ERROR", "An error occurred! Please try again", "error");
			        }
			    });
			}
            
            function delete_dealer (container, dealer_id)
			{
				$("#"+container).find("#selected_dealer_"+dealer_id).remove();
			}	
			
            function load_families (container, make_id, family_id)
			{
				//alert();
				if(make_id != "")
				{
					if (family_id == 0 || typeof(family_id) == "undefined")
					{
						$("#"+container).find("#build_date").html("<option value='0'></option>");
						$("#"+container).find("#build_date").prop("disabled", true);
						$("#"+container).find("#vehicle").html("<option value='0'></option>");
						$("#"+container).find("#vehicle").prop("disabled", true);
						$("#"+container).find("#option").html("");

						var data = {
							make_id: make_id
						};						
					}
					else
					{
						var data = {
							make_id: make_id,
							family_id: family_id
						};
					}
					
					$.ajax({
						type: "POST",
						url: "<?php echo site_url("cars/load_families"); ?>",
						cache: false,
						data: data,
						success: function(response){
							//console.log(response);
							$("#"+container).find("#family").removeAttr("disabled");
							$("#"+container).find("#family").html("<option value='0'></option>");
							$("#"+container).find("#family").append(response);
						}
					});				
				}
            }

            function load_build_dates (container, family_id, build_date)
            {
                if(family_id != "")
                {
                    if (build_date == 0 || typeof(build_date) == "undefined")
                    {
                        $("#"+container).find("#vehicle").html("<option value='0'></option>");
                        $("#"+container).find("#vehicle").prop("disabled", true);
                        $("#"+container).find("#option").html("");

                        var data = {
                            family_id: family_id
                        };
                    }
                    else
                    {
                        var data = {
                            family_id: family_id,
                            build_date: build_date
                        };
                    }
                    var make_id = $("#"+container).find("#make").val();

                    //rbgetdata(container,make_id,family_id,0)
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url("cars/load_build_dates"); ?>",
                        cache: false,
                        data: data,
                        success: function(response){
                            $("#"+container).find("#build_date").removeAttr("disabled");
                            $("#"+container).find("#build_date").html("<option value='0'></option>");
                            $("#"+container).find("#build_date").append(response);
                        }
                    });
                }
            }

            function load_vehicles (container, code, vehicle_id)
			{
				if(code != "")
				{
					if (vehicle_id == 0 || typeof(vehicle_id) == "undefined") 
					{
						$("#"+container).find("#options").html("");

						var data = {
							code: code
						};							
					}
					else
					{
						var data = {
							code: code,
							vehicle_id: vehicle_id
						};							
					}

					$.ajax({
						type: "POST",
						url: "<?php echo site_url("cars/load_vehicles"); ?>",
						cache: false,
						data: data,
						success: function(response){
							$("#"+container).find("#vehicle").removeAttr("disabled");
							$("#"+container).find("#vehicle").html("<option value='0'></option>");
							$("#"+container).find("#vehicle").append(response);
						}
					});				
				}
			}		
			
            function check_existing_quote (container)
            {		
				var id_user = $("#"+container).find("#dealer_id_inp").val();
				var id_quote_request = $("#"+container).find("#id_quote_request").val();
				var demo = $("#"+container).find("#demo").val();

				if (id_user && id_quote_request && demo && id_user != "" && id_quote_request != "" && demo != "" && id_user != "0" && id_quote_request != "0")
				{
					var data = {
						id_user: id_user,
						id_quote_request: id_quote_request,
						demo: demo
					};
					
					$.ajax({
						type: "POST",
						url: "<?php echo site_url('lead/get_dealer_existing_quote'); ?>",
						data: data,
						cache: false,
						success: function(response){
							if (response == 0)
							{
								$("#add_quote_modal").find("#quote_form_container").prop("hidden", false);
								$("#add_quote_modal").find("#quote_form_warning_container").prop("hidden", true);
								$("#add_quote_modal").find("#quote_form_warning_message").html();
								$("#add_quote_modal").find("#add_quote_submit_button").prop("disabled", false);
							}
							else
							{
								$("#add_quote_modal").find("#quote_form_container").prop("hidden", true);
								$("#add_quote_modal").find("#quote_form_warning_container").prop("hidden", false);
								$("#add_quote_modal").find("#quote_form_warning_message").html("There is already an existing "+demo+" Vehicle Quote from this Dealer");
								$("#add_quote_modal").find("#add_quote_submit_button").prop("disabled", true);
							}						
						}		
					});					
				}
			}

			 $(document).on('submit', '#add_dealers_form', function (e) {
                	e.preventDefault();
			        $("#add_dealers_modal").find("#add_dealers_submit_button").prop("disabled", true);
			       
			        var rowCount = $('#add_dealers_modal .selected_dealers tbody tr').length;
			        if(rowCount <= 1){
			            swal("ERROR", "Please Select Dealer !", "error");
			            return false;
			        }
			        var postData = new FormData(this);
			        $.ajax({
			            type: "POST",
			            url: "<?php echo site_url("fapplication/add_dealers"); ?>",
			            data: postData,
			            fileElementId   :'quote_file',
			            processData: false,
			            contentType: false,
			            cache: false,
			            success: function(response) {
			                //console.log(response);
			                var res = response.trim();
			                if (res === "success") {
			                    $("#add_dealers_modal").modal("hide");
			                    $("#add_dealers_modal").find("#selected_dealers").html("");
			                    $("#add_dealers_modal").find("#dealer_ids_inp").val("0");
			                    $("#add_dealers_modal").find(".norecord").prop("hidden", false);                            
			                    $("#add_dealers_modal").find("#add_dealers_submit_button").prop("disabled", false);
			                    
								
								if($('#add_dealers_modal .selected_dealers tbody tr').length == 0){
									$('#add_dealers_modal .selected_dealers tbody').html('<tr class="norecord"><td colspan="2"><center>No dealer is selected!</center></td></tr>');
								}

								swal("SUCCESS", "", "success");
			                    // location.reload(true);
			                } else {
			                    swal("ERROR", "An error occurred! Please try again", "error");
			                }
			            }
			        });
			    });

		    $(document).on('submit', '#invited_dealers_form', function (e) {
			    e.preventDefault();
			    var rowCount = $('#invited_dealers_form .selected_dealers tbody tr').length;
			    if(rowCount <= 1){
			        swal("ERROR", "Please Select Dealer !", "error");
			        return false;
			    }
			    var postData = new FormData(this);
			    $.ajax({
			        type: "POST",
			        url: "<?php echo site_url("fapplication/invited_dealers"); ?>",
			        data: postData,
			        fileElementId   :'quote_file',
			        processData: false,
			        contentType: false,
			        cache: false,
			        success: function(response) {
			            //console.log(response);
			            var res = response.trim();
			            if (res === "success") {
			                $("#invited_dealers_modal").modal("hide");
			                $("#invited_dealers_modal").find("#selected_dealers").html("");
			                $("#invited_dealers_modal").find(".norecord").prop("hidden", false);                            

			                swal("SUCCESS", "", "success");
			                // location.reload(true);
			            } else {
			                swal("ERROR", "An error occurred! Please try again", "error");
			            }
			        }
			    });
			});

			$(document).on('submit', '#email_client_trade_form', function (e) {
			    e.preventDefault();
			    var postData = new FormData(this);
			    $.ajax({
			        type: "POST",
			        url: "<?php echo site_url("tradein/send_mail_client_trade"); ?>",
			        data: postData,
			        processData: false,
			        contentType: false,
			        cache: false,
			        success: function(response) {
			            var res = response.trim();
			            if (res === "success") {
			                $("#email_client_trade_model").modal("hide");
			                $("#email_client_trade_model").find("textarea").html("");
			                swal("SUCCESS", "", "success");

			            } else {
			                swal("ERROR", "An error occurred! Please try again", "error");
			            }
			        }
			    });
			});

			$(document).on('submit', '#email_dealer_trade_form', function (e) {
			    e.preventDefault();
			    var rowCount = $('#email_dealer_trade_form .selected_dealers tbody tr').length;
			    if(rowCount <= 1){
			    	swal("ERROR", "Please Select Dealer !", "error");
			        return false;
			    }

			    $("#email_dealer_trade_model").find("#email_dealer_trade_sub_btn").prop("disabled", true);
			    
			    var postData = new FormData(this);
			    $.ajax({
			        type: "POST",
			        url: "<?php echo site_url('tradein/send_mail_dealer_trade'); ?>",
			        data: postData,
			        processData: false,
			        contentType: false,
			        cache: false,
			        success: function(response) {
			            var res = response.trim();
			            if (res === "success") {
			                $("#email_dealer_trade_model").modal("hide");
			                $("#email_dealer_trade_model").find("#selected_dealers").html("");
			                $("#email_dealer_trade_model").find("textarea").html("");
			                $("#email_dealer_trade_model").find(".norecord").prop("hidden", false);

			                swal("SUCCESS", "", "success");
			            } else {
			                swal("ERROR", "An error occurred! Please try again", "error");
			            }
			            $("#email_dealer_trade_model").find("#email_dealer_trade_sub_btn").prop("disabled", false);
			        }
			    });
			});

			$(document).on('submit', '#email_wholesaler_trade_form', function (e) {
			    e.preventDefault();
			    var rowCount = $('.selected_dealers tbody tr').length;
			    if(rowCount <= 1){
			        swal("ERROR", "Please Select Dealer !", "error");
			        return false;
			    }
			    
			    $("#email_wholesaler_trade_model").find("#email_wholesaler_trade_sub_btn").prop("disabled", true);
			    
			    var postData = new FormData(this);
			    $.ajax({
			        type: "POST",
			        url: "<?php echo site_url('tradein/send_mail_wholesaler_trade'); ?>",
			        data: postData,
			        processData: false,
			        contentType: false,
			        cache: false,
			        success: function(response) {
			            var res = response.trim();
			            if (res === "success") {
			                $("#email_wholesaler_trade_model").modal("hide");
			                $("#email_wholesaler_trade_model").find("#selected_dealers").html("");
			                $("#email_wholesaler_trade_model").find("textarea").html("");
			                $("#email_wholesaler_trade_model").find(".norecord").prop("hidden", false);

			                swal("SUCCESS", "", "success");

			            } else {
			                swal("ERROR", "An error occurred! Please try again", "error");
			            }
			            $("#email_wholesaler_trade_model").find("#email_wholesaler_trade_sub_btn").prop("disabled", false);
			        }
			    });
			});

			$(document).on('submit', '#resend_vehicle_confirmation', function (e) {
			    e.preventDefault();
			    let postData = new FormData(this);
			    $.ajax({
			        type: "POST",
			        url: "<?php echo site_url("fapplication/resend_vehicle_confirmation"); ?>",
			        data: postData,
			        fileElementId   :'quote_file',
			        processData: false,
			        contentType: false,
			        cache: false,
			        success: function(response) {
			            //console.log(response);
			            var res = response.trim();
			            if (res === "success") {
			                $("#send_email_template_model").modal("hide");
			                swal("SUCCESS", "", "success");
			            } else {
			                swal("ERROR", "An error occurred! Please try again", "error");
			            }
			        }
			    });
			});

			var historical_quotes_datatable = function(fapplication_id) { 
              historical_quotes_table = $('#account_table').DataTable({
                    "destroy": true,
                    "processing": true,
                    "searching": false,
                    "language": {
                        processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                    },
                    "serverSide": true,
                    "ordering": true,
                    "ajax": {
                        "url": "<?php echo base_url('index.php/fapplication/redbook_data_datatable')?>",
                        "type": "POST",
                        "data":function(d){
									d.id_make = $("#id_make").val();
									d.id_modal = $("#id_family").val();
                                    d.id_rbdata = $("#id_rbdata").val();
                                    d.fapplication_id = fapplication_id;
                                    d.state_id = $('#sel_state_hquote').val();
                                }
                    },    
                    "columnDefs": [
                        {"targets": 0, "orderable" : false},
                        {"targets": 1, "orderable" : false},
                        {"targets": 2, "orderable" : false},
                        {"targets": 3, "orderable" : false},
                        {"targets": 4, "orderable" : false},
                        {"targets": 5, "orderable" : false},
                        {"targets": 6, "orderable" : false},
                        {"targets": 7, "orderable" : false},
                        {"targets": 8, "orderable" : false},
                        {"targets": 9, "orderable" : false},
                        {"targets": 10, "orderable" : false},
                    ]
                });
            }
			
			$("#start_tender_form").submit(function(e) { // Reload //
				
				var make = $("#start_tender_form").find("#make").val();
				var family = $("#start_tender_form").find("#family").val();
				var build_date = $("#start_tender_form").find("#build_date").val();
				var vehicle = $("#start_tender_form").find("#vehicle").val();
				var colour = $("#start_tender_form").find("#colour").val();
				var registration_type = $("#start_tender_form").find("#registration_type").val();
				var rb_data =  $("#start_tender_form").find("#rb_data").val();
				var postcode = $("#start_tender_form").find("#postcode_ds2").val();
				/**/
				var make_old = $("#start_tender_form").find("#make").attr('data-old');
		        var family_old = $("#start_tender_form").find("#family").attr('data-old');
		        var colour_old = $("#start_tender_form").find("#colour").attr('data-old');
		        var registration_type_old = $("#start_tender_form").find("#registration_type").attr('data-old');
		        var rb_data_old =  $("#start_tender_form").find("#rb_data").attr('data-old');
		        var postcode_old = $("#start_tender_form").find("#postcode_ds2").attr('data-old');
		        /**/
                var id_lead =  $("#start_tender_form").find("#id_leads").val();

                var other_data = $('#fapplication_main_form').serializeArray();

                var newArr = ['new_lead_name','new_lead_surname','new_lead_number','new_lead_email_address','new_lead_address','new_lead_postcode','new_lead_dl_no','new_lead_credit_card','new_lead_card_no','new_lead_exp_date','new_lead_cvv_no','new_lead_deposit_amt','newLead_car_year','newLead_make','newLead_model','newLead_car_variant','new_lead_redbook_url','new_lead_sale_price','new_lead_winning_quote','new_lead_winning_trade','new_lead_gross_margin','new_lead_delivery_date','new_lead_dealer','new_lead_wholesaler'];
			    
			    /* main application form data */
			    $.each(other_data,function(key,input){
			    	if(jQuery.inArray(input.name, newArr) != -1) {
			    		let input11 = $("#fapplication_main_form").find(':input[name="'+input.name+'"]');
			    		if($(input11).is('select')) {
			    			$("#fapplication_main_form").find(':input[name="'+input.name+'"]').clone().appendTo("#start_tender_form").css('visibility','hidden');
			    		}
			    		else if($(input11).is('input:text')) {
			    			$("#fapplication_main_form").find(':input[name="'+input.name+'"]').clone().appendTo("#start_tender_form").attr('type','hidden');
			    		}
			    		// $("#fapplication_main_form").find(':input[name="'+input.name+'"]').appendTo("#start_tender_form");
			        }
			    });
                
				if (rb_data == "" || rb_data == 0 || make == 0 || make == "" || family == 0 || family == "" ||  registration_type == "")
				{  // || build_date == 0 || build_date == "" || vehicle == 0 || vehicle == "" || colour == ""
					swal("ERROR", "Please complete all the required fields!", "error");
				}
				else
				{
					console.log(make +'--'+ make_old);
		        	console.log(registration_type +'--'+ registration_type_old);
		        	console.log(postcode +'--'+ postcode_old);
		        	console.log(family +'--'+ family_old);
		        	console.log(colour +'--'+ colour_old);
		        	console.log(rb_data +'--'+ rb_data_old);
					if(make != make_old || registration_type != registration_type_old || postcode != postcode_old || family != family_old || colour != colour_old || rb_data != rb_data_old) {
		             	swal("ERROR", "Please Save Information Before Send", "error");   
		            }
		            else {
			            $.ajax({
							type: "POST",
							url: "<?php echo site_url("fapplication/start_tender_new"); ?>",
							data: $("#start_tender_form").serialize(),
							cache: false,
							success: function(response) {
								//console.log(response); 
								var res = response.trim();
								if (res === "success" || res === "successsuccess")
								{
									$("#start_tender_modal").find("#selected_dealers").html("");
									$("#start_tender_modal").find("#suggested_dealers").html("");
									$("#start_tender_modal").find("input,textarea,select").val("");
									$("#start_tender_modal").find("#dealer_ids_inp").val("0");
									$("#start_tender_modal").modal("hide");

									swal("SUCCESS", "", "success");
									//location.reload(true);
	                                $.post("<?php echo site_url("fapplication/record"); ?>/" + id_lead, function(data) {
	                                    //console.log(data);
	                                    <?php $this->load->view('admin/js/full_calendar'); ?>
	                                    set_applicant_count_values();
	                                    set_car_data();
	                                    //historical_quotes_table.draw();
	                                }, 'json');

	                                setTimeout(function(){
	                                    historical_quotes_datatable(id_lead);
	                                }, 2000);
								}
								else
								{
									swal("ERROR", "An error occurred! Please contact the administrator", "error");
								}							
							}
						});
		            }
				}
				e.preventDefault();
			});
			
			// $(".add_dealers_modal_button").click(function(e) {
				// alert();
				// var name = $("#client_details_form").find("#name").val();
				// var email = $("#client_details_form").find("#email").val();
				// $("#add_dealers_form").find("#label_name").html(name);
				// $("#add_dealers_form").find("#label_email").html(email);
			
				// var id_lead = $(this).data("id_lead");
				// var id_quote_request = $(this).data("id_quote_request");
				// console.log(id_quote_request);
				// load_dealer_selector_parameters("add_dealers_modal", id_lead, "quote_request");

				// $("#add_dealers_modal").find("#id_quote_request").val(id_quote_request);
				// $("#add_dealers_modal").modal();
			// });
			function load_dealer_selector_parameters (container, id_lead, type)
			{
				var data = {
					id_lead: id_lead,
					type: type
				};

				$.ajax({
					type: "POST",
					url: "<?php echo site_url("fapplication/get_dealer_selector_parameters"); ?>",
					data: data,
					cache: false,
					dataType: "json",
					success: function(response){
						$("#"+container).find("#make_ds").val(response.make);
						$("#"+container).find("#state_ds").val(response.state);
						load_suggested_dealers(container);
					}
				});
			}
			
			function calculate_quote_new (container)
			{
				var registration_type    	= $(container).find('#registration_type').val();
				var retail_price         	= parseFloat($(container).find('#retail_price').val());
				var metallic_paint       	= parseFloat($(container).find('#metallic_paint').val());
				var fleet_discount       	= parseFloat($(container).find('#fleet_discount').val());
				var dealer_discount      	= parseFloat($(container).find('#dealer_discount').val());
				var predelivery          	= parseFloat($(container).find('#predelivery').val());
				var luxury_tax           	= parseFloat($(container).find('#luxury_tax').val());
				var ctp                  	= parseFloat($(container).find('#ctp').val());
				var registration         	= parseFloat($(container).find('#registration').val());
				var premium_plate_fee    	= parseFloat($(container).find('#premium_plate_fee').val());
				var stamp_duty           	= parseFloat($(container).find('#stamp_duty').val());
				var dealer_tradein_value 	= parseFloat($(container).find('#dealer_tradein_value').val());
				var dealer_tradein_payout   = parseFloat($(container).find('#dealer_tradein_payout').val());
				var dealer_client_refund    = parseFloat($(container).find('#dealer_client_refund').val());
				
				if ($(container).find('#retail_price').val()          == "") { retail_price = 0; }
				if ($(container).find('#metallic_paint').val()        == "") { metallic_paint = 0; }
				if ($(container).find('#fleet_discount').val()        == "") { fleet_discount = 0; }
				if ($(container).find('#dealer_discount').val()       == "") { dealer_discount = 0; }
				if ($(container).find('#predelivery').val()           == "") { predelivery = 0; }
				if ($(container).find('#luxury_tax').val()            == "") { luxury_tax = 0; }
				if ($(container).find('#ctp').val()                   == "") { ctp = 0; }
				if ($(container).find('#registration').val()          == "") { registration = 0; }
				if ($(container).find('#premium_plate_fee').val()     == "") { premium_plate_fee = 0; }
				if ($(container).find('#stamp_duty').val()            == "") { stamp_duty = 0; }
				if ($(container).find('#dealer_tradein_value').val()  == "") { dealer_tradein_value = 0; }
				if ($(container).find('#dealer_tradein_payout').val() == "") { dealer_tradein_payout = 0; }
				if ($(container).find('#dealer_client_refund').val()  == "") { dealer_client_refund = 0; }

				var opt_index = 0;
				var total_options = 0;
				var curr_option = 0;
				while ($(container).find('#option_' + opt_index).length > 0)
				{
					curr_option = parseFloat($(container).find('#option_' + opt_index).val());
					if ($(container).find('#option_' + opt_index).val() == "") 
					{
						curr_option = 0; 
					}
					total_options = total_options + curr_option;
					opt_index = opt_index + 1;
				}				

				var acc_index = 0;
				var total_accessories = 0;
				var curr_accessory = 0;
				while ($(container).find('#accessory_' + acc_index).length > 0)
				{
					curr_accessory = parseFloat($(container).find('#accessory_' + acc_index).val());
					if ($(container).find('#accessory_' + acc_index).val() == "") 
					{ 
						curr_accessory = 0; 
					}
					total_accessories = total_accessories + curr_accessory;
					acc_index = acc_index + 1;
				}

				var subtotal_1 = retail_price + metallic_paint - fleet_discount - dealer_discount;
				var subtotal_2 = subtotal_1 + total_accessories + total_options + predelivery;
				
				if (registration_type == "Exempted" || registration_type == "TPI/Gold Card")
				{
					var gst = 0;
				}
				else
				{
					var gst = (subtotal_2) * 0.10;
				}

				var subtotal_3 = subtotal_2 + gst;				
				var total = subtotal_3 + luxury_tax + ctp + registration + premium_plate_fee + stamp_duty;
				var dealer_changeover = total - dealer_tradein_value + dealer_tradein_payout + dealer_client_refund;

				$(container).find("#gst").val(gst);
				$(container).find("#subtotal_1").val(subtotal_1);
				$(container).find("#subtotal_2").val(subtotal_2);
				$(container).find("#subtotal_3").val(subtotal_3);
				$(container).find("#total").val(total);
				$(container).find("#dealer_changeover").val(dealer_changeover);
			}

			$(document).on('submit', '#add_quote_form', function (e){
		        e.preventDefault();
		            
		        $(this).find(':submit').attr( 'disabled','disabled' );

		        var submitChildren = $(this).find('button[type=submit]');
		        submitChildren.attr('disabled', 'disabled');
		        submitChildren.addClass('disabled');

		        //alert('');return false;
		        var postData = new FormData(this);        
		        $.ajax({
		            url: "<?php echo site_url('user/send_quote'); ?>",
		            type: "POST",
		            processData: false,
		            contentType: false,
		            cache: false,
		            data: postData,
		            fileElementId:'quote_file',
		            success: function(response){
		                console.log(response);
		                var json = $.parseJSON(response);
		                if (json['success']) {
		                    swal("SUCCESS", "", "success");
		                    setTimeout(function(){
		                        window.location.reload();                                
		                    }, 1000);
		                } else {
		                    swal("ERROR", "An error occurred! Please try again", "error");
		                }
		                return false;
		                /*var res = response.trim();
		                if (res === "success") {
		                    $("#add_quote_modal").find("input,textarea,select").val("");
		                    $("#add_quote_modal").modal("hide");                    
		                } else {                    
		                }*/                
		            }
		        });
		        return false;
		    });	
			
			<?php $this->load->view('admin/js/my_custom'); ?>

		</script>
	</body>
</html>
		<script>
			function add_ticket_comment ()
			{
				var ticket_id = $('#ticket_id').val();
				var comment = $('#ticket_comment').val();

				$("#addcomment_loader").show();
				$("#addcomment_loader").fadeIn(400).html('Sending...');
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('ticket/add_comment'); ?>",
					data: $("form").serialize(),
					cache: false,
					success: function(result){
						$("#addcomment_loader").hide();
						$("#ticket_comment").val("");
						$("#ticket-modal").modal("hide");
					}
				});
			}
			
			function close_ticket ()
			{
				if (confirm("Are you sure you want to mark this ticket as Closed?")) 
				{			
					var ticket_id = $("#ticket_id").val();
					var dataString = "&ticket_id="+ticket_id;

					$("#closeticket_loader").show();
					$("#closeticket_loader").fadeIn(400).html("Sending...");
					$.ajax({
						type: "POST",
						url: "<?php echo site_url("ticket/close"); ?>",
						data: dataString,
						cache: false,
						success: function(result){
							$("#closeticket_loader").hide();
							$("#status_label_" + ticket_id).css("color", "#088600");
							$("#status_label_" + ticket_id).html('<span style="color: #088600 id="status_label_' + ticket_id + '"><b>Closed</b></span>');
							$("#ticket_comment").val("");
							$("#ticket-modal").modal("hide");
						}
					});
				}
			}
			
			function reopen_ticket ()
			{
				if (confirm("Are you sure you want to reopen this ticket?"))
				{			
					var ticket_id = $("#ticket_id").val();
					var dataString = "&ticket_id="+ticket_id;

					$("#closeticket_loader").show();
					$("#closeticket_loader").fadeIn(400).html("Sending...");
					$.ajax({
						type: "POST",
						url: "<?php echo site_url("ticket/reopen"); ?>",
						data: dataString,
						cache: false,
						success: function(result){
							$("#closeticket_loader").hide();
							$("#status_label_" + ticket_id).css("color", "#3E1AFF");
							$("#status_label_" + ticket_id).html('<span style="color: #3E1AFF id="status_label_' + ticket_id + '"><b>Open</b></span>');
							$("#ticket_comment").val("");
							$("#ticket-modal").modal("hide");
						}
					});
				}
			}
			
			function delete_ticket ()
			{
				if (confirm('Are you sure you want to delete this ticket?')) 
				{
					var ticket_id = $('#ticket_id').val();
					var dataString = '&ticket_id='+ticket_id;
					$.ajax({
						type: "POST",
						url: "<?php echo site_url('ticket/delete'); ?>",
						data: dataString,
						cache: false,
						success: function(result){
							$("#calendar").fullCalendar("removeEvents",ticket_id);
							$("#ticket_comment").val("");
							$("#ticket-modal").modal("hide");
						}
					});				
				}
			}
			
			function update_toc ()
			{
				var ticket_id = $('#ticket_id').val();
				var toc = $('#eta_val').val();
				var dataString = '&ticket_id='+ticket_id+'&toc='+toc;
			
				$("#edittoc_loader").show();
				$("#edittoc_loader").fadeIn(400).html('Sending...');
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('ticket/update_toc'); ?>",
					data: dataString,
					cache: false,
					success: function(result){
						$("#edittoc_loader").hide();
						$("#toc").html(toc);
						$("#edittoc-modal").modal("hide");
					}
				});
			}

			$(document).on("click", ".open-edittoc", function(data)
			{
				var ticket_id = $(this).data("ticket_id");
				$("#edittoc-modal").modal();
			});

			$(document).on("click", ".edit-ticket", function()
			{
				var ticket_id = $(this).data("ticket_id");				
				$("#hidden_edit_ticket_id").val(ticket_id);
				var data = {
					ticket_id: ticket_id
				}
				$("#ticket_edit_user_id_to").val([]).trigger("change");
				$("#ticket_edit_ticket_type").val("");
				$("#ticket_edit_priority").val("");
				$("#ticket_edit_module").val("");
				$("#ticket_edit_name").val("");
				$("#ticket_edit_assignment_date").val("");
				$("#ticket_edit_description").val("");
				
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('ticket/get_ticket'); ?>",
					data: data,
					cache: false,
					dataType: 'json',
					success: function(data){
						$("#ticket_edit_user_id_to").val(data.id_to).trigger("change");
						$("#ticket_edit_ticket_type").val(data.ticket_type);
						$("#ticket_edit_priority").val(data.priority);
						$("#ticket_edit_module").val(data.module);
						$("#ticket_edit_name").val(data.name);
						$("#ticket_edit_assignment_date").val(data.assignment_date);
						$("#ticket_edit_description").val(data.description);

						$("#edit_ticket_modal").modal();
					}
				});
			});

			$(document).on("click", ".ticket_submit_edit", function()
			{
				var form = $("#edit_form").serialize();

				var ticket_type     = $("#ticket_edit_ticket_type").val();
				var priority        = $("#ticket_edit_priority").val();
				var module          = $("#ticket_edit_module").val();
				var name            = $("#ticket_edit_name").val();
				var assignment_date = $("#ticket_edit_assignment_date").val();
				var assigned_to     = $("#ticket_edit_user_id_to").val();

				var ticket_id = $("#hidden_edit_ticket_id").val();

				if(ticket_type == "")
				{
					alert("Please choose a Ticket Type!");
					return false;
				}
				if(priority == "")
				{
					alert("Please choose a priority!");
					return false;
				}
				if(module == "")
				{
					alert("Please choose a module!");
					return false;
				}
				if(name == "")
				{
					alert("Subject cannot be blank!");
					return false;
				}
				if(assignment_date == "")
				{
					alert("Schedule start date cannot be blank!");
					return false;
				}

				if(assigned_to == null)
				{
					alert("Please choose a recipient!");
					return false;
				}

				var this_row = $("#ticket_row_"+ticket_id);

				$.ajax({
					type: "POST",
					url: "<?php echo site_url('ticket/update_ticket'); ?>",
					data: form,
					cache: false,
					success: function(result){

						$(this_row).find(".ticket_priority").text( $("#ticket_edit_priority option:selected").text() );
						$(this_row).find(".ticket_type").text( $("#ticket_edit_ticket_type option:selected").text() );
						$(this_row).find(".ticket_module").text( $("#ticket_edit_module option:selected").text() );
						$(this_row).find(".ticket_name").text( name );
						$(this_row).find(".ticket_start_date").text( assignment_date );

						$("#edit_ticket_modal").modal("hide");
					}
				});
			});

			function add_t_comment_modal () // 06-01-16
			{
				var ticket_id = $("#ticket_id").val();
				$("#addticketcomment-modal").find("#ticket_comment").val("");
				$("#addticketcomment-modal").find("#t_uploaded_comment_files").html("");
				$("#addticketcomment-modal").find("#dz_t_comment_file").html("");
				$("#addticketcomment-modal").modal();	
			}

			function add_t_comment_action () // 06-01-16
			{
				var ticket_id = $("#ticket_id").val();
				
				var d = new Date();
				var curr_date = d.getDate();
				var curr_month = d.getMonth() + 1;
				var curr_year = d.getFullYear();
				var curr_hour = d.getHours();
				var curr_minute = d.getMinutes();
				var curr_second = d.getSeconds();	
				var time_now = (curr_year + "-" + curr_month + "-" + curr_date + " " + curr_hour + ":" + curr_minute + ":" + curr_second);

				$("#addticketcomment_loader").show();
				$("#addticketcomment_loader").fadeIn(400).html("Sending...");
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('ticket/add_comment'); ?>/" + ticket_id,
					data: $("#ticket_comment_form").serialize(),
					cache: false,
					success: function(result){
						$("#addticketcomment_loader").hide();
						$("#ticket_actions_history").append("<tr><td>Added Comment</td><td></td><td>" + time_now + "</td></tr>");
						$("#addticketcomment-modal").modal("hide");
						$("#ticket-modal").modal("hide");
					}
				});
			}			

			jQuery(document).ready(function() {
				// $(document).find("#dz_t_comment_file").dropzone({
				// 	url: '<?php echo site_url('ticket/upload_file'); ?>',
				// 	success: function (file, response) {
				// 		$("#t_uploaded_comment_files").append('<input type="hidden" name="t_uploaded_comment_file[]" value="'+response+'">');
				// 	}
				// });
			});
		</script>
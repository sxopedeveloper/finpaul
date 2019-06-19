<!-- Vendor -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.2/jquery.js"></script> 
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>-->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

<script src="<?php echo base_url('assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js'); ?>?v=<?php echo time();?>"></script>
<script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.js'); ?>?v=<?php echo time();?>"></script>
<script src="<?php echo base_url('assets/vendor/nanoscroller/nanoscroller.js'); ?>?v=<?php echo time();?>"></script>
<script src="<?php echo base_url('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js'); ?>?v=<?php echo time();?>"></script>
<script src="<?php echo base_url('assets/vendor/magnific-popup/magnific-popup.js'); ?>?v=<?php echo time();?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery-placeholder/jquery.placeholder.js'); ?>?v=<?php echo time();?>"></script>
<script src="<?php echo base_url('assets/vendor/pnotify/pnotify.custom.js'); ?>?v=<?php echo time();?>"></script> 

<script src="<?php echo base_url('assets/vendor/autosize/autosize.js'); ?>?v=<?php echo time();?>"></script> 


<!-- Calendar -->
<script src="<?php echo base_url('assets/vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js'); ?>?v=<?php echo time();?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js'); ?>?v=<?php echo time();?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.js?v=<?php echo time();?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.0/fullcalendar.min.js?v=<?php echo time();?>"></script>

<!-- Data Table -->
<script src="<?php echo base_url('assets/vendor/select2/select2.js'); ?>?v=<?php echo time();?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery-datatables/media/js/jquery.dataTables.js'); ?>?v=<?php echo time();?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js'); ?>?v=<?php echo time();?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery-datatables-bs3/assets/js/datatables.js'); ?>?v=<?php echo time();?>"></script>

<!-- Sweet Alert -->
<script src="<?php echo base_url('assets/vendor/sweetalert/sweetalert.min.js'); ?>?v=<?php echo time();?>"></script>	

<!-- Carousel -->
<script src="<?php echo base_url('assets/vendor/owl-carousel/owl.carousel.js'); ?>?v=<?php echo time();?>"></script>

<!-- Tags -->
<script src="<?php echo base_url('assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js'); ?>?v=<?php echo time();?>"></script>

<!-- Fixed Columns -->
<script src="<?php echo base_url('assets/vendor/jquery-datatables/extensions/FixedColumns/js/dataTables.fixedColumns.js'); ?>?v=<?php echo time();?>"></script>

<!-- Switch IO7 -->
<script src="<?php echo base_url('assets/vendor/ios7-switch/ios7-switch.js'); ?>?v=<?php echo time();?>"></script>

<!-- Timepicker -->
<script src="<?php echo base_url('assets/vendor/bootstrap-timepicker/js/bootstrap-timepicker.min.js'); ?>?v=<?php echo time();?>"></script>

<!-- Color Picker -->
<script src="<?php echo base_url('assets/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js'); ?>?v=<?php echo time();?>"></script>

<!-- HTML Editor -->
<script src="<?php echo base_url('assets/vendor/summernote/summernote.js'); ?>?v=<?php echo time();?>"></script>		

<!-- Dashboard -->
<script src="<?php echo base_url('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js'); ?>?v=<?php echo time();?>"></script>
<script src="<?php echo base_url('assets/vendor/raphael/raphael.js'); ?>?v=<?php echo time();?>"></script>
<script src="<?php echo base_url('assets/vendor/morris/morris.js'); ?>?v=<?php echo time();?>"></script>

<!-- JQuery Mask -->
<script src="<?php echo base_url('assets/vendor/jquery-mask/jquery.mask.js'); ?>?v=<?php echo time();?>"></script>

<!-- Dropzone Uploader -->
<script src="<?php echo base_url('assets/js/image_uploader/dropzone.js'); ?>?v=<?php echo time();?>"></script>
<script type="text/javascript">
	Dropzone.autoDiscover = false;
</script>

<!-- Wizard -->
<script src="<?php echo base_url('assets/vendor/bootstrap-wizard/jquery.bootstrap.wizard.js'); ?>?v=<?php echo time();?>"></script>	
<script src="<?php echo base_url('assets/vendor/jquery-validation/jquery.validate.js'); ?>?v=<?php echo time();?>"></script>

<!-- Canvas -->
<script src="<?php echo base_url('assets/vendor/html2canvas/html2canvas.js'); ?>?v=<?php echo time();?>"></script>

<!-- Theme Base, Components and Settings -->
<script src="<?php echo base_url('assets/js/theme.js'); ?>?v=<?php echo time();?>"></script>

<!-- Theme Custom -->
<script src="<?php echo base_url('assets/js/theme.custom.js'); ?>?v=<?php echo time();?>"></script>

<!-- Theme Initialization Files -->
<script src="<?php echo base_url('assets/js/theme.init.js'); ?>?v=<?php echo time();?>"></script>

<!-- Ck-Editor -->
<script src="<?php echo base_url('assets/js/ckeditor/ckeditor.js');?>?v=<?php echo time();?>"></script>
<script src="<?php echo base_url('assets/js/ckeditor/adapters/jquery.js');?>?v=<?php echo time();?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('textarea.ckeditor').ckeditor({
            allowedContent:true
        });
        $('textarea.edit_template_content').ckeditor({ 
            height: 300,
            allowedContent:true
        });
        $('textarea.send_email_template_content').ckeditor({ 
            height: 300,
            allowedContent:true
        });
        $('textarea.email_client_template').ckeditor({ 
            height: 300,
            allowedContent:true
        });
        /*$('textarea.email_dealer_template').ckeditor({ 
            height: 300,
            allowedContent:true
        });*/
		CKEDITOR.config.protectedSource.push( /<\?[\s\S]*?\?>/g );

		/*var writer = editor.dataProcessor.writer;

			// The character sequence to use for every indentation step.
			writer.indentationChars = '\t';

			// The way to close self closing tags, like <br />.
			writer.selfClosingEnd = ' />';

			// The character sequence to be used for line breaks.
			writer.lineBreakChars = '\n';

			// The writing rules for the <p> tag.
			writer.setRules( 'p',
			{
				// Indicates that this tag causes indentation on line breaks inside of it.
				indent : true,

				// Inserts a line break before the <p> opening tag.
				breakBeforeOpen : true,

				// Inserts a line break after the <p> opening tag.
				breakAfterOpen : true,

				// Inserts a line break before the </p> closing tag.
				breakBeforeClose : false,

				// Inserts a line break after the </p> closing tag.
				breakAfterClose : true
			});	*/		
	});
</script>
<?php
if (!isset($login_type))
{
	$login_type = "";
}

if ($login_type=="Admin")
{
?>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		reload_notifications();
		$(document).on("click","#my-paging a",function(event){
			event.preventDefault();
			var url = $(this).attr('href');

			$.ajax({
				type: "GET",
				url: url,
				//data: $("#search_form").serialize(),
				cache: false,
				success: function(response){
					//console.log(response);
					$('#assign').html(response);

				}
			});	
			return false;
		});
		$(".tender_alert").click(function(e) {
			var tender_id = $(this).data('tender_id');
			var data = {
				tender_id: tender_id
			};

			$.ajax({
				type: "POST",
				url: "<?php echo site_url("admin_main/get_tender_alert_details"); ?>",
				cache: false,
				data: data,
				success: function(response){
					$("#tender_alert_modal").find("#tender_alert_details").html(response);
					$("#tender_alert_modal").modal();
				}
			});	

			$("#tender_alert_modal").modal();
		});							

		$(document).find(".dz_al_comment_file").dropzone({
			url: '<?php echo site_url('lead/upload_file'); ?>',
			success: function (file, response) {
				$("#al_uploaded_comment_files").append('<input type="hidden" name="al_uploaded_comment_file[]" value="'+response+'">');
			}
		});

		$(document).find(".dz_fa_comment_file").dropzone({
			url: '<?php echo site_url('fapplication/upload_file'); ?>',
			success: function (file, response) {
				$("#fa_uploaded_comment_files").append('<input type="hidden" name="fa_uploaded_comment_file[]" value="'+response+'">');
			}
		});

		$(document).find(".dz_t_comment_file").dropzone({
			url: '<?php echo site_url('ticket/upload_file'); ?>',
			success: function (file, response) {
				$("#t_uploaded_comment_files").append('<input type="hidden" name="t_uploaded_comment_file[]" value="'+response+'">');
			}
		});

		$(document).on("click", ".open-ticket", function(data){
			var ticket_id = $(this).data("ticket_id");
			$.post("<?php echo site_url("ticket/record"); ?>/" + ticket_id, function(data)
				   {
				$("#ticket_id").val(data.id_ticket);
				$("#ticket_status_id").val(data.id_ticket_status);
				$("#ticket_status").html(data.ticket_status);
				$("#ticket_priority").html(data.ticket_priority);
				$("#ticket_type").html(data.ticket_type);
				$("#ticket_module").html(data.ticket_module);
				$("#toc").html(data.toc);
				$("#assignment_date").html(data.assignment_date);					
				$("#ticket_number").html(data.ticket_number);
				$("#ticket_name").html(data.name);
				$("#ticket_description").html(data.description);
				$("#ticket_comments").html(data.ticket_comments);
				$("#ticket_actions").html(data.ticket_actions);
				$("#ticket_tbody_ass_to").html(data.assigned_table);
				$("#ticket-modal").modal();
			}, "json");
		});

		$(document).on("click", ".open-edittoc", function(data){
			var ticket_id = $(this).data("ticket_id");
			$("#edittoc-modal").modal();
		});

		$(document).on("click", ".edit-ticket", function(){
			var ticket_id = $(this).data("ticket_id");	

			$("#hidden_edit_ticket_id").val(ticket_id);
			$("#ticket_edit_user_id_to").val([]).trigger("change");
			$("#ticket_edit_ticket_type").val("");
			$("#ticket_edit_priority").val("");
			$("#ticket_edit_module").val("");
			$("#ticket_edit_name").val("");
			$("#ticket_edit_assignment_date").val("");
			$("#ticket_edit_description").val("");

			var data = {
				ticket_id: ticket_id
			}

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

		$(document).on("click", ".ticket_submit_edit", function(){
			var form 			= $("#edit_form").serialize();
			var ticket_type     = $("#ticket_edit_ticket_type").val();
			var priority        = $("#ticket_edit_priority").val();
			var module          = $("#ticket_edit_module").val();
			var name            = $("#ticket_edit_name").val();
			var assignment_date = $("#ticket_edit_assignment_date").val();
			var assigned_to     = $("#ticket_edit_user_id_to").val();

			var ticket_id = $("#hidden_edit_ticket_id").val();

			if (ticket_type == "")
			{
				alert("Please choose a Ticket Type!");
				return false;
			}

			if (priority == "")
			{
				alert("Please choose a priority!");
				return false;
			}

			if (module == "")
			{
				alert("Please choose a module!");
				return false;
			}

			if (name == "")
			{
				alert("Subject cannot be blank!");
				return false;
			}

			if (assignment_date == "")
			{
				alert("Schedule start date cannot be blank!");
				return false;
			}

			if (assigned_to == null)
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
					$(this_row).find(".ticket_priority").text($("#ticket_edit_priority option:selected").text());
					$(this_row).find(".ticket_type").text($("#ticket_edit_ticket_type option:selected").text());
					$(this_row).find(".ticket_module").text($("#ticket_edit_module option:selected").text());
					$(this_row).find(".ticket_name").text(name);
					$(this_row).find(".ticket_start_date").text(assignment_date);
					$("#edit_ticket_modal").modal("hide");
				}
			});
		});
	});		

	function addmsg (type, msg)
	{
		$('#notification_count').html(msg);
		$('#notification_count_label').html(msg);
	}

	function reload_notifications () 
	{
		$.ajax({
			type: "GET",
			url: '<?= site_url("admin/get_notifications_count"); ?>',
			async: true,
			cache: false,
			timeout: 600000,
			success: function(data){
				addmsg("new", data);
				setTimeout(reload_notifications, 120000);
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
				addmsg("error", textStatus + " (" + errorThrown + ")");
				setTimeout(reload_notifications, 120000);
			}
		});
	};

	function get_notifications ()
	{
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('admin/get_notifications_content'); ?>",
			cache: false,
			success: function(result){
				$("#ticket_notifications_content").html(result);
			}
		});				
	}			

	function add_t_comment_modal ()
	{
		var ticket_id = $("#ticket_id").val();
		$("#addticketcomment-modal").find("#ticket_comment").val("");
		$("#addticketcomment-modal").find("#t_uploaded_comment_files").html("");
		$("#addticketcomment-modal").find("#dz_t_comment_file").html("");
		$("#addticketcomment-modal").modal();	
	}

	function add_t_comment_action ()
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
					$("#ticket_status_" + ticket_id).html("Closed");
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
					$("#ticket_status_" + ticket_id).html("Open");
					$("#ticket_comment").val("");
					$("#ticket-modal").modal("hide");
				}
			});
		}
	}

	function delete_ticket ()
	{
		if (confirm("Are you sure you want to delete this ticket?")) 
		{
			var ticket_id = $("#ticket_id").val();
			var dataString = "&ticket_id="+ticket_id;
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("ticket/delete"); ?>",
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
</script>
<?php
}
else if ($login_type == 1)
{
?>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		reload_notifications();
	});		

	function addmsg (type, cart_item_count, new_order_count) 
	{
		$('#cart_item_count').html(cart_item_count);
		$('#new_order_count').html(new_order_count);
	}

	function reload_notifications () 
	{
		$.ajax({
			type: "GET",
			url: "<?php echo site_url('user/get_notifications'); ?>",
			async: true,
			cache: false,
			dataType: "json",
			timeout: 500000,
			success: function(data){
				addmsg("new", data.cart_item_count, data.new_order_count);
				setTimeout(reload_notifications, 300000);
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
				addmsg("error", "", "");
				setTimeout(reload_notifications, 300000);
			}
		});
	};
</script>
<?php			
}
else if ($login_type == 3)
{

}
else
{

}
?>

<script type="text/javascript" charset="utf-8">		
	$("#checkAll").change(function(){
		$("input:checkbox").prop("checked", $(this).prop("checked"));
	});

	$(document).on("click", ".datepicker", function(){
		//$(this).toggleClass("clicked").datepicker().datepicker("show");
	});

	$(document).on("click", ".timepicker", function(){
		//$(this).toggleClass("clicked").timepicker().timepicker("show");
	});			

	$("#add_quote_modal").find("#demo").change(function(e){
		check_existing_quote("add_quote_modal");
	});

	function quote_modal_button(){
		//alert();
		var name = $("#name").val();
		//alert(name);
		var email = $("#email").val();
		//var name = $("#client_details_form").find("#name").val();
		//var name = $("#client_details_form").find("#name").val();
		var email = $("#client_details_form").find("#email").val();
		//console.log($(this).data());
		var id_lead = $("#id_lead").val();

		var id_quote_request = $("#id_quote_request").val();
		var id_quote = $("#id_quote").val();
		var demo = $(this).data("demo");
		// alert(id_quote_request);
		// alert(id_quote);
		// alert(demo);

		var process = $(this).data("process");
		//alert(process);
		if (name == "" || name == 0 || typeof(name) == "undefined")
		{
			$("#add_quote_form").find("#label_name").html("Quote Form");
			$("#add_quote_form").find("#label_email").html(demo+" Vehicle");
			$("#add_quote_form").find("#quote_form_demo_container").prop("hidden", true);
		}
		else
		{
			$("#add_quote_form").find("#label_name").html(name);
			$("#add_quote_form").find("#label_email").html(email);				
		}

		if (process == "" || process == 0 || typeof(process) == "undefined")
		{
			if (id_quote == "" || id_quote == 0 || typeof(id_quote) == "undefined")
			{				
				var process = "insert";
			}
			else
			{
				var process = "update";
			}					
		}
		else
		{
			var process = "view";
		}

		var data = {
			id_lead: id_lead,
			id_quote_request: id_quote_request,
			id_quote: id_quote
		};

		$.ajax({
			type: "POST",
			url: "<?php echo site_url("user/generate_tender_details_json"); ?>",
			data: data,
			cache: false,
			dataType: "json",
			success: function(response){

				//console.log(response);
				$("#add_quote_form").find("#client_state").val(response.state);
				$("#add_quote_form").find("#tradein_count").val(response.tradein_count);	
				$("#add_quote_form").find("#registration_type").val(response.registration_type);

				$("#add_quote_form").find("#registration_type_label").html(response.registration_type);
				$("#add_quote_form").find("#vehicle_label").html(response.build_date+" "+response.make+" "+response.model+" "+response.variant+" ("+response.colour+")");

				$("#add_quote_form").find("#options_content").html(response.options_html);
				$("#add_quote_form").find("#accessories_content").html(response.accessories_html);	

				if (response.registration_type=="TPI/Gold Card" || response.registration_type=="Exempt")
				{
					$("#add_quote_form").find("#stamp_duty").val("0.00");
					$("#add_quote_form").find("#stamp_duty").prop("readonly", true);
				}
				else
				{
					$("#add_quote_form").find("#stamp_duty").prop("readonly", false);
				}

				if (process == "view")
				{
					populate_quote_form(id_quote, "#add_quote_form");

					$("#add_quote_form").find("input,textarea,select").prop("disabled", true);
					$("#add_quote_form").find("#add_quote_submit_button").hide();
				}						
				else if (process == "update")
				{
					populate_quote_form(id_quote, "#add_quote_form");
				}
				else if (process == "insert")
				{
					<?php
					if ($login_type == "Admin")
					{
					?>					
					clear_quote_form(demo, "#add_quote_form");
					<?php
					}
					else if ($login_type == 1)
					{
					?>							
					clear_quote_form(demo, "#add_quote_form");								
					<?php								
					}
					?>
				}
			}
		});

		if (process == "update")
		{
			$("#add_quote_modal").find("#add_quote_submit_button").prop("disabled", false);
			$("#add_quote_modal").find("#quote_form_dealer_selector_container").prop("hidden", true);
			$("#add_quote_modal").find("#quote_form_warning_container").prop("hidden", true);
			$("#add_quote_modal").find("#quote_form_container").prop("hidden", false);
			$("#add_quote_modal").find("#add_quote_submit_button").prop("disabled", false);
		}
		else if (process == "insert")
		{
			$("#add_quote_modal").find("#quote_form_dealer_selector_container").prop("hidden", false);
			$("#add_quote_modal").find("#quote_form_warning_container").prop("hidden", true);
			$("#add_quote_modal").find("#quote_form_container").prop("hidden", true);				
			$("#add_quote_modal").find("#add_quote_submit_button").prop("disabled", true);							
		}
		else if (process == "update")
		{

		}

		<?php
		if ($login_type == "Admin")
		{
		?>
		if (process == "insert")
		{					
			$("#add_quote_modal").find("#quote_form_dealer_selector_container").prop("hidden", false);
			$("#add_quote_modal").find("#quote_form_warning_container").prop("hidden", true);
			$("#add_quote_modal").find("#quote_form_container").prop("hidden", true);				
			$("#add_quote_modal").find("#add_quote_submit_button").prop("disabled", true);											

			load_dealer_selector_parameters("add_quote_modal", id_lead, "quote_request");
		}
		else
		{
			$("#add_quote_modal").find("#quote_form_dealer_selector_container").prop("hidden", true);
			$("#add_quote_modal").find("#quote_form_warning_container").prop("hidden", true);
			$("#add_quote_modal").find("#quote_form_container").prop("hidden", false);
			$("#add_quote_modal").find("#add_quote_submit_button").prop("disabled", false);						
		}
		<?php
		}
		else if ($login_type == 1)
		{
		?>
		$("#add_quote_modal").find("#quote_form_dealer_selector_container").prop("hidden", true);
		$("#add_quote_modal").find("#quote_form_warning_container").prop("hidden", true);
		$("#add_quote_modal").find("#quote_form_container").prop("hidden", false);
		$("#add_quote_modal").find("#add_quote_submit_button").prop("disabled", false);					
		<?php
		}	
		?>				

		$("#add_quote_modal").find("#process").val(process);
		$("#add_quote_modal").find("#id_lead").val(id_lead);
		$("#add_quote_modal").find("#id_quote_request").val(id_quote_request);

		if (process == "update")				
		{	
			$("#add_quote_modal").find("#id_quote").val(id_quote);
		}

		$("#add_quote_modal").modal();
	}

	// $(".quote_modal_button").click(function(e){
	// //alert();
	// var name = $("#client_details_form").find("#name").val();
	// var email = $("#client_details_form").find("#email").val();

	// var id_lead = $(this).data("id_lead");
	// var id_quote_request = $(this).data("id_quote_request");
	// var id_quote = $(this).data("id_quote");
	// var demo = $(this).data("demo");

	// var process = $(this).data("process");

	// if (name == "" || name == 0 || typeof(name) == "undefined")
	// {
	// $("#add_quote_form").find("#label_name").html("Quote Form");
	// $("#add_quote_form").find("#label_email").html(demo+" Vehicle");
	// $("#add_quote_form").find("#quote_form_demo_container").prop("hidden", true);
	// }
	// else
	// {
	// $("#add_quote_form").find("#label_name").html(name);
	// $("#add_quote_form").find("#label_email").html(email);				
	// }

	// if (process == "" || process == 0 || typeof(process) == "undefined")
	// {
	// if (id_quote == "" || id_quote == 0 || typeof(id_quote) == "undefined")
	// {				
	// var process = "insert";
	// }
	// else
	// {
	// var process = "update";
	// }					
	// }
	// else
	// {
	// var process = "view";
	// }

	// var data = {
	// id_lead: id_lead,
	// id_quote_request: id_quote_request,
	// id_quote: id_quote
	// };

	// $.ajax({
	// type: "POST",
	// url: "<?php echo site_url("user/generate_tender_details_json"); ?>",
	// data: data,
	// cache: false,
	// dataType: "json",
	// success: function(response){
	// console.log(response);
	// $("#add_quote_form").find("#client_state").val(response.state);
	// $("#add_quote_form").find("#tradein_count").val(response.tradein_count);	
	// $("#add_quote_form").find("#registration_type").val(response.registration_type);

	// $("#add_quote_form").find("#registration_type_label").html(response.registration_type);
	// $("#add_quote_form").find("#vehicle_label").html(response.build_date+" "+response.make+" "+response.model+" "+response.variant+" ("+response.colour+")");

	// $("#add_quote_form").find("#options_content").html(response.options_html);
	// $("#add_quote_form").find("#accessories_content").html(response.accessories_html);	

	// if (response.registration_type=="TPI/Gold Card" || response.registration_type=="Exempt")
	// {
	// $("#add_quote_form").find("#stamp_duty").val("0.00");
	// $("#add_quote_form").find("#stamp_duty").prop("readonly", true);
	// }
	// else
	// {
	// $("#add_quote_form").find("#stamp_duty").prop("readonly", false);
	// }

	// if (process == "view")
	// {
	// populate_quote_form(id_quote, "#add_quote_form");

	// $("#add_quote_form").find("input,textarea,select").prop("disabled", true);
	// $("#add_quote_form").find("#add_quote_submit_button").hide();
	// }						
	// else if (process == "update")
	// {
	// populate_quote_form(id_quote, "#add_quote_form");
	// }
	// else if (process == "insert")
	// {
	// <?php
	// if ($login_type == "Admin")
	// {
	// ?>					
	// clear_quote_form(demo, "#add_quote_form");
	// <?php
	// }
	// else if ($login_type == 1)
	// {
	// ?>							
	// clear_quote_form(demo, "#add_quote_form");								
	// <?php								
	// }
	// ?>
	// }
	// }
	// });

	// if (process == "update")
	// {
	// $("#add_quote_modal").find("#add_quote_submit_button").prop("disabled", false);
	// $("#add_quote_modal").find("#quote_form_dealer_selector_container").prop("hidden", true);
	// $("#add_quote_modal").find("#quote_form_warning_container").prop("hidden", true);
	// $("#add_quote_modal").find("#quote_form_container").prop("hidden", false);
	// $("#add_quote_modal").find("#add_quote_submit_button").prop("disabled", false);
	// }
	// else if (process == "insert")
	// {
	// $("#add_quote_modal").find("#quote_form_dealer_selector_container").prop("hidden", false);
	// $("#add_quote_modal").find("#quote_form_warning_container").prop("hidden", true);
	// $("#add_quote_modal").find("#quote_form_container").prop("hidden", true);				
	// $("#add_quote_modal").find("#add_quote_submit_button").prop("disabled", true);							
	// }
	// else if (process == "update")
	// {

	// }

	// <?php
	// if ($login_type == "Admin")
	// {
	// ?>
	// if (process == "insert")
	// {					
	// $("#add_quote_modal").find("#quote_form_dealer_selector_container").prop("hidden", false);
	// $("#add_quote_modal").find("#quote_form_warning_container").prop("hidden", true);
	// $("#add_quote_modal").find("#quote_form_container").prop("hidden", true);				
	// $("#add_quote_modal").find("#add_quote_submit_button").prop("disabled", true);											

	// load_dealer_selector_parameters("add_quote_modal", id_lead, "quote_request");
	// }
	// else
	// {
	// $("#add_quote_modal").find("#quote_form_dealer_selector_container").prop("hidden", true);
	// $("#add_quote_modal").find("#quote_form_warning_container").prop("hidden", true);
	// $("#add_quote_modal").find("#quote_form_container").prop("hidden", false);
	// $("#add_quote_modal").find("#add_quote_submit_button").prop("disabled", false);						
	// }
	// <?php
	// }
	// else if ($login_type == 1)
	// {
	// ?>
	// $("#add_quote_modal").find("#quote_form_dealer_selector_container").prop("hidden", true);
	// $("#add_quote_modal").find("#quote_form_warning_container").prop("hidden", true);
	// $("#add_quote_modal").find("#quote_form_container").prop("hidden", false);
	// $("#add_quote_modal").find("#add_quote_submit_button").prop("disabled", false);					
	// <?php
	// }	
	// ?>				

	// $("#add_quote_modal").find("#process").val(process);
	// $("#add_quote_modal").find("#id_lead").val(id_lead);
	// $("#add_quote_modal").find("#id_quote_request").val(id_quote_request);

	// if (process == "update")				
	// {	
	// $("#add_quote_modal").find("#id_quote").val(id_quote);
	// }

	// $("#add_quote_modal").modal();
	// });			

	/*------Commented by - RJ - Start 27-4-18 --------*/ 
	/*$("#add_quote_form").submit(function(e) {

				$("#add_quote_form").find("#demo").prop("disabled", false);

				$.ajax({
					type: "POST",
					url: "<?php //echo site_url("user/send_quote"); ?>",
					data: $("#add_quote_form").serialize(),
					cache: false,
					success: function(response){
						if (response === "success")
						{
							$("#add_quote_modal").find("input,textarea,select").val("");
							$("#add_quote_modal").modal("hide");

							swal("SUCCESS", "", "success");
							location.reload(true);
						}
						else
						{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});
				e.preventDefault();
			});*/
	/*------Commented by - RJ - End --------*/ 

	function populate_quote_form (id_quote, container)
	{
		var data = {
			id_quote: id_quote
		};				

		$.ajax({
			type: "POST",
			url: "<?php echo site_url("user/generate_quote_json"); ?>",
			data: data,
			cache: false,
			dataType: "json",
			success: function(response){	
				$(container).find("#demo").val(response.demo);
				$(container).find("#demo").prop("disabled", true);

				$(container).find("#delivery_date").val(response.delivery_date);
				$(container).find("#compliance_date").val(response.compliance_date);

				$(container).find("#vin").val(response.vin);
				$(container).find("#engine").val(response.engine);
				$(container).find("#registration_plate").val(response.registration_plate);
				$(container).find("#registration_expiry").val(response.registration_expiry);
				$(container).find("#kms").val(response.kms);
				$(container).find("#notes").val(response.notes);

				$(container).find("#retail_price").val(response.retail_price);
				$(container).find("#metallic_paint").val(response.metallic_paint);
				$(container).find("#predelivery").val(response.predelivery);
				$(container).find("#fleet_discount").val(response.fleet_discount);
				$(container).find("#dealer_discount").val(response.dealer_discount);

				$(container).find("#luxury_tax").val(response.luxury_tax);
				$(container).find("#ctp").val(response.ctp);
				$(container).find("#registration").val(response.registration);
				$(container).find("#premium_plate_fee").val(response.premium_plate_fee);
				$(container).find("#stamp_duty").val(response.stamp_duty);

				$(container).find("#dealer_tradein_value").val(response.dealer_tradein_value);
				$(container).find("#dealer_tradein_payout").val(response.dealer_tradein_payout);
				$(container).find("#dealer_client_refund").val(response.dealer_client_refund);

				$(container).find("#transport_checkbox").val(response.transport_checkbox);

				jQuery.each(response.options, function(index, value){
					$(container).find("#option_"+index).val(value.price);
				});

				jQuery.each(response.accessories, function(index, value){
					$(container).find("#accessory_"+index).val(value.price);
				});

				calculate_quote_new(container);
			}
		});				
	}

	function clear_quote_form (demo, container)
	{
		if (typeof(demo) != "undefined")
		{
			$(container).find("#demo").val(demo);
			$(container).find("#demo").prop("disabled", true);
		}
		else
		{
			$(container).find("#demo").val("")
			$(container).find("#demo").prop("disabled", false);
		}

		$(container).find("#delivery_date").val("");
		$(container).find("#compliance_date").val("");

		$(container).find("#vin").val("");
		$(container).find("#engine").val("");
		$(container).find("#registration_plate").val("");
		$(container).find("#registration_expiry").val("");
		$(container).find("#kms").val(0);
		$(container).find("#notes").val("");

		$(container).find("#retail_price").val(0);
		$(container).find("#metallic_paint").val(0);
		$(container).find("#predelivery").val(0);
		$(container).find("#fleet_discount").val(0);
		$(container).find("#dealer_discount").val(0);

		$(container).find("#luxury_tax").val(0);
		$(container).find("#ctp").val(0);
		$(container).find("#registration").val(0);
		$(container).find("#premium_plate_fee").val(0);
		$(container).find("#stamp_duty").val(0);

		$(container).find("#dealer_tradein_value").val(0);
		$(container).find("#dealer_tradein_payout").val(0);
		$(container).find("#dealer_client_refund").val(0);

		$(container).find("#transport_checkbox").val();

		$(container).find("#option_0").val(0);
		$(container).find("#option_1").val(0);
		$(container).find("#option_2").val(0);
		$(container).find("#option_3").val(0);
		$(container).find("#option_4").val(0);
		$(container).find("#option_5").val(0);
		$(container).find("#option_6").val(0);
		$(container).find("#option_7").val(0);
		$(container).find("#option_8").val(0);

		$(container).find("#accessory_0").val(0);
		$(container).find("#accessory_1").val(0);
		$(container).find("#accessory_2").val(0);
		$(container).find("#accessory_3").val(0);
		$(container).find("#accessory_4").val(0);
		$(container).find("#accessory_5").val(0);
		$(container).find("#accessory_6").val(0);
		$(container).find("#accessory_7").val(0);
		$(container).find("#accessory_8").val(0);

		$(container).find("#subtotal_1").val(0);
		$(container).find("#subtotal_2").val(0);
		$(container).find("#subtotal_3").val(0);
		$(container).find("#gst").val(0);
		$(container).find("#total").val(0);
		$(container).find("#dealer_changeover").val(0);
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

	function isNumberKey (evt)
	{
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) { return false; } else { return true; }
	}

	function replaceAll (str, find, replace) 
	{
		return str.replace(new RegExp(find, 'g'), replace);
	}

	function pad (n, width, z) 
	{
		z = z || '0';
		n = n + '';
		return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
	}

	function getPosition (str, m, i) 
	{
		return str.split(m, i).join(m).length;
	}		


	function search_fil()
	{

		$.ajax({
			type: "GET",
			url: "<?php echo site_url("account/dealersfloat"); ?>",
			data: $("#search_form").serialize(),
			cache: false,
			success: function(response){
				//console.log(response);
				$('#assign').html(response);

			}
		});	
	}

	function qsearch()
	{

		$.ajax({
			type: "GET",
			url: "<?php echo site_url("quote/search"); ?>",
			data: $("#searchquote").serialize(),
			cache: false,
			success: function(response){
				//console.log(response);
				setTimeout(function(){ 

					$('#quoteserch').DataTable({
						'paging'      : true,
						'lengthChange': false,
						'searching'   : false,
						'ordering'    : true,
						'info'        : true,
						'autoWidth'   : false
					})

				}, 1500);



				$('#map_lead_modal').modal();


				$('#quotesearch').html(response);



			}
		});	
	}

	function deletequote(){

		var id_quote =$("#quoteid").val();
		alert(id_quote);
		var data ={id_quote:id_quote};
		$.ajax({
			type: "POST",
			url: "<?php echo site_url("quote/delete"); ?>",
			data: data,
			cache: false,
			success: function(response){
				//console.log(response);


				$( ".open_lead_assign" ).trigger( "click" );

			}
		});	



	}

	// $(".quote_modal_button").click(function(e){
	// alert();
	// var name = $("#name").val();
	// //alert(name);
	// var email = $("#email").val();
	// //var name = $("#client_details_form").find("#name").val();
	// //var name = $("#client_details_form").find("#name").val();
	// var email = $("#client_details_form").find("#email").val();

	// var id_lead = $(this).data("id_lead");

	// var id_quote_request = $(this).data("id_quote_request");
	// var id_quote = $(this).data("id_quote");
	// var demo = $(this).data("demo");

	// var process = $(this).data("process");

	// if (name == "" || name == 0 || typeof(name) == "undefined")
	// {
	// $("#add_quote_form").find("#label_name").html("Quote Form");
	// $("#add_quote_form").find("#label_email").html(demo+" Vehicle");
	// $("#add_quote_form").find("#quote_form_demo_container").prop("hidden", true);
	// }
	// else
	// {
	// $("#add_quote_form").find("#label_name").html(name);
	// $("#add_quote_form").find("#label_email").html(email);				
	// }

	// if (process == "" || process == 0 || typeof(process) == "undefined")
	// {
	// if (id_quote == "" || id_quote == 0 || typeof(id_quote) == "undefined")
	// {				
	// var process = "insert";
	// }
	// else
	// {
	// var process = "update";
	// }					
	// }
	// else
	// {
	// var process = "view";
	// }

	// var data = {
	// id_lead: id_lead,
	// id_quote_request: id_quote_request,
	// id_quote: id_quote
	// };

	// $.ajax({
	// type: "POST",
	// url: "<?php echo site_url("user/generate_tender_details_json"); ?>",
	// data: data,
	// cache: false,
	// dataType: "json",
	// success: function(response){

	// console.log(response);
	// $("#add_quote_form").find("#client_state").val(response.state);
	// $("#add_quote_form").find("#tradein_count").val(response.tradein_count);	
	// $("#add_quote_form").find("#registration_type").val(response.registration_type);

	// $("#add_quote_form").find("#registration_type_label").html(response.registration_type);
	// $("#add_quote_form").find("#vehicle_label").html(response.build_date+" "+response.make+" "+response.model+" "+response.variant+" ("+response.colour+")");

	// $("#add_quote_form").find("#options_content").html(response.options_html);
	// $("#add_quote_form").find("#accessories_content").html(response.accessories_html);	

	// if (response.registration_type=="TPI/Gold Card" || response.registration_type=="Exempt")
	// {
	// $("#add_quote_form").find("#stamp_duty").val("0.00");
	// $("#add_quote_form").find("#stamp_duty").prop("readonly", true);
	// }
	// else
	// {
	// $("#add_quote_form").find("#stamp_duty").prop("readonly", false);
	// }

	// if (process == "view")
	// {
	// populate_quote_form(id_quote, "#add_quote_form");

	// $("#add_quote_form").find("input,textarea,select").prop("disabled", true);
	// $("#add_quote_form").find("#add_quote_submit_button").hide();
	// }						
	// else if (process == "update")
	// {
	// populate_quote_form(id_quote, "#add_quote_form");
	// }
	// else if (process == "insert")
	// {
	// <?php
	// if ($login_type == "Admin")
	// {
	// ?>					
	// clear_quote_form(demo, "#add_quote_form");
	// <?php
	// }
	// else if ($login_type == 1)
	// {
	// ?>							
	// clear_quote_form(demo, "#add_quote_form");								
	// <?php								
	// }
	// ?>
	// }
	// }
	// });

	// if (process == "update")
	// {
	// $("#add_quote_modal").find("#add_quote_submit_button").prop("disabled", false);
	// $("#add_quote_modal").find("#quote_form_dealer_selector_container").prop("hidden", true);
	// $("#add_quote_modal").find("#quote_form_warning_container").prop("hidden", true);
	// $("#add_quote_modal").find("#quote_form_container").prop("hidden", false);
	// $("#add_quote_modal").find("#add_quote_submit_button").prop("disabled", false);
	// }
	// else if (process == "insert")
	// {
	// $("#add_quote_modal").find("#quote_form_dealer_selector_container").prop("hidden", false);
	// $("#add_quote_modal").find("#quote_form_warning_container").prop("hidden", true);
	// $("#add_quote_modal").find("#quote_form_container").prop("hidden", true);				
	// $("#add_quote_modal").find("#add_quote_submit_button").prop("disabled", true);							
	// }
	// else if (process == "update")
	// {

	// }

	// <?php
	// if ($login_type == "Admin")
	// {
	// ?>
	// if (process == "insert")
	// {					
	// $("#add_quote_modal").find("#quote_form_dealer_selector_container").prop("hidden", false);
	// $("#add_quote_modal").find("#quote_form_warning_container").prop("hidden", true);
	// $("#add_quote_modal").find("#quote_form_container").prop("hidden", true);				
	// $("#add_quote_modal").find("#add_quote_submit_button").prop("disabled", true);											

	// load_dealer_selector_parameters("add_quote_modal", id_lead, "quote_request");
	// }
	// else
	// {
	// $("#add_quote_modal").find("#quote_form_dealer_selector_container").prop("hidden", true);
	// $("#add_quote_modal").find("#quote_form_warning_container").prop("hidden", true);
	// $("#add_quote_modal").find("#quote_form_container").prop("hidden", false);
	// $("#add_quote_modal").find("#add_quote_submit_button").prop("disabled", false);						
	// }
	// <?php
	// }
	// else if ($login_type == 1)
	// {
	// ?>
	// $("#add_quote_modal").find("#quote_form_dealer_selector_container").prop("hidden", true);
	// $("#add_quote_modal").find("#quote_form_warning_container").prop("hidden", true);
	// $("#add_quote_modal").find("#quote_form_container").prop("hidden", false);
	// $("#add_quote_modal").find("#add_quote_submit_button").prop("disabled", false);					
	// <?php
	// }	
	// ?>				

	// $("#add_quote_modal").find("#process").val(process);
	// $("#add_quote_modal").find("#id_lead").val(id_lead);
	// $("#add_quote_modal").find("#id_quote_request").val(id_quote_request);

	// if (process == "update")				
	// {	
	// $("#add_quote_modal").find("#id_quote").val(id_quote);
	// }

	// $("#add_quote_modal").modal();
	// });	



	/*function load_families (make_id)
			{
				$("#build_date_dropdown").html("<option name='build_date' value=''></option>");
				$("#build_date_dropdown").prop("disabled", true);
				$("#vehicle_dropdown").html("<option name='vehicle' value=''></option>");
				$("#vehicle_dropdown").prop("disabled", true);	

				if (make_id != "")
				{			
					var dataString = "&make_id="+make_id;
					$("#family_loader").show();
					$("#family_loader").fadeIn(400).html("Loading...");
					$.ajax({
						type: "POST",
						url: "<?php echo site_url('cars/load_families'); ?>",
						data: dataString,
						cache: false,
						success: function(result){
							$("#family_loader").hide();
							$("#family_dropdown").removeAttr("disabled");
							$("#family_dropdown").html("<option name='family' value=''></option>");
							$("#family_dropdown").append(result);
						}
					});
				}
			}*/

	function load_families (container, make_id, family_id)
	{	
		//alert()
		if(make_id != "")
		{
			if (family_id == 0 || typeof(family_id) == 'undefined')
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

	function load_vehicles (container, code, vehicle_id)
	{
		if(code != "")
		{
			if (vehicle_id == 0 || typeof(vehicle_id) == 'undefined') 
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
	
	function load_options (container, vehicle_id, quote_request_id)
	{
		if(vehicle_id != "" )
		{
			if (quote_request_id == 0 || typeof(quote_request_id) == 'undefined')
			{
				var data = {
					vehicle_id: vehicle_id
				};													
			}	
			else
			{
				var data = {
					vehicle_id: vehicle_id,
					quote_request_id: quote_request_id
				};				
			}

			$("#"+container).find("#options").html("");
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('cars/load_options'); ?>",
				cache: false,
				data: data,
				success: function(response){
					$("#"+container).find("#options").append(response);
				}
			});
		}
	}

	function load_build_datess (family_id)
	{
		$("#vehicle_dropdown").html("<option name='vehicle' value=''></option>");
		$("#vehicle_dropdown").prop("disabled", true);

		if (family_id != "")
		{
			var dataString = "&family_id="+family_id;
			$("#build_date_loader").show();
			$("#build_date_loader").fadeIn(400).html("Loading...");
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("cars/load_build_dates"); ?>",
				data: dataString,
				cache: false,
				success: function(result){
					$("#build_date_loader").hide();
					$("#build_date_dropdown").removeAttr("disabled");
					$("#build_date_dropdown").html("<option name='build_date' value=''></option>");
					$("#build_date_dropdown").append(result);
				}
			});				
		}
	}

	function load_vehicless (code)
	{
		if (code != "")
		{
			var dataString = "&code="+code;
			$("#vehicle_loader").show();
			$("#vehicle_loader").fadeIn(400).html("Loading...");
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("cars/load_vehicles"); ?>",
				data: dataString,
				cache: false,
				success: function(result){
					$("#vehicle_loader").hide();
					$("#vehicle_dropdown").removeAttr("disabled");
					$("#vehicle_dropdown").html("<option name='vehicle' value=''></option>");
					$("#vehicle_dropdown").append(result);
				}
			});				
		}
	}

</script>
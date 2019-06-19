<script>
var computation_changedFlag;
var save_btn_flag = 0;
	function save_fapplication_info_2 (button_flag = 0) // new
	{
        /*alert(tradeInform_changedFlag);
		alert(computation_changedFlag);*/
        if(tradeInform_changedFlag > 0){
            //alert('tradeInform_changedFlag < 0');
            swal("ERROR", "Please Save Trade In Details and try again !", "error");
            return false;
        }
	   
	
			if(computation_changedFlag > 0){
				swal("ERROR", "Please Save Computation Details and try again !", "error");
				return false;
			}
		
		

		$(document).find(".btn-save").prop("disabled", true);
		var fapplication_id        = $("#fapplication_id").val();
		var fapplication_status_id = $("#fapplication_status_id").val();
		var details                = $("#fapplication_details").val();
		var save_flag = "<?php if(isset($save_flag)) { echo $save_flag; }else{ echo "0";  } ?>";
		var d           = new Date();
		var curr_date   = d.getDate();
		var curr_month  = d.getMonth() + 1;
		var curr_year   = d.getFullYear();
		var curr_hour   = d.getHours();
		var curr_minute = d.getMinutes();
		var curr_second = d.getSeconds();	
		var time_now    = (curr_year + "-" + curr_month + "-" + curr_date + " " + curr_hour + ":" + curr_minute + ":" + curr_second);				
		if (fapplication_status_id <= 1)
		{
			$("#status_label_" + fapplication_id).css("color", "#cc3333");
			$("#status_label_" + fapplication_id).html('<span style="color: #cc3333 id="status_label_' + fapplication_id + '"><b>Attempted</b></span>');
			$("#ls_td_"+fapplication_id).html("Attempted");
			$("#ls_td_"+fapplication_id).css({"color": "#cc3333"});
		}				
		$("#updateapplicationdetails_loader").show();
		$("#updateapplicationdetails_loader").fadeIn(400).html('Sending...');

		$.ajax({
			type: "POST",
			url: "<?php echo site_url('fapplication/update_record'); ?>",
			data: $("#fapplication_main_form").serialize(),
			cache: false,
			dataType: 'json',
			success: function(result){
				$("#updateapplicationdetails_loader").hide();
				$("#fapplication_actions_history").append("<tr><td>Update</td><td></td><td>" + time_now + "</td></tr>");
				$(document).find(".btn-save").prop("disabled", false);
				if(button_flag == 1){
					$("#fapplication-modal-3").modal('hide');
					get_state(fapplication_id);
				}
                if(button_flag == 22){

					
					get_state(fapplication_id);
                    save_btn_flag = 1;
                    $("#computation_form").submit();
                    $("#delivery_submit").submit();
                    $("#details_form").submit();
                    
                    $.post("<?php echo site_url("fapplication/record"); ?>/" + fapplication_id, function(data) {
                        //console.log(data);
						
                        <?php $this->load->view('admin/js/full_calendar'); ?>
                        set_applicant_count_values();
                        set_car_data();
                        //historical_quotes_table.draw();
                    }, 'json');
                    
                    swal("SUCCESS", "", "success");
                    
				}
				if(save_flag == "1")
				{
					var event_arr = $('#calendar').fullCalendar('clientEvents', fapplication_id);
					var final_event = event_arr[0];
					final_event.title = result.title;
				
					$("#calendar").fullCalendar('updateEvent',final_event);
				}
			}
		});
	}
    
	function fapplication_called () // 06-01-16
	{
		var fapplication_id = $("#fapplication_id").val();
		var fapplication_status_id = $("#fapplication_status_id").val();
		var details = $("#fapplication_details").val();
		
		var d = new Date();
		var curr_date = d.getDate();
		var curr_month = d.getMonth() + 1;
		var curr_year = d.getFullYear();
		var curr_hour = d.getHours();
		var curr_minute = d.getMinutes();
		var curr_second = d.getSeconds();	
		var time_now = (curr_year + "-" + curr_month + "-" + curr_date + " " + curr_hour + ":" + curr_minute + ":" + curr_second);				
		if (fapplication_status_id <= 1)
		{
			$("#status_label_" + fapplication_id).css("color", "#cc3333");
			$("#status_label_" + fapplication_id).html('<span style="color: #cc3333 id="status_label_' + fapplication_id + '"><b>Attempted</b></span>');
			$("#ls_td_"+fapplication_id).html("Attempted");
			$("#ls_td_"+fapplication_id).css({"color": "#cc3333"});
		}
		$("#updateapplicationdetails_loader").show();
		$("#updateapplicationdetails_loader").fadeIn(400).html('Sending...');
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('fapplication/record_called'); ?>",
			data: $("#fapplication_main_form").serialize(),
			cache: false,
			success: function(result){
				$("#updateapplicationdetails_loader").hide();
				$("#fapplication_actions_history").append("<tr><td>Called the Client</td><td></td><td>" + time_now + "</td></tr>");
			}
		});
	}
    
	function delete_fapplication () // 06-01-16
	{
		if (confirm("Are you sure you want to delete this Lead?"))
		{
			var fapplication_id = $("#fapplication_id").val();
			var dataString = "&fapplication_id="+fapplication_id;
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('fapplication/delete_calendar'); ?>",
				data: dataString,
				cache: false,
				success: function(result){
					$("#calendar").fullCalendar("removeEvents",fapplication_id);
					$("#fapplication_details").val("");
					$("#fapplication-modal").modal("hide");
					$("#ls_td_"+fapplication_id).html("Deleted");
					$("#ls_td_"+fapplication_id).css({"color": "#cccccc"});							
				}
			});
		}
	}
    
	function add_fa_comment_modal () // 06-01-16
	{
		var fapplication_id = $("#fapplication_id").val();
		var fapplication_status_id = $("#fapplication_status_id").val();
		$("#addfapplicationcomment-modal").find("#fapplication_id_ac").val(fapplication_id);
		$("#addfapplicationcomment-modal").find("#fapplication_status_id_ac").val(fapplication_status_id);				
		$("#addfapplicationcomment-modal").find("#fapplication_comment").val("");
		$("#addfapplicationcomment-modal").find("#fa_uploaded_comment_files").html("");
		$("#addfapplicationcomment-modal").find("#dz_fa_comment_file").html("");
		$("#addfapplicationcomment-modal").modal();	
	}
    
	function add_fa_comment_action () // 06-01-16
	{
		var fapplication_id = $("#fapplication_id").val();
		var fapplication_status_id = $("#fapplication_status_id").val();
		
		var d = new Date();
		var curr_date = d.getDate();
		var curr_month = d.getMonth() + 1;
		var curr_year = d.getFullYear();
		var curr_hour = d.getHours();
		var curr_minute = d.getMinutes();
		var curr_second = d.getSeconds();	
		var time_now = (curr_year + "-" + curr_month + "-" + curr_date + " " + curr_hour + ":" + curr_minute + ":" + curr_second);
		
		if (fapplication_status_id <= 1)
		{
			$("#status_label_" + fapplication_id).css("color", "#cc3333");
			$("#status_label_" + fapplication_id).html('<span style="color: #cc3333 id="status_label_' + fapplication_id + '"><b>Attempted</b></span>');
			$("#ls_td_"+fapplication_id).html("Attempted");
			$("#ls_td_"+fapplication_id).css({"color": "#cc3333"});
		}
		
		$("#addfapplicationcomment_loader").show();
		$("#addfapplicationcomment_loader").fadeIn(400).html("Sending...");
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('fapplication/add_comment'); ?>/" + fapplication_id,
			data: $("#fapplication_comment_form").serialize(),
			cache: false,
			success: function(result){
				$("#addfapplicationcomment_loader").hide();
				$("#fapplication_actions_history").append("<tr><td>Added Comment</td><td></td><td>" + time_now + "</td></tr>");
				$("#addfapplicationcomment-modal").modal("hide");
				$("#fapplication-modal").modal("hide");     
			}
		});				
	}
			
    function calculate_revenue () {
        var membership = parseFloat(($("#computation_form").find("#membership").val() != '') ? $("#computation_form").find("#membership").val() : 0);
        //alert(membership);
        var membership_lower = parseFloat(($("#computation_form").find("#membership_lower").val() != '') ? $("#computation_form").find("#membership_lower").val() : 0);

        var dqp = parseFloat(($("#computation_form").find("#dqp").val() != '') ? $("#computation_form").find("#dqp").val() : 0);
        var tradein_count = parseFloat(($("#computation_form").find("#tradein_count").val() != '') ? $("#computation_form").find("#tradein_count").val() : 0);
        var dealer_tradein_count = parseFloat(($("#computation_form").find("#dealer_tradein_count").val() != '') ? $("#computation_form").find("#dealer_tradein_count").val() : 0);
        var dealer_tradein_value = parseFloat(($("#computation_form").find("#dealer_tradein_value").val() != '') ? $("#computation_form").find("#dealer_tradein_value").val() : 0);
        var dealer_tradein_payout = parseFloat(($("#computation_form").find("#dealer_tradein_payout").val() != '') ? $("#computation_form").find("#dealer_tradein_payout").val() : 0);
        var dealer_client_refund = parseFloat(($("#computation_form").find("#dealer_client_refund").val() != '') ? $("#computation_form").find("#dealer_client_refund").val() : 0);
        var dealer_changeover = parseFloat(($("#computation_form").find("#dealer_changeover").val() != '') ? $("#computation_form").find("#dealer_changeover").val() : 0);		

        var sales_price = parseFloat(($("#computation_form").find("#sales_price").val() != '') ? $("#computation_form").find("#sales_price").val() : 0);
        var tradein_value = parseFloat(($("#computation_form").find("#real_tradein_value").val() != '') ? $("#computation_form").find("#real_tradein_value").val() : 0);
        var tradein_given = parseFloat(($("#computation_form").find("#real_tradein_given").val() != '') ? $("#computation_form").find("#real_tradein_given").val() : 0);
        var tradein_payout = parseFloat(($("#computation_form").find("#real_tradein_payout").val() != '') ? $("#computation_form").find("#real_tradein_payout").val() : 0);
        var deposits_total = parseFloat(($("#computation_form").find("#deposits_total").val() != '') ? $("#computation_form").find("#deposits_total").val() : 0);
        var refunds_total = parseFloat(($("#computation_form").find("#refunds_total").val() != '') ? $("#computation_form").find("#refunds_total").val() : 0);
        var transport_cost = parseFloat(($("#computation_form").find("#transport_cost").val() != '') ? $("#computation_form").find("#transport_cost").val() : 0);
        var other_costs_amount = parseFloat(($("#computation_form").find("#other_costs_amount").val() != '') ? $("#computation_form").find("#other_costs_amount").val() : 0);
        var other_qs_revenue_amount = parseFloat(($("#computation_form").find("#other_qs_revenue_amount").val() != '') ? $("#computation_form").find("#other_qs_revenue_amount").val() : 0);				
        var other_revenue_amount = parseFloat(($("#computation_form").find("#other_revenue_amount").val() != '') ? $("#computation_form").find("#other_revenue_amount").val() : 0);
        var aftersales_accessory_revenue = parseFloat(($("#computation_form").find("#aftersales_accessory_revenue").val() != '') ? $("#computation_form").find("#aftersales_accessory_revenue").val() : 0);

        var balance = 0;
        var price_difference = 0;
        var changeover = 0;
        var commissionable_gross = 0;
        var revenue = 0;
        var revenue_threshold = 1000;
        var final_membership = 0;

        balance = sales_price - tradein_given + tradein_payout - deposits_total + refunds_total;
        changeover = sales_price - tradein_given + tradein_payout;

        if (dealer_tradein_count >= 1)
        {
            price_difference = changeover - dealer_changeover;
            revenue = changeover - dealer_changeover - transport_cost - other_costs_amount + aftersales_accessory_revenue + other_qs_revenue_amount + other_revenue_amount;

            if (revenue <= revenue_threshold)
            {
                final_membership = membership_lower;
            }
            else
            {
                final_membership = membership;
            }
            commissionable_gross = ((changeover - dealer_changeover - transport_cost - other_costs_amount + aftersales_accessory_revenue + other_qs_revenue_amount - final_membership) / 11) * 10;
        }
        else
        {
            price_difference = sales_price - dqp;
            revenue = sales_price + (tradein_value - tradein_given) - dqp - transport_cost - other_costs_amount + aftersales_accessory_revenue + other_qs_revenue_amount + other_revenue_amount;
                //console.log(changeover);
                //console.log(tradein_value);
                //console.log(tradein_given);
                //console.log(revenue);
                //console.log(revenue);

                //alert(revenue);
            if (revenue <= revenue_threshold)
            {
                final_membership = membership_lower;
            }
            else
            {
                final_membership = membership;
            }			
            commissionable_gross = ((sales_price + (tradein_value - tradein_given) - dqp - transport_cost - other_costs_amount + aftersales_accessory_revenue + other_qs_revenue_amount - final_membership) / 11) * 10;
        }

        $("#computation_form").find("#balance").val(balance.toFixed(2));
        $("#computation_form").find("#cpp").val(changeover.toFixed(2));
        $("#computation_form").find("#commissionable_gross").val(commissionable_gross.toFixed(2));
        $("#computation_form").find("#revenue").val(revenue.toFixed(2));			

    }
			
			/* $("#computation_form").submit(function(e) {
				 alert();
				 $.ajax({
					 type: "POST",
					 url: "<?php echo site_url('lead/update_record'); ?>",
					 data: $("#computation_form").serialize(),
					 success: function(response) {
						 console.log(response);
						 if (response === "success")
						 {
							 swal("SUCCESS", "", "success");
							 location.reload(true);
						 }	
						 else if (response === "nochanges")
						 {
							 swal("", "No changes were made", "info");
						 }								
						 else
						 {
							 swal("ERROR", "An error occurred! Please try again", "error");
						 }
					 }
				 });
				 e.preventDefault();
			 });*/
	
	// Dropzone.autoDiscover = false; // 06-01-16
	$(document).ready(function() {
		/* $(document).find("#dz_fa_comment_file").dropzone({
		 	url: '<?php echo site_url('fapplication/upload_file'); ?>',
		 	success: function (file, response) {
		 		$("#fa_uploaded_comment_files").append('<input type="hidden" name="fa_uploaded_comment_file[]" value="'+response+'">');
		 	}
		 });*/
		$(document).on('click', '.btn-close', function(){
			$("#fapplication-modal-3").modal('hide');
		});
	});

	function reopen_lead(id_lead){
	
		get_state(id_lead);
		$.post("<?php echo site_url("fapplication/record"); ?>/" + id_lead, function(data) {
			<?php $this->load->view('admin/js/full_calendar'); ?>
			set_applicant_count_values();
			set_car_data();
		}, 'json');
		swal("SUCCESS", "", "success");

	}
</script>
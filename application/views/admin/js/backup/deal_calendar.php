		<script>
			$("#tradein_select").change(function (){
				var flag = $("#tradein_select").val();
				if (flag == 0)
				{
					$("#trade_buyer_div").addClass("hidden");
				}
				else if (flag == 1)
				{
					$("#trade_buyer_div").removeClass("hidden");
				}
			});
			
			$(document).ready(function(){

				
				$(document).on("click", ".open-send-invoice", function(data){
					
					var invoice_id = $(this).data("invoice_id");

					$.post("<?php echo site_url("deal/send_invoice_modal"); ?>/" + invoice_id, function(data)
					{
						$("#send-invoice-modal").find("#invoice_id").val(invoice_id);
						$("#send-invoice-modal").find("#invoice_sent_emails_div").html(data.invoice_sent_emails_html);
						$("#send-invoice-modal").modal();
					}, "json");
				});

				$(document).on("click", ".open-balcqo", function(data){
					var lead_id = $(this).data("lead_id");
					$.post("<?php echo site_url("deal/balcqo_modal"); ?>/" + lead_id, function(data)
					{
						$("#balcqo-modal").find(".lead_id").val(lead_id);
						$("#balcqo-modal").find(".payments_table").html(data.payments_html);
						$("#balcqo-modal").find(".invoices_table").html(data.invoices_html);
						$("#balcqo-modal").find(".eway_token_body").html(data.eway_token_html);
						$("#balcqo-modal").find(".revenue_total_td").html(data.revenue);
						$("#balcqo-modal").find(".balcqo_total_td").html(data.balcqo);
						$("#balcqo-modal").find(".received_total_td").html(data.received);
						$("#balcqo-modal").find(".remaining_balance_td").html(data.remaining_balance);
						$("#balcqo-modal").find(".actions").html(data.actions_html);
						$("#balcqo-modal").modal();
					}, "json");
				});
				
				$(document).on("click", ".open-add-payment", function(data){

					var lead_id = $("#balcqo-modal").find(".lead_id").val();

					$("#merchant_cost").val("");
					$("#optional_ad_fee").val("");
					$("#merchant_cost_check").prop("checked", false);
					
					$.post("<?php echo site_url("deal/add_payment_modal"); ?>/" + lead_id, function(data)
					{
						$("#add-payment-modal").find(".lead_id").val(lead_id);
						$("#add-payment-modal").find(".eway_token_body").html(data.eway_token_html);
						// $("#add-payment-modal").find(".invoice_number_select").html(data.invoice_html);
						$("#add-payment-modal").find("#add_payment_invoice_tbl").html(data.invoice_html);
						$("#add-payment-modal").modal();
					}, "json");
				});
				
				$(document).on("click", ".open-edit-payment", function(data){

					var payment_id = $(this).data("payment_id");
					
					$.post("<?php echo site_url("deal/edit_payment_modal"); ?>/" + payment_id, function(data)
					{
						$("#edit-payment-modal").find("#payment_id").val(payment_id);
						$("#edit-payment-modal").find("#hidden_sign").val(data.sign);
						$("#edit-payment-modal").find("#fk_payment_type").val(data.fk_payment_type);
						$("#edit-payment-modal").find("#amount").val(data.amount);
						$("#edit-payment-modal").find("#reference_number").val(data.reference_number);
						$("#edit-payment-modal").find("#payment_date").val(data.payment_date);
						$("#edit-payment-modal").find("#optional_ad_fee_edit").val(data.admin_fee);
						$("#edit-payment-modal").find("#edit_payment_invoice_tbl").html(data.invoices_html);
						$("#edit-payment-modal").find("#payment_remarks").val(data.remarks);

						var sign = $("#edit-payment-modal").find("#fk_payment_type").find(":selected").data("sign");
						
						if(sign == 1)
						{
							$("#edit-payment-modal").find(".invoice_check").prop("disabled", false);
						}
						else
						{
							$("#edit-payment-modal").find(".invoice_check").prop("disabled", true);
						}

						if(data.merchant_cost == 0.00 || data.merchant_cost == "0.00" || data.merchant_cost == ""){
							$("#edit_merchant_cost_check").prop("checked", false);
							$("#edit_merchant_cost").prop("disabled", true);
						}
						else{
							$("#edit_merchant_cost_check").prop("checked", true);
							$("#edit_merchant_cost").prop("disabled", false);
							$("#edit_merchant_cost").val(data.merchant_cost);
						}

						$("#edit-payment-modal").modal();
					}, "json");
				});

				$(document).on("click", ".open-add-invoice-payment", function(data){

					var invoice_id = $(this).data("invoice_id");
					
					$.post("<?php echo site_url("deal/add_invoice_payment_modal"); ?>/" + invoice_id, function(data)
					{
						$("#add-invoice-payment-modal").find(".invoice_id").val(invoice_id);
						$("#add-invoice-payment-modal").find(".eway_token_body").html(data.eway_token_html);
						$("#add-invoice-payment-modal").find(".invoice_body").html(data.invoice_html);
						$("#add-invoice-payment-modal").modal();
					}, "json");
				});				
				
				$(document).on("click", ".open-add-invoice", function(data){

					var lead_id = $("#balcqo-modal").find(".lead_id").val();

					$("#add-invoice-modal").find(".lead_id").val(lead_id);
					$("#add-invoice-modal").modal();
				});				
				
				$(document).on("click", ".open-edit-invoice", function(data){ // Partially Done // Add Item Remaining //

					var invoice_id = $(this).data("invoice_id");
					
					$.post("<?php echo site_url("deal/edit_invoice_modal"); ?>/" + invoice_id, function(data)
					{
						$("#edit-invoice-modal").find("#invoice_id").val(invoice_id);
						$("#edit-invoice-modal").find("#invoice_number").val(data.invoice_number);
						$("#edit-invoice-modal").find("#invoice_type").val(data.invoice_type);
						$("#edit-invoice-modal").find("#amount").val(data.amount);
						$("#edit-invoice-modal").find("#invoice_date").val(data.invoice_date);
						$("#edit-invoice-modal").find("#due_date").val(data.due_date);
						$("#edit-invoice-modal").find("#promised_date").val(data.promised_date);
						$("#edit-invoice-modal").find("#invoice_name").val(data.invoice_name);
						$("#edit-invoice-modal").find("#remarks").val(data.remarks);
						$("#edit-invoice-modal").find("#details").val(data.details);
						$("#edit-invoice-modal").find("#invoice_item_div").html(data.invoice_item_html);
						$("#edit-invoice-modal").modal();
					}, "json");
				});				
				//transferred to lead_calendars.php
				// $(document).on("change", ".payment-type-select", function(){
				// 	var that = $(this);
				// 	var this_value = that.val();
				// 	var this_sign = that.find(":selected").data("sign");

				// 	if (this_sign == 1)
				// 	{
				// 		$("#add-payment-modal").find(".invoice_number_select").prop("disabled", false);
				// 		$("#add-payment-modal").find(".amount_tb").prop("disabled", false);
				// 		$("#add-payment-modal").find(".hidden-credit-card").prop("hidden", true);
				// 		$("#add-payment-modal").find(".hidden-reference").prop("hidden", true);
				// 		$("#add-payment-modal").find(".credit-card").closest("div").prop("hidden", false);
				// 		$("#add-payment-modal").find(".reference-number").closest("div").prop("hidden", false);
				// 		$("#add-payment-modal").find(".payment-method-radio").prop("checked", false);
				// 		$("#add-payment-modal").find(".invoice_check").prop("disabled", false);

				// 		$("#edit-payment-modal").find(".invoice_check").prop("disabled", false);

				// 		$("#merchant_cost_check").prop("disabled", false);
				// 	}
				// 	else if (this_sign == -1)
				// 	{
				// 		$("#add-payment-modal").find(".invoice_number_select").prop("disabled", true);
				// 		$("#add-payment-modal").find(".amount_tb").prop("disabled", false);
				// 		$("#add-payment-modal").find(".hidden-credit-card").prop("hidden", true);
				// 		$("#add-payment-modal").find(".hidden-reference").prop("hidden", true);
				// 		$("#add-payment-modal").find(".credit-card").closest("div").prop("hidden", true);
				// 		$("#add-payment-modal").find(".reference-number").closest("div").prop("hidden", false);
				// 		$("#add-payment-modal").find(".payment-method-radio").prop("checked", false);
				// 		$("#add-payment-modal").find(".invoice_check").prop("disabled", true);
				// 		$("#add-payment-modal").find(".invoice_amt").prop("disabled", true);

				// 		$("#add-payment-modal").find(".invoice_check").prop("checked", false);

				// 		$("#edit-payment-modal").find(".invoice_check").prop("disabled", true);
				// 		$("#edit-payment-modal").find(".invoice_amt").prop("disabled", true);

				// 		$("#edit-payment-modal").find(".invoice_check").prop("checked", false);

				// 		$("#merchant_cost_check").prop("disabled", true);
				// 		$("#merchant_cost_check").prop("checked", false);
				// 		$("#merchant_cost").val("0.00");
				// 		$("#merchant_cost").prop("disabled", true);
				// 	}
				// 	else
				// 	{
				// 		$("#add-payment-modal").find(".invoice_number_select").prop("disabled", true);
				// 		$("#add-payment-modal").find(".amount_tb").prop("disabled", true);
				// 		$("#add-payment-modal").find(".hidden-credit-card").prop("hidden", true);
				// 		$("#add-payment-modal").find(".hidden-reference").prop("hidden", true);
				// 		$("#add-payment-modal").find(".credit-card").closest("div").prop("hidden", true);
				// 		$("#add-payment-modal").find(".reference-number").closest("div").prop("hidden", true);
				// 		$("#add-payment-modal").find(".payment-method-radio").prop("checked", false);
				// 		$("#add-payment-modal").find(".invoice_check").prop("disabled", false);
				// 		$("#add-payment-modal").find(".invoice_amt").prop("disabled", true);

				// 		$("#edit-payment-modal").find(".invoice_check").prop("disabled", false);
				// 		$("#edit-payment-modal").find(".invoice_amt").prop("disabled", true);
				// 	}
				// });

				//dropdown
				$(document).on("change", "#fk_payment_type", function(){
					var that = $(this);
					var this_value = that.val();
					var this_sign = that.find(":selected").data("sign");
					
					if (this_sign == 1)
					{
						$("#edit-payment-modal").find(".invoice_check").prop("disabled", false);

						$("#edit_merchant_cost_check").prop("disabled", false);
					}
					else if (this_sign == -1)
					{
						$("#edit-payment-modal").find(".invoice_check").prop("disabled", true);
						$("#edit-payment-modal").find(".invoice_amt").prop("disabled", true);

						$("#edit-payment-modal").find(".invoice_check").prop("checked", false);

						$(document).find('.invoice_check').prop("checked", false);
						$(document).find('.invoice_amt').val("");

						$("#edit_merchant_cost_check").prop("disabled", true);
						$("#edit_merchant_cost_check").prop("checked", false);
						$("#edit_merchant_cost").val("0.00");
						$("#edit_merchant_cost").prop("disabled", true);
					}
					else
					{
						$("#edit-payment-modal").find(".invoice_check").prop("disabled", false);
						$("#edit-payment-modal").find(".invoice_amt").prop("disabled", true);
					}
				});

				// $(document).on("change", ".payment-method-radio", function(){
				// 	var that = $(this);
				// 	var this_value = that.val();

				// 	if(this_value == 1)
				// 	{
				// 		$("#add-payment-modal").find(".hidden-credit-card").prop("hidden", false);
				// 		$("#add-payment-modal").find(".hidden-reference").prop("hidden", true);
				// 		$("#add-payment-modal").find(".add-payment-btn").prop("disabled", false);
				// 	}
				// 	else
				// 	{
				// 		$("#add-payment-modal").find(".hidden-credit-card").prop("hidden", true);
				// 		$("#add-payment-modal").find(".hidden-reference").prop("hidden", false);
				// 		$("#add-payment-modal").find(".add-payment-btn").prop("disabled", false);
				// 	}
				// });
				
				$(document).on("change", ".credit_card_number_inp", function(){
					var master = /^(?:5[1-5][0-9]{14})$/;
					var visa = /^(?:4[0-9]{12}(?:[0-9]{3})?)$/;  
					var inputtxt = $(this).val().replace(' ', '');
					if(inputtxt.match(master))  
			        {  
						$(".card_type").val("Mastercard");
			        }
			        else if(inputtxt.match(visa))
			        {
			        	$(".card_type").val("Visa");
			        }
					else  
			        {  
				        alert("Not a valid Mastercard or Visa number!");
			        }
				});

				$(document).on("click", ".uncheck_tokens", function(){
					$(document).find(".token_id").prop("checked", false);
				});				
			});

			function add_invoice_item ()
			{
				$("#add-invoice-modal").find("#invoice_item_div").append('\
				<div style="border: 1px solid #ddd; padding: 15px;">\
					<div class="row">\
						<div class="col-md-12">\
							<div class="form-group">\
								<label><b>Amount:</b></label>\
								<input type="text" class="form-control mb-md" id="invoice_item_amount" name="invoice_item_amount[]" onkeypress="return isNumberKey(event)" >\
								<br />\
							</div>\
						</div>\
						<div class="col-md-12">\
							<div class="form-group">\
								<label><b>Description:</b></label>\
								<textarea id="invoice_item_description" name="invoice_item_description[]" class="form-control" placeholder="Description"></textarea>\
								<br />\
							</div>\
						</div>\
					</div>\
				</div>\
				<br />');
			}
			
			function delete_invoice_item (invoice_item_id)
			{
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('deal/delete_invoice_item'); ?>/"+invoice_item_id,
					cache: false,
					success: function(result) {
						$("#edit-invoice-modal").find("#invoice_item_div_"+invoice_item_id).remove();
					}
				});
			}

			// $(document).on('change', '.invoice_check', function(){
			// 	var checked = $(this).prop('checked');
			// 	var amt = $(this).closest("tr").find(".invoice_amt");

			// 	if(checked == true){
			// 		$(amt).prop("disabled", false);
			// 	}else{
			// 		$(amt).prop("disabled", true);
			// 		// $(amt).val("");
			// 	}
			// });

			// $(document).on('change', '#merchant_cost_check', function(){
			// 	var this_status = $(this).prop("checked");
			// 	var amount = $("#add-payment-modal").find(".amount_tb").val();
			// 	var sign = $("#add-payment-modal").find(".payment-type-select option:selected").data("sign");
			// 	var temp_cost = 0.00;
			// 	console.log(sign);
			// 	if(amount == 0.00 || amount == "0.00" || amount == "")
			// 		amount = 0.00;	

			// 	console.log(amount)
			// 	if(this_status == true && sign == 1){
			// 		$("#merchant_cost").prop("disabled", false);
			// 		temp_cost = 0.3 + (0.0175 * parseFloat(amount));
			// 		$("#merchant_cost").val(temp_cost.toFixed(2));
			// 	}
			// 	else{
			// 		$("#merchant_cost").val("0.00");
			// 		$("#merchant_cost").prop("disabled", true);
			// 	}
			// });

			// $(document).on('change', '.amount_tb', function(){
			// 	var this_status = $("#add-payment-modal").find("#merchant_cost_check").prop("checked");
			// 	var sign = $("#add-payment-modal").find(".payment-type-select option:selected").data("sign");
			// 	var amount = $(this).val();
			// 	var temp_cost = 0.00;

			// 	if(amount == 0.00 || amount == "0.00" || amount == "")
			// 		amount = 0.00;

			// 	if(this_status == true && sign == 1){
			// 		temp_cost = 0.3 + (0.0175 * parseFloat(amount));
			// 		$("#merchant_cost").val(temp_cost.toFixed(2));
			// 	}
			// 	else{
			// 		$("#merchant_cost").val("0.00");	
			// 	}
			// });

			// $(document).on('change', '#edit_merchant_cost_check', function(){
			// 	var this_status = $(this).prop("checked");
			// 	var amount = $("#edit-payment-modal").find("#amount").val();
			// 	var sign = $("#edit-payment-modal").find("#fk_payment_type option:selected").data("sign");
			// 	var temp_cost = 0.00;
				
			// 	if(amount == 0.00 || amount == "0.00" || amount == "")
			// 		amount = 0.00;				

				
			// 	if(this_status == true && sign == 1){
			// 		$("#edit_merchant_cost").prop("disabled", false);
			// 		temp_cost = 0.3 + (0.0175 * parseFloat(amount));
			// 		$("#edit_merchant_cost").val(temp_cost.toFixed(2));
			// 	}
			// 	else{
			// 		$("#edit_merchant_cost").val("0.00");
			// 		$("#edit_merchant_cost").prop("disabled", true);
			// 	}
			// });

			// $(document).on('change', '#amount', function(){
			// 	var this_status = $("#edit-payment-modal").find("#edit_merchant_cost_check").prop("checked");
			// 	var sign = $("#edit-payment-modal").find("#fk_payment_type option:selected").data("sign");
			// 	var amount = $(this).val();
			// 	var temp_cost = 0.00;

			// 	if(amount == 0.00 || amount == "0.00" || amount == "")
			// 		amount = 0.00;

			// 	if(this_status == true && sign == 1){
			// 		temp_cost = 0.3 + (0.0175 * parseFloat(amount));
			// 		$("#edit_merchant_cost").val(temp_cost.toFixed(2));
			// 	}
			// 	else{
			// 		$("#edit_merchant_cost").val("0.00");	
			// 	}
			// });

			//transferred to lead_calendar.php
			// function add_payment_action ()
			// {
			// 	var admin_fee = "";
			// 	var payment_method = "";
			// 	var final_payment_date = "";
				
			// 	var amount = $("#add-payment-modal").find(".amount_tb").val();

			// 	if(amount == "")
			// 	{
			// 		alert ("Please enter the amount!");
			// 		return false;
			// 	}

			// 	var lead_id            = $("#add-payment-modal").find(".lead_id").val();
			// 	var invoice_id         = $("#add-payment-modal").find(".invoice_number_select").val();				
			// 	var code               = $("#add-payment-modal").find(".payment-type-select option:selected").html();
			// 	var code_id            = $("#add-payment-modal").find(".payment-type-select").val();
			// 	var amount             = parseFloat(amount);
				
			// 	var reference_number   = $.trim($("#add-payment-modal").find(".reference_number").val());
			// 	var payment_date       = $("#add-payment-modal").find(".payment_date").val();
				
			// 	// console.log(payment_date);
				
			// 	var cc_number          = $("#add-payment-modal").find(".credit_card_number_inp").val();
			// 	var credit_card_number = $("#add-payment-modal").find(".credit_card_number_inp").val();
			// 	var first_name         = $("#add-payment-modal").find(".first_name_inp").val();
			// 	var last_name          = $("#add-payment-modal").find(".last_name_inp").val();
			// 	var expiry_month       = $("#add-payment-modal").find(".expiry_month_inp").val();
			// 	var expiry_year        = $("#add-payment-modal").find(".expiry_year_inp").val();
			// 	var cvn                = $("#add-payment-modal").find(".cvn_inp").val();
			// 	var card_type          = $("#add-payment-modal").find(".card_type").val();
			// 	var merchant_cost      = $("#add-payment-modal").find("#merchant_cost").val();

			// 	if(code_id == "")
			// 	{
			// 		alert ("Payment Code cannot be blank!");
			// 		return false;
			// 	}

			// 	if(reference_number != '' && cc_number != '')
			// 	{
			// 		alert("You cannot enter a reference number and credit card payment at the same time!");
			// 		return false;
			// 	}

			// 	if(reference_number == '' && cc_number != '')
			// 	{
			// 		if (last_name=="" || first_name=="" || credit_card_number=="" || expiry_month=="" || expiry_year=="" || cvn=="")
			// 		{
			// 			alert("Please complete the required fields!");
			// 			return false;
			// 		}
			// 	}
			// 	else if(reference_number == '' && cc_number == '' && $('input[name="token_id"]:checked').length == 0)
			// 	{
			// 		alert("Please choose a payment method!");
			// 		return false;
			// 	}
			// 	else if(cc_number != '' && $('input[name="token_id"]:checked').length > 0)
			// 	{
			// 		alert("You cannot enter a credit card details and choose a token at the same time!");
			// 		return false;
			// 	}

			// 	var sign              = parseFloat($("#add-payment-modal").find(".payment-type-select option:selected").data("sign"));
			// 	var received_total    = parseFloat($("#balcqo-modal").find(".received_total_td").html());
			// 	var remaining_balance = parseFloat($("#balcqo-modal").find(".remaining_balance_td").html());

			// 	var real_amount           = sign * amount;
			// 	var new_received_total    = received_total + real_amount;
			// 	var new_remaining_balance = remaining_balance - real_amount;
				
			// 	var d           = new Date();
			// 	var curr_date   = d.getDate();
			// 	var curr_month  = d.getMonth() + 1;
			// 	var curr_year   = d.getFullYear();
			// 	var curr_hour   = d.getHours();
			// 	var curr_minute = d.getMinutes();
			// 	var curr_second = d.getSeconds();					
			// 	var time_now    = (curr_year + "-" + pad(curr_month, 2) + "-" + pad(curr_date, 2) + " " + pad(curr_hour, 2) + ":" + pad(curr_minute, 2) + ":" + pad(curr_second, 2));

			// 	var new_date = (curr_year + "-" + pad(curr_month, 2) + "-" + pad(curr_date, 2));
				
			// 	if (reference_number == '')
			// 	{
			// 		payment_method = "Credit Card";
			// 		final_payment_date = new_date;
			// 	}
			// 	else
			// 	{
			// 		payment_method = "External";
			// 		final_payment_date = payment_date;
			// 	}

			// 	var ctr  = 0;
			// 	var ctr2 = 0;
			// 	var total_invoice_amount = 0.00;

			// 	$(document).find('.invoice_check').each(function(index, value){
			// 		var id = $(this).val();
			// 		var amt = $(this).closest("tr").find(".invoice_amt").val();
			// 		var checked = $(this).prop('checked');

			// 		if(amt == "")
			// 			amt = 0.00;	

			// 		if(checked == true && amt == "")
			// 			ctr = ctr + 1;

			// 		if(checked == false && amt != "")
			// 			ctr2 = ctr2 + 1;

			// 		total_invoice_amount = total_invoice_amount + parseFloat(amt);
			// 	});

			// 	if(total_invoice_amount > amount)
			// 	{
			// 		alert("Total invoice amount should be equal or less than the payment amount!");
			// 		return false;
			// 	}

			// 	if(ctr > 0)
			// 	{
			// 		alert("There's a selected invoice that has no amount, please unselect the invoice or put an amount!");
			// 		return false;
			// 	}

			// 	if(ctr2 > 0)
			// 	{
			// 		alert("There's an unselected invoice that has amount, please select the invoice or remove the amount!");
			// 		return false;
			// 	}
				
			// 	$.ajax({
			// 		type: "POST",
			// 		url: "<?php echo site_url('deal/add_payment'); ?>",
			// 		data: $("#add-payment-modal").find(".main_form").serialize(),
			// 		cache: false,
			// 		dataType: "json",
			// 		success: function(result) {

			// 			if(!result.status)
			// 			{
			// 				alert(result.message);
			// 				return false;
			// 			}

			// 			if(result.reference_number != 0)
			// 			{
			// 				reference_number = result.reference_number;
			// 			}

			// 			alert(result.message);
			// 			var user = "<?php echo $session_data['name']; ?>";

			// 			$("#add-payment-modal").find(".payment-type-select").val("");
			// 			$("#add-payment-modal").find(".payment-method-radio").val("");
			// 			$("#add-payment-modal").find(".amount_tb").val("");
						
			// 			$("#add-payment-modal").find(".reference_number").val("");						
			// 			$("#add-payment-modal").find(".payment_date").val("");

			// 			$("#add-payment-modal").find(".credit_card_number_inp").val("");						
			// 			$("#add-payment-modal").find(".first_name_inp").val("");
			// 			$("#add-payment-modal").find(".last_name_inp").val("");
			// 			$("#add-payment-modal").find(".expiry_month_inp").val("");
			// 			$("#add-payment-modal").find(".expiry_year_inp").val("");
			// 			$("#add-payment-modal").find(".cvn_inp").val("");
			// 			$("#add-payment-modal").find(".card_type").val("");

			// 			$("#balcqo-modal").find("#payment_no_records").remove();
			// 			$("#balcqo-modal").find(".payments_table").append('\
			// 				<tr>\
			// 					<td align="center"></td>\
			// 					<td></td>\
			// 					<td></td>\
			// 					<td></td>\
			// 					<td>'+code+'</td>\
			// 					<td>'+payment_method+'</td>\
			// 					<td>'+reference_number+'</td>\
			// 					<td>'+user+'</td>\
			// 					<td>'+real_amount.toFixed(2)+'</td>\
			// 					<td>'+(parseFloat(result.admin_pay)).toFixed(2)+'</td>\
			// 					<td>'+final_payment_date+'</td>\
			// 					<td>0.00</td>\
			// 					<td></td>\
			// 					<td>'+merchant_cost+'</td>\
			// 					<td>Unverified</td>\
			// 					<td>Shown</td>\
			// 				</tr>'
			// 			);
			// 			$("#balcqo-modal").find(".received_total_td").html(new_received_total.toFixed(2));
			// 			$("#balcqo-modal").find(".remaining_balance_td").html(new_remaining_balance.toFixed(2));

			// 			$("#remaining_balance_td_"+lead_id).html(new_remaining_balance.toFixed(2));

			// 			$("#add-payment-modal").find(".invoice_number_select").prop("disabled", true);
			// 			$("#add-payment-modal").find(".amount_tb").prop("disabled", true);
			// 			$("#add-payment-modal").find(".hidden-credit-card").prop("hidden", true);
			// 			$("#add-payment-modal").find(".hidden-reference").prop("hidden", true);
			// 			$("#add-payment-modal").find(".credit-card").closest("div").prop("hidden", true);
			// 			$("#add-payment-modal").find(".reference-number").closest("div").prop("hidden", true);
			// 			$("#add-payment-modal").find(".payment-method-radio").prop("checked", false);

			// 			$("#add-payment-modal").modal("hide");
			// 		}
			// 	});
			// }
			
			function add_invoice_action ()
			{
				var lead_id = $("#add-invoice-modal").find(".lead_id").val();
				var amount = $("#add-invoice-modal").find("#amount").val();
				if(amount == "")
				{
					alert ("Please enter the amount!");
					return false;
				}
				
				var invoice_number = $("#add-invoice-modal").find("#invoice_number").val();
				var invoice_name = $("#add-invoice-modal").find("#invoice_name").val();
				var invoice_type = $("#add-invoice-modal").find("#invoice_type").val();
				var amount = parseFloat(amount);
				var invoice_date = $("#add-invoice-modal").find("#invoice_date").val();
				var due_date = $("#add-invoice-modal").find("#due_date").val();
				var promised_date = $("#add-invoice-modal").find("#promised_date").val();
				var remarks = $("#add-invoice-modal").find("#remarks").val();
				var details = $("#add-invoice-modal").find("#details").val();
				var user = "<?php echo $session_data['name']; ?>";

				if(invoice_number == "" || invoice_name == "" || invoice_type == "" || invoice_date == "" || due_date == "")
				{
					alert ("Please complete all the required fields!");
					return false;
				}

				$.ajax({
					type: "POST",
					url: "<?php echo site_url('deal/add_invoice'); ?>/"+lead_id,
					data: $("#add-invoice-modal").find(".main_form").serialize(),
					cache: false,
					success: function(result) {
						$("#add-invoice-modal").find("#invoice_number").val("");
						$("#add-invoice-modal").find("#invoice_name").val("");
						$("#add-invoice-modal").find("#invoice_type").val("");
						$("#add-invoice-modal").find("#amount").val("");
						$("#add-invoice-modal").find("#invoice_date").val("");
						$("#add-invoice-modal").find("#due_date").val("");
						$("#add-invoice-modal").find("#promised_date").val("");
						$("#add-invoice-modal").find("#remarks").val("");
						$("#add-invoice-modal").find("#details").val("");
						$("#balcqo-modal").find(".tr-invoice-no-results").remove();
						$("#balcqo-modal").find(".invoices_table").append('\
							<tr>\
								<td></td>\
								<td></td>\
								<td></td>\
								<td></td>\
								<td></td>\
								<td>'+invoice_number+'</td>\
								<td>'+invoice_name+'</td>\
								<td>'+invoice_type+'</td>\
								<td>'+invoice_date+'</td>\
								<td>'+due_date+'</td>\
								<td>'+promised_date+'</td>\
								<td>'+amount+'</td>\
								<td>0</td>\
								<td>'+user+'</td>\
								<td></td>\
							</tr>'
						);
						$("#add-invoice-modal").modal("hide");
					}
				});
			}

			function update_payment_action ()
			{
				var payment_id           = $("#edit-payment-modal").find("#payment_id").val();
				var fk_payment_type      = $("#edit-payment-modal").find("#fk_payment_type").val();
				var amount               = $("#edit-payment-modal").find("#amount").val();
				var reference_number     = $("#edit-payment-modal").find("#reference_number").val();
				var payment_date         = $("#edit-payment-modal").find("#payment_date").val();
				var orig_amount          = $("#payment_tr_"+payment_id).find('.payment_amount_td').text();
				var optional_ad_fee_edit = $("#edit-payment-modal").find("#optional_ad_fee_edit").val();

				var merchant_cost      = $("#edit-payment-modal").find("#edit_merchant_cost").val();

				orig_amount = parseFloat(orig_amount.replace('$ ', ''));

				var received_total    = parseFloat($("#balcqo-modal").find(".received_total_td").text());
				var remaining_balance = parseFloat($("#balcqo-modal").find(".remaining_balance_td").text());

				var sign = $("#edit-payment-modal").find("#fk_payment_type option:selected").data("sign");
				var orig_sign = parseFloat($("#edit-payment-modal").find("#hidden_sign").val());

				var fk_payment_type_text  = $("#edit-payment-modal").find("#fk_payment_type option:selected").text();

				var new_remaining_balance = 0.00;

				if(fk_payment_type == "" || amount == "" || reference_number == "" || payment_date == "")
				{
					alert ("Please complete all the required fields!");
					return false;
				}
				
				amount = sign * amount;

				var diff = amount - orig_amount;

				var new_received_total    = parseFloat(received_total + diff);
				var new_remaining_balance = parseFloat(remaining_balance - diff);
				//console.log(diff);
				var user = "<?php echo $session_data['name']; ?>";

				var ctr  = 0;
				var ctr2 = 0;
				var total_invoice_amount = 0.00;

				$(document).find('.invoice_check').each(function(index, value){
					var id = $(this).val();
					var amt = $(this).closest("tr").find(".invoice_amt").val();
					var checked = $(this).prop('checked');

					if(amt == "")
						amt = 0.00;	

					if(checked == true && amt == "")
						ctr = ctr + 1;

					if(checked == false && amt != "")
						ctr2 = ctr2 + 1;

					total_invoice_amount = total_invoice_amount + parseFloat(amt);
				});
				
				if(total_invoice_amount > amount && sign == 1)
				{
					alert("Total invoice amount should be equal or less than the payment amount!");
					return false;
				}

				if(ctr > 0)
				{
					alert("There's a selected invoice that has no amount, please unselect the invoice or put an amount!");
					return false;
				}

				if(ctr2 > 0)
				{
					alert("There's an unselected invoice that has amount, please select the invoice or remove the amount!");
					return false;
				}
				// return false;
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('deal/update_payment'); ?>/" + payment_id,
					data: $("#edit-payment-modal").find(".main_form").serialize(),
					cache: false,
					success: function(result) {

						$("#payment_tr_"+payment_id).find('.payment_type_td').text(fk_payment_type_text);
						$("#payment_tr_"+payment_id).find('.referencet_td').text(reference_number);
						$("#payment_tr_"+payment_id).find('.payment_amount_td').text(amount);
						$("#payment_tr_"+payment_id).find('.payment_date_td').text(payment_date);
						$("#payment_tr_"+payment_id).find('.admin_fee').text(optional_ad_fee_edit);
						$("#payment_tr_"+payment_id).find('.merchant_cost_td').text(merchant_cost);

						$("#balcqo-modal").find(".received_total_td").html(new_received_total.toFixed(2));
						$("#balcqo-modal").find(".remaining_balance_td").html(new_remaining_balance.toFixed(2));

						$("#edit-payment-modal").find("#payment_id").val("");
						$("#edit-payment-modal").find("#fk_payment_type").val("");
						$("#edit-payment-modal").find("#amount").val("");
						$("#edit-payment-modal").find("#reference_number").val("");
						$("#edit-payment-modal").find("#payment_date").val("");
						$("#edit-payment-modal").modal("hide");
					}
				});
			}			
			
			function update_invoice_action ()
			{
				var invoice_id = $("#edit-invoice-modal").find("#invoice_id").val();
				var amount = $("#edit-invoice-modal").find("#amount").val();
				if(amount == "")
				{
					alert ("Please enter the amount!");
					return false;
				}
				
				var invoice_number = $("#edit-invoice-modal").find("#invoice_number").val();
				var invoice_name = $("#edit-invoice-modal").find("#invoice_name").val();
				var invoice_type = $("#edit-invoice-modal").find("#invoice_type").val();
				var amount = parseFloat(amount);
				var invoice_date = $("#edit-invoice-modal").find("#invoice_date").val();
				var due_date = $("#edit-invoice-modal").find("#due_date").val();
				var promised_date = $("#edit-invoice-modal").find("#promised_date").val();
				var remarks = $("#edit-invoice-modal").find("#remarks").val();
				var details = $("#edit-invoice-modal").find("#details").val();
				var user = "<?php echo $session_data['name']; ?>";

				if(invoice_number == "" || invoice_name == "" || invoice_type == "" || invoice_date == "" || due_date == "")
				{
					alert ("Please complete all the required fields!");
					return false;
				}

				$.ajax({
					type: "POST",
					url: "<?php echo site_url('deal/update_invoice'); ?>/"+invoice_id,
					data: $("#edit-invoice-modal").find(".main_form").serialize(),
					cache: false,
					success: function(result) {

						$("#invoice_tr_"+invoice_id).find(".invoice_num_td").text(invoice_number);
						$("#invoice_tr_"+invoice_id).find(".invoice_name_td").text(invoice_name);
						$("#invoice_tr_"+invoice_id).find(".invoice_type_td").text(invoice_type);
						$("#invoice_tr_"+invoice_id).find(".invoice_date_td").text(invoice_date);
						$("#invoice_tr_"+invoice_id).find(".invoice_due_date_td").text(due_date);
						$("#invoice_tr_"+invoice_id).find(".invoice_promise_date_td").text(promised_date);
						$("#invoice_tr_"+invoice_id).find(".invoice_amount_td").text(amount);
						

						$("#edit-invoice-modal").find("#invoice_number").val("");
						$("#edit-invoice-modal").find("#invoice_name").val("");
						$("#edit-invoice-modal").find("#invoice_type").val("");
						$("#edit-invoice-modal").find("#amount").val("");
						$("#edit-invoice-modal").find("#invoice_date").val("");
						$("#edit-invoice-modal").find("#due_date").val("");
						$("#edit-invoice-modal").find("#promised_date").val("");	
						$("#edit-invoice-modal").find("#remarks").val("");							
						$("#edit-invoice-modal").find("#details").val("");
						$("#edit-invoice-modal").modal("hide");
					}
				});
			}			
			
			function send_invoice_action ()
			{
				var invoice_id = $("#send-invoice-modal").find("#invoice_id").val();
				var email = $("#send-invoice-modal").find("#email").val();
				if(email == "")
				{
					alert ("Please enter the email address of the recipient!");
					return false;
				}
				var message = $("#send-invoice-modal").find("#message").val();
				var user = "<?php echo $session_data['name']; ?>";

				$.ajax({
					type: "POST",
					url: "<?php echo site_url('deal/send_invoice'); ?>/"+invoice_id,
					data: $("#send-invoice-modal").find(".main_form").serialize(),
					cache: false,
					success: function(result) {
						$("#send-invoice-modal").find("#invoice_id").val("");
						$("#send-invoice-modal").find("#email").val("");
						$("#send-invoice-modal").find("#subject").val("");
						$("#send-invoice-modal").find("#message").val("");
						$("#send-invoice-modal").modal("hide");
					}
				});
			}			
			
			function delete_payment (payment_id)
			{
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('deal/delete_payment'); ?>/"+payment_id,
					cache: false,
					success: function(result) {
						var payment_amount    = parseFloat($("#balcqo-modal").find("#payment_amount_td_"+payment_id).html());
						var received_total    = parseFloat($("#balcqo-modal").find(".received_total_td").html());
						var remaining_balance = parseFloat($("#balcqo-modal").find(".remaining_balance_td").html());

						var new_received_total    = received_total - payment_amount;
						var new_remaining_balance = remaining_balance + payment_amount;

						$("#balcqo-modal").find(".received_total_td").html(new_received_total.toFixed(2));
						$("#balcqo-modal").find(".remaining_balance_td").html(new_remaining_balance.toFixed(2));
						$("#balcqo-modal").find("#payment_tr_"+payment_id).remove();
					}
				});			
			}

			function delete_invoice (invoice_id)
			{
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('deal/delete_invoice'); ?>/"+invoice_id,
					cache: false,
					success: function(result) {
						$("#balcqo-modal").find("#invoice_tr_"+invoice_id).remove();
					}
				});
			}

			$(document).on("click", ".open-search-payment", function(){

				var lead_id = $("#balcqo-modal").find(".lead_id").val();
				$("#filtered_payment_search_result").html("");
				$("#search_payment_modal").modal();
			});

			$(document).on("change", ".search_payment_field", function(){

				$("#filtered_payment_search_result").html("");

				var search_payment_reference = $("#search_payment_reference").val();
				var search_payment_amount = $("#search_payment_amount").val();
				var search_payment_created_at = $("#search_payment_created_at").val();

				var data = {
					search_payment_reference: search_payment_reference,
					search_payment_amount : search_payment_amount,
					search_payment_created_at: search_payment_created_at
				};

				$.ajax({
					type: "POST",
					url: "<?php echo site_url("deal/get_searched_payments"); ?>",
					data: data,
					cache: false,
					success: function(result){
						$("#filtered_payment_search_result").html(result);
					}
				});
			});

			$(document).on('click', '#search_payment_created_at', function () {
		        $(this).toggleClass('clicked').datepicker().datepicker('show')
		    });

		    $(document).on('click', '.select_payment', function () {
				var lead_id = $("#balcqo-modal").find(".lead_id").val();
				var payment_id = $(this).data("payment_id");

				var data = {
					lead_id: lead_id,
					payment_id: payment_id
				}

				if( confirm("Are you sure you want to attach this payment to the deal?") )
				{
					$.ajax({
						type: "POST",
						url: "<?php echo site_url("deal/attach_payment_to_lead"); ?>",
						data: data,
						dataType: 'json',
						cache: false,
						success: function(data){
							
							var user = "<?php echo $session_data['name']; ?>";

							$("#balcqo-modal").find("#payment_no_records").remove();
							$("#balcqo-modal").find(".payments_table").append('\
								<tr>\
									<td align="center"></td>\
									<td></td>\
									<td></td>\
									<td></td>\
									<td>'+data.description+'</td>\
									<td>External</td>\
									<td>'+data.reference_number+'</td>\
									<td>'+user+'</td>\
									<td align="right">'+(parseFloat(data.amount)).toFixed(2)+'</td>\
									<td align="right">'+(parseFloat(data.admin_fee)).toFixed(2)+'</td>\
									<td>'+data.payment_date+'</td>\
									<td>0.00</td>\
									<td></td>\
									<td>Shown</td>\
								</tr>'
							);

							var sign              = parseFloat(data.sign);
							var received_total    = parseFloat($("#balcqo-modal").find(".received_total_td").html());
							var remaining_balance = parseFloat($("#balcqo-modal").find(".remaining_balance_td").html());

							var real_amount           = sign * parseFloat(data.amount);
							var new_received_total    = received_total + real_amount;
							var new_remaining_balance = remaining_balance - real_amount;

							$("#balcqo-modal").find(".received_total_td").html(new_received_total.toFixed(2));
							$("#balcqo-modal").find(".remaining_balance_td").html(new_remaining_balance.toFixed(2));

							$("#remaining_balance_td_"+lead_id).html(new_remaining_balance.toFixed(2));

							$("#search_payment_modal").modal('hide');
						}
					});
				}
			});

		</script>



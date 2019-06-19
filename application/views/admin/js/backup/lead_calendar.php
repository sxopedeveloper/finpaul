<?php
$session_user_id = $this->session->userdata('user_id');
if($session_user_id == 255)
{
	?>
	<!--
	<script type="text/javascript" src="https://js.squareup.com/v2/paymentform"></script>
	<script>
		var modal_flag = 0;
		var applicationId = 'sandbox-sq0idp-k1bW2KCbidEk3Ftd9Fnp8g';
		var paymentForm = new SqPaymentForm({
			applicationId: applicationId,
			inputClass: 'sq-input',
			cardNumber: {
				elementId: 'cc_number_squareup',
				placeholder: '•••• •••• •••• ••••'
			},
			cvv: {
				elementId: 'cvn_squareup',
				placeholder: 'CVN'
			},
			expirationDate: {
				elementId: 'expiration_squareup',
				placeholder: 'MM/YY'
			},
			postalCode: {
				elementId: 'postcode_squareup'
			},
			callbacks: {

				cardNonceResponseReceived: function(errors, nonce, cardData) {
				  if (errors) {
					
					errors.forEach(function(error) {
					  alert('Encountered errors: ' + error.message);
					});
					return false;
				  
				  } else {

					document.getElementById('card-nonce').value = nonce;
					// document.getElementById('nonce-form').submit();
					$(".add_deposit").prop("disabled", false);

					alert("Squareup transaction authorized and secured!");
				  }
				},

				unsupportedBrowserDetected: function() {
				  alert("This browser is not supported for Squareup Transactions");
				  return false;
				},

				inputEventReceived: function(inputEvent) {
				  switch (inputEvent.eventType) {
					case 'focusClassAdded':
					  // Handle as desired
					  break;
					case 'focusClassRemoved':
					  // Handle as desired
					  break;
					case 'errorClassAdded':
					  // Handle as desired
					  break;
					case 'errorClassRemoved':
					  // Handle as desired
					  break;
					case 'cardBrandChanged':
					  // Handle as desired
					  break;
					case 'postalCodeChanged':
					  // Handle as desired
					  break;
				  }
				},

				paymentFormLoaded: function() {
					  
					}
				}
			});
	</script>
	-->
	<?php
}
?>
<script>
		function return_to_pre_tender (lead_id)
		{
			var current_url = window.location.href;

			var data = {
				lead_id: lead_id
			};

			$.ajax({
				type: "POST",
				url: "<?php echo site_url('lead/return_to_pre_tender'); ?>",
				data: data,
				cache: false,
				success: function(data){
					$("#lead-modal").modal('hide');
					if(current_url.includes("admin/home"))
					{
						$("#tab_3").html('<center><i class="fa fa-refresh fa-spin" style="font-size: 50px; margin-top: 20px; margin-bottom: 20px;"></i></center>');
						load_sales_tab(3);
					}
					if(current_url.includes("lead/list_view"))
					{
						$("#lead_status_main_td_" + lead_id).html("Pre-Tender");
						$("#lead_status_main_td_" + lead_id).css({"color": "#0000FF"});
					}
				}
			});
		}

		function return_to_tendering(lead_id)
		{
			var current_url = window.location.href;

			var data = {
				lead_id: lead_id
			};

			$.ajax({
				type: "POST",
				url: "<?php echo site_url('lead/return_to_tendering'); ?>",
				data: data,
				cache: false,
				success: function(data){
					$("#lead-modal").modal('hide');
					if(current_url.includes("admin/home"))
					{
						$("#tab_2").html('<center><i class="fa fa-refresh fa-spin" style="font-size: 50px; margin-top: 20px; margin-bottom: 20px;"></i></center>');
						load_sales_tab(2);
					}
					if(current_url.includes("lead/list_view"))
					{
						$("#lead_status_main_td_" + lead_id).html("Pre-Tender");
						$("#lead_status_main_td_" + lead_id).css({"color": "#0000FF"});
					}
				}
			});
		}

		function add_payment_action ()
		{
			var admin_fee = "";
			var payment_method = "";
			var final_payment_date = "";
			
			var amount = $("#add-payment-modal").find(".amount_tb").val();

			if(amount == "")
			{
				alert ("Please enter the amount!");
				return false;
			}

			var lead_id            = $("#add-payment-modal").find(".lead_id").val();
			var invoice_id         = $("#add-payment-modal").find(".invoice_number_select").val();				
			var code               = $("#add-payment-modal").find(".payment-type-select option:selected").html();
			var code_id            = $("#add-payment-modal").find(".payment-type-select").val();
			var amount             = parseFloat(amount);
			
			var reference_number   = $.trim($("#add-payment-modal").find(".reference_number").val());
			var payment_date       = $("#add-payment-modal").find(".payment_date").val();
			
			// console.log(payment_date);
			
			var cc_number          = $("#add-payment-modal").find(".credit_card_number_inp").val();
			var credit_card_number = $("#add-payment-modal").find(".credit_card_number_inp").val();
			var first_name         = $("#add-payment-modal").find(".first_name_inp").val();
			var last_name          = $("#add-payment-modal").find(".last_name_inp").val();
			var expiry_month       = $("#add-payment-modal").find(".expiry_month_inp").val();
			var expiry_year        = $("#add-payment-modal").find(".expiry_year_inp").val();
			var cvn                = $("#add-payment-modal").find(".cvn_inp").val();
			var card_type          = $("#add-payment-modal").find(".card_type").val();
			var merchant_cost      = $("#add-payment-modal").find("#merchant_cost").val();
			var bank_account       = $("#add-payment-modal").find(".bank_account").val();

			if(bank_account == "")
			{
				alert ("Please choose a bank account!");
				return false;
			}

			if(code_id == "")
			{
				alert ("Payment Code cannot be blank!");
				return false;
			}

			if(reference_number != '' && cc_number != '')
			{
				alert("You cannot enter a reference number and credit card payment at the same time!");
				return false;
			}

			if(reference_number == '' && cc_number != '')
			{
				if (last_name=="" || first_name=="" || credit_card_number=="" || expiry_month=="" || expiry_year=="" || cvn=="")
				{
					alert("Please complete the required fields!");
					return false;
				}
			}
			else if(reference_number == '' && cc_number == '' && $('input[name="token_id"]:checked').length == 0)
			{
				alert("Please choose a payment method!");
				return false;
			}
			else if(cc_number != '' && $('input[name="token_id"]:checked').length > 0)
			{
				alert("You cannot enter a credit card details and choose a token at the same time!");
				return false;
			}

			var sign              = parseFloat($("#add-payment-modal").find(".payment-type-select option:selected").data("sign"));
			var received_total    = parseFloat($("#balcqo-modal").find(".received_total_td").html());
			var remaining_balance = parseFloat($("#balcqo-modal").find(".remaining_balance_td").html());

			var real_amount           = sign * amount;
			var new_received_total    = received_total + real_amount;
			var new_remaining_balance = remaining_balance - real_amount;
			
			var d           = new Date();
			var curr_date   = d.getDate();
			var curr_month  = d.getMonth() + 1;
			var curr_year   = d.getFullYear();
			var curr_hour   = d.getHours();
			var curr_minute = d.getMinutes();
			var curr_second = d.getSeconds();					
			var time_now    = (curr_year + "-" + pad(curr_month, 2) + "-" + pad(curr_date, 2) + " " + pad(curr_hour, 2) + ":" + pad(curr_minute, 2) + ":" + pad(curr_second, 2));

			var new_date = (curr_year + "-" + pad(curr_month, 2) + "-" + pad(curr_date, 2));
			
			if (reference_number == '')
			{
				payment_method = "Credit Card";
				final_payment_date = new_date;
			}
			else
			{
				payment_method = "External";
				final_payment_date = payment_date;
			}

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

			if(total_invoice_amount > amount)
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
			
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('deal/add_payment'); ?>",
				data: $("#add-payment-modal").find(".main_form").serialize(),
				cache: false,
				dataType: "json",
				success: function(result) {

					if(!result.status)
					{
						alert(result.message);
						return false;
					}

					if(result.reference_number != 0)
					{
						reference_number = result.reference_number;
					}

					alert(result.message);
					
					var user = "<?php echo $name; ?>";

					$("#add-payment-modal").find(".payment-type-select").val("");
					$("#add-payment-modal").find(".payment-method-radio").val("");
					$("#add-payment-modal").find(".amount_tb").val("");
					
					$("#add-payment-modal").find(".reference_number").val("");						
					$("#add-payment-modal").find(".payment_date").val("");

					$("#add-payment-modal").find(".credit_card_number_inp").val("");						
					$("#add-payment-modal").find(".first_name_inp").val("");
					$("#add-payment-modal").find(".last_name_inp").val("");
					$("#add-payment-modal").find(".expiry_month_inp").val("");
					$("#add-payment-modal").find(".expiry_year_inp").val("");
					$("#add-payment-modal").find(".cvn_inp").val("");
					$("#add-payment-modal").find(".card_type").val("");

					$("#balcqo-modal").find("#payment_no_records").remove();
					$("#balcqo-modal").find(".payments_table").append('\
						<tr>\
							<td align="center"></td>\
							<td></td>\
							<td></td>\
							<td></td>\
							<td></td>\
							<td>'+code+'</td>\
							<td>'+payment_method+'</td>\
							<td>'+reference_number+'</td>\
							<td>'+user+'</td>\
							<td>'+real_amount.toFixed(2)+'</td>\
							<td>'+(parseFloat(result.admin_pay)).toFixed(2)+'</td>\
							<td>'+final_payment_date+'</td>\
							<td>0.00</td>\
							<td></td>\
							<td>'+merchant_cost+'</td>\
							<td>Unverified</td>\
							<td>Shown</td>\
						</tr>'
					);
					$("#balcqo-modal").find(".received_total_td").html(new_received_total.toFixed(2));
					$("#balcqo-modal").find(".remaining_balance_td").html(new_remaining_balance.toFixed(2));

					$("#remaining_balance_td_"+lead_id).html(new_remaining_balance.toFixed(2));

					$("#add-payment-modal").find(".invoice_number_select").prop("disabled", true);
					$("#add-payment-modal").find(".amount_tb").prop("disabled", true);
					$("#add-payment-modal").find(".hidden-credit-card").prop("hidden", true);
					$("#add-payment-modal").find(".hidden-reference").prop("hidden", true);
					$("#add-payment-modal").find(".credit-card").closest("div").prop("hidden", true);
					$("#add-payment-modal").find(".reference-number").closest("div").prop("hidden", true);
					$("#add-payment-modal").find(".payment-method-radio").prop("checked", false);

					$("#add-payment-modal").modal("hide");
				}
			});
		}
	
	$(document).ready(function () {

		$(document).on("click", ".invoice_item_radio", function(){
			var this_val = $(this).val();
			var this_modal = $("#add-invoice-item-modal");
			if(this_val == 1){
				$(document).find("#add-invoice-item-modal").find(".invoice_item").each(function(){
					$(this).select2('destroy');
				});
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('lead/get_invoice_item_types'); ?>",
					cache: false,
					success: function(response){
						this_modal.find(".invoice_item:first").html(response);
						$("#add-invoice-item-modal").find(".invoice_item_parent_panel").find(".invoice_item_child_panel").not(":first").remove();
						$("#add-invoice-item-modal").find(".invoice_item_parent_panel").find(".invoice_item_child_panel").find(".invoice_item").select2();
						this_modal.find(".invoice_item_amount").val(0.00);
						this_modal.modal();
					}
				});
			}
		});

		$(document).on("click", ".add_invoice_item", function(){
			$(document).find("#add-invoice-item-modal").find(".invoice_item").each(function(){
				$(this).select2('destroy');
			});
			var parent_panel = $("#add-invoice-item-modal").find(".invoice_item_parent_panel");
			var panel = parent_panel.find(".invoice_item_child_panel:first").clone();
			var id = $("#add-invoice-item-modal").find(".invoice_item_parent_panel").find(".invoice_item_child_panel").length;

			panel.find('.invoice_item').each(function(key, value)
			{
				var input       = $(this);
				var curr_name   = input.attr('name');
				
				var str_index   = curr_name.indexOf("[");
				var str_index_2 = curr_name.indexOf("]");
				var str_index_3 = curr_name.lastIndexOf("]");
				var str_core_1  = curr_name.substring(str_index, str_index_2 + 1);
				var str_core_2  = curr_name.substring(str_index_2 + 1, str_index_3 + 1);
				var new_name    = curr_name.substring(0,str_index);
				str_core_1      = str_core_1.replace(/[0-9]/g, id);
				new_name        = new_name + str_core_1 + str_core_2;

				input.attr('name', new_name);
			});
			panel.find(".invoice_item_amount").val(0.00);
			panel.prepend('<div class="col-md-12">\
							<hr>\
						</div>');
			parent_panel.append(panel);			

			$(document).find("#add-invoice-item-modal").find(".invoice_item").each(function(){
				$(this).select2();
			});
		});

		//sample_submit
		$(document).on("click", ".sample_submit", function(){
			var lead_id    = $(document).find("#lead-modal").find("#lead_id").val();
			var this_modal = $(document).find("#add-invoice-item-modal");
			var invoice_item_amount_array = [];
			var invoice_item_array = [];
			var invoice_item_description_array = [];

			var invoice_item_amount_obj = $(document).find(this_modal).find(".invoice_item_amount");
			var invoice_item_array_obj = $(document).find(this_modal).find(".invoice_item");
			var invoice_item_description_obj = $(document).find(this_modal).find(".invoice_item_description");

			$(invoice_item_amount_obj).each(function(i, v){
				invoice_item_amount_array.push($(this).val());
			});

			$(invoice_item_description_obj).each(function(i, v){
				invoice_item_description_array.push($(this).val());
			});

			$(invoice_item_array_obj).each(function(i, v){
				var empty_array = [""];
				if($(this).val() != null){
					if( $(this).val().length > 0 ){
						invoice_item_array.push($(this).val());
					}
				}else{
					invoice_item_array.push(empty_array);
				}
			});

			var data = {
				invoice_item_amount_array: invoice_item_amount_array,
				invoice_item_description_array: invoice_item_description_array,
				invoice_item_array: invoice_item_array,
				lead_id: lead_id
			};

			
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('lead/sample_submit'); ?>",
				data: data,
				cache: false,
				success: function(response){
					
				}
			});
		});

		$(document).on("change", "#transport", function(data){
			var this_val = $(this).val();

			if(this_val != 3)
			{
				$("#lead-modal").find("#transport_cost_tr").prop("hidden", true);
				$("#lead-modal").find("#transport_cost").val("0.00");
			}
			else
			{
				$("#lead-modal").find("#transport_cost_tr").prop("hidden", false);
			}
		});

		$(document).on("change", ".date_filter_by", function(data){
			var this_val = $(this).val();

			$(document).find(".filter_date_textbox").val("");

			if(this_val == 7)
			{
				$(document).find(".filter_date_textbox").prop("disabled", false);
			}
			else
			{
				$(document).find(".filter_date_textbox").prop("disabled", true);
			}
		});

		var date_filter_val = $(document).find(".date_filter_by").val();

		if(date_filter_val == 7)
		{
			$(document).find(".filter_date_textbox").prop("disabled", false);
		}
		else
		{
			$(document).find(".filter_date_textbox").val("");
			$(document).find(".filter_date_textbox").prop("disabled", true);
		}

		$(document).on("click", ".open-add-payment-lead", function(data){

			var lead_id = $(this).data("id");

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

		$(document).on("change", ".payment-type-select", function(){
			var that = $(this);
			var this_value = that.val();
			var this_sign = that.find(":selected").data("sign");

			if (this_sign == 1)
			{
				$("#add-payment-modal").find(".invoice_number_select").prop("disabled", false);
				$("#add-payment-modal").find(".amount_tb").prop("disabled", false);
				$("#add-payment-modal").find(".hidden-credit-card").prop("hidden", true);
				$("#add-payment-modal").find(".hidden-reference").prop("hidden", true);
				$("#add-payment-modal").find(".credit-card").closest("div").prop("hidden", false);
				$("#add-payment-modal").find(".reference-number").closest("div").prop("hidden", false);
				$("#add-payment-modal").find(".payment-method-radio").prop("checked", false);
				$("#add-payment-modal").find(".invoice_check").prop("disabled", false);

				$("#edit-payment-modal").find(".invoice_check").prop("disabled", false);

				$("#merchant_cost_check").prop("disabled", false);
			}
			else if (this_sign == -1)
			{
				$("#add-payment-modal").find(".invoice_number_select").prop("disabled", true);
				$("#add-payment-modal").find(".amount_tb").prop("disabled", false);
				$("#add-payment-modal").find(".hidden-credit-card").prop("hidden", true);
				$("#add-payment-modal").find(".hidden-reference").prop("hidden", true);
				$("#add-payment-modal").find(".credit-card").closest("div").prop("hidden", true);
				$("#add-payment-modal").find(".reference-number").closest("div").prop("hidden", false);
				$("#add-payment-modal").find(".payment-method-radio").prop("checked", false);
				$("#add-payment-modal").find(".invoice_check").prop("disabled", true);
				$("#add-payment-modal").find(".invoice_amt").prop("disabled", true);

				$("#add-payment-modal").find(".invoice_check").prop("checked", false);

				$("#edit-payment-modal").find(".invoice_check").prop("disabled", true);
				$("#edit-payment-modal").find(".invoice_amt").prop("disabled", true);

				$("#edit-payment-modal").find(".invoice_check").prop("checked", false);

				$("#merchant_cost_check").prop("disabled", true);
				$("#merchant_cost_check").prop("checked", false);
				$("#merchant_cost").val("0.00");
				$("#merchant_cost").prop("disabled", true);
			}
			else
			{
				$("#add-payment-modal").find(".invoice_number_select").prop("disabled", true);
				$("#add-payment-modal").find(".amount_tb").prop("disabled", true);
				$("#add-payment-modal").find(".hidden-credit-card").prop("hidden", true);
				$("#add-payment-modal").find(".hidden-reference").prop("hidden", true);
				$("#add-payment-modal").find(".credit-card").closest("div").prop("hidden", true);
				$("#add-payment-modal").find(".reference-number").closest("div").prop("hidden", true);
				$("#add-payment-modal").find(".payment-method-radio").prop("checked", false);
				$("#add-payment-modal").find(".invoice_check").prop("disabled", false);
				$("#add-payment-modal").find(".invoice_amt").prop("disabled", true);

				$("#edit-payment-modal").find(".invoice_check").prop("disabled", false);
				$("#edit-payment-modal").find(".invoice_amt").prop("disabled", true);
			}
		});

		$(document).on("change", ".payment-method-radio", function(){
			var that = $(this);
			var this_value = that.val();

			if(this_value == 1)
			{
				$("#add-payment-modal").find(".hidden-credit-card").prop("hidden", false);
				$("#add-payment-modal").find(".hidden-reference").prop("hidden", true);
				$("#add-payment-modal").find(".add-payment-btn").prop("disabled", false);
			}
			else
			{
				$("#add-payment-modal").find(".hidden-credit-card").prop("hidden", true);
				$("#add-payment-modal").find(".hidden-reference").prop("hidden", false);
				$("#add-payment-modal").find(".add-payment-btn").prop("disabled", false);
			}
		});

		$(document).on('change', '#merchant_cost_check', function(){
			var this_status = $(this).prop("checked");
			var amount = $("#add-payment-modal").find(".amount_tb").val();
			var sign = $("#add-payment-modal").find(".payment-type-select option:selected").data("sign");
			var temp_cost = 0.00;
			//console.log(sign);
			if(amount == 0.00 || amount == "0.00" || amount == "")
				amount = 0.00;	

			//console.log(amount)
			if(this_status == true && sign == 1){
				$("#merchant_cost").prop("disabled", false);
				temp_cost = 0.3 + (0.0175 * parseFloat(amount));
				$("#merchant_cost").val(temp_cost.toFixed(2));
			}
			else{
				$("#merchant_cost").val("0.00");
				$("#merchant_cost").prop("disabled", true);
			}
		});

		$(document).on('change', '.invoice_check', function(){
			var checked = $(this).prop('checked');
			var amt = $(this).closest("tr").find(".invoice_amt");

			if(checked == true){
				$(amt).prop("disabled", false);
			}else{
				$(amt).prop("disabled", true);
				// $(amt).val("");
			}
		});

		$(document).on('change', '.amount_tb', function(){
			var this_status = $("#add-payment-modal").find("#merchant_cost_check").prop("checked");
			var sign = $("#add-payment-modal").find(".payment-type-select option:selected").data("sign");
			var amount = $(this).val();
			var temp_cost = 0.00;

			if(amount == 0.00 || amount == "0.00" || amount == "")
				amount = 0.00;

			if(this_status == true && sign == 1){
				temp_cost = 0.3 + (0.0175 * parseFloat(amount));
				$("#merchant_cost").val(temp_cost.toFixed(2));
			}
			else{
				$("#merchant_cost").val("0.00");	
			}
		});

		$(document).on('change', '#edit_merchant_cost_check', function(){
			var this_status = $(this).prop("checked");
			var amount = $("#edit-payment-modal").find("#amount").val();
			var sign = $("#edit-payment-modal").find("#fk_payment_type option:selected").data("sign");
			var temp_cost = 0.00;
			
			if(amount == 0.00 || amount == "0.00" || amount == "")
				amount = 0.00;				

			
			if(this_status == true && sign == 1){
				$("#edit_merchant_cost").prop("disabled", false);
				temp_cost = 0.3 + (0.0175 * parseFloat(amount));
				$("#edit_merchant_cost").val(temp_cost.toFixed(2));
			}
			else{
				$("#edit_merchant_cost").val("0.00");
				$("#edit_merchant_cost").prop("disabled", true);
			}
		});

		$(document).on('change', '#amount', function(){
			var this_status = $("#edit-payment-modal").find("#edit_merchant_cost_check").prop("checked");
			var sign = $("#edit-payment-modal").find("#fk_payment_type option:selected").data("sign");
			var amount = $(this).val();
			var temp_cost = 0.00;

			if(amount == 0.00 || amount == "0.00" || amount == "")
				amount = 0.00;

			if(this_status == true && sign == 1){
				temp_cost = 0.3 + (0.0175 * parseFloat(amount));
				$("#edit_merchant_cost").val(temp_cost.toFixed(2));
			}
			else{
				$("#edit_merchant_cost").val("0.00");	
			}
		});

		$(document).on('change', '#delivery_address_map', function() {
			map_delivery_address();
		});
		$(document).on('change', '#state', function() {
			map_delivery_address();
		});
		$(document).on('change', '#postcode', function() {
			map_delivery_address();
		});
		$(document).on('change', '#address', function() {
			map_delivery_address();
		});

		function map_delivery_address ()
		{
			var status        = $(document).find("#delivery_address_map").prop("checked");
			
			var address       = $(document).find("#address").val();
			var postcode      = $(document).find("#postcode").val();
			var state         = $(document).find("#state").val();
			var final_address = address + " " + postcode + " " + state;
			
			if(status == true)
			{
				$(document).find("#delivery_address").val(final_address);
				$(document).find("#delivery_address").prop("readonly", true);
			}
			else
			{
				$(document).find("#delivery_address").prop("readonly", false);
			}
		}

		$(document).on("click",".dealer_email_btn",function(){
			var lead_id      = $(document).find("#lead-modal").find("#lead_id").val();
			var this_modal = $("#email_accountant_modal");
			this_modal.find("#dealer_email_content").code('');
			this_modal.find("#dealer_email_subject").val("");
			this_modal.find("#dealer_email_recipients").val("");
			this_modal.find("#dealer_email_attachment_flag").prop("checked", false);
			
			var data = {
				lead_id: lead_id
			};
			$(this_modal).find("#hidden_images").html("");
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('lead/open_accountant_emailer'); ?>",
				data: data,
				dataType: "json",
				cache: false,
				success: function(data){
					$(this_modal).find("#dealer_email_dropdown").html(data.email_options);
					$(this_modal).find("#show_status").html(data.show_status);
					$(this_modal).modal();
				}
			});

		});

		$(document).on("change","#dealer_email_dropdown",function(){
			var this_modal = $("#email_accountant_modal");
			var lead_id      = $(document).find("#lead-modal").find("#lead_id").val();
			var id = $(this).val();
			var dealer_balance = $(document).find("#dealer_balance").val();
			var data = {
				id: id,
				lead_id: lead_id,
				dealer_balance: dealer_balance
			};
			this_modal.find("#dealer_email_content").code('');
			this_modal.find("#dealer_email_subject").val("");
			this_modal.find("#dealer_email_recipients").val("");

			$.ajax({
				type: "POST",
				url: "<?php echo site_url('lead/get_accountaint_email_template'); ?>",
				cache: false,
				data: data,
				dataType: 'json',
				success: function(data){
					this_modal.find("#dealer_email_content").code(data.content);
					this_modal.find("#dealer_email_subject").val(data.subject);
					this_modal.find("#dealer_email_recipients").val(data.dealer_email);
				}
			});
		});

		$(document).on("click","#dealer_email_send_btn",function(){
			var this_modal = $("#email_accountant_modal");

			var lead_id      = $(document).find("#lead-modal").find("#lead_id").val();
			var email_message = this_modal.find("#dealer_email_content").code();
			var email_subject = this_modal.find("#dealer_email_subject").val();
			var recipients    = this_modal.find("#dealer_email_recipients").val();
			var email_attachment_flag = null;
			var attachment_array = [];

			if( this_modal.find("#dealer_email_attachment_flag").prop("checked") == true )
				email_attachment_flag = 1;
			else
				email_attachment_flag = 0;

			email_message = replaceAll(email_message, '&quot;', '%27');
			email_message = replaceAll(email_message, '&lt;', '%3C');
			email_message = replaceAll(email_message, '&qt;', '%3E');
			email_message = replaceAll(email_message, '&amp;', '%26');
			email_message = replaceAll(email_message, '&', '%26');

			$(document).find("#hidden_images").find(".hidden_image").each(function(){
				var image = $(this).val();

				attachment_array.push(image);
			});

			var data = {
				email_message        : email_message,
				email_subject        : email_subject,
				recipients           : recipients,
				lead_id              : lead_id,
				email_attachment_flag: email_attachment_flag,
				attachment_array     : attachment_array
			};

			$.ajax({
				type: "POST",
				url: "<?php echo site_url("deal/send_dealer_email"); ?>",
				data: data,
				cache: false,
				success: function(result){
					this_modal.modal("hide");
				}
			});
		});

		$(document).find(".dealer_email_uploader").dropzone ({
	        url: '<?php echo site_url('deal/upload_temporary_dealer_email_file/'); ?>',
	        init: function() {
	            this.on("sending", function(file, xhr, formData){
				}),
				this.on("success", function(file, response){
					// var str_end = response.indexOf("<!D");
					// var final_file = response.substring(0, str_end);
					$("#hidden_images").append('<input class="hidden_image" type="hidden" name="email_file[]" value="'+response+'">');
				}),
				this.on("queuecomplete", function () {
				});
			},
		
		});

		$(document).on("click",".email_trail",function(){
			var lead_id   = $(this).data("lead_id");
			var email     = $(this).data("email");
			var qm_number = $(this).data("qm-number");
			var data = {
				lead_id  : lead_id,
				email    : email,
				qm_number: qm_number
			};
			var this_modal = $("#lead_email_modal_gmail");
			$("#lead_email_modal_gmail_body").html("");
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('lead/get_email'); ?>",
				data: data,
				cache: false,
				success: function(data){
					$("#lead_email_modal_gmail_body").html(data);
					$(this_modal).modal();
				}
			});
		});
		
		$(document).on("click",".audit_trail",function(){
			var lead_id = $(this).data("lead_id");
			var data = {
				id: lead_id,
				table_name: 'leads'
			};
			var this_modal = $("#lead_audit_trail_modal");
			$("#lead_audit_trail_modal_body").html("");
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('lead/get_lead_audit_trail'); ?>",
				data: data,
				cache: false,
				success: function(data){
					$("#lead_audit_trail_modal_body").html(data);
					$(this_modal).modal();
				}
			});
		});

		$(document).on("click",".open-audit-trail", function(){
			var quote_id = $("#hidden_quote_id_sub").val();
			var this_modal = $("#audit_trail");
			var data = {
				quote_id: quote_id
			}
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("user/get_quote_audit_trail"); ?>",
				cache: false,
				data: data,
				success: function(data){
					$("#audit_body").html(data);

					$(this_modal).modal();
				}
			});
		});

		$(document).on("click",".open-quote", function(){
			var this_modal = $("#addquote-modal-request");
			var this_id    = $(this).data("quote_request_id");
			var type       = $(this).data("type");
			var dealer_id  = $(this).data("dealer_id");

			if (type == "New")
			{
				type = 1;
			}
			else
			{
				type = 2;
			}

			var data = {
				this_id: this_id,
				type   : type,
				dealer_id: dealer_id
			};

			$(this_modal).find("#hidden_dealer_id").val(dealer_id);
			$(this_modal).find("#retail_price").val(0);
			$(this_modal).find("#fleet_discount").val(0);
			$(this_modal).find("#dealer_discount").val(0);
			$(this_modal).find("#predelivery").val(0);
			$(this_modal).find("#gst").val(0);
			$(this_modal).find("#luxury_tax").val(0);
			$(this_modal).find("#ctp").val(0);
			$(this_modal).find("#registration").val(0);
			$(this_modal).find("#premium_plate_fee").val(0);
			$(this_modal).find("#stamp_duty").val(0);
			$(this_modal).find("#total").val(0);
			$(this_modal).find("#delivery_date").val('');
			$(this_modal).find("#compliance_date").val('');
			$(this_modal).find("#notes").val('');
			$(this_modal).find("#kms").val('');
			$(this_modal).find("#vin").val('');
			$(this_modal).find("#engine").val('');
			$(this_modal).find("#registration_expiry").val('');
			$(this_modal).find("#registration_plate").val('');
			$(this_modal).find("#dealer_tradein_value").val('');
			$(this_modal).find("#dealer_changeover").val(0);
			$(this_modal).find("#subtotal_1").val(0);
			$(this_modal).find("#subtotal_2").val(0);
			$(this_modal).find("#subtotal_3").val(0);

			$(this_modal).find("#dealer_tradein_payout").val(0);
			$(this_modal).find("#dealer_client_refund").val(0);
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("user/open_edit_quotation"); ?>",
				cache: false,
				data: data,
				dataType: 'json',
				success: function(data){
					$(this_modal).find("#hidden_process").val(data.process_type);
					$(this_modal).find("#hidden_quote_request_id").val(this_id);

					$(this_modal).find("#hidden_quote_request_lead_id").val(data.lead_id);

					if(data.type == 1)
					{
						$(this_modal).find("#kms_tr").hide();
						$(this_modal).find("#demo").val("New");
					}
					else
					{
						$(this_modal).find("#kms_tr").show();
						$(this_modal).find("#demo").val("Demo");
					}

					$(this_modal).find("#title").html(data.title);
					$(this_modal).find("#options_dom").html(data.option_string);
					$(this_modal).find("#accessories_dom").html(data.accessories_string);
					$(this_modal).find("#make").text(data.make);
					$(this_modal).find("#model").text(data.model);
					$(this_modal).find("#variant").text(data.variant);
					$(this_modal).find("#build_date").text(data.build_date);
					$(this_modal).find("#series").text(data.series);
					$(this_modal).find("#body_type").text(data.body_type);
					$(this_modal).find("#transmission").text(data.transmission);
					$(this_modal).find("#fuel_type").text(data.fuel_type);
					$(this_modal).find("#colour").text(data.colour);
					$(this_modal).find("#registration_type").text(data.registration_type);
					$(this_modal).find("#hidden_registration_type").val(data.registration_type);

					$(this_modal).find("#transport_checkbox").prop("checked", false);

					if(data.visibility == "hidden")
					{
						$("#checkbox_tbl").prop('hidden', true);
					}
					else
					{
						$("#checkbox_tbl").prop('hidden', false);
					}

					if(data.process_type === "update")
					{
						$(this_modal).find("#hidden_quote_id_sub").val(data.id_quote);
						$(this_modal).find("#retail_price").val(data.retail_price);
						$(this_modal).find("#fleet_discount").val(data.fleet_discount);
						$(this_modal).find("#dealer_discount").val(data.dealer_discount);
						$(this_modal).find("#predelivery").val(data.predelivery);
						$(this_modal).find("#gst").val(data.gst);
						$(this_modal).find("#luxury_tax").val(data.luxury_tax);
						$(this_modal).find("#ctp").val(data.ctp);
						$(this_modal).find("#registration").val(data.registration);
						$(this_modal).find("#premium_plate_fee").val(data.premium_plate_fee);
						$(this_modal).find("#stamp_duty").val(data.stamp_duty);
						$(this_modal).find("#total").val(data.total);
						$(this_modal).find("#delivery_date").val(data.delivery_date);
						$(this_modal).find("#compliance_date").val(data.compliance_date);
						$(this_modal).find("#notes").val(data.notes);
						$(this_modal).find("#kms").val(data.kms);
						$(this_modal).find("#vin").val(data.vin);
						$(this_modal).find("#engine").val(data.engine);
						$(this_modal).find("#registration_expiry").val(data.registration_expiry);
						$(this_modal).find("#registration_plate").val(data.registration_plate);
						$(this_modal).find("#dealer_tradein_value").val(data.dealer_tradein_value);

						$(this_modal).find("#dealer_tradein_payout").val(data.dealer_tradein_payout);
						$(this_modal).find("#dealer_client_refund").val(data.dealer_client_refund);
						$(this_modal).find("#metallic_paint").val(data.metallic_paint);

						if(data.transport_checkbox == "Yes")
						{
							$(this_modal).find("#transport_checkbox").prop("checked", true);
						}
						else
						{
							$(this_modal).find("#transport_checkbox").prop("checked", false);
						}
						calculate_quote_new('#addquote-modal-request')
					}
					$(this_modal).modal();
				}
			});
		});
	});

	function submit_new_edit_quote()
	{
		var data = $("#addquote-modal-form").serialize();

		$.ajax({
			type: "POST",
			url: "<?php echo site_url("user/send_quotation"); ?>",
			cache: false,
			data: data,
			success: function(data){
				$("#addquote-modal-request").modal('hide');
			}
		});
	}

	function delete_deposit_lead (payment_id)
	{
		if( confirm("Are you sure you want to delete this deposit record?") )
		{
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('deal/delete_payment'); ?>/"+payment_id,
				cache: false,
				success: function(result) {
					$("#lead-modal").find("#tr_payment_"+payment_id).remove();
				}
			});
		}
	}

	$(document).ready(function()
	{
		$(document).on('click', '.open-quote-old', function(data)
		{
			var quote_id = $(this).data('quote_id');
			$.post('<?php echo site_url("user/quotation"); ?>/' + quote_id, function(data)
			{
				$('#quote-modal').find('.quote').html(data.quotation);
				$('#quote-modal').modal();
			}, 'json');
		});	
	});

	$(document).on("click", ".open-sendorderpdf", function(data)
	{
		var lead_id = $(this).data("lead_id");
		$.post("<?php echo site_url("deal/order_recipients"); ?>/" + lead_id, function(data)
		{
			$("#sendorderpdf-modal").find("#lead_id").val(lead_id);
			$("#sendorderpdf-modal").find("#user_type").val("");
			$("#sendorderpdf-modal").find("#email").val("");
			$("#sendorderpdf-modal").find("#order_recipients").html(data.order_recipients);
			$("#sendorderpdf-modal").find("#client_email").val(data.client_email);
			$("#sendorderpdf-modal").find("#dealer_email").val(data.dealer_email);
			$("#sendorderpdf-modal").modal();
		}, "json");
	});

	$(document).on("click", ".open-clientconfirmation", function(data)
	{
		var lead_id = $(this).data("lead_id");
		$.post("<?php echo site_url("deal/order_confirmation_recipients"); ?>/" + lead_id, function(data)
		{
			$("#send-clientconfirmation-modal").find("#lead_id").val(lead_id);
			
			$("#send-clientconfirmation-modal").find("#email").val(data.client_email);
			$("#send-clientconfirmation-modal").find("#client_email").val(data.client_email);

			$("#send-clientconfirmation-modal").find("#order_recipients").html(data.order_recipients);
			$("#send-clientconfirmation-modal").modal();
		}, "json");
	});

	function load_email (user_type)
	{
		var email = "";

		if (user_type == 1)
		{
			email = $("#sendorderpdf-modal").find("#client_email").val();
		}
		else if (user_type == 2)
		{
			email = $("#sendorderpdf-modal").find("#dealer_email").val();
		}

		$("#sendorderpdf-modal").find("#email").val(email);
	}
	
	function send_order_pdf ()
	{
		var lead_id = $("#sendorderpdf-modal").find("#lead_id").val();
		var email = $("#sendorderpdf-modal").find("#email").val();
		var user_type = $("#sendorderpdf-modal").find("#user_type").val();

		var d = new Date();
		var curr_date = d.getDate();
		var curr_month = d.getMonth() + 1;
		var curr_year = d.getFullYear();
		var curr_hour = d.getHours();
		var curr_minute = d.getMinutes();
		var curr_second = d.getSeconds();	
		var date_now = (curr_year + "-" + pad(curr_month, 2) + "-" + pad(curr_date, 2));

		var dataString = "&email="+email+"&lead_id="+lead_id+"&user_type="+user_type;
		if (email.length == 0 | user_type === "") 
		{
			alert ("Please complete all the fields!");
		}
		else
		{
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("deal/add_order_recipient"); ?>" + "/" + lead_id + "/",
				data: dataString,
				cache: false,
				success: function(result){
					$("#sendorderpdf-modal").find("#email").val("");
					$("#sendorderpdf-modal").find("#no_record").remove();
					$("#sendorderpdf-modal").find("#order_recipients").append("<tr><td>"+email+"</td><td></td><td></td><td>"+date_now+"</td></tr>");
				}
			});
		}
	}

	function send_clientconfirmation_email ()
	{
		var modal = $("#send-clientconfirmation-modal");

		var lead_id = modal.find("#lead_id").val();
		var email = modal.find("#email").val();

		var d = new Date();
		var curr_date = d.getDate();
		var curr_month = d.getMonth() + 1;
		var curr_year = d.getFullYear();
		var curr_hour = d.getHours();
		var curr_minute = d.getMinutes();
		var curr_second = d.getSeconds();	
		var date_now = (curr_year + "-" + pad(curr_month, 2) + "-" + pad(curr_date, 2));

		var dataString = "&email="+email+"&lead_id="+lead_id;
		if (email.length == 0 | user_type === "") 
		{
			alert ("Please complete all the fields!");
		}
		else
		{
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("deal/send_confirmation_email"); ?>" + "/" + lead_id + "/",
				data: dataString,
				cache: false,
				success: function(result){
					modal.find("#email").val("");
					modal.find("#no_record").remove();
					modal.find("#order_recipients").append("<tr><td>"+email+"</td><td></td><td>"+date_now+"</td></tr>");
				}
			});
		}
	}

	$(document).on("click", "#add_acc_btn", function(){
		var lead_id = $(this).data("leadid");
		
		var data = {
			lead_id: lead_id
		}

		$("#add_acc_table_body").html("");

		$.ajax({
			type: "POST",
			url: "<?php echo site_url("lead/get_all_accessories"); ?>",
			data: data,
			cache: false,
			success: function(result){
				$("#add_acc_table_body").html(result);
				$(document).find(".acc_check").prop("checked", false);
				$("#add_accessory_modal").modal();	
			}
		});
	});

	$(document).on("click", "#acc_btn_confirm", function(){
		var id_arr       = [];
		var supplier_arr = [];
		var code_arr     = [];
		var name_arr     = [];
		var cost_arr     = [];
		var lead_id      = $(document).find("#lead-modal").find("#lead_id").val();

		$(document).find(".acc_check").each(function(index, value){
			var id = $(this).val();
			
			if($(this).prop("checked") == true)
			{
				id_arr.push(id);
				supplier_arr.push($(this).closest("tr").data("supplier"));
				code_arr.push($(this).closest("tr").data("code"));
				name_arr.push($(this).closest("tr").data("name"));
				cost_arr.push($(this).closest("tr").data("cost"));
			}
		});

		var data = {
			id_arr: id_arr,
			lead_id: lead_id
		};

		$.ajax({
			type: "POST",
			url: "<?php echo site_url("lead/insert_lead_accessory"); ?>",
			data: data,
			dataType: 'json',
			cache: false,
			success: function(data){
				if(data.length > 0)
					$(document).find("#accessory_no_record").remove();

				var i;
				var html = ""; 
				for(i in data){
					html += '<tr id="acc_tr_id_'+data[i]+'" data-idacc="'+data[i]+'">\
									<td><a href="#" class="del_lead_acc" data-idacc="'+data[i]+'"><i class="fa fa-trash-o"></i></a></td>\
									<td>'+supplier_arr[i]+'</td>\
									<td>'+code_arr[i]+'</td>\
									<td>'+name_arr[i]+'</td>\
									<td>'+cost_arr[i]+'</td>\
									<td>\
										<input value="0.00" class="form-control input-sm acc_price" type="text" name="deal_accessory_price['+data[i]+']" onkeypress="return isNumberKey(event)" style="text-align: right !important;">\
									</td>\
									<td>\
										<input value="1" class="form-control input-sm acc_quantity" type="text" name="deal_accessory_quantity['+data[i]+']" onkeypress="return isNumberKey(event)" style="text-align: right !important;">\
									</td>\
									<td>\
										<input value="0.00" class="form-control input-sm total_price" type="text" name="total_price" onkeypress="return isNumberKey(event)" readonly style="text-align: right !important;">\
									</td>\
								</tr>';
				}

				$(document).find("#lead_accessory_table_body").append(html);

				$('#add_accessory_modal').modal("hide");
			}
		});

	});

	$(document).on("click", "#update_lead_acc_btn", function(){
		var id_arr       = [];
		var quantity_arr = [];
		var price_arr    = [];
		var lead_id      = $(document).find("#lead-modal").find("#lead_id").val();
		var acc_spec_con = $(document).find("#accessory_special_conditions").val();
		var acc_job_date = $(document).find("#accessory_job_date").val();
		var acc_status = 0;

		if($(document).find("#accessory_status").prop("checked") == true)
			acc_status = 1;

		$(document).find(".acc_quantity").each(function(index, value){
			var quantity    = $(this).val();
			var price       = $(this).closest("tr").find(".acc_price").val();
			var id_deal_acc = $(this).closest("tr").data("idacc");

			id_arr.push(id_deal_acc);
			quantity_arr.push(quantity);
			price_arr.push(price);
		});

		var data = {
			id_arr      : id_arr,
			quantity_arr: quantity_arr,
			price_arr   : price_arr,
			lead_id     : lead_id,
			acc_spec_con: acc_spec_con,
			acc_job_date: acc_job_date,
			acc_status  : acc_status
		};

		$.ajax({
			type: "POST",
			url: "<?php echo site_url("lead/update_lead_accessory"); ?>",
			data: data,
			cache: false,
			success: function(result){
				if(result === "success")
					alert("Update Successful!");
				else
					alert("Update Failed!");
			}
		});

	});

	$(document).on("change", ".acc_price", function(){
		var this_row          = $(this).closest("tr");
		var total_price_field = this_row.find(".total_price");
		var price             = parseFloat($(this).val());
		var qty               = parseInt(this_row.find(".acc_quantity").val());
		var total_price       = 0.00;
		total_price           = price * qty;

		var total_cost_field = this_row.find('.hidden_total_cost');
		var cost = this_row.find(".supplier_price_td").text();
		var total_cost = 0.00

		total_cost = parseInt(cost) * qty;

		$(total_cost_field).val( (parseFloat(total_cost)).toFixed(2) );

		$(total_price_field).val((parseFloat(total_price)).toFixed(2));

		lead_compute_total_price_revenue();
	});

	$(document).on("change", ".acc_quantity", function(){
		var this_row          = $(this).closest("tr");
		var total_price_field = this_row.find(".total_price");
		var qty               = parseFloat($(this).val());
		var price             = parseInt(this_row.find(".acc_price").val());
		var total_price       = 0.00;
		total_price = price * qty;

		var total_cost_field = this_row.find('.hidden_total_cost');
		var cost = $(this_row).find(".supplier_price_td").text();
		var total_cost = 0.00

		total_cost = parseInt(cost) * qty;


		$(total_cost_field).val( (parseFloat(total_cost)).toFixed(2) );

		$(total_price_field).val( (parseFloat(total_price)).toFixed(2) );

		lead_compute_total_price_revenue();
	});

	$(document).on("click", ".del_lead_acc", function(){
		var id_acc = $(this).data("idacc");
		var this_row = $(this).closest("tr");
		var data = {
			id_acc: id_acc
		};

		if(confirm("Are you sure you want to delete this accessory?"))
		{
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("lead/delete_lead_accessory"); ?>",
				data: data,
				cache: false,
				success: function(result){
					if(result === "success"){
						this_row.remove();
						lead_compute_total_price_revenue();
					}
					else
						alert("Accessory deletion failed!");
				}
			});
		}
		else
		{
			return false;
		}
	});

	function lead_compute_total_price_revenue ()
	{
		var total_price_obj = $("#lead-modal").find(".total_price");
		var cost_obj        = $("#lead-modal").find(".hidden_total_cost");
		var total_price     = 0.00;
		var total_cost      = 0.00;
		var total_revenue   = 0.00;

		$(total_price_obj).each(function(index, value){
			var temp_val = parseFloat($(this).val());
			total_price = total_price + temp_val;
		});

		$(cost_obj).each(function(index, value){
			var temp_val = parseFloat($(this).val());
			total_cost = total_cost + temp_val;
		});

		total_revenue = parseInt(total_price) - parseInt(total_cost);
		total_revenue = (parseFloat(total_revenue)).toFixed(2);

		$(document).find("#lead_total_deal_accessory_price").text((parseFloat(total_price)).toFixed(2));
		$(document).find("#lead_total_revenue").text(total_revenue);
	}

	$(document).on("click", "#lead_add_new_accessory_btn", function(){
		
		$.ajax({
			type: "POST",
			url: "<?php echo site_url("accessory/initialize_create_accessory_modal"); ?>",
			data: {},
			dataType: 'json',
			cache: false,
			success: function(data){
				$("#fk_accessory_supplier").html(data.suppliers_html);

				$("#add_new_accessory_modal").modal();
			}
		});
	});

	$(document).on("click", "#add_new_accessory_confirm", function(){
		var form = $(".add_new_accessory_form").serialize();

		if($("#fk_accessory_supplier").val() == ""){
			alert("Please choose an accessory supplier!");
			return false;
		}

		$.ajax({
			type: "POST",
			url: "<?php echo site_url("accessory/insert_new_accessory"); ?>",
			data: form,
			cache: false,
			success: function(response){
				$("#add_acc_table_body").append(response);
				$("#add_new_accessory_modal").modal("hide");
			}
		});
	});

	$(document).on("click", "#add_new_accessory_supplier_confirm", function(){
		var form = $(".add_new_accessory_supplier_form").serialize();

		$.ajax({
			type: "POST",
			url: "<?php echo site_url("accessory/insert_new_accessory_supplier"); ?>",
			data: form,
			cache: false,
			success: function(response){
				$("#fk_accessory_supplier").append(response);
				$("#add_new_supplier_modal").modal("hide");
			}
		});
	});

	$(document).on("click", "#lead_add_new_supplier", function(){
		$("#add_new_supplier_modal").modal();
	});

	//lead modal
	$(document).on("click", ".open-lead-details", function(data){
		var lead_id = $(this).data("lead_id");
		$.post("<?php echo site_url("lead/record"); ?>/" + lead_id, function(data)
		{
			$('.full_loader').hide();

			$('#lead-modal').find('#lead_status_id').val(data.status_id);
			$('#lead-modal').find('#lead_status').html('('+data.status+')');
			$('#lead-modal').find('#lead_id').val(data.id_lead);
			$('#lead-modal').find('#lead_cq_number').html(data.cq_number);
			$('#lead-modal').find('#lead_name').html(data.name);
			$('#lead-modal').find('#lead_email').html('<a href="mailto:'+data.email+'" target="_top">'+data.email+'</a>');
			$('#lead-modal').find('#lead_email_value').val(data.email);
			$('#lead-modal').find('#lead_mobile').html(data.mobile);
			$('#lead-modal').find('#lead_phone').html(data.phone);
			$('#lead-modal').find('#lead_state').html(data.state);
			$('#lead-modal').find('#lead_postcode').html(data.postcode);
			$('#lead-modal').find('#lead_make').html(data.make);
			$('#lead-modal').find('#lead_model').html(data.model);
			$('#lead-modal').find('#lead_details').val(data.details);
			$('#lead-modal').find('#lead_created_at').html(data.created_at);

			$('#lead-modal').find('#lead_admin_section').html(data.admin_section);
			$('#lead-modal').find('#lead_client_details').html(data.client_details);
			$('#lead-modal').find('#lead_tradein_details').html(data.tradein_details);
			$('#lead-modal').find('#lead_quote_request_details').html(data.quote_request_details);
			$('#lead-modal').find('#lead_winning_quote_details').html(data.winning_quote_details);

			$('#lead-modal').find('#lead_accessories_details').html(data.accessory_details);

			$('#lead-modal').find('#lead_calculation_details').html(data.calculation_details);
			$('#lead-modal').find('#lead_delivery_details').html(data.delivery_details);
			$('#lead-modal').find('#lead_settlement_details').html(data.settlement_details);

			$('#lead-modal').find('#lead_actions_history').html(data.actions_history);
			$('#lead-modal').find('#lead_stage_history').html(data.stage_history);
			$('#lead-modal').find('#lead_comments').html(data.comments);
			$('#lead-modal').find('#lead_email_actions').html(data.email_actions);
			$('#lead-modal').find('#lead_actions').html(data.actions);

			$('#lead-modal').find('#attachment_table_id').html(data.files_table);

			$('#lead-modal').find('#dealer_table').html(data.dealer_files_table);

			$('#lead-modal').find('#tradein_document_row').html(data.tradein_documents);


			if($("#lead-modal").find("#transport").val() == 3)
				$("#lead-modal").find("#transport_cost_tr").prop("hidden", false);
			else
				$("#lead-modal").find("#transport_cost_tr").prop("hidden", true);
		
			var curr_doc = "";

			$(document).on('click', '.documents', function(){
				$(document).find("#tradein_doc_hidden_val").val($(this).data("doc"));
				$(document).find("#tradein_id_hidden").val($(this).data("tradein_id"));
				curr_doc = $(this);
			});

			$(document).find('.documents').dropzone ({
		        url: '<?php echo site_url('lead/upload_tradein_documents/'); ?>',
		        init: function() {
		            this.on("sending", function(file, xhr, formData){
						var lead_id = $('#tradein_id_hidden').val();
						var doc_id  = $("#tradein_doc_hidden_val").val();
						
						formData.append("lead_id", lead_id);
						formData.append("doc_id", doc_id);
					}),
					this.on("success", function(file, response){

						if(!curr_doc.hasClass("documents_green"))
							curr_doc.addClass("documents_green");
						
					}),
					this.on("queuecomplete", function () {
					    this.removeAllFiles();
					});
				},
			});
			$('#lead-modal').modal();
		}, 'json');
	});

	$(document).on("click", ".wh", function(){

		var $this = $(this);
		var this_id = $this.data("tradein_id");

		$("#wh_modal_id").val(this_id);

		var data = {
			this_id: this_id
		};

		$.ajax({
			type: "POST",
			url: "<?php echo site_url("lead/get_trade_checklist"); ?>",
			cache: false,
			data: data,
			dataType: 'json',
			success: function(data){
				
				$("#wh_modal").find("#pickup_date").val(data.tradein_result.pickup_date);
				$("#wh_modal").find("#pickup_time").val(data.tradein_result.pickup_time);
				$("#wh_modal").find("#contact_name").val(data.tradein_result.contact_name);
				$("#wh_modal").find("#contact_number").val(data.tradein_result.contact_number);
				$("#wh_modal").find('input[name="trans_flag"][value="' + data.tradein_result.trans_flag + '"]').prop('checked', true);

				if(data.tradein_result.trans_flag == 1)
				{
					$("#wh_modal").find(".hidden_div").prop('hidden', false);
				}
				else
				{
					$("#wh_modal").find(".hidden_div").prop('hidden', true);	
				}

				$("#wh_modal").find("#transport_company").val(data.tradein_result.transport_company);
				$("#wh_modal").find("#transport_contact_number").val(data.tradein_result.transport_contact_num);
				$("#wh_modal").find("#cost_of_transport").val(data.tradein_result.cost_of_transport);
				$("#wh_modal").find("#booking_made").val(data.tradein_result.booking_made);
				$("#wh_modal").find("#booking_ref_number").val(data.tradein_result.book_ref_number);
				$("#wh_modal").find("#tradein_buyer").html(data.user_select);

				$("#wh_modal").modal('show');
			}
		});

	});

	$(document).on("click", ".trans_flag", function(){
		var that = $(this);
		if(that.val() == 1)
		{
			$(".hidden_div").prop("hidden", false);
		}
		else if(that.val() == 0)
		{
			$(".hidden_div").prop("hidden",true);
		}
	});

	$(document).on('click', '.save_wh', function() {
		var data = $("#trade_cl_form").serialize();
		$.ajax({
			type: "POST",
			url: "<?php echo site_url("lead/save_checklist"); ?>",
			cache: false,
			data: data,
			success: function(data){
				$("#wh_modal").modal('hide');
			}
		});
	});

    $(document).on('click', '.tradein_doc_button', function() {

		var tradein_id = $(this).data("tradein_id");
		var doc_id     = $(this).closest(".tradein-doc-panel").data("doc");
		var modal_name = $(this).closest('.row').find('.tradein_doc_name').text();
		
		var data = {
				tradein_id: tradein_id,
				doc_id    : doc_id,
					};

    	$.ajax({
			type: "POST",
			url: "<?php echo site_url("lead/get_specific_tradein_documents"); ?>",
			cache: false,
			data: data,
			dataType: 'json',
			success: function(data){

				$('#tradein_documents_modal').find('.modal-title').text(modal_name);
				
				if($.trim(data.doc_list) == "")
				{
					$(document).find("#tradein_doc_modal_body").html("<i>You have not uploaded anything yet...</i>");
				}
				else
				{
					$(document).find("#tradein_doc_modal_body").html(data.doc_list);
				}

				$('#tradein_documents_modal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
			}
		});
		
    });

    $(document).on('click', '.del_doc', function() {
		var that           = $(this);
		var id_doc         = that.closest(".tr_doc").data("id-doc");
		var abspath        = that.closest(".tr_doc").data("abspath");

		var data = {
				id_doc        : id_doc,
				abspath       : abspath
					};

		if(confirm("Are you sure you want to delete this document?"))
		{
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("lead/delete_tradein_document"); ?>",
				cache: false,
				data: data,
				success: function(response){
					if($.trim(response) == "success")
					{
						that.closest(".tr_doc").remove();
					}
				}
			});
		}
    });

	$(document).ready(function(){
		$(document).on("click", ".add-deposit", function(data) // NEW
		{
			modal_flag = 2;
			var type = $(this).data("type");
			var lead_id = $(this).data("id");
			var data = {
				lead_id: lead_id,
				type: type
			};

			$(".deposit_method").prop("checked", false);
			$(".squareup_auth").prop("disabled", true);
			$(".add_deposit").prop("disabled", true);
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("lead/additional_deposit"); ?>",
				cache: false,
				data: data,
				dataType: 'json',
				success: function(data){
					$("#add-dep-modal").find(".form-control").each(function(){
						$(this).val("");
					});
					$("#add-dep-modal").find(".code").val(type);
					$("#add-dep-modal").find(".lead_id").val(lead_id);
					$("#add-dep-modal").find(".deposits").html(data.deposits);
					$("#add-dep-modal").find(".actions").html(data.actions);
					$("#add-dep-modal").modal();
				}
			});
		});

		$(document).on("change",".deposit_method", function(){
			var that = $(this);
			var this_value = that.val();
			if(this_value == 1)
			{
				$(".hidden-credit-card").prop("hidden", false);
				$(".hidden-reference").prop("hidden", true);
				$(".hidden-squareup-card").prop("hidden", true);

				$(".add_deposit").prop("disabled", false);
				$(".squareup_auth").prop("disabled", true);
			}
			if(this_value == 3)
			{
				$(".hidden-credit-card").prop("hidden", true);
				$(".hidden-reference").prop("hidden", true);
				$(".hidden-squareup-card").prop("hidden", false);

				$(".add_deposit").prop("disabled", true);
				$(".squareup_auth").prop("disabled", false);
			}
			else
			{
				$(".hidden-credit-card").prop("hidden", true);
				$(".hidden-reference").prop("hidden", false);
				$(".hidden-squareup-card").prop("hidden", true);

				$(".add_deposit").prop("disabled", false);
				$(".squareup_auth").prop("disabled", true);
			}
		});
	});

	$(document).on("click",".squareup_auth", function(){
		paymentForm.requestCardNonce();	
	});

	$(document).on('click','.add_deposit',function()
	{
		var amount = $("#add-dep-modal").find(".amount_inp").val();
		var bank_account = $("#add-dep-modal").find(".bank_account").val();

		if(amount == "")
		{
			alert ("Amount cannot be blank!");
			return false;
		}

		if(bank_account == "")
		{
			alert ("Please choose a bank account!");
			return false;
		}

		var lead_id            = $("#add-dep-modal").find(".lead_id").val();
		var reference_number   = $.trim($("#add-dep-modal").find(".reference_number").val());
		amount                 = parseFloat(amount);
		var cc_number          = $(".credit_card_number_inp").val();
		
		var first_name         = $("#add-dep-modal").find(".first_name_inp").val();
		var last_name          = $("#add-dep-modal").find(".last_name_inp").val();
		var credit_card_number = $("#add-dep-modal").find(".credit_card_number_inp").val();
		var expiry_month       = $("#add-dep-modal").find(".expiry_month_inp").val();
		var expiry_year        = $("#add-dep-modal").find(".expiry_year_inp").val();
		var cvn                = $("#add-dep-modal").find(".cvn_inp").val();
		var card_type          = $("#add-dep-modal").find(".card_type").val();
		var payment_date       = "<?php echo date("Y-m-d"); ?>";

		var that = $(this);

		if(reference_number != '' && cc_number != '')
		{
			alert("You cannot enter a reference number and credit car payment at the same time!");
			return false;
		}

		if(reference_number == '' && cc_number != '')
		{
			if (last_name=="" || first_name=="" || credit_card_number=="" || expiry_month=="" || expiry_year=="" || cvn=="")
			{
				alert("Please complete the required fields!");
				return false;
			}
		}
		else if (reference_number != '' && cc_number == '')
		{

		}

		var d           = new Date();
		var curr_date   = d.getDate();
		var curr_month  = d.getMonth() + 1;
		var curr_year   = d.getFullYear();
		var curr_hour   = d.getHours();
		var curr_minute = d.getMinutes();
		var curr_second = d.getSeconds();					
		var time_now    = (curr_year + "-" + pad(curr_month, 2) + "-" + pad(curr_date, 2) + " " + pad(curr_hour, 2) + ":" + pad(curr_minute, 2) + ":" + pad(curr_second, 2));

		that.prop('disabled', true);

		var nonce = $("#add-dep-modal").find("#card-nonce").val();
		var status = "Unverified";

		if(nonce != "")
			status = "Verified";
		
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('deal/add_payment'); ?>",
			data: $("#add-dep-modal").find(".main_form").serialize(),
			cache: false,
			dataType: 'json',
			success: function(result) {
				

				that.prop('disabled', false);
				if(!result.status)
				{
					alert(result.message);
					return false;
				}

				if(result.reference_number != 0)
				{
					reference_number = result.reference_number;
				}

				alert(result.message);

				var name = "<?= $this->session->userdata('name') ?>";

				$("#add-dep-modal").find(".code_inp").val("");
				$("#add-dep-modal").find(".reference_number").val("");
				$("#add-dep-modal").find(".amount_inp").val("");
				$("#add-dep-modal").find(".tr-no-results").remove();
				$("#add-dep-modal").find(".deposits").append('<tr><td></td><td></td><td></td><td>DEP</td><td>'+reference_number+'</td><td>'+amount.toFixed(2)+'</td><td>'+name+'</td><td>'+payment_date+'</td><td>'+(parseFloat(result.admin_pay)).toFixed(2)+'</td><td></td><td></td><td>0.00</td><td>'+status+'</td><td>'+time_now+'</td></tr>');

				$("#add-dep-modal").find(".first_name_inp").val("");
				$("#add-dep-modal").find(".last_name_inp").val("");
				$("#add-dep-modal").find(".credit_card_number_inp").val("");
				$("#add-dep-modal").find(".expiry_month_inp").val("");
				$("#add-dep-modal").find(".expiry_year_inp").val("");
				$("#add-dep-modal").find(".cvn_inp").val("");
				$("#add-dep-modal").find(".card_type").val("");
				$("#add-dep-modal").find(".payment_date").val("");
				$("#add-dep-modal").find(".optional_ad_fee").val("");
				$("#add-dep-modal").find(".payment_remarks").val("");
			}
		});
		
	});

	$(document).on('click', '.payment_date', function () {
        $(this).toggleClass('clicked').datepicker().datepicker('show')
    });

	function calculate_deal ()
	{
		// Constant Values //
		var lct_fuel_efficient_value =  75526;
		var lct_other_vehicles_value =  64132;
		var luxury_tax_rate = 0.33;

		// Calculated Values //
		var lct_threshold = 64132; // Default Threshold (If Fuel Efficiency is not filled up)		
		var lct = 0;		
		var stamp_duty = 0;
		
		var rrp = 0;
		var subtotal_1 = 0;
		var subtotal_2 = 0;
		var subtotal_3 = 0;
		var subtotal_4 = 0;
		var gst = 0;
		var balance = 0;
		var sales_price = 0;		
		
		var price_difference = 0;
		var changeover = 0;
		var revenue = 0;
		var commissionable_gross = 0;

		var membership = parseFloat(($("#invoice-generator-modal").find("#membership").val() != '') ? $("#invoice-generator-modal").find("#membership").val() : 0);
		var dqp = parseFloat(($("#invoice-generator-modal").find("#dqp").val() != '') ? $("#invoice-generator-modal").find("#dqp").val() : 0);
		var dealer_tradein_count = parseFloat(($("#invoice-generator-modal").find("#dealer_tradein_count").val() != '') ? $("#invoice-generator-modal").find("#dealer_tradein_count").val() : 0);
		var dealer_tradein_value = parseFloat(($("#invoice-generator-modal").find("#dealer_tradein_value").val() != '') ? $("#invoice-generator-modal").find("#dealer_tradein_value").val() : 0);
		var dealer_changeover = parseFloat(($("#invoice-generator-modal").find("#dealer_changeover").val() != '') ? $("#invoice-generator-modal").find("#dealer_changeover").val() : 0);

		var client_state = $("#invoice-generator-modal").find("#client_state").val();
		var dealer_state = $("#invoice-generator-modal").find("#dealer_state").val();
		var registration_type = $("#invoice-generator-modal").find("#registration_type").val();
		var fuel_efficient_flag = $("#invoice-generator-modal").find("#fuel_efficient_flag").val();

		var list_price = parseFloat(($("#invoice-generator-modal").find("#list_price").val() != '') ? $("#invoice-generator-modal").find("#list_price").val() : 0);
		var options_total = parseFloat(($("#invoice-generator-modal").find("#options_total").val() != '') ? $("#invoice-generator-modal").find("#options_total").val() : 0);
		var accessories_total = parseFloat(($("#invoice-generator-modal").find("#accessories_total").val() != '') ? $("#invoice-generator-modal").find("#accessories_total").val() : 0);
		var dealer_delivery = parseFloat(($("#invoice-generator-modal").find("#edited_dealer_delivery").val() != '') ? $("#invoice-generator-modal").find("#edited_dealer_delivery").val() : 0);
		var dealer_discount = parseFloat(($("#invoice-generator-modal").find("#edited_dealer_discount").val() != '') ? $("#invoice-generator-modal").find("#edited_dealer_discount").val() : 0);
		var fleet_discount = parseFloat(($("#invoice-generator-modal").find("#edited_fleet_discount").val() != '') ? $("#invoice-generator-modal").find("#edited_fleet_discount").val() : 0);
		var registration = parseFloat(($("#invoice-generator-modal").find("#edited_registration").val() != '') ? $("#invoice-generator-modal").find("#edited_registration").val() : 0);
		var ctp = parseFloat(($("#invoice-generator-modal").find("#edited_ctp").val() != '') ? $("#invoice-generator-modal").find("#edited_ctp").val() : 0);
		var tradein_value = parseFloat(($("#invoice-generator-modal").find("#tradein_value").val() != '') ? $("#invoice-generator-modal").find("#tradein_value").val() : 0);
		var tradein_given = parseFloat(($("#invoice-generator-modal").find("#tradein_given").val() != '') ? $("#invoice-generator-modal").find("#tradein_given").val() : 0);
		var tradein_payout = parseFloat(($("#invoice-generator-modal").find("#tradein_payout").val() != '') ? $("#invoice-generator-modal").find("#tradein_payout").val() : 0);
		var deposits_total = parseFloat(($("#invoice-generator-modal").find("#deposits_total").val() != '') ? $("#invoice-generator-modal").find("#deposits_total").val() : 0);
		var refunds_total = parseFloat(($("#invoice-generator-modal").find("#refunds_total").val() != '') ? $("#invoice-generator-modal").find("#refunds_total").val() : 0);

		var other_costs_amount = parseFloat(($("#invoice-generator-modal").find("#other_costs_amount").val() != '') ? $("#invoice-generator-modal").find("#other_costs_amount").val() : 0);
		var other_revenue_amount = parseFloat(($("#invoice-generator-modal").find("#other_revenue_amount").val() != '') ? $("#invoice-generator-modal").find("#other_revenue_amount").val() : 0);

		rrp = list_price + options_total + accessories_total;			// Retail Price of the Car
		subtotal_1 = rrp + dealer_delivery;								// Price Plus Options & Delivery 
		subtotal_2 = subtotal_1 - (dealer_discount + fleet_discount);	// Sub Total Line
		gst = subtotal_2 * 0.1;											// GST
		subtotal_3 = subtotal_2 + gst;									// Price INC of GST ()
		
		// LCT Computation (Start) //
		if (fuel_efficient_flag == 1) { lct_threshold = lct_fuel_efficient_value; }
		else if (fuel_efficient_flag == 2) { lct_threshold = lct_other_vehicles_value; }
		else { lct_threshold = lct_other_vehicles_value; }
		
		if (subtotal_3 > lct_threshold) { lct = (subtotal_3 - lct_threshold) / 11 * 10 * luxury_tax_rate; }
		else { lct = 0; }
		// LCT Computation (End) //
		
		subtotal_4 = subtotal_3 + lct;									// 
		
		// Stamp Duty (Start) //
		if (registration_type == "TPI") // GO BACK HERE (Change the TPI Value)
		{
			stamp_duty = 0;
		}
		else
		{
			if (client_state === "NSW" || client_state === "ACT") // Calculated on negotiated price + LCT using formula
			{
				if (subtotal_3 >= 45000)
				{
					stamp_duty = ((subtotal_3 - 45000) * 0.05) + 1350; 
				}
				else
				{
					stamp_duty = (subtotal_3 * 0.03);
				}
			}
			else if (client_state === "VIC")
			{
				if (subtotal_3 >= 57466)
				{
					stamp_duty = (subtotal_3 * 0.05); 
				}
				else
				{
					stamp_duty = (subtotal_3 * 0.025); 
				}
			}
			else if (client_state === "QLD")
			{
				stamp_duty = (rrp * 0.03);
			}
			else if (client_state === "SA")
			{
				stamp_duty = ((subtotal_3 - 3000) * 0.04) + 60;
			}
			else if (client_state === "WA")
			{
				if (rrp >= 50000)
				{
					stamp_duty = rrp * 0.065;
				}
				else if (rrp >= 25000)
				{
					stamp_duty = floor(((round((((rrp - 25000) / 6666.66) + 2.75), 2) / 100) * rrp) / 0.05) * 0.05;
				}
				else
				{
					stamp_duty = rrp * 0.0275;
				}
			}
			else if (client_state === "TAS")
			{
				if (subtotal_3 >= 40000)
				{
					stamp_duty = subtotal_3 * 0.04;
				}						
				else if (subtotal_3 >= 35000)
				{
					stamp_duty = ((subtotal_3 - 3500) * 0.11) + 1050;
				}
				else
				{
					stamp_duty = subtotal_3 * 0.03;
				}
			}
			else if (client_state === "NT")
			{
				stamp_duty = (subtotal_3 * 0.03);
			}					
		}
		// Stamp Duty (End) //

		sales_price = subtotal_4 + stamp_duty + registration + ctp;
		balance = sales_price - tradein_given + tradein_payout - deposits_total + refunds_total;
		price_difference = sales_price - dqp;
		changeover = sales_price - tradein_given + tradein_payout;

		commissionable_gross = ((sales_price + (tradein_value - tradein_given) - dqp - other_costs_amount - membership) / 11) * 10;
		revenue = sales_price + (tradein_value - tradein_given) - dqp - other_costs_amount + other_revenue_amount;
		
		if (dealer_tradein_value != 0)
		{
			price_difference = changeover - dealer_changeover;
			commissionable_gross = ((changeover - dealer_changeover - other_costs_amount - membership) / 11) * 10;
			revenue = changeover - dealer_changeover - other_costs_amount + other_revenue_amount;
		}
		else
		{
			price_difference = sales_price - dqp;
			commissionable_gross = ((sales_price + (tradein_value - tradein_given) - dqp - other_costs_amount - membership) / 11) * 10;
			revenue = sales_price + (tradein_value - tradein_given) - dqp - other_costs_amount + other_revenue_amount;
		}		

		$("#invoice-generator-modal").find("#lct_threshold").val(lct_threshold.toFixed(2));
		$("#invoice-generator-modal").find("#rrp").val(rrp.toFixed(2));
		$("#invoice-generator-modal").find("#subtotal_1").val(subtotal_1.toFixed(2));
		$("#invoice-generator-modal").find("#subtotal_2").val(subtotal_2.toFixed(2));
		$("#invoice-generator-modal").find("#subtotal_3").val(subtotal_3.toFixed(2));
		$("#invoice-generator-modal").find("#gst").val(gst.toFixed(2));
		$("#invoice-generator-modal").find("#lct").val(lct.toFixed(2));
		$("#invoice-generator-modal").find("#stamp_duty").val(stamp_duty.toFixed(2));
		$("#invoice-generator-modal").find("#sales_price").val(sales_price.toFixed(2));
		$("#invoice-generator-modal").find("#balance").val(balance.toFixed(2));

		$("#invoice-generator-modal").find("#price_difference").val(price_difference.toFixed(2));
		$("#invoice-generator-modal").find("#changeover").val(changeover.toFixed(2));
		$("#invoice-generator-modal").find("#revenue").val(revenue.toFixed(2));
		$("#invoice-generator-modal").find("#commissionable_gross").val(commissionable_gross.toFixed(2));
	}

	function calculate_revenue ()
	{
		var membership = parseFloat(($("#lead-modal").find("#membership").val() != '') ? $("#lead-modal").find("#membership").val() : 0);
		var membership_lower = parseFloat(($("#lead-modal").find("#membership_lower").val() != '') ? $("#lead-modal").find("#membership_lower").val() : 0);
		var dqp = parseFloat(($("#lead-modal").find("#dqp").val() != '') ? $("#lead-modal").find("#dqp").val() : 0);
		var tradein_count = parseFloat(($("#lead-modal").find("#tradein_count").val() != '') ? $("#lead-modal").find("#tradein_count").val() : 0);
		var dealer_tradein_count = parseFloat(($("#lead-modal").find("#dealer_tradein_count").val() != '') ? $("#lead-modal").find("#dealer_tradein_count").val() : 0);
		var dealer_tradein_value = parseFloat(($("#lead-modal").find("#dealer_tradein_value").val() != '') ? $("#lead-modal").find("#dealer_tradein_value").val() : 0);
		var dealer_tradein_payout = parseFloat(($("#lead-modal").find("#dealer_tradein_payout").val() != '') ? $("#lead-modal").find("#dealer_tradein_payout").val() : 0);
		var dealer_client_refund = parseFloat(($("#lead-modal").find("#dealer_client_refund").val() != '') ? $("#lead-modal").find("#dealer_client_refund").val() : 0);
		var dealer_changeover = parseFloat(($("#lead-modal").find("#dealer_changeover").val() != '') ? $("#lead-modal").find("#dealer_changeover").val() : 0);		

		var sales_price = parseFloat(($("#lead-modal").find("#sales_price").val() != '') ? $("#lead-modal").find("#sales_price").val() : 0);
		var tradein_value = parseFloat(($("#lead-modal").find("#real_tradein_value").val() != '') ? $("#lead-modal").find("#real_tradein_value").val() : 0);
		var tradein_given = parseFloat(($("#lead-modal").find("#real_tradein_given").val() != '') ? $("#lead-modal").find("#real_tradein_given").val() : 0);
		var tradein_payout = parseFloat(($("#lead-modal").find("#real_tradein_payout").val() != '') ? $("#lead-modal").find("#real_tradein_payout").val() : 0);
		var deposits_total = parseFloat(($("#lead-modal").find("#deposits_total").val() != '') ? $("#lead-modal").find("#deposits_total").val() : 0);
		var refunds_total = parseFloat(($("#lead-modal").find("#refunds_total").val() != '') ? $("#lead-modal").find("#refunds_total").val() : 0);
		var other_costs_amount = parseFloat(($("#lead-modal").find("#other_costs_amount").val() != '') ? $("#lead-modal").find("#other_costs_amount").val() : 0);
		var other_revenue_amount = parseFloat(($("#lead-modal").find("#other_revenue_amount").val() != '') ? $("#lead-modal").find("#other_revenue_amount").val() : 0);

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
			revenue = changeover - dealer_changeover - other_costs_amount + other_revenue_amount;
			
			if (revenue <= revenue_threshold)
			{
				final_membership = membership_lower;
			}
			else
			{
				final_membership = membership;
			}
			commissionable_gross = ((changeover - dealer_changeover - other_costs_amount - final_membership) / 11) * 10;
			
		}
		else
		{
			price_difference = sales_price - dqp;
			revenue = sales_price + (tradein_value - tradein_given) - dqp - other_costs_amount + other_revenue_amount;
			
			if (revenue <= revenue_threshold)
			{
				final_membership = membership_lower;
			}
			else
			{
				final_membership = membership;
			}			
			commissionable_gross = ((sales_price + (tradein_value - tradein_given) - dqp - other_costs_amount - final_membership) / 11) * 10;
		}

		$("#lead-modal").find("#balance").val(balance.toFixed(2));
		$("#lead-modal").find("#cpp").val(changeover.toFixed(2));
		$("#lead-modal").find("#commissionable_gross").val(commissionable_gross.toFixed(2));
		$("#lead-modal").find("#revenue").val(revenue.toFixed(2));								
	}

	function save_lead_info (lead_id, lead_status_id) // Lead Modal Action (07-16-16) - Form Serialize
	{
		var d = new Date();
		var curr_date = d.getDate();
		var curr_month = d.getMonth() + 1;
		var curr_year = d.getFullYear();
		var curr_hour = d.getHours();
		var curr_minute = d.getMinutes();
		var curr_second = d.getSeconds();	
		var time_now = (curr_year + "-" + curr_month + "-" + curr_date + " " + curr_hour + ":" + curr_minute + ":" + curr_second);

		if (lead_status_id <= 1)
		{
			$("#status_label_" + lead_id).css("color", "#33cc66");
			$("#status_label_" + lead_id).html('<span style="color: #33cc66 id="status_label_' + lead_id + '"><b>Attempted</b></span>');
			$("#lead_status_main_td_" + lead_id).html("Attempted");
			$("#lead_status_main_td_" + lead_id).css({"color": "#33cc66"});	
		}

		$.ajax({
			type: "POST",
			url: "<?php echo site_url('lead/update_record'); ?>",
			data: $("#lead-modal").find("#main_form").serialize(),
			cache: false,
			success: function(result){

				$("#order_date_td_" + lead_id).html($("#lead-modal").find("#order_date").val());
				$("#delivery_date_td_" + lead_id).html($("#lead-modal").find("#delivery_date").val());
				$("#settled_date_td_" + lead_id).html($("#lead-modal").find("#settled_date").val());
				$("#winning_price_td_" + lead_id).html($("#lead-modal").find("#dealer_quoted_price").val());

				$("#tradein_value_td_" + lead_id).html($("#lead-modal").find("#real_tradein_value").val());
				$("#tradein_payout_td_" + lead_id).html($("#lead-modal").find("#real_tradein_payout").val());
				$("#changeover_td_" + lead_id).html($("#lead-modal").find("#changeover").val());

				$("#deposit_td_" + lead_id).html($("#lead-modal").find("#deposit").val());
				$("#commissionable_gross_td_" + lead_id).html($("#lead-modal").find("#commissionable_gross").val());
				$("#revenue_td_" + lead_id).html($("#lead-modal").find("#final_revenue").val());

				$("#name_td_" + lead_id).html($("#lead-modal").find("#name").val());
				$("#email_td_" + lead_id).html($("#lead-modal").find("#email").val());
				$("#phone_td_" + lead_id).html($("#lead-modal").find("#phone").val());
				$("#mobile_td_" + lead_id).html($("#lead-modal").find("#mobile").val());
				$("#state_td_" + lead_id).html($("#lead-modal").find("#state").val());
				$("#postcode_td_" + lead_id).html($("#lead-modal").find("#postcode").val());

				$("#lead-modal").find("#lead_actions_history").append("<tr><td>Update</td><td></td><td>" + time_now + "</td></tr>");
				
				alert ("Update successful!");
			}
		});
	}

	function send_tender_confirmation (lead_id) // Lead Modal Action
	{
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('lead/send_tender_confirmation'); ?>/" + lead_id,
			cache: false,
			success: function(result){
				alert ("Tender Confirmation was successfully sent!");
			}
		});	
	}
	
	function lead_called (lead_id, lead_status_id, lead_call_count, home_tab) // Lead Modal Action (07-16-16) - Form Serialize
	{
		var d = new Date();
		var curr_date = d.getDate();
		var curr_month = d.getMonth() + 1;
		var curr_year = d.getFullYear();
		var curr_hour = d.getHours();
		var curr_minute = d.getMinutes();
		var curr_second = d.getSeconds();	
		var time_now = (curr_year + "-" + pad(curr_month, 2) + "-" + pad(curr_date, 2) + " " + pad(curr_hour, 2) + ":" + pad(curr_minute, 2) + ":" + pad(curr_second, 2));

		if (lead_status_id <= 1)
		{
			// ??
			$("#status_label_" + lead_id).css("color", "#33cc66");
			$("#status_label_" + lead_id).html('<span style="color: #33cc66 id="status_label_' + lead_id + '"><b>Attempted</b></span>');
			
			// Leads List
			$("#lead_status_main_td_"+lead_id).html("Attempted");
			$("#lead_status_main_td_"+lead_id).css({"color": "#33cc66"});					
		}

		$.ajax({
			type: "POST",
			url: "<?php echo site_url('lead/lead_called'); ?>",
			data: $("#lead-modal").find("#main_form").serialize(),
			cache: false,
			success: function(result){
				lead_call_count ++;
				
				// Lead Popup
				$("#lead-modal").find("#lead_call_count").html(lead_call_count);
				$("#lead-modal").find("#lead_actions_history").append("<tr><td>Called Client</td><td></td><td>" + time_now + "</td></tr>");

				if (typeof load_sales_tab === 'function')
				{
					if (home_tab != "")
					{
						load_sales_tab(home_tab);
					}
				}
			}
		});
	}		
	
	function send_email (lead_id, lead_status_id, email_type, home_tab) // Lead Modal Action (07-16-16) - Datastring
	{
		if (confirm('Are you sure you want to send this email to the client?')) 
		{
			var dataString = '&lead_id='+lead_id+'&type='+email_type;

			var d = new Date();
			var curr_date = d.getDate();
			var curr_month = d.getMonth() + 1;
			var curr_year = d.getFullYear();
			var curr_hour = d.getHours();
			var curr_minute = d.getMinutes();
			var curr_second = d.getSeconds();
			var date_now = (curr_year + "-" + pad(curr_month, 2) + "-" + pad(curr_date, 2));
			var time_now = (curr_year + "-" + pad(curr_month, 2) + "-" + pad(curr_date, 2) + " " + pad(curr_hour, 2) + ":" + pad(curr_minute, 2) + ":" + pad(curr_second, 2));

			if (lead_status_id <= 1)
			{
				$("#status_label_" + lead_id).css("color", "#33cc66");
				$("#status_label_" + lead_id).html('<span style="color: #33cc66 id="status_label_' + lead_id + '"><b>Attempted</b></span>');
				$("#lead_status_main_td_"+lead_id).html("Attempted");
				$("#lead_status_main_td_"+lead_id).css({"color": "#33cc66"});					
			}

			$.ajax({
				type: "POST",
				url: "<?php echo site_url('lead/email_client'); ?>",
				data: dataString,
				cache: false,
				success: function(result){

					// Lead Popup
					$("#lead-modal").find("#send_email_"+email_type).append(" ("+date_now+")");
					$("#lead-modal").find("#lead_actions_history").append("<tr><td>Client Email: " + email_type + "</td><td></td><td>" + time_now + "</td></tr>");
					
					// Lead Main
					$("#next_lead_btn").removeAttr("disabled");
					$("#lead_status_text").html("Attempted");

					alert ("You email has been sent to the client");
					
					if (typeof load_sales_tab === 'function')
					{
						if (home_tab != "")
						{
							load_sales_tab(home_tab);
						}
					}					
				}
			});
		}
	}		

	function delete_lead (lead_id, home_tab) // Lead Modal Action (07-16-16) - Datastring
	{
		if (confirm("Are you sure you want to delete this lead?"))
		{
			var dataString = "&lead_id="+lead_id;
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("lead/delete_calendar"); ?>",
				data: dataString,
				cache: false,
				success: function(result){
					$("#calendar").fullCalendar("removeEvents",lead_id);
					$("#lead-modal").find("#lead_details").val("");
					$("#lead-modal").modal("hide");
					
					// Leads List
					$("#lead_status_main_td_"+lead_id).html("Deleted");
					$("#lead_status_main_td_"+lead_id).css({"color": "#cccccc"});
					
					// Lead Main
					$("#next_lead_btn").removeAttr("disabled");
					$("#not_proceeding_btn").prop("disabled", true);
					$("#no_answer_btn").prop("disabled", true);
					$("#wrong_number_btn").prop("disabled", true);
					$("#call_back_btn").prop("disabled", true);
					$("#open_lead_btn").prop("disabled", true);
					$("#lead_status_text").html("Not Proceeding");
					
					if (typeof load_sales_tab === 'function')
					{
						if (home_tab != "")
						{
							load_sales_tab(home_tab);
						}
					}
				}
			});
		}
	}

	function submit_deal_modal (lead_id)
	{
		var lead_status_id = $("#lead-modal").find("#lead_status_id").val();

		save_lead_info(lead_id, lead_status_id);

		$.post("<?php echo site_url("deal/submit_deal_modal"); ?>/" + lead_id, function(data)
		{
			$("#submit-deal-modal").find("#submitdeal").html(data.requirements_html);
			$("#submit-deal-modal").modal();
		}, "json");
	}

	function submit_deal (lead_id) // Lead Modal Action (07-16-16) - Form Serialize
	{
		if (confirm("Are you sure you want to submit the deal?")) 
		{
			var d = new Date();
			var curr_date = d.getDate();
			var curr_month = d.getMonth() + 1;
			var curr_year = d.getFullYear();
			var curr_hour = d.getHours();
			var curr_minute = d.getMinutes();
			var curr_second = d.getSeconds();					
			var time_now = (curr_year + "-" + pad(curr_month, 2) + "-" + pad(curr_date, 2) + " " + pad(curr_hour, 2) + ":" + pad(curr_minute, 2) + ":" + pad(curr_second, 2));

			$.ajax({
				type: "POST",
				url: "<?php echo site_url("lead/submit_deal"); ?>",
				data: $("#lead-modal").find("#main_form").serialize(),
				cache: false,
				success: function(result){
					$("#status_label_" + lead_id).css("color", "#9933cc");
					$("#status_label_" + lead_id).html('<span style="color: #9933cc id="status_label_' + lead_id + '"><b>Deal PreAuth</b></span>');
					$("#lead_status_main_td_"+lead_id).html("Submitted as Deal");
					$("#lead_status_main_td_"+lead_id).css({"color": "#9933cc"});
					$("#lead-modal").find("#lead_actions_history").append("<tr><td>Deal Submitted</td><td></td><td>" + time_now + "</td></tr>");
					$("#lead-modal").find("#lead_details").val("");
					$("#submit-deal-modal").modal("hide");
					$("#lead-modal").modal("hide");
					$("#next_lead_btn").removeAttr("disabled");
				}
			});
		}
	}

	function change_deal_status (status_id) // Lead Modal Action (07-16-16) - Form Serialize
	{
		var status_color = "#cccccc";
		var status_label = "";
		var actions_text = "";
		var confirmation_text = "";

		if (status_id == 3)
		{
			status_color = "#6600cc";
			status_label = "Tendering";
			actions_text = "Converted Back to Tendering";
			confirmation_text = "Are you sure you want to convert this Deal back to Tendering?";
		}
		else if (status_id == 5)
		{
			status_color = "#cc00cc";
			status_label = "Approved by Admin";
			actions_text = "Deal Approved";
			confirmation_text = "Are you sure you want to approve this Deal?";
		}
		else if (status_id == 6)
		{
			status_color = "#ff6633";
			status_label = "Delivered";
			actions_text = "Deal Delivered";
			confirmation_text = "Are you sure you want to mark this Deal as Delivered?";
		}
		else if (status_id == 7)
		{
			status_color = "#009900";
			status_label = "Settled";
			actions_text = "Deal Settled";
			confirmation_text = "Are you sure you want to mark this Deal as Settled?";
		}
		else if (status_id == 8)
		{
			status_color = "#2baab1";
			status_label = "Admin on Hold";
			actions_text = "Put on Hold";
			confirmation_text = "Are you sure you want to put this Deal on Hold?";
		}

		if (confirm(confirmation_text))
		{
			var lead_id = $("#lead-modal").find("#lead_id").val();
			var details = $("#lead-modal").find("#lead_details").val();
			
			var d = new Date();
			var curr_date = d.getDate();
			var curr_month = d.getMonth() + 1;
			var curr_year = d.getFullYear();
			var curr_hour = d.getHours();
			var curr_minute = d.getMinutes();
			var curr_second = d.getSeconds();					
			var time_now = (curr_year + "-" + pad(curr_month, 2) + "-" + pad(curr_date, 2) + " " + pad(curr_hour, 2) + ":" + pad(curr_minute, 2) + ":" + pad(curr_second, 2));

			$.ajax({
				type: "POST",
				url: "<?php echo site_url("deal/change_deal_status"); ?>/" + status_id,
				data: $("#lead-modal").find("#main_form").serialize(),
				cache: false,
				success: function(result){
					$("#status_label_" + lead_id).css("color", status_color);
					$("#status_label_" + lead_id).html('<span style="color: '+status_color+' id="status_label_' + lead_id + '"><b>'+status_label+'</b></span>');
					$("#lead_status_main_td_"+lead_id).html(status_label);
					$("#lead_status_main_td_"+lead_id).css({"color": status_color});
					$("#lead-modal").find("#lead_actions_history").append("<tr><td>"+actions_text+"</td><td></td><td>" + time_now + "</td></tr>");
					$("#lead-modal").find("#lead_details").val("");
					$("#lead-modal").modal("hide");
				}
			});
		}
	}

	function add_lead_comment_modal (lead_id, lead_status_id) // Sub Modal View (07-16-16)
	{
		$("#addleadcomment-modal").find("#lead_id").val(lead_id);
		$("#addleadcomment-modal").find("#lead_status_id").val(lead_status_id);
		$("#addleadcomment-modal").find("#lead_comment").val("");
		$("#addleadcomment-modal").find("#al_uploaded_comment_files").html("");
		$("#addleadcomment-modal").find("#dz_al_comment_file").html("");
		$("#addleadcomment-modal").modal();
	}

	function add_lead_comment_action () // Sub Modal Action (07-16-16)
	{
		var lead_id = $("#addleadcomment-modal").find("#lead_id").val();
		var lead_status_id = $("#addleadcomment-modal").find("#lead_status_id").val();
		
		var d = new Date();
		var curr_date = d.getDate();
		var curr_month = d.getMonth() + 1;
		var curr_year = d.getFullYear();
		var curr_hour = d.getHours();
		var curr_minute = d.getMinutes();
		var curr_second = d.getSeconds();	
		var time_now = (curr_year + "-" + pad(curr_month, 2) + "-" + pad(curr_date, 2) + " " + pad(curr_hour, 2) + ":" + pad(curr_minute, 2) + ":" + pad(curr_second, 2));
		
		if (lead_status_id <= 1)
		{
			$("#status_label_" + lead_id).css("color", "#33cc66");
			$("#status_label_" + lead_id).html('<span style="color: #33cc66 id="status_label_' + lead_id + '"><b>Attempted</b></span>');
			$("#lead_status_main_td_"+lead_id).html("Attempted");
			$("#lead_status_main_td_"+lead_id).css({"color": "#33cc66"});	
		}

		$.ajax({
			type: "POST",
			url: "<?php echo site_url('lead/add_comment/'); ?>/" + lead_id,
			data: $("#addleadcomment-modal").find("#main_form").serialize(),
			cache: false,
			success: function(result){
				$("#addleadcomment-modal").modal("hide");
				$("#lead-modal").find("#lead_actions_history").append("<tr><td>Added Comment</td><td></td><td>" + time_now + "</td></tr>");
				$("#lead-modal").modal("hide");
			}
		});
	}

	function add_lead_ticket_modal (lead_id, cq_number) // Sub Modal View (07-16-16)
	{
		$("#addleadticket-modal").find("#lead_id").val(lead_id);
		$("#addleadticket-modal").find("#cq_reference").val(cq_number);
		$("#addleadticket-modal").find("#ticket_type").val("");
		$("#addleadticket-modal").find("#priority").val("");
		$("#addleadticket-modal").find("#module").val("");
		$("#addleadticket-modal").find("#user_id_to").val("");
		$("#addleadticket-modal").find("#name").val("");
		$("#addleadticket-modal").find("#assignment_date").val("");
		$("#addleadticket-modal").find("#description").val("");
		$("#addleadticket-modal").modal();
	}

	function add_lead_ticket_action () // Sub Modal Action (07-16-16)
	{
		var lead_id = $("#addleadticket-modal").find("#lead_id").val();
		var cq_number = $("#addleadticket-modal").find("#cq_reference").val();
		
		var d = new Date();
		var curr_date = d.getDate();
		var curr_month = d.getMonth() + 1;
		var curr_year = d.getFullYear();
		var curr_hour = d.getHours();
		var curr_minute = d.getMinutes();
		var curr_second = d.getSeconds();	
		var time_now = (curr_year + "-" + pad(curr_month, 2) + "-" + pad(curr_date, 2) + " " + pad(curr_hour, 2) + ":" + pad(curr_minute, 2) + ":" + pad(curr_second, 2));

		$.ajax({
			type: "POST",
			url: "<?php echo site_url('ticket/add_record/'); ?>",
			data: $("#addleadticket-modal").find("#main_form").serialize(),
			cache: false,
			success: function(result){
				$("#addleadticket-modal").modal("hide");
			}
		});
	}

	function load_makes (make_id, modal_name) // Submodal Dropdown Action (07-16-16)
	{
		if(make_id != "" && make_id != 0)
		{
			var dataString = "&make_id="+make_id;
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("cars/load_makes"); ?>/"+make_id,
				cache: false,
				success: function(result){
					$("#"+modal_name+"-modal").find("#make").html("<option name='make' value='0'></option>");
					$("#"+modal_name+"-modal").find("#make").append(result);
				}
			});					
		}
	}			

	function load_families (make_id, modal_name, family_id) // Submodal Dropdown Action (07-16-16)
	{
		if(make_id != "")
		{
			if (family_id == 0 || typeof(family_id) == "undefined")
			{
				$('#'+modal_name+'-modal').find("#build_date").html("<option name='build_date' value='0'></option>");
				$('#'+modal_name+'-modal').find("#build_date").prop("disabled", true);
				$('#'+modal_name+'-modal').find("#vehicle").html("<option name='vehicle' value='0'></option>");
				$('#'+modal_name+'-modal').find("#vehicle").prop("disabled", true);
				$('#'+modal_name+'-modal').find("#option").html("");
				var dataString = "&make_id="+make_id;
			}
			else
			{
				var dataString = "&make_id="+make_id+"&family_id="+family_id;
			}
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("cars/load_families"); ?>",
				data: dataString,
				cache: false,
				success: function(result){
					$('#'+modal_name+'-modal').find("#family").removeAttr("disabled");
					$('#'+modal_name+'-modal').find("#family").html("<option name='family' value='0'></option>");
					$('#'+modal_name+'-modal').find("#family").append(result);
				}
			});				
		}
	}			

	function load_build_dates (family_id, modal_name, build_date) // Submodal Dropdown Action (07-16-16)
	{
		if(family_id != "")
		{
			if (build_date == 0 || typeof(build_date) == "undefined")
			{
				$('#'+modal_name+'-modal').find("#vehicle").html("<option name='vehicle' value='0'></option>");
				$('#'+modal_name+'-modal').find("#vehicle").prop("disabled", true);
				$('#'+modal_name+'-modal').find("#option").html("");
				var dataString = "&family_id="+family_id;
			}
			else
			{
				var dataString = "&family_id="+family_id+"&build_date="+build_date;
			}
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("cars/load_build_dates"); ?>",
				data: dataString,
				cache: false,
				success: function(result){
					$('#'+modal_name+'-modal').find("#build_date").removeAttr("disabled");
					$('#'+modal_name+'-modal').find("#build_date").html("<option name='build_date' value='0'></option>");
					$('#'+modal_name+'-modal').find("#build_date").append(result);
				}
			});				
		}
	}
	
	function load_vehicles (code, modal_name, vehicle_id) // Submodal Dropdown Action (07-16-16)
	{
		if(code != "")
		{
			if (vehicle_id == 0 || typeof(vehicle_id) == "undefined") 
			{
				$('#'+modal_name+'-modal').find("#options").html("");
				var dataString = "&code="+code;
			}
			else
			{
				var dataString = "&code="+code+"&vehicle_id="+vehicle_id;
			}

			$.ajax({
				type: "POST",
				url: "<?php echo site_url("cars/load_vehicles"); ?>",
				data: dataString,
				cache: false,
				success: function(result){
					$('#'+modal_name+'-modal').find("#vehicle").removeAttr("disabled");
					$('#'+modal_name+'-modal').find("#vehicle").html("<option name='vehicle' value='0'></option>");
					$('#'+modal_name+'-modal').find("#vehicle").append(result);
				}
			});				
		}
	}

	function load_options (vehicle_id, modal_name, quote_request_id) // Submodal Dropdown Action (07-16-16)
	{
		if(vehicle_id != "" )
		{
			if (quote_request_id == 0 || typeof(quote_request_id) == "undefined")
			{
				var dataString = "&vehicle_id="+vehicle_id;
			}	
			else
			{
				var dataString = "&vehicle_id="+vehicle_id+"&quote_request_id="+quote_request_id;
			}

			$('#'+modal_name+'-modal').find("#options").html("");
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('cars/load_options'); ?>",
				data: dataString,
				cache: false,
				success: function(result){
					$('#'+modal_name+'-modal').find("#options").append(result);
				}
			});
		}
	}

	function load_accessories (quote_request_id, modal_name) // Submodal TEXTAREA Action (07-16-16)
	{
		$('#'+modal_name+'-modal').find("#accessory_container").html("");
		var dataString = "&quote_request_id="+quote_request_id;
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('cars/load_accessories'); ?>",
			data: dataString,
			cache: false,
			success: function(result){
				$('#'+modal_name+'-modal').find("#accessory_container").append(result);
			}
		});
	}

	function add_accessory (modal_name) // Submodal TEXTAREA Action (07-16-16)
	{
		var accessory_field = '<div class="col-md-12 text-left"><hr /><input class="form-control input-md" name="accessory_name[]" type="text" placeholder="Accessory"><br /></div><div class="col-md-12 text-left"><textarea class="form-control" name="accessory_desc[]" rows="3" id="textareaDefault" placeholder="Description"></textarea></div>';
		$('#'+modal_name+'-modal').find("#accessory_container").append(accessory_field);
	}			

	function load_dealers (modal_name) // Submodal Dropdown Action (07-16-16)
	{
		var make = $("#"+modal_name+"-modal").find("#make_ds").val();
		var postcode = $("#"+modal_name+"-modal").find("#postcode_ds").val();
		var state = $("#"+modal_name+"-modal").find("#state_ds").val();
		var dataString = "&make="+make+"&postcode="+postcode+"&state="+state+"&modal_name="+modal_name;

		$.ajax({
			type: "POST",
			url: "<?php echo site_url("lead/suggested_dealers"); ?>",
			data: dataString,
			cache: false,
			success: function(result){
				$("#"+modal_name+"-modal").find("#suggested_dealers").html("");
				$("#"+modal_name+"-modal").find("#suggested_dealers").append(result);
			}
		});
	}

	$(document).ready(function(){

		$(document).on('click','.search_trade_btn', function(){
			$("#filtered_tradein_result").html("");

			$("#t_s_email").val("");
			$("#t_s_make").val("");
			$("#t_s_firstname").val("");
			$("#t_s_lastname").val("");
			$("#t_s_model").val("");

			var this_modal = $("#search_tradein_modal");

			$(this_modal).modal();
		});

		$(document).on('change','.search_tradein_field', function(){

			$("#filtered_tradein_result").html("");

			var t_s_email     = $("#t_s_email").val();
			var t_s_make      = $("#t_s_make").val();
			var t_s_firstname = $("#t_s_firstname").val();
			var t_s_lastname  = $("#t_s_lastname").val();
			var t_s_model     = $("#t_s_model").val();

			var data = {
				t_s_email    : t_s_email,
				t_s_make     : t_s_make,
				t_s_firstname: t_s_firstname,
				t_s_lastname : t_s_lastname,
				t_s_model    : t_s_model
			};

			$.ajax({
				type: "POST",
				url: "<?php echo site_url("lead/searched_tradein"); ?>",
				data: data,
				cache: false,
				success: function(result){
					$("#filtered_tradein_result").html(result);
				}
			});
		});

		$(document).on('click','.select_tradein', function(){
			var tradein_id = $(this).data("tradein_id");
			var lead_id    = $("#lead-modal").find("#lead_id").val();
			
			var data = {
				tradein_id: tradein_id,
				lead_id: lead_id
			};

			$.ajax({
				type: "POST",
				url: "<?php echo site_url("lead/set_new_tradein"); ?>",
				data: data,
				cache: false,
				success: function(result){
					$("#no_tradeins").remove();

					$("#suggested_trades_body").append(result);

					$(document).find('.documents_temp_'+tradein_id).dropzone ({
				        url: '<?php echo site_url('lead/upload_tradein_documents/'); ?>',
				        init: function() {
				            this.on("sending", function(file, xhr, formData){
								var lead_id = $('#tradein_id_hidden').val();
								var doc_id  = $("#tradein_doc_hidden_val").val();
								
								formData.append("lead_id", lead_id);
								formData.append("doc_id", doc_id);
							}),
							this.on("success", function(file, response){

								if(!curr_doc.hasClass("documents_green"))
									curr_doc.addClass("documents_green");
								
							}),
							this.on("queuecomplete", function () {
							    this.removeAllFiles();
							});
						},
					
					});

					$("#search_tradein_modal").modal('hide');
				}
			});
		})
	});

	function add_dealer (dealer_id, modal_name)
	{
		if (modal_name == 'addquote')
		{
			var username = $("#"+modal_name+"-modal").find("#dealer_"+dealer_id).html();
			$("#"+modal_name+"-modal").find("#selected_dealers").html('<tr><td><input type="hidden" value="'+dealer_id+'" id="dealer_id_inp" name="dealer_id">'+username+'</td></tr>');
			$("#"+modal_name+"-modal").find("#suggested_dealers").html("");

			var data = {
				dealer_id: dealer_id
			};

			$("#hidden_dealer_state").val("");

			$.ajax({
				type: "POST",
				url: "<?php echo site_url('user/get_dealer_state'); ?>",
				data: data,
				cache: false,
				success: function(result){
					$("#hidden_dealer_state").val(result);

					$("#addquote-modal").find(".transport_checkbox").prop("checked", false);

					if( $("#hidden_dealer_state").val() != $("#hidden_lead_state").val() && parseInt($("#hidden_tradein_count").val()) > 0 )
					{
						$("#checkbox_form").prop("hidden", false);
					}
					else
					{
						$("#checkbox_form").prop("hidden", true);
					}
					
				}
			});
		}
		else if (modal_name == 'adddealers' || modal_name == 'starttender')
		{
			var dealer_ids = $("#"+modal_name+"-modal").find("#dealer_ids_inp").val();
			var username = $("#"+modal_name+"-modal").find("#dealer_"+dealer_id).html();
			$("#"+modal_name+"-modal").find("#selected_dealers").append('<tr id="selected_dealer_'+dealer_id+'"><td width="90%">'+username+'</td><td><center><span style="cursor: pointer; cursor: hand; color: #58c603;" onclick="delete_dealer('+dealer_id+', \''+modal_name+'\')"><i class="fa fa-times"></i></span></center></td></tr>');
			$("#"+modal_name+"-modal").find("#dealer_ids_inp").val(dealer_ids+"-"+dealer_id);
		}
	}

	function delete_dealer (dealer_id, modal_name) // ADD DELETING OF ACTUAL DEALER IDS
	{
		$("#selected_dealer_"+dealer_id).remove();
	}

	// REMIND DEALERS //
	function remind_dealers (quote_request_id) // Modal Action (07-20-2016)
	{
		if (confirm("Are you sure you want to send a Reminder Email the invited dealers?"))
		{
			var lead_id = $("#lead-modal").find("#lead_id").val();
			var dataString = "&lead_id="+lead_id;

			var d = new Date();
			var curr_date = d.getDate();
			var curr_month = d.getMonth() + 1;
			var curr_year = d.getFullYear();
			var curr_hour = d.getHours();
			var curr_minute = d.getMinutes();
			var curr_second = d.getSeconds();
			var time_now = (curr_year + "-" + curr_month + "-" + curr_date + " " + curr_hour + ":" + curr_minute + ":" + curr_second);
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('lead/remind_dealers'); ?>/" + quote_request_id,
				data: dataString,
				cache: false,
				success: function(result){
					$('#lead-modal').find("#reminder_date").html("(Last Sent: "+time_now+")");
					alert ("You have successfully sent the Reminder Emails");
				}
			});
		}
	}
	// ..REMIND DEALERS //

	// ADD DEALER QUOTE //
	$(document).on("click", ".open-addquote", function(data) // Sub Modal Action (07-16-16)
	{
		var quote_request_id = $(this).data("quote_request_id");
		$.post("<?php echo site_url("lead/add_quote"); ?>/" + quote_request_id, function(data)
		{
			$('#addquote-modal').find("#hidden_quote_request_id_old").val(quote_request_id);
			$('#addquote-modal').find("#options_content").html(data.options_html);
			$('#addquote-modal').find("#accessories_content").html(data.accessories_html);
			$('#addquote-modal').find("#hidden_lead_state").val(data.lead_state);
			$('#addquote-modal').find("#hidden_tradein_count").val(data.tradein_count);
			$('#addquote-modal').find("#hidden_quote_request_lead_id").val(data.lead_id);

			var lead_id = $("#lead-modal").find("#lead_id").val();
			get_load_dealer_paramters(lead_id,'quote_request','addquote');

			$("#addquote-modal").modal();
		}, "json");
	});

	$(document).on('change', '#demo_lead_modals', function(){
		var $this     = $(this);
		var this_val = $this.val();

		if(this_val == "New")
		{
			$("#tr_kms_lead_modal").prop('hidden', true);
		}
		else
		{
			$("#tr_kms_lead_modal").prop('hidden', false);
		}
	});

	function submit_quote () // Sub Modal Action january 5, 2017
	{
		var final_flag = null;
		var lead_id = $("#lead-modal").find("#lead_id").val();
		var dealer_id = $("#dealer_id_inp").val();
		var flag = $("#addquote-modal").find("#demo_lead_modals").val();
		var quote_req_id = $("#addquote-modal").find("#hidden_quote_request_id_old").val();
		if (dealer_id != 0)
		{

			var data = {
				dealer_id: dealer_id,
				flag: flag,
				quote_req_id: quote_req_id,
				lead_id: lead_id
			}

			$.ajax({
				type: "POST",
				url: "<?php echo site_url("user/verify_dealer_quote"); ?>",
				data: data,
				cache: false,
				dataType: 'json',
				success: function(data){

					if (parseInt(data.status) > 0)
					{
						if (confirm("This dealer has already a quotation for a "+flag+" car for this request! Do you wish to override the data?"))
						{
							$("#addquote-modal").find("#hidden_process_old").val("update");
							$("#addquote-modal").find("#hidden_quote_id_sub_old").val(data.id_quote);
							final_flag = 1;
						}
						else
						{
							final_flag = 0;
							return false;
						}
					}
					else
					{
						final_flag = 1;
					}

					if(final_flag == 1)
					{
						$("#addquote-modal").find("#addquote_modal_submit_quote").prop("disabled", true);

						$.ajax({
							type: "POST",
							url: "<?php echo site_url("user/send_quotation"); ?>",
							data: $("#addquote-modal").find("#main_form").serialize(),
							cache: false,
							success: function(result){
								$("#addquote-modal").find("input,textarea,select").val("");
								$("#addquote-modal").modal("hide");
								$("#lead-modal").modal("hide");
								$("#addquote-modal").find("#addquote_modal_submit_quote").prop("disabled", false);

								var data_2 = {
									dealer_id       : dealer_id,
									flag            : flag,
									quote_request_id: quote_req_id,
									lead_id         : lead_id
								};

								$.ajax({
									type: "POST",
									url: "<?php echo site_url("lead/add_single_dealer_request"); ?>",
									data: data_2,
									cache: false,
									success: function(result){
										
									}
								});
							}
						});
					}
				}
			});

		}
		else
		{
			alert ("Please choose Dealer!");
		}
	}
	// ..ADD DEALER QUOTE //
	$(document).on("click", ".open-addquote", function(data) // Sub Modal Action (07-16-16)
	{
		var quote_request_id = $(this).data("quote_request_id");
		$.post("<?php echo site_url("lead/add_quote"); ?>/" + quote_request_id, function(data)
		{
			$('#addquote-modal').find("#hidden_quote_request_id_old").val(quote_request_id);
			$('#addquote-modal').find("#options_content").html(data.options_html);
			$('#addquote-modal').find("#accessories_content").html(data.accessories_html);
			$('#addquote-modal').find("#hidden_lead_state").val(data.lead_state);
			$('#addquote-modal').find("#hidden_tradein_count").val(data.tradein_count);
			$('#addquote-modal').find("#hidden_quote_request_lead_id").val(data.lead_id);
			$('#addquote-modal').find("#hidden_registration_type").val(data.registration_type);

			var lead_id = $("#lead-modal").find("#lead_id").val();
			get_load_dealer_paramters(lead_id,'quote_request','addquote');

			$("#addquote-modal").modal();
		}, "json");
	});	

	// SELECT WINNER //
	function select_winning_quote (quote_id) // Sub Modal Action (08-04-16)
	{
		var lead_id = $("#lead-modal").find("#lead_id").val();
		var quote_request_id = $("#lead-modal").find("#id_quote_request").val();
		var dataString = "&quote_request_id="+quote_request_id+"&quote_id="+quote_id;
		if (quote_request_id != 0 && quote_id != 0)
		{
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("lead/select_winning_quote"); ?>",
				data: dataString,
				cache: false,
				success: function(result){
					var winning_quote_total = $("#lead-modal").find("#dealer_quote_total_"+quote_id).html();
					$("#lead-modal").find("#winning_quote").html(winning_quote_total);
					$("#lead-modal").find("#dealer_quoted_price").val(winning_quote_total);
					calculate_lead();
					$("#winning_price_td_" + lead_id).html(winning_quote_total);
					$("#commissionable_gross_td_" + lead_id).html($("#lead-modal").find("#commissionable_gross").val());
					$("#revenue_td_" + lead_id).html($("#lead-modal").find("#final_revenue").val());
					$("#lead-modal").find(".select_winning_quote_btn").prop("disabled", false);
					$("#lead-modal").find("#select_winning_quote_btn_"+quote_id).prop("disabled", true);
					$("#lead-modal").modal("hide");
				}
			});			
		}
	}
	// ..SELECT WINNER //

	// ADD DEALERS //
	$(document).on("click", ".open-adddealers", function(data) // Sub Modal View (07-16-16)
	{
		var lead_id = $("#lead-modal").find("#lead_id").val();
		get_load_dealer_paramters(lead_id,'quote_request','adddealers');

		$("#adddealers-modal").modal();
	});			

	function add_dealer_request () // Sub Modal Action (07-16-16)
	{
		var quote_request_id = $("#lead-modal").find("#id_quote_request").val();
		var lead_id = $("#lead-modal").find("#lead_id").val();
		var dealer_ids = $("#dealer_ids_inp").val();
		var dataString = "&dealer_ids="+dealer_ids+"&lead_id="+lead_id;
		$.ajax({
			type: "POST",
			url: "<?php echo site_url("lead/add_dealer_request"); ?>" + "/" + quote_request_id + "/",
			data: dataString,
			cache: false,
			success: function(result){
				$("#adddealers-modal").find("#selected_dealers").html("");
				$("#adddealers-modal").find("#suggested_dealers").html("");
				$("#adddealers-modal").find("input,textarea,select").val("");
				$("#adddealers-modal").find("#dealer_ids_inp").val("0");
				$("#adddealers-modal").modal("hide");
				$("#lead-modal").modal("hide");
			}
		});
	}
	// ..ADD DEALERS //

	// START TENDER //
	$(document).on("click", ".open-starttender", function(data) // Sub Modal View (07-16-16)
	{
		var lead_id = $(this).data("lead_id");
		var cq_number;
		var email;
		var name;
		var postcode;

		cq_number = $("#lead-modal").find("#lead_cq_number").text();
		if (cq_number.length == 0)
		{
			cq_number = $("#lead_main_cq_number").text();
			email = $("#lead_main_email").text();
			name = $("#lead_main_name").text();
			postcode = $("#lead_main_postcode").text();
			
			if (cq_number.length == 0)
			{
				var this_panel = $(this).closest(".aftersales_panel");
				
				cq_number = $(this_panel).find(".home_cq_number").text();
				email = $(this_panel).find(".home_email").text();
				name = $(this_panel).find(".home_name").text();
				postcode = $(this_panel).find(".home_postcode").text();
			}
		}
		else
		{
			email = $("#lead-modal").find("#lead_email_value").val();
			name = $("#lead-modal").find("#lead_name").text();
			postcode = $("#lead-modal").find("#lead_postcode").text();			
		}

		var data = {
			lead_id: lead_id
		};

		$.ajax({
			type: "POST",
			url: "<?php echo site_url("lead/get_lead_car_details"); ?>",
			data: data,
			cache: false,
			dataType: 'json',
			success: function(data){
				load_makes(data.id_make, 'starttender');
				load_families(data.id_make, 'starttender', data.id_family);
				load_build_dates(data.id_family, 'starttender');
			}
		});

		get_load_dealer_paramters(lead_id, 'tender', 'starttender');

		$("#starttender-modal").find("input,textarea,select").val("");
		$("#starttender-modal").find("#dealer_ids_inp").val("0");
		$("#starttender-modal").find("#option").html("");
		$("#starttender-modal").find("#lead_id").val(lead_id);
		$("#starttender-modal").find("#cq_number").val(cq_number);
		$("#starttender-modal").find("#email").val(email);
		$("#starttender-modal").find("#name").val(name);
		$("#starttender-modal").find("#postcode").val(postcode);
		$("#starttender-modal").modal();
	});

	function get_load_dealer_paramters(lead_id, type, modal_name)
	{
		var data = {
			lead_id: lead_id,
			type: type
		};

		var dataString = "";

		$.ajax({
			type: "POST",
			url: "<?php echo site_url("lead/get_load_dealer_paramters"); ?>",
			data: data,
			cache: false,
			dataType: 'json',
			success: function(data){
				dataString = "&make="+data.make+"&postcode=&state="+data.state+"&modal_name="+modal_name;
				load_initial_dealers(modal_name, dataString, data.make, data.state)
			}
		});
	}

	function load_initial_dealers (modal_name, dataString, make, state)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo site_url("lead/suggested_dealers"); ?>",
			data: dataString,
			cache: false,
			success: function(result){
				$("#"+modal_name+"-modal").find("#make_ds").val(make);
				$("#"+modal_name+"-modal").find("#state_ds").val(state);
				$("#"+modal_name+"-modal").find("#suggested_dealers").html("");
				$("#"+modal_name+"-modal").find("#suggested_dealers").append(result);
			}
		});
	}
	
	function start_tender (home_tab) // Sub Modal Action (07-16-16)
	{
		var lead_id = $("#starttender-modal").find("#lead_id").val();
		var make = $("#starttender-modal").find("#make").val();
		var family = $("#starttender-modal").find("#family").val();
		var build_date = $("#starttender-modal").find("#build_date").val();
		var vehicle = $("#starttender-modal").find("#vehicle").val();
		var colour = $("#starttender-modal").find("#colour").val();
		var registration_type = $("#starttender-modal").find("#registration_type").val();

		if (make==0 || make=="" || family==0 || family=="" || build_date==0 || build_date=="" || vehicle==0 || vehicle==="" || colour==="" || registration_type==="")
		{
			alert ("Please fill up all the required fields!");
		}
		else
		{
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("lead/start_tender"); ?>",
				data: $("#starttender-modal").find("#main_form").serialize(),
				cache: false,
				success: function(result){
					$("#status_label_" + lead_id).css("color", "#6600cc");
					$("#status_label_" + lead_id).html('<span style="color: #6600cc id="status_label_' + lead_id + '"><b>Tendering (0)</b></span>');
					$("#lead_status_main_td_"+lead_id).html("Tendering");
					$("#lead_status_main_td_"+lead_id).css({"color": "#6600cc"});							
					$("#starttender-modal").find("input,textarea,select").val("");
					$("#starttender-modal").find("#options").html("");
					$("#starttender-modal").find("#suggested_dealers").html("");
					$("#starttender-modal").find("#selected_dealers").html("");
					$("#starttender-modal").modal("hide");
					$("#lead-modal").find("input,textarea,select").val("");
					$("#lead-modal").modal("hide");
					$("#lead_status_text").html("Tendering");					
					$("#next_lead_btn").removeAttr("disabled");
					$("#not_proceeding_btn").attr("disabled", true);
					$("#no_answer_btn").attr("disabled", true);
					$("#wrong_number_btn").attr("disabled", true);
					$("#call_back_btn").attr("disabled", true);
					$("#start_tender_btn").attr("disabled", true);

					if (typeof load_sales_tab === 'function')
					{
						if (home_tab != "")
						{
							load_sales_tab(home_tab);
						}
					}					
				}
			});
		}
	}
	// ..START TENDER //

	// EMAIL INVITE //
	$(document).on("click", ".open-emailinvite", function(data) // Sub Modal View (07-16-16)
	{
		var quote_request_id = $(this).data("quote_request_id");
		$.post("<?php echo site_url("lead/invited_emails"); ?>/" + quote_request_id, function(data)
		{
			$("#emailinvite-modal").find("#id_quote_request").val(quote_request_id);
			$("#emailinvite-modal").find("#email_invites").html(data.email_invites);
			$("#emailinvite-modal").modal();
		}, "json");
	});
	
	function add_email_invite () // Sub Modal Action (07-16-16)
	{
		var lead_id = $("#lead-modal").find("#lead_id").val();
		var quote_request_id = $("#lead-modal").find("#id_quote_request").val();
		var email = $("#emailinvite-modal").find("#email").val();

		var d = new Date();
		var curr_date = d.getDate();
		var curr_month = d.getMonth() + 1;
		var curr_year = d.getFullYear();
		var curr_hour = d.getHours();
		var curr_minute = d.getMinutes();
		var curr_second = d.getSeconds();	
		var date_now = (curr_year + "-" + pad(curr_month, 2) + "-" + pad(curr_date, 2));

		var dataString = "&email="+email+"&lead_id="+lead_id;
		if (email.length == 0) 
		{
			alert ("Please enter an email address!");
		}
		else
		{
			$("#emailinvite-modal").find("#email").val("");
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("lead/add_email_invite"); ?>" + "/" + quote_request_id + "/",
				data: dataString,
				cache: false,
				success: function(result){
					$("#emailinvite-modal").find("#ei_no_record").remove();
					$("#emailinvite-modal").find("#email_invites").append("<tr><td>"+email+"</td></tr>");
					$("#lead-modal").find("#ei_no_record").remove();
					$("#lead-modal").find("#email_invites").append("<tr><td>"+email+"</td><td>"+date_now+"</td></tr>");
				}
			});
		}
	}
	// ..EMAIL INVITE //
	
	// EDIT VEHICLE //
	$(document).on("click", ".open-editvehicle", function(data) // Sub Modal View (07-16-16)
	{
		$(".full_loader").show();
		var quote_request_id = $(this).data("quote_request_id");
		var make = $("#lead-modal").find("#tender_make").val();
		var family = $("#lead-modal").find("#tender_model").val();
		var build_date = $("#lead-modal").find("#tender_build_date").val();
		var variant = $("#lead-modal").find("#tender_variant").val();
		var colour = $("#lead-modal").find("#tender_colour").val();
		var registration_type = $("#lead-modal").find("#tender_registration").val();
		
		load_makes(make, 'editvehicle');
		load_families(make, 'editvehicle', family);
		load_build_dates(family, 'editvehicle', build_date);
		load_vehicles(family+'-'+build_date, 'editvehicle', variant);
		load_options(variant, 'editvehicle', quote_request_id);
		load_accessories(quote_request_id, 'editvehicle');
		
		$("#editvehicle-modal").find("#id_quote_request").val(quote_request_id);				
		$("#editvehicle-modal").find("#colour").val(colour);
		$("#editvehicle-modal").find("#registration_type [value='"+registration_type+"']").attr("selected", true);
		$("#editvehicle-modal").modal();
		$(".full_loader").hide();
	});
	
	function update_vehicle ()// Sub Modal Action (07-16-16)
	{
		var lead_id = $("#lead-modal").find("#lead_id").val();
		var quote_request_id = $("#editvehicle-modal").find("#id_quote_request").val();
		var make = $("#editvehicle-modal").find("#make").val();
		var family = $("#editvehicle-modal").find("#family").val();
		var make_text = $("#editvehicle-modal").find("#make option:selected").text();
		var family_text = $("#editvehicle-modal").find("#model option:selected").text();
		var build_date = $("#editvehicle-modal").find("#build_date").val();
		var vehicle = $("#editvehicle-modal").find("#vehicle").val();
		var colour = $("#editvehicle-modal").find("#colour").val();
		var registration_type = $("#editvehicle-modal").find("#registration_type").val();

		if (make == 0 || make == "" || family == 0 || family == "" || build_date == 0 || build_date == "" || vehicle == 0 || vehicle == "" || colour == "" || registration_type == "")
		{
			alert ("Please fill up all the required fields!");
		}
		else
		{
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("lead/update_vehicle"); ?>",
				data: $("#editvehicle-modal").find("#main_form").serialize(),
				cache: false,
				success: function(result){
					$("#editvehicle-modal").find("input,textarea,select").val("");
					$("#editvehicle-modal").modal("hide");
					$("#editvehicle-modal").find("input,textarea,select").val("");
					$("#editvehicle-modal").find("#options").html("");
					$("#editvehicle-modal").find("#suggested_dealers").html("");
					$("#editvehicle-modal").find("#selected_dealers").html("");							
					$("#editvehicle-modal").modal("hide");
					$("#make_td_" + lead_id).html(make_text);
					$("#model_td_" + lead_id).html(model_text);
					$("#lead-modal").modal("hide");
				}
			});
		}
	}
	// ..EDIT VEHICLE //

	// TRADE IN //
	function attach_trade (tradein_id) // Modal Action (07-20-16)
	{
		var lead_id = $("#lead-modal").find("#lead_id").val();
		var tradein_value = parseFloat($("#lead-modal").find("#tradein_value_"+tradein_id).html());
		var tradein_given = parseFloat($("#lead-modal").find("#tradein_given_"+tradein_id).html());
		var tradein_payout = parseFloat($("#lead-modal").find("#tradein_payout_"+tradein_id).html());
		var preview_tradein_value = parseFloat($("#lead-modal").find("#preview_tradein_value").html());
		var preview_tradein_given = parseFloat($("#lead-modal").find("#preview_tradein_given").html());
		var preview_tradein_payout = parseFloat($("#lead-modal").find("#preview_tradein_payout").html());
		var total_tradein_value = preview_tradein_value + tradein_value;
		var total_tradein_given = preview_tradein_given + tradein_given;
		var total_tradein_payout = preview_tradein_payout + tradein_payout;

		var dataString = '&lead_id='+lead_id+'&tradein_id='+tradein_id;

		$.ajax({
			type: "POST",
			url: "<?php echo site_url('tradein/attach_trade'); ?>",
			data: dataString,
			cache: false,
			success: function(result){
				$("#lead-modal").find("#attach_trade_button_"+tradein_id).hide();
				$("#lead-modal").find("#unattach_trade_button_"+tradein_id).show();
				$("#lead-modal").find("#preview_tradein_value").html(total_tradein_value);
				$("#lead-modal").find("#preview_tradein_given").html(total_tradein_given);
				$("#lead-modal").find("#preview_tradein_payout").html(total_tradein_payout);
			}
		});
	}
	
	function unattach_trade (tradein_id, status) // Modal Action (07-20-16)
	{
		var lead_id = $("#lead-modal").find("#lead_id").val();
		var tradein_value = parseFloat($("#lead-modal").find("#tradein_value_"+tradein_id).html());
		var tradein_given = parseFloat($("#lead-modal").find("#tradein_given_"+tradein_id).html());
		var tradein_payout = parseFloat($("#lead-modal").find("#tradein_payout_"+tradein_id).html());
		var preview_tradein_value = parseFloat($("#lead-modal").find("#preview_tradein_value").html());
		var preview_tradein_given = parseFloat($("#lead-modal").find("#preview_tradein_given").html());
		var preview_tradein_payout = parseFloat($("#lead-modal").find("#preview_tradein_payout").html());
		var total_tradein_value = preview_tradein_value - tradein_value;
		var total_tradein_given = preview_tradein_given - tradein_given;
		var total_tradein_payout = preview_tradein_payout - tradein_payout;

		var dataString = '&lead_id='+lead_id+'&tradein_id='+tradein_id;
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('tradein/unattach_trade'); ?>",
			data: dataString,
			cache: false,
			success: function(result){
				$("#lead-modal").find("#unattach_trade_button_"+tradein_id).hide();
				$("#lead-modal").find("#attach_trade_button_"+tradein_id).show();
				$("#lead-modal").find("#preview_tradein_value").html(total_tradein_value);
				$("#lead-modal").find("#preview_tradein_given").html(total_tradein_given);
				$("#lead-modal").find("#preview_tradein_payout").html(total_tradein_payout);
			}
		});
	}

	$(document).on("change", ".dealer_visibility_rad", function(data) {
		var tradein_id = this.name;
		var dealer_visibility = this.value;
		var dataString = '&tradein_id='+tradein_id+'&dealer_visibility='+dealer_visibility;
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('tradein/update_dealer_visibility'); ?>",
			data: dataString,
			cache: false,
			success: function(result){
			
			}
		});
	});

	$(document).find('.upload_file_attachment').dropzone ({
        url: '<?php echo site_url('lead/upload_to_database'); ?>',
        init: function() {
            this.on("sending", function(file, xhr, formData){
				var id = $('#lead_id').val();
			
				formData.append("id", id);
			}),
			this.on("success", function(file, response){
				var obj = jQuery.parseJSON(response);
				var html = "<tr class='file_table' data-abspath='"+obj.file_name+"' data-fileid='"+obj.insert_id+"'><td><a target='_blank' href='"+obj.abspath+"'>"+obj.file_name+"</a></td><td><a class='fa fa-trash-o del_file' ></a></td></tr>";
				$(document).find("#attachment_table_id").find('.table').append(html);
				
			}),
			this.on("queuecomplete", function () {
			    this.removeAllFiles();
			});
		},
	
	});

	$(document).on('click', '.del_file', function(){
		var fk_main = $(this).closest('.file_table').data("fileid");
		var abspath = $(this).closest('.file_table').data("abspath");
		var that    = $(this);

		var data = {
			fk_main: fk_main,
			abspath: abspath
		};

		if( !confirm("Are you sure you want to delete this file?") )
			return false;

		$.ajax({
			type: "POST",
			url: "<?php echo site_url("lead/delete_file"); ?>",
			cache: false,
			data: data,
			success: function(response){
				if($.trim(response) == "success")
					that.closest(".file_table").remove();
			}
		});
	});

	function refund (id_payment)
	{
		var data = {
			id_payment: id_payment
		};

		if( confirm("Are you sure you want to refund this payment?") )
		{
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('admin_main/refund'); ?>",
				data : data,
				cache: false,
				success: function(response) {
					if(response == "success")
					{
						$("#payment_tr_"+id_payment).find(".ref_date").text("<?php echo date("Y-m-d"); ?>");
						$("#payment_tr_"+id_payment).find(".ref_status").text("Refunded");
						$("#payment_tr_"+id_payment).find(".refund_btn").prop('hidden',true);
						$("#payment_tr_"+id_payment).find(".edit_payment_date").prop('hidden',true);
					}
					else
					{
						alert("Refund failed!");
					}
				}
			});
		}
	}

	$(document).on('click', '.open-refund-payment', function(){


		var this_modal = $("#refund_modal");
		var payment_id = $(this).data("payment_id");

		$(this_modal).find(".hidden_ref_payment_id").val(payment_id);

		$(this_modal).modal('show');
	});

	$(document).on('click', '.confirm_refund', function(){

		var this_modal    = $("#refund_modal");
		var id_payment    = $(this_modal).find(".hidden_ref_payment_id").val();
		var refund_amount = $(this_modal).find(".refund_amount").val();

		var data = {
			id_payment: id_payment,
			refund_amount: refund_amount
		};

		var d           = new Date();
		var curr_date   = d.getDate();
		var curr_month  = d.getMonth() + 1;
		var curr_year   = d.getFullYear();
		var curr_hour   = d.getHours();
		var curr_minute = d.getMinutes();
		var curr_second = d.getSeconds();

		var name = "";

		var new_date = (curr_year + "-" + pad(curr_month, 2) + "-" + pad(curr_date, 2));

		$.ajax({
			type: "POST",
			url: "<?php echo site_url('admin_main/refund'); ?>",
			data : data,
			cache: false,
			success: function(response) {
				if(modal_flag == 1)
				{
					if(response == "success")
					{
						alert("Refunded successfully!!");

						$("#balcqo-modal").find(".payments_table").append('\
							<tr>\
								<td align="center"></td>\
								<td></td>\
								<td></td>\
								<td></td>\
								<td>Deposit Refund (-)</td>\
								<td>Credit Card</td>\
								<td></td>\
								<td>'+name+'</td>\
								<td>-'+refund_amount+'</td>\
								<td>0.00</td>\
								<td>'+new_date+'</td>\
								<td></td>\
								<td></td>\
								<td>Shown</td>\
							</tr>'
						);

						$(this_modal).modal("hide");
					}
					else if(response == "over_refund")
						alert("Total refund exceeds the amount paid!");
					else
						alert("Refund failed!")
				}
				else if (modal_flag == 2)
				{
					if(response == "success")
					{
						alert("Refunded successfully!!");
						$(this_modal).modal("hide");
					}
					else if(response == "over_refund")
						alert("Total refund exceeds the amount paid!");
					else
						alert("Refund failed!")
				}
			}
		});
	});

	$(document).on('click', '.show_btn', function(){
		var $this           = $(this);
		var id_payment      = $this.data('idpayment');
		var show_status     = $this.data('showstatus');
		var show_class      = "";
		var show_text       = "";
		var new_show_status = 0;
		var $show_title     = "";

		if(show_status == 1)
		{
			show_class      = "fa-eye";
			show_text       = "Hidden";
			new_show_status = 0;
			$show_title  = "Show this payment on the paperworks";
		}
		else
		{
			show_class      = "fa-eye-slash";
			show_text       = "Shown";
			new_show_status = 1;
			$show_title  = "Hide this payment on the paperworks";
		}

		var data = {
			id_payment: id_payment,
			show_status: show_status
		};

		$.ajax({
			type: "POST",
			url: "<?php echo site_url('admin_main/show_payment'); ?>",
			data : data,
			cache: false,
			success: function(response) {
				$("#payment_tr_"+id_payment).find(".show_text").text(show_text);
				$("#payment_tr_"+id_payment).find(".show_btn").data("showstatus", new_show_status);
				$this.find(".show-icon").remove();
				$this.html('<i class="show-icon fa '+show_class+'"></i>');
				$this.attr("title", $show_title);
			}
		});
		
	});

	$(document).on('click', '.verify_btn', function(){
		var $this           = $(this);
		var id_payment      = $this.data('idpayment');
		var status     = $this.data('status');
		var status_class      = "";
		var status_text       = "";
		var new_status = 0;
		var status_title     = "";

		if(status == 1)
		{
			status_class      = "fa-check-circle";
			status_text       = "Unverified";
			new_status = 0;
			status_title  = "Verify this payment";
		}
		else
		{
			status_class      = "fa-times-circle";
			status_text       = "Verified";
			new_status = 1;
			status_title  = "Unverify this payment";
		}

		var data = {
			id_payment: id_payment,
			status: status
		};
		
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('admin_main/verify_payment_status'); ?>",
			data : data,
			cache: false,
			success: function(response) {
				$("#payment_tr_"+id_payment).find(".status_text").text(status_text);
				$("#payment_tr_"+id_payment).find(".verify_btn").data("status", new_status);
				$this.find(".status-icon").remove();
				$this.html('<i class="status-icon fa '+status_class+'"></i>');
				$this.attr("title", status_title);
			}
		});
		
	});
	// ..TRADE IN //
</script>
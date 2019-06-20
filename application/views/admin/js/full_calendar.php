$("#fapplication-modal-3").find('.panel-main').not(':first').remove();
$("#fapplication-modal-3").find('.address-clause').find('.prev_address_panel').not(':first').remove();
$("#fapplication-modal-3").find('.address-clause').find(".prev_panel_parent").find(".prev_address_panel:first").prop("hidden", true);
$("#fapplication-modal-3").find('.employer_clause').find('.prev_employer_panel').not(':first').remove();
$("#fapplication-modal-3").find('.employer_clause').find(".prev_emp_panel_parent").find(".prev_employer_panel:first").prop("hidden", true);
$("#fapplication-modal-3").find('.cred_card_clause').find('.panel').not(':first').remove();
$("#fapplication-modal-3").find('.loan_clause').find('.panel').not(':first').remove();
$("#fapplication-modal-3").find('.cred_reference_clause').find('.panel').not(':first').remove();
$("#fapplication-modal-3").find('.property_clause').find('.panel').not(':first').remove();
$("#fapplication-modal-3").find('.asset_clause').find('.panel').not(':first').remove();
$("#fapplication-modal-3").find('.beneficiaries_section').find('.panel').not(':first').remove();
$("#fapplication-modal-3").find('input').val('');
$('.beneficiaries_section').attr('hidden',true);
modal_data = data;


var get_notes_data_tabs = function(lead_id, id_application) { 
    var lead_id    = lead_id;
    var fa_acct_id = id_application;
    var data = {
        fa_acct_id: fa_acct_id,
        lead_id: lead_id
    };
    $(".note-model").find(".textarea").val("");
    $(".note-model").find(".textarea_2").val("");
    $(".note-model").find(".textarea_2").closest(".col-md-12").prop("hidden", true);
    $.ajax({
        type: "POST",
        url: "<?php echo site_url("fapplication/get_note"); ?>",
        cache: false,
        data: data,
        dataType: 'json',
        success: function(data){
        	$(".note-model").find(".textarea").val(data.note);
            $('textarea').each(function(){
                autosize(this);
            }).on('autosize:resized', function(){
                //console.log('textarea height updated');
            });
    
            if(data.lead_note != ""){
                $(".note-model").find(".textarea_2").val(data.lead_note);
                $(".note-model").find(".textarea_2").closest(".col-md-12").prop("hidden", false);
            }
            $(".note-model").slideDown(500);
            $(".note-model").addClass("active");            
        }
    });
}
get_notes_data_tabs(data.lead_id, data.id_application);

$(".side-note").hide();

// console.log(modal_data.row.vin);
$("#open_lead_popup").data("lead_id", data.lead_id);

//$('#start_valuation_button').attr('data-id_lead', );

$("#fapplication_traidin").find("#id_leads").val(data.id_application);
const fapplication_lead_id = data.id_application;
$('.full_loader').hide();
$('#fapplication_status_id').val(data.status_id);
$('#fqa_number').val(data.fqa_number);
$('#fapplication_status').html('('+data.status+')');
$('#fapplication_id').val(data.id_application);
$('#fapplication_fqa_number').html(data.fqa_number);
$('#fapplication_summary').html(data.fapplication_summary);
$('#fapplication_summary_new').html(data.fapplication_summary_new);
//$('#start_tender_modal .fapplication_summary_new').html(data.fapplication_summary_new);
var fapplication_summary_new = data.fapplication_summary_new;
//console.log(fapplication_summary_new);
$('#fapplication_actions_history').html(data.actions_history);

$('#tfapplication_actions_history').html(data.tender);


if(data.lead_status_tender == 'start_tender'){
    $('#tfapplication_start_tender_button').show();
}else{
    $('#tfapplication_start_tender_button').hide();    
}
$('#fapplication_traidin').html(data.tradein_html);
//$('#fapplication_traidin').html(data.traidin);
//console.log(data.computation);
$('#fapplication_computation').html(data.computation);
$('#fapplication_payment').html(data.payment);
$('#fapplication_email_actions').html(data.email_actions);
$('#lead_id_fq').val(data.lead_id);
$('#fapplication_created_at').html(data.created_at);
$('#fapplication_last_updated').html(data.last_updated);

$('.req_sec_panel').html(data.requirements_strings);
// $('.req_sett_panel').html(data.settlements_strings);

$(document).find('#new_req').html(data.requirement_ddown);
$(document).find('#new_sett').html(data.settlement_ddown);
$('#new_req_temp_storage').html(data.requirement_ddown);

// $('#floating_menu_body').html(data.actions);

//JAVASCRIPT FAPPLICATION FIELDS//
var global_loan_use = modal_data.row.loan_use;
var global_cust_type = modal_data.row.customer_type;

var state_type_1 = [
	'Have you ever been registered with any Credit Reporting Agency as having a Credit Default or Court Judgement registered against you?',
	'If Yes, have the related debts been paid in full?',
	'Have you ever been declared Bankrupt or entered into any Part 9 / Debt Agreement?',
	'If Yes, have you since been discharged?',
	''
];

var state_type_2 = [
	'Have you ever been declared bankrupt or insolvent, or has your estate been assigned for the benefit of creditors?',
	'Have you ever been shareholders or officer of any company of which a manager, receiver or liquidator has been appointed?',
	'Is there any unsatisfied court judgement entered against you or any company of which you are/were a shareholder or officer?',
	'Have you ever been registered with any Credit Reporting Agencies as in default?',
	'Are you the director or shareholder of any other companies? If yes, details:'
];

if(global_loan_use == 'business')
{
	$('.business_details').attr('hidden',false);
	$('.employer_clause').attr('hidden',true);
	//$('.cred_reference_clause').attr('hidden',true);
	$('.living_cost_clause').attr('hidden',true);

	$('#cust_type').html(
		"<option></option>\
<option value='company'>Company</option>\
<option value='sole_trader'>Sole Trader</option>\
<option value='partnership'>Partnership</option>\
<option value='trust'>Trust</option>\
"
	);
	$('#f-label-guarantors').text('Directors');
}
else if(global_loan_use == 'consumer')
{
	$('.business_details').attr('hidden',true);
	$('.employer_clause').attr('hidden',false);
	//$('.cred_reference_clause').attr('hidden',false);
	$('.living_cost_clause').attr('hidden',false);

	$('#cust_type').html(
		"<option></option>\
        <option value='joint'>Joint</option>\
        <option value='individual'>Individual</option>\
        "
    );
	$('#f-label-guarantors').text('Applicants');				
}


if(global_cust_type == "sole_trader")
{
	$('.applicant-add').attr('disabled',true);
	$('.applicant-remove').attr('disabled',false);
	$('.living_cost_clause').attr('hidden',false);
}
else if(global_cust_type == "company")
{
	$('.applicant-add').attr('disabled',false);
	$('.applicant-remove').attr('disabled',false);
}
else if(global_cust_type == "partnership")
{
	$('.applicant-add').attr('disabled',true);
	$('.applicant-remove').attr('disabled',true);
}
else if(global_cust_type == "trust")
{
	$('.applicant-add').attr('disabled',false);
	$('.applicant-remove').attr('disabled',false);
	$('.beneficiaries_section').attr('hidden',false);
}
else if(global_cust_type == "individual")
{
	$('.applicant-add').attr('disabled',true);
	$('.applicant-remove').attr('disabled',true);
}
else if(global_cust_type == "joint")
{
	$('.applicant-add').attr('disabled',true);
	$('.applicant-remove').attr('disabled',true);
}

var current_date = "<?= date('d/m/Y'); ?>";

$("#current_date").val(current_date);

$('#makes_row').html(modal_data.make_dom);
$('#model_row').html(modal_data.model_dom);
$('#year_row').html(modal_data.build_date_dom);
$('#variant_row').html(modal_data.variant_dom);

$('#dealers_name_dom').html(modal_data.dealer_dom);

$("#car").val(modal_data.row.car);
// $("#year").val(modal_data.row.year);
$("#color").val(modal_data.row.color);
$("#fq_vin").val(modal_data.row.vin);
$("#fq_engine").val(modal_data.row.engine);
$("#fq_rego").val(modal_data.row.rego);
$("#kms_1").val(parseInt(modal_data.row.kms));
$("#options").val(modal_data.row.options);
$("#further_details").val(modal_data.row.further_details);
$("#seller").val(modal_data.row.seller);
$("#tax_inv_dealer").val(modal_data.row.tax_inv_dealer);
$("#supplier_contact").val(modal_data.row.supplier_contact);
$("#supplier_email").val(modal_data.row.supplier_email);
$("#supplier_mobile").val(modal_data.row.supplier_mobile);
$("#supplier_landline").val(modal_data.row.supplier_landline);
$("#dealer_street_address").val(modal_data.row.dealer_street_address);
$("#dealer_suburb").val(modal_data.row.dealer_suburb);
$("#alt_dealer").val(modal_data.row.alt_dealer);
$("#dealer_postcode").val(modal_data.row.dealer_postcode);

$("#car_stock").val(modal_data.row.car_stock);
$("#car_arrival").val(modal_data.row.car_arrival);
$("#date_delivered").val(modal_data.row.delivery_date);
$("#further_details_supplies").val(modal_data.row.further_details_supplier);
$("#purchase_price").val(modal_data.row.purchase_price);
$("#deposit").val(modal_data.row.deposit);
$("#trade").val(modal_data.row.trade);
$("#payout").val(modal_data.row.payout);
$("#amt_to_finance").val(modal_data.row.amt_to_finance);
$("#term").val(modal_data.row.term);
$("#balloon_percentage").val(modal_data.row.balloon_percent);
$("#balloon_amt").val(modal_data.row.balloon_amt);
$("#lender").val(modal_data.row.lender);
$("#est_fee").val(modal_data.row.est_fee);
$("#origination_fee").val(modal_data.row.origination_fee);
$("#gap").val(modal_data.row.gap);
$("#lti").val(modal_data.row.lti);
$("#comprehensive").val(modal_data.row.comprehensive);
$("#rate").val(modal_data.row.rate);
$("#cust_rate").val(modal_data.row.cust_rate);
$("#frequency").val(modal_data.row.frequency);
$("#payments").val(modal_data.row.payments);
$("#commision").val(modal_data.row.commision);
$("#total_outgoings").val(modal_data.row.total_outgoings);
$("#total_income").val(modal_data.row.total_income);
$("#surp_def_pos").val(modal_data.row.surp_def_pos);
$("#further_details_deals").val(modal_data.row.further_details_deals);
$("#loan_use").val(modal_data.row.loan_use);
$("#cust_type").val(modal_data.row.customer_type);
$("#trading_name").val(modal_data.row.trading_name);
$("#abn").val(modal_data.row.abn);
$("#abr_name").val(modal_data.row.abr_name);
$("#abn_date").val(modal_data.row.abn_date);
$("#industry").val(modal_data.row.industry);
$("#gst_registered").val(modal_data.row.gst_registered);
$("#turnover_gross").val(modal_data.row.turnover_gross);
$("#net_profit").val(modal_data.row.net_profit);
$("#other_income").val(modal_data.row.other_income);
$("#trade_unit_address").val(modal_data.row.trade_unit_address);
$("#trade_address").val(modal_data.row.trade_address);
$("#trade_suburb").val(modal_data.row.trade_suburb);
$("#trade_post_code").val(modal_data.row.trade_post_code);
$("#accountant").val(modal_data.row.accountant);
$("#accountant_contact").val(modal_data.row.accountant_contact);
$("#accountant_number").val(modal_data.row.accountant_number);
$("#accountant_address").val(modal_data.row.accountant_address);
$("#accountant_suburb").val(modal_data.row.accountant_suburb);
$("#accountant_post_code").val(modal_data.row.accountant_post_code);
$("#banking_institution").val(modal_data.row.banking_institution);
$("#naf").val(modal_data.row.naf);
$("#bank_addr_titled").val(modal_data.row.bank_addr_titled);
$("#accountant_email").val(modal_data.row.accountant_email);
$("#arrears").val(modal_data.row.arrears);
$("#assessment_type").val(modal_data.row.assessment_type);
$("#book_value").val(modal_data.row.book_value);
$("#trust_name").val(modal_data.row.trust_name);
$("#trust_type").val(modal_data.row.trust_type);
$("#acn").val(modal_data.row.acn);
$("#loan_type").val(modal_data.row.loan_type);

if(modal_data.row.deposit_check == "1")
	$("#deposit_check").prop("checked", true);
else
	$("#deposit_check").prop("checked", false);

if(modal_data.row.trade_check == "1")
	$("#trade_check").prop("checked", true);
else
	$("#trade_check").prop("checked", false);

if(modal_data.row.replacement == "1")
	$("#replacement").prop("checked", true);
else
	$("#replacement").prop("checked", false);

if(modal_data.temp_user != "")
{
	$("#temp_user_div").prop("hidden", false);
	$("#temp_user_name").html(modal_data.temp_user);
}
else
{
	$("#temp_user_div").prop("hidden", true);
}

var dealer = $("#dealer").select2();
var email_array = [];

$(modal_data.email_list).each(function(index, value){
	// console.log(value);
	email_array.push(value.email);
});

var email_html = "";

if(modal_data.row.supplier_email!=''){
	email_array.push(modal_data.row.supplier_email);
}
if(modal_data.row.lead_email !=''){
	email_array.push(modal_data.row.lead_email);
}

if(modal_data.dealer_email != ''){
	email_array.push(modal_data.dealer_email);
}

if(modal_data.dealer_manager_email != ''){
	email_array.push(modal_data.dealer_manager_email);
}

$(modal_data.tenderInviteDealer).each(function(index, value){
	if(value !=''){
		email_array.push(value);
	}
	
});

email_array.push("paul@finquote.net.au");

$(email_array).each(function(index, value){
	email_html += '<li><a href="#" class="ddown_email_btn">'+value+'</a></li>'
});

$(".ddown_emails").closest(".input-group-btn").find("ul").html(email_html);

if(modal_data.beneficiary_rows.length > 0)
{
	$(document).find('.new_beneficiary_parent').find('.panel:first').find('.panel-body').prop('hidden', false);
	$(document).find('.new_beneficiary_parent').find('.panel:first').find('.new').prop('hidden', false);
	$(document).find('.new_beneficiary_parent').find('.panel:first').find('.default').remove();
}

//beneficiary row
$.each(modal_data.beneficiary_rows, function(index, value)
{
	var panel       = $(document).find('.new_beneficiary_parent').find('.panel:first').clone();
	var first_panel = $(document).find('.new_beneficiary_parent').find('.panel:first');
	var this_panel  = $(document).find('.new_beneficiary_parent');
	var id          = $(this_panel).find('.panel').length;
	var final_panel;

	panel.find('input').val('');

	if(index > 0)
	{
		final_panel = panel;

		final_panel.find('.form-control').each(function(key, value) {
			var input      = $(this);

			input.val('');

			var name       = input.closest('.panel').find('.panel-title-fapplication').text().replace(/[0-9]/g, id + 1);

			var curr_name = input.attr('name');

			var str_index   = curr_name.indexOf("[");
			var str_index_2 = curr_name.indexOf("]");
			var str_core_1  = curr_name.substring(str_index, str_index_2 + 1);
			var new_name    = curr_name.substring(0,str_index);
			str_core_1      = str_core_1.replace(/[0-9]/g, id);
			new_name        = new_name + str_core_1;

			input.attr('name', new_name);
			input.closest('.panel').find('.panel-title-fapplication').text(name);
		});

		this_panel.append(final_panel);

	}
	else
	{
		final_panel = first_panel;
	}

	final_panel.find('.beneficiary_id').val(value.id);
	final_panel.find('.b_type').val(value.b_type);
	final_panel.find('.b_first_name').val(value.b_first_name);
	final_panel.find('.b_last_name').val(value.b_last_name);
	final_panel.find('.b_unit').val(value.b_unit);
	final_panel.find('.b_address').val(value.b_address);
	final_panel.find('.b_suburb').val(value.b_suburb);
	final_panel.find('.b_postcode').val(value.b_postcode);
	final_panel.find('.b_mobile_number').val(value.b_mobile_number);
	final_panel.find('.b_other_number').val(value.b_other_number);
	final_panel.find('.b_acn').val(value.b_acn);

});

if(modal_data.applicant_rows.length < 1)
{
	$(document).find('.panel-main:first').find(".first_name").val(modal_data.lead_name);
	$(document).find('.panel-main:first').find(".mobile").val(modal_data.lead_phone);
	$(document).find('.panel-main:first').find(".other_telephone").val(modal_data.lead_mobile);
	$(document).find('.panel-main:first').find(".email").val(modal_data.lead_email);
}

//applicant row
$.each(modal_data.applicant_rows, function(index, value)
{
	var panel       = $(document).find('.temp_parent_panel:first').clone();
	var first_panel = $(document).find('.temp_parent_panel:first');
	var this_panel  = $(document).find('#application_fields');
	var id          = $(this_panel).find('.temp_parent_panel').length;
	var final_panel;
	var total_property_val = 0.00;

	// var name = panel.find('.panel-title-main').text().replace(/[0-9]/g, id + 1);
	var name = panel.find('.panel-title-main').text().replace(/[0-9]/g, "");
	var curr_name_number = parseInt(id) + 1;
	name = name + " "+ curr_name_number.toString();
	name = name.replace("Copy fields","");
	panel.find('.panel-title-main').text(name);

	panel.find('input').val('');

	panel.find('.address-clause').find('.prev_address_panel').not(':first').remove();
	panel.find('.address-clause').find(".prev_panel_parent").find(".prev_address_panel:first").prop("hidden", true);
	panel.find('.employer_clause').find('.prev_employer_panel').not(':first').remove();
	panel.find('.employer_clause').find(".prev_emp_panel_parent").find(".prev_employer_panel:first").prop("hidden", true);
	panel.find('.cred_card_clause').find('.panel').not(':first').remove();
	panel.find('.loan_clause').find('.panel').not(':first').remove();
	panel.find('.cred_reference_clause').find('.panel').not(':first').remove();
	panel.find('.property_clause').find('.panel').not(':first').remove();
	panel.find('.asset_clause').find('.panel').not(':first').remove();

	panel.find('.cred_card_clause').find('.panel:first').find('.panel-body').prop('hidden', true);
	panel.find('.cred_card_clause').find('.panel:first').find('.new').prop('hidden', true);
	panel.find('.cred_card_clause').find('.panel:first').find('.panel-heading').prepend('<label class="panel-title-fapplication default">Add a Credit Card?</label>');
	panel.find('.cred_card_clause').find('.panel:first').find(".remove").prop("disabled", true);

	panel.find('.loan_clause').find('.panel:first').find('.panel-body').prop('hidden', true);
	panel.find('.loan_clause').find('.panel:first').find('.new').prop('hidden', true);
	panel.find('.loan_clause').find('.panel:first').find('.panel-heading').prepend('<label class="panel-title-fapplication default">Add Other Loans?</label>');
	panel.find('.loan_clause').find('.panel:first').find(".remove").prop("disabled", true);

	panel.find('.property_claue').find('.panel:first').find('.panel-body').prop('hidden', true);
	panel.find('.property_claue').find('.panel:first').find('.new').prop('hidden', true);
	panel.find('.property_claue').find('.panel:first').find('.panel-heading').prepend('<label class="panel-title-fapplication default">Add a Property?</label>');
	panel.find('.property_claue').find('.panel:first').find(".remove").prop("disabled", true);

	panel.find('.cred_reference_clause').find('.panel:first').find('.panel-body').prop('hidden', true);
	panel.find('.cred_reference_clause').find('.panel:first').find('.new').prop('hidden', true);
	panel.find('.cred_reference_clause').find('.panel:first').find('.panel-heading').prepend('<label class="panel-title-fapplication default">Add a Reference?</label>');
	panel.find('.cred_reference_clause').find('.panel:first').find(".remove").prop("disabled", true);

	panel.find('.top-fields').remove();
	panel.find('.living_cost_clause').remove();
	panel.find('.assets').remove();
	panel.find('.car_details').remove();
	panel.find('.cred_reference_clause').remove();

	if(index > 0)
	{
		final_panel = panel;

		final_panel.find('.form-control').each(function(key, value)
											   {
			var input      = $(this);

			var curr_name = input.attr('name');

			var count = (curr_name.match(/\[/g) || []).length;

			if(count == 2)
			{
				var str_index   = curr_name.indexOf("[");
				var str_index_2 = curr_name.indexOf("]");
				var str_index_3 = curr_name.lastIndexOf("]");
				var str_core_1  = curr_name.substring(str_index, str_index_2 + 1);
				var str_core_2  = curr_name.substring(str_index_2 + 1, str_index_3 + 1);
				var new_name    = curr_name.substring(0,str_index);
				str_core_1      = str_core_1.replace(/[0-9]/g, id);
				new_name        = new_name + str_core_1 + str_core_2;

				input.attr('name', new_name);
			}
			else if(count == 3)
			{
				var str_index   = curr_name.indexOf("[");
				var str_index_2 = curr_name.indexOf("]");
				var str_core_1  = curr_name.substring(str_index, str_index_2 + 1);
				var str_core_2  = curr_name.substring(str_index_2 + 1, str_index_2 + 4);
				var str_core_3  = curr_name.substring(str_index_2 + 4, str_index_2 + 8);
				var new_name    = curr_name.substring(0,str_index);
				str_core_1      = str_core_1.replace(/[0-9]/g, id);
				new_name        = new_name + str_core_1 + str_core_2 + str_core_3;

				input.attr('name', new_name);

				// console.log(curr_name + ":" + count + " - 3");
			}
			else
			{
				var str_index   = curr_name.indexOf("[");
				var str_index_2 = curr_name.indexOf("]");
				var str_core_1  = curr_name.substring(str_index, str_index_2 + 1);
				var new_name    = curr_name.substring(0,str_index);
				str_core_1      = str_core_1.replace(/[0-9]/g, id);
				new_name        = new_name + str_core_1;

				input.attr('name', new_name);
			}

		});

		var html = '<button type="button" class="btn btn-primary btn-xs pull-right copy_applicant1" style="margin-left: 15px;">Copy fields</button>';

		final_panel.find(".panel-title-main").remove(".copy_applicant1");

		final_panel.find(".panel-title-main").append(html);

		final_panel.find(".business_details").remove();
		final_panel.find(".beneficiaries_section").remove();

		this_panel.append(final_panel);
	}
	else 
	{
		final_panel = first_panel;

	}

	final_panel.find(".applicant_id").val(value.id);
	final_panel.find(".title").val(value.title);
	final_panel.find(".first_name").val(value.first_name);
	final_panel.find(".middle_name").val(value.middle_name);
	final_panel.find(".last_name").val(value.last_name);
	final_panel.find(".date_of_birth").val(value.date_of_birth);
	final_panel.find(".dl_number").val(value.dl_number);
	final_panel.find(".dl_exp").val(value.dl_exp);
	final_panel.find(".dl_state").val(value.dl_state);
	final_panel.find(".dl_type").val(value.dl_type);
	final_panel.find(".marital_stat").val(value.marital_stat);
	final_panel.find(".dependents").val(value.dependents);
	final_panel.find(".ages").val(value.ages);
	final_panel.find(".citizen_stat").val(value.citizen_stat);
	final_panel.find(".visa_type").val(value.visa_type);
	final_panel.find(".visa_exp_date").val(value.visa_exp_date);
	final_panel.find(".email").val(value.email);
	final_panel.find(".mobile").val(value.mobile);
	final_panel.find(".other_telephone").val(value.other_telephone);
	final_panel.find(".food_beverage").val(value.food_beverage);
	final_panel.find(".power_gas").val(value.power_gas);
	final_panel.find(".medical").val(value.medical);
	final_panel.find(".insurance").val(value.insurance);
	final_panel.find(".transportation_fuel").val(value.transportation_fuel);
	final_panel.find(".communications").val(value.communications);
	final_panel.find(".recreation").val(value.recreation);
	final_panel.find(".cash_savings").val(value.cash_savings);
	final_panel.find(".personal_effects").val(value.personal_effects);
	final_panel.find(".superannuation").val(value.superannuation);
	final_panel.find(".shares_investments").val(value.shares_investments);
	final_panel.find(".asset_vehicles").val(value.asset_vehicles);
	final_panel.find(".total_assets").val(value.total_assets);
	final_panel.find(".tot_living_cost").val(value.tot_living_cost);
	final_panel.find(".statement_1").val(value.statement_1);
	final_panel.find(".statement_2").val(value.statement_2);
	final_panel.find(".statement_3").val(value.statement_3);
	final_panel.find(".statement_4").val(value.statement_4);
	final_panel.find(".statement_5").val(value.statement_5);
	final_panel.find(".sex").val(value.sex);

	if(value.visa_holder == "1")
		final_panel.find(".visa_holder").prop("checked", true);
	else
		final_panel.find(".visa_holder").prop("checked", false);

	// if(value.tot_living_cost_check == "1")
	// 	final_panel.find(".tot_living_cost_check").prop("checked", true);
	// else
	// 	final_panel.find(".tot_living_cost_check").prop("checked", false);

	//address js
	if(modal_data.address_arr[index].length > 0)
	{
		$.each(modal_data.address_arr[index], function(add_index, add_value)
			   {
			var child_panel       = final_panel.find('.address-clause').find(".prev_address_panel:first").clone();
			var first_child_panel = final_panel.find('.address-clause').find('.initial_address_panel');
			var second_child_panel = final_panel.find('.address-clause').find('.prev_address_panel:first');
			var parent_panel      = final_panel.find('.address-clause').find(".prev_panel_parent");
			var id                = parent_panel.find('.prev_address_panel').length;
			var final_family_panel;

			var ctr = child_panel.find('.form-control').length;

			var temp_ctr = 1;

			child_panel.find('input').val('');

			if(add_index > 0)
			{
				if(add_index > 1 && add_index != 0){
					final_family_panel = child_panel;
				}else{
					final_family_panel = second_child_panel;
				}

				final_family_panel.find('.form-control').each(function(key, value)
															  {
					var input      = $(this);

					input.val('');

					// var name       = input.closest('.panel').find('.panel-title-fapplication').text().replace(/[0-9]/g, id + 1);

					var name      = input.closest('.panel').find('.panel-title-fapplication').text().replace(/[0-9]/g, "");
					var curr_name_number = parseInt(id) + 1;

					if(add_index > 1 && add_index != 0){
						name = name + " "+ curr_name_number.toString();
					}

					var curr_name = input.attr('name');

					var str_index   = curr_name.indexOf("[");
					var str_index_2 = curr_name.indexOf("]");
					var str_index_3 = curr_name.lastIndexOf("]");
					var str_core_1  = curr_name.substring(str_index, str_index_2 + 1);
					var str_core_2  = curr_name.substring(str_index_2 + 1, str_index_3 + 1);
					var new_name    = curr_name.substring(0,str_index);
					str_core_2      = str_core_2.replace(/[0-9]/g, id);
					new_name        = new_name + str_core_1 + str_core_2;

					input.attr('name', new_name);
					// input.closest('.panel').find('.panel-title-fapplication').text(name);
					if(ctr==temp_ctr)
						input.closest('.panel').find('.panel-title-fapplication').text(name);

					temp_ctr++;
				});
				final_family_panel.find(".client_res_stat_panel").prop("hidden", true);
				final_family_panel.find('.landlord-hidden').prop('hidden', true);
				final_family_panel.find('.name_on_title_row').prop('hidden', true);
				final_family_panel.find('.monthly_comm_2').prop('hidden', true);

				if(add_index > 1 && add_index != 0)
				{
					parent_panel.append(final_family_panel);
				}
				else
				{
					final_panel.find('.address-clause').find(".prev_panel_parent").find('.prev_address_panel:first').prop("hidden", false);
				}
			}
			else
			{
				final_family_panel = first_child_panel;

				if(add_value.client_res_stat == 'renting' || add_value.client_res_stat == 'boarding')
					final_family_panel.find('.landlord-hidden').prop('hidden', false);
				else
					final_family_panel.find('.landlord-hidden').prop('hidden', true);

				if(add_value.client_res_stat == 'mortgage' || add_value.client_res_stat == 'owner')
					final_family_panel.find('.name_on_title_row').prop('hidden', false);
				else
					final_family_panel.find('.name_on_title_row').prop('hidden', true);

				if(add_value.client_res_stat == 'Boarding' || add_value.client_res_stat == 'Employer Subsidised'  || add_value.client_res_stat == 'Living with parents')
					final_family_panel.find('.monthly_comm_2').prop('hidden', false);
				else
					final_family_panel.find('.monthly_comm_2').prop('hidden', true);

			}

			final_family_panel.find('.address_id').val(add_value.id);
			final_family_panel.find('.client_unit').val(add_value.client_unit);
			final_family_panel.find('.client_address').val(add_value.client_address);
			final_family_panel.find('.client_suburb').val(add_value.client_suburb);
			final_family_panel.find('.client_post_code').val(add_value.client_postcode);
			final_family_panel.find('.client_res_stat').val(add_value.client_res_stat);
			final_family_panel.find('.client_state').val(add_value.client_state);
			final_family_panel.find('.time_address_years').val(add_value.time_address_years);
			final_family_panel.find('.time_address_month').val(add_value.time_address_months);
			final_family_panel.find('.landlord_realestate_name').val(add_value.landlord_realestate_name);
			final_family_panel.find('.landlord_realestate_contact').val(add_value.landlord_realestate_contact);
			final_family_panel.find('.landlord_realestate_number').val(add_value.landlord_realestate_number);
			final_family_panel.find('.monthly_commitment').val(add_value.monthly_commitment);
			final_family_panel.find('.name_on_title').val(add_value.name_on_title);
			final_family_panel.find('.monthly_commitment_2').val(add_value.monthly_commitment_2);
			final_family_panel.find('.address_further_details').val(add_value.address_further_details);
			final_family_panel.find('.number_on_lease').val(add_value.number_on_lease);
		}); 
	}

	//employer js
	if(modal_data.employee_arr[index].length > 0)
	{
		$.each(modal_data.employee_arr[index], function(emp_index, emp_value)
			   {
			var child_panel       = final_panel.find('.employer_clause').find(".prev_employer_panel:first").clone();
			var first_child_panel = final_panel.find('.employer_clause').find('.initial_employer_panel');
			var second_child_panel = final_panel.find('.employer_clause').find('.prev_employer_panel:first');
			var parent_panel      = final_panel.find('.employer_clause').find(".prev_emp_panel_parent");
			var id                = parent_panel.find('.prev_employer_panel').length;
			var final_family_panel;

			var ctr = child_panel.find('.form-control').length;

			var temp_ctr = 1;

			child_panel.find('input').val('');

			if(emp_index > 0)
			{
				if(emp_index > 1 && emp_index != 0){
					final_family_panel = child_panel;
				}else{
					final_family_panel = second_child_panel;
				}

				final_family_panel.find('.form-control').each(function(key, value)
															  {
					var input      = $(this);

					input.val('');

					var name      = input.closest('.panel').find('.panel-title-fapplication').text().replace(/[0-9]/g, "");
					var curr_name_number = parseInt(id) + 1;
					if(emp_index > 1 && emp_index != 0){
						name = name + " "+ curr_name_number.toString();
					}

					var curr_name = input.attr('name');

					var str_index   = curr_name.indexOf("[");
					var str_index_2 = curr_name.indexOf("]");
					var str_index_3 = curr_name.lastIndexOf("]");
					var str_core_1  = curr_name.substring(str_index, str_index_2 + 1);
					var str_core_2  = curr_name.substring(str_index_2 + 1, str_index_3 + 1);
					var new_name    = curr_name.substring(0,str_index);
					str_core_2      = str_core_2.replace(/[0-9]/g, id);
					new_name        = new_name + str_core_1 + str_core_2;

					input.attr('name', new_name);
					// input.closest('.panel').find('.panel-title-fapplication').text(name);
					if(ctr==temp_ctr)
						input.closest('.panel').find('.panel-title-fapplication').text(name);

					temp_ctr++;
				});

				final_family_panel.find(".employer_hidden_panels").prop("hidden", true);

				// parent_panel.append(final_family_panel);

				if(emp_index > 1 && emp_index != 0)
				{
					parent_panel.append(final_family_panel);
				}
				else
				{
					final_panel.find('.employer_clause').find(".prev_emp_panel_parent").find('.prev_employer_panel:first').prop("hidden", false);
				}
			}
			else
			{
				final_family_panel = first_child_panel;

				final_family_panel.find('.emp_abn_panel').prop('hidden', true);
			}

			final_family_panel.find('.employer_id').val(emp_value.id);
			final_family_panel.find('.employer_name').val(emp_value.employer_name);
			final_family_panel.find('.employment_status').val(emp_value.employment_status);
			final_family_panel.find('.occ_position').val(emp_value.occ_position);
			final_family_panel.find('.emp_unit').val(emp_value.emp_unit);
			final_family_panel.find('.emp_address').val(emp_value.emp_address);
			final_family_panel.find('.emp_suburb').val(emp_value.emp_suburb);
			final_family_panel.find('.emp_post').val(emp_value.emp_post);
			final_family_panel.find('.emp_state').val(emp_value.emp_state);
			final_family_panel.find('.net_income').val(emp_value.net_income);
			final_family_panel.find('.sal_pax_ded').val(emp_value.sal_pax_ded);
			final_family_panel.find('.ytd').val(emp_value.ytd);
			final_family_panel.find('.contact_person').val(emp_value.contact_person);
			final_family_panel.find('.contact_number').val(emp_value.contact_number);
			final_family_panel.find('.time_employer_years').val(emp_value.time_employer_years);
			final_family_panel.find('.time_employer_month').val(emp_value.time_employer_month);
			final_family_panel.find('.emp_abn').val(emp_value.emp_abn);
			final_family_panel.find('.emp_industry').val(emp_value.industry);

			final_family_panel.closest(".employer_clause").find('.other_income_clause').find('.false-panel').not(':first').remove();

			if(modal_data.other_inc_array[index][emp_index].length > 0)
			{
				$.each(modal_data.other_inc_array[index][emp_index], function(other_inc_index, other_inc_value)
					   {
					//console.log(modal_data.other_inc_array[index][emp_index][other_inc_index]);

					final_family_panel.closest(".employer_clause").find('.other_income_clause').find('.false-panel:first').find('.panel-body').prop('hidden', false);
					final_family_panel.closest(".employer_clause").find('.other_income_clause').find('.false-panel:first').find('.new').prop('hidden', false);
					final_family_panel.closest(".employer_clause").find('.other_income_clause').find('.false-panel:first').find('.default').remove();

					final_family_panel.closest(".employer_clause").find('.other_income_clause').find('.false-panel:first').find(".remove_other_income").prop("disabled", false);

					var child_panel       = final_family_panel.closest(".employer_clause").find('.other_income_clause').find('.false-panel:first').clone();
					var first_child_panel = final_family_panel.closest(".employer_clause").find('.other_income_clause').find('.false-panel:first');
					var parent_panel      = final_family_panel.closest(".employer_clause").find('.other_income_clause');
					var id                = final_family_panel.closest(".employer_clause").find('.false-panel').length;
					var final_sub_panel;

					var ctr = child_panel.find('.form-control').length;

					var temp_ctr = 1;

					child_panel.find('input').val('');

					if(other_inc_index > 0)
					{
						final_sub_panel = child_panel;

						final_sub_panel.find('.form-control').each(function(key, value)
																   {
							var input      = $(this);

							input.val('');

							// var name       = input.closest('.false-panel').find('.panel-title-3rd-dim').text().replace(/[0-9]/g, id + 1);

							var name      = input.closest('.false-panel').find('.panel-title-3rd-dim').text().replace(/[0-9]/g, "");
							var curr_name_number = parseInt(id) + 1;
							name = name + " "+ curr_name_number.toString();

							var curr_name   = input.attr('name');
							var sec_pos     = getPosition(curr_name,"[",2);
							var third_pos   = getPosition(curr_name,"[",3);

							var str_index   = curr_name.indexOf("[");
							var str_index_2 = curr_name.indexOf("]");
							var str_core_1  = curr_name.substring(str_index, str_index_2 + 1);
							var str_core_2  = curr_name.substring(str_index_2 + 1, sec_pos + 3);
							var str_core_3  = curr_name.substring(third_pos, third_pos + 3);
							var new_name    = curr_name.substring(0,str_index);
							str_core_3      = str_core_3.replace(/[0-9]/g, id);
							new_name        = new_name + str_core_1 + str_core_2 + str_core_3;

							input.attr('name', new_name);
							// input.closest('.false-panel').find('.panel-title-3rd-dim').text(name);
							if(ctr==temp_ctr)
								input.closest('.false-panel').find('.panel-title-3rd-dim').text(name);

							temp_ctr++;
						});

						parent_panel.append(final_sub_panel);
					}
					else
					{
						final_sub_panel = first_child_panel;
					}

					final_sub_panel.closest(".employer_clause").find('.other_income_id').val(other_inc_value.id);
					final_sub_panel.closest(".employer_clause").find('.other_income_name').val(other_inc_value.other_income_name);
					final_sub_panel.closest(".employer_clause").find('.other_income_details').val(other_inc_value.other_income_details);
					final_sub_panel.closest(".employer_clause").find('.other_income_amount').val(other_inc_value.other_income_amount);

				});
			}
		});
	}
	//reference js

	if(modal_data.reference_arr[index].length > 0)
	{
		final_panel.find('.cred_reference_clause').find('.panel:first').find('.panel-body').prop('hidden', false);
		final_panel.find('.cred_reference_clause').find('.panel:first').find('.new').prop('hidden', false);
		final_panel.find('.cred_reference_clause').find('.panel:first').find('.default').remove();

		final_panel.find('.cred_reference_clause').find('.panel:first').find(".remove").prop("disabled", false);

		$.each(modal_data.reference_arr[index], function(ref_index, ref_value)
			   {
			var child_panel       = final_panel.find('.cred_reference_clause').find('.panel:first').clone();
			var first_child_panel = final_panel.find('.cred_reference_clause').find('.panel:first');
			var parent_panel      = final_panel.find('.cred_reference_clause');
			var id                = parent_panel.find('.panel').length;
			var final_family_panel;

			var ctr = child_panel.find('.form-control').length;

			var temp_ctr = 1;

			child_panel.find('input').val('');

			if(ref_index > 0)
			{
				final_family_panel = child_panel;

				final_family_panel.find('.form-control').each(function(key, value)
															  {
					var input      = $(this);

					input.val('');

					// var name       = input.closest('.panel').find('.panel-title-fapplication').text().replace(/[0-9]/g, id + 1);
					var name      = input.closest('.panel').find('.panel-title-fapplication').text().replace(/[0-9]/g, "");
					var curr_name_number = parseInt(id) + 1;
					name = name + " "+ curr_name_number.toString();

					var curr_name = input.attr('name');

					var str_index   = curr_name.indexOf("[");
					var str_index_2 = curr_name.indexOf("]");
					var str_index_3 = curr_name.lastIndexOf("]");
					var str_core_1  = curr_name.substring(str_index, str_index_2 + 1);
					var str_core_2  = curr_name.substring(str_index_2 + 1, str_index_3 + 1);
					var new_name    = curr_name.substring(0,str_index);
					str_core_2      = str_core_2.replace(/[0-9]/g, id);
					new_name        = new_name + str_core_1 + str_core_2;

					input.attr('name', new_name);
					if(ctr==temp_ctr)
						input.closest('.panel').find('.panel-title-fapplication').text(name);

					temp_ctr++;
				});

				parent_panel.append(final_family_panel);
			}
			else
			{
				final_family_panel = first_child_panel;
			}

			final_family_panel.find('.credit_reference_id').val(ref_value.id);
			final_family_panel.find('.r_first_name').val(ref_value.r_first_name);
			final_family_panel.find('.r_last_name').val(ref_value.r_last_name);
			final_family_panel.find('.r_telephone').val(ref_value.r_telephone);
			final_family_panel.find('.r_unit').val(ref_value.r_unit);
			final_family_panel.find('.r_address').val(ref_value.r_address);
			final_family_panel.find('.r_suburb').val(ref_value.r_suburb);
			final_family_panel.find('.r_postcode').val(ref_value.r_postcode);
			final_family_panel.find('.r_business_name').val(ref_value.r_business_name);
		});
	}
	//liabilites js

	if(modal_data.liabilities_arr[index].length > 0)
	{
		final_panel.find('.property_clause').find('.panel:first').find('.panel-body').prop('hidden', false);
		final_panel.find('.property_clause').find('.panel:first').find('.new').prop('hidden', false);
		final_panel.find('.property_clause').find('.panel:first').find('.default').remove();

		final_panel.find('.property_clause').find('.panel:first').find(".remove").prop("disabled", false);

		$.each(modal_data.liabilities_arr[index], function(lia_index, lia_value)
			   {
			var child_panel       = final_panel.find('.property_clause').find('.panel:first').clone();
			var first_child_panel = final_panel.find('.property_clause').find('.panel:first');
			var parent_panel      = final_panel.find('.property_clause');
			var id                = parent_panel.find('.panel').length;
			var final_family_panel;

			var ctr = child_panel.find('.form-control').length;

			var temp_ctr = 1;

			child_panel.find('input').val('');

			if(lia_index > 0)
			{
				final_family_panel = child_panel;

				final_family_panel.find('.form-control').each(function(key, value)
															  {
					var input      = $(this);

					input.val('');

					// var name       = input.closest('.panel').find('.panel-title-fapplication').text().replace(/[0-9]/g, id + 1);
					var name      = input.closest('.panel').find('.panel-title-fapplication').text().replace(/[0-9]/g, "");
					var curr_name_number = parseInt(id) + 1;
					name = name + " "+ curr_name_number.toString();

					var curr_name = input.attr('name');

					var str_index   = curr_name.indexOf("[");
					var str_index_2 = curr_name.indexOf("]");
					var str_index_3 = curr_name.lastIndexOf("]");
					var str_core_1  = curr_name.substring(str_index, str_index_2 + 1);
					var str_core_2  = curr_name.substring(str_index_2 + 1, str_index_3 + 1);
					var new_name    = curr_name.substring(0,str_index);
					str_core_2      = str_core_2.replace(/[0-9]/g, id);
					new_name        = new_name + str_core_1 + str_core_2;

					input.attr('name', new_name);
					if(ctr==temp_ctr)
						input.closest('.panel').find('.panel-title-fapplication').text(name);

					temp_ctr++;
				});

				parent_panel.append(final_family_panel);
			}
			else
			{
				final_family_panel = first_child_panel;
			}

			final_family_panel.find('.property_id').val(lia_value.id);
			final_family_panel.find('.property_unit').val(lia_value.property_unit);
			final_family_panel.find('.property_address').val(lia_value.property_address);
			final_family_panel.find('.property_suburb').val(lia_value.property_suburb);
			final_family_panel.find('.property_postcode').val(lia_value.property_postcode);
			final_family_panel.find('.mortgage_with').val(lia_value.mortgage_with);
			final_family_panel.find('.mortgage_commitment').val(lia_value.mortgage_commitment);
			final_family_panel.find('.balance').val(lia_value.balance);
			final_family_panel.find('.property_value').val(lia_value.property_value);
			final_family_panel.find('.monthly_payment').val(lia_value.monthly_payment);

			if(lia_value.managed == "1")
				final_family_panel.find(".managed").prop("checked", true);
			else
				final_family_panel.find(".managed").prop("checked", false);

			if(lia_value.name_on_title == "1")
				final_family_panel.find(".name_on_title").prop("checked", true);
			else
				final_family_panel.find(".name_on_title").prop("checked", false);

			total_property_val = total_property_val + parseFloat(lia_value.property_value);
		});
	}
	//credit card js
	if(modal_data.credit_card_arr[index].length > 0)
	{
		final_panel.find('.cred_card_clause').find('.panel:first').find('.panel-body').prop('hidden', false);
		final_panel.find('.cred_card_clause').find('.panel:first').find('.new').prop('hidden', false);
		final_panel.find('.cred_card_clause').find('.panel:first').find('.default').remove();

		final_panel.find('.cred_card_clause').find('.panel:first').find(".remove").prop("disabled", false);

		$.each(modal_data.credit_card_arr[index], function(cred_index, cred_value)
			   {
			var child_panel       = final_panel.find('.cred_card_clause').find('.panel:first').clone();
			var first_child_panel = final_panel.find('.cred_card_clause').find('.panel:first');
			var parent_panel      = final_panel.find('.cred_card_clause');
			var id                = parent_panel.find('.panel').length;
			var final_family_panel;

			var ctr = child_panel.find('.form-control').length;

			var temp_ctr = 1;

			child_panel.find('input').val('');

			if(cred_index > 0)
			{
				final_family_panel = child_panel;

				final_family_panel.find('.form-control').each(function(key, value)
															  {
					var input      = $(this);

					input.val('');

					var name      = input.closest('.panel').find('.panel-title-fapplication').text().replace(/[0-9]/g, "");
					var curr_name_number = parseInt(id) + 1;
					name = name + " "+ curr_name_number.toString();

					var curr_name = input.attr('name');

					var str_index   = curr_name.indexOf("[");
					var str_index_2 = curr_name.indexOf("]");
					var str_index_3 = curr_name.lastIndexOf("]");
					var str_core_1  = curr_name.substring(str_index, str_index_2 + 1);
					var str_core_2  = curr_name.substring(str_index_2 + 1, str_index_3 + 1);
					var new_name    = curr_name.substring(0,str_index);
					str_core_2      = str_core_2.replace(/[0-9]/g, id);
					new_name        = new_name + str_core_1 + str_core_2;

					input.attr('name', new_name);
					if(ctr==temp_ctr)
						input.closest('.panel').find('.panel-title-fapplication').text(name);

					temp_ctr++;
				});

				parent_panel.append(final_family_panel);
			}
			else
			{
				final_family_panel = first_child_panel;
			}

			final_family_panel.find('.credit_card_id').val(cred_value.id);
			final_family_panel.find('.credit_card_name').val(cred_value.credit_card_name);
			final_family_panel.find('.credit_card_limit').val(cred_value.credit_card_limit);
			final_family_panel.find('.credit_card_balance').val(cred_value.credit_card_balance);
			final_family_panel.find('.credit_card_monthly').val(cred_value.credit_card_monthly);

		});
	}
	// console.log(modal_data.other_loans_arr[index].length); return false;
	//other loans js
	if(modal_data.other_loans_arr[index].length > 0)
	{
		final_panel.find('.loan_clause').find('.panel:first').find('.panel-body').prop('hidden', false);
		final_panel.find('.loan_clause').find('.panel:first').find('.new').prop('hidden', false);
		final_panel.find('.loan_clause').find('.panel:first').find('.default').remove();

		final_panel.find('.loan_clause').find('.panel:first').find(".remove").prop("disabled", false);

		$.each(modal_data.other_loans_arr[index], function(loans_index, loans_value)
			   {
			var child_panel       = final_panel.find('.loan_clause').find('.panel:first').clone();
			var first_child_panel = final_panel.find('.loan_clause').find('.panel:first');
			var parent_panel      = final_panel.find('.loan_clause');
			var id                = parent_panel.find('.panel').length;
			var final_family_panel;

			var ctr = child_panel.find('.form-control').length;

			var temp_ctr = 1;

			child_panel.find('input').val('');

			if(loans_index > 0)
			{
				final_family_panel = child_panel;

				final_family_panel.find('.form-control').each(function(key, value)
															  {
					var input      = $(this);

					input.val('');

					var name      = input.closest('.panel').find('.panel-title-fapplication').text().replace(/[0-9]/g, "");
					var curr_name_number = parseInt(id) + 1;
					name = name + " "+ curr_name_number.toString();

					var curr_name = input.attr('name');

					var str_index   = curr_name.indexOf("[");
					var str_index_2 = curr_name.indexOf("]");
					var str_index_3 = curr_name.lastIndexOf("]");
					var str_core_1  = curr_name.substring(str_index, str_index_2 + 1);
					var str_core_2  = curr_name.substring(str_index_2 + 1, str_index_3 + 1);
					var new_name    = curr_name.substring(0,str_index);
					str_core_2      = str_core_2.replace(/[0-9]/g, id);
					new_name        = new_name + str_core_1 + str_core_2;

					input.attr('name', new_name);
					if(ctr==temp_ctr)
						input.closest('.panel').find('.panel-title-fapplication').text(name);

					temp_ctr++;
				});

				parent_panel.append(final_family_panel);
			}
			else
			{
				final_family_panel = first_child_panel;
			}

			final_family_panel.find('.other_loans_id').val(loans_value.id);
			final_family_panel.find('.lending_institution').val(loans_value.lending_institution);
			final_family_panel.find('.purpose').val(loans_value.purpose);
			final_family_panel.find('.amount_borrowed').val(loans_value.amount_borrowed);
			final_family_panel.find('.o_term').val(loans_value.o_term);
			final_family_panel.find('.loan_start_date').val(loans_value.loan_start_date);
			final_family_panel.find('.o_balloon_percentage').val(loans_value.o_balloon_percentage);
			final_family_panel.find('.o_balloon_amt').val(loans_value.o_balloon_amt);
			final_family_panel.find('.o_monthly_payment').val(loans_value.monthly_commitment);

		});	
	}

	if(modal_data.other_asset_arr[index].length > 0)
	{
		final_panel.find('.asset_clause').find('.panel:first').find('.panel-body').prop('hidden', false);
		final_panel.find('.asset_clause').find('.panel:first').find('.new').prop('hidden', false);
		final_panel.find('.asset_clause').find('.panel:first').find('.default').remove();

		$.each(modal_data.other_asset_arr[index], function(asset_index, asset_value)
			   {
			var child_panel       = final_panel.find('.asset_clause').find('.panel:first').clone();
			var first_child_panel = final_panel.find('.asset_clause').find('.panel:first');
			var parent_panel      = final_panel.find('.asset_clause');
			var id                = parent_panel.find('.panel').length;
			var final_family_panel;

			var ctr = child_panel.find('.form-control').length;

			var temp_ctr = 1;

			child_panel.find('input').val('');

			if(asset_index > 0)
			{
				final_family_panel = child_panel;

				final_family_panel.find('.form-control').each(function(key, value)
															  {
					var input      = $(this);

					input.val('');

					var name      = input.closest('.panel').find('.panel-title-fapplication').text().replace(/[0-9]/g, "");
					var curr_name_number = parseInt(id) + 1;
					name = name + " "+ curr_name_number.toString();

					var curr_name = input.attr('name');

					var str_index   = curr_name.indexOf("[");
					var str_index_2 = curr_name.indexOf("]");
					var str_index_3 = curr_name.lastIndexOf("]");
					var str_core_1  = curr_name.substring(str_index, str_index_2 + 1);
					var str_core_2  = curr_name.substring(str_index_2 + 1, str_index_3 + 1);
					var new_name    = curr_name.substring(0,str_index);
					str_core_2      = str_core_2.replace(/[0-9]/g, id);
					new_name        = new_name + str_core_1 + str_core_2;

					input.attr('name', new_name);
					if(ctr==temp_ctr)
						input.closest('.panel').find('.panel-title-fapplication').text(name);

					temp_ctr++;
				});

				parent_panel.append(final_family_panel);
			}
			else
			{
				final_family_panel = first_child_panel;
			}

			final_family_panel.find('.other_asset_id').val(asset_value.id);
			final_family_panel.find('.other_asset_name').val(asset_value.other_asset_name);
			final_family_panel.find('.other_asset_value').val(asset_value.other_asset_value);

		});	
	}

	final_panel.find('.tot_prop_value').val(total_property_val);

	var b_stmnt = final_panel.find(".borrowers_statement");
	var b_rows  = b_stmnt.find(".row");

	if(global_cust_type == "sole_trader" || global_cust_type == "joint" || global_cust_type == "individual")
	{
		var index = 1;

		$(b_rows).each(function()
					   {
			$(this).find("p").html(state_type_1[index-1]);
			b_stmnt.find(".statement_"+index).closest('.row').attr('hidden', false);
			index++
		});

		b_stmnt.find(".statement_5").closest('.row').attr('hidden', true);
	}
	else
	{
		var index = 1;

		$(b_rows).each(function()
					   {
			$(this).find("p").html(state_type_2[index-1]);
			b_stmnt.find(".statement_"+index).closest('.row').attr('hidden', false);
			index++
		});

		b_stmnt.find(".statement_5").closest('.row').attr('hidden', false);
	}
});
//JAVASCRIPT FAPPLICATION FIELDS END//

if($(document).find('.panel-main:first').find(".mobile").val() == "")
	$(document).find('.panel-main:first').find(".mobile").val(modal_data.lead_phone);

if($(document).find('.panel-main:first').find(".other_telephone").val() == "")
	$(document).find('.panel-main:first').find(".other_telephone").val(modal_data.lead_mobile);

if($(document).find('.panel-main:first').find(".email").val() == "")
	$(document).find('.panel-main:first').find(".email").val(modal_data.lead_email);

if($(document).find('.panel-main:first').find('.address-clause:first').find('.client_state').val()=="")
	$(document).find('.panel-main:first').find('.address-clause:first').find('.client_state').val(modal_data.lead_state);

var curr_req = "";

$(document).on('click', '.requirements', function(){
	
	$(document).find("#req_hidden_val").val($(this).data("req"));
	$(document).find("#is_temp_hidden").val($(this).data("istemp"));
	curr_req = $(this);
});

$(document).on('change', '.requirements', function(){
	//console.log("hello!");
});

$(document).find('.requirements').on("addedfile", function(file) {
	//alert("hello");
});
setTimeout(function(){
	$(".toggle.active > label").trigger("click");
	 removeUnderline() 
}, 1000);
$(document).find('.requirements').dropzone ({
	url: '<?php echo site_url('fapplication/upload_requirements/'); ?>',
	init: function() {
            var requirement_fk = "";
            var temp_is = "";
            this.on("sending", function(file, xhr, formData){
                var id             = $('#fapplication_id').val();
                var fk_requirement = $("#req_hidden_val").val();
                var is_temp         = $("#is_temp_hidden").val();

                if(requirement_fk == "")
                {
                    formData.append("id", id);
                    formData.append("fk_requirement", fk_requirement);
                    formData.append("is_temp", is_temp);
                }
                else
                {
                    formData.append("id", id);
                    formData.append("fk_requirement", requirement_fk);
                    formData.append("is_temp", temp_is);	
                }
            }),
            this.on("success", function(file, response){

                if(requirement_fk == "")
                {
                    if(!curr_req.hasClass("requirements_green"))
                    {
                        curr_req.addClass("requirements_green").removeClass("requirements_white");
                        $(curr_req).find("*").removeClass("requirements_white").addClass("requirements_green");
                    }
                }												
                requirement_fk = "";
                temp_is = "";
            }),
            this.on("queuecomplete", function () {
                this.removeAllFiles();
            }),
            this.on("drop", function (event) {

                requirement_fk = event.target.dataset.req;
                temp_is = event.target.dataset.istemp;

                if(event.target.className != "req-panel panel-body requirements dz-clickable requirements_green")
                event.target.className = "req-panel panel-body requirements dz-clickable requirements_green";
            });
        },

});

$("#diarize_modal").modal('hide');

$('#fapplication-modal-3').modal({
	backdrop: 'static',
	keyboard: false
});

set_state($('#fapplication_id').val());

$("#add_note_button").unbind().click(function() {
    let text_area  = $('#note-model-textarea1');
    $('#first_t_c').addClass('active');
    $("#openfirst").show();
    let text_val = text_area.val();    
    var dt = new Date();
    let date_time = dt.toDateString()+' '+dt.getHours() + ':' + dt.getMinutes();
    let char = date_time.length;
    text_area.val(date_time+"\n\n\n" + text_val);
    setCaretToPos(text_area[0], char+1);
    text_area.scrollTop(0);    
    //console.log('clicked');
    text_area.height(text_area.prop('scrollHeight'));
    return false;
});

$('#first_t_c').unbind().click(function() {
	let text_area  = $('#note-model-textarea1');
	let checkTextClass = $(text_area).hasClass('scrollDown');
	if(checkTextClass == false) {
		$(text_area).addClass('scrollDown');
		text_area.height(text_area.prop('scrollHeight'));
	}
	return false;
});

function setSelectionRange(input, selectionStart, selectionEnd) {
    if (input.setSelectionRange) {
        input.focus();
        input.setSelectionRange(selectionStart, selectionEnd);
    } else if (input.createTextRange) {
        var range = input.createTextRange();
        range.collapse(true);
        range.moveEnd('character', selectionEnd);
        range.moveStart('character', selectionStart);
        range.select();
    }
}

function setCaretToPos(input, pos) {
    setSelectionRange(input, pos, pos);
}


$("#tfapplication_start_tender_button").click(function(){
    $( ".start_tender_modal_buttont" ).trigger( "click" );
});

$(".start_tender_modal_buttont").click(function(){
    //  alert(fapplication_id);return false;        
    var modal_data = null;
   /* $.post("<?php echo site_url("fapplication/record"); ?>/" + fapplication_id, function(data){
        $('#start_tender_modal .fapplication_summary_new').html(data.fapplication_summary_new);
    }, 'json');*/

    var name = $("#name").val();
    var email = $("#email").val();
    let email_template_id = $(this).data("email_template_id");
    
    $("#start_tender_form").find("#label_name").html(name);
    $("#start_tender_form").find("#label_email").html(email);
    $("#start_tender_form").find("#email_template_id").val(email_template_id);

    var id_lead = $(this).data("id_lead");
    //	alert(id_lead);
    $("#id_leads").val(id_lead);

    get_car_lead(id_lead,'start_tender_modal');
    get_accessories(id_lead);
    load_dealer_selector_parameters("start_tender_modal", id_lead, "tender");
    get_system_email_template_start_tender();
    $("#start_tender_modal").modal();

});


//edit tender 
$(".edit_tender_modal_button").click(function(e) {

	var name = $("#name").val();
	var email = $("#email").val();
	$("#edit_tender_form").find("#label_name").html(name);
	$("#edit_tender_form").find("#label_email").html(email);

	var id_lead = $(this).data("id_lead");
	var id_quote_request = $(this).data("id_quote_request");
	var id_make = $("#id_make").val();
	var id_family = $("#id_family").val();
	var id_vehicle = $("#id_vehicle").val();
    var build_date = $("#build_date").val();
	var colour = $("#colour").val();
    
	var id_rbdata = $("#id_rbdata").val();

	var registration_type = $("#registration_type").val();
	load_makes("edit_tender_modal", id_make);
	load_families("edit_tender_modal", id_make, id_family);
	
    load_build_dates("edit_tender_modal", id_family, build_date);
	load_vehicles("edit_tender_modal", id_family+'-'+build_date, id_vehicle);
	
    load_options("edit_tender_modal", id_vehicle, id_quote_request);
	// load_accessories("edit_tender_modal", id_quote_request);
	get_accessories(id_lead,'edit_tender_modal');
	load_rbdata("edit_tender_modal", id_make, id_family,build_date,id_rbdata);

	$("#edit_tender_modal").find("#colour").val(colour);
	$("#edit_tender_modal").find("#registration_type [value='"+registration_type+"']").attr("selected", true);

	$("#edit_tender_modal").find("#id_quote_request").val(id_quote_request);
	$("#edit_tender_modal").modal();
});

function edit_tender_get_data(){
    
}

$("#start_valuation_button").click(function(){
    //alert(fapplication_id);return false;
    var modal_data = null;
    var id_lead = $(this).data("id_lead");
    //alert(id_lead);
    $("#start_valuation_form").find("#id_leads").val(id_lead);
    //$("#id_leads").val(id_lead);

    var data = { id_lead: id_lead };

    $.ajax({
        type: "POST",
        url: "<?php echo site_url("lead/get_lead_car_ids"); ?>",
        data: data,
        cache: false,
        dataType: "json",
        success: function(response){
            // console.log(response);
            load_makes("start_valuation_modal", response.id_make);
            load_families("start_valuation_modal", response.id_make, response.id_family);
            //load_build_dates("start_valuation_modal", response.id_family);
            //$("#postcode_ds2").val($('input[name=new_lead_postcode]').val());
            //$("#start_valuation_modal #make_ds").val(response.make_name);            
            rbgetdata("start_valuation_modal",response.id_make,response.id_family, 0);
        }
    });

   // load_dealer_selector_parameters("start_valuation_modal", id_lead, "tender");
    
    $("#start_valuation_modal").modal();
    
});

function set_car_data(){
    //alert(fapplication_id);return false;
    var modal_data = null;
    
    $("#start_valuation_form").find("#id_leads").val(fapplication_id);
    
    var data = { id_lead: fapplication_id };

    $.ajax({
        type: "POST",
        url: "<?=site_url('lead/get_lead_car_ids');?>",
        data: data,
        cache: false,
        dataType: "json",
        success: function(response){
            load_makes("start_valuation_modal", response.id_make);
            load_families("start_valuation_modal", response.id_make, response.id_family);
            rbgetdata("start_valuation_modal",response.id_make,response.id_family, 0);
        }
    });
}

function load_build_dates_tradein(container, family_id, build_date) {
    if(family_id != "") {
        if (build_date == 0 || typeof(build_date) == "undefined") {
            $("#"+container).find("#vehicle").html("<option value='0'></option>");
            $("#"+container).find("#vehicle").prop("disabled", true);
            $("#"+container).find("#option").html("");

            var data = { family_id: family_id };						
        } else {
            var data = { family_id: family_id, build_date: build_date };						
        }

        $.ajax({
            type: "POST",
            url: "<?php echo site_url("cars/load_build_dates_rb"); ?>",
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

/*$(".makeclass_tradein").change(function(){

	$make_id = this.options[this.selectedIndex].value;

	family_id = 0;
	if($make_id != "") {
		if (family_id == 0 || typeof(family_id) == 'undefined') {
			$("#start_valuation_modal").find("#build_date").html("<option value='0'></option>");
			$("#start_valuation_modal").find("#build_date").prop("disabled", true);
			$("#start_valuation_modal").find("#vehicle").html("<option value='0'></option>");
			$("#start_valuation_modal").find("#vehicle").prop("disabled", true);
			$("#start_valuation_modal").find("#option").html("");

			var data = { make_id: $make_id };						
		} else {
			var data = { make_id: make_id, family_id: family_id};
		}

        $.ajax({
            type: "POST",
            url: "<?php echo site_url("cars/load_families"); ?>",
            cache: false,
            data: data,
            success: function(response) {
                //console.log(response);
                $("#start_valuation_modal").find("#family").removeAttr("disabled");
                $("#start_valuation_modal").find("#family").html("<option value='0'></option>");
                $("#start_valuation_modal").find("#family").append(response);
            }
        });
	}
});

$(".modelclass_tradein").change(function() {
	$family_id = this.options[this.selectedIndex].value;
	build_date=0;
	//alert($family_id);
	if($family_id != "") {
		if (build_date == 0 || typeof(build_date) == 'undefined') {
			$("#start_valuation_modal").find("#vehicle").html("<option value='0'></option>");
			$("#start_valuation_modal").find("#vehicle").prop("disabled", true);
			$("#start_valuation_modal").find("#option").html("");

			var data = { family_id: $family_id };						
		} else {
			var data = { family_id: $family_id, build_date: build_date };						
		}

        $.ajax({
            type: "POST",
            url: "<?php echo site_url("cars/load_build_dates"); ?>",
            cache: false,
            data: data,
            success: function(response) {
                $("#start_valuation_modal").find("#build_date").removeAttr("disabled");
                $("#start_valuation_modal").find("#build_date").html("<option value='0'></option>");
                $("#start_valuation_modal").find("#build_date").append(response);
            }
        });
	}
});

$(".builddtclass_tradein").change(function() {
    code=this.options[this.selectedIndex].value;
    vehicle_id = 0;
    if(code != "") {
        if (vehicle_id == 0 || typeof(vehicle_id) == 'undefined') {
            $("#start_tender_modal").find("#options").html("");

            var data = { code: code };
        } else{
            var data = { code: code, vehicle_id: vehicle_id };							
        }

        $.ajax({
            type: "POST",
            url: "<?php echo site_url("cars/load_vehicles"); ?>",
            cache: false,
            data: data,
            success: function(response) {
                $("#start_valuation_modal").find("#vehicle").removeAttr("disabled");
                $("#start_valuation_modal").find("#vehicle").html("<option value='0'></option>");
                $("#start_valuation_modal").find("#vehicle").append(response);
            }
        });
    }
});*/


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

function load_rbdata (container,id_make,id_family,build_date,id_rbdata)
{
	$("#"+container).find("#rb_data").html("");

	var data = {
		id_make: id_make,
		id_family:id_family,
		build_date:build_date,
		id_rbdata:id_rbdata
	};

	$.ajax({
		type: "POST",
		url: "<?php echo site_url('cars/load_rbdata'); ?>",
		cache: false,
		data: data,
		success: function(response){
			$("#"+container).find("#rb_data").append(response);
		}
	});
}

function load_accessories (container, quote_request_id)
{
	$("#"+container).find("#accessory_container").html("");

	var data = {
		quote_request_id: quote_request_id
	};

	$.ajax({
		type: "POST",
		url: "<?php echo site_url('cars/load_accessories'); ?>",
		cache: false,
		data: data,
		success: function(response){
			$("#"+container).find("#accessory_container").append(response);
		}
	});
}

$("#edit_tender_form").submit(function(e) { // Reload //
	var make = $("#edit_tender_modal").find("#make").val();
    var family = $("#edit_tender_modal").find("#family").val();
    var build_date = $("#edit_tender_modal").find("#build_date").val();
    var vehicle = $("#edit_tender_modal").find("#vehicle").val();
    var colour = $("#edit_tender_modal").find("#colour").val();
    var registration_type = $("#edit_tender_modal").find("#registration_type").val();

    var rb_data = $("#edit_tender_modal").find("#rb_data").val();

    if (rb_data == 0 || rb_data == "" || make == 0 || make == "" || family == 0 || family == "" || build_date == 0 || build_date == "" || vehicle == 0 || vehicle == "" || colour == "" || registration_type == ""){
        swal("ERROR", "Please complete all the required fields!", "error");
    } else {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url("lead/update_tender"); ?>",
            data: $("#edit_tender_form").serialize(),
            cache: false,
            success: function(response) {
                var res = response.trim();
                if (res === "success") {
                    $("#edit_tender_modal").modal("hide");
                    swal("SUCCESS", "", "success");
                    //location.reload(true);
                } else {
                    swal("ERROR", "An error occurred! Please contact the administrator", "error");
                }
            }
        });
    }
    e.preventDefault();
});

$("#start_valuation_form").submit(function(e) { // Reload //
    var make = $("#start_valuation_modal").find("#make").val();
    var family = $("#start_valuation_modal").find("#family").val();
    
    var rb_data = $("#start_valuation_modal").find("#rb_data").val();

    /*var form_data = $("#start_valuation_form").serialize();
    form_data += "&fapplication_lead_id=" + encodeURIComponent(fapplication_lead_id);*/
    
    var form_data = new FormData(this);
    form_data.append('fapplication_lead_id', fapplication_lead_id);

    if (rb_data == 0 || rb_data == "" || make == 0 || make == "" || family == 0 || family == ""){
        swal("ERROR", "Please complete all the required fields!", "error");
    }
    else {

    	let old_images = $('#old_images').val();
    	let images = $('#images').val();
    	
    	$.ajax({
            type: "POST",
            url: "<?php echo site_url("tradein/save_tradeIn"); ?>",
            data: form_data,            
            contentType: false,
            processData: false,
            cache: false,
            success: function(response) {
            	console.log(response);
                var json = $.parseJSON(response);
                if (json['sucess'] == 'Insert'){
                    swal("SUCCESS", "", "success");
                    tradeInform_changedFlag = 0;
                }
                if (json['sucess'] == 'Update'){
                    swal("SUCCESS", "", "success");
                	tradeInform_changedFlag = 0;
                	save_fapplication_info_2(22);
                }
                if (json['fileUpload'] == 'sucess'){
                    $('#photos').val('');
                    tradeInform_changedFlag = 0;
                    location.reload(true);
                }
                if(json['fileUpload'] == 'error'){
                    swal("ERROR", "An error occurred during upload photos!", "error");
                }
                if(json['error'] == 'LeadEmpty'){
                    swal("ERROR", "An error occurred! Please try again", "error");
                    return false;
                }                    
                if(json['error'] == 'NotIns'){
                    swal("ERROR", "An error occurred! Please try again", "error");
                    return false;
                }
            }
        });
    }
    e.preventDefault();
});

/*$(document).on('submit', '#start_valuation_form', function (e) {
    e.preventDefault();
    var make = $("#start_valuation_modal").find("#make").val();
    var family = $("#start_valuation_modal").find("#family").val();    
    var rb_data = $("#start_valuation_modal").find("#rb_data").val();

    //var form_data = $("#start_valuation_form").serialize();
    var form_data = new FormData(this);
    form_data.append('fapplication_lead_id', fapplication_lead_id);
    //form_data += "&fapplication_lead_id=" + encodeURIComponent(fapplication_lead_id);
    
    if (rb_data == 0 || rb_data == "" || make == 0 || make == "" || family == 0 || family == ""){
        
        swal("ERROR", "Please complete all the required fields!", "error");
        
    } else {
        
        $.ajax({
            url: "<?php echo site_url("tradein/save_tradeIn"); ?>",
            type: "POST",
            //processData: false,
            //contentType: false,
            data: form_data,
            cache: false,
            fileElementId	:'photos',
            success: function (response) {
                var json = $.parseJSON(response);
                if (json['sucess'] == 'Insert'){
                    swal("SUCCESS", "", "success");
                }
                if (json['sucess'] == 'Update'){
                    swal("SUCCESS", "", "success");
                }
                if(json['error'] == 'LeadEmpty'){
                    swal("ERROR", "An error occurred! Please try again", "error");
                    return false;
                }                    
                if(json['error'] == 'NotIns'){
                    swal("ERROR", "An error occurred! Please try again", "error");
                    return false;
                }
                return false;
            },
        });
        return false;        
    }    
});	*/


$(".varientclass").change(function(){

	vehicle_id=this.options[this.selectedIndex].value;
	quote_request_id=0;

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

		$("#start_tender_modal").find("#options").html("");
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('cars/load_options'); ?>",
			cache: false,
			data: data,
			success: function(response){
				$("#start_tender_modal").find("#options").append(response);
			}
		});
	}


});

$(document).on("click",".add_accessory_button",function(evt){
    evt.stopPropagation();
    var container = $(this).data("container");
	var item = '<hr />\
    <input class="form-control input-md" name="accessory_name[]" type="text" class="" placeholder="Accessory"><br />\
    <textarea class="form-control" style="display:none" name="accessory_desc[]" id="textareaDefault" placeholder="Description"></textarea>';
	$("#"+container).find("#accessory_container").append(item);
});

$(document).on("click",".remove_accessory_button",function(){    
    $(this).closest('.accessory_name').remove();    
});

$(".builddtclass").change(function(){
    code=this.options[this.selectedIndex].value;
    vehicle_id = 0;
    if(code != "")
    {
        if (vehicle_id == 0 || typeof(vehicle_id) == 'undefined') 
        {
            $("#start_tender_modal").find("#options").html("");

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
                $("#start_tender_modal").find("#vehicle").removeAttr("disabled");
                $("#start_tender_modal").find("#vehicle").html("<option value='0'></option>");
                $("#start_tender_modal").find("#vehicle").append(response);
            }
        });
    }

});

$(".makeclass").change(function(){

	$make_id = this.options[this.selectedIndex].value;

	family_id = 0;
	if($make_id != "")
	{
		if (family_id == 0 || typeof(family_id) == 'undefined')
		{
			$("#start_tender_modal").find("#build_date").html("<option value='0'></option>");
			$("#start_tender_modal").find("#build_date").prop("disabled", true);
			$("#start_tender_modal").find("#vehicle").html("<option value='0'></option>");
			$("#start_tender_modal").find("#vehicle").prop("disabled", true);
			$("#start_tender_modal").find("#option").html("");

			var data = {
				make_id: $make_id
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
                $("#start_tender_modal").find("#family").removeAttr("disabled");
                $("#start_tender_modal").find("#family").html("<option value='0'></option>");
                $("#start_tender_modal").find("#family").append(response);
            }
        });
	}

});

$(".modelclass").change(function(){

	$family_id = this.options[this.selectedIndex].value;
	build_date=0;
	//alert($family_id);
	if($family_id != "")
	{
		if (build_date == 0 || typeof(build_date) == 'undefined')
		{
			$("#start_tender_modal").find("#vehicle").html("<option value='0'></option>");
			$("#start_tender_modal").find("#vehicle").prop("disabled", true);
			$("#start_tender_modal").find("#option").html("");

			var data = {
				family_id: $family_id
			};						
		}
		else
		{
			var data = {
				family_id: $family_id,
				build_date: build_date
			};						
		}


        $.ajax({
            type: "POST",
            url: "<?php echo site_url("cars/load_build_dates"); ?>",
            cache: false,
            data: data,
            success: function(response){
                $("#start_tender_modal").find("#build_date").removeAttr("disabled");
                $("#start_tender_modal").find("#build_date").html("<option value='0'></option>");
                $("#start_tender_modal").find("#build_date").append(response);
            }
        });
	}

});

$(document).on('change','#start_tender_form #make_ds',function(){
	$("#start_tender_modal").find("#make_ds").val($(this).val());
	load_suggested_dealers('start_tender_modal');
});

$(document).on('change','#start_tender_form #state_ds',function(){
	$("#start_tender_modal").find("#state_ds").val($(this).val());
	load_suggested_dealers('start_tender_modal');
});


$(".add_dealers_modal_button").click(function(e) {

	var id_lead = $(this).data("id_lead");
	let email_template_id = $(this).data("email_template_id");
	//	alert(id_lead);
	$("#id_leads").val(id_lead);
	var name = $("#client_details_form").find("#name").val();
	var email = $("#client_details_form").find("#email").val();
	$("#add_dealers_form").find("#label_name").html(name);
	$("#add_dealers_form").find("#label_email").html(email);

	var id_lead = $(this).data("id_lead");
	var id_quote_request = $(this).data("id_quote_request");
	//console.log(id_quote_request);
	load_dealer_selector_parameters("add_dealers_modal", id_lead, "quote_request");

	$("#add_dealers_modal").find("#id_quote_request").val(id_quote_request);
	$("#add_dealers_modal").find("#id_lead").val(id_lead);
	$("#add_dealers_modal").find("#email_template_id").val(email_template_id);

	$("#add_dealers_modal").modal();
});

$(".email_dealer_trade_details").click(function(e) {
    
    var id_lead = $(this).data("id_lead");
    var id_tradein = $(this).data("id_tradein");
    let email_template_id = $(this).data("email_template_id");
    //console.log(id_lead);

    $("#id_leads").val(id_lead);
    var name = $("#client_details_form").find("#name").val();
    var email = $("#client_details_form").find("#email").val();
    $("#email_dealer_trade_form").find("#label_name").html(name);
    $("#email_dealer_trade_form").find("#label_email").html(email);

    $("#email_dealer_trade_model").find("#id_tradein").val(id_tradein);
    $("#email_dealer_trade_model").find("#id_lead").val(id_lead);
    $("#email_dealer_trade_model").find("#email_template_id").val(email_template_id);

    load_dealer_selector_parameters("email_dealer_trade_model", id_lead, "quote_request");

    $("#email_dealer_trade_model").modal();
});

$(".email_wholesaler_trade_details").click(function(e) {
    var id_lead = $(this).data("id_lead");
    var id_tradein = $(this).data("id_tradein");
    let email_template_id = $(this).data("email_template_id");
    // console.log(id_lead);

    $("#id_leads").val(id_lead);
    var name = $("#client_details_form").find("#name").val();
    var email = $("#client_details_form").find("#email").val();
    $("#email_wholesaler_trade_form").find("#label_name").html(name);
    $("#email_wholesaler_trade_form").find("#label_email").html(email);

    $("#email_wholesaler_trade_model").find("#id_tradein").val(id_tradein);
    $("#email_wholesaler_trade_model").find("#email_template_id").val(email_template_id);
    $("#email_wholesaler_trade_model").find("#id_lead").val(id_lead);

    load_wholesaler_selector_parameters("email_wholesaler_trade_model", id_lead, "quote_request");

    $("#email_wholesaler_trade_model").modal();
});


$(".send_tender_confirmation_button").click(function(e) {
    //alert();
    var id_lead = $(this).data("id_lead");
    var id_quote_request = $(this).data("id_quote_request");

    var data = {
        id_lead: id_lead,
        id_quote_request: id_quote_request
    };				
    //console.log(data);return false;
    $.ajax({
        type: "POST",
        url: "<?php echo site_url("fapplication/send_tender_confirmation_email"); ?>" + "/" + id_lead + "/" +  id_quote_request,
        data: data,
        cache: false,
        success: function(response){
            //console.log(response);
            var res = response.trim();
            if (res === "success"){
                swal("SUCCESS", "", "success");
            }else{
                swal("ERROR", "An error occurred! Please try again", "error");
            }
        }
    });				
    e.preventDefault();
});

$(".resend_quote_request_button").click(function(e) {
    //alert('111');return false;
    var id_lead = $(this).data("id_lead");
    var id_quote_request = $(this).data("id_quote_request");
    let email_template_id = $(this).data("email_template_id");
    var container = "invited_dealers_modal";
    var data = {
        id_lead: id_lead,
        id_quote_request: id_quote_request,
        container:container
    };
    
    //alert(id_lead);
	$("#id_leads").val(id_lead);
	var name = $("#client_details_form").find("#name").val();
	var email = $("#client_details_form").find("#email").val();
	$("#invited_dealers_form").find("#label_name").html(name);
	$("#invited_dealers_form").find("#label_email").html(email);
    
	$.ajax({
        type: "POST",
        url: "<?php echo site_url("fapplication/get_invited_dealers"); ?>",
        data: data,
        cache: false,
        //dataType: "json",
        success: function(response){
            //console.log(response);return false;
            //$("#"+container).find("#make_ds").val(response.make);
            //$("#"+container).find("#state_ds").val(response.state);
            //load_suggested_dealers(container);        
            $("#"+container).find("#suggested_dealers").html("");
            $("#"+container).find("#suggested_dealers").append(response);
        }
    });

	$("#invited_dealers_modal").find("#id_quote_request").val(id_quote_request);
	$("#invited_dealers_modal").find("#id_lead").val(id_lead);
	$("#invited_dealers_modal").find("#email_template_id").val(email_template_id);
	
	$("#invited_dealers_modal").modal();
    e.preventDefault();
    
});

$('.resend_vehicle_confirm_button').click(function(e) {
	
	var email_template_id = $(this).data("email_template_id");
    var fq_acct_id = $("#fapplication_id").val();
    let this_modal = $("#send_email_template_model");
    let id_lead = $(this).data("id_lead");
    let id_quote_request = $(this).data("id_quote_request");
	
	var data = {
        id: email_template_id,
        fq_acct_id: fq_acct_id,
        id_lead: id_lead,
        id_quote_request: id_quote_request
    };
    $.ajax({
        type: "POST",
        url: "<?php echo site_url("fapplication/get_system_email_template/start_tender_modal"); ?>",
        data: data,
        cache: false,
        dataType: 'json',
        success: function(data){
            CKEDITOR.instances.send_email_template_content.setData(data.content); 
            this_modal.find("#send_mail_template_subject").val(data.subject);
            this_modal.find("#id_quote_request").val(id_quote_request);
            this_modal.find("#id_lead").val(id_lead);
            $(this_modal).modal({
                backdrop: 'static',
                keyboard: false
            });
        }
    });
	
});


function load_invited_dealer (container, id_lead, type)
{
    
}

$(".remind_dealers_button").click(function(e) {

    var id_lead = $(this).data("id_lead");
    var id_quote_request = $(this).data("id_quote_request");
    //alert(id_quote_request);
    var data = {
        id_lead: id_lead,
        id_quote_request: id_quote_request
    };				

    $.ajax({
        type: "POST",
        url: "<?php echo site_url("lead/remind_dealers_new"); ?>",
        data: data,
        cache: false,
        success: function(response){
            //console.log(response);
            var res = response.trim();
            if (res === "success")
            {
                swal("SUCCESS", "", "success");
            }						
            else
            {
                swal("ERROR", "An error occurred! Please try again", "error");
            }
        }
    });				
    e.preventDefault();
});	

$(".email_invite_modal_button").click(function(e) {
	var name = $("#name").val();
	var email = $("#email").val();
	$("#email_invite_form").find("#label_name").html(name);
	$("#email_invite_form").find("#label_email").html(email);			
	//console.log($(this).data); 
	var id_lead = $(this).data("id_lead");
	var id_quote_request = $(this).data("id_quote_request");

	$(email_invite_modal).find("#id_lead").val(id_lead);
	$("#email_invite_modal").find("#id_quote_request").val(id_quote_request);
	$("#email_invite_modal").modal();
});	

$("#email_invite_form").submit(function(e) { // Reload //
    $.ajax({
        type: "POST",
        url: "<?php echo site_url("fapplication/send_email_invite"); ?>",
        data: $("#email_invite_form").serialize(),
        cache: false,
        success: function(response) {
            //console.log(response);
            var res = response.trim();
            if (res === "success") {
                $("#email_invite_modal").modal("hide");

                swal("SUCCESS", "", "success");
                location.reload(true);
            } else {
                swal("ERROR", "An error occurred! Please try again", "error");
            }
        }
    });
    e.preventDefault();
});	

$(".quote_modal_button").click(function(e){
	//alert('');
	var name = $("#name").val();
	//alert(name);
	var email = $("#email").val();
	//var name = $("#client_details_form").find("#name").val();
	//var name = $("#client_details_form").find("#name").val();
	var email = $("#client_details_form").find("#email").val();
	//console.log($(this).data());
	var id_lead = $(this).data("id_lead");

	var id_quote_request = $(this).data("id_quote_request");
	var id_quote = $(this).data("id_quote");
	var demo = $(this).data("demo");

	var process = $(this).data("process");

	if (name == "" || name == 0 || typeof(name) == 'undefined')	{
		$("#add_quote_form").find("#label_name").html("Quote Form");
		$("#add_quote_form").find("#label_email").html(demo+" Vehicle");
		$("#add_quote_form").find("#quote_form_demo_container").prop("hidden", true);
	} else {
		$("#add_quote_form").find("#label_name").html(name);
		$("#add_quote_form").find("#label_email").html(email);				
	}

	if (process == "" || process == 0 || typeof(process) == 'undefined' || process == 'undefined') {
		if (id_quote == "" || id_quote == 0 || typeof(id_quote) == 'undefined') {	
			var process = "insert";
		} else {
			var process = "update";
		}					
	} else {
		var process = "view";
        
    }
    
	var data = {
		id_lead: id_lead,
		id_quote_request: id_quote_request,
		id_quote: id_quote
	};

	$.ajax({
		type: "POST",
		url: "<?php echo site_url('user/generate_tender_details_json'); ?>",
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

        if (response.registration_type=="TPI/Gold Card" || response.registration_type=="Exempt") {
            $("#add_quote_form").find("#stamp_duty").val("0.00");
            $("#add_quote_form").find("#stamp_duty").prop("readonly", true);
        } else {
		   $("#add_quote_form").find("#stamp_duty").prop("readonly", false);
        }
                               
        if (process == "view") {
            populate_quote_form(id_quote, "#add_quote_form");

            $("#add_quote_form").find("input,textarea,select").prop("disabled", true);
            $("#add_quote_form").find("#add_quote_submit_button").hide();
        } else if (process == "update") {
            populate_quote_form(id_quote, "#add_quote_form");
        } else if (process == "insert")	{
            <?php if ($login_type == "Admin") { ?>					
                clear_quote_form(demo, "#add_quote_form");
            <?php } else if ($login_type == 1) { ?>							
                clear_quote_form(demo, "#add_quote_form");								
            <?php } ?>
            }
        }
    });

    if (process == "update") {
        $("#add_quote_modal").find("#quote_form_dealer_selector_container").prop("hidden", true);
        $("#add_quote_modal").find("#quote_form_warning_container").prop("hidden", true);
        $("#add_quote_modal").find("#quote_form_container").prop("hidden", false);
        $("#add_quote_modal").find("#add_quote_submit_button").prop("disabled", false);
    } else if (process == "insert") {
        $("#add_quote_modal").find("#quote_form_dealer_selector_container").prop("hidden", false);
        $("#add_quote_modal").find("#quote_form_warning_container").prop("hidden", true);
        $("#add_quote_modal").find("#quote_form_container").prop("hidden", true);				
        $("#add_quote_modal").find("#add_quote_submit_button").prop("disabled", true);							
    } else if (process == "update") {

    }

    <?php if ($login_type == "Admin") { ?>
        if (process == "insert") {	
            $("#add_quote_modal").find("#quote_form_dealer_selector_container").prop("hidden", false);
            $("#add_quote_modal").find("#quote_form_warning_container").prop("hidden", true);
            $("#add_quote_modal").find("#quote_form_container").prop("hidden", true);				
            $("#add_quote_modal").find("#add_quote_submit_button").prop("disabled", true);											

            load_dealer_selector_parameters("add_quote_modal", id_lead, "quote_request");
        } else {
            $("#add_quote_modal").find("#quote_form_dealer_selector_container").prop("hidden", true);
            $("#add_quote_modal").find("#quote_form_warning_container").prop("hidden", true);
            $("#add_quote_modal").find("#quote_form_container").prop("hidden", false);
            $("#add_quote_modal").find("#add_quote_submit_button").prop("disabled", false);						
        }
	<?php } else if ($login_type == 1) { ?>
		$("#add_quote_modal").find("#quote_form_dealer_selector_container").prop("hidden", true);
        $("#add_quote_modal").find("#quote_form_warning_container").prop("hidden", true);
        $("#add_quote_modal").find("#quote_form_container").prop("hidden", false);
        $("#add_quote_modal").find("#add_quote_submit_button").prop("disabled", false);					
	<?php } ?>				

	$("#add_quote_modal").find("#process").val(process);
    $("#add_quote_modal").find("#id_lead").val(id_lead);
    $("#add_quote_modal").find("#id_quote_request").val(id_quote_request);

    if (process == "update") {	
        $("#add_quote_modal").find("#id_quote").val(id_quote);
    }

    $("#add_quote_modal").find("#add_quote_submit_button").prop("disabled", false);
    $("#add_quote_modal").modal();
});	

/*$(document).on('submit', '#add_quote_form', function (e) {
    e.preventDefault();
    $("#add_quote_modal").find("#add_quote_submit_button").prop("disabled", true);
    
    $(this).find(':submit').attr( 'disabled','disabled' );
    
    var postData = new FormData(this);
    $("#add_quote_form").find("#demo").prop("disabled", false);

    $.ajax({
        type: "POST",
        url: "<?php echo site_url('user/send_quote'); ?>",
        data: postData,
        fileElementId	:'quote_file',
        processData: false,
        contentType: false,
        cache: false,
        success: function(response){
            //console.log(response);
            var res = response.trim();
            if (res === "success") {
                $("#add_quote_modal").find("input,textarea,select").val("");
                $("#add_quote_modal").modal("hide");
                swal("SUCCESS", "", "success");
                setTimeout(function(){
                window.location.reload();								 
                }, 1000);
            } else {
                swal("ERROR", "An error occurred! Please try again", "error");
            }
        }
    });

});*/

$(".add-more").click(function(){ 
    var html = $(".copy-fields").html();
    // $(".after-add-more").parent().append(html);
    // $(html).insertAfter('.after-add-more');
    $('#accessory_container').append(html);
});
$(".add-more1").click(function(){ 
    var html = $(".copy-fields").html();
    // $(".after-add-more").parent().append(html);
    // $(html).insertAfter('.after-add-more');
    $('#accessory_container1').append(html);
});

$("body").on("click",".removeAs",function(){
	$(this).parents(".control-group").remove();
});

$('#start_valuation_form input').on('keyup',function() {
    let val = $(this).val();
    if(val != '') {
        $(this).addClass('black_border');
    }
    else {
        $(this).removeClass('black_border');
    }
});

$('#start_valuation_form select').on('change',function() {
    let val = $(this).val();
    if(val != '') {
        $(this).addClass('black_border');
    }
    else {
        $(this).removeClass('black_border');
    }
});

var formAlreadySubmitted = false;

/*$("#add_quote_form").submit(function(e) {
    e.preventDefault();
});*/

$(".trade_valuation_modal_button").click(function(e){
    //alert('');
    var name = $("#name").val();
    var email = $("#email").val();
    var email = $("#client_details_form").find("#email").val();
    //console.log($(this).data());
    var id_lead = $(this).data("id_lead");
    var id_tradein = $(this).data("id_tradein");
    $("#add_trade_valuation_modal").find("#id_lead").val(id_lead);
    $("#add_trade_valuation_modal").find("#id_tradeIn").val(id_tradein);
    //alert(id_lead);
    load_dealer_selector_parameters("add_trade_valuation_modal", id_lead, "trade_valuation_request");
    //var id_tradeIn = $(this).data("id_trade_valuation");

    $("#add_trade_valuation_modal").find("#add_trade_valuation_submit_button").prop("disabled", false);
    $("#add_trade_valuation_modal").modal();
});

$(".email_client_trade_details").click(function(e) {

    let btn = $(this);
    btn.prop("disabled", true);
    
    var id_lead = $(this).data("id_lead");
    var id_tradein = $(this).data("id_tradein");
    var id_quote_request = $(this).data("id_quote_request");

    var email_template_id = $(this).data("email_template_id");
    
 	$("#email_client_trade_model").find("#id_tradein").val(id_tradein);
    $("#email_client_trade_model").find("#id_lead").val(id_lead);
    $("#email_client_trade_model").find("#id_quote_request").val(id_quote_request);
    
    load_email_template_client(email_template_id);

    $("#email_client_trade_model").modal();
});

$('#email_client_trade_model').on('hidden.bs.modal', function() {
	let btn = $('.email_client_trade_details');
	btn.prop("disabled", false);
});

$('#edit_tender_modal').on('.hidden.bs.modal', function() {
	$('#accessory_container1').html('');
});

function load_email_template_client(email_template_id)
{
	var fq_acct_id = $("#fapplication_id").val();
    let lead_id = $("#email_client_trade_form").find("#id_lead").val();
    let id_tradein = $("#email_client_trade_form").find("#id_tradein").val();
    let id_quote_request = $("#email_client_trade_form").find("#id_quote_request").val();
    
    var data = {
        id: email_template_id,
        fq_acct_id: fq_acct_id,
        id_lead: lead_id,
        id_tradein: id_tradein,
        id_quote_request: id_quote_request
    };

    $.ajax({
        type: "POST",
        url: "<?php echo site_url("fapplication/get_system_email_template/client_modal"); ?>",
        data: data,
        cache: false,
        dataType: 'json',
        success: function(data){
        	// $('#email_client_template').val(data.content);
            CKEDITOR.instances.email_client_template.setData(data.content); 
            // this_modal.find("#send_mail_template_subject").val(data.subject);
        }
    });
}

$(document).on('click','.edit_client_template', function() {
	$("#email_client_trade_model").modal("hide");
});
$(document).on('click','.edit_dealer_template', function() {
	$("#email_dealer_trade_model").modal("hide");
});
$(document).on('click','.edit_wholesaler_template', function() {
	$("#email_wholesaler_trade_model").modal("hide");
});
$(document).on('click','.edit_client_template_resend_vehicle', function() {
	$("#send_email_template_model").modal("hide");
});
$(document).on('click','.edit_client_template_resend_quote', function() {
	$("#invited_dealers_modal").modal("hide");
});
$(document).on('click','.edit_add_dealer_template', function() {
	$("#add_dealers_modal").modal("hide");
});


$(document).on('submit', '#add_trade_valuation_form', function (e) {
    e.preventDefault();
    let rowCount = $(this).find('#selected_dealers tr td').length;
    //console.log(rowFind);
    if(rowCount <= 1){
        swal("ERROR", "Please Select Dealer !", "error");
        return false;
    }
    var postData = new FormData(this);
    $.ajax({
        type: "POST",
        url: "<?=site_url('tradein/add_trade_valuation');?>",
        data: postData,
        processData: false,
        contentType: false,
        cache: false,
        success: function(response) {
            //console.log(response);
            var res = response.trim();
            if (res === "success") {
                $("#add_trade_valuation_modal").modal("hide");
                $("#add_trade_valuation_modal").find("#selected_dealers").html("");
                $("#add_trade_valuation_modal").find(".norecord").prop("hidden", false);
                
                $(this).find("input[type=text],input[type=hidden]").val("");

                swal("SUCCESS", "", "success");
                //location.reload(true);
            } else {
                swal("ERROR", "An error occurred! Please try again", "error");
            }
        }
    });
    return false;
});


$("#delivery_submit").click(function() {
	$.ajax({
		type: "POST",
		url: "<?php echo site_url('lead/update_record'); ?>",
		data: $("#delivery_details_form").serialize(),
		success: function(response) {
			//console.log(response);
			var res = response.trim();
            if (save_btn_flag == 0){
                if (res === "success")
                {
                    swal("SUCCESS", "", "success");
                    //location.reload(true);
                }	
                else if (res === "nochanges")
                {
                    swal("", "No changes were made", "info");
                }								
                else
                {
                    swal("ERROR", "An error occurred! Please try again", "error");
                }
            }
		}
	});
});

$("#computation_form").submit(function(e) {
    $.ajax({
		type: "POST",
		url: "<?php echo site_url('lead/update_record'); ?>",
		data: $("#computation_form").serialize(),
		success: function(response) {
			//console.log(response);
			var res = response.trim();
            if(save_btn_flag == 0){
                if (res === "success")
                {
                    swal("SUCCESS", "", "success");
                    //location.reload(true);
                }	
                else if (res === "nochanges")
                {
                    swal("", "No changes were made", "info");
                }								
                else
                {
                    swal("ERROR", "An error occurred! Please try again", "error");
                }
            } 
			
		}
	});
	e.preventDefault();
});

$(".submit_deal_button").click(function(e) { // Reload //
    //alert();
    var id_lead = $(this).data("id_lead");

    var data = {
        id_lead: id_lead
    };				

    $.ajax({
        type: "POST",
        url: "<?php echo site_url("lead/submit_deal_new"); ?>",
        data: data,
        cache: false,
        success: function(response){
            //console.log(response);
            var res = response.trim();
            if (res === "success") {
                swal("SUCCESS", "", "success");
                //location.reload(true);
            } else {
                swal("ERROR", "An error occurred! Please try again", "error");
            }
        }
    });
    e.preventDefault();
});

$(".approve_deal_button").click(function(e) { // Reload //

    var id_lead = $(this).data("id_lead");

    var data = {
        id_lead: id_lead,
        status: 5
    };				

    $.ajax({
        type: "POST",
        url: "<?php echo site_url("lead/update_status"); ?>",
        data: data,
        cache: false,
        success: function(response){
            var res = response.trim();
            if (res === "success") {
                swal("SUCCESS", "", "success");
                //	location.reload(true);
            } else {
                swal("ERROR", "An error occurred! Please try again", "error");
            }
        }
    });				
    e.preventDefault();
});

$(".deliver_button").click(function(e) { // Reload //

    var id_lead = $(this).data("id_lead");

    var data = {
        id_lead: id_lead,
        status: 6
    };				

    $.ajax({
        type: "POST",
        url: "<?php echo site_url("lead/update_status"); ?>",
        data: data,
        cache: false,
        success: function(response){
            var res = response.trim();
            if (res === "success")
            {
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
});

$(".settle_button").click(function(e) { // Reload //

    var id_lead = $(this).data("id_lead");

    var data = {
        id_lead: id_lead,
        status: 7
    };				

    $.ajax({
        type: "POST",
        url: "<?php echo site_url("lead/update_status"); ?>",
        data: data,
        cache: false,
        success: function(response){
            var res = response.trim();
            if (res === "success") {
                swal("SUCCESS", "", "success");
                location.reload(true);
            } else{
                swal("ERROR", "An error occurred! Please try again", "error");
            }
        }
    });				
    e.preventDefault();
});

$("#details_form").submit(function(e) {
	$.ajax({
		type: "POST",
		url: "<?php echo site_url('tradein/update_record_new'); ?>",
		data: $("#details_form").serialize(),
		success: function(response) {
			//console.log(response);
			var res = response.trim();
			if (save_btn_flag == 0){
                if (res === "success")
                {
                    swal("SUCCESS", "", "success");
                }	
                else if (res === "nochanges")
                {
                    swal("", "No changes were made", "info");
                }								
                else
                {
                    swal("ERROR", "An error occurred! Please try again", "error");
                }
            }
		}
	});
	e.preventDefault();
});

$(".add_trade_valuation_modal_button").click(function(e) {
	var make = $("#details_form").find("#tradein_make").val();
	var model = $("#details_form").find("#tradein_model").val();
	var variant = $("#details_form").find("#tradein_variant").val();
	$("#add_trade_valuation_form").find("#label_1").html(make+" "+model);
	$("#add_trade_valuation_form").find("#label_2").html(variant);

	var id_tradein = $(this).data("id_tradein");

	$("#add_trade_valuation_form").find("#id_tradein").val(id_tradein);
	$("#add_trade_valuation_modal").modal();
});

$(".forward_pdf_modal_button").click(function(e) {

	var id_trade = $("#details_form").find("#trade").val();
	var make = $("#details_form").find("#tradein_make").val();
	var model = $("#details_form").find("#tradein_model").val();
	var variant = $("#details_form").find("#tradein_variant").val();
	$("#forward_pdf_form").find("#label_1").html(make+" "+model);
	$("#forward_pdf_form").find("#label_2").html(variant);
	//alert(id_trade);
	$("#forward_pdf_form").find("#id_tradei").html(id_trade);
	$("#forward_pdf_modal").modal();

});	

// DROPZONE UPLOADERS (Start) //
$("#forward_pdf_form").find(".email_attachments").dropzone({
	url: '<?php echo site_url('tradein/upload_email_attachments/'); ?>',
	init: function() {
	this.on("sending", function(file, xhr, formData){}),
	this.on("success", function(file, response){
	$("#forward_pdf_form").find("#hidden_images").append('<input class="hidden_image" type="hidden" name="email_file[]" value="'+response+'">');
}),
	this.on("queuecomplete", function(){});
},
});
// DROPZONE UPLOADERS (End) //	

$("#forward_pdf_form").submit(function(e) {

	var id_tradein = $("#forward_pdf_form").find("#id_tradein").val();
	var recipient = $("#forward_pdf_form").find("#recipient_email").val();
	var subject = $("#forward_pdf_form").find("#subject").val();
	var message = $("#forward_pdf_form").find("#message").val();

	var attachment_array = [];



	$("#forward_pdf_form").find("#hidden_images").find(".hidden_image").each(function(){
		var image = $(this).val();
		attachment_array.push(image);
	});

	var data = {
		id_tradein: id_tradein,
		recipient: recipient,
		subject: subject,
		message: message,
		attachment_array: attachment_array
	};			

	$.ajax({
		type: "POST",
		url: "<?php echo site_url('tradein/forward_pdf'); ?>",
		data: data,
		cache: false,
		success: function(response) {
			var res = response.trim();
			if (res === "success")
			{
				$("#forward_pdf_modal").find("input,textarea,select").val("");
				$("#forward_pdf_modal").find(".email_attachments").html("");
				$("#forward_pdf_modal").modal("hide");

				swal("SUCCESS", "", "success");
			}				
			else
			{
				swal("ERROR", "An error occurred! Please try again", "error");
			}
		}
	});
	e.preventDefault();
});


$(".assign_cqo").click(function() { // Reload //


	$.ajax({
		type: "GET",
		url: "<?php echo site_url("account/dealersfloat"); ?>",
		cache: false,
		success: function(response){
		//console.log(response);
		$('#assign').html(response);

	}
		   });				

});

$(".open_lead_assign").click(function() {

	$.ajax({
		type: "GET",
		url: "<?php echo site_url("quote/search"); ?>",
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
});

$(".submit_deal_button").click(function(e) { // Reload //

	var id_lead = $(this).data("id_lead");

	var data = {
		id_lead: id_lead
	};				

	$.ajax({
		type: "POST",
		url: "<?php echo site_url("lead/submit_deal_new"); ?>",
		data: data,
		cache: false,
		success: function(response){
		var res = response.trim();
		if (res === "success")
		{
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
});

$(".select_winning_quote_button").click(function(e) { // Reload //
	var id_lead = $(this).data("id_lead");
    var id_quote_request = $(this).data("id_quote_request");
    var id_quote = $(this).data("id_quote");
    var data = {
        id_lead: id_lead,
        id_quote_request: id_quote_request,
        id_quote: id_quote
    };
    $.ajax({
        type: "POST",
        url: "<?php echo site_url("lead/select_winning_quote_new"); ?>",
        data: data,
        cache: false,
        success: function(response){
            //console.log(response);
            var res = response.trim();
            if (res === "success") {
                //swal("SUCCESS", "", "success");
                //location.reload(true);
				//save_fapplication_info_2(22);
				reopen_lead(id_lead);
			
						
            } else {
                swal("ERROR", "An error occurred! Please try again", "error");
            }
        }
    });				
    e.preventDefault();
});

$(".remove_winning_quote_button").click(function(e) { // Reload //
    var id_lead = $(this).data("id_lead");
    var id_quote_request = $(this).data("id_quote_request");
    
    var data = {
        id_lead: id_lead,
        id_quote_request: id_quote_request
    };
    $.ajax({
        type: "POST",
        url: "<?php echo site_url("lead/remove_winning_quote_new"); ?>",
        data: data,
        cache: false,
        success: function(response){
            //console.log(response);
            var res = response.trim();
            if (res === "success") {
                swal("SUCCESS", "", "success");
                location.reload(true);
            } else {
                swal("ERROR", "An error occurred! Please try again", "error");
            }
        }
    });				
    e.preventDefault();
});

$(document).on("click",".delate_quote_button",function(){
    //alert('111');return false;
	let value = confirm('Are you sure delete this Quote ?');
	let tr = $(this).closest("tr");				
	let id_quote = $(this).data("id_quote");				
	let data = {
		id_quote: id_quote
	};
	if(value){
		$.ajax({
			url: "<?php echo site_url("lead/delete_quote"); ?>",
			type: "POST",
			data: data,
			success: function(response){
            console.log(response);
				var res = response.trim();
				if (res === "success") {
					swal("SUCCESS", "", "success");
					tr.remove();
				} else {
					swal("ERROR", "An error occurred! Please try again", "error");
				}
			}
		});
	}
});

$(document).on("change","input[type=radio][class=car_onroad]",function(){
		let car_onroad = this.value;
		let id_quote = $(this).data("id_quote");
		var data = {
			id_quote: id_quote,
			car_onroad: car_onroad
		};
		//alert(id_quote);return false;
		$.ajax({
			url: "<?php echo site_url("lead/car_OnRoad_update"); ?>",
			type: "POST",
			data: data,
			success: function(response){
				var res = response.trim();
				if (res === "success") {
					swal("SUCCESS", "", "success");
				} else {
					swal("ERROR", "An error occurred! Please try again", "error");
				}
			}
		});
	});

$(document).on("click",".off_road",function(){
	let tr = $(this).closest("tr");
	let id_quote = tr.data("id_quote");
	let off_road = $("#off_road_"+id_quote).val();    
	var data = {
			id_quote: id_quote,
			off_road: off_road
		};
	
	$.ajax({
		url: "<?php echo site_url("lead/car_OffRoad_update"); ?>",
		type: "POST",
		data: data,
		success: function(response){
			var res = response.trim();
			if (res === "success") {
				swal("SUCCESS", "", "success");
			} else {
				swal("ERROR", "An error occurred! Please try again", "error");
			}
		}
	});
});

$(document).on("click",".dealer_notes",function(){
	let tr = $(this).closest("tr");
	let id_quote = tr.data("id_quote");
	let dealer_notes = $("#notes_"+id_quote).val();
	var data = {
			id_quote: id_quote,
			dealer_notes: dealer_notes
		};
	$.ajax({
		url: "<?php echo site_url("lead/dealer_notes_update"); ?>",
		type: "POST",
		data: data,
		success: function(response){
			var res = response.trim();
			if (res === "success") {
				swal("SUCCESS", "", "success");
			} else {
				swal("ERROR", "An error occurred! Please try again", "error");
			}
		}
	});
});

$(document).on("click",".e_d_date",function(){
	let tr = $(this).closest("tr");
	let id_quote = tr.data("id_quote");
	let d_date = $("#e_d_date_"+id_quote).val();    
	var data = {
			id_quote: id_quote,
			d_date: d_date
		};
	
	$.ajax({
		url: "<?php echo site_url("lead/delivery_date_update"); ?>",
		type: "POST",
		data: data,
		success: function(response){
			var res = response.trim();
			if (res === "success") {
				swal("SUCCESS", "", "success");
			} else {
				swal("ERROR", "An error occurred! Please try again", "error");
			}
		}
	});
});

$(document).on("change","input[type=radio][class=hq_car_onroad]",function(){
        $(this).closest('td').find(':radio').not(this).prop('checked', false)
    
		let car_onroad = this.value;
		let id_quote = $(this).data("id_quote");
		var data = {
			id_quote: id_quote,
			car_onroad: car_onroad
		};
		//alert(id_quote);return false;
		$.ajax({
			url: "<?php echo site_url("lead/car_OnRoad_update"); ?>",
			type: "POST",
			data: data,
			success: function(response){
				var res = response.trim();
				if (res === "success") {
					swal("SUCCESS", "", "success");
				} else {
					swal("ERROR", "An error occurred! Please try again", "error");
				}
			}
		});
	});

$(document).on("click",".hq_off_road",function(){
	let tr = $(this).closest("td").find('input');
	let id_quote = tr.attr('id').replace ( /[^\d.]/g, '' );
	let off_road = $("#hq_off_road_"+id_quote).val();
    var data = {
			id_quote: id_quote,
			off_road: off_road
		};    
	
	$.ajax({
		url: "<?php echo site_url("lead/car_OffRoad_update"); ?>",
		type: "POST",
		data: data,
		success: function(response){
			var res = response.trim();
			if (res === "success") {
				swal("SUCCESS", "", "success");
			} else {
				swal("ERROR", "An error occurred! Please try again", "error");
			}
		}
	});
});

$(document).on("click",".hq_dealer_notes",function(){
    let tr = $(this).closest("td").find('input');
	let id_quote = tr.attr('id').replace ( /[^\d.]/g, '' );
	let dealer_notes = $("#hq_notes_"+id_quote).val();
    
	var data = {
			id_quote: id_quote,
			dealer_notes: dealer_notes
		};
	$.ajax({
		url: "<?php echo site_url("lead/dealer_notes_update"); ?>",
		type: "POST",
		data: data,
		success: function(response){
			var res = response.trim();
			if (res === "success") {
				swal("SUCCESS", "", "success");
			} else {
				swal("ERROR", "An error occurred! Please try again", "error");
			}
		}
	});
});

$('[data-toggle="tooltip"]').tooltip();

$("#delivery_address_map").change(function(e) {
	var container = $(this).data("container");

	//alert ($("#"+container).find("#delivery_address_map").val());

	if ($("#"+container).find("#delivery_address_map").val() == 1)
	{
		$("#"+container).find("#delivery_address").hide();
	}
	else
	{
		$("#"+container).find("#delivery_address").show();
	}
});

$(".send_email_modal_button").click(function(e) {
	//alert();
	var email = $("#email").val();
	var id_lead = $("#id_lead").val();
	// var name = $("#client_details_form").find("#name").val();
	// var email = $("#client_details_form").find("#email").val();	
	$("#send_email_form").find("#label_name").html(name);
	$("#send_email_form").find("#label_email").html(email);
	$("#send_email_form").find("#id_leads").val(id_lead);

	$("#send_email_modal").modal();
});		

$(".sms_modal_button").click(function(e) {

	swal("UNDER CONSTRUCTION", "This feature is under construction!", "info");

	/*
				var name = $("#client_details_form").find("#name").val();
				var email = $("#client_details_form").find("#email").val();	
				$("#sms_form").find("#label_name").html(name);
				$("#sms_form").find("#label_email").html(email);				

				var mobile = $("#client_details_form").find("#mobile").val();

				$("#sms_form").find("#mobile").html(mobile);

				$("#sms_modal").modal();
				*/
});

$(".call_modal_button").click(function(e) {
	var name = $("#client_details_form").find("#name").val();
	var email = $("#client_details_form").find("#email").val();
	$("#call_form").find("#label_name").html(name);
	$("#call_form").find("#label_email").html(email);

	var phone = $("#client_details_form").find("#phone").val();
	var mobile = $("#client_details_form").find("#mobile").val();

	$("#call_form").find("#phone_text").html(phone);
	$("#call_form").find("#mobile_text").html(mobile);
	$("#call_form").find("#phone_button").attr("href", "tel:" + phone);
	$("#call_form").find("#mobile_button").attr("href", "tel:" + mobile);				

	$("#call_modal").modal();
});

$("#send_email_form").find(".email_attachments").dropzone({
	url: '<?php echo site_url('lead/upload_email_attachments/'); ?>',
	init: function() {
	this.on("sending", function(file, xhr, formData){}),
	this.on("success", function(file, response){
	$("#send_email_form").find("#hidden_images").append('<input class="hidden_image" type="hidden" name="email_file[]" value="'+response+'">');
}),
	this.on("queuecomplete", function(){});
},
});

$("#send_email_form").submit(function(e) { // Reload //

	var id_lead = $("#send_email_form").find("#id_leads").val();
	alert(id_lead);
	var recipient = $("#send_email_form").find("#recipient_email").val();
	var subject = $("#send_email_form").find("#subject").val();
	var message = $("#send_email_form").find("#message").val();

	var purchase_order_attachment_flag = 0;
	var order_package_attachment_flag = 0;
	var dealer_invoice_attachment_flag = 0;
	var admin_fee_invoice_attachment_flag = 0;	

	var attachment_array = [];				

	if ($("#send_email_form").find("#purchase_order_attachment_flag").prop("checked") == true)
	{
		purchase_order_attachment_flag = 1;
	}

	if ($("#send_email_form").find("#order_package_attachment_flag").prop("checked") == true)
	{
		order_package_attachment_flag = 1;
	}

	if ($("#send_email_form").find("#dealer_invoice_attachment_flag").prop("checked") == true)
	{
		dealer_invoice_attachment_flag = 1;
	}

	if ($("#send_email_form").find("#admin_fee_invoice_attachment_flag").prop("checked") == true)
	{
		admin_fee_invoice_attachment_flag = 1;
	}

	$("#send_email_form").find("#hidden_images").find(".hidden_image").each(function(){
		var image = $(this).val();
		attachment_array.push(image);
	});

	var data = {
		id_lead: id_lead,
		recipient: recipient,
		subject: subject,
		message: message,
		purchase_order_attachment_flag: purchase_order_attachment_flag,
		order_package_attachment_flag: order_package_attachment_flag,
		dealer_invoice_attachment_flag: dealer_invoice_attachment_flag,
		admin_fee_invoice_attachment_flag: admin_fee_invoice_attachment_flag,
		attachment_array: attachment_array
	};			
	//console.log(data);
	$.ajax({
		type: "POST",
		url: "<?php echo site_url('deal/send_email'); ?>",
		data: data,
		cache: false,
		success: function(response) {
			//console.log(response);
			var res = response.trim();
			if (res === "success")
			{
				$("#send_email_modal").find("input,textarea,select").val("");
				$("#send_email_modal").modal("hide");

				swal("SUCCESS", "", "success");
				//location.reload(true);
			}				
			else
			{
				swal("ERROR", "An error occurred! Please try again", "error");
			}
		}
	});
	e.preventDefault();
});

$(".approve_deal_button").click(function(e) { // Reload //

	var id_lead = $(this).data("id_lead");

	var data = {
		id_lead: id_lead,
		status: 5
	};				

	$.ajax({
		type: "POST",
		url: "<?php echo site_url("lead/update_status"); ?>",
		data: data,
		cache: false,
		success: function(response){
		var res = response.trim();
		if (res === "success")
		{
		swal("SUCCESS", "", "success");
		//location.reload(true);
	}						
		   else
		   {
		   swal("ERROR", "An error occurred! Please try again", "error");
}
								}
								});				
e.preventDefault();
});

$(".cancel_deal_modal_button").click(function(e) {
	var name = $("#client_details_form").find("#name").val();
	var email = $("#client_details_form").find("#email").val();
	$("#cancel_deal_form").find("#label_name").html(name);
	$("#cancel_deal_form").find("#label_email").html(email);

	$("#cancel_deal_modal").modal();
});	

$(".delete_quote_button").click(function(e) { // Reload //
	//alert();
	var id_lead = $(this).data("id_lead");
	var id_quote_request = $(this).data("id_quote_request");
	var id_quote = $(this).data("id_quote");

	var data = {
		id_lead: id_lead,
		id_quote_request: id_quote_request,
		id_quote: id_quote
	};				

	$.ajax({
		type: "POST",
		url: "<?php echo site_url("lead/delete_quote"); ?>",
		data: data,
		cache: false,
		success: function(response){
		//console.log(response);
		var res = response.trim();
		if (res === "success")
		{
		swal("SUCCESS", "", "success");
		//location.reload(true);
	}						
		   else
		   {
		   swal("ERROR", "An error occurred! Please try again", "error");
}
								}
								});				
e.preventDefault();
});

$(".add_invoice_modal_button").click(function(e) {
	var name = $("#name").val();
	var id_lead = $(this).data("id_lead");
	//alert(id_lead);
	var email = $("#email").val();
	$("#add_invoice_modal").find("#label_name").html(name);
	$("#add_invoice_modal").find("#id_lead").val(id_lead);
	$("#add_invoice_modal").find("#label_email").html(email);	

	$("#add_invoice_modal").modal();
});

$(".add_invoice_item_button").click(function(e) {
	var container = $(this).data("container");
	var item = '\
<div style="padding: 15px; border: 1px solid #ddd; margin-top: 15px;">\
<div class="row">\
<div class="col-md-6">\
<div class="form-group">\
<label class="control-label">Amount:</label>\
<input type="text" class="form-control" name="invoice_item_amount[]" onkeypress="return isNumberKey(event)">\
</div>\
</div>\
</div>\
<div class="row" style="margin-top: 10px;">\
<div class="col-md-12">\
<div class="form-group">\
<label class="control-label">Item Description:</label>\
<textarea type="text" class="form-control" name="invoice_item_description[]"></textarea>\
</div>\
</div>\
</div>\
</div>';
	$("#"+container).find("#invoice_items_container").append(item);
});	

$("#add_invoice_form").submit(function(e) { // Reload //
	$.ajax({
		type: "POST",
		url: "<?php echo site_url('invoice/add_invoice'); ?>",
		data: $("#add_invoice_form").serialize(),
		cache: false,
		success: function(response) {
			//console.log(response);
			var res = response.trim();
			if (res === "success")
			{
				$("#add_invoice_form").find("input,textarea,select").val("");
				$("#add_invoice_modal").modal("hide");

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
});		

$(".add_payment_modal_button").click(function(e) {
	var name = $("#name").val();
	var id_lead = $(this).data("id_lead");
	var email = $("#email").val();
	$("#add_payment_modal").find("#label_name").html(name);
	$("#add_payment_modal").find("#id_lead").val(id_lead);
	$("#add_payment_modal").find("#label_email").html(email);	

	$("#add_payment_modal").modal();
});

$("#add_payment_form").submit(function(e) { // Reload //
	$.ajax({
		type: "POST",
		url: "<?php echo site_url('payment/add_payment'); ?>",
		data: $("#add_payment_form").serialize(),
		cache: false,
		success: function(response) {
			var res = response.trim();
			if (res === "success")
			{
				$("#add_payment_form").find("input,textarea,select").val("");
				$("#add_payment_modal").modal("hide");

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
});

$(".delete_invoice_button").click(function(e) { // Remove record

	var id_lead = $(this).data("id_lead");
	var id_invoice = $(this).data("id_invoice");

	var data = {
		id_lead: id_lead,
		id_invoice: id_invoice
	};
	//console.log(data);
	$.ajax({
		type: "POST",
		url: "<?php echo site_url("invoice/delete_invoice"); ?>",
		data: data,
		cache: false,
		success: function(response){
		var res = response.trim();
		if (response === "success")
		{
		swal("SUCCESS", "", "success");
		$("#invoices_container").find("#lead_invoice_"+id_invoice).remove();
	}						
		   else
		   {
		   swal("ERROR", "An error occurred! Please try again", "error");
}
								  }
								  });				
e.preventDefault();
});	

$(".update_payment_show_status_button").click(function(e) { // Remove record

	var id_lead = $(this).data("id_lead");
	var id_payment = $(this).data("id_payment");
	var show_status = $(this).data("show_status");

	var data = {
		id_lead: id_lead,
		id_payment: id_payment,
		show_status: show_status
	};

	$.ajax({
		type: "POST",
		url: "<?php echo site_url("payment/update_payment_show_status"); ?>",
		data: data,
		cache: false,
		success: function(response){
		var res = response.trim();
		if (res === "success")
		{
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
});	

$(".delete_payment_button").click(function(e) { // Remove record

	var id_lead = $(this).data("id_lead");
	var id_payment = $(this).data("id_payment");

	var data = {
		id_lead: id_lead,
		id_payment: id_payment
	};

	$.ajax({
		type: "POST",
		url: "<?php echo site_url("payment/delete_payment"); ?>",
		data: data,
		cache: false,
		success: function(response){
		var res = response.trim();
		if (res === "success")
		{
		swal("SUCCESS", "", "success");
		$("#payments_container").find("#lead_payment_"+id_payment).remove();
	}						
		   else
		   {
		   swal("ERROR", "An error occurred! Please try again", "error");
}
								  }
								  });				
e.preventDefault();
});

$(".edit_payment_modal_button").click(function(e) {
	//alert();
	var name = $("#name").val();
	var id_lead = $(this).data("id_lead");
	var email = $("#email").val();
	$("#edit_payment_form").find("#label_name").html(name);
	$("#edit_payment_form").find("#label_email").html(email);				
	$("#edit_payment_form").find("#id_lead").val(id_lead);
	var id_lead = $(this).data("id_lead");
	var id_payment = $(this).data("id_payment");

	$("#edit_payment_form").find("#id_payment").val(id_payment);

	var data = {
		id_lead: id_lead,
		id_payment: id_payment
	};

	//console.log(data);
	$.ajax({
		type: "POST",
		url: "<?php echo site_url('payment/get_payment'); ?>",
		data: data,
		dataType: "json",
		cache: false,
		success: function(response){
			//console.log(response);
			$("#edit_payment_modal").find("#fk_payment_type").val(response.fk_payment_type);
			$("#edit_payment_modal").find("#reference_number").val(response.reference_number);
			$("#edit_payment_modal").find("#payment_date").val(response.payment_date);
			$("#edit_payment_modal").find("#amount").val(response.amount);
			$("#edit_payment_modal").find("#admin_fee").val(response.admin_fee);
			$("#edit_payment_modal").find("#merchant_cost").val(response.merchant_cost);
			$("#edit_payment_modal").find("#method").val(response.method);
			$("#edit_payment_modal").find("#credit_card").val(response.credit_card);
			$("#edit_payment_modal").find("#bank_account").val(response.bank_account);
			$("#edit_payment_modal").find("#remarks").val(response.remarks);
			$("#edit_payment_modal").modal();	
		}
	});
});

$("#edit_payment_form").submit(function(e) { // Reload //
	$.ajax({
		type: "POST",
		url: "<?php echo site_url('payment/update_payment'); ?>",
		data: $("#edit_payment_form").serialize(),
		cache: false,
		success: function(response) {
			var res = response.trim();
			if (res === "success")
			{
				$("#edit_payment_form").find("input,textarea,select").val("");
				$("#edit_payment_modal").modal("hide");

				swal("SUCCESS", "", "success");
				// location.reload(true);
			}				
			else
			{
				swal("ERROR", "An error occurred! Please try again", "error");
			}
		}
	});
	e.preventDefault();
});
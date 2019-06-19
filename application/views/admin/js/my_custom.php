$(document).ready(function(){
    /*$(document).on('submit', '#email_client_trade_form', function (e) {
        e.preventDefault();
       
        var postData = new FormData(this);
        
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('tradein/send_mail_client_trade'); ?>",
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
                    //location.reload(true);
                } else {
                    swal("ERROR", "An error occurred! Please try again", "error");
                }
            }
        });
        return false;
    });*/

    /*$(document).on('submit', '#email_dealer_trade_form', function (e) {
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
                //console.log(response);
                var res = response.trim();
                if (res === "success") {
                    $("#email_dealer_trade_model").modal("hide");
                    $("#email_dealer_trade_model").find("#selected_dealers").html("");
                    $("#email_dealer_trade_model").find("textarea").html("");
                    $("#email_dealer_trade_model").find(".norecord").prop("hidden", false);

                    swal("SUCCESS", "", "success");
                    //location.reload(true);
                } else {
                    swal("ERROR", "An error occurred! Please try again", "error");
                }
                $("#email_dealer_trade_model").find("#email_dealer_trade_sub_btn").prop("disabled", false);
            }
        });
        return false;
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
                //console.log(response);
                var res = response.trim();
                if (res === "success") {
                    $("#email_wholesaler_trade_model").modal("hide");
                    $("#email_wholesaler_trade_model").find("#selected_dealers").html("");
                    $("#email_wholesaler_trade_model").find("textarea").html("");
                    $("#email_wholesaler_trade_model").find(".norecord").prop("hidden", false);

                    swal("SUCCESS", "", "success");
                    //location.reload(true);
                } else {
                    swal("ERROR", "An error occurred! Please try again", "error");
                }
                $("#email_wholesaler_trade_model").find("#email_wholesaler_trade_sub_btn").prop("disabled", false);
            }
        });
        return false;
    });*/

});
function load_wholesaler_selector_parameters (container, id_lead, type)
{
    //console.log(container);
    //alert();
    var data = {
        id_lead: id_lead,
        type: type
    };  

    // console.log('Comming soon...');
    $.ajax({
        type: "POST",
        url: "<?php echo site_url("lead/get_wholesaler_selector_parameters"); ?>",
        data: data,
        cache: false,
        dataType: "json",
        success: function(response){
            //console.log(response);
            $("#"+container).find("#make_ds").val(response.make);
            $("#"+container).find("#state_ds").val(response.state);
            load_suggested_wholesalers(container);
        }
    });
}

function load_suggested_wholesalers (container)
{
    // console.log('my');
	var make = $("#"+container).find("#make_ds").val();
    var state = $("#"+container).find("#state_ds").val();
    
    var data = {
        container: container,
        make: make,
        state: state
    };

    $.ajax({
        type: "POST",
        url: "<?php echo site_url("fapplication/get_suggested_wholesalers"); ?>",
        data: data,
        cache: false,
        success: function(response){
            $("#"+container).find("#suggested_wholesalers").html("");
            $("#"+container).find("#suggested_wholesalers").append(response);
        }
    });
}

function load_dealer_selector_parameters (container, id_lead, type)
{
    var data = {
        id_lead: id_lead,
        type: type
    };  

    $.ajax({
        type: "POST",
        url: "<?php echo site_url("lead/get_dealer_selector_parameters"); ?>",
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

function load_suggested_dealers (container)
{
    var make = $("#"+container).find("#make_ds").val();
    var state = $("#"+container).find("#state_ds").val();
    var type = $("#"+container).find("#type_ds").val();
    var quote_request = $("#"+container).find("#id_quote_request").val();
    
    var data = {
        container: container,
        make: make,
        state: state,
        type: type,
        // quote_request_id: quote_request
    };

    if(container == 'add_dealers_modal') {
        data['quote_request_id'] = quote_request;
    }

    $.ajax({
        type: "POST",
        url: "<?php echo site_url("fapplication/get_suggested_dealers"); ?>",
        data: data,
        cache: false,
        success: function(response){
            // console.log(response);
            $("#"+container).find("#suggested_dealers").html("");
            $("#"+container).find("#suggested_dealers").append(response);
        }
    });
}

function get_car_lead(id_lead, fromCheck='')
{
    var data = {
        id_lead: id_lead,
    };

    if(fromCheck != '' && fromCheck == 'start_tender_modal')  {
        data['from'] = 'start_tender_form';
    }

    $.ajax({
        type: "POST",
        url: "<?php echo site_url("lead/get_lead_car_ids"); ?>",
        data: data,
        cache: false,
        dataType: "json",
        success: function(response){
            // console.log(response);
            load_makes("start_tender_modal", response.id_make);
            load_families("start_tender_modal", response.id_make, response.id_family);

            /**/
            $("#start_tender_modal").find("#make").attr('data-old',response.id_make);
            $("#start_tender_modal").find("#family").attr('data-old',response.id_family);
            /**/

            //load_build_dates("start_tender_modal", response.id_family);
            load_registration_colour("start_tender_modal",id_lead);
            $("#postcode_ds2").val($('input[name=new_lead_postcode]').val());
            $("#postcode_ds2").attr('data-old',$('input[name=new_lead_postcode]').val());
            //$("#start_tender_modal #make_ds").val(response.make_name);
            // load_suggested_dealers('start_tender_modal');
            rbgetdata("start_tender_modal",response.id_make,response.id_family, 0);
            display_rbdata("start_tender_modal", id_lead);
        }
    });
}

function get_accessories(lead_id, container='')
{
    if(container == '') {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url("cars/get_accessories"); ?>/"+lead_id,
            cache: false,
            success: function(response){
                // console.log(response);
                $('#accessory_container').html('');
                response = jQuery.parseJSON(response);
                /*=============*/
                $(response).each(function(k,v) {
                    if(k == 0) {
                        $("#start_tender_modal").find('input[name="accessory_name[]"]').val(v);
                    }
                    else {
                        var html = $(".copy-fields1").html();
                        html = html.replace('@@@',v);
                        $('#accessory_container').append(html);
                    }
                });
                /*=============*/
            }
        }); 
    }
    else {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url("cars/get_accessories"); ?>/"+lead_id+'/'+container,
            cache: false,
            success: function(response){
                // console.log(response);
                $('#accessory_container1').html('');
                response = jQuery.parseJSON(response);
                /*=============*/
                $(response).each(function(k,v) {
                    // console.log(v);
                    if(k == 0) {
                        $("#"+container).find('input[name="accessory_name[]"]').val(v);
                    }
                    else {
                        var html = $(".copy-fields1").html();
                        html = html.replace('@@@',v);
                        $('#accessory_container1').append(html);
                    }
                });
                /*=============*/
            }
        });    
    }
}

function get_system_email_template_start_tender()
{
    let email_template_id = $("#start_tender_form").find("#email_template_id").val();
    let id_lead = $("#start_tender_form").find("#id_leads").val();
    let fq_acct_id = $("#fapplication_id").val();
    let this_modal = $("#start_tender_modal");
    
    var data = {
        id: email_template_id,
        id_lead: id_lead,
        fq_acct_id: fq_acct_id
    };

    $('textarea.start_tender_email_template_content').ckeditor({ 
        height: 300,
        allowedContent:true
    });

    $.ajax({
        type: "POST",
        url: "<?php echo site_url("fapplication/get_system_email_template/start_tender_modal"); ?>",
        data: data,
        cache: false,
        dataType: 'json',
        success: function(data){
            setTimeout(function() {
                CKEDITOR.instances.start_tender_email_template_content.setData(data.content); 
            },1500);
        }
    });
}

function load_makes (container, make_id)
{
    if(make_id != "" && make_id != 0)
    {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url("cars/load_makes"); ?>/"+make_id,
            cache: false,
            success: function(response){
                $("#"+container).find("#make").html("<option value='0'></option>");
                $("#"+container).find("#make").append(response);
            }
        });                 
    }
}

function load_registration_colour(container, lead_id)
{
    if(lead_id != "" && lead_id != 0)
    {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url("cars/load_registration_colour"); ?>/"+lead_id,
            cache: false,
            success: function(response){
                response = jQuery.parseJSON(response);
                // console.log(response);
                let reg_type = response.registration_type;
                let colour = response.colour;
                $("#"+container).find("#registration_type").val(reg_type);
                $("#"+container).find("#colour").val(colour);
                /**/
                $("#"+container).find("#registration_type").attr('data-old',reg_type);
                $("#"+container).find("#colour").attr('data-old',colour);
            }
        });
    }
}

function load_families (container, make_id, family_id)
{
    // console.log(make_id+'--'+family_id);
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

function display_rbdata (container,lead_id)
{
    $.ajax({
        type: "POST",
        url: "<?php echo site_url('cars/load_registration_colour'); ?>/"+lead_id,
        cache: false,
        success: function(response){
            response = jQuery.parseJSON(response);
            // console.log(response);
            let rb_data = response.rb_data;
            setTimeout(function() {
                $('#'+container).find('#rb_data').val(rb_data);
                $('#'+container).find('#rb_data').attr('data-old',rb_data);
            },1500);
        }
    });
}
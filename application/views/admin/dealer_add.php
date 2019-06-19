<?php include 'template/head.php'; ?>

<body>
    <section class="body">
        <?php include 'template/header.php'; ?>
        <div class="inner-wrapper">
            <?php include 'template/left_sidebar.php'; ?>
            <section role="main" class="content-body">
                <?php include 'template/header_2.php'; ?>
                <!-- start: page -->
                <div class="panel-body dealer-modal-main">
                    <div class="modal-wrapper">
                        <div class="modal-text">
                            <form id="form_dealer_creation" action="" method="post" accept-charset="utf-8">
                                <div class="dealer-detail-inner-content">
                                    <div class=""> <!-- container -->
                                        <div class="row">
                                            <div class="col-md-12" style="margin-bottom: 13px;">                                
                                                <div class="form-group">
                                                    <div class="dealer-detail-form-group">
                                                        <span>* User Type:</span>
                                                        <select class="form-control input-md" name="user_type" id="user_type" type="text" required>
                                                            <option selected value="1">Dealer</option>
                                                            <option value="3">Wholesaler</option>
                                                            
                                                        </select>
                                                    </div>														
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h5 class="dealer-heading"><span class="user_type_word">Dealership</span> Details</h5>
                                                <div class="form-group">
                                                    <div class="dealer-detail-form-group">
                                                        <span class="require-field"><span class="user_type_word">Dealership</span> Name</span>
                                                        <input type="text" id="dealership_name" name="dealership_name" class="form-control pull-right" value="" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="dealer-detail-form-group" style="position:relative;">
                                                        <span class="require-field">Brands</span>
                                                        <style>
                                                        select#dealership_brand.form-control.select-box.select2-offscreen {
                                                            position: absolute !important;
                                                            left: 60% !important;
                                                            top: 45px !important;
                                                        }
                                                        </style>
                                                        <select class="form-control select-box" id="dealership_brand" name="dealership_brand[]" type="text" multiple="multiple" required>
                                                            <?php foreach ($makes as $make) { ?>
                                                            <option value="<?php echo $make->name; ?>"><?php echo $make->name; ?></option>
                                                            <?php } ?>                                                            
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="dealer-detail-form-group">
                                                        <span>Catered States</span>
                                                        <select class="form-control select-box" id="dealership_states" name="dealership_states[]" type="text" multiple="multiple">
                                                            <?php foreach ($states as $state_key => $state_val) { ?>
                                                            <option value="<?= $state_val ?>"><?= $state_val ?> </option>
                                                            <?php } ?>                                                            
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="dealer-detail-form-group">
                                                        <span>Dealer Licence No</span>
                                                        <input type="text" id="dealer_license" name="dealer_license" class="form-control pull-right" value="">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="dealer-detail-form-group">
                                                        <span>ABN</span>
                                                        <input type="text" id="abn" name="abn" class="form-control pull-right" value="">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="dealer-detail-form-group">
                                                        <span>Address</span>
                                                        <input type="text" id="address" name="address" class="form-control pull-right" value="">
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <div class="dealer-detail-form-group">
                                                        <span>State</span>
                                                        <select class="form-control input-md" name="state" type="text">
                                                            <option value="">-Select State-</option>
                                                            <option value="ACT">ACT - Australian Capital Territory</option>
                                                            <option value="NSW">NSW - New South Wales</option>
                                                            <option value="NT">NT - Northern Territory</option>
                                                            <option value="QLD">QLD - Queensland</option>
                                                            <option value="SA">SA - South Australia</option>
                                                            <option value="TAS">TAS - Tasmania</option>
                                                            <option value="VIC">VIC - Victoria</option>
                                                            <option value="WA">WA - Western Australia</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <div class="dealer-detail-form-group">
                                                        <span>Postcode</span>
                                                        <input type="text" id="postcode" name="postcode" class="form-control pull-right" value="">
                                                    </div>
                                                </div>
                                                <div class="dealer-heading-outer">
                                                    <h5 class="dealer-heading">Bank Details</h5>
                                                </div>
                                                <div class="form-group">
                                                    <div class="dealer-detail-form-group">
                                                        <span>Account Name</span>
                                                        <input type="text" id="bank_acct_name" name="bank_acct_name" class="form-control pull-right" value="">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="dealer-detail-form-group">
                                                        <span>BSB</span>
                                                        <input type="text" id="bank_acct_bsb" name="bank_acct_bsb" class="form-control pull-right" value="">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="dealer-detail-form-group">
                                                        <span>Account No</span>
                                                        <input type="text" id="bank_acct_num" name="bank_acct_num" class="form-control pull-right" value="">
                                                    </div>
                                                </div>
                                                <div class="dealer-heading-outer">
                                                    <h5 class="dealer-heading">Notes :</h5>
                                                </div>
                                                <div class="form-group">
                                                    <div class="dealer-detail-form-group">
                                                        <textarea style="width:100%" name="dealer_note" id="dealer_note" class="form-control "></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class='dealer-input-check'>
                                                    <span class='primary-contact'>Primary Contact</span>
                                                    <input type='checkbox' checked class='check-new-one in-check' id='quote_request_recipient' name='primary_contact[0]' required=''>
                                                    <label for='quote_request_recipient' data-toggle='tooltip' data-placement='top' title='Quote Request Recipient' data-original-title='Quote Request Recipient'>
                                                        <span class='border-span'><i class='fa fa-check' aria-hidden='true'></i></span>
                                                    </label>
                                                    <input type='checkbox' checked class='check-new-one in-check' id='new_vehicle_tax_invoice_request_recipient' name='primary_contact[1]' required=''>
                                                    <label for='new_vehicle_tax_invoice_request_recipient' data-toggle='tooltip' data-placement='top' title='New Vehicle Tax Invoice Request Recipient' data-original-title='New Vehicle Tax Invoice Request Recipient'>
                                                        <span class='border-span'><i class='fa fa-check' aria-hidden='true'></i></span>
                                                    </label><input type='checkbox' checked class='check-new-one in-check' id='recipient_of_settlement_remittance_advice' name='primary_contact[2]' required=''>
                                                    <label for='recipient_of_settlement_remittance_advice' data-toggle='tooltip' data-placement='top' title='Recipient Of Settlement Remittance Advice' data-original-title='Recipient Of Settlement Remittance Advice'>
                                                        <span class='border-span'><i class='fa fa-check' aria-hidden='true'></i></span>
                                                    </label>
                                                    <input type='checkbox' checked class='check-new-one in-check' id='introducer_tax_invoice_recipient' name='primary_contact[3]' required=''>
                                                    <label for='introducer_tax_invoice_recipient' data-toggle='tooltip' data-placement='top' title='Introducer Tax Invoice Recipient' data-original-title='Introducer Tax Invoice Recipient'>
                                                        <span class='border-span'><i class='fa fa-check' aria-hidden='true'></i></span>
                                                    </label>
                                                </div>
                                                
                                                <div class='dealer-input-check'>
                                                    <span class='primary-contact' style="padding-right: 15px;">Is Primary Contact</span>
                                                    <input type='checkbox' checked class='check-new-one in-check is_primary_contact' id='is_primary_contact' value="1" name='is_primary_contact'>
                                                    <label for='is_primary_contact' data-toggle='tooltip' data-placement='top' title='Is Primary Contact' data-original-title='Is Primary Contact'>
                                                        <span class='border-span'><i class='fa fa-check' aria-hidden='true'></i></span>
                                                    </label>                                                    
                                                </div>
                                                
                                                <div id="dealer_contact_form">
                                                    <div class="form-group">
                                                        <div class="dealer-detail-form-group">
                                                            <span>Title</span>
                                                            <input type="text" name="dealership_contact_title" class="form-control pull-right" value="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="dealer-detail-form-group">
                                                            <span class="require-field">Full Name</span>
                                                            <input type="text" name="name" class="form-control pull-right" value="" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="dealer-detail-form-group">
                                                            <span class="require-field">Email = Username</span>
                                                            <input type="email" name="email" class="form-control pull-right" value="" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="dealer-detail-form-group">
                                                            <span>Mobile</span>
                                                            <input type="text" data-rule-number="true" name="mobile" value="" class="form-control pull-right" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="dealer-detail-form-group">
                                                            <span>Landline</span>
                                                            <input type="text" data-rule-number="true" name="phone" value="" class="form-control pull-right">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group text-right">
                                                    <button type="button" name="add_contact" id="add_contact" class="btn btn-default btn-custom" onClick="">Add Contact</button>
                                                </div>
                                                <div id="dealer_contacts"></div>
                                                <div class="form-group text-center dealer-margin-top">
                                                    <a href="<?=site_url('home/agreement');?>" target="_blank" class="agreement-anch">I have read the Accredited Dealer Agreement</a>
                                                    <input type="checkbox" checked class="check-new-one in-check" id="checknew5" name="deal_agreement" required>
                                                    <label for="checknew5">
                                                        <span class="border-span"><i class="fa fa-check" aria-hidden="true"></i></span>
                                                    </label>
                                                </div>
                                                <div class="form-group text-right">
                                                    <button class="btn btn-default btn-save" type="submit">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- end: page -->
                <?php include 'modals/ticket_modals.php'; ?>
            </section>
        </div>
        <?php include 'template/right_sidebar.php'; ?>
    </section>
    <?php include 'template/scripts.php'; ?>
    <script type="text/javascript">        
        $(document).ready(function() {
            addContact();
            /*$("#add_contact").on("click",function(){
                var d = new Date();
                var n = d.getMilliseconds();
                var x = Math.floor((Math.random()*(n/2)) + 1);
                n = "" + n + x;
                var div_id = "data_"+n;
                var contact_data = '';
                var checkbox_input_name = "primary_contact["+n+"]";
                var primary_contact_keys = ["quote_request_recipient","new_vehicle_tax_invoice_request_recipient","recipient_of_settlement_remittance_advice","introducer_tax_invoice_recipient"];
                contact_data += '<input type="hidden" name="contact_id[]" value="'+n+'"><div class="dealer-input-check"><span class="primary-contact">Primary Contact</span>';

                for (i = 0; i < primary_contact_keys.length; i++) {
                    var contact_key = primary_contact_keys[i]+n;
                    var contact_key_name = primary_contact_keys[i].split('_').join(' ');
                    contact_key_name = contact_key_name.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                        return letter.toUpperCase();
                    });
                    contact_data += '<input type="checkbox" class="check-new-one in-check" id="'+contact_key+'" name="'+checkbox_input_name+'['+i+']" required=""><label for="'+contact_key+'" data-toggle="tooltip" data-placement="top" title="" data-original-title="'+contact_key_name+'"><span class="border-span"><i class="fa fa-check" aria-hidden="true"></i></span></label>';
                }
                contact_data += "</div>";
                contact_data += '<div class="form-group"><div class="dealer-detail-form-group"><span>Title</span><input type="text" name="contact_title[]" id="contact_title'+n+'" class="form-control pull-right"></div></div><div class="form-group"><div class="dealer-detail-form-group"><span class="require-field">Full Name</span><input type="text" name="contact_fullname[]" id="contact_fullname'+n+'" class="form-control pull-right"  required=""></div></div><div class="form-group"><div class="dealer-detail-form-group"><span class="require-field">Email = Username</span><input type="email" name="contact_email[]" id="contact_email'+n+'" class="form-control pull-right" required=""></div></div><div class="form-group"><div class="dealer-detail-form-group"><span>Mobile</span><input type="text" data-rule-number="true" name="contact_mobile[]" id="contact_mobile'+n+'" class="form-control pull-right"></div></div><div class="form-group"><div class="dealer-detail-form-group"><span>Landline</span><input type="text" data-rule-number="true" name="contact_landline[]" id="contact_landline'+n+'" class="form-control pull-right"></div></div>';
                var button = '<div class="form-group text-right"><button type="button" name="delete_contact" id="delete_contact" class="btn btn-danger delete_contact" data-id="'+div_id+'" >Delete</button></div> <hr/>';
                var clone_div = "<div id='"+div_id+"'></div>";
                $("#dealer_contacts").append(clone_div);
                $("#"+div_id).append(contact_data);
                $("#"+div_id).append(button);
                $("#dealer_contact_form").trigger("reset");
                $(".delete_contact").on("click",function(){
                    var div_ids = $(this).data("id");
                    $("#"+div_ids).remove();
                });
            });*/
            
            $(document).on('change',"#user_type",function(e){
                e.preventDefault();
                let u_type = $(this).val();

                if(u_type == '1') {
                    $('.user_type_word').html('Dealer');
                    $("#dealership_brand").prop('required',true);
                } else if(u_type == '3') {
                    $('.user_type_word').html('Wholesaler');
                    $("#dealership_brand").prop('required',false);
                }

            });
            
            $("[data-toggle='tooltip']").tooltip();
            $("#dealership_brand").select2();
           

            $("#dealership_states").select2();
            $(document).on('submit', '#form_dealer_creation', function() {
                let user_type = $('#user_type').val();
                
                var postData = new FormData(this);
                $.ajax({
                    url: "<?=site_url('account/create_dealer_profile') ?>",
                    type: "POST",
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: postData,
                    success: function(response) {
                        var json = $.parseJSON(response);
                        if (json['error'] == 'validation_errors') {
                            swal("ERROR", json['validation_msg'], "error");
                        }
                        
                        if (json['success'] == 'Error') {
                            swal("ERROR", "some error occurred during add dealer", "error");
                        }
                        if (json['success'] == 'Added') {
                            if(user_type == 1) {
                                window.location.href = "<?php echo site_url('account/dealers')?>";
                            } else {
                                window.location.href = "<?php echo site_url('account/wholesalers')?>";
                            }

                        }
                        return false;
                    },
                });
                return false;
            });
            
            $(document).on('click',".is_primary_contact",function(){
                var $box = $(this);
                if ($box.is(":checked")) {
                    var group = "input:checkbox[class='check-new-one in-check is_primary_contact']";
                    $(group).prop("checked", false);
                    $box.prop("checked", true);
                } else {
                    $box.prop("checked", false);
                }
            });
        });
        
        function addContact(){
            var contact_data; 
            var d = new Date();
            var n = d.getMilliseconds();

            $("#add_contact").on("click",function(){
                //var contact_data = $("#dealer_contact_form").html();
                var d = new Date();
                var n = d.getMilliseconds();
                var x = Math.floor((Math.random()*(n/2)) + 1);
                n = "" + n + x;
                var div_id = "data_"+n;
                var contact_data = '';
                var checkbox_input_name = "primary_contact["+n+"]";
                var primary_contact_keys = ["quote_request_recipient","new_vehicle_tax_invoice_request_recipient","recipient_of_settlement_remittance_advice","introducer_tax_invoice_recipient"];
                contact_data += '<input type="hidden" name="contact_id[]" value="'+n+'"><div class="dealer-input-check"><span class="primary-contact">Primary Contact</span>';

                for (i = 0; i < primary_contact_keys.length; i++) {
                    var contact_key = primary_contact_keys[i]+n;
                    var contact_key_name = primary_contact_keys[i].split('_').join(' ');
                    //contact_key_name = contact_key_name.toUpperCase();
                    contact_key_name = contact_key_name.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                        return letter.toUpperCase();
                    });
                    contact_data += '<input type="checkbox" class="check-new-one in-check" id="'+contact_key+'" name="'+checkbox_input_name+'['+i+']" ><label for="'+contact_key+'" data-toggle="tooltip" data-placement="top" title="" data-original-title="'+contact_key_name+'"><span class="border-span"><i class="fa fa-check" aria-hidden="true"></i></span></label>';
                }
                
                // Is primary contact
                contact_data += "</div>";
                contact_data += '<div class="dealer-input-check">';
                    contact_data += '<span class="primary-contact" style="padding-right: 15px;">Is Primary Contact</span>';
                    contact_data += '<input type="checkbox" class="check-new-one in-check is_primary_contact" id="is_primary_contact'+n+'" value="1" name="contact_is_primary['+n+']">';
                    contact_data += '<label for="is_primary_contact'+n+'" data-toggle="tooltip" data-placement="top" title="is_primary_contact" data-original-title="Is Primary Contact"><span class="border-span"><i class="fa fa-check" aria-hidden="true"></i></span></label>';
                contact_data += '</div>';
                
                //contact_data += '<div class="form-group"><div class="dealer-detail-form-group"><span>Title</span><input type="text" name="contact_title[]" id="contact_title'+n+'" class="form-control pull-right"></div></div><div class="form-group"><div class="dealer-detail-form-group"><span class="require-field">Full Name</span><input type="text" name="contact_fullname[]" id="contact_fullname'+n+'" class="form-control pull-right"  ></div></div><div class="form-group"><div class="dealer-detail-form-group"><span class="require-field">Email = Username</span><input type="email" name="contact_email[]" id="contact_email'+n+'" class="form-control pull-right" ></div></div><div class="form-group"><div class="dealer-detail-form-group"><span>Mobile</span><input type="text" data-rule-number="true" name="contact_mobile[]" id="contact_mobile'+n+'" class="form-control pull-right"></div></div><div class="form-group"><div class="dealer-detail-form-group"><span>Landline</span><input type="text" data-rule-number="true" name="contact_landline[]" id="contact_landline'+n+'" class="form-control pull-right"></div></div>';
                   contact_data += '<div class="form-group">';
                       contact_data += '<div class="dealer-detail-form-group">';
                           contact_data += '<span>Title</span>';
                           contact_data += '<input type="text" name="contact_title[]" id="contact_title'+n+'" class="form-control pull-right">';
                       contact_data += '</div>';
                   contact_data += '</div>';
                   contact_data += '<div class="form-group">';
                       contact_data += '<div class="dealer-detail-form-group">';
                           contact_data += '<span class="require-field">Full Name</span>';
                           contact_data += '<input type="text" name="contact_fullname[]" id="contact_fullname'+n+'" class="form-control pull-right"  >';
                       contact_data += '</div>';
                   contact_data += '</div>';
                   contact_data += '<div class="form-group">';
                       contact_data += '<div class="dealer-detail-form-group">';
                           contact_data += '<span class="require-field">Email = Username</span>';
                           contact_data += '<input type="email" name="contact_email[]" id="contact_email'+n+'" class="form-control pull-right" >';
                       contact_data += '</div>';
                   contact_data += '</div>';
                   contact_data += '<div class="form-group">';
                       contact_data += '<div class="dealer-detail-form-group">';
                           contact_data += '<span>Mobile</span>';
                           contact_data += '<input type="text" data-rule-number="true" name="contact_mobile[]" id="contact_mobile'+n+'" class="form-control pull-right">';
                       contact_data += '</div>';
                   contact_data += '</div>';
                   contact_data += '<div class="form-group">';
                       contact_data += '<div class="dealer-detail-form-group">';
                           contact_data += '<span>Landline</span>';
                           contact_data += '<input type="text" data-rule-number="true" name="contact_landline[]" id="contact_landline'+n+'" class="form-control pull-right">';
                       contact_data += '</div>';
                   contact_data += '</div>';
                
                
                
                

                var button = '<div class="form-group text-right"><button type="button" name="delete_contact" id="delete_contact" class="btn btn-danger delete_contact" data-id="'+div_id+'" >Delete</button></div> <hr/>';

                /*if($("#dealer_contact_form").valid())
                {*/
                    var clone_div = "<div id='"+div_id+"'></div>";
                    $("#dealer_contacts").append(clone_div);
                    //$("#dealer_contact_form").children().clone(true,true).appendTo("#"+div_id);
                    $("#"+div_id).append(contact_data);
                    //$("#"+div_id).html($("#dealer_contact_form").html());
                    $("#"+div_id).append(button);
                    $("#dealer_contact_form").trigger("reset");

                /*}
                else
                {
                    //alert("hello");
                }*/

                $(".delete_contact").on("click",function(){
                    var div_ids = $(this).data("id");
                    $("#"+div_ids).remove();
                });
                $("[data-toggle='tooltip']").tooltip(); 
            });
        }

        
    </script>
</body>

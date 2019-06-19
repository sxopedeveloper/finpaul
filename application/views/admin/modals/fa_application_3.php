<style type="text/css">
    /*floating menu start*/

    .side_bar_buttons_container {
        right: 15px;
        top: 10px;
        position: fixed;
        z-index: 2147483647;
    }

    .side_bar_button {
        height: 30px;
        width: 25px;
        background-color: #000;
        opacity: .80;
        border-radius: 8px 0px 0px 8px;
        padding: 7px;
        color: #fff;
        cursor: pointer;
        cursor: hand;
        /*display: inline-block;*/
        font-size: 18px;
        vertical-align: top;
        margin-bottom: 3px;
    }

    /*floating menu ends*/

    .no-value {
        border: 1px solid #a94442;
    }

    .f-label {
        display: inline-block;
        max-width: 100%;
        margin-bottom: 2px;
        font-weight: 700;
    }

    .dealer-label {
        display: inline-block;
        max-width: 100%;
        margin-bottom: 5px;
        font-weight: 700;
        cursor: pointer;
        cursor: hand;
    }

    .panel-app-inputs {
        margin-top: 10px;
    }

    .row-input {
        margin-bottom: 10px;
    }

    .panel-body {
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.4);
        padding-bottom: 0px;
    }

    .panel-heading {
        box-shadow: 0 0px 2px rgba(0, 0, 0, 0.4);
        padding-top: 7px;
        padding-bottom: 5px;
    }

    .panel-title-fapplication {
        color: #33353f;
        font-size: 15px;
        font-weight: 700;
        padding: 0;
        text-transform: none;
    }

    .panel-title-3rd-dim {
        color: #33353f;
        font-size: 15px;
        font-weight: 700;
        padding: 0;
        text-transform: none;
    }

    .requirements {
        cursor: pointer;
        cursor: hand;
        padding-top: 6px;
    }

    .requirements-temp {
        cursor: pointer;
        cursor: hand;
        padding-top: 6px;
    }

    .requirements-tempo {
        cursor: pointer;
        cursor: hand;
        padding-top: 6px;
    }

    .requirements-temp2 {
        cursor: pointer;
        cursor: hand;
        padding-top: 6px;
    }

    .temp_dzone {
        cursor: pointer;
        cursor: hand;
        padding-top: 6px;
    }

    .requirements_green {
        background-color: #b2ffb2;
    }

    .del_file {
        cursor: pointer;
        cursor: hand;
    }

    .del_all_req {
        cursor: pointer;
        cursor: hand;
    }

    .all_req_button {
        cursor: pointer;
        cursor: hand;
    }

    .all_req_row {
        margin-bottom: 10px;
    }

    .req_button {
        font-size: 20px;
        cursor: pointer;
        cursor: hand;
    }

    .lead_email_send {
        color: #0088cc;
        cursor: pointer;
        cursor: hand;
    }

    .del_req {
        font-size: 23px;
        cursor: pointer;
        cursor: hand;
    }

    .hide_req {
        font-size: 23px;
        cursor: pointer;
        cursor: hand;
    }

    .pop_init {
        cursor: pointer;
        cursor: hand;
    }

    .pop_sett {
        cursor: pointer;
        cursor: hand;
    }

    .f-label {
        cursor: pointer;
        cursor: hand;
    }

    .ui-state-default {
        cursor: pointer;
        cursor: hand;
    }

    .email_popup {
        cursor: pointer;
        cursor: hand;
    }

    .abn_popup {
        cursor: pointer;
        cursor: hand;
    }

    .pac-container {
        z-index: 10000000000000000000000000000 !important;
    }

    .tooltip {
        z-index: 1000000000000000000000 !important;
    }

    .full_loader {
        z-index: 10000000000000000000000000000 !important;
    }

    .p-all-10 {
        padding-left: 7px;
        padding-right: 7px
    }

    .p-top-15 {
        padding-top: 10px;
    }

    /*
    #make{
    width: 134px;
    }
    #model{
    width: 134px;
    }
    */

    .panel-body {
        padding-bottom: 5px !important;
    }

    .google_address {
        width: 250px;
    }

    #fapplication_main_form .form-control input-sm {
        font-weight: bold;
    }

    .bootstrap-tagsinput {
        margin-bottom: 0px !important;
        line-height: 24px !important;
        border-radius: 0px !important;
    }

    .label-info {
        background: #58c603 !important;
    }

    .dz-upload {
        display: block;
        background-color: red;
        height: 10px;
        width: 0%;
    }

    .form-group {
        padding-left: 5px !important;
        padding-right: 5px !important;
        margin-bottom: 5px !important;
    }

    .btn-full {
        width: 100% !important;
    }

    .panel-heading {
        background-color: #BEBEBE !important;
    }


    #fapplication_computation .text-line {
        background-color: transparent;
        color: #888;
        outline: none;
        outline-style: none;
        border-top: none;
        border-left: none;
        border-right: none;
        border-bottom: solid #ddd 1px;
        padding: 0px 0px;
        height: 22px;
        width: 100%;
    }

    .comon-text .text-line {
        background-color: transparent;
        color: #888;
        outline: none;
        outline-style: none;
        border-top: none;
        border-left: none;
        border-right: none;
        border-bottom: solid #ddd 1px;
        padding: 0px 0px;
        height: 22px;
        width: 100%;
    }


    .round {
        position: relative;
    }

    .round label {
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 50%;
        cursor: pointer;
        left: 282px;
        height: 28px;
        position: absolute;
        top: -22px;
        width: 28px;
    }

    .round label:after {
        border: 2px solid #fff;
        border-top: none;
        border-right: none;
        content: "";
        height: 6px;
        left: 7px;
        opacity: 0;
        position: absolute;
        top: 8px;
        transform: rotate(-45deg);
        width: 12px;
    }

    .round input[type="checkbox"] {
        visibility: hidden;
    }

    .round input[type="checkbox"]:checked+label {
        background-color: #58c603;
        border-color: #58c603;
    }

    .round input[type="checkbox"]:checked+label:after {
        opacity: 1;
    }

</style>
<div id="fapplication-modal-3" class="modal fade">
    <?php include 'fa_sidenote.php'; ?>
    <?php include 'floating_menu.php'; ?>
    <?php include 'fa_req_list_modal.php'; ?>
    <div class="modal-dialog model-new-design p10" style="width: 95%;">
        <div class="panel-body">
            <div class="modal-wrapper ptb10">
                <div class="modal-text">
                    <form method="post" action="" id="fapplication_main_form" name="fapplication_main_form">
                        <div class="popup-detail mb30 p10">
                            <div class="row fa_app_inp" id="fapplication_summary_new">
                                <div class="col-md-3">
                                    <div class="clearfix">
                                        <h3 class="pull-left">Luke Ashcroft</h3>
                                        <!-- <span class="pull-right">0436 773 254</span> -->
                                        <input type="text" name="number" class="pull-right form-control num_inp">
                                    </div>

                                    <div class="mt20 text-capitalize personal-detail car_detail">
                                        <p>Client Registered Address</p>
                                        <!-- <p class="value">27 forest Way, warringah 2614</p> -->
                                        <div class="form-group">
                                            <input type="text" name="address" class="form-control address_inp">
                                        </div>
                                        <p>postcode</p>
                                        <!-- <p class="value">2614</p> -->
                                        <div class="form-group">
                                            <input type="text" name="postcode" class="form-control address_inp">
                                        </div>
                                        <p>DL No.</p>
                                        <!-- <p class="value">7389267</p> -->
                                        <div class="form-group">
                                            <input type="text" name="dl_no" class="form-control address_inp">
                                        </div>
                                        <p>credit card type A</p>
                                        <!-- <p class="value">VISA</p> -->
                                        <div class="form-group">
                                            <input type="text" name="credit_card" class="form-control address_inp">
                                        </div>
                                        <p>credit card no.</p>
                                        <!-- <p class="value">8367-7842-7872-8743</p> -->
                                        <div class="form-group">
                                            <input type="text" name="card_no" class="form-control address_inp">
                                        </div>
                                        <p>expiration date</p>
                                        <!-- <p class="value">08/16</p> -->
                                        <div class="form-group">
                                            <input type="text" name="exp_date" class="form-control address_inp">
                                        </div>
                                        <p>CVV</p>
                                        <!-- <p class="value">227</p> -->
                                        <div class="form-group">
                                            <input type="text" name="cvv_no" class="form-control address_inp">
                                        </div>
                                        <p>Deposit amount <span class="pull-right">$165 Fee&nbsp;<i class="fa fa-check-circle-o fa-2x"></i> </span></p>
                                        <!-- <p class="value">$2,000</p> -->
                                        <div class="form-group">
                                            <input type="text" name="deposit_amt" class="form-control address_inp">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="clearfix">
                                        <!-- <p class="text-white pull-left" style="font-size:14px;">lukeashcroft@gmail.com</p> -->
                                        <input type="text" name="email_address" class="form-control email_inp">
                                        <h4 class="pull-right text-white">FQ01573</h4>
                                    </div>
                                    <img src="<?php echo base_url('/assets/img/redbook-logo-new.png');?>" class="img img-responsive mt20" width="130px">
                                    <img src="<?php echo base_url('/assets/img/bmw-logo.png');?>" class="img img-responsive bmw" width="60px">
                                    <div class="mt50 text-capitalize personal-detail car_make">
                                        <p>year</p>
                                        <!-- <p class="value">2017</p> -->
                                        <div class="form-group">
                                            <!-- <input type="text" name="year" class="form-control num_inp" placeholder="Year"> -->
                                            <select class="form-control num_inp" name="year">
                                                <option value="">Test 1</option>
                                                <option value="">Test 2</option>
                                                <option value="">Test 3</option>
                                                <option value="">Test 4</option>
                                                <option value="">Test 5</option>
                                                <option value="">Test 6</option>
                                                <option value="">Test 7</option>
                                            </select>
                                        </div>
                                        <p>make</p>
                                        <!-- <p class="value">BMW</p> -->
                                        <div class="form-group">
                                            <!-- <input type="text" name="car_make" class="form-control address_inp" placeholder="Make"> -->
                                            <select name="car_make" class="form-control email_inp">
                                                <option value="">Test 1</option>
                                                <option value="">Test 2</option>
                                                <option value="">Test 3</option>
                                                <option value="">Test 4</option>
                                                <option value="">Test 5</option>
                                                <option value="">Test 6</option>
                                                <option value="">Test 7</option>
                                            </select>
                                        </div>
                                        <p>model</p>
                                        <!-- <p class="value">340i</p> -->
                                        <div class="form-group">
                                            <!-- <input type="text" name="car_model" class="form-control address_inp" placeholder="Model"> -->
                                            <select name="car_model" class="form-control address_inp">
                                                <option value="">Test 1</option>
                                                <option value="">Test 2</option>
                                                <option value="">Test 3</option>
                                                <option value="">Test 4</option>
                                                <option value="">Test 5</option>
                                                <option value="">Test 6</option>
                                                <option value="">Test 7</option>
                                            </select>
                                        </div>
                                        <p>variant</p>
                                        <!-- <p class="value">2017 BMW 340i M sport f30 auto</p> -->
                                        <div class="form-group">
                                            <!-- <input type="text" name="car_variant" class="form-control address_inp" placeholder="Variant"> -->
                                            <select name="car_variant" class="form-control address_inp">
                                                <option value="">Test 1</option>
                                                <option value="">Test 2</option>
                                                <option value="">Test 3</option>
                                                <option value="">Test 4</option>
                                                <option value="">Test 5</option>
                                                <option value="">Test 6</option>
                                                <option value="">Test 7</option>
                                            </select>
                                        </div>
                                        <p>redbook link</p>
                                        <!-- <p class="value">https://www.redbook.com.au/boat-news/sacs-marine/champagne-concierge-service-for-boaters-110308?csn_tnet=true</p> -->
                                        <div class="form-group">
                                            <input type="text" name="redbook_link" class="form-control address_inp">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mt40 text-capitalize personal-detail car_dealer">
                                        <p>sale price/changeover</p>
                                        <!-- <p class="value">$64,850</p> -->
                                        <div class="form-group">
                                            <input type="text" name="sale_price" class="form-control address_inp">
                                        </div>
                                        <p>winning quote</p>
                                        <!-- <p class="value">$61,700</p> -->
                                        <div class="form-group">
                                            <input type="text" name="winning_quote" class="form-control address_inp">
                                        </div>
                                        <p>winning <span class="text-blue">trade</span> value</p>
                                        <!-- <hr> -->
                                        <div class="form-group">
                                            <input type="text" name="trade_value" class="form-control address_inp">
                                        </div>
                                        <p>gross margin</p>
                                        <!-- <p class="value">$3000</p> -->
                                        <div class="form-group">
                                            <input type="text" name="margin_gross" class="form-control address_inp">
                                        </div>
                                        <p>delivery date</p>
                                        <!-- <p class="value">29/10/2017</p> -->
                                        <div class="form-group">
                                            <input type="text" name="delivery_date" class="form-control address_inp">
                                        </div>
                                        <p>dealer</p>
                                        <!-- <p class="value">nothshore BMW</p> -->
                                        <div class="form-group">
                                            <input type="text" name="dealer" class="form-control address_inp">
                                        </div>
                                        <p>wholesaler</p>
                                        <!-- <hr> -->
                                        <div class="form-group">
                                            <input type="text" name="wholesaler" class="form-control address_inp">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 map mt40">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3316.725514944585!2d151.26376921482654!3d-33.76775818068429!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6b12aa44fc3e5197%3A0xf017d68f9f32900!2sWestfield+Warringah+Mall!5e0!3m2!1sen!2sin!4v1513772417996" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
                                    <p>Enlarge</p>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="fapplication_status_id" name="fapplication_status" value="" />
                        <input type="hidden" id="fq_admin_flag" value="">
                        <input type="hidden" id="fqa_number" value="" />
                        <div class="alert alert-warning hide" id="temp_user_div" hidden>
                            Temporarily assigned to <strong id="temp_user_name"></strong>
                        </div>
                        <div class="table-responsive hide">
                            <table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
                                <thead>
                                    <tr>
                                        <td><i class="fa fa-file-pdf-o" data-toggle="tooltip" data-placement="top" title="Order PDF"></i></td>
                                        <td><b>FQ Number</b></td>
                                        <td><b>Source</b></td>
                                        <td><b>CQ Staff</b></td>
                                        <td><b>FQ Staff</b></td>
                                        <td><b>Client Name</b></td>
                                        <td><b>Email</b></td>
                                        <td><b>Phone</b></td>
                                        <td><b>Mobile</b></td>
                                        <td><b>State</b></td>
                                        <td><b>Make</b></td>
                                        <td><b>Model</b></td>
                                        <td><b>Date/Time</b></td>
                                    </tr>
                                </thead>
                                <tbody id="fapplication_summary"></tbody>
                            </table>
                        </div>

                        <div class="toogle" data-plugin-toggle="">
                            <section class="toggle notes_open" id="first_t_c">
                                <label>NOTES</label>
                                <button class="btn btn-default btn-sm" id="add_note_button" type="button" style="position:absolute; top:7px; left:10%; border-color:#fff; background-color:#fff; color:#333;">Add Note</button>
                                <div class="toggle-content collapse in " id="openfirst">
                                    <div class="table-responsive" id="">
                                        <div class="panel panel-default">
                                            <div class="note-model">
                                                <div class="">
                                                    <div class="row">
                                                        <div class="col-md-12" data-flag="1">
                                                            <textarea class="form-control textarea" style="" id="note-model-textarea1" placeholder="Write your notes here..." row=300></textarea>
                                                        </div>
                                                        <div class="col-md-12" hidden data-flag="2">
                                                            <textarea class="form-control textarea_2" placeholder="Write your notes here..." row=300></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <div class="toogle" data-plugin-toggle="">
                            <section class="toggle">
                                <label>TENDER  </label>
                                <button class="btn btn-default btn-sm" id="tfapplication_start_tender_button" type="button" style="position:absolute; top:7px; left:10%; border-color:#fff; background-color:#fff; color:#333;">Start Tender</button>
                                <div class="toggle-content">
                                    <div class="table-responsive" id="tfapplication_actions_history">

                                    </div>
                                </div>
                            </section>
                        </div>

                        <div class="toogle" data-plugin-toggle="">
                            <section class="toggle">
                                <label>TRADEIN</label>
                                <!--<button class="btn btn-default btn-sm" data-id_lead="" id="start_valuation_button" type="button" style="position:absolute; top:7px; left:10%; border-color:#fff; background-color:#fff; color:#333;">Start Valuation</button>-->
                                <div class="toggle-content">
                                    <div class="table-responsive comon-text" id="fapplication_traidin">

                                    </div>
                                </div>
                            </section>
                        </div>

                        <div class="toogle" data-plugin-toggle="">
                            <section class="toggle">
                                <label>COMPUTATION</label>
                                <div class="toggle-content">
                                    <div class="table-responsive" id="fapplication_computation">

                                    </div>
                                </div>
                            </section>
                        </div>

                        <div class="toogle" data-plugin-toggle="">
                            <section class="toggle" id="requirements_tab_panel">
                                <label>REQUIREMENTS</label>
                                <div class="toggle-content">
                                    <div class="row row-input all_req_row">
                                        <input type="hidden" value="" id="all_req_hidden_val">
                                        <div class="col-md-offset-6 col-md-6">
                                            <select id="new_req_temp_storage" class="" hidden>

                                            </select>
                                            <div class="row">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="requirements_section">
                                        <input type="hidden" value="" id="req_hidden_val">
                                        <input type="hidden" value="" id="is_temp_hidden">
                                        <div class="req_sec_panel">
                                        </div>
                                        <!-- <div class="req_sett_panel"></div> -->
                                    </div>
                                </div>
                            </section>
                        </div>

                        <div class="toogle" data-plugin-toggle="">
                            <section class="toggle">
                                <label>INVOICE AND PAYMENT</label>
                                <div class="toggle-content">
                                    <div class="table-responsive comon-text" id="fapplication_payment">

                                    </div>
                                </div>
                            </section>
                        </div>
                      
                        <div class="toogle" data-plugin-toggle="">
                            <section class="toggle" id="application_section">
                                <label>APPLICATION FIELDS</label>
                                <div class="toggle-content" style="display: block; margin-top: 15px;" id="application_fields">
                                    <div class="row temp_parent_panel">
                                        <div class="col-md-6 left">
                                            <div class="row top-fields" style="margin-left: -5px; margin-right: -5px;">
                                                <div class="form-group col-md-4">
                                                    <label for="loan_use" class="f-label">Loan Use</label>
                                                    <select name="loan_use" id="loan_use" class="form-control input-sm loan_use">
                                                        <option value="consumer">Consumer</option>
                                                        <option value="business">Business</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="loan_type" class="f-label">Loan Type</label>
                                                    <select name="loan_type" id="loan_type" class="form-control input-sm loan_type">
                                                        <option value="Chattel Mortgage">Chattel Mortgage</option>
                                                        <option value="Consumer Loan">Consumer Loan</option>
                                                        <option value="CHP">CHP</option>
                                                        <option value="Lease">Lease</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="cust_type" class="f-label">Customer Type</label>
                                                    <select name="cust_type" id="cust_type" class="form-control input-sm cust_type">
                                                        <option></option>
                                                        <option value="joint">Joint</option>
                                                        <option value="individual">Individual</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="multiple_dynamic" id="multiple_dynamic">
                                                <div class="panel panel-default panel-main">
                                                    <div class="panel-heading panel-applicant">
                                                        <label class="panel-title-fapplication panel-title-main">Applicant 1</label>
                                                        <button type="button" class="btn btn-danger btn-xs pull-right applicant-remove">Remove</button>
                                                        <button type="button" class="btn btn-primary btn-xs pull-right applicant-add">Add</button>
                                                    </div>
                                                    <input type="hidden" name="applicant_id[0]" class="form-control input-sm applicant_id">
                                                    <div class="panel-body panel-applicant-body" style="background: #d2ffbf">
                                                        <!-- twentysecond row -->
                                                        <div class="applicant_info">
                                                            <div class="row">
                                                                <div class="form-group col-md-3">
                                                                    <label for="title" class="f-label">Title</label>
                                                                    <select name="title[0]" class="form-control input-sm title">
                                                                        <option value="Mr.">Mr</option>
                                                                        <option value="Mrs.">Mrs</option>
                                                                        <option value="Ms.">Ms</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-3">
                                                                    <label for="first_name" class="f-label">First name</label>
                                                                    <input type="text" name="first_name[0]" class="form-control input-sm first_name">
                                                                </div>
                                                                <div class="form-group col-md-3">
                                                                    <label for="middle_name" class="f-label">Middle name</label>
                                                                    <input type="text" name="middle_name[0]" class="form-control input-sm middle_name">
                                                                </div>
                                                                <div class="form-group col-md-3">
                                                                    <label for="last_name" class="f-label">Surname</label>
                                                                    <input type="text" name="last_name[0]" class="form-control input-sm last_name">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group col-md-4">
                                                                    <label for="mobile" class="f-label">Primary Number</label>
                                                                    <input type="text" name="mobile[0]" class="form-control input-sm mobile ">
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label for="other_telephone" class="f-label">Secondary Number</label>
                                                                    <input type="text" name="other_telephone[0]" class="form-control input-sm other_telephone ">
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label for="email" class="f-label">Email</label>
                                                                    <div class="input-group email_group">
                                                                        <input type="text" name="email[0]" class="form-control input-sm email">
                                                                        <span class="input-group-addon email_popup">@</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group col-md-3">
                                                                    <label for="date_of_birth" class="f-label">Date of Birth</label>
                                                                    <input type="text" name="date_of_birth[0]" class="form-control input-sm date_of_birth">
                                                                </div>
                                                                <div class="form-group col-md-3">
                                                                    <label for="marital_stat" class="f-label">Marital Status</label>
                                                                    <select name="marital_stat[0]" class="form-control input-sm marital_stat">
                                                                        <option value=""> - Please Choose - </option>
                                                                        <option value="married">Married</option>
                                                                        <option value="single">Single</option>
                                                                        <option value="defacto">Defacto</option>
                                                                        <option value="widowed">Widowed</option>
                                                                        <option value="divorced">Divorced</option>
                                                                        <option value="separated">Separated</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-3">
                                                                    <label for="dependents" class="f-label">Dependents</label>
                                                                    <select name="dependents[0]" class="form-control input-sm dependents">
                                                                        <?php
                                                                        for ($i=0; $i < 12; $i++) 
                                                                        { 
                                                                            echo "<option value='{$i}'>{$i}</option>";
                                                                        }
                                                                        ?>	
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-3">
                                                                    <label for="ages" class="f-label">Ages</label>
                                                                    <input type="text" name="ages[0]" class="form-control input-sm ages">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group col-md-3">
                                                                    <label for="dl_number" class="f-label">Driving License No.</label>
                                                                    <input type="text" name="dl_number[0]" class="form-control input-sm dl_number">
                                                                </div>
                                                                <div class="form-group col-md-3">
                                                                    <label for="dl_exp" class="f-label">Expiry Date</label>
                                                                    <input type="text" name="dl_exp[0]" class="form-control input-sm dl_exp">
                                                                </div>
                                                                <div class="form-group col-md-3">
                                                                    <label for="dl_state" class="f-label">State</label>
                                                                    <select name="dl_state[0]" class="form-control input-sm dl_state">
                                                                        <option value=""> - Please Choose - </option>
                                                                        <option value="nsw">NSW</option>
                                                                        <option value="vic">VIC</option>
                                                                        <option value="qld">QLD</option>
                                                                        <option value="wa">WA</option>
                                                                        <option value="tas">TAS</option>
                                                                        <option value="nt">NT</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-3">
                                                                    <label for="dl_type" class="f-label">License Type</label>
                                                                    <select name="dl_type[0]" class="form-control input-sm dl_type">
                                                                        <option value="full">Full</option>
                                                                        <option value="heavy_duty">Heavy Duty</option>
                                                                        <option value="learner">Learner</option>
                                                                        <option value="private_plate">Private Plate</option>
                                                                        <option value="pensioner">Pensioner</option>
                                                                        <option value="professional">Professional</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="address-clause">
                                                                <div class="initial_address_panel">
                                                                    <input type="hidden" name="address_id[0][0]" class="form-control address_id">
                                                                    <div class="row">
                                                                        <div class="form-group col-md-12">
                                                                            <label for="client_address" class="f-label">Street Address</label>
                                                                            <div class="input-group email_group">
                                                                                <input type="text" name="client_address[0][0]" class="form-control input-sm client_address google_address initial_address" style="width: 100%">
                                                                                <span class="input-group-addon">
                                                                                    <input type="checkbox" data-toggle="tooltip" data-placement="top" title="Visa Holder" name="visa_holder[0]" class="visa_holder">
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="form-group col-md-4">
                                                                            <label for="client_suburb" class="f-label">Suburb</label>
                                                                            <input type="text" name="client_suburb[0][0]" class="form-control input-sm client_suburb google_suburb">
                                                                        </div>
                                                                        <div class="form-group col-md-4">
                                                                            <label for="client_post_code" class="f-label">Post Code</label>
                                                                            <input type="text" name="client_post_code[0][0]" class="form-control input-sm client_post_code google_postcode">
                                                                        </div>
                                                                        <div class="form-group col-md-4">
                                                                            <label for="client_state" class="f-label">State</label>
                                                                            <select name="client_state[0][0]" class="form-control input-sm client_state">
                                                                                <option name="state" value="">-State-</option>
                                                                                <option name="state" value="ACT" >ACT</option>
                                                                                <option name="state" value="NSW" >NSW</option>
                                                                                <option name="state" value="NT" >NT</option>
                                                                                <option name="state" value="QLD" >QLD</option>
                                                                                <option name="state" value="SA" >SA</option>
                                                                                <option name="state" value="TAS" >TAS</option>
                                                                                <option name="state" value="VIC" >VIC</option>
                                                                                <option name="state" value="WA" >WA</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="form-group col-md-2">
                                                                            <label class="f-label">Time</label>
                                                                            <select name="time_address_years[0][0]" class="form-control input-sm time_address_years time_add">
                                                                                <?php
                                                                                for ($i=0; $i < 100; $i++) 
                                                                                { 
                                                                                    echo "<option value='{$i}'>{$i}</option>";
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-2">
                                                                            <label class="f-label">-</label>
                                                                            <select name="time_address_month[0][0]" class="form-control input-sm time_address_month time_add">
                                                                                <?php
                                                                                for ($i=0; $i < 13; $i++) 
                                                                                { 
                                                                                    echo "<option value='{$i}'>{$i}</option>";
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-2">
                                                                            <label class="f-label">-</label>
                                                                            <span class="btn btn-primary add_address" style="height: 30px; width: 100%" data-toggle="tooltip" data-placement="top" title="Add previous address">Add</span>
                                                                        </div>
                                                                        <div class="form-group col-md-3">
                                                                            <label for="client_res_stat" class="f-label">Res. Status</label>
                                                                            <select name="client_res_stat[0][0]" class="form-control input-sm client_res_stat">
                                                                                <option value="">--Please Choose--</option>
                                                                                <option value="mortgage">Mortgage</option>
                                                                                <option value="renting">Renting</option>
                                                                                <option value="owner">Owner</option>
                                                                                <option value="Living with parents">Living with parents</option>
                                                                                <option value="Boarding">Boarding</option>
                                                                                <option value="Employer Subsidised">Employer Subsidised</option>
                                                                                <option value="other">Other</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-3">
                                                                            <label for="monthly_commitment" class="f-label">Monthly Comm.</label>
                                                                            <input type="text" name="monthly_commitment[0][0]" class="form-control input-sm monthly_commitment">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row landlord-hidden" hidden>
                                                                        <div class="form-group col-md-3">
                                                                            <label for="number_on_lease" class="f-label">Number on Lease</label>
                                                                            <select name="number_on_lease[0][0]" class="form-control input-sm number_on_lease">
                                                                                <?php
                                                                                for ($i=0; $i < 10; $i++) 
                                                                                { 
                                                                                    echo "<option value='{$i}'>{$i}</option>";
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-3">
                                                                            <label for="landlord_realestate_name" class="f-label">Landlord/Realestate Agent</label>
                                                                            <input type="text" name="landlord_realestate_name[0][0]" class="form-control input-sm landlord_realestate_name">
                                                                        </div>
                                                                        <div class="form-group col-md-3">
                                                                            <label for="landlord_realestate_contact" class="f-label">Landlord/Realestate Contact</label>
                                                                            <input type="text" name="landlord_realestate_contact[0][0]" class="form-control input-sm landlord_realestate_contact">
                                                                        </div>
                                                                        <div class="form-group col-md-3">
                                                                            <label for="landlord_realestate_number" class="f-label">Landlord/Realestate Number</label>
                                                                            <input type="text" name="landlord_realestate_number[0][0]" class="form-control input-sm landlord_realestate_number ">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row prev_panel_parent" style="margin-right: -9px; margin-left: -9px; margin-top: 5px;">
                                                                    <div class="panel panel-default prev_address_panel">
                                                                        <div class="panel-heading" style="padding: 10px; ">
                                                                            <label style="font-weight: bold;" class="panel-title-fapplication">Previous Address 1</label>
                                                                            <button type="button" class="btn btn-danger btn-xs pull-right remove" data-flag="address">Remove</button>
                                                                        </div>
                                                                        <input type="hidden" name="address_id[0][1]" class="form-control address_id">
                                                                        <div class="panel-body" style="background: #7fffff">
                                                                            <div class="row">
                                                                                <div class="form-group col-md-12">
                                                                                    <label for="client_address" class="f-label">Street Address</label>
                                                                                    <input type="text" name="client_address[0][1]" class="form-control input-sm client_address google_address" style="width: 100%">
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="form-group col-md-4">
                                                                                    <label for="client_suburb" class="f-label">Suburb</label>
                                                                                    <input type="text" name="client_suburb[0][1]" class="form-control input-sm client_suburb google_suburb">
                                                                                </div>
                                                                                <div class="form-group col-md-4">
                                                                                    <label for="client_post_code" class="f-label">Post Code</label>
                                                                                    <input type="text" name="client_post_code[0][1]" class="form-control input-sm client_post_code google_postcode">
                                                                                </div>
                                                                                <div class="form-group col-md-2">
                                                                                    <label class="f-label">Time</label>
                                                                                    <select name="time_address_years[0][1]" class="form-control input-sm time_address_years time_add">
                                                                                        <?php
                                                                                        for ($i=0; $i < 100; $i++) 
                                                                                        { 
                                                                                            echo "<option value='{$i}'>{$i}</option>";
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="form-group col-md-2">
                                                                                    <label class="f-label">-</label>
                                                                                    <select name="time_address_month[0][1]" class="form-control input-sm time_address_month time_add">
                                                                                        <?php
                                                                                        for ($i=0; $i < 13; $i++) 
                                                                                        { 
                                                                                            echo "<option value='{$i}'>{$i}</option>";
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="property_clause">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <label class="panel-title-fapplication new" hidden>Property 1</label>
                                                        <label class="panel-title-fapplication default">Add a Property?</label>
                                                        <button type="button" class="btn btn-danger btn-xs pull-right remove" data-flag="property_claue" disabled>Remove</button>
                                                        <button type="button" class="btn btn-primary btn-xs pull-right add" data-flag="property_claue">Add</button>
                                                    </div>
                                                    <input type="hidden" name="property_id[0][0]" class="form-control property_id">
                                                    <div class="panel-body" hidden style="background: #d2ffbf">
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <label for="property_address" class="f-label">Street Address</label>
                                                                <div class="input-group">
                                                                    <input type="text" name="property_address[0][0]" class="form-control input-sm property_address google_address" style="width: 100%">
                                                                    <span class="input-group-addon">
                                                                        <input type="checkbox" data-toggle="tooltip" data-placement="top" title="Name on Title" class="name_on_title" name="name_on_title[0][0]">
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-4">
                                                                <label for="property_suburb" class="f-label">Suburb</label>
                                                                <input type="text" name="property_suburb[0][0]" class="form-control input-sm property_suburb google_suburb">
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="property_postcode" class="f-label">Postcode</label>
                                                                <input type="text" name="property_postcode[0][0]" class="form-control input-sm property_postcode google_postcode">
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="mortgage_with" class="f-label">Mortgage Institution</label>
                                                                <input type="text" name="mortgage_with[0][0]" class="form-control input-sm mortgage_with">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-3">
                                                                <label for="balance" class="f-label">Mortgage Balance</label>
                                                                <input type="text" name="balance[0][0]" class="form-control input-sm balance">
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <label for="property_value" class="f-label">Property Value</label>
                                                                <input type="text" name="property_value[0][0]" class="form-control input-sm property_value">
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <label for="mortgage_commitment" class="f-label">Monthly Rental Income</label>
                                                                <div class="input-group">
                                                                    <input type="text" name="mortgage_commitment[0][0]" class="form-control input-sm mortgage_commitment">
                                                                    <span class="input-group-addon">
                                                                        <input type="checkbox" data-toggle="tooltip" data-placement="top" title="Managed with statements available" class="managed" name="managed[0][0]">
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <label for="monthly_payment" class="f-label">Monthly Payment</label>
                                                                <input type="text" name="monthly_payment[0][0]" class="form-control input-sm monthly_payment">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="loan_clause">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <label class="panel-title-fapplication new" hidden>Other Loans 1</label>
                                                        <label class="panel-title-fapplication default">Add Other Loans?</label>
                                                        <button type="button" class="btn btn-danger btn-xs pull-right remove" data-flag="loan_clause" disabled>Remove</button>
                                                        <button type="button" class="btn btn-primary btn-xs pull-right add" data-flag="loan_clause">Add</button>
                                                    </div>
                                                    <input type="hidden" name="other_loans_id[0][0]" class="form-control other_loans_id">
                                                    <div class="panel-body" hidden style="background: #d2ffbf">
                                                        <div class="row">
                                                            <div class="form-group col-md-4">
                                                                <label for="lending_institution" class="f-label">Lending Institution</label>
                                                                <input type="text" name="lending_institution[0][0]" class="form-control input-sm lending_institution">
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="purpose" class="f-label">Purpose for Loan</label>
                                                                <input type="text" name="purpose[0][0]" class="form-control input-sm purpose">
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label class="f-label">Monthly Payment</label>
                                                                <input type="text" name="o_monthly_payment[0][0]" class="form-control input-sm o_monthly_payment outgoing_calc">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-4">
                                                                <label for="loan_start_date" class="f-label">Start Date</label>
                                                                <input type="text" name="loan_start_date[0][0]" class="form-control input-sm loan_start_date">
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="o_term" class="f-label">Loan Term</label>
                                                                <input type="text" name="o_term[0][0]" class="form-control input-sm o_term">
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="amount_borrowed" class="f-label">Balance</label>
                                                                <input type="text" name="amount_borrowed[0][0]" class="form-control input-sm amount_borrowed" onkeypress="return isNumberKey(event)">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cred_card_clause">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <label class="panel-title-fapplication new" hidden>Credit Card 1</label>
                                                        <label class="panel-title-fapplication default">Add a Credit Card?</label>
                                                        <button type="button" class="btn btn-danger btn-xs pull-right remove" data-flag="credit_card_clause" disabled>Remove</button>
                                                        <button type="button" class="btn btn-primary btn-xs pull-right add" data-flag="credit_card_clause">Add</button>
                                                    </div>
                                                    <input type="hidden" name="credit_card_id[0][0]" class="form-control credit_card_id">
                                                    <div class="panel-body" hidden style="background: #d2ffbf">
                                                        <div class="row">
                                                            <div class="form-group col-md-3">
                                                                <label for="credit_card_name" class="f-label">Provider</label>
                                                                <input type="text" name="credit_card_name[0][0]" class="form-control input-sm credit_card_name">
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <label for="credit_card_limit" class="f-label">Limit ($)</label>
                                                                <input type="text" name="credit_card_limit[0][0]" class="form-control input-sm credit_card_limit outgoing_calc" onkeypress="return isNumberKey(event)">
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <label for="credit_card_balance" class="f-label">Balance</label>
                                                                <input type="text" name="credit_card_balance[0][0]" class="form-control input-sm credit_card_balance">
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <label for="credit_card_monthly" class="f-label">Monthly Payment</label>
                                                                <input type="text" name="credit_card_monthly[0][0]" class="form-control input-sm credit_card_monthly">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="living_cost_clause">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <label class="panel-title-fapplication">Living Cost</label>
                                                    </div>
                                                    <div class="panel-body" style="background: #d2ffbf">
                                                        <div class="row">
                                                            <div class="form-group col-md-4">
                                                                <label for="food_beverage" class="f-label">Food</label>
                                                                <input type="text" name="food_beverage[0]" class="form-control input-sm food_beverage living_cost" onkeypress="return isNumberKey(event)">
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="power_gas" class="f-label">Utilities</label>
                                                                <input type="text" name="power_gas[0]" class="form-control input-sm power_gas living_cost" onkeypress="return isNumberKey(event)">
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="insurance" class="f-label">Insurance Prem</label>
                                                                <input type="text" name="insurance[0]" class="form-control input-sm insurance living_cost" onkeypress="return isNumberKey(event)">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-4">
                                                                <label for="transportation_fuel" class="f-label">Transport</label>
                                                                <input type="text" name="transportation_fuel[0]" class="form-control input-sm transportation_fuel living_cost" onkeypress="return isNumberKey(event)">
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="recreation" class="f-label">Recreation</label>
                                                                <input type="text" name="recreation[0]" class="form-control input-sm recreation living_cost" onkeypress="return isNumberKey(event)">
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="tot_living_cost" class="f-label">Total Living Cost</label>
                                                                <div class="input-group">
                                                                    <input type="text" name="tot_living_cost[0]" class="form-control input-sm tot_living_cost" onkeypress="return isNumberKey(event)">
                                                                    <!-- <span class="input-group-addon">
                                                                    <input type="checkbox" class="tot_living_cost_check" name="tot_living_cost_check[0]" value="1" data-toggle="tooltip" data-placement="top" title="15% - Recreation, 10% - Communications, 20% - Transportation, 25% - Food, 20% - Utilities, 10% - Insurance.">
                                                                    </span> -->
                                                                    <span class="input-group-addon tot_living_cost_check" data-toggle="tooltip" data-placement="top" title="15% - Recreation, 10% - Communications, 20% - Transportation, 25% - Food, 20% - Utilities, 10% - Insurance.">+/-</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-6 right">
                                            <div class="row top-fields" style="margin-left: -5px; margin-right: -5px;">
                                                <div class="form-group col-md-6">
                                                    <label for="assessment_type" class="f-label">Assessment Type</label>
                                                    <select name="assessment_type" id="assessment_type" class="form-control input-sm">
                                                        <option value="Fast Track/Replacement">Fast Track/Replacement</option>
                                                        <option value="Express/Replacement"> Express/Replacement</option>
                                                        <option value="Low doc/Replacement">Low doc/Replacement</option>
                                                        <option value="Full Doc" selected="selected">Full Doc</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="rego" class="f-label">Current Date</label>
                                                    <input type="text" class="form-control input-sm" id="current_date">
                                                </div>
                                            </div>
                                            <div class="car_details" id="car_details">
                                                <div class="panel panel-default ">
                                                    <div class="panel-heading ">
                                                        <label class="panel-title-fapplication">Car &amp; Supplier</label>
                                                    </div>
                                                    <div class="panel-body panel-applicant-body" style="background: #d2ffbf">
                                                        <div class="row">
                                                            <div class="form-group col-md-3">
                                                                <label for="car" class="f-label ">Car</label>
                                                                <select name="car" id="car" class="form-control input-sm">
                                                                    <option value="Demo" selected>Demo</option>
                                                                    <option value="New">New</option>
                                                                    <option value="Used">Used</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-3" id="makes_row">
                                                                <label for="make" class="f-label">Make</label>
                                                                <select name="make" id="make" class="form-control input-sm">

                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-3" id="model_row">
                                                                <label for="model" class="f-label">Model</label>
                                                                <select name="model" id="model" class="form-control input-sm">

                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-3" id="year_row">
                                                                <label for="year" class="f-label">Year</label>
                                                                <select name="year" id="year" class="form-control input-sm">

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-12" id="variant_row">
                                                                <label for="variant" class="f-label">Variant</label>
                                                                <select name="variant" id="variant" class="form-control input-sm" style="width: 100%">

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <label class="f-label">Color, Options &amp; Further Details</label>
                                                                <div class="input-group">
                                                                    <textarea name="further_details_supplies" id="further_details_supplies" class="form-control input-sm" rows="1" cols="50" placeholder="Color, Options &amp; Further Details..."></textarea>
                                                                    <span class="input-group-addon">
                                                                        <input type="checkbox" data-toggle="tooltip" data-placement="top" title="Replacement" name="replacement" id="replacement" class="replacement">
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-3">
                                                                <label for="seller" class="f-label">Seller</label>
                                                                <select name="seller" class="form-control input-sm" id="seller">
                                                                    <option value="PRIVATE">PRIVATE</option>
                                                                    <option value="FRANCHISED DEALER">FRANCHISED DEALER</option>
                                                                    <option value="OTHER DEALER">OTHER DEALER</option>
                                                                    <option value="SALE">SALE</option>
                                                                    <option value="LEASE BACK">LEASE BACK</option>
                                                                    <option value="CQO">CQO</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-3" id="dealers_name_dom">
                                                                <label for="dealer" class="dealer-label">Dealer</label>
                                                                <select name="dealer" class="form-control input-sm dealer" id="dealer">

                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <label for="alt_dealer" class="f-label">Alt-Dealer</label>
                                                                <input type="text" name="alt_dealer" class="form-control input-sm" id="alt_dealer" placeholder="Dealer Name" data-toggle="tooltip" data-placement="top" title="Fill this up if the dealer details is not in the system.">
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <label for="supplier_contact" class="f-label">Dealer Contact</label>
                                                                <input type="text" name="supplier_contact" class="form-control input-sm" id="supplier_contact">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-4">
                                                                <label for="supplier_email" class="f-label">Dealer Email</label>
                                                                <div class="input-group email_group">
                                                                    <input type="text" name="supplier_email" class="form-control input-sm" id="supplier_email">
                                                                    <span class="input-group-addon email_popup">@</span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="supplier_mobile" class="f-label">Mobile</label>
                                                                <input type="text" name="supplier_mobile" class="form-control input-sm " id="supplier_mobile">

                                                                </select>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="supplier_landline" class="f-label">Landline</label>
                                                            <input type="text" name="supplier_landline" class="form-control input-sm " id="supplier_landline">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-12">
                                                            <label for="dealer_street_address" class="f-label">Street Address</label>
                                                            <input type="text" name="dealer_street_address" class="form-control input-sm dealer_street_address google_address" style="width: 100%" id="dealer_street_address">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-4">
                                                            <label for="dealer_suburb" class="f-label">Suburb</label>
                                                            <input type="text" name="dealer_suburb" class="form-control input-sm dealer_suburb google_suburb" id="dealer_suburb">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="dealer_postcode" class="f-label">Post Code</label>
                                                            <input type="text" name="dealer_postcode" class="form-control input-sm dealer_postcode google_postcode">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="delivery_date" class="f-label">Delivery Date</label>
                                                            <input type="text" name="delivery_date" class="form-control input-sm" id="date_delivered">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="employer_clause">
                                            <div class="panel panel-default ">
                                                <div class="panel-heading ">
                                                    <label class="panel-title-fapplication">Employer Details</label>
                                                </div>
                                                <div class="panel-body" style="background: #d2ffbf">
                                                    <div class="initial_employer_panel">
                                                        <input type="hidden" name="employer_id[0][0]" class="form-control employer_id">
                                                        <div class="row">
                                                            <div class="form-group col-md-4">
                                                                <label for="employer_name" class="f-label">Company Name</label>
                                                                <input type="text" name="employer_name[0][0]" class="form-control input-sm employer_name">
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="employement_status" class="f-label">Employment Status</label>
                                                                <select name="employment_status[0][0]" class="form-control input-sm employment_status">
                                                                    <option value="full_time">Full Time</option>
                                                                    <option value="contract">Contract</option>
                                                                    <option value="part_time">Part Time</option>
                                                                    <option value="perm_full_contract">Permanent Full time Contract</option>
                                                                    <option value="perm_part_contract">Permanent Part time Contract</option>
                                                                    <option value="unemployed">Unemployed</option>
                                                                    <option value="casual">Casual</option>
                                                                    <option value="seasonal">Seasonal</option>
                                                                    <option value="probation">On Probation</option>
                                                                    <option value="other">Other</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="occ_position" class="f-label">Occupation/Position</label>
                                                                <input type="text" name="occ_position[0][0]" class="form-control input-sm occ_position">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-3">
                                                                <label for="emp_industry" class="f-label">Industry</label>
                                                                <input type="text" name="emp_industry[0][0]" class="form-control input-sm emp_industry">
                                                            </div>
                                                            <div class="form-group col-md-2">
                                                                <label class="f-label">Time</label>
                                                                <select name="time_employer_years[0][0]" class="form-control input-sm time_employer_years time_add_employer">
                                                                    <?php
                                                                    for ($i=0; $i < 100; $i++) 
                                                                    { 
                                                                        echo "<option value='{$i}'>{$i}</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-2">
                                                                <label class="f-label">-</label>
                                                                <select name="time_employer_month[0][0]" class="form-control input-sm time_employer_month time_add_employer">
                                                                    <?php
                                                                    for ($i=0; $i < 13; $i++) 
                                                                    { 
                                                                        echo "<option value='{$i}'>{$i}</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-2">
                                                                <label class="f-label">-</label>
                                                                <span class="btn btn-primary add_employer" style="height: 30px; width: 100%;">Add</span>
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <label for="net_income" class="f-label">Net Income ($)</label>
                                                                <input type="text" name="net_income[0][0]" class="form-control input-sm net_income income_calc" onkeypress="return isNumberKey(event)">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <label for="emp_address" class="f-label">Street Address</label>
                                                                <input type="text" name="emp_address[0][0]" class="form-control input-sm emp_address google_address" style="width: 100%;">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-4">
                                                                <label for="emp_suburb" class="f-label">Suburb</label>
                                                                <input type="text" name="emp_suburb[0][0]" class="form-control input-sm emp_suburb google_suburb">
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="emp_post" class="f-label">Post Code</label>
                                                                <input type="text" name="emp_post[0][0]" class="form-control input-sm emp_post google_postcode">
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="emp_state" class="f-label">State</label>
                                                                <input type="text" name="emp_state[0][0]" class="form-control input-sm emp_state google_state">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-4">
                                                                <label for="contact_person" class="f-label">Contact Person</label>
                                                                <input type="text" name="contact_person[0][0]" class="form-control input-sm contact_person">
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="contact_number" class="f-label">Contact Number</label>
                                                                <input type="text" name="contact_number[0][0]" class="form-control input-sm contact_number">
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="emp_abn" class="f-label">Employer ABN</label>
                                                                <input type="text" name="emp_abn[0][0]" class="form-control input-sm emp_abn">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="prev_emp_panel_parent">
                                                        <div class="row prev_employer_panel" style="margin-right: -9px; margin-left: -9px; margin-top: 5px;" hidden>
                                                            <div class="panel panel-default ">
                                                                <div class="panel-heading" style="padding: 10px; ">
                                                                    <label style="font-weight: bold;" class="panel-title-fapplication">Previous Employer 1</label>
                                                                    <button type="button" class="btn btn-danger btn-xs pull-right remove" data-flag="employer">Remove</button>
                                                                </div>
                                                                <input type="hidden" name="employer_id[0][1]" class="form-control employer_id">
                                                                <div class="panel-body" style="background-color: #7fffff">
                                                                    <div class="row">
                                                                        <div class="form-group col-md-3">
                                                                            <label for="employer_name" class="f-label">Company Name</label>
                                                                            <input type="text" name="employer_name[0][1]" class="form-control input-sm employer_name">
                                                                        </div>
                                                                        <div class="form-group col-md-3">
                                                                            <label for="occ_position" class="f-label">Occupation/Position</label>
                                                                            <input type="text" name="occ_position[0][1]" class="form-control input-sm occ_position">
                                                                        </div>
                                                                        <div class="form-group col-md-2">
                                                                            <label class="f-label">Time</label>
                                                                            <select name="time_employer_years[0][1]" class="form-control input-sm time_employer_years time_add_employer">
                                                                                <?php
                                                                                for ($i=0; $i < 100; $i++) 
                                                                                { 
                                                                                    echo "<option value='{$i}'>{$i}</option>";
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-2">
                                                                            <label class="f-label">-</label>
                                                                            <select name="time_employer_month[0][1]" class="form-control input-sm time_employer_month time_add_employer">
                                                                                <?php
                                                                                for ($i=0; $i < 13; $i++) 
                                                                                { 
                                                                                    echo "<option value='{$i}'>{$i}</option>";
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-2">
                                                                            <label class="f-label">-</label>
                                                                            <span class="btn btn-primary add_employer" style="height: 30px; width: 100%;" data-toggle="tooltip" data-placement="top" title="Add previous employer">Add</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="form-group col-md-3">
                                                                            <label for="contact_number" class="f-label">Contact Number</label>
                                                                            <input type="text" name="contact_number[0][1]" class="form-control input-sm contact_number">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row other_income_clause employer_hidden_panels" style="margin-right: -9px; margin-left: -9px; margin-top: 5px;">
                                                        <div class="panel panel-default false-panel">
                                                            <div class="panel-heading" style="padding: 10px; ">
                                                                <label class="panel-title-3rd-dim new" hidden>Other Income 1</label>
                                                                <label class="panel-title-3rd-dim default">Add Other Income?</label>
                                                                <button type="button" class="btn btn-danger btn-xs pull-right remove_other_income" data-flag="other_income_clause" disabled="">Remove</button>
                                                                <button type="button" class="btn btn-primary btn-xs pull-right add_other_income" data-flag="other_income_clause">Add</button>
                                                            </div>
                                                            <input type="hidden" name="other_income_id[0][0][0]" class="form-control other_income_id">
                                                            <div class="panel-body" style="background-color: #7fffff" hidden>
                                                                <div class="row">
                                                                    <div class="form-group col-md-4">
                                                                        <label for="other_income_name" class="f-label">Other Income</label>
                                                                        <select name="other_income_name[0][0][0]" class="form-control input-sm other_income_name">
                                                                            <option value=""></option>
                                                                            <option value="Concurrent Employer">Concurrent Employer</option>
                                                                            <option value="Overtime">Overtime</option>
                                                                            <option value="Commission">Commission</option>
                                                                            <option value="Interest">Interest</option>
                                                                            <option value="Dividends">Dividends</option>
                                                                            <option value="Pension">Pension</option>
                                                                            <option value="Pension">Welfare</option>
                                                                            <option value="Partner Income">Partner's Income</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-md-4">
                                                                        <label for="other_income_details" class="f-label">Details</label>
                                                                        <input type="text" name="other_income_details[0][0][0]" class="form-control input-sm other_income_details">
                                                                    </div>
                                                                    <div class="form-group col-md-4">
                                                                        <label for="other_income_amount" class="f-label">Amount ($)</label>
                                                                        <input type="text" name="other_income_amount[0][0][0]" class="form-control input-sm other_income_amount income_calc" onkeypress="return isNumberKey(event)">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="business_details">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <label class="panel-title-fapplication">BUSINESS DETAILS</label>
                                                </div>
                                                <div class="panel-body" style="background: #d2ffbf">

                                                    <div class="row">
                                                        <div class="form-group col-md-4">
                                                            <label for="trading_name" class="f-label">Trading Name</label>
                                                            <input type="text" name="trading_name" class="form-control input-sm" id="trading_name">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="abr_name" class="f-label">Entity Name</label>
                                                            <input type="text" name="abr_name" id="abr_name" class="form-control input-sm">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="industry" class="f-label">Industry</label>
                                                            <input type="text" name="industry" id="industry" class="form-control input-sm">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-4">
                                                            <label for="supplier_email" class="f-label">ABN</label>
                                                            <div class="input-group email_group">
                                                                <input type="text" name="abn" id="abn" class="form-control input-sm">
                                                                <span class="input-group-addon abn_popup" data-toggle="tooltip" data-placement="top" title="Search ABN"><i class="fa fa-search"></i></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="abn_date" class="f-label">ABN active since</label>
                                                            <input type="text" name="abn_date" id="abn_date" class="form-control input-sm abn_date">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="gst_registered" class="f-label">GST Registered</label>
                                                            <input type="text" name="gst_registered" id="gst_registered" class="form-control input-sm">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-12">
                                                            <label class="f-label">Street Address</label>
                                                            <input type="text" name="trade_address" id="trade_address" class="form-control input-sm google_address" style="width: 100%">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-4">
                                                            <label for="trade_suburb" class="f-label">Suburb</label>
                                                            <input type="text" name="trade_suburb" id="trade_suburb" class="form-control input-sm bus_google_suburb">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="trade_post_code" class="f-label">Postcode</label>
                                                            <input type="text" name="trade_post_code" id="trade_post_code" class="form-control input-sm bus_google_postcode">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label class="f-label">Telephone</label>
                                                            <input class="form-control input-sm " id="bank_addr_titled" name="bank_addr_titled" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-4">
                                                            <label for="other_income" class="f-label">Gross Annual Turnover</label>
                                                            <input type="text" name="other_income" class="form-control input-sm" id="other_income" onkeypress="return isNumberKey(event)">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="net_profit" class="f-label">Net Annual Income</label>
                                                            <input type="text" name="net_profit" class="form-control input-sm" id="net_profit" onkeypress="return isNumberKey(event)">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="banking_institution" class="f-label">Banking Institution</label>
                                                            <input type="text" name="banking_institution" id="banking_institution" class="form-control input-sm">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-4">
                                                            <label for="accountant" class="f-label">Accountant</label>
                                                            <input type="text" name="accountant" id="accountant" class="form-control input-sm">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="accountant_contact" class="f-label">Contact</label>
                                                            <input type="text" name="accountant_contact" id="accountant_contact" class="form-control input-sm">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="accountant_number" class="f-label">Number</label>
                                                            <input type="text" name="accountant_number" id="accountant_number" class="form-control input-sm ">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-12">
                                                            <label for="accountant_address" class="f-label">Address</label>
                                                            <input type="text" name="accountant_address" id="accountant_address" class="form-control input-sm google_address accountant_address" style="width: 100%">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-4">
                                                            <label for="accountant_suburb" class="f-label">Suburb</label>
                                                            <input type="text" name="accountant_suburb" id="accountant_suburb" class="form-control input-sm acct_google_suburb">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="accountant_post_code" class="f-label">Post Code</label>
                                                            <input type="text" name="accountant_post_code" id="accountant_post_code" class="form-control input-sm acct_google_postcode">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="accountant_number" class="f-label">Email</label>
                                                            <input type="text" name="accountant_email" id="accountant_email" class="form-control input-sm">
                                                        </div>
                                                    </div>
                                                    <div class="beneficiaries_section" style="margin-top: 10px;">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <label class="panel-title-fapplication">TRUST DETAILS</label>
                                                            </div>
                                                            <input type="hidden" name="beneficiary_id[0]" class="form-control beneficiary_id">
                                                            <div class="panel-body" style="background: #7fffff">
                                                                <div class="row">
                                                                    <div class="form-group col-md-4">
                                                                        <label for="trust_name" class="f-label">Trust Name</label>
                                                                        <input type="text" name="trust_name" class="form-control input-sm trust_name" id="trust_name">
                                                                    </div>
                                                                    <div class="form-group col-md-4">
                                                                        <label for="trust_type" class="f-label">Trust Type</label>
                                                                        <select class="form-control input-sm" name="trust_type" id="trust_type">
                                                                            <option value="Constructive Trust">Constructive Trust</option>
                                                                            <option value="Family Discretionary Trust">Family Discretionary Trust</option>
                                                                            <option value="Other">Other</option>
                                                                            <option value="Resulting Trust">Resulting Trust</option>
                                                                            <option value="Service Trust">Serice Trust</option>
                                                                            <option value="Unit Trust">Unit Trust</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-md-4">
                                                                        <label for="acn" class="f-label">ACN</label>
                                                                        <input type="text" name="acn" class="form-control input-sm acn" id="acn">
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group col-md-5">
                                                                        <label for="settlor" class="f-label">Settlor</label>
                                                                        <input type="text" name="settlor[0][0]" class="form-control input-sm settlor">
                                                                    </div>
                                                                    <div class="form-group col-md-1">
                                                                        <label>-</label>
                                                                        <button type="button" class="btn btn-primary btn-xs pull-right " style="width: 100%">Add</button>
                                                                    </div>
                                                                    <div class="form-group col-md-5">
                                                                        <label for="appointer" class="f-label">Appointer</label>
                                                                        <input type="text" name="appointer[0][0]" class="form-control input-sm appointer">
                                                                    </div>
                                                                    <div class="form-group col-md-1">
                                                                        <label>-</label>
                                                                        <button type="button" class="btn btn-primary btn-xs pull-right " style="width: 100%">Add</button>
                                                                    </div>
                                                                </div>
                                                                <div class="new_beneficiary_parent">
                                                                    <div class="beneficiary_panel panel">
                                                                        <input type="hidden" name="beneficiary_id[0]" class="form-control beneficiary_id">
                                                                        <div class="row">
                                                                            <div class="form-group col-md-5">
                                                                                <label for="b_first_name" class="f-label">Additional Beneficiary/Entity</label>
                                                                                <input type="text" name="b_first_name[0]" class="form-control input-sm b_first_name">
                                                                            </div>
                                                                            <div class="form-group col-md-4">
                                                                                <label for="b_type" class="f-label">Type</label>
                                                                                <select class="form-control input-sm b_type" name="b_type[0]">
                                                                                    <option value="BE">Beneficiary</option>
                                                                                    <option value="BO">Beneficial Owner</option>
                                                                                    <option value="DI">Directory</option>
                                                                                    <option value="IB">Intermediate Benficial Owner</option>
                                                                                    <option value="SG">Signatory</option>
                                                                                    <option value="SM">Senior Manging Official</option>
                                                                                    <option value="TR">Trustee</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group col-md-3">
                                                                                <label for="b_acn" class="f-label">ACN</label>
                                                                                <input type="text" name="b_acn[0]" class="form-control input-sm b_acn">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="form-group col-md-12">
                                                                                <label for="b_address" class="f-label">Street Address</label>
                                                                                <input type="text" name="b_address[0]" class="form-control input-sm b_address google_address" style="width: 100%">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="form-group col-md-4">
                                                                                <label for="b_suburb" class="f-label">Suburb</label>
                                                                                <input type="text" name="b_suburb[0]" class="form-control input-sm b_suburb google_suburb">
                                                                            </div>
                                                                            <div class="form-group col-md-4">
                                                                                <label for="b_postcode" class="f-label">Postcode</label>
                                                                                <input type="text" name="b_postcode[0]" class="form-control input-sm b_postcode google_postcode">
                                                                            </div>
                                                                            <div class="form-group col-md-2">
                                                                                <label>-</label>
                                                                                <button type="button" class="btn btn-primary btn-xs btn-full add_beneficiary">Add</button>
                                                                            </div>
                                                                            <div class="form-group col-md-2">
                                                                                <label>-</label>
                                                                                <button type="button" class="btn btn-danger btn-xs btn-full remove">Remove</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cred_reference_clause">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <label class="panel-title-fapplication new" hidden>Reference 1</label>
                                                    <label class="panel-title-fapplication default">Add a Reference?</label>
                                                    <button type="button" class="btn btn-danger btn-xs pull-right remove" data-flag="reference_clause" disabled>Remove</button>
                                                    <button type="button" class="btn btn-primary btn-xs pull-right add" data-flag="reference_clause">Add</button>
                                                </div>
                                                <input type="hidden" name="credit_reference_id[0][0]" class="form-control credit_reference_id">
                                                <div class="panel-body" hidden style="background: #d2ffbf">
                                                    <div class="row">
                                                        <div class="form-group col-md-4">
                                                            <label for="r_first_name" class="f-label">First Name</label>
                                                            <input type="text" name="r_first_name[0][0]" class="form-control input-sm r_first_name">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="r_last_name" class="f-label">Last Name</label>
                                                            <input type="text" name="r_last_name[0][0]" class="form-control input-sm r_last_name">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="r_business_name" class="f-label">Business Name</label>
                                                            <input type="text" name="r_business_name[0][0]" class="form-control input-sm r_business_name">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-12">
                                                            <label for="r_address" class="f-label">Street Address</label>
                                                            <input type="text" name="r_address[0][0]" class="form-control input-sm r_address google_address" style="width: 100%">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-4">
                                                            <label for="r_suburb" class="f-label">Suburb</label>
                                                            <input type="text" name="r_suburb[0][0]" class="form-control input-sm r_suburb google_suburb">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="r_postcode" class="f-label">Postcode</label>
                                                            <input type="text" name="r_postcode[0][0]" class="form-control input-sm r_postcode google_postcode">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="r_telephone" class="f-label">Telephone</label>
                                                            <input type="text" name="r_telephone[0][0]" class="form-control input-sm r_telephone">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="assets">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <label class="panel-title-fapplication ">Assets</label>
                                                </div>
                                                <div class="panel-body" style="background: #d2ffbf">
                                                    <div class="row">
                                                        <div class="form-group col-md-4">
                                                            <label for="tot_prop_value" class="f-label">Total Property Value ($)</label>
                                                            <input type="text" name="tot_prop_value[0]" class="form-control input-sm tot_prop_value comp_asset" onkeypress="return isNumberKey(event)" s>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="cash_savings" class="f-label">Cash Savings ($)</label>
                                                            <input type="text" name="cash_savings[0]" class="form-control input-sm cash_savings comp_asset" onkeypress="return isNumberKey(event)">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="personal_effects" class="f-label">Personal Effects</label>
                                                            <input type="text" name="personal_effects[0]" class="form-control input-sm personal_effects comp_asset" onkeypress="return isNumberKey(event)">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-4">
                                                            <label for="superannuation" class="f-label">Superannuation</label>
                                                            <input type="text" name="superannuation[0]" class="form-control input-sm superannuation comp_asset" onkeypress="return isNumberKey(event)">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="shares_investments" class="f-label">Shares and Investments
                                                                <input type="text" name="shares_investments[0]" class="form-control input-sm shares_investments" onkeypress="return isNumberKey(event)">
                                                                </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="asset_vehicles" class="f-label">Vehicles</label>
                                                                <input type="text" name="asset_vehicles[0]" class="form-control input-sm asset_vehicles comp_asset" onkeypress="return isNumberKey(event)">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-4">
                                                                <label for="total_assets" class="f-label">Total</label>
                                                                <input type="text" name="total_assets[0]" class="form-control input-sm total_assets" onkeypress="return isNumberKey(event)">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="borrowers_statement">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <label class="panel-title-fapplication ">Applicant Declaration</label>
                                                    </div>
                                                    <div class="panel-body" style="background: #d2ffbf">
                                                        <div class="row row-input" hidden>
                                                            <div class="col-md-10 statement_label">
                                                                <p></p>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <select name="statement_1[0]" class="form-control input-sm statement_1">
                                                                    <option value="yes">Yes</option>
                                                                    <option value="no">No</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row row-input" hidden>
                                                            <div class="col-md-10 statement_label">
                                                                <p></p>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <select name="statement_2[0]" class="form-control input-sm statement_2">
                                                                    <option value="yes">Yes</option>
                                                                    <option value="no">No</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="toogle" data-plugin-toggle="">
                            <section class="toggle" id="deal_structure">
                                <label>DEAL STRUCTURE</label>
                                <div class="toggle-content" style="padding: 10px;">
                                    <div class="row row-input">
                                        <div class="col-md-2">

                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="purchase_price" class="f-label">Purchase Price</label>

                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" name="purchase_price" class="form-control input-sm" id="purchase_price" onkeypress="return isNumberKey(event)" value="0.00">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-2">

                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="book_value" class="f-label">Book Value</label>

                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" name="book_value" class="form-control input-sm" id="book_value" onkeypress="return isNumberKey(event)" value="0.00">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-2">

                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="deposit" class="f-label">Deposit</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="input-group">
                                                        <input type="text" name="deposit" class="form-control input-sm" id="deposit" value="0.00">
                                                        <span class="input-group-addon">
                                                            <input type="checkbox" name="deposit_check" id="deposit_check" value="1" data-toggle="tooltip" data-placement="top" title="By ticking this box, the deposit refunded back to the client and not taken into the account.">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-2">

                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="trade" class="f-label">Trade Value</label>

                                                </div>
                                                <div class="col-md-7">
                                                    <!-- <input type="text" name="trade" class="form-control input-sm" id="trade" onkeypress="return isNumberKey(event)" value="0.00"> -->
                                                    <div class="input-group">
                                                        <input type="text" name="trade" class="form-control input-sm" id="trade" onkeypress="return isNumberKey(event)" value="0.00">
                                                        <span class="input-group-addon">
                                                            <input type="checkbox" name="trade_check" id="trade_check" value="1" data-toggle="tooltip" data-placement="top" title="By ticking this box, tradein value will not be included in the tax invoice.">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-2">

                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="payout" class="f-label">Payout</label>

                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" name="payout" class="form-control input-sm" id="payout" onkeypress="return isNumberKey(event)" value="0.00">
                                                </div>
                                            </div>

                                        </div>

                                        <!-- <div class="col-md-2">

                                            <div class="row">
                                            <div class="col-md-5">
                                            <label for="amt_to_finance" class="f-label">Amt to Finance</label>

                                            </div>
                                            <div class="col-md-7">	
                                            <input type="text" name="amt_to_finance" class="form-control input-sm" id="amt_to_finance" onkeypress="return isNumberKey(event)" value="0.00">
                                            </div>
                                            </div>

                                            </div> -->

                                        <div class="col-md-2">

                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="term" class="f-label">Term</label>

                                                </div>
                                                <div class="col-md-7">
                                                    <select class="form-control input-sm" id="term" name="term">
                                                        <option value="12">12</option>
                                                        <option value="24">24</option>
                                                        <option value="36">36</option>
                                                        <option value="48">48</option>
                                                        <option value="60">60</option>
                                                        <option value="72">72</option>
                                                        <option value="84">84</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row row-input">
                                        <div class="col-md-2">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label class="f-label">Balloon $</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" name="balloon_amt" id="balloon_amt" class="form-control input-sm" placeholder="$" onkeypress="return isNumberKey(event)" value="0.00">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label class="f-label">Balloon %</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" name="balloon_percentage" id="balloon_percentage" class="form-control input-sm" placeholder="%" onkeypress="return isNumberKey(event)" value="0.00">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="lender" class="f-label">Lender</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <select name="lender" id="lender" class="form-control input-sm">
                                                        <option value="ANZ">ANZ</option>
                                                        <option value="St. George">St. George</option>
                                                        <option value="Macquarie">Macquarie</option>
                                                        <option value="Pepper">Pepper</option>
                                                        <option value="PCCU">PCCU</option>
                                                        <option value="Liberty">Liberty</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="est_fee" class="f-label">Est Fee ($)</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" name="est_fee" id="est_fee" class="form-control input-sm" onkeypress="return isNumberKey(event)">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="origination_fee" class="f-label">Orig Fee</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" name="origination_fee" id="origination_fee" class="form-control input-sm" onkeypress="return isNumberKey(event)">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="gap" class="f-label">GAP</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" name="gap" id="gap" class="form-control input-sm" onkeypress="return isNumberKey(event)">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row row-input">

                                        <div class="col-md-2">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="lti" class="f-label">LTI</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" name="lti" id="lti" class="form-control input-sm" onkeypress="return isNumberKey(event)">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="comprehensive" class="f-label">Comp Ins.</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" name="comprehensive" id="comprehensive" class="form-control input-sm">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="rate" class="f-label">Base Rate</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" name="rate" id="rate" class="form-control input-sm" placeholder="%" onkeypress="return isNumberKey(event)">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="cust_rate" class="f-label">Cust Rate</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" name="cust_rate" id="cust_rate" class="form-control input-sm" placeholder="%" onkeypress="return isNumberKey(event)">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="frequency" class="f-label">Frequency</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <select name="frequency" id="frequency" class="form-control input-sm">
                                                        <option value="weekly">Weekly</option>
                                                        <option value="fortnightly">Fortnightly</option>
                                                        <option value="monthly">Monthly</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="fc_inc_gst" class="f-label">Arrears/Ad</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <select class="form-control input-sm" id="arrears" name="arrears">
                                                        <option value="Arrears" data-type="0" selected="selected">Arrears</option>
                                                        <option value="Advance" data-type="1">Advance</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row row-input">

                                        <div class="col-md-2">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="total_outgoings" class="f-label">Outgoings</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" name="total_outgoings" id="total_outgoings" class="form-control input-sm" onkeypress="return isNumberKey(event)">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="total_income" class="f-label">Income</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" name="total_income" id="total_income" class="form-control input-sm" onkeypress="return isNumberKey(event)">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="surp_def_pos" class="f-label">Surp/Def</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" name="surp_def_pos" id="surp_def_pos" class="form-control input-sm" onkeypress="return isNumberKey(event)">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="naf" class="f-label">NAF</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" name="naf" id="naf" class="form-control input-sm" onkeypress="return isNumberKey(event)">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="commision" class="f-label">Commision</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" name="commision" id="commision" class="form-control input-sm" onkeypress="return isNumberKey(event)">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="payments" class="f-label">Payments($)</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" name="payments" id="payments" class="form-control input-sm" onkeypress="return isNumberKey(event)">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="toogle" data-plugin-toggle="">
                            <section class="toggle">
                                <label>ACTIONS HISTORY</label>
                                <div class="toggle-content">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
                                            <thead>
                                                <tr>
                                                    <td width="80%"><b>Action</b></td>
                                                    <td><b>User</b></td>
                                                    <td><b>Timestamp</b></td>
                                                </tr>
                                            </thead>
                                            <tbody id="fapplication_actions_history"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <div id="fapplication_comments"></div>

                        <div class="col-md-12 text-left" id="fapplication_email_actions"></div>
                        <div class="col-md-12 text-left">

                            <input type="hidden" id="fapplication_id" name="fapplication_id" value="5" />
                            <input type="hidden" id="lead_id_fq" name="lead_id_fq" value="" />
                            <input type="hidden" id="fapplication_details" name="fapplication_details" />

                        </div>
                    </form>
                </div>
            </div>
        </div>
        <footer class="panel-footer bg-black">
            <div class="row">
                <div class="col-md-12 text-right">
                    <div id="fapplication_actions"></div>
                </div>
            </div>
        </footer>
    </div>
</div>

<div id="start_tender_modal" class="modal fade">
    <!-- Start Tender Modal -->
    <style>
        #start_tender_modal label {
            color: #FFFFFF;
        }
    </style>
    <div class="modal-dialog" style="width: 95%;">
        <section class="panel">
            <form method="post" action="" id="start_tender_form" name="start_tender_form">
                <input type="hidden" id="id_leads" name="id_lead">
                <input type="hidden" id="dealer_ids_inp" name="dealer_ids" value="0">
                <input type="hidden" id="email_template_id" name="email_template_id">
                <div class="panel-body" style="background: #000;">
                    <div class="modal-wrapper">
                        <div class="modal-text">
                            <div class="row" style="margin-top: 20px;">
                                <!-- Tender Details -->
                                <div class="col-md-4">
                                    <div class="container_bordered_round">
                                        <div class="form-group">
                                            <label><font color="red">*</font> Registration Type:</label>
                                            <select class="form-control input-md" id="registration_type" name="registration_type" type="text" data-old="">
                                                <option value=""></option>
                                                <option value="Business">Business</option>
                                                <option value="Private">Private</option>
                                                <option value="Pensioner">Pensioner</option>
                                                <option value="Exempt">Exempt</option>
                                                <option value="TPI/Gold Card">TPI/Gold Card</option>
                                            </select>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="container_bordered_round">
                                        <div class="form-group">
                                            <label><font color="red">*</font> Postcode:</label>
                                            <input class="form-control input-sm" id="postcode_ds2" type="text" value="" name="postcode_ds2" placeholder="Postcode" data-old="">
                                        </div>
                                    </div>
                                    <br />
                                    <div class="container_bordered_round">
                                        <div class="form-group">
                                            <label><font color="red">*</font> Make:</label>
                                            <select class="form-control input-sm makeclass" id="make" name="make" data-old="">
                                                <option value="0"></option>
                                                <?php 
                                                foreach ($makes as $make)
                                                {
                                                ?>
                                                <option value="<?php echo $make->id_make; ?>"><?php echo $make->name; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label><font color="red">*</font> Model:</label>
                                            <select class="form-control input-sm modelclass" id="family" name="family" data-old="" disabled>
                                                <option value="">
                                                    <span class="loader"></span>
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label><font color="red">*</font> Colour:</label>
                                            <input value="" class="form-control input-sm" data-old="" id="colour" name="colour" type="text"><br />
                                        </div>
                                    </div>
                                    <br />
                                </div>
                                <div class="col-md-8">
                                    <div class="container_bordered_round">
                                        <label>Options:</label><br />
                                        <div class="row">
                                            <div id="options"></div>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="">
                                        <label><font color="red">*</font>Redbook Data:</label><br />
                                        <select class="form-control input-sm rb_data_option" id="rb_data" name="rb_data" data-old="">
                                            <option value="">No Data Found</option>
                                        </select>
                                    </div>

                                    <br />
                                    <div class="container_bordered_round">
                                        <label>Note : </label><br />
                                        <textarea class="form-control" name="email_paragraph" id="email_paragraph" rows="5" placeholder="Email Paragraph">11 Lovely to chat and make your acquaintance over the phone this afternoon. As discussed once you have confirmed your new vehicle details below your request for quote will be prepared for tender. I will advise when you can expect the next tender to happen in advance and when it starts multiple dealer fleet departments across the country will be invited to quote in a bid to win your business. Because we are a fleet buyer dealers are permitted to include your new vehicle with others being ordered that day so fleet assistance can apply. I will keep you up to date with the results as they come in and all quotes are drive-away with 12 months registration and include delivery to your front door with a full tank of fuel. </textarea>
                                        <?php /* its value coming from function load_build_dates(). */?>
                                        <br />
                                        <div class="col-md-12">
                                            <button type="button" id="open_email_paragraph_model" class="btn btn-primary pull-right">Edit Email Template</button>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="container_bordered_round">
                                        <label>Accessories:</label><br />
                                        <div class="row after-add-more">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <input type="text" name="accessory_name[]" class="form-control" placeholder="Description" value="N/A">
                                                </div>
                                            </div>
                                            <div class="col-lg-1">
                                                <button class="btn btn-success add-more" type="button"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>

                                        <div id="accessory_container"></div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <br />
                                                <div class="pull-right">
                                                    <button type="button" id="form_save_submit" class="btn btn-primary ">
                                                        Save
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Copy Elements -->
                                        <div class="copy-fields hide">
                                            <div class="row control-group">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <input type="text" name="accessory_name[]" class="form-control" placeholder="Description">
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <button class="btn btn-danger removeAs" type="button"><i class="fa fa-minus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Copy Elements -->

                                        <!-- Copy Elements for Dynamic jQuery -->
                                        <div class="copy-fields1 hide">
                                            <div class="row control-group">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <input type="text" name="accessory_name[]" class="form-control" placeholder="Description" value="@@@">
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <button class="btn btn-danger removeAs" type="button"><i class="fa fa-minus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Copy Elements -->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="quote_file">Preview Template :</label>
                                        <textarea name="start_tender_email_template_content" id="start_tender_email_template_content" class="start_tender_email_template_content" rows="10" cols="80" style="display: none;"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <!-- Actions -->
                    <input type="hidden" name="form_change" id="form_change" value="0">
                    <input type="hidden" name="form_save" id="form_save" value="1">
                    <button type="submit" class="btn btn-primary">
                        Send
                    </button>
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </form>
        </section>
    </div>
</div>

<div id="edit_tender_modal" class="modal fade">
    <!-- Edit Tender Modal -->
    <div class="modal-dialog" style="width: 95%;">
        <section class="panel">
            <form method="post" action="" id="edit_tender_form" name="edit_tender_form">
                <input type="hidden" id="id_lead" name="id_lead">
                <input type="hidden" id="id_quote_request" name="id_quote_request">
                <div class="panel-body" style="background: #000;">
                    <div class="modal-wrapper">
                        <div class="modal-text">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h4 id="label_name" style="line-height: 1px;"></h4>
                                    <p id="label_email" style="color: #cccccc; font-size: 0.9em;"></p>
                                    <hr class="solid mt-sm mb-lg">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div style="padding: 20px;">
                                        <div class="form-group">
                                            <label><font color="red">*</font> Registration Type:</label>
                                            <select class="form-control input-md" id="registration_type" name="registration_type" type="text">
                                                <option value=""></option>
                                                <option value="Business">Business</option>
                                                <option value="Private">Private</option>
                                                <option value="Pensioner">Pensioner</option>
                                                <option value="Exempt">Exempt</option>
                                                <option value="TPI/Gold Card">TPI/Gold Card</option>
                                            </select>
                                        </div>
                                    </div>
                                    <br />
                                    <div style="padding: 20px;">
                                        <div class="form-group">
                                            <label><font color="red">*</font> Make:</label>
                                            <select class="form-control makeclass1" id="make" name="make" onchange="load_families('edit_tender_modal', this.options[this.selectedIndex].value, 0)" required>
                                                <option value="0"></option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label><font color="red">*</font> Model:</label>
                                            <select class="form-control modelclass1" id="family" name="family" onchange="load_build_dates('edit_tender_modal', this.options[this.selectedIndex].value, 0 )">
                                                <option value="0"></option>
                                            </select>
                                        </div>
                                        <!--<div class="form-group">
                                        <label><font color="red">*</font> Build Date:</label>
                                        <select class="form-control builddtclass1" id="build_date" name="build_date" onchange="load_vehicles('edit_tender_modal', this.options[this.selectedIndex].value, 0)">
                                        <option name="build_date" value="0"></option>
                                        </select>
                                        </div>-->
                                                                                <!--<div class="form-group">
                                        <label><font color="red">*</font> Variant:</label>
                                        <select class="form-control" id="vehicle" name="vehicle" onchange="load_options('edit_tender_modal', this.options[this.selectedIndex].value, 0)">
                                        <option name="vehicle" value="0"></option>
                                        </select>																
                                        </div>-->
                                        <div class="form-group">
                                            <label><font color="red">*</font> Colour:</label>
                                            <input value="" class="form-control input-md" id="colour" name="colour" type="text">
                                        </div>
                                    </div>
                                    <br />
                                </div>
                                <div class="col-md-8">
                                    <div style="padding: 20px;">
                                        <label>Options:</label><br />
                                        <div class="row">
                                            <div id="options"></div>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="">
                                        <label>Redbook Data:</label><br />
                                        <select class="form-control input-sm rb_data_option" id="rb_data" name="rb_data">																	<option value="">No Data Found</option>
                                        </select>
                                    </div>

                                    <br />
                                    <div style="padding: 20px;">
                                        <label>Accessories:</label><br />
                                        <div class="row after-add-more">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <input type="text" name="accessory_name[]" class="form-control" placeholder="Description" value="N/A">
                                                </div>
                                            </div>
                                            <div class="col-lg-1">
                                                <button class="btn btn-success add-more1" type="button"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>

                                        <div id="accessory_container1"></div>
                                        <!-- <div class="row">
                                            <div class="col-md-12">
                                                <br />
                                                <span class="btn btn-default btn-sm ajax_button add_accessory_button" data-container="edit_tender_modal">
                                                    Add Accessory
                                                </span>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </form>
        </section>
    </div>
</div>

<div id="add_dealers_modal" class="modal fade">
    <!-- Add Dealers Modal -->
    <div class="modal-dialog" style="width: 95%;">
        <section class="panel">
            <form method="post" enctype="multipart/form-data" action="" id="add_dealers_form" name="add_dealers_form">
                <input type="hidden" id="id_lead" name="id_lead">
                <input type="hidden" id="email_template_id" name="email_template_id">
                <input type="hidden" id="id_quote_request" name="id_quote_request">
                <input type="hidden" id="dealer_ids_inp" name="dealer_ids" value="0">
                <div class="panel-body">
                    <div class="modal-wrapper">
                        <div class="modal-text">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h4 id="label_name" style="line-height: 1px;"></h4>
                                    <p id="label_email" style="color: #cccccc; font-size: 0.9em;"></p>
                                    <hr class="solid mt-sm mb-lg">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div style="padding: 20px; border: 1px solid #ddd;">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <select class="form-control input-md" id="make_ds" type="text" onchange="load_suggested_dealers('add_dealers_modal')">
                                                    <option name="make" value=""></option>
                                                    <?php
                                                    foreach ($makes as $make)
                                                    {
                                                    ?>
                                                    <option value="<?php echo $make->name; ?>"><?php echo $make->name; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <br />
                                            </div>
                                            <div class="col-md-4">
                                                <select class="form-control input-md" id="state_ds" type="text" onchange="load_suggested_dealers('add_dealers_modal')">
                                                    <option value="">Select State</option>
                                                    <option value="ACT">Australian Capital Territory</option>
                                                    <option value="NSW">New South Wales</option>
                                                    <option value="NT">Northern Territory</option>
                                                    <option value="QLD">Queensland</option>
                                                    <option value="SA">South Australia</option>
                                                    <option value="TAS">Tasmania</option>
                                                    <option value="VIC">Victoria</option>
                                                    <option value="WA">Western Australia</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <input class="form-control input-md" id="postcode_ds" type="text" value="" placeholder="Postcode" onchange="load_suggested_dealers('add_dealers_modal')"><br />
                                            </div>
                                            <div class="col-md-12" id="suggested_dealers"></div>
                                            <div class="col-md-12">
                                                <br />
                                                <table class="table table-bordered table-striped table-condensed mb-none selected_dealers">
                                                    <thead>
                                                        <tr>
                                                            <td><b>SELECTED DEALERS</b></td>
                                                            <td></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="selected_dealers">
                                                        <tr class="norecord">
                                                            <td colspan="2">
                                                                <center>No dealer is selected!</center>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- <br />
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Email Text:</label>
                                                    <textarea class="form-control" rows="3" name="mail_text"></textarea>
                                                </div>
                                            </div> -->
                                            <br />
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="quote_file">Attach Dealer Agreement :</label>
                                                    <input type="file" id="quote_file" name="quote_file">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="quote_file">Preview Template :</label>
                                                    <textarea name="add_dealer_email_template_content" id="add_dealer_email_template_content" class="add_dealer_email_template_content" rows="10" cols="80" style="display: none;"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <!-- <button type="button" class="btn btn-info open-edit-emailtemplate edit_add_dealer_template" data-email_template_id="<?php echo DEALER_TRADE_MAIL_TEMPLATE ?>" id="add_dealers_edit_template" style="display: none;">Edit Template</button> -->
                    <button type="submit" class="btn btn-primary" id="add_dealers_submit_button">
                        Submit
                    </button>
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </form>
        </section>
    </div>
</div>

<div id="email_invite_modal" class="modal fade">
    <!-- Email Invite Modal -->
    <div class="modal-dialog" style="width: 95%;">
        <section class="panel">
            <form method="post" action="" id="email_invite_form" name="email_invite_form">
                <input type="hidden" id="id_lead" name="id_lead">
                <input type="hidden" id="id_quote_request" name="id_quote_request">
                <div class="panel-body">
                    <div class="modal-wrapper">
                        <div class="modal-text">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h4 id="label_name" style="line-height: 1px;"></h4>
                                    <p id="label_email" style="color: #cccccc; font-size: 0.9em;"></p>
                                    <hr class="solid mt-sm mb-lg">
                                </div>
                            </div>
                            <div class="row" style="margin-top: 10px;">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Email Address:</label>
                                        <input type="text" class="form-control" name="email">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <button type="submit" class="btn btn-primary">
                        Start
                    </button>
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </form>
        </section>
    </div>
</div>

<div id="send_email_modal" class="modal fade">
    <!-- Send Email Modal -->
    <div class="modal-dialog" style="width: 80%;">
        <section class="panel">
            <form method="post" id="send_email_form" name="send_email_form" action="">

                <input type="hidden" id="email" name="email">
                <div class="panel-body">
                    <div class="modal-wrapper">
                        <div class="modal-text">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h4 id="label_name" style="line-height: 1px;"></h4>
                                    <p id="label_email" style="color: #cccccc; font-size: 0.9em;"></p>
                                    <hr class="solid mt-sm mb-lg">
                                </div>
                            </div>
                            <div class="row" style="margin-top: 10px;">
                                <div class="col-md-12">
                                    <div class="container_bordered_round">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h5>Recipient:</h5>
                                                <div class="row" style="margin-top: 10px;">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <select class="form-control" id="recipient_type" name="recipient_type" type="text">
                                                                <option value=""></option>
                                                                <option value="Client">Client</option>
                                                                <option value="Dealer">Dealer</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="hidden" id="id_leads" name="id_lead" />
                                                        <div class="form-group">
                                                            <input class="form-control" id="recipient_email" name="recipient_email" type="text" placeholder="Email Address">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 10px;">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Subject:</label>
                                                    <input type="text" value="" class="form-control" id="subject" name="subject">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 10px;">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Message:</label>
                                                    <textarea class="form-control" id="message" name="message" rows="8"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 30px;">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Attachments:</label><br />
                                                    <input type="checkbox" name="purchase_order_attachment_flag" id="purchase_order_attachment_flag"> Purchase Order PDF <br />
                                                    <input type="checkbox" name="order_package_attachment_flag" id="order_package_attachment_flag"> Order Package PDF <br />
                                                    <?php 
                                                    if ($admin_type==2)
                                                    {
                                                    ?>
                                                    <input type="checkbox" name="dealer_invoice_attachment_flag" id="dealer_invoice_attachment_flag"> Dealer Invoice PDF <br />
                                                    <?php
                                                    }
                                                    else
                                                    {
                                                    ?>
                                                    <input type="hidden" name="dealer_invoice_attachment_flag" id="dealer_invoice_attachment_flag">
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 30px;">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Other Attachments:</label>
                                                    <div class="dropzone email_attachments" style="min-height: 160px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div hidden="hidden" id="hidden_images"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn btn-primary">
                        Send
                    </button>
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </form>
        </section>
    </div>
</div>

<div id="forward_pdf_modal" class="modal fade">
    <!-- Send Email Modal -->
    <div class="modal-dialog" style="width: 80%;">
        <section class="panel">
            <form method="post" id="forward_pdf_form" name="forward_pdf_form" action="">
                <input type="hidden" id="id_tradei" name="id_tradein">
                <div class="panel-body">
                    <div class="modal-wrapper">
                        <div class="modal-text">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h4 id="label_1" style="line-height: 1px;"></h4>
                                    <p id="label_2" style="color: #cccccc; font-size: 0.9em;"></p>

                                    <hr class="solid mt-sm mb-lg">
                                </div>
                            </div>
                            <div class="row comon-text" style="margin-top: 10px;">
                                <div class="col-md-12">
                                    <div class="container_bordered_round">
                                        <!--div class="row">
<div class="col-md-12">
<h5></h5>
<div class="row" style="margin-top: 10px;">
<div class="col-md-12">																
<div class="form-group">
<select class="text-line" id="" name="">
<option value=""></option>
<option value="" <?php echo ""; ?> ></option>
<option value="" <?php echo ""; ?> ></option>
</select>
</div>
</div>																		
</div>
</div>
</div-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h5>Recipient:</h5>
                                                <div class="row" style="margin-top: 10px;">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <input class="form-control" id="recipient_email" name="recipient_email" type="text" placeholder="Email Address">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 10px;">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Subject:</label>
                                                    <input type="text" value="" class="form-control" id="subject" name="subject">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 10px;">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Message:</label>
                                                    <textarea class="form-control" id="message" name="message" rows="8"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 30px;">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Attachments:</label><br />
                                                    <i class="fa fa-check"></i> Tradein Details PDF <br />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 30px;">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Other Attachments:</label>
                                                    <div class="dropzone email_attachments" style="min-height: 160px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div hidden="hidden" id="hidden_images"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn btn-primary">
                        Send
                    </button>
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </form>
        </section>
    </div>
</div>

<div id="add_payment_modal" class="modal fade">
    <!-- Add Payment Modal -->
    <div class="modal-dialog" style="width: 95%;">
        <section class="panel">
            <form method="post" action="" id="add_payment_form" name="add_payment_form">
                <input type="hidden" id="id_lead" name="id_lead">
                <div class="panel-body">
                    <div class="modal-wrapper">
                        <div class="modal-text">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h4 id="label_name" style="line-height: 1px;"></h4>
                                    <p id="label_email" style="color: #cccccc; font-size: 0.9em;"></p>
                                    <hr class="solid mt-sm mb-lg">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div style="padding: 20px; border: 1px solid #ddd;">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Payment Type:</label>
                                                    <select class="form-control" name="fk_payment_type" type="text">
                                                        <option value=""></option>
                                                        <?php
                                                        foreach ($payment_types as $payment_type)
                                                        {
                                                        ?>
                                                        <option data-sign="<?php echo $payment_type->sign; ?>" value="<?php echo $payment_type->id_payment_type; ?>">
                                                            <?php echo $payment_type->description; ?>
                                                        </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Reference Number:</label>
                                                    <input type="text" class="form-control" name="reference_number">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Payment Date:</label>
                                                    <input type="text" class="form-control datepicker" data-date-format="yyyy-mm-dd" name="payment_date" value="<?php echo date(" Y-m-d "); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-md-12">
                                    <div style="padding: 20px; border: 1px solid #ddd;">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Amount:</label>
                                                    <input type="text" class="form-control" name="amount" onkeypress="return isNumberKey(event)">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Admin Fee:</label>
                                                    <input type="text" class="form-control" name="admin_fee">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Merchant Cost:</label>
                                                    <input type="text" class="form-control" name="merchant_cost">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-md-12">
                                    <div style="padding: 20px; border: 1px solid #ddd;">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Method:</label>
                                                    <select class="form-control" name="method" type="text">
                                                        <option value=""></option>
                                                        <option value="Bendigo">Bendigo</option>
                                                        <option value="Square">Square</option>
                                                        <option value="EFT">EFT</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Credit Card:</label>
                                                    <select class="form-control" name="credit_card" type="text">
                                                        <option value=""></option>
                                                        <option value="MasterCard">MasterCard</option>
                                                        <option value="Visa">Visa</option>
                                                        <option value="Amex">Amex</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Bank Account:</label>
                                                    <select class="form-control" name="bank_account" type="text">
                                                        <option value=""></option>
                                                        <option value="Bendigo">Bendigo</option>
                                                        <option value="WestPac">Westpac</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-md-12">
                                    <div style="padding: 20px; border: 1px solid #ddd;">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Remarks:</label>
                                                    <textarea type="text" class="form-control" name="remarks"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </form>
        </section>
    </div>
</div>

<div id="add_invoice_modal" class="modal fade">
    <!-- Add Custom Invoice Modal -->
    <div class="modal-dialog" style="width: 95%;">
        <section class="panel">
            <form method="post" action="" id="add_invoice_form" name="add_invoice_form">
                <input type="hidden" id="id_lead" name="id_lead">
                <div class="panel-body">
                    <div class="modal-wrapper">
                        <div class="modal-text">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h4 id="label_name" style="line-height: 1px;"></h4>
                                    <p id="label_email" style="color: #cccccc; font-size: 0.9em;"></p>
                                    <hr class="solid mt-sm mb-lg">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Description:</label>
                                        <textarea type="text" class="form-control" name="details"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 10px;">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Remarks to the Recipient:</label>
                                        <textarea type="text" class="form-control" name="remarks"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 70px;">
                                <div class="col-md-12">
                                    <h5><b>Invoice Items</b></h5>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 15px;">
                                <div class="col-md-12">
                                    <div id="invoice_items_container">
                                        <div style="padding: 15px; border: 1px solid #ddd;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Amount:</label>
                                                        <input type="text" class="form-control" name="invoice_item_amount[]" onkeypress="return isNumberKey(event)">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top: 10px;">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Item Description:</label>
                                                        <textarea type="text" class="form-control" name="invoice_item_description[]"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <br />
                                    <span class="btn btn-default btn-sm add_invoice_item_button" style="cursor: pointer; cursor: hand;" data-container="add_invoice_form">
                                        Add Item
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </form>
        </section>
    </div>
</div>

<div id="edit_payment_modal" class="modal fade">
    <!-- Edit Payment Modal -->
    <div class="modal-dialog" style="width: 95%;">
        <section class="panel">
            <form method="post" action="" id="edit_payment_form" name="edit_payment_form">
                <input type="hidden" id="id_lead" name="id_lead">
                <input type="hidden" id="id_payment" name="id_payment" value="">
                <div class="panel-body">
                    <div class="modal-wrapper">
                        <div class="modal-text">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h4 id="label_name" style="line-height: 1px;"></h4>
                                    <p id="label_email" style="color: #cccccc; font-size: 0.9em;"></p>
                                    <hr class="solid mt-sm mb-lg">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div style="padding: 20px; border: 1px solid #ddd;">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Payment Type:</label>
                                                    <select class="form-control" id="fk_payment_type" name="fk_payment_type" type="text">
                                                        <option value=""></option>
                                                        <?php
                                                        foreach ($payment_types as $payment_type)
                                                        {
                                                        ?>
                                                        <option data-sign="<?php echo $payment_type->sign; ?>" value="<?php echo $payment_type->id_payment_type; ?>">
                                                            <?php echo $payment_type->description; ?>
                                                        </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Reference Number:</label>
                                                    <input type="text" class="form-control" id="reference_number" name="reference_number">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Payment Date:</label>
                                                    <input type="text" class="form-control datepicker" data-date-format="yyyy-mm-dd" id="payment_date" name="payment_date">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-md-12">
                                    <div style="padding: 20px; border: 1px solid #ddd;">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Amount:</label>
                                                    <input type="text" class="form-control" id="amount" name="amount" onkeypress="return isNumberKey(event)">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Admin Fee:</label>
                                                    <input type="text" class="form-control" id="admin_fee" name="admin_fee">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Merchant Cost:</label>
                                                    <input type="text" class="form-control" id="merchant_cost" name="merchant_cost">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-md-12">
                                    <div style="padding: 20px; border: 1px solid #ddd;">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Method:</label>
                                                    <select class="form-control" id="method" name="method" type="text">
                                                        <option value=""></option>
                                                        <option value="Bendigo">Bendigo</option>
                                                        <option value="Square">Square</option>
                                                        <option value="EFT">EFT</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Credit Card:</label>
                                                    <select class="form-control" id="credit_card" name="credit_card" type="text">
                                                        <option value=""></option>
                                                        <option value="MasterCard">MasterCard</option>
                                                        <option value="Visa">Visa</option>
                                                        <option value="Amex">Amex</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Bank Account:</label>
                                                    <select class="form-control" id="bank_account" name="bank_account" type="text">
                                                        <option value=""></option>
                                                        <option value="Bendigo">Bendigo</option>
                                                        <option value="WestPac">Westpac</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-md-12">
                                    <div style="padding: 20px; border: 1px solid #ddd;">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Remarks:</label>
                                                    <textarea type="text" id="remarks" class="form-control" name="remarks"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </form>
        </section>
    </div>
</div>

<div id="dealer_modal" class="modal fade">
    <div class="modal-dialog" style="width: 95%;">
        <div class="panel-body dealer-modal-main">
            <div class="modal-wrapper">
                <div class="modal-text">
                    <form method="post" action="" id="dealer_main_form" name="dealer_main_form">
                        <input type="hidden" id="dealer_id" name="dealer_id" value="" />
                        <div id="dealer_details">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- <footer class="panel-footer">
<div class="row">
<div class="col-md-12 text-right">
<div id="dealer_actions"></div>
</div>
</div>
</footer> -->
    </div>
</div>
<!-- Modal -->
<div id="email_template_paragraph_model_old" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Email Template Note</h4>
            </div>
            <div class="modal-body">
                <textarea rows="5" id="email_template_paragraph_data" class="form-control" style="min-width: 100%"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--Edit Email Template Modal-->
<div id="email_template_paragraph_model" class="modal fade">
    <div class="modal-dialog" style="width: 80%;">
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title">Send Email</h2>
            </header>
            <form id="form_email_template" action="" method="post" enctype="">
                <div class="panel-body">
                    <div class="modal-wrapper">
                        <div class="modal-text">
                            <div class="form-group">
                                <input id="email_template_id" value="<?=isset($email_template[0]->id_email_template) ? $email_template[0]->id_email_template : '' ?>" name="email_template_id" type="hidden">
                            </div>
                            <div class="form-group">
                                <textarea name="email_template_content" id="email_template_content" class="ckeditor" rows="10" cols="80">
                                    <?=isset($email_template[0]->content) ? ($email_template[0]->content) : '' ?>
                                </textarea> * Please Don't edit the "@@" quoted text, As it is coming from database and need not to be edited
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="panel-footer">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="update_email_template()">Save</button>
                        </div>
                    </div>
                </footer>
            </form>
        </section>
    </div>
</div>

<!-- -------Added By - RJ - Start---------- -->
<div id="add_quote_modal" class="modal fade">
    <!-- Add Quote Modal -->
    <div class="modal-dialog" style="width: 95%;">
        <section class="panel">
            <form method="post" action="" id="add_quote_form" name="add_quote_form" enctype="multipart/form-data">
                <input type="hidden" id="id_lead" name="id_lead" value="">
                <input type="hidden" id="id_quote_request" name="id_quote_request">
                <input type="hidden" id="id_quote" name="id_quote">
                <input type="hidden" id="process" name="process">
                <input type="hidden" id="registration_type" name="registration_type">
                <input type="hidden" id="dealer_state" name="dealer_state">
                <input type="hidden" id="client_state" name="client_state">
                <input type="hidden" id="tradein_count" name="tradein_count">
                <div class="panel-body">
                    <div class="modal-wrapper">
                        <div class="modal-text">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h4 id="label_name" style="line-height: 1px;"></h4>
                                    <p id="label_email" style="color: #cccccc; font-size: 0.9em;"></p>
                                    <hr class="solid mt-sm mb-lg">
                                </div>
                            </div>
                            <div class="row" id="quote_form_demo_container">
                                <div class="col-md-12">
                                    <div style="padding: 20px; border: 1px solid #ddd;">
                                        <div class="form-group">
                                            <label class="control-label">Is the vehicle brand new or a demonstrator?</label>
                                            <select class="form-control" id="demo" name="demo">
                                                <option value="New">New</option>
                                                <option value="Demo">Demo</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--div class="row" style="margin-top: 20px;">
<div class="col-md-12">
<div style="padding: 20px; border: 1px solid #ddd;">
<div class="row">
<div class="col-md-6">
<h5><b>Vehicle:</b></h5>
<p><span id="vehicle_label"></span></p>
</div>
<div class="col-md-6">
<h5><b>Registration Type:</b></h5>
<p><span id="registration_type_label"></span></p>
</div>																
</div>
</div>
</div>
</div-->
                            <div class="row" id="quote_form_dealer_selector_container" style="margin-top: 20px;" hidden>
                                <div class="col-md-12">
                                    <div style="padding: 20px; border: 1px solid #ddd;">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="control-label">Dealership Make:</label>
                                                <select class="form-control input-md" id="make_ds" type="text" onchange="load_suggested_dealers('add_quote_modal')">
                                                    <option name="make" value=""></option>
                                                    <?php foreach ($makes as $make) { ?>
                                                    <option name="make" value="<?php echo $make->name; ?>"><?php echo $make->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <br />
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label">State:</label>
                                                <select class="form-control input-md" id="state_ds" type="text" onchange="load_suggested_dealers('add_quote_modal')">
                                                    <option value=""></option>
                                                    <option value="ACT">Australian Capital Territory</option>
                                                    <option value="NSW">New South Wales</option>
                                                    <option value="NT">Northern Territory</option>
                                                    <option value="QLD">Queensland</option>
                                                    <option value="SA">South Australia</option>
                                                    <option value="TAS">Tasmania</option>
                                                    <option value="VIC">Victoria</option>
                                                    <option value="WA">Western Australia</option>
                                                </select>
                                            </div>
                                            <!-- <div class="col-md-4">
<label class="control-label">Postcode:</label>
<input class="form-control input-md" id="postcode_ds" type="text" value="" placeholder="Postcode" onchange="load_suggested_dealers('add_quote_modal')"><br />
</div> -->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-left" id="suggested_dealers"></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 text-left">
                                                <br />
                                                <table class="table table-bordered table-striped table-condensed mb-none">
                                                    <thead>
                                                        <tr>
                                                            <td><b>SELECTED DEALERS</b></td>
                                                            <td></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="selected_dealers">
                                                        <tr class="norecord">
                                                            <td colspan="2">
                                                                <center>No dealer is selected!</center>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="control-label">Sender:</label>
                                                <input class="form-control input-md" id="" name="sender_new" type="text" value="" placeholder="Sender" required><br />
                                                <!--<select class="form-control" id="sender_new" name="sender_new" required><option value="">--Select--</option></select><br />-->
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label">Quoted Price:</label>
                                                <input class="form-control input-md" id="" name="quoted_price" type="text" value="" placeholder="Quoted Price" required><br />
                                            </div>
                                            <div class="col-md-2">
                                                <label class="control-label">On Road:</label>
                                                <div class="form-group">
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="on_road" id="optionsRadios1" value="1" required>
                                                            Yes
                                                        </label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <label>
                                                            <input type="radio" name="on_road" id="optionsRadios2" value="0" required>
                                                            No
                                                        </label>
                                                    </div>
                                                </div>
                                                <!-- 
<input class="form-control input-md" id="" type="text" name="" value="" placeholder="" ><br /> --><br />
                                            </div>
                                            <div class="col-md-2">
                                                <label class="control-label">Car Off Road:</label>
                                                <input class="form-control input-md" id="" name="car_off_road" type="text" value="" placeholder="Car Off Road"><br />
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label">Estimated Delivery Date:</label>
                                                <input value="" class="form-control input-sm datepicker_mysql" id="delivery_date" name="delivery_date" type="text"><br />
                                            </div>
                                            <!-- <div class="col-md-4">
<div class="col-md-6">
<label class="control-label">Date:</label>
<input class="form-control input-md datepicker" name="date" data-date-format="yyyy-mm-dd" id="datepicker3" type="text" value="" placeholder="">
</div>
<div class="col-md-6">
<label class="control-label">Time:</label>
<input class="form-control input-md timepicker" name="time" id="timepicker" type="text"  value="" placeholder="" >
</div>
</div> -->
                                            <div class="col-md-4">
                                                <label class="control-label">Dealer Notes:</label>
                                                <input class="form-control input-md" id="" type="text" name="dealer_notes" value="" placeholder=""><br />
                                            </div>
                                            <div class="col-md-4">
                                                <label for="quote_file">Upload Quote:</label>
                                                <input type="file" id="quote_file" name="quote_file">
                                                <!-- <p class="help-block">Upload Quote File Here.</p> -->
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div id="quote_form_warning_container" hidden>
                                <!-- Quote Form Warning -->
                                <div class="row" style="margin-top: 20px;">
                                    <div class="col-md-12">
                                        <div class="alert alert-danger" id="quote_form_warning_message">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="quote_form_container" hidden>
                                <!-- Quote Form -->
                                <div class="row" style="margin-top: 20px;">
                                    <div class="col-md-12">
                                        <div style="padding: 20px; border: 1px solid #ddd;">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-condensed mb-none">
                                                    <tbody>
                                                        <tr>
                                                            <td width="70%">Delivery Date</td>
                                                            <td><input value="" class="form-control input-sm datepicker"  id="" name="" type="text"></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="70%">Compliance Date</td>
                                                            <td><input value="" class="form-control input-sm" id="compliance_date" name="compliance_date" type="text"></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="70%">VIN</td>
                                                            <td><input value="" class="form-control input-sm" id="vin" name="vin" type="text"></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="70%">Engine Number</td>
                                                            <td><input value="" class="form-control input-sm" id="engine" name="engine" type="text"></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="70%">Registration Plate</td>
                                                            <td><input value="" class="form-control input-sm" id="registration_plate" name="registration_plate" type="text"></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="70%">Registration Expiry</td>
                                                            <td><input value="" class="form-control input-sm" id="registration_expiry" name="registration_expiry" type="text"></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="70%">KMS</td>
                                                            <td><input value="0" class="form-control input-sm" id="kms" name="kms" type="text" onkeypress="return isNumberKey(event)"></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="70%">Dealer Note</td>
                                                            <td><textarea class="form-control input-sm" id="notes" name="notes"></textarea></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 20px;">
                                    <div class="col-md-12">
                                        <div style="padding: 20px; border: 1px solid #ddd;">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-condensed mb-none">
                                                    <tbody>
                                                        <tr>
                                                            <td width="70%">List Price</td>
                                                            <td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="retail_price" name="retail_price" type="text" onchange="calculate_quote_new('#add_quote_modal')" required></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Metallic Paint</td>
                                                            <td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="metallic_paint" name="metallic_paint" type="text" onchange="calculate_quote_new('#add_quote_modal')" required></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Discount</td>
                                                            <td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="dealer_discount" name="dealer_discount" type="text" onchange="calculate_quote_new('#add_quote_modal')" required></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Fleet Claim</td>
                                                            <td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="fleet_discount" name="fleet_discount" type="text" onchange="calculate_quote_new('#add_quote_modal')" required></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>SUBTOTAL</b></td>
                                                            <td><input value="0" class="form-control input-sm subtotal_1" id="subtotal_1" name="subtotal_1" type="text" readonly></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <br />
                                            <div id="options_content"></div>
                                            <div id="accessories_content"></div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-condensed mb-none">
                                                    <tbody>
                                                        <tr>
                                                            <td width="70%">Delivery Charge</td>
                                                            <td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="predelivery" name="predelivery" type="text" onchange="calculate_quote_new('#add_quote_modal')" required></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>SUBTOTAL</b></td>
                                                            <td><input value="0" class="form-control input-sm subtotal_2" id="subtotal_2" name="subtotal_2" type="text" readonly></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <br />
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-condensed mb-none">
                                                    <tbody>
                                                        <tr>
                                                            <td width="70%">GST</td>
                                                            <td><input value="0" class="form-control input-sm" id="gst" name="gst" type="text" readonly></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>SUBTOTAL</b></td>
                                                            <td><input value="0" class="form-control input-sm" id="subtotal_3" name="subtotal_3" type="text" readonly></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <br />
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-condensed mb-none">
                                                    <tbody>
                                                        <tr>
                                                            <td width="70%">Luxury Tax</td>
                                                            <td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="luxury_tax" name="luxury_tax" type="text" onchange="calculate_quote_new('#add_quote_modal')" required></td>
                                                        </tr>
                                                        <tr>
                                                            <td>CTP</td>
                                                            <td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm ctp" id="ctp" name="ctp" type="text" onchange="calculate_quote_new('#add_quote_modal')" required></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Registration</td>
                                                            <td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm registration" id="registration" name="registration" type="text" onchange="calculate_quote_new('#add_quote_modal')" required></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Premium Plate Fee</td>
                                                            <td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="premium_plate_fee" name="premium_plate_fee" type="text" onchange="calculate_quote_new('#add_quote_modal')" required></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Stamp Duty</td>
                                                            <td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm stamp_duty" id="stamp_duty" name="stamp_duty" type="text" onchange="calculate_quote_new('#add_quote_modal')" required></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>TOTAL INC GST</b></td>
                                                            <td><input value="0" class="form-control input-sm" id="total" name="total" type="text" readonly></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tradein Value (-)</td>
                                                            <td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="dealer_tradein_value" name="dealer_tradein_value" type="text" onchange="calculate_quote_new('#add_quote_modal')" required></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tradein Payout (+)</td>
                                                            <td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="dealer_tradein_payout" name="dealer_tradein_payout" type="text" onchange="calculate_quote_new('#add_quote_modal')" required></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Refund to Client (+)</td>
                                                            <td><input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="dealer_client_refund" name="dealer_client_refund" type="text" onchange="calculate_quote_new('#add_quote_modal')" required></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Changeover</b></td>
                                                            <td><input value="0" class="form-control input-sm" id="dealer_changeover" name="dealer_changeover" type="text" readonly></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <br />
                                            <div class="table-responsive" id="transport_checkbox_container">
                                                <table class="table table-bordered table-striped table-condensed mb-none">
                                                    <tbody>
                                                        <tr>
                                                            <td width="70%">Is the Dealer paying for the transport of the Trade-in Vehicle?</td>
                                                            <td>
                                                                <select class="form-control" id="transport_checkbox" name="transport_checkbox">
                                                                    <option value=""></option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="Now">No</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <button type="submit" class="btn btn-primary" id="add_quote_submit_button">
                        Submit
                    </button>
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </form>
        </section>
    </div>
</div>

<div id="invited_dealers_modal" class="modal fade">
    <!-- Invited Dealers Modal -->
    <div class="modal-dialog" style="width: 95%;">
        <section class="panel">
            <form method="post" enctype="multipart/form-data" action="" id="invited_dealers_form" name="invited_dealers_form">
                <input type="hidden" id="id_lead" name="id_lead">
                <input type="hidden" id="id_quote_request" name="id_quote_request">
                <input type="hidden" id="email_template_id" name="email_template_id">
                <input type="hidden" id="dealer_ids_inp" name="dealer_ids" value="0">
                <div class="panel-body">
                    <div class="modal-wrapper">
                        <div class="modal-text">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h4 id="label_name" style="line-height: 1px;"></h4>
                                    <p id="label_email" style="color: #cccccc; font-size: 0.9em;"></p>
                                    <hr class="solid mt-sm mb-lg">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div style="padding: 20px; border: 1px solid #ddd;">
                                        <div class="row">
                                            <div class="col-md-12" id="suggested_dealers"></div>
                                            <div class="col-md-12">
                                                <br />
                                                <table class="table table-bordered table-striped table-condensed mb-none selected_dealers">
                                                    <thead>
                                                        <tr>
                                                            <td><b>SELECTED DEALERS</b></td>
                                                            <td></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="selected_dealers">
                                                        <tr class="norecord">
                                                            <td colspan="2">
                                                                <center>No dealer is selected!</center>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- <br />
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Email Text:</label>
                                                    <textarea class="form-control" rows="3" name="mail_text"></textarea>
                                                </div>
                                            </div> -->
                                            <br />
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="quote_file">Attach Dealer Agreement :</label>
                                                    <input type="file" id="quote_file" name="quote_file">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="quote_file">Preview Template :</label>
                                                    <textarea name="resend_quote_email_template_content" id="resend_quote_email_template_content" class="resend_quote_email_template_content" rows="10" cols="80" style="display: none;"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <!-- <button type="button" class="btn btn-info open-edit-emailtemplate edit_client_template_resend_quote" data-email_template_id="<?php echo QUOTE_REQUEST_MAIL_TEMPLATE ?>" id="invited_dealers_edit_template" style="display: none;">Edit Template</button> -->
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </section>
    </div>
</div>

<div id="send_email_template_model" class="modal fade">
    <div class="modal-dialog" style="width: 80%;">
        <section class="panel">
            <form action="" method="post" id="resend_vehicle_confirmation" name="resend_vehicle_confirmation">
                <input type="hidden" id="send_mail_template_subject" name="send_mail_template_subject">
                <input type="hidden" id="id_quote_request" name="id_quote_request">
                <input type="hidden" id="id_lead" name="id_lead">
                <div class="panel-body">
                    <div class="modal-wrapper">
                        <textarea name="send_email_template_content" id="send_email_template_content" class="send_email_template_content" rows="10" cols="80"></textarea>
                    </div>
                </div>
                <footer class="panel-footer">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <!-- <button type="button" class="btn btn-info open-edit-emailtemplate edit_client_template_resend_vehicle" data-email_template_id="<?php echo CLIENT_TRADE_MAIL_TEMPLATE ?>">Edit Template</button> -->
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </footer>
            </form>
        </section>
    </div>
</div>

<div id="email_client_trade_model" class="modal fade">
    <!-- Add Dealers Modal -->
    <div class="modal-dialog" style="width: 95%;">
        <section class="panel">
            <form method="post" enctype="multipart/form-data" action="" id="email_client_trade_form" name="email_client_trade_form">
                <input type="hidden" id="id_lead" name="id_lead">
                <input type="hidden" id="id_tradein" name="id_tradein">
                <input type="hidden" id="id_quote_request" name="id_quote_request">
                <!-- <input type="hidden" id="dealer_ids_inp" name="dealer_ids" value="0"> -->
                <div class="panel-body">
                    <div class="modal-wrapper">
                        <textarea name="email_client_template" id="email_client_template" class="email_client_template" rows="10" cols="80"></textarea>
                    </div>
                </div>
                <footer class="panel-footer">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <!-- <button type="button" class="btn btn-info open-edit-emailtemplate edit_client_template" data-email_template_id="<?php echo CLIENT_TRADE_MAIL_TEMPLATE ?>">Edit Template</button> -->
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </footer>
            </form>
        </section>
    </div>
</div>

<div id="add_trade_valuation_modal" class="modal fade">
    <!-- Add Quote Modal -->
    <div class="modal-dialog" style="width: 95%;">
        <section class="panel">
            <form method="post" action="" id="add_trade_valuation_form" name="add_trade_valuation_form" enctype="multipart/form-data">
                <input type="hidden" id="id_lead" name="id_lead" value="">
                <input type="hidden" id="id_tradeIn" name="id_tradeIn" value="">

                <div class="panel-body">
                    <div class="modal-wrapper">
                        <div class="modal-text">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h4 id="label_name" style="line-height: 1px;"></h4>
                                    <p id="label_email" style="color: #cccccc; font-size: 0.9em;"></p>
                                    <hr class="solid mt-sm mb-lg">
                                </div>
                            </div>

                            <div class="row" id="trade_valuation_form_dealer_selector_container" style="margin-top: 20px;">
                                <div class="col-md-12">
                                    <div style="padding: 20px; border: 1px solid #ddd;">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="control-label">Dealership Make:</label>
                                                <select class="form-control input-md" id="make_ds" type="text" onchange="load_suggested_dealers('add_trade_valuation_modal')">
                                                    <option name="make" value=""></option>
                                                    <?php foreach ($makes as $make) { ?>
                                                    <option name="make" value="<?php echo $make->name; ?>"><?php echo $make->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <br />
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label">State:</label>
                                                <select class="form-control input-md" id="state_ds" type="text" onchange="load_suggested_dealers('add_trade_valuation_modal')">
                                                    <option value=""></option>
                                                    <option value="ACT">Australian Capital Territory</option>
                                                    <option value="NSW">New South Wales</option>
                                                    <option value="NT">Northern Territory</option>
                                                    <option value="QLD">Queensland</option>
                                                    <option value="SA">South Australia</option>
                                                    <option value="TAS">Tasmania</option>
                                                    <option value="VIC">Victoria</option>
                                                    <option value="WA">Western Australia</option>
                                                </select>
                                            </div>
                                             <div class="col-md-4">
                                                <label class="control-label">User Type :</label>
                                                <select class="form-control input-md" id="type_ds" type="text" onchange="load_suggested_dealers('add_trade_valuation_modal')">
                                                    <option value="0">All</option>
                                                    <option value="1">Dealer</option>
                                                    <option value="3">Wholesaler</option>
                                                    <option value="8">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-left" id="suggested_dealers"></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 text-left">
                                                <br />
                                                <table class="table table-bordered table-striped table-condensed mb-none">
                                                    <thead>
                                                        <tr>
                                                            <td><b>SELECTED DEALERS</b></td>
                                                            <td></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="selected_dealers">
                                                        <tr class="norecord">
                                                            <td colspan="2">
                                                                <center>No dealer is selected!</center>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">                                            
                                           
                                            <div class="col-md-4">
                                                <label class="control-label">Valuation:</label>
                                                <input class="form-control input-md" id="" name="trade_valuation" type="text" value="" placeholder="Trade Valuation" required><br />
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div id="trade_valuation_form_warning_container" hidden>
                                <!-- Quote Form Warning -->
                                <div class="row" style="margin-top: 20px;">
                                    <div class="col-md-12">
                                        <div class="alert alert-danger" id="trade_valuation_form_warning_message">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <button type="submit" class="btn btn-primary" id="add_trade_valuation_submit_button">
                        Submit
                    </button>
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </form>
        </section>
    </div>
</div>

<div id="email_dealer_trade_model" class="modal fade">
    <!-- Add Dealers Modal -->
    <div class="modal-dialog" style="width: 95%;">
        <section class="panel">
            <form method="post" enctype="multipart/form-data" action="" id="email_dealer_trade_form" name="email_dealer_trade_form">
                <input type="hidden" id="id_lead" name="id_lead">
                <input type="hidden" id="id_tradein" name="id_tradein">
                <input type="hidden" id="dealer_id" name="dealer_id">
                <input type="hidden" id="email_template_id" name="email_template_id">
                <input type="hidden" id="dealer_ids_inp" name="dealer_ids" value="0">
                <div class="panel-body">
                    <div class="modal-wrapper">
                        <div class="modal-text">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h4 id="label_name" style="line-height: 1px;"></h4>
                                    <p id="label_email" style="color: #cccccc; font-size: 0.9em;"></p>
                                    <hr class="solid mt-sm mb-lg">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div style="padding: 20px; border: 1px solid #ddd;">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <select class="form-control input-md" id="make_ds" type="text" onchange="load_suggested_dealers('email_dealer_trade_model')">
                                                    <option name="make" value=""></option>
                                                    <?php foreach ($makes as $make){ ?>
                                                    <option value="<?php echo $make->name; ?>"><?php echo $make->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <br />
                                            </div>
                                            <div class="col-md-4">
                                                <select class="form-control input-md" id="state_ds" type="text" onchange="load_suggested_dealers('email_dealer_trade_model')">
                                                    <option value="">Select State</option>
                                                    <option value="ACT">Australian Capital Territory</option>
                                                    <option value="NSW">New South Wales</option>
                                                    <option value="NT">Northern Territory</option>
                                                    <option value="QLD">Queensland</option>
                                                    <option value="SA">South Australia</option>
                                                    <option value="TAS">Tasmania</option>
                                                    <option value="VIC">Victoria</option>
                                                    <option value="WA">Western Australia</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <input class="form-control input-md" id="postcode_ds" type="text" value="" placeholder="Postcode" onchange="load_suggested_dealers('email_dealer_trade_model')"><br />
                                            </div>
                                            <div class="col-md-12" id="suggested_dealers"></div>
                                            <div class="col-md-12">
                                                <br />
                                                <table class="table table-bordered table-striped table-condensed mb-none selected_dealers">
                                                    <thead>
                                                        <tr>
                                                            <td><b>SELECTED DEALERS</b></td>
                                                            <td></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="selected_dealers">
                                                        <tr class="norecord">
                                                            <td colspan="2">
                                                                <center>No dealer is selected!</center>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <br />
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Note :</label>
                                                    <textarea class="form-control" rows="3" name="mail_text"></textarea>
                                                </div>
                                            </div>
                                            <br />
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Preview Template :</label>
                                                    <textarea name="email_dealer_template" id="email_dealer_template" class="email_dealer_template" rows="10" cols="80" style="display: none;"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <!--<div class="form-group">
                                                    <label for="quote_file">Attach Dealer Agreement :</label>
                                                    <input type="file" id="quote_file" name="quote_file">
                                                </div>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <!-- <button type="button" class="btn btn-info open-edit-emailtemplate edit_dealer_template" id="dealer_edit_template" data-email_template_id="<?php echo DEALER_TRADE_MAIL_TEMPLATE ?>" style="display: none;">Edit Template</button> -->
                    <button type="submit" class="btn btn-primary" id="email_dealer_trade_sub_btn">
                        Submit
                    </button>
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </form>
        </section>
    </div>
</div>

<div id="email_wholesaler_trade_model" class="modal fade">
    <!-- Add Dealers Modal -->
    <div class="modal-dialog" style="width: 95%;">
        <section class="panel">
            <form method="post" enctype="multipart/form-data" action="" id="email_wholesaler_trade_form" name="email_wholesaler_trade_form">
                <input type="hidden" id="id_lead" name="id_lead">
                <input type="hidden" id="id_tradein" name="id_tradein">
                <input type="hidden" id="dealer_id" name="dealer_id">
                <input type="hidden" id="email_template_id" name="email_template_id">
                <input type="hidden" id="dealer_ids_inp" name="dealer_ids" value="0">
                <!-- <input type="hidden" id="wholesaler_ids_inp" name="wholesaler_ids" value="0"> -->
                <div class="panel-body">
                    <div class="modal-wrapper">
                        <div class="modal-text">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h4 id="label_name" style="line-height: 1px;"></h4>
                                    <p id="label_email" style="color: #cccccc; font-size: 0.9em;"></p>
                                    <hr class="solid mt-sm mb-lg">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div style="padding: 20px; border: 1px solid #ddd;">
                                        <div class="row">
                                            <!-- <div class="col-md-4">
                                                <select class="form-control input-md" id="make_ds" type="text" onchange="load_suggested_wholesalers('email_wholesaler_trade_model')">
                                                    <option name="make" value=""></option>
                                                    <?php foreach ($makes as $make){ ?>
                                                    <option value="<?php echo $make->name; ?>"><?php echo $make->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <br />
                                            </div>
                                            <div class="col-md-4">
                                                <select class="form-control input-md" id="state_ds" type="text" onchange="load_suggested_wholesalers('email_wholesaler_trade_model')">
                                                    <option value="">Select State</option>
                                                    <option value="ACT">Australian Capital Territory</option>
                                                    <option value="NSW">New South Wales</option>
                                                    <option value="NT">Northern Territory</option>
                                                    <option value="QLD">Queensland</option>
                                                    <option value="SA">South Australia</option>
                                                    <option value="TAS">Tasmania</option>
                                                    <option value="VIC">Victoria</option>
                                                    <option value="WA">Western Australia</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <input class="form-control input-md" id="postcode_ds" type="text" value="" placeholder="Postcode" onchange="load_suggested_wholesalers('email_wholesaler_trade_model')"><br />
                                            </div> -->
                                            <div class="col-md-12" id="suggested_wholesalers"></div>
                                            <div class="col-md-12">
                                                <br />
                                                <table class="table table-bordered table-striped table-condensed mb-none selected_dealers">
                                                    <thead>
                                                        <tr>
                                                            <td><b>SELECTED WHOLESALERS</b></td>
                                                            <td></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="selected_wholesalers">
                                                        <tr class="norecord">
                                                            <td colspan="2">
                                                                <center>No wholesaler is selected!</center>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <br />
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Note :</label>
                                                    <textarea class="form-control" rows="3" name="mail_text"></textarea>
                                                </div>
                                            </div>
                                            <br />
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Preview Template :</label>
                                                    <textarea name="email_wholesaler_template" id="email_wholesaler_template" class="email_wholesaler_template" rows="10" cols="80" style="display: none;"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <!--<div class="form-group">
                                                    <label for="quote_file">Attach Dealer Agreement :</label>
                                                    <input type="file" id="quote_file" name="quote_file">
                                                </div>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <!-- <button type="button" class="btn btn-info open-edit-emailtemplate edit_wholesaler_template" id="wholesaler_edit_template" data-email_template_id="<?php echo DEALER_TRADE_MAIL_TEMPLATE ?>" style="display: none;">Edit Template</button> -->
                    <button type="submit" class="btn btn-primary" id="email_wholesaler_trade_sub_btn">
                        Submit
                    </button>
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </form>
        </section>
    </div>
</div>

<!-- -------Added By - RJ - End---------- -->
<script type="text/javascript">
    //var update_email_template_url = "<?=base_url('index.php/email_template/update_email_template_data') ?>";
    var update_email_template_url = "<?=base_url('index.php/admin/update_email_template_data') ?>";
</script>

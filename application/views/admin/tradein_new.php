<style type="text/css">
    .input-tradein{
        background-color: black;
        color: white;
    }

    .car_image {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    .car_image:hover {opacity: 0.7;}

    /* The Modal (background) */
    .car_model {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
    }

    /* Modal Content (image) */
    .car_model-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    /* Caption of Modal Image */
    #caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    }

    /* Add Animation */
    .car_model-content, #caption {    
        -webkit-animation-name: zoom;
        -webkit-animation-duration: 0.6s;
        animation-name: zoom;
        animation-duration: 0.6s;
    }

    @-webkit-keyframes zoom {
        from {-webkit-transform:scale(0)} 
        to {-webkit-transform:scale(1)}
    }

    @keyframes zoom {
        from {transform:scale(0)} 
        to {transform:scale(1)}
    }

    /* The Close Button */
    .close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #ffffff;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close:hover,
    .close:focus {
        /*color: #bbb;*/
        color: #ffffff;

        text-decoration: none;
        cursor: pointer;
    }

    /* 100% Image Width on Smaller Screens */
    @media only screen and (max-width: 700px){
        .car_model-content {
            width: 100%;
        }
    }
    

    .black_border{
        border-color:black !important;
    }
    .mb-35 {
        position: relative;
        margin-bottom: 35px;
    }
    .checkbox { position: absolute; bottom: 0px; right: 20px; }

</style>
<link href="<?=base_url();?>assets/vendor/jquery.filer/css/jquery.filer.css" rel="stylesheet" />
<section class="panel" id="start_valuation_modal">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <?php                
                /*$errors = array_filter($tradeins);

                echo "<pre>";                
                print_r($tradeins);
                echo "<br>";
                print_r($errors);                
                echo "</pre>";*/                
                ?>
                <button class="btn btn-default btn-sm <?=isset($tradeins->id_tradein) ? 'trade_valuation_modal_button' : 'disabled' ?>" data-id_tradein="<?=isset($tradeins->id_tradein) ? $tradeins->id_tradein : '' ?>" data-id_lead="<?=isset($tradeins->id_leads) ? $tradeins->id_leads : '' ?>" type="button">Add Valuation</button>
                
                <!-- <button class="btn btn-default btn-sm <?=(isset($id_quote_request) && !empty($id_quote_request)) || (isset($tradeins->id_tradein) && !empty($tradeins->id_tradein)) ? 'email_client_trade_details' : 'disabled';?>" type="button" data-id_tradein="<?=isset($tradeins->id_tradein) ? $tradeins->id_tradein : '' ?>" data-id_quote_request="<?=isset($id_quote_request) ? $id_quote_request : '' ?>" data-id_lead="<?=isset($lead_id) ? $lead_id : '' ?>" data-email_template_id="<?php echo CLIENT_TRADE_MAIL_TEMPLATE ?>">Email Client Trade Details</button> -->
                <button class="btn btn-default btn-sm <?= isset($tradeins->id_tradein) ? 'email_client_trade_details' : 'disabled';?>" type="button" data-id_tradein="<?=isset($tradeins->id_tradein) ? $tradeins->id_tradein : '' ?>" data-id_quote_request="<?=isset($id_quote_request) ? $id_quote_request : '' ?>" data-id_lead="<?=isset($lead_id) ? $lead_id : '' ?>" data-email_template_id="<?php echo CLIENT_TRADE_MAIL_TEMPLATE ?>">Email Client Trade Details</button>

                <button class="btn btn-default btn-sm" disabled type="button">SMS Client</button>

                <button class="btn btn-default btn-sm <?=isset($tradeins->id_tradein) ? 'email_dealer_trade_details' : 'disabled';?>" data-id_tradein="<?=isset($tradeins->id_tradein) ? $tradeins->id_tradein : '' ?>" data-id_lead="<?=isset($tradeins->id_leads) ? $tradeins->id_leads : '' ?>" type="button" data-email_template_id="<?php echo DEALER_TRADE_MAIL_TEMPLATE ?>">Email Dealer Trade Details</button>

                <button class="btn btn-default btn-sm" disabled type="button">SMS Dealer</button>
                <button class="btn btn-default btn-sm <?=isset($tradeins->id_tradein) ? 'email_wholesaler_trade_details' : 'disabled';?>" data-id_tradein="<?=isset($tradeins->id_tradein) ? $tradeins->id_tradein : '' ?>" data-id_lead="<?=isset($tradeins->id_leads) ? $tradeins->id_leads : '' ?>" data-email_template_id="<?php echo DEALER_TRADE_MAIL_TEMPLATE ?>" type="button">Email Wholesaler Trade Details</button>                
                <button class="btn btn-default btn-sm" disabled type="button">SMS Whoeslaer</button>

            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-md-12">
                <h5><b style="color: white;">Pictures</b></h5>
                <hr class="solid mt-sm mb-lg">
            </div>

            <div class="col-md-12">
                <?php if(isset($tradeins->rb_data_img) && !empty($tradeins->rb_data_img)){ ?>
                <div class="col-md-3">
                    <img src="<?=$tradeins->rb_data_img;?>" class="img-rounded car_image" alt="" style="width:100%;max-width:300px" width="284" height="186">
                </div>
                <form id="selectable-form" name="selectable-form" enctype="multipart/form-data">
                <?php } ?>
                <?php
                if(isset($tradeins->images) && !empty($tradeins->images)){
                    $images_arr = explode(', ', $tradeins->images);
                    foreach($images_arr as $image){
                ?>
                    <div class="col-md-3 mb-35">
                        <img src="<?=base_url('uploads/tradein_cars/'.$image);?>" class="img-rounded car_image" alt="" style="width:100%;max-width:300px" width="284" height="186">
                        <input type="checkbox" class="checkbox selectable" name="tradein_select[]" value="<?= $image ?>">
                    </div>
                <?php   
                    }
                }
                if(empty($tradeins)) {
                    echo '<div class="col-md-12 center"><h3>Upload Images</h3></div>';
                }
                ?>             
                </form>
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-md-12">
                <h5><b style="color: white;">Trade Summary</b></h5>
                <hr class="solid mt-sm mb-lg">
            </div>
        </div>

        <div class="row">
            <form method="post" action="" id="start_valuation_form" name="start_valuation_form" enctype="multipart/form-data">
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
                                <!-- Dealer Selector -->
                                <div class="col-md-12 ">
                                    <h4 style="color:#FFFFFF;">
                                        User Tradein data entry
                                    </h4>
                                </div>
                                <br>
                                <div class="col-md-12 text-center">
                                    <h4 id="label_name" style="line-height: 1px;"></h4>
                                    <p id="label_email" style="color: #cccccc; font-size: 0.9em;"></p>
                                    <hr class="solid mt-sm mb-lg">
                                </div>
                                <br>
                                <?php
                                //echo '<pre>';print_r($makes);
                                ?>
                                <div class="col-md-12">
                                    <div class="container_bordered_round">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label><font color="red">*</font> Make:</label>
                                                <select class="form-control input-sm input-tradein makeclass_tradein <?=isset($tradeins->make) && !empty($tradeins->make) ? "black_border" : ''?> " id="" name="make" onchange="load_families('start_valuation_modal', this.options[this.selectedIndex].value, 0)">
                                                    <option value=""></option>
                                                    <?php foreach ($makes as $make) { ?>                                            
                                                    <option value="<?=$make['id_make'];?>" <?=isset($tradeins->make) && $tradeins->make == $make['id_make'] ? "selected='selected'" : '';?>><?php echo $make['name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <br />
                                            </div>
                                            <div class="col-md-4">
                                                <label><font color="red">*</font> Model:</label>
                                                <select class="form-control input-sm input-tradein modelclass_tradein <?=isset($tradeins->family) && !empty($tradeins->family) ? "black_border" : ''?>" id="family" name="family" onchange="load_build_dates('start_valuation_modal', this.options[this.selectedIndex].value, 0)" <?php //onchange="load_build_dates_tradein('start_valuation_modal', this.options[this.selectedIndex].value, 0)" ?>  disabled>
                                                    <option value="">
                                                        <span class="loader"></span>
                                                    </option>
                                                </select>
                                                <br />
                                            </div>
                                            <div class="col-md-4">
                                                <label>Registration Plat</label>
                                                <input class="form-control input-sm input-tradein <?=isset($tradeins->registration_plat) && !empty($tradeins->registration_plat) ? "black_border" : ''?>" value="<?=isset($tradeins->registration_plat) ? $tradeins->registration_plat : '' ?>" id="registration_plat" name="registration_plat" type="text">
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="col-md-12">
                                                <label>Redbook Data:</label><br />
                                                <select class="form-control input-sm input-tradein rb_data_option <?=isset($tradeins->family) && !empty($tradeins->family) ? "black_border" : ''?>" id="rb_data" name="rb_data"><option value="">No Data Found</option></select>
                                                <br />
                                            </div>

                                            <div class="clearfix"></div>
                                            <div class="col-sm-4">
                                                <label class="control-label">Kilometers</label><br />
                                                <input class="form-control input-sm input-tradein <?=isset($tradeins->kilometers) && !empty($tradeins->kilometers) ? "black_border" : ''?>" value="<?=isset($tradeins->kilometers) ? $tradeins->kilometers : '' ?>" id="kilometers" name="kilometers" type="text">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label">Colour</label><br />
                                                <input class="form-control input-sm input-tradein <?=isset($tradeins->colour) && !empty($tradeins->colour) ? "black_border" : ''?>" value="<?=isset($tradeins->colour) ? $tradeins->colour : '' ?>" id="colour" name="colour" type="text">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label">Service History</label><br />
                                                <select class="form-control input-sm input-tradein <?=isset($tradeins->service_history) && !empty($tradeins->service_history) ? "black_border" : ''?>" name="service_history">
                                                    <option value=""> --Select-- </option>
                                                    <option value="1" <?=isset($tradeins->service_history) && $tradeins->service_history == '1' ? "selected='selected'" : '';?>>Service records & books available and servicing complete</option>
                                                    <option value="2" <?=isset($tradeins->service_history) && $tradeins->service_history == '2' ? "selected='selected'" : '';?>>Service records and books available but some servicing incomplete</option>
                                                    <option value="3" <?=isset($tradeins->service_history) && $tradeins->service_history == '3' ? "selected='selected'" : '';?>>Missing books and unknown service</option>
                                                </select>
                                            </div>
                                            <div class="clearfix"></div><br>

                                            <div class="col-sm-4">
                                                <label class="control-label">Rego Expiry</label><br />
                                                <input class="form-control input-sm input-tradein <?=isset($tradeins->rego_expiry) && !empty($tradeins->rego_expiry) ? "black_border" : ''?>" value="<?=isset($tradeins->rego_expiry) ? $tradeins->rego_expiry : '' ?>"  id="rego_expiry" name="rego_expiry" type="text">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label">Tyres</label><br />
                                                <select class="form-control input-sm input-tradein <?=isset($tradeins->tyres) && !empty($tradeins->tyres) ? "black_border" : ''?>" name="tyres">
                                                    <option value=""> --Select-- </option>
                                                    <option value="1" <?=isset($tradeins->tyres) && $tradeins->tyres == '1' ? "selected='selected'" : '';?>>New or near new</option>
                                                    <option value="2" <?=isset($tradeins->tyres) && $tradeins->tyres == '2' ? "selected='selected'" : '';?>>Not new but I believe them to be in roadworthy condition </option>
                                                    <option value="3" <?=isset($tradeins->tyres) && $tradeins->tyres == '3' ? "selected='selected'" : '';?>>Some or all may need replacing</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label">Dash Warning Lights</label><br />
                                                <select class="form-control input-sm input-tradein <?=isset($tradeins->dash_warning_lights) && !empty($tradeins->dash_warning_lights) ? "black_border" : ''?>" name="dash_warning_lights">
                                                    <option value=""> --Select-- </option>
                                                    <option value="1" <?=isset($tradeins->dash_warning_lights) && $tradeins->dash_warning_lights == '1' ? "selected='selected'" : '';?>>No dash warning lights illuminated</option>
                                                    <option value="2" <?=isset($tradeins->dash_warning_lights) && $tradeins->dash_warning_lights == '2' ? "selected='selected'" : '';?>>Dash warning lights illuminated</option>
                                                </select>
                                            </div>
                                            <div class="clearfix"></div><br>

                                            <div class="col-sm-4">
                                                <label class="control-label">Windscreen</label><br />
                                                <select class="form-control input-sm input-tradein <?=isset($tradeins->windscreen) && !empty($tradeins->windscreen) ? "black_border" : ''?>" name="windscreen">
                                                    <option value=""> --Select-- </option>
                                                    <option value="1" <?=isset($tradeins->windscreen) && $tradeins->windscreen == '1' ? "selected='selected'" : '';?>>Windscreen has no cracks or chips</option>
                                                    <option value="2" <?=isset($tradeins->windscreen) && $tradeins->windscreen == '2' ? "selected='selected'" : '';?>>Windscreen has cracks or chips</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label">Spare Keys</label><br />
                                                <select class="form-control input-sm input-tradein <?=isset($tradeins->spare_keys) && !empty($tradeins->spare_keys) ? "black_border" : ''?>" name="spare_keys">
                                                    <option value=""> --Select-- </option>
                                                    <option value="1" <?=isset($tradeins->spare_keys) && $tradeins->spare_keys == '1' ? "selected='selected'" : '';?>>2 sets of keys available</option>
                                                    <option value="2" <?=isset($tradeins->spare_keys) && $tradeins->spare_keys == '2' ? "selected='selected'" : '';?>>1 sets of keys available</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label">Paint Work</label><br />
                                                <select class="form-control input-sm input-tradein <?=isset($tradeins->paint_work) && !empty($tradeins->paint_work) ? "black_border" : ''?>" name="paint_work">
                                                    <option value=""> --Select-- </option>
                                                    <option value="1" <?=isset($tradeins->paint_work) && $tradeins->paint_work == '1' ? "selected='selected'" : '';?>>Perfect</option>
                                                    <option value="2" <?=isset($tradeins->paint_work) && $tradeins->paint_work == '2' ? "selected='selected'" : '';?>>Minor Scratches</option>
                                                    <option value="3" <?=isset($tradeins->paint_work) && $tradeins->paint_work == '3' ? "selected='selected'" : '';?>>Moderate scratches, chips, dents</option>
                                                    <option value="4" <?=isset($tradeins->paint_work) && $tradeins->paint_work == '4' ? "selected='selected'" : '';?>>Damage, dents, paint blemishes, rust or poor previous repair</option>
                                                </select>
                                            </div>
                                            <div class="clearfix"></div><br>

                                            <div class="col-sm-4">
                                                <label class="control-label">Has your vehicle been a rental or taxi</label><br />
                                                <select class="form-control input-sm input-tradein <?=isset($tradeins->rental_or_taxi) && !empty($tradeins->rental_or_taxi) ? "black_border" : ''?>" name="rental_or_taxi">
                                                    <option value=""> --Select-- </option>
                                                    <option value="1" <?=isset($tradeins->rental_or_taxi) && $tradeins->rental_or_taxi == '1' ? "selected='selected'" : '';?>>Yes</option>
                                                    <option value="2" <?=isset($tradeins->rental_or_taxi) && $tradeins->rental_or_taxi == '2' ? "selected='selected'" : '';?>>No</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label">Did you buy the car new</label><br />
                                                <select class="form-control input-sm input-tradein <?=isset($tradeins->buy_new_car) && !empty($tradeins->buy_new_car) ? "black_border" : ''?>"  name="buy_new_car">
                                                    <option value=""> --Select-- </option>
                                                    <option value="1" <?=isset($tradeins->buy_new_car) && $tradeins->buy_new_car == '1' ? "selected='selected'" : '';?>>Yes</option>
                                                    <option value="2" <?=isset($tradeins->buy_new_car) && $tradeins->buy_new_car == '2' ? "selected='selected'" : '';?>>No</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label">Do all Options & Accessories work</label><br />
                                                <select class="form-control input-sm input-tradein <?=isset($tradeins->all_accessories_work) && !empty($tradeins->all_accessories_work) ? "black_border" : ''?>"  name="all_accessories_work">
                                                    <option value=""> --Select-- </option>
                                                    <option value="1" <?=isset($tradeins->all_accessories_work) && $tradeins->all_accessories_work == '1' ? "selected='selected'" : '';?>>Yes</option>
                                                    <option value="2" <?=isset($tradeins->all_accessories_work) && $tradeins->all_accessories_work == '2' ? "selected='selected'" : '';?>>No</option>
                                                </select>
                                            </div>
                                            <div class="clearfix"></div><br>

                                            <div class="col-sm-4">
                                                <label class="control-label">Has your vehicle been any accidents</label><br />
                                                <select class="form-control input-sm input-tradein <?=isset($tradeins->accidents) && !empty($tradeins->accidents) ? "black_border" : ''?>" name="accidents">
                                                    <option value=""> --Select-- </option>
                                                    <option value="1" <?=isset($tradeins->accidents) && $tradeins->accidents == '1' ? "selected='selected'" : '';?>>Yes</option>
                                                    <option value="2" <?=isset($tradeins->accidents) && $tradeins->accidents == '2' ? "selected='selected'" : '';?>>No</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label">Has the vehicle ever had any paint work</label><br />
                                                <select class="form-control input-sm input-tradein <?=isset($tradeins->any_paint_work) && !empty($tradeins->any_paint_work) ? "black_border" : ''?>" name="any_paint_work">
                                                    <option value=""> --Select-- </option>
                                                    <option value="1" <?=isset($tradeins->any_paint_work) && $tradeins->any_paint_work == '1' ? "selected='selected'" : '';?>>Yes</option>
                                                    <option value="2" <?=isset($tradeins->any_paint_work) && $tradeins->any_paint_work == '2' ? "selected='selected'" : '';?>>No</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label">Estimated payout if finance encumbered</label><br />
                                                <input class="form-control input-sm input-tradein <?=isset($tradeins->estimated_payout) && !empty($tradeins->estimated_payout) ? "black_border" : ''?>" value="<?=isset($tradeins->estimated_payout) ? $tradeins->estimated_payout : '' ?>"  id="estimated_payout" name="estimated_payout" type="text">
                                            </div>
                                            <div class="clearfix"></div><br>

                                            <div class="col-sm-12">
                                                <label class="control-label">Please list any options & Accessories </label><br />
                                                <input class="form-control input-sm input-tradein <?=isset($tradeins->additional_notes) && !empty($tradeins->additional_notes) ? "black_border" : ''?>" value="<?=isset($tradeins->additional_notes) ? $tradeins->additional_notes : '' ?>" id="" name="additional_notes" type="text">
                                            </div>
                                            <div class="clearfix"></div><br>
                                            <div class="col-sm-12">
                                                <label class="control-label">Please Describe Any Damage or Mechanical Issues </label><br />
                                                <input class="form-control input-sm input-tradein <?=isset($tradeins->damage_or_mechanical_issue) && !empty($tradeins->damage_or_mechanical_issue) ? "black_border" : ''?>" value="<?=isset($tradeins->damage_or_mechanical_issue) ? $tradeins->damage_or_mechanical_issue : '' ?>" id="" name="damage_or_mechanical_issue" type="text">
                                            </div>

                                            <div class="clearfix"></div><br>
                                            <div class="col-sm-4">
                                                <!-- <label class="control-label">Select Photos For Upload</label><br />
                                                <input type="file" multiple class="form-control input-sm input-tradein" id="photos" name="photos[]"> -->
                                                <label> Select Photos For Upload </label>
                                                <?php
                                                if(count($images_arr)< 4)
                                                {
                                                    ?>
                                                      <input type="file" multiple class="form-control input-sm input-tradein" id="photos" name="photos[]" > <!-- required -->
                                                    <?php
                                                }else{
                                                    ?>
                                                    <h5>4 Images Already Selected</h5>
                                                    <?php
                                                }
                                                ?>
                                              
                                                <input type="hidden" id="rename_file">
                                                <?php
                                                $images = '';
                                                if(isset($tradeins->images) && !empty($tradeins->images)) {
                                                    $images = explode(', ', $tradeins->images);
                                                    $images = json_encode($images);
                                                }
                                                ?>
                                                <input type="hidden" id="old_images" name="old_images" value='<?php echo $images; ?>'>
                                                <input type="hidden" id="images" name="images">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>                                
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-left">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <!--<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>-->
                </div>
            </form>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <h5><b style="color: white;">Invitations</b></h5>
                <hr class="solid mt-sm mb-lg">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed mb-none" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr style="background-color: #f9f9f9;color: black;">
                                <td>Valuer</td>
                                <td>State</td>
                                <td>Invites</td>
                                <td>Quotes</td>
                                <td>Won</td>
                            </tr>
                        </thead>
                        <tbody style="color: #ffffff">
                            <?php
                            if(isset($tradeins) && !empty($tradeins) && isset($tradein_recipients) && !empty($tradein_recipients)){
                                foreach($tradein_recipients as $valuaton){
                                    echo '<tr>';        
                                    echo '<td>'.$valuaton['name'].'</td>';
                                    echo '<td>'.$valuaton['state'].'</td>';
                                    echo '<td></td>';
                                    echo '<td></td>';
                                    echo '<td></td>';                                    
                                    echo '</tr>';        
                                }
                            }else{
                                echo '<tr>';
                                echo '<td colspan="5" style="text-align:center;">No Invitations</td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <h5><b style="color: white;">Valuations</b></h5>
                <hr class="solid mt-sm mb-lg">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed mb-none" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr style="background-color: #f9f9f9;color: black;">
                                <td align="center"><i class="fa fa-trophy"></i></td>
                                <td>Valuer</td>
                                <td>State</td>
                                <td>Valuation </td>
                            </tr>
                        </thead>
                        <tbody style="color: #ffffff">
                            <?php
                            if(isset($tradeins) && !empty($tradeins) && isset($tradein_valuations) && !empty($tradein_valuations)){
                                foreach($tradein_valuations as $valuation){
                                    echo '<tr>';
                                    if ($tradein['fk_trade_valuation']==$valuation['id_trade_valuation']) 
                                    {

                                        echo '<td align="center">
                                                <span class="ajax_button_primary remove_winning_trade_valuation_button" data-id_tradein="'.$tradein['id_tradein'].'" data-id_trade_valuation="'.$valuation['id_trade_valuation'].'">
                                                    <i class="fa fa-trophy"></i>
                                                </span>
                                            </td>';
                                    }
                                    else
                                    {
                                        echo '<td align="center">
                                            <a class="ajax_button_primary select_winning_trade_valuation_button" data-id_tradein="'.$tradein['id_tradein'].'" data-id_trade_valuation="'.$valuation['id_trade_valuation'].'">
                                                <i class="fa fa-trophy"></i>
                                            </a>
                                        </td>';
                                    }
                                    echo '<td>'.$valuation['name'].'</td>';
                                    echo '<td>'.$valuation['state'].'</td>';
                                    echo '<td>'.$valuation['value'].'</td>';
                                    echo '</tr>';
                                }
                            }else{
                                echo '<tr>';
                                echo '<td colspan="3" style="text-align:center;">No Valuations</td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6"></div>
        </div>                        
        <br />            
    </div>    
</section>

<div id="myCarModal" class="car_model">
    <span class="close">&times;</span>
    <img class="car_model-content" id="img01">
    <div id="caption"></div>
</div>

<script src="<?=base_url('assets/vendor/jquery.filer/js/jquery.filer.min.js');?>?v=<?php echo time();?>" type="text/javascript"></script>
<script type="text/javascript">
    var car_model = document.getElementById('myCarModal');
    var car_modelImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");
    var tradeInform_changedFlag = 0;

    $(document).on("click",".car_image",function(){
        document.getElementById("img01");
        $('.btn-toolbar').hide();
        car_model.style.display = "block";
        car_modelImg.src = this.src;
        captionText.innerHTML = this.alt;
        $("#fapplication-modal-3").animate({ scrollTop: 0 }, "slow");
    });                

    $(document).on("click",".close",function(){
        car_model.style.display = "none";
        $('.btn-toolbar').show();
    });

    $(document).ready(function() {
        <?php if(isset($tradeins->make)){ ?>
        load_families('start_valuation_modal', <?=$tradeins->make;?>, <?=$tradeins->family;?>);    
        <?php } ?>

        <?php if(isset($tradeins->rb_data)){ ?>
        rbgetdata("start_valuation_form",<?=$tradeins->make;?>,<?=$tradeins->family;?>,0);

        setTimeout(function(){
            $("#rb_data option[value='<?=$tradeins->rb_data;?>']").attr("selected", "selected");
        }, 2000);    
        <?php } ?>

        $("#start_valuation_form :input").change(function() {
            //$(this).closest('form').data('changed', true);
            tradeInform_changedFlag++;
            //alert(tradeInform_changedFlag);
        });

        var photos = {};
        /* file uploader */
        $('#photos').filer({
            limit: 4,
            maxSize: 25,
            extensions: ['jpg', 'jpeg', 'png', 'gif'],
            changeInput: true,
            showThumbs: true,
            addMore: true,
            uploadFile: {
                url: "<?php echo site_url("Process/upload_img"); ?>",
                data: null,
                type: 'POST',
                enctype: 'multipart/form-data',
                beforeSend: function(){},
                success: function(data, el){
                    var json = $.parseJSON(data);
                    let name = json['metas'][0]['name'];
                    var old_name = json['metas'][0]['old_name'];
                    
                    photos[old_name] = name;
                    
                    let images = JSON.stringify(photos); 
                    $('#images').val(images);

                    var parent = el.find(".jFiler-jProgressBar").parent();
                    el.find(".jFiler-jProgressBar").fadeOut("slow", function(){
                        $("<div class=\"jFiler-item-others text-success\"><i class=\"icon-jfi-check-circle\"></i> Success</div>").hide().appendTo(parent).fadeIn("slow");
                    });
                },
                error: function(el){
                    var parent = el.find(".jFiler-jProgressBar").parent();
                    el.find(".jFiler-jProgressBar").fadeOut("slow", function(){
                        $("<div class=\"jFiler-item-others text-error\"><i class=\"icon-jfi-minus-circle\"></i> Error</div>").hide().appendTo(parent).fadeIn("slow");
                    });
                },
                statusCode: null,
                onProgress: null,
                onComplete: null
            },
            onRemove: function(itemEl, file, id, listEl, boxEl, newInputEl, inputEl){
                var filename = file.name.split('.')[0];
                var f_name = photos[filename];

                var key = filename;
                delete photos[key];

                let images = JSON.stringify(photos); 
                $('#images').val(images);
                
                $.post('<?php echo site_url("Process/remove_file"); ?>', {file: f_name});
            },
        });
        /* file uploader */

        /* On checkbox change event */
        $('.selectable').on('change', function() {
            let form_data = $('#selectable-form').serialize();
            $('.selectable').attr('disabled','disabled');
            // setTimeout(function() {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url("tradein/save_picture") ?>",
                    data: form_data,
                    success: function(result) {
                        console.log(result);
                        $('.selectable').removeAttr('disabled');
                    }
                });
            // }, 3000);
        });
        /* On checkbox change event */

        $(".select_winning_trade_valuation_button").click(function(e) {
            var id_tradein = $(this).data("id_tradein");
            var id_trade_valuation = $(this).data("id_trade_valuation");

            var data = {
                id_tradein: id_tradein,
                id_trade_valuation: id_trade_valuation
            };

            $.ajax({
                type: "POST",
                url: "<?php echo site_url("tradein/select_winner"); ?>",
                data: data,
                cache: false,
                success: function(response){
                    if (response === "success")
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

        $(".remove_winning_trade_valuation_button").click(function(e) {
            var id_tradein = $(this).data("id_tradein");
            var id_trade_valuation = $(this).data("id_trade_valuation");

            var data = {
                id_tradein: id_tradein,
                id_trade_valuation: id_trade_valuation
            };

            $.ajax({
                type: "POST",
                url: "<?php echo site_url("tradein/remove_winner"); ?>",
                data: data,
                cache: false,
                success: function(response){
                    if (response === "success")
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

    });


</script>
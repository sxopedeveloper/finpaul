<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Finquote </title>
        <link rel="stylesheet" href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.css'); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom.css?i='.time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/vendor/font-awesome/css/font-awesome.css'); ?>" />
        <!-- bootstrap datepicker -->
        <link rel="stylesheet" href="<?= base_url();?>assets/vendor/bootstrap-datepicker/css/datepicker3.css">
        <link rel="stylesheet" href="<?= base_url();?>assets/vendor/sweetalert/sweetalert.css">

        <link rel="shortcut icon" href="<?= base_url();?>assets/img/favicon.png" type="image/x-icon">

        <style>
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

            select {
                -moz-appearance: none;
                -webkit-appearance:none;
                border:0px solid #fff !important;
                padding:5px 0px;
            }
            input {
                border:0px solid #fff !important;
            }
            
            input.del_input {
                border:1px solid #fff !important;
            }
            
        </style>

    </head>
    <body>
        <section class="quote-request-main">
            <div class="container">
                <div class="row">
                    <div class="quote-request-inner">
                        <div class="col-md-12">
                            <img src="<?php echo base_url('assets/img/finquote.png'); ?>" width="250" height="auto" class="img-responsive" style="width:100%;max-width:300px" alt="finquote-logo">
                            <div class="text-center">
                                <h3>Trade Vehicle Details</h3>
                                <p>Please review trade vehicle details, click on images to enlarge and submit your valuation.</p>                                
                            </div>                            
                            <div class="row">
                                <div class="col-md-12">                                    
                                    <div class="img-sec" style="margin-top: 10px !important">
                                        <p>Pictures</p>
                                        <hr>
                                        <?php 
                                        if(isset($tradeins->rb_data_img) && !empty($tradeins->rb_data_img)) {
                                            echo '<div class="col-md-3">';
                                            echo '<img src="'.$tradeins->rb_data_img.'" class="img-rounded car_image" alt="" style="width:100%;max-width:300px" width="284" height="186">';
                                            echo '</div>';
                                        }
                                        if(isset($tradeins->images) && !empty($tradeins->images)) {
                                            $images_arr = explode(', ', $tradeins->images);   
                                            foreach($images_arr as $image) {
                                                echo '<div class="col-md-3">';
                                                echo '<img src="'.base_url('uploads/tradein_cars/'.$image).'" class="img-rounded car_image" alt="" width="284" height="186">';
                                                echo '</div>';
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <p>Trade Summary</p>
                            <hr>
                        </div>
                        <form method="post" enctype="multipart/form-data" action="">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><font color="red">*</font> Make:</label>
                                    <select class="form-control input-sm input-tradein makeclass_tradein" disabled id="make" name="make" onchange="load_families('start_valuation_car_model', this.options[this.selectedIndex].value, 0)" required>
                                        <option value=""></option>
                                        <?php foreach ($makes as $make) { ?>                                            
                                        <option value="<?=$make['id_make'];?>" <?=isset($tradeins->make) && $tradeins->make == $make['id_make'] ? "selected='selected'" : '';?>><?php echo $make['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><font color="red">*</font> Model:</label>
                                    <select class="form-control input-sm input-tradein modelclass_tradein" disabled id="family" name="family"  disabled required>
                                        <option value="">
                                            <span class="loader"></span>
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Registration Plate</label>
                                    <input class="form-control input-sm input-tradein" value="<?=isset($tradeins->registration_plat) ? $tradeins->registration_plat : '' ?>" disabled id="registration_plat" name="registration_plat" type="text">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Redbook Data</label>
                                    <select class="form-control input-sm input-tradein rb_data_option" disabled id="rb_data" name="rb_data" required>
                                        <option value="">No Data Found</option>
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Kilometers</label>
                                    <input type="text" id="kilometers" value="<?=isset($tradeins->kilometers) ? $tradeins->kilometers : '' ?>" disabled name="kilometers" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Colour</label>
                                    <input type="text" name="colour" disabled value="<?=isset($tradeins->colour) ? $tradeins->colour : '' ?>" id="colour" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Service History</label>
                                    <select class="form-control input-sm input-tradein" disabled name="service_history">
                                        <option value=""> --Select-- </option>
                                        <option value="1" <?=isset($tradeins->service_history) && $tradeins->service_history == '1' ? "selected='selected'" : '';?>>Service records & books available and servicing complete</option>
                                        <option value="2" <?=isset($tradeins->service_history) && $tradeins->service_history == '2' ? "selected='selected'" : '';?>>Service records and books available but some servicing incomplete</option>
                                        <option value="3" <?=isset($tradeins->service_history) && $tradeins->service_history == '3' ? "selected='selected'" : '';?>>Missing books and unknown service</option>
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Rego Expiry</label>
                                    <input type="text" id="rego_expiry" disabled name="rego_expiry" value="<?=isset($tradeins->rego_expiry) ? $tradeins->rego_expiry : '' ?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tyres</label>
                                    <select class="form-control input-sm input-tradein" disabled name="tyres">
                                        <option value=""> --Select-- </option>
                                        <option value="1" <?=isset($tradeins->tyres) && $tradeins->tyres == '1' ? "selected='selected'" : '';?>>New or near new</option>
                                        <option value="2" <?=isset($tradeins->tyres) && $tradeins->tyres == '2' ? "selected='selected'" : '';?>>Not new but I believe them to be in roadworthy condition </option>
                                        <option value="3" <?=isset($tradeins->tyres) && $tradeins->tyres == '3' ? "selected='selected'" : '';?>>Some or all may need replacing</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Dash Warning Lights</label>
                                    <select class="form-control input-sm input-tradein" disabled name="dash_warning_lights">
                                        <option value=""> --Select-- </option>
                                        <option value="1" <?=isset($tradeins->dash_warning_lights) && $tradeins->dash_warning_lights == '1' ? "selected='selected'" : '';?>>No dash warning lights illuminated</option>
                                        <option value="2" <?=isset($tradeins->dash_warning_lights) && $tradeins->dash_warning_lights == '2' ? "selected='selected'" : '';?>>Dash warning lights illuminated</option>
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Windscreen</label>
                                    <select class="form-control input-sm input-tradein" disabled name="windscreen">
                                        <option value=""> --Select-- </option>
                                        <option value="1" <?=isset($tradeins->windscreen) && $tradeins->windscreen == '1' ? "selected='selected'" : '';?>>Windscreen has no cracks or chips</option>
                                        <option value="2" <?=isset($tradeins->windscreen) && $tradeins->windscreen == '2' ? "selected='selected'" : '';?>>Windscreen has cracks or chips</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Spare Keys</label>
                                    <select class="form-control input-sm input-tradein" disabled name="spare_keys">
                                        <option value=""> --Select-- </option>
                                        <option value="1" <?=isset($tradeins->spare_keys) && $tradeins->spare_keys == '1' ? "selected='selected'" : '';?>>2 sets of keys available</option>
                                        <option value="2" <?=isset($tradeins->spare_keys) && $tradeins->spare_keys == '2' ? "selected='selected'" : '';?>>1 sets of keys available</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Paint work</label>
                                    <select class="form-control input-sm input-tradein" disabled name="paint_work">
                                        <option value=""> --Select-- </option>
                                        <option value="1" <?=isset($tradeins->paint_work) && $tradeins->paint_work == '1' ? "selected='selected'" : '';?>>Perfect</option>
                                        <option value="2" <?=isset($tradeins->paint_work) && $tradeins->paint_work == '2' ? "selected='selected'" : '';?>>Minor Scratches</option>
                                        <option value="3" <?=isset($tradeins->paint_work) && $tradeins->paint_work == '3' ? "selected='selected'" : '';?>>Moderate scratches, chips, dents</option>
                                        <option value="4" <?=isset($tradeins->paint_work) && $tradeins->paint_work == '4' ? "selected='selected'" : '';?>>Damage, dents, paint blemishes, rust or poor previous repair</option>
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Has your vehicle been a rental or taxi</label>
                                    <select class="form-control input-sm input-tradein" disabled name="rental_or_taxi">
                                        <option value=""> --Select-- </option>
                                        <option value="1" <?=isset($tradeins->rental_or_taxi) && $tradeins->rental_or_taxi == '1' ? "selected='selected'" : '';?>>Yes</option>
                                        <option value="2" <?=isset($tradeins->rental_or_taxi) && $tradeins->rental_or_taxi == '2' ? "selected='selected'" : '';?>>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Did you buy the car new</label>
                                    <select class="form-control input-sm input-tradein" disabled  name="buy_new_car">
                                        <option value=""> --Select-- </option>
                                        <option value="1" <?=isset($tradeins->buy_new_car) && $tradeins->buy_new_car == '1' ? "selected='selected'" : '';?>>Yes</option>
                                        <option value="2" <?=isset($tradeins->buy_new_car) && $tradeins->buy_new_car == '2' ? "selected='selected'" : '';?>>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Do all options & Accessories work</label>
                                    <select class="form-control input-sm input-tradein" disabled name="all_accessories_work">
                                        <option value=""> --Select-- </option>
                                        <option value="1" <?=isset($tradeins->all_accessories_work) && $tradeins->all_accessories_work == '1' ? "selected='selected'" : '';?>>Yes</option>
                                        <option value="2" <?=isset($tradeins->all_accessories_work) && $tradeins->all_accessories_work == '2' ? "selected='selected'" : '';?>>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Has your vehicle been any accidents</label>
                                    <select class="form-control input-sm input-tradein" disabled name="accidents">
                                        <option value=""> --Select-- </option>
                                        <option value="1" <?=isset($tradeins->accidents) && $tradeins->accidents == '1' ? "selected='selected'" : '';?>>Yes</option>
                                        <option value="2" <?=isset($tradeins->accidents) && $tradeins->accidents == '2' ? "selected='selected'" : '';?>>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Has the vehicle ever had any paint work</label>
                                    <select class="form-control input-sm input-tradein" disabled name="any_paint_work">
                                        <option value=""> --Select-- </option>
                                        <option value="1" <?=isset($tradeins->any_paint_work) && $tradeins->any_paint_work == '1' ? "selected='selected'" : '';?>>Yes</option>
                                        <option value="2" <?=isset($tradeins->any_paint_work) && $tradeins->any_paint_work == '2' ? "selected='selected'" : '';?>>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Estimated payout if finance encumbered</label>
                                    <input type="text" id="estimated_payout" value="<?=isset($tradeins->estimated_payout) ? $tradeins->estimated_payout : '' ?>" disabled name="estimated_payout" class="form-control">
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Please list any options & Accessories</label>
                                    <input type="text" id="" name="additional_notes" value="<?=isset($tradeins->additional_notes) ? $tradeins->additional_notes : '' ?>" class="form-control <?=isset($tradeins->additional_notes) && !empty($tradeins->additional_notes) ? "black_border" : ''?>" required>
                                </div>
                            </div>
                            
                            <div class="clearfix"></div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Please Describe Any Damage or Mechanical Issues</label>
                                    <input type="text" id="" name="damage_or_mechanical_issue" value="<?=isset($tradeins->damage_or_mechanical_issue) ? $tradeins->damage_or_mechanical_issue : '' ?>" class="form-control <?=isset($tradeins->damage_or_mechanical_issue) && !empty($tradeins->damage_or_mechanical_issue) ? "black_border" : ''?>">
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Valuation $</label>
                                    <input type="text" id="valuation" required name="trade_valuation" class="form-control del_input">
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Additional notes</label>
                                    <input type="text" id="" name="additional_notes" class="form-control del_input">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <p></p>

                                <div class="text-center mt-30">

                                    <a href="javascript:void(0)">Terms & Conditions</a>
                                    <br/>
                                    <button type="submit" class="btn btn-green">Submit</button>

                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </section>
        <div id="myModal" class="car_model">
            <span class="close">&times;</span>
            <img class="car_model-content" id="img01">
            <div id="caption"></div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.2/jquery.js?v=<?php echo time();?>"></script>
        <script src="<?php echo base_url('assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js'); ?>?v=<?php echo time();?>"></script>
        <script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.js'); ?>?v=<?php echo time();?>"></script>
        <!-- datepicker -->
        <script src="<?=base_url('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js');?>?v=<?php echo time();?>"></script>
        <!-- Sweet Alert -->
        <script src="<?=base_url('assets/vendor/sweetalert/sweetalert.min.js');?>?v=<?php echo time();?>"></script>
        <script type="text/javascript">

            var car_model = document.getElementById('myModal');

            var car_modelImg = document.getElementById("img01");
            var captionText = document.getElementById("caption");

            $(document).on("click",".car_image",function(){
                car_model.style.display = "block";
                car_modelImg.src = this.src;
                captionText.innerHTML = this.alt;

            });                
            var span = document.getElementsByClassName("close")[0];
            span.onclick = function() { 
                car_model.style.display = "none";
            }

            $(document).ready(function(){
                <?php
                if(isset($tradeins) && !empty($tradeins)){
                    $make = $tradeins->make;
                    $family = $tradeins->family;
                    $rb_data = $tradeins->rb_data;

                    if(!empty($make) && !empty($family)){ ?>

                load_families('start_valuation_car_model', "<?=$make;?>", "<?=$family;?>");

                <?php } if(!empty($make) && !empty($family) && !empty($rb_data)){ ?>

                get_rb_data("<?=$family;?>", "<?=$make;?>", "<?=$rb_data;?>");

                <?php }
                }
                ?>

                <?php if($this->session->flashdata('success') == 'true') { ?>

                swal("SUCCESS", "", "success");

                <?php } if($this->session->flashdata('error') == 'false') { ?>

                swal("ERROR", "An error occurred! Please try again", "error");

                <?php } ?>

            });

            function load_families (container, make_id, family_id = null) {
                //alert();
                if(make_id != "") {

                    $("#vehicle").html("<option value='0'></option>");
                    $("#vehicle").prop("disabled", true);
                    $("#option").html("");

                    if(family_id !== null){ 
                        var data = { 
                            make_id     : make_id,
                            family_id   : family_id
                        };

                    } else {

                        var data = { make_id: make_id };

                    }

                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url("cars/load_families"); ?>",
                        cache: false,
                        data: data,
                        success: function(response){
                            //console.log(response);
                            //$("#family").removeAttr("disabled");
                            $("#family").html("<option value='0'></option>");
                            $("#family").append(response);
                        }
                    });
                }
            }

            function get_rb_data(model, make , car_id = null){

                var temp_ajax_load = 0;

                if(temp_ajax_load==0) {
                    temp_ajax_load = 1;
                    //$(".rb_data_option").html('<option value="" >Fatching Data From Server</option>');
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('Process/getRBdata'); ?>",
                        data:{make:make,model:model,car_id:car_id},//,year:year
                        cache: false,
                        beforeSend: function(){
                            $(".rb_data_option").html('<option value="" >Fatching Data From Server</option>');
                        },
                        success: function(result){
                            $(".rb_data_option").html(result);
                            temp_ajax_load = 0;
                        }
                    });
                } else {
                    alert('Wait For A While');
                }
            }

            $(document).on("change","#family",function(){
                var model = $("#family").val();
                var make = $("#make").val();

                get_rb_data(model, make)

            });
        </script>
    </body>
</html>
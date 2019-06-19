<?php
// echo '<pre>';print_r($makes);exit;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Finquote </title>
        <link rel="stylesheet" href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.css'); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/vendor/font-awesome/css/font-awesome.css'); ?>" />
        <!-- bootstrap datepicker -->
        <link rel="stylesheet" href="<?= base_url();?>assets/vendor/bootstrap-datepicker/css/datepicker3.css">
        <link rel="stylesheet" href="<?= base_url();?>assets/vendor/sweetalert/sweetalert.css">
        
        <!-- Jquery filer css -->
        <link href="<?=base_url();?>assets/vendor/jquery.filer/css/jquery.filer.css" rel="stylesheet" />

        <link rel="shortcut icon" href="<?= base_url();?>assets/img/favicon.png" type="image/x-icon">
        <style type="text/css">
        .black_border{
            border-color:black !important;
        }
        </style>
    </head>
    <body>
        <section class="quote-request-main">
            <div class="container">
                <div class="row">
                    <div class="quote-request-inner">
                        <form method="post" id="frm_add_valuation_client" enctype="multipart/form-data" action="">
                            <div class="col-md-12">
                                <img src="<?php echo base_url('assets/img/finquote.png'); ?>" width="250" height="auto" class="img-responsive" alt="finquote-logo">
                                <div class="text-center">
                                    <h3>Trade Vehicle Details</h3>
                                    <p>Please ensure accurate details are provided and describe anything about the vehicle you think a valuer should be aware of in additional notes.</p>
                                    <p>All vehicle appraisals are subject to inspection.</p>
                                </div>
                                <div class="img-sec" style="margin-top: 10px !important">
                                    <p>Pictures</p>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4">
                                            <h3 class="text-center">Upload Images</h3>
                                            <p class="text-center">Please select quality images of your trade vehicle from your phone or computer.</p>

                                            <div class="form-group">
                                                <div class="text-center">
                                                    <label> Select Photos For Upload </label>
                                                    <input type="file" multiple class="form-control input-sm input-tradein" id="photos" name="photos[]" > <!-- required -->
                                                    <input type="hidden" name="images" id="images">
                                                </div>                                            
                                            </div>

                                        </div>
                                        <div class="col-md-4"></div>
                                    </div>

                                    <div class="clearfix"></div>

                                </div>

                                <p>Trade Summary</p>
                                <hr>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><font color="red">*</font> Make:</label>
                                    <select class="form-control input-sm input-tradein makeclass_tradein <?=isset($tradeins->make) && !empty($tradeins->make) ? "black_border" : ''?>" id="make" name="make" onchange="load_families('start_valuation_modal', this.options[this.selectedIndex].value, 0)" required>
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
                                    <select class="form-control input-sm input-tradein modelclass_tradein <?=isset($tradeins->family) && !empty($tradeins->family) ? "black_border" : ''?>" id="family" name="family" disabled required>
                                        <option value="">
                                            <span class="loader"></span>
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Registration Plate</label>
                                    <input class="form-control input-sm input-tradein <?=isset($tradeins->registration_plat) && !empty($tradeins->registration_plat) ? "black_border" : ''?>" value="<?=isset($tradeins->registration_plat) ? $tradeins->registration_plat : '' ?>" id="registration_plat" name="registration_plat" type="text" required>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Redbook Data</label>
                                    <select class="form-control input-sm input-tradein rb_data_option <?=isset($tradeins->family) && !empty($tradeins->family) ? "black_border" : ''?>" id="rb_data" name="rb_data" required>
                                        <option value="">No Data Found</option>
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Kilometers</label>
                                    <input type="text" id="kilometers" value="<?=isset($tradeins->kilometers) ? $tradeins->kilometers : '' ?>" name="kilometers" class="form-control <?=isset($tradeins->kilometers) && !empty($tradeins->kilometers) ? "black_border" : ''?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Colour</label>
                                    <input type="text" name="colour" value="<?=isset($tradeins->colour) ? $tradeins->colour : '' ?>" id="colour" class="form-control <?=isset($tradeins->colour) && !empty($tradeins->colour) ? "black_border" : ''?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Service History</label>
                                    <select class="form-control input-sm input-tradein <?=isset($tradeins->service_history) && !empty($tradeins->service_history) ? "black_border" : ''?>" name="service_history" required>
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
                                    <input type="text" id="rego_expiry" name="rego_expiry" value="<?=isset($tradeins->rego_expiry) ? $tradeins->rego_expiry : '' ?>" class="form-control <?=isset($tradeins->rego_expiry) && !empty($tradeins->rego_expiry) ? "black_border" : ''?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tyres</label>
                                    <select class="form-control input-sm input-tradein <?=isset($tradeins->tyres) && !empty($tradeins->tyres) ? "black_border" : ''?>" name="tyres" required>
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
                                    <select class="form-control input-sm input-tradein <?=isset($tradeins->dash_warning_lights) && !empty($tradeins->dash_warning_lights) ? "black_border" : ''?>" name="dash_warning_lights" required>
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
                                    <select class="form-control input-sm input-tradein <?=isset($tradeins->windscreen) && !empty($tradeins->windscreen) ? "black_border" : ''?>" name="windscreen" required>
                                        <option value=""> --Select-- </option>
                                        <option value="1" <?=isset($tradeins->windscreen) && $tradeins->windscreen == '1' ? "selected='selected'" : '';?>>Windscreen has no cracks or chips</option>
                                        <option value="2" <?=isset($tradeins->windscreen) && $tradeins->windscreen == '2' ? "selected='selected'" : '';?>>Windscreen has cracks or chips</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Spare Keys</label>
                                    <select class="form-control input-sm input-tradein <?=isset($tradeins->spare_keys) && !empty($tradeins->spare_keys) ? "black_border" : ''?>" name="spare_keys" required>
                                        <option value=""> --Select-- </option>
                                        <option value="1" <?=isset($tradeins->spare_keys) && $tradeins->spare_keys == '1' ? "selected='selected'" : '';?>>2 sets of keys available</option>
                                        <option value="2" <?=isset($tradeins->spare_keys) && $tradeins->spare_keys == '2' ? "selected='selected'" : '';?>>1 sets of keys available</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Paint work </label>
                                    <select class="form-control input-sm input-tradein <?=isset($tradeins->paint_work) && !empty($tradeins->paint_work) ? "black_border" : ''?>" name="paint_work" required>
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
                                    <select class="form-control input-sm input-tradein <?=isset($tradeins->rental_or_taxi) && !empty($tradeins->rental_or_taxi) ? "black_border" : ''?>" name="rental_or_taxi" required>
                                        <option value=""> --Select-- </option>
                                        <option value="1" <?=isset($tradeins->rental_or_taxi) && $tradeins->rental_or_taxi == '1' ? "selected='selected'" : '';?>>Yes</option>
                                        <option value="2" <?=isset($tradeins->rental_or_taxi) && $tradeins->rental_or_taxi == '2' ? "selected='selected'" : '';?>>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Did you buy the car new</label>
                                    <select class="form-control input-sm input-tradein <?=isset($tradeins->buy_new_car) && !empty($tradeins->buy_new_car) ? "black_border" : ''?>"  name="buy_new_car" required>
                                        <option value=""> --Select-- </option>
                                        <option value="1" <?=isset($tradeins->buy_new_car) && $tradeins->buy_new_car == '1' ? "selected='selected'" : '';?>>Yes</option>
                                        <option value="2" <?=isset($tradeins->buy_new_car) && $tradeins->buy_new_car == '2' ? "selected='selected'" : '';?>>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Do all options & Accessories work</label>
                                    <select class="form-control input-sm input-tradein <?=isset($tradeins->all_accessories_work) && !empty($tradeins->all_accessories_work) ? "black_border" : ''?>" name="all_accessories_work" required>
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
                                    <select class="form-control input-sm input-tradein <?=isset($tradeins->accidents) && !empty($tradeins->accidents) ? "black_border" : ''?>" name="accidents" required>
                                        <option value=""> --Select-- </option>
                                        <option value="1" <?=isset($tradeins->accidents) && $tradeins->accidents == '1' ? "selected='selected'" : '';?>>Yes</option>
                                        <option value="2" <?=isset($tradeins->accidents) && $tradeins->accidents == '2' ? "selected='selected'" : '';?>>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Has the vehicle ever had any paint work</label>
                                    <select class="form-control input-sm input-tradein <?=isset($tradeins->any_paint_work) && !empty($tradeins->any_paint_work) ? "black_border" : ''?>" name="any_paint_work" required>
                                        <option value=""> --Select-- </option>
                                        <option value="1" <?=isset($tradeins->any_paint_work) && $tradeins->any_paint_work == '1' ? "selected='selected'" : '';?>>Yes</option>
                                        <option value="2" <?=isset($tradeins->any_paint_work) && $tradeins->any_paint_work == '2' ? "selected='selected'" : '';?>>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Estimated payout if finance encumbered</label>
                                    <input type="text" id="estimated_payout" value="<?=isset($tradeins->estimated_payout) ? $tradeins->estimated_payout : '' ?>" name="estimated_payout" class="form-control <?=isset($tradeins->estimated_payout) && !empty($tradeins->estimated_payout) ? "black_border" : ''?>" required>
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

                            <div class="col-md-12">
                                <p></p>

                                <div class="text-center mt-30">

                                    <a href="javascript:void(0)">Terms & Conditions</a>
                                    <br/>
                                    <button type="submit" class="btn btn-green submitBtn">Submit</button>

                                </div>
                            </div>
                            
                            <input type="hidden" id="rename_file">

                        </form>
                    </div>
                </div>
            </div>
        </section>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.2/jquery.js?v=<?php echo time();?>"></script>
        <script src="<?php echo base_url('assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js'); ?>?v=<?php echo time();?>"></script>
        <script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.js'); ?>?v=<?php echo time();?>"></script>
        <!-- datepicker -->
        <script src="<?=base_url('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js');?>?v=<?php echo time();?>"></script>
        <!-- Sweet Alert -->
        <script src="<?=base_url('assets/vendor/sweetalert/sweetalert.min.js');?>?v=<?php echo time();?>"></script>
        
        <!-- Jquery filer js -->
        <script src="<?=base_url('assets/vendor/jquery.filer/js/jquery.filer.min.js');?>?v=<?php echo time();?>" type="text/javascript"></script>
        
        <script type="text/javascript">
            var photos = {};
            $(document).ready(function(){
                <?php
                if(isset($tradeins) && !empty($tradeins)){
                    $make = $tradeins->make;
                    $family = $tradeins->family;
                    $rb_data = $tradeins->rb_data;

                if(!empty($make) && !empty($family)){ ?>
                load_families('start_valuation_modal', "<?=$make;?>", "<?=$family;?>");

                <?php } if(!empty($make) && !empty($family) && !empty($rb_data)){ ?>

                get_rb_data("<?=$family;?>", "<?=$make;?>", "<?=$rb_data;?>");

                <?php }
                }
                ?>

                <?php if($this->session->flashdata('success') == 'true') { ?>

                swal("SUCCESS", "<?=$this->session->flashdata('msg')?>", "success");

                <?php } if($this->session->flashdata('error') == 'false') { ?>

                swal("ERROR", "An error occurred! Please try again", "error");

                <?php } ?>
                
                $('#photos').filer({
                    limit: 8,
                    maxSize: 3,
                    extensions: ['jpg', 'jpeg', 'png', 'gif'],
                    changeInput: true,
                    showThumbs: true,
                    addMore: true,
                    uploadFile: {
                        url: "<?php echo site_url("Process/upload_img"); ?>",
                        data: null,
                        type: 'POST',
                        enctype: 'multipart/form-data',
                        beforeSend: function(){
                            $('.submitBtn').attr('disabled','disabled');
                        },
                        success: function(data, el){
                            var json = $.parseJSON(data);
                            let name = json['metas'][0]['name'];
                            
                            /*$('#rename_file').val(name);
                            photos.push(name);*/

                            var old_name = json['metas'][0]['old_name'];
                            photos[old_name] = name;
                            
                            var parent = el.find(".jFiler-jProgressBar").parent();
                            el.find(".jFiler-jProgressBar").fadeOut("slow", function(){
                                $("<div class=\"jFiler-item-others text-success\"><i class=\"icon-jfi-check-circle\"></i> Success</div>").hide().appendTo(parent).fadeIn("slow");
                            });

                            $('.submitBtn').removeAttr('disabled');
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
                        //var file = file.name;
                        /*let f_name =  $('#rename_file').val();
                        var file = f_name;*/
                        var filename = file.name.split('.')[0];
                        var f_name = photos[filename];

                        var key = filename;
                        delete photos[key];
                        
                        $.post('<?php echo site_url("Process/remove_file"); ?>', {file: f_name});
                    },
                });
                
                $('#frm_add_valuation_client').submit(function(event) {
                    // let photos = $('#photos').val();
                    
                    if(photos == '') {
                        swal("ERROR", "An error occurred! Please Select Image(s)", "error");
                        return false;
                    }
                    else {
                        
                        var images = JSON.stringify(photos); 
                        $('#images').val(images);

                        /*var input = $("<input>")
                        .attr("type", "hidden")
                        .attr("name", "images").val(photos);
                        $('#frm_add_valuation_client').append(input);*/
                        
                        return true;
                    }
                    
                });

            });

            $('#frm_add_valuation_client input').on('keyup',function() {
                let val = $(this).val();
                if(val != '') {
                    $(this).addClass('black_border');
                }
                else {
                    $(this).removeClass('black_border');
                }
            });

            $('#frm_add_valuation_client select').on('change',function() {
                let val = $(this).val();
                if(val != '') {
                    $(this).addClass('black_border');
                }
                else {
                    $(this).removeClass('black_border');
                }
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
                            $("#family").removeAttr("disabled");
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
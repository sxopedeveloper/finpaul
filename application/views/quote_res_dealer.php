<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Finquote || Add Quote</title>
		<link rel="stylesheet" href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.css'); ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/vendor/font-awesome/css/font-awesome.css'); ?>" />
		<!-- bootstrap datepicker -->
		<link rel="stylesheet" href="<?= base_url();?>assets/vendor/bootstrap-datepicker/css/datepicker3.css">
		<link rel="stylesheet" href="<?= base_url();?>assets/vendor/sweetalert/sweetalert.css">
		<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAtI0BU9BxFm9YavQRG2ShSC5EvJrns4aw&callback=init" type="text/javascript"></script>
		<script type="text/javascript">
			var map;
			var geocoder;
			var postcode = "<?php echo $del_postcode;?>";
			function init() {
				geocoder = new google.maps.Geocoder();				
				var mapOptions = {
					zoom: 11,
					center: new google.maps.LatLng(-33.8498426,150.8835553),
				}
				var mapElement = document.getElementById('map');
				map = new google.maps.Map(mapElement, mapOptions);

				var geocode_pram = {
					componentRestrictions: {
						country: 'AU',
						postalCode: postcode
					}
				};
				
				geocoder.geocode( geocode_pram, function(results, status) {
					if (status == google.maps.GeocoderStatus.OK) {
						map.setCenter(results[0].geometry.location);						
						var marker = new google.maps.Marker({
							map: map,
							position: results[0].geometry.location
						});
					} else {
						console.log('Geocode was not successful for the following reason: ' + status);
					}
				});
			}
            google.maps.event.addDomListener(window, 'load', init);
		</script>
	</head>
	<body>
		<section class="quote-request-main">
			<div class="container">
				<div class="row">
					<div class="quote-request-inner">
						<h3 class="text-center">Quote Request</h3>
            			<form method="post" action="" id="main_form" class="" enctype="multipart/form-data">
							<input type="hidden" name="id_quote_request" value="<?=isset($lead['id_quote_request']) ? $lead['id_quote_request'] : '';?>">
							<div class="col-xs-12 col-sm-6 col-md-8 ">
								<div class="panel panel-heading">
									<div class="form-group">
										<div class="row">
											<div class="col-xs-12 col-md-3">
												<h4 class="text-left">Vehicle</h4>
											</div>
											<div class="col-xs-12 col-md-9">
												<p><?=isset($car_name) ? $car_name : ''; ?></p>
											</div>
										</div>
									</div>
								</div>

								<div class="panel panel-heading quote-notes-text">
									<div class="form-group">
										<div class="row">
											<div class="col-xs-12 col-md-3">
												<h4 class="text-left">Details</h4>
											</div>
											<div class="col-xs-12 col-md-9">
												<p><?=isset($vehicle_detail) ? $vehicle_detail : ''; ?></p>
											</div>
										</div>
									</div>
								</div>
                                
								<div class="panel panel-heading">
									<div class="form-group">
										<div class="row">
											<div class="col-xs-12 col-md-3">
												<h4 class="text-left">Colour</h4>
											</div>
											<div class="col-xs-12 col-md-9">
												<p><?=isset($lead['colour']) ? $lead['colour'] : '';?></p>
											</div>
										</div>
									</div>
								</div>
                                
								<?php
                                if(isset($option) && !empty($option)) {
                                    $string_version = implode(', ', $option);
                                }else{
                                    $string_version = '';
                                }
								?>
                                <div class="panel panel-heading">
									<div class="form-group">
										<div class="row">
											<div class="col-xs-12 col-md-3">
												<h4 class="text-left">Options</h4>
											</div>
											<div class="col-xs-12 col-md-9">
												<p><?=$string_version; ?></p>
											</div>
										</div>
									</div>
								</div>

								<div class="panel panel-heading">
									<div class="form-group">
										<div class="row">
											<div class="col-xs-12 col-md-3">
												<h4 class="text-left">Registration</h4>
											</div>
											<div class="col-xs-12 col-md-9">
												<p><?=isset($lead['registration_type']) ? $lead['registration_type'] : '';?></p>
											</div>
										</div>
									</div>
								</div>
								
								<!-- <div class="panel panel-heading">
									<div class="form-group">
										<div class="row">
											<div class="col-xs-12 col-md-3">
												<h4 class="text-left">Postcode</h4>
											</div>
											<div class="col-xs-12 col-md-3">
												<p><?=isset($del_postcode) ? $del_postcode : '';?></p>
											</div>
										</div>
									</div>
								</div> 

								<h4 class="text-center">Sender <font color="red">*</font></h4>
								<div class="panel panel-heading">
									<div class="form-group">
										<input type="text" name="sender_new" required class="form-control" value="">
									</div>
								</div> 

								<h4 class="text-center">Upload Quote File <font color="red">*</font></h4>
								<div class="panel panel-heading">
                                    <div class="pull-right" style="margin-left:5px">
                                        <button type="button" id="btn_blank" class="btn btn-success btn-xs">Remove</button>
                                    </div>
                                    <div class="input-group">
                                        <input type="file" name="quote_file" id="quote_file" style="color: #fff;" required>
                                    </div>
								</div> -->

                                <!-- <h4 class="text-center">Additional Files</h4>
								<button type="button" class="btn btn-sm btn-primary add_more_button">Add More Fields</button> -->
                                <div id="fields_container" class="panel panel-heading input_fields_container hidden"></div>

							</div>

							<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
								<div class="quote-request-map">
									<div class="map" id="map"></div>
								</div>

								<div class="panel panel-heading">
									<div class="form-group">
										<div class="row">
											<div class="col-xs-12 col-md-3">
												<h4 class="text-left">Postcode</h4>
											</div>
											<div class="col-xs-12 col-md-9">
												<p><?=isset($del_postcode) ? $del_postcode : '';?></p>
											</div>
										</div>
									</div>
								</div>

							</div>

							<div class="row dealer-quote-bottom">
								<div class="col-xs-12 col-md-12">
									<h3 class="text-center">Upload Quote</h3>
									<!-- <h4 class="text-center">Upload Quote File <font color="red">*</font></h4> -->
									<div class="panel panel-heading">
	                                    <div class="pull-right" style="margin-left:5px">
	                                        <button type="button" id="btn_blank" class="btn btn-success btn-xs btn-remove">Remove</button>
	                                    </div>
	                                    <div class="input-group">
	                                        <input type="file" name="quote_file" id="quote_file" onchange="ValidateSingleInput(this);" style="color: #fff;" required>
	                                    </div>
									</div>

									<div class="panel panel-heading quote-right-form">
										<div class="form-group">
											<div class="row">
												<div class="col-xs-12 col-md-3">
													<label class="text-left">Bottom Line Quoted Price</label>
												</div>
												<div class="col-xs-12 col-md-4">
													<input type="text" name="quoted_price" required class="form-control" value="">
												</div>
												<div class="col-xs-12 col-md-2">
													<label class="text-left">Quote On Road</label>
												</div>
												<div class="col-xs-12 col-md-3">
													 <div class="">
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
											</div>
										</div>
									</div>

									<div class="panel panel-heading quote-right-form">
										<div class="form-group">
											<div class="row">
												<div class="col-xs-12 col-md-3">
													<label class="text-left">Estimated Delivery Date</label>
												</div>
												<div class="col-xs-12 col-md-9">
													<input type="text" name="delivery_date" id="estimated_d_d" required class="form-control datepicker_mysql" value="<?=isset($delivery_date) ? $delivery_date : '';?>" placeholder="yyyy-mm-dd">
												</div>
											</div>
										</div>								
									</div>									

									<div class="panel panel-heading quote-notes-text">
										<div class="form-group">
											<div class="row">
												<div class="col-xs-12 col-md-3">
													<label class="text-left">Dealer Notes</label>
												</div>
												<div class="col-xs-12 col-md-9">
													<textarea class="form-control" name="dealer_notes"><?=isset($delivery_notes) ? $delivery_notes : ''; ?></textarea>
												</div>
											</div>
										</div>
									</div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group text-right">
                                            <button type="submit" name="submit_quote" class="btn btn-upload">Submit Quote</button>                                        
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <h4 class="download-link-custom"><a href="<?=base_url();?>index.php/Process/download/accredited_dealer_agreement.pdf">Download Accredited Dealer Agreement &nbsp;<i class="fa fa-download"></i></a></h4>
                                    </div>

								</div>
							</div>

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
		<script type="text/javascript">
			$(document).ready(function(){
                <?php if($this->session->flashdata('success') === true  && $this->session->flashdata('message') != '') { ?>
                    swal("ERROR", "<?= $this->session->flashdata('message') ?>", "error");
                <?php } if($this->session->flashdata('success') === false  && $this->session->flashdata('message') != '') { ?>
                    swal("ERROR", "<?= $this->session->flashdata('message') ?>", "error");
                <?php } ?>
                $('#btn_blank').bind("click",function() { 
                    $('#quote_file').val(''); 
                });
                
                $('.datepicker_mysql').datepicker({
                    format: 'yyyy-mm-dd',
                    todayBtn: "linked",
                    autoclose: true
                });
                
                
                var max_fields_limit      = 6;
                var x = 1;
                $('.add_more_button').click(function(e){
                    e.preventDefault();
                    $("#fields_container").removeClass('hidden');
                    if(x < max_fields_limit){
                        x++;
                        $('.input_fields_container').append('<div style="padding-bottom: 5px;"><div class="pull-right" style="margin-left:5px"><a href="#" class="remove_field" style="margin-left:10px;">Remove</a></div><div class="input-group"><input type="file" name="additional_file[]" id="" style="color: #fff;"></div></div>');
                    }
                });  
                $('.input_fields_container').on("click",".remove_field", function(e){ 
                    e.preventDefault();
                    $(this).parent().parent('div').remove();
                    x--;
                    if(x == 1){
                        $("#fields_container").addClass('hidden');
                    }
                });
                
                $(document).on('submit', '#main_form', function () {
                    var estimated_d_d = $('#estimated_d_d').val();
                    //alert(estimated_d_d);
                    var $valid_date = isValidDate(estimated_d_d);
                    if($valid_date == false){
                        swal("ERROR", "Estimated Delivery Date format is not valid, Please Enter The Date In The Format 'yyyy-mm-dd' !", "error");
                        return false;                            
                    }
                });
			});
            function isValidDate(dateString) {
                  var regEx = /^\d{4}-\d{2}-\d{2}$/;
                  if(!dateString.match(regEx)) return false;  // Invalid format
                  var d = new Date(dateString);
                  if(!d.getTime() && d.getTime() !== 0) return false; // Invalid date
                  return d.toISOString().slice(0,10) === dateString;
            }
            
            var _validFileExtensions = [".pdf", ".jpg", ".jpeg"];
            function ValidateSingleInput(oInput) {
                if (oInput.type == "file") {
                    var sFileName = oInput.value;
                     if (sFileName.length > 0) {
                        var blnValid = false;
                        for (var j = 0; j < _validFileExtensions.length; j++) {
                            var sCurExtension = _validFileExtensions[j];
                            if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                                blnValid = true;
                                break;
                            }
                        }

                        if (!blnValid) {
                            let error_msg = "Sorry, File is invalid, allowed extensions are: " + _validFileExtensions.join(", ");
                            swal("ERROR", error_msg, "error");
                            oInput.value = "";
                            return false;
                        }
                    }
                }
                return true;
            }
            
		</script>        
	</body>
</html>
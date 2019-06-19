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
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAtI0BU9BxFm9YavQRG2ShSC5EvJrns4aw&callback=init" type="text/javascript"></script>
    <script type="text/javascript">
       google.maps.event.addDomListener(window, 'load', init);
        function init() {
            var mapOptions = {
                zoom: 11,
                center: new google.maps.LatLng(-33.8498426,150.8835553)
            };

            var mapElement = document.getElementById('map');
            var map = new google.maps.Map(mapElement, mapOptions);
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(-33.8498426,150.8835553),
                map: map,                
            });
        }
    </script>
</head>
<body>

	<section class="quote-request-main">
		<div class="container">
			<div class="row">
				<div class="quote-request-inner">
					<h3 class="text-center">Quote Request</h3>
					<form method="post" action="" id="" class="">
						<div class="col-xs-12 col-sm-6 col-md-offset-2 col-md-5 col-lg-offset-2 col-lg-5">
							<h4 class="text-center">Vehicle</h4>
							<div class="panel panel-heading">
								<div class="form-group">
									<input type="text" name="vehicle_name" readonly required class="form-control" value="<?=isset($car_name) ? $car_name : ''; ?>">
								</div>
							</div>
							 <?php foreach($car_desc as $key => $val){ ?>
							<div class="panel panel-heading">
								<div class="form-group">
									<input type="text" name="vehicle_type[]" required class="form-control" value="<?php echo $val ?>">
								</div>
							</div>
							<?php } ?>
							<h4 class="text-center">Options</h4>
							<?php foreach($option as $key => $val){ ?>
							<div class="panel panel-heading">
								<div class="form-group">
									<input type="text" name="option[]" required class="form-control" value="<?php echo $val ?>">
								</div>
							</div>
							<?php } ?>
							<h4 class="text-center">Registration</h4>
							<div class="panel panel-heading">
								<div class="form-group">
									<input type="text" name="registration" required readonly class="form-control"  value="<?=isset($lead['registration_type']) ? $lead['registration_type'] : '';?>">
								</div>
							</div>
							<h4 class="text-center">Delivery Postcode</h4>
							<div class="panel panel-heading">
								<div class="form-group">
									<input type="text" name="delivery_post_code" required readonly class="form-control" value="<?=isset($del_postcode) ? $del_postcode : '';?>">
								</div>
							</div>
							<div class="form-group text-center">
								<button type="submit"  name="upload_quote" class="btn btn-upload">Upload Quote</button>
							</div>
						</div>
						
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<div class="quote-request-map">
								<div class="map" id="map"></div>
							</div>
							<div class="panel panel-heading quote-right-form">
								<div class="form-group">
									<label>Delivery Date</label>
									<input type="text" name="delivery_date" id="datepicker1" required class="form-control" value="<?=isset($delivery_date) ? $delivery_date : '';?>">
								</div>								
							</div>
							<div class="panel panel-heading quote-right-form">
								<div class="form-group">
									<label>Quoted Price</label>
									<input type="text" name="final_price" required class="form-control" value="<?=isset($car_price) ? $car_price : '' ;?>">
								</div>
							</div>
							<div class="panel panel-heading quote-notes-text">
								<div class="form-group">
									<label>Dealer Notes</label>
									<textarea class="form-control" name="delivery_notes"><?=isset($delivery_notes) ? $delivery_notes : ''; ?></textarea>
								</div>
							</div>
							<div class="form-group text-center ">
								<button type="submit" name="submit_quote" class="btn btn-upload">Submit</button>
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
<script type="text/javascript">
    $(document).ready(function(){
        $('#datepicker1,#datepicker2,#datepicker3').datepicker({
            format: 'dd-mm-yyyy',
            todayBtn: "linked",
            autoclose: true
        });
    });

</script>
</body>
</html>
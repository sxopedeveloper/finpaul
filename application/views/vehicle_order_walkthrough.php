<?php 
include 'admin/template/login_head.php'; 
?>
	<body>
		<div class="body">
			<?php include 'admin/template/login_header.php'; ?>
			<div role="main" class="main" style="border-top: 5px solid #58c603; padding-top: 40px;">
				<div class="container">
					<div class="row">
						<div class="col-md-12 text-center">
							<br />
							<h5><b>Upon admin's approval of the deal, an email is being sent to the client:</b></h5>
							<p>
								The email to the client contains the Link to the <b>New Order Confirmation Wizard</b> page. 
								<br />
								In cases where the deal has a tradein, the Tradein Document Uploader Link is attached as well.
							</p>
						</div>
						<div class="col-md-3 text-center">	
						</div>
						<div class="col-md-6 text-center">	
							<a href="<?php echo base_url('uploads/screenshots/vehicle_order/order_confirmation_email.png'); ?>" target="_blank">
								<img src="<?php echo base_url('uploads/screenshots/vehicle_order/order_confirmation_email.png'); ?>" style="width: 100%; border: 1px solid #ccc;">
							</a>
						</div>
						<div class="col-md-3 text-center">	
						</div>
						<div class="col-md-12 text-center">
							<br />
							<hr />
							<br />
							<h5><b>New Vehicle Order - Confirmation Wizard (Client's View)</b></h5>
							<p>
								The client checks all the details of the vehicle order and has the ability to update his personal and contact details.
							</p>
						</div>
						<div class="col-md-3">
							<a href="<?php echo base_url('uploads/screenshots/vehicle_order/client_stage_1.png'); ?>" target="_blank">
								<img src="<?php echo base_url('uploads/screenshots/vehicle_order/client_stage_1.png'); ?>" style="width: 100%; border: 1px solid #ccc;">
							</a>
						</div>
						<div class="col-md-3">
							<a href="<?php echo base_url('uploads/screenshots/vehicle_order/client_stage_2.png'); ?>" target="_blank">
								<img src="<?php echo base_url('uploads/screenshots/vehicle_order/client_stage_2.png'); ?>" style="width: 100%; border: 1px solid #ccc;">
							</a>
						</div>
						<div class="col-md-3">
							<a href="<?php echo base_url('uploads/screenshots/vehicle_order/client_stage_3.png'); ?>" target="_blank">
								<img src="<?php echo base_url('uploads/screenshots/vehicle_order/client_stage_3.png'); ?>" style="width: 100%; border: 1px solid #ccc;">
							</a>
						</div>
						<div class="col-md-3">
							<a href="<?php echo base_url('uploads/screenshots/vehicle_order/client_stage_4.png'); ?>" target="_blank">
								<img src="<?php echo base_url('uploads/screenshots/vehicle_order/client_stage_4.png'); ?>" style="width: 100%; border: 1px solid #ccc;">
							</a>						
						</div>
						<div class="col-md-12 text-center">
							<br />
							<br />
							<p>
								If the deal has a tradein, the <b>New Order Confirmation Wizard</b> requires an extra step wherein 
								<br />
								the client checks and confirms the tradein details and answers the trade declaration questions.
							</p>
						</div>	
						<div class="col-md-2 text-center">	
						</div>
						<div class="col-md-8 text-center">
							<a href="<?php echo base_url('uploads/screenshots/vehicle_order/client_tradein.png'); ?>" target="_blank">
								<img src="<?php echo base_url('uploads/screenshots/vehicle_order/client_tradein.png'); ?>" style="width: 100%; border: 1px solid #ccc;">
							</a>
						</div>
						<div class="col-md-2 text-center">	
						</div>	
						<div class="col-md-12 text-center">
							<br />
							<hr />
							<br />
							<p>
								<h5><b>New Vehicle Order - Summary</b></h5>
								<p>
									Once the client has accepted and confirmed the order, he is being redirected to the Order Summary page.
									<br />
									An email is being sent to the dealer notifying them regarding the new order. A notification can be seen 
									on his Dealer Portal as well.
								</p>
							</p>
						</div>	
						<div class="col-md-2 text-center">	
						</div>
						<div class="col-md-8 text-center">
							<a href="<?php echo base_url('uploads/screenshots/vehicle_order/client_order_summary.png'); ?>" target="_blank">
								<img src="<?php echo base_url('uploads/screenshots/vehicle_order/client_order_summary.png'); ?>" style="width: 100%; border: 1px solid #ccc;">
							</a>
						</div>
						<div class="col-md-2 text-center">	
						</div>
						<div class="col-md-12 text-center">
							<br />
							<hr />
							<br />
							<p>
								<h5><b>New Vehicle Order - Confirmation Wizard (Dealer's View)</b></h5>
								<p>
									The dealer is asked to check the vehicle order details and specify the estimated delivery date in order to confirm the deal.
								</p>
							</p>							
						</div>	
						<div class="col-md-4">
							<a href="<?php echo base_url('uploads/screenshots/vehicle_order/dealer_stage_1.png'); ?>" target="_blank">
								<img src="<?php echo base_url('uploads/screenshots/vehicle_order/dealer_stage_1.png'); ?>" style="width: 100%; border: 1px solid #ccc;">
							</a>
						</div>
						<div class="col-md-4">
							<a href="<?php echo base_url('uploads/screenshots/vehicle_order/dealer_stage_2.png'); ?>" target="_blank">
								<img src="<?php echo base_url('uploads/screenshots/vehicle_order/dealer_stage_2.png'); ?>" style="width: 100%; border: 1px solid #ccc;">
							</a>
						</div>
						<div class="col-md-4">
							<a href="<?php echo base_url('uploads/screenshots/vehicle_order/dealer_stage_3.png'); ?>" target="_blank">
								<img src="<?php echo base_url('uploads/screenshots/vehicle_order/dealer_stage_3.png'); ?>" style="width: 100%; border: 1px solid #ccc;">
							</a>
						</div>
					</div>
				</div>
			</div>
			<?php include 'admin/template/login_footer.php'; ?>
		</div>
		<?php include 'admin/template/login_scripts.php'; ?>
	</body>
</html>
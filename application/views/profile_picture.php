<?php $this->load->view('admin/template/head'); ?>
	<body>
		<style type="text/css">
			#add-cc{
				cursor: pointer; 
				cursor: hand;
			}
			#insert_cc{
				cursor: pointer; 
				cursor: hand;	
			}
			.row-input{
				margin-bottom: 10px;
			}
			.panel-cc{
				margin-bottom: 10px;
			}
			.panel-body-cc{
				background-color: #e5e5e5;
			}
			.del_token { 
				cursor: pointer; 
				cursor: hand;
			}
			
			#drop_zone {
				/* width: 50%; */
				border: 2px dashed #BBB;
				border-radius: 5px;
				padding: 25px;
				text-align: center;
				color: #BBB;
			}
			
		</style>	
		<section class="body">
			<!-- start: header -->
			<?php $this->load->view('admin/template/header'); ?>
			<!-- end: header -->
			<div class="inner-wrapper">
				<!-- start: sidebar -->
				<?php $this->load->view('admin/template/left_sidebar'); ?>
				<!-- end: sidebar -->
				<section role="main" class="content-body">
					<?php $this->load->view('admin/template/header_2'); ?>
					<!-- start: page -->					
					<div class="row">
						<!-- .Your image -->
						<div class="col-md-7 p-20">
							<div class="img-container">
								<img id="image" src="<?php echo $user_image; ?>" class="img-responsive"  alt="Picture">
							</div>
						</div>
						<div class="col-md-5 p-20">
							<div id='drop_zone'>
								<form action="#" class='dropzone' id='MyDropzone'></form>
								<input type="hidden" id="cropped" value=""/>
							</div>
							<div class="docs-buttons" style="padding-top: 15px;">
								<div class="btn-group btn-group-crop col-md-12">
									<button id="get_cropped" type="button" class="btn btn-danger btn-block" data-method="getCroppedCanvas"> <span class="docs-tooltip" data-toggle="tooltip" title=""> Crop Image </span> </button>
								</div>
								<!-- Show the cropped image in modal -->
								<div class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" role="dialog" tabindex="-1">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="modal-title" id="getCroppedCanvasTitle">Cropped Image</h4>
											</div>
											<div class="modal-body"></div>
											<div class="modal-footer">
												<a class="btn btn-primary" id="download" href="" onclick="">Set Profile Pic</a>
											</div>
										</div>
									</div>
								</div>
								<!-- /.modal -->
							</div>
						</div>
					</div>
					<!-- end: page -->
	                <div id="payment-insert" class="modal fade" tabindex="-1" role="dialog">
	                    <div class="modal-dialog" role="document">
	                        <div class="modal-content">
	                            <div class="modal-header">
	                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                                <h4 class="modal-title" id="myModalLabel">Add a new Credit Card</h4>
	                            </div>
	                            <div class="modal-body">
	                                <form method="post" id="insert_cc_info" name="insert_cc_info">
	                                    <input type="hidden" id="user_id" value="217" name="user_id">
	                                    <div class="row row-input">
	                                        <div class="col-md-4">
	                                            <label>Title: </label>
	                                        </div>
	                                        <div class="col-md-8">
	                                            <select class="form-control input-sm" id="title" name="title">
	                                                <option value="Mr">Mr</option>
	                                                <option value="Mrs">Mrs</option>
	                                                <option value="Mss">Ms</option>
	                                            </select>
	                                        </div>
	                                    </div>
	                                    <div class="row row-input">
	                                        <div class="col-md-4">
	                                            <label>First Name: </label>
	                                        </div>
	                                        <div class="col-md-8">
	                                            <input type="text" class="form-control input-sm" name="first_name" id="first_name">
	                                        </div>
	                                    </div>
	                                    <div class="row row-input">
	                                        <div class="col-md-4">
	                                            <label>Last Name: </label>
	                                        </div>
	                                        <div class="col-md-8">
	                                            <input type="text" class="form-control input-sm" name="last_name" id="last_name">
	                                        </div>
	                                    </div>
	                                    <div class="row row-input">
	                                        <div class="col-md-4">
	                                            <label>Credit Card Number: </label>
	                                        </div>
	                                        <div class="col-md-8">
	                                            <input type="text" class="form-control input-sm" name="cc_number" id="cc_number" placeholder="Visa or Mastercard only. No spaces and/or dashes">
	                                        </div>
	                                    </div>
	                                    <div class="row row-input">
	                                        <div class="col-md-4">
	                                            <label>Credit Card Type: </label>
	                                        </div>
	                                        <div class="col-md-8">
	                                            <input type="text" class="form-control input-sm" name="card_type" id="card_type" disabled>
	                                        </div>
	                                    </div>
	                                    <div class="row row-input">
	                                        <div class="col-md-4">
	                                            <label>Card Expiry: </label>
	                                        </div>
	                                        <div class="col-md-4">
	                                            <select class="form-control input-sm" id="exp_month" name="exp_month">
	                                                <option value='01'>01</option><option value='02'>02</option><option value='03'>03</option><option value='04'>04</option><option value='05'>05</option><option value='06'>06</option><option value='07'>07</option><option value='08'>08</option><option value='09'>09</option><option value='10'>10</option><option value='11'>11</option><option value='12'>12</option>	                                            </select>
	                                        </div>
	                                        <div class="col-md-4">
	                                            <select class="form-control input-sm" id="exp_year" name="exp_year">
	                                                <option value='16'>16</option><option value='17'>17</option><option value='18'>18</option><option value='19'>19</option><option value='20'>20</option><option value='21'>21</option><option value='22'>22</option><option value='23'>23</option><option value='24'>24</option><option value='25'>25</option><option value='26'>26</option><option value='27'>27</option><option value='28'>28</option><option value='29'>29</option><option value='30'>30</option><option value='31'>31</option><option value='32'>32</option><option value='33'>33</option><option value='34'>34</option><option value='35'>35</option><option value='36'>36</option><option value='37'>37</option><option value='38'>38</option><option value='39'>39</option><option value='40'>40</option><option value='41'>41</option><option value='42'>42</option><option value='43'>43</option><option value='44'>44</option><option value='45'>45</option><option value='46'>46</option><option value='47'>47</option><option value='48'>48</option><option value='49'>49</option><option value='50'>50</option>	                                            </select>
	                                        </div>
	                                    </div>
	                                    <div class="row row-input">
	                                        <div class="col-md-4">
	                                            <label>CVN: </label>
	                                        </div>
	                                        <div class="col-md-8">
	                                            <input type="text" class="form-control input-sm" name="cvn" id="cvn">
	                                        </div>
	                                    </div>
	                                </form>
	                            </div>
	                            <div class="modal-footer">
	                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	                                <span type="button" class="btn btn-primary" id="insert_cc" disabled>Save</span>
	                            </div>
	                        </div>
	                    </div>
	                </div>					
				</section>	
			</div>
			<?php $this->load->view('admin/template/right_sidebar'); ?>
		</section>
		<?php include 'admin/template/scripts.php'; ?>
		<!-- jQuery file upload -->
		<script>
			$(document).ready(function() {
				
				// $('#get_cropped').on('click', function () {
					// alert( $('.cropper-view-box img').attr('src') );
					// $('#cropped').val( $('#download').attr('href') );
				// });
				
				$('#download').on('click', function () {
					var img = $('.cropper-view-box img').attr('src')
					// alert( $('.cropper-view-box img').attr('src') );
					// alert( 'before submit:\n' + img );
				//
					$.ajax({
						url: '<?php echo site_url('profile_picture/update'); ?>',
						data: { image: img },
						type: 'post',
						success: function( result ) {
							
							// alert( 'after submit:\n' + result );
							if( result ){
								alert('Profile pic updated successfully!');
								parent.location.reload();
							}
						}
					});
				//
					event.preventDefault();
					
				});
				
			});
		</script>
</body>
</html>
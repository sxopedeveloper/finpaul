		<!-- Vendor -->
		<script src="<?php echo base_url('assets_login/vendor/jquery/jquery.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets_login/vendor/jquery.appear/jquery.appear.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets_login/vendor/jquery.easing/jquery.easing.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets_login/vendor/jquery-cookie/jquery-cookie.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets_login/vendor/bootstrap/bootstrap.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets_login/vendor/common/common.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets_login/vendor/jquery.validation/jquery.validation.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets_login/vendor/jquery.stellar/jquery.stellar.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets_login/vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets_login/vendor/jquery.gmap/jquery.gmap.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets_login/vendor/isotope/jquery.isotope.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets_login/vendor/owlcarousel/owl.carousel.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets_login/vendor/jflickrfeed/jflickrfeed.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets_login/vendor/magnific-popup/jquery.magnific-popup.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets_login/vendor/vide/vide.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets/vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js'); ?>?v=<?php echo time();?>"></script>

		<script src="<?php echo base_url('assets/vendor/jquery-validation/jquery.validate.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets/vendor/bootstrap-wizard/jquery.bootstrap.wizard.js'); ?>?v=<?php echo time();?>"></script>

		<!-- Dropzone Uploader -->
		<script src="<?php echo base_url('assets/js/image_uploader/dropzone.js'); ?>?v=<?php echo time();?>"></script>
		<script type="text/javascript">
			Dropzone.autoDiscover = false;
		</script>
		
		<!-- Sweet Alert -->
		<script src="<?php echo base_url('assets/vendor/sweetalert/sweetalert.min.js'); ?>?v=<?php echo time();?>"></script>			
		
		<!-- Theme Base, Components and Settings -->
		<script src="<?php echo base_url('assets_login/js/theme.js'); ?>?v=<?php echo time();?>"></script>
		
		<!-- Specific Page Vendor and Views -->
		<script src="<?php echo base_url('assets_login/vendor/rs-plugin/js/jquery.themepunch.tools.min.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets_login/vendor/rs-plugin/js/jquery.themepunch.revolution.min.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets_login/vendor/circle-flip-slideshow/js/jquery.flipshow.js'); ?>?v=<?php echo time();?>"></script>
		<script src="<?php echo base_url('assets_login/js/views/view.home.js'); ?>"></script>
		
		<!-- Theme Custom -->
		<script src="<?php echo base_url('assets_login/js/custom.js'); ?>?v=<?php echo time();?>"></script>
		
		<!-- Theme Initialization Files -->
		<script src="<?php echo base_url('assets_login/js/theme.init.js'); ?>?v=<?php echo time();?>"></script>

		<script type="text/javascript">
			$(document).ready(function(){
				$(document).find("#1").find(".dz-default").append("<span><h4>REGISTRATION PAPERS</h4></span>");
				$(document).find("#2").find(".dz-default").append("<span><h4>PAYOUT LETTER</h4></span>");
				$(document).find("#3").find(".dz-default").append("<span><h4>TRADEIN DECLARATION</h4></span>");
				$(document).find("#4").find(".dz-default").append("<span><h4>PHOTOS OF SPEEDOMETER, BUILD DATE AND COMPLIANCE DATE</h4></span>");
			});
			
			$(document).on('click', '.main_datepicker', function () {
				$(this).toggleClass('clicked').datepicker({format: 'yyyy-mm-dd',}).datepicker('show')
			});
			
			$(document).on('click', '.datepicker_login', function () {
				$(this).toggleClass('clicked').datepicker({format: 'mm/dd/yyyy',}).datepicker('show')
			});

			$(document).on('click', '.date_of_birth', function () {
				$(this).toggleClass('clicked').datepicker({format: 'mm/dd/yyyy',}).datepicker('show')
			});

			$(document).find('#upload_file_1').dropzone ({
				url: '<?php echo site_url('client_upload/upload_tradein_documents'); ?>',
				init: function() {
					this.on("sending", function(file, xhr, formData){
						var id   = $('#hidden_id').val();
						formData.append("tradein_id", id);
						formData.append("type", 1);
					}),
					this.on("success", function(file, response){
						$("#upload_file_1_panel").append("<li><a target='_blank' href='"+response+"'>"+file.name+"</a></li>");
					}),
					this.on("queuecomplete", function () {
						// this.removeAllFiles();
					});
				},
			});

			$(document).find('#upload_file_2').dropzone ({
				url: '<?php echo site_url('client_upload/upload_tradein_documents'); ?>',
				init: function() {
					this.on("sending", function(file, xhr, formData){
						var id   = $('#hidden_id').val();
						formData.append("tradein_id", id);
						formData.append("type", 2);
					}),
					this.on("success", function(file, response){
						$("#upload_file_2_panel").append("<li><a target='_blank' href='"+response+"'>"+file.name+"</a></li>");
					}),
					this.on("queuecomplete", function () {
						// this.removeAllFiles();
					});
				},
			});

			$(document).find('#upload_file_3').dropzone ({
				url: '<?php echo site_url('client_upload/upload_tradein_documents'); ?>',
				init: function() {
					this.on("sending", function(file, xhr, formData){
						var id   = $('#hidden_id').val();
						formData.append("tradein_id", id);
						formData.append("type", 3);
					}),
					this.on("success", function(file, response){
						$("#upload_file_3_panel").append("<li><a target='_blank' href='"+response+"'>"+file.name+"</a></li>");
					}),
					this.on("queuecomplete", function () {
						// this.removeAllFiles();
					});
				},
			});

			$(document).find('#upload_file_4').dropzone ({
				url: '<?php echo site_url('client_upload/upload_tradein_documents'); ?>',
				init: function() {
					this.on("sending", function(file, xhr, formData){
						var id   = $('#hidden_id').val();
						formData.append("tradein_id", id);
						formData.append("type", 4);
					}),
					this.on("success", function(file, response){
						$("#upload_file_4_panel").append("<li><a target='_blank' href='"+response+"'>"+file.name+"</a></li>");
					}),
					this.on("queuecomplete", function () {
						// this.removeAllFiles();
					});
				},
			});

			var root_url = 'http://mytradevaluation.com.au/uploads/';

			$(document).find('#dropzone-image-1').dropzone ({
		        url: '<?php echo site_url('tradein/upload_new_image'); ?>',
		        init: function() {
		            this.on("sending", function(file, xhr, formData){
						var modal_id = $('#modal-id').val();
						formData.append("image_num", this.element.dataset['imageNo']);
						formData.append("image_oldname", this.element.dataset['imageOldname']);
						formData.append("modal_id", modal_id);
					}),
					this.on("success", function(file, response){
						$(document).find(".img-"+this.element.dataset['imageNo']).attr('src','');
						$(document).find(".img-"+this.element.dataset['imageNo']).attr('src',root_url+response);
						$(document).find(".img-"+this.element.dataset['imageNo']).data('img',response);
						$(document).find(".dropzone-image[data-image-no='"+this.element.dataset['imageNo']+"']").data('image-oldname',response);
					}),
					this.on("queuecomplete", function () {
					    this.removeAllFiles();
					});
				},
			});

			$(document).find('#dropzone-image-2').dropzone ({
		        url: '<?php echo site_url('tradein/upload_new_image'); ?>',
		        init: function() {
		            this.on("sending", function(file, xhr, formData){
						var modal_id = $('#modal-id').val();
						formData.append("image_num", this.element.dataset['imageNo']);
						formData.append("image_oldname", this.element.dataset['imageOldname']);
						formData.append("modal_id", modal_id);
					}),
					this.on("success", function(file, response){
						$(document).find(".img-"+this.element.dataset['imageNo']).attr('src','');
						$(document).find(".img-"+this.element.dataset['imageNo']).attr('src',root_url+response);
						$(document).find(".img-"+this.element.dataset['imageNo']).data('img',response);
						$(document).find(".dropzone-image[data-image-no='"+this.element.dataset['imageNo']+"']").data('image-oldname',response);
					}),
					this.on("queuecomplete", function () {
					    this.removeAllFiles();
					});
				},
			});

			$(document).find('#dropzone-image-3').dropzone ({
		        url: '<?php echo site_url('tradein/upload_new_image'); ?>',
		        init: function() {
		            this.on("sending", function(file, xhr, formData){
						var modal_id = $('#modal-id').val();
						formData.append("image_num", this.element.dataset['imageNo']);
						formData.append("image_oldname", this.element.dataset['imageOldname']);
						formData.append("modal_id", modal_id);
					}),
					this.on("success", function(file, response){
						$(document).find(".img-"+this.element.dataset['imageNo']).attr('src','');
						$(document).find(".img-"+this.element.dataset['imageNo']).attr('src',root_url+response);
						$(document).find(".img-"+this.element.dataset['imageNo']).data('img',response);
						$(document).find(".dropzone-image[data-image-no='"+this.element.dataset['imageNo']+"']").data('image-oldname',response);
					}),
					this.on("queuecomplete", function () {
					    this.removeAllFiles();
					});
				},
			});

			$(document).find('#dropzone-image-4').dropzone ({
		        url: '<?php echo site_url('tradein/upload_new_image'); ?>',
		        init: function() {
		            this.on("sending", function(file, xhr, formData){
						var modal_id = $('#modal-id').val();
						formData.append("image_num", this.element.dataset['imageNo']);
						formData.append("image_oldname", this.element.dataset['imageOldname']);
						formData.append("modal_id", modal_id);
					}),
					this.on("success", function(file, response){
						$(document).find(".img-"+this.element.dataset['imageNo']).attr('src','');
						$(document).find(".img-"+this.element.dataset['imageNo']).attr('src',root_url+response);
						$(document).find(".img-"+this.element.dataset['imageNo']).data('img',response);
						$(document).find(".dropzone-image[data-image-no='"+this.element.dataset['imageNo']+"']").data('image-oldname',response);
					}),
					this.on("queuecomplete", function () {
					    this.removeAllFiles();
					});
				},
			});

			$(document).on('click', '.delete-image', function() 
			{
				var that       = $(this);
				var image_name = $(this).closest('.img-div').find('.img-details').data("img");
				var image_num  = $(this).closest('.img-div').find('.img-details').data("img-no");
				var id         = $('#modal-id-2').val();
				
				if($.trim(image_name) == "no_image.png")
					return false;

				if(!confirm("Are you sure you want to delete this image?"))
					return false;

				var data = {
					image_name: image_name,
					id: id,
					image_num: image_num
				};

				$.ajax({
					type: "POST",
					url: "<?php echo site_url("tradein/delete_image"); ?>",
					cache: false,
					data: data,
					success: function(response){
						if(response=="success")
						{
							$(document).find(".img-"+image_num).attr('src','');
							$(document).find(".img-"+image_num).attr('src','http://mytradevaluation.com.au/uploads/no_image.png');
							$(document).find(".img-"+image_num).data('img','no_image.png');
						}
					}
				});
			});
		</script>
		<script>
			(function( $ ) {
				'use strict';

				$('.popup-gallery').magnificPopup({
					delegate: 'a',
					type: 'image',
					tLoading: 'Loading image #%curr%...',
					mainClass: 'mfp-img-mobile',
					gallery: 
					{
						enabled: true,
						navigateByImgClick: true,
						preload: [0,1]
					},
					image: 
					{
						tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
					}
				});
			}).apply( this, [ jQuery ]);

			$(document).ready(function() {
				var image_oldname = "";

				$(document).on("click", ".open-tradeindetails", function(data)
				{
					var root_url = 'http://mytradevaluation.com.au/uploads/';
					var tradein_id = $(this).data("tradein_id");

					$.post('<?php echo site_url("tradein/record"); ?>/' + tradein_id, function(data)
					{
						$("#tradeindetails-modal").find("#id_tradein").html(tradein_id);

						$("#tradeindetails-modal").find("#tradein_details").html(data.tradein_details);
						// $(document).on('click', '.dropzone-image', function() {
						// 	var image_num     = $(this).data("image-no");
						// 	var image_oldname = $(this).data("image-oldname");

						// 	$('#image-no').val(image_num);
						// 	$('#image-oldname').val(image_oldname);
						// 	$('#modal-id').val(tradein_id);
						// });
						
						$(document).find('.dropzone-image').dropzone ({
					        url: '<?php echo site_url('tradein/upload_new_image'); ?>',
					        init: function() {
					            this.on("sending", function(file, xhr, formData){
					            
									var modal_id = tradein_id;

									var image_oldname = $(document).find("#image-oldname-"+this.element.dataset['imageNo']).val();
						
									formData.append("image_num", this.element.dataset['imageNo']);
									formData.append("image_oldname", image_oldname);
									formData.append("modal_id", modal_id);
									//console.log(image_oldname);
								}),
								this.on("success", function(file, response){
									//console.log($(document).find("#image-oldname-"+this.element.dataset['imageNo']).val());
									$(document).find(".img-"+this.element.dataset['imageNo']).attr('src','');
									$(document).find(".img-"+this.element.dataset['imageNo']).attr('src',root_url+response);
									$(document).find(".img-"+this.element.dataset['imageNo']).data('img',response);
									$(document).find("#image-oldname-"+this.element.dataset['imageNo']).val(response);
									//console.log($(document).find("#image-oldname-"+this.element.dataset['imageNo']).val());
								}),
								this.on("queuecomplete", function () {
								    this.removeAllFiles();
								});
							},
						
						});

						var trans_flag = $("#tradeindetails-modal").find(".trans_flag").val();

						if(trans_flag == "1")
							$("#tradeindetails-modal").find(".hidden_div").prop("hidden", false);
						else
							$("#tradeindetails-modal").find(".hidden_div").prop("hidden", true);

						$('#modal-id-2').val(tradein_id);
						$("#tradeindetails-modal").modal({
							backdrop: 'static',
							keyboard: false
						});
					}, "json");
				});


				$(document).ready(function(){
			    	$(document).on('click','#pickup_time',function(){
						var time = $('#pickup_time').timepicker('showWidget');
			    	});

			    	$(document).on('click', '#pickup_date', function () {
				        $(this).toggleClass('clicked').datepicker().datepicker('show')
				    });

				    // $(document).on('click', '.payment_due', function () {
				    //     $(this).toggleClass('clicked').datepicker().datepicker('show').datepicker("setDate", new Date());
				    // });
				});

				$(document).on('click', '.delete-image', function() 
				{
					var that       = $(this);
					var image_name = $(this).closest('.img-div').find('.img-details').data("img");
					var image_num  = $(this).closest('.img-div').find('.img-details').data("img-no");
					var id         = $('#modal-id-2').val();
					
					if( $.trim(image_name) == "no_image.png" )
						return false;

					if( !confirm("Are you sure you want to delete this image?") )
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
								$(document).find("#image-oldname-"+image_num).val('no_image.png');
							}
						}
					});
				});

				$(document).on('change', '.contact_type', function(){ 
					var type = $(this).val();
					var lead_id = $("#hidden_lead_id_tradein").val();
					var this_modal = $("#tradeindetails-modal");

					var data = {
						type: type,
						lead_id: lead_id
					};

					$.ajax({
						type: "POST",
						url: "<?php echo site_url("tradein/get_contact_details"); ?>",
						cache: false,
						dataType: 'json',
						data: data,
						success: function(data){
							
							if(type == 1 && data.flag == 1)
							{
								$(this_modal).find(".contact_name").val(data.dealership_name);
								$(this_modal).find(".contact_number").val(data.dealer_mobile);
								$(this_modal).find(".pickup_address").val(data.dealer_address + ", " + data.dealer_state + " " + data.dealer_postcode);
							}
							else if(type == 2 && data.flag == 1)
							{
								$(this_modal).find(".contact_name").val(data.name);
								$(this_modal).find(".contact_number").val(data.mobile);
								$(this_modal).find(".pickup_address").val(data.address + ", " + data.state + " " + data.postcode);
							}
							else
							{
								$(this_modal).find(".contact_name").val("");
								$(this_modal).find(".contact_number").val("");
								$(this_modal).find(".pickup_address").val("");
							}

						}
					});
				});
			});

			<?php 
			if ($login_type=="Admin")
			{
				?>
				function save_tradein_info ()
				{
					var id_tradein = $("#tradeindetails-modal").find("#id_tradein").val();
					var tradein_value = $("#tradeindetails-modal").find("#tradein_value").val();
					var tradein_given = $("#tradeindetails-modal").find("#tradein_given").val();
					var tradein_payout = $("#tradeindetails-modal").find("#tradein_payout").val();
					$.ajax({
						type: "POST",
						url: "<?php echo site_url('tradein/update_record'); ?>",
						data: $("#tradein_form").serialize(),
						cache: false,
						success: function(result){
							$("#lead-modal").find("#tradein_value_"+id_tradein).html(tradein_value);
							$("#lead-modal").find("#tradein_given_"+id_tradein).html(tradein_given);
							$("#lead-modal").find("#tradein_payout_"+id_tradein).html(tradein_payout);
							$("#tradeindetails-modal").modal("hide");
						}
					});
				}

				$(document).on("click", ".open-tradeinvaluations", function(data)
				{
					var tradein_id = $(this).data("tradein_id");
					$.post('<?php echo site_url("tradein/valuations"); ?>/' + tradein_id, function(data)
					{
						$("#tradeinvaluations-modal").find("#id_tradein").val(tradein_id);
						$("#tradeinvaluations-modal").find("#tradein_valuations").html(data.tradein_valuations);
						$("#tradeinvaluations-modal").modal();
					}, "json");
				});

				$(document).on("click", ".open-addvaluation", function(data)
				{
					var tradein_id = $(this).data("tradein_id");

					$.ajax({
						type: "POST",
						url: "<?php echo site_url("user/get_suggested_wholesalers"); ?>",
						cache: false,
						success: function(result){
							$("#entervaluation-modal").find("#id_tradein").val(tradein_id);
							$("#wholesaler_dropdown").html("");
							$("#wholesaler_dropdown").append(result);
							$("#entervaluation-modal").modal();
						}
					});
				});

				$(document).on("click", ".open-sendpdf", function(data)
				{
					var tradein_id = $(this).data("tradein_id");
					var state = $(this).data("state");
					
					$.post('<?php echo site_url("tradein/pdf_recipients"); ?>/' + tradein_id, function(data)
					{
						$("#sendpdf-modal").find("#id_tradein_sp").val(tradein_id);
						$("#sendpdf-modal").find("#pdf_recipients").html(data.pdf_recipients);

						$("#sendpdf-modal").find(".email_text_panel").prop("hidden",true);
						$("#sendpdf-modal").find(".multi_email_panel").prop("hidden",false);

						$("#sendpdf-modal").find("#selected_wholesalers").html("");
						$("#state_filter").val(state);
						state_filter(state);

						$("#sendpdf-modal").modal();
					}, "json");					
				});

				$(".email_method_radio").change(function (){
					var flag = $(this).val();

					if (flag == 1)
					{
						$("#sendpdf-modal").find(".email_text_panel").prop("hidden",false);
						$("#sendpdf-modal").find(".multi_email_panel").prop("hidden",true);
					}
					else if (flag == 2)
					{
						$("#sendpdf-modal").find(".email_text_panel").prop("hidden",true);
						$("#sendpdf-modal").find(".multi_email_panel").prop("hidden",false);
					}
				});

				$(document).on("change", "#state_filter", function(){
					var state = $(this).val();

					state_filter(state);
				});

				function state_filter(state)
				{
					var data = {
						state: state
					}

					$.ajax({
						type: "POST",
						url: "<?php echo site_url("tradein/suggested_wholesalers"); ?>",
						data: data,
						cache: false,
						success: function(result){
							$("#sendpdf-modal").find("#suggested_wholesalers").html(result);
						}
					});
				}

				$(document).on("click", ".select_wholesaler", function(){
					var id = $(this).data("id");
					var email = $(this).data("email");
					var name = $(this).data("name");

					$("#sendpdf-modal").find("#selected_wholesalers").append('<tr class="wholesaler_email_piece" data-id="'+id+'" data-email="'+email+'"><td width="40%">'+name+'</td><td width="40%">'+email+'</td><td><center><span style="cursor: pointer; cursor: hand; color: #58c603;" class="remove_wholesaler_email" ><i class="fa fa-times"></i></span></center></td></tr>');	
				});

				$(document).on("click", ".remove_wholesaler_email", function(){
					$(this).closest(".wholesaler_email_piece").remove();
				});


				function submit_pdf ()
				{
					var flag = null;

					$(".email_method_radio").each(function(index, value){
						var this_status = $(this).prop("checked");

						if(this_status == true)
							flag = $(this).val();
					});

					if(flag == 1)
					{
						var email = $("#ti_email").val();
						var id_tradein = $("#id_tradein_sp").val();
						var dataString = "&email="+email;
						if (email.length == 0) 
						{
							alert ("Please enter an email address!");
						}
						else
						{
							$("#ti_email").val("");
							$("#sendpdf_loader").show();
							$("#sendpdf_loader").fadeIn(400).html("Sending...");
							$.ajax({
								type: "POST",
								url: "<?php echo site_url("tradein/submit_pdf"); ?>" + "/" + id_tradein + "/",
								data: dataString,
								cache: false,
								success: function(result){
									$("#sendpdf_loader").hide();

									if($(document).find(".no_recipient").length > 0)
										$("#pdf_recipients").html("");

									$("#pdf_recipients").append("<tr><td>"+email+"</td></tr>");
								}
							});
						}
					}
					else
					{
						var email_array = [];
						var id_tradein = $("#id_tradein_sp").val();

						if($("#sendpdf-modal").find(".wholesaler_email_piece").length > 0)
						{
							$("#sendpdf-modal").find(".wholesaler_email_piece").each(function(index){
								var email = $(this).data("email");
								email_array.push(email);
							});

							var data = {
								id_tradein: id_tradein,
								email_array: email_array
							};

							$.ajax({
								type: "POST",
								url: "<?php echo site_url("tradein/initialize_submit_pdf_modal"); ?>",
								data: data,
								cache: false,
								success: function(result){
									$("#sendpdf_loader").hide();

									if($(document).find(".no_recipient").length > 0)
										$("#pdf_recipients").html("");
									
									email_array.each(function(index, value){
										$("#pdf_recipients").append("<tr><td>"+value+"</td></tr>");
									});
								}
							});
						}
					}
				}

				function select_trade_winner (id_tradein, id_trade_valuation)
				{
					var dataString = "&id_tradein="+id_tradein+"&id_trade_valuation="+id_trade_valuation;
					var winning_buyer = $("#ti_buyer_modal_"+id_trade_valuation).html();
					var winning_value = $("#ti_trade_value_modal_"+id_trade_valuation).html();

					$("#selecttrade_loader").show();
					$("#selecttrade_loader").fadeIn(400).html("Sending...");
					$.ajax({
						type: "POST",
						url: "<?php echo site_url('tradein/select_winner'); ?>",
						data: dataString,
						cache: false,
						success: function(result){
							$("#selecttrade_loader").hide();
							$("#ti_buyer_"+id_tradein).html(winning_buyer);
							$("#ti_trade_value_"+id_tradein).html(winning_value);
							$("#tradeinvaluations-modal").modal("hide");
						}
					});					
				}

				function delete_tradeins ()
				{
					if (confirm("Are you sure you want to delete this Trade?")) 
					{			
						var checkbox_values = [];

						$('input[type="checkbox"]:checked').each(function(index, elem) {
							checkbox_values.push($(elem).val());
						});

						var tradein_ids = checkbox_values.join(',');
						var tradein_id_arr = tradein_ids.split(',');
						var tradein_count = tradein_id_arr.length;				
						var dataString = "&tradein_ids="+tradein_ids;

						$("#delete_tradein_loader").show();
						$("#delete_tradein_loader").fadeIn(400).html("Sending...");
						$.ajax({
							type: "POST",
							url: "<?php echo site_url("tradein/delete"); ?>",
							data: dataString,
							cache: false,
							success: function(result){
								$("#delete_tradein_loader").hide();
								var tradein_index = 0;
								while (tradein_index < tradein_count) 
								{
									$("#tradein_row_"+tradein_id_arr[tradein_index]).remove();
									tradein_index++;
								}
							}
						});
					}
				}				
				<?php
			}
			else
			{
				?>
				$(document).on("click", ".open-entervaluation", function(data)
				{
					var tradein_id = $(this).data("tradein_id");
					$.post('<?php echo site_url("tradein/valuation"); ?>/' + tradein_id, function(data)
					{
						$("#entervaluation-modal").find("#id_tradein").val(tradein_id);
						$("#entervaluation-modal").find("#entered_value").val(data.entered_value);
						$("#entervaluation-modal").modal();
					}, "json");
				});
				<?php
			}
			?>

			function submit_valuation ()
			{
				var id_tradein = $("#entervaluation-modal").find("#id_tradein").val();
				var tradein_value = $("#entervaluation-modal").find("#entered_value").val();
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('tradein/submit_valuation'); ?>",
					data: $("#entervaluation_form").serialize(),
					cache: false,
					success: function(result){
						$("#ti_my_valuation_"+id_tradein).html(tradein_value);
						$("#entervaluation-modal").modal("hide");
					}
				});
			}
		</script>
<?php include 'template/head.php'; ?>
<body>
		<section class="body">
			
			<?php //include 'template/header.php'; ?>
			
				<?php //include 'template/left_sidebar.php'; ?>
				<section role="main" class="content-body">
					<?php //include 'template/header_2.php'; ?>
					<!-- start: page -->
					<section class="panel dealer-modal-main">
		
						<div class="panel-body dealer-modal-main">
							<form id="dealer_main_form" action="#" method="post">
								<input type="hidden" name="dealer_id" value="<?php echo $id_dealer; ?>">
								<?php echo $dealer_details; ?>
							</form>
						</div>
					</section>
					<!-- end: page -->
					<?php //include 'modals/ticket_modals.php'; ?>
				</section>
			
			<?php //include 'template/right_sidebar.php'; ?>
		</section>
		<?php include 'template/scripts.php'; ?>
		<?php //include 'js/fapplication_scripts.php'; ?>
		<script>
			$(function(){

				$("#dealership_brand").select2();
				$("#dealership_states").select2();

			});
			function save_front_dealer_info ()
			{	
				$("input.form-control").attr("required",true);
				$(".contact-input").each(function(i,v){
					if(i<=4 && i>0)
					{
						$(v).attr("required",false);
					}
				});

				if($("#dealer_main_form").valid())
				{
					$.ajax({
						type: "POST",
						url: "<?php echo site_url('account/update_front_dealer_profile'); ?>",
						data: $("#dealer_main_form").serialize(),
						cache: false,
						success: function(result){
							//return false;
							$(location).attr("href","<?php echo base_url(); ?>");
						}
					});
				}
			}
			function addContactFront()
			{
				$("input.form-control").attr("required",false);
				
				var error = 0;
				$(".contact-input").each(function(i,v){
					if(i<=4 && i>0)
					{
						$(v).attr("required",true);
						if($(v).hasClass('error') || !$(v).val())
						{
							error++;
						}
					}
				});
				
				$("#dealer_main_form").valid();
				var d = new Date();
				var n = d.getMilliseconds();
				var x = Math.floor((Math.random()*(n/2)) + 1);
				n = "" + n + x;
	    		var div_id = "data_"+n;
	    		var contact_data = '';
	    		var checkbox_input_name = "primary_contact["+n+"]";
	    		var primary_contact_keys = ["quote_request_recipient","new_vehicle_tax_invoice_request_recipient","recipient_of_settlement_remittance_advice","introducer_tax_invoice_recipient"];
	    		contact_data += '<input type="hidden" name="contact_id[]" value="'+n+'"><div class="dealer-input-check"><span class="primary-contact">Primary Contact</span>';

	    		for (i = 0; i < primary_contact_keys.length; i++) {
	    			var contact_key = primary_contact_keys[i]+n;
	    			var contact_key_name = primary_contact_keys[i].split('_').join(' ');
	    			//contact_key_name = contact_key_name.toUpperCase();
	    			contact_key_name = contact_key_name.toLowerCase().replace(/\b[a-z]/g, function(letter) {
					    return letter.toUpperCase();
					});
				    contact_data += '<input type="checkbox" class="check-new-one in-check" id="'+contact_key+'" name="'+checkbox_input_name+'['+i+']" required=""><label for="'+contact_key+'" data-toggle="tooltip" data-placement="top" title="" data-original-title="'+contact_key_name+'"><span class="border-span"><i class="fa fa-check" aria-hidden="true"></i></span></label>';
				}
				contact_data += "</div>";
	  
	    		contact_data += '<div class="form-group"><div class="dealer-detail-form-group"><span>Title</span><input type="text" name="contact_title[]" id="contact_title'+n+'" class="form-control pull-right"></div></div><div class="form-group"><div class="dealer-detail-form-group"><span class="require-field">Full Name</span><input type="text" name="contact_fullname[]" id="contact_fullname'+n+'" class="form-control pull-right"  required=""></div></div><div class="form-group"><div class="dealer-detail-form-group"><span class="require-field">Email = Username</span><input type="email" name="contact_email[]" id="contact_email'+n+'" class="form-control pull-right" required=""></div></div><div class="form-group"><div class="dealer-detail-form-group"><span>Mobile</span><input type="text" data-rule-number="true" name="contact_mobile[]" id="contact_mobile'+n+'" class="form-control pull-right"></div></div><div class="form-group"><div class="dealer-detail-form-group"><span>Landline</span><input type="text" data-rule-number="true" name="contact_landline[]" id="contact_landline'+n+'" class="form-control pull-right"></div></div>';

	    		var button = '<div class="form-group text-right"><button type="button" name="delete_contact" id="" class="btn btn-danger" data-id="'+div_id+'" onclick="deleteContact('+"'"+div_id+"'"+')">Delete</button></div> <hr/>';
	  		
		    	if(error==0)
		    	{
		    		var clone_div = "<div id='"+div_id+"'></div>";
		    		$("#dealer_contacts").append(clone_div);
		    		$("#"+div_id).append(contact_data);
		    		//$("#dealer_contact_form").children().clone(true,true).appendTo("#"+div_id);
		    		$("#"+div_id).append(button);
		    		
		    		$(".contact-input").each(function(i,v){
						if(i<=4 && i>0)
						{
							$(v).val('');
							$(v).attr("required",false);
						}
					});
		    	}
		    	else
		    	{
		    		//alert("hello");
		    	}
		    	$("[data-toggle='tooltip']").tooltip();
			}
			function deleteContact(div_id)
			{	
		    	$("#"+div_id).remove();
			}
		</script>
	</body>
</html>
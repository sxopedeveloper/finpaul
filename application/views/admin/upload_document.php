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
							<div class="col-md-6 col-md-offset-3">
								<form id="dealer_main_form" action="#" method="post">
									<input type="hidden" name="dealer_id" value="<?php echo $id_dealer; ?>">
									<div class="form-group">
									    <label for="file">Upload Document:</label>
									    <input type="file" name="document" class="form-control" >
									  </div>
									  <br>
									<button type="submit" class="btn btn-success pull-right">Submit</button>
								</form>
							</div>
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
					if(i<=4)
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
							//$(location).attr("href","<?php echo base_url(); ?>");
						}
					});
				}
			}
			function addContactFront()
			{
				$("input.form-control").attr("required",false);
				
				var error = 0;
				$(".contact-input").each(function(i,v){
					if(i<=4)
					{
						$(v).attr("required",true);
						if($(v).hasClass('error') || !$(v).val())
						{
							error++;
						}
					}
				});
				
				$("#dealer_main_form").valid();
				var contact_data; 
		    	var d = new Date();
				var n = d.getMilliseconds();
		    	
	    		contact_data = $("#dealer_contact_form").clone();
	    		
	    		var div_id = "data_"+n;
	    		
	    		var button = '<div class="form-group text-right"><button type="button" name="delete_contact" id="delete_contact" class="btn btn-danger" div_id="'+div_id+'" onclick="deleteContact("'+div_id+'")">Delete</button></div> <hr/>';
	  		
		    	if(error==0)
		    	{
		    		var clone_div = "<div id='"+div_id+"'></div>";
		    		$("#dealer_contacts").append(clone_div);
		    		$("#dealer_contact_form").children().clone(true,true).appendTo("#"+div_id);
		    		$("#"+div_id).append(button);
		    		
		    		$(".contact-input").each(function(i,v){
						if(i<=4)
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
			}
			function deleteContact(div_id)
			{
		    	$("#"+div_id).remove();
			}
		</script>
	</body>
</html>
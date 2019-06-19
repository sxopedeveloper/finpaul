<script src="http://staging-new.finquote.com.au/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js?v=<?php echo time();?>"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#datepicker1,#datepicker2,#datepicker3').datepicker({
            format: 'dd-mm-yyyy',
            todayBtn: "linked",
            autoclose: true
        });
        $('#datepicker3').datepicker('setDate', 'today');
        //Timepicker
	    $('.timepicker').timepicker({
	      	showInputs: false
	    });

	    $('.datepicker_mysql').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: "linked",
            autoclose: true
        });

	 		$('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
        
            autoclose: true
        });

        $('.datepicker_mysql').datepicker('setDate', 'today');

    });

</script>
<script type="text/javascript">	
		$("#form_save_submit").on("click",function(e) { // Reload //
			//console.log("mm - fapplication.php - 1527");
			var make = $("#start_tender_form").find("#make").val();
			var family = $("#start_tender_form").find("#family").val();
			var build_date = $("#start_tender_form").find("#build_date").val();
			var vehicle = $("#start_tender_form").find("#vehicle").val();
			var colour = $("#start_tender_form").find("#colour").val();
			var registration_type = $("#start_tender_form").find("#registration_type").val();
			var rb_data =  $("#start_tender_form").find("#rb_data").val();

			var id_lead =  $("#start_tender_form").find("#id_leads").val();

            var other_data = $('#fapplication_main_form').serializeArray();

            var newArr = ['new_lead_name','new_lead_surname','new_lead_number','new_lead_email_address','new_lead_address','new_lead_postcode','new_lead_dl_no','new_lead_credit_card','new_lead_card_no','new_lead_exp_date','new_lead_cvv_no','new_lead_deposit_amt','newLead_car_year','newLead_make','newLead_model','newLead_car_variant','new_lead_redbook_url','new_lead_sale_price','new_lead_winning_quote','new_lead_winning_trade','new_lead_gross_margin','new_lead_delivery_date','new_lead_dealer','new_lead_wholesaler'];
		    
		    /* main application form data */
		    $.each(other_data,function(key,input){
		    	if(jQuery.inArray(input.name, newArr) != -1) {
		    		let input11 = $("#fapplication_main_form").find(':input[name="'+input.name+'"]');
		    		if($(input11).is('select')) {
		    			$("#fapplication_main_form").find(':input[name="'+input.name+'"]').clone().appendTo("#start_tender_form").css('visibility','hidden');
		    		}
		    		else if($(input11).is('input:text')) {
		    			$("#fapplication_main_form").find(':input[name="'+input.name+'"]').clone().appendTo("#start_tender_form").attr('type','hidden');
		    		}
		        }
		    });
			
			if (rb_data == "" || rb_data == 0 ||  make == 0 || make == "" || family == 0 || family == "" || colour == "" || registration_type == "")
			{
				swal("ERROR", "Please complete all the required fields!", "error");
			}
			else
			{
				let id_lead = $("#start_tender_modal").find("#id_leads").val();
				let email_template_id = $("#start_tender_modal").find("#email_template_id").val();
				let note = $("#start_tender_modal").find("#email_paragraph").val();
				let accessory = $("#start_tender_modal").find('input[name="accessory_name[]"]').val();
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('fapplication/start_tender_new_save'); ?>",
					data: $("#start_tender_form").serialize(),
					cache: false,
					success: function(response) {
						//console.log(response); 
						var res = response.trim();
						if (res === "success" || res === "successsuccess")
						{
							$("#start_tender_modal").find("#selected_dealers").html("");
							$("#start_tender_modal").find("#suggested_dealers").html("");
							$("#start_tender_modal").find("input,textarea,select").val("");
							$("#start_tender_modal").find("#dealer_ids_inp").val("0");
							$("#start_tender_modal").modal("hide");

							// swal("SUCCESS", "", "success");
							// location.reload(true);
							swal({
					            title: "SUCCESS",
					            text: "",
					            type: "success"
					        }, function() {
					        	$("#start_tender_modal").find("#id_leads").val(id_lead);
					        	$("#start_tender_form").find("#email_template_id").val(email_template_id);
					        	$("#start_tender_form").find("#email_paragraph").val(note);
					        	// $("#start_tender_modal").find('input[name="accessory_name[]"]').val(accessory);

					        	setTimeout(function() {
									/**/
					        		var make_text = $("#start_tender_form").find("#make option:selected").text();
					        		$('#newLead_make').val(make_text);
									var family_text = $("#start_tender_form").find("#family option:selected").text();
									var reg_text = $("#start_tender_form").find("#registration_type option:selected").text();
									var rb_data_text = $("#start_tender_form").find("#rb_data option:selected").text();
									var color_text = $("#start_tender_form").find("#colour").val();
									$('#fapplication_summary_new #newLead_make').change();
									setTimeout(function() {
										$('#newLead_model').val(family_text);
									},2500);
									$('#make_ds').text(make_text);
									$('#model_ds').text(family_text);
									$('#reg_ds').text(reg_text);
									$('#color_ds').text(color_text);
									$('#rb_data_ds').text(rb_data_text);
						        	/**/
					        	}, 2500);


					        	get_car_lead(id_lead,'start_tender_modal');
					        	get_accessories(id_lead);
								load_dealer_selector_parameters("start_tender_modal", id_lead, "tender");
							    get_system_email_template_start_tender();
							    $("#start_tender_modal").modal();
					        });
						}
						else
						{
							swal("ERROR", "An error occurred! Please contact the administrator", "error");
						}							
					}
				});
			}
			e.preventDefault();
		});

		$('#start_tender_modal').on('.hidden.bs.modal', function() {
			$('#accessory_container').html('');
		});

		function rbgetdata(mdl_name = '',make,model, year)
		{
			var temp_ajax_load = 0;
		
			//var model = $("#"+mdl_name+" .modelclass").val();
			//var make = $("#"+mdl_name+' .makeclass').val();
			//var year = $('.builddtclass').val();
			if(mdl_name!='' && temp_ajax_load==0){
				temp_ajax_load = 1;
				$("#"+mdl_name+' .rb_data_option').html('<option value="" >Fatching Data From Server</option>');
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('fapplication/getRBdata'); ?>",
					data:{make:make,model:model},//,year:year
					cache: false,
					success: function(result){
						$("#"+mdl_name+' .rb_data_option').html(result);
						temp_ajax_load = 0;
					}
				});
			}
			else
			{
				alert('Wait For A While');
			}
		}
		$(document).ready(function(){	
			$(document).on("change","#edit_tender_form #family",function(){
				var model = $("#edit_tender_form #family").val();
				var make = $("#edit_tender_form #make").val();
				rbgetdata("edit_tender_form",make,model,0);//edit_tender_form
			});
            
            $(document).on("change","#start_valuation_form #family",function(){
				var model = $("#start_valuation_form #family").val();
				var make = $("#start_valuation_form .makeclass_tradein").val();
                rbgetdata("start_valuation_form",make,model,0);//edit_tender_form
			});
            
			/*$(document).on("change","#edit_tender_form #build_date",function(){
				var model = $("#edit_tender_form #family").val();
				var make = $("#edit_tender_form #make").val();
				var year = $("#edit_tender_form #build_date").val();
				rbgetdata("edit_tender_form",make,model,year)//edit_tender_form
			});*/
			
			
			$(document).on("change","#start_tender_form .modelclass",function(){
				var model = $("#start_tender_form .modelclass").val();
				var make = $("#start_tender_form .makeclass").val();
				rbgetdata("start_tender_form",make,model,0);//edit_tender_form
			});
			/*$(document).on("change","#start_tender_form .builddtclass",function(){
				var model = $("#start_tender_form .modelclass").val();
				var make = $("#start_tender_form .makeclass").val();
				var year = $("#start_tender_form .builddtclass").val();
				rbgetdata("start_tender_form",make,model,year)//edit_tender_form
			});*/
			
			
			$(document).on("click",".delete_contact",function(){
				var div_ids = $(this).data("id");
				$("#"+div_ids).remove();
			});	
			$(document).on("click",".delete_dealer",function(){
				var dealer_id = $(this).data("id");
				if (confirm("Are you sure you want to delete this Dealer?")) 
					{				
						$.ajax({
							type: "POST",
							url: "<?php echo site_url('account/delete'); ?>/" + dealer_id,
							cache: false,
							success: function(result){
								$("#dealer_row_"+dealer_id).remove();
							}
						});
					}
			});
			
			// Re-tender
			$(document).on("click",".restart_tender_button",function(e){
					var id_lead = $(this).data("id_lead");
					var data = {id_lead: id_lead,status: 1};//3 re to pre							
					$.ajax({
						type: "POST",
						url: "<?php echo site_url("lead/update_record"); ?>",
						data: data,
						cache: false,
						success: function(response){
							if (response === "success"){
								swal("SUCCESS", "", "success");
								location.reload(true);
							}						
							else{
								swal("ERROR", "An error occurred! Please try again", "error");
							}
						}
					});				
					e.preventDefault();
				});
				//pre tender
			$(document).on("click",".pretender_button",function(e) { // Reload //
				var id_lead = $(this).data("id_lead");
				var data = {id_lead: id_lead,status: 10};				
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("lead/update_record"); ?>",
					data: data,
					cache: false,
					success: function(response){
						if (response === "success"){
							swal("SUCCESS", "", "success");
							location.reload(true);
						}						
						else{
							swal("ERROR", "An error occurred! Please try again", "error");
						}
					}
				});				
				e.preventDefault();
			});
			$(document).on("click", ".open-editdealer", function(data){ 
				var dealer_id = $(this).data("dealer_id");
				$.post("<?php echo site_url("account/dealer"); ?>/" + dealer_id, function(data){
					$(".full_loaderde").hide();
					$("#dealer_id").val(data.id_dealer);
					//alert("55");
					$("#dealer_details").html(data.dealer_details);
					$("#dealer_actions").html(data.dealer_actions);

					$("#dealership_brand").select2();
					$("#dealership_states").select2();

					$("#dealer_modal").modal();
				}, "json");
			});
			$(document).on("keyup change",".address_inp",function(){ 
				if( $(this).val()=="")
				{ $(this).removeClass("hide_show_text");}
				else
				{ $(this).addClass("hide_show_text");}	
			});
			$(document).on('change', '#fapplication_summary_new #newLead_make', function() {
			var selected = $(this).find('option:selected'); 
			var logo = selected.val();
			logo = logo.toLowerCase();
			logo = logo.trim();
			logo = logo.replace(/\s/g, '') ;
			if(logo=='')
			{$('#companylogo').hide()}
			else
			{$('#companylogo').attr("src","<?php echo base_url(); ?>/assets/img/makes/png/"+logo+".png");$('#companylogo').show()}
			var id = selected.data('id');
			var data = {
	    		code: 2,
	    		id_make: id
		    }
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/get_dropdown_data"); ?>",
				cache: false,
				data: data,
				dataType: 'json',
				success: function(result){
					var option = '<option></option>';
					
					for (var i in result) {
			            option = option+'<option data-id="'+result[i].id_family+'" value="'+result[i].name+'">'+result[i].name+'</option>';
			          }
					$(document).find("#fapplication_summary_new").find('#newLead_model').html(option);
					
				}
			});
	    });
		
			$(document).on('change', '#fapplication_summary_new #newLead_model', function() {
			var selected = $(this).find('option:selected');
			var id = selected.data('id');
			
			// var data = {
	  //   		code: 3,
	  //   		id_model: id
			// 	    }
			var data = {
	    		code: 4,
	    		id_model: id
				    }
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/get_dropdown_data"); ?>",
				cache: false,
				data: data,
				dataType: 'json',
				success: function(result){
					var option = '<option value="">--Choose--</option>';
					
					// for (var i in result) {
			  //           option = option+'<option data-id="'+result[i].id_vehicle+'" value="'+result[i].name+'">'+result[i].name+'</option>';
			  //         }
					// $(document).find("#application_section").find('#variant').html(option);
					for (var i in result) {
			            option = option+'<option data-code="'+result[i].code+'" value="'+result[i].year+'">'+result[i].year+'</option>';
			          }
					$(document).find("#fapplication_summary_new").find('#newLead_car_year').html(option);
				}
			});
	    });
			$(document).on('change', '#fapplication_summary_new #newLead_car_year', function() {
			var selected = $(this).find('option:selected');
			var var_code = selected.data('code');
			
			var data = {
	    		code: 3,
	    		var_code: var_code
				    }
			//console.log(var_code);
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/get_dropdown_data"); ?>",
				cache: false,
				data: data,
				dataType: 'json',
				success: function(result){
					var option = '<option value="">--Choose--</option>';
					
					for (var i in result) {
			            option = option+'<option data-id="'+result[i].id_vehicle+'" value="'+result[i].name+'">'+result[i].name+'</option>';
			          }
					$(document).find("#fapplication_summary_new").find('#newLead_car_variant').html(option);
				}
			});
	    });
			$(document).on('click',".sendNotificationToDealer",function(){
				var id = $(this).data("id");
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('account/send_notification_to_dealer'); ?>",
					data: {id:id},
					cache: false,
					success: function(result){
						if(result == 1 || result == '1')
						{
							alert("Notification mail sent to dealer successfully.");
						}
						else
						{
							alert("Error in Mail sending to dealer");
						}
					}
				});
			});
		});
		
	function save_dealer_info ()
	{	

		if($("#dealer_main_form").valid())
		{
			var dealer_id        = $("#dealer_modal").find("#dealer_id").val();

			var dealership_name  = $("#dealer_modal").find("#dealership_name").val();
			var abn              = $("#dealer_modal").find("#abn").val();
			var dealership_brand = $("#dealer_modal").find("#dealership_brand").val();
			
			var state            = $("#dealer_modal").find("#state").val();
			var postcode         = $("#dealer_modal").find("#postcode").val();
			var address          = $("#dealer_modal").find("#address").val();
			
			var manager_name     = $("#dealer_modal").find("#manager_name").val();
			var manager_email    = $("#dealer_modal").find("#manager_email").val();
			var manager_phone    = $("#dealer_modal").find("#manager_phone").val();
			var manager_mobile   = $("#dealer_modal").find("#manager_mobile").val();

			$.ajax({
				type: "POST",
				url: "<?php echo site_url('account/update_dealer_profile'); ?>",
				data: $("#dealer_main_form").serialize(),
				cache: false,
				success: function(result){
					//return false;
					$("#dealer_dealership_name_"+dealer_id).html(dealership_name);
					$("#dealer_abn_"+dealer_id).html(abn);
					$("#dealer_dealership_brand_"+dealer_id).html(dealership_brand);
					
					$("#dealer_state_"+dealer_id).html(state);
					$("#dealer_postcode_"+dealer_id).html(postcode);
					$("#dealer_address_"+dealer_id).html(address);
					
					$("#dealer_name_"+dealer_id).html(manager_name);
					$("#dealer_email_"+dealer_id).html(manager_email);						
					$("#dealer_phone_"+dealer_id).html(manager_phone);
					$("#dealer_mobile_"+dealer_id).html(manager_mobile);
					
					$("#dealer_modal").modal("hide");
					//$(location).reload();
				}
			});
		}
		else
		{
			//alert("werre");
		}
	}	
	function delete_dealer(dealer_id)
	{

		if (confirm("Are you sure you want to delete this Dealer?")) 
		{				
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('account/delete'); ?>/" + dealer_id,
				cache: false,
				success: function(result){
					$("#dealer_row_"+dealer_id).remove();
				}
			});
		}
	}
	function pma_control (dealer_id, status)
	{
		var data = {
			dealer_id: dealer_id,
			status: status
		};

		$.ajax({
			type: "POST",
			url: "<?php echo site_url('account/change_pma_status'); ?>/" + dealer_id,
			cache: false,
			data: data,
			dataType: 'json',
			success: function(response){
				if(response.status == 1)
				{
					$("#activate_pma_"+dealer_id).hide();
					$("#deactivate_pma_"+dealer_id).show();
				}
				else
				{
					$("#deactivate_pma_"+dealer_id).hide();
					$("#activate_pma_"+dealer_id).show();
				}
				$("#dealer_pma_"+dealer_id).text(response.status_text);
			}
		});
	}		
	function gold_control (dealer_id, status)
	{
		var data = {
			dealer_id: dealer_id,
			status: status
		};

		$.ajax({
			type: "POST",
			url: "<?php echo site_url('account/change_gold_status'); ?>/" + dealer_id,
			cache: false,
			data: data,
			dataType: 'json',
			success: function(response){
				if(response.status == 1)
				{
					$("#activate_gold_"+dealer_id).hide();
					$("#deactivate_gold_"+dealer_id).show();
				}
				else
				{
					$("#deactivate_gold_"+dealer_id).hide();
					$("#activate_gold_"+dealer_id).show();
				}
				$("#dealer_gold_"+dealer_id).text(response.status_text);
			}
		});
	}
	function deposit_visibility_control (dealer_id, status)
	{
		var data = {
			dealer_id: dealer_id,
			status: status
		};

		$.ajax({
			type: "POST",
			url: "<?php echo site_url('account/change_deposit_visibility_status'); ?>/" + dealer_id,
			cache: false,
			data: data,
			dataType: 'json',
			success: function(response){
				if(response.status == 1)
				{
					$("#hide_deposit_"+dealer_id).show();
					$("#show_deposit_"+dealer_id).hide();	
				}
				else
				{
					$("#show_deposit_"+dealer_id).show();
					$("#hide_deposit_"+dealer_id).hide();
				}
			}
		});
	}
	function activate_dealer (dealer_id)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('account/activate'); ?>/" + dealer_id,
			cache: false,
			success: function(result){
				$("#activate_button_"+dealer_id).show();
				$("#deactivate_button_"+dealer_id).hide();
				$("#dealer_status_"+dealer_id).html("Activated");
			}
		});
	}
	function deactivate_dealer (dealer_id)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('account/deactivate'); ?>/" + dealer_id,
			cache: false,
			success: function(result){
				$("#deactivate_button_"+dealer_id).hide();
				$("#activate_button_"+dealer_id).show();
				$("#dealer_status_"+dealer_id).html("Deactivated");
			}
		});
	}
	function delete_dealer (dealer_id)
	{
		if (confirm("Are you sure you want to delete this Dealer?")) 
		{				
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('account/delete'); ?>/" + dealer_id,
				cache: false,
				success: function(result){
					$("#dealer_row_"+dealer_id).remove();
				}
			});
		}
	}
	function removeUnderline()
	{	
		$( ".address_inp" ).each(function( i ) {
			//console.log( $(this).val())
			if( $(this).val()=="")
			{ $(this).removeClass("hide_show_text");}
			else
			{ $(this).addClass("hide_show_text");}
		});
	}
	function remove_no_val()
	{
		$(document).find("#application_section").find(".form-control").each(function(){
			var $this = $(this);
			if($.trim($this.val()) == "")
			{
				$this.addClass('no-value');
			}
			else
			{
				$this.removeClass('no-value');
			}
		});
	}
	function set_applicant_count_values()
	{
		var count = $(document).find(".panel-main").length;
		
		$(document).find("#applicant_count").val(count);
	}
	function allocate_lead_note()
	{
		var lead_id = $("#lead_id_fq").val();
		var fq_id   = $("#fapplication_id").val();
		var data = {
			lead_id: lead_id,
			fq_id: fq_id
		}
		$.ajax({
			type: "POST",
			url: "<?php echo site_url("fapplication/allocate_lead_note"); ?>",
			cache: false,
			data: data,
			success: function(response){
				
			}
		});
	}
	function get_state(id)
	{
		var note_state         = $(".side-note").hasClass("active");
		var requirements_state = $("#requirements_tab_panel").hasClass("active");
		var application_state  = $("#application_section").hasClass("active");
		var note_1_height      = $(".side-note").find(".textarea").height();
		var note_2_height      = $(".side-note").find(".textarea_2").height();
		$(".side-note").prop("hidden", false);
		var data = {
			id                : id,
			note_state        : note_state,
			requirements_state: requirements_state,
			application_state : application_state,
			note_1_height     : note_1_height,
			note_2_height     : note_2_height
		};
		
		$.ajax({
			type: "POST",
			url: "<?php echo site_url("fapplication/save_state"); ?>",
			cache: false,
			data: data,
			success: function(response){
				$(".side-note").prop("hidden", true);		
			}
		});
	}
	function set_state(id)
	{
		var data = {
			id: id
		};
		$.ajax({
			type: "POST",
			url: "<?php echo site_url("fapplication/set_save_state"); ?>",
			cache: false,
			data: data,
			dataType: 'json',
			success: function(data){
				if(data.requirements_tab_state == 1)
				{
					$("#requirements_tab_panel").addClass("active");
					$("#requirements_tab_panel").find(".toggle-content").css("display", "block");
				}
				else
				{
					$("#requirements_tab_panel").removeClass("active");
					$("#requirements_tab_panel").find(".toggle-content").css("display", "none");	
				}
				if(data.application_tab_state == 1)
				{
					$("#application_section").addClass("active");
					$("#application_section").find(".toggle-content").css("display", "block");
				}
				else
				{
					$("#application_section").removeClass("active");
					$("#application_section").find(".toggle-content").css("display", "none");	
				}
				if(data.note_state == 1)
				{
					if(data.note_1_height > 0.00)
						$(".side-note").find(".textarea").height(data.note_1_height);
					if(data.note_2_height > 0.00)
						$(".side-note").find(".textarea_2").height(data.note_2_height);
					get_notes_data();
				}
				else
				{
					$(".side-note").show();
					if(data.note_1_height > 0.00)
						$(".side-note").find(".textarea").height(data.note_1_height);
					if(data.note_2_height > 0.00)
						$(".side-note").find(".textarea_2").height(data.note_2_height);
					$(".side-note").hide();
					$(".side-note").removeClass("active");
				}
			}
		});
	}
	function get_notes_data ()
    {
    	var lead_id    = $("#lead_id_fq").val();
		var fa_acct_id = $("#fapplication_id").val();
    	var data = {
    		fa_acct_id: fa_acct_id,
    		lead_id: lead_id
    	};
    	$(".side-note").find(".textarea").val("");
    	$(".side-note").find(".textarea_2").val("");
    	$(".side-note").find(".textarea_2").closest(".col-md-6").prop("hidden", true);
		$.ajax({
			type: "POST",
			url: "<?php echo site_url("fapplication/get_note"); ?>",
			cache: false,
			data: data,
			dataType: 'json',
			success: function(data){
				$(".side-note").find(".textarea").val(data.note);
				if(lead_id != ""){
					$(".side-note").find(".textarea_2").val(data.lead_note);
					$(".side-note").find(".textarea_2").closest(".col-md-6").prop("hidden", false);
				}
				$(".side-note").slideDown(500);
				$(".side-note").addClass("active");
			}
		});
    }
    function save_note_1(obj)
    {
    	var fa_acct_id = $("#fapplication_id").val();
    	var note = $.trim(obj.val());
    	if($.trim(note) == '')
    		return false;
    	var data = {
    		fa_acct_id: fa_acct_id,
    		note: note
    	};
    	obj.prop("disabled", true);
    	$.ajax({
			type: "POST",
			url: "<?php echo site_url("fapplication/insert_new_note"); ?>",
			cache: false,
			data: data,
			success: function(data){
				
				obj.prop("disabled", false);
				allocate_lead_note();
			}
		});
    }
    function save_note_2(obj)
    {
    	var lead_id = $("#lead_id_fq").val();
		var note    = $.trim(obj.val());
    	if($.trim(note) == '')
    		return false;
    	var data = {
    		lead_id: lead_id,
    		note: note
    	};
    	obj.prop("disabled", true);
    	$.ajax({
			type: "POST",
			url: "<?php echo site_url("fapplication/update_lead_note_detail"); ?>",
			cache: false,
			data: data,
			success: function(data){
				
				obj.prop("disabled", false);
				allocate_lead_note();
			}
		});
    }
	/*G8CJEACG6WGRPSC 67JXC8VESB4K27D*/
    function addContact(){
    	var contact_data; 
    	var d = new Date();
		var n = d.getMilliseconds();
	 
	 	$("#add_contact").on("click",function(){
                //var contact_data = $("#dealer_contact_form").html();
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
                    contact_data += '<input type="checkbox" class="check-new-one in-check" id="'+contact_key+'" name="'+checkbox_input_name+'['+i+']" ><label for="'+contact_key+'" data-toggle="tooltip" data-placement="top" title="" data-original-title="'+contact_key_name+'"><span class="border-span"><i class="fa fa-check" aria-hidden="true"></i></span></label>';
                }
                
                // Is primary contact
                contact_data += "</div>";
                contact_data += '<div class="dealer-input-check">';
                    contact_data += '<span class="primary-contact" style="padding-right: 15px;">Is Primary Contact</span>';
                    contact_data += '<input type="checkbox" class="check-new-one in-check is_primary_contact" id="is_primary_contact'+n+'" value="1" name="contact_is_primary['+n+']">';
                    contact_data += '<label for="is_primary_contact'+n+'" data-toggle="tooltip" data-placement="top" title="is_primary_contact" data-original-title="Is Primary Contact"><span class="border-span"><i class="fa fa-check" aria-hidden="true"></i></span></label>';
                contact_data += '</div>';
                
                //contact_data += '<div class="form-group"><div class="dealer-detail-form-group"><span>Title</span><input type="text" name="contact_title[]" id="contact_title'+n+'" class="form-control pull-right"></div></div><div class="form-group"><div class="dealer-detail-form-group"><span class="require-field">Full Name</span><input type="text" name="contact_fullname[]" id="contact_fullname'+n+'" class="form-control pull-right"  ></div></div><div class="form-group"><div class="dealer-detail-form-group"><span class="require-field">Email = Username</span><input type="email" name="contact_email[]" id="contact_email'+n+'" class="form-control pull-right" ></div></div><div class="form-group"><div class="dealer-detail-form-group"><span>Mobile</span><input type="text" data-rule-number="true" name="contact_mobile[]" id="contact_mobile'+n+'" class="form-control pull-right"></div></div><div class="form-group"><div class="dealer-detail-form-group"><span>Landline</span><input type="text" data-rule-number="true" name="contact_landline[]" id="contact_landline'+n+'" class="form-control pull-right"></div></div>';
                   contact_data += '<div class="form-group">';
                       contact_data += '<div class="dealer-detail-form-group">';
                           contact_data += '<span>Title</span>';
                           contact_data += '<input type="text" name="contact_title[]" id="contact_title'+n+'" class="form-control pull-right">';
                       contact_data += '</div>';
                   contact_data += '</div>';
                   contact_data += '<div class="form-group">';
                       contact_data += '<div class="dealer-detail-form-group">';
                           contact_data += '<span class="require-field">Full Name</span>';
                           contact_data += '<input type="text" name="contact_fullname[]" id="contact_fullname'+n+'" class="form-control pull-right"  >';
                       contact_data += '</div>';
                   contact_data += '</div>';
                   contact_data += '<div class="form-group">';
                       contact_data += '<div class="dealer-detail-form-group">';
                           contact_data += '<span class="require-field">Email = Username</span>';
                           contact_data += '<input type="email" name="contact_email[]" id="contact_email'+n+'" class="form-control pull-right" >';
                       contact_data += '</div>';
                   contact_data += '</div>';
                   contact_data += '<div class="form-group">';
                       contact_data += '<div class="dealer-detail-form-group">';
                           contact_data += '<span>Mobile</span>';
                           contact_data += '<input type="text" data-rule-number="true" name="contact_mobile[]" id="contact_mobile'+n+'" class="form-control pull-right">';
                       contact_data += '</div>';
                   contact_data += '</div>';
                   contact_data += '<div class="form-group">';
                       contact_data += '<div class="dealer-detail-form-group">';
                           contact_data += '<span>Landline</span>';
                           contact_data += '<input type="text" data-rule-number="true" name="contact_landline[]" id="contact_landline'+n+'" class="form-control pull-right">';
                       contact_data += '</div>';
                   contact_data += '</div>';
                
                
                
                

                var button = '<div class="form-group text-right"><button type="button" name="delete_contact" id="delete_contact" class="btn btn-danger delete_contact" data-id="'+div_id+'" >Delete</button></div> <hr/>';

                /*if($("#dealer_contact_form").valid())
                {*/
                    var clone_div = "<div id='"+div_id+"'></div>";
                    $("#dealer_contacts").append(clone_div);
                    //$("#dealer_contact_form").children().clone(true,true).appendTo("#"+div_id);
                    $("#"+div_id).append(contact_data);
                    //$("#"+div_id).html($("#dealer_contact_form").html());
                    $("#"+div_id).append(button);
                    $("#dealer_contact_form").trigger("reset");

                /*}
                else
                {
                    //alert("hello");
                }*/

                $(".delete_contact").on("click",function(){
                    var div_ids = $(this).data("id");
                    $("#"+div_ids).remove();
                });
                $("[data-toggle='tooltip']").tooltip(); 
            });
    	
    }
    var takeScreenShot = function() {
    	var application_fields = $(document).find("#application_fields");
	    var orig_body_height = 0;
	    var orig_background = "";
	    var orig_padding = 0;
	    orig_body_height = $("body").css("height");
	    orig_padding = application_fields.css('padding');
	    orig_background = application_fields.css('background');
	    $("body").css("height", 10000);
	    application_fields.css('padding', '20px');
	    application_fields.css('background', '#fff');
		application_fields.css('display', 'inline-block');
		application_fields.css('height', 'auto');
	    html2canvas(document.getElementById("application_fields"), {
	        onrendered: function (canvas) {
	        	var height = $(application_fields).height();
		    	var width = $(application_fields).width();
	            var tempcanvas=document.createElement('canvas');
	            tempcanvas.width=width;
	            tempcanvas.height=height;
	            var context=tempcanvas.getContext('2d');
	            context.drawImage(canvas,0,0);
	            var link=document.createElement("a");
	            link.href=tempcanvas.toDataURL('image/jpg');   //function blocks CORS
	            link.download = 'applicants.jpg';
	            link.click();
	        }
	    });
	    $("body").css("height", orig_body_height);
	    application_fields.css('padding', orig_padding);
	    application_fields.css('background', orig_background);
	}
	$(document).ready(function(){

        $(document).on('click',".is_primary_contact",function(){
            var $box = $(this);
            if ($box.is(":checked")) {
                var group = "input:checkbox[class='check-new-one in-check is_primary_contact']";
                $(group).prop("checked", false);
                $box.prop("checked", true);
            } else {
                $box.prop("checked", false);
            }
        });
        
		$("#fapplication-modal-4").modal("show");
        
		$(document).on('click', '.export_application', function() {
			takeScreenShot();
		});
        
	    $(document).on('change', '.textarea', function() {
	    	var that = $(this);
	    	save_note_1(that);
	    });
        
	    $(document).on('change', '.textarea_2', function() {
			var that    = $(this);
			save_note_2(that);
	    });
        
	    $(document).on('click', '.auto_text', function() {
	    	var txt = $(this).text();
	    	var old_txt = $(this).closest(".col-md-6").find("textarea").val();
	    	var new_text = old_txt + " " + txt;
	    	var textarea = $(this).closest(".col-md-6").find("textarea");
	    	var note_flag = $(this).closest(".col-md-6").data("flag");
	    	$(textarea).val("");
	    	$(textarea).val(new_text);
	    	
	    	if(note_flag==1)
	    		save_note_1(textarea);
	    	else
	    		save_note_2(textarea);
	    });
        
		$(document).on("click", ".ddown_email_btn", function(){
			var email = $(this).text();
			var parent = $(this).closest(".email_recipient_group");
			var current_val = parent.find(".multi_email_recipients").val();
			parent.find(".multi_email_recipients").tagsinput('add', email);
		});
        
		// $(".multi_email_recipients").select2({
		// 	tags: "true"
		// 	// tokenSeparators: [',']
		// });
		// var admin_flag = "<?php //echo $admin_flag ?>";
		var admin_flag = 0;
		$(document).on('click','.admin-close',function(){
			$("#fapplication-modal-3").modal("hide");
		});
        
		$(document).on('change','.form-control',function(){
			var $this = $(this);
			remove_no_val();
		});
        
		$("#fapplication-modal-3").on('shown.bs.modal', function(){
			$(document).find('#application_section').find('.form-control').each(function(index, value){
				var $this = $(this);
				if($.trim($this.val()) == "")
				{
					$this.addClass('no-value');
				}
				else
				{
					$this.removeClass('no-value');
				}
			});
		});
        
		var global_loan_use;
		var global_cust_type;
		var state_type_1 = [
		'Have you ever been registered with any Credit Reporting Agency as having a Credit Default or Court Judgement registered against you?',
		'If Yes, have the related debts been paid in full?',
		'Have you ever been declared Bankrupt or entered into any Part 9 / Debt Agreement?',
		'If Yes, have you since been discharged?',
		''
		];
        
		var state_type_2 = [
		'Have you ever been declared bankrupt or insolvent, or has your estate been assigned for the benefit of creditors?',
		'Have you ever been shareholders or officer of any company of which a manager, receiver or liquidator has been appointed?',
		'Is there any unsatisfied court judgement entered against you or any company of which you are/were a shareholder or officer?',
		'Have you ever been registered with any Credit Reporting Agencies as in default?',
		'Are you the director or shareholder of any other companies? If yes, details:'
		];
        
		$(document).on('change','.loan_use',function(){
			var ddown_loan = $(this);
			var loan_val = $(this).val();
			if(admin_flag == "1")
				return false;
			$('.beneficiaries_section').attr('hidden',true);
			$(document).find('.temp_parent_panel:not(:first)').remove();
			if(loan_val == 'business')
			{
				$('.business_details').attr('hidden',false);
				$('.employer_clause').attr('hidden',true);
				// $('.cred_reference_clause').attr('hidden',true);
				$('#cust_type').html(
									"<option></option>\
									<option value='company'>Company</option>\
									<option value='sole_trader'>Sole Trader</option>\
									<option value='partnership'>Partnership</option>\
									<option value='trust'>Trust</option>\
									"
									);
				$('#f-label-guarantors').text('Directors');
			}
			else if(loan_val == 'consumer')
			{
				$('.business_details').attr('hidden',true);
				$('.employer_clause').attr('hidden',false);
				// $('.cred_reference_clause').attr('hidden',false);
				$('#cust_type').html(
									"<option></option>\
									<option value='joint'>Joint</option>\
									<option value='individual'>Individual</option>\
									"
									);
				$('#f-label-guarantors').text('Applicants');
			}
			set_applicant_count_values();
		});
        
		$(document).on('change','.cust_type',function(){
			var cust_type = $(this).val();
			var b_stmnt = $(document).find(".borrowers_statement:first");
			var b_rows  = b_stmnt.find(".row");
			if(admin_flag == "1")
				return false;
			if(cust_type == "sole_trader" || cust_type == "joint" || cust_type == "individual")
			{
				var index = 1;
				$(b_rows).each(function()
				{
					$(this).find("p").html(state_type_1[index-1]);
					b_stmnt.find(".statement_"+index).closest('.row').attr('hidden', false);
					index++
				});
				b_stmnt.find(".statement_5").closest('.row').attr('hidden', true);
			}
			else
			{
				var index = 1;
				$(b_rows).each(function()
				{
					$(this).find("p").html(state_type_2[index-1]);
					b_stmnt.find(".statement_"+index).closest('.row').attr('hidden', false);
					index++
				});
				b_stmnt.find(".statement_5").closest('.row').attr('hidden', false);
			}
			$('.temp_parent_panel').not(':first').remove();
			$('.beneficiaries_section').attr('hidden',true);
			
			if(cust_type == "sole_trader")
			{
				$('.applicant-add').attr('disabled',true);
				$('.applicant-remove').attr('disabled',false);
				$('.living_cost_clause').attr('hidden',false);
			}
			else if(cust_type == "company")
			{
				$('.applicant-add').attr('disabled',false);
				$('.applicant-remove').attr('disabled',false);
			}
			// else if(cust_type == "partnership")
			// {
			// 	$('.applicant-add').attr('disabled',false);
			// 	$('.applicant-remove').attr('disabled',false);
			// }
			else if(cust_type == "trust")
			{
				$('.applicant-add').attr('disabled',false);
				$('.applicant-remove').attr('disabled',false);
				$('.beneficiaries_section').attr('hidden',false);
			}
			else if(cust_type == "individual")
			{
				$('.applicant-add').attr('disabled',true);
				$('.applicant-remove').attr('disabled',true);
				$('.living_cost_clause').attr('hidden',false);				
			}
			else if(cust_type == "joint" || cust_type == "partnership")
			{
				$('.applicant-add').attr('disabled',true);
				$('.applicant-remove').attr('disabled',true);
				$('.living_cost_clause').attr('hidden',false);
				var main_panel = $('#application_fields');
				var new_panel  = $(document).find('.temp_parent_panel:first').clone();
				var id         = 1;
				var name = new_panel.find('.panel-title-main').text().replace(/[0-9]/g, 2);
				new_panel.find('.panel-title-main').text(name);
				new_panel.find('input').val('');
				new_panel.find('.cred_card_clause').find('.panel').not(':first').remove();
				new_panel.find('.loan_clause').find('.panel').not(':first').remove();
				new_panel.find('.cred_reference_clause').find('.panel').not(':first').remove();
				new_panel.find('.property_clause').find('.panel').not(':first').remove();
				new_panel.find('.asset_clause').find('.panel').not(':first').remove();
				new_panel.find('.cred_reference_clause').find('.panel').not(':first').remove();
				new_panel.find('.top-fields').remove();
				new_panel.find('.living_cost_clause').remove();
				new_panel.find('.assets').remove();
				new_panel.find('.car_details').remove();
				new_panel.find('.form-control').each(function(key, value)
				{
					var input      = $(this);
					var curr_name = input.attr('name');
					var count = (curr_name.match(/\[/g) || []).length;
					
					if(count == 2)
					{
						var str_index   = curr_name.indexOf("[");
						var str_index_2 = curr_name.indexOf("]");
						var str_index_3 = curr_name.lastIndexOf("]");
						var str_core_1  = curr_name.substring(str_index, str_index_2 + 1);
						var str_core_2  = curr_name.substring(str_index_2 + 1, str_index_3 + 1);
						var new_name    = curr_name.substring(0,str_index);
						str_core_1      = str_core_1.replace(/[0-9]/g, id);
						new_name        = new_name + str_core_1 + str_core_2;
						input.attr('name', new_name);
						// console.log(curr_name + ":" + count + " - 2");
					}
					else if(count == 3)
					{
						var str_index   = curr_name.indexOf("[");
						var str_index_2 = curr_name.indexOf("]");
						var str_core_1  = curr_name.substring(str_index, str_index_2 + 1);
						var str_core_2  = curr_name.substring(str_index_2 + 1, str_index_2 + 4);
						var str_core_3  = curr_name.substring(str_index_2 + 4, str_index_2 + 8);
						var new_name    = curr_name.substring(0,str_index);
						str_core_1      = str_core_1.replace(/[0-9]/g, id);
						new_name        = new_name + str_core_1 + str_core_2 + str_core_3;
						input.attr('name', new_name);
						// console.log(curr_name + ":" + count + " - 3");
					}
					else
					{
						var str_index   = curr_name.indexOf("[");
						var str_index_2 = curr_name.indexOf("]");
						var str_core_1  = curr_name.substring(str_index, str_index_2 + 1);
						var new_name    = curr_name.substring(0,str_index);
						str_core_1      = str_core_1.replace(/[0-9]/g, id);
						new_name        = new_name + str_core_1;
						input.attr('name', new_name);
						// console.log(curr_name + ":" + count + " - 1");
					}
				});
				main_panel.append(new_panel);
			}
			set_applicant_count_values();
		});
							
		$(document).on('click','.applicant-add', function(){
			
			var panel      = $(this).closest('.temp_parent_panel').clone();
			var this_panel = $(this).closest('#application_fields');
			var id         = $(this).closest(this_panel).find('.temp_parent_panel').length;
			var name = panel.find('.panel-title-main').text().replace(/[0-9]/g, "");
			var curr_name_number = parseInt(id) + 1;
			name = name + " "+ curr_name_number.toString();
			name = name.replace("Copy fields","");
			panel.find('.panel-title-main').text(name);
			panel.find('input').val('');
			panel.find('.cred_card_clause').find('.panel').not(':first').remove();
			panel.find('.loan_clause').find('.panel').not(':first').remove();
			panel.find('.cred_reference_clause').find('.panel').not(':first').remove();
			panel.find('.property_clause').find('.panel').not(':first').remove();
			panel.find('.asset_clause').find('.panel').not(':first').remove();
			panel.find('.top-fields').remove();
			panel.find('.living_cost_clause').remove();
			panel.find('.assets').remove();
			panel.find('.car_details').remove();
			panel.find('.cred_reference_clause').remove();
			panel.find('.form-control').each(function(key, value)
			{
				var input      = $(this);
				var curr_name = input.attr('name');
				if(typeof(curr_name) == "undefined")
					//console.log(curr_name + " " + input.attr("class"));
				var count = (curr_name.match(/\[/g) || []).length;
				
				if(count == 2)
				{
					var str_index   = curr_name.indexOf("[");
					var str_index_2 = curr_name.indexOf("]");
					var str_index_3 = curr_name.lastIndexOf("]");
					var str_core_1  = curr_name.substring(str_index, str_index_2 + 1);
					var str_core_2  = curr_name.substring(str_index_2 + 1, str_index_3 + 1);
					var new_name    = curr_name.substring(0,str_index);
					str_core_1      = str_core_1.replace(/[0-9]/g, id);
					new_name        = new_name + str_core_1 + str_core_2;
					input.attr('name', new_name);
				}
				else if(count == 3)
				{
					var str_index   = curr_name.indexOf("[");
					var str_index_2 = curr_name.indexOf("]");
					var str_core_1  = curr_name.substring(str_index, str_index_2 + 1);
					var str_core_2  = curr_name.substring(str_index_2 + 1, str_index_2 + 4);
					var str_core_3  = curr_name.substring(str_index_2 + 4, str_index_2 + 8);
					var new_name    = curr_name.substring(0,str_index);
					str_core_1      = str_core_1.replace(/[0-9]/g, id);
					new_name        = new_name + str_core_1 + str_core_2 + str_core_3;
					input.attr('name', new_name);
				}
				else
				{
					var str_index   = curr_name.indexOf("[");
					var str_index_2 = curr_name.indexOf("]");
					var str_core_1  = curr_name.substring(str_index, str_index_2 + 1);
					var new_name    = curr_name.substring(0,str_index);
					str_core_1      = str_core_1.replace(/[0-9]/g, id);
					new_name        = new_name + str_core_1;
					input.attr('name', new_name);
				}
				
			});
			panel.find(".copy_applicant1").remove();
			var html = '<button type="button" class="btn btn-primary btn-xs pull-right copy_applicant1" style="margin-left: 15px;">Copy fields</button>';
			panel.find(".panel-title-main").append(html);
			panel.find(".business_details").remove();
			panel.find(".beneficiaries_section").remove();
			this_panel.append(panel);
			// initAutocomplete();
			set_applicant_count_values();
		});
        
		function verify()
		{
			var car_details_panel = $(".car_details");
			var supp_panel        = $(".supplier_details");
			var deal_panel        = $(".deal_structure");
			var business_panel    = $(".business_details");
			var assets            = $(".assets").children('.row');
			var app_panel         = $(".panel-main").children('.panel-body').children('.row');
			var loan_use = $("#loan_use").val();
			var car_ctr      = 0;
			var supp_ctr     = 0;
			var deal_ctr     = 0;
			var business_ctr = 0;
			var assets_ctr   = 0;
			var app_ctr      = 0;
			car_details_panel.find('input').each(function(){
				var input = $.trim($(this).val());
				
				if(input == '')
					car_ctr++;
			});
			supp_panel.find('input').each(function(){
				var input = $.trim($(this).val());
				
				if(input == '')
					supp_ctr++;
			});
			deal_panel.find('input').each(function(){
				var input = $.trim($(this).val());
				
				if(input == '')
					deal_ctr++;
			});
			business_panel.find('input').each(function(){
				var input = $.trim($(this).val());
				
				if(input == '')
					business_ctr++;
			});
			assets.find('input').each(function(){
				var input = $.trim($(this).val());
				
				if(input == '')
					assets_ctr++;
			});
			app_panel.find('input').each(function(){
				var input = $.trim($(this).val());
				
				if(input == '')
					app_ctr++;
			});
			if(car_ctr > 0)
				alert("There are unfilled fields in the Car Details section...");
			if(supp_ctr > 0)
				alert("There are unfilled fields in the Supplier Details section...");
			if(deal_ctr > 0)
				alert("There are unfilled fields in the Deal Structure section...");
			if(loan_use == 'business')
			{
				if(business_ctr > 0)
					alert("There are unfilled fields in the Business Details section...");
				// return false;
			}
		}
        
		$(document).on('click','.submit_to_admin', function(){
			var id_fq_account = $(document).find("#fapplication_id").val();
			var fqa_number    = $(document).find("#fqa_number").val();
			var data = {
				id_fq_account: id_fq_account,
				fqa_number: fqa_number
			};
			verify();
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/submit_to_admin"); ?>",
				cache: false,
				data: data,
				success: function(response){
					save_fapplication_info_2(1);
				}
			});
		});
        
		var dof_arr = {
			esanda: 770,
			pepper: 770,
			liberty: 880,
			macquarie: 750,
			pccu: 880,
			st_george: 700,
			anz: 770
		};
		var est_arr = {
			esanda: 350,
			pepper: 399,
			liberty: 330,
			macquarie: 450,
			pccu: 250,
			st_george: 399,
			anz: 350
		};
		var monthly_arr = {
			esanda: 5,
			pepper: 7,
			liberty: 5,
			macquarie: 5,
			pccu: 0,
			st_george: 5.95,
			anz: 5
		};
		var nper = 0; //terms
		var rate = 0.00; //rate
		var fv   = 0.00; //balloon amount
		var pv   = 0.00; // naf
		var type = 0; // arrears/advance
		var monthly_rate = 0.00;
		$(document).on('change', '#arrears', function() {
			pmt();
		});
        
		$(document).on('change', '#frequency', function() {
			pmt();
		});
        
		function pmt(orig_flag)
		{
			var final_val = 0.00;
			set_pmt_vars(orig_flag);
			var frequency = $("#frequency").val();
			
			pv = parseFloat(pv * -1);
			fv = parseFloat(fv);
			nper = parseInt(nper);
			// type = parseInt(type);
			rate = parseFloat(rate);
			var PMT = (-fv - pv * Math.pow(1 + rate, nper)) /
			  (1 + rate * type) /
			  ((Math.pow(1 + rate, nper) - 1) / rate);
			if(frequency == "weekly"){
				final_val = ((PMT * 12) / 52) + monthly_rate;
			}else if(frequency == "fortnightly"){
				final_val = ((PMT * 12) / 26) + monthly_rate;
			}
			else{
				final_val = PMT + monthly_rate;
			}
			final_val = final_val.toFixed(2);
			$("#payments").val(final_val);
		}
        
		function set_pmt_vars(orig_flag)
		{
			var lender = $("#lender").val();
			var dof     = 0;
			var est     = 0;
			var monthly = 0.00;
			if (lender == "St. George") {
				dof     = dof_arr.st_george;
				est     = est_arr.st_george;
				monthly = monthly_arr.st_george;
			}
			else if (lender == "Macquarie") {
				dof     = dof_arr.macquarie;
				est     = est_arr.macquarie;
				monthly = monthly_arr.macquarie;
			}
			else if (lender == "Pepper") {
				dof     = dof_arr.pepper;
				est     = est_arr.pepper;
				monthly = monthly_arr.pepper;
			}
			else if (lender == "PCCU") {
				dof     = dof_arr.pccu;
				est     = est_arr.pccu;
				monthly = monthly_arr.pccu;
			}
			else if (lender == "Liberty") {
				dof     = dof_arr.liberty;
				est     = est_arr.liberty;
				monthly = monthly_arr.liberty;
			}
			else if(lender == "ANZ"){
				dof     = dof_arr.anz;
				est     = est_arr.anz;
				monthly = monthly_arr.anz;
			}
			if(orig_flag == 1){
				$("#origination_fee").val(dof);
			}
			$("#est_fee").val(est);
			monthly_rate = monthly;
			nper         = $("#term").val();
			rate         = (parseFloat($("#cust_rate").val()) * .01) / 12;
			fv           = parseFloat($("#balloon_amt").val());
			pv           = parseFloat($("#naf").val());
			type         = $("#arrears option:selected").data("type");
		}
        
		// rules
		function emp_abn()
		{
			var lender = $("#lender").val();
			if(lender == "MacQuarie")
				$(document).find(".emp_abn_panel").attr('hidden', false);
			else
				$(document).find(".emp_abn_panel").attr('hidden', true);
		}
        
		$(document).on('change','.property_value', function(){
			that = $(this);
			var liability_panel = that.closest(".property_clause");
			var first_lia_val = liability_panel.find(".panel:first").find(".property_value").val();
			var tot_prop_val = 0.00;
			if($.trim(first_lia_val) != '')
			{
				$(liability_panel.find('.property_value')).each(function(){
					var prop_val = $(this).val();
					if(prop_val == "")
						prop_val = 0;
					tot_prop_val = tot_prop_val + parseFloat(prop_val);
				});
				liability_panel.closest('.temp_parent_panel').find('.assets').find('.tot_prop_value').val(tot_prop_val);
			}
			//console.log(tot_prop_val);
		});
		// rules
        
		function calculate_naf(orig_flag = 1)
		{
			var purchase_price  = parseFloat($("#purchase_price").val());
			var deposit         = parseFloat($("#deposit").val());
			var trade           = parseFloat($("#trade").val());
			var origination_fee = parseFloat($("#origination_fee").val());
			var est_fee         = parseFloat($("#est_fee").val());
			var payout          = parseFloat($("#payout").val());
			var fees            = origination_fee + est_fee;
			var insurance       = 0.00;
			var loan_use        = $("#loan_use").val();
			var naf             = 0.00;
			var rev_fee         = 6.8;
			
			//payout
			if($('#deposit_check').is(":checked"))
				deposit = 0.00;
			if(loan_use == "consumer")
			{
				$(document).find(".insurance").each(function(){
					var this_val = parseFloat($(this).val());
					insurance = insurance + this_val;
				});
			}
			naf = (((((purchase_price - deposit) - trade) + fees) + insurance) + payout) + rev_fee;
			$("#naf").val(naf);
			pmt(orig_flag);
		}
        
		// rules
		$(document).on('change','.client_res_stat', function(){
			var base_rate_arr = [4.10,4.70,5.50,6.80];
			var year          = $("#year").val();
			var res_stat      = $(this).val();
			var base_rate     = 0.00;
			var status_count  = $(document).find('.client_res_stat').length;
			var property_stat = false;
			$(document).find('.client_res_stat').each(function(){
				var this_value = $(this).val();
				if(this_value == "owner")
					property_stat = true;
			});
			if(property_stat)
			{
				if(year > 2014)
					base_rate = base_rate_arr[0];
				else
					base_rate = base_rate_arr[1];
			}
			else
			{
				if(year > 2014)
					base_rate = base_rate_arr[2];
				else
					base_rate = base_rate_arr[3];
			}
			base_rate = base_rate.toFixed(2);
			$("#rate").val(base_rate);
			set_requirements();
		});
        
		$(document).on('change','#loan_type', function(){
			set_requirements();
		});
        
		// rules
	    function compute_balloon ()
	    {
			var balloon_percentage = $.trim($("#balloon_percentage").val());
			var balloon_amt        = $.trim($("#balloon_amt").val());
			var purchase_price     = $.trim($("#purchase_price").val());
			var book_value         = $.trim($("#book_value").val());
			var temp_balloon_amt   = 0.00;
			var temp_balloon_per   = 0.00;
			var lender             = $("#lender").val();
			if(purchase_price == '')
			{
				alert("Purchase price must not be empty!");
				return false;
			}
			if(lender != "ANZ")
			{
				if(balloon_percentage != '')
				{
					temp_balloon_amt = (balloon_percentage * .01) * purchase_price;
					temp_balloon_amt = temp_balloon_amt.toFixed(2);
					$("#balloon_amt").val(temp_balloon_amt);
				}
				else if(balloon_amt != '')
				{
					temp_balloon_per = (balloon_amt / purchase_price) * 100.00;
					temp_balloon_per = temp_balloon_per.toFixed(2);
					$("#balloon_percentage").val(temp_balloon_per);
				}
			}
			else
			{
				if(balloon_percentage != '')
				{
					temp_balloon_amt = (balloon_percentage * .01) * purchase_price;
					temp_balloon_amt = temp_balloon_amt.toFixed(2);
					$("#balloon_amt").val(temp_balloon_amt);
				}
				else if(balloon_amt != '')
				{
					temp_balloon_per = (balloon_amt / purchase_price) * 100.00;
					temp_balloon_per = temp_balloon_per.toFixed(2);
					$("#balloon_percentage").val(temp_balloon_per);
				}
			}
	    }
	    // rules
	    $(document).on('change', '.o_balloon_percentage', function() {
			var that               = $(this);
			var balloon_percentage = $.trim(that.closest('.panel').find('.o_balloon_percentage').val());
			var balloon_amt        = $.trim(that.closest('.panel').find('.o_balloon_amt').val());
			var amount             = $.trim(that.closest('.panel').find('.amount_borrowed').val());
			var temp_balloon_amt   = 0.00;
			if(amount == '')
			{
				alert("Amount Borrowed cannot be empty!");
				that.val("");
				return false;
			}
			temp_balloon_amt = compute_other_balloon(amount, balloon_percentage, balloon_amt);
			temp_balloon_amt = temp_balloon_amt.toFixed(2);
			that.closest('.panel').find('.o_balloon_amt').val(temp_balloon_amt);
	    });
	    $(document).on('change', '.o_balloon_amt', function() {
			var that                    = $(this);
			var balloon_percentage      = $.trim(that.closest('.panel').find('.o_balloon_percentage').val());
			var balloon_amt             = $.trim(that.closest('.panel').find('.o_balloon_amt').val());
			var amount                  = $.trim(that.closest('.panel').find('.amount_borrowed').val())
			var temp_balloon_percentage = 0.00;
			if(amount == '')
			{
				alert("Amount Borrowed cannot be empty!");
				that.val("");
				return false;
			}
			temp_balloon_percentage = compute_other_balloon(amount, balloon_percentage, balloon_amt);
			temp_balloon_percentage = temp_balloon_percentage.toFixed(2);
			that.closest('.panel').find('.o_balloon_percentage').val(temp_balloon_percentage);
	    });
	    function compute_other_balloon(amt_borrowed, balloon_percentage, balloon_amt)
	    {
			if(balloon_percentage != '')
				return (balloon_percentage * .01) * amt_borrowed;
			else if(balloon_amt != '')
				return (balloon_amt / amt_borrowed) * 100.00;
			else	
				return 0.00;
	    }
	    // rules
	    function compute_amt_to_finance()
	    {
			var purchased_price = parseFloat($("#purchase_price").val());
			var deposit         = parseFloat($("#deposit").val());
			var trade_value     = parseFloat($("#trade").val());
			var payout          = parseFloat($("#payout").val());
			var amt_to_finance  = 0.00;
			amt_to_finance = (purchased_price - (deposit + trade_value)) + payout;
			
			$("#amt_to_finance").val(amt_to_finance);
	    }
	    $(document).on('change', '#deposit_check', function() {
	    	compute_amt_to_finance();
	    	calculate_naf();
		});
	    $(document).on('change', '#loan_use', function() {
			set_requirements();
		});
		$(document).on('change', '#cust_type', function() {
			set_requirements();
		});
		$(document).on('change', '#amt_finance', function() {
			set_requirements();
			set_settlement();
		});
		$(document).on('change', '#lender', function() {
			calculate_naf();
			set_requirements();
			emp_abn();
			pmt();
		});
		$(document).on('change', '#abn_date', function() {
			set_requirements();
		});
		$(document).on('change', '#purchase_price', function() {
			compute_balloon();
	    	compute_amt_to_finance();
	    	calculate_naf();
	    });
	    $(document).on('change', '#deposit', function() {
	    	compute_amt_to_finance();
	    	calculate_naf();
	    });
	    $(document).on('change', '#trade', function() {
	    	compute_amt_to_finance();
	    	calculate_naf();
	    });
	    $(document).on('change', '#payout', function() {
	    	set_requirements();
	    	compute_amt_to_finance();
	    });
	    $(document).on('change', '#amt_to_finance', function() {
	    	compute_amt_to_finance();
	    });
	    $(document).on('change', '#balloon_percentage', function() {
			var balloon_percentage = $.trim($(this).val());
			var balloon_amt        = $.trim($("#balloon_amt").val());
			var purchase_price     = $.trim($("#purchase_price").val());
			var temp_balloon_amt   = 0.00;
			var temp_balloon_per   = 0.00;
			if(purchase_price == '')
			{
				alert("Purchase price must not be empty!");
				return false;
			}
			if(balloon_percentage != '')
			{
				temp_balloon_amt = (balloon_percentage * .01) * purchase_price;
				temp_balloon_amt = temp_balloon_amt.toFixed(2);
				$("#balloon_amt").val(temp_balloon_amt);
			}
			calculate_naf();
	    });
	    $(document).on('change', '#balloon_amt', function() {
	    	var balloon_percentage = $.trim($("#balloon_percentage").val());
			var balloon_amt        = $.trim($(this).val());
			var purchase_price     = $.trim($("#purchase_price").val());
			var temp_balloon_amt   = 0.00;
			var temp_balloon_per   = 0.00;
			if(purchase_price == '')
			{
				alert("Purchase price must not be empty!");
				return false;
			}
			if(balloon_amt != '')
			{
				temp_balloon_per = (balloon_amt / purchase_price) * 100.00;
				temp_balloon_per = temp_balloon_per.toFixed(2);
				$("#balloon_percentage").val(temp_balloon_per);
			}
			calculate_naf();
	    });
	    $(document).on('change', '#book_value', function() {
	    });
	    $(document).on('change', '#origination_fee', function() {
	    	calculate_naf(0);
	    });
	    $(document).on('change', '#est_fee', function() {
	    	calculate_naf();
	    });
	    $(document).on('change', '#cust_rate', function() {
	    	calculate_naf();
	    });
	    $(document).on('change', '.insurance', function() {
	    	calculate_naf();
	    });
	    $(document).on('change', '#term', function() {
	    	calculate_naf();
	    });
		function delete_applicant()
		{
			var panel_count = $('.panel-main').length;
			if( panel_count >  1 )
			{
				$('.panel-main:not(:first)').each(function (index, value){
					var panel_id        = $(this).find('.applicant_id').val();
					var fapplication_id = $(document).find("#fapplication_id").val();
					
					if( $.trim(panel_id) != '' )
					{
						var data = {
							panel_id: panel_id,
							fapplication_id: fapplication_id
						};
						$.ajax({
							type: "POST",
							url: "<?php echo site_url("fapplication/delete_applicant"); ?>",
							cache: false,
							data: data,
							success: function(response){
								
							}
						});
					}
					
				});
			}
			initAutocomplete();
		}
		$(document).on('click', '.tot_living_cost_check', function() {
			// var this_val           = $(this).prop("checked");
			var living_cost_clause = $(this).closest(".living_cost_clause");
			var living_cost_value  = parseFloat($(this).closest(".input-group").find(".tot_living_cost").val());
			var food               = $(living_cost_clause).find(".food_beverage");
			var utilities          = $(living_cost_clause).find(".power_gas");
			var insurance          = $(living_cost_clause).find(".insurance");
			var transportation     = $(living_cost_clause).find(".transportation_fuel");
			var communications     = $(living_cost_clause).find(".communications");
			var recreation         = $(living_cost_clause).find(".recreation");
			var food_val           = 0.00;
			var utilities_val      = 0.00;
			var insurance_val      = 0.00;
			var transportation_val = 0.00;
			var communications_val = 0.00;
			var recreation_val     = 0.00;
			
			food_val           = living_cost_value * .25;
			utilities_val      = living_cost_value * .20;
			insurance_val      = living_cost_value * .10;
			transportation_val = living_cost_value * .20;
			communications_val = living_cost_value * .10;
			recreation_val     = living_cost_value * .15;
			$(food).val(food_val);
			$(utilities).val(utilities_val);
			$(insurance).val(insurance_val);
			$(transportation).val(transportation_val);
			$(communications).val(communications_val);
			$(recreation).val(recreation_val);
			
		});
		$(document).on('change','.citizen_stat', function(){
			var ddown_cit = $(this);
			var cit_val = $(this).val();
			var visa_type = ddown_cit.closest('.panel-main').find('.visa_type');
			var visa_date = ddown_cit.closest('.panel-main').find('.visa_exp_date');
			if(cit_val == 'Citizen/Permanent Resident')
			{
				visa_type.attr('disabled',true);
				visa_date.attr('disabled',true);
			}
			else if(cit_val == 'Visitor')
			{
				visa_type.attr('disabled',false);
				visa_date.attr('disabled',false);
			}
		});
		$(document).on('change','.income_calc', function(){
			var total_income = 0.00;
			$(document).find(".income_calc").each(function(){
				
				var val = ( $(this).val() != "" ) ? parseFloat( $(this).val() ) : parseFloat( "0.00" );
				total_income = total_income + val;
			});
			$("#total_income").val(total_income);
			surpdef_calculate();
		});
		$(document).on('change','.outgoing_calc', function(){
			outgoing_calc();
			surpdef_calculate();	
		});
		$(document).on('change','.panel-main:first .living_cost', function(){
			outgoing_calc();
			surpdef_calculate();	
		});
		function outgoing_calc()
		{
			var first_applicant_living_cost_obj = $(document).find(".panel-main:first").find(".living_cost");
			var credit_card_limit_obj = $(document).find(".credit_card_limit");
			var loans_obj = $(document).find(".o_monthly_payment");
			var total_living_cost = 0.00;
			var total_credit_card_monthly = 0.00;
			var total_loans = 0.00;
			var total = 0.00
			$(first_applicant_living_cost_obj).each(function(index){
				var value = ( $(this).val() != "" ) ? $(this).val() : "0.00";
				total_living_cost = total_living_cost + parseFloat( value );
			});
			$(credit_card_limit_obj).each(function(index){
				var value = ( $(this).val() != "" ) ? $(this).val() : "0.00";
				total_credit_card_monthly = total_credit_card_monthly + ( parseFloat( value ) * 0.03 );
			});
			$(loans_obj).each(function(index){
				var value = ( $(this).val() != "" ) ? $(this).val() : "0.00";
				total_loans = total_loans + parseFloat( value );
				
			});
			total = total_living_cost + total_credit_card_monthly + total_loans;
			$("#total_outgoings").val(total);
		}
		function surpdef_calculate()
		{
			var total_income    = ( $("#total_income").val() != "" ) ? parseFloat( $("#total_income").val() ) : parseFloat( "0.00" );
			var total_outgoings = ( $("#total_outgoings").val() != "" ) ? parseFloat( $("#total_outgoings").val() ) : parseFloat( "0.00" );
			var surpdef = total_income - total_outgoings;
			$("#surp_def_pos").val(surpdef);
		}
		$(document).on('change','.client_res_stat',function(){
			var ddown_stat = $(this);
			var stat_val = $(this).val();
			var landlord_panel = ddown_stat.closest('.initial_address_panel').find('.landlord-hidden');
			var month_comm_2_panel = ddown_stat.closest('.initial_address_panel').find('.monthly_comm_2');
			var monthly_commitment = ddown_stat.closest('.initial_address_panel').find('.address_monthly_commitment');
			var name_on_title_panel = ddown_stat.closest('.initial_address_panel').find('.name_on_title_row');
			
			if(stat_val == "renting")
			{
				landlord_panel.prop('hidden',false);
			}
			else if(stat_val != "renting" )
			{
				landlord_panel.prop('hidden',true);
			}
			
			if(stat_val == "mortgage" || stat_val == "owner")
			{
				name_on_title_panel.prop('hidden', false)
			}
			else
			{
				name_on_title_panel.prop('hidden', true)
			}
			if(stat_val == "Boarding" || stat_val == "Employer Subsidised" || stat_val == "Living with parents")
			{
				month_comm_2_panel.prop('hidden',false);
			}
			else if(stat_val != "Boarding" || stat_val != "Employer Subsidised" || stat_val != "Living with parents")
			{
				month_comm_2_panel.prop('hidden',true);
			}
		});
		$(document).on('change','.living_cost', function(){
			var parent_panel = $(this).closest('.living_cost_clause');
			var total_living_cost = 0.00;
			$(parent_panel).find('.living_cost').each(function(){
				var this_value = parseFloat($(this).val());
				total_living_cost = total_living_cost + this_value;
			});
			parent_panel.find('.tot_living_cost').val(total_living_cost);
		});
		$(document).on('change','.comp_asset', function(){
			var parent_panel = $(this).closest('.major_assets');
			var total_major_assets = 0.00;
			$(parent_panel).find('.comp_asset').each(function(){
				var this_value = parseFloat($(this).val());
				total_major_assets = total_major_assets + this_value;
			});
			parent_panel.find('.total_assets').val(total_major_assets);
		});
		$(document).on('change','.client_res_stat', function(){
			var this_val       = $(this).val();
			var this_panel     = $(this).closest(".panel");
			var unit           = this_panel.find(".client_unit").val();
			var street_address = this_panel.find(".client_address").val();
			var suburb         = this_panel.find(".client_suburb").val();
			var postcode       = this_panel.find(".client_post_code").val();
			
			if(this_val == "owner" || this_val == "mortgage" || this_val == "renting")
			{
				var tier_0_panel = $(this).closest(".panel-main");
				var panel      = tier_0_panel.find('.property_clause').find('.panel:first').clone();
				var prop_panel = tier_0_panel.find('.property_clause').find('.panel').parent();
				var id         = tier_0_panel.find('.property_clause').find('.panel').length;
				var status     = panel.find('.panel-body').prop('hidden');
				if(status == false)
				{
					panel.find('.form-control').each(function(key, value)
					{
						var input      = $(this);
						input.val('');
						
						var name       = input.closest('.panel').find('.panel-title-fapplication').text().replace(/[0-9]/g, id + 1);
						var curr_name = input.attr('name');
						
						var str_index   = curr_name.indexOf("[");
						var str_index_2 = curr_name.indexOf("]");
						var str_index_3 = curr_name.lastIndexOf("]");
						var str_core_1  = curr_name.substring(str_index, str_index_2 + 1);
						var str_core_2  = curr_name.substring(str_index_2 + 1, str_index_3 + 1);
						var new_name    = curr_name.substring(0,str_index);
						str_core_2      = str_core_2.replace(/[0-9]/g, id);
						new_name        = new_name + str_core_1 + str_core_2;
						input.attr('name', new_name);
						input.closest('.panel').find('.panel-title-fapplication').text(name);
					});
					panel.find('.property_unit').val(unit);
					panel.find('.property_address').val(street_address);
					panel.find('.property_suburb').val(suburb);
					panel.find('.property_postcode').val(postcode);
					prop_panel.append(panel);
				}
				else
				{
					var panel_first = tier_0_panel.find('.property_clause').find('.panel:first');
					panel_first.find('.panel-body').prop('hidden', false);
					panel_first.find('.new').prop('hidden', false);
					panel_first.find('.default').remove();
					panel_first.find('.panel-heading').find(".remove").prop("disabled", false);
					
					panel_first.find('.property_unit').val(unit);
					panel_first.find('.property_address').val(street_address);
					panel_first.find('.property_suburb').val(suburb);
					panel_first.find('.property_postcode').val(postcode);
				}
			}
		});
		//ADD ADDRESS
		$(document).on('click','.add_address',function(){
			var this_panel = $(this).closest('.address-clause').find(".prev_panel_parent");
			var panel      = $(this).closest('.address-clause').find(".prev_address_panel:first").clone();
			var id         = this_panel.find('.prev_address_panel').length;
			var prev_address_hidden_prop = this_panel.find(".prev_address_panel:first").prop("hidden");
			if(!prev_address_hidden_prop)
			{
				var ctr = panel.find('.form-control').length;
				var temp_ctr = 1;
				panel.find('.form-control').each(function(key, value)
				{
					var input      = $(this);
					input.val('');
					
					var name      = input.closest('.panel').find('.panel-title-fapplication').text().replace(/[0-9]/g, "");
					var curr_name_number = parseInt(id) + 1;
					name = name + " "+ curr_name_number.toString();
					var curr_name = input.attr('name');
					
					var str_index   = curr_name.indexOf("[");
					var str_index_2 = curr_name.indexOf("]");
					var str_index_3 = curr_name.lastIndexOf("]");
					var str_core_1  = curr_name.substring(str_index, str_index_2 + 1);
					var str_core_2  = curr_name.substring(str_index_2 + 1, str_index_3 + 1);
					var new_name    = curr_name.substring(0,str_index);
					str_core_2      = str_core_2.replace(/[0-9]/g, curr_name_number);
					new_name        = new_name + str_core_1 + str_core_2;
					input.attr('name', new_name);
					
					
					if(ctr==temp_ctr)
						input.closest('.panel').find('.panel-title-fapplication').text(name);
					temp_ctr++;
				});
				panel.find(".client_res_stat_panel").prop("hidden", true);
				panel.find(".landlord-hidden").prop("hidden", true);
				panel.find(".monthly_comm_2").prop("hidden", true);
				this_panel.append(panel);
			}
			else
			{
				this_panel.find(".prev_address_panel:first").prop("hidden", false);
			}
		});
		//ADD EMPLOYER
		$(document).on('click','.add_employer',function(){
			var this_panel = $(this).closest('.employer_clause').find(".prev_emp_panel_parent");
			var panel      = $(this).closest('.employer_clause').find(".prev_employer_panel:first").clone();
			var id         = this_panel.find('.prev_employer_panel').length;
			var prev_employer_hidden_prop = this_panel.find(".prev_employer_panel:first").prop("hidden");
			if(!prev_employer_hidden_prop)
			{
				var ctr = panel.find('.form-control').length;
				var temp_ctr = 1;
				
				panel.find('.form-control').each(function(key, value)
				{
					var input      = $(this);
					input.val('');
					
					var name      = input.closest('.panel').find('.panel-title-fapplication').text().replace(/[0-9]/g, "");
					var curr_name_number = parseInt(id) + 1;
					name = name + " "+ curr_name_number.toString();
					var curr_name = input.attr('name');
					
					var count = (curr_name.match(/\[/g) || []).length;
					if(count == 3)
					{
						var sec_pos = getPosition(curr_name,"[",2);
						var str_index   = curr_name.indexOf("[");
						var str_index_2 = curr_name.indexOf("]");
						var str_core_1  = curr_name.substring(str_index, str_index_2 + 1);
						var str_core_2  = curr_name.substring(str_index_2 + 1, sec_pos + 3);
						var str_core_3  = curr_name.substring(str_index_2 + 4, str_index_2 + 8);
						var new_name    = curr_name.substring(0,str_index);
						str_core_2      = str_core_2.replace(/[0-9]/g, curr_name_number);
						new_name        = new_name + str_core_1 + str_core_2 + str_core_3;
						input.attr('name', new_name);
						if(ctr==temp_ctr)
							input.closest('.panel').find('.panel-title-fapplication').text(name);
					}
					else
					{
						var str_index   = curr_name.indexOf("[");
						var str_index_2 = curr_name.indexOf("]");
						var str_index_3 = curr_name.lastIndexOf("]");
						var str_core_1  = curr_name.substring(str_index, str_index_2 + 1);
						var str_core_2  = curr_name.substring(str_index_2 + 1, str_index_3 + 1);
						var new_name    = curr_name.substring(0,str_index);
						str_core_2      = str_core_2.replace(/[0-9]/g, curr_name_number);
						new_name        = new_name + str_core_1 + str_core_2;
						input.attr('name', new_name);
						// input.closest('.panel').find('.panel-title-fapplication').text(name);
						if(ctr==temp_ctr)
							input.closest('.panel').find('.panel-title-fapplication').text(name);
					}
					temp_ctr++;
				});
			
				panel.find(".employer_hidden_panels").prop("hidden", true);
				this_panel.append(panel);	
			}
			else
			{
				this_panel.find(".prev_employer_panel:first").prop("hidden", false);
			}
		});
		$(document).on('click','.add_other_income',function(){
			var panel      = $(this).closest('.false-panel').clone();
			var this_panel = $(this).closest('.false-panel').parent();
			var id         = $(this).closest(this_panel).find('.false-panel').length;
			var ctr = panel.find('.form-control').length;
			var temp_ctr = 1;
			if(this_panel.find('.panel-body:first').prop('hidden') == false)
			{
				panel.find('.form-control').each(function(key, value)
				{
					var input      = $(this);
					input.val('');
					
					// var name       = input.closest('.false-panel').find('.panel-title-3rd-dim').text().replace(/[0-9]/g, id + 1);
					var name      = input.closest('.false-panel').find('.panel-title-3rd-dim').text().replace(/[0-9]/g, "");
					var curr_name_number = parseInt(id) + 1;
					name = name + " "+ curr_name_number.toString();
					var curr_name = input.attr('name');
					
					var sec_pos = getPosition(curr_name,"[",2);
					var third_pos = getPosition(curr_name,"[",3);
					var str_index   = curr_name.indexOf("[");
					var str_index_2 = curr_name.indexOf("]");
					var str_core_1  = curr_name.substring(str_index, str_index_2 + 1);
					var str_core_2  = curr_name.substring(str_index_2 + 1, sec_pos + 3);
					var str_core_3  = curr_name.substring(third_pos, third_pos + 3);
					var new_name    = curr_name.substring(0,str_index);
					str_core_3      = str_core_3.replace(/[0-9]/g, id);
					new_name        = new_name + str_core_1 + str_core_2 + str_core_3;
					input.attr('name', new_name);
					// input.closest('.false-panel').find('.panel-title-3rd-dim').text(name);
					if(ctr==temp_ctr)
						input.closest('.false-panel').find('.panel-title-3rd-dim').text(name);
					temp_ctr++;
				});
				this_panel.append(panel);
			}
			else
			{
				this_panel.find('.panel-body:first').prop('hidden', false);
				this_panel.find('.new').prop('hidden', false);
				this_panel.find('.default').remove();
				this_panel.find('.false-panel:first').find('.panel-heading').find(".remove_other_income").prop("disabled", false);
			}
		});
		$(document).on('click','.add_beneficiary',function(){
			var panel      = $(this).closest('.beneficiary_panel').clone();
			var this_panel = $(this).closest('.beneficiary_panel').parent();
			var id         = $(this).closest(this_panel).find('.beneficiary_panel').length;
			var ctr = panel.find('.form-control').length;
			var temp_ctr = 1;
			panel.find('.form-control').each(function(key, value)
			{
				var input      = $(this);
				input.val('');
				
				var name      = input.closest('.panel').find('.panel-title-fapplication').text().replace(/[0-9]/g, "");
				var curr_name_number = parseInt(id) + 1;
				name = name + " "+ curr_name_number.toString();
				var curr_name = input.attr('name');
				
				var str_index   = curr_name.indexOf("[");
				var str_index_2 = curr_name.indexOf("]");
				var str_index_3 = curr_name.lastIndexOf("]");
				var str_core_1  = curr_name.substring(str_index, str_index_2 + 1);
				var str_core_2  = curr_name.substring(str_index_2 + 1, str_index_3 + 1);
				var new_name    = curr_name.substring(0,str_index);
				str_core_2      = str_core_2.replace(/[0-9]/g, id);
				new_name        = new_name + str_core_1 + str_core_2;
				input.attr('name', new_name);
				temp_ctr++;
			});
			this_panel.append(panel);
		});
		//ADD PANEL
		$(document).on('click','.add',function(){
			
			var panel      = $(this).closest('.panel').clone();
			var this_panel = $(this).closest('.panel').parent();
			var id         = $(this).closest(this_panel).find('.panel').length;
			var ctr = panel.find('.form-control').length;
			var temp_ctr = 1;
			if(this_panel.find('.panel:first').find('.panel-body').prop('hidden') == false)
			{
				
				panel.find('.form-control').each(function(key, value)
				{
					var input      = $(this);
					input.val('');
					
					var name      = input.closest('.panel').find('.panel-title-fapplication').text().replace(/[0-9]/g, "");
					var curr_name_number = parseInt(id) + 1;
					name = name + " "+ curr_name_number.toString();
					var curr_name = input.attr('name');
					
					var str_index   = curr_name.indexOf("[");
					var str_index_2 = curr_name.indexOf("]");
					var str_index_3 = curr_name.lastIndexOf("]");
					var str_core_1  = curr_name.substring(str_index, str_index_2 + 1);
					var str_core_2  = curr_name.substring(str_index_2 + 1, str_index_3 + 1);
					var new_name    = curr_name.substring(0,str_index);
					str_core_2      = str_core_2.replace(/[0-9]/g, id);
					new_name        = new_name + str_core_1 + str_core_2;
					input.attr('name', new_name);
					if(ctr==temp_ctr)
						input.closest('.panel').find('.panel-title-fapplication').text(name);
					temp_ctr++;
				});
				
				this_panel.append(panel);
			}
			else
			{
				this_panel.find('.panel:first').find('.panel-body').prop('hidden', false);
				this_panel.find('.panel:first').find('.new').prop('hidden', false);
				this_panel.find('.panel:first').find('.default').remove();
				this_panel.find('.panel:first').find('.panel-heading').find(".remove").prop("disabled", false);
			}
		});
		//REMOVE PANEL
		$(document).on('click','.remove',function () {
			var panel      = $(this).closest('.panel');
			if( $(this).closest(".panel").parent().hasClass("prev_employer_panel") )
				var this_panel = $(this).closest('.prev_emp_panel_parent');
			else
				var this_panel = $(this).closest('.panel').parent();
			var id         = $(this).closest(this_panel).find('.panel').length;
			var parent_id  = $(this).closest('.panel-main').find('input[type=hidden]:first').val();
			var panel_id   = "";
			var panel_type = "";
			
			panel_id   = $.trim(panel.find('input[type=hidden]:first').val());
			panel_type = $.trim(panel.find('input[type=hidden]:first').attr('class'));
			var type       = "";
			// console.log(id);
			var flag = $(this).data("flag");
			if(admin_flag == "1")
				return false;
			if( confirm("Are you sure you want to remove this panel?") )
			{
				if ( id == 1 ) 
				{
					var title_html = "";
					var class_name = "";
					var panel_flag = 0;
					switch(flag)
					{
						case "credit_card_clause":
					        title_html = '<label class="panel-title-fapplication default">Add a Credit Card?</label>';
					        class_name = "credit_card_id";
					        break;
						case "loan_clause":
					        title_html = '<label class="panel-title-fapplication default">Add Other Loans?</label>';
					        class_name = "other_loans_id";
					        break;
					    case "reference_clause":
					    	title_html = '<label class="panel-title-fapplication default">Add a Reference?</label>';
					    	class_name = "credit_reference_id";
					        break;
					    case "property_claue":
					    	title_html = '<label class="panel-title-fapplication default">Add a Property?</label>';
					    	class_name = "property_id";
					        break;
					    case "address":
					    	$(document).find(".prev_address_panel:first").prop("hidden", true);
					    	panel_flag = 1;
					    	break;
					    case "employer":
						    $(document).find(".prev_employer_panel:first").prop("hidden", true)
					    	panel_flag = 1;
					    	break;
					    default:
						    alert("You cannot remove the last form!");
						    return false;
						    break;
					}
					if(panel_flag == 0)
					{
						this_panel.find('.panel:first').find('.panel-body').prop('hidden', true);
						this_panel.find('.panel:first').find('.new').prop('hidden', true);
						this_panel.find('.panel:first').find('.panel-heading').prepend(title_html);
						this_panel.find('.panel:first').find('.panel-heading').find(".remove").prop("disabled", true);
						this_panel.find('.panel:first').find("."+class_name).val("");
						this_panel.find('.panel:first').find(".form-control").val("");
					}
				}
				if(panel_id != "")
				{
					switch(panel_type) 
					{
					    case "form-control address_id":
					        type = "address";
					        break;
					    case "form-control employer_id":
					        type = "employer";
					        break;
					    case "form-control credit_card_id":
					        type = "credit_card";
					        break;  
					    case "form-control other_loans_id":
					        type = "other_loans";
					        break;
					    case "form-control credit_reference_id":
					        type = "credit_reference";
					        break;
					    case "form-control property_id":
					        type = "property";
					        break;
					    case "form-control personal_vehicle_id":
					        type = "personal_vehicle";
					        break;
					    case "form-control other_asset_id":
					        type = "other_asset";
					        break;
				        case "form-control beneficiary_id":
					        type = "beneficiary";
					        break;
					    default:
					    	alert("Something went wrong! Please contact the developer...");
					        return false;
					        break;
					}
					var data = {
						panel_id: panel_id,
						type: type
					};
					$.ajax({
						type: "POST",
						url: "<?php echo site_url("fapplication/delete_panel"); ?>",
						cache: false,
						data: data,
						success: function(response){
							
						}
					});
				}
				
				if( id == 1 )
					return false;
				else
					panel.remove();
			}
		});
		$(document).on('click','.remove_other_income',function(){
			var panel      = $(this).closest('.false-panel');
			var this_panel = $(this).closest('.false-panel').parent();
			var id         = $(this).closest(this_panel).find('.false-panel').length;
			var parent_id  = $(this).closest('.panel-default').find('.employer_id').val();
			var panel_id   = "";
			var panel_type = "";
			
			panel_id       = $.trim(panel.find('input[type=hidden]:first').val());
			var fk_parent  = "fk_employer_id";
			var table      = "fq_employer_other_inc";
			var data = {
				panel_id : panel_id,
				fk_parent: fk_parent,
				parent_id: parent_id,
				table    : table
			};
			if(admin_flag == "1")
				return false;
			if( confirm("Are you sure you want to remove this panel?") )
			{
				if ( id == 1 ) 
				{
					this_panel.find('.false-panel:first').find('.panel-body').prop('hidden', true);
					this_panel.find('.false-panel:first').find('.new').prop('hidden', true);
					this_panel.find('.false-panel:first').find('.panel-heading').prepend('<label class="panel-title-3rd-dim default">Add Other Income?</label>');
					this_panel.find('.false-panel:first').find('.panel-heading').find(".remove_other_income").prop("disabled", true);
					this_panel.find('.false-panel:first').find(".other_income_id").val("");
					this_panel.find('.false-panel:first').find(".form-control").val("");
				}
				if(panel_id != "")
				{
					$.ajax({
						type: "POST",
						url: "<?php echo site_url("fapplication/delete_panel_3rd"); ?>",
						cache: false,
						data: data,
						success: function(response){
							
						}
					});
				}
				
				if( id == 1 )
					return false;
				else
					panel.remove();
			}
		});
		//APPLICANT ADD
		// $(document).on('click','.applicant-add', function(){
			
		// 	var panel      = $(this).closest('.panel-main').clone();
		// 	var this_panel = $(this).closest('.panel-main').parent();
		// 	var id         = $(this).closest(this_panel).find('.panel-main').length;
		// 	var name = panel.find('.panel-title-main').text().replace(/[0-9]/g, "");
		// 	var curr_name_number = parseInt(id) + 1;
		// 	name = name + " "+ curr_name_number.toString();
		// 	name = name.replace("Copy fields","");
		// 	panel.find('.panel-title-main').text(name);
		// 	panel.find('input').val('');
		// 	panel.find('.address-clause').find('.panel').not(':first').remove();
		// 	panel.find('.employer_clause').find('.panel').not(':first').remove();
		// 	panel.find('.cred_card_clause').find('.panel').not(':first').remove();
		// 	panel.find('.loan_clause').find('.panel').not(':first').remove();
		// 	panel.find('.cred_reference_clause').find('.panel').not(':first').remove();
		// 	panel.find('.property_clause').find('.panel').not(':first').remove();
		// 	panel.find('.asset_clause').find('.panel').not(':first').remove();
		// 	panel.find('.form-control').each(function(key, value)
		// 	{
		// 		var input      = $(this);
		// 		var curr_name = input.attr('name');
		// 		var count = (curr_name.match(/\[/g) || []).length;
				
		// 		if(count == 2)
		// 		{
		// 			var str_index   = curr_name.indexOf("[");
		// 			var str_index_2 = curr_name.indexOf("]");
		// 			var str_index_3 = curr_name.lastIndexOf("]");
		// 			var str_core_1  = curr_name.substring(str_index, str_index_2 + 1);
		// 			var str_core_2  = curr_name.substring(str_index_2 + 1, str_index_3 + 1);
		// 			var new_name    = curr_name.substring(0,str_index);
		// 			str_core_1      = str_core_1.replace(/[0-9]/g, id);
		// 			new_name        = new_name + str_core_1 + str_core_2;
		// 			input.attr('name', new_name);
		// 		}
		// 		else if(count == 3)
		// 		{
		// 			var str_index   = curr_name.indexOf("[");
		// 			var str_index_2 = curr_name.indexOf("]");
		// 			var str_core_1  = curr_name.substring(str_index, str_index_2 + 1);
		// 			var str_core_2  = curr_name.substring(str_index_2 + 1, str_index_2 + 4);
		// 			var str_core_3  = curr_name.substring(str_index_2 + 4, str_index_2 + 8);
		// 			var new_name    = curr_name.substring(0,str_index);
		// 			str_core_1      = str_core_1.replace(/[0-9]/g, id);
		// 			new_name        = new_name + str_core_1 + str_core_2 + str_core_3;
		// 			input.attr('name', new_name);
		// 		}
		// 		else
		// 		{
		// 			var str_index   = curr_name.indexOf("[");
		// 			var str_index_2 = curr_name.indexOf("]");
		// 			var str_core_1  = curr_name.substring(str_index, str_index_2 + 1);
		// 			var new_name    = curr_name.substring(0,str_index);
		// 			str_core_1      = str_core_1.replace(/[0-9]/g, id);
		// 			new_name        = new_name + str_core_1;
		// 			input.attr('name', new_name);
		// 		}
				
		// 	});
		// 	panel.find(".copy_applicant1").remove();
		// 	var html = '<button type="button" class="btn btn-primary btn-xs pull-right copy_applicant1" style="margin-left: 15px;">Copy fields</button>';
		// 	panel.find(".panel-title-main").append(html);
		// 	panel.find(".business_details").remove();
		// 	panel.find(".beneficiaries_section").remove();
		// 	this_panel.append(panel);
		// 	// initAutocomplete();
		// 	set_applicant_count_values();
		// });
		$(document).on('click','.applicant-add', function(){
			
			var panel      = $(this).closest('.temp_parent_panel').clone();
			var this_panel = $(this).closest('#application_fields');
			var id         = $(this).closest(this_panel).find('.temp_parent_panel').length;
			var name = panel.find('.panel-title-main').text().replace(/[0-9]/g, "");
			var curr_name_number = parseInt(id) + 1;
			name = name + " "+ curr_name_number.toString();
			name = name.replace("Copy fields","");
			panel.find('.panel-title-main').text(name);
			panel.find('input').val('');
			// panel.find('.address-clause').find('.panel').not(':first').remove();
			// panel.find('.employer_clause').find('.panel').not(':first').remove();
			panel.find('.cred_card_clause').find('.panel').not(':first').remove();
			panel.find('.loan_clause').find('.panel').not(':first').remove();
			panel.find('.cred_reference_clause').find('.panel').not(':first').remove();
			panel.find('.property_clause').find('.panel').not(':first').remove();
			panel.find('.asset_clause').find('.panel').not(':first').remove();
			panel.find('.top-fields').remove();
			panel.find('.living_cost_clause').remove();
			panel.find('.assets').remove();
			panel.find('.car_details').remove();
			panel.find('.form-control').each(function(key, value)
			{
				var input      = $(this);
				var curr_name = input.attr('name');
				if(typeof(curr_name) == "undefined")
					//console.log(curr_name + " " + input.attr("class"));
				var count = (curr_name.match(/\[/g) || []).length;
				
				if(count == 2)
				{
					var str_index   = curr_name.indexOf("[");
					var str_index_2 = curr_name.indexOf("]");
					var str_index_3 = curr_name.lastIndexOf("]");
					var str_core_1  = curr_name.substring(str_index, str_index_2 + 1);
					var str_core_2  = curr_name.substring(str_index_2 + 1, str_index_3 + 1);
					var new_name    = curr_name.substring(0,str_index);
					str_core_1      = str_core_1.replace(/[0-9]/g, id);
					new_name        = new_name + str_core_1 + str_core_2;
					input.attr('name', new_name);
				}
				else if(count == 3)
				{
					var str_index   = curr_name.indexOf("[");
					var str_index_2 = curr_name.indexOf("]");
					var str_core_1  = curr_name.substring(str_index, str_index_2 + 1);
					var str_core_2  = curr_name.substring(str_index_2 + 1, str_index_2 + 4);
					var str_core_3  = curr_name.substring(str_index_2 + 4, str_index_2 + 8);
					var new_name    = curr_name.substring(0,str_index);
					str_core_1      = str_core_1.replace(/[0-9]/g, id);
					new_name        = new_name + str_core_1 + str_core_2 + str_core_3;
					input.attr('name', new_name);
				}
				else
				{
					var str_index   = curr_name.indexOf("[");
					var str_index_2 = curr_name.indexOf("]");
					var str_core_1  = curr_name.substring(str_index, str_index_2 + 1);
					var new_name    = curr_name.substring(0,str_index);
					str_core_1      = str_core_1.replace(/[0-9]/g, id);
					new_name        = new_name + str_core_1;
					input.attr('name', new_name);
				}
				
			});
			panel.find(".copy_applicant1").remove();
			var html = '<button type="button" class="btn btn-primary btn-xs pull-right copy_applicant1" style="margin-left: 15px;">Copy fields</button>';
			panel.find(".panel-title-main").append(html);
			panel.find(".business_details").remove();
			panel.find(".beneficiaries_section").remove();
			this_panel.append(panel);
			// initAutocomplete();
			set_applicant_count_values();
		});
		$(document).on('click','.copy_applicant1',function () {
			var first_panel = $(this).closest(".multiple_dynamic").find(".panel-main:first").find(".applicant_info");
			var this_panel = $(this).closest('.panel-main').find(".applicant_info");
			var val_arr = [];
			first_panel.find(".form-control").each(function(){
				val_arr.push($(this).val());
			});
			
			this_panel.find(".form-control").each(function(index, value){
				$(this).val(val_arr[index]);
			});
		});
		//APPLICANT REMOVE
		$(document).on('click','.applicant-remove',function () {
			
			var panel      = $(this).closest('.temp_parent_panel');
			var this_panel = $(this).closest('.temp_parent_panel').parent();
			var id         = $(this).closest(this_panel).find('.temp_parent_panel').length;
			var panel_id        = $.trim(panel.find('input[type=hidden]:first').val());
			var fapplication_id = $(document).find("#fapplication_id").val();
			var data = {
				panel_id: panel_id,
				fapplication_id: fapplication_id
			};
			if(admin_flag == "1")
				return false;
			if( confirm("Are you sure you want to remove this panel?") )
			{
				if ( id == 1 ) 
				{
					alert("You cannot remove the last form!");
					return false;
				}
				if(panel_id != "")
				{
					$.ajax({
						type: "POST",
						url: "<?php echo site_url("fapplication/delete_applicant"); ?>",
						cache: false,
						data: data,
						success: function(response){
							
						}
					});
				}
				panel.remove();
				// initAutocomplete();
				set_applicant_count_values();
			}
			
		});
		// function getPosition(str, m, i) {
		//    return str.split(m, i).join(m).length;
		// }
		// $(document).on('click', '#diarize_date', function () {
	 //        $(this).toggleClass('clicked').datepicker().datepicker('show')
	 //    });
	 	//moment(loans_value.loan_start_date).format('DD/MM/YYYY')
		$(document).on('click', '#diarize_date', function () {
	        $(this).toggleClass('clicked').datepicker({todayHighlight: true, format: 'dd/mm/yyyy'}).datepicker('show')
	    });
		$(document).on('click', '.goods_date_finalized', function () {
	        $(this).toggleClass('clicked').datepicker({format: 'dd/mm/yyyy'}).datepicker('show')
	    });
	    $(document).on('click', '.visa_date', function () {
	        $(this).toggleClass('clicked').datepicker({format: 'dd/mm/yyyy'}).datepicker('show')
	    });
	    $(document).on('click', '.date_of_birth', function () {
	        $(this).toggleClass('clicked').datepicker({format: 'dd/mm/yyyy'}).datepicker('show')
	    });
	    $(document).on('click', '.abn_date', function () {
	        $(this).toggleClass('clicked').datepicker({format: 'dd/mm/yyyy'}).datepicker('show')
	    });
	    $(document).on('click', '.dl_exp', function () {
	        $(this).toggleClass('clicked').datepicker({format: 'dd/mm/yyyy'}).datepicker('show')
	    });
	    $(document).on('click', '#car_arrival', function () {
	        $(this).toggleClass('clicked').datepicker({format: 'dd/mm/yyyy'}).datepicker('show')
	    });
	    $(document).on('click', '#date_delivered', function () {
	        $(this).toggleClass('clicked').datepicker({format: 'dd/mm/yyyy',todayHighlight: true}).datepicker('show')
	    });
	    $(document).on('click', '.loan_start_date', function () {
	        $(this).toggleClass('clicked').datepicker({format: 'dd/mm/yyyy'}).datepicker('show')
	    });
	    $(document).on('change', '#year', function() {
			var selected = $(this).find('option:selected');
			var var_code = selected.data('code');
			
			var data = {
	    		code: 3,
	    		var_code: var_code
				    }
			//console.log(var_code);
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/get_dropdown_data"); ?>",
				cache: false,
				data: data,
				dataType: 'json',
				success: function(result){
					var option = '<option value="">--Choose--</option>';
					
					for (var i in result) {
			            option = option+'<option data-id="'+result[i].id_vehicle+'" value="'+result[i].name+'">'+result[i].name+'</option>';
			          }
					$(document).find("#application_section").find('#variant').html(option);
				}
			});
	    });
		
	    $(document).on('change', '#model', function() {
			var selected = $(this).find('option:selected');
			var id = selected.data('id');
			
			// var data = {
	  //   		code: 3,
	  //   		id_model: id
			// 	    }
			var data = {
	    		code: 4,
	    		id_model: id
				    }
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/get_dropdown_data"); ?>",
				cache: false,
				data: data,
				dataType: 'json',
				success: function(result){
					var option = '<option value="">--Choose--</option>';
					
					// for (var i in result) {
			  //           option = option+'<option data-id="'+result[i].id_vehicle+'" value="'+result[i].name+'">'+result[i].name+'</option>';
			  //         }
					// $(document).find("#application_section").find('#variant').html(option);
					for (var i in result) {
			            option = option+'<option data-code="'+result[i].code+'" value="'+result[i].year+'">'+result[i].year+'</option>';
			          }
					$(document).find("#application_section").find('#year').html(option);
				}
			});
	    });
	
	    $(document).on('change', '#make', function() {
	    	var selected = $(this).find('option:selected');
			var id = selected.data('id');
			var data = {
	    		code: 2,
	    		id_make: id
				    }
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/get_dropdown_data"); ?>",
				cache: false,
				data: data,
				dataType: 'json',
				success: function(result){
					var option = '<option></option>';
					
					for (var i in result) {
			            option = option+'<option data-id="'+result[i].id_family+'" value="'+result[i].name+'">'+result[i].name+'</option>';
			          }
					$(document).find("#application_section").find('#model').html(option);
					
				}
			});
	    });	    
	    $(document).on('click', '.all_req_button', function() {
			var fapplication_id = $(document).find("#fapplication_id").val();
			var req_type        = $(this).data("req");
			var data = {
					fapplication_id: fapplication_id,
					req_type: req_type
						};
	    	$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/get_all_requirements"); ?>",
				cache: false,
				data: data,
				dataType: 'json',
				success: function(data){
					if($.trim(data.allreq_list) == "")
					{
						$(document).find(".list-merged-requirements").html("<i>You have not uploaded anything yet...</i>");
						$(document).find("#all_req_container").hide();
						$(document).find(".all_req_button").hide();
					}
					else
					{
						$(document).find("#all_req_container").show();
						$(document).find(".all_req_button").show();
						$(document).find(".all_req_container").html(data.allreq_list);
						$(document).find(".list-merged-requirements").html(data.all_final_list);
						$(document).find("#all_req_user").val(data.user);
						$(document).find("#all_req_modal_id").val(data.fk_requirement);
					}
					$('#all_requirements_modal').modal({
	                    backdrop: 'static',
	                    keyboard: false
	                });
				}
			});
			
	    });
	    $(document).on('click','.add-allreq',function(){
			
			var panel      = $(this).closest('#allreq_modal_body').find('.all_req_row:first').clone();
			var this_panel = $(".all_req_container");
			var id         = this_panel.find('.all_req_row').length;
			
			panel.find('.form-control').each(function(key, value)
			{
				var input      = $(this);
				input.val('');
				
				var count       = input.closest('.all_req_row').find('.item-count').text().replace(/[0-9]/g, id + 1);
				var curr_name   = input.attr('name');
				
				var str_index   = curr_name.indexOf("[");
				var str_index_2 = curr_name.indexOf("]");
				var str_core_1  = curr_name.substring(str_index, str_index_2 + 1);
				var new_name    = curr_name.substring(0,str_index);
				str_core_1      = str_core_1.replace(/[0-9]/g, id);
				new_name        = new_name + str_core_1;
				input.attr('name', new_name);
				input.closest('.all_req_row').find('.item-count').text(count);
			});
			this_panel.append(panel);
		});
		var curr_panel = null;
	    $(document).on('click', '.req_button', function() {
			var fapplication_id = $(document).find("#fapplication_id").val();
			var req_type        = $(this).closest(".req-panel").data("req");
			var modal_name      = $(this).closest('.col-md-3').find('.req_name').text();
			var is_temp         = $(this).closest('.req-panel').data('istemp');
			curr_panel = $(this).closest(".req-panel");
			var data = {
					fapplication_id: fapplication_id,
					req_type: req_type,
					is_temp: is_temp
						};
	    	console.log(data);
	    	$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/get_specific_requirements"); ?>",
				cache: false,
				data: data,
				dataType: 'json',
				success: function(data){
					$('#requirements_modal').find('.modal-title').text(modal_name);
					
					if($.trim(data.req_list) == "")
					{
						$(document).find("#modal_body").html("<i>You have not uploaded anything yet...</i>");
					}
					else
					{
						$(document).find("#modal_body").html(data.req_list);
						$(document).find("#req_user").val(data.user);
						$(document).find("#req_modal_id").val(data.fk_requirement);
					}
					$('#requirements_modal').modal({
	                    backdrop: 'static',
	                    keyboard: false
	                });
				}
			});
			
	    });
	    $(document).on('click', '.del_req_file', function() {
			var that           = $(this);
			var fk_user        = that.closest("#requirements_modal").find("#req_user").val();
			var fk_requirement = that.closest("#requirements_modal").find("#req_modal_id").val();
			var id_req         = that.closest(".tr_req").data("req");
			var abspath        = that.closest(".tr_req").data("abspath");
			var is_temp        = that.data('istemp');
			var data = {
					fk_user       : fk_user,
					fk_requirement: fk_requirement,
					id_req        : id_req,
					abspath       : abspath,
					is_temp 	  : is_temp
						};
			if(!confirm("Are you sure you want to delete this requirement?"))			
				return false;
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/delete_requirements"); ?>",
				cache: false,
				data: data,
				dataType: 'json',
				success: function(res_data){
					that.closest(".tr_req").remove();
					if(res_data.count == 0){
						$(document).find("#modal_body").html("<i>You have not uploaded anything yet...</i>");
						curr_panel.addClass("requirements_white").removeClass("requirements_green");
						$(curr_panel).find("*").removeClass("requirements_green").addClass("requirements_white");
						$(curr_panel).find('.del_req').removeClass('requirements_white');
					}
				}
			});
	    });
	    $(document).on('click', '.edit_req_file', function() {
	    	var hidden_input_status = $(this).closest(".tr_req").find(".input").prop("hidden");
	    	if(hidden_input_status == true){
	    		$(this).closest(".tr_req").find(".input").prop("hidden", false);
	    		$(this).closest(".tr_req").find(".link").prop("hidden", true);
	    	}
	    	else{
	    		$(this).closest(".tr_req").find(".input").prop("hidden", true);
	    		$(this).closest(".tr_req").find(".link").prop("hidden", false);
	    	}
	    	
	    });
	    $(document).on('change', '.edit_req_filename', function() {
	    	var filename = $.trim( $(this).val() );
	    	var id = $(this).closest(".tr_req").data("req");
	    	var $this = $(this);
	    	var data = {
	    		filename: filename,
	    		id: id
	    	};
	    	$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/update_requirement_filename"); ?>",
				cache: false,
				data: data,
				success: function(data){
					$this.closest(".tr_req").find(".link_name").text(filename);
					$this.closest(".tr_req").find(".input").prop("hidden", true);
		    		$this.closest(".tr_req").find(".link").prop("hidden", false);
				}
			});
	    });
	    $(document).on('click', '.del_all_req', function() {
			var that           = $(this);
			var fk_user        = that.closest("#all_requirements_modal").find("#all_req_user").val();
			var fk_requirement = that.closest("#all_requirements_modal").find("#all_req_modal_id").val();
			var id_req        = that.closest(".tr_req").data("idrequp");
			var abspath        = that.closest(".tr_req").data("abspath");
			var data = {
					fk_user       : fk_user,
					fk_requirement: fk_requirement,
					id_req       : id_req,
					abspath       : abspath
						};
			if(!confirm("Are you sure you want to delete this merged requirement?"))			
				return false;
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/delete_requirements"); ?>",
				cache: false,
				data: data,
				success: function(response){
					if($.trim(response) == "success")
					{
						that.closest(".tr_req").remove();
					}
				}
			});
	    });
	    $(document).on('click', '#merge_file', function() {
	    	var id_array = $('input[name=file_merge]:checked').map(function() {
			    return this.value;
			}).get();
			var req_type_id = $("#req_modal_id").val();
			var fq_acct_id  = $("#fapplication_id").val();
			var req_user    = $("#req_user").val();
	    	var data = {
					id_array   : id_array,
					req_type_id: req_type_id,
					fq_acct_id : fq_acct_id,
					req_user   : req_user
				    	};
	        $.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/merge_files"); ?>",
				cache: false,
				data: data,
				success: function(response){
					alert("Please re-open this modal to see the merged files included this list.");
				}
			});
	    });
	    $(document).find('.add_req_detail_container').hide();
	    $(document).on('click', '.add-requirement-details', function() {
	    	$(document).find('.add_req_detail_container').slideDown(300);
	    });
	    $(document).on('click', '.close-req-details', function() {
	    	$(document).find('.add_req_detail_container').slideUp(300);
	    });
	    $(document).on('click', '.add-req-details', function() {
			var short_name = $.trim($("#short_name").val());
			var full_name  = $.trim($("#full_name").val());
			if(short_name == '')
			{
				alert("Short Requirement Name cannot be empty!");
				return false;
			}
			if(full_name == '')
			{
				alert("Full Requirement Name cannot be empty!");
				return false;
			}
			var data = {
				short_name: short_name,
				full_name: full_name
			};
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/insert_requirement_details"); ?>",
				cache: false,
				data: data,
				success: function(data){
					$("#short_name").val("");
					$("#full_name").val("");
					$("#requirement_list").modal('hide');
				}
			});
	    });
	    $(document).on('click', '.edit-req-detail', function() {
			var that      = $(this);
			var this_id   = that.closest("tr").data("id");
			var this_tr   = that.closest("tr");
			var name_td   = that.closest("tr").find(".editable-name");
			var desc_td   = that.closest("tr").find(".editable-description");
			name_td.find('.editable_name_input').attr('disabled', false);
			desc_td.find('.editable_desc_input').attr('disabled', false);
	    });
	    $(document).on('change', '.editable', function() {
			var that   = $(this);
			var value  = $(this).val();
			var field  = $(this).data("type")
			var req_id = $(this).closest("tr").data("id");
			var data = {
				req_id: req_id,
				field: field,
				value: value
			};
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/edit_requirement_details"); ?>",
				cache: false,
				data: data,
				success: function(data){
					if(data === "success")
						that.attr('disabled', true);
				}
			});
	    });
	    $(document).on('click', '.view_sent_body', function() {
	    	var id = $(this).data("id");
	    	var data = {
	    		id: id
	    	};
	    	$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/get_email_trail_body"); ?>",
				cache: false,
				data: data,
				dataType: 'json',
				success: function(data){
					$("#sent_email_body").html(data.body);
					$("#sent_email_title").html(data.subject);
					$("#view_sent_email").modal("show");
				}
			});
	    });
	    $(document).on('click', '.delete-req-detail', function() {
	    	var that = $(this);
	    	var req_id = that.closest("tr").data("id");
	    	var data = {
	    		req_id: req_id
	    	};
	    	if(  confirm("Are you sure you want to delete this requirement?") )
	    	{
		    	$.ajax({
					type: "POST",
					url: "<?php echo site_url("fapplication/delete_requirement_details"); ?>",
					cache: false,
					data: data,
					success: function(data){
						if(data === "success")
							that.closest("tr").remove();
					}
				});
				
		    }
	    });
	    //sorting of requirements
	    // $('#requirement_list').on('hidden.bs.modal', function () {
	    // 	// return_ids_2();
	    // 	update_order();
	    // });
	    $( function() {
			$( "#req_list_tbl_body" ).sortable({
				stop: function(e, ui) {
					// return_ids_2();
					// update_order();
				}
			});
		} );
		function return_ids_2()
		{
			console.log($.map($("#req_list_tbl_body").find('tr'), function(el) {
			    // return el.id + ' = ' + ($(el).index() + 1);
			    return el.id;
			    // return el.attributes;
			}));		
		}
		function sortNumber(a,b) {
		    return a - b;
		}
		function update_order()
		{
			var order_array = [];
			var id_array = [];
			var id_fq_account = $("#fapplication_id").val();
			$.map($("#req_list_tbl_body").find('tr'), function(el) {
				id_array.push(el.id);
			});
			$(".tr_req_list").each(function(index,value){
				order_array.push($(this).data("order"));
			});
			order_array = order_array.sort(sortNumber);
			var data = {
				id_array: id_array,
				order_array: order_array,
				id_fq_account: id_fq_account
			};
			// console.log(id_array);
			// console.log(order_array);
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/update_order"); ?>",
				cache: false,
				data: data,
				success: function(response){
				}
			});
		}
		$('#requirement_list').on('hidden.bs.modal', function () {
			update_order();
		});
	    //sorting of requirements
	    $(document).on('click', '.btn-req-list', function() {
	    	var that = $(this);
	    	var id_fq_account = $("#fapplication_id").val();
	    	var data = {
	    		id_fq_account: id_fq_account
	    	};
	    	$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/set_requirement_list"); ?>",
				cache: false,
				data: data,
				dataType: 'json',
				success: function(data){
					$("#req_list_tbl_body").html(data.req_table);
					that.hide();
					$('#requirement_list').modal();
				}
			});
	    });
	    $(document).on('click', '#open_lead_popup', function() {
	    	var this_id = $(this).data("lead_id");
	    	
	    	if(this_id == "" || this_id == null || this_id == 0){
	    		alert("This calendar item doesn't have any lead connected to it!");
	    		return false;
	    	}else{
	    		var url = "<?php echo site_url('lead/record_final/'); ?>"+"/"+this_id;
	    		window.open(url, '_blank');
	    	}
	    });
	    $('#lead-modal').on('hidden.bs.modal', function () {
	    	var id_fq_account = $("#fapplication_id").val();
		    
	    	if(id_fq_account != "")
	    	{
	    		$("#fapplication-modal-3").modal({
	                backdrop: 'static',
	                keyboard: false
	            });
	    	}
	    });
	  
	    $(document).on('change','.search_lead_field', function(){
			$("#filtered_lead_search_result").html("");
			var search_lead_email = $("#search_lead_email").val();
			var search_lead_name  = $("#search_lead_name").val();
			var search_lead_make  = $("#search_lead_make").val();
			var search_lead_state = $("#search_lead_state").val();
			var data = {
				search_lead_email    : search_lead_email,
				search_lead_name     : search_lead_name,
				search_lead_make: search_lead_make,
				search_lead_state : search_lead_state
			};
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/search_lead"); ?>",
				data: data,
				cache: false,
				success: function(result){
					$("#filtered_lead_search_result").html(result);
					$("#final_search_result").html("");
				}
			});
		});
		$(document).on('click','.select_lead', function(){
			var lead_id = $(this).data("lead_id");
			var data = {
				lead_id: lead_id
			}
			$("#final_search_result").html("");
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/get_specific_lead"); ?>",
				data: data,
				cache: false,
				success: function(result){
					$("#filtered_lead_search_result").html("");
					$("#final_search_result").html(result);
				}
			});
		});
		$(document).on('click','#assing_lead_btn', function(){
			var lead_id       = $("#hidden_assign_lead_id").val();
			var id_fq_account = $("#fapplication_id").val();
			var data = {
				lead_id: lead_id,
				id_fq_account: id_fq_account
			}
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/assign_lead_to_fq"); ?>",
				data: data,
				cache: false,
				success: function(result){
					$("#map_lead_modal").modal("hide")
					location.reload();
				}
			});
		});
	    $(document).on('click', '.diarize_btn', function() {
	    	$(this).hide();
	    	$('#diarize_modal').modal();
	    });
	    $('#diarize_modal').on('hidden.bs.modal', function () {
	    	$(".diarize_btn").show(500);
	    	$('input[name="alarm_status"]').prop('checked', false);
	    });
	    $('#requirement_list').on('hidden.bs.modal', function () {
	    	$(".btn-req-list").show(500);
	    	$('#datatable-default').dataTable().fnDestroy();
	    });
	    $(document).on('click', '.temp_email', function() {

	    	var lead_name = $(document).find("#fq_lead_name").text();
	    	var subject = lead_name + " Tax Invoice Request";
	    	$("#email_recipients").val($("#supplier_email").val());
	    	$("#email_subject").val(subject);
	    	$("#hidden_attachment").val("");
	    	$(document).find(".temp_tax_invoice").remove();
	    	$('#temp_email_modal').modal();
	    });
	    $('#temp_email_modal').on('hidden.bs.modal', function () {
	    	$(".temp_email").show(500);
	    });
		$(document).on('click','#diarize_submit',function () {

			var alarm_status = $('input[name="alarm_status"]').prop('checked');
			alarm_status = (alarm_status == true) ? '1':'0';

			var date          = $.trim($("#diarize_date").val());
			var time          = $.trim($("#diarize_time").val());
			var id_fq_account = $("#fapplication_id").val();
			var data = {
				date: date,
				time: time,
				id_fq_account: id_fq_account,
				alarm_status: alarm_status
			};
			
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/diarize"); ?>",
				cache: false,
				data: data,
				dataType: 'json',
				success: function(data){
					save_fapplication_info_2();
					$("#fapplication-modal-3").modal('hide');
					var event_arr = $('#calendar').fullCalendar('clientEvents', id_fq_account);
					var final_event = event_arr[0];
					final_event.start = data.start;
					final_event.end   = data.end;
				
					$("#calendar").fullCalendar('updateEvent',final_event);
				}
			});	
		});	    
	    $(document).on('click', '.assign_cqo', function() {
	    	var $this = $(this);
	    	var this_modal = $('#assign_cqo');
	    	var lead_id = $("#lead_id_fq").val();
	    	var data = {
	    		lead_id: lead_id
	    	};
	    	$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/get_cqo_staff"); ?>",
				cache: false,
				data: data,
				dataType: 'json',
				success: function(data){
					if(lead_id == "")
					{
						$("#cqo_staff_ddown").prop('disabled',true);
						$("#assign_cqo_staff_submit").prop('disabled',true);
					}
					if(data.assigned_flag == 0)
					{
						$("#cqo_staff_ddown").prop('disabled',true);
						$("#assign_cqo_staff_submit").prop('disabled',true);
					}
					else if(data.assigned_flag == 1)
					{
						$("#cqo_staff_ddown").prop('disabled',false);
						$("#assign_cqo_staff_submit").prop('disabled',false);
					}
					this_modal.find("#cqo_staff_ddown").html(data.option_string);
					$this.hide();
					$('#assign_cqo').modal();
				}
			});
	    });
	    $(document).on('click', '#assign_cqo_staff_submit', function() {
			var this_modal      = $('#assign_cqo');
			var fapplication_id = $(document).find("#fapplication_id").val();
			var assigned_name   = this_modal.find("#cqo_staff_ddown option:selected").text();
			var assigned_id     = this_modal.find("#cqo_staff_ddown").val();
			var lead_id         = $("#lead_id_fq").val();
	    	var data = {
				fapplication_id: fapplication_id,
				assigned_name: assigned_name,
				assigned_id: assigned_id,
				lead_id: lead_id
	    	}
	    	
	    	$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/assign_cqo_staff"); ?>",
				data: data,
				cache: false,
				success: function(response){
					$("#cq_staff_name_text").text(assigned_name);
					this_modal.modal('hide');
				}
			});
	    })
	    $('#assign_cqo').on('hidden.bs.modal', function () {
	    	$(".assign_cqo").show(500);
	    });
	    $(document).on('focusin', '.pages', function() {
	    	$(this).tooltip('show');
	    });
	    
	    $(".saved_alert").hide();
	    $(document).on('click', '.btn-sidenote', function() {
	    	get_notes_data();
	    });
	    $(document).on('click', '.btn-close-note', function() {
	    	$(this).closest(".side-note").slideUp(500);
	    	$(".side-note").removeClass("active");
	    });
	    $(document).on('click', '.view_note', function() {
	    	var that = $(this);
	    	var note_id = that.closest('.history_list').data('note-id');
	    	var data = {
	    		note_id: note_id
	    	};
	    	$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/view_note"); ?>",
				cache: false,
				data: data,
				dataType: 'json',
				success: function(data){
					$('#view_note_modal_label').text(data.created_at);
					$('#view_note_body').html(data.note)
					$('#view_note_modal').modal('show');
				}
			});
	    });
	    var curr_req = "";
		$(document).on('click', '.temp_dzone', function(){
			$(document).find("#req_hidden_val").val($(this).data("req"));
			$(document).find("#is_temp_hidden").val($(this).data("istemp"));
			curr_req = $(this);
		});
	    $(document).on('click', '.add_req', function() {

			var req_id          = $(this).closest('.input-group').find('.ddown_req').val();
			var req_name        = $(this).closest('.input-group').find('.ddown_req option:selected').text();
			var fapplication_id = $(document).find("#fapplication_id").val();
			var type            = $(this).data('type');
			if(req_id == '')
				return false;
			$(this).closest('.input-group').find('.ddown_req option:selected').remove();
			var data = {
				fapplication_id: fapplication_id,
				req_id: req_id,
				type: type
			}
			if(type == 1)
				var append_class = ".requirements_section_row";
			else
				var append_class = ".settlement_section_row";
			
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/add_new_req"); ?>",
				cache: false,
				data: data,
				success: function(data){
					
					var dzone_count = $(document).find('.temp_dzone').length + 1;
					var dom = "<div class='col-md-3'>\
								<div class='row'>\
									<div class='col-md-12'>\
										<div class='panel panel-default'>\
											<div class='req-panel panel-body requirements_white temp_dzone requirements-temp-"+dzone_count+" ' data-req='"+req_id+"' data-istemp='1' data-idreq='"+data+"'>\
													<label class='f-label req_name requirements_white'>"+req_name+"</label>\
												<div class='pull-right'>\
													<a class='fa fa-desktop req_button requirements_white'></a>&nbsp;\
													<a class='fa fa-trash-o del_req requirements_white'></a>\
												</div>\
											</div>\
										</div>\
									</div>\
								</div>\
							</div>";
					$(document).find(append_class).append(dom);
					
					$(document).find('.requirements-temp-'+dzone_count).dropzone ({
					
				        url: '<?php echo site_url('fapplication/upload_requirements/'); ?>',
				        init: function() {
				        	var requirement_fk = "";
				        	var temp_is = "";
				            this.on("sending", function(file, xhr, formData){
								var id             = $('#fapplication_id').val();
								var fk_requirement = $("#req_hidden_val").val();
								var is_temp         = $("#is_temp_hidden").val();
								if(requirement_fk == "")
								{
									formData.append("id", id);
									formData.append("fk_requirement", fk_requirement);
									formData.append("is_temp", is_temp);
								}
								else
								{
									formData.append("id", id);
									formData.append("fk_requirement", requirement_fk);
									formData.append("is_temp", temp_is);	
								}
								console.log("sending");
							}),
							this.on("success", function(file, response){
								
								if(requirement_fk == "")
								{
									if(!curr_req.hasClass("requirements_green"))
										curr_req.addClass("requirements_green");
								}
								
								requirement_fk = "";
								temp_is = "";
								
							}),
							this.on("queuecomplete", function () {
								//console.log("queuecomplete");
							    this.removeAllFiles();
							}),
							this.on("drop", function (event) {
								
							    requirement_fk = event.target.dataset.req;
							    temp_is = event.target.dataset.istemp;
							    if(event.target.className != "req-panel panel-body requirements dz-clickable")
							    	event.target.className = "req-panel panel-body requirements dz-clickable";
							});
						},
					
					});
				}
			});
	    });
	    $(document).on('click', '.del_global_file', function() {
			var that           = $(this);
			var id_req         = that.closest(".tr_req").data("req");
			var abspath        = that.closest(".tr_req").data("abspath");
			var data = {
					id_req        : id_req,
					abspath       : abspath
						};
			if(!confirm("Are you sure you want to delete this requirement?"))			
				return false;
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/delete_global_requirements"); ?>",
				cache: false,
				data: data,
				success: function(data){
					that.closest(".tr_req").remove();
				}
			});
	    });
	    $(document).find('.global_upload').dropzone ({
	        url: '<?php echo site_url('fapplication/upload_global_req/'); ?>',
	        init: function() {
	            this.on("sending", function(file, xhr, formData){
					
				}),
				this.on("success", function(file, response){
					var obj = jQuery.parseJSON(response);
					var html = "<tr class='tr_req'  data-req='"+obj.req+"' data-abspath='"+obj.name+"'>\
								<td><a target='_blank' href='"+obj.absolute_path+"'>"+obj.name+"</a></td>\
								<td><a class='fa fa-trash-o del_global_file'></a></td>\
							</tr>";
					$("#global_table_body").append(html);
				}),
				this.on("queuecomplete", function () {
				    this.removeAllFiles();
				});
			},
		
		});
	    //global requirements
		$(document).on('click', '.global_dep', function() {
			$.ajax({
		    	type: "POST",
				url: "<?php echo site_url("fapplication/get_global_req"); ?>",
				cache: false,
				dataType: 'json',
				success: function(data){
					
					if($.trim(data.global_req_list) == "")
					{
						$(document).find("#global_table_body").html("<i id='no_upload_i'>You have not uploaded anything yet...</i>");
					}
					else
					{	$(document).find("#no_upload_i").remove();
						$(document).find("#global_table_body").html(data.global_req_list);
					}
					$('#global_dep_modal').modal('show');
				}
		    });
		});

		$(document).on('click', '#close_global_dep_modal', function(){
			$("#global_dep_modal").modal('hide');
		});

	    $(document).on('click', '.del_req', function() {
			var that            = $(this);
			var req             = that.closest('.panel-body').data('req');
			var id_req          = that.closest('.panel-body').data('idreq');

			if(id_req == undefined || id_req == ''){
				id_req          	= 	that.data("id-fq");
				req          	=	that.data("id");
			} 
			
			var fapplication_id = $(document).find("#fapplication_id").val();
			var is_temp         = that.closest('.panel-body').data('istemp');
	    	if( !confirm("Are you sure you want to delete this requirement panel?") )
		    	return false;	
		    var data = {
		    	req: req,
		    	fapplication_id: fapplication_id,
		    	is_temp: is_temp,
		    	id_req: id_req
		    }
		    
		    $.ajax({
		    	type: "POST",
				url: "<?php echo site_url("fapplication/del_new_req"); ?>",
				cache: false,
				data: data,
				success: function(response){
					if( response == "success" )
					{
						that.closest('.row').closest('.col-md-3').remove();
					}
				}
		    });
	    });
	    $(document).on('click', '.hide_req', function() {
	    	var fapplication_id = $(this).data("id-fq");
	    	var id_req = $(this).data("id");
	    	var $this = $(this);
	    	var data = {
	    		fapplication_id: fapplication_id,
	    		id_req: id_req
	    	};
	    	confirm( "Are you sure you want to delete this requirement tab?" )
	    	{
		    	$.ajax({
			    	type: "POST",
					url: "<?php echo site_url("fapplication/hide_permanent_requirement"); ?>",
					cache: false,
					data: data,
					success: function(response){
						$this.closest(".col-md-3").prop("hidden", true);
					}
			    });
			}
	    });
	    $(document).on('click', '.new-cal-item', function() {
	    	
	    	$('#new_calendar_modal').modal({
                backdrop: 'static',
                keyboard: false
            });
	    });
	    $(document).on('change', '#new_cal_make', function() {
			var selected = $(this).find('option:selected');
			var id = selected.data('id');
			var data = {
	    		code: 2,
	    		id_make: id
				    }
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/get_dropdown_data"); ?>",
				cache: false,
				data: data,
				dataType: 'json',
				success: function(result){
					var option = '<option value=""></option>';
					
					for (var i in result) {
			            option = option+'<option data-id="'+result[i].id_family+'" value="'+result[i].name+'">'+result[i].name+'</option>';
			          }
					$(document).find('#new_cal_model').html(option);
				}
			});
	    });
		$(document).on('click', '#save_new_cal_item', function() {
			var that = $(this);
			var data = $('.new-cal-form').serialize();
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/create_new_calendar_item"); ?>",
				cache: false,
				data: data,
				success: function(result){
					//console.log(result);
					if(result)
					{
						$('.new-cal-form').find('.form-control').each(function(){
							$(this).val("");
						});
						$('#new_calendar_modal').modal('hide');
						location.reload();
					}	
				}
			});
		});
		$(document).on("click", ".update_status_btn", function(){
			$("#change_color_status_modal").modal();
		});
		$(document).on("click", "#update_color_status_btn", function(){
			var fapplication_id = $(document).find("#fapplication_id").val();
			var status = $("#update_status_color_field").val();
			var data = {
				fapplication_id: fapplication_id,
				status         : status
			};
			var class_name = 'cal_item_' + fapplication_id;
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/update_status_color"); ?>",
				cache: false,
				data: data,
				dataType: 'json',
				success: function(result){
					var event_arr = $('#calendar').fullCalendar('clientEvents', fapplication_id);
					var final_event = event_arr[0];
					final_event.backgroundColor = result.color;
					
					$("#calendar").fullCalendar('updateEvent',final_event);
					$("#change_color_status_modal").modal("hide");
				}
			});
		});
		function getAge(birthDateString) {
		    var today = new Date();
		    var birthDate = new Date(birthDateString);
		    var age = today.getFullYear() - birthDate.getFullYear();
		    var m = today.getMonth() - birthDate.getMonth();
		    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
		        age--;
		    }
		    return age;
		}
		function set_requirements()
		{
			var type            = $(document).find('#cust_type').val();
			var loan_use        = $("#loan_use").val();
			var app_count       = $('#applicant_count').val();
			var amt_to_finance  = $('#amt_to_finance').val();
			var loan_type  = $('#loan_type').val();
			var assessment_type = $('#assessment_type').val();
			var lender          = $('#lender').val();
			var fapplication_id = $(document).find("#fapplication_id").val();
			var req_pan_type    = 1;
			var other_income_flag = $(document).find(".panel-main:first").find(".employer_clause:first").find(".false-panel:first").find(".other_income_id").val();
			var renting_flag      = $(document).find(".panel-main:first").find(".address-clause:first").find(".panel:first").find(".client_res_stat").val();
			var name_on_title_flag = $(document).find(".property_clause:first").find(".panel:first").find(".name_on_title").prop('checked');
			var managed = $(document).find(".property_clause:first").find(".panel:first").find(".managed").prop('checked');
			var visa = $(document).find(".initial_address_panel:first").find(".visa_holder").prop('checked');
			var payout            = $(document).find("#payout").val();
			var gap               = $(document).find("#gap").val();
			var lti               = $(document).find("#lti").val();
			var requirement = [];
			requirement.push(65,22,8,5,22,2,11,15,46,16,59,21,19,90,91,58,52,88,33,31,30,85,40,29,92,101);
			if(lender == "ANZ")
				requirement.push(88,46);
			if(loan_use == "consumer")
				requirement.push(67);
			if(name_on_title_flag)
				requirement.push(22);
			if(visa)
				requirement.push(118);
			if(managed)
				requirement.push(10);
			if(loan_use == "consumer" && loan_type == "Chattel Mortgage")
				requirement.push(42);
			if(assessment_type == "Full Doc")
				requirement.push(102);
			if(parseFloat(payout) > 0)
				requirement.push(12);
			if(parseFloat(gap) > 0)
				requirement.push(37);
			if(parseFloat(gap) > 0)
				requirement.push(38);
			//console.log(requirement);
			var ddown_storage = $('#new_req_temp_storage').html();
			$('#new_req').html(ddown_storage);
			$.each(requirement, function (index, value) {
				$('#new_req').find('option[value="'+value+'"]').remove();
			});
			$('.req_sec_panel').find('.req-panel').each(function(){
				var that    = $(this);
				var data_id = that.data('req');
				var this_panel = that.closest('.col-md-3');
				this_panel.prop('hidden',true);
			});
			$('.req_sec_panel').find('.req-panel').each(function(){
				var that    = $(this);
				var data_id = that.data('req');
				var this_panel = that.closest('.col-md-3');
				$.each(requirement, function (index, value) {
					if(value == data_id)
					{
						this_panel.prop('hidden',false);
					}
				});
			});
		}
	    $(document).on('click', '.send_email_invoice', function() {
	    	var id = $(document).find("#fapplication_id").val();
			var email_subject = $("#temp_email_modal").find("#email_subject").val();
			var recipients    = $("#temp_email_modal").find("#email_recipients").val();
			var attachment    = $("#temp_email_modal").find("#hidden_attachment").val();
			var email_message = $("#temp_email_modal").find("#email_content").code();
			// var email_message = $("#temp_email_modal").find("#email_content").val();
			email_message = replaceAll(email_message, '&quot;', '%27');
			email_message = replaceAll(email_message, '&lt;', '%3C');
			email_message = replaceAll(email_message, '&qt;', '%3E');
			email_message = replaceAll(email_message, '&amp;', '%26');
			email_message = replaceAll(email_message, '&', '%26');
			
			var data = {
				email_message: email_message,
				email_subject: email_subject,
				id           : id,
				recipients   : recipients,
				attachment   : attachment
			};
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/send_tax_invoice_email"); ?>",
				data: data,
				cache: false,
				success: function(result){
					$("#temp_email_modal").modal("hide");
				}
			});
	    });
	    $(document).on('click', '.attach_tax_invoice', function() {
	    	var id = $(document).find("#fapplication_id").val();
	    	$(document).find(".temp_tax_invoice").remove();
	    	var data = {
	    		id: id
	    	};
	    	$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/new_tax_invoice_export"); ?>",
				data: data,
				cache: false,
				dataType: 'json',
				success: function(data){
					var html = "<a class='temp_tax_invoice' target='_blank' href='"+data.abslink+"'>"+data.file_name+"</a>";
					$("#temp_email_modal").find(".invoice_btn_div").append(html);
					$("#temp_email_modal").find("#hidden_attachment").val(data.abspath);
				}
			});
	    });
	    
		function myFunction() { 
		     if((navigator.userAgent.indexOf("Opera") || navigator.userAgent.indexOf('OPR')) != -1 ) 
		    {
		        alert('Opera');
		    }
		    else if(navigator.userAgent.indexOf("Chrome") != -1 )
		    {
		        alert('Chrome');
		    }
		    else if(navigator.userAgent.indexOf("Safari") != -1)
		    {
		        alert('Safari');
		    }
		    else if(navigator.userAgent.indexOf("Firefox") != -1 ) 
		    {
		         alert('Firefox');
		    }
		    else if((navigator.userAgent.indexOf("MSIE") != -1 ) || (!!document.documentMode == true )) //IF IE > 10
		    {
		      alert('IE'); 
		    }  
		    else 
		    {
		       alert('unknown');
		    }
	    }
	    $(document).on('click','.f-label', function () {
	    	var $this = $(this);
	    	var to_be_copied = $this.closest(".form-group").find(".form-control");
	    	if($this.closest(".toggle").attr("id") == "deal_structure")
				to_be_copied = $this.closest(".row").find(".form-control");	    		
	    	if(navigator.userAgent.indexOf("Firefox") != -1)
	    	{
	    		var to_be_copied = $this.closest(".form-group").find(".form-control").val();
	    		if($this.closest(".toggle").attr("id") == "deal_structure")
					to_be_copied = $this.closest(".row").find(".form-control").val();
	    		copyToClipboardPopUp(to_be_copied);
	    	}
	    	else
	    	{
	    		copyToClipboard(to_be_copied);
	    	}
	    });
		$(document).on('click','.dealer-label', function () {
	    	var this_value = $("#dealer option:selected").val();
	    	if(navigator.userAgent.indexOf("Firefox") != -1)
	    	{
	    		copyToClipboardPopUp(this_value);
	    	}
	    	else
	    	{
	    		var $temp = $("<input>");
			    $("body").append($temp);
			    $temp.val(this_value).select();
			    document.execCommand("copy");
			    $temp.remove();
	    	}
	    });	    
	    // $(document).on('change','#dealer', function () {
	    // 	console.log($(this).val());
	    // });
	 //    dealer.on("change", function (e) {
		// 	console.log($(this).attr("data-dealid"));
		// });
		$(document).on("change", "#dealer", function(){
			var id = $("#dealer option:selected").attr("data-dealid");
			var data = {
				id: id
			};
			$("#supplier_contact").val("");
			$("#supplier_email").val("");
			$("#supplier_mobile").val("");
			$("#supplier_landline").val("");
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/get_dealer_fields"); ?>",
				data: data,
				cache: false,
				dataType: 'json',
				success: function(data){
					$("#supplier_contact").val(data.name);
					$("#supplier_landline").val(data.phone);
					$("#supplier_email").val(data.username);
					$("#supplier_mobile").val(data.mobile);
					$("#dealer_street_address").val(data.address);
					$("#dealer_postcode").val(data.postcode);
					remove_no_val();
				}
			});
		})
	    function copyToClipboard(element) {
		    var $temp = $("<input>");
		    $("body").append($temp);
		    $temp.val($(element).val()).select();
		    document.execCommand("copy");
		    $temp.remove();
		}
		function copyToClipboardPopUp(text) {
			window.prompt("Copy to clipboard: Ctrl+C, Enter", text);
		}
		var masked_num = null;
		var def_number = "";
		var focusout_flag = 0;
		var options =  {
			onKeyPress: function(cep, e, field, options){
				var masks = ['9999 999 999', '99 9999 9999'];
				var _temp = cep.substring(0, 2); 
				
				if(_temp == 02 || _temp == 03 || _temp == 07 || _temp == 08){
					mask = masks[1];
				}
				else{
					mask = masks[0];
				}
				masked_num.mask(mask, options);
			}
		};
		
		$(document).on('click', '.masked', function(){
			masked_num = $(this);
			def_number = masked_num.val();
			
			masked_num.mask('9999 999 999', options);
			if(def_number != masked_num.val() && masked_num.val() != ""){
				masked_num.val(def_number);
			}
		}).on('blur','.masked', function(){
			focusout_flag = 0;
			
			if(def_number != masked_num.val() && masked_num.val() != ""){
				
				focusout_flag = 1;
			}
			else if(masked_num.val() == ""){
				focusout_flag = 1;
				masked_num.val("");
			}
		});
		$(document).on('click', '.delete_floating_btn', function() {
			var fapplication_id = $("#fapplication_id").val();
			var data = {
				fapplication_id: fapplication_id,
				isDelete : false
			};
			if( confirm( "Are you sure you want to delete this calendar item?" ) )
			{
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("fapplication/delete_cal_item"); ?>",
					data: data,
					
					success: function(data){
						location.reload();
					}
				});
			}
		});
		$(document).on('change', '.abn', function() {
			$(document).find(".abr_name").val("");
			$("#anb_results").html("");
			var abn       = $(this).val();
			var search_by = "abn";
			var data = {
				abn      : abn,
				search_by: search_by
			};
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/process_abn"); ?>",
				data: data,
				cache: false,
				success: function(response){
					$("#anb_results").html(response);
				}
			});
		});
		$(document).on('click', '.search_abn_btn', function() {
			
			$(document).find(".abn").val("");
			$("#anb_results").html("");
			var abr_name       = $(".abn_name").val();
			var search_by = "name";
			var data = {
				abr_name : abr_name,
				search_by: search_by
			};
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/process_abn"); ?>",
				data: data,
				cache: false,
				success: function(response){
					$("#anb_results").html(response);
				}
			});
		});
		$(document).on('click', '.choose_temp_abn', function() {
			var abn = $(this).data("abn");
			var search_by = "abn";
			var data = {
				abn      : abn,
				search_by: search_by
			};
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/process_abn"); ?>",
				data: data,
				cache: false,
				success: function(response){
					$("#anb_results").html("");
					$("#anb_results").html(response);
				}
			});
		});
		$(document).on('click', '.choose_final_abn', function() {
			$("#abn").val($("#res_abn").text());
			$("#abr_name").val($("#res_abn_name").text());
			$("#trading_name").val($("#hidden_trading_name").val());
			$("#abn_date").val($("#res_abn_date").text());
			$("#gst_registered").val($("#res_gst_date").text());
			$("#trade_post_code").val($("#abn_postcode").text());
			$("#abn_modal").modal('hide');
			$("#anb_results").html("");
			$(document).find(".abn").val("");
			$(document).find(".abr_name").val("");
		});
		$(document).on('click', '.abn_popup', function() {
			$("#abn_modal").modal({
                backdrop: 'static',
                keyboard: false
            });
		});
		$(document).on('click','.close_abn_modal', function() {
			$("#abn_modal").modal('hide');
		});
		//TEMPORARY FILE MERGER
		var initial_i = 10;
		var ctr = 1;
		var progress = $("#all_requirements_modal").find(".progress");
		var progress_bar = progress.find(".progress-bar");
		var interval = null;
		function load(count = 0)
		{
			if(count > 0)
			{
			  	ctr = count;
			}
			
		  var percentage = initial_i * ctr;
		  var width = percentage.toString() + "%";
		  
		  progress_bar.attr("aria-valuenow", percentage);
		  progress_bar.css("width", width);
		  progress_bar.text(width);
		  
		  if(ctr == 10)
		  {
		    progress_bar.text(width + "  This may take longer than intended. Please wait...");
		    clearInterval(interval);
		  }
		  ctr++;
		}
		var sort_group = "";
		var sortClass = document.getElementsByClassName('sort2');
		$(document).on('click', '#all_merge_file', function() {
			progress.prop("hidden", false);
			interval = setInterval(load,1000);
			var this_modal = $("#temp_tile_merger");
			var fq_acct_id  = $("#fapplication_id").val();
			var id_req_up_arr = [];
			var name_arr      = [];
			$('.all_req_ddown option:selected').each(function (index, value){
				
				var id_req_up = $(this).val();
				var name      = $(this).data("filename");
				id_req_up_arr.push(id_req_up);
				name_arr.push(name);
			});
			var data = {
				id_req_up_arr: id_req_up_arr,
				name_arr     : name_arr,
				fq_acct_id   : fq_acct_id
			};
			var html = "";
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/open_demo_merger"); ?>",
				cache: false,
				data: data,
				dataType: 'json',
				success: function(data){
					progress.prop("hidden", true);
					clearInterval(interval);
					load(10);
					var sort_num = 0;
					$('#all_requirements_modal').modal('hide');
					html += "<div class='row'>";
					for (var j = 0; j < data.files.length; j++) {
						html += "<div class='col-md-6'>";
						html += '<ul id="sort'+String(j)+'" class="sort">';
						for (var i = 0; i < data.files[j].length; i++) {
							var page = 0;
							page = i + 1;
							html += '<li href="'+data.files[j][i].return_abspath+'" class="ui-state-default image-popup-vertical-fit"  data-returnfilename="'+data.files[j][i].return_filename+'" data-origfilename="'+data.files[j][i].orig_file_name+'" id="'+page+'"><button class="close">X</button><img src="'+data.files[j][i].return_abspath+'" width="100" height="140"></li>';
						}
						html += '</ul>';
						html += '</div>';
						sort_group += " #sort"+String(j)+",";
					}
					sort_group = sort_group.replace(/,+$/,'');
					html += '</div>';
					$(this_modal).find("#doc_merger_body").html(html);
					$(sort_group).sortable({
						connectWith: ".sort2",
			            remove: function(event, ui) {
			                ui.item.clone().appendTo('#sortX');
			                $(this).sortable('cancel');
			            },
			            placeholder: "ui-state-highlight"
					});
					$("#sortX").sortable({
						placeholder: "ui-state-highlight"
					});
					$(this_modal).modal({
	                    backdrop: 'static',
	                    keyboard: false
	                });
	                ctr = 1;
				},
				error: function(xhr,status,error){
					//console.log(xhr);
					//console.log(status);
					//console.log(error);
					clearInterval(interval);
					load(10);
					progress_bar.text("Initialization failed!");
					ctr = 1;
				}
			});
			$('.full_loader').hide();
	    });
		$(document).on('click','.image-popup-vertical-fit', function(){
			$(this).magnificPopup({
				type: 'image',
				closeOnContentClick: true,
				mainClass: 'mfp-img-mobile',
				image: {
					verticalFit: true
				}
				
			});
		});
		$('#temp_tile_merger').on('hidden.bs.modal', function () {
	    	var this_modal = $("#temp_tile_merger");
	    	var sort_group_old = $(document).find('.sort');
	    	var return_array = [];
	    	sort_group_old.find('li').each(function(index, value){
	    		return_array.push($(this).data("returnfilename"));
	    	});
	    	var data = {
	    		return_array: return_array
	    	};
	    	$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/delete_temporary_pages"); ?>",
				data: data,
				cache: false,
				success: function(response){
				}
			});
	    });
		$(document).on('click', '.close_merger_modal', function(){
			$("#temp_tile_merger").modal('hide');
		});
		$(document).on('click', '.close_anon_modal', function(){
			$("#annot_tile_modal").modal('hide');
		});
		$(document).on('click', '.close_edit_pdf_final', function(){
			$("#edit_pdf_modal_final").modal('hide');
		});
		$(document).on('click', '.close', function(){
			$(this).closest("li").remove();
			return_ids();
		});
		function return_ids()
		{
			for (var i = 0; i < sortClass.length; i++) {
				console.log($.map($(sortClass[i]).find('li'), function(el) {
				    return el.id + ' = ' + $(el).index();
				}));		
			}
		}
		$(document).on('click', '.submit_merged', function(){
			
			var id_array   = [];
			var file_array = [];
			var file_name  = $.trim($("#new_file_name").val());
			var fq_acct_id = $("#fapplication_id").val();
			if(file_name == "")
			{
				alert("File name cannot be blank!");
				return false;
			}
			$.map($(sortClass[0]).find('li'), function(el) {
			    id_array.push(el.id);
			});
			file_array = $("#sortX").sortable('toArray', { attribute: 'data-origfilename' });
			// $("#id_array").val(id_array);
			// $("#hidden_form").submit();
			var data = {
				id_array  : id_array,
				file_array: file_array,
				file_name : file_name,
				fq_acct_id: fq_acct_id
			}
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/final_merge"); ?>",
				data: data,
				cache: false,
				success: function(response){
					$('#temp_tile_merger').modal('hide');
				}
			});
		});
	    $('#temp_tile_merger').on('hidden.bs.modal', function () {
	    	sort_group = "";
	    	$('.sort').remove();
	    	// console.log(sort_group);
	    	$("#all_requirements_modal").modal('show');
	    });
	     $('#all_requirements_modal').on('shown.bs.modal', function () {
	     	$("#progress_bar").prop("hidden", true);
	    });
	    //TEMPORARY FILE MERGER
		var final_array_anot = [];
		var final_sig_anot   = [];
		var final_page_val   = 0;
		var final_x          = 0.00;
		var final_y          = 0.00;
		var temp_array_top   = [];
		var page_image_count = [];
		var temp_state_array = {};
		var temp_top_state = [];
	    $(document).on('click', '.edit_req', function() {
	    	var this_modal = $("#annot_tile_modal");
			var that     = $(this);
			var filename = that.closest('.tr_req').data('abspath');
			var id_req   = that.closest('.tr_req').data('idrequp');
			var id_req_up_arr = [];
			var name_arr      = [];
		    var data = {
		    	filename: filename,
		    	id_req: id_req
		    };
		    var html = "";
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/open_annot_modal"); ?>",
				cache: false,
				data: data,
				dataType: 'json',
				success: function(data){
					$('#all_requirements_modal').modal('hide');
					var sort_num = 0;				
					html += "<div class='row'>";
					html += "<div class='col-md-12'>";
					html += '<ul id="sort_anon" class="sort_anon">';
					for (var i = 0; i < data.files.length; i++) {
						var page = 0;
						page = i + 1;
						html += '<li data-page="'+page+'" data-absolute="'+data.files[i].return_abspath+'" class="ui-state-default annot_page"  data-returnfilename="'+data.files[i].return_filename+'" data-origfilename="'+data.files[i].orig_file_name+'" id="'+page+'"><img src="'+data.files[i].return_abspath+'" width="100" height="140"></li>';
						page_image_count[page] = 0;
					}
					html += '</ul>';
					html += '</div>';
					html += '</div>';
					$(this_modal).find("#annotate_body").html(html);
					$(this_modal).find("#hidden_orig_file_name").val(data.original_filename);
					$("#sort_anon").sortable({
			            remove: function(event, ui) {
			                $(this).sortable('cancel');
			            },
			            placeholder: "ui-state-highlight"
					});
					$(this_modal).modal({
	                    backdrop: 'static',
	                    keyboard: false
	                });
				},
				error: function( jqXHR, textStatus, errorThrown ){
					//console.log(jqXHR);
					//console.log(textStatus);
					//console.log(errorThrown);
				}
			});
	    });
	    //canvas
	    var click_flagger = 0;
	    var states=[];
	    var canvas = null;
	    var context = null;
	    var canvas_click = null;
	    var absolute_path = "";
	    var background = null;
		var img = null;
		var check_image = null;
		var anot_text  = "";
		var anot_font  = "";
		var anot_size  = "";
		var anot_color = "";
	    var w = "";
	    var h = "";
	    function getImageDimension(el, onReady) {    
		    var src = typeof el.attr === 'function' ? el.attr('src') : el.src !== undefined ? el.src : el;
		    var image = new Image();
		    image.onload = function(){
		        if(typeof(onReady) == 'function') {
		            onReady({
		                width: image.width,
		                height: image.height
		            });
		        }
		    };
		    image.src = src;
		}
		function getMousePos(canvas, evt) {
			var rect = canvas.getBoundingClientRect();
			return {
				x: evt.clientX - rect.left,
				y: evt.clientY - rect.top
			};
		}
		$(document).on('click', '#input_anot_settings', function() {
			anot_text  = $("#input_txt").val();
			anot_font  = $("#font").val();
			anot_size  = $("#font_size").val();
			anot_color = $("#anot_color").val();
			click_flagger = 1;
		});
	    $(document).on('click', '.annot_page', function() {
	    	temp_state_array = {};
	    	img=new Image();
	    	check_image = new Image();
		    img.src="http://myelquoto.com.au/assets/img/paul-sig-2.png";
		    check_image.src="http://myelquoto.com.au/assets/img/check.png";
			var this_page  = $(this).data("page");
			absolute_path  = $(this).data("absolute");
			var this_modal = $("#edit_pdf_modal_final");
			final_page_val = this_page;
			canvas = document.getElementById('anot_canvas');
			context = canvas.getContext('2d');
			getImageDimension(absolute_path, function(d){ 
				canvas.height = d.height;
				canvas.width = d.width;
				w = d.height;
				h = d.width;
			});
			canvas.onclick=function(e){
				if(click_flagger==1){
					insertTextClick(e);
				}
				else if(click_flagger==0){
					handleClick(e,1); 
				}
			};
			function insertTextClick(e){
				if(anot_color == "")
					anot_color = 'red';
				var temp_arr     = [];
				var temp_x       = 0.00;
				var temp_y       = 0.00
				var mousePos     = getMousePos(canvas, e);
				context.font      = anot_size+'pt '+anot_font;
				context.fillStyle = anot_color;
				context.fillText(anot_text, mousePos.x, mousePos.y);
				temp_x = mousePos.x / parseFloat(canvas.width);
				temp_y = mousePos.y / parseFloat(canvas.height);
				temp_arr = {
					anot_size : anot_size,
					anot_font : anot_font,
					anot_text : anot_text,
					anot_color: anot_color,
					temp_x    : temp_x,
					temp_y    : temp_y,
					x         : mousePos.x,
					y         : mousePos.y
				};
				temp_array_top.push(temp_arr);
				// console.log(temp_array_top);
			}
			function clearAll(){
	            canvas.width = canvas.width
	            context.drawImage(background,0,0);
	        }
	        
	        function handleClick(e,contextIndex){
	            e.stopPropagation();
	            var mouse_arr = getMousePos(canvas, e);
            
	            // var mouseX=parseInt(e.clientX-e.target.offsetLeft);
	            // var mouseY=parseInt(e.clientY-e.target.offsetTop);
	            var mouseX = mouse_arr.x;
	            var mouseY = mouse_arr.y;
	            clearAll();
	            for(var i=0;i<states.length;i++){
	                var state=states[i];
	                if(state.dragging){
	                    state.dragging=false;
	                    state.draw();
	                    continue;
	                }
	                if ( state.contextIndex==contextIndex
	                    && mouseX>state.x && mouseX<state.x+state.width
	                    && mouseY>state.y && mouseY<state.y+state.height)
	                {
	                    state.dragging=true;
	                    state.offsetX=mouseX-state.x;
	                    state.offsetY=mouseY-state.y;
	                    state.contextIndex=contextIndex;
	                }
	                state.draw();
	            }
	            redraw_canvas();
	        }
	        canvas.onmousemove = function(e){ handleMousemove(e,1); }
        
	        function handleMousemove(e,contextIndex){
	            e.stopPropagation();
	            var mouse_arr = getMousePos(canvas, e);
            
	            // var mouseX=parseInt(e.clientX-e.target.offsetLeft);
	            // var mouseY=parseInt(e.clientY-e.target.offsetTop);
	            var mouseX = mouse_arr.x;
	            var mouseY = mouse_arr.y;
	            clearAll();
	            for(var i=0;i<states.length;i++){
	                var state=states[i];
	                if (state.dragging) {
	                    state.x = mouseX-state.offsetX;
	                    state.y = mouseY-state.offsetY;
	                    state.contextIndex=contextIndex;
	                }
	                state.draw();
	            }
	            redraw_canvas();
	        }
	        function addState(x,y,image, width = 100, height = 100, image_flag = 1){
                state = {}
                state.dragging=false;
                state.contextIndex=1;
                state.image=image;
                state.x=x;
                state.y=y;
                state.width=width;
                state.height=height;
                state.offsetX=0;
                state.offsetY=0;
                state.draw=function(){
                	temp_state_array = {};
                	context.drawImage(background,0,0);
                    if (this.dragging) {
                        context.strokeStyle = 'red';
                        context.strokeRect(this.x,this.y,this.width+2,this.height+2)
                    }
                    redraw_canvas();    
                    context.drawImage(this.image,this.x,this.y,state.width,state.height);
                    temp_state_array = {
	                    img   : this.image,
	                    x     : this.x,
	                    y     : this.y,
	                    width : state.width,
	                    height: state.height,
	                    image_flag : image_flag
	                };
                }
                state.draw();
                return(state);
	        }
	        $(document).on('click','#input_signature', function(){
			 	click_flagger = 0;
				context.drawImage(background,0,0);
				states.push(addState(50,50,img));
				page_image_count[final_page_val] = page_image_count[final_page_val] + 1;
	 
		    });
		    $(document).on('click','#input_check', function(){
			 	click_flagger = 0;
				context.drawImage(background,0,0);
				states.push(addState(50,50,check_image, 50, 50, 2));
				page_image_count[final_page_val] = page_image_count[final_page_val] + 1;
	 
		    });
			$("#annot_tile_modal").modal("hide");
			$(this_modal).modal({
                backdrop: 'static',
                keyboard: false
            });
	    });
	    $(document).on('click', '.submit_annotations', function() {
	    	
	    	var orig_file_name = $("#hidden_orig_file_name").val();
	    	var fq_acct_id = $("#fapplication_id").val();
	    	var sig_anot = [];
	    	
		    $(final_sig_anot).each(function(index_1, array_1){
		    	if(typeof(array_1) != "undefined")
		    	{
		    		sig_anot[index_1] = [];
					$(array_1).each(function(index_2, array_2){
			    		var temp_array = {
			    			x: array_2.x / parseFloat(w),
			    			y: array_2.y / parseFloat(h),
			    			image_flag: array_2.image_flag
			    		};
			    		sig_anot[index_1].push(temp_array)
				    });
				}
		    });
	    	var data = {
	    		final_array_anot: final_array_anot,
	    		sig_anot: sig_anot,
	    		orig_file_name: orig_file_name,
	    		fq_acct_id: fq_acct_id
	    	};
	    	$.ajax({
				type: "POST",
				url: "<?= site_url("fapplication/annotate_pdf"); ?>",
				data: data,
				cache: false,
				success: function(data){
					$("#annot_tile_modal").modal("hide");
				}
			});
	    });
	    $(document).on('click', '#finaliz_page', function() {
	    	if(typeof(final_sig_anot[final_page_val]) == 'undefined')
	    	{
	    		final_sig_anot[final_page_val] = [];
	    	}
	    	final_array_anot[final_page_val] = temp_array_top;
	    	page_image_count[final_page_val] = temp_state_array;
	    	final_sig_anot[final_page_val].push(page_image_count[final_page_val]);
	    	if(typeof(temp_state_array.img) != "undefined")
	    	{
		    	context.drawImage(temp_state_array.img,temp_state_array.x,temp_state_array.y,temp_state_array.width,temp_state_array.height);
		    	temp_state_array = {};
				sate   = {};
				states = [];
		    }
	    });
        $('#edit_pdf_modal_final').on('shown.bs.modal', function () {
            background = new Image();
            background.src = absolute_path;
            context.drawImage(background,0,0);
            /*if(typeof(final_array_anot[final_page_val]) != 'undefined')
            {
                $(final_array_anot[final_page_val]).each(function(index, array){
                    context.font      = array.anot_size+'pt '+array.anot_font;
                    context.fillStyle = array.anot_color;
                    context.fillText(array.anot_text, array.x, array.y);
                });
            }
            if(typeof(final_sig_anot[final_page_val]) != 'undefined')
            {
                $(final_sig_anot[final_page_val]).each(function(index, array){
                    context.drawImage(array.img,array.x,array.y,array.width,array.height);
                });
            }*/
            redraw_canvas();
        });
	    $('#edit_pdf_modal_final').on('hidden.bs.modal', function () {
	    	// context.clearRect(0, 0, canvas.width, canvas.height);
			temp_array_top   = [];
			temp_state_array = [];
			
			canvas         = null;
			context        = null;
			img            = null;
			check_image    = null;
			state          = {};
	    	$("#annot_tile_modal").modal({
                backdrop: 'static',
                keyboard: false
            });
	    });
	    $(document).on('click','#clear_canvas', function(){
			context.clearRect(0, 0, canvas.width, canvas.height);
			context.drawImage(background,0,0);
			final_sig_anot[final_page_val] = [];
			final_array_anot[final_page_val] = [];
			temp_array_top = [];
			state = {};
			click_flagger = 0;
		});
		function redraw_canvas()
		{
			if(temp_array_top.length > 0)
            {
                $(temp_array_top).each(function(index, array){
                	context.font      = array.anot_size+'pt '+array.anot_font;
					context.fillStyle = array.anot_color;
					context.fillText(array.anot_text, array.x, array.y);
                });
            }
            if(typeof(final_array_anot[final_page_val]) != 'undefined')
			{	
				$(final_array_anot[final_page_val]).each(function(index, array){
					
                	context.font      = array.anot_size+'pt '+array.anot_font;
					context.fillStyle = array.anot_color;
					context.fillText(array.anot_text, array.x, array.y);
                });
			}
			if(typeof(final_sig_anot[final_page_val]) != 'undefined')
	    	{
	    		$(final_sig_anot[final_page_val]).each(function(index, array){
	    			context.drawImage(array.img,array.x,array.y,array.width,array.height);
	    		});
	    	}
		}
////////////////////////////////////////////////
	    // sorting of requirements
	    // sorting of requirements
	    $('#fapplication-modal-3').on('show.bs.modal', function () {
	    	var fq_id = $("#fapplication_id").val();
	    	var lead_id = $("#lead_id_fq").val();
	    	
	    	var data = {
	    		fq_id: fq_id,
	    		lead_id: lead_id
	    	}
	    	
	    	$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/allocate_temp_lead"); ?>",
				data: data,
				cache: false,
				success: function(data){
				}
			});
	    });
	    $('#fapplication-modal-3').on('hidden.bs.modal', function () {
	    	var fq_id = $("#fapplication_id").val();
	    	var lead_id = $("#lead_id_fq").val();
	    	
	    	var data = {
	    		fq_id: fq_id,
	    		lead_id: lead_id
	    	}
	    	
	    	$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/deallocate_temp_lead"); ?>",
				data: data,
				cache: false,
				success: function(data){
				}
			});
	    });
	    $(document).on('click', '.lead_email_send', function() {
			
			var fq_acct_id = $("#fapplication_id").val();
			var this_modal = $("#send_blank_email_modal");
			var this_email = $(this).text();
			this_modal.find(".attachment_container").find(".email_attachment_group").not(':first').remove();
			var data = {
				fq_acct_id: fq_acct_id
			};
			this_modal.find("#send_email_content").code('');
			this_modal.find("#send_email_recipients").tagsinput('removeAll');
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/get_just_requirements"); ?>",
				data: data,
				cache: false,
				dataType: 'json',
				success: function(data){
					this_modal.find(".send_email_attachment_select").html(data.att_option);
					
					this_modal.find("#send_email_recipients").tagsinput('add', this_email);
					$(this_modal).modal({
	                    backdrop: 'static',
	                    keyboard: false
	                });
				}
			});
		});
		$(document).on('click', '.add_attachment', function() {
			var parent_panel = $(this).closest(".attachment_container");
			var panel = $(this).closest(".attachment_container").find(".email_attachment_group:first").clone();
			parent_panel.append(panel);
		});
		$(document).on('click', '.remove_attachment', function() {
			var parent_panel = $(this).closest(".attachment_container");
			var panel = $(this).closest(".email_attachment_group");
			var count = parent_panel.find(".email_attachment_group").length;
			if(count == 1)
			{
				alert("You cannot remove the last dropdown menu!");
				return false;
			}
			panel.remove();
		});
		$(document).on('click', '.email_popup', function() {
			
			var fq_acct_id = $("#fapplication_id").val();
			var this_modal = $("#send_blank_email_modal");
			var this_email = $(this).closest(".email_group").find(".form-control").val();
			this_modal.find(".attachment_container").find(".email_attachment_group").not(':first').remove();
			var data = {
				fq_acct_id: fq_acct_id
			};
			this_modal.find("#send_email_content").code('');
			this_modal.find("#send_email_recipients").tagsinput('removeAll');
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/get_just_requirements"); ?>",
				data: data,
				cache: false,
				dataType: 'json',
				success: function(data){
					this_modal.find(".send_email_attachment_select").html(data.att_option);
					// this_modal.find("#send_email_recipients").val(this_email);
					this_modal.find("#send_email_recipients").tagsinput('add', this_email);
					$(this_modal).modal({
	                    backdrop: 'static',
	                    keyboard: false
	                });
				}
			});
		});
		$(document).on('click', '.send_blank_email', function() {
			var attachment_array = [];
			$(document).find(".send_email_attachment_select").each(function(index){
				attachment_array.push($(this).val());
			});
			var this_modal = $("#send_blank_email_modal");
	    	var id = $(document).find("#fapplication_id").val();
			var email_subject = this_modal.find("#send_email_subject").val();
			var recipients    = this_modal.find("#send_email_recipients").val();
			var email_message = this_modal.find("#send_email_content").code();
			email_message = replaceAll(email_message, '&quot;', '%27');
			email_message = replaceAll(email_message, '&lt;', '%3C');
			email_message = replaceAll(email_message, '&qt;', '%3E');
			email_message = replaceAll(email_message, '&amp;', '%26');
			email_message = replaceAll(email_message, '&', '%26');
			
			var data = {
				email_message   : email_message,
				email_subject   : email_subject,
				id              : id,
				recipients      : recipients,
				attachment_array: attachment_array
			};
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/send_email_template"); ?>",
				data: data,
				cache: false,
				success: function(result){
					this_modal.modal("hide");
				}
			});
		});
	    $(document).on('click', '.email_templates_modal', function() {
			
			$("#fq_emailer").modal("show");
		});
        
        $(document).on('click', '.system_email_templates_modal', function() {
			$("#system_mail_template_model").modal("show");
		});
		$(document).on('click', '#create_email_button', function() {
			$("#create_email_modal").modal("show");
			$("#create_email_modal").find("#email_recipients").val('');
			var fq_id = $("#fapplication_id").val();
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/get_attachments"); ?>",
				data: {fq_id:fq_id},
				cache: false,
				success: function(result){
					$("#create_email_modal").find("#new_email_attachment_select").html(result);
				}
			});
			
		});
		var datatables_email_trail = null;
		$(document).on('click', '.sent_box_button', function() {
			var fq_id = $("#fapplication_id").val();
			var this_modal = $("#email_trail_modal");
			var data = {
				fq_id: fq_id
			};
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/get_email_trail"); ?>",
				data: data,
				cache: false,
				success: function(response){
					$(this_modal).find("#sent_body").html(response);
					datatables_email_trail = $('#datatables_email_trail').DataTable({
						lengthMenu: [ [10, 20, 50], [10, 20, 50] ],
						pageLength: 10
					});
					$(this_modal).modal({
	                    backdrop: 'static',
	                    keyboard: false
	                });
				}
			});
		});
		$('#email_trail_modal').on('hidden.bs.modal', function () {
			datatables_email_trail.destroy();
		});
		$(document).on('click', '.view_sent_body', function() {
	    	var id = $(this).data("id");
	    	var data = {
	    		id: id
	    	};
	    	$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/get_email_trail_body"); ?>",
				cache: false,
				data: data,
				dataType: 'json',
				success: function(data){
					$("#sent_email_body").html(data.body);
					$("#sent_email_title").html(data.subject);
					$("#view_sent_email").modal("show");
					$("#email_trail_modal").modal("hide");
				}
			});
	    });
	    $('#view_sent_email').on('hidden.bs.modal', function () {
			datatables_email_trail = $('#datatables_email_trail').DataTable({
				lengthMenu: [ [10, 20, 50], [10, 20, 50] ],
				pageLength: 10
			});
			$("#email_trail_modal").modal({
                backdrop: 'static',
                keyboard: false
            });
            $.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/get_email_trail_body"); ?>",
				cache: false,
				data: data,
				dataType: 'json',
				success: function(data){
				}
			});
		});
		var datatables_email_list = null;
		$(document).on('change', '.email_list_input', function() {
			var email = $(this).val();
			var id = $(this).data("id");
			var $this = $(this);
			var data = {
				email: email,
				id   : id
			};
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/update_email_list_item"); ?>",
				cache: false,
				data: data,
				success: function(data){
					$this.prop("readonly", true);
				}
			});
		});
		$(document).on('click', '.delete_email_list_item', function() {
			var id = $(this).data("id");
			var parent = $(this).closest(".email_list_tr");
			var data = {
				id: id
			};
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/delete_email_list_item"); ?>",
				cache: false,
				data: data,
				success: function(data){
					datatables_email_list.row(parent).remove().draw();
				}
			});
		});
		$(document).on('click', '.open_add_email_modal', function() {
			$("#add_email_list_item").modal();
		});
		$(document).on('click', '.add_email_to_list', function() {
			var email = $("#email_list_value").val();
			var data = {
				email: email
			};
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/add_email_list_item"); ?>",
				cache: false,
				data: data,
				success: function(data){
					$("#add_email_list_item").modal("hide");
					$('#email_list_modal').modal("hide");
				}
			});
		});
		$(document).on('click', '.edit_email_list_item', function() {
			var parent = $(this).closest(".email_list_tr");
			var input = parent.find(".email_list_input");
			if(input.prop("readonly") == true)
				input.prop("readonly", false);
			else
				input.prop("readonly", true);
		});
		$(document).on('click', '.email_list_btn', function() {
			var fq_id      = $("#fapplication_id").val();
			var this_modal = $("#email_list_modal");
			var data = {
				fq_id: fq_id
			};
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/get_email_list"); ?>",
				cache: false,
				success: function(response){
					$(this_modal).find("#email_list_body").html(response);
					datatables_email_list = $('#datatables_email_list').DataTable({
						lengthMenu: [ [10, 20, 50], [10, 20, 50] ],
						pageLength: 10
					});
					$(this_modal).find(".email").prop("readonly", true);
					$(this_modal).modal({
	                    backdrop: 'static',
	                    keyboard: false
	                });
				}
			});
		});
		$('#email_list_modal').on('hidden.bs.modal', function () {
			datatables_email_list.destroy();
		});
		
        $(document).on('click', '.open-emailtemplate-details', function() {
			
			var id = $(this).data("email_template_id");
			var fq_acct_id = $("#fapplication_id").val();
			
			//$(".attachment_container").find(".email_attachment_group").not(':first').remove();
			var this_modal = $("#open_email_modal");
			var data = {
				id: id,
				fq_acct_id: fq_acct_id
			};
			this_modal.find("#email_content").code('');
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/get_email_template"); ?>",
				data: data,
				cache: false,
				dataType: 'json',
				success: function(data){
					
					this_modal.find("#email_content").code(data.content);
					this_modal.find("#email_subject").val(data.subject);
					this_modal.find("#email_template_id").val(id);
					this_modal.find(".attachment_container").empty().append(data.attachment);
					
					if( data.recipients && data.recipients !='' && data.recipients != null){
						var recipient_arr = data.recipients.split(',');
					
						$.each(recipient_arr, function(index, value) {
							$(".edit_template_recipient li a:contains("+value+")").click();
						});
					}
					$(this_modal).modal({
	                    backdrop: 'static',
	                    keyboard: false
	                });
				}
			});
		});
        
        $(document).on('click', '.open-edit-emailtemplate', function(data) {
            var email_template_id = $(this).data("email_template_id");
            var fq_acct_id = $("#fapplication_id").val();
            let this_modal = $("#email_template_model");
            var data = {
                id: email_template_id,
                fq_acct_id: fq_acct_id
            };
            CKEDITOR.instances.edit_template_content.setData(''); 
            $.ajax({
                type: "POST",
                url: "<?php echo site_url("fapplication/get_system_email_template"); ?>",
                data: data,
                cache: false,
                dataType: 'json',
                success: function(data){
                    //console.log(data);
                    this_modal.find("#email_template_id").val(email_template_id);
                    CKEDITOR.instances.edit_template_content.setData(data.content); 
                    this_modal.find("#mail_template_subject").text('Edit '+data.subject +' Template');
                    $(this_modal).modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                }
            });
        });

        $(document).on('click','.preview_system_email_template', function() {
        	// $("#email_template_model").modal('hide');
        	let this_modal = $("#preview_email_template_model");
        	$(this_modal).modal({
                backdrop: 'static',
                keyboard: false
            });
        });
        
		$(document).on('click', '.forward_email', function() {
			var attachment_array = [];
			var this_modal = $("#forward_email_modal");
			$(document).find(this_modal).find(".email_attachment_select").each(function(index){
				attachment_array.push($(this).val());
			});
	    	var fq_id = $(document).find("#fapplication_id").val();
			var email_subject = this_modal.find("#email_subject").val();
			var recipients    = this_modal.find("#email_recipients").val();
			var email_id      = this_modal.find("#sent_email_id").val();
			
			var data = {
				email_subject   : email_subject,
				email_id        : email_id,
				recipients      : recipients,
				attachment_array: attachment_array,
				fq_id           : fq_id
			};
			
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/forward_email"); ?>",
				data: data,
				cache: false,
				success: function(result){
					this_modal.modal("hide");
				}
			});
		});
        
		$(document).on('click', '.open_forward_email', function() {
			var id = $(this).data("id");
			var fq_acct_id = $("#fapplication_id").val();
			var this_modal = $("#forward_email_modal");
			var data = {
				id: id,
				fq_acct_id: fq_acct_id
			};
			this_modal.find("#email_content").code('');
			var initial_panel = this_modal.find(".attachment_container").find(".email_attachment_group:first").clone();
			this_modal.find(".attachment_container").find(".email_attachment_group").remove();
			this_modal.find(".attachment_container").append(initial_panel);						
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/get_sent_email"); ?>",
				data: data,
				cache: false,
				dataType: 'json',
				success: function(data){
					this_modal.find("#sent_email_id").val(id);
					this_modal.find("#html_message").html(data.message);
					this_modal.find("#email_subject").val(data.subject);
					this_modal.find(".email_attachment_select").html(data.att_option);
					
					$(data.recipients).each(function(index, value){
						this_modal.find(".multi_email_recipients").tagsinput('add', value);
					});
					var parent_panel = this_modal.find(".attachment_container");
					
					//this_modal.find(".attachment_container").find(".email_attachment_group:first").find(".email_attachment_select").val(data.attachment[0]);

					$(data.attachment).each(function(index, value){
						// if(index > 0)
						// {
							var panel = this_modal.find(".attachment_container").find(".email_attachment_group:first").clone();
							panel.find(".email_attachment_select").val(value);
							parent_panel.append(panel);
							console.log(parent_panel.append(panel));
						//}
					});
					$(this_modal).modal({
	                    backdrop: 'static',
	                    keyboard: false
	                });
				}
			});
		});
        
		$(document).on('click', '.create_email_template_btn', function() {
			var email_description = $("#create_email_modal").find("#new_email_description").val();
			var email_subject     = $("#create_email_modal").find("#new_email_subject").val();
			var visibility        = $("#create_email_modal").find("#new_email_visibility").val();
			var email_content     = $("#create_email_modal").find("#new_email_content").code();
			var new_email_recipient =  $("#create_email_modal").find("#email_recipients").val();
			var attachment = $("#create_email_modal").find( ".new_email_attachment_select" ).map(function() {
				return $( this ).val();}).get().join( "***" );
				
			email_content = replaceAll(email_content, '&quot;', '%27');
			email_contenontent = replaceAll(email_content, '&qt;', '%3E');
			email_content = replaceAll(email_content, '&amp;', '%26');
			emailt = replaceAll(email_content, '&lt;', '%3C');
			email_c_content = replaceAll(email_content, '&', '%26');
			var data = {
				email_description: email_description,
				email_content: email_content,
				email_subject: email_subject,
				visibility: visibility,
				new_email_recipient:new_email_recipient,
				attachment:attachment
			}
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/add_email_template"); ?>",
				data: data,
				cache: false,
				success: function(result){
					$("#create_email_modal").hide();
				}
			});
		});
		
		$(document).on('click', '.send_email_template', function() {
			
			var attachment_array = [];
			$(document).find(".edit_email_attachment_select").each(function(index){
				attachment_array.push($(this).val());
			});
			var this_modal = $("#open_email_modal");
	    	var id = $(document).find("#fapplication_id").val();
			var email_subject = this_modal.find("#email_subject").val();
			var recipients    = this_modal.find("#email_recipients").val();
			var email_message = this_modal.find("#email_content").code();
			email_message = replaceAll(email_message, '&quot;', '%27');
			email_message = replaceAll(email_message, '&lt;', '%3C');
			email_message = replaceAll(email_message, '&qt;', '%3E');
			email_message = replaceAll(email_message, '&amp;', '%26');
			email_message = replaceAll(email_message, '&', '%26');
			
			var data = {
				email_message   : email_message,
				email_subject   : email_subject,
				id              : id,
				recipients      : recipients,
				attachment_array: attachment_array
			};
			// console.log(recipients);
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/send_email_template"); ?>",
				data: data,
				cache: false,
				success: function(result){
					this_modal.modal("hide");
				}
			});
		});
        
        $(document).on('click', '.save_system_email_template', function() {
			var this_modal = $("#email_template_model");
	    	var id = $(document).find("#fapplication_id").val();
			var email_template_id = this_modal.find("#email_template_id").val();
			var email_content = CKEDITOR.instances.edit_template_content.getData();
			
			var data = {
				id: id,
                email_content : email_content,
				email_template_id: email_template_id
			};
            // console.log(data);return false;
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/save_system_email_template"); ?>",
				data: data,
				cache: false,
				success: function(result){
					this_modal.modal("hide");
				}
			});
		});
        
		$(document).on('click', '.save_email_template', function() {
			var this_modal = $("#open_email_modal");
	    	var id = $(document).find("#fapplication_id").val();
			var email_template_id = this_modal.find("#email_template_id").val();
			var email_subject     = this_modal.find("#email_subject").val();
			var recipients        = this_modal.find("#email_recipients").val();
			var email_message     = this_modal.find("#email_content").code();
			var attachment = this_modal.find( ".edit_email_attachment_select" ).map(function() {
				return $( this ).val();}).get().join( "***" );
			email_message = replaceAll(email_message, '&quot;', '%27');
			email_message = replaceAll(email_message, '&lt;', '%3C');
			email_message = replaceAll(email_message, '&qt;', '%3E');
			email_message = replaceAll(email_message, '&amp;', '%26');
			email_message = replaceAll(email_message, '&', '%26');
			
			var data = {
				email_message    : email_message,
				email_subject    : email_subject,
				id               : id,
				recipients       : recipients,
				email_template_id: email_template_id,
				attachment : attachment,
			};
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/save_email_template"); ?>",
				data: data,
				cache: false,
				success: function(result){
					this_modal.modal("hide");
				}
			});
		});
        
		$(document).on('click', '.delete_email_template', function() {
			var id_email_template = $(this).data("email_template_id");
			var this_row = $("#email_template_main_row_"+id_email_template);
			var data = {
				id_email_template: id_email_template
			};
			if( confirm("Are you sure you want to delete this template?") )
			{
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("fapplication/delete_email_template"); ?>",
					data: data,
					cache: false,
					success: function(result){
						$(this_row).remove();
					}
				});
			}
		});
		var datatables = null;
		(function( $ ) {
			'use strict';
			var datatableInit = function() {
				datatables = $('#datatables_email');
				datatables.DataTable({
					lengthMenu: [ [20, 50, 100], [20, 50, 100] ],
					pageLength: 20
				});
			};
			$(function() {
				datatableInit();
			});
		}).apply( this, [ jQuery ]);
		
		$(document).on('click','.unallocate_fk_lead', function(){
			var lead_id = $("#lead_id_fq").val();
			if(lead_id == "")
			{
				alert("This FQ Lead doesn't have a QM Lead attached to it");
				return false;
			}
			var data = {
				lead_id: lead_id
			};
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/unallocate_lead"); ?>",
				data: data,
				cache: false,
				success: function(result){
					if(result == "fail")
						alert("The Lead is not assigned to you!");
					else
						alert("Successfully unallocated!");
				}
			});
		});

		
	$(document).on('click', '.historical_quotes_btn', function() {
		$("#historical_quotes_modal").modal("show");
			//$( "#all_quotes_filter" ).click();

		});
		
		$(document).on("change", "#search_make", function(){
			var id = $("#search_make option:selected").attr("data-id");
			var data = {
				code: 2,
				id_make: id
			}
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/get_dropdown_data"); ?>",
				cache: false,
				data: data,
				dataType: 'json',
				success: function(result){
					var option = '<option value="">-Model-</option>';
					for (var i in result) 
					{
						option = option+'<option data-id="'+result[i].id_family+'" value="'+result[i].name+'">'+result[i].name+'</option>';
					}
					$("#search_model").html(option);

					var red_book_option = '<option value="">Select Specific Car</option>'; 
					$("#search_rb_data").html(red_book_option);
				}
			});

			get_dealer();
		});

		$(document).on("change", "#search_model", function(){
			
			var make = $("#search_make option:selected").attr("data-id");
			var model = $("#search_model option:selected").attr("data-id");
			var data = {
				make: make,
				model:model,
			}
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/getRBdata"); ?>",
				cache: false,
				data: data,
				success: function(result){
				
					$("#search_rb_data").html(result);
				}
			});

		});

		$(document).on("change", "#search_state", function(){
			get_dealer();
		});

		function get_dealer(){
			var make = $("#search_make option:selected").val();
			var state = $("#search_state option:selected").val();
			var data = {
				make: make,
				state:state,
			}
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("fapplication/getDealer"); ?>",
				cache: false,
				data: data,
				success: function(result){
					$("#search_dealer").html(result);
				}
			});

		}

		$(document).on("click", "#all_quotes_filter", function(){
			var make = $("#search_make option:selected").attr("data-id");
			var model = $("#search_model option:selected").attr("data-id");
			var id_rbdata = $("#search_rb_data option:selected").val();
			var state_id = $("#search_state option:selected").val();
			var dealer_id = $("#search_dealer option:selected").val();
			var filter_from_dt = $("#filter_from_dt").val();
			var filter_to_dt = $("#filter_to_dt").val();
			var data = {
				id_make: make,
				id_model:model,
				id_rbdata:id_rbdata,
				state_id:state_id,
				dealer_id:dealer_id,
				filter_from_dt:filter_from_dt,
				filter_to_dt:filter_to_dt,
			}
		 $('#historical_quotes_table').DataTable({
					"destroy":true,
					"processing": true,
					"serverSide": true,
					"ordering": false,
					"searching": false,
					"lengthMenu": [[20, 25, 50, 100, -1], [20, 25, 50, 100, "All"]],
					pageLength: 20,
					"language": {
              processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
          		},
					"ajax":{
					"url": "<?php echo site_url("fapplication/all_historical_quotes"); ?>",
					"dataType": "json",
					"type": "POST",
					"data":data,
					},
			

				});

		});

	
		$(document).on("click", "#all_quotes_clear", function(){
			var make_option = '<option value="">-Make-</option>';
			var model_option = '<option value="">-Model-</option>';
			var red_book_option = '<option value="">Select Specific Car</option>';
			var state_option = '<option value="">-State-</option>';
			var dealer_option = '<option value="">-Dealer-</option>';
			$("#search_make").html(make_option);
			$("#search_model").html(model_option); 
			$("#search_rb_data").html(red_book_option);
			$("#search_state").html(state_option);
			$("#search_dealer").html(dealer_option);
			$("#filter_from_dt").val('');
			$("#filter_to_dt").val('');
			$( "#all_quotes_filter" ).click();
		});

		$(document).on('click', '.close_all_historical_quotes', function() {
			//all_historical_quotes_datatable .destroy();
			$("#historical_quotes_modal").modal("hide");
		});
	});		
		
	var placeSearch, autocomplete = [], className, place = [];
	var x;
	function initAutocomplete(x = 0) {
		
		className = document.getElementsByClassName('google_address');
		if(className.length > 0)
		{	
			autocomplete[x] = new google.maps.places.Autocomplete((className[x]), {types: ['address']});
			google.maps.event.addListener(autocomplete[x], 'place_changed', function(e) {
		        
				place[x] = autocomplete[x].getPlace();
				
		        var postal_code;
		        var suburb;
		        var final_street_add = "";
				for (var i = 0; i < place[x].address_components.length; i++) {
					var addressType = place[x].address_components[i].types[0];
					
					if (addressType == 'postal_code') {
						var val = place[x].address_components[i]['short_name'];
						postal_code = val;
					}
					if (addressType == 'locality') {
						var val = place[x].address_components[i]['long_name'];
						suburb = val;
					}
					if(addressType == 'street_number')
					{
						var val = place[x].address_components[i]['long_name'];
						final_street_add = final_street_add + val + " ";
					}
					if(addressType == 'route')
					{
						var val = place[x].address_components[i]['long_name'];
						final_street_add = final_street_add + val;
					}
				}
		        var curr_class = $(className[x]);
		        
		    	if(curr_class.closest('.business_details').length > 0 && curr_class.hasClass('accountant_address') == false)
		    	{
		    		curr_class.closest('.business_details').find('.bus_google_postcode').val(postal_code);
		    		curr_class.closest('.business_details').find('.bus_google_suburb').val(suburb);
				}
				else if(curr_class.hasClass('accountant_address') == true)
				{
					curr_class.closest('.business_details').find('.acct_google_postcode').val(postal_code);
		    		curr_class.closest('.business_details').find('.acct_google_suburb').val(suburb);
				}
				else if(curr_class.hasClass('initial_address') == true)
				{
					curr_class.closest('.initial_address_panel').find('.google_postcode').val(postal_code);
		    		curr_class.closest('.initial_address_panel').find('.google_suburb').val(suburb);
				}
				else
				{
					curr_class.closest('.panel-body').find('.google_postcode').val(postal_code);
					curr_class.closest('.panel-body').find('.google_suburb').val(suburb);
				}
				//curr_class.val(final_street_add);
				remove_no_val();
		    });
		}
		
	}
	$(document).on('focus', '.google_address', function(){
		initAutocomplete($('.google_address').index($(this)));
	});
	
	<?php $this->load->view('admin/js/my_custom'); ?>
</script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDyR6Qi_hb0GkY9Wk0D4LBI0pqg5ln6X_k&libraries=places&callback=initAutocomplete" async defer></script>

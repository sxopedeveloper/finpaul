<?php include 'template/head.php'; ?>
<style>
.btn-white
{
	background-color:#fff;
	color:#58c603;
}
</style>
	<body>
		<section class="body">
			<?php include 'template/header.php'; ?>
			<div class="inner-wrapper">
				<?php include 'template/left_sidebar.php'; ?>
				<section role="main" class="content-body">
					<?php include 'template/header_2.php'; ?>
					<!-- start: page -->						
					<section class="panel">
						<?php /*?><header class="panel-heading">
							<div class="panel-actions">
								<a href="javascript:void(0)" class="fa fa-caret-down"></a>
							</div>
							<h2 class="panel-title">
								<span class="label label-primary label-sm text-normal va-middle mr-sm"><?php echo $result_count; ?></span>
								<span class="va-middle">Search Filters</span>
							</h2>
						</header><?php */?>
						<form action="<?php echo site_url('account/dealers'); ?>" id="main_list_filter_form" class="form-horizontal form-borsdered" method="get" accept-charset="utf-8">
							<div class="panel-body">
								<h5><b>Search Filters</b></h5>
								<?php
								$status           = isset($_GET['status']) ? $_GET['status'] : '';
								$pma_status       = isset($_GET['pma_status']) ? $_GET['pma_status'] : '';
								$gold_status      = isset($_GET['gold_status']) ? $_GET['gold_status'] : '';
								$email            = isset($_GET['email']) ? $_GET['email'] : '';
								$name             = isset($_GET['name']) ? $_GET['name'] : '';
								$abn              = isset($_GET['abn']) ? $_GET['abn'] : '';
								$state            = isset($_GET['state']) ? $_GET['state'] : '';
								$catered_state            = isset($_GET['catered_state']) ? $_GET['catered_state'] : '';
								$postcode         = isset($_GET['postcode']) ? $_GET['postcode'] : '';
								$address          = isset($_GET['address']) ? $_GET['address'] : '';
								$phone            = isset($_GET['phone']) ? $_GET['phone'] : '';
								$mobile           = isset($_GET['mobile']) ? $_GET['mobile'] : '';
								$dealership_name  = isset($_GET['dealership_name']) ? $_GET['dealership_name'] : '';
								$dealership_brand = isset($_GET['dealership_brand']) ? $_GET['dealership_brand'] : '';

								$selected_status_0 = ""; if ($status == "0") { $selected_status_0 = " selected"; }
								$selected_status_1 = ""; if ($status == "1") { $selected_status_1 = " selected"; }								
								
								$selected_gold_status_0 = ""; if ($gold_status == "0") { $selected_gold_status_0 = " selected"; }
								$selected_gold_status_1 = ""; if ($gold_status == "1") { $selected_gold_status_1 = " selected"; }								

								$selected_pma_status_0 = ""; if ($pma_status == "0") { $selected_pma_status_0 = " selected"; }
								$selected_pma_status_1 = ""; if ($pma_status == "1") { $selected_pma_status_1 = " selected"; }																
								?>
								<div class="form-group">
									<div class="col-md-2">
										<input value="<?php echo $dealership_name; ?>" class="form-control mb-md" name="dealership_name" type="text" placeholder="Dealership Name">
									</div>
									<div class="col-md-2">
										<input value="<?php echo $abn; ?>" class="form-control mb-md" name="abn" type="text" placeholder="ABN">
									</div>									
									<div class="col-md-2">
										<input value="<?php echo $dealership_brand; ?>" class="form-control mb-md" name="dealership_brand" type="text" placeholder="Dealership Brands">
									</div>
									<div class="col-md-2">
										<input value="<?php echo $name; ?>" class="form-control mb-md" name="name" type="text" placeholder="Manager Name">
									</div>									
									<div class="col-md-2">
										<select class="form-control mb-md" name="status" title="User Status">
											<option name="status" value="">-User Status-</option>
											<option name="status" value="1" <?php echo $selected_status_1; ?>>Activated</option>
											<option name="status" value="0" <?php echo $selected_status_0; ?>>Deactivated</option>
										</select>
									</div>
									<div class="col-md-2">
										<select class="form-control mb-md" name="gold_status" title="Dealer Type">
											<option name="gold_status" value="">-Dealer Type-</option>
											<option name="gold_status" value="1" <?php echo $selected_gold_status_1; ?>>Gold</option>
											<option name="gold_status" value="0" <?php echo $selected_gold_status_0; ?>>Ordinary</option>
										</select>
									</div>									
									<div class="col-md-2">
										<select class="form-control mb-md" name="pma_status" title="PMA Status">
											<option name="pma_status" value="">-PMA Status-</option>
											<option name="pma_status" value="1" <?php echo $selected_pma_status_1; ?>>Active</option>
											<option name="pma_status" value="0" <?php echo $selected_pma_status_0; ?>>Inactive</option>
										</select>
									</div>
									<div class="col-md-2">
										<input value="<?php echo $email; ?>" class="form-control mb-md" name="email" type="text" placeholder="Email Address">
									</div>
									<div class="col-md-2">
										<input value="<?php echo $phone; ?>" class="form-control mb-md" name="phone" type="text" placeholder="Phone">
									</div>
									<div class="col-md-2">
										<input value="<?php echo $mobile; ?>" class="form-control mb-md" name="mobile" type="text" placeholder="Mobile">
									</div>
									<div class="col-md-2">
										<?php /*?><input value="<?php echo $state; ?>" class="form-control mb-md" name="state" type="text" placeholder="State">		<?php */?>		
										<select class="form-control mb-md" name="catered_state" placeholder="Catered State">
											<option name="state"  value="">Catered States</option>
											<option name="state" <?php echo ($catered_state=="ACT")?"SELECTED":""; ?> value="ACT">ACT - Australian Capital Territory</option>
											<option name="state" <?php echo ($catered_state=="NSW")?"SELECTED":""; ?> value="NSW">NSW - New South Wales</option>
											<option name="state" <?php echo ($catered_state=="NT")?"SELECTED":""; ?> value="NT">NT - Northern Territory</option>
											<option name="state" <?php echo ($catered_state=="QLD")?"SELECTED":""; ?> value="QLD">QLD - Queensland</option>
											<option name="state" <?php echo ($catered_state=="SA")?"SELECTED":""; ?> value="SA">SA - South Australia</option>
											<option name="state" <?php echo ($catered_state=="TAS")?"SELECTED":""; ?> value="TAS">TAS - Tasmania</option>
											<option name="state" <?php echo ($catered_state=="VIC")?"SELECTED":""; ?> value="VIC">VIC - Victoria</option>
											<option name="state" <?php echo ($catered_state=="WA")?"SELECTED":""; ?> value="WA">WA - Western Australia</option>
										</select>
									</div>
									<div class="col-md-2">
										<input value="<?php echo $postcode; ?>" class="form-control mb-md" name="postcode" type="text" placeholder="Postcode">
									</div>
									<div class="col-md-2">
										<input value="<?php echo $address; ?>" class="form-control mb-md" name="address" type="text" placeholder="Address">
									</div>
									<div class="col-md-2">
										<?php /*?><input value="<?php echo $state; ?>" class="form-control mb-md" name="state" type="text" placeholder="State">		<?php */?>		
										<select class="form-control mb-md" name="state" placeholder="State">
											<option name="state"  value="">Address States</option>
											<option name="state" <?php echo ($state=="ACT")?"SELECTED":""; ?> value="ACT">ACT - Australian Capital Territory</option>
											<option name="state" <?php echo ($state=="NSW")?"SELECTED":""; ?> value="NSW">NSW - New South Wales</option>
											<option name="state" <?php echo ($state=="NT")?"SELECTED":""; ?> value="NT">NT - Northern Territory</option>
											<option name="state" <?php echo ($state=="QLD")?"SELECTED":""; ?> value="QLD">QLD - Queensland</option>
											<option name="state" <?php echo ($state=="SA")?"SELECTED":""; ?> value="SA">SA - South Australia</option>
											<option name="state" <?php echo ($state=="TAS")?"SELECTED":""; ?> value="TAS">TAS - Tasmania</option>
											<option name="state" <?php echo ($state=="VIC")?"SELECTED":""; ?> value="VIC">VIC - Victoria</option>
											<option name="state" <?php echo ($state=="WA")?"SELECTED":""; ?> value="WA">WA - Western Australia</option>
										</select>
									</div>
									<div class="col-md-2 pull-right">
										<a href="<?php echo site_url('account/dealers'); ?>" class="btn btn-white search-filter-btn  col-md-12 col-sm-12 col-xs-12" value="Search" name="submit">Clear Filters</a>
									</div>
									<div class="col-md-2 pull-right">
										<button class="btn btn-primary search-filter-btn  col-md-12 col-sm-12 col-xs-12" value="Search" name="submit">Apply Filters</button>
									</div>
								</div>
								
							</div>
							
						</form>
					</section>
					<section class="panel" id="tableData">
						<div class="panel-body">			
							<div class="table-responsive">
								<?php
								if (count($dealers)==0)
								{
									echo "<br /><center><i>No results found!</i></center><br />";
								}
								else
								{
								?>
									<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
										<thead>
											<tr>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th>Status</th>
												<th>Orders</th>
												<th>Invites</th>
												<th>Quotes</th>
												<th>Dealership</th>
												<th>Manager</th>												
												<th>Address</th>
												<th>Notes</th>
											</tr>
										</thead>
										<tbody>
											<?php
											//echo "<pre>";print_r($dealers);die();
											foreach($dealers as $dealer)
											{
                                                /*$dealer_name = $dealer->name;
                                                $dealer_mobile = $dealer->mobile;
                                                $dealer_phone = $dealer->phone;*/
                                                if($dealer->primary_contact == 1) {
                                                    $dealer_name = $dealer->name;
                                                    $dealer_mobile = $dealer->mobile;
                                                    $dealer_phone = $dealer->phone;
                                                } else {
                                                    $primary_contact_arr = json_decode(str_replace('\\', '',$dealer->primary_contact), true);
                                                    
                                                    $dealer_name = array_column($primary_contact_arr, 'contact_is_primary', 'contact_fullname');
                                                    $dealer_name = array_search('1', $dealer_name);
                                                    
                                                    $dealer_mobile = array_column($primary_contact_arr, 'contact_is_primary','contact_mobile');
                                                    $dealer_mobile = array_search('1', $dealer_mobile);
                                                    
                                                    $dealer_phone = array_column($primary_contact_arr, 'contact_is_primary', 'contact_landline');
                                                    $dealer_phone = array_search('1', $dealer_phone);
                                                }
												?>
												<tr id="dealer_row_<?php echo $dealer->id_user; ?>">
													<td class="text-center">
														<?php
														$deactivate_button_hidden = "";
														$activate_button_hidden = "";
														if ($dealer->status == 0) { $deactivate_button_hidden = " hidden"; }
														else { $activate_button_hidden = " hidden";	}
														?>													
														<a href="javascript:void(0)" id="activate_button_<?php echo $dealer->id_user; ?>" onClick="activate_dealer(<?php echo $dealer->id_user; ?>)" data-toggle="tooltip" data-placement="top" title="Activate Dealer" <?php echo $activate_button_hidden; ?>>
															<i class="fa fa-check"></i>
														</a>
														<a href="javascript:void(0)" id="deactivate_button_<?php echo $dealer->id_user; ?>" onClick="deactivate_dealer(<?php echo $dealer->id_user; ?>)" data-toggle="tooltip" data-placement="top" title="Deactivate Dealer" <?php echo $deactivate_button_hidden; ?>>
															<i class="fa fa-times"></i>
														</a>
													</td>
													<td class="text-center">
														<?php
														$gold_btn_hidden = "";
														$ungold_btn_hidden = "";
														if ($dealer->gold_status == 0) { $ungold_btn_hidden = " hidden"; }
														else { $gold_btn_hidden = " hidden";	}
														?>
														<a href="javascript:void(0)" id="activate_gold_<?php echo $dealer->id_user; ?>" onClick="gold_control(<?php echo $dealer->id_user; ?>, 1)" data-toggle="tooltip" data-placement="top" title="Mark as Gold" <?php echo $gold_btn_hidden; ?>>
															<i class="fa fa-star" ></i>
														</a>
														<a href="javascript:void(0)" id="deactivate_gold_<?php echo $dealer->id_user; ?>" onClick="gold_control(<?php echo $dealer->id_user; ?>, 0)" data-toggle="tooltip" data-placement="top" title="Unmark as Gold" <?php echo $ungold_btn_hidden; ?>>
															<i class="fa fa-star" style="color: #FFD700;" ></i>
														</a>
													</td>
													<td class="text-center">
														<?php
														$show_deposit_btn_hidden = "";
														$hide_deposit_btn_hidden = "";
														if ($dealer->deposit_show_status == 0) { $hide_deposit_btn_hidden = " hidden"; }
														else { $show_deposit_btn_hidden = " hidden";	}
														?>
														<a href="javascript:void(0)" id="show_deposit_<?php echo $dealer->id_user; ?>" onClick="deposit_visibility_control(<?php echo $dealer->id_user; ?>, 1)" data-toggle="tooltip" data-placement="top" title="Show Deposit" <?php echo $show_deposit_btn_hidden; ?>>
															<i class="fa fa-dollar" ></i>
														</a>
														<a href="javascript:void(0)" id="hide_deposit_<?php echo $dealer->id_user; ?>" onClick="deposit_visibility_control(<?php echo $dealer->id_user; ?>, 0)" data-toggle="tooltip" data-placement="top" title="Hide Deposit" <?php echo $hide_deposit_btn_hidden; ?>>
															<i class="fa fa-dollar" style="color: #FFD700;" ></i>
														</a>
													</td>
													<td class="text-center">
														<a href="javascript:void(0)" class="open-editdealer" data-dealer_id="<?php echo $dealer->id_user; ?>">
															<i class="fa fa-pencil-square-o" data-toggle="tooltip" data-placement="top" title="Edit Dealer"></i>
														</a>
													</td>
													<td class="text-center">
														<a href="javascript:void(0)" onClick="delete_dealer(<?php echo $dealer->id_user; ?>)">
															<i class="fa fa-trash-o" data-toggle="tooltip" data-placement="top" title="Delete Dealer Permanently"></i>
														</a>
													</td>
													<td>
														<span id="dealer_status_<?php echo $dealer->id_user; ?>"><?php echo $dealer->status_text; ?></span>
														<br />
														<b>PMA Protection:</b>
														<br />
														<span id="dealer_pma_<?php echo $dealer->id_user; ?>"><?php echo $dealer->pma_status_text; ?></span> (<span id="dealer_gold_<?php echo $dealer->id_user; ?>"><?php echo $dealer->gold_status_text; ?></span>)														
													</td>
													<td><?php echo $dealer->orders_count; ?></td>													
													<td><?php echo $dealer->invites_count; ?></td>
													<td><?php echo $dealer->quotes_count; ?></td>
													<td>
														<b>
															<span id="dealer_dealership_name_<?php echo $dealer->id_user; ?>">
																<a href="<?php echo site_url('user/record/'.$dealer->id_user); ?>" target="_blank"><?php echo $dealer->dealership_name; ?></a>
															</span>
														</b>
														(ABN: <span id="dealer_abn_<?php echo $dealer->id_user; ?>"><?php echo $dealer->abn; ?></span>)
														<br />
														<a href="mailto:<?php echo $dealer->username; ?>" target="_top">
															<?php echo $dealer->username; ?>
														</a><br />
														<i class="fa fa-car"></i> <span id="dealer_dealership_brand_<?php echo $dealer->id_user; ?>"><?php echo $dealer->dealership_brand; ?></span>
													</td>
													<td>
														<i class="fa fa-user"></i> <span id="dealer_name_<?php echo $dealer->id_user; ?>"><?php echo $dealer_name;?></span><br />
														<i class="fa fa-mobile"></i> &nbsp;<span id="dealer_mobile_<?php echo $dealer->id_user; ?>"><?php echo $dealer_mobile;?></span><br />
														<i class="fa fa-phone"></i> <span id="dealer_phone_<?php echo $dealer->id_user; ?>"><?php echo $dealer_phone; ?></span>
													</td>													
													<td>
														<i class="fa fa-map-marker"></i> <span id="dealer_address_<?php echo $dealer->id_user; ?>"><?php echo $dealer->address; ?></span><br />
														<i class="fa fa-map-marker"></i> <span id="dealer_postcode_<?php echo $dealer->id_user; ?>"><?php echo $dealer->postcode; ?></span><br />
														<i class="fa fa-map-marker"></i> <span id="dealer_state_<?php echo $dealer->id_user; ?>"><?php echo $dealer->state; ?></span>
													</td>
													<td><?php echo $dealer->dealer_note; ?></td>
												</tr>											
												<?php
											}
											?>
										</tbody>
									</table>
									<br />													
								<?php
								}
								?>
							</div>
							<?php echo $links; ?>						
						</div>
					</section>
					<!-- end: page -->					
					<?php include 'modals/ticket_modals.php'; ?>	
					<div id="dealer_modal" class="modal fade">
						<div class="modal-dialog" style="width: 95%;">
							<div class="panel-body dealer-modal-main">
								<div class="modal-wrapper">
									<div class="modal-text">
										<form method="post" action="" id="dealer_main_form" name="dealer_main_form">
											<input type="hidden" id="dealer_id" name="dealer_id" value="" />
											<div id="dealer_details">
													<!-- Dealers. php , id="dealer_details" line number 250 -->
											</div>
										</form>
									</div>
								</div>
							</div>
							<footer class="panel-footer">
								<div class="row">
									<div class="col-md-12 text-right">
										<div id="dealer_actions"></div>
									</div>
								</div>
							</footer>
						</div>
					</div>					
				</section>
			</div>
			<?php include 'template/right_sidebar.php'; ?>
		</section>
		<?php include 'template/scripts.php'; ?>
		<script>
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
        $(document).ready(function(){
            
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
            $(document).on("click",".delete_contact",function(){
                var div_ids = $(this).data("id");
                $("#"+div_ids).remove();
            });	
            $(document).on("click", ".datepicker_dealer", function () {
                $(this).toggleClass("clicked").datepicker("setDate", new Date()).datepicker("show");
                $(this).datepicker("update");
            });
            
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
        });

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

        $(document).on("click", ".open-editdealer", function(data){
            var dealer_id = $(this).data("dealer_id");
            $.post("<?php echo site_url("account/dealer"); ?>/" + dealer_id, function(data){
                $(".full_loader").hide();
                $("#dealer_id").val(data.id_dealer);
                //alert('view/admin/dealers.php & line number : 413');
                $("#dealer_details").html(data.dealer_details);
                $("#dealer_actions").html(data.dealer_actions);

                $("#dealership_brand").select2();
                $("#dealership_states").select2();

                $("#dealer_modal").modal();
            }, "json");
        });

        $("#dealer_modal").on("hidden.bs.modal", function(){
            $("#dealership_brand").select2("destroy");
            $("#dealership_states").select2("destroy");
        });

        function save_dealer_info ()
        {
            //console.log("dealers");
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
                }
            });
        }

		</script>
	</body>
</html>
<?php include 'template/head.php'; ?>
	<body>
		<section class="body">
			<?php include 'template/header.php'; ?>
			<div class="inner-wrapper">
				<?php include 'template/left_sidebar.php'; ?>
				<section role="main" class="content-body">
					<?php include 'template/header_2.php'; ?>
					<!-- start: page -->
                    <div class="panel-body dealer-modal-main">
                        <div class="modal-wrapper">
                            <div class="modal-text">
                                <form id="form_account_creation" action="" method="post" accept-charset="utf-8">
                                    <div id="">
                                        <div class="dealer-detail-inner-content">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-md-12" style="margin-bottom: 13px;">                                
                                                        <div class="form-group">
                                                            <div class="dealer-detail-form-group">
                                                                <span>* User Type:</span>
                                                                <select class="form-control input-md" name="user_type" type="text" onchange="check_user_type(this.options[this.selectedIndex].value)" required>
                                                                    <option name="user_type" value="">-User Type-</option>
                                                                    <!--<option name="user_type" value="3">Wholesaler</option>-->
                                                                    <option name="user_type" value="2">Staff</option>
                                                                    <option name="user_type" value="4">Referrer</option>
                                                                    <option value="5">FQ user account</option>
                                                                </select>
                                                            </div>														
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div style="margin-bottom: 13px;" id="dealership_details" hidden>
                                                            <h5 class="dealer-heading">Dealership Details</h5>
                                                            <div class="form-group">
                                                                <div class="dealer-detail-form-group">
                                                                    <span>Dealership Name</span>
                                                                    <input type="text" id="dealership_name" name="dealership_name" class="form-control pull-right" value="" >                                                                    
                                                                </div>														
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="dealer-detail-form-group">
                                                                    <span>Dealer Licence No</span>
                                                                    <input type="text" id="dealer_license" name="dealer_license" class="form-control pull-right" value="">
                                                                </div>														
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="dealer-detail-form-group">
                                                                    <span>Brands</span>
                                                                    <select class="form-control select-box" id="dealership_brand" name="dealership_brand[]" type="text" multiple="multiple">
                                                                        <?php foreach ($makes as $make) { ?>
                                                                        <option id="make_<?php echo $make->id_make; ?>" value="<?php echo $make->name; ?>"><?php echo $make->name; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>														
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="dealer-detail-form-group">
                                                                    <span>Catered States</span>
                                                                    <select class="form-control select-box" id="dealership_states" name="dealership_state[]" type="text" multiple="multiple">
                                                                        <?php foreach ($states as $state_key => $state_val) { ?>
                                                                            <option value="<?= $state_val ?>"><?= $state_val ?> </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>														
                                                            </div>
                                                        </div>
                                                        <div style="margin-bottom: 13px;" id="staff_details" hidden>
                                                            <div class="form-group">
                                                                <div class="dealer-detail-form-group">
                                                                    <span class="require-field">Admin Type</span>
                                                                    <select class="form-control select-box" id="admin_type" name="admin_type" type="text" >
                                                                        <option name="admin_type" value="1">Sales</option>
                                                                        <option name="admin_type" value="2">CQ Admin</option>
                                                                        <option name="admin_type" value="3">FQ Admin</option>
                                                                    </select>
                                                                </div>														
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group" >
                                                            <div class="dealer-detail-form-group">
                                                                <span class="require-field">Email</span>
                                                                <input type="text" name="username" class="form-control pull-right" value="" required>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <div class="dealer-detail-form-group">
                                                                <span class="require-field">Password</span>
                                                                <input type="password" name="password" class="form-control pull-right" value="" required>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <div class="dealer-detail-form-group">
                                                                <span class="require-field"> Re-enter Password</span>
                                                                <input name="confirm-password" type="password" class="form-control pull-right" value="" required>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <div class="dealer-detail-form-group">
                                                                <span class="require-field"> Name</span>
                                                                <input type="text" name="name" class="form-control pull-right" value="" required>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <div class="dealer-detail-form-group">
                                                                <span>ABN</span>
                                                                <input type="text" id="abn" name="abn" class="form-control pull-right" >
                                                            </div>														
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <div class="dealer-detail-form-group">
                                                                <span class=""> State</span>
                                                                <select class="form-control input-md" name="state" type="text">
                                                                    <option name="state" value="">-Select State-</option>
                                                                    <option name="state" value="ACT">ACT - Australian Capital Territory</option>
                                                                    <option name="state" value="NSW">NSW - New South Wales</option>
                                                                    <option name="state" value="NT">NT - Northern Territory</option>
                                                                    <option name="state" value="QLD">QLD - Queensland</option>
                                                                    <option name="state" value="SA">SA - South Australia</option>
                                                                    <option name="state" value="TAS">TAS - Tasmania</option>
                                                                    <option name="state" value="VIC">VIC - Victoria</option>
                                                                    <option name="state" value="WA">WA - Western Australia</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="dealer-detail-form-group">
                                                                <span>Postcode</span>
                                                                <input type="text" id="postcode" name="postcode" class="form-control pull-right" value="">
                                                            </div>														
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <div class="dealer-detail-form-group">
                                                                <span>Address</span>
                                                                <input type="text" id="address" name="address" class="form-control pull-right" value="">
                                                            </div>														
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="dealer-detail-form-group">
                                                                <span>Phone</span>
                                                                <input type="text" data-rule-number="true" name="phone" value="" class="form-control pull-right">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="dealer-detail-form-group">
                                                                <span>Mobile</span>
                                                                <input type="text" data-rule-number="true" name="mobile" value="" class="form-control pull-right">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="dealer-detail-form-group">
                                                                <span>Date of Birth</span>
                                                                <input class="form-control pull-right datepicker" name="dob" type="text"><br />
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="dealer-detail-form-group">
                                                                <span>Account Holder's Name</span>
                                                                <input type="text" name="acct_holders_name" class="form-control pull-right">
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="dealer-heading-outer">
                                                            <h5 class="dealer-heading">Bank Details</h5>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="dealer-detail-form-group">
                                                                <span>Account Name</span>
                                                                <input type="text" id="bank_acct_name" name="bank_acct_name" class="form-control pull-right">
                                                            </div>														
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <div class="dealer-detail-form-group">
                                                                <span>Account No</span>
                                                                <input type="text" id="bank_acct_num" name="bank_acct_num" class="form-control pull-right">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="dealer-detail-form-group">
                                                                <span>BSB</span>
                                                                <input type="text" id="bank_acct_bsb" name="bank_acct_bsb" class="form-control pull-right">
                                                            </div>														
                                                        </div>
                                                        <div class="dealer-heading-outer">
                                                            <h5 class="dealer-heading">Notes :</h5>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="dealer-detail-form-group">
                                                                <textarea style="width:100%" rows="3" id="textareaDefault" name="description" id="description" class="form-control " ></textarea>
                                                            </div>														
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group text-right">
                                                            <button class="btn btn-primary btn-save" type="submit">Save</button>
                                                        </div>
                                                    </div>
                                                    <!--<div class="col-md-6">

                                                        <div id="dealer_contact_form">
                                                            <div class="form-group">
                                                                <div class="dealer-detail-form-group">
                                                                    <span>Title</span>
                                                                    <input type="text" name="dealership_contact_title" class="form-control pull-right" value="">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="dealer-detail-form-group">
                                                                    <span class="require-field">Full Name</span>
                                                                    <input type="text" name="name" class="form-control pull-right" value="" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="dealer-detail-form-group">
                                                                    <span class="require-field">Email = Username</span>
                                                                    <input type="email" name="email" class="form-control pull-right" value="" required>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>

                                                        <div class="form-group text-right">
                                                            <button type="button" name="send_notification" class="btn btn-default btn-custom sendNotificationToDealer" data-id=" $dealer['id_user']">Send Notification</button>
                                                            <button class="btn btn-default btn-close" type="button" data-dismiss="modal">Close</button>
                                                            <button class="btn btn-default btn-save" type="button" onclick="save_dealer_info()">Save</button>
                                                        </div>

                                                    </div>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
					<!-- end: page -->
					<?php include 'modals/ticket_modals.php'; ?>
				</section>
			</div>
			<?php include 'template/right_sidebar.php'; ?>
		</section>
		<?php include 'template/scripts.php'; ?>
		<script type="text/javascript">
            $(document).ready(function(){
                $("#dealership_brand").select2();
                $("#dealership_states").select2();
                $(document).on('submit', '#form_account_creation', function () {
                    var state_id = $('#state_id').val();
                    var city_name = $('#city_name').val();
                    var postData = new FormData(this);
                    $.ajax({
                        url: "<?=site_url('account/verify_account_creation') ?>",
                        type: "POST",
                        processData: false,
                        contentType: false,
                        cache: false,
                        data: postData,
                        success: function (response) {
                            var json = $.parseJSON(response);
                            console.log(json);
                            if (json['error'] == 'validation_errors') {
                                swal("ERROR", json['validation_msg'], "error");
                            }
                            if (json['success'] == 'Added') {
                                window.location.href = json['ref_url'];
                            }
                            return false;
                        },
                    });
                    return false;
                });
                
            });
			function check_user_type (user_type)
			{
				if (user_type == 1)
				{
					$("#dealership_details").show();
					$("#staff_details").hide();
				}
				else if (user_type == 2)
				{
					$("#staff_details").show();
					$("#dealership_details").hide();
				}
				else if (user_type==4 || user_type==3)
				{
					$("#staff_details").hide();
					$("#dealership_details").hide();
				}
			}
		</script>
	</body>
</html>
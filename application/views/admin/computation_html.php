<style type="text/css">
   .form-control[readonly] {
   background-color: transparent;
   }
  	#send_client_purchase_order_model,#send_dealer_purchase_order_model
  	{
  		position: absolute;
  		top: -100px;
  	}
   #send_client_purchase_order_model .panel-body {
   background-color: #fff!important;
   }
   #send_client_purchase_order_model .panel-footer {
   background-color: #fff!important;
   }
   #send_dealer_purchase_order_model .panel-body {
   background-color: #fff!important;
   }
   #send_dealer_purchase_order_model .panel-footer {
   background-color: #fff!important;
   }
</style>
<section>
	<div class="row">
	   <div class="col-md-12">
	      <?php
	         if (count($deal_requirements['errors']) == 0 ){
	             ?>
	      <a href="<?php echo base_url().'index.php/fapplication/client_purchase_order/client/'.$lead['id_fq_account']?>" target="_blank" class="btn btn-default btn-sm" >Preview Client Purchase Order</a>
	      <a href="<?php echo base_url().'index.php/fapplication/client_purchase_order/dealer/'.$lead['id_fq_account']?>" target="_blank" class="btn btn-default btn-sm" >Preview Dealer Purchase Order</a>
	      <?php
	         }else{
	             ?> 
	      <button class="btn btn-default btn-sm"  disabled type="button" >Preview Client Purchase Order</button>
	      <button class="btn btn-default btn-sm"  disabled type="button" >Preview Dealer Purchase Order</button>
	      <?php
	         }
	         ?>
	      <button class="btn btn-default btn-sm" disabled type="button">Preview Tax Invoice Request</button>
	      <button class="btn btn-default btn-sm" disabled type="button">Preview Trade Agreement</button>
	      <?php
	         if (count($deal_requirements['errors']) == 0 ){
	             ?>
	      <button class="btn btn-default btn-sm send_client_purchase_order" type="button" data-id_lead="<?php echo $lead['id_fq_account'];?>" data-email_template_id="<?php echo CLIENT_PURCHASE_ORDER;?>" >Send Client Purchase Order</button>
	      <button class="btn btn-default btn-sm send_dealer_purchase_order" type="button" data-id_lead="<?php echo $lead['id_fq_account'];?>" data-email_template_id="<?php echo DEALER_PURCHASE_ORDER;?>" >Send Dealer Purchase Order</button>
	      <!--<button class="btn btn-default btn-sm" disabled type="button">Send Dealer Purchase Order</button>-->
	      <?php
	         }
	         ?>
	   </div>
	</div>
	<br>
	<div class="row">
	   <div class="col-sm-12">
	      <?php if (count($deal_requirements['errors'])>0): ?>
	      <div class="alert alert-danger">
	         <i class="fa fa-exclamation-circle"></i>&nbsp;<strong>Deal Submission Requirements:</strong>
	         <ul>
	            <?php foreach ($deal_requirements['errors'] AS $deal_error): ?>
	            <li><?=$deal_error;?></li>
	            <?php endforeach; ?>
	         </ul>
	      </div>
	      <?php endif; ?>
	      <?php if (count($deal_requirements['warnings'])>0): ?>
	      <div class="alert alert-warning">
	         <i class="fa fa-warning"></i>&nbsp; <strong>Deal Warnings:</strong>
	         <ul>
	            
	            <?php foreach ($deal_requirements['warnings'] AS $deal_error): ?>
	            <li><?=$deal_warning;?></li>
	            <?php endforeach; ?>
	         </ul>
	      </div>
	      <?php endif; ?>							
	   </div>
	</div>
</section>
<section class="panel ">
   <form method="post" id="computationForm" name="computationForm">
      <input type="hidden" name="id_lead" value="<?= $lead['id_fq_account'];?>" />										
      <div class="panel-body">
         <div class="row">
            <div class="col-md-12">
               <h5><b style="color: white;">Valuation request sent to : </b></h5>
               <hr class="solid mt-sm mb-lg">
            </div>
         </div>
         <div class="row col-md-8">
            <div class="table-responsive">
               <?php
                  $special_conditions = ($lead_dealer_data['special_conditions'] != '') ? $lead_dealer_data['special_conditions'] : 'N/A';
                  ?>
               <table class="table table-bordered table-condensed mb-none">
                  <tr>
                     <td width="40%">Sale Price / Change over <font color="red">*</font> <span class="pull-right"><font color="white">$</font></span></td>
                     <td>
                        <!-- <select class="form-control input-sm input-tradein" id="" name="" required>
                           <option value="">--Select--</option>
                           <option value="">Select 1</option>
                           <option value="">Select 2</option>
                           </select> -->                            
                        <input type="text" name="new_lead_sale_price_comp" id="new_lead_sale_price_comp" value="<?php echo $fq_dealer_data['sale_price'] ?>" placeholder="Enter Sale prie " class="form-control input-sm input-tradein totalGross">
                     </td>
                  </tr>
                  <tr>
                     <td>Delivery Date <font color="red">*</font></td>
                     <td>
                        <?php
                           // $delivery_date = date_create($delivery_date_comp['delivery_date']);
                           $delivery_date = date_create($fq_dealer_data['delivery_date']);
                           $delivery_date = date_format($delivery_date,'Y-m-d');
                           ?>
                        <!-- <input value="" class="form-control input-sm input-tradein" id="" name="" type="text" > -->
                        <input value="<?php echo $delivery_date; ?>" class="form-control input-sm datepicker_mysql input-tradein" name="delivery_date_comp" type="text">
                     </td>
                  </tr>

                  <tr>
                     <td>Invoice to  

                        <span class="pull-right">
                           <input type="hidden" id="lead_invoice_to" value="<?php echo $lead['lead_name'] ?>">
                           <button type="button" id="lead_invoice_to_comp_btn" class="btn btn-default btn-sm">As recorded in Lead</button>
                        </span></td>
                     <td>
                       
                        <input value="<?php echo $computation_data['invoice_to']; ?>" class="form-control input-sm invoice_to input-tradein" name="invoice_to" type="text">
                     </td>
                  </tr>

                  <tr>
                     <td>
                        Delivery Instructions <font color="red">*</font>
                     </td>
                     <td>
                        <select class="form-control input-sm input-tradein" id="delivery_instruction" name="delivery_instructions" required>
                           <option value="">--Select--</option>
                           <option value="client_address" <?php if($lead_dealer_data['delivery_instructions'] == 'client_address') { echo 'selected'; } ?>>Dealer delivering to client's address </option>
                           <option value="client_dealer" <?php if($lead_dealer_data['delivery_instructions'] == 'client_dealer') { echo 'selected'; } ?>>Client to take delivery at the dealership</option>
                           <option value="transport" <?php if($lead_dealer_data['delivery_instructions'] == 'transport') { echo 'selected'; } ?>>Finquote organising Transport</option>
                           <option value="dealer_transport" <?php if($lead_dealer_data['delivery_instructions'] == 'dealer_transport') { echo 'selected'; } ?>>Dealer organising car carrier transportation</option>
                        </select>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        Delivery Address <font color="red">*</font>
                        <span class="pull-right">
                        <input type="hidden" id="lead_address_comp_hidden" value="<?php echo $fq_dealer_data['address'] ?>">
                        <button type="button" id="lead_address_comp_btn" class="btn btn-default btn-sm">As recorded in Lead</button>
                        </span>
                     </td>
                     <td><input style="width:100% !important" class="form-control input-sm input-tradein client_address google_address initial_address" id="lead_address_comp" name="lead_address_comp" type="text" value="<?php echo $lead_dealer_data['delivery_address'] ?>" required></td>
                  </tr>
                  <tr>
                     <td>Method of Purchase <font color="red">*</font></td>
                     <td>
                        <select class="form-control input-sm input-tradein" id="" name="method_of_purchase" required>
                           <option value="">--Select--</option>
                           <!-- <option value="">Select 1</option>
                              <option value="">Select 2</option> -->
                           <option value="no_finance" <?php if($computation_data['method_of_purchase'] == 'no_finance'){echo "selected==selected";}?>>No finance required, client purchasing outright</option>
                           <option value="own_finance"<?php if($computation_data['method_of_purchase'] == 'own_finance'){echo "selected==selected";}?>>Client has organised their own finance</option>
                           <option value="finquote"<?php if($computation_data['method_of_purchase'] == 'finquote'){echo "selected==selected";}?>>Finquote organising finance on the client's behalf</option>
                           <option value="dealer"<?php if($computation_data['method_of_purchase'] == 'dealer'){echo "selected==selected";}?>>Dealer organising finance on the client's behalf</option>
                        </select>
                     </td>
                  </tr>
                  <tr>
                     <td>Special Conditions <font color="red">*</font></td>
                     <td><input value="<?php echo $special_conditions; ?>" class="form-control input-sm input-tradein" id="" name="special_conditions" type="text" required></td>
                  </tr>
                  <tr>
                     <!-- <td>Select case number <font color="red">*</font></td>
                        <td><input value="" class="form-control input-sm input-tradein" id="" name="" type="text"></td> -->
                     <input type="hidden" name="deposite"  value="<?php echo $fq_dealer_data['deposite_amt'];?>">
                     <td>Include New Vehicle Security on Dealer purchase order <font color="red">*</font></td>
                     <td>
                        <select class="form-control input-sm input-tradein" required name="include_dealer">
                           <option value="">--Select--</option>
                           <option value="yes"<?php if($computation_data['include_dealer'] == 'yes'){echo "selected==selected";}?> >Yes</option>
                           <option value="no"<?php if($computation_data['include_dealer'] == 'no'){echo "selected==selected";}?>>No</option>
                        </select>
                     </td>
                  </tr>
               </table>
            </div>
         </div>
         <!-- <div class="clearfix"></div>
            <div class="row" style="margin-top: 10px;">
                <div class="col-sm-12">
                    <div class="alert alert-info">														
                        <p><strong>Case 1 : </strong>Dealer documentation to client to include deposit</p>
                        <p><strong>Case 2 : </strong>Dealer documentation to client to reflect quoted price, Finquote providing client a tax invoice for transactions processed over and above dealer quote</p>
                        <p><strong>Case 3 : </strong>Client dealing with dealer direct with Finquote sending a tax invoice for introducer Fees</p>
                    </div>
                </div>
            </div> -->
         <div class="clearfix"></div>
         <div class="row" style="margin-top: 10px;">
            <?php
               if($delivery_date_comp['on_road'] == 1 || $delivery_date_comp['car_off_road'] != 0) :
               ?>
            <div class="col-sm-12">
               <div class="alert alert-info">
                  <?php
                     if($delivery_date_comp['on_road'] == 1) {
                     ?>
                  <p>*All GST, LCT (where applicable), Dealer Charges, State and Territory stamp duty, registration and on road costs are included in this order and balance payable to suppling dealer.</p>
                  <?php
                     }
                     if($delivery_date_comp['car_off_road'] != 0) {
                     ?>
                  <p>*All GST, LCT (where applicable) and Dealer Charges are included in this order and balance payable to suppling dealer. This order excludes State and Territory on road charges. Client is responsible for Stamp Duty and Registraion charges within state and territory of registration.</p>
                  <?php
                     }
                     ?>
               </div>
            </div>
            <?php endif ?>
         </div>
         <div class="clearfix"></div>
         <div class="row col-md-8">
            <div class="row" style="color: white;">
               <div class="col-md-6">
                  Trade Details <font color="red">*</font> 
               </div>
               <div class="col-md-6">
                  Include Trade : <input type="checkbox" <?php if($computation_data['trade_include']== 1){echo "checked";}?> value="1" name="trade_include" id="trade_include">
               </div>
            </div>
            <div class="table-responsive">

               <table class="table table-bordered table-condensed mb-none">
                  <tr>
                     <td width="40%">Winning Valuer</td>
                     <td>
                        <!--<input value="<?php echo $winner_trade_valuation['name'] ?>" class="form-control input-sm input-tradein" id="" name="valuer_name_comp" type="text" required>-->
                        <input value="<?php echo $fq_dealer_data['dealer'] ?>" class="form-control input-sm input-tradein" id="valuer_name_comp" name="valuer_name_comp" type="text" >
                     </td>
                  </tr>
                  <tr>
                     <td>Winning Valuation $</td>
                     <td>

                        <!--<input value="<?php echo $winner_trade_valuation['value'] ?>" class="form-control input-sm input-tradein totalGross" id="valuation_comp" name="valuation_comp" type="text" required>-->
                        <input value="<?php echo $winner_trade_valuation['value'] ?>" class="form-control input-sm input-tradein totalGross" id="valuation_comp" name="valuation_comp" type="text" >
                     </td>
                  </tr>
                  <tr>
                     <td>Show Trade Valuation</td>
                     <!-- <td><input value="" class="form-control input-sm input-tradein" id="" name="" type="text"></td> -->
                     <td>
                        <select name="trade_valuation_sel" id="trade_valuation_sel" class="form-control input-sm input-tradein">
                           <option value="">--Select--</option>
                           <option value="1" <?php if($computation_data['trade_valuation_sel']== 1){echo "selected";}?>>Yes</option>
                           <option value="0"  <?php if($computation_data['trade_valuation_sel']== 0){echo "selected";}?>>No</option>
                        </select>
                     </td>
                  </tr>
                  <tr>
                     <td>Trade valuation given to client</td>
                     <td>
                        <input type="text" name="tradein_valuaton" id="tradein_valuaton" class="form-control input-sm input-tradein totalGross"  value="<?php echo $computation_data['tradein_valuaton'];?>">
                     </td>
                  </tr>
                  <tr>
                     <td>
                        Trade Payout Allowed 
                        <span class="pull-right">
                        <button type="button" id="no_payout" data-payout="<?php echo $computation_data['trade_payout'];?>" class="btn btn-sm btn-default">No Payout</button>
                        </span>
                     </td>
                     <td><input value="<?php echo $computation_data['trade_payout'];?>" id="trade_payout" class="form-control input-sm input-tradein" name="trade_payout" type="text"></td>
                  </tr>
                   <tr>
                     <td>
                        Changeover
                     </td>
                     <td><input value="<?php echo "$".($fq_dealer_data['sale_price']-$winner_trade_valuation['value']);?>" id="trade_changeover" class="form-control input-sm input-tradein" name="trade_changeover" type="text"></td>
                  </tr>
               </table>
            </div>
         </div>
         <div class="clearfix"></div>
         <br>
         <div class="row col-md-8">
            <div class="row" style="color: white;">
               <div class="col-md-6">
                  Aftermarket
               </div>
            </div>
            <div class="table-responsive">
               <table class="table table-bordered table-condensed mb-none">
                  <tr>
                     <td width="40%">Aftermarket Products</td>
                     <td><input value="<?php if($computation_data['aftermarket_product'] == ''){echo "N/A";}else{echo $computation_data['aftermarket_product'] ;}?>" class="form-control input-sm input-tradein" id="" name="aftermarket_product" type="text" ></td>
                  </tr>
                  <tr>
                     <td>Aftermarket Products Cost</td>
                     <td>
                        <select name="aftermarket_product_cost" id="aftermarket_product_cost" class="form-control input-sm input-tradein" >
                           <option value="">--Select--</option>
                           <option value="115.00" <?php if($computation_data['aftermarket_product_cost']== '115.00'){echo "selected";}?>>Aurora Tint 2 wind Up (115.00)</option>
                           <option value="210.00" <?php if($computation_data['aftermarket_product_cost']== '210.00'){echo "selected";}?>>Aurora Tint Full Vehicle (210.00)</option>
                           <option value="137.50" <?php if($computation_data['aftermarket_product_cost']== '137.50'){echo "selected";}?>>Stratosphere Tint 2 Wind Up (137.50)</option>
                           <option value="282.00" <?php if($computation_data['aftermarket_product_cost']== '282.00'){echo "selected";}?>>Stratosphere Tint Full Vehicle (282.00</option>
                           <option value="478.00" <?php if($computation_data['aftermarket_product_cost']== '478.00'){echo "selected";}?>>Permagard Full vehicle (478.00</option>
                           <option value="328.00" <?php if($computation_data['aftermarket_product_cost']== '328.00'){echo "selected";}?>>Paint Protection Only (328.00</option>
                           <option value="169.00" <?php if($computation_data['aftermarket_product_cost']== '169.00'){echo "selected";}?>>Interior Protection Only (169.00</option>
                           <option value="625.00" <?php if($computation_data['aftermarket_product_cost']== '625.00'){echo "selected";}?>>Rejuvenation Kit (625.00</option>
                           <option value="725.00" <?php if($computation_data['aftermarket_product_cost']== '725.00'){echo "selected";}?>>Rejuvenation Kit Large (725.00)</option>
                           <option value="129.00" <?php if($computation_data['aftermarket_product_cost']== '129.00'){echo "selected";}?>>Buff & Polish (129.00)</option>
                        </select>
                        <!-- <input value="" class="form-control input-sm input-tradein" id="" name="aftermarket_product_cost" type="text"> -->
                     </td>
                  </tr>
                  <tr>
                     <td>
                        Aftermarket Sale Price 
                        <span class="pull-right"><font color="white">$</font></span>
                     </td>
                     <td><input value="<?php echo $computation_data['aftermarket_sale_price'];?>" class="form-control input-sm input-tradein" id="aftermarket_sale_price" name="aftermarket_sale_price" type="text" ></td>
                  </tr>
                  <tr>
                     <td>Aftermarket Revenue Before Tax </td>
                     <td><input value="<?php echo $computation_data['aftermarket_revenue'];?>" class="form-control input-sm input-tradein totalGross" id="aftermarket_revenue" name="aftermarket_revenue" type="text" readonly=""></td>
                  </tr>
                  <tr>
                     <td>&nbsp;</td>
                     <td>
                        <button type="button" id="btnAfterConfirm">Send aftermarket confirmation email</button>
                     </td>
                  </tr>
               </table>
            </div>
         </div>
         <div class="clearfix"></div>
         <br>
         <div class="row col-md-8">
            <div class="row" style="color: white;">
               <div class="col-md-6">
                  Finance
               </div>
            </div>
            <div class="table-responsive">
               <table class="table table-bordered table-condensed mb-none">
                  <tr>
                     <td width="40%">Origination Fee</td>
                     <td>
                        <input value="<?php echo $finance['origination_fee'] ?>" class="form-control input-sm input-tradein" id="origination_fee_comp" name="origination_fee_comp" type="text" required>
                     </td>
                  </tr>
                  <tr>
                     <td>Origination Revenue</td>
                     <td>
                        <input class="form-control input-sm input-tradein" id="origination_revenue_comp" name="origination_revenue_comp" type="text" readonly="readonly">
                     </td>
                  </tr>
                  <tr>
                     <td>Brokerage Gross</td>
                     <td>
                        <input value="<?php echo $finance['commision'] ?>" class="form-control input-sm input-tradein" id="brokerage_gross_comp" name="brokerage_gross_comp" type="text" required>
                     </td>
                  </tr>
                  <!-- <tr>
                     <td>Brokerage Revenvue Before Tax</td>
                     <td>
                        <input class="form-control input-sm input-tradein" id="brokerage_revenue_comp" name="brokerage_revenue_comp" type="text" readonly="readonly">
                     </td>
                  </tr> -->
                  <tr>
                     <td>Finance Revenvue Before Tax</td>
                     <td>
                        <input class="form-control input-sm input-tradein totalGross" id="finance_revenue_comp" name="finance_revenue_comp" type="text" readonly="readonly">
                     </td>
                  </tr>
               </table>
            </div>
         </div>
         <div class="clearfix"></div>
         <br>
         <div class="row col-md-8">
            <div class="row" style="color: white;">
               <div class="col-md-6">
                  BALCO
               </div>
            </div>
            <div class="table-responsive">
               <table class="table table-bordered table-condensed mb-none">
                  <tr>
                     <td width="40%">Dealer Balco&nbsp;<b>$</b></td>
                     <td><input value="<?php echo $computation_data['dealer_balco'];?>" class="form-control input-sm input-tradein" id="" name="dealer_balco" type="text"></td>
                  </tr>
                  <tr>
                     <td>Client balco&nbsp;<b>$</b></td>
                     <td><input value="<?php echo $computation_data['client_balco'];?>" class="form-control input-sm input-tradein" id="" name="client_balco" type="text"></td>
                  </tr>
                  <tr>
                     <td>Finquote Balco&nbsp;<b>$</b></td>
                     <td><input value="<?php echo $computation_data['finquote_balco'];?>" class="form-control input-sm input-tradein" id="" name="finquote_balco" type="text"></td>
                  </tr>
               </table>
            </div>
         </div>
         <div class="clearfix"></div>
         <br>
         <div class="row col-md-8">
            <div class="row" style="color: white;">
               <div class="col-md-6">
                  Computation:
               </div>
            </div>
            <div class="table-responsive">
               <table class="table table-bordered table-condensed mb-none">
                  <tr>
                     <td width="40%">Total Gross Revenue</td>
                     <td><input value="<?php echo $computation_data['total_gross_revenue'];?>" class="form-control input-sm input-tradein" id="total_gross_revenue" name="total_gross_revenue" type="text"></td>
                  </tr>
                  <tr>
                     <td>Commissionable Gross</td>
                     <td><input value="<?php echo $computation_data['commissionable_gross'];?>" class="form-control input-sm input-tradein" id="" name="commissionable_gross" type="text"></td>
                  </tr>
                  <tr>
                     <td>Net Revenue Before Tax & Commission</td>
                     <td><input value="<?php echo $computation_data['net_revenue'];?>" class="form-control input-sm input-tradein" id="" name="net_revenue" type="text"></td>
                  </tr>
               </table>
            </div>
         </div>
         <div class="clearfix"></div>
         <br>
         <div class="row" style="margin-top: 10px;">
            <div class="col-sm-12">
               <button type="submit" id="computationBtn" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
            </div>
         </div>
      </div>
   </form>
</section>
<div id="send_client_purchase_order_model" class="modal fade">
   <div class="modal-dialog" style="width: 80%;">
      <section class="panel">

      <form  id="send_client_purchaseorder" name="send_client_purchaseorder">
            <input type="hidden" id="send_mail_template_subject" name="send_mail_template_subject">
            <input type="hidden" id="id_lead" name="id_lead">
            <div class="panel-body">
                        
               <div class="form-group">
                  <!-- <label>Reciepent : </label>
                  <div class="form-group">
                     <select class="form-control input-sm client_email" name="client_email[]" id="client_email">
                      
                     </select>
                  </div> -->
               </div>
               <div class="modal-wrapper">
                  <div class="form-group attachment_container">
                  <div class="input-group email_attachment_group" style="margin-bottom: 10px;">
                     <select class="form-control input-sm client_email_attachment_select" name="client_email_attachment_select[]" id="client_email_attachment_select">
                      
                     </select>
                     <span class="input-group-addon add_attachment" style="cursor: pointer;cursor: hand;"><i class="fa fa-plus" style="display:block"></i></span>
                     <span class="input-group-addon remove_attachment" style="cursor: pointer;cursor: hand;"><i class="fa fa-times"></i></span>
                  </div>
               </div>

               <textarea name="client_email_template_content"  id="client_email_template_content" class="client_email_template_content" rows="10" cols="80"></textarea>
               </div>
            </div>
            <footer class="panel-footer">
               <div class="row">
                  <div class="col-md-12 text-right">
                     <button type="button" class="btn btn-primary " id="mail_client_purchase_order">Submit</button>
                     <button type="button" class="btn btn-default client_purchase_order_btn" >Close</button>
                  </div>
               </div>
            </footer>
         </form>
      </section>
   </div>
</div>
<div id="send_dealer_purchase_order_model" class="modal fade">
   <div class="modal-dialog" style="width: 80%;">
      <section class="panel">
         <form  id="send_dealer_purchaseorder" name="send_dealer_purchaseorder">
            <input type="hidden" id="send_mail_template_subject" name="send_mail_template_subject">
            <input type="hidden" id="id_lead" name="id_lead">
            <div class="panel-body">
               <div class="form-group">
                  <!-- <label>Reciepent : </label>
                  <div class="form-group">
                     <select class="form-control input-sm dealer_email" name="dealer_email[]" id="dealer_email">
                      
                     </select>
                  </div> -->
               </div>
               <div class="modal-wrapper">
                  <div class="form-group attachment_container">
                  <div class="input-group email_attachment_group" style="margin-bottom: 10px;">
                     <select class="form-control input-sm dealer_email_attachment_select" name="dealer_email_attachment_select[]" id="dealer_email_attachment_select">
                      
                     </select>
                     <span class="input-group-addon add_attachment" style="cursor: pointer;cursor: hand;"><i class="fa fa-plus" style="display:block"></i></span>
                     <span class="input-group-addon remove_attachment" style="cursor: pointer;cursor: hand;"><i class="fa fa-times"></i></span>
                  </div>
               </div>
                  <textarea name="dealer_email_template_content"  id="dealer_email_template_content" class="dealer_email_template_content" rows="10" cols="80"></textarea>
               </div>
            </div>
            <footer class="panel-footer">
               <div class="row">
                  <div class="col-md-12 text-right">
                     <button type="button" class="btn btn-primary " id="mail_dealer_purchase_order">Submit</button>
                     <button type="button" class="btn btn-default dealer_purchase_order_btn" >Close</button>
                  </div>
               </div>
            </footer>
         </form>
      </section>
   </div>
</div>
<!--
   <style>
   .loading {
     position: fixed;
     z-index: 999;
     height: 2em;
     width: 2em;
     overflow: visible;
     margin: auto;
     top: 0;
     left: 0;
     bottom: 0;
     right: 0;
   }
   
   .loading:before {
     content: '';
     display: block;
     position: fixed;
     top: 0;
     left: 0;
     width: 100%;
     height: 100%;
     background-color: rgba(0,0,0,0.3);
   }
   </style>
   <div class="loading"><img src="<?php echo base_url();?>assets/img/loader.gif"></div>
   -->
<script type="text/javascript">
    CKEDITOR.replace('client_email_template_content');
    CKEDITOR.replace('dealer_email_template_content');
</script>
<script type="text/javascript">
   //$(".loading").hide();
   var computation_changedFlag = 0;
   
       $(document).ready(function() {



            $('textarea.send_email_template_content').ckeditor({ 
   		            height: 300,
   		            allowedContent:true
   		   });
   
           $('.send_client_purchase_order').click(function(e) {
               
               var id_lead = $(this).data("id_lead");
               var email_template_id = $(this).data("email_template_id");
               var  this_modal = $("#send_client_purchase_order_model");
               var data = {
                   id: email_template_id,
                   id_lead: id_lead,
                   user_type: "Client",
               };
   
               $.ajax({
                   type: "POST",
                   url: "<?php echo site_url("fapplication/get_system_email_template/client_purchase_order"); ?>",
                   data: data,
                   cache: false,
                   dataType: 'json',
                   success: function(data){
                       CKEDITOR.instances.client_email_template_content.setData(data.content);
                       this_modal.find("#client_email_attachment_select").html(data.email_attachment_select);
                       this_modal.find("#send_mail_template_subject").val(data.subject);
                       this_modal.find("#id_lead").val(id_lead);
                       $(this_modal).modal({
                           backdrop: 'static',
                           keyboard: false
                       });
                   }
               });

            //    $.ajax({
            //    type: "POST",
            //    url: "<?php echo site_url('fapplication/client_email_list'); ?>",
            //    data: data,
            //    dataType: 'json',
            //    cache: false,
            //    success: function(data) {
            //       var selOpts = "";
            //       $('#client_email').empty()
            //       for (i=0;i<data.length;i++)
            //       {
            //           var id = data[i]['id_email_list'];
            //           var val = data[i]['email'];
            //           selOpts += "<option value='"+id+"'>"+val+"</option>";
            //       }
            //       $('#client_email').append(selOpts);
                  
            //    }
            // });   


               
           });
           
            $('#mail_client_purchase_order').click(function(e) {

              var postData = $("#send_client_purchaseorder").serialize();
               var  send_mail_template_subject =  $("#send_client_purchase_order_model").find("#send_mail_template_subject").val();
               var id_lead = $("#send_client_purchase_order_model").find("#id_lead").val();
               var client_email_template_content = CKEDITOR.instances. client_email_template_content.getData();
               var email_attachment_select =  $(".client_email_attachment_select").map(function(){return $(this).val();}).get();
               
              
               $.ajax({
                   type: "POST",
                   url: "<?php echo site_url("fapplication/send_client_purchaseorder"); ?>",
                   data: {id_lead:id_lead,send_mail_template_subject:send_mail_template_subject,email_attachment_select:email_attachment_select,client_email_template_content:client_email_template_content},
                   success: function(response) {
                      var order_Date = '<?php echo date("d-m-Y");?>';
                     if($("#order_date").val() == ''){
                        $("#order_date").val(order_Date) ;
                     }
                       //console.log(response);
                       var res = response.trim();
                       if (res === "success") {
                         
                           $('.attachment_container div:not(:first)').remove();
                           $("#send_client_purchase_order_model").modal("hide");
                           swal("SUCCESS", "", "success");
                       } else {
                           swal("ERROR", "An error occurred! Please try again", "error");
                       }
                   }
               });
   		   });
   
           $('.client_purchase_order_btn').click(function(e) {
               $("#send_client_purchase_order_model").modal("hide");
           });
   
           $('.send_dealer_purchase_order').click(function(e) {
               
               var id_lead = $(this).data("id_lead");
               var email_template_id = $(this).data("email_template_id");
               var  this_modal = $("#send_dealer_purchase_order_model");
               var data = {
                   id: email_template_id,
                   id_lead: id_lead,
                   user_type: "Dealer",
                   
               };
   
               $.ajax({
                   type: "POST",
                   url: "<?php echo site_url("fapplication/get_system_email_template/dealer_purchase_order"); ?>",
                   data: data,
                   cache: false,
                   dataType: 'json',
                   success: function(data){
                       CKEDITOR.instances.dealer_email_template_content.setData(data.content);
                       this_modal.find("#send_mail_template_subject").val(data.subject);
                       this_modal.find("#id_lead").val(id_lead);
                       $(this_modal).modal({
                           backdrop: 'static',
                           keyboard: false
                       });
                   }
               });

            //    $.ajax({
            //    type: "POST",
            //    url: "<?php echo site_url('fapplication/email_recipient'); ?>",
            //    data: data,
            //    dataType: 'json',
            //    cache: false,
            //    success: function(data) {
            //       var selOpts = "";
            //       $('#dealer_email').empty()
            //       for (i=0;i<data.length;i++)
            //       {
            //           var id = data[i];
            //           var val = data[i];
            //           selOpts += "<option value='"+id+"'>"+val+"</option>";
            //       }
            //       $('#dealer_email').append(selOpts);
                  
            //    }
            // }); 


                $.ajax({
                   type: "POST",
                   url: "<?php echo site_url("fapplication/get_system_email_template/client_purchase_order"); ?>",
                   data: data,
                   cache: false,
                   dataType: 'json',
                   success: function(data){
                       CKEDITOR.instances.client_email_template_content.setData(data.content);
                       this_modal.find("#dealer_email_attachment_select").html(data.email_attachment_select);
                       this_modal.find("#send_mail_template_subject").val(data.subject);
                       this_modal.find("#id_lead").val(id_lead);
                       $(this_modal).modal({
                           backdrop: 'static',
                           keyboard: false
                       });
                   }
               });



               
           });
   
            $('#mail_dealer_purchase_order').click(function(e) {
               var postData = $("#send_dealer_purchaseorder").serialize();
               var  send_mail_template_subject = $("#send_dealer_purchase_order_model").find("#send_mail_template_subject").val();
               var id_lead = $("#send_dealer_purchase_order_model").find("#id_lead").val();
               var dealer_email_template_content = CKEDITOR.instances.dealer_email_template_content.getData();
               $.ajax({
                   type: "POST",
                   url: "<?php echo site_url("fapplication/send_dealer_purchaseorder"); ?>",
                   data: {id_lead:id_lead,send_mail_template_subject:send_mail_template_subject,dealer_email_template_content:dealer_email_template_content},
                   success: function(response) {
                       
                       //console.log(response);
                       var res = response.trim();
                       if (res === "success") {
                           $("#send_dealer_purchase_order_model").modal("hide");
                           swal("SUCCESS", "", "success");
                       } else {
                           swal("ERROR", "An error occurred! Please try again", "error");
                       }
                   }
               });
   		   });
   
            $('.dealer_purchase_order_btn').click(function(e) {
                  $("#send_dealer_purchase_order_model").modal("hide");
            });
      
            $('.datepicker_mysql').datepicker({
                  format: 'yyyy-mm-dd',
                  todayBtn: "linked",
                  autoclose: true
            });
      
            $("#computationForm :input").change(function() {
                  computation_changedFlag++;
            });
          
   
           /**/
           var origination_fee = $('#origination_fee_comp').val();
           let origination_revenue;
           if(origination_fee != '') {
               origination_revenue = (origination_fee * 90) / 100;
               origination_revenue = origination_revenue.toFixed(2);
               $('#origination_revenue_comp').val(origination_revenue);
           }
   
           var brokerage_gross = $('#brokerage_gross_comp').val();
           let brokerage_revenue;
           if(brokerage_gross != '') {
               brokerage_revenue = (brokerage_gross * 90) / 100;
               brokerage_revenue = brokerage_revenue.toFixed(2);
               $('#brokerage_revenue_comp').val(brokerage_revenue);
           }
   
           let finance_revenue;
           if(origination_revenue != '' && brokerage_revenue != '') {
               finance_revenue = parseFloat(origination_revenue) + parseFloat(brokerage_revenue);
               $('#finance_revenue_comp').val(finance_revenue.toFixed(2));
           }
   
           $('#origination_fee_comp, #brokerage_gross_comp').keypress(function(key) {
               if(key.charCode < 46 || key.charCode > 57 || key.charCode == 47) return false;
           });
   
           $('#origination_fee_comp').on('change',function() {
               let origination_fee = $(this).val();
               if(origination_fee != '') {
                   origination_revenue = (origination_fee * 90) / 100;
                   origination_revenue = origination_revenue.toFixed(2);
                   $('#origination_revenue_comp').val(origination_revenue);

                   brokerage_gross_amt = (parseFloat(origination_fee) + parseFloat(origination_revenue));
                   $("#brokerage_gross_comp").val(brokerage_gross_amt.toFixed(2));
   
                   /**/
                   //finance_revenue = parseFloat(origination_revenue) + parseFloat(brokerage_revenue);
                   $('#finance_revenue_comp').val(((brokerage_gross_amt * 90)/100).toFixed(2));
                   totalGross();
               }
               else {
                   swal("ERROR", "Please Enter Origination Fee", "error");
               }
           });
   
           $('#brokerage_gross_comp').on('change',function() {
               let brokerage_gross = $(this).val();
               if(brokerage_gross != '') {
                   brokerage_revenue = (brokerage_gross * 90) / 100;
                   brokerage_revenue = brokerage_revenue.toFixed(2);
                   $('#brokerage_revenue_comp').val(brokerage_revenue);
   
                   /**/
                   finance_revenue = parseFloat(origination_revenue) + parseFloat(brokerage_revenue);
                   $('#finance_revenue_comp').val(finance_revenue.toFixed(2));
                   totalGross();
               }
               else {
                   swal("ERROR", "Please Enter Brokerage Gross", "error");
               }
           });
   
   
           /**/
           $('#lead_address_comp_btn').click(function() {
               var lead_address = $('#lead_address_comp_hidden').val();
               $('#lead_address_comp').val(lead_address);
               // $('#lead_address_comp').attr('readonly','readonly');
           });

           $('#lead_invoice_to_comp_btn').click(function() {
               var invoice_to = $('#lead_invoice_to').val();
               $('.invoice_to').val(invoice_to);
            
           });
           
           /* Computation Submit */
           $('#computationForm').submit(function(e) {
               e.preventDefault();
               var flg = 0;
               if($("#trade_include").prop('checked') == true){
                   if($("#valuer_name_comp").val() == '' || $("#valuation_comp").val() == '' || $("#trade_valuation_sel").val() == '' || $("#tradein_valuaton").val() == ''|| $("#trade_payout").val() == ''){
                       
                       swal("ERROR", "Fill all Trade Details", "error");
                       flg = 1;
                   }
                
               }
   
               if(flg == 0){
                   $.ajax({
                       type: "POST",
                       url: "<?php echo site_url("fapplication/computation_save"); ?>",
                       data: $('#computationForm').serialize(),
                       success: function(data) {
                           // console.log(data);
                           data = jQuery.parseJSON(data);
                           if(data.success) {
                               // swal("SUCCESS", data.message, "success");
                           /* swal({
                                   title: "SUCCESS",
                                   text: data.message,
                                   type: "success"
                               }, function() {
                                   save_fapplication_info_2(22);
                               });*/
                               computation_changedFlag = 0;
                               save_fapplication_info_2(22);
                           }
                           else {
                               swal("ERROR", data.message, "error");
                           }
                       }
                   });
               }
               
           });
   
           /**/
           $('#no_payout').click(function() {
               $('input[name="trade_payout"]').val('N/A');
           });
   
          
           $('#aftermarket_sale_price').on('keyup', function() {
               var product_cost = $('#aftermarket_product_cost').val();
               if(product_cost == '') {
                   swal("ERROR", 'Please Select Product Cost First.', "error");
                   $(this).val('');
               }
               else {
                   let sale_price = $(this).val();
                   let revenue = sale_price - product_cost;
                   $('#aftermarket_revenue').val(revenue)
               }
               totalGross();
           });
   
           $('#aftermarket_sale_price').keypress(function(key) {
               if(key.charCode < 48 || key.charCode > 57) return false;
           });
   
           /**/
           totalGross();
           /**/
       });
   
     
       $('.totalGross').on('change',function() {
           totalGross();
       });
       function totalGross()
       {
           // (Sale Price - Dealers Quote) + (Trade Value - Trade Value given) + Aftermarket Revenue Gross before tax + Finance Revenue Before Tax + $165 fee if ticked in lead

           //(Sale Price – Winning Quote Price)+(winning trade valuation – Trade Valuation Given to client)+(Aftermarket Revenue Before Tax)+(Finance Revenue Before Tax)+(New Vehicle Security Fee) 

           let sale_price = $('#new_lead_sale_price_comp').val()== '' ? 0 :$('#new_lead_sale_price_comp').val(); 
           let dealer_quote = $('#valuation_comp').val() == '' ? 0 :$('#valuation_comp').val();
           let trade_value = $('#valuation_comp').val() == '' ? 0 :$('#valuation_comp').val(); 
           let trade_value_given = $('#tradein_valuaton').val()== '' ? 0 :$('#tradein_valuaton').val(); 
           let aftermarket_revenue = $('#aftermarket_revenue').val()== '' ? 0 :$('#aftermarket_revenue').val(); 
           let finance_revenue = $('#finance_revenue_comp').val()== '' ? 0 :$('#finance_revenue_comp').val();
           let new_veh_sec = '';
           var lead_ticked = 0;
           if($('#checkbox').prop("checked") == true){
               
                lead_ticked = 165;
               
           }
         
          
          
           let salePrice_dealerQuote = sale_price - dealer_quote;
           let tradeValue_tradeValueGiven = trade_value - trade_value_given;
           let total_gross_revenue = parseFloat(salePrice_dealerQuote) + parseFloat(tradeValue_tradeValueGiven) + parseFloat(aftermarket_revenue) + parseFloat(finance_revenue)  + parseFloat(lead_ticked) ;
          
           $('#total_gross_revenue').val(parseFloat(total_gross_revenue));
           
           
       }
</script>
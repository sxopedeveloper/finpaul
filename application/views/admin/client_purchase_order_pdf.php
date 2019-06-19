<html>
   <head>
      <title>Finquote</title>
      <style>
         body
         {
            font-size:12px;
         }
      </style>

   </head>
   <body>
      <section class="header-section">
         <div class="container">
            <div class="row">
               <div style="display: flex; align-items: center; justify-content: center;">
                  <div style="width:80%; float:left;">
                     <img src="<?php echo base_url('assets/pdf/images/logo.png'); ?>" class="img-responsive">
                  </div>
                  <div style="width:20%; float:left;">
                        <div style="height:20px;"></div>
                        <div style="padding:0px 5px; color: #fff; line-height: 40px; background: #16c40e; font-weight: bold; text-align:center;"><?php echo $row['fqa_number'];?></div>
                        
                     </div>
                     </div>
               </div>
            </div>
         </section>
         
         <section class="main-content">
            <div class="container">
               <div class="row">
                  <?php
                  if($type == 'dealer'){
                     echo "<div class=\"btn-green2\" style=\"background: #16c40e; font-weight: bold; color: #fff; text-align: center; margin: 20px 0px 10px; padding: 10px;\">Dealer Purchase Order ". $row['fqa_number']."</div>";
                  }
                  else{
                     
                     echo "<div class=\"btn-green2\" style=\"background: #16c40e; font-weight: bold; color: #fff; text-align: center; margin: 20px 0px 10px; padding: 10px;\">New Vehicle Order </div>";
                  }
                  ?>
                  <div class="table-responsive">
                     <table class="table grey-head-table" style="border:1px solid #969696;">
                        <thead>
                           <tr>
                              <th style="background-color: #969696; color: #fff; padding:4px;">Supplying Dealer:</th>
                              <th style="background-color: #969696; color: #fff; padding:4px;">Client Details:</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td style="padding:1px; width: 50%; border-right:1px solid #969696;">Dealership: <?php echo $lead['dealership_name'];?> </td>
                              <td style="padding:1px; width: 50%; border-right:1px solid #969696;">Client Name:<?php echo $client['name']." ".$client['surname'];?></td>
                           </tr>
                           <?php
                           
                           $tender_dealers = $this->request_model->get_tender_dealers($lead['id_quote_request']);
                           $tender_dealer = $tender_dealers[0];
                           $dealerNm = '';
                           if(isset($tender_dealer['is_primary_contact']) && $tender_dealer['is_primary_contact'] == '1'){
                              $dealerNm = $tender_dealer['name'];
                           }
                           $getContactDetail = $this->db->query("select dealership_contacts from dealer_attributes where fk_user = ".$tender_dealer['user_id'])->row_array();

                           if($getContactDetail['dealership_contacts'] !=''){
                              $dealer_contacts = str_replace('\\', '',$getContactDetail['dealership_contacts']);
                              
                              $dealer_contacts_arr = json_decode($dealer_contacts,true);
                              
                              foreach ($dealer_contacts_arr as $dealerRow) {
                                    if($dealerRow['contact_email'] && $dealerRow['contact_email'] !=''){
                                       $tenderInviteDealer[].=	$dealerRow['contact_email'];
                                    }
                                    if($dealerRow['contact_is_primary'] == 1){
                                       $dealerNm = 	$dealerRow['contact_fullname'];
                                    }
                              
                              }

                           }

                           if($dealerNm == ''){
                              $dealerNm = $tender_dealer['name'];
                           }

                           ?>
                           <tr>
                              <td style="padding:1px; width: 50%; border-right:1px solid #969696;">Dealer Contact: <?php echo  $dealerNm;?></td>
                              <td style="padding:1px; width: 50%; border-right:1px solid #969696;">DL No. : <?php echo $client['dl_no'];?></td>
                           </tr>
                           <tr>
                              <td style="padding:1px; width: 50%; border-right:1px solid #969696;">Email: <?php echo $lead['dealer_email'];?></td>
                              <td style="padding:1px; width: 50%; border-right:1px solid #969696;">Email: <?php echo $client['email'];?></td>
                           </tr>
                           <tr>
                              <td style="padding:1px; width: 50%; border-right:1px solid #969696;">Phone: <?php echo $lead['dealer_phone'];?></td>
                              <td style="padding:1px; width: 50%; border-right:1px solid #969696;">Phone: <?php echo $client['number'];?></td>
                           </tr>
                           <tr>
                              <td style="padding:1px; width: 50%; border-right:1px solid #969696;">Mobile: <?php echo $lead['dealer_mobile'];?></td>
                              <td  style="padding:1px; width: 50%; border-right:1px solid #969696;">Address: <?php echo $client['address'];?> </td>
                           </tr>
                           <tr>
                              <td style="padding:1px; width: 50%; border-right:1px solid #969696;">Address: <?php echo $lead['dealer_address']." , ".$lead['dealer_postcode']." , ".$lead['dealer_state'];?> </td>
                              <td style="padding:1px; width: 50%; border-right:1px solid #969696;">Invoice to :<?php echo $lead['lead_name'];?></td>
                           </tr>
                           
                           <tr>
                              <td style="padding:1px; width: 50%; border-right:1px solid #969696;" class="first">ABN: <?php echo $lead['dealer_abn'];?> Dealer Licence: <?php echo $lead['dealer_license'];?></td>
                              <td style="padding:1px; width: 50%; border-right:1px solid #969696;"></td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
                  <div class="table-responsive">
                     <table class="table grey-head-table three-column" style="border:1px solid #969696;">
                        <thead>
                           <tr>
                              <th style="text-align: center; background-color: #969696; color: #fff; padding:4px;">FinQuote Sales Consultant:</th>
                              <th style="text-align: center; background-color: #969696; color: #fff; padding:4px;">Email:</th>
                              <th style="text-align: center; background-color: #969696; color: #fff; padding:4px;">Telephone:</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td style="text-align: center; padding:4px; width: 33.33%; border-right:1px solid #969696;"><?php echo $lead['qs_name'];?></td>
                              <td style="text-align: center; padding:4px; width: 33.33%; border-right:1px solid #969696;"><?php echo $lead['qs_email'];?></td>
                              <td style="text-align: center; padding:4px; width: 33.33%"><?php echo $lead['qs_mobile'];?></td>
                           </tr>
                          
                        </tbody>
                     </table>
                  </div>
                  <div class="table-responsive">
                     <table class="table grey-head-table" style="border:1px solid #969696;  font-size:12px;">
                        <thead>
                           <tr>
                              <th style="background-color: #969696; color: #fff; padding:4px;">New Vehicle Details</th>
                              <th style="background-color: #969696; color: #fff; padding:4px;"></th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td style=" background-color: #ccc; color: #000; padding: 4px; border-right:1px solid #969696;"><b>Item</b></td>
                              <td style=" background-color: #ccc; color: #000; padding: 4px;"></td>
                           </tr>
                           <?php
                              foreach ($rb_data_row['des'] as $rb) {
                                 $desc .= $rb;
                              }
                           
                           ?>
                           <tr style="border-top: 1px solid #969696">
                              <td style=" padding:1px; border-right:1px solid #969696;" ><?php echo "<p>".$rb_data_row['name']."</p><p>".$desc."</p>";?></td>
                              <td rowspan="3" style="width: 33.33%; padding:1px; border-right:1px solid #969696;" class="text-center">
                              <?php 
                                 //$price =  preg_replace("/[^0-9]/", '', $rb_data_row['price']);
                                 if($type == 'client'){
                                       if($computation_data['trade_include'] == '1'){
                                          if($computation_data['include_dealer'] == 'no'){
                                          
                                             $price =  preg_replace("/[^0-9]/", '', ($client['sale_price']-$computation_data['tradein_valuaton']));
                                             echo  '$'.number_format($price, 2, '.', ',');  
                                       }
                                    }
                                    else{
                                             $price =  preg_replace("/[^0-9]/", '', ($client['sale_price']));
                                             echo  '$'.number_format($price, 2, '.', ',');
                                    }
                                 } 
                                 else{
                                    if($computation_data['include_dealer'] == 'yes'){

                                       $price =  preg_replace("/[^0-9]/", '', ($client['sale_price']));
                                       echo  '$'.number_format($price, 2, '.', ',');
                                    }
                                    else{
                                       $price =  preg_replace("/[^0-9]/", '', ($client['sale_price']-$client['deposite_amt']));
                                       echo  '$'.number_format($price, 2, '.', ',');  
                                    }
                                 }
                              ?>
                              </td>
                           </tr>
                           <tr>
                              <td style="padding:1px; border-right:1px solid #969696;">Colour: <?php echo $rb_data_row['colour'];?> </td>
                              
                           </tr>
                           <?php
                           $accessories = '';
                           if(isset($lead['id_quote_request']) && !empty($lead['id_quote_request'])){
                              $accessories_arr = array();
                              $accessories_data = $this->request_model->get_accessories($lead['id_quote_request']);
                              foreach($accessories_data as $key => $accessory){
                                 $accessories_arr[$key] = $accessory->name;
                              }
                              if(!empty($accessories_arr)){
                                 $accessories = implode(', ', $accessories_arr);
                              }			
                           }else{
                              $accessories = '';
                           }
                           ?>
                           <tr>
                              <td style="padding:1px; border-right:1px solid #969696;">Options: <?php echo $accessories; ?>
                              </td>
                           </tr>
                           <?php
                           $deposite = 0;
                           //print_r($computation_data);
                           //exit;
                           

                              if($computation_data['trade_include'] == '1'){
                                 if($computation_data['trade_valuation_sel'] == '1'){


                                 ?>
                                 <tr>
                                    <td style="padding:4px; border-right:1px solid #969696; border-top: 1px solid #969696;">Include Trade Deposit - </td>
                                    
                                    <td style="padding:4px; width: 33.33%; border-right:1px solid #969696; border-top: 1px solid #969696; text-align: center;" ><?php echo  '$'.number_format($computation_data['tradein_valuaton'], 2, '.', ','); 
                                       $t_value = $computation_data['tradein_valuaton'];
                                    ?></td>
                                 </tr>

                              <?php
                              }
                           }else{
                              $t_value = 0;
                           }
                           

                           if($type == 'client'){
                              ?>
                              <tr>
                                 <td style="padding:4px; border-right:1px solid #969696; border-top: 1px solid #969696;">New Vehicle Security - <?php echo $client['c_card_type'];?></td>
                                 <td style="padding:4px; width: 33.33%; border-right:1px solid #969696; border-top: 1px solid #969696; text-align: center;" ><?php $deposite = $client['deposite_amt']; if($deposite != ''){echo  '$'.number_format($deposite, 2, '.', ',');}?></td>
                              </tr>
                           <?php
                           }

                           if($type == 'dealer'){
                              if($computation_data['include_dealer'] == 'yes')
                              {
                                 ?>
                              <!-- <tr>
                                 <td style="padding:4px; width: 50%; border-right:1px solid #969696; border-top: 1px solid #969696;">New Vehicle Security - <?php echo $client['c_card_type'];?></td>
                                 <td style="padding:4px; width: 50%; border-right:1px solid #969696; border-top: 1px solid #969696; text-align: center;" ><?php $deposite = $client['deposite_amt']; if($deposite != ''){echo  '$'.number_format($deposite, 2, '.', ',');}?></td>
                              </tr> -->

                              <tr>
                                 <td style="padding:4px; border-right:1px solid #969696; border-top: 1px solid #969696;">New Vehicle Security - <?php echo $client['c_card_type'];?></td>
                                 <td style="padding:4px; width: 33.33%; border-right:1px solid #969696; border-top: 1px solid #969696; text-align: center;" ><?php $deposite = $client['deposite_amt']; if($deposite != ''){echo  '$'.number_format($deposite, 2, '.', ',');}?></td>
                              </tr>
                              <?php
                              }
                           }
                           ?>
                        </tbody>
                     </table>
                  </div>
                  <div class="table-responsive">
                     <table class="table grey-head-table right-table" style="  width: 100%; margin-left: auto;">
                      
                        <tbody>
                           <tr>
                              <td style="width: 33.33%; border: none;"></td>
                              <td style=" padding:8px; border:1px solid #969696; font-weight: bold;">Balance Payable (AUD)</td>
                              <td style="width: 33.33%; border:1px solid #969696; border-left:none;  padding:8px; text-align: center;"><?php echo  '$'.number_format(($price - $deposite - $t_value), 2, '.', ',');?></td>
                           </tr>
                          
                        </tbody>
                     </table>
                  </div>
                  <div class="clearfix">
                     <div class="col-md-6 col-md-offset-6">
                           <div class="row">
                              <div class="text-right">

                                 <?php
                                 if($computation_data['trade_include'] == '1'){
                                    if($computation_data['trade_payout']== 'N/A'){
                                       echo "<p>No trade payout has been allowed for in this order, any variation in payout with adjust balance payable.</p>";
                                    }
                                    else{
                                       echo "<p>A payout of $".$computation_data['trade_payout']." has been allowed for in balance payable, any variation in payout will adjust balance payable</p>";
                                    }
                                 }
                                 ?>
                                 
                                 <p><?php 
                                 if($lead['on_road']){
                                   echo "<i>*GST, stamp duty and all on road costs are included in the Balance<br> Payable. On road charges are calculated based on the state and<br> territory government where the vehicle is to be registered</i>"; 
                                 }
                                 else{
                                    echo "<i>*All GST, LCT (where applicable), dealer fees and charges are included in the Balance Payable.<br/> Interstate dealer supplied vehicles exclude state government charges. <br/>Client is responsible for state government charges within state and territory of registration.</i>";   
                                 }
                                 ?></p>
                              </div>
                           </div>
                     </div>
                 </div>
                  <div class="table-responsive">
                     <table class="table grey-head-table" style="border:1px solid #969696;">
                        <thead>
                           <tr>
                              <th style="background-color: #969696; color: #fff; padding:4px;">Delivery Date: </th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td style="padding:4px;">
                              <?php 
                               $delivery_date = date_create($client['delivery_date']);
                               $delivery_date = date_format($delivery_date,'d-m-Y');
                               echo $delivery_date;?></td>
                           </tr>
                        </tbody>
                        <thead>
                           <tr>
                              <th style="background-color: #969696; color: #fff; padding:4px;">Registration Type:</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td style="padding:4px;"><?php echo $rb_data_row['registration_type'];?></td>
                           </tr>
                        </tbody>
                        <thead>
                           <tr>
                              <th style="background-color: #969696; color: #fff; padding:4px;">Delivery Instructions:</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td style="padding:4px;">
                                 <?php 
                                    if($computation_data['delivery_instructions'] == 'client_address'){
                                       echo "Dealer delivering to client's address  - ".$computation_data['lead_address_comp'] ;
                                    }else if($computation_data['delivery_instructions'] == 'client_dealer'){
                                       echo "Client to take delivery at the dealership";
                                    }else if($computation_data['delivery_instructions'] == 'transport'){
                                       echo "Finquote organising Transport";
                                    }else if($computation_data['delivery_instructions'] == 'dealer_transport'){
                                       echo "Dealer organising car carrier transportation";
                                    }
                                 ?>
                              </td>
                           </tr>
                        </tbody>
                        
                        <thead>
                           
                           <tr>
                              <th style="background-color: #969696; color: #fff; padding:4px;">Special Conditions</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td style="padding:4px;">
                                 <?php echo $lead['special_conditions']."&nbsp;"; ?>
                              </td>
                           </tr>
                        </tbody>


                        <thead>

                           <tr>
                              <th style="background-color: #969696; color: #fff; padding:4px;">Method of Payment </th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td style="padding:4px;">
                              <?php 
                              if($computation_data['method_of_purchase'] == 'no_finance')
                              {
                                 echo "No finance required, client purchasing outright";
                              }else if($computation_data['method_of_purchase'] == 'own_finance')
                              {
                                 echo "Client has organised their own finance";
                              }else if($computation_data['method_of_purchase'] == 'finquote')
                              {
                                 echo "Finquote organising finance on the client's behalf";
                              }else if($computation_data['method_of_purchase'] == 'dealer')
                              {
                                 echo "Dealer organising finance on the client's behalf";
                              }
                              ?>
                              </td>
                           </tr>
                        </tbody>
                        <thead>
                           <tr>
                              <th style="background-color: #969696; color: #fff; padding:4px;">Balance Payable</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td style="padding:4px;">
                                 <?php if($deposite != ''){
                                    echo "FinQuote has successfully processed a transaction of ".'$'.number_format($deposite, 2, '.', ',')."from the above client. FinQuote will forward funds to the dealer upon receipt of the vehicle tax invoice no less than 48 hours prior delivery less any FinQuote fees. Balance Payable is to be made to the supplying dealer on or prior to the day of delivery.";
                                 }
                                 else{
                                    echo "Finquote has successfully processed a vehicle security payment from the above client. Balance payable will be made directly with your dealer using the account details provided on the tax invoice. Client has been advised cleared funds must be received by the suppling dealer before release of new car. ";
                                 }?>
                                 </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
                  
                  <div style="page-break-after: always;"></div>
               
                  <?php
                 
                  if($computation_data['trade_include']== 1){
                     ?>
                     <div class="new-section" >
                        <div style="display: flex; align-items: center; justify-content: center;">
                        <div style="width:80%; float:left;">
                           <img src="<?php echo base_url('assets/pdf/images/logo.png'); ?>" class="img-responsive">
                        </div>
                        <div style="width:20%; float:left;">
                              <div style="height:20px;"></div>
                              <div style="padding:0px 5px; color: #fff; line-height: 40px; background: #16c40e; font-weight: bold; text-align:center;"><?php echo $row['fqa_number'];?></div>
                              
                           </div>
                           </div>
                           <div class="btn-green2" style="background: #16c40e; font-weight: bold; color: #fff; text-align: center; margin: 20px 0px 10px; padding: 10px; font-size:16px;">Trade Details </div>
                           <div class="table-responsive">
                              <table class="table grey-head-table" style="border:1px solid #969696">
                                 
                                 <tbody>
                                    <tr>
                                       <td width="30%;" style=" padding:1px 2px; border:1px solid #969696;">Make </td>
                                       <td width="70%;" style=" padding:1px 2px; border:1px solid #969696;">
                                       <?php
                                       $this->db->select('name');
                                       $this->db->from('makes');
                                       $this->db->where('id_make', $tradeins->make );
                                       $make = $this->db->get()->result();
                                       
                                       echo $make[0]->name;?> </td>
                                    </tr>
                                    <tr>
                                       <td style="padding:1px 2px; border:1px solid #969696;">Model</td>
                                       <td style="padding:1px 2px; border:1px solid #969696;">
                                       <?php
                                       $this->db->select('name');
                                       $this->db->from('families');
                                       $this->db->where('id_family', $tradeins->family );
                                       $family = $this->db->get()->result();
                                       
                                       echo $family[0]->name;?>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td style="padding:1px 2px; border:1px solid #969696;" class="first">Registration Plate</td>
                                       <td style="padding:1px 2px; border:1px solid #969696;"><?php echo $tradeins->registration_plat;?></td>
                                    </tr>

                                    <?php
                                       $this->db->select('*');
                                       $this->db->from('rb_data');
                                       $this->db->where('car_id', $tradeins->rb_data );
                                       $rb_data = $this->db->get()->row_array();
                                     ?> 
                                   
                                    <tr>
                                       <td style="padding:1px 2px; border:1px solid #969696;">Redbook Data</td>
                                       <td style="padding:1px 2px; border:1px solid #969696;">
                                       <?php 
                                       $desc = unserialize($rb_data['des']);
                                     
                                       echo $rb_data['name']." - ".implode(', ', $desc)." - ".$rb_data['price'];?>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td style="padding:1px 2px; border:1px solid #969696;">Kilometres</td>
                                       <td  style="padding:1px 2px; border:1px solid #969696;"><?php echo $tradeins->kilometers;?> </td>
                                    </tr>
                                    <tr>
                                       <td style="padding:1px 2px; border:1px solid #969696;">Colour</td>
                                       <td style="padding:1px 2px; border:1px solid #969696;"><?php echo $tradeins->colour;?> </td>
                                    </tr>
                                    <tr>
                                       <td style="padding:1px 2px; border:1px solid #969696;" class="first">Service History  </td>
                                       <td style="padding:1px 2px; border:1px solid #969696;">
                                          <?php 
                                          if($tradeins->service_history == '1'){
                                             echo "Service records & books available and servicing complete";
                                          }
                                          elseif($tradeins->service_history == '2'){
                                             echo "Service records and books available but some servicing incomplete";
                                          }
                                          elseif($tradeins->service_history == '3'){
                                             echo "Missing books and unknown service";
                                          }
                                          ?>  
                                       </td>
                                    </tr>
                                    
                                    <tr>
                                       <td style="padding:1px 2px; border:1px solid #969696;" class="first">Rego Expiry </td>
                                       <td style="padding:1px 2px; border:1px solid #969696;"><?php echo $tradeins->rego_expiry;?> </td>
                                    </tr>
                                    <tr>
                                       <td style="padding:1px 2px; border:1px solid #969696;" class="first">Tyres </td>
                                       <td style="padding:1px 2px; border:1px solid #969696;">
                                       <?php 
                                          if($tradeins->tyres == '1'){
                                             echo "New or near new";
                                          }
                                          elseif($tradeins->tyres == '2'){
                                             echo "Not new but I believe them to be in roadworthy condition";
                                          }
                                          elseif($tradeins->tyres == '3'){
                                             echo "Some or all may need replacing";
                                          }
                                          ?>  
                                       </td>
                                    </tr>
                                    <tr>
                                       <td style="padding:1px 2px; border:1px solid #969696;" class="first">Dash Warning lights </td>
                                       <td style="padding:1px 2px; border:1px solid #969696;">
                                       <?php 
                                          if($tradeins->dash_warning_lights == '1'){
                                             echo "No dash warning lights illuminated";
                                          }
                                          elseif($tradeins->dash_warning_lights == '2'){
                                             echo "Dash warning lights illuminated";
                                          }
                                         
                                          ?>  
                                       </td>
                                    </tr>
                                    <tr>
                                       <td style="padding:1px 2px; border:1px solid #969696;" class="first">Windscreen</td>
                                       <td style="padding:1px 2px; border:1px solid #969696;">
                                       <?php
                                       if($tradeins->windscreen == '1'){
                                          echo "Windscreen has no cracks or chips";
                                       }
                                       elseif($tradeins->paint_work == '2'){
                                          echo "Windscreen has cracks or chips";
                                       }
                                       ?>
                                      
                                       </td>
                                    </tr>
                                    <tr>
                                       <td style="padding:1px 2px; border:1px solid #969696;" class="first">Spare Keys </td>
                                       <td style="padding:1px 2px; border:1px solid #969696;">
                                       <?php 
                                          if($tradeins->spare_keys == '1'){
                                             echo "2 sets of keys available";
                                          }
                                          elseif($tradeins->spare_keys == '2'){
                                             echo "1 sets of keys available";
                                          }
                                         
                                          ?>  
                                        </td>
                                    </tr>
                                    <tr>
                                       <td style="padding:1px 2px; border:1px solid #969696;" class="first">Paint Work</td>
                                       <td style="padding:1px 2px; border:1px solid #969696;">
                                       <?php 
                                          if($tradeins->paint_work == '1'){
                                             echo "Perfect";
                                          }
                                          elseif($tradeins->paint_work == '2'){
                                             echo "Minor Scratches";
                                          }
                                          elseif($tradeins->paint_work == '3'){
                                             echo "Moderate scratches, chips, dents";
                                          }
                                          elseif($tradeins->paint_work == '4'){
                                             echo "Damage, dents, paint blemishes, rust or poor previous repair";
                                          }
                                          ?>  
                                          </td>
                                    </tr>
                                   
                                    <tr>
                                       <td style="padding:1px 2px; border:1px solid #969696;" class="first">Has your vehicle been a rental or taxi </td>
                                       <td style="padding:1px 2px; border:1px solid #969696;">
                                       <?php 
                                          if($tradeins->rental_or_taxi == '1'){
                                             echo "Yes";
                                          }
                                          elseif($tradeins->rental_or_taxi == '2'){
                                             echo "No";
                                          }
                                         
                                          ?>  
                                        </td>
                                        </td>
                                    </tr>
                                    <tr>
                                       <td style="padding:1px 2px; border:1px solid #969696;" class="first">Did you buy the car new </td>
                                       <td style="padding:1px 2px; border:1px solid #969696;">
                                       <?php 
                                          if($tradeins->buy_new_car == '1'){
                                             echo "Yes";
                                          }
                                          elseif($tradeins->buy_new_car == '2'){
                                             echo "No";
                                          }
                                         
                                          ?>  
                                        </td>
                                        </td>
                                    </tr>
                                    <tr>
                                       <td style="padding:1px 2px; border:1px solid #969696;" class="first">Do all Options & Accessories work</td>
                                       <td style="padding:1px 2px; border:1px solid #969696;">
                                       <?php 
                                          if($tradeins->all_accessories_work == '1'){
                                             echo "Yes";
                                          }
                                          elseif($tradeins->all_accessories_work == '2'){
                                             echo "No";
                                          }
                                         
                                          ?>  
                                        </td>
                                        </td>
                                    </tr>
                                    <tr>
                                       <td style="padding:1px 2px; border:1px solid #969696;" class="first">Has your vehicle been any accidents</td>
                                       <td style="padding:1px 2px; border:1px solid #969696;">
                                       <?php 
                                          if($tradeins->accidents == '1'){
                                             echo "Yes";
                                          }
                                          elseif($tradeins->accidents == '2'){
                                             echo "No";
                                          }
                                         
                                          ?>  
                                        </td>
                                        </td>
                                    </tr>
                                    <tr>
                                       <td style="padding:1px 2px; border:1px solid #969696;" class="first">Has the vehicle ever had any paint work</td>
                                       <td style="padding:1px 2px; border:1px solid #969696;">
                                       <?php 
                                          if($tradeins->any_paint_work == '1'){
                                             echo "Yes";
                                          }
                                          elseif($tradeins->any_paint_work == '2'){
                                             echo "No";
                                          }
                                         
                                          ?>  
                                        </td>
                                        </td>
                                    </tr>
                                    <tr>
                                       <td style="padding:1px 2px; border:1px solid #969696;" class="first">Estimated payout if finance encumbered</td>
                                       <td style="padding:1px 2px; border:1px solid #969696;"><?php echo $tradeins->estimated_payout;?></td>
                                    </tr>
                                    <tr>
                                       <td style="padding:1px 2px; border:1px solid #969696;" class="first">Please list any options & Accessories</td>
                                       <td style="padding:1px 2px; border:1px solid #969696;"><?php echo $tradeins->additional_notes;?> </td>
                                    </tr>
                                    <tr>
                                       <td style="padding:1px 2px; border:1px solid #969696;" class="first">Please Describe Any Damage or Mechanical Issues</td>
                                       <td style="padding:1px 2px; border:1px solid #969696;"><?php echo $tradeins->damage_or_mechanical_issue;?></td>
                                    </tr>

                                 </tbody>
                              </table>
                           </div>
                           <div style="clear:both;">

                           <?php
                            
                                 $images_arr = explode(', ', $tradeins->images);
                                 $images_arr = array_slice($images_arr, 0, 4);
                              ?>
                              <div style="width:60%; margin: 0 auto 20px;">
                               <?php
                               if(isset($images_arr[0]) && $images_arr[0] !=''){
                                  ?>
                                   <div style="width:49%; float:left; text-align:center;">
                                    <img src="<?=base_url('uploads/tradein_cars/'.$images_arr[0]);?>" height="150" width="150" >
                                  </div>
                                  <?php
                               }
                               if(isset($images_arr[1]) && $images_arr[1] !=''){
                                 ?>
                                 
                              <div style="width:49%; float:left; text-align:center;">
                                    <img src="<?=base_url('uploads/tradein_cars/'.$images_arr[1]);?>" height="150" width="150" >
                              </div>
                                 <?php
                              }
                              ?>
                               
                              </div>

                              <div style="width:60%; margin: 0 auto 20px;">
                              <?php
                              if(isset($images_arr[2]) && $images_arr[2] !=''){
                                 ?>
                                 
                              <div style="width:49%; float:left; text-align:center;">
                                 <img src="<?=base_url('uploads/tradein_cars/'.$images_arr[2]);?>" height="150" width="150" >
                              </div>
                           
                                 <?php
                              }
                              if(isset($images_arr[3]) && $images_arr[3] !=''){
                                 ?>
                                 
                          
                              <div style="width:49%; float:left; text-align:center;">
                                 <img src="<?=base_url('uploads/tradein_cars/'.$images_arr[3]);?>" height="150" width="150" >
                              </div>
                                 <?php
                              }
                              ?>
                       
                             
                           </div>
                          

                           </div>
                           <br>
                     </div>
                     <div style="page-break-after: always;"></div>
                     <?php
                  }
                  ?>
                  <h4 style="font-weight: bold;">Terms & Conditions</h4>

                  <div style="font-size:11px;">
                  <p>Unless otherwise stated, Finquote, the dealer and the client agree to the following. A telephone order forms a legally binding verbal contract. The following conditions apply. </p>
                  <p>
                     Before taking delivery of the motor vehicle, the customer shall pay to the dealer the balance payable shown on this order. This must be paid by direct deposit, bank cheque, credit card or financed funds. Cleared funds for the vehicle (less any Finquote fees) must be with the dealer prior or on the day of delivery. If paying for the motor vehicle by personal cheque, the personal cheque must be presented to the dealer five days before the date of delivery.</p>
                     
                     <p>
                     If the motor vehicle is being financed settled funds must be paid to the supplying dealer from the finance company. If the amount shown on this new vehicle order is financed any funds paid over and above the amount shown on this order will be refunded to the customer within 10 business days upon all fees and invoices between parties of this agreement being paid and cleared. </p>
                     
                     <p>
                     Until the dealer has received payment for the vehicle, title in the motor vehicle shall not pass to the customer and the customer shall hold possession of it as bailee only. While the customer holds possession of the motor vehicle as bailee, he /she: </p>
                     
                     <p>
                     Is responsible for its proper care and maintenance, is liable for any loss or damage occasioned to it and will indemnify the dealer against any claim for its use.</p>
                     
                     <p>
                     Where the dealer is entitled to reclaim possession of the motor vehicle, the customer authorises the dealer, its servants and its agents to lawfully enter the customer’s property for the purposes of retaking possession.</p>
                     
                     <p>
                     The amount shown and balance payable on this New Vehicle Order includes any taxes, statutory charges unless otherwise stated.</p>
                     
                     <p>
                     The balance payable may vary if, before the delivery of the motor vehicle, there is a change in the manufacturer’s recommended retail price, statutory charges or applicable taxes or duties.  The dealer shall give Finquote and/or the customer written notice of any variation. If the balance payable is varied due to an increase of recommended retail, the customer may rescind this contract anytime within three (3) days after receipt of the written notice of variation. </p>
                     
                     <p>
                     The dealer shall use its best endeavours to acquire the vehicle by the estimated delivery date but should not be liable for any damage or loss whatsoever arising either directly or indirectly from any such delay or failure of delivery.
                     The Customer shall take delivery of the motor vehicle within (7) days of the Dealer notifying the Customer that the motor vehicle is available for delivery.</p>
                     
                     <p>
                     If Dealer has not delivered the motor vehicle to the Customer within thirty (30) days of the estimated delivery date, the Customer may by notice in writing to the Dealer rescind this Contract.</p>
                     
                     <p>
                     At or before taking delivery of the motor vehicle the Customer shall pay to the Dealer the “Balance Payable"</p>
                     
                     <p>
                     If the customer wishes to trade in a vehicle, Finquote will organise provisionally a value for the trade in vehicle based on the customer’s description of it.Valuations will be valid for the time stated in the trade documents in this order, after which the trade in vehicle may need to be re-valued.As the customer is permitted to use the vehicle between initial valuation and delivery of new car, the customer is responsible for the following whilst the trade-in is in their possession; proper care and maintenance (including but not exclusive to the following: servicing, tyres, and mechanical repairs), registration renewals, loss or damage to the vehicle, insurance claims, and depreciation. Any kilometres travelled above the odometer cap provided with this order will be charged at 35c/kilometre, further depreciation may also be charged beyond the valid valuation period. </p>
                     
                     <p>
                     Before taking delivery of the motor vehicle, the Customer shall deliver to the Dealer the trade-in vehicle together with all accessories, extras and attachments fitted at the time of valuation. If the trade-in vehicle is not in substantially the same condition as when valued by the Dealer or wholesale agent organised by Finquote, the parties may negotiate a variation in the net trade-in allowance or either party may rescind the trade-in inclusion upon which a revised new vehicle order will be raised.</p>
                     
                     <p> 
                     If the Customer is entitled and duly elects to terminate this contract under the Cooling Off Rights the Customer is liable to the dealer for any damage to the motor vehicle while it was in the Customer’s possession, other than fair wear and tear; the Dealer need not return any trade in vehicle if the dealer is unable to return it because of a defect in the trade in vehicle, not caused by the Dealer, that renders the trade in vehicle incapable of being driven or unroadworthy, but the Dealer must permit, and the Customer must arrange for, the collection of the trade in vehicle from the Dealer within 24 hours of exercise of the Cooling Off Right;</p>
                     
                     <p>
                     The Customer shall be deemed not to have paid for the new vehicle until unencumbered title for the trade is passed to the buyer of the trade in. If the customer elects to sell the trade vehicle privately they must inform Finquote prior to transferring ownership of the vehicle. Finquote will revise the New Vehicle Order affecting the balance payable in removing the trade vehicle from the order.</p>
                     
                     <p>
                     Despite the foregoing, the sum to be paid or allowed to the customer for the trade in vehicle will be its actual value (determined by Finquote) at the time of delivery of the trade in vehicle to Finquote or a wholesale agent nominated by Finquote.  
                     </p>
                     
                     <p>Variations in value may be caused by errors in description of vehicles details (including but not limited to the following examples) Build Year, Make, Model, Series, Fuel Type, Transmission, Body Shape, Odometer, External Condition, Interior Condition, Mechanical & Electrical Performance. Please ensure that the description contained within this contract is a true and accurate representation of your vehicle. The customer must pay or allow to Finquote on demand the difference (if any) between the value of the trade in vehicle provisionally determined by Finquote and the actual value of the trade in vehicle when delivered to Finquote or its nominated wholesale agent.  Variations in the actual value up to three thousand (3,000) dollars will be immediately charged to your nominated credit card where possible. </p>
                     
                     <p>
                     Variations that are greater than three thousand (3,000) dollars in value will require an EFT transfer to Finquote, upon request.  
                     </p>
                     
                     <p>If the customer fails to pay the difference to Finquote when demanded, at the discretion of Finquote options include:</p>
                     
                     <ul style="list-style-type: none;">
                        <li>(a)  Finquote may return the trade in vehicle to the customer, without taking title; or</li>
                        <br>
                        <li>(b)  Upon demand by Finquote, the customer must return the newly supplied motor vehicle to Finquote or its nominated wholesale agent, which may sell the newly supplied vehicle and the trade in vehicle and, after payment of all costs incurred (including, without limitation, finance costs, on road costs and other transaction costs) Finquote will arrange for the customer to be paid the net proceeds of sale (if any);</li>
                     </ul>
                     
                     <p>without prejudice to Finquote, Finquote has the right to sue the customer to recover any deficiency or loss suffered or liability, cost or expense incurred by Finquote or to recover damages for breach of contract.</p>
                     
                     <p>
                     If the trade in vehicle provided by the customer proves to have a history as a rental vehicle and/or taxi the vehicle will be not be accepted, the vehicle will subsequently be returned to the client and the full payment for the trade in value is payable by the client to the agent nominated by Finquote.</p>
                     
                     <p>
                     To avoid doubt, any person other than the customer who delivers a vehicle to Finquote or its nominated wholesale agent shall be deemed to act as the agent of the customer.</p>
                     
                     <p>
                     Where the customer refuses or fails to take delivery of the motor vehicle, other than under the cooling off rights, or is otherwise in breach of his obligations under this contract, the dealer or Finquote may terminate this contract by written notice to the customer.; thereafter any funds paid or payable by the customer to an amount not exceeding 5% of the amount shown on this order shall be forfeited. Both parties acknowledge that the dealer shall be entitled to claim by way of pre-estimated liquidated damages from the customer an amount equal to 5% of the total on road cost less any funds paid forfeited. </p>
                     
                     <p>
                     Where this contract is lawfully rescinded, funds paid by the customer shall be refunded and where possible the trade in vehicle returned less the actual costs of repairs and improvements to the trade in vehicle and any payouts made or to be made by the dealer or wholesale agent to clear any encumbrances. Where the dealer or wholesale agent has disposed of the trade in vehicle the customer shall accept an amount which the parties agree is fair and reasonable compensation.</p>
                     
                     <p>
                     Where the Customer requires finance to be provided for payment of the motor vehicle, the Customer shall promptly provide Finquote or the dealer with information necessary to allow a determination of the Customers finance application. Where the Customer advises Finquote or the Dealer before entering into this Contract that he/she requires credit to be provided for the payment of the motor vehicle and having taken reasonable steps has been unable to obtain credit, the Customer may within a reasonable period by notice in writing given to the Dealer rescind the contract.
                     </p>
                     
                     <p>The Dealer and Client acknowledge Finquote as the introducer of the client to the suppling dealership. Anyfunds received/processed by Finquote and required as part payment for the new vehicle are forwarded (less any outstanding associated invoices) to the dealer 48 hours before the delivery date shown. The supplying new car dealer is not responsible for the trade vehicle if there is an alternate wholesale agent nominated. Instead the nominated purchasing agent will pay via eft the valued amount, less any Finquote Fees, to the dealer supplying the new car.</p>
                     
                     <p> 
                     The provisions of any federal or state law apply to this contact. These provisions are deemed to be incorporated into this contract and the customer shall have the full benefit thereof, but only to the extent to which these warranties are applicable to the contract and may not be excluded there from and all other warranties are expressly excluded.
                     </p>
                     </div>
                     <h4 style="font-weight: bold;">Privacy Statement</h4>
                     <div style="font-size:11px;">
                     <p>The Dealer is an organisation bound by the National Privacy Principles under the Privacy Act 1988. A copy of the Principles is available from the Office of the National Privacy Commissioner. The kind of information the dealer holds is that detailed within this contract document or other information necessary to establish the Customer’s identification. The Dealer will use this information to facilitate the delivery of the goods which are the subject of this contract; and to meet the requirements of government authorities and third-party suppliers associated with the supply of the motor vehicle and related goods. Associated services will include the vehicle and the provision of warranty and servicing for the vehicle; insurance and registration of the vehicle; and the provision of information about new products related to vehicle use which becomes available from time to time.</p>
                     
                     <p>
                     You may request access to your personal information held by the Dealer, by contacting the nominated dealer contact.
                     </p>
                     </div>
                     <div class="text-center" style="font-size:11px; font-weight:bold;">
                     <p>Important</p>
                     <p>Please read these conditions carefully. These conditions accompany your phone order. Please contact our offices immediately upon receipt of this paperwork if these conditions are outside your expectations and/or requirements. </p>
                     
                     </div>
               </div>
            </div>
         </section>
       
      </body>
   </html>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('unlogged_main.php');
require_once("./application/libraries/PDFMerger/PDFMerger.php");
require_once("./application/libraries/PDFMerger/fpdf/fpdf.php");
require_once("./application/libraries/PDFMerger/fpdi/fpdi.php");

class Vehicle_order extends Unlogged_main 
{
	function __construct()
	{
	    ob_start();
		parent::__construct();

		$this->data['user_id'] = "0";
	}

	public function index ()
	{
		header ("Location: ".site_url());
		exit ();
	}

	public function walkthrough ()
	{
		$data['title'] = 'El Quoto | Quote Me';
		$data['header'] = 'Vehicle Order';

		$this->load->view('vehicle_order_walkthrough', $data);
	}
	
	public function client_agreement ()
	{		
		$data['title'] = 'El Quoto | Dealer Agreement';
		$data['header'] = 'Home';
		
		$input_arr = $this->input->get();
		$lead_id = isset($input_arr['id']) ? $input_arr['id'] : 0;
		$key = isset($input_arr['key']) ?  $input_arr['key']: "";

		$result = $this->lead_model->get_lead_client_key($lead_id, $key);
		if (count($result) > 0)
		{
			$tradein_query = "
			SELECT
			t.id_tradein, 
			t.tradein_make, t.tradein_model, 
			t.tradein_variant, t.tradein_build_date, t.tradein_kms,
			t.tradein_colour, t.tradein_transmission, 
			t.tradein_body_type, t.tradein_fuel_type, t.tradein_drive_type, t.tradein_compliance_date,
			t.image_1, t.image_2, t.image_3, t.image_4
			FROM tradeins t
			WHERE t.fk_lead = '".$lead_id."'
			ORDER BY t.id_tradein DESC";
			$data['tradeins'] = $this->db->query($tradein_query)->result_array();
			$data['tradein_count'] = count($data['tradeins']);			
			
			if ($result['client_status']==0 OR $result['client_status']==1)
			{
				$this->lead_model->update_lead_client_status($lead_id, 1);

				$data['id'] = $lead_id;
				$data['key'] = $key;
				$data['lead'] = $this->lead_model->get_lead($lead_id);		
				$data['accessories'] = $this->request_model->get_quote_request_accessories($data['lead']['id_quote_request']);
				$data['options'] = $this->request_model->get_quote_request_options($data['lead']['id_quote_request']);		
				$data['user_signature'] = $this->user_model->get_client_signature($lead_id);

				$this->load->view('vehicle_order_client_wizard', $data);
			}
			else if ($result['client_status']==2)
			{
				$data['id'] = $lead_id;
				$data['key'] = $key;
				$data['lead'] = $this->lead_model->get_lead($lead_id);		
				$data['accessories'] = $this->request_model->get_quote_request_accessories($data['lead']['id_quote_request']);
				$data['options'] = $this->request_model->get_quote_request_options($data['lead']['id_quote_request']);		
				$data['user_signature'] = $this->user_model->get_client_signature($lead_id);				
				
				$this->load->view('vehicle_order_client_success', $data);
			}
			
			$audit_trail_arr = array(
				'id' => $lead_id,
				'table_name' => 'leads',
				'action' => 42,
				'description' => ''
			);
			$insert_audit_trail_result = $this->audit_model->insert_audit_trail(0, $audit_trail_arr);
		}
		else
		{
			header ("Location: ".site_url());
			exit ();
		}
	}	
	
	public function confirm_deal ()
	{
		$input_arr = $this->input->post();
		
		$lead_id = isset($input_arr['id']) ? $input_arr['id'] : 0;
		$key = isset($input_arr['key']) ?  $input_arr['key']: "";
		
		$result = $this->lead_model->get_lead_client_key($lead_id, $key);
		
		if (count($result) > 0)
		{
			if (
				($input_arr['name'] == "") OR
				($input_arr['date_of_birth'] == "") OR
				($input_arr['driver_license'] == "") OR
				($input_arr['email'] == "") OR
				($input_arr['mobile'] == "") OR
				($input_arr['phone'] == "") OR			
				($input_arr['address'] == "") OR
				($input_arr['postcode'] == "") OR
				($input_arr['state'] == "")
			)
			{
				echo "fail";
			}
			else
			{
				if (isset($input_arr['id_tradein']) AND $input_arr['id_tradein'] <> "" AND $input_arr['id_tradein'] <> 0)
				{
					if (isset($input_arr['declaration_1']))
					{
						if ($input_arr['declaration_1']==1)
						{
							$input_arr['tradein_purchased_from'] = $input_arr['tradein_purchased_from'];
						}
						else
						{
							$input_arr['tradein_purchased_from'] = "";
						}						
					}
					else
					{
						$input_arr['declaration_1'] = 0;
						$input_arr['tradein_purchased_from'] = "";
					}
					
					if (isset($input_arr['declaration_2']))
					{
						if ($input_arr['declaration_2']==2)
						{
							$input_arr['tradein_encumbered_by'] = $input_arr['tradein_encumbered_by'];
						}
						else
						{
							$input_arr['tradein_encumbered_by'] = "";
						}
					}
					else
					{
						$input_arr['declaration_2'] = 0;
						$input_arr['tradein_encumbered_by'] = "";
					}
	
					if (isset($input_arr['declaration_payg']))
					{
						if ($input_arr['declaration_payg']==1)
						{
							$input_arr['tradein_abn_holder'] = $input_arr['tradein_abn_holder'];
							$input_arr['tradein_not_providing'] = 0;
							$input_arr['tradein_not_providing_abn'] = "";
						}
						else
						{
							$input_arr['tradein_abn_holder'] = "";
									
							if (isset($input_arr['tradein_not_providing']))
							{
								if ($input_arr['tradein_not_providing']==2)
								{
									$input_arr['tradein_not_providing_abn'] = $input_arr['tradein_not_providing_abn'];
								}
								else
								{
									$input_arr['tradein_not_providing_abn'] = "";
								}								
							}
							else
							{
								$input_arr['tradein_not_providing'] = 0;
								$input_arr['tradein_not_providing_abn'] = "";
							}
						}						
					}
					else
					{
						$input_arr['declaration_payg'] = 0;
						$input_arr['tradein_abn_holder'] = "";
						$input_arr['tradein_not_providing'] = 0;
						$input_arr['tradein_not_providing_abn'] = "";						
					}

					$tradein_input_arr = array(
						'id_tradein' => $input_arr['id_tradein'],
						'declaration_1' => $input_arr['declaration_1'],
						'tradein_purchased_from' => $input_arr['tradein_purchased_from'],
						'declaration_2' => $input_arr['declaration_2'],
						'tradein_encumbered_by' => $input_arr['tradein_encumbered_by'],
						'declaration_payg' => $input_arr['declaration_payg'],
						'tradein_abn_holder' => $input_arr['tradein_abn_holder'],
						'tradein_not_providing' => $input_arr['tradein_not_providing'],
						'tradein_not_providing_abn' => $input_arr['tradein_not_providing_abn']
					);					
					$result = $this->tradein_model->update_tradein_declarations($input_arr);
				}

				$lead_field_arr = array (
					'id_lead' => $lead_id,
					'name' => $input_arr['name'],
					'occupation' => $input_arr['occupation'],
					'business_name' => $input_arr['business_name'],
					'abn' => $input_arr['abn'],
					'date_of_birth' => $input_arr['date_of_birth'],
					'driver_license' => $input_arr['driver_license'],
					'email' => $input_arr['email'],
					'mobile' => $input_arr['mobile'],
					'phone' => $input_arr['phone'],
					'address' => $input_arr['address'],
					'postcode' => $input_arr['postcode'],
					'state' => $input_arr['state']			
				);
				$result = $this->lead_model->update_lead_details($lead_field_arr);
				$result = $this->lead_model->update_lead_client_status($lead_id, 2);
				$result = $this->lead_model->update_lead_client_agreed_date($lead_id);

				echo "success";
			}
		}
		else
		{
			echo "fail";
		}

		$lead = $this->lead_model->get_lead($lead_id);
		
		$audit_trail_arr = array(
			'id' => $lead_id,
			'table_name' => 'leads',
			'action' => 43,
			'description' => ''
		);
		$insert_audit_trail_result = $this->audit_model->insert_audit_trail(0, $audit_trail_arr);

		$notification_message ='The client approved the vehicle order <b><a href="#" class="open-lead-details" data-lead_id="'.$lead_id.'">'.$lead['cq_number'].'</a></b>';
		$this->notification_model->add_notification(1, $notification_message);
		$notification_id = $this->db->insert_id();
		$this->notification_model->add_notification_user($notification_id, $lead['qs_id']);		
	}
	
	public function generate_deal_agreement_pdf ($lead_id)
	{
		$lead = $this->lead_model->get_lead($lead_id);
		$lead = $this->calculate_adjusted_quote($lead);
		$lead_calculation_details = $this->calculate_deal_new($lead);
		// $accessories = $this->request_model->get_quote_request_accessories($lead['id_quote_request']);
		// $options = $this->request_model->get_quote_request_options($lead['id_quote_request']);
		// $option_prices = $this->request_model->get_quote_option_prices($lead['id_quote']);
		// $accessory_prices = $this->request_model->get_quote_accessories_prices($lead['id_quote']);
		$deposits = $this->payment_model->get_deposits($lead_id);
		$refunds = $this->payment_model->get_refunds($lead_id);		
		$tradeins = $this->tradein_model->get_tradeins_client($lead_id);
		
		$options_query = "
		SELECT o.name, qo.price
		FROM quote_request_options qro 
		JOIN quote_options qo ON qro.id_quote_request_option = qo.fk_request_option
		JOIN options o ON qro.fk_option = o.id_option
		WHERE qo.fk_quote = '".$lead['id_quote']."' AND qro.deprecated <> 1 ORDER BY qro.id_quote_request_option ASC";
		$options_result = $this->db->query($options_query)->result();

		$accessories_query = "
		SELECT qra.name, qa.price
		FROM quote_request_accessories qra
		JOIN quote_accessories qa ON qra.id_quote_request_accessory = qa.fk_request_accessory
		WHERE qa.fk_quote = '".$lead['id_quote']."' AND qra.deprecated <> 1 ORDER BY qra.id_quote_request_accessory ASC";
		$accessories_result = $this->db->query($accessories_query)->result();
		
		if ($lead['registration_type']=="Business")
		{
			$customer_name = $lead['name'];
			$customer_abn = $lead['abn'];
		}
		else
		{
			$customer_name = $lead['name'];
			$customer_abn = "";
		}
		
		if (1==1) // Text Definitions
		{
			$xy_arr = [
				1 => [
					'customer_name' => [
						'x'    => 27,
						'y'    => 38,
						'text' => $customer_name,
						'size' => 7.5
					],							
					'address' => [
						'x'    => 27,
						'y'    => 42,
						'text' => $lead['address']." ".$lead['state']." ".$lead['postcode'],
						'size' => 7.5
					],
					'abn' => [
						'x'    => 27,
						'y'    => 46.1,
						'text' => $customer_abn,
						'size' => 7.5
					],
					'email' => [
						'x'    => 92,
						'y'    => 46.1,
						'text' => $lead['email'],
						'size' => 7.5
					],
					'mobile' => [
						'x'    => 124,
						'y'    => 50.35,
						'text' => $lead['mobile'],
						'size' => 7.5
					],		
					'date_of_birth' => [
						'x'    => 6.3,
						'y'    => 58,
						'text' => date('d F Y', strtotime($lead['date_of_birth'])),
						'size' => 7.5
					],
					'occupation' => [
						'x'    => 42,
						'y'    => 58,
						'text' => $lead['occupation'],
						'size' => 7.5
					],
					'license_number' => [
						'x'    => 78,
						'y'    => 58,
						'text' => $lead['driver_license'],
						'size' => 7.5
					],
					'make' => [
						'x'    => 6.2,
						'y'    => 69,
						'text' => $lead['tender_make'],
						'size' => 7.5
					],
					'model' => [
						'x'    => 54.1,
						'y'    => 69,
						'text' => $lead['tender_model'],
						'size' => 7.5
					],
					'colour' => [
						'x'    => 125.5,
						'y'    => 69,
						'text' => $lead['colour'],
						'size' => 7.5
					],
					'body_type' => [
						'x'    => 6.2,
						'y'    => 76,
						'text' => $lead['body_type'],
						'size' => 7.5
					],
					'alternative_model_no' => [
						'x'    => 54.1,
						'y'    => 76,
						'text' => '',
						'size' => 7.5
					],
					'odometer' => [
						'x'    => 86.9,
						'y'    => 76,
						'text' => $lead['kms'],
						'size' => 7.5
					],
					'trim' => [
						'x'    => 125.5,
						'y'    => 76,
						'text' => '',
						'size' => 7.5
					],
					'rego_expiry' => [
						'x'    => 179.4,
						'y'    => 76,
						'text' => $lead['registration_expiry'],
						'size' => 7.5
					],
					'stock_number' => [
						'x'    => 6.2,
						'y'    => 82,
						'text' => '',
						'size' => 7.5
					],
					'vin_number' => [
						'x'    => 54.1,
						'y'    => 82,
						'text' => $lead['vin'],
						'size' => 7.5
					],
					'engine_number' => [
						'x'    => 86.8,
						'y'    => 82,
						'text' => $lead['engine'],
						'size' => 7.5
					],
					'prod_date' => [
						'x'    => 125.5,
						'y'    => 82,
						'text' => $lead['build_date'],
						'size' => 7.5
					],
					'comp_date' => [
						'x'    => 153.9,
						'y'    => 82,
						'text' => $lead['compliance_date'],
						'size' => 7.5
					],
					'fact_order_no' => [
						'x'    => 181,
						'y'    => 82,
						'text' => '',
						'size' => 7.5
					],
					'customer_number' => [
						'x'    => -38,
						'y'    => 38,
						'text' => $lead['cq_number'],
						'size' => 7.5
					],
					'deal_number' => [
						'x'    => -38,
						'y'    => 42.5,
						'text' => $lead['cq_number'],
						'size' => 7.5
					],
					'deal_date' => [
						'x'    => -38,
						'y'    => 47,
						'text' => date('d F Y', strtotime($lead['order_date'])),
						'size' => 7.5
					],
					'order_number' => [
						'x'    => -38,
						'y'    => 51.5,
						'text' => $lead['cq_number'],
						'size' => 7.5
					],
					'price_level' => [
						'x'    => -38,
						'y'    => 56,
						'text' => '',
						'size' => 7.5
					],
					'sales_person' => [
						'x'    => -38,
						'y'    => 60.5,
						'text' => $lead['qs_name'],
						'size' => 7.5
					],
					'delivery_date' => [
						'x'    => 9,
						'y'    => -56,
						'text' => date('d F Y', strtotime($lead['delivery_date'])),
						'size' => 7.5
					],
					'special_conditions' => [
						'x'    => 47,
						'y'    => -56,
						'text' => $lead['special_conditions'],
						'size' => 7.5
					],
					'date_purchaser_signed' => [
						'x'    => 12,
						'y'    => -16,
						'text' => date('d F Y', strtotime($lead['client_agreed_date'])),
						'size' => 7.5
					],
					'witness_name' => [
							'x'    => 76.5,
							'y'    => -16,
							'text' => '',
							'size' => 7.5
						],
					'date_employee_signed' => [
						'x'    => 143,
						'y'    => -16,
						'text' => '',
						'size' => 7.5
					],
				],
				3 =>[
					'customer_signature_date' => [
						'x'    => -48.7,
						'y'    => -23.5,
						'text' => date('d     m    Y', strtotime($lead['client_agreed_date'])),
						'size' => 7.5
					],
				]
			];
		}

		if (1==1) // Signature Definitions
		{
			$sig_coords = [
				1 => [
					'puchaser_signature' => [
						'x'     => 11,
						'y'     => 264,
						'reso'  => -400,
						'image' => base_url("uploads/signatures/client/".$lead['client_signature_url'])
					]
				],
				2 => [
					'tradein_signature' => [
						'x'     => 54,
						'y'     => 265,
						'reso'  => -400,
						'image' => base_url("uploads/signatures/client/".$lead['client_signature_url'])
					]
				],
				3 => [
					'customer_signature_1' => [
						'x'     => 35,
						'y'     => 279,
						'reso'  => -400,
						'image' => base_url("uploads/signatures/client/".$lead['client_signature_url'])
					],
					'customer_signature_2' => [
						'x'     => 107,
						'y'     => 267,
						'reso'  => -400,
						'image' => base_url("uploads/signatures/client/".$lead['client_signature_url'])
					]							
				]
			];
		}

		$pdf = new FPDI();
		$directory = './assets/pdf_templates/';

		$pdf->setSourceFile($directory.'template_vehicle_order.pdf');
		$pdf->AddPage();
		$tplIdx = $pdf->importPage(1);
		$pdf->useTemplate($tplIdx, 0, 0, 0);
		$pdf->SetFont('Times');
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetMargins(0,0,0);
		$pdf->SetAutoPageBreak('auto',0);
		if (isset($xy_arr[1]))
		{
			foreach ($xy_arr[1] as $x_key => $x_val) 
			{
				$pdf->SetFont('Times', 'B');
				$pdf->SetFontSize($xy_arr[1][$x_key]['size']);
				$pdf->SetXY($xy_arr[1][$x_key]['x'], $xy_arr[1][$x_key]['y']);
				$pdf->Write(0, $xy_arr[1][$x_key]['text']);
			}

			$pdf->SetFontSize(7);

			$pdf->SetXY(82, 227.5);
			$pdf->Cell(20, .5, '$ '.number_format($lead['sales_price'], 2), 0, 0, 'R');					

			$pdf->SetXY(8, 100);
			$pdf->SetFont('Helvetica', 'B');
			$pdf->Write(0, 'Vehicle Price');
			
			$pdf->SetXY(82, 100);
			$pdf->Cell(20, .5, number_format($lead['retail_price'], 2), 0, 0, 'R');	
	
			$pdf->SetXY(8, 221);
			$pdf->SetFont('Helvetica', 'B');
			$pdf->Write(0, 'GST');
			
			if ($lead_calculation_details['gst']>0)
			{
				$lead_calculation_details['gst'] = number_format($lead_calculation_details['gst'], 2);
			}
			else
			{
				$lead_calculation_details['gst'] = "Included";
			}			
			$pdf->SetXY(82, 221);
			$pdf->SetFont('Helvetica');
			$pdf->Cell(20, .5, $lead_calculation_details['gst'], 0, 0, 'R');			

			$initial_y = 107;
			$initial_x = 10;
			
			$character_limit = 40;
			$character_limit = 40;
			if (count($options_result)>0)
			{
				$pdf->SetXY(8, 106);
				$pdf->SetFont('Helvetica', 'B');
				$pdf->Write(0, 'Factory-Fitted Options');	

				$initial_y = $initial_y + 2;				
				
				foreach ($options_result as $option_key => $option_val) 
				{
					$pdf->SetXY(82, ($option_key != 0) ? $initial_y + 2.5 : $initial_y + 2);
					$pdf->SetFont('Helvetica');
					$pdf->Cell(20, .5, $option_val->price, 0, 0, 'R');

					$pdf->SetXY($initial_x, $initial_y);

					$string_count = strlen($option_val->name);

					if(strlen($option_val->name) > $character_limit)
					{
						$temp_string_array = [];

						$string_arr = str_split($option_val->name);
						$temp_string = "";
						$final_string = "";
						$counter = 1;
						foreach ($string_arr as $string_key => $string_val) 
						{
							$temp_string .= $string_val;
							if( ($counter >= $character_limit && $string_val == " ")  || $counter== $string_count )
							{
								$final_string = $temp_string;
								$temp_string = "";
								$counter = 1;
								$initial_y = $initial_y + 3;
								$pdf->SetXY($initial_x , $initial_y);
								$pdf->SetFont('Helvetica', 'I');
								$pdf->Write(0, $final_string);
								$temp_string_array[] = $final_string;
							}
							$counter++;
						}

						if( $counter > 2 )
						{
							if( strlen($temp_string_array[count($temp_string_array) - 1]) > $character_limit )
							{
								$pdf->SetXY($initial_x , $initial_y + 3);
								$initial_y = $initial_y + 2;
							}
						}
							
						$pdf->Write(0, " ".$temp_string);
					}
					else
					{
						$pdf->SetXY($initial_x, $initial_y + 2);
						$pdf->SetFont('Helvetica', 'I');
						$pdf->Write(0, $option_val->name);

						$initial_y = $initial_y + 2;
					}
					$initial_y = $initial_y + 2;
				}
				
				$initial_y = $initial_y + 7;
				$initial_x = 10;				
			}

			if (count($accessories_result)>0)
			{
				$pdf->SetXY(8, $initial_y - 2);
				$pdf->SetFont('Helvetica', 'B');
				$pdf->Write(0, 'Dealer-Fitted Accessories');

				foreach ($accessories_result as $accessory_key => $accessory_val) 
				{
					$temp_initial_y = $initial_y + 2;

					$pdf->SetXY(82, ($accessory_key != 0) ? $temp_initial_y + .5 : $temp_initial_y );
					$pdf->SetFont('Helvetica');
					$pdf->Cell(20, .5, $accessory_val->price, 0, 0, 'R');

					$pdf->SetXY($initial_x, $initial_y);

					$string_count = strlen($accessory_val->name);

					if (strlen($accessory_val->name) > $character_limit)
					{
						$temp_string_array = [];

						$string_arr = str_split($accessory_val->name);
						$temp_string = "";
						$final_string = "";
						$counter = 1;
						foreach ($string_arr as $string_key => $string_val) 
						{
							$temp_string .= $string_val;
							if( ($counter >= $character_limit && $string_val == " ")  || $counter== $string_count )
							{
								$final_string = $temp_string;
								$temp_string = "";
								$counter = 1;
								$initial_y = $initial_y + 3;
								$pdf->SetXY($initial_x , $initial_y);
								$pdf->SetFont('Helvetica', 'I');
								$pdf->Write(0, $final_string);
								$temp_string_array[] = $final_string;	
							}
							$counter++;
						}

						if( $counter > 2 )
						{
							if( strlen($temp_string_array[count($temp_string_array) - 1]) > $character_limit )
							{
								$pdf->SetXY($initial_x , $initial_y + 3);
								$initial_y = $initial_y + 2;
							}
						}
							
						$pdf->Write(0, " ".$temp_string);
					}
					else
					{
						$pdf->SetXY($initial_x, $initial_y + 2);
						$pdf->SetFont('Helvetica', 'I');
						$pdf->Write(0, $accessory_val->name);

						$initial_y = $initial_y + 2;
					}
					$initial_y = $initial_y + 2;
				}				
			}

			// Lead Calculation Details //
			if (1==1)
			{	
				$pdf->SetFontSize(7);
				
				$lead_calculation_field_y = $initial_y + 5;
				$pdf->SetXY(8, $lead_calculation_field_y);
				$pdf->SetFont('Helvetica', 'B');
				$pdf->Write(0, 'Other Costs');				
				
				if ($lead_calculation_details['dealer_delivery']>0)
				{
					$lead_calculation_details['dealer_delivery'] = number_format($lead_calculation_details['dealer_delivery'], 2);
				}
				else
				{
					$lead_calculation_details['dealer_delivery'] = "Included";
				}
				$lead_calculation_field_y = $lead_calculation_field_y + 5;
				$pdf->SetFont('Helvetica', 'I');
				$pdf->SetXY(10, $lead_calculation_field_y);
				$pdf->Write(0, 'Dealer Delivery');
				$pdf->SetFont('Helvetica');
				$pdf->SetXY(82, $lead_calculation_field_y);
				$pdf->Cell(20, .5, $lead_calculation_details['dealer_delivery'], 0, 0, 'R');				
				
				if ($lead_calculation_details['stamp_duty']>0)
				{
					$lead_calculation_details['stamp_duty'] = number_format($lead_calculation_details['stamp_duty'], 2);
				}
				else
				{
					$lead_calculation_details['stamp_duty'] = "Included";
				}			
				$lead_calculation_field_y  = $lead_calculation_field_y  + 4;
				$pdf->SetFont('Helvetica', 'I');
				$pdf->SetXY(10, $lead_calculation_field_y);
				$pdf->Write(0, 'Stamp Duty');
				$pdf->SetFont('Helvetica');
				$pdf->SetXY(82, $lead_calculation_field_y);
				$pdf->Cell(20, .5, $lead_calculation_details['stamp_duty'], 0, 0, 'R');
				
				if ($lead_calculation_details['registration']>0)
				{
					$lead_calculation_details['registration'] = number_format($lead_calculation_details['registration'], 2);
				}
				else
				{
					$lead_calculation_details['registration'] = "Included";
				}			
				$lead_calculation_field_y  = $lead_calculation_field_y  + 4;
				$pdf->SetFont('Helvetica', 'I');
				$pdf->SetXY(10, $lead_calculation_field_y);
				$pdf->Write(0, 'Registration Fee');
				$pdf->SetFont('Helvetica');
				$pdf->SetXY(82, $lead_calculation_field_y);
				$pdf->Cell(20, .5, $lead_calculation_details['registration'], 0, 0, 'R');			

				if ($lead_calculation_details['ctp']>0)
				{
					$lead_calculation_details['ctp'] = number_format($lead_calculation_details['ctp'], 2);
				}
				else
				{
					$lead_calculation_details['ctp'] = "Included";
				}			
				$lead_calculation_field_y  = $lead_calculation_field_y  + 4;
				$pdf->SetFont('Helvetica', 'I');
				$pdf->SetXY(10, $lead_calculation_field_y);
				$pdf->Write(0, 'Compulsary Third Party');
				$pdf->SetFont('Helvetica');
				$pdf->SetXY(82, $lead_calculation_field_y);
				$pdf->Cell(20, .5, $lead_calculation_details['ctp'], 0, 0, 'R');
				
				if ($lead_calculation_details['premium_plate_fee']>0)
				{
					$lead_calculation_details['premium_plate_fee'] = number_format($lead_calculation_details['premium_plate_fee'], 2);
				}
				else
				{
					$lead_calculation_details['premium_plate_fee'] = "Included";
				}
				$lead_calculation_field_y  = $lead_calculation_field_y  + 4;
				$pdf->SetFont('Helvetica', 'I');
				$pdf->SetXY(10, $lead_calculation_field_y);
				$pdf->Write(0, 'Premium Plate Fee');
				$pdf->SetFont('Helvetica');
				$pdf->SetXY(82, $lead_calculation_field_y);
				$pdf->Cell(20, .5, $lead_calculation_details['premium_plate_fee'], 0, 0, 'R');
				
				if ($lead_calculation_details['lct']>0)
				{
					$lead_calculation_details['lct'] = number_format($lead_calculation_details['lct'], 2);
				}
				else
				{
					$lead_calculation_details['lct'] = "Included";
				}	
				$lead_calculation_field_y  = $lead_calculation_field_y  + 4;
				$pdf->SetFont('Helvetica', 'I');
				$pdf->SetXY(10, $lead_calculation_field_y);
				$pdf->Write(0, 'Luxury Car Tax');
				$pdf->SetFont('Helvetica');
				$pdf->SetXY(82, $lead_calculation_field_y);
				$pdf->Cell(20, .5, $lead_calculation_details['lct'], 0, 0, 'R');			
				
				if (
					$lead_calculation_details['dealer_discount']>0 OR
					$lead_calculation_details['fleet_discount']>0
				)
				{
					$lead_calculation_field_y = $lead_calculation_field_y + 5;
					$pdf->SetXY(8, $lead_calculation_field_y);
					$pdf->SetFont('Helvetica', 'B');
					$pdf->Write(0, 'Discount');

					$discounts_total = $lead_calculation_details['dealer_discount'] + $lead_calculation_details['fleet_discount'];
					
					$pdf->SetFont('Helvetica');
					$pdf->SetXY(82, $lead_calculation_field_y);
					$pdf->Cell(20, .5, '-'.number_format($discounts_total, 2), 0, 0, 'R');				
				}			
			}

			// Details of Settlement
			if (1==1)
			{
				$pdf->SetFontSize(7);
				$pdf->SetFont('Helvetica', 'B');
				$pdf->SetXY(105.7, 227.5);
				$pdf->Write(0, 'TOTAL Settlement Amount');				
				
				$pdf->SetXY(180.5, 227.5);
				$pdf->Cell(20, .5, '$ '.number_format($lead['sales_price'], 2), 0, 0, 'R');								
				
				$settlement_x = 110;
				$settlement_y = 108;

				if (count($tradeins)>0)
				{
					$pdf->SetFont('Helvetica', 'B');
					$pdf->SetXY(105.7, $settlement_y);
					$pdf->Write(0, 'Trade-in vehicle particulars');

					$settlement_y  = $settlement_y + 3;
					$pdf->SetFont('Helvetica');
					$pdf->SetXY(107.7, $settlement_y);
					$pdf->Write(0, 'The Trader agrees to allow part of the total price for the motor');					
					
					$settlement_y  = $settlement_y + 3;
					$pdf->SetFont('Helvetica');
					$pdf->SetXY(107.7, $settlement_y);
					$pdf->Write(0, 'vehicle to be discharged by the Purchaser delivering to the');			

					$settlement_y  = $settlement_y + 3;
					$pdf->SetFont('Helvetica');
					$pdf->SetXY(107.7, $settlement_y);
					$pdf->Write(0, 'Trader the undermentioned trade-in vehicle including all extras');			
					
					$settlement_y  = $settlement_y + 3;
					$pdf->SetFont('Helvetica');
					$pdf->SetXY(107.7, $settlement_y);
					$pdf->Write(0, 'and accessories now on or attached thereto, free of all encum');
					
					$settlement_y  = $settlement_y + 2;
					
					foreach ($tradeins AS $tradein)
					{
						$settlement_y  = $settlement_y + 3;
						$pdf->SetFont('Helvetica', 'B');
						$pdf->SetXY(107.7, $settlement_y);
						$pdf->Write(0, 'Make & Model');					

						$settlement_y  = $settlement_y + 3;
						$pdf->SetFont('Helvetica');
						$pdf->SetXY(107.7, $settlement_y);
						$pdf->Write(0, $tradein['tradein_make'].' '.$tradein['tradein_model'].' '.$tradein['tradein_variant']);

						$settlement_y = $settlement_y + 1;

						$settlement_y  = $settlement_y + 3;
						$pdf->SetFont('Helvetica', 'B');
						$pdf->SetXY(107.7, $settlement_y);
						$pdf->Write(0, 'Body Type');	
						
						$settlement_y  = $settlement_y;
						$pdf->SetFont('Helvetica', 'B');
						$pdf->SetXY(147.7, $settlement_y);
						$pdf->Write(0, 'Registration No');					
						
						$settlement_y  = $settlement_y + 3;
						$pdf->SetFont('Helvetica');
						$pdf->SetXY(107.7, $settlement_y);
						$pdf->Write(0, $tradein['tradein_body_type']);

						$settlement_y  = $settlement_y;
						$pdf->SetFont('Helvetica');
						$pdf->SetXY(147.7, $settlement_y);
						$pdf->Write(0, $tradein['registration_plate']);		

						$settlement_y = $settlement_y + 1;					
						
						$settlement_y  = $settlement_y + 3;
						$pdf->SetFont('Helvetica', 'B');
						$pdf->SetXY(107.7, $settlement_y);
						$pdf->Write(0, 'Distance on Odometer');					

						$settlement_y  = $settlement_y;
						$pdf->SetFont('Helvetica', 'B');
						$pdf->SetXY(147.7, $settlement_y);
						$pdf->Write(0, 'Expiry Date');										
						
						$settlement_y  = $settlement_y + 3;
						$pdf->SetFont('Helvetica');
						$pdf->SetXY(107.7, $settlement_y);
						$pdf->Write(0, $tradein['tradein_kms']);

						$settlement_y  = $settlement_y;
						$pdf->SetFont('Helvetica');
						$pdf->SetXY(147.7, $settlement_y);
						$pdf->Write(0, $tradein['rego_expiry']);					
					}
					
					$settlement_y  = $settlement_y + 4;
					$pdf->SetFont('Helvetica');
					$pdf->SetXY(107.7, $settlement_y);
					$pdf->Write(0, 'at the time of signing this agreement which the purchaser');
					
					$settlement_y  = $settlement_y + 3;
					$pdf->SetFont('Helvetica');
					$pdf->SetXY(107.7, $settlement_y);
					$pdf->Write(0, 'believes is true');					

					$settlement_y  = $settlement_y + 5;
					$pdf->SetFont('Helvetica', 'B');
					$pdf->SetXY(107.7, $settlement_y);
					$pdf->Write(0, 'Signature of person Authorised to tradein Motor vehicle');	

					$settlement_y  = $settlement_y + 4;
					$pdf->SetFont('Helvetica', 'I');
					$pdf->SetXY(107.7, $settlement_y);
					$pdf->Write(0, 'Allowance for Trade In');

					$pdf->SetFont('Helvetica');
					$pdf->SetXY(180.5, ($settlement_y - 1));
					$pdf->Cell(20, .5, number_format($lead_calculation_details['tradein_given'], 2), 0, 0, 'R');					
					
					$settlement_y  = $settlement_y + 4;
					$pdf->SetFont('Helvetica', 'B');
					$pdf->SetXY(107.7, $settlement_y);
					$pdf->Write(0, 'Payout');				

					$pdf->SetFont('Helvetica');
					$pdf->SetXY(180.5, ($settlement_y - 1));
					$pdf->Cell(20, .5, number_format($lead_calculation_details['tradein_payout'], 2), 0, 0, 'R');						
				}

				if (count($deposits)>0)
				{
					$settlement_y  = $settlement_y + 5;
					$pdf->SetFont('Helvetica', 'B');
					$pdf->SetXY(105.7, $settlement_y);
					$pdf->Write(0, 'Amounts payable by dealer');									
					
					$deposit_counter = 0;
					foreach ($deposits AS $deposit)
					{
						$deposit_counter ++;
						if ($deposit['payment_date'] == "0000-00-00") { $deposit_date = ""; }
						else { $deposit_date = date('d/m/Y', strtotime($deposit['payment_date'])); }

						$settlement_y  = $settlement_y + 3;
						$pdf->SetFont('Helvetica');
						$pdf->SetXY(107.7, $settlement_y);
						$pdf->Write(0, 'Reference: Deposit taken by Quote Me ('.$deposit_date.')');
						
						$pdf->SetFont('Helvetica');
						$pdf->SetXY(180.5, ($settlement_y - 1));
						$pdf->Cell(20, .5, number_format($deposit['amount'], 2), 0, 0, 'R');
					}					
				}
				
				if (count($refunds)>0)
				{
					$refund_counter = 0;
					foreach ($refunds AS $refund)
					{
						$refund_counter ++;
						if ($refund['payment_date'] == "0000-00-00") { $refund_date = ""; }
						else { $refund_date = date('d F Y', strtotime($refund['payment_date'])); }		

						$settlement_y  = $settlement_y  + 3;
						$pdf->SetFont('Helvetica');
						$pdf->SetXY(107.7, $settlement_y);
						$pdf->Write(0, 'Refund made '.$refund_date);

						$pdf->SetFont('Helvetica');
						$pdf->SetXY(180.5, ($settlement_y - 1));
						$pdf->Cell(20, .5, '-'.number_format($refund['amount'], 2), 0, 0, 'R');								
					}					
				}
		
				if ($lead_calculation_details['balance']>0)
				{
					$settlement_y  = $settlement_y  + 5;
					$pdf->SetFontSize(9);
					$pdf->SetFont('Helvetica', 'B');
					$pdf->SetXY(105.7, $settlement_y);
					$pdf->Write(0, 'Balance of '.number_format($lead_calculation_details['balance'], 2).' to be settled by');
				}
			}
		}

		if (isset($sig_coords[1])) // Signature Population
		{
			foreach ($sig_coords[1] as $s_key => $s_val) 
			{
				$pdf->Image($sig_coords[1][$s_key]['image'],$sig_coords[1][$s_key]['x'],$sig_coords[1][$s_key]['y'],$sig_coords[1][$s_key]['reso']);
			}
		}

		// Tradein
		for ($i=1; $i<=count($tradeins); $i++)
		{
			$j = $i - 1;

			$pdf->AddPage();
			$tplIdx = $pdf->importPage(2);
			$pdf->useTemplate($tplIdx, 0, 0, 0);
			$pdf->SetFont('Times');
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetMargins(0,0,0);
			$pdf->SetAutoPageBreak('auto',0);
			
			if (1==1) // Tradein Text Definitions
			{
				$tradein_xy_arr = [
					'make_model_and_body' => [
						'x'    => 46,
						'y'    => 18,
						'text' => $tradeins[$j]['tradein_make']." ".$tradeins[$j]['tradein_model']." (".$tradeins[$j]['tradein_body_type'].")",
						'size' => 10
					],
					'registration_number' => [
						'x'    => 36,
						'y'    => 25.1,
						'text' => $tradeins[$j]['registration_plate'],
						'size' => 10
					],
					'vin_number' => [
						'x'    => 84,
						'y'    => 25.1,
						'text' => $tradeins[$j]['tradein_vin'],
						'size' => 10
					],
					'deal_id' => [
						'x'    => 163,
						'y'    => 11.5,
						'text' => '',
						'size' => 8
					],							
					'odometer' => [
						'x'    => 163,
						'y'    => 21.1,
						'text' => $tradeins[$j]['tradein_kms'],
						'size' => 10
					],
					'engine_number' => [
						'x'    => 163,
						'y'    => 25.1,
						'text' => $tradeins[$j]['tradein_eng'],
						'size' => 10
					],
					'name_of_declarant' => [
						'x'    => 14,
						'y'    => 34,
						'text' => $tradeins[$j]['first_name'] . " " . $tradeins[$j]['last_name'],
						'size' => 10
					],
					'credit_provider' => [
						'x'    => 40,
						'y'    => 96,
						'text' => $tradeins[$j]['credit_provider'],
						'size' => 10
					],
					'account_number' => [
						'x'    => 40,
						'y'    => 103,
						'text' => $tradeins[$j]['account_number'],
						'size' => 10
					],
					'payout_required' => [
						'x'    => 133,
						'y'    => 103,
						'text' => $tradeins[$j]['payout_required'],
						'size' => 10
					],
					'declarant' => [
						'x'    => 44,
						'y'    => -95,
						'text' => $tradeins[$j]['first_name']." ".$tradeins[$j]['last_name'],
						'size' => 11
					],
					'declaration_date' => [
						'x'    => 152,
						'y'    => -95,
						'text' => date('d F Y', strtotime($lead['client_agreed_date'])),
						'size' => 11
					],
					'reference' => [
						'x'    => 30,
						'y'    => -73.9,
						'text' => '',
						'size' => 9
					],
					'reference_date' => [
						'x'    => 87,
						'y'    => -73.9,
						'text' => date('d F Y', strtotime($lead['client_agreed_date'])),
						'size' => 9
					],
					'reference_time' => [
						'x'    => 160,
						'y'    => -73.9,
						'text' => $lead['client_agreed_time'],
						'size' => 9
					],
					'result' => [
						'x'    => 30,
						'y'    => -67,
						'text' => '',
						'size' => 9
					],
					'special_conditions_date' => [
						'x'    => 20,
						'y'    => -25,
						'text' => date('d F Y', strtotime($lead['client_agreed_date'])),
						'size' => 8
					],
					'special_conditions_signed' => [
						'x'    => 156,
						'y'    => -18,
						'text' => date('d F Y', strtotime($lead['client_agreed_date'])),
						'size' => 9
					],
					'tradein_purchased_from' => [
						'x'    => 114,
						'y'    => 50,
						'text' => $tradeins[$j]['tradein_purchased_from'],
						'size' => 10
					],							
					'tradein_encumbered_by' => [
						'x'    => 23,
						'y'    => 82,
						'text' => $tradeins[$j]['tradein_encumbered_by'],
						'size' => 10
					],
					'tradein_abn_holder' => [
						'x'    => 22,
						'y'    => 163,
						'text' => $tradeins[$j]['tradein_abn_holder'],
						'size' => 7
					],
					'tradein_not_providing_abn' => [
						'x'    => 69,
						'y'    => 176.1,
						'text' => $tradeins[$j]['tradein_not_providing_abn'],
						'size' => 9
					],
				];
			}
			
			if (1==1) // Tradein Declaration Definitions
			{						
				$check_url = base_url("assets/img/red_check.png");
				
				$declaration_1_1 = base_url("assets/img/blank_check.png");
				$declaration_1_2 = base_url("assets/img/blank_check.png");
				if ($tradeins[$j]['declaration_1']==1) { $declaration_1_1 = $check_url; }
				else if ($tradeins[$j]['declaration_1']==2) { $declaration_1_2 = $check_url; }
				
				$declaration_2_1 = base_url("assets/img/blank_check.png");
				$declaration_2_2 = base_url("assets/img/blank_check.png");
				if ($tradeins[$j]['declaration_2']==1) { $declaration_2_1 = $check_url; }
				else if ($tradeins[$j]['declaration_2']==2) { $declaration_2_2 = $check_url; }	

				$declaration_payg_1 = base_url("assets/img/blank_check.png");
				$declaration_payg_2 = base_url("assets/img/blank_check.png");
				if ($tradeins[$j]['declaration_payg']==1) { $declaration_payg_1 = $check_url; }
				else if ($tradeins[$j]['declaration_payg']==2) { $declaration_payg_2 = $check_url; }	

				$tradein_not_providing_1 = base_url("assets/img/blank_check.png");
				$tradein_not_providing_2 = base_url("assets/img/blank_check.png");
				if ($tradeins[$j]['tradein_not_providing']==1) { $tradein_not_providing_1 = $check_url; }
				else if ($tradeins[$j]['tradein_not_providing']==2) { $tradein_not_providing_2 = $check_url; }						
	
				$checks = [
					'declaration_1_1' => [
						'x'     => 14,
						'y'     => 48.6,
						'reso'  => -3700,
						'image' => $declaration_1_1
					],
					'declaration_1_2' => [
						'x'     => 14,
						'y'     => 59,
						'reso'  => -3700,
						'image' => $declaration_1_2
					],
					'declaration_2_1' => [
						'x'     => 14,
						'y'     => 64,
						'reso'  => -3700,
						'image' => $declaration_2_1
					],
					'declaration_2_2' => [
						'x'     => 14,
						'y'     => 74.6,
						'reso'  => -3700,
						'image' => $declaration_2_2
					],
					'declaration_payg_1' => [
						'x'     => 14,
						'y'     => 158,
						'reso'  => -3700,
						'image' => $declaration_payg_1
					],
					'declaration_payg_2' => [
						'x'     => 14,
						'y'     => 165,
						'reso'  => -3700,
						'image' => $declaration_payg_2
					],
					'tradein_not_providing_1' => [
						'x'     => 25,
						'y'     => 169.5,
						'reso'  => -3700,
						'image' => $tradein_not_providing_1
					],
					'tradein_not_providing_2' => [
						'x'     => 25,
						'y'     => 174,
						'reso'  => -3700,
						'image' => $tradein_not_providing_2
					],
				];
			}

			foreach ($tradein_xy_arr as $tradein_key => $tradein_val) // Tradein Text Population
			{
				$pdf->SetFontSize($tradein_val['size']);
				$pdf->SetXY($tradein_val['x'], $tradein_val['y']);
				$pdf->Write(0, $tradein_val['text']);
			}

			if (isset($sig_coords[2])) // Tradein Signature Population
			{
				foreach ($sig_coords[2] as $s_key => $s_val) 
				{
					$pdf->Image($sig_coords[2][$s_key]['image'],$sig_coords[2][$s_key]['x'],$sig_coords[2][$s_key]['y'],$sig_coords[2][$s_key]['reso']);
				}
			}

			foreach ($checks as $s_key => $s_val) // Tradein Declaration Population
			{
				$pdf->Image($checks[$s_key]['image'],$checks[$s_key]['x'],$checks[$s_key]['y'],$checks[$s_key]['reso']);
			}
		}
				
		if ($lead['dealer_tradein_count']==0)
		{
			$pdf->setSourceFile($directory.'template_vehicle_order_terms_and_conditions_dealer_not_taking_trade.pdf');
		}		
		else
		{
			$pdf->setSourceFile($directory.'template_vehicle_order_terms_and_conditions_dealer_taking_trade.pdf');
		}
		
		$pdf->AddPage();
		$tplIdx = $pdf->importPage(1);
		$pdf->useTemplate($tplIdx, 0, 0, 0);
		$pdf->SetFont('Times');
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetMargins(0,0,0);
		$pdf->SetAutoPageBreak('auto',0);
		if (isset($xy_arr[3]))
		{
			foreach ($xy_arr[3] as $x_key => $x_val) 
			{
				$pdf->SetFontSize($xy_arr[3][$x_key]['size']);
				$pdf->SetXY($xy_arr[3][$x_key]['x'], $xy_arr[3][$x_key]['y']);
				$pdf->Write(0, $xy_arr[3][$x_key]['text']);
			}
		}

		if (isset($sig_coords[3]))
		{
			foreach ($sig_coords[3] as $s_key => $s_val) 
			{
				$pdf->Image($sig_coords[3][$s_key]['image'],$sig_coords[3][$s_key]['x'],$sig_coords[3][$s_key]['y'],$sig_coords[3][$s_key]['reso']);
			}
		}

		$pdf->AddPage();
		$tplIdx = $pdf->importPage(2);
		$pdf->useTemplate($tplIdx, 0, 0, 0);
		
		$time = time();
		$final_file_name = "deal_agreement_".$lead_id."_".$time.".pdf";
		$pdf->Output('./uploads/deal_agreements/'.$final_file_name, 'F');
		
		return $final_file_name;
	}

	public function temp_test ($lead_id = 0)
	{
		$lead_id = 671;

		$lead = $this->lead_model->get_lead($lead_id);

		// echo "<pre>";
		// print_r($lead); die();

		$lead = $this->calculate_adjusted_quote($lead);
		$lead_calculation_details = $this->calculate_deal_new($lead);
		// $accessories = $this->request_model->get_quote_request_accessories($lead['id_quote_request']);
		// $options = $this->request_model->get_quote_request_options($lead['id_quote_request']);
		// $option_prices = $this->request_model->get_quote_option_prices($lead['id_quote']);
		// $accessory_prices = $this->request_model->get_quote_accessories_prices($lead['id_quote']);
		$tradeins = $this->tradein_model->get_tradeins_client($lead_id);

		$options_query = "
					SELECT o.name, qo.price
					FROM quote_request_options qro 
					JOIN quote_options qo ON qro.id_quote_request_option = qo.fk_request_option
					JOIN options o ON qro.fk_option = o.id_option
					WHERE qo.fk_quote = '".$lead['id_quote']."' AND qro.deprecated <> 1 ORDER BY qro.id_quote_request_option ASC";
		$options_result = $this->db->query($options_query)->result();

		$accessories_query = "
					SELECT qra.name, qa.price
					FROM quote_request_accessories qra
					JOIN quote_accessories qa ON qra.id_quote_request_accessory = qa.fk_request_accessory
					WHERE qa.fk_quote = '".$lead['id_quote']."' AND qra.deprecated <> 1 ORDER BY qra.id_quote_request_accessory ASC";
		$accessories_result = $this->db->query($accessories_query)->result();


		// echo "<pre>";
		// print_r($options_result); die();

		
		if ($lead['registration_type']=="Business")
		{
			$customer_name = $lead['name'];
			$customer_abn = $lead['abn'];
		}
		else
		{
			$customer_name = $lead['name'];
			$customer_abn = "";
		}
		
		if (1==1) // Text Definitions
		{
			$xy_arr = [
				1 => [
					'customer_name' => [
						'x'    => 27,
						'y'    => 38,
						'text' => $customer_name,
						'size' => 7.5
					],							
					'address' => [
						'x'    => 27,
						'y'    => 42,
						'text' => $lead['address']." ".$lead['state']." ".$lead['postcode'],
						'size' => 7.5
					],
					'abn' => [
						'x'    => 27,
						'y'    => 46.1,
						'text' => $customer_abn,
						'size' => 7.5
					],
					'email' => [
						'x'    => 92,
						'y'    => 46.1,
						'text' => $lead['email'],
						'size' => 7.5
					],
					'mobile' => [
						'x'    => 124,
						'y'    => 50.35,
						'text' => $lead['mobile'],
						'size' => 7.5
					],		
					'date_of_birth' => [
						'x'    => 6.3,
						'y'    => 58,
						'text' => date('d F Y', strtotime($lead['date_of_birth'])),
						'size' => 7.5
					],
					'occupation' => [
						'x'    => 42,
						'y'    => 58,
						'text' => $lead['occupation'],
						'size' => 7.5
					],
					'license_number' => [
						'x'    => 78,
						'y'    => 58,
						'text' => $lead['driver_license'],
						'size' => 7.5
					],
					'make' => [
						'x'    => 6.2,
						'y'    => 69,
						'text' => $lead['tender_make'],
						'size' => 7.5
					],
					'model' => [
						'x'    => 54.1,
						'y'    => 69,
						'text' => $lead['tender_model'],
						'size' => 7.5
					],
					'colour' => [
						'x'    => 125.5,
						'y'    => 69,
						'text' => $lead['colour'],
						'size' => 7.5
					],
					'body_type' => [
						'x'    => 6.2,
						'y'    => 76,
						'text' => $lead['body_type'],
						'size' => 7.5
					],
					'alternative_model_no' => [
						'x'    => 54.1,
						'y'    => 76,
						'text' => '',
						'size' => 7.5
					],
					'odometer' => [
						'x'    => 86.9,
						'y'    => 76,
						'text' => $lead['kms'],
						'size' => 7.5
					],
					'trim' => [
						'x'    => 125.5,
						'y'    => 76,
						'text' => '',
						'size' => 7.5
					],
					'rego_expiry' => [
						'x'    => 179.4,
						'y'    => 76,
						'text' => $lead['registration_expiry'],
						'size' => 7.5
					],
					'stock_number' => [
						'x'    => 6.2,
						'y'    => 82,
						'text' => '',
						'size' => 7.5
					],
					'vin_number' => [
						'x'    => 54.1,
						'y'    => 82,
						'text' => $lead['vin'],
						'size' => 7.5
					],
					'engine_number' => [
						'x'    => 86.8,
						'y'    => 82,
						'text' => $lead['engine'],
						'size' => 7.5
					],
					'prod_date' => [
						'x'    => 125.5,
						'y'    => 82,
						'text' => $lead['build_date'],
						'size' => 7.5
					],
					'comp_date' => [
						'x'    => 153.9,
						'y'    => 82,
						'text' => $lead['compliance_date'],
						'size' => 7.5
					],
					'fact_order_no' => [
						'x'    => 181,
						'y'    => 82,
						'text' => '',
						'size' => 7.5
					],
					'customer_number' => [
						'x'    => -38,
						'y'    => 38,
						'text' => $lead['cq_number'],
						'size' => 7.5
					],
					'deal_number' => [
						'x'    => -38,
						'y'    => 42.5,
						'text' => $lead['cq_number'],
						'size' => 7.5
					],
					'deal_date' => [
						'x'    => -38,
						'y'    => 47,
						'text' => date('d F Y', strtotime($lead['order_date'])),
						'size' => 7.5
					],
					'order_number' => [
						'x'    => -38,
						'y'    => 51.5,
						'text' => $lead['cq_number'],
						'size' => 7.5
					],
					'price_level' => [
						'x'    => -38,
						'y'    => 56,
						'text' => '',
						'size' => 7.5
					],
					'sales_person' => [
						'x'    => -38,
						'y'    => 60.5,
						'text' => $lead['qs_name'],
						'size' => 7.5
					],
					'delivery_date' => [
						'x'    => 9,
						'y'    => -56,
						'text' => date('d F Y', strtotime($lead['delivery_date'])),
						'size' => 7.5
					],
					'special_conditions' => [
						'x'    => 47,
						'y'    => -56,
						'text' => $lead['special_conditions'],
						'size' => 7.5
					],
					'date_purchaser_signed' => [
						'x'    => 12,
						'y'    => -16,
						'text' => date('d F Y', strtotime($lead['client_agreed_date'])),
						'size' => 7.5
					],
					'witness_name' => [
							'x'    => 76.5,
							'y'    => -16,
							'text' => '',
							'size' => 7.5
						],
					'date_employee_signed' => [
						'x'    => 143,
						'y'    => -16,
						'text' => '',
						'size' => 7.5
					],
				],
				3 =>[
					'customer_signature_date' => [
						'x'    => -48.7,
						'y'    => -23.5,
						'text' => date('d     m    Y', strtotime($lead['client_agreed_date'])),
						'size' => 7.5
					],
				]
			];
		}

		if (1==1) // Signature Definitions
		{
			$sig_coords = [
				1 => [
					'puchaser_signature' => [
						'x'     => 11,
						'y'     => 264,
						'reso'  => -400,
						'image' => base_url("uploads/signatures/client/".$lead['client_signature_url'])
					]
				],
				2 => [
					'tradein_signature' => [
						'x'     => 54,
						'y'     => 265,
						'reso'  => -400,
						'image' => base_url("uploads/signatures/client/".$lead['client_signature_url'])
					]
				],
				3 => [
					'customer_signature_1' => [
						'x'     => 35,
						'y'     => 279,
						'reso'  => -400,
						'image' => base_url("uploads/signatures/client/".$lead['client_signature_url'])
					],
					'customer_signature_2' => [
						'x'     => 107,
						'y'     => 267,
						'reso'  => -400,
						'image' => base_url("uploads/signatures/client/".$lead['client_signature_url'])
					]							
				]
			];
		}

		$pdf = new FPDI();
		$directory = './assets/pdf_templates/';

		$pdf->setSourceFile($directory.'template_vehicle_order.pdf');
		$pdf->AddPage();
		$tplIdx = $pdf->importPage(1);
		$pdf->useTemplate($tplIdx, 0, 0, 0);
		$pdf->SetFont('Times');
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetMargins(0,0,0);
		$pdf->SetAutoPageBreak('auto',0);
		if (isset($xy_arr[1]))
		{
			foreach ($xy_arr[1] as $x_key => $x_val) 
			{
				$pdf->SetFont('Times', 'B');
				$pdf->SetFontSize($xy_arr[1][$x_key]['size']);
				$pdf->SetXY($xy_arr[1][$x_key]['x'], $xy_arr[1][$x_key]['y']);
				$pdf->Write(0, $xy_arr[1][$x_key]['text']);
			}

			$pdf->SetFontSize(7);
						
			$pdf->SetXY(82, 227.5);
			$pdf->Cell(20, .5, $lead['sales_price'], 0, 0, 'R');					

			$pdf->SetXY(8, 100);
			$pdf->SetFont('Times', 'B');
			$pdf->Write(0, 'Vehicle Price');
			
			$pdf->SetXY(82, 100);
			$pdf->Cell(20, .5, $lead['retail_price'], 0, 0, 'R');			

			$initial_y = 107;
			$initial_x = 10;

			$character_limit = 40;
			if (count($options_result)>0)
			{
				$pdf->SetXY(8, 106);
				$pdf->SetFont('Times', 'B');
				$pdf->Write(0, 'Factory-Fitted Options');				
				
				foreach ($options_result as $option_key => $option_val) 
				{
					$pdf->SetXY(82, ($option_key != 0) ? $initial_y + 2.5 : $initial_y + 2);
					$pdf->SetFont('Times');
					$pdf->Cell(20, .5, $option_val->price, 0, 0, 'R');

					$pdf->SetXY($initial_x, $initial_y);

					$string_count = strlen($option_val->name);

					if(strlen($option_val->name) > $character_limit)
					{
						$temp_string_array = [];

						$string_arr = str_split($option_val->name);
						$temp_string = "";
						$final_string = "";
						$counter = 1;
						foreach ($string_arr as $string_key => $string_val) 
						{
							$temp_string .= $string_val;
							if( ($counter >= $character_limit && $string_val == " ")  || $counter== $string_count )
							{
								$final_string = $temp_string;
								$temp_string = "";
								$counter = 1;
								$initial_y = $initial_y + 3;
								$pdf->SetXY($initial_x , $initial_y);
								$pdf->SetFont('Times', 'I');
								$pdf->Write(0, $final_string);
								$temp_string_array[] = $final_string;
							}
							$counter++;
						}

						if( $counter > 2 )
						{
							if( strlen($temp_string_array[count($temp_string_array) - 1]) > $character_limit )
							{
								$pdf->SetXY($initial_x , $initial_y + 3);
								$initial_y = $initial_y + 2;
							}
						}
							
						$pdf->Write(0, " ".$temp_string);
					}
					else
					{
						$pdf->SetXY($initial_x, $initial_y + 2);
						$pdf->SetFont('Times', 'I');
						$pdf->Write(0, $option_val->name);

						$initial_y = $initial_y + 2;
					}
					$initial_y = $initial_y + 2;
				}
				
				$initial_y = $initial_y + 7;
				$initial_x = 10;				
			}

			if (count($accessories_result)>0)
			{
				$pdf->SetXY(8, $initial_y - 2);
				$pdf->SetFont('Times', 'B');
				$pdf->Write(0, 'Dealer-Fitted Accessories');

				foreach ($accessories_result as $accessory_key => $accessory_val) 
				{
					// if($accessory_key == 0)
					// 	continue;

					$temp_initial_y = $initial_y + 2;

					$pdf->SetXY(82, ($accessory_key != 0) ? $temp_initial_y + .5 : $temp_initial_y );
					$pdf->SetFont('Times');
					$pdf->Cell(20, .5, $accessory_val->price, 0, 0, 'R');

					$pdf->SetXY($initial_x, $initial_y);

					$string_count = strlen($accessory_val->name);

					if(strlen($accessory_val->name) > $character_limit)
					{
						$temp_string_array = [];

						$string_arr = str_split($accessory_val->name);
						$temp_string = "";
						$final_string = "";
						$counter = 1;
						foreach ($string_arr as $string_key => $string_val) 
						{
							$temp_string .= $string_val;
							if( ($counter >= $character_limit && $string_val == " ")  || $counter== $string_count )
							{
								$final_string = $temp_string;
								$temp_string = "";
								$counter = 1;
								$initial_y = $initial_y + 3;
								$pdf->SetXY($initial_x , $initial_y);
								$pdf->SetFont('Times', 'I');
								$pdf->Write(0, $final_string);
								$temp_string_array[] = $final_string;	
							}

							$counter++;
						}

						if( $counter > 2 )
						{
							if( strlen($temp_string_array[count($temp_string_array) - 1]) > $character_limit )
							{
								$pdf->SetXY($initial_x , $initial_y + 3);
								$initial_y = $initial_y + 2;
							}
						}
							
						$pdf->Write(0, " ".$temp_string);

					}
					else
					{
						$pdf->SetXY($initial_x, $initial_y + 2);
						$pdf->SetFont('Times', 'I');
						$pdf->Write(0, $accessory_val->name);

						$initial_y = $initial_y + 2;
					}

					$initial_y = $initial_y + 2;
				}				
			}

			// Lead Calculation Details //
			$pdf->SetFontSize(7);
			
			$lead_calculation_field_y = $initial_y + 7;
			$pdf->SetXY(8, $lead_calculation_field_y);
			$pdf->SetFont('Times', 'B');
			$pdf->Write(0, 'Other Costs');				
			
			if ($lead_calculation_details['dealer_delivery']>0)
			{
				$lead_calculation_details['dealer_delivery'] = number_format($lead_calculation_details['dealer_delivery'], 2);
			}
			else
			{
				$lead_calculation_details['dealer_delivery'] = "Included";
			}
			$lead_calculation_field_y = $lead_calculation_field_y + 5;
			$pdf->SetFont('Times', 'I');
			$pdf->SetXY(10, $lead_calculation_field_y);
			$pdf->Write(0, 'Dealer Charges');
			$pdf->SetFont('Times');
			$pdf->SetXY(82, $lead_calculation_field_y);
			$pdf->Cell(20, .5, $lead_calculation_details['dealer_delivery'], 0, 0, 'R');				
			
			if ($lead_calculation_details['gst']>0)
			{
				$lead_calculation_details['gst'] = number_format($lead_calculation_details['gst'], 2);
			}
			else
			{
				$lead_calculation_details['gst'] = "Included";
			}		
			$lead_calculation_field_y  = $lead_calculation_field_y  + 4;
			$pdf->SetFont('Times', 'I');
			$pdf->SetXY(10, $lead_calculation_field_y);
			$pdf->Write(0, 'GST');
			$pdf->SetFont('Times');
			$pdf->SetXY(82, $lead_calculation_field_y);
			$pdf->Cell(20, .5, $lead_calculation_details['gst'], 0, 0, 'R');

			if ($lead_calculation_details['lct']>0)
			{
				$lead_calculation_details['lct'] = number_format($lead_calculation_details['lct'], 2);
			}
			else
			{
				$lead_calculation_details['lct'] = "Included";
			}	
			$lead_calculation_field_y  = $lead_calculation_field_y  + 4;
			$pdf->SetFont('Times', 'I');
			$pdf->SetXY(10, $lead_calculation_field_y);
			$pdf->Write(0, 'LCT');
			$pdf->SetFont('Times');
			$pdf->SetXY(82, $lead_calculation_field_y);
			$pdf->Cell(20, .5, $lead_calculation_details['lct'], 0, 0, 'R');
			
			if ($lead_calculation_details['stamp_duty']>0)
			{
				$lead_calculation_details['stamp_duty'] = number_format($lead_calculation_details['stamp_duty'], 2);
			}
			else
			{
				$lead_calculation_details['stamp_duty'] = "Included";
			}			
			$lead_calculation_field_y  = $lead_calculation_field_y  + 4;
			$pdf->SetFont('Times', 'I');
			$pdf->SetXY(10, $lead_calculation_field_y);
			$pdf->Write(0, 'Stamp Duty');
			$pdf->SetFont('Times');
			$pdf->SetXY(82, $lead_calculation_field_y);
			$pdf->Cell(20, .5, $lead_calculation_details['stamp_duty'], 0, 0, 'R');
			
			if ($lead_calculation_details['registration']>0)
			{
				$lead_calculation_details['registration'] = number_format($lead_calculation_details['registration'], 2);
			}
			else
			{
				$lead_calculation_details['registration'] = "Included";
			}			
			$lead_calculation_field_y  = $lead_calculation_field_y  + 4;
			$pdf->SetFont('Times', 'I');
			$pdf->SetXY(10, $lead_calculation_field_y);
			$pdf->Write(0, 'Registration');
			$pdf->SetFont('Times');
			$pdf->SetXY(82, $lead_calculation_field_y);
			$pdf->Cell(20, .5, $lead_calculation_details['registration'], 0, 0, 'R');			

			if ($lead_calculation_details['ctp']>0)
			{
				$lead_calculation_details['ctp'] = number_format($lead_calculation_details['ctp'], 2);
			}
			else
			{
				$lead_calculation_details['ctp'] = "Included";
			}			
			$lead_calculation_field_y  = $lead_calculation_field_y  + 4;
			$pdf->SetFont('Times', 'I');
			$pdf->SetXY(10, $lead_calculation_field_y);
			$pdf->Write(0, 'CTP');
			$pdf->SetFont('Times');
			$pdf->SetXY(82, $lead_calculation_field_y);
			$pdf->Cell(20, .5, $lead_calculation_details['ctp'], 0, 0, 'R');
			
			if ($lead_calculation_details['premium_plate_fee']>0)
			{
				$lead_calculation_details['premium_plate_fee'] = number_format($lead_calculation_details['premium_plate_fee'], 2);
			}
			else
			{
				$lead_calculation_details['premium_plate_fee'] = "Included";
			}
			$lead_calculation_field_y  = $lead_calculation_field_y  + 4;
			$pdf->SetFont('Times', 'I');
			$pdf->SetXY(10, $lead_calculation_field_y);
			$pdf->Write(0, 'Premium Plate Fee');
			$pdf->SetFont('Times');
			$pdf->SetXY(82, $lead_calculation_field_y);
			$pdf->Cell(20, .5, $lead_calculation_details['premium_plate_fee'], 0, 0, 'R');
			
			if (
				$lead_calculation_details['dealer_discount']>0 OR
				$lead_calculation_details['fleet_discount']>0
			)
			{
				$lead_calculation_field_y = $lead_calculation_field_y + 7;
				$pdf->SetXY(8, $lead_calculation_field_y);
				$pdf->SetFont('Times', 'B');
				$pdf->Write(0, 'Discounts');				
			}

			if ($lead_calculation_details['dealer_discount']>0)
			{
				$lead_calculation_field_y  = $lead_calculation_field_y  + 4;
				$pdf->SetFont('Times', 'I');
				$pdf->SetXY(10, $lead_calculation_field_y);
				$pdf->Write(0, 'Discount');
				$pdf->SetXY(82, $lead_calculation_field_y);
				$pdf->Cell(20, .5, number_format($lead_calculation_details['dealer_discount'], 2), 0, 0, 'R');
			}
			
			if ($lead_calculation_details['fleet_discount']>0)
			{			
				$lead_calculation_field_y  = $lead_calculation_field_y  + 4;
				$pdf->SetFont('Times', 'I');
				$pdf->SetXY(10, $lead_calculation_field_y);
				$pdf->Write(0, 'Fleet Claim');
				$pdf->SetXY(82, $lead_calculation_field_y);
				$pdf->Cell(20, .5, number_format($lead_calculation_details['fleet_discount'], 2), 0, 0, 'R');						
			}
		}

		// if (isset($sig_coords[1])) // Signature Population
		// {
		// 	foreach ($sig_coords[1] as $s_key => $s_val) 
		// 	{
		// 		$pdf->Image($sig_coords[1][$s_key]['image'],$sig_coords[1][$s_key]['x'],$sig_coords[1][$s_key]['y'],$sig_coords[1][$s_key]['reso']);
		// 	}
		// }

		// for ($i=1; $i<=count($tradeins); $i++)
		// {
		// 	$j = $i - 1;

		// 	$pdf->AddPage();
		// 	$tplIdx = $pdf->importPage(2);
		// 	$pdf->useTemplate($tplIdx, 0, 0, 0);
		// 	$pdf->SetFont('Times');
		// 	$pdf->SetTextColor(0, 0, 0);
		// 	$pdf->SetMargins(0,0,0);
		// 	$pdf->SetAutoPageBreak('auto',0);
			
		// 	if (1==1) // Tradein Text Definitions
		// 	{
		// 		$tradein_xy_arr = [
		// 			'make_model_and_body' => [
		// 				'x'    => 46,
		// 				'y'    => 18,
		// 				'text' => $tradeins[$j]['tradein_make']." ".$tradeins[$j]['tradein_model']." (".$tradeins[$j]['tradein_body_type'].")",
		// 				'size' => 10
		// 			],
		// 			'registration_number' => [
		// 				'x'    => 36,
		// 				'y'    => 25.1,
		// 				'text' => $tradeins[$j]['registration_plate'],
		// 				'size' => 10
		// 			],
		// 			'vin_number' => [
		// 				'x'    => 84,
		// 				'y'    => 25.1,
		// 				'text' => $tradeins[$j]['tradein_vin'],
		// 				'size' => 10
		// 			],
		// 			'deal_id' => [
		// 				'x'    => 163,
		// 				'y'    => 11.5,
		// 				'text' => '',
		// 				'size' => 8
		// 			],							
		// 			'odometer' => [
		// 				'x'    => 163,
		// 				'y'    => 21.1,
		// 				'text' => $tradeins[$j]['tradein_kms'],
		// 				'size' => 10
		// 			],
		// 			'engine_number' => [
		// 				'x'    => 163,
		// 				'y'    => 25.1,
		// 				'text' => $tradeins[$j]['tradein_eng'],
		// 				'size' => 10
		// 			],
		// 			'name_of_declarant' => [
		// 				'x'    => 14,
		// 				'y'    => 34,
		// 				'text' => $tradeins[$j]['first_name'] . " " . $tradeins[$j]['last_name'],
		// 				'size' => 10
		// 			],
		// 			'credit_provider' => [
		// 				'x'    => 40,
		// 				'y'    => 96,
		// 				'text' => $tradeins[$j]['credit_provider'],
		// 				'size' => 10
		// 			],
		// 			'account_number' => [
		// 				'x'    => 40,
		// 				'y'    => 103,
		// 				'text' => $tradeins[$j]['account_number'],
		// 				'size' => 10
		// 			],
		// 			'payout_required' => [
		// 				'x'    => 133,
		// 				'y'    => 103,
		// 				'text' => $tradeins[$j]['payout_required'],
		// 				'size' => 10
		// 			],
		// 			'declarant' => [
		// 				'x'    => 44,
		// 				'y'    => -95,
		// 				'text' => $tradeins[$j]['first_name']." ".$tradeins[$j]['last_name'],
		// 				'size' => 11
		// 			],
		// 			'declaration_date' => [
		// 				'x'    => 152,
		// 				'y'    => -95,
		// 				'text' => date('d F Y', strtotime($lead['client_agreed_date'])),
		// 				'size' => 11
		// 			],
		// 			'reference' => [
		// 				'x'    => 30,
		// 				'y'    => -73.9,
		// 				'text' => '',
		// 				'size' => 9
		// 			],
		// 			'reference_date' => [
		// 				'x'    => 87,
		// 				'y'    => -73.9,
		// 				'text' => date('d F Y', strtotime($lead['client_agreed_date'])),
		// 				'size' => 9
		// 			],
		// 			'reference_time' => [
		// 				'x'    => 160,
		// 				'y'    => -73.9,
		// 				'text' => $lead['client_agreed_time'],
		// 				'size' => 9
		// 			],
		// 			'result' => [
		// 				'x'    => 30,
		// 				'y'    => -67,
		// 				'text' => '',
		// 				'size' => 9
		// 			],
		// 			'special_conditions_date' => [
		// 				'x'    => 20,
		// 				'y'    => -25,
		// 				'text' => date('d F Y', strtotime($lead['client_agreed_date'])),
		// 				'size' => 8
		// 			],
		// 			'special_conditions_signed' => [
		// 				'x'    => 156,
		// 				'y'    => -18,
		// 				'text' => date('d F Y', strtotime($lead['client_agreed_date'])),
		// 				'size' => 9
		// 			],
		// 			'tradein_purchased_from' => [
		// 				'x'    => 114,
		// 				'y'    => 50,
		// 				'text' => $tradeins[$j]['tradein_purchased_from'],
		// 				'size' => 10
		// 			],							
		// 			'tradein_encumbered_by' => [
		// 				'x'    => 23,
		// 				'y'    => 82,
		// 				'text' => $tradeins[$j]['tradein_encumbered_by'],
		// 				'size' => 10
		// 			],
		// 			'tradein_abn_holder' => [
		// 				'x'    => 22,
		// 				'y'    => 163,
		// 				'text' => $tradeins[$j]['tradein_abn_holder'],
		// 				'size' => 7
		// 			],
		// 			'tradein_not_providing_abn' => [
		// 				'x'    => 69,
		// 				'y'    => 176.1,
		// 				'text' => $tradeins[$j]['tradein_not_providing_abn'],
		// 				'size' => 9
		// 			],
		// 		];
		// 	}
			
		// 	if (1==1) // Tradein Declaration Definitions
		// 	{						
		// 		$check_url = base_url("assets/img/red_check.png");
				
		// 		$declaration_1_1 = base_url("assets/img/blank_check.png");
		// 		$declaration_1_2 = base_url("assets/img/blank_check.png");
		// 		if ($tradeins[$j]['declaration_1']==1) { $declaration_1_1 = $check_url; }
		// 		else if ($tradeins[$j]['declaration_1']==2) { $declaration_1_2 = $check_url; }
				
		// 		$declaration_2_1 = base_url("assets/img/blank_check.png");
		// 		$declaration_2_2 = base_url("assets/img/blank_check.png");
		// 		if ($tradeins[$j]['declaration_2']==1) { $declaration_2_1 = $check_url; }
		// 		else if ($tradeins[$j]['declaration_2']==2) { $declaration_2_2 = $check_url; }	

		// 		$declaration_payg_1 = base_url("assets/img/blank_check.png");
		// 		$declaration_payg_2 = base_url("assets/img/blank_check.png");
		// 		if ($tradeins[$j]['declaration_payg']==1) { $declaration_payg_1 = $check_url; }
		// 		else if ($tradeins[$j]['declaration_payg']==2) { $declaration_payg_2 = $check_url; }	

		// 		$tradein_not_providing_1 = base_url("assets/img/blank_check.png");
		// 		$tradein_not_providing_2 = base_url("assets/img/blank_check.png");
		// 		if ($tradeins[$j]['tradein_not_providing']==1) { $tradein_not_providing_1 = $check_url; }
		// 		else if ($tradeins[$j]['tradein_not_providing']==2) { $tradein_not_providing_2 = $check_url; }						
	
		// 		$checks = [
		// 			'declaration_1_1' => [
		// 				'x'     => 14,
		// 				'y'     => 48.6,
		// 				'reso'  => -3700,
		// 				'image' => $declaration_1_1
		// 			],
		// 			'declaration_1_2' => [
		// 				'x'     => 14,
		// 				'y'     => 59,
		// 				'reso'  => -3700,
		// 				'image' => $declaration_1_2
		// 			],
		// 			'declaration_2_1' => [
		// 				'x'     => 14,
		// 				'y'     => 64,
		// 				'reso'  => -3700,
		// 				'image' => $declaration_2_1
		// 			],
		// 			'declaration_2_2' => [
		// 				'x'     => 14,
		// 				'y'     => 74.6,
		// 				'reso'  => -3700,
		// 				'image' => $declaration_2_2
		// 			],
		// 			'declaration_payg_1' => [
		// 				'x'     => 14,
		// 				'y'     => 158,
		// 				'reso'  => -3700,
		// 				'image' => $declaration_payg_1
		// 			],
		// 			'declaration_payg_2' => [
		// 				'x'     => 14,
		// 				'y'     => 165,
		// 				'reso'  => -3700,
		// 				'image' => $declaration_payg_2
		// 			],
		// 			'tradein_not_providing_1' => [
		// 				'x'     => 25,
		// 				'y'     => 169.5,
		// 				'reso'  => -3700,
		// 				'image' => $tradein_not_providing_1
		// 			],
		// 			'tradein_not_providing_2' => [
		// 				'x'     => 25,
		// 				'y'     => 174,
		// 				'reso'  => -3700,
		// 				'image' => $tradein_not_providing_2
		// 			],
		// 		];
		// 	}

		// 	foreach ($tradein_xy_arr as $tradein_key => $tradein_val) // Tradein Text Population
		// 	{
		// 		$pdf->SetFontSize($tradein_val['size']);
		// 		$pdf->SetXY($tradein_val['x'], $tradein_val['y']);
		// 		$pdf->Write(0, $tradein_val['text']);
		// 	}

		// 	if (isset($sig_coords[2])) // Tradein Signature Population
		// 	{
		// 		foreach ($sig_coords[2] as $s_key => $s_val) 
		// 		{
		// 			$pdf->Image($sig_coords[2][$s_key]['image'],$sig_coords[2][$s_key]['x'],$sig_coords[2][$s_key]['y'],$sig_coords[2][$s_key]['reso']);
		// 		}
		// 	}

		// 	foreach ($checks as $s_key => $s_val) // Tradein Declaration Population
		// 	{
		// 		$pdf->Image($checks[$s_key]['image'],$checks[$s_key]['x'],$checks[$s_key]['y'],$checks[$s_key]['reso']);
		// 	}
		// }
		
		$pdf->setSourceFile($directory.'template_vehicle_order_terms_and_conditions.pdf');
		$pdf->AddPage();
		$tplIdx = $pdf->importPage(1);
		$pdf->useTemplate($tplIdx, 0, 0, 0);
		$pdf->SetFont('Times');
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetMargins(0,0,0);
		$pdf->SetAutoPageBreak('auto',0);
		if (isset($xy_arr[3]))
		{
			foreach ($xy_arr[3] as $x_key => $x_val) 
			{
				$pdf->SetFontSize($xy_arr[3][$x_key]['size']);
				$pdf->SetXY($xy_arr[3][$x_key]['x'], $xy_arr[3][$x_key]['y']);
				$pdf->Write(0, $xy_arr[3][$x_key]['text']);
			}
		}

		// if (isset($sig_coords[3]))
		// {
		// 	foreach ($sig_coords[3] as $s_key => $s_val) 
		// 	{
		// 		$pdf->Image($sig_coords[3][$s_key]['image'],$sig_coords[3][$s_key]['x'],$sig_coords[3][$s_key]['y'],$sig_coords[3][$s_key]['reso']);
		// 	}
		// }

		$pdf->AddPage();
		$tplIdx = $pdf->importPage(2);
		$pdf->useTemplate($tplIdx, 0, 0, 0);
		
		$time = time();
		$final_file_name = "deal_agreement_".$lead_id."_".$time.".pdf";
		// $pdf->Output('./uploads/deal_agreements/'.$final_file_name, 'F');
		$pdf->Output();
	}
}
?>
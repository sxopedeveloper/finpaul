<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('user_main.php');

require_once("./application/libraries/PDFMerger/PDFMerger.php");
require_once("./application/libraries/PDFMerger/fpdf/fpdf.php");
require_once("./application/libraries/PDFMerger/fpdi/fpdi.php");

class User extends User_main {

	public $now_time = null;
	function __construct()
	{
		parent::__construct();
		$this->load->model('logs_model');
		$this->now_time = date('Y-m-d H:i:s');
	}

	function index ()
	{
		$data['title'] = "Home";
		if ($data['login_type']==1) 
		{
			header("Location: " . site_url('user/home')); 
		}
		else if ($data['login_type']==3)
		{
			header("Location: " . site_url('user/profile')); 
		}
		exit();
	}

	public function home ()
	{
		$data = $this->data;	
		$data['title'] = "Home";

		$data['delivery_percentage'] = 0;
		$data['user'] = $this->user_model->get_dealer($data['user_id']);

		// ORDERS //
		$order_param = array();

		$order_param['status'] = 0;
		$count_result = $this->lead_model->get_orders_count($order_param, $data['user_id']);
		$data['new_orders_count'] = $count_result['cnt'];

		$order_param['status'] = 1;
		$count_result = $this->lead_model->get_orders_count($order_param, $data['user_id']);
		$data['deliveries_pending_count'] = $count_result['cnt'];

		$order_param['status'] = 2;
		$count_result = $this->lead_model->get_orders_count($order_param, $data['user_id']);
		$data['delivered_count'] = $count_result['cnt'];

		$count_result = $this->request_model->get_dealer_quote_requests_count($data['user_id'], 2);
		$data['tenders_won_count'] = $count_result['cnt'];

		$count_result = $this->request_model->get_dealer_quote_requests_count($data['user_id'], 0);
		$data['quote_requests_count'] = $count_result['cnt'];

		$data['newest_orders'] = $this->lead_model->get_newest_orders($data['user_id']);

		$data['incoming_deliveries'] = $this->lead_model->get_incoming_deliveries($data['user_id']);		

		// LEADS //
		$leads_arr = array();
		$dealership_brands_arr = explode(',', $data['user']['dealership_brand']);

		$data['makes'] = $this->user_model->get_makes();
		$data['states'] = ['ACT','NSW','NT','QLD','SA','TAS','VIC','WA'];

		$this->load->view('home_dealer', $data);		
	}
	
	public function generate_users_html ()
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;
		
		$input_arr = $this->input->post();
		
		$users = $this->user_model->get_users($input_arr);
		if (count($users) > 0)
		{
			$html = '
			<div class="table-responsive" style="white-space: nowrap;">
				<table class="table table-bordered table-striped table-condensed mb-none">
					<thead>
						<tr>
							<th></th>
							<th>Type</th>
							<th>Name</th>							
							<th>Email</th>
							<th>Phone</th>
							<th>Mobile</th>
							<th>Postcode</th>
							<th>State</th>
						</tr>
					</thead>
					<tbody>';
						foreach($users as $user)
						{
							$html .= '
							<tr id="user_'.$user['id_user'].'">
								<td align="center">
									<span onclick="select_user(\''.$input_arr['container'].'\', '.$user['id_user'].')" style="cursor: pointer; cursor: hand; color: #58c603;">
										<i class="fa fa-plus"></i>
									</span>
								</td>
								<td id="type_'.$user['id_user'].'">'.$user['type_text'].'</td>
								<td id="name_'.$user['id_user'].'">'.$user['name'].'</td>
								<td id="email_'.$user['id_user'].'">'.$user['username'].'</td>
								<td id="phone_'.$user['id_user'].'">'.$user['phone'].'</td>
								<td id="mobile_'.$user['id_user'].'">'.$user['mobile'].'</td>
								<td id="postcode_'.$user['id_user'].'">'.$user['postcode'].'</td>
								<td id="state_'.$user['id_user'].'">'.$user['state'].'</td>
							</tr>';
						}
						$html .= '
					</tbody>
				</table>
			</div>';
		}
		else
		{
			$html = '
			<div class="table-responsive">
				<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
					<thead>						
						<tr>
							<th></th>
							<th>Type</th>
							<th>Name</th>							
							<th>Email</th>
							<th>Phone</th>
							<th>Mobile</th>
							<th>Postcode</th>
							<th>State</th>
						</tr>
					</thead>					
					<tbody>
						<tr><td colspan="8"><center><i>No records found!</i></center></td></tr>
					</tbody>
				</table>
			</div>';
		}
		echo $html;		
	}
	
	public function record ($user_id)
	{
		$data = $this->data;
		$data['title'] = 'User';

		$user = $this->user_model->get_user($user_id);

		$data['user'] = $user;
		$data['comments'] = array();
		$data['audit_trails'] = array();
		$data['files'] = array();

		$this->load->view('admin/user', $data);
	}
	
	public function update_record ()
	{
		
	}

	public function change_password () // PAGE VIEW
	{
		$data = $this->data;			
		$data['title'] = "Change Password";

		$this->load->helper(array('form'));
		$this->load->view('change_password', $data);
	}

	public function check_current_password ($current_password, $user_id) // PAGE ACTION
	{
		$result = $this->user_model->check_password($current_password, $user_id);

		if($result)
		{
			$this->form_validation->set_message('check_current_password', 'Current Password is correct!');
			return true;
		}
		else
		{
			$this->form_validation->set_message('check_current_password', 'Current Password is incorrect!');
			return false;
		}
	}

	public function generate_tender_details_json ()
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;
		
		$input_arr = $this->input->post();
		
		$lead = $this->lead_model->get_lead($input_arr['id_lead']);
		echo json_encode($lead); die();
		$options = $this->request_model->get_quote_request_options($input_arr['id_quote_request']);
		$accessories = $this->request_model->get_quote_request_accessories($input_arr['id_quote_request']);

		$options_html = '';
		if (count($options)<>0)
		{		
			$options_html .= '
			<div class="table-responsive">
				<table class="table table-bordered table-striped table-condensed mb-none">
					<tbody>
					<tr><td colspan="2"><b>Options</b></td></tr>';	
					foreach ($options as $option_index => $option)
					{
						$options_html .= '
						<tr>
							<td width="70%">'.$option->name.'</td>
							<td>
								<input type="hidden" name="option_id_'.$option_index.'" value="'.$option->id_quote_request_option.'">
								<input type="hidden" name="option_name_'.$option_index.'" value="'.$option->name.'">
								<input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="option_'.$option_index.'" name="option_'.$option_index.'" type="text" placeholder="0" onchange="calculate_quote_new(\'#add_quote_modal\')" required>
							</td>
						</tr>';
					}
					$options_html .= '
					</tbody>
				</table>
			</div>
			<br />';
		}

		$accessories_html = '';
		if (count($accessories)<>0)
		{	
			$accessories_html .= '
			<div class="table-responsive">
				<table class="table table-bordered table-striped table-condensed mb-none">
					<tbody>
					<tr><td colspan="2"><b>Accessories</b></td></tr>';	
					foreach ($accessories AS $accessory_index => $accessory)
					{
						$accessories_html .= '
						<tr>
							<td width="70%">'.$accessory->name.'</td>
							<td>
								<input type="hidden" name="accessory_id_'.$accessory_index.'" value="'.$accessory->id_quote_request_accessory.'">
								<input type="hidden" name="accessory_name_'.$accessory_index.'" value="'.$accessory->name.'">
								<input value="0" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="accessory_'.$accessory_index.'" name="accessory_'.$accessory_index.'" type="text" placeholder="0" onchange="calculate_quote_new(\'#add_quote_modal\')" required>
							</td>
						</tr>';
					}
					$accessories_html .= '
					</tbody>
				</table>
			</div>
			<br />';					
		}

		$output_arr = array(
			"id_lead" => $input_arr['id_lead'],		
			"id_quote_request" => $input_arr['id_quote_request'],
			"state" => $lead['state'],
			"tradein_count" => $lead['tradein_count'],
			"make" => $lead['tender_make'],
			"model" => $lead['tender_model'],
			"variant" => $lead['tender_variant'],
			"build_date" => $lead['build_date'],
			"colour" => $lead['colour'],
			"registration_type" => $lead['registration_type'],
			"options_html" => $options_html,
			"accessories_html" => $accessories_html
		);
		echo json_encode($output_arr);
	}	
	
	public function generate_quote_json ()
	{
		$data = $this->data;
		
		$input_arr = $this->input->post();
		
		$quote = $this->quote_model->get_quote_all($input_arr['id_quote']);
		$quote_options = $this->quote_model->get_quote_options_array($input_arr['id_quote']);
		$quote_accessories = $this->quote_model->get_quote_accessories_array($input_arr['id_quote']);

		$output_arr = array(
			'demo'        			=> $quote['demo'],
		
			'delivery_date'         => $quote['delivery_date'],
			'compliance_date'       => $quote['compliance_date'],		
		
			'vin'                   => $quote['vin'],
			'engine'                => $quote['engine'],
			'registration_plate'    => $quote['registration_plate'],
			'registration_expiry'   => $quote['registration_expiry'],
			'kms'                   => $quote['kms'],
			'notes'                 => $quote['notes'],		

			'retail_price'          => $quote['retail_price'],
			'metallic_paint'		=> $quote['metallic_paint'],
			'predelivery'           => $quote['predelivery'],
			'fleet_discount'        => $quote['fleet_discount'],
			'dealer_discount'       => $quote['dealer_discount'],

			'luxury_tax'            => $quote['luxury_tax'],
			'ctp'                   => $quote['ctp'],
			'registration'          => $quote['registration'],
			'premium_plate_fee'     => $quote['premium_plate_fee'],
			'stamp_duty'            => $quote['stamp_duty'],
			
			'dealer_tradein_value'  => $quote['dealer_tradein_value'],
			'dealer_tradein_payout' => $quote['dealer_tradein_payout'],
			'dealer_client_refund'  => $quote['dealer_client_refund'],
			
			'options'				=> $quote_options,
			'accessories'			=> $quote_accessories,

			'transport_checkbox'    => $quote['transport_checkbox']
		);
		echo json_encode($output_arr);
	}	
	
	public function send_quote () // AUDIT TRAIL //
	{
		$return = array();
		$now = date("Y-m-d H:i:s");
		$data = $this->data;
		
		$process_error = array();
		$input_arr = $this->input->post();

		//$input_arr['delivery_date_time'] = isset($input_arr['time']) ? date('Y-m-d H:i:s', strtotime($input_arr['date'].' '.$input_arr['time'])) : null;
		unset($input_arr['time']);
		unset($input_arr['date']);
		$lead = $this->lead_model->get_lead($input_arr['id_lead']);
		$input_arr['make'] = $lead['id_make'];
		$input_arr['modal'] = $lead['id_family'];
		$input_arr['rb_data'] = $lead['rb_data'];
	
		$dealer_id = 0;
		if ($data['login_type']=='Admin')
		{
			$input_arr['sender'] = 'Dealer';
			if ($input_arr['process'] == "insert")
			{
				$dealer_id = $input_arr['dealer_id'];
			}
			else if ($input_arr['process'] == "update")
			{
				$quote = $this->quote_model->get_quote_all($input_arr['id_quote']);
				$dealer_id = $quote['fk_user'];
			}
		}
		else
		{
			$input_arr['sender'] = 'Dealer';
			$dealer_id = $data['user_id'];
		}		

		if ($dealer_id <> 0)
		{
			$option_index = 0;
			$options_total = 0;
			while (isset($input_arr['option_id_'.$option_index]))
			{
				$current_option = 0;
				if ($input_arr['option_'.$option_index] <> '')
				{
					$current_option = $input_arr['option_'.$option_index];
				}
				else
				{
					$current_option = 0;
				}
				$options_total = $options_total + $current_option;					
				$option_index ++;
			}			

			$accessory_index = 0;
			$accessories_total = 0;
			while (isset($input_arr['accessory_id_'.$accessory_index]))
			{
				$current_accessory = 0;
				if ($input_arr['accessory_'.$accessory_index] <> '')
				{
					$current_accessory = $input_arr['accessory_'.$accessory_index];
				}
				else
				{
					$current_accessory = 0;
				}
				$accessories_total = $accessories_total + $current_accessory;
				$accessory_index ++;
			}

			if ($lead['registration_type']=="Exempt" OR $lead['registration_type']=="TPI/Gold Card")
			{
				$input_arr['gst'] = 0;
				$input_arr['stamp_duty'] = 0;
			}
			else
			{
				$input_arr['gst'] = ($input_arr['retail_price'] + $input_arr['metallic_paint'] + $options_total + $accessories_total + $input_arr['predelivery'] - $input_arr['fleet_discount'] - $input_arr['dealer_discount']) * 0.10;
			}
			
			$input_arr['total'] = $input_arr['retail_price'] + $input_arr['metallic_paint'] + $options_total + $accessories_total + $input_arr['predelivery'] + $input_arr['gst'] + $input_arr['stamp_duty'] + $input_arr['registration'] + $input_arr['premium_plate_fee'] + $input_arr['ctp'] + $input_arr['luxury_tax'] - $input_arr['fleet_discount'] - $input_arr['dealer_discount'];
			$input_arr['dealer_changeover'] = $input_arr['total'] - $input_arr['dealer_tradein_value'] + $input_arr['dealer_tradein_payout'] + $input_arr['dealer_client_refund'];

			/*			
			$update_trail_arr = [
				'retail_price'          => $input_arr['retail_price'],
				'metallic_paint'        => $input_arr['metallic_paint'],
				'dealer_discount'       => $input_arr['dealer_discount'],				
				'fleet_discount'        => $input_arr['fleet_discount'],
				'predelivery'           => $input_arr['predelivery'],
				'gst'                   => $input_arr['gst'],
				'luxury_tax'            => $input_arr['luxury_tax'],
				'ctp'                   => $input_arr['ctp'],
				'registration'          => $input_arr['registration'],
				'premium_plate_fee'     => $input_arr['premium_plate_fee'],
				'stamp_duty'            => $input_arr['stamp_duty'],
				'delivery_date'         => $input_arr['delivery_date'],
				'compliance_date'       => $input_arr['compliance_date'],
				'notes'                 => $input_arr['notes'],
				'kms'                   => $input_arr['kms'],
				'vin'                   => $input_arr['vin'],
				'engine'                => $input_arr['engine'],
				'registration_expiry'   => $input_arr['registration_expiry'],
				'registration_plate'    => $input_arr['registration_plate'],
				'transport_checkbox'    => $input_arr['transport_checkbox'],
				'total'					=> $total,
				'dealer_tradein_value'  => $input_arr['dealer_tradein_value'],
				'dealer_tradein_payout' => $input_arr['dealer_tradein_payout'],
				'dealer_client_refund'  => $input_arr['dealer_client_refund'],				
				'dealer_changeover'     => $dealer_changeover
			];

			$update_trail_arr['total'] = $total;
			$label_arr = [];
			
			$option_index = 0;
			while ($input_arr['option_id_'.$option_index])
			{
				$curr_opt = 0;
				if ($input_arr['option_'.$option_index] == '')
				{
					$curr_opt = 0;
				}
				else
				{
					$curr_opt = $input_arr['option_'.$option_index];
				}

				if ($input_arr['process'] == "update")
				{
					$update_trail_arr[$input_arr['option_name_'.$option_index]] = $curr_opt;
					$label_arr[] = $input_arr['option_label_'.$option_index];
				}
				$option_index ++;
			}

			$accessory_index = 0;
			while ($input_arr['accessory_id_'.$accessory_index])
			{
				$curr_acc = 0;
				if (trim($input_arr['accessory_'.$accessory_index]) == '')
				{
					$curr_acc = 0;
				}
				else
				{
					$curr_acc = $input_arr['accessory_'.$accessory_index];
				}

				if ($input_arr['process'] == "update")
				{
					$update_trail_arr[$input_arr['accessory_name_'.$accessory_index]] = $curr_acc;
					$label_arr[] = $input_arr['accessory_label_'.$accessory_index];
				}
				$accessory_index ++;
			}

			if ($input_arr['process'] == "update")
			{
				$this->quote_update_trail($update_trail_arr, $input_arr['id_quote'], $label_arr);
			}
			*/
			if ($input_arr['process'] == "insert")
			{
				$myFlag = false;
				$insert_data = array(
                    'fk_quote_request' => $this->db->escape_str($input_arr['id_quote_request']),
                    'fk_user' => $dealer_id,
                    'status' => 1,
                    'sender' => 'Dealer',
                    'transport_checkbox' => '',
                    'on_road' => $this->db->escape_str($input_arr['on_road']),
                    'delivery_date' => $this->db->escape_str($input_arr['delivery_date']),
                    //'sender_new' => $this->db->escape_str($input_arr['sender_new']),
                    'quoted_price' => $this->db->escape_str($input_arr['quoted_price']),                                    
                );

				$this->load->model('fapplication_model');
				$funded_id_quote = $this->fapplication_model->get_column_value_by_id('quotes','id_quote',$insert_data);
				if (isset($funded_id_quote) && !empty($funded_id_quote)) {
                	$process_error[] = 'Duplicate Quote Submitted.';
                	$myFlag = true;
                	$insert_quote_result = true;
                }
                else {

                	$myFlag = false;

	                $insert_quote_result = $this->quote_model->insert_quotation($input_arr['id_quote_request'], $dealer_id, $input_arr);
					$quote_id = $this->db->insert_id();

					if ($quote_id > 0) {
						$file_element_name = 'quote_file';
						$config['upload_path'] = './uploads/quote_files/';
						$config['allowed_types'] = '*';
						$config['overwrite'] = TRUE;
						$config['encrypt_name'] = FALSE;
						$config['remove_spaces'] = TRUE;
						$newFileName = $_FILES['quote_file']['name'];
						$tmp = explode('.', $newFileName);
						$file_extension = end($tmp);
						$filename = $quote_id."_".time().".".$file_extension;
						$config['file_name'] = $filename;
						if(!is_dir($config['upload_path'])){
							mkdir($config['upload_path'],0777,TRUE);
						}
						$this->load->library('upload', $config);
						if (!$this->upload->do_upload($file_element_name)){
							$return['Uploaderror'] = $this->upload->display_errors();
						}
						$file_data = $this->upload->data();
						if(!empty($file_data['file_name']) && !empty($file_extension)){
							$f_data['quote_file'] = $file_data['file_name'];
							$f_where_array['id_quote'] = $quote_id;
							$file_id = $this->quote_model->update('quotes', $f_data, $f_where_array);	
						}
						@unlink($_FILES[$file_element_name]);
					}
					
					if ($lead['qs_id'] <> $data['user_id'])
					{
						$notification_message = 'New <b>'.$input_arr['demo'].'</b> quote added by <b>'.$data['name'].'</b> on <b><a href="'.site_url('lead/record_final/'.$input_arr['id_lead']).'" target="_blank">'.$lead['cq_number'].'</a></b>';
						$this->notification_model->add_notification(1, $notification_message);
						$notification_id = $this->db->insert_id();
						$this->notification_model->add_notification_user($notification_id, $lead['qs_id']);					
					}

					$audit_trail_arr = array(
						'id' => $input_arr['id_lead'],
						'table_name' => 'leads',
						'action' => 37,
						'description' => '[{"quote_id":"'.$quote_id.'"}]'
					);
					$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);
                }
			}
			else if ($input_arr['process'] == "update")
			{
				$update_quote_result = $this->quote_model->update_quotation($input_arr['id_quote'], $input_arr);
				$quote_id = $input_arr['id_quote'];

				if ($lead['qs_id'] <> $data['user_id'])
				{
					$notification_message = 'Quote (<b>'.$input_arr['demo'].'</b>) edited by <b>'.$data['name'].'</b> on <b><a href"'.site_url('lead/record_final/'.$input_arr['id_lead']).'" target="_blank">'.$lead['cq_number'].'</a></b>';
					$this->notification_model->add_notification(1, $notification_message);
					$notification_id = $this->db->insert_id();
					$this->notification_model->add_notification_user($notification_id, $lead['qs_id']);
				}

				$audit_trail_arr = array(
					'id' => $input_arr['id_lead'],
					'table_name' => 'leads',
					'action' => 38,
					'description' => '[{"quote_id":"'.$quote_id.'"}]'
				);
				$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);
			}

			$option_index = 0;
			$current_option_id = 0;
			while (isset($input_arr['option_id_'.$option_index]))
			{
				$current_option = 0;
				if ($input_arr['option_'.$option_index] == '')
				{
					$current_option = 0;
				}
				else
				{
					$current_option = $input_arr['option_'.$option_index];
				}
				$current_option_id = $input_arr['option_id_'.$option_index];
				
				if ($input_arr['process'] == "insert")
				{
					$insert_option_result = $this->quote_model->insert_quotation_option($quote_id, $current_option_id, $current_option);
				}
				else if ($input_arr['process'] == "update")
				{
					$update_option_result = $this->quote_model->update_quotation_option($quote_id, $current_option_id, $current_option);
				}
				$option_index ++;
			}

			$accessory_index = 0;
			$current_accessory_id = 0;
			while (isset($input_arr['accessory_id_'.$accessory_index]))
			{
				$current_accessory = 0;
				if (trim($input_arr['accessory_'.$accessory_index]) == '')
				{
					$current_accessory = 0;
				}
				else
				{
					$current_accessory = $input_arr['accessory_'.$accessory_index];
				}
				$current_accessory_id = $input_arr['accessory_id_'.$accessory_index];

				if ($input_arr['process'] == "insert")
				{
					$insert_accessory_result = $this->quote_model->insert_quotation_accessory($quote_id, $current_accessory_id, $current_accessory);
				}
				else if ($input_arr['process'] == "update")
				{
					$update_accessory_result = $this->quote_model->update_quotation_accessory($quote_id, $current_accessory_id, $current_accessory);
				}
				$accessory_index ++;
			}

			if ($input_arr['process'] == "insert")
			{
				if (!$insert_quote_result) { $process_error[] = "Quote not successfully added"; }	

				if ($option_index > 0)
				{
					if (!$insert_option_result) { $process_error[] = "Option price not successfully added"; }		
				}
				
				if ($accessory_index > 0)
				{
					if (!$insert_accessory_result) { $process_error[] = "Accessory price not successfully added"; }			
				}				
			}
			else if ($input_arr['process'] == "update")
			{
				if (!$update_quote_result) { $process_error[] = "Quote not successfully updated"; }
				
				if ($option_index > 0)
				{
					if (!$update_option_result) { $process_error[] = "Option price not successfully updated"; }					
				}
				
				if ($accessory_index > 0)
				{
					if (!$update_accessory_result) { $process_error[] = "Accessory price not successfully updated"; }			
				}
			}
		}
		else
		{
			$process_error[] = "Dealer is missing";
		}

		if (count($process_error)==0)
		{
			//echo "success";
            $return['success'] = true;
		}
		else
		{
			//echo "fail";
            $return['success'] = false;
            if($myFlag) {
            	$return['message'] = $process_error[0];
            }
		}
        print json_encode($return);
        exit;
	}
	
	public function leave_message () // AUDIT TRAIL OK //
	{
		$data = $this->data;
		$input_arr = $this->input->post();

		$insert_result = $this->user_model->insert_user_message($data['user_id'], $input_arr);

		if ($insert_result)
		{
			$audit_trail_arr = array(
				'id' => '0',
				'table_name' => 'user_messages',
				'action' => 47,
				'description' => '[{"message":"'.$input_arr['message'].'"}]'
			);			
			$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);		
		}		
	}

	public function orders ($start = 0) // PAGE VIEW 
	{
		$data = $this->data;
		$data['title'] = 'Orders';

		$limit = 10;
		$count_result = $this->lead_model->get_orders_count($_GET, $data['user_id']);  // Record count
		$data['orders'] = $this->lead_model->get_orders($_GET, $data['user_id'], $start, $limit); // Main Query

		$data['id_user'] = $data['user_id'];

		$this->load->library('pagination');
		$config['base_url'] = site_url('user/orders/');
		$config['total_rows'] = $count_result['cnt'];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);
		$data['links'] = $this->pagination->create_links();

		$data['user_signature'] = $this->user_model->get_user_signature($data['user_id']);

		$data['order_status'] = isset($_GET['status']) ? $_GET['status'] : 0;
		$data['result_count'] = $count_result['cnt'];
		
		// if ($data['user_id']==217)
		// {
			$this->load->view('orders', $data);	
		// }
		// else
		// {
		// 	$this->load->view('orders_backup', $data);	
		// }
	}

	public function generate_deal_agreement_wizard_json ($lead_id)
	{
		$data = $this->data;

		$lead = $this->lead_model->get_lead($lead_id);
		$lead_calculation_details = $this->calculate_revenue($lead);
		$accessories = $this->request_model->get_quote_request_accessories($lead['id_quote_request']);
		$options = $this->request_model->get_quote_request_options($lead['id_quote_request']);
		$tradeins = $this->tradein_model->get_attached_tradeins($lead_id);

		$make_logo = base_url("assets/img/makes/".str_replace(' ', '_', strtolower($lead['tender_make'])).".png");
		if ($lead['delivery_date'] == "") { $lead['delivery_date'] = "N/A"; }
		if ($lead['delivery_address'] == "") { $lead['delivery_address'] = "N/A"; }
		if ($lead['delivery_instructions'] == "") { $lead['delivery_instructions'] = "N/A"; }
		if ($lead['special_conditions'] == "") { $lead['special_conditions'] = "N/A"; }
	
		$quote_id = $lead['winner'];
		$quote = $this->quote_model->get_quote($lead['winner']);
		
		if (1==1)
		{
			$order_details = '
			<div class="row">
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-2">
							<img src="'.$make_logo.'" style="border: 1px solid #ddd;" width="100%">
							<br />
						</div>
						<div class="col-md-10">
							<h5 style="font-size: 1.5em; color: #58c603;"><b>'.$lead['build_date'].' '.$lead['tender_make'].' '.$lead['tender_model'].' ('.$lead['colour'].')</b></h5>
							<h5>'.$lead['tender_variant'].'</h5>
							<br />					
						</div>						
					</div>
					<br />';
					
					
					$order_details .= '
					<h5><b>Registration Type: </b>'.$lead['registration_type'].'</h5>						
					<br />					
					<h5><b>Factory-Fitted Options:</b></h5>';
					if (count($options)==0)
					{
						$order_details .= '<p><i>No records found..</i></p>';
					}
					else
					{
						$order_details .= '<ul>';
						foreach ($options AS $option)
						{
							$order_details .= '<li>'.$option->name.'</li>';
						}
						$order_details .= '</ul>';
					}
					$order_details .= '
					<br />
					<h5><b>Dealer-Fitted Accessories:</b></h5>';
					if (count($accessories)==0)
					{
						$order_details .= '<p><i>No records found..</i></p>';
					}
					else
					{
						$order_details .= '<ul>';
						foreach ($accessories AS $accessory)
						{
							$order_details .= '<li>'.$accessory->name.'</li>';
						}																											
						$order_details .= '</ul>';
					}
					
					$order_details .= '<br /><br />';
					$tradein_text = '';
					if ($lead['tradein_count']>0)
					{
						if ($lead['dealer_tradein_count']==0)
						{
							$tradein_text = '
							<p>There is a trade vehicle and the dealer is not taking the trade.</p>
							<p>The dealer is aware that they must confirm a car is in stock and allow 3 days for the trade to be funded.</p>';
						}
						else
						{
							$tradein_text = '<p>There is a trade vehicle and the dealer is taking the trade.</p>';
						}
						
						$order_details .= '
						<br />
						<div class="alert alert-info">
							<h5><b>Trade In vehicle</b></h5>
							'.$tradein_text.'
							<br />
							<ul>';							
								foreach ($tradeins AS $tradein)
								{
									$order_details .= '
									<li>'.$tradein->tradein_make.' '.$tradein->tradein_model.' ('.$tradein->tradein_build_date.')</li>';
								}
								$order_details .= '
							</ul>
						</div>';						
					}

					if ($lead['deposit']==1)
					{
						$deposit_text = '
						<p>
							The Deposit Of $1000.00 Will be refunded at delivery once the supplying dealer has delivered the car and notifies 
							'.$data['company']['company_name'].' that the vehicle has been paid In full. 
						</p>
						<p>
							The '.$data['company']['company_name'].' Invoice being paid will action its release.					
						</p>';
					}
					else if ($lead['deposit']==2)
					{
						$deposit_text = '
						<p>
							Deposit will be transferred to the dealer 24 hours before delivery when the dealer sends a copy of the tax
							invoice showing the vin chassis or registration number. 						
						</p>
						<p>
							This deposit is forwarded less any corresponding '.$data['company']['company_name'].' invoice to the dealer
						</p>
						';
					}
					else if ($lead['deposit']==3)
					{
						$deposit_text = '
						<p>
							The dealership has taken the deposit and will fund '.$data['company']['company_name'].' an invoice of $______ 3 to 5 days post delivery
						</p>';
					}
					else if ($lead['deposit']==4)
					{
						$deposit_text = '
						<p>
							Deposit will be transferred to the dealer 24 hours before delivery when the dealer sends a copy of the 
							tax invoice showing the vin chassis or registration number.
						</p>
						<p>
							The dealer is to fund any corresponding invoice 24 hours after delivery.
						</p>';
					}
					else					
					{
						$deposit_text = 'N/A';
					}

					$order_details .= '
					<div class="alert alert-info">
						<h5><b>Deposit</b></h5>
						'.$deposit_text.'						
					</div>';
					
					$order_details .= '
					<div class="alert alert-warning">
						<h5><b>Finance and Aftermarket</b></h5>
						<p>The dealer will not approach the client for the selling of aftermarket and finance products</p>
					</div>';				
					
					$order_details .= '
				</div>';
				
				$client_payment_to_dealer = 0;
				$qm_payment_to_dealer = 0;
				$qm_invoice_to_dealer = 0;				

				if ($lead['deposit']==1)
				{
					$client_payment_to_dealer = $lead['sales_price'];
					$qm_payment_to_dealer = 0;
					$qm_invoice_to_dealer = $lead_calculation_details['revenue'];
				}
				else if ($lead['deposit']==2)
				{
					$client_payment_to_dealer = $lead['sales_price'] - $lead['deposits_total'] - $lead['refunds_total'];
					$qm_payment_to_dealer = $lead['winning_price'] - ($lead['sales_price'] - $lead['deposits_total'] - $lead['refunds_total']);
					$qm_invoice_to_dealer = 0;
				}
				else if ($lead['deposit']==3)
				{
					$client_payment_to_dealer = $lead['sales_price'];
					$qm_payment_to_dealer = 0;
					$qm_invoice_to_dealer = $lead_calculation_details['revenue'];					
				}
				else if ($lead['deposit']==4)
				{
					$client_payment_to_dealer = $lead['sales_price'] - $lead['deposits_total'] - $lead['refunds_total'];
					$qm_payment_to_dealer = $lead['deposits_total'] - $lead['refunds_total'];
					$qm_invoice_to_dealer = $lead_calculation_details['revenue'];					
				}				
				
				$subtotal_1 = $quote['retail_price'] - $quote['dealer_discount'] - $quote['fleet_discount'];
				$order_details .= '
				<div class="col-md-6">
					<h5><b>DEALERSHIP QUOTE</b> &nbsp;(Q'.$quote['id_quote'].')</h5>
					<br />
					<table class="table table-condensed table-bordered mb-none">
						<tr><td width="70%">List Price</td><td align="right">$ '.$quote['retail_price'].'</td></tr>
						<tr><td>Discount (-)</td><td align="right">$ '.$quote['dealer_discount'].'</td></tr>						
						<tr><td>Fleet Claim (-)</td><td align="right">$ '.$quote['fleet_discount'].'</td></tr>
						<tr><td><b>SUBTOTAL</b></td><td align="right">$ '.$subtotal_1.'</td></tr>				
					</table>
					<br />';
					$order_details .= '
					<h5><b>Factory-Fitted Options</b></h5>
					<table class="table table-condensed table-bordered mb-none">';
						$options_total = 0;
						$options_query = "
						SELECT o.name, qo.price
						FROM quote_request_options qro 
						JOIN quote_options qo ON qro.id_quote_request_option = qo.fk_request_option
						JOIN options o ON qro.fk_option = o.id_option
						WHERE qo.fk_quote = ".$quote_id." ORDER BY qro.id_quote_request_option ASC";
						$options_result = $this->db->query($options_query);
						if (count($options_result->result())==0)
						{
							$order_details .= '<tr><td colspan="2">No options included</td></tr>';
						}
						else
						{
							foreach ($options_result->result() as $options_row)
							{
								$order_details .= '
								<tr>
									<td width="70%">'.$options_row->name.'</td>
									<td align="right">$ '.$options_row->price.'</td>
								</tr>';
								$options_total = $options_total + $options_row->price;
							}
						}
						$order_details .= '
					</table>
					<br />';
					$order_details .= '
					<h5><b>Dealer-Fitted Accessories</b></h5>
					<table class="table table-condensed table-bordered mb-none">';
						$accessories_total = 0;
						$accessories_query = "
						SELECT qra.name, qa.price
						FROM quote_request_accessories qra
						JOIN quote_accessories qa ON qra.id_quote_request_accessory = qa.fk_request_accessory
						WHERE qa.fk_quote = ".$quote_id." ORDER BY qra.id_quote_request_accessory ASC";
						$accessories_result = $this->db->query($accessories_query);
						if (count($accessories_result->result())==0)
						{
							$order_details .= '<tr><td colspan="2">No accessories included</td></tr>';
						}
						else
						{
							foreach ($accessories_result->result() as $accessories_row)
							{
								$order_details .= '
								<tr>
									<td width="70%">'.$accessories_row->name.'</td>
									<td align="right">$ '.$accessories_row->price.'</td>
								</tr>';
								$accessories_total = $accessories_total + $accessories_row->price;
							}
						}
						$order_details .= '
					</table>
					<br />';			

					$subtotal_2 = $subtotal_1 + $options_total + $accessories_total + $quote['predelivery'];
					$subtotal_3 = $subtotal_2 + $quote['gst'];
					$total_inc_gst = $subtotal_3 + $quote['luxury_tax'] + $quote['ctp'] + $quote['registration'] + $quote['premium_plate_fee'] + $quote['stamp_duty'];
					
					$order_details .= '
					<table class="table table-condensed table-bordered mb-none">
						<tr><td width="70%">Delivery Charge</td><td align="right">$ '.$quote['predelivery'].'</td></tr>
						<tr><td><b>SUBTOTAL</b></td><td align="right">$ '.$subtotal_2.'</td></tr>
					</table>
					<br />
					<table class="table table-condensed table-bordered mb-none">
						<tr><td width="70%">GST</td><td align="right">$ '.$quote['gst'].'</td></tr>
						<tr><td><b>SUBTOTAL</b></td><td align="right">$ '.$subtotal_3.'</td></tr>
					</table>
					<br />';
					$order_details .= '
					<table class="table table-condensed table-bordered mb-none">
						<tr><td width="70%">Luxury Tax</td><td align="right">$ '.$quote['luxury_tax'].'</td></tr>
						<tr><td>CTP</td><td align="right">$ '.$quote['ctp'].'</td></tr>
						<tr><td>Registration</td><td align="right">$ '.$quote['registration'].'</td></tr>
						<tr><td>Premium Plate Fee</td><td align="right">$ '.$quote['premium_plate_fee'].'</td></tr>										
						<tr><td>Stamp Duty</td><td align="right">$ '.$quote['stamp_duty'].'</td></tr>
						<tr><td><b>TOTAL INC GST</b></td><td align="right"><b>$ '.$quote['total'].'</b></td></tr>
					</table>
					<br />
					<table class="table table-condensed table-bordered mb-none">
						<tr><td width="70%"><b>Client Purchase Price</b></td><td align="right">$ '.$lead['sales_price'].'</td></tr>
						<tr><td><b>Client Payment To Dealer</b></td><td align="right">$ '.$client_payment_to_dealer.'</td></tr>
						<tr><td><b>'.$data['company']['company_name'].' Payment To Dealer</b></td><td align="right">$ '.$qm_payment_to_dealer.'</td></tr>
						<tr><td><b>'.$data['company']['company_name'].' Invoice To Dealer</b></td><td align="right">$ '.$qm_invoice_to_dealer.'</td></tr>
					</table>
					<br />					
				</div>
			</div>';			
		}
		
		if (1==1)
		{
			$delivery_details = '
			<div class="row">			
				<div class="col-md-12">';
			
					$transport_text = '';
					if ($lead['transport']==1)
					{
						$transport_text = '<p>The dealer will deliver the car to the client with a full tank of petrol and in immaculate condition.</p>';
					}
					else if ($lead['transport']==2)
					{
						$transport_text = '<p>The client will attend the dealership to take delivery.</p>';
					}
					else if ($lead['transport']==3)
					{
						$transport_text = '<p>'.$data['company']['company_name'].' is organising the transport to the client.</p>';
					}
					else
					{
						$transport_text = 'N/A';
					}
					
					if ($lead['state']<>$lead['dealer_state'])
					{
						$transport_text .= '<p>This car is being driven interstate and needs a permit to be supplied valid for 3 days.</p>';
					}
					
					$delivery_details .= '
					<div class="alert alert-info">
						<h5><b>Transport of the new vehicle</b></h5>
						'.$transport_text.'						
					</div>';
				
					$delivery_details .= '
					<br />
					<h5><b>Please enter the estimated delivery date of the new vehicle:</b></h5>
					<div class="row">
						<div class="col-md-4">
							<input type="hidden" name="order_date" id="order_date" value="'.$lead['order_date'].'" /> 
							<input value="" class="form-control input-sm datepicker" data-date-format="yyyy-mm-dd" type="text" id="delivery_date_input" name="delivery_date" required>
						</div>
					</div>
					<br />					
					<h5><b>Delivery Address:</b></h5>
					<p style="margin-bottom: 30px;">'.$lead['delivery_address'].'</p>														
					<h5><b>Delivery Instructions:</b></h5>
					<p style="margin-bottom: 30px;">'.$lead['delivery_instructions'].'</p>														
					<h5><b>Special Conditions:</b></h5>
					<p style="margin-bottom: 30px;">'.$lead['special_conditions'].'</p>				
				</div>								
			</div>';
		}
		
		$lead_arr = array(
			"lead_id"      			=> $lead_id,
			"order_details"  		=> $order_details,
			"delivery_details"  	=> $delivery_details
		);

		echo json_encode($lead_arr);		
	}

	public function confirm_order () // AUDIT TRAIL OK //
	{
		$data = $this->data;
		$input_arr = $this->input->post();

		$lead = $this->lead_model->get_lead($input_arr['id_lead']);
		
		$update_arr = array(
			'id_lead' => $input_arr['id_lead'],
			'dealer_status' => 1
		);
		$this->lead_model->update_lead_details($update_arr);

		$from_email = $data['company']['company_email'];
		$from_name = $data['company']['company_name'];
		$to = $lead['email'];
		$subject = "Dealer Confirmation Received";
		
		$content = '
		<p style="line-height: 1.5">
			The dealer that was nominated to supply your new car is: '.$lead['dealership_name'].'
		</p>
		<p style="line-height: 1.5">
			They have confirmed the new car order and will be contacting you soon. Please feel free to contact 
			the fleet manager shown if you have any questions.				
		</p>
		<p style="line-height: 1.5">
			'.$lead['fleet_manager'].'<br />
			'.$lead['dealership_name'].'<br />
			'.$lead['dealer_address'].'<br />
			'.$lead['dealer_state'].' '.$lead['dealer_postcode'].'<br />
			'.$lead['dealer_phone'].'<br />
			'.$lead['dealer_mobile'].'
		</p>
		<p style="line-height: 1.5">
			The dealership supplying the new car will now take over as your primary point of contact. They will 
			pre deliver the car and supply it to you with a run thru on how the vehicles features operate. 
		</p>
		<p style="line-height: 1.5">
			<br><br>
			Thank you for your business,
			<br>
			<b>'.$data['company']['company_name'].'</b>
		</p>';
		$this->send_templated_email ($from_email, $from_name, $to, $subject, $content, $file = "");			

		$audit_trail_arr = array(
			'id' => $input_arr['id_lead'],
			'table_name' => 'leads',
			'action' => 44,
			'description' => ''
		);
		$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);
		
		$notification_message ='The dealer approved the Deal <b><a href="#" class="open-lead-details" data-lead_id="'.$input_arr['id_lead'].'">'.$lead['cq_number'].'</a></b>';
		$this->notification_model->add_notification(1, $notification_message);
		$notification_id = $this->db->insert_id();
		$this->notification_model->add_notification_user($notification_id, $lead['qs_id']);
		
		if ($lead['delivery_date'] <> $input_arr['delivery_date'])
		{
			$update_arr = array(
				'id_lead' => $input_arr['id_lead'],
				'delivery_date' => $input_arr['delivery_date']
			);
			$this->lead_model->update_lead_details($update_arr);
			
			$from_email = $lead['qs_email'];
			$from_name = $lead['qs_name'];
			$to = $lead['email'];
			$subject = "Delivery Date Updated by Dealer";
			
			if (trim($lead['dealer_phone']) <> '' AND trim($lead['dealer_mobile']) <> '')
			{
				$dealer_contact_number = trim($lead['dealer_phone']).' or '.trim($lead['dealer_mobile']);
			}
			else if (trim($lead['dealer_mobile']) <> '')
			{
				$dealer_contact_number = trim($lead['dealer_mobile']);
			}
			else if (trim($lead['dealer_phone']) <> '')
			{
				$dealer_contact_number = trim($lead['dealer_phone']);
			}
				
			$content = '
			<p style="line-height: 1.5">
				Your supplying dealer '.$lead['dealership_name'].' has updated the delivery date on the portal 
				for '.$lead['cq_number'].' A 
				'.$lead['tender_make'].' '.$lead['tender_model'].' '.$lead['tender_variant'].' in '.$lead['colour'].'
			</p>
			<p style="line-height: 1.5">
				The new delivery date is <b>'.date('d F Y', strtotime($input_arr['delivery_date'])).'</b>			
			</p>
			<p style="line-height: 1.5">
				Please contact the dealer on '.$dealer_contact_number.' if you have any questions. You can 
				email him on '.$lead['dealer_email'].'.
			</p>			
			<p style="line-height: 1.5">
				<br><br>
				Thank you for your business,
				<br>
				<b>'.$data['company']['company_name'].'</b>
			</p>';
			$this->send_templated_email ($from_email, $from_name, $to, $subject, $content, $file = "");					
			
			$audit_trail_arr = array(
				'id' => $input_arr['id_lead'],
				'table_name' => 'leads',
				'action' => 45,
				'description' => '[{"date_from":"'.$lead['delivery_date'].'","date_to":"'.$input_arr['delivery_date'].'"}]'
			);
			$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);			
		}		

		echo "success";
	}

	public function deliver_order () // AUDIT TRAIL OK //
	{
		$data = $this->data;
		$input_arr = $this->input->post();
	
		$update_arr = array(
			'id_lead' => $input_arr['id_lead'],
			'dealer_status' => 2
		);
		$update_result = $this->lead_model->update_lead_details($update_arr);		
		
		if ($update_result)
		{
			$audit_trail_arr = array(
				'id' => $input_arr['id_lead'],
				'table_name' => 'leads',
				'action' => 46,
				'description' => ''
			);			
			$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);		
		}
	}

	public function update_delivery_date () // AUDIT TRAIL OK //
	{
		$data = $this->data;
		$input_arr = $this->input->post();

		$update_arr = array(
			'id_lead' => $input_arr['id_lead'],
			'delivery_date' => $input_arr['new_delivery_date']
		);
		$update_result = $this->lead_model->update_lead_details($update_arr);
		
		if ($update_result)
		{
			$audit_trail_arr = array(
				'id' => $input_arr['id_lead'],
				'table_name' => 'leads',
				'action' => 45,
				'description' => '[{"date_from":"'.$input_arr['current_delivery_date'].'","date_to":"'.$input_arr['new_delivery_date'].'"}]'
			);
			$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);		
		}		
	}	
	
	public function update_dealer_profile_old () // AJAX ACTION //
	{
		$data = $this->data;
		$input_arr = $this->input->post();

		$this->user_model->update_dealer_profile($data['user_id'], $input_arr);
	}	
	
	public function update_dealer_profile () // AJAX ACTION //
	{
		$data = $this->data;
		$input_arr = $this->input->post();

		$this->user_model->update_dealer_profile($data['user_id'], $input_arr);
		$this->session->set_flashdata("message","<div class='alert alert-success'>Profile updated successfully</div>");
		header("Location: ".site_url('user/profile'));
		exit();
	}

	public function update_wholesaler_profile () // PAGE ACTION 
	{
		$data = $this->data;
		$input_arr = $this->input->post();

		$this->user_model->update_wholesaler_profile($data['user_id'], $input_arr);

		header("Location: ".site_url('user/profile'));
		exit();
	}	

	public function update_user_password () // PAGE ACTION 
	{
		$data = $this->data;
		$input_arr = $this->input->post();
		
		$error = 0;

		if ($input_arr['password'] == "" OR $input_arr['confirm_password'] == "")
		{
			$error = 1;
		}

		if ($input_arr['password'] != $input_arr['confirm_password'])
		{
			$error = 1;
		}

		$current_password_result = $this->user_model->check_password($input_arr['current_password'], $data['user_id']);
		if (!$current_password_result)
		{
			$error = 1;
		}

		if ($error != 1)
		{
			$this->user_model->update_password($data['user_id'], md5($input_arr['password']));
			$result = true;
		}
		else
		{
			$result = false;
		}

		echo $result;
	}

	public function update_password () // PAGE ACTION 
	{
		$data = $this->data;
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('current_password', 'Current Password', 'trim|required|callback_check_current_password['.$data['user_id'].']');
		$this->form_validation->set_rules('password', 'New Password', 'trim|required|min_length[5]|max_length[25]|matches[confirm_password]|md5');
		$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'trim|required');

		if ($this->form_validation->run() == FALSE)
		{
			$data['title'] = "Change Password";
			$this->load->view('change_password', $data);
		}
		else
		{
			$this->user_model->update_password($data['user_id'], $this->input->post('password'));
			$this->session->set_flashdata("message","<div class='alert alert-success'>Password changed successfully</div>");
			header("Location: ".site_url('user/change_password'));
			exit();
		}
	}

	public function logout() // ACTION
	{
		
		$ip = $_SERVER['REMOTE_ADDR'];
		//$location = json_decode( file_get_contents( 'http://freegeoip.net/json/'.$ip ) );
		
		//print_r($location );
		
		$url='http://freegeoip.net/json/'.$ip;
		$handle=curl_init();
		$timeout=5;
		//$parameters = array("user_id"=>$user_id,"stream_id"=>$stream_id,"stream_operator"=>$stream_operator);
		curl_setopt($handle, CURLOPT_URL, $url);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, $timeout);
		//curl_setopt($handle, CURLOPT_POST, true);
		//curl_setopt($handle, CURLOPT_POSTFIELDS, $parameters);
		// Get URL content
		$location=curl_exec($handle);
		// close handle to release resources
		curl_close($handle);
		//output, you can also save it locally on the server
		//print_r($response);
		 $location=json_decode($location);
		 
		//exit;
		$date = Date('Y-m-d H:i:s');
		$loc = $location->city.' '.$location->region_name.' '.$location->country_name.' '.$location->zip_code;
		$desc = $this->session->userdata('username');
		
		$this->logs_model->insert_log( $this->session->userdata('username'), $ip, $desc, $loc, $date, '0000-00-00 00:00', '2' , '1' );
		
		$this->session->unset_userdata('logged_in');
		$this->session->unset_userdata('login_type');
		$this->session->unset_userdata('admin_type');
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('user_image');
		$this->session->unset_userdata('name');
		$this->session->unset_userdata('phone');
		$this->session->unset_userdata('mobile');
		$this->session->unset_userdata('state');
		$this->session->unset_userdata('postcode');
		$this->session->unset_userdata('status');
		$this->session->sess_destroy();
		session_start();
		session_destroy();
		
		redirect(site_url('login'));
		//header("Location: ".site_url('login'));
		//exit();
	}	
	
	public function profile () // PAGE VIEW
	{
		$data = $this->data;	
		$data['title'] = "Profile";
		
		if ($data['login_type']==1)
		{
			$data['user'] = $this->user_model->get_dealer($data['user_id']);
		}
		else if ($data['login_type']==3)
		{
			$data['user'] = $this->user_model->get_wholesaler($data['user_id']);
		}

		$this->load->helper(array('form'));
		$this->load->view('profile', $data);
	}

	
	public function quotation_requests ($status = 0) // DEALERS (PAGE VIEW)
	{
		$data = $this->data;
		$data['title'] = "Quotes";
		$data['status'] = $status;
		
		$data['quote_requests'] = $this->request_model->get_dealer_quote_requests($data['user_id'], $data['status']);
		
		$this->load->view('quotation_requests', $data);
	}
	
	public function quotation ($quote_id) // DEALER (MODAL VIEW)
	{
		if($this->session->userdata('logged_in'))
		{
			$quotation = "";
			$data['login_type'] = $this->session->userdata('login_type');
			$data['user_id'] = $this->session->userdata('user_id');

			$query = "
			SELECT 
			q.id_quote, q.fk_quote_request,
			q.delivery_date, q.compliance_date, q.build_date, q.notes, q.created_at,
			da.dealership_name as `dealer`, u.name as `manager_name`, u.username, u.postcode, u.state,
			m.name as `make`, f.name as `model`, v.name as `variant`,
			qr.series, qr.body_type, qr.colour, qr.transmission, qr.fuel_type, qr.registration_type, qr.build_date as `qr_build_date`,
			q.retail_price, q.fleet_discount, q.dealer_discount,
			q.predelivery, q.gst, q.luxury_tax, q.ctp, q.dealer_tradein_value, q.registration,
			q.premium_plate_fee, q.stamp_duty, q.total,	q.dealer_changeover,
			qr.winner, qr.accessories, q.accessories as accessories_price,
			q.build_date, q.compliance_date, q.demo, q.vin, q.engine, q.registration_plate, q.registration_expiry, q.kms
			FROM quotes q
			JOIN quote_requests qr ON q.fk_quote_request = qr.id_quote_request
			JOIN makes m ON qr.make = m.id_make
			JOIN families f ON qr.model = f.id_family
			LEFT JOIN vehicles v ON qr.variant = v.id_vehicle
			JOIN users u ON q.fk_user = u.id_user
			JOIN dealer_attributes da ON u.id_user = da.fk_user			
			WHERE 1 AND qr.deprecated <> 1 AND q.deprecated <> 1 AND q.id_quote = ".$quote_id." 
			GROUP BY q.id_quote LIMIT 1";
			$result = $this->db->query($query);
			foreach ($result->result() as $row)
			{
				if ($row->notes=="")
				{
					$dealer_notes = "<i>n/a</i>";
				}
				else
				{
					$dealer_notes = $row->notes;
				}

				$quotation .= '
				<h4>'.
					$row->make . ' ' . 
					$row->model . ' (' . 
					$row->variant
					.')
				</h4>
				<br />
				<div class="row">
					<div class="col-md-5">
						<table class="table table-bordered table-striped table-condensed mb-none">
							<tr><td width="30%">Demo</td><td>'.$row->demo.'</td></tr>
							<tr><td>VIN</td><td>'.$row->vin.'</td></tr>
							<tr><td>Engine Number</td><td>'.$row->engine.'</td></tr>
							<tr><td>Registration Plate</td><td>'.$row->registration_plate.'</td></tr>
							<tr><td>Registration Expiry</td><td>'.$row->registration_expiry.'</td></tr>
							<tr><td>KMS</td><td>'.$row->kms.'</td></tr>
							<tr><td>Make</td><td>'.$row->make.'</td></tr>
							<tr><td>Model</td><td>'.$row->model.'</td></tr>
							<tr><td>Variant</td><td>'.$row->variant.'</td></tr>
							<tr><td>Build Date</td><td>'.$row->qr_build_date.'</td></tr>
							<tr><td>Series</td><td>'.$row->series.'</td></tr>
							<tr><td>Body Type</td><td>'.$row->body_type.'</td></tr>
							<tr><td>Transmission</td><td>'.$row->transmission.'</td></tr>
							<tr><td>Fuel Type</td><td>'.$row->fuel_type.'</td></tr>
							<tr><td>Colour</td><td>'.$row->colour.'</td></tr>
							<tr><td>Registration Type</td><td>'.$row->registration_type.'</td></tr>
						</table>
						<br />					
						<table class="table table-bordered table-striped table-condensed mb-none">
							<tr><td width="30%">Dealership Name</td><td>'.$row->dealer.'</td></tr>
							<tr><td>Fleet Manager</td><td>'.$row->manager_name.'</td></tr>
							<tr><td>Email Address</td><td>'.$row->username.'</td></tr>
							<tr><td>Postcode</td><td>'.$row->postcode.'</td></tr>
							<tr><td>State</td><td>'.$row->state.'</td></tr>
							<tr><td>Delivery Date</td><td>'.$row->delivery_date.'</td></tr>
							<tr><td>Compliance Date</td><td>'.$row->compliance_date.'</td></tr>
							<tr><td>Build Date</td><td>'.$row->build_date.'</td></tr>
						</table>
						<br />
						<table class="table table-bordered table-striped table-condensed mb-none">
							<tr>
								<td><b>Additional Notes:</b></td>
							</tr>
							<tr>
								<td>'.$dealer_notes.'</td>
							</tr>							
						</table>
					</div>
					<div class="col-md-7">
						<table class="table table-bordered table-striped table-condensed mb-none">
							<tr><td width="70%">List Price</td><td align="right">$ '.$row->retail_price.'</td></tr>
							<tr><td>Fleet Discount (-)</td><td align="right">$ '.$row->fleet_discount.'</td></tr>
							<tr><td>Dealer Discount (-)</td><td align="right">$ '.$row->dealer_discount.'</td></tr>
							<tr><td>Delivery Charge</td><td align="right">$ '.$row->predelivery.'</td></tr>					
						</table>
						<br />';
						$quotation .= '
						<table class="table table-bordered table-striped table-condensed mb-none">
							<tr><td colspan="2">Options</td></tr>';
							$opt_total = 0;
							$options_query = "
							SELECT o.name, qo.price
							FROM quote_request_options qro 
							JOIN quote_options qo ON qro.id_quote_request_option = qo.fk_request_option
							JOIN options o ON qro.fk_option = o.id_option
							WHERE qo.fk_quote = ".$row->id_quote." ORDER BY qro.id_quote_request_option ASC";
							$options_result = $this->db->query($options_query);
							if (count($options_result->result())==0)
							{
								$quotation .= '<tr><td colspan="2">No options included</td></tr>';
							}
							else
							{
								foreach ($options_result->result() as $options_row)
								{
									$quotation .= '<tr><td width="70%">Option: '.$options_row->name.'</td><td align="right">$ '.$options_row->price.'</td></tr>';
									$opt_total = $opt_total + $options_row->price;
								}
							}
							$quotation .= '
						</table>
						<br />';
						$quotation .= '
						<table class="table table-bordered table-striped table-condensed mb-none">
							<tr><td colspan="2">Accessories</td></tr>';
							$acc_total = 0;
							$accessories_query = "
							SELECT qra.name, qa.price
							FROM quote_request_accessories qra
							JOIN quote_accessories qa ON qra.id_quote_request_accessory = qa.fk_request_accessory
							WHERE qa.fk_quote = ".$row->id_quote." ORDER BY qra.id_quote_request_accessory ASC";
							$accessories_result = $this->db->query($accessories_query);
							if (count($accessories_result->result())==0)
							{
								$quotation .= '<tr><td colspan="2">No accessories included</td></tr>';
							}
							else
							{
								foreach ($accessories_result->result() as $accessories_row)
								{
									$quotation .= '<tr><td width="70%">Accessory: '.$accessories_row->name.'</td><td align="right">$ '.$accessories_row->price.'</td></tr>';
									$acc_total = $acc_total + $accessories_row->price;
								}
							}
							$quotation .= '
						</table>
						<br />';
						$quotation .= '
						<table class="table table-bordered table-striped table-condensed mb-none">
							<tr><td width="70%">GST</td><td align="right">$ '.$row->gst.'</td></tr>
							<tr><td>Luxury Tax</td><td align="right">$ '.$row->luxury_tax.'</td></tr>
							<tr><td>CTP</td><td align="right">$ '.$row->ctp.'</td></tr>
							<tr><td>Registration</td><td align="right">$ '.$row->registration.'</td></tr>
							<tr><td>Premium Plate Fee</td><td align="right">$ '.$row->premium_plate_fee.'</td></tr>										
							<tr><td>Stamp Duty</td><td align="right">$ '.$row->stamp_duty.'</td></tr>
							<tr><td>Tradein Value (-)</td><td align="right">$ '.$row->dealer_tradein_value.'</td></tr>
							<tr><td><b>Total-On Road Cost (Inclusive of GST)</b></td><td align="right"><b>$ '.$row->total.'</b></td></tr>
							<tr><td><b>Changeover</b></td><td align="right"><b>$ '.$row->dealer_changeover.'</b></td></tr>
						</table>';
						$quotation .= '
					</div>
				</div>';
			}
			$quotation_content = array("quotation" => $quotation);
			echo json_encode($quotation_content);
		}
	}

	public function quotation_request ($quotation_request_id) // REMOVE LEFT JOIN FROM vehicles?
	{
		$query = "
		SELECT
		qr.id_quote_request as `id_quote_request`, qr.quote_number, qr.postcode, qr.winner as `winner_id`,
		u.name as `user`, u.username as `email`, u.phone as `phone`,
		m.name as `make`, f.name as `model`, qr.build_date, v.name as `variant`,
		qr.series, qr.body_type, qr.registration_type, qr.transmission, qr.colour, qr.fuel_type,
		qr.message, qr.created_at, TIME_TO_SEC(TIMEDIFF(NOW(), qr.created_at)) as `remaining`,
		(SELECT total FROM quotes WHERE fk_quote_request = `winner_id` LIMIT 1) as `winning_price`
		FROM quote_requests qr
		JOIN makes m ON qr.make = m.id_make
		JOIN families f ON qr.model = f.id_family
		LEFT JOIN vehicles v ON qr.variant = v.id_vehicle
		JOIN users u ON qr.fk_user = u.id_user
		WHERE 1 AND qr.deprecated <> 1 AND qr.id_quote_request = ".$quotation_request_id." LIMIT 1";
		$result = $this->db->query($query);
		foreach ($result->result() as $row)
		{
			$options = '';
			$qro_query = "
			SELECT o.name, o.items
			FROM quote_request_options qro
			JOIN options o ON qro.fk_option = o.id_option
			WHERE qro.deprecated <> 1 AND qro.fk_quote_request = ".$quotation_request_id;
			$qro_result = $this->db->query($qro_query);
			if (count($qro_result->result())==0)
			{
				$options .= '<tr><td><i>No accessories added</i></td></tr>';
			}
			else
			{
				foreach ($qro_result->result() as $qro_row)
				{
					$items = "";
					if ($qro_row->items <> '')
					{
						$items = ": ".$qro_row->items;
					}
					$options .= '<tr><td>'.$qro_row->name.$items.'</td></tr>';
				}			
			}
			
			$accessories = '';
			$qra_query = "
			SELECT name, description
			FROM quote_request_accessories
			WHERE deprecated <> 1 AND fk_quote_request = ".$quotation_request_id;
			$qra_result = $this->db->query($qra_query);
			if (count($qra_result->result())==0)
			{
				$accessories .= '<tr><td><i>No accessories added</i></td></tr>';
			}
			else
			{
				$accessories .= '<tr><td><b>Item</b></td><td><b>Description</b></td></tr>';
				foreach ($qra_result->result() as $qra_row)
				{
					$accessories .= '<tr><td>'.$qra_row->name.'</td><td>'.$qra_row->description.'</td></tr>';
				}
			}
			
			$message = '';
			if ($row->message <> '')
			{
				$message = '
				<h4>Additional Info:</h4>
				<div class="well well-sm">'.$row->message.'</div>';
			}

			$quote_request_arr = array(
				"title" => $row->make.' '.$row->model.' '.$row->variant,
				"quote_number" => $row->quote_number,
				"postcode" => $row->postcode,
				"make" => $row->make,
				"model" => $row->model,
				"build_date" => $row->build_date,
				"variant" => $row->variant,
				"series" => $row->series,
				"body_type" => $row->body_type,
				"registration_type" => $row->registration_type,
				"transmission" => $row->transmission,
				"colour" => $row->colour,
				"fuel_type" => $row->fuel_type,
				"options" => $options,
				"accessories" => $accessories,
				"message" => $message,
				"created_at" => $row->created_at,
				"winning_price" => $row->winning_price,
				"user" => $row->user,
				"email" => $row->email,
				"phone" => $row->phone
			);
		}
		echo json_encode($quote_request_arr);
	}
	
	public function get_tradein_details_quote ($lead_id)
	{
		$response_array = [];

		$tradeins = $this->user_model->get_tradein_details_quote($lead_id);

		$tradein_details = "";

		$tradein_details .= '
						<thead>
							<tr><td colspan="23"><b>TRADEINS</b></td></tr>
						</thead>
						<tbody id="suggested_trades_body">';
		if (count($tradeins)==0)
		{
			$tradein_details .= '<tr><td colspan="23" id="no_tradeins"><i>No Trade-Ins found to this client..</i></td></tr>';
		}
		else
		{
			$tradein_details .= '					
								<tr>
									<td></td>
									<td><b>VEHICLE DETAILS</b></td>
								</tr>';

			$root_url = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/";
			foreach ($tradeins as $key => $tradein) 
			{
				$tradein_details .= "<tr>";
				if ($tradein['image_1']=="") { $tradein['image_1'] = "no_image.png"; }
				$tradein_details .= "
				<td width='40%'>
					<center>
						<br />
						<img src='".$root_url.$tradein['image_1']."' class='img-responsive' width='90%'>
						<br />
						<div class='btn-group' role='group'>
							<a href='#' class='btn btn-primary btn-xs open-tradeindetails' data-tradein_id='".$tradein['id_tradein']."'>
								<i class='fa fa-pencil-square-o' ></i> Details
							</a>
							<a href='#' class='btn btn-default btn-xs open-entervaluation' data-tradein_id='".$tradein['id_tradein']."'>
								<i class='fa fa-tag'></i> Valuation
							</a>
						</div>
					</center>
				</td>
				<td width='60%'>
					<br />
					<span>
						<b>".strtoupper($tradein['tradein_make'])." ".strtoupper($tradein['tradein_model'])." ".strtoupper($tradein['tradein_variant'])."</b>
					</span>
					<br />
					<br />
					<span><b>Transmission:</b><br />".$tradein['tradein_transmission']."</span><br /><br />
					<span><b>Colour:</b><br />".$tradein['tradein_colour']."</span><br /><br />
					<span><b>Kms:</b><br />".$tradein['tradein_kms']."</span>
				</td>";
				$tradein_details .= "</tr>";
			}
		}

		$tradein_details .= "</tbody>";

		return $response_array = [
				'tradein_details' => $tradein_details,
				'count'           => count($tradeins)
					];
	}

	public function get_quote ($quote_id)
	{
		$quote_accessories_loop = $this->quote_model->get_quote_accessories_array($quote_id);
		$quote_options_loop     = $this->quote_model->get_quote_options_array($quote_id);

		$quote = $this->quote_model->get_quote_all($quote_id);

		$old_data = [
			'retail_price'          => $quote['retail_price'],
			'fleet_discount'        => $quote['fleet_discount'],
			'dealer_discount'       => $quote['dealer_discount'],
			'predelivery'           => $quote['predelivery'],
			'gst'                   => $quote['gst'],
			'luxury_tax'            => $quote['luxury_tax'],
			'ctp'                   => $quote['ctp'],
			'registration'          => $quote['registration'],
			'premium_plate_fee'     => $quote['premium_plate_fee'],
			'stamp_duty'            => $quote['stamp_duty'],
			'delivery_date'         => $quote['delivery_date'],
			'compliance_date'       => $quote['compliance_date'],
			'notes'                 => $quote['notes'],
			'kms'                   => $quote['kms'],
			'vin'                   => $quote['vin'],
			'engine'                => $quote['engine'],
			'registration_expiry'   => $quote['registration_expiry'],
			'registration_plate'    => $quote['registration_plate'],
			'total'                 => $quote['total'],
			'transport_checkbox'    => $quote['transport_checkbox'],
			'dealer_changeover'     => $quote['dealer_changeover'],
			'dealer_tradein_payout' => $quote['dealer_tradein_payout'],
			'dealer_tradein_value'  => $quote['dealer_tradein_value'],
			'dealer_client_refund'  => $quote['dealer_client_refund']
		];

		$qro_query = "
		SELECT qro.id_quote_request_option, o.id_option, o.name, o.items
		FROM quote_request_options qro
		JOIN options o ON qro.fk_option = o.id_option
		WHERE qro.deprecated <> 1 AND qro.fk_quote_request = '".$quote['fk_quote_request']."' ORDER BY qro.id_quote_request_option ASC;";
		$qro_result = $this->db->query($qro_query)->result_array();	
		foreach ($qro_result as $opt_index => $opt_row)
		{
			$old_data[md5($opt_row['name'])] = $quote_options_loop[$opt_index]['price'];
		}

		$qra_query = "
		SELECT id_quote_request_accessory, name, description
		FROM quote_request_accessories
		WHERE deprecated <> 1 AND fk_quote_request = '".$quote['fk_quote_request']."'";
		$qra_result = $this->db->query($qra_query)->result_array();
		
		foreach ($qra_result as $acc_index => $acc_row)
		{
			$old_data[md5($acc_row['name'])] = $quote_accessories_loop[$acc_index]['price'];
		}

		return $old_data;
	}

	public function quote_update_trail ($update_array = array(), $quote_id, $label_arr)
	{
		$now = date('Y-m-d H:i:s');
		$data = $this->data;

		$return_array = [];
		$micro_array  = [];
		$macro_array  = [];

		$old_array = $this->get_quote($quote_id);

		$ctr = 0;
		foreach ($old_array as $key => $val) 
		{
			$label = "";
			if ($val != $update_array[$key])
			{
				if (strlen($key) == 32)
				{
					$tot_key = count($old_array) - $ctr;
					$label = $label_arr[count($label_arr) - (int)$tot_key];
				}
				else
				{
					$label = $key;
				}

				$micro_array = [
					'field'      => $label,
					'value_from' => $val,
					'value_to'   => $update_array[$key]
				];
				$macro_array[] = $micro_array;
			}
			$ctr++;
		}
		
		$return_array = [
			'trail'      => json_encode($macro_array),
			'fk_user'    => $data['user_id'],
			'fk_main'    => $quote_id,
			'table_name' => 'quotes',
			'action'     => 'update',
			'created_at' => $now
		];

		if (count($macro_array) > 0)
		{
			$this->db->insert('audit_trail', $return_array);
		}
	}

	public function get_dropdown_data () // WHAT ???? //
    {
    	$this->load->model('fapplication_model');
    	$post_data = $this->input->post();
    	$return_array = $this->fapplication_model->get_dropdown_data($post_data);
    	echo json_encode($return_array);
    }
	
	public function dealer_uploads ()
	{
		$data = $this->data;
		$input_arr = $this->input->post();

		$dealer_files = $this->user_model->get_dealer_files($input_arr['id_lead'], $data['user_id']);
		$html = '
		<div class="table-responsive">
			<table class="table table-condensed mb-none">		
				<tbody>';
					$file_path = "uploads/dealer_files/";
					$absolute_path = "";
					foreach ($dealer_files AS $dealer_file) 
					{
						$absolute_path = base_url($file_path.$dealer_file['file_name']);
						$html .= '
						<tr class="dealer_files_tbl" data-abspath="'.$dealer_file['file_name'].'" data-id_file_attachment="'.$dealer_file['id_file_attachment'].'">
							<td>
								<a target="_blank" href="'.$absolute_path.'">
									'.$dealer_file['file_name'].'
								</a>
							</td>
						</tr>';
					}
					$html .= '
				</tbody>
			</table>
		</div>';

		$dom = ['files_table' => $html];
		echo json_encode($dom);
	}

	public function dealer_upload ()
	{
		$data = $this->data;
		$directory = './uploads/dealer_files/';
		$prefix = time().'_'.$data['user_id'].'_';
		$file_name = $_FILES['file']['name'];
		$file_tmp = $_FILES['file']['tmp_name'];
		$file = $directory.$prefix.$file_name;
		$database_file_name = $prefix.$file_name;

		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$mime  = finfo_file($finfo, $_FILES['file']['tmp_name']);

		$json_array = [];

		if (
			strpos($mime, 'application/pdf')!==false || 
			strpos($mime, 'application/msword')!==false ||
			strpos($mime, 'image/jpg')!==false ||
			strpos($mime, 'image/jpeg')!==false ||
			strpos($mime, 'image/png')!==false ||
			strpos($mime, 'image/gif')!==false ||
			strpos($mime, 'image/bmp')!==false
		)
		{		
			$post_data = $this->input->post();
			$insert_id = $this->comment_model->insert_file_attachment($post_data['id'], $database_file_name, $data['user_id'], 7);

			if(move_uploaded_file($file_tmp, $file))
			{
				$json_array['abspath'] = base_url('uploads/dealer_files/'.$database_file_name);
				$json_array['status'] = "success";
				$json_array['insert_id'] = $insert_id;
				$json_array['file_name'] = $database_file_name;
			}
			else
			{
				$json_array['status'] = "fail";
			}
		}
		else
		{
			$json_array['status'] = "fail";
		}
		echo json_encode($json_array);
	}

	public function upload_quote_pdf ()
	{
		$data = $this->data;
		$directory = './uploads/';
		$prefix = time().'_'.$data['user_id'].'_';
		$file_name = $_FILES['file']['name'];
		$file_tmp = $_FILES['file']['tmp_name'];
		$file = $directory.$prefix.$file_name;
		$database_file_name = $prefix.$file_name;
		
		$finfo = new finfo();
		$fileMimeType = $finfo->file($file_tmp);

		$json_array = [];

		if (strpos($fileMimeType, 'PDF')!==false)
		{		
			$post_data = $this->input->post();
			$insert_id = $this->comment_model->insert_file_attachment($post_data['id'], $database_file_name, $data['user_id'], 5);

			if(move_uploaded_file($file_tmp, $file))
			{
				$json_array['abspath']   = base_url('uploads/'.$database_file_name);
				$json_array['status']    = "success";
				$json_array['insert_id'] = $insert_id;
				$json_array['file_name'] = $database_file_name;
			}
			else
			{
				$json_array['status'] = "fail";
			}
		}
		else
		{
			$json_array['status'] = "fail";
		}
		echo json_encode($json_array);
	}

	public function get_files ()
	{
		$post_data = $this->input->post();
		$data = $this->data;

		$rows = $this->request_model->get_files($post_data['this_id'], $data['user_id']);

		$modal_list = '
		<table class="table table-striped">
			<tbody>';
				$file_path = "uploads/";
				$absolute_path = "";
				foreach ($rows as $key => $value) 
				{
					$absolute_path = base_url($file_path.$value['file_name']);
					$modal_list .= '
					<tr class="pdf_table" data-abspath="'.$value['file_name'].'" data-fileid="'.$value['id_comment'].'">
						<td><a target="_blank" href="'.$absolute_path.'">'.$value['file_name'].'</a></td>
						<td><a class="fa fa-trash-o del_file" ></a></td>
					</tr>';
				}
				$modal_list .= '
			</tbody>
		</table>';
		$dom = ['files_table' => $modal_list];

		echo json_encode($dom);
	}

	public function delete_dealer_file ()
	{
		$post_data = $this->input->post();
	
		if ($this->user_model->delete_dealer_file($post_data))
		{
			echo "success";
		}
		else
		{
			echo "fail";
		}
	}

	public function delete_file ()
	{
		$post_data = $this->input->post();
	
		if($this->request_model->delete_file($post_data))
		{
			echo "success";
		}
		else
		{
			echo "fail";
		}
	}
		
	public function get_notifications ()
	{
		$data = $this->data;

		$new_order_count_result = $this->lead_model->get_orders_count(array(), $data['user_id']);
		
		$notification_arr = array(
			"cart_item_count"  	=> count($this->cart->contents()),
			"new_order_count"  	=> $new_order_count_result['cnt']
		);

		echo json_encode($notification_arr);		
	}	

	public function get_suggested_wholesalers ()
	{
		$wholesalers = $this->user_model->get_suggested_wholesalers();
		$html = "";
		foreach($wholesalers as $wholesaler)
		{
			$html .= "<option value='".$wholesaler->id_user."'>".$wholesaler->name."</option>";
		}
		echo $html;
	}

	public function get_dealer_state ()
	{
		$id_user = $this->input->post('id_user');
		$user = $this->user_model->get_user($id_user);
		echo $user['state'];
	}

	public function get_dealership_contacts(){
		$id_user = $this->input->post('id_user');
		$dealer = $this->user_model->get_dealership_contacts($id_user);
		$dealer_contacts = str_replace('\\', '',$dealer['dealership_contacts']);
		$html = '';
		$html .= '<option value="">--Select--</option>';
		if(!empty($dealer['name'])){
			$html .= '<option value="'.$dealer['name'].'">'.$dealer['name'].'</option>';
		}
		if(!empty($dealer_contacts) || $dealer_contacts != ''){
			$dealer_contacts_arr = json_decode($dealer_contacts,true);
			if(!empty($dealer_contacts_arr)){
				foreach ($dealer_contacts_arr as $row) {
					extract($row);
					if(!empty($row)) {
						if(isset($row['contact_full_name'])){
							$full_name = $row['contact_full_name'];
						}elseif ($row['contact_fullname']) {
							$full_name = $row['contact_fullname'];
						}
						$html .= '<option value="'.$full_name.'">'.$full_name.'</option>';
					}
				}
			}
		} else {
			//$html .= '<option value="">No Records</option>';
		}
		echo $html;

	}

	// PDF Redirect //
	public function generate_purchase_order_pdf ($lead_id) // PDF RENDER
	{
		$data = $this->data;
		$data['title'] = 'Purchase Order';

		$data['company_settings'] = $this->settings;
		$data['deal'] = $this->lead_model->get_deal($lead_id);

		$data['accessories'] = $this->request_model->get_quote_request_accessories($data['deal']['id_quote_request']);
		$data['options'] = $this->request_model->get_quote_request_options($data['deal']['id_quote_request']);
		$data['tradeins'] = $this->tradein_model->get_attached_tradeins($lead_id);
		
		$data['deposits'] = $this->lead_model->get_lead_deposits($lead_id);
		$data['refunds'] = $this->lead_model->get_lead_refunds($lead_id);		
		$data['deposit_trans'] = $this->lead_model->get_lead_deposit_trans($lead_id);
	
		$filename = str_replace('QM', 'PO', $data['deal']['cq_number'])."_".date("Ymdhis");
		$pdfFilePath = FCPATH."/uploads/order_files/".$filename.".pdf";

		ini_set('memory_limit','512M');
		$html = $this->load->view('pdf_renders/order_print', $data, true);
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->SetHTMLFooter($this->footer);
		$pdf->WriteHTML($html);
		$pdf->Output($pdfFilePath, 'F');
		$path = "/uploads/order_files/".$filename.".pdf";
		
		$input_arr = array(
			'id' => $lead_id,
			'table_name' => 'leads',
			'pdf_type' => 'Purchase Order (to Dealer)',
			'path' => $path
		);
		$this->pdf_model->insert_pdf($data['user_id'], $input_arr);

		return $path;
	}
	
	public function deal_export ($lead_id) // PDF RENDER
	{
		$data = $this->data;
		$data['title'] = 'Purchase Order';

		$data['company_settings'] = $this->settings;
		$data['deal'] = $this->lead_model->get_deal($lead_id);

		$data['accessories'] = $this->request_model->get_quote_request_accessories($data['deal']['id_quote_request']);
		$data['options'] = $this->request_model->get_quote_request_options($data['deal']['id_quote_request']);
		$data['tradeins'] = $this->tradein_model->get_attached_tradeins($lead_id);
		
		$data['deposits'] = $this->lead_model->get_lead_deposits($lead_id);
		$data['refunds'] = $this->lead_model->get_lead_refunds($lead_id);		
		$data['deposit_trans'] = $this->lead_model->get_lead_deposit_trans($lead_id);
	
		$filename = str_replace('QM', 'PO', $data['deal']['cq_number'])."_".date("Ymdhis");
		$pdfFilePath = FCPATH."/uploads/order_files/".$filename.".pdf";

		ini_set('memory_limit','512M');
		$html = $this->load->view('pdf_renders/order_print', $data, true);
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->SetHTMLFooter($this->footer);
		$pdf->WriteHTML($html);
		$pdf->Output($pdfFilePath, 'F');
		$path = "/uploads/order_files/".$filename.".pdf";
		
		$input_arr = array(
			'id' => $lead_id,
			'table_name' => 'leads',
			'pdf_type' => 'Purchase Order (to Dealer)',
			'path' => $path
		);
		$this->pdf_model->insert_pdf($data['user_id'], $input_arr);
		
		$audit_trail_arr = array(
			'id' => $lead_id,
			'table_name' => 'leads',
			'action' => 33,
			'description' => '[{"file":"'.$path.'"}]'
		);
		$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);

		redirect($path);
	}
}
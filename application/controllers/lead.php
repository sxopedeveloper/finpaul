<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('admin_main.php');
ob_start();
class Lead extends Admin_main
{
	function __construct()
	{
		parent::__construct();
	}

	function index ()
	{
		header("Location: " . site_url('lead/list_view'));
		exit();
	}

	public function email_dead_leads () // BACKGROUND PROCESS // STATIC EMAIL //
	{
		date_default_timezone_set('Australia/Sydney');
		ini_set('max_execution_time', -1);	
		$now = date("Y-m-d H:i:s");
		$this->load->library('email');
		$lead_details = $this->lead_model->get_lead_cheapest_prices();
		foreach ($lead_details as $lead_detail)
		{
			$final_price = 0;

			if ($lead_detail->cq_cheapest_variant_price <> "" AND $lead_detail->cq_cheapest_variant_price <> 0)
			{
				$make = $lead_detail->qr_make;
				$model = $lead_detail->qr_family;
				$variant = $lead_detail->qr_vehicle;

				$difference = 0;
				$higher = 0;
				$lower = 0;
				if ($lead_detail->cq_cheapest_variant_price > $lead_detail->rb_final_variant_price)
				{
					$difference = $lead_detail->cq_cheapest_variant_price - $lead_detail->rb_final_variant_price;
					$higher = $lead_detail->cq_cheapest_variant_price;
					$lower = $lead_detail->rb_final_variant_price;
				}
				else
				{
					$difference = $lead_detail->rb_final_variant_price - $lead_detail->cq_cheapest_variant_price;
					$higher = $lead_detail->rb_final_variant_price;
					$lower = $lead_detail->cq_cheapest_variant_price;
				}
				$percentage = ($difference / $higher) * 100;

				if ($percentage <= 15)
				{
					$final_price = $lead_detail->cq_cheapest_variant_price;
				}
				else
				{
					$final_price = $lead_detail->rb_final_variant_price;
				}
			}
			else if ($lead_detail->rb_final_variant_price <> "" AND $lead_detail->rb_final_variant_price <> 0)
			{
				$make = $lead_detail->qr_make;
				$model = $lead_detail->qr_family;
				$variant = $lead_detail->qr_vehicle;

				$final_price = $lead_detail->rb_final_variant_price;
			}
			else if ($lead_detail->cq_cheapest_model_price <> "" AND $lead_detail->cq_cheapest_model_price <> 0)
			{
				$make = $lead_detail->l_make;
				$model = $lead_detail->l_model;
				$variant = "";

				$final_price = $lead_detail->cq_cheapest_model_price;
			}
			else
			{
				$final_price = $lead_detail->rb_final_model_price;	
			}

			if ($final_price <> 0 AND $final_price <> "" AND $final_price > 10000)
			{
				$final_price = $final_price + 2000;

				$content = '
				<p style="line-height: 1.5">
					Dear '.$lead_detail->name.',
					<br />
				</p>
				<p style="line-height: 1.5">
					You recently inquired regarding prices for a '.$make.' '.$model.' with '.$lead_detail->qs_name.' and we 
					appreciate the opportunity to be involved and felt that you should know that we have purchased 
					a '.$make.' '.$model.' in '.$lead_detail->state.' for the price of $'.$final_price.'
				</p>
				<p style="line-height: 1.5">
					We hope that the price is competitive enough that you might re contact us if you wish to also take advantage 
					of the pricing on info@qteme.com.au or ring 1300 009 001.
				</p>
				<p style="line-height: 1.5">
					<br /><br />
					Thank you for your time,
					<br />
					'.$data['company']['company_name'].'
				</p>';
				$this->send_templated_email($this->settings['company_email'], $this->settings['company_name'], $lead_detail->email, 'Quotes for the '.$make.' '.$model, $content);
				$this->lead_model->update_lead_date($lead_detail->id_lead, $now, 'dead_email_date');
			}
		}
	}	
	
	public function calculate_all_quotes () // BACKGROUND PROCESS //
	{
		$qro_query = "SELECT id_quote_request_option, fk_quote_request FROM quote_request_options WHERE deprecated <> 1";
		$qro_result = $this->db->query($qro_query);
		foreach ($qro_result->result() as $qro_row)
		{
			$quote_request_option_id = $qro_row->id_quote_request_option;
			$quote_request_id = $qro_row->fk_quote_request;

			$query = "SELECT id_quote FROM quotes WHERE fk_quote_request = " . $quote_request_id;
			$result = $this->db->query($query);
			foreach ($result->result() as $row)
			{
				$this->quote_model->reinsert_quotation_option($row->id_quote, $quote_request_option_id);
			}	
		}
		
		$qra_query = "SELECT id_quote_request_accessory, fk_quote_request FROM quote_request_accessories WHERE deprecated <> 1";
		$qra_result = $this->db->query($qra_query);
		foreach ($qra_result->result() as $qra_row)
		{
			$quote_request_accessory_id = $qra_row->id_quote_request_accessory;
			$quote_request_id = $qra_row->fk_quote_request;
			
			$query = "SELECT id_quote FROM quotes WHERE fk_quote_request = " . $quote_request_id;
			$result = $this->db->query($query);
			foreach ($result->result() as $row)
			{
				$this->quote_model->reinsert_quotation_accessory($row->id_quote, $quote_request_accessory_id);
			}
		}
		
		$query = "SELECT id_quote FROM quotes";
		$result = $this->db->query($query);
		if (count($result->result()) <> 0)
		{
			foreach ($result->result() as $row)
			{		
				$this->calculate_quote($row->id_quote, 0);
			}
		}
	}	

	public function calculate_quote ($quote_id, $status_change = 0)
	{
		$quote_details = $this->quote_model->get_quote_all($quote_id);
		$options = $this->quote_model->get_options_total($quote_id);
		$accessories = $this->quote_model->get_accessories_total($quote_id);		
		$quote_lead_id = $this->quote_model->get_quote_lead_id($quote_id);
		
		if(!empty($quote_lead_id)){
			$lead = $this->lead_model->get_lead($quote_lead_id['id_lead']);
		}

		
		if ((isset($lead) || !empty($lead)) && ($lead['registration_type']=="Exempt" OR $lead['registration_type']=="TPI/Gold Card"))
		{
			$gst = 0;
			$quote_details['stamp_duty'] = 0;
		}
		else
		{
			$gst = ($quote_details['retail_price'] + $quote_details['metallic_paint'] + $options['price_total'] + $accessories['price_total'] + $quote_details['predelivery'] - $quote_details['fleet_discount'] - $quote_details['dealer_discount']) * 0.10;
		}

		$total = $quote_details['retail_price'] + $quote_details['metallic_paint'] + $options['price_total'] + $accessories['price_total'] + $quote_details['predelivery'] + $gst + $quote_details['stamp_duty'] + $quote_details['registration'] + $quote_details['premium_plate_fee'] + $quote_details['ctp'] + $quote_details['luxury_tax'] - $quote_details['fleet_discount'] - $quote_details['dealer_discount'];
		$dealer_changeover = $total - $quote_details['dealer_tradein_value'] + $quote_details['dealer_tradein_payout'] - $quote_details['dealer_client_refund'];
		
		$this->quote_model->update_quote_total($quote_id, $gst, $total, $dealer_changeover, $status_change);
	}	
	
	// LIST VIEW PAGE (Start) //
	public function list_view ($start = 0) // PAGE VIEW (LV) //
	{
		$lead_id_arr = [];

		$data = $this->data;
		$data['title'] = 'Leads - List View';

		$limit = 50;
		$count_result = $this->lead_model->get_leads_count($_GET, $data['user_id'], $data['admin_type']);  // Record count
		$data['leads'] = $this->lead_model->get_leads($_GET, $data['user_id'], $data['admin_type'], $start, $limit); // Main Query
		$data['lead_sources'] = $this->lead_model->get_lead_sources(); // Lead Sources
		$data['rl_admins'] = $this->user_model->get_admins($data['user_id']); // Quote Specialists for Reallocation
		$data['ticket_types'] = $this->ticket_model->get_ticket_types(); // Ticket Types
		$data['modules'] = $this->ticket_model->get_modules(); // Modules
		$data['makes_row'] = $this->fapplication_model->get_dropdown_data(array("code"=>1));
		
		$current_date = date('Y-m-d');
		$current_month = date('m');
		$current_year = date('Y');
		
		if ($current_month==1)
		{
			$last_month = 12;
			$last_month_year = $current_year - 1;
		}
		else
		{
			$last_month = $current_month - 1;
			$last_month_year = $current_year;			
		}
		
		$current_date_f = new DateTime($current_date);
		$current_week_number = $current_date_f->format("W");		
		
		$dto = new DateTime();
		$dto->setISODate($current_year, $current_week_number);
		$week_start = $dto->format('Y-m-d');
		$dto->modify('+6 days');
		$week_end = $dto->format('Y-m-d');
		
		$_GET['week_start'] = $week_start;
		$_GET['week_end'] = $week_end;
		$_GET['current_date'] = $current_date;
		$_GET['current_year'] = $current_year;
		$_GET['current_month'] = $current_month;
		$_GET['last_month'] = $last_month;
		$_GET['last_month_year'] = $last_month_year;

		$data['leads_summary'] = $this->lead_model->get_leads_summary_main($_GET, $data['user_id'], $data['admin_type']); // Summary		

		$this->load->library('pagination');
		$config['base_url'] = site_url('lead/list_view/'); 
		$config['total_rows'] = $count_result['cnt'];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);
		$data['links'] = $this->pagination->create_links();

		$data['export_url'] = $this->substring_index($this->substring_index($data['links'], '">2</a></li>', 1), 'list_view/50?', -1);

		$data['session_data'] = $this->data;
		$data['result_count'] = $count_result['cnt'];

		
		foreach ($data['leads'] as $key => $value) 
		{
			$attachment_flag = 0;
			$attachment_flag = $this->lead_model->get_attachment_flag($value['id_lead']);
			$data['leads'][$key]['attachment_flag'] = $attachment_flag;
		}

		$first_flag = 0;
		$get_count = 0;

		if ($this->session->userdata('chkbx_overall_flag') !== FALSE)
		{
			$first_flag = $this->session->userdata('chkbx_overall_flag');
		}

		if (count($_GET) > 0)
		{
			foreach ($_GET as $g_key => $g_val) 
			{
				if (empty($g_val))
				{
					unset($_GET[$g_key]);
				}
			}

			if ($this->session->userdata('get_count') !== FALSE)
			{
				$get_count = $this->session->userdata('get_count');
			}

			if ($get_count != count($_GET))
			{
				$first_flag = 0;
				$this->session->set_userdata('chkbx_flag', 0);
			}

			if ($first_flag == 0)
			{
				$arr = ($this->session->userdata('chkbx_ids') !== FALSE) ? $this->session->userdata('chkbx_ids') : array();

				foreach ($arr as $key => $val) 
				{
					if (!in_array($val, $lead_id_arr))
					{
						unset($arr[$key]);
					}
				}

				$this->session->set_userdata('chkbx_ids', $arr);
				$first_flag = 1;
			}
			$this->session->set_userdata('get_count', count($_GET));
		}

		$data['payment_types'] = $this->payment_model->get_payment_types();
		$data['bank_accounts'] = $this->settings_model->get_bank_accounts();

		$this->load->view('admin/leads', $data);
	}	
	
	public function remove_all_checked () // FOR PAGINATION //
	{
		if ($this->session->userdata('chkbx_flag') !== FALSE)
		{
			$this->session->unset_userdata('chkbx_flag');
		}
		
		if ($this->session->userdata('chkbx_ids') !== FALSE)
		{
			$this->session->unset_userdata('chkbx_ids');
		}
	}

	public function return_all_checkbox_ids ($temp_string) // FOR PAGINATION //
	{
		$data    = $this->data;
		$get_arr = [];

		$temp_arr = explode('&', $temp_string);

		foreach ($temp_arr as $t_key => $t_val) 
		{
			$s_arr = explode('=', $t_val);
			$get_arr[$s_arr[0]] = $s_arr[1];
		}

		$return_array = [];

		$array_1 = [];
		$array_2 = [];

		if ($this->session->userdata('chkbx_ids') !== FALSE)
		{
			$array_2 = $this->session->userdata('chkbx_ids');
		}

		if ($this->session->userdata('chkbx_flag') !== FALSE)
		{
			if ($this->session->userdata('chkbx_flag') == 1)
			{
				$lead_id_arr = $this->lead_model->get_leads_ids($get_arr, $data['user_id'], $data['admin_type']);

				foreach ($lead_id_arr as $l_key => $l_val) 
				{
					$array_1[] = $l_val->lead_id;
				}

				foreach ($array_1 as $a_key => $a_val) 
				{
					if(in_array($a_val, $array_2))
						unset($array_1[$a_key]);
				}

				$return_array = $array_1;
			}
			else
			{
				$return_array = $array_2;
			}
		}
		else
		{
			$return_array = $array_2;
		}
		
		return $return_array;
	}

	public function select_all_curr_checked () // FOR PAGINATION //
	{
		if ($this->session->userdata('chkbx_flag') !== FALSE)
		{
			$this->session->set_userdata('chkbx_flag', 0);
		}

		$post_data = $this->input->post();
		
		$id_array = $this->input->post('id_array');
		$this_val = $this->input->post('this_val');

		$array  = [];
		$array2 = [];

		if ($this_val == "true")
		{
			if ($this->session->userdata('chkbx_ids') !== FALSE)
			{
				$array2 = $this->session->userdata('chkbx_ids');
				$array = array_merge($array2, $id_array);
				$array = array_unique($array);
				$this->session->unset_userdata('chkbx_ids');
				$this->session->set_userdata('chkbx_ids', $array);
			}
			else
			{
				$this->session->set_userdata('chkbx_ids', $id_array);
			}
		}
		else
		{
			if ($this->session->userdata('chkbx_ids') !== FALSE)
			{
				$this->session->set_userdata('chkbx_ids', array());
			}
		}
		
		echo json_encode($this->session->userdata('chkbx_ids'));
	}

	public function maintain_pagination () // FOR PAGINATION //
	{
		$this->session->set_userdata('chkbx_overall_flag', 1);
		
		$array = [];
		
		$id = $this->input->post('id');

		if ($this->session->userdata('chkbx_ids') !== FALSE)
		{
			$array = $this->session->userdata('chkbx_ids');
			if (in_array($id, $array))
			{
				foreach( $array as $key => $val) 
				{
					if($id == $val)
					{
						unset($array[$key]);
						break;
					}
				}
			}
			else
				$array[] = $id;
		}
		else
		{
			$array[] = $id;
		}
		
		$this->session->set_userdata('chkbx_ids', $array);
		
		echo json_encode($array);
	}

	public function check_all_control () // FOR PAGINATION //
	{
		$this->session->set_userdata('chkbx_overall_flag', 0);

		if ($this->session->userdata('chkbx_ids') !== FALSE)
		{
			$this->session->unset_userdata('chkbx_ids');
		}

		if ($this->session->userdata('chkbx_flag') !== FALSE)
		{
			if ($this->session->userdata('chkbx_flag') == 1)
			{
				$this->session->set_userdata('chkbx_flag', 0);
			}
			else
			{
				$this->session->set_userdata('chkbx_flag', 1);
			}
		}
		else
		{
			$this->session->set_userdata('chkbx_flag', 1);
		}
	}

	public function pagination_clicked () // FOR PAGINATION //
	{
		$this->session->set_userdata('chkbx_overall_flag', 1);
	}	
	
	public function send_email () // MODAL ACTION // (BULK FROM LIST VIEW) //
	{
		$data = $this->data;

		$temp_string = $this->input->post('query_filter');
		$lead_id_arr = $this->return_all_checkbox_ids($temp_string);

		$user_id = $data['user_id'];
		$email_subject = $this->input->post('email_subject');
		$email_message = $this->input->post('email_message');		
		$admin_detail = $this->user_model->get_admin($user_id);
		foreach ($lead_id_arr as $lead_id)
		{
			if ($lead_id != 'on')
			{
				$lead_detail = $this->lead_model->get_lead_client($lead_id);
				$content = $email_message;
				$this->send_templated_email($admin_detail['username'], $admin_detail['name'], $lead_detail['email'], $email_subject, $content);
			}
		}
	}

	public function allocate () // MODAL ACTION // (BULK FROM LIST VIEW) //
	{
		$data = $this->data;

		$temp_string = $this->input->post('query_filter');
		$lead_id_arr = $this->return_all_checkbox_ids($temp_string);
		$user_id = $this->input->post('quote_specialist_id');

		$lead_ids = implode(',', $lead_id_arr);
		$this->lead_model->allocate_leads($lead_ids, $user_id);

		$allocated_leads = "0";
		foreach ($lead_id_arr as $lead_id)
		{
			if ($lead_id != 'on')
			{
				$now = date('Y-m-d H:i:s');

				$lead_status = $this->lead_model->get_lead_status($lead_id);
				if ($lead_status['status'] == 100)
				{
					$this->lead_model->update_lead_date($lead_id, $now, 'shown_created_at');  
					$allocated_leads .= ", ".$lead_id;
				}
				else if ($lead_status['status']==0)
				{
					$allocated_leads .= ", ".$lead_id;
				}
				$this->lead_model->update_lead_date($lead_id, $now, 'allocated_date');
				$this->lead_model->update_lead_date($lead_id, '0000-00-00 00:00:00', 'assignment_date');
				// $this->templated_client_email_init(27, $lead_id, 'qs');
			}
		}

		if (count($lead_id_arr) > 0)
		{
			$user = $this->user_model->get_user($user_id);
			$from_email = $data['company']['company_email'];
			$from_name = $data['company']['company_name'];
			$to = $user['username'];
			$subject = "New Leads";
			
			if (count($lead_id_arr)==1)
			{
				$new_allocated_lead_label = 'lead';
			}
			else
			{
				$new_allocated_lead_label = 'leads';
			}
			
			$content = '
			<p style="line-height: 1.5">
				You have '.count($lead_id_arr).' new allocated '.$new_allocated_lead_label.'.
			</p>';
			// $this->send_templated_email($from_email, $from_name, $to, $subject, $content, $file = "");
		}
		
		$this->lead_model->update_leads_status($allocated_leads, 1);

		$return_data = [
			'lead_id_arr' => $lead_id_arr,
			'lead_count'  => count($lead_id_arr)
		];

		echo json_encode($return_data);
	}

	public function reallocate () // MODAL ACTION // (BULK FROM LIST VIEW) //
	{
		$data = $this->data;

		$temp_string = $this->input->post('query_filter');

		$lead_id_arr = $this->return_all_checkbox_ids($temp_string);
	
		// $lead_ids = $this->input->post('lead_ids');
		$user_id = $this->input->post('quote_specialist_id');
		$details = $this->input->post('details');
		
		$lead_ids_arr = explode(',', $lead_ids);
		foreach ($lead_ids_arr as $lead_id)
		{
			$this->reallocation_model->insert_lead_reallocation($lead_id, $data['user_id'], $user_id, $details);
		}

		$return_data = [
			'lead_count'  => count($lead_id_arr)
		];

		echo json_encode($return_data);
	}

	public function delete () // MODAL ACTION // (BULK FROM LIST VIEW) //
	{
		$temp_string = $this->input->post('query_filter');

		$lead_id_arr = $this->return_all_checkbox_ids($temp_string);
		$lead_ids = implode(',', $lead_id_arr);

		$this->lead_model->delete_leads($lead_ids);

		$return_data = [
			'lead_id_arr' => $lead_id_arr,
			'lead_count'  => count($lead_id_arr)
		];

		echo json_encode($return_data);
	}

	public function export_csv_leads ()
	{
		$now = date('Y-m-d H:i:s');
		$data = $this->data;
		
		$leads = $this->lead_model->get_leads($_GET, $data['user_id'], $data['admin_type'], 0, 0);
		
		foreach ($leads AS $index => $lead)
		{
			if (isset($lead['admin_to_qs_details']))
			{
				unset($leads[$index]['admin_to_qs_details']);
			}
			
			if (isset($lead['admin_details']))
			{
				unset($leads[$index]['admin_details']);
			}
			
			if (isset($lead['details']))
			{
				unset($leads[$index]['details']);
			}			
		}
		
		$this->export_csv($leads);
	}
	// LIST VIEW PAGE (End) //
	
	// CALENDAR PAGE (Start) //
	public function update_assignment_date ($lead_id) // CALENDAR ACTION //
	{
		$now = date('Y-m-d H:i:s');
		$data = $this->data;		
		
		$new_date = $this->input->post('new_date');
		
		$input_arr['id_lead'] = $lead_id;
		$input_arr['assignment_date'] = $new_date;
		
		$update_result = $this->lead_model->update_lead_details($input_arr);		
		
		if ($update_result)
		{
			$audit_trail_arr = array(
				'id' => $lead_id,
				'table_name' => 'leads',
				'action' => 23,
				'description' => '[{"date":"'.$new_date.'"}]'
			);
			$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);
			$this->action_model->insert_action(1, $lead_id, $data['user_id'], 'Assignment Date Changed');
		}
	}
	
	public function delete_calendar () // CALENDAR ACTION // AUDIT TRAIL //
	{
		$now = date('Y-m-d H:i:s');
		$data = $this->data;
		
		$input_arr = $this->input->post();

		$input_arr['id_lead'] = $input_arr['lead_id'];
		$input_arr['status'] = 100;
		$input_arr['deleted_date'] = $now;
		
		$update_result = $this->lead_model->update_lead_details($input_arr);
		
		if ($update_result)
		{
			$audit_trail_arr = array(
				'id' => $input_arr['id_lead'],
				'table_name' => 'leads',
				'action' => 8,
				'description' => ''
			);
			$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);
			$this->action_model->insert_action(1, $input_arr['id_lead'], $data['user_id'], 'Delete');			
			
			// echo "success";
		}
		else
		{
			// echo "fail";
		}
	}	
	// CALENDAR PAGE (End) //
	
	// NEW LEAD PAGE (Start) //
	public function new_record () // PAGE VIEW //
	{
		$data = $this->data;
		$data['title'] = 'Leads - Create New';
		$this->load->view('admin/lead_form', $data);
	}
	
	public function add_record () // PAGE ACTION //
	{
		$data = $this->data;
		$input_arr = $this->input->post();

		if (!$this->input->post())
		{
			header ("Location: ".site_url('lead/new_record'));
			exit ();
		}
		
		$query = "
		SELECT m.name as `make`, f.name as `family`
		FROM makes m
		JOIN families f ON m.id_make = f.fk_make
		WHERE m.id_make = '".$input_arr['make']."' AND f.id_family = '".$input_arr['family']."'
		LIMIT 1";
		$result = $this->db->query($query);
		if (count($result->result())<>0)
		{
			foreach ($result->result() as $row)
			{
				$input_arr['make'] = $row->make;
				$input_arr['family'] = $row->family;
			}
		}

		$this->lead_model->add_lead($input_arr);
		$lead_id = $this->db->insert_id();

		$audit_trail_arr = array(
			'id' => $lead_id,
			'table_name' => 'leads',
			'action' => 1,
			'description' => ''
		);
		$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);
		
		header ("Location: ".site_url('lead/list_view'));
		exit ();
	}	
	// NEW LEAD PAGE (End) //
	
	// HOME PAGE (Start) //
	public function load_home_aftersales_tab_html ($status) // V 1.0
	{
		$data = $this->data;
		
		$html = '<span data-status="'.$status.'" class="refresh_aftersales_tab btn btn-primary btn-sm pull-right" style="margin-bottom: 10px;cursor: pointer; cursor: hand;">Refresh</span><br /><br />';
		$params = array('aftersales_status' => $status);
		$results = $this->lead_model->get_deals_tile($params, '', 2, 0, 100);
		if (count($results)==0)
		{
			$html .= '<br /><center><i>No results found!</i></center><br /><br /><br />';
		}
		else
		{		
			foreach ($results as $result) 
			{
				$actions = '';
				if ($status==0) // Uncontacted
				{
					$actions .= '
					<a href="#" class="btn btn-primary as_buying_btn" data-lead_id="'.$result['lead_id'].'" data-status="3" >
						<i class="fa fa-check"></i> Buying
					</a>
					<a href="#" class="btn btn-warning as_undecided_btn" data-lead_id="'.$result['lead_id'].'" data-status="1">
						<i class="fa fa-question"></i> Undecided
					</a>					
					<a href="#" class="btn btn-danger as_notinterested_btn" data-lead_id="'.$result['lead_id'].'" data-status="2">
						<i class="fa fa-times"></i> Not Interested
					</a>';
				}
				else if ($status==1) // Undecided 
				{
					$actions .= '
					<a href="#" class="btn btn-primary as_buying_btn" data-lead_id="'.$result['lead_id'].'" data-status="3" >
						<i class="fa fa-check"></i> Buying
					</a>
					<a href="#" class="btn btn-danger as_notinterested_btn" data-lead_id="'.$result['lead_id'].'" data-status="2">
						<i class="fa fa-times"></i> Not Interested
					</a>';				
				}
				else if ($status==2) // Declined
				{
					$actions .= '
					<a href="#" class="btn btn-primary as_buying_btn" data-lead_id="'.$result['lead_id'].'" data-status="3" >
						<i class="fa fa-check"></i> Buying
					</a>
					<a href="#" class="btn btn-warning as_undecided_btn" data-lead_id="'.$result['lead_id'].'" data-status="1">
						<i class="fa fa-question"></i> Undecided
					</a>';
				}
				else if ($status==3) // Order
				{
					$actions .= '
					<a href="#" class="btn btn-info as_buying_btn" data-lead_id="'.$result['lead_id'].'" data-status="3" >
						<i class="fa fa-pencil-square-o"></i> Edit Order
					</a>
					<a href="#" class="btn btn-warning as_undecided_btn" data-lead_id="'.$result['lead_id'].'" data-status="1">
						<i class="fa fa-question"></i> Undecided
					</a>					
					<a href="#" class="btn btn-danger as_notinterested_btn" data-lead_id="'.$result['lead_id'].'" data-status="2">
						<i class="fa fa-times"></i> Not Interested
					</a>';				
				}

				if ($result['delivery_date']=="0000-00-00") { $delivery_date = ""; } else { $delivery_date = $result['delivery_date']; }
				$business_name = ""; if ($result['business_name']<>"") { $business_name = " (".$result['business_name'].")"; }
				$dealership_name = ""; if ($result['dealership_name']<>"") { $dealership_name = " (".$result['dealership_name'].")"; }
				$html .= '
				<div class="row" data-lead_id="'.$result['lead_id'].'" id="aftersales_row_'.$result['lead_id'].'">
					<div class="col-md-2">
						<img src="http://www.myelquoto.com.au/global_images/makes/'.str_replace(' ', '_', strtolower($result['tender_make'])).'.png" width="100%" style="border: 1px solid #ddd; margin-bottom: 8px; margin-top: 10px">
						<a href="#" class="btn btn-block btn-default email_trail" data-lead_id="'.$result['lead_id'].'" data-email="'.$result['email'].'" data-qm-number="'.$result['cq_number'].'">
							<i class="fa fa-envelope"></i> Emails
						</a>
						<a href="#" class="btn btn-block btn-default open-lead-details" data-lead_id="'.$result['lead_id'].'">
							<i class="fa fa-pencil-square-o"></i> Details
						</a>					
					</a>
					</div>
					<div class="col-md-10">			
						<h5><strong>'.$result['cq_number'].' - '.$result['tender_make'].' '.$result['tender_model'].'</strong></h5>
						<h5>'.$result['tender_variant'].' (' . $result['colour'] . ')</h5>
						<p><i class="fa fa-user"></i> <b>'.$result['qs_name'].'</b></i></p>				
						<p>Delivery Date: '.$delivery_date.'</p>
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
								<tr>
									<td width="50%"><b>Client</b></td>
									<td><b>Dealer</b></td>
								</tr>
								<tr>
									<td>
										'.$result['name'].$business_name.'<br />
										'.$result['phone'].'<br />
										'.$result['mobile'].'
									</td>
									<td>
										'.$result['fleet_manager'].$dealership_name.'<br />
										'.$result['dealer_phone'].'<br />
										'.$result['dealer_mobile'].'							
									</td>
								</tr>
							</table>
						</div>
						<br />
						'.$actions.'
					</div>
					<div class="col-md-12">
						<hr />
					</div>
				</div>';
			}
		}
		echo $html;		
	}
	
	public function load_home_sales_tab_html () // V 1.0
	{
		$data = $this->data;
		$post_data = $this->input->post();
		$client = isset($post_data['client']) ? $post_data['client'] : "";

		$status = $post_data['home_status'];
		$html = '
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading" style="padding: 8px;" id="filter_heading">
						<span style="cursor: pointer; cursor: hand;" class="btn btn-primary btn-xs filter_button">Show Filter</span>
					</div>
					<div class="panel-body filter_body" style="padding: 8px;" hidden>
						<div class="col-md-4 pull-right">
							<input type="text" class="form-control input-sm pull-right" placeholder="Client Name or Email" id="client" value="'.$client.'">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2 pull-right">
				<span data-status="'.$status.'" class="refresh_sales_tab btn btn-primary btn-sm pull-right" style="margin-bottom: 10px;cursor: pointer; cursor: hand;">Refresh</span>
			</div>
		</div>';

		$params = $post_data;
		$results = $this->lead_model->get_deals_tile($params, $data['user_id'], $data['admin_type'], 0, 100);		
		if (count($results)==0)
		{
			$html .= '<br /><center><i>No results found!</i></center><br /><br /><br />';
		}
		else
		{
			foreach ($results as $result)
			{
				$warning_arr = [];
				$reminder_arr = [];

				$heading = '';
				$summary = '';
				$contacts = '';
				$actions = '';
				
				if ($result['assignment_date']=="0000-00-00") { $assignment_date = ""; } else { $assignment_date = $result['assignment_date']; }
				if ($result['assignment_time']=="00:00:00") { $assignment_time = ""; } else { $assignment_time = $result['assignment_time']; }
				if ($result['delivery_date']=="0000-00-00") { $delivery_date = ""; } else { $delivery_date = $result['delivery_date']; }
				if ($result['finance']==1) { $finance = 'Yes'; } else { $finance = 'No'; }									
				$business_name = ""; if ($result['business_name']<>"") { $business_name = " (".$result['business_name'].")"; }
				$dealership_name = ""; if ($result['dealership_name']<>"") { $dealership_name = " (".$result['dealership_name'].")"; }				
				
				if ($status==3) // Orders
				{
					if ($result['delivery_date']=="0000-00-00")
					{
						$delivery_difference = "";
						$delivery_notification_text = "";
					}
					else
					{
						$delivery_difference = $this->date_difference_count($result['delivery_date']);
						$delivery_notification_text = "<b>Delivery</b> is ".$this->date_difference_text($delivery_difference);
					}
					if ($result['settled_date']=="0000-00-00")
					{
						$settled_difference = "";
						$settled_notification_text = "";
					}
					else
					{
						$settled_difference = $this->date_difference_count($result['settled_date']);
						$settled_notification_text = "<b>Settled</b> ".$this->date_difference_text($settled_difference);
					}
					if ($result['cancelled_date']=="0000-00-00")
					{
						$cancelled_difference = "";
						$cancelled_notification_text = "";
					}
					else
					{
						$cancelled_difference = $this->date_difference_count($result['cancelled_date']);
						$cancelled_notification_text = "<b>Cancelled</b> ".$this->date_difference_text($cancelled_difference);
					}					
					
					if ($result['name'] == "") { $warning_arr[] = "<b>Client name</b> is missing"; }
					if ($result['email'] == "") { $warning_arr[] = "<b>Client email</b> address is missing"; }
					if ($result['phone'] == "" AND $result['mobile'] == "") { $warning_arr[] = "<b>Client contact number<b/> is missing"; }
					if ($result['state'] == "" OR $result['postcode'] == "" OR $result['address'] == "") { $warning_arr[] = "<b>Client address</b> is incomplete"; }
				
					if ($result['delivery_date'] == "0000-00-00") { $warning_arr[] = "<b>Delivery date</b> is not set"; }
					if ($result['commissionable_gross'] <= 0) { $warning_arr[] = "<b>Commissionable gross</b> is very low"; }				
					if ($result['delivery_address'] == "") { $warning_arr[] = "<b>Delivery address</b> is missing"; }
				
					if (($result['status'] == 4 OR $result['status'] == 5 OR $result['status'] == 6) AND ($delivery_difference >= 0 AND $delivery_difference <= 7))
					{
						$reminder_arr[] = $delivery_notification_text;
					}
					if (($result['status'] == 4 OR $result['status'] == 5 OR $result['status'] == 6) AND ($delivery_difference < 0))
					{
						$warning_arr[] = $delivery_notification_text;
					}				
					if ($result['status'] == 7 AND $delivery_difference > 0)
					{
						$warning_arr[] = "Marked as <b>Settled</b> but delivery date hasn't arrived yet!";
					}					

					$heading .= '
					<a href="'.site_url("lead/record_final/".$result['lead_id']).'" target="_blank">
						<h5>
							<strong>
								<span id="home_cq_number">'.$result['cq_number'].'</span> - '.$result['tender_make'].' '.$result['tender_model'].'
							</strong>
						</h5>
					</a>
					<h5>'.$result['tender_variant'].' (' . $result['colour'] . ')</h5>
					<p><i class="fa fa-user"></i> <b>'.$result['qs_name'].'</b></i></p>';

					$summary .= '
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">					
							<tr>
								<td><b>Delivery</b></td>
								<td><b>Finance</b></td>								
								<td><b>Tradeins</b></td>
								<td><b>Quotes</b></td>
								<td><b>Gross</b></td>
							</tr>
							<tr>
								<td>'.$delivery_date.'</td>
								<td>'.$finance.'</td>								
								<td>'.$result['tradein_count'].'</td>
								<td>'.$result['quote_count'].'</td>
								<td align="right">$ '.number_format($result['commissionable_gross'], 2).'</td>
							</tr>
						</table>
					</div>
					<br />';

					$contacts .= '
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
							<tr>
								<td width="50%"><b>Client</b></td>
								<td><b>Dealer</b></td>
							</tr>
							<tr>
								<td>
									<span id="home_name">'.$result['name'].'</span>'.$business_name.'<br />
									<b>Email:</b> <span id="home_email">'.$result['email'].'</span><br />
									<b>Phone:</b> '.$result['phone'].'<br />
									<b>Mobile:</b> '.$result['mobile'].'<br />
									<b>Location:</b> '.$result['state'].' <span id="home_postcode">'.$result['postcode'].'</span>
								</td>
								<td>
									'.$result['fleet_manager'].$dealership_name.'<br />
									<b>Phone:</b> '.$result['dealer_phone'].'<br />
									<b>Mobile:</b> '.$result['dealer_mobile'].'<br />
									<b>Location:</b> '.$result['dealer_state'].' '.$result['dealer_postcode'].'
								</td>
							</tr>
						</table>
					</div>
					<br />';					
					$actions .= '
					<a class="btn btn-info edit-callback" data-lead_id="'.$result['lead_id'].'">
						Call Back
					</a>					
					<a class="btn btn-primary btn-sm" href="'.site_url("deal/pdf_export/".$result['lead_id']).'" target="_blank">
						<i class="fa fa-file-pdf-o"></i> Purchase Order
					</a>
					<a class="btn btn-primary btn-sm" href="'.site_url("deal/dealer_invoice_pdf/".$result['lead_id']).'" target="_blank">
						<i class="fa fa-file-pdf-o"></i> Dealer Invoice
					</a>
					<a class="btn btn-primary btn-sm" href="'.site_url("deal/client_automated_invoice_pdf/".$result['lead_id']).'" target="_blank">
						<i class="fa fa-file-pdf-o"></i> Client Invoice
					</a>';
				}
				else if ($status==2) // Tenders
				{
					$heading .= '
					<a href="'.site_url("lead/record_final/".$result['lead_id']).'" target="_blank">
						<h5>
							<strong>
								<span id="home_cq_number">'.$result['cq_number'].'</span> - '.$result['tender_make'].' '.$result['tender_model'].'
							</strong>
						</h5>
					</a>
					<p><i class="fa fa-user"></i> <b>'.$result['qs_name'].'</b></i></p>';
					
					$summary .= '
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">					
							<tr>
								<td><b>Finance</b></td>								
								<td><b>Tradeins</b></td>
								<td><b>Quotes</b></td>
							</tr>
							<tr>
								<td>'.$finance.'</td>								
								<td>'.$result['tradein_count'].'</td>
								<td>'.$result['quote_count'].'</td>
							</tr>
						</table>
					</div>
					<br />';
					
					$contacts .= '
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
							<tr>
								<td width="100%"><b>Client</b></td>
							</tr>
							<tr>
								<td>
									<span id="home_name">'.$result['name'].'</span>'.$business_name.'<br />
									<b>Email:</b> <span id="home_email">'.$result['email'].'</span><br />
									<b>Phone:</b> '.$result['phone'].'<br />
									<b>Mobile:</b> '.$result['mobile'].'<br />
									<b>Location:</b> '.$result['state'].' <span id="home_postcode">'.$result['postcode'].'</span>
								</td>
							</tr>
						</table>
					</div>
					<br />';
					
					$actions .= '
					<a class="btn btn-info edit-callback" data-lead_id="'.$result['lead_id'].'">
						Call Back
					</a>					
					<a id="no_answer_btn" class="btn btn-default btn-sm" onclick="send_email('.$result['id_lead'].', '.$result['status'].', 2, '.$status.')">
						No Answer
					</a>
					<a id="wrong_number_btn" class="btn btn-default btn-sm" onclick="send_email('.$result['id_lead'].', '.$result['status'].', 3, '.$status.')">
						Wrong Number
					</a>
					<a id="not_proceeding_btn" class="btn btn-danger btn-sm" onclick="delete_lead('.$result['id_lead'].', '.$status.')">
						Not Proceeding
					</a>';
				}
				else if ($status==1) // Pre-Tenders
				{
					$heading .= '
					<a href="'.site_url("lead/record_final/".$result['lead_id']).'" target="_blank">
						<h5>
							<strong>
								<span id="home_cq_number">'.$result['cq_number'].'</span> - '.$result['make'].' '.$result['model'].'
							</strong>
						</h5>
					</a>
					<p><i class="fa fa-user"></i> <b>'.$result['qs_name'].'</b></i></p>
					<p>Finance: '.$finance.'</p>';
					
					$contacts .= '
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
							<tr>
								<td width="100%"><b>Client</b></td>
							</tr>
							<tr>
								<td>
									<span class="home_name">'.$result['name'].'</span>'.$business_name.'<br />
									<b>Email:</b> <span class="home_email">'.$result['email'].'</span><br />
									<b>Phone:</b> '.$result['phone'].'<br />
									<b>Mobile:</b> '.$result['mobile'].'<br />
									<b>Location:</b> '.$result['state'].' <span class="home_postcode">'.$result['postcode'].'</span>
								</td>
							</tr>
						</table>
					</div>
					<br />';
					
					$actions .= '
					<a class="btn btn-info edit-callback btn-sm" data-lead_id="'.$result['lead_id'].'" data-callbacktype="1">
						Call Back
					</a>
					<a id="no_answer_btn" class="btn btn-info btn-sm" onclick="send_email('.$result['id_lead'].', '.$result['status'].', 2, '.$status.')">
						No Answer
					</a>
					<a id="wrong_number_btn" class="btn btn-info btn-sm" onclick="send_email('.$result['id_lead'].', '.$result['status'].', 3, '.$status.')">
						Wrong Number
					</a>
					<a id="not_proceeding_btn" class="btn btn-danger btn-sm" onclick="delete_lead('.$result['id_lead'].', '.$status.')">
						Not Proceeding
					</a>
					<a id="start_tender_btn" class="btn btn-primary open-starttender btn-sm" data-lead_id="'.$result['id_lead'].'">
						Start Tender
					</a>';
				}		
				else if ($status==0) // Leads
				{
					$heading .= '
					<a href="'.site_url("lead/record_final/".$result['lead_id']).'" target="_blank">
						<h5>
							<strong>
								<span id="home_cq_number">'.$result['cq_number'].'</span> - '.$result['make'].' '.$result['model'].'
							</strong>
						</h5>
					</a>
					<p><i class="fa fa-user"></i> <b>'.$result['qs_name'].'</b></i></p>
					<p>Finance: '.$finance.'</p>';
					
					$contacts .= '
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
							<tr>
								<td width="100%"><b>Client</b></td>
							</tr>
							<tr>
								<td>
									<span class="home_name">'.$result['name'].'</span>'.$business_name.'<br />
									<b>Email:</b> <span class="home_email">'.$result['email'].'</span><br />
									<b>Phone:</b> '.$result['phone'].'<br />
									<b>Mobile:</b> '.$result['mobile'].'<br />
									<b>Location:</b> '.$result['state'].' <span class="home_postcode">'.$result['postcode'].'</span>
								</td>
							</tr>
						</table>
					</div>
					<br />';
					
					$actions .= '
					<a class="btn btn-info edit-callback btn-sm" data-lead_id="'.$result['lead_id'].'" data-callbacktype="1">
						Call Back
					</a>
					<a id="no_answer_btn" class="btn btn-info btn-sm" onclick="send_email('.$result['id_lead'].', '.$result['status'].', 2, '.$status.')">
						No Answer
					</a>
					<a id="wrong_number_btn" class="btn btn-info btn-sm" onclick="send_email('.$result['id_lead'].', '.$result['status'].', 3, '.$status.')">
						Wrong Number
					</a>
					<a id="not_proceeding_btn" class="btn btn-danger btn-sm" onclick="delete_lead('.$result['id_lead'].', '.$status.')">
						Not Proceeding
					</a>					
					<a id="pre_tender_btn" class="btn btn-warning edit-callback btn-sm" data-lead_id="'.$result['id_lead'].'" data-callbacktype="2">
						Pre Tender
					</a>
					<a id="start_tender_btn" class="btn btn-primary open-starttender btn-sm" data-lead_id="'.$result['id_lead'].'">
						Start Tender
					</a>';
				}				

				if ($result['tender_make']<>"")
				{
					$make_image = 'http://www.myelquoto.com.au/global_images/makes/'.str_replace(' ', '_', strtolower($result['tender_make'])).'.png';
				}
				else if ($result['make']<>"")
				{
					$make_image = 'http://www.myelquoto.com.au/global_images/makes/'.str_replace(' ', '_', strtolower($result['make'])).'.png';
				}
				else
				{
					$make_image = "";
				}

				$callback_alert = "";
				if ($assignment_date <> "")
				{
					$callback_alert = '
					<div class="alert alert-warning fade in nomargin">
						<p><b>A call is scheduled on '.$assignment_date.' '.$assignment_time.'</b></p>
					</div>';
				}
				
				$html .= '
				<div class="row aftersales_panel" data-lead_id="'.$result['lead_id'].'" id="aftersales_row_'.$result['lead_id'].'">
					<div class="col-md-2">
						<img src="'.$make_image.'" width="100%" style="border: 1px solid #ddd; margin-bottom: 8px; margin-top: 10px">
					</div>
					<div class="col-md-10">	
						'.$heading.$callback_alert;
						
						if (count($warning_arr)>0)
						{
							$html .= '
							<div class="alert alert-danger fade in nomargin">
								<ul>';
								foreach ($warning_arr AS $warning)
								{
									$html .= '<li>'.$warning.'</li>';
								}													
								$html .= '
								</ul>
							</div>';
						}
										
						if (count($reminder_arr)>0)
						{
							$html .= '
							<div class="alert alert-info fade in nomargin">
								<ul>';
								foreach ($reminder_arr AS $reminder)
								{
									$html .= '<li>'.$reminder.'</li>';
								}													
								$html .= '
								</ul>
							</div>';
						}

						if ($result['details']=="") 
						{
							$remarks = "<center><i>N/A</i></center>"; 
						}
						else 
						{
							$remarks = $result['details']; 
						}
						
						$actions = "";
						
						$lead_age = abs($this->date_difference_count($this->substring_index($result['created_at'], ' ', 1)));
						$lead_age_text = "Lead is ".$lead_age." days old | ";
						
						if ($result['last_call']=="")
						{
							$last_call_text = "";						
						}
						else
						{
							$last_call_date_difference = $this->date_difference_count($this->substring_index($result['last_call'], ' ', 1));
							$last_call_text = "Last called ".$this->date_difference_text($last_call_date_difference)." | ";							
						}
						
						$emails_sent_text = $result['sent_emails_count']." emails sent | ";
						$attempted_calls_text = $result['called_count']." attempted calls";
						
						$html .= 
						$summary.$contacts.'
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
								<tr>
									<td width="100%"><b>Remarks</b></td>
								</tr>
								<tr>
									<td>
										'.$remarks.'
									</td>
								</tr>
							</table>
						</div>
						<br />
						'.$lead_age_text.'
						'.$last_call_text.'
						'.$emails_sent_text.'
						'.$attempted_calls_text.'
						<br  />
						'.$actions.'
					</div>
					<div class="col-md-12">
						<hr />
					</div>
				</div>';
			}			
		}

		echo $html;
	}
	// HOME PAGE (End) //
	
	// HOME V2 (Start) //
	public function set_lead_schedule () // CALENDAR ACTION // AUDIT TRAIL OK //
	{
		$now = date('Y-m-d H:i:s');
		$data = $this->data;		
		
		$post_arr = $this->input->post();
		
		$input_arr['id_lead'] = $post_arr['id_lead'];
		$input_arr['assignment_date'] = date('Y-m-d', strtotime($post_arr['date']))." 00:00:00";
		
		$update_result = $this->lead_model->update_lead_details($input_arr);
		
		if ($update_result)
		{
			$audit_trail_arr = array(
				'id' => $input_arr['id_lead'],
				'table_name' => 'leads',
				'action' => 48,
				'description' => '[{"assignment_date":"'.$input_arr['assignment_date'].'"}]'
			);			
			$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);		
		}		
	}	
	
	public function load_home_tab_html ()
	{
		$data = $this->data;
		$input_arr = $this->input->post();
		$now = date('Y-m-d');
		
		$html = '';
		
		$tab_name = isset($input_arr['tab_name']) ? $input_arr['tab_name'] : "";
		$client = isset($input_arr['client']) ? $input_arr['client'] : "";
		$calendar_date = isset($input_arr['tab_name']) ? date('Y-m-d', strtotime($input_arr['date'])) : $now;
		
		$scheduled_leads = $this->lead_model->get_scheduled_leads($data['user_id'], $calendar_date);
		$scheduled_tenders = $this->lead_model->get_scheduled_tenders($data['user_id'], $calendar_date);
		$scheduled_orders = $this->lead_model->get_scheduled_orders($data['user_id'], $calendar_date);		
		$scheduled_tradeins = $this->lead_model->get_scheduled_tradeins($data['user_id'], $calendar_date);
		// print_r($scheduled_tenders);
		$html .= '
		<div class="row">
			<div class="col-md-6">
				<section class="panel" style="border: 1px solid #eee;">
					<header class="panel-heading bg-primary">
						<div class="panel-heading-icon">
							<i class="fa fa-calendar"></i>
						</div>
					</header>
					<div class="panel-body">
						<h4 class="text-semibold mt-sm text-center" style="margin-top: 10px; margin-bottom: 0px;">'.$input_arr['date'].'</h4>
						<br />
						<div class="row">';
							if (count($scheduled_leads)==0 AND $scheduled_tenders==0 AND $scheduled_orders==0 AND $scheduled_tradeins==0)
							{
								$html .= '
								<div class="col-md-12 text-center">
									<br />
									<br />
									<img src="'.base_url('assets/img/noschedule.png').'">
									<br />
									<br />
									<br />
									<br />
									<br />
									<br />
								</div>';
							}
							else
							{
								foreach ($scheduled_leads AS $scheduled_lead)
								{
									if ($scheduled_lead['status']==1)
									{
										$scheduled_lead_type = "attempted_lead";
										$scheduled_lead_class = "alert-default";						
									}
									else
									{
										$scheduled_lead_type = "unattempted_lead";
										$scheduled_lead_class = "alert-info";
									}
									$html .= '
									<div class="col-md-12">
										<div class="alert '.$scheduled_lead_class.' item_details_button" id="scheduled_lead_'.$scheduled_lead['id_lead'].'" data-id="'.$scheduled_lead['id_lead'].'" data-id_prefix="scheduled_lead" data-item_type="lead">
											<i class="fa fa-calendar scheduled_lead" data-id="'.$scheduled_lead['id_lead'].'" data-type="'.$scheduled_lead_type.'"></i>&nbsp;
											<b>'.$scheduled_lead['cq_number'].'</b> - '.$scheduled_lead['make'].' '.$scheduled_lead['model'].'
										</div>
									</div>';
								}

								foreach ($scheduled_tenders AS $scheduled_tender)
								{
									$new_quote_notification_flag = '';
									if ($scheduled_tender['new_quote_count'] > 0)
									{
										$new_quote_notification_flag = '<i class="fa fa-check-circle notification_flag_small"></i>';
									}
									
									$html .= '
									<div class="col-md-12">
										<div class="alert alert-warning item_details_button" id="scheduled_tender_'.$scheduled_tender['id_lead'].'" data-id="'.$scheduled_tender['id_lead'].'" data-id_prefix="scheduled_tender" data-item_type="tender">
											<b>'.$scheduled_tender['cq_number'].'</b> - '.$scheduled_tender['make'].' '.$scheduled_tender['model'].' '.$new_quote_notification_flag.'
										</div>
									</div>';
								}

								foreach ($scheduled_orders AS $scheduled_order)
								{
									$new_quote_notification_flag = '';
									if ($scheduled_tender['new_quote_count'] > 0)
									{
										$new_quote_notification_flag = '<i class="fa fa-check-circle notification_flag_small"></i>';
									}									
									
									$html .= '
									<div class="col-md-12">
										<div class="alert alert-success item_details_button" id="scheduled_order_'.$scheduled_order['id_lead'].'" data-id="'.$scheduled_order['id_lead'].'" data-id_prefix="scheduled_order" data-item_type="order">
											<b>'.$scheduled_order['cq_number'].'</b> - '.$scheduled_order['make'].' '.$scheduled_order['model'].' '.$new_quote_notification_flag.'
										</div>
									</div>';
								}								
							}
							$html .= '
						</div>
					</div>
				</section>
			</div>
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-12">
						<div class="alert alert-default" id="item_preview" style="min-height: 350px;">
							<br />
							<center>
								<i>Select an Item</i>
							</center>
							<br />							
						</div>							
					</div>
				</div>
			</div>			
		</div>';

		echo $html;
	}	
	
	public function load_home_calendar_tab_item_html ()
	{
		$data = $this->data;
		$input_arr = $this->input->post();

		$html = '';
		if ($input_arr['item_type'] == "lead")
		{
			$lead = $this->lead_model->get_lead($input_arr['id']);
			$lead_calculation_details = $this->calculate_revenue($lead); //
			$tradeins = $this->tradein_model->get_lead_tradeins($input_arr['id']);
			$call_logs = $this->lead_model->get_lead_call_logs($input_arr['id']);
			
			$finance = "";
			if ($lead['finance'] == 1)
			{
				$finance = "<br /><i>Possible Finance</i>";
			}
			
			$html .= '
			<h4 style="color: #58c603;"><b>'.$lead['name'].'</b></h4>
			<p>
				<b>'.$lead['cq_number'].'</b> - '.$lead['make'].' '.$lead['model'].'
				<br />
				<b>'.$lead['age'].'</b> Days Old | 
				<b>'.$lead['attempt_count'].'</b> Logged Calls
				'.$finance.'
			</p>
			<br />
			<table>
				<tr><td><b>State:</b></td><td>'.$lead['state'].'</td></tr>
				<tr><td><b>Email:</b></td><td>'.$lead['email'].'</td></tr>
				<tr><td><b>Phone:</b></td><td>'.$lead['phone'].'</td></tr>
			</table>';
			if (count($tradeins) > 0)
			{	
				$html .= '
				<hr class="solid mt-sm mb-lg">
				<h5><b>Tradeins:</b></h5>';				
				foreach ($tradeins AS $tradein)
				{
					$html .= '
					<p>
						<a href="'.site_url('tradein/record_final/'.$tradein['id_tradein']).'" target="_blank">
							<b>'.$tradein['ti_number'].'</b> - '.$tradein['tradein_make'].' '.$tradein['tradein_model'].' '.$tradein['tradein_variant'].'
						</a>
					</p>';
				}
			}
			if (count($call_logs) > 0)
			{
				$html .= '
				<hr class="solid mt-sm mb-lg">
				<p><b>Call Logs:</b></p>';				
				foreach ($call_logs AS $call_log)
				{
					$html .= '
					<p>
						<span style="color: #58c603;"><b>'.$call_log['call_status'].'</b></span> - 
						<span style="font-size: 0.9em;"><i>'.$call_log['details'].'</i></span>
						<br />
						<span style="font-size: 0.8em;">'.$call_log['created_at'].'</span>
					</p>
					';
				}				
			}
			$html .= '
			<hr class="solid mt-sm mb-lg">
			<a class="mb-xs mt-xs mr-xs btn btn-sm btn-primary btn-block" href="'.site_url('lead/record_final/'.$lead['id_lead']).'" target="_blank">
				OPEN PAGE
			</a>			
			<button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-primary btn-block call_modal_button" data-id_lead="'.$lead['id_lead'].'" data-phone="'.$lead['phone'].'" data-mobile="'.$lead['mobile'].'">
				LOG CALL
			</button>
			<button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-primary btn-block sms_modal_button" data-id_lead="'.$lead['id_lead'].'" data-phone="'.$lead['phone'].'" data-mobile="'.$lead['mobile'].'">
				SEND SMS
			</button>
			<button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-primary btn-block not_proceeding_modal_button" data-id_lead="'.$lead['id_lead'].'">
				NOT PROCEEDING
			</button>';
		}
		else if ($input_arr['item_type'] == "tender")
		{
			//echo $input_arr['id'];
			$lead = $this->lead_model->get_lead($input_arr['id']);
			//print_r($lead);
			$lead_calculation_details = $this->calculate_revenue($lead); //
			$quotes = $this->quote_model->get_tender_quotes($lead['id_quote_request']);			
			$tradeins = $this->tradein_model->get_lead_tradeins($input_arr['id']);
			$call_logs = $this->lead_model->get_lead_call_logs($input_arr['id']);
			
			$finance = "";
			if ($lead['finance'] == 1)
			{
				$finance = "<br /><i>Possible Finance</i>";
			}
			
			$html .= '
			<h4 style="color: #58c603;"><b>'.$lead['lead_name'].'</b></h4>
			<p>
				<b>'.$lead['cq_number'].'</b> - '.$lead['make'].' '.$lead['model'].'
				<br />
				<b>Started: </b>'.$lead['tender_date'].' | 
				<b>'.$lead['quote_count'].'</b> Quotes
				'.$finance.'
			</p>
			<br />
			<table>
				<tr><td><b>State:</b></td><td>'.$lead['lead_state'].'</td></tr>
				<tr><td><b>Email:</b></td><td>'.$lead['lead_email'].'</td></tr>
				<tr><td><b>Phone:</b></td><td>'.$lead['lead_phone'].'</td></tr>
			</table>';
			if (count($quotes) > 0)
			{
				$html .= '
				<hr class="solid mt-sm mb-lg">
				<p><b>Dealer Quotes:</b></p>
				<table width="100%">
					<tr>
						<td width="9%" align="center"><i class="fa fa-eye"></i></td>
						<td width="45%"><b>Dealer</b></td>
						<td width="23%"><b>Sender</b></td>						
						<td width="23%"><b>Price</b></td>
					</tr>';
					foreach ($quotes AS $quote)
					{
						$new_flag = "";
						if ($quote['seen_status']==0)
						{
							$new_flag = '
							&nbsp;<i class="fa fa-check-circle notification_flag_small"></i>';
						}
			
						$html .= '
						<tr>';
							if ($quote['seen_status'] == 1) 
							{
								$html .= '																		
								<td align="center">
									<i class="fa fa-eye" data-toggle="tooltip" title="New Quote"></i>																																										
								</td>';
							}
							else
							{
								$html .= '
								<td align="center">
									<span class="ajax_button_primary update_quote_seen_status_button" data-id_quote="'.$quote['id_quote'].'" data-seen_status="1">
										<i class="fa fa-eye" data-toggle="tooltip" title="Mark as Seen"></i>
									</span>																																												
								</td>';																						
							}	
						
							$html .= '
							<td>
								<a href="'.site_url('user/record/'.$quote['dealer_id']).'" target="_blank">
									'.$quote['name'].' '.$new_flag.'
								</a>
							</td>
							<td>'.$quote['sender'].'</td>
							<td>'.$quote['total'].'</td>
						</tr>';
					}		
					$html .= '
				</table>';				
			}			
			if (count($tradeins) > 0)
			{	
				$html .= '
				<hr class="solid mt-sm mb-lg">
				<h5><b>Tradeins:</b></h5>';				
				foreach ($tradeins AS $tradein)
				{
					$html .= '
					<p>
						<a href="'.site_url('tradein/record_final/'.$tradein['id_tradein']).'" target="_blank">
							<b>'.$tradein['ti_number'].'</b> - '.$tradein['tradein_make'].' '.$tradein['tradein_model'].' '.$tradein['tradein_variant'].'
						</a>
					</p>';
				}
			}
			if (count($call_logs) > 0)
			{
				$html .= '
				<hr class="solid mt-sm mb-lg">
				<p><b>Call Logs:</b></p>';				
				foreach ($call_logs AS $call_log)
				{
					$html .= '
					<p>
						<span style="color: #58c603;"><b>'.$call_log['call_status'].'</b></span> - 
						<span style="font-size: 0.9em;"><i>'.$call_log['details'].'</i></span>
						<br />
						<span style="font-size: 0.8em;">'.$call_log['created_at'].'</span>
					</p>';
				}				
			}
			$html .= '
			<hr class="solid mt-sm mb-lg">
			<a class="mb-xs mt-xs mr-xs btn btn-sm btn-primary btn-block" href="'.site_url('lead/record_final/'.$lead['lead_id']).'" target="_blank">
				OPEN PAGE
			</a>			
			<button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-primary btn-block call_modal_button" data-id_lead="'.$lead['lead_id'].'" data-phone="'.$lead['lead_phone'].'" data-mobile="'.$lead['lead_mobile'].'">
				LOG CALL
			</button>
			<button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-primary btn-block sms_modal_button" data-id_lead="'.$lead['lead_id'].'" data-phone="'.$lead['lead_phone'].'" data-mobile="'.$lead['lead_mobile'].'">
				SEND SMS
			</button>
			<button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-primary btn-block not_proceeding_modal_button" data-id_lead="'.$lead['lead_id'].'">
				NOT PROCEEDING
			</button>';
		}
		else if ($input_arr['item_type'] == "order")
		{
			$lead = $this->lead_model->get_lead($input_arr['id']);
			$lead_calculation_details = $this->calculate_revenue($lead); //
			$quotes = $this->quote_model->get_tender_quotes($lead['id_quote_request']);			
			$tradeins = $this->tradein_model->get_lead_tradeins($input_arr['id']);
			$call_logs = $this->lead_model->get_lead_call_logs($input_arr['id']);
			
			$finance = "";
			if ($lead['finance'] == 1)
			{
				$finance = "<br /><i>Possible Finance</i>";
			}
			
			$html .= '
			<h4 style="color: #58c603;"><b>'.$lead['name'].'</b></h4>
			<p>
				<b>'.$lead['cq_number'].'</b> - '.$lead['make'].' '.$lead['model'].'
				<br />
				<b>Started: </b>'.$lead['tender_date'].' | 
				<b>'.$lead['quote_count'].'</b> Quotes
				'.$finance.'
			</p>
			<br />
			<table>
				<tr><td><b>State:</b></td><td>'.$lead['state'].'</td></tr>
				<tr><td><b>Email:</b></td><td>'.$lead['email'].'</td></tr>
				<tr><td><b>Phone:</b></td><td>'.$lead['phone'].'</td></tr>
			</table>
			<hr class="solid mt-sm mb-lg">
			<p>
				<b>Delivery Date:</b>
				<br />
				'.$lead['delivery_date'].'
			</p>
			<p>
				<b>Delivery Address:</b>
				<br />
				'.$lead['delivery_address'].'
			</p>			
			<p>
				<b>Delivery Instructions:</b>
				<br />
				'.$lead['delivery_instructions'].'
			</p>	
			<p>
				<b>Special Conditions:</b>
				<br />
				'.$lead['special_conditions'].'
			</p>					
			';
			if (count($quotes) > 0)
			{
				$html .= '
				<hr class="solid mt-sm mb-lg">
				<p><b>Dealer Quotes:</b></p>
				<table width="100%">
					<tr>
						<td width="9%" align="center"><i class="fa fa-eye"></i></td>
						<td width="45%"><b>Dealer</b></td>
						<td width="23%"><b>Sender</b></td>						
						<td width="23%"><b>Price</b></td>
					</tr>';
					foreach ($quotes AS $quote)
					{
						$new_flag = "";
						if ($quote['seen_status']==0)
						{
							$new_flag = '
							&nbsp;<i class="fa fa-check-circle notification_flag_small"></i>';
						}
			
						$html .= '
						<tr>';
							if ($quote['seen_status'] == 1) 
							{
								$html .= '																		
								<td align="center">
									<i class="fa fa-eye" data-toggle="tooltip" title="New Quote"></i>																																										
								</td>';
							}
							else
							{
								$html .= '
								<td align="center">
									<span class="ajax_button_primary update_quote_seen_status_button" data-id_quote="'.$quote['id_quote'].'" data-seen_status="1">
										<i class="fa fa-eye" data-toggle="tooltip" title="Mark as Seen"></i>
									</span>																																												
								</td>';																						
							}	
						
							$html .= '
							<td>
								<a href="'.site_url('user/record/'.$quote['dealer_id']).'" target="_blank">
									'.$quote['name'].' '.$new_flag.'
								</a>
							</td>
							<td>'.$quote['sender'].'</td>
							<td>'.$quote['total'].'</td>
						</tr>';
					}		
					$html .= '
				</table>';				
			}	
			if (count($tradeins) > 0)
			{	
				$html .= '
				<hr class="solid mt-sm mb-lg">
				<h5><b>Tradeins:</b></h5>';				
				foreach ($tradeins AS $tradein)
				{
					$html .= '
					<p>
						<a href="'.site_url('tradein/record_final/'.$tradein['id_tradein']).'" target="_blank">
							<b>'.$tradein['ti_number'].'</b> - '.$tradein['tradein_make'].' '.$tradein['tradein_model'].' '.$tradein['tradein_variant'].'
						</a>
					</p>';
				}
			}
			if (count($call_logs) > 0)
			{
				$html .= '
				<hr class="solid mt-sm mb-lg">
				<p><b>Call Logs:</b></p>';				
				foreach ($call_logs AS $call_log)
				{
					$html .= '
					<p>
						<span style="color: #58c603;"><b>'.$call_log['call_status'].'</b></span> - 
						<span style="font-size: 0.9em;"><i>'.$call_log['details'].'</i></span>
						<br />
						<span style="font-size: 0.8em;">'.$call_log['created_at'].'</span>
					</p>';
				}				
			}
			$html .= '
			<hr class="solid mt-sm mb-lg">
			<a class="mb-xs mt-xs mr-xs btn btn-sm btn-primary btn-block" href="'.site_url('lead/record_final/'.$lead['id_lead']).'" target="_blank">
				OPEN PAGE
			</a>			
			<button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-primary btn-block call_modal_button" data-id_lead="'.$lead['id_lead'].'" data-phone="'.$lead['phone'].'" data-mobile="'.$lead['mobile'].'">
				LOG CALL
			</button>
			<button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-primary btn-block sms_modal_button" data-id_lead="'.$lead['id_lead'].'" data-phone="'.$lead['phone'].'" data-mobile="'.$lead['mobile'].'">
				SEND SMS
			</button>
			<button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-primary btn-block" data-id_lead="'.$lead['id_lead'].'">
				CANCEL DEAL
			</button>';
		}		

		echo $html;
	}
	// HOME V2 (End) //
	
	// LEAD PAGE (Start) //
	public function upload_file ($directory) // BACKGROUND ACTION //
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;
		
		$directory = './uploads/'.$directory.'/';
		$prefix = time().'_'.$data['user_id'].'_';
		$file_name = $_FILES['file']['name'];
		$file_tmp = $_FILES['file']['tmp_name'];
		$file = $directory.$prefix.$file_name;

		if (move_uploaded_file($file_tmp, $file))
		{
			echo $file;
		}
	}	
	
	public function upload_email_attachments () // BACKGROUND ACTION //
	{
		$directory = "uploads/temp/";
		$prefix = time() . '_';
		$file_name = $_FILES['file']['name'];
		$file_tmp = $_FILES['file']['tmp_name'];
		$file = $directory.$prefix.$file_name;
		
	    if (move_uploaded_file($file_tmp, $file))
		{
			echo $file;
	    }
	}

	public function record_final ($lead_id) // PAGE VIEW (LP) // AUDIT TRAIL OK //
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;
		
		$data['title'] = "Lead";

		$admins = $this->user_model->get_admins(); // M Object

		$audit_trail_arr = array(
			'id' => $lead_id,
			'table_name' => 'leads',
			'action' => 29,
			'description' => ''
		);
		$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);		
		$this->action_model->insert_action(1, $lead_id, $data['user_id'], 'Opened the Lead');

		// Requirements //
		$lead_call_status = $this->lead_model->get_lead_call_status(); // M Array
		//
		
		$next_lead = $this->lead_model->get_next_lead_id($lead_id, $data['user_id']); // S Array
		$previous_lead = $this->lead_model->get_previous_lead_id($lead_id, $data['user_id']); // S Array

		$lead = $this->lead_model->get_lead($lead_id); // S Array
		//echo json_encode($lead); die();
		$lead_calculation_details = $this->calculate_revenue($lead); // S Array
		$lead_files = $this->lead_model->get_lead_files($lead_id); // M Array
		$lead_dealer_files = $this->lead_model->get_dealer_files($lead_id); // M Array
		$lead_comments = $this->lead_model->get_lead_comments($lead_id); // M Array
		$lead_invoices = $this->invoice_model->get_lead_invoices($lead_id); // M Array
		$lead_payments = $this->payment_model->get_lead_payments($lead_id); // M Array
		$lead_call_logs = $this->lead_model->get_lead_call_logs($lead_id); // M Array
		$lead_events = $this->lead_model->get_lead_events(array('fk_lead' => $lead_id, 'status' => 0)); // M Array
		$lead_aftersales_accessories = $this->lead_model->get_deal_accessories($lead_id); // M Array

		$audit_trail_params = array(
			'id' => $lead_id,
			'table_name' => 'leads'
		);
		$lead_audit_trails = $this->audit_model->get_audit_trails($audit_trail_params); // M Array
		
		$email_params = array(
			'email' => $lead['email'],
			'alternate_email_1' => $lead['alternate_email_1'],
			'alternate_email_2' => $lead['alternate_email_2'],
			'cq_number' => $lead['cq_number']
		);
		// $lead_emails = $this->lead_model->get_lead_emails($email_params);
		$lead_emails = array();
		foreach ($admins AS $admin)
		{			
			if ($admin->username == $lead['email'])
			{
				$lead_emails = [];
			}
		}

		$data['make_logo'] = "http://www.myelquoto.com.au/global_images/makes/".str_replace(' ', '_', strtolower($lead['make'])).".png";
		
		$data['lead_call_status'] = $lead_call_status;
		$data['bank_accounts'] = $this->settings_model->get_bank_accounts();
		
		$data['lead'] = $lead;
		
		if (isset($previous_lead['id_lead']))
		{
			$data['previous_lead_id'] = $previous_lead['id_lead'];
		}
		else
		{
			$data['previous_lead_id'] = "";
		}
		
		if (isset($next_lead['id_lead']))
		{
			$data['next_lead_id'] = $next_lead['id_lead'];
		}
		else
		{
			$data['next_lead_id'] = "";
		}		
			
		$data['lead_calculation_details'] = $lead_calculation_details;
		$data['lead_comments'] = $lead_comments;
		$data['lead_aftersales_accessories'] = $lead_aftersales_accessories;
		$data['lead_emails'] = $lead_emails;
		
		$data['lead_invoices'] = $lead_invoices;
		$data['lead_payments'] = $lead_payments;		
		$data['lead_audit_trails'] = $lead_audit_trails;

		// Right Sidebar //		
		$data['lead_files'] = $lead_files;
		$data['lead_dealer_files'] = $lead_dealer_files;
		$data['lead_quotes'] = array();

		$data['lead_suggested_tradeins'] = $this->lead_model->get_lead_suggested_tradeins($lead['name'], $lead['email'], $lead['phone'], $lead['mobile']);
		$data['lead_attached_tradeins'] = $this->lead_model->get_lead_attached_tradeins($lead_id);
		
		$data['lead_call_logs'] = $lead_call_logs;
		$data['lead_events'] = $lead_events;
		
		$data['deal_requirements'] = $this->deal_requirements($lead_id);
		

		if ($lead['status']==3 OR $lead['status']==4 OR $lead['status']==5 OR $lead['status']==6 OR $lead['status']==7 OR $lead['status']==8 OR $lead['status']==9)
		{
			$tender_dealers = $this->request_model->get_tender_dealers($lead['id_quote_request']);
			$tender_email_invites = $this->request_model->get_tender_email_invites($lead['id_quote_request']);		
			$tender_quotes = $this->quote_model->get_tender_quotes($lead['id_quote_request']);
			$tender_quote_files = $this->request_model->get_files_lead($lead['id_quote_request']);	
			$tender_same_variant_quotes = $this->quote_model->get_tender_same_variant_quotes($lead['id_quote_request'], $lead['id_make'], $lead['id_family'], $lead['id_vehicle']);
			$tender_same_model_quotes = $this->quote_model->get_tender_same_model_quotes($lead['id_quote_request'], $lead['id_make'], $lead['id_family'], $lead['id_vehicle']);			
			
			$data['tender_dealers'] = $tender_dealers;
			$data['tender_email_invites'] = $tender_email_invites;
			$data['tender_quotes'] = $tender_quotes;
			$data['tender_quote_files'] = $tender_quote_files;		
			$data['tender_same_variant_quotes'] = $tender_same_variant_quotes;
			$data['tender_same_model_quotes'] = $tender_same_model_quotes;			
		}

		$this->load->view('admin/lead', $data);
	}

	public function update_record () // BUTTON ACTION // AUDIT TRAIL OK // RECHECK NOTIF TO PARAM AND JENO //
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;
		
		$input_arr = $this->input->post();

		$lead_arr = $this->lead_model->get_lead($input_arr['id_lead']);
		//echo json_encode($lead_arr); die();
		/*
		if (isset($input_arr['deduct_to_dealer_invoice'])) 
		{
			$input_arr['deduct_to_dealer_invoice'] = 1; 
		}
		else 
		{ 
			$input_arr['deduct_to_dealer_invoice'] = 0; 
		}

		if (isset($input_arr['delivery_address_map'])) 
		{ 
			$input_arr['delivery_address_map'] = 1; 
		}
		else 
		{ 
			$input_arr['delivery_address_map'] = 0; 
		}
		*/

		$changed_fields_string = $this->changed_fields($lead_arr, $input_arr);
	//	echo json_encode($changed_fields_string); 
		if ($changed_fields_string <> "")
		{
			if (isset($input_arr['status']) AND $input_arr['status'] == 100)
			{
				if ($lead_arr['attempted_date'] == "0000-00-00 00:00:00")
				{
					$input_arr['attempted_date'] = $now;
				}
			}
			else if (isset($input_arr['status']) AND $input_arr['status'] == 3)
			{
				if ($lead_arr['attempted_date'] == "0000-00-00 00:00:00")
				{
					$input_arr['attempted_date'] = $now;
				}
			}
			else if ($lead_arr['status'] <= 1)
			{
				$input_arr['status'] = 2;
				$input_arr['attempted_date'] = $now;
			}

			$update_lead_result = $this->lead_model->update_lead_details($input_arr);
		//	echo json_encode($update_lead_result); die();
			if ($update_lead_result)
			{
				if ($lead_arr['deal_flag']==1)
				{
					$computation_change = 0;
					$computation_fields_arr = array(
						'answer_act',
						'answer_vic',
						'answer_qld',
						'sales_price',
						'tradein_value',
						'tradein_given',
						'tradein_payout',
						'other_costs_amount',
						'other_costs_description',
						'other_revenue_amount',
						'other_revenue_description'
					);
					
					$delivery_change = 0;
					$delivery_fields_arr = array(
						'delivery_date',
						'delivery_address',
						'delivery_instructions',
						'special_conditions'
					);
					
					$settlement_change = 0;	
					$settlement_fields_arr = array(
						'settled_date'
					);

					$change_text = $data['name']." did some changes";
					$changed_fields_array = $this->changed_fields_array($lead_arr, $input_arr);
					foreach ($changed_fields_array AS $changed_field)
					{
						if (in_array($changed_field['field'], $computation_fields_arr)) { $computation_change ++; }
						if (in_array($changed_field['field'], $delivery_fields_arr)) { $delivery_change ++; }
						if (in_array($changed_field['field'], $settlement_fields_arr)) { $settlement_change ++; }
					}
					
					if ($computation_change > 0) { $change_text .= " [Computation]"; }
					if ($delivery_change > 0) { $change_text .= " [Delivery Details]"; }
					if ($settlement_change > 0) { $change_text .= " [Settlement Details]"; }

					$change_text .= ' on <b><a href="'.site_url('lead/record_final/'.$lead_arr['id_lead']).'" target="_blank">'.$lead_arr['cq_number'].'</a></b>';
					
					if ($computation_change <> 0 OR $delivery_change <> 0 OR $settlement_change <> 0)
					{
						if ($data['user_id'] <> 427)
						{
							$notification_message = $change_text;
							$this->notification_model->add_notification(1, $notification_message);
							$notification_id = $this->db->insert_id();
							$this->notification_model->add_notification_user($notification_id, 427);
							$this->notification_model->add_notification_user($notification_id, 255);
						}				
					}
				}

				$audit_trail_arr = array(
					'id' => $input_arr['id_lead'],
					'table_name' => 'leads',
					'action' => 2,
					'description' => $changed_fields_string
				);
				$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);
				$this->action_model->insert_action(1, $input_arr['id_lead'], $data['user_id'], 'Update');
				
				echo "success";
			}
			else
			{
				echo "fail";
			}
		}
		else
		{
			echo "nochanges";
		}		
	}	
	
	public function add_call_log () // MODAL ACTION // AUDIT TRAIL OK //
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;

		$input_arr = $this->input->post();
		
		if ($input_arr['fk_call_status'] == 2) 
		{
			$this->templated_client_email_init(6, $input_arr['id_lead'], 'qs'); 
			$email_type = "Bad Contact"; 
		}
		else if ($input_arr['fk_call_status'] == 3) 
		{
			$this->templated_client_email_init(5, $input_arr['id_lead'], 'qs'); 
			$email_type = "No Answer"; 
		}
		else
		{
			$email_type = "";
		}

		$insert_result = $this->lead_model->insert_lead_call_log($data['user_id'], $input_arr);

		if ($insert_result)
		{
			$audit_trail_arr = array(
				'id' => $input_arr['id_lead'],
				'table_name' => 'leads',
				'action' => 50,
				'description' => '[{"fk_call_status":"'.$input_arr['fk_call_status'].'","details":"'.$input_arr['details'].'"}]'
			);			
			$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);			
			
			echo "success";
		}
		else
		{
			echo "fail";
		}
	}
	
	public function add_lead_files ()
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;

		$input_arr = $this->input->post();
		
		if (isset($input_arr['attachment_array']))
		{		
			foreach ($input_arr['attachment_array'] AS $attachment)
			{
				$lead_file_arr = array(
					'id_lead' => $input_arr['id_lead'],
					'file_name' => $this->substring_index($attachment, 'uploads/cq_files/', -1),
				);
				$this->lead_model->insert_lead_file($data['user_id'], $lead_file_arr);
			}
		}
		
		echo "success";
	}	
	
	public function send_lead_event () // MODAL ACTION // AUDIT TRAIL OK //
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;

		$input_arr = $this->input->post();
		
		if (isset($input_arr['id_lead_event']) AND $input_arr['id_lead_event'] <> "" AND $input_arr['id_lead_event'] <> 0)
		{
			$update_result = $this->lead_model->update_lead_event($data['user_id'], $input_arr);
			
			if ($update_result)
			{
				$audit_trail_arr = array(
					'id' => $input_arr['id_lead'],
					'table_name' => 'leads',
					'action' => 52,
					'description' => ''
				);			
				$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);				
				
				echo "success";
			}
			else
			{
				echo "fail";
			}			
		}
		else
		{
			$insert_result = $this->lead_model->insert_lead_event($data['user_id'], $input_arr);
			
			if ($insert_result)
			{
				$audit_trail_arr = array(
					'id' => $input_arr['id_lead'],
					'table_name' => 'leads',
					'action' => 51,
					'description' => '[{"date":"'.$input_arr['date'].'","time":"'.$input_arr['time'].'","details":"'.$input_arr['details'].'"}]'
				);			
				$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);				
				
				echo "success";
			}
			else
			{
				echo "fail";
			}			
		}
	}

	public function delete_lead_event () // SUBMODAL ACTION // AT OK //
	{
		$now = date("Y-m-d H:i:s");		
		$data = $this->data;

		$input_arr = $this->input->post();

		$delete_lead_event_result = $this->lead_model->delete_lead_event($input_arr['id_lead_event']);
		
		if ($delete_lead_event_result)
		{
			/*
			$audit_trail_arr = array(
				'id' => $input_arr['id_lead'],
				'table_name' => 'leads',
				'action' => 13,
				'description' => ''
			);
			$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);
			$this->action_model->insert_action(1, $input_arr['id_lead'], $data['user_id'], 'Winning Quote '.$notification_parameter);
			*/
			
			echo "success";
		}
		else
		{
			echo "fail";
		}
	}
	
	public function update_lead_event_status () // SUBMODAL ACTION // AT OK //
	{
		$now = date("Y-m-d H:i:s");		
		$data = $this->data;

		$input_arr = $this->input->post();

		$update_lead_event_status_result = $this->lead_model->update_lead_event_status($input_arr['id_lead_event'], $input_arr['status']);
		
		if ($update_lead_event_status_result)
		{
			/*
			$audit_trail_arr = array(
				'id' => $input_arr['id_lead'],
				'table_name' => 'leads',
				'action' => 13,
				'description' => ''
			);
			$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);
			$this->action_model->insert_action(1, $input_arr['id_lead'], $data['user_id'], 'Winning Quote '.$notification_parameter);
			*/
			
			echo "success";
		}
		else
		{
			echo "fail";
		}
	}	
	
	public function update_quote_seen_status () // SUBMODAL ACTION // AT OK //
	{
		$now = date("Y-m-d H:i:s");		
		$data = $this->data;

		$input_arr = $this->input->post();

		$update_quote_seen_status_result = $this->quote_model->update_quote_seen_status($input_arr['id_quote'], $input_arr['seen_status']);
		
		if ($update_quote_seen_status_result)
		{
			/*
			$audit_trail_arr = array(
				'id' => $input_arr['id_lead'],
				'table_name' => 'leads',
				'action' => 13,
				'description' => ''
			);
			$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);
			$this->action_model->insert_action(1, $input_arr['id_lead'], $data['user_id'], 'Winning Quote '.$notification_parameter);
			*/
			
			echo "success";
		}
		else
		{
			echo "fail";
		}
	}		

	public function generate_lead_event_json ()
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;
		
		$input_arr = $this->input->post();	

		$lead_event = $this->lead_model->get_lead_event($input_arr['id_lead_event']);

		$response_array = [
			'date' => $lead_event['date'],
			'time' => $lead_event['time'],
			'details' => $lead_event['details']
		];

		echo json_encode($response_array);		
	}	
	
	public function send_lead_sms () // NO CODES YET //
	{
		
	}
	
	// SENDING OF EMAIL IS ON DEAL CONTROLLER  BECAUSE OF INVOICE GENERATION //
	
	public function add_comment_new () // MODAL ACTION // AUDIT TRAIL //
	{
		$data = $this->data;
		$input_arr = $this->input->post();

		$input_arr['user_id'] = $data['user_id'];
		
		$insert_comment_result = $this->comment_model->insert_comment($input_arr['id_lead'], 1, $input_arr);

		/*
		$comment_id = $this->db->insert_id();
		if (isset($_POST['al_uploaded_comment_file']))
		{
			foreach ($_POST['al_uploaded_comment_file'] AS $uploaded_file)
			{
				$file_name = str_replace('./uploads/cq_files/', '', $uploaded_file);
				$this->comment_model->insert_comment_attachment($comment_id, $file_name);
			}
		}

		if ($input_arr['lead_status'] <= 1)
		{
			$this->lead_model->update_lead_status($input_arr['id_lead'], 2);
			$this->lead_model->update_lead_date($input_arr['id_lead'], $now, 'attempted_date');
		}
		*/
		
		if ($insert_comment_result)
		{
			$audit_trail_arr = array(
				'id' => $input_arr['id_lead'],
				'table_name' => 'leads',
				'action' => 7,
				'description' => ''
			);
			$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);		
			$this->action_model->insert_action(1, $input_arr['id_lead'], $data['user_id'], 'Added a Comment');			
			
			echo "success";
		}
		else
		{
			echo "fail";
		}
	}	
	
	public function attach_trade () // BUTTON ACTION // NO AUDIT TRAIL YET // NOTIF TO PARAM //
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;

		$input_arr = $this->input->post();
		
		$input_arr['lead_id'] = $input_arr['id_lead'];
		$input_arr['tradein_id'] = $input_arr['id_tradein'];

		$update_result = $this->tradein_model->attach_tradein($input_arr);
		
		if ($update_result)
		{
			$lead = $this->lead_model->get_lead($input_arr['id_lead']);
			if (isset($lead['deal_flag']))
			{
				if ($lead['deal_flag']==1)
				{
					if ($data['user_id'] <> 427)
					{
						$cq_number = "QM".str_pad($input_arr['id_lead'], 5, '0', STR_PAD_LEFT);
						$notification_message = '<b><a href="'.site_url('lead/record_final/'.$input_arr['id_lead']).'" target="_blank">'.$cq_number.'</a></b> - '.$data['name'].' attached a trade';
						$this->notification_model->add_notification(1, $notification_message);
						$notification_id = $this->db->insert_id();
						$this->notification_model->add_notification_user($notification_id, 427);
					}
				}
			}			
			
			echo "success";
		}
		else		
		{
			echo "fail";
		}
	}

	public function unattach_trade () // BUTTON ACTION // NO AUDIT TRAIL YET // NOTIF TO PARAM //
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;

		$input_arr = $this->input->post();
		
		$input_arr['lead_id'] = $input_arr['id_lead'];
		$input_arr['tradein_id'] = $input_arr['id_tradein'];

		$update_result = $this->tradein_model->unattach_tradein($input_arr);
		
		if ($update_result)
		{
			$lead = $this->lead_model->get_lead($input_arr['id_lead']);
			if (isset($lead['deal_flag']))
			{
				if ($lead['deal_flag']==1)
				{
					if ($data['user_id'] <> 427)
					{
						$cq_number = "QM".str_pad($input_arr['id_lead'], 5, '0', STR_PAD_LEFT);
						$notification_message = '<b><a href="'.site_url('lead/record_final/'.$input_arr['id_lead']).'" target="_blank">'.$cq_number.'</a></b> - '.$data['name'].' unattached a trade';
						$this->notification_model->add_notification(1, $notification_message);
						$notification_id = $this->db->insert_id();
						$this->notification_model->add_notification_user($notification_id, 427);
					}
				}
			}			
			
			echo "success";
		}
		else		
		{
			echo "fail";
		}
	}
	
	public function test_client_email ($lead_id)
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;
		
		$lead = $this->lead_model->get_lead($lead_id);
		$deal_agreement_link = "http://www.myelquoto.com.au/vehicle_order/client_agreement?id=".$lead_id."&key=".$lead['client_key'];
		
		$tradein_content = '';
		$tradeins_result = $this->tradein_model->lead_tradein_flagger($lead_id);
		if (count($tradeins_result) > 0)
		{
			$upload_url = '';
			foreach ($tradeins_result as $tradein_key => $tradein_result)
			{
				if ($tradein_result['upload_key']=="")
				{
					$upload_key = md5($tradein_result['id_tradein']."-".$this->random_string(5));
					$this->tradein_model->update_upload_key($tradein_result['id_tradein'], $upload_key);
				}
				else
				{
					$upload_key = $tradein_result['upload_key'];
				}
				$upload_url .= '
				<a href="http://www.myelquoto.com.au/client_upload?id='.$tradein_result['id_tradein'].'&key='.$upload_key.'">
					'.$tradein_result['tradein_make'].' '.$tradein_result['tradein_model'].' '.$tradein_result['tradein_variant'].'
				</a>
				<br />';
			}

			$tradein_content .= '
			<br />
			<br />
			<br />
			<p style="line-height: 1.3; font-size: 1.3em;">
				Please click the link/s below to upload your tradein documents.
			</p>
			<p style="line-height: 1.3; font-size: 1.3em;">
				'.$upload_url.'
			</p>					
			<p style="line-height: 1.3; font-size: 1.3em;">
				You can also email them to '.$data['company']['company_email'].'
			</p>';
		}
		
		$from_email = $data['company']['company_email'];
		$from_name = $data['company']['company_name'];
		$to = "jeno.g.cabrera@gmail.com";
		$subject = "Congratulations On Your New Car Order - ".$data['company']['company_name']." Email Confirmation";
		
		$content = '
		<p style="line-height: 1.3; font-size: 1.3em;">
			Hi '.$this->substring_index(trim($lead['name']), ' ', 1).',
		</p>
		<p style="line-height: 1.3; font-size: 1.3em;">
			Congratulations on your new car purchase. 			
		</p>
		<p style="line-height: 1.3; font-size: 1.3em;">
			Please click the following link to confirm your order:
		</p>
		<a href="'.$deal_agreement_link.'" target="_blank">
			<img src="'.base_url('assets/img/email_button_order_confirmation.png').'" style="width: 100%">
		</a>
		'.$tradein_content.'
		<p style="line-height: 1.3; font-size: 1.3em;">
			<br />
			<br />
			Thank you for your business,
			<br />
			<b>'.$data['company']['company_name'].'</b>
		</p>';
		$this->send_templated_email($from_email, $from_name, $to, $subject, $content, $file = "");		
	}
	
	public function update_status ()
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;

		$input_arr = $this->input->post();

		if ($input_arr['status'] == 3)
		{
			$status_label = "Tendering";
			$actions_text = "Converted Back to Tendering";
			$date_field = "";
			$notification_text = "converted back to tender";	
		}
		else if ($input_arr['status'] == 5)
		{
			$status_label = "Approved by Admin";
			$actions_text = "Deal Approved";
			$date_field = "approved_date";
			$notification_text = "approved";

			$lead = $this->lead_model->get_lead($input_arr['id_lead']);

			$client_key = md5($input_arr['id_lead']."-".$this->random_string(5));
			$this->lead_model->update_lead_client_key($input_arr['id_lead'], $client_key);
			
			$deal_agreement_link = "http://www.myelquoto.com.au/vehicle_order/client_agreement?id=".$input_arr['id_lead']."&key=".$client_key;

			$tradein_content = '';
			$tradeins_result = $this->tradein_model->lead_tradein_flagger($input_arr['id_lead']);
			if (count($tradeins_result) > 0)
			{
				$upload_url = '';
				foreach ($tradeins_result as $tradein_key => $tradein_result)
				{
					if ($tradein_result['upload_key']=="")
					{
						$upload_key = md5($tradein_result['id_tradein']."-".$this->random_string(5));
						$this->tradein_model->update_upload_key($tradein_result['id_tradein'], $upload_key);
					}
					else
					{
						$upload_key = $tradein_result['upload_key'];
					}
					$upload_url .= '
					<a href="http://www.myelquoto.com.au/client_upload?id='.$tradein_result['id_tradein'].'&key='.$upload_key.'">
						'.$tradein_result['tradein_make'].' '.$tradein_result['tradein_model'].' '.$tradein_result['tradein_variant'].'
					</a>
					<br />';
				}

				$tradein_content .= '
				<br />
				<br />
				<br />
				<p style="line-height: 1.3; font-size: 1.3em;">
					Please click the link/s below to upload your tradein documents.
				</p>
				<p style="line-height: 1.3; font-size: 1.3em;">
					'.$upload_url.'
				</p>					
				<p style="line-height: 1.3; font-size: 1.3em;">
					You can also email them to '.$data['company']['company_email'].'
				</p>';
			}
			
			$from_email = $data['company']['company_email'];
			$from_name = $data['company']['company_name'];
			$to = $lead['email'];
			$subject = "Congratulations On Your New Car Order - ".$data['company']['company_name']." Email Confirmation";
			
			$content = '
			<p style="line-height: 1.3; font-size: 1.3em;">
				Hi '.$this->substring_index(trim($lead['name']), ' ', 1).',
			</p>
			<p style="line-height: 1.3; font-size: 1.3em;">
				Congratulations on your new car purchase. 			
			</p>
			<p style="line-height: 1.3; font-size: 1.3em;">
				Please click the following link to confirm your order:
			</p>
			<a href="'.$deal_agreement_link.'" target="_blank">
				<img src="'.base_url('assets/img/email_button_order_confirmation.png').'" style="width: 100%">
			</a>
			'.$tradein_content.'
			<p style="line-height: 1.3; font-size: 1.3em;">
				<br />
				<br />
				Thank you for your business,
				<br />
				<b>'.$data['company']['company_name'].'</b>
			</p>';
			$this->send_templated_email($from_email, $from_name, $to, $subject, $content, $file = "");

			$from_email = $data['company']['company_email'];
			$from_name = $data['company']['company_name'];
			$to = $lead['dealer_email'];
			$subject = "New Vehicle Order";
			$content = '
			<p style="line-height: 1.5">
				An order has been submitted for your approval, please log on now to check the details and accept the order.
			</p>
			<p style="line-height: 1.5">
				<br><br>
				Thank you for your business,
				<br>
				<b>'.$data['company']['company_name'].'</b>
			</p>';
			$this->send_templated_email($from_email, $from_name, $to, $subject, $content, $file = "");
		}
		else if ($input_arr['status'] == 6)
		{
			$status_label = "Delivered";
			$actions_text = "Deal Delivered";
			$date_field = "";
			$notification_text = "marked as Delivered";
		}
		else if ($input_arr['status'] == 7)
		{
			$status_label = "Settled";
			$actions_text = "Deal Settled";
			$date_field = "";
			$notification_text = "marked as Settled";
		}
		else if ($input_arr['status'] == 8)
		{
			$status_label = "Admin on Hold";
			$actions_text = "Put on Hold";
			$date_field = "";
			$notification_text = "marked as On Hold";
		}
		else if ($input_arr['status'] == 9)
		{
			$status_label = "Deal Cancelled";
			$actions_text = "Deal Cancelled";
			$date_field = "cancelled_date";
			$notification_text = "marked as Cancelled";
		}

		$update_arr = array(
			"id_lead" => $input_arr['id_lead'],
			"status" => $input_arr['status']
		);
		
		if ($date_field <> "")
		{
			$update_arr[$date_field] = $now;
		}
		
		$update_lead_result = $this->lead_model->update_lead_details($update_arr);
		
		if ($update_lead_result)
		{
			$audit_trail_arr = array(
				'id' => $input_arr['id_lead'],
				'table_name' => 'leads',
				'action' => 17,
				'description' => '[{"status":"'.$status_label.'"}]'
			);
			$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);	
			$this->action_model->insert_action(1, $input_arr['id_lead'], $data['user_id'], $actions_text);
			
			if ($data['user_id'] <> 427)
			{
				$cq_number = "QM".str_pad($input_arr['id_lead'], 5, '0', STR_PAD_LEFT);
				$notification_message = '<b><a href="'.site_url('lead/record_final/'.$input_arr['id_lead']).'" target="_blank">'.$cq_number.'</a></b> - '.$data['name'].' '.$notification_text;
				$this->notification_model->add_notification(1, $notification_message);
				$notification_id = $this->db->insert_id();
				$this->notification_model->add_notification_user($notification_id, 427);
			}			

			echo "success";
		}
		else
		{
			echo "fail";
		}
	}

	public function get_lead_car_ids () // GETTING IDS OF LEAD MAKE AND MODEL //
	{
		$input_arr = $this->input->post();
		if(isset($input_arr['from'])) {
			$result = $this->lead_model->get_lead_car_ids($input_arr['id_lead'],$input_arr['from']);
		}
		else {
			$result = $this->lead_model->get_lead_car_ids($input_arr['id_lead']);
		}
		echo json_encode($result);
	}
	// public function get_lead_car_ids () // GETTING IDS OF LEAD MAKE AND MODEL //
	// {
		// $input_arr = $this->input->post();
		// $result = $this->lead_model->get_lead_car_ids($input_arr['id_lead']);
		// echo json_encode($result);
	// }
	
	public function get_dealer_selector_parameters () // FOR GENERATING DEFAULT PARAMETERS ON SUGGESTED DEALERS
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;		
		
		$input_arr = $this->input->post();

		$result = $this->lead_model->get_dealer_selector_parameters($input_arr['id_lead'], $input_arr['type']);
		echo json_encode($result);
	}

	public function get_wholesaler_selector_parameters () // FOR GENERATING DEFAULT PARAMETERS ON SUGGESTED WHOLESALERS
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;		
		
		$input_arr = $this->input->post();
		$result = $this->lead_model->get_wholesaler_selector_parameters($input_arr['id_lead'], $input_arr['type']);
		echo json_encode($result);
	}
	
	public function get_suggested_dealers ($quote_request_id = 0) // MODAL VIEW //
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;
		
		$input_arr = $this->input->post();		

		$suggested_dealers = $this->user_model->get_suggested_dealers($input_arr['make'], $input_arr['postcode'], $input_arr['state'], $quote_request_id);
		if ($suggested_dealers->num_rows() > 0)
		{
			$html = '
			<div class="table-responsive" style="white-space: nowrap;">
				<table class="table table-bordered table-striped table-condensed mb-none">
					<thead>						
						<tr>
							<th></th>
							<th>Email</th>
							<th>Dealership</th>
							<th>Address</th>
							<th>Postcode</th>
							<th>State</th>
							<th>Invites</th>
							<th>Quotes</th>
							<th>Won</th>
							<th>Orders</th>
						</tr>
					</thead>
					<tbody>';
						foreach($suggested_dealers->result() as $dealer)
						{
							$gold_status_flag = ($dealer->gold_status == 1) ? '<i class="fa fa-star" style="color: #FFD700;" ></i>' : '';
							$html .= '
							
							<tr id="suggested_dealer_'.$dealer->id_user.'">
								<td align="center">
									<span onclick="select_suggested_dealer(\''.$input_arr['container'].'\', '.$dealer->id_user.')" style="cursor: pointer; cursor: hand; color: #58c603;">
										<i class="fa fa-plus"></i>
									</span>
								</td>
								<td id="dealer_'.$dealer->id_user.'">'.$dealer->username.' &nbsp; '.$gold_status_flag.'</td>
								<td>'.$dealer->dealership_name.'</td>									
								<td>'.$dealer->dealership_address.'</td>
								<td>'.$dealer->postcode.'</td>
								<td>'.$dealer->state.'</td>
								<td>'.$dealer->tender_count.'</td>
								<td>'.$dealer->quote_count.'</td>
								<td>'.$dealer->won_count.'</td>
								<td>'.$dealer->order_count.'</td>
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
						<th></th>
						<th>Email</th>
						<th>Dealership</th>
						<th>Address</th>
						<th>Postcode</th>
						<th>State</th>
						<th>Invites</th>
						<th>Quotes</th>
						<th>Won</th>
						<th>Orders</th>
					</thead>					
					<tbody>
						<tr><td colspan="10"><center><i>No dealers found!</i></center></td></tr>
					</tbody>
				</table>
			</div>';
			
		}
		
		$html .='<script> 
		
	function select_suggested_dealer (container, id_user)
			{
				if (container == "add_quote_modal")
				{
					var username = $("#"+container).find("#dealer_"+id_user).html();
					var id_quote_request = $("#"+container).find("#id_quote_request").val();
					var demo = $("#"+container).find("#demo").val();			

					var data = {
						id_user: id_user
					};

					$.ajax({
						type: "POST",
						url: "'.site_url('user/get_dealer_state').'",
						data: data,
						cache: false,
						success: function(response){
							$("#"+container).find("#selected_dealers .norecord").prop("hidden", true);
							$("#"+container).find("#selected_dealers").html("<tr><td><input type="hidden" value="+id_user+" id="dealer_id_inp" name="dealer_id">"+username+"</td><td></td></tr>");
							
							$("#"+container).find("#dealer_state").val(response);
							$("#"+container).find("#transport_checkbox").val("");
							if ($("#dealer_state").val() != $("#client_state").val() && parseInt($("#tradein_count").val()) > 0)
							{
								$("#"+container).find("#transport_checkbox_container").prop("hidden", false);
							}
							else
							{
								$("#"+container).find("#transport_checkbox_container").prop("hidden", true);
							}
							
							check_existing_quote(container);
						}
					});
				}
			else if (container == "add_dealers_modal" || container == "start_tender_modal")
				{
					var dealer_ids = $("#"+container).find("#dealer_ids_inp").val();
					var username = $("#"+container).find("#dealer_"+id_user).html();

					$("#"+container).find("#selected_dealers .norecord").prop("hidden", true);
					$("#"+container).find("#selected_dealers").append("<tr id="selected_dealer_"+id_user+""><td width="90%">"+username+"</td><td><center><span style="cursor: pointer; cursor: hand; color: #58c603;" onclick="delete_dealer(\'"+container+"\', "+id_user+")"><i class="fa fa-times"></i></span></center></td></tr>");
					
					$("#"+container).find("#dealer_ids_inp").val(dealer_ids+"-"+id_user);
					$("#"+container).find("#suggested_dealer_"+id_user).remove();
				}
			}
		
		</script>';
		
		
		echo $html;
	}
	
	// DEALER EMAIL (Start) //
	public function get_accountant_email_templates ()
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;
		
		$input_arr = $this->input->post();	

		$winner_details = $this->lead_model->get_winning_dealer($input_arr['id_lead']);
		
		if ($winner_details['deposit_show_status'] == 1)
		{
			$show_status = "Client Deposits are shown on paperworks for this dealer.";
		}
		else
		{
			$show_status = "Client Deposits are hidden on paperworks for this dealer.";
		}

		$result = $this->lead_model->get_accountant_email_templates();

		$html = '<option value="0"></option>';
		foreach ($result as $r_key => $r_val) 
		{
			$html .= '<option value="'.$r_val['id_email_template'].'">'.$r_val['description'].'</option>';
		}

		$response_array = [
			'email_options' => $html,
			'show_status'   => $show_status
		];

		echo json_encode($response_array);
	}
	
	public function get_accountant_email_template ()
	{
		$response_array = [];

		$email_id = $this->input->post('id_template');
		$lead_id = $this->input->post('id_lead');
		$dealer_balance = $this->input->post('dealer_balance');

		$email_template = $this->settings_model->get_email_template($email_id);
		$lead_details = $this->lead_model->get_lead_for_email($lead_id);

		$subject = $email_template['subject'];
		$content = $email_template['content'];

		$content = str_replace('“AMOUNT DUE”', $dealer_balance, $content);
		
		foreach ($this->dynamic_fields AS $dynamic_field)
		{
			if (isset($lead_details[str_replace('_]', '', str_replace('[_', '', $dynamic_field))]))
			{
				$subject = str_replace($dynamic_field, $lead_details[str_replace('_]', '', str_replace('[_', '', $dynamic_field))], $subject);
				$content = str_replace($dynamic_field, $lead_details[str_replace('_]', '', str_replace('[_', '', $dynamic_field))], $content);
			}

			if (isset($this->settings[str_replace('_]', '', str_replace('[_', '', $dynamic_field))]))
			{
				$subject = str_replace($dynamic_field, $this->settings[str_replace('_]', '', str_replace('[_', '', $dynamic_field))], $subject);
				$content = str_replace($dynamic_field, $this->settings[str_replace('_]', '', str_replace('[_', '', $dynamic_field))], $content);
			}
		}

		$response_array = [
			'subject' => $subject,
			'content' => $content
		];
		echo json_encode($response_array);
	}	
	// DEALER EMAIL (End) //	
	
	public function get_dealer_existing_quote ()
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;
		
		$input_arr = $this->input->post();

		$existing_quote_result = $this->quote_model->get_dealer_existing_quote($input_arr['id_user'], $input_arr['id_quote_request'], $input_arr['demo']);
		
		echo $existing_quote_result['cnt'];
	}
	
	// TENDER ACTIONS (Start) //
	public function send_tender_confirmation_email ($lead_id)
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;
		
		$lead = $this->lead_model->get_lead($lead_id);

		$content = '
		<center>
			<h1 style="font-size: 25px;">Tender Confirmation</h1>
			<h2 style="font-size: 17px;">'.$lead['cq_number'].'</h2>
		</center>
		<p style="line-height: 1.5">
			Multiple dealers are being given the opportunity to quote on the below car. Please take a moment to confirm the 
			details are correct. If there is an error please email 
			<a href="mailto:'.$data['company']['company_email'].'" target="_top">'.$data['company']['company_email'].'</a>. 
			Please ensure you are available for the 4 hours post your tenders allocated start for a telephone conversation. 
			If this is not suitable let your broker know as soon as possible.
		</p>
		<p style="line-height: 1.5">
			The following car has been submitted to multiple dealers for tender. Please confirm that the vehicle is correct and 
			the options / accessories are all listed.
		</p>		
		<ul>
			<li style="margin-left: -20px;">'.$lead['tender_make'].' '.$lead['tender_model'].' '.$lead['tender_variant'].'</li>
			<li style="margin-left: -20px;">'.$lead['series'].'</li>
			<li style="margin-left: -20px;">'.$lead['body_type'].'</li>
			<li style="margin-left: -20px;">'.$lead['transmission'].'</li>
			<li style="margin-left: -20px;">'.$lead['colour'].'</li>
			<li style="margin-left: -20px;">'.$lead['fuel_type'].'</li>
		</ul>		
		<p style="line-height: 1.5">
			The New Car Tender is to incorporate delivery to post code '.$lead['postcode'].'. <br />
			This vehicle is to be registered for '.$lead['registration_type'].' use. 
		</p>
		<p style="line-height: 1.5">
			Current year build date of 2017 is required and any build date 120 days or older must be listed in dealer submissions. 
			Demonstrator quotes will only be accepted if the KM, Build Date and Registration Expiry are clearly listed. This 
			vehicle is to be home delivered with a full tank of fuel and in immaculate condition.
		</p>
		<p style="line-height: 1.5">
			Factory Options and Dealer Fitted Accessories
		</p>
		<ul>';
			$qro_query = "
			SELECT if (o.items <> '', CONCAT(o.name, ' (', o.items, ')'), o.name) as `option`
			FROM quote_request_options qro
			JOIN options o ON qro.fk_option = o.id_option
			WHERE qro.fk_quote_request = '".$lead['id_quote_request']."' AND qro.deprecated <> 1";
			$qro_result = $this->db->query($qro_query);
			if ($qro_result->result()<>0)
			{
				foreach ($qro_result->result() as $qro_row)
				{
					$content .= '<li style="margin-left: -20px;">'.$qro_row->option.'</li>';
				}					
			}
			$qra_query = "
			SELECT name, description
			FROM quote_request_accessories
			WHERE fk_quote_request = '".$lead['id_quote_request']."' AND deprecated <> 1";
			$qra_result = $this->db->query($qra_query);
			if ($qra_result->result()<>0)
			{
				foreach ($qra_result->result() as $qra_row)
				{
					$content .= '<li style="margin-left: -20px;">'.$qra_row->name.'</li>';
				}					
			}
			$content .= '
		</ul>
		<p style="line-height: 1.5">
			Fleet Claims / Fleet Number<br />
			<b>Internal use only</b><br />
		</p>
		<p style="line-height: 1.5">
			*Any offer listed here is subject to confirmation from the supplying dealer and manufacturer. '.$data['company']['company_name'].' is 
			not responsible for providing any offer listed inferred or promised.
		</p>		
		<p style="line-height: 1.5"><b>Business Claim Only</b></p>
		<p style="line-height: 1.5">
			Vehicle Numbers : <br />
			Novated Lease: Y/N <br />
			Provider: <br />
			Registered W/Fleet Aus. Y/N <br />
		</p>';
		
		$email_recipients = "";
		if (trim($lead['email']) <> "")
		{
			$email_recipients .= $lead['email'];
		}
		
		if (trim($lead['alternate_email_1']) <> "")
		{
			$email_recipients .= ",".$lead['alternate_email_1'];
		}
		
		if (trim($lead['alternate_email_2']) <> "")
		{
			$email_recipients .= ",".$lead['alternate_email_2'];
		}
		
		if ($email_recipients <> "")
		{
			$this->send_templated_email($lead['qs_email'], $lead['qs_name'], $email_recipients, $data['company']['company_name'].': Tender Confirmation Email ('.$lead['cq_number'].')', $content);
			
			echo "success";
			
			$audit_trail_arr = array(
				'id' => $lead['id_lead'],
				'table_name' => 'leads',
				'action' => 41,
				'description' => ''
			);
			$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);
			$this->action_model->insert_action(1, $lead['id_lead'], $data['user_id'], 'Resent Tender Confirmation');			
		}
	}	
	
	public function remind_dealers_new () // BUTTON ACTION // AUDIT TRAIL //
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;
		
		$input_arr = $this->input->post();

		$remind_dealer_result = $this->request_model->update_quote_request_reminder($input_arr['id_quote_request']);

		if ($remind_dealer_result)
		{
			$remind_dealers = $this->user_model->get_remind_dealers($input_arr['id_quote_request']);
			
			//temporary commented of email
			// foreach ($remind_dealers as $remind_dealer)
			// {
				// $this->templated_dealer_lead_email_init(12, $remind_dealer->id_user, $input_arr['id_lead'], 'company', 'dealer');
			// }

			$audit_trail_arr = array(
				'id' => $input_arr['id_lead'],
				'table_name' => 'leads',
				'action' => 12,
				'description' => ''
			);
			//echo json_encode($audit_trail_arr); die();
			$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);	
			//echo json_encode($insert_audit_trail_result); die();
			$this->action_model->insert_action(1, $input_arr['id_lead'], $data['user_id'], 'Reminded Dealers to Quote');

			echo "success";
		}
		else
		{
			echo "fail";
		}
	}	
	
	public function add_dealers () // MODAL ACTION // AUDIT TRAIL //
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;
		
		$input_arr = $this->input->post();

		$process_error = array();
		
		$dealer_id_arr = explode("-", $input_arr['dealer_ids']);
		foreach ($dealer_id_arr as $dealer_id)
		{
			if ($dealer_id <> 0)
			{
				$insert_dealer_request_result = $this->request_model->insert_dealer_request($input_arr['id_quote_request'], $dealer_id);
				if (!$insert_dealer_request_result)
				{
					$process_error[] = $dealer_id." not added";
				}

				$user_detail = $this->user_model->get_dealer($dealer_id);
				if (isset($user_detail['username']))
				{
					$this->templated_dealer_lead_email_init(10, $dealer_id, $input_arr['id_lead'], 'company', 'dealer');
				}
			}
		}
		
		if (count($process_error)==0)
		{
			$audit_trail_arr = array(
				'id' => $input_arr['id_lead'],
				'table_name' => 'leads',
				'action' => 10,
				'description' => ''
			);
			$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);	
			$this->action_model->insert_action(1, $input_arr['id_lead'], $data['user_id'], 'Added Dealer Invites');			
			
			echo "success";
		}
		else
		{
			echo "fail";
		}
	}
	
	public function send_email_invite () // MODAL ACTION // AUDIT TRAIL //
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;

		$input_arr = $this->input->post();
//echo json_encode(input_arr); die();
		if ($input_arr['email'] != "" AND $input_arr['id_quote_request'] != "" AND $input_arr['id_quote_request'] != 0)
		{
			$email_invite_result = $this->emailinvite_model->insert_email_invite($input_arr['id_quote_request'], $input_arr['email']);
		
			if ($email_invite_result)
			{
				$this->templated_special_email_init(11, $input_arr['id_lead'], 'company', $input_arr['email']);
				
				$audit_trail_arr = array(
					'id' => $input_arr['id_lead'],
					'table_name' => 'leads',
					'action' => 11,
					'description' => '[{"email":"'.$input_arr['email'].'"}]'
				);
				$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);	
				$this->action_model->insert_action(1, $input_arr['id_lead'], $data['user_id'], 'Sent Dealer Email Invite');	

				echo "success";
			}
			else
			{
				echo "fail";
			}
		}
		else
		{
			echo "fail";
		}		
	}	
	
	public function update_tender () // MODAL ACTION // AUDIT TRAIL //
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;

		$input_arr = $this->input->post();
		
		//$vehicle_details = $this->car_model->get_vehicle($input_arr['vehicle']);
		$admin_detail = $this->user_model->get_admin($data['user_id']);
		$car_detail = $this->car_model->get_family($input_arr['family']);	
		
		// TEMPORARY //
		/*$input_arr['series'] = $vehicle_details['series'];
		$input_arr['body_type'] = $vehicle_details['bodystyle'];
		$input_arr['transmission'] = $vehicle_details['transmission'];
		$input_arr['fuel_type'] = $vehicle_details['fueltype'];*/
		// ..TEMPORARY //

		$update_quote_request_result = $this->request_model->update_quote_request($input_arr);
		
		$quote_request_id = $input_arr['id_quote_request'];

		$this->request_model->clear_quote_request_options($quote_request_id);
		if (isset($input_arr['options_arr']))
		{
			foreach ($input_arr['options_arr'] as $option_id)
			{
				$this->request_model->resend_quote_request_option($quote_request_id, $option_id);
				
				$qro_query = "SELECT id_quote_request_option FROM quote_request_options WHERE fk_quote_request = " . $quote_request_id . " AND fk_option = " . $option_id;
				$qro_result = $this->db->query($qro_query);
				foreach ($qro_result->result() as $qro_row)
				{
					$quote_request_option_id = $qro_row->id_quote_request_option;
				}
				
				$query = "SELECT id_quote FROM quotes WHERE fk_quote_request = " . $quote_request_id;
				$result = $this->db->query($query);
				foreach ($result->result() as $row)
				{
					if (isset($quote_request_option_id))
					{
						$this->quote_model->reinsert_quotation_option($row->id_quote, $quote_request_option_id);
					}
				}
			}
		}
		
		$this->request_model->clear_quote_request_accessories($quote_request_id);
		if (isset($input_arr['accessory_name']))
		{
			$accessories = $input_arr['accessory_name'];
			$accessories = array_filter($accessories);
			$old_acc = array();
			foreach ($accessories as $acc_index => $acc)
			{
				if(!in_array($acc, $old_acc)) {
					array_push($old_acc, $acc);
					if($acc != '@@@') {
						$this->request_model->resend_quote_request_accessory($quote_request_id, $acc, $input_arr['accessory_desc'][$acc_index]);
					}
				}

				$qra_query = "
				SELECT id_quote_request_accessory FROM quote_request_accessories 
				WHERE code = MD5(CONCAT(".$quote_request_id.", '-', '".$this->db->escape_str($acc)."', '-', '".$this->db->escape_str($input_arr['accessory_desc'][$acc_index])."'))";
				$qra_result = $this->db->query($qra_query);
				foreach ($qra_result->result() as $qra_row)
				{
					$quote_request_accessory_id = $qra_row->id_quote_request_accessory;
				}

				$query = "SELECT id_quote FROM quotes WHERE fk_quote_request = " . $quote_request_id;
				$result = $this->db->query($query);
				foreach ($result->result() as $row)
				{
					if (isset($quote_request_accessory_id))
					{
						$this->quote_model->reinsert_quotation_accessory($row->id_quote, $quote_request_accessory_id);
					}
				}
			}
		}

		$lead_id = 0;

		$query = "
		SELECT 
		q.id_quote, qr.fk_lead AS `id_lead`, qr.quote_number, u.id_user, u.username, a.name as `qs_name`
		FROM quotes q 
		JOIN users u ON q.fk_user = u.id_user
		JOIN quote_requests qr ON q.fk_quote_request = qr.id_quote_request
		JOIN users a ON qr.fk_user = a.id_user
		WHERE q.fk_quote_request = " . $quote_request_id;
		$result = $this->db->query($query);
		if (count($result->result()) <> 0)
		{
			foreach ($result->result() as $row)
			{
				//$this->calculate_quote($row->id_quote, 1);
				//$this->templated_dealer_lead_email_init(1, $row->id_user, $row->id_lead, 'company', 'dealer');				
				$lead_id = $row->id_lead;
				$cq_number = $row->quote_number;
			}
		}
		/*------------------------------------------------------------------------*/
		$lead_id = 0;
		$query = "
		SELECT fk_lead
		FROM quote_requests
		WHERE id_quote_request = '".$quote_request_id."'
		LIMIT 1";
		$result = $this->db->query($query);
		if (count($result->result())<>0)
		{
			foreach ($result->result() as $row)
			{
				 $lead_id = $row->fk_lead;
				
			}
		}
		
		
			$query = "
		SELECT m.name as `make`, f.name as `family`
		FROM makes m
		JOIN families f ON m.id_make = f.fk_make
		WHERE m.id_make = '".$input_arr['make']."' AND f.id_family = '".$input_arr['family']."'
		LIMIT 1";
		$result = $this->db->query($query);
		if (count($result->result())<>0)
		{
			foreach ($result->result() as $row)
			{
				 $make = $row->make;
				 $family = $row->family;
			}
		}
		
		$query = "
		SELECT name
		FROM vehicles
		WHERE id_vehicle = '".$input_arr['vehicle']."'
		LIMIT 1";
		$result = $this->db->query($query);
		if (count($result->result())<>0)
		{
			foreach ($result->result() as $row)
			{
				 $veriant = $row->name;
				
			}
		}
		
		$year_ar = explode("-",$input_arr['build_date']);
		 $year = $year_ar[1];	
				
				$this->db->set('year',  $year);  
				$this->db->set('make',  $make);  
				$this->db->set('modal',  $family );  
				$this->db->set('veriant',  $veriant);  
				
				$this->db->where('fq_lead_id', $lead_id); 
				$this->db->update('fq_lead_dealer_data');
				
		//echo $this->db->last_query();
		
		
		/*------------------------------------------------------------------------*/	
		if ($update_quote_request_result)
		{
			echo "success";
		}
		else
		{
			echo "fail";
		}
		
		if ($lead_id <> 0)
		{
			$audit_trail_arr = array(
				'id' => $quote_request_id,
				'table_name' => 'quote_requests',
				'action' => 2,
				'description' => ''
			);
			$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);		
			$this->action_model->insert_action(1, $lead_id, $data['user_id'], 'Tender Update');
		}
	}	

    public function select_winning_quote_new () // SUBMODAL ACTION // AUDIT TRAIL REVIEW //
    {
        $now = date("Y-m-d H:i:s");
        $data = $this->data;
        $input_arr = $this->input->post();

        $lead = $this->lead_model->get_lead($input_arr['id_lead']);
        $quote = $this->quote_model->get_quote_all($input_arr['id_quote']);
        //echo json_encode($quote); die();
        if ($lead['winner'] == 0 OR $lead['winner'] == "")
        {
            $notification_parameter = " selected ";
        }
        else
        {
            $notification_parameter = " changed ";
        }

        $select_winner_result = $this->request_model->select_winner($input_arr['id_quote_request'], $input_arr['id_quote']); 

        $update_delivery_date_result = $this->lead_model->update_lead_date($input_arr['id_lead'], $quote['delivery_date'], 'delivery_date');
        //echo json_encode($update_delivery_date_result); die();

        $update_winner_date_result = $this->lead_model->update_lead_date($input_arr['id_lead'], $now, 'winner_date');
        //echo json_encode($update_winner_date_result); die();
        if ($select_winner_result AND $update_winner_date_result)
        {
            if (isset($lead['deal_flag']))
            {
                if ($lead['deal_flag']==1)
                {
                    if ($data['user_id'] <> 427)
                    {
                        $cq_number = "QM".str_pad($input_arr['id_lead'], 5, '0', STR_PAD_LEFT);
                        $notification_message = '<b><a href="'.site_url('lead/record_final/'.$input_arr['id_lead']).'" target="_blank">'.$cq_number.'</a></b> - '.$data['name'].' '.$notification_parameter.' the winning dealer';
                        $this->notification_model->add_notification(1, $notification_message);
                        $notification_id = $this->db->insert_id();
                        $this->notification_model->add_notification_user($notification_id, 427);
                    }				
                }
            }
            
            //$query = $this->db->get_where('quotes', array('id_quote' => 120));
            $fq_dealer_data = array(
						//'fq_lead_id'		=> $input_arr['fapplication_id'],
						'winning_quote'		=> $quote['quoted_price'],
                        'delivery_date'		=> $quote['delivery_date'],
						'dealer'			=> $this->quote_model->get_id_by_val('users','name','id_user',$quote['fk_user']),
				);
            $this->fapplication_model->insert_update_fq_dealer_data($fq_dealer_data,$input_arr['id_lead']);
                
            $audit_trail_arr = array(
                'id' => $input_arr['id_lead'],
                'table_name' => 'leads',
                'action' => 13,
                'description' => ''
            );
            $insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);
            $this->action_model->insert_action(1, $input_arr['id_lead'], $data['user_id'], 'Winning Quote '.$notification_parameter);

            echo "success";
        }
        else
        {
            echo "fail";
        }
    }

    public function remove_winning_quote_new()
    {
    	$now = date("Y-m-d H:i:s");
        $data = $this->data;
        $input_arr = $this->input->post();

        $lead = $this->lead_model->get_lead($input_arr['id_lead']);
        // $quote = $this->quote_model->get_quote_all($input_arr['id_quote']);

        $remove_winner_result = $this->request_model->remove_winner($input_arr['id_quote_request']);

        if($remove_winner_result)
        {
        	echo "success";
        }
        else {
        	echo "fail";
        }
    }
	
	public function delete_quote () // SUBMODAL ACTION // AUDIT TRAIL PENDING //
	{
		$now = date("Y-m-d H:i:s");		
		$data = $this->data;

		$input_arr = $this->input->post();

		$delete_quote_result = $this->quote_model->delete_quote($input_arr['id_quote']);
		
		if ($delete_quote_result)
		{
			/*
			$audit_trail_arr = array(
				'id' => $input_arr['id_lead'],
				'table_name' => 'leads',
				'action' => 13,
				'description' => ''
			);
			$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);
			$this->action_model->insert_action(1, $input_arr['id_lead'], $data['user_id'], 'Winning Quote '.$notification_parameter);
			*/
			
			echo "success";
		}
		else
		{
			echo "fail";
		}
	}	
	
	function car_OnRoad_update(){
		$now = date("Y-m-d H:i:s");		
		$data = $this->data;
		$input_arr = $this->input->post();
		$result = $this->quote_model->change_carOnroad($input_arr);
		if ($result) {
			echo "success";
		} else {
			echo "fail";
		}
	}
	
	function car_OffRoad_update(){
		$now = date("Y-m-d H:i:s");		
		$data = $this->data;
		$input_arr = $this->input->post();
		$result = $this->quote_model->change_carOffroad($input_arr);
		if ($result) {
			echo "success";
		} else {
			echo "fail";
		}
	}
    
	function dealer_notes_update(){
		$now = date("Y-m-d H:i:s");		
		$data = $this->data;
		$input_arr = $this->input->post();
		$result = $this->quote_model->change_dealer_notes($input_arr);
		if ($result) {
			echo "success";
		} else {
			echo "fail";
		}
	}
	function delivery_date_update(){
        $now = date("Y-m-d H:i:s");
		$data = $this->data;
		$input_arr = $this->input->post();
		$result = $this->quote_model->change_delivery_date($input_arr);
		if ($result) {
			echo "success";
		} else {
			echo "fail";
		}
    }
	// TENDER ACTIONS (End) //
	
	public function start_tender_new () // MODAL ACTION // AUDIT TRAIL //
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;

		$input_arr = $this->input->post();

		$lead = $this->lead_model->get_lead($input_arr['id_lead']);
		
		if ($lead['qs_id']==0)
		{
			$this->lead_model->allocate_lead($input_arr['id_lead'], $data['user_id']);
			$this->lead_model->update_lead_attempt_flag($input_arr['id_lead'], 1);
		}

		// TEMPORARY //
		$vehicle_details = $this->car_model->get_vehicle($input_arr['vehicle']);
		$input_arr['series'] = $vehicle_details['series'];
		$input_arr['body_type'] = $vehicle_details['bodystyle'];
		$input_arr['transmission'] = $vehicle_details['transmission'];
		$input_arr['fuel_type'] = $vehicle_details['fueltype'];
		// ..TEMPORARY //
		
		$insert_quote_request_result = $this->request_model->send_quote_request($input_arr, $data['user_id']);
		if ($insert_quote_request_result)
		{
			$quote_request_id = $this->db->insert_id();
			$this->lead_model->update_lead_status($input_arr['id_lead'], 3);
			$this->lead_model->update_lead_date($input_arr['id_lead'], $now, 'tender_date');			

			if (isset($input_arr['options_arr']))
			{
				foreach ($input_arr['options_arr'] as $option_id)
				{
					$this->request_model->send_quote_request_option($quote_request_id, $option_id);
				}
			}

			if (isset($input_arr['accessory_name']))
			{
				foreach ($input_arr['accessory_name'] as $acc_index => $acc)
				{
					if ($acc <> '')
					{
						$this->request_model->send_quote_request_accessory($quote_request_id, $acc, $input_arr['accessory_desc'][$acc_index]);
					}
				}
			}

			$quote_detail = $this->request_model->get_quote_request($quote_request_id);

			$this->send_tender_confirmation_email($input_arr['id_lead']);
			
			if (isset($input_arr['dealer_ids']))
			{
				$dealer_ids = $input_arr['dealer_ids'];
				$dealer_id_arr = explode("-", $dealer_ids);
				foreach ($dealer_id_arr as $dealer_id)
				{
					if ($dealer_id <> 0)
					{
						$this->request_model->insert_dealer_request($quote_request_id, $dealer_id);
						$this->templated_dealer_lead_email_init(10, $dealer_id, $input_arr['id_lead'], 'qs', 'dealer');
					}
				}				
			}

			$audit_trail_arr = array(
				'id' => $input_arr['id_lead'],
				'table_name' => 'leads',
				'action' => 9,
				'description' => ''
			);
			$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);	
			$this->action_model->insert_action(1, $input_arr['id_lead'], $data['user_id'], 'Tender Started');
			
			echo "success";
		}
		else
		{
			echo "fail";
		}
	}
	
	public function submit_deal_new () // BUTTON ACTION // AUDIT TRAIL // EMAIL NOTIF TO JENO //
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;

		$input_arr = $this->input->post();

		$input_arr['deal_flag'] = 1;
		$input_arr['status'] = 4;
		$input_arr['order_date'] = $now;
		$input_arr['transport'] = 1;
		
		$update_result = $this->lead_model->update_lead_details($input_arr);
		
		if ($update_result)
		{
			//temp commented
			//$this->templated_special_email_init(8, $input_arr['id_lead'], 'company', 'jeronimo@qteme.com.au');
			
			$audit_trail_arr = array(
				'id' => $input_arr['id_lead'],
				'table_name' => 'leads',
				'action' => 6,
				'description' => ''
			);
			$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);		
			$this->action_model->insert_action(1, $input_arr['id_lead'], $data['user_id'], 'Submitted Deal');			
			
			echo "success";
		}
		else
		{
			echo "fail";
		}
	}	

	public function deal_requirements ($lead_id)
	{
		$requirements = $this->lead_model->get_deal_requirements($lead_id);
		
		$error_arr = [];
		$warning_arr = [];

		if ($requirements['winning_quote'] == 0 OR $requirements['winning_quote'] == "")
		{
			$error_arr[] = 'No winning quote selected';
		}
		
		if ($requirements['attached_tradein_count'] > 0 AND ($requirements['tradein_buyer'] == "" OR $requirements['tradein_buyer'] == 0))
		{
			$error_arr[] = 'No nominated buyer of the tradein';
		}		
		
		if ($requirements['delivery_date'] == "" OR ($requirements['delivery_address'] == "" AND $requirements['delivery_address_map']==0))
		{
			$error_arr[] = 'Delivery details is incomplete';
		}
		
		if ($requirements['name'] == "" OR $requirements['email'] == "" OR $requirements['state'] == "" OR $requirements['postcode'] == "" OR $requirements['address'] == "")
		{
			$error_arr[] = 'Client details is incomplete';
		}
		
		if ($requirements['delivery_date'] < $requirements['order_date'])
		{
			$error_arr[] = 'Delivery cannot be before Order Date. Please check the delivery date';
		}
		
		if ($requirements['suggested_tradein_count'] > $requirements['attached_tradein_count'])
		{
			$warning_arr[] = 'There are suggested tradeins that are not attached to the deal';
		}

		if (($requirements['state'] == "ACT" AND $requirements['answer_act'] == "")
				OR ($requirements['state'] == "VIC" AND $requirements['answer_vic'] == "")
				OR ($requirements['state'] == "QLD" AND $requirements['answer_qld'] == ""))
		{	
			$error_arr[] = 'Vehicle type is not indicated';
		}
		
		if ($requirements['deposit'] == 0 OR $requirements['deposit'] == "")
		{
			$error_arr[] = 'Deposit type is not indicated';
		}
		
		if ($requirements['transport'] == 0 OR $requirements['transport'] == "")
		{
			$error_arr[] = 'Transport type is not indicated';
		}
		
		$output_arr = array(
			"errors" => $error_arr,
			"warnings" => $warning_arr
		);

		return $output_arr;
	}
	// LEAD PAGE (End) //	
	
	// DEALS PAGE (Start) //
	public function generate_balcqo_json () // MODAL VIEW //
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;

		$input_arr = $this->input->post();		

		$lead = $this->lead_model->get_lead($input_arr['id_lead']);
		$balcqo = $this->lead_model->get_lead_balcqo_details($input_arr['id_lead']);
		
		$invoices = $this->generate_invoices_html($input_arr['id_lead']);
		$payments = $this->generate_payments_html($input_arr['id_lead']);
		
		$remaining_balance = 0;
		$remaining_balance = $balcqo['balcqo'] - $payments['total_received'];
		
		$output_arr = array(
			"id_lead" => $input_arr['id_lead'],
			"accounts_status" => $lead['accounts_status'],
			"accounts_update_status" => $lead['accounts_update_status'],
			"revenue" => number_format($balcqo['revenue'], 2, '.', ''),
			"balcqo" => number_format($balcqo['balcqo'], 2, '.', ''),
			"total_received" => number_format($payments['total_received'], 2, '.', ''),
			"remaining_balance" => number_format($remaining_balance, 2, '.', ''),
			"invoices_html" => $invoices['html'],
			"payments_html" => $payments['html']
		);

		echo json_encode($output_arr);
	}
	
	public function generate_invoices_json () // MODAL VIEW //
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;

		$input_arr = $this->input->post();		

		$payments = $this->generate_invoices_html($input_arr['id_lead']);
		
		$output_arr = array(
			"invoices_html"     => $invoices['html']
		);

		echo json_encode($output_arr);
	}	
	
	public function generate_payments_json () // MODAL VIEW //
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;

		$input_arr = $this->input->post();		

		$payments = $this->generate_payments_html($input_arr['id_lead']);
		
		$output_arr = array(
			"payments_html"     => $payments['html']
		);

		echo json_encode($output_arr);
	}
	
	public function generate_invoices_html ($id_lead)
	{
		$total_received = 0;

		$lead = $this->lead_model->get_lead($id_lead);
		$attached_tradeins = $this->lead_model->get_lead_attached_tradeins($id_lead);

		$invoices = $this->invoice_model->get_lead_invoices($id_lead);

		$invoices_html = '
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
						<tbody>	
							<tr>
								<!--
								<td align="center"><i class="fa fa-pencil-square-o"></i></td>
								-->
								<td align="center"><i class="fa fa-trash-o"></i></td>
								<td align="center"><i class="fa fa-file-pdf-o"></i></td>
								<td align="center"><i class="fa fa-envelope"></i></td>
								<td><b>Invoice #</b></td>
								<td><b>Name</b></td>
								<td><b>To</b></td>
								<td><b>Invoice Date</b></td>
								<td><b>Due Date</b></td>
								<td><b>Promised Date</b></td>
								<td><b>Amount Due</b></td>
								<td><b>Amount Paid</b></td>
								<td><b>User</b></td>
								<td><b>Created</b></td>
							</tr>
							<tr id="admin_fee_invoice">
								<!--
								<td align="center"><i class="fa fa-pencil-square-o"></i></td>
								-->
								<td align="center"><i class="fa fa-trash-o"></i></td>
								<td align="center"><i class="fa fa-file-pdf-o"></i></td>
								<td align="center"><i class="fa fa-envelope"></i></td>
								<td>AI_'.$lead['cq_number_only'].'</td>
								<td>Admin Fee Invoice</td>
								<td>Client</td>
								<td>'.$lead['order_date'].'</td>
								<td>'.date('Y-m-d', strtotime($lead['order_date'] . ' +1 day')).'</td>
								<td></td>
								<td>165.00</td>
								<td></td>
								<td>'.$lead['qs_name'].'</td>
								<td>'.$lead['order_date'].'</td>
							</tr>																	
							<tr id="dealer_invoice">
								<!--
								<td align="center"><i class="fa fa-pencil-square-o"></i></td>
								-->
								<td align="center"><i class="fa fa-trash-o"></i></td>
								<td align="center">
									<a href="'.site_url('invoice/pdf_dealer_invoice/'.$id_lead).'" target="_blank">
										<i class="fa fa-file-pdf-o"></i>
									</a>
								</td>
								<td align="center"><i class="fa fa-envelope"></i></td>
								<td>DI_'.$lead['cq_number_only'].'</td>
								<td>Dealer Invoice</td>
								<td>Dealer</td>
								<td>'.$lead['order_date'].'</td>
								<td>'.$lead['delivery_date'].'</td>
								<td></td>
								<td></td>
								<td></td>
								<td>'.$lead['qs_name'].'</td>
								<td>'.$lead['order_date'].'</td>
							</tr>';
							
							foreach ($attached_tradeins AS $attached_tradein)
							{
								$invoices_html .= '
								<tr id="wholesaler_invoice_'.$attached_tradein['id_tradein'].'">
									<!--
									<td align="center"><i class="fa fa-pencil-square-o"></i></td>
									-->
									<td align="center"><i class="fa fa-trash-o"></i></td>
									<td align="center">
										<a href="'.site_url('deal/tradein_invoice_pdf/'.$attached_tradein['id_tradein']).'" target="_blank">
											<i class="fa fa-file-pdf-o"></i>
										</a>
									</td>
									<td align="center"><i class="fa fa-envelope"></i></td>
									<td>WI_'.$lead['cq_number_only'].'</td>
									<td>Wholesaler Invoice</td>
									<td>Wholesaler</td>
									<td>'.$lead['order_date'].'</td>
									<td>'.date('Y-m-d', strtotime($lead['delivery_date'] . ' -2 days')).'</td>
									<td></td>
									<td></td>
									<td></td>
									<td>'.$lead['qs_name'].'</td>
									<td>'.$lead['order_date'].'</td>
								</tr>';
							}

							foreach ($invoices AS $invoice)
							{
								$invoices_html .= '
								<tr id="lead_invoice_'.$invoice['id_invoice'].'">
									<!--
									<td align="center">
										<span class="ajax_button_primary edit_invoice_modal_button" data-id_lead="'.$id_lead.'" data-id_invoice="'.$invoice['id_invoice'].'">
											<i class="fa fa-pencil-square-o"></i>
										</span>
									</td>
									-->
									<td align="center">
										<span class="ajax_button_primary delete_invoice_button" data-id_lead="'.$id_lead.'" data-id_invoice="'.$invoice['id_invoice'].'">
											<i class="fa fa-trash-o"></i>
										</span>
									</td>
									<td align="center">
										<a href="'.site_url('invoice/pdf_custom_invoice/'.$invoice['id_invoice']).'" target="_blank">
											<i class="fa fa-file-pdf-o"></i>
										</a>
									</td>
									<td align="center"><i class="fa fa-envelope"></i></td>
									<td>'.$invoice['invoice_number'].'</td>
									<td>'.$invoice['invoice_name'].'</td>
									<td>'.$invoice['invoice_type'].'</td>
									<td>'.$invoice['invoice_date'].'</td>
									<td>'.$invoice['due_date'].'</td>
									<td>'.$invoice['promised_date'].'</td>
									<td>'.$invoice['amount_due'].'</td>
									<td>'.$invoice['amount_paid'].'</td>
									<td>'.$invoice['name'].'</td>
									<td>'.date('Y-m-d', strtotime($invoice['created_at'])).'</td>
								</tr>';	
							}
							$invoices_html .= '
						</tbody>
					</table>
				</div>
			</div>
		</div>';
		
		$output_arr = array(
			'html' => $invoices_html
		);
		
		return $output_arr;
	}	

	public function generate_payments_html ($id_lead)
	{
		$total_received = 0;

		$payments = $this->payment_model->get_lead_payments($id_lead);

		$payments_html = '
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
						<tbody>	
							<tr>
								<td align="center"><b><i class="fa fa-pencil-square-o"></i></b></td>
								<td align="center"><b><i class="fa fa-trash-o"></i></b></td>
								<td align="center"><b><i class="fa fa-eye"></i></b></td>
								<td><b>Type</b></td>
								<td><b>Method</b></td>
								<td><b>Credit Card</b></td>
								<td><b>Bank</b></td>
								<td><b>Reference</b></td>
								<td><b>Amount</b></td>
								<td><b>Admin Fee</b></td>
								<td><b>Merchant Cost</b></td>
								<td><b>Processed</b></td>
								<td><b>Received</b></td>
								<td><b>User</b></td>
								<td><b>Created</b></td>
							</tr>';

							if (count($payments)==0)
							{
								$payments_html .= '<tr class="norecords"><td colspan="15"><center>No records found!</center></td></tr>';										
							}
							else
							{
								foreach ($payments AS $payment)
								{
									if ($payment['show_status']==1)
									{
										$show_status_action = 0;
										$show_status_action_text = "Hide";
										$show_status_icon = "fa fa-eye-slash";
									}
									else
									{
										$show_status_action = 1;
										$show_status_action_text = "Show";
										$show_status_icon = "fa fa-eye";
									}
									
									$payments_html .= '
									<tr id="lead_payment_'.$payment['id_payment'].'">
										<td align="center">
											<span class="ajax_button_primary edit_payment_modal_button" data-id_lead="'.$id_lead.'" data-id_payment="'.$payment['id_payment'].'">
												<i class="fa fa-pencil-square-o"></i>
											</span>
										</td>
										<td align="center">
											<span class="ajax_button_primary delete_payment_button" data-id_lead="'.$id_lead.'" data-id_payment="'.$payment['id_payment'].'">
												<i class="fa fa-trash-o"></i>
											</span>
										</td>
										<td align="center">
											<span class="ajax_button_primary update_payment_show_status_button" data-id_lead="'.$id_lead.'" data-id_payment="'.$payment['id_payment'].'" data-show_status="'.$show_status_action.'">
												<i class="'.$show_status_icon.'" data-toggle="tooltip" title="'.$show_status_action_text.'"></i>
											</span>
										</td>
										<td>'.$payment['payment_type'].'</td>
										<td>'.$payment['method'].'</td>
										<td>'.$payment['credit_card'].'</td>
										<td>'.$payment['bank_account'].'</td>
										<td>'.$payment['reference_number'].'</td>
										<td>'.$payment['amount'].'</td>
										<td>'.$payment['admin_fee'].'</td>
										<td>'.$payment['merchant_cost'].'</td>
										<td>'.$payment['payment_date'].'</td>
										<td>'.$payment['received_date'].'</td>
										<td>'.$payment['user'].'</td>
										<td>'.$payment['created_at'].'</td>
									</tr>';
									$total_received += $payment['amount'];
								}
							}
							$payments_html .= '
						</tbody>
					</table>
				</div>
			</div>
		</div>';
		
		$output_arr = array(
			'total_received' => $total_received,
			'html' => $payments_html
		);
		
		return $output_arr;		
	}	
	// DEALS PAGE (End) //	

	public function reallocations ($start = 0) // PAGE VIEW
	{
		$data = $this->data;
		$data['title'] = 'Leads - Reallocations';

		$limit = 50;
		$count_result = $this->reallocation_model->get_reallocations_count($_GET, $data['user_id'], $data['admin_type']);  // Record count
		$data['reallocations'] = $this->reallocation_model->get_reallocations($_GET, $data['user_id'], $data['admin_type'], $start, $limit); // Main Query

		$this->load->library('pagination');
		$config['base_url'] = site_url('lead/reallocations/'); 
		$config['total_rows'] = $count_result['cnt'];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config); 
		$data['links'] = $this->pagination->create_links();

		$this->load->view('admin/reallocations', $data);
	}

	public function approve_reallocation () // MODAL ACTION // AT PENDING //
	{
		$data = $this->data;

		$reallocation_ids = $this->input->post('reallocation_ids');
		$this->reallocation_model->update_reallocation_status($reallocation_ids, $data['user_id'], 1);
		$this->lead_model->update_lead_quote_specialists($reallocation_ids);		
	}
	

	
	/////////////
	public function get_all_accessories () // MODAL VIEW //
	{
		$acc_html = "";
		$lead_id = $this->input->post("lead_id");
		$result = $this->lead_model->get_all_accessories($lead_id);
		foreach ($result as $r_key => $r_val) 
		{
			$acc_html .= '
			<tr id="acc_tb_tr_'.$r_val['id_accessory'].'" data-idacc="'.$r_val['id_accessory'].'"
				data-supplier="'.$r_val['acc_supplier'].'" data-code="'.$r_val['code'].'" data-name="'.$r_val['name'].'" data-cost="'.$r_val['cost'].'">
				<td class="acc_check_td"><center><input class="acc_check" name="acc_check" type="checkbox" value="'.$r_val['id_accessory'].'"></center></td>
				<td >'.$r_val['code'].'</td>
				<td >'.$r_val['name'].'</td>
				<td >'.$r_val['cost'].'</td>
			</tr>';	
		}

		echo $acc_html;
	}

	public function insert_lead_accessory () // AT OK //
	{
		$data              = $this->data;
		$post_data         = $this->input->post();
		$result            = $this->lead_model->insert_lead_accessory($post_data);
		$deal_accessory_id = $this->db->insert_id();
		
		$audit_trail_arr = array(
			'id' => $deal_accessory_id,
			'table_name' => 'deal_accessories',
			'action' => 14,
			'description' => '[{"lead_id":"'.$post_data['lead_id'].'"}]'
		);
		$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);
		$this->action_model->insert_action(1, $post_data['lead_id'], $data['user_id'], 'Aftersales Accessory Added');
		
		echo json_encode($result);
	}

	public function update_lead_accessory () // AT OK //
	{
		$data = $this->data;

		$flag = 0;
		$post_data = $this->input->post();
		$acc_arr = [
			'quantity' => isset($post_data['quantity_arr']) ? $post_data['quantity_arr'] : array(),
			'price'    => isset($post_data['price_arr']) ? $post_data['price_arr'] : array(),
			'id_acc'   => isset($post_data['id_arr']) ?$post_data['id_arr'] : array()
		];

		if($this->lead_model->update_lead_accessory($acc_arr))
		{
			$flag = 1;
		}

		if($this->lead_model->update_lead_accessory_status($post_data['acc_status'], $post_data['acc_job_date'], $post_data['acc_spec_con'], $post_data['lead_id']))
		{
			$flag = 1;
		}
		
		if($flag == 1)
		{
			$audit_trail_arr = array(
				'id' => $post_data['lead_id'],
				'table_name' => 'leads',
				'action' => 15,
				'description' => ''
			);
			$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);
			
			echo "success";
		}
		else
		{
			echo "fail";
		}
	}

	public function delete_lead_accessory () // AT OK //
	{
		$data = $this->data;

		$deal_accessory_id = $this->input->post("id_acc");
		if($this->lead_model->delete_lead_accessory($deal_accessory_id))
		{
			$audit_trail_arr = array(
				'id' => $deal_accessory_id,
				'table_name' => 'deal_accessories',
				'action' => 16,
				'description' => ''
			);
			$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);
			
			echo "success";
		}
		else
		{
			echo "fail";
		}
	}

	public function additional_deposit () // C
	{
		$data = $this->data;

		$post_data = $this->input->post();

		$payments   = $this->lead_model->get_deposit($post_data['lead_id'], $post_data['type']);
		$eway_trans = $this->lead_model->get_eway_transactions();
		
		$actions = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

		$payments_html = "";
		if (count($payments) == 0)
		{
			$payments_html .= '<tr class="tr-no-results"><td colspan="12"><center>No payments received yet</center></td></tr>';
		}
		else
		{
			foreach ($payments AS $payment)
			{
				$refund_stat = "";
				$refund_date = "";
				$refund_hidden  = "hidden";
				$show_class = "";
				$show_text  = "";

				if(in_array($payment->reference_number, $eway_trans) && $payment->refund_status == 0)
					$refund_hidden = "";

				if($payment->refund_status == 1)
					$refund_stat = "Refunded";

				if($payment->refund_date == "0000-00-00 00:00:00")
					$refund_date = "";
				else
					$refund_date = date("Y-m-d", strtotime($payment->refund_date));

				if($payment->show_status == 1)
				{
					$show_class = "fa-eye-slash";
					$show_text  = "Shown";
				}
				else
				{
					$show_class = "fa-eye";	
					$show_text  = "Hidden";
				}

				if($payment->status_id == 1)
				{
					$status_class = "fa-times-circle";
					$status_text  = "Shown";
				}
				else
				{
					$status_class = "fa-check-circle";	
					$status_text  = "Hidden";
				}

				if($data['user_id'] == 427 || $data['user_id'] == 255)
					$hidden_control = "";
				else
					$hidden_control = "hidden";

				$payments_html .= '
					<tr id="payment_tr_'.$payment->id_payment.'">
						<td align="center">';
						
						// if ($data['user_id']=="327" OR $data['user_id']=="255")
						// {
							$payments_html .= '
							<a class="open-refund-payment" href="#" '.$refund_hidden.' data-payment_id="'.$payment->id_payment.'">
								<i class="fa fa-reply"></i>
							</a>';
						// }
						
						$payments_html .= '
						</td>
						<td align="center"><a  '.$hidden_control.' href="#" class="show_btn" data-idpayment="'.$payment->id_payment.'" data-showstatus="'.$payment->show_status.'" ><i class="show-icon fa '.$show_class.'"></i></a></td>
						<td align="center"><a '.$hidden_control.' href="#" class="verify_btn" data-idpayment="'.$payment->id_payment.'" data-status="'.$payment->status_id.'" ><i class="status-icon fa '.$status_class.'"></i></a></td>
						<td>'.$payment->code.'</td>
						<td>'.$payment->reference_number.'</td>			
						<td>'.$payment->amount.'</td>
						<td>'.$payment->name.'</td>
						<td>'.date("Y-m-d", strtotime($payment->payment_date)).'</td>
						<td class="admin_fee">'.$payment->admin_fee.'</td>
						<td >'.$refund_stat.'</td>
						<td class="show_text">'.$show_text.'</td>
						<td>'.$payment->merchant_cost.'</td>
						<td class="status_text">'.$payment->status.'</td>
						<td>'.$payment->created_at.'</td>
					</tr>
				';
			}
		}

		$payments_arr = array(
			"lead_id"           => $post_data['lead_id'],
			"deposits"          => $payments_html,
			"actions"           => $actions
		);
		echo json_encode($payments_arr);		
	}

	public function upload_to_database () // C
	{
		$data               = $this->data;
		$directory          = './uploads/cq_files/';
		$prefix             = time().'_'.$data['user_id'].'_';
		$file_name          = $_FILES['file']['name'];
		$file_tmp           = $_FILES['file']['tmp_name'];
		$file               = $directory.$prefix.$file_name;
		$database_file_name = $prefix.$file_name;
		$post_data = $this->input->post();
		$json_array = [];
		$insert_id = $this->comment_model->insert_file_attachment($post_data['id'], $database_file_name, $data['user_id'], 6);
		move_uploaded_file($file_tmp, $file);
		$json_array['abspath']   = base_url('uploads/cq_files/'.$database_file_name);
		$json_array['insert_id'] = $insert_id;
		$json_array['file_name'] = $database_file_name;

		echo json_encode($json_array);
	}

	public function dealer_uploads ($lead_id) // C
	{
		$id   = $lead_id;
		$data = $this->data;

		$modal_list = "";

		$rows = $this->lead_model->get_dealer_files($id);

		$modal_list = '<table class="table table-striped"><tbody>';

		$file_path = 'uploads/dealer_files/';
		$absolute_path = "";

		foreach ($rows as $key => $value) 
		{
			$absolute_path = base_url($file_path.$value['file_name']);

			$modal_list .= "
							<tr class='dealer_files_tbl' data-abspath='{$value['file_name']}' data-fileid='{$value['id_comment']}'>
								<td><a target='_blank' href='{$absolute_path}'>".$value['file_name']."</a></td>
							</tr>
							";
		}

		$modal_list .= '</tbody></table>';

		return $modal_list;
	}

	public function get_files ($lead_id) // C
	{
		$data = $this->data;

		$modal_list = "";

		$rows = $this->lead_model->get_files($lead_id, $data['user_id']);

		$modal_list = '<table class="table table-striped"><tbody>';

		$file_path = 'uploads/cq_files/';
		$absolute_path = "";
		foreach ($rows as $key => $value) 
		{
			$absolute_path = base_url($file_path.$value['file_name']);

			$modal_list .= "
							<tr class='file_table' data-abspath='{$value['file_name']}' data-fileid='{$value['id_comment']}'>
								<td><a target='_blank' href='{$absolute_path}'>".$value['file_name']."</a></td>
								<td><a class='fa fa-trash-o del_file' ></a></td>
							</tr>
							";
		}

		$modal_list .= '</tbody></table>';

		return $modal_list;
	}

	public function delete_file () // C
	{
		$input_arr = $this->input->post();
		if ($this->lead_model->delete_file($input_arr))
		{
			echo "success";
		}
		else
		{
			echo "fail";
		}
	}

	public function set_tradein_documents_panel ($lead_id) // C
	{
		$default_string = "";
		$result = $this->lead_model->get_tradein_document_list();
		$temp_string = "";

		if(count($result) > 0)
		{
			foreach ($result as $res_key => $res_val) 
			{
				$class_green = "";
				$hidden_class = "hidden";

				$default_string .= "
				<div class='col-md-4' >
					<div class='row'>
						<div class='col-md-12'>
							<div class='panel panel-default'>
								<div class='tradein-doc-panel panel-body {$class_green} documents tradein-doc-panel-body' data-doc='{$res_val['id_lead_doc']}'>
										<label class='tradein_doc_name' >{$res_val['name']}</label>
									<div class='pull-right'>
										<a class='fa fa-desktop tradein_doc_button'></a>&nbsp;
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
				";
			}
			$default_string .= "</div></div></div>";
		}
		return $default_string;
	}

	public function upload_tradein_documents () // C
	{
		$data               = $this->data;
		$directory          = './uploads/tradein_documents/';
		$prefix             = time().'_'.$data['user_id'].'_';
		$file_name          = $_FILES['file']['name'];
		$file_tmp           = $_FILES['file']['tmp_name'];
		$file               = $directory.$prefix.$file_name;
		$database_file_name = $prefix.$file_name;
		
		$post_data = $this->input->post();

		$lead_id = $post_data['lead_id'];
		$doc_id  = $post_data['doc_id'];
		$user    = $data['user_id'];

		$response_raw = $this->lead_model->insert_tradein_documents($lead_id, $doc_id, $database_file_name, $file_name, $user);

		if(move_uploaded_file($file_tmp, $file))
		{
			echo base_url('uploads/tradein_documents/'.$database_file_name);
		}
	}

    public function get_specific_tradein_documents () // C
    {
    	$data = $this->data;

    	$post_data = $this->input->post();

		$tradein_id = $post_data['tradein_id'];
		$doc_id     = $post_data['doc_id'];

		$response = $this->lead_model->get_specific_tradein_documents($tradein_id, $doc_id);

		$modal_list = '<table class="table table-striped"><tbody>';

		$file_path = 'uploads/tradein_documents/';
		$absolute_path = "";
		foreach ($response as $key => $value) 
		{
			$absolute_path = base_url($file_path.$value['file_name']);

			$up_name = "";

			if($value['name'] == NULL)
				$up_name = "Client";
			else
				$up_name = $value['name'];

			$modal_list .= "
			<tr class='tr_doc'  data-id-doc='{$value['id_lead_doc_up']}' data-abspath='{$value['file_name']}'>
				<td><a target='_blank' href='{$absolute_path}'>".$value['file_name']."</a></td>
				<td><p>{$up_name}<p/></td>
				<td><a class='fa fa-trash-o del_doc'></a></td>
			</tr>
			";
		}

		$modal_list .= '</tbody></table>';

		if(count($response) < 1)
			$modal_list = "";

		$dom = array(
				'doc_list' => $modal_list
					);

		echo json_encode($dom);
    }

	public function delete_tradein_document () // C
	{
		$post_data = $this->input->post();
	
		if($this->lead_model->delete_tradein_documents($post_data))
			echo "success";
		else
			echo "fail";
	}

	public function get_trade_checklist () // C
	{
		$id = $this->input->post("this_id");

		$tradein_result = $this->lead_model->get_trade_checklist($id);

		if( $tradein_result['pickup_time'] == "00:00:00" )
			$tradein_result['pickup_time'] = date('h:i:s A');
		else
			$tradein_result['pickup_time'] = date('h:i:s A', strtotime($tradein_result['pickup_time']));

		$user_select = "";

		$users = $this->lead_model->get_tradein_user();
		$user_select .= "<option value='0'>-- Choose a Buyer --</option>";
		foreach ($users as $user_key => $user_val) 
		{
			$selected = "";

			if($tradein_result['fk_user'] == $user_val['id_user'])
				$selected = "selected";
			
			$user_select .= "<option value='{$user_val['id_user']}' {$selected}>{$user_val['name']}</option>";
		}

		$response_array = [
						'tradein_result' => $tradein_result,
						'user_select'    => $user_select
							];

		echo json_encode($response_array);			
	}

	public function save_checklist () // C
	{
		$post_data = $this->input->post();
		$this->lead_model->save_checklist($post_data);
	}

	public function searched_tradein () // C
	{
		$email      = $_POST['t_s_email'];
		$make       = $_POST['t_s_make'];
		$first_name = $_POST['t_s_firstname'];
		$last_name  = $_POST['t_s_lastname'];
		$model      = $_POST['t_s_model'];
		$result = $this->tradein_model->get_filtred_tradeins($email,$make,$first_name,$last_name,$model);

		if(count($result) > 0)
		{
			$html = '
			<div class="table-responsive" style="white-space: nowrap;">
				<table class="table table-bordered table-striped table-condensed mb-none">
					<thead>						
						<tr>
							<th></th>
							<th>Email</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Make</th>
							<th>Model</th>
							<th>Build Date</th>
							<th>QM Number</th>
						</tr>
					</thead>
					<tbody>';
						foreach($result as $r_key => $r_val)
						{
							$cq_number = "";
							$hidden_string = "";

							if($r_val['fk_lead'] != 0)
							{
								$cq_number = $r_val['cq_number'];
								$hidden_string = "hidden";
							}
							else
							{
								$cq_number = "";
								$hidden_string = "";						
							}

							$html .= '
							<tr>
								<td align="center"><span '.$hidden_string.' class="select_tradein" style="cursor: pointer; cursor: hand; color: #58c603;" data-tradein_id="'.$r_val['id_tradein'].'"><i class="fa fa-plus" data-toggle="tooltip" data-placement="top" data-original-title="Select Dealer"></i></span></td>
								<td>'. $r_val['email'] .'</td>
								<td>'. $r_val['first_name'] .'</td>
								<td>'. $r_val['last_name'] .'</td>
								<td>'. $r_val['tradein_make'] .'</td>
								<td>'. $r_val['tradein_model'] .'</td>
								<td>'. $r_val['tradein_build_date'] .'</td>
								<td>'. $cq_number .'</td>
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
						<th></th>
						<th>Email</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Make</th>
						<th>Model</th>
						<th>Build Date</th>
					</thead>					
					<tbody>
						<tr><td colspan="7"><center><i>No results found!</i></center></td></tr>
					</tbody>
				</table>
			</div>';
		}
		echo $html;
	}

	public function set_new_tradein () // C
	{
		$root_url = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/";
		$tradein_details = "";

		$post_data = $this->input->post();
		$this->tradein_model->attach_tradein($post_data);
		$this->lead_model->update_lead_admin_status($post_data['lead_id'], 0);
		$tradein = $this->tradein_model->get_searched_tradeins($post_data['tradein_id']);
		$tradein_details .= "<tr>";
			$attach_string = "";
			if ($tradein['fk_lead']==$post_data['lead_id'])
			{
				$attach_status = "hidden";
				$unattach_status = "";
			}
			else
			{
				$attach_status = "";
				$unattach_status = "hidden";							
			}

			if (1==1) // if ($lead['status'] <= 6 OR $lead['status'] <= 6)
			{
				$attach_string = '
				<a href="#" onclick="attach_trade('.$tradein['id_tradein'].')" id="attach_trade_button_'.$tradein['id_tradein'].'" '.$attach_status.'>
					Attach
				</a>
				<a href="#" onclick="unattach_trade('.$tradein['id_tradein'].')" id="unattach_trade_button_'.$tradein['id_tradein'].'" '.$unattach_status.'>
					Unattach
				</a>';
			}
			else
			{
				$attach_string = '
				<span '.$unattach_status.'>Attached</span>
				<span '.$attach_status.'>Unattached</span>';
			}

			$doc_type_arr = [];
			$doc_type_arr = $this->lead_model->get_tradein_document_class($tradein['id_tradein']);

			if ($tradein['image_1']=="") { $tradein['image_1'] = "no_image.png"; }
			$tradein_details .= "
			<td width='20%'>
				<center>
					<br />
					<img src='".$root_url.$tradein['image_1']."' class='img-responsive' width='90%'>
					<br />
					<a href='#' class='open-tradeindetails' data-tradein_id='".$tradein['id_tradein']."'>
						<i class='fa fa-pencil-square-o' data-toggle='tooltip' data-placement='top' title='View Details'></i>
					</a>
					&nbsp;".$attach_string."&nbsp;
					<a href='#'' class='open-tradeinvaluations' data-tradein_id='".$tradein['id_tradein']."'>
						<i class='fa fa-dollar' data-toggle='tooltip' data-placement='top' data-original-title='View Valuations'></i>
					</a>
					&nbsp;
					<a href='#' class='open-addvaluation' data-tradein_id='".$tradein['id_tradein']."'>
						<i class='fa fa-tag' data-toggle='tooltip' data-placement='top' data-original-title='Add Valuation'></i>
					</a>
					&nbsp;
					<a href='".site_url('tradein/pdf_export/'.$tradein['id_tradein'])."' target='_blank' style='height: 30px; font-size: 12px;'>
						<i class='fa fa-file-pdf-o' data-toggle='tooltip' data-placement='top' data-original-title='Generate PDF'></i>
					</a>
					&nbsp;
					<a href='#' class='open-sendpdf' data-tradein_id='".$tradein['id_tradein']."'>
						<i class='fa fa-envelope-o' data-toggle='tooltip' data-placement='top' data-original-title='Send PDF'></i>
					</a>
					<br />
					<br />
				</center>
			</td>
			<td>
				<br />
				<span><b>".strtoupper($tradein['first_name']).' '.strtoupper($tradein['last_name'])."</b></span><br /><br />
				<span><b>Email Address:</b><br />".$tradein['email']."</span><br /><br />
				<span><b>Phone:</b><br />".$tradein['phone']."</span><br /><br />
				<span><b>Postcode:</b><br />".$tradein['postcode']." ".$tradein['state']."</span><br /><br />
			</td>
			<td>
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
			
			$checked_dealer_visibility_1 = "";
			$checked_dealer_visibility_2 = "";
			if ($tradein['dealer_visibility']==1)
			{
				$checked_dealer_visibility_1 = ' checked="checked"';
			}
			else
			{
				$checked_dealer_visibility_2 = ' checked="checked"';
			}
			
			$tradein_details .= "
			<td class='text-left'>
				<br />
				<span id='tradein_value_".$tradein['id_tradein']."'>".$tradein['value']."</span><br /><br />
				<b>Allow Dealers to Value?</b><br />
				<input type='radio' name='".$tradein['id_tradein']."' class='dealer_visibility_rad' value='1' ".$checked_dealer_visibility_1."> Yes <br />
				<input type='radio' name='".$tradein['id_tradein']."' class='dealer_visibility_rad' value='0' ".$checked_dealer_visibility_2."> No
			</td>
			<td>
				<br />
				<div class='row'>
					<div class='col-md-12'>
						<div class='panel panel-default panel-up-tradein'>
							<div class='tradein-doc-panel panel-body ".( (in_array(1, $doc_type_arr)) ? 'documents_green' : '' )." documents_temp documents_temp_{$post_data['tradein_id']} tradein-doc-panel-body' data-doc='1' data-tradein_id='{$tradein['id_tradein']}'>
								<label class='tradein_doc_name' >REG</label>
								<a class='fa fa-desktop tradein_doc_button' data-toggle='tooltip' data-placement='top' data-original-title='View Uploads' data-tradein_id='{$tradein['id_tradein']}'></a>
							</div>
						</div>
					</div>
				</div>
				<div class='row'>
					<div class='col-md-12'>
						<div class='panel panel-default panel-up-tradein'>
							<div class='tradein-doc-panel panel-body ".( (in_array(2, $doc_type_arr)) ? 'documents_green' : '' )."  documents_temp documents_temp_{$post_data['tradein_id']} tradein-doc-panel-body' data-doc='2' data-tradein_id='{$tradein['id_tradein']}'>
								<label class='tradein_doc_name' >P/O</label>
								<a class='fa fa-desktop tradein_doc_button' data-toggle='tooltip' data-placement='top' data-original-title='View Uploads' data-tradein_id='{$tradein['id_tradein']}'></a>
							</div>
						</div>
					</div>
				</div>
				<div class='row'>
					<div class='col-md-12'>
						<div class='panel panel-default panel-up-tradein'>
							<div class='tradein-doc-panel panel-body ".( (in_array(3, $doc_type_arr)) ? 'documents_green' : '' )."  documents_temp documents_temp_{$post_data['tradein_id']} tradein-doc-panel-body' data-doc='3' data-tradein_id='{$tradein['id_tradein']}'>
								<label class='tradein_doc_name' >DEC</label>
								<a class='fa fa-desktop tradein_doc_button' data-toggle='tooltip' data-placement='top' data-original-title='View Uploads' data-tradein_id='{$tradein['id_tradein']}'></a>
							</div>
						</div>
					</div>
				</div>
				<div class='row'>
					<div class='col-md-12'>
						<div class='panel panel-default panel-up-tradein'>
							<div class='tradein-doc-panel panel-body ".( (in_array(4, $doc_type_arr)) ? 'documents_green' : '' )."  documents_temp documents_temp_{$post_data['tradein_id']} tradein-doc-panel-body' data-doc='4' data-tradein_id='{$tradein['id_tradein']}'>
								<label class='tradein_doc_name' >PIC</label>
								<a class='fa fa-desktop tradein_doc_button' data-toggle='tooltip' data-placement='top' data-original-title='View Uploads' data-tradein_id='{$tradein['id_tradein']}'></a>
							</div>
						</div>
					</div>
				</div>
				
			</td>
		</tr>";		
		echo $tradein_details;
	}

	public function get_email_old ()
	{
		$post_data = $this->input->post();

		$result = $this->lead_model->get_emails($post_data);

		$thread_id = "";
		$prev_thread_id = "";

		$html = "";
		$head = '<div class="table-responsive">
					<table class="table table-bordered mb-none">
						<thead>
							<tr>
								<th>Sender</th>
								<th>Recipient</th>
								<th>Received Date</th>
								<th>Subject</th>
							</tr>
						</thead>
						<tbody>';
		$foot = '		</tbody>
					</table>
				</div>
				<br/>';
		$body = "";

		foreach ($result as $r_key => $r_val) 
		{
			$sender = str_replace('>', ')', str_replace('<', '(', str_replace('"', '', $r_val["sender"])));
			$recipient = str_replace('>', ')', str_replace('<', '(', str_replace('"', '', $r_val["recipient"])));
			
			$body .= '
			<tr>
				<td>'.$sender.'</td>
				<td>'.$recipient.'</td>
				<td>'.$r_val["received_date"].'</td>
				<td>'.$r_val["subject"].'</td>
			</tr>';

			if($prev_thread_id != "")
			{
				if($prev_thread_id != $r_val['thread_id'])
				{	
					$html .= $head . $body . $foot;
					$body = "";
				}
			}
			$prev_thread_id = $r_val['thread_id'];
		}
		$html .= $head.$body.$foot;
		echo $html;
	}
	
	public function get_email ()
	{
		$data = $this->data;
		$post_data = $this->input->post();

		$emails = $this->lead_model->get_emails($post_data);
		$admins = $this->user_model->get_admins();

		$admin_check = 0;
		foreach ($admins AS $admin)
		{			
			if ($admin->username == $post_data['email'])
			{
				$admin_check = 1;
			}
		}
		
		$html = "";
		if ($admin_check == 0)
		{
			foreach ($emails as $email) 
			{
				$sender = str_replace('>', ')', str_replace('<', '(', str_replace('"', '', $email["sender"])));
				$recipient = str_replace('>', ')', str_replace('<', '(', str_replace('"', '', $email["recipient"])));

				$file_array = explode(",", $email['files']);
				
				$html .= '
				<div style="border: 1px solid #ccc; border-radius: 5px; padding: 10px;">
					<b>From:</b> '.$sender.'<br />
					<b>To:</b> '.$recipient.'<br />
					<b>Subject:</b> '.$email["subject"].'
					<p>'.$email["received_date"].'</p>
					<p>
						<b>Body:</b><br />
						'.nl2br($email["content"]).'
					</p>
					<p>
						<b>Attachments: </b> <br />';
						foreach ($file_array as $f_key => $f_val) 
						{
							$temp_filename = $email['id_email']."_".$f_val;

							$full_path = base_url("./uploads/email_attachments/".$temp_filename);

							$html .= "<a href='{$full_path}' target='_blank'>{$f_val}</a> <br />";
						}
				$html .= '</p>
				</div>
				<br />';
			}			
		}
		else
		{
			$html .= "
			<center>
				<p>The client email belongs to a ".$data['company']['company_name']." staff. This is probably a test data.</p>
			</center>";
		}

		echo $html;
	}	
	
	public function get_lead_audit_trail ()
	{
		$post_data = $this->input->post();
		
		$html = '';
		$audit_trails = $this->audit_model->get_audit_trails($post_data);
		foreach ($audit_trails AS $audit_trail)
		{
			$link = "";
			if ($audit_trail['table_name']=="leads")
			{
				$cq_number = "QM".str_pad($audit_trail['fk_main'], 5, '0', STR_PAD_LEFT);
			}
			$html .= '
			<div style="border: 1px solid #ccc; border-radius: 5px; padding: 10px;">
				<b>'.$audit_trail['user'].'</b>
				'.$audit_trail['action_text'].' '.$cq_number.'
				<br /><span style="font-size: 0.8em;">'.$audit_trail['created_at'].'</span>';
				if ($audit_trail['description'] <> '')
				{
					if ($audit_trail['action']==2)
					{
						$html .= '
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-condensed mb-none">
								<tr>
									<td width="20%"><b>Field</b></td>
									<td width="40%"><b>Value From</b></td>
									<td width="40%"><b>Value To</b></td>
								</tr>';
								$audit_trail_value_arr = json_decode($audit_trail['description'], true);
								foreach ($audit_trail_value_arr AS $audit_trail_values)
								{
									$html .= '
									<tr>
										<td>'.$audit_trail_values['field'].'</td>
										<td>'.nl2br($audit_trail_values['value_from']).'</td>
										<td>'.nl2br($audit_trail_values['value_to']).'</td>
									</tr>';
								}				
								$html .= '
							</table>
						</div>';
					}
					else if ($audit_trail['action']==30)
					{
						$html .= '
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-condensed mb-none">
								<tr>
									<td width="30%"><b>Field</b></td>
									<td width="70%"><b>Value</b></td>
								</tr>';
								$audit_trail_value_arr = json_decode($audit_trail['description'], true);
								foreach ($audit_trail_value_arr AS $audit_trail_values)
								{
									foreach ($audit_trail_values AS $audit_trail_field => $audit_trail_value);
									{
										if ($audit_trail_value==0)
										{
											$audit_trail_value = "Uncontacted";
										}
										else if ($audit_trail_value==1)
										{
											$audit_trail_value = "Undecided";
										}
										else if ($audit_trail_value==2)
										{
											$audit_trail_value = "Not Interested";
										}
										else if ($audit_trail_value==3)
										{
											$audit_trail_value = "Buying";
										}
										
										$html .= '
										<tr>
											<td>'.$audit_trail_field.'</td>
											<td>'.$audit_trail_value.'</td>
										</tr>';
									}
								}
								$html .= '
							</table>
						</div>';
					}
					else if ($audit_trail['action']==31)
					{
						$audit_trail_value_arr = json_decode($audit_trail['description'], true);
						foreach ($audit_trail_value_arr AS $audit_trail_values)
						{
							foreach ($audit_trail_values AS $audit_trail_field => $audit_trail_value);
							{
								$html .= '<br /><br /><i>"'.$audit_trail_value.'"</i>';
							}
						}
					}
					else
					{
						$html .= '
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-condensed mb-none">
								<tr>
									<td width="30%"><b>Field</b></td>
									<td width="70%"><b>Value</b></td>
								</tr>';
								$audit_trail_value_arr = json_decode($audit_trail['description'], true);
								foreach ($audit_trail_value_arr AS $audit_trail_values)
								{
									foreach ($audit_trail_values AS $audit_trail_field => $audit_trail_value);
									{
										$html .= '
										<tr>
											<td>'.$audit_trail_field.'</td>
											<td>'.$audit_trail_value.'</td>
										</tr>';
									}
								}
								$html .= '
							</table>
						</div>';
					}
				}
				$html .= '
			</div>
			<br />';
		}
		echo $html;		
	}

	public function return_to_pre_tender ()
	{
		$data = $this->data;
		$lead_id = $this->input->post("lead_id");
		$this->lead_model->return_to_pre_tender($lead_id);
		$audit_trail_arr = array(
			'id' => $lead_id,
			'table_name' => 'leads',
			'action' => 39,
			'description' => ''
		);
		$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);
	}

	public function return_to_tendering ()
	{
		$data = $this->data;
		$lead_id = $this->input->post("lead_id");
		$this->lead_model->return_to_tendering($lead_id);
		$audit_trail_arr = array(
			'id' => $lead_id,
			'table_name' => 'leads',
			'action' => 40,
			'description' => ''
		);
		$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);
	}

	public function get_invoice_item_types ()
	{
		$html = "";

		$result = $this->lead_model->get_invoice_item_types();

		foreach ($result as $r_key => $r_val) 
		{
			$html .= "<option value='{$r_val['name']}'>{$r_val['name']}</option>";
		}

		echo $html;
	}

	public function sample_submit ()
	{
		$data = $this->data;
		$post_data = $this->input->post();

		$now = date("Y-m-d");
		
		$invoice_amount = 0;
		$invoice_item_arr = [];
		foreach ($post_data['invoice_item_amount_array'] as $i_key => $i_val) 
		{
			$description = "";

			$invoice_item_arr[$i_key]['amount'] = ($post_data['invoice_item_amount_array'][$i_key] != "") ? $post_data['invoice_item_amount_array'][$i_key] : "0.00";

			if ($post_data['invoice_item_array'][$i_key][0] != "")
			{
				$invoice_item_arr[$i_key]['description'] = implode(", ",  $post_data['invoice_item_array'][$i_key]);
			}
			else
			{
				$invoice_item_arr[$i_key]['description'] = "";
			}
			
			if ($post_data['invoice_item_description_array'][$i_key] <> "")
			{
				$invoice_item_arr[$i_key]['description'] .= "<br />".$post_data['invoice_item_description_array'][$i_key]."";
			}

			$invoice_amount += (float)$invoice_item_arr[$i_key]['amount'];
		}

		$invoice_input_arr = array(
			'invoice_number' => 'CCI_'.$post_data['lead_id'],
			'invoice_name'   => 'Client Invoice',
			'invoice_type'   => 'Client',
			'amount'         => $invoice_amount,
			'invoice_date'   => $now,
			'due_date'       => $now,
			'promised_date'  => $now,
			'details'        => 'Test',
			'remarks'        => 'Test'
		);
		$this->invoice_model->insert_invoice($data['user_id'], $post_data['lead_id'], $invoice_input_arr);
		$invoice_id = $this->db->insert_id();
		
		$invoice_item = [];
		foreach ($invoice_item_arr as $invoice_item) 
		{			
			$invoice_item_input_arr = array(
				'description' => $invoice_item['description'],
				'amount' => $invoice_item['amount']
			);
			$this->invoice_model->insert_invoice_item($invoice_id, $invoice_item_input_arr);
		}
	}

	


	public function history ($start = 0) // TO BE REVIEWED //
	{
		header("Location: " . site_url('lead/list_view'));
		exit();			
		
		$data = $this->data;
		$data['title'] = 'Leads - History';

		$limit = 20;
		$count_result = $this->action_model->get_leads_actions_count($_GET, $data['user_id'], $data['admin_type']); // Record count
		$data['lead_actions'] = $this->action_model->get_leads_actions($_GET, $data['user_id'], $data['admin_type'], $start, $limit); // Main Query

		$this->load->library('pagination');
		$config['base_url'] = site_url('lead/history/');
		$config['total_rows'] = $count_result['cnt'];
		$config['per_page'] = $limit;
		$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);

		$this->pagination->initialize($config); 
		$data['links'] = $this->pagination->create_links();

		$this->load->view('admin/lead_actions', $data);
	}	

	public function stats_complete () // TO BE REVIEWED //
	{
		header("Location: " . site_url('lead/list_view'));
		exit();			
		
		$data = $this->data;
		$data['title'] = 'Lead - Stats';
		$data['leads_summary'] = $this->lead_model->get_leads_summary(); // Main Query
		$this->load->view('admin/lead_stats_complete', $data);
	}	
	
	public function stats () // TO BE REVIEWED //
	{
		header("Location: " . site_url('lead/list_view'));
		exit();
		
		$data = $this->data;
		$data['title'] = 'Leads - Stats';
		
		if (isset($_GET['period_type']))
		{
			if ($_GET['period_type']=='')
			{
				$params['period_type'] = '1';
			}
			else
			{
				$params['period_type'] = $_GET['period_type'];
			}
		}
		else
		{
			$params['period_type'] = '1';
		}
		
		if (isset($_GET['date_type']))
		{
			if ($_GET['date_type']=='')
			{
				$params['date_type'] = '1';
			}
			else
			{
				$params['date_type'] = $_GET['date_type'];
			}
		}
		else
		{
			$params['date_type'] = '1';
		}

		if ($params['date_type']==1) { $params['date_type'] = 'allocated_date'; }
		else if ($params['date_type']==2) { $params['date_type'] = 'attempted_date'; }
		else if ($params['date_type']==3) { $params['date_type'] = 'tender_date'; }
		else if ($params['date_type']==4) { $params['date_type'] = 'winner_date'; }
		else if ($params['date_type']==5) { $params['date_type'] = 'order_date'; }
		else if ($params['date_type']==6) { $params['date_type'] = 'approved_date'; }
		else if ($params['date_type']==7) { $params['date_type'] = 'decline_date'; }
		else if ($params['date_type']==8) { $params['date_type'] = 'deleted_date'; }
		else { $params['date_type'] = 'allocated_date'; }
		
		if ($params['period_type']==1) { $params['period_type'] = 'day'; }
		else if ($params['period_type']==2) { $params['period_type'] = 'week'; }
		else { $params['period_type'] = 'day'; }
		
		$current_date = date('Y-m-d');
		$current_year = date('Y');
		$current_date_f = new DateTime($current_date);
		
		$current_week_number = $current_date_f->format("W");
		$prev_1_week = $current_week_number - 1;
		$prev_2_week = $current_week_number - 2;
		$prev_3_week = $current_week_number - 3;
		$prev_4_week = $current_week_number - 4;
		$prev_5_week = $current_week_number - 5;
		$prev_6_week = $current_week_number - 6;

		
		if ($params['period_type']=='day')
		{
			$dto = new DateTime();
			$dto->setISODate($current_year, $current_week_number);
			$week_start = $dto->format('Y-m-d');
			$dto->modify('+6 days');
			$week_end = $dto->format('Y-m-d');
			
			$days = array();
			$iDateFrom = mktime(1,0,0,substr($week_start,5,2),substr($week_start,8,2),substr($week_start,0,4));
			$iDateTo = mktime(1,0,0,substr($week_end,5,2),substr($week_end,8,2),substr($week_end,0,4));
			if ($iDateTo>=$iDateFrom)
			{
				array_push($days,date('Y-m-d',$iDateFrom));
				while ($iDateFrom<$iDateTo)
				{
					$iDateFrom+=86400;
					array_push($days,date('Y-m-d',$iDateFrom));
				}
			}
			$params['d'] = $days;
			$data['d'] = $days;
			$data['lead_counter'] = $this->dashboard_model->get_lead_counter_days($params);
		}
		else if ($params['period_type']=='week')
		{		
			$dto = new DateTime();
			$dto->setISODate($current_year, $current_week_number);
			$week_start[0] = $dto->format('Y-m-d');
			$dto->modify('+6 days');
			$week_end[0] = $dto->format('Y-m-d');

			$dto = new DateTime();
			$dto->setISODate($current_year, $prev_1_week);
			$week_start[1] = $dto->format('Y-m-d');
			$dto->modify('+6 days');
			$week_end[1] = $dto->format('Y-m-d');
			
			$dto = new DateTime();
			$dto->setISODate($current_year, $prev_2_week);
			$week_start[2] = $dto->format('Y-m-d');
			$dto->modify('+6 days');
			$week_end[2] = $dto->format('Y-m-d');

			$dto = new DateTime();
			$dto->setISODate($current_year, $prev_3_week);
			$week_start[3] = $dto->format('Y-m-d');
			$dto->modify('+6 days');
			$week_end[3] = $dto->format('Y-m-d');

			$dto = new DateTime();
			$dto->setISODate($current_year, $prev_4_week);
			$week_start[4] = $dto->format('Y-m-d');
			$dto->modify('+6 days');
			$week_end[4] = $dto->format('Y-m-d');

			$dto = new DateTime();
			$dto->setISODate($current_year, $prev_5_week);
			$week_start[5] = $dto->format('Y-m-d');
			$dto->modify('+6 days');
			$week_end[5] = $dto->format('Y-m-d');
			
			$dto = new DateTime();
			$dto->setISODate($current_year, $prev_6_week);
			$week_start[6] = $dto->format('Y-m-d');
			$dto->modify('+6 days');
			$week_end[6] = $dto->format('Y-m-d');			
			
			$params['week_start'] = $week_start;
			$params['week_end'] = $week_end;
			$data['d'] = array(
				'Week '.$prev_6_week.'<br /> '.str_replace('2016-', '', $week_start[6]).' to '.str_replace('2016-', '', $week_end[6]).'', 
				'Week '.$prev_5_week.'<br /> '.str_replace('2016-', '', $week_start[5]).' to '.str_replace('2016-', '', $week_end[5]).'', 
				'Week '.$prev_4_week.'<br /> '.str_replace('2016-', '', $week_start[4]).' to '.str_replace('2016-', '', $week_end[4]).'', 
				'Week '.$prev_3_week.'<br /> '.str_replace('2016-', '', $week_start[3]).' to '.str_replace('2016-', '', $week_end[3]).'', 
				'Week '.$prev_2_week.'<br /> '.str_replace('2016-', '', $week_start[2]).' to '.str_replace('2016-', '', $week_end[2]).'', 
				'Week '.$prev_1_week.'<br /> '.str_replace('2016-', '', $week_start[1]).' to '.str_replace('2016-', '', $week_end[1]).'', 
				'Week '.$current_week_number.'<br /> '.str_replace('2016-', '', $week_start[0]).' to '.str_replace('2016-', '', $week_end[0]).''
			);
			$data['lead_counter'] = $this->dashboard_model->get_lead_counter_weeks($params);
		}
		else if ($params['period_type']=='month')
		{

		}
		
		$this->load->view('admin/lead_counter', $data);
	}
}
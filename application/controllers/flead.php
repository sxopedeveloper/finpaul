<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Flead extends CI_Controller {

	var $data;
	var $email_header = '
	<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<meta name="generator" content="HTML Tidy for Linux/x86 (vers 25 March 2009), see www.w3.org">		
			<title>DealQuote</title>
		</head>	
		<body bgcolor="#ffffff" style="font-family: Calibri, sans-serif;background-color: #ffffff;">
			<table style="border-spacing: 0px" bgcolor="#FFFFFF" width="100%" cellspacing="0" cellpadding="0">
				<tbody>
					<tr>
						<td align="center" colspan="2">
							<br /><br />
						</td>
					</tr>			
					<tr>
						<td valign="middle" width="50%" align="left">
						
						</td>';

						/*	<a href="http://dealers.carquote.net.au" rilt="Header_Logo" target="_blank" style="text-decoration: none;">
								<img src="http://www.carquote.net.au/assets/img/logo.png" width="180px;"><br />
							</a>
							*/
	var $lead_email_header = '
	<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<meta name="generator" content="HTML Tidy for Linux/x86 (vers 25 March 2009), see www.w3.org">		
			<title>DealQuote</title>
		</head>	
		<body bgcolor="#ffffff" style="font-family: Calibri, sans-serif;background-color: #ffffff;">
			<table style="border-spacing: 0px" bgcolor="#FFFFFF" width="100%" cellspacing="0" cellpadding="0">
				<tbody>
					<tr>
						<td align="center" colspan="2">
							<br /><br />
						</td>
					</tr>			
					<tr>
						<td valign="middle" width="50%" align="left">
						
						</td>
						<td valign="middle" width="50%" align="right">
							HEADER_1<br />
							Reference Number: HEADER_2<br />
							Car Quotes Consultant: HEADER_3
						</td>
					</tr>';
					/*	<a href="http://dealers.carquote.net.au" rilt="Header_Logo" target="_blank" style="text-decoration: none;">
								<img src="http://www.carquote.net.au/assets/img/logo.png" width="180px;"><br />
							</a>
							*/
	var $email_footer = '
					<tr>
						<td align="center" colspan="2">
							<br /><br /><br />
							<p><i>To the extent permitted by law, Car Quotes Online Pty Ltd will not be liable to any person or organisation under any circumstances for any indirect, consequential, incidental or special damages arising in any way out of providing this service.</i></p>
						</td>
					</tr>
				</tbody>
			</table>
			<div style="display:none; white-space:nowrap; font:15px courier; color:#ffffff;">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -</div>
		</body>
	</html>';

	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model', '', TRUE);
		$this->load->model('car_model', '', TRUE);
		$this->load->model('request_model', '', TRUE);
		$this->load->model('quote_model', '', TRUE);
		$this->load->model('lead_model', '', TRUE);
		$this->load->model('tradein_model', '', TRUE);
		$this->load->model('reallocation_model', '', TRUE);
		$this->load->model('action_model', '', TRUE);
		$this->load->model('flead_model', '', TRUE);
		$this->load->model('freallocation_model', '', TRUE);
		
		if($this->session->userdata('logged_in'))
		{
			if ($this->session->userdata('login_type') != 'Admin')
			{
				header("Location: " . site_url());
				exit();
			}
			else
			{
				$this->data = array(
					'logged_in' => $this->session->userdata('logged_in'),
					'login_type' => $this->session->userdata('login_type'),
					'admin_type' => $this->session->userdata('admin_type'),
					'user_id' => $this->session->userdata('user_id'),
					'username' => $this->session->userdata('username'),
					'name' => $this->session->userdata('name'),
					'phone' => $this->session->userdata('phone'),
					'mobile' => $this->session->userdata('mobile'),
					'state' => $this->session->userdata('state'),
					'postcode' => $this->session->userdata('postcode'),
					'status' => $this->session->userdata('status')
				);
			}
		}
		else
		{
			header("Location: " . site_url('login'));
			exit();
		}
	}

	function index()
	{
		header("Location: " . site_url('flead/list_view'));
		exit();
	}
	
	public function new_record () // PAGE VIEW (DONE)
	{
		$data = $this->data;
		$data['title'] = 'FinQuote Leads - Create New';
		$this->load->view('admin/flead_form', $data);
	}
	
	public function add_record () // PAGE ACTION (DONE)
	{
		$data = $this->data;
		$input_arr = $this->input->post();

		if (!$this->input->post())
		{
			header ("Location: ".site_url('flead/new_record'));
			exit ();
		}
		
		$input_arr['user_id'] = $data['user_id'];
		$this->flead_model->add_lead($input_arr);	

		header ("Location: ".site_url('flead/list_view'));
		exit ();
	}
	
	// LIST VIEW //
	public function list_view ($start = 0) // PAGE VIEW (LV) (DONE)
	{		
		$data = $this->data;
		$data['title'] = 'FinQuote Leads - List View';

		$limit = 50;
		$count_result = $this->flead_model->get_leads_count($_GET, $data['user_id'], $data['admin_type']);  // Record count
		$data['leads'] = $this->flead_model->get_leads($_GET, $data['user_id'], $data['admin_type'], $start, $limit); // Main Query
		$data['admins'] = $this->user_model->get_admins(); // Quote Specialists for Assignment
		$data['rl_admins'] = $this->user_model->get_admins($data['user_id']); // Quote Specialists for Reallocation

		$this->load->library('pagination');
		$config['base_url'] = site_url('flead/list_view/'); 
		$config['total_rows'] = $count_result['cnt'];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config); 
		$data['links'] = $this->pagination->create_links();

		$data['result_count'] = $count_result['cnt'];
		$this->load->view('admin/fleads', $data);
	}
	
	public function open_note ($lead_id) // MODAL VIEW (DONE)
	{
		$query = "SELECT details FROM finance_leads WHERE id_lead = ".$lead_id." LIMIT 1";
		$result = $this->db->query($query);
		if (count($result)==0)
		{
			$lead_note = '<br /><br /><center><i>No result found!</i></center>';
		}
		else
		{
			$lead_note = '';			
			foreach ($result->result() as $row)
			{
				$lead_note .= $row->details;				
			}
		}
		$lead_note_arr = array("lead_note" => $lead_note);
		echo json_encode($lead_note_arr);
	}

	public function allocate () // MODAL ACTION (DONE - Review EMAIL)
	{
		$lead_ids = $this->input->post('lead_ids');
		$user_id = $this->input->post('user_id');
		
		$this->flead_model->allocate_leads($lead_ids, $user_id);
		$this->flead_model->update_leads_status($lead_ids, 1);
		
		$this->load->library('email');
		
		$admin_detail = $this->user_model->get_admin($user_id);
		$lead_id_arr = explode(',', $lead_ids);

		foreach ($lead_id_arr as $lead_id)
		{
			if ($lead_id != 'on')
			{
				$now = date('Y-m-d H:i:s');
				$this->flead_model->update_lead_date($lead_id, $now, 'allocated_date');
			}
		}
	}
	
	public function reallocate () // MODAL ACTION (DONE)
	{
		$data = $this->data;
	
		$lead_ids = $this->input->post('lead_ids');
		$user_id = $this->input->post('user_id');
		$details = $this->input->post('details');
		
		$lead_ids_arr = explode(',', $lead_ids);

		foreach ($lead_ids_arr as $lead_id)
		{
			$this->freallocation_model->insert_lead_reallocation($lead_id, $data['user_id'], $user_id, $details);
		}
	}
	
	public function reallocations ($start = 0) // PAGE VIEW
	{
		$data = $this->data;
		$data['title'] = 'FinQuote Leads - Reallocations';

		$limit = 50;
		$count_result = $this->freallocation_model->get_reallocations_count($_GET, $data['user_id'], $data['admin_type']);  // Record count
		$data['reallocations'] = $this->freallocation_model->get_reallocations($_GET, $data['user_id'], $data['admin_type'], $start, $limit); // Main Query
		$data['admins'] = $this->user_model->get_admins(); // Quote Specialists for Assignment

		$this->load->library('pagination');
		$config['base_url'] = site_url('flead/reallocations/'); 
		$config['total_rows'] = $count_result['cnt'];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config); 
		$data['links'] = $this->pagination->create_links();

		$this->load->view('admin/freallocations', $data);
	}

	public function approve_reallocation () // MODAL ACTION
	{
		$data = $this->data;

		$reallocation_ids = $this->input->post('reallocation_ids');
		$this->freallocation_model->update_reallocation_status($reallocation_ids, $data['user_id'], 1);
		$this->flead_model->update_lead_quote_specialists($reallocation_ids);
	}	

	public function send_email () // MODAL ACTION (DONE)
	{
		$data = $this->data;

		$lead_ids = $this->input->post('lead_ids');
		$user_id = $data['user_id'];
		$email_subject = $this->input->post('email_subject');
		$email_message = $this->input->post('email_message');
		
		$this->load->library('email');
		
		$admin_detail = $this->user_model->get_admin($user_id);
		$lead_id_arr = explode(',', $lead_ids);
		foreach ($lead_id_arr as $lead_id)
		{
			if ($lead_id != 'on')
			{
				$lead_detail = $this->flead_model->get_lead_client($lead_id);

				$email_header = $this->lead_email_header;
				$email_header = str_replace('HEADER_1', $email_subject, $email_header);
				$email_header = str_replace('HEADER_2', rand(209381, 929102), $email_header);
				$email_header = str_replace('HEADER_3', $admin_detail['name'], $email_header);			
				$email_body = '
				<tr>
					<td align="left" colspan="2">
						<p align="justify">
							<br /><br /><br /><br />
							Dear '.$lead_detail['name'].',
							<br /><br />					
							'.$email_message.'
						</p>
						<br /><br />
					</td>
				</tr>';
				$email_body = '
				<tr>
					<td align="left" colspan="2">
						<p align="justify">
							<br /><br /><br /><br />
							'.$email_message.'
						</p>
						<br /><br />
					</td>
				</tr>';
				$email_content = $email_header.$email_body.$this->email_footer;
				$this->email->clear();
				$this->email->set_mailtype('html');
				$this->email->to($lead_detail['email']);
				$this->email->from($admin_detail['username'], $admin_detail['name']);
				$this->email->subject($email_subject);
				$this->email->message($email_content);
				$this->email->send();
			}
		}
	}		

	public function delete () // MODAL ACTION (DONE)
	{
		$lead_ids = $this->input->post('lead_ids');
		$this->flead_model->delete_leads($lead_ids);
	}

	// CALENDAR VIEW //
	public function calendar_view ($status_id = 'all') // PAGE VIEW (CV) (PENDING)
	{
		$data = $this->data;
		$data['title'] = 'FinQuote Leads - Calendar View';

		$data['leads'] = $this->flead_model->get_qs_leads($data['user_id'], $status_id); // Main Query
		$data['status_id'] = $status_id;
		$this->load->view('admin/allocated_leads', $data);
	}
	
	public function update_assignment_date ($lead_id) // CALENDAR ACTION (PENDING)
	{
		$new_date = $this->input->post('new_date');
		$this->flead_model->update_lead_date($lead_id, $new_date, 'assignment_date');
	}	
	
    public function record ($lead_id) // MODAL VIEW (LEAD POPUP) (DONE)
    {
		$data = $this->data;
		
		$this->action_model->insert_action(2, $lead_id, $data['user_id'], 'Opened the Lead');

		$query = "
		SELECT
		id_lead, CONCAT('FQ', LPAD(id_lead, 5, '0')) AS `fq_number`, status,
		CASE (status)
			WHEN 0 THEN 'Unallocated'
			WHEN 1 THEN 'Allocated'
			WHEN 2 THEN 'Attempted'
			WHEN 100 THEN 'Deleted'
		END `status_text`,
		name, email, phone, mobile, state, postcode, address, details, created_at, last_updated
		FROM finance_leads WHERE 1 AND id_lead = ".$lead_id." LIMIT 1";
		$result = $this->db->query($query);
		foreach ($result->result() as $row)
		{
			$client_details = '
			<tr>
				<td width="30%">Client Name:</td>
				<td>
					<input value="'.$lead_id.'" id="id_lead" name="id_lead" type="hidden">
					<input value="'.$row->name.'" class="form-control input-sm" id="name" name="name" type="text">
				</td>
			</tr>
			<tr>
				<td>Email Address:</td>
				<td>
					<input value="'.$row->email.'" class="form-control input-sm" id="email" name="email" type="text">
				</td>
			</tr>
			<tr>
				<td>Phone:</td>
				<td>
					<input value="'.$row->phone.'" class="form-control input-sm" id="phone" name="phone" type="text">
				</td>
			</tr>			
			<tr>
				<td>Mobile:</td>
				<td>
					<input value="'.$row->mobile.'" class="form-control input-sm" id="mobile" name="mobile" type="text">
				</td>
			</tr>
			<tr>
				<td>Address:</td>
				<td>
					<input value="'.$row->address.'" class="form-control input-sm" id="address" name="address" type="text">
				</td>
			</tr>';

			$actions_history = '';
			$history_query = "
			SELECT u.name, ac.details, ac.created_at
			FROM actions ac
			JOIN users u ON ac.fk_user = u.id_user
			WHERE ac.type = 2 AND ac.id = ".$lead_id." ORDER BY ac.id_action DESC";
			$history_result = $this->db->query($history_query);
			foreach ($history_result->result() as $history_row)
			{
				$actions_history .= '<tr><td>'.$history_row->details.'</td><td>'.$history_row->name.'</td><td>'.$history_row->created_at.'</td></tr>';
			}

			$actions = '
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-warning" onclick="flead_called()">Called Client</button>
			<button type="button" class="btn btn-danger" onclick="delete_flead()">Delete</button>
			<button type="button" class="btn btn-primary" onclick="save_flead_info()">Save</button>
			';

			$email_1 = $this->flead_model->get_lead_email($row->id_lead, 1);
			$email_2 = $this->flead_model->get_lead_email($row->id_lead, 2);
			$email_3 = $this->flead_model->get_lead_email($row->id_lead, 3);
			$email_4 = $this->flead_model->get_lead_email($row->id_lead, 4);

			$email_1_disabled = '';
			$email_1_sent = '';
			if (isset($email_1['created_at']))
			{
				$email_1_disabled = ' disabled';
				$email_1_disabled = '';
				$email_1_sent = '('.$email_1['created_at'].')';
			}

			$email_2_disabled = '';
			$email_2_sent = '';
			if (isset($email_2['created_at']))
			{
				$email_2_disabled = ' disabled';
				$email_2_disabled = '';
				$email_2_sent = '('.$email_2['created_at'].')';
			}

			$email_3_disabled = '';
			$email_3_sent = '';
			if (isset($email_3['created_at']))
			{
				$email_3_disabled = ' disabled';
				$email_3_disabled = '';
				$email_3_sent = '('.$email_3['created_at'].')';
			}

			$email_4_disabled = '';
			$email_4_sent = '';
			if (isset($email_4['created_at']))
			{
				$email_4_disabled = ' disabled';
				$email_4_disabled = '';
				$email_4_sent = '('.$email_4['created_at'].')';
			}

			$email_actions = '
			<button type="button" class="btn btn-warning" id="send_email_1" onclick="send_email_f(1)" '.$email_1_disabled.'>
				Not Ready '.$email_1_sent.'
			</button>
			<button type="button" class="btn btn-warning" id="send_email_2" onclick="send_email_f(2)" '.$email_2_disabled.'>
				No Answer '.$email_2_sent.'
			</button>
			<button type="button" class="btn btn-warning" id="send_email_3" onclick="send_email_f(3)" '.$email_3_disabled.'>
				Wrong Number '.$email_3_sent.'
			</button>
			<button type="button" class="btn btn-warning" id="send_email_4" onclick="send_email_f(4)" '.$email_4_disabled.'>
				New Car Inquiry '.$email_4_sent.'
			</button>		
			';
			$email_actions = '';

			$lead_arr = array(
				"status_id" => $row->status,
				"status" => $row->status_text,
				"id_lead" => $row->id_lead,
				"fq_number" => $row->fq_number,
				"name" => $row->name,
				"email" => $row->email,
				"phone" => $row->phone,
				"mobile" => $row->mobile,
				"state" => $row->state,
				"details" => $row->details,
				"client_details" => $client_details,
				"actions_history" => $actions_history,
				"email_actions" => $email_actions,
				"actions" => $actions,
				"created_at" => $row->created_at,
				"last_updated" => $row->last_updated
			);
		}
		echo json_encode($lead_arr);
    }	

	public function update_record () // MODAL ACTION
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;
		$input_arr = $this->input->post();
		$this->flead_model->update_lead_details($input_arr);
		$this->action_model->insert_action(2, $input_arr['id_lead'], $data['user_id'], 'Update');
		if ($input_arr['lead_status']<=1)
		{
			$this->flead_model->update_lead_status($input_arr['id_lead'], 2);
			$this->flead_model->update_lead_date($input_arr['id_lead'], $now, 'attempted_date');
		}
	}
	
	public function lead_called () // MODAL ACTION
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;
		$input_arr = $this->input->post();
		$this->action_model->insert_action(2, $input_arr['id_lead'], $data['user_id'], 'Called Client');
		if ($input_arr['lead_status']<=1)
		{
			$this->flead_model->update_lead_status($input_arr['id_lead'], 2);
			$this->flead_model->update_lead_date($input_arr['id_lead'], $now, 'attempted_date');
		}
	}
	
	public function email_client () // MODAL ACTION
	{
		$data = $this->data;

		$lead_id = $this->input->post('lead_id');
		$type = $this->input->post('type');

		$lead_detail = $this->flead_model->get_lead_client($lead_id);
		$admin_detail = $this->user_model->get_admin($lead_detail['fk_user']);

		$this->flead_model->update_lead_status($lead_id, 2);
		$now = date("Y-m-d H:i:s");
		$this->flead_model->update_lead_date($lead_id, $now, 'attempted_date');
		$this->action_model->insert_action(2, $lead_id, $data['user_id'], 'Client Email: '.$type);

		// 1: Not Ready
		// 2: No Answer
		// 3: Wrong Number
		// 4: New Car Inquiry

		$email_header = $this->lead_email_header;

		if ($type == 1) // NOT READY
		{
			$email_subject = 'FinQuote: We just spoke on the phone';

			$email_header = str_replace('HEADER_1', 'FinQuote', $email_header);
			$email_header = str_replace('HEADER_2', rand(209381, 929102), $email_header);
			$email_header = str_replace('HEADER_3', $admin_detail['name'], $email_header);			
		
			$email_message = '
			<p align="justify">
				We just spoke on the phone and talked about FinQuote. While you were not quite ready to tender we wanted you to know that we would love you to feel comfortable re-contacting us in the future. We are able to generate massive discounts on cars and our service is free to use. You can\'t lose!
			</p>
			<p align="justify">
				When you are ready please email us your details.
			</p>
			<p align="justify">
				Alternately, call us anytime on 1300 793 251.
			</p>
			<p align="justify">
				<br /><br />
				Thank you again,
				<br />
				The FinQuote Team
			</p>';
		}
		else if ($type == 2) // NO ANSWER
		{
			$email_subject = 'FinQuote: We have tried to call you';
			
			$email_header = str_replace('HEADER_1', 'FinQuote', $email_header);
			$email_header = str_replace('HEADER_2', rand(209381, 929102), $email_header);
			$email_header = str_replace('HEADER_3', $admin_detail['name'], $email_header);
			
			$email_message = '
			<p align="justify">
				We have tried to call you to confirm your details. We were unable to reach you but wanted you to know that we tried!
			</p>
			<p align="justify">
				If were are busy and unable to call back, please email us with your details.
			</p>
			<p align="justify">
				Alternately, call us anytime on 1300 793 251.
			</p>
			<p align="justify">
				<br /><br />
				Thank you again,
				<br />
				The FinQuote Team
			</p>';		
		}
		else if ($type == 3) // WRONG NUMBER
		{
			$email_subject = 'FinQuote: We tried to call';

			$email_header = str_replace('HEADER_1', 'FinQuote', $email_header);
			$email_header = str_replace('HEADER_2', rand(209381, 929102), $email_header);
			$email_header = str_replace('HEADER_3', $admin_detail['name'], $email_header);
			
			$email_message = '
			<p align="justify">
				We have tried to call you however were unable to reach you on the supplied number. Please email or call info@finquote.net.au or 1300 793 251.
			</p>
			<p align="justify">
				We would like to confirm your details.
			</p>
			<p align="justify">
				Alternately, call us anytime on 1300 793 251.
			</p>
			<p align="justify">
				<br /><br />
				Thank you again,
				<br />
				The FinQuote Team
			</p>';
		}

		$email_body = '
		<tr>
			<td align="left" colspan="2">
				<p align="justify">
					<br /><br /><br /><br />
					Dear '.$lead_detail['name'].',
					<br />
				</p>
				'.$email_message.'
				<br /><br /><br />
			</td>
		</tr>';

		$this->load->library('email');

		$email_content = $email_header.$email_body.$this->email_footer;
		$this->email->clear();
		$this->email->set_mailtype('html');
		$this->email->to($lead_detail['email']);
		$this->email->bcc('jeno.g.cabrera@gmail.com');
		$this->email->from($admin_detail['username'], $admin_detail['name']);
		$this->email->subject($email_subject);
		$this->email->message($email_content);
		$this->email->send();
	}	
	
	public function delete_calendar () // MODAL ACTION
	{
		$now = date('Y-m-d H:i:s');
		$data = $this->data;
		$lead_id = $this->input->post('lead_id');
		$this->flead_model->update_lead_date($lead_id, $now, 'deleted_date');
		$this->flead_model->update_lead_status($lead_id, 100);
		$this->action_model->insert_action(2, $lead_id, $data['user_id'], 'Delete');
	}
}
?>
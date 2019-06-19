<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('admin_main.php');

class Payment extends Admin_main 
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		header("Location: " . site_url('payment/list_view'));
		exit();
	}

	public function list_view ()
	{
		$data = $this->data;
		$data['title'] = 'Payment';
		$user_data           = $this->payment_model->get_user($data['user_id']);
		
		$data['balance']     = number_format($user_data['balance'], 2, '.', ',');
		$data['token_infos'] = $this->payment_model->get_token_infos($data['user_id']);
		$this->load->view('admin/payment_view', $data);
	}

	public function get_payment ()
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;
		
		$input_arr = $this->input->post();	

		$payment = $this->payment_model->get_payment($input_arr['id_payment']);

		$response_array = [
			'fk_payment_type' => $payment['fk_payment_type'],
			'reference_number' => $payment['reference_number'],
			'payment_date' => $payment['payment_date'],
			'amount' => $payment['amount'],
			'admin_fee' => $payment['admin_fee'],
			'merchant_cost' => $payment['merchant_cost'],
			'method' => $payment['method'],
			'credit_card' => $payment['credit_card'],
			'bank_account' => $payment['bank_account'],
			'remarks' => $payment['remarks']
		];

		echo json_encode($response_array);		
	}
	
	public function add_payment ()
	{
		$data = $this->data;
		$input_arr = $this->input->post();

		/*
		$admin_fee = 0.00;
		$admin_fee_flag = $this->lead_model->get_admin_fee_flag($input_arr['id_lead']);
		if($admin_fee_flag || $input_arr['fk_payment_type'] == 17)
		{
			$admin_fee = 165.00;
		}
		*/
		
		$insert_payment_result = $this->payment_model->insert_payment($data['user_id'], $input_arr);

		if ($insert_payment_result)
		{
			$payment_id = $this->db->insert_id();
			
			$audit_trail_arr = array(
				'id' => $payment_id,
				'table_name' => 'payments',
				'action' => 18,
				'description' => '[{"lead_id":"'.$input_arr['id_lead'].'"}]'
			);
			$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);
			$this->action_model->insert_action(1, $input_arr['id_lead'], $data['user_id'], 'Payment Added');			
			
			echo "success";
		}
		else
		{
			echo "fail";
		}
	}
	
	public function update_payment ()
	{
		$data = $this->data;
		$input_arr = $this->input->post();

		$update_payment_result = $this->payment_model->update_payment($input_arr['id_payment'], $input_arr);

		if ($update_payment_result)
		{
			/*
			$audit_trail_arr = array(
				'id' => $payment_id,
				'table_name' => 'payments',
				'action' => 18,
				'description' => '[{"lead_id":"'.$input_arr['id_lead'].'"}]'
			);
			$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);
			$this->action_model->insert_action(1, $input_arr['id_lead'], $data['user_id'], 'Payment Added');			
			*/
			
			echo "success";
		}
		else
		{
			echo "fail";
		}
	}

	public function update_payment_show_status ()
	{
		$data = $this->data;
		$input_arr = $this->input->post();

		$update_payment_result = $this->payment_model->update_payment_show_status($input_arr['id_payment'], $input_arr);

		if ($update_payment_result)
		{
			/*
			$audit_trail_arr = array(
				'id' => $payment_id,
				'table_name' => 'payments',
				'action' => 18,
				'description' => '[{"lead_id":"'.$input_arr['id_lead'].'"}]'
			);
			$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);
			$this->action_model->insert_action(1, $input_arr['id_lead'], $data['user_id'], 'Payment Added');			
			*/
			
			echo "success";
		}
		else
		{
			echo "fail";
		}
	}	
	
	public function delete_payment ()
	{
		$data = $this->data;
		$input_arr = $this->input->post();

		if (isset($input_arr['id_payment']))
		{
			$delete_payment_result = $this->payment_model->delete_payment($input_arr['id_payment']);

			if ($delete_payment_result)
			{
				echo "success";
			}
		}
		else
		{
			echo "fail";
		}		
	}
}
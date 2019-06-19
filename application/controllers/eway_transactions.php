<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('eway.php');

class Eway_transactions extends Eway 
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('user_model', '', TRUE);
		$this->load->model('car_model', '', TRUE);
		$this->load->model('ticket_model', '', TRUE);
		$this->load->model('eway_transactions_model');		

		if($this->session->userdata('logged_in'))
		{			
			$this->data = array(
				'logged_in'  => $this->session->userdata('logged_in'),
				'login_type' => $this->session->userdata('login_type'),
				'admin_type' => $this->session->userdata('admin_type'),
				'user_id'    => $this->session->userdata('user_id'),
				'username'   => $this->session->userdata('username'),
				'name'       => $this->session->userdata('name'),
				'phone'      => $this->session->userdata('phone'),
				'mobile'     => $this->session->userdata('mobile'),
				'state'      => $this->session->userdata('state'),
				'postcode'   => $this->session->userdata('postcode'),
				'status' => $this->session->userdata('status'),
				'makes' => $this->car_model->get_makes(),
				'ticket_types' => $this->ticket_model->get_ticket_types(),
				'modules' => $this->ticket_model->get_modules()
			);			
		}
		else
		{
			header("Location: " . site_url('login'));
			exit();
		}
	}

	public function index()
	{
		header("Location: " . site_url('eway_transactions/list_view'));
		exit();
	}

	public function list_view()
	{
		$data = $this->data;
		$data['title'] = 'Eway Transactions';
		$page_count = 0;
		$get_data = $this->input->get();

		if( isset($get_data['date_from']) )
		{
			if( $get_data['date_from'] != '' )
			{
				$date_from = date_create($get_data['date_from']);

				$get_data['date_from'] = date_format($date_from, "Y-m-d");
			}
		}
		else
			$get_data['date_from'] = "";

		if( isset($get_data['date_to']) )
		{
			if( $get_data['date_to'] != '' )
			{
				$date_to = date_create($get_data['date_to']);

				$get_data['date_to'] = date_format($date_to, "Y-m-d");
			}
		}
		else
			$get_data['date_to'] = "";
		
		$get_data['user_id']    = $data['user_id'];
		$get_data['login_type'] = $data['login_type'];
		
		$data['transactions'] = $this->eway_transactions_model->get_all_trans($get_data);
		$data['trans_type']   = $this->eway_transactions_model->get_trans_type();
		$data['users']        = $this->eway_transactions_model->get_all_users();
		$data['cq_trans']     = $this->eway_transactions_model->get_cq_trans_type();
	
		$this->load->view('admin/eway_view', $data);
	}
}



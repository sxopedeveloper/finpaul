<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('admin_main.php');

class Client extends Admin_main
{
	function __construct()
	{
	    ob_start();
		parent::__construct();
	}

	function index()
	{
		header("Location: " . site_url('client/list_view'));
		exit();
	}

	public function list_view ($start = 0) // PAGE VIEW
	{		
		$data = $this->data;
		$data['title'] = 'Clients';

		$limit = 20;
		$count_result = $this->lead_model->get_clients_count();  // Record count
		$data['clients'] = $this->lead_model->get_clients($start, $limit); // Main Query

		$this->load->library('pagination');
		$config['base_url'] = site_url('client/list_view/'); 
		$config['total_rows'] = $count_result['cnt'];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config); 
		$data['links'] = $this->pagination->create_links();

		$this->load->view('admin/clients', $data);
	}
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('admin_main.php');

class Carsales extends Admin_main 
{
	function __construct()
	{
		parent::__construct();
	}

	function index ()
	{
		header("Location: " . site_url('carsales/list_view'));
		exit();
	}

	public function list_view ($start = 0) // PAGE VIEW //
	{
		$data = $this->data;
		$data['title'] = 'Car Sales - List View';

		if (!isset($_GET['status']) OR $_GET['status'] == "")
		{
			$_GET['status'] = 0;
		}
		
		$limit = 10;
		$count_result = $this->carsales_model->get_carsales_count($_GET);  // Record count
		$data['carsales'] = $this->carsales_model->get_carsales($_GET, $start, $limit); // Main Query

		$this->load->library('pagination');
		$config['base_url'] = site_url('carsales/list_view/');
		$config['total_rows'] = $count_result['cnt'];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);
		$data['links'] = $this->pagination->create_links();

		$data['carsales_status'] = $_GET['status'];
		$data['result_count'] = $count_result['cnt'];
		$this->load->view('admin/carsales', $data);
	}
	
	public function update_details ($id)
	{
		$this->carsales_model->update_details($id, $_POST);
	}	
	
	public function update_status ($id)
	{
		$this->carsales_model->update_status($id, $_POST['status']);
		
		$now = date("Y-m-d H:i:s");
		$input_arr = [];
		if ($_POST['status']==1)
		{
			$input_arr['called_date'] = $now;
		}
		else if ($_POST['status']==100)
		{
			$input_arr['deleted_date'] = $now;
		}
		$this->carsales_model->update_details($id, $input_arr);
	}
	
	public function remarks ($id)
	{
		$output = $this->carsales_model->get_carsales_remarks($id);
		$output_arr = array("remarks" => $output['remarks']);
		echo json_encode($output_arr);
	}

	public function valuation ($id)
	{
		$output = $this->carsales_model->get_carsales_valuation($id);
		$output_arr = array("valuation" => $output['valuation']);
		echo json_encode($output_arr);		
	}	
}
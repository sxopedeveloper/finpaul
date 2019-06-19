<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('admin_main.php');

class Add_vehicle extends Admin_main
{

	public function __construct()
	{
	    ob_start();
		parent::__construct();
		$this->load->model('add_vehicle_model');
	}

	public function index ()
	{
		$data = $this->data;
		$data['title'] = 'Add Vehicle';

		$data['makes']    = $this->add_vehicle_model->get_dropdown_data(1);
		$data['models']   = $this->add_vehicle_model->get_dropdown_data(2);
		$data['vehicles'] = $this->add_vehicle_model->get_dropdown_data(3);

		$this->load->view('admin/add_vehicles', $data);
	}

	public function add_make()
	{
		$post_data = $this->input->post();

		$this->add_vehicle_model->add_make($post_data);
	}

	public function add_model()
	{
		$post_data = $this->input->post();

		$this->add_vehicle_model->add_model($post_data);
	}

	public function add_vehicles()
	{
		$post_data = $this->input->post();

		$this->add_vehicle_model->add_vehicles($post_data);
	}

	public function add_option()
	{
		$post_data = $this->input->post();

		$this->add_vehicle_model->add_option($post_data);
	}
}
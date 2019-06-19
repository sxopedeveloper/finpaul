<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('user_main.php');

class Logs extends User_main 
{
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		if($this->session->userdata('logged_in'))
		{
			$data = $this->data;
			$data['title'] = "Logs View";
			/*
			$this->load->library( 'pagination' );
			$total_row = $this->logs_model->get_count();
			
			$config['base_url'] = site_url('logs/index');
				
			$config['num_links'] = 10;
			
			$config['cur_tag_open'] = '<li><a style="color: black; font-weight: bold;">';
			$config['cur_tag_close'] = '</a></li>';
			
			$config['total_rows'] = $total_row;
			$config['per_page'] = 30;
			
			$this->pagination->initialize( $config );
			
			// $data['per_page'] = $config['per_page'];
			$data['total'] = $config['total_rows'];
			$data['logs'] = $this->logs_model->get_paged_results( $config['per_page'], $this->uri->segment(3) );
			*/
			$data['logs'] = $this->logs_model->get_all();
			$this->load->view('admin/logs_view', $data);
		}
		else
		{
			$this->load->helper(array('form'));
			$this->load->view('login');
		}
	}
}
?>
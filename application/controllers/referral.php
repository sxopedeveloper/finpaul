<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('admin_main.php');

class Referral extends Admin_main 
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		header("Location: " . site_url('referral/list_view'));
		exit();
	}

	public function list_view()
	{
		$this->load->model('fapplication_model');

		$data = $this->data;
		$data['title'] = 'Referrals';

		$data['referrals'] = $this->user_model->get_all_referrals_admin();
		$data['makes']     = $this->fapplication_model->get_dropdown_data(array("code"=>1));

		$this->load->view('admin/referrals', $data);
	}
}
	
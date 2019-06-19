<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('admin_main.php');

class Account_transaction extends Admin_main
{
	public function __construct()
	{
	    ob_start();
		parent::__construct();

		$this->load->model("account_transaction_model");
	}

	public function index ()
	{
		$data = $this->data;
		$data['title'] = 'Account Transactions';
		$data['transactions'] = $this->account_transaction_model->get_all_account_transactions();
		$this->load->view('admin/account_transactions', $data);
	}
}
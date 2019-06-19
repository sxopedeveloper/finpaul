<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_transaction_model extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_all_account_transactions()
	{
		$query = "select * from account_transactions";

		return $this->db->query($query)->result_array();
	}
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Squareup_model extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
	}

	public function insert_squareup_transaction($data)
	{
		$insert_data = [
			'transaction_id' => $data['transaction_id'],
			'idempotencykey' => $data['idempotencykey'],
			'amount'         => $data['amount'],
			'customer_id'    => $data['customer_id'],
			'status'         => $data['status'],
			'created_at'     => date('Y-m-d H:i:s')
		];

		$this->db->insert('squareup_transactions', $insert_data);

		return $this->db->insert_id();
	}

	public function insert_squaerup_error($insert_data)
	{
		$insert_data['created_at'] = date('Y-m-d H:i:s');

		$this->db->insert('squareup_error_logs', $insert_data);
	}
}
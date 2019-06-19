<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Eway_transactions_model extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_trans_type()
	{
		$query = "select * from eway_transaction_type";

		return $this->db->query($query)->result_array();
	}

	public function get_cq_trans_type()
	{
		$query = "select 
				trans_type,
				CASE (trans_type)
					WHEN 1 THEN 'CQ Deal'
					WHEN 2 THEN 'Lead Sales'
				END `trans_text` 
				from eway_transactions group by trans_type";

		return $this->db->query($query)->result_array();
	}

	public function get_all_trans($params = array())
	{
		$where = "";

		if( isset($params['date_from']) || isset($params['date_to']) )
		{
			if( $params['date_from'] != '' )
				$where .= " AND date(et.date_created) >= '{$params['date_from']}' ";
			if( $params['date_to'] != '' )
				$where .= " AND date(et.date_created) <= '{$params['date_to']}' ";
		}

		if( isset($params['name']) )
		{
			if( $params['name'] != 0 )
				$where .= " AND u.id_user = {$params['name']} ";
		}

		if( isset($params['trans_id']) )
		{
			if( $params['trans_id'] != '' )
				$where .= " AND et.trans_id like '%{$params['trans_id']}%' ";
		}

		if( isset($params['cq_trans']) )
		{
			if( $params['cq_trans'] != '0' )
				$where .= " AND et.trans_type = {$params['cq_trans']} ";
		}

		if( isset($params['trans_type']) )
		{
			if( $params['trans_type'] != '0' )
				$where .= " AND t.id = {$params['trans_type']} ";
		}

		$query = "
		select
		u.name as `name`,
		et.trans_id as `trans_id`,
		t.trans_name as `trans_name`,
		CASE (et.trans_type)
			WHEN 1 THEN 'CQ Deal'
			WHEN 2 THEN 'Lead Sales'
		END `trans_text`,
		et.trans_amount as `trans_amount`,
		et.date_created as `date_created`,
		et.auth_code as `auth_code`,
		if(et.`auth_code` = '000000', 'Failed', 'Successful') as `status`
		from eway_transactions et
		join eway_transaction_type t on et.trans_type = t.id
		join users u on et.fk_user = u.id_user where 1  
		{$where}";

		return $this->db->query($query)->result_array();
	}

	public function get_all_users()
	{
		$query = "select * from users";

		return $this->db->query($query)->result_array();
	}

	public function insert_transactions($data)
	{
		$response_array = [
			'status' => FALSE,
			'id' => 0
				];

		if($this->db->insert('eway_transactions', $data))
		{
			$response_array['status'] = TRUE;
			$response_array['id'] = $this->db->insert_id();
		}
		else
		{
			$response_array['status'] = FALSE;
			$response_array['id'] = 0;
		}

		return $response_array;
	}

	public function insert_response_codes($data_array = [])
	{
		$data = [
			'response_codes'  => $data_array['response_codes'],
			'controller'      => $data_array['controller'],
			'transaction_num' => $data_array['transaction_num'],
			'fk_main'         => $data_array['fk_main']
		];

		$this->db->insert('eway_response_codes',$data);
	}
}



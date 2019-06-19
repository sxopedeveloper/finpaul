<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Carsales_Model extends CI_Model {

	public $date_format = "DATE_FORMAT(row_date, '%d/%m/%Y %H:%i:%S')";

	function get_carsales_count ($params)
	{
		$status = isset($params['status']) ? $params['status'] : 0;
		
		if ($status=="") { $status = 0; }
		
		$where = "";
		if ($status <> "") { $where .= " AND status = '".$status."'"; }

		$query = "
		SELECT COUNT(1) AS `cnt`
		FROM carsales_cars 
		WHERE deprecated <> 1
		AND `type` = 'private'
		AND (`price` > 40000 OR `status` <> 0)
		AND SUBSTRING_INDEX(build_date, ' ', -1) >= 2010
		AND SUBSTRING_INDEX(build_date, ' ', 1) IN ('November', 'December') ".$where."";
		return $this->db->query($query)->row_array();
	}

	function get_carsales ($params, $start, $limit)
	{
		$status = isset($params['status']) ? $params['status'] : 0;
		
		if ($status=="") { $status = 0; }
		
		$where = "";
		if ($status <> "") { $where .= " AND status = '".$status."'"; }

		$query = "
		SELECT
		id, clean_url AS `url`, status, `type`, valuation, image_url, name, price, compliance_date, build_date, 
		transmission, `engine`, body_type, odometer, remarks, deleted_date, called_date, 
		DATE(created_at) AS `created_at`
		FROM carsales_cars 
		WHERE deprecated <> 1
		AND `type` = 'private'
		AND (`price` > 40000 OR `status` <> 0)
		AND SUBSTRING_INDEX(build_date, ' ', -1) >= 2010
		AND SUBSTRING_INDEX(build_date, ' ', 1) IN ('November', 'December') ".$where."
		ORDER BY id DESC
		LIMIT ".$start.", ".$limit;
		$sql = $this->db->query($query);
		return $sql->result_array();
	}

	function get_carsales_remarks ($id)
	{
		$query = "SELECT remarks FROM carsales_cars WHERE id = '".$this->db->escape_str($id)."'";
		return $this->db->query($query)->row_array();	
	}
	
	function get_carsales_valuation ($id)
	{
		$query = "SELECT valuation FROM carsales_cars WHERE id = '".$this->db->escape_str($id)."'";
		return $this->db->query($query)->row_array();	
	}	
	
	function update_details ($id, $input_arr)
	{
		$now = date("Y-m-d H:i:s");

		$input_string = "";
		foreach ($input_arr AS $field => $value)
		{
			$input_string .= " ".$field." = '".$this->db->escape_str($value)."', ";
		}
	
		$query = "UPDATE carsales_cars SET ".$input_string." last_updated = '".$now."' WHERE `id` = '".$this->db->escape_str($id)."'";
		$sql = $this->db->query($query);
	}
	
	function update_status ($id, $status)
	{
		$query = "UPDATE carsales_cars SET `status` = '".$this->db->escape_str($status)."' WHERE `id` = '".$this->db->escape_str($id)."'";
		$sql = $this->db->query($query);
	}
}
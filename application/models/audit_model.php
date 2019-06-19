<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Audit_Model extends CI_Model {

	public $date_format = "DATE_FORMAT(row_date, '%d/%m/%Y %H:%i:%S')";

	public function insert_audit_trail ($id_user, $input_arr)
	{

		$now = date("Y-m-d g:i:s");
		$query = "
		INSERT INTO `qm_audit_trail` (`fk_user`, `fk_main`, `action`, `table_name`, `description`, `created_at`)
		VALUES (
			".$id_user.", ".$input_arr['id'].", '".$input_arr['action']."', 
			'".$input_arr['table_name']."', '".$this->db->escape_str($input_arr['description'])."', '".$now."'
		)";
		return $this->db->query($query);
	}
	public function insert_audit_trailinvite ($id_user, $input_arr)
	{
		//return $input_arr; 
		$now = date("Y-m-d g:i:s");
		$query = "
		INSERT INTO `qm_audit_trail` (`fk_user`, `fk_main`, `action`, `table_name`, `description`, `created_at`)
		VALUES (
			".$id_user.", ".$input_arr['id'].", '".$input_arr['action']."', 
			'".$input_arr['table_name']."', '".$this->db->escape_str($input_arr['description'])."', '".$now."'
		)";
		return $this->db->query($query);
	}
	
	public function get_audit_trails ($params)
	{
		$user_id = isset($params['user_id']) ? $params['user_id'] : '';
		$table_name = isset($params['table_name']) ? $params['table_name'] : '';
		$id = isset($params['id']) ? $params['id'] : '';
		
		$opened_lead = isset($params['opened_lead']) ? $params['opened_lead'] : '';
		
		$where = "";
		if ($opened_lead=="") { $where .= " AND at.action <> 29"; }
		if ($user_id <> "" AND $user_id <> 0) { $where .= " AND at.fk_user = '".$this->db->escape_str($user_id)."' "; }
		if ($table_name <> "") { $where .= " AND at.table_name = '".$this->db->escape_str($table_name)."' "; }
		if ($id <> "") { $where .= " AND at.fk_main = '".$this->db->escape_str($id)."' "; }

		$query = "
		SELECT 
		at.id_audit_trail, at.fk_main, at.action, at.table_name, at.description, at.created_at,
		aty.`name` AS `action_text`,
		u.id_user, 
		IF (u.`name` IS NOT NULL, u.`name`, 'Client') AS `user`
		FROM `qm_audit_trail` AS `at`
		JOIN `qm_action_types` AS `aty` ON at.action = aty.id_action_type
		LEFT JOIN `users` AS `u` ON at.fk_user = u.id_user
		WHERE at.deprecated <> 1 ".$where."
		ORDER BY at.id_audit_trail DESC LIMIT 50";
		return $this->db->query($query)->result_array();
	}
}
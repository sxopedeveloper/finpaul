<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Action_Model extends CI_Model {

	public $date_format = "DATE_FORMAT(row_date, '%d/%m/%Y %H:%i:%S')";

	function insert_action ($type, $id, $user_id, $details)
	{
		$now = date("Y-m-d g:i:s");
		return $query = "
		INSERT INTO `actions` (type, id, fk_user, details, created_at)
		VALUES ('".$type."', ".$id.", ".$user_id.", '".$this->db->escape_str($details)."', '".$now."')";
		$sql = $this->db->query($query);	
		return $sql->result();
	}

	function get_actions ($type, $id)
	{
		$query = "
		SELECT id_action, details, ".str_replace('row_date', 'created_at', $this->date_format)." FROM actions
		WHERE type = '".$type."' AND id = ".$lead_id." ORDER BY id_action DESC";
		$sql = $this->db->query($query);
		return $sql->result();
	}	
	
	function get_leads_actions ($params, $my_id, $admin_type, $start, $limit)
	{
		$where = "";
		if ($admin_type <> 2)
		{
			$where .= " AND (ac.fk_user = ".$my_id.") ";
		}

		$query = "
		SELECT 
		ac.id_action, ac.details , ac.created_at,
		CONCAT('QM', LPAD(l.id_lead, 5, '0')) AS `cq_number`,
		l.status,
		CASE (l.status)
			WHEN 0 THEN 'Unallocated'
			WHEN 1 THEN 'Allocated'
			WHEN 2 THEN 'Attempted'
			WHEN 3 THEN 'Tendering'
			WHEN 4 THEN 'Converted to Deal'
			WHEN 5 THEN 'Delivery Pending'
			WHEN 6 THEN 'Delivered'
			WHEN 7 THEN 'Settled'
			WHEN 99 THEN 'Reallocated'
			WHEN 100 THEN 'Deleted'
		END `status_text`,
		u.name AS `quote_specialist`
		FROM actions ac 
		JOIN leads l ON ac.id = l.id_lead
		JOIN users u ON ac.fk_user = u.id_user
		WHERE ac.type = 1 
		".$where." ORDER BY ac.id_action DESC LIMIT ".$start.", ".$limit;
		$sql = $this->db->query($query);
		return $sql->result();
	}

	function get_leads_actions_count ($params, $my_id, $admin_type)
	{
		$where = "";		
		if ($admin_type <> 2) 
		{
			$where .= " AND (ac.fk_user = ".$my_id.") ";
		}
	
		$query = "
		SELECT COUNT(1) AS `cnt` FROM actions ac 
		JOIN leads l ON ac.id = l.id_lead
		JOIN users u ON ac.fk_user = u.id_user
		WHERE 1 ".$where;
		return $this->db->query($query)->row_array();
	}
}
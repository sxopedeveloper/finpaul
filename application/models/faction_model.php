<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Faction_Model extends CI_Model {

	function insert_action ($lead_id, $user_id, $details)
	{
		$now = date("Y-m-d g:i:s");
	
		$query = "
		INSERT INTO finance_lead_actions (fk_lead, fk_user, details, created_at)
		VALUES (".$lead_id.", ".$user_id.", '".$this->db->escape_str($details)."', '".$now."')";
		$sql = $this->db->query($query);
	}
	
	function get_leads_actions ($params, $my_id, $admin_type, $start, $limit)
	{
		$where = "";
		if ($admin_type == 2)
		{
			
		}
		else
		{
			$where .= " AND (la.fk_user = ".$my_id.") ";
		}

		$query = "
		SELECT 
		la.id_lead_action, la.details , la.created_at,
		CONCAT('QM', LPAD(l.id_lead, 5, '0')) AS `cq_number`,
		l.status,
		CASE (l.status)
			WHEN 0 THEN 'Unallocated'
			WHEN 1 THEN 'Allocated'
			WHEN 2 THEN 'Attempted'
			WHEN 100 THEN 'Deleted'
		END `status_text`,
		u.name AS `quote_specialist`
		FROM finance_lead_actions la 
		JOIN finance_leads l ON la.fk_lead = l.id_lead
		JOIN users u ON la.fk_user = u.id_user
		WHERE 1 ".$where." ORDER BY la.id_lead_action DESC LIMIT ".$start.", ".$limit;
		$sql = $this->db->query($query);
		return $sql->result();
	}

	function get_leads_actions_count ($params, $my_id, $admin_type)
	{
		$where = "";		
		if ($admin_type == 2) 
		{
			
		}
		else
		{
			$where .= " AND (la.fk_user = ".$my_id.") ";
		}
	
		$query = "
		SELECT COUNT(1) AS `cnt`
		FROM finance_lead_actions la 
		JOIN finance_leads l ON la.fk_lead = l.id_lead
		JOIN users u ON la.fk_user = u.id_user
		WHERE 1 ".$where;
		return $this->db->query($query)->row_array();
	}

	function get_lead_actions ($lead_id)
	{
		$query = "
		SELECT id_lead_action, details, created_at 
		FROM finance_lead_actions
		WHERE 1 AND fk_lead = ".$lead_id." ORDER BY id_lead_action DESC";
		$sql = $this->db->query($query);
		return $sql->result();
	}
}
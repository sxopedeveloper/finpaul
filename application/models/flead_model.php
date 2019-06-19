<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Flead_Model extends CI_Model {

	function get_leads ($params, $my_id, $admin_type, $start, $limit)
	{
		$status = isset($params['status']) ? $params['status'] : '';
		$name = isset($params['name']) ? $params['name'] : '';
		$email = isset($params['email']) ? $params['email'] : '';
		$phone = isset($params['phone']) ? $params['phone'] : '';
		$mobile = isset($params['mobile']) ? $params['mobile'] : '';
		$state = isset($params['state']) ? $params['state'] : '';
		$postcode = isset($params['postcode']) ? $params['postcode'] : '';

		$where = "";
		if ($status <> "") { $where .= " AND l.status = '".$this->db->escape_str($status)."' "; }
		if ($name <> "") { $where .= " AND l.name LIKE '%".$this->db->escape_str($name)."%' "; }
		if ($email <> "") { $where .= " AND l.email = '".$this->db->escape_str($email)."' "; }
		if ($email <> "") { $where .= " AND l.phone = '".$this->db->escape_str($phone)."' "; }
		if ($phone <> "") { $where .= " AND l.mobile = '".$this->db->escape_str($mobile)."' "; }
		if ($state <> "") { $where .= " AND l.state = '".$this->db->escape_str($state)."' "; }
		if ($state <> "") { $where .= " AND l.postcode = '".$this->db->escape_str($postcode)."' "; }

		if ($admin_type == 2 OR $admin_type == 3 OR $admin_type == 4)
		{
			$user_id = isset($params['user_id']) ? $params['user_id'] : '';
			if ($user_id <> "") { $where .= " AND l.fk_user = '".$this->db->escape_str($user_id)."' "; }
		}
		else
		{
			$where .= " AND l.fk_user = ".$my_id; 
		}

		$query = "
		SELECT l.id_lead, l.fk_user, l.source,
		CONCAT('FQ', LPAD(l.id_lead, 5, '0')) AS `fq_number`,
		l.status,
		CASE (l.status)
			WHEN 0 THEN 'Unallocated'
			WHEN 1 THEN 'Allocated'
			WHEN 2 THEN 'Attempted'
			WHEN 100 THEN 'Deleted'
		END `status_text`,
		u.name AS `quote_specialist`,
		l.name, l.email, l.phone, l.mobile, l.state, l.postcode, l.details, l.assignment_date, l.created_at, l.last_updated
		FROM finance_leads l
		LEFT JOIN users u ON l.fk_user = u.id_user
		WHERE l.deprecated <> 1
		".$where."
		ORDER BY l.id_lead DESC LIMIT ".$start.", ".$limit;
		$sql = $this->db->query($query);
		return $sql->result();
	}
	
	function get_leads_count ($params, $my_id, $admin_type)
	{
		$status = isset($params['status']) ? $params['status'] : '';
		$name = isset($params['name']) ? $params['name'] : '';
		$email = isset($params['email']) ? $params['email'] : '';
		$phone = isset($params['phone']) ? $params['phone'] : '';
		$mobile = isset($params['mobile']) ? $params['mobile'] : '';
		$state = isset($params['state']) ? $params['state'] : '';
		$postcode = isset($params['postcode']) ? $params['postcode'] : '';

		$where = "";
		if ($status <> "") { $where .= " AND l.status = '".$this->db->escape_str($status)."' "; }
		if ($name <> "") { $where .= " AND l.name LIKE '%".$this->db->escape_str($name)."%' "; }
		if ($email <> "") { $where .= " AND l.email = '".$this->db->escape_str($email)."' "; }
		if ($email <> "") { $where .= " AND l.phone = '".$this->db->escape_str($phone)."' "; }
		if ($phone <> "") { $where .= " AND l.mobile = '".$this->db->escape_str($mobile)."' "; }
		if ($state <> "") { $where .= " AND l.state = '".$this->db->escape_str($state)."' "; }
		if ($state <> "") { $where .= " AND l.postcode = '".$this->db->escape_str($postcode)."' "; }

		if ($admin_type == 2 OR $admin_type == 3 OR $admin_type == 4)
		{
			$user_id = isset($params['user_id']) ? $params['user_id'] : '';
			if ($user_id <> "") { $where .= " AND l.fk_user = '".$this->db->escape_str($user_id)."' "; }
		}
		else
		{
			$where .= " AND l.fk_user = ".$my_id; 
		}
	
		$query = "
		SELECT COUNT(1) AS cnt FROM finance_leads l WHERE l.deprecated <> 1 ".$where."";
		return $this->db->query($query)->row_array();
	}

	function get_leads_mycalendar ($status_ids, $my_id, $admin_type)
	{
		$now = date("Y-m-d H:i:s");
		
		$where = "";
		if ($admin_type == 2)
		{
			$user_id = isset($params['user_id']) ? $params['user_id'] : '';
			if ($user_id <> "" AND $user_id <> 0) 
			{
				$where .= " AND l.fk_user = '".$this->db->escape_str($user_id)."' ";
			}
			else
			{
				$where .= " AND l.fk_user = ".$my_id;
			}
		}
		else
		{
			$where .= " AND l.fk_user = ".$my_id;
		}
		
		$where .= " AND l.status IN (".$status_ids." '9999')";
		
		$query = "
		SELECT l.id_lead, l.fk_user, l.source,
		CONCAT('FQ', LPAD(l.id_lead, 5, '0')) AS `fq_number`,
		l.status,		
		CASE (l.status)
			WHEN 0 THEN 'Unallocated'
			WHEN 1 THEN 'Allocated'
			WHEN 2 THEN 'Attempted'
			WHEN 100 THEN 'Deleted'
		END `status_text`,
		u.name AS `quote_specialist`,
		l.name, l.email, l.phone, l.mobile, l.state, l.postcode, l.details,
		IF (DATE(l.assignment_date) = '0000-00-00' OR DATE(l.assignment_date) = '', 
			IF (DATE(l.allocated_date) = '0000-00-00' OR DATE(l.allocated_date) = '',
				DATE(l.allocated_date), DATE('".$now."')
			), 
			DATE(l.assignment_date)
		)
		AS assignment_date,
		l.created_at, l.last_updated
		FROM finance_leads l
		LEFT JOIN users u ON l.fk_user = u.id_user
		WHERE l.deprecated <> 1
		".$where."
		ORDER BY l.id_lead ASC";
		$sql = $this->db->query($query);
		return $sql->result();
	}	
	
	function get_qs_leads ($user_id, $status_id) //
	{
		$now = date("Y-m-d H:i:s");

		if ($status_id == 'all')
		{
			$status_where = "";
		}
		else
		{
			$status_where = " AND l.status = '" . $status_id . "'";
		}
		
		$query = "
		SELECT l.id_lead, l.fk_user, l.source,
		CONCAT('FQ', LPAD(l.id_lead, 5, '0')) AS `fq_number`,
		l.status,		
		CASE (l.status)
			WHEN 0 THEN 'Unallocated'
			WHEN 1 THEN 'Allocated'
			WHEN 2 THEN 'Attempted'
			WHEN 100 THEN 'Deleted'
		END `status_text`,
		u.name AS `quote_specialist`,
		l.name, l.email, l.phone, l.mobile, l.state, l.postcode, l.details,
		IF (DATE(l.assignment_date) = '0000-00-00' OR DATE(l.assignment_date) = '', 
			IF (DATE(l.allocated_date) = '0000-00-00' OR DATE(l.allocated_date) = '',
				DATE(l.allocated_date), DATE('".$now."')
			), 
			DATE(l.assignment_date)
		)
		AS assignment_date,
		l.created_at, l.last_updated
		FROM finance_leads l
		LEFT JOIN users u ON l.fk_user = u.id_user
		WHERE l.deprecated <> 1 AND l.status NOT IN (5, 6, 7, 98, 100)
		".$status_where." AND l.fk_user = ".$user_id."
		ORDER BY l.id_lead ASC";
		$sql = $this->db->query($query);
		return $sql->result();
	}
	
	function get_lead_email ($lead_id, $email_type) //
	{
		$query = "
		SELECT DATE(created_at) as `created_at` FROM actions 
		WHERE type = 2 AND id = ".$lead_id." AND details = 'Client Email: ".$email_type."' LIMIT 1";
		return $this->db->query($query)->row_array();
	}

	function get_lead_client ($lead_id)
	{
		$query = "SELECT fk_user, name, email FROM finance_leads WHERE id_lead = ".$lead_id;
		return $this->db->query($query)->row_array();
	}
	
	function get_lead_complete ($lead_id) // RECHECK ON WHERE I USE THIS
	{
		$query = "
		SELECT l.id_lead, l.fk_user, l.source,
		CONCAT('FQ', LPAD(l.id_lead, 5, '0')) AS `fq_number`,
		l.status,		
		CASE (l.status)
			WHEN 0 THEN 'Unallocated'
			WHEN 1 THEN 'Allocated'
			WHEN 2 THEN 'Attempted'
			WHEN 100 THEN 'Deleted'
		END `status_text`,		
		l.name, l.email, l.phone, l.mobile, l.state, l.postcode, l.details, l.created_at, l.last_updated,		
		FROM finance_leads l WHERE l.id_lead = ".$lead_id." LIMIT 1";
		return $this->db->query($query)->row_array();
	}
	
	function add_lead ($input_arr)
	{
		$now = date("Y-m-d H:i:s");
		$query = "
		INSERT INTO finance_leads (source, fk_user, status, name, email, phone, state, allocated_date, created_at) VALUES
		(
			'Quote Specialist', 
			".$input_arr['user_id'].",
			1,
			'".$this->db->escape_str($input_arr['name'])."',
			'".$this->db->escape_str($input_arr['email'])."',
			'".$this->db->escape_str($input_arr['phone'])."',
			'".$this->db->escape_str($input_arr['state'])."',
			'".$now."', '".$now."'
		)";
		$sql = $this->db->query($query);
	}	
	
	function delete_lead ($lead_id)
	{
		$query = "UPDATE `finance_leads` SET `deprecated` = 1 WHERE `id_lead` = ".$lead_id;
		$sql = $this->db->query($query);
	}

	function allocate_lead ($lead_id, $user_id)
	{
		$query = "UPDATE `finance_leads` SET `fk_user` = ".$user_id." WHERE `id_lead` = ".$lead_id;
		$sql = $this->db->query($query);		
	}
	
	function update_lead_status ($lead_id, $status)
	{
		$query = "UPDATE `finance_leads` SET `status` = ".$status." WHERE `id_lead` = ".$lead_id;
		$sql = $this->db->query($query);
	}
	
	function update_lead_quote_specialists ($reallocation_ids)
	{
		$query = "
		UPDATE `leads` l
		JOIN finance_lead_reallocations r ON l.id_lead = r.fk_lead
		SET l.`fk_user` = r.`fk_user_to`
		WHERE r.id_lead_reallocation IN (".$reallocation_ids.")";
		$sql = $this->db->query($query);	
	}

	function allocate_leads ($lead_ids, $user_id)
	{
		$query = "UPDATE `finance_leads` SET `fk_user` = ".$user_id." WHERE `id_lead` IN (".str_replace('on', '', str_replace(',on', '', $lead_ids)).")";
		$sql = $this->db->query($query);
	}
	
	function delete_leads ($lead_ids)
	{
		$query = "DELETE FROM `finance_leads` WHERE `id_lead` IN (".str_replace('on', '', str_replace(',on', '', $lead_ids)).")";
		$sql = $this->db->query($query);
	}		
	
	function update_leads_status ($lead_ids, $status)
	{
		$query = "
		UPDATE `finance_leads` SET `status` = ".$status." 
		WHERE `id_lead` IN (".str_replace('on', '', str_replace(',on', '', $lead_ids)).")
		AND `status` < ".$status."";
		$sql = $this->db->query($query);
	}

	function update_lead_date ($lead_id = 1, $date, $date_type)
	{
		if ($date_type=="assignment_date")
		{
			$date = $date . " 00:00:00";
			$where = "";
		}
		else 
		{
			$where = " AND (`".$date_type."` = '0000-00-00 00:00:00' OR `".$date_type."` = '' OR `".$date_type."` IS NULL)";
		}

		$query = "UPDATE `finance_leads` SET `".$date_type."` = '".$date."' WHERE `id_lead` = ".$lead_id." ".$where;
		$sql = $this->db->query($query);
	}

	function update_lead_details ($lead_arr)
	{
		$query = "
		UPDATE `finance_leads` SET 
		name = '".$this->db->escape_str($lead_arr['name'])."',
		email = '".$this->db->escape_str($lead_arr['email'])."',
		phone = '".$this->db->escape_str($lead_arr['phone'])."',
		mobile = '".$this->db->escape_str($lead_arr['mobile'])."',
		address = '".$this->db->escape_str($lead_arr['address'])."',
		details = '".$this->db->escape_str($lead_arr['lead_details'])."'		
		WHERE `id_lead` = ".$lead_arr['id_lead'];
		$sql = $this->db->query($query);
	}
}
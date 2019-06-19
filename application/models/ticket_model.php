<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ticket_Model extends CI_Model {

	function get_tickets_mycalendar ($status_ids, $my_id, $admin_type)
	{
		$now = date("Y-m-d H:i:s");
		$where = "";
		if ($admin_type == 2)
		{
			$user_id = isset($params['user_id']) ? $params['user_id'] : '';
			if ($user_id <> "" AND $user_id <> 0) 
			{
				$where .= " AND t.fk_user_to = '".$this->db->escape_str($user_id)."' ";
			}
			else
			{
				$where .= " AND tr.fk_user = '".$this->db->escape_str($my_id)."' ";
			}
		}
		else
		{
			$where .= " AND tr.fk_user = ".$my_id;
		}

		$where .= " AND t.fk_ticket_status IN (".$status_ids." '9999')";

		$query = "
		SELECT
		t.id_ticket, CONCAT('TN', LPAD(t.id_ticket, 5, '0')) AS `ticket_number`,
		t.name, t.description, t.eta, t.toc,
		CASE (t.priority)
			WHEN 1 THEN 'Urgent'
			WHEN 2 THEN 'High'
			WHEN 3 THEN 'Low'
		END `priority`,		
		a1.name as `assigned_by`, a1.email as `ab_email`,
		ts.id_ticket_status as `id_ticket_status`, ts.name as `ticket_status`, ts.color,
		tt.name as `ticket_type`, m.name as `module`, t.created_at, 
		IF (DATE(t.assignment_date) = '0000-00-00' OR DATE(t.assignment_date < DATE('".$now."')), DATE('".$now."'), DATE(t.assignment_date)) AS assignment_date
		FROM tickets t
		JOIN ticket_types tt ON t.fk_ticket_type = tt.id_ticket_type
		JOIN modules m ON t.fk_module = m.id_module
		JOIN ticket_status ts ON t.fk_ticket_status = ts.id_ticket_status
		JOIN users a1 ON t.fk_user_from = a1.id_user
		JOIN ticket_receivers tr ON  t.id_ticket = tr.fk_ticket
		WHERE t.deprecated <> 1 AND t.fk_user_from <> t.fk_user_to
		".$where." GROUP BY t.id_ticket ORDER BY t.id_ticket ASC";
		$sql = $this->db->query($query);
		return $sql->result();
	}
	
	function get_selfies_mycalendar ($status_ids, $my_id, $admin_type)
	{
		$now = date("Y-m-d H:i:s");
		$where = "";
		if ($admin_type == 2)
		{
			$user_id = isset($params['user_id']) ? $params['user_id'] : '';
			if ($user_id <> "" AND $user_id <> 0) 
			{
				$where .= " AND t.fk_user_to = '".$this->db->escape_str($user_id)."' ";
			}
			else
			{
				$where .= " AND t.fk_user_to = '".$this->db->escape_str($my_id)."' ";
			}
		}
		else
		{
			$where .= " AND t.fk_user_to = ".$my_id;
		}
		
		$where .= " AND t.fk_ticket_status IN (".$status_ids." '9999')";

		$query = "
		SELECT
		t.id_ticket, CONCAT('TN', LPAD(t.id_ticket, 5, '0')) AS `ticket_number`,
		t.name, t.description, t.eta, t.toc,
		CASE (t.priority)
			WHEN 1 THEN 'Urgent'
			WHEN 2 THEN 'High'
			WHEN 3 THEN 'Low'
		END `priority`,		
		a1.name as `assigned_by`, a2.name as `assigned_to`, a1.email as `ab_email`, a2.email as `at_email`,
		ts.id_ticket_status as `id_ticket_status`, ts.name as `ticket_status`, ts.color,
		tt.name as `ticket_type`, m.name as `module`, t.created_at, 
		IF (DATE(t.assignment_date) = '0000-00-00' OR DATE(t.assignment_date < DATE('".$now."')), DATE('".$now."'), DATE(t.assignment_date)) AS assignment_date
		FROM tickets t
		JOIN ticket_types tt ON t.fk_ticket_type = tt.id_ticket_type
		JOIN modules m ON t.fk_module = m.id_module
		JOIN ticket_status ts ON t.fk_ticket_status = ts.id_ticket_status
		JOIN users a1 ON t.fk_user_from = a1.id_user
		JOIN users a2 ON t.fk_user_to = a2.id_user
		WHERE t.deprecated <> 1 AND t.fk_user_from = t.fk_user_to
		".$where." ORDER BY t.id_ticket ASC";
		$sql = $this->db->query($query);
		return $sql->result();
	}	

	function get_users_to ($id_ticket)
	{
		$query = "select 
					u.id_user, u.username, u.name, u.email 
					from ticket_receivers tr
					join users u on tr.fk_user = u.id_user
					where tr.fk_ticket = '{$id_ticket}';";

		return $this->db->query($query)->result_array();
	}

	function get_tickets ($params, $my_id, $admin_type)
	{
		$where = "";
		if ($admin_type == 2)
		{
			$user_from = isset($params['fk_user_from']) ? $params['fk_user_from'] : '';
			if ($user_from <> "") { $where .= " AND t.fk_user_from = '".$this->db->escape_str($user_from)."' "; }

			$user_to = isset($params['fk_user_to']) ? $params['fk_user_to'] : '';
			if ($user_to <> "") { $where .= " AND tr.fk_user = '".$this->db->escape_str($user_to)."' "; }			
		}
		else
		{
			$where .= " AND (t.fk_user_from = ".$my_id." OR tr.fk_user = ".$my_id.") ";
		}
		
		$t_number = isset($params['t_number']) ? $params['t_number'] : '';

		$ticket_status = isset($params['ticket_status']) ? $params['ticket_status'] : '';
		$user_from = isset($params['user_from']) ? $params['user_from'] : '';
		$user_to = isset($params['user_to']) ? $params['user_to'] : '';
		
		$ticket_type = isset($params['ticket_type']) ? $params['ticket_type'] : '';
		$module = isset($params['module']) ? $params['module'] : '';
		$priority = isset($params['priority']) ? $params['priority'] : '';
		
		if ($t_number <> "") { $where .= " AND CONCAT('TN', LPAD(t.id_ticket, 5, '0')) = '".$this->db->escape_str($t_number)."' "; }

		if ($ticket_status <> "") { $where .= " AND t.fk_ticket_status = '".$this->db->escape_str($ticket_status)."' "; }
		if ($user_from <> "") { $where .= " AND t.fk_user_from = '".$this->db->escape_str($user_from)."' "; }
		if ($user_to <> "") { $where .= " AND tr.fk_user = '".$this->db->escape_str($user_to)."' "; }

		if ($ticket_type <> "") { $where .= " AND t.fk_ticket_type = '".$this->db->escape_str($ticket_type)."' "; }
		if ($module <> "") { $where .= " AND t.fk_module = '".$this->db->escape_str($module)."' "; }
		if ($priority <> "") { $where .= " AND t.priority = '".$this->db->escape_str($priority)."' "; }

		$query = "
		SELECT
		t.id_ticket, CONCAT('TN', LPAD(t.id_ticket, 5, '0')) AS `ticket_number`,
		GROUP_CONCAT(a2.name SEPARATOR ', ') AS `assigned_to_names`,
		t.name, t.description, t.eta, 
		CASE (t.priority)
			WHEN 1 THEN 'Urgent'
			WHEN 2 THEN 'High'
			WHEN 3 THEN 'Low'
		END `priority`,
		a1.name as `assigned_by`, a1.email as `ab_email`,
		ts.id_ticket_status as `id_ticket_status`, ts.name as `ticket_status`,
		tt.name as `ticket_type`, m.name as `module`, t.created_at, 
		IF (t.toc = '0' OR t.toc = '', 'NOT SET', t.toc) AS toc,
		IF (DATE(t.assignment_date) = '0000-00-00', 'NOT SET', DATE(t.assignment_date)) AS assignment_date,
		t.fk_user_from as `fk_user_from` 
		FROM tickets t
		JOIN ticket_types tt ON t.fk_ticket_type = tt.id_ticket_type
		JOIN modules m ON t.fk_module = m.id_module
		JOIN ticket_status ts ON t.fk_ticket_status = ts.id_ticket_status
		JOIN users a1 ON t.fk_user_from = a1.id_user
		JOIN ticket_receivers tr ON  t.id_ticket = tr.fk_ticket
		LEFT JOIN users a2 ON tr.fk_user = a2.id_user
		WHERE t.deprecated <> 1 ".$where." GROUP BY t.id_ticket ORDER BY t.id_ticket DESC ";
		$sql = $this->db->query($query);
		return $sql->result();
	}
	
	function get_ticket ($ticket_id)
	{

		$query = "
		SELECT t.id_ticket, CONCAT('TN', LPAD(t.id_ticket, 5, '0')) AS `ticket_number`, a1.id_user as `user_id_from`, GROUP_CONCAT(a2.id_user SEPARATOR ',') AS `id_to`,
		t.fk_ticket_type as `ticket_type`, t.fk_module as `module`, t.priority as `priority`, t.assignment_date as `assignment_date`, t.description as `description`, t.name as `name`
		FROM tickets t
		JOIN users a1 ON t.fk_user_from = a1.id_user
		JOIN ticket_receivers tr ON  t.id_ticket = tr.fk_ticket
		LEFT JOIN users a2 ON tr.fk_user = a2.id_user
		WHERE t.id_ticket = ".$ticket_id;
		return $this->db->query($query)->row_array();
	}

	function get_this_month_urgent_tickets ($user_id)
	{
		$current_month = date('m');
		$query = "
		SELECT COUNT(1) AS `cnt` FROM tickets 
		WHERE fk_user_to = ".$user_id." AND priority = 1
		AND (MONTH(assignment_date) = '".$current_month."' OR assignment_date = '0000-00-00 00:00:00')";
		return $this->db->query($query)->row_array();
	}
	
	function get_ticket_status ()
	{
		$query = "SELECT * FROM ticket_status WHERE deprecated <> 1";
		$sql = $this->db->query($query);
		return $sql->result();
	}
	
	function get_ticket_types ()
	{
		$query = "SELECT * FROM ticket_types WHERE deprecated <> 1";
		$sql = $this->db->query($query);
		return $sql->result();
	}
	
	function get_modules ()
	{
		$query = "SELECT * FROM modules WHERE deprecated <> 1";
		$sql = $this->db->query($query);
		return $sql->result();
	}	
	
	function add_ticket ($input_arr)
	{
		$now = date("Y-m-d H:i:s");
		$query = "
		INSERT INTO tickets (fk_ticket_status, fk_user_from, fk_ticket_type, fk_module, name, description, priority, assignment_date, created_at) VALUES
		(1, 
		".$input_arr['user_id_from'].",
		".$input_arr['ticket_type'].",
		".$input_arr['module'].",
		'".$this->db->escape_str($input_arr['name'])."',
		'".$this->db->escape_str($input_arr['description'])."',
		'".$this->db->escape_str($input_arr['priority'])."',
		'".$this->db->escape_str($input_arr['assignment_date'])."',
		'".$now."')";
		$sql = $this->db->query($query);

		$insert_id = $this->db->insert_id();

		foreach ($input_arr['user_id_to'] as $user_key => $user_val) 
		{
			$receivers_data = [
				'fk_ticket'  => $insert_id,
				'fk_user'    => $user_val,
				'created_at' => $now
			];

			$this->db->insert('ticket_receivers', $receivers_data);
		}

		return $insert_id;
	}

	function add_ticket_comment ($input_arr)
	{
		$now = date("Y-m-d H:i:s");
		$query = "
		INSERT INTO ticket_comments (fk_ticket, fk_user, comment, created_at) VALUES
		(".$input_arr['ticket_id'].",
		".$input_arr['user_id'].",
		'".$this->db->escape_str($input_arr['ticket_comment'])."',
		'".$now."')";
		$sql = $this->db->query($query);	
	}
	
	function update_ticket_assignment_date ($ticket_id, $date)
	{
		$query = "UPDATE `tickets` SET `assignment_date` = '".$date."' WHERE `id_ticket` = ".$ticket_id;
		$sql = $this->db->query($query);
	}
	
	function update_ticket_toc ($input_arr)
	{
		$query = "UPDATE `tickets` SET `toc` = '".$input_arr['toc']."' WHERE `id_ticket` = ".$input_arr['ticket_id'];
		$sql = $this->db->query($query);
	}	
	
	function update_ticket_status ($ticket_id, $status_id)
	{
		$query = "UPDATE `tickets` SET `fk_ticket_status` = '".$status_id."' WHERE `id_ticket` = ".$ticket_id;
		$sql = $this->db->query($query);	
	}

	function update_ticket($data)
	{
		$this->db->where("id_ticket", $data['ticket_id']);

		$update_data = [
			'fk_ticket_type'  => $data['ticket_type'],
			'priority'        => $data['priority'],
			'fk_module'       => $data['module'],
			'name'            => $data['name'],
			'assignment_date' => $data['assignment_date'],
			'description'     => $data['description']
		];

		$this->db->update('tickets', $update_data);
	}
}
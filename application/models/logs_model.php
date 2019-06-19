<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logs_Model extends CI_Model {
	
	function get_all()
	{
		$this->db->order_by('ID', 'DESC');
		$query = $this->db->get('logs');

		return $query->result_array();
	}

	function insert_log ($username, $ip_address, $description, $location, $date_created, $last_updated, $type, $status)
	{	
		$new_log = array(
			'username' => $username,
			'ip_address' => $ip_address,
			'description' => $description,
			'location' => trim( $location ),
			'date_created' => $date_created,
			'last_updated' => $last_updated,
			'type' => $type,
			'status' => $status
		);
		
		return $this->db->insert('logs', $new_log);
	}
	
	function get_paged_results ($limit, $offset)
	{	
		$this->db->order_by('ID', 'DESC');	
		$this->db->limit($limit, $offset);
        $query = $this->db->get('logs');
        if ($query->num_rows() > 0)
		{	
            return $query->result();
		}
	}
	
	function search ($search)
	{	
		// $this->db->limit(1);
		$this->db->order_by('ID', 'DESC');	
		$this->db->like('username', $search, 'both'); 
		$this->db->or_like('ip_address', $search, 'both');
		$this->db->or_like('location', $search, 'both');
		$query = $this->db->get('logs');
		return $query->result();
	}
	
	function get_count()
	{	
		$query = $this->db->get('logs');
		if ($query->num_rows() > 0)
		{	
			return $query->num_rows();	
		}
		else 
		{	
			return 0;	
		}
	}
}



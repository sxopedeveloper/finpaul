<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Model extends CI_Model {

	public $date_format = "DATE_FORMAT(row_date, '%d/%m/%Y %H:%i:%S')";

	public function login($username, $password)
	{
		$this->db->select('id_user, username, password, name, type');
		$this->db->where('username', $username);
		$this->db->where('password', MD5($password));
		$this->db->where('deprecated', 0);
		$this->db->limit(1);
		$query = $this->db->get('admin');
		if($query->num_rows() == 1)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	public function check_password($password, $user_id)
	{
		$this->db->select('password');
		$this->db->where('id_user', $user_id);
		$this->db->where('password', MD5($password));
		$this->db->where('deprecated', 0);
		$this->db->limit(1);
		$query = $this->db->get('admin');
		if($query->num_rows() == 1)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}	
	
	public function check_username_availability($username)
	{
		$this->db->select('username');
		$this->db->where('username', $username);
		$this->db->limit(1);
		$query = $this->db->get('admin');
		if($query->num_rows() == 1)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}
	
	public function get_user_password($user_id)
	{
		$query = "SELECT `password` FROM `admin` WHERE `id_user` = ".$user_id."";
		return $this->db->query($query)->row_array();
	}

	public function update_profile($user_id, $name, $phone)
	{
		$query = "
		UPDATE `admin` SET
		name = '".$this->db->escape_str($name)."',
		phone = '".$this->db->escape_str($phone)."'
		WHERE `id_user` = '".$user_id."'";
		$sql = $this->db->query($query);
	}	
	
	public function update_password($user_id, $password)
	{
		$query = "UPDATE `admin` SET `password` = '".$this->db->escape_str($password)."' WHERE `id_user` = '".$user_id."'";
		$sql = $this->db->query($query);
	}
	
	public function get_admins ($user_id = 0)
	{
		$query = "
		SELECT * FROM admin 
		WHERE id_user <> ".$user_id."
		AND deprecated <> 1
		ORDER BY name ASC";
		$sql = $this->db->query($query);
		return $sql->result();
	}
	
	public function get_admin ($user_id)
	{
		$query = "SELECT * FROM admin WHERE id_user = ".$user_id;
		return $this->db->query($query)->row_array();		
	}
}
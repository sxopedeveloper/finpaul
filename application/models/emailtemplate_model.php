<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Emailtemplate_Model extends CI_Model {

	public $date_format = "DATE_FORMAT(row_date, '%d/%m/%Y %H:%i:%S')";

	function get_email_templates ()
	{
		$query = "SELECT * FROM email_templates ORDER BY id_email_template ASC";
		$sql = $this->db->query($query);
		return $sql->result();
	}

	function get_email_templates_count ()
	{
		$query = "SELECT COUNT(1) AS `cnt` FROM email_templates";
		return $this->db->query($query)->row_array();
	}	
	
	function get_email_template ($email_template_id)
	{
		$query = "SELECT * FROM email_templates WHERE id_email_template = ".$email_template_id;
		return $this->db->query($query)->row_array();
	}

	function insert_email_template ($input_arr)
	{
		$now = date("Y-m-d H:i:s");

		$query = "
		INSERT INTO email_templates (description, subject, eq_function, content, attachment, created_at) VALUES
		(
			'".$this->db->escape_str($input_arr['email_description'])."',
			'".$this->db->escape_str($input_arr['email_subject'])."',
			'".$this->db->escape_str($input_arr['email_function'])."',
			'".$this->db->escape_str($input_arr['email_content'])."',
			'".$this->db->escape_str($input_arr['email_attachment'])."',
			'".$now."'
		)";
		$sql = $this->db->query($query);		
	}	

	function update_email_template ($input_arr)
	{
		$query = "
		UPDATE email_templates SET 
		description = '".$this->db->escape_str($input_arr['email_description'])."',
		subject = '".$this->db->escape_str($input_arr['email_subject'])."',
		eq_function = '".$this->db->escape_str($input_arr['email_function'])."',
		content = '".$this->db->escape_str($input_arr['email_content'])."',
		attachment = '".$this->db->escape_str($input_arr['email_attachment'])."'
		WHERE id_email_template = '".$this->db->escape_str($input_arr['email_template_id'])."'";
		$sql = $this->db->query($query);		
	}

	function update_email_template_new ($input_arr)
	{
		//echo "<pre>";print_r($this->db->escape_str($input_arr['email_content']));exit();
		$data = array(
            'content' => $input_arr['email_content'],
        );
		$this->db->where('id_email_template', $this->db->escape_str($input_arr['email_template_id']));
		$this->db->update('email_template', $data); 
		echo $this->db->last_query();	
	}
	
}
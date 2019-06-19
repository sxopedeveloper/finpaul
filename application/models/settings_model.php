<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings_Model extends CI_Model {

	public function get_settings ($company_id)
	{	
		$query = "SELECT * FROM company_settings WHERE 1 AND deprecated <> 1 AND id_company_setting = ".$company_id;
		return $this->db->query($query)->row_array();
	}

	public function get_email_template ($email_template_id)
	{	
		$query = "SELECT * FROM email_templates WHERE 1 AND deprecated <> 1 AND id_email_template = ".$email_template_id;
		return $this->db->query($query)->row_array();
	}
	
	public function get_bank_accounts()
	{
		$query = "SELECT * FROM bank_accounts WHERE deprecated <> 1";
		return $this->db->query($query)->result();
	}	
}
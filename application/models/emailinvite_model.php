<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Emailinvite_Model extends CI_Model {

	public $date_format = "DATE_FORMAT(row_date, '%d/%m/%Y %H:%i:%S')";

	function insert_email_invite ($quote_request_id, $email)
	{
		$now = date("Y-m-d g:i:s");
		$query = "
		INSERT INTO `email_invites` (fk_quote_request, email, created_at)
		VALUES ('".$this->db->escape_str($quote_request_id)."', '".$this->db->escape_str($email)."', '".$now."')";
		return $this->db->query($query);
	}

	function get_email_invites ($fk_quote_request)
	{
		$query = "
		SELECT * FROM `email_invites` WHERE 1 AND fk_quote_request = ".$fk_quote_request."";
		return $this->db->query($query);
	}
}
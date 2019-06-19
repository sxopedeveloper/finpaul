<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tradeinrecipient_Model extends CI_Model {

	function insert_tradein_recipient ($tradein_id, $email)
	{
		$now = date("Y-m-d g:i:s");
		$query = "
		INSERT INTO `tradein_recipients` (fk_tradein, email, created_at) VALUES ('".$this->db->escape_str($tradein_id)."', '".$this->db->escape_str($email)."', '".$now."')";
		$sql = $this->db->query($query);
	}

	function get_tradein_recipients ($tradein_id)
	{
		$query = "SELECT * FROM `tradein_recipients` WHERE 1 AND fk_tradein = ".$tradein_id."";
		$sql = $this->db->query($query);
		return $sql->result();
	}
}
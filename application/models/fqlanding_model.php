<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fqlanding_Model extends CI_Model {

	function get_landing_pages ($params, $start, $limit)
	{
		$where = "";

		$query = "
		SELECT * FROM fq_landing_pages lp WHERE lp.deprecated <> 1
		".$where."
		ORDER BY lp.id_fq_landing_page DESC LIMIT ".$start.", ".$limit;
		$sql = $this->db->query($query);
		return $sql->result();
	}
	
	function get_landing_pages_count ($params)
	{
		$where = "";
	
		$query = "
		SELECT COUNT(1) AS cnt FROM fq_landing_pages lp WHERE lp.deprecated <> 1 ".$where."";
		return $this->db->query($query)->row_array();
	}
	
	function update_fq_lp ($lp_arr)
	{
		$query = "
		UPDATE `fq_landing_pages` SET
		title = '".$this->db->escape_str($lp_arr['title'])."',
		subtitle = '".$this->db->escape_str($lp_arr['subtitle'])."',
		root = '".$this->db->escape_str($lp_arr['root'])."',
		website_url = '".$this->db->escape_str($lp_arr['website_url'])."',
		content = '".$this->db->escape_str($lp_arr['content'])."'
		WHERE `id_fq_landing_page` = ".$lp_arr['lp_id'];
		$sql = $this->db->query($query);	
	}
}
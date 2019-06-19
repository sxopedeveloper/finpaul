<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cqlanding_Model extends CI_Model {

	public $date_format = "DATE_FORMAT(row_date, '%d/%m/%Y %H:%i:%S')";

	function get_landing_pages ($params, $start, $limit)
	{
		$where = "";
		$query = "
		SELECT * FROM landing_pages cp WHERE cp.deprecated <> 1
		".$where."
		ORDER BY cp.id_landing_page DESC LIMIT ".$start.", ".$limit;
		$sql = $this->db->query($query);
		return $sql->result();
	}
	
	function get_landing_pages_count ($params)
	{
		$where = "";
		$query = "
		SELECT COUNT(1) AS cnt FROM landing_pages cp WHERE cp.deprecated <> 1 ".$where."";
		return $this->db->query($query)->row_array();
	}
	
	function update_cp_lp ($lp_arr)
	{
		$query = "
		UPDATE `landing_pages` SET
		root = '".$this->db->escape_str($lp_arr['root'])."',
		website_url = '".$this->db->escape_str($lp_arr['website_url'])."',
		make = '".$this->db->escape_str($lp_arr['make'])."',
		model = '".$this->db->escape_str($lp_arr['model'])."',
		img = '".$this->db->escape_str($lp_arr['img'])."',
		main_color = '".$this->db->escape_str($lp_arr['main_color'])."',
		hex_color = REPLACE('".$this->db->escape_str($lp_arr['main_color'])."', '#', ''),
		get_quotes_size = '".$this->db->escape_str($lp_arr['get_quotes_size'])."',
		bing = '".$this->db->escape_str($lp_arr['bing'])."',
		google_analytics = '".$this->db->escape_str($lp_arr['google_analytics'])."',
		google_conversion_id = '".$this->db->escape_str($lp_arr['google_conversion_id'])."',
		google_conversion_label = '".$this->db->escape_str($lp_arr['google_conversion_label'])."',
		content = '".$this->db->escape_str($lp_arr['content'])."'
		WHERE `id_landing_page` = ".$lp_arr['lp_id'];
		$sql = $this->db->query($query);	
	}	
}
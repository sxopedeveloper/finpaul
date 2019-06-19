<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Car_Model extends CI_Model {

	public $date_format = "DATE_FORMAT(row_date, '%d/%m/%Y %H:%i:%S')";

	public function get_brands ()
	{
		$query = "
		SELECT id_brand, name, landing_page_url, image_url FROM brands ORDER BY name ASC";
		$sql = $this->db->query($query);
		return $sql->result();
	}

	public function get_models ($brand_id)
	{
		$this->db->select('id_model, name');
		$this->db->from('models');
		$this->db->where('fk_brand', $brand_id);
		$this->db->order_by('name', 'asc');
		$query=$this->db->get();
		return $query;
	}

	public function get_quotes_by_lead_id($lead_id)
	{
		$query = "SELECT * FROM quote_requests WHERE fk_lead=".$lead_id;
		return $this->db->query($query)->row_array();	
	}

	public function get_quotes_id($lead_id)
	{
		$query = "SELECT id_quote_request FROM quote_requests WHERE fk_lead=".$lead_id;
		return $this->db->query($query)->row_array();
	}

	public function get_accessories($quote_id)
	{
		$query = "SELECT name FROM quote_request_accessories WHERE fk_quote_request=".$quote_id;
		return $this->db->query($query)->result_array();
	}
	
	// NEW CAR STRUCTURE //
	public function get_makes ()
	{
		$query = "
		SELECT id_make, code, name FROM makes WHERE deprecated <> 1 ORDER BY name ASC";
		$sql = $this->db->query($query);
		return $sql->result();
	}
	
	public function get_families ($make_id)
	{
		$query = "
		SELECT id_family, code, name, latest_year FROM families 
		WHERE deprecated <> 1 AND fk_make = ".$make_id."
		ORDER BY name ASC";
		$sql = $this->db->query($query);
		return $sql->result();
	}
	
	public function get_family ($family_id)
	{
		$query = "
		SELECT m.name as `make`, f.name as `family`
		FROM families f JOIN makes m ON f.fk_make = m.id_make
		WHERE f.id_family = ".$family_id;
		return $this->db->query($query)->row_array();
	}

	public function get_build_dates ($family_id)
	{
		$query = "SELECT MD5(CONCAT(fk_family, '-', year)) AS `code`, year FROM vehicles WHERE deprecated <> 1 AND fk_family = ".$family_id." GROUP BY year ORDER BY year DESC";
		$sql = $this->db->query($query);
		return $sql->result();
	}	
    
    public function get_build_dates_rb ($family_id)
	{
		$query = "SELECT MD5(CONCAT(fk_family, '-', year)) AS `code`, year FROM vehicles WHERE deprecated <> 1 AND fk_family = ".$family_id." GROUP BY year ORDER BY year DESC";
		$sql = $this->db->query($query);
		return $sql->result();
	}	
	
	public function get_vehicles ($code)
	{
		$query = "
		SELECT id_vehicle, code, name FROM vehicles
		WHERE deprecated <> 1 AND MD5(CONCAT(fk_family, '-', year)) = '".md5($code)."'
		ORDER BY name ASC";
		$sql = $this->db->query($query);
		return $sql->result();
	}
	
	public function get_options ($vehicle_id)
	{
		$query = "
		SELECT id_option, code, name, items, adddeduct, newprice FROM options 
		WHERE deprecated <> 1 AND fk_vehicle = ".$vehicle_id."
		ORDER BY name ASC";
		$sql = $this->db->query($query);
		return $sql->result();	
	}
	
	public function get_standards ($vehicle_id)
	{
		$query = "
		SELECT id_standard, code, name FROM options 
		WHERE deprecated <> 1 AND fk_vehicle = ".$vehicle_id."
		ORDER BY name ASC";
		$sql = $this->db->query($query);
		return $sql->result();	
	}

	public function get_vehicle ($vehicle_id)
	{
		$query = "SELECT * FROM vehicles v WHERE deprecated <> 1 AND id_vehicle = ".$vehicle_id."";
		return $this->db->query($query)->row_array();
	}
}
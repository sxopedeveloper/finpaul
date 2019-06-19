<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Add_vehicle_model extends CI_Model 
{

	public function __construct()
	{
		parent::__construct();
	}

	public function add_make($params)
	{
		$count = 0;
		$select_query = "SELECT * FROM makes WHERE code LIKE '%CQMA%'";
		$count = $this->db->query($select_query)->num_rows();
		$data = [
			'code' => "CQMA" . (string)($count + 1),
			'name' => $params['make_name']
		];
		$this->db->insert('makes', $data);
	}

	public function add_model($params)
	{
		$count = 0;
		$select_query = "SELECT * FROM families WHERE code LIKE '%CQFA%'";
		$count = $this->db->query($select_query)->num_rows();
		$data = [
			'fk_vehicle_type' => $params['fk_vehicle_type'],
			'fk_make'         => $params['fk_make'],
			'code'            => "CQFA" . (string)($count + 1),
			'name'            => $params['model_name'],
			'latest_year'     => $params['latest_year']
		];
		$this->db->insert('families', $data);
	}

	public function add_vehicles($params)
	{
		$count = 0;
		$select_query = "select * from vehicles where code like '%CQVE%'";
		$count = $this->db->query($select_query)->num_rows();
		$data = [
			'fk_family'    => $params['fk_family'],
			'code'         => "CQVE" . (string)($count + 1),
			'name'         => $params['vehicle_name'],
			'year'         => $params['vehicle_year'],
			'series'       => $params['series'],
			'bodystyle'    => $params['bodystyle'],
			'transmission' => $params['transmission'],
			'fueltype'     => $params['fueltype'],
			'newprice'     => $params['newprice']
		];
		$this->db->insert('vehicles', $data);
	}

	public function add_option($params)
	{
		$count = 0;
		$select_query = "select * from options where code like '%CQOP%'";
		$count = $this->db->query($select_query)->num_rows();
		$data = [
			'fk_vehicle' => $params['fk_vehicle'],
			'code'       => "CQOP" . (string)($count + 1),
			'name'       => $params['option_name'],
			'items'      => $params['option_items'],
			'adddeduct'  => $params['adddeduct'],
			'newprice'   => $params['option_newprice']
		];
		$this->db->insert('options', $data);
	}

	public function get_dropdown_data($code, $id = 0)
	{		
		if($code == 1)
		{
			$make_query = "select * from makes";
			$make_array = $this->db->query($make_query)->result_array();
			return $make_array;
		}
		elseif($code == 2)
		{	
			$families_query = "select * from families";
			$families_array = $this->db->query($families_query)->result_array();
			return $families_array;
		}
		elseif($code == 3)
		{	
			$vehicle_query = "select * from vehicles";
			$vehicles_array = $this->db->query($vehicle_query)->result_array();
			return $vehicles_array;
		}
	}
}
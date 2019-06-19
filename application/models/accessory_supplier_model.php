<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accessory_supplier_model extends CI_Model {

	public $date_format = "DATE_FORMAT(row_date, '%d/%m/%Y %H:%i:%S')";

	function get_accessory_supplier ()
	{
		$query = "SELECT * FROM accessory_suppliers WHERE deprecated <> 1 ORDER BY name ASC";
		return $this->db->query($query)->result_array();
	}

	function insert_new_accessory($insert_data = [])
	{
		$insert_data['created_at'] = date("Y-m-d H:i:s");

		$this->db->insert('accessories', $insert_data);

		return $this->db->insert_id();
	}

	function get_supplier($id_accessory_supplier)
	{
		$query = "select * from accessory_suppliers where id_accessory_supplier = {$id_accessory_supplier}";

		return $this->db->query($query)->row_array();
	}

	function insert_new_supplier($insert_data = [])
	{
		$insert_data['created_at'] = date("Y-m-d H:i:s");

		$this->db->insert('accessory_suppliers', $insert_data);

		return $this->db->insert_id();
	}
}
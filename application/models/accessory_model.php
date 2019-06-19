<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accessory_Model extends CI_Model {

	public $date_format = "DATE_FORMAT(row_date, '%d/%m/%Y %H:%i:%S')";

	function get_accessories ()
	{
		$query = "
		SELECT 
		a.id_accessory, 
		a.code AS `accessory_code`, a.name AS `accessory_name`, a.description AS `accessory_description`,
		a.cost,
		
		as.id_accessory_supplier,
		as.name AS `accessory_supplier_name`
		
		FROM accessories `a`
		JOIN accessory_suppliers `as` ON a.fk_accessory_supplier = as.id_accessory_supplier
		WHERE a.deprecated <> 1
		ORDER BY a.name ASC";
		return $this->db->query($query)->result_array();
	}
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pdf_Model extends CI_Model {

	public $date_format = "DATE_FORMAT(row_date, '%d/%m/%Y %H:%i:%S')";

	public function insert_pdf ($id_user, $input_arr)
	{
		$now = date("Y-m-d g:i:s");
		$query = "
		INSERT INTO `pdfs` (`fk_user`, `fk_main`, `table_name`, `pdf_type`, `path`, `created_at`)
		VALUES (
			".$id_user.", ".$input_arr['id'].", '".$input_arr['table_name']."', 
			'".$input_arr['pdf_type']."', '".$input_arr['path']."', '".$now."'
		)";
		$this->db->query($query);
	}
	
	public function get_pdfs ($id_user, $pdf_type, $id = 0)
	{
		$additional_where = "";
		if ($id_user <> "")
		{
			$additional_where .= " AND p.fk_user = '".$id_user."'";
		}		
		
		if ($pdf_type <> "")
		{
			$additional_where .= " AND p.pdf_type = '".$pdf_type."'";
		}
		
		if ($id <> 0)
		{
			$additional_where .= " AND p.fk_main = '".$id."'";
		}

		$query = "
		SELECT 
		p.id_pdf, p.path, p.table_name, p.pdf_type, p.created_at,
		u.name, u.email
		FROM `pdfs` AS `p`
		JOIN `user` AS `u` ON p.fk_user = u.id_user
		WHERE 1 ".$additional_where." 
		ORDER BY p.id_pdf DESC";
		return $this->db->query($query)->result_array();
	}	
}
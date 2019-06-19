<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comment_Model extends CI_Model {

	function insert_comment ($id, $type, $input_arr)
	{
		$now = date("Y-m-d g:i:s");
		$query = "
		INSERT INTO `comments` (fk_main, fk_user, type, comment, created_at)
		VALUES ('".$id."', ".$input_arr['user_id'].", ".$type.", '".$this->db->escape_str($input_arr['comment'])."', '".$now."')";
		return $this->db->query($query);	
	}
	
	function insert_comment_attachment ($comment_id, $file_name)
	{
		$now = date("Y-m-d g:i:s");
		$query = "
		INSERT INTO `comment_attachments` (fk_comment, file_name, created_at)
		VALUES ('".$comment_id."', '".$this->db->escape_str($file_name)."', '".$now."')";
		return $this->db->query($query);	
	}

	public function insert_file_attachment ($id, $file_name, $user, $type)
	{
		$now = date("Y-m-d g:i:s");
		$data = array(
			'file_name'  => $file_name,
			'fk_main'    => $id,
			'fk_user'    => $user,
			'type'       => $type,
			'created_at' => $now
		);
		$this->db->insert('file_attachments', $data);

		return $this->db->insert_id();
	}
}
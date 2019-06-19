<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification_Model extends CI_Model {

	function get_notifications ($user_id, $type)
	{
		$query = "
		SELECT n.id_notification, nu.id_notification_user, nu.status, nt.icon, n.message, n.created_at
		FROM notifications n
		JOIN notification_types nt ON n.fk_notification_type = nt.id_notification_type
		JOIN notification_users nu ON n.id_notification = nu.fk_notification
		WHERE nu.fk_user = ".$user_id." AND nt.id_notification_type = ".$type." ORDER BY n.id_notification DESC LIMIT 12";
		$sql = $this->db->query($query);
		return $sql->result();
	}
	
	function get_new_notifications ($user_id, $type)
	{
		$query = "
		SELECT n.id_notification, nu.id_notification_user, nt.icon, n.message, n.created_at
		FROM notifications n
		JOIN notification_types nt ON n.fk_notification_type = nt.id_notification_type
		JOIN notification_users nu ON n.id_notification = nu.fk_notification
		WHERE nu.fk_user = ".$user_id." AND nt.id_notification_type = ".$type." AND nu.status = 0";
		$sql = $this->db->query($query);
		return $sql->result();
	}	
	
	function update_notification_status ($notification_user_ids)
	{
		$query = "UPDATE `notification_users` SET `status` = 1 WHERE `id_notification_user` IN (".$notification_user_ids.")";
		$sql = $this->db->query($query);
	}

	function add_notification ($notification_type_id, $message)
	{
		$now = date("Y-m-d H:i:s");
		$query = "INSERT INTO notifications (fk_notification_type, message, created_at) VALUES (".$notification_type_id.", '".$this->db->escape_str($message)."', '".$now."')";
		$sql = $this->db->query($query);
	}

	function add_notification_user ($notification_id, $user_id)
	{
		$now = date("Y-m-d H:i:s");
		$query = "INSERT INTO notification_users (fk_notification, fk_user, status, created_at) VALUES (".$notification_id.", ".$user_id.", 0, '".$now."')";
		$sql = $this->db->query($query);
	}
}
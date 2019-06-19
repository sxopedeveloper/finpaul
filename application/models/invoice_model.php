<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice_model extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_lead_invoices ($lead_id)
	{
		$where = "";
		$query = "
		SELECT 
		i.`id_invoice`, i.`id_invoice` AS `invoice_id`,
		i.`fk_lead`, i.`invoice_number`, i.`invoice_name`, i.`invoice_type`,
		u.name, u.email, fa.lead_name as `client_name`,
		i.`amount`, i.`amount` AS `amount_due`,
		(SELECT COALESCE(SUM(`amount`), 0.00) 
			FROM `invoice_payments` 
			WHERE `fk_invoice` = `invoice_id` AND `deprecated` <> 1
		) AS `amount_paid`,		
		i.details,		
		DATE(i.invoice_date) AS `invoice_date`,
		DATE(i.due_date) AS `due_date`,
		DATE(i.received_date) AS `received_date`,
		DATE(i.promised_date) AS `promised_date`,
		(SELECT IF (`amount_due` > `amount_paid`, 'Unpaid', 'Paid')) AS `paid_status`,
		IF(i.`status`= 1, 'Paid', 'Unpaid') as `status`, #TO BE DELETED	
		i.created_at
		FROM invoices i
		JOIN users u ON i.fk_user = u.id_user
		JOIN fq_accounts_new fa ON i.fk_lead = fa.id_fq_account
		WHERE i.deprecated <> 1 AND i.fk_lead = '".$this->db->escape_str($lead_id)."'";
		return $this->db->query($query)->result_array();
	}	
	
	public function delete_invoice ($invoice_id)
	{
		$query = "UPDATE invoices SET deprecated = 1 WHERE id_invoice = '".$this->db->escape_str($invoice_id)."'";
		return $this->db->query($query);
	}	
	
	public function delete_invoice_item ($invoice_item_id)
	{
		$query = "UPDATE invoice_items SET deprecated = 1 WHERE id_invoice_item = '".$this->db->escape_str($invoice_item_id)."'";
		return $this->db->query($query);
	}	
	
	public function insert_invoice ($user_id, $input_arr)
	{
		$now = date("Y-m-d H:i:s");
		$query = "
		INSERT INTO invoices 
		(
			fk_user, fk_lead, 
			invoice_number, invoice_name, invoice_type, amount,
			invoice_date, due_date, promised_date, 
			details, remarks,
			created_at, status
		)
		VALUES
		(
			'".$this->db->escape_str($user_id)."',
			'".$this->db->escape_str($input_arr['id_lead'])."',
			'".$this->db->escape_str($input_arr['invoice_number'])."',
			'".$this->db->escape_str($input_arr['invoice_name'])."',
			'".$this->db->escape_str($input_arr['invoice_type'])."',
			'".$this->db->escape_str($input_arr['amount'])."',
			'".$this->db->escape_str($input_arr['invoice_date'])."',
			'".$this->db->escape_str($input_arr['due_date'])."',
			'".$this->db->escape_str($input_arr['promised_date'])."',
			'".$this->db->escape_str($input_arr['details'])."',
			'".$this->db->escape_str($input_arr['remarks'])."',
			'".$now."',
			'0'
		)";
		return $this->db->query($query);
	}	

	public function insert_invoice_item ($invoice_id, $input_arr)
	{
		$now = date("Y-m-d H:i:s");
		$query = "
		INSERT INTO invoice_items (fk_invoice, description, amount, created_at)
		VALUES 
		(
			'".$this->db->escape_str($invoice_id)."',
			'".$this->db->escape_str($input_arr['description'])."',
			'".$this->db->escape_str($input_arr['amount'])."',
			'".$now."'
		)";
		return $this->db->query($query);
	}	
	
	
	
	
	
	
	
	
	
	
	public function get_invoices ($lead_id = 0)
	{
		$where = "";
		if ($lead_id <> 0)
		{
			$where .= " AND i.fk_lead = '".$this->db->escape_str($lead_id)."'";
		}

		$query = "
		SELECT 
		i.`id_invoice`, i.`id_invoice` AS `invoice_id`,
		i.`fk_lead`, i.`invoice_number`, i.`invoice_name`, i.`invoice_type`,
		u.name, u.email, l.name as `client_name`,
		i.`amount`, i.`amount` AS `amount_due`,
		(SELECT COALESCE(SUM(`amount`), 0.00) 
			FROM `invoice_payments` 
			WHERE `fk_invoice` = `invoice_id` AND `deprecated` <> 1
		) AS `amount_paid`,		
		i.details,		
		DATE(i.invoice_date) AS `invoice_date`,
		DATE(i.due_date) AS `due_date`,
		DATE(i.received_date) AS `received_date`,
		DATE(i.promised_date) AS `promised_date`,
		(SELECT IF (`amount_due` > `amount_paid`, 'Unpaid', 'Paid')) AS `paid_status`,
		IF(i.`status`= 1, 'Paid', 'Unpaid') as `status`, #TO BE DELETED	
		i.created_at
		FROM invoices i
		JOIN users u ON i.fk_user = u.id_user
		JOIN leads l ON i.fk_lead = l.id_lead
		WHERE i.deprecated <> 1 ".$where;
		return $this->db->query($query)->result_array();
	}

	public function get_payment_invoice ($lead_id = 0)
	{
		$where = "";
		if ($lead_id <> 0)
		{
			$where .= " AND i.fk_lead = '".$this->db->escape_str($lead_id)."'";
		}

		$query = "
		SELECT 
		i.`id_invoice`, i.`id_invoice` AS `invoice_id`,
		i.`fk_lead`, i.`invoice_number`, i.`invoice_name`, i.`invoice_type`,
		u.name, u.email, l.name as `client_name`,
		i.`amount`, i.`amount` AS `amount_due`,
		(SELECT COALESCE(SUM(`amount`), 0.00) 
			FROM `invoice_payments` 
			WHERE `fk_invoice` = `invoice_id` AND `deprecated` <> 1
		) AS `amount_paid`,		
		i.details,		
		DATE(i.invoice_date) AS `invoice_date`,
		DATE(i.due_date) AS `due_date`,
		DATE(i.received_date) AS `received_date`,
		DATE(i.promised_date) AS `promised_date`,
		(SELECT IF (`amount_due` > `amount_paid`, 'Unpaid', 'Paid')) AS `paid_status`,
		IF(i.`status`= 1, 'Paid', 'Unpaid') as `status`, #TO BE DELETED	
		i.created_at, ip.fk_payment as `payment_id`, ip.amount as `ip_amount`, ip.id_invoice_payment as `id_invoice_payment`
		FROM invoices i
		JOIN users u ON i.fk_user = u.id_user
		JOIN leads l ON i.fk_lead = l.id_lead
		LEFT JOIN invoice_payments ip ON fk_invoice = i.id_invoice
		WHERE i.deprecated <> 1 ".$where;
		return $this->db->query($query)->result_array();
	}

	public function get_invoice ($invoice_id)
	{
		$query = "
		SELECT 
		i.`id_invoice`, i.`id_invoice` AS `invoice_id`,
		i.`fk_lead`, i.`invoice_number`, i.`invoice_name`, i.`invoice_type`,
		u.name, u.email, 
		
		l.id_lead,
		CONCAT('QM', LPAD(l.id_lead, 5, '0')) AS `cq_number`,
		l.name AS `client_name`, l.business_name AS `client_business_name`,
		l.email AS `client_email`, l.phone AS `client_phone`, 
		l.state AS `client_state`, l.postcode AS `client_postcode`, l.address AS `client_address`, 
		
		da.dealership_name,
		d.name AS `dealer_name`, d.email AS `dealer_email`, d.phone AS `dealer_phone`, 
		d.state AS `dealer_state`, d.postcode AS `dealer_postcode`, d.address AS `dealer_address`, 		

		i.`amount`, i.`amount` AS `amount_due`,
		(SELECT COALESCE(SUM(`amount`), 0.00) 
			FROM `invoice_payments` 
			WHERE `fk_invoice` = `invoice_id` AND `deprecated` <> 1
		) AS `amount_paid`,		
		i.`details`, i.`remarks`,
		DATE(i.invoice_date) AS `invoice_date`,
		DATE(i.due_date) AS `due_date`,
		DATE(i.received_date) AS `received_date`,
		DATE(i.promised_date) AS `promised_date`,
		(SELECT IF (`amount_due` > `amount_paid`, 'Unpaid', 'Paid')) AS `paid_status`,
		IF(i.`status`= 1, 'Paid', 'Unpaid') as `status`, #TO BE DELETED	
		i.created_at
		FROM invoices i
		JOIN users u ON i.fk_user = u.id_user
		LEFT JOIN `leads` AS `l` ON i.fk_lead = l.id_lead
		LEFT JOIN `quote_requests` AS `qr` ON l.`id_lead` = qr.`fk_lead`
		LEFT JOIN `quotes` AS `q` ON qr.`winner` = q.`id_quote`
		LEFT JOIN `users` AS `d` ON q.`fk_user` = d.`id_user`
		LEFT JOIN `dealer_attributes` AS `da` ON d.`id_user` = da.`fk_user`
		WHERE i.id_invoice = '".$this->db->escape_str($invoice_id)."'";
		return $this->db->query($query)->row_array();
	}

	public function get_invoice_items ($invoice_id)
	{
		$query = "SELECT * FROM invoice_items WHERE deprecated <> 1 AND fk_invoice = '".$this->db->escape_str($invoice_id)."'";
		return $this->db->query($query)->result_array();
	}	
	
	public function update_invoice ($invoice_id, $input_arr)
	{
		$now = date("Y-m-d H:i:s");
		$query = "
		UPDATE invoices SET
			`invoice_number` = '".$this->db->escape_str($input_arr['invoice_number'])."',
			`invoice_name` = '".$this->db->escape_str($input_arr['invoice_name'])."',
			`invoice_type` = '".$this->db->escape_str($input_arr['invoice_type'])."',
			`amount` = '".$this->db->escape_str($input_arr['amount'])."',
			`invoice_date` = '".$this->db->escape_str($input_arr['invoice_date'])."',
			`due_date` = '".$this->db->escape_str($input_arr['due_date'])."',
			`promised_date` = '".$this->db->escape_str($input_arr['promised_date'])."',
			`details` = '".$this->db->escape_str($input_arr['details'])."',
			`remarks` = '".$this->db->escape_str($input_arr['remarks'])."'
		WHERE id_invoice = '".$this->db->escape_str($invoice_id)."'";
		return $this->db->query($query);
	}

	public function update_invoice_item ($invoice_item_id, $input_arr)
	{
		$now = date("Y-m-d H:i:s");
		$query = "
		UPDATE invoice_items SET
			`amount` = '".$this->db->escape_str($input_arr['amount'])."',
			`description` = '".$this->db->escape_str($input_arr['description'])."'
		WHERE id_invoice_item = '".$this->db->escape_str($invoice_item_id)."'";
		return $this->db->query($query);
	}	

	public function get_invoice_sent_emails ($invoice_id)
	{
		$query = "
		SELECT * FROM `invoice_sent_emails`
		WHERE `deprecated` <> 1
		AND `fk_invoice` = '".$this->db->escape_str($invoice_id)."'";
		return $this->db->query($query)->result_array();
	}
	
	public function insert_invoice_sent_email ($user_id, $invoice_id, $input_arr)
	{
		$now = date("Y-m-d H:i:s");
		$query = "
		INSERT INTO invoice_sent_emails 
		(
			fk_invoice, fk_user, email, subject, message, created_at
		)
		VALUES
		(
			'".$this->db->escape_str($invoice_id)."',
			'".$this->db->escape_str($user_id)."',
			'".$this->db->escape_str($input_arr['email'])."',
			'".$this->db->escape_str($input_arr['subject'])."',
			'".$this->db->escape_str($input_arr['message'])."',
			'".$now."'
		)";
		$sql = $this->db->query($query);
	}
}



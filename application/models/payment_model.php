<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_model extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_lead_payments ($lead_id)
	{
		$query = "
		SELECT 
		p.`id_payment`,
		p.`fk_transaction`,
		p.`fk_payment_type`, p.`fk_lead`, p.`fk_user`,
		p.`fk_facility`,
		
		u.`name` AS `user`,
		
		p.`status` as `status`,
		p.`refund_status`, p.`show_status`,
 
		p.`reference_number`, p.`name`, 
		p.`method`, p.credit_card, p.bank_account,
		pt.`code`, pt.`description` AS `payment_type`,
		
		(pt.`sign` * p.`amount`) AS `amount`, p.`admin_fee`, p.`merchant_cost` as `merchant_cost`,

		DATE(p.`payment_date`) AS `payment_date`,
		DATE(p.`received_date`) AS `received_date`,
		DATE(p.`refund_date`) AS `refund_date`,
		
		p.`remarks` as `remarks`,
		
		p.`created_at`, p.`last_updated`
		FROM payments p 
		LEFT JOIN payment_types pt ON p.`fk_payment_type` = pt.`id_payment_type`
		LEFT JOIN users u ON p.`fk_user` = u.`id_user`
		LEFT JOIN payments p2 ON p.`fk_parent` = p2.`id_payment`
		WHERE p.`fk_lead` = '".$lead_id."' AND p.`deprecated` <> 1
		GROUP BY p.`id_payment`";
		return $this->db->query($query)->result_array();
	}		
	
	public function insert_payment ($user_id, $input_arr)
	{
		$now = date("Y-m-d H:i:s");

		$query = "
		INSERT INTO `payments` 
		(
			fk_payment_type, fk_lead, fk_user, status, 
			reference_number, payment_date, 
			method, credit_card, bank_account,
			amount, admin_fee, merchant_cost, 
			remarks, created_at
		)
		VALUES (
			'".$this->db->escape_str($input_arr['fk_payment_type'])."', 
			'".$this->db->escape_str($input_arr['id_lead'])."',
			'".$this->db->escape_str($user_id)."',
			'0',
			'".$this->db->escape_str($input_arr['reference_number'])."',
			'".$this->db->escape_str($input_arr['payment_date'])."',
			'".$this->db->escape_str($input_arr['method'])."',
			'".$this->db->escape_str($input_arr['credit_card'])."',
			'".$this->db->escape_str($input_arr['bank_account'])."',
			'".$this->db->escape_str($input_arr['amount'])."',
			'".$this->db->escape_str($input_arr['admin_fee'])."',
			'".$this->db->escape_str($input_arr['merchant_cost'])."',
			'".$this->db->escape_str($input_arr['remarks'])."',
			'".$now."'
		)";
		
		return $this->db->query($query);
	}	
	
	public function delete_payment ($payment_id)
	{
		$query = "UPDATE payments SET deprecated = 1 WHERE id_payment = '".$this->db->escape_str($payment_id)."'";
		return $this->db->query($query);
	}	

	public function get_payment ($payment_id)
	{
		$query = "
		SELECT 
		p.`id_payment`,
		p.`fk_transaction`,
		p.`fk_payment_type`, p.`fk_lead`, p.`fk_user`,
		p.`fk_facility`,
		
		u.`name` AS `user`,
		
		p.`status` as `status`,
		p.`refund_status`, p.`show_status`,
		
		p.`reference_number`, p.`name`, 
		p.`method`, p.credit_card, p.bank_account,
		pt.`code`, pt.`description` AS `payment_type`, 
		
		pt.`sign`, p.`amount` AS `amount`, p.`admin_fee`, p.`merchant_cost` as `merchant_cost`,
		
		DATE(p.`payment_date`) AS `payment_date`,
		DATE(p.`received_date`) AS `received_date`,
		DATE(p.`refund_date`) AS `refund_date`,
		
		p.`remarks` as `remarks`,
		
		p.`created_at`, p.`last_updated`		
		FROM payments p 
		LEFT JOIN payment_types pt ON p.`fk_payment_type` = pt.`id_payment_type`
		LEFT JOIN users u ON p.`fk_user` = u.`id_user`
		WHERE p.`id_payment` = '".$payment_id."' AND p.`deprecated` <> 1
		GROUP BY p.`id_payment`";
		return $this->db->query($query)->row_array();
	}	

	public function update_payment ($payment_id, $input_arr)
	{
		$now = date("Y-m-d H:i:s");
		
		$query = "
		UPDATE payments SET 
		fk_payment_type = '".$this->db->escape_str($input_arr['fk_payment_type'])."',
		reference_number = '".$this->db->escape_str($input_arr['reference_number'])."',
		payment_date = '".$this->db->escape_str($input_arr['payment_date'])."',
		amount = '".$this->db->escape_str($input_arr['amount'])."',
		admin_fee = '".$this->db->escape_str($input_arr['admin_fee'])."',
		merchant_cost = '".$this->db->escape_str($input_arr['merchant_cost'])."',
		method = '".$this->db->escape_str($input_arr['method'])."',
		credit_card = '".$this->db->escape_str($input_arr['credit_card'])."',
		bank_account = '".$this->db->escape_str($input_arr['bank_account'])."',
		remarks = '".$this->db->escape_str($input_arr['remarks'])."'
		WHERE id_payment = '".$this->db->escape_str($payment_id)."'";
		return $this->db->query($query);		
	}	
	
	public function update_payment_show_status ($payment_id, $input_arr)
	{
		$now = date("Y-m-d H:i:s");
		
		$query = "
		UPDATE payments SET 
		show_status = '".$this->db->escape_str($input_arr['show_status'])."'
		WHERE id_payment = '".$this->db->escape_str($payment_id)."'";
		return $this->db->query($query);		
	}	
	



	

	
	public function get_payments ($lead_id)
	{
		$query = "
		SELECT 
		p.`id_payment`, p.`id_payment` AS `payment_id`,
		p.`status` as `status_id`,
		p.`refund_status`, p.`show_status`,
		p.`fk_payment_type`, p.`fk_lead`, p.`fk_user`, p.`fk_transaction`, 
		p.`reference_number`, p.`name`, 
		p.`method`, p.credit_card, p.bank_account,
		pt.`code`, pt.`description` AS `payment_type`, (pt.`sign` * p.`amount`) AS `amount`, p.`admin_fee`,
		u.`name` AS `user`,
		p.`fk_transaction` AS `transaction_id`,
		DATE(p.`payment_date`) AS `payment_date`,
		DATE(p.`refund_date`) AS `refund_date`,
		p.`created_at`, p.`last_updated`,
		(SELECT COALESCE(SUM(`amount`), 0.00) as `sum` FROM payments WHERE fk_parent = `payment_id`) AS `refunds_total`,
		p2.`reference_number` as `parent_reference_number`, p.`remarks` as `remarks`,p.`merchant_cost` as `merchant_cost`, if(p.`status`=1,'Verified', 'Unverified') as `status`
		FROM payments p 
		LEFT JOIN payment_types pt ON p.`fk_payment_type` = pt.`id_payment_type`
		LEFT JOIN users u ON p.`fk_user` = u.`id_user`
		LEFT JOIN payments p2 ON p.`fk_parent` = p2.`id_payment`
		WHERE p.`fk_lead` = '".$lead_id."' AND p.`deprecated` <> 1
		GROUP BY p.`id_payment`";
		$sql = $this->db->query($query);
		return $sql->result();
	}	

	public function get_deposits ($lead_id)
	{
		$query = "SELECT * FROM payments WHERE `fk_lead` = '".$lead_id."' AND fk_payment_type = 2 AND `deprecated` <> 1";
		return $this->db->query($query)->result_array();	
	}
	
	public function get_refunds ($lead_id)
	{
		$query = "SELECT * FROM payments WHERE `fk_lead` = '".$lead_id."' AND fk_payment_type = 7 AND `deprecated` <> 1";
		return $this->db->query($query)->result_array();	
	}
	
	

	public function get_invoice_payments ($params)
	{
		$where = "";
		if (isset($params['invoice_id']))
		{
			if ($params['invoice_id'] <> "" AND $params['invoice_id'] <> "0")
			{
				$where .= " AND fk_invoice = '".$this->db->escape_str($params['invoice_id'])."' ";
			}
		}
		
		if (isset($params['payment_id']))
		{
			if ($params['payment_id'] <> "" AND $params['payment_id'] <> "0")
			{
				$where .= " AND fk_payment = '".$this->db->escape_str($params['payment_id'])."' ";
			}
		}		

		$query = "
		SELECT 
		ip.`fk_invoice`, ip.`fk_payment`, ip.`fk_user`, ip.`amount`, ip.`created_at`,
		i.`invoice_number`, i.`amount`
		FROM `invoice_payments` ip 
		LEFT JOIN invoices i ON ip.`fk_invoice` = i.`id_invoice`
		LEFT JOIN payments p ON ip.`fk_payment` = p.`id_payment`
		WHERE ip.`deprecated` <> 1 ".$where."
		GROUP BY ip.`id_invoice_payment`";
		$sql = $this->db->query($query);
		return $sql->result();
	}	
	
	public function get_payment_types ()
	{
		$query = "
		SELECT * FROM `payment_types`
		WHERE `deprecated` <> 1 
		ORDER BY `sign` DESC, `id_payment_type` ASC";
		$sql = $this->db->query($query);
		return $sql->result();
	}

	public function verify_payment_status ($params)
	{
		$this->db->where('id_payment', $params['id_payment']);
		$data = ['status' => ($params['status'] == 1) ? "0" : "1"];
		$this->db->update('payments', $data);
	}




	
	public function insert_invoice_payment ($input_arr)
	{
		$now = date("Y-m-d H:i:s");
		$query = "
		INSERT INTO `invoice_payments` (`fk_invoice`, `fk_payment`, `fk_user`, `amount`, `created_at`)
		VALUES (
			'".$this->db->escape_str($input_arr['invoice_number'])."',
			'".$this->db->escape_str($input_arr['payment_id'])."',
			'".$this->db->escape_str($input_arr['user_id'])."',
			'".$this->db->escape_str($input_arr['amount'])."',
			'".$now."'
		)";
		$sql = $this->db->query($query);
	}
	
	
	
	// To check //
	public function get_user ($id)
	{
		return $this->db->get_where('users', array('id_user'=> $id))->row_array();
	}

	public function get_searched_payments($reference, $amount, $created_at)
	{
		if($created_at != "")
		{
			$created_at = date('Y-m-d', strtotime($created_at));
		}

		$where = "";
		if ($reference != "") { $where .= " AND `reference_number` like '%".$reference."%' "; }
		if ($amount != "") { $where .= " AND `amount` = '".$amount."' "; }
		if ($created_at != "") { $where .= " AND date(`created_at`) = '".$created_at."' "; }

		$query = "select * from payments
				where fk_lead = 0 and deprecated = 0 {$where};";

		return $this->db->query($query)->result_array();
	}

	public function attach_payment_to_lead($payment_id, $lead_id)
	{
		$this->db->where('id_payment', $payment_id);

		$update_data = [
			'fk_lead' => $lead_id
		];

		$this->db->update('payments', $update_data);

		$query = "select 
						p.id_payment, p.fk_payment_type, p.fk_lead, p.fk_user, p.fk_transaction, p.fk_parent, p.refund_status, p.show_status, p.reference_number, p.name, p.amount, p.admin_fee,
	p.merchant_cost, p.remarks, date(p.payment_date) as `payment_date`, p.refund_date, pt.id_payment_type, pt.code, pt.sign, pt.description 
				from payments p
				join payment_types pt on p.fk_payment_type = pt.id_payment_type
				where p.id_payment='{$payment_id}'";

		return $this->db->query($query)->row_array();
	}

	public function get_all_payments ($params = [], $my_id = "", $admin_type = "", $start = "", $limit = "")
	{
		$cq_number = isset($params['cq_number']) ? $params['cq_number'] : '';
		$name = isset($params['name']) ? $params['name'] : '';
		$email = isset($params['email']) ? $params['email'] : '';
		$phone = isset($params['phone']) ? $params['phone'] : '';
		$user_id = isset($params['user_id']) ? $params['user_id'] : ''; 

		$state = isset($params['state']) ? $params['state'] : '';
		$postcode = isset($params['postcode']) ? $params['postcode'] : '';
		$address = isset($params['address']) ? $params['address'] : '';
		$lead_flag = isset($params['lead_flag']) ? $params['lead_flag'] : '';

		$where = "";
		if ($cq_number <> "") { $where .= " AND CONCAT('QM', LPAD(p.`fk_lead`, 5, '0')) = '".$this->db->escape_str($cq_number)."' "; }

		if ($admin_type==2 OR $admin_type==5)
		{
			if ($user_id <> "")
			{
				$where .= " AND l.`fk_user` = '".$this->db->escape_str($user_id)."' ";
			}
		}
		else
		{
			$where .= " AND l.`fk_user` = ".$my_id;
		}

		if ($name <> "") { $where .= " AND l.`name` LIKE '%".$this->db->escape_str($name)."%' "; }
		if ($email <> "") { $where .= " AND l.`email` LIKE '%".$this->db->escape_str($email)."%' "; }
		if ($phone <> "") { $where .= " AND l.`phone` LIKE '%".$this->db->escape_str($phone)."%' "; }
		
		if ($state <> "") { $where .= " AND l.`state` = '".$this->db->escape_str($state)."' "; }
		if ($postcode <> "") { $where .= " AND l.`postcode` LIKE '%".$this->db->escape_str($postcode)."%' "; }
		if ($address <> "") { $where .= " AND l.`address` LIKE '%".$this->db->escape_str($address)."%' "; }

		if($lead_flag <> "" and $lead_flag == "1")
		{
			$where .= " AND p.`fk_lead` = 0 ";
		}
		elseif($lead_flag <> "" and $lead_flag == "0")
		{
			$where .= " AND p.`fk_lead` != 0 ";
		}

		$query = "
		SELECT 
		p.`id_payment`, pt.`code` as `code`, (pt.`sign` * p.`amount`) as `amount`, 
		p.`reference_number`, p.`created_at` as created_at, 
		IF (p.fk_user = 0, 'Automated', u.`name`) AS `name`,
		p.`fk_transaction` as `trans_id`,
		date(`p`.`payment_date`) as `payment_date`, 
		IF (p.fk_lead=0, '', CONCAT('QM', LPAD(p.fk_lead, 5, '0'))) AS `lead_cq_number`, 
		p.`refund_status` as `refund_status`, p.`refund_date` as `refund_date`, p.`admin_fee` as `admin_fee`, pt.`description` as `description`, p.`fk_lead` as `lead_id`, p.`fk_payment_type` as `fk_payment_type`, p.`merchant_cost` as `merchant_cost`, if(p.`status`=1,'Verified', 'Unverified') as `status`
		FROM payments p 
		LEFT JOIN payment_types pt ON p.`fk_payment_type` = pt.`id_payment_type`
		LEFT JOIN users u ON p.`fk_user` = u.`id_user`
		WHERE p.`deprecated` <> 1 {$where}
		GROUP BY p.`id_payment`
		ORDER BY p.`id_payment` DESC LIMIT ".$start.", ".$limit;

		return $this->db->query($query)->result_array();
	}	

	public function get_all_payments_count ($params, $my_id, $admin_type)
	{
		$cq_number = isset($params['cq_number']) ? $params['cq_number'] : '';
		$name = isset($params['name']) ? $params['name'] : '';
		$email = isset($params['email']) ? $params['email'] : '';
		$phone = isset($params['phone']) ? $params['phone'] : '';
		$user_id = isset($params['user_id']) ? $params['user_id'] : ''; 

		$state = isset($params['state']) ? $params['state'] : '';
		$postcode = isset($params['postcode']) ? $params['postcode'] : '';
		$address = isset($params['address']) ? $params['address'] : '';
		$lead_flag = isset($params['lead_flag']) ? $params['lead_flag'] : '';

		$where = "";
		if ($cq_number <> "") { $where .= " AND CONCAT('QM', LPAD(p.`fk_lead`, 5, '0')) = '".$this->db->escape_str($cq_number)."' "; }

		if ($admin_type==2 OR $admin_type==5)
		{
			if ($user_id <> "")
			{
				$where .= " AND l.`fk_user` = '".$this->db->escape_str($user_id)."' ";
			}
		}
		else
		{
			$where .= " AND l.`fk_user` = ".$my_id;
		}

		if($lead_flag <> "" and $lead_flag == "1")
		{
			$where .= " AND p.`fk_lead` = 0 ";
		}
		elseif($lead_flag <> "" and $lead_flag == "0")
		{
			$where .= " AND p.`fk_lead` != 0 ";
		}

		if ($name <> "") { $where .= " AND l.`name` LIKE '%".$this->db->escape_str($name)."%' "; }
		if ($email <> "") { $where .= " AND l.`email` LIKE '%".$this->db->escape_str($email)."%' "; }
		if ($phone <> "") { $where .= " AND l.`phone` LIKE '%".$this->db->escape_str($phone)."%' "; }
		
		if ($state <> "") { $where .= " AND l.`state` = '".$this->db->escape_str($state)."' "; }
		if ($postcode <> "") { $where .= " AND l.`postcode` LIKE '%".$this->db->escape_str($postcode)."%' "; }
		if ($address <> "") { $where .= " AND l.`address` LIKE '%".$this->db->escape_str($address)."%' "; }

		$query = "
		SELECT count(1) as `cnt`
		FROM payments p 
		LEFT JOIN payment_types pt ON p.`fk_payment_type` = pt.`id_payment_type`
		LEFT JOIN users u ON p.`fk_user` = u.`id_user`
		WHERE p.`deprecated` <> 1 {$where}";
		return $this->db->query($query)->row_array();
	}

	public function search_lead($email, $name, $qm_number)
	{
		$where = "";
		if ($email != "") { $where .= " AND l.`email` like '%".$this->db->escape_str($email)."%' "; }
		if ($name != "") { $where .= " AND l.`name` like '%".$this->db->escape_str($name)."%' "; }
		if ($qm_number <> "") { $where .= " AND CONCAT('QM', LPAD(l.`id_lead`, 5, '0')) = '".$this->db->escape_str($qm_number)."' "; }

		$query = "select 
					l.id_lead, l.email, l.name, l.phone, l.mobile, l.state, l.postcode, l.address, l.make, l.model, u.name as `qm_user`, u2.name as `temp_user`,
					CONCAT('QM', LPAD(l.id_lead, 5, '0')) AS `qm_number`
				from leads l
				left join `users` u on l.fk_user = u.id_user
				left join `users` u2 on l.fk_temp_user = u.id_user
				where 1 AND l.deprecated != 1 {$where} 
				order by l.`created_at` desc limit 20";

		return $this->db->query($query)->result_array();
	}

	public function get_searched_lead($lead_id)
	{
		$query = "select 
					l.id_lead, l.email, l.name, l.phone, l.mobile, l.state, l.postcode, l.address, l.make, l.model, u.name as `qm_user`, u2.name as `temp_user`,
					CONCAT('QM', LPAD(l.id_lead, 5, '0')) AS `qm_number`
				from leads l
				left join `users` u on l.fk_user = u.id_user
				left join `users` u2 on l.fk_temp_user = u.id_user
				where l.id_lead = {$lead_id};";

		return $this->db->query($query)->row_array();
	}

	public function assign_payment_to_lead($param)
	{
		$this->db->where('id_payment', $param['payment_id']);

		$update_data = [
			'fk_lead'         => $param['lead_id'],
			'fk_payment_type' => $param['payment_type']
		];

		$this->db->update('payments', $update_data);		
	}
}


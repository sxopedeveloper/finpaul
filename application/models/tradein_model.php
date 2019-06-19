<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tradein_Model extends CI_Model {

	public function attach_tradein ($input_arr)
	{
		$query = "
		UPDATE `tradeins` SET fk_lead = '".$this->db->escape_str($input_arr['lead_id'])."'
		WHERE `id_tradein` = '".$this->db->escape_str($input_arr['tradein_id'])."'";
		return $this->db->query($query);
	}

	public function unattach_tradein ($input_arr)
	{
		$query = "
		UPDATE `tradeins` SET fk_lead = '0' 
		WHERE `id_tradein` = '".$this->db->escape_str($input_arr['tradein_id'])."'";
		return $this->db->query($query);
	}

	public function update_tradein_new ($input_arr)
	{
		$now = date("Y-m-d H:i:s");
		
		$query_fields = '';
		if (isset($input_arr['id_tradein']))
		{
			if (isset($input_arr['first_name'])) { $query_fields .= " first_name = '".$this->db->escape_str($input_arr['first_name'])."',"; }
			if (isset($input_arr['first_name'])) { $query_fields .= " first_name = '".$this->db->escape_str($input_arr['first_name'])."',"; }
			if (isset($input_arr['email'])) { $query_fields .= " email = '".$this->db->escape_str($input_arr['email'])."',"; }
			if (isset($input_arr['phone'])) { $query_fields .= " phone = '".$this->db->escape_str($input_arr['phone'])."',"; }
			if (isset($input_arr['state'])) { $query_fields .= " state = '".$this->db->escape_str($input_arr['state'])."',"; }
			if (isset($input_arr['postcode'])) { $query_fields .= " postcode = '".$this->db->escape_str($input_arr['postcode'])."',"; }
			if (isset($input_arr['registration_plate'])) { $query_fields .= " registration_plate = '".$this->db->escape_str($input_arr['registration_plate'])."',"; }
			if (isset($input_arr['rego_expiry'])) { $query_fields .= " rego_expiry = '".$this->db->escape_str($input_arr['rego_expiry'])."',"; }
			if (isset($input_arr['tradein_vin'])) { $query_fields .= " tradein_vin = '".$this->db->escape_str($input_arr['tradein_vin'])."',"; }
			if (isset($input_arr['tradein_eng'])) { $query_fields .= " tradein_eng = '".$this->db->escape_str($input_arr['tradein_eng'])."',"; }
			if (isset($input_arr['tradein_make'])) { $query_fields .= " tradein_make = '".$this->db->escape_str($input_arr['tradein_make'])."',"; }
			if (isset($input_arr['tradein_model'])) { $query_fields .= " tradein_model = '".$this->db->escape_str($input_arr['tradein_model'])."',"; }
			if (isset($input_arr['tradein_variant'])) { $query_fields .= " tradein_variant = '".$this->db->escape_str($input_arr['tradein_variant'])."',"; }
			if (isset($input_arr['tradein_build_date'])) { $query_fields .= " tradein_build_date = '".$this->db->escape_str($input_arr['tradein_build_date'])."',"; }
			if (isset($input_arr['tradein_compliance_date'])) { $query_fields .= " tradein_compliance_date = '".$this->db->escape_str($input_arr['tradein_compliance_date'])."',"; }
			if (isset($input_arr['tradein_kms'])) { $query_fields .= " tradein_kms = '".$this->db->escape_str($input_arr['tradein_kms'])."',"; }
			if (isset($input_arr['tradein_fuel_type'])) { $query_fields .= " tradein_fuel_type = '".$this->db->escape_str($input_arr['tradein_fuel_type'])."',"; }
			if (isset($input_arr['tradein_body_type'])) { $query_fields .= " tradein_body_type = '".$this->db->escape_str($input_arr['tradein_body_type'])."',"; }
			if (isset($input_arr['tradein_colour'])) { $query_fields .= " tradein_colour = '".$this->db->escape_str($input_arr['tradein_colour'])."',"; }
			if (isset($input_arr['tradein_drive_type'])) { $query_fields .= " tradein_drive_type = '".$this->db->escape_str($input_arr['tradein_drive_type'])."',"; }
			if (isset($input_arr['tradein_transmission'])) { $query_fields .= " tradein_transmission = '".$this->db->escape_str($input_arr['tradein_transmission'])."',"; }
			if (isset($input_arr['options_1'])) { $query_fields .= " options_1 = '".$this->db->escape_str($input_arr['options_1'])."',"; }
			if (isset($input_arr['accessories_1'])) { $query_fields .= " accessories_1 = '".$this->db->escape_str($input_arr['accessories_1'])."',"; }
						
			if (isset($input_arr['warning_lights'])) { $query_fields .= " warning_lights = '".$this->db->escape_str($input_arr['warning_lights'])."',"; }
			if (isset($input_arr['damage'])) { $query_fields .= " damage = '".$this->db->escape_str($input_arr['damage'])."',"; }
			if (isset($input_arr['lease'])) { $query_fields .= " lease = '".$this->db->escape_str($input_arr['lease'])."',"; }
			if (isset($input_arr['bought_new'])) { $query_fields .= " bought_new = '".$this->db->escape_str($input_arr['bought_new'])."',"; }
			if (isset($input_arr['accessories_working'])) { $query_fields .= " accessories_working = '".$this->db->escape_str($input_arr['accessories_working'])."',"; }
			if (isset($input_arr['accident'])) { $query_fields .= " accident = '".$this->db->escape_str($input_arr['accident'])."',"; }
			if (isset($input_arr['paint_work'])) { $query_fields .= " paint_work = '".$this->db->escape_str($input_arr['paint_work'])."',"; }			
			
			if (isset($input_arr['tradein_service_history'])) { $query_fields .= " tradein_service_history = '".$this->db->escape_str($input_arr['tradein_service_history'])."',"; }
			if (isset($input_arr['other_info'])) { $query_fields .= " other_info = '".$this->db->escape_str($input_arr['other_info'])."',"; }
			if (isset($input_arr['total_payment_amount'])) { $query_fields .= " total_payment_amount = '".$this->db->escape_str($input_arr['total_payment_amount'])."',"; }
			if (isset($input_arr['dealer_payment'])) { $query_fields .= " dealer_payment = '".$this->db->escape_str($input_arr['dealer_payment'])."',"; }
			if (isset($input_arr['client_payment'])) { $query_fields .= " client_payment = '".$this->db->escape_str($input_arr['client_payment'])."',"; }
			if (isset($input_arr['bank_details'])) { $query_fields .= " bank_details = '".$this->db->escape_str($input_arr['bank_details'])."',"; }
			if (isset($input_arr['bank_account'])) { $query_fields .= " bank_account = '".$this->db->escape_str($input_arr['bank_account'])."',"; }
			if (isset($input_arr['bsb'])) { $query_fields .= " bsb = '".$this->db->escape_str($input_arr['bsb'])."',"; }
			if (isset($input_arr['reference'])) { $query_fields .= " reference = '".$this->db->escape_str($input_arr['reference'])."',"; }
			if (isset($input_arr['ppsr'])) { $query_fields .= " ppsr = '".$this->db->escape_str($input_arr['ppsr'])."',"; }

			if (isset($input_arr['contact_name'])) { $query_fields .= " contact_name = '".$this->db->escape_str($input_arr['contact_name'])."',"; }
			if (isset($input_arr['contact_number'])) { $query_fields .= " contact_number = '".$this->db->escape_str($input_arr['contact_number'])."',"; }
			if (isset($input_arr['pickup_address'])) { $query_fields .= " pickup_address = '".$this->db->escape_str($input_arr['pickup_address'])."',"; }			
			if (isset($input_arr['special_request'])) { $query_fields .= " special_request = '".$this->db->escape_str($input_arr['special_request'])."',"; }
			
			if (isset($input_arr['details'])) { $query_fields .= " details = '".$this->db->escape_str($input_arr['details'])."',"; }

			$query = "UPDATE `tradeins` SET ".$query_fields." last_updated = '".$now."' WHERE `id_tradein` = '".$this->db->escape_str($input_arr['id_tradein'])."'";
			return $this->db->query($query);					
		}
	}	
	
	public function get_lead_tradeins ($lead_id)
	{
		$query = "
		SELECT
		CONCAT('TI', LPAD(t.`id_tradein`, 5, '0')) AS `ti_number`,
		t.`id_tradein`,
		t.`fk_user`, t.`fk_lead`, t.`first_name`, t.`last_name`, t.`email`, t.`phone`, t.`state`, t.`postcode`, t.`registration_plate`, t.`rego_expiry`, 
		t.`tradein_value`, t.`tradein_given`, t.`tradein_payout`,
		t.`tradein_make`, t.`tradein_model`, t.`tradein_build_date`, t.`tradein_variant`, t.`tradein_colour`, t.`tradein_body_type`, t.`tradein_fuel_type`, 
		t.`tradein_drive_type`, t.`tradein_transmission`, t.`tradein_compliance_date`, t.`tradein_kms`, t.`tradein_service_history`, 
		t.`options_1`, t.`accessories_1`,
		t.`warning_lights`, t.`damage`, t.`lease`, t.`bought_new`, t.`accessories_working`, t.`accident`, t.`paint_work`, t.`other_info`, 
		t.`image_1`, t.`image_2`, t.`image_3`, t.`image_4`, t.`deprecated`, t.`created_at`
		FROM tradeins t 
		WHERE t.fk_lead = ".$lead_id."
		ORDER BY t.created_at DESC, t.id_tradein ASC";
		return $this->db->query($query)->result_array();
	}	
	
	public function get_tradeins ($params, $user_id, $login_type, $start, $limit)
	{
		$now = date("Y-m-d");

		$lead_id = isset($params['lead_id']) ? $params['lead_id'] : '';
		
		$ti_number = isset($params['ti_number']) ? $params['ti_number'] : '';
		$status = isset($params['status']) ? $params['status'] : '';

		$email = isset($params['email']) ? $params['email'] : '';		
		$name = isset($params['name']) ? $params['name'] : '';
		$phone = isset($params['phone']) ? $params['phone'] : '';

		$registration_plate = isset($params['registration_plate']) ? $params['registration_plate'] : '';
		$state = isset($params['state']) ? $params['state'] : '';
		$postcode = isset($params['postcode']) ? $params['postcode'] : '';
		
		$make = isset($params['make']) ? $params['make'] : '';
		$model = isset($params['model']) ? $params['model'] : '';
		$variant = isset($params['variant']) ? $params['variant'] : '';

		$where = "";
		$additional_order = "";
		
		if ($lead_id <> "") { $where .= " AND t.`fk_lead` = '".$this->db->escape_str($lead_id)."' "; }

		if ($ti_number <> "") { $where .= " AND CONCAT('TI', LPAD(t.`id_tradein`, 5, '0')) = '".$this->db->escape_str($ti_number)."' "; }

		if ($status == 1) // Cars Submitted for Valuation
		{
			$where .= " AND (t.`fk_lead` = '0' OR t.`fk_lead` = '') ";
		}
		else if ($status == 2) // Tendering Currently (Needs Urgent Valuation)
		{
			$where .= " AND t.`fk_lead` <> '0' AND DATE(l.`delivery_date`) >= '".$now."' AND l.status <= 3 ";
		}
		else if ($status == 3) // Confirmed as Trade (No Winners Yet)
		{
			$where .= " AND t.`fk_lead` <> '0' AND DATE(l.`delivery_date`) >= '".$now."' AND l.status IN (4, 5, 6, 7) ";
			$additional_order = " l.`delivery_date` ASC, ";
		}
		else if ($status == 4) // Valuations Won / Valuations with Winners
		{
			if ($login_type == "Admin")
			{
				$where .= " AND (tv.`fk_user` <> 0 AND tv.`fk_user` IS NOT NULL) AND DATE(l.`delivery_date`) >= '".$now."' ";
			}
			else
			{
				$where .= " AND tv.`fk_user` = '".$this->db->escape_str($user_id)."' AND DATE(l.`delivery_date`) >= '".$now."' ";	
			}
		}
		else if ($status == 5) // Cars Delivered
		{
			if ($login_type == "Admin")
			{
				$where .= " AND (tv.`fk_user` <> 0 AND tv.`fk_user` IS NOT NULL) AND DATE(l.`delivery_date`) < '".$now."' ";
			}
			else
			{
				$where .= " AND tv.`fk_user` = '".$this->db->escape_str($user_id)."' AND DATE(l.`delivery_date`) < '".$now."' ";
			}
		}

		if ($email <> "") { $where .= " AND t.`email` LIKE '%".$this->db->escape_str($email)."%' "; }
		if ($name <> "") { $where .= " AND CONCAT(t.`first_name`, ' ', t.`last_name`) LIKE '%".$this->db->escape_str($name)."%' "; }
		if ($phone <> "") { $where .= " AND t.`phone` LIKE '%".$this->db->escape_str($phone)."%' "; }

		if ($registration_plate <> "") { $where .= " AND t.`registration_plate` = '".$this->db->escape_str($registration_plate)."' "; }
		if ($state <> "") { $where .= " AND t.`state` = '".$this->db->escape_str($state)."' "; }
		if ($postcode <> "") { $where .= " AND t.`postcode` LIKE '%".$this->db->escape_str($postcode)."%' "; }

		if ($make <> "") { $where .= " AND t.`tradein_make` LIKE '%".$this->db->escape_str($make)."%' "; }
		if ($model <> "") { $where .= " AND t.`tradein_model` LIKE '%".$this->db->escape_str($model)."%' "; }
		if ($variant <> "") { $where .= " AND t.`tradein_variant` LIKE '%".$this->db->escape_str($variant)."%' "; }

		$query = "
		SELECT
		t.`id_tradein`,
		t.`id_tradein` AS `tradein_id`,
		
		t.`fk_trade_valuation` AS `trade_valuation_id`,
		
		CONCAT('TI', LPAD(t.`id_tradein`, 5, '0')) AS `ti_number`,
		t.`status`,
		CASE (t.`status`)
			WHEN 0 THEN 'Available'
			WHEN 1 THEN 'Bought'
		END `status_text`,
		t.`fk_user`, t.`fk_lead`, t.`first_name`, t.`last_name`, CONCAT(t.`first_name`, ' ', t.`last_name`) AS `name`, 
		t.`email`, t.`phone`, t.`state`, t.`postcode`, t.`registration_plate`, t.`rego_expiry`, 
		t.`tradein_make`, t.`tradein_model`, t.`tradein_build_date`, t.`tradein_variant`, t.`tradein_colour`, t.`tradein_body_type`, t.`tradein_fuel_type`, 
		t.`tradein_drive_type`, t.`tradein_transmission`, t.`tradein_compliance_date`, t.`tradein_kms`, t.`tradein_service_history`, 
		t.`options_1`, t.`accessories_1`,
		t.`warning_lights`, t.`damage`, t.`lease`, t.`bought_new`, t.`accessories_working`, t.`accident`, t.`paint_work`, t.`other_info`, 
		t.`image_1`, t.`image_2`, t.`image_3`, t.`image_4`, t.`deprecated`, DATE(t.`created_at`) AS `created_at`,
		a.`name` AS `qs_name`, a.`email` AS `qs_email`,
		
		(SELECT COUNT(1) FROM `trade_valuations` WHERE fk_tradein = `tradein_id`) AS `valuations`, 
		(SELECT `value` FROM trade_valuations WHERE fk_user = '".$user_id."' AND fk_tradein = `tradein_id`) AS `my_valuation`,
		(SELECT MAX(`value`) FROM trade_valuations WHERE fk_tradein = `tradein_id`) AS `highest_valuation`,
		
		IF (DATE(l.delivery_date) <> '0000-00-00', DATE(l.delivery_date), '') AS `delivery_date`,
		w.`name` AS `buyer`, tv.`value` AS `trade_value`,
		
		t.`email` AS `email_check`,
		(SELECT fk_user FROM leads WHERE `email` = `email_check` LIMIT 1) AS `consultant_id`,
		(SELECT name FROM users WHERE id_user = `consultant_id`) AS `consultant_name`,
		(SELECT mobile FROM users WHERE id_user = `consultant_id`) AS `consultant_mobile`,

		t.contact_name, t.contact_number, date(t.pickup_datetime) as `pickup_date`, DATE_FORMAT(t.`pickup_datetime`,'%H:%i:%s') as `pickup_time`, t.trans_flag,
		t.transport_company, t.transport_contact_num, t.cost_of_transport, t.booking_made, t.book_ref_number

		FROM tradeins t 
		LEFT JOIN users a ON t.fk_user = a.id_user
		LEFT JOIN trade_valuations tv ON t.fk_trade_valuation = tv.id_trade_valuation
		LEFT JOIN users w ON tv.fk_user = w.id_user
		LEFT JOIN leads l ON t.fk_lead = l.id_lead
		WHERE 1 ".$where." AND t.deprecated <> 1
		ORDER BY ".$additional_order." t.id_tradein DESC LIMIT ".$start.", ".$limit;
		return $this->db->query($query)->result_array();
	}
	
	public function get_tradeins_count ($params, $user_id, $login_type)
	{
		$now = date("Y-m-d");
		
		$lead_id = isset($params['lead_id']) ? $params['lead_id'] : '';

		$ti_number = isset($params['ti_number']) ? $params['ti_number'] : '';
		$status = isset($params['status']) ? $params['status'] : '';

		$email = isset($params['email']) ? $params['email'] : '';		
		$name = isset($params['name']) ? $params['name'] : '';
		$phone = isset($params['phone']) ? $params['phone'] : '';

		$registration_plate = isset($params['registration_plate']) ? $params['registration_plate'] : '';
		$state = isset($params['state']) ? $params['state'] : '';
		$postcode = isset($params['postcode']) ? $params['postcode'] : '';
		
		$make = isset($params['make']) ? $params['make'] : '';
		$model = isset($params['model']) ? $params['model'] : '';
		$variant = isset($params['variant']) ? $params['variant'] : '';

		$where = "";

		if ($lead_id <> "") { $where .= " AND t.`fk_lead` = '".$this->db->escape_str($lead_id)."' "; }
		
		if ($ti_number <> "") { $where .= " AND CONCAT('TI', LPAD(t.`id_tradein`, 5, '0')) = '".$this->db->escape_str($ti_number)."' "; }

		if ($status == 1) // Cars Submitted for Valuation
		{
			$where .= " AND t.`fk_lead` = '0' ";
		}
		else if ($status == 2) // Tendering Currently (Needs Urgent Valuation)
		{
			$where .= " AND t.`fk_lead` <> '0' AND DATE(l.`delivery_date`) >= '".$now."' AND l.status <= 3 ";
		}
		else if ($status == 3) // Confirmed as Trade (No Winners Yet)
		{
			$where .= " AND t.`fk_lead` <> '0' AND DATE(l.`delivery_date`) >= '".$now."' AND l.status IN (4, 5, 6, 7) ";
		}
		else if ($status == 4) // Valuations Won / Valuations with Winners
		{
			if ($login_type == "Admin")
			{
				$where .= " AND (tv.`fk_user` <> 0 AND tv.`fk_user` IS NOT NULL) AND DATE(l.`delivery_date`) >= '".$now."' ";
			}
			else
			{
				$where .= " AND tv.`fk_user` = '".$this->db->escape_str($user_id)."' AND DATE(l.`delivery_date`) >= '".$now."' ";	
			}
		}
		else if ($status == 5) // Cars Delivered
		{
			if ($login_type == "Admin")
			{
				$where .= " AND (tv.`fk_user` <> 0 AND tv.`fk_user` IS NOT NULL) AND DATE(l.`delivery_date`) < '".$now."' ";
			}
			else
			{
				$where .= " AND tv.`fk_user` = '".$this->db->escape_str($user_id)."' AND DATE(l.`delivery_date`) < '".$now."' ";
			}
		}

		if ($email <> "") { $where .= " AND t.`email` LIKE '%".$this->db->escape_str($email)."%' "; }
		if ($name <> "") { $where .= " AND CONCAT(t.`first_name`, ' ', t.`last_name`) LIKE '%".$this->db->escape_str($name)."%' "; }
		if ($phone <> "") { $where .= " AND t.`phone` LIKE '%".$this->db->escape_str($phone)."%' "; }

		if ($registration_plate <> "") { $where .= " AND t.`registration_plate` = '".$this->db->escape_str($registration_plate)."' "; }
		if ($state <> "") { $where .= " AND t.`state` = '".$this->db->escape_str($state)."' "; }
		if ($postcode <> "") { $where .= " AND t.`postcode` LIKE '%".$this->db->escape_str($postcode)."%' "; }

		if ($make <> "") { $where .= " AND t.`tradein_make` LIKE '%".$this->db->escape_str($make)."%' "; }
		if ($model <> "") { $where .= " AND t.`tradein_model` LIKE '%".$this->db->escape_str($model)."%' "; }
		if ($variant <> "") { $where .= " AND t.`tradein_variant` LIKE '%".$this->db->escape_str($variant)."%' "; }

		$query = "
		SELECT COUNT(1) AS `cnt` 
		FROM tradeins t
		LEFT JOIN users a ON t.fk_user = a.id_user
		LEFT JOIN trade_valuations tv ON t.fk_trade_valuation = tv.id_trade_valuation
		LEFT JOIN users w ON tv.fk_user = w.id_user
		LEFT JOIN leads l ON t.fk_lead = l.id_lead		
		WHERE 1 ".$where." AND t.deprecated <> 1";
		return $this->db->query($query)->row_array();
	}	
	
	public function get_same_make_tradeins ($make)
	{
		$now = date("Y-m-d");

		$query = "SELECT * FROM tradeins WHERE tradein_make = '".$make."' AND deprecated <> 1";
		return $this->db->query($query)->result_array();
	}
	
	public function get_user_tradein_valuation ($tradein_id, $user_id)
	{
		$query = "
		SELECT id_trade_valuation, value FROM trade_valuations 
		WHERE deprecated <> 1 AND fk_tradein = '".$this->db->escape_str($tradein_id)."' 
		AND fk_user = '".$this->db->escape_str($user_id)."'";
		return $this->db->query($query)->row_array();		
	}
	
	public function get_tradein_valuations_old ($tradein_id)
	{
		$query = "
		SELECT t.id_tradein, tv.id_trade_valuation, u.username AS `email`, u.name, u.id_user, tv.value, tv.created_at,
		t.fk_trade_valuation
		FROM trade_valuations tv
		JOIN tradeins t ON tv.fk_tradein = t.id_tradein
		JOIN users u ON tv.fk_user = u.id_user
		WHERE t.id_tradein = '".$this->db->escape_str($tradein_id)."'";
		return $this->db->query($query)->result_array();	
	}

	public function get_tradein_valuations ($tradein_id)
	{
		$query = "
		SELECT t.id_tradein, tv.id_trade_valuation, u.username AS `email`, u.name, u.state, u.id_user, tv.value, tv.created_at,
		t.fk_trade_valuation
		FROM trade_valuations tv
		JOIN tradein_new t ON tv.fk_tradein = t.id_tradein
		JOIN users u ON tv.dealer_id = u.id_user
		WHERE t.id_tradein = '".$this->db->escape_str($tradein_id)."'";
		return $this->db->query($query)->result_array();	
	}
	
	public function get_tradein_old ($tradein_id)
	{
		$query = "
		SELECT
		CONCAT('TI', LPAD(t.`id_tradein`, 5, '0')) AS `ti_number`,
		t.`id_tradein`, t.`id_tradein` AS `tradein_id`,
		t.`fk_user`, t.`fk_lead`, t.`first_name`, t.`last_name`, t.`email`, t.`phone`, t.`state`, t.`postcode`, t.`registration_plate`, t.`rego_expiry`, 
		t.`tradein_make`, t.`tradein_model`, t.`tradein_build_date`, t.`tradein_variant`, t.`tradein_colour`, t.`tradein_body_type`, t.`tradein_fuel_type`, 
		t.`tradein_drive_type`, t.`tradein_transmission`, t.`tradein_compliance_date`, t.`tradein_kms`, t.`tradein_service_history`, 
		t.`options_1`, t.`accessories_1`,
		t.`warning_lights`, t.`damage`, t.`lease`, t.`bought_new`, t.`accessories_working`, t.`accident`, t.`paint_work`, t.`other_info`, 
		t.`image_1`, t.`image_2`, t.`image_3`, t.`image_4`, t.`image_5`, t.`image_6`, t.`image_7`, t.`image_8`, t.`deprecated`,
		tv.`id_trade_valuation`,
		tv.`value` AS `winning_valuation`,
		
		fa.`lead_name`, fa.`business_name`, 
		fa.`tradein_value`, fa.`tradein_payout`, fa.`tradein_given`, fa.`lead_state` AS `client_state`, fa.`lead_postcode` AS `client_postcode`,

		u.`name` AS `buyer_name`, u.`username` AS `buyer_email`, 
		u.`phone` AS `buyer_phone`, u.`mobile` AS `buyer_mobile`, 
		u.`state` AS `buyer_state`, u.`postcode` AS `buyer_postcode`, u.`address` AS `buyer_address`,		
		
		a.`name` AS `qs_name`, a.`email` AS `qs_email`,
		IF (DATE(fa.`delivery_date`) <> '0000-00-00', DATE(fa.`delivery_date`), '') AS `delivery_date`,
		
		IF (
			DATE(fa.`order_date`) <> '0000-00-00', 
				DATE(fa.`order_date`), 
				''
		) AS `invoice_date`,
		
		IF (
			DATE(fa.`delivery_date`) <> '0000-00-00', 
				DATE(DATE_ADD(fa.`delivery_date` , INTERVAL -2 DAY)),
				''
		) AS `invoice_due_date`,

		DATE(t.pickup_datetime) AS `pickup_date`, 
		DATE_FORMAT(t.`pickup_datetime`,'%H:%i:%s') AS `pickup_time`,		
		t.`contact_type`, t.`contact_name`, t.`contact_number`, t.`pickup_address`, t.`special_request`,

		t.`trans_flag`, 
		t.`transport_company`, t.`transport_contact_num`, t.`cost_of_transport`, 
		t.`booking_made`, t.`book_ref_number`, 
		
		fa.`delivery_date` as `lead_delivery_date`, fa.`id_fq_account` as `lead_id`,

		t.`tradein_vin`, t.`tradein_eng`, t.`compliance_date`, t.`total_payment_amount`, t.`payment_due`, 
		t.`client_payment`, t.`dealer_payment`, t.`payment_amount`, 
		t.`bank_details`, t.`bank_account`, t.`bsb`, t.`reference`, t.`ppsr`,

		(SELECT COUNT(1) FROM tradein_documents_upload WHERE fk_lead = `tradein_id` AND fk_lead_doc = 1) AS `document_1_count`,
		(SELECT COUNT(1) FROM tradein_documents_upload WHERE fk_lead = `tradein_id` AND fk_lead_doc = 2) AS `document_2_count`,
		(SELECT COUNT(1) FROM tradein_documents_upload WHERE fk_lead = `tradein_id` AND fk_lead_doc = 3) AS `document_3_count`,
		(SELECT COUNT(1) FROM tradein_documents_upload WHERE fk_lead = `tradein_id` AND fk_lead_doc = 4) AS `document_4_count`,

		t.`details`, DATE(t.`created_at`) AS `created_at`

		FROM tradeins t 
		LEFT JOIN users a ON t.fk_user = a.id_user
		LEFT JOIN fq_accounts_new fa ON t.fk_lead = fa.id_fq_account
		LEFT JOIN trade_valuations tv ON t.fk_trade_valuation = tv.id_trade_valuation
		LEFT JOIN users u ON tv.fk_user = u.id_user
		WHERE t.`id_tradein` = ".$tradein_id." 
		GROUP BY t.`id_tradein`
		LIMIT 1";
		return $this->db->query($query)->row_array();
	}

	public function get_tradein ($tradein_id)
	{
		$query = "
		SELECT
		CONCAT('TI', LPAD(t.`id_tradein`, 5, '0')) AS `ti_number`,
		t.`id_tradein`, t.`fk_trade_valuation`, t.`id_tradein` AS `tradein_id`,
		t.`id_user`, t.`id_leads`, a.`name`, a.`username` as email, a.`phone`, a.`state`, a.`postcode`, t.`registration_plat`, t.`rego_expiry`, 
		t.`make`, t.`family`, t.`colour`, 
		t.`kilometers`, t.`service_history`, 
		t.`dash_warning_lights`, t.`damage_or_mechanical_issue`, t.`accidents`, t.`any_paint_work`, t.`images`,
		tv.`id_trade_valuation`,
		tv.`value` AS `winning_valuation`,
		
		fa.`lead_name`, fa.`business_name`, 
		fa.`tradein_value`, fa.`tradein_payout`, fa.`tradein_given`, fa.`lead_state` AS `client_state`, fa.`lead_postcode` AS `client_postcode`,

		u.`name` AS `buyer_name`, u.`username` AS `buyer_email`, 
		u.`phone` AS `buyer_phone`, u.`mobile` AS `buyer_mobile`, 
		u.`state` AS `buyer_state`, u.`postcode` AS `buyer_postcode`, u.`address` AS `buyer_address`,		
		
		a.`name` AS `qs_name`, a.`email` AS `qs_email`,
		IF (DATE(fa.`delivery_date`) <> '0000-00-00', DATE(fa.`delivery_date`), '') AS `delivery_date`,
		
		IF (
			DATE(fa.`order_date`) <> '0000-00-00', 
				DATE(fa.`order_date`), 
				''
		) AS `invoice_date`,
		
		IF (
			DATE(fa.`delivery_date`) <> '0000-00-00', 
				DATE(DATE_ADD(fa.`delivery_date` , INTERVAL -2 DAY)),
				''
		) AS `invoice_due_date`,

		fa.`delivery_date` as `lead_delivery_date`, fa.`id_fq_account` as `lead_id`,

		(SELECT COUNT(1) FROM tradein_documents_upload WHERE fk_lead = `tradein_id` AND fk_lead_doc = 1) AS `document_1_count`,
		(SELECT COUNT(1) FROM tradein_documents_upload WHERE fk_lead = `tradein_id` AND fk_lead_doc = 2) AS `document_2_count`,
		(SELECT COUNT(1) FROM tradein_documents_upload WHERE fk_lead = `tradein_id` AND fk_lead_doc = 3) AS `document_3_count`,
		(SELECT COUNT(1) FROM tradein_documents_upload WHERE fk_lead = `tradein_id` AND fk_lead_doc = 4) AS `document_4_count`,

		DATE(t.`created_at`) AS `created_at`

		FROM tradein_new t 
		LEFT JOIN users a ON t.id_user = a.id_user
		LEFT JOIN fq_accounts_new fa ON t.id_leads = fa.id_fq_account
		LEFT JOIN trade_valuations tv ON t.fk_trade_valuation = tv.id_trade_valuation
		LEFT JOIN users u ON tv.fk_user = u.id_user
		WHERE t.`id_tradein` = ".$tradein_id." 
		GROUP BY t.`id_tradein`
		LIMIT 1";
		return $this->db->query($query)->row_array();
		/*WHERE t.`id_leads` = ".$tradein_id." */
	}

	public function get_tradeins_client ($lead_id)
	{
		$query = "SELECT * FROM tradeins WHERE fk_lead = {$lead_id}";
		return $this->db->query($query)->result_array();
	}
	
	public function insert_trade_valuation ($user_id, $input_arr)
	{
		$now = date("Y-m-d H:i:s");
		
		if ($input_arr['value'] <> "" AND $input_arr['value'] <> 0)
		{
			$query = "
			INSERT INTO `trade_valuations` (fk_tradein, fk_user, dealer_id, code, status, value, deprecated, created_at)
			VALUES (
				'".$input_arr['id_tradeIn']."', 
				'".$user_id."',
				'".$input_arr['dealer_id']."', 
				MD5(CONCAT('".$input_arr['id_tradeIn']."', '-', '".$input_arr['dealer_id']."')),
				0,
				'".$this->db->escape_str($input_arr['value'])."',
				0,
				'".$now."'
			)
			ON DUPLICATE KEY UPDATE
			value = '".$this->db->escape_str($input_arr['value'])."'";
			return $this->db->query($query);
		}		
	}
	
	public function update_trade_valuation ($input_arr)
	{
		$now = date("Y-m-d H:i:s");
		
		if ($input_arr['value'] <> "" AND $input_arr['value'] <> 0)
		{
			$query = "
			UPDATE `trade_valuations` 
			SET value = '".$this->db->escape_str($input_arr['value'])."'
			WHERE id_trade_valuation = '".$this->db->escape_str($input_arr['id_trade_valuation'])."'";
			return $this->db->query($query);
		}		
	}
	
	
	
	
	public function update_tradein_declarations ($input_arr)
	{
		if (isset($input_arr['id_tradein']))
		{		
			$query = "
			UPDATE `tradeins` SET 
			declaration_1 = '".$this->db->escape_str($input_arr['declaration_1'])."',
			tradein_purchased_from = '".$this->db->escape_str($input_arr['tradein_purchased_from'])."',
			declaration_2 = '".$this->db->escape_str($input_arr['declaration_2'])."',
			tradein_encumbered_by = '".$this->db->escape_str($input_arr['tradein_encumbered_by'])."',
			declaration_payg = '".$this->db->escape_str($input_arr['declaration_payg'])."',
			tradein_abn_holder = '".$this->db->escape_str($input_arr['tradein_abn_holder'])."',
			tradein_not_providing = '".$this->db->escape_str($input_arr['tradein_not_providing'])."',
			tradein_not_providing_abn = '".$this->db->escape_str($input_arr['tradein_not_providing_abn'])."'
			WHERE `id_tradein` = ".$input_arr['id_tradein'];
			$sql = $this->db->query($query);
		}
	}
	
	public function update_tradein ($input_arr) // TO BE DELETED //
	{
		if (isset($input_arr['id_tradein']))
		{
			$id = $input_arr['id_tradein'];

			unset($input_arr['id_tradein']);
			unset($input_arr['hidden_lead_id_tradein']);

			(isset($input_arr['warning_lights'])) ? $input_arr['warning_lights'] = "Yes" : $input_arr['warning_lights'] = "No";
			(isset($input_arr['damage'])) ? $input_arr['damage'] = "Yes" : $input_arr['damage'] = "No";
			(isset($input_arr['lease'])) ? $input_arr['lease'] = "Yes" : $input_arr['lease'] = "No";
			(isset($input_arr['bought_new'])) ? $input_arr['bought_new'] = "Yes" : $input_arr['bought_new'] = "No";
			(isset($input_arr['accessories_working'])) ? $input_arr['accessories_working'] = "Yes" : $input_arr['accessories_working'] = "No";
			(isset($input_arr['accident'])) ? $input_arr['accident'] = "Yes" : $input_arr['accident'] = "No";
			(isset($input_arr['paint_work'])) ? $input_arr['paint_work'] = "Yes" : $input_arr['paint_work'] = "No";

			$input_arr['pickup_datetime'] = $input_arr['pickup_date'] . " " . date('H:i:s', strtotime($input_arr['pickup_time']));

			unset($input_arr['pickup_date']);
			unset($input_arr['pickup_time']);

			$this->db->where('id_tradein', $id);

			$this->db->update('tradeins', $input_arr);			
		}
	}

	public function update_buyer_old ($id_tradein, $id_trade_valuation)
	{
		$query = "
		UPDATE `tradeins` SET fk_trade_valuation = '".$this->db->escape_str($id_trade_valuation)."'
		WHERE `id_tradein` = ".$id_tradein;
		return $this->db->query($query);
	}

	public function update_buyer ($id_tradein, $id_trade_valuation)
	{
		$query = "
		UPDATE `tradein_new` SET fk_trade_valuation = '".$this->db->escape_str($id_trade_valuation)."'
		WHERE `id_tradein` = ".$id_tradein;
		return $this->db->query($query);
	}

	public function remove_buyer ($id_tradein, $id_trade_valuation)
	{
		$query = "
		UPDATE `tradeins` SET fk_trade_valuation = ''
		WHERE `id_tradein` = ".$id_tradein;
		return $this->db->query($query);
	}
	
	public function insert_valuation ($input_arr)
	{
		$now = date("Y-m-d H:i:s");
		
		if ($input_arr['entered_value']<>"" AND $input_arr['entered_value']<>0)
		{
			$query = "
			INSERT INTO `trade_valuations` (fk_tradein, fk_user, code, status, value, deprecated, created_at)
			VALUES (
				'".$input_arr['id_tradein']."', 
				'".$input_arr['user_id']."',
				MD5(CONCAT('".$input_arr['id_tradein']."', '-', '".$input_arr['user_id']."')),
				0,
				'".$this->db->escape_str($input_arr['entered_value'])."',
				0,
				'".$now."'
			)
			ON DUPLICATE KEY UPDATE
			value = '".$this->db->escape_str($input_arr['entered_value'])."'";
			$sql = $this->db->query($query);
		}		
	}
	
	public function get_attached_tradeins ($lead_id)
	{
		$query = "
		SELECT
		CONCAT('TI', LPAD(t.`id_tradein`, 5, '0')) AS `ti_number`,
		t.`id_tradein`,
		t.`fk_user`, t.`fk_lead`, t.`first_name`, t.`last_name`, t.`email`, t.`phone`, t.`state`, t.`postcode`, t.`registration_plate`, t.`rego_expiry`, 
		t.`tradein_value`, t.`tradein_given`, t.`tradein_payout`,
		t.`tradein_make`, t.`tradein_model`, t.`tradein_build_date`, t.`tradein_variant`, t.`tradein_colour`, t.`tradein_body_type`, t.`tradein_fuel_type`, 
		t.`tradein_drive_type`, t.`tradein_transmission`, t.`tradein_compliance_date`, t.`tradein_kms`, t.`tradein_service_history`, 
		t.`options_1`, t.`accessories_1`,
		t.`warning_lights`, t.`damage`, t.`lease`, t.`bought_new`, t.`accessories_working`, t.`accident`, t.`paint_work`, t.`other_info`, 
		t.`image_1`, t.`image_2`, t.`image_3`, t.`image_4`, t.`deprecated`, t.`created_at`
		FROM tradeins t 
		WHERE t.fk_lead = ".$lead_id."
		ORDER BY t.created_at DESC, t.id_tradein ASC";
		$sql = $this->db->query($query);
		return $sql->result();
	}
	
	public function update_dealer_visibility ($input_arr)
	{
		$query = "
		UPDATE `tradeins` SET dealer_visibility = '".$this->db->escape_str($input_arr['dealer_visibility'])."'
		WHERE `id_tradein` = ".$input_arr['tradein_id'];
		$sql = $this->db->query($query);
	}

	public function delete_tradeins ($tradein_ids)
	{
		$query = "UPDATE `tradeins` SET deprecated = 1 WHERE `id_tradein` IN (".str_replace('on', '', str_replace(',on', '', $tradein_ids)).")";
		$sql = $this->db->query($query);
	}

	public function upload_new_image ($data_array) // Christian
	{
		$data['image_'.$data_array['image_num']] = $data_array['file_name'];
		$this->db->where('id_tradein', $data_array['id']);
		if($this->db->update('tradeins', $data))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function delete_image ($data_array) // Christian
	{
		$data['image_'.$data_array['image_num']] = "";
		$this->db->where('id_tradein', $data_array['id']);
		if($this->db->update('tradeins', $data))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function get_filtred_tradeins ($email,$make,$first_name,$last_name,$model)
	{
		$where = "";
		if ($make != "") { $where .= " AND t.`tradein_make` like '%".$make."%' "; }
		if ($email != "") { $where .= " AND t.`email` like '%".$email."%' "; }
		if ($first_name != "") { $where .= " AND t.`first_name` like '%".$first_name."%' "; }
		if ($last_name != "") { $where .= " AND t.`last_name` like '%".$last_name."%' "; }
		if ($model != "") { $where .= " AND t.`tradein_model` like'%".$model."%' "; }

		$query = "
		SELECT t.id_tradein, t.fk_lead, t.dealer_visibility,
		t.first_name, t.last_name, t.email, t.phone, t.state, t.postcode,
		t.tradein_value, t.tradein_given, t.tradein_payout,
		t.tradein_make, t.tradein_model, t.tradein_variant, t.tradein_build_date, t.tradein_kms,
		t.tradein_colour, t.tradein_transmission, CONCAT('QM', LPAD(t.fk_lead, 5, '0')) AS `cq_number`, t.fk_lead,
		tv.value,
		u.id_user, u.username, u.name, t.image_1, t.id_tradein
		FROM tradeins t
		LEFT JOIN trade_valuations tv ON t.fk_trade_valuation = tv.id_trade_valuation
		LEFT JOIN users u ON tv.fk_user = u.id_user WHERE 1 ".$where. "
		ORDER BY t.id_tradein DESC";

		return $result = $this->db->query($query)->result_array();
	}

	public function get_searched_tradeins ($tradein_id)
	{
		$query = "
		SELECT t.id_tradein, t.fk_lead, t.dealer_visibility,
		t.first_name, t.last_name, t.email, t.phone, t.state, t.postcode,
		t.tradein_value, t.tradein_given, t.tradein_payout,
		t.tradein_make, t.tradein_model, t.tradein_variant, t.tradein_build_date, t.tradein_kms,
		t.tradein_colour, t.tradein_transmission,
		tv.value,
		u.id_user, u.username, u.name, t.image_1, t.id_tradein
		FROM tradeins t
		LEFT JOIN trade_valuations tv ON t.fk_trade_valuation = tv.id_trade_valuation
		LEFT JOIN users u ON tv.fk_user = u.id_user WHERE t.id_tradein = {$tradein_id};";
		return $result = $this->db->query($query)->row_array();
	}

	public function lead_tradein_flagger ($lead_id)
	{
		$query = "SELECT *, CONCAT('QM', LPAD(id_tradein, 5, '0')) AS `ti_number` FROM tradeins WHERE fk_lead = {$lead_id}";
		return $this->db->query($query)->result_array();
	}

	public function update_upload_key ($id, $key)
	{
		$data = ['upload_key' => $key];
		$this->db->where('id_tradein', $id);
		$this->db->update('tradeins', $data);
	}

	public function get_contact_details ($lead_id)
	{
		$lead_id = ($lead_id == "" || $lead_id == "0" || $lead_id == 0) ? "0" : $lead_id;

		$query = "
		SELECT
		l.`id_lead`, 
		l.`id_lead` AS `lead_id`,				
		l.`name`, l.`business_name`, l.`email`, l.`state`, l.`postcode`, l.`address`, 
		l.`phone`, l.`mobile`, l.`date_of_birth`, l.`driver_license`, l.`details`, 
		
		qs.`id_user`,
		qs.`id_user` AS `qs_id`,
		qs.`name` AS `qs_name`, 
		qs.`username` AS `qs_email`, qs.`phone` AS `qs_phone`, qs.`mobile` AS `qs_mobile`,

		d.`id_user` AS `dealer_id`,
		da.`dealership_name` AS `dealership_name`, d.`name` AS `fleet_manager`, 
		d.`username` AS `dealer_email`, d.`phone` AS `dealer_phone`, d.`mobile` AS `dealer_mobile`, 
		d.`state` AS `dealer_state`, d.`postcode` AS `dealer_postcode`, d.`address` AS `dealer_address`,

		q.`id_quote`,
		q.`id_quote` AS `quote_id`,

		l.`delivery_address`, l.`delivery_instructions`

		FROM `leads` AS `l`
		LEFT JOIN `users` AS `qs` ON l.`fk_user` = qs.`id_user`
		LEFT JOIN `quote_requests` AS `qr` ON l.`id_lead` = qr.`fk_lead`
		LEFT JOIN `quotes` AS `q` ON qr.`winner` = q.`id_quote`
		LEFT JOIN `users` AS `d` ON q.`fk_user` = d.`id_user`
		LEFT JOIN `dealer_attributes` AS `da` ON d.`id_user` = da.`fk_user`
		WHERE l.id_lead = {$lead_id};";
		return $this->db->query($query)->row_array();
	}

	public function get_all_wholesalers($state)
	{
		$query = "select id_user, username, name from users where type = 3 and state = '{$state}'";
		return $this->db->query($query)->result_array();
	}
}


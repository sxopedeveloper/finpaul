<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Request_Model extends CI_Model {

	public function insert_dealer_request ($quote_request_id, $user_id ,$ins_array = array())
	{
		$email_text = isset($ins_array['mail_text']) && !empty($ins_array['mail_text']) ? $ins_array['mail_text'] : '';
		$file = isset($ins_array['file']) && !empty($ins_array['file']) ? $ins_array['file'] : '';
		$now = date("Y-m-d g:i:s");
		$data = array(
			'fk_quote_request' => $this->db->escape_str($quote_request_id),
			'fk_user' => $this->db->escape_str($user_id),
			'created_at' => $now,
			'code' => $this->db->escape_str($quote_request_id)."-".$this->db->escape_str($user_id),
			'mail_text' => $email_text,
			'file_name' => $file,
		);

		return $this->db->insert('dealer_requests', $data);
	}

	public function update_quote_request_reminder ($quote_request_id)
	{
		$query = "UPDATE quote_requests SET reminder = 1 WHERE id_quote_request = ".$quote_request_id;
		return $this->db->query($query);	
	}

	public function select_winner ($quote_request_id, $quote_id)
	{
		$this->db->set('winner', $quote_id);  
		$this->db->where('id_quote_request', $quote_request_id); 
		return $this->db->update('quote_requests');
		//return $quote_request_id;
		// $query = "UPDATE `quote_requests` SET `winner` = ".$quote_id." WHERE `id_quote_request` = '".$quote_request_id."'";
		// return $this->db->query($query);
	}

	public function remove_winner($quote_request_id)
	{
		$this->db->set('winner', '');
		$this->db->where('id_quote_request', $quote_request_id);
		return $this->db->update('quote_requests');
	}
	
	public function send_quote_request ($input_arr, $user_id)
	{
		$this->db->where('fk_user', $user_id);
		$this->db->where('fk_lead', $input_arr['id_lead']);
		$this->db->delete('quote_requests');
			
		$now = date("Y-m-d g:i:s");
		$query = "
		INSERT INTO `quote_requests` (fk_user, fk_lead, make, model,rb_data ,build_date, variant, series, body_type, registration_type, transmission, colour, fuel_type, email_paragraph, created_at)
		VALUES (
		'".$user_id."', '".$input_arr['id_lead']."',
		'".$this->db->escape_str($input_arr['make'])."',
		'".$this->db->escape_str($input_arr['family'])."',
		'".$this->db->escape_str($input_arr['rb_data'])."',
		SUBSTRING_INDEX('".$this->db->escape_str($input_arr['build_date'])."', '-', -1),
		'".$this->db->escape_str($input_arr['vehicle'])."',
		'".$this->db->escape_str($input_arr['series'])."',
		'".$this->db->escape_str($input_arr['body_type'])."',
		'".$this->db->escape_str($input_arr['registration_type'])."',
		'".$this->db->escape_str($input_arr['transmission'])."',
		'".$this->db->escape_str($input_arr['colour'])."',
		'".$this->db->escape_str($input_arr['fuel_type'])."',
		'".$this->db->escape_str($input_arr['email_paragraph'])."',
		'".$now."')";
		
		return $this->db->query($query);
	}
	
	public function update_quote_request ($input_arr)
	{
		$now = date("Y-m-d g:i:s");
		$query = "
		UPDATE `quote_requests` 
		SET 
		make = '".$this->db->escape_str($input_arr['make'])."', 
		model = '".$this->db->escape_str($input_arr['family'])."', 
		build_date = SUBSTRING_INDEX('".$this->db->escape_str($input_arr['build_date'])."', '-', -1), 
		rb_data = '".$this->db->escape_str($input_arr['rb_data'])."', 
		variant = '".$this->db->escape_str($input_arr['vehicle'])."', 
		series = '".$this->db->escape_str($input_arr['series'])."', 
		body_type = '".$this->db->escape_str($input_arr['body_type'])."', 
		transmission = '".$this->db->escape_str($input_arr['transmission'])."', 
		colour = '".$this->db->escape_str($input_arr['colour'])."', 
		fuel_type = '".$this->db->escape_str($input_arr['fuel_type'])."', 
		registration_type = '".$this->db->escape_str($input_arr['registration_type'])."'
		WHERE id_quote_request = '".$this->db->escape_str($input_arr['id_quote_request'])."'";
		return $this->db->query($query);
	}		
	
	public function send_quote_request_option ($quote_request_id, $option_id)
	{
		$now = date("Y-m-d g:i:s");
		$query = "
		INSERT INTO `quote_request_options` (fk_quote_request, fk_option, code, created_at)
		VALUES (
			'".$quote_request_id."', '".$option_id."', CONCAT(".$quote_request_id.", '-', ".$option_id."), '".$now."'
		)";
		$sql = $this->db->query($query);
	}
	
	public function clear_quote_request_options ($quote_request_id)
	{
		$query = "
		UPDATE quote_request_options qro
		LEFT JOIN quote_options qo
		ON qro.id_quote_request_option = qo.fk_request_option
		SET qro.deprecated = 1, qo.deprecated = 1 WHERE qro.fk_quote_request = ".$quote_request_id;
		$sql = $this->db->query($query);
	}
	
	public function clear_quote_request_accessories ($quote_request_id)
	{
		$query = "
		UPDATE quote_request_accessories qra
		LEFT JOIN quote_accessories qa
		ON qra.id_quote_request_accessory = qa.fk_request_accessory
		SET qra.deprecated = 1, qa.deprecated = 1 WHERE qra.fk_quote_request = ".$quote_request_id;
		$sql = $this->db->query($query);
	}	
	
	public function resend_quote_request_option ($quote_request_id, $option_id)
	{
		$now = date("Y-m-d g:i:s");
		$query = "
		INSERT INTO quote_request_options
		(fk_quote_request, fk_option, code, deprecated, created_at)
		VALUES ('".$quote_request_id."', '".$option_id."', CONCAT(".$quote_request_id.", '-', ".$option_id."), 0, '".$now."')
		ON DUPLICATE KEY UPDATE
		deprecated = 0";
		$sql = $this->db->query($query);
	}
	
	public function send_quote_request_accessory ($quote_request_id, $name, $desc)
	{
		$now = date("Y-m-d g:i:s");
		$query = "
		INSERT INTO `quote_request_accessories` (fk_quote_request, name, description, code, created_at)
		VALUES (
			'".$quote_request_id."', '".$this->db->escape_str($name)."', '".$this->db->escape_str($desc)."', 
			MD5(CONCAT(".$quote_request_id.", '-', '".$this->db->escape_str($name)."', '-', '".$this->db->escape_str($desc)."')), 
			'".$now."'
		)";

		// echo $query.'<br>';
		$sql = $this->db->query($query);
	}
	
	public function resend_quote_request_accessory ($quote_request_id, $name, $desc)
	{
		$now = date("Y-m-d g:i:s");
		$query = "
		INSERT INTO quote_request_accessories
		(fk_quote_request, name, description, code, deprecated, created_at)
		VALUES (
			'".$quote_request_id."', '".$this->db->escape_str($name)."', '".$this->db->escape_str($desc)."',
			MD5(CONCAT(".$quote_request_id.", '-', '".$this->db->escape_str($name)."', '-', '".$this->db->escape_str($desc)."')),
			0, '".$now."'
		)
		ON DUPLICATE KEY UPDATE
		deprecated = 0";

		// echo $query.'<br>';
		$sql = $this->db->query($query);
	}

	public function get_accessories ($quote_request_id)
	{
		$query = "SELECT * FROM quote_request_accessories WHERE fk_quote_request = ".$quote_request_id." AND deprecated <> 1";
		$sql = $this->db->query($query);
		return $sql->result();	
	}
	
	public function get_accessories_edit_tender($quote_request_id)
	{
		$query = "SELECT * FROM quote_request_accessories WHERE fk_quote_request = ".$quote_request_id." AND deprecated <> 1";
		$sql = $this->db->query($query);
		return $sql->result_array();	
	}
	
	public function get_dealers ($fk_quote_request)
	{
		$query = "
		SELECT u.username as `email`
		FROM users u JOIN dealer_requests dr ON u.id_user = dr.fk_user
		WHERE 1 AND u.deprecated <> 1
		AND dr.fk_quote_request = ".$fk_quote_request."
		GROUP BY u.id_user";
		$sql = $this->db->query($query);
		return $sql->result();
	}

	public function get_dealer_quote_requests ($user_id, $status) // TEMPORARILY DISBALED THE STATUS
	{
		$now = date("Y-m-d g:i:s");

		$where = "";
		$join = ""; 
		if ($status == 0)
		{
			// $where = " AND (qr.winner IN (0, '') OR qr.winner IS NULL) ";
		}
		else if ($status == 2)
		{
			$join =  " JOIN quotes q ON qr.winner = q.id_quote";
			$where = " AND q.fk_user = " . $user_id . " ";
		}		
		
		$query = "
		SELECT da.dealership_brand, CONCAT(u.state, ',', da.dealership_states) AS dealership_states
		FROM users u
		JOIN dealer_attributes da ON u.id_user = da.fk_user
		WHERE u.id_user = ".$user_id."
		GROUP BY u.id_user LIMIT 1";
		$dealer_details = $this->db->query($query)->row_array();

		$dealership_states_query_string = "";
		$dealership_states = explode(',', $dealer_details['dealership_states']);
		foreach ($dealership_states AS $dealership_state)
		{
			if (trim($dealership_state) <> "")
			{
				$dealership_states_query_string .= "'".$dealership_state."', ";
			}
		}
		$dealership_states_query_string .= "'xxxxxxxx'";
		
		$dealership_brand_query_string = "";
		$dealership_brands = explode(',', $dealer_details['dealership_brand']);
		foreach ($dealership_brands AS $dealership_brand)
		{
			if (trim($dealership_brand) <> "")
			{
				$dealership_brand_query_string .= "'".$dealership_brand."', ";
			}
		}
		$dealership_brand_query_string .= "'xxxxxxxx'";		

		/*
		<input type="hidden" id="process" name="process">
		<input type="hidden" id="registration_type" name="registration_type">
		<input type="hidden" id="dealer_state" name="dealer_state">
		<input type="hidden" id="client_state" name="client_state">
		<input type="hidden" id="tradein_count" name="tradein_count">
		*/
		
		$params = $_GET;
		
		$dealer_status = isset($params['dealer_status']) ? $params['dealer_status'] : '';
		$qn_no = isset($params['qn_no']) ? $params['qn_no'] : '';
		$newLead_make = isset($params['newLead_make']) ? $params['newLead_make'] : '';
		$newLead_model = isset($params['newLead_model']) ? $params['newLead_model'] : '';
		$newLead_car_year = isset($params['newLead_car_year']) ? $params['newLead_car_year'] : '';
		$newLead_car_variant = isset($params['newLead_car_variant']) ? $params['newLead_car_variant'] : '';

		//$where = "";
		if ($dealer_status <> "") { $where .= " AND l.status = '".$this->db->escape_str($dealer_status)."' "; }
		if ($qn_no <> "") { $where .= " AND l.id_lead LIKE '%".$this->db->escape_str($qn_no)."%' "; }
		if ($newLead_make <> "") { $where .= " AND m.name = '".$this->db->escape_str($newLead_make)."' "; }
		if ($newLead_model <> "") { $where .= " AND f.name = '".$this->db->escape_str($newLead_model)."' "; }
		if ($newLead_car_year <> "") { $where .= " AND qr.build_date = '".$this->db->escape_str($newLead_car_year)."' "; }
		if ($newLead_car_variant <> "") { $where .= " AND v.name = '".$this->db->escape_str($newLead_car_variant)."' "; }
		
		$query = "
		SELECT * FROM 
		(
			SELECT
			
			qr.id_quote_request,
			qr.id_quote_request AS `quote_request_id`, 
			qr.winner AS `winner_id`,
			
			(
				SELECT id_quote FROM quotes 
				WHERE fk_quote_request = `quote_request_id` AND fk_user = '".$this->db->escape_str($user_id)."' AND demo = 'New'
				LIMIT 1
			) AS `id_quote_new`,
			
			(
				SELECT id_quote FROM quotes 
				WHERE fk_quote_request = `quote_request_id` AND fk_user = '".$this->db->escape_str($user_id)."' AND demo = 'Demo'
				LIMIT 1
			) AS `id_quote_demo`,
			
			l.id_lead, 
			l.id_lead AS `lead_id`,
			CONCAT('QM', LPAD(l.`id_lead`, 5, '0')) AS `cq_number`,
			l.state, l.postcode, 

			m.name AS `make`, f.name AS `model`, v.name AS `variant`,
			
			qr.registration_type, qr.build_date, qr.colour, qr.message, qr.created_at,
			
			(
				SELECT COUNT(1) FROM quotes 
				WHERE deprecated <> 1 
				AND fk_user = '".$user_id."' 
				AND fk_quote_request = `quote_request_id`
			) AS `cnt`,

			(
				SELECT COUNT(1) FROM dealer_requests 
				WHERE fk_user = '".$user_id."' 
				AND fk_quote_request = `quote_request_id`
			) AS `invited`
			
			FROM quote_requests qr
			JOIN leads l ON qr.fk_lead = l.id_lead
			JOIN makes m ON qr.make = m.id_make
			JOIN families f ON qr.model = f.id_family
			LEFT JOIN vehicles v ON qr.variant = v.id_vehicle
			".$join."
			WHERE qr.deprecated <> 1
			AND l.status <> 100
			AND l.state IN (".$dealership_states_query_string.")
			AND m.name IN (".$dealership_brand_query_string.")		
			".$where."
			GROUP BY qr.id_quote_request
			
			UNION
			
			SELECT
			
			qr.id_quote_request,
			qr.id_quote_request AS `quote_request_id`, 
			qr.winner AS `winner_id`,
			
			(
				SELECT id_quote FROM quotes 
				WHERE fk_quote_request = `quote_request_id` AND fk_user = '".$this->db->escape_str($user_id)."' AND demo = 'New'
				LIMIT 1
			) AS `id_quote_new`,
			
			(
				SELECT id_quote FROM quotes 
				WHERE fk_quote_request = `quote_request_id` AND fk_user = '".$this->db->escape_str($user_id)."' AND demo = 'Demo'
				LIMIT 1
			) AS `id_quote_demo`,
			
			l.id_lead, 
			l.id_lead AS `lead_id`,
			CONCAT('QM', LPAD(l.`id_lead`, 5, '0')) AS `cq_number`,
			l.state, l.postcode, 

			m.name AS `make`, f.name AS `model`, v.name AS `variant`,
			
			qr.registration_type, qr.build_date, qr.colour, qr.message, qr.created_at,
			
			(
				SELECT COUNT(1) FROM quotes 
				WHERE deprecated <> 1 
				AND fk_user = '".$user_id."' 
				AND fk_quote_request = `quote_request_id`
			) AS `cnt`,

			(
				SELECT COUNT(1) FROM dealer_requests 
				WHERE fk_user = '".$user_id."' 
				AND fk_quote_request = `quote_request_id`
			) AS `invited`

			FROM quote_requests qr
			JOIN leads l ON qr.fk_lead = l.id_lead
			JOIN makes m ON qr.make = m.id_make
			JOIN families f ON qr.model = f.id_family
			LEFT JOIN vehicles v ON qr.variant = v.id_vehicle
			JOIN dealer_requests dr ON qr.id_quote_request = dr.fk_quote_request
			".$join."		
			WHERE qr.deprecated <> 1
			AND l.status <> 100
			".$where." 
			AND dr.fk_user = '".$user_id."'
			GROUP BY qr.id_quote_request
		) a
		ORDER BY invited DESC, created_at DESC";
		return $this->db->query($query)->result_array();
	}

	public function get_dealer_quote_requests_count ($user_id, $status) // TEMPORARILY DISBALED THE STATUS
	{
		$now = date("Y-m-d g:i:s");
	
		$where = "";
		$join = "";
		if ($status == 0)
		{
			$where = " AND qr.winner IN (0, '') AND qr.created_at > ('".$now."' - INTERVAL 14 DAY) ";
		}
		else if ($status == 1)
		{
			$where = " AND (qr.winner NOT IN (0, '') OR qr.created_at < ('".$now."' - INTERVAL 14 DAY)) ";
		}
		else if ($status == 2)
		{
			$join =  " JOIN quotes q ON qr.winner = q.id_quote";
			$where = " AND q.fk_user = " . $user_id . " ";
		}

		$query = "
		SELECT COUNT(DISTINCT qr.id_quote_request) AS `cnt`
		FROM quote_requests qr
		LEFT JOIN dealer_requests dr ON qr.id_quote_request = dr.fk_quote_request
		".$join."
		WHERE 1 AND qr.deprecated <> 1 ".$where." AND dr.fk_user = '".$user_id."'";
		return $this->db->query($query)->row_array();
	}	
	
	// FOR QUOTATION FORM //
	public function get_quote_request ($quote_request_id)
	{
		$query = "
		SELECT 
		qr.id_quote_request, qr.quote_number, qr.postcode, a.name as `user`, a.username as `email`, a.phone as `phone`,
		m.name as `make`, f.name as `model`, qr.build_date, v.name as `variant`,
		qr.series, qr.body_type, qr.registration_type, qr.transmission, qr.colour, qr.fuel_type,
		qr.message, qr.created_at, qr.winner,qr.email_paragraph
		FROM quote_requests qr
		JOIN makes m ON qr.make = m.id_make
		JOIN families f ON qr.model = f.id_family
		LEFT JOIN vehicles v ON qr.variant = v.id_vehicle
		JOIN users a ON qr.fk_user = a.id_user
		WHERE 1 AND qr.deprecated <> 1
		AND qr.id_quote_request = ".$quote_request_id;
		return $this->db->query($query)->row_array();
	}
	
	public function get_quote_request_options ($quote_request_id)
	{	
		$query = "
		SELECT qro.id_quote_request_option, o.id_option, o.name, o.items
		FROM quote_request_options qro
		JOIN options o ON qro.fk_option = o.id_option
		WHERE qro.deprecated <> 1 AND qro.fk_quote_request = ".$quote_request_id." ORDER BY qro.id_quote_request_option ASC";
		$sql = $this->db->query($query);
		return $sql->result();
	}
	
	public function get_quote_request_accessories ($quote_request_id)
	{	
		$query = "
		SELECT id_quote_request_accessory, name, description
		FROM quote_request_accessories
		WHERE deprecated <> 1 AND fk_quote_request = ".$quote_request_id." ORDER BY id_quote_request_accessory ASC";
		$sql = $this->db->query($query);
		return $sql->result();
	}

	public function get_quote_option_prices($quote_id)
	{
		$query = "select * from quote_options where fk_quote = {$quote_id}";

		return $this->db->query($query)->result_array();
	}

	public function get_quote_accessories_prices($quote_id)
	{
		$query = "select * from quote_accessories where fk_quote = {$quote_id}";
		return $this->db->query($query)->result_array();
	}
	// ..FOR QUOTATION FORM //
	
	public function get_tender_dealers ($quote_request_id)
	{
		$query = "
		SELECT u.id_user AS `user_id`, u.name, u.abn, u.username as `email`, u.phone, u.mobile, u.state, u.postcode,da.is_primary_contact,
		(SELECT COUNT(DISTINCT fk_quote_request) FROM dealer_attributes WHERE fk_user = `user_id`) AS `tender_count`,
		(SELECT COUNT(1) FROM quotes WHERE fk_user = `user_id`) AS `quote_count`,
		(
			SELECT COUNT(DISTINCT fk_quote_request) FROM quotes q 
			JOIN quote_requests qr ON q.id_quote = qr.winner
			WHERE q.fk_user = `user_id`
		) AS `won_count`,
		(
			SELECT COUNT(1) FROM fq_accounts_new fa
			JOIN quote_requests qr ON fa.id_fq_account = qr.fk_lead
			JOIN quotes q  ON qr.winner = q.id_quote
			WHERE q.fk_user = `user_id` AND fa.status IN (5, 6, 7)
		) AS `order_count`
		FROM users u
		LEFT JOIN dealer_attributes da ON u.id_user = da.fk_user
		JOIN dealer_requests dr ON u.id_user = dr.fk_user
		WHERE dr.fk_quote_request = '".$this->db->escape_str($quote_request_id)."' GROUP BY u.id_user";
		return $this->db->query($query)->result_array();		
	}	
	
	public function get_tender_email_invites ($quote_request_id)
	{
		$query = "
		SELECT email, DATE(created_at) AS `invite_date`
		FROM email_invites
		WHERE fk_quote_request = '".$this->db->escape_str($quote_request_id)."'";
		return $this->db->query($query)->result_array();		
	}

	public function get_finished_quote_request ($quote_request_id, $quote_id)
	{
		$query = "
		SELECT
		q.id_quote, q.fk_quote_request, da.dealership_name as `dealer`, a.username as `email`, q.total, q.delivery_date, q.compliance_date, q.notes, q.created_at,
		if (qr.build_date = '', q.build_date, qr.build_date) as `build_date`,
		q.retail_price, q.predelivery, q.gst, q.stamp_duty, q.registration, q.premium_plate_fee, q.ctp,
		q.luxury_tax, q.fleet_discount, q.dealer_discount,
		m.name as `make`, f.name as `model`,
		qr.quote_number, qr.postcode, qr.series, qr.body_type, qr.colour, qr.transmission, qr.fuel_type,		
		qr.winner, a.name as `user`
		FROM quote_requests qr
		JOIN quotes q ON qr.winner = q.id_quote
		JOIN makes m ON qr.make = m.id_make
		JOIN families f ON qr.model = f.id_family
		JOIN users a ON qr.fk_user = a.id_user
		JOIN users u ON q.fk_user = u.id_user
		JOIN dealer_attributes da ON u.id_user = da.fk_user
		WHERE 1 AND q.deprecated <> 1 AND qr.deprecated <> 1
		AND qr.id_quote_request = ".$quote_request_id." AND q.id_quote = ".$quote_id;
		return $this->db->query($query)->row_array();
	}

	public function delete_quote_request ($quote_request_id)
	{
		$query = "UPDATE `quote_requests` SET `deprecated` = 1 WHERE `id_quote_request` = '".$quote_request_id."'";
		$sql = $this->db->query($query);	
	}

	public function get_files_lead ($id_quote_request)
	{
		
		$query = "
		SELECT
		u.name, u.username AS `email`, DATE(fa.created_at) AS `date_submitted`,
		fa.id_file_attachment, fa.file_name
		FROM file_attachments fa
		JOIN users u ON fa.fk_user = u.id_user
		WHERE fa.type = 5 
		AND fa.fk_main = '{$id_quote_request}'";

		return $this->db->query($query)->result_array();
	}

	public function get_files ($fk_main, $fk_user)
	{
		return $this->db->get_where('file_attachments', array('fk_main' => $fk_main, 'type' => 5, 'fk_user' => $fk_user))->result_array();
	}

	public function delete_file($params)
	{
		$this->load->helper('file');
		$fk_main = $params['fk_main'];
		$abspath = "./uploads/".$params['abspath'];
		$delete_file_q = "delete from file_attachments where id_file_attachment = {$fk_main}";

		if ($this->db->query($delete_file_q))
		{
			if (unlink($abspath))
			{
				return TRUE;
			}
		}
		return FALSE;
	}
}
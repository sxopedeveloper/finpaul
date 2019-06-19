<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quote_Model extends CI_Model {
	
	public function get_quote_all ($quote_id)
	{
		
		$query = "SELECT * FROM quotes WHERE id_quote = ".$quote_id;
		return $this->db->query($query)->row_array();	
		// $this->db->select('*');
		// $this->db->from('quotes');
		// $this->db->where('id_quote',$quote_id);
		// $query = $this->db->get();
		// return $this->db->query($query)->row_array();	
		
		
		// echo $query = "SELECT * FROM quotes WHERE id_quote = ".$quote_id; die();
		 // $this->db->query($query)->row_array();	
	// return $this->db->last_query(); 
	}	

	public function get_quote ($quote_id)
	{
		$query = "
		SELECT 
		q.id_quote, q.fk_quote_request,
		q.delivery_date, q.compliance_date, q.build_date, q.notes, q.created_at,
		da.dealership_name as `dealer`, u.name as `manager_name`, u.username, u.postcode, u.state,
		m.name as `make`, f.name as `model`, v.name as `variant`,
		qr.series, qr.body_type, qr.colour, qr.transmission, qr.fuel_type, qr.registration_type, qr.build_date as `qr_build_date`,
		q.retail_price, q.metallic_paint, q.fleet_discount, q.dealer_discount,
		q.predelivery, q.gst, q.luxury_tax, q.ctp, q.dealer_tradein_value, q.registration,
		q.premium_plate_fee, q.stamp_duty, q.total,	q.dealer_changeover,
		qr.winner, qr.accessories, q.accessories as accessories_price,
		q.build_date, q.compliance_date, q.demo, q.vin, q.engine, q.registration_plate, q.registration_expiry, q.kms
		FROM quotes q
		JOIN quote_requests qr ON q.fk_quote_request = qr.id_quote_request
		JOIN makes m ON qr.make = m.id_make
		JOIN families f ON qr.model = f.id_family
		LEFT JOIN vehicles v ON qr.variant = v.id_vehicle
		JOIN users u ON q.fk_user = u.id_user
		JOIN dealer_attributes da ON u.id_user = da.fk_user			
		WHERE 1 AND qr.deprecated <> 1 AND q.deprecated <> 1 
		AND q.id_quote = ".$quote_id." 
		GROUP BY q.id_quote LIMIT 1";		
		return $this->db->query($query)->row_array();
	}	
	
	function get_quotes ($params, $start, $limit)
	{
		$quote_number = isset($params['quote_number']) ? $params['quote_number'] : '';
		$client_name = isset($params['client_name']) ? $params['client_name'] : '';
		$client_email = isset($params['client_email']) ? $params['client_email'] : '';
		$quote_specialist = isset($params['quote_specialist']) ? $params['quote_specialist'] : '';
		
		$make = isset($params['make']) ? $params['make'] : '';
		$model = isset($params['family']) ? $params['family'] : '';
		$build_date = isset($params['build_date']) ? $params['build_date'] : '';
		$variant = isset($params['vehicle']) ? $params['vehicle'] : '';
		$series = isset($params['series']) ? $params['series'] : '';
		$body_type = isset($params['body_type']) ? $params['body_type'] : '';
		$colour = isset($params['colour']) ? $params['colour'] : '';
		$transmission = isset($params['transmission']) ? $params['transmission'] : '';
		$fuel_type = isset($params['fuel_type']) ? $params['fuel_type'] : '';
		$created_at = isset($params['created_at']) ? $params['created_at'] : '';
		
		$total = isset($params['total']) ? $params['total'] : '';
		
		$postcode = isset($params['postcode']) ? $params['postcode'] : '';
		$state = isset($params['state']) ? $params['state'] : '';
		
		$dealership_name = isset($params['dealership_name']) ? $params['dealership_name'] : '';
		$manager_name = isset($params['manager_name']) ? $params['manager_name'] : '';
		$username = isset($params['username']) ? $params['username'] : '';
		
		$winner = isset($params['winner']) ? $params['winner'] : '';
	
		$where = "";
		if ($quote_number <> "") { $where .= " AND qr.quote_number = '".$this->db->escape_str($quote_number)."' "; }
		if ($client_name <> "") { $where .= " AND qr.client_name = '".$this->db->escape_str($client_name)."' "; }
		if ($client_email <> "") { $where .= " AND qr.client_email = '".$this->db->escape_str($client_email)."' "; }
		if ($quote_specialist <> "") { $where .= " AND a.username = '".$this->db->escape_str($quote_specialist)."' "; }
		
		if ($make <> "") { $where .= " AND qr.make = ".$this->db->escape_str($make)." "; }
		if ($model <> "") { $where .= " AND qr.model = ".$this->db->escape_str($model)." "; }
		if ($build_date <> "") { $where .= " AND qr.build_date = SUBSTRING_INDEX('".$this->db->escape_str($build_date)."', '-', -1) "; }
		if ($variant <> "") { $where .= " AND qr.variant = ".$this->db->escape_str($variant)." "; }		
		if ($series <> "") { $where .= " AND qr.series = '".$this->db->escape_str($series)."' "; }
		if ($body_type <> "") { $where .= " AND qr.body_type = '".$this->db->escape_str($body_type)."' "; }
		if ($colour <> "") { $where .= " AND qr.colour = '".$this->db->escape_str($colour)."' "; }
		if ($transmission <> "") { $where .= " AND qr.transmission = '".$this->db->escape_str($transmission)."' "; }
		if ($fuel_type <> "") { $where .= " AND qr.fuel_type = '".$this->db->escape_str($fuel_type)."' "; }		
		if ($created_at <> "") { $where .= " AND qr.created_at = '".$this->db->escape_str($created_at)."' "; }

		if ($total <> "") { $where .= " AND q.total = '".$this->db->escape_str($total)."' "; }
		
		if ($postcode <> "") { $where .= " AND u.postcode = '".$this->db->escape_str($postcode)."' "; }
		if ($state <> "") { $where .= " AND u.state = '".$this->db->escape_str($state)."' "; }

		if ($dealership_name <> "") { $where .= " AND da.dealership_name = '".$this->db->escape_str($dealership_name)."' "; }
		if ($manager_name <> "") { $where .= " AND u.name = '".$this->db->escape_str($manager_name)."' "; }
		if ($username <> "") { $where .= " AND u.username = '".$this->db->escape_str($username)."' "; }
		
		if ($winner <> "") 
		{ 
			if ($winner == 1)
			{
				$where .= " AND q.id_quote IN (SELECT DISTINCT winner FROM quote_requests) "; 
			}
		}

		$query = "
		SELECT 
		q.id_quote, q.id_quote as `quote_id`, 
		q.sender, q.delivery_date, q.retail_price as `list_price`, q.total, q.created_at,
		
		l.id_lead, qr.id_quote_request,
		
		(SELECT COUNT(1) FROM quote_requests WHERE winner = `quote_id`) AS `winner`,
		
		m.name as `make`, f.name as `model`, qr.build_date, v.name as `variant`,
		
		a.username as `quote_specialist`,
		
		qr.quote_number, qr.client_name, qr.client_email, qr.postcode,
		qr.series, qr.body_type, qr.colour, qr.transmission, qr.fuel_type, qr.registration_type,
		
		da.dealership_name as `dealer`, u.state, u.name as `manager_name`, u.mobile as `manager_mobile`, u.phone as `manager_phone`, u.username
		
		FROM quotes q
		JOIN quote_requests qr ON q.fk_quote_request = qr.id_quote_request
		JOIN leads l ON qr.fk_lead = l.id_lead
		JOIN makes m ON qr.make = m.id_make
		JOIN families f ON qr.model = f.id_family
		LEFT JOIN vehicles v ON qr.variant = v.id_vehicle
		JOIN users a ON qr.fk_user = a.id_user
		JOIN users u ON q.fk_user = u.id_user
		JOIN dealer_attributes da ON u.id_user = da.fk_user
		WHERE 1 AND qr.deprecated <> 1 AND q.deprecated <> 1
		" . $where . " ORDER BY q.total ASC
		LIMIT ".$start.", ".$limit;
		return $this->db->query($query)->result_array();
	}
	
	function get_quotes_count ($params)
	{
		$quote_number = isset($params['quote_number']) ? $params['quote_number'] : '';
		$client_name = isset($params['client_name']) ? $params['client_name'] : '';
		$client_email = isset($params['client_email']) ? $params['client_email'] : '';
		$quote_specialist = isset($params['quote_specialist']) ? $params['quote_specialist'] : '';
		
		$make = isset($params['make']) ? $params['make'] : '';
		$model = isset($params['family']) ? $params['family'] : '';
		$build_date = isset($params['build_date']) ? $params['build_date'] : '';
		$variant = isset($params['vehicle']) ? $params['vehicle'] : '';
		$series = isset($params['series']) ? $params['series'] : '';
		$body_type = isset($params['body_type']) ? $params['body_type'] : '';
		$colour = isset($params['colour']) ? $params['colour'] : '';
		$transmission = isset($params['transmission']) ? $params['transmission'] : '';
		$fuel_type = isset($params['fuel_type']) ? $params['fuel_type'] : '';
		$created_at = isset($params['created_at']) ? $params['created_at'] : '';
		
		$total = isset($params['total']) ? $params['total'] : '';
		
		$postcode = isset($params['postcode']) ? $params['postcode'] : '';
		$state = isset($params['state']) ? $params['state'] : '';
		
		$dealership_name = isset($params['dealership_name']) ? $params['dealership_name'] : '';
		$manager_name = isset($params['manager_name']) ? $params['manager_name'] : '';
		$username = isset($params['username']) ? $params['username'] : '';
		
		$winner = isset($params['winner']) ? $params['winner'] : '';
	
		$where = "";
		if ($quote_number <> "") { $where .= " AND qr.quote_number = '".$this->db->escape_str($quote_number)."' "; }
		if ($client_name <> "") { $where .= " AND qr.client_name = '".$this->db->escape_str($client_name)."' "; }
		if ($client_email <> "") { $where .= " AND qr.client_email = '".$this->db->escape_str($client_email)."' "; }
		if ($quote_specialist <> "") { $where .= " AND a.username = '".$this->db->escape_str($quote_specialist)."' "; }
		
		if ($make <> "") { $where .= " AND qr.make = ".$this->db->escape_str($make)." "; }
		if ($model <> "") { $where .= " AND qr.model = ".$this->db->escape_str($model)." "; }
		if ($build_date <> "") { $where .= " AND qr.build_date = SUBSTRING_INDEX('".$this->db->escape_str($build_date)."', '-', -1) "; }
		if ($variant <> "") { $where .= " AND qr.variant = ".$this->db->escape_str($variant)." "; }
		if ($series <> "") { $where .= " AND qr.series = '".$this->db->escape_str($series)."' "; }
		if ($body_type <> "") { $where .= " AND qr.body_type = '".$this->db->escape_str($body_type)."' "; }
		if ($colour <> "") { $where .= " AND qr.colour = '".$this->db->escape_str($colour)."' "; }
		if ($transmission <> "") { $where .= " AND qr.transmission = '".$this->db->escape_str($transmission)."' "; }
		if ($fuel_type <> "") { $where .= " AND qr.fuel_type = '".$this->db->escape_str($fuel_type)."' "; }		
		if ($created_at <> "") { $where .= " AND qr.created_at = '".$this->db->escape_str($created_at)."' "; }

		if ($total <> "") { $where .= " AND q.total = '".$this->db->escape_str($total)."' "; }
		
		if ($postcode <> "") { $where .= " AND u.postcode = '".$this->db->escape_str($postcode)."' "; }
		if ($state <> "") { $where .= " AND u.state = '".$this->db->escape_str($state)."' "; }
		
		if ($dealership_name <> "") { $where .= " AND da.dealership_name = '".$this->db->escape_str($dealership_name)."' "; }
		if ($manager_name <> "") { $where .= " AND u.name = '".$this->db->escape_str($manager_name)."' "; }
		if ($username <> "") { $where .= " AND u.username = '".$this->db->escape_str($username)."' "; }
		
		if ($winner <> "")
		{ 
			if ($winner == 1)
			{
				$where .= " AND q.id_quote IN (SELECT DISTINCT winner FROM quote_requests) "; 
			}
		}

		$query = "
		SELECT COUNT(1) AS cnt
		FROM quotes q
		JOIN quote_requests qr ON q.fk_quote_request = qr.id_quote_request
		JOIN makes m ON qr.make = m.id_make
		JOIN families f ON qr.model = f.id_family
		LEFT JOIN vehicles v ON qr.variant = v.id_vehicle		
		JOIN users a ON qr.fk_user = a.id_user
		JOIN users u ON q.fk_user = u.id_user
		JOIN dealer_attributes da ON u.id_user = da.fk_user
		WHERE 1 AND qr.deprecated <> 1 AND q.deprecated <> 1 " . $where;
		return $this->db->query($query)->row_array();
	}	
	
	public function insert_quotation ($quote_request_id, $user_id, $input_arr)
	{
		$now = date("Y-m-d g:i:s");
		
		if (!isset($input_arr['transport_checkbox']))
		{
			$input_arr['transport_checkbox'] = "";
		}		
		/*// '".$this->db->escape_str($input_arr['demo'])."',*/
		$query = "
		INSERT INTO `quotes`
		(
			fk_quote_request, 
			fk_user, 
			status, 
			sender, 
			demo,
			gst, 
			total, 
			dealer_tradein_value, 
			dealer_tradein_payout, 
			dealer_client_refund, 
			dealer_changeover,
			retail_price, 
			metallic_paint, 
			predelivery, 
			fleet_discount, 
			dealer_discount, 
			stamp_duty, 
			registration, 
			premium_plate_fee, 
			ctp, luxury_tax, 
			delivery_date, 
			compliance_date, 
			notes, 
			vin, 
			engine, 
			registration_plate,
			registration_expiry, 
			kms, 
			transport_checkbox,

			sender_new,
			quoted_price,
			on_road,
			car_off_road,
			dealer_notes,
			make,
			modal,
			rb_data,
			created_at
		)
		VALUES 
		(
			

			'".$quote_request_id."', '".$user_id."', 
			1, 
			'".$this->db->escape_str($input_arr['sender'])."', 
			'',		
			'".$this->db->escape_str($input_arr['gst'])."', 
			'".$this->db->escape_str($input_arr['total'])."', 
			'".$this->db->escape_str($input_arr['dealer_tradein_value'])."', 
			'".$this->db->escape_str($input_arr['dealer_tradein_payout'])."',
			'".$this->db->escape_str($input_arr['dealer_client_refund'])."',		
			'".$this->db->escape_str($input_arr['dealer_changeover'])."',			
			'".$this->db->escape_str($input_arr['retail_price'])."', 
			'".$this->db->escape_str($input_arr['metallic_paint'])."', 
			'".$this->db->escape_str($input_arr['predelivery'])."', 
			'".$this->db->escape_str($input_arr['fleet_discount'])."', 
			'".$this->db->escape_str($input_arr['dealer_discount'])."', 
			'".$this->db->escape_str($input_arr['stamp_duty'])."', 
			'".$this->db->escape_str($input_arr['registration'])."', 
			'".$this->db->escape_str($input_arr['premium_plate_fee'])."', 
			'".$this->db->escape_str($input_arr['ctp'])."', 
			'".$this->db->escape_str($input_arr['luxury_tax'])."',
			'".$this->db->escape_str($input_arr['delivery_date'])."', 
			'".$this->db->escape_str($input_arr['compliance_date'])."',			
			'".$this->db->escape_str($input_arr['notes'])."',
			'".$this->db->escape_str($input_arr['vin'])."',
			'".$this->db->escape_str($input_arr['engine'])."',
			'".$this->db->escape_str($input_arr['registration_plate'])."',
			'".$this->db->escape_str($input_arr['registration_expiry'])."',
			'".$this->db->escape_str($input_arr['kms'])."',			
			'".$this->db->escape_str($input_arr['transport_checkbox'])."',

			'".$this->db->escape_str($input_arr['sender_new'])."',
			'".$this->db->escape_str($input_arr['quoted_price'])."',
			'".$this->db->escape_str($input_arr['on_road'])."',
			'".$this->db->escape_str($input_arr['car_off_road'])."',
			'".$this->db->escape_str($input_arr['dealer_notes'])."',
			'".$this->db->escape_str($input_arr['make'])."',
			'".$this->db->escape_str($input_arr['modal'])."',
			'".$this->db->escape_str($input_arr['rb_data'])."',
			'".$now."'
		)";

		$result = $this->db->query($query);
		
		if ($result)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}
	}

	public function update_quotation ($quote_id, $input_arr)
	{
		$now = date("Y-m-d g:i:s");
		
		if (!isset($input_arr['transport_checkbox']))
		{
			$input_arr['transport_checkbox'] = "";
		}

		$update_arr = [
			'gst'                   => $input_arr['gst'],
			'total'                 => $input_arr['total'],
			'dealer_tradein_value'  => $input_arr['dealer_tradein_value'],
			'dealer_tradein_payout' => $input_arr['dealer_tradein_payout'],
			'dealer_client_refund'  => $input_arr['dealer_client_refund'],			
			'dealer_changeover'     => $input_arr['dealer_changeover'],
			
			'retail_price'          => $input_arr['retail_price'],
			'metallic_paint'		=> $input_arr['metallic_paint'],
			'predelivery'           => $input_arr['predelivery'],
			'fleet_discount'        => $input_arr['fleet_discount'],
			'dealer_discount'       => $input_arr['dealer_discount'],
			
			'stamp_duty'            => $input_arr['stamp_duty'],
			'registration'          => $input_arr['registration'],
			'premium_plate_fee'     => $input_arr['premium_plate_fee'],
			'ctp'                   => $input_arr['ctp'],
			'luxury_tax'            => $input_arr['luxury_tax'],
			
			'delivery_date'         => $input_arr['delivery_date'],
			'compliance_date'       => $input_arr['compliance_date'],
			
			'notes'                 => $input_arr['notes'],
			'vin'                   => $input_arr['vin'],
			'engine'                => $input_arr['engine'],
			'registration_plate'    => $input_arr['registration_plate'],
			'registration_expiry'   => $input_arr['registration_expiry'],
			'kms'                   => $input_arr['kms'],
			'transport_checkbox'    => $input_arr['transport_checkbox']
		];

		$this->db->where('id_quote', $quote_id);
		$this->db->update('quotes', $update_arr);

		return $input_arr['total'];
	}
	
	public function update_quote_seen_status ($quote_id, $status)
	{
		$query = "UPDATE quotes SET seen_status = '".$status."' WHERE id_quote = ".$quote_id;
		return $this->db->query($query);		
	}
	
	public function update_quote_total ($quote_id, $gst, $total, $dealer_changeover, $status_change)
	{
		$status_change_q = "";
		if ($status_change==1) 
		{
			$status_change_q .= " status = 0, "; 
		}

		$query = "UPDATE quotes SET ".$status_change_q." gst = '".$gst."', total = '".$total."', dealer_changeover = '".$dealer_changeover."' WHERE id_quote = ".$quote_id;
		$sql = $this->db->query($query);
	}	
	
	public function delete_quote ($quote_id)
	{
		$query = "UPDATE `quotes` SET `deprecated` = 1 WHERE `id_quote` = ".$quote_id;
		return $this->db->query($query);
	}
	
	function change_carOnroad ($array){		
		$this->db->where('id_quote', $array['id_quote']);
		$this->db->update('quotes', array('on_road' => $array['car_onroad']));
		return ($this->db->affected_rows() > 0);
	}


	
	function change_carOffroad ($array){		
		$this->db->where('id_quote', $array['id_quote']);
		$this->db->update('quotes', array('car_off_road' => $array['off_road']));
		return ($this->db->affected_rows() > 0);
	}
	
	function change_dealer_notes ($array){		
		$this->db->where('id_quote', $array['id_quote']);
		$this->db->update('quotes', array('dealer_notes' => $array['dealer_notes']));
		return ($this->db->affected_rows() > 0);
	}
    
    function change_delivery_date ($array){		
		$this->db->where('id_quote', $array['id_quote']);
		$this->db->update('quotes', array('delivery_date' => date("Y-m-d", strtotime($array['d_date'])) ));
		return ($this->db->affected_rows() > 0);
	}

	public function insert_quotation_option ($quote_id, $quote_request_option_id, $price)
	{
		$now = date("Y-m-d g:i:s");
		$query = "
		INSERT INTO `quote_options` 
		(fk_quote, fk_request_option, code, price, created_at) 
		VALUES 
		('".$quote_id."', '".$quote_request_option_id."', CONCAT('".$quote_id."', '-', '".$quote_request_option_id."'), '".$this->db->escape_str($price)."', '".$now."')";
		return $this->db->query($query);
	}

	public function update_quotation_option ($quote_id, $quote_request_option_id, $price)
	{
		$query = "
		UPDATE `quote_options` SET price = '".$this->db->escape_str($price)."'
		WHERE fk_quote = '".$this->db->escape_str($quote_id)."' AND fk_request_option = '".$this->db->escape_str($quote_request_option_id)."'";
		return $this->db->query($query);		
	}
	
	public function reinsert_quotation_option ($quote_id, $quote_request_option_id)
	{
		$now = date("Y-m-d g:i:s");
		$query = "
		INSERT INTO `quote_options`
		(fk_quote, fk_request_option, code, price, deprecated, created_at)
		VALUES ('".$quote_id."', '".$quote_request_option_id."', CONCAT('".$quote_id."', '-', '".$quote_request_option_id."'), '0.00', 0, '".$now."')
		ON DUPLICATE KEY UPDATE
		deprecated = 0";
		return $this->db->query($query);
	}

	public function insert_quotation_accessory ($quote_id, $quote_request_accessory_id, $price)
	{
		$now = date("Y-m-d g:i:s");
		$query = "
		INSERT INTO `quote_accessories` (fk_quote, fk_request_accessory, code, price, created_at)
		VALUES ('".$quote_id."', '".$quote_request_accessory_id."', CONCAT('".$quote_id."', '-', '".$quote_request_accessory_id."'), 
		'".$this->db->escape_str($price)."', '".$now."')";
		return $this->db->query($query);	
	}

	public function update_quotation_accessory ($quote_id, $quote_request_accessory_id, $price)
	{
		$query = "
		UPDATE `quote_accessories` SET price = '".$this->db->escape_str($price)."'
		WHERE fk_quote = '".$this->db->escape_str($quote_id)."' AND fk_request_accessory = '".$this->db->escape_str($quote_request_accessory_id)."'";
		return $this->db->query($query);	
	}
	
	public function reinsert_quotation_accessory ($quote_id, $quote_request_accessory_id)
	{
		$now = date("Y-m-d g:i:s");
		$query = "
		INSERT INTO `quote_accessories`
		(fk_quote, fk_request_accessory, code, price, created_at)
		VALUES ('".$quote_id."', '".$quote_request_accessory_id."', CONCAT('".$quote_id."', '-', '".$quote_request_accessory_id."'), '0.00', '".$now."')
		ON DUPLICATE KEY UPDATE
		deprecated = 0";
		return $this->db->query($query);	
	}	

	public function get_quote_options_array ($quote_id, $user_id = 0)
	{
		$user_query = "";
		if ($user_id <> 0) { $user_query .= " AND q.fk_user = ".$user_id." "; }
	
		$query = "
		SELECT qo.fk_quote, qo.fk_request_option, qo.price 
		FROM quote_options qo
		JOIN quotes q ON qo.fk_quote = q.id_quote
		WHERE 1 AND qo.deprecated <> 1
		AND qo.fk_quote = ".$quote_id." ".$user_query." ORDER BY qo.fk_request_option ASC";
		$sql = $this->db->query($query);
		return $sql->result_array();	
	}

	public function get_quote_accessories_array ($quote_id, $user_id = 0)
	{
		$user_query = "";
		if ($user_id <> 0) { $user_query .= " AND q.fk_user = ".$user_id." "; }
	
		$query = "
		SELECT qa.fk_quote, qa.fk_request_accessory, qa.price 
		FROM quote_accessories qa
		JOIN quotes q ON qa.fk_quote = q.id_quote
		WHERE 1 AND qa.deprecated <> 1
		AND qa.fk_quote = ".$quote_id." ".$user_query." ORDER BY qa.fk_request_accessory ASC";
		$sql = $this->db->query($query);
		return $sql->result_array();
	}	
	
	
	
	
	

	public function insert_quotation_backup ($quote_request_id, $user_id, $registration_type, $sender, $retail_price, $metallic_paint, $options_total, $accessories_total, $predelivery, $fleet_discount, $dealer_discount, $gst, $stamp_duty, $registration, $premium_plate_fee, $ctp, $dealer_tradein_value, $luxury_tax, $delivery_date, $build_date, $compliance_date, $notes, $post_data, $transport_checkbox = "No")
	{
		$now = date("Y-m-d g:i:s");
		
		if ($registration_type=="Exempt" OR $registration_type=="TPI/Gold Card")
		{
			$gst = 0;
			$stamp_duty = 0;
		}
		else
		{
			$gst = ($retail_price + $metallic_paint + $options_total + $accessories_total + $predelivery - $fleet_discount - $dealer_discount) * 0.10;
		}

		$total = $retail_price + $metallic_paint + $options_total + $accessories_total + $predelivery + $gst + $stamp_duty + $registration + $premium_plate_fee + $ctp + $luxury_tax - $fleet_discount - $dealer_discount;
		$dealer_changeover = $total - $dealer_tradein_value + $post_data['dealer_tradein_payout'] + $post_data['dealer_client_refund'];
		
		$query = "
		INSERT INTO `quotes`
		(fk_quote_request, fk_user, status, sender, total, dealer_changeover,
		retail_price, metallic_paint, predelivery, 
		fleet_discount, dealer_discount, gst, stamp_duty, 
		registration, premium_plate_fee, ctp, dealer_tradein_value, luxury_tax, 
		delivery_date, build_date, compliance_date, 
		notes, created_at, demo, vin, engine, registration_plate, registration_expiry, kms, transport_checkbox, dealer_tradein_payout, dealer_client_refund)
		VALUES (
		'".$quote_request_id."', '".$user_id."', 1, '".$this->db->escape_str($sender)."', '".$total."', '".$dealer_changeover."',
		'".$this->db->escape_str($retail_price)."', '".$this->db->escape_str($metallic_paint)."', '".$this->db->escape_str($predelivery)."', 
		'".$this->db->escape_str($fleet_discount)."', '".$this->db->escape_str($dealer_discount)."', '".$this->db->escape_str($gst)."', 
		'".$this->db->escape_str($stamp_duty)."', '".$this->db->escape_str($registration)."', '".$this->db->escape_str($premium_plate_fee)."', 
		'".$this->db->escape_str($ctp)."', '".$this->db->escape_str($dealer_tradein_value)."', 
		'".$this->db->escape_str($luxury_tax)."',
		'".$this->db->escape_str($delivery_date)."', '".$this->db->escape_str($build_date)."', '".$this->db->escape_str($compliance_date)."', 
		'".$this->db->escape_str($notes)."', '".$now."',
		'".$this->db->escape_str($post_data['demo'])."', 
		'".$this->db->escape_str($post_data['vin'])."',
		'".$this->db->escape_str($post_data['engine'])."',
		'".$this->db->escape_str($post_data['registration_plate'])."',
		'".$this->db->escape_str($post_data['registration_expiry'])."',
		'".$this->db->escape_str($post_data['kms'])."',
		'".$this->db->escape_str($transport_checkbox)."',
		'".$this->db->escape_str($post_data['dealer_tradein_payout'])."',
		'".$this->db->escape_str($post_data['dealer_client_refund'])."'
		)
		";

		$sql = $this->db->query($query);

		return $total;
	}

	public function update_quotation_backup ($quote_request_id, $user_id, $registration_type, $sender, $retail_price, $metallic_paint, $options_total, $accessories_total, $predelivery, $fleet_discount, $dealer_discount, $gst, $stamp_duty, $registration, $premium_plate_fee, $ctp, $dealer_tradein_value, $luxury_tax, $delivery_date, $build_date, $compliance_date, $notes, $post_data, $transport_checkbox = "No")
	{
		$now = date("Y-m-d g:i:s");
		
		if ($registration_type=="Exempt" OR $registration_type=="TPI/Gold Card")
		{
			$gst = 0;
			$stamp_duty = 0;
		}
		else
		{
			$gst = ($retail_price + $metallic_paint + $options_total + $accessories_total + $predelivery - $fleet_discount - $dealer_discount) * 0.10;
		}

		$total = $retail_price + $metallic_paint + $options_total + $accessories_total + $predelivery + $gst + $stamp_duty + $registration + $premium_plate_fee + $ctp + $luxury_tax - $fleet_discount - $dealer_discount;
		$dealer_changeover = $total - $dealer_tradein_value + $post_data['dealer_tradein_payout'] + $post_data['dealer_client_refund'];

		$update_data = [
			'total'                 => $total,
			'dealer_changeover'     => $dealer_changeover,
			'retail_price'          => $retail_price,
			'metallic_paint'		=> $metallic_paint,
			'predelivery'           => $predelivery,
			'fleet_discount'        => $fleet_discount,
			'dealer_discount'       => $dealer_discount,
			'gst'                   => $gst,
			'stamp_duty'            => $stamp_duty,
			'registration'          => $registration,
			'premium_plate_fee'     => $premium_plate_fee,
			'ctp'                   => $ctp,
			'dealer_tradein_value'  => $dealer_tradein_value,
			'luxury_tax'            => $luxury_tax,
			'delivery_date'         => $delivery_date,
			'build_date'            => $build_date,
			'compliance_date'       => $compliance_date,
			'notes'                 => $notes,
			'vin'                   => $post_data['vin'],
			'engine'                => $post_data['engine'],
			'registration_plate'    => $post_data['registration_plate'],
			'registration_expiry'   => $post_data['registration_expiry'],
			'kms'                   => $post_data['kms'],
			'transport_checkbox'    => $transport_checkbox,
			'dealer_tradein_payout' => $post_data['dealer_tradein_payout'],
			'dealer_client_refund'  => $post_data['dealer_client_refund']
		];

		$this->db->where('id_quote', $post_data['hidden_quote_id_sub']);
		$this->db->update('quotes', $update_data);

		return $total;
	}	
	
	public function get_options_total ($quote_id)
	{
		$query = "SELECT SUM(price) AS price_total FROM quote_options WHERE fk_quote = ".$quote_id." AND deprecated <> 1";
		return $this->db->query($query)->row_array();	
	}

	public function get_accessories_total ($quote_id)
	{
		$query = "SELECT SUM(price) AS price_total FROM quote_accessories WHERE fk_quote = ".$quote_id." AND deprecated <> 1";
		return $this->db->query($query)->row_array();	
	}

	public function get_quotes_final ($quote_request_id, $user_id = 0)
	{
		$user_query = "";
		if ($user_id <> 0) 
		{
			$user_query .= " AND q.fk_user = ".$user_id." "; 
		}
	
		$query = "
		SELECT
		l.status as `lead_status`,
		q.status,
		q.sender, q.id_quote, da.dealership_name, u.name as `manager_name`, u.username,
		u.mobile as `manager_mobile`, u.phone as `manager_phone`, u.postcode, u.state,
		q.delivery_date, q.compliance_date, q.build_date,
		q.retail_price, q.fleet_discount, q.dealer_discount,
		qr.accessories, q.accessories as `accessories_price`,
		q.predelivery, q.gst, q.luxury_tax, q.ctp, q.registration,
		q.premium_plate_fee, q.stamp_duty, q.total, q.notes, q.created_at, q.demo, q.vin, q.engine, q.registration_expiry, q.registration_plate, q.kms
		FROM quotes q
		JOIN quote_requests qr ON q.fk_quote_request = qr.id_quote_request
		LEFT JOIN leads l ON qr.fk_lead = l.id_lead
		JOIN users a ON qr.fk_user = a.id_user
		JOIN users u ON q.fk_user = u.id_user
		JOIN dealer_attributes da ON u.id_user = da.fk_user
		WHERE 1 AND qr.deprecated <> 1 AND q.deprecated <> 1
		AND q.fk_quote_request = ".$quote_request_id." ".$user_query." ORDER BY q.id_quote ASC";
		$sql = $this->db->query($query);
		return $sql->result();
	}
	
	public function get_dealer_existing_quote ($user_id, $quote_request_id, $demo)
	{
		$query = "
		SELECT COUNT(1) AS `cnt`
		FROM quotes WHERE deprecated <> 1 AND fk_user = '".$this->db->escape_str($user_id)."' 
		AND fk_quote_request = '".$this->db->escape_str($quote_request_id)."' 
		AND demo = '".$this->db->escape_str($demo)."'";
		return $this->db->query($query)->row_array();		
	}	
	
	public function get_tender_quotes ($quote_request_id)
	{
		$query = "
		SELECT 
		q.id_quote, qr.id_quote_request, q.status, q.seen_status, u.name, u.state, u.username AS `email`, q.sender, q.retail_price, q.total, 
		q.sender_new, q.quoted_price, q.on_road, q.car_off_road, q.dealer_notes, q.delivery_date_time, q.delivery_date, q.quote_file,
		DATE(q.created_at) AS `date_submitted`, qr.winner, q.demo, u.id_user as `dealer_id`
		FROM quotes q 
		JOIN quote_requests qr ON q.fk_quote_request = qr.id_quote_request
		JOIN users u ON q.fk_user = u.id_user
		WHERE q.deprecated <> 1 AND q.fk_quote_request = '".$this->db->escape_str($quote_request_id)."'
		ORDER BY q.created_at DESC";

		return $this->db->query($query)->result_array();
	}
	
	public function get_tender_quotes_delivery ($quote_request_id)
	{
		$query = "
		SELECT 
		q.id_quote, qr.id_quote_request, q.status, q.seen_status, u.name, u.state, u.username AS `email`, q.sender, q.retail_price, q.total, 
		q.sender_new, q.quoted_price, q.on_road, q.car_off_road, q.dealer_notes, q.delivery_date_time, q.delivery_date, q.quote_file,
		DATE(q.created_at) AS `date_submitted`, qr.winner, q.demo, u.id_user as `dealer_id`
		FROM quotes q 
		JOIN quote_requests qr ON q.fk_quote_request = qr.id_quote_request
		JOIN users u ON q.fk_user = u.id_user
		WHERE q.deprecated <> 1 AND q.fk_quote_request = '".$this->db->escape_str($quote_request_id)."' AND q.id_quote=qr.winner
		ORDER BY q.created_at DESC";

		return $this->db->query($query)->row_array();
	}
	
	public function get_tender_same_variant_quotes ($quote_request_id, $make_id, $family_id, $vehicle_id)
	{	
		$now = date("Y-m-d g:i:s");
		
		$query = "
		SELECT 
		q.`id_quote`,
		
		qr.`id_quote_request`,
		
		fa.`id_fq_account`,
		fa.`id_fq_account` AS `lead_id`,
		(SELECT COUNT(1) FROM tradeins WHERE fk_lead = `lead_id`) AS `tradein_count`,
		
		u.`id_user` as `dealer_id`,
		u.`name`, u.username AS `email`, 
		
		q.demo, q.retail_price, q.total, qr.winner,
		DATEDIFF('".$now."', q.created_at) AS `date_submitted`
		
		FROM quotes q
		JOIN quote_requests qr ON q.fk_quote_request = qr.id_quote_request
		JOIN fq_accounts_new fa ON qr.fk_lead = fa.id_fq_account
		JOIN users u ON q.fk_user = u.id_user
		WHERE q.deprecated <> 1
		AND qr.id_quote_request <> '".$this->db->escape_str($quote_request_id)."' 
		AND qr.make = '".$this->db->escape_str($make_id)."' AND qr.model = '".$this->db->escape_str($family_id)."' AND qr.variant = '".$this->db->escape_str($vehicle_id)."'
		GROUP BY q.id_quote
		ORDER BY q.total ASC, q.created_at DESC LIMIT 10";
		return $this->db->query($query)->result_array();
	}
	
	public function get_tender_same_model_quotes ($quote_request_id, $make_id, $family_id, $vehicle_id)
	{
		$now = date("Y-m-d g:i:s");
		
		$query = "
		SELECT
		q.`id_quote`, 
		
		qr.`id_quote_request`,
		
		fa.`id_fq_account`,
		fa.`id_fq_account` AS `lead_id`,
		(SELECT COUNT(1) FROM tradeins WHERE fk_lead = `lead_id`) AS `tradein_count`,		
		
		v.name AS `variant`,

		u.`id_user` as `dealer_id`,
		u.`name`, u.username AS `email`, 
		
		q.demo, q.retail_price, q.total, qr.winner,
		DATEDIFF('".$now."', q.created_at) AS `date_submitted`		
		
		FROM quotes q 
		JOIN quote_requests qr ON q.fk_quote_request = qr.id_quote_request
		JOIN fq_accounts_new fa ON qr.fk_lead = fa.id_fq_account
		LEFT JOIN vehicles v ON qr.variant = v.id_vehicle
		JOIN users u ON q.fk_user = u.id_user
		WHERE q.deprecated <> 1
		AND qr.id_quote_request <> '".$this->db->escape_str($quote_request_id)."'
		AND qr.make = '".$this->db->escape_str($make_id)."' AND qr.model = '".$this->db->escape_str($family_id)."' AND qr.variant <> '".$this->db->escape_str($vehicle_id)."'
		GROUP BY q.id_quote
		ORDER BY q.total ASC, q.created_at DESC LIMIT 10";
		return $this->db->query($query)->result_array();
	}
	
	public function get_quote_options ($quote_request_id, $user_id = 0)
	{
		$user_query = "";
		if ($user_id <> 0) { $user_query .= " AND q.fk_user = ".$user_id." "; }
	
		$query = "
		SELECT qo.fk_quote, qo.price FROM quote_options qo
		JOIN quotes q ON qo.fk_quote = q.id_quote
		WHERE 1 AND qo.deprecated <> 1 AND q.fk_quote_request = ".$quote_request_id." ".$user_query." ORDER BY qo.id_quote_option ASC";
		$sql = $this->db->query($query);
		return $sql->result();
	}
	
	public function get_quote_accessories ($quote_request_id, $user_id = 0)
	{
		$user_query = "";
		if ($user_id <> 0) { $user_query .= " AND q.fk_user = ".$user_id." "; }
	
		$query = "
		SELECT qa.fk_quote, qa.price FROM quote_accessories qa
		JOIN quotes q ON qa.fk_quote = q.id_quote
		WHERE 1 AND qa.deprecated <> 1 AND q.fk_quote_request = ".$quote_request_id." ".$user_query." ORDER BY qa.id_quote_accessory ASC";
		$sql = $this->db->query($query);
		return $sql->result();
	}	

	public function get_quote_lead_id ($quote_id)
	{	
		$query = "
		SELECT l.id_lead
		FROM leads l
		JOIN quote_requests qr ON l.id_lead = qr.fk_lead
		JOIN quotes q ON qr.id_quote_request = q.fk_quote_request
		WHERE q.id_quote = ".$quote_id;
		return $this->db->query($query)->row_array();
	}

	/**
	 * @param $table_name
	 * @param $data_array
	 * @param $where_array
	 * @return mixed
	 */
	function update($table_name,$data_array,$where_array){
		$this->db->where($where_array);
		$rs = $this->db->update($table_name, $data_array);
		return $rs;
	}

	/**
	 * @param $table
	 * @param $id_column
	 * @param $column
	 * @param $column_val
	 * @return null
	 */
	function get_id_by_val($table,$id_column,$column,$column_val){
		$this->db->select($id_column);
		$this->db->from($table);
		$this->db->where($column,$column_val);
		$this->db->limit('1');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row()->$id_column;
		} else {
			return null;
		}
	}
}


<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_Model extends CI_Model {

	public $date_format = "DATE_FORMAT(row_date, '%d/%m/%Y %H:%i:%S')";
	
	public $revenue_threshold = 1000;
	
	public $revenue_query = "
	IF (tv.`fk_user` = 282,
		l.sales_price - l.tradein_given + l.tradein_payout - q.dealer_changeover - l.transport_cost - l.other_costs_amount + l.aftersales_accessory_revenue + l.other_qs_revenue_amount + l.other_revenue_amount,
		l.sales_price + (l.tradein_value - l.tradein_given) - q.total - l.transport_cost - l.other_costs_amount + l.aftersales_accessory_revenue + l.other_qs_revenue_amount + l.other_revenue_amount
	)";
		
	public $balcqo_query = "
	IF (l.`deduct_to_dealer_invoice` = 1,
		IF (tv.`fk_user` = 282, 
			l.sales_price - l.tradein_given + l.tradein_payout - q.dealer_changeover - l.transport_cost - l.other_costs_amount + l.aftersales_accessory_revenue + l.other_qs_revenue_amount + l.other_revenue_amount,
			l.sales_price + (l.tradein_value - l.tradein_given) - q.total - l.transport_cost - l.other_costs_amount + l.aftersales_accessory_revenue + l.other_qs_revenue_amount + l.other_revenue_amount
		),
		IF (tv.`fk_user` = 282, 
			l.sales_price - l.tradein_given + l.tradein_payout - q.dealer_changeover - l.transport_cost - l.other_costs_amount + l.aftersales_accessory_revenue + l.other_qs_revenue_amount + l.other_revenue_amount,
			l.sales_price + (l.tradein_value - l.tradein_given) - q.total - l.transport_cost - l.other_costs_amount + l.aftersales_accessory_revenue + l.other_qs_revenue_amount + l.other_revenue_amount
		) + l.other_costs_amount		
	)";

	public $commissionable_gross_query = "
	IF (tv.`fk_user` = 282,
		(
			(
				(
					l.sales_price - l.tradein_given + l.tradein_payout - q.dealer_changeover - l.transport_cost - l.other_costs_amount - 
					IF (
						(l.sales_price - l.tradein_given + l.tradein_payout - q.dealer_changeover - l.transport_cost - l.other_costs_amount + l.aftersales_accessory_revenue + l.other_qs_revenue_amount + l.other_revenue_amount) <= 1000,
						l.gross_subtractor_lower, 
						l.gross_subtractor
					) + l.aftersales_accessory_revenue + l.other_qs_revenue_amount
				) / 11
			) * 10
		),
		(
			(
				(
					l.sales_price + (l.tradein_value - l.tradein_given) - q.total - l.transport_cost - l.other_costs_amount - 
					IF (
						(l.sales_price + (l.tradein_value - l.tradein_given) - q.total - l.transport_cost - l.other_costs_amount + l.aftersales_accessory_revenue + l.other_qs_revenue_amount + l.other_revenue_amount) <= 1000,
						l.gross_subtractor_lower, 
						l.gross_subtractor					
					) + l.aftersales_accessory_revenue + l.other_qs_revenue_amount
				) / 11
			) * 10
		)
	)";
	
	// HOME - Timeline Stats (Start) //
	public function get_lead_stats ($user_id)
	{
		$where = "";
		if (isset($user_id) AND $user_id <> "" AND $user_id <> 0)
		{
			$where .= " AND l.`fk_user` = '".$this->db->escape_str($user_id)."'";
		}
		
		$query = "
		SELECT 
		(
			SELECT COUNT(1) AS `cnt` FROM `leads` AS `l`
			WHERE l.`deprecated` <> 1 AND l.`status` = 3 AND DATE(l.`tender_date`) = CURDATE() ".$where."
		) AS `tenders_today_count`,
		(
			SELECT COUNT(1) AS `cnt` FROM `leads` AS `l`
			WHERE l.`deprecated` <> 1 AND l.`status` = 3 ".$where."
		) AS `total_tenders_count`,
		(
			SELECT COUNT(1) AS `cnt` FROM `leads` AS `l`
			WHERE l.`deprecated` <> 1 AND DATE(l.`created_at`) = CURDATE() ".$where."
		) AS `leads_today_count`,	
		(
			SELECT COUNT(1) AS `cnt` FROM `leads` AS `l`
			WHERE l.`deprecated` <> 1 AND MONTH(l.`created_at`) = MONTH(CURRENT_DATE()) ".$where."
		) AS `leads_this_month_count`,			
		(
			SELECT COUNT(1) AS `cnt` FROM `leads` AS `l`
			WHERE l.`deprecated` <> 1 AND l.`status` IN (4, 5, 6, 7, 8) AND DATE(l.`order_date`) = CURDATE() ".$where."
		) AS `deals_today_count`,						
		(
			SELECT COUNT(1) AS `cnt` FROM `leads` AS `l`
			WHERE l.`deprecated` <> 1 AND l.`status` IN (4, 5, 6, 7, 8) AND MONTH(l.`order_date`) = MONTH(CURRENT_DATE()) ".$where."
		) AS `deals_this_month_count`,				
		(
			SELECT COUNT(1) AS `cnt` FROM `leads` AS `l`
			WHERE l.`deprecated` <> 1 AND l.`status` IN (4, 5, 6, 7, 8) AND l.`dealer_status` = 0 ".$where."
		) AS `orders_without_dealer_approval_count`,			
		(
			SELECT COUNT(1) AS `cnt` FROM `leads` AS `l`
			WHERE l.`deprecated` <> 1 AND l.`status` IN (4, 5, 6, 7, 8) AND l.`client_status` = 0 ".$where."
		) AS `orders_without_client_approval_count`,	
		(
			SELECT COALESCE(SUM(".$this->commissionable_gross_query."), 0)
			FROM `leads` AS `l`
			LEFT JOIN `quote_requests` AS `qr` ON l.`id_lead` = qr.`fk_lead`
			LEFT JOIN `quotes` AS `q` ON qr.`winner` = q.`id_quote`			
			LEFT JOIN `tradeins` ti ON l.`id_lead` = ti.`fk_lead`
			LEFT JOIN `trade_valuations` tv ON tv.`id_trade_valuation` = ti.`fk_trade_valuation`
			WHERE l.`deprecated` <> 1 AND l.`status` IN (4, 5, 6, 7, 8) AND DATE(l.`order_date`) = CURDATE() ".$where."
		) AS `gross_today`,
		(
			SELECT COALESCE(SUM(".$this->commissionable_gross_query."), 0)
			FROM `leads` AS `l`
			LEFT JOIN `quote_requests` AS `qr` ON l.`id_lead` = qr.`fk_lead`
			LEFT JOIN `quotes` AS `q` ON qr.`winner` = q.`id_quote`						
			LEFT JOIN `tradeins` ti ON l.`id_lead` = ti.`fk_lead`
			LEFT JOIN `trade_valuations` tv ON tv.`id_trade_valuation` = ti.`fk_trade_valuation`
			WHERE l.`deprecated` <> 1 AND l.`status` IN (4, 5, 6, 7, 8) AND MONTH(l.`order_date`) = MONTH(CURRENT_DATE()) ".$where."
		) AS `gross_this_month`,
		(
			SELECT COUNT(1)
			FROM `quotes` AS `q`
			JOIN `quote_requests` AS `qr` ON q.`fk_quote_request` = qr.`id_quote_request`
			JOIN `leads` AS `l` ON qr.`fk_lead` = l.`id_lead`
			WHERE l.`deprecated` <> 1 AND qr.`deprecated` <> 1 AND q.`deprecated` <> 1 
			AND DATE(q.`created_at`) = CURDATE() ".$where."
		) AS `quotes_today`,		
		(
			SELECT COUNT(1)
			FROM `quotes` AS `q`
			JOIN `quote_requests` AS `qr` ON q.`fk_quote_request` = qr.`id_quote_request`
			JOIN `leads` AS `l` ON qr.`fk_lead` = l.`id_lead`
			WHERE l.`deprecated` <> 1 AND qr.`deprecated` <> 1 AND q.`deprecated` <> 1 
			AND MONTH(q.`created_at`) = MONTH(CURRENT_DATE()) ".$where."
		) AS `quotes_this_month`,
		(
			SELECT COUNT(1)
			FROM `leads` AS `l`
			WHERE l.`deprecated` <> 1 AND l.`status` = 1 
			AND DATE(l.`created_at`) >= (CURDATE() - INTERVAL 3 DAY)
			AND DATE(l.`created_at`) <= CURDATE()
			".$where."
		) AS `leads_1`,
		(
			SELECT COUNT(1)
			FROM `leads` AS `l`
			WHERE l.`deprecated` <> 1 AND l.`status` = 1 
			AND DATE(l.`created_at`) >= (CURDATE() - INTERVAL 5 DAY)
			AND DATE(l.`created_at`) <= (CURDATE() - INTERVAL 4 DAY)
			".$where."
		) AS `leads_2`,
		(
			SELECT COUNT(1)
			FROM `leads` AS `l`
			WHERE l.`deprecated` <> 1 AND l.`status` = 1 
			AND DATE(l.`created_at`) >= (CURDATE() - INTERVAL 10 DAY)
			AND DATE(l.`created_at`) <= (CURDATE() - INTERVAL 6 DAY)
			".$where."
		) AS `leads_3`,
		(
			SELECT COUNT(1)
			FROM `leads` AS `l`
			WHERE l.`deprecated` <> 1 AND l.`status` = 1 
			AND DATE(l.`created_at`) <= (CURDATE() - INTERVAL 11 DAY)
			".$where."
		) AS `leads_4`
		";
		return $this->db->query($query)->row_array();			
	}
	
	public function get_ranking_stats ()
	{
		$query = "
		SELECT 
		id_user, 
		id_user AS `user_id`, username, 
		(
			SELECT COUNT(1) FROM `leads` AS `l` 
			WHERE l.`deprecated` <> 1
			AND l.`status` IN (3, 4, 5, 6, 7, 8)
			AND l.`fk_user` = `user_id`
			AND MONTH(l.`tender_date`) = MONTH(CURRENT_DATE())
		) AS `tenders_this_month_count`,
		(
			SELECT COUNT(1) FROM `leads` AS `l` 
			WHERE l.`deprecated` <> 1
			AND l.`status` IN (4, 5, 6, 7, 8)
			AND l.`fk_user` = `user_id`
			AND MONTH(l.`order_date`) = MONTH(CURRENT_DATE())
		) AS `deals_this_month_count`,
		(
			SELECT COALESCE(SUM(".$this->commissionable_gross_query."), 0)
			FROM `leads` AS `l`
			LEFT JOIN `quote_requests` AS `qr` ON l.`id_lead` = qr.`fk_lead`
			LEFT JOIN `quotes` AS `q` ON qr.`winner` = q.`id_quote`						
			LEFT JOIN `tradeins` ti ON l.`id_lead` = ti.`fk_lead`
			LEFT JOIN `trade_valuations` tv ON tv.`id_trade_valuation` = ti.`fk_trade_valuation`
			WHERE l.`deprecated` <> 1 
			AND l.`status` IN (4, 5, 6, 7, 8)
			AND l.`fk_user` = `user_id` 
			AND MONTH(l.`order_date`) = MONTH(CURRENT_DATE())
		) AS `commissionable_gross_this_month`
		FROM users WHERE `type` = 2 AND `status` = 1 AND `cq_sales` = 1";
		return $this->db->query($query)->result_array();		
	}
	// HOME - Timeline Stats (End) //
	
	public function get_running_tenders ()
	{
		$now = date("Y-m-d");
		$query = "
		SELECT u.id_user AS `qs_id`, u.name,
		(SELECT COUNT(DISTINCT id_lead) FROM leads WHERE `fk_user` = `qs_id` AND `status` = 3 AND `deprecated` <> 1) AS `tender_count_all`,
		(
			SELECT COUNT(DISTINCT id_lead) FROM leads l
			JOIN quote_requests qr ON l.id_lead = qr.fk_lead
			WHERE l.`fk_user` = `qs_id` AND l.`status` = 3 AND qr.`winner` <> 0 AND l.`deprecated` <> 1
		) AS `tender_with_winners_count_all`,		
		(
			SELECT COUNT(DISTINCT id) FROM actions 
			WHERE `fk_user` = `qs_id` 
			AND `details` = 'Tender Started'
			AND DATE(`created_at`) = '".$now."'
		) AS `tender_count_today`
		FROM users u WHERE cq_sales = 1 AND deprecated <> 1
		GROUP BY u.`id_user` ORDER BY `name` ASC";
		$sql = $this->db->query($query);
		return $sql->result_array();
	}	
	
	public function get_this_month_tickets ($user_id)
	{
		$current_month = date('m');
		$query = "
		SELECT COUNT(1) AS `cnt` FROM tickets 
		WHERE fk_user_to = ".$user_id."
		AND (MONTH(assignment_date) = '".$current_month."' OR assignment_date = '0000-00-00 00:00:00')";
		return $this->db->query($query)->row_array();
	}	
	
	public function get_lead_counter_days ($params) // Dashboard // To be revised
	{
		$query = "
		SELECT id_user as `qs_id`, name, 
			(SELECT COUNT(1) FROM leads WHERE fk_user = `qs_id` AND DATE(`".$params['date_type']."`) = '".$params['d'][0]."') as `val_1`,
			(SELECT COUNT(1) FROM leads WHERE fk_user = `qs_id` AND DATE(`".$params['date_type']."`) = '".$params['d'][1]."') as `val_2`,
			(SELECT COUNT(1) FROM leads WHERE fk_user = `qs_id` AND DATE(`".$params['date_type']."`) = '".$params['d'][2]."') as `val_3`,
			(SELECT COUNT(1) FROM leads WHERE fk_user = `qs_id` AND DATE(`".$params['date_type']."`) = '".$params['d'][3]."') as `val_4`,
			(SELECT COUNT(1) FROM leads WHERE fk_user = `qs_id` AND DATE(`".$params['date_type']."`) = '".$params['d'][4]."') as `val_5`,
			(SELECT COUNT(1) FROM leads WHERE fk_user = `qs_id` AND DATE(`".$params['date_type']."`) = '".$params['d'][5]."') as `val_6`,
			(SELECT COUNT(1) FROM leads WHERE fk_user = `qs_id` AND DATE(`".$params['date_type']."`) = '".$params['d'][6]."') as `val_7`
		FROM users WHERE admin_type = 1 OR (id_user = 259 OR id_user = 260 OR id_user = 244) AND deprecated <> 1 GROUP BY id_user ORDER BY name ASC";
		$sql = $this->db->query($query);
		return $sql->result();
	}

	public function get_submitted_deals_report ($params) // Dashboard //
	{
		$current_month = date('m');
		$current_year = date('Y');
		$last_month = str_pad((date('m') - 1), 2, "0", STR_PAD_LEFT);

		$query = "
		SELECT id_user as `qs_id`, name, 

			(SELECT COUNT(1) as cnt FROM leads WHERE fk_user = `qs_id` AND status IN (4, 5, 6, 7, 8) 
				AND MONTH(order_date) = '".$current_month."' AND YEAR(order_date) = '".$current_year."'
			) AS `monthly_deals`,

			(SELECT 
				SUM(".$this->commissionable_gross_query.")
				FROM leads l
				JOIN quote_requests qr ON l.id_lead = qr.fk_lead
				JOIN quotes q ON qr.winner = q.id_quote
				LEFT JOIN tradeins ti ON l.id_lead = ti.fk_lead
				LEFT JOIN trade_valuations tv ON tv.id_trade_valuation = ti.fk_trade_valuation
				WHERE l.fk_user = `qs_id` AND l.status IN (4, 5, 6, 7, 8) 
				AND MONTH(order_date) = '".$current_month."' AND YEAR(order_date) = '".$current_year."'
			) AS `monthly_gross`,

			(SELECT 
				SUM(".$this->commissionable_gross_query.")
				FROM leads l
				JOIN quote_requests qr ON l.id_lead = qr.fk_lead
				JOIN quotes q ON qr.winner = q.id_quote
				LEFT JOIN tradeins ti ON l.id_lead = ti.fk_lead
				LEFT JOIN trade_valuations tv ON tv.id_trade_valuation = ti.fk_trade_valuation				
				WHERE l.fk_user = `qs_id` AND l.status IN (4, 5, 6, 7, 8) 
				AND MONTH(order_date) = '".$last_month."' AND YEAR(order_date) = '".$current_year."'
			) AS `last_month_gross`,

			(SELECT 
				SUM(".$this->commissionable_gross_query.")
				FROM leads l
				JOIN quote_requests qr ON l.id_lead = qr.fk_lead
				JOIN quotes q ON qr.winner = q.id_quote
				LEFT JOIN tradeins ti ON l.id_lead = ti.fk_lead
				LEFT JOIN trade_valuations tv ON tv.id_trade_valuation = ti.fk_trade_valuation				
				WHERE l.fk_user = `qs_id` AND l.status IN (4, 5, 6, 7, 8) AND DATE(l.order_date) = '".$params['d'][0]."'
			) as `val_1`,
			(SELECT 
				SUM(".$this->commissionable_gross_query.")				
				FROM leads l
				JOIN quote_requests qr ON l.id_lead = qr.fk_lead
				JOIN quotes q ON qr.winner = q.id_quote
				LEFT JOIN tradeins ti ON l.id_lead = ti.fk_lead
				LEFT JOIN trade_valuations tv ON tv.id_trade_valuation = ti.fk_trade_valuation
				WHERE l.fk_user = `qs_id` AND l.status IN (4, 5, 6, 7, 8) AND DATE(l.order_date) = '".$params['d'][1]."'
			) as `val_2`,
			(SELECT 
				SUM(".$this->commissionable_gross_query.")				
				FROM leads l
				JOIN quote_requests qr ON l.id_lead = qr.fk_lead
				JOIN quotes q ON qr.winner = q.id_quote
				LEFT JOIN tradeins ti ON l.id_lead = ti.fk_lead
				LEFT JOIN trade_valuations tv ON tv.id_trade_valuation = ti.fk_trade_valuation				
				WHERE l.fk_user = `qs_id` AND l.status IN (4, 5, 6, 7, 8) AND DATE(l.order_date) = '".$params['d'][2]."'
			) as `val_3`,
			(SELECT 
				SUM(".$this->commissionable_gross_query.")				
				FROM leads l
				JOIN quote_requests qr ON l.id_lead = qr.fk_lead
				JOIN quotes q ON qr.winner = q.id_quote
				LEFT JOIN tradeins ti ON l.id_lead = ti.fk_lead
				LEFT JOIN trade_valuations tv ON tv.id_trade_valuation = ti.fk_trade_valuation				
				WHERE l.fk_user = `qs_id` AND l.status IN (4, 5, 6, 7, 8) AND DATE(l.order_date) = '".$params['d'][3]."'
			) as `val_4`,
			(SELECT 
				SUM(".$this->commissionable_gross_query.")
				FROM leads l
				JOIN quote_requests qr ON l.id_lead = qr.fk_lead
				JOIN quotes q ON qr.winner = q.id_quote
				LEFT JOIN tradeins ti ON l.id_lead = ti.fk_lead
				LEFT JOIN trade_valuations tv ON tv.id_trade_valuation = ti.fk_trade_valuation				
				WHERE l.fk_user = `qs_id` AND l.status IN (4, 5, 6, 7, 8) AND DATE(l.order_date) = '".$params['d'][4]."'
			) as `val_5`

		FROM users WHERE type = 2 AND deprecated <> 1 GROUP BY id_user ORDER BY `monthly_deals` DESC";
		$sql = $this->db->query($query);
		return $sql->result();
	}	

	public function get_approved_deals_report ($params) // Dashboard //
	{
		$current_month = date('m');
		$current_year = date('Y');
		$last_month = str_pad((date('m') - 1), 2, "0", STR_PAD_LEFT);

		$query = "
		SELECT id_user as `qs_id`, name, 
			(SELECT COUNT(1) as cnt FROM leads WHERE fk_user = `qs_id` AND status IN (5, 6, 7) 
				AND MONTH(order_date) = '".$current_month."' AND YEAR(order_date) = '".$current_year."'
			) AS `monthly_deals`,

			(SELECT 
				SUM(".$this->commissionable_gross_query.")
				FROM leads l
				JOIN quote_requests qr ON l.id_lead = qr.fk_lead
				JOIN quotes q ON qr.winner = q.id_quote
				LEFT JOIN tradeins ti ON l.id_lead = ti.fk_lead
				LEFT JOIN trade_valuations tv ON tv.id_trade_valuation = ti.fk_trade_valuation				
				WHERE l.fk_user = `qs_id` AND l.status IN (5, 6, 7)
				AND MONTH(order_date) = '".$current_month."' AND YEAR(order_date) = '".$current_year."'
			) AS `monthly_gross`,

			(SELECT 
				SUM(".$this->commissionable_gross_query.")
				FROM leads l
				JOIN quote_requests qr ON l.id_lead = qr.fk_lead
				JOIN quotes q ON qr.winner = q.id_quote
				LEFT JOIN tradeins ti ON l.id_lead = ti.fk_lead
				LEFT JOIN trade_valuations tv ON tv.id_trade_valuation = ti.fk_trade_valuation				
				WHERE l.fk_user = `qs_id` AND l.status IN (5, 6, 7)
				AND MONTH(order_date) = '".$last_month."' AND YEAR(order_date) = '".$current_year."'
			) AS `last_month_gross`,

			(SELECT 
				SUM(".$this->commissionable_gross_query.")				
				FROM leads l
				JOIN quote_requests qr ON l.id_lead = qr.fk_lead
				JOIN quotes q ON qr.winner = q.id_quote
				LEFT JOIN tradeins ti ON l.id_lead = ti.fk_lead
				LEFT JOIN trade_valuations tv ON tv.id_trade_valuation = ti.fk_trade_valuation				
				WHERE l.fk_user = `qs_id` AND l.status IN (5, 6, 7) AND DATE(l.order_date) = '".$params['d'][0]."'
			) as `val_1`,
			(SELECT 
				SUM(".$this->commissionable_gross_query.")				
				FROM leads l
				JOIN quote_requests qr ON l.id_lead = qr.fk_lead
				JOIN quotes q ON qr.winner = q.id_quote
				LEFT JOIN tradeins ti ON l.id_lead = ti.fk_lead
				LEFT JOIN trade_valuations tv ON tv.id_trade_valuation = ti.fk_trade_valuation				
				WHERE l.fk_user = `qs_id` AND l.status IN (5, 6, 7) AND DATE(l.order_date) = '".$params['d'][1]."'
			) as `val_2`,
			(SELECT 
				SUM(".$this->commissionable_gross_query.")				
				FROM leads l
				JOIN quote_requests qr ON l.id_lead = qr.fk_lead
				JOIN quotes q ON qr.winner = q.id_quote
				LEFT JOIN tradeins ti ON l.id_lead = ti.fk_lead
				LEFT JOIN trade_valuations tv ON tv.id_trade_valuation = ti.fk_trade_valuation				
				WHERE l.fk_user = `qs_id` AND l.status IN (5, 6, 7) AND DATE(l.order_date) = '".$params['d'][2]."'
			) as `val_3`,
			(SELECT 
				SUM(".$this->commissionable_gross_query.")				
				FROM leads l
				JOIN quote_requests qr ON l.id_lead = qr.fk_lead
				JOIN quotes q ON qr.winner = q.id_quote
				LEFT JOIN tradeins ti ON l.id_lead = ti.fk_lead
				LEFT JOIN trade_valuations tv ON tv.id_trade_valuation = ti.fk_trade_valuation				
				WHERE l.fk_user = `qs_id` AND l.status IN (5, 6, 7) AND DATE(l.order_date) = '".$params['d'][3]."'
			) as `val_4`,
			(SELECT 
				SUM(".$this->commissionable_gross_query.")				
				FROM leads l
				JOIN quote_requests qr ON l.id_lead = qr.fk_lead
				JOIN quotes q ON qr.winner = q.id_quote
				LEFT JOIN tradeins ti ON l.id_lead = ti.fk_lead
				LEFT JOIN trade_valuations tv ON tv.id_trade_valuation = ti.fk_trade_valuation
				WHERE l.fk_user = `qs_id` AND l.status IN (5, 6, 7) AND DATE(l.order_date) = '".$params['d'][4]."'
			) as `val_5`

		FROM users WHERE type = 2 AND deprecated <> 1 GROUP BY id_user ORDER BY name ASC";
		$sql = $this->db->query($query);
		return $sql->result();
	}

	public function get_settled_deals_report ($params) // Dashboard //
	{
		$current_month = date('m');
		$current_year = date('Y');
		$last_month = str_pad((date('m') - 1), 2, "0", STR_PAD_LEFT);

		$query = "
		SELECT id_user as `qs_id`, name,

			(SELECT 
				SUM(".$this->commissionable_gross_query.")				
				FROM leads l
				JOIN quote_requests qr ON l.id_lead = qr.fk_lead
				JOIN quotes q ON qr.winner = q.id_quote
				LEFT JOIN tradeins ti ON l.id_lead = ti.fk_lead
				LEFT JOIN trade_valuations tv ON tv.id_trade_valuation = ti.fk_trade_valuation				
				WHERE l.fk_user = `qs_id` AND l.status IN (7) 
				AND MONTH(settled_date) = '".$current_month."' AND YEAR(settled_date) = '".$current_year."'
			) AS `monthly_gross`,

			(SELECT COUNT(1) as cnt FROM leads WHERE fk_user = `qs_id` AND status IN (5, 6, 7) 
				AND MONTH(order_date) = '".$current_month."' AND YEAR(order_date) = '".$current_year."'
			) AS `approved_deals`,

			(SELECT COUNT(1) as cnt FROM leads WHERE fk_user = `qs_id` AND status IN (7) 
				AND MONTH(settled_date) = '".$current_month."' AND YEAR(settled_date) = '".$current_year."'
			) AS `settled_deals`,

			(SELECT COUNT(1) as cnt FROM actions WHERE fk_user = `qs_id` AND details = 'Tender Started' 
				AND MONTH(created_at) = '".$current_month."' AND YEAR(created_at) = '".$current_year."'
			) AS `tenders_run`,

			(SELECT COUNT(1) as cnt FROM actions WHERE fk_user = `qs_id` AND details LIKE 'Client Email%' 
				AND MONTH(created_at) = '".$current_month."' AND YEAR(created_at) = '".$current_year."'
			) AS `emails_sent`,

			(SELECT COUNT(1) as cnt FROM actions WHERE fk_user = `qs_id` AND details = 'Winner Selected' 
				AND MONTH(created_at) = '".$current_month."' AND YEAR(created_at) = '".$current_year."'
			) AS `winning_dealers_selected`

		FROM users WHERE type = 2 AND deprecated <> 1 GROUP BY id_user ORDER BY `monthly_gross` DESC";
		$sql = $this->db->query($query);
		return $sql->result();
	}

	public function get_last_settled_deals_report ($params) // Dashboard
	{
		$current_month = date('m');
		$current_year = date('Y');
		$last_month = str_pad((date('m') - 1), 2, "0", STR_PAD_LEFT);

		$query = "
		SELECT id_user as `qs_id`, name,

			(SELECT 
				SUM(".$this->commissionable_gross_query.")				
				FROM leads l
				JOIN quote_requests qr ON l.id_lead = qr.fk_lead
				JOIN quotes q ON qr.winner = q.id_quote
				LEFT JOIN tradeins ti ON l.id_lead = ti.fk_lead
				LEFT JOIN trade_valuations tv ON tv.id_trade_valuation = ti.fk_trade_valuation
				WHERE l.fk_user = `qs_id` AND l.status IN (7) 
				AND MONTH(settled_date) = '".$last_month."' AND YEAR(settled_date) = '".$current_year."'
			) AS `monthly_gross`,

			(SELECT COUNT(1) as cnt FROM leads WHERE fk_user = `qs_id` AND status IN (5, 6, 7) AND MONTH(order_date) = '".$last_month."') AS `approved_deals`,
			(SELECT COUNT(1) as cnt FROM leads WHERE fk_user = `qs_id` AND status IN (7) AND MONTH(settled_date) = '".$last_month."') AS `settled_deals`,
			(SELECT COUNT(1) as cnt FROM actions WHERE fk_user = `qs_id` AND details = 'Tender Started' AND MONTH(created_at) = '".$last_month."') AS `tenders_run`,
			(SELECT COUNT(1) as cnt FROM actions WHERE fk_user = `qs_id` AND details LIKE 'Client Email%' AND MONTH(created_at) = '".$last_month."') AS `emails_sent`,
			(SELECT COUNT(1) as cnt FROM actions WHERE fk_user = `qs_id` AND details = 'Winner Selected' AND MONTH(created_at) = '".$last_month."') AS `winning_dealers_selected`

		FROM users WHERE admin_type = 1 AND deprecated <> 1 GROUP BY id_user ORDER BY `monthly_gross` DESC";
		$sql = $this->db->query($query);
		return $sql->result();
	}
	
	public function get_lead_counter_weeks ($params) // Dashboard (Pending)
	{
		$query = "
		SELECT id_user as `qs_id`, name, 
			(SELECT COUNT(1) FROM leads WHERE fk_user = `qs_id` 
				AND DATE(`".$params['date_type']."`) >= '".$params['week_start'][6]."' AND DATE(`".$params['date_type']."`) <= '".$params['week_end'][6]."') as `val_1`,
			(SELECT COUNT(1) FROM leads WHERE fk_user = `qs_id` 
				AND DATE(`".$params['date_type']."`) >= '".$params['week_start'][5]."' AND DATE(`".$params['date_type']."`) <= '".$params['week_end'][5]."') as `val_2`,
			(SELECT COUNT(1) FROM leads WHERE fk_user = `qs_id` 
				AND DATE(`".$params['date_type']."`) >= '".$params['week_start'][4]."' AND DATE(`".$params['date_type']."`) <= '".$params['week_end'][4]."') as `val_3`,
			(SELECT COUNT(1) FROM leads WHERE fk_user = `qs_id` 
				AND DATE(`".$params['date_type']."`) >= '".$params['week_start'][3]."' AND DATE(`".$params['date_type']."`) <= '".$params['week_end'][3]."') as `val_4`,
			(SELECT COUNT(1) FROM leads WHERE fk_user = `qs_id` 
				AND DATE(`".$params['date_type']."`) >= '".$params['week_start'][2]."' AND DATE(`".$params['date_type']."`) <= '".$params['week_end'][2]."') as `val_5`,
			(SELECT COUNT(1) FROM leads WHERE fk_user = `qs_id` 
				AND DATE(`".$params['date_type']."`) >= '".$params['week_start'][1]."' AND DATE(`".$params['date_type']."`) <= '".$params['week_end'][1]."') as `val_6`,
			(SELECT COUNT(1) FROM leads WHERE fk_user = `qs_id` 
				AND DATE(`".$params['date_type']."`) >= '".$params['week_start'][0]."' AND DATE(`".$params['date_type']."`) <= '".$params['week_end'][0]."') as `val_7`
		FROM users WHERE admin_type = 1  OR (id_user = 259 OR id_user = 260 OR id_user = 244) AND deprecated <> 1 GROUP BY id_user ORDER BY name ASC";
		$sql = $this->db->query($query);
		return $sql->result();
	}
	
	public function get_this_month_leads ($user_id) // Dashboard //
	{
		$current_month = date('m');
		$query = "SELECT COUNT(1) as cnt FROM actions WHERE fk_user = '".$user_id."' AND details = 'Assigned'";
		return $this->db->query($query)->row_array();		
	}
	
	public function get_this_month_tenders ($user_id) // Dashboard //
	{
		$current_month = date('m');
		$query = "
		SELECT COUNT(1) as cnt FROM leads WHERE fk_user = '".$user_id."' AND status IN (3, 4, 5, 6, 7, 8, 9) AND MONTH(tender_date) = '".$current_month."'";
		return $this->db->query($query)->row_array();		
	}

	public function get_this_month_approved_deals ($user_id) // Dashboard //
	{
		$current_month = date('m');
		$query = "
		SELECT COUNT(1) as cnt FROM leads WHERE fk_user = '".$user_id."' AND status IN (5, 6, 7) AND MONTH(order_date) = '".$current_month."'";
		return $this->db->query($query)->row_array();
	}

	public function get_this_month_settled_deals ($user_id) // Dashboard //
	{
		$current_month = date('m');
		$query = "SELECT COUNT(1) as cnt FROM leads WHERE fk_user = '".$user_id."' AND status IN (7) AND MONTH(settled_date) = '".$current_month."'";
		return $this->db->query($query)->row_array();
	}

	public function get_highest_day_deals ($user_id) // Dashboard //
	{
		$current_month = date('m');
		$query = "
		SELECT DATE(l.order_date) AS `record_date`, u.name, COUNT(1) AS `cnt`
		FROM leads l JOIN users u ON l.fk_user = u.id_user
		WHERE l.status IN (5, 6, 7) AND DATE(l.order_date) <> '0000:00:00'
		GROUP BY DATE(l.order_date), l.fk_user ORDER BY `cnt` DESC LIMIT 1";
		return $this->db->query($query)->row_array();
	}

	public function get_highest_month_leads ($user_id) // Dashboard // To be revised
	{
		$current_month = date('m');
		$query = "
		SELECT CONCAT(MONTH(l.attempted_date), '-', YEAR(l.attempted_date)) AS `record_date`, u.name, COUNT(1) AS `cnt`
		FROM leads l JOIN users u ON l.fk_user = u.id_user
		WHERE 1 AND DATE(l.attempted_date) <> '0000:00:00'
		GROUP BY CONCAT(MONTH(l.attempted_date), '-', YEAR(l.attempted_date)), l.fk_user ORDER BY `cnt` DESC LIMIT 1";
		return $this->db->query($query)->row_array();
	}

	public function get_this_month_approved_commissionable_gross_fields ($user_id) // Dashboard
	{
		$current_month = date('m');
		$query = "
		SELECT 
		l.id_lead, q.total, q.dealer_changeover, q.dealer_tradein_value, l.tradein_value, l.tradein_given, l.tradein_payout, 
		l.sales_price, l.cpp, l.gross_subtractor, l.gross_subtractor_lower, l.other_costs_amount, l.other_revenue_amount,
		tv.fk_user AS `winning_wholesaler`
		FROM leads l
		JOIN quote_requests qr ON l.id_lead = qr.fk_lead
		JOIN quotes q ON qr.winner = q.id_quote
		LEFT JOIN tradeins ti ON l.id_lead = ti.fk_lead
		LEFT JOIN trade_valuations tv ON tv.id_trade_valuation = ti.fk_trade_valuation		
		WHERE l.fk_user = '".$user_id."'
		AND l.status IN (5, 6, 7)
		AND MONTH(order_date) = '".$current_month."'
		GROUP BY l.id_lead";
		$sql = $this->db->query($query);
		return $sql->result();
	}

	public function get_this_month_delivered_commissionable_gross_fields ($user_id) // Dashboard
	{
		$current_month = date('m');
		$query = "
		SELECT 
		l.id_lead, q.total, q.dealer_changeover, q.dealer_tradein_value, l.tradein_value, l.tradein_given, l.tradein_payout, 
		l.sales_price, l.cpp, l.gross_subtractor, l.gross_subtractor_lower, l.other_costs_amount, l.other_revenue_amount,
		tv.fk_user AS `winning_wholesaler`
		FROM leads l
		JOIN quote_requests qr ON l.id_lead = qr.fk_lead
		JOIN quotes q ON qr.winner = q.id_quote
		LEFT JOIN tradeins ti ON l.id_lead = ti.fk_lead
		LEFT JOIN trade_valuations tv ON tv.id_trade_valuation = ti.fk_trade_valuation		
		WHERE l.fk_user = '".$user_id."'
		AND l.status IN (5, 6, 7)
		AND MONTH(l.delivery_date) = '".$current_month."'
		GROUP BY l.id_lead";
		$sql = $this->db->query($query);
		return $sql->result();
	}	

	public function get_this_month_settled_commissionable_gross_fields ($user_id) // Dashboard
	{
		$current_month = date('m');
		$query = "
		SELECT 
		l.id_lead, q.total, q.dealer_changeover, q.dealer_tradein_value, l.tradein_value, l.tradein_given, l.tradein_payout, 
		l.sales_price, l.cpp, l.gross_subtractor, l.gross_subtractor_lower, l.other_costs_amount, l.other_revenue_amount,
		tv.fk_user AS `winning_wholesaler`
		FROM leads l
		JOIN quote_requests qr ON l.id_lead = qr.fk_lead
		JOIN quotes q ON qr.winner = q.id_quote
		LEFT JOIN tradeins ti ON l.id_lead = ti.fk_lead
		LEFT JOIN trade_valuations tv ON tv.id_trade_valuation = ti.fk_trade_valuation		
		WHERE l.fk_user = '".$user_id."'
		AND l.status IN (7)
		AND MONTH(settled_date) = '".$current_month."'
		GROUP BY l.id_lead";
		$sql = $this->db->query($query);
		return $sql->result();
	}
	
	public function get_revenue_per_brand ($start_date, $end_date) // REVENUE PER BRAND
	{
		$where = "";
		if ($start_date<>"")
		{
			$where .= " AND l.`order_date` >= '".$this->db->escape_str($start_date)."'";
		}

		if ($end_date<>"")
		{
			$where .= " AND l.`order_date` <= '".$this->db->escape_str($end_date)."'";
		}

		$query = "
		SELECT m.id_make AS `make_id`, m.name AS `make`,
		(SELECT SUM(l.cpp + l.tradein_value - l.tradein_payout - q.total - l.other_costs_amount + l.other_revenue_amount)
				FROM leads l
				JOIN quote_requests qr ON l.id_lead = qr.fk_lead
				JOIN quotes q ON qr.winner = q.id_quote
				WHERE qr.`make` = `make_id` AND l.status IN (5, 6, 7) 
				".$where."
		) as `revenue`		
		FROM makes m
		JOIN quote_requests qr ON m.id_make = qr.make
		JOIN leads l ON qr.fk_lead = l.id_lead
		WHERE l.`status` IN (5, 6, 7, 8)
		".$where."
		GROUP BY m.id_make ORDER BY `revenue` DESC";
		$sql = $this->db->query($query);
		return $sql->result_array();
	}		

	public function get_revenue_per_model ($start_date, $end_date) // REVENUE PER MODEL
	{
		$where = "";
		if ($start_date<>"")
		{
			$where .= " AND l.`order_date` >= '".$this->db->escape_str($start_date)."'";
		}

		if ($end_date<>"")
		{
			$where .= " AND l.`order_date` <= '".$this->db->escape_str($end_date)."'";
		}

		$query = "
		SELECT f.id_family AS `family_id`,
		m.name AS `make`, f.name AS `model`,
		(SELECT SUM(l.cpp + l.tradein_value - l.tradein_payout - q.total - l.other_costs_amount + l.other_revenue_amount)
			FROM leads l
			JOIN quote_requests qr ON l.id_lead = qr.fk_lead
			JOIN quotes q ON qr.winner = q.id_quote
			WHERE qr.`model` = `family_id` AND l.status IN (5, 6, 7) 
			".$where."
		) as `revenue`
		FROM families f
		JOIN makes m ON f.fk_make = m.id_make
		JOIN quote_requests qr ON m.id_make = qr.make
		JOIN leads l ON qr.fk_lead = l.id_lead
		WHERE l.`status` IN (5, 6, 7, 8)
		".$where."
		GROUP BY f.id_family ORDER BY `revenue` DESC";
		$sql = $this->db->query($query);
		return $sql->result_array();
	}

	public function get_revenue_per_salesperson ($start_date, $end_date) // REVENUE PER SALESPERSON
	{
		$where = "";
		if ($start_date<>"")
		{
			$where .= " AND l.`order_date` >= '".$this->db->escape_str($start_date)."'";
		}

		if ($end_date<>"")
		{
			$where .= " AND l.`order_date` <= '".$this->db->escape_str($end_date)."'";
		}

		$query = "
		SELECT 
		u.id_user as `qs_id`, u.name,
		(SELECT SUM(l.cpp + l.tradein_value - l.tradein_payout - q.total - l.other_costs_amount + l.other_revenue_amount)
				FROM leads l
				JOIN quote_requests qr ON l.id_lead = qr.fk_lead
				JOIN quotes q ON qr.winner = q.id_quote
				WHERE l.fk_user = `qs_id` AND l.status IN (5, 6, 7) 
				".$where."
		) as `revenue`
		FROM users u
		JOIN leads l ON u.id_user = l.fk_user
		JOIN quote_requests qr ON l.id_lead = qr.fk_lead
		WHERE l.`status` IN (5, 6, 7, 8)
		".$where."
		GROUP BY u.`id_user` ORDER BY `revenue` DESC";
		$sql = $this->db->query($query);
		return $sql->result_array();
	}

	public function get_lead_attempts ($start_date, $end_date) // ASSIGNED TO QS LEAD COUNT
	{
		$where = "";
		if ($start_date<>"")
		{
			$where .= " AND `created_at` >= '".$this->db->escape_str($start_date)."'";
		}

		if ($end_date<>"")
		{
			$where .= " AND `created_at` <= '".$this->db->escape_str($end_date)."'";
		}
		
		$query = "
		SELECT
		`id_user` as `qs_id`, `name`, 
		(SELECT COUNT(DISTINCT `id`) FROM actions WHERE `type` = 1 AND `details` = 'Assigned' AND fk_user = `qs_id` ".$where.") AS `assigned`,
		(SELECT COUNT(DISTINCT `id`) FROM actions WHERE `type` = 1 AND `details` = 'Client Email: 2' AND fk_user = `qs_id` ".$where.") AS `no_answer`,
		(SELECT COUNT(DISTINCT `id`) FROM actions WHERE `type` = 1 AND `details` = 'Client Email: 3' AND fk_user = `qs_id` ".$where.") AS `wrong_number`,
		(SELECT COUNT(DISTINCT `id`) FROM actions WHERE `type` = 1 AND `details` = 'Delete' AND fk_user = `qs_id` ".$where.") AS `deleted`,
		(SELECT COUNT(DISTINCT `id`) FROM actions WHERE `type` = 1 AND `details` = 'Tender Started' AND fk_user = `qs_id` ".$where.") AS `tender_started`
		FROM users
		WHERE 1 AND `cq_sales` = 1
		GROUP BY `id_user` ORDER BY `assigned` DESC";
		$sql = $this->db->query($query);
		return $sql->result_array();
	}

	public function get_lead_sources ($start_date, $end_date) // POSTCODE LEAD COUNT
	{
		$where = "";
		if ($start_date<>"")
		{
			$where .= " AND `created_at` >= '".$this->db->escape_str($start_date)."'";
		}

		if ($end_date<>"")
		{
			$where .= " AND `created_at` <= '".$this->db->escape_str($end_date)."'";
		}
		
		$query = "
		SELECT `source`, COUNT(1) AS `record_count`
		FROM leads
		WHERE 1 AND `source` <> ''
		".$where."
		GROUP BY `source` ORDER BY `record_count` DESC";
		$sql = $this->db->query($query);
		return $sql->result_array();
	}	

	public function get_lead_postcodes ($start_date, $end_date) // POSTCODE LEAD COUNT
	{
		$where = "";
		if ($start_date<>"")
		{
			$where .= " AND `created_at` >= '".$this->db->escape_str($start_date)."'";
		}

		if ($end_date<>"")
		{
			$where .= " AND `created_at` <= '".$this->db->escape_str($end_date)."'";
		}
		
		$query = "
		SELECT `postcode`, COUNT(1) AS `record_count`
		FROM leads
		WHERE 1 AND `postcode` <> ''
		".$where."
		GROUP BY `postcode` ORDER BY `record_count` DESC";
		$sql = $this->db->query($query);
		return $sql->result_array();
	}

	public function get_lead_states ($start_date, $end_date) // POSTCODE LEAD COUNT
	{
		$where = "";
		if ($start_date<>"")
		{
			$where .= " AND `created_at` >= '".$this->db->escape_str($start_date)."'";
		}

		if ($end_date<>"")
		{
			$where .= " AND `created_at` <= '".$this->db->escape_str($end_date)."'";
		}
		
		$query = "
		SELECT `state`, COUNT(1) AS `record_count`
		FROM leads
		WHERE 1 AND `state` <> ''
		".$where."
		GROUP BY `state` ORDER BY `record_count` DESC";
		$sql = $this->db->query($query);
		return $sql->result_array();
	}	

	public function get_lead_makes ($start_date, $end_date) // MAKE LEAD COUNT
	{
		$where = "";
		if ($start_date<>"")
		{
			$where .= " AND `created_at` >= '".$this->db->escape_str($start_date)."'";
		}

		if ($end_date<>"")
		{
			$where .= " AND `created_at` <= '".$this->db->escape_str($end_date)."'";
		}
		
		$query = "
		SELECT `make`, COUNT(1) AS `record_count`
		FROM leads
		WHERE 1 AND `make` <> ''
		".$where."
		GROUP BY `make` ORDER BY `record_count` DESC";
		$sql = $this->db->query($query);
		return $sql->result_array();
	}

	public function get_lead_bought ($start_date, $end_date) // BOUGHT LEAD COUNT
	{
		$where = "";
		if ($start_date<>"")
		{
			$where .= " AND l.`purchase_date` >= '".$this->db->escape_str($start_date)."'";
		}

		if ($end_date<>"")
		{
			$where .= " AND l.`purchase_date` <= '".$this->db->escape_str($end_date)."'";
		}
		
		$query = "
		SELECT u.`name`, COUNT(1) AS `record_count`
		FROM leads l
		JOIN users u ON l.fk_buyer = u.id_user
		WHERE 1 AND `fk_buyer` <> 0
		".$where."
		GROUP BY u.`id_user` ORDER BY `record_count` DESC";
		$sql = $this->db->query($query);
		return $sql->result_array();
	}	
}
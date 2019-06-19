<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
else if ($lead->status == 0) { $ls_css = 'style="color: #57DC75"'; } Unallocated
else if ($lead->status == 1) { $ls_css = 'style="color: #3c94d6"'; } Allocated
else if ($lead->status == 2) { $ls_css = 'style="color: #cc3333"'; } Attempted
else if ($lead->status == 10) { $ls_css = 'style="color: #2baab1"'; } Pre-Tendering
else if ($lead->status == 3) { $ls_css = 'style="color: #6600cc"'; } Tendering
else if ($lead->status == 4) { $ls_css = 'style="color: #9933cc"'; } Pending Auth
else if ($lead->status == 5) { $ls_css = 'style="color: #cc00cc"'; } Approved by Admin
else if ($lead->status == 6) { $ls_css = 'style="color: #ff6633"'; } Delivered
else if ($lead->status == 7) { $ls_css = 'style="color: #009900"'; } Settled
else if ($lead->status == 8) { $ls_css = 'style="color: #2baab1"'; } Admin on Hold
else if ($lead->status == 9) { $ls_css = 'style="color: #2baab1"'; } Deal Cancelled
else if ($lead->status == 100) { $ls_css = 'style="color: #cccccc"'; } Deleted

else if ($lead->sale_status == 0) { $lss_css = 'style="color: #3c94d6"'; }
else if ($lead->sale_status == 1) { $lss_css = 'style="color: #cc3333"'; } On Sale
else if ($lead->sale_status == 2) { $lss_css = 'style="color: #bbbbbb"'; } Sold

else if ($lead->admin_status == 0) { $as_css = 'style="color: #333"'; }
else if ($lead->admin_status == 1) { $as_css = 'style="color: #333"'; }
else if ($lead->admin_status == 2) { $as_css = 'style="color: #333"'; }
*/

class Lead_Model extends CI_Model {

	public $date_format = "DATE_FORMAT(row_date, '%d/%m/%Y %H:%i:%S')";
	
	public $revenue_threshold = 1000;
	
	public $revenue_query = "
	IF(tv.`fk_user` = 282,
		fa.sales_price - fa.tradein_given + fa.tradein_payout - q.dealer_changeover - fa.transport_cost - fa.other_costs_amount + fa.aftersales_accessory_revenue + fa.other_qs_revenue_amount + fa.other_revenue_amount,
		fa.sales_price + (fa.tradein_value - fa.tradein_given) - q.total - fa.transport_cost - fa.other_costs_amount + fa.aftersales_accessory_revenue + fa.other_qs_revenue_amount + fa.other_revenue_amount
	)";
		
	public $balcqo_query = "
	IF (fa.`deduct_to_dealer_invoice` = 1,
		IF(tv.`fk_user` = 282, 
			fa.sales_price - fa.tradein_given + fa.tradein_payout - q.dealer_changeover - fa.transport_cost - fa.other_costs_amount + fa.aftersales_accessory_revenue + fa.other_qs_revenue_amount + fa.other_revenue_amount,
			fa.sales_price + (fa.tradein_value - fa.tradein_given) - q.total - fa.transport_cost - fa.other_costs_amount + fa.aftersales_accessory_revenue + fa.other_qs_revenue_amount + fa.other_revenue_amount
		),
		IF(tv.`fk_user` = 282, 
			fa.sales_price - fa.tradein_given + fa.tradein_payout - q.dealer_changeover - fa.transport_cost - fa.other_costs_amount + fa.aftersales_accessory_revenue + fa.other_qs_revenue_amount + fa.other_revenue_amount,
			fa.sales_price + (fa.tradein_value - fa.tradein_given) - q.total - fa.transport_cost - fa.other_costs_amount + fa.aftersales_accessory_revenue + fa.other_qs_revenue_amount + fa.other_revenue_amount
		) + fa.other_costs_amount		
	)";

	public $commissionable_gross_query = "
	IF(tv.`fk_user` = 282,
		(
			(
				(
					fa.sales_price - fa.tradein_given + fa.tradein_payout - q.dealer_changeover - fa.transport_cost - fa.other_costs_amount - 
					IF(
						(fa.sales_price - fa.tradein_given + fa.tradein_payout - q.dealer_changeover - fa.transport_cost - fa.other_costs_amount + fa.aftersales_accessory_revenue + fa.other_qs_revenue_amount + fa.other_revenue_amount) <= 1000,
						fa.gross_subtractor_lower, 
						fa.gross_subtractor
					) + fa.aftersales_accessory_revenue + fa.other_qs_revenue_amount
				) / 11
			) * 10
		),
		(
			(
				(
					fa.sales_price + (fa.tradein_value - fa.tradein_given) - q.total - fa.transport_cost - fa.other_costs_amount - 
					IF(
						(fa.sales_price + (fa.tradein_value - fa.tradein_given) - q.total - fa.transport_cost - fa.other_costs_amount + fa.aftersales_accessory_revenue + fa.other_qs_revenue_amount + fa.other_revenue_amount) <= 1000,
						fa.gross_subtractor_lower, 
						fa.gross_subtractor					
					) + fa.aftersales_accessory_revenue + fa.other_qs_revenue_amount
				) / 11
			) * 10
		)
	)";
	
	// LEAD START // 
	public function get_all_my_tenders ($user_id)
	{
		$query = "
		SELECT 
		qr.id_quote_request,
		qr.id_quote_request AS `quote_request_id`,		
		
		l.id_lead, 
		CONCAT('QM', LPAD(l.`id_lead`, 5, '0')) AS `cq_number`,
		l.name, l.email,
		
		u.name AS `qs_name`, 
		u.phone AS `qs_phone`, u.mobile AS `qs_mobile`,
		
		m.`name` AS `tender_make`,
		f.`name` AS `tender_model`,
		v.`name` AS `tender_variant`,
		qr.`build_date`,
		v.`bodystyle` AS `tender_body_type`,
		
		(SELECT COUNT(1) FROM `quotes` WHERE `fk_quote_request` = `quote_request_id`) AS `quotes_count`,
		
		(SELECT COUNT(1) FROM `quotes` WHERE `fk_quote_request` = `quote_request_id` AND `seen_status` = 0) AS `new_quotes_count`,
		
		DATE(qr.`created_at`) AS `tender_date`
		
		FROM `leads` AS `l`
		JOIN `users` AS `u` ON l.`fk_user` = u.`id_user`
		JOIN `quote_requests` AS `qr` ON l.`id_lead` = qr.`fk_lead`
		JOIN `makes` AS `m` ON qr.`make` = m.`id_make`
		JOIN `families` AS `f` ON qr.`model` = f.`id_family`
		JOIN `vehicles` AS `v` ON qr.`variant` = v.`id_vehicle`
		WHERE u.`id_user` = '".$this->db->escape_str($user_id)."' AND l.`status` = 3 
		AND qr.`deprecated` <> 1 
		AND l.`deprecated` <> 1
		ORDER BY 
		`new_quotes_count` DESC,
		qr.`created_at` ASC";
		return $this->db->query($query)->result_array();		
	}
	
	public function get_tender_cheapest_quotes ($quote_request_id)
	{
		$query = "
		SELECT 
		qr.`id_quote_request`, 
		qr.`id_quote_request` AS `quote_request_id`,
		qr.`fk_lead`,
		qr.make AS `make_id`,
		qr.model AS `family_id`,
		qr.variant AS `vehicle_id`,
		m.`name` AS `tender_make`,
		f.`name` AS `tender_model`,
		v.`name` AS `tender_variant`,
		(SELECT COALESCE(MIN(`total`)) FROM quotes WHERE fk_quote_request = `quote_request_id` AND deprecated <> 1) AS `lowest_price`,
		(SELECT `total` FROM quotes WHERE fk_quote_request = `quote_request_id` AND deprecated <> 1 ORDER BY created_at DESC LIMIT 1) AS `newest_price`,
		(
			SELECT COALESCE(MIN(q.`total`))
			FROM `quotes` AS `q`
			JOIN `quote_requests` AS `qr` ON q.`fk_quote_request` = qr.`id_quote_request`
			WHERE 1
			AND qr.`make` = `make_id` 
			AND qr.`model` = `family_id` 
			AND qr.`variant` = `vehicle_id`
			AND q.`deprecated` <> 1
		) AS `cheapest_price`,
		'0' AS `lowest_carsales_price`,
		qr.`created_at`
		FROM `quote_requests` AS `qr`
		JOIN `makes` AS `m` ON qr.`make` = m.`id_make`
		JOIN `families` AS `f` ON qr.`model` = f.`id_family`
		JOIN `vehicles` AS `v` ON qr.`variant` = v.`id_vehicle`
		WHERE qr.`id_quote_request` = '".$this->db->escape_str($quote_request_id)."'
		GROUP BY qr.`id_quote_request`";
		return $this->db->query($query)->row_array();
	}

	public function get_lead ($lead_id)
	{
		$query = "
		SELECT
		fa.`id_fq_account`, 
		fa.`id_fq_account` AS `lead_id`,
		
		fa.`source`,

		CONCAT('QM', LPAD(fa.`id_fq_account`, 5, '0')) AS `cq_number`,
		CONCAT('PO_', LPAD(fa.`id_fq_account`, 5, '0')) AS `po_number`,
		CONCAT('DI_', LPAD(fa.`id_fq_account`, 5, '0')) AS `dealer_invoice_number`,
		CONCAT('CI_', LPAD(fa.`id_fq_account`, 5, '0')) AS `client_invoice_number`,
		
		LPAD(fa.`id_fq_account`, 5, '0') AS `cq_number_only`,
		
	fa.`client_signature_url`, fa.`order_pdf`,
		fa.`client_invoice_taxes`,

		fa.`status`,
		CASE (fa.`status`)
			WHEN 0 THEN 'Unallocated'
			WHEN 1 THEN 'Allocated'
			WHEN 2 THEN 'Attempted'
			WHEN 3 THEN 'Tendering'
			WHEN 4 THEN 'Pending Auth'
			WHEN 5 THEN 'Approved by Admin'
			WHEN 6 THEN 'Delivered'
			WHEN 7 THEN 'Settled'
			WHEN 8 THEN 'Admin on Hold'
			WHEN 9 THEN 'Deal Cancelled'
			WHEN 100 THEN 'Deleted'
		END `status_text`,

		fa.`dealer_status`,
		CASE (fa.`dealer_status`)
			WHEN 0 THEN 'Pending'
			WHEN 1 THEN 'Approved'
			WHEN 2 THEN 'Delivered'
		END `dealer_status_text`,
		
		fa.`client_status`,
		CASE (fa.`client_status`)
			WHEN 0 THEN 'Pending Client Approval'
			WHEN 1 THEN 'Agreement Seen'
			WHEN 2 THEN 'Approved by Client'
			WHEN 3 THEN 'Awaiting Approval'
		END `client_status_text`,
		
		fa.`accounts_status`,
		CASE (fa.`accounts_status`)
			WHEN 0 THEN 'Pending'
			WHEN 1 THEN 'Approved'
		END `accounts_status_text`,
		
		fa.`accounts_update_status`,	

		fa.`admin_status`,
		
		fa.`deal_flag`,

		fa.`finance`,
				
		fa.`lead_name`, fa.`business_name`, fa.`abn`, fa.`facsimile`, fa.`occupation`,
		fa.`lead_email`, fa.`lead_state`, fa.`lead_postcode`, 
		fa.`lead_phone`, fa.`lead_mobile`, fa.`driver_license`, fa.`details`, 
		fa.`admin_details`, fa.`admin_to_qs_details`, 
		
		qr.`id_quote_request`, 
		qr.`id_quote_request` AS `qr_id`, 

		qs.`id_user`,
		qs.`id_user` AS `qs_id`,
		qs.`name` AS `qs_name`, 
		qs.`username` AS `qs_email`, qs.`phone` AS `qs_phone`, qs.`mobile` AS `qs_mobile`,

		d.`id_user` AS `dealer_id`,
		da.`dealership_name` AS `dealership_name`, d.`name` AS `fleet_manager`, 
		d.`abn` AS `dealer_abn`, d.`dealer_license`, 
		d.`state` AS `dealer_state`, d.`postcode` AS `dealer_postcode`, d.`address` AS `dealer_address`,
		d.`username` AS `dealer_email`, d.`phone` AS `dealer_phone`, d.`mobile` AS `dealer_mobile`, 
	
		d.`manager_name` AS `dealer_manager_name`, d.`manager_email` AS `dealer_manager_email`, d.`manager_phone` AS `dealer_manager_phone`, d.`manager_mobile` AS `dealer_manager_mobile`, 
		d.`account_name` AS `dealer_account_name`, d.`account_email` AS `dealer_account_email`, d.`account_phone` AS `dealer_account_phone`, d.`account_mobile` AS `dealer_account_mobile`, 
		d.`dealer_principal_name`, d.`dealer_principal_email`, d.`dealer_principal_phone`, d.`dealer_principal_mobile`, 
		d.`account_email`, d.`account_name`,
		
		d.`account_holders_name`, d.`bank_acct_name`, d.`bank_acct_bsb`, d.`bank_acct_num`, 
		
		d.`deposit_show_status`,

		fa.`make` AS `make`, fa.`model` AS `model`,

		m.`id_make`, m.`name` AS `tender_make`,

		f.`id_family`, f.`name` AS `tender_model`, 

		v.`id_vehicle`, v.`name` AS `tender_variant`,

		qr.`build_date`, qr.`series`, qr.`body_type`, qr.`registration_type`, 
		qr.`colour`, qr.`transmission`, qr.`fuel_type`,
		qr.`email_paragraph` AS `qr_email_paragraph`, 
		qr.`message` AS `qr_message`,
		qr.`rb_data` AS `rb_data`,
       
		q.`id_quote`,
		q.`id_quote` AS `quote_id`,
		q.`sender`,
		q.`id_quote` AS `winner`, 
		q.`total`, q.`total` AS `winning_price`, 
		q.`dealer_tradein_value`, q.`dealer_tradein_payout`, q.`dealer_client_refund`, q.`dealer_changeover`,
		q.`retail_price`, q.`predelivery`, q.`gst`, q.`stamp_duty`, q.`registration`, q.`premium_plate_fee`, q.`ctp`, 
		q.`luxury_tax`, q.`dealer_discount`, q.`fleet_discount`, q.`build_date` AS `quote_build_date`, q.`compliance_date`,q.`on_road`,
		q.`vin`, q.`engine`, q.`registration_plate`, q.`registration_expiry`, IF(q.`kms` = 0, '', q.`kms`) AS `kms`,
		q.`demo`,

		(SELECT COUNT(1) FROM `tradeins` WHERE `fk_lead` = `lead_id`) AS `tradein_count`,
		(SELECT COUNT(1) FROM `tradeins` AS `t` 
			JOIN `trade_valuations` AS `tv`
			ON t.`fk_trade_valuation` = tv.`id_trade_valuation`
			WHERE t.`fk_lead` = `lead_id` AND tv.`fk_user` = 282
		) AS `dealer_tradein_count`,

		(SELECT
			IF (tv.`fk_user` = 282, 'Dealer', IF (tv.`fk_user` = 374, 'Quote Me', 'Wholesaler'))
			FROM `tradeins` AS `t` 
			JOIN `trade_valuations` AS `tv`
			ON t.`fk_trade_valuation` = tv.`id_trade_valuation`
			WHERE t.`fk_lead` = `lead_id`
			LIMIT 1
		) AS `trade_buyer_type`,

		fa.`accessory_status`, fa.`accessory_special_conditions`, fa.`fuel_efficient_flag`,
		IF (DATE(fa.`accessory_job_date`) = '0000-00-00', '', DATE(fa.`accessory_job_date`)) AS `accessory_job_date`,

		fa.`deposit`, fa.`transport`, fa.`transport_cost`,

		q.`dealer_tradein_value` AS `dtv`,
		q.`dealer_tradein_payout` AS `dtp`, 
		q.`dealer_client_refund` AS `dcr`,
		(SELECT `winning_price` - `dtv` + `dtp` + `dcr`) AS `dealer_changeover`,

		(SELECT COUNT(DISTINCT fk_user) FROM `quote_requests` WHERE `fk_quote_request` = `qr_id`) AS `invite_dealer_count`,
		
		(SELECT COUNT(1) FROM `quotes` WHERE `fk_quote_request` = `qr_id`) AS `quote_count`, 

		IF(DATE(fa.`deleted_date`) = '0000-00-00 00:00:00', '', fa.`deleted_date`) AS `deleted_date`,
		IF(DATE(fa.`allocated_date`) = '0000-00-00 00:00:00', '', fa.`allocated_date`) AS `allocated_date`,
		IF(DATE(fa.`attempted_date`) = '0000-00-00 00:00:00', '', fa.`attempted_date`) AS `attempted_date`,
		IF(DATE(fa.`tender_date`) = '0000-00-00 00:00:00', '', fa.`tender_date`) AS `tender_date`,
		IF(DATE(fa.`deal_date`) = '0000-00-00 00:00:00', '', fa.`deal_date`) AS `deal_date`,
		IF(DATE(fa.`order_date`) = '0000-00-00', '', DATE(fa.`order_date`)) AS `order_date`,
		IF(DATE(fa.`client_agreed_date`) = '0000-00-00', '', DATE(fa.`client_agreed_date`)) AS `client_agreed_date`,
		IF(DATE(fa.`approved_date`) = '0000-00-00 00:00:00', '', fa.`approved_date`) AS `approved_date`,
		IF(DATE(fa.`delivery_date`) = '0000-00-00', '', DATE(fa.`delivery_date`)) AS `delivery_date`,
		IF(DATE(fa.`settled_date`) = '0000-00-00', '', DATE(fa.`settled_date`)) AS `settled_date`,
		fa.`created_at`, fa.`last_updated`,
		
		IF(DATE(fa.`client_agreed_date`) = '0000-00-00', '', TIME(fa.`client_agreed_date`)) AS `client_agreed_time`,

		(SELECT COALESCE(SUM(`price`), 0.00) 
			FROM `quote_options` 
			WHERE `fk_quote` = `quote_id` AND `deprecated` <> 1
		) AS `options_total`,

		(SELECT COALESCE(SUM(`price`), 0.00) 
			FROM `quote_accessories` 
			WHERE `fk_quote` = `quote_id` AND `deprecated` <> 1
		) AS `accessories_total`,

		(SELECT COALESCE(SUM(`amount`), 0.00) 
			FROM payments WHERE fk_payment_type = 2 AND fk_lead = `lead_id` AND deprecated <> 1
		) AS `deposits_total`,

		(SELECT COALESCE(SUM(`amount`), 0.00) 
			FROM payments WHERE fk_payment_type = 7 AND fk_lead = `lead_id` AND deprecated <> 1
		) AS `refunds_total`,
		
		(SELECT COALESCE(SUM(`amount`), 0.00) 
			FROM payments WHERE fk_payment_type = 8 AND fk_lead = `lead_id` AND deprecated <> 1
		) AS `deposit_trans_total`,

		(SELECT COALESCE(SUM(`amount`), 0.00) 
			FROM payments WHERE fk_payment_type = 2 AND fk_lead = `lead_id` AND show_status = 1 AND deprecated <> 1
		) AS `shown_deposits_total`,

		(SELECT COALESCE(SUM(`amount`), 0.00) 
			FROM payments WHERE fk_payment_type = 7 AND fk_lead = `lead_id` AND show_status = 1 AND deprecated <> 1
		) AS `shown_refunds_total`,
		
		(SELECT COALESCE(SUM(`amount`), 0.00)
			FROM payments WHERE fk_payment_type = 8 AND fk_lead = `lead_id` AND show_status = 1 AND deprecated <> 1
		) AS `shown_deposit_trans_total`,

		(SELECT COALESCE(SUM(`merchant_cost`), 0.00) 
			FROM payments WHERE fk_lead = `lead_id` AND deprecated <> 1
		) AS `merchant_cost_total`,

		

		IF (((fa.`edited_dealer_delivery` IS NULL) OR (fa.`edited_dealer_delivery` = 0)), q.`predelivery`, fa.`edited_dealer_delivery`) AS `edited_dealer_delivery`,
		IF (((fa.`edited_dealer_discount` IS NULL) OR (fa.`edited_dealer_discount` = 0)), q.`dealer_discount`, fa.`edited_dealer_discount`) AS `edited_dealer_discount`,
		IF (((fa.`edited_fleet_discount` IS NULL) OR (fa.`edited_fleet_discount` = 0)), q.`fleet_discount`, fa.`edited_fleet_discount`) AS `edited_fleet_discount`,
		IF (((fa.`edited_registration` IS NULL) OR (fa.`edited_registration` = 0)), q.`registration`, fa.`edited_registration`) AS `edited_registration`,
		IF (((fa.`edited_ctp` IS NULL) OR (fa.`edited_ctp` = 0)), q.`ctp`, fa.`edited_ctp`) AS `edited_ctp`,

		fa.`delivery_address`, fa.`delivery_address_map`, fa.`delivery_instructions`, fa.`special_conditions`, fa.`delivery_address_map` ,
		fa.`tradein_value`, fa.`tradein_payout`, fa.`tradein_given`,
		fa.`balcqo_client`, fa.`sales_price`, fa.`cpp`,
		fa.`gross_subtractor`, fa.`gross_subtractor_lower`,
		fa.`other_costs_amount`, fa.`other_costs_description`, fa.`other_qs_revenue_amount`, fa.`other_qs_revenue_description`, fa.`aftersales_accessory_revenue`,
		fa.`other_revenue_amount`, fa.`other_revenue_description`, fa.`deduct_to_dealer_invoice` as `deduct_to_dealer_invoice`, 
		fa.`fk_bank_account` as `fk_bank_account`,

		(SELECT COUNT(1) FROM `actions` WHERE `id` = `lead_id` AND `details` = 'Called Client') AS `called_count`,
		
		(SELECT COUNT(1) FROM `call_logs` WHERE `fk_lead` = `lead_id`) AS `attempt_count`,

		DATEDIFF(NOW(), fa.`created_at`) AS `age`

		FROM `fq_accounts_new` AS `fa`
		LEFT JOIN `users` AS `qs` ON fa.`fk_user` = qs.`id_user`
		LEFT JOIN `quote_requests` AS `qr` ON fa.`id_fq_account` = qr.`fk_lead`
		LEFT JOIN `makes` AS `m` ON qr.`make` = m.`id_make`
		LEFT JOIN `families` AS `f` ON qr.`model` = f.`id_family`
		LEFT JOIN `vehicles` AS `v` ON qr.`variant` = v.`id_vehicle`
		LEFT JOIN `quotes` AS `q` ON qr.`winner` = q.`id_quote`
		LEFT JOIN `users` AS `d` ON q.`fk_user` = d.`id_user`
		LEFT JOIN `dealer_attributes` AS `da` ON d.`id_user` = da.`fk_user`
		
		WHERE fa.id_fq_account = '".$lead_id."' ORDER BY qr.id_quote_request DESC LIMIT 1";//WHERE fa.id_fq_account = '1' LIMIT 1";
		//echo $query;
		return $this->db->query($query)->row_array();
	}

	public function get_deal ($lead_id)
	{
		$query = "
		SELECT
		fa.id_fq_account, fa.id_fq_account AS `lead_id`,
		qr.id_quote_request, qr.id_quote_request AS `qr_id`,		

		qs.id_user, qs.name AS `qs_name`, qs.username AS `qs_email`, qs.phone AS `qs_phone`,
		
		fa.lead_name, fa.business_name, fa.lead_email, fa.lead_state, fa.lead_postcode, fa.lead_address, fa.lead_phone, fa.lead_mobile, 
		 fa.driver_license, fa.details,

		da.dealership_name as `dealership_name`,
		d.name as `fleet_manager`,
		d.`abn` AS `dealer_abn`, 
		d.`dealer_license`, 
		d.username as `dealer_email`,
		d.phone as `dealer_phone`,
		d.mobile as `dealer_mobile`,
		d.state as `dealer_state`,
		d.postcode as `dealer_postcode`,
		d.address as `dealer_address`,
		d.deposit_show_status,
		m.name as `make`,
		f.name as `model`,
		v.name as `variant`,
		qr.build_date, qr.series, qr.body_type, qr.registration_type, qr.colour, qr.transmission, qr.fuel_type, 

		qr.winner,
		q.total as `winning_price`, 
		(SELECT COUNT(1) FROM quotes WHERE fk_quote_request = `qr_id`) AS `quote_count`,
		DATE(fa.order_date) AS `order_date`, 
		qr.message AS `qr_message`,

		q.id_quote, q.sender, q.total, 
		q.retail_price, q.compliance_date, q.predelivery, q.gst, q.stamp_duty, q.registration, q.premium_plate_fee, q.ctp, 
		q.luxury_tax, q.fleet_discount, q.dealer_discount,
		fa.`accessory_status`, fa.`accessory_special_conditions`, 
		IF (DATE(fa.`accessory_job_date`) = '0000-00-00', '', DATE(fa.`accessory_job_date`)) AS `accessory_job_date`,

		fa.status,
		CONCAT('QM', LPAD(fa.id_fq_account, 5, '0')) AS `cq_number`,
		CONCAT('PO', LPAD(fa.id_fq_account, 5, '0')) AS `po_number`,
		CONCAT('TID', LPAD(fa.id_fq_account, 5, '0')) AS `dealer_invoice_number`,
		CONCAT('TIC', LPAD(fa.id_fq_account, 5, '0')) AS `client_invoice_number`,

		CASE (fa.`status`)
			WHEN 4 THEN 'Admin on Hold'
			WHEN 5 THEN 'Approved by Admin'
			WHEN 98 THEN 'Deal Declined'
			WHEN 6 THEN 'Delivered'
			WHEN 7 THEN 'Settled'
		END `status_text`,
		
		fa.`client_status`,
		CASE (fa.`client_status`)
			WHEN 0 THEN 'Pending Client Approval'
			WHEN 1 THEN 'Agreement Seen'
			WHEN 2 THEN 'Approved by Client'
			WHEN 3 THEN 'Awaiting Approval'
		END `client_status_text`,		

		IF(DATE(fa.delivery_date) = '0000-00-00', '', DATE(fa.delivery_date)) AS `delivery_date`,
		IF(DATE(fa.settled_date) = '0000-00-00', '', DATE(fa.settled_date)) AS `settled_date`,
		fa.created_at, fa.last_updated,
		
		(SELECT COALESCE(SUM(`amount`), 0.00) 
			FROM payments WHERE fk_payment_type = 2 AND fk_lead = `lead_id` AND deprecated <> 1
		) AS `deposits_total`,

		(SELECT COALESCE(SUM(`amount`), 0.00) 
			FROM payments WHERE fk_payment_type = 7 AND fk_lead = `lead_id` AND deprecated <> 1
		) AS `refunds_total`,
		
		(SELECT COALESCE(SUM(`amount`), 0.00) 
			FROM payments WHERE fk_payment_type = 8 AND fk_lead = `lead_id` AND deprecated <> 1
		) AS `deposit_trans_total`,

		(SELECT COALESCE(SUM(`amount`), 0.00) 
			FROM payments WHERE fk_payment_type = 2 AND fk_lead = `lead_id` AND show_status = 1 AND deprecated <> 1
		) AS `shown_deposits_total`,

		(SELECT COALESCE(SUM(`amount`), 0.00) 
			FROM payments WHERE fk_payment_type = 7 AND fk_lead = `lead_id` AND show_status = 1 AND deprecated <> 1
		) AS `shown_refunds_total`,
		
		(SELECT COALESCE(SUM(`amount`), 0.00)
			FROM payments WHERE fk_payment_type = 8 AND fk_lead = `lead_id` AND show_status = 1 AND deprecated <> 1
		) AS `shown_deposit_trans_total`,
		
		(SELECT COALESCE(SUM(`merchant_cost`), 0.00) 
			FROM payments WHERE fk_lead = `lead_id` AND deprecated <> 1
		) AS `merchant_cost_total`,		

		fa.tradein_value, fa.tradein_payout, fa.tradein_given,

		fa.balcqo_client, fa.cpp, fa.sales_price, fa.gross_subtractor, fa.gross_subtractor_lower, 
		fa.delivery_address, fa.delivery_address_map, fa.delivery_instructions, fa.special_conditions,
		fa.other_costs_amount, fa.other_costs_description, fa.other_revenue_amount, fa.other_revenue_description,

		fa.`answer_act`, fa.`answer_vic`, fa.`answer_qld`, fa.`fuel_efficient_flag`,
		fa.invoice_issued_date, fa.invoice_payment_due_date, fa.invoice_dealer_license, fa.invoice_vin, fa.invoice_km, fa.invoice_engine_number,

		fa.i_issued_date, fa.i_payment_due_date,
		fa.i_list_price, fa.i_options, fa.i_accessories, fa.i_dealer_delivery, fa.i_subtotal_1,
		fa.i_discount, fa.i_subtotal_2,
		fa.i_gst, fa.i_lct, fa.i_stamp_duty, fa.i_registration, fa.i_ctp, fa.i_total_price,
		fa.i_deposit, fa.i_tradein, fa.i_payout, fa.i_refunds, fa.i_balance

		FROM fq_accounts_new fa
		JOIN users qs ON fa.fk_user = qs.id_user
		JOIN quote_requests qr ON fa.id_fq_account = qr.fk_lead
		JOIN makes m ON qr.make = m.id_make
		JOIN families f ON qr.model = f.id_family
		LEFT JOIN vehicles v ON qr.variant = v.id_vehicle
		JOIN quotes q ON qr.winner = q.id_quote
		JOIN users d ON q.fk_user = d.id_user
		JOIN dealer_attributes da ON d.id_user = da.fk_user
		WHERE fa.status IN (4, 5, 6, 7, 8) AND fa.id_fq_account = ".$lead_id." LIMIT 1";
		return $this->db->query($query)->row_array();
	}

	public function get_previous_lead_id ($lead_id, $user_id)
	{
		$query = "
		SELECT id_fq_account FROM fq_accounts_new 
		WHERE id_fq_account < '".$this->db->escape_str($lead_id)."' AND fk_user = '".$this->db->escape_str($user_id)."'
		ORDER BY id_fq_account DESC LIMIT 1";
		return $this->db->query($query)->row_array();
	}
	
	public function get_next_lead_id ($lead_id, $user_id)
	{
		$query = "
		SELECT id_fq_account FROM fq_accounts_new 
		WHERE id_fq_account > '".$this->db->escape_str($lead_id)."' AND fk_user = '".$this->db->escape_str($user_id)."'
		ORDER BY id_fq_account ASC LIMIT 1";
		return $this->db->query($query)->row_array();
	}	
	
	public function update_lead_details ($lead_arr)
	{
		$query_fields = '';
		
		if (isset($lead_arr['status'])) { $query_fields .= " status = '".$this->db->escape_str($lead_arr['status'])."',"; }
		if (isset($lead_arr['client_status'])) { $query_fields .= " client_status = '".$this->db->escape_str($lead_arr['client_status'])."',"; }
		if (isset($lead_arr['dealer_status'])) { $query_fields .= " dealer_status = '".$this->db->escape_str($lead_arr['dealer_status'])."',"; }
		if (isset($lead_arr['accounts_status'])) { $query_fields .= " accounts_status = '".$this->db->escape_str($lead_arr['accounts_status'])."',"; }
		if (isset($lead_arr['accounts_update_status'])) { $query_fields .= " accounts_update_status = '".$this->db->escape_str($lead_arr['accounts_update_status'])."',"; }
		if (isset($lead_arr['admin_status'])) { $query_fields .= " admin_status = '".$this->db->escape_str($lead_arr['admin_status'])."',"; }
		
		if (isset($lead_arr['deal_flag'])) { $query_fields .= " deal_flag = '".$this->db->escape_str($lead_arr['deal_flag'])."',"; }

		// TO BE DELETED (Start) //
		if (isset($lead_arr['fuel_efficient_flag'])) { $query_fields .= " invoice_fuel_efficient_flag = '".$this->db->escape_str($lead_arr['fuel_efficient_flag'])."',"; }
		if (isset($lead_arr['edited_dealer_delivery'])) { $query_fields .= " edited_dealer_delivery = '".$this->db->escape_str($lead_arr['edited_dealer_delivery'])."',"; }
		if (isset($lead_arr['edited_dealer_discount'])) { $query_fields .= " edited_dealer_discount = '".$this->db->escape_str($lead_arr['edited_dealer_discount'])."',"; }
		if (isset($lead_arr['edited_fleet_discount'])) { $query_fields .= " edited_fleet_discount = '".$this->db->escape_str($lead_arr['edited_fleet_discount'])."',"; }
		if (isset($lead_arr['edited_registration'])) { $query_fields .= " edited_registration = '".$this->db->escape_str($lead_arr['edited_registration'])."',"; }
		if (isset($lead_arr['edited_ctp'])) { $query_fields .= " edited_ctp = '".$this->db->escape_str($lead_arr['edited_ctp'])."',"; }
		// TO BE DELETED (End) //
		
		if (isset($lead_arr['answer_act'])) { $query_fields .= " answer_act = '".$this->db->escape_str($lead_arr['answer_act'])."',"; }
		if (isset($lead_arr['answer_vic'])) { $query_fields .= " answer_vic = '".$this->db->escape_str($lead_arr['answer_vic'])."',"; }
		if (isset($lead_arr['answer_qld'])) { $query_fields .= " answer_qld = '".$this->db->escape_str($lead_arr['answer_qld'])."',"; }
		
		if (isset($lead_arr['sales_price'])) { $query_fields .= " sales_price = '".$this->db->escape_str($lead_arr['sales_price'])."',"; }
		if (isset($lead_arr['tradein_value'])) { $query_fields .= " tradein_value = '".$this->db->escape_str($lead_arr['tradein_value'])."',"; }
		if (isset($lead_arr['tradein_payout'])) { $query_fields .= " tradein_payout = '".$this->db->escape_str($lead_arr['tradein_payout'])."',"; }
		if (isset($lead_arr['tradein_given'])) { $query_fields .= " tradein_given = '".$this->db->escape_str($lead_arr['tradein_given'])."',"; }		
		if (isset($lead_arr['cpp'])) { $query_fields .= " cpp = '".$this->db->escape_str($lead_arr['cpp'])."',"; }
		if (isset($lead_arr['balcqo_client'])) { $query_fields .= " balcqo_client = '".$this->db->escape_str($lead_arr['balcqo_client'])."',"; }

		if (isset($lead_arr['other_costs_amount'])) { $query_fields .= " other_costs_amount = '".$this->db->escape_str($lead_arr['other_costs_amount'])."',"; }
		if (isset($lead_arr['other_costs_description'])) { $query_fields .= " other_costs_description = '".$this->db->escape_str($lead_arr['other_costs_description'])."',"; }
		if (isset($lead_arr['other_revenue_amount'])) { $query_fields .= " other_revenue_amount = '".$this->db->escape_str($lead_arr['other_revenue_amount'])."',"; }
		if (isset($lead_arr['other_revenue_description'])) { $query_fields .= " other_revenue_description = '".$this->db->escape_str($lead_arr['other_revenue_description'])."',"; }
		if (isset($lead_arr['other_qs_revenue_amount'])) { $query_fields .= " other_qs_revenue_amount = '".$this->db->escape_str($lead_arr['other_qs_revenue_amount'])."',"; }
		if (isset($lead_arr['other_qs_revenue_description'])) { $query_fields .= " other_qs_revenue_description = '".$this->db->escape_str($lead_arr['other_qs_revenue_description'])."',"; }

		if (isset($lead_arr['assignment_date'])) { $query_fields .= " assignment_date = '".$this->db->escape_str($lead_arr['assignment_date'])."',"; }
		if (isset($lead_arr['attempted_date'])) { $query_fields .= " attempted_date = '".$this->db->escape_str($lead_arr['attempted_date'])."',"; }
		if (isset($lead_arr['order_date'])) { $query_fields .= " order_date = '".$this->db->escape_str($lead_arr['order_date'])."',"; }
		if (isset($lead_arr['delivery_date'])) { $query_fields .= " delivery_date = '".$this->db->escape_str($lead_arr['delivery_date'])."',"; }
		if (isset($lead_arr['settled_date'])) { $query_fields .= " settled_date = '".$this->db->escape_str($lead_arr['settled_date'])."',"; }

		if (isset($lead_arr['delivery_address'])) { $query_fields .= " delivery_address = '".$this->db->escape_str($lead_arr['delivery_address'])."',"; }
		if (isset($lead_arr['delivery_address_map'])) { $query_fields .= " delivery_address_map = '".$this->db->escape_str($lead_arr['delivery_address_map'])."',"; }
		if (isset($lead_arr['delivery_instructions'])) { $query_fields .= " delivery_instructions = '".$this->db->escape_str($lead_arr['delivery_instructions'])."',"; }
		if (isset($lead_arr['special_conditions'])) { $query_fields .= " special_conditions = '".$this->db->escape_str($lead_arr['special_conditions'])."',"; }				
		
		if (isset($lead_arr['admin_details'])) { $query_fields .= " admin_details = '".$this->db->escape_str($lead_arr['admin_details'])."',"; }
		if (isset($lead_arr['admin_to_qs_details'])) { $query_fields .= " admin_to_qs_details = '".$this->db->escape_str($lead_arr['admin_to_qs_details'])."',"; }

		if (isset($lead_arr['name'])) { $query_fields .= " name = '".$this->db->escape_str($lead_arr['name'])."',"; }
		if (isset($lead_arr['business_name'])) { $query_fields .= " business_name = '".$this->db->escape_str($lead_arr['business_name'])."',"; }
		if (isset($lead_arr['abn'])) { $query_fields .= " abn = '".$this->db->escape_str($lead_arr['abn'])."',"; }
		if (isset($lead_arr['facsimile'])) { $query_fields .= " facsimile = '".$this->db->escape_str($lead_arr['facsimile'])."',"; }
		if (isset($lead_arr['occupation'])) { $query_fields .= " occupation = '".$this->db->escape_str($lead_arr['occupation'])."',"; }
		if (isset($lead_arr['email'])) { $query_fields .= " email = '".$this->db->escape_str($lead_arr['email'])."',"; }
		if (isset($lead_arr['alternate_email_1'])) { $query_fields .= " alternate_email_1 = '".$this->db->escape_str($lead_arr['alternate_email_1'])."',"; }
		if (isset($lead_arr['alternate_email_2'])) { $query_fields .= " alternate_email_2 = '".$this->db->escape_str($lead_arr['alternate_email_2'])."',"; }
		if (isset($lead_arr['state'])) { $query_fields .= " state = '".$this->db->escape_str($lead_arr['state'])."',"; }
		if (isset($lead_arr['postcode'])) { $query_fields .= " postcode = '".$this->db->escape_str($lead_arr['postcode'])."',"; }
		if (isset($lead_arr['address'])) { $query_fields .= " address = '".$this->db->escape_str($lead_arr['address'])."',"; }
		if (isset($lead_arr['phone'])) { $query_fields .= " phone = '".$this->db->escape_str($lead_arr['phone'])."',"; }
		if (isset($lead_arr['alternate_phone'])) { $query_fields .= " alternate_phone = '".$this->db->escape_str($lead_arr['alternate_phone'])."',"; }
		if (isset($lead_arr['mobile'])) { $query_fields .= " mobile = '".$this->db->escape_str($lead_arr['mobile'])."',"; }
		if (isset($lead_arr['alternate_mobile'])) { $query_fields .= " alternate_mobile = '".$this->db->escape_str($lead_arr['alternate_mobile'])."',"; }
		if (isset($lead_arr['date_of_birth'])) { $query_fields .= " date_of_birth = '".$this->db->escape_str($lead_arr['date_of_birth'])."',"; }
		if (isset($lead_arr['driver_license'])) { $query_fields .= " driver_license = '".$this->db->escape_str($lead_arr['driver_license'])."',"; }

		if (isset($lead_arr['details'])) { $query_fields .= " details = '".$this->db->escape_str($lead_arr['details'])."',"; }

		if (isset($lead_arr['accessory_special_conditions'])) { $query_fields .= " accessory_special_conditions = '".$this->db->escape_str($lead_arr['accessory_special_conditions'])."',"; }		
		if (isset($lead_arr['accessory_order_date'])) { $query_fields .= " accessory_order_date = '".$this->db->escape_str($lead_arr['accessory_order_date'])."',"; }
		if (isset($lead_arr['accessory_job_date'])) { $query_fields .= " accessory_job_date = '".$this->db->escape_str($lead_arr['accessory_job_date'])."',"; }
		if (isset($lead_arr['aftersales_accessory_revenue'])) { $query_fields .= " aftersales_accessory_revenue = '".$this->db->escape_str($lead_arr['aftersales_accessory_revenue'])."',"; }

		if (isset($lead_arr['deduct_to_dealer_invoice'])) { $query_fields .= " deduct_to_dealer_invoice = '".$lead_arr['deduct_to_dealer_invoice']."',"; }
		if (isset($lead_arr['delivery_address_map'])) { $query_fields .= " delivery_address_map = '".$lead_arr['delivery_address_map']."',"; }

		if (isset($lead_arr['client_signature_url'])) { $query_fields .= " client_signature_url = '".$this->db->escape_str($lead_arr['client_signature_url'])."',"; }
		if (isset($lead_arr['fk_bank_account'])) { $query_fields .= " fk_bank_account = '".$this->db->escape_str($lead_arr['fk_bank_account'])."',"; }
		if (isset($lead_arr['transport'])) { $query_fields .= " transport = '".$this->db->escape_str($lead_arr['transport'])."',"; }
		if (isset($lead_arr['transport_cost'])) { $query_fields .= " transport_cost = '".$this->db->escape_str($lead_arr['transport_cost'])."',"; }
		if (isset($lead_arr['deposit'])) { $query_fields .= " deposit = '".$this->db->escape_str($lead_arr['deposit'])."',"; }

		if (isset($lead_arr['delete_reason'])) { $query_fields .= " delete_reason = '".$this->db->escape_str($lead_arr['delete_reason'])."',"; }
		if (isset($lead_arr['deal_cancel_reason'])) { $query_fields .= " deal_cancel_reason = '".$this->db->escape_str($lead_arr['deal_cancel_reason'])."',"; }
		
		if (isset($lead_arr['client_invoice_taxes'])) { $query_fields .= " client_invoice_taxes = '".$lead_arr['client_invoice_taxes']."',"; }

		$now = date("Y-m-d H:i:s");
		$query = "UPDATE `fq_accounts_new` SET ".$query_fields." last_updated = '".$now."' WHERE `id_fq_account` = ".$lead_arr['id_lead'];
		return $this->db->query($query);
	}	
	
	public function get_lead_files ($lead_id, $fk_user = 0)
	{
		$where = "";
		if ($fk_user <> 0) 
		{
			$where .= " AND `fk_user` = '".$fk_user."' "; 
		}
		$query = "SELECT * FROM file_attachments WHERE `fk_main` = '".$lead_id."' AND `type` = '6' ".$where;
		return $this->db->query($query)->result_array();		
	}

	public function get_dealer_files ($lead_id, $fk_user = 0)
	{
		$where = "";
		if ($fk_user <> 0) 
		{ 
			$where .= " AND `fk_user` = '".$fk_user."' "; 
		}
		$query = "SELECT * FROM file_attachments WHERE `fk_main` = '".$lead_id."' AND `type` = '7' ".$where;
		return $this->db->query($query)->result_array();
	}
	
	public function get_lead_comments ($lead_id)
	{
		$query = "
		SELECT 
		c.id_comment, c.comment, c.created_at, u.id_user, u.name AS `sender`,
		GROUP_CONCAT(ca.file_name) AS `attachments`
		FROM comments c 
		JOIN users u ON c.fk_user = u.id_user
		LEFT JOIN comment_attachments ca ON c.id_comment = ca.fk_comment
		WHERE c.fk_main = '".$lead_id."' AND c.type = 1
		GROUP BY c.id_comment
		ORDER BY c.id_comment DESC";
		return $this->db->query($query)->result_array();
	}	
	
	public function get_lead_emails ($params)
	{
		$where = "";
		if ($params['email'] <> "")
		{
			$where .= " 
			OR e.sender LIKE '%".$this->db->escape_str($params['email'])."%' 
			OR e.recipient LIKE '%".$this->db->escape_str($params['email'])."%' ";
		}

		$query = "
		SELECT 
		e.id_email, e.fk_lead, e.gmail_id, e.thread_id, 
		REPLACE(REPLACE(REPLACE(REPLACE(SUBSTRING_INDEX(e.sender, ' <', 1), '\"', ''), '<', ''), '>', ''), '\\'', '') AS `sender_name`,
		SUBSTRING_INDEX(SUBSTRING_INDEX(e.sender, '<', -1), '>', 1) AS `sender_email`,
		REPLACE(REPLACE(REPLACE(REPLACE(SUBSTRING_INDEX(e.recipient, ' <', 1), '\"', ''), '<', ''), '>', ''), '\\'', '') AS `recipient_name`,
		SUBSTRING_INDEX(SUBSTRING_INDEX(e.recipient, '<', -1), '>', 1) AS `recipient_email`,		
		e.received_date, e.subject,
		SUBSTRING_INDEX(e.content, '\nOn', 1) AS `content`, GROUP_CONCAT(ea.filename) AS `files`
		FROM emails e
		LEFT JOIN email_attachments ea ON e.id_email = ea.fk_email
		WHERE e.subject LIKE '%".$this->db->escape_str($params['cq_number'])."%'
		".$where."
		GROUP BY e.id_email
		ORDER BY e.received_date DESC";
		return $this->db->query($query)->result_array();
	}

	public function get_lead_call_status ()
	{
		$query = "SELECT * FROM call_status WHERE deprecated <> 1 ORDER BY id_call_status ASC";
		return $this->db->query($query)->result_array();		
	}
	
	public function get_lead_call_logs ($lead_id)
	{
		$query = "
		SELECT cl.`id_call_log`, cl.`details`, cs.`name` AS `call_status`, u.`name` AS `user`, cl.`created_at`
		FROM call_logs cl
		JOIN call_status cs ON cl.`fk_call_status` = cs.`id_call_status`
		JOIN users u ON cl.`fk_user` = u.`id_user`
		WHERE cl.`fk_lead` = '".$this->db->escape_str($lead_id)."' 
		AND cl.`deprecated` <> 1";
		return $this->db->query($query)->result_array();		
	}
	
	public function get_lead_events ($input_arr)
	{
		$where = "";
		
		foreach ($input_arr AS $index => $value)
		{
			$where .= " AND le.`".$index."` = '".$this->db->escape_str($value)."'";
		}
		
		$query = "
		SELECT 
		fa.id_fq_account,
		CONCAT('QM', LPAD(fa.`id_fq_account`, 5, '0')) AS `cq_number`,
		fa.lead_name AS `client_name`,
		
		le.`id_lead_event`, le.`details`, le.`status`, le.`date`, le.`time`, u.`name` AS `user`
		FROM lead_events le
		JOIN fq_accounts_new fa ON le.fk_lead = fa.id_fq_account
		JOIN users u ON le.`fk_user` = u.`id_user`
		WHERE le.`deprecated` <> 1 ".$where."";
		return $this->db->query($query)->result_array();		
	}	
	
	public function get_lead_event ($lead_event_id)
	{
		$query = "
		SELECT le.`id_lead_event`, le.`details`, le.`status`, le.`date`, le.`time`, u.`name` AS `user`
		FROM lead_events le
		JOIN users u ON le.`fk_user` = u.`id_user`
		WHERE le.`deprecated` <> 1 
		AND le.`id_lead_event` = '".$this->db->escape_str($lead_event_id)."'";
		return $this->db->query($query)->row_array();	
	}
	
	public function get_lead_suggested_tradeins ($name, $email, $phone, $mobile)
	{
		$phone_query = "";
		if (strlen($phone) > 5) { $phone_query = " OR t.phone = '".$this->db->escape_str($phone)."' "; }
		
		$mobile_query = "";
		if (strlen($mobile) > 5) { $mobile_query = " OR t.phone = '".$this->db->escape_str($mobile)."' "; }		
		
		$query = "
		SELECT 
		t.id_tradein, t.fk_lead, t.dealer_visibility,
		t.first_name, t.last_name, t.email, t.phone, t.state, t.postcode,
		t.tradein_value, t.tradein_given, t.tradein_payout,
		t.tradein_make, t.tradein_model, t.tradein_variant, t.tradein_build_date, t.tradein_kms,
		t.tradein_colour, t.tradein_transmission,
		tv.value,
		u.id_user, u.username, u.name, t.image_1, t.id_tradein, t.created_at
		FROM tradeins t
		LEFT JOIN trade_valuations tv ON t.fk_trade_valuation = tv.id_trade_valuation
		LEFT JOIN users u ON tv.fk_user = u.id_user
		WHERE 
			t.email = '".$this->db->escape_str($email)."' OR 
			CONCAT(t.first_name, ' ', t.last_name) = '".$this->db->escape_str($name)."'
			".$phone_query." 
			".$mobile_query."
		ORDER BY t.id_tradein DESC";
		return $this->db->query($query)->result_array();
	}
	
	public function get_lead_attached_tradeins ($lead_id)
	{
		//echo json_encode ($lead_id); die();
		$query = "
		SELECT 
		t.id_tradein, 
		t.id_tradein AS `tradein_id`,
		t.fk_lead, t.dealer_visibility, t.image_1, 
		t.first_name, t.last_name, t.email, t.phone, t.state, t.postcode,
		t.tradein_value, t.tradein_given, t.tradein_payout,
		t.tradein_make, t.tradein_model, t.tradein_variant, t.tradein_build_date, t.tradein_kms,
		t.tradein_colour, t.tradein_transmission,
		(SELECT COUNT(1) FROM trade_valuations WHERE fk_tradein = `tradein_id`) AS `trade_valuation_count`,
		tv.value,
		u.id_user, u.username, u.name, 
		t.created_at
		FROM tradeins t
		LEFT JOIN trade_valuations tv ON t.fk_trade_valuation = tv.id_trade_valuation
		LEFT JOIN users u ON tv.fk_user = u.id_user
		WHERE t.fk_lead = '".$lead_id."'
		ORDER BY t.id_tradein DESC";
		return $this->db->query($query)->result_array();
	}		
	
	public function get_deal_accessories ($lead_id)
	{
		$query = "
		SELECT 
		da.id_deal_accessory, a.id_accessory, 
		a.code AS `accessory_code`, a.name AS `accessory_name`, a.cost AS `accessory_cost`,
		a_s.name AS `accessory_supplier_name`,
		da.price, da.quantity
		FROM deal_accessories da
		JOIN accessories a ON da.fk_accessory = a.id_accessory
		JOIN accessory_suppliers a_s ON a.fk_accessory_supplier = a_s.id_accessory_supplier
		WHERE da.deprecated <> 1 AND da.fk_lead = '".$this->db->escape_str($lead_id)."'
		ORDER BY a.name ASC";
		return $this->db->query($query)->result_array();
	}

	public function get_lead_car_ids ($lead_id,$from='')
	{
		if($from == 'start_tender_form') {
			$make_query = "
				SELECT `make` AS `make_name`, `modal` AS `model_name`,
				(SELECT id_make FROM makes WHERE `name` = `make_name` LIMIT 1) AS `id_make`,
				(SELECT id_family FROM families WHERE `name` = `model_name` LIMIT 1) AS `id_family`
				FROM fq_lead_dealer_data WHERE fq_lead_id = ".$this->db->escape_str($lead_id);
		}
		else {
			$make_query = "
			SELECT `make` AS `make_name`, `model` AS `model_name`,
			(SELECT id_make FROM makes WHERE `name` = `make_name` LIMIT 1) AS `id_make`,
			(SELECT id_family FROM families WHERE `name` = `model_name` LIMIT 1) AS `id_family`
			FROM fq_accounts_new WHERE id_fq_account = ".$this->db->escape_str($lead_id);
		}

		$result =  $this->db->query($make_query)->row_array();

		if($result['id_make']=="" || $result['id_family']=="")
		{
			$make_query = "
			SELECT `make` AS `make_name`, `modal` AS `model_name`,
			(SELECT id_make FROM makes WHERE `name` = `make_name` LIMIT 1) AS `id_make`,
			(SELECT id_family FROM families WHERE `name` = `model_name` LIMIT 1) AS `id_family`
			FROM fq_lead_dealer_data WHERE fq_lead_id = ".$this->db->escape_str($lead_id);

			$results =  $this->db->query($make_query)->row_array();
			
			$output_array = [
				'id_make'   => $results['id_make'],
				'id_family' => $results['id_family'],
				'make_name' =>  $results['make_name']
			];
		}
		else
		{
			$output_array = [
				'id_make'   => $result['id_make'],
				'id_family' => $result['id_family'],
				'make_name' =>  $result['make_name']
			];
		}
			
		return $output_array;
	}

	public function get_accountant_email_templates ($email_ids = [21,22,23,25,26])
	{
		$email_ids_string = implode(",", $email_ids);
		$query = "SELECT * FROM email_templates WHERE id_email_template IN ({$email_ids_string})";
		return $this->db->query($query)->result_array();
	}	
	
	public function get_dealer_selector_parameters ($lead_id = 0, $type)
	{
		/*-------------------------Added by MM : START---------------------------------------*/
		
		$make_query = "
		SELECT `make` AS `make_name`, `model` AS `model_name`, lead_state,
		(SELECT id_make FROM makes WHERE `name` = `make_name` LIMIT 1) AS `id_make`,
		(SELECT id_family FROM families WHERE `name` = `model_name` LIMIT 1) AS `id_family`
		FROM fq_accounts_new WHERE id_fq_account = ".$this->db->escape_str($lead_id);
		
		$result =  $this->db->query($make_query)->row_array();

		if($result['id_make']=="" || $result['id_family']=="")
		{
			$make_query = "
			SELECT `make` AS `make_name`, `modal` AS `model_name`,
			(SELECT id_make FROM makes WHERE `name` = `make_name` LIMIT 1) AS `id_make`,
			(SELECT id_family FROM families WHERE `name` = `model_name` LIMIT 1) AS `id_family`
			FROM fq_lead_dealer_data WHERE fq_lead_id = ".$this->db->escape_str($lead_id);
			
			$results =  $this->db->query($make_query)->row_array();
			
			$output_array = [
				'make'   => $results['make_name'],
				'state' => "",
				
			];
		}
		else
		{
			$output_array = [
				'make'   => $result['make_name'],
				'state' => $result['lead_state'],
			];
		}
			
		return $output_array;die();
		/*-------------------------Added by MM : END---------------------------------------*/
		
		$dealer_request_query  = "
		SELECT
		fa.`id_fq_account` as `lead_id`,
		fa.`id_fq_account`, fa.`lead_name`, fa.`lead_email`, fa.`lead_email` as `lead_email`,
		qr.`id_quote_request` AS `qr_id`,
		fa.`lead_postcode`, fa.`lead_state`,
		m.`id_make`, m.`name` AS `make`,
		f.`id_family`, f.`name` AS `model`
		FROM fq_accounts_new fa
		JOIN quote_requests qr ON fa.`id_fq_account` = qr.`fk_lead`
		LEFT JOIN `makes` AS `m` ON qr.`make` = m.`id_make`
		LEFT JOIN `families` AS `f` ON qr.`model` = f.`id_family`
		LEFT JOIN `vehicles` AS `v` ON qr.`variant` = v.`id_vehicle`
		WHERE fa.`id_fq_account` = '".$this->db->escape_str($lead_id)."'
		AND fa.`deprecated` <> 1
		GROUP BY fa.`id_fq_account`";
			
			$query = $dealer_request_query;

		 return $result = $this->db->query($query)->row_array(); die();
		$lead_query = "
		SELECT id_fq_account, make, model, state, lead_postcode 
		FROM fq_accounts_new

		WHERE id_fq_account = '".$this->db->escape_str($lead_id)."' 
		LIMIT 1";

		$query = "";

		if($type == "tender")
		{
			$query = $lead_query;
		}
		else
		{
			$query = $dealer_request_query;
		}

		$result = $this->db->query($query)->row_array();

		if (count($result) > 0)
		{
			$output_array = [
				'make'  => $result['make'],
				'state' => $result['state']
			];
		}
		else
		{
			$output_array = [
				'make'  => "",
				'state' => ""
			];	
		}

		return $output_array;
	}

	public function get_wholesaler_selector_parameters ($lead_id = 0, $type)
	{
		/*-------------------------Added by MM : START---------------------------------------*/
		
		$make_query = "
		SELECT `make` AS `make_name`, `model` AS `model_name`, lead_state,
		(SELECT id_make FROM makes WHERE `name` = `make_name` LIMIT 1) AS `id_make`,
		(SELECT id_family FROM families WHERE `name` = `model_name` LIMIT 1) AS `id_family`
		FROM fq_accounts_new WHERE id_fq_account = ".$this->db->escape_str($lead_id);
		
		$result =  $this->db->query($make_query)->row_array();

		if($result['id_make']=="" || $result['id_family']=="")
		{
			$make_query = "
			SELECT `make` AS `make_name`, `modal` AS `model_name`,
			(SELECT id_make FROM makes WHERE `name` = `make_name` LIMIT 1) AS `id_make`,
			(SELECT id_family FROM families WHERE `name` = `model_name` LIMIT 1) AS `id_family`
			FROM fq_lead_dealer_data WHERE fq_lead_id = ".$this->db->escape_str($lead_id);
			
			$results =  $this->db->query($make_query)->row_array();
			
			$output_array = [
				'make'   => $results['make_name'],
				'state' => "",
				
			];
		}
		else
		{
			$output_array = [
				'make'   => $result['make_name'],
				'state' => $result['lead_state'],
			];
		}
			
		return $output_array;die();
		/*-------------------------Added by MM : END---------------------------------------*/
		
		$dealer_request_query  = "
		SELECT
		fa.`id_fq_account` as `lead_id`,
		fa.`id_fq_account`, fa.`lead_name`, fa.`lead_email`, fa.`lead_email` as `lead_email`,
		qr.`id_quote_request` AS `qr_id`,
		fa.`lead_postcode`, fa.`lead_state`,
		m.`id_make`, m.`name` AS `make`,
		f.`id_family`, f.`name` AS `model`
		FROM fq_accounts_new fa
		JOIN quote_requests qr ON fa.`id_fq_account` = qr.`fk_lead`
		LEFT JOIN `makes` AS `m` ON qr.`make` = m.`id_make`
		LEFT JOIN `families` AS `f` ON qr.`model` = f.`id_family`
		LEFT JOIN `vehicles` AS `v` ON qr.`variant` = v.`id_vehicle`
		WHERE fa.`id_fq_account` = '".$this->db->escape_str($lead_id)."'
		AND fa.`deprecated` <> 1
		GROUP BY fa.`id_fq_account`";
			
		$query = $dealer_request_query;

	 	return $result = $this->db->query($query)->row_array(); die();
		$lead_query = "
		SELECT id_fq_account, make, model, state, lead_postcode 
		FROM fq_accounts_new

		WHERE id_fq_account = '".$this->db->escape_str($lead_id)."' 
		LIMIT 1";

		$query = "";

		if($type == "tender")
		{
			$query = $lead_query;
		}
		else
		{
			$query = $dealer_request_query;
		}

		$result = $this->db->query($query)->row_array();

		if (count($result) > 0)
		{
			$output_array = [
				'make'  => $result['make'],
				'state' => $result['state']
			];
		}
		else
		{
			$output_array = [
				'make'  => "",
				'state' => ""
			];	
		}

		return $output_array;
	}
	
	public function insert_lead_call_log ($fk_user, $input_arr)
	{
		$now = date("Y-m-d H:i:s");
		$query = "
		INSERT INTO call_logs (fk_lead, fk_user, fk_call_status, details, created_at) 
		VALUES 
		(
			'".$this->db->escape_str($input_arr['id_lead'])."', 
			'".$this->db->escape_str($fk_user)."', 
			'".$this->db->escape_str($input_arr['fk_call_status'])."', 
			'".$this->db->escape_str($input_arr['details'])."', 
			'".$now."'
		)";
		return $this->db->query($query);		
	}
	
	public function insert_lead_event ($fk_user, $input_arr)
	{
		$now = date("Y-m-d H:i:s");
		$query = "
		INSERT INTO lead_events (fk_lead, fk_user, date, time, details, created_at) 
		VALUES 
		(
			'".$this->db->escape_str($input_arr['id_lead'])."', 
			'".$this->db->escape_str($fk_user)."',
			'".$this->db->escape_str($input_arr['date'])."',
			'".$this->db->escape_str($input_arr['time'])."',
			'".$this->db->escape_str($input_arr['details'])."', 
			'".$now."'
		)";
		return $this->db->query($query);
	}

	public function insert_lead_file ($fk_user, $input_arr)
	{
		$now = date("Y-m-d H:i:s");
		$query = "
		INSERT INTO file_attachments (fk_user, fk_main, type, file_name, orig_filename, created_at) 
		VALUES 
		(
			'".$this->db->escape_str($fk_user)."',
			'".$this->db->escape_str($input_arr['id_lead'])."', 
			6,
			'".$this->db->escape_str($input_arr['file_name'])."',
			'',
			'".$now."'
		)";
		return $this->db->query($query);			
	}	

	public function delete_lead_event ($id_lead_event)
	{
		$now = date("Y-m-d H:i:s");
		$query = "UPDATE lead_events SET deprecated = 1 WHERE id_lead_event = '".$this->db->escape_str($id_lead_event)."'";
		return $this->db->query($query);
	}
	
	public function update_lead_event ($fk_user, $input_arr)
	{
		$now = date("Y-m-d H:i:s");
		$query = "
		UPDATE lead_events SET
		fk_user = '".$this->db->escape_str($fk_user)."',
		date = '".$this->db->escape_str($input_arr['date'])."',
		time = '".$this->db->escape_str($input_arr['time'])."',
		details = '".$this->db->escape_str($input_arr['details'])."'
		WHERE id_lead_event = '".$this->db->escape_str($input_arr['id_lead_event'])."'";
		return $this->db->query($query);
	}	
	
	public function update_lead_event_status ($id_lead_event, $status)
	{
		$now = date("Y-m-d H:i:s");
		$query = "UPDATE lead_events SET status = '".$this->db->escape_str($status)."' WHERE id_lead_event = '".$this->db->escape_str($id_lead_event)."'";
		return $this->db->query($query);
	}
	// LEAD END //

	// HOME START //
	public function get_sales_stats ($user_id)
	{
		$now = date("Y-m-d");
		$query = "
		SELECT 
		(SELECT COUNT(1) FROM leads WHERE fk_user = ".$user_id." AND `status` = 1) AS `unattempted_leads`,
		(SELECT COUNT(1) FROM leads WHERE fk_user = ".$user_id." AND `status` = 2) AS `pre_tenders`,
		(SELECT COUNT(1) FROM leads WHERE fk_user = ".$user_id." AND `status` = 3) AS `tenders`,
		(SELECT COUNT(1) FROM leads WHERE fk_user = ".$user_id." AND `status` IN (4, 5, 6, 7, 8, 9)) AS `orders`,
		(SELECT COUNT(1) FROM leads WHERE fk_user = ".$user_id." AND DATE(`delivery_date`) <> '0000-00-00' AND DATE(`delivery_date`) >= ('".$now."' - INTERVAL 10 DAY)) AS `incoming_deliveries`,
		(SELECT COUNT(1) FROM leads WHERE fk_user = ".$user_id." AND DATE(`assignment_date`) = '".$now."') AS `callbacks_today`,
		(SELECT COUNT(1) FROM leads WHERE fk_user = ".$user_id." AND `status` IN (4, 5, 6, 7, 8, 9) AND MONTH(`order_date`) = MONTH(CURRENT_DATE())) AS `submitted_deals_this_month`,
		(SELECT COUNT(1) FROM leads WHERE fk_user = ".$user_id." AND `status` IN (5, 6, 7) AND MONTH(`approved_date`) = MONTH(CURRENT_DATE())) AS `approved_deals_this_month`,
		(SELECT COUNT(1) FROM leads WHERE fk_user = ".$user_id." AND `status` IN (7) AND MONTH(`settled_date`) = MONTH(CURRENT_DATE())) AS `settled_deals_this_month`,
		(SELECT COUNT(1) FROM tradeins WHERE DATE(`created_at`) = '".$now."') AS `tradeins_today`
		";
		return $this->db->query($query)->row_array();		
	}	
	// HOME END //
	
	// CALENDAR START //
	public function get_calendar_items ($user_id, $query_flag = "")
	{
		$tradein_query = "
		SELECT
		CONCAT('TI', LPAD(t.`id_tradein`, 5, '0')) AS `ti_number`, 
		l.id_lead AS `lead_id`, t.id_tradein AS `tradein_id`, 
		t.first_name AS `first_name`, t.last_name AS `last_name`,
		t.tradein_make AS `tradein_make`, t.tradein_model AS `tradein_model`, 
		l.delivery_date AS `delivery_date`
		FROM tradeins t
		JOIN leads l ON t.fk_lead = l.id_lead
		WHERE l.fk_user = '".$user_id."'
		AND l.deprecated <> 1 
		AND t.deprecated <> 1
		AND l.status IN (4, 5, 6, 7, 8)";		
		
		$event_query = "
		SELECT 
		CONCAT('QM', LPAD(l.`id_lead`, 5, '0')) AS `cq_number`, 
		l.`id_lead`, l.`id_lead` AS `lead_id`, 
		l.`name`, l.`email`, l.`email` AS `lead_email`, 
		le.`details` AS `event_details`,
		le.`status` AS `event_status`,
		le.`date` AS `assignment_date`, le.`time` AS `assignment_time`, 
		l.`make`, l.`model`,
		(SELECT COUNT(1) FROM tradeins WHERE email = `lead_email` and fk_lead <> `lead_id`) AS `st`,
		(SELECT COUNT(1) FROM tradeins WHERE fk_lead = `lead_id`) AS `at`
		FROM lead_events le
		JOIN leads l ON le.fk_lead = l.id_lead
		WHERE l.fk_user = '".$user_id."' 
		AND le.deprecated <> 1
		AND l.deprecated <> 1";

		$order_query = "
		SELECT
		CONCAT('QM', LPAD(l.`id_lead`, 5, '0')) AS `cq_number`, 
		l.`id_lead`, l.`id_lead` AS `lead_id`, 
		l.`name`, l.`email`, l.`email` AS `lead_email`, 
		l.`make`, l.`model`, 
		DATE(l.`delivery_date`) AS `delivery_date`, 
		l.`status`,
		m.`id_make`, m.`name` AS `tender_make`,
		f.`id_family`, f.`name` AS `tender_model`,		
		(SELECT COUNT(1) FROM `tradeins` WHERE `email` = `lead_email` AND `fk_lead` <> `lead_id`) AS `st`,
		(SELECT COUNT(1) FROM `tradeins` WHERE `fk_lead` = `lead_id`) AS `at` 
		FROM `leads` AS `l`
		JOIN `quote_requests` AS `qr` ON l.`id_lead` = qr.`fk_lead`
		LEFT JOIN `makes` AS `m` ON qr.`make` = m.`id_make`
		LEFT JOIN `families` AS `f` ON qr.`model` = f.`id_family`
		LEFT JOIN `vehicles` AS `v` ON qr.`variant` = v.`id_vehicle`		
		WHERE l.`fk_user` = '".$user_id."'
		AND l.`deprecated` <> 1 
		AND l.`status` IN (4, 5, 6, 7, 8)";
		
		$tender_query = "
		SELECT
		CONCAT('QM', LPAD(l.`id_lead`, 5, '0')) AS `cq_number`,
		l.`id_lead` AS `lead_id`, l.`id_lead`, 
		l.`name`, l.`email`, l.`email` AS `lead_email`, 
		l.`make`, l.`model`, 
		DATE(l.`assignment_date`) AS `assignment_date`, l.`assignment_time`, 
		qr.`id_quote_request` AS `qr_id`,
		(SELECT COUNT(1) FROM quotes WHERE fk_quote_request = `qr_id` AND deprecated <> 1) AS `quote_count`,
		m.`id_make`, m.`name` AS `tender_make`,
		f.`id_family`, f.`name` AS `tender_model`,
		(SELECT COUNT(1) FROM `tradeins` WHERE `email` = `lead_email` and fk_lead <> `lead_id`) AS `st`,
		(SELECT COUNT(1) FROM `tradeins` WHERE `fk_lead` = `lead_id`) AS `at`
		FROM `leads` AS `l` 
		JOIN `quote_requests` AS `qr` ON l.`id_lead` = qr.`fk_lead`
		LEFT JOIN `makes` AS `m` ON qr.`make` = m.`id_make`
		LEFT JOIN `families` AS `f` ON qr.`model` = f.`id_family`
		LEFT JOIN `vehicles` AS `v` ON qr.`variant` = v.`id_vehicle`
		WHERE l.`fk_user` = '".$user_id."'
		AND l.`deprecated` <> 1 
		AND l.`status` = 3
		GROUP BY l.`id_lead`";

		$unattempted_query = "
		SELECT 
		CONCAT('QM', LPAD(`id_lead`, 5, '0')) AS `cq_number`, 
		`id_lead`, `id_lead` AS `lead_id`,
		`name`, `email`, `email` AS `lead_email`,
		DATE(`assignment_date`) AS `assignment_date`, `assignment_time`, 
		`make`, `model`,
		(SELECT COUNT(1) FROM `tradeins` WHERE `email` = `lead_email` AND `fk_lead` <> `lead_id`) AS `st`,
		(SELECT COUNT(1) FROM `tradeins` WHERE `fk_lead` = `lead_id`) AS `at`
		FROM `leads` 
		WHERE `fk_user` = '".$user_id."'
		AND `deprecated` <> 1 
		AND `status` = 1";

		$attempted_query = "
		SELECT
		CONCAT('QM', LPAD(`id_lead`, 5, '0')) AS `cq_number`, 
		`id_lead`, `id_lead` AS `lead_id`, 
		`name`, `email`, `email` AS `lead_email`, 
		DATE(`assignment_date`) AS `assignment_date`, `assignment_time`, 
		`make`, `model`,
		(SELECT COUNT(1) FROM `tradeins` WHERE `email` = `lead_email` AND `fk_lead` <> `lead_id`) AS `st`,
		(SELECT COUNT(1) FROM `tradeins` WHERE `fk_lead` = `lead_id`) AS `at` 
		FROM `leads` 
		WHERE `fk_user` = '".$user_id."' 
		AND `deprecated` <> 1
		AND `status` = 2";

		$query = "";

		if($query_flag == "event")
		{
			$query = $event_query;
		}
		elseif($query_flag == "order")
		{
			$query = $order_query;
		}
		elseif($query_flag == "tradein")
		{
			$query = $tradein_query;
		}
		elseif($query_flag == "tender")
		{
			$query = $tender_query;
		}
		elseif($query_flag == "unattempted")
		{
			$query = $unattempted_query;
		}
		elseif($query_flag == "attempted")
		{
			$query = $attempted_query;
		}
		else
		{
			$query = "SELECT * FROM leads WHERE fk_user = '".$user_id."'";
		}

		return $this->db->query($query)->result_array();
	}	
	
	public function get_unscheduled_leads ($user_id)
	{
		$query = "
		SELECT
		`id_lead`, `id_lead` AS `lead_id`, 
		`status`,
		CONCAT('QM', LPAD(`id_lead`, 5, '0')) AS `cq_number`, 
		`name`, `email`, `make`, `model`, `created_at`,
		(SELECT COUNT(1) FROM `call_logs` WHERE `fk_lead` = `lead_id`) AS `attempt_count`,
		DATEDIFF(NOW(), `created_at`) AS `age`
		FROM `leads` 
		WHERE `fk_user` = '".$user_id."' 
		AND `deprecated` <> 1
		AND `status` IN (1, 2)
		AND DATE(`assignment_date`) = '0000-00-00'
		ORDER BY `age` DESC";
		return $this->db->query($query)->result_array();
	}
	
	public function get_scheduled_leads ($user_id, $date)
	{
		$query = "
		SELECT
		`id_lead`, `id_lead` AS `lead_id`, 
		`status`,
		CONCAT('QM', LPAD(`id_lead`, 5, '0')) AS `cq_number`, 
		`name`, `email`, `make`, `model`, `created_at`,
		(SELECT COUNT(1) FROM `call_logs` WHERE `fk_lead` = `lead_id` AND deprecated <> 1) AS `attempt_count`,
		DATEDIFF(NOW(), `created_at`) AS `age`
		FROM `leads` 
		WHERE `fk_user` = '".$user_id."' 
		AND `deprecated` <> 1
		AND `status` IN (1, 2)
		AND DATE(`assignment_date`) = '".$date."'
		ORDER BY `assignment_date` DESC";
		return $this->db->query($query)->result_array();
	}
	
	public function get_scheduled_tenders ($user_id, $date)
	{
		$query = "
		SELECT
		l.`id_lead`, l.`id_lead` AS `lead_id`, qr.`id_quote_request` AS `quote_request_id`,
		l.`status`,
		CONCAT('QM', LPAD(l.`id_lead`, 5, '0')) AS `cq_number`, 
		l.`name`, l.`email`, m.`name` AS `make`, f.`name` AS `model`, l.`created_at`,
		(SELECT COUNT(1) FROM quotes WHERE fk_quote_request = `quote_request_id` AND `deprecated` <> 1) AS `quote_count`,
		(SELECT COUNT(1) FROM quotes WHERE fk_quote_request = `quote_request_id` AND `seen_status` = 0 AND `deprecated` <> 1) AS `new_quote_count`
		FROM `leads` l
		JOIN `quote_requests` AS `qr` ON l.`id_lead` = qr.`fk_lead`
		LEFT JOIN `makes` AS `m` ON qr.`make` = m.`id_make`
		LEFT JOIN `families` AS `f` ON qr.`model` = f.`id_family`
		LEFT JOIN `vehicles` AS `v` ON qr.`variant` = v.`id_vehicle`		
		WHERE l.`fk_user` = '".$user_id."' 
		AND l.`deprecated` <> 1
		AND l.`status` = 3
		GROUP BY l.`id_lead`
		ORDER BY l.`id_lead` DESC
		";
		return $this->db->query($query)->result_array();
	}		
	
	public function get_scheduled_orders ($user_id, $date)
	{
		$query = "
		SELECT
		l.`id_lead`, l.`id_lead` AS `lead_id`, qr.`id_quote_request` AS `quote_request_id`,
		l.`status`,
		CONCAT('QM', LPAD(l.`id_lead`, 5, '0')) AS `cq_number`,
		l.`name`, l.`email`, m.`name` AS `make`, f.`name` AS `model`, l.`created_at`,
		(SELECT COUNT(1) FROM quotes WHERE fk_quote_request = `quote_request_id` AND `deprecated` <> 1) AS `quote_count`,
		(SELECT COUNT(1) FROM quotes WHERE fk_quote_request = `quote_request_id` AND `seen_status` = 0 AND `deprecated` <> 1) AS `new_quote_count`		
		FROM `leads` l
		JOIN `quote_requests` AS `qr` ON l.`id_lead` = qr.`fk_lead`
		LEFT JOIN `makes` AS `m` ON qr.`make` = m.`id_make`
		LEFT JOIN `families` AS `f` ON qr.`model` = f.`id_family`
		LEFT JOIN `vehicles` AS `v` ON qr.`variant` = v.`id_vehicle`		
		WHERE l.`fk_user` = '".$user_id."' 
		AND l.`deprecated` <> 1
		AND l.`status` IN (4, 5, 6, 7, 8)
		AND DATE(l.`delivery_date`) = '".$date."'
		GROUP BY l.`id_lead`
		ORDER BY l.`id_lead` DESC";
		return $this->db->query($query)->result_array();
	}	
	
	public function get_scheduled_tradeins ($user_id, $date)
	{
		$query = "
		SELECT
		t.`id_tradein`, l.`id_lead`,
		CONCAT('TI', LPAD(t.`id_tradein`, 5, '0')) AS `ti_number`, 		
		CONCAT(t.`first_name`, ' ', t.`last_name`) AS `name`,
		t.`tradein_make` AS `make`, t.`tradein_model` AS `model`, 
		t.`created_at`
		FROM `tradeins` t
		JOIN leads l ON t.`fk_lead` = l.`id_lead`
		WHERE l.`fk_user` = '".$user_id."' 
		AND t.`deprecated` <> 1
		AND l.`status` IN (4, 5, 6, 7, 8)
		AND DATE(l.`delivery_date`) = '".$date."'
		ORDER BY l.`delivery_date` DESC";
		return $this->db->query($query)->result_array();
	}	
	// CALENDAR END //
	
	
	
	
	
	
	
	
	
	public function get_emails ($params) // To be removed
	{
		$client_email = $params['email'];
		$cq_number = $params['qm_number'];

		$query = "
		SELECT 
		e.id_email, e.fk_lead, e.gmail_id, e.thread_id, 
		e.sender, e.recipient, e.received_date, e.subject,
		SUBSTRING_INDEX(e.content, '\nOn', 1) AS `content`, GROUP_CONCAT(ea.filename) as `files`
		FROM `emails` AS `e`
		LEFT JOIN `email_attachments` AS `ea` ON e.id_email = ea.fk_email
		WHERE 
		e.`sender` like '%".$this->db->escape_str($client_email)."%' 
		OR e.`recipient` LIKE '%".$this->db->escape_str($client_email)."%' 
		OR e.`subject` LIKE '%".$this->db->escape_str($cq_number)."%'
		GROUP BY e.id_email
		ORDER BY e.received_date ASC";
		return $this->db->query($query)->result_array();
	}	

	public function get_lead_main ($user_id = 0)
	{
		$now = date("Y-m-d H:i:s");

		$order_string = "";
		$case_id = rand (1, 6);
		if ($case_id == 1) // Least # of Attempts + Oldest Leads
		{
			$order_string = " ORDER BY l.attempts ASC, l.created_at ASC";
		}
		else if ($case_id == 2) // Least # of Attempts + Newest Leads
		{
			$order_string = " ORDER BY l.attempts ASC, l.created_at DESC";
		}
		else if ($case_id >= 3) // Oldest Leads
		{
			$order_string = " ORDER BY l.created_at ASC";
		}

		$where = "";
		if ($user_id == 0)
		{
			$where .= "
			AND (l.phone <> '' OR l.mobile <> '')
			AND l.attempts < 6
			AND l.fk_user = 0
			AND l.status <> 100
			AND l.deprecated <> 1
			AND l.id_lead NOT IN (SELECT id FROM actions WHERE created_at >= ('".$now."' - INTERVAL 210 MINUTE) AND details <> 'Assigned')
			AND l.id_lead NOT IN (SELECT id FROM actions WHERE details = 'Client Email: 3')
			AND l.id_lead NOT IN (SELECT fk_lead FROM fq_accounts_new WHERE fk_user <> 0)			
			AND l.created_at >= ('".$now."' - INTERVAL 20 DAY)
			";
		}

		$query = "
		SELECT 
		l.id_lead, l.status,
		CASE (l.status)
			WHEN 0 THEN 'Unallocated'
			WHEN 1 THEN 'Allocated'
			WHEN 2 THEN 'Attempted'
			WHEN 3 THEN 'Tendering'
			WHEN 4 THEN 'Pending Auth'
			WHEN 5 THEN 'Approved by Admin'
			WHEN 6 THEN 'Delivered'
			WHEN 7 THEN 'Settled'
			WHEN 8 THEN 'Admin on Hold'
			WHEN 9 THEN 'Deal Cancelled'
			WHEN 100 THEN 'Not Proceeding'
		END `status_text`,
		CONCAT('QM', LPAD(l.id_lead, 5, '0')) AS `cq_number`,
		l.attempt_flag, l.attempts, l.source, l.email, l.name, 
		IF (l.phone = '', 'N/A', l.phone) AS `phone`, 
		IF (l.mobile = '', 'N/A', l.mobile) AS `mobile`, 
		l.state, l.postcode, l.make, l.model, l.created_at, l.make AS `make_name`,
		(SELECT img 
			FROM landing_pages 
			WHERE REPLACE(REPLACE(make, '-', ''), ' ', '') = REPLACE(REPLACE(`make_name`, '-', ''), ' ', '') LIMIT 1
		) AS `image_url`
		FROM leads l
		WHERE 1
		AND l.fk_buyer = 0
		AND l.fk_temp_user = '".$this->db->escape_str($user_id)."'		
		".$where."
		".$order_string." LIMIT 1";
		return $this->db->query($query)->row_array();
	}

	public function get_temp_assigned_lead ($user_id)
	{
		$query = "SELECT COUNT(1) AS `cnt` FROM leads WHERE fk_temp_user = '".$this->db->escape_str($user_id)."' AND fk_buyer = 0";
		return $this->db->query($query)->row_array();
	}	

	public function get_lead_call_backs ($user_id, $start_date, $end_date)
	{
		$now = date("Y-m-d");
		$query = "
		SELECT l.id_lead, l.email, l.name, l.phone, l.mobile, l.state, l.postcode, l.make, l.model, l.details,
		IF (DATE(l.assignment_date) = '0000-00-00', '".$now."', DATE(l.assignment_date)) AS `assignment_date`, l.assignment_time
		FROM leads l
		WHERE 1
		AND l.fk_user = '".$user_id."'
		AND l.fk_buyer = 0
		AND l.status IN (1, 2)
		AND (DATE(l.assignment_date) >= '".$this->db->escape_str($start_date)."' AND DATE(l.assignment_date) <= '".$this->db->escape_str($end_date)."')
		ORDER BY l.assignment_date ASC, l.assignment_time ASC";
		$sql = $this->db->query($query);
		return $sql->result_array();
	}

	public function get_single_lead_call_back($lead_id)
	{	
		$now = date("Y-m-d");
		$query = "
		SELECT 
			fk_user, details,
			IF (DATE(assignment_date) = '0000-00-00', 
				'".$now."', DATE(assignment_date)
			) AS `assignment_date`, 
			assignment_time FROM leads 
		WHERE id_lead = {$lead_id}";
		return $this->db->query($query)->row_array();
	}

	public function insert_order_recipient ($lead_id, $user_id, $email, $file)
	{
		$now = date("Y-m-d H:i:s");
		$query = "
		INSERT INTO order_recipients (fk_lead, fk_user, email, file, created_at) 
		VALUES 
		(
			'".$this->db->escape_str($lead_id)."', 
			'".$this->db->escape_str($user_id)."', 
			'".$this->db->escape_str($email)."', 
			'".$this->db->escape_str($file)."', 
			'".$now."'
		)";
		$sql = $this->db->query($query);
	}

	public function insert_confirmation_recipient ($lead_id, $user_id, $email, $file)
	{
		$now = date("Y-m-d H:i:s");
		$query = "
		INSERT INTO order_confirmation_recipients (fk_lead, fk_user, email, file, created_at) 
		VALUES 
		(
			'".$this->db->escape_str($lead_id)."', 
			'".$this->db->escape_str($user_id)."', 
			'".$this->db->escape_str($email)."', 
			'".$this->db->escape_str($file)."', 
			'".$now."'
		)";
		$sql = $this->db->query($query);
	}

	public function get_lead_key ($id_lead)
	{
		$query = "SELECT client_key FROM leads WHERE id_lead = {$id_lead}";
		return $this->db->query($query)->row_array();
	}

	public function update_single_call_back ($params)
	{
		$assignment_date = date("Y-m-d H:i:s", strtotime($params['edit_assignment_date']));
		$assignment_time = date("H:i:s", strtotime($params['edit_assignment_time']));
		$fk_user = $params['edit_quote_specialist'];
		$details = $params['edit_lead_details'];

		if( $params['callback_type'] == 2 )
		{
			$data = [
				'assignment_date' => $assignment_date,
				'assignment_time' => $assignment_time,
				'fk_user'         => $fk_user,
				'details'         => $details,
				'status'          => 10
			];
		}
		else
		{
			$data = [
				'assignment_date' => $assignment_date,
				'assignment_time' => $assignment_time,
				'fk_user'         => $fk_user,
				'details'         => $details
			];
		}

		$this->db->where('id_lead', $params['edit_lead_id']);
		$this->db->update('leads', $data);

		if( $params['callback_type'] == 2 )
			return "pre-tender";
		else
			return "callback";
	}

	public function get_lead_tenders ($user_id)
	{
		$now = date("Y-m-d");
		$query = "
		SELECT 
		l.id_lead, l.email, l.name, l.phone, l.mobile, l.state, l.postcode, l.make, l.model, 
		qr.id_quote_request, qr.id_quote_request AS `qr_id`,
		(SELECT COUNT(1) FROM quotes WHERE fk_quote_request = `qr_id`) AS `quote_count`,
		IF (DATE(l.assignment_date) = '0000-00-00', '".$now."', DATE(l.assignment_date)) AS `assignment_date`
		FROM leads l
		LEFT JOIN quote_requests qr ON l.id_lead = qr.fk_lead
		LEFT JOIN makes m ON qr.make = m.id_make
		LEFT JOIN families f ON qr.model = f.id_family
		LEFT JOIN vehicles v ON qr.variant = v.id_vehicle
		LEFT JOIN quotes q ON qr.winner = q.id_quote
		WHERE 1
		AND l.fk_user = '".$user_id."'
		AND l.fk_buyer = 0
		AND l.status IN (3)
		ORDER BY l.allocated_date ASC";
		$sql = $this->db->query($query);
		return $sql->result_array();
	}

	public function get_lead_sources ()
	{
		$query = "
		SELECT DISTINCT source 
		FROM leads 
		WHERE deprecated <> 1 AND source <> 'LP - ' AND source <> '' 
		ORDER BY source ASC";
		$sql = $this->db->query($query);
		return $sql->result_array();
	}	
	
	public function get_lead_deals ($user_id)
	{
		$query = "
		SELECT 
		l.id_lead, l.email, l.name, l.phone, l.mobile, 
		l.state, l.postcode, l.make, l.model, l.assignment_date
		FROM leads l
		WHERE 1
		LEFT JOIN users qs ON l.fk_user = qs.id_user
		LEFT JOIN quote_requests qr ON l.id_lead = qr.fk_lead
		LEFT JOIN makes m ON qr.make = m.id_make
		LEFT JOIN families f ON qr.model = f.id_family
		LEFT JOIN vehicles v ON qr.variant = v.id_vehicle
		LEFT JOIN quotes q ON qr.winner = q.id_quote
		LEFT JOIN users d ON q.fk_user = d.id_user
		LEFT JOIN dealer_attributes da ON d.id_user = da.fk_user		
		AND l.fk_user = '".$user_id."'
		AND l.fk_buyer = 0
		AND l.status IN (4, 5, 6 , 7, 8, 9)
		ORDER BY l.allocated_date ASC";
		$sql = $this->db->query($query);
		return $sql->result_array();
	}

	public function get_lead_status ($lead_id)
	{
		$query = "SELECT status FROM leads WHERE id_lead = '".$this->db->escape_str($lead_id)."'";
		return $this->db->query($query)->row_array();
	}

	public function get_sold_leads ()
	{
		$query = "
		SELECT
		l.id_lead, l.name, l.email, l.phone, l.make, l.model, l.state, l.postcode, 
		IF (l.sale_type=0, 'Manual Purchase', 'PMA Purchase') AS `purchase_type`, DATE(l.purchase_date) AS `purchase_date`,
		u.name AS `dealer_name`, u.email AS `dealer_email`
		FROM leads l
		JOIN users u ON l.fk_buyer = u.id_user
		WHERE l.fk_buyer <> 0 ORDER BY l.purchase_date DESC";
		$sql = $this->db->query($query);
		return $sql->result_array();		
	}

	public function get_lead_sale_transactions ($lead_sale_invoice_id)
	{
		$query = "
		SELECT 
		id_transaction, CONCAT('LST', LPAD(id_transaction, 5, '0')) AS `transaction_number`,
		original_amount, discount, merchant_fee, amount, created_at 
		FROM transactions 
		WHERE fk_lead_sale_invoice = ".$lead_sale_invoice_id;
		$sql = $this->db->query($query);
		return $sql->result_array();
	}
	
	public function get_lead_sale_invoice ($id_lead_sale_invoice)
	{
		$query = "
		SELECT 
		lsi.id_lead_sale_invoice,
		lsi.id_lead_sale_invoice AS `lead_sale_invoice_id`,
		CONCAT('LSI', LPAD(lsi.id_lead_sale_invoice, 5, '0')) AS `lead_sale_invoice_number`,
		lsi.type, lsi.status,
		lsi.invoice_date, lsi.payment_due_date,
		u.name AS `buyer_name`, u.username AS `buyer_email`, u.address AS `buyer_address`,
		u.state AS `buyer_state`, u.postcode AS `buyer_postcode`,
		(SELECT SUM(amount) FROM transactions WHERE fk_lead_sale_invoice = `lead_sale_invoice_id`) AS `amount`
		FROM lead_sale_invoices lsi
		JOIN users u ON lsi.fk_user = u.id_user
		WHERE lsi.id_lead_sale_invoice = '".$id_lead_sale_invoice."' LIMIT 1";
		return $this->db->query($query)->row_array();
	}
	
	public function get_lead_sale_invoices ()
	{
		$query = "
		SELECT 
		lsi.id_lead_sale_invoice,
		lsi.id_lead_sale_invoice AS `lead_sale_invoice_id`,
		CONCAT('LSI', LPAD(lsi.id_lead_sale_invoice, 5, '0')) AS `lead_sale_invoice_number`,
		lsi.type, lsi.status,
		lsi.invoice_date, lsi.payment_due_date,
		u.name AS `buyer_name`, u.username AS `buyer_email`, u.address AS `buyer_address`,
		u.state AS `buyer_state`, u.postcode AS `buyer_postcode`,
		(SELECT SUM(amount) FROM transactions WHERE fk_lead_sale_invoice = `lead_sale_invoice_id`) AS `amount`
		FROM lead_sale_invoices lsi
		JOIN users u ON lsi.fk_user = u.id_user
		GROUP BY lsi.id_lead_sale_invoice";
		$sql = $this->db->query($query);
		return $sql->result_array();
	}	

	public function get_lead_sales_invoices ()
	{
		$query = "
		SELECT 
		lsi.id_lead_sale_invoice, lsi.type,
		CONCAT('LSI', LPAD(lsi.id_lead_sale_invoice, 5, '0')) AS `lead_sales_invoice_number`,
		lsi.quantity, lsi.amount, lsi.invoice_date, lsi.payment_due_date,
		u.name AS `buyer_name`, u.email AS `buyer_email`, u.address AS `buyer_address`, u.state AS `buyer_state`, u.postcode AS `buyer_postcode`
		FROM lead_sales_invoices lsi
		JOIN users u ON lsi.fk_user = u.id_user
		WHERE 1 ORDER BY lsi.id_lead_sale_invoice DESC";
		$sql = $this->db->query($query);
		return $sql->result_array();
	}

	public function get_lead_sales_invoice ($id_lead_sales_invoice)
	{
		$query = "
		SELECT 
		lsi.id_lead_sale_invoice, lsi.type,
		CONCAT('LSI', LPAD(lsi.id_lead_sale_invoice, 5, '0')) AS `lead_sales_invoice_number`,
		lsi.quantity, lsi.amount, lsi.invoice_date, lsi.payment_due_date,
		u.name AS `buyer_name`, u.email AS `buyer_email`, u.address AS `buyer_address`, u.state AS `buyer_state`, u.postcode AS `buyer_postcode`
		FROM lead_sales_invoices lsi
		JOIN users u ON lsi.fk_user = u.id_user
		WHERE lsi.id_lead_sale_invoice = '".$id_lead_sales_invoice."' LIMIT 1";
		return $this->db->query($query)->row_array();
	}

	public function get_protected_postcodes ()
	{
		$current_month = date('m');
		$current_year = date('Y');
		$query = "
		SELECT 
		u.id_user AS `user_id`, u.name, u.email, da.dealership_name, da.dealership_brand, u.lead_cap AS `monthly_lead_cap`, u.postcode AS `main_postcode`,
		(SELECT GROUP_CONCAT(postcode) FROM pma_protection WHERE fk_user = `user_id` AND postcode <> `main_postcode`) AS `postcodes`,
		(
			SELECT CONCAT(`main_postcode`, IF (`postcodes` IS NULL, '', CONCAT(',', `postcodes`)))
		) AS `all_postcodes`,
		(
			SELECT COUNT(1) FROM leads WHERE fk_buyer = `user_id` AND sale_type = 1 
			AND MONTH(purchase_date) = '".$current_month."' AND YEAR(purchase_date) = '".$current_year."'
		) AS `purchased_leads`,
		(SELECT `monthly_lead_cap` - `purchased_leads`) AS `remaining_leads`
		FROM users u 
		LEFT JOIN dealer_attributes da ON u.id_user = da.fk_user
		WHERE pma_status = 1";
		$sql = $this->db->query($query);
		return $sql->result_array();		
	}	

	public function get_lead_main_numbers ($user_id, $action_string)
	{
		$now = date("Y-m-d");
		$query = "
		SELECT COUNT(DISTINCT id) AS `cnt`
		FROM actions 
		WHERE 1
		AND fk_user = '".$this->db->escape_str($user_id)."'
		AND DATE(created_at) = '".$now."'
		AND details = '".$this->db->escape_str($action_string)."' LIMIT 1";
		return $this->db->query($query)->row_array();
	}

	public function get_lead_qs ($lead_id)
	{
		$query = "
		SELECT fk_user AS `qs_id`, fk_temp_user AS `qs_temp_id` 
		FROM leads WHERE id_lead = '".$this->db->escape_str($lead_id)."' 
		LIMIT 1";
		return $this->db->query($query)->row_array();		
	}

	public function update_lead_attempt_flag ($lead_id, $flag)
	{
		$query = "
		UPDATE `leads` SET attempt_flag = '".$flag."' 
		WHERE `id_lead` = '".$this->db->escape_str($lead_id)."'";
		$sql = $this->db->query($query);		
	}

	public function update_lead_temp_user ($lead_id, $user_id)
	{
		$query = "UPDATE `leads` SET fk_temp_user = '".$this->db->escape_str($user_id)."' WHERE `id_lead` = '".$this->db->escape_str($lead_id)."'";
		$sql = $this->db->query($query);		
	}

	public function update_lead_temp_status ($lead_id)
	{
		$query = "UPDATE `leads` SET fk_temp_user = '0', attempts = attempts + 1, attempt_flag = 0, fk_temp_user = 0 WHERE `id_lead` = '".$this->db->escape_str($lead_id)."'";
		$sql = $this->db->query($query);
	}

	public function update_lead_call_back_details ($lead_id, $lead_details)
	{
		$query = "UPDATE `leads` SET details = '".$this->db->escape_str($lead_details)."' WHERE `id_lead` = ".$lead_id;
		$sql = $this->db->query($query);		
	}

	public function get_deal_requirements ($lead_id)
	{
		$query = "
		SELECT 
		fa.id_fq_account AS `lead_id`, fa.lead_email AS `lead_email`, fa.lead_name AS `lead_name`,
		fa.lead_name, fa.lead_email,  fa.lead_postcode, fa.lead_state, fa.delivery_date, fa.delivery_address, fa.delivery_address_map, 
		fa.answer_act, fa.answer_vic, fa.answer_qld,
		q.id_quote AS `winning_quote`,
		fa.`transport`, fa.`deposit`,
		(SELECT COUNT(1) FROM tradeins WHERE email = `lead_email` OR CONCAT(first_name, ' ', last_name) = `lead_name`) AS `suggested_tradein_count`,
		(SELECT COUNT(1) FROM tradeins WHERE fk_lead = `lead_id`) AS `attached_tradein_count`,
		(SELECT
			tv.fk_user
			FROM `tradeins` AS `t`
			JOIN `trade_valuations` AS `tv`
			ON t.`fk_trade_valuation` = tv.`id_trade_valuation`
			WHERE t.`fk_lead` = `lead_id`
			LIMIT 1
		) AS `tradein_buyer`,
		fa.order_date
		FROM fq_accounts_new fa
		LEFT JOIN users qs ON fa.fk_user = qs.id_user
		LEFT JOIN quote_requests qr ON fa.id_fq_account = qr.fk_lead
		LEFT JOIN quotes q ON qr.winner = q.id_quote
		WHERE fa.id_fq_account = '".$this->db->escape_str($lead_id)."'
		GROUP BY fa.id_fq_account LIMIT 1";
		return $this->db->query($query)->row_array();		
	}

	public function update_lead_client_key ($lead_id, $key)
	{
		$data = ['client_key' => $key];
		$this->db->where('id_lead', $lead_id);
		$this->db->update('leads', $data);
	}
	
	public function update_lead_client_status ($lead_id, $status)
	{
		$data = ['client_status' => $status];
		$this->db->where('id_lead', $lead_id);
		$this->db->update('leads', $data);		
	}

	public function update_lead_order_pdf ($lead_id, $order_pdf) // TO BE DELETED //
	{
		$data = ['order_pdf' => $order_pdf];
		$this->db->where('id_lead', $lead_id);
		$this->db->update('leads', $data);		
	}
	
	public function update_lead_client_agreed_date ($lead_id)
	{
		$data = ['client_agreed_date' => date("Y-m-d H:i:s")];
		$this->db->where('id_lead', $lead_id);
		$this->db->update('leads', $data);			
	}	
	
	public function get_lead_client_key ($lead_id, $key)
	{
		$query = "
		SELECT * FROM leads 
		WHERE id_lead = '".$this->db->escape_str($lead_id)."' 
		AND client_key = '".$this->db->escape_str($key)."'
		AND deprecated <> 1";
		return $this->db->query($query)->row_array();		
	}

	public function get_additional_lead_accessory_details($lead_id)
	{
		$query = "select id_lead, accessory_job_date, accessory_special_conditions, accessory_status, aftersales_status from leads where id_lead = {$lead_id}";
		
		return $this->db->query($query)->row_array();	
	}

	public function get_lead_deposits ($lead_id)
	{
		$query = "SELECT * FROM payments WHERE fk_payment_type = 2 AND fk_lead = ".$lead_id." AND deprecated <> 1";
		return $this->db->query($query)->result_array();
	}
	
	public function get_lead_refunds ($lead_id)
	{
		$query = "SELECT * FROM payments WHERE fk_payment_type = 7 AND fk_lead = ".$lead_id." AND deprecated <> 1";
		return $this->db->query($query)->result_array();
	}
	
	public function get_lead_deposit_trans ($lead_id)
	{
		$query = "SELECT * FROM payments WHERE fk_payment_type = 8 AND fk_lead = ".$lead_id." AND deprecated <> 1";
		return $this->db->query($query)->result_array();
	}	

	public function get_lead_details ($lead_id)
	{
		$query = "
		SELECT l.`id_lead`, CONCAT('QM', LPAD(l.`id_lead`, 5, '0')) AS `cq_number`, 
		l.`name` AS `client_name`, l.`email` AS `client_email`, m.`name` AS `make`, f.`name` AS `model`,
		u.`name` AS `qs_name`, u.`username` AS `qs_email`
		FROM `leads` l 
		JOIN `users` u ON l.`fk_user` = u.`id_user`
		JOIN `quote_requests` qr ON l.`id_lead` = qr.`fk_lead`
		JOIN `makes` m ON qr.`make` = m.`id_make`
		JOIN `families` f ON qr.`model` = f.`id_family`
		WHERE l.`id_lead` = '".$this->db->escape_str($lead_id)."'";
		return $this->db->query($query)->row_array();	
	}

	public function get_leads ($params, $my_id, $admin_type, $start, $limit) // ADMIN
	{
		$cq_number = isset($params['cq_number']) ? $params['cq_number'] : '';
		$current_status = isset($params['current_status']) ? $params['current_status'] : '';
		$user_id = isset($params['user_id']) ? $params['user_id'] : ''; 
		
		$name = isset($params['name']) ? $params['name'] : '';
		$email = isset($params['email']) ? $params['email'] : '';
		$phone = isset($params['phone']) ? $params['phone'] : '';

		$state = isset($params['state']) ? $params['state'] : '';
		$postcode = isset($params['postcode']) ? $params['postcode'] : '';
		$address = isset($params['address']) ? $params['address'] : '';
		
		$make = isset($params['make']) ? $params['make'] : '';
		$model = isset($params['model']) ? $params['model'] : '';
		$source = isset($params['source']) ? $params['source'] : '';		
		
		/*
		$status = isset($params['status']) ? $params['status'] : '';
		$date_from = isset($params['date_from']) ? $params['date_from'] : '';
		$date_to = isset($params['date_to']) ? $params['date_to'] : '';
		*/

		$where = "";
		if ($cq_number <> "") 
		{
			$where .= " 
			AND (
				CONCAT('QM', LPAD(l.`id_lead`, 5, '0')) = '".$this->db->escape_str($cq_number)."' 
				OR l.`id_lead` = '".$this->db->escape_str($cq_number)."'
			) "; 
		}
		
		if ($current_status <> "")
		{
			if ($current_status==4)
			{
				$where .= " AND l.`status` IN (4, 5, 6, 7, 8, 9) "; 
			}
			else
			{
				$where .= " AND l.`status` = '".$this->db->escape_str($current_status)."' "; 
			}
		}
		
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

		if ($make <> "") { $where .= " AND l.`make` LIKE '%".$this->db->escape_str($make)."%' "; }
		if ($model <> "") { $where .= " AND l.`model` LIKE '%".$this->db->escape_str($model)."%' "; }
		if ($source <> "") { $where .= " AND l.`source` = '".$this->db->escape_str($source)."' "; }

		/*
		if ($status == 1) { $status_date_label = "allocated_date"; }
		else if ($status == 2) { $status_date_label = "attempted_date"; }
		else if ($status == 3) { $status_date_label = "tender_date"; }
		else if ($status == 4) { $status_date_label = "order_date"; }
		else if ($status == 5) { $status_date_label = "approved_date"; }
		else if ($status == 6) { $status_date_label = "delivery_date"; }
		else if ($status == 7) { $status_date_label = "settled_date"; }
		else if ($status == 98) { $status_date_label = "decline_date"; }
		else if ($status == 100) { $status_date_label = "delete_date"; }
		else { $status_date_label = "created_at"; }
		if ($date_from <> "") { $where .= " AND DATE(l.`".$status_date_label."`) >= DATE('".$this->db->escape_str($date_from)."') "; }
		if ($date_to <> "") { $where .= " AND DATE(l.`".$status_date_label."`) <= DATE('".$this->db->escape_str($date_to)."') "; }
		*/

		$filter_column = "";

		if (isset($params['filter_column']))
		{
			if ($params['filter_column'] != "")
			{
				$filter_column = $params['filter_column'];
			}
			else
			{
				$filter_column = "created_at";
			}
		}

		$date_filter_by = isset($params['date_filter_by']) ? $params['date_filter_by'] : "";
		
		if ($date_filter_by != "")
		{
			if ($date_filter_by == 1)
			{
				$where .= " AND (DATE(`l`.`{$filter_column}`) BETWEEN  '".date( "Y-m-d",strtotime('monday this week') )."' AND '".date( "Y-m-d",strtotime("sunday this week") )."' )";
			}
			else if ($date_filter_by == 2)
			{
				$where .= " AND (DATE(`l`.`{$filter_column}`) BETWEEN  '".date( "Y-m-d",strtotime('monday last week') )."' AND '".date( "Y-m-d",strtotime("sunday last week") )."' )";
			}
			else if ($date_filter_by == 3)
			{
				$where .= " AND (DATE(`l`.`{$filter_column}`) BETWEEN  '".date( "Y-m-d",strtotime('first day of this month') )."' AND '".date( "Y-m-d",strtotime("last day of this month") )."' )";
			}
			else if ($date_filter_by == 4)
			{
				$where .= " AND (DATE(`l`.`{$filter_column}`) BETWEEN  '".date( "Y-m-d",strtotime('first day of last month') )."' AND '".date( "Y-m-d",strtotime("last day of last month") )."' )";
			}
			else if ($date_filter_by == 5)
			{
				$where .= " AND DATE(`l`.`{$filter_column}`) = '".date( "Y-m-d" )."'"; 
			}
			else if ($date_filter_by == 6)
			{
				$where .= " AND DATE(`l`.`{$filter_column}`) = '".date( "Y-m-d",strtotime('yesterday') )."'"; 
			}
			else if ($date_filter_by == 7)
			{
				if (isset($params['filter_date_from']))
				{
					$filter_date_from = date('Y-m-d', strtotime($params['filter_date_from']));
				}
				else
				{
					$filter_date_from = date('Y-m-d');
				}

				if (isset($params['filter_date_to']))
				{
					$filter_date_to = date('Y-m-d', strtotime($params['filter_date_to']));
				}
				else
				{
					$filter_date_to = date('Y-m-d');
				}

				$where .= " AND (DATE(`l`.`{$filter_column}`) BETWEEN '{$filter_date_from}' AND '{$filter_date_to}' ) ";
			}
			else
			{
				$where .= " ";
			}
		}

		if (isset($params['order_by_filter']))
		{
			if ($params['order_by_filter']<>"")
			{
				$order_by = " `l`.`".$params['order_by_filter']."` ";
			}
			else
			{
				$order_by = " `l`.`id_lead` ";
			}
		}
		else
		{
			$order_by = " `l`.`id_lead` ";
		}

		if (isset($params['order_filter']))
		{
			if ($params['order_by_filter']<>"")
			{		
				$order = " ".$params['order_filter']." ";
			}
			else
			{
				$order = " DESC ";
			}
		}
		else
		{
			$order = " DESC ";
		}
		
		if ($limit == "0")
		{
			$limit_query = "";
		}
		else
		{
			$limit_query = " LIMIT ".$start.", ".$limit;
		}

		$query = "
		SELECT 
		l.`id_lead` AS `lead_id`,
		l.`id_lead`, l.`fk_user`, l.`source`,
		CONCAT('QM', LPAD(l.`id_lead`, 5, '0')) AS `cq_number`,
		l.`status`,
		CASE (l.`status`)
			WHEN 0 THEN 'Unallocated'
			WHEN 1 THEN 'Allocated'
			WHEN 2 THEN 'Attempted'
			WHEN 3 THEN 'Tendering'
			WHEN 4 THEN 'Pending Auth'
			WHEN 5 THEN 'Approved by Admin'
			WHEN 6 THEN 'Delivered'
			WHEN 7 THEN 'Settled'
			WHEN 8 THEN 'Admin on Hold'
			WHEN 9 THEN 'Deal Cancelled'
			WHEN 10 THEN 'Pre-Tender'
			WHEN 100 THEN 'Deleted'
		END `status_text`,
		
		l.`client_status`,
		CASE (l.`client_status`)
			WHEN 0 THEN 'Pending Client Approval'
			WHEN 1 THEN 'Agreement Seen'
			WHEN 2 THEN 'Approved by Client'
			WHEN 3 THEN 'Awaiting Approval'
		END `client_status_text`,
		
		l.`sale_status`,
		l.`attempts`,		

		IF (l.`fk_buyer` = 0, '', 'Sold') AS `sale_status_text`,
		IF (l.`lead_price` = 0, '44.00', l.`lead_price`) AS `lead_price`,

		l.`admin_status`,

		l.`email`, l.`name`, l.`phone`, l.`mobile`, l.`state`, l.`postcode`, 
		l.`make`, l.`model`, l.`details`, l.`admin_details`, l.`admin_to_qs_details`,

		l.`created_at`, l.`last_updated`, l.`shown_created_at`,

		l.`finance`,
		ul.`name` AS `cq_staff`,
		uf.`name` AS `fq_staff`,

		l.`email` as `ti_email`, l.`phone` as `ti_phone`, l.`mobile` as `ti_mobile`,
		IF (l.`email` <> '', (SELECT COUNT(1) FROM tradeins WHERE email = `ti_email` AND fk_lead IN (0, `lead_id`)), 0) AS `tradein_email_check`,
		IF (l.`phone` <> '', (SELECT COUNT(1) FROM tradeins WHERE phone = `ti_phone` AND fk_lead IN (0, `lead_id`)), 0) AS `tradein_phone_check`,
		IF (l.`mobile` <> '', (SELECT COUNT(1) FROM tradeins WHERE phone = `ti_mobile` AND fk_lead IN (0, `lead_id`)), 0) AS `tradein_mobile_check`,
		(SELECT GREATEST(`tradein_email_check`, `tradein_phone_check`, `tradein_mobile_check`) AS `at`) AS `available_trades`,

		qr.`id_quote_request` as `qr_id`,
		(SELECT COUNT(1) FROM `quotes` WHERE `fk_quote_request` = `qr_id` AND deprecated <> 1) AS `quote_count`
		FROM `leads` `l`
		LEFT JOIN `users` ul ON l.`fk_user` = ul.`id_user`
		LEFT JOIN `fq_accounts_new` fa ON l.`id_lead` = fa.`fk_lead`
		LEFT JOIN `users` uf ON fa.`fk_user` = uf.`id_user`
		LEFT JOIN `quote_requests` qr ON l.`id_lead` = qr.`fk_lead`		
		WHERE l.`deprecated` <> 1
		AND (l.`phone` <> '' OR l.`mobile` <> '') ".$where."
		AND l.fk_buyer = 0
		GROUP BY l.id_lead
		ORDER BY ".$order_by." ".$order." ".$limit_query;
		return $this->db->query($query)->result_array();
	}
	
	public function get_leads_summary_main ($params, $my_id, $admin_type) // ADMIN
	{
		$cq_number = isset($params['cq_number']) ? $params['cq_number'] : '';
		$current_status = isset($params['current_status']) ? $params['current_status'] : '';
		$user_id = isset($params['user_id']) ? $params['user_id'] : ''; 
		
		$name = isset($params['name']) ? $params['name'] : '';
		$email = isset($params['email']) ? $params['email'] : '';
		$phone = isset($params['phone']) ? $params['phone'] : '';

		$state = isset($params['state']) ? $params['state'] : '';
		$postcode = isset($params['postcode']) ? $params['postcode'] : '';
		$address = isset($params['address']) ? $params['address'] : '';
		
		$make = isset($params['make']) ? $params['make'] : '';
		$model = isset($params['model']) ? $params['model'] : '';
		$source = isset($params['source']) ? $params['source'] : ''; 

		$where = "";
		if ($cq_number <> "") { $where .= " AND CONCAT('QM', LPAD(l.`id_lead`, 5, '0')) = '".$this->db->escape_str($cq_number)."' "; }
		if ($current_status <> "")
		{
			if ($current_status==4)
			{
				$where .= " AND l.`status` IN (4, 5, 6, 7, 8, 9) "; 
			}
			else
			{
				$where .= " AND l.`status` = '".$this->db->escape_str($current_status)."' "; 
			}			
		}
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

		if ($make <> "") { $where .= " AND l.`make` LIKE '%".$this->db->escape_str($make)."%' "; }
		if ($model <> "") { $where .= " AND l.`model` LIKE '%".$this->db->escape_str($model)."%' "; }
		if ($source <> "") { $where .= " AND l.`source` = '".$this->db->escape_str($source)."' "; }
	
		$query = "
		SELECT 
			SUM(IF(DATE(`created_at`) = '".$params['current_date']."', 1, 0)) 
				AS `received_today`,
			SUM(IF(DATE(`created_at`) = DATE_SUB('".$params['current_date']."', INTERVAL 1 DAY), 1, 0)) 
				AS `received_yesterday`,
			SUM(IF(DATE(`created_at`) <= '".$params['week_end']."' AND DATE(`created_at`) >= '".$params['week_start']."', 1, 0)) 
				AS `received_this_week`,		
			SUM(IF(MONTH(`created_at`) = '".$params['current_month']."' AND YEAR(`created_at`) = '".$params['current_year']."', 1, 0)) 
				AS `received_this_month`,
			SUM(IF(MONTH(`created_at`) = '".$params['last_month']."' AND YEAR(`created_at`) = '".$params['last_month_year']."', 1, 0)) 
				AS `received_last_month`
		FROM
		(
			SELECT `status`, `created_at`
			FROM `leads` l 
			WHERE l.`deprecated` <> 1 
			AND l.source NOT LIKE '(Old)%'
			AND l.fk_buyer = 0 
			AND (l.`phone` <> '' OR l.`mobile` <> '') ".$where."
		) `filtered_leads`";
		return $this->db->query($query)->row_array();
	}	
	
	public function get_leads_count ($params, $my_id, $admin_type) // ADMIN
	{
		$cq_number = isset($params['cq_number']) ? $params['cq_number'] : '';
		$current_status = isset($params['current_status']) ? $params['current_status'] : '';
		$user_id = isset($params['user_id']) ? $params['user_id'] : ''; 
		
		$name = isset($params['name']) ? $params['name'] : '';
		$email = isset($params['email']) ? $params['email'] : '';
		$phone = isset($params['phone']) ? $params['phone'] : '';

		$state = isset($params['state']) ? $params['state'] : '';
		$postcode = isset($params['postcode']) ? $params['postcode'] : '';
		$address = isset($params['address']) ? $params['address'] : '';
		
		$make = isset($params['make']) ? $params['make'] : '';
		$model = isset($params['model']) ? $params['model'] : '';
		$source = isset($params['source']) ? $params['source'] : '';

		$date_filter_by = isset($params['date_filter_by']) ? $params['date_filter_by'] : "";
		
		/*
		$status = isset($params['status']) ? $params['status'] : '';
		$date_from = isset($params['date_from']) ? $params['date_from'] : '';
		$date_to = isset($params['date_to']) ? $params['date_to'] : '';
		*/

		$where = "";
		if ($cq_number <> "") { $where .= " AND CONCAT('QM', LPAD(l.`id_lead`, 5, '0')) = '".$this->db->escape_str($cq_number)."' "; }
		if ($current_status <> "")
		{
			if ($current_status==4)
			{
				$where .= " AND l.`status` IN (4, 5, 6, 7, 8, 9) "; 
			}
			else
			{
				$where .= " AND l.`status` = '".$this->db->escape_str($current_status)."' "; 
			}			
		}
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

		if ($make <> "") { $where .= " AND l.`make` LIKE '%".$this->db->escape_str($make)."%' "; }
		if ($model <> "") { $where .= " AND l.`model` LIKE '%".$this->db->escape_str($model)."%' "; }
		if ($source <> "") { $where .= " AND l.`source` = '".$this->db->escape_str($source)."' "; }

		/*
		if ($status == 1) { $status_date_label = "allocated_date"; }
		else if ($status == 2) { $status_date_label = "attempted_date"; }
		else if ($status == 3) { $status_date_label = "tender_date"; }
		else if ($status == 4) { $status_date_label = "order_date"; }
		else if ($status == 5) { $status_date_label = "approved_date"; }
		else if ($status == 6) { $status_date_label = "delivery_date"; }
		else if ($status == 7) { $status_date_label = "settled_date"; }		
		else if ($status == 98) { $status_date_label = "decline_date"; }
		else if ($status == 100) { $status_date_label = "delete_date"; }
		else { $status_date_label = "created_at"; }
		if ($date_from <> "") { $where .= " AND DATE(l.`".$status_date_label."`) >= DATE('".$this->db->escape_str($date_from)."') "; }
		if ($date_to <> "") { $where .= " AND DATE(l.`".$status_date_label."`) <= DATE('".$this->db->escape_str($date_to)."') "; }
		*/

		$filter_column = "";

		if( isset($params['filter_column']) )
		{
			if($params['filter_column'] != "")
				$filter_column = $params['filter_column'];
			else
				$filter_column = "created_at";
		}

		if($date_filter_by != "")
		{
			if($date_filter_by == 1)
				$where .= " AND (DATE(`l`.`{$filter_column}`) BETWEEN  '".date( "Y-m-d",strtotime('monday this week') )."' AND '".date( "Y-m-d",strtotime("sunday this week") )."' )";
			elseif($date_filter_by == 2)
				$where .= " AND (DATE(`l`.`{$filter_column}`) BETWEEN  '".date( "Y-m-d",strtotime('monday last week') )."' AND '".date( "Y-m-d",strtotime("sunday last week") )."' )";
			elseif($date_filter_by == 3)
				$where .= " AND (DATE(`l`.`{$filter_column}`) BETWEEN  '".date( "Y-m-d",strtotime('first day of this month') )."' AND '".date( "Y-m-d",strtotime("last day of this month") )."' )";
			elseif($date_filter_by == 4)
				$where .= " AND (DATE(`l`.`{$filter_column}`) BETWEEN  '".date( "Y-m-d",strtotime('first day of last month') )."' AND '".date( "Y-m-d",strtotime("last day of last month") )."' )";
			elseif($date_filter_by == 5)
				$where .= " AND DATE(`l`.`{$filter_column}`) = '".date( "Y-m-d" )."'"; 
			elseif($date_filter_by == 6)
				$where .= " AND DATE(`l`.`{$filter_column}`) = '".date( "Y-m-d",strtotime('yesterday') )."'"; 
			elseif($date_filter_by == 7)
			{
				if(isset($params['filter_date_from']))
					$filter_date_from = date('Y-m-d', strtotime($params['filter_date_from']));
				else
					$filter_date_from = date('Y-m-d');

				if(isset($params['filter_date_to']))
					$filter_date_to = date('Y-m-d', strtotime($params['filter_date_to']));
				else
					$filter_date_to = date('Y-m-d');

				$where .= " AND (DATE(`l`.`{$filter_column}`) BETWEEN '{$filter_date_from}' AND '{$filter_date_to}' ) ";
			}
			else
			{
				$where .= " ";
			}
		}
	
		$query = "SELECT COUNT(1) AS cnt FROM `leads` l WHERE l.`deprecated` <> 1 AND l.fk_buyer = 0 AND (l.`phone` <> '' OR l.`mobile` <> '') ".$where."";
		return $this->db->query($query)->row_array();
	}

	public function get_winning_dealer ($lead_id)
	{
		$query = "
		SELECT d.id_user, d.username, d.name, d.account_email, d.account_name, d.deposit_show_status
		FROM `users` d
		JOIN `quotes` q ON d.id_user = q.fk_user
		JOIN `quote_requests` qr ON q.id_quote = qr.winner
		JOIN `leads` l ON qr.fk_lead = l.id_lead		
		WHERE l.`id_lead` = '".$lead_id."'";
		return $this->db->query($query)->row_array();
	}

	public function get_email_dealer_info ($lead_id)
	{
		$query = "
		SELECT d.id_user, d.username, d.name, d.account_email as `dealer_email`, d.account_name as `dealer_name`
		FROM `users` d
		JOIN `quotes` q ON d.id_user = q.fk_user
		JOIN `quote_requests` qr ON q.id_quote = qr.winner
		JOIN `leads` l ON qr.fk_lead = l.id_lead		
		WHERE l.`id_lead` = '".$lead_id."'";
		return $this->db->query($query)->row_array();
	}

	public function get_leads_mycalendar ($status_ids, $my_id, $admin_type) // ADMIN
	{
		$now = date("Y-m-d H:i:s");
		
		$where = "";
		if ($admin_type == 2)
		{
			$user_id = isset($params['user_id']) ? $params['user_id'] : '';
			if ($user_id <> "" AND $user_id <> 0) 
			{
				$where .= " AND l.fk_user = '".$this->db->escape_str($user_id)."' ";
			}
			else
			{
				$where .= " AND l.fk_user = ".$my_id;
			}
		}
		else
		{
			$where .= " AND l.fk_user = ".$my_id;
		}
		
		$where .= " AND l.status IN (".$status_ids." '9999')";

		$query = "
		SELECT l.id_lead,
		qr.id_quote_request AS `qr_id`,
		(SELECT COUNT(1) FROM quotes WHERE fk_quote_request = `qr_id` AND deprecated <> 1) AS `quote_count`,
		l.fk_user, l.status,
		CASE (l.status)
			WHEN 0 THEN 'Unallocated'
			WHEN 1 THEN 'Allocated'
			WHEN 2 THEN 'Attempted'
			WHEN 3 THEN 'Tendering'
			WHEN 4 THEN 'Pending Auth'
			WHEN 5 THEN 'Approved by Admin'
			WHEN 6 THEN 'Delivered'
			WHEN 7 THEN 'Settled'
			WHEN 8 THEN 'Admin on Hold'
			WHEN 9 THEN 'Deal Cancelled'
			WHEN 100 THEN 'Deleted'
		END `status_text`,
		CONCAT('QM', LPAD(l.`id_lead`, 5, '0')) AS `cq_number`, 
		l.`name`, l.`email`, l.`mobile`, l.`state`, l.`make`, l.`model`, l.`details`,

		ul.`name` AS `cq_staff`,
		uf.`name` AS `fq_staff`,		

		l.`email` as `ti_email`, l.`phone` as `ti_phone`, l.`mobile` as `ti_mobile`,
		IF (l.`email` <> '', (SELECT COUNT(1) FROM tradeins WHERE email = `ti_email`), 0) AS `tradein_email_check`,
		IF (l.`phone` <> '', (SELECT COUNT(1) FROM tradeins WHERE phone = `ti_phone`), 0) AS `tradein_phone_check`,
		IF (l.`mobile` <> '', (SELECT COUNT(1) FROM tradeins WHERE phone = `ti_mobile`), 0) AS `tradein_mobile_check`,
		(SELECT GREATEST(`tradein_email_check`, `tradein_phone_check`, `tradein_mobile_check`) AS `at`) AS `available_trades`,
		(SELECT IF(`available_trades` = 0, '', CONCAT(`available_trades`, ' Available Trades')) AS `tt`) AS `trade_text`,
		IF (DATE(l.assignment_date) = '0000-00-00' OR DATE(l.assignment_date) = '',
			IF (DATE(l.allocated_date) = '0000-00-00' OR DATE(l.allocated_date) = '',
				DATE(l.allocated_date), DATE('".$now."')
			), 
			DATE(l.assignment_date)
		)
		AS assignment_date,
		l.created_at, l.last_updated
		FROM leads l
		LEFT JOIN users ul ON l.fk_user = ul.id_user
		LEFT JOIN fq_accounts_new fa ON l.id_lead = fa.fk_lead
		LEFT JOIN users uf ON fa.fk_user = uf.id_user		
		LEFT JOIN quote_requests qr ON l.id_lead = qr.fk_lead		
		WHERE l.deprecated <> 1
		AND (l.phone <> '' OR l.mobile <> '')
		".$where."
		ORDER BY l.id_lead ASC";
		$sql = $this->db->query($query);
		return $sql->result();
	}

	public function get_incoming_deliveries ($my_id) // DEALER HOME
	{
		$query = "
		SELECT
		CONCAT('QM', LPAD(l.id_lead, 5, '0')) AS `cq_number`,
		l.name, l.email, l.state, l.postcode,
		m.name AS `make`, f.name AS `model`, v.name AS `variant`, qr.colour,
		qs.username AS `qs_email`, qs.name AS `qs_name`, DATE(l.delivery_date) AS `delivery_date`
		FROM leads l
		JOIN users qs ON l.fk_user = qs.id_user
		JOIN quote_requests qr ON l.id_lead = qr.fk_lead
		LEFT JOIN makes m ON qr.make = m.id_make
		LEFT JOIN families f ON qr.model = f.id_family
		LEFT JOIN vehicles v ON qr.variant = v.id_vehicle
		JOIN quotes q ON qr.winner = q.id_quote
		WHERE q.fk_user = '".$my_id."' AND l.status = 5 AND l.dealer_status = 1
		GROUP BY l.id_lead
		ORDER BY l.delivery_date ASC
		LIMIT 5";
		$sql = $this->db->query($query);
		return $sql->result_array();
	}

	public function get_newest_orders ($my_id) // DEALER HOME
	{
		$query = "
		SELECT
		CONCAT('QM', LPAD(l.id_lead, 5, '0')) AS `cq_number`,
		l.name, l.email, l.state, l.postcode,
		m.name AS `make`, f.name AS `model`, v.name AS `variant`, qr.colour,
		qs.username AS `qs_email`, qs.name AS `qs_name`
		FROM leads l
		JOIN users qs ON l.fk_user = qs.id_user
		JOIN quote_requests qr ON l.id_lead = qr.fk_lead
		LEFT JOIN makes m ON qr.make = m.id_make
		LEFT JOIN families f ON qr.model = f.id_family
		LEFT JOIN vehicles v ON qr.variant = v.id_vehicle
		JOIN quotes q ON qr.winner = q.id_quote
		WHERE q.fk_user = '".$my_id."' AND l.status = 5 AND l.dealer_status = 0
		GROUP BY l.id_lead
		ORDER BY l.order_date DESC
		LIMIT 5";
		$sql = $this->db->query($query);
		return $sql->result_array();
	}

	public function get_orders_count ($params, $my_id) // DEALER
	{
		$status = isset($params['status']) ? $params['status'] : '';
		
		$where = "";
		if ($status == 0) { $where .= " AND l.status = 5 AND l.dealer_status = 0 AND l.client_status IN (2, 3) "; }
		else if ($status == 1) { $where .= " AND l.status = 5 AND l.dealer_status = 1 AND l.client_status IN (2, 3) "; }
		else if ($status == 2) { $where .= " AND (l.status IN (6, 7) OR l.dealer_status = 2) AND l.client_status IN (2, 3) "; }

		$query = "
		SELECT COUNT(DISTINCT l.id_lead) AS `cnt`
		FROM leads l
		JOIN users qs ON l.fk_user = qs.id_user
		JOIN quote_requests qr ON l.id_lead = qr.fk_lead
		JOIN quotes q ON qr.winner = q.id_quote
		WHERE q.fk_user = '".$my_id."' ".$where."";
		return $this->db->query($query)->row_array();
	}

	public function get_orders ($params, $my_id, $start, $limit) // DEALER
	{
		$status = isset($params['status']) ? $params['status'] : '';

		$where = "";
		if ($status == 0) { $where .= " AND l.status = 5 AND l.dealer_status = 0 AND l.client_status IN (2, 3) "; }
		else if ($status == 1) { $where .= " AND l.status = 5 AND l.dealer_status = 1 AND l.client_status IN (2, 3) "; }
		else if ($status == 2) { $where .= " AND (l.status IN (6, 7) OR l.dealer_status = 2) AND l.client_status IN (2, 3) "; }

		$query = "
		SELECT
		l.id_lead,
		qr.id_quote_request, 
		q.id_quote,

		CONCAT('QM', LPAD(l.id_lead, 5, '0')) AS `cq_number`, l.status,
		CASE (l.status)
			WHEN 5 THEN 'Approved by Admin'
			WHEN 6 THEN 'Delivered'
			WHEN 7 THEN 'Settled'
		END `status_text`,
		
		l.dealer_status, 	
		
		l.`client_status`,
		CASE (l.`client_status`)
			WHEN 0 THEN 'Pending Client Approval'
			WHEN 1 THEN 'Agreement Seen'
			WHEN 2 THEN 'Approved by Client'
			WHEN 3 THEN 'Awaiting Approval'
		END `client_status_text`,

		l.name, l.email, l.phone, l.mobile, l.state, l.postcode, l.address, l.details,

		m.name AS `make`, f.name AS `model`, v.name AS `variant`, qr.colour,

		l.created_at,
		l.last_updated,
		DATE(l.order_date) AS `order_date`,
		IF(DATE(l.delivery_date) = '0000-00-00', '', DATE(l.delivery_date)) AS `delivery_date`,

		l.tradein_value, l.tradein_payout, l.tradein_given, l.wholesaler, l.wholesaler_value, l.admin_note, l.rego,
		l.cpp, l.gross_subtractor, l.gross_subtractor_lower, l.deposit, l.other_costs_amount, l.other_revenue_amount,

		qs.username AS `qs_email`, qs.name AS `qs_name`, qs.phone AS `qs_phone`, qs.mobile AS `qs_mobile`, 

		qr.winner AS `winner_id`, (SELECT total FROM quotes WHERE id_quote = `winner_id` LIMIT 1) as `winning_price`, 

		l.tradein_given

		FROM leads l
		JOIN users qs ON l.fk_user = qs.id_user
		JOIN quote_requests qr ON l.id_lead = qr.fk_lead
		LEFT JOIN makes m ON qr.make = m.id_make
		LEFT JOIN families f ON qr.model = f.id_family
		LEFT JOIN vehicles v ON qr.variant = v.id_vehicle
		JOIN quotes q ON qr.winner = q.id_quote
		WHERE q.fk_user = '".$my_id."' ".$where."
		GROUP BY l.id_lead
		ORDER BY l.delivery_date ASC
		LIMIT ".$start.", ".$limit;
		$sql = $this->db->query($query);
		return $sql->result_array();
	}

	public function get_lead_email ($lead_id, $email_type)
	{
		$query = "
		SELECT DATE(created_at) as `created_at` FROM actions 
		WHERE type = 1 AND id = ".$lead_id." AND details = 'Client Email: ".$email_type."' LIMIT 1";
		return $this->db->query($query)->row_array();
	}

	public function get_lead_client ($lead_id)
	{
		$query = "SELECT fk_user, name, email FROM leads WHERE id_lead = ".$lead_id;
		return $this->db->query($query)->row_array();
	}
	
	public function get_deals_tile ($params, $my_id, $admin_type, $start, $limit)
	{
		$status = isset($params['status']) ? $params['status'] : '';
		$aftersales_status = isset($params['aftersales_status']) ? $params['aftersales_status'] : '';
		$home_status = isset($params['home_status']) ? $params['home_status'] : '';
		
		$cq_number = isset($params['cq_number']) ? $params['cq_number'] : '';
		$finance = isset($params['finance']) ? $params['finance'] : '';
		$client = isset($params['client']) ? $params['client'] : '';
		$quote_specialist = isset($params['quote_specialist']) ? $params['quote_specialist'] : '';
		$dealer = isset($params['dealer']) ? $params['dealer'] : '';
		$make = isset($params['make']) ? $params['make'] : '';
		$model = isset($params['model']) ? $params['model'] : '';
		$tradein = isset($params['tradein']) ? $params['tradein'] : '';
		$tradein_buyer = isset($params['tradein_buyer']) ? $params['tradein_buyer'] : '';
		$sort = isset($params['sort']) ? $params['sort'] : '';
		$direction = isset($params['direction']) ? $params['direction'] : '';
		
		$interstate = isset($params['interstate']) ? $params['interstate'] : '';
		
		$incomplete_details = isset($params['incomplete_details']) ? $params['incomplete_details'] : '';
		$revenue_low = isset($params['revenue_low']) ? $params['revenue_low'] : '';
		$commissionable_gross_low = isset($params['commissionable_gross_low']) ? $params['commissionable_gross_low'] : '';
		
		$invoice_number = isset($params['invoice_number']) ? $params['invoice_number'] : '';
		$reference_number = isset($params['reference_number']) ? $params['reference_number'] : '';		

		$where = "";
		$join = "";
		$order = "";

		if ($home_status <> "")
		{
			if ($home_status==0) // Unattempted Leads
			{
				$where .= " AND l.`status` = '1' AND l.`fk_user` = '".$this->db->escape_str($my_id)."'";
			}
			else if ($home_status==1) // Attempted Leads
			{
				$where .= " AND l.`status` = '2' AND l.`fk_user` = '".$this->db->escape_str($my_id)."'";
			}
			else if ($home_status==2) // Pre Tenders
			{
				$where .= " AND l.`status` = '10' AND l.`fk_user` = '".$this->db->escape_str($my_id)."'";
			}			
			else if ($home_status==3) // Tenders
			{
				$where .= " AND l.`status` = '3' AND l.`fk_user` = '".$this->db->escape_str($my_id)."'";
			}
			else if ($home_status==4) // Orders
			{
				$where .= " AND l.`status` IN (4, 5, 6, 7, 8, 9) AND l.`fk_user` = '".$this->db->escape_str($my_id)."'";
			}			
		}
		else
		{
			if ($aftersales_status <> "")
			{
				$where .= " AND l.`aftersales_status` = '".$this->db->escape_str($aftersales_status)."' ";
			}
			
			if ($status <> "")
			{
				$where .= " AND l.`status` = '".$this->db->escape_str($status)."' ";
			}
			else
			{
				$where .= " AND l.`status` IN (4, 5, 6, 7, 8, 9) ";
			}			
		}

		if ($finance <> "")
		{
			$where .= " AND l.`finance` = '".$this->db->escape_str($params['finance'])."'";
		}

		if ($cq_number <> "")
		{
			$where .= " 
			AND (l.`id_lead` = '".$this->db->escape_str($params['cq_number'])."' 
			OR CONCAT('QM', LPAD(l.`id_lead`, 5, '0')) = '".$this->db->escape_str($params['cq_number'])."') ";
		}
		
		if ($client <> "")
		{
			$where .= " 
			AND (l.`name` LIKE '%".$this->db->escape_str($params['client'])."%' 
			OR l.`email` LIKE '%".$this->db->escape_str($params['client'])."%') ";
		}
		
		if ($quote_specialist <> "")
		{
			$where .= " 
			AND (qs.`name` LIKE '%".$this->db->escape_str($params['quote_specialist'])."%' 
			OR qs.`username` LIKE '%".$this->db->escape_str($params['quote_specialist'])."%') ";
		}

		if ($dealer <> "")
		{
			$where .= " 
			AND (qs.`name` LIKE '%".$this->db->escape_str($params['dealer'])."%' 
			OR qs.`username` LIKE '%".$this->db->escape_str($params['dealer'])."%') ";
		}
		
		if ($make <> "")
		{
			$where .= " AND m.`name` LIKE '%".$this->db->escape_str($params['make'])."%' ";
		}

		if ($model <> "")
		{
			$where .= " AND f.`name` LIKE '%".$this->db->escape_str($params['model'])."%' ";
		}
		
		if ($tradein <> "")
		{
			if ($tradein == 0)
			{
				$where .= " AND ti.`id_tradein` = 0 ";
			}
			else if ($tradein == 1)
			{
				$where .= " AND ti.`id_tradein` <> 0 ";
				if ($tradein_buyer == 1)
				{
					$where .= " AND tv.`fk_user` = 282 ";
				}
				else if ($tradein_buyer == 2)
				{
					$where .= " AND tv.`fk_user` NOT IN (282, 374) ";
				}				
				else if ($tradein_buyer == 3)
				{
					$where .= " AND tv.`fk_user` = 374 ";
				}		
			}
			else
			{
				$where .= "";
			}
		}
		
		if ($sort <> "")
		{
			if ($direction <> "ASC" AND $direction <> "DESC")
			{
				$direction = " ASC ";
			}
			
			if ($sort == "balcqo")
			{
				$order = " ORDER BY ".$this->balcqo_query." ".$direction;
			}
			else if ($sort == "revenue")
			{
				$order = " ORDER BY ".$this->revenue_query." ".$direction;
			}
			else if ($sort == "commissionable_gross")
			{
				$order = " ORDER BY ".$this->commissionable_gross_query." ".$direction;
			}
			else
			{
				$order = " ORDER BY ".$sort." ".$direction;
			}
		}

		if ($interstate == 1)
		{
			$where .= " AND l.`state` <> d.`state` ";
		}
		
		if ($incomplete_details == 1)
		{
			$where .= " 
			AND (
				l.`name` = '' OR l.`email` = '' 
				OR (l.`phone` = '' AND l.`mobile`)
				OR (l.`state` = '' AND l.`postcode` = '' AND l.`address` = '')
				OR l.`delivery_address` = ''
			) ";
		}
		
		if ($revenue_low == 1)
		{
			$where .= " 
			AND (
				IF(tv.fk_user = 282, 
					l.sales_price - l.tradein_given + l.tradein_payout - q.dealer_changeover - l.other_costs_amount + l.other_revenue_amount,
					l.sales_price + (l.tradein_value - l.tradein_given) - q.total - l.other_costs_amount + l.other_revenue_amount
				) <= 0
			) ";
		}
		
		if ($commissionable_gross_low == 1)
		{
			$where .= " AND (".$this->commissionable_gross_query." <= 0) ";
		}
		
		if ($invoice_number <> "")
		{
			$where .= " AND i.`invoice_number` = '".$this->db->escape_str($params['invoice_number'])."' ";
			$join .= " LEFT JOIN `invoices` AS `i` ON l.`id_lead` = i.`fk_lead` ";
		}
		
		if ($reference_number <> "")
		{
			$where .= " AND p.`reference_number` = '".$this->db->escape_str($params['reference_number'])."' ";
			$join .= " LEFT JOIN `payments` AS `p` ON l.`id_lead` = p.`fk_lead` ";
		}
		
		$query = "
		SELECT

		l.`id_lead`, 
		l.`id_lead` AS `lead_id`,

		CONCAT('QM', LPAD(l.`id_lead`, 5, '0')) AS `cq_number`,
		CONCAT('PO', LPAD(l.`id_lead`, 5, '0')) AS `po_number`,
		CONCAT('TID', LPAD(l.`id_lead`, 5, '0')) AS `dealer_invoice_number`,
		CONCAT('TIC', LPAD(l.`id_lead`, 5, '0')) AS `client_invoice_number`,

		l.`status`,
		CASE (l.`status`)
			WHEN 0 THEN 'Unallocated'
			WHEN 1 THEN 'Allocated'
			WHEN 2 THEN 'Attempted'
			WHEN 3 THEN 'Tendering'
			WHEN 4 THEN 'Pending Auth'
			WHEN 5 THEN 'Approved by Admin'
			WHEN 6 THEN 'Delivered'
			WHEN 7 THEN 'Settled'
			WHEN 8 THEN 'Admin on Hold'
			WHEN 9 THEN 'Deal Cancelled'
			WHEN 100 THEN 'Deleted'
		END `status_text`,

		l.`dealer_status`,
		CASE (l.`dealer_status`)
			WHEN 0 THEN 'Pending'
			WHEN 1 THEN 'Approved'
			WHEN 2 THEN 'Delivered'
		END `dealer_status_text`,

		l.`admin_status`, 
		
		l.`aftersales_status`,

		l.`finance`,
				
		l.`name`, l.`business_name`, l.`email`, l.`state`, l.`postcode`, l.`address`, 
		l.`phone`, l.`mobile`, l.`date_of_birth`, l.`driver_license`, l.`details`, 
		l.`admin_details`, l.`admin_to_qs_details`,

		qr.`id_quote_request`, 
		qr.`id_quote_request` AS `qr_id`, 

		qs.`id_user`,
		qs.`id_user` AS `qs_id`,
		qs.`name` AS `qs_name`, 
		qs.`username` AS `qs_email`, qs.`phone` AS `qs_phone`, qs.`mobile` AS `qs_mobile`,

		d.`id_user` AS `dealer_id`,
		da.`dealership_name` AS `dealership_name`, d.`name` AS `fleet_manager`, 
		d.`username` AS `dealer_email`, d.`phone` AS `dealer_phone`, d.`mobile` AS `dealer_mobile`, 
		d.`state` AS `dealer_state`, d.`postcode` AS `dealer_postcode`, d.`address` AS `dealer_address`,

		l.`make` AS `make`, l.`model` AS `model`,

		m.`id_make`, m.`name` AS `tender_make`,

		f.`id_family`, f.`name` AS `tender_model`, 

		v.`id_vehicle`, v.`name` AS `tender_variant`,

		qr.`build_date`, qr.`series`, qr.`body_type`, qr.`registration_type`, 
		qr.`colour`, qr.`transmission`, qr.`fuel_type`,
		qr.`message` AS `qr_message`,

		q.`id_quote`,
		q.`id_quote` AS `quote_id`,
		q.`sender`,
		q.`id_quote` AS `winner`, 
		q.`total`, q.`dealer_tradein_value`, q.`dealer_tradein_payout`, q.`dealer_client_refund`, q.`dealer_changeover` AS `dealer_changeover_column`,
		q.`retail_price`, q.`predelivery`, q.`gst`, q.`stamp_duty`, q.`registration`, q.`premium_plate_fee`, q.`ctp`, 
		q.`luxury_tax`, q.`dealer_discount`, q.`fleet_discount`, q.`build_date`, q.`compliance_date`,
		q.`vin`, q.`engine`, q.`registration_plate`, q.`registration_expiry`, IF(q.`kms` = 0, '', q.`kms`) AS `kms`,

		(SELECT COUNT(1) FROM `tradeins` WHERE `fk_lead` = `lead_id`) AS `tradein_count`,
		(SELECT COUNT(1) FROM `tradeins` AS `t` 
			JOIN `trade_valuations` AS `tv`
			ON t.`fk_trade_valuation` = tv.`id_trade_valuation`
			WHERE t.`fk_lead` = `lead_id` AND tv.`fk_user` = 282
		) AS `dealer_tradein_count`,

		(q.`total` - q.`dealer_tradein_value` + q.`dealer_tradein_payout` + q.`dealer_client_refund` ) AS `dealer_changeover`,

		(SELECT COUNT(1) FROM `quotes` WHERE `fk_quote_request` = `qr_id`) AS `quote_count`,
		
		(SELECT COUNT(1) FROM `call_logs` WHERE `fk_lead` = `lead_id`) AS `called_count`,
		
		(SELECT created_at FROM `call_logs` WHERE `fk_lead` = `lead_id` ORDER BY id_call_log DESC LIMIT 1) AS `last_call`,
		
		(SELECT COUNT(1) FROM `sent_emails` WHERE `fk_lead` = `lead_id` ORDER BY id_sent_email DESC LIMIT 1) AS `sent_emails_count`,
		
		DATE(l.`deleted_date`) AS `deleted_date`, 
		DATE(l.`allocated_date`) AS `allocated_date`, 
		DATE(l.`attempted_date`) AS `attempted_date`, 
		DATE(l.`tender_date`) AS `tender_date`,
		DATE(l.`order_date`) AS `order_date`,
		DATE(l.`approved_date`) AS `approved_date`,
		DATE(l.`delivery_date`) AS `delivery_date`,
		DATE(l.`settled_date`) AS `settled_date`,
		DATE(l.`cancelled_date`) AS `cancelled_date`,
		
		DATE(l.`assignment_date`) AS `assignment_date`,
		l.`assignment_time` AS `assignment_time`,
		
		l.`deleted_date` AS `deleted_date_time`,
		l.`allocated_date` AS `allocated_date_time`,
		l.`attempted_date` AS `attempted_date_time`,
		l.`tender_date` AS `tender_date_time`,
		l.`order_date` AS `order_date_time`,
		l.`approved_date` AS `approved_date_time`,
		l.`delivery_date` AS `delivery_date_time`,
		l.`settled_date` AS `settled_date_time`,
		l.`cancelled_date` AS `cancelled_date_time`,
		
		l.`created_at`, l.`last_updated`,

		(SELECT COALESCE(SUM(`amount`), 0.00) 
			FROM payments WHERE fk_payment_type = 2 AND fk_lead = `lead_id` AND deprecated <> 1
		) AS `deposits_total`,

		(SELECT COALESCE(SUM(`amount`), 0.00) 
			FROM payments WHERE fk_payment_type = 7 AND fk_lead = `lead_id` AND deprecated <> 1
		) AS `refunds_total`,

		l.`delivery_address`, l.`delivery_instructions`, l.`special_conditions`,
		l.`tradein_value`, l.`tradein_payout`, l.`tradein_given`,
		l.`balcqo_client`, l.`sales_price`, l.`cpp`,
		l.`gross_subtractor`, l.`gross_subtractor_lower`,
		l.`other_costs_amount`, l.`other_costs_description`, 
		l.`other_revenue_amount`, l.`other_revenue_description`,

		tv.`fk_user` AS `tradein_buyer`,

		IF (tv.`fk_user` = 282, 'Dealer', IF(tv.`fk_user` = 374, 'Quote Me', 'Wholesaler')) AS `tradein_buyer_user_type`,		

		".$this->revenue_query." AS `revenue`,
		".$this->balcqo_query." AS `balcqo`,		
		".$this->commissionable_gross_query." AS `commissionable_gross`,

		(
			SELECT COALESCE(SUM(pt.`sign` * p.`amount`), 0)
			FROM payments p
			JOIN payment_types pt ON p.`fk_payment_type` = pt.`id_payment_type`
			WHERE p.`fk_lead` = `lead_id` 
			AND p.`deprecated` <> 1
		) AS `total_payments`,
		
		(SELECT `balcqo` - `total_payments`) AS `remaining_balance`

		FROM `leads` AS `l`
		LEFT JOIN `users` AS `qs` ON l.`fk_user` = qs.`id_user`
		LEFT JOIN `quote_requests` AS `qr` ON l.`id_lead` = qr.`fk_lead`
		LEFT JOIN `makes` AS `m` ON qr.`make` = m.`id_make`
		LEFT JOIN `families` AS `f` ON qr.`model` = f.`id_family`
		LEFT JOIN `vehicles` AS `v` ON qr.`variant` = v.`id_vehicle`
		LEFT JOIN `quotes` AS `q` ON qr.`winner` = q.`id_quote`
		LEFT JOIN `users` AS `d` ON q.`fk_user` = d.`id_user`
		LEFT JOIN `dealer_attributes` AS `da` ON d.`id_user` = da.`fk_user`
		LEFT JOIN `tradeins` ti ON l.`id_lead` = ti.`fk_lead`
		LEFT JOIN `trade_valuations` tv ON tv.`id_trade_valuation` = ti.`fk_trade_valuation`
		".$join."
		WHERE 1 AND l.`deprecated` <> 1 
		".$where."
		GROUP BY l.`id_lead` ".$order." LIMIT ".$start.", ".$limit;
		$sql = $this->db->query($query);
		return $sql->result_array();
	}
	
	public function get_deals_tile_summary ($params, $my_id, $admin_type)
	{
		$status = isset($params['status']) ? $params['status'] : '';
		$aftersales_status = isset($params['aftersales_status']) ? $params['aftersales_status'] : '';
		$home_status = isset($params['home_status']) ? $params['home_status'] : '';
		
		$cq_number = isset($params['cq_number']) ? $params['cq_number'] : '';
		$finance = isset($params['finance']) ? $params['finance'] : '';
		$client = isset($params['client']) ? $params['client'] : '';
		$quote_specialist = isset($params['quote_specialist']) ? $params['quote_specialist'] : '';
		$dealer = isset($params['dealer']) ? $params['dealer'] : '';
		$make = isset($params['make']) ? $params['make'] : '';
		$model = isset($params['model']) ? $params['model'] : '';
		$tradein = isset($params['tradein']) ? $params['tradein'] : '';
		$tradein_buyer = isset($params['tradein_buyer']) ? $params['tradein_buyer'] : '';
		$sort = isset($params['sort']) ? $params['sort'] : '';
		$direction = isset($params['direction']) ? $params['direction'] : '';	

		$interstate = isset($params['interstate']) ? $params['interstate'] : '';
		
		$incomplete_details = isset($params['incomplete_details']) ? $params['incomplete_details'] : '';
		$revenue_low = isset($params['revenue_low']) ? $params['revenue_low'] : '';
		$commissionable_gross_low = isset($params['commissionable_gross_low']) ? $params['commissionable_gross_low'] : '';

		$invoice_number = isset($params['invoice_number']) ? $params['invoice_number'] : '';
		$reference_number = isset($params['reference_number']) ? $params['reference_number'] : '';		

		$where = "";
		$join = "";

		if ($home_status <> "")
		{
			if ($home_status==0) // Unattempted Leads
			{
				$where .= " AND l.`status` = '1' AND l.`fk_user` = '".$this->db->escape_str($my_id)."'";
			}
			else if ($home_status==1) // Attempted Leads
			{
				$where .= " AND l.`status` = '2' AND l.`fk_user` = '".$this->db->escape_str($my_id)."'";
			}
			else if ($home_status==2) // Pre Tenders
			{
				$where .= " AND l.`status` = '10' AND l.`fk_user` = '".$this->db->escape_str($my_id)."'";
			}			
			else if ($home_status==3) // Tenders
			{
				$where .= " AND l.`status` = '3' AND l.`fk_user` = '".$this->db->escape_str($my_id)."'";
			}
			else if ($home_status==4) // Orders
			{
				$where .= " AND l.`status` IN (4, 5, 6, 7, 8, 9) AND l.`fk_user` = '".$this->db->escape_str($my_id)."'";
			}			
		}
		else
		{
			if ($aftersales_status <> "")
			{
				$where .= " AND l.`aftersales_status` = '".$this->db->escape_str($aftersales_status)."' ";
			}
			
			if ($status <> "")
			{
				$where .= " AND l.`status` = '".$this->db->escape_str($status)."' ";
			}
			else
			{
				$where .= " AND l.`status` IN (4, 5, 6, 7, 8, 9) ";
			}			
		}

		if ($finance <> "")
		{
			$where .= " AND l.`finance` = '".$this->db->escape_str($params['finance'])."'";
		}

		if ($cq_number <> "")
		{
			$where .= " 
			AND (l.`id_lead` = '".$this->db->escape_str($params['cq_number'])."' 
			OR CONCAT('QM', LPAD(l.`id_lead`, 5, '0')) = '".$this->db->escape_str($params['cq_number'])."') ";
		}
		
		if ($client <> "")
		{
			$where .= " 
			AND (l.`name` LIKE '%".$this->db->escape_str($params['client'])."%' 
			OR l.`email` LIKE '%".$this->db->escape_str($params['client'])."%') ";
		}
		
		if ($quote_specialist <> "")
		{
			$where .= " 
			AND (qs.`name` LIKE '%".$this->db->escape_str($params['quote_specialist'])."%' 
			OR qs.`username` LIKE '%".$this->db->escape_str($params['quote_specialist'])."%') ";
		}

		if ($dealer <> "")
		{
			$where .= " 
			AND (qs.`name` LIKE '%".$this->db->escape_str($params['dealer'])."%' 
			OR qs.`username` LIKE '%".$this->db->escape_str($params['dealer'])."%') ";
		}
		
		if ($make <> "")
		{
			$where .= " AND m.`name` LIKE '%".$this->db->escape_str($params['make'])."%' ";
		}

		if ($model <> "")
		{
			$where .= " AND f.`name` LIKE '%".$this->db->escape_str($params['model'])."%' ";
		}
		
		if ($tradein <> "")
		{
			if ($tradein == 0)
			{
				$where .= " AND ti.`id_tradein` = 0 ";
			}
			else if ($tradein == 1)
			{
				$where .= " AND ti.`id_tradein` <> 0 ";
				if ($tradein_buyer == 1)
				{
					$where .= " AND tv.`fk_user` = 282 ";
				}
				else if ($tradein_buyer == 2)
				{
					$where .= " AND tv.`fk_user` NOT IN (282, 374) ";
				}				
				else if ($tradein_buyer == 3)
				{
					$where .= " AND tv.`fk_user` = 374 ";
				}		
			}
			else
			{
				$where .= "";
			}
		}
		
		if ($sort <> "")
		{
			if ($direction <> "ASC" AND $direction <> "DESC")
			{
				$direction = " ASC ";
			}
			
			if ($sort == "balcqo")
			{
				$order = " ORDER BY ".$this->balcqo_query." ".$direction;
			}
			else if ($sort == "revenue")
			{
				$order = " ORDER BY ".$this->revenue_query." ".$direction;
			}
			else if ($sort == "commissionable_gross")
			{
				$order = " ORDER BY ".$this->commissionable_gross_query." ".$direction;
			}
			else
			{
				$order = " ORDER BY ".$sort." ".$direction;
			}
		}

		if ($interstate == 1)
		{
			$where .= " AND l.`state` <> d.`state` ";
		}
		
		if ($incomplete_details == 1)
		{
			$where .= " 
			AND (
				l.`name` = '' OR l.`email` = '' 
				OR (l.`phone` = '' AND l.`mobile`)
				OR (l.`state` = '' AND l.`postcode` = '' AND l.`address` = '')
				OR l.`delivery_address` = ''
			) ";
		}
		
		if ($revenue_low == 1)
		{
			$where .= " 
			AND (
				IF(tv.fk_user = 282, 
					l.sales_price - l.tradein_given + l.tradein_payout - q.dealer_changeover - l.other_costs_amount + l.other_revenue_amount,
					l.sales_price + (l.tradein_value - l.tradein_given) - q.total - l.other_costs_amount + l.other_revenue_amount
				) <= 0
			) ";
		}
		
		if ($commissionable_gross_low == 1)
		{
			$where .= " AND (".$this->commissionable_gross_query." <= 0) ";
		}
		
		if ($invoice_number <> "")
		{
			$where .= " AND i.`invoice_number` = '".$this->db->escape_str($params['invoice_number'])."' ";
			$join .= " LEFT JOIN `invoices` AS `i` ON l.`id_lead` = i.`fk_lead` ";
		}
		
		if ($reference_number <> "")
		{
			$where .= " AND p.`reference_number` = '".$this->db->escape_str($params['reference_number'])."' ";
			$join .= " LEFT JOIN `payments` AS `p` ON l.`id_lead` = p.`fk_lead` ";
		}
		
		$query = "
		SELECT 
			l.`id_lead` AS `lead_id`,
			
			(".$this->revenue_query.") AS `revenue`,
			(".$this->commissionable_gross_query.") AS `commissionable_gross`,
			(".$this->balcqo_query.") AS `balcqo`,

			(
				SELECT COALESCE(SUM(pt.`sign` * p.`amount`), 0)
					FROM payments p
					JOIN payment_types pt ON p.`fk_payment_type` = pt.`id_payment_type`
					WHERE p.`fk_lead` = `lead_id` 
					AND p.`deprecated` <> 1
			) AS `payments`
		
		FROM `leads` l
		LEFT JOIN `users` AS `qs` ON l.`fk_user` = qs.`id_user`
		LEFT JOIN `quote_requests` AS `qr` ON l.`id_lead` = qr.`fk_lead`
		LEFT JOIN `makes` AS `m` ON qr.`make` = m.`id_make`
		LEFT JOIN `families` AS `f` ON qr.`model` = f.`id_family`
		LEFT JOIN `vehicles` AS `v` ON qr.`variant` = v.`id_vehicle`
		LEFT JOIN `quotes` AS `q` ON qr.`winner` = q.`id_quote`
		LEFT JOIN `users` AS `d` ON q.`fk_user` = d.`id_user`
		LEFT JOIN `dealer_attributes` AS `da` ON d.`id_user` = da.`fk_user`
		LEFT JOIN `tradeins` ti ON l.`id_lead` = ti.`fk_lead`
		LEFT JOIN `trade_valuations` tv ON tv.`id_trade_valuation` = ti.`fk_trade_valuation`
		".$join."
		WHERE 1 AND l.deprecated <> 1
		".$where." ";
		return $this->db->query($query)->result_array();		
	}	
	
	public function get_deals_tile_count ($params, $my_id, $admin_type)
	{
		$status = isset($params['status']) ? $params['status'] : '';
		$aftersales_status = isset($params['aftersales_status']) ? $params['aftersales_status'] : '';
		$home_status = isset($params['home_status']) ? $params['home_status'] : '';
		
		$cq_number = isset($params['cq_number']) ? $params['cq_number'] : '';
		$finance = isset($params['finance']) ? $params['finance'] : '';
		$client = isset($params['client']) ? $params['client'] : '';
		$quote_specialist = isset($params['quote_specialist']) ? $params['quote_specialist'] : '';
		$dealer = isset($params['dealer']) ? $params['dealer'] : '';
		$make = isset($params['make']) ? $params['make'] : '';
		$model = isset($params['model']) ? $params['model'] : '';
		$tradein = isset($params['tradein']) ? $params['tradein'] : '';
		$tradein_buyer = isset($params['tradein_buyer']) ? $params['tradein_buyer'] : '';
		$sort = isset($params['sort']) ? $params['sort'] : '';
		$direction = isset($params['direction']) ? $params['direction'] : '';	

		$interstate = isset($params['interstate']) ? $params['interstate'] : '';
		
		$incomplete_details = isset($params['incomplete_details']) ? $params['incomplete_details'] : '';
		$revenue_low = isset($params['revenue_low']) ? $params['revenue_low'] : '';
		$commissionable_gross_low = isset($params['commissionable_gross_low']) ? $params['commissionable_gross_low'] : '';
		
		$invoice_number = isset($params['invoice_number']) ? $params['invoice_number'] : '';
		$reference_number = isset($params['reference_number']) ? $params['reference_number'] : '';

		$where = "";
		$join = "";
		
		if ($home_status <> "")
		{
			if ($home_status==0) // Unattempted Leads
			{
				$where .= " AND l.`status` = '1' AND l.`fk_user` = '".$this->db->escape_str($my_id)."'";
			}
			else if ($home_status==1) // Attempted Leads
			{
				$where .= " AND l.`status` = '2' AND l.`fk_user` = '".$this->db->escape_str($my_id)."'";
			}
			else if ($home_status==2) // Pre Tenders
			{
				$where .= " AND l.`status` = '10' AND l.`fk_user` = '".$this->db->escape_str($my_id)."'";
			}			
			else if ($home_status==3) // Tenders
			{
				$where .= " AND l.`status` = '3' AND l.`fk_user` = '".$this->db->escape_str($my_id)."'";
			}
			else if ($home_status==4) // Orders
			{
				$where .= " AND l.`status` IN (4, 5, 6, 7, 8, 9) AND l.`fk_user` = '".$this->db->escape_str($my_id)."'";
			}			
		}
		else
		{
			if ($aftersales_status <> "")
			{
				$where .= " AND l.`aftersales_status` = '".$this->db->escape_str($aftersales_status)."' ";
			}
			
			if ($status <> "")
			{
				$where .= " AND l.`status` = '".$this->db->escape_str($status)."' ";
			}
			else
			{
				$where .= " AND l.`status` IN (4, 5, 6, 7, 8, 9) ";
			}			
		}

		if ($finance <> "")
		{
			$where .= " AND l.`finance` = '".$this->db->escape_str($params['finance'])."'";
		}

		if ($cq_number <> "")
		{
			$where .= " 
			AND (l.`id_lead` = '".$this->db->escape_str($params['cq_number'])."' 
			OR CONCAT('QM', LPAD(l.`id_lead`, 5, '0')) = '".$this->db->escape_str($params['cq_number'])."') ";
		}
		
		if ($client <> "")
		{
			$where .= " 
			AND (l.`name` LIKE '%".$this->db->escape_str($params['client'])."%' 
			OR l.`email` LIKE '%".$this->db->escape_str($params['client'])."%') ";
		}
		
		if ($quote_specialist <> "")
		{
			$where .= " 
			AND (qs.`name` LIKE '%".$this->db->escape_str($params['quote_specialist'])."%' 
			OR qs.`username` LIKE '%".$this->db->escape_str($params['quote_specialist'])."%') ";
		}

		if ($dealer <> "")
		{
			$where .= " 
			AND (qs.`name` LIKE '%".$this->db->escape_str($params['dealer'])."%' 
			OR qs.`username` LIKE '%".$this->db->escape_str($params['dealer'])."%') ";
		}
		
		if ($make <> "")
		{
			$where .= " AND m.`name` LIKE '%".$this->db->escape_str($params['make'])."%' ";
		}

		if ($model <> "")
		{
			$where .= " AND f.`name` LIKE '%".$this->db->escape_str($params['model'])."%' ";
		}
		
		if ($tradein <> "")
		{
			if ($tradein == 0)
			{
				$where .= " AND ti.`id_tradein` = 0 ";
			}
			else if ($tradein == 1)
			{
				$where .= " AND ti.`id_tradein` <> 0 ";
				if ($tradein_buyer == 1)
				{
					$where .= " AND tv.`fk_user` = 282 ";
				}
				else if ($tradein_buyer == 2)
				{
					$where .= " AND tv.`fk_user` NOT IN (282, 374) ";
				}				
				else if ($tradein_buyer == 3)
				{
					$where .= " AND tv.`fk_user` = 374 ";
				}		
			}
			else
			{
				$where .= "";
			}
		}
		
		if ($sort <> "")
		{
			if ($direction <> "ASC" AND $direction <> "DESC")
			{
				$direction = " ASC ";
			}
			
			if ($sort == "balcqo")
			{
				$order = " ORDER BY ".$this->balcqo_query." ".$direction;
			}
			else if ($sort == "revenue")
			{
				$order = " ORDER BY ".$this->revenue_query." ".$direction;
			}
			else if ($sort == "commissionable_gross")
			{
				$order = " ORDER BY ".$this->commissionable_gross_query." ".$direction;
			}
			else
			{
				$order = " ORDER BY ".$sort." ".$direction;
			}
		}

		if ($interstate == 1)
		{
			$where .= " AND l.`state` <> d.`state` ";
		}
		
		if ($incomplete_details == 1)
		{
			$where .= " 
			AND (
				l.`name` = '' OR l.`email` = '' 
				OR (l.`phone` = '' AND l.`mobile`)
				OR (l.`state` = '' AND l.`postcode` = '' AND l.`address` = '')
				OR l.`delivery_address` = ''
			) ";
		}
		
		if ($revenue_low == 1)
		{
			$where .= " 
			AND (
				IF(tv.fk_user = 282, 
					l.sales_price - l.tradein_given + l.tradein_payout - q.dealer_changeover - l.other_costs_amount + l.other_revenue_amount,
					l.sales_price + (l.tradein_value - l.tradein_given) - q.total - l.other_costs_amount + l.other_revenue_amount
				) <= 0
			) ";
		}
		
		if ($commissionable_gross_low == 1)
		{
			$where .= " AND (".$this->commissionable_gross_query." <= 0) ";
		}
		
		if ($invoice_number <> "")
		{
			$where .= " AND i.`invoice_number` = '".$this->db->escape_str($params['invoice_number'])."' ";
			$join .= " LEFT JOIN `invoices` AS `i` ON l.`id_lead` = i.`fk_lead` ";
		}
		
		if ($reference_number <> "")
		{
			$where .= " AND p.`reference_number` = '".$this->db->escape_str($params['reference_number'])."' ";
			$join .= " LEFT JOIN `payments` AS `p` ON l.`id_lead` = p.`fk_lead` ";
		}

		$query = "
		SELECT COUNT(1) AS `cnt` 
		FROM `leads` l
		LEFT JOIN `users` AS `qs` ON l.`fk_user` = qs.`id_user`
		LEFT JOIN `quote_requests` AS `qr` ON l.`id_lead` = qr.`fk_lead`
		LEFT JOIN `makes` AS `m` ON qr.`make` = m.`id_make`
		LEFT JOIN `families` AS `f` ON qr.`model` = f.`id_family`
		LEFT JOIN `vehicles` AS `v` ON qr.`variant` = v.`id_vehicle`
		LEFT JOIN `quotes` AS `q` ON qr.`winner` = q.`id_quote`
		LEFT JOIN `users` AS `d` ON q.`fk_user` = d.`id_user`
		LEFT JOIN `dealer_attributes` AS `da` ON d.`id_user` = da.`fk_user`
		LEFT JOIN `tradeins` ti ON l.`id_lead` = ti.`fk_lead`
		LEFT JOIN `trade_valuations` tv ON tv.`id_trade_valuation` = ti.`fk_trade_valuation`
		".$join."
		WHERE 1 AND l.deprecated <> 1
		".$where." ";
		return $this->db->query($query)->row_array();		
	}
	
	public function get_deals ($params, $my_id, $admin_type, $start, $limit) // ADMIN
	{
		//echo json_encode($params); die();
		$sort_field = isset($params['sort_field']) ? $params['sort_field'] : '';
		$sort_type = isset($params['sort_type']) ? $params['sort_type'] : '';

		$cq_number = isset($params['cq_number']) ? $params['cq_number'] : '';
		$finance = isset($params['finance']) ? $params['finance'] : '';
		//$interstate = isset($params['interstate']) ? $params['interstate'] : '';
		$tradein = isset($params['tradein']) ? $params['tradein'] : '';
		$tradein_buyer = isset($params['tradein_buyer']) ? $params['tradein_buyer'] : '';		

		$current_status = isset($params['current_status']) ? $params['current_status'] : '';
		$dealer_status = isset($params['dealer_status']) ? $params['dealer_status'] : '';
		$aftersales_status = isset($params['aftersales_status']) ? $params['aftersales_status'] : '';
		$user_id = isset($params['user_id']) ? $params['user_id'] : ''; 
		
		$name = isset($params['name']) ? $params['name'] : '';
		$email = isset($params['email']) ? $params['email'] : '';
		$phone = isset($params['phone']) ? $params['phone'] : '';

		$state = isset($params['state']) ? $params['state'] : '';
		$postcode = isset($params['postcode']) ? $params['postcode'] : '';
		$address = isset($params['address']) ? $params['address'] : '';
		
		$make = isset($params['make']) ? $params['make'] : '';
		$model = isset($params['model']) ? $params['model'] : '';
		$dealer_id = isset($params['dealer_id']) ? $params['dealer_id'] : ''; 
		
		$status = isset($params['status']) ? $params['status'] : '';
		$date_from = isset($params['date_from']) ? $params['date_from'] : '';
		$date_to = isset($params['date_to']) ? $params['date_to'] : '';

		$where = "";
		if ($cq_number <> "")
		{
			$where .= " 
			AND (fa.`id_fq_account` = '".$this->db->escape_str($params['cq_number'])."' 
			OR CONCAT('QM', LPAD(fa.`id_fq_account`, 5, '0')) = '".$this->db->escape_str($params['cq_number'])."') ";
		}

		if ($finance <> "")
		{
			$where .= " AND fa.`finance` = '".$this->db->escape_str($params['finance'])."'";
		}
		
		// if ($interstate == 1)
		// {
			// $where .= " AND fa.`lead_state` <> d.`state` ";
		// }		

		if ($tradein <> "")
		{
			if ($tradein == 0)
			{
				$where .= " AND ti.`id_tradein` = 0 ";
			}
			else if ($tradein == 1)
			{
				$where .= " AND ti.`id_tradein` <> 0 ";
				if ($tradein_buyer == 1)
				{
					$where .= " AND tv.`fk_user` = 282 ";
				}
				else if ($tradein_buyer == 2)
				{
					$where .= " AND tv.`fk_user` NOT IN (282, 374) ";
				}				
				else if ($tradein_buyer == 3)
				{
					$where .= " AND tv.`fk_user` = 374 ";
				}		
			}
			else
			{
				$where .= "";
			}
		}		
		
		if ($current_status <> "") { $where .= " AND fa.`status` = '".$this->db->escape_str($current_status)."' "; }
		if ($dealer_status <> "") { $where .= " AND fa.`dealer_status` = '".$this->db->escape_str($dealer_status)."' "; }
		if ($aftersales_status <> "") { $where .= " AND fa.`aftersales_status` = '".$this->db->escape_str($aftersales_status)."' "; }
		if ($admin_type==2 OR $admin_type==4 OR $admin_type==5)
		{
			if ($user_id <> "")
			{
				$where .= " AND fa.`fk_user` = '".$this->db->escape_str($user_id)."' ";
			}
		}
		else 
		{
			$where .= " AND fa.`fk_user` = ".$my_id;
		}

		if ($name <> "") { $where .= " AND fa.`lead_name` LIKE '%".$this->db->escape_str($name)."%' "; }
		if ($email <> "") { $where .= " AND fa.`lead_email` LIKE '%".$this->db->escape_str($email)."%' "; }
		if ($phone <> "") { $where .= " AND fa.`lead_phone` LIKE '%".$this->db->escape_str($phone)."%' "; }
		
		if ($state <> "") { $where .= " AND fa.`lead_state` = '".$this->db->escape_str($state)."' "; }
		if ($postcode <> "") { $where .= " AND fa.`lead_postcode` LIKE '%".$this->db->escape_str($postcode)."%' "; }
		if ($address <> "") { $where .= " AND fa.`lead_address` LIKE '%".$this->db->escape_str($address)."%' "; }

		if ($make <> "") { $where .= " AND fa.`lead_make` LIKE '%".$this->db->escape_str($make)."%' "; }
		if ($model <> "") { $where .= " AND fa.`lead_model` LIKE '%".$this->db->escape_str($model)."%' "; }
		if ($dealer_id <> "") { $where .= " AND d.`id_user` = '".$this->db->escape_str($dealer_id)."' "; }

		if ($status == 4) { $status_date_label = "order_date"; }
		else if ($status == 5) { $status_date_label = "approved_date"; }
		else if ($status == 6) { $status_date_label = "delivery_date"; }
		else if ($status == 7) { $status_date_label = "settled_date"; }		
		else { $status_date_label = "order_date"; }
		if ($date_from <> "") { $where .= " AND DATE(fa.`".$status_date_label."`) >= DATE('".$this->db->escape_str($date_from)."') "; }
		if ($date_to <> "") { $where .= " AND DATE(fa.`".$status_date_label."`) <= DATE('".$this->db->escape_str($date_to)."') "; }

		$order = "";
		if ($sort_field == "") { $sort_field = "lead_id"; }
		if ($sort_type == "") { $sort_type = "DESC"; }
		$order .= " ORDER BY `".$this->db->escape_str($sort_field)."` ".$this->db->escape_str($sort_type)."";

		$date_filter_by = isset($params['date_filter_by']) ? $params['date_filter_by'] : "";

		$filter_column = "";

		if( isset($params['filter_column']) )
		{
			if($params['filter_column'] != "")
				$filter_column = $params['filter_column'];
			else
				$filter_column = "created_at";
		}

		if($date_filter_by != "")
		{
			if($date_filter_by == 1)
				$where .= " AND ( DATE(`fa`.`{$filter_column}`) BETWEEN  '".date( "Y-m-d",strtotime('monday this week') )."' AND '".date( "Y-m-d",strtotime("sunday this week") )."' )";
			elseif($date_filter_by == 2)
				$where .= " AND ( DATE(`fa`.`{$filter_column}`) BETWEEN  '".date( "Y-m-d",strtotime('monday last week') )."' AND '".date( "Y-m-d",strtotime("sunday last week") )."' )";
			elseif($date_filter_by == 3)
				$where .= " AND ( DATE(`fa`.`{$filter_column}`) BETWEEN  '".date( "Y-m-d",strtotime('first day of this month') )."' AND '".date( "Y-m-d",strtotime("last day of this month") )."' )";
			elseif($date_filter_by == 4)
				$where .= " AND ( DATE(`fa`.`{$filter_column}`) BETWEEN  '".date( "Y-m-d",strtotime('first day of last month') )."' AND '".date( "Y-m-d",strtotime("last day of last month") )."' )";
			elseif($date_filter_by == 5)
				$where .= " AND DATE(`fa`.`{$filter_column}`) = '".date( "Y-m-d" )."'"; 
			elseif($date_filter_by == 6)
				$where .= " AND DATE(`fa`.`{$filter_column}`) = '".date( "Y-m-d",strtotime('yesterday') )."'"; 
			elseif($date_filter_by == 7)
			{
				if(isset($params['filter_date_from']))
					$filter_date_from = date('Y-m-d', strtotime($params['filter_date_from']));
				else
					$filter_date_from = date('Y-m-d');

				if(isset($params['filter_date_to']))
					$filter_date_to = date('Y-m-d', strtotime($params['filter_date_to']));
				else
					$filter_date_to = date('Y-m-d');

				$where .= " AND ( DATE(`fa`.`{$filter_column}`) BETWEEN '{$filter_date_from}' AND '{$filter_date_to}' ) ";
			}
			else
			{
				$where .= " ";
			}
		}
		
		$query = "
		SELECT
		fa.id_fq_account, fa.id_fq_account AS `lead_id`, qr.id_quote_request, qr.winner AS `winner_id`,
		CONCAT('QM', LPAD(fa.id_fq_account, 5, '0')) AS `cq_number`,
		CONCAT('PO', LPAD(fa.id_fq_account, 5, '0')) AS `po_number`,
		CONCAT('TID', LPAD(fa.id_fq_account, 5, '0')) AS `dealer_invoice_number`,
		CONCAT('TIC', LPAD(fa.id_fq_account, 5, '0')) AS `client_invoice_number`,
		fldd.*,
		fa.`status`,
		CASE (fa.status)
			WHEN 4 THEN 'Pending Auth'
			WHEN 5 THEN 'Approved by Admin'
			WHEN 6 THEN 'Delivered'
			WHEN 7 THEN 'Settled'
			WHEN 8 THEN 'Admin on Hold'
			WHEN 9 THEN 'Deal Cancelled'
		END `status_text`,
		
		fa.`accounts_status`,
		CASE (fa.`accounts_status`)
			WHEN 0 THEN 'Pending'
			WHEN 1 THEN 'Approved'
		END `accounts_status_text`,
		
		fa.`accounts_update_status`,			

		fa.`admin_status`,
		CASE (fa.`status`)
			WHEN 4 THEN 4
			WHEN 8 THEN 5
			WHEN 5 THEN 6
			WHEN 6 THEN 7
			WHEN 7 THEN 8
			WHEN 9 THEN 9
		END `status_order`,

		fa.`dealer_status`,
		CASE (fa.`dealer_status`)
			WHEN 0 THEN 'Pending'
			WHEN 1 THEN 'Approved'
			WHEN 2 THEN 'Delivered'
		END `dealer_status_text`,
		
		fa.`client_status`,
		CASE (fa.`client_status`)
			WHEN 0 THEN 'Pending Client Approval'
			WHEN 1 THEN 'Agreement Seen'
			WHEN 2 THEN 'Approved by Client'
			WHEN 3 THEN 'Awaiting Approval'
		END `client_status_text`,			

		d.name AS `dealer`,
		
		
		
		IF (fa.`finance` = 1, 'Yes', 'No') AS `finance`,

		fa.lead_name, fa.lead_email, fa.lead_phone, fa.lead_mobile, fa.lead_state, fa.lead_postcode,
		m.name AS `make`, f.name AS `model`, v.name as `variant`,
		
		fa.details, fa.admin_details, fa.admin_to_qs_details,
		
		fa.created_at, fa.last_updated,
		DATE(fa.order_date) AS `order_date`,
		IF(DATE(fa.approved_date) = '0000-00-00', '', DATE(fa.approved_date)) AS `approved_date`,
		IF(DATE(fa.delivery_date) = '0000-00-00', '', DATE(fa.delivery_date)) AS `delivery_date`,
		IF(DATE(fa.settled_date) = '0000-00-00', '', DATE(fa.settled_date)) AS `settled_date`,

		fa.wholesaler, fa.wholesaler_value, fa.admin_note, fa.rego,
		fa.tradein_value, fa.tradein_given, fa.tradein_payout,
		fa.balcqo_client, fa.sales_price, fa.cpp,
		fa.gross_subtractor, fa.gross_subtractor_lower,
		fa.other_costs_amount, fa.other_revenue_amount,

		(SELECT SUM(amount) FROM payments WHERE fk_lead = `lead_id` AND fk_payment_type = 2 AND deprecated <> 1) AS `deposits_total`,
		(SELECT SUM(amount) FROM payments WHERE fk_lead = `lead_id` AND fk_payment_type = 7 AND deprecated <> 1) AS `refunds_total`,

		a.name AS `quote_specialist`, 
		
		q.total as `winning_price`, 
		q.fk_user AS `dealer_id`,
		q.dealer_tradein_value, 
		q.dealer_tradein_value AS `dtv`, 
		q.dealer_tradein_payout AS `dtp`, 
		q.dealer_client_refund AS `dcr`,		
		q.dealer_changeover AS `dealer_changeover_column`,
		(SELECT `winning_price` - `dtv` + `dtp` + `dcr`) AS `dealer_changeover`,
		
		(fa.sales_price - fa.tradein_given + fa.tradein_payout) AS `changeover`,

		tv.`fk_user` AS `tradein_buyer`,
		
		IF ((tv.`fk_user` = 0 OR tv.`fk_user` IS NULL), 'N/A',
			IF (tv.`fk_user` = 282, 'Dealer', IF(tv.`fk_user` = 374, 'Quote Me', 'Wholesaler'))
		) AS `tradein_buyer_user_type`,

		".$this->commissionable_gross_query." AS `commissionable_gross`,
		".$this->revenue_query." AS `revenue`,
		".$this->balcqo_query." AS `balcqo`,
		
		(
			SELECT COALESCE(SUM(pt.`sign` * p.`amount`), 0)
			FROM payments p
			JOIN payment_types pt ON p.`fk_payment_type` = pt.`id_payment_type`
			WHERE p.`fk_lead` = `lead_id`
			AND p.`deprecated` <> 1
		) AS `total_payments`,
		
		(SELECT `balcqo` - `total_payments`) AS `remaining_balance`,
		
		(SELECT IF(`revenue` < (`deposits_total` - `refunds_total`), 0, (`revenue` - (`deposits_total` - `refunds_total`))))
		AS `dealer_balance`,

		GROUP_CONCAT(ti.id_tradein) AS `tradein_ids`, GROUP_CONCAT(tidu.fk_lead_doc) AS `tradein_document_type_ids`
		
		FROM fq_accounts_new fa
		LEFT JOIN fq_lead_dealer_data fldd ON fldd.fq_lead_id = fa.id_fq_account
		LEFT JOIN users a ON fa.fk_user = a.id_user
		LEFT JOIN quote_requests qr ON fa.id_fq_account = qr.fk_lead
		LEFT JOIN makes m ON qr.make = m.id_make
		LEFT JOIN families f ON qr.model = f.id_family
		LEFT JOIN vehicles v ON qr.variant = v.id_vehicle		
		LEFT JOIN quotes q ON qr.winner = q.id_quote
		LEFT JOIN users d ON q.fk_user = d.id_user
		LEFT JOIN tradeins ti ON fa.id_fq_account = ti.fk_lead
		LEFT JOIN trade_valuations tv ON tv.id_trade_valuation = ti.fk_trade_valuation
		LEFT JOIN tradein_documents_upload tidu ON ti.id_tradein = tidu.fk_lead
		WHERE fa.`status` IN (4, 5, 6, 7, 8, 9) ".$where." 
		GROUP BY fa.id_fq_account ".$order;
		// "LIMIT ".$start.", ".$limit;
		// echo "<pre>";
		// print_r($query);
		// exit;
		$sql = $this->db->query($query);
		return $sql->result();
	}

	public function get_deals_count ($params, $my_id, $admin_type) // ADMIN
	{
		$cq_number = isset($params['cq_number']) ? $params['cq_number'] : '';
		$finance = isset($params['finance']) ? $params['finance'] : '';
		//$interstate = isset($params['interstate']) ? $params['interstate'] : '';
		$tradein = isset($params['tradein']) ? $params['tradein'] : '';
		$tradein_buyer = isset($params['tradein_buyer']) ? $params['tradein_buyer'] : '';		
		
		$current_status = isset($params['current_status']) ? $params['current_status'] : '';
		$dealer_status = isset($params['dealer_status']) ? $params['dealer_status'] : '';
		$aftersales_status = isset($params['aftersales_status']) ? $params['aftersales_status'] : '';
		$user_id = isset($params['user_id']) ? $params['user_id'] : ''; 
		
		$name = isset($params['name']) ? $params['name'] : '';
		$email = isset($params['email']) ? $params['email'] : '';
		$phone = isset($params['phone']) ? $params['phone'] : '';

		$state = isset($params['state']) ? $params['state'] : '';
		$postcode = isset($params['postcode']) ? $params['postcode'] : '';
		$address = isset($params['address']) ? $params['address'] : '';
		
		$make = isset($params['make']) ? $params['make'] : '';
		$model = isset($params['model']) ? $params['model'] : '';
		$dealer_id = isset($params['dealer_id']) ? $params['dealer_id'] : ''; 		
		
		$status = isset($params['status']) ? $params['status'] : '';
		$date_from = isset($params['date_from']) ? $params['date_from'] : '';
		$date_to = isset($params['date_to']) ? $params['date_to'] : '';

		$where = "";
		if ($cq_number <> "")
		{
			$where .= " 
			AND (fa.`id_fq_account` = '".$this->db->escape_str($params['cq_number'])."' 
			OR CONCAT('QM', LPAD(fa.`id_fq_account`, 5, '0')) = '".$this->db->escape_str($params['cq_number'])."') ";
		}
		
		if ($finance <> "")
		{
			$where .= " AND fa.`finance` = '".$this->db->escape_str($params['finance'])."'";
		}
		
		// if ($interstate == 1)
		// {
			// $where .= " AND fa.`lead_state` <> d.`state` ";
		// }		

		if ($tradein <> "")
		{
			if ($tradein == 0)
			{
				$where .= " AND ti.`id_tradein` = 0 ";
			}
			else if ($tradein == 1)
			{
				$where .= " AND ti.`id_tradein` <> 0 ";
				if ($tradein_buyer == 1)
				{
					$where .= " AND tv.`fk_user` = 282 ";
				}
				else if ($tradein_buyer == 2)
				{
					$where .= " AND tv.`fk_user` NOT IN (282, 374) ";
				}				
				else if ($tradein_buyer == 3)
				{
					$where .= " AND tv.`fk_user` = 374 ";
				}		
			}
			else
			{
				$where .= "";
			}
		}		
		
		if ($current_status <> "") { $where .= " AND fa.`status` = '".$this->db->escape_str($current_status)."' "; }
		if ($dealer_status <> "") { $where .= " AND fa.`dealer_status` = '".$this->db->escape_str($dealer_status)."' "; }
		if ($aftersales_status <> "") { $where .= " AND fa.`aftersales_status` = '".$this->db->escape_str($aftersales_status)."' "; }
		if ($admin_type==2 OR $admin_type==4 OR $admin_type==5)
		{
			if ($user_id <> "")
			{
				$where .= " AND fa.`fk_user` = '".$this->db->escape_str($user_id)."' ";
			}
		}
		else
		{
			$where .= " AND fa.`fk_user` = ".$my_id;
		}

		if ($name <> "") { $where .= " AND fa.`lead_name` LIKE '%".$this->db->escape_str($name)."%' "; }
		if ($email <> "") { $where .= " AND fa.`lead_email` LIKE '%".$this->db->escape_str($email)."%' "; }
		if ($phone <> "") { $where .= " AND fa.`lead_phone` LIKE '%".$this->db->escape_str($phone)."%' "; }
		
		if ($state <> "") { $where .= " AND fa.`lead_state` = '".$this->db->escape_str($state)."' "; }
		if ($postcode <> "") { $where .= " AND fa.`lead_postcode` LIKE '%".$this->db->escape_str($postcode)."%' "; }
		if ($address <> "") { $where .= " AND fa.`lead_address` LIKE '%".$this->db->escape_str($address)."%' "; }

		if ($make <> "") { $where .= " AND fa.`lead_make` LIKE '%".$this->db->escape_str($make)."%' "; }
		if ($model <> "") { $where .= " AND fa.`lead_model` LIKE '%".$this->db->escape_str($model)."%' "; }
		if ($dealer_id <> "") { $where .= " AND d.`id_user` = '".$this->db->escape_str($dealer_id)."' "; }

		if ($status == 4) { $status_date_label = "order_date"; }
		else if ($status == 5) { $status_date_label = "approved_date"; }
		else if ($status == 6) { $status_date_label = "delivery_date"; }
		else if ($status == 7) { $status_date_label = "settled_date"; }		
		else { $status_date_label = "created_at"; }
		if ($date_from <> "") { $where .= " AND DATE(fa.`".$status_date_label."`) >= DATE('".$this->db->escape_str($date_from)."') "; }
		if ($date_to <> "") { $where .= " AND DATE(fa.`".$status_date_label."`) <= DATE('".$this->db->escape_str($date_to)."') "; }

		$date_filter_by = isset($params['date_filter_by']) ? $params['date_filter_by'] : "";

		$filter_column = "";

		if( isset($params['filter_column']) )
		{
			if($params['filter_column'] != "")
				$filter_column = $params['filter_column'];
			else
				$filter_column = "created_at";
		}

		if($date_filter_by != "")
		{
			if($date_filter_by == 1)
				$where .= " AND ( DATE(`fa`.`{$filter_column}`) BETWEEN  '".date( "Y-m-d",strtotime('monday this week') )."' AND '".date( "Y-m-d",strtotime("sunday this week") )."' )";
			elseif($date_filter_by == 2)
				$where .= " AND ( DATE(`fa`.`{$filter_column}`) BETWEEN  '".date( "Y-m-d",strtotime('monday last week') )."' AND '".date( "Y-m-d",strtotime("sunday last week") )."' )";
			elseif($date_filter_by == 3)
				$where .= " AND ( DATE(`fa`.`{$filter_column}`) BETWEEN  '".date( "Y-m-d",strtotime('first day of this month') )."' AND '".date( "Y-m-d",strtotime("last day of this month") )."' )";
			elseif($date_filter_by == 4)
				$where .= " AND ( DATE(`fa`.`{$filter_column}`) BETWEEN  '".date( "Y-m-d",strtotime('first day of last month') )."' AND '".date( "Y-m-d",strtotime("last day of last month") )."' )";
			elseif($date_filter_by == 5)
			{
				if(isset($params['filter_date_from']))
					$filter_date_from = date('Y-m-d', strtotime($params['filter_date_from']));
				else
					$filter_date_from = date('Y-m-d');

				if(isset($params['filter_date_to']))
					$filter_date_to = date('Y-m-d', strtotime($params['filter_date_to']));
				else
					$filter_date_to = date('Y-m-d');

				$where .= " AND ( DATE(`fa`.`{$filter_column}`) BETWEEN '{$filter_date_from}' AND '{$filter_date_to}' ) ";
			}
			else
			{
				$where .= " ";
			}
		}
	
		$query = "
		SELECT COUNT(1) AS `cnt` 
		FROM fq_accounts_new fa 
		LEFT JOIN users a ON fa.fk_user = a.id_user
		LEFT JOIN quote_requests qr ON fa.id_fq_account = qr.fk_lead
		LEFT JOIN quotes q ON qr.winner = q.id_quote
		LEFT JOIN users d ON q.fk_user = d.id_user
		LEFT JOIN tradeins ti ON fa.id_fq_account = ti.fk_lead
		LEFT JOIN trade_valuations tv ON tv.id_trade_valuation = ti.fk_trade_valuation
		LEFT JOIN tradein_documents_upload tidu ON ti.id_tradein = tidu.fk_lead		
		WHERE fa.status IN (4, 5, 6, 7, 8, 9) " . $where . " ";
		return $this->db->query($query)->row_array();
	}

	public function get_aftersales_deals ($status)
	{
		$query = "";
		return $this->db->query($query)->result_array();
	}
	
	public function get_deal_manual_invoice_parameters ($lead_id)
	{
		$query = "
		SELECT 
		id_lead,
		CONCAT('QM', LPAD(id_lead, 5, '0')) AS `cq_number`,
		i_issued_date, i_payment_due_date,
		i_list_price, i_options, i_accessories, i_dealer_delivery, i_subtotal_1,
		i_discount, i_subtotal_2,
		i_gst, i_lct, i_stamp_duty, i_registration, i_ctp, i_total_price,
		i_deposit, i_tradein, i_payout, i_refunds, i_balance, i_vin, i_engine, 
		i_registration_plate, i_registration_expiry, i_kms, i_demo
		FROM leads
		WHERE id_lead = '".$this->db->escape_str($lead_id)."'
		LIMIT 1";
		return $this->db->query($query)->row_array();
	}

	public function update_manual_invoice_details ($lead_id, $input_arr)
	{
		if ($input_arr['i_list_price']=="") { $input_arr['i_list_price'] = 0; }
		if ($input_arr['i_options']=="") { $input_arr['i_options'] = 0; }
		if ($input_arr['i_accessories']=="") { $input_arr['i_accessories'] = 0; }
		if ($input_arr['i_dealer_delivery']=="") { $input_arr['i_dealer_delivery'] = 0; }
		if ($input_arr['i_subtotal_1']=="") { $input_arr['i_subtotal_1'] = 0; }
		if ($input_arr['i_discount']=="") { $input_arr['i_discount'] = 0; }
		if ($input_arr['i_subtotal_2']=="") { $input_arr['i_subtotal_2'] = 0; }
		if ($input_arr['i_gst']=="") { $input_arr['i_gst'] = 0; }
		if ($input_arr['i_lct']=="") { $input_arr['i_lct'] = 0; }
		if ($input_arr['i_stamp_duty']=="") { $input_arr['i_stamp_duty'] = 0; }
		if ($input_arr['i_registration']=="") { $input_arr['i_registration'] = 0; }
		if ($input_arr['i_ctp']=="") { $input_arr['i_ctp'] = 0; }
		if ($input_arr['i_total_price']=="") { $input_arr['i_total_price'] = 0; }
		if ($input_arr['i_deposit']=="") { $input_arr['i_deposit'] = 0; }
		if ($input_arr['i_tradein']=="") { $input_arr['i_tradein'] = 0; }
		if ($input_arr['i_payout']=="") { $input_arr['i_payout'] = 0; }
		if ($input_arr['i_refunds']=="") { $input_arr['i_refunds'] = 0; }
		if ($input_arr['i_balance']=="") { $input_arr['i_balance'] = 0; }
		if ($input_arr['i_vin']=="") { $input_arr['i_vin'] = ""; }
		if ($input_arr['i_engine']=="") { $input_arr['i_engine'] = ""; }
		if ($input_arr['i_registration_plate']=="") { $input_arr['i_registration_plate'] = ""; }
		if ($input_arr['i_registration_expiry']=="") { $input_arr['i_registration_expiry'] = ""; }
		if ($input_arr['i_kms']=="") { $input_arr['i_kms'] = ""; }

		$query = "
		UPDATE `leads` SET 
		i_issued_date = '".$this->db->escape_str($input_arr['i_issued_date'])."',
		i_payment_due_date = '".$this->db->escape_str($input_arr['i_payment_due_date'])."',
		i_list_price = '".$this->db->escape_str($input_arr['i_list_price'])."',
		i_options = '".$this->db->escape_str($input_arr['i_options'])."',
		i_accessories = '".$this->db->escape_str($input_arr['i_accessories'])."',
		i_dealer_delivery = '".$this->db->escape_str($input_arr['i_dealer_delivery'])."',
		i_subtotal_1 = '".$this->db->escape_str($input_arr['i_subtotal_1'])."',
		i_discount = '".$this->db->escape_str($input_arr['i_discount'])."',
		i_subtotal_2 = '".$this->db->escape_str($input_arr['i_subtotal_2'])."',
		i_gst = '".$this->db->escape_str($input_arr['i_gst'])."', 
		i_lct = '".$this->db->escape_str($input_arr['i_lct'])."',
		i_stamp_duty = '".$this->db->escape_str($input_arr['i_stamp_duty'])."',
		i_registration = '".$this->db->escape_str($input_arr['i_registration'])."',
		i_ctp = '".$this->db->escape_str($input_arr['i_ctp'])."',
		i_total_price = '".$this->db->escape_str($input_arr['i_total_price'])."',
		i_deposit = '".$this->db->escape_str($input_arr['i_deposit'])."',
		i_tradein = '".$this->db->escape_str($input_arr['i_tradein'])."',
		i_payout = '".$this->db->escape_str($input_arr['i_payout'])."',
		i_refunds = '".$this->db->escape_str($input_arr['i_refunds'])."',
		i_balance = '".$this->db->escape_str($input_arr['i_balance'])."',
		i_vin = '".$this->db->escape_str($input_arr['i_vin'])."',
		i_engine = '".$this->db->escape_str($input_arr['i_engine'])."',
		i_registration_plate = '".$this->db->escape_str($input_arr['i_registration_plate'])."',
		i_registration_expiry = '".$this->db->escape_str($input_arr['i_registration_expiry'])."',
		i_kms = '".$this->db->escape_str($input_arr['i_kms'])."',
		i_demo = '".$this->db->escape_str($input_arr['i_demo'])."'
		WHERE `id_lead` = ".$lead_id;
		$sql = $this->db->query($query);
	}	

	public function get_deal_invoice_parameters ($lead_id)
	{
		$query = "
		SELECT 
		l.id_lead, l.id_lead AS `lead_id`, q.id_quote AS `quote_id`,
		CONCAT('QM', LPAD(l.id_lead, 5, '0')) AS `cq_number`,
		l.state,
		l.cpp, q.retail_price AS `list_price`, q.total AS `dqp`,
		q.registration AS `registration`, q.ctp AS `ctp`,
		l.tradein_value, l.tradein_given, l.tradein_payout, 

		l.invoice_dealer_license AS `dealer_license`,
		DATE(l.invoice_issued_date) AS `issued_date`,
		DATE(l.invoice_payment_due_date) AS `payment_due_date`,

		l.invoice_discount AS `discount`, 
		IF (l.invoice_dealer_delivery = 0, q.predelivery, l.invoice_dealer_delivery) AS `dealer_delivery`,
		l.invoice_answer_based_on_state AS `answer_based_on_state`,
		l.invoice_fuel_efficient_flag AS `fuel_efficient_flag`,

		(SELECT COALESCE(SUM(price), 0.00) FROM quote_accessories WHERE fk_quote = `quote_id` AND deprecated <> 1) AS `accessories_total`,
		(SELECT COALESCE(SUM(price), 0.00) FROM quote_options WHERE fk_quote = `quote_id` AND deprecated <> 1) AS `options_total`,		

		(SELECT COALESCE(SUM(amount), 0.00) FROM payments WHERE fk_payment_type = 2 AND fk_lead = `lead_id` AND deprecated <> 1) AS `deposits_total`,
		(SELECT COALESCE(SUM(amount), 0.00) FROM payments WHERE fk_payment_type = 7 AND fk_lead = `lead_id` AND deprecated <> 1) AS `refunds_total`
		FROM leads l
		JOIN quote_requests qr ON l.id_lead = qr.fk_lead
		JOIN quotes q ON qr.winner = q.id_quote
		WHERE 1 AND l.deprecated <> 1 AND qr.deprecated <> 1 AND q.deprecated <> 1
		AND l.id_lead = '".$this->db->escape_str($lead_id)."'
		GROUP BY l.id_lead LIMIT 1";
		return $this->db->query($query)->row_array();		
	}

	public function update_invoice_details ($lead_id, $dealer_license, $issued_date, $payment_due_date, $dealer_delivery, $discount, $fuel_efficient_flag, $answer_based_on_state)
	{
		$query = "
		UPDATE `leads` SET 
		invoice_dealer_license = '".$this->db->escape_str($dealer_license)."',
		invoice_issued_date = '".$this->db->escape_str($issued_date)."',
		invoice_payment_due_date = '".$this->db->escape_str($payment_due_date)."',
		invoice_dealer_delivery = '".$this->db->escape_str($dealer_delivery)."',
		invoice_discount = '".$this->db->escape_str($discount)."',
		invoice_fuel_efficient_flag = '".$this->db->escape_str($fuel_efficient_flag)."',
		invoice_answer_based_on_state = '".$this->db->escape_str($answer_based_on_state)."'
		WHERE `id_lead` = ".$lead_id;
		$sql = $this->db->query($query);
	}
	
	public function add_lead ($input_arr) // ADMIN
	{
	//	echo json_encode($input_arr); die();
		$now = date("Y-m-d H:i:s");
		$query = "
		INSERT INTO leads (source, fk_user, status, name, email, phone, mobile, state, postcode, make, model, allocated_date, created_at) VALUES
		(
		'Quote Specialist', 
		".$input_arr['user_id'].",
		1,
		'".$this->db->escape_str($input_arr['name'])."',
		'".$this->db->escape_str($input_arr['email'])."',
		'".$this->db->escape_str($input_arr['phone'])."',
		'".$this->db->escape_str($input_arr['mobile'])."',
		'".$this->db->escape_str($input_arr['state'])."',
		'".$this->db->escape_str($input_arr['postcode'])."',
		'".$this->db->escape_str($input_arr['make'])."',
		'".$this->db->escape_str($input_arr['family'])."',
		'".$now."', '".$now."')";
		$sql = $this->db->query($query);
	}
	public function add_fq_record ($input_arr) // ADMIN
	{
		//echo json_encode($input_arr); die();
		$now = date("Y-m-d H:i:s");
		$query = "
		INSERT INTO fq_accounts_new (source, fk_user, status, lead_name, lead_email, lead_phone, lead_mobile, lead_state, lead_postcode, lead_make, lead_model, allocated_date, created_at) VALUES
		(
		'Quote Specialist', 
		".$input_arr['user_id'].",
		1,
		'".$this->db->escape_str($input_arr['name'])."',
		'".$this->db->escape_str($input_arr['email'])."',
		'".$this->db->escape_str($input_arr['phone'])."',
		'".$this->db->escape_str($input_arr['mobile'])."',
		'".$this->db->escape_str($input_arr['state'])."',
		'".$this->db->escape_str($input_arr['postcode'])."',
		'".$this->db->escape_str($input_arr['make'])."',
		'".$this->db->escape_str($input_arr['family'])."',
		'".$now."', '".$now."')";
		$sql = $this->db->query($query);
	}	
	
	public function delete_lead ($lead_id) // ADMIN
	{
		$query = "UPDATE `leads` SET `deprecated` = 1 WHERE `id_lead` = ".$lead_id;
		$sql = $this->db->query($query);
	}

	public function allocate_lead ($lead_id, $user_id) // ADMIN
	{
		$query = "UPDATE `leads` SET `fk_user` = ".$user_id." WHERE `id_lead` = ".$lead_id;
		$sql = $this->db->query($query);		
	}

	public function update_lead_status ($lead_id, $status) // ADMIN
	{
		$query = "UPDATE `fq_accounts_new` SET `status` = ".$status." WHERE `id_fq_account` = ".$lead_id;
		$sql = $this->db->query($query);
	}

	public function update_lead_admin_status ($lead_id, $status) // ADMIN
	{
		$query = "UPDATE `leads` SET `admin_status` = ".$status." WHERE `id_lead` = ".$lead_id;
		$sql = $this->db->query($query);
	}	

	public function update_lead_sale_status ($lead_ids, $status) // ADMIN
	{
		$query = "UPDATE `leads` SET `sale_status` = ".$status." WHERE `id_lead` IN (".str_replace('on', '', str_replace(',on', '', $lead_ids)).")";
		return $this->db->query($query);
	}

	public function update_lead_price ($lead_ids, $lead_price)
	{
		$query = "
		UPDATE `leads` SET `lead_price` = '".$this->db->escape_str($lead_price)."'
		WHERE `id_lead` IN (".str_replace('on', '', str_replace(',on', '', $lead_ids)).")";
		return $this->db->query($query);
	}
	
	public function update_lead_quote_specialists ($reallocation_ids)
	{
		$query = "
		UPDATE `leads` l JOIN lead_reallocations r ON l.id_lead = r.fk_lead SET l.`fk_user` = r.`fk_user_to`
		WHERE r.id_lead_reallocation IN (".$reallocation_ids.")";
		return $this->db->query($query);	
	}

	public function allocate_leads ($lead_ids, $user_id)
	{
		$query = "UPDATE `leads` SET `fk_user` = ".$user_id." WHERE `id_lead` IN (".str_replace('on', '', str_replace(',on', '', $lead_ids)).")";
		return $this->db->query($query);
	}
	
	public function delete_leads ($lead_ids)
	{
		$query = "UPDATE `leads` SET `deprecated` = 1 WHERE `id_lead` IN (".str_replace('on', '', str_replace(',on', '', $lead_ids)).")";
		return $this->db->query($query);
	}		
	
	public function update_leads_status ($lead_ids, $status)
	{
		$query = "
		UPDATE `leads` SET `status` = '".$status."' WHERE `id_lead` IN (".str_replace('on', '', str_replace(',on', '', $lead_ids)).") AND `status` < ".$status."";
		return $this->db->query($query);
	}

	public function update_lead_date ($lead_id = 1, $date, $date_type) // ADMIN
	{
		$where = "";
		if ($date_type != "delivery_date") 
		{
			$where = " AND (`".$date_type."` = '0000-00-00 00:00:00' OR `".$date_type."` = '' OR `".$date_type."` IS NULL)";
		}

		$query = "UPDATE `leads` SET `".$date_type."` = '".$date."' WHERE `id_lead` = ".$lead_id." ".$where;
		return $this->db->query($query);
	}
	
	
	public function get_clients ($start, $limit) // ADMIN
	{
		$query = "	
		SELECT email, name, mobile, state
		FROM leads
		WHERE email LIKE '%@%'
		GROUP BY email ORDER BY email ASC LIMIT ".$start.", ".$limit;
		$sql = $this->db->query($query);
		return $sql->result();
	}
	
	public function get_clients_count () // ADMIN
	{
		$query = "SELECT COUNT(DISTINCT email) AS `cnt` FROM leads WHERE email LIKE '%@%'";
		return $this->db->query($query)->row_array();
	}	
	
	public function update_f_lead_status ($lead_ids, $status) // ADMIN
	{
		$query = "UPDATE `leads` SET `finance_status` = ".$status." WHERE `id_lead` IN (".str_replace('on', '', str_replace(',on', '', $lead_ids)).")";
		$sql = $this->db->query($query);
	}
	
	public function update_f_lead_date ($lead_id, $date) // ADMIN
	{
		$query = "UPDATE `leads` SET `finance_assignment_date` = '".$date." 00:00:00' WHERE `id_lead` = ".$lead_id;
		$sql = $this->db->query($query);
	}	
	
	public function update_f_lead_details ($lead_id, $details) // ADMIN
	{
		$query = "UPDATE `leads` SET `finance_details` = '".$this->db->escape_str($details)."' WHERE `id_lead` = ".$lead_id;
		$sql = $this->db->query($query);
	}
	
	public function get_leads_summary () // Leads Summary (To be revised)
	{
		$query = "
		SELECT id_user as `qs_id`, name, 
			(SELECT COUNT(1) FROM leads WHERE fk_user = `qs_id` AND status >= 1) as `allocated`,
			(SELECT COUNT(1) FROM leads WHERE fk_user = `qs_id` AND status >= 2) as `total_attempted`,
			(SELECT COUNT(1) FROM leads WHERE fk_user = `qs_id` AND status = 2) as `attempted_rescheduled`,
			(SELECT COUNT(1) FROM leads WHERE fk_user = `qs_id` AND status = 3) as `tendering`,
			(SELECT COUNT(1) FROM leads WHERE fk_user = `qs_id` AND status = 4) as `converted_to_deal`,
			(SELECT COUNT(1) FROM leads WHERE fk_user = `qs_id` AND status = 5) as `delivery_pending`,
			(SELECT COUNT(1) FROM leads WHERE fk_user = `qs_id` AND status = 6) as `delivered`,
			(SELECT COUNT(1) FROM leads WHERE fk_user = `qs_id` AND status = 7) as `settled`,
			(SELECT COUNT(1) FROM leads WHERE fk_user = `qs_id` AND status = 8) as `onhold`,
			(SELECT COUNT(1) FROM leads WHERE fk_user = `qs_id` AND status = 9) as `cancelled`,
			(SELECT COUNT(1) FROM leads WHERE fk_user = `qs_id` AND status = 100) as `deleted`
		FROM users WHERE deprecated <> 1 AND type = 2";
		$sql = $this->db->query($query);
		return $sql->result();
	}

	public function get_lead_cheapest_prices () // FOR Email of Dead Leads
	{
		$now = date("Y-m-d H:i:s");
		$query = "
		SELECT 
		l.id_lead,
		l.id_lead AS `lead_id`,

		m.id_make as `l_make_id`, 
		f.id_family as `l_family_id`,
		l.make AS `l_make`, 
		l.model AS `l_model`, 

		qr_m.id_make as `qr_make_id`,
		qr_f.id_family as `qr_family_id`,
		qr_v.id_vehicle as `qr_vehicle_id`,
		qr_m.name as `qr_make`,
		qr_f.name as `qr_family`,
		qr_v.name as `qr_vehicle`,

		(SELECT MIN(total)
			FROM quotes q
			JOIN quote_requests qr ON q.fk_quote_request = qr.id_quote_request
			WHERE qr.variant = `qr_vehicle_id` AND qr.variant <> 0 AND q.deprecated <> 1
		) AS `cq_cheapest_variant_price`,

		(SELECT MIN(total)
			FROM quotes q
			JOIN quote_requests qr ON q.fk_quote_request = qr.id_quote_request
			WHERE qr.model = `l_family_id` AND qr.model <> 0 AND q.deprecated <> 1
		) AS `cq_cheapest_model_price`,

		(SELECT `newprice` FROM vehicles WHERE fk_family = `l_family_id` ORDER BY `year` DESC, `newprice` ASC LIMIT 1) AS `rb_cheapest_model_price`,
		(SELECT IF(`rb_cheapest_model_price` > 50000, `rb_cheapest_model_price` + 2000, `rb_cheapest_model_price` + 1000)) AS `rb_final_model_price`,

		(SELECT `newprice` FROM vehicles WHERE id_vehicle = `qr_vehicle_id` ORDER BY `year` DESC, `newprice` ASC LIMIT 1) AS `rb_cheapest_variant_price`,
		(SELECT IF(`rb_cheapest_variant_price` > 50000, `rb_cheapest_variant_price` + 2000, `rb_cheapest_variant_price` + 1000)) AS `rb_final_variant_price`,

		l.name, l.email, l.state,
		u.name as `qs_name`, u.username as `qs_email`,
		l.deleted_date
		FROM leads l
		JOIN users u ON l.fk_user = u.id_user

		LEFT JOIN quote_requests qr ON l.id_lead = qr.fk_lead
		LEFT JOIN makes qr_m ON qr.make = qr_m.id_make
		LEFT JOIN families qr_f ON qr.model = qr_f.id_family
		LEFT JOIN vehicles qr_v ON qr.variant = qr_v.id_vehicle

		LEFT JOIN makes m ON l.make = m.name
		LEFT JOIN families f ON l.model = f.name 

		WHERE 1
		AND f.fk_make = m.id_make	
		AND l.status = 100
		AND l.deleted_date > ('".$now."' - INTERVAL 20 DAY)
		AND l.dead_email_date = '0000-00-00 00:00:00'
		GROUP BY l.id_lead";
		$sql = $this->db->query($query);
		return $sql->result();
	}

	public function get_lead_balcqo_details ($lead_id)
	{
		$query = "
		SELECT 
		".$this->revenue_query." AS `revenue`,
		".$this->balcqo_query." AS `balcqo`
		FROM leads l
		JOIN quote_requests qr ON l.`id_lead` = qr.`fk_lead`
		JOIN quotes q ON qr.`winner` = q.`id_quote`
		LEFT JOIN tradeins ti ON l.id_lead = ti.fk_lead
		LEFT JOIN trade_valuations tv ON tv.id_trade_valuation = ti.fk_trade_valuation
		WHERE id_lead = '".$this->db->escape_str($lead_id)."'";
		return $this->db->query($query)->row_array();
	}

	public function get_accessory_payments ($lead_id)
	{
		$query = "
		SELECT 
		p.`id_payment`, pt.`code` as `code`, (pt.`sign` * p.`amount`) as `amount`, p.`reference_number`, 
		p.`created_at` as created_at, u.`name` as `name`, p.`payment_date` as `payment_date`, 
		p.refund_status as `refund_status`, p.refund_date as `refund_date`, p.`admin_fee` as `admin_fee`, 
		p.`show_status` as `show_status`
		FROM payments p JOIN payment_types pt
		ON p.`fk_payment_type` = pt.`id_payment_type`
		JOIN users u ON p.`fk_user` = u.`id_user`
		WHERE p.`fk_lead` = '".$lead_id."' AND p.`deprecated` <> 1 
		AND p.fk_payment_type = 17";
		return $this->db->query($query)->result_array();
	}

	public function get_deposit ($lead_id, $payment_type = 2)
	{
		$query = "
		SELECT p.`id_payment`, pt.`code` as `code`, (pt.`sign` * p.`amount`) as `amount`, p.`reference_number`, p.`created_at` as created_at, u.`name` as `name`, p.`payment_date` as `payment_date`, p.refund_status as `refund_status`, p.refund_date as `refund_date`, p.`admin_fee` as `admin_fee`, p.`show_status` as `show_status`, p.`merchant_cost` as `merchant_cost`, if(p.`status`=1,'Verified', 'Unverified') as `status`, p.`status` as `status_id`
		FROM payments p JOIN payment_types pt
		ON p.`fk_payment_type` = pt.`id_payment_type`
		JOIN users u ON p.`fk_user` = u.`id_user`
		WHERE p.`fk_lead` = '".$lead_id."' AND p.`deprecated` <> 1 
		AND p.fk_payment_type = {$payment_type} 
		AND p.refund_status = 0 
		AND p.show_status = 1";
		$sql = $this->db->query($query);
		return $sql->result();
	}

	public function insert_deposit ($input_arr)
	{
		$fk_transaction = 0;
		$fk_transaction = isset($input_arr['fk_transaction']) ? $input_arr['fk_transaction'] : 0;
		$admin_fee = isset($input_arr['admin_fee']) ? $input_arr['admin_fee'] : 0.00;
		$now = date("Y-m-d H:i:s");
		if($fk_transaction == 0)
		{
			$query = "
			INSERT INTO `payments` (fk_payment_type, fk_lead, fk_user, amount, reference_number, deprecated, created_at, payment_date)
			VALUES (
				'2', 
				'".$this->db->escape_str($input_arr['lead_id'])."', 
				'".$this->db->escape_str($input_arr['user_id'])."',
				'".$this->db->escape_str($input_arr['amount'])."',
				'".$this->db->escape_str($input_arr['reference_number'])."',
				0,
				'".$now."',
				'".$this->db->escape_str($input_arr['payment_date'])."')
			";
		}
		else
		{
			$query = "
			INSERT INTO `payments` (fk_payment_type, fk_lead, fk_user, amount, reference_number, deprecated, created_at, payment_date, fk_transaction, admin_fee)
			VALUES (
				'2', 
				'".$this->db->escape_str($input_arr['lead_id'])."', 
				'".$this->db->escape_str($input_arr['user_id'])."',
				'".$this->db->escape_str($input_arr['amount'])."',
				'".$this->db->escape_str($input_arr['reference_number'])."',
				0,
				'".$now."',
				'".$now."',
				'".$fk_transaction."',
				'".$admin_fee."'
				)
			";	
		}
		$sql = $this->db->query($query);
	}
	
	// FOR EMAILING //
	public function get_lead_for_email ($lead_id)
	{
		$query = "		
		SELECT
		CONCAT('QM', LPAD(l.id_lead, 5, '0')) AS `lead_cq_number`,
		CONCAT('PO', LPAD(l.id_lead, 5, '0')) AS `lead_po_number`,
		l.source AS `lead_source`,
		CASE (l.sale_status)
			WHEN 0 THEN ''
			WHEN 1 THEN 'For Sale'
			WHEN 2 THEN 'Sold'
		END `lead_sale_status`,
		l.`lead_price` AS `lead_sale_price`,
		l.make AS `lead_make`,
		l.model AS `lead_model`,
		q.total as `lead_dealer_price`,
		l.cpp AS `lead_changeover`,
		l.created_at AS `lead_submitted_date`,
		IF(DATE(l.order_date) = '0000-00-00', '', DATE(l.order_date)) AS `lead_order_date`,
		IF(DATE(l.delivery_date) = '0000-00-00', '', DATE(l.delivery_date)) AS `lead_delivery_date`,

		d.account_email as `account_email`,
		d.username AS `dealer_email`, 
		da.dealership_name AS `dealer_name`,
		d.name AS `dealer_manager_name`,
		SUBSTRING_INDEX(TRIM(d.name), ' ', 1) AS `dealer_manager_first_name`,
		d.abn AS `dealer_abn`,
		d.state AS `dealer_state`, 
		d.postcode AS `dealer_postcode`, 
		'' AS `dealer_suburb`,
		d.address AS `dealer_address`,
		d.phone AS `dealer_phone`,
		d.mobile AS `dealer_mobile`,
		d.deposit_show_status as `deposit_show_status`,

		l.email AS `client_email`,
		l.name AS `client_name`,
		SUBSTRING_INDEX(TRIM(l.name), ' ', 1) AS `client_first_name`,
		l.state AS `client_state`,
		l.postcode AS `client_postcode`,
		'' AS `client_suburb`,
		l.address AS `client_address`,
		l.phone AS `client_phone`,
		l.mobile AS `client_mobile`,

		temp_qs.username AS `temp_qs_email`,
		temp_qs.name AS `temp_qs_name`,
		SUBSTRING_INDEX(TRIM(temp_qs.name), ' ', 1) AS `temp_qs_first_name`,
		temp_qs.abn AS `temp_qs_abn`,
		temp_qs.phone AS `temp_qs_phone`,
		temp_qs.mobile AS `temp_qs_mobile`,
		temp_qs.state AS `temp_qs_state`,
		temp_qs.postcode AS `temp_qs_postcode`,		

		qs.username AS `qs_email`,
		qs.name AS `qs_name`,
		SUBSTRING_INDEX(TRIM(qs.name), ' ', 1) AS `qs_first_name`,
		qs.abn AS `qs_abn`,
		qs.phone AS `qs_phone`,
		qs.mobile AS `qs_mobile`,
		qs.state AS `qs_state`,
		qs.postcode AS `qs_postcode`,
		'' AS `qs_suburb`,

		'' AS `fqs_email`,
		'' AS `fqs_name`,
		'' AS `fqs_phone`,
		'' AS `fqs_mobile`,
		'' AS `fqs_state`,
		'' AS `fqs_postcode`,
		'' AS `fqs_suburb`,

		m.name AS `tender_make`,
		f.name AS `tender_model`,
		v.name AS `tender_variant`,
		qr.build_date AS `tender_build_date`,
		qr.series AS `tender_series`,
		qr.body_type AS `tender_body_type`,
		qr.colour AS `tender_colour`,
		qr.transmission AS `tender_transmission`,
		qr.fuel_type AS `tender_fuel_type`,
		qr.registration_type AS `tender_registration_type`

		FROM leads l
		LEFT JOIN users qs ON l.fk_user = qs.id_user
		LEFT JOIN users temp_qs ON l.fk_temp_user = temp_qs.id_user
		LEFT JOIN quote_requests qr ON l.id_lead = qr.fk_lead
		LEFT JOIN makes m ON qr.make = m.id_make
		LEFT JOIN families f ON qr.model = f.id_family
		LEFT JOIN vehicles v ON qr.variant = v.id_vehicle
		LEFT JOIN quotes q ON qr.winner = q.id_quote
		LEFT JOIN users d ON q.fk_user = d.id_user
		LEFT JOIN dealer_attributes da ON d.id_user = da.fk_user
		WHERE l.id_lead = '".$lead_id."' LIMIT 1";
		return $this->db->query($query)->row_array();
	}
	
	// OTHER PARTS //


	public function delete_file ($params)
	{
		$this->load->helper('file');
		$fk_main = $params['fk_main'];
		$abspath = "./uploads/cq_files/".$params['abspath'];
		$delete_file_q = "DELETE FROM file_attachments WHERE id_file_attachment = {$fk_main}";
		if($this->db->query($delete_file_q))
		{
			if(unlink($abspath))
			{
				return TRUE;
			}
		}
		return FALSE;
	}

	public function get_eway_transactions ()
	{
		$return_array = [];
		$query = "SELECT trans_id FROM eway_transactions WHERE trans_type <> 3 AND auth_code <> '000000'";
		$result = $this->db->query($query)->result_array();
		foreach ($result as $key => $value) 
		{
			$return_array[] = $value['trans_id'];
		}
		return $return_array;
	}

	public function get_refund_details ($id_payment)
	{
		$query = "SELECT * FROM payments WHERE id_payment = {$id_payment}";
		return $this->db->query($query)->row_array();
	}

	public function update_payment_refund ($id_payment)
	{
		$this->db->where('id_payment', $id_payment);
		$this->db->update('payments', array( 'refund_status' => 1, 'refund_date' => date("Y-m-d H:i:s") ) );
	}

	public function get_admin_fee_flag ($fk_lead)
	{
		// $query = "SELECT * FROM payments WHERE fk_lead = {$fk_lead} AND admin_fee != 0";
		$query = "SELECT * FROM payments WHERE fk_lead = {$fk_lead} AND fk_payment_type = 2";
		if($this->db->query($query)->num_rows() > 0)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	public function get_tradein_document_list ()
	{
		$query = "SELECT * FROM tradein_documents";
		return $this->db->query($query)->result_array();
	}

	public function insert_tradein_documents ($tradein_id, $doc_id, $final_filename, $original_filename, $user)
	{
		$now = date("Y-m-d H:i:s");
		$file_data = array(
			'fk_lead'       => $tradein_id,
			'fk_user'       => $user,
			'fk_lead_doc'   => $doc_id,
			'file_name'     => $final_filename,
			'orig_filename' => $original_filename,
			'created_at'    => $now
		);

		$this->db->insert('tradein_documents_upload', $file_data);

		$insert_id = $this->db->insert_id();

		if($doc_id == 0 || $doc_id == "" || $doc_id == "0")
		{
			$this->catch_tradein_zero_doc_id($tradein_id, $insert_id, $doc_id, $user);
		}
	}

	public function catch_tradein_zero_doc_id($tradein_id, $insert_id, $doc_id, $user)
	{
		$insert_data = [
			'fk_tradein'        => $tradein_id,
			'fk_tradein_doc_id' => $insert_id,
			'fk_doc_id'         => $fk_doc_id,
			'fk_user'           => $user,
			'created_at'        => date('Y-m-d H:i:s')
		];

		$this->db->insert('caught_zero_tradein_doc', $insert_data);
	}

	public function get_specific_tradein_documents ($tradein_id, $doc_id)
	{
		$query = "
		SELECT * FROM tradein_documents_upload tu
		LEFT JOIN users u ON tu.fk_user = u.id_user 
		WHERE fk_lead = {$tradein_id} AND fk_lead_doc = {$doc_id};";
		return $this->db->query($query)->result_array();
	}

	public function delete_tradein_documents ($params)
	{
		$this->load->helper('file');
		$id_doc = $params['id_doc'];
		$abspath = "./uploads/tradein_documents/".$params['abspath'];
		$delete_file_q = "DELETE FROM tradein_documents_upload WHERE id_lead_doc_up={$id_doc}";
		if ($this->db->query($delete_file_q))
		{
			if (unlink($abspath))
			{
				return TRUE;
			}
		}
		return FALSE;
	}

	public function get_attachment_flag ($lead_id)
	{
		$query = "SELECT COUNT(1) AS `count` FROM file_attachments WHERE fk_main = {$lead_id}";
		$result = $this->db->query($query)->row_array();
		return (int)$result['count'];
	}

	public function get_all_lead_call_backs ($user_id)
	{
		$now = date("Y-m-d");
		$query = "
		SELECT l.id_lead, l.email, l.name, l.phone, l.mobile, l.state, l.postcode, l.make, l.model, l.details,
		IF (DATE(l.assignment_date) = '0000-00-00', '".$now."', DATE(l.assignment_date)) AS `assignment_date`, l.assignment_time
		FROM leads l
		WHERE 1
		AND l.fk_user = '".$user_id."'
		AND l.fk_buyer = 0
		AND l.status IN (1, 2)
		ORDER BY l.assignment_date ASC, l.assignment_time ASC";
		$sql = $this->db->query($query);

		return $sql->result_array();
	}

	public function get_tradein_document_class ($id)
	{
		$doc_type_arr = [];

		$query = "
		SELECT * FROM tradein_documents_upload WHERE fk_lead = {$id};";
		$result = $this->db->query($query)->result_array();

		foreach ($result as $key => $val) 
		{
			$doc_type_arr[] = $val['fk_lead_doc'];
		}

		return $doc_type_arr;
	}

	public function get_trade_checklist ($id)
	{
		$query = "
		SELECT 
		`id_tradein`, `contact_name`, `contact_number`, 
		DATE(pickup_datetime) AS `pickup_date`, DATE_FORMAT(`pickup_datetime`,'%H:%i:%s') AS `pickup_time`,
		`trans_flag`, `transport_company`, `transport_contact_num`, `cost_of_transport`, `booking_made`, `book_ref_number`, `fk_user`
		FROM `tradeins` WHERE `id_tradein` = {$id}";
		return $this->db->query($query)->row_array();
	}

	public function get_tradein_user ()
	{
		$query = "SELECT * FROM users WHERE type = 3";
		return $this->db->query($query)->result_array();
	}

	public function save_checklist ($data)
	{
		$update_data = [
			'fk_user'               => $data['tradein_buyer'],
			'pickup_datetime'       => $data['pickup_date'] . " " . date('H:i:s', strtotime($data['pickup_time'])),
			'contact_name'          => $data['contact_name'],
			'contact_number'        => $data['contact_number'],
			'trans_flag'            => $data['trans_flag'],
			'transport_company'     => $data['transport_company'],
			'transport_contact_num' => $data['transport_contact_number'],
			'cost_of_transport'     => $data['cost_of_transport'],
			'booking_made'          => $data['booking_made'],
			'book_ref_number'       => $data['booking_ref_number']
		];
		$this->db->where('id_tradein', $data['hidden_id']);
		$this->db->update('tradeins', $update_data);
	}

	public function insert_lead_token_info ($data)
	{
		$insert_data = [
			'fk_user'    => $data['fk_user'],
			'fk_lead'    => $data['lead_id'],
			'token'      => $data['token'],
			'cc_ending'  => $data['cc_ending'],
			'first_name' =>$data['first_name'],
			'last_name'  => $data['last_name'],
			'exp_month'  => $data['exp_month'],
			'exp_year'   => $data['exp_year']
		];
		$this->db->insert('lead_payments_tokens', $insert_data);
	}

	public function validate_token ($lead_id, $cc_ending, $exp_month, $exp_year)
	{
		$query = "
		SELECT * FROM lead_payments_tokens 
		WHERE fk_lead = '".$this->db->escape_str($lead_id)."'
		AND cc_ending = '".$this->db->escape_str($cc_ending)."'
		AND exp_month = '".$this->db->escape_str($exp_month)."'
		AND exp_year = '".$this->db->escape_str($exp_year)."'";
		return $this->db->query($query)->num_rows();
	}

	public function get_commission ($lead_id)
	{
		$query = "
		SELECT comm_month, comm_year, comm_validation_code, comm_status 
		FROM leads 
		WHERE id_lead = '".$this->db->escape_str($code)."'";
		return $this->db->query($query)->row_array();
	}

	public function update_commission_date ($lead_id, $data)
	{
		$query = "
		UPDATE `leads` SET 
		comm_month = '".$data['comm_month']."', 
		comm_year = '".$data['comm_year']."', 
		comm_validation_code = '".$data['email_code']."', 
		comm_status = 1 
		WHERE `id_lead` = '".$this->db->escape_str($lead_id)."'";
		$sql = $this->db->query($query);
	}

	public function validate_commission_code ($lead_id, $code)
	{
		$query = "
		SELECT * FROM leads 
		WHERE id_lead = '".$this->db->escape_str($lead_id)."' 
		AND comm_validation_code = '".$this->db->escape_str($code)."'";
		$flag = $this->db->query($query)->num_rows();

		if($flag > 0)
		{
			$query = "UPDATE `leads` SET comm_status = 2 WHERE `id_lead` = '".$this->db->escape_str($lead_id)."'";
			$sql = $this->db->query($query);			
		}

		return $flag;
	}

	public function update_lead_sale_invoice_status ($data)
	{
		$this->db->where('id_lead_sale_invoice', $data['id']);
		$update_data = ['status' => ($data['old_status'] == 0) ? 1 : 0];
		$this->db->update('lead_sale_invoices', $update_data);
	}

	public function get_all_accessories ($lead_id)
	{
		$query = "select 
				a.id_accessory, a.fk_accessory_supplier as `fk_accessory_supplier`, a.code, a.name, a.cost, a.description, acs.name as `acc_supplier`
				from accessories `a`
				join accessory_suppliers `acs` on a.fk_accessory_supplier = acs.id_accessory_supplier
				where id_accessory not in (select id_deal_accessory from deal_accessories where fk_lead = {$lead_id}) AND a.deprecated != 1";

		return $this->db->query($query)->result_array();
	}

	public function insert_lead_accessory ($data)
	{
		$return_arr = [];

		$insert_data = [];

		$lead_id = $data['lead_id'];

		foreach ($data['id_arr'] as $d_key => $d_val) 
		{
			$insert_data = [];

			$insert_data = [
				'fk_lead'      => $lead_id,
				'fk_accessory' => $d_val,
				'quantity'     => "1",
				'price'        => 0.00,
				'created_at'   => date("Y-m-d H:i:s")
			];

			$this->db->insert('deal_accessories', $insert_data);

			$return_arr[] = $this->db->insert_id();
		}

		return $return_arr;
	}

	public function update_lead_accessory ($data)
	{
		$update_data = [];

		if( count($data['id_acc']) > 0 )
		{
			foreach ($data['id_acc'] as $d_key => $d_val) 
			{
				$temp_data = [];

				$temp_data = [
					'id_deal_accessory' => $d_val,
					'quantity'          => $data['quantity'][$d_key],
					'price'             => $data['price'][$d_key]
				];

				$update_data[] = $temp_data;
			}

			$this->db->update_batch('deal_accessories', $update_data, 'id_deal_accessory');
		}

		return true;
	}

	public function update_lead_accessory_status ($status, $job_date, $spec_con, $lead_id)
	{
		$this->db->where('id_lead', $lead_id);

		$update_arr = [
			'accessory_status'             => $status,
			'accessory_job_date'           => $job_date,
			'accessory_special_conditions' => $spec_con
		];

		if($this->db->update('leads', $update_arr))
			return true;

		return false;
	}

	public function delete_lead_accessory ($id_acc)
	{
		$this->db->where('id_deal_accessory', $id_acc);

		$update_data = [
			'deprecated' => 1
		];

		return $this->db->update('deal_accessories', $update_data);
	}

	public function update_aftersales_status($lead_id, $aftersales_status, $aftersales_remarks = "")
	{
		$this->db->where('id_lead', $lead_id);

		$update_data = [
			'aftersales_status'  => $aftersales_status,
			'aftersales_remarks' => $aftersales_remarks
		];

		$this->db->update('leads', $update_data);
	}

	public function get_lead_car_details($lead_id) // To be deleted
	{
		$make_query = "select  *
					from makes 
					where name = (select make from leads where id_lead = {$lead_id}) limit 1;";

		$make_result =  $this->db->query($make_query)->row_array();

		$model_query = "select  *
						from families
						where name = (select model from leads where id_lead = {$lead_id}) limit 1;";

		$model_result =  $this->db->query($model_query)->row_array();

		$return_array = [
			'id_make'   => $make_result['id_make'],
			'id_family' => $model_result['id_family']
		];

		return $return_array;

	}


	public function get_client_info ($lead_id)
	{
		$query = "select id_lead, email, name, postcode, phone, mobile, postcode, address, make, model from leads where id_lead = {$lead_id}";

		return $this->db->query($query)->row_array();
	}

	public function get_load_dealer_paramters ($lead_id = 0, $type) // To be deleted
	{
		$dealer_request_query  = "SELECT
									l.`id_lead` as `lead_id`,
									l.`id_lead`, l.`name`, l.`email`, l.`email` as `lead_email`,
									qr.`id_quote_request` AS `qr_id`,
									l.`postcode`, l.`state`,
									m.`id_make`, m.`name` AS `make`,
									f.`id_family`, f.`name` AS `model`
									FROM leads l 
									JOIN quote_requests qr ON l.`id_lead` = qr.`fk_lead`
									LEFT JOIN `makes` AS `m` ON qr.`make` = m.`id_make`
									LEFT JOIN `families` AS `f` ON qr.`model` = f.`id_family`
									LEFT JOIN `vehicles` AS `v` ON qr.`variant` = v.`id_vehicle`
									WHERE l.`id_lead` = {$lead_id} AND l.`deprecated` <> 1
									GROUP BY l.`id_lead`";

		$lead_query = "SELECT id_lead, make, model, state, postcode from leads where id_lead = {$lead_id} LIMIT 1";

		$query = "";

		if($type == "tender")
			$query = $lead_query;
		else
			$query = $dealer_request_query;

		$result = $this->db->query($query)->row_array();

		if(count($result) > 0)
		{
			$return_array = [
				'make'  => $result['make'],
				'state' => $result['state']
			];
		}
		else
		{
			$return_array = [
				'make'  => "",
				'state' => ""
			];	
		}

		return $return_array;
	}

	public function return_to_pre_tender ($lead_id)
	{
		$this->db->where('id_lead', $lead_id);

		$update_data = [
			'status' => 10
		];

		$this->db->update('leads', $update_data);
	}

	public function return_to_tendering ($lead_id)
	{
		$this->db->where('id_lead', $lead_id);

		$update_data = [
			'status' => 3
		];

		$this->db->update('leads', $update_data);
	}

	public function get_invoice_item_types()
	{
		$query = "select * from invoice_item_types where deprecated <> 1";

		return $this->db->query($query)->result_array();
	}
}
/*

14164
28200
10600
1520


1000
1520
7373
*/
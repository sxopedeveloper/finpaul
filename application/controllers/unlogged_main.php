<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('eway.php');

class Unlogged_main extends Eway
{
	protected $data = [];
	protected $settings = [];
	protected $dynamic_fields = [];
	protected $email_header = "";
	protected $email_footer = "";
	protected $email_signature             = "";
	protected $pdf_header = "";
	protected $pdf_footer = "";	
	protected $base_path = "/home/mycarquo/public_html/finquote_crm/";
	protected $landing_page_file_base_path = "/home/mycarquo/public_html/finquote_crm/uploads/landing_page_files/";
	protected $tradein_photo_base_path = "/home/mycarquo/public_html/mytradevaluation.com.au/uploads/";
	protected $tradein_photo_base_path_tm = "/home/mycarquo/public_html/mytradevaluation.com.au/uploads/thumbnails_m/";
	protected $tradein_photo_base_path_ts = "/home/mycarquo/public_html/mytradevaluation.com.au/uploads/thumbnails_s/";
	protected $tradein_photo_base_url_tm = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/";

	protected $tendering_status_array = array(3, 4, 5, 6, 7, 8);
	protected $deal_status_array = array(4, 5, 6, 7, 8);
	protected $deal_approved_status_array = array(5, 6, 7);	
	
	protected $revenue_threshold = 1005;

	public function __construct()
	{
		parent::__construct();

		$company_id = 1;
		
		$this->load->model('logs_model', '', TRUE);
		$this->load->model('audit_model', '', TRUE);
		$this->load->model('pdf_model', '', TRUE);
		$this->load->model('settings_model', '', TRUE);
		$this->load->model('dashboard_model', '', TRUE);
		$this->load->model('user_model', '', TRUE);
		$this->load->model('profile_model', '', TRUE);				
		$this->load->model('admin_model', '', TRUE);
		$this->load->model('car_model', '', TRUE);
		$this->load->model('ticket_model', '', TRUE);
		$this->load->model('notification_model', '', TRUE);
		$this->load->model('comment_model', '', TRUE);
		$this->load->model('carsales_model', '', TRUE);
		
		$this->load->model('lead_model', '', TRUE);
		$this->load->model('emailinvite_model', '', TRUE);
		$this->load->model('emailtemplate_model', '', TRUE);
		$this->load->model('request_model', '', TRUE);
		$this->load->model('quote_model', '', TRUE);
		$this->load->model('accessory_model', '', TRUE);
		$this->load->model('reallocation_model', '', TRUE);
		$this->load->model('action_model', '', TRUE);

		$this->load->model('tradein_model', '', TRUE);
		$this->load->model('tradeinrecipient_model', '', TRUE);

		$this->load->model('payment_model', '', TRUE);
		$this->load->model('invoice_model', '', TRUE);

		$this->load->model('fapplication_model', '', TRUE);

		$this->load->model('landing_model', '', TRUE); // Recheck
		$this->load->model('cqlanding_model', '', TRUE); // Recheck
		$this->load->model('fqlanding_model', '', TRUE);

		$this->load->model('eway_transactions_model');

		$this->settings = $this->settings_model->get_settings($company_id);
		$this->email_header = '
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
				<meta name="generator" content="HTML Tidy for Linux/x86 (vers 25 March 2009), see www.w3.org">
				<title>El Quoto | '.$this->settings['company_name'].'</title>
			</head>
			<body style="background: #ffffff; font-family: Verdana, Geneva, sans-serif; font-size: 14px; border: 1px solid #d8d8d8; padding: 0px">
				<style>
					p {
						line-height: 1.5;
					}
				</style>					
				<table style="border-spacing: 0px" bgcolor="#ffffff" width="100%" cellspacing="0" cellpadding="0">
					<tbody>
						<tr>
							<td valign="middle" align="right">
								
								<p style="background: #4bb701; color: #ffffff; padding: 3px 15px; font-size: 1.0em; color: #ffffff; margin-top: 5px; margin-bottom: 20px;">
									<b>
										QuoteMe Hotline | 
										'.$this->settings['company_phone'].' | 
										<a href="mailto:'.$this->settings['company_email'].'">
											<span style="color: #ffffff; text-decoration: none;">info</span>
											<span style="color: #ffffff; text-decoration: none;">@'.$this->settings['company_short_url'].'</span>
										</a>											
									/b>
								</p>
							</td>
						</tr>
						<tr>
							<td align="left" style="padding: 15px 30px 15px 30px; color: #484848;">';

							/*<a href="'.$this->settings['company_url'].'" rilt="Header_Logo" target="_blank" style="text-decoration: none;">
									<img src="'.$this->settings['company_logo'].'" width="300px;" style="margin-right: 15px; margin-top: 15px"><br />
								</a>
								*/
		$this->email_footer = '
							</td>
						</tr>
						<tr>
							<td align="center">
								<br /><br /><br />
								<hr style="border: solid 1px #d8d8d8; border-top: 0px;">
								<p style="font-size: 0.8em; font-family: Verdana, Geneva, sans-serif;">
									'.$this->settings['company_name'].' | 
									'.$this->settings['company_address_line_2'].' | 
									'.$this->settings['company_address_line_1'].' '.$this->settings['company_suburb'].' | 
									'.$this->settings['company_state'].' '.$this->settings['company_postcode'].' <br />
									Ph: '.$this->settings['company_phone'].' |
									'.$this->settings['company_email'].' or '.$this->settings['company_alternate_email'].'
								</p>
							</td>
						</tr>
					</tbody>
				</table>
			</body>
		</html>';

		$this->pdf_css = '
		<style>
			body {
				font-family: Verdana, Geneva, sans-serif;
				color: #666;
				font-size: 10px;
				padding: 100px;				
			}

			.terms p {
				font-size: 20px;
			}
			
			table {
				border-spacing: 0px;
				border-collapse: collapse;
			}

			td {
				vertical-align: top;
			}

			.content td {
				border: 1px solid #666;
				border-top: 0px;
				padding: 3px 5px 3px 5px;			
			}

			.content_2 {
				border: 1px solid #666;
			}

			.content_2 td {
				padding: 3px 5px 3px 5px;			
			}			
			
			.tradedetails_1 {
				padding: 6px 9px; 
				border: 1px solid #666; 
				background: #eee; 
				border-radius: 5px; 
				float: left; 
				margin-bottom: 9px;
				font-weight: bold;				
				width: 18%;
			}
			
			.tradedetails_2 {
				padding: 6px 9px;
				border: 1px solid #666; 
				border-radius: 5px; 
				float: right; 
				margin-bottom: 9px;
				width: 75%;
			}
			
			.tradedetails_3 {
				padding: 7px 10px; 
				border: 1px solid #666; 
				background: #eee; 
				border-radius: 5px; 
				float: left; 
				margin-bottom: 9px;
				font-weight: bold;
				width: 63%;
			}
			
			.tradedetails_4 {
				padding: 7px 10px; 
				border: 1px solid #666; 
				border-radius: 5px; 
				float: right;
				margin-bottom: 9px;
				width: 29%;
			}			
			
			th {
				border: 1px solid #666;
				border-bottom: 0px;
				background: #666;
				color: #fff;
				padding: 3px 5px 3px 5px;
				text-align: left;
			}
			
			.th_2 {
				border: 1px #666 solid;
				border-top: 0px;
				background: #ddd; 
				color: #666; 
			}
			
			.blue_header {
				padding: 5px 10px 5px 10px; 
				background: #0d75ba; 
				color: #fff; 
				font-size: 1.6em;
				margin-top: 18px;
				margin-bottom: 18px;
			}
			
			.details table > tbody tr > td {
				font-size: 0.9em;
			}
			
			.total table > tbody tr > td {
				font-size: 0.9em;
			}

			.license {
				text-align: right;
			}

			.delivery {
				padding: 5px 7px 4px 7px;
				background: #0d75ba;
				color: #fff;				
				font-size: 1.3em; 
				margin-top: 18px; 
				margin-bottom: 10px;			
			}

			.special_conditions {
				padding: 5px 7px 4px 7px;
				background: #0d75ba; 
				color: #fff;
				font-size: 1.3em; 
				margin-top: 18px; 
				margin-bottom: 10px;			
			}			
			
			.th_po_title {
				padding: 7px 25px 7px 25px;
			}
			
			.th_po_text {
				color: #fff; 
				margin: 0px; 
				font-size: 1.2em;
			}
			
			.th_po_num_title {
				padding: 9px 10px 9px 10px;
			}
			
			.th_po_num_text {
				margin: 0px;
			}
		</style>';		
		
		$this->pdf_header = '
		<div>
			<a href="'.$this->settings['company_url'].'" rilt="'.$this->settings['company_name'].'" target="_blank" style="text-decoration: none;">
				<img src="'.$this->settings['company_logo'].'" width="300px;" style="margin-right: 15px; margin-top: 15px"><br />
			</a>
		</div>
		<hr style="clear: both; color: #58C603; background-color: #58C603; height: 2px; border-width: 0;">';

		$this->pdf_footer = '
		<div style="text-align: center;" >
			<hr style="clear: both; color: #58C603; background-color: #58C603; height: 2px; border-width: 0;">
			'.$this->settings['company_name'].' | 
			'.$this->settings['company_address_line_2'].' | 
			'.$this->settings['company_address_line_1'].' '.$this->settings['company_suburb'].' | 
			'.$this->settings['company_state'].' '.$this->settings['company_postcode'].' <br />
			Ph: '.$this->settings['company_phone'].' | 
			'.$this->settings['company_email'].' or '.$this->settings['company_alternate_email'].'
		</div>';		
		
		$this->dynamic_fields = array(
			'[_company_name_]', '[_company_abn_]', '[_company_email_]', '[_company_alternate_email_]', '[_company_phone_]', '[_company_skype_]', '[_company_state_]', '[_company_postcode_]', '[_company_suburb_]', '[_company_address_line_1_]', '[_company_address_line_2_]',
			'[_dealer_email_]', '[_dealer_name_]', '[_dealer_manager_name_]', '[_dealer_manager_first_name_]', '[_dealer_abn_]', '[_dealer_state_]', '[_dealer_postcode_]', '[_dealer_suburb_]', '[_dealer_address_]', '[_dealer_phone_]', '[_dealer_mobile_]',
			'[_client_email_]', '[_client_name_]', '[_client_first_name_]', '[_client_state_]', '[_client_postcode_]', '[_client_suburb_]', '[_client_address_]', '[_client_phone_]', '[_client_mobile_]',
			'[_lead_cq_number_]', '[_lead_po_number_]', '[_lead_source_]', '[_lead_sale_status_]', '[_lead_sale_price_]', '[_lead_make_]', '[_lead_model_]', '[_lead_dealer_price_]', '[_lead_changeover_]', '[_lead_submitted_date_]', '[_lead_order_date_]', '[_lead_delivery_date_]',
			'[_qs_email_]', '[_qs_name_]', '[_qs_first_name_]', '[_qs_phone_]', '[_qs_mobile_]', '[_qs_state_]', '[_qs_postcode_]', '[_qs_suburb_]',
			'[_fqs_email_]', '[_fqs_name_]', '[_fqs_phone_]', '[_fqs_mobile_]', '[_fqs_state_]', '[_fqs_postcode_]', '[_fqs_suburb_]',
			'[_tender_make_]', '[_tender_model_]', '[_tender_variant_]', '[_tender_build_date_]', '[_tender_series_]', '[_tender_body_type_]', '[_tender_colour_]', '[_tender_fuel_type_]', '[_tender_registration_type_]'
		);
		
		$this->data = array(		
			'company' => $this->settings
		);		
	}
	
	function index ()
	{
		header ("Location: ".site_url());
		exit ();
	}	
	
	protected function substring_index($subject, $delim, $count)
	{
		if($count < 0)
		{
			return implode($delim, array_slice(explode($delim, $subject), $count));
		}
		else
		{
			return implode($delim, array_slice(explode($delim, $subject), 0, $count));
		}
	}	

	public function calculate_deal_new ($input_arr, $type = 1)
	{
		// Constant Values //
		$lct_fuel_efficient_value =  75526;
		$lct_other_vehicles_value =  64132;
		$luxury_tax_rate = 0.33;

		// Calculated Values //
		$lct = 0;		
		$stamp_duty = 0;
		
		$rrp = 0;
		$subtotal_1 = 0;
		$subtotal_2 = 0;
		$subtotal_3 = 0;
		$subtotal_4 = 0;
		$gst = 0;
		$total_price_gst_inc = 0;
		$sales_price = 0;
		$price_difference = 0;
		$changeover = 0;
		$revenue = 0;
		$commissionable_gross = 0;

		$answer_act = $input_arr['answer_act'];
		$answer_vic = $input_arr['answer_vic'];
		$answer_qld = $input_arr['answer_qld'];
		$fuel_efficient_flag = $input_arr['fuel_efficient_flag'];
		
		$membership_fee = $input_arr['gross_subtractor'];
		$membership_fee_lower = $input_arr['gross_subtractor_lower'];

		$dqp = $input_arr['winning_price'];
		$dealer_tradein_count = $input_arr['dealer_tradein_count'];
		$dealer_tradein_value = $input_arr['dealer_tradein_value'];
		$dealer_tradein_payout = $input_arr['dealer_tradein_payout'];
		$dealer_client_refund = $input_arr['dealer_client_refund'];		
		$dealer_changeover = $input_arr['dealer_changeover'];		

		$client_state = $input_arr['state'];
		$dealer_state = $input_arr['dealer_state'];
		$registration_type = $input_arr['registration_type'];
		$fuel_efficient_flag = $input_arr['invoice_fuel_efficient_flag'];
		$list_price = $input_arr['retail_price'];
		$options_total = $input_arr['options_total'];
		$accessories_total = $input_arr['accessories_total'];
		$dealer_delivery = $input_arr['predelivery'];
		$dealer_discount = $input_arr['dealer_discount'];
		$fleet_discount = $input_arr['fleet_discount'];
		$registration = $input_arr['registration'];
		$ctp = $input_arr['ctp'];
		$premium_plate_fee = $input_arr['premium_plate_fee'];
		
		$tradein_value = $input_arr['tradein_value'];
		$tradein_given = $input_arr['tradein_given'];
		$tradein_payout = $input_arr['tradein_payout'];

		$deposits_total = $input_arr['deposits_total'];
		$refunds_total = $input_arr['refunds_total'];

		$other_costs_amount = $input_arr['other_costs_amount'];
		$other_revenue_amount = $input_arr['other_revenue_amount'];
		
		$sales_price = $input_arr['sales_price'];

		$rrp = $list_price + $options_total + $accessories_total;				// Retail Price of the Car
		$subtotal_1 = $rrp + $dealer_delivery;									// Price Plus Options & Delivery 		
		$subtotal_2 = $subtotal_1 - ($dealer_discount + $fleet_discount);		// Sub Total Line

		if ($registration_type == "TPI/Gold Card")
		{
			$gst = 0;															// GST (TPI)
		}
		else
		{
			$gst = $subtotal_2 * 0.1;											// GST
		}
		
		$subtotal_3 = $subtotal_2 + $gst;										// Price INC of GST ()
		
		// LCT Computation (Start) //
		if ($fuel_efficient_flag == 1)
		{
			$lct_threshold = $lct_fuel_efficient_value;
		}
		else if ($fuel_efficient_flag == 2)
		{
			$lct_threshold = $lct_other_vehicles_value;
		}
		else
		{
			$lct_threshold = $lct_other_vehicles_value;
		}
		
		if ($subtotal_3 > $lct_threshold)
		{
			$lct = ($subtotal_3 - $lct_threshold) / 11 * 10 * $luxury_tax_rate;
		}
		else
		{
			$lct = 0;
		}
		// LCT Computation (End) //
		
		$subtotal_4 = $subtotal_3 + $lct;
		
		// Stamp Duty NEW (Start) //
		if ($registration_type == "TPI/Gold Card")
		{
			$stamp_duty = 0;
		}
		else
		{
			if ($client_state == "NSW")
			{
				if ($subtotal_3 < 45000)
				{
					$stamp_duty = $subtotal_3 * 0.03;
				}
				else
				{
					$stamp_duty = (($subtotal_3 - 45000) * 0.05) + 1350;
				}
			}
			else if ($client_state == "ACT")
			{				
				if ($subtotal_3 < 45000)
				{
					if ($answer_act == "A-rated")
					{
						$stamp_duty = 0;
					}
					else if ($answer_act == "B-rated")
					{
						$stamp_duty = $subtotal_3 * 0.01;
					}
					else if ($answer_act == "C-rated and Non-rated")
					{
						$stamp_duty = $subtotal_3 * 0.03;
					}
					else if ($answer_act == "D-rated")
					{
						$stamp_duty = $subtotal_3 * 0.04;
					}
				}
				else
				{
					if ($answer_act == "A-rated")
					{
						$stamp_duty = 0;
					}
					else if ($answer_act == "B-rated")
					{
						$stamp_duty = 0.02 * ($subtotal_3 - 45000) +450;
					}
					else if ($answer_act == "C-rated and Non-rated")
					{
						$stamp_duty = 0.05 * ($subtotal_3 - 45000) + 1350;
					}
					else if ($answer_act == "D-rated")
					{
						$stamp_duty = 0.06 * ($subtotal_3 - 45000) + 1800;
					}					
				}
			}
			else if ($client_state == "VIC")
			{
				if ($subtotal_3 <= 64132)
				{
					if ($answer_vic == "New Vehicle - Passenger")
					{
						$stamp_duty = $subtotal_3 * 0.032;
					}
					else if ($answer_vic == "New Vehicle - Non Passenger")
					{
						$stamp_duty = $subtotal_3 * 0.027;
					}
					else if ($answer_vic == "Used Vehicle (Previously Registered)")
					{
						$stamp_duty = $subtotal_3 * 0.042;
					}
				}
				else
				{
					if ($answer_vic == "New Vehicle - Passenger")
					{
						$stamp_duty = $subtotal_3 * 0.052;
					}
					else if ($answer_vic == "New Vehicle - Non Passenger")
					{
						$stamp_duty = $subtotal_3 * 0.027;
					}					
					else if ($answer_vic == "Used Vehicle (Previously Registered)")
					{
						$stamp_duty = $subtotal_3 * 0.042;
					}
				}
			}
			else if ($client_state == "QLD")
			{
				if ($answer_qld == "Hybrid and electric vehicles")
				{
					$stamp_duty = $subtotal_3 * 0.02;
				}
				else if ($answer_qld == "1 to 4 cylinders -2 rotors or a steam vehicle")
				{
					$stamp_duty = $subtotal_3 * 0.03;
				}
				else if ($answer_qld == "5 to 6 cylinders -3 rotors")
				{
					$stamp_duty = $subtotal_3 * 0.035;
				}
				else if ($answer_qld == "7 or more cylinders")
				{
					$stamp_duty = $subtotal_3 * 0.04;
				}
			}
			else if ($client_state == "SA")
			{
				if ($subtotal_3 <= 1000)
				{
					$stamp_duty = $subtotal_3 * 0.01;
				}
				else if ($subtotal_3 <= 2000)
				{
					$stamp_duty = 0.02 * ($subtotal_3 - 1000) + 10;
				}
				else if ($subtotal_3 <= 3000)
				{
					$stamp_duty = 0.03 * ($subtotal_3 - 2000) + 30;
				}
				else
				{
					$stamp_duty = 0.04 * ($subtotal_3 - 3000) + 60;
				}
			}			
			else if ($client_state == "WA")
			{		
				if ($subtotal_3 <= 25000)
				{
					$stamp_duty = $subtotal_3 * 0.0275;
				}
				else if ($subtotal_3 <= 50000)
				{
					$stamp_duty = ((0.0275 * $subtotal_3) + ((($subtotal_3 - 25000) / 6666.66) / 100) * $subtotal_3);
				}
				else
				{
					$stamp_duty = $subtotal_3 * 0.065;
				}
			}			
			else if ($client_state == "TAS")
			{
				if ($subtotal_3 < 600)
				{
					$stamp_duty = 20;
				}
				else if ($subtotal_3 <= 35000)
				{
					$stamp_duty = $subtotal_3 * 0.03;
				}
				else if ($subtotal_3 <= 40000)
				{
					$stamp_duty = 0.11 * ($subtotal_3 - 35000) + 1050;
				}
				else
				{
					$stamp_duty = $subtotal_3 * 0.04;
				}
			}			
			else if ($client_state == "NT")
			{
				$stamp_duty = $subtotal_3 * 0.03;
			}			
		}
		// Stamp Duty NEW (End) //

		$sales_price = $subtotal_4 + $stamp_duty + $registration + $ctp + $premium_plate_fee;
		$balance = $sales_price - $tradein_given + $tradein_payout - $deposits_total + $refunds_total;
		$changeover = $sales_price - $tradein_given + $tradein_payout;
		
		if ($dealer_tradein_count <> 0 AND $dealer_tradein_count <> "")
		{
			$price_difference = $changeover - $dealer_changeover;
			$revenue = $changeover - $dealer_changeover - $other_costs_amount + $other_revenue_amount;
			
			if ($revenue <= $this->revenue_threshold)
			{
				$final_membership_fee = $membership_fee_lower;
			}
			else
			{
				$final_membership_fee = $membership_fee;
			}
			$commissionable_gross = (($revenue - $other_revenue_amount - $final_membership_fee) / 11) * 10;
		}
		else
		{
			$price_difference = $sales_price - $dqp;
			$revenue = $sales_price + ($tradein_value - $tradein_given) - $dqp - $other_costs_amount + $other_revenue_amount;
			
			if ($revenue <= $this->revenue_threshold)
			{
				$final_membership_fee = $membership_fee_lower;
			}
			else
			{
				$final_membership_fee = $membership_fee;
			}
			$commissionable_gross = (($revenue - $other_revenue_amount - $final_membership_fee) / 11) * 10;
		}

		$output_arr = array(
			'list_price' => round($list_price, 2),
			'options_total' => round($options_total, 2),
			'accessories_total' => round($accessories_total, 2),
			'dealer_delivery' => round($dealer_delivery, 2),
			'dealer_discount' => round($dealer_discount, 2),
			'fleet_discount' => round($fleet_discount, 2),
			'registration' => round($registration, 2),
			'ctp' => round($ctp, 2),
			'premium_plate_fee' => round($premium_plate_fee, 2),
			
			'tradein_value' => round($tradein_value, 2),
			'tradein_given' => round($tradein_given, 2),
			'tradein_payout' => round($tradein_payout, 2),
			'deposits_total' => round($deposits_total, 2),
			'refunds_total' => round($refunds_total, 2),
			'other_costs_amount' => round($other_costs_amount, 2),
			'other_revenue_amount' => round($other_revenue_amount, 2),
			
			'lct_threshold' => round($lct_threshold, 2),
			'rrp' => round($rrp, 2),
			'subtotal_1' => round($subtotal_1, 2),
			'subtotal_2' => round($subtotal_2, 2),
			'subtotal_3' => round($subtotal_3, 2),
			'gst' => round($gst, 2),
			'lct' => round($lct, 2),
			'stamp_duty' => round($stamp_duty, 2),
			'sales_price' => round($sales_price, 2),

			'balance' => round($balance, 2),
			'price_difference' => round($price_difference, 2),
			'changeover' => round($changeover, 2),
			'revenue' => round($revenue, 2),
			'commissionable_gross' => round($commissionable_gross, 2)
		);
		return $output_arr;
	}
		
	public function calculate_adjusted_quote ($lead_arr)
	{
		$lead_calculation_details = $this->calculate_deal_new($lead_arr);		
		if ($lead_calculation_details['sales_price'] > $lead_arr['sales_price'])
		{
			while ($lead_calculation_details['sales_price'] > $lead_arr['sales_price'])
			{
				$lead_arr['dealer_discount'] += 1;
				$lead_calculation_details = $this->calculate_deal_new($lead_arr);
			}
			
			if ($lead_calculation_details['sales_price'] < $lead_arr['sales_price'])
			{
				while ($lead_calculation_details['sales_price'] < $lead_arr['sales_price'])
				{
					if ($lead_arr['fleet_discount'] <= 0)
					{
						if ($lead_arr['dealer_discount'] <= 0)
						{
							if ($lead_arr['predelivery'] >= 1000)
							{
								$lead_arr['registration'] += 0.01;
							}
							else
							{
								$lead_arr['predelivery'] += 0.01;
							}
						}
						else
						{
							$lead_arr['dealer_discount'] -= 0.01;
						}
					}
					else
					{
						$lead_arr['fleet_discount'] -= 0.01;
					}
					$lead_calculation_details = $this->calculate_deal_new($lead_arr);
				}		
			}
		}
		else
		{
			$lead_calculation_details['sales_price'] = 0;
			while ($lead_calculation_details['sales_price'] < $lead_arr['sales_price'])
			{
				if ($lead_arr['fleet_discount'] <= 0)
				{
					if ($lead_arr['dealer_discount'] <= 0)
					{
						if ($lead_arr['predelivery'] >= 1000)
						{
							$lead_arr['registration'] += 0.01;
						}
						else
						{
							$lead_arr['predelivery'] += 0.01;
						}
					}
					else
					{
						$lead_arr['dealer_discount'] -= 0.01;
					}
				}
				else
				{
					$lead_arr['fleet_discount'] -= 0.01;
				}
				$lead_calculation_details = $this->calculate_deal_new($lead_arr);
			}	
		}
		return $lead_arr;		
	}	
	
	protected function send_templated_email ($from_email, $from_name, $to, $subject, $content, $file = "")
	{
		date_default_timezone_set('Australia/Sydney');
		ini_set('max_execution_time', -1);	
		$now = date("Y-m-d H:i:s");
		$complete_email = $this->email_header.$content.$this->email_footer;

		$this->load->library('email');
		$this->email->clear();
		$this->email->set_mailtype('html');
		$this->email->to($to);
		$this->email->from($from_email, $from_name);
		$this->email->subject($subject);
		$this->email->message($complete_email);
		
		$path_array = explode("[path]", $file);
		foreach ($path_array AS $path)
		{
			if (trim($path) <> "")
			{
				$this->email->attach($path);
			}			
		}
		
		$this->email->send();		
	}

	protected function templated_special_email_init ($email_template_id, $from, $to, $inline_dynamic_fields, $file = "") // Recheck - Different from ADMIN
	{
		$email_template = $this->settings_model->get_email_template($email_template_id);

		$subject = $email_template['subject'];
		$content = $email_template['content'];
		foreach ($this->dynamic_fields AS $dynamic_field)
		{
			if (isset($this->settings[str_replace('_]', '', str_replace('[_', '', $dynamic_field))]))
			{
				$subject = str_replace($dynamic_field, $this->settings[str_replace('_]', '', str_replace('[_', '', $dynamic_field))], $subject);
				$content = str_replace($dynamic_field, $this->settings[str_replace('_]', '', str_replace('[_', '', $dynamic_field))], $content);
			}
		}

		foreach ($inline_dynamic_fields AS $inline_dynamic_field_index => $inline_dynamic_field)
		{
			$subject = str_replace($inline_dynamic_field_index, $inline_dynamic_field, $subject);
			$content = str_replace($inline_dynamic_field_index, $inline_dynamic_field, $content);
		}

		if ($from == "company" OR $from == "")
		{
			$from_email = $this->settings['company_email'];
			$from_name = $this->settings['company_name'];
		}
		else
		{
			$from_email = $lead_details[$from.'_email'];
			$from_name = $lead_details[$from.'_name'];			
		}

		$this->send_templated_email($from_email, $from_name, $to, $subject, $content, $file);
	}	
	
	protected function templated_client_email_init ($email_template_id, $lead_id, $from, $file = "")
	{
		$email_template = $this->settings_model->get_email_template($email_template_id);
		$lead_details = $this->lead_model->get_lead_for_email($lead_id);
		
		$subject = $email_template['subject'];
		$content = $email_template['content'];		
		foreach ($this->dynamic_fields AS $dynamic_field)
		{
			if (isset($lead_details[str_replace('_]', '', str_replace('[_', '', $dynamic_field))]))
			{
				$subject = str_replace($dynamic_field, $lead_details[str_replace('_]', '', str_replace('[_', '', $dynamic_field))], $subject);
				$content = str_replace($dynamic_field, $lead_details[str_replace('_]', '', str_replace('[_', '', $dynamic_field))], $content);
			}

			if (isset($this->settings[str_replace('_]', '', str_replace('[_', '', $dynamic_field))]))
			{
				$subject = str_replace($dynamic_field, $this->settings[str_replace('_]', '', str_replace('[_', '', $dynamic_field))], $subject);
				$content = str_replace($dynamic_field, $this->settings[str_replace('_]', '', str_replace('[_', '', $dynamic_field))], $content);
			}			
		}

		if ($from == "company" OR $from == "")
		{
			$from_email = $this->settings['company_email'];
			$from_name = $this->settings['company_name'];
		}
		else
		{
			if ($lead_details[$from.'_email'] <> "")
			{
				$from_email = $lead_details[$from.'_email'];
				$from_name = $lead_details[$from.'_name'];
			}
			else if ($lead_details['temp_qs_email'] <> "")
			{
				$from_email = $lead_details['temp_qs_email'];
				$from_name = $lead_details['temp_qs_name'];				
			}
			else
			{
				$from_email = $this->settings['company_email'];
				$from_name = $this->settings['company_name'];				
			}			
		}

		$this->send_templated_email($from_email, $from_name, $lead_details['client_email'], $subject, $content, $file);
	}

	protected function templated_dealer_email_init ($email_template_id, $dealer_id, $file = "")
	{
		$email_template = $this->settings_model->get_email_template($email_template_id);
		$user_details = $this->user_model->get_dealer_for_email($dealer_id);

		$subject = $email_template['subject'];
		$content = $email_template['content'];
		foreach ($this->dynamic_fields AS $dynamic_field)
		{
			if (isset($user_details[str_replace('_]', '', str_replace('[_', '', $dynamic_field))]))
			{
				$subject = str_replace($dynamic_field, $user_details[str_replace('_]', '', str_replace('[_', '', $dynamic_field))], $subject);
				$content = str_replace($dynamic_field, $user_details[str_replace('_]', '', str_replace('[_', '', $dynamic_field))], $content);
			}

			if (isset($this->settings[str_replace('_]', '', str_replace('[_', '', $dynamic_field))]))
			{
				$subject = str_replace($dynamic_field, $this->settings[str_replace('_]', '', str_replace('[_', '', $dynamic_field))], $subject);
				$content = str_replace($dynamic_field, $this->settings[str_replace('_]', '', str_replace('[_', '', $dynamic_field))], $content);
			}
		}
		
		$this->send_templated_email($this->settings['company_email'], $this->settings['company_name'], $user_details['dealer_email'], $subject, $content, $file);
	}	
	
	protected function templated_dealer_lead_email_init ($email_template_id, $dealer_id, $lead_id, $from, $to, $file = "")
	{
		$email_template = $this->settings_model->get_email_template($email_template_id);
		$user_details = $this->user_model->get_dealer_for_email($dealer_id);
		$lead_details = $this->lead_model->get_lead_for_email($lead_id);

		$subject = $email_template['subject'];
		$content = $email_template['content'];
		foreach ($this->dynamic_fields AS $dynamic_field)
		{
			if (isset($user_details[str_replace('_]', '', str_replace('[_', '', $dynamic_field))]))
			{
				$subject = str_replace($dynamic_field, $user_details[str_replace('_]', '', str_replace('[_', '', $dynamic_field))], $subject);
				$content = str_replace($dynamic_field, $user_details[str_replace('_]', '', str_replace('[_', '', $dynamic_field))], $content);
			}

			if (isset($lead_details[str_replace('_]', '', str_replace('[_', '', $dynamic_field))]))
			{
				$subject = str_replace($dynamic_field, $lead_details[str_replace('_]', '', str_replace('[_', '', $dynamic_field))], $subject);
				$content = str_replace($dynamic_field, $lead_details[str_replace('_]', '', str_replace('[_', '', $dynamic_field))], $content);
			}			

			if (isset($this->settings[str_replace('_]', '', str_replace('[_', '', $dynamic_field))]))
			{
				$subject = str_replace($dynamic_field, $this->settings[str_replace('_]', '', str_replace('[_', '', $dynamic_field))], $subject);
				$content = str_replace($dynamic_field, $this->settings[str_replace('_]', '', str_replace('[_', '', $dynamic_field))], $content);
			}
		}

		if ($from == "company" OR $from == "")
		{
			$from_email = $this->settings['company_email'];
			$from_name = $this->settings['company_name'];
		}
		else
		{
			if ($lead_details[$from.'_email'] <> "")
			{
				$from_email = $lead_details[$from.'_email'];
				$from_name = $lead_details[$from.'_name'];
			}
			else if ($lead_details['temp_qs_email'] <> "")
			{
				$from_email = $lead_details['temp_qs_email'];
				$from_name = $lead_details['temp_qs_name'];				
			}
			else
			{
				$from_email = $this->settings['company_email'];
				$from_name = $this->settings['company_name'];				
			}
		}

		$to_email = "";
		if ($to == "dealer")
		{
			if (isset($user_details['dealer_email']))
			{
				$to_email = $user_details['dealer_email'];	
			}
		}
		else if ($to == "client")
		{
			$to_email = $lead_details['client_email'];
		}

		if ($to_email <> "")
		{
			$this->send_templated_email($from_email, $from_name, $to_email, $subject, $content, $file);	
		}
	}
	
	public function changed_fields ($db_arr, $post_arr, $exceptions_arr = array())
	{
		$changed_fields_arr = [];
		$changed_fields_string = "";
		foreach ($post_arr AS $field => $value)
		{
			if (!in_array($field, $exceptions_arr))
			{
				if ($db_arr[$field] != $value)
				{
					$changed_fields_arr[] = array("field" => $field, "value_from" => $db_arr[$field], "value_to" => $value);
				}
			}
		}
		if (count($changed_fields_arr) <> 0)
		{
			$changed_fields_string = json_encode($changed_fields_arr, JSON_HEX_QUOT);
		}
		return $changed_fields_string;
	}	
}
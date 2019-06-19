<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('admin_main.php');

class Dashboard extends Admin_main
{
	function __construct()
	{
	    ob_start();
		parent::__construct();
	}

	function index()
	{
		$data = $this->data;
		$data['title'] = 'Dashboard';

		// MY NUMBERS //
		$total_tickets = $this->dashboard_model->get_this_month_tickets($data['user_id']);
		$total_leads = $this->dashboard_model->get_this_month_leads($data['user_id']);
		$total_tenders = $this->dashboard_model->get_this_month_tenders($data['user_id']);
		$total_approved_deals = $this->dashboard_model->get_this_month_approved_deals($data['user_id']);
		$total_settled_deals = $this->dashboard_model->get_this_month_settled_deals($data['user_id']);
		$highest_day_deals = $this->dashboard_model->get_highest_day_deals($data['user_id']);
		$highest_month_leads = $this->dashboard_model->get_highest_month_leads($data['user_id']);

		$total_approved_commissionable_gross = 0;
		$approved_commissionable_gross_rows = $this->dashboard_model->get_this_month_approved_commissionable_gross_fields($data['user_id']);
		foreach ($approved_commissionable_gross_rows as $commissionable_gross_row)
		{
			$other_costs_amount = $commissionable_gross_row->other_costs_amount;
			$other_revenue_amount = $commissionable_gross_row->other_revenue_amount;
			$dqp = $commissionable_gross_row->total;
			$dealer_tradein_value = $commissionable_gross_row->dealer_tradein_value;
			$dealer_changeover = $commissionable_gross_row->dealer_changeover;
			$changeover = $commissionable_gross_row->cpp;
			$sales_price = $commissionable_gross_row->sales_price;
			$tradein_value = $commissionable_gross_row->tradein_value;
			$tradein_given = $commissionable_gross_row->tradein_given;
			$tradein_payout = $commissionable_gross_row->tradein_payout;
			$winning_wholesaler = $commissionable_gross_row->winning_wholesaler;
			$membership_fee = $commissionable_gross_row->gross_subtractor;
			$membership_fee_lower = $commissionable_gross_row->gross_subtractor_lower;
			
			$changeover = $sales_price - $tradein_given + $tradein_payout;

			if ($winning_wholesaler == 282)
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
			
			$total_approved_commissionable_gross += $commissionable_gross;
		}

		$total_delivered_commissionable_gross = 0;
		$delivered_commissionable_gross_rows = $this->dashboard_model->get_this_month_delivered_commissionable_gross_fields($data['user_id']);
		foreach ($delivered_commissionable_gross_rows as $commissionable_gross_row)
		{
			$other_costs_amount = $commissionable_gross_row->other_costs_amount;
			$other_revenue_amount = $commissionable_gross_row->other_revenue_amount;
			$dqp = $commissionable_gross_row->total;
			$dealer_tradein_value = $commissionable_gross_row->dealer_tradein_value;
			$dealer_changeover = $commissionable_gross_row->dealer_changeover;
			$changeover = $commissionable_gross_row->cpp;
			$sales_price = $commissionable_gross_row->sales_price;
			$tradein_value = $commissionable_gross_row->tradein_value;
			$tradein_given = $commissionable_gross_row->tradein_given;
			$tradein_payout = $commissionable_gross_row->tradein_payout;
			$winning_wholesaler = $commissionable_gross_row->winning_wholesaler;
			$membership_fee = $commissionable_gross_row->gross_subtractor;
			$membership_fee_lower = $commissionable_gross_row->gross_subtractor_lower;
			
			$changeover = $sales_price - $tradein_given + $tradein_payout;
			
			if ($winning_wholesaler == 282)
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
			
			$total_delivered_commissionable_gross += $commissionable_gross;
		}		

		$total_settled_commissionable_gross = 0;
		$settled_commissionable_gross_rows = $this->dashboard_model->get_this_month_settled_commissionable_gross_fields($data['user_id']);
		foreach ($settled_commissionable_gross_rows as $commissionable_gross_row)
		{
			$other_costs_amount = $commissionable_gross_row->other_costs_amount;
			$other_revenue_amount = $commissionable_gross_row->other_revenue_amount;
			$dqp = $commissionable_gross_row->total;
			$dealer_tradein_value = $commissionable_gross_row->dealer_tradein_value;
			$dealer_changeover = $commissionable_gross_row->dealer_changeover;
			$changeover = $commissionable_gross_row->cpp;
			$sales_price = $commissionable_gross_row->sales_price;
			$tradein_value = $commissionable_gross_row->tradein_value;
			$tradein_given = $commissionable_gross_row->tradein_given;
			$tradein_payout = $commissionable_gross_row->tradein_payout;
			$winning_wholesaler = $commissionable_gross_row->winning_wholesaler;
			$membership_fee = $commissionable_gross_row->gross_subtractor;
			$membership_fee_lower = $commissionable_gross_row->gross_subtractor_lower;
			
			$changeover = $sales_price - $tradein_given + $tradein_payout;
			
			if ($winning_wholesaler == 282)
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
			
			$total_settled_commissionable_gross += $commissionable_gross;			
		}

		$data['ticket_count'] = $total_tickets['cnt'];
		$data['urgent_ticket_count'] = $total_tickets['cnt'];
		$data['lead_count'] = $total_leads['cnt'];
		$data['tender_count'] = $total_tenders['cnt'];
		$data['approved_deal_count'] = $total_approved_deals['cnt'];
		$data['settled_deal_count'] = $total_settled_deals['cnt'];

		$data['highest_day_deals_name'] = "N/A";
		$data['highest_day_deals_count'] = "0";
		$data['highest_day_deals_record_date'] = "N/A";
		if (isset($highest_day_deals['name']) AND isset($highest_day_deals['cnt']) AND isset($highest_day_deals['record_date']))
		{
			$data['highest_day_deals_name'] = $highest_day_deals['name'];
			$data['highest_day_deals_count'] = $highest_day_deals['cnt'];
			$data['highest_day_deals_record_date'] = $highest_day_deals['record_date'];
		}

		$data['highest_month_leads_name'] = "N/A";
		$data['highest_month_leads_count'] = "0";
		$data['highest_month_leads_record_date'] = "N/A";
		if (isset($highest_month_leads['name']) AND isset($highest_month_leads['cnt']) AND isset($highest_month_leads['record_date']))
		{
			$data['highest_month_leads_name'] = $highest_month_leads['name'];
			$data['highest_month_leads_count'] = $highest_month_leads['cnt'];
			$data['highest_month_leads_record_date'] = $highest_month_leads['record_date'];
		}

		$data['total_approved_commissionable_gross'] = round($total_approved_commissionable_gross, 2);
		$data['total_settled_commissionable_gross'] = round($total_settled_commissionable_gross, 2);
		$data['total_delivered_commissionable_gross'] = round($total_delivered_commissionable_gross, 2);

		$settled_commission = ($total_settled_commissionable_gross - 10000) / 2;
		if ($settled_commission < 0) { $settled_commission = 0; }
		$data['settled_commission'] = round($settled_commission, 2);

		$projected_commission = ($total_delivered_commissionable_gross - 10000) / 2;
		if ($projected_commission < 0) { $projected_commission = 0; }
		$data['projected_commission'] = round($projected_commission, 2);

		// CHART //
		$current_date = date('Y-m-d');
		$current_year = date('Y');
		$current_month = date('m');
		$current_date_f = new DateTime($current_date);
		$current_week_number = $current_date_f->format("W");

		// DAY VIEW
		$dto = new DateTime();
		$dto->setISODate($current_year, $current_week_number);
		$week_start = $dto->format('Y-m-d');
		$dto->modify('+6 days');
		$week_end = $dto->format('Y-m-d');
		
		$days = array();
		$iDateFrom = mktime(1,0,0,substr($week_start,5,2),substr($week_start,8,2),substr($week_start,0,4));
		$iDateTo = mktime(1,0,0,substr($week_end,5,2),substr($week_end,8,2),substr($week_end,0,4));
		if ($iDateTo>=$iDateFrom)
		{
			array_push($days,date('Y-m-d',$iDateFrom));
			while ($iDateFrom<$iDateTo)
			{
				$iDateFrom+=86400;
				array_push($days,date('Y-m-d',$iDateFrom));
			}
		}

		$data['d'] = $days;
		$params['date_type'] = 'order_date';
		$params['d'] = $days;
		$data['order_counter'] = $this->dashboard_model->get_lead_counter_days($params);

		$params['date_type'] = 'tender_date';
		$data['tender_counter'] = $this->dashboard_model->get_lead_counter_days($params);
		
		$params['date_type'] = 'allocated_date';
		$data['lead_counter'] = $this->dashboard_model->get_lead_counter_days($params);

		$data['running_tenders_report'] = $this->dashboard_model->get_running_tenders();

		$report_params['d'] = $days;
		$data['approved_deals_report'] = $this->dashboard_model->get_approved_deals_report($report_params);
		$data['submitted_deals_report'] = $this->dashboard_model->get_submitted_deals_report($report_params);
		$data['settled_deals_report'] = $this->dashboard_model->get_settled_deals_report($report_params);
		$data['last_settled_deals_report'] = $this->dashboard_model->get_last_settled_deals_report($report_params);

		if ($data['user_id']==255)
		{
			$this->load->view('admin/admin_dashboard', $data);
		}
		else
		{
			$this->load->view('admin/dashboard', $data);
		}
	}
}
?>
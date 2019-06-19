<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tool extends CI_Controller
{
	protected $data                        = [];
	protected $settings                    = [];
	protected $dynamic_fields              = [];
	protected $email_header                = "";
	protected $email_footer                = "";
	protected $email_signature             = "";
	protected $pdf_header                  = "";
	protected $pdf_footer                  = "";	
	protected $base_path                   = "/home/mycarquo/public_html/myelquoto.com.au/";
	protected $landing_page_file_base_path = "/home/mycarquo/public_html/myelquoto.com.au/uploads/landing_page_files/";
	protected $tradein_photo_base_path     = "/home/mycarquo/public_html/mytradevaluation.com.au/uploads/";
	protected $tradein_photo_base_path_tm  = "/home/mycarquo/public_html/mytradevaluation.com.au/uploads/thumbnails_m/";
	protected $tradein_photo_base_path_ts  = "/home/mycarquo/public_html/mytradevaluation.com.au/uploads/thumbnails_s/";
	protected $tradein_photo_base_url_tm   = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/";
	
	protected $tendering_status_array      = array(3, 4, 5, 6, 7, 8);
	protected $deal_status_array           = array(4, 5, 6, 7, 8);
	protected $deal_approved_status_array  = array(5, 6, 7);
	
	protected $revenue_threshold           = 1005;

	protected $now;

	public function __construct()
	{
		parent::__construct();
	}

	function index ()
	{
		header ("Location: ".site_url());
		exit ();
	}
	
	public function generate_tender_alerts ($user_id) // TEMPLATE // NEW //
	{
		$all_tenders = $this->lead_model->get_all_my_tenders($user_id); // M Array
		return $all_tenders;
	}

	public function get_tender_alert_details () // MODAL VIEW // NEW //
	{
		$input_arr = $this->input->post();
		
		$cheapest_quote = $this->lead_model->get_tender_cheapest_quotes($input_arr['tender_id']); // S Array
		$lead = $this->lead_model->get_lead($cheapest_quote['fk_lead']);
		$make_logo = "http://www.myelquoto.com.au/global_images/makes/".str_replace(' ', '_', strtolower($lead['tender_make'])).".png";

		$quotes = $this->quote_model->get_quotes_final($input_arr['tender_id']); // M Array
		// $email_results = $this->lead_model->get_tender_emails($cheapest_quotes_result['fk_lead']); // M Array
		$lead_events = $this->lead_model->get_lead_events($cheapest_quote['fk_lead']); // M Array
		
		if ($cheapest_quote['lowest_price']=="" OR $cheapest_quote['lowest_price']==0) { $cheapest_quote['lowest_price'] = "N/A"; }
		else { $cheapest_quote['lowest_price'] = number_format($cheapest_quote['lowest_price'], 2); }
		
		if ($cheapest_quote['newest_price']=="" OR $cheapest_quote['newest_price']==0) { $cheapest_quote['newest_price'] = "N/A"; }
		else { $cheapest_quote['newest_price'] = number_format($cheapest_quote['newest_price'], 2); }

		if ($cheapest_quote['lowest_carsales_price']=="" OR $cheapest_quote['lowest_carsales_price']==0) { $cheapest_quote['lowest_carsales_price'] = "N/A"; }
		else { $cheapest_quote['lowest_carsales_price'] = number_format($cheapest_quote['lowest_carsales_price'], 2); }

		if ($cheapest_quote['cheapest_price']=="" OR $cheapest_quote['cheapest_price']==0) { $cheapest_quote['cheapest_price'] = "N/A"; }
		else { $cheapest_quote['cheapest_price'] = number_format($cheapest_quote['cheapest_price'], 2); }		

		// date('d F Y (H:i)', strtotime($cheapest_quote['created_at']))
		
		$cheapest_quote_bg['lowest_price'] = 'bg-primary';
		$cheapest_quote_bg['newest_price'] = 'bg-primary';
		$cheapest_quote_bg['lowest_carsales_price'] = 'bg-danger';
		$cheapest_quote_bg['cheapest_price'] = 'bg-primary';
		
		$html = '
		<div class="col-md-9">
			<section class="panel panel-group">
				<header class="panel-heading bg-primary">
					<div class="widget-profile-info">
						<div class="profile-picture">
							<img src="'.$make_logo.'">
						</div>
						<div class="profile-info">
							<h4 class="name text-weight-semibold" style="margin-bottom: 10px;"><b>'.$lead['name'].'</b></h4>
							<h5 class="role">'.$lead['email'].'</h5>
							<div class="profile-footer">
								'.date('d F Y', strtotime($cheapest_quote['created_at'])).'
							</div>
						</div>
					</div>
				</header>
				<div id="accordion">
					<div class="panel panel-accordion panel-accordion-first">
						<div class="panel-heading" style="border-bottom: 1px solid #ddd;">
							<h4 class="panel-title">
								<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse_1">
									<b>'.$lead['status_text'].'</b>
								</a>
							</h4>
						</div>
						<div id="collapse_1" class="accordion-body collapse in">
							<div class="panel-body">
								<div class="row"> 
									<div class="col-md-12">
										<br />
										<h5 style="margin-bottom: 10px;"><b>Dealer Quotes</b></h5>
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-condensed mb-none">		
												<thead>
													<tr>
														<th>Dealer</th>
														<th>Quote</th>
														<th>Delivery</th>
														<th>Dealer Notes</th>
													</tr>
												</thead>
												<tbody>';
													if (count($quotes)==0)
													{
														$html .= '<tr><td colspan="4"><center>No records found!</center></td></tr>';
													}
													else
													{
														foreach ($quotes AS $quote)
														{
															$html .= '
															<tr>
																<td>'.$quote->manager_name.'</td>
																<td>'.$quote->total.'</td>
																<td>'.date('d F Y', strtotime($quote->delivery_date)).'</td>
																<td>'.nl2br($quote->notes).'</td>							
															</tr>';						
														}							
													}
													$html .= '
												</tbody>
											</table>
										</div>
										<br />
										<hr class="solid mt-sm mb-lg">	
										<h5 style="margin-bottom: 10px;"><b>Events</b></h5>										
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-condensed mb-none">		
												<thead>
													<tr>
														<th>User</th>
														<th>Date</th>
														<th>Time</th>
														<th>Details</th>
													</tr>
												</thead>
												<tbody>';
													if (count($lead_events)==0)
													{
														$html .= '<tr><td colspan="4"><center>No records found!</center></td></tr>';
													}
													else
													{
														foreach ($lead_events AS $lead_event)
														{
															$html .= '
															<tr>
																<td>'.$lead_event['user'].'</td>
																<td>'.date('d F Y', strtotime($lead_event['date'])).'</td>
																<td>'.$lead_event['time'].'</td>
																<td>'.nl2br($lead_event['details']).'</td>							
															</tr>';						
														}
													}
													$html .= '
												</tbody>
											</table>
										</div>
										<br />
										<hr class="solid mt-sm mb-lg">	
										<h5 style="margin-bottom: 10px;"><b>Emails</b></h5>										
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-condensed mb-none">		
												<thead>
													<tr>
														<th>User</th>
														<th>Date</th>
														<th>Time</th>
														<th>Details</th>
													</tr>
												</thead>
												<tbody>';
													$html .= '<tr><td colspan="4"><center>No records found!</center></td></tr>';
													$html .= '
												</tbody>
											</table>
										</div>										
									</div>
								</div>
								<br />
							</div>
						</div>
					</div>	
				</div>
			</section>			
		</div>
		<div class="col-md-3">
			<div class="panel-body '.$cheapest_quote_bg['lowest_price'].'">
				<div class="widget-summary widget-summary-sm">
					<div class="widget-summary-col widget-summary-col-icon">
						<div class="summary-icon">
							<i class="fa fa-life-ring"></i>
						</div>
					</div>
					<div class="widget-summary-col">
						<div class="summary">
							<h4 class="title">Lowest Quote</h4>
							<div class="info">
								<strong class="amount">'.$cheapest_quote['lowest_price'].'</strong>
							</div>
						</div>
						<div class="summary-footer">
							<a class="text-uppercase">(view all)</a>
						</div>
					</div>
				</div>
			</div>
			<br />
			<div class="panel-body '.$cheapest_quote_bg['newest_price'].'">		
				<div class="widget-summary widget-summary-sm">
					<div class="widget-summary-col widget-summary-col-icon">
						<div class="summary-icon">
							<i class="fa fa-life-ring"></i>
						</div>
					</div>
					<div class="widget-summary-col">
						<div class="summary">
							<h4 class="title">Newest Quote</h4>
							<div class="info">
								<strong class="amount">'.$cheapest_quote['newest_price'].'</strong>
							</div>
						</div>
						<div class="summary-footer">
							<a class="text-uppercase">(view all)</a>
						</div>
					</div>
				</div>	
			</div>
			<br />
			<div class="panel-body '.$cheapest_quote_bg['lowest_carsales_price'].'">		
				<div class="widget-summary widget-summary-sm">
					<div class="widget-summary-col widget-summary-col-icon">
						<div class="summary-icon">
							<i class="fa fa-life-ring"></i>
						</div>
					</div>
					<div class="widget-summary-col">
						<div class="summary">
							<h4 class="title">Cheapest Carsales</h4>
							<div class="info">
								<strong class="amount">'.$cheapest_quote['lowest_carsales_price'].'</strong>
							</div>
						</div>
						<div class="summary-footer">
							<a class="text-uppercase">(view all)</a>
						</div>
					</div>
				</div>	
			</div>
			<br />
			<div class="panel-body '.$cheapest_quote_bg['cheapest_price'].'">		
				<div class="widget-summary widget-summary-sm">
					<div class="widget-summary-col widget-summary-col-icon">
						<div class="summary-icon">
							<i class="fa fa-life-ring"></i>
						</div>
					</div>
					<div class="widget-summary-col">
						<div class="summary">
							<h4 class="title">All-Time Cheapest</h4>
							<div class="info">
								<strong class="amount">'.$cheapest_quote['cheapest_price'].'</strong>
							</div>
						</div>
						<div class="summary-footer">
							<a class="text-uppercase">(view all)</a>
						</div>
					</div>
				</div>	
			</div>
		</div>';
		
		echo $html;
	}	
	
	public function substring_index ($subject, $delim, $count)
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

	public function cq_date_format ($date_string)
	{
		$date = date_create($date_string);
		return date_format($date, 'd F Y');
	}

	public function date_difference_text ($date_difference_count)
	{
		if ($date_difference_count == 0) { $date_difference_text = "today"; }
		else if ($date_difference_count == 1) { $date_difference_text = abs($date_difference_count)." day from now"; }
		else if ($date_difference_count > 1) { $date_difference_text = abs($date_difference_count)." days from now"; }
		else if ($date_difference_count == -1) { $date_difference_text = abs($date_difference_count)." day ago"; }
		else if ($date_difference_count < -1) { $date_difference_text = abs($date_difference_count)." days ago"; }
		
		return $date_difference_text;
	}

	public function date_difference_count ($date_string)
	{
		$now = time();
		$date = strtotime($date_string);
		$date_difference = $date - $now;
		$date_difference_count = (floor($date_difference / (60 * 60 * 24)) + 1);
		
		return $date_difference_count;
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

	protected function templated_special_email_init ($email_template_id, $lead_id, $from, $to, $file = "") // Lead Special
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

		$this->send_templated_email($from_email, $from_name, $to, $subject, $content, $file);
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

	public function changed_fields ($db_arr, $post_arr, $exceptions_arr = array())
	{
		$changed_fields_arr = [];
		$changed_fields_string = "";
		foreach ($post_arr AS $field => $value)
		{
			if (!in_array($field, $exceptions_arr))
			{
				if (isset($db_arr[$field]))
				{
					if ($db_arr[$field] != $value)
					{
						$changed_fields_arr[] = array("field" => $field, "value_from" => $db_arr[$field], "value_to" => $value);
					}					
				}
			}
		}
		if (count($changed_fields_arr) <> 0)
		{
			$changed_fields_string = json_encode($changed_fields_arr, JSON_HEX_QUOT);
		}
		return $changed_fields_string;
	}

	public function changed_fields_array ($db_arr, $post_arr, $exceptions_arr = array())
	{
		$changed_fields_arr = [];
		$changed_fields_string = "";
		foreach ($post_arr AS $field => $value)
		{
			if (!in_array($field, $exceptions_arr))
			{
				if (isset($db_arr[$field]))
				{
					if ($db_arr[$field] != $value)
					{
						$changed_fields_arr[] = array("field" => $field, "value_from" => $db_arr[$field], "value_to" => $value);
					}					
				}
			}
		}
		return $changed_fields_arr;
	}
	
	public function email_test ($email_template_id)
	{
		$data = $this->data;

		$email_template = $this->settings_model->get_email_template($email_template_id);
		$subject = $email_template['subject'];
		$content = $email_template['content'];
		$this->send_templated_email($this->settings['company_email'], $this->settings['company_name'], $data['username'], $subject, $content, "");
	}

	public function calculate_deal ($input_arr, $type = 1)
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

		// Stamp Duty OLD (Start) //
		if ($registration_type == "TPI/Gold Card")
		{
			$stamp_duty = 0;
		}
		else
		{
			if ($client_state == "NSW" OR $client_state == "ACT")
			{
				$partial_subtotal_5 = $sales_price - $lct - $registration - $ctp - $premium_plate_fee;
				$index = 0;
				$stamp_duty = 0;
				while (($index + $stamp_duty) < $partial_subtotal_5)
				{
					if ($index < 45000)
					{
						$stamp_duty += 3;
					}
					else
					{
						$stamp_duty += 5;
					}
					$index += 100;
				}
			}
			else if ($client_state == "VIC")
			{
				if ($subtotal_3 >= 57466)
				{
					$stamp_duty = ($subtotal_3 * 0.05); 
				}
				else
				{
					$stamp_duty = ($subtotal_3 * 0.025); 
				}
			}
			else if ($client_state == "QLD")
			{
				$stamp_duty = ($rrp * 0.03);
			}
			else if ($client_state == "SA")
			{
				$stamp_duty = (($subtotal_3 - 3000) * 0.04) + 60;
			}
			else if ($client_state == "WA")
			{
				if ($rrp >= 50000)
				{
					$stamp_duty = $rrp * 0.065;
				}
				else if ($rrp >= 25000)
				{
					$stamp_duty = floor(((round(((($rrp - 25000) / 6666.66) + 2.75), 2) / 100) * $rrp) / 0.05) * 0.05;
				}
				else
				{
					$stamp_duty = $rrp * 0.0275;
				}
			}
			else if ($client_state == "TAS")
			{
				if ($subtotal_3 >= 40000)
				{
					$stamp_duty = $subtotal_3 * 0.04;
				}						
				else if ($subtotal_3 >= 35000)
				{
					$stamp_duty = (($subtotal_3 - 3500) * 0.11) + 1050;
				}
				else
				{
					$stamp_duty = $subtotal_3 * 0.03;
				}
			}
			else if ($client_state == "NT")
			{
				$stamp_duty = ($subtotal_3 * 0.03);
			}					
		}
		// Stamp Duty OLD (End) //

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
	
	public function calculate_dealer_invoice ($lead_arr, $revenue_arr, $deposits_arr, $refunds_arr, $deposit_trans_arr)
	{
		$cq_number = $lead_arr['cq_number'];	
		$client_name = $lead_arr['name'];
		$tender_make = $lead_arr['tender_make'];	
		$tender_model = $lead_arr['tender_model'];	
		$tender_variant = $lead_arr['tender_variant'];			
		
		$sales_price = $lead_arr['sales_price'];		
		$winning_price = $lead_arr['winning_price'];
		$dealer_changeover = $lead_arr['dealer_changeover'];
		$deposits_total = $lead_arr['shown_deposits_total'];
		$refunds_total = $lead_arr['shown_refunds_total'];
		$deposit_trans_total = $lead_arr['shown_deposit_trans_total'];
		$other_costs_amount = $lead_arr['other_costs_amount'];
		$deduct_to_dealer_invoice = $lead_arr['deduct_to_dealer_invoice'];
		$deposit_show_status = $lead_arr['deposit_show_status'];

		$tradein_count = $lead_arr['tradein_count'];
		$trade_buyer_type = $lead_arr['trade_buyer_type'];

		$client_balance = $revenue_arr['balance'];
		$changeover = $revenue_arr['changeover'];
		
		$line_item_1_description = $cq_number.": ".$client_name."<br />".$tender_make." ".$tender_model." ".$tender_variant;			
		
		if ($tradein_count==0)
		{
			$line_item_1_amount_aud = $sales_price - $winning_price;
		}
		else
		{
			if ($trade_buyer_type=="Wholesaler" OR $trade_buyer_type=="Quote Me")
			{
				if ($client_balance < $winning_price)
				{
					$line_item_1_amount_aud = $deposits_total - $refunds_total;
				}
				else
				{
					$line_item_1_amount_aud = $deposits_total - $refunds_total + ($client_balance - $winning_price);
				}
			}
			else
			{
				$line_item_1_amount_aud = $changeover - $dealer_changeover;
			}	
		}

		if ($deduct_to_dealer_invoice==1)
		{
			$line_item_1_amount_aud = $line_item_1_amount_aud - $other_costs_amount;
		}

		if ($deposit_show_status==1)
		{
			$balance_payable = $line_item_1_amount_aud - ($deposits_total - $refunds_total - $deposit_trans_total);	
		}
		else
		{
			$balance_payable = $line_item_1_amount_aud;
		}
		$gst = $line_item_1_amount_aud / 11;
		$line_item_1_unit_price = $line_item_1_amount_aud - $gst;
		
		$line_items_arr = [];
		
		$line_items_arr[] = array(
			'description' => $line_item_1_description,
			'quantity' => '1',
			'unit_price' => round($line_item_1_unit_price, 2),
			'gst' => '10%',
			'amount_aud' => round($line_item_1_amount_aud, 2),
			'tax_type' => 'OUTPUT',
			'account_code' => '200'
		);
		
		foreach ($deposits_arr AS $deposit)
		{
			if ($deposit['show_status']==1)
			{
				if ($deposit['payment_date'] == "")
				{
					$payment_date = ""; 
				}
				else
				{
					$payment_date = date('d F Y', strtotime($deposit['payment_date'])); 
				}

				$line_items_arr[] = array(
					'description' => "Deposit Made: ".$payment_date."<br />Reference #: ".$deposit['reference_number'],
					'quantity' => '1',
					'unit_price' => round(($deposit['amount']*(-1)), 2),
					'gst' => '',
					'amount_aud' => round(($deposit['amount']*(-1)), 2),
					'tax_type' => 'OUTPUT',
					'account_code' => '810'
				);
			}
		}
		
		foreach ($refunds_arr AS $refund)
		{
			if ($refund['show_status']==1)
			{
				if ($refund['payment_date'] == "")
				{
					$payment_date = ""; 
				}
				else
				{
					$payment_date = date('d F Y', strtotime($refund['payment_date'])); 
				}

				$line_items_arr[] = array(
					'description' => "Refund Made: ".$payment_date."<br />(".$refund['reference_number'].")",
					'quantity' => '1',
					'unit_price' => round($refund['amount'], 2),
					'gst' => '',
					'amount_aud' => round($refund['amount'], 2),
					'tax_type' => 'OUTPUT',
					'account_code' => '810'
				);
			}
		}

		foreach ($deposit_trans_arr AS $deposit_tran)
		{
			if ($deposit_tran['show_status']==1)
			{
				if ($deposit_tran['payment_date'] == "")
				{
					$payment_date = ""; 
				}
				else
				{
					$payment_date = date('d F Y', strtotime($deposit_tran['payment_date'])); 
				}

				$line_items_arr[] = array(
					'description' => "Eft made to Dealer: ".$payment_date."<br />Reference: ".$deposit_tran['reference_number'],
					'quantity' => '1',
					'unit_price' => round($deposit_tran['amount'], 2),
					'gst' => '',
					'amount_aud' => round($deposit_tran['amount'], 2),
					'tax_type' => 'OUTPUT',
					'account_code' => '810'
				);
			}
		}
	
		$output_arr = array(
			'line_items' => $line_items_arr,
			'gst' => round($gst, 2),
			'balance_payable' => round($balance_payable, 2)
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
	
	public function calculate_revenue ($input_arr)
	{
		$membership_fee = $input_arr['gross_subtractor'];
		$membership_fee_lower = $input_arr['gross_subtractor_lower'];

		$dqp = $input_arr['winning_price'];
		$dealer_tradein_count = $input_arr['dealer_tradein_count'];
		$dealer_tradein_value = $input_arr['dealer_tradein_value'];
		$dealer_tradein_payout = $input_arr['dealer_tradein_payout'];
		$dealer_client_refund = $input_arr['dealer_client_refund'];
		$dealer_changeover = $input_arr['dealer_changeover'];
		
		$sales_price = $input_arr['sales_price'];
		$tradein_value = $input_arr['tradein_value'];
		$tradein_given = $input_arr['tradein_given'];
		$tradein_payout = $input_arr['tradein_payout'];
		$deposits_total = $input_arr['deposits_total'];
		$refunds_total = $input_arr['refunds_total'];
		$deposit_trans_total = $input_arr['deposit_trans_total'];
		$transport_cost = $input_arr['transport_cost'];
		$other_costs_amount = $input_arr['other_costs_amount'];
		$other_qs_revenue_amount = $input_arr['other_qs_revenue_amount'];
		$other_revenue_amount = $input_arr['other_revenue_amount'];
		$aftersales_accessory_revenue = $input_arr['aftersales_accessory_revenue'];

		$balance = $sales_price - $tradein_given + $tradein_payout - $deposits_total + $refunds_total;
		$changeover = $sales_price - $tradein_given + $tradein_payout;

		if ($dealer_tradein_count <> 0 AND $dealer_tradein_count <> "")
		{
			$price_difference = $changeover - $dealer_changeover;
			$revenue = $changeover - $dealer_changeover - $transport_cost - $other_costs_amount + $aftersales_accessory_revenue + $other_qs_revenue_amount + $other_revenue_amount;
			
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
			$revenue = $sales_price + ($tradein_value - $tradein_given) - $dqp - $transport_cost - $other_costs_amount + $aftersales_accessory_revenue + $other_qs_revenue_amount + $other_revenue_amount;
			
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

		if ($input_arr['tradein_count']==0)
		{
			$dealer_balance = $input_arr['sales_price'] - $input_arr['winning_price'];
		}
		else
		{
			if ($input_arr['trade_buyer_type']=="Wholesaler" OR $input_arr['trade_buyer_type']=="Quote Me")
			{
				if ($balance < $dqp)
				{
					$dealer_balance = $deposits_total - $refunds_total;
				}
				else
				{
					$dealer_balance = $deposits_total - $refunds_total + ($balance - $dqp);
				}
			}
			else
			{
				$dealer_balance = $changeover - $dealer_changeover;
			}	
		}

		if ($input_arr['deposit_show_status']==1)
		{
			$dealer_balance = $dealer_balance - ($deposits_total - $refunds_total - $deposit_trans_total);	
		}
		else
		{
			$dealer_balance = $dealer_balance;
		}
		
		if ($input_arr['deduct_to_dealer_invoice']==1)
		{
			$dealer_balance = $dealer_balance - $input_arr['other_costs_amount'];
		}		

		$output_arr = array(
			'dealer_balance' => round($dealer_balance, 2),
			'balance' => round($balance, 2),
			'price_difference' => round($price_difference, 2),
			'changeover' => round($changeover, 2),
			'revenue' => round($revenue, 2),
			'commissionable_gross' => round($commissionable_gross, 2)
		);

		return $output_arr;
	}

	public function random_string ($random_string_length = 5)
	{
		$characters = 'abcdefghijklmnopqrstuvwxyz0123456789'; 
		$string = '';
		$max = strlen($characters) - 1;
		for ($i = 0; $i < $random_string_length; $i++) 
		{
			$string .= $characters[mt_rand(0, $max)];
		}
		return $string;
	}
	
	public function send_sms ($data = [])
	{
		MessageMedia\RESTAPI\Configuration::getDefaultConfiguration()->setUsername('yehyz9q44FnfCbfOJnNk'); //username
		MessageMedia\RESTAPI\Configuration::getDefaultConfiguration()->setPassword('3FcBWDsXxMMDe9uI0329jRCC7XT5r2'); //password

		$api_instance = new MessageMedia\RESTAPI\Api\MessagingApi();
		$message = new \MessageMedia\RESTAPI\Model\NewMessage(array(
			'content'            => $data['content'], //message maximum of 160 characters
			'source_number'      => $data['source_number'], // number of sender
			'destination_number' => $data['destination_number'], // destination
			'format'             => 'SMS'
		));
		$messages = new \MessageMedia\RESTAPI\Model\Messages(array('messages' => array($message)));

		try {
		    $result = $api_instance->sendMessages($messages);
		} catch (Exception $e) {
		    echo 'Exception when calling MessagingApi->sendMessages: ', $e->getMessage(), PHP_EOL;
		}
	}

	public function export_csv ($data = [], $file_name = "") //pass an array of data as a result from a query, this automatically output a download file
	{
		$filename = $file_name . " - " . date('Y-m-d') . ".csv";

		header('Content-Type: text/csv; charset=UTF-8');
		header("Cache-Control: no-store, no-cache");  
		header("Content-Disposition: attachment;filename=". $filename);

		echo $this->array2csv($data);
	}
	
	public function import_csv_1 () // use this when you want to accept a post data with file upload
	{
		if(isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0)
		{
			$file      = $_FILES['csv_file'];
			$file_path = $file['tmp_name'];

			$csv_data = $this->csv_to_array($file_path);

			$clean_array = [];

			$fields = [];

			$fields = $csv_data[0];

			foreach($csv_data as $key => $data)
			{
				if($key == 0)
					continue;

				$temp_array = [];
				foreach ($data as $k => $v) 
				{
					$temp_array[$fields[$k]] = trim(striptags($v));
				}

				$clean_array[] = $temp_array;
			}

			//you can now use clean_array for insertion to database.
		}
		else
			show_404('page', FALSE);
	}
	
	public function import_csv_2 ($_FILE = []) // use this inside a function, just pass the $_FILE you got from post. this returns an array of data to be used for inserting
	{

		$file      = $_FILES['csv_file'];
		$file_path = $file['tmp_name'];

		$csv_data = $this->csv_to_array($file_path);

		$clean_array = [];

		$fields = [];

		$fields = $csv_data[0];

		foreach($csv_data as $key => $data)
		{
			if($key == 0)
				continue;

			$temp_array = [];
			foreach ($data as $k => $v) 
			{
				$temp_array[$fields[$k]] = trim(striptags($v));
			}

			$clean_array[] = $temp_array;
		}

		return $clean_array;
	}

	public function csv_to_array ($file)
    {
        if(($handle = fopen($file, 'r')) !== FALSE)
        {
            $array = array();

            while(!feof($handle))
            {
                $array[] = fgetcsv($handle, 0);
            }

            return $array;
        }
    }

    public function array2csv ($array)
    {
       if (count($array) == 0) {
         return null;
       }

       ob_start();

       $df = fopen("php://output", 'w');

       fputcsv($df, array_keys(reset($array)));

       foreach ($array as $row)
       {
          fputcsv($df, $row);
       }

       fclose($df);

       return ob_get_clean();
    }

	protected function send_to_many ($from_email, $from_name, $user_type, $subject, $content, $file = "")
	{
		date_default_timezone_set('Australia/Sydney');
		ini_set('max_execution_time', -1);	
		$now = date("Y-m-d H:i:s");
		$complete_email = $this->email_header.$content.$this->email_footer;

		$result = $this->user_model->get_user_with_type($user_type);
                $this->load->library('email');
		foreach ($result as $key => $val) 
		{
			$this->email->clear();
			$this->email->set_mailtype('html');

			$this->email->to($val);

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
	}
}
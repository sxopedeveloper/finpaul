<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('eway.php');

class User_main extends Eway
{
	protected $data = [];
	protected $settings = [];
	protected $dynamic_fields = [];
	protected $email_header = "";
	protected $email_footer = "";
	protected $email_signature = "";
	protected $pdf_header = "";
	protected $pdf_footer = "";	
	protected $base_path = "/home/mycarquo/public_html/myelquoto.com.au/";
	protected $landing_page_file_base_path = "/home/mycarquo/public_html/myelquoto.com.au/uploads/landing_page_files/";
	protected $tradein_photo_base_path = "/home/mycarquo/public_html/mytradevaluation.com.au/uploads/";
	protected $tradein_photo_base_path_tm = "/home/mycarquo/public_html/mytradevaluation.com.au/uploads/thumbnails_m/";
	protected $tradein_photo_base_path_ts = "/home/mycarquo/public_html/mytradevaluation.com.au/uploads/thumbnails_s/";
	protected $tradein_photo_base_url_tm = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/";

	protected $tendering_status_array = array(3, 4, 5, 6, 7, 8);
	protected $deal_status_array = array(4, 5, 6, 7, 8);
	protected $deal_approved_status_array = array(5, 6, 7);	

	protected $revenue_threshold = 1000;

	public function __construct()
	{
		parent::__construct();

		if ($this->session->userdata('logged_in'))
		{
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
			$this->load->model('squareup_model');
			$this->load->model('google_ad_model');			

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
									
									<p style="background: #58c603; color: #ffffff; padding: 3px 15px; font-size: 1.0em; color: #ffffff; margin-top: 5px; margin-bottom: 20px;">
										<b>
											'.$this->settings['company_name'].' Hotline | 
											'.$this->settings['company_phone'].' | 
											<a href="mailto:'.$this->settings['company_email'].'">
												<span style="color: #ffffff; text-decoration: none;">info</span>
												<span style="color: #ffffff; text-decoration: none;">@'.$this->settings['company_short_url'].'</span>
											</a>
										</b>
									</p>
								</td>
							</tr>
							<tr>
								<td align="left" style="padding: 15px 30px 15px 30px; color: #484848;">';
								/*
								<a href="'.$this->settings['company_url'].'" rilt="Header_Logo" target="_blank" style="text-decoration: none;">
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

			/*
			$this->pdf_footer = '
			<div style="text-align: left;" >
				<hr style="clear: both; color: #58C603; background-color: #58C603; height: 2px; border-width: 0;">
				<table class="content" width="70%">
					<tbody>
						<tr>
							<td>
								<img src="http://www.myelquoto.com.au/assets/img/phone_icon.jpg" width="12px" height="12px">'.$this->settings['company_phone'].'<br/>
								<img src="http://www.myelquoto.com.au/assets/img/globe_icon.jpg" width="12px" height="12px">'.$this->settings['company_email'].'<br/>
								<img src="http://www.myelquoto.com.au/assets/img/globe_icon.jpg" width="12px" height="12px">'.$this->settings['company_short_url'].'<br/>
							</td>
							<td>
								<img src="http://www.myelquoto.com.au/assets/img/pointer.jpg" width="12px" height="12px">'.$this->settings['company_address_line_1'].'<br/>
								&nbsp;&nbsp;&nbsp;&nbsp;'.$this->settings['company_address_line_2'].'<br/>
								&nbsp;&nbsp;&nbsp;&nbsp;'.$this->settings['company_suburb'].' '.$this->settings['company_state'].' '.$this->settings['company_postcode'].'
							</td>
						</tr>
					</tbody>
				</table>
			</div>';
			*/

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

			$balance = 0;
			$user = $this->user_model->get_user_balance($this->session->userdata('user_id'));
			if (isset($user['balance'])) { $balance = $user['balance']; }
			$this->data = array(
				'logged_in' => $this->session->userdata('logged_in'),
				'login_type' => $this->session->userdata('login_type'),
				'admin_type' => $this->session->userdata('admin_type'),
				
				'user_id' => $this->session->userdata('user_id'),
				'username' => $this->session->userdata('username'),
				'user_image' => $this->profile_model->profile_picture( $this->session->userdata('user_id') ),
				'name' => $this->session->userdata('name'),
				
				'phone' => $this->session->userdata('phone'),
				'mobile' => $this->session->userdata('mobile'),
				'state' => $this->session->userdata('state'),
				'postcode' => $this->session->userdata('postcode'),
				'status' => $this->session->userdata('status'),

				'company' => $this->settings,				
				'bank_accounts' => $this->settings_model->get_bank_accounts(),
				
				'makes' => $this->car_model->get_makes(),
				'ticket_types' => $this->ticket_model->get_ticket_types(),
				'modules' => $this->ticket_model->get_modules(),
				'admins' => $this->user_model->get_admins(),
				'payment_types' => $this->payment_model->get_payment_types(),
				
				'tender_alerts' => $this->generate_tender_alerts($this->session->userdata('user_id')),
				'balance' => $balance
			);
		}
		else
		{
			header("Location: " . site_url('login'));
			exit();
		}
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
			if ($input_arr['trade_buyer_type']=="Wholesaler" OR $input_arr['trade_buyer_type']=="Company")
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
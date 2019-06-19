<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('admin_main.php');
require_once('xero.php');
ob_start();
class Deal extends Admin_main 
{
	function __construct()
	{
		parent::__construct(); // $this->load->library('squareup');
	}

	function index ()
	{
		header("Location: " . site_url('deal/list_view'));
		exit();
	}
	
	public function list_view ($start = 0) // PAGE VIEW //
	{
		$data = $this->data;
		$data['title'] = 'Deals - List View';

		//$limit = 20;
		$count_result = $this->lead_model->get_deals_count($_GET, $data['user_id'], $data['admin_type']);  // Record count
	$data['leads'] = $this->lead_model->get_deals($_GET, $data['user_id'], $data['admin_type'], $start, $limit); //MainQuery

	

//echo json_encode($data['leads']); die();
		$data['admins'] = $this->user_model->get_admins();
		$data['dealers'] = $this->user_model->get_dealers_all();
		$data['payment_types'] = $this->payment_model->get_payment_types();
		$data['bank_accounts'] = $this->settings_model->get_bank_accounts();

		// $this->load->library('pagination');
		// $config['base_url'] = site_url('deal/list_view/');
		// $config['total_rows'] = $count_result['cnt'];
		// $config['per_page'] = $limit;
		// $this->pagination->initialize($config);
		// $data['links'] = $this->pagination->create_links();

		$data['session_data'] = $this->data;
		$data['result_count'] = $count_result['cnt'];
		foreach ($data['leads'] as $key => $val) 
		{
			$att_flag = 0;
			$att_flag = $this->lead_model->get_attachment_flag($val->lead_id);
			$data['leads'][$key]->attachment_flag = $att_flag;
		}
//echo json_encode($data['admins']); 
//echo json_encode($data['leads']); 
//echo json_encode($data['leads']); die();
		$this->load->view('admin/deals', $data);	
	}
	
	public function tile_view ($start = 0) // PAGE VIEW //
	{
		$data = $this->data;
		$data['title'] = 'Deals - Tile View';
		$data['session_data'] = $this->data;
		
		$_GET['status'] = isset($_GET['status']) ? $_GET['status'] : '4';
		
		$limit = 10;
		$summary_result = $this->lead_model->get_deals_tile_summary($_GET, $data['user_id'], $data['admin_type']);  // Record count
		$count_result = $this->lead_model->get_deals_tile_count($_GET, $data['user_id'], $data['admin_type']);  // Record count
		$data['deals'] = $this->lead_model->get_deals_tile($_GET, $data['user_id'], $data['admin_type'], $start, $limit); // Main Query
		$data['payment_types'] = $this->payment_model->get_payment_types();
		$data['bank_accounts'] = $this->settings_model->get_bank_accounts();

		$total_revenue = 0;
		$total_commissionable_gross = 0;
		$total_balcqo = 0;
		$total_payments = 0;
		$total_remaining_balance = 0;
		foreach ($summary_result AS $summary_field)
		{
			$total_revenue += $summary_field['revenue'];
			$total_commissionable_gross += $summary_field['commissionable_gross'];
			$total_balcqo += $summary_field['balcqo'];
			$total_payments += $summary_field['payments'];
		}
		$total_remaining_balance = $total_balcqo - $total_payments;
		
		$data['total_revenue'] = $total_revenue;
		$data['total_commissionable_gross'] = $total_commissionable_gross;
		$data['total_balcqo'] = $total_balcqo;
		$data['total_payments'] = $total_payments;
		$data['total_remaining_balance'] = $total_remaining_balance;

		$this->load->library('pagination');
		$config['base_url'] = site_url('deal/tile_view/');
		$config['total_rows'] = $count_result['cnt'];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);
		$data['links'] = $this->pagination->create_links();
		$data['result_count'] = $count_result['cnt'];

		$this->load->view('admin/deals_tile', $data);	
	}	

	public function submit_deal_modal ($lead_id)
	{
		$requirements = $this->lead_model->get_deal_requirements($lead_id);
		
		$status = 1;
		$requirements_html = '';
		if ($requirements['winning_quote'] == 0 OR $requirements['winning_quote'] == "")
		{
			$status = 0;
			$requirements_html .= '
			<div class="alert alert-danger fade in nomargin">
				There is no <b>winning quote</b> selected!
			</div>';
		}
		
		if ($requirements['attached_tradein_count'] > 0 AND ($requirements['tradein_buyer'] == "" OR $requirements['tradein_buyer'] == 0))
		{
			$status = 0;
			$requirements_html .= '
			<div class="alert alert-info fade in nomargin">
				There is no nominated <b>buyer of the tradein</b>!
			</div>';			
		}		
		
		if ($requirements['delivery_date'] == "" OR $requirements['delivery_address'] == "")
		{
			$status = 0;
			$requirements_html .= '
			<div class="alert alert-danger fade in nomargin">
				The <b>delivery details</b> is incomplete!
			</div>';			
		}
		
		if ($requirements['name'] == "" OR $requirements['email'] == "" OR $requirements['state'] == "" OR $requirements['postcode'] == "" OR $requirements['address'] == "")
		{
			$status = 0;
			$requirements_html .= '
			<div class="alert alert-danger fade in nomargin">
				The <b>client details</b> is incomplete!
			</div>';
		}
		
		if ($requirements['suggested_tradein_count'] > $requirements['attached_tradein_count'])
		{
			$requirements_html .= '
			<div class="alert alert-info fade in nomargin">
				There are suggested tradeins that are not attached to the deal!
			</div>';			
		}

		if ($requirements['state'] == "ACT" AND $requirements['answer_act'] == "")
		{	
			$status = 0;
			$requirements_html .= '
			<div class="alert alert-danger fade in nomargin">
				The <b>Vehicle Type</b> (under the Computation Details) is missing!
			</div>';
		}
		
		if ($requirements['state'] == "VIC" AND $requirements['answer_vic'] == "")
		{	
			$status = 0;
			$requirements_html .= '
			<div class="alert alert-danger fade in nomargin">
				The <b>Vehicle Type</b> (under the Computation Details) is missing!
			</div>';
		}
		
		if ($requirements['state'] == "QLD" AND $requirements['answer_qld'] == "")
		{	
			$status = 0;
			$requirements_html .= '
			<div class="alert alert-danger fade in nomargin">
				The <b>Vehicle Type</b> (under the Computation Details) is missing!
			</div>';
		}
		
		// if ($requirements['deposit'] == 0 OR $requirements['deposit'] == "")
		// {
		// 	$status = 0;
		// 	$requirements_html .= '
		// 	<div class="alert alert-danger fade in nomargin">
		// 		Please fill in the <b>Deposit</b> field under the Computation Section
		// 	</div>';
		// }
		
		if ($requirements['transport'] == 0 OR $requirements['transport'] == "")
		{
			$status = 0;
			$requirements_html .= '
			<div class="alert alert-danger fade in nomargin">
				Please fill in the <b>Transport</b> field under the Computation Section
			</div>';
		}
		
		if ($status == 0)
		{
			$requirements_html .= ' 
			The deal cannot be submitted yet! Please complete all the requirements first.<br /><br />
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>';
		}
		else
		{
			$requirements_html .= ' 
			Congratulations! All the requirements for Deal submission is complete.<br /><br />
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			<button type="button" class="btn btn-primary" onclick="submit_deal('.$lead_id.')">Submit</button>';			
		}

		$requirements_arr = array(
			"requirements_html" => $requirements_html
		);
		echo json_encode($requirements_arr);		
	}
	
	public function balcqo_modal ($lead_id) // TO BE DELETED //
	{
		$balcqo_figure = 0.00;
		$balcqo_revenue = 0.00;

		$data = $this->data;
		$balcqo = $this->lead_model->get_lead_balcqo_details($lead_id);
		$payments = $this->payment_model->get_payments($lead_id);
		$invoices = $this->invoice_model->get_invoices($lead_id);		
		$eway_tokens = $this->payment_model->get_eway_tokens($lead_id);

		$eway_token_html = "";
		if (count($eway_tokens) > 0)
		{
			foreach ($eway_tokens as $token_key => $token_value) 
			{
				$radio_value = $token_key + 1;
				$eway_token_html .= '
				<tr class="parent_tr">
					<td>
						<center>
							<input type="radio" name="token_id" class="token_id" value="'.$token_value['id'].'">
						</center>
					</td>
					<td>'.$token_value['first_name'].' '.$token_value['last_name'].'</td>
					<td class="child_td" data-id='.$token_value['id'].'>
						************'.$token_value['cc_ending'].'
					</td>
					<td>'.$token_value['exp_month'].'/'.$token_value['exp_year'].'</td>
				</tr>';
			}
		}
		else
		{
			$eway_token_html .= '
			<tr id="eway_token_no_records">
				<td colspan="4" align="center"><br /><p><i>No records found!</i></p></td>
			</tr>';
		}

		$received = 0;
		$remaining_balance = 0;
		$actions_html = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
		$payments_html = "";
		if (count($payments) == 0)
		{
			$payments_html .= '
			<tr id="payment_no_records">
				<td colspan="16"><center>No records found!</center></td>
			</tr>';
		}
		else
		{
			foreach ($payments AS $payment)
			{
				$payment_method = "";
				$edit_btn_hidden = "";
				$delete_btn_hidden = "";
				$refund_btn_hidden = "";
				$refunded = "";

				if ($payment->fk_transaction==0)
				{
					$payment_method = "External";
					$edit_btn_hidden = "";
					$delete_btn_hidden = "";
					$refund_btn_hidden = "hidden";					
				}
				else
				{
					$payment_method = "Credit Card";
					$edit_btn_hidden = "hidden";
					$delete_btn_hidden = "hidden";
					$refund_btn_hidden = "";					
					
					// if($payment->refund_status == 0)
					// {
						// $refunded = "";
					// }
					// else
					// {
						// $refund_btn_hidden = "hidden";
						// $refunded = $payment->refund_date;
					// }					
				}

				if($payment->fk_payment_type == 7)
				{
					$refund_btn_hidden = "hidden";
				}

				// Shown or Hidden on Paperworks //
				$show_class = "";
				$show_text = "";				
				if($payment->show_status == 1)
				{
					$show_class = "fa-eye-slash";
					$show_text  = "Shown";
					$show_title  = "Hide this payment on the paperworks";
				}
				else
				{
					$show_class = "fa-eye";	
					$show_text  = "Hidden";
					$show_title  = "Show this payment on the paperworks";
				}
				// (End) Shown or Hidden on Paperworks //

				//verified or unverified//
				$status_class = "";
				$status_text = "";				
				if($payment->status_id == 1)
				{
					$status_class = "fa-times-circle";
					$status_text  = "Verified";
					$status_title  = "Unverify this payment";
				}
				else
				{
					$status_class = "fa-check-circle";
					$status_text  = "Unverified";
					$status_title  = "Verify this payment";
				}
				//end verified or unverified//

				$payments_html .= '
				<tr id="payment_tr_'.$payment->id_payment.'">
					<td align="center">
						<a href="#" onclick="delete_payment('.$payment->id_payment.')" '.$delete_btn_hidden.' data-toggle="tooltip" data-placement="top" title="Delete Payment">
							<i class="fa fa-trash-o"></i>
						</a>
					</td>
					<td align="center">
						<a href="#" class="open-edit-payment" data-payment_id="'.$payment->id_payment.'" '.$edit_btn_hidden.' data-toggle="tooltip" data-placement="top" title="Edit Payment">
							<i class="fa fa-pencil-square-o"></i>
						</a>
					</td>
					<td align="center">
						<a href="#" class="open-refund-payment" data-payment_id="'.$payment->id_payment.'" '.$refund_btn_hidden.' data-toggle="tooltip" data-placement="top" title="Refund Payment">
							<i class="fa fa-reply"></i>
						</a>
					</td>
					<td align="center">
						<a href="#" class="show_btn" data-idpayment="'.$payment->id_payment.'" data-showstatus="'.$payment->show_status.'" data-toggle="tooltip" data-placement="top" title="'.$show_title.'">
							<i class="show-icon fa '.$show_class.'"></i>
						</a>
					</td>
					<td align="center">
						<a href="#" class="verify_btn" data-idpayment="'.$payment->id_payment.'" data-status="'.$payment->status_id.'" data-toggle="tooltip" data-placement="top" title="'.$status_title.'">
							<i class="status-icon fa '.$status_class.'"></i>
						</a>
					</td>
					<td class="payment_type_td">'.$payment->payment_type.'</td>
					<td>'.$payment_method.'</td>
					<td class="referencet_td">'.$payment->reference_number.'</td>
					<td>'.$payment->user.'</td>
					<td id="payment_amount_td_'.$payment->id_payment.'" align="right" class="payment_amount_td"> '.$payment->amount.'</td>
					<td class="admin_fee" align="right"> '.$payment->admin_fee.'</td>
					<td class="payment_date_td">'.$payment->payment_date.'</td>
					<td>'.$payment->refunds_total.'</td>
					<td>'.$payment->parent_reference_number.'</td>
					<td class="merchant_cost_td">'.$payment->merchant_cost.'</td>
					<td class="status_text">'.$payment->status.'</td>
					<td class="show_text">'.$show_text.'</td>
				</tr>';
				$received += $payment->amount;
			}
		}

		$invoices_html = "";
		if (count($invoices) == 0)
		{
			$invoices_html .= '
			<tr class="tr-invoice-no-results">
				<td colspan="15"><center>No records found!</center></td>
			</tr>
			';
		}
		else
		{
			foreach ($invoices AS $invoice)
			{
				if ($invoice['invoice_date']=="0000-00-00") { $invoice['invoice_date'] = ""; }
				if ($invoice['due_date']=="0000-00-00") { $invoice['due_date'] = ""; }
				if ($invoice['promised_date']=="0000-00-00") { $invoice['promised_date'] = ""; }

				$invoices_html .= '
				<tr id="invoice_tr_'.$invoice['id_invoice'].'" data-idinv="'.$invoice['id_invoice'].'">
					<td align="center">
						<a href="#" onclick="delete_invoice('.$invoice['id_invoice'].')">
							<i class="fa fa-trash-o" data-toggle="tooltip" data-placement="top" title="Delete"></i>
						</a>
					</td>
					<td align="center">
						<a href="#" class="open-edit-invoice" data-invoice_id="'.$invoice['id_invoice'].'">
							<i class="fa fa-pencil-square-o" data-toggle="tooltip" data-placement="top" title="Edit Invoice"></i>
						</a>
					</td>
					<td align="center">
						<!--<a href="#" class="open-add-invoice-payment" data-invoice_id="'.$invoice['id_invoice'].'">-->
							<i class="fa fa-dollar" data-toggle="tooltip" data-placement="top" title="Add Payment"></i>
						<!--</a>-->
					</td>
					<td align="center">
						<a href="'.site_url('deal/custom_invoice_pdf/'.$invoice['id_invoice']).'" target="_blank">
							<i class="fa fa-file-pdf-o" data-toggle="tooltip" data-placement="top" title="Open Invoice PDF"></i>
						</a>
					</td>					
					<td align="center">
						<a href="#" class="open-send-invoice" data-invoice_id="'.$invoice['id_invoice'].'">
							<i class="fa fa-envelope" data-toggle="tooltip" data-placement="top" title="Send Invoice PDF"></i>
						</a>
					</td>
					<td class="invoice_num_td">'.$invoice['invoice_number'].'</td>
					<td class="invoice_name_td">'.$invoice['invoice_name'].'</td>
					<td class="invoice_type_td">'.$invoice['invoice_type'].'</td>
					<td class="invoice_date_td">'.$invoice['invoice_date'].'</td>
					<td class="invoice_due_date_td">'.$invoice['due_date'].'</td>
					<td class="invoice_promise_date_td">'.$invoice['promised_date'].'</td>
					<td align="right" class="invoice_amount_td">$ '.$invoice['amount'].'</td>
					<td align="right" class="invoice_amount_pd_td">$ '.$invoice['amount_paid'].'</td>
					<td class="invoice_user_td">'.$invoice['name'].'</td>
					<td>'.$invoice['created_at'].'</td>
				</tr>';
			}
		}

		if (isset($balcqo['balcqo']))
		{
			$balcqo_figure = $balcqo['balcqo'];
		}

		if (isset($balcqo['revenue']))
		{
			$balcqo_revenue = $balcqo['revenue'];
		}

		$remaining_balance = $balcqo_figure - $received;
		$payments_arr = array(
			"lead_id"           => $lead_id,
			"revenue"           => number_format($balcqo_revenue, 2, '.', ''),
			"balcqo"            => number_format($balcqo_figure, 2, '.', ''),
			"received"          => number_format($received, 2, '.', ''),
			"remaining_balance" => number_format($remaining_balance, 2, '.', ''),
			"payments_html"     => $payments_html,
			"invoices_html"     => $invoices_html,
			"eway_token_html"   => $eway_token_html,
			"actions_html"      => $actions_html
		);
		echo json_encode($payments_arr);
	}
	
	public function generate_lead_email_recipient_string ()
	{
		$data = $this->data;
		$input_arr = $this->input->post();
		
		$email_recipient_arr = array();
		$email_addresses_result = $this->lead_model->get_lead($input_arr['id_lead']);
		if ($input_arr['user_type']=="Client")
		{
			if ($email_addresses_result['email'] != "") 
			{
				if (!in_array($email_addresses_result['email'], $email_recipient_arr))
				{
					$email_recipient_arr[] = $email_addresses_result['email'];
				}
			}
			
			if ($email_addresses_result['alternate_email_1'] != "") 
			{
				if (!in_array($email_addresses_result['alternate_email_1'], $email_recipient_arr))
				{
					$email_recipient_arr[] = $email_addresses_result['alternate_email_1'];
				}
			}
			
			if ($email_addresses_result['alternate_email_2'] != "") 
			{
				if (!in_array($email_addresses_result['alternate_email_2'], $email_recipient_arr))
				{
					$email_recipient_arr[] = $email_addresses_result['alternate_email_2'];
				}
			}			
		}
		else if ($input_arr['user_type']=="Dealer")
		{
			if ($email_addresses_result['dealer_email'] != "") 
			{
				if (!in_array($email_addresses_result['dealer_email'], $email_recipient_arr))
				{
					$email_recipient_arr[] = $email_addresses_result['dealer_email'];
				}				
			}
			
			if ($email_addresses_result['dealer_manager_email'] != "") 
			{
				if (!in_array($email_addresses_result['dealer_manager_email'], $email_recipient_arr))
				{
					$email_recipient_arr[] = $email_addresses_result['dealer_manager_email'];
				}								
			}
			
			if ($email_addresses_result['dealer_account_email'] != "") 
			{
				if (!in_array($email_addresses_result['dealer_account_email'], $email_recipient_arr))
				{
					$email_recipient_arr[] = $email_addresses_result['dealer_account_email'];
				}								
			}			
		}
		
		$email_recipient_string = "";
		foreach ($email_recipient_arr AS $email_recipient)
		{
			$email_recipient_string .= $email_recipient.",";
		}
		$email_recipient_string = rtrim($email_recipient_string, ',');
		
		echo $email_recipient_string;
	}	
	
	public function send_email ()
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;
		
		$input_arr = $this->input->post();		
		//echo json_encode($input_arr); die();
		$attachment_string = "";
		
		if ($input_arr['purchase_order_attachment_flag'] == 1)
		{
			$file = $this->generate_purchase_order_pdf($input_arr['id_lead']);
			$file = ltrim($file, "/");			
			$attachment_string .= $file . "[path]";
		}

		if ($input_arr['order_package_attachment_flag'] == 1)
		{
			$file = $this->generate_order_package_pdf($input_arr['id_lead']);
			$file = ltrim($file, "/");			
			$attachment_string .= $file . "[path]";
		}		
		
		if ($input_arr['dealer_invoice_attachment_flag'] == 1)
		{
			$file = $this->generate_dealer_invoice_pdf($input_arr['id_lead']);
			$file = ltrim($file, "/");			
			$attachment_string .= $file . "[path]";
		}				

		if (isset($input_arr['attachment_array']))
		{
			if (count($input_arr['attachment_array']) > 0)
			{
				foreach ($input_arr['attachment_array'] as $attachment) 
				{
					$attachment_string .= $attachment."[path]";
				}
			}
		}

		$attachment_string = rtrim($attachment_string, "[path]");

		$this->send_templated_email($data['username'], $data['name'], $input_arr['recipient'], $input_arr['subject'], $input_arr['message'], $attachment_string);
		
		echo "success";
	}
	
	public function send_accountant_email ()
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;
		
		$input_arr = $this->input->post();

		$attachment_string = "";

		if ($input_arr['dealer_invoice_flag'] == 0)
		{
			$file = $this->generate_dealer_invoice_pdf($input_arr['id_lead']);
			$file = ltrim($file, "/");			
			$attachment_string .= $file . "[path]";
		}
		
		if ($input_arr['email_template']==25)
		{
			$attachment_string .= "uploads/order_attachments/CONTRA ACCOUNTING.pdf[path]";
		}
		
		if ($input_arr['email_template']==26)
		{
			$attachment_string .= "uploads/order_attachments/DEALERSHIP DETAILS FORM.docx";
		}		
		
		if (isset($input_arr['attachment_array']))
		{
			if (count($input_arr['attachment_array']) > 0)
			{
				foreach ($input_arr['attachment_array'] as $attachment) 
				{
					$attachment_string .= $attachment."[path]";
				}
			}
		}

		$attachment_string = rtrim($attachment_string, "[path]");

		$this->send_temporary_templated_dealer_email($data['username'], $data['name'], $input_arr['recipients'], $input_arr['subject'], $input_arr['message'], $attachment_string);
		
		echo "success";
	}	
	
	public function send_temporary_templated_dealer_email ($from_email, $from_name, $to, $subject, $content, $file = "")
	{

	}

	// PDF RENDERS (Start) //
	public function pdf_export ($lead_id) // PDF RENDER
	{
		$customurl='http://staging-new.finquote.com.au';
		$path = $customurl.$this->generate_purchase_order_pdf($lead_id);
		redirect($path);
	}
	
	public function order_package_pdf ($lead_id) // PDF RENDER
	{
		$customurl='http://portal.finquote.com.au';
		$path = $customurl.$this->generate_order_package_pdf($lead_id);
		redirect($path);
	}	
	
	public function custom_invoice_pdf ($invoice_id) // PDF RENDER
	{
		$customurl='http://portal.finquote.com.au';
		$path = $customurl.$this->generate_custom_invoice_pdf($invoice_id);
		redirect($path);
	}	

	public function dealer_invoice_pdf ($lead_id) // PDF RENDER
	{
		$customurl='http://staging-new.finquote.com.au';
		$path = $customurl.$this->generate_dealer_invoice_pdf($lead_id);
		redirect($path);
	}

	public function client_automated_invoice_pdf ($lead_id) // PDF RENDER
	{
		// echo $lead_id; die();
		$customurl='http://portal.finquote.com.au';
		$path = $customurl.$this->generate_client_automated_invoice_pdf($lead_id);
		redirect($path);		
	}
	
	public function client_new_automated_invoice_pdf ($lead_id) // PDF RENDER
	{
		$customurl='http://portal.finquote.com.au';
		$path = $customurl.$this->generate_client_new_automated_invoice_pdf($lead_id);
		redirect($path);		
	}	

	public function accessory_order_pdf ($lead_id) // PDF RENDER
	{
		$customurl='http://portal.finquote.com.au';
		$path = $customurl.$this->generate_accessory_client_order_pdf($lead_id);
		redirect($path);
	}

	public function accessory_supplier_order_pdf ($lead_id) // PDF RENDER
	{
		$customurl='http://portal.finquote.com.au';
		$path = $customurl.$this->generate_accessory_supplier_order_pdf($lead_id);
		redirect($path);		
	}	
	// PDF RENDERS (End) //
	
	// PDF GENERATORS (Start) //
	public function generate_purchase_order_pdf ($lead_id) // PDF GENERATION
	{
		$data = $this->data;
		//echo json_encode($data['deal']); die();
		$data['title'] = 'Purchase Order';

		$data['company_settings'] = $this->settings;
		$data['deal'] = $this->lead_model->get_deal($lead_id);
		//echo json_encode($data['deal']); die();
		$data['accessories'] = $this->request_model->get_quote_request_accessories($data['deal']['id_quote_request']);
		$data['options'] = $this->request_model->get_quote_request_options($data['deal']['id_quote_request']);
		$data['tradeins'] = $this->tradein_model->get_attached_tradeins($lead_id);

		$data['deposits'] = $this->lead_model->get_lead_deposits($lead_id);
		$data['refunds'] = $this->lead_model->get_lead_refunds($lead_id);		
		$data['deposit_trans'] = $this->lead_model->get_lead_deposit_trans($lead_id);

		$data['deal_accessories'] = $this->lead_model->get_deal_accessories($lead_id);
		$data['accessory_payments'] = $this->lead_model->get_accessory_payments($lead_id);	

		$filename = str_replace('QM', 'PO', $data['deal']['cq_number'])."_".date("Ymdhis");
		$pdfFilePath = FCPATH."/uploads/deals/".$filename.".pdf";
		ini_set('memory_limit','512M');
		$html = $this->load->view('admin/pdf_renders/deal_print', $data, true);
		//echo $html; die();
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->SetHTMLFooter($this->pdf_footer);
		$pdf->WriteHTML($html);
		$pdf->Output($pdfFilePath, 'F');
		$path = "/uploads/deals/".$filename.".pdf";
		
		$input_arr = array(
			'id' => $lead_id,
			'table_name' => 'fq_accounts_new',
			'pdf_type' => 'Purchase Order (to Client)',
			'path' => $path
		);
		$this->pdf_model->insert_pdf($data['user_id'], $input_arr);

		return $path;
	}	
	
	public function generate_order_package_pdf ($lead_id) // PDF GENERATION
	{
		$data = $this->data;
		$data['title'] = 'Purchase Order';

		$data['company_settings'] = $this->settings;
		$data['deal'] = $this->lead_model->get_deal($lead_id);

		$data['accessories'] = $this->request_model->get_quote_request_accessories($data['deal']['id_quote_request']);
		$data['options'] = $this->request_model->get_quote_request_options($data['deal']['id_quote_request']);
		$data['tradeins'] = $this->tradein_model->get_attached_tradeins($lead_id);

		$data['deposits'] = $this->lead_model->get_lead_deposits($lead_id);
		$data['refunds'] = $this->lead_model->get_lead_refunds($lead_id);		
		$data['deposit_trans'] = $this->lead_model->get_lead_deposit_trans($lead_id);

		$data['deal_accessories'] = $this->lead_model->get_deal_accessories($lead_id);
		$data['accessory_payments'] = $this->lead_model->get_accessory_payments($lead_id);	

		// For Client Invoice (Start) //
		$lead = $this->lead_model->get_lead($lead_id);
		$lead = $this->calculate_adjusted_quote($lead);
		$lead_calculation_details = $this->calculate_deal_new($lead);
		$data['lead'] = $lead;
		$data['invoice_details'] = $lead_calculation_details;		
		// For Client Invoice (End) //

		$filename = str_replace('QM', 'PO', $data['deal']['cq_number'])."_".date("Ymdhis");
		$pdfFilePath = FCPATH."/uploads/deals/".$filename.".pdf";

		ini_set('memory_limit','512M');
		$html = $this->load->view('admin/pdf_renders/order_package_pdf', $data, true);
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->SetHTMLFooter($this->pdf_footer);
		$pdf->WriteHTML($html);
		$pdf->Output($pdfFilePath, 'F');
		$path = "/uploads/deals/".$filename.".pdf";
		
		$input_arr = array(
			'id' => $lead_id,
			'table_name' => 'fq_accounts_new',
			'pdf_type' => 'Purchase Order (to Client)',
			'path' => $path
		);
		$this->pdf_model->insert_pdf($data['user_id'], $input_arr);

		return $path;
	}	
	
	public function generate_custom_invoice_pdf ($invoice_id) // PDF GENERATION
	{
		$data = $this->data;
		$data['title'] = 'Invoice';

		$data['company_settings'] = $this->settings;
		$data['invoice'] = $this->invoice_model->get_invoice($invoice_id);
		$data['invoice_items'] = $this->invoice_model->get_invoice_items($invoice_id);		
	
		$filename = str_replace('QM', 'CI', $data['invoice']['id_invoice'])."_".date("Ymdhis");
		$pdfFilePath = FCPATH."/uploads/invoice_files/".$filename.".pdf";
		ini_set('memory_limit','512M');
		$html = $this->load->view('admin/pdf_renders/custom_invoice_print', $data, true);
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->SetHTMLFooter($this->pdf_footer);
		$pdf->WriteHTML($html);
		$pdf->Output($pdfFilePath, 'F');
		$path = "/uploads/invoice_files/".$filename.".pdf";
		
		$input_arr = array(
			'id' => $invoice_id,
			'table_name' => 'invoices',
			'pdf_type' => 'Custom Invoice',
			'path' => $path
		);
		$this->pdf_model->insert_pdf($data['user_id'], $input_arr);

		return $path;
	}
	
	public function generate_dealer_invoice_pdf ($lead_id) // PDF GENERATION
	{
		$data = $this->data;
		$data['title'] = 'Dealer Invoice';

		$data['company_settings'] = $this->settings;
		$data['lead'] = $this->lead_model->get_lead($lead_id);
		
		$data['deposits'] = $this->lead_model->get_lead_deposits($lead_id);
		$data['refunds'] = $this->lead_model->get_lead_refunds($lead_id);		
		$data['deposit_trans'] = $this->lead_model->get_lead_deposit_trans($lead_id);
		$data['revenue_details'] = $this->calculate_revenue($data['lead']);
	
		$filename = str_replace('QM', 'DI', $data['lead']['cq_number'])."_".date("Ymdhis");
		$pdfFilePath = FCPATH."/uploads/invoice_files/".$filename.".pdf";

		ini_set('memory_limit','512M');
		$html = $this->load->view('admin/pdf_renders/dealer_invoice_print', $data, true);
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->SetHTMLFooter($this->pdf_footer);
		$pdf->WriteHTML($html);
		$pdf->Output($pdfFilePath, 'F');
		$path = "/uploads/invoice_files/".$filename.".pdf";
		
		$input_arr = array(
			'id' => $lead_id,
			'table_name' => 'fq_accounts_new',
			'pdf_type' => 'Dealer Invoice',
			'path' => $path
		);
		$this->pdf_model->insert_pdf($data['user_id'], $input_arr);

		return $path;
	}

	public function generate_client_automated_invoice_pdf ($lead_id) // PDF GENERATION
	{
		$data = $this->data;
		$data['title'] = 'Invoice';

		$data['company_settings'] = $this->settings;
		$lead = $this->lead_model->get_lead($lead_id);
		$deposits = $this->payment_model->get_deposits($lead_id);
		$refunds = $this->payment_model->get_refunds($lead_id);
		$tradeins = $this->tradein_model->get_attached_tradeins($lead_id);

		$lead_calculation_details = $this->calculate_deal($lead);	
	
		if ($lead_calculation_details['sales_price'] > $lead['sales_price'])
		{
			//echo json_encode($lead); die();		
			while ($lead_calculation_details['sales_price'] > $lead['sales_price'])
			{
				$lead['dealer_discount'] += 1;
				$lead_calculation_details = $this->calculate_deal($lead);
			}
			
			if ($lead_calculation_details['sales_price'] < $lead['sales_price'])
			{
				while ($lead_calculation_details['sales_price'] < $lead['sales_price'])
				{
					if ($lead['fleet_discount'] <= 0)
					{
						if ($lead['dealer_discount'] <= 0)
						{
							if ($lead['dealer_delivery'] >= 1000)
							{
								$lead['registration'] += 0.01;
							}
							else
							{
								$lead['dealer_delivery'] += 0.01;
							}
						}
						else
						{
							$lead['dealer_discount'] -= 0.01;
						}
					}
					else
					{
						$lead['fleet_discount'] -= 0.01;
					}
					$lead_calculation_details = $this->calculate_deal($lead);
				}		
			}
		}
		else
		{
			$lead_calculation_details['sales_price'] = 0;
			while ($lead_calculation_details['sales_price'] < $lead['sales_price'])
			{
				if ($lead['fleet_discount'] <= 0)
				{
					if ($lead['dealer_discount'] <= 0)
					{
						if ($lead['dealer_delivery'] >= 1000)
						{
							$lead['registration'] += 0.01;
						}
						else
						{
							$lead['dealer_delivery'] += 0.01;
						}
					}
					else
					{
						$lead['dealer_discount'] -= 0.01;
					}
				}
				else
				{
					$lead['fleet_discount'] -= 0.01;
				}
				$lead_calculation_details = $this->calculate_deal($lead);
			}	
		}		

	
		$data['deal'] = $lead;
		$data['deposits'] = $deposits;
		$data['refunds'] = $refunds;
		$data['tradeins'] = $tradeins;
		$data['invoice_details'] = $lead_calculation_details;

		$filename = str_replace('QM', 'CI', $data['deal']['cq_number'])."_".date("Ymdhis");
		$pdfFilePath = FCPATH."/uploads/invoice_files/".$filename.".pdf";
		ini_set('memory_limit','512M');
		$html = $this->load->view('admin/pdf_renders/client_automated_invoice_print', $data, true);
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->SetHTMLFooter($this->pdf_footer);
		$pdf->WriteHTML($html);
		$pdf->Output($pdfFilePath, 'F');
		$path = "/uploads/invoice_files/".$filename.".pdf";
		echo $path; die();
		$input_arr = array(
			'id' => $lead_id,
			'table_name' => 'fq_accounts_new',
			'pdf_type' => 'Dealer to Client Invoice',
			'path' => $path
		);
		$this->pdf_model->insert_pdf($data['user_id'], $input_arr);
		
		redirect($path);
	}

	public function generate_client_new_automated_invoice_pdf ($lead_id) // PDF GENERATION
	{
		$data = $this->data;
		$data['title'] = 'Invoice';

		$data['company_settings'] = $this->settings;
		$lead = $this->lead_model->get_lead($lead_id);
		$deposits = $this->payment_model->get_deposits($lead_id);
		$refunds = $this->payment_model->get_refunds($lead_id);
		$tradeins = $this->tradein_model->get_attached_tradeins($lead_id);

		$lead = $this->calculate_adjusted_quote($lead);
		$lead_calculation_details = $this->calculate_deal_new($lead);

		$data['deal'] = $lead;
		$data['deposits'] = $deposits;
		$data['refunds'] = $refunds;
		$data['tradeins'] = $tradeins;
		$data['invoice_details'] = $lead_calculation_details;

		$filename = str_replace('QM', 'CI', $data['deal']['cq_number'])."_new_".date("Ymdhis");
		$pdfFilePath = FCPATH."/uploads/invoice_files/".$filename.".pdf";
		ini_set('memory_limit','512M');
		$html = $this->load->view('admin/pdf_renders/client_automated_invoice_print', $data, true);
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->SetHTMLFooter($this->pdf_footer);
		$pdf->WriteHTML($html);
		$pdf->Output($pdfFilePath, 'F');
		$path = "/uploads/invoice_files/".$filename.".pdf";
		
		$input_arr = array(
			'id' => $lead_id,
			'table_name' => 'fq_accounts_new',
			'pdf_type' => 'Dealer to Client Invoice',
			'path' => $path
		);
		$this->pdf_model->insert_pdf($data['user_id'], $input_arr);

		redirect($path);
	}
	
	public function generate_accessory_client_order_pdf ($lead_id) // PDF GENERATION
	{
		$data = $this->data;
		$data['title'] = 'Accessories Purchase Order';

		$data['company_settings'] = $this->settings;
		$data['deal'] = $this->lead_model->get_deal($lead_id);
		$data['deal_accessories'] = $this->lead_model->get_deal_accessories($lead_id);
		$data['accessory_payments'] = $this->lead_model->get_accessory_payments($lead_id);
	
		$filename = str_replace('QM', 'PO', $data['deal']['cq_number'])."ACC_".date("Ymdhis");
		$pdfFilePath = FCPATH."/uploads/deals/".$filename.".pdf";

		ini_set('memory_limit','512M');
		$html = $this->load->view('admin/pdf_renders/accessory_order_print', $data, true);
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->SetHTMLFooter($this->pdf_footer);
		$pdf->WriteHTML($html);
		$pdf->Output($pdfFilePath, 'F');
		$path = "/uploads/deals/".$filename.".pdf";
		
		$input_arr = array(
			'id' => $lead_id,
			'table_name' => 'fq_accounts_new',
			'pdf_type' => 'Accessory Order (Client)',
			'path' => $path
		);
		$this->pdf_model->insert_pdf($data['user_id'], $input_arr);

		redirect($path);		
	}
	
	public function generate_accessory_supplier_order_pdf ($lead_id) // PDF GENERATION
	{
		$data = $this->data;
		$data['title'] = 'Accessories Purchase Order';

		$data['company_settings'] = $this->settings;
		$data['deal'] = $this->lead_model->get_deal($lead_id);
		$data['deal_accessories'] = $this->lead_model->get_deal_accessories($lead_id);
		$data['accessory_payments'] = $this->lead_model->get_accessory_payments($lead_id);
	
		$filename = str_replace('QM', 'PO', $data['deal']['cq_number'])."ACS_".date("Ymdhis");
		$pdfFilePath = FCPATH."/uploads/deals/".$filename.".pdf";

		ini_set('memory_limit','512M');
		$html = $this->load->view('admin/pdf_renders/accessory_supplier_order_print', $data, true);
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->SetHTMLFooter($this->pdf_footer);
		$pdf->WriteHTML($html);
		$pdf->Output($pdfFilePath, 'F');
		$path = "/uploads/deals/".$filename.".pdf";
		
		$input_arr = array(
			'id' => $lead_id,
			'table_name' => 'fq_accounts_new',
			'pdf_type' => 'Accessory Order (Supplier)',
			'path' => $path
		);
		$this->pdf_model->insert_pdf($data['user_id'], $input_arr);

		redirect($path);		
	}	

	public function generate_tradein_invoice_pdf ($tradein_id) // PDF GENERATION
	{
		$data = $this->data;
		$data['title'] = 'Invoice';

		$data['company_settings'] = $this->settings;
		$data['tradein'] = $this->tradein_model->get_tradein($tradein_id);
		
		$filename = 'QMTII'.$data['tradein']['id_tradein']."_".date("Ymdhis");
		$pdfFilePath = FCPATH."/uploads/invoice_files/".$filename.".pdf";
		ini_set('memory_limit','512M');
		$html = $this->load->view('admin/pdf_renders/tradein_invoice_print', $data, true);
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->SetHTMLFooter($this->pdf_footer);
		$pdf->WriteHTML($html);
		$pdf->Output($pdfFilePath, 'F');
		$path = "/uploads/invoice_files/".$filename.".pdf";
		
		$input_arr = array(
			'id' => $tradein_id,
			'table_name' => 'tradeins',
			'pdf_type' => 'Wholesaler Invoice',
			'path' => $path
		);
		$this->pdf_model->insert_pdf($data['user_id'], $input_arr);

		return $path;
	}	
	// PDF GENERATORS (End) //
	
	
	// XERO INVOICE GENERATORS (Start) //
	public function add_xero_dealer_invoice ($lead_id, $invoice_id = "")
	{
		$data['lead'] = $this->lead_model->get_lead($lead_id);
		$data['revenue_details'] = $this->calculate_revenue($data['lead']);

		$data['deposits'] = $this->lead_model->get_lead_deposits($lead_id);
		$data['refunds'] = $this->lead_model->get_lead_refunds($lead_id);		
		$data['deposit_trans'] = $this->lead_model->get_lead_deposit_trans($lead_id);
		
		$dealer_invoice_details = $this->calculate_dealer_invoice($data['lead'], $data['revenue_details'], $data['deposits'], $data['refunds'], $data['deposit_trans']);

		$line_items_arr = [];
		foreach ($dealer_invoice_details['line_items'] AS $line_item)
		{
			$line_item['account_code'] = 200; // Remove this on LIVE
			$line_items_arr[] = array(
				'LineItem' => array(
					'Description' => $line_item['description'],
					'Quantity' => $line_item['quantity'],
					'UnitAmount' => $line_item['amount_aud'],
					'TaxType' => $line_item['tax_type'],
					'AccountCode' => $line_item['account_code']
				)
			);
		}
		
		if ($dealer_invoice_details['balance_payable'] < 0)
		{
			$line_items_arr[] = array(
				'LineItem' => array(
					'Description' => 'Deposit Owed to Dealer',
					'Quantity' => 1,
					'UnitAmount' => ($dealer_invoice_details['balance_payable'] * (-1)),
					'TaxType' => 'OUTPUT',
					// 'AccountCode' => 810
					'AccountCode' => 200 // Remove this on LIVE
				)
			);
			$dealer_invoice_details['balance_payable'] = 0;
		}		

		$invoice_arr = array(			
			'Date' => $data['lead']['order_date'],
			'DueDate' => $data['lead']['delivery_date'],
			'Reference' => $data['lead']['cq_number'].": ".$data['lead']['name'],
			'SubTotal' => $dealer_invoice_details['balance_payable'],
			'TotalTax' => $dealer_invoice_details['gst'],
			'LineItems' => $line_items_arr,
			
			'ContactNumber' => $data['lead']['dealer_mobile'],
			'Name' => $data['lead']['fleet_manager'],
			'EmailAddress' => $data['lead']['dealer_email'],
			'AttentionTo' => $data['lead']['fleet_manager'],
			'AddressLine1' => $data['lead']['dealer_address'],
			'Region' => $data['lead']['dealer_state'],
			'PostalCode' => $data['lead']['dealer_postcode'],			
			'MobileNumber' => $data['lead']['dealer_mobile'],
			'PhoneNumber' => $data['lead']['dealer_phone']			
		);
		
		if ($invoice_id <> "")
		{
			$invoice_arr['InvoiceID'] = $invoice_id;
		}

		$xero = new Xero();
		$output_arr = $xero->invoice_values($invoice_arr);
		$invoices = $output_arr->Invoices;

		return $output_arr->Invoices[0]->InvoiceID;
	}
	
	public function add_xero_admin_fee_invoice ($lead_id, $amount)
	{
		$data['lead'] = $this->lead_model->get_lead($lead_id);
		$data['revenue_details'] = $this->calculate_revenue($data['lead']);

		$line_items_arr[] = array(
			'LineItem' => array(
				'Description' => 'Order processing fee for supplying quotes on '.$data['lead']['tender_make'].' '.$data['lead']['tender_model'].' '.$data['lead']['tender_variant'],
				'Quantity' => 1,
				'UnitAmount' => $amount,
				'TaxType' => 'OUTPUT',
				// 'AccountCode' => 210
				'AccountCode' => 200 // Remove this on LIVE
			)
		);

		$invoice_arr = array(			
			'Date' => $data['lead']['order_date'],
			'DueDate' => $data['lead']['order_date'],
			'Reference' => "Admin Fee: ".$data['lead']['name'],
			'SubTotal' => $amount,
			'TotalTax' => ($amount * 0.1),
			'LineItems' => $line_items_arr,
			
			'ContactNumber' => $data['lead']['mobile'],
			'Name' => $data['lead']['name'],
			'EmailAddress' => $data['lead']['email'],
			'AttentionTo' => $data['lead']['name'],
			'AddressLine1' => $data['lead']['address'],
			'Region' => $data['lead']['state'],
			'PostalCode' => $data['lead']['postcode'],			
			'MobileNumber' => $data['lead']['mobile'],
			'PhoneNumber' => $data['lead']['phone']			
		);
		
		if ($invoice_id <> "")
		{
			$invoice_arr['InvoiceID'] = $invoice_id;
		}		

		$xero = new Xero();
		$output_arr = $xero->invoice_values($invoice_arr);
	}	
	// XERO INVOICE GENERATORS (End) //

	public function add_order_recipient ($lead_id) // SUB MODAL ACTION //
	{
		$data = $this->data;
		$input_arr = $this->input->post();

		if ($input_arr['email'] != "")
		{
			$path = $this->generate_purchase_order_pdf($lead_id);
			$this->lead_model->insert_order_recipient($lead_id, $data['user_id'], $input_arr['email'], $path);
			
			$po_path = $this->base_path."uploads/".$this->substring_index($path, '/uploads/', -1);

			if ($input_arr['user_type'] == 1) // Client
			{
				$email_type = "Client Email";
				$attachment_1_path = $this->base_path."uploads/order_attachments/QUOTE ME CAR CARE & DELIVERY INTRODUCTION.pdf";
				$attachment_2_path = $this->base_path."uploads/order_attachments/PERMAGARD AUTOMOTIVE TINT SOLUTIONS.pdf";
				$attachment_3_path = $this->base_path."uploads/order_attachments/PERMAGARD E-BROCHURE.pdf";				
				$attachment_4_path = $this->base_path."uploads/order_attachments/PERMAGARD E-BROCHURE 2.pdf";
				$complete_attachment_path_string = $po_path."[path]".$attachment_1_path."[path]".$attachment_2_path."[path]".$attachment_3_path."[path]".$attachment_4_path;
				$this->templated_special_email_init(19, $lead_id, 'company', $input_arr['email'], $complete_attachment_path_string);
				
				$tradeins_data_res = $this->tradein_model->lead_tradein_flagger($lead_id);
				if (count($tradeins_data_res) > 0)
				{
					$from_email = $data['company']['company_email'];
					$from_name = $data['company']['company_name'];
					$to = $input_arr['email'];
					$subject = "Tradein Requirements";		
					
					$upload_url = '';
					$upload_url_link = '';
					foreach ($tradeins_data_res as $id_key => $id_res) 
					{
						if ($id_res['upload_key']=="")
						{
							$upload_key = md5($id_res['id_tradein']."-".$this->random_string(5));
							$this->tradein_model->update_upload_key($id_res['id_tradein'], $upload_key);
						}
						else
						{
							$upload_key = $id_res['upload_key'];
						}
						$upload_url_link .= '
						<a href="'.site_url('client_upload?id='.$id_res['id_tradein'].'&key='.$upload_key).'" target="_blank">
							'.site_url('client_upload?id='.$id_res['id_tradein'].'&key='.$upload_key).'
						</a>
						<br />';
						$upload_url .= site_url('client_upload?id='.$id_res['id_tradein'].'&key='.$upload_key).'<br />';
					}

					$link_text = "link";
					if (count($tradeins_data_res)>1)
					{
						$link_text = "links";
					}
					$content = '
					<p style="line-height: 1.5">
						Please visit the '.$link_text.' below and upload the Trade-In Requirements to ensure that there would be no delay 
						on the delivery of your new car.
					</p>
					<p style="line-height: 1.5">
						'.$upload_url_link.'
					</p>
					<p style="line-height: 1.5">
						<br /><br />
						Thank you for your business,
						<br />
						<b>'.$data['company']['company_name'].'</b>
					</p>';
					$this->send_templated_email($from_email, $from_name, $to, $subject, $content);

					$audit_trail_arr = array(
						'id' => $lead_id,
						'table_name' => 'leads',
						'action' => 25,
						'description' => '[{"urls":"'.$upload_url.'"}]'
					);
					$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);																
				}
			}
			else // Dealer
			{
				$email_type = "Dealer Email";
				$this->templated_special_email_init(20, $lead_id, 'company', $input_arr['email'], $po_path);
			}

			$audit_trail_arr = array(
				'id' => $lead_id,
				'table_name' => 'leads',
				'action' => 24,
				'description' => '[{"email_type":"'.$email_type.'","email":"'.$input_arr['email'].'","file":"'.$path.'"}]'
			);
			$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);
		}
	}

	public function order_recipients ($lead_id) // SUB MODAL VIEW (PDF) //
	{
		$email_query = "
		SELECT l.email AS `client_email`, u.email AS `dealer_email`
		FROM leads l 
		LEFT JOIN quote_requests qr ON l.id_lead = qr.fk_lead
		LEFT JOIN quotes q ON qr.winner = q.id_quote
		LEFT JOIN users u ON q.fk_user = u.id_user
		WHERE l.id_lead = ".$lead_id." LIMIT 1";
		$email_result = $this->db->query($email_query)->row_array();

		$query = "
		SELECT o.email, u.name, o.file, o.created_at 
		FROM order_recipients o JOIN users u ON o.fk_user = u.id_user
		WHERE o.fk_lead = ".$lead_id." ORDER BY o.id_order_recipient DESC";
		$result = $this->db->query($query);
		if (count($result->result())==0)
		{
			$order_recipients = '<tr id="no_record"><td colspan="4"><center><i>No recipients yet!</i></center></td></tr>';
		}
		else
		{
			$order_recipients = '';			
			foreach ($result->result() as $row)
			{
				if ($row->file <> '')
				{
					$file_url = site_url($row->file);
				}
				else
				{
					$file_url = "";
				}
				
				$order_recipients .= '
				<tr>
					<td>'.$row->email.'</td>
					<td>'.$row->name.'</td>
					<td>'.$file_url.'</td>
					<td>'.$row->created_at.'</td>
				</tr>';
			}
			$order_recipients .= '';
		}
		$order_recipients_arr = array(
			"order_recipients" => $order_recipients,
			"client_email" => $email_result['client_email'],
			"dealer_email" => $email_result['dealer_email']
		);
		echo json_encode($order_recipients_arr);
	}

	public function order_confirmation_recipients ($lead_id) // SUB MODAL VIEW (PDF) //
	{
		$email_query = "
		SELECT l.email AS `client_email`, u.email AS `dealer_email`
		FROM leads l 
		LEFT JOIN quote_requests qr ON l.id_lead = qr.fk_lead
		LEFT JOIN quotes q ON qr.winner = q.id_quote
		LEFT JOIN users u ON q.fk_user = u.id_user
		WHERE l.id_lead = ".$lead_id." LIMIT 1";
		$email_result = $this->db->query($email_query)->row_array();

		$query = "
		SELECT o.email, u.name, o.file, o.created_at 
		FROM order_confirmation_recipients o JOIN users u ON o.fk_user = u.id_user
		WHERE o.fk_lead = ".$lead_id." ORDER BY o.id_confirmation_recipient DESC";
		$result = $this->db->query($query);
		if (count($result->result())==0)
		{
			$order_recipients = '<tr id="no_record"><td colspan="4"><center><i>No recipients yet!</i></center></td></tr>';
		}
		else
		{
			$order_recipients = '';			
			foreach ($result->result() as $row)
			{
				if ($row->file <> '')
				{
					$file_url = site_url($row->file);
				}
				else
				{
					$file_url = "";
				}
				
				$order_recipients .= '
				<tr>
					<td>'.$row->email.'</td>
					<td>'.$row->name.'</td>
					<td>'.$row->created_at.'</td>
				</tr>';
			}
			$order_recipients .= '';
		}
		$order_recipients_arr = array(
			"order_recipients" => $order_recipients,
			"client_email" => $email_result['client_email'],
			"dealer_email" => $email_result['dealer_email']
		);
		echo json_encode($order_recipients_arr);
	}

	public function send_confirmation_email ()
	{
		$data = $this->data;

		$input_arr = $this->input->post();

		$this->lead_model->insert_confirmation_recipient($input_arr['lead_id'], $data['user_id'], $input_arr['email'], "");

		$response = $this->lead_model->get_lead_key($input_arr['lead_id']); 
		
		$deal_agreement_link = site_url("vehicle_order/client_agreement?id=".$input_arr['lead_id']."&key=".$response['client_key']);

		$tradein_content = '';
		$tradeins_result = $this->tradein_model->lead_tradein_flagger($input_arr['lead_id']);
		if (count($tradeins_result) > 0)
		{
			$upload_url = '';
			foreach ($tradeins_result as $tradein_key => $tradein_result)
			{
				if ($tradein_result['upload_key']=="")
				{
					$upload_key = md5($tradein_result['id_tradein']."-".$this->random_string(5));
					$this->tradein_model->update_upload_key($tradein_result['id_tradein'], $upload_key);
				}
				else
				{
					$upload_key = $tradein_result['upload_key'];
				}
				$upload_url .=
				'<a href="'.site_url("client_upload?id=".$tradein_result['id_tradein']."&key=".$upload_key).'" target="_blank">
					'.site_url('client_upload?id='.$tradein_result['id_tradein'].'&key='.$upload_key).'
				</a>
				<br />';						
				
				$upload_url = site_url('client_upload?id='.$tradein_result['id_tradein'].'&key='.$upload_key);
			}

			$tradein_content .= '
			<br />
			<p style="line-height: 1.5">
				Please use the link below to upload your tradein documents.
			</p>
			<p style="line-height: 1.5">
				'.$upload_url.'
			</p>					
			<p>
				You can also email them to '.$data['company']['company_email'].'
			</p>					
			';
		}
		
		$from_email = $data['company']['company_email'];
		$from_name = $data['company']['company_name'];
		$to = $input_arr['email'];
		$subject = "Congratulations On Your New Car Order - ".$data['company']['company_name']." Email Confirmation";
		
		$content = '
		<p style="line-height: 1.5">
			The '.$data['company']['company_name'].' team congratulates you on your new car.
		</p>
		<p style="line-height: 1.5">
			Please click on the link below to walk thru the new car order and confirm the vehicle specification. 
			If you have any questions please call '.$data['company']['company_phone'].' or your quote specialist.				
		</p>
		<p style="line-height: 1.5">
			<a href="'.$deal_agreement_link.'">'.$deal_agreement_link.'</a>
		</p>
		'.$tradein_content.'
		<p style="line-height: 1.5">
			<br><br>
			Thank you for your business,
			<br>
			<b>'.$data['company']['company_name'].'</b>
		</p>';
		$this->send_templated_email ($from_email, $from_name, $to, $subject, $content, $file = "");		
	}

	public function after_sales_accessory_modal()
	{
		$lead_id = $this->input->post('lead_id');
		$status = $this->input->post('status');

		$lead = $this->lead_model->get_additional_lead_accessory_details($lead_id);

		$accessory_details = '
		<h5><b>List of accessories to be purchased</b></h5>
		<div class="table-responsive">
			<table class="table table-bordered table-striped table-condensed mb-none">
				<thead>
					<tr>
						<td><b><i class="fa fa-trash-o"></i></b></td>
						<td><b>Supplier</b></td>
						<td><b>Code</b></td>
						<td><b>Name</b></td>
						<td><b>Supplier Price</b></td>
						<td><b>Our Price</b></td>
						<td><b>Quantity</b></td>
						<td><b>Price</b></td>
						<td hidden></td>
					</tr>
				</thead>
				<tbody id="modal_aftersales_accessory_table_body">
				';

				$total_deal_accessory_price = 0.00;
				$total_acessory_cost        = 0.00;
				$total_revenue              = 0.00;
				$deal_accessories = $this->lead_model->get_deal_accessories($lead_id);
				if (count($deal_accessories)==0)
				{
					$accessory_details .= '
					<tr id="aftersales_accessory_no_record"><td colspan="8"><center><i>No accessories added yet..</center></i></td></tr>
					';
				}
				else
				{
					foreach ($deal_accessories AS $deal_accessory)
					{
						$total_price = (float)($deal_accessory['price'] * $deal_accessory['quantity']);
						$total_price = number_format((float)$total_price, 2, '.', '');

						$total_cost = (float)($deal_accessory['accessory_cost'] * $deal_accessory['quantity']);
						$total_cost = number_format($total_cost, 2, '.', '');

						$accessory_details .= '
						<tr id="aftersales_acc_tr_id_"'.$deal_accessory['id_deal_accessory'].' data-idacc="'.$deal_accessory['id_deal_accessory'].'" class="acc_table_body_tr">
							<td><a href="#" class="del_lead_acc_aftersales" data-idacc="'.$deal_accessory['id_deal_accessory'].'"><i class="fa fa-trash-o"></i></a></td>
							<td>'.$deal_accessory['accessory_supplier_name'].'</td>
							<td>'.$deal_accessory['accessory_code'].'</td>
							<td>'.$deal_accessory['accessory_name'].'</td>
							<td class="supplier_price_td">'.$deal_accessory['accessory_cost'].'</td>
							<td>
								<input value="'.$deal_accessory['price'].'" class="form-control input-sm acc_price" type="text" name="deal_accessory_price['.$deal_accessory['id_deal_accessory'].']" onkeypress="return isNumberKey(event)" style="text-align: right !important;">
							</td>
							<td>
								<input value="'.$deal_accessory['quantity'].'" class="form-control input-sm acc_quantity" type="text" name="deal_accessory_quantity['.$deal_accessory['id_deal_accessory'].']" onkeypress="return isNumberKey(event)" style="text-align: right !important;">
							</td>
							<td>
								<input value="'.$total_price.'" class="form-control input-sm total_price" type="text" name="total_price" onkeypress="return isNumberKey(event)" readonly style="text-align: right !important;">
							</td>
							<td hidden>
								<input type="hidden" class="hidden_total_cost" value="'.$total_cost.'">
							</td>
						</tr>';
						$total_deal_accessory_price += $total_price;
						$total_acessory_cost += $total_cost;
					}
				}

				$total_revenue = $total_deal_accessory_price - $total_acessory_cost;

				$total_deal_accessory_price = number_format((float)$total_deal_accessory_price, 2, '.', '');
				$total_revenue = number_format((float)$total_revenue, 2, '.', '');

				$buying_save_string = "";

				if($lead['aftersales_status'] == 3){
					$buying_save_string = "Save";
				}
				else{
					$buying_save_string = "Submit";
				}

				$accessory_details .= '
				</tbody>
			</table>
		</div>
		<div style="margin-top: 10px; margin-bottom: 10px;" >
			<p><b>Total Price:&nbsp;</b><span id="total_deal_accessory_price">'.$total_deal_accessory_price.'</span></p>
			<p><b>Revenue:&nbsp;</b><span id="total_revenue">'.$total_revenue.'</span></p>
		</div>
		<br />
		<span class="btn btn-sm btn-primary" id="aftersales_add_accessory_btn" data-leadid="'.$lead_id.'">
			<i class="fa fa-plus"></i> Add Accessories
		</span>
		<br /><br /><br />
		
		<h5><b>Please choose the date the accessories will be installed on the car:</b></h5>
		<input value="'.$lead['accessory_job_date'].'" class="datepicker form-control input-sm" data-date-format="yyyy-mm-dd" type="text" id="aftersales_accessory_job_date" name="aftersales_accessory_job_date">
		<br /><br />
		
		<h5><b>Please indicate any special conditions that needs to be included on the Purchase Order:</b></h5>
		<textarea class="form-control" rows="1" width="100%" id="aftersales_accessory_special_conditions">'.$lead["accessory_special_conditions"].'</textarea>
		<br />
		<input type="checkbox" id="aftersales_accessory_status" '.($lead['accessory_status'] == "1" ? "checked" : "").' disabled="disabled"> Is this attached to the New Car Order? <font color="red">*Choosing this option is still under construction</font>
		<br /><br />
		<span class="btn btn-primary btn-sm" id="update_aftersales_accessory_btn" data-buyflag="'.$lead['aftersales_status'].'">'.$buying_save_string.' Order</span>
		<a class="btn btn-warning btn-sm" href="'.site_url('deal/accessory_order_pdf/'.$lead['id_lead']).'" target="_blank"><i class="fa fa-pdf"></i> PO to Client</a>
		<a class="btn btn-warning btn-sm" href="'.site_url('deal/accessory_supplier_order_pdf/'.$lead['id_lead']).'" target="_blank"><i class="fa fa-pdf"></i> PO to Supplier</a>
		<br />
		<br />';

		$response_data = [
			'accessory_dom' => $accessory_details,
			'lead_id'       => $lead_id,
			'status'        => $status
		];

		echo json_encode($response_data);
	}

	public function update_aftersales_status()
	{
		$post_data = $this->input->post();

		$data = $this->data;
		$this->lead_model->update_aftersales_status($post_data['lead_id'], $post_data['status'], $post_data['remarks']);

		$audit_trail_arr = array(
			'id'          => $post_data['lead_id'],
			'table_name'  => 'leads',
			'action'      => 30,
			'description' => '[{"status":"'.$post_data['status'].'"}]'
		);
		$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);

		echo "success";
	}
	
	public function payments_view ($start = 0) // PAGE VIEW //
	{
		$this->load->model('invoice_model');

		$data = $this->data;
		$data['title'] = 'Payments';

		$limit                 = 30;
		$data['payments']      = $this->payment_model->get_all_payments($_GET, $data['user_id'], $data['admin_type'], $start, $limit);
		$count_result          = $this->payment_model->get_all_payments_count($_GET, $data['user_id'], $data['admin_type']);
		$data['eway_trans']    = $this->lead_model->get_eway_transactions();
		$data['payment_types'] = $this->payment_model->get_payment_types();

		$this->load->library('pagination');
		$config['base_url']   = site_url('deal/payments_view/'); 
		$config['total_rows'] = $count_result['cnt'];
		$config['per_page']   = $limit;
		$this->pagination->initialize($config);
		$data['links']        = $this->pagination->create_links();

		$data['session_data'] = $this->data;

		$this->load->view('admin/payments', $data);
	}

	public function search_lead ()
	{
		$post_data = $this->input->post();

		$result = $this->payment_model->search_lead($post_data['search_lead_email'], $post_data['search_lead_name'], $post_data['search_lead_qm']);

		if(count($result) > 0)
		{
			$html = '
			<div class="table-responsive" style="white-space: nowrap;">
				<table class="table table-bordered table-striped table-condensed mb-none">
					<thead>
						<tr>
							<th></th>
							<th>QM Number</th>
							<th>Email</th>
							<th>Name</th>
							<th>Phone</th>
							<th>Mobile</th>
							<th>Make</th>
							<th>State</th>
						</tr>
					</thead>
					<tbody>';
						foreach($result as $r_key => $r_val)
						{

							$html .= '
							<tr>
								<td align="center"><span class="select_lead" style="cursor: pointer; cursor: hand; color: #58c603;" data-lead_id="'.$r_val['id_lead'].'"><i class="fa fa-check" data-toggle="tooltip" data-placement="top" data-original-title="Select Lead"></i></span></td>
								<td>'. $r_val['qm_number'] .'</td>
								<td>'. $r_val['email'] .'</td>
								<td>'. $r_val['name'] .'</td>
								<td>'. $r_val['phone'] .'</td>
								<td>'. $r_val['mobile'] .'</td>
								<td>'. $r_val['make'] .'</td>
								<td>'. $r_val['state'] .'</td>
							</tr>';
						}
						$html .= '
					</tbody>
				</table>
			</div>';
		}
		else
		{
			$html = '
			<div class="table-responsive">
				<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
					<thead>						
						<th></th>
						<th>Email</th>
						<th>Name</th>
						<th>Phone</th>
						<th>Mobile</th>
						<th>Make</th>
						<th>State</th>
					</thead>					
					<tbody>
						<tr><td colspan="7"><center><i>No results found!</i></center></td></tr>
					</tbody>
				</table>
			</div>';
		}
		echo $html;
	}

	public function get_specific_lead ()
	{
		$lead_id = $this->input->post("lead_id");

		$result = $this->payment_model->get_searched_lead($lead_id);

		$html = '
			<div class="table-responsive">
				<input type="hidden" id="payment_hidden_assign_lead_id" value="'.$result["id_lead"].'">
				<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
					<tbody>
						<tr>
							<td>QM Number</td>
							<td>'.$result['qm_number'].'</td>
						</tr>
						<tr>
							<td>Email</td>
							<td>'.$result['email'].'</td>
						</tr>
						<tr>
							<td>Name</td>
							<td>'.$result['name'].'</td>
						</tr>
						<tr>
							<td>Phone</td>
							<td>'.$result['phone'].'</td>
						</tr>
						<tr>
							<td>Mobile</td>
							<td>'.$result['mobile'].'</td>
						</tr>
						<tr>
							<td>Address</td>
							<td>'.$result['address'].'</td>
						</tr>
						<tr>
							<td>State</td>
							<td>'.$result['state'].'</td>
						</tr>
						<tr>
							<td>Postcode</td>
							<td>'.$result['postcode'].'</td>
						</tr>
						<tr>
							<td>Make</td>
							<td>'.$result['make'].'</td>
						</tr>
						<tr>
							<td>Model</td>
							<td>'.$result['model'].'</td>
						</tr>
						<tr>
							<td>QM Staff</td>
							<td>'.$result['qm_user'].'</td>
						</tr>
					</tbody>
				</table>
			</div>';

		echo $html;
	}

	public function assign_payment_to_lead ()
	{
		$data = $this->data;
		$post_data = $this->input->post();

		$this->payment_model->assign_payment_to_lead($post_data);

		$description = '[{"lead_id":"'.$post_data['lead_id'].'","payment_type":"'.$post_data['payment_type'].'"}]';

		$audit_trail_arr = array(
			'id'          => $post_data['payment_id'],
			'table_name'  => 'payments',
			'action'      => 32,
			'description' => $description
		);

		$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);
	}

	public function client_invoice_modal ($lead_id) // Client Invoice Generator Modal
	{
		$lead = $this->lead_model->get_lead($lead_id);
		$lead_calculation_details = $this->calculate_deal_old($lead);

		$fuel_efficient_flag_1 = "";
		$fuel_efficient_flag_2 = "";
		if ($lead['invoice_fuel_efficient_flag']==1) { $fuel_efficient_flag_1 = " selected"; }
		else if ($lead['invoice_fuel_efficient_flag']==2) { $fuel_efficient_flag_2 = " selected"; }

		$invoice_html = '
		<div class="row">
			<div class="col-md-6">
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-condensed mb-none">
						<tr>
							<td width="60%">Client State:</td>
							<td><input value="'.$lead['state'].'" class="form-control input-sm" id="client_state" name="client_state" type="text" readonly="readonly"></td>
						</tr>
						<tr>
							<td>Dealer State:</td>
							<td><input value="'.$lead['dealer_state'].'" class="form-control input-sm" id="dealer_state" name="dealer_state" type="text" readonly="readonly"></td>
						</tr>
						<tr>
							<td>Registration Type:</td>
							<td><input value="'.$lead['registration_type'].'" class="form-control input-sm" id="registration_type" name="registration_type" type="text" readonly="readonly"></td>
						</tr>
						<tr>
							<td>Fuel Efficient:</td>
							<td>
								<select class="form-control input-sm" name="fuel_efficient_flag" id="fuel_efficient_flag" onchange="calculate_deal()">
									<option name="fuel_efficient_flag" value="0"></option>
									<option name="fuel_efficient_flag" value="2" '.$fuel_efficient_flag_2.'>No</option>
									<option name="fuel_efficient_flag" value="1" '.$fuel_efficient_flag_1.'>Yes</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>LCT Threshold:</h5></td>
							<td><input value="'.$lead_calculation_details['lct_threshold'].'" class="form-control input-sm text-right" id="lct_threshold" name="lct_threshold" type="text" readonly="readonly"></td>
						</tr>
					</table>
					<br />
				</div>
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-condensed mb-none">
						<tr>
							<td width="60%">List Price:</td>
							<td><input value="'.$lead['retail_price'].'" class="form-control input-sm text-right" id="list_price" name="list_price" type="text" readonly="readonly"></td>
						</tr>
						<tr>
							<td>Options:</td>
							<td><input value="'.$lead['options_total'].'" class="form-control input-sm text-right" id="options_total" name="options_total" type="text" readonly="readonly"></td>
						</tr>
						<tr>
							<td>Accessories:</td>
							<td><input value="'.$lead['accessories_total'].'" class="form-control input-sm text-right" id="accessories_total" name="accessories_total" type="text" readonly="readonly"></td>
						</tr>
						<tr>
							<td><b>RRP:</b></td>
							<td><input value="'.$lead_calculation_details['rrp'].'" class="form-control input-sm text-right" id="rrp" name="rrp" type="text" readonly="readonly"></td>
						</tr>
						<tr>
							<td>Dealer Delivery:</td>
							<td><input value="'.$lead['edited_dealer_delivery'].'" class="form-control input-sm text-right" id="edited_dealer_delivery" name="edited_dealer_delivery" type="text" onkeypress="return isNumberKey(event)" onchange="calculate_deal()"></td>
						</tr>
						<tr>
							<td><b>Price Plus Options & Delivery:</b></td>
							<td><input value="'.$lead_calculation_details['subtotal_1'].'" class="form-control input-sm text-right" id="subtotal_1" name="subtotal_1" type="text" readonly="readonly"></td>
						</tr>
						<tr>
							<td>Discount (-):</td>
							<td><input value="'.$lead['edited_dealer_discount'].'" class="form-control input-sm text-right" id="edited_dealer_discount" name="edited_dealer_discount" type="text" onkeypress="return isNumberKey(event)" onchange="calculate_deal()"></td>
						</tr>
						<tr>
							<td>Fleet Claim (-):</td>
							<td><input value="'.$lead['edited_fleet_discount'].'" class="form-control input-sm text-right" id="edited_fleet_discount" name="edited_fleet_discount" type="text" onkeypress="return isNumberKey(event)" onchange="calculate_deal()"></td>
						</tr>
						<tr>
							<td><b>Sub Total:</b></td>
							<td><input value="'.$lead_calculation_details['subtotal_2'].'" class="form-control input-sm text-right" id="subtotal_2" name="subtotal_2" type="text" readonly="readonly"></td>
						</tr>
						<tr>
							<td>GST:</td>
							<td><input value="'.$lead_calculation_details['gst'].'" class="form-control input-sm text-right" id="gst" name="gst" type="text" readonly="readonly"></td>
						</tr>
						<tr>
							<td><b>Sub Total (Inc GST):</b></td>
							<td><input value="'.$lead_calculation_details['subtotal_3'].'" class="form-control input-sm text-right" id="subtotal_3" name="subtotal_3" type="text" readonly="readonly"></td>
						</tr>							
						<tr>
							<td>LCT:</td>
							<td><input value="'.$lead_calculation_details['lct'].'" class="form-control input-sm text-right" id="lct" name="lct" type="text" readonly="readonly"></td>
						</tr>
						<tr>
							<td>Stamp Duty:</td>
							<td><input value="'.$lead_calculation_details['stamp_duty'].'" class="form-control input-sm text-right" id="stamp_duty" name="stamp_duty" type="text" readonly="readonly"></td>
						</tr>
						<tr>
							<td>Registration:</td>
							<td><input value="'.$lead['edited_registration'].'" class="form-control input-sm text-right" id="edited_registration" name="edited_registration" type="text" onkeypress="return isNumberKey(event)" onchange="calculate_deal()"></td>
						</tr>
						<tr>
							<td>CTP:</td>
							<td><input value="'.$lead['edited_ctp'].'" class="form-control input-sm text-right" id="edited_ctp" name="edited_ctp" type="text" onkeypress="return isNumberKey(event)" onchange="calculate_deal()"></td>
						</tr>
						<tr>
							<td><b>SALES PRICE:</b></td>
							<td><input value="'.$lead_calculation_details['sales_price'].'" class="form-control input-sm text-right" id="sales_price" name="sales_price" type="text" readonly="readonly"></td>
						</tr>
						<tr>
							<td><b>SALES PRICE (FROM QS):</b></td>
							<td><input value="'.$lead['sales_price'].'" class="form-control input-sm text-right" id="sales_price_reference" name="sales_price_reference" type="text" readonly="readonly"></td>
						</tr>						
					</table>
					<br />
				</div>
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-condensed mb-none">
						<tr>
							<td width="60%">Real TradeIn Value:</td>
							<td><input value="'.$lead['tradein_value'].'" class="form-control input-sm text-right" id="tradein_value" name="tradein_value" type="text"  readonly="readonly"></td>
						</tr>						
						<tr>
							<td>Shown TradeIn Value:</td>
							<td><input value="'.$lead['tradein_given'].'" class="form-control input-sm text-right" id="tradein_given" name="tradein_given" type="text"  readonly="readonly"></td>
						</tr>
						<tr>
							<td>TradeIn Payout:</td>
							<td><input value="'.$lead['tradein_payout'].'" class="form-control input-sm text-right" id="tradein_payout" name="tradein_payout" type="text"  readonly="readonly"></td>
						</tr>									
						<tr>
							<td>Total Deposits:</td>
							<td><input value="'.$lead['deposits_total'].'" class="form-control input-sm text-right" id="deposits_total" name="deposits_total" type="text" readonly="readonly"></td>
						</tr>
						<tr>
							<td>Total Refunds:</td>
							<td><input value="'.$lead['refunds_total'].'" class="form-control input-sm text-right" id="refunds_total" name="refunds_total" type="text" readonly="readonly"></td>
						</tr>
						<tr>
							<td><b>BALANCE PAYABLE:</b></td>
							<td><input value="'.$lead_calculation_details['balance'].'" class="form-control input-sm text-right" id="balance" name="balance" type="text" readonly="readonly"></td>
						</tr>
					</table>
					<br />
				</div>
			</div>
			<div class="col-md-6">
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-condensed mb-none">
					
						<tr>
							<td width="60%">Dealer Quoted Price:</td>
							<td align="right">
								<input value="'.$lead['winning_price'].'" class="form-control input-sm text-right" id="dqp" name="dqp" type="text" readonly="readonly">
								<input value="'.$lead['gross_subtractor'].'" type="hidden" id="membership" name="membership">
								<input value="'.$lead['gross_subtractor_lower'].'" type="hidden" id="membership_lower" name="membership_lower">
							</td>
						</tr>						
						<tr>
							<td>Trades Attached to this Deal:</td>
							<td><input value="'.$lead['tradein_count'].'" class="form-control input-sm text-right" id="tradein_count" name="tradein_count" type="text" readonly></td>
						</tr>
						<tr>
							<td>Trades the dealer is taking:</td>
							<td><input value="'.$lead['dealer_tradein_count'].'" class="form-control input-sm text-right" id="dealer_tradein_count" name="dealer_tradein_count" type="text" readonly></td>
						</tr>
						<tr>
							<td>Dealer\'s Trade Value <i>(If the dealer is taking the trade)</i>:</td>
							<td><input value="'.$lead['dealer_tradein_value'].'" class="form-control input-sm text-right" id="dealer_tradein_value" name="dealer_tradein_value" type="text" readonly></td>
						</tr>				
						<tr>
							<td><b>DEALER CHANGEOVER PRICE:</b></td>
							<td><input value="'.$lead['dealer_changeover'].'" class="form-control input-sm text-right" id="dealer_changeover" name="dealer_changeover" type="text" readonly></td>
						</tr>					
						<tr>
							<td><b>OUR CHANGEOVER:</b></td>
							<td><input value="'.$lead_calculation_details['changeover'].'" class="form-control input-sm text-right" id="changeover" name="changeover" type="text" readonly="readonly"></td>
						</tr>
						<tr>
							<td width="60%">Other Costs (Amount):</td>
							<td><input value="'.$lead['other_costs_amount'].'" class="form-control input-sm text-right" id="other_costs_amount" name="other_costs_amount" type="text"  readonly="readonly"></td>
						</tr>
						<tr>
							<td>Other Costs (Description):</td>
							<td>
								<textarea class="form-control input-sm" id="other_costs_description" name="other_costs_description" readonly="readonly">'.$lead['other_costs_description'].'</textarea>
							</td>
						</tr>					
						<tr>
							<td><b>COMMISSIONABLE GROSS:</b></td>
							<td><input value="'.$lead_calculation_details['commissionable_gross'].'" class="form-control input-sm text-right" id="commissionable_gross" name="commissionable_gross" type="text" readonly="readonly"></td>
						</tr>
						<tr>
							<td>Other Revenue (Amount):</td>
							<td><input value="'.$lead['other_revenue_amount'].'" class="form-control input-sm text-right" id="other_revenue_amount" name="other_revenue_amount" type="text"  readonly="readonly"></td>
						</tr>
						<tr>
							<td>Other Revenue (Description):</td>
							<td>
								<textarea class="form-control input-sm" id="other_revenue_description" name="other_revenue_description" readonly="readonly">'.$lead['other_revenue_description'].'</textarea>
							</td>
						</tr>						
						<tr>
							<td><b>TOTAL REVENUE:</b></td>
							<td><input value="'.$lead_calculation_details['revenue'].'" class="form-control input-sm text-right" id="revenue" name="revenue" type="text" readonly="readonly"></td>
						</tr>
					</table>
				</div>
			</div>
		</div>';		

		$output_arr = array(
			"cq_number" => $lead['cq_number'],
			"invoice_html" => $invoice_html
		);

		echo json_encode($output_arr);
	}

	public function update_client_invoice () // Updating of Values from Client Invoice Generator Modal
	{
		$data = $this->data;
		$input_arr = $this->input->post();
		$this->lead_model->update_lead_details($input_arr);
	}
	
	public function get_searched_payments ()
	{
		$post_data = $this->input->post();

		$result = $this->payment_model->get_searched_payments($post_data['search_payment_reference'], $post_data['search_payment_amount'], $post_data['search_payment_created_at']);

		if(count($result) > 0)
		{
			$html = '
			<div class="table-responsive" style="white-space: nowrap;">
				<table class="table table-bordered table-striped table-condensed mb-none">
					<thead>						
						<tr>
							<th></th>
							<th>Reference</th>
							<th>Amount</th>
							<th>Admin Fee</th>
							<th>Merchant Cost</th>
						</tr>
					</thead>
					<tbody>';
						foreach($result as $r_key => $r_val)
						{

							$html .= '
							<tr>
								<td align="center"><span class="select_payment" style="cursor: pointer; cursor: hand; color: #58c603;" data-payment_id="'.$r_val['id_payment'].'"><i class="fa fa-plus" data-toggle="tooltip" data-placement="top" data-original-title="Select Payment"></i></span></td>
								<td>'. $r_val['reference_number'] .'</td>
								<td>'. $r_val['amount'] .'</td>
								<td>'. $r_val['admin_fee'] .'</td>
								<td>'. $r_val['merchant_cost'] .'</td>
								<td>'. $r_val['created_at'] .'</td>
							</tr>';
						}
						$html .= '
					</tbody>
				</table>
			</div>';
		}
		else
		{
			$html = '
			<div class="table-responsive">
				<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
					<thead>						
						<th></th>
						<th>Reference</th>
						<th>Amount</th>
						<th>Admin Fee</th>
						<th>Merchant Cost</th>
					</thead>					
					<tbody>
						<tr><td colspan="5"><center><i>No results found!</i></center></td></tr>
					</tbody>
				</table>
			</div>';
		}

		echo $html;
	}

	public function attach_payment_to_lead ()
	{
		$post_data = $this->input->post();

		$result = $this->payment_model->attach_payment_to_lead($post_data['payment_id'], $post_data['lead_id']);

		echo json_encode($result);
	}
}
?>
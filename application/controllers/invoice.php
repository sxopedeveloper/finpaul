<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//error_reporting(0);
require_once('admin_main.php');
ob_start();

class Invoice extends Admin_main
{
	public function __construct()
	{
		parent::__construct();
		
	}

	public function index ()
	{
		$data = $this->data;
		$data['title'] = 'Deals - Invoices';
		$data['invoices'] = $this->invoice_model->get_invoices();
		$this->load->view('admin/invoices', $data);
	}

	public function generate_pdf_dealer_invoice ($lead_id) // PDF GENERATION
	{
		$data = $this->data;
		$data['title'] = 'Tax Invoice';

		$data['company_settings'] = $this->settings;
		$data['lead'] = $this->lead_model->get_lead($lead_id);
		$data['revenue_details'] = $this->calculate_revenue($data['lead']);

		$data['deposits'] = $this->lead_model->get_lead_deposits($lead_id);
		$data['refunds'] = $this->lead_model->get_lead_refunds($lead_id);		
		$data['deposit_trans'] = $this->lead_model->get_lead_deposit_trans($lead_id);

		$data['from_details'] = "
		<b>".$data['company_settings']['company_name']."</b><br />
		".$data['company_settings']['company_alternate_email']."<br />
		".$data['company_settings']['company_postal_address_line_1'].", ".$data['company_settings']['company_postal_address_line_2'].",<br />
		".$data['company_settings']['company_postal_suburb'].", ".$data['company_settings']['company_postal_state']." ".$data['company_settings']['company_postal_postcode']."<br />
		Call ".$data['company_settings']['company_phone'];
		
		$data['to_details'] = 
		"<b>".$data['lead']['dealership_name'] . "</b><br />" .
		$data['lead']['fleet_manager'] . "<br />" .
		$data['lead']['dealer_email'] . "<br />" .
		$data['lead']['dealer_address'] . "<br />" . 
		$data['lead']['dealer_state'] . " " . $data['lead']['dealer_postcode'] . "<br />";

		// INVOICE DATES (Start) //
		if ($data['lead']['order_date'] == "")
		{
			$data['issued_date'] = "";
		}
		else
		{			
			$data['issued_date'] = date('d F Y', strtotime($data['lead']['order_date']));
		}
		
		if ($data['lead']['delivery_date'] == "")
		{
			$data['payment_due_date'] = "";
		}
		else
		{
			$data['payment_due_date'] = date('d F Y', strtotime($data['lead']['delivery_date']));
		}
		// INVOICE DATES (End) //

		$dealer_invoice_details = $this->calculate_dealer_invoice($data['lead'], $data['revenue_details'], $data['deposits'], $data['refunds'], $data['deposit_trans']);
		
		$data['line_items'] = $dealer_invoice_details['line_items'];
		$data['gst'] = $dealer_invoice_details['gst'];
		$data['balance_payable'] = $dealer_invoice_details['balance_payable'];
	
		$filename = 'DI_'.str_replace('QM', '', $data['lead']['cq_number'])."_".date("Ymdhis");
		$pdfFilePath = FCPATH."/uploads/invoice_files/".$filename.".pdf";
// echo $pdfFilePath; die();
		ini_set('memory_limit','512M');
		$html = $this->load->view('admin/pdf_renders/dealer_invoice_print_final', $data, true);		
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->SetHTMLFooter($this->pdf_footer);
		$pdf->WriteHTML($html);
		$pdf->Output($pdfFilePath, 'F');
		
		$path = "/uploads/invoice_files/".$filename.".pdf";
		
		$input_arr = array(
			'id' => $lead_id,
			'table_name' => 'leads',
			'pdf_type' => 'Dealer Invoice',
			'path' => $path
		);
		$this->pdf_model->insert_pdf($data['user_id'], $input_arr);

		return $path;
	}	
	
	public function generate_pdf_admin_fee_invoice ($lead_id, $amount = 165) // PDF GENERATION
	{
		$data = $this->data;
		$data['title'] = 'Tax Invoice';

		$data['company_settings'] = $this->settings;
		$data['lead'] = $this->lead_model->get_lead($lead_id);
		$data['revenue_details'] = $this->calculate_revenue($data['lead']);

		$data['from_details'] = "
		<b>".$data['company_settings']['company_name']."</b><br />
		".$data['company_settings']['company_alternate_email']."<br />
		".$data['company_settings']['company_postal_address_line_1'].", ".$data['company_settings']['company_postal_address_line_2'].",<br />
		".$data['company_settings']['company_postal_suburb'].", ".$data['company_settings']['company_postal_state']." ".$data['company_settings']['company_postal_postcode']."<br />
		Call ".$data['company_settings']['company_phone'];
		
		$data['to_details'] = 
		"<b>".$data['lead']['name'] . "</b><br />" .
		$data['lead']['email'] . "<br />" .
		$data['lead']['address'] . "<br />" .
		$data['lead']['state'] . " " . $data['lead']['postcode'] . "<br />" .
		$deal['lead']['phone'];

		// INVOICE DATES (Start) //
		if ($data['lead']['order_date'] == "")
		{
			$data['issued_date'] = "";
		}
		else
		{			
			$data['issued_date'] = date('d F Y', strtotime($data['lead']['order_date']));
		}
		
		if ($data['lead']['order_date'] == "")
		{
			$data['payment_due_date'] = "";
		}
		else
		{
			$data['payment_due_date'] = date('d F Y', strtotime($data['lead']['order_date'] . ' +1 day'));
		}
		// INVOICE DATES (End) //
		
		$admin_fee_invoice_details = array(
			'line_items' => array(
			
			),
			'gst' => '',
			'balance_payable' => $amount
		);
		
		$data['line_items'] = $admin_fee_invoice_details['line_items'];
		$data['gst'] = $admin_fee_invoice_details['gst'];
		$data['balance_payable'] = $admin_fee_invoice_details['balance_payable'];
	
		$filename = 'AI_'.str_replace('QM', '', $data['lead']['cq_number'])."_".date("Ymdhis");
		$pdfFilePath = FCPATH."/uploads/invoice_files/".$filename.".pdf";

		ini_set('memory_limit','512M');
		$html = $this->load->view('admin/pdf_renders/admin_fee_invoice_print_final', $data, true);
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->SetHTMLFooter($this->pdf_footer);
		$pdf->WriteHTML($html);
		$pdf->Output($pdfFilePath, 'F');
		$path = "/uploads/invoice_files/".$filename.".pdf";
		
		$input_arr = array(
			'id' => $lead_id,
			'table_name' => 'leads',
			'pdf_type' => 'Admin Fee Invoice',
			'path' => $path
		);
		$this->pdf_model->insert_pdf($data['user_id'], $input_arr);

		return $path;
	}
	
	public function generate_pdf_custom_invoice ($invoice_id) // PDF GENERATION
	{
		$data = $this->data;
		$data['title'] = 'Tax Invoice';

		$data['company_settings'] = $this->settings;		
		$data['invoice'] = $this->invoice_model->get_invoice($invoice_id);
		$data['invoice_items'] = $this->invoice_model->get_invoice_items($invoice_id);	

		$data['from_details'] = "
		<b>".$data['company_settings']['company_name']."</b><br />
		".$data['company_settings']['company_alternate_email']."<br />
		".$data['company_settings']['company_postal_address_line_1'].", ".$data['company_settings']['company_postal_address_line_2'].",<br />
		".$data['company_settings']['company_postal_suburb'].", ".$data['company_settings']['company_postal_state']." ".$data['company_settings']['company_postal_postcode']."<br />
		Call ".$data['company_settings']['company_phone'];		

		if ($data['invoice']['invoice_type']=="Dealer")
		{
			$data['to_details'] =
			"<b>".$data['invoice']['dealership_name']." (".$data['invoice']['dealer_name'].")</b><br />" .
			$data['invoice']['dealer_email'] . "<br />" .
			$data['invoice']['dealer_address'] . "<br />" . 
			$data['invoice']['dealer_state'] . " " . $data['invoice']['dealer_postcode'] . "<br />" . 
			$data['invoice']['dealer_phone'];
		}
		else if ($data['invoice']['invoice_type']=="Client")
		{
			$client_business_name = "";
			if ($data['invoice']['client_business_name']<>"")
			{
				$client_business_name = "(".$data['invoice']['client_business_name'].")";
			}
			$data['to_details'] =
			"<b>".$data['invoice']['dealership_name']." ".$client_business_name."</b><br />" .
			$data['invoice']['client_email'] . "<br />" .
			$data['invoice']['client_address'] . "<br />" . 
			$data['invoice']['client_state'] . " " . $data['invoice']['client_postcode'] . "<br />" . 
			$data['invoice']['client_phone'];	
		}
		else if ($data['invoice']['invoice_type']=="Wholesaler")
		{
			$data['to_details'] = "";
		}

		$data['gst'] = $data['invoice']['amount'] / 11;
		
		$data['lead']['id_lead'] = $data['invoice']['id_lead'];
		$data['lead']['cq_number'] = $data['invoice']['cq_number'];
		
		$custom_invoice_details = array(
			'line_items' => array(
			
			),
			'gst' => $data['gst'],
			'balance_payable' => $data['invoice']['amount']
		);
		
		$filename = 'CI_'.str_replace('QM', '', $data['lead']['cq_number'])."_".date("Ymdhis");
		$pdfFilePath = FCPATH."/uploads/invoice_files/".$filename.".pdf";

		ini_set('memory_limit','512M');
		$html = $this->load->view('admin/pdf_renders/custom_invoice_print_final', $data, true);
		// echo $html;
		// die ();
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->SetHTMLFooter($this->pdf_footer);
		$pdf->WriteHTML($html);
		$pdf->Output($pdfFilePath, 'F');
		$path = "/uploads/invoice_files/".$filename.".pdf";
		
		$input_arr = array(
			'id' => $invoice_id,
			'table_name' => 'invoices',
			'pdf_type' => 'Client Invoice',
			'path' => $path
		);
		$this->pdf_model->insert_pdf($data['user_id'], $input_arr);

		return $path;
	}	

	public function pdf_dealer_invoice ($lead_id) // PDF RENDER
	{
		$customurl='http://portal.finquote.com.au';
		$path = $customurl.$this->generate_pdf_dealer_invoice($lead_id);
	   // $path = $this->generate_pdf_dealer_invoice($lead_id);
		redirect($path);
	}	
	
	public function pdf_custom_invoice ($invoice_id) // PDF RENDER
	{
		$customurl='http://portal.finquote.com.au';
		$path = $customurl.$this->generate_pdf_custom_invoice($invoice_id);
		redirect($path);
	}
	
	public function add_invoice ()
	{
		
		$data = $this->data;
		$input_arr = $this->input->post();
		
		//echo json_encode($input_arr); die();
		$invoice_amount = 0;
		foreach ($input_arr['invoice_item_amount'] AS $invoice_item_amount)
		{
			if ($invoice_item_amount <> "" AND $invoice_item_amount <> 0)
			{
				$invoice_amount += $invoice_item_amount;
			}
		}		

		if (isset($input_arr['id_lead']) AND $input_arr['id_lead'] <> "")
		{
			$lead = $this->lead_model->get_lead($input_arr['id_lead']);
			
			$input_arr['invoice_number'] = "CI_".$lead['cq_number_only'];
			$input_arr['invoice_name'] = "Client Invoice";
			$input_arr['invoice_type'] = "Client";
			$input_arr['amount'] = $invoice_amount;
			$input_arr['invoice_date'] = $lead['order_date'];
			$input_arr['due_date'] = "0000-00-00 00:00:00";
			$input_arr['promised_date'] = "0000-00-00 00:00:00";
			$input_arr['details'] = $input_arr['details'];
			$input_arr['remarks'] = $input_arr['remarks'];
		}
		else // TO FOLLOW //
		{
			$input_arr['id_lead'] = 0;
			$input_arr['invoice_number'] = "";
			$input_arr['invoice_name'] = "";
			$input_arr['invoice_type'] = "";
			$input_arr['amount'] = "";
			$input_arr['invoice_date'] = "";
			$input_arr['due_date'] = "";
			$input_arr['promised_date'] = "";
			$input_arr['details'] = $input_arr['details'];
			$input_arr['remarks'] = $input_arr['remarks'];				
		}

		$insert_invoice_result = $this->invoice_model->insert_invoice($data['user_id'], $input_arr);

		if ($insert_invoice_result)
		{
			$invoice_id = $this->db->insert_id();

			foreach ($input_arr['invoice_item_amount'] AS $invoice_item_index => $invoice_item_amount)
			{
				if ($invoice_item_amount <> "" AND $invoice_item_amount <> 0)
				{
					$invoice_item_input_arr['amount'] = $invoice_item_amount;
					$invoice_item_input_arr['description'] = $input_arr['invoice_item_description'][$invoice_item_index];
					$insert_invoice_item_result = $this->invoice_model->insert_invoice_item($invoice_id, $invoice_item_input_arr);
				}
			}

			echo "success";
		}
		else
		{
			echo "fail";
		}
	}
	
	public function delete_invoice ()
	{
		$data = $this->data;
		$input_arr = $this->input->post();

		if (isset($input_arr['id_invoice']))
		{
			$delete_invoice_result = $this->invoice_model->delete_invoice($input_arr['id_invoice']);

			if ($delete_invoice_result)
			{
				echo "success";
			}
		}
		else
		{
			echo "fail";
		}
	}	
}

?>
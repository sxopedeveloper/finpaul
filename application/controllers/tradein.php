<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('user_main.php');

require_once("./application/libraries/PDFMerger/PDFMerger.php");
require_once("./application/libraries/PDFMerger/fpdf/fpdf.php");
require_once("./application/libraries/PDFMerger/fpdi/fpdi.php");
ob_start();
class Tradein extends User_main
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('image_lib');
        $this->load->library('encrypt');
	}

	function index()
	{
		// echo "string"; die();
		header("Location: " . site_url('tradein/list_view'));
		exit();
	}
    
    public function list_view ($start = 0) // PAGE VIEW (LV)
	{		
		$data = $this->data;
		$data['title'] = 'Trade-In - List View';

		$limit = 50;
		$count_result = $this->tradein_model->get_tradeins_count($_GET, $data['user_id'], $data['login_type']);  // Record count
		$data['tradeins'] = $this->tradein_model->get_tradeins($_GET, $data['user_id'], $data['login_type'], $start, $limit); // Main Query
		$this->load->library('pagination');
		$config['base_url'] = site_url('tradein/list_view/'); 
		$config['total_rows'] = $count_result['cnt'];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config); 
		$data['links'] = $this->pagination->create_links();
		$data['result_count'] = $count_result['cnt'];

		$this->load->view('admin/tradeins', $data);
	}

	public function tile_view ($start = 0) // TILE VIEW
	{
		$data = $this->data;

		$data['title'] = 'Trade-In - Tile View';
		$limit = 20;
		$count_result = $this->tradein_model->get_tradeins_count($_GET, $data['user_id'], $data['login_type']);  // Record count
		$data['tradeins'] = $this->tradein_model->get_tradeins($_GET, $data['user_id'], $data['login_type'], $start, $limit); // Main Query
		$this->load->library('pagination');
		$config['base_url'] = site_url('tradein/tile_view/'); 
		$config['total_rows'] = $count_result['cnt'];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config); 
		$data['links'] = $this->pagination->create_links();
		$data['result_count'] = $count_result['cnt'];

		$doc_type_array = [];

		foreach ($data['tradeins'] as $tradein) 
		{
			$doc_type_array[$tradein['id_tradein']] = $this->lead_model->get_tradein_document_class($tradein['id_tradein']);
		}

		$data['doc_type_arr'] = $doc_type_array;

		$this->load->view('admin/tradeins_tile', $data);
	}

	public function upload_email_attachments ()
	{
		$directory = "uploads/temp/";
		$prefix = time() . '_';
		$file_name = $_FILES['file']['name'];
		$file_tmp = $_FILES['file']['tmp_name'];
		$file = $directory.$prefix.$file_name;
		
	    if (move_uploaded_file($file_tmp, $file))
		{
			echo $file;
	    }
	}	
	
	public function forward_pdf ()
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;
		
		$input_arr = $this->input->post();		
		
		$attachment_string = "";

		$file = $this->generate_pdf($input_arr['id_tradein']);
		$file = ltrim($file, "/");			
		$attachment_string .= $file . "[path]";

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
		
		$error = 0;
		if ($input_arr['recipient_type'] == 1)
		{
			if ($input_arr['recipient'] != "")
			{
				$this->send_templated_email($data['username'], $data['name'], $input_arr['recipient'], $input_arr['subject'], $input_arr['message'], $attachment_string);
			}
			else
			{
				$error ++;
			}
		}
		else if ($input_arr['recipient_type'] == 2)
		{
			
		}
		else if ($input_arr['recipient_type'] == 3)
		{
			
		}

		if ($error == 0)
		{
			echo "success";
		}
		else
		{
			echo "fail";
		}
	}	
	
	public function new_record ()
	{
		$data = $this->data;
		$data['title'] = 'Trade-In - Create New';
		$this->load->view('admin/tradein_form', $data);
	}
	
	public function record ($tradein_id) // MODAL VIEW
	{
		$data = $this->data;

		$query = "
		SELECT
		t.`id_tradein`, t.`fk_user`, t.`fk_lead`, 
		t.`first_name`, t.`last_name`, t.`email`, t.`phone`, t.`state`, t.`postcode`, 
		t.`registration_plate`, t.`rego_expiry`, 
		t.`tradein_value`, t.`tradein_given`, t.`tradein_payout`,
		t.`tradein_make`, t.`tradein_model`, t.`tradein_build_date`, t.`tradein_variant`, t.`tradein_colour`, t.`tradein_body_type`, t.`tradein_fuel_type`, 
		t.`tradein_drive_type`, t.`tradein_transmission`, t.`tradein_compliance_date`, t.`tradein_kms`, t.`tradein_service_history`, 
		t.`options_1`, t.`accessories_1`,
		t.`warning_lights`, t.`damage`, t.`lease`, t.`bought_new`, t.`accessories_working`, t.`accident`, t.`paint_work`, t.`other_info`, 
		t.`image_1`, t.`image_2`, t.`image_3`, t.`image_4`, t.`deprecated`, t.`created_at`,
		u.`name` AS `qs_name`, u.`email` AS `qs_email`,

		t.`contact_name`, t.`contact_number`, t.`contact_type`, 
		DATE(t.pickup_datetime) AS `pickup_date`, DATE_FORMAT(t.`pickup_datetime`,'%H:%i:%s') AS `pickup_time`,
		t.`trans_flag`, t.`transport_company`, t.`transport_contact_num`, t.`cost_of_transport`, t.`booking_made`, t.`book_ref_number`, t.`pickup_address`,
		l.`delivery_date` as `lead_delivery_date`, l.`id_lead` as `lead_id`,

		l.`tradein_value`, l.`tradein_payout`, l.`tradein_given`,
		
		t.`tradein_vin`, t.`tradein_eng`, t.`compliance_date`, t.`total_payment_amount`, t.`payment_due`, t.`client_payment`, t.`dealer_payment`, t.`payment_amount`, t.`bank_details`, t.`bank_account`, t.`bsb`, t.`reference`, t.`ppsr`, t.`special_request`

		FROM tradeins t 
		LEFT JOIN users u ON t.`fk_user` = u.`id_user`
		LEFT JOIN leads l ON t.`fk_lead` = l.`id_lead`
		WHERE t.`id_tradein` = ".$tradein_id;
		$result = $this->db->query($query);
		if (count($result->result())==0)
		{
			$tradein_details = '<br /><br /><center><i>No result found!</i></center>';
		}
		else
		{
			foreach ($result->result() as $row)
			{
				$tradein_details = '';
				if ($row->image_1=="") { $row->image_1 = "no_image.png"; }
				if ($row->image_2=="") { $row->image_2 = "no_image.png"; }
				if ($row->image_3=="") { $row->image_3 = "no_image.png"; }
				if ($row->image_4=="") { $row->image_4 = "no_image.png"; }

				if ($data['login_type']=="Admin" AND $data['user_id']<> 554)
				{
					if( $row->pickup_time == "00:00:00" )
					{
						$row->pickup_time = date('h:i:s A', strtotime("09:00"));
					}
					else
					{
						$row->pickup_time = date('h:i:s A', strtotime($row->pickup_time));
					}

					if( $row->pickup_date == "0000-00-00" )
					{
						if($row->lead_delivery_date == "0000-00-00 00:00:00" || $row->lead_delivery_date == "" || $row->lead_delivery_date === NULL)
						{
							$row->pickup_date = "";
						}
						else
						{
							$row->pickup_date = date('Y-m-d', strtotime($row->lead_delivery_date . ' +1 day'));
						}
					}
					else
					{
						$row->pickup_date = date('Y-m-d', strtotime($row->pickup_date));
					}
					
					$total_payment_amount = 0;
					if ($row->fk_lead <> 0)
					{
						$lead_details = $this->lead_model->get_lead($row->fk_lead);
						$revenue_details = $this->calculate_revenue($lead_details);
						$total_payment_amount = $lead_details['tradein_value'] - (($lead_details['winning_price'] - $revenue_details['balance']) + $lead_details['tradein_payout']);						
					}

					$tradein_details .= '
					<input type="hidden" id="id_tradein" name="id_tradein" value="'.$row->id_tradein.'" class="form-control input-sm" />
					<input type="hidden" id="hidden_lead_id_tradein" name="hidden_lead_id_tradein" value="'.$row->lead_id.'" class="form-control input-sm" />
					<input type="hidden" id="image-oldname-1" value="'.$row->image_1.'">
					<input type="hidden" id="image-oldname-2" value="'.$row->image_2.'">
					<input type="hidden" id="image-oldname-3" value="'.$row->image_3.'">
					<input type="hidden" id="image-oldname-4" value="'.$row->image_4.'">
					<div class="row">
						<div class="col-md-3">
							<div class="img-responsive img-div">
								<button type="button" class="close delete-image" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<img src="'.$this->tradein_photo_base_url_tm.$row->image_1.'" class="img-responsive img-details img-1" data-img="'.$row->image_1.'" data-img-no="1">
							</div>
						</div>
						<div class="col-md-3">
							<div class="img-responsive img-div">
								<button type="button" class="close delete-image" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<img src="'.$this->tradein_photo_base_url_tm.$row->image_2.'" class="img-responsive img-details img-2" data-img="'.$row->image_2.'" data-img-no="2">
							</div>
						</div>
						<div class="col-md-3">
							<div class="img-responsive img-div">
								<button type="button" class="close delete-image" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<img src="'.$this->tradein_photo_base_url_tm.$row->image_3.'" class="img-responsive img-details img-3" data-img="'.$row->image_3.'" data-img-no="3">
							</div>
						</div>
						<div class="col-md-3">
							<div class="img-responsive img-div">
								<button type="button" class="close delete-image" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<img src="'.$this->tradein_photo_base_url_tm.$row->image_4.'" class="img-responsive img-details img-4" data-img="'.$row->image_4.'" data-img-no="4">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<div class="panel panel-default">
								<div class="panel-body dropzone-image admin-dropzone-image-1" data-image-no="1" data-image-oldname="'.$row->image_1.'" id="admin-dropzone-image-1">
									Replace Image
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="panel panel-default">
								<div class="panel-body dropzone-image admin-dropzone-image-2" data-image-no="2" data-image-oldname="'.$row->image_2.'" id="admin-dropzone-image-2">
									Replace Image
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="panel panel-default">
								<div class="panel-body dropzone-image admin-dropzone-image-3" data-image-no="3" data-image-oldname="'.$row->image_3.'" id="admin-dropzone-image-3">
									Replace Image
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="panel panel-default">
								<div class="panel-body dropzone-image admin-dropzone-image-4" data-image-no="4" data-image-oldname="'.$row->image_4.'" id="admin-dropzone-image-4">
									Replace Image
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<br /><br />
							<h5><b>CLIENT DETAILS</b></h5><br />
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
									<tbody>
										<tr>
											<td width="50%"><b>Email Address:</b></td>
											<td><input type="text" name="email" class="form-control input-xs" value="'.$row->email.'"></td>
										</tr>
										<tr>
											<td><b>First Name:</b></td>
											<td><input type="text" name="first_name" class="form-control input-xs" value="'.$row->first_name.'"></td>
										</tr>
										<tr>
											<td><b>Last Name:</b></td>
											<td><input type="text" name="last_name" class="form-control input-xs" value="'.$row->last_name.'"></td>
										</tr>
										<tr>
											<td><b>Phone:</b></td>
											<td><input type="text" name="phone" class="form-control input-xs" value="'.$row->phone.'"></td>
										</tr>
										<tr>
											<td><b>Postcode:</b></td>
											<td><input type="text" name="postcode" class="form-control input-xs" value="'.$row->postcode.'"></td>
										</tr>
										<tr>
											<td><b>State:</b></td>
											<td><input type="text" name="state" class="form-control input-xs" value="'.$row->state.'"></td>
										</tr>
									</tbody>
								</table>
							</div>
							<br />
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">						
									<tbody>
										<tr>
											<td width="50%"><b>Registration Plate:</b></td>
											<td><input type="text" name="registration_plate" class="form-control input-xs" value="'.$row->registration_plate.'"></td>
										</tr>
										<tr>
											<td><b>Rego Expiry:</b></td>
											<td><input type="text" name="rego_expiry" class="form-control input-xs" value="'.$row->rego_expiry.'"></td>
										</tr>
										<tr>
											<td><b>VIN:</b></td>
											<td><input type="text" name="tradein_vin" class="form-control input-xs" value="'.$row->tradein_vin.'"></td>
										</tr>
										<tr>
											<td><b>Engine No.:</b></td>
											<td><input type="text" name="tradein_eng" class="form-control input-xs" value="'.$row->tradein_eng.'"></td>
										</tr>
									</tbody>
								</table>
							</div>
							<br />
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
									<tbody>
										<tr>
											<td width="50%"><b>Tradein Value:</b></td>
											<td><input type="text" id="tradein_value" name="tradein_value" value="'.$row->tradein_value.'" class="form-control input-sm" /></td></tr>
										<tr>
											<td><b>Tradein Given:</b></td>
											<td><input type="text" id="tradein_given" name="tradein_given" value="'.$row->tradein_given.'" class="form-control input-sm" /></td>
										</tr>
										<tr>
											<td><b>Tradein Payout:</b></td>
											<td><input type="text" id="tradein_payout" name="tradein_payout" value="'.$row->tradein_payout.'" class="form-control input-sm" /></td>
										</tr>
									</tbody>
								</table>
							</div>
							<br/>
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
									<tbody>
										<tr>
											<td width="50%">
												<b>Date / Time of Pickup:</b>
											</td>
											<td>
												<input class="form-control input-sm pickup_date" id="pickup_date" name="pickup_date" data-date-format="yyyy-mm-dd" value="'.$row->pickup_date.'">
											</td>
											<td>
												<input class="form-control input-sm pickup_time" id="pickup_time" name="pickup_time" value="'.$row->pickup_time.'">
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<br/>
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
									<tbody>
										<tr>
											<td width="50%"><b>Type of Contact:</b></td>
											<td>
												<select class="form-control input-sm contact_type" id="contact_type" name="contact_type">
													<option value="0" '.($row->contact_type=="0" ? "selected" : "").'></option>
													<option value="1" '.($row->contact_type=="1" ? "selected" : "").'>Dealer</option>
													<option value="2" '.($row->contact_type=="2" ? "selected" : "").'>Client</option>
													<option value="3" '.($row->contact_type=="3" ? "selected" : "").'>Other</option>
												</select>
											</td>
										</tr>
										<tr>
											<td><b>Name of Contact:</b></td>
											<td><input type="text" class="form-control input-sm contact_name" name="contact_name" value="'.$row->contact_name.'"></td>
										</tr>
										<tr>
											<td><b>Contact Number</b></td>
											<td><input type="text" class="form-control input-sm contact_number" name="contact_number" value="'.$row->contact_number.'"></td>
										</tr>
										<tr>
											<td><b>Pickup Address</b></td>
											<td><input type="text" class="form-control input-sm pickup_address" name="pickup_address" value="'.$row->pickup_address.'"></td>
										</tr>
										<tr>
											<td><b>Special Request</b></td>
											<td><input type="text" class="form-control input-sm special_request" name="special_request" value="'.$row->special_request.'"></td>
										</tr>
									</tbody>
								</table>
							</div>
							<br/>
							<div class="table-responsive" >
								<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
									<tbody>
										<tr>
											<td width="50%"><b>Transport being booked by Quote Me?</b></td>
											<td>
												<select class="form-control input-sm trans_flag" id="trans_flag" name="trans_flag">
													<option value="0" '.($row->trans_flag=="0" ? "selected" : "").'>No</option>
													<option value="1" '.($row->trans_flag=="1" ? "selected" : "").'>Yes</option>
												</select>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<br/>
							<div class="table-responsive hidden_div" hidden>
								<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
									<tbody>
										<tr>
											<td width="50%"><b>Transport Company</b></td>
											<td><input type="text" class="form-control input-sm transport_company"  name="transport_company" value="'.$row->transport_company.'"></td>
										</tr>
										<tr>
											<td><b>Contact Number</b></td>
											<td><input type="text" class="form-control input-sm transport_contact_num" name="transport_contact_num" value="'.$row->transport_contact_num.'"></td>
										</tr>
										<tr>
											<td><b>Cost of Transport</b></td>
											<td><input type="text" class="form-control input-sm cost_of_transport" id="cost_of_transport" name="cost_of_transport" value="'.$row->cost_of_transport.'"></td>
										</tr>
										<tr>
											<td><b>Booking Made</b></td>
											<td>
												<select class="form-control input-sm booking_made" id="booking_made" name="booking_made">
													<option value="Yes" '.($row->booking_made=="Yes" ? "selected" : "").'>Yes</option>
													<option value="No" '.($row->booking_made=="No" ? "selected" : "").'>No</option>
												</select>
											</td>
										</tr>
										<tr>
											<td><b>Reference Number of Booking</b></td>
											<td><input type="text" class="form-control input-sm book_ref_number" id="book_ref_number" name="book_ref_number" value="'.$row->book_ref_number.'"></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-md-6">
							<br /><br />
							<h5><b>VEHICLE DETAILS</b></h5><br />
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
									<tbody>			
										<tr><td width="50%"><b>Make:</b></td><td><input type="text" class="form-control input-xs" name="tradein_make" value="'.$row->tradein_make.'"></td></tr>
										<tr><td><b>Model:</b></td><td><input type="text" class="form-control input-xs" name="tradein_model" value="'.$row->tradein_model.'"></td></tr>
										<tr><td><b>Variant:</b></td><td><input type="text" class="form-control input-xs" name="tradein_variant" value="'.$row->tradein_variant.'"></td></tr>
										<tr><td><b>Build Date:</b></td><td><input type="text" class="form-control input-xs" name="tradein_build_date" value="'.$row->tradein_build_date.'"></td></tr>
										<tr><td><b>Compliance Date:</b></td><td><input type="text" class="form-control input-xs" name="compliance_date" value="'.$row->compliance_date.'"></td></tr>
										<tr><td><b>Kms:</b></td><td><input type="text" class="form-control input-xs" name="tradein_kms" value="'.$row->tradein_kms.'"></td></tr>
										<tr><td><b>Fuel Type:</b></td><td><input type="text" class="form-control input-xs" name="tradein_fuel_type" value="'.$row->tradein_fuel_type.'"></td></tr>
										<tr><td><b>Body Shape:</b></td><td><input type="text" class="form-control input-xs" name="tradein_body_type" value="'.$row->tradein_body_type.'"></td></tr>
										<tr><td><b>Colour:</b></td><td><input type="text" class="form-control input-xs" name="tradein_colour" value="'.$row->tradein_colour.'"></td></tr>
										<tr><td><b>Drive Type:</b></td><td><input type="text" class="form-control input-xs" name="tradein_drive_type" value="'.$row->tradein_drive_type.'"></td></tr>
										<tr><td><b>Transmission:</b></td><td><input type="text" class="form-control input-xs" name="tradein_transmission" value="'.$row->tradein_transmission.'"></td></tr>
										<tr><td><b>Service History:</b></td><td><textarea placeholder="Write your service history here..." class="other_info_textarea form-control input-sm" name="tradein_service_history">'.$row->tradein_service_history.'</textarea></td></tr>
										<tr><td><b>Vehicle Options:</b></td><td><input type="text" class="form-control input-xs" name="options_1" value="'.$row->options_1.'"></td></tr>
										<tr><td><b>Accessories:</b></td><td><input type="text" class="form-control input-xs" name="accessories_1" value="'.$row->accessories_1.'"></td></tr>
									</tbody>
								</table>
							</div>					
							<br />
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
									<tbody>
										<tr>
											<td><b>Warning lights while vehicle is running?</b></td>
											<td align="center"><input type="checkbox" name="warning_lights" value="Yes" '.(($row->warning_lights == "Yes") ? "checked" : "").'/></td>
										</tr>
										<tr>
											<td><b>Is there existing damage on the vehicle?</b></td>
											<td align="center"><input type="checkbox" name="damage" value="Yes" '.(($row->damage == "Yes") ? "checked" : "").'/></td>
										</tr>
										<tr>
											<td><b>Was your vehicle ever a lease or rental?</b></td>
											<td align="center"><input type="checkbox" name="lease" value="Yes" '.(($row->lease == "Yes") ? "checked" : "").'/></td>
										</tr>
										<tr>
											<td><b>Did you buy the vehicle new?</b></td>
											<td align="center"><input type="checkbox" name="bought_new" value="Yes" '.(($row->bought_new == "Yes") ? "checked" : "").'/></td>
										</tr>
										<tr>
											<td><b>Do all the options & accessories work?</b></td>
											<td align="center"><input type="checkbox" name="accessories_working" value="Yes" '.(($row->accessories_working == "Yes") ? "checked" : "").'/></td>
										</tr>
										<tr>
											<td><b>Has vehicle ever been in any accident?</b></td>
											<td align="center"><input type="checkbox" name="accident" value="Yes" '.(($row->accident == "Yes") ? "checked" : "").'/></td>
										</tr>
										<tr>
											<td><b>Has vehicle ever had any paint work?</b></td>
											<td align="center"><input type="checkbox" name="paint_work" value="Yes" '.(($row->paint_work == "Yes") ? "checked" : "").'/></td>
										</tr>
									</tbody>
								</table>
							</div>
							<br />
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
									<tbody>
										<tr>
											<td>
												<b>Other Info</b>
												<textarea placeholder="Write your other info here..." class="other_info_textarea form-control input-sm" name="other_info">'.$row->other_info.'</textarea>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<br /><br />
							<h5><b>PAYMENT INSTRUCTIONS</b></h5><br />
							<p><i>Calculated Total Payment Amount: '.$total_payment_amount.' AUD</i></p>
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
									<tbody>
										<tr>
											<td width="50%"><b>Total Payment Amount:</b></td>
											<td><input type="text" name="total_payment_amount" class="form-control input-xs" value="'.$row->total_payment_amount.'"></td>
										</tr>
										<tr>
											<td><b>Dealer Payment:</b></td>
											<td><input type="text" name="dealer_payment" class="form-control input-xs" value="'.$row->dealer_payment.'"></td>
										</tr>
										<tr>
											<td><b>Client Payment:</b></td>
											<td><input type="text" name="client_payment" class="form-control input-xs" value="'.$row->client_payment.'"></td>
										</tr>
									</tbody>
								</table>
							</div>
							<br />
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
									<tbody>
										<tr>
											<td width="50%"><b>Bank Details:</b></td>
											<td><input type="text" name="bank_details" class="form-control input-xs" value="'.$row->bank_details.'"></td>
										</tr>
										<tr>
											<td><b>Bank Account:</b></td>
											<td><input type="text" name="bank_account" class="form-control input-xs" value="'.$row->bank_account.'"></td>
										</tr>
										<tr>
											<td><b>BSB:</b></td>
											<td><input type="text" name="bsb" class="form-control input-xs" value="'.$row->bsb.'"></td>
										</tr>
										<tr>
											<td><b>Reference:</b></td>
											<td><input type="text" name="reference" class="form-control input-xs" value="'.$row->reference.'"></td>
										</tr>
										<tr>
											<td><b>PPSR:</b></td>
											<td><input type="text" name="ppsr" class="form-control input-xs" value="'.$row->ppsr.'"></td>
										</tr>
									</tbody>
								</table>
							</div>
							<br />
						</div>
					</div>
					<br />';
				}
				else
				{
					if ($row->other_info == "")
					{
						$row->other_info = "<i>N/A</i><br />";
					}
					
					$tradein_details .= '
					<div class="row">
						<div class="col-md-3">
							<div class="img-responsive img-div">
								<img src="'.$this->tradein_photo_base_url_tm.$row->image_1.'" class="img-responsive img-details img-1" data-img="'.$row->image_1.'" data-img-no="1">
							</div>
						</div>
						<div class="col-md-3">
							<div class="img-responsive img-div">
								<img src="'.$this->tradein_photo_base_url_tm.$row->image_2.'" class="img-responsive img-details img-2" data-img="'.$row->image_2.'" data-img-no="2">
							</div>
						</div>
						<div class="col-md-3">
							<div class="img-responsive img-div">
								<img src="'.$this->tradein_photo_base_url_tm.$row->image_3.'" class="img-responsive img-details img-3" data-img="'.$row->image_3.'" data-img-no="3">
							</div>
						</div>
						<div class="col-md-3">
							<div class="img-responsive img-div">
								<img src="'.$this->tradein_photo_base_url_tm.$row->image_4.'" class="img-responsive img-details img-4" data-img="'.$row->image_4.'" data-img-no="4">
							</div>
						</div>
					</div>			
					<div class="row">
						<div class="col-md-6">
							<br /><br />
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
									<tbody>			
										<tr><td width="40%"><b>Make:</b></td><td>'.$row->tradein_make.'</td></tr>
										<tr><td><b>Model:</b></td><td>'.$row->tradein_model.'</td></tr>
										<tr><td><b>Variant:</b></td><td>'.$row->tradein_variant.'</td></tr>
										<tr><td><b>Build Date:</b></td><td>'.$row->tradein_build_date.'</td></tr>
										<tr><td><b>Kms:</b></td><td>'.$row->tradein_kms.'</td></tr>
										<tr><td><b>Fuel Type:</b></td><td>'.$row->tradein_fuel_type.'</td></tr>
										<tr><td><b>Body Shape:</b></td><td>'.$row->tradein_body_type.'</td></tr>
										<tr><td><b>Colour:</b></td><td>'.$row->tradein_colour.'</td></tr>
										<tr><td><b>Drive Type:</b></td><td>'.$row->tradein_drive_type.'</td></tr>
										<tr><td><b>Transmission:</b></td><td>'.$row->tradein_transmission.'</td></tr>
										<tr><td><b>Service History:</b></td><td>'.$row->tradein_service_history.'</td></tr>
										<tr><td><b>Vehicle Options:</b></td><td>'.$row->options_1.'</td></tr>
										<tr><td><b>Accessories:</b></td><td>'.$row->accessories_1.'</td></tr>
									</tbody>
								</table>
							</div>							
						</div>
						<div class="col-md-6">
							<br /><br />
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
									<tbody>
										<tr><td><b>Warning lights while vehicle is running?</b></td><td>'.$row->warning_lights.'</td></tr>
										<tr><td><b>Is there existing damage on the vehicle?</b></td><td>'.$row->damage.'</td></tr>
										<tr><td><b>Was your vehicle ever a lease or rental?</b></td><td>'.$row->lease.'</td></tr>
										<tr><td><b>Did you buy the vehicle new?</b></td><td>'.$row->bought_new.'</td></tr>
										<tr><td><b>Do all the options & accessories work?</b></td><td>'.$row->accessories_working.'</td></tr>
										<tr><td><b>Has vehicle ever been in any accident?</b></td><td>'.$row->accident.'</td></tr>
										<tr><td><b>Has vehicle ever had any paint work?</b></td><td>'.$row->paint_work.'</td></tr>
									</tbody>
								</table>
							</div>
							<br />
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
									<tbody>
										<tr>
											<td>
												<b>Other Info</b><br /><br />
												'.$row->other_info.'
											</td>
										</tr>
									</tbody>
								</table>
							</div>						
						</div>
					</div>';
				}
			}
		}
		$tradein_details_arr = ["tradein_details" => $tradein_details];
		echo json_encode($tradein_details_arr);
	}

	public function record_final ($tradein_id)
	{
		$data = $this->data;
		$data['title'] = 'Trade-In';

		$tradein = $this->tradein_model->get_tradein($tradein_id);
		$user_trade_valuation = $this->tradein_model->get_user_tradein_valuation($tradein_id, $data['user_id']);
		$trade_valuations = $this->tradein_model->get_tradein_valuations($tradein_id);
		$same_make_tradeins = $this->tradein_model->get_same_make_tradeins($tradein['tradein_make']);
		
		$root_image_url = "http://www.mytradevaluation.com.au/uploads/thumbnails_m/";
		if ($tradein['image_1']=="") 
		{
			$thumb_image = "no_image.png"; 
		}
		else
		{
			$thumb_image = $tradein['image_1']; 
		}

		$data['tradein'] = $tradein;
		
		$data['tradein']['real_total_payment_amount'] = 0;
		if ($tradein['fk_lead'] <> 0)
		{
			$lead = $this->lead_model->get_lead($tradein['fk_lead']);
			$revenue_details = $this->calculate_revenue($lead);
			$data['tradein']['real_total_payment_amount'] = $lead['tradein_value'] - (($lead['winning_price'] - $revenue_details['balance']) + $lead['tradein_payout']);						
		}

		if (isset($user_trade_valuation['value']))
		{
			$data['user_trade_valuation'] = $user_trade_valuation['value'];
			$data['user_trade_valuation_id'] = $user_trade_valuation['id_trade_valuation'];
		}
		else
		{
			$data['user_trade_valuation'] = "";
			$data['user_trade_valuation_id'] = 0;
		}
		
		$data['same_make_tradeins'] = $same_make_tradeins;
		$data['trade_valuations'] = $trade_valuations;
		$data['tradein_files'] = array();
		$data['thumb_image'] = $root_image_url.$thumb_image;		
		$data['comments'] = array();
		$data['audit_trails'] = array();
		$data['audit_trails'] = array();

		
		$this->load->view('admin/tradein', $data);
	}
	
	public function update_record_new ()
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;
		
		$input_arr = $this->input->post();

		$tradein_arr = $this->tradein_model->get_tradein($input_arr['id_tradein']);

		$changed_fields_string = $this->changed_fields($tradein_arr, $input_arr);
		if ($changed_fields_string <> "")
		{
			$update_tradein_result = $this->tradein_model->update_tradein_new($input_arr);
			if ($update_tradein_result)
			{
				/*
				$audit_trail_arr = array(
					'id' => $input_arr['id_lead'],
					'table_name' => 'leads',
					'action' => 2,
					'description' => $changed_fields_string
				);
				$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);
				$this->action_model->insert_action(1, $input_arr['id_lead'], $data['user_id'], 'Update');
				*/
				echo "success";
			}
			else
			{
				echo "fail";
			}
		}
		else
		{
			echo "nochanges";
		}		
	}	
	
	public function get_contact_details()
	{
		$post_data = $this->input->post();
		$result = $this->tradein_model->get_contact_details($post_data['lead_id']);

		if (count($result) > 0)
		{
			$result['flag'] = 1;
		}
		else
		{
			$result['flag'] = 0;	
		}

		echo json_encode($result);
	}

	public function delete () // MODAL ACTION // AT PENDING //
	{
		$tradein_ids = $this->input->post('tradein_ids');
		$this->tradein_model->delete_tradeins($tradein_ids);
	}

	public function select_winner()
	{
		$data = $this->data;
		$id_tradein = $this->input->post('id_tradein');
		$id_trade_valuation = $this->input->post('id_trade_valuation');
		$update_buyer_result = $this->tradein_model->update_buyer($id_tradein, $id_trade_valuation);
		
		if ($update_buyer_result)
		{
			// $query = "SELECT fk_lead FROM tradeins WHERE id_tradein = ".$id_tradein;		
			$query = "SELECT id_leads FROM tradein_new WHERE id_tradein = ".$id_tradein;		
			$tradein_result = $this->db->query($query)->row_array();
			
			// $lead = $this->lead_model->get_lead($tradein_result['fk_lead']);
			$lead = $this->lead_model->get_lead($tradein_result['id_leads']);
			if (isset($lead['deal_flag']))
			{
				if ($lead['deal_flag']==1)
				{
					if ($data['user_id'] <> 427)
					{
						$cq_number = "QM".str_pad($tradein_result['id_leads'], 5, '0', STR_PAD_LEFT);
						$notification_message = '<b><a href="'.site_url('lead/record_final/'.$tradein_result['id_leads']).'">'.$cq_number.'</a></b> - '.$data['name'].' changed the winning buyer of trade';
						$this->notification_model->add_notification(1, $notification_message);
						$notification_id = $this->db->insert_id();
						$this->notification_model->add_notification_user($notification_id, 427);
					}		
				}
			}		
			
			echo "success";
		}
		else
		{
			echo "fail";
		}
	}

	public function remove_winner()
	{
		$data = $this->data;
		$id_tradein = $this->input->post('id_tradein');
		$id_trade_valuation = $this->input->post('id_trade_valuation');
		$remove_buyer_result = $this->tradein_model->remove_buyer($id_tradein, $id_trade_valuation);
		
		if ($remove_buyer_result)
		{
			echo "success";
		}
		else
		{
			echo "fail";
		}
	}

	public function valuations ($tradein_id) // MODAL VIEW
	{
		$data = $this->data;
		$tradein_valuations = '';
		$query = "
		SELECT t.id_tradein, tv.id_trade_valuation, u.username AS `email`, u.name, tv.value, tv.created_at,
		t.fk_trade_valuation
		FROM trade_valuations tv
		JOIN tradeins t ON tv.fk_tradein = t.id_tradein
		JOIN users u ON tv.fk_user = u.id_user
		WHERE t.id_tradein = ".$tradein_id;
		$result = $this->db->query($query);
		if (count($result->result())==0)
		{
			$tradein_valuations .= '<tr><td colspan="5"><center><i>No valuations found!</i></center></td><tr>';
		}
		else
		{
			foreach ($result->result() as $row)
			{
				if ($row->fk_trade_valuation == $row->id_trade_valuation)
				{
					$winner_button = '<i class="fa fa-trophy"></i>';
				}
				else
				{
					$winner_button = '
					<a href="#" onclick="select_trade_winner('.$row->id_tradein.', '.$row->id_trade_valuation.')">
						<i class="fa fa-trophy"></i>
					</a>
					';					
				}

				$tradein_valuations .= '
				<tr>
					<td>'.$winner_button.'</td>
					<td>'.$row->email.'</td>
					<td id="ti_buyer_modal_'.$row->id_trade_valuation.'">'.$row->name.'</td>
					<td id="ti_trade_value_modal_'.$row->id_trade_valuation.'">'.$row->value.'</td>
					<td>'.$row->created_at.'</td>
				</tr>';
			}
		}
		$tradein_valuations_arr = array("tradein_valuations" => $tradein_valuations);
		echo json_encode($tradein_valuations_arr);	
	}
	
	public function valuation ($tradein_id) // MODAL VIEW
	{
		$data = $this->data;
		$tradein_valuation = '';
		$query = "
		SELECT value FROM trade_valuations 
		WHERE fk_tradein = ".$tradein_id." AND fk_user = ".$data['user_id']." 
		ORDER BY id_trade_valuation DESC LIMIT 1";
		$result = $this->db->query($query);
		if (count($result->result())<>0)
		{
			foreach ($result->result() as $row)
			{
				$tradein_valuation = $row->value;
			}
		}
		$tradein_value_arr = array("entered_value" => $tradein_valuation);
		echo json_encode($tradein_value_arr);	
	}

	public function add_trade_valuation () // MODAL ACTION // NO AUDIT TRAIL YET //
	{
        $return = array();
		$now = date("Y-m-d H:i:s");
		$data = $this->data;

		$input_arr = $this->input->post();
		
        $input_arr['value'] = $input_arr['trade_valuation'];        
        
        //echo '<pre>';print_r($input_arr);exit;
		
		if (isset($input_arr['id_user']) AND $input_arr['id_user'] <> "")
		{
			$user_id = $input_arr['id_user'];
		}
		else
		{
			$user_id = $data['user_id'];
		}

		$insert_trade_valuation_result = $this->tradein_model->insert_trade_valuation($user_id, $input_arr);

		if ($insert_trade_valuation_result)
		{
			echo "success";
		}
		else
		{
			echo "fail";
		}
	}	
	
	public function update_trade_valuation () // MODAL ACTION // NO AUDIT TRAIL YET //
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;

		$input_arr = $this->input->post();
		
		$update_trade_valuation_result = $this->tradein_model->update_trade_valuation($input_arr);

		if ($update_trade_valuation_result)
		{
			echo "success";
		}
		else
		{
			echo "fail";
		}
	}	
	
	public function update_record () // MODAL ACTION // AT PENDING //
	{
		$data = $this->data;
		$input_arr = $this->input->post();
		$this->tradein_model->update_tradein($input_arr);
	}

	public function update_tradein_declarations ($input_arr)
	{
		$this->tradein_model->update_tradein_declarations($input_arr);
	}
	
	public function submit_valuation () // MODAL ACTION // AT PENDING //
	{
		$data = $this->data;
		$input_arr = $this->input->post();
		if (isset($input_arr['wholesaler_id']))
		{
			$input_arr['user_id'] = $input_arr['wholesaler_id'];
		}
		else
		{
			$input_arr['user_id'] = $data['user_id'];	
		}
		$this->tradein_model->insert_valuation($input_arr);
	}
	
	public function update_dealer_visibility () // MODAL ACTION // AT PENDING //
	{
		$data = $this->data;
		$input_arr = $this->input->post();
		$this->tradein_model->update_dealer_visibility($input_arr);
	}	

	public function attach_trade () // MODAL ACTION // AT PENDING //
	{
		$data = $this->data;
		$input_arr = $this->input->post();
		$this->tradein_model->attach_tradein($input_arr);
		
		$lead = $this->lead_model->get_lead($input_arr['lead_id']);
		if (isset($lead['deal_flag']))
		{
			if ($lead['deal_flag']==1)
			{
				if ($data['user_id'] <> 427)
				{
					$cq_number = "QM".str_pad($input_arr['lead_id'], 5, '0', STR_PAD_LEFT);
					$notification_message = '<b><a href="#" class="open-lead-details" data-lead_id="'.$input_arr['lead_id'].'">'.$cq_number.'</a></b> - '.$data['name'].' attached a trade';
					$this->notification_model->add_notification(1, $notification_message);
					$notification_id = $this->db->insert_id();
					$this->notification_model->add_notification_user($notification_id, 427);
				}
			}
		}
	}

	public function unattach_trade () // MODAL ACTION // AT PENDING //
	{
		$data = $this->data;
		$input_arr = $this->input->post();
		$this->tradein_model->unattach_tradein($input_arr);

		$lead = $this->lead_model->get_lead($input_arr['lead_id']);
		if (isset($lead['deal_flag']))
		{
			if ($lead['deal_flag']==1)
			{
				if ($data['user_id'] <> 427)
				{
					$cq_number = "QM".str_pad($input_arr['lead_id'], 5, '0', STR_PAD_LEFT);
					$notification_message = '<b><a href="#" class="open-lead-details" data-lead_id="'.$input_arr['lead_id'].'">'.$cq_number.'</a></b> - '.$data['name'].' unattached a trade';
					$this->notification_model->add_notification(1, $notification_message);
					$notification_id = $this->db->insert_id();
					$this->notification_model->add_notification_user($notification_id, 427);
				}				
			}
		}
	}
	
	
	public function pdf_recipients ($tradein_id) // SUB MODAL VIEW (PDF)
	{
		$query = "
		SELECT email FROM tradein_recipients 
		WHERE fk_tradein = ".$tradein_id." 
		ORDER BY id_tradein_recipient DESC";
		$result = $this->db->query($query);
		if (count($result->result())==0)
		{
			$pdf_recipients = '<tr class="no_recipient"><td><center><i>No recipients yet!</i></center></td></tr>';
		}
		else
		{
			$pdf_recipients = '';			
			foreach ($result->result() as $row)
			{
				$pdf_recipients .= '<tr><td>'.$row->email.'</td></tr>';				
			}
			$pdf_recipients .= '';
		}
		$pdf_recipients_arr = array("pdf_recipients" => $pdf_recipients);
		echo json_encode($pdf_recipients_arr);
	}

	public function new_trade_form () // ACTION // With Email (TRADITIONAL) // AT PENDING //
	{
		if (isset($_POST['submit']))
		{	
			$now = date("Y-m-d H:i:s");
			$query = "
			INSERT INTO tradeins (
				`fk_user`, `first_name`, `last_name`, `email`, `phone`, `state`, `postcode`, `registration_plate`, `rego_expiry`, 
				`tradein_make`, `tradein_model`, `tradein_build_date`, `tradein_variant`, `tradein_colour`, `tradein_body_type`, `tradein_fuel_type`, 
				`tradein_drive_type`, `tradein_transmission`, `tradein_compliance_date`, `tradein_kms`, `tradein_service_history`, 
				`options_1`, `accessories_1`, 
				`warning_lights`, `damage`, `lease`, `bought_new`, `accessories_working`, `accident`, `paint_work`, `other_info`, 
				`image_1`, `image_2`, `image_3`, `image_4`, `deprecated`, `created_at`, `tradein_vin`, `tradein_eng`
			)
			VALUES (
				0, 
				'".$this->db->escape_str($_POST['first_name'])."',
				'".$this->db->escape_str($_POST['last_name'])."',
				'".$this->db->escape_str($_POST['email'])."',
				'".$this->db->escape_str($_POST['phone'])."',
				'".$this->db->escape_str($_POST['state'])."',
				'".$this->db->escape_str($_POST['postcode'])."',
				'".$this->db->escape_str($_POST['registration_plate'])."',
				'".$this->db->escape_str($_POST['rego_expiry'])."',
				'".$this->db->escape_str($_POST['tradein_make'])."',
				'".$this->db->escape_str($_POST['tradein_model'])."',
				'".$this->db->escape_str($_POST['tradein_build_date'])."',
				'".$this->db->escape_str($_POST['tradein_variant'])."',
				'".$this->db->escape_str($_POST['tradein_colour'])."',
				'".$this->db->escape_str($_POST['tradein_body_type'])."',
				'".$this->db->escape_str($_POST['tradein_fuel_type'])."',
				'".$this->db->escape_str($_POST['tradein_drive_type'])."',
				'".$this->db->escape_str($_POST['tradein_transmission'])."',
				'".$this->db->escape_str($_POST['tradein_compliance_date'])."',
				'".$this->db->escape_str($_POST['tradein_kms'])."',
				'".$this->db->escape_str($_POST['tradein_service_history'])."',
				'".$this->db->escape_str($_POST['options_1'])."',
				'".$this->db->escape_str($_POST['accessories_1'])."',
				'".$this->db->escape_str($_POST['warning_lights'])."',
				'".$this->db->escape_str($_POST['damage'])."',
				'".$this->db->escape_str($_POST['lease'])."',
				'".$this->db->escape_str($_POST['bought_new'])."',
				'".$this->db->escape_str($_POST['accessories_working'])."',
				'".$this->db->escape_str($_POST['accident'])."',
				'".$this->db->escape_str($_POST['paint_work'])."',
				'".$this->db->escape_str($_POST['other_info'])."',
				'".$this->db->escape_str( (isset($_POST['photo'][0]) ? $_POST['photo'][0] : "") )."',
				'".$this->db->escape_str( (isset($_POST['photo'][1]) ? $_POST['photo'][1] : "") )."',
				'".$this->db->escape_str( (isset($_POST['photo'][2]) ? $_POST['photo'][2] : "") )."',
				'".$this->db->escape_str( (isset($_POST['photo'][3]) ? $_POST['photo'][3] : "") )."',
				0,
				'".$now."',
				'".$this->db->escape_str($_POST['tradein_vin'])."',
				'".$this->db->escape_str($_POST['tradein_eng'])."'
			)";
			$this->db->query($query);
			
			$to = 'jeronimo@qteme.com.au';
			$subject = 'New TradeIn from '.$_POST['first_name'].' '.$_POST['last_name'];
			$message = '
			<html>
				<head>
					<title>TradeValuation - New TradeIn</title>
				</head>
				<body>
					<p><b>New TradeIn</b></p>
					<table>
						<tr><td>Name: </td><td>'.$_POST['first_name'].' '.$_POST['last_name'].'</td></tr>
						<tr><td>Email: </td><td>'.$_POST['email'].'</td></tr>
						<tr><td>Phone: </td><td>'.$_POST['phone'].'</td></tr>
						<tr><td>State: </td><td>'.$_POST['state'].'</td></tr>
						<tr><td>Make: </td><td>'.$_POST['tradein_make'].'</td></tr>
						<tr><td>Model: </td><td>'.$_POST['tradein_model'].'</td></tr>
					</table>
				</body>
			</html>';
			$headers  = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";	
			$headers .= "From: TradeValuation <info@qteme.com.au>" . "\r\n";
			mail($to,$subject,$message,$headers);
		}
	}

	public function upload_image_form () // AT PENDING //
	{
		$post_data = $this->input->post();
		$request_array = array();
		$data = $this->data;
		$directory = $this->tradein_photo_base_path;
		$thumbnail_m = $this->tradein_photo_base_path_tm;
		$thumbnail_s = $this->tradein_photo_base_path_ts;
		$prefix = time().'_'.$data['user_id'].'_';
		$file_name = $_FILES['file']['name'];
		$file_tmp = $_FILES['file']['tmp_name'];
		$file = $directory.$prefix.$file_name;
		$file_2 = $thumbnail_m.$prefix.$file_name;
		$file_3 = $thumbnail_s.$prefix.$file_name;
		$database_file_name = $prefix.$file_name;

		if( move_uploaded_file($file_tmp, $file) )
		{
			$this->upload_medium($file, $file_2);
			$this->upload_small($file, $file_3);
			echo $database_file_name;
		}
	}

	public function delete_image_unload () // AT PENDING //
	{
		$post_data = $this->input->post();
		$directory = $this->tradein_photo_base_path;
		$thumbnail_m = $this->tradein_photo_base_path_tm;
		$thumbnail_s = $this->tradein_photo_base_path_ts;
		foreach ($post_data['photo'] as $key => $val) 
		{
			unlink( $directory.$val );
			unlink( $thumbnail_m.$val );
			unlink( $thumbnail_s.$val );
		}
	}

	public function upload_new_image () // AT PENDING //
	{
		$post_data = $this->input->post();

		$request_array = array();
		$data = $this->data;
		$directory = $this->tradein_photo_base_path;
		$thumbnail_m = $this->tradein_photo_base_path_tm;
		$thumbnail_s = $this->tradein_photo_base_path_ts;
		$prefix = time().'_'.$data['user_id'].'_';
		$file_name = $_FILES['file']['name'];
		$file_tmp = $_FILES['file']['tmp_name'];
		$file = $directory.$prefix.$file_name;
		$file_2 = $thumbnail_m.$prefix.$file_name;
		$file_3 = $thumbnail_s.$prefix.$file_name;
		$database_file_name = $prefix.$file_name;
		$request_array = array(
			'id'        => $post_data['modal_id'],
			'file_name' => $database_file_name,
			'image_num' => $post_data['image_num']
		);
		if( move_uploaded_file($file_tmp, $file) )
		{
			$this->upload_medium($file, $file_2);
			$this->upload_small($file, $file_3);
			if( $this->tradein_model->upload_new_image($request_array) )
			{
				if( trim($post_data['image_oldname']) != "no_image.png" )
				{
					unlink( $directory.$post_data['image_oldname'] );
					unlink( $thumbnail_m.$post_data['image_oldname'] );
					unlink( $thumbnail_s.$post_data['image_oldname'] );
				}
				echo $database_file_name;
			}
		}
	}

	public function delete_image () // AT PENDING //
	{
		$post_data = $this->input->post();
		if($this->tradein_model->delete_image($post_data))
		{
			echo "success";
		}
		else
		{
			echo "fail";
		}
	}

	private function upload_medium ($file_name, $image_loc)
	{
		$config_1['image_library']  = 'gd2';
		$config_1['source_image']   = $file_name;
		$config_1['new_image']      = $image_loc;
		$config_1['maintain_ratio'] = TRUE;
		$config_1['width']          = 600;
		$config_1['height']         = 600;
		$this->image_lib->initialize($config_1);
		$this->image_lib->resize();
	}

	private function upload_small ($file_name, $image_loc)
	{
		$config_2['image_library']  = 'gd2';
		$config_2['source_image']   = $file_name;
		$config_2['new_image']      = $image_loc;
		$config_2['maintain_ratio'] = TRUE;
		$config_2['width']          = 100;
		$config_2['height']         = 100;
		$this->image_lib->initialize($config_2);
		$this->image_lib->resize();
	}
	
	// PDF Redirect //
	public function pdf_export ($tradein_id)
	{
		$customurl='http://portal.finquote.com.au';
		$path = $customurl.$this->generate_pdf($tradein_id);
		
		
		redirect($path);
	}
		
	public function tradein_invoice_pdf ($tradein_id)
	{
		$customurl='http://portal.finquote.com.au';
		$path = $customurl.$this->generate_tradein_invoice_pdf($tradein_id);
		redirect($path);
	}

	public function submit_pdf ($tradein_id) // SUB MODAL ACTION (PDF) // With Email (Custom) // AT PENDING //
	{
		$data = $this->data;
		
		$this->load->model('tradeinrecipient_model', '', TRUE);
		$email = $this->input->post('email');
		if ($email != "")
		{
			$this->tradeinrecipient_model->insert_tradein_recipient($tradein_id, $email);
			$tradein_detail = $this->tradein_model->get_tradein($tradein_id);
			$content = '
			<center>
				<h1 style="font-size: 22px;">
					New Vehicle for Valuation
				</h1>
			</center>
			<p style="line-height: 1.5">
				Vehicle submitted for valuation ('.$tradein_detail['tradein_make'].' 
				'.$tradein_detail['tradein_model'].' '.$tradein_detail['registration_plate'].'). 
				Please see the attached PDF file for more details.
			</p>
			<br />
			<br />';

			$path = $this->generate_pdf($tradein_id);
			$final_path = $this->base_path."uploads/".$this->substring_index($path, '/uploads/', -1);

			$this->send_templated_email($this->settings['company_email'], $this->settings['company_name'], $email, $tradein_detail['tradein_make'].' '.$tradein_detail['tradein_model'].' '.$tradein_detail['registration_plate'].' - Quote Me', $content, $final_path);
		}
	}

	public function initialize_submit_pdf_modal()
	{
		$data = $this->data;

		$this->load->model('tradeinrecipient_model', '', TRUE);

		$email_array = $this->input->post('email_array');
		$tradein_id = $this->input->post('id_tradein');

		foreach ($email_array as $e_key => $e_val) 
		{
			$email = $e_val;

			$this->tradeinrecipient_model->insert_tradein_recipient($tradein_id, $email);
			$tradein_detail = $this->tradein_model->get_tradein($tradein_id);
			$content = '
			<center>
				<h1 style="font-size: 22px;">
					New Vehicle for Valuation
				</h1>
			</center>
			<p style="line-height: 1.5">
				Vehicle submitted for valuation ('.$tradein_detail['tradein_make'].' 
				'.$tradein_detail['tradein_model'].' '.$tradein_detail['registration_plate'].'). 
				Please see the attached PDF file for more details.
			</p>
			<br />
			<br />';

			$path = $this->generate_pdf($tradein_id);
			$final_path = $this->base_path."uploads/".$this->substring_index($path, '/uploads/', -1);

			$this->send_templated_email($this->settings['company_email'], $this->settings['company_name'], $email, $tradein_detail['tradein_make'].' '.$tradein_detail['tradein_model'].' '.$tradein_detail['registration_plate'].' - Quote Me', $content, $final_path);
		}
	}

	public function suggested_wholesalers () 
	{
		$state = $this->input->post('state');
		
		$results = $this->tradein_model->get_all_wholesalers($state);
		if(count($results) > 0)
		{
			$html = '
			<div class="table-responsive" style="white-space: nowrap;">
				<table class="table table-bordered table-striped table-condensed mb-none">
					<thead>						
						<tr>
							<th></th>
							<th>Name</th>
							<th>Email</th>
						</tr>
					</thead>
					<tbody>';
						foreach($results as $r_key => $r_val)
						{
							$html .= '
							<tr>
								<td align="center"><span class="select_wholesaler" data-id="'.$r_val['id_user'].'"  data-email="'.$r_val['username'].'"  data-name="'.$r_val['name'].'" style="cursor: pointer; cursor: hand; color: #58c603;"><i class="fa fa-plus" data-toggle="tooltip" data-placement="top" data-original-title="Select Wholesaler"></i></span></td>
								<td>'.$r_val['name'].'</td>
								<td>'.$r_val['username'].'</td>
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
						<th>Name</th>
						<th>Email</th>
					</thead>					
					<tbody>
						<tr><td colspan="3"><center><i>No wholesalers found!</i></center></td></tr>
					</tbody>
				</table>
			</div>';
		}
		echo $html;
	}
	
	public function generate_pdf ($tradein_id) // PDF RENDER
	{
		$data = $this->data;
		$data['title'] = 'Trade-In';
		
		$data['company_settings'] = $this->settings;
		$data['tradein'] = $this->tradein_model->get_tradein($tradein_id);
	
		$filename = str_replace('QM', 'TI', $data['tradein']['ti_number']);
		$pdfFilePath = FCPATH."/uploads/tradeins/".$filename.".pdf";
		ini_set('memory_limit','512M');
		$html = $this->load->view('admin/pdf_renders/tradein_print', $data, true);
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->SetHTMLFooter($this->pdf_footer);
		$pdf->WriteHTML($html);
		$pdf->Output($pdfFilePath, 'F');
		return "/uploads/tradeins/".$filename.".pdf";
	}	
	
	public function generate_tradein_invoice_pdf ($tradein_id) // PDF RENDER
	{
		$data = $this->data;
		$data['title'] = 'Invoice';
		
		$data['company_settings'] = $this->settings;
		$data['tradein'] = $this->tradein_model->get_tradein($tradein_id);

		if ($data['tradein']['total_payment_amount']==0 OR $data['tradein']['total_payment_amount']==0.00)
		{
			if ($data['tradein']['fk_lead'] <> 0 AND $data['tradein']['fk_lead'] <> "")			
			{
				$lead_details = $this->lead_model->get_lead($data['tradein']['fk_lead']);
				$revenue_details = $this->calculate_revenue($lead_details);			
				$data['tradein']['total_payment_amount'] = $lead_details['tradein_value'] - (($lead_details['winning_price'] - $revenue_details['balance']) + $lead_details['tradein_payout']);				
			}
		}

		$filename = 'TF'.str_pad($data['tradein']['fk_lead'], 5, '0', STR_PAD_LEFT)."_".$data['tradein']['id_tradein'];
		$pdfFilePath = FCPATH."/uploads/invoice_files/".$filename.".pdf";
		ini_set('memory_limit','512M');
		$html = $this->load->view('admin/pdf_renders/tradein_invoice_print', $data, true);
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->SetHTMLFooter($this->pdf_footer);
		$pdf->WriteHTML($html);
		$pdf->Output($pdfFilePath, 'F');
		return "/uploads/invoice_files/".$filename.".pdf";
	}

	public function generate_tradein_package_pdf ($tradein_id) // PDF RENDER
	{
		$data = $this->data;
		$data['title'] = 'Invoice';
		
		$company_settings = $this->settings;
		$tradein = $this->tradein_model->get_tradein($tradein_id);
		if ($tradein['total_payment_amount']==0 OR $tradein['total_payment_amount']==0.00)
		{
			if ($tradein['fk_lead'] <> 0 AND $tradein['fk_lead'] <> "")			
			{
				$lead_details = $this->lead_model->get_lead($data['tradein']['fk_lead']);
				$revenue_details = $this->calculate_revenue($lead_details);			
				$tradein['total_payment_amount'] = $lead_details['tradein_value'] - (($lead_details['winning_price'] - $revenue_details['balance']) + $lead_details['tradein_payout']);				
			}
		}
		
		
		// Page 3 //
		$tradein['buyer_name'];
		
		// Page 4 //
		$tradein['tradein_make']." ".$tradein['tradein_model']." (".$tradein['registration_plate'].")";
		
		// Bank Details for electronic funds transfer //
		
		/*
		$tradein['bank_account']
		$tradein['bsb']
		*/

		$invoice_number = "TF".str_pad($tradein['fk_lead'], 5, '0', STR_PAD_LEFT)."_".$tradein['id_tradein'];

		$from_details = 
		"<b>".$company_settings['company_name']."</b><br />
		".$company_settings['company_alternate_email']."<br />
		".$company_settings['company_postal_address_line_1'].", ".$company_settings['company_postal_address_line_2'].",<br />
		".$company_settings['company_postal_suburb'].", ".$company_settings['company_postal_state']." ".$company_settings['company_postal_postcode']."<br />
		Call ".$company_settings['company_phone'];

		$to_details = 
		"<b>".$tradein['buyer_name']."</b><br />" .
		$tradein['buyer_email'] . "<br />" .
		$tradein['buyer_address'] . "<br />" . 
		$tradein['buyer_state'] . " " . $tradein['buyer_postcode'] . "<br />" . 
		$tradein['buyer_phone'];
		
		$company_settings['company_logo'];	
		$company_settings['company_name'];
		$company_settings['company_short_name'];
		$company_settings['company_abn'];
		$company_settings['company_email'];
		$company_settings['company_alternate_email'];
		$company_settings['bank'];
		$company_settings['bsb'];
		$company_settings['account_number'];
		
		if ($tradein['invoice_date'] == "0000-00-00")
		{
			$invoice_date = "";
		}
		else
		{
			$invoice_date = date('d F Y', strtotime($tradein['invoice_date']));
		}

		if ($tradein['invoice_due_date'] == "0000-00-00") 
		{
			$due_date = "";
		}
		else
		{
			$due_date = date('d F Y', strtotime($tradein['invoice_due_date']));
		}
		
		$description = "Tender Fee for the introduction of ".$tradein['tradein_make']." ".$tradein['tradein_model']." (".$tradein['registration_plate'].")";
		$total_amount = $tradein['total_payment_amount'];
		$gst = $total_amount / 11;		
		$balance_payable = $total_amount;
		
		$client_address = $tradein['client_address']." ".$tradein['client_state']." ".$tradein['client_postcode'];
		
		if ($tradein['business_name']<>"")
		{
			$client_name = $tradein['business_name'];
		}
		else
		{
			$client_name = $tradein['name'];
		}
		$tradein['phone'];
		
		$tradein['contact_name'];
		$tradein['pickup_address'];
		$tradein['contact_number'];
		
		$tradein['pickup_date'];
		$tradein['pickup_time'];
		$tradein['special_request'];
		
		if ($tradein['document_1_count']=="0") { $document_1_count = "Yes"; }
		else { $document_1_count = "No"; }
				
		if ($tradein['document_4_count']=="0") { $document_4_count = "Yes"; }
		else { $document_4_count = "No"; }

		if ($tradein['document_3_count']=="0") { $document_3_count = "Yes"; }
		else { $document_3_count = "No"; }
		
		$tradein['tradein_make'];
		$tradein['tradein_model'];
		$tradein['tradein_variant'];
		$tradein['tradein_fuel_type'];
		$tradein['tradein_kms'];

		$tradein['rego_expiry'];
		$tradein['tradein_colour'];
		$tradein['tradein_transmission'];
		$tradein['tradein_build_date'];
		$tradein['tradein_compliance_date'];

		$tradein['options_1'];

		//texts array
		$xy_arr =[ 
                3 => [
                    'wholesaler_name' => [
                        'x'     => 30, // x axis
                        'y'     => -52, // y axis
                        'text'  => 'Christian Burgos', // text
                        'size'  => 11 // font size
                    ],
                    'wholesaler_sig_date' => [
                        'x'     => 80,
                        'y'     => -37,
                        'text'  => date( 'd F Y'),
                        'size'  => 11
                    ]
                ],

                4 => [
                    'tradein_vehicle' => [
                        'x'     => 70,
                        'y'     => 59,
                        'text'  => "MAKE MODEL VARIANT",
                        'size'  => 11
                    ],
                    'account_name' => [
                        'x'     => 22,
                        'y'     => -118,
                        'text'  => "ACCOUNT NAME",
                        'size'  => 11
                    ],
                    'bsb' => [
                        'x'     => 22,
                        'y'     => -103,
                        'text'  => " 1      2      3      -      A      B      C",
                        'size'  => 11
                    ],
                    'account_number' => [
                        'x'     => 107,
                        'y'     => -103,
                        'text'  => "ACCOUNT NUMBER",
                        'size'  => 11
                    ],
                    'bank_instruction' => [
                        'x'     => 23,
                        'y'     => -87,
                        'text'  => "BANK INSTRUCTION",
                        'size'  => 11
                    ],
                    'vehicle_owner_name' => [
                        'x'     => 23,
                        'y'     => -59,
                        'text'  => "VEHICLE ORDER NAME",
                        'size'  => 11
                    ],
                    'date' => [
                        'x'     => -55,
                        'y'     => -44,
                        'text'  => date('d F Y'),
                        'size'  => 11
                    ],
                ],
                6 => [
                    'date' => [
                        'x'     => 66,
                        'y'     => 25,
                        'text'  => "MAKE MODEL BODY",
                        'size'  => 10
                    ],
                    'registration_no' => [
                        'x'     => 25,
                        'y'     => 38,
                        'text'  => "REGISTRATION",
                        'size'  => 10
                    ],
                    'vin' => [
                        'x'     => 70,
                        'y'     => 38,
                        'text'  => "VIN1234",
                        'size'  => 10
                    ],
                    'kms' => [
                        'x'     => 115,
                        'y'     => 38,
                        'text'  => "100000",
                        'size'  => 10
                    ],
                    'kms' => [
                        'x'     => 115,
                        'y'     => 38,
                        'text'  => "100000",
                        'size'  => 10
                    ],
                    'declarant' => [
                        'x'     => 40,
                        'y'     => 52,
                        'text'  => "DECLARANT",
                        'size'  => 10
                    ],
                    'A1_text' => [
                        'x'     => 140,
                        'y'     => 68,
                        'text'  => "A1 TEXT",
                        'size'  => 7
                    ],
                    'A2_text' => [
                        'x'     => 140,
                        'y'     => 75,
                        'text'  => "A2 TEXT",
                        'size'  => 7
                    ],
                    'A3_text' => [
                        'x'     => 140,
                        'y'     => 82,
                        'text'  => "A3 TEXT",
                        'size'  => 7
                    ],
                    'A4_text' => [
                        'x'     => 140,
                        'y'     => 89,
                        'text'  => "A4 TEXT",
                        'size'  => 7
                    ],
                    'credit_provider' => [
                        'x'     => 28,
                        'y'     => 107,
                        'text'  => "CREDIT PROVIDER",
                        'size'  => 9
                    ],
                    'account_number' => [
                        'x'     => 28,
                        'y'     => 123,
                        'text'  => "ACCOUNT NUMBER",
                        'size'  => 9
                    ],
                    'payout_required' => [
                        'x'     => 28,
                        'y'     => 138,
                        'text'  => "PAYOUT REQUIRED",
                        'size'  => 9
                    ],
                    'payg_abn_1' => [
                        'x'     => 143,
                        'y'     => 164,
                        'text'  => "PAYG ABN 1",
                        'size'  => 8
                    ],
                    'payg_abn_2' => [
                        'x'     => 84,
                        'y'     => 178.5,
                        'text'  => "PAYG ABN 2",
                        'size'  => 8
                    ],
                    'declarant_signature_date' => [
                        'x'     => 143,
                        'y'     => 202,
                        'text'  => date('d F Y'),
                        'size'  => 9
                    ],
                    'declarant_signature_date' => [
                        'x'     => 143,
                        'y'     => 202,
                        'text'  => date('d F Y'),
                        'size'  => 9
                    ],
                ],
                7 => [
                    'date_tax_invoice_issued' => [
                        'x'     => 30,
                        'y'     => 95,
                        'text'  => date('d F Y'),
                        'size'  => 8
                    ],
                    'payment_due_date' => [
                        'x'     => 97,
                        'y'     => 95,
                        'text'  => date('d F Y'),
                        'size'  => 8
                    ],
                    'quoteme_abn' => [
                        'x'     => 150,
                        'y'     => 95,
                        'text'  => "75617320537",
                        'size'  => 8
                    ],
                    'description' => [
                        'x'     => 150,
                        'y'     => 95,
                        'text'  => "75617320537",
                        'size'  => 8
                    ],
                    'quantity' => [
                        'x'     => 83,
                        'y'     => 120,
                        'text'  => "1",
                        'size'  => 8
                    ],
                    'unit_price' => [
                        'x'     => 105,
                        'y'     => 120,
                        'text'  => "3,390.00",
                        'size'  => 8
                    ],
                    'GST' => [
                        'x'     => 130,
                        'y'     => 120,
                        'text'  => "10%",
                        'size'  => 8
                    ],
                    'total_amount' => [
                        'x'     => 160,
                        'y'     => 120,
                        'text'  => "3,390.00",
                        'size'  => 8
                    ],
                    'amount_with_gst' => [
                        'x'     => 169,
                        'y'     => 141,
                        'text'  => "$ 308.18",
                        'size'  => 8
                    ],
                    'balance_payable' => [
                        'x'     => 169,
                        'y'     => 148,
                        'text'  => "$ 3,390.00",
                        'size'  => 8
                    ],
                    'bsb' => [
                        'x'     => 93,
                        'y'     => 183,
                        'text'  => "032006",
                        'size'  => 10
                    ],
                    'account_number' => [
                        'x'     => 140,
                        'y'     => 183,
                        'text'  => "743215",
                        'size'  => 10
                    ]
                ],
                9 => [
                    'submitted' => [
                        'x'     => 92,
                        'y'     => 41,
                        'text'  => "SUBMITTED",
                        'size'  => 9
                    ],
                    'arrival_date' => [
                        'x'     => 92,
                        'y'     => 51,
                        'text'  => date('d F Y'),
                        'size'  => 9
                    ],
                    'registration_date' => [
                        'x'     => 92,
                        'y'     => 61,
                        'text'  => date('d F Y'),
                        'size'  => 9
                    ],
                    'make' => [
                        'x'     => 92,
                        'y'     => 71,
                        'text'  => "make",
                        'size'  => 9
                    ],
                    'variant' => [
                        'x'     => 92,
                        'y'     => 81,
                        'text'  => "variant",
                        'size'  => 9
                    ],
                    'current_kms' => [
                        'x'     => 92,
                        'y'     => 91,
                        'text'  => "current kms",
                        'size'  => 9
                    ],
                    'fuel_type' => [
                        'x'     => 92,
                        'y'     => 101,
                        'text'  => "fuel type",
                        'size'  => 9
                    ],
                    'transmission' => [
                        'x'     => 92,
                        'y'     => 110.5,
                        'text'  => "transmission",
                        'size'  => 9
                    ],
                    'service_history' => [
                        'x'     => 92,
                        'y'     => 120.5,
                        'text'  => "service history",
                        'size'  => 9
                    ],
                    'vehicle_options' => [
                        'x'     => 92,
                        'y'     => 130.5,
                        'text'  => "vehicle options",
                        'size'  => 9
                    ],
                    'rego_expiry' => [
                        'x'     => 92,
                        'y'     => 140.5,
                        'text'  => "rego expiry",
                        'size'  => 9
                    ],
                    'model' => [
                        'x'     => 92,
                        'y'     => 150.5,
                        'text'  => "model",
                        'size'  => 9
                    ],
                    'build_date' => [
                        'x'     => 92,
                        'y'     => 160.5,
                        'text'  => "2017",
                        'size'  => 9
                    ],
                    'body_type' => [
                        'x'     => 92,
                        'y'     => 170,
                        'text'  => "body type",
                        'size'  => 9
                    ],
                    'colour' => [
                        'x'     => 92,
                        'y'     => 180,
                        'text'  => "colour",
                        'size'  => 9
                    ],
                    'drive_type' => [
                        'x'     => 92,
                        'y'     => 190,
                        'text'  => "drive type",
                        'size'  => 9
                    ],
                    'accessories' => [
                        'x'     => 92,
                        'y'     => 200,
                        'text'  => "accessories",
                        'size'  => 9
                    ],
                    'warning_light' => [
                        'x'     => 90,
                        'y'     => -75,
                        'text'  => "Yes",
                        'size'  => 9
                    ],
                    'lease' => [
                        'x'     => 90,
                        'y'     => -65,
                        'text'  => "Yes",
                        'size'  => 9
                    ],
                    'accessories_working' => [
                        'x'     => 90,
                        'y'     => -55,
                        'text'  => "Yes",
                        'size'  => 9
                    ],
                    'paint_work' => [
                        'x'     => 90,
                        'y'     => -45,
                        'text'  => "Yes",
                        'size'  => 9
                    ],
                    'damage' => [
                        'x'     => -37,
                        'y'     => -71,
                        'text'  => "Yes",
                        'size'  => 9
                    ],
                    'bought_new' => [
                        'x'     => -37,
                        'y'     => -61,
                        'text'  => "Yes",
                        'size'  => 9
                    ],
                    'accident' => [
                        'x'     => -37,
                        'y'     => -51,
                        'text'  => "Yes",
                        'size'  => 9
                    ],
                ]
            ];
		
		//declaration checks
		$checks = [
				6 => [
					'A1' => [
						'x'     => 114,
						'y'     => 65,
						'reso'  => -1300, //size
						'image' => base_url("assets/img/check.png") // image path
					],
					'A2' => [
						'x'     => 127,
						'y'     => 72,
						'reso'  => -1300,
						'image' => base_url("assets/img/check.png")
					],

					'A3' => [
						'x'     => 123,
						'y'     => 79,
						'reso'  => -1300,
						'image' => base_url("assets/img/check.png")
					],

					'A4' => [
						'x'     => 95,
						'y'     => 85,
						'reso'  => -1300,
						'image' => base_url("assets/img/check.png")
					],
					'B' => [
						'x'     => 189,
						'y'     => 102,
						'reso'  => -1300,
						'image' => base_url("assets/img/check.png")
					],
					'C' => [
						'x'     => 189,
						'y'     => 111,
						'reso'  => -1300,
						'image' => base_url("assets/img/check.png")
					],
					'D' => [
						'x'     => 189,
						'y'     => 121,
						'reso'  => -1300,
						'image' => base_url("assets/img/check.png")
					],
					'E' => [
						'x'     => 189,
						'y'     => 129,
						'reso'  => -1300,
						'image' => base_url("assets/img/check.png")
					],
					'E' => [
						'x'     => 189,
						'y'     => 137,
						'reso'  => -1300,
						'image' => base_url("assets/img/check.png")
					],
					'PAYG1' => [
						'x'     => 189,
						'y'     => 162,
						'reso'  => -1300,
						'image' => base_url("assets/img/check.png")
					],
					'PAYG2' => [
						'x'     => 155,
						'y'     => 172,
						'reso'  => -1300,
						'image' => base_url("assets/img/check.png")
					],
					'PAYG3' => [
						'x'     => 155,
						'y'     => 176,
						'reso'  => -1300,
						'image' => base_url("assets/img/check.png")
					],
				],
		];

		$pdf = new FPDI();

		$directory = './assets/pdf_templates/';

		$count = $pdf->setSourceFile($directory.'template_wholesale_invoice.pdf');

		for($i=1; $i<=10; $i++ )
		{
			$pdf->AddPage();//add a page per loop
			$tplIdx = $pdf->importPage($i);//import page of the given pdf $i = page number
			$pdf->useTemplate($tplIdx, 0, 0, 0);// use the imported page as the template

			$pdf->SetFont('Helvetica');
			$pdf->SetTextColor(125, 126, 128);//rgb text color
			$pdf->SetMargins(0,0,0);//set the margin of the pdf to 0 all
			$pdf->SetAutoPageBreak('auto',0); // page break per page

			if(isset($xy_arr[$i]))
			{
				foreach ($xy_arr[$i] as $x_key => $x_val) 
				{
					$pdf->SetFontSize($xy_arr[$i][$x_key]['size']); //font size
					$pdf->SetXY($xy_arr[$i][$x_key]['x'], $xy_arr[$i][$x_key]['y']); //x and y coordinates
					$pdf->Write(0, $xy_arr[$i][$x_key]['text']); // write the text
				}
			}

			if(isset($checks[$i]))
			{
				foreach ($checks[$i] as $s_key => $s_val) 
				{
					
					$pdf->Image($checks[$i][$s_key]['image'],$checks[$i][$s_key]['x'],$checks[$i][$s_key]['y'],$checks[$i][$s_key]['reso']);
				}
			}

			if($i == 7)
			{
				$string_1 = "Car Quotes Online";
				$string_2 = "wholesale@qteme.com.au
							Car Quotes Head Office - East Balmain NSW 2041
							NSW 2041
							0407 999 997";

				$pdf->SetFont('Helvetica','B');
				$pdf->SetFontSize(8);
				$pdf->SetXY(24, 51.5);
				$pdf->MultiCell(85, 4, $string_1, 0, 'L', false);//parameters (length of the invisible box, height, text, border 1 with 0 none, 
																// 'R' justify L left R right C center, fill the box if true or false )
				$pdf->SetFont('Helvetica');
				$pdf->SetFontSize(8);
				$pdf->SetXY(24, 56);
				$pdf->MultiCell(85, 4, $string_2, 0, 'L', false);

				$string_3 = "Quote Me";
				$string_4 =	"accounts@qteme.com.au
							Po Box 829, Norton Street,
							Leichhardt, NSW 2040
							Call 1300 070 706";

				$pdf->SetFont('Helvetica', 'B');
				$pdf->SetFontSize(8);
				$pdf->SetXY(108, 51.5);
				$pdf->MultiCell(80, 4, $string_3, 0, 'L', false);

				$pdf->SetFont('Helvetica');
				$pdf->SetFontSize(8);
				$pdf->SetXY(108, 56);
				$pdf->MultiCell(80, 4, $string_4, 0, 'L', false);

				$description = "Tender Fee for the introduction of Hyundai Accent (Dbv96l)";

				$pdf->SetFont('Helvetica');
				$pdf->SetFontSize(8);
				$pdf->SetXY(24, 117);
				$pdf->MultiCell(48, 4, $description, 0, 'L', false);
			}
			if($i == 10)
			{
				//image source
				// $image_1 = "image_1.jpeg";

				// $pdf->Image($image_1,22,67.3,77.5,49.6); //image source, x, y, width, height
				// $pdf->Image($image_1,110.5,67.3,77.5,49.6);
				// $pdf->Image($image_1,22,143,77.5,49.6);
				// $pdf->Image($image_1,110.5,143,77.5,49.6);
			}
		}
		$final_file_name = "CHANGE TO YOUR FILE NAME";
		// $pdf->Output();
		$pdf->Output('./your/directory/'.$final_file_name, 'F'); //F if you want to save the file to a path
	}
    
    private function set_upload_options() {   
        //upload an image options
        $config = array();
        $config['upload_path'] = './uploads/tradein_cars/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['encrypt_name'] = TRUE;        
        $config['overwrite']     = FALSE;
        return $config;
    }
    
    function save_tradeIn(){
        //echo '<pre>';print_r($_FILES);exit;
        $return = array();
        $post_data =  $this->input->post();

        if(!empty($post_data)){
            if(isset($post_data['fapplication_lead_id']) && !empty($post_data['fapplication_lead_id'])){
                
                $post_data['id_leads'] = $post_data['fapplication_lead_id'];
                $tradein_id = $this->quote_model->get_id_by_val('tradein_new','id_tradein','id_leads',$post_data['fapplication_lead_id']);
                
                if(isset($post_data['images']) && !empty($post_data['images'])){

                    $images = json_decode($post_data['images'], true);
                    $images = implode(',', $images);
                    $post_data['images'] = str_replace(",",", ",$images);
                }

                if(isset($post_data['old_images']) && !empty($post_data['old_images'])) {
                	$old_images = json_decode($post_data['old_images'], true);
                	$old_images = array_filter($old_images);
                	$old_images = implode(',', $old_images);

                    // $post_data['images'] = $post_data['old_images'].', '.str_replace(",",", ",$old_images);
                    if(!empty($post_data['images'])) {
                    	$post_data['images'] = $post_data['images'].', '.str_replace(",",", ",$old_images);
                    }
                    else {
                    	$post_data['images'] = str_replace(",",", ",$old_images);
                    }

                }

                //echo '<pre>';print_r($tradein_id);exit;
                
                unset($post_data['fapplication_lead_id']);
                unset($post_data['old_images']);
                $post_data['id_user'] = $this->data['user_id'];
                
                if(isset($tradein_id) && !empty($tradein_id)){
                    $where_array = array('id_tradein' => $tradein_id);
                    $this->db->where($where_array);
                    $data_array = $post_data;
                    if($this->db->update('tradein_new', $data_array)){
                        $return['sucess'] = 'Update';    
                    }                    
                }else{
                    if($this->db->insert('tradein_new', $post_data)) {
                        $return['insert_id'] = $this->db->insert_id();
                        $tradein_id = $this->db->insert_id();
                        $return['sucess'] = 'Insert';
                    }else{
                        $return['error'] = 'NotIns';
                    }
                }

                /*if($return['sucess'] == 'Update' || $return['sucess'] == 'Insert'){
                    
                    if(isset($_FILES['photos']) && !empty($_FILES['photos'])){
                        $uploadData = array();
                        $files = $_FILES;
                        $this->load->library('upload');
                        $cpt = count($_FILES['photos']['name']);

                        for($i=0; $i<$cpt; $i++) {
                            $_FILES['photos']['name']= $files['photos']['name'][$i];
                            $_FILES['photos']['type']= $files['photos']['type'][$i];
                            $_FILES['photos']['tmp_name']= $files['photos']['tmp_name'][$i];
                            $_FILES['photos']['error']= $files['photos']['error'][$i];
                            $_FILES['photos']['size']= $files['photos']['size'][$i];    

                            $this->upload->initialize($this->set_upload_options());
                            
                            if($this->upload->do_upload('photos')){                                
                                $fileData = $this->upload->data();
                                $uploadData[$i]['file_name'] = $fileData['file_name'];
                            }
                        }                        
                        if(!empty($uploadData)){
                            $photos_name = array_column($uploadData, 'file_name');
                            $photos_name = implode(", ", $photos_name);
                            if(!empty($photos_name)){
                                //echo $photos_name;
                                $where_array = array('id_tradein' => $tradein_id);
                                $this->db->where($where_array);
                                $this->db->update('tradein_new', array('images' => $photos_name));                                
                                if($this->db->affected_rows()){
                                    $return['fileUpload'] = 'sucess';
                                }else{
                                    $return['fileUpload'] = 'error';
                                }
                                
                            }    
                        }
                    }
                    
                }*/
                
            }else{
                $return['error'] = "LeadEmpty";
            }
        }
        print json_encode($return);
        exit;
        //echo '<pre>';print_r($post_data);
    }

    function save_picture() {
    	$post_data = $this->input->post();
    	echo "<pre>";
    	print_r($post_data);
    	echo "</pre>";
    }

    public function send_mail_client_trade() {
    	// echo "string"; die();
    	$post_data = $this->input->post();
        //echo '<pre>';print_r($post_data);exit;        
        /*if(isset($post_data['id_tradein'])){
        }elseif(isset($post_data['id_quote_request']){
        }else{
            echo "error";
            exit;
        }*/
    	// echo "string1"; die();
        $data = $this->data;
        $lead_id = $post_data['id_lead'];
        $lead = $this->lead_model->get_lead($post_data['id_lead']);

        $content = $post_data['email_client_template'];


        $from_name = $lead['qs_name'];
        $from_email = $lead['qs_email'];
        $to_email = $lead['lead_email'];
        
        $to_name = substr($lead['lead_name'],0,strpos($lead['lead_name'], ' '));
        
        if(empty($to_name) || $to_name == ''){
            $to_name = $lead['lead_name'];
        }
        
        if(isset($post_data['id_tradein']) && !empty($post_data['id_tradein'])){
            
            $rb_data = $this->fapplication_model->get_column_value_by_id('tradein_new','rb_data',array('id_tradein' => $post_data['id_tradein']));
            $car_name = $this->fapplication_model->get_column_value_by_id('rb_data','name',array('car_id' => $rb_data));

        }else if(isset($post_data['id_quote_request']) && !empty($post_data['id_quote_request'])){
            
            $rb_data = $this->fapplication_model->get_column_value_by_id('quote_requests','rb_data',array('id_quote_request' => $post_data['id_quote_request']));            
            $car_name = $this->fapplication_model->get_column_value_by_id('rb_data','name',array('car_id' => $rb_data));

        }
        //echo $link_url;exit;

        $subject = $data['company']['company_name']." - Submit Trade Vehicle Details"." - ". $car_name;
        date_default_timezone_set('Australia/Sydney');
        ini_set('max_execution_time', -1);	
        $now = date("Y-m-d H:i:s");

        /**/
        /*if($to_email == 'paul@finquote.com.au') {
        	$to_email = 'devakshay89@gmail.com';
        }*/
        /*echo $to_email;
        die();*/
        /**/

        $this->load->library('email');
        $this->email->clear(TRUE);
        $this->email->set_mailtype('html');
        $this->email->to($to_email);
        $this->email->from($from_email, $from_name);
        $this->email->subject($subject);
        $this->email->message($content);
        if($this->email->send()){
            $trail_array = [
                'fk_user'    => $data['user_id'],
                'fk_account' => $lead_id,
                'sent_to'    => $to_email,
                'subject'    => $subject,
                'message'    => $content,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->fapplication_model->email_audit_trail_model($trail_array);
            echo "success";
        }else{
            echo "error";
        }
        //echo '<pre>';print_r();exit;
        
    }
    
    public function send_mail_dealer_trade() {
    	// echo "string";die();
        $post_data = $this->input->post();

        $data = $this->data;
        $lead_id = $post_data['id_lead'];
        $dealer_id = $post_data['dealer_id'];
        
        $notes = $post_data['mail_text'];
        
        $lead = $this->lead_model->get_lead($lead_id);
        $dealer_detail = $this->user_model->get_dealer($dealer_id);
        //echo '<pre>';print_r($lead);

        $content = $post_data['email_dealer_template'];

        $from_name = $lead['qs_name'];
        $from_email = $lead['qs_email'];
        $to_email = $dealer_detail['email'];
        
        $to_name = substr($dealer_detail['name'],0,strpos($dealer_detail['name'], ' '));
        
        if(empty($to_name) || $to_name == ''){
            $to_name = $dealer_detail['name'];    
        }

        /*if($to_email == 'paul@finquote.com.au') {
        	$to_email = 'devakshay89@gmail.com';
        }*/
        /*echo $to_email;
        die();*/
        /**/
        
        $cq_number = 'FQ'.str_pad($lead['id_fq_account'], 5, '0',STR_PAD_LEFT);

        $rb_data = $this->fapplication_model->get_column_value_by_id('tradein_new','rb_data',array('id_tradein' => $post_data['id_tradein']));
        $car_name = $this->fapplication_model->get_column_value_by_id('rb_data','name',array('car_id' => $rb_data));

        $subject = $data['company']['company_name']." - Trade Valuation"." - ". $car_name;

        date_default_timezone_set('Australia/Sydney');
        ini_set('max_execution_time', -1);	
        $now = date("Y-m-d H:i:s");
        $this->load->library('email');
        $this->email->clear(TRUE);
        $this->email->set_mailtype('html');
        $this->email->to($to_email);
        $this->email->from($from_email, $from_name);
        $this->email->subject($subject);
        $this->email->message($content);
        if($this->email->send()){
            $trail_array = [
                'fk_user'    => $data['user_id'],
                'fk_account' => $lead_id,
                'sent_to'    => $to_email,
                'subject'    => $subject,
                'message'    => $content,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->fapplication_model->email_audit_trail_model($trail_array);
            
            $recipients_array = [
                'fk_tradein' => $post_data['id_tradein'],
                'id_dealer'  => $dealer_id,
                'email'      => $to_email,
                'created_at' => date('Y-m-d H:i:s'),
            ];
            $this->db->insert('tradein_recipients', $recipients_array);
            
            echo "success";
        }else{
            echo "error";
        }
        
        //echo '<pre>';print_r($post_data);exit;
    }

    public function send_mail_wholesaler_trade() {
    	// echo "string"; die();
        $post_data = $this->input->post();
        
        $data = $this->data;
        $lead_id = $post_data['id_lead'];
        $wholesaler_id = $post_data['dealer_id'];
        
        $notes = $post_data['mail_text'];        
        $lead = $this->lead_model->get_lead($lead_id);
        // $wholesaler_detail = $this->user_model->get_wholesaler($wholesaler_id);
        $wholesaler_detail = $this->user_model->get_dealer($wholesaler_id);

        $content = $post_data['email_wholesaler_template'];

        //echo '<pre>';print_r($lead);

        $from_name = $lead['qs_name'];
        $from_email = $lead['qs_email'];
        $to_email = $wholesaler_detail['email'];
        
        $to_name = substr($wholesaler_detail['name'],0,strpos($wholesaler_detail['name'], ' '));
        
        if(empty($to_name) || $to_name == ''){
            $to_name = $wholesaler_detail['name'];    
        }
        
        $rb_data = $this->fapplication_model->get_column_value_by_id('tradein_new','rb_data',array('id_tradein' => $post_data['id_tradein']));
        $car_name = $this->fapplication_model->get_column_value_by_id('rb_data','name',array('car_id' => $rb_data));

        $subject = $data['company']['company_name']." - Trade Valuation"." - ". $car_name;

        /*if($to_email == 'paul@finquote.com.au') {
        	$to_email = 'devakshay89@gmail.com';
        }*/
        /*echo $to_email;
        die();*/

        date_default_timezone_set('Australia/Sydney');
        ini_set('max_execution_time', -1);	
        $now = date("Y-m-d H:i:s");
        $this->load->library('email');
        $this->email->clear(TRUE);
        $this->email->set_mailtype('html');
        $this->email->to($to_email);
        $this->email->from($from_email, $from_name);
        $this->email->subject($subject);
        $this->email->message($content);
        if($this->email->send()){
            $trail_array = [
                'fk_user'    => $data['user_id'],
                'fk_account' => $lead_id,
                'sent_to'    => $to_email,
                'subject'    => $subject,
                'message'    => $content,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->fapplication_model->email_audit_trail_model($trail_array);
            
            $recipients_array = [
                'fk_tradein' => $post_data['id_tradein'],
                'id_dealer'  => $wholesaler_id,
                'email'      => $to_email,
                'created_at' => date('Y-m-d H:i:s'),
            ];
            $this->db->insert('tradein_recipients', $recipients_array);
            
            echo "success";
        }else{
            echo "error";
        }
        
        //echo '<pre>';print_r($post_data);exit;
    }
    
    public function send_test_mail() {
        //$this->load->library('email');
        date_default_timezone_set('Australia/Sydney');
        ini_set('max_execution_time', -1);
        $now = date("Y-m-d H:i:s");
        
        $fq_lead_number = 'FQ0009';
        $c_first_name = 'Paul';
        $email_paragraph = 'ertyuiopplk';
        $submit_url = 'www.finquote.au';
        $car_name = 'Landruser Prado';

        //$manager_name = $user_details['dealer_manager_name'];
        //$to = $user_details['dealer_email'];
        $content = '';
        $where_id = array('id_email_template' => 5,'deprecated' => 0);
        $email_template = $this->fapplication_model->get_column_value_by_id('system_email_templates','content',$where_id);

        $content = $email_template;
        $content = str_replace("@@FQ_LEAD_NUMBER@@",$fq_lead_number,$content);
        $content = str_replace("@@MANGER_NAME@@",$c_first_name,$content);
        $content = str_replace("@@EMAIL_PARAGRAPH@@",$email_paragraph,$content);
        $content = str_replace("@@SUBMIT_URL@@",$submit_url,$content);

        //$subject = $data['company']['company_name']." - Submit Trade Vehicle Details."." - ". $car_name;
        $subject = "Submit Trade Vehicle Details."." - ". $car_name;
        
        $content = str_replace("@@FQ_LEAD_NUMBER@@",$cq_number,$content);
        $content = str_replace("@@MANGER_NAME@@",$manager_name,$content);
        $content = str_replace("@@EMAIL_PARAGRAPH@@",$email_paragraph,$content);
        $content = str_replace("@@SUBMIT_URL@@",$link_url,$content);
        $content = str_replace("@@CAR_NAME@@",$car_name,$content);

        $subject = $data['company']['company_name']." - Quote Request"." - ". $car_name;
        date_default_timezone_set('Australia/Sydney');
        ini_set('max_execution_time', -1);	
        $now = date("Y-m-d H:i:s");
        $this->load->library('email');
        $this->email->clear(TRUE);
        $this->email->set_mailtype('html');
        $this->email->to($to);
        $this->email->from($from_email, $from_name);
        $this->email->subject($subject);
        $this->email->message($content);
        
        if($this->email->send()){
            /*$trail_array = [
                'fk_user'    => $data['user_id'],
                'fk_account' => $lead_id,
                'sent_to'    => $to,
                'subject'    => $subject,
                'message'    => $content,
                'attachment'    => $file_name,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->fapplication_model->email_audit_trail_model($trail_array);*/
            echo "sucess";

        }else{
            echo "error";
        }
        $this->email->clear();        
    }
    
    function encTest(){
        
        $lead = 200;
        $trade_id = 3;
        
        $link_url = site_url('process/recive_submitterd').'/'.$lead.'/'.$trade_id;
        $link_url = "<a href=".$link_url.">click here</a>";
        
        //print_r();
        
        
        echo $link_url; exit();
        
        
    }
}
?>
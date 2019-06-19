<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('unlogged_main.php');

require_once("./application/libraries/PDFMerger/PDFMerger.php");
require_once("./application/libraries/PDFMerger/fpdf/fpdf.php");
require_once("./application/libraries/PDFMerger/fpdi/fpdi.php");

class VerifyRegistration extends Unlogged_main 
{
	function __construct ()
	{
		parent::__construct();
	}

	function index ()
	{
		header ("Location: ".site_url());
		exit ();
	}	
	
	public function verifyDealer ()
	{
		$now = Date('Y-m-d H:i:s');
		$input_arr = $this->input->post();
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Email', 'trim|required|valid_email|xss_clean|callback_check_username');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|max_length[25]|matches[confirm-password]|md5');
		$this->form_validation->set_rules('confirm-password', 'Password Confirmation', 'trim|required');
		
		$this->form_validation->set_rules('dealership_name', 'Dealership Name', 'trim|required');
		$this->form_validation->set_rules('dealer_license', 'Dealer License Number', 'trim|required');
		$this->form_validation->set_rules('abn', 'ABN', 'trim|required');
		$this->form_validation->set_rules('address', 'Dealership Address', 'trim|required');
		$this->form_validation->set_rules('state', 'State', 'trim|required');
		$this->form_validation->set_rules('postcode', 'Postcode', 'trim|required');
		
		$this->form_validation->set_rules('manager_name', 'Fleet Manager - Name', 'trim|required');
		$this->form_validation->set_rules('manager_email', 'Fleet Manager - Email', 'trim|required');
		$this->form_validation->set_rules('manager_mobile', 'Fleet Manager - Mobile', 'trim|required');
		$this->form_validation->set_rules('manager_phone', 'Fleet Manager - Phone', 'trim|required');
		
		$this->form_validation->set_rules('account_name', 'Accounts Payable - Name', 'trim|required');
		$this->form_validation->set_rules('account_email', 'Accounts Payable - Email', 'trim|required');
		$this->form_validation->set_rules('account_mobile', 'Accounts Payable - Mobile', 'trim|required');
		$this->form_validation->set_rules('account_phone', 'Accounts Payable - Phone', 'trim|required');
		
		$this->form_validation->set_rules('dealer_principal_name', 'Dealer Principal - Name', 'trim|required');
		$this->form_validation->set_rules('dealer_principal_email', 'Dealer Principal - Email', 'trim|required');
		$this->form_validation->set_rules('dealer_principal_mobile', 'Dealer Principal - Mobile', 'trim|required');
		$this->form_validation->set_rules('dealer_principal_phone', 'Dealer Principal - Phone', 'trim|required');		

		$this->form_validation->set_rules('bank_acct_name', 'Bank Account Name', 'trim');
		$this->form_validation->set_rules('bank_acct_num', 'Bank Account Number', 'trim');
		$this->form_validation->set_rules('bank_acct_bsb', 'Bank Account BSB', 'trim');

		$this->form_validation->set_rules('description', 'Additional Information', 'trim');

		// $location = json_decode(file_get_contents('http://freegeoip.net/json/'.$ip_address));
		// $location_string = $location->city.' '.$location->region_name.' '.$location->country_name.' '.$location->zip_code;
		$location_string = "";
		$ip_address = $_SERVER['REMOTE_ADDR'];
		$registration_details = json_encode($input_arr);

		if ($this->form_validation->run() == FALSE)
		{
			$this->logs_model->insert_log($input_arr['username'], $ip_address, $registration_details, $location_string, $now, '0000-00-00 00:00', '3' , '2');
			
			$data['title'] = 'El Quoto | Dealer Registration';
			$data['header'] = 'Home';
			$data['makes'] = $this->car_model->get_makes();
			$this->load->view('register', $data);
		}
		else
		{
			$this->logs_model->insert_log($input_arr['username'], $ip_address, $registration_details, $location_string, $now, '0000-00-00 00:00', '3' , '1');

			$input_arr['username'] = strtolower($input_arr['username']);
				
			$this->user_model->register_dealer($input_arr);
			$user_id = $this->db->insert_id();
			
			if ($user_id <> "" AND $user_id <> 0)
			{
				$dealership_brand = "";
				$make_index = 1;
				while ($make_index <= 100)
				{
					if (isset($input_arr['make_'.$make_index]))
					{
						$dealership_brand .= $input_arr['make_'.$make_index].",";
					}
					$make_index ++;
				}
				$dealership_brand = substr($dealership_brand, 0, -1);
				
				$input_arr['dealership_brand'] = $dealership_brand;				
				
				$this->user_model->register_dealer_attributes($user_id, $input_arr);
				
				$this->session->set_userdata(array(
					'logged_in'			=> 1,
					'login_type'		=> 1,
					'admin_type'		=> 0,
					'user_id'       	=> $user_id,
					'username'      	=> $input_arr['username'],
					'name'   			=> $input_arr['manager_name'],
					'phone'   			=> $input_arr['manager_phone'],
					'mobile'   			=> $input_arr['manager_mobile'],
					'state'   			=> $input_arr['state'],
					'postcode'   		=> $input_arr['postcode'],
					'status'   			=> 1
				));

				$inline_dynamic_fields = array();
				$this->templated_special_email_init(14, 'company', $input_arr['username'], $inline_dynamic_fields, '');
			}

			header("Location: " . site_url());
			exit();							
		}	
	}

	public function verifyWholesaler ()
	{
		$ip_address = $_SERVER['REMOTE_ADDR'];
		$location_arr = json_decode(file_get_contents('http://freegeoip.net/json/'.$ip_address));
		$date = Date('Y-m-d H:i:s');
		$location = $location_arr->city.' '.$location_arr->region_name.' '.$location_arr->country_name.' '.$location_arr->zip_code;
		$log_description = json_encode($_POST);

		$input_arr = $this->input->post();
		$input_arr['username'] = strtolower(trim($input_arr['username']));
		$input_arr['password'] = md5($input_arr['password']);
		$input_arr['confirm_password'] = md5($input_arr['confirm_password']);
		$input_arr['status'] = 1;
				
		$existing_username_result = $this->user_model->check_username_availability($input_arr['username']);
		if (
			($existing_username_result) OR 
			($input_arr['username'] == "") OR 
			($input_arr['password'] == "") OR 
			($input_arr['password'] <> $input_arr['confirm_password']) OR
			($input_arr['name'] == "") OR
			($input_arr['business_name'] == "") OR
			($input_arr['abn'] == "") OR
			($input_arr['dealer_license'] == "") OR
			($input_arr['address'] == "") OR
			($input_arr['postcode'] == "") OR
			($input_arr['state'] == "") OR
			($input_arr['phone'] == "") OR
			($input_arr['mobile'] == "")
		)
		{
			echo "fail";
		}
		else
		{
			$time = time();
			$image_base64_url = $input_arr['signature_image'];
			$image_base64_url = str_replace('[removed]', '', $image_base64_url);
			$image_url = base64_decode($image_base64_url);		
			$image_path = './uploads/signatures/signature_' . $time . ".png";
			$image_file_name = "signature_" . $time . ".png";
			file_put_contents($image_path, $image_url);
			$input_arr['signature_image'] = $image_file_name;
			
			$exceptions_arr = array('confirm_password');
			$registration_result = $this->user_model->register_wholesaler(3, $input_arr, $exceptions_arr);
			$user_id = $this->db->insert_id();
			if ($registration_result)
			{
				$xy_arr = [
					3 => [
						'wholesaler_name' => [
							'x'     => 21,
							'y'     => -52.5,
							'text'  => $input_arr['name'],
							'size'  => 9
						],
						'registration_date' => [
							'x'     => 83,
							'y'     => -37,
							'text'  => date('d F Y'),
							'size'  => 9
						]
					]
				];
				
				$sig_coords = [
					3 => [
						'last_signature' => [
							'x'     => 21,
							'y'     => 255,
							'reso'  => -400,
							'image' => base_url("uploads/signatures/".$image_file_name)
						]
					]
				];

				$pdf = new FPDI();
				$directory = './assets/pdf_templates/';
				$page_count = $pdf->setSourceFile($directory.'template_tradein_package.pdf');

				for($i=1; $i<=$page_count; $i++)
				{
					if ($i > 3) // Pages to skip
					{
						continue;
					}
					
					$pdf->AddPage();
					$tplIdx = $pdf->importPage($i);
					$pdf->useTemplate($tplIdx, 0, 0, 0);
					$pdf->SetFont('Helvetica');
					$pdf->SetTextColor(125, 126, 128);
					$pdf->SetMargins(0,0,0);
					$pdf->SetAutoPageBreak('auto',0);
					if(isset($xy_arr[$i]))
					{
						foreach ($xy_arr[$i] as $x_key => $x_val) 
						{
							$pdf->SetFontSize($xy_arr[$i][$x_key]['size']); // Font size
							$pdf->SetXY($xy_arr[$i][$x_key]['x'], $xy_arr[$i][$x_key]['y']); //x and y coordinates
							$pdf->Write(0, $xy_arr[$i][$x_key]['text']); // write the text
						}
					}
					
					if ($i == 3)
					{
						if(isset($sig_coords[3]))
						{
							foreach ($sig_coords[3] as $s_key => $s_val) 
							{
								$pdf->Image($sig_coords[3][$s_key]['image'],$sig_coords[3][$s_key]['x'],$sig_coords[3][$s_key]['y'],$sig_coords[3][$s_key]['reso']);
							}
						}						
					}
				}
				
				$final_file_name = "wholesaler_agreement_".$user_id."_".$time.".pdf";
				$pdf->Output('./uploads/wholesaler_agreements/'.$final_file_name, 'F');
				
				$this->logs_model->insert_log( $this->input->post('username'), $ip_address, $log_description, $location, $date, '0000-00-00 00:00', '3' , '2' );
				$this->session->set_userdata(array(
					'logged_in'			=> 1,
					'login_type'		=> 3,
					'admin_type'		=> 0,
					'user_id'       	=> $user_id,
					'username'      	=> $input_arr['username'],
					'name'   			=> $this->input->post('name'),
					'phone'   			=> $this->input->post('phone'),
					'mobile'   			=> $this->input->post('mobile'),
					'state'   			=> $this->input->post('state'),
					'postcode'   		=> $this->input->post('postcode'),
					'status'   			=> 1
				));
				echo "success";
			}
			else
			{
				$this->logs_model->insert_log( $this->input->post('username'), $ip_address, $log_description, $location, $date, '0000-00-00 00:00', '3' , '1' );
				echo "fail";
			}
		}
	}
	
	public function verifyReferrer ()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Email', 'trim|required|valid_email|xss_clean|callback_check_username');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|max_length[25]|matches[confirm-password]|md5');
		$this->form_validation->set_rules('confirm-password', 'Password Confirmation', 'trim|required');
		$this->form_validation->set_rules('dealership_address', 'Dealership Address', 'trim|required');
		$this->form_validation->set_rules('state', 'State', 'trim|required');
		$this->form_validation->set_rules('postcode', 'Postcode', 'trim|required');
		$this->form_validation->set_rules('manager_name', 'Manager Name', 'trim|required');
		$this->form_validation->set_rules('manager_mobile', 'Manager Mobile', 'trim|required');
		$this->form_validation->set_rules('manager_phone', 'Manager Phone', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim');
		$this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required');
		$this->form_validation->set_rules('bank_acct_name', 'Bank Account Name', 'trim');
		$this->form_validation->set_rules('bank_acct_bsb', 'Bank Account BSB', 'trim');
		$this->form_validation->set_rules('bank_acct_num', 'Bank Account Number', 'trim');
		$this->form_validation->set_rules('acct_holders_name', 'Account Holder\'s Name', 'trim');
		
		$ip = $_SERVER['REMOTE_ADDR'];
		$location = json_decode( file_get_contents( 'http://freegeoip.net/json/'.$ip ) );
		$date = Date('Y-m-d H:i:s');
		$loc = $location->city.' '.$location->region_name.' '.$location->country_name.' '.$location->zip_code;

		$desc = json_encode( $_POST );

		if($this->form_validation->run() == FALSE)
		{
			$this->logs_model->insert_log( $this->input->post('username'), $ip, $desc, $loc, $date, '0000-00-00 00:00', '3' , '2' );
			
			$data['title'] = 'El Quoto | Dealer Registration';
			$data['header'] = 'Home';
			$data['brands'] = $this->car_model->get_brands();
			$this->load->view('register', $data);
		}
		else
		{
			$this->logs_model->insert_log( $this->input->post('username'), $ip, $desc, $loc, $date, '0000-00-00 00:00', '3' , '1' );
			
			$username          = strtolower($this->input->post('username'));
			$password          = $this->input->post('password');
			$state             = $this->input->post('state'); 			
			$postcode          = $this->input->post('postcode'); 			
			$address           = $this->input->post('dealership_address'); 
			$name              = $this->input->post('manager_name'); 
			$phone             = $this->input->post('manager_phone'); 			
			$mobile            = $this->input->post('manager_mobile'); 
			$description       = $this->input->post('description');
			$dob               = $this->input->post('dob');
			$bank_acct_name    = $this->input->post('bank_acct_name');
			$bank_acct_bsb     = $this->input->post('bank_acct_bsb');
			$bank_acct_num     = $this->input->post('bank_acct_num');
			$usertype          = $this->input->post('usertype');
			$acct_holders_name = $this->input->post('acct_holders_name');

			$dob = date('Y-m-d', strtotime($dob));

			$data['username'] = $username;
			$this->user_model->register_user($usertype, 0, $username, $password, $name, $state, $postcode, $address, $phone, $mobile, $description, $dob, $bank_acct_name, $bank_acct_bsb, $bank_acct_num ,$acct_holders_name);
			$user_id = $this->db->insert_id();

			$this->session->set_userdata(array(
				'logged_in'			=> 1,
				'login_type'		=> 4,
				'admin_type'		=> 0,
                'user_id'       	=> $user_id,
                'username'      	=> $username,
                'name'   			=> $name,
				'phone'   			=> $phone,
				'mobile'   			=> $mobile,
				'state'   			=> $state,
				'postcode'   		=> $postcode,
				'status'   			=> 0
			));

			header("Location: " . site_url());
			exit();
		}
	}

	public function activate_account ($username, $activation_code)
	{
		$this->user_model->activate_account($username, $activation_code);
		header("Location: ".site_url());
		exit();
	}

	public function check_username ()
	{
		$username = $this->input->post('username');
		$result = $this->user_model->check_username_availability($username);
		if($result)
		{
			$this->form_validation->set_message('check_username', 'The email/username you entered is already in use');
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public function check_username_availability ()
	{
		$username = $this->input->post('username');
		$result = $this->user_model->check_username_availability($username);
		if($result)
		{
			echo "fail";
		}
		else
		{
			echo "success";
		}
	}	
}
?>
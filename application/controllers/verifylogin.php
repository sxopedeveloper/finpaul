<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('unlogged_main.php');

class VerifyLogin extends Unlogged_main 
{
	function __construct()
	{
	    ob_start();
		parent::__construct();
	}

	function index ()
	{
		$data = $this->data;
		
		$ip_address = $_SERVER['REMOTE_ADDR'];	
		// $location = json_decode(file_get_contents('http://freegeoip.net/json/'.$ip_address));
		$date = Date('Y-m-d H:i:s');
		// $loc = $location->city.' '.$location->region_name.' '.$location->country_name.' '.$location->zip_code;
		$loc = "";

		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('login', $data);
		}
		else
		{
			$description = $this->input->post('username');
			$this->logs_model->insert_log( $this->input->post('username'), $ip_address, $description, $loc, $date, '0000-00-00 00:00', '1' , '1' );
			
			redirect(login);
			exit();
		}
	}

	function check_database ($password)
	{
		$username = $this->input->post('username');
		$result = $this->user_model->login($username, $password);

		if ($result)
		{
			foreach($result as $row)
			{
				if ($row->type == 2) 
				{
					$row->type = "Admin"; 
				}
				
				$this->session->set_userdata(array(
					'logged_in'     => 1,
					'login_type'    => $row->type,
					'admin_type'    => $row->admin_type,
					'user_id'       => $row->id_user,
					'username'      => $row->username,
					'name'          => $row->name,
					'phone'         => $row->phone,
					'mobile'        => $row->mobile,
					'state'         => $row->state,
					'postcode'      => $row->postcode,
					'status'        => $row->status,
					'fq_admin_flag' => $row->fq_admin_flag
				));
			
				$this->session->set_userdata['user_image'] = $row->profile_image;
			}
			return true;
		}
		else
		{
			$ip_address = $_SERVER['REMOTE_ADDR'];
			// $location = json_decode( file_get_contents( 'http://freegeoip.net/json/'.$ip_address ) );
			$date = Date('Y-m-d H:i:s');
			// $loc = $location->city.' '.$location->region_name.' '.$location->country_name.' '.$location->zip_code;
			$loc = "";
			
			$description = $username;
			$this->logs_model->insert_log( $username, $ip_address, $description, $loc, $date, '0000-00-00 00:00', '1' , '2' );
			
			$this->form_validation->set_message('check_database', 'Invalid username or password');
			return false;
		}
	}
}
?>
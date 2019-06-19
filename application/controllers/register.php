<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('unlogged_main.php');

class Register extends Unlogged_main 
{
	function __construct()
	{
		parent::__construct();
	}

	function index ()
	{	$data = $this->data;
		if ($this->session->userdata('logged_in'))
		{
			header("Location: " . site_url());
			exit();
		}
		else
		{
			$data['title'] = 'El Quoto | Dealer Registration';
			$data['header'] = 'Home';
			$data['makes'] = $this->car_model->get_makes();
			$this->load->helper(array('form'));
			$this->load->view('register', $data);
		}
	}

	function wholesaler ()
	{
		$data['title'] = 'El Quoto | Wholesaler Registration';
		$data['header'] = 'Home';		
		$this->load->view('wholesaler_registration', $data);
	}

	public function reset_password()
	{
		if ($this->input->post('email'))
		{
			$this->load->library('email');
			$email = $this->input->post('email');
			if ($email <> "")
			{			
				$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
				$pass = array();
				$alphaLength = strlen($alphabet) - 1;
				for ($i = 0; $i < 8; $i++) 
				{
					$n = rand(0, $alphaLength);
					$pass[] = $alphabet[$n];
				}
				$new_password = implode($pass);
				$user_data = $this->user_model->get_user_id($email);
				if (isset($user_data['id_user']))
				{
					if ($user_data['id_user'] <> "")
					{
						$this->user_model->update_password($user_data['id_user'], md5($new_password));
						$inline_dynamic_fields = array('[__new_password__]' => $new_password);
						$this->templated_special_email_init(13, 'company', $email, $inline_dynamic_fields, '');
					}			
				}
				header("Location: ".site_url());
				exit();
			}
		}
	}	
}
?>
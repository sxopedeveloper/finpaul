<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index ()
	{
		if($this->session->userdata('logged_in'))
		{
			if ($this->session->userdata('login_type') == 1) 
			{
				header("Location: " . site_url('user/home'));
				exit();
			}
			else if ($this->session->userdata('login_type') == 2 OR $this->session->userdata('login_type') == 'Admin')
			{
				header("Location: " . site_url('admin/home'));
				exit();				
			}
			else if ($this->session->userdata('login_type') == 3) 
			{
				header("Location: " . site_url('user/profile'));
				exit();
			}
			else if ($this->session->userdata('login_type') == 4) 
			{
				header("Location: " . site_url('user/referrals'));
				exit();
			}
		}
		else
		{
			header("Location: " . site_url('login'));
			exit();
		}
	}
	public function agreement()
	{
		$this->load->helper('file');
		$this->load->helper('download');
		$file = "FINQUOTE-Accredited-Dealer-Agreement.pdf";
		$name = "FINQUOTE";
		$html = "<style type='text/css'>.doc{ width:100%; border:none; height: 100vh; } body{ overflow-y: hidden; }</style><iframe class='doc' src='".base_url('assets/documents/'.$file)."'></iframe>";
		echo $html;
	}
}
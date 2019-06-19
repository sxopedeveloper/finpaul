<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('unlogged_main.php');

class Login extends Unlogged_main 
{
	function __construct()
	{
	    ob_start();
		parent::__construct();
	}

	function index()
	{
		$data = $this->data;
		
		if ($this->session->userdata('logged_in'))
		{
			header("Location: " . site_url('home'));
			exit();
		}
		else
		{
			$this->load->helper(array('form'));
			$this->load->view('login', $data);
		}
	}

}
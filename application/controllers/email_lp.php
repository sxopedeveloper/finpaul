<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('unlogged_main.php');

class Email_lp extends Unlogged_main
{
	public function __construct()
	{
		parent::__construct();
	}

	function index ()
	{
		header ("Location: ".site_url());
		exit ();
	}

	public function thank_you_email ()
	{
		date_default_timezone_set('Australia/Sydney');
		ini_set('max_execution_time', -1);	
		$now = date("Y-m-d H:i:s");
		
		$data = $this->data;
		
		$redirect = $_POST['redirect'];
		$client_name = $_POST['name'];
		$to = $_POST['email'];
		$subject = $_POST['subject'];
		$content = '
		<p style="line-height: 1.5">
			Dear '.$client_name.',
			<br />
			<br />
		</p>			
		<p style="line-height: 1.5">
			Thanks for inquiring with '.$data['company']['company_name'].'!
		</p>
		<p style="line-height: 1.5">
			Your tender manager will call you in the next day to confirm your vehicle details and options. If you need a tender run 
			quickly please call the tender bookings line on '.$data['company']['company_phone'].'.
		</p>
		<p style="line-height: 1.5">
			<br />
			<br />
			'.$data['company']['company_name'].'
			<br />
			'.$data['company']['company_email'].'
			<br />
			W: '.$data['company']['company_phone'].'
		</p>';
		$this->load->library('email');
		$this->email->clear();
		$this->email->set_mailtype('html');
		$this->email->to($to);
		$this->email->from($data['company']['company_email'], $data['company']['company_name']);
		$this->email->subject($subject);
		$this->email->message($this->email_header.$content.$this->email_footer);
		$this->email->send();
		header("Location: ".$redirect);
		exit();		
	}
}
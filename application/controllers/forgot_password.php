<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forgot_password extends CI_Controller {

	function __construct() {
		ob_start();
		parent::__construct();
		$this->load->helper('form');
		$this->load->model('user_model');
		$this->load->library('email');
	}
	
	function index()
	{
		// this will be the function that will $_GET data.
		$id = $this->input->get('id');
		$key = $this->input->get('key');
	
		$user_found = $this->user_model->get_userkey( $id, $key );
	
		if( $user_found )
		{
			$data['users'] = $user_found;
			$this->load->view( 'reset_password' , $data );
		}
		else
		{
			$this->load->view('reset_password');
		}
	}
	
	function update_password()
	{		
		if ($_POST['new_password'] <> $_POST['confirm_password'])
		{
			echo "fail1";
		}
		else
		{
			$update_result = $this->user_model->update_password( $_POST['id_user'], md5($_POST['new_password']) );
			
			if ($update_result)
			{
				//reset password key
				$this->user_model->clear_passkey( $_POST['id_user'] );
				echo "success";
			}
			else
			{
				echo "fail";
			}
		}
	}
	
	function send_email()
	{ 
		// ACTION to send password reset key
		$email = $this->input->post('email');
		$found = $this->user_model->getby_email( $email );
		
		if( $found )
		{
			//generate key and update referrers db
			$key = $this->verification_code( 12 );
			
			$this->user_model->update_passkey( $email, $key );
			
			$this->email->clear();
				
			$config['protocol'] = 'sendmail';
			$config['charset'] = 'iso-8859-1';

			$this->email->initialize($config);

			$this->email->set_mailtype('html');
			$this->email->to( $email );
			$this->email->from('info@qteme.com.au', 'Quote Me');
			$this->email->subject('Password Reset');
			
			$message = '
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
					<meta name="viewport" content="width=device-width"/>
					<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
					<title>El Quoto | Quote Me</title>
				</head>
				<body style="margin:0px; background: #f8f8f8; ">
					<div width="100%" style="background: #f8f8f8; padding: 0px 0px; font-family:arial; line-height:28px; height:100%; width: 100%; color: #514d6a;">
					<div style="max-width: 700px; padding:50px 0; margin: 0px auto; font-size: 14px">
					<table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
						<tbody>
							<tr style="background: #fff;">
								<td style="vertical-align: top; padding: 25px 20px 10px 40px; text-align: left;">
									<a href="http://www.myelquoto.com.au" target="_blank">
										<img src="http://www.mycqo.com.au/assets/img/logos/new_quoteme.png" alt="Quote Me" style="border:none; width: 250px;"/>
									</a>
								</td>
							</tr>
						</tbody>
					</table>
					<table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
						<tbody>
							<tr>
								<td style="background: #58c603; padding-left: 40px; color: #fff; text-align: left;">
									<span style="background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-origin: initial; background-clip: initial; background-color: #58c603; font-size: 1em; color: rgb(255,255,255);">
										<b>
											QuoteMe Hotline | 1300 070 706 | 
											<a href="mailto:info@qteme.com.au" target="_blank" style="text-decoration:none;">
												<span style="color:rgb(255,255,255);text-decoration:none">info</span>
												<span style="color:rgb(255,255,255);">@qteme.com.au</span>
											</a>
										</b>
									</span>
								</td>
							</tr>
						</tbody>
					</table>
					<div style="padding: 40px; background: #fff; color: #000;">
						<h1 style="font-size:20px;">
							Hi '.$found->name.',
						</h1>
						<p style="line-height:1.5;">
							We got a request to reset your Quote Me password.
						</p>
						<p style="line-height:1.5;">
							If you ignore this message, your password won&#39;t be changed.
						</p>
						<a href="'.site_url('forgot_password').'?id='.$found->id_user.'&key='.$key.'" style="background: #58c603; color: #ffffff; text-decoration: none; padding: 10px 15px; border-radius: 5px;">Reset Password</a>
					</div>
					<div style="text-align: center; font-size: 12px; color: #ffffff; background: #58c603; padding: 10px 5px;">
						<span style="display: block; font-size: 0.8em; font-family: verdana,geneva,sans-serif; line-height: 14px;">
							Quote Me | Suite 3, Level 27 Governor Macquarie Tower | 1 Farrer Place | NSW 2000
						</span>
						<span style="font-size: 0.8em; font-family: verdana,geneva,sans-serif; line-height: 14px;">
							Ph: 1300 070 706 | Skype: | 
							<a href="mailto:info@qteme.com.au" target="_blank" style="text-decoration: none; color: #ffffff;">
								info@qteme.com.au
							</a> or 
							<a href="mailto:accounts@qteme.com.au" target="_blank" style="text-decoration: none; color: #ffffff;">
								accounts@qteme.com.au
							</a>
						</span>
					</div>
					</div>
					</div>
				</body>
			</html>';
            $message = '';
            $href = site_url('forgot_password').'?id='.$found->id_user.'&key='.$key;
            $where_id = array('template_text' => 'forgot_password','deprecated' => 0);
            $email_template = $this->user_model->get_column_value_by_id('system_email_templates','content',$where_id);
            $content = $email_template;

            $message = str_replace("@@FOUND_NAME@@",$found->name,$content);            
            $message = str_replace("@@URL@@",$href,$content);
            
            $this->email->message($content);
			
			if( $this->email->send() )
			{
				echo 'success';
			}
			else 
			{
				echo 'There is an error sending email. Please try again later.';
			}
		}
		else 
		{
			echo 'No account found associated with the email!';
		}
	}
	
	function verification_code( $length = 10 ) 
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen( $characters );
		$randomString = '';
		for ($i = 0; $i < $length; $i++) 
		{
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
}
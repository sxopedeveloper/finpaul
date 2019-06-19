<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once("./application/libraries/messagemedia/autoload.php");
ob_start();
class Process extends CI_Controller
{
    protected $settings = [];
    protected $email_header = "";
    protected $email_footer = "";
    protected $query_number = "";
    protected $query_mail = "";
    protected $data = [];
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('download');
        $company_id = 1;
        $this->load->model("settings_model");
        $this->load->model('user_model', '', TRUE);
        $this->load->model('lead_model', '', TRUE);
        $this->load->model('notification_model', '', TRUE);
        $this->load->model('fapplication_model', '', TRUE);
        $this->settings = $this->settings_model->get_settings($company_id);
        $this->email_header = '
				<html xmlns="http://www.w3.org/1999/xhtml">
					<head>
						<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
						<meta name="generator" content="HTML Tidy for Linux/x86 (vers 25 March 2009), see www.w3.org">
						<title>El Quoto | '.$this->settings['company_name'].'</title>
					</head>
					<body  width="600px" style="width:800px;    margin: 10px auto;background: #ffffff; font-family: Verdana, Geneva, sans-serif; font-size: 14px; border: 1px solid #d8d8d8; padding: 0px">
						<style>p {line-height: 1.5;}</style>					
						<table style="border-spacing: 0px" bgcolor="#ffffff" width="100%" cellspacing="0" cellpadding="0">
							<tbody>
								<tr>
									
								</tr>
								<tr>
                                    <td align="left" style="padding: 15px 30px 15px 30px; color: #484848;">';
                                    
                                    /*
                                    <td valign="middle" align="middle">
										<a href="'.$this->settings['company_url'].'" rilt="Header_Logo" target="_blank" style="text-decoration: none;">
											<img src="'.$this->settings['company_logo'].'" width="200px;" style="margin-right: 15px; margin-top: 15px"><br />
										</a>
										<p style="background: #58c603; color: #ffffff; padding: 3px 15px; font-size: 1.0em; color: #ffffff; margin-top: 5px; margin-bottom: 20px;">

										</p>
                                    </td>
                                    */
        $this->email_footer ='</td>
								</tr>
								<tr>
									<td align="center">
										<a href="'.$this->settings['company_url'].'" rilt="Header_Logo" target="_blank" style="text-decoration: none;">
											<img src="'.base_url("/assets/img/logos/email_footer.png").'" width="500px;" style="margin-right: 15px; margin-top: 15px"><br />
										</a>
									</td>
								<td>
								<tr>
									<td align="center">
										<p style="background: #58c603; color: #ffffff; padding: 3px 15px; font-size: 1.0em; color: #ffffff; margin-top: 5px; margin-bottom: 20px;">
											<b style="">
												'.$this->settings['company_name'].' | 
												'.$this->settings['company_phone'].' | 
												<a href="mailto:'.$this->settings['company_email'].'" style="color: #ffffff; text-decoration: none;" >
													<span style="color: #ffffff; text-decoration: none;">'.$this->settings['company_email'].'</span>
												</a>											
											</b>
										</p>										
									</td>
								</tr>
							</tbody>
						</table>
					</body>
				</html>';
        $this->data['company'] = $this->settings; 
        $this->query_number = "1300 221 466";
        $this->query_mail = "support@finquote.com.au";
        
        $this->load->library('encrypt');
        
    }

    public function index(){
        echo $this->email_header;
        echo $this->email_footer;
        exit;
        $this->session->set_flashdata('message',"Login ?");
        //echo site_url();	
        redirect(site_url()."/login");
    }
    public function confirmdealer($dealer_id='')
    {
        if($dealer_id != '')
        {
            $table = "users";
            $where = array("MD5(id_user)"=>$dealer_id,"status"=>0);
            $row = $this->user_model->getRow($table,$where);
            $password = random_password();
            $enc_password = md5($password);
            if($row)
            {
                $db_dealer_id = $row->id_user;
                $dealer = $this->user_model->get_dealer($db_dealer_id);
                if($dealer)
                {
                    $is_status_changed = $this->user_model->activate($db_dealer_id);
                    $upass_status = $this->user_model->update_password($db_dealer_id,$enc_password);

                    $data = $this->data;
                    $from_email = $data['company']['company_email'];
                    $from_name = $data['company']['company_name'];
                    $to = $dealer['username'];
                    $subject = "Congratulations for registering with FinQuote";
                    $content = "
						<p style='line-height: 1.5'>
							Congratulations for registering with FinQuote you are now active and set up to receive quote requests and new vehicle orders.
						</p>
						<p style='line-height: 1.5'>
							Please <a href='".site_url('login')."'>click here</a> to login to your account.
						</p>
						<p style='line-height: 1.5'>
							Your username: {$dealer['email']} <br>
							Your Password: {$password}
						</p>
						<p style='line-height: 1.5'>
						Once you have logged in you can change your password in the User tab in the main menu on the left of your home screen. You can also update your details and add contacts through the profile tab in the main menu.
						</p>
						<p style='line-height: 1.5;margin-bottom: 25px;'>
							Once registered you will receive an email with login details to your account where you can update your details,change your password, see all quotes request, quotes submitted and orders won.
						</p>
						<p style='line-height: 1.5;margin-bottom: 25px;'>
							All quote requests, quotes submitted, orders and tax invoice requests can be viewed in the List View tab in the main menu.
						</p>
						If you have any questions, please contact FinQuote on {$this->query_number} or email <a href='mailto:{$this->query_mail}'>{$this->query_mail}</a>";

                    $content .= "
						<p style='line-height: 1.5'>
							<br><br>
							Kind Regards,
							<br />
							<b>".$data['company']['company_name']."</b>
						</p>";
                    //echo $content;
                    //	echo $from_email."--".$from_name."--".$to;exit;
                    if(($upass_status) && is_null($is_status_changed))
                    {
                        $this->send_templated_email ($from_email, $from_name, $to, $subject, $content, $file = "");
                        $msg = "<div style='font-size: 0.8em; margin-bottom: 10px; padding: 10px; color: #3c763d; border-radius: 3px; border: 1px solid #d6e9c6; background-color: #b5e491;'><strong>Success</strong> Account Confirmed! Login With Your Account.</div>";
                    }
                    else
                    {
                        $msg = "<div style='font-size: 0.8em; margin-bottom: 10px; padding: 10px; color: #E85454; border-radius: 3px; border: 1px solid #E45D5D; background-color: #F9D9D9;'>Something Went Wrong!</div>";
                    }
                    $this->session->set_flashdata('message',$msg);
                }
                else
                {

                }
            }
            else {	}

        }
        else {  }
        redirect(site_url()."/login");
    }
    public function confirmtender($lead_id)
    {
        if($lead_id != '')
        {

            $lead = $this->lead_model->get_lead($lead_id);
            $cq_number = 'FQ'.str_pad($lead['id_fq_account'], 5, '0',STR_PAD_LEFT);
            ///print_r($lead);


            $query_lead_de = "SELECT * FROM fq_lead_dealer_data  WHERE fq_lead_id = '".$lead_id."' LIMIT 1";
            $result_lead_de = $this->db->query($query_lead_de);
            if (count($result_lead_de)==0)
            {
                $del_postcode = "N/A"; 
            }
            else
            {
                foreach ($result_lead_de->result() as $row_lead)
                {
                    $del_postcode = $row_lead->postcode;					
                }
            }

            $query = "SELECT * FROM `rb_data`  WHERE car_id = '".$lead['rb_data']."' LIMIT 1";
            $result = $this->db->query($query);
            if (count($result)==0)
            {
                $car_name = "N/A"; 
                $car_price = "N/A"; 
                $car_year = "N/A"; 			
                $car_desc = "N/A"; 
            }
            else
            {
                $fapplication_note = '';			
                foreach ($result->result() as $row)
                {
                    $data[] = date("M Y",strtotime("22-".$row->month."-".$row->year));
                    $des = unserialize( $row->des);
                    $data[] = implode(", ",$des);

                    $car_name = $row->name;
                    $car_price = $row->price;
                    $car_year = date("M Y",strtotime("22-".$row->month."-".$row->year));		
                    $car_desc = implode('</li><li style="margin-left: -20px;">',$des); 
                }
            }

            $client_subject = "You New Car Tender Has Started Successfully";
            $client_content="<p style='line-height: 1.5;text-align:center'><b>Thank you, Your new vehicle details have been confirmed.</b></p>
							<p style='line-height: 1.5;text-align:center'>You are one step closer to your new car<p>
							<p style='line-height: 1.5;text-align:center'>Multiple Dealers have now been sent a request to quote on your new vehicle<p>
							<p style='line-height: 1.5;text-align:center'>Please ensure you are available throughout the day for updates from your assigned consultant<p>
							<p style='line-height: 1.5;text-align:center'>Good luck and we hope to have you in your new car very soon<p>";
            $data = $this->data;
            $from_email = $data['company']['company_email'];
            $from_name = $data['company']['company_name'];
            $to =   $lead['lead_email'];
            $this->send_templated_email ($from_email, $from_name, $to, $client_subject, $client_content, $file = "");


            $to =   $lead['qs_email'];			
            $subject = "Quote Request - ".$cq_number;		
            $content = '
				<center>
					<h1 style="font-size: 25px;">Quote Request</h1>
					<h2 style="font-size: 17px;">'.$cq_number.'</h2>
				</center>
				<p>Hi '.$lead['qs_name'].'</p>
				<p style="line-height: 1.5">
					We are currently in the process of taking a new vehicle order and you have been invited to submit a quote for supply. Please be as aggressive as you can, should you be successful a purchase order will be sent to you via email and listed in your FinQuote Dealer account.</p>
				<p style="line-height: 1.5">
					Please <a href="'.site_url("Process/submitquote/{$lead_id}").'" >click here</a> to submit your quote
				</p>
				<p style="line-height: 1.5">Vehicle details as follows:		</p>
				<ul>
					<li style="margin-left: -20px;">'.$car_name.'</li>
					<li style="margin-left: -20px;">'.$car_year.'</li>
					<li style="margin-left: -20px;">'.$car_desc.'</li>
				</ul>
				<p style="line-height: 1.5">
					Factory Options and Dealer Fitted Accessories
				</p>
				<ul>';
            $qro_query = "
					SELECT if (o.items <> '', CONCAT(o.name, ' (', o.items, ')'), o.name) as `option`
					FROM quote_request_options qro
					JOIN options o ON qro.fk_option = o.id_option
					WHERE qro.fk_quote_request = '".$lead['id_quote_request']."' AND qro.deprecated <> 1";
            $qro_result = $this->db->query($qro_query);
            if ($qro_result->result()<>0)
            {
                foreach ($qro_result->result() as $qro_row)
                {
                    $content .= '<li style="margin-left: -20px;">'.$qro_row->option.'</li>';
                }					
            }
            $qra_query = "
					SELECT name, description
					FROM quote_request_accessories
					WHERE fk_quote_request = '".$lead['id_quote_request']."' AND deprecated <> 1";
            $qra_result = $this->db->query($qra_query);
            if ($qra_result->result()<>0)
            {
                foreach ($qra_result->result() as $qra_row)
                {
                    $content .= '<li style="margin-left: -20px;">'.$qra_row->name.'</li>';
                }					
            }
            $content .= '
				</ul>
				<p style="line-height: 1.5">
					Registration: '.$lead['registration_type'].'
				</p>	
				<p style="line-height: 1.5">
					Delivery to Postcode: '.$del_postcode.' 
				</p>	
				<p style="line-height: 1.5">
					Thanks &amp; Regards,
				</p>';
            //echo $content;
            $this->send_templated_email ($from_email, $from_name, $to, $subject, $content, $file = "");
            $msg = "<div style='font-size: 0.8em; margin-bottom: 10px; padding: 10px; color: #3c763d; border-radius: 3px; border: 1px solid #d6e9c6; background-color: #b5e491;'><strong>Thank You</strong> we hope to have you in your new car very soon.</div>";
            $this->session->set_flashdata('message',$msg);

        }
        else {  }

        redirect(site_url()."/login");
    }
    public function submitquote($lead_id)
    {
        if($lead_id != '')
        {
            if($_POST)
            {
                /*echo $lead_id;
				echo '<pre>';print_r($_POST);
				exit;*/
                $lead = $this->lead_model->get_lead($lead_id);
                $cq_number = 'FQ'.str_pad($lead['id_fq_account'], 5, '0',STR_PAD_LEFT);
                //echo '<pre>';print_r($lead);exit;
                $delivery_post_code = $_POST['delivery_post_code'];
                $delivery_date= $_POST['delivery_date'];
                $final_price= $_POST['final_price'];
                $delivery_notes= $_POST['delivery_notes'];

                $query = "UPDATE fq_lead_dealer_data SET  postcode='".$delivery_post_code."',delivery_date='".$delivery_date."',winning_quote='".$final_price."',delivery_notes='".$delivery_notes."'  WHERE fq_lead_id = ".$lead_id;
                $this->db->query($query);

                $notification_message = "New Quote Request confirm : <a  class='open-fapplication-details' href='".site_url("fapplication/list_view")."'>{$cq_number}</a>";

                $this->notification_model->add_notification(1, $notification_message);
                $notification_id = $this->db->insert_id();
                $this->notification_model->add_notification_user($notification_id,$lead['qs_id']);

                redirect(site_url()."/login");
            }

            //echo '<pre>';
            $data = array();

            $lead = $this->lead_model->get_lead($lead_id);
            $lead['fq_number'] = 'FQ'.str_pad($lead['id_fq_account'], 5, '0',STR_PAD_LEFT);
            //print_r($lead);

            $data['lead'] = $lead ;
            $query_lead_de = "SELECT * FROM fq_lead_dealer_data  WHERE fq_lead_id = '".$lead_id."' LIMIT 1";
            $result_lead_de = $this->db->query($query_lead_de);
            $del_postcode ='';
            if (count($result_lead_de)==0)
            {
                $del_postcode = "N/A"; 
                $delivery_date = '';
                $delivery_notes	='';
            }
            else
            {
                foreach ($result_lead_de->result() as $row_lead)
                {
                    //print_r($row_lead);
                    $del_postcode = $row_lead->postcode;	
                    $delivery_date    = $row_lead->delivery_date;
                    $delivery_notes	= $row_lead->delivery_notes;				
                }
            }
            $data['delivery_date'] = $delivery_date;
            $data['delivery_notes'] = $delivery_notes;
            $data['del_postcode'] = $del_postcode;
            $data['option'] = array();
            $qro_query = "
					SELECT if (o.items <> '', CONCAT(o.name, ' (', o.items, ')'), o.name) as `option`
					FROM quote_request_options qro
					JOIN options o ON qro.fk_option = o.id_option
					WHERE qro.fk_quote_request = '".$lead['id_quote_request']."' AND qro.deprecated <> 1";
            $qro_result = $this->db->query($qro_query);
            if ($qro_result->result()<>0)
            {
                foreach ($qro_result->result() as $qro_row)
                {
                    $data['option'][] =  $qro_row->option;
                }					
            }
            $qra_query = "
					SELECT name, description
					FROM quote_request_accessories
					WHERE fk_quote_request = '".$lead['id_quote_request']."' AND deprecated <> 1";
            $qra_result = $this->db->query($qra_query);
            if ($qra_result->result()<>0)
            {
                foreach ($qra_result->result() as $qra_row)
                {
                    $data['option'][] =  $qra_row->name;
                }					
            }

            $query = "SELECT * FROM `rb_data`  WHERE car_id = '".$lead['rb_data']."' LIMIT 1";
            $result = $this->db->query($query);
            if (count($result)==0)
            {
                $data['car_name'] = "N/A"; 
                $data['car_price'] = "N/A"; 
                $data['car_year'] = "N/A"; 			
                $data['car_desc'] = "N/A"; 
            }
            else
            {
                $fapplication_note = '';			
                foreach ($result->result() as $row)
                {
                    $des = unserialize( $row->des);
                    $data['car_name'] = $row->name;
                    $data['car_price'] = $row->price;
                    $data['car_year'] = date("M Y",strtotime("22-".$row->month."-".$row->year));		
                    $data['car_desc'] = $des; 
                }
            }

            $this->load->view('quote_res', $data);
        }		
        else 
        { 
            redirect(site_url()."/login");
        }
        //redirect(site_url());
    }

    public function submitquote_dealer($lead_id, $dealer_id = 0){
        $lead = $this->lead_model->get_lead($lead_id);
        //echo '<pre>';print_r($lead);exit;
        if($lead_id != ''){
            // echo "post";
            if($this->input->post()){
                $dataInfo = array();
                $post_data = $this->input->post();

                $lead = $this->lead_model->get_lead($lead_id);
                $cq_number = 'FQ'.str_pad($lead['id_fq_account'], 5, '0',STR_PAD_LEFT);
                $now = date("Y-m-d g:i:s");		
                $insert_data = array(
                    'fk_quote_request' => $this->db->escape_str($post_data['id_quote_request']),
                    'fk_user' => $dealer_id,
                    'status' => 1,
                    'sender' => 'Dealer',
                    'transport_checkbox' => '',
                    'on_road' => $this->db->escape_str($post_data['on_road']),
                    'delivery_date' => $this->db->escape_str($post_data['delivery_date']),
                    //'sender_new' => $this->db->escape_str($post_data['sender_new']),
                    'quoted_price' => $this->db->escape_str($post_data['quoted_price']),                                    
                );
               
                $funded_id_quote = $this->fapplication_model->get_column_value_by_id('quotes','id_quote',$insert_data);
                if (isset($funded_id_quote) && !empty($funded_id_quote)) {
                    $this->session->set_flashdata('success',false);
                    $this->session->set_flashdata('message','Duplicate Quote Submitted.');
                    redirect(site_url()."/Process/submitquote_dealer/".$lead_id."/".$dealer_id);
                }

                $insert_data['created_at'] = $now;
                $insert_data['dealer_notes'] = $this->db->escape_str($post_data['dealer_notes']);
                $insert_data['make'] = $lead['id_make'];
                $insert_data['modal'] = $lead['id_family'];
                $insert_data['rb_data'] = $lead['rb_data'];

                $result = $this->db->insert('quotes', $insert_data);
                if ($result){
                    $quote_id =  $this->db->insert_id();
                    if ($quote_id > 0 && isset($_FILES['quote_file'])) {
                        $file_element_name = 'quote_file';
                        $config['upload_path'] = './uploads/quote_files/';
                        $config['allowed_types'] = '*';
                        $config['overwrite'] = FALSE;
                        $config['encrypt_name'] = FALSE;
                        $config['remove_spaces'] = TRUE;
                        $newFileName = $_FILES['quote_file']['name'];
                        $tmp = explode('.', $newFileName);
                        $file_extension = end($tmp);
                        $filename = $quote_id."_".time().".".$file_extension;
                        $config['file_name'] = $filename;
                        if(!is_dir($config['upload_path'])){
                            mkdir($config['upload_path'],0777,TRUE);
                        }
                        $this->load->library('upload', $config);
                        if (!$this->upload->do_upload($file_element_name)){
                            $return['Uploaderror'] = $this->upload->display_errors();
                        }
                        $file_data = $this->upload->data();
                        if(!empty($file_data['file_name']) && !empty($file_extension)){
                            $this->db->where('id_quote', $quote_id);
                            $this->db->update('quotes', array('quote_file' => $file_data['file_name']));
                        }
                        @unlink($_FILES[$file_element_name]);
                        if (isset($_FILES['additional_file'])) {
                            $cpt = count($_FILES['additional_file']['name']);
                            $file_el_name = 'additional_file';
                            $files = $_FILES;
                            for($i=0; $i<$cpt; $i++){
                                $_FILES['additional_file']['name']=     $files['additional_file']['name'][$i];
                                $_FILES['additional_file']['type']= $files['additional_file']['type'][$i];
                                $_FILES['additional_file']['tmp_name']= $files['additional_file']['tmp_name'][$i];
                                $_FILES['additional_file']['error']= $files['additional_file']['error'][$i];
                                $_FILES['additional_file']['size']= $files['additional_file']['size'][$i];
                                $this->upload->initialize($this->set_upload_options($_FILES['additional_file']['name']));
                                if ($this->upload->do_upload($file_el_name)){
                                    $dataInfo_name = $this->upload->data();
                                    $dataInfo[] = $dataInfo_name['file_name'];
                                }//else{}
                                @unlink($_FILES[$file_el_name]);
                            }
                            $additional_files = implode(', ', $dataInfo);
                            if(!empty($dataInfo) && !empty($additional_files)){
                                $this->db->where('id_quote', $quote_id);
                                $this->db->update('quotes', array('additional_files' => $additional_files));
                            }
                        }
                        echo 'Yes Mail Sent here....1';
                        
                        $this->send_new_quote_request_mail($lead,$quote_id);
                       
                        /*$this->session->set_flashdata('success',true);
                        $this->session->set_flashdata('message','Quote Submitted Successfully..');
                        redirect(site_url()."/Process/submitquote_dealer/".$lead_id."/".$dealer_id);*/
                        redirect('/Process/thankyou_quote', 'refresh');
                    }

                }else{
                    return false;
                }

                $notification_message = "New Quote Request confirm : <a class='open-fapplication-details' href='".site_url("fapplication/list_view")."'>{$cq_number}</a>";
                $this->notification_model->add_notification(1, $notification_message);
                $notification_id = $this->db->insert_id();
                $this->notification_model->add_notification_user($notification_id,$lead['qs_id']);
                redirect("http://finquote.com.au/quotesubmitted");
            }
            //echo "string";
            // echo "string"; die();
            $data = array();

            $lead = $this->lead_model->get_lead($lead_id);
            $lead['fq_number'] = 'FQ'.str_pad($lead['id_fq_account'], 5, '0',STR_PAD_LEFT);
            //print_r($lead);

            $data['lead'] = $lead ;
            $query_lead_de = "SELECT * FROM fq_lead_dealer_data  WHERE fq_lead_id = '".$lead_id."' LIMIT 1";
            $result_lead_de = $this->db->query($query_lead_de);
            //echo '<pre>';print_r($result_lead_de->result());exit;
            $del_postcode ='';
            if (count($result_lead_de)==0){
                $del_postcode = "N/A"; 
                $delivery_date = '';
                $delivery_notes	='';
            }else{
                foreach ($result_lead_de->result() as $row_lead){
                    //print_r($row_lead);
                    $del_postcode = $row_lead->postcode;	
                    $delivery_date    = $row_lead->delivery_date;
                    $delivery_notes	= $row_lead->delivery_notes;				
                }
            }
            $data['delivery_date'] = $delivery_date;
            $data['delivery_notes'] = $delivery_notes;
            $data['del_postcode'] = $del_postcode;
            $data['option'] = array();
            $qro_query = "
					SELECT if (o.items <> '', CONCAT(o.name, ' (', o.items, ')'), o.name) as `option`
					FROM quote_request_options qro
					JOIN options o ON qro.fk_option = o.id_option
					WHERE qro.fk_quote_request = '".$lead['id_quote_request']."' AND qro.deprecated <> 1";
            $qro_result = $this->db->query($qro_query);
            if ($qro_result->result()<>0){
                foreach ($qro_result->result() as $qro_row){
                    $data['option'][] =  $qro_row->option;
                }					
            }
            $qra_query = "
					SELECT name, description
					FROM quote_request_accessories
					WHERE fk_quote_request = '".$lead['id_quote_request']."' AND deprecated <> 1";
            $qra_result = $this->db->query($qra_query);
            if ($qra_result->result()<>0){
                foreach ($qra_result->result() as $qra_row){
                    $data['option'][] =  $qra_row->name;
                }					
            }

            $query = "SELECT * FROM `rb_data`  WHERE car_id = '".$lead['rb_data']."' LIMIT 1";
            $result = $this->db->query($query);
            if (count($result)==0){
                $data['car_name'] = "N/A"; 
                $data['car_price'] = "N/A"; 
                $data['car_year'] = "N/A"; 			
                $data['car_desc'] = "N/A"; 
                $data['vehicle_detail'] = "N/A"; 

            }else{
                $fapplication_note = '';
                foreach ($result->result() as $row){
                    $des = unserialize( $row->des);
                    $data['car_name'] = $row->name;
                    $data['car_price'] = $row->price;
                    $data['car_year'] = date("M Y",strtotime("22-".$row->month."-".$row->year));		
                    $data['car_desc'] = $des;
                    $data['vehicle_detail'] = implode(', ', $des);
                }
            }
            //echo '<pre>';print_r($data);exit;
            $this->load->view('quote_res_dealer',$data);
        }else{
            redirect(site_url()."/login");
        }
    }

    public function send_new_quote_request_mail($lead,$quote_id){
        $data = $this->data;
        $quote_request = $this->user_model->getRow('quotes',array('id_quote' => $quote_id));

        $user_details = $this->user_model->get_dealer_for_email($quote_request->fk_user);
        //echo '<pre>';print_r($user_details);exit;

        $from_email = $user_details['dealer_email'];
        //$from_email = $data['company']['company_email'];

        $from_name = $data['company']['company_name'];
        $to = $lead['qs_email'];
        //$to = 'devakshay89@gmail.com';

        //$quote_data = $this->request_model->get_quote_request($quote_request_id);

        $file_name = isset($quote_request->quote_file) && !empty($quote_request->quote_file) ? $quote_request->quote_file : '';
        $additional_file = isset($quote_request->additional_files) && !empty($quote_request->additional_files) ? $quote_request->additional_files : '';

        $query = "SELECT * FROM `rb_data`  WHERE car_id = '".$lead['rb_data']."' LIMIT 1";
        $result = $this->db->query($query);
        if (count($result)==0){
            $car_name = "N/A"; 
            $car_price = "N/A"; 
            $car_year = "N/A"; 			
            $car_desc = "N/A";
        }else{
            $fapplication_note = '';
            foreach ($result->result() as $row)
            {
                $data[] = date("M Y",strtotime("22-".$row->month."-".$row->year));
                $des = unserialize($row->des);
                $data[] = implode(", ",$des);

                $car_name = $row->name;
                $car_price = $row->price;
                $car_year = date("M Y",strtotime("22-".$row->month."-".$row->year));
                $car_desc = implode(",",$des);
            }
        }

        $cq_number = 'FQ'.str_pad($lead['id_fq_account'], 5, '0',STR_PAD_LEFT);

        $delivery_date_time = date("d-m-Y", strtotime($quote_request->delivery_date));
        $onroad = isset($quote_request->on_road) ? ($quote_request->on_road == 1 ? 'Yes' : 'No') : '' ;
        $s = explode(" ",$lead['qs_name']);
        $content = '';
        //echo $content;exit;

        $content = '';
        $where_id = array('template_text' => 'new_quote_submitted','deprecated' => 0);
        $email_template = $this->fapplication_model->get_column_value_by_id('system_email_templates','content',$where_id);
        $content = $email_template;

        $content = str_replace("@@CQ_NUMBER@@",$cq_number,$content);
        $content = str_replace("@@ADMIN_NAME@@",$s[0],$content);
        $content = str_replace("@@DEALER_NAME@@",$user_details['dealer_name'],$content);
        $content = str_replace("@@TO_ACCOUNT@@",$lead['qs_name'],$content);
        $content = str_replace("@@QUOTED_PRICE@@",$quote_request->quoted_price,$content);
        $content = str_replace("@@DELIVERY_DATE_TIME@@",$delivery_date_time,$content);
        $content = str_replace("@@DEALER_NOTES@@",$quote_request->dealer_notes,$content);
        $content = str_replace("@@CAR_ONROAD@@",$onroad,$content);
        $content = str_replace("@@CAR_NAME@@",$car_name,$content);

        $subject = $data['company']['company_name']." - New Quote submitted - ".$car_name;
        date_default_timezone_set('Australia/Sydney');
        //ini_set('max_execution_time', -1);	

         $dealership_name = (isset($lead['dealership_name']) &&  $lead['dealership_name']!='')?$lead['dealership_name']:'Finquote';
          $dealer_email = (isset($lead['dealer_email']) &&  $lead['dealer_email']!='')?$lead['dealer_email']:'paul@finquote.net.au';
      //  echo $dealership_name = $lead['dealership_name'];
       // echo $dealer_email = $lead['dealer_email'];


        $now = date("Y-m-d H:i:s");
        //echo '<pre>';print_r($lead);
        //echo $content ;
       // exit;
        $config = array();
        $config['smtp_port']= "465";
        $config['mailtype'] = 'html';
        $config['charset']  = "utf-8";
        $config['newline']  = "\r\n";
        $config['smtp_timeout']='30';
        $config['wordwrap'] = TRUE;

        // for testing purposes only
        $config['smtp_host']= "ssl://smtp.gmail.com";
        $config['smtp_user']='_mainaccount@mynewcardiscount.com.au';
        $config['smtp_pass']='silent604';

        // load Email Library 
        $this->load->library('email');

        $this->email->clear();
        $this->email->initialize($config);

        $this->email->from($dealer_email, $dealership_name);
       
        $this->email->cc('paul@finquote.net.au', 'Finquote');
        $this->email->cc('devakshay89@gmail.com','devakshay');

        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($content);
        $attachment_url = array();
        if (trim($file_name) <> ""){
            $path = './uploads/quote_files/';
            $this->email->attach($path.$file_name);
            //echo $this->email->print_debugger();
            $attachment_url[].='uploads/quote_files/'.$file_name;
        }

        $result = array();
        if (trim($additional_file) <> ""){
            $file_array = explode(", ", $additional_file);
            //$path = './uploads/quote_files/';
            foreach ($file_array AS $file){
                if (trim($file) <> ""){
                    $file_name= $_SERVER["DOCUMENT_ROOT"].'/uploads/quote_files/'.$file;
                    $this->email->attach($file_name);
                    $attachment_url[].='uploads/quote_files/'.$file;
                }
            }
        }

        if($this->email->send()){
            //print_r();
            $attachment = isset($additional_file) && !empty($additional_file) ? $file_name.','.$additional_file : $file_name;
            $attachment_urls =  implode(",",$attachment_url);
            $trail_array = [
                'fk_user'    => $lead['qs_id'],
                'fk_account' => $lead['lead_id'],
                'sent_to'    => $to,
                'subject'    => $subject,
                'message'    => $content,
                'attachment' => $attachment,
                'attachment_url'   => $attachment_urls,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->fapplication_model->email_audit_trail_model($trail_array);
        }else{
            echo "error";
        }
        return true;
    }

    private function set_upload_options($filename){
        $config = array();
        $config['upload_path'] = './uploads/quote_files/';
        if(!is_dir($config['upload_path'])){
            mkdir($config['upload_path'],0777,TRUE);
        }
        $config['file_name'] = $filename;
        $config['allowed_types'] = '*';
        $config['overwrite'] = FALSE;
        $config['encrypt_name'] = FALSE;
        $config['remove_spaces'] = TRUE;
        $config['max_size']    = '2048';
        return $config;
    }
    public function post_instapage_data()
    {
        /*
        $name =  htmlspecialchars( $this->escape_str( $_REQUEST['name']));
        $email =htmlspecialchars( $this->escape_str( $_REQUEST['email']));
        $phone  =htmlspecialchars( $this->escape_str( $_REQUEST['phone']));
        $postcode   =htmlspecialchars( $this->escape_str( $_REQUEST['postcode']));
        $model  = htmlspecialchars($this->escape_str( $_REQUEST['model']));
        $finance    =htmlspecialchars( $this->escape_str( $_REQUEST['finance']));
		*/
			
        /*$_REQUEST = '{"page_id":"9483867","page_name":"TOYOTA Discounts","page_url":"newcardiscounts.finquote.com.au\/Toyota","variant":"Variation C","ip":"43.241.145.46","Select_Model":"RAV 4","Enter_Full_Name":"Aj Test v-c","Enter_Phone_Number":"6378290","Enter_Email_Address":"test@test.com","Enter_Postcode":"8577326","Looking_Finance":"No, I don\'t need finance","pageshown":"TOYOTA Discounts","variationshown":"Variation C","desktopmobile":"Desktop","timestamp":"29 October 2018 07:57 UTC","ipaddress":"43.241.145.46","referralsource":"http:\/\/newcardiscounts.finquote.com.au\/toyota"}';

        $_REQUEST = '{"page_id":"9483867","page_name":"TOYOTA Discounts","page_url":"newcardiscounts.finquote.com.au\/Toyota","variant":"Variation A","ip":"43.241.145.56","Select_Model":"Tarago","Enter_Full_Name":"Test AjA","Enter_Phone_Number":"0789123456","Enter_Email_Address":"test@tarago.com","Enter_Postcode":"078945","Select_Finance":"No, I don\'t need finance","pageshown":"TOYOTA Discounts","variationshown":"A","desktopmobile":"Desktop","timestamp":"29 October 2018 10:54 UTC","ipaddress":"43.241.145.56","referralsource":"http:\/\/newcardiscounts.finquote.com.au\/Toyota"}';

        $_REQUEST = json_decode($_REQUEST, true);*/

        $ip =htmlspecialchars( $this->escape_str( $_REQUEST['ip']));
        $page_id    =htmlspecialchars( $this->escape_str( $_REQUEST['page_id']));
        $page_url   =htmlspecialchars( $this->escape_str( $_REQUEST['page_url']));
        $page_name  =htmlspecialchars( $this->escape_str( $_REQUEST['page_name']));
        $variant    =htmlspecialchars( $this->escape_str( $_REQUEST['variant']));
        /* new */
        $name =  htmlspecialchars( $this->escape_str( $_REQUEST['Enter_Full_Name']));
        $email =htmlspecialchars( $this->escape_str( $_REQUEST['Enter_Email_Address']));
        $phone  =htmlspecialchars( $this->escape_str( $_REQUEST['Enter_Phone_Number']));
        $postcode   =htmlspecialchars( $this->escape_str( $_REQUEST['Enter_Postcode']));
        $model  = htmlspecialchars($this->escape_str( $_REQUEST['Select_Model']));
        if($variant == 'Variation A' || $variant == 'Variation A-mobile') {
            $finance =htmlspecialchars( $this->escape_str( $_REQUEST['Select_Finance']));
        }
        else {
			if(isset($_REQUEST['Select_Finance'])){
            $finance =htmlspecialchars( $this->escape_str( $_REQUEST['Select_Finance']));
			}
			else{
			$finance =htmlspecialchars( $this->escape_str( $_REQUEST['Looking_Finance']));
			}
        }
        // $finance = stripslashes($finance);
        /* new */

        /* For check Response */
        $res = json_encode($_REQUEST);
        $myfile = fopen("newfile.txt", "a") or die("Unable to open file!");
        $txt = "Response \n".$res."\n";
        fwrite($myfile, $txt);
        $txt = "\n";
        fwrite($myfile, $txt);
        fclose($myfile);
        /* For check Response */

        $data = $this->data;


        $post_data = array();

        $post_data['lead_first_name'] = $name;
        $post_data['lead_last_name']= '';
        $post_data['lead_email']= $email;
        $post_data['lead_phone']= $phone;
        $post_data['lead_state']= '';
        $post_data['client_source']= '';
        $post_data['lead_state']= '';
        $post_data['postcode']= $postcode;
        $post_data['user'] = '259';
        $post_data['landing_page_url'] = $page_url;
        $post_data['landing_date_time'] = date("Y-m-d H:i:s");
        $post_data['finance'] = $finance;
        
        //$post_data['make'] = 29;
        //$post_data['family'] = 239;

        //$page_url = "newcardiscounts.finquote.com.au/toyota/landcruiser";
        $url_array = explode("/",$page_url);
        $make = (isset($url_array[1]) && $url_array[1]!='')?$url_array[1]:'';
        //$family = (isset($url_array[2]) && $url_array[2]!='')?$url_array[2]:'';
        $family = $model;

        $query = "
		SELECT m.name as `make`, f.name as `family`
		FROM makes m
		JOIN families f ON m.id_make = f.fk_make
		WHERE LOWER(m.name) LIKE '%".strtolower($make)."%' AND LOWER(f.name) LIKE '%".strtolower($family)."%'
		LIMIT 1";
        //WHERE m.id_make = 29 AND f.id_family = 239
        //WHERE m.id_make = '".$input_arr['make']."' AND f.id_family = '".$input_arr['family']."'

        /*$content = 'Run Done - '.$query;
		$send = $this->send_templated_email("devakshay89@gmail.com", $name, "devakshay89@gmail.com", "test zap", $content);
		if($send)
		{echo 'yes';}else{echo 'no';}exit;*/

        $result = $this->db->query($query);
        if (count($result->result())<>0) {
            foreach ($result->result() as $row) {
                $post_data['make'] = $row->make;
                $post_data['family'] = $row->family;
            }
        }
        else {
            $post_data['make'] = $make;
            $post_data['family'] = $family;
        }

        if($lead_id = $this->fapplication_model->create_new_calendar_item($post_data)) {
            
            $input_arr_fq_new = array(
                'fq_lead_id'		=> $lead_id ,
                'name'				=> $post_data['lead_first_name'],
                'number'			=> $post_data['lead_phone'],
                'email'				=> $post_data['lead_email'],
                'postcode'			=> $post_data['postcode'],
                'make'				=> $post_data['make'],
                'modal'				=> $post_data['family'],
                'landing_page_url'  => $post_data['landing_page_url'],
                'landing_date_time' => $post_data['landing_date_time'],
                'finance'			=> $post_data['finance'],
            );

            /*echo "<pre>";
            print_r($input_arr_fq_new);
            die();*/

            $lead_data = $this->fapplication_model->insert_update_fq_dealer_data($input_arr_fq_new,$lead_id) ;

        }

        $query_lead_de = "INSERT INTO post_instapage_data SET  
						lead_id = '".$lead_id."', 
						name = '".$name."', 
						email = '".$email."',
						phone = '".$phone."',
						postcode = '".$postcode."',
						ip = '".$ip."',
						page_id = '".$page_id."',
						page_url = '".$page_url."',
						model = '".$model."',
						finance = '".$finance."',
						variant = '".$variant."',
						page_name = '".$page_name."',
						qry = '".$make."/".$family."' ";


        //$content = json_encode($_REQUEST);
        /*$content = 'Run Done - '.$query."--".$query_lead_de;
		$send = $this->send_templated_email("devakshay89@gmail.com", $name, "devakshay89@gmail.com", "test zap", $content);
		if($send)
		{echo 'yes';}else{echo 'no';}*/

        $result_lead_de = $this->db->query($query_lead_de);

        return $res;
    }

    public function get_instapage_lead($lead_id)
    {
        $query = "select * from post_instapage_data where lead_id=".$lead_id;
        $result = $this->db->query($query);
        $res = $result->result();
        
        echo "<pre>";
        print_r($res);
        echo "</pre>";
    }

    public function testsendmail()
    {
        $content = '
		<p style="line-height: 1.5">
			Registration: '.$lead['registration_type'].'
		</p>	
		<p style="line-height: 1.5">
			The New Car Tender is to incorporate delivery to an address within postcode 2097 with a full tank of fuel and in immaculate condition. 
		</p>	
		<p style="line-height: 1.5">
			Fleet Claims / Fleet Number<br />
			<b>Internal use only</b><br />
		</p>
		<p style="line-height: 1.5">
			<a href="'.site_url("Process/confirmtender/{$lead_id}").'" style="background-color: #58c603;text-decoration: none;color: #fff;padding: 10px 25px;border-radius: 8px;" >Confirm Vehicle Details</a>
		</p>
		<p style="line-height: 1.5">
			Kind Regards, 
		</p>';
        $send = $this->send_templated_email("devakshay89@gmail.com","test 123", "devakshay89@gmail.com", "test zap", $content);
        if($send)
        {echo 'yes';}else{echo 'no';}
    }
    public function escape_str($str, $like = FALSE)
    {
        if (is_array($str))
        {
            foreach ($str as $key => $val)
            {
                $str[$key] = $this->escape_str($val, $like);
            }

            return $str;
        }

        /*if (function_exists('mysqli_real_escape_string') AND is_object($this->conn_id))
		{
			$str = mysqli_real_escape_string($this->conn_id, $str);
		}
		else
		{
			$str = addslashes($str);
		}*/
        $str = addslashes($str);
        // escape LIKE condition wildcards
        if ($like === TRUE)
        {
            $str = str_replace(array('%', '_'), array('\\%', '\\_'), $str);
        }

        return $str;
    }
    protected function send_templated_email ($from_email, $from_name, $to, $subject, $content, $file = "")
    {
        date_default_timezone_set('Australia/Sydney');
        ini_set('max_execution_time', -1);	
        $now = date("Y-m-d H:i:s");
        $complete_email = $this->email_header.$content.$this->email_footer;
        //echo $complete_email;exit;
        $this->load->library('email');
        $this->email->clear();
        $this->email->set_mailtype('html');
        $this->email->to($to);
        $this->email->from($from_email, $from_name);
        $this->email->subject($subject);
        $this->email->message($complete_email);

        $path_array = explode("[path]", $file);
        foreach ($path_array AS $path)
        {
            if (trim($path) <> "")
            {
                $this->email->attach($path);
            }			
        }

        if($this->email->send())
        {
            return 1 ;
        }else
        { 	return 0;
        }
    }

    public function download($fileName = NULL) {
        $this->load->helper('download');
        $data = file_get_contents(base_url('/assets/documents/'.$fileName));
        force_download($fileName, $data);
        redirect();        
    }

    public function valuation_inv(){
        $data = array();
        $this->load->view('add_valuation_dealer',$data);
    }

    public function send_new_quote_request_mail_test($lead_id,$quote_id){
        $lead = $this->lead_model->get_lead($lead_id);
        $data = $this->data;
        $quote_request = $this->user_model->getRow('quotes',array('id_quote' => $quote_id));

        $user_details = $this->user_model->get_dealer_for_email($quote_request->fk_user);
        //echo '<pre>';print_r($user_details);exit;
        //echo '<pre>';print_r($lead);exit;

        $from_email = $user_details['dealer_email'];
        //$from_email = $data['company']['company_email'];

        $from_name = $data['company']['company_name'];
        //$to = $lead['qs_email'];
        $to = 'devakshay89@gmail.com';

        //$quote_data = $this->request_model->get_quote_request($quote_request_id);

        $file_name = isset($quote_request->quote_file) && !empty($quote_request->quote_file) ? $quote_request->quote_file : '';
        $additional_file = isset($quote_request->additional_files) && !empty($quote_request->additional_files) ? $quote_request->additional_files : '';

        $query = "SELECT * FROM `rb_data`  WHERE car_id = '".$lead['rb_data']."' LIMIT 1";
        $result = $this->db->query($query);
        if (count($result)==0){
            $car_name = "N/A"; 
            $car_price = "N/A"; 
            $car_year = "N/A"; 			
            $car_desc = "N/A";
        }else{
            $fapplication_note = '';
            foreach ($result->result() as $row)
            {
                $data[] = date("M Y",strtotime("22-".$row->month."-".$row->year));
                $des = unserialize($row->des);
                $data[] = implode(", ",$des);

                $car_name = $row->name;
                $car_price = $row->price;
                $car_year = date("M Y",strtotime("22-".$row->month."-".$row->year));
                $car_desc = implode(",",$des);
            }
        }

        $cq_number = 'FQ'.str_pad($lead['id_fq_account'], 5, '0',STR_PAD_LEFT);

        $delivery_date_time = date("d-m-Y", strtotime($quote_request->delivery_date));
        $onroad = isset($quote_request->on_road) ? ($quote_request->on_road == 1 ? 'Yes' : 'No') : '';
        $s = explode(" ",$lead['qs_name']);
        //echo $content;exit;

        $content = '';
        $where_id = array('template_text' => 'new_quote_submitted','deprecated' => 0);
        $email_template = $this->fapplication_model->get_column_value_by_id('system_email_templates','content',$where_id);
        $content = $email_template;

        $content = str_replace("@@CQ_NUMBER@@",$cq_number,$content);
        $content = str_replace("@@ADMIN_NAME@@",$s[0],$content);
        $content = str_replace("@@DEALER_NAME@@",$user_details['dealer_name'],$content);
        $content = str_replace("@@TO_ACCOUNT@@",$lead['qs_name'],$content);
        $content = str_replace("@@QUOTED_PRICE@@",$quote_request->quoted_price,$content);
        $content = str_replace("@@DELIVERY_DATE_TIME@@",$delivery_date_time,$content);
        $content = str_replace("@@DEALER_NOTES@@",$quote_request->dealer_notes,$content);
        $content = str_replace("@@CAR_ONROAD@@",$onroad,$content);
        $content = str_replace("@@CAR_NAME@@",$car_name,$content);

        $subject = $data['company']['company_name']." - New Quote submitted - ".$car_name;
        date_default_timezone_set('Australia/Sydney');
        //ini_set('max_execution_time', -1);	
        $now = date("Y-m-d H:i:s");

        $config = array();
        $config['smtp_port']= "465";
        $config['mailtype'] = 'html';
        $config['charset']  = "utf-8";
        $config['newline']  = "\r\n";
        $config['smtp_timeout']='30';
        $config['wordwrap'] = TRUE;

        // for testing purposes only
        $config['smtp_host']= "ssl://smtp.gmail.com";
        $config['smtp_user']='_mainaccount@mynewcardiscount.com.au';
        $config['smtp_pass']='silent604';

        // load Email Library 
        $this->load->library('email');

        $this->email->clear();
        $this->email->initialize($config);
        $this->email->from('paul@finquote.net.au', 'Finquote');
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($content);

        $attachment_url = array();
        if (trim($file_name) <> ""){
            $path = './uploads/quote_files/';
            $this->email->attach($path.$file_name);
            //echo $this->email->print_debugger();
            $attachment_url[].='uploads/quote_files/'.$file_name;
        }

        $result = array();
        if (trim($additional_file) <> ""){
            $file_array = explode(", ", $additional_file);
            //$path = './uploads/quote_files/';
            foreach ($file_array AS $file){
                if (trim($file) <> ""){
                    $file_name= $_SERVER["DOCUMENT_ROOT"].'/uploads/quote_files/'.$file;
                    $this->email->attach($file_name);
                    $attachment_url[].='uploads/quote_files/'.$file;
                }
            }
        }

        if($this->email->send()){
            //print_r();
            $attachment = isset($additional_file) && !empty($additional_file) ? $file_name.', '.$additional_file : $file_name;
            $attachment_urls =  implode(",",$attachment_url);
            $trail_array = [
                'fk_user'    => $lead['qs_id'],
                'fk_account' => $lead['lead_id'],
                'sent_to'    => $to,
                'subject'    => $subject,
                'message'    => $content,
                'attachment' => $attachment,
                'attachment_url'  => $attachment_urls,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->fapplication_model->email_audit_trail_model($trail_array);
        }else{
            echo $this->email->print_debugger();
        }
        exit;
    }

    public function getRBdata() {
        //$this->load->helper('getrbdata');
        $input_arr = $this->input->post();

        $make = $input_arr['make'];
        $model = $input_arr['model'];
        
        if(isset($input_arr['car_id']) && !empty($input_arr['car_id'])){
            
            $car_id = $input_arr['car_id'];
        }
        //$year = $input_arr['year'];

        $cars_array = array();
        if($make !="" && $model!="") {
            $query = "SELECT * FROM rb_data WHERE make_id = '".$make."' AND model_id = '". $model."' ";
            $query .=" ORDER BY  name DESC ";
            $result = $this->db->query($query);

            foreach ($result->result() as $row) {
                $temp = array();
                $temp['car_id'] = $row->car_id; 
                $temp['name'] = $row->name; 
                $temp['price'] = $row->price; 
                $des = unserialize( $row->des);
                $temp['des'] = implode(" - ",$des);
                $cars_array[]  = $temp;
            }
        }

        $response = '';
        if(!empty($cars_array)) {
            $response .= '<option value="" >Select Specific Car </option>' ;
            foreach($cars_array as $value) {
                
                $selected = '';
                if (null !== $input_arr['car_id'] && !empty($input_arr['car_id'])) {
                    if ($input_arr['car_id'] == $value['car_id']){
                        $selected = ' selected';
                    }
                }
                
                $response .= '<option value="'.$value['car_id'].'" '.$selected.'>'.$value['name']." - ".$value['des']." - ".$value['price'].'</option>' ;
            }
        } else {
            $response .= '<option value="" >No Data Found</option>' ;
        }
        echo $response;
    }

    public function addClient_trade_valuation($lead_id, $slug_2) {
        
        $slug_2 = $this->encrypt->decode($slug_2);
        
        // echo $slug_2;exit;
        
        if(is_numeric($slug_2)){
            $tradeIn_id = $slug_2;
            $trade_row = $this->fapplication_model->get_data_row_by_id('tradein_new',array('id_tradein' => $tradeIn_id, 'id_leads' => $lead_id));
        }elseif($slug_2 == 'id_quote_request'){
            $tradeIn_id = null;
        }
        
        $return = array();
        if(isset($lead_id) && !empty($lead_id)) {

            if($this->input->post()){
                
                $post_data = $this->input->post();

                //echo '<pre>';print_r();exit;
                
                if(isset($post_data['images']) && !empty($post_data['images'])){

                    $images = json_decode($post_data['images'], true);
                    $images = implode(',', $images);
                    $post_data['images'] = str_replace(",",", ",$images);

                    // $post_data['images'] = str_replace(",",", ",$post_data['images']);
                }

                $post_data['id_leads'] = $lead_id;
                
                if(isset($tradeIn_id) && !empty($tradeIn_id)) {
                    $where_array = array('id_tradein' => $tradeIn_id);
                    $this->db->where($where_array);
                    $data_array = $post_data;

                    if($this->db->update('tradein_new', $data_array)) {
                        $return['sucess'] = 'Update';
                        //$this->session->set_flashdata('msg','Update');
                    }
                } else {
                    
                    if($this->db->insert('tradein_new', $post_data)) {
                        $return['insert_id'] = $this->db->insert_id();
                        $tradeIn_id = $this->db->insert_id();
                        $return['sucess'] = 'Insert';
                        //$this->session->set_flashdata('msg','Insert');
                    } else {
                        $return['error'] = 'NotIns';
                    }
                }
                //echo '<pre>';print_r($return);exit;
                if($return['sucess'] == 'Insert' || $return['sucess'] == 'Update'){

                    /*if(isset($_FILES['photos']) && !empty($_FILES['photos'])){
                        $uploadData = array();
                        $files = $_FILES;
                        $this->load->library('upload');
                        $cpt = count($_FILES['photos']['name']);

                        for($i=0; $i<$cpt; $i++) {
                            if(!empty($_FILES['photos']['name'][$i])){
                                //echo '111';
                                $_FILES['photos']['name']= $files['photos']['name'][$i];
                                $_FILES['photos']['type']= $files['photos']['type'][$i];
                                $_FILES['photos']['tmp_name']= $files['photos']['tmp_name'][$i];
                                $_FILES['photos']['error']= $files['photos']['error'][$i];
                                $_FILES['photos']['size']= $files['photos']['size'][$i];    

                                $this->upload->initialize($this->set_upload_options_multiple());

                                if($this->upload->do_upload('photos')){
                                    $fileData = $this->upload->data();
                                    $uploadData[$i]['file_name'] = $fileData['file_name'];
                                } else {
                                    $return['fileUpload'] = 'error';
                                    //$uploadData[] = $this->upload->display_errors();
                                }
                            }

                        }

                        if(!empty($uploadData)){
                            $photos_name = array_column($uploadData, 'file_name');
                            $photos_name = implode(", ", $photos_name);
                            if(!empty($photos_name)){
                                //echo $photos_name;
                                $where_array = array('id_tradein' => $tradeIn_id);
                                $this->db->where($where_array);
                                $this->db->update('tradein_new', array('images' => $photos_name)); 
                                $return['fileUpload'] = 'sucess';
                                //echo $this->db->last_query();
                            }
                        }
                        //echo '<pre>';print_r($array);exit;
                    }*/
                    
                    $this->send_mail_added_Client_trade_valuation($lead_id, $tradeIn_id);
                    
                    $this->session->set_flashdata('success','true');
                    //redirect(current_url(), 'refresh');
                    redirect('/Process/thankyou_tradein', 'refresh');

                } else {
                    redirect(current_url(), 'refresh');
                    $this->session->set_flashdata('success','false');
                }
            }
            
            $tradein_data = array();

            if(!empty($trade_row)) {
                $tradein_data['tradeins'] = $trade_row;
            }
            $tradein_data['makes'] = $this->fapplication_model->get_dropdown_data(array("code"=>1));
            $this->load->view('add_valuation_client', $tradein_data);
            
        } else {

            redirect('');

        }        
    }
    
    public function upload_img(){
        $this->load->library('uploader');
        
        //echo '<pre>';print_r($_FILES);exit;
            
            
        $data = $this->uploader->upload($_FILES['photos'], array(
            'limit' => 10, //Maximum Limit of files. {null, Number}
            'maxSize' => 10, //Maximum Size of files {null, Number(in MB's)}
            'extensions' => null, //Whitelist for file extension. {null, Array(ex: array('jpg', 'png'))}
            'required' => false, //Minimum one file is required for upload {Boolean}
            'uploadDir' => './uploads/tradein_cars/', //Upload directory {String}
            'title' => array('auto'), //New file name {null, String, Array} *please read documentation in README.md
            'removeFiles' => true, //Enable file exclusion {Boolean(extra for jQuery.filer), String($_POST field name containing json data with file names)}
            'perms' => null, //Uploaded file permisions {null, Number}
            'onCheck' => null, //A callback function name to be called by checking a file for errors (must return an array) | ($file) | Callback
            'onError' => null, //A callback function name to be called if an error occured (must return an array) | ($errors, $file) | Callback
            'onSuccess' => null, //A callback function name to be called if all files were successfully uploaded | ($files, $metas) | Callback
            'onUpload' => null, //A callback function name to be called if all files were successfully uploaded (must return an array) | ($file) | Callback
            'onComplete' => null, //A callback function name to be called when upload is complete | ($file) | Callback
            'onRemove' => 'onFilesRemoveCallback' //A callback function name to be called by removing files (must return an array) | ($removed_files) | Callback
        ));

        if($data['isComplete']){
            $files = $data['data'];
            //print_r($files);
            print json_encode($files);
        }

        if($data['hasErrors']){
            $errors = $data['errors'];
            //print_r($errors);            
            print json_encode($errors);
        }

        function onFilesRemoveCallback($removed_files){
            foreach($removed_files as $key=>$value){
                $file = './uploads/tradein_cars/' . $value;
                if(file_exists($file)){
                    unlink($file);
                }
            }

            return $removed_files;
        }
    }
    
    function remove_file(){
        if(isset($_POST['file'])){
            $file = './uploads/tradein_cars/' . $_POST['file'];
            echo $file;
            if(file_exists($file)){
                unlink($file);
            }
        }
    }
    
    //private function send_mail_added_Client_trade_valuation($lead_id, $tradeIn_id){
    public function send_mail_added_Client_trade_valuation($lead_id, $tradeIn_id) {
        
        $now = date("Y-m-d H:i:s");        
        $data = $this->data;
        
        $lead = $this->lead_model->get_lead($lead_id);        
        $trade_row = $this->fapplication_model->get_data_row_by_id('tradein_new',array('id_tradein' => $tradeIn_id, 'id_leads' => $lead_id));
        
        $client_name = $lead['lead_name'];
        $user_name = $lead['qs_name'];        
        $user_email = $lead['qs_email'];        
        $cq_number = 'FQ'.str_pad($lead['id_fq_account'], 5, '0',STR_PAD_LEFT);
        $car_name = $this->fapplication_model->get_column_value_by_id('rb_data', 'name', array('car_id' => $trade_row->rb_data));
        
        // $additional_note = $trade_row['additional_notes'];
        $additional_note = $trade_row->additional_notes;
        
        $where_id = array('id_email_template' => CLIENT_TRADE_SUBMITTED_MAIL_TEMPLATE, 'deprecated' => 0);
        $email_template = $this->fapplication_model->get_column_value_by_id('system_email_templates','content',$where_id);
        $content = $email_template;

        $content = str_replace("@@FQ_LEAD_NUMBER@@", $cq_number, $content);
        $content = str_replace("@@CLIENT_NAME@@", $client_name, $content);
        $content = str_replace("@@USER_NAME@@", $user_name, $content);        
        $content = str_replace("@@CAR_NAME@@", $car_name, $content);
        $content = str_replace("@@ADDITIONAL_NOTE@@", $additional_note, $content);

        $subject = $data['company']['company_name']." - New Tradein Details Added - ".$car_name;
        
        date_default_timezone_set('Australia/Sydney');
        ini_set('max_execution_time', -1);	
        
        $this->load->library('email');
        $this->email->clear(TRUE);
        $this->email->set_mailtype('html');
        $this->email->to($user_email);
        //$this->email->from($from_email, $from_name);
        $this->email->from('paul@staging-new.finquote.com.au', 'Finquote');
        $this->email->subject($subject);
        $this->email->message($content);
        
        if($this->email->send()){
            $trail_array = [
                'fk_user'    => $lead['id_user'],
                'fk_account' => $lead_id,
                'sent_to'    => $user_email,
                'subject'    => $subject,
                'message'    => $content,
                'created_at' => $now,
            ];
            $this->fapplication_model->email_audit_trail_model($trail_array);
            //echo "sucess";

        } else {
            //echo "error";
        }        
    }
    
    private function set_upload_options_multiple() {   
        //upload an image options
        $config = array();
        $config['upload_path'] = './uploads/tradein_cars/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['encrypt_name'] = TRUE;        
        $config['overwrite']     = FALSE;
        return $config;
    }
    
    function thankyou_tradein($parm = null){
        
        $data['from'] = $parm;
        
        $this->load->view('thankyou_tradein', $data);
    }

    function thankyou_quote($parm = null){
        
        $data = array();
        $this->load->view('thankyou_quote', $data);
    }

    public function addDealer_trade_valuation($lead_id, $tradeIn_id, $dealer_id){
        $now = date("Y-m-d H:i:s");
        $data = array();
        $return = array();
        if(isset($lead_id) && isset($tradeIn_id)) {
            //echo ''
            if($this->input->post()){
                
                $dealer_id = $this->encrypt->decode($dealer_id);
                
                if(empty($dealer_id) && $dealer_id == ''){
                    $this->session->set_flashdata('error', 'false');
                    $this->session->set_flashdata('msg', 'dealer_empty');
                    redirect(current_url(), 'refresh');
                }
                
                $input_arr = $this->input->post();
                
                //echo '<pre>';print_r($input_arr);exit;
                
                $input_arr['id_tradeIn'] = $tradeIn_id;
                $input_arr['dealer_id'] = $dealer_id;                
                $input_arr['value'] = $input_arr['trade_valuation'];        
                $input_arr['note'] = $input_arr['additional_notes'];        

                if ($input_arr['value'] <> "" AND $input_arr['value'] <> 0){
                    $query = "
                        INSERT INTO `trade_valuations` (fk_tradein, fk_user, dealer_id, code, status, value, note, deprecated, created_at)
                        VALUES (
                            '".$input_arr['id_tradeIn']."', 
                            '".$user_id."',
                            '".$input_arr['dealer_id']."', 
                            MD5(CONCAT('".$input_arr['id_tradeIn']."', '-', '".$input_arr['dealer_id']."')),
                            0,
                            '".$this->db->escape_str($input_arr['value'])."',
                            '".$this->db->escape_str($input_arr['note'])."',
                            0,
                            '".$now."'
                        )
                        ON DUPLICATE KEY UPDATE
                        value = '".$this->db->escape_str($input_arr['value'])."'";
                    $insert_trade_valuation_result =  $this->db->query($query);
                }

                if ($insert_trade_valuation_result) {
                    $valuation_id = $this->db->insert_id();
                    $return['sucess'] = 'Insert';
                    
                } else {
                    $return['error'] = 'NotIns';
                    //$this->session->set_flashdata('msg', $this->db->last_query());
                }
                //echo '<pre>';print_r($return);exit;
                if($return['sucess'] == 'Insert'){
                    
                    $this->send_mail_added_Dealer_trade_valuation($lead_id, $tradeIn_id , $input_arr['value'], $dealer_id);
                    
                    $this->session->set_flashdata('success','true');
                    //redirect('/Process/thankyou_tradein_dealer', 'refresh');                    
                    redirect(base_url().'Process/thankyou_tradein/dealer', 'refresh');

                } else {
                    
                    $this->session->set_flashdata('error', 'false');
                    redirect(current_url(), 'refresh');

                }
            }

            $trade_row = $this->fapplication_model->get_data_row_by_id('tradein_new',array('id_leads' => $lead_id,'id_tradein' => $tradeIn_id,'parent_id' => null));

            if(!empty($trade_row)) {

                //echo '<pre>';print_r($trade_row);exit;
                $tradein_data['makes'] = $this->fapplication_model->get_dropdown_data(array("code"=>1));
                
                $rb_data_img = $this->user_model->get_id_by_val('rb_data','img','car_id',$trade_row->rb_data);
                //echo $rb_data_img;exit;
                $trade_row->rb_data_img = str_replace("?width=150","",trim($rb_data_img));
                
                $tradein_data['tradeins'] = $trade_row;
                $data = array();
                
                $this->load->view('add_valuation_dealer', $tradein_data);

            } else {

                redirect('');
            }

        } else {

            redirect('');

        } 
    }
    
    public function send_mail_added_Dealer_trade_valuation($lead_id, $tradeIn_id, $value, $dealer_id) {

        $now = date("Y-m-d H:i:s");        
        $data = $this->data;

        $lead = $this->lead_model->get_lead($lead_id);        
        $trade_row = $this->fapplication_model->get_data_row_by_id('tradein_new',array('id_tradein' => $tradeIn_id, 'id_leads' => $lead_id));

        $client_name = $lead['lead_name'];
        $user_name = $lead['qs_name'];        
        
        $user_email = $lead['qs_email'];
        
        $cq_number = 'FQ'.str_pad($lead['id_fq_account'], 5, '0',STR_PAD_LEFT);
        
        $car_name = $this->fapplication_model->get_column_value_by_id('rb_data', 'name', array('car_id' => $trade_row->rb_data));
        
        $dealer_name = $this->fapplication_model->get_column_value_by_id('users', 'name', array('id_user' => $dealer_id));


        $where_id = array('id_email_template' => DEALER_TRADE_SUBMITTED_MAIL_TEMPLATE, 'deprecated' => 0);
        $email_template = $this->fapplication_model->get_column_value_by_id('system_email_templates','content',$where_id);
        $content = $email_template;

        $content = str_replace("@@CQ_NUMBER@@", $cq_number, $content);
        $content = str_replace("@@TO_CLIENT@@", $client_name, $content);
        $content = str_replace("@@USER_NAME@@", $user_name, $content);        
        $content = str_replace("@@CAR_NAME@@", $car_name, $content);
        
        $content = str_replace("@@DEALER_NAME@@", $dealer_name, $content);
        $content = str_replace("@@VALUATION@@", $value, $content);

        $subject = $data['company']['company_name']." - New Valuation Submitted - ".$car_name;

        date_default_timezone_set('Australia/Sydney');
        ini_set('max_execution_time', -1);	

        $this->load->library('email');
        $this->email->clear(TRUE);
        $this->email->set_mailtype('html');
        $this->email->to($user_email);
        //$this->email->from($from_email, $from_name);
        $this->email->from('paul@staging-new.finquote.com.au', 'Finquote');
        $this->email->subject($subject);
        $this->email->message($content);

        if($this->email->send()) {
            $trail_array = [
                'fk_user'    => $lead['id_user'],
                'fk_account' => $lead_id,
                'sent_to'    => $user_email,
                'subject'    => $subject,
                'message'    => $content,
                'created_at' => $now,
            ];
            $this->fapplication_model->email_audit_trail_model($trail_array);
            //echo "sucess";

        } else {
            //echo "error";
        }        
    }


}
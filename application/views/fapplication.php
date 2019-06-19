<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set('max_execution_time', 600);
//require_once('simple_html_dom.php');
require_once('admin_main.php');
require_once("./application/libraries/PDFMerger/PDFMerger.php");
require_once("./application/libraries/PDFMerger/fpdf/fpdf.php");
require_once("./application/libraries/PDFMerger/fpdi/fpdi.php");
class Fapplication extends Admin_main 
{
    private $fq_email_header = '<html xmlns="http://www.w3.org/1999/xhtml">
					<head>
						<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
						<meta name="generator" content="HTML Tidy for Linux/x86 (vers 25 March 2009), see www.w3.org">
						<title>DealQuote | Finquote</title>
					</head>
					<body style="background: #ffffff; font-family: Verdana, Geneva, sans-serif; font-size: 14px; border: 1px solid #d8d8d8; padding: 0px">
						<style>
							p {
								line-height: 1.5;
							}
						</style>					
						<table style="border-spacing: 0px" bgcolor="#ffffff" width="100%" cellspacing="0" cellpadding="0">
							<tbody>
								<tr>
									
								</tr>
								<tr>
							<td align="left" style="padding: 15px 30px 15px 30px; color: #484848;">';

							/*
							<td valign="middle" align="right">
										<a href="http://www.finquote.com.au/" rilt="Header_Logo" target="_blank" style="text-decoration: none;">
											<img src="http://www.finquote.com.au/img/logo_40.png" width="300px;" style="margin-right: 15px; margin-top: 15px"><br />
										</a>
										
									</td>
									
									<p style="display:none;background: #58C603; color: #ffffff; padding: 3px 15px; font-size: 1.0em; color: #ffffff; margin-top: 5px; margin-bottom: 20px;">
											<b>Quotes Hotline | ‎02 9195 2853 | <a href="mailto:info@finquote.net.au"><span style="color: #ffffff; text-decoration: none;">info</span><span style="color: #ffffff; text-decoration: none;">@finquote.net.au</span></a></b>
										</p>*/
	private $fq_email_footer = '</td>
								</tr>
								<tr>
									<td align="center">
										<br /><br /><br />
										<hr style="border: solid 1px #d8d8d8; border-top: 0px;">
										<p style="font-size: 0.8em; font-family: Verdana, Geneva, sans-serif;">
											 | 
											 | 
											 | 
											 <br />
											Ph:  | 
											Skype:  | 
											
										</p>
									</td>
								</tr>
							</tbody>
						</table>
					</body>
				</html>';
	private $fq_email_signature_bkp = '<table style="padding:10px 0 10px 0px;margin-bottom:5px;border:none">
									<tbody>
										<tr>
											<td style="border-left:3px solid #e8e8e8;padding:7px 0 0 10px">
												<div>
													<strong>Paul Rouse</strong>
												</div>
												<div style="margin-bottom: 11px;">
													Vehicle Sourcing & Finance Specialist
												</div>
												<div style="margin-bottom: 11px;">
													<a href="mailto:paul@finquote.net.au" style="text-decoration:none;color:#134865" rel="nofollow" target="_blank">
													paul@finquote.net.au
													</a> | 1300 073 065 | <a>0403 919 995</a>
												</div>
												<div>
													Finquote  | 
													<a href="http://www.finquote.com.au/" style="text-decoration:none;color:#134865" rel="nofollow" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=en&amp;q=http://www.finquote.com.au&amp;source=gmail&amp;ust=1491360851728000&amp;usg=AFQjCNG7uCnf20UwVGVFwz2EUzox671UeA">
														www.finquote.com.au
													</a>
												</div>
												<div style="margin-bottom: 11px;">
													Suite 3 Level 27 Governor Macquarie Tower<br>1 Farrer Place Sydney NSW 2000
												</div>
												&nbsp;
												&nbsp;
												<a href="https://www.facebook.com/finquote" rel="nofollow" target="_blank" style="color: #fff">
													<img src="https://ci4.googleusercontent.com/proxy/N47dx11WPY-0EhITwjqxDikUZapea_MU1_OiVLrejWYBLn9I4kcBD8quvkz6RyaQL4kMCXznDmP1gxdqJeIrfP92m-TWqGQpzMkEmcAdRzu2xwxvCRM=s0-d-e1-ft#http://storage.googleapis.com/signaturesatori/icons/facebook.png">
												</a>
												&nbsp;
												<a href="https://plus.google.com/b/100924488307997759997/100924488307997759997" rel="nofollow" target="_blank" style="color: #fff">
													<img src="https://ci5.googleusercontent.com/proxy/pb4o14ow7M7bjhapf3e-93pnRlQixFbPgY_jCZ2KOrSw21LeUwLS7vQfMVGeLJ9WK9IyKTXgqkLDgEMal39Sea0ZTiLF6-iZ5AJt_HZWlqbRMk_F7lnmmg=s0-d-e1-ft#http://storage.googleapis.com/signaturesatori/icons/googleplus.png">
												</a>
												&nbsp;
												<a rel="nofollow" style="color: #fff" href="https://www.linkedin.com/company-beta/6631443/" target="_blank">
													<img src="https://ci3.googleusercontent.com/proxy/F6yDmYObpbe_nsYsuVRbfDMANRT1x8QFmqfsnUovijVwBvRQg_Hnxcn38Tqwfho1qkqnzIhAQkr-Vw5JPwdD2C42M5FY7YZf4hshr9-yVHDIe99tCMg=s0-d-e1-ft#http://storage.googleapis.com/signaturesatori/icons/linkedin.png">
												</a>
											</td>
										</tr>
									</tbody>
								</table>';
	private $fq_email_signature = '<p><span style="font-size:14px;font-family:Calibri,Verdana,Geneva,sans-serif;">Kind Regards,</span></p>

	<table border="0">
		<tbody>
			<tr>
				<td rowspan="3">
				<p><img src="http://staging-new.finquote.com.au/assets/img/signature_logo.png" /></p>
				</td>
				<td>
				<table>
					<tbody>
						<tr>
							<td>
							<div style="padding-left: 10px;margin:0px; text-align:start; -webkit-text-stroke-width:0px"><span style="font-size:14px;font-family:Calibri,Verdana,Geneva,sans-serif;"><b><span style="color:#969696">Paul Rouse</span></b> </span></div>
							</td>
						</tr>
						<tr>
							<td>
							<div style="padding-left: 10px;font-size:14px;margin:0px; text-align:start; -webkit-text-stroke-width:0px"><span style="font-size:14px;font-family:Calibri,Verdana,Geneva,sans-serif;"><b><span style="color:#969696">FIN</span></b><b><span style="color:#16C40E">QUOTE</span></b></span></div>
							</td>
						</tr>
						<tr>
							<td>
							<div style="padding-left: 10px;font-size:14px;margin:0px; text-align:start; -webkit-text-stroke-width:0px"><span style="font-size:14px;font-family:Calibri,Verdana,Geneva,sans-serif;"><span style="color:#969696">Office 1300 221 466 | Direct 02 9984 9126 | Mobile 0403 919 995</span></span></div>
							</td>
						</tr>
					</tbody>
				</table>
				</td>
			</tr>
		</tbody>
	</table>';
	
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{	
		header("Location: " . site_url('fapplication/list_view'));exit();
	}
	public function new_record () // PAGE VIEW (VIEW FILE IS PENDING)
	{
		$data = $this->data;
		$data['title'] = 'FinQuote Applications - Create New';
		$this->load->view('admin/fapplication_form', $data);
	}
	
	public function add_record () // PAGE ACTION (INSERT QUERY IS PENDING) 
	{
		$data = $this->data;
		$input_arr = $this->input->post();
		if (!$this->input->post())
		{
			header ("Location: ".site_url('fapplication/new_record'));
			exit ();
		}
		$input_arr['user_id'] = $data['user_id'];
		$this->fapplication_model->add_record($input_arr);
		header ("Location: ".site_url('fapplication/list_view'));exit();
	}

	public function list_view ($start = 0) // PAGE VIEW (LV) (DONE)
	{		
		$lead_id_arr = [];
		$data = $this->data;
		$data['title'] = 'Leads - List View';
        
		$limit = 50;
		$data['fapplications'] = $this->fapplication_model->get_records($_GET, $data['user_id'],$data['admin_type'], $start, $limit); // Main Query
		$count_result = $this->fapplication_model->get_leads_count($_GET, $data['user_id'], $data['admin_type']);  // Record count
		$data['leads'] = $this->fapplication_model->get_leads($_GET, $data['user_id'], $data['admin_type'], $start, $limit); // Main Query
		
		//print_r($count_result );
		//print_r($data['leads']);
	
		//echo json_encode($data['leads']); die();
		$data['lead_sources'] = $this->fapplication_model->get_lead_sources(); // Lead Sources
		$data['rl_admins'] = $this->user_model->get_admins($data['user_id']); // Quote Specialists for Reallocation
		$data['ticket_types'] = $this->ticket_model->get_ticket_types(); // Ticket Types
		$data['modules'] = $this->ticket_model->get_modules(); // Modules
		$data['makes_row'] = $this->fapplication_model->get_dropdown_data(array("code"=>1));
		$data['admin_flag'] = $this->fapplication_model->get_fq_admin_flag($data['user_id']);
			$data['email_templates'] = $this->fapplication_model->get_email_templates($data['user_id']);
			$data['system_email_templates'] = $this->fapplication_model->get_system_email_templates($data['user_id']);
        
		//echo json_encode($data); die();
		$current_date = date('Y-m-d');
		$current_month = date('m');
		$current_year = date('Y');
		
		if ($current_month==1)
		{
			$last_month = 12;
			$last_month_year = $current_year - 1;
		}
		else
		{
			$last_month = $current_month - 1;
			$last_month_year = $current_year;
		}
		
		$current_date_f = new DateTime($current_date);
		$current_week_number = $current_date_f->format("W");
		
		$dto = new DateTime();
		$dto->setISODate($current_year, $current_week_number);
		$week_start = $dto->format('Y-m-d');
		$dto->modify('+6 days');
		$week_end = $dto->format('Y-m-d');
		
		$_GET['week_start'] = $week_start;
		$_GET['week_end'] = $week_end;
		$_GET['current_date'] = $current_date;
		$_GET['current_year'] = $current_year;
		$_GET['current_month'] = $current_month;
		$_GET['last_month'] = $last_month;
		$_GET['last_month_year'] = $last_month_year;
		$data['leads_summary'] = $this->fapplication_model->get_leads_summary_main($_GET, $data['user_id'], $data['admin_type']); // Summary		
		/*echo "<pre>";
		print_r($_GET);
		exit;*/

		$this->load->library('pagination');
		$config['base_url'] = site_url('fapplication/list_view/'); 
		$config['total_rows'] = $count_result['cnt'];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);
		$data['links'] = $this->pagination->create_links();
		$data['export_url'] = $this->substring_index($this->substring_index($data['links'], '">2</a></li>', 1), 'list_view/50?', -1);
		$data['session_data'] = $this->data;
		$data['result_count'] = $count_result['cnt'];
		
		foreach ($data['leads'] as $key => $value) 
		{
			$attachment_flag = 0;
			$attachment_flag = $this->fapplication_model->get_attachment_flag($value['id_fq_account']);
			$data['leads'][$key]['attachment_flag'] = $attachment_flag;
			
			$data['leads'][$key]['get_fq_dealer_data'] = $this->fapplication_model->get_fq_dealer_data($value['id_fq_account']);
		}
		$first_flag = 0;
		$get_count = 0;
		if ($this->session->userdata('chkbx_overall_flag') !== FALSE)
		{
			$first_flag = $this->session->userdata('chkbx_overall_flag');
		}
		if (count($_GET) > 0)
		{
			foreach ($_GET as $g_key => $g_val) 
			{
				if (empty($g_val))
				{
					unset($_GET[$g_key]);
				}
			}
			if ($this->session->userdata('get_count') !== FALSE)
			{
				$get_count = $this->session->userdata('get_count');
			}
			if ($get_count != count($_GET))
			{
				$first_flag = 0;
				$this->session->set_userdata('chkbx_flag', 0);
			}
			if ($first_flag == 0)
			{
				$arr = ($this->session->userdata('chkbx_ids') !== FALSE) ? $this->session->userdata('chkbx_ids') : array();
				foreach ($arr as $key => $val) 
				{
					if (!in_array($val, $lead_id_arr))
					{
						unset($arr[$key]);
					}
				}
				$this->session->set_userdata('chkbx_ids', $arr);
				$first_flag = 1;
			}
			$this->session->set_userdata('get_count', count($_GET));
		}
		$data['payment_types'] = $this->payment_model->get_payment_types();
		$data['bank_accounts'] = $this->settings_model->get_bank_accounts();
		$emailtemplate_query = "SELECT * FROM email_template ORDER BY id_email_template ASC";
		$emailtemplate_sql = $this->db->query($emailtemplate_query);
		$data['email_template'] =  $emailtemplate_sql->result();
			
		
		$this->load->view('admin/fapplications', $data);
	}
    
    function pagination_test(){
        $total_rows = $this->fapplication_model->record_count();
        echo '<pre>';print_r($this->db->last_query());exit;
        $this->load->library("pagination");
        $config = array();
        $config["base_url"] = base_url() . "index.php/fapplication/pagination_test";
        $config["total_rows"] = $this->fapplication_model->record_count();
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["results"] = $this->fapplication_model->get_historical_quotes($config["per_page"], $page);
        //echo '<pre>';print_r($total_rows);exit;
        $data["links"] = $this->pagination->create_links();
        $this->load->view("pagination", $data);
    }
    
    function version_get(){
        echo CI_VERSION; 
    }
    
    function redbook_data_datatable(){
        //echo '<pre>';print_r($_POST);exit;
        $fapplication_id = $_POST['fapplication_id'];
        $id_rbdata = $_POST['id_rbdata'];
				$id_make = $_POST['id_make'];
				$id_modal = $_POST['id_modal'];
        //$config['table'] = 'quotes qu';
        $config['table'] = 'quote_requests qr';
				$config['select'] = "qu.id_quote, qu.quote_file, rb.name AS car_name, fa.id_fq_account as fq_number";
				$config['select'] .= ", qu.quoted_price, u.id_user, u.name AS dealer, u.state, qu.dealer_notes, qu.car_off_road, qu.on_road, qu.delivery_date_time";
				$config['select'] .= ", qr.winner, GROUP_CONCAT(qra.name) AS accessories";
		
				$config['joins'][] = array('join_table' => 'fq_accounts_new fa', 'join_by' => 'fa.id_fq_account = qr.fk_lead', 'join_type' => 'left');
				
				$config['joins'][] = array('join_table' => 'quotes qu', 'join_by' => 'qu.fk_quote_request = qr.id_quote_request', 'join_type' => 'left');
        
        //$config['joins'][] = array('join_table' => 'quote_requests qr', 'join_by' => 'qr.id_quote_request = qu.fk_quote_request', 'join_type' => 'inner');
				$config['joins'][] = array('join_table' => 'rb_data rb', 'join_by' => 'rb.car_id = qr.rb_data', 'join_type' => 'left');
				$config['joins'][] = array('join_table' => 'users u', 'join_by' => 'u.id_user = qu.fk_user', 'join_type' => 'left');
				$config['joins'][] = array('join_table' => 'quote_request_accessories qra', 'join_by' => 'qra.fk_quote_request = qr.id_quote_request', 'join_type' => 'left');
				
				$config['wheres'][] = array('column_name' => 'fa.deprecated', 'column_value' => '0');
				$config['wheres'][] = array('column_name' => 'qu.deprecated', 'column_value' => '0');
			//$config['wheres'][] = array('column_name' => 'fa.status !=', 'column_value' => '100');
        
       			$config['wheres'][] = array('column_name' => 'qu.rb_data', 'column_value' => $id_rbdata);
		
				$config['wheres'][] = array('column_name' => 'qu.make', 'column_value' => $id_make);
				$config['wheres'][] = array('column_name' => 'qu.modal', 'column_value' => $id_modal);
       	//$config['wheres'][] = array('column_name' => 'fa.id_fq_account !=', 'column_value' => $fapplication_id);
		
        if(isset($_POST['state_id']) && !empty($_POST['state_id'])){
            $state = $_POST['state_id'];
            if($state != 'ALL'){
                $config['wheres'][] = array('column_name' => 'u.state', 'column_value' => $state);
            }
        }
        
        $config['order'] = array('qu.delivery_date_time' => 'DESC');
		//$config['group_by'] = 'qr.id_quote_request';
		//$config['group_by'] = 'fa.id_fq_account';
		$config['group_by'] = 'qu.id_quote';

        $this->load->library('datatables', $config, 'datatable');
		$list = $this->datatable->get_datatables();
		//echo $this->db->last_query();exit;
		$data = array();
			
		foreach ($list as $rec) {
			$row = array();            
            $onroad = '';
            if(isset($rec->on_road)){
                if($rec->on_road == 1) {
                   $onroad = '<input type="radio" class="hq_car_onroad" id="hq_car_onroad'.$rec->id_quote.'" value="1" data-id_quote="'.$rec->id_quote.'" checked="checked" > Yes <input type="radio" class="hq_car_onroad" id="hq_car_onroad'.$rec->id_quote.'" data-id_quote="'.$rec->id_quote.'" value="0"> No';
                } else {
                   $onroad = '<input type="radio" class="hq_car_onroad" id="hq_car_onroad'.$rec->id_quote.'" value="1"  data-id_quote="'.$rec->id_quote.'"> Yes <input type="radio" class="hq_car_onroad" id="hq_car_onroad'.$rec->id_quote.'" data-id_quote="'.$rec->id_quote.'" value="0"  checked="checked" > No';
                }
            }
            
            $date_time = isset($rec->delivery_date_time) ?  date('d-m-Y h:i A', strtotime($rec->delivery_date_time)) : '';
			$quote_file = isset($rec->quote_file) && !empty($rec->quote_file) ? base_url() .'uploads/quote_files/'. $rec->quote_file : 'javascript:void(0);';
			
            if($rec->id_quote == $rec->winner){
			    $row[] = '<a href="javascript:void(0);"><i class="fa fa-trophy"></i></a>';
            }else{                
                $row[] = '<span><i class="fa fa-trophy"></i></span>';
            }
            $row[] = '<a href="'.$quote_file .'" target="_blank"><i class="fa fa-eye"></i></a>';               
        	if($rec->id_quote == $rec->winner){
                $row[] = '<i class="fa fa-trash-o"></i>';
            } else {
                $row[] = '<a href="javascript:void(0);" data-id_quote="'.$rec->id_quote.'" class="delate_quote_button" title="Delete Quote">
                            <i class="fa fa-trash-o"></i>
                        </a>';
            }
            $row[] = '<a class="open-editdealer" data-dealer_id="'.$rec->id_user.'" href="javascript:void(0);" target="_blank">'.$rec->dealer.'</a>';
			$row[] = $rec->state;
			$row[] = $rec->quoted_price;
			$row[] = $onroad;
			$row[] = '<input type="text" id="hq_off_road_'.$rec->id_quote.'" value="'.$rec->car_off_road.'" >&nbsp;<button type="button" class="btn btn-primary btn-xs hq_off_road">OK</button>';
			$row[] = '<input type="text" data-toggle="tooltip" title="'.$rec->dealer_notes.'" id="hq_notes_'.$rec->id_quote.'" value="'.$rec->dealer_notes.'" >&nbsp;<button type="button" class="btn btn-primary btn-xs hq_dealer_notes">OK</button>';
			$row[] = $result = substr($rec->accessories, 0, 21);
			$row[] = $date_time;
            
			$data[] = $row;
			
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->datatable->count_all(),
			"recordsFiltered" => $this->datatable->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	function getDealer(){
		$make = $this->input->post('make');
		$state = $this->input->post('state');
		$html = '';
		
		if($make =='' && $state == ''){
			$html.='<option value="">-Dealer-</option>';
		}
		else{
		
			$where = "";
			if ($make != "") { $where .= " AND da.dealership_brand LIKE '%".$make."%' "; }
			if ($state != "") { $where .= " AND u.state LIKE '%".$state."%' "; }
		$query = "
					SELECT 
						u.id_user, u.id_user AS `user_id`, u.name , da.dealership_name
					FROM users u
					LEFT JOIN dealer_attributes da ON u.id_user = da.fk_user
					WHERE 1
					AND u.type = 1
					AND u.deprecated <> 1
					".$where."
					GROUP BY u.id_user
					ORDER BY name ASC";
					$get_dealers = $this->db->query($query)->result_array();
					
					$html.='<option value="">-Dealer-</option>';
					foreach(	$get_dealers as $k=>$v){
						$html.='<option value="'.$v['id_user'].'">'.$v['name'].'</option>';
					}
		}
		echo $html;
	}
	function all_historical_quotes(){
		
		
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		
		
		$config['table'] = 'quote_requests qr';
		$config['select'] = "qu.id_quote, qu.quote_file, rb.name AS car_name, rb.price AS car_price, rb.des AS car_desc, fa.id_fq_account as fq_number";
		$config['select'] .= ", qu.quoted_price, u.id_user, u.name AS dealer, u.state, qu.dealer_notes, qu.car_off_road, qu.on_road, qu.delivery_date_time, qu.make, qu.modal";
		$config['select'] .= ",qr.registration_type as registration_type, qr.winner, GROUP_CONCAT(qra.name) AS accessories";
		$config['select'] .= ', mk.name AS quote_make , fm.name AS quote_modal';
		//print_r(	$config);
		$config['joins'][] = array('join_table' => 'fq_accounts_new fa', 'join_by' => 'fa.id_fq_account = qr.fk_lead', 'join_type' => 'left');
		$config['joins'][] = array('join_table' => 'quotes qu', 'join_by' => 'qu.fk_quote_request = qr.id_quote_request', 'join_type' => 'left');
		$config['joins'][] = array('join_table' => 'rb_data rb', 'join_by' => 'rb.car_id = qr.rb_data', 'join_type' => 'left');
		$config['joins'][] = array('join_table' => 'users u', 'join_by' => 'u.id_user = qu.fk_user', 'join_type' => 'left');
		$config['joins'][] = array('join_table' => 'quote_request_accessories qra', 'join_by' => 'qra.fk_quote_request = qr.id_quote_request', 'join_type' => 'left');
		$config['joins'][] = array('join_table' => 'makes mk', 'join_by' => 'mk.id_make = qu.make', 'join_type' => 'inner');
		$config['joins'][] = array('join_table' => 'families fm', 'join_by' => 'fm.id_family = qu.modal', 'join_type' => 'inner');
		
    	$config['wheres'][] = array('column_name' => 'fa.deprecated', 'column_value' => '0');
		$config['wheres'][] = array('column_name' => 'qu.deprecated', 'column_value' => '0');
		if(isset($_POST['id_make']) && !empty($this->input->post('id_make'))){
			$id_make = $this->input->post('id_make');
			$config['wheres'][] = array('column_name' => 'qu.make', 'column_value' => $id_make);
		}
		if(isset($_POST['id_model']) && !empty($this->input->post('id_model'))){
			$id_modal = $this->input->post('id_model');
			$config['wheres'][] = array('column_name' => 'qu.modal', 'column_value' => $id_modal);
		}
		if(isset($_POST['id_rbdata']) && !empty($this->input->post('id_rbdata'))){
			$id_rbdata = $this->input->post('id_rbdata');
			$config['wheres'][] = array('column_name' => 'rb.car_id', 'column_value' => $id_rbdata);
		}
		
		if(isset($_POST['state_id']) && !empty($this->input->post('state_id'))){
            $state = $this->input->post('state_id');
            if($state != 'ALL'){
                $config['wheres'][] = array('column_name' => 'u.state', 'column_value' => $state);
            }
        }
		if(isset($_POST['dealer_id']) && !empty($this->input->post('dealer_id'))){
			$dealer_id = $this->input->post('dealer_id');
			$config['wheres'][] = array('column_name' => 'qu.fk_user', 'column_value' => $dealer_id);
		}
		if(isset($_POST['filter_from_dt']) && !empty($this->input->post('filter_from_dt'))){
			$filter_from_dt = $this->input->post('filter_from_dt');
			$config['wheres'][] = array('column_name' => 'qu.delivery_date_time >=', 'column_value' => $filter_from_dt.'%');
		}
		if(isset($_POST['filter_to_dt']) && !empty($this->input->post('filter_to_dt'))){
			$filter_to_dt = $this->input->post('filter_to_dt');
			$config['wheres'][] = array('column_name' => 'qu.delivery_date_time <=', 'column_value' => $filter_to_dt.'%');
		}
		$config['order'] = array('qu.delivery_date_time' => 'DESC');
		$config['group_by'] = 'qu.id_quote';
		
		$config['length'] = $limit;
		$config['start'] = $start;
		
		$this->load->library('datatables', $config, 'datatable');
		
		$list = $this->datatable->get_datatables();
		
		//echo $this->db->last_query();
		//exit;
		$data = array();		
		foreach ($list as $rec) {
			$row = array();            
            $onroad = '';
            if(isset($rec->on_road)){
                if($rec->on_road == 1) {
                   $onroad = '<input type="radio" class="hq_car_onroad" id="hq_car_onroad'.$rec->id_quote.'" value="1" data-id_quote="'.$rec->id_quote.'" checked="checked" > Yes <input type="radio" class="hq_car_onroad" id="hq_car_onroad'.$rec->id_quote.'" data-id_quote="'.$rec->id_quote.'" value="0"> No';
                } else {
                   $onroad = '<input type="radio" class="hq_car_onroad" id="hq_car_onroad'.$rec->id_quote.'" value="1"  data-id_quote="'.$rec->id_quote.'"> Yes <input type="radio" class="hq_car_onroad" id="hq_car_onroad'.$rec->id_quote.'" data-id_quote="'.$rec->id_quote.'" value="0"  checked="checked" > No';
                }
            }
            
            $date_time = isset($rec->delivery_date_time) ? date('d-m-Y h:i A', strtotime($rec->delivery_date_time)) : '';
            $quote_file = isset($rec->quote_file) && !empty($rec->quote_file) ? base_url() .'uploads/quote_files/'. $rec->quote_file : 'javascript:void(0);';
           
			//$row[] = '<a href="'.$quote_file .'" target="_blank"><i class="fa fa-eye"></i></a>';
			$row[] = $rec->quote_make;
			$row[] = $rec->quote_modal;
			$des = unserialize( $rec->car_desc);
			$des = implode(" - ",$des);
			$row[] = $rec->car_name." <br> ".$des." <br> ".$rec->car_price;           
        	$row[] = $rec->registration_type;
            $row[] = '<a class="open-editdealer" data-dealer_id="'.$rec->id_user.'" href="javascript:void(0);" target="_blank">'.$rec->dealer.'</a>';
			$row[] = $rec->state;
			$row[] = $rec->quoted_price;
			$row[] = $onroad;
			$row[] = '<input style="background-color: #00000024 !important;" type="text" id="hq_off_road_'.$rec->id_quote.'" value="'.$rec->car_off_road.'" >&nbsp;<button type="button" class="btn btn-primary btn-xs hq_off_road">OK</button>';
			$row[] = '<input style="background-color: #00000024 !important;" type="text" data-toggle="tooltip" title="'.$rec->dealer_notes.'" id="hq_notes_'.$rec->id_quote.'" value="'.$rec->dealer_notes.'" >&nbsp;<button type="button" class="btn btn-primary btn-xs hq_dealer_notes">OK</button>';
			$row[] = $result = substr($rec->accessories, 0, 21);
			$row[] = $date_time;
            
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->datatable->count_filtered(),
			"recordsFiltered" =>$this->datatable->count_filtered() ,
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);

	}
	public function admin_list_view ($start = 0)
	{
		$data = $this->data;
		$data['title'] = 'FinQuote Applications - Admin List View';
		$limit                 = 50;
		$count_result          = $this->fapplication_model->admin_get_records_count($_GET, $data['user_id'], $data['admin_type']);  // Record count
		$data['fapplications'] = $this->fapplication_model->admin_get_records($_GET, $data['user_id'], $data['admin_type'], $start, $limit); // Main Query
		$data['admins']        = $this->user_model->get_admins(); // Quote Specialists for Assignment
		$data['rl_admins']     = $this->user_model->get_admins($data['user_id']); // Quote Specialists for Reallocation
		$this->load->library('pagination');
		$config['base_url'] = site_url('fapplication/list_view/'); 
		$config['total_rows'] = $count_result['cnt'];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config); 
		$data['links'] = $this->pagination->create_links();
		$data['email_templates'] = $this->fapplication_model->get_email_templates($data['user_id']);
		$data['result_count'] = $count_result['cnt'];
		$data['admin_flag'] = $this->fapplication_model->get_fq_admin_flag($data['user_id']);
		
		$this->load->view('admin/fq_admin_list_view', $data);
	}
	public function open_note ($fapplication_id) // MODAL VIEW (DONE)
	{
		$query = "SELECT further_details as `details` FROM fq_accounts_new WHERE id_fq_account = ".$fapplication_id." LIMIT 1";
		$result = $this->db->query($query);
		if (count($result)==0)
		{
			$fapplication_note = '<br /><br /><center><i>No result found!</i></center>';
		}
		else
		{
			$fapplication_note = '';
			foreach ($result->result() as $row)
			{
				$fapplication_note .= $row->details;
			}
		}
		$fapplication_note_arr = array("fapplication_note" => $fapplication_note);
		echo json_encode($fapplication_note_arr);
	}	
	
	public function allocate () // MODAL ACTION
	{
		$fapplication_ids = $this->input->post('fapplication_ids');
		$user_id = $this->input->post('user_id');
		$this->fapplication_model->allocate_records($fapplication_ids, $user_id);
		$this->fapplication_model->update_records_status($fapplication_ids, 1);
		
		// $this->load->library('email');
		
		$admin_detail = $this->user_model->get_admin($user_id);
		$fapplication_id_arr = explode(',', $fapplication_ids);
		$temp_date_array = [];
		$app_dates = $this->fapplication_model->get_application_date($fapplication_ids, $user_id);
		foreach ($app_dates as $key => $val) 
		{
			$temp_date_array[] = $val;
		}
		foreach ($temp_date_array as $f_key => $f_val)
		{
			$final_time = "";
			$multiplier = (30 * ($f_key + 1));
			$date = date('Y-m-d');
			$date2 = "08:30:00";
			  
			$date3 = date('Y-m-d H:i:s', strtotime($date . " " . $date2));
			$time = date("H:i:s", strtotime($date3) + 60*$multiplier);
			$final_time = date('Y-m-d H:i:s', strtotime($date . " " . $time));
			$this->fapplication_model->update_record_date($f_val['id_fq_account'], $final_time, 'allocated_date');
		}
	}
	
	public function send_email () // MODAL ACTION
	{
		$data = $this->data;
		$fapplication_ids = $this->input->post('fapplication_ids');
		$user_id = $data['user_id'];
		$email_subject = $this->input->post('email_subject');
		$email_message = $this->input->post('email_message');
		
		$this->load->library('email');
		
		$admin_detail = $this->user_model->get_admin($user_id);
		$fapplication_id_arr = explode(',', $fapplication_ids);
		foreach ($fapplication_id_arr as $fapplication_id)
		{
			if ($fapplication_id != 'on')
			{
				$fapplication_detail = $this->fapplication_model->get_record_client($fapplication_id);
				$email_header = $this->fapplication_email_header;
				$email_header = str_replace('HEADER_1', $email_subject, $email_header);
				$email_header = str_replace('HEADER_2', rand(209381, 929102), $email_header);
				$email_header = str_replace('HEADER_3', $admin_detail['name'], $email_header);
				$email_body = '
				<tr>
					<td align="left" colspan="2">
						<p align="justify">
							<br /><br /><br /><br />
							Dear '.$fapplication_detail['lead_name'].',
							<br /><br />					
							'.$email_message.'
						</p>
						<br /><br />
					</td>
				</tr>';
				$email_body = '
				<tr>
					<td align="left" colspan="2">
						<p align="justify">
							<br /><br /><br /><br />
							'.$email_message.'
						</p>
						<br /><br />
					</td>
				</tr>';
				$email_content = $email_header.$email_body.$this->email_footer;
				$this->email->clear();
				$this->email->set_mailtype('html');
				$this->email->to($fapplication_detail['lead_email']);
				$this->email->from($admin_detail['username'], $admin_detail['name']);
				$this->email->subject($email_subject);
				$this->email->message($email_content);
				$this->email->send();
			}
		}
	}
	
	public function delete_cal_item()
	{	
		$post = $this->input->post();
		if(isset($post['isDelete']))
		{
			$isDelete = $post['isDelete'];
		}
		else
		{
			$isDelete = 'false';
		}
		$id = $post['fapplication_id'];
		$return = $this->fapplication_model->delete_cal_item($id,$isDelete);
		echo $return;
	}
	public function reallocate_cal_item()
	{	
		
		$id = $this->input->post('fapplication_id');
		$return = $this->fapplication_model->reallocate_cal_item($id);
		echo $return;
	}
	
	public function delete () // MODAL ACTION (DONE)
	{
		$fapplication_ids = $this->input->post('ids');
		$this->fapplication_model->delete_records($fapplication_ids);
	}
	public function restore_record_status () // MODAL ACTION (DONE)
	{
		$fapplication_ids = $this->input->post('ids');
		$this->fapplication_model->restore_record_status($fapplication_ids);
		
	}	
	public function allocation_status_change()
	{
		$fapplication_ids = $this->input->post('ids');
		$status = $this->input->post('status');
		$allto = $this->input->post('allto');
		//print_r($fapplication_ids );echo '<br>';echo $allto;echo  $status;exit;
		$this->fapplication_model->allocation_status_change($fapplication_ids,$status,$allto);
		echo '1';
	}
	
	public function update_record_date ($id) // CALENDAR ACTION (DONE)
	{
		$new_date = $this->input->post('new_date');
		// $this->fapplication_model->update_record_date($id, $new_date, 'assignment_date');
	}	
	public function update_record()
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;
		$input_arr = $this->input->post();
	
		/*echo "<pre>";
		print_r($input_arr);
		die();*/
	
		$this->fapplication_model->update_record_details($input_arr);
		$this->update_status_color_new(2, $input_arr['fapplication_id']);
		$this->action_model->insert_action(3, $input_arr['fapplication_id'], $data['user_id'], 'Update');

		$computation = array(
			'lead_id'=>$input_arr['fapplication_id'],
			'deposite'=>$input_arr['new_lead_deposit_amt'],
			'order_date'=>$input_arr['order_date'],
		);
		$this->db->where('lead_id',$input_arr['fapplication_id']);
		$checkExist = $this->db->get('computation');
		if ($checkExist->num_rows() == 0){
		
			$this->db->insert('computation', $computation);
		}else{
			$this->db->where('lead_id',$input_arr['fapplication_id']);
			$this->db->update('computation', $computation);
		}

		// if ($input_arr['fapplication_status']<=1)
		// {
		// 	$this->fapplication_model->update_record_status($input_arr['fapplication_id'], 2);
		// 	$this->fapplication_model->update_record_date($input_arr['fapplication_id'], $now, 'attempted_date');
		// }
		$result = $this->fapplication_model->get_basic_fapplication_data($input_arr['fapplication_id']);
		//print_r($result);exit;
		$car = $car = $result['lead_make']." ".$result['lead_model'];
		$return_array = [
			'title' => addslashes($result['lead_name']).' ('.$car.')' . ' - ' . $result['lead_phone'] . ' - ' . $result['lead_email'] . ' - ' . $result['lead_state']
		];
		echo json_encode($return_array);
	}
	public function record_called () // MODAL ACTION
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;
		$input_arr = $this->input->post();
		$this->action_model->insert_action(3, $input_arr['fapplication_id'], $data['user_id'], 'Called the Client');
		if ($input_arr['fapplication_status']<=1)
		{
			// $this->fapplication_model->update_record_status($input_arr['fapplication_id'], 2);
			// $this->fapplication_model->update_record_date($input_arr['fapplication_id'], $now, 'attempted_date');
		}
	}	
	public function delete_calendar () // MODAL ACTION
	{
		$now = date('Y-m-d H:i:s');
		$data = $this->data;
		$id = $this->input->post('fapplication_id');
		// $this->fapplication_model->update_record_date($id, $now, 'deleted_date');
		$this->fapplication_model->update_record_status($id, 100);
		$this->action_model->insert_action(3, $id, $data['user_id'], 'Delete');
	}
	public function upload_file () // BACKGROUND ACTION
	{
		$data = $this->data;
		$directory = './uploads/fq_files/';
		$prefix = time().'_'.$data['user_id'].'_';
		$file_name = $_FILES['file']['name'];
		$file_tmp = $_FILES['file']['tmp_name'];
		$file = $directory.$prefix.$file_name;
		if(move_uploaded_file($file_tmp, $file))
		{
			echo $file;
		}
	}
	// temporary allocate a connected lead when an fq user opens an fq lead.
	public function allocate_temp_lead()
	{
		$data = $this->data;
		$post_data = $this->input->post();
		$post_data['user_id'] = $data['user_id'];
		$this->fapplication_model->allocate_temp_lead($post_data);
	}
	// remove temporary allocation a connected lead when an fq user opens an fq lead.
	public function deallocate_temp_lead()
	{
		$data = $this->data;
		$post_data = $this->input->post();
		$post_data['user_id'] = $data['user_id'];
		$this->fapplication_model->deallocate_temp_lead($post_data);
	}
	//requirement upload
	public function upload_requirements()
	{
		$post_data = $this->input->post();
		
		$data               = $this->data;
		$directory          = './uploads/cq_requirements/';
		$prefix             = time().'_'.$data['user_id'].'_';
		$file_name          = $_FILES['file']['name'];
		$file_tmp           = $_FILES['file']['tmp_name'];
		$file               = $directory.$prefix.$file_name;
		$ext = pathinfo($file, PATHINFO_EXTENSION);
		
		$database_file_name = $prefix.$file_name;
		
		$id             = $post_data['id'];
		$fk_requirement = $post_data['fk_requirement'];
		$is_temp         = $post_data['is_temp'];
		
		$response_raw = $this->fapplication_model->insert_requirements($id, $database_file_name, $data['user_id'], 4, $fk_requirement, $file_name, $is_temp,$ext);

		$response = $directory . $response_raw;
		$allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
		$detectedType = exif_imagetype($file_tmp);
		/*if(in_array($detectedType, $allowedTypes))
		{
			$this->load->library('pdf');
			$pdf = $this->pdf->load();
			$file_name = $prefix . $file_name;
			$base_file = base_url('uploads/cq_requirements/'.$file_name);
			move_uploaded_file($file_tmp, $directory . $file_name);
			$pdfFilePath = FCPATH."/uploads/cq_requirements/".$response_raw;
			$html = "
				<html>
					<head>
					</head>
					<body>
						<img src='{$base_file}' />
					</body>
				</html>
					";
			$pdf->WriteHTML($html);
			$pdf->Output($pdfFilePath, 'F');
			unlink($directory . $file_name);
			move_uploaded_file($file_tmp, $pdfFilePath);
		}
		else
		{
			move_uploaded_file($file_tmp, $response);
		}*/
		move_uploaded_file($file_tmp, $response);
		$notify_array = [
			'fq_id'          => $id,
			'flag'           => 1,
			'fk_requirement' => $fk_requirement,
			'file_name'      => $file_name,
			'user_id'        => $data['user_id']
		];
		$this->notify_admin($notify_array);
		if($fk_requirement==15){
			$this->update_status_color_new(4, $id);
		}
		elseif($fk_requirement==16){
			$this->update_status_color_new(5, $id);
		}
	}
	//global files uploads
	public function upload_global_req ()
	{
		$return_array = [];
		$post_data = $this->input->post();
		$data               = $this->data;
		$directory          = './uploads/cq_requirements/';
		$file_name          = $_FILES['file']['name'];
		$file_tmp           = $_FILES['file']['tmp_name'];

		$response_raw = $this->fapplication_model->insert_global_requirements($file_name, $data['user_id']);
		$response = $directory . $response_raw["file_name"];
		$allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
		$detectedType = exif_imagetype($file_tmp);
		if(in_array($detectedType, $allowedTypes))
		{
			$this->load->library('pdf');
			$pdf = $this->pdf->load();
			// $file_name = $prefix . $file_name;
			$base_file = base_url('uploads/cq_requirements/'.$file_name);
			move_uploaded_file($file_tmp, $directory . $file_name);
			$pdfFilePath = FCPATH."/uploads/cq_requirements/".$response_raw["file_name"];
			$html = "
				<html>
					<head>
					</head>
					<body>
						<img src='{$base_file}' />
					</body>
				</html>
					";
			$pdf->WriteHTML($html);
			$pdf->Output($pdfFilePath, 'F');
			unlink($directory . $file_name);
			move_uploaded_file($file_tmp, $pdfFilePath);
		}
		else
		{
			move_uploaded_file($file_tmp, $response);
		}
		$return_array = [
			"absolute_path" => base_url('uploads/cq_requirements/'.$response_raw["file_name"]),
			"req"           => $response_raw["id_req"],
			"name"          => $response_raw["file_name"]
		];
		echo json_encode($return_array);
	}
	public function get_global_req()
	{
		$data = $this->data;
    	$post_data = $this->input->post();
		$response = $this->fapplication_model->get_global_requirements();
		$modal_list = '';
		$file_path = 'uploads/cq_requirements/';
		$absolute_path = "";
		foreach ($response as $key => $value) 
		{
			$absolute_path = base_url($file_path.$value['file_name']);
			$modal_list .= "
							<tr class='tr_req' data-req='{$value['id_req_up']}' data-abspath='{$value['file_name']}'>
								<td><a target='_blank' href='{$absolute_path}'>".$value['file_name']."</a></td>
								<td><a class='fa fa-trash-o del_global_file'></a></td>
							</tr>
							";
		}
		if(count($response) < 1)
			$modal_list = "";
		$dom = array(
				'global_req_list' => $modal_list
					);
		echo json_encode($dom);
	}
	public function pdf_export ($tradein_id) // PDF RENDER jeno
	{
		$data = $this->data;
		$pdfFilePath = FCPATH."/uploads/tradeins/".$filename.".pdf";
		ini_set('memory_limit','32M');
		$html = $this->load->view('admin/tradein_print_v2', $data, true);
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->SetHTMLFooter($footer);
		$pdf->WriteHTML($html);
		$pdf->Output($pdfFilePath, 'F');
		redirect("/uploads/tradeins/".$filename.".pdf");
	}
	public function add_comment ($id) // MODAL ACTION jeno
	{
		$data = $this->data;
		$input_arr = $this->input->post() ;
		$input_arr['user_id'] = $data['user_id'];
		$this->comment_model->insert_comment($id, 2, $input_arr);
		$comment_id = $this->db->insert_id();
		if (isset($_POST['fa_uploaded_comment_file']))
		{
			foreach ($_POST['fa_uploaded_comment_file'] AS $uploaded_file)
			{
				$file_name = str_replace('./uploads/fq_files/', '', $uploaded_file);
				$this->comment_model->insert_comment_attachment($comment_id, $file_name);
			}
		}
		if ($input_arr['fapplication_status']<=1)
		{
			// $this->fapplication_model->update_record_status($input_arr['id_fapplication'], 2);
			// $this->fapplication_model->update_record_date($input_arr['id_fapplication'], $now, 'attempted_date');
		}		
	}
	public function add_new_req()
	{
		$post_data = $this->input->post();
		echo $this->fapplication_model->add_new_req($post_data);
	}
	public function del_new_req()
	{
		$post_data = $this->input->post();
		echo $this->fapplication_model->del_new_req($post_data);
	}
	public function get_temp_req($id = 0, $type = 0)
	{
		$class = "";
		$default_string = "";
		$result = $this->fapplication_model->get_requirements_dom($id, $type);
		if(count($result) > 0)
		{
			foreach ($result as $res_key => $res_val) 
			{
				$class = "";
				$class_ctr = $this->fapplication_model->get_requirements_class($id, $res_val['id_requirement'], 1);
				if($class_ctr > 0)
					$class = "requirements_green";
				else
					$class = "requirements_white";
				$default_string .= "
								<div class='col-md-3'>
									<div class='row'>
										<div class='col-md-12'>
											<div class='panel panel-default'>
												<div class='req-panel panel-body {$class} requirements ' data-req='{$res_val['id_requirement']}' data-type='{$type}' data-istemp='1' data-idreq='{$res_val['id_req_fq_account']}'>
														<label class='f-label req_name {$class}'>{$res_val['name']}</label>
													
													<div class='pull-right'>
														<a class='fa fa-desktop req_button {$class}'></a>&nbsp;
														<a class='fa fa-trash-o del_req text-danger'></a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								";
			}
		}
		return $default_string;
	}
	public function get_requirements_ddown($type, $params, $flags = array())
	{
		$result = $this->fapplication_model->get_requirements_new();
		$req_pan_array = $this->requirement_panel_rules($type, $params, $flags);
		$req_temp_array = $this->fapplication_model->get_temp_requirements($params['id_fq_account'], $type);
		foreach ($req_temp_array as $key => $val) 
		{
			$req_pan_array[] = $val['fk_requirement'];
		}
		$select_string = "<option value=''> -- Choose a requirement -- </option>";
		foreach ($result as $res_key => $res_val) 
		{
			if( !in_array($res_val['id_requirement'], $req_pan_array) )
			{
				$select_string .= "
								<option value='{$res_val['id_requirement']}'>{$res_val['name']}</option>
								";
			}
		}
		return $select_string;
	}
	
	
	public function get_suggested_dealers ($quote_request_id = 0) // MODAL VIEW //
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;
		
		$input_arr = $this->input->post();
        //echo '<pre>';print_r($input_arr);exit;
        $make = isset($input_arr['make']) ? $input_arr['make'] : null;
		$postcode = null;
       /// $postcode = isset($input_arr['postcode']) ? $input_arr['postcode'] : null;
        $state = isset($input_arr['state']) ? $input_arr['state'] : null;
		$suggested_dealers = $this->user_model->get_suggested_dealers($make, $postcode, $state, $quote_request_id);
       	
		if ($suggested_dealers->num_rows() > 0)
		{
            $suggested_dealers_arr = $suggested_dealers->result_array();
			$html = '
			<div class="table-responsive" style="">
				<table class="table table-bordered table-striped table-condensed mb-none" CELLSPACING=0>
					<thead>						
						<tr>
							<th></th>
							<th>Email</th>
							<th>Dealership</th>
							<th>Quote Request Recipiants</th>                            
							<th>Address</th>
							<th>Postcode</th>
							<th>State</th>
							<th>Invites</th>
							<th>Quotes</th>
							<th>Won</th>
							<th>Orders</th>
						</tr>
					</thead>
					<tbody>';
            
                        foreach($suggested_dealers_arr AS $key => $val){
                            if(!empty($val['dealership_contact_boxs'])){
                                $dealership_contact_boxs = json_decode(stripslashes($val['dealership_contact_boxs']));
                                if(!empty($dealership_contact_boxs->quote_request_recipient) && $dealership_contact_boxs->quote_request_recipient == 'on'){
                                    $manager_name = $val['name'];
                                }
                            }
                            $manager_name = '';
                            if(!empty($val['contacts'])){
                                $contect_details = json_decode(stripslashes($val['contacts']));
                                if(!empty($contect_details)){
                                    foreach($contect_details AS $key_cd => $val_cd){
                                        if(!empty($val_cd->contact_boxs) && $val_cd->contact_boxs->quote_request_recipient == 'on' ){
                                            $manager_name .= $val_cd->contact_fullname;
                                        }
                                    }
                                }
                            }
                            
                            $gold_status_flag = ($val['gold_status'] == 1) ? '<i class="fa fa-star" style="color: #FFD700;" ></i>' : '';
							$html .= '							
							<tr id="suggested_dealer_'.$val['id_user'].'">
								<td align="center">
									<span onClick="select_suggested_dealer(\''.$input_arr['container'].'\', '.$val['id_user'].')" style="cursor: pointer; cursor: hand; color: #58c603;">
										<i class="fa fa-plus"></i>
									</span>
								</td>
								<td id="dealer_'.$val['id_user'].'"><a href="javascript:void(0)" class="open-editdealer" data-dealer_id="'.$val['id_user'].'">'.$val['username'].'</a> &nbsp; '.$gold_status_flag.'</td>
								<td>'.$val['dealership_name'].'</td>
								<td>'.$manager_name.'</td>
								<td>'.$val['dealership_address'].'</td>
								<td>'.$val['postcode'].'</td>
								<td>'.$val['state'].'</td>
								<td>'.$val['tender_count'].'</td>
								<td>'.$val['quote_count'].'</td>
								<td>'.$val['won_count'].'</td>
								<td>'.$val['order_count'].'</td>
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
						<th>Email</th>
						<th>Dealership</th>
						<th>Address</th>
						<th>Postcode</th>
						<th>State</th>
						<th>Invites</th>
						<th>Quotes</th>
						<th>Won</th>
						<th>Orders</th>
					</thead>					
					<tbody>
						<tr><td colspan="10"><center><i>No dealers found!</i></center></td></tr>
					</tbody>
				</table>
			</div>';
			
		}
		
		echo $html;
	}
	public function get_suggested_wholesalers ($quote_request_id = 0) // MODAL VIEW //
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;
		
		$input_arr = $this->input->post();
        //echo '<pre>';print_r($input_arr);exit;
        $make = isset($input_arr['make']) ? $input_arr['make'] : null;
		$postcode = null;
       /// $postcode = isset($input_arr['postcode']) ? $input_arr['postcode'] : null;
        $state = isset($input_arr['state']) ? $input_arr['state'] : null;
		$suggested_wholesalers = $this->user_model->get_suggested_wholesalers();
		// $suggested_dealers = $this->user_model->get_suggested_wholesalers_2($make, $postcode, $state, $quote_request_id);
		if ($suggested_wholesalers->num_rows() > 0)
		{
            $suggested_wholesalers_arr = $suggested_wholesalers->result_array();
            $html = '
			<div class="table-responsive" style="">
				<table class="table table-bordered table-striped table-condensed mb-none" CELLSPACING=0>
					<thead>						
						<tr>
							<th></th>
							<th>Email</th>
							<th>Address</th>
							<th>Postcode</th>
							<th>State</th>
						</tr>
					</thead>
					<tbody>';
            
                        foreach($suggested_wholesalers_arr AS $key => $val){
                            
                            $gold_status_flag = ($val['gold_status'] == 1) ? '<i class="fa fa-star" style="color: #FFD700;" ></i>' : '';
							$html .= '							
							<tr id="suggested_dealer_'.$val['id_user'].'">
								<td align="center">
									<span onClick="select_suggested_wholesaler(\''.$input_arr['container'].'\', '.$val['id_user'].')" style="cursor: pointer; cursor: hand; color: #58c603;">
										<i class="fa fa-plus"></i>
									</span>
								</td>
								<td id="dealer_'.$val['id_user'].'"><a href="javascript:void(0)" class="open-editdealer" data-dealer_id="'.$val['id_user'].'">'.$val['username'].'</a> &nbsp; '.$gold_status_flag.'</td>
								<td>'.$val['address'].'</td>
								<td>'.$val['postcode'].'</td>
								<td>'.$val['state'].'</td>
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
						<th>Email</th>
						<th>Dealership</th>
						<th>Address</th>
						<th>Postcode</th>
						<th>State</th>
						<th>Invites</th>
						<th>Quotes</th>
						<th>Won</th>
						<th>Orders</th>
					</thead>					
					<tbody>
						<tr><td colspan="10"><center><i>No wholesaler found!</i></center></td></tr>
					</tbody>
				</table>
			</div>';
			
		}
		
		echo $html;
	}
    
    public function get_invited_dealers ($quote_request_id = 0) // MODAL VIEW //
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;
		
		$input_arr = $this->input->post();
        
		$invited_dealers = $this->user_model->get_invited_dealers($input_arr['id_quote_request']);
        // echo '<pre>';print_r($invited_dealers);exit;
        
        //$tender_dealers = $this->request_model->get_tender_dealers($lead['id_quote_request']);
		if ($invited_dealers->num_rows() > 0)
		{
			$html = '
			<div class="table-responsive" style="white-space: nowrap;">
				<table class="table table-bordered table-striped table-condensed mb-none">
					<thead>						
						<tr>
							<th></th>
							<th>Email</th>
							<th>Dealership</th>
							<th>Address</th>
							<th>Postcode</th>
							<th>State</th>
							<th>Invites</th>
							<th>Quotes</th>
							<th>Won</th>
							<th>Orders</th>
						</tr>
					</thead>
					<tbody>';
						foreach($invited_dealers->result() as $dealer)
						{
							$gold_status_flag = ($dealer->gold_status == 1) ? '<i class="fa fa-star" style="color: #FFD700;" ></i>' : '';
							$html .= '
							
							<tr id="suggested_dealer_'.$dealer->id_user.'">
								<td align="center">
									<span onClick="select_suggested_dealer(\''.$input_arr['container'].'\', '.$dealer->id_user.')" style="cursor: pointer; cursor: hand; color: #58c603;">
										<i class="fa fa-plus"></i>
									</span>
								</td>
								<td id="dealer_'.$dealer->id_user.'">'.$dealer->username.' &nbsp; '.$gold_status_flag.'</td>
								<td>'.$dealer->dealership_name.'</td>									
								<td>'.$dealer->dealership_address.'</td>
								<td>'.$dealer->postcode.'</td>
								<td>'.$dealer->state.'</td>
								<td>'.$dealer->tender_count.'</td>
								<td>'.$dealer->quote_count.'</td>
								<td>'.$dealer->won_count.'</td>
								<td>'.$dealer->order_count.'</td>
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
						<th>Email</th>
						<th>Dealership</th>
						<th>Address</th>
						<th>Postcode</th>
						<th>State</th>
						<th>Invites</th>
						<th>Quotes</th>
						<th>Won</th>
						<th>Orders</th>
					</thead>					
					<tbody>
						<tr><td colspan="10"><center><i>No dealers found!</i></center></td></tr>
					</tbody>
				</table>
			</div>';
			
		}
		
		echo $html;
	}
	
	public function add_dealers () // MODAL ACTION // AUDIT TRAIL //
	{
		// echo "string"; die;
		$now = date("Y-m-d H:i:s");
		$data = $this->data;
		$input_arr = $this->input->post();
		//echo json_encode($input_arr); die();
		$email_content = $input_arr['add_dealer_email_template_content'];
		$process_error = array();
		$dealer_id_arr = explode("-", $input_arr['dealer_ids']);
		$mail_text = $input_arr['mail_text'];
		$file_name = '';
		if(isset($_FILES['quote_file']) && !empty(isset($_FILES['quote_file']))){
			$file_element_name = 'quote_file';
			$config['upload_path'] = './uploads/dealer_uploaded_files/';
			$config['allowed_types'] = '*';
			$config['overwrite'] = TRUE;
			$config['encrypt_name'] = FALSE;
			$config['remove_spaces'] = TRUE;
			$newFileName = $_FILES['quote_file']['name'];
			$config['file_name'] = $newFileName;
			if(!is_dir($config['upload_path'])){
				mkdir($config['upload_path'],0777,TRUE);
			}
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload($file_element_name)){
				$return['Uploaderror'] = $this->upload->display_errors();
			}
			$file_data = $this->upload->data();
			$file_name = $file_data['file_name'];
			@unlink($_FILES[$file_element_name]);
		}
		$insert_arr = array(
			'mail_text' => $input_arr['mail_text'],
			'file' => $file_name,
		);
		//echo '<pre>';print_r($input_arr);exit;
        $manager_name = '';
        $myArr = array();
		foreach ($dealer_id_arr as $dealer_id)
		{
			if ($dealer_id <> 0)
			{
				if(!in_array($dealer_id, $myArr)) {
					array_push($myArr, $dealer_id);
					$insert_dealer_request_result = $this->request_model->insert_dealer_request($input_arr['id_quote_request'], $dealer_id, $insert_arr);
					if (!$insert_dealer_request_result)
					{
						$process_error[] = $dealer_id." not added";
					}
	                $user_detail = $this->user_model->get_dealer($dealer_id);
					if (isset($user_detail['username']))
					{
						$rand_key = md5($dealer_id.rand(0,100));
						$upload_key_data['uploadKey'] = $rand_key;
						$where = array("fk_user"=>$dealer_id);
						$this->user_model->updateRow("dealer_requests",$upload_key_data,$where);
						// echo 'From Func:'.$dealer_id.'<br>';
			            $this->send_quote_request_mail($dealer_id,$input_arr['id_lead'],$rand_key,$input_arr['id_quote_request'], $email_content);
						//$this->templated_dealer_lead_email_init(10, $dealer_id, $input_arr['id_lead'], 'company', 'dealer');//temporary commented
					}
				}
			}
		}
		
		if (count($process_error)==0)
		{
			$audit_trail_arr = array(
				'id' => $input_arr['id_lead'],
				'table_name' => 'fq_accounts_new',
				'action' => 11,
				'description' => ''
			);
			$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);
            //echo '<pre>';print_r($insert_audit_trail_result);exit;
			$this->action_model->insert_action(1, $input_arr['id_lead'], $data['user_id'], 'Added Dealer Invites');
			
			echo "success";
		}
		else
		{
			echo "fail";
		}
	}
	public function invited_dealers () // MODAL ACTION // AUDIT TRAIL //
	{
		// echo "string"; die;
		$now = date("Y-m-d H:i:s");
		$data = $this->data;
		$input_arr = $this->input->post();
		//echo json_encode($input_arr); die();
		$email_content = $input_arr['resend_quote_email_template_content'];
		$process_error = array();
		$dealer_id_arr = explode("-", $input_arr['dealer_ids']);
		$mail_text = $input_arr['mail_text'];
		$file_name = '';
		if(isset($_FILES['quote_file']) && !empty(isset($_FILES['quote_file']))){
			$file_element_name = 'quote_file';
			$config['upload_path'] = './uploads/dealer_uploaded_files/';
			$config['allowed_types'] = '*';
			$config['overwrite'] = TRUE;
			$config['encrypt_name'] = FALSE;
			$config['remove_spaces'] = TRUE;
			$newFileName = $_FILES['quote_file']['name'];
			$config['file_name'] = $newFileName;
			if(!is_dir($config['upload_path'])){
				mkdir($config['upload_path'],0777,TRUE);
			}
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload($file_element_name)){
				$return['Uploaderror'] = $this->upload->display_errors();
			}
			$file_data = $this->upload->data();
			$file_name = $file_data['file_name'];
			@unlink($_FILES[$file_element_name]);
		}
		$insert_arr = array(
			'mail_text' => $input_arr['mail_text'],
			'file' => $file_name,
		);
		//echo '<pre>';print_r($input_arr);exit;
        $manager_name = '';
        $myArr = array();
		foreach ($dealer_id_arr as $dealer_id)
		{
			if ($dealer_id <> 0)
			{
				if(!in_array($dealer_id, $myArr)) {
					array_push($myArr, $dealer_id);
					$insert_dealer_request_result = $this->request_model->insert_dealer_request($input_arr['id_quote_request'], $dealer_id, $insert_arr);
					if (!$insert_dealer_request_result)
					{
						$process_error[] = $dealer_id." not added";
					}
	                $user_detail = $this->user_model->get_dealer($dealer_id);
					if (isset($user_detail['username']))
					{
						$rand_key = md5($dealer_id.rand(0,100));
						$upload_key_data['uploadKey'] = $rand_key;
						$where = array("fk_user"=>$dealer_id);
						$this->user_model->updateRow("dealer_requests",$upload_key_data,$where);
			            $this->send_quote_request_mail($dealer_id,$input_arr['id_lead'],$rand_key,$input_arr['id_quote_request'], $email_content,'invited_dealers');
						//$this->templated_dealer_lead_email_init(10, $dealer_id, $input_arr['id_lead'], 'company', 'dealer');//temporary commented
					}
				}
			}
		}
		
		if (count($process_error)==0)
		{
			$audit_trail_arr = array(
				'id' => $input_arr['id_lead'],
				'table_name' => 'fq_accounts_new',
				'action' => 11,
				'description' => ''
			);
			$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);
            //echo '<pre>';print_r($insert_audit_trail_result);exit;
			$this->action_model->insert_action(1, $input_arr['id_lead'], $data['user_id'], 'Added Dealer Invites');
			
			echo "success";
		}
		else
		{
			echo "fail";
		}
	}
    
    function c_date(){
        for ($x = 13; $x <= 40; $x++) {
            echo " $x <br>";
        } 
    }
    
    public function get_dealer(){
        $lead = $this->lead_model->get_lead(321);
        echo '<pre>';print_r($lead);exit;
    }
    
    public function send_quote_request_mail($dealer_id,$lead_id,$rand_key,$quote_request_id, $email_content='',$from=''){
		
		$data = $this->data;
		$user_details = $this->user_model->get_dealer_for_email($dealer_id);
		$lead_details = $this->lead_model->get_lead_for_email($lead_id);
		$dealer_requests = $this->user_model->getRow('dealer_requests',array('fk_quote_request' => $quote_request_id, 'fk_user' => $dealer_id));
		// $link_url = "<a href=".site_url("Process/submitquote_dealer/".$lead_id."/".$dealer_id).">click here</a>";
		$link_url = "<a href=".site_url("Process/submitquote_dealer/".$lead_id."/".$dealer_id).">click here";
		
		$fq_dealer_data = $this->fapplication_model->get_fq_dealer_data($lead_id);
        
        $lead = $this->lead_model->get_lead($lead_id);
		$quote_data = $this->request_model->get_quote_request($quote_request_id);
        
        $from_name = $lead['qs_name'];
		$from_email = $lead['qs_email'];
		$file_name = isset($dealer_requests->file_name) && !empty($dealer_requests->file_name) ? $dealer_requests->file_name : '';
		$query = "SELECT * FROM `rb_data`  WHERE car_id = '".$lead['rb_data']."' LIMIT 1";
		$result = $this->db->query($query);
		if (count($result)==0){
				$car_name = "N/A";
		}else{
			$fapplication_note = '';
			foreach ($result->result() as $row)
			{
				$car_name = $row->name;
			}
		}
		$flagCount = false;
		/*echo "<pre>";
		print_r($user_details);*/
		//die();
		if(!empty($user_details['dealership_contact_boxs'])) {
		
			$dealership_contact_boxs = json_decode(stripslashes($user_details['dealership_contact_boxs']));
		
            if(!empty($dealership_contact_boxs->quote_request_recipient) && $dealership_contact_boxs->quote_request_recipient == 'on'){
				/**/
				$flagCount = true;
				/**/
                $manager_name = $user_details['dealer_manager_name'];
                $to = $user_details['dealer_email'];
                $content = $email_content;
                $content = preg_replace('/<a(.*)href="([^"]*)"(.*)>click here/',$link_url,$content);
                $content = preg_replace('/Hi ([A-Za-z0-9.]+\s*)+,/','Hi '.$manager_name.',',$content);
                /*if($to == 'paul@finquote.com.au') {
					$to = 'devakshay89@gmail.com';
				}*/
				$resend = '';
				if($from == 'invited_dealers') {
					$resend = 'Resend';
				}
                /*echo $dealer_id.'-->';
				echo $to.'<br>';*/
                $subject = $data['company']['company_name']." - ".$resend." Quote Request"." - ". $car_name;
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
                if (trim($file_name) <> ""){
                    $path = './uploads/dealer_uploaded_files/';
                    $this->email->attach($path.$file_name);
                    //echo $this->email->print_debugger();
                }
                if($this->email->send()){
					$trail_array = [
						'fk_user'    => $data['user_id'],
						'fk_account' => $lead_id,
						'sent_to'    => $to,
						'subject'    => $subject,
						'message'    => $content,
						'attachment'    => $file_name,
						'attachment_url' => 'uploads/dealer_uploaded_files/'.$file_name,
						'created_at' => date('Y-m-d H:i:s')
					];
					$this->fapplication_model->email_audit_trail_model($trail_array);
                    
                }else{
                    echo "error";
				}
				
                //$this->email->clear();
            }
        }
	
        if(!empty($user_details['contacts']) && $flagCount == false) {
			$contect_details = json_decode(stripslashes($user_details['contacts']));
			
            if(!empty($contect_details)){
                foreach($contect_details AS $key => $val){


                    if(!empty($val->contact_boxs) && $val->contact_boxs->quote_request_recipient == 'on' ){
                        $content = $email_content;
                		$to = $val->contact_email;
                		$content = preg_replace('/<a(.*)href="([^"]*)"(.*)>click here/',$link_url,$content);
		                $content = preg_replace('/Hi ([A-Za-z0-9.]+\s*)+,/','Hi '.$manager_name.',',$content);
		                if($to == 'paul@finquote.com.au') {
							// $to = 'devakshay89@gmail.com';
						}
						/*echo 'another--'.$dealer_id.'-->';
						echo $to.'<br>';*/
						// die();
						$resend = '';
						if($from == 'invited_dealers') {
							$resend = 'Resend';
						}
                        
                        $subject = $data['company']['company_name']." - ".$resend." Quote Request"." - ". $car_name;
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
                        if (trim($file_name) <> ""){
                            $path = './uploads/dealer_uploaded_files/';
                            $this->email->attach($path.$file_name);
                            //echo $this->email->print_debugger();
                        }
                        if($this->email->send()){
                            $trail_array = [
                                'fk_user'    => $data['user_id'],
                                'fk_account' => $lead_id,
                                'sent_to'    => $to,
                                'subject'    => $subject,
                                'message'    => $content,
								'attachment'    => $file_name,
								'attachment_url' => 'uploads/dealer_uploaded_files/'.$file_name,
                                'created_at' => date('Y-m-d H:i:s')
                            ];
                            $this->fapplication_model->email_audit_trail_model($trail_array);
                        }else{
							
                            echo "error";
                        }
                    }
                }
            }
        }
	}
	
	public function start_tender_new_save()
	{
		
		$now = date("Y-m-d H:i:s");
		$data = $this->data;
		// print_r($data);exit;
		$input_arr = $this->input->post();
		$lead = $this->lead_model->get_lead($input_arr['id_lead']);
		
		if ($lead['qs_id']==0)
		{
			$this->lead_model->allocate_lead($input_arr['id_lead'], $data['user_id']);
			$this->lead_model->update_lead_attempt_flag($input_arr['id_lead'], 1);
		}
		
		// ..TEMPORARY //
		// $vehicle_details = $this->car_model->get_vehicle($input_arr['vehicle']);
		// echo "string"; die();
		/*$input_arr['series'] = $vehicle_details['series'];
		$input_arr['body_type'] = $vehicle_details['bodystyle'];
		$input_arr['transmission'] = $vehicle_details['transmission'];
		$input_arr['fuel_type'] = $vehicle_details['fueltype'];*/
		// ..TEMPORARY //
		$fq_dealer_data = array();
		$fq_dealer_data_keys = array(
		'fq_lead_id'		=> 'id_lead',
		'name'				=> 'new_lead_name',
		'surname'			=> 'new_lead_surname',
		'number'			=> 'new_lead_number',
		'email'				=> 'new_lead_email_address',
		'address'			=> 'new_lead_address',
		'postcode'			=> 'new_lead_postcode',
		'dl_no'				=> 'new_lead_dl_no',
		'c_card_type'		=> 'new_lead_credit_card',
		'c_card_num'		=> 'new_lead_card_no',
		'c_card_exp'		=> 'new_lead_exp_date',
		'c_card_cvv'		=> 'new_lead_cvv_no',
		'deposite_amt'		=> 'new_lead_deposit_amt',
		'year'				=> 'newLead_car_year',
		'make'				=> 'newLead_make',
		'modal'				=> 'newLead_model',
		'veriant'			=> 'newLead_car_variant',
		'redbook_url'		=> 'new_lead_redbook_url',
		'sale_price'		=> 'new_lead_sale_price',
		'winning_quote'		=> 'new_lead_winning_quote',
		'winning_trade'		=> 'new_lead_winning_trade',
		'gross_margin'		=> 'new_lead_gross_margin',
		'delivery_date'		=> 'new_lead_delivery_date',
		'dealer'			=> 'new_lead_dealer',
		'wholesaler'		=> 'new_lead_wholesaler');
		
		foreach($fq_dealer_data_keys as $fq_key=>$input_key)
		{
			$fq_dealer_data[$fq_key] = $input_arr[$input_key];
		}
		$this->fapplication_model->insert_update_fq_dealer_data($fq_dealer_data,$input_arr['id_lead']);
		$insert_quote_request_result = $this->request_model->send_quote_request($input_arr, $data['user_id']);
		//exit;
		if ($insert_quote_request_result)
		{
			$quote_request_id = $this->db->insert_id();
				
			//$this->lead_model->update_lead_status($input_arr['id_lead'], 3);
			//$this->lead_model->update_lead_date($input_arr['id_lead'], $now, 'tender_date');
		
			if (isset($input_arr['options_arr']))
			{
				foreach ($input_arr['options_arr'] as $option_id)
				{
					$this->request_model->send_quote_request_option($quote_request_id, $option_id);
				}
			}
			if (isset($input_arr['accessory_name']))
			{
				$accessories = $input_arr['accessory_name'];
				$accessories = array_filter($accessories);
				$old_acc = array();
				foreach ($accessories as $acc_index => $acc)
				{
					if(!in_array($acc, $old_acc)) {
						array_push($old_acc, $acc);
						if($acc != '@@@') {
							$this->request_model->send_quote_request_accessory($quote_request_id, $acc, $input_arr['accessory_desc'][$acc_index]);
						}
					}
				}
			}
			$quote_detail = $this->request_model->get_quote_request($quote_request_id);
			//$response = $this->send_tender_confirmation_email($input_arr['id_lead'],$quote_request_id);//temporary commented tanvi
			$response = true;
			if (isset($input_arr['dealer_ids']))
			{
				$dealer_ids = $input_arr['dealer_ids'];
				$dealer_id_arr = explode("-", $dealer_ids);
				foreach ($dealer_id_arr as $dealer_id)
				{
					if ($dealer_id <> 0)
					{
						$this->request_model->insert_dealer_request($quote_request_id, $dealer_id);
						//$this->templated_dealer_lead_email_init(10, $dealer_id, $input_arr['id_lead'], 'qs', 'dealer');//temporary commented email 
					}
				}				
			}
			$audit_trail_arr = array(
				'id' => $input_arr['id_lead'],
				'table_name' => 'fq_accounts_new',
				'action' => 9,
				'description' => ''
			);
			//$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);
			//$this->action_model->insert_action(1, $input_arr['id_lead'], $data['user_id'], 'Tender Started');
				
			$query = "
			SELECT m.name as `make`, f.name as `family`
			FROM makes m
			JOIN families f ON m.id_make = f.fk_make
			WHERE m.id_make = '".$input_arr['make']."' AND f.id_family = '".$input_arr['family']."'
			LIMIT 1";
			$result = $this->db->query($query);
			if (count($result->result())<>0)
			{
				foreach ($result->result() as $row)
				{
					 $make = $row->make;
					 $family = $row->family;
				}
			}
			
			$query = "
			SELECT name
			FROM vehicles
			WHERE id_vehicle = '".$input_arr['vehicle']."'
			LIMIT 1";
			$result = $this->db->query($query);
			if (count($result->result())<>0)
			{
				foreach ($result->result() as $row)
				{
					 $veriant = $row->name;
					
				}
			}
		
			$year_ar = explode("-",$input_arr['build_date']);
		 	$year = $year_ar[1];
				
			$this->db->set('year',   $year);  
			$this->db->set('make',  $make);  
			$this->db->set('modal',  $family );  
			$this->db->set('veriant',  $veriant);  
			
			$this->db->where('fq_lead_id', $input_arr['id_lead']); 
			$this->db->update('fq_lead_dealer_data');
			
			
			if($response == "success")
			{echo "success"; }
			else
			{echo "Error";}
		}
		else
		{
			echo "fail";
		}
	
	}
	public function start_tender_new () // MODAL ACTION // AUDIT TRAIL //
	{
		// echo "string";die();
		$now = date("Y-m-d H:i:s");
		$data = $this->data;
		
		
		$input_arr = $this->input->post();
		$email_content = $input_arr['start_tender_email_template_content'];
		$lead = $this->lead_model->get_lead($input_arr['id_lead']);
		
		if ($lead['qs_id']==0)
		{
			$this->lead_model->allocate_lead($input_arr['id_lead'], $data['user_id']);
			$this->lead_model->update_lead_attempt_flag($input_arr['id_lead'], 1);
		}
		// ..TEMPORARY //
		/*$vehicle_details = $this->car_model->get_vehicle($input_arr['vehicle']);
		$input_arr['series'] = $vehicle_details['series'];
		$input_arr['body_type'] = $vehicle_details['bodystyle'];
		$input_arr['transmission'] = $vehicle_details['transmission'];
		$input_arr['fuel_type'] = $vehicle_details['fueltype'];*/
		// ..TEMPORARY //
		$fq_dealer_data = array();
		$fq_dealer_data_keys = array(
		'fq_lead_id'		=> 'id_lead',
		'name'				=> 'new_lead_name',
		'surname'			=> 'new_lead_surname',
		'number'			=> 'new_lead_number',
		'email'				=> 'new_lead_email_address',
		'address'			=> 'new_lead_address',
		// 'postcode'			=> 'new_lead_postcode',
		'postcode'			=> 'postcode_ds2',
		'dl_no'				=> 'new_lead_dl_no',
		'c_card_type'		=> 'new_lead_credit_card',
		'c_card_num'		=> 'new_lead_card_no',
		'c_card_exp'		=> 'new_lead_exp_date',
		'c_card_cvv'		=> 'new_lead_cvv_no',
		'deposite_amt'		=> 'new_lead_deposit_amt',
		'year'				=> 'newLead_car_year',
		'make'				=> 'newLead_make',
		'modal'				=> 'newLead_model',
		'veriant'			=> 'newLead_car_variant',
		'redbook_url'		=> 'new_lead_redbook_url',
		'sale_price'		=> 'new_lead_sale_price',
		'winning_quote'		=> 'new_lead_winning_quote',
		'winning_trade'		=> 'new_lead_winning_trade',
		'gross_margin'		=> 'new_lead_gross_margin',
		'delivery_date'		=> 'new_lead_delivery_date',
		'dealer'			=> 'new_lead_dealer',
		'wholesaler'		=> 'new_lead_wholesaler');
		
		foreach($fq_dealer_data_keys as $fq_key=>$input_key)
		{
			$fq_dealer_data[$fq_key] = $input_arr[$input_key];
		}
		
		/*echo "<pre>";
		print_r($fq_dealer_data);
		echo "</pre>";*/
		
		$this->fapplication_model->insert_update_fq_dealer_data($fq_dealer_data,$input_arr['id_lead']);

		$insert_quote_request_result = $this->request_model->send_quote_request($input_arr, $data['user_id']);
		
		if ($insert_quote_request_result)
		{
		
			$quote_request_id = $this->db->insert_id();
				
			$this->lead_model->update_lead_status($input_arr['id_lead'], 3);
			$this->lead_model->update_lead_date($input_arr['id_lead'], $now, 'tender_date');
		
			if (isset($input_arr['options_arr']))
			{
				foreach ($input_arr['options_arr'] as $option_id)
				{
					$this->request_model->send_quote_request_option($quote_request_id, $option_id);
				}
			}
			if (isset($input_arr['accessory_name']))
			{
				$accessories = $input_arr['accessory_name'];
				$accessories = array_filter($accessories);
				$old_acc = array();
				foreach ($accessories as $acc_index => $acc)
				{
					if(!in_array($acc, $old_acc)) {
						array_push($old_acc, $acc);
						if($acc != '@@@') {
							$this->request_model->send_quote_request_accessory($quote_request_id, $acc, $input_arr['accessory_desc'][$acc_index]);
						}
					}
				}
			}
	
			$quote_detail = $this->request_model->get_quote_request($quote_request_id);
			
			if (isset($input_arr['dealer_ids']))
			{
				$dealer_ids = $input_arr['dealer_ids'];
				$dealer_id_arr = explode("-", $dealer_ids);
				foreach ($dealer_id_arr as $dealer_id)
				{
					if ($dealer_id <> 0)
					{
						$this->request_model->insert_dealer_request($quote_request_id, $dealer_id);
						//$this->templated_dealer_lead_email_init(10, $dealer_id, $input_arr['id_lead'], 'qs', 'dealer');//temporary commented email 
					}
				}				
			}
			$audit_trail_arr = array(
				'id' => $input_arr['id_lead'],
				'table_name' => 'fq_accounts_new',
				'action' => 9,
				'description' => ''
			);
			$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);
			$this->action_model->insert_action(1, $input_arr['id_lead'], $data['user_id'], 'Tender Started');
				
			$query = "
			SELECT m.name as `make`, f.name as `family`
			FROM makes m
			JOIN families f ON m.id_make = f.fk_make
			WHERE m.id_make = '".$input_arr['make']."' AND f.id_family = '".$input_arr['family']."'
			LIMIT 1";
			$result = $this->db->query($query);
			if (count($result->result())<>0)
			{
				foreach ($result->result() as $row)
				{
					 $make = $row->make;
					 $family = $row->family;
				}
			}
			
			$query = "
			SELECT name
			FROM vehicles
			WHERE id_vehicle = '".$input_arr['vehicle']."'
			LIMIT 1";
			$result = $this->db->query($query);
			if (count($result->result())<>0)
			{
				foreach ($result->result() as $row)
				{
					 $veriant = $row->name;
					
				}
			}
		
			$year_ar = explode("-",$input_arr['build_date']);
		 	$year = $year_ar[1];
				
				$this->db->set('year',   $year);  
				$this->db->set('make',  $make);  
				$this->db->set('modal',  $family );  
				$this->db->set('veriant',  $veriant);  
				
				$this->db->where('fq_lead_id', $input_arr['id_lead']); 
				$this->db->update('fq_lead_dealer_data');
			
			$response = $this->send_tender_confirmation_email($input_arr['id_lead'],$quote_request_id,$email_content);//temporary commented tanvi
			if($response == "success")
			{echo "success"; }
			else
			{echo "Error";}
		}
		else
		{
			echo "fail";
		}
	}
	public function computation_save()
	{
		$post = $this->input->post();
		
		/* For Account Table */
		$lead_id = $post['id_lead'];
		
		/* For Delivery */
		$delivery = array();
		$delivery['delivery_instructions'] = $post['delivery_instructions'];
		$delivery['delivery_address'] = $post['lead_address_comp'];
		$delivery['special_conditions'] = $post['special_conditions'];
		$delivery['sale_price'] = $post['new_lead_sale_price_comp'];
		$delivery['delivery_date'] = $post['delivery_date_comp'];
		$delivery['deposite'] = $post['deposite'];

		$res = $this->fapplication_model->delivery_details_for_computation($lead_id, $delivery);

	
		$computation = array(
			'lead_id'=>$post['id_lead'],
			'new_lead_sale_price_comp' => $post['new_lead_sale_price_comp'],
			'delivery_date_comp' => $post['delivery_date_comp'],
			'delivery_instructions' => $post['delivery_instructions'],
			'lead_address_comp' => $post['lead_address_comp'],
			'method_of_purchase' => $post['method_of_purchase'],
			'special_conditions' => $post['special_conditions'],
			'include_dealer' => $post['include_dealer'],
			'trade_include' => $post['trade_include'],
			'valuer_name_comp'=> $post['valuer_name_comp'],
			'valuation_comp'=> $post['valuation_comp'],
			'trade_valuation_sel'=> $post['trade_valuation_sel'],
			'tradein_valuaton'=> $post['tradein_valuaton'],
			'trade_payout'=> $post['trade_payout'],
			'aftermarket_product'=> $post['aftermarket_product'],
			'aftermarket_product_cost'=> $post['aftermarket_product_cost'],
			'aftermarket_sale_price'=> $post['aftermarket_sale_price'],
			'aftermarket_revenue'=> $post['aftermarket_revenue'],
			'origination_fee_comp'=> $post['origination_fee_comp'],
			'origination_revenue_comp'=> $post['origination_revenue_comp'],
			'brokerage_gross_comp'=> $post['brokerage_gross_comp'],
			'brokerage_revenue_comp'=> $post['brokerage_revenue_comp'],
			'finance_revenue_comp'=> $post['finance_revenue_comp'],
			'dealer_balco'=> $post['dealer_balco'],
			'client_balco'=> $post['client_balco'],
			'finquote_balco'=> $post['finquote_balco'],
			'total_gross_revenue'=> $post['total_gross_revenue'],
			'commissionable_gross'=> $post['commissionable_gross'],
			'net_revenue'=>$post['net_revenue'],
			'deposite'=>$post['deposite'],
			'invoice_to'=>$post['invoice_to'],
			);
		$this->db->where('lead_id',$post['id_lead']);
		$checkExist = $this->db->get('computation');
		if ($checkExist->num_rows() == 0){
		
			$this->db->insert('computation', $computation);
		}else{
			$this->db->where('lead_id',$post['id_lead']);
			$this->db->update('computation', $computation);
		}
	
		$response = array();
		if($res) {
			$response['success'] = true;
			$response['message'] = "Computation Saved Successfully";
		}
		else {
			$response['success'] = false;
			$response['message'] = "Something went wrong!";
		}
		echo json_encode($response);
		/* For Account Table */
		
	}
	public function resend_vehicle_confirmation()
	{
		// echo "string"; die();
		$post_data = $this->input->post();
		$lead_id = $post_data['id_lead'];
		$quote_request_id = $post_data['id_quote_request'];
		$email_content = $post_data['send_email_template_content'];
		$response = $this->send_tender_confirmation_email($lead_id,$quote_request_id,$email_content);
		if($response == "success") {
			echo "success"; 
		} else {
			echo "Error";
		}
	}

    public function send_tender_confirmation_email ($lead_id,$quote_request_id,$email_content='')
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;
		$lead = $this->lead_model->get_lead($lead_id);
		$content = $email_content;
		$email_recipients = "";
		if (trim($lead['lead_email']) <> "")
		{
			$email_recipients .= $lead['lead_email'];
		}
		
		// if (trim($lead['alternate_email_1']) <> "")
		// {
		// $email_recipients .= ",".$lead['alternate_email_1'];
		// }
		
		// if (trim($lead['alternate_email_2']) <> "")
		// {
		// $email_recipients .= ",".$lead['alternate_email_2'];
		// }
		//echo $email_recipients;
		if ($email_recipients <> "")
		{	//echo $lead['qs_email'];
			
			if($email_recipients == 'paul@finquote.com.au') {
				// $email_recipients = 'devakshay89@gmail.com';
			}
			
			/*echo $email_recipients;
			die();*/
			$subject = str_replace('| Broker CRM', '', $data['company']['company_name']).": New Vehicle Confirmation";
			//$subject = $data['company']['company_name'].': Tender Confirmation Email ('.$cq_number.')'
			$return = $this->mm_lead_send_templated_email($lead['qs_email'], $lead['qs_name'], $email_recipients,$subject , $content);
			
			$audit_trail_arr = array(
				'id' => $lead['id_fq_account'],
				'table_name' => 'leads',
				'action' => 41,
				'description' => ''
			);
			$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);
			$this->action_model->insert_action(1, $lead['id_fq_account'], $data['user_id'], 'Resent Tender Confirmation');
			if($return == 1){
				$trail_array = [
					'fk_user'    => $data['user_id'],
					'fk_account' => $lead_id,
					'sent_to'    => $email_recipients,
					'subject'    => $subject,
					'message'    => $content,
					'created_at' => date('Y-m-d H:i:s')
				];
				$this->fapplication_model->email_audit_trail_model($trail_array);
				return "success";
			}else{
				return "Error";
			}		
		}
	}

	
	
	public function remind_dealers_new () // BUTTON ACTION // AUDIT TRAIL //
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;
		
		$input_arr = $this->input->post();
		$remind_dealer_result = $this->request_model->update_quote_request_reminder($input_arr['id_quote_request']);
		if ($remind_dealer_result)
		{
			$remind_dealers = $this->user_model->get_remind_dealers($input_arr['id_quote_request']);
			foreach ($remind_dealers as $remind_dealer)
			{
				//$this->templated_dealer_lead_email_init(12, $remind_dealer->id_user, $input_arr['id_lead'], 'company', 'dealer');//temporary commented mail 
			}
			$audit_trail_arr = array(
				'id' => $input_arr['id_lead'],
				'table_name' => 'leads',
				'action' => 12,
				'description' => ''
			);
			$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);
			$this->action_model->insert_action(1, $input_arr['id_lead'], $data['user_id'], 'Reminded Dealers to Quote');
			echo "success";
		}
		else
		{
			echo "fail";
		}
	}
	
	public function check(){

		$requirements = $this->lead_model->get_deal_requirements('977');
	
		$this->db->select('*');
		$this->db->from('computation');
		$this->db->where('lead_id', '977' );
		$computataion_data = $this->db->get()->result_array();
		$computation_data = $computataion_data[0];

		print_r($computation_data);

		$error_arr = [];
		$warning_arr = [];
		 if ($requirements['winning_quote'] == 0 OR $requirements['winning_quote'] == "" OR $requirements['winning_quote'] == null )
		{
			$error_arr[] = 'No winning quote selected';
		}
		
		
		if ($computation_data['delivery_date_comp'] == "" OR ($requirements['delivery_address'] == "" AND $requirements['delivery_address_map']==0))
		{
			$error_arr[] = 'Delivery details is incomplete';
		}
	
		
		if ($computation_data['delivery_date_comp'] < $requirements['order_date'])
		{
			$error_arr[] = 'Delivery cannot be before Order Date. Please check the delivery date';
		}
		
		if ($computation_data['deposite'] == 0 OR $computation_data['deposite'] == "")
		{
			$error_arr[] = 'Deposit type is not indicated';
		}
		
		print_r($error_arr);
	}
	public function deal_requirements ($lead_id)
	{
		$requirements = $this->lead_model->get_deal_requirements($lead_id);
	
		$this->db->select('*');
		$this->db->from('computation');
		$this->db->where('lead_id', $lead_id );
		$computataion_data = $this->db->get()->result_array();
		$computation_data = $computataion_data[0];

		$error_arr = [];
		$warning_arr = [];
		 if ($requirements['winning_quote'] == 0 OR $requirements['winning_quote'] == "" OR $requirements['winning_quote'] == null )
		{
			$error_arr[] = 'No winning quote selected';
		}
		
		// if ($requirements['attached_tradein_count'] > 0 AND ($requirements['tradein_buyer'] == "" OR $requirements['tradein_buyer'] == 0 OR $requirements['tradein_buyer'] == null))
		// {
			// $error_arr[] = 'No nominated buyer of the tradein';
		// }		
		
		/*if ($requirements['delivery_date'] == "" OR ($requirements['delivery_address'] == "" AND $requirements['delivery_address_map']==0))
		{
			$error_arr[] = 'Delivery details is incomplete';
		}*/
		if ($computation_data['delivery_date_comp'] == "" OR ($requirements['delivery_address'] == "" AND $requirements['delivery_address_map']==0))
		{
			$error_arr[] = 'Delivery details is incomplete';
		}
		
		// if ($requirements['lead_name'] == "" OR $requirements['lead_email'] == "" OR $requirements['lead_state'] == "" OR $requirements['lead_postcode'] == "" )
		// {
			// $error_arr[] = 'Client details is incomplete';
		// }
		
		if ($computation_data['delivery_date_comp'] < $requirements['order_date'])
		{
			$error_arr[] = 'Delivery cannot be before Order Date. Please check the delivery date';
		}
		
		// if ($requirements['suggested_tradein_count'] > $requirements['attached_tradein_count'])
		// {
			// $warning_arr[] = 'There are suggested tradeins that are not attached to the deal';
		// }
		// if (($requirements['lead_state'] == "ACT" AND $requirements['answer_act'] == "")
				// OR ($requirements['lead_state'] == "VIC" AND $requirements['answer_vic'] == "")
				// OR ($requirements['lead_state'] == "QLD" AND $requirements['answer_qld'] == ""))
		// {	
			// $error_arr[] = 'Vehicle type is not indicated';
		// }
		
		if ($computation_data['deposite'] == 0 OR $computation_data['deposite'] == "")
		{
			$error_arr[] = 'Deposit type is not indicated';
		}
		
		/*if ($requirements['transport'] == 0 OR $requirements['transport'] == "")
		{
			$error_arr[] = 'Transport type is not indicated';
		}*/
		
		$output_arr = array(
			"errors" => $error_arr,
			"warnings" => $warning_arr
		);
//echo json_encode($requirements); die();
		return $output_arr;
	}
	
	public function update_dealer_sheet(){
		//$this->db->select("company,address");
		$this->db->select("*");
		$this->db->from('sheet_dealers');
		$this->db->where('latlng IS NOT NULL', null, false);
		//$this->db->limit('10',$page);
		$query = $this->db->get();
		foreach($query->result_array() as $row){
			echo '<pre>';
			//print_r($row['latlng']);
			$pieces = explode(" ", $row['latlng']);
			if(isset($pieces[0]) && isset($pieces[1])){
				echo 'UPDATE `sheet_dealers` SET `lat`= "';
				echo rtrim($pieces[0],',');
				echo '",`lon`= "';
				echo $pieces[1];
				echo '" WHERE `id` = ';
				echo $row['id'];
				echo ';<br>';
			}
			
			//echo '';echo '<pre>';print_r($row);
		
		}exit();
		echo '<pre>';print_r($query->result_array());exit();
	}
	public function get_dealer_sheet(){
		$data = $_POST;
		$page  =  $data['page'];
		if(isset($data['lat']) && isset($data['lng'])){
			$lat  =  $data['lat'];
			$lng  =  $data['lng'];
		}else{
			$lng = 151.209900;
			$lat = -33.865143;
		}
		$num = 111.045;
		/*$this->db->select("company,address");
		$this->db->from('sheet_dealers');
		$this->db->where('latlng IS NOT NULL', null, false);
		$this->db->limit('10',$page);
		$query = $this->db->get();*/
		
		$sql = "SELECT `company`, `latlng`, `address`, 111.045 * DEGREES(ACOS(COS(RADIANS(".$lat.")) * COS(RADIANS(lat)) * COS(RADIANS(lon) - RADIANS(".$lng.")) + SIN(RADIANS(".$lat.")) * SIN(RADIANS(lat)))) AS distance_in_km FROM `sheet_dealers` WHERE latlng !=''  AND latlng IS NOT NULL ORDER BY distance_in_km ASC ";
		//$sql .= "LIMIT 6";
		$sql .= "LIMIT ".$page.", 3";
		$query = $this->db->query($sql);
		//echo $this->db->last_query();
		echo json_encode($query->result_array());
	}
	
  public function record ($id)
  {		
    $flags = [];
		$data = $this->data;
		//$dealer_sheet_data = $this->get_dealer_sheet();
		$dat = $this->action_model->insert_action(3, $id, $data['user_id'], 'Opened the Application');
		
		$admins = $this->user_model->get_admins();
		$audit_trail_arr = array(
			'id' => $id,
			'table_name' => 'fq_accounts_new',
			'action' => 29,
			'description' => ''
		);
		
		$query_str_po = "SELECT * FROM  post_instapage_data  WHERE lead_id = '".$id."' LIMIT 1";
		$query_po = $this->db->query($query_str_po);
        $insta_data = $query_po->row_array();
		if(!empty($insta_data)){
			$insta_data['finance'] = $insta_data['finance'];
			$insta_data['page_url'] = $insta_data['page_url'];
            $insta_data['model'] = $insta_data['model'];
            $insta_data['variant'] = $insta_data['variant'];
			$insta_data['date'] = date('m-d-Y h:i:s',strtotime($insta_data['date']));
    }else{
			$insta_data['finance'] = '';
            $insta_data['page_url'] = '';
            $insta_data['model'] = '';
            $insta_data['variant'] = '';
			$insta_data['date'] = '';
			
    }
		
		//print_r( $insta_data);exit;
		
		//*-----------------------------Lead Data---------------------------------***
		$lead = $this->lead_model->get_lead($id);

		//print_r($lead);
	
		$accessories = '';
		if(isset($lead['id_quote_request']) && !empty($lead['id_quote_request'])){
			$accessories_arr = array();
			$accessories_data = $this->request_model->get_accessories($lead['id_quote_request']);
			foreach($accessories_data as $key => $accessory){
				$accessories_arr[$key] = $accessory->name;
			}
			if(!empty($accessories_arr)){
				$accessories = implode(', ', $accessories_arr);
			}			
		}else{
			$accessories = '';
		}
		
		if($insta_data['date']=="")
		{
			$insta_data['date'] = $lead['created_at'];
		}
		
  	$query_str = "SELECT * FROM `rb_data`  WHERE car_id = '".$lead['rb_data']."' LIMIT 1";
		$query = $this->db->query($query_str);
    $rb_data_row = $query->row_array();
      
    if(!empty($rb_data_row)){
      $rb_data_row['des'] = unserialize($rb_data_row['des']);
			$rb_data_row['registration_type'] = $lead['registration_type'];
			$rb_data_row['colour'] = $lead['colour'];
			//echo '<pre>';print_r($rb_data_row);exit;
			
    }else{
			$rb_data_row['name'] = '';
			$rb_data_row['price'] = '';
			$rb_data_row['month'] = '';
			$rb_data_row['year'] = '';
      $rb_data_row['des'] = array();
			$rb_data_row['registration_type']= '';
			$rb_data_row['colour']= '';
    }
	
		//print_r($lead);
		//*-------------------------------------------------------------*/
		$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);
		$this->action_model->insert_action(1, $id, $data['user_id'], 'Opened the Lead');
		// Requirements //
		$lead_call_status = $this->lead_model->get_lead_call_status(); // M Array
		$next_lead = $this->lead_model->get_next_lead_id($id, $data['user_id']); // S Array
		$previous_lead = $this->lead_model->get_previous_lead_id($id, $data['user_id']);
		$lead = $this->lead_model->get_lead($id);
		$lead_attached_tradeins = $this->lead_model->get_lead_attached_tradeins($id);
		//echo json_encode($lead_attached_tradeins); die();
		//echo count($lead_attached_tradeins); die();
		
		$lead_calculation_details = $this->calculate_revenue($lead);
		//echo json_encode($lead_calculation_details); die();
		$lead_files = $this->lead_model->get_lead_files($id);
		$lead_dealer_files = $this->lead_model->get_dealer_files($id);
		$lead_comments = $this->lead_model->get_lead_comments($id);
		$lead_invoices = $this->invoice_model->get_lead_invoices($id);
		//echo json_encode($lead_invoices); die();
		$lead_payments = $this->payment_model->get_lead_payments($id);
		$lead_call_logs = $this->lead_model->get_lead_call_logs($id);
		$lead_events = $this->lead_model->get_lead_events(array('fk_lead' => $id, 'status' => 0));
		$lead_aftersales_accessories = $this->lead_model->get_deal_accessories($id); // M Array
	
		$audit_trail_params = array(
			'id' => $id,
			'table_name' => 'fq_accounts_new'
		);
		$lead_audit_trails = $this->audit_model->get_audit_trails($audit_trail_params); // M Array
		
		$lead_emails = array();
		// foreach ($admins AS $admin)
		// {			
			// if ($admin->username == $lead['lead_email'])
			// {
				// $lead_emails = [];
			// }
		// }
		
		$data['make_logo'] = "http://www.myelquoto.com.au/global_images/makes/".str_replace(' ', '_', strtolower($lead['make'])).".png";
		
		$data['lead_call_status'] = $lead_call_status;
		$data['bank_accounts'] = $this->settings_model->get_bank_accounts();
		
		$data['lead'] = $lead;
		//traid in
		$data['title'] = 'Trade-In';
		$tradein = $this->tradein_model->get_tradein($id);
		if($tradein & $lead)
		{
			$user_trade_valuation = $this->tradein_model->get_user_tradein_valuation($tradein['id_tradein'], $data['user_id']);
			// $trade_valuations = $this->tradein_model->get_tradein_valuations($id);
			$trade_valuations = $this->tradein_model->get_tradein_valuations($tradein['id_tradein']);
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
				//$lead = $this->lead_model->get_lead($tradein['fk_lead']);
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
		
			//end traid in
			//echo json_encode($data); die();
		
			$traidin ='';
			$traidin ='<div id="accordion">
				<div class="panel panel-accordion panel-accordion-first"> 
				<form>
					<div class="panel-heading" style="border-bottom: 1px solid #ddd;">
						<h4 class="panel-title">
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse_1">
								<b>'.$tradein['tradein_make']." ".$tradein['tradein_model'].'</b>
							</a>
						</h4>
					</div>
					<div id="collapse_1" class="accordion-body collapse in">
						<div class="panel-body">
							<div class="row"> <!-- Tradein Summary -->
								<div class="col-sm-12">
									<h5 style="color: #58c603"><b></b></h5>
									<p></p>';
									
									if ($tradein['image_1']=="") { $tradein['image_1'] = "no_image.png"; }
									if ($tradein['image_2']=="") { $tradein['image_2'] = "no_image.png"; }
									if ($tradein['image_3']=="") { $tradein['image_3'] = "no_image.png"; }
									if ($tradein['image_4']=="") { $tradein['image_4'] = "no_image.png"; }														
									
									$traidin .='<div class="row"> <!-- Tradein Images -->
										<div class="col-sm-3">
											<a href="http://www.mytradevaluation.com.au/uploads/thumbnails_m/'.$tradein['image_1'].'" target="_blank"><img alt="Tradein Image 1" height="300" class="img-responsive" src="http://www.mytradevaluation.com.au/uploads/thumbnails_m/'.$tradein['image_1'].'"></a>
										</div>
										<div class="col-sm-3">
											<a href="http://www.mytradevaluation.com.au/uploads/thumbnails_m/'.$tradein['image_2'].'" target="_blank"><img alt="Tradein Image 2" height="300" class="img-responsive" src="http://www.mytradevaluation.com.au/uploads/thumbnails_m/'.$tradein['image_2'].'"></a>
										</div>
										<div class="col-sm-3">
											<a href="http://www.mytradevaluation.com.au/uploads/thumbnails_m/'.$tradein['image_3'].'" target="_blank"><img alt="Tradein Image 3" height="300" class="img-responsive" src="http://www.mytradevaluation.com.au/uploads/thumbnails_m/'.$tradein['image_3'].'"></a>
										</div>
										<div class="col-sm-3">
											<a href="http://www.mytradevaluation.com.au/uploads/thumbnails_m/'.$tradein['image_4'].'" target="_blank"><img alt="Tradein Image 4" height="300" class="img-responsive" src="http://www.mytradevaluation.com.au/uploads/thumbnails_m/'.$tradein['image_4'].'"></a>
										</div>
									</div>';
									if ($data['login_type']=="Admin")
									{
										
										$traidin .='<div class="row" style="margin-top: 20px;"> <!-- Tradein Valuations -->
											<div class="col-sm-12">
												<div class="table-responsive">
													<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
														<thead>
															<tr>
																<td><center><i class="fa fa-trash-o"></i></center></td>
																<td><center><i class="fa fa-trophy"></i></center></td>
																<td>Name</td>
																<td>Value</td>
																<td>Date</td>
															</tr>
														</thead>
														<tbody id="tradein_valuations">';
														if (count($trade_valuations)==0)
															{
																$traidin .='<tr id="norecords">
																	<td colspan="5"><center><i>No valuations found!</i></center></td>
																</tr>';
																
															}
															else
															{
																foreach ($trade_valuations AS $trade_valuation)
																{
																	$traidin .='<tr>
																		<td>
																			<center>
																				<!--
																				<span class="ajax_button_primary delete_trade_valuation_button" data-id_tradein="'.$tradein['id_tradein'].'" data-id_trade_valuation="'.$trade_valuation['id_trade_valuation'].'">
																					<i class="fa fa-trash-o"></i>
																				</span>
																				-->
																				<i class="fa fa-trash-o"></i>
																			</center>
																		</td>';
																		if ($tradein['fk_trade_valuation']==$trade_valuation['id_trade_valuation']) 
																		{
																			$traidin .='<td align="center">
																				<i class="fa fa-trophy"></i>							
																			</td>';
																			
																		}
																		else
																		{
																			
																			$traidin .='<td align="center">
																				<span class="ajax_button_primary select_winning_trade_valuation_button" data-id_tradein="'.$tradein['id_tradein'].'" data-id_trade_valuation="'.$trade_valuation['id_trade_valuation'].'">
																					<i class="fa fa-trophy"></i>
																				</span>
																			</td>';
								
																		}
																		
																		$traidin .='<td><a href="'.site_url('user/record/'.$trade_valuation['id_user']).'">'.$trade_valuation['name'].'</a></td>
																		<td>'.$trade_valuation['value'].'</td>
																		<td>'.$trade_valuation['created_at'].'</td>
																	</tr>';
																	
																}
																
															}
														$traidin .='</tbody>
													</table>
												</div>
											</div>
										</div>';
										
									}
									else
									{
										if ($user_trade_valuation_id==0)
										{
											
											$traidin .='<div class="row" style="margin-top: 20px;">
												<div class="col-sm-12">
													<div class="alert alert-danger">
														You havent valued this vehicle yet!
														<br />
														<br />
														<span class="btn btn-danger btn-sm ajax_button add_trade_valuation_modal_button" data-id_tradein="'.$tradein['id_tradein'].'">
															<i class="fa fa-dollar"></i>&nbsp; VALUE THIS CAR
														</span>
													</div>
												</div>
											</div>';
											
										}
										else
										{
											
											$traidin .='<div class="row" style="margin-top: 20px;">
												<div class="col-sm-12">
													<div class="alert alert-danger">
														Thank you for sending your valuation!
														<br />
														<br />
														<span class="btn btn-danger btn-sm ajax_button edit_trade_valuation_modal_button" data-id_tradein="'.$tradein['id_tradein'].'" data-id_trade_valuation="'. $user_trade_valuation_id.'">
															<i class="fa fa-dollar"></i>&nbsp; CHANGE VALUE
														</span>																			
													</div>
												</div>
											</div>';
										}
									}
								$traidin .='</div>
							</div>
							<br />
						</div>
					</div>';
				
				if ($data['login_type'] != "Admin")
				{
					$details_disabled = 'disabled="disabled"';
				}
				else
				{
					$details_disabled = '';
				}
				
				if ($data['login_type']=="Admin")
				{	
					$traidin .='<div class="panel-footer panel-footer-btn-group"> <!-- Actions -->
						<a href="#" style="border-top: 1px solid #ddd;" class="add_trade_valuation_modal_button" data-id_tradein="'.$tradein['id_tradein'].'">
							<i class="fa fa-dollar mr-xs"></i> Add Valuation
						</a>
						<a href="'.site_url('tradein/pdf_export/'.$tradein['id_tradein']).'" target="_blank" style="border-top: 1px solid #ddd;">
							<i class="fa fa-file-pdf-o"></i> PDF Export
						</a>
						<a href="#" style="border-top: 1px solid #ddd;" class="forward_pdf_modal_button" data-id_tradein="'.$tradein['id_tradein'].'">
							<i class="fa fa-envelope mr-xs"></i> Forward PDF
						</a>
					</div>
					</form>';
					
				}
				
			$traidin .='</div>
			<section class="panel">
                <form method="post" id="details_form" name="details_form" action="">
                    <input type="hidden" name="id_tradein" value="'.$tradein['id_tradein'].'" id="trade" />
                        <div id="vehicle_details"> <!-- Vehicle Details -->
                            <div class="row" style="margin-top: 30px;">
                                <div class="col-md-12">
                                    <h5><b>Vehicle Details</b></h5>
                                    <hr class="solid mt-sm mb-lg">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Registration Plate:</label><br />
                                    <input value="'.$tradein['registration_plate'].'" class="text-line" id="registration_plate" name="registration_plate" type="text" '.$details_disabled.'>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Rego Expiry:</label><br />
                                        <input value="'.$tradein['rego_expiry'].'" class="text-line" id="rego_expiry" name="rego_expiry" type="text" '.$details_disabled.'>
                                    </div>
                                </div>					
                            </div>
                            <div class="row" style="margin-top: 10px;">														
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">VIN:</label><br />
                                        <input value="'.$tradein['tradein_vin'].'" class="text-line" id="tradein_vin" name="tradein_vin" type="text" '.$details_disabled.'>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Engine Number:</label><br />
                                        <input value="'.$tradein['tradein_eng'].'" class="text-line" id="tradein_eng" name="tradein_eng" type="text" '.$details_disabled.'>
                                    </div>
                                </div>														
                            </div>										
                            <div class="row" style="margin-top: 40px;">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Make:</label><br />
                                        <input value="'.$tradein['tradein_make'].'" class="text-line" id="tradein_make" name="tradein_make" type="text" '.$details_disabled.'>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Model:</label><br />
                                        <input value="'. $tradein['tradein_model'].'" class="text-line" id="tradein_model" name="tradein_model" type="text"'. $details_disabled.'>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Variant:</label><br />
                                        <input value="'.$tradein['tradein_variant'].'" class="text-line" id="tradein_variant" name="tradein_variant" type="text" '.$details_disabled.'>
                                    </div>
                                </div>														
                            </div>
                            <div class="row" style="margin-top: 10px;">												
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Build Date:</label><br />
                                    <input value="'.$tradein['tradein_build_date'].'" class="text-line" id="tradein_build_date" name="tradein_build_date" type="text" '.$details_disabled.'>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Compliance Date:</label><br />
                                        <input value="'.$tradein['tradein_compliance_date'].'" class="text-line" id="tradein_compliance_date" name="tradein_compliance_date" type="text" '. $details_disabled.'>
                                    </div>
                                </div>		
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Kms:</label><br />
                                        <input value="'.$tradein['tradein_kms'].'" class="text-line" id="tradein_kms" name="tradein_kms" type="text" '.$details_disabled.'>
                                    </div>
                                </div>														
                            </div>
                            <div class="row" style="margin-top: 10px;">												
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Fuel Type:</label><br />
                                        <input value="'.$tradein['tradein_fuel_type'].'" class="text-line" id="tradein_fuel_type" name="tradein_fuel_type" type="text" '.$details_disabled.'>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Body Shape:</label><br />
                                        <input value="'.$tradein['tradein_body_type'].'" class="text-line" id="tradein_body_type" name="tradein_body_type" type="text" '.$details_disabled.'>
                                    </div>
                                </div>		
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Colour:</label><br />
                                        <input value="'.$tradein['tradein_colour'].'" class="text-line" id="tradein_colour" name="tradein_colour" type="text"'.$details_disabled.'>
                                    </div>
                                </div>														
                            </div>													
                            <div class="row" style="margin-top: 10px;">												
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Drive Type:</label><br />
                                        <input value="'.$tradein['tradein_drive_type'].'" class="text-line" id="tradein_drive_type" name="tradein_drive_type" type="text"'.$details_disabled.'>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Transmission:</label><br />
                                        <input value="'.$tradein['tradein_transmission'].'" class="text-line" id="tradein_transmission" name="tradein_transmission" type="text"'.$details_disabled.'>
                                    </div>
                                </div>														
                            </div>		
                            <div class="row" style="margin-top: 30px;">												
                                <div class="col-sm-12">		
                                    <div class="form-group">
                                        <label class="control-label">Vehicle Options:</label><br />														
                                        <input value="'.$tradein['options_1'].'" class="text-line" id="options_1" name="options_1" type="text" '.$details_disabled.'>
                                    </div>
                                </div>
                            </div>						
                            <div class="row" style="margin-top: 30px;">												
                                <div class="col-sm-12">		
                                    <div class="form-group">
                                        <label class="control-label">Accessories:</label><br />														
                                        <input value="'.$tradein['accessories_1'].'" class="text-line" id="accessories_1" name="accessories_1" type="text" '. $details_disabled.'>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 30px;">
                                <div class="col-sm-9">		
                                    Warning lights while vehicle is running?
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <select class="text-line" id="warning_lights" name="warning_lights" '. $details_disabled.'>
                                            <option value=""></option>
                                            <option value="Yes"'; 
                                                if($tradein["warning_lights"]=="Yes"){
                                                    $traidin .='selected';
                                                } 
                                            $traidin .='>Yes</option>';
                                            $traidin .='<option value="No"'; 
                                                if($tradein["warning_lights"]=="No"){
                                                    $traidin .='selected';
                                                } 
                                            $traidin .='>No</option>';
                                        $traidin .='</select>
                                    </div>
                                </div>
                            </div>	
                            <div class="row" style="margin-top: 30px;">
                                <div class="col-sm-9">		
                                    Is there existing damage on the vehicle?
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <select class="text-line" id="damage" name="damage" '. $details_disabled.'>
                                            <option value=""></option>
                                            <option value="Yes"'; 
                                                if($tradein["damage"]=="Yes"){
                                                    $traidin .='selected';
                                                } 
                                            $traidin .='>Yes</option>';
                                            $traidin .='<option value="No"'; 
                                                if($tradein["damage"]=="No"){
                                                    $traidin .='selected';
                                                } 
                                            $traidin .='>No</option>';
                                        $traidin .='</select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 30px;">
                                <div class="col-sm-9">		
                                    Was your vehicle ever a lease or rental?
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <select class="text-line" id="lease" name="lease" '. $details_disabled.'>
                                            <option value=""></option>
                                            <option value="Yes"'; 
                                            if($tradein["lease"]=="Yes"){
                                                $traidin .='selected';
                                            } 
                                            $traidin .='>Yes</option>';
                                            $traidin .='<option value="No"'; 
                                            if($tradein["lease"]=="No"){
                                                $traidin .='selected';
                                            } 
                                            $traidin .='>No</option>';
                                        $traidin .='</select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 30px;">
                                <div class="col-sm-9">		
                                    Did you buy the vehicle new?
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <select class="text-line" id="bought_new" name="bought_new" '. $details_disabled.'>
                                            <option value=""></option>
                                            <option value="Yes"'; 
                                            if($tradein["bought_new"]=="Yes"){
                                                $traidin .='selected';
                                            } 
                                                $traidin .='>Yes</option>';
                                                $traidin .='<option value="No"'; 
                                            if($tradein["bought_new"]=="No"){
                                                $traidin .='selected';
                                            } 
                                            $traidin .='>No</option>';
                                        $traidin .='</select>
                                    </div>
                                </div>
                            </div>							
                            <div class="row" style="margin-top: 30px;">
                                <div class="col-sm-9">		
                                    Do all the options & accessories work?
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">										
                                        <select class="text-line" id="accessories_working" name="accessories_working" '. $details_disabled.'>
                                            <option value=""></option>
                                            <option value="Yes"'; 
                                                if($tradein["accessories_working"]=="Yes"){
                                                    $traidin .='selected';
                                                } 
                                            $traidin .='>Yes</option>';
                                            $traidin .='<option value="No"'; 
                                                if($tradein["accessories_working"]=="No"){
                                                    $traidin .='selected';
                                                } 
                                            $traidin .='>No</option>';
                                        $traidin .='</select>
                                    </div>
                                </div>
                            </div>								
                            <div class="row" style="margin-top: 30px;">
                                <div class="col-sm-9">		
                                    Has vehicle ever been in any accident?
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">										
                                        <select class="text-line" id="accident" name="accident" '. $details_disabled.'>
                                            <option value=""></option>
                                            <option value="Yes"'; 
                                                if($tradein["accident"]=="Yes"){
                                                    $traidin .='selected';
                                                } 
                                            $traidin .='>Yes</option>';
                                            $traidin .='<option value="No"'; 
                                                if($tradein["accident"]=="No"){
                                                    $traidin .='selected';
                                                } 
                                            $traidin .='>No</option>';
                                        $traidin .='</select>
                                    </div>
                                </div>
                            </div>								
                            <div class="row" style="margin-top: 30px;">
                                <div class="col-sm-9">		
                                    Has vehicle ever had any paint work?
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <select class="text-line" id="paint_work" name="paint_work" '. $details_disabled.'>
                                            <option value=""></option>
                                            <option value="Yes"'; 
                                                if($tradein["paint_work"]=="Yes"){
                                                    $traidin .='selected';
                                                } 
                                            $traidin .='>Yes</option>';
                                            $traidin .='<option value="No"'; 
                                                if($tradein["paint_work"]=="No"){
                                                    $traidin .='selected';
                                                } 
                                            $traidin .='>No</option>';
                                        $traidin .='</select>
                                    </div>
                                </div>
                            </div>								
                            <div class="row" style="margin-top: 30px;">												
                                <div class="col-sm-12">		
                                    <div class="form-group">
                                        <label class="control-label">Service History:</label><br />														
                                        <textarea class="form-control input-sm" id="tradein_service_history" name="tradein_service_history" '.$details_disabled.'>'.$tradein['tradein_service_history'].'</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 10px;">												
                                <div class="col-sm-12">		
                                    <div class="form-group">
                                        <label class="control-label">Other Information:</label><br />														
                                        <textarea class="form-control input-sm" id="other_info" name="other_info" '.$details_disabled.'>'.$tradein['other_info'].'</textarea>
                                    </div>
                                </div>
                            </div>
                            <br />';
                            if ($data['login_type'] == "Admin")
                            {
                                $traidin .='<div class="row" style="margin-top: 10px;">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save"></i> Save
                                        </button>								
                                    </div>
                                </div>';
                            }
                        $traidin .='</div></form>
                        </section>';
            $traidin .='</div>';
	
		}
		
		//echo json_encode($traidin); die();
	
		if (isset($previous_lead['id_fq_account']))
		{
			$data['previous_lead_id'] = $previous_lead['id_fq_account'];
		}
		else
		{
			$data['previous_lead_id'] = "";
		}
		
		if (isset($next_lead['id_fq_account']))
		{
			$data['next_lead_id'] = $next_lead['id_fq_account'];
		}
		else
		{
			$data['next_lead_id'] = "";
		}	
		$data['lead_calculation_details'] = $lead_calculation_details;
		$data['lead_comments'] = $lead_comments;
		$data['lead_aftersales_accessories'] = $lead_aftersales_accessories;
		$data['lead_emails'] = $lead_emails;
	
		//	$data['lead_invoices'] = $lead_invoices;
		$data['lead_payments'] = $lead_payments;
		$data['lead_audit_trails'] = $lead_audit_trails;
		$deal_requirements = $this->deal_requirements($id);
		$data['deal_requirements'] = $deal_requirements;
	
		if ($lead['status']==3 OR $lead['status']==4 OR $lead['status']==5 OR $lead['status']==6 OR $lead['status']==7 OR $lead['status']==8 OR $lead['status']==9)
		{
			$tender_dealers = $this->request_model->get_tender_dealers($lead['id_quote_request']);
			
			$tender_email_invites = $this->request_model->get_tender_email_invites($lead['id_quote_request']);
			$tender_quotes = $this->quote_model->get_tender_quotes($lead['id_quote_request']);
			
			$tender_quote_files = $this->request_model->get_files_lead($lead['id_quote_request']);
			$tender_same_variant_quotes = $this->quote_model->get_tender_same_variant_quotes($lead['id_quote_request'], $lead['id_make'], $lead['id_family'], $lead['id_vehicle']);
			$tender_same_model_quotes = $this->quote_model->get_tender_same_model_quotes($lead['id_quote_request'], $lead['id_make'], $lead['id_family'], $lead['id_vehicle']);
			
			$data['tender_dealers'] = $tender_dealers;
			$data['tender_email_invites'] = $tender_email_invites;
			$data['tender_quotes'] = $tender_quotes;
			$data['tender_quote_files'] = $tender_quote_files;
			$data['tender_same_variant_quotes'] = $tender_same_variant_quotes;
			$data['tender_same_model_quotes'] = $tender_same_model_quotes;
		}
		
		$tender_quotes = $this->quote_model->get_tender_quotes($lead['id_quote_request']);
		//echo json_encode($tender_quotes); die();
		//Qm Functionality end
		
		$row = $this->fapplication_model->get_fq_account($id);

		$email_list = $this->fapplication_model->get_email_list();
	
		$order_button = "";
		if ($row['status'] == 5 OR $row['status'] == 6 OR $row['status'] == 7 OR $row['status'] == 8)
		{
			$order_button = '<a href="'.site_url("deal/pdf_export/".$row['lead_id']).'"  target="_blank">
								<i class="fa fa-file-pdf-o" data-toggle="tooltip" data-placement="top" title="Order PDF"></i>
							</a>';
		}
		else
		{
			$order_button = '<i class="fa fa-file-pdf-o" data-toggle="tooltip" data-placement="top" title="Order PDF"></i>';
		}
		// echo "<pre>";
		// print_r($row);
		
		$temp ='';
		foreach($row as $key => $val)
		{	
			//$temp .= $key ."==".$val."<br>";
    }
		$fapplication_summary = '
			<tr>
				<td>'.$order_button.'</td>
				<td>'.$row['fqa_number'].'</td>
				<td>'.$row['source'].'</td>
				<td id="cq_staff_name_text">'.$row['cq_staff'].'</td>
				<td>'.$row['fq_staff'].'</td>
				<td id="fq_lead_name">'.$row['lead_name'].'</td>
				<td><span class="lead_email_send">'.$row['lead_email'].'</span></td>
				<td>'.$row['lead_phone'].'</td>
				<td>'.$row['lead_mobile'].'</td>
				<td>'.$row['lead_state'].'</td>
				<td>'.$row['lead_make'].'</td>
				<td>'.$row['lead_model'].'</td>
				<td>'.$row['created_at'].'</td>			
			</tr>';

			
		
		$fq_dealer_data = $this->fapplication_model->get_fq_dealer_data($id);
	
        if(!empty($fq_dealer_data['dealer'])){
			//$fq_dealer_data['dealer_id'] = $this->fapplication_model->get_column_value_by_id('users','id_user',array('name' => $fq_dealer_data['dealer']));
			$fq_dealer_data['dealer_id'] = $lead['dealer_id'];
        }else{
            $fq_dealer_data['dealer_id'] = '';
        }
		if(!$fq_dealer_data)
		{
			$fq_dealer_data['name'] = '';
			$fq_dealer_data['surname'] = '';
			$fq_dealer_data['number'] = '';
			$fq_dealer_data['email'] = '';
			$fq_dealer_data['address'] = '';
			$fq_dealer_data['postcode'] = '';
			$fq_dealer_data['dl_no'] = '';
			$fq_dealer_data['c_card_type'] = '';
			$fq_dealer_data['c_card_num'] = '';
			$fq_dealer_data['c_card_exp'] = '';
			$fq_dealer_data['c_card_cvv'] = '';
			$fq_dealer_data['deposite_amt'] = '';
			$fq_dealer_data['year'] = '';
			$fq_dealer_data['make'] = '';
			$fq_dealer_data['modal'] = '';
			$fq_dealer_data['veriant'] = '';
			$fq_dealer_data['redbook_url'] = '';
			$fq_dealer_data['sale_price'] = '';
			$fq_dealer_data['winning_quote'] = '';
			$fq_dealer_data['winning_trade'] = '';
			$fq_dealer_data['gross_margin'] = '';
			$fq_dealer_data['delivery_date'] = '';
			$fq_dealer_data['dealer'] = '';
			$fq_dealer_data['wholesaler'] = '';
			$fq_dealer_data['dealer_id'] = '';			
		}
		//print_r($fq_dealer_data);
		$logo = base_url("/assets/img/makes/png/".strtolower( str_replace(" ","", $fq_dealer_data['make'])).".png");
				
		$admin_flag = $this->fapplication_model->get_fq_admin_flag($data['user_id']);
			
		$this->db->select('*');
		$this->db->from('computation');
		$this->db->where('lead_id', $id );
		$computataion_data = $this->db->get()->result_array();
	

		$fapplication_summary_new = '
                                                       
                <div class="col-md-3">
									<div class="clearfix">

										<input type="text" style="width:48%"  name="new_lead_name" value="'.$fq_dealer_data['name'].'" placeholder="Enter name" class="h3-text form-control num_inp address_inp">
										<input type="text" style="width:48%"  name="new_lead_surname" value="'.$fq_dealer_data['surname'].'" placeholder="Enter Surname" class="h3-text form-control num_inp address_inp">
										</div>
									<div class="clearfix">
									<br>
									<input style="width:100%" type="text" name="new_lead_number" value="'.$fq_dealer_data['number'].'" placeholder="Enter contact number" class="pull-right form-control num_inp address_inp">
									</div>
									
									<div class="mt20 text-capitalize personal-detail car_detail">
										<p>Client Registered Address</p>
										<div class="form-group">
											<input type="text" style="width:100%"  name="new_lead_address" value="'.$fq_dealer_data['address'].'" placeholder="Enter Client Registered Address" class="form-control address_inp load_map client_address google_address initial_address">
										</div>
										<p>postcode</p>
										<div class="form-group">
											<input type="text" name="new_lead_postcode" id="postcode_ds" value="'.$fq_dealer_data['postcode'].'" placeholder="Enter Postcode" class="form-control address_inp load_map">
										</div>
										<p>Contact : </p>
										<div class="form-group">
											<input type="text" name="" value="'.$fq_dealer_data['number']. '" placeholder="" class="form-control address_inp">
										</div>
										<p>DL No.</p>
										<div class="form-group">
											<input type="text" name="new_lead_dl_no" value="'.$fq_dealer_data['dl_no'].'" placeholder="Enter Dl No" class="form-control address_inp">
										</div>
										<p>credit card type</p>
										<div class="form-group"> 
											<select name="new_lead_credit_card" class="form-control address_inp">
												<option value="">Select</option>';
												if($fq_dealer_data['c_card_type'] == 'VISA'){
													$fapplication_summary_new .= '
													<option value="VISA" selected>VISA</option>
													<option value="MasterCard">MasterCard</option>
													<option value="AMEX">AMEX</option>
													<option value="EFT">EFT</option>';
												}elseif($fq_dealer_data['c_card_type'] == 'MasterCard'){
													$fapplication_summary_new .= '
													<option value="VISA">VISA</option>
													<option value="MasterCard" selected>MasterCard</option>
													<option value="AMEX">AMEX</option>
													<option value="EFT">EFT</option>';
												}elseif($fq_dealer_data['c_card_type'] == 'AMEX'){
													$fapplication_summary_new .= '
													<option value="VISA">VISA</option>
													<option value="MasterCard">MasterCard</option>
													<option value="AMEX" selected>AMEX</option>
													<option value="EFT">EFT</option>';
												}elseif($fq_dealer_data['c_card_type'] == 'EFT'){
													$fapplication_summary_new .= '
													<option value="VISA">VISA</option>
													<option value="MasterCard">MasterCard</option>
													<option value="AMEX">AMEX</option>
													<option value="EFT" selected>EFT</option>';
												}else{
													$fapplication_summary_new .= '
													<option value="VISA">VISA</option>
													<option value="MasterCard">MasterCard</option>
													<option value="AMEX">AMEX</option>
													<option value="EFT">EFT</option>';
												}
												

											$fapplication_summary_new .= '</select>
											
										</div>
										<p>credit card no.</p>
										<div class="form-group">
											<input type="text" name="new_lead_card_no" value="'.$fq_dealer_data['c_card_num'].'" placeholder="Enter card no" class="form-control address_inp">
										</div>
										<p>expiration date</p>
										<div class="form-group">
											<input type="text" name="new_lead_exp_date" value="'.$fq_dealer_data['c_card_exp'].'" placeholder="Enter expiration date" class="form-control address_inp">
										</div>
										<p>CVV</p>
										<div class="form-group">
											<input type="text" name="new_lead_cvv_no" value="'.$fq_dealer_data['c_card_cvv'].'"  placeholder="Enter CVV"   class="form-control address_inp">
										</div>
                                        
										<p>Deposit amount : <span>$165 Fee&nbsp;
												<div class="round" style="height: 1px;" >';
												if($row['deposit_check'] == 1){
													$fapplication_summary_new .= '<input checked name="depositCheck" type="checkbox" id="checkbox" class="totalGross " />';
												}else{
													$fapplication_summary_new .= '<input name="depositCheck" type="checkbox" id="checkbox" class="totalGross " />';
												}
											
                                                    $fapplication_summary_new .= '<label for="checkbox" style="left: 200px;"></label>
                                                </div>
                                            </span>
                                                                                    
                                        </p>                                        
										
										<div class="form-group">
											<input type="text" name="new_lead_deposit_amt" value="'.$fq_dealer_data['deposite_amt'].'"  placeholder="Enter Deposite Amount"  class="form-control address_inp">
										</div>
										
										<p>Order Date</p>
										<div class="form-group">
											<input type="text" name="order_date" id="order_date" value="'.$computataion_data[0]['order_date'].'"  placeholder="Order Date"  class="form-control address_inp">
										</div>

									</div>
								</div>
								<div class="col-md-3" >
									<div class="clearfix">
										<input type="text" name="new_lead_email_address" value="'.$fq_dealer_data['email'].'" placeholder="Enter Email" class="form-control email_inp address_inp">
										<h4 class="pull-right text-white">'.$row['fqa_number'].'</h4>
									</div>
									<img src="'.base_url('/assets/img/redbook-logo-new.png').'" class="img img-responsive mt20" width="130px">
									<img src="'.$logo.'" id="companylogo" class="img img-responsive bmw" width="60px">
									<div class="mt20 text-capitalize personal-detail car_make" >
										<p>Make :</p>  <span style="color:#fff" id="make_ds">'.$fq_dealer_data['make'].'</span>
										<div class="form-group" style="display:none" >
											<select class="form-control address_inp num_inp" id="newLead_make" name="newLead_make"><option value="">Select Make</option>';
												$makes_row = $this->fapplication_model->get_dropdown_data(array("code"=>1));
												$make_dom_selected = "";
												$make_id ='';$model_id ='';
												foreach ($makes_row as $make_key => $make_val) 
												{
														if($fq_dealer_data['make'] == "")
														{
																$fapplication_summary_new.="<option data-id='{$make_val['id_make']}' ".$make_dom_selected."  value='{$make_val['name']}' ".((trim($fq_dealer_data['make'])==trim($make_val['name'])) ? "selected":"").">{$make_val['name']}</option>";
																if(trim($fq_dealer_data['make']) == trim($make_val['name'])){
																		$make_id = $make_val['id_make'];
																}
														}
														else
														{
																$fapplication_summary_new.="<option data-id='{$make_val['id_make']}' ".$make_dom_selected."  value='{$make_val['name']}' ".((trim($fq_dealer_data['make'])==trim($make_val['name'])) ? "selected":"").">{$make_val['name']}</option>";
																if(trim($fq_dealer_data['make']) == trim($make_val['name']))
																		$make_id = $make_val['id_make'];
														}
												}
		$fapplication_summary_new .= '</select>
										</div>
										<p>Model :</p> <span style="color:#fff" id="model_ds">'.$fq_dealer_data['modal'].'</span >
										<div class="form-group"  style="display:none" >
											<select name="newLead_model" id="newLead_model"  class="form-control address_inp email_inp">
												<option value="">Select Model</option>';
                                                if( $make_id!=""){
                                                    $model_row = $this->fapplication_model->get_dropdown_data(array("code"=>2, "id_make" => $make_id));

                                                    foreach ($model_row as $model_key => $model_val) 
                                                    {
                                                        if($fq_dealer_data['modal'] == "")
                                                        {
                                                            $fapplication_summary_new.="<option data-id='{$model_val['id_family']}' value='{$model_val['name']}' ".((md5($fq_dealer_data['modal'])==md5($model_val['name'])) ? "selected":"").">{$model_val['name']}</option>";
                                                            if( md5( trim($fq_dealer_data['modal']) ) == md5( trim($model_val['name']) ) )
                                                                $model_id = $model_val['id_family'];
                                                        }
                                                        else
                                                        {
                                                            $fapplication_summary_new.="<option data-id='{$model_val['id_family']}' value='{$model_val['name']}' ".((md5($fq_dealer_data['modal'])==md5($model_val['name'])) ? "selected":"").">{$model_val['name']}</option>";
                                                            if( md5( trim($fq_dealer_data['modal']) ) == md5( trim($model_val['name']) ) )
                                                                $model_id = $model_val['id_family'];
                                                        }
                                                    }
                                                }
		$fapplication_summary_new .='</select>
										</div>
										<p style="display:none">Year :</p> <span style="color:#fff;display:none;">'.$fq_dealer_data['year'].'</span>
										<div class="form-group" style="display:none" >
											<select name="newLead_car_year" id="newLead_car_year" class="form-control address_inp">
												<option value="">Select Year</option>';$code = '';
												if($model_id!=""){
                                                    $build_date_row = $this->fapplication_model->get_dropdown_data(array("code"=>4,"id_model"=>$model_id));

                                                    foreach ($build_date_row as $b_key => $b_val) 
                                                    {
                                                        $fapplication_summary_new.="<option data-code='{$b_val['code']}' value='{$b_val['year']}' ".((md5($fq_dealer_data['year'])==md5($b_val['year'])) ? "selected":"").">{$b_val['year']}</option>";
                                                    }
                                                    $code = $model_id . "-" . $fq_dealer_data['year'];
                                                }
							
						$fapplication_summary_new .= '</select>
										</div>
										<p style="display:none">Variant :</p> <span style="color:#fff;display:none;">'.$fq_dealer_data['veriant'].'</span>
										
										<p >Registration Type :</p> <span style="color:#fff;" id="reg_ds">'.$rb_data_row['registration_type'].'</span>
										<p >Colour :</p> <span style="color:#fff;" id="color_ds">'.$rb_data_row['colour'].'</span>
                                        <br><p style="font-size:18px;margin: 10px 0px;">RedBook data :</p>
                                        <p>Car Name :</p> <span style="color:#fff" id="rb_data_ds">'.$rb_data_row['name'].'</span>
                                        <p>Price :</p> <span style="color:#fff" id="price_ds">'.$rb_data_row['price'].'</span>
                                        <p>Details :</p> <span style="color:#fff" id="des_ds">'.implode(', ',$rb_data_row['des']).'</span>
										
										<p>Accessories :</p> <span style="color:#fff" id="acces_ds">'.$accessories.'</span>
										
										<div class="form-group" style="display:none" >
											<select name="newLead_car_variant" id="newLead_car_variant" class="form-control address_inp">
												<option value="">Select varient</option>';
                                                if($code!='')
                                                {
                                                    $variant_row = $this->fapplication_model->get_dropdown_data(array("code"=>3,"var_code"=>md5($code)));

                                                    foreach ($variant_row as $var_key => $var_val) 
                                                    {
                                                        $fapplication_summary_new.="<option data-id='{$var_val['id_vehicle']}' value='{$var_val['name']}' ".((md5($fq_dealer_data['veriant'])==md5($var_val['name'])) ? "selected":"").">{$var_val['name']}</option>";
                                                    }
											}

						if($fq_dealer_data['gross_margin'] == ''){
							if($fq_dealer_data['sale_price'] != ''){
								$grossMargin = $fq_dealer_data['sale_price'] - $fq_dealer_data['winning_quote'];
							}else{
								$grossMargin = '';
							}
						}else{
							$grossMargin =$fq_dealer_data['gross_margin'];
						}
					
					
						$search_str = $fq_dealer_data['address']." ".$fq_dealer_data['postcode'];
						$fapplication_summary_new .= '</select>
										</div>
										<p style="display:none" >redbook link</p>
										<div class="form-group" style="display:none">
											<input type="text"  name="new_lead_redbook_url" value="'.$fq_dealer_data['redbook_url'].'" placeholder="Enter Redbook Url" class="form-control address_inp">
										</div>
									</div>
								</div>
								
								<div class="col-md-6">
                                    <p style="color: #58c603;margin:0;">Landing Page URL : <span style="color:#fff">'.$insta_data['page_url'].'</span ></p>
                                    <p style="color: #58c603;margin:0;">Finance : <span style="color:#fff">'.$insta_data['finance'].'</span ></p>
									<p style="color: #58c603;margin:0;">Model : <span style="color:#fff">'.$insta_data['model'].'</span ></p>
									<p style="color: #58c603;margin:0;display:none;">Variant : <span style="color:#fff">'.$insta_data['variant'].'</span ></p>
									<p style="color: #58c603;margin:0;">Date & Time : <span style="color:#fff">'.$insta_data['date'].'</span ></p>
									
								<div class="col-md-6">
                                    <div class="mt10 text-capitalize personal-detail car_dealer">
                                        <p>Sale price/changeover</p>
                                        <div class="form-group">
                                            <input type="text" name="new_lead_sale_price" value="'.$fq_dealer_data['sale_price'].'" placeholder="Enter Sale price " class="form-control address_inp">
                                        </div>
                                        <p>Winning quote</p>
                                        <div class="form-group">
                                            <input type="text" name="new_lead_winning_quote" value="'.$fq_dealer_data['winning_quote'].'" placeholder="Enter winning quote "  class="form-control address_inp">
                                        </div>
                                        <p>Winning  trade  value</p>
                                        <div class="form-group">
                                            <input type="text" name="new_lead_winning_trade"  value="'.$fq_dealer_data['winning_trade'].'" placeholder="Enter trade value "   class="form-control address_inp">
                                        </div>
                                        <p>Gross margin</p>
                                        <div class="form-group">
                                            <input type="text" name="new_lead_gross_margin" value="'.$grossMargin.'" placeholder="Enter gross margin"  class="form-control address_inp">
                                        </div>
                                        <p>Delivery date</p>
                                        <div class="form-group">
                                            <input type="text" name="new_lead_delivery_date" value="'.$fq_dealer_data['delivery_date'].'" placeholder="Enter Delivery date " class="form-control address_inp">
                                        </div>
                                        <p>Dealer</p>
                                        <div class="form-group">
											<input type="text" name="new_lead_dealer" value="'.$fq_dealer_data['dealer'].'" placeholder="Enter Dealer Firstname" class="form-control address_inp"> <input type="text" name="new_lead_dealer_surname" value="'.$fq_dealer_data['dealer_surname'].'" placeholder="Enter Dealer Surname" class="form-control address_inp"> ';
											if($fq_dealer_data['dealer_id'] !=''){
												$fapplication_summary_new .='<a href="javascript:void(0)" class="open-editdealer" data-dealer_id="'.$fq_dealer_data['dealer_id'].'">View</a>';
											}
										$fapplication_summary_new .='</div>
										
                                        <p>Wholesaler</p>
                                        <div class="form-group">
                                            <input type="text" name="new_lead_wholesaler" value="'.$fq_dealer_data['wholesaler'].'" placeholder="Enter Wholesaler"  class="form-control address_inp">
                                        </div>
                                    </div>
								</div>	
								
								<div class="col-md-6 map mt10" id="lead_map">
								</div>
								</div>	
								';
								/*<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3316.725514944585!2d151.26376921482654!3d-33.76775818068429!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6b12aa44fc3e5197%3A0xf017d68f9f32900!2sWestfield+Warringah+Mall!5e0!3m2!1sen!2sin!4v1513772417996" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>*/
								/*<iframe src="http://maps.google.co.uk/maps?q=NSW+7878&output=embed" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
								<iframe width="100%" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v2/place?key=AIzaSyDyR6Qi_hb0GkY9Wk0D4LBI0pqg5ln6X_k&q=NSW+7878" allowfullscreen></iframe>
									<p>Enlarge</p>
								*/
		$fapplication_summary_new_OLD =$temp.'<div><div class="col-md-3">
									<div class="clearfix">
										<h3 class="pull-left">'.$row['lead_name'].'</h3>
										<span class="pull-right">'.$row['lead_mobile'].'</span>
									</div>
									
									<div class="mt20 text-capitalize personal-detail">
										<p>Client Registered Address</p>
										<p class="value">'.$row['le_address'].'</p>
										<p>postcode</p>
										<p class="value">'.$row['le_postcode'].'</p>
										<p>DL No.</p>
										<p class="value">7389267*</p>
										<p>credit card type</p>
										<p class="value">VISA*</p>
										<p>credit card no.</p>
										<p class="value">8367-7842-7872-8743*</p>
										<p>exp</p>
										<p class="value">08/16*</p>
										<p>CVV</p>
										<p class="value">227*</p>
										<p>Deposit amount <span class="pull-right">$165 Fee*&nbsp;<i class="fa fa-check-circle-o fa-2x"></i> </span></p>
										<p class="value">$'.$row['deposit'].'</p>
									</div>
								</div>
								<div class="col-md-3">
									<div class="clearfix">
										<p class="text-white pull-left" style="font-size:14px;">'.$row['lead_email'].'</p>
										<h4 class="pull-right text-white">'.$row['fqa_number'].'</h4>
									</div>
									<img src="'.base_url("/assets/img/redbook-logo-new.png").'" class="img img-responsive mt20" width="130px">
									<img src="'.$logo.'" class="img img-responsive bmw" width="100px">
									<div class="mt50 text-capitalize personal-detail">
										<p>year</p>
										<p class="value">'.$row['year'].'</p>
										<p>make</p>
										<p class="value">'.$row['make'].'</p>
										<p>model</p>
										<p class="value">'.$row['lead_model'].'</p>
										<p>variant</p>
										<p class="value">'.$row['variant'].'</p>
										<p>redbook link</p>
										<p class="value">https://www.redbook.com.au/boat-news/sacs-marine/champagne-concierge-service-for-boaters-110308?csn_tnet=true*</p>
									</div>
								</div>
								<div class="col-md-3">
                                    <div class="mt40 text-capitalize personal-detail">
                                        <p>sale price/changeover</p>
                                        <p class="value">$64,850*</p>
                                        <p>winning quote</p>
                                        <p class="value">$61,700*</p>
                                        <p>winning <span class="text-blue">trade</span> value</p>
                                        <hr>
                                        <p>gross margin</p>
                                        <p class="value">$3000*</p>
                                        <p>delivery date</p>
                                        <p class="value">'.$row['delivery_date'].'</p>
                                        <p>dealer</p>
                                        <p class="value">'.$row['dealer'].'</p>
                                        <p>'.$row['seller'].'</p>
                                        <hr>
                                    </div>
								</div>	
								<div class="col-md-3 map mt40">
									<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3316.725514944585!2d151.26376921482654!3d-33.76775818068429!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6b12aa44fc3e5197%3A0xf017d68f9f32900!2sWestfield+Warringah+Mall!5e0!3m2!1sen!2sin!4v1513772417996" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
									<p>Enlarge</p>
								</div></div>';
		
								$temp_name = "";
		if($row['temp_lead_user'] != "0")
		{
			$temp_name = $row['temp_user'];
		}
		$applicant_rows = $this->fapplication_model->get_applicant_data($id);
	
		$beneficiary_rows = $this->fapplication_model->get_beneficiary_data($id);
		$address_arr     = [];
		$employee_arr    = [];
		$liabilities_arr = [];
		$reference_arr   = [];
		$other_loans_arr = [];
		$other_asset_arr = [];
		$credit_card_arr = [];
		$other_inc_array = [];
		$visa_flag = 0;
		$name_on_title_flag = 0;
		$managed_flag = 0;
		$flags = [
			'name_on_title_flag' => 0,
			'visa_flag'          => 0,
			'managed'            => 0
		];
		foreach ($applicant_rows as $app_key => $app_val) 
		{
			//echo json_encode($app_val['id']); die();
			$address_arr[]     = $this->fapplication_model->get_address_data($app_val['id']);
			$liabilities_arr[] = $this->fapplication_model->get_property_data($app_val['id']);
			$other_loans_arr[] = $this->fapplication_model->get_other_loans_data($app_val['id']);
			$other_asset_arr[] = $this->fapplication_model->get_asset_data($app_val['id']);
			$credit_card_arr[] = $this->fapplication_model->get_credit_card_data($app_val['id']);
			$employee_arr[]    = $this->fapplication_model->get_employer_data($app_val['id']);
			$reference_arr[]   = $this->fapplication_model->get_reference_data($app_val['id']);
			foreach ($employee_arr[$app_key] as $emp_key => $emp_val) 
			{
				$other_inc_array[$app_key][$emp_key] = $this->fapplication_model->get_other_income_data($emp_val['id']);
			}
			if($app_val['visa_holder'] == 1)
				$flags['visa_flag'] = 1;
		}
		if(isset($liabilities_arr[0][0]))
		{
			if( $liabilities_arr[0][0]['name_on_title'] == 1 )
				$flags['name_on_title_flag'] = 1;
			if( $liabilities_arr[0][0]['managed'] == 1 )
				$flags['managed'] = 1;
		}
		if(isset($address_arr[0][0]))
		{
			if( $address_arr[0][0]['client_res_stat'] == "renting" )
				$flags['renting_flag'] = 1;
			else
				$flags['renting_flag'] = 0;
		}
		else
			$flags['renting_flag'] = 0;
		if(isset($other_inc_array[0][0]))
		{
			if(count($other_inc_array[0][0]) > 0)
				$flags['other_income'] = 1;
			else
				$flags['other_income'] = 0;
		}
		else
			$flags['other_income'] = 0;
		$requirements_strings = $this->set_requirements(1, $row, $flags);
		$requirement_ddown = $this->get_requirements_ddown(1, $row, $flags);
		
		$makes_row = $this->fapplication_model->get_dropdown_data(array("code"=>1));
		$dealers = $this->fapplication_model->get_all_dealers();
		$make_id  = 0;
		$model_id = 0;
		$dealers_dom = '';
		$dealers_dom .= '<label for="dealer" class="dealer-label">Dealer</label>
								<select name="dealer" class="form-control input-sm dealer" id="dealer">
									<option></option>';
		foreach ($dealers as $dealer_key => $dealer_val) 
		{
			$dealers_dom .= "<option data-dealid='{$dealer_val['id_user']}' ".((trim($row['dealer'])==trim($dealer_val['dealership_name'])) ? "selected":"")." value='{$dealer_val['dealership_name']}'>{$dealer_val['dealership_name']}</option>";
		}
		$dealers_dom .= '</select>';
		$make_dom_selected = "";
		$make_dom = '<label for="make" class="f-label">Make</label>
						<select name="make" id="make" class="form-control input-sm">
							<option></option>';
						foreach ($makes_row as $make_key => $make_val) 
						{
							if($row['make'] == "")
							{
								$make_dom.="<option data-id='{$make_val['id_make']}' ".$make_dom_selected."  value='{$make_val['name']}' ".((trim($row['lead_make'])==trim($make_val['name'])) ? "selected":"").">{$make_val['name']}</option>";
								if(trim($row['lead_make']) == trim($make_val['name'])){
									$make_id = $make_val['id_make'];
								}
							}
							else
							{
								$make_dom.="<option data-id='{$make_val['id_make']}' ".$make_dom_selected."  value='{$make_val['name']}' ".((trim($row['make'])==trim($make_val['name'])) ? "selected":"").">{$make_val['name']}</option>";
								if(trim($row['make']) == trim($make_val['name']))
									$make_id = $make_val['id_make'];
							}
						}
					$make_dom.='</select>';
					
		$model_row = $this->fapplication_model->get_dropdown_data(array("code"=>2, "id_make" => $make_id));
		$model_dom = '
				<label for="model" class="f-label">Model</label>
				<select name="model" id="model" class="form-control input-sm">
					<option></option>';
					foreach ($model_row as $model_key => $model_val) 
					{
						if($row['model'] == "")
						{
							$model_dom.="<option data-id='{$model_val['id_family']}' value='{$model_val['name']}' ".((md5($row['lead_model'])==md5($model_val['name'])) ? "selected":"").">{$model_val['name']}</option>";
							if( md5( trim($row['lead_model']) ) == md5( trim($model_val['name']) ) )
								$model_id = $model_val['id_family'];
						}
						else
						{
							$model_dom.="<option data-id='{$model_val['id_family']}' value='{$model_val['name']}' ".((md5($row['model'])==md5($model_val['name'])) ? "selected":"").">{$model_val['name']}</option>";
							if( md5( trim($row['model']) ) == md5( trim($model_val['name']) ) )
								$model_id = $model_val['id_family'];
						}
					}
				$model_dom .='</select>';
		$build_date_row = [];
		$build_date_row = $this->fapplication_model->get_dropdown_data(array("code"=>4,"id_model"=>$model_id));
		// echo "<pre>";
		// print_r($build_date_row); die();
		$build_date_dom = '
						<label for="year" class="f-label">Year</label>
						<select name="year" id="year" class="form-control input-sm">
							<option></option>';
							foreach ($build_date_row as $b_key => $b_val) 
							{
								$build_date_dom.="<option data-code='{$b_val['code']}' value='{$b_val['year']}' ".((md5($row['year'])==md5($b_val['year'])) ? "selected":"").">{$b_val['year']}</option>";
							}
						$build_date_dom .= '</select>';
		$code = $model_id . "-" . $row['year'];
		$variant_row = $this->fapplication_model->get_dropdown_data(array("code"=>3,"var_code"=>md5($code)));
		$variant_dom = '
						<label for="variant" class="f-label">Variant</label>
						<select name="variant" id="variant" class="form-control input-sm">
							<option></option>';
							foreach ($variant_row as $var_key => $var_val) 
							{
								$variant_dom.="<option data-id='{$var_val['id_vehicle']}' value='{$var_val['name']}' ".((md5($row['variant'])==md5($var_val['name'])) ? "selected":"").">{$var_val['name']}</option>";
							}
						$variant_dom .= '</select>';
		$actions_history = '';
		$actions_query = "
		SELECT u.name, ac.details, ac.created_at
		FROM actions ac
		JOIN users u ON ac.fk_user = u.id_user
		WHERE ac.type = 3 AND ac.id = ".$id." ORDER BY ac.id_action DESC";
		$actions_result = $this->db->query($actions_query);
		foreach ($actions_result->result() as $actions_row)
		{
			$actions_history .= '<tr><td>'.$actions_row->details.'</td><td>'.$actions_row->name.'</td><td>'.$actions_row->created_at.'</td></tr>';
		}
		
			
		
		$tender ='';
		
		 /* ?><input value="'. $lead['lead_name'].'" class="text-line" id="name" name="name" type="hidden">
		<input value="'. $lead['lead_email'].'" class="text-line" id="email" name="email" type="hidden"><?php */ 
		$tender ='<div class="panel-heading" style="border-bottom: 1px solid #ddd;"> <!-- Status -->
						<h4 class="panel-title">
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse_1">
								<b>'. $lead['status_text'] .'</b>
							</a>
						</h4>
						<b>Submitted:</b>'.$lead['created_at'].'
						<br />
						<b>Owner:</b> '.$lead['qs_name'].'
				
					
						<br />
						<br />';
	
					
						if ($data['previous_lead_id'] <> "")
						{
							
								$tender .='<a href="'.site_url('fapplication/record/'.$data['previous_lead_id']).'" class="btn btn-default btn-sm ajax_button">
								<i class="fa fa-arrow-left"></i>&nbsp; Previous Lead
							</a>';
						}
						else
						{
								$tender .='<a href="#" class="btn btn-default btn-sm ajax_button" disabled>
								<i class="fa fa-arrow-left"></i>&nbsp; Previous Lead
							</a>';
						}
						
						if ($data['next_lead_id'] <> "")
						{
							
							$tender .='<a href="'.site_url('fapplication/record/'.$data['next_lead_id']).'" class="btn btn-default btn-sm ajax_button">
								<i class="fa fa-arrow-right"></i>&nbsp; Next Lead
							</a>';
						}		
						else
						{
							
							$tender .='<a href="#" class="btn btn-default btn-sm ajax_button" disabled>
								<i class="fa fa-arrow-right"></i>&nbsp; Next Lead
							</a>';
						}
							
						
						//echo (count($deal_requirements['errors'])); die();
						if ($lead['status']==0 || $lead['status']==1 || $lead['status']==2)
						{
																	$lead_status_tender = 'start_tender';
							$tender .='<span class="btn btn-default btn-sm ajax_button start_tender_modal_buttont" data-id_lead="'.$lead['id_fq_account'].'" data-email_template_id="1">
								Start Tender
							</span>
							<span class="btn btn-default btn-sm ajax_button not_proceeding_modal_button" data-id_lead="'.$lead['id_fq_account'].'">
								Not Proceeding
							</span>';
						}
						else if ($lead['status']==10)
						{
							$tender .='<span class="btn btn-default btn-sm ajax_button restart_tender_button" data-id_lead="'.$lead['id_fq_account'].'">
								Restart Tender
							</span>
							<span class="btn btn-default btn-sm ajax_button not_proceeding_modal_button" data-id_lead="'. $lead['id_fq_account'].'">
								Not Proceeding
							</span>';
							}
							
					
						else if ( $lead['status']=="3" || $lead['status']==3)
						{	
							$tender .='<span class="btn btn-default btn-sm ajax_button pretender_button" data-id_lead="'. $lead['id_fq_account'].'">
								Pre-Tender
							</span>';
							
								if (count($deal_requirements['errors'])==0)
							{
								$tender .='<span class="btn btn-default btn-sm ajax_button submit_deal_button" data-id_lead="'.$lead['id_fq_account'].'">
									Submit Deal
								</span>';
								
							} 
							
							$tender .='<span class="btn btn-default btn-sm ajax_button not_proceeding_modal_button" data-id_lead="'.$lead['id_fq_account'].'">
								Not Proceeding
							</span>';
						}
						
						else if ($lead['status']=="4" || $lead['status']==4)
						{
							//echo json_encode($data['user_id']); die();
							if ($data['user_id'] == 427 OR $data['user_id'] == 255) // Param and Jeno (Hardcoded for Now)
							{
								$tender .='<span class="btn btn-default btn-sm ajax_button accountant_email_modal_button" data-id_lead="'.$lead['id_fq_account'].'">
									Dealer Email
								</span>	';
								
							}															
							
							$tender .='<span class="btn btn-default btn-sm ajax_button cancel_deal_modal_button" data-id_lead="'.$lead['id_fq_account'].'">
								Cancel Deal
							</span>';
							
							if ($data['login_type']=="Admin")
							{
								
								$tender .='<span class="btn btn-default btn-sm ajax_button approve_deal_button" data-id_lead="'.$lead['id_fq_account'].'">
									Approve Deal
								</span>';
								
							}
						}												
						else if ($lead['status']==5)
						{
							
							if ($data['user_id'] == 427 OR $data['user_id'] == 255) // Param and Jeno (Hardcoded for Now)
							{
								$tender .='<span class="btn btn-default btn-sm ajax_button accountant_email_modal_button" data-id_lead="'. $lead['id_fq_account'].'">Dealer Email</span>';
								
							}															
							$tender .=	'<span class="btn btn-default btn-sm ajax_button cancel_deal_modal_button" data-id_lead="'.$lead['id_fq_account'].'">Cancel Deal</span>
										<span class="btn btn-default btn-sm ajax_button deliver_button" data-id_lead="'. $lead['id_fq_account'].'">Delivered</span>';
						}
						else if ($lead['status']==6)
						{
							
							if ($data['user_id'] == 427 OR $data['user_id'] == 255) // Param and Jeno (Hardcoded for Now)
							{
								$tender .='<span class="btn btn-default btn-sm ajax_button accountant_email_modal_button" data-id_lead="'.$lead['id_fq_account'].'">Dealer Email</span>';
							}
							$tender .= 	'<span class="btn btn-default btn-sm ajax_button cancel_deal_modal_button" data-id_lead="'.$lead['id_fq_account'].'">Cancel Deal</span>
										<span class="btn btn-default btn-sm ajax_button settle_button" data-id_lead="'.$lead['id_fq_account'].'">
											Settled
										</span>';
						}
						else if ($lead['status']==7)
						{										
							if ($data['user_id'] == 427 OR $data['user_id'] == 255) // Param and Jeno (Hardcoded for Now)
							{
								$tender .='<span class="btn btn-default btn-sm ajax_button accountant_email_modal_button" data-id_lead="'.$lead['id_fq_account'].'">Dealer Email</span>';
							}															
							$tender .='<span class="btn btn-default btn-sm ajax_button cancel_deal_modal_button" data-id_lead="'. $lead['id_fq_account'].'">Cancel Deal</span>';
						}		
					//echo $next_button;
									
		$tender .='</div>';
			
		if ($lead['status']==3 OR $lead['status']==4 OR $lead['status']==5 OR $lead['status']==6 OR $lead['status']==7 OR $lead['status']==8 OR $lead['status']==9)
		{
		
			$tender .='<div class="row">
							<div class="col-sm-12">
								<div class="alert alert-default">
									<i class="fa fa-car"></i>&nbsp; <strong>Tender Actions</strong> 
									<br />
									<br />';
									$send_tender_confirmation_button_old = '<span class="btn btn-default btn-sm  11 ajax_button send_tender_confirmation_button" data-id_lead="'.$lead['id_fq_account'].'" data-id_quote_request="'.$lead['id_quote_request'].'">Send Tender Confirmation</span>';
									$tender .='<span class="btn btn-default btn-sm  ajax_button resend_vehicle_confirm_button" data-email_template_id="'.RESEND_VEHICLE_MAIL_TEMPLATE.'" data-id_lead="'.$lead['id_fq_account'].'" data-id_quote_request="'.$lead['id_quote_request'].'">Resend New Vehicle Confirmation</span>';
									$tender .='<span class="btn btn-default btn-sm  ajax_button resend_quote_request_button" data-id_lead="'.$lead['id_fq_account'].'" data-id_quote_request="'.$lead['id_quote_request'].'" data-email_template_id="'. QUOTE_REQUEST_MAIL_TEMPLATE.'">Resend Quote Request</span>';
									$tender .='<span class="btn btn-default btn-sm ajax_button add_dealers_modal_button" data-id_lead="'.$lead['id_fq_account'].'" data-id_quote_request="'.$lead['id_quote_request'].'" data-email_template_id="'. QUOTE_REQUEST_MAIL_TEMPLATE.'">
										Add Dealers
									</span>
									<span class="btn btn-default btn-sm ajax_button edit_tender_modal_button" data-id_lead="'.$lead['id_fq_account'].'" data-id_quote_request="'. $lead['id_quote_request'].'">
										Edit Tender
									</span>
									<span class="btn btn-default btn-sm ajax_button remind_dealers_button" data-id_lead="'. $lead['id_fq_account'].'" data-id_quote_request="'.$lead['id_quote_request'].'">
										Remind Dealers
									</span>
									<span class="btn btn-default btn-sm ajax_button email_invite_modal_button" data-id_lead="'.$lead['id_fq_account'].'" data-id_quote_request="'.$lead['id_quote_request'].'">
										Email Invitation
									</span>
									<span class="btn btn-default btn-sm ajax_button quote_modal_button" data-id_lead="'.$lead['id_fq_account'].'" data-id_quote_request="'.$lead['id_quote_request'].'">
										Add Quote
									</span>																
								</div>
							</div>
					</div>';
		}													
							
 		// echo json_encode(count($tender_quotes)); die();
 		//echo json_encode($lead); die();
		if ($lead['status']==3 OR $lead['status']==4 OR $lead['status']==5 OR $lead['status']==6 OR $lead['status']==7 OR $lead['status']==8 OR $lead['status']==9 OR $lead['status']==100)
		{
		
			$tender .='<section class="panel">
							<div class="panel-body">
							<hr class="solid mt-sm mb-lg">
							<div class="row"> <!-- Tender Summary -->
									<div class="col-sm-12">
										<h5 style="color: #58c603"><b>Tender Summary</b></h5>
									</div>
									<div class="col-sm-4">
										<p>
											<b>Start Date</b><br />
											'.($lead['tender_date']).'
										</p>
										<p>
											<b>Registration</b><br />
											'.$lead['registration_type'].'
										</p>
									</div>
									<div class="col-sm-4">
										<p>
											<b>Vehicle</b><br />
											'.$lead['build_date']." ".$lead['tender_make']." ".$lead['tender_model'].'
										</p>
										<p>
											<b>Winning Dealer</b><br />
											'.$lead['fleet_manager'].'
										</p>
									</div>
									<div class="col-sm-4">
										<p>
											<b>Quotes / Invites</b><br />
											'.$lead['quote_count']." / ".$lead['invite_dealer_count'].'
										</p>													
										<p>
											<b>Dealer Price</b><br />
											'.$lead['winning_price'].'
										</p>
									</div>
								</div>';
							if ($lead['status']==4 OR $lead['status']==5 OR $lead['status']==6 OR $lead['status']==7 OR $lead['status']==8 OR $lead['status']==9 )
							{
								$tender .='<hr class="solid mt-sm mb-lg">
								<div class="row"> <!-- Documents -->
									<div class="col-sm-12">
										<a href="'.site_url('deal/pdf_export/'.$lead['id_fq_account']).'" target="_blank" class="btn btn-default btn-sm ajax_button">
											<i class="fa fa-file-pdf-o"></i> Purchase Order PDF
										</a>
										<a href="'.site_url('deal/order_package_pdf/'.$lead['id_fq_account']).'" target="_blank" class="btn btn-default btn-sm ajax_button">
											<i class="fa fa-file-pdf-o"></i> Order Package PDF
										</a>															
									</div>
								</div>';
							}
							$tender .='</div>
								</section>
								
						<div class="panel-footer panel-footer-btn-group"> <!-- Actions -->
						<a href="#" style="border-top: 1px solid #ddd;" class="call_modal_button">
							<i class="fa fa-phone mr-xs"></i> Log Call
						</a>
						<a href="#" style="border-top: 1px solid #ddd;" class="sms_modal_button">
							<i class="fa fa-mobile mr-xs"></i> Send SMS
						</a>
						<a href="#" style="border-top: 1px solid #ddd;"  class="send_email_modal_button">
							<i class="fa fa-envelope mr-xs"></i> Send Email
						</a>
					</div>	
							
			<section class="panel" 555 > <!-- Tender Details -->
			<form method="post" id="tender_details_form" name="tender_details_form" action="">
				<input type="hidden" id="id_lead" name="id_lead" value="'.$lead['id_fq_account'].'" />
				
				<input type="hidden" id="id_quote_request" name="id_quote_request" value="'.$lead['id_quote_request'].'" />
				<input type="hidden" id="id_make" name="id_make" value="'.$lead['id_make'].'" />
				<input type="hidden" id="id_family" name="id_family" value="'.$lead['id_family'].'" />
				<input type="hidden" id="id_vehicle" name="id_vehicle" value="'. $lead['id_vehicle'].'" />
				<input type="hidden" id="build_date" name="build_date" value="'. $lead['build_date'].'" />
				<input type="hidden" id="colour" name="colour" value="'. $lead['colour'].'" />
				<input type="hidden" id="id_rbdata" name="id_rbdata" value="'. $lead['rb_data'].'" />
				<input type="hidden" id="registration_type" name="registration_type" value="'.$lead['registration_type'].'" />
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<h5><b>Tender Details</b></h5>
							<hr class="solid mt-sm mb-lg">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<h5><b>Vehicle:</b></h5>
								<p>'.$lead['build_date']." ".$lead['tender_make']." ".$lead['tender_model']." ".$lead['tender_variant'].'</p>
							</div>
						</div>
					</div>
					<div class="row" style="margin-top: 20px;">
						<div class="col-md-12">
							<h5><b>Invited Dealers</b></h5>
							<hr class="solid mt-sm mb-lg">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-condensed mb-none">
									<tbody>
										<tr>
											<td><b>Name</b></td>
											<td><b>Invites</b></td>
											<td><b>Quotes</b></td>
											<td><b>Won</b></td>
											<td><b>Orders</b></td>
										</tr>';

									
										
										$tenderInviteDealer = [];
										if (count($tender_dealers)==0)
										{
											$tender .='<tr id="norecord"><td colspan="5"><center>No records found!</center></td></tr>';
										}
										else
										{
											
											foreach ($tender_dealers as $tender_dealer)
											{	
												$dealerNm = '';
												if(isset($tender_dealer['is_primary_contact']) && $tender_dealer['is_primary_contact'] == '1'){
													$dealerNm = $tender_dealer['name'];
												}

												$dealerEmail = $tender_dealer['email'];
												$getmanagerEmail = $this->db->query("select manager_email from users where id_user = ".$tender_dealer['user_id'])->row_array();
												$managerEmail = $getmanagerEmail['manager_email'];
												if($dealerEmail ==  $managerEmail){
													$managerEmail = '';
												}
												$tenderInviteDealer[].=	$dealerEmail;					$tenderInviteDealer[].=	$managerEmail;

												$getContactDetail = $this->db->query("select dealership_contacts from dealer_attributes where fk_user = ".$tender_dealer['user_id'])->row_array();
												
												if($getContactDetail['dealership_contacts'] !=''){
													$dealer_contacts = str_replace('\\', '',$getContactDetail['dealership_contacts']);
													
													$dealer_contacts_arr = json_decode($dealer_contacts,true);
													
													foreach ($dealer_contacts_arr as $dealerRow) {
															if($dealerRow['contact_email'] && $dealerRow['contact_email'] !=''){
																$tenderInviteDealer[].=	$dealerRow['contact_email'];
															}
															if($dealerRow['contact_is_primary'] == 1){
																$dealerNm = 	$dealerRow['contact_fullname'];
															}
													
													}
												
												}
											
												
												if($dealerNm == ''){
													$dealerNm = $tender_dealer['name'];
												}
												$tender .=	'<tr>
																<td><a class="open-editdealer" data-dealer_id="'.$tender_dealer['user_id'].'" href="javascript:void(0);" target="_blank">'.$dealerNm .'</a></td>
																<td>'.$tender_dealer['tender_count'].'</td>
																<td>'.$tender_dealer['quote_count'].'</td>
																<td>'.$tender_dealer['won_count'].'</td>
																<td>'.$tender_dealer['order_count'].'</td>
															</tr>';
											}
										}
										
									$tender .='</tbody>
								</table>
							</div>
						</div>
					</div>	
					<div class="row" style="margin-top: 20px;">
						<div class="col-md-12">
							<h5><b>Email Invitations</b></h5>
							<hr class="solid mt-sm mb-lg">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-condensed mb-none">
									<tbody>
										<tr>
											<td><b>Email</b></td>
											<td><b>Date</b></td>
										</tr>';
										if (count($tender_email_invites)==0)
										{
											
											$tender .='<tr id="norecord"><td colspan="2"><center>No records found!</center></td></tr>';
										}
										else
										{
											foreach ($tender_email_invites as $tender_email_invite)
											{
												$tenderInviteDealer[].=	$tender_email_invite['email'];
												$tender .='<tr>
													<td>'. $tender_email_invite['email'].'</td>
													<td>'. $tender_email_invite['invite_date'].'</td>
												</tr>';
												
											}																			
										}									
									$tender .='</tbody>																	
								</table>
							</div>
						</div>
					</div>
					<br />
					<div class="row" style="margin-top: 20px;">
						<div class="col-md-12">
							<h5><b>Historical Quotes</b></h5>
							<hr class="solid mt-sm mb-lg">
                            <div class="col-sm-2" style="padding-left: 0px;">
                                <div class="form-group">
                                    <select class="form-control" id="sel_state_hquote">
                                        <option value="ALL" selected>ALL</option>
                                        <option value="ACT">ACT - Australian Capital Territory</option>
                                        <option value="NSW">NSW - New South Wales</option>
                                        <option value="NT">NT - Northern Territory</option>
                                        <option value="QLD">QLD - Queensland</option>
                                        <option value="SA">SA - South Australia</option>
                                        <option value="TAS">TAS - Tasmania</option>
                                        <option value="VIC">VIC - Victoria</option>
                                        <option value="WA">WA - Western Australia</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2" style="padding-left: 0px;">
                                <label for="sel1">Select State</label>
                            </div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="table-responsive" id="account_table_div">';
								$tender .='<table class="table table-bordered table-condensed mb-none account-table" id="account_table" cellspacing="0" cellpadding="0" style="white-space:nowrap;">
                                    <thead>
										<tr style="background-color: #f9f9f9;color: black;">
											
                                            <th><b><i class="fa fa-trophy"></i></b></th>
                                            <th><b><i class="fa fa-eye"></i></b></th>
                                            <th><b><i class="fa fa-trash-o"></i></b></th>
                                            <th><b>Dealer</b></th>
                                            <th><b>State</b></th>
                                            <th><b>Quoted Price</b></th>
                                            <th><b>On Road</b></th>
                                            <th><b>Car Off Road</b></th>
                                            <th><b>Dealer Notes</b></th>
                                            <th><b>Accessories</b></th>
                                            <th><b>Datetime</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>';
							$tender .='</div>
						</div>
					</div>
					<br />
				</div>
			</form>
			</section>';
	
			$tender .='<section class="panel"> <!-- Dealer Quotes -->
			<form method="post" id="dealer_quotes_form" name="dealer_quotes_form" action="">
			<input type="hidden" id="id_lead" name="id_lead" value="'.$lead['id_fq_account'].'" />
			<input type="hidden" value="'.$lead['id_quote'].'" id="id_quote">
			<input type="hidden" id="id_quote_request" name="id_quote_request" value="'.$lead['id_quote_request'].'" />
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<h5><b>Dealer Quotes</b></h5>
						<hr class="solid mt-sm mb-lg">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="table-responsive">
							<table class="table table-bordered table-condensed mb-none" cellspacing="0" cellpadding="0">
								    <thead>
									<tr style="background-color: #f9f9f9;color: black;">
										<td style="text-align:center;"><i class="fa fa-trophy"></i></td>
										<td style="text-align:center;"><i class="fa fa-eye"></i></td>
										<td style="text-align:center;"><i class="fa fa-trash-o"></i></td>';
										if ($data['admin_type'] == 2)
										{
											//$tender .='<td></td>';
										}
									// commeted by jignesh 26/4/18 7:00 PM
									/*$tender .='<td><b>Sender</b></td>
										<td><b>Type</b></td>
										<td><b>Dealer</b></td>
										<td><b>List Price</b></td>
										<td><b>Total Price</b></td>
										<td><b>Date</b></td>
									</tr>';*/
									// Added by jignesh 26/4/18 7:00 PM
								$tender .='<td><b>Dealer</b></td>
                                            <td><b>State</b></td>
                                            <td><b>Quoted Price</b></td>
                                            <td><b>On Road</b></td>
                                            <td><b>Car Off Road</b></td>
                                            <td><b>Dealer Notes</b></td>
                                            <td><b>Estimated Delivery Date</b></td>
                                            <td><b>Date Time</b></td>
								</tr>
                                </thead>';
								$tender .='<tbody style="color: #ffffff">';
								if(count($tender_quotes)==0)
								{
									$tender .='<tr id="norecord"><td colspan="11"><center>No records found!</center></td></tr>';
								}
								else
								{
									foreach($tender_quotes as $tender_quote)
									{
										$warning_flag = "";
										if($tender_quote['total'] < 5000 OR $tender_quote['retail_price'] < 5000)
										{
											/*----commeted by -- RJ 28/4/18----*/
											//$warning_flag = '&nbsp;<span style="color: red"><i class="fa fa-exclamation-triangle" data-toggle="tooltip" title="Quote is too low"></i></span>';
										}
										
										$new_flag = "";
										if($tender_quote['seen_status']==0)
										{
											/*----commeted by -- RJ 28/4/18----*/
											//$new_flag = '&nbsp;<span style="color: red; font-size: 0.9em;">New</span>';
										}										
										
										/*$tender .='<tr>
													<td align="center">													
														<span class="ajax_button_primary quote_modal_button" data-id_lead="'.$lead['id_fq_account'].'" data-id_quote_request="'.$tender_quote['id_quote_request'].'" data-id_quote="'.$tender_quote['id_quote'].'">
															<i class="fa fa-edit" data-toggle="tooltip" title="Edit Quote"></i>
														</span>
													</td>';*/
										$tender .='<tr data-id_quote="'.$tender_quote['id_quote'].'">';
										if($tender_quote['winner']==$tender_quote['id_quote']) 
										{
											$tender .=	'<td align="center">
															<a href="javascript:void(0);" class="remove_winning_quote_button" data-id_lead="'.$lead['id_fq_account'].'" data-id_quote_request="'.$tender_quote['id_quote_request'].'">
																<i class="fa fa-trophy" data-toggle="tooltip" title="Remove from Winning Quote"></i>
															</a>
														</td>';
										}
										else
										{												
											$tender .=	'<td align="center">												
															<span class="select_winning_quote_button" data-id_lead="'.$lead['id_fq_account'].'" data-id_quote_request="'.$tender_quote['id_quote_request'].'" data-id_quote="'.$tender_quote['id_quote'].'">
																<i class="fa fa-trophy" data-toggle="tooltip" title="Nominate as Winning Quote"></i>
															</span>
														</td>';
										}
									
										if($tender_quote['seen_status'] == 1) {
											/*----commeted by -- RJ 28/4/18----*/
											//$tender .='<td align="center"><i class="fa fa-eye"></i></td>';
										} else {
											/*----commeted by -- RJ 28/4/18----*/
											//$tender .='<td align="center"><span class="ajax_button_primary update_quote_seen_status_button" data-id_lead="'.$lead['id_fq_account'].'" data-id_quote_request="'. $tender_quote['id_quote_request'].'" data-id_quote="'.$tender_quote['id_quote'].'" data-seen_status="1"><i class="fa fa-eye" data-toggle="tooltip" title="Mark as Seen"></i></span></td>';
										}
										/*----Added by -- RJ 28/4/18 Start----*/
										if(isset($tender_quote['quote_file']) && !empty($tender_quote['quote_file'])){
											//$quote_file = base_url() .'uploads/quote_files/'. $tender_quote['quote_file'];
										} else {
											//$quote_file = 'javascript:void(0);';
										}
										$quote_file = isset($tender_quote['quote_file']) && !empty($tender_quote['quote_file']) ? base_url() .'uploads/quote_files/'. $tender_quote['quote_file'] : 'javascript:void(0);';
										$tender .=	'<td align="center">
														<a href="'.$quote_file .'" target="_blank">
															<i class="fa fa fa-eye"></i>
														</a>
													</td>';
										/*----Added by -- RJ 28/4/18 End----*/
										$tender .=	'<td align="center">
														<a href="javascript:void(0);" data-id_quote="'.$tender_quote['id_quote'].'" class="delate_quote_button" title="Delete Quote">
															<i class="fa fa-trash-o"></i>
														</a>
													</td>';
										
										if($data['admin_type'] == 2)
										{
											/*$tender .='<td align="center">
															<span class="ajax_button_primary delete_quote_button" data-id_lead="'.$lead['id_fq_account'].'" data-id_quote_request="'.$tender_quote['id_quote_request'].'" data-id_quote="'.$tender_quote['id_quote'].'">
																<i class="fa fa-trash-o" data-toggle="tooltip" title="Delete Quote"></i>
															</span>
														</td>';*/
										}
										// commeted by jignesh 26/4/18 7:00 PM
										/*$tender .='<td style="vertical-align: middle">'.$tender_quote['sender'].'</td>
														<td style="vertical-align: middle">'.$tender_quote['demo'].'</td>
														<td style="vertical-align: middle"><a href="'.site_url('user/record/'.$tender_quote['dealer_id']).'" target="_blank">'.$tender_quote['name'].'</a> '.$warning_flag . " " . $new_flag.'</td>
														<td style="vertical-align: middle">'.$tender_quote['retail_price'].'</td>
														<td style="vertical-align: middle">'. $tender_quote['total'].'</td>
														<td style="vertical-align: middle">'.$tender_quote['date_submitted'].'</td>
													</tr>';*/
										// Added by jignesh 26/4/18 7:00 PM
										//$onroad = isset($tender_quote['on_road']) ? ($tender_quote['on_road'] == 1 ? 'Yes' : 'No') : '' ;
										$onroad = isset($tender_quote['on_road']) ? ($tender_quote['on_road'] == 1 ? '<input type="radio" class="car_onroad" name="car_onroad'.$tender_quote['id_quote'].'" value="1" data-id_quote="'.$tender_quote['id_quote'].'" checked> Yes <input type="radio" class="car_onroad" name="car_onroad'.$tender_quote['id_quote'].'" data-id_quote="'.$tender_quote['id_quote'].'" value="0"> No' : '<input type="radio" class="car_onroad" name="car_onroad'.$tender_quote['id_quote'].'" data-id_quote="'.$tender_quote['id_quote'].'" value="1"> Yes <input type="radio" class="car_onroad" name="car_onroad'.$tender_quote['id_quote'].'" value="0" data-id_quote="'.$tender_quote['id_quote'].'" checked> No') : '' ;
										$date_time = isset($tender_quote['delivery_date_time']) ? date('d-m-Y h:i A', strtotime($tender_quote['delivery_date_time'])) : '';
										$e_d_date = isset($tender_quote['delivery_date']) && !empty($tender_quote['delivery_date']) ? date('d-m-Y', strtotime($tender_quote['delivery_date'])) : '';
										$tender .=	'<td style="vertical-align: middle">
														<a  class="open-editdealer" data-dealer_id="'.$tender_quote['dealer_id'].'" href="javascript:void(0);" target="_blank">'.$tender_quote['name'].'</a>'.$warning_flag . " " . $new_flag.'</td>
														<td style="vertical-align: middle">'.$tender_quote['state'].'</td>
														<td style="vertical-align: middle">'.$tender_quote['quoted_price'].'</td>
														<td style="vertical-align: middle">'.$onroad.'</td>
														<td style="vertical-align: middle"><input type="text" id="off_road_'.$tender_quote['id_quote'].'" value="'.$tender_quote['car_off_road'].'" style="background-color: black;">&nbsp;<button type="button" class="btn btn-primary btn-xs off_road">OK</button></td>
														<td style="vertical-align: middle"><input type="text" data-toggle="tooltip" title="'.$tender_quote['dealer_notes'].'" id="notes_'.$tender_quote['id_quote'].'" value="'.$tender_quote['dealer_notes'].'" style="background-color: black;">&nbsp;<button type="button" class="btn btn-primary btn-xs dealer_notes">OK</button></td>
														<td style="vertical-align: middle"><input type="text" id="e_d_date_'.$tender_quote['id_quote'].'" value="'.$e_d_date.'" class="e_d_date_input" style="background-color: black;">&nbsp;<button type="button" class="btn btn-primary btn-xs e_d_date">OK</button></td>
                                                        <td style="vertical-align: middle">'.$date_time.'</td>
													</tr>';
												}
											}
										$tender .='</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</form>
			</section>';
		
		}
	
		// $fq_dealer_data = $this->fapplication_model->get_fq_dealer_data($id);
		// $tender_quotes = $this->quote_model->get_tender_quotes($lead['id_quote_request']);
		$tender_quotes_delivery = $this->quote_model->get_tender_quotes_delivery($lead['id_quote_request']);
		$fq_lead_dealer_data = $this->fapplication_model->get_lead_dealer_data($lead['id_fq_account']);
	
		$tradeins = $this->fapplication_model->get_data_row_by_id('tradein_new',array('id_leads' => $id,'parent_id' => null));
	
		$trade_id = $tradeins->id_leads;
	
		$winner_trade_valuation = $this->fapplication_model->get_winning_trade($trade_id);
		$computation='';
		if ($lead['status']==3 OR $lead['status']==4 OR $lead['status']==5 OR $lead['status']==6 OR $lead['status']==7 OR $lead['status']==8 OR $lead['status']==9){
			

			$computation_view_data['user_id'] = $this->data['user_id'];
            $computation_view_data['computation_data'] = $computataion_data[0];
			$computation_view_data['deal_requirements'] = $deal_requirements;
			$computation_view_data['lead'] = $lead;
			$computation_view_data['lead_calculation_details'] = $lead_calculation_details;
			/* first half */
			$computation_view_data['fq_dealer_data'] = $fq_dealer_data;
			$computation_view_data['delivery_date_comp'] = $tender_quotes_delivery;
			$computation_view_data['lead_dealer_data'] = $fq_lead_dealer_data;
			/* second half */
			$computation_view_data['winner_trade_valuation'] = $winner_trade_valuation;
			$computation_view_data['estimated_payout'] = $tradeins->estimated_payout;
			/* fourth half */
			$computation_view_data['finance'] = $row;
			$computation = $this->load->view('admin/computation_html', $computation_view_data, TRUE);
        }
        
		/*if ($lead['status']==3 OR $lead['status']==4 OR $lead['status']==5 OR $lead['status']==6 OR $lead['status']==7 OR $lead['status']==8 OR $lead['status']==9)
		{
            $computation_view_data['deal_requirements'] = $deal_requirements;
            $computation_view_data['lead'] = $lead;
            $computation_view_data['lead_calculation_details'] = $lead_calculation_details;
	
			$computation='<div class="row">
                <div class="col-sm-12">';
									
                        if (count($deal_requirements['errors'])>0)
                        {
                            $computation .='<div class="alert alert-danger">
                                <i class="fa fa-exclamation-circle"></i>&nbsp;<strong>Deal Submission Requirements:</strong>
                                <ul>';
                                    foreach ($deal_requirements['errors'] AS $deal_error)
                                    {
                                        $computation .='<li>'. $deal_error.'</li>';
                                    }
                                $computation .='</ul>
                            </div>';
                        }
                        if (count($deal_requirements['warnings'])>0)
                        {
                            $computation .='<div class="alert alert-warning">
                                <i class="fa fa-warning"></i>&nbsp; <strong>Deal Warnings:</strong>
                                <ul>';
                                    foreach ($deal_requirements['warnings'] AS $deal_warning)
                                    {
                                        $computation .='<li>'.$deal_warning.'</li>';
                                    }
                                $computation .='</ul>
                            </div>';
                        }														
                    $computation .='</div>
                </div>
				<section class="panel "> 
				    <form method="post" id="delivery_details_form" name="delivery_details_form" action="">
						<input type="hidden" name="id_lead" value="'. $lead['id_fq_account'].'" />										
							<div class="panel-body">
								<div class="row">
									<div class="col-md-12">
										<h5><b>Delivery Details</b></h5>
										<hr class="solid mt-sm mb-lg">
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label class="control-label">Delivery Date</label><br />
											<input value="'.$lead['delivery_date'].'" class="text-line datepicker" data-date-format="yyyy-mm-dd" id="delivery_date" name="delivery_date" type="text">
										</div>
									</div>
								</div>';
				
			$computation .='				
				<div class="row" style="margin-top: 10px;">
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">Delivery Address</label><br />';
							
							$delivery_address_hidden = '';
							if ($lead['delivery_address_map']==1)
							{
								$delivery_address_hidden = ' hidden="hidden" ';
							}
							
							$computation .='Same as the Client Address? &nbsp; 
							<select class="text-line" name="delivery_address_map" id="delivery_address_map" style="width: 100px;" data-container="delivery_details_form">';
							
							$computation .='<option value="0"';
							   if ($lead['delivery_address_map'] == 0) {
								   $computation .='selected';
							   }
							$computation .='>No</option>';
							
							$computation .='<option value="1"'; 
							  if ($lead['delivery_address_map'] == 1) {
								   $computation .='selected';
							   }
							$computation .='>Yes</option>';
							
							$computation .='</select>
							<br />
							<br />
							<input value="'.$lead['delivery_address'].'" class="text-line" id="delivery_address" name="delivery_address" type="text"'.$delivery_address_hidden.'>
						</div>
					</div>
				</div>
				
				<div class="row" style="margin-top: 10px;">
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">Delivery Instructions</label><br />
							<input value="'. $lead['delivery_instructions'].'" class="text-line" id="delivery_instructions" name="delivery_instructions" type="text">
						</div>
					</div>
				</div>
				<div class="row" style="margin-top: 10px;">
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">Special Conditions</label><br />
							<input value="'.$lead['special_conditions'].'" class="text-line" id="special_conditions" name="special_conditions" type="text">
						</div>
					</div>													
				</div>	
				<div class="row" style="margin-top: 10px;">
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">Transport</label><br />
							<select class="text-line" name="transport" id="transport">';
							
							$computation .='<option value="0"';
							   if ($lead['transport'] == 0){
								   $computation .='selected';
							   }
							$computation .='></option>';
							
							$computation .='<option value="1"';
							  if ($lead['transport'] == 1){
								   $computation .='selected';
							   }
                            $computation .=' >Dealer will deliver the car to the client</option>';
							
							$computation .='<option value="2"';
							   if ($lead['transport'] == 2){
								   $computation .='selected';
							   }
							$computation .=' >Client will attend the dealership to take delivery</option>';
							$computation .='<option value="3"';
							   if ($lead['transport'] == 3){
								   $computation .='selected';
							   }
							$computation .=' >Quote me is organising the transport to the client</option>';
								
							$computation .='</select>
							
						</div>
					</div>													
				</div>													
				<br />
                <div class="row" style="margin-top: 10px;">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Exempt from LCT and Stamp Duty</label><br />
                            <select class="text-line" id="client_invoice_taxes" name="client_invoice_taxes">';
                            $computation .='<option value="0"';
                                if ($lead['client_invoice_taxes'] == 0) {
                                    $computation .='selected';
                                }
                            $computation .='>No</option>';
                            $computation .='<option value="1"';
                                if ($lead['client_invoice_taxes'] == 1) {
                                    $computation .='selected';
                                }
                            $computation .='>Yes</option>';
                            $computation .='</select>
                        </div>
                    </div>
                </div>
			     <br />
			
                <div class="row" style="margin-top: 10px;">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Deposit</label><br />
                            <select class="text-line" id="deposit" name="deposit">';
                            $computation .='<option value="0"';
                               if ($lead['deposit'] == 0) {
                                   $computation .='selected';
                               }
                            $computation .='></option>';
                            $computation .='<option value="1"';
                               if ($lead['deposit'] == 1) {
                                   $computation .='selected';
                               }
                            $computation .='>Case 1</option>';
                            $computation .='<option value="2"';
                               if ($lead['deposit'] == 2) {
                                   $computation .='selected';
                               }
                            $computation .='>Case 2</option>';
                            $computation .='<option value="3"';
                               if ($lead['deposit'] == 3) {
                                   $computation .='selected';
                               }
                            $computation .='>Case 3</option>';
                            $computation .='<option value="4"';
                               if ($lead['deposit'] == 4) {
                                   $computation .='selected';
                               }
                            $computation .='>Case 4</option>';
                            $computation .='</select>
                        </div>
                    </div>
                </div>
                <br />
	
	            <div class="row" style="margin-top: 10px;">
	                <div class="col-sm-12">
	                    <div class="alert alert-info">														
	                        <strong>Case 1:</strong>
	                        <p>Qteme will refund the client in full his deposit once the
	                        car is confirmed in the portal as delivered and paid for in
	                        full. Qteme me invoice being paid by the dealer
	                        is the action that releases the deposit</p>
	                        <br />
	                        <strong>Case 2:</strong>
	                        <p>Deposit will be transferred to the dealer 24 hours before
	                        delivery when the dealer sends a copy of the tax
	                        invoice showing the vin chassis or registration number. This 
	                        deposit is forwarded less any corresponding
	                        Qteme invoice to the dealer</p>
	                        <br />
	                        <strong>Case 3:</strong>
	                        <p>The dealership has taken the deposit and will fund
	                        qteme a invoice of $XXX.XX 3 - 5 days post delivery</p>
	                        <br />
	                        <strong>Case 4:</strong>
	                        <p>Deposit will be transferred to the dealer 24
	                        hours before delivery when the dealer sends a
	                        copy of the tax invoice showing the vin chassis
	                        or registration number. The dealer is to fund 
	                        any corresponding qteme invoice
	                        24 hours after delivery</p>	
	                    </div>
	                </div>
	            </div>
	            <br />
	            <div class="row" style="margin-top: 10px;">
	                <div class="col-sm-12">
	                    <input type="button"  id="delivery_submit" class="btn btn-primary" value="Save">	
	                </div>
	            </div>
			</div>	
		</form>
		</section>
	
		<section class="panel "> 
			<form method="post" id="computation_form" name="computation_form" action="">
				<input type="hidden" name="id_lead" value="'.$lead['id_fq_account'].'" />										
				<input type="hidden" id="membership" name="membership" value="'.$lead['gross_subtractor'].'">
				<input type="hidden" id="membership_lower" name="membership_lower" value="'.$lead['gross_subtractor_lower'].'>">
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
						
							<h5><b>Computation</b></h5>
							<hr class="solid mt-sm mb-lg">';
							
						
                            if ($lead['deduct_to_dealer_invoice'] == 1)
                            {
                                $deduct_to_dealer_invoice_check = 'checked="checked"';
                            }
                            else
                            {
                                $deduct_to_dealer_invoice_check = '';
                            }
						$computation .='
						<div class="table-responsive">
								<table class="table table-bordered table-condensed mb-none">	
									<tr>
                                        <td width="70%">Client State:</td>
                                        <td>'.$lead['lead_state'].'</td>
                                    </tr>
                                    <tr>
                                        <td>Dealer State:</td>
                                        <td>'. $lead['dealer_state'].'</td>
                                    </tr>	
									<tr>
									
								</table>
						</div>
						<br />
						<div class="table-responsive">
													<table class="table table-bordered table-condensed mb-none">
														<tr>
															<td width="70%">Dealer Quote</td>
															<td><input value="'.$lead['winning_price'].'" class="form-control input-sm" id="dqp" name="dqp" type="text" readonly="readonly"></td>
														</tr>
														<tr>
															<td>Attached Trades</td>
															<td><input value="'.$lead['tradein_count'].'" class="form-control input-sm" id="tradein_count" name="tradein_count" type="text" readonly="readonly"></td>
														</tr>
														<tr>
															<td>Trades the dealer is taking</td>
															<td><input value="'.$lead['dealer_tradein_count'].'" class="form-control input-sm" id="dealer_tradein_count" name="dealer_tradein_count" type="text" readonly="readonly"></td>
														</tr>																
													</table>
							</div>
							
							<br />
												<div class="table-responsive">
													<table class="table table-bordered table-condensed mb-none">							
														<tr>
															<td colspan="2"><b>If the dealer is taking the trade</b></td>
														</tr>
														<tr>
															<td width="70%">Dealer Trade Value</td>
															<td><input value="'.round($lead['dealer_tradein_value'],2).'" class="form-control input-sm" id="dealer_tradein_value" name="dealer_tradein_value" type="text" readonly="readonly"></td>
														</tr>
														<tr>
															<td>Dealer Trade Payout</td>
															<td><input value="'.round($lead['dealer_tradein_payout'],2).'" class="form-control input-sm" id="dealer_tradein_payout" name="dealer_tradein_payout" type="text" readonly="readonly"></td>
														</tr>
														<tr>
															<td>Dealer Refund to Client</td>
															<td><input value="'.round($lead['dealer_client_refund'],2).'" class="form-control input-sm" id="dealer_client_refund" name="dealer_client_refund" type="text" readonly="readonly"></td>
														</tr>							
													</table>
												</div>
												
										<br />														
											<div class="table-responsive">
												<table class="table table-bordered table-condensed mb-none">							
													<tr>
														<td width="70%"><b>DEALER CHANGEOVER PRICE:</b></td>
														<td><input value="'.round($lead['dealer_changeover'],2).'" class="form-control input-sm" id="dealer_changeover" name="dealer_changeover" type="text" readonly="readonly"></td>
													</tr>							
													<tr>
														<td>Sale Price:</td>
														<td><input value="'.round($lead['sales_price'],2).'" class="form-control input-sm" id="sales_price" name="sales_price" type="text" onkeypress="return isNumberKey(event)" onchange="calculate_revenue()"></td>
													</tr>
													<tr>
														<td>Trade Value Real:</td>
														<td><input value="'.round($lead['tradein_value'],2).'" class="form-control input-sm" id="real_tradein_value" name="tradein_value" type="text" onkeypress="return isNumberKey(event)" onchange="calculate_revenue()"></td>
													</tr>						
													<tr>
														<td>Trade Value Shown:</td>
														<td><input value="'.round($lead['tradein_given'],2).'" class="form-control input-sm" id="real_tradein_given" name="tradein_given" type="text" onkeypress="return isNumberKey(event)" onchange="calculate_revenue()"></td>
													</tr>
													<tr>
														<td>Trade Payout:</td>
														<td><input value="'.round($lead['tradein_payout'],2).'" class="form-control input-sm" id="real_tradein_payout" name="tradein_payout" type="text" onkeypress="return isNumberKey(event)" onchange="calculate_revenue()"></td>
													</tr>
													<tr>
														<td>Changeover:</td>
														<td><input value="'.round($lead_calculation_details['changeover'],2).'" class="form-control input-sm" id="cpp" name="cpp" type="text" readonly="readonly"></td>
													</tr>					
													<tr>
														<td>Total Deposits:</td>
														<td><input value="'.round($lead['deposits_total'],2).'" class="form-control input-sm" id="deposits_total" name="deposits_total" type="text" readonly="readonly"></td>
													</tr>
													<tr>
														<td>Total Refunds:</td>
														<td><input value="'.round($lead['refunds_total'],2).'" class="form-control input-sm" id="refunds_total" name="refunds_total" type="text" readonly="readonly"></td>
													</tr>
													<tr>
														<td><b>CLIENT BALANCE PAYABLE:</b></td>
														<td><input value="'.round($lead_calculation_details['balance'],2).'" class="form-control input-sm" id="balance" name="balance" type="text" readonly="readonly"></td>
													</tr>
													<tr>
														<td><b>DEALER BALCQO:</b></td>
														<td><input value="'.round($lead_calculation_details['dealer_balance'],2).'" class="form-control input-sm" id="dealer_balance" name="dealer_balance" type="text" readonly="readonly"></td>
													</tr>
													<tr>
														<td><b>CLIENT BALCQO:</b></td>
														<td><input value="'.round($lead['balcqo_client'],2).'" class="form-control input-sm" id="balcqo_client" name="balcqo_client" type="text"></td>
													</tr>							
												</table>
											</div>
						
		
							<div class="table-responsive">
								<table class="table table-bordered table-condensed mb-none">					
									
									<tr>
										<td width="70%">
											Other Costs Amount:
											<br />
											<br />
											<input '.$deduct_to_dealer_invoice_check.' value="1" id="deduct_to_dealer_invoice" name="deduct_to_dealer_invoice" type="checkbox">
											Deduct this from Dealer Invoice?																			
										</td>
										<td>
											<input value="'.$lead['other_costs_amount'].'" class="form-control input-sm" id="other_costs_amount" name="other_costs_amount" onkeypress="return isNumberKey(event)" onchange="calculate_revenue()" type="text">
										</td>
									</tr>
									
									<tr>
										<td>Transport Cost:</td>
										<td>
											<input value="'.$lead['transport_cost'].'" class="form-control input-sm" id="transport_cost" name="transport_cost" onkeypress="return isNumberKey(event)" onchange="calculate_revenue()" type="text"></td>
									</tr>';
									
									$estimated_trasnport_cost = 0;
											
											if ($lead['dealer_state']=="NSW" AND $lead['lead_state']=="ACT") { $estimated_trasnport_cost = 614.00; }
											if ($lead['dealer_state']=="NSW" AND $lead['lead_state']=="VIC") { $estimated_trasnport_cost = 510.00; }
											if ($lead['dealer_state']=="NSW" AND $lead['lead_state']=="QLD ") { $estimated_trasnport_cost = 632.00; }
											if ($lead['dealer_state']=="NSW" AND $lead['lead_state']=="SA") { $estimated_trasnport_cost = 749.00; }
											if ($lead['dealer_state']=="NSW" AND $lead['lead_state']=="WA") { $estimated_trasnport_cost = 1623.00; }
											if ($lead['dealer_state']=="NSW" AND $lead['lead_state']=="TAS") { $estimated_trasnport_cost = 1654.00; }
											if ($lead['dealer_state']=="NSW" AND $lead['lead_state']=="NT") { $estimated_trasnport_cost = 2428.00; }
											
											if ($lead['dealer_state']=="ACT" AND $lead['lead_state']=="NSW") { $estimated_trasnport_cost = 655.00; }
											if ($lead['dealer_state']=="ACT" AND $lead['lead_state']=="VIC") { $estimated_trasnport_cost = 428.00; }
											if ($lead['dealer_state']=="ACT" AND $lead['lead_state']=="QLD ") { $estimated_trasnport_cost = 851.00; }
											if ($lead['dealer_state']=="ACT" AND $lead['lead_state']=="SA") { $estimated_trasnport_cost = 396.00; }
											if ($lead['dealer_state']=="ACT" AND $lead['lead_state']=="WA") { $estimated_trasnport_cost = 1211.00; }
											if ($lead['dealer_state']=="ACT" AND $lead['lead_state']=="TAS") { $estimated_trasnport_cost = 1576.00; }
											if ($lead['dealer_state']=="ACT" AND $lead['lead_state']=="NT") { $estimated_trasnport_cost = 1680.00; }
											if ($lead['dealer_state']=="VIC" AND $lead['lead_state']=="NSW") { $estimated_trasnport_cost = 861.00; }
											if ($lead['dealer_state']=="VIC" AND $lead['lead_state']=="ACT") { $estimated_trasnport_cost = 942.00; }
											if ($lead['dealer_state']=="VIC" AND $lead['lead_state']=="QLD ") { $estimated_trasnport_cost = 1018.00; }
											if ($lead['dealer_state']=="VIC" AND $lead['lead_state']=="SA") { $estimated_trasnport_cost = 451.00; }
											if ($lead['dealer_state']=="VIC" AND $lead['lead_state']=="WA") { $estimated_trasnport_cost = 1387.00; }
											if ($lead['dealer_state']=="VIC" AND $lead['lead_state']=="TAS") { $estimated_trasnport_cost = 1313.00; }
											if ($lead['dealer_state']=="VIC" AND $lead['lead_state']=="NT") { $estimated_trasnport_cost = 1826.00; }
											
											if ($lead['dealer_state']=="QLD" AND $lead['lead_state']=="NSW") { $estimated_trasnport_cost = 725.00; }
											if ($lead['dealer_state']=="QLD" AND $lead['lead_state']=="ACT") { $estimated_trasnport_cost = 994.00; }
											if ($lead['dealer_state']=="QLD" AND $lead['lead_state']=="VIC ") { $estimated_trasnport_cost = 1046.00; }
											if ($lead['dealer_state']=="QLD" AND $lead['lead_state']=="SA") { $estimated_trasnport_cost = 893.00; }
											if ($lead['dealer_state']=="QLD" AND $lead['lead_state']=="WA") { $estimated_trasnport_cost = 1855.00; }
											if ($lead['dealer_state']=="QLD" AND $lead['lead_state']=="TAS") { $estimated_trasnport_cost = 1902.00; }
											if ($lead['dealer_state']=="QLD" AND $lead['lead_state']=="NT") { $estimated_trasnport_cost = 2326.00; }																				
											
											if ($lead['dealer_state']=="SA" AND $lead['lead_state']=="NSW") { $estimated_trasnport_cost = 1214.00; }
											if ($lead['dealer_state']=="SA" AND $lead['lead_state']=="ACT") { $estimated_trasnport_cost = 1353.00; }
											if ($lead['dealer_state']=="SA" AND $lead['lead_state']=="VIC ") { $estimated_trasnport_cost = 817.00; }
											if ($lead['dealer_state']=="SA" AND $lead['lead_state']=="QLD") { $estimated_trasnport_cost = 1294.00; }
											if ($lead['dealer_state']=="SA" AND $lead['lead_state']=="WA") { $estimated_trasnport_cost = 1075.00; }
											if ($lead['dealer_state']=="SA" AND $lead['lead_state']=="TAS") { $estimated_trasnport_cost = 1740.00; }
											if ($lead['dealer_state']=="SA" AND $lead['lead_state']=="NT") { $estimated_trasnport_cost = 1654.00; }
											
											if ($lead['dealer_state']=="WA" AND $lead['lead_state']=="NSW") { $estimated_trasnport_cost = 1242.00; }
											if ($lead['dealer_state']=="WA" AND $lead['lead_state']=="ACT") { $estimated_trasnport_cost = 1497.00; }
											if ($lead['dealer_state']=="WA" AND $lead['lead_state']=="VIC ") { $estimated_trasnport_cost = 908.00; }
											if ($lead['dealer_state']=="WA" AND $lead['lead_state']=="QLD") { $estimated_trasnport_cost = 1466.00; }
											if ($lead['dealer_state']=="WA" AND $lead['lead_state']=="SA") { $estimated_trasnport_cost = 512.00; }
											if ($lead['dealer_state']=="WA" AND $lead['lead_state']=="TAS") { $estimated_trasnport_cost = 2092.00; }
											if ($lead['dealer_state']=="WA" AND $lead['lead_state']=="NT") { $estimated_trasnport_cost = 1678.00; }
											
											if ($lead['dealer_state']=="TAS" AND $lead['lead_state']=="NSW") { $estimated_trasnport_cost = 1702.00; }
											if ($lead['dealer_state']=="TAS" AND $lead['lead_state']=="ACT") { $estimated_trasnport_cost = 1763.00; }
											if ($lead['dealer_state']=="TAS" AND $lead['lead_state']=="VIC ") { $estimated_trasnport_cost = 1018.00; }
											if ($lead['dealer_state']=="TAS" AND $lead['lead_state']=="QLD") { $estimated_trasnport_cost = 1820.00; }
											if ($lead['dealer_state']=="TAS" AND $lead['lead_state']=="SA") { $estimated_trasnport_cost = 1456.00; }
											if ($lead['dealer_state']=="TAS" AND $lead['lead_state']=="WA") { $estimated_trasnport_cost = 2249.00; }
											if ($lead['dealer_state']=="TAS" AND $lead['lead_state']=="NT") { $estimated_trasnport_cost = 2683.00; }
											
											if ($lead['dealer_state']=="NT" AND $lead['lead_state']=="NSW") { $estimated_trasnport_cost = 1430.00; }
											if ($lead['dealer_state']=="NT" AND $lead['lead_state']=="ACT") { $estimated_trasnport_cost = 1534.00; }
											if ($lead['dealer_state']=="NT" AND $lead['lead_state']=="VIC ") { $estimated_trasnport_cost = 1085.00; }
											if ($lead['dealer_state']=="NT" AND $lead['lead_state']=="QLD") { $estimated_trasnport_cost = 1489.00; }
											if ($lead['dealer_state']=="NT" AND $lead['lead_state']=="SA") { $estimated_trasnport_cost = 652.00; }
											if ($lead['dealer_state']=="NT" AND $lead['lead_state']=="WA") { $estimated_trasnport_cost = 1395.00; }
											if ($lead['dealer_state']=="NT" AND $lead['lead_state']=="TAS") { $estimated_trasnport_cost = 2156.00; }
									
			$computation .='
					<tr>
						<td><i>Estimated Prixcar Quote from '. $lead['dealer_state'].' to '.$lead['lead_state'].':</i></td>
								<td>
								&nbsp;&nbsp;<i>$'.$estimated_trasnport_cost.'</i>
							</td>
						</tr>
				
								<tr>
										<td>Other Costs Description:</td>
										<td>
											<textarea class="form-control input-sm" id="other_costs_description" name="other_costs_description">'.$lead['other_costs_description'].'</textarea>
										</td>
								</tr>
									<tr>
										<td>Aftersales Accessories Revenue:</td>
										<td><input value="'.$lead['aftersales_accessory_revenue'].'" class="form-control input-sm" id="aftersales_accessory_revenue" name="aftersales_accessory_revenue" onkeypress="return isNumberKey(event)" onchange="calculate_revenue()" type="text"></td>
									</tr>																		
									<tr>
										<td>Other Revenue Amount:</td>
										<td><input value="'.$lead['other_qs_revenue_amount'].'" class="form-control input-sm" id="other_qs_revenue_amount" name="other_qs_revenue_amount" onkeypress="return isNumberKey(event)" onchange="calculate_revenue()" type="text"></td>
									</tr>
									<tr>
										<td>Other Revenue Description:</td>
										<td>
											<textarea class="form-control input-sm" id="other_qs_revenue_description" name="other_qs_revenue_description">'.$lead['other_qs_revenue_description'].'</textarea>
										</td>
									</tr>																		
									<tr>
										<td>Commissionable Gross:</td>
										<td><input value="'.$lead_calculation_details['commissionable_gross'].'" class="form-control input-sm" type="text" id="commissionable_gross" name="commissionable_gross" readonly></td>
									</tr>';
										
									if ($data['admin_type']==2)
									{
										
											$computation .='<tr>
											<td>Other Revenue Amount (Not included on the Commissionable Gross):</td>
											<td><input value="'.$lead['other_revenue_amount'].'" class="form-control input-sm" id="other_revenue_amount" name="other_revenue_amount" onkeypress="return isNumberKey(event)" onchange="calculate_revenue()" type="text"></td>
										</tr>
										<tr>
											<td>Other Revenue Description:</td>
											<td>
											<textarea class="form-control input-sm" id="other_revenue_description" name="other_revenue_description">'.$lead['other_revenue_description'].'</textarea>
											</td>
										</tr>';
										
									}
																				
									
										
										$computation .='<tr>
										<td><b>TOTAL REVENUE:</b></td>
										<td><input value="'.$lead_calculation_details['revenue'].'" class="form-control input-sm" type="text" id="revenue" name="revenue" readonly></td>
									</tr>																	
								
								</table>
								
					</div>
			
					
							<br />
					<div class="row" style="margin-top: 10px;">
						<div class="col-sm-12">
							<button type="submit" class="btn btn-primary">
								<i class="fa fa-save"></i> Save
							</button>								
						</div>
					</div>
					
						</div>
					</div>
					<br />				
			</div>				
			</form>
		</section>';
    	}*/
        
		$payment = '';
		$payment ='<section class="active" id="invoices_container"> 
									<label>Invoices</label>
									<div class="toggle-content">
										<section class="panel">
											<div class="panel-body">									
												<div class="row">
													<div class="col-md-12">
														<div class="table-responsive">
															<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
																<tbody>	
																	<tr>
																		<!--<td align="center"><i class="fa fa-pencil-square-o"></i></td>-->
																		<td align="center"><i class="fa fa-trash-o"></i></td>
																		<td align="center"><i class="fa fa-file-pdf-o"></i></td>
																		<td><b>Invoice #</b></td>
																		<td><b>Name</b></td>
																		<td><b>To</b></td>
																		<td><b>Invoice Date</b></td>
																		<td><b>Due Date</b></td>
																		<td><b>Promised Date</b></td>
																		<td><b>Amount Due</b></td>
																		<td><b>Amount Paid</b></td>
																		<td><b>User</b></td>
																		<td><b>Created</b></td>
																	</tr>
																	<tr id="admin_fee_invoice">
																		<!--<td align="center"><i class="fa fa-pencil-square-o"></i></td>-->
																		<td align="center"><i class="fa fa-trash-o"></i></td>
																		<td align="center"><i class="fa fa-file-pdf-o"></i></td>
																		<td>AI_'.$lead['cq_number_only'].'</td>
																		<td>Admin Fee Invoice</td>
																		<td>Client</td>
																		<td>'.$lead['order_date'].'</td>
													                   <td>'.date("Y-m-d", strtotime($lead['order_date'] . ' +1 day')).'</td>
																		<td></td>
																		<td>165.00</td>
																		<td></td>
																		<td>'.$lead['qs_name'].'</td>
																		<td>'.$lead['order_date'].'</td>
																	</tr>																	
																	<tr id="dealer_invoice">
																		<!--<td align="center"><i class="fa fa-pencil-square-o"></i></td>-->
																		<td align="center"><i class="fa fa-trash-o"></i></td>
																		<td align="center">																		
								                                            <a href="'.site_url('invoice/pdf_dealer_invoice/'.$lead['id_fq_account']).'" target="_blank">
																				<i class="fa fa-file-pdf-o" data-toggle="tooltip" title="Generate PDF"></i>
																			</a>
																		</td>
																		<td>DI_'.$lead['cq_number_only'].'</td>
																		<td>Dealer Invoice</td>
																		<td>Dealer</td>
																		<td>'.$lead['order_date'].'</td>
																		<td>'.$lead['delivery_date'].'</td>
																		<td></td>
																		<td></td>
																		<td></td>
																		<td>'.$lead['qs_name'].'</td>
																		<td><'.$lead['order_date'].'</td>
																	</tr>';
												
																foreach ($lead_attached_tradeins AS $lead_attached_tradein)
																	{
														//$dt = date('Y-m-d', strtotime($lead['delivery_date'] . ' -2 days');
														$dt = date('Y-m-d', strtotime('-2 days', strtotime($lead['delivery_date'])));
											$payment .='<tr id="wholesaler_invoice_'. $lead_attached_tradein['id_tradein'].'">
														<td align="center"><i class="fa fa-trash-o"></i></td>
													<td align="center">
					                               <a href="'.site_url('deal/tradein_invoice_pdf/'.$lead_attached_tradein['id_tradein']).'" target="_blank">
												<i class="fa fa-file-pdf-o" data-toggle="tooltip" title="Generate PDF"></i>
												</a>
												</td>
												<td>WI_'.$lead['cq_number_only'].'</td>
												<td>Wholesaler Invoice</td>
												<td>Wholesaler</td>
												<td>'.$lead['order_date'].'</td>
												<td>'.$dt.'</td>
												<td></td>
												<td></td>
												<td></td>
												<td>'.$lead['qs_name'].'</td>
											<td>'.$lead['order_date'].'</td>
												</tr>';
																		
											} 
														
																 
																 foreach ($lead_invoices AS $lead_invoice)
																	{
																		
																		$payment .='<tr id="lead_invoice_'.$lead_invoice['id_invoice'].'">
																			<!--
																			<td align="center">
																				<span class="ajax_button_primary edit_invoice_modal_button" data-id_lead="'.$lead['id_fq_account'].'" data-id_invoice="'.$lead_invoice['id_invoice'].'">
																					<i class="fa fa-pencil-square-o"></i>
																				</span>
																			</td>
																			-->
																			<td align="center">
																				<span class="ajax_button_primary delete_invoice_button" data-id_lead="'.$lead['id_fq_account'].'" data-id_invoice="'. $lead_invoice['id_invoice'].'">
																					<i class="fa fa-trash-o" data-toggle="tooltip" title="Delete Invoice"></i>
																				</span>
																			</td>
																			<td align="center">
							                                                     <a href="'.site_url('invoice/pdf_custom_invoice/'.$lead_invoice['id_invoice']).'" target="_blank">
																					<i class="fa fa-file-pdf-o" data-toggle="tooltip" title="Generate PDF"></i>
																				</a>
																			</td>
																			<td>'.$lead_invoice['invoice_number'].'</td>
																			<td>'.$lead_invoice['invoice_name'].'</td>
																			<td>'.$lead_invoice['invoice_type'].'</td>
																			<td>'.$lead_invoice['invoice_date'].'</td>
																			<td>'.$lead_invoice['due_date'].'</td>
																			<td>'.$lead_invoice['promised_date'].'</td>
																			<td>'.$lead_invoice['amount_due'].'</td>
																			<td>'.$lead_invoice['amount_paid'].'</td>
																			<td>'.$lead_invoice['name'].'</td>
																			<td>'.date('Y-m-d', strtotime($lead_invoice['created_at'])).'</td>
																		</tr>';
																		
																	}
																$payment .='</tbody>
															</table>
															<br />
														</div>														
													</div>
												</div>	
												<br />
												<div class="row" style="margin-top: 10px;">
													<div class="col-sm-12">
														<span class="btn btn-primary ajax_button add_invoice_modal_button" data-id_lead="'.$lead['id_fq_account'].'">
															Add Invoice
														</span>								
													</div>
												</div>												
											</div>
										</section>
									</div>
								</section>
								<section class="active" id="payments_container"> <!-- Payments -->
									<label>Payments</label>
									<div class="toggle-content">
										<section class="panel">
											<div class="panel-body">									
												<div class="row">
													<div class="col-md-12">
														<div class="table-responsive">
											<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
												<tbody>	
													<tr>
														<td align="center"><b><i class="fa fa-pencil-square-o"></i></b></td>
														<td align="center"><b><i class="fa fa-trash-o"></i></b></td>
														<td align="center"><b><i class="fa fa-eye"></i></b></td>
														<td><b>Type</b></td>
														<td><b>Method</b></td>
														<td><b>Credit Card</b></td>
														<td><b>Bank</b></td>
														<td><b>Reference</b></td>
														<td><b>Amount</b></td>
														<td><b>Admin Fee</b></td>
														<td><b>Merchant Cost</b></td>
														<td><b>Processed</b></td>
														<td><b>Received</b></td>
														<td><b>User</b></td>
														<td><b>Created</b></td>
													</tr>';
													if (count($lead_payments)==0)
													{
														
														$payment .='<tr class="norecords"><td colspan="15"><center>No records found!</center></td></tr>';
														
													}
													else
													{
														foreach ($lead_payments AS $lead_payment)
														{
															if ($lead_payment['payment_date']=="")
															{
																$lead_payment['payment_date'] = "";
															}
															
															if ($lead_payment['received_date']=="")
															{
																$lead_payment['received_date'] = "";
															}
															
															if ($lead_payment['show_status']==1)
															{
																$show_status_action = 0;
																$show_status_action_text = "Hide";
																$show_status_icon = "fa fa-eye-slash";
															}
															else
															{
																$show_status_action = 1;
																$show_status_action_text = "Show";
																$show_status_icon = "fa fa-eye";
															}
															
															$payment .='<tr id="lead_payment_'.$lead_payment['id_payment'].'">
																<td align="center">
																	<span class="ajax_button_primary edit_payment_modal_button" data-id_lead="'.$lead['id_fq_account'].'" data-id_payment="'.$lead_payment['id_payment'].'">
																		<i class="fa fa-pencil-square-o" data-toggle="tooltip" title="Edit Payment"></i>
																	</span>
																</td>
																<td align="center">
																	<span class="ajax_button_primary delete_payment_button" data-id_lead="'.$lead['id_fq_account'].'" data-id_payment="'.$lead_payment['id_payment'].'">
																		<i class="fa fa-trash-o" data-toggle="tooltip" title="Delete Payment"></i>
																	</span>
																</td>
																<td align="center">
																	<span class="ajax_button_primary update_payment_show_status_button" data-id_lead="'.$lead['id_fq_account'].'" data-id_payment="'.$lead_payment['id_payment'].'" data-show_status="'.$show_status_action.'">
														                  <i class="'.$show_status_icon.'" data-toggle="tooltip" title="'.$show_status_action_text.'"></i>
																	</span>
																</td>
																<td>'.$lead_payment['payment_type'].'</td>
																<td>'.$lead_payment['method'].'</td>
																<td>'.$lead_payment['credit_card'].'</td>
																<td>'.$lead_payment['bank_account'].'</td>
																<td>'.$lead_payment['reference_number'].'</td>
																<td>'.$lead_payment['amount'].'</td>
																<td>'.$lead_payment['admin_fee'].'</td>
																<td>'.$lead_payment['merchant_cost'].'</td>
																<td>'.$lead_payment['payment_date'].'</td>
																<td>'.$lead_payment['received_date'].'</td>
																<td>'.$lead_payment['user'].'</td>
																<td>'.$lead_payment['created_at'].'</td>
															</tr>';
															
														}
													}
													
												$payment .='</tbody>
											</table>
															<br />
														</div>														
													</div>
												</div>		
												<br />
												<div class="row" style="margin-top: 10px;">
													<div class="col-sm-12">
														<span class="btn btn-primary ajax_button add_payment_modal_button" data-id_lead="'.$lead['id_fq_account'].'">
															Add Payment
														</span>								
													</div>
												</div>												
											</div>
										</section>
									</div>
								</section>
								<script type="text/javascript">var function_base_url = "'.base_url('index.php/fapplication/get_dealer_sheet').'"; loadLeadMap("'.$fq_dealer_data['address'].'","'.$fq_dealer_data['postcode'].'",function_base_url);loadMapOnChange();</script>';
		
		$email_actions = '';
		$actions = '
		<input type="hidden" value="'.$id.'" id="this_modal_id">
		<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
		<button type="button" class="btn btn-danger" onClick="delete_fapplication()">Delete</button>
		<button type="button" class="btn btn-primary btn-save" onClick="save_fapplication_info_2(1)">Save and Close</button>
		<button type="button" class="btn btn-primary btn-save submit_to_admin" >Submit to Admin</button>
		';
        
        $tradein_data['makes'] = $this->fapplication_model->get_dropdown_data(array("code"=>1));
        
        $tradein_data['lead_id'] = $lead['id_fq_account'];
        
        $tradein_data['id_quote_request'] = $lead['id_quote_request'];
        
        $tradeins = $this->fapplication_model->get_data_row_by_id('tradein_new',array('id_leads' => $lead['id_fq_account'],'parent_id' => null));
        
        // echo '<pre>';print_r($tradeins);exit;
        
        if(!empty($tradeins)){
            $rb_data_img = $this->quote_model->get_id_by_val('rb_data','img','car_id',$tradeins->rb_data);
            $tradeins->rb_data_img = str_replace("?width=150","",trim($rb_data_img));
            $tradein_data['tradeins'] = $tradeins;
            $tradein = $this->tradein_model->get_tradein($tradeins->id_tradein);
            $tradein_data['tradein'] = $tradein;
            /**/
            // $tradein_data['tradein_valuations'] = $this->fapplication_model->get_tradein_valuations($tradeins->id_tradein);
            $tradein_data['tradein_valuations'] = $this->tradein_model->get_tradein_valuations($tradeins->id_tradein);
            $tradein_data['tradein_recipients'] = $this->fapplication_model->get_tradein_recipients($tradeins->id_tradein);
		}
		$dealer_email = $lead['dealer_email'];
		$dealer_manager_email = $lead['dealer_manager_email'];
		if($dealer_manager_email == $dealer_email ){
			$dealer_manager_email = '';
		}
		
		$tradein_html = $this->load->view('admin/tradein_new', $tradein_data, TRUE);
		
	
		$lead_arr = array(
			"status_id"            => $row['status'],
			"status"               => $row['status_text'],
			"id_application"       => $row['id_fq_account'],
			"fqa_number"           => $row['fqa_number'],
			"fapplication_summary" => $fapplication_summary,
			"fapplication_summary_new"=>$fapplication_summary_new,
			"actions_history"      => $actions_history,
			"email_actions"        => $email_actions,		
			"actions"              => $actions,
			"created_at"           => $row['created_at'],
			"last_updated"         => $row['last_updated'],
			"make_dom"             => $make_dom,
			"model_dom"            => $model_dom,
			"variant_dom"          => $variant_dom,
			"build_date_dom"       => $build_date_dom,
			"requirements_strings" => $requirements_strings,
			"requirement_ddown"    => $requirement_ddown,
			"row"                  => $row,
			"applicant_rows"       => $applicant_rows,
			"beneficiary_rows"     => $beneficiary_rows,
			"address_arr"          => $address_arr,
			"employee_arr"         => $employee_arr,
			"liabilities_arr"      => $liabilities_arr,
			"reference_arr"        => $reference_arr,
			"other_loans_arr"      => $other_loans_arr,
			"other_asset_arr"      => $other_asset_arr,
			"credit_card_arr"      => $credit_card_arr,
			"other_inc_array"      => $other_inc_array,
			"lead_id"              => $row['lead_id'],
			"dealer_dom"           => $dealers_dom,
			"lead_name"            => $row['lead_name'],
			"lead_phone"           => $row['lead_phone'],
			"lead_mobile"          => $row['lead_mobile'],
			"lead_email"           => $row['lead_email'],
			"lead_model"           => $row['lead_model'],
			"lead_make"            => $row['lead_make'],
			"lead_state"           => $row['lead_state'],
			"temp_user"            => $temp_name,
			"email_list"           => $email_list,
			"dealer_email"			=> $dealer_email,
			"dealer_manager_email" => $dealer_manager_email,
			"tenderInviteDealer" => $tenderInviteDealer,
			"tender"          	     => $tender,
			"computation"            =>$computation,
            "traidin"                =>isset($traidin) && !empty($traidin) ? $traidin: '',
			"payment"                =>$payment,
            "notes"                 => isset($notes) && !empty($notes) ? $notes: '',
            "lead_status_tender"    => $lead_status_tender,
            "tradein_html"    => $tradein_html,
        );
		echo json_encode($lead_arr);
    }
	
	public function send_email_invite () // MODAL ACTION // AUDIT TRAIL //
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;
		$input_arr = $this->input->post();
		if ($input_arr['email'] != "" AND $input_arr['id_quote_request'] != "" AND $input_arr['id_quote_request'] != 0)
		{
			$email_invite_result = $this->emailinvite_model->insert_email_invite($input_arr['id_quote_request'], $input_arr['email']);
		
			if ($email_invite_result)
			{
				//temporary commented for email
				//$this->templated_special_email_init(11, $input_arr['id_lead'], 'company', $input_arr['email']);
				
				$audit_trail_arr = array(
					'id' => $input_arr['id_lead'],
					'table_name' => 'leads',
					'action' => 11,
					'description' => '[{"email":"'.$input_arr['email'].'"}]'
				);
				
			$insert_audit_trail_result = $this->audit_model->insert_audit_trailinvite($data['user_id'], $audit_trail_arr);
				
				$this->action_model->insert_action(1, $input_arr['id_lead'], $data['user_id'], 'Sent Dealer Email Invite');
				echo "success";
			}
			else
			{
				echo "fail";
			}
		}
		else
		{
			echo "fail";
		}		
	}	
    public function submit_to_admin()
    {
    	$data = $this->data;
    	$post_data = $this->input->post();
    	$this->fapplication_model->submit_to_admin($post_data);
    	$notification_message = "There's a new fq lead submitted to you: <a data-fapplication_id='{$post_data['id_fq_account']}' class='open-fapplication-details' href='#'>{$post_data['fqa_number']}</a>";
		$this->notification_model->add_notification(1, $notification_message);
		$notification_id = $this->db->insert_id();
		$this->notification_model->add_notification_user($notification_id, 272);
		$this->update_status_color_new(3, $post_data['id_fq_account']);
		$this->action_model->insert_action(3, $post_data['id_fq_account'], $data['user_id'], 'Submitted to Admin');
    }
    public function notify_admin($data = [])
    {
    	//$data = $this->data;
    	$fq_number = "FQ".str_pad($data['fq_id'], 5, '0', STR_PAD_LEFT);
    	$result = $this->fapplication_model->get_requirement_name($data['fk_requirement']);
    	if($data['flag'] == 1)
    	{
	    	$notification_message = "An Admin uploaded {$data['file_name']} on {$result['name']} requirement tab on: {$fq_number}";
    	}
    	if($data['user_id'] != 259)
    	{
			$this->notification_model->add_notification(1, $notification_message);
			$notification_id = $this->db->insert_id();
			$this->notification_model->add_notification_user($notification_id, 259);
			
			$this->action_model->insert_action(3, $data['fq_id'], $data['user_id'], "Uploaded {$data['file_name']} on {$result['name']}");
		}
    }
    public function assign_cqo_staff()
    {
    	$post_data = $this->input->post();
    	$this->fapplication_model->assign_cqo_staff($post_data);
    }
    public function get_cqo_staff()
    {
    	$return_array = [];
    	$data = $this->data;
    	$lead_id = $this->input->post('lead_id');
    	$assigned_flag = 0;
    	if($this->fapplication_model->verify_assigned_lead($lead_id, $data['user_id']))
    		$assigned_flag = 1;
    	$option_string = "";
    	$result = $this->fapplication_model->get_cqo_staff($data['user_id']);
    	foreach ($result as $key => $val) 
    	{
    		$option_string .= "<option value='{$val['id_user']}'>{$val['name']}</option>";
    	}
    	$return_array = [
    		'option_string' => $option_string,
    		'assigned_flag' => $assigned_flag
    	];
    	echo json_encode($return_array);
    }
    public function get_dropdown_data()
    {
    	$post_data = $this->input->post();
    	$return_array = $this->fapplication_model->get_dropdown_data($post_data);
    	echo json_encode($return_array);
    }
    public function get_specific_requirements()
    {
    	$data = $this->data;
    	$post_data = $this->input->post();
		$id       = $post_data['fapplication_id'];
		$req_type = $post_data['req_type'];
		$is_temp  = $post_data['is_temp'];
		$response = $this->fapplication_model->get_specific_requirements($id, $req_type, $is_temp);
		$modal_list = '<table class="table table-striped"><tbody>';
		$file_path = 'uploads/cq_requirements/';
		$absolute_path = "";
		foreach ($response as $key => $value) 
		{
			$absolute_path = base_url($file_path.$value['file_name']);
			$modal_list .= "
							<tr class='tr_req'  data-req='{$value['id_req_up']}' data-abspath='{$value['file_name']}'>
								<td class='link'><a class='link_name' target='_blank' href='{$absolute_path}'>".$value['orig_filename']."</a></td>
								<td class='input' hidden><input style='width: 75%;' type='text' class='form-control input-sm edit_req_filename' value='{$value['orig_filename']}'></td>
								<td><a class='fa fa-pencil-square-o edit_req_file' data-id='{$value['id_req_up']}'></a></td>
								<td><a class='fa fa-trash-o del_req_file' data-istemp='{$value['is_temp']}'></a></td>
							</tr>
							";
		}
		$modal_list .= '</tbody></table>';
		if(count($response) < 1)
			$modal_list = "";
		$dom = array(
				'req_list'       => $modal_list,
				'user'           => $data['user_id'],
				'fk_requirement' => $req_type
            );
		echo json_encode($dom);
    }
    public function update_requirement_filename()
    {
    	$post_data = $this->input->post();
    	$this->fapplication_model->update_requirement_filename($post_data);
    }
    public function get_all_requirements()
    {
    	$data = $this->data;
    	$post_data = $this->input->post();
		$id       = $post_data['fapplication_id'];
		$req_type = $post_data['req_type'];
		$response       = $this->fapplication_model->get_all_requirements($id);
		$all_final_req  = $this->fapplication_model->get_all_final_requirements($id);
		$file_path      = 'uploads/cq_requirements/';
		$absolute_path  = "";
		$final_abs_path = "";
		$modal_list     = "";
		$all_final_list = "";
		$modal_list = "<div class='row all_req_row'>
						<div class='col-md-12'>
							<select name='all_req_ddown[0]' class='form-control input-sm all_req_ddown'>
							<option></option>";
		foreach ($response as $res_key => $res_val) 
		{
			$absolute_path = base_url($file_path.$res_val['file_name']);
			$modal_list .= "<option data-abspath='{$absolute_path}'  data-filename='{$res_val['file_name']}' value='{$res_val['id_req_up']}'>{$res_val['orig_filename']}</option>";
		}
		$modal_list .= "</select>
							</div>
						</div>";
		$all_final_list = '<table class="table table-striped"><tbody>';
		foreach ($all_final_req as $all_key => $all_val) 
		{
			$final_abs_path = base_url($file_path.$all_val['file_name']);
			$all_final_list .= "
							<tr class='tr_req' data-idrequp='{$all_val['id_req_up']}' data-abspath='{$all_val['file_name']}' data-req='{$all_val['id_req_up']}'>
								<td class='link'><a class='link_name' target='_blank' href='{$final_abs_path}'>".$all_val['orig_filename']."</a></td>
								<td class='input' hidden><input style='width: 75%;' type='text' class='form-control input-sm edit_req_filename' value='{$all_val['orig_filename']}'></td>
								<td><a class='fa fa-pencil-square edit_req_file'></a></td>
								<td><a class='fa fa-pencil-square-o edit_req'></a></td>
								<td><a class='fa fa-trash-o del_all_req'></a></td>
							</tr>";
		}
		$all_final_list .= "</tbody></table>";
		if(count($response) < 1)
			$modal_list = "";
		if(count($all_final_req) < 1)
			$all_final_list = "";
        $dom = array(
            'allreq_list'    => $modal_list,
            'user'           => $data['user_id'],
            'fk_requirement' => $req_type,
            'all_final_list' => $all_final_list
        );
		echo json_encode($dom);
    }
	public function delete_requirements()
	{
		$post_data = $this->input->post();
	
		$result = $this->fapplication_model->delete_requirements($post_data);
		echo json_encode($result);
	}
	public function delete_global_requirements()
	{
		$post_data = $this->input->post();
	
		$this->fapplication_model->delete_global_requirements($post_data);
	}
	public function merge_files()
	{
		$post_data = $this->input->post();
		$this->fapplication_model->merge_files($post_data);
	}
	public function merge_all_files()
	{
		$post_data = $this->input->post();
		echo $this->fapplication_model->merge_all_files($post_data);
	}
	public function delete_panel()
	{
		$post_data = $this->input->post();
		switch ($post_data['type']) 
		{
			case 'address':
				$post_data['table'] = "fq_app_address";
				break;
			case 'employer':
				$post_data['table'] = "fq_app_employer";
				break;
			case 'credit_card':
				$post_data['table'] = "fq_credit_card";
				break;
			case 'other_loans':
				$post_data['table'] = "fq_other_loans";
				break;
			case 'credit_reference':
				$post_data['table'] = "fq_reference";
				break;
			case 'property':
				$post_data['table'] = "fq_property_assets";
				break;
			case 'personal_vehicle':
				$post_data['table'] = "fq_vehicle_asset";
				break;
			case 'other_asset':
				$post_data['table'] = "fq_other_asset";
				break;
			case 'beneficiary':
				$post_data['table'] = "fq_beneficiaries";
				break;
			default:
				$post_data['table'] = "fq_other_asset";
				break;
		}
		if( $this->fapplication_model->delete_panel($post_data) )
		{
			echo "success";
		}
		else
		{
			echo "fail";
		}
	}
	public function delete_panel_3rd()
	{
		$post_data = $this->input->post();
		$this->fapplication_model->delete_panel_3rd($post_data);
	}
	public function insert_note()
	{
		$post_data = $this->input->post();
		$now       = date("Y-m-d H:i:s");
		$new_note  = str_replace("\n", "<br/>", $post_data['note']);
		$note      = "";
		$old_note  = "";
		if( $this->fapplication_model->note_checker($post_data['fa_acct_id']) )
		{
			$note .= $now;
			$note .= "<br/>";
			$note .= $new_note;
			$note .= "<br/>";
			$note .= "======================";
		}
		else
		{
			$old_note = $this->fapplication_model->get_note($post_data['fa_acct_id']);
			$temp_note = $this->substring_index($new_note, "======================", -1);
			$note .= $old_note;
			$note .= "<br/>";
			$note .= $now;
			$note .= "<br/>";
			$note .= $temp_note;
			$note .= "<br/>";
			$note .= "======================";
		}
		$insert_data = [
			'fa_acct_id' => $post_data['fa_acct_id'],
			'note'       => $note
		];
		$this->fapplication_model->insert_note($insert_data);
		$this->update_status_color_new(1, $post_data['fa_acct_id']);
	}
	public function insert_new_note()
	{
		$post_data = $this->input->post();
		$new_note  = str_replace("\n", "<br/>", $post_data['note']);
		$insert_data = [
			'fa_acct_id' => $post_data['fa_acct_id'],
			'note'       => $new_note
		];
		$this->fapplication_model->insert_note($insert_data);
	}
	public function update_lead_note_detail()
	{
		$post_data = $this->input->post();
		$this->fapplication_model->update_lead_note_detail($post_data);
	}
	public function get_all_notes()
	{
		$post_data = $this->input->post();
		$result = $this->fapplication_model->get_all_notes($post_data);
		$table_content = "";
		foreach ($result as $res_key => $res_val) 
		{
			$note = $res_val['note'];
			$table_content .= "<tr data-note-id='{$res_val['id']}' class='history_list'>
								<td>
									{$res_val['created_at']}
									<br>
									{$note}
								</td>
							   </tr>";
		}
		if(count($result) < 1)
			$table_content = "";
		$json_data = array(
					'table_content' => $table_content
						);
		echo json_encode($json_data);
	}
	public function get_note()
	{
		$return_data = [
			'note'      => "",
			'lead_note' => ""
		];
		$lead_note = "";
		$post_data = $this->input->post();
		$note = $this->fapplication_model->get_note($post_data['fa_acct_id']);
		$note = str_replace("<br/>", "\n", $note);
		if($post_data["lead_id"] != "")
		{
			$lead_note = $this->fapplication_model->get_lead_note_details($post_data['lead_id']);
		}
		$return_data = [
			'note'      => $note,
			'lead_note' => $lead_note
		];
		
		echo json_encode($return_data);
	}
	public function view_note()
	{
		$post_data = $this->input->post();
		$result = $this->fapplication_model->view_note($post_data);
		$note = "<p>" . $result['note'] . "</p>";
		$json_data= array('note' => $note, 'created_at' => $result['created_at']);
		echo json_encode($json_data);
	}
	public function delete_applicant()
	{
		$post_data = $this->input->post();
		$this->fapplication_model->delete_applicant($post_data);
	}
	public function get_new_cal_data()
	{
		$staff_results = $this->fapplication_model->get_all_fq_staff();
		$staff_option = "<option> -- Please select one -- </option>";
		foreach ($staff_results as $res_key => $res_val) 
		{
			$staff_option .= "<option value='{$res_val['id_user']}'>{$res_val['email']}</option>";
		}
		$makes_result = $this->fapplication_model->get_dropdown_data(array('code'=>1));
		$makes_option = "<option> -- Please select one -- </option>";
		foreach ($makes_result as $makes_key => $makes_val) 
		{
			$makes_option .= "<option data-id='{$makes_val['id_make']}' value='{$makes_val['name']}'>{$makes_val['name']}</option>";
		}
		$return_array = 
		[
			'staff_option' => $staff_option,
			'makes_option' => $makes_option
		];
		echo json_encode($return_array);
	}

	public function set_requirement_list()
	{
		$temp_array = [];
		$new_array = [];
		$order_array = [];
		$row_keys = [];
		// $id = $this->input->post('id_fq_account');
		// $order = $this->fapplication_model->validate_order($id);
		// $order_array = explode(',', $order);
		$rows = $this->fapplication_model->get_requirements_new();
		// foreach ($rows as $x_key => $x_val) 
		// {
		// 	$temp_array[$x_val['id_requirement']] = $x_val;
		// }
		// foreach ($rows as $r_key => $r_val) 
		// {
		// 	$row_keys[] = $r_val['id_requirement'];
		// }
		// $diff_array = array_diff($row_keys, $order_array);
		// $diff_array_2 = array_diff($order_array, $row_keys);

		// foreach ($order_array as $o_key => $o_val) 
		// {
		// 	if(isset($temp_array[(int)$o_val]))
		// 		$new_array[] = $temp_array[(int)$o_val];
		// }
		// foreach ($diff_array as $diff_key => $diff_val) 
		// {
		// 	if(isset($temp_array[$diff_val]))
		// 		$new_array[] = $temp_array[$diff_val];
		// }
		$modal_list = "";
		foreach ($rows as $key => $value) 
		{
			$modal_list .= "<tr class='tr_req_list' id='{$value['id_requirement']}' data-order='{$value['order']}' data-id='{$value['id_requirement']}'>";
			$modal_list .= "<td><i class='fa fa-pencil-square-o edit-req-detail'></i></td>";
			$modal_list .= "<td><i class='fa fa-trash-o delete-req-detail'></i></td>";
			$modal_list .= "<td class='editable-name'><input type='text' data-type='name' class='editable editable_name_input form-control input-xs' value='{$value['name']}' disabled></td>";
			$modal_list .= "<td class='editable-description'><input type='text' data-type='description' class='editable editable_desc_input form-control input-xs' value='{$value['description']}' disabled></td>";
			$modal_list .= "</tr>";
		}
		$json_array = [
			'req_table' => $modal_list
		];
		echo json_encode($json_array);
	}
	public function update_order()
	{
		$post_data = $this->input->post();
		// echo "<pre>";
		// print_r($post_data); die();
		$this->fapplication_model->update_order($post_data);
	}
	public function insert_requirement_details()
	{
		$post_data = $this->input->post();
		echo $this->fapplication_model->insert_requirement_details($post_data);
	}
	public function edit_requirement_details()
	{
		$post_data = $this->input->post();
		if($this->fapplication_model->edit_requirement_details($post_data))
			echo "success";
		else
			echo "fail";
	}
	public function delete_requirement_details()
	{
		$post_data = $this->input->post();
		if($this->fapplication_model->delete_requirement_details($post_data))
			echo "success";
		else
			echo "fail";
	}
	public function hide_permanent_requirement()
	{
		$post_data = $this->input->post();
		$this->fapplication_model->hide_permanent_requirement($post_data);
	}
	public function set_requirements($type = 0, $params = array(), $flags = array())
	{
		$class_green = "";
		$default_string = "";
		$result = $this->fapplication_model->get_requirements_new();
		$temp_string = "";
		// echo "<pre>";
		// print_r($result); die();
		$req_pan_array = $this->requirement_panel_rules($type, $params, $flags);
		$hidden_req_array = $this->fapplication_model->get_all_hidden_requirements($params['id_fq_account']);
		if($type == 1)
		{
			$class       = "requirements_section_row";
			$header      = "<h4>Initial Requirements</h4>";
			$dzone_class = "requirements-tempo";
			$ddown_id    = "new_req";
		}
		else
		{
			$class       ="";
			$header      ="";
			$dzone_class ="";
			$ddown_id    = "";
		}
		if(count($result) > 0)
		{
			$default_string .= "
								<div class='panel panel-default'>
									<div class='panel-body'>
										<div class='row row-input' style='margin-bottom: 15px;'>
											<div class='col-md-4  col-md-offset-4'>
												<a id='all_req' data-req='99' class='btn btn-primary btn-md all_req_button pull-right'>Document Merger</a>
											</div>
											<div class='col-md-4'>
												<div class='input-group pull-right'>
													<span class='input-group-addon btn btn-primary btn-md add_req' data-type='{$type}'>Add</span>
													<span class='input-group-addon' style='width:0px; padding-left:0px; padding-right:0px; border:none;'></span>
													<select id='{$ddown_id}' class='input-group-addon form-control input-xs {$ddown_id} ddown_req' style='text-align: left;'>
														
													</select>
												</div>
											</div>
										</div>
										<div class='row row-input {$class}'>";
			foreach ($result as $res_key => $res_val) 
			{
				$class_green = "";
				$hidden_class = "hidden";
				$class_ctr = $this->fapplication_model->get_requirements_class($params['id_fq_account'],$res_val['id_requirement']);
				if($class_ctr > 0)
					$class_green = "requirements_green";
				else
					$class_green = "requirements_white";
				if( in_array($res_val['id_requirement'], $req_pan_array) )
				{
					$hidden_class = "";
				}
				if( in_array($res_val['id_requirement'], $hidden_req_array) )
				{
					$hidden_class = "hidden";
				}
				$default_string .= "
					<div class='col-md-3' {$hidden_class}>
						<div class='row'>
							<div class='col-md-12'>
								<div class='panel panel-default'>
								
								<div class='req-panel panel-body {$class_green} requirements' data-req='{$res_val['id_requirement']}' data-type='{$type}' data-istemp='0'>

										<label title='{$res_val['name']}' class='f-label {$class_green} req_name' style=' white-space: nowrap;width: 150px; overflow: hidden;
										text-overflow: ellipsis;border: 1px solid #000000;'>{$res_val['name']}</label>
										
									
										<div class='pull-right'>
											<span class='dz-message' data-dz-message><i class='fa fa-upload req_button {$class_green}'></i></span>&nbsp;
											<a class='fa fa-desktop req_button {$class_green}'></a>&nbsp;
											<a class='fa fa-trash-o del_req text-danger' data-id-fq='{$params['id_fq_account']}' data-id='{$res_val['id_requirement']}' ></a>
										</div>

										

									</div>
								</div>
							</div>
						</div>
					</div>
					";
					/* class 'del_req' added inplace of 'hide_req' in delete button */
			}
			$temp_string = $this->get_temp_req($params['id_fq_account'], $type);
			$default_string .= $temp_string;
			$default_string .= "</div></div></div>";
		}
		return $default_string;
	}
	// REQUIREMENT RULES
	public function requirement_panel_rules($panel_type = 0, $params = array(), $flags = array())
	{
		$requirement_array = [];
		$loan_use        = $params['loan_use'];
		$type            = $params['customer_type'];
		$abn_active      = $params['abn_date'];
		$amt_to_finance  = $params['amt_to_finance'];
		$lender          = $params['lender'];
		$fapplication_id = $params['id_fq_account'];
		$app_count       = $params['applicant_count'];
		$managed_statement = "";
		$payout = "";
		$visa = "";
		$name_on_title = "";
		$assessment_type = "";
		// ID OF REQUIREMENTS IN REQUIREMENTS TABLE
		$requirement_array = [11,65,2,127,15,16,31,117,85,33,37,85,40,29,92,102,111,113];
		if($loan_use == "ANZ")
			$requirement_array = array_merge($requirement_array, array('88,46'));
		if($loan_use == "consumer")
			$requirement_array[] = 67;
		if($flags['name_on_title_flag'] == 1)
			$requirement_array[] = 22;
		if($flags['visa_flag'] == 1)
			$requirement_array[] = 118;
		if($flags['managed'] == 1 && $loan_use == "consumer")
			$requirement_array[] = 10;
		if($loan_use == "consumer" && $params['loan_type'] == "Chattel Mortgage")
			$requirement_array[] = 42;
		if($assessment_type == "Full Doc")
			$requirement_array[] = 102;
		if($params['payout'] > 0)
			$requirement_array[] = 12;
		if($params['gap'] > 0)
			$requirement_array[] = 37;
		if($params['lti'] > 0)
			$requirement_array[] = 38;
		
		return $requirement_array;
	}
	public function diarize()
	{
		$return_array = [];
		$post_data = $this->input->post();
		$temp_date = $post_data['date'];
		$temp_time = $post_data['time'];
		/* set alarm */
		$alarm_status = $post_data['alarm_status'];
		/* set alarm */
		if($temp_time == "")
			$temp_time = "01:00:00";
		$temp_date = str_replace("/", "-", $temp_date);
		$temp_date . " " . $temp_time;
		$final_date = date("Y-m-d H:i:s", strtotime($temp_date . " " . $temp_time));
		$this->fapplication_model->diarize($post_data['id_fq_account'], $final_date, $alarm_status);
		$temp_1 = date("Y-m-d", strtotime($final_date));
		$temp_2 = date("H:i:s", strtotime($final_date) + 60*30);
		$assignment_date_end = $temp_1 . " " . $temp_2;
		$return_array = [
			'start' => str_replace(" ", "T", $final_date),
			'end'   => str_replace(" ", "T", $assignment_date_end)
		];
		echo json_encode($return_array);
	}
	public function change_page()
	{
		$post_data = $this->input->post();
		if(trim($post_data['temp_file']) != '')
			unlink("./uploads/cq_requirements/temp/" . $post_data['temp_file']);
		$temp_file = $this->get_single_pdf_page($post_data['abspath'], $post_data['page_num']);
		$single_image_arr = $this->pdf_to_image($temp_file, $post_data['page_num']);
		$json_array = [
			'image'       => $single_image_arr['return_filename'],
			'abspath'     => base_url($single_image_arr['return_abspath']),
			'orig_width'  => $single_image_arr['orig_width'],
			'orig_height' => $single_image_arr['orig_height']
		];
		echo json_encode($json_array);
	}
	public function pdf_edit_init()
	{
		$post_data = $this->input->post();
		$file_name = $post_data['abspath'];
		$curr_directory = 'uploads/cq_requirements/';
		$final_file_path = base_url($curr_directory . $file_name);
		$pages_count = $this->get_pdf_count($final_file_path);
		$select_data = "<option value='0'> -- Pages -- </option>";
		for ($i=1; $i < $pages_count + 1; $i++) 
		{
			$select_data .= "<option val='{$i}'>{$i}</option>";
		}
		$json_array = [
				'select_data' => $select_data,
				'pages'       => $pages_count,
				'file_name'   => $file_name
					];
		echo json_encode($json_array);
	}
	public function get_pdf_count($abspath)
	{
		$im = new Imagick();
		$im->pingImage($abspath);
		return $im->getNumberImages();
	}
	public function get_single_pdf_page($file_name, $page)
	{
		$directory = './uploads/cq_requirements/temp/';
		$old_dir   = './uploads/cq_requirements/';
		$file_loc  = $directory . $file_name;
		$now       = date("Y-m-d g:i:s");
		$pdf = new PDFMerger;
		$pdf->addPDF($old_dir . $file_name, $page);
		$final_file_name = "single_".time()."_temp.pdf";
		$pdf->merge('file', $directory . $final_file_name);
		return $final_file_name;
	}
	public function pdf_to_image($file_name, $page = "0")
	{
		$pdf_file = './uploads/cq_requirements/temp/'.$file_name;
		$save_to  = str_replace('.pdf', '', $pdf_file . "_" . $this->data['user_id']) .'.jpg';
		$return_filename = str_replace('.pdf', '', $file_name) . "_" . $this->data['user_id'] . ".jpg";
		$return_abspath = ltrim($save_to, './');
		
		$img = new Imagick();
		$d = $this->get_image_size("{$pdf_file}[0]");
		$w = $d['width']; 
		$h = $d['height'];
		$img->setResolution(200, 200);
		
		$img->readImage("{$pdf_file}[0]");
		$img->setimageformat('jpeg');
		$img->setImageCompression(imagick::COMPRESSION_JPEG); 
		$img->setImageCompressionQuality(100);
		 
		$img->writeImages($save_to, false);
		unlink($pdf_file);
		$return_array = [
			'return_filename' => $return_filename,
			'return_abspath'  => $return_abspath,
			'orig_width'      => $w,
			'orig_height'     => $h
		];
		return $return_array;
	}
	public function get_image_size($file)
	{
		// $file = './uploads/cq_requirements/temp/' . $img;
		$img = new Imagick();
		$img->readImage($file);
		$d = $img->getImageGeometry(); 
		$w = $d['width']; 
		$h = $d['height'];
		$json_array = [
			'height' => $h,
			'width'  => $w
		];
		return $json_array;
	}
	public function delete_temp_image ()
	{
		$post_data = $this->input->post();
		unlink('./uploads/cq_requirements/temp/'.$post_data['abspath']);
	}
	public function export_pdf()
	{
		$data = $_POST["data"];
		$data = str_replace('[removed]', '', $data);
		$data = base64_decode($data);
		$fname = time();
		$dir = "./uploads/cq_requirements/temp/".$fname.".jpg";

		file_put_contents($dir, $data);
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$base_file = base_url('uploads/cq_requirements/temp/'.$fname.".jpg");
		$pdfFilePath = FCPATH."/uploads/cq_requirements/temp/".$fname.".pdf";
		$html = "<html>	<head>	</head>	<body>	<img src='{$base_file}' />	</body>	</html>";
		$pdf->WriteHTML($html);
		$pdf->Output($pdfFilePath, 'F');
		// move_uploaded_file($file_tmp, $pdfFilePath);
	}
	public function substring_index($subject, $delim, $count) 
    {
        if ($count < 0) {
            return implode($delim, array_slice(explode($delim, $subject), $count));
        } 
        else {
            return implode($delim, array_slice(explode($delim, $subject), 0, $count));
        }
    }
	public function get_dealer_fields()
	{
		$id = $this->input->post('id');
		$result = $this->fapplication_model->get_dealer_fields($id);
		echo json_encode($result);
	}
	public function annotate_pdf()
	{
		$orig_file_name = "";
		$now = date('Y-m-d_H-i-s');
		$pdf = new FPDI();
		$post_data = $this->input->post();
		$data = $this->data;
		$fq_acct_id = $this->input->post('fq_acct_id');
		$arr = $post_data['final_array_anot'];
		$pic_array = $post_data['sig_anot'];
		unset($arr[0]);
		unset($pic_array[0]);
		// echo "<pre>";
		// print_r($pic_array); die();
		$directory = './uploads/cq_requirements/';
		$count = $pdf->setSourceFile($directory.$post_data['orig_file_name']);
		for($i=1; $i<=$count; $i++)
		{
			$pdf->AddPage();
			$tplIdx = $pdf->importPage($i);
			$pdf_h = $pdf->GetPageHeight();
			$pdf_w = $pdf->GetPageWidth();
			$pdf->useTemplate($tplIdx, 0, 0, 0);
			$pdf->SetMargins(0,0,0);
			// echo $pdf_h; echo "<br>"; echo $pdf_w;
			if(isset($pic_array[$i]))
			{
				foreach ($pic_array[$i] as $p_key => $p_val)
				{
					$image = "";
					$size = -500;
					$pic_x = 0.00;
					$pic_y = 0.00;
					if($p_val['x'] == "NaN")
						continue;
					$pic_x = ($p_val['x'] * 1.35) * $pdf_w;
					$pic_y = ($p_val['y'] * .6) * $pdf_h;
					// $pic_x = $p_val['x'] * $pdf_w;
					// $pic_y = $p_val['y'] * $pdf_h;
					$image = "http://myelquoto.com.au/assets/img/paul-sig-2.png";
					if($p_val['image_flag'] == 1)
					{
						$image = "http://myelquoto.com.au/assets/img/paul-sig-2.png";
						$size = -500;
					}
					else
					{
						$image = "http://myelquoto.com.au/assets/img/check.png";
						$size = -800;
					}
					$pdf->Image($image,$pic_x,$pic_y,$size);
				}
			}
			if(empty($arr[$i]))
				continue;
			foreach ($arr[$i] as $t_key => $t_val)
			{ 
				$pdf->SetFont($t_val['anot_font']);
				$pdf->SetFontSize($t_val['anot_size']);
				$pdf->SetTextColor(255,0,0);
				$x = 0.00;
				$y = 0.00;
				// $x = $t_val['temp_x'] * $pdf_w;
				// $y = ($t_val['temp_y'] * .85) * $pdf_h;
				$x = $t_val['temp_x'] * $pdf_w;
				$y = $t_val['temp_y'] * $pdf_h;
				
				$pdf->SetXY($x, $y);
				$pdf->Write(0, $t_val['anot_text']);
			}
		}
		$orig_file_name = str_replace('.pdf', '', $post_data['orig_file_name']);
		$final_file_name = $orig_file_name . "_edited_" . $now . ".pdf";
		$pdf->Output('./uploads/cq_requirements/'.$final_file_name, 'F');
		$insert_data = [
			'file_name'  => $final_file_name,
			'fq_acct_id' => $fq_acct_id,
			'user_id'    => $data['user_id']
		];
		$this->fapplication_model->upload_merged_document_new($insert_data);
	}
	public function open_annot_modal()
	{
		$post_data = $this->input->post();
		$files_array   = [];
		$abspath_array = [];
		$return_array  = [];
		$directory     = FCPATH . '/uploads/cq_requirements/temp/';
		$orig_file_dir = FCPATH . "/uploads/cq_requirements/";
		$now           = time();
		$pages_count     = 0;
		$final_file_path = "";
		$final_file_path = $orig_file_dir . $post_data['filename'];
		$pages_count = $this->get_pdf_count($final_file_path);
		for ($i=1; $i < $pages_count + 1; $i++) 
		{
			$files_array[] = $this->pdf_to_image_temp($post_data['filename'], $i - 1, $now, "1");
		}
		
		$return_array = [
			'files'             => $files_array,
			'original_filename' => $post_data['filename']
		];
		echo json_encode($return_array);
	}
	public function open_demo_merger()
	{
		$post_data = $this->input->post();
		// echo "<pre>";
		// print_r($post_data); die();
		$files_array   = [];
		$abspath_array = [];
		$return_array  = [];
		$temp_file = 'selection.pdf';
		$directory = FCPATH . '/uploads/cq_requirements/temp/';
		$orig_file_dir = FCPATH . "/uploads/cq_requirements/";
		$now       = time();
		$pdf = new FPDI();
		
		foreach ($post_data['id_req_up_arr'] as $key => $val) 
		{
			$batch = (string)(1 + $key);
			$pages_count     = 0;
			$final_file_path = "";
			$final_file_path = $orig_file_dir . $post_data['name_arr'][$key];
			// $pages_count = $this->get_pdf_count($final_file_path);
			$pages_count = $pdf->setSourceFile($final_file_path);
			for ($i=1; $i < $pages_count + 1; $i++) 
			{
				$files_array[$key][] = $this->pdf_to_image_temp($post_data['name_arr'][$key], $i - 1, $now, $batch);
			}
		}
		
		
		$return_array = [
			'files' => $files_array
		];
		echo json_encode($return_array);
	}
	public function pdf_to_image_temp($file_name, $page = "0", $now, $batch)
	{
		$page = (String)$page;
		$pdf_file = './uploads/cq_requirements/'.$file_name;
		$save_to_file = './uploads/cq_requirements/temp/'.$file_name;
		$save_to  = str_replace('.pdf', '', $save_to_file . "_" . $this->data['user_id'] . "_" . $batch . "_" . $page . "_" . $now) .'.jpg';
		$return_filename = str_replace('.pdf', '', $file_name) . "_" . $this->data['user_id'] . "_" . $batch . "_" . $page . "_" . $now . ".jpg";
		$return_abspath = ltrim($save_to, './');
		$return_abspath = base_url($return_abspath);
		
		$img = new Imagick();
		$d = $this->get_image_size("{$pdf_file}[".$page."]");
		$w = $d['width']; 
		$h = $d['height'];
		$img->setResolution(72, 72);
		
		$img->readImage("{$pdf_file}[".$page."]");
		// $img->resizeImage(800,800, imagick::FILTER_LANCZOS, 1, true);
		$img->setimageformat('jpeg');
		$img->setImageCompression(imagick::COMPRESSION_JPEG); 
		$img->setImageCompressionQuality(100);
		 
		$img->writeImages($save_to, false);
		$return_array = [
			'return_filename' => $return_filename,
			'return_abspath'  => $return_abspath,
			'orig_width'      => $w,
			'orig_height'     => $h,
			'orig_file_name'  => $file_name
		];
		return $return_array;
	}
	public function final_merge()
	{
		$post_data  = $this->input->post();
		$data = $this->data;
		
		$id_array   = $this->input->post('id_array');
		$file_array = $this->input->post('file_array');
		$file_name  = $this->input->post('file_name');
		$fq_acct_id = $this->input->post('fq_acct_id');
	
		$temp_file = 'selection.pdf';
		$directory = './uploads/cq_requirements/';
		$now       = date("Y-m-d H:i:s");
		$pdf = new PDFMerger;
		foreach ($id_array as $key => $val) 
		{
			$pdf->addPDF($directory . $file_array[$key], $val);
		}
		$file_name = str_replace(" ", "_", $file_name);
		$final_file_name = $file_name . "_" . time(). ".pdf";
		// $pdf->merge('file', $directory . $final_file_name);
		// $file_url = base_url("uploads/cq_requirements/temp/" . $final_file_name);
		// header('Content-Type: application/pdf');
		// header("Content-Transfer-Encoding: Binary");
		// header("Content-disposition: attachment; filename=".$pdfname);
		// readfile($file_url);
		$pdf->merge('file', $directory . $final_file_name);
		$insert_data = [
			'file_name'  => $final_file_name,
			'fq_acct_id' => $fq_acct_id,
			'user_id'    => $data['user_id']
		];
		$this->fapplication_model->upload_merged_document_new($insert_data);
	}
	public function delete_temporary_pages()
	{
		$post_data = $this->input->post();
		$directory = './uploads/cq_requirements/temp/';
		foreach ($post_data['return_array'] as $key => $val) 
		{
			unlink($directory . $val);
		}
	}
	public function temp_merge()
	{
		$id_array = $this->input->post('id_array');
		
		$new_id_arr = explode(",", $id_array);
		$temp_file = 'selection.pdf';
		$directory = './uploads/cq_requirements/temp/';
		$now       = date("Y-m-d g:i:s");
		$pdf = new PDFMerger;
		foreach ($new_id_arr as $key => $val) 
		{
			$page = 0;
			$page = $val + 1;
			$pdf->addPDF($directory . $temp_file, $page);
		}
		$final_file_name = "MERGED_".time()."_temp.pdf";
		// $pdf->merge('file', $directory . $final_file_name);
		// $file_url = base_url("uploads/cq_requirements/temp/" . $final_file_name);
		// header('Content-Type: application/pdf');
		// header("Content-Transfer-Encoding: Binary");
		// header("Content-disposition: attachment; filename=".$pdfname);
		// readfile($file_url);
		$pdf->merge('download', $final_file_name);
	}
	public function get_sent_email()
	{
		$id = $this->input->post('id');
		$fq_acct_id = $this->input->post('fq_acct_id');
		$data = $this->data;
		$att_option = "<option value=''></option>";
		$attachments_res = $this->fapplication_model->get_all_requirements_attachments($fq_acct_id, $data['user_id']);
		foreach ($attachments_res as $key => $val) 
		{
			$att_option .= "<option data-id='{$val['id_req_up']}' value='{$val['file_name']}'>{$val['file_name']}</option>";
		}
		$email_trail = $this->fapplication_model->get_sent_email($id);
		$recipient_arr  = [];
		$attachment_arr = [];
		$recipient_arr = explode(",", $email_trail['sent_to']);
		$attachment_arr = explode(",", $email_trail['attachment']);
		$email_trail_arr = array(
			"message"    => $email_trail['message'],
			"subject"    => $email_trail['subject'],
			"attachment" => $attachment_arr,
			"recipients" => $recipient_arr,
			"att_option" => $att_option
		);
		echo json_encode($email_trail_arr);
	}
	public function get_email_template () 
	{
		$email_template_id = $this->input->post('id');
		$fq_acct_id = $this->input->post('fq_acct_id');
		$data = $this->data;

		$email_template = $this->fapplication_model->get_email_template($email_template_id);

		$query = "select * from requirement_uploads where (fk_account = {$fq_acct_id}) OR (fk_account = 0);";
		$attachments_res = $this->db->query($query)->result_array();
		

		$attach = '';
		$attachments = explode("***",$email_template['attachment']);
		foreach($attachments as $ak => $av){
			$attach.= '<div class="input-group email_attachment_group" style="margin-bottom: 10px;">
			<select class="form-control input-sm edit_email_attachment_select" name="edit_email_attachment_select[]" id="edit_email_attachment_select">';
			$attach.= "<option value=''></option>";
			foreach ($attachments_res as $key => $val) 
			{
				if($val['file_name'] == $av){
					$attach.= "<option data-id='{$val['id_req_up']}' selected value='{$val['file_name']}'>{$val['orig_filename']}</option>";
				}else{
					$attach.= "<option data-id='{$val['id_req_up']}' value='{$val['file_name']}'>{$val['file_name']}</option>";
				}
			
			}
			$attach.= '</select>
			<span class="input-group-addon add_attachment" style="cursor: pointer;cursor: hand;"><i class="fa fa-plus" style="display:block"></i></span>
			<span class="input-group-addon remove_attachment" style="cursor: pointer;cursor: hand;"><i class="fa fa-times"></i></span>
			</div>';
		}
		
		
		$email_template_arr = array(
			"description" => $email_template['description'],
			"subject"     => $email_template['subject'],
			"content"     => $email_template['content'],
			"attachment"  => $attach,
			"recipients" => $email_template['recipients'],
		);
		echo json_encode($email_template_arr);
	}
    
    public function get_system_email_template($modal_place='') 
	{
		$email_template_id = $this->input->post('id');
		
        $data = $this->data;
		$email_template = $this->fapplication_model->get_system_email_template($email_template_id);
		$email_template_arr = array(
			"description" => $email_template['description'],
			"subject"     => $email_template['subject'],
			"content"     => $email_template['content'],
		);
		if($modal_place == 'client_modal') {
			$this->load->library('encrypt');
			$post_data = $this->input->post();
	        $lead_id = $post_data['id_lead'];
	        $lead = $this->lead_model->get_lead($post_data['id_lead']);
	        $from_name = $lead['qs_name'];
	        $from_email = $lead['qs_email'];
	        $to_email = $lead['lead_email'];
	        
	        $to_name = substr($lead['lead_name'],0,strpos($lead['lead_name'], ' '));
	        
	        if(empty($to_name) || $to_name == ''){
	            $to_name = $lead['lead_name'];
	        }
	        
	        //print_r($lead);exit;
	        
	        $cq_number = 'FQ'.str_pad($lead['id_fq_account'], 5, '0',STR_PAD_LEFT);
	        if(isset($post_data['id_tradein']) && !empty($post_data['id_tradein'])){
	            $rb_data = $this->fapplication_model->get_column_value_by_id('tradein_new','rb_data',array('id_tradein' => $post_data['id_tradein']));
	            $car_name = $this->fapplication_model->get_column_value_by_id('rb_data','name',array('car_id' => $rb_data));
				$link_url = site_url('Client-trade-valuation').'/'.$lead_id.'/'.$this->encrypt->encode($post_data['id_tradein']);
	            $link_url = "<a href=".$link_url.">click here</a>";
	        }else if(isset($post_data['id_quote_request']) && !empty($post_data['id_quote_request'])){
	            
	            $rb_data = $this->fapplication_model->get_column_value_by_id('quote_requests','rb_data',array('id_quote_request' => $post_data['id_quote_request']));            
	            $car_name = $this->fapplication_model->get_column_value_by_id('rb_data','name',array('car_id' => $rb_data));
	            $link_url = site_url('Client-trade-valuation').'/'.$lead_id.'/'.$this->encrypt->encode('id_quote_request');
	            $link_url = "<a href=".$link_url.">click here</a>";
	        }
	        $content = $email_template_arr['content'];
			$content = str_replace("@@FQ_LEAD_NUMBER@@",$cq_number,$content);
	        $content = str_replace("@@CLIENT_NAME@@",$to_name,$content);
	        //$content = str_replace("@@EMAIL_PARAGRAPH@@",$email_paragraph,$content);
	        $content = str_replace("@@SUBMIT_URL@@",$link_url,$content);
	        $content = str_replace("@@NOTE@@",$notes,$content);
	        $content = str_replace("@@CAR_NAME@@",$car_name,$content);
	        $email_template_arr['content'] = $content;
			echo json_encode($email_template_arr);
		}
		elseif ($modal_place == 'dealer_modal') {
			$this->load->library('encrypt');
			$post_data = $this->input->post();
			$lead_id = $post_data['id_lead'];
	        $dealer_id = $post_data['dealer_id'];
	        
	        $notes = $post_data['mail_text'];
	
	        $lead = $this->lead_model->get_lead($lead_id);
	        $dealer_detail = $this->user_model->get_dealer($dealer_id);
		 
			$fq_dealer_data = $this->fapplication_model->get_fq_dealer_data($lead_id);
		
	        $from_name = $lead['qs_name'];
	        $from_email = $lead['qs_email'];
	        $to_email = $dealer_detail['email'];
	        
	        $to_name = substr($dealer_detail['name'],0,strpos($dealer_detail['name'], ' '));
	        
	        if(empty($to_name) || $to_name == ''){
	            $to_name = $dealer_detail['name'];    
	        }
	        
	        $cq_number = 'FQ'.str_pad($lead['id_fq_account'], 5, '0',STR_PAD_LEFT);
	        $rb_data = $this->fapplication_model->get_column_value_by_id('tradein_new','rb_data',array('id_tradein' => $post_data['id_tradein']));
	        $car_name = $this->fapplication_model->get_column_value_by_id('rb_data','name',array('car_id' => $rb_data));
	        $link_url = site_url('Dealer-trade-valuation').'/'.$lead_id.'/'.$post_data['id_tradein'].'/'.$this->encrypt->encode($dealer_id);
	        $link_url = "<a href=".$link_url.">click here</a>";
	        $content = $email_template_arr['content'];
	        $content = str_replace("@@FQ_LEAD_NUMBER@@",$cq_number,$content);
	        $content = str_replace("@@CLIENT_NAME@@",$to_name,$content);
	        //$content = str_replace("@@EMAIL_PARAGRAPH@@",$email_paragraph,$content);
	        $content = str_replace("@@SUBMIT_URL@@",$link_url,$content);
	        $content = str_replace("@@NOTE@@",$notes,$content);
			$content = str_replace("@@CAR_NAME@@",$car_name,$content);
			$content = str_replace("@@CLIENT_POSTCODE@@",$fq_dealer_data['postcode'],$content);
	        $email_template_arr['content'] = $content;
			echo json_encode($email_template_arr);
		}
		elseif ($modal_place == 'wholesaler_modal') {
			$this->load->library('encrypt');
			$post_data = $this->input->post();
			$lead_id = $post_data['id_lead'];
	        $dealer_id = $post_data['dealer_id'];
	        
	        $notes = $post_data['mail_text'];
	        
	        $lead = $this->lead_model->get_lead($lead_id);
	        $dealer_detail = $this->user_model->get_dealer($dealer_id);
	        //echo '<pre>';print_r($lead);
	        $from_name = $lead['qs_name'];
	        $from_email = $lead['qs_email'];
	        $to_email = $dealer_detail['email'];
			
			$fq_dealer_data = $this->fapplication_model->get_fq_dealer_data($lead_id);
		

	        $to_name = substr($dealer_detail['name'],0,strpos($dealer_detail['name'], ' '));
	        
	        if(empty($to_name) || $to_name == ''){
	            $to_name = $dealer_detail['name'];    
	        }
	        
	        $cq_number = 'FQ'.str_pad($lead['id_fq_account'], 5, '0',STR_PAD_LEFT);
	        $rb_data = $this->fapplication_model->get_column_value_by_id('tradein_new','rb_data',array('id_tradein' => $post_data['id_tradein']));
	        $car_name = $this->fapplication_model->get_column_value_by_id('rb_data','name',array('car_id' => $rb_data));
	        $link_url = site_url('Dealer-trade-valuation').'/'.$lead_id.'/'.$post_data['id_tradein'].'/'.$this->encrypt->encode($dealer_id);
	        $link_url = "<a href=".$link_url.">click here</a>";
	        $content = $email_template_arr['content'];
	        $content = str_replace("@@FQ_LEAD_NUMBER@@",$cq_number,$content);
	        $content = str_replace("@@CLIENT_NAME@@",$to_name,$content);
	        //$content = str_replace("@@EMAIL_PARAGRAPH@@",$email_paragraph,$content);
	        $content = str_replace("@@SUBMIT_URL@@",$link_url,$content);
	        $content = str_replace("@@NOTE@@",$notes,$content);
			$content = str_replace("@@CAR_NAME@@",$car_name,$content);
			$content = str_replace("@@CLIENT_POSTCODE@@",$fq_dealer_data['postcode'],$content);
	        $email_template_arr['content'] = $content;
			echo json_encode($email_template_arr);
		}
		elseif ($modal_place == 'invited_dealers_modal') {
			$post_data = $this->input->post();
			$lead_id = $post_data['id_lead'];
	        $dealer_id = $post_data['dealer_id'];
	        $dealer_id = explode('-', $dealer_id)[1];
	        $quote_request_id = $post_data['id_quote_request'];
			$lead = $this->lead_model->get_lead($lead_id);
			$user_details = $this->user_model->get_dealer_for_email($dealer_id);
			$dealer_requests = $this->user_model->getRow('dealer_requests',array('fk_quote_request' => $quote_request_id, 'fk_user' => $dealer_id));
			$query = "SELECT * FROM `rb_data`  WHERE car_id = '".$lead['rb_data']."' LIMIT 1";
			$result = $this->db->query($query);
			
			if (count($result)==0){
					$car_name = "N/A";
			}else{
				foreach ($result->result() as $row)
				{
					$car_name = $row->name;
				}
			}
			$cq_number = 'FQ'.str_pad($lead['id_fq_account'], 5, '0',STR_PAD_LEFT);
			$manager_name = $user_details['dealer_manager_name'];
			$email_paragraph = isset($dealer_requests->mail_text) && !empty($dealer_requests->mail_text) ? $dealer_requests->mail_text : '';
			$link_url = "<a href=".site_url("Process/submitquote_dealer/".$lead_id."/".$dealer_id).">click here</a>";

			$content = $email_template_arr['content'];
                
            $content = str_replace("@@FQ_LEAD_NUMBER@@",$cq_number,$content);
            $content = str_replace("@@MANGER_NAME@@",$manager_name,$content);
            $content = str_replace("@@EMAIL_PARAGRAPH@@",$email_paragraph,$content);
            $content = str_replace("@@SUBMIT_URL@@",$link_url,$content);
            $content = str_replace("@@CAR_NAME@@",$car_name,$content);
            $email_template_arr['content'] = $content;
			echo json_encode($email_template_arr);
		}
		else if($modal_place == 'add_dealer_modal') {
			
			$post_data = $this->input->post();
			$lead_id = $post_data['id_lead'];
			$dealer_id = $post_data['dealer_id'];
	        // $dealer_id = explode('-', $dealer_id)[1];
	        $dealer_id = explode('-', $dealer_id);
	        $dealer_id = end($dealer_id);
	        $quote_request_id = $post_data['id_quote_request'];
	        $lead = $this->lead_model->get_lead($lead_id);
	        $user_details = $this->user_model->get_dealer_for_email($dealer_id);
	        $dealer_requests = $this->user_model->getRow('dealer_requests',array('fk_quote_request' => $quote_request_id, 'fk_user' => $dealer_id));
			$query = "SELECT * FROM `rb_data`  WHERE car_id = '".$lead['rb_data']."' LIMIT 1";
			$result = $this->db->query($query);
			
			if (count($result)==0){
					$car_name = "N/A";
			}else{
				foreach ($result->result() as $row)
				{
					$car_name = $row->name;
				}
			}
	        $cq_number = 'FQ'.str_pad($lead['id_fq_account'], 5, '0',STR_PAD_LEFT);
	        $manager_name = '';
	        if(!empty($user_details['dealership_contact_boxs'])){
	        	$manager_name = $user_details['dealer_manager_name'];
	        }
	        if(!empty(trim($user_details['contacts']))){
	        	$contect_details = json_decode(stripslashes($user_details['contacts']));
	        	if(!empty($contect_details)){
	                foreach($contect_details AS $key => $val){
	                    if(!empty($val->contact_boxs) && $val->contact_boxs->quote_request_recipient == 'on' ){
	                    	$manager_name = $val->contact_fullname;
	                    }
	                }
	            }
	        }
	        $email_paragraph = isset($dealer_requests->mail_text) && !empty($dealer_requests->mail_text) ? $dealer_requests->mail_text : '';
	        $link_url = "<a href=".site_url("Process/submitquote_dealer/".$lead_id."/".$dealer_id).">click here</a>";
	        $content = $email_template_arr['content'];
	        $content = str_replace("@@FQ_LEAD_NUMBER@@",$cq_number,$content);
            $content = str_replace("@@MANGER_NAME@@",$manager_name,$content);
            $content = str_replace("@@EMAIL_PARAGRAPH@@",$email_paragraph,$content);
            $content = str_replace("@@SUBMIT_URL@@",$link_url,$content);
            $content = str_replace("@@CAR_NAME@@",$car_name,$content);
            $email_template_arr['content'] = $content;
			echo json_encode($email_template_arr);
		}
		elseif ($modal_place == 'start_tender_modal') {
			
			$post_data = $this->input->post();
			$lead_id = $post_data['id_lead'];
			$lead = $this->lead_model->get_lead($lead_id);
			$fq_dealer_data = $this->fapplication_model->get_fq_dealer_data($lead_id);
			
			$cq_number = 'FQ'.str_pad($lead['id_fq_account'], 5, '0',STR_PAD_LEFT);
			$email_paragraph = $quote_data['email_paragraph'];
			$query = "SELECT * FROM `rb_data`  WHERE car_id = '".$lead['rb_data']."' LIMIT 1";
			$result = $this->db->query($query);
			if (count($result)==0)
			{
				$car_name = "N/A";
				$car_desc = '';
			}
			else
			{
				foreach ($result->result() as $row)
				{
					$car_name = $row->name;
					$des = unserialize($row->des);
					$car_desc = implode(', ',$des);
				}
			}
			$qro_query = "SELECT IF(o.items <> '',CONCAT(o.name,'(', o.items, ')'), o.name) AS `option` FROM quote_request_options qro JOIN options o ON qro.fk_option = o.id_option WHERE qro.fk_quote_request = '".$lead['id_quote_request']."' AND qro.deprecated <> 1";
			$qro_result = $this->db->query($qro_query);
			if ($qro_result->result()<>0)
			{
				foreach ($qro_result->result() as $qro_row)
				{
                    $lead_option = $qro_row->option;
				}
			}
			$qra_query = "SELECT name, description FROM quote_request_accessories WHERE fk_quote_request = '".$lead['id_quote_request']."' AND deprecated <> 1";
			$qra_result = $this->db->query($qra_query);
			if ($qra_result->result()<>0)
			{
				$accessories = array();
				foreach ($qra_result->result() as $qra_row)
				{
                    // $lead_option = $qra_row->name;
                    array_push($accessories, $qra_row->name);
				}
				$accessories = implode(', ', $accessories);
                $lead_option = $accessories;
			}
			$content = $email_template_arr['content'];
			$content = str_replace("@@FQ_LEAD_NUMBER@@",$cq_number,$content);
			$content = str_replace("@@LEAD_NAME@@",trim($fq_dealer_data['name']),$content);
			$content = str_replace("@@LEAD_VEHICLE_DETAIL@@",$car_name.','.$car_desc,$content);
			$content = str_replace("@@LEAD_VEHICLE_COLOR@@",$lead['colour'],$content);
			$content = str_replace("@@LEAD_OPTION@@",$lead_option,$content);
			$content = str_replace("@@LEAD_REG_TYPE@@",$lead['registration_type'],$content);
			$linkurl = site_url("Process/confirmtender/'.$lead_id.'");
			$content = str_replace("@@confirm_vehicle@@",$linkurl,$content);
			$content = str_replace("@@POSTCODE@@",$fq_dealer_data['postcode'],$content);
			$email_template_arr['content'] = $content;
			echo json_encode($email_template_arr);
		}elseif($modal_place == 'client_purchase_order'){
			$post_data = $this->input->post();
			$lead_id = $post_data['id_lead'];
			$lead = $this->lead_model->get_lead($lead_id);
			$fq_dealer_data = $this->fapplication_model->get_fq_dealer_data($lead_id);
			$cq_number = 'FQ'.str_pad($lead['id_fq_account'], 5, '0',STR_PAD_LEFT);

			$query = "SELECT * FROM `rb_data`  WHERE car_id = '".$lead['rb_data']."' LIMIT 1";
			$result = $this->db->query($query);
			if (count($result)==0)
			{
				$car_name = "N/A";
				$car_desc = '';
			}
			else
			{
				foreach ($result->result() as $row)
				{
					$car_name = $row->name;
					$des = unserialize($row->des);
					$car_desc = implode(', ',$des);
				}
			}

			$dealer_id= $lead['dealer_id'];
			$dealer_detail = $this->user_model->get_dealer($dealer_id);
			$from_name = $lead['qs_name'];
	        $from_email = $lead['qs_email'];
	        $to_email = $dealer_detail['email'];
	        
	        $to_name = substr($dealer_detail['name'],0,strpos($dealer_detail['name'], ' '));
	        
	        if(empty($to_name) || $to_name == ''){
	            $to_name = $dealer_detail['name'];    
			}
			
			$client = $this->fapplication_model->get_fq_dealer_data($lead_id);
			
			$data['type'] = $type;
			$this->db->select('*');
			$this->db->from('computation');
			$this->db->where('lead_id', $lead_id);
			$computataion_data = $this->db->get()->result_array();
			
			$computation_data = $computataion_data[0];

			if($computation_data['method_of_purchase'] == 'no_finance'){
				$method_of_purchase = 'No finance required, client purchasing outright';
			}else if($computation_data['method_of_purchase'] == 'own_finance'){
				$method_of_purchase = 'Client has organised their own finance';
			}else if($computation_data['method_of_purchase'] == 'finquote'){
				$method_of_purchase = "Finquote organising finance on the client's behalf";
			}else if($computation_data['method_of_purchase'] == 'dealer'){
				$method_of_purchase = "Dealer organising finance on the client's behalf";
			}

			$content = $email_template_arr['content'];
			$content = str_replace("@@FQ_Lead_Number@@",$cq_number,$content);
			$content = str_replace("@@Car_Name@@",$car_name,$content);
			$content = str_replace("@@CQ_NUMBER@@",$lead['cq_number'],$content);
			$content = str_replace("@@Client_First_Name@@",$client['name'],$content);
			$content = str_replace("@@Dealer_Primary_Contact_First_Name@@",$fq_dealer_data['name'],$content);
			$content = str_replace("@@Dealer_Primary_Contact_Surname_Name@@",$fq_dealer_data['surname'],$content);
			$content = str_replace("@@First_Name_Of_Dealer_Contact@@",$to_name,$content);
			$content = str_replace("@@Method_Of_Purchase@@",$method_of_purchase,$content);
			$email_template_arr['content'] = $content;
			$email_template_arr['subject'] = 'Purchase Order - '.$cq_number.' - '.$car_name.'';
			$att_option = "<option value=''></option>";
			$query = "select * from requirement_uploads where (fk_account = {$lead_id}) OR (fk_account = 0);";
			$attachments_res = $this->db->query($query)->result_array();
			foreach ($attachments_res as $key => $val) 
			{
			   $att_option .= "<option data-id='{$val['id_req_up']}' value='{$val['file_name']}'>{$val['orig_filename']}</option>";
			}
			$email_template_arr['email_attachment_select'] = $att_option;
			echo json_encode($email_template_arr);
			
		}elseif($modal_place == 'dealer_purchase_order'){
			$post_data = $this->input->post();
			$lead_id = $post_data['id_lead'];
			$lead = $this->lead_model->get_lead($lead_id);
			$fq_dealer_data = $this->fapplication_model->get_fq_dealer_data($lead_id);
			$cq_number = 'FQ'.str_pad($lead['id_fq_account'], 5, '0',STR_PAD_LEFT);

			$query = "SELECT * FROM `rb_data`  WHERE car_id = '".$lead['rb_data']."' LIMIT 1";
			$result = $this->db->query($query);
			if (count($result)==0)
			{
				$car_name = "N/A";
				$car_desc = '';
			}
			else
			{
				foreach ($result->result() as $row)
				{
					$car_name = $row->name;
					$des = unserialize($row->des);
					$car_desc = implode(', ',$des);
				}
			}

			$dealer_id= $lead['dealer_id'];
			$dealer_detail = $this->user_model->get_dealer($dealer_id);
			$from_name = $lead['qs_name'];
	        $from_email = $lead['qs_email'];
	        $to_email = $dealer_detail['email'];
	        
	        $to_name = substr($dealer_detail['name'],0,strpos($dealer_detail['name'], ' '));
	        
	        if(empty($to_name) || $to_name == ''){
	            $to_name = $dealer_detail['name'];    
			}
			
			$client = $this->fapplication_model->get_fq_dealer_data($lead_id);
		
			$data['type'] = $type;
			$this->db->select('*');
			$this->db->from('computation');
			$this->db->where('lead_id', $lead_id);
			$computataion_data = $this->db->get()->result_array();
			
			$computation_data = $computataion_data[0];

			if($computation_data['method_of_purchase'] == 'no_finance'){
				$method_of_purchase = 'No finance required, client purchasing outright';
			}else if($computation_data['method_of_purchase'] == 'own_finance'){
				$method_of_purchase = 'Client has organised their own finance';
			}else if($computation_data['method_of_purchase'] == 'finquote'){
				$method_of_purchase = "Finquote organising finance on the client's behalf";
			}else if($computation_data['method_of_purchase'] == 'dealer'){
				$method_of_purchase = "Dealer organising finance on the client's behalf";
			}

			$content = $email_template_arr['content'];
			$content = str_replace("@@Car_Name@@",$car_name,$content);
			$content = str_replace("@@Client_First_Name@@",$client['name'],$content);
			$content = str_replace("@@Client_Surname@@",$client['surname'],$content);
			$content = str_replace("@@Primary_Dealer_Contact_First_Name@@",$to_name,$content);
			$content = str_replace("@@Method_Of_Payment@@",$method_of_purchase,$content);

			$email_template_arr['content'] = $content;
			$email_template_arr['subject'] = 'New Purchase Order  - '.$car_name.' - '.$client['name'].' '.$client['surname'];

			
			echo json_encode($email_template_arr);
			
		}
		else {
			echo json_encode($email_template_arr);
		}
	}
	public function get_just_requirements()
	{
		$fq_acct_id = $this->input->post('fq_acct_id');
		$data = $this->data;
		$att_option = "<option value=''></option>";
		$attachments_res = $this->fapplication_model->get_all_requirements_attachments($fq_acct_id, $data['user_id']);
		foreach ($attachments_res as $key => $val) 
		{
			$att_option .= "<option data-id='{$val['id_req_up']}' value='{$val['file_name']}'>{$val['file_name']}</option>";
		}
		$email_arr = [
			'att_option' => $att_option
		];
		echo json_encode($email_arr);
	}
	public function new_tax_invoice_export()
	{
		$data = $this->data;
		$id = $this->input->post('id');
		$response = $this->fapplication_model->get_tax_invoice_details($id);
		if($response['loan_use'] == "consumer")
		{
			$address = $this->fapplication_model->get_first_address($id);
			$invoice_to_2   = ( isset($address['client_address']) ) ? $address['client_address'] : "";
			$temp_invoice_1 = ( isset($address['client_postcode']) ) ? $address['client_postcode'] : "";
			$temp_invoice_2 = ( isset($address['client_suburb']) ) ? $address['client_suburb'] : "";
			$invoice_to_3 = $temp_invoice_2 . ", " . $temp_invoice_1;
			$invoice_to_1 = $response['lead_name'];
		}
		else
		{
			$address = $this->fapplication_model->get_first_address($id);
			
			$invoice_to_1 = $response['abr_name'];
			// $invoice_to_2 = $response['trade_address'];
			// $invoice_to_3 = $response['trade_suburb'] . ", " . $response['trade_post_code'];
			$invoice_to_2   = ( isset($address['client_address']) ) ? $address['client_address'] : "";
			$temp_invoice_1 = ( isset($address['client_postcode']) ) ? $address['client_postcode'] : "";
			$temp_invoice_2 = ( isset($address['client_suburb']) ) ? $address['client_suburb'] : "";
			$invoice_to_3 = $temp_invoice_2 . ", " . $temp_invoice_1;
		}
		if($response['trade_check'] == 1)
		{
			$trade_val = "0.00";
		}
		else
		{
			$trade_val = $response['trade'];
		}
		$total_payable = $response['naf'] - ( (float)$response['est_fee'] + (float)$response['origination_fee'] + 6.80 + (float)$trade_val + (float)$response['payout']);
		$xy_arr = [
			'invoice_to_1' => [
				'x'    => 35,
				'y'    => 55.5,
				'text' => $invoice_to_1,
				'size' => 10
			],
			'invoice_to_2' => [
				'x'    => 35,
				'y'    => 61,
				'text' => $invoice_to_2,
				'size' => 10
			],
			'invoice_to_3' => [
				'x'    => 35,
				'y'    => 66,
				'text' => $invoice_to_3,
				'size' => 10
			],
			'deliver_to_1' => [
				'x'    => 130,
				'y'    => 55.5,
				'text' => $invoice_to_1,
				'size' => 10
			],
			'deliver_to_2' => [
				'x'    => 130,
				'y'    => 61,
				'text' => $invoice_to_2,
				'size' => 10
			],
			'deliver_to_3' => [
				'x'    => 130,
				'y'    => 66,
				'text' => $invoice_to_3,
				'size' => 10
			],
			'dealer' => [
				'x'    => 120,
				'y'    => 29,
				'text' => $response['dealer'],
				'size' => 10
			],
			'attn' => [
				'x'    => 120,
				'y'    => 34,
				'text' => $response['supplier_contact'],
				'size' => 10
			],
			'email' => [
				'x'    => 120,
				'y'    => 39.5,
				'text' => $response['supplier_email'],
				'size' => 10
			]
		];
		
		$pdf = new FPDI();
		$directory = './assets/pdf_templates/';
		$page_count = $pdf->setSourceFile($directory.'template_fq_tax_invoice.pdf');
		
		$pdf->AddPage();
		$tplIdx = $pdf->importPage(1);
		$pdf->useTemplate($tplIdx, 0, 0, 0);
		$pdf->SetFont('Helvetica');
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetMargins(0,0,0);
		$pdf->SetAutoPageBreak('auto',0);
		foreach ($xy_arr as $xy_key => $xy_val) 
		{
			$pdf->SetFontSize($xy_val['size']);//font size
			$pdf->SetXY($xy_val['x'], $xy_val['y']);
			$pdf->Write(0, $xy_val['text']);
		}
		$pdf->SetFontSize(10);
		$pdf->SetXY(173, 81);
		$pdf->Cell(20, .5, $response['car'] . " " . $response['year'] , 0, 0, 'R');
		$pdf->SetFontSize(10);
		$pdf->SetXY(173, 87);
		$pdf->Cell(20, .5, $response['make'], 0, 0, 'R');
		$pdf->SetFontSize(10);
		$pdf->SetXY(173, 93);
		$pdf->Cell(20, .5, $response['model'] . " " . $response['variant'], 0, 0, 'R');
		$pdf->SetFontSize(10);
		$pdf->SetXY(173, 209.5);
		$pdf->Cell(20, .5, "$ " . number_format($response['purchase_price'], 2), 0, 0, 'R');
		$pdf->SetFontSize(10);
		$pdf->SetXY(173, 215.5);
		$pdf->Cell(20, .5, "$ " . number_format($trade_val, 2), 0, 0, 'R');
		if($response['deposit_check'] != 1)
		{
			$pdf->SetFontSize(10);
			$pdf->SetXY(173, 228);
			$pdf->Cell(20, .5, "$ " . number_format($response['deposit'], 2), 0, 0, 'R');
		}
		$pdf->SetFontSize(10);
		$pdf->SetXY(173, 234);
		$pdf->Cell(20, .5, "$ " . number_format((float)$total_payable,2), 0, 0, 'R');
		$filename = time().'_'.$data['user_id'].'_'."tax_invoice";
		$pdfFilePath = FCPATH."/uploads/temp_files/".$filename.".pdf";
		// $pdf->Output();
		$pdf->Output($pdfFilePath, 'F');
		$return_array = [
			'abslink'   => "http://myelquoto.com.au/uploads/temp_files/".$filename.".pdf",
			'abspath'   => $pdfFilePath,
			'file_name' => $filename
		];
		
		echo json_encode($return_array);
	}
	public function send_tax_invoice_email ()
	{
		$data = $this->data;
		$post_data = $this->input->post();
		$to = $post_data['recipients'];
		$file = "";
		if($post_data['attachment'] != '')
			$file = $post_data['attachment'];
		date_default_timezone_set('Australia/Sydney');
		ini_set('max_execution_time', -1);
		$now = date("Y-m-d H:i:s");
		$complete_email = $this->fq_email_header.$post_data['email_message'].$this->fq_email_signature;
		$this->load->library('email');
		$this->email->clear();
		$this->email->set_mailtype('html');
		$this->email->to($to);
		$this->email->from($this->data['username'], $this->data['name']);
		$this->email->subject($post_data['email_subject']);
		$this->email->message($complete_email);
		if ($file <> "") { $this->email->attach($file);}
		if ( ! $this->email->send())
		{
			echo "error!";
		}
	}
	public function send_email_template ()
	{
		$data = $this->data;
		$trail_array = [];
		$post_data = $this->input->post();
		$to = $post_data['recipients'];
		
		date_default_timezone_set('Australia/Sydney');
		ini_set('max_execution_time', -1);
		$now = date("Y-m-d H:i:s");
		$complete_email = $this->fq_email_header.$post_data['email_message'];
		// $complete_email = $post_data['email_message'];
		$this->load->library('email');
		$this->email->clear();
		$this->email->set_mailtype('html');
		$this->email->to($to);
		$this->email->from($this->data['username'], $this->data['name']);
		$this->email->subject($post_data['email_subject']);
		$this->email->message($complete_email);
		$attachment_url= array();
		if(count($post_data['attachment_array']) > 0)
		{
			foreach ($post_data['attachment_array'] as $key => $value) 
			{
				$file = "";
				$file = $value;
				if($file != ""){
					$attachment_url[].='uploads/cq_requirements/' . $file;
					$file = "./uploads/cq_requirements/" . $file;
					$this->email->attach($file);
					
				}
			}
		}
		
		if ( ! $this->email->send())
		{
			echo "error!";
		}
		else
		{
			$attachments = implode(",", $post_data['attachment_array']);
			$attachment_urls = implode(",",$attachment_url);
			$trail_array = [
				'fk_user'    => $data['user_id'],
				'fk_account' => $post_data['id'],
				'attachment' => $attachments,
				'attachment_url' => $attachment_urls,
				'sent_to'    => $to,
				'subject'    => $post_data['email_subject'],
				'message'    => $complete_email,
				'created_at' => date('Y-m-d H:i:s')
			];
			$this->fapplication_model->email_audit_trail_model($trail_array);
		}
	}
	public function forward_email ()
	{
		$data = $this->data;
		$trail_array = [];
		$post_data = $this->input->post();
		$to = $post_data['recipients'];
		date_default_timezone_set('Australia/Sydney');
		ini_set('max_execution_time', -1);
		$now = date("Y-m-d H:i:s");
		$result = $this->fapplication_model->get_email_body($post_data['email_id']);
		$this->load->library('email');
		$this->email->clear();
		$this->email->set_mailtype('html');
		$this->email->to($to);
		$this->email->from($this->data['username'], $this->data['name']);
		$this->email->subject($post_data['email_subject']);
		$this->email->message($result['message']);
		$attachment_url= array();
		if(count($post_data['attachment_array']) > 0)
		{
			foreach ($post_data['attachment_array'] as $key => $value) 
			{
				$file = "";
				$file = $value;
				if($file != ""){
					$attachment_url[].='uploads/cq_requirements/' . $file;
					$file = FCPATH."/uploads/cq_requirements/" . $file;
					$this->email->attach($file);
					
				}			
			}
		}
		if ( ! $this->email->send())
		{
			echo "error!";
		}
		else
		{
			$attachments = implode(",", $post_data['attachment_array']);
			$attachment_urls = implode(",",$attachment_url);
			$trail_array = [
				'fk_user'    => $data['user_id'],
				'fk_account' => $post_data['fq_id'],
				'attachment' => $attachments,
				'attachment_url' => $attachment_urls,
				'sent_to'    => $to,
				'subject'    => $post_data['email_subject'],
				'message'    => $result['message'],
				'forwarded'  => 1,
				'created_at' => date('Y-m-d H:i:s')
			];
			$this->fapplication_model->email_audit_trail_model($trail_array);
		}
	}

	public function save_email_template ()
	{
		$data = $this->data;
		$post_data = $this->input->post();
		$this->fapplication_model->update_email_template($post_data);
	}
    
    public function save_system_email_template ()
	{
		$data = $this->data;
		$post_data = $this->input->post();
		$this->fapplication_model->update_system_email_template($post_data);
	}
	public function delete_email_template ()
	{
		$post_data = $this->input->post();
		$this->fapplication_model->delete_email_template($post_data);
	}
	public function get_email_list()
	{
		$html = "";
		$data = $this->data;
		$post_data = $this->input->post();
		$fq_id = $post_data['fq_id'];
		$email_list = $this->fapplication_model->get_email_list();
		$html .= '<table class="table table-striped table-condensed mb-none" style="white-space: nowrap;" id="datatables_email_list">
          <thead>
            <tr>
			  <td><i class="fa fa-pencil-square-o"></i></td>
			  <td><i class="fa fa-trash-o"></i></td>
              <td><b>Email</b></td>
            </tr>
          </thead>
          <tbody>';
            
        foreach ($email_list as $s_key => $s_val)
        {                     
			$html .= "<tr class='email_list_tr' data-id='{$s_val['id_email_list']}'>
						<td><a href='#' data-id='{$s_val['id_email_list']}' class='edit_email_list_item'><i class='fa fa-pencil-square-o'></i></a></td>
						<td><a href='#' data-id='{$s_val['id_email_list']}' class='delete_email_list_item'><i class='fa fa-trash-o'></i></a></td>
						<td><input data-id='{$s_val['id_email_list']}' type='text' class='form-control input-xs email_list_input' value='{$s_val['email']}' readonly></td>
					</tr>";
        
        }
            
        $html .='</tbody>
        </table>';
        echo $html;
	}
	public function add_email_list_item()
	{
		$email = $this->input->post("email");
		$this->fapplication_model->add_email_list_item($email);
	}
	public function update_email_list_item()
	{
		$post_data = $this->input->post();
		$this->fapplication_model->update_email_list_item($post_data['email'], $post_data['id']);
	}
	public function delete_email_list_item()
	{
		$id = $this->input->post("id");
		$this->fapplication_model->delete_email_list_item($id);
	}
	public function get_email_trail()
	{
		$html = "";
		$data = $this->data;
		$post_data = $this->input->post();
		$fq_id = $post_data['fq_id'];
		$sent_emails = $this->fapplication_model->get_email_trail($fq_id);
		$html .= '<table class="table table-bordered table-condensed mb-none" style="white-space: nowrap;" id="datatables_email_trail">
          <thead>
            <tr style="background-color: #f9f9f9;color: black;">
			  <td><i class="fa fa-eye"></i></td>
			  <td><i class="fa fa-mail-forward"></i></td>
              <td><b>Sender</b></td>
              <td><b>Sender Email</b></td>
              <td><b>Sent To</b></td>
              <td><b>Subject</b></td>
              <td><b>Attacment</b></td>
              <td><b>Forwarded</b></td>
              <td><b>Created at</b></td>
            </tr>
          </thead>
          <tbody style="color: #ffffff">';
            
        foreach ($sent_emails as $s_key => $s_val)
        {                     
        	$forwarded = "No";
        	if($s_val['forwarded'] == 1)
				$forwarded = "Yes";
			$attachment = explode(",",$s_val['attachment']);
			$attachment_url = explode(",",$s_val['attachment_url']);
			$attachmentHtml = '';
			foreach($attachment as $ak=>$attach){
				if($attachmentHtml == ''){
					$attachmentHtml.='<a target="bank" href="'.base_url().$attachment_url[$ak].'">'.$attachment_url[$ak].'</a>';
				}else{
					$attachmentHtml.=' , <a target="bank" href="'.base_url().$attachment_url[$ak].'">'.$attachment_url[$ak].'</a>';
				}
			
			}
			$html .= "<tr>
						<td><a href='#' data-id='{$s_val['id_trail']}' class='view_sent_body'><i class='fa fa-eye'></i></a></td>
						<td><a href='#' data-id='{$s_val['id_trail']}' class='open_forward_email'><i class='fa fa-mail-forward'></i></a></td>
						<td>{$s_val['sender_name']}</td>
						<td>{$s_val['sender_email']}</td>
						<td>{$s_val['sent_to']}</td>
						<td>{$s_val['subject']}</td>
						<td>{$attachmentHtml}</td>
						<td>{$forwarded}</td>
						<td>{$s_val['created_at']}</td>
					</tr>";
        
        }
            
        $html .='</tbody>
        </table>';
        echo $html;
	}
	public function get_email_trail_body()
	{
		$id = $this->input->post("id");
		$result = $this->fapplication_model->get_email_trail_body($id);
		echo json_encode($result);
	}
	public function add_email_template () // PAGE ACTION
	{
		$data = $this->data;
		$input_arr = $this->input->post();
		
		if($input_arr['visibility'] == 0)
		{
			$input_arr['fk_user'] = $data['user_id'];
		}
		else
		{
			$input_arr['fk_user'] = "0";
		}
		$this->fapplication_model->insert_email_template($input_arr);
	}
	public function fetch_abn()
	{
		$postData = array(
		    'login' => 'acogneau',
		    'pwd' => 'secretpassword',
		    'redirect_to' => 'http://example.com',
		    'testcookie' => '1'
		);
		curl_setopt_array($ch, array(
		    CURLOPT_URL => 'http://example.com/wp-login.php',
		    CURLOPT_RETURNTRANSFER => true,
		    CURLOPT_POST => true,
		    CURLOPT_POSTFIELDS => $postData,
		    CURLOPT_FOLLOWLOCATION => true
		));
		$output = curl_exec($ch);
	}
	public function process_abn()
	{
		$html = "";
		$post_data = $this->input->post();
		$abn      = "";
		$abr_name = "";
		$search_by = $post_data['search_by'];
		$guid = "54795896-ddb9-410b-8dec-fa713c5c4e45";
		if($search_by == "abn")
		{
			$abn = trim($post_data['abn']);
			$abn = str_replace(" ", "", $abn);
			$url = "http://abr.business.gov.au/ABRXMLSearch/abrxmlsearch.asmx/SearchByABNv201408?searchString={$abn}&includeHistoricalDetails=N&authenticationGuid={$guid}";
			$xml = file_get_contents($url);
			$json = json_encode(simplexml_load_string($xml));
			$json_array = json_decode($json, TRUE);
			if(!isset($json_array['response']['exception']))
			{
				// echo "<pre>";
				// print_r($json_array['response']); die();
				$active_from = date('d/m/Y', strtotime($json_array['response']['businessEntity201408']['entityStatus']['effectiveFrom']));
				$gst = date('d/m/Y', strtotime($json_array['response']['businessEntity201408']['goodsAndServicesTax']['effectiveFrom']));
				$trading_name = isset($json_array['response']['businessEntity201408']['mainTradingName']['organisationName']) ? $json_array['response']['businessEntity201408']['mainTradingName']['organisationName'] : ""; 
				// echo $json_array['response']['businessEntity201408']['mainTradingName']['organisationName']; die();
				$entity_type = isset($json_array['response']['businessEntity201408']['entityType']['entityDescription']) ? $json_array['response']['businessEntity201408']['entityType']['entityDescription'] : ""; 
				$state = isset($json_array['response']['businessEntity201408']['mainBusinessPhysicalAddress']['stateCode']) ? $json_array['response']['businessEntity201408']['mainBusinessPhysicalAddress']['stateCode'] : "";
				$postcode = isset($json_array['response']['businessEntity201408']['mainBusinessPhysicalAddress']['postcode']) ? $json_array['response']['businessEntity201408']['mainBusinessPhysicalAddress']['postcode'] : "";
				$entity_name = isset($json_array['response']['businessEntity201408']['mainName']['organisationName']) ? $json_array['response']['businessEntity201408']['mainName']['organisationName'] : "";
				$html = '
						<div class="table-responsive" style="white-space: nowrap;">
							<input type="hidden" name="hidden_trading_name" id="hidden_trading_name" value="'.$trading_name.'">
							<table class="table table-bordered table-striped table-condensed mb-none">
								<thead>						
									<tr>
										<th></th>
										<th>ABN</th>
										<th>Entity Name</th>
										<th>ABN Status</th>
										<th>Entity Type</th>
										<th>Active Since</th>
										<th>GST</th>
										<th>State</th>
										<th>Postcode</th>
									</tr>
								</thead>
								<tbody>';
									$html .= '
									<tr>
										<td align="center"><span class="choose_final_abn" style="cursor: pointer; cursor: hand; color: #58c603;"><i class="fa fa-plus" data-toggle="tooltip" data-placement="top" data-original-title="Select Dealer"></i></span></td>
										<td id="res_abn">'.$json_array['response']['businessEntity201408']['ABN']['identifierValue'].'</td>
										<td id="res_abn_name">'.$entity_name.'</td>
										<td>'.$json_array['response']['businessEntity201408']['entityStatus']['entityStatusCode'].'</td>
										<td>'.$entity_type.'</td>
										<td id="res_abn_date">'.$active_from.'</td>
										<td id="res_gst_date">'.$gst.'</td>
										<td id="abn_state">'.$state.'</td>
										<td id="abn_postcode">'.$postcode.'</td>
									</tr>';
									$html .= '
								</tbody>
							</table>
						</div>';
			}
			else
			{
				$html .= "<h4 style='margin: 10px;'>".$json_array['response']['exception']['exceptionDescription']."</h4>";
			}
		}
		elseif($search_by == "name")
		{
			$abr_name = trim($post_data['abr_name']);
			$abr_name = str_replace(' ', '+', $abr_name);
			$json_url = "http://abr.business.gov.au/json/MatchingNames.aspx?name={$abr_name}&maxResults=10&callback=x&guid={$guid}";
			$json = file_get_contents($json_url);
			$json = rtrim($json, ')');
			$json = ltrim($json, 'x(');
			$json_array = json_decode($json, TRUE);
			if($json_array['Message'] == "")
			{
				$html = '
						<div class="table-responsive" style="white-space: nowrap;">
							<table class="table table-bordered table-striped table-condensed mb-none">
								<thead>						
									<tr>
										<th></th>
										<th>ABN</th>
										<th>ABR Name</th>
									</tr>
								</thead>
								<tbody>';
									foreach ($json_array['Names'] as $n_key => $n_val) 
									{
										$html .= '
										<tr>
											<td align="center"><span data-abn="'.$n_val['Abn'].'" class="choose_temp_abn" style="cursor: pointer; cursor: hand; color: #58c603;"><i class="fa fa-plus" data-toggle="tooltip" data-placement="top" data-original-title="Select Dealer"></i></span></td>
											<td>'.$n_val['Abn'].'</td>
											<td>'.$n_val['Name'].'</td>
										</tr>';
									}
									$html .= '
								</tbody>
							</table>
						</div>';
			}
			else
			{
				$html .= "<h4 style='margin: 10px;'>".$json_array['Message']."</h4>";
			}
		}
		else
		{
			$html .= "<h4 style='margin: 10px;'>A sudden uncaught error appeared!</h4>";
		}
		echo $html;
	}
	public function search_lead()
	{
		$post_data = $this->input->post();
		$result = $this->fapplication_model->search_lead($post_data['search_lead_email'], $post_data['search_lead_name'], $post_data['search_lead_state'], $post_data['search_lead_make']);
		if(count($result) > 0)
		{
			$html = '
			<div class="table-responsive" style="white-space: nowrap;">
				<table class="table table-bordered table-striped table-condensed mb-none">
					<thead>						
						<tr>
							<th></th>
							<th>Email</th>
							<th>Name</th>
							<th>Phone</th>
							<th>Mobile</th>
							<th>Make</th>
							<th>State</th>
						</tr>
					</thead>
					<tbody>';
						foreach($result as $r_key => $r_val)
						{
							$html .= '
							<tr>
								<td align="center"><span class="select_lead" style="cursor: pointer; cursor: hand; color: #58c603;" data-lead_id="'.$r_val['id_lead'].'"><i class="fa fa-plus" data-toggle="tooltip" data-placement="top" data-original-title="Select Lead"></i></span></td>
								<td>'. $r_val['email'] .'</td>
								<td>'. $r_val['name'] .'</td>
								<td>'. $r_val['phone'] .'</td>
								<td>'. $r_val['mobile'] .'</td>
								<td>'. $r_val['make'] .'</td>
								<td>'. $r_val['state'] .'</td>
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
						<th>Email</th>
						<th>Name</th>
						<th>Phone</th>
						<th>Mobile</th>
						<th>Make</th>
						<th>State</th>
					</thead>					
					<tbody>
						<tr><td colspan="7"><center><i>No results found!</i></center></td></tr>
					</tbody>
				</table>
			</div>';
		}
		echo $html;
	}
	public function get_specific_lead()
	{
		$lead_id = $this->input->post("lead_id");
		$result = $this->fapplication_model->get_searched_lead($lead_id);
		$html = '
			<div class="table-responsive">
				<input type="hidden" id="hidden_assign_lead_id" value="'.$result["id_lead"].'">
				<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
					<tbody>
						<tr>
							<td>Email</td>
							<td>'.$result['email'].'</td>
						</tr>
						<tr>
							<td>Name</td>
							<td>'.$result['name'].'</td>
						</tr>
						<tr>
							<td>Phone</td>
							<td>'.$result['phone'].'</td>
						</tr>
						<tr>
							<td>Mobile</td>
							<td>'.$result['mobile'].'</td>
						</tr>
						<tr>
							<td>Address</td>
							<td>'.$result['address'].'</td>
						</tr>
						<tr>
							<td>State</td>
							<td>'.$result['state'].'</td>
						</tr>
						<tr>
							<td>Postcode</td>
							<td>'.$result['postcode'].'</td>
						</tr>
						<tr>
							<td>Make</td>
							<td>'.$result['make'].'</td>
						</tr>
						<tr>
							<td>Model</td>
							<td>'.$result['model'].'</td>
						</tr>
						<tr>
							<td>QM Staff</td>
							<td>'.$result['qm_user'].'</td>
						</tr>
						<tr>
							<td>Temp Staff</td>
							<td>'.$result['temp_user'].'</td>
						</tr>
					</tbody>
				</table>
			</div>';
		echo $html;
	}
	public function assign_lead_to_fq()
	{
		$lead_id       = $this->input->post("lead_id");
		$id_fq_account = $this->input->post("id_fq_account");
		$this->fapplication_model->assign_lead_to_fq($lead_id, $id_fq_account);
	}
	public function update_status_color()
	{
		$return_array = [];
		$post_data = $this->input->post();
		$status = 0;
		$color = "";
		switch ($post_data['status']) 
		{
			case '0':
				$color = "#ffffff";
				$status = 0;
				break;
			case '1':
				$color = "#c0d6f9";
				$status = 1;
				break;
			case '2':
				$color = "#55b2ed";
				$status = 2;
				break;
			case '3':
				$color = "#91f2c1";
				$status = 3;
				break;
			case '4':
				$color = "#1cbc34";
				$status = 4;
				break;
			case '5':
				$color = "#d8d51c";
				$status = 5;
				break;
			case '100':
				$color = "#ffffff";
				$status = 100;
				break;
			default:
				$color = "#ffffff";
				$status = 0;
				break;
		}
		$this->fapplication_model->update_status_color($post_data['fapplication_id'], $color, $status);
		$result = $this->fapplication_model->get_basic_fapplication_data($post_data['fapplication_id']);
		$car = $car = $result['lead_make']." ".$result['lead_model'];
		$return_array = [
			'title' => addslashes($result['lead_name']).' ('.$car.')' . ' - ' . $result['lead_phone'],
			'color' => $color
		];
		echo json_encode($return_array);
	}
	public function update_status_color_new($status, $fq_id)
	{
		$color = "";
		switch ($status) 
		{
			case '0':
				$color = "#ffffff";
				break;
			case '1':
				$color = "#c0d6f9";
				break;
			case '2':
				$color = "#55b2ed";
				break;
			case '3':
				$color = "#91f2c1";
				break;
			case '4':
				$color = "#1cbc34";
				break;
			case '5':
				$color = "#d8d51c";
				break;
			case '100':
				$color = "#ffffff";
				break;
			default:
				$color = "#ffffff";
				break;
		}
		$this->fapplication_model->update_status_color($fq_id, $color, $status);
	}
	public function unallocate_lead()
	{
		$data = $this->data;
		$lead_id = $this->input->post('lead_id');
		$response = $this->fapplication_model->unallocate_lead($lead_id, $data['user_id']);
		echo $response;
	}
	public function set_save_state()
	{
		$id = $this->input->post('id');
		$result = $this->fapplication_model->get_save_state($id);
		echo json_encode($result);
	}
	public function save_state()
	{
		$post_data = $this->input->post();
		$this->fapplication_model->update_save_state($post_data['id'], $post_data);
	}
	public function allocate_lead_note()
	{
		$post_data = $this->input->post();
		$data = $this->data;
		$this->fapplication_model->allocate_lead_note($post_data['lead_id'], $data['user_id']);
	}
	public function modal_test()
	{
		$this->load->view('admin/template/head');
		$this->load->view('admin/modals/fa_application_4');
		$this->load->view('admin/template/scripts');
		$this->load->view('admin/js/fapplication_scripts');
	}
	
	public function fq_new_record () // PAGE VIEW //
	{
		$data = $this->data;
		$data['title'] = 'Leads - Create New';
		$this->load->view('admin/fq_leads_form', $data);
	}
	
	public function create_new_calendar_item()
	{
		$post_data = $this->input->post();
		$post_data['user'] = $this->session->userdata('user_id');
		//echo json_encode($post_data); die();
		if($lead_id = $this->fapplication_model->create_new_calendar_item($post_data))
		{
			$input_arr_fq_new = array(
						'fq_lead_id'		=> $lead_id ,
						'name'				=> $post_data['lead_first_name'],
						'surname'			=> $post_data['lead_last_name'],
						'number'			=> $post_data['lead_phone'],
						'email'				=> $post_data['lead_email'],
						'address'			=> $post_data['lead_state'],
						
			);
			//echo $lead_id;
			
			//print_r($input_arr_fq_new );
			$this->fapplication_model->insert_update_fq_dealer_data($input_arr_fq_new,$lead_id) ;
			echo TRUE;
		}else
		{	echo FALSE; }
	}
	
	public function add_fq_record () // PAGE ACTION //
	{
		$data = $this->data;
		$input_arr = $this->input->post();
		if (!$this->input->post())
		{
			header ("Location: ".site_url('fapplication/fq_new_record'));
			exit ();
		}
		
		$query = "
		SELECT m.name as `make`, f.name as `family`
		FROM makes m
		JOIN families f ON m.id_make = f.fk_make
		WHERE m.id_make = '".$input_arr['make']."' AND f.id_family = '".$input_arr['family']."'
		LIMIT 1";
		$result = $this->db->query($query);
		if (count($result->result())<>0)
		{
			foreach ($result->result() as $row)
			{
				$input_arr['make'] = $row->make;
				$input_arr['family'] = $row->family;
			}
		}
		 
		//echo "<pre>";print_r($input_arr); die();
		$this->lead_model->add_fq_record($input_arr);
		$lead_id = $this->db->insert_id();
		$input_arr_fq_new = array(
						'fq_lead_id'		=> $lead_id ,
						'name'				=> $input_arr['name'],
						'number'			=> $input_arr['phone'],
						'email'				=> $input_arr['email'],
						'address'			=> $input_arr['state'],
						'postcode'			=> $input_arr['postcode'],
						'make'				=> $input_arr['make'],
						'modal'				=> $input_arr['family'],
		);
		
		
		$this->fapplication_model->insert_update_fq_dealer_data($input_arr_fq_new,$lead_id) ;
		
		$audit_trail_arr = array(
			'id' => $lead_id,
			'table_name' => 'fq_accounts_new',
			'action' => 1,
			'description' => ''
		);
		$insert_audit_trail_result = $this->audit_model->insert_audit_trail($data['user_id'], $audit_trail_arr);
		
		header ("Location: ".site_url('fapplication/list_view'));
		exit ();
	}
    
	public function excelDownload()
	{
		
		/*$array = array(
			array('Last Name', 'First Name', 'Gender'),
			array('Furtado', 'Nelly', 'female'),
			array('Twain', 'Shania', 'female'),
			array('Farmer', 'Mylene', 'female')
		);
		$this->load->helper('csv');
		echo array_to_csv($array);*/
		
		$filename = "car_data_".date("Y-m-d-H:s:i")."-".rand(1111,9999).".csv";
		$fp = fopen('php://output', 'w');
		
		$header = array();
		$header[] ="No";
		$header[] = "Make";
		$header[] = "Model";
		$header[] = "Name";
		$header[] = "Image"; 
		$header[] = "Price"; 
		$header[] = "Year"; 
		$header[] = "Description"; 
		
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);
		fputcsv($fp, $header);
	
		/*$query = "SELECT * FROM event";
		$result = mysql_query($query);
		while($row = mysql_fetch_row($result)) {
			print_r($row);
			fputcsv($fp, $row);
		}*/
		$query = 'SELECT rb.*,m.name as make_name, f.name as model_name FROM rb_data rb JOIN makes m ON m.id_make = rb.make_id JOIN families f ON f.id_family = rb.model_id  WHERE 1=1 ';//LIMIT 100
		$result = $this->db->query($query);
		
		$i = 1;
		if (count($result->result())<>0)
		{
			foreach ($result->result() as $row)
			{
				$data = array();
				$data[] = $i++;
				$data[] = $row->make_name;
				$data[] = $row->model_name;
				$data[] = $row->name;
				$data[] = $row->img;
				$data[] = $row->price;
				
				$data[] = date("M Y",strtotime("22-".$row->month."-".$row->year));
				$des = unserialize( $row->des);
				$data[] = implode(", ",$des);
      			fputcsv($fp, $data);
			}
		}
		//print_r($data);
		exit;		
	}
    
	public function getRBdata()
	{
		//$this->load->helper('getrbdata');
		$input_arr = $this->input->post();
		//echo '<pre>';print_r($input_arr);exit;
		/*$query = "SELECT m.name as `make`, f.name as `family` FROM makes m	JOIN families f ON m.id_make = f.fk_make
		WHERE m.id_make = '".$input_arr['make']."' AND f.id_family = '".$input_arr['model']."' LIMIT 1";
		$result = $this->db->query($query);*/
		
		$make = $input_arr['make'];
		$model = $input_arr['model'];
		
		//$year = $input_arr['year'];
		
		$cars_array = array();
		if($make !="" && $model!="")
		{
			$query = "SELECT * FROM rb_data WHERE make_id = '".$make."' AND model_id = '". $model."' ";
			/*if($year!="" && $year!=0 && $year!="0")
			{
				$year_ar = explode("-",$year);
				
				$query .="  AND year = '". $year_ar[1]."' ";
			} */
			$query .=" ORDER BY  name DESC ";
			$result = $this->db->query($query);
			
			foreach ($result->result() as $row)
			{
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
		if(!empty($cars_array))
		{	$response .= '<option value="" >Select Specific Car </option>' ;
			foreach($cars_array as $value)
			{
				$response .= '<option value="'.$value['car_id'].'" >'.$value['name']." - ".$value['des']." - ".$value['price'].'</option>' ;
			}
		}else
		{	
			$response .= '<option value="" >No Data Found</option>' ;
		}
		echo $response;
	}
    
	public function getRBdata_old()
	{
		$this->load->helper('getrbdata');
		$input_arr = $this->input->post();
		//print_r($input_arr);
		$query = "SELECT m.name as `make`, f.name as `family` FROM makes m	JOIN families f ON m.id_make = f.fk_make
		WHERE m.id_make = '".$input_arr['make']."' AND f.id_family = '".$input_arr['model']."' LIMIT 1";
		$result = $this->db->query($query);
		
		$make = '';
		$model = '';
		
		$cars_array = array();
		
		if (count($result->result())<>0)
		{
			foreach ($result->result() as $row)
			{
				$make = $row->make;
				$model = $row->family;
			}
		}
		if($make !="" && $model!="")
		{
			$make = $row->make;
			$model = $row->family;
			
			$make_str = urlencode("Make=[".$make."]&Model=[".$model."]");//(Make=[Audi]&Model=[A8])
			
			$j = 0;
			for($i=0;$i<1;$i++){
				
				$url ='https://www.redbook.com.au/cars/results?s='.$j.'&evnt=pagination&q='.$make_str;
						
				$html = file_get_html($url);
				
				foreach($html->find('div.content') as $e) {
					foreach($e->find('a.item') as $e2){
						$temp = array();
						foreach($e2->find('div.desc h3') as $e5){
							$temp['name'] = nl2br($e5->plaintext); 
						}
						foreach($e2->find('div.info span.price') as $e4){
							$temp['price'] = nl2br($e4->plaintext); 
						}
						$cars_array[]  = $temp;
					}
				}
				$j = $j + 15;
			}
		}
		
		$response = '';
		if(!empty($cars_array))
		{
			foreach($cars_array as $value)
			{
				$response .= '<option value="'.$value['name'].'" >'.$value['name']." - ".$value['price'].'</option>' ;
			}
		}else
		{	
			$response .= '<option value="" >No Data Found</option>' ;
		}
		echo $response;
	}
    
    public function duplicate_lead(){
        $fapplication_ids = $this->input->post('ids');
		//print_r($fapplication_ids);exit;
        $this->db->where_in('id_fq_account', $fapplication_ids);
        $query = $this->db->get('fq_accounts_new');
        //echo '<pre>';print_r($query->result_array());exit;
        $ins_data = array();
        //echo '<pre>';
        $res = $query->result_array();
        
        foreach ($query->result_array() as $row){
            //print_r($row);exit;
            $id_fq_account = $row['id_fq_account'];
            unset($row['id_fq_account']);
            unset($row['note']);
            /*Start Tender*/
            $row['status'] = 1;
            /*Start Tender*/
            $this->db->insert('fq_accounts_new', $row);
            
            $insert_id = $this->db->insert_id();
            //$ins_data[] = $row;
            //echo $insert_id;exit;
            $this->fapplication_model->duplicate_lead_dealer_data($id_fq_account, $insert_id);
           /*foreach($row as $key=>$val){
              if($key != 'id_fq_account' || $key != 'note'){
                $this->db->set($key, $val);               
              }
           }*/
        }
        //print_r($ins_data);
        //$this->db->insert_batch('fq_accounts_new', $ins_data);
        if($this->db->affected_rows() > 0)
            echo 1;
        else
            echo 0;
    }
    
    public function duplicateMySQLRecord(){
        $this->db->where('id_fq_account', 462);
        $query = $this->db->get('fq_accounts_new');
        //echo '<pre>';print_r($query->result_array());exit;
        foreach ($query->result() as $row){
           foreach($row as $key=>$val){
              if($key != $primary_key_field || $key != 'note'){ 
                $this->db->set($key, $val);               
              }
           }
        }
        return $this->db->insert($table);
    }
    
    public function get_where(){
        $query = $this->db->get_where('quotes', array('id_quote' => 120));
        echo '<pre>';
        print_r($query->row_array());
        exit;
	}
	
	/*public function update_quotes(){
		$sql = "SELECT `qu`.`fk_quote_request`, `qr`.`rb_data` , `qr`.`make` , `qr`.`model` from (`quotes` qu) LEFT JOIN `quote_requests` qr ON `qr`.`id_quote_request` = `qu`.`fk_quote_request`  where `qr`.`make` != '' AND `qr`.`model` != '' AND `qr`.`rb_data` != '' GROUP BY `qu`.`fk_quote_request`";
		
		
		$query = $this->db->query($sql)->result();
	
		foreach($query as $key=>$value){
			
			$fk_quote_request = $value->fk_quote_request;
			
			$make = $value->make;
			$modal = $value->model;
			$rb_data = $value->rb_data;
			$this->db->query("Update quotes set make = '".$make."' , modal = '".$modal."' , rb_data = '".$rb_data."' where fk_quote_request = '".$fk_quote_request."'");
			//echo "Update quotes set make = '".$make."' , modal = '".$modal."' where fk_quote_request = '".$fk_quote_request."'";
			//echo "<BR><BR>";
		}
	}*/

	public function client_purchase_order($type,$id){
		
	
		$data['type'] = $type;
		$this->db->select('*');
		$this->db->from('computation');
		$this->db->where('lead_id', $id );
		$computataion_data = $this->db->get()->result_array();

		$data['computation_data'] = $computataion_data[0];
	
		$data['lead'] = $this->lead_model->get_lead($id);
		

		$data['row'] = $this->fapplication_model->get_fq_account($id);

		$data['client'] = $this->fapplication_model->get_fq_dealer_data($id);
		
		$data['tradeins'] = $this->fapplication_model->get_data_row_by_id('tradein_new',array('id_leads' => $id,'parent_id' => null));
		
		$query_str = "SELECT * FROM `rb_data`  WHERE car_id = '".$data['lead']['rb_data']."' LIMIT 1";
		$query = $this->db->query($query_str);
		$rb_data_row = $query->row_array();
		
		if(!empty($rb_data_row)){
		$rb_data_row['des'] = unserialize($rb_data_row['des']);
			$rb_data_row['registration_type'] = $data['lead']['registration_type'];
			$rb_data_row['colour'] = $data['lead']['colour'];
		}else{
			$rb_data_row['name'] = '';
			$rb_data_row['price'] = '';
			$rb_data_row['month'] = '';
			$rb_data_row['year'] = '';
			$rb_data_row['des'] = array();
			$rb_data_row['registration_type']= '';
			$rb_data_row['colour']= '';
		}
		$data['rb_data_row'] = $rb_data_row;
		
		ini_set('memory_limit','512M');
		$html = $this->load->view('admin/client_purchase_order_pdf', $data, true);
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$stylesheet = file_get_contents('assets/pdf/css/bootstrap.min.css');
		$pdf->WriteHTML($stylesheet,1);
	
		$pdf->WriteHTML($html);
		$pdfFilePath = "client_purchase_order.pdf";

		if($type == 'client'){
			$uid = $this->data['user_id'];
			$filenm = 'PurchaseOrder_'.$uid.'.pdf';
			$select_query = "select * from requirement_uploads where file_name= '".$filenm."' and fk_account = '".$id."'";
			$query = $this->db->query($select_query);

			if($query->num_rows() ==  0){
				$pdfFilePath = "uploads/cq_requirements/".$filenm;
				$pdf->Output($pdfFilePath, 'F');

				$file_data = array(
					'file_name'      => $filenm,
					'fk_account'     => $id,
					'fk_requirement' => '11',
					'fk_user'        => $uid,
					'created_at'     => date("Y-m-d g:i:s"),
					'orig_filename'  => $filenm,
					'is_temp'        => 0
					);
	
					$this->db->insert('requirement_uploads', $file_data);
			}

			
		}
		$pdf->Output($pdfFilePath, 'I');


	}

	public function send_client_purchaseorder(){
	
		
		$email_content = $_POST['client_email_template_content'];
		$email_attachment_select = $_POST['email_attachment_select'];

		$lead_id = $_POST['id_lead'];
		$lead = $this->lead_model->get_lead($lead_id);
		$from_email = 'paul@finquote.net.au';
		$from_name = 'Finquote';
		$client = $this->fapplication_model->get_fq_dealer_data($lead_id);
		
		$to  = $client['email'];
		$content = $email_content;
		$subject = $_POST['send_mail_template_subject'];
		
		
		$data['type'] = 'client';
		$this->db->select('*');
		$this->db->from('computation');
		$this->db->where('lead_id', $lead_id );
		$computataion_data = $this->db->get()->result_array();

		$data['computation_data'] = $computataion_data[0];
		$computation_id = $data['computation_data']['id'];
		if($data['computation_data']['order_date'] == ''){
			$computation = array(
				'order_date'=>date("d-m-Y"),
			);
			$this->db->where('id',$computation_id);
			$this->db->update('computation', $computation);
		}
		$data['lead'] = $this->lead_model->get_lead($lead_id);
		
		$data['row'] = $this->fapplication_model->get_fq_account($lead_id);

		$data['client'] = $this->fapplication_model->get_fq_dealer_data($lead_id);
		
		$data['tradeins'] = $this->fapplication_model->get_data_row_by_id('tradein_new',array('id_leads' => $lead_id,'parent_id' => null));
		
		$query_str = "SELECT * FROM `rb_data`  WHERE car_id = '".$data['lead']['rb_data']."' LIMIT 1";
		$query = $this->db->query($query_str);
		$rb_data_row = $query->row_array();
		
		if(!empty($rb_data_row)){
		$rb_data_row['des'] = unserialize($rb_data_row['des']);
			$rb_data_row['registration_type'] = $data['lead']['registration_type'];
			$rb_data_row['colour'] = $data['lead']['colour'];
		}else{
			$rb_data_row['name'] = '';
			$rb_data_row['price'] = '';
			$rb_data_row['month'] = '';
			$rb_data_row['year'] = '';
			$rb_data_row['des'] = array();
			$rb_data_row['registration_type']= '';
			$rb_data_row['colour']= '';
		}
		$data['rb_data_row'] = $rb_data_row;
		
		ini_set('memory_limit','512M');
		/*$html = $this->load->view('admin/client_purchase_order_pdf', $data, true);
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$stylesheet = file_get_contents('assets/pdf/css/bootstrap.min.css');
		$pdf->WriteHTML($stylesheet,1);
	
		$pdf->WriteHTML($html);
		$pdfFilePath = "uploads/purchase_order_temp/".$subject.".pdf";
		$pdf->Output($pdfFilePath, 'F');*/

		/*$vehicle_protection_file = 	$this->db->query("select * from requirement_uploads where fk_account = 0 and orig_filename = 'Permaguard New Vehicle Protection'")->result();	
	
		$vehicle_file = 'uploads/cq_requirements/'.$vehicle_protection_file[0]->file_name;*/

		$pdfFilePath = '';
		$vehicle_file = '';
	
		$file = array($pdfFilePath,$vehicle_file);
		
		$return = $this->client_purchase_order_email($from_email, $from_name, $to, $subject, $content, $file,$email_attachment_select);

		$attachment_url = array();
		foreach($email_attachment_select as $attachment){
			$attachment_url[].='uploads/cq_requirements/'. $attachment;
		}
		$attachment_urls = implode(",",$attachment_url);
		if($return == 1){
			$trail_array = [
				'fk_user'    => $this->data['user_id'],
				'fk_account' => $lead_id,
				'sent_to'    => $to,
				'subject'    => $subject,
				'message'    => $content,
				'attachment'    => implode(",",$email_attachment_select),
				'attachment_url'    => $attachment_urls,
				'created_at' => date('Y-m-d H:i:s')
			];
			$this->fapplication_model->email_audit_trail_model($trail_array);

			echo "success"; 
		}else{
				echo "Error";
		}
		
		
	}

	public function send_dealer_purchaseorder(){
		
		
		$email_content = $_POST['dealer_email_template_content'];
	
		$lead_id = $_POST['id_lead'];
		$lead = $this->lead_model->get_lead($lead_id);
		$from_email = 'paul@finquote.net.au';
		$from_name = 'Finquote';
		
		$to  = $lead['dealer_email'];
		$content = $email_content;
		$subject = $_POST['send_mail_template_subject'];
		
		$data['type'] = 'dealer';
		$this->db->select('*');
		$this->db->from('computation');
		$this->db->where('lead_id', $lead_id );
		$computataion_data = $this->db->get()->result_array();

		$data['computation_data'] = $computataion_data[0];
	
		$data['lead'] = $this->lead_model->get_lead($lead_id);
		
		$data['row'] = $this->fapplication_model->get_fq_account($lead_id);

		$data['client'] = $this->fapplication_model->get_fq_dealer_data($lead_id);
		
		$data['tradeins'] = $this->fapplication_model->get_data_row_by_id('tradein_new',array('id_leads' => $lead_id,'parent_id' => null));
		
		$query_str = "SELECT * FROM `rb_data`  WHERE car_id = '".$data['lead']['rb_data']."' LIMIT 1";
		$query = $this->db->query($query_str);
		$rb_data_row = $query->row_array();
		
		if(!empty($rb_data_row)){
		$rb_data_row['des'] = unserialize($rb_data_row['des']);
			$rb_data_row['registration_type'] = $data['lead']['registration_type'];
			$rb_data_row['colour'] = $data['lead']['colour'];
		}else{
			$rb_data_row['name'] = '';
			$rb_data_row['price'] = '';
			$rb_data_row['month'] = '';
			$rb_data_row['year'] = '';
			$rb_data_row['des'] = array();
			$rb_data_row['registration_type']= '';
			$rb_data_row['colour']= '';
		}
		$data['rb_data_row'] = $rb_data_row;
		
		ini_set('memory_limit','512M');
		$html = $this->load->view('admin/client_purchase_order_pdf', $data, true);
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$stylesheet = file_get_contents('assets/pdf/css/bootstrap.min.css');
		$pdf->WriteHTML($stylesheet,1);
	
		$pdf->WriteHTML($html);
		$pdfFilePath = "uploads/cq_requirements/".str_replace(' ', '_', $subject).".pdf";
		$pdf->Output($pdfFilePath, 'F');

		$attachment = str_replace(' ', '_', $subject).".pdf";
		$attachment_urls = $pdfFilePath;
		$winner_quote = '';
		$tender_quotes = $this->quote_model->get_tender_quotes($data['lead']['id_quote_request']);
		foreach($tender_quotes as $tender_quote){
			if($tender_quote['id_quote'] == $tender_quote['winner']){
				$winner_quote = 'uploads/quote_files/'. $tender_quote['quote_file'];
				$attachment.=','.$tender_quote['quote_file'];
				$attachment_urls.=','.$winner_quote;
			}
		}
		$file = array($pdfFilePath,$winner_quote);
		$email_attachment_select = array();
		$return = $this->client_purchase_order_email($from_email, $from_name, $to, $subject, $content, $file,$email_attachment_select);

		if($return == 1){
			$trail_array = [
				'fk_user'    => $this->data['user_id'],
				'fk_account' => $lead_id,
				'sent_to'    => $to,
				'subject'    => $subject,
				'message'    => $content,
				'attachment'    => $attachment,
				'attachment_url' =>$attachment_urls,
				'created_at' => date('Y-m-d H:i:s')
			];
			$this->fapplication_model->email_audit_trail_model($trail_array);
			echo "success"; 
		}else{
			echo "Error";
		}
		
		
	}

	public function get_attachments(){
		$fq_id = $_POST['fq_id'];
		
		$att_option = "<option value=''></option>";

		$query = "select * from requirement_uploads where (fk_account = {$fq_id}) OR  (fk_account = 0);";
		$attachments_res = $this->db->query($query)->result_array();
		foreach ($attachments_res as $key => $val) 
		{
		$att_option .= "<option data-id='{$val['id_req_up']}' value='{$val['file_name']}'>{$val['orig_filename']}</option>";
		}
		echo $att_option;
                     
	}
    

}

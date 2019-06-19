<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('admin_main.php');
class Account extends Admin_main 
{
	function __construct()
	{
	    ob_start();
		parent::__construct();
	}

	function index()
	{
		header("Location: ".site_url('account/dealers'));
		exit();
	}
	
	public function get_fatch_data()
	{
		
		/*ini_set("allow_url_fopen", 1);
		ini_set("allow_url_include", 1);
		echo ini_get("allow_url_fopen");
		
		exit;*/
		$data = $this->data;
		$input_arr = $this->input->post();
		$data['title'] = 'Get Data';
		$data['makes_row'] = $this->car_model->get_makes();
		$data['make'] = '';
		 $data['cars_list'] = array();
		if($_POST)
		{		
				$data['make'] = $input_arr['make'];
				//Alfa Romeo
				//q=Make=[Alfa Romeo]
				//echo http_build_query($data, 'flags_');
				
				$make = $input_arr['make'];
				$str = urlencode("Make=[".$make."]");
				$url ='https://www.redbook.com.au/cars/results?q='.$str;
				
				//$url = "https://www.redbook.com.au/cars/results?q=Make%3D%5BAlfa%20Romeo%5D";
				
				$html = file_get_contents($url); //get the html returned from the following url
				//$html = $this->get_data($url);
				//print_r($html);
				$cars_doc = new DOMDocument();
				
				libxml_use_internal_errors(TRUE); //disable libxml errors
				
				if(!empty($html)){ //if any html is actually returned
				
					$cars_doc->loadHTML($html);
					libxml_clear_errors(); //remove errors for yucky html
					
					$cars_xpath = new DOMXPath($cars_doc);
				
					//get all the h2's with an id
					$cars_row = $cars_xpath->query('//a[@class="item"]');
					//print_r($cars_row);
					
					/*if($cars_row->length > 0){
						foreach($cars_row as $row){
							echo $row->nodeValue . "<br/>";
						}
					}*/
					
					if($cars_row->length > 0){	
	
						//loop through all the carss
						foreach($cars_row as $pat){
							
							//get the name of the cars
							$img = $cars_xpath->query('div[@class="photos"]', $pat)->item(0)->nodeValue;
							$name = $cars_xpath->query('div[@class="desc"]/h3', $pat)->item(0)->nodeValue;
							$price = $cars_xpath->query('div[@class="info"]/span[@class="price "]', $pat)->item(0)->nodeValue;							
							$pkmn_types = array(); //reset $pkmn_types for each cars
							$types = $cars_xpath->query('div[@class="desc"]/ul/li', $pat);
					
							//loop through all the types and store them in the $pkmn_types array
							foreach($types as $type){
								$pkmn_types[] = $type->nodeValue; //the cars type
							}
					
							//store the data in the $cars_list array
							$cars_list[] = array('img' => $img,'name' => $name,'price'=>$price, 'desc' => $pkmn_types);
							
						}
					}
					
					//output what we have
					///echo "<pre>";
					//print_r($cars_list);
					//echo "</pre>";
					 $data['cars_list'] = $cars_list;
				}
				//exit;
		}
		
		$this->load->helper(array('form'));
		$this->load->view('admin/get_reedbook_data', $data);
	}
	public function new_record () // PAGE VIEW
	{
		$data = $this->data;
		$data['title'] = 'Accounts - Create New';
		$this->load->helper(array('form'));
		$this->load->view('admin/account_form', $data);
	}

	public function verify_account_creation ()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('user_type', 'User Type', 'required');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|valid_email|xss_clean|callback_check_username');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|max_length[25]|matches[confirm-password]|md5');
		$this->form_validation->set_rules('confirm-password', 'Password Confirmation', 'trim|required');
		$this->form_validation->set_rules('name', 'Name', 'trim');
		$this->form_validation->set_rules('state', 'State', 'trim');
		$this->form_validation->set_rules('postcode', 'Postcode', 'trim');
		$this->form_validation->set_rules('address', 'Address', 'trim');		
		$this->form_validation->set_rules('phone', 'Mobile', 'trim');
		$this->form_validation->set_rules('mobile', 'Phone', 'trim');
		$this->form_validation->set_rules('description', 'Description', 'trim');
		$this->form_validation->set_rules('dob', 'Date of Birth', 'trim');
		$this->form_validation->set_rules('bank_acct_name', 'Bank Account Name', 'trim');
		$this->form_validation->set_rules('bank_acct_bsb', 'Bank Account BSB', 'trim');
		$this->form_validation->set_rules('bank_acct_num', 'Bank Account Number', 'trim');
		$this->form_validation->set_rules('acct_holders_name', 'Account Holder\'s Name', 'trim');

		$admin_type = 0;

		if ($this->input->post('user_type')==1)
		{
			$this->form_validation->set_rules('dealership_name', 'Dealership Name', 'trim|required');
		}
		else if ($this->input->post('user_type')==2)
		{
			$admin_type = $this->input->post('admin_type');
		}

		if($this->form_validation->run() == FALSE)
		{
			$data = $this->data;
			$data['title'] = 'Accounts - Create New';
			$data['makes'] = $this->car_model->get_makes();

			$this->load->helper(array('form'));
			$this->load->view('admin/account_form', $data);
		}
		else
		{
			$user_type         = $this->input->post('user_type');
			$username          = strtolower($this->input->post('username'));
			$password          = $this->input->post('password');
			$name              = $this->input->post('name');
			$abn               = "";
			$dealer_license    = $this->input->post('dealer_license');
			$state             = $this->input->post('state');
			$postcode          = $this->input->post('postcode');
			$address           = $this->input->post('address');
			$phone             = $this->input->post('phone');
			$mobile            = $this->input->post('mobile');
			$description       = $this->input->post('description');
			$dob               = $this->input->post('dob');
			$bank_acct_name    = $this->input->post('bank_acct_name');
			$bank_acct_bsb     = $this->input->post('bank_acct_bsb');
			$bank_acct_num     = $this->input->post('bank_acct_num');
			$usertype          = $this->input->post('usertype');
			$acct_holders_name = $this->input->post('acct_holders_name');
			$dob 			   = date('Y-m-d', strtotime($dob));

			$this->user_model->register_user($user_type, $admin_type, $username, $password, $name, $abn, $state, $postcode, $address, $phone, $mobile, $description,$dob, $bank_acct_name, $bank_acct_bsb, $bank_acct_num, $acct_holders_name, $dealer_license);
			$user_id = $this->db->insert_id();

			if ($user_type=="1")
			{
				//echo "Dealer Registration";
				
				$dealership_name = $this->input->post('dealership_name'); 
				$dealership_brand = "";
				$make_index = 1;
				while ($make_index <= 100)
				{
					if ($this->input->post('make_'.$make_index))
					{
						$dealership_brand .= $this->input->post('make_'.$make_index).",";
					}
					$make_index ++;
				}
				$dealership_brands = substr($dealership_brand, 0, -1);

				$dealership_states = "";

				$post_data = $this->input->post();

				if (isset($post_data['dealership_state']))
				{
					$dealership_states = implode(",", $this->input->post('dealership_state'));
				}

				$this->user_model->register_dealer_attributes($user_id, $dealership_name, $dealership_brands, $dealership_states);
			}

			$ref_url = "";
			if ($user_type==1) { $ref_url = "dealers"; }
			else if ($user_type==2) { $ref_url = "staffs"; }
			else if ($user_type==3) { $ref_url = "wholesalers"; }
			//echo site_url('account/'.$ref_url);
			//exit;
			header("Location: " . site_url('account/'.$ref_url));
			//exit();
		}	//echo site_url('account/'.$ref_url);
			//exit;
	}

	public function check_username ()
	{
		$username = $this->input->post('username');
		$result = $this->user_model->check_username_availability($username);

		if ($result)
		{
			$this->form_validation->set_message('check_username', 'The email/username you entered is already in use');
			return false;
		}
		else
		{
			return true;
		}
	}	
	
	public function send_user_invite ($user_type)
	{
		$now = date("Y-m-d H:i:s");
		$data = $this->data;
		
		$input_arr = $this->input->post();
		
		$existing_username_result = $this->user_model->check_username_availability($input_arr['email']);		
		if ($existing_username_result)
		{
			echo "Username is already registered on the system!";
		}
		else
		{
			if ($user_type==1)
			{
				echo "Incorrect user type!";
			}
			else if ($user_type==3)
			{
				$from_email = $data['company']['company_email'];
				$from_name = $data['company']['company_name'];
				$to = $input_arr['email'];
				$subject = $data['company']['company_name']." - Wholesale Registration";
				$content = '
				<p style="line-height: 1.5">
					Thank you for inquiring with <b>'.$data['company']['company_name'].'</b> regarding a Wholesale Buyers account. 
				</p>
				<p style="line-height: 1.5">
					Please click <a href="'.site_url('register/wholesaler').'">here</a> and submit your details.
				</p>				
				<p style="line-height: 1.5">
					<a href="'.site_url('register/wholesaler').'">'.site_url('register/wholesaler').'</a>
				</p>
				<p style="line-height: 1.5">
					<br><br>
					Thank you,
					<br />
					<b>'.$data['company']['company_name'].'</b>
				</p>';
				$this->send_templated_email ($from_email, $from_name, $to, $subject, $content, $file = "");	
				$this->user_model->insert_user_invite($user_type, $input_arr['email']);
				
				echo "Invitation was sent!";
			}
			else
			{
				echo "Incorrect user type!";
			}
		}	
	}	

	public function staffs ($start = 0) // LIST VIEW
	{
		$data = $this->data;
		$data['title'] = 'Staffs';

		$limit = 20;
		$count_result = $this->user_model->get_staffs_count($_GET);
		$data['staffs'] = $this->user_model->get_staffs($_GET, $start, $limit);

		$this->load->library('pagination');
		$config['base_url'] = site_url('account/staffs/');
		$config['total_rows'] = $count_result['cnt'];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config); 
		$data['links'] = $this->pagination->create_links();
		$data['result_count'] = $count_result['cnt'];
		
		$this->load->view('admin/staffs', $data);
	}	
	
	public function dealers ($start = 0) // LIST VIEW
	{
		$data = $this->data;
		$data['title'] = 'Dealers';

		$limit = 20;
		$count_result = $this->user_model->get_dealers_count($_GET);
		$data['dealers'] = $this->user_model->get_dealers($_GET, $start, $limit);
		
		$this->load->library('pagination');
		$config['base_url'] = site_url('account/dealers/');
		$config['total_rows'] = $count_result['cnt'];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config); 
		$data['links'] = $this->pagination->create_links();
		$data['result_count'] = $count_result['cnt'];
		
		$this->load->view('admin/dealers', $data);
	}	
	public function dealersfloat ($start = 0) // LIST VIEW
	{
		$data = $this->data;
		$data['title'] = 'Dealers';

		$limit = 20;
		$count_result = $this->user_model->get_dealers_count($_GET);
		$data['dealers'] = $this->user_model->get_dealers($_GET, $start, $limit);
		
		$this->load->library('pagination');
		$config['base_url'] = site_url('account/dealersfloat/');
		$config['total_rows'] = $count_result['cnt'];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config); 
		$data['links'] = $this->pagination->create_links();
		$data['result_count'] = $count_result['cnt'];
		
		// $this->load->view('admin/dealers', $data);
		
		$floatdealer =''; 
		$floatdealer .='<style>#assign_cqo .modal-body #search_form .panel-body .form-group select.form-control {color:#ccc}</style><section class="panel">
						<header class="panel-heading">
							<div class="panel-actions">
								<a href="#" class="fa fa-caret-down"></a>
							</div>
							<h2 class="panel-title">
								<span class="label label-primary label-sm text-normal va-middle mr-sm">'.$data['result_count'].'</span>
								<span class="va-middle">Search Filters</span>
							</h2>
						</header>
						<form>
						</form>
						<form class="form-horizontal form-bordered" accept-charset="utf-8" id="search_form">
							<div class="panel-body">
								<br />';
								
								$status           = isset($_GET['status']) ? $_GET['status'] : '';
								$pma_status       = isset($_GET['pma_status']) ? $_GET['pma_status'] : '';
								$gold_status      = isset($_GET['gold_status']) ? $_GET['gold_status'] : '';
								$email            = isset($_GET['email']) ? $_GET['email'] : '';
								$name             = isset($_GET['name']) ? $_GET['name'] : '';
								$abn              = isset($_GET['abn']) ? $_GET['abn'] : '';
								$state            = isset($_GET['state']) ? $_GET['state'] : '';
								
								$catered_state            = isset($_GET['catered_state']) ? $_GET['catered_state'] : '';
								
								$ACT = ($state =="ACT")?"SELECTED":"";
								$NSW = ($state =="NSW")?"SELECTED":"";
								$NT = ($state =="NT")?"SELECTED":"";
								$QLD = ($state =="QLD")?"SELECTED":"";
								$SA = ($state =="SA")?"SELECTED":"";
								$TAS = ($state =="TAS")?"SELECTED":"";
								$VIC = ($state =="VIC")?"SELECTED":"";
								$WA = ($state =="WA")?"SELECTED":"";
								
								$CS_ACT = ($catered_state =="ACT")?"SELECTED":"";
								$CS_NSW = ($catered_state =="NSW")?"SELECTED":"";
								$CS_NT = ($catered_state =="NT")?"SELECTED":"";
								$CS_QLD = ($catered_state =="QLD")?"SELECTED":"";
								$CS_SA = ($catered_state =="SA")?"SELECTED":"";
								$CS_TAS = ($catered_state =="TAS")?"SELECTED":"";
								$CS_VIC = ($catered_state =="VIC")?"SELECTED":"";
								$CS_WA = ($catered_state =="WA")?"SELECTED":"";
								
								$postcode         = isset($_GET['postcode']) ? $_GET['postcode'] : '';
								$address          = isset($_GET['address']) ? $_GET['address'] : '';
								$phone            = isset($_GET['phone']) ? $_GET['phone'] : '';
								$mobile           = isset($_GET['mobile']) ? $_GET['mobile'] : '';
								$dealership_name  = isset($_GET['dealership_name']) ? $_GET['dealership_name'] : '';
								$dealership_brand = isset($_GET['dealership_brand']) ? $_GET['dealership_brand'] : '';

								$selected_status_0 = ""; if ($status == "0") { $selected_status_0 = " selected"; }
								$selected_status_1 = ""; if ($status == "1") { $selected_status_1 = " selected"; }								
								
								$selected_gold_status_0 = ""; if ($gold_status == "0") { $selected_gold_status_0 = " selected"; }
								$selected_gold_status_1 = ""; if ($gold_status == "1") { $selected_gold_status_1 = " selected"; }								

								$selected_pma_status_0 = ""; if ($pma_status == "0") { $selected_pma_status_0 = " selected"; }
								$selected_pma_status_1 = ""; if ($pma_status == "1") { $selected_pma_status_1 = " selected"; }																
								
								$floatdealer .='<div class="form-group">
									<div class="col-md-12">
										<input value="'.$dealership_name.'" class="form-control mb-md" name="dealership_name" type="text" placeholder="Dealership Name">
									</div>
									<div class="col-md-4">
										<input value="'.$abn.'" class="form-control mb-md" name="abn" type="text" placeholder="ABN">
									</div>									
									<div class="col-md-4">
										<input value="'.$dealership_brand.'" class="form-control mb-md" name="dealership_brand" type="text" placeholder="Dealership Brands">
									</div>
									<div class="col-md-4">
										<input value="'.$name.'" class="form-control mb-md" name="name" type="text" placeholder="Manager Name">
									</div>									
									<div class="col-md-4">
										<select class="form-control mb-md" name="status" title="User Status">
											<option name="status" value="">-User Status-</option>
											<option name="status" value="1" '.$selected_status_1.'>Activated</option>
											<option name="status" value="0" '.$selected_status_0.'>Deactivated</option>
										</select>
									</div>
									<div class="col-md-4">
										<select class="form-control mb-md" name="gold_status" title="Dealer Type">
											<option name="gold_status" value="">-Dealer Type-</option>
											<option name="gold_status" value="1" '.$selected_gold_status_1.'>Gold</option>
											<option name="gold_status" value="0" '.$selected_gold_status_0.'>Ordinary</option>
										</select>
									</div>	
									<div class="col-md-4">
										<select class="form-control mb-md" name="pma_status" title="PMA Status">
											<option name="pma_status" value="">-PMA Status-</option>
											<option name="pma_status" value="1" '.$selected_pma_status_1.'>Active</option>
											<option name="pma_status" value="0" '.$selected_pma_status_0.'>Inactive</option>
										</select>
									</div>
									
									
									<div class="col-md-4">
										<input value="'.$email.'" class="form-control mb-md" name="email" type="text" placeholder="Email Address">
									</div>
									<div class="col-md-4">
										<input value="'.$phone.'" class="form-control mb-md" name="phone" type="text" placeholder="Phone">
									</div>
									<div class="col-md-4">
										<input value="'.$mobile.'" class="form-control mb-md" name="mobile" type="text" placeholder="Mobile">
									</div>
									<div class="col-md-4">
										<select class="form-control mb-md" name="catered_state" placeholder="Catered State">
											<option value="">Catered States</option>
											<option '.$CS_ACT.'  value="ACT">ACT - Australian Capital Territory</option>
											<option '.$CS_NSW.'  value="NSW">NSW - New South Wales</option>
											<option '.$CS_NT.'  value="NT">NT - Northern Territory</option>
											<option '.$CS_QLD.'  value="QLD">QLD - Queensland</option>
											<option '.$CS_SA.'  value="SA">SA - South Australia</option>
											<option '.$CS_TAS.'  value="TAS">TAS - Tasmania</option>
											<option '.$CS_VIC.'  value="VIC">VIC - Victoria</option>
											<option '.$CS_WA.'  value="WA">WA - Western Australia</option>
										</select>
									</div>
									<div class="col-md-4">
										<input value="'.$postcode.'" class="form-control mb-md" name="postcode" type="text" placeholder="Postcode">
									</div>
									<div class="col-md-4">
										<input value="'.$address.'" class="form-control mb-md" name="address" type="text" placeholder="Address">
									</div>
									<div class="col-md-4">
										<select class="form-control mb-md" name="state" placeholder="State">
											<option value="">Address States</option>
											<option '.$ACT.'  value="ACT">ACT - Australian Capital Territory</option>
											<option '.$NSW.'  value="NSW">NSW - New South Wales</option>
											<option '.$NT.'  value="NT">NT - Northern Territory</option>
											<option '.$QLD.'  value="QLD">QLD - Queensland</option>
											<option '.$SA.'  value="SA">SA - South Australia</option>
											<option '.$TAS.'  value="TAS">TAS - Tasmania</option>
											<option '.$VIC.'  value="VIC">VIC - Victoria</option>
											<option '.$WA.'  value="WA">WA - Western Australia</option>
										</select>
									</div>
								</div>
							</div>
							<footer class="panel-footer text-right">
								<input type="button" class="btn btn-primary search_btnn" onclick="search_fil()" value="Apply Filters"/>
							</footer>
						</form>
					</section>
					<section class="panel">
						<div class="panel-body">			
							<div class="table-responsive">';
							
								if (count($data['dealers'])==0)
								{
									echo "<br /><center><i>No results found!</i></center><br /><br /><br /><br />";
								}
								else
								{
								
									$floatdealer .='<table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
										<thead>
											<tr>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th>Status</th>
												<th>Orders</th>
												<th>Invites</th>
												<th>Quotes</th>
												<th>Dealership</th>
												<th>Manager</th>												
												<th>Address</th>
											</tr>
										</thead>
										<tbody>';
											
											foreach($data['dealers'] as $dealer)
											{
												
												$floatdealer .='<tr id="dealer_row_'.$dealer->id_user.'">
													<td class="text-center">';
														
														$deactivate_button_hidden = "";
														$activate_button_hidden = "";
														if ($dealer->status == 0) { $deactivate_button_hidden = " hidden"; }
														else { $activate_button_hidden = " hidden";	}
																									
														$floatdealer .='<a href="#" id="activate_button_'.$dealer->id_user.'" onclick="activate_dealer('.$dealer->id_user.')" data-toggle="tooltip" data-placement="top" title="Activate Dealer" '.$activate_button_hidden.'>
															<i class="fa fa-check"></i>
														</a>
														<a href="#" id="deactivate_button_'.$dealer->id_user.'" onclick="deactivate_dealer('.$dealer->id_user.')" data-toggle="tooltip" data-placement="top" title="Deactivate Dealer"'.$deactivate_button_hidden.'>
															<i class="fa fa-times"></i>
														</a>
													</td>
													<td class="text-center">';
													
														$gold_btn_hidden = "";
														$ungold_btn_hidden = "";
														if ($dealer->gold_status == 0) { $ungold_btn_hidden = " hidden"; }
														else { $gold_btn_hidden = " hidden";	}
														
														$floatdealer .='<a href="#" id="activate_gold_'.$dealer->id_user.'" onclick="gold_control('.$dealer->id_user.', 1)" data-toggle="tooltip" data-placement="top" title="Mark as Gold" '.$gold_btn_hidden.'>
															<i class="fa fa-star" ></i>
														</a>
														<a href="#" id="deactivate_gold_'.$dealer->id_user.'" onclick="gold_control('.$dealer->id_user.', 0)" data-toggle="tooltip" data-placement="top" title="Unmark as Gold" '.$ungold_btn_hidden.'>
															<i class="fa fa-star" style="color: #FFD700;" ></i>
														</a>
													</td>
													<td class="text-center">';
														
														$show_deposit_btn_hidden = "";
														$hide_deposit_btn_hidden = "";
														if ($dealer->deposit_show_status == 0) { $hide_deposit_btn_hidden = " hidden"; }
														else { $show_deposit_btn_hidden = " hidden";	}
														
														$floatdealer .='<a href="#" id="show_deposit_'.$dealer->id_user.'" onclick="deposit_visibility_control('.$dealer->id_user.', 1)" data-toggle="tooltip" data-placement="top" title="Show Deposit" '.$show_deposit_btn_hidden.'>
															<i class="fa fa-dollar" ></i>
														</a>
														<a href="#" id="hide_deposit_'.$dealer->id_user.'" onclick="deposit_visibility_control('.$dealer->id_user.', 0)" data-toggle="tooltip" data-placement="top" title="Hide Deposit" '.$hide_deposit_btn_hidden.'>
															<i class="fa fa-dollar" style="color: #FFD700;" ></i>
														</a>
													</td>
													<td class="text-center">
													<a href="#" class="open-editdealer" data-dealer_id="'.$dealer->id_user.'">
															<i class="fa fa-pencil-square-o" data-toggle="tooltip" data-placement="top" title="Edit Dealer"></i>
														</a>
													</td>
													<td class="text-center">
														<a href="#" data-id="'.$dealer->id_user.'" class="delete_dealer" onclick="delete_dealer('.$dealer->id_user.')">
															<i class="fa fa-trash-o" data-toggle="tooltip" data-placement="top" title="Delete Dealer Permanently"></i>
														</a>
													</td>
													<td>
														<span id="dealer_status_'.$dealer->id_user.'">'.$dealer->status_text.'</span>
														<br />
														<b>PMA Protection:</b>
														<br />
														<span id="dealer_pma_'.$dealer->id_user.'">'.$dealer->pma_status_text.'</span> (<span id="dealer_gold_'.$dealer->id_user.'">'.$dealer->gold_status_text.'</span>)														
													</td>
													<td>'.$dealer->orders_count.'</td>													
													<td>'.$dealer->invites_count.'</td>
													<td>'.$dealer->quotes_count.'</td>
													<td>
														<b>
												<span id="dealer_dealership_name_'.$dealer->id_user.'">
												<a href="'.site_url('user/record/'.$dealer->id_user).'" target="_blank">'.$dealer->dealership_name.'</a>
												</span>
												</b>
											(ABN: <span id="dealer_abn_'.$dealer->id_user.'">'.$dealer->abn.'</span>)
												<br />
											<a href="mailto:'.$dealer->username.'" target="_top">'.$dealer->username.'</a><br />
												<i class="fa fa-car"></i> <span id="dealer_dealership_brand_'. $dealer->id_user.'">'.$dealer->dealership_brand.'</span>
													</td>
													<td>
														<i class="fa fa-user"></i> <span id="dealer_name_'.$dealer->id_user.'">'.$dealer->name.'</span><br />
														<i class="fa fa-mobile"></i> &nbsp;<span id="dealer_mobile_'. $dealer->id_user.'">'.$dealer->mobile.'</span><br />
														<i class="fa fa-phone"></i> <span id="dealer_phone_'.$dealer->id_user.'">'.$dealer->phone.'</span>
													</td>													
													<td>
														<i class="fa fa-map-marker"></i> <span id="dealer_address_'.$dealer->id_user.'">'.$dealer->address.'</span><br />
														<i class="fa fa-map-marker"></i> <span id="dealer_postcode_'.$dealer->id_user.'">'.$dealer->postcode.'</span><br />
														<i class="fa fa-map-marker"></i> <span id="dealer_state_'.$dealer->id_user.'">'.$dealer->state.'</span>
													</td>
												</tr>';											
												
											}
											
										$floatdealer .='</tbody>
									</table>
									<br /><div id="my-paging">'.$data['links']."</div>";													
								
								}
								
							$floatdealer .='</div>';
							$links; 					
						$floatdealer .='</div>
					</section>';
				 
					
		echo $floatdealer;
		
	}
	
	public function wholesalers ($start = 0) // LIST VIEW
	{
		$data = $this->data;
		$data['title'] = 'Wholesalers';

		$limit = 20;
		$count_result = $this->user_model->get_wholesalers_count($_GET);
		$data['wholesalers'] = $this->user_model->get_wholesalers($_GET, $start, $limit);
		$data['user_invites'] = $this->user_model->get_user_invites();
		$data['user_invite_count'] = count($data['user_invites']);

		$this->load->library('pagination');
		$config['base_url'] = site_url('account/wholesalers/');
		$config['total_rows'] = $count_result['cnt'];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config); 
		$data['links'] = $this->pagination->create_links();
		$data['result_count'] = $count_result['cnt'];
		
		$this->load->view('admin/wholesalers', $data);
	}

	public function referrers ($start = 0) // LIST VIEW
	{
		$data = $this->data;
		$data['title'] = 'Referrers';

		$limit = 20;
		$count_result = $this->user_model->get_referrers_count($_GET);
		$data['referrers'] = $this->user_model->get_referrers($_GET, $start, $limit);

		$this->load->library('pagination');
		$config['base_url'] = site_url('account/referrers/');
		$config['total_rows'] = $count_result['cnt'];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config); 
		$data['links'] = $this->pagination->create_links();
		$data['result_count'] = $count_result['cnt'];
	
		$this->load->view('admin/referrer_view', $data);
	}	

    public function dealer ($dealer_id) // MODAL VIEW
    {
		$agreement_link = site_url("home/agreement");
		$data = $this->data;
		$makes = $this->user_model->get_makes();
		$dealer = $this->user_model->get_dealer($dealer_id);
		$deal_agreement  = ($dealer['deal_agreement']==1)?"checked":'nochk';
		$dealer_contacts = str_replace('\\', '',$dealer['dealership_contacts']);
		$dealership_contact_boxs = str_replace('\\', '',$dealer['dealership_contact_boxs']);
		$dealer_contacts_html = '';
		$primary_contact_keys = array("quote_request_recipient","new_vehicle_tax_invoice_request_recipient","recipient_of_settlement_remittance_advice","introducer_tax_invoice_recipient");
		$dealership_contact_boxs_html = '';
		
		if($dealership_contact_boxs != '')
		{
			$dealership_contact_boxs_arr = json_decode($dealership_contact_boxs,true);
			if(is_array($dealership_contact_boxs_arr))
			{
				$i = 0;
				$dealership_contact_boxs_html .= "<div class='dealer-input-check'><span class='primary-contact'>Primary Contact</span>";
				foreach($dealership_contact_boxs_arr as $box_contact_key => $box_contact_value)
				{
					$checked = '';
					$box_contact_name  = ucwords(str_replace("_"," ", $box_contact_key ));
					if($box_contact_value=="on")
					{
						$checked = 'checked';
					}
					$dealership_contact_boxs_html .= "<input type='checkbox' {$checked} class='check-new-one in-check' id='{$box_contact_key}' name='primary_contact[{$i}]' required=''>";
					$dealership_contact_boxs_html .= "<label for='{$box_contact_key}' data-toggle='tooltip' data-placement='top' title='".$box_contact_name."' data-original-title='".$box_contact_name."'><span class='border-span'><i class='fa fa-check' aria-hidden='true'></i></span></label>";
					$i++;
				}
				$dealership_contact_boxs_html .= "</div>";
			}
		}
		else
		{
			$i = 0;
			$dealership_contact_boxs_html .= "<div class='dealer-input-check'><span class='primary-contact'>Primary Contact</span>";
			foreach($primary_contact_keys as $box_contact_key)
			{ 	$box_contact_name  = ucwords(str_replace("_"," ", $box_contact_key ));
				$dealership_contact_boxs_html .= "<input type='checkbox' checked='' class='check-new-one in-check' id='{$box_contact_key}' name='primary_contact[{$i}]' required=''>";
				$dealership_contact_boxs_html .= "<label for='{$box_contact_key}' data-toggle='tooltip' data-placement='top' itle='".$box_contact_name."' data-original-title='".$box_contact_name."'><span class='border-span'><i class='fa fa-check' aria-hidden='true'></i></span></label>";
				$i++;
			}
			$dealership_contact_boxs_html .= "</div>";
		}

		if($dealer_contacts != '')
		{	$contact_fullname = '';$contact_id='';
			$dealer_contacts_arr = json_decode($dealer_contacts,true);
			if(!empty($dealer_contacts_arr)){
			foreach ($dealer_contacts_arr as $row) {
				extract($row);
				if(!empty($row))
				{
					$n = $contact_id;
					$div_id = "data_".$n;
					$checkbox_input_name = "primary_contact[".$n."]";
					$dealer_contacts_html .= "<div id='{$div_id}'>";
					$dealer_contacts_html .= "<input type='hidden' name='contact_id[]' value='{$n}'>";
					if(isset($row['contact_boxs']))
					{
						$dealer_contacts_html .= "<div class='dealer-input-check'><span class='primary-contact'>Primary Contact</span>";
						if(!empty($contact_boxs))
						{
							$j = 0;
							foreach($contact_boxs as $contact_key => $contact_value)
							{
								$db_checked = '';
								$contact_key_name  = ucwords(str_replace("_"," ", $contact_key ));
								if($contact_value=="on")
								{
									$db_checked = 'checked';
								}
								$dealer_contacts_html .= "<input type='checkbox' {$db_checked} class='check-new-one in-check' id='{$contact_key}{$n}' name='{$checkbox_input_name}[{$j}]' required=''>";
								$dealer_contacts_html .= "<label for='{$contact_key}{$n}' data-toggle='tooltip' data-placement='top' title='' data-original-title='{$contact_key_name}'><span class='border-span'><i class='fa fa-check' aria-hidden='true'></i></span></label>";
								$j++;
							}
						}
						else
						{
							$j = 0;
							/*$dealer_contacts_html .= "<div class='dealer-input-check'><span class='primary-contact'>Primary Contact</span>";*/
							foreach($primary_contact_keys as $box_contact_key)
							{ 	$box_contact_name  = ucwords(str_replace("_"," ", $box_contact_key ));
								$dealer_contacts_html .= "<input type='checkbox' class='check-new-one in-check' id='{$box_contact_key}{$n}' name='{$checkbox_input_name}[{$j}]' required=''>";
								$dealer_contacts_html .= "<label for='{$box_contact_key}{$n}' data-toggle='tooltip' data-placement='top' itle='".$box_contact_name."' data-original-title='".$box_contact_name."'><span class='border-span'><i class='fa fa-check' aria-hidden='true'></i></span></label>";
								$j++;
							}
							/*$dealer_contacts_html .= "</div>";*/
						}
						$dealer_contacts_html .= "</div>";
					}
					
 					$dealer_contacts_html .= '<div class="form-group">
					<div class="dealer-detail-form-group">
						<span class="">Title</span>
						<input type="text" name="contact_title[]" id="contact_title'.$n.'" class="form-control pull-right valid" value="'.$contact_title.'" >
					</div>
					</div>
					<div class="form-group">
						<div class="dealer-detail-form-group">
							<span class="require-field">Full Name</span>
							<input type="text" name="contact_fullname[]" id="contact_fullname'.$n.'" class="form-control pull-right valid" value="'.$contact_fullname.'" required>
						</div>
					</div>
					<div class="form-group">
						<div class="dealer-detail-form-group">
							<span class="require-field">Email = Username</span>
							<input type="email" name="contact_email[]" id="contact_email'.$n.'" class="form-control pull-right valid" value="'.$contact_email.'" required>
						</div>
					</div>
					<div class="form-group">
						<div class="dealer-detail-form-group">
							<span class="">Mobile</span>
							<input type="text" name="contact_mobile[]" id="contact_mobile'.$n.'" class="form-control pull-right valid" value="'.$contact_mobile.'" >
						</div>
					</div>
					<div class="form-group">
						<div class="dealer-detail-form-group">
							<span class="">Landline</span>
							<input type="text" name="contact_landline[]" id="contact_landline'.$n.'" class="form-control pull-right valid" value="'.$contact_landline.'" >
						</div>
					</div>
					<div class="form-group text-right"><button type="button" name="delete_contact" id="delete_contact" class="btn btn-danger delete_contact" data-id="'.$div_id.'" onclick="">Delete</button></div>';
					$dealer_contacts_html .= "<hr></div>";
													
				}
			}
			}
		}
		$states = ['ACT','NSW','NT','QLD','SA','TAS','VIC','WA'];

		$dealer_details = '<div class="dealer-detail-inner-content">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<h5 class="dealer-heading">Dealership Details</h5>
						<div class="form-group">
							<div class="dealer-detail-form-group">
								<span>Dealership Name</span>
								<input type="text" id="dealership_name" name="dealership_name" class="form-control pull-right" value="'.$dealer['dealership_name'].'" >
							</div>														
						</div>
						<div class="form-group">
							<div class="dealer-detail-form-group">
								<span>Brands</span>
								<select class="form-control select-box" id="dealership_brand" name="dealership_brand[]" type="text" multiple="multiple">';
										$dealership_brand = str_replace('&', "", $dealer['dealership_brand']);
										$make_array = explode(",", $dealership_brand);
										foreach ($makes as $make_key => $make_val)
										{
											$dealer_details .= '
											<option '.(in_array(trim($make_val['name']), $make_array) ? ' selected="selected" ' : '').' value="'.$make_val['name'].'">
												'.$make_val['name'].'
											</option>';
										}
										$dealer_details .= '
									</select>
							</div>														
						</div>
						<div class="form-group">
							<div class="dealer-detail-form-group">
								<span>Catered States</span>
								<select class="form-control select-box" id="dealership_states" name="dealership_states[]" type="text" multiple="multiple">';
										$state_array = explode(",", $dealer['dealership_states']);
										foreach ($states as $state_key => $state_val)
										{
											$dealer_details .= '
											<option '.(in_array(trim($state_val), $state_array) ? ' selected="selected" ' : "").' value="'.$state_val.'">
												'.$state_val .'
											</option>';	
										}
										$dealer_details .= '
									</select>
							</div>														
						</div>
						<div class="form-group">
							<div class="dealer-detail-form-group">
								<span>Dealer Licence No</span>
								<input type="text" id="dealer_license" name="dealer_license" class="form-control pull-right" value="'.$dealer['dealer_license'].'">
							</div>														
						</div>
						<div class="form-group">
							<div class="dealer-detail-form-group">
								<span>ABN</span>
								<input type="text" id="abn" name="abn" class="form-control pull-right" value="'.$dealer['abn'].'">
							</div>														
						</div>
						<div class="form-group">
							<div class="dealer-detail-form-group">
								<span>Address</span>
								<input type="text" id="address" name="address" class="form-control pull-right" value="'.$dealer['address'].'">
							</div>														
						</div>
						<div class="form-group">
							<div class="dealer-detail-form-group">
								<span>Postcode</span>
								<input type="text" id="postcode" name="postcode" class="form-control pull-right" value="'.$dealer['postcode'].'">
							</div>														
						</div>
						<div class="dealer-heading-outer">
							<h5 class="dealer-heading">Bank Details</h5>
						</div>
						<div class="form-group">
							<div class="dealer-detail-form-group">
								<span>Account Name</span>
								<input type="text" id="bank_acct_name" name="bank_acct_name" class="form-control pull-right" value="'.$dealer['bank_acct_name'].'">
							</div>														
						</div>
						<div class="form-group">
							<div class="dealer-detail-form-group">
								<span>BSB</span>
								<input type="text" id="bank_acct_bsb" name="bank_acct_bsb" class="form-control pull-right" value="'.$dealer['bank_acct_bsb'].'">
							</div>														
						</div>
						<div class="form-group">
							<div class="dealer-detail-form-group">
								<span>Account No</span>
								<input type="text" id="bank_acct_num" name="bank_acct_num" class="form-control pull-right" value="'.$dealer['bank_acct_num'].'">
							</div>														
						</div>
						<div class="dealer-heading-outer">
							<h5 class="dealer-heading">Notes :</h5>
						</div>
						<div class="form-group">
							<div class="dealer-detail-form-group">
								<textarea style="width:100%" name="dealer_note" id="dealer_note" class="form-control " >'.$dealer['dealer_note'].'</textarea>
							</div>														
						</div>
					</div>
					<div class="col-md-6">';
						$dealer_details .= $dealership_contact_boxs_html; 
						$dealer_details .= '<div id="dealer_contact_form">
							<div class="form-group">
								<div class="dealer-detail-form-group">
									<span>Title</span>
									<input type="text" name="dealership_contact_title" class="form-control pull-right" value="'.$dealer['dealership_contact_title'].'">
								</div>
							</div>
							<div class="form-group">
								<div class="dealer-detail-form-group">
									<span class="require-field">Full Name</span>
									<input type="text" name="name" class="form-control pull-right" value="'.$dealer['name'].'" required>
								</div>
							</div>
							<div class="form-group">
								<div class="dealer-detail-form-group">
									<span class="require-field">Email = Username</span>
									<input type="email" name="email" class="form-control pull-right" value="'.$dealer['username'].'" required>
								</div>
							</div>
							<div class="form-group">
								<div class="dealer-detail-form-group">
									<span>Mobile</span>
									<input type="text" data-rule-number="true" name="mobile" value="'.$dealer['mobile'].'" class="form-control pull-right">
								</div>
							</div>
							<div class="form-group">
								<div class="dealer-detail-form-group">
									<span>Landline</span>
									<input type="text" data-rule-number="true" name="phone" value="'.$dealer['phone'].'" class="form-control pull-right">
								</div>
							</div>
						</div>
						
						<div class="form-group text-right">
							<button type="button" name="add_contact" id="add_contact" class="btn btn-default btn-custom" onClick="">Add Contact</button>
						</div>
						<div id="dealer_contacts">'.$dealer_contacts_html.'</div>
						<div class="form-group text-center dealer-margin-top">
							<a href="'.$agreement_link.'" target="_blank" class="agreement-anch">I have read the Accredited Dealer Agreement</a>
							<input type="checkbox" '.$deal_agreement.' class="check-new-one in-check" id="checknew5" name="deal_agreement" required>
							<label for="checknew5">
					       		<span class="border-span"><i class="fa fa-check" aria-hidden="true"></i></span>
				        	</label>
						</div>

						<div class="form-group text-right">
							<button type="button" name="send_notification" class="btn btn-default btn-custom sendNotificationToDealer" data-id="'. $dealer['id_user'].'">Send Notification</button>
							<button class="btn btn-default btn-close" type="button" data-dismiss="modal">Close</button>
							<button class="btn btn-default btn-save" type="button" onclick="save_dealer_info()">Save</button>
						</div>

					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">addContact();$(document).ready(function(){    $("[data-toggle='."'".'tooltip'."'".']").tooltip();  });</script>
		';
		/*
		<div class="form-group">
			<div class="dealer-detail-form-group">
				<span>Password</span>
				<input type="password" name="contact_password" class="form-control pull-right">
			</div>
		</div>
		<div class="form-group">
			<div class="dealer-detail-form-group">
				<span>Confirm Password</span>
				<input type="password" name="contact_conf_password" class="form-control pull-right">
			</div>
		</div>
		*/
		$dealer_actions = '';
		/*<button type="button" class="btn btn-primary sendNotificationToDealer"  data-id="'. $dealer['id_user'].'">Send Notification</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="button" class="btn btn-primary" onclick="save_dealer_info()">Save</button>*/

		$dealer_arr = array(
			"id_dealer" => $dealer['id_user'],
			"dealer_details" => $dealer_details,
			"dealer_actions" => $dealer_actions
		);
			
		echo json_encode($dealer_arr);
	}
	public function dealer_info ($editkey) // MODAL VIEW
    {
    	$agreement_link = site_url("home/agreement");
    	$dealer_data = $this->user_model->getRow("dealer_attributes",array("dealership_editkey"=>$editkey));

    	if($dealer_data)
    	{
    		$dealer_id = $dealer_data->fk_user;
    	}
    	else
    	{
    		redirect(base_url());
    	}
    	
		$data = $this->data;
	
		$makes = $this->user_model->get_makes();
		$dealer = $this->user_model->get_dealer($dealer_id);
		
			$deal_agreement  = ($dealer['deal_agreement']==1)?"checked":'nochk';
		$states = ['ACT','NSW','NT','QLD','SA','TAS','VIC','WA'];

		$dealer_contacts = str_replace('\\', '',$dealer['dealership_contacts']);
		$dealership_contact_boxs = str_replace('\\', '',$dealer['dealership_contact_boxs']);
		$dealership_contact_boxs_html = '';
		if($dealership_contact_boxs != '')
		{
			$dealership_contact_boxs_arr = json_decode($dealership_contact_boxs,true);
			if(is_array($dealership_contact_boxs_arr))
			{
				$i = 0;
				$dealership_contact_boxs_html .= "<div class='dealer-input-check'><span class='primary-contact'>Primary Contact</span>";
				foreach($dealership_contact_boxs_arr as $box_contact_key => $box_contact_value)
				{
					$checked = '';
					$box_contact_name  = ucwords(str_replace("_"," ", $box_contact_key ));
					if($box_contact_value=="on")
					{
						$checked = 'checked';
					}
					$dealership_contact_boxs_html .= "<input type='checkbox' {$checked} class='check-new-one in-check' id='{$box_contact_key}' name='primary_contact[{$i}]' required=''>";
					$dealership_contact_boxs_html .= "<label for='{$box_contact_key}' data-toggle='tooltip' data-placement='top' title='".$box_contact_name."' data-original-title='".$box_contact_name."'><span class='border-span'><i class='fa fa-check' aria-hidden='true'></i></span></label>";
					$i++;
				}
				$dealership_contact_boxs_html .= "</div>";
			}
		}
		else
		{
			$i = 0;
			$dealership_contact_boxs_html .= "<div class='dealer-input-check'><span class='primary-contact'>Primary Contact</span>";
			foreach($primary_contact_keys as $box_contact_key)
			{ 	$box_contact_name  = ucwords(str_replace("_"," ", $box_contact_key ));
				$dealership_contact_boxs_html .= "<input type='checkbox' class='check-new-one in-check' id='{$box_contact_key}' name='primary_contact[{$i}]' required=''>";
				$dealership_contact_boxs_html .= "<label for='{$box_contact_key}' data-toggle='tooltip' data-placement='top' itle='".$box_contact_name."' data-original-title='".$box_contact_name."'><span class='border-span'><i class='fa fa-check' aria-hidden='true'></i></span></label>";
				$i++;
			}
			$dealership_contact_boxs_html .= "</div>";
		}

		$dealer_contacts_arr = array();
		if($dealer_contacts != '')
		{
			$dealer_contacts_arr = json_decode($dealer_contacts,true);
		}
		$dealer_contacts_html = '';
		if(!empty($dealer_contacts_arr))
		{
			foreach ($dealer_contacts_arr as $row) {
				/*$rand_num = rand(0,255);
				$div_id = "div_".$rand_num;*/
				extract($row);
				if(!empty($row))
				{
					$n = $contact_id;
					$div_id = "data_".$n;
					$checkbox_input_name = "primary_contact[".$n."]";
					$dealer_contacts_html .= "<div id='{$div_id}'>";
					$dealer_contacts_html .= "<input type='hidden' name='contact_id[]' value='{$n}'>";
					if(isset($row['contact_boxs']))
					{
						$dealer_contacts_html .= "<div class='dealer-input-check'><span class='primary-contact'>Primary Contact</span>";
						if(!empty($contact_boxs))
						{
							$j = 0;
							foreach($contact_boxs as $contact_key => $contact_value)
							{
								$db_checked = '';
								$contact_key_name  = ucwords(str_replace("_"," ", $contact_key ));
								if($contact_value=="on")
								{
									$db_checked = 'checked';
								}
								$dealer_contacts_html .= "<input type='checkbox' {$db_checked} class='check-new-one in-check' id='{$contact_key}{$n}' name='{$checkbox_input_name}[{$j}]' required=''>";
								$dealer_contacts_html .= "<label for='{$contact_key}{$n}' data-toggle='tooltip' data-placement='top' title='' data-original-title='{$contact_key_name}'><span class='border-span'><i class='fa fa-check' aria-hidden='true'></i></span></label>";
								$j++;
							}
						}
						else
						{
							$j = 0;
							/*$dealer_contacts_html .= "<div class='dealer-input-check'><span class='primary-contact'>Primary Contact</span>";*/
							foreach($primary_contact_keys as $box_contact_key)
							{ 	$box_contact_name  = ucwords(str_replace("_"," ", $box_contact_key ));
								$dealer_contacts_html .= "<input type='checkbox' class='check-new-one in-check' id='{$box_contact_key}{$n}' name='{$checkbox_input_name}[{$j}]' required=''>";
								$dealer_contacts_html .= "<label for='{$box_contact_key}{$n}' data-toggle='tooltip' data-placement='top' itle='".$box_contact_name."' data-original-title='".$box_contact_name."'><span class='border-span'><i class='fa fa-check' aria-hidden='true'></i></span></label>";
								$j++;
							}
							/*$dealer_contacts_html .= "</div>";*/
						}
						$dealer_contacts_html .= "</div>";
					}

						$dealer_contacts_html .= '
						
						<div class="form-group">
							<div class="dealer-detail-form-group">
								<span class="require-field">Title</span>
								<input type="text" name="contact_title[]" class="form-control pull-right valid" value="'.$contact_title.'" required>
							</div>
						</div>
						<div class="form-group">
							<div class="dealer-detail-form-group">
								<span class="require-field">Full Name</span>
								<input type="text" name="contact_fullname[]" class="form-control pull-right valid" value="'.$contact_fullname.'" required>
							</div>
						</div>
						<div class="form-group">
							<div class="dealer-detail-form-group">
								<span class="require-field">Email = Username</span>
								<input type="email" name="contact_email[]" class="form-control pull-right valid" value="'.$contact_email.'" required>
							</div>
						</div>
						<div class="form-group">
							<div class="dealer-detail-form-group">
								<span class="require-field">Mobile</span>
								<input type="text" data-rule-number="true" name="contact_mobile[]" class="form-control pull-right valid" value="'.$contact_mobile.'" required>
							</div>
						</div>
						<div class="form-group">
							<div class="dealer-detail-form-group">
								<span class="require-field">Landline</span>
								<input type="text" data-rule-number="true" name="contact_landline[]" class="form-control pull-right valid" value="'.$contact_landline.'" required>
							</div>
						</div>
						<div class="form-group text-right"><button type="button" name="delete_contact" id="delete_contact" class="btn btn-danger" div_id="'.$div_id.'" onclick="deleteContact('."'".$div_id."'".')" onclick="">Delete</button></div><hr></div>';
				}
			}
			
		}
		$dealer_details = '<div class="dealer-detail-inner-content">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<h5 class="dealer-heading">Dealership Details</h5>
						<div class="form-group">
							<div class="dealer-detail-form-group">
								<span class="require-field">Dealership Name</span>
								<input type="text" id="dealership_name" name="dealership_name" class="form-control pull-right" value="'.$dealer['username'].'">
							</div>														
						</div>
						<div class="form-group">
							<div class="dealer-detail-form-group">
								<span class="require-field">Brands</span>
								<select class="form-control select-box" id="dealership_brand" name="dealership_brand[]" type="text" multiple="multiple" required>';
										$dealership_brand = str_replace('&', "", $dealer['dealership_brand']);
										$make_array = explode(",", $dealership_brand);
										foreach ($makes as $make_key => $make_val)
										{
											$dealer_details .= '
											<option '.(in_array(trim($make_val['name']), $make_array) ? ' selected="selected" ' : '').' value="'.$make_val['name'].'">
												'.$make_val['name'].'
											</option>';
										}
										$dealer_details .= '
									</select>
							</div>														
						</div>
						<div class="form-group">
							<div class="dealer-detail-form-group">
								<span class="require-field">Catered States</span>
								<select class="form-control select-box" id="dealership_states" name="dealership_states[]" type="text" multiple="multiple" required>';
										$state_array = explode(",", $dealer['dealership_states']);
										foreach ($states as $state_key => $state_val)
										{
											$dealer_details .= '
											<option '.(in_array(trim($state_val), $state_array) ? ' selected="selected" ' : "").' value="'.$state_val.'">
												'.$state_val .'
											</option>';	
										}
										$dealer_details .= '
									</select>
							</div>														
						</div>
						<div class="form-group">
							<div class="dealer-detail-form-group">
								<span class="require-field">Dealer Licence No</span>
								<input type="text" id="dealer_license" name="dealer_license" class="form-control pull-right" value="'.$dealer['dealer_license'].'" required>
							</div>														
						</div>
						<div class="form-group">
							<div class="dealer-detail-form-group">
								<span class="require-field">ABN</span>
								<input type="text" id="abn" name="abn" class="form-control pull-right" value="'.$dealer['abn'].'" required>
							</div>														
						</div>
						<div class="form-group">
							<div class="dealer-detail-form-group">
								<span class="require-field">Address</span>
								<input type="text" id="address" name="address" class="form-control pull-right" value="'.$dealer['address'].'" required>
							</div>														
						</div>
						<div class="form-group">
							<div class="dealer-detail-form-group">
								<span class="require-field">Postcode</span>
								<input type="text" id="postcode" name="postcode" class="form-control pull-right" value="'.$dealer['postcode'].'" required>
							</div>														
						</div>
						<div class="dealer-heading-outer">
							<h5 class="dealer-heading">Bank Details</h5>
						</div>
						<div class="form-group">
							<div class="dealer-detail-form-group">
								<span class="require-field">Account Name</span>
								<input type="text" id="bank_acct_name" name="bank_acct_name" class="form-control pull-right" value="'.$dealer['bank_acct_name'].'" required>
							</div>														
						</div>
						<div class="form-group">
							<div class="dealer-detail-form-group">
								<span class="require-field">BSB</span>
								<input type="text" id="bank_acct_bsb" name="bank_acct_bsb" class="form-control pull-right" value="'.$dealer['bank_acct_bsb'].'" required>
							</div>														
						</div>
						<div class="form-group">
							<div class="dealer-detail-form-group">
								<span class="require-field">Account No</span>
								<input type="text" id="bank_acct_num" name="bank_acct_num" class="form-control pull-right" value="'.$dealer['bank_acct_num'].'" required>
							</div>														
						</div>
					</div>
					<div class="col-md-6">';
						$dealer_details .= $dealership_contact_boxs_html; 
						$dealer_details .= '<div id="dealer_contact_form" action="#" method="post">
							<div class="form-group">
								<div class="dealer-detail-form-group">
									<span>Title</span>
									<input type="text" name="dealership_contact_title" class="form-control pull-right" value="'.$dealer['dealership_contact_title'].'">
								</div>
							</div>
							<div class="form-group">
								<div class="dealer-detail-form-group">
									<span class="require-field">Full Name</span>
									<input type="text" name="name" class="form-control pull-right" value="'.$dealer['name'].'" required>
								</div>
							</div>
							<div class="form-group">
								<div class="dealer-detail-form-group">
									<span class="require-field">Email = Username</span>
									<input type="email" name="email" class="form-control pull-right" value="'.$dealer['username'].'" required>
								</div>
							</div>
							<div class="form-group">
								<div class="dealer-detail-form-group">
									<span>Mobile</span>
									<input type="text" data-rule-number="true" name="mobile" value="'.$dealer['mobile'].'" class="form-control pull-right">
								</div>
							</div>
							<div class="form-group">
								<div class="dealer-detail-form-group">
									<span>Landline</span>
									<input type="text" data-rule-number="true" name="phone" value="'.$dealer['phone'].'" class="form-control pull-right">
								</div>
							</div>
						</div>
						<div class="form-group text-right">
							<button type="button" name="add_contact" id="add_contact" class="btn btn-default btn-custom" onClick="addContactFront();">Add Contact</button>
						</div>
						<div id="dealer_contacts">';
						$dealer_details .= $dealer_contacts_html;
						$dealer_details .= '</div>
							<div class="form-group">
								<div class="dealer-detail-form-group">
									<span class="require-field">Password</span>
									<input type="password" name="password" id="password" class="form-control pull-right" value="" required>
								</div>
							</div>
							<div class="form-group">
								<div class="dealer-detail-form-group">
									<span class="require-field">Confirm Password</span>
									<input type="password" name="conf_password" id="conf_password" data-rule-equalTo="#password" class="form-control pull-right" value="" data-msg-equalTo="Password and Confirm Password Must Be Same." required>
								</div>
							</div>';
						$dealer_details .= '
						<div class="form-group text-center dealer-margin-top">
							<a href="'.$agreement_link.'" target="_blank" class="agreement-anch">I have read the Accredited Dealer Agreement</a>
							<input type="checkbox" '.$deal_agreement.' class="check-new-one in-check" id="checknew5" name="deal_agreement" required>
							<label for="checknew5">
					       		<span class="border-span"><i class="fa fa-check" aria-hidden="true"></i></span>
				        	</label>
						</div>

						<div class="form-group text-right">
							<button type="button" class="btn btn-default btn-save" onclick="save_front_dealer_info()">Save</button>
						</div>
					</div>
				</div>
			</div>
		</div><script type="text/javascript">$(document).ready(function(){    $("[data-toggle='."'".'tooltip'."'".']").tooltip();  });</script>
		';
		$newVar = '<div class="container">
				<div class="row">
					<div class="col-md-6">
						<h5 class="dealer-heading">Dealership Details</h5>
						<div class="form-group">
							<div class="dealer-detail-form-group">
								<span class="require-field">Dealership Name</span>
								<input type="text" id="dealership_name" name="dealership_name" class="form-control pull-right" value="'.$dealer['username'].'" readonly="readonly">
							</div>														
						</div>';
		/*
		<button type="button" name="send_notification" class="btn btn-default btn-custom sendNotificationToDealer" data-id="'. $dealer['id_user'].'">Send Notification</button>
		<button class="btn btn-default btn-close" type="button" data-dismiss="modal">Close</button>
		*/
		/*
		<div class="form-group">
			<div class="dealer-detail-form-group">
				<span>Password</span>
				<input type="password" name="contact_password" class="form-control pull-right">
			</div>
		</div>
		<div class="form-group">
			<div class="dealer-detail-form-group">
				<span>Confirm Password</span>
				<input type="password" name="contact_conf_password" class="form-control pull-right">
			</div>
		</div>
		*/
		$dealer_actions = '';
		/*<button type="button" class="btn btn-primary sendNotificationToDealer"  data-id="'. $dealer['id_user'].'">Send Notification</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="button" class="btn btn-primary" onclick="save_dealer_info()">Save</button>*/
		$dealer_details = trim(preg_replace('/\s\s+/', ' ', $dealer_details));
		$dealer_arr = array(
			"id_dealer" => $dealer['id_user'],
			"dealer_details" => $dealer_details,
			"dealer_actions" => $dealer_actions,
			"newVar"=>trim($newVar),
			'company'=>array("favicon"=>"")
		);

		$this->load->view("admin/dealer_info",$dealer_arr);	
		//echo json_encode($dealer_arr);
	}

	public function update_dealer_profile () // MODAL ACTION
	{
		$input_arr = $this->input->post();
		$primary_contact_keys = array("quote_request_recipient","new_vehicle_tax_invoice_request_recipient","recipient_of_settlement_remittance_advice","introducer_tax_invoice_recipient");
		$primary_contact_data = array();
		for($i=0;$i<count($primary_contact_keys);$i++)
		{
			if(isset($input_arr['primary_contact'][$i]))
			{
				$primary_contact_data[$primary_contact_keys[$i]] = $input_arr['primary_contact'][$i];
			}
			else
			{
				$primary_contact_data[$primary_contact_keys[$i]] = "off";
			}
		}
		$input_arr['dealership_contact_boxs'] = json_encode($primary_contact_data);
		
		$contact_data = array();
		$contact_mail_id = '';
		$contact_data_keys = array("contact_id","contact_title","contact_fullname","contact_email","contact_mobile","contact_landline");
		
		$primary_data = array();
		if(array_key_exists('contact_title', $input_arr))
		{
			for($i=0;$i<count($input_arr['contact_title']);$i++)
			{
				$one_data = array();
				
				foreach ($contact_data_keys as $contact_key) {
					if(!empty($input_arr['contact_fullname'][$i]) && !empty($input_arr['contact_email'][$i]))
					{
						$one_data[$contact_key] = $input_arr[$contact_key][$i];
						if($contact_key=="contact_id")
						{
							$contact_id = $input_arr[$contact_key][$i];
							$contact_boxs = '';
							
							if(is_array($input_arr['primary_contact'][$contact_id]))
							{

								for($j=0;$j<count($primary_contact_keys);$j++)
								{
									if(isset($input_arr['primary_contact'][$contact_id][$j]))
									{
										$one_primary_contact_data[$primary_contact_keys[$j]] = $input_arr['primary_contact'][$contact_id][$j];
									}
									else
									{
										$one_primary_contact_data[$primary_contact_keys[$j]] = "off";
									}
								}
								$contact_boxs = $one_primary_contact_data;
							}
							$one_data['contact_boxs'] = $contact_boxs;
						}
					}					
				}
				$contact_data[] = $one_data;
			}
		}
		$curr_time = date("Y-m-d H:i:s");
		$rand_str = md5($curr_time);
		$input_arr['dealership_contacts'] = !empty($contact_data) ? preg_replace('/\\\\\"/',"\"",json_encode($contact_data)) : ' ';
		$input_arr['dealership_editkey'] = $rand_str;
		//$input_arr['dealership_password'] = '';
		//print_r($input_arr);exit;
		$update_res = $this->user_model->update_dealer_profile($input_arr['dealer_id'], $input_arr);
		if($update_res)
		{
			//$this->send_contactdetail_to_dealer($input_arr['dealer_id'],$rand_str);
		}
		else
		{
			echo "fail";
			exit;
		}
	}
	public function update_front_dealer_profile () // MODAL ACTION
	{
		$input_arr = $this->input->post();
		$contact_mail_id = '';
		$primary_contact_keys = array("quote_request_recipient","new_vehicle_tax_invoice_request_recipient","recipient_of_settlement_remittance_advice","introducer_tax_invoice_recipient");
		$primary_contact_data = array();
		for($i=0;$i<count($primary_contact_keys);$i++)
		{
			if(isset($input_arr['primary_contact'][$i]))
			{
				$primary_contact_data[$primary_contact_keys[$i]] = $input_arr['primary_contact'][$i];
			}
			else
			{
				$primary_contact_data[$primary_contact_keys[$i]] = "off";
			}
		}
		$input_arr['dealership_contact_boxs'] = json_encode($primary_contact_data);
		
		$contact_data = array();
		$contact_data_keys = array("contact_id","contact_title","contact_fullname","contact_email","contact_mobile","contact_landline");

		if(array_key_exists('contact_title', $input_arr))
		{
			for($i=0;$i<count($input_arr['contact_title']);$i++)
			{
				$one_data = array();
				
				foreach ($contact_data_keys as $contact_key) {
					if(!empty($input_arr['contact_fullname'][$i]) && !empty($input_arr['contact_email'][$i]))
					{
						$one_data[$contact_key] = $input_arr[$contact_key][$i];
						if($contact_key=="contact_id")
						{
							$contact_id = $input_arr[$contact_key][$i];
							$contact_boxs = '';
							
							if(is_array($input_arr['primary_contact'][$contact_id]))
							{
								for($j=0;$j<count($primary_contact_keys);$j++)
								{
									if(isset($input_arr['primary_contact'][$contact_id][$j]))
									{
										$one_primary_contact_data[$primary_contact_keys[$j]] = $input_arr['primary_contact'][$contact_id][$j];
									}
									else
									{
										$one_primary_contact_data[$primary_contact_keys[$j]] = "off";
									}
								}
								$contact_boxs = $one_primary_contact_data;
							}
							$one_data['contact_boxs'] = $contact_boxs;
						}	
					}					
				}
				$contact_data[] = $one_data;
			}
		}
		//print_r($contact_data);exit;
		$curr_time = date("Y-m-d H:i:s");
		$rand_str = md5($curr_time);
		$input_arr['dealership_contacts'] = !empty($contact_data) ? preg_replace('/\\\\\"/',"\"",json_encode($contact_data)) : '';
		$input_arr['dealership_editkey'] = '';
		$input_arr['dealership_password'] = md5($input_arr['password']);
		$upass_status = $this->user_model->update_password($input_arr['dealer_id'],$input_arr['dealership_password']);
		$update_res = $this->user_model->update_dealer_profile($input_arr['dealer_id'], $input_arr);
		if($update_res && !empty($contact_data) && $upass_status)
		{
			$this->send_contactdetail_to_front_user($contact_mail_id,$input_arr['password']);
		}
		else
		{
			echo "fail";
			exit;
		}
	}

	public function send_contactdetail_to_dealer($dealer_id,$rand_str)
	{
		$dealer = $this->user_model->get_dealer($dealer_id);
		if($dealer)
		{
			$link_url = site_url("account/dealer_info/".$rand_str);
			$data = $this->data;
			//print_r($dealer);
			$from_email = $data['company']['company_email'];
			$from_name = $data['company']['company_name'];
			$to = $dealer['username'];//"devakshay89@gmail.com";
			$subject = $data['company']['company_name']." - Dealer Contacts";
			/* <p>
					<a href="'.$link_url.'" style="text-decoration:none;background: #58c603;border: none !important;color: #fff;font-weight: 400;font-size: 16px;padding: 4px 10px !important;width: 35%;margin-top: 10px;">Submit</a>
				</p> */
			$content = '
				<p style="line-height: 1.5">
					Thank you for register with <b>'.$data['company']['company_name'].'</b> as a Dealer account. 
				</p>
				<p style="line-height: 1.5">
					Kindly request you to complete your profile information. Please <a href="'.$link_url.'">click here</a> to login.
				</p>
								
				<p style="line-height: 1.5">
					<br><br>
					Thank you,
					<br />
					<b>'.$data['company']['company_name'].'</b>
				</p>';
			//echo $content;exit;
			$this->send_templated_email ($from_email, $from_name, $to, $subject, $content, $file = "");	
			echo 1;exit;
		}
		else
		{
			echo 0;exit;
		}
	}
	public function send_contactdetail_to_front_user($contact_mail_id,$password)
	{
		if($contact_mail_id != '')
		{
			$data = $this->data;
			$from_email = $data['company']['company_email'];
			$from_name = $data['company']['company_name'];
			$to =  $dealer['username']; //"devakshay89@gmail.com";
			$subject = $data['company']['company_name']." - Dealer Contacts";
			$content = '
				<p style="line-height: 1.5">
					Thank you for register with <b>'.$data['company']['company_name'].'</b> as a Dealer account. 
				</p>
				<p style="line-height: 1.5">
					Account information: 
				</p>
				<p>Email : '.$contact_mail_id.'</p>
				<p>Password : '.$password.'</p>
								
				<p style="line-height: 1.5">
					<br><br>
					Thank you,
					<br />
					<b>'.$data['company']['company_name'].'</b>
				</p>';
			//echo $content;exit;
			$this->send_templated_email ($from_email, $from_name, $to, $subject, $content, $file = "");	
			echo 1;exit;
		}
		else
		{
			echo 0;exit;
		}
	}
    public function wholesaler ($id) // MODAL VIEW
    {
		$data = $this->data;
		$details = '';
		$query = "
		SELECT 
		CASE (u.status)
			WHEN 0 THEN 'Deactivated'
			WHEN 1 THEN 'Activated'
		END `status_text`,
		u.id_user, u.status, u.username, u.password, u.name, u.abn, u.state, u.postcode, u.address, u.phone, u.mobile, u.description,u.dob, u.account_holders_name, u.bank_acct_name, u.bank_acct_bsb, u.bank_acct_num
		FROM users u
		WHERE u.id_user = ".$id;
		$result = $this->db->query($query);
		foreach ($result->result() as $row)
		{
			$details .= '
			<tr>
				<td>ABN:</td>
				<td><input value="'.$row->abn.'" class="form-control input-sm" id="wholesaler_abn_in" name="abn" type="text"></td>
			</tr>			
			<tr>
				<td>Name of Manager:</td>
				<td><input value="'.$row->name.'" class="form-control input-sm" id="wholesaler_name_in" name="name" type="text"></td>
			</tr>
			<tr>
				<td>State:</td>
				<td>
					<select class="form-control " id="wholesaler_state_in" name="state" type="text">
						<option name="state" value="">-State-</option>
						<option name="state" value="ACT" '.(($row->state=="ACT") ? "selected='selected'" : "").'>ACT - Australian Capital Territory</option>
						<option name="state" value="NSW" '.(($row->state=="NSW") ? "selected='selected'" : "").'>NSW - New South Wales</option>
						<option name="state" value="NT" '.(($row->state=="NT") ? "selected='selected'" : "").'>NT - Northern Territory</option>
						<option name="state" value="QLD" '.(($row->state=="QLD") ? "selected='selected'" : "").'>QLD - Queensland</option>
						<option name="state" value="SA" '.(($row->state=="SA") ? "selected='selected'" : "").'>SA - South Australia</option>
						<option name="state" value="TAS" '.(($row->state=="TAS") ? "selected='selected'" : "").'>TAS - Tasmania</option>
						<option name="state" value="VIC" '.(($row->state=="VIC") ? "selected='selected'" : "").'>VIC - Victoria</option>
						<option name="state" value="WA" '.(($row->state=="WA") ? "selected='selected'" : "").'>WA - Western Australia</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Postcode:</td>
				<td><input value="'.$row->postcode.'" class="form-control input-sm" id="wholesaler_postcode_in" name="postcode" type="text"></td>
			</tr>
			<tr>
				<td>Address:</td>
				<td><input value="'.$row->address.'" class="form-control input-sm" id="wholesaler_address_in" name="address" type="text"></td>
			</tr>			
			<tr>
				<td>Phone of Manager:</td>
				<td><input value="'.$row->phone.'" class="form-control input-sm" id="wholesaler_phone_in" name="phone" type="text"></td>
			</tr>
			<tr>
				<td>Mobile of Manager:</td>
				<td><input value="'.$row->mobile.'" class="form-control input-sm" id="wholesaler_mobile_in" name="mobile" type="text"></td>
			</tr>
			<tr >
				<td>Date of Birth:</td>
				<td><input value="'.$row->dob.'" class="form-control input-md datepicker_wholesaler" name="dob" id="wholesaler_dob" type="text"></td>
			</tr>
			<tr >
				<td>Account Holder\'s Name:</td>
				<td><input value="'.$row->account_holders_name.'" class="form-control input-md" id="wholesaler_account_holders_name" name="account_holders_name" type="text"><td>
			</tr>
			<tr >
				<td>Bank Account Name:</td>
				<td><input value="'.$row->bank_acct_name.'" class="form-control input-md" name="bank_acct_name" id="wholesaler_bank_acct_name" type="text"></td>
			</tr>
			<tr >
				<td>Bank Account Number:</td>
				<td><input value="'.$row->bank_acct_num.'" class="form-control input-md" name="bank_acct_num" id="wholesaler_bank_acct_num" type="text"></td>
			</tr>
			<tr >
				<td>BSB Number:</td>
				<td><input value="'.$row->bank_acct_bsb.'" class="form-control input-md" name="bank_acct_bsb" id="wholesaler_bank_acct_bsb" type="text"></td>
			</tr>
			<tr>
				<td>Description:</td>
				<td><textarea class="form-control input-sm" id="wholesaler_description_in" name="description">'.$row->description.'</textarea></td>
			</tr>			
			';

			$actions = '
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary" onclick="save_wholesaler_info()">Save</button>
			';			

			$arr = array(
				"id" => $row->id_user,
				"details" => $details,
				"actions" => $actions
			);
		}
		echo json_encode($arr);
	}

	public function update_wholesaler_profile () // MODAL ACTION
	{
		$input_arr = $this->input->post();
		$this->user_model->update_wholesaler_profile($input_arr['wholesaler_id'], $input_arr);
	}

	public function referrer ($id) // MODAL VIEW
    {
		$data = $this->data;
		$details = '';
		$query = "
		SELECT 
		CASE (u.status)
			WHEN 0 THEN 'Deactivated'
			WHEN 1 THEN 'Activated'
		END `status_text`,
		u.id_user, u.status, u.username, u.password, u.name, u.abn, u.state, u.postcode, u.address, u.phone, u.mobile, u.description,u.dob, u.account_holders_name, u.bank_acct_name, u.bank_acct_bsb, u.bank_acct_num
		FROM referrers u
		WHERE u.id_user = ".$id; // change the "FROM" from users to referrers
		$result = $this->db->query($query);

		foreach ($result->result() as $row)
		{


			$details .= '		
			<tr>
				<td>Name of Manager:</td>
				<td><input value="'.$row->name.'" class="form-control input-sm" id="referrer_name_in" name="name" type="text"></td>
			</tr>
			<tr>
				<td>State:</td>
				<td>
					<select class="form-control " id="referrer_state_in" name="state" type="text">
						<option name="state" value="">-State-</option>
						<option name="state" value="ACT" '.(($row->state=="ACT") ? "selected='selected'" : "").'>ACT - Australian Capital Territory</option>
						<option name="state" value="NSW" '.(($row->state=="NSW") ? "selected='selected'" : "").'>NSW - New South Wales</option>
						<option name="state" value="NT" '.(($row->state=="NT") ? "selected='selected'" : "").'>NT - Northern Territory</option>
						<option name="state" value="QLD" '.(($row->state=="QLD") ? "selected='selected'" : "").'>QLD - Queensland</option>
						<option name="state" value="SA" '.(($row->state=="SA") ? "selected='selected'" : "").'>SA - South Australia</option>
						<option name="state" value="TAS" '.(($row->state=="TAS") ? "selected='selected'" : "").'>TAS - Tasmania</option>
						<option name="state" value="VIC" '.(($row->state=="VIC") ? "selected='selected'" : "").'>VIC - Victoria</option>
						<option name="state" value="WA" '.(($row->state=="WA") ? "selected='selected'" : "").'>WA - Western Australia</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Postcode:</td>
				<td><input value="'.$row->postcode.'" class="form-control input-sm" id="referrer_postcode_in" name="postcode" type="text"></td>
			</tr>
			<tr>
				<td>Address:</td>
				<td><input value="'.$row->address.'" class="form-control input-sm" id="referrer_address_in" name="address" type="text"></td>
			</tr>			
			<tr>
				<td>Phone of Manager:</td>
				<td><input value="'.$row->phone.'" class="form-control input-sm" id="referrer_phone_in" name="phone" type="text"></td>
			</tr>
			<tr>
				<td>Mobile of Manager:</td>
				<td><input value="'.$row->mobile.'" class="form-control input-sm" id="referrer_mobile_in" name="mobile" type="text"></td>
			</tr>
			<tr >
				<td>Date of Birth:</td>
				<td><input value="'.$row->dob.'" class="form-control input-md datepicker_referrer" name="dob" id="referrer_dob" type="text"></td>
			</tr>
			<tr >
				<td>Account Holder\'s Name:</td>
				<td><input value="'.$row->account_holders_name.'" class="form-control input-md" id="referrer_account_holders_name" name="account_holders_name" type="text"><td>
			</tr>
			<tr >
				<td>Bank Account Name:</td>
				<td><input value="'.$row->bank_acct_name.'" class="form-control input-md" name="bank_acct_name" id="referrer_bank_acct_name" type="text"></td>
			</tr>
			<tr >
				<td>Bank Account Number:</td>
				<td><input value="'.$row->bank_acct_num.'" class="form-control input-md" name="bank_acct_num" id="referrer_bank_acct_num" type="text"></td>
			</tr>
			<tr >
				<td>BSB Number:</td>
				<td><input value="'.$row->bank_acct_bsb.'" class="form-control input-md" name="bank_acct_bsb" id="referrer_bank_acct_bsb" type="text"></td>
			</tr>
			<tr>
				<td>Description:</td>
				<td><textarea class="form-control input-sm" id="referrer_description_in" name="description">'.$row->description.'</textarea></td>
			</tr>			
			';

			$actions = '
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary" onclick="save_referrer_info()">Save</button>
			';			

			$arr = array(
				"id" => $row->id_user,
				"details" => $details,
				"actions" => $actions
			);
		}
		echo json_encode($arr);
	}

	public function update_referrer_profile () // MODAL ACTION
	{
		$input_arr = $this->input->post();
		$this->user_model->update_referrer_profile($input_arr['referrer_id'], $input_arr);
	}

    public function staff ($user_id) // MODAL VIEW
    {
		$user = $this->user_model->get_staff($user_id);
		if (isset($user['name']))
		{
			$details .= '
			<tr>
				<td>ABN:</td>
				<td><input value="'.$user['abn'].'" class="form-control input-sm" id="staff_abn_in" name="abn" type="text"></td>
			</tr>			
			<tr>
				<td>Name of Manager:</td>
				<td><input value="'.$user['name'].'" class="form-control input-sm" id="staff_name_in" name="name" type="text"></td>
			</tr>
			<tr>
				<td>State:</td>
				<td>
					<select class="form-control " id="staff_state_in" name="state" type="text">
						<option name="state" value="">-State-</option>
						<option name="state" value="ACT" '.(($user['state']=="ACT") ? "selected='selected'" : "").'>ACT - Australian Capital Territory</option>
						<option name="state" value="NSW" '.(($user['state']=="NSW") ? "selected='selected'" : "").'>NSW - New South Wales</option>
						<option name="state" value="NT" '.(($user['state']=="NT") ? "selected='selected'" : "").'>NT - Northern Territory</option>
						<option name="state" value="QLD" '.(($user['state']=="QLD") ? "selected='selected'" : "").'>QLD - Queensland</option>
						<option name="state" value="SA" '.(($user['state']=="SA") ? "selected='selected'" : "").'>SA - South Australia</option>
						<option name="state" value="TAS" '.(($user['state']=="TAS") ? "selected='selected'" : "").'>TAS - Tasmania</option>
						<option name="state" value="VIC" '.(($user['state']=="VIC") ? "selected='selected'" : "").'>VIC - Victoria</option>
						<option name="state" value="WA" '.(($user['state']=="WA") ? "selected='selected'" : "").'>WA - Western Australia</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Postcode:</td>
				<td><input value="'.$user['postcode'].'" class="form-control input-sm" id="staff_postcode_in" name="postcode" type="text"></td>
			</tr>
			<tr>
				<td>Address:</td>
				<td><input value="'.$user['address'].'" class="form-control input-sm" id="staff_address_in" name="address" type="text"></td>
			</tr>			
			<tr>
				<td>Phone of Manager:</td>
				<td><input value="'.$user['phone'].'" class="form-control input-sm" id="staff_phone_in" name="phone" type="text"></td>
			</tr>
			<tr>
				<td>Mobile of Manager:</td>
				<td><input value="'.$user['mobile'].'" class="form-control input-sm" id="staff_mobile_in" name="mobile" type="text"></td>
			</tr>
			<tr>
				<td>Description:</td>
				<td><textarea class="form-control input-sm" id="staff_description_in" name="description">'.$user['description'].'</textarea></td>
			</tr>';

			$actions = '
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary" onclick="save_staff_info()">Save</button>';

			$output_arr = array(
				"id" => $user['id_user'],
				"details" => $details,
				"actions" => $actions
			);
		}
		echo json_encode($output_arr);
	}

	public function update_staff_profile () // MODAL ACTION
	{
		$input_arr = $this->input->post();
		$this->user_model->update_admin_profile($input_arr['staff_id'], $input_arr);
	}

	public function activate_lead_stack ($user_id)
	{
		$this->user_model->activate_lead_stack($user_id);
	}

	public function deactivate_lead_stack ($user_id)
	{
		$this->user_model->deactivate_lead_stack($user_id);
	}
	
	public function activate ($user_id) // AJAX Action
	{
		$this->user_model->activate($user_id);
	}

	public function deactivate ($user_id) // AJAX Action
	{
		$this->user_model->deactivate($user_id);
	}	
	
	public function delete ($user_id) // AJAX Action
	{
		$this->user_model->delete($user_id);
	}

	public function change_pma_status () // AJAX Action
	{
		$return_array = [];

		$post_data = $this->input->post();

		$return_array['status'] = $post_data['status'];
		$return_array['status_text'] = "";
		if($this->user_model->update_pma_status($post_data['dealer_id'], $post_data['status']))
		{
			$return_array['status_text'] = ($post_data['status'] == 1) ? "Active" : "Inactive";
		}
		echo json_encode($return_array);
	}	

	public function change_gold_status () // AJAX Action
	{
		$return_array = [];

		$post_data = $this->input->post();

		$return_array['status'] = $post_data['status'];
		$return_array['status_text'] = "";
		if($this->user_model->update_gold_status($post_data['dealer_id'], $post_data['status']))
		{
			$return_array['status_text'] = ($post_data['status'] == 1) ? "Gold" : "Standard";
		}
		echo json_encode($return_array);
	}

	public function change_deposit_visibility_status () // AJAX Action
	{
		$return_array = [];
		$input_arr = $this->input->post();
		$return_array['status'] = $input_arr['status'];
		$this->user_model->change_deposit_visibility_status($input_arr['dealer_id'], $input_arr['status']);
		echo json_encode($return_array);
	}
	/*public function send_notification_to_dealer()
	{
		$post_data = $this->input->post();
		$dealer_id = $post_data['id'];
		$dealer = $this->user_model->get_dealer($dealer_id );
		if($dealer)
		{
			$data = $this->data;
			//print_r($dealer);
			$from_email = $data['company']['company_email'];
			$from_name = $data['company']['company_name'];
			$to = $dealer['username'];
			$subject = $data['company']['company_name']." - Dealer Registration";
			$content = '
				<p style="line-height: 1.5">
					Thank you for register with <b>'.$data['company']['company_name'].'</b> as a Dealer account. 
				</p>
				<p style="line-height: 1.5">
					Kindly request you to complete your profile information. Please <a href="'.site_url('login').'">click here</a> to login.
				</p>				
				<p style="line-height: 1.5">
					<br><br>
					Thank you,
					<br />
					<b>'.$data['company']['company_name'].'</b>
				</p>';
			//echo $content;exit;
			$this->send_templated_email ($from_email, $from_name, $to, $subject, $content, $file = "");	
			echo 1;exit;
		}
		else
		{
			echo 0;exit;
		}
		
		//echo json_encode($return_array);
	}*/
	public function send_notification_to_dealer()
	{
		$post_data = $this->input->post();
		$dealer_id = $post_data['id'];
		//$dealer_id = 587;
		$is_status_changed = $this->user_model->deactivate($dealer_id);
		$enc_dealer_id = md5($dealer_id);
		$dealer = $this->user_model->get_dealer($dealer_id);
		if($dealer)
		{
			$data = $this->data;
			//echo "<pre>";print_r($dealer);exit;
			$keys = array("dealership_name"=>"Dealership Name","dealership_brand"=>"Franchise Brands","dealership_states"=>"Catered States","dealership_address"=>"Dealership Address","name"=>"Primary Contact","dealership_contact_title"=>"Primary Contact title","email"=>"Email","mobile"=>"Mobile","phone"=>"Landline");
			$from_email = $data['company']['company_email'];
			$from_name = $data['company']['company_name'];
			$to = $dealer['username'];
			//$subject = $data['company']['company_name']." - Dealer Registration";
			$subject = "FinQuote: Dealer Detail Confirmation & Registration";
			$content = "
				<p style='line-height: 1.5'>
					Hi {$from_name}
				</p>
				<p style='line-height: 1.5'>
					Thank you for your interest in becoming a registered new car supplier for FinQuote.
				</p>
				<p style='line-height: 1.5'>
				Please review the Accredited Dealer Agreement attached and the details we hold for you and the dealership below. Please click the Confirm &amp; Submit button to activate your account so as new quote requests can be sent to you straight away. 
				</p>
				<p style='line-height: 1.5;margin-bottom: 25px;'>
					Once registered you will receive an email with login details to your account where you can update your details,change your password, see all quotes request, quotes submitted and orders won.
				</p>";
			foreach ($keys as $key => $caption) {
				$content .= "<p style='line-height: 0.5'> <strong>{$caption}</strong> : {$dealer[$key]} </p> \n";
			}
			$content .= "
				<p style='line-height:1.5;text-align:center;'>
					We look forward to working with you.
				</p>				
				<p style='line-height:1.5;text-align:center;'>
					<a href='".site_url("Process/confirmdealer/{$enc_dealer_id}")."' style='background-color: #58c603;text-decoration: none;color: #fff;padding: 10px;border-radius: 5px;'>Confirm & Submit</a>
				</p>
				<p style='line-height: 1.5'>
					<br><br>
					Kind Regards,
					<br />
					<b>".$data['company']['company_name']."</b>
				</p>";
			//echo $content;exit;
			$this->mm_send_templated_email ($from_email, $from_name, $to, $subject, $content, $file = "");	
			echo 1;exit;
		}
		else
		{
			echo 0;exit;
		}
		//echo json_encode($return_array);
	}
	
}
?>


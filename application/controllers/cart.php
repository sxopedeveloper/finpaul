<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('eway.php');
require_once('user.php');

class Cart extends User 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model', '', TRUE);
		$this->load->model('car_model', '', TRUE);
		$this->load->model('ticket_model', '', TRUE);
		$this->load->model('notification_model', '', TRUE);		
		$this->load->model('fapplication_model', '', TRUE);		
		$this->load->model('flead_model', '', TRUE);
		$this->load->model('lead_model', '', TRUE);
		$this->load->model('request_model', '', TRUE);
		$this->load->model('quote_model', '', TRUE);
		$this->load->model('tradein_model', '', TRUE);
		$this->load->model('payment_model');
		$this->load->model('eway_transactions_model');
		
		if($this->session->userdata('logged_in'))
		{
			$user = $this->user_model->get_user_balance($this->session->userdata('user_id'));

			$this->data = array(
				'logged_in' => $this->session->userdata('logged_in'),
				'login_type' => $this->session->userdata('login_type'),
				'admin_type' => $this->session->userdata('admin_type'),
				'user_id' => $this->session->userdata('user_id'),
				'username' => $this->session->userdata('username'),
				'name' => $this->session->userdata('name'),
				'phone' => $this->session->userdata('phone'),
				'mobile' => $this->session->userdata('mobile'),
				'state' => $this->session->userdata('state'),
				'postcode' => $this->session->userdata('postcode'),
				'status' => $this->session->userdata('status'),
				'makes' => $this->car_model->get_makes(),
				'ticket_types' => $this->ticket_model->get_ticket_types(),
				'modules' => $this->ticket_model->get_modules(),
				'balance' => $user['balance']
			);			
		}
		else
		{
			header("Location: " . site_url('login'));
			exit();
		}
	}

	function index()
	{
		header("Location: " . site_url('cart/list_view'));
		exit();
	}

	// LIST VIEW //
	public function list_view ($start = 0) // PAGE VIEW (LV)
	{		
		$data = $this->data;
		$data['title'] = 'Purchase Confirmation';

		// print_r($data);
		// die ();

		$data['token_infos'] = $this->payment_model->get_token_infos($data['user_id']);

		$this->load->view('cart', $data);
	}
	
    public function add_to_cart ()
    {
		$lead_ids = $this->input->post('lead_ids');
		$quantity = 1;

		$lead_id_arr = explode (',', $lead_ids);
		foreach ($lead_id_arr as $lead_id)
		{
			$lead_details = $this->lead_model->get_lead_cart($lead_id);
			if (isset($lead_details['name']))
			{
				$lead_name = $lead_details['name'];
				$lead_price = $lead_details['lead_price'];
				$cart = array(
				   'id'      => $lead_id,
				   'qty'     => $quantity,
				   'price'   => $lead_price,
				   'name'    => $lead_name
				);
				$this->cart->insert($cart);
			}
		}
    }

	public function remove_item ()
	{
		$row_id = $this->input->post('cart_id');
		$data = array('rowid' => $row_id, 'qty' => 0);
		$this->cart->update($data);
	}

	public function submit_payment ()
    {
    	$lead_details = [];

    	$data = $this->data;
    	$post_data = $this->input->post();
    	$response_array = ['status' => FALSE, 'message' => 'Oops! Something went wrong!'];

    	$payment_method = $this->input->post('payment_method');
    	$error = 0;
    	if ($payment_method==1)
    	{
    		$user_details = $this->user_model->get_user_balance($data['user_id']);
			$lead_arr = [];
			$cart_ctr = 0;
	    	$total_amount = 0;
			foreach ($this->cart->contents() as $item)
			{
				if ($item['qty'] <> 0) 
				{
					$lead_details = $this->lead_model->get_lead_cart($item['id']);
					if ($lead_details['fk_buyer']==0 AND $lead_details['fk_user']==0 AND $lead_details['fk_temp_user']==0 AND $lead_details['attempt_flag']==0 AND $lead_details['status']<3)
					{
						$this->lead_model->update_lead_buyer($item['id'], $data['user_id']);
						$lead_arr[$item['id']] = $item['price'];
						$total_amount += $item['price'];
						$cart_ctr++;
					}
				}
			}

			$new_user_balance = $user_details['balance'] + $total_amount;
			$this->user_model->update_user_balance($data['user_id'], $new_user_balance);
			
			$discount = 0;
			$original_amount = $total_amount;
			$trans_data = [
				'fk_user'      		=> $data['user_id'],
				'quantity'     		=> $cart_ctr,
				'original_amount'	=> (float)$original_amount,
				'discount'			=> (float)$discount,
				'amount'       		=> (float)$total_amount,
				'transaction_type' 	=> 0,
				'payment_type' 		=> 1,
				'deprecated'   		=> 0,
				'created_at'   		=> date("Y-m-d H:i:s")
			];
			$this->lead_model->insert_lead_transaction($trans_data);
			
			if (count($lead_arr) <> 0)
			{
				$transaction_id = $this->db->insert_id();
				$this->lead_model->insert_lead_transaction_items($transaction_id, $lead_arr);			
			}
    	}
    	else if ($payment_method==2) 
    	{
			$lead_arr = [];
    		$cart_ctr = 0;
    		$token_total_amt = 0;
    		foreach ($this->cart->contents() as $cart_key => $cart_val) 
			{
				if ($cart_val['qty'] <> 0) 
				{
					$lead_details = $this->lead_model->get_lead_cart($cart_val['id']);
					if ($lead_details['fk_buyer']==0 AND $lead_details['fk_user']==0 AND $lead_details['fk_temp_user']==0 AND $lead_details['attempt_flag']==0 AND $lead_details['status']<3) // Check Lead Availability
					{
						$this->lead_model->update_lead_buyer($cart_val['id'], $data['user_id']); // Temporarily Update Lead Buyer
						$lead_arr[$cart_val['id']] = $cart_val['price'];
						$token_total_amt += $cart_val['price'];
						$cart_ctr++;
					}
				}
			}
			$payment_amt = ((float)$token_total_amt * 100.00);

    		if($post_data['cc_method'] == 1 && $token_total_amt > 0) // Already has token
    		{
    			$token_info = $this->payment_model->get_token($post_data['token_id']);
    			$recurring_array = array(
					'customer_token' => $token_info['token'],
					'total_amount' => $payment_amt - ($payment_amt * .10) // 10% discount for cc payment
				);

				$response = $this->recurring_transaction($recurring_array);
				if(isset($response['TransactionID'])) // Credit Card Info Validation
				{
					$eway_trans_data = [
						'fk_user'      => $data['user_id'],
						'fk_token'     => $token_info['id'],
						'trans_type'   => 2,
						'trans_amount' => ((float)$token_total_amt),
						'trans_id'     => $response['TransactionID'],
						'auth_code'    => $response['AuthorisationCode'],
						'date_created' => date("Y-m-d H:i:s")
					];
					$this->eway_transactions_model->insert_transactions($eway_trans_data); // Eway Transactions DB

					$error = 0;
					if(isset($response['AuthorisationCode']))
					{
						if($response['AuthorisationCode'] == "000000")
						{
							$response_array['message'] = "Payment was declined! Please check your credit card details and make sure that you have sufficient funds.";
							$error = 1;

							$error_array = [
								'response_codes'  => '000000',
								'controller'      => 'cart.php',
								'transaction_num' => (isset($response['TransactionID'])) ? $response['TransactionID'] : '',
								'fk_main'         => $data['user_id']
							];
							$this->eway_transactions_model->insert_response_codes($error_array);	

							foreach ($this->cart->contents() as $dec_key => $dec_val) 
							{
								$this->lead_model->revert_lead_buyer($dec_val['id'], $data['user_id']);
							}
						}
						else
						{
							$discount = $token_total_amt * .10;
							$original_amount = $token_total_amt;
							$total_amount = $token_total_amt - $discount;
							$trans_data = [
								'fk_user'      		=> $data['user_id'],
								'quantity'     		=> $cart_ctr,
								'original_amount'	=> (float)$original_amount,
								'discount'			=> (float)$discount,
								'amount'       		=> (float)$total_amount,
								'transaction_type' 	=> 0,
								'payment_type' 		=> 2,
								'deprecated'   		=> 0,
								'created_at'   		=> date("Y-m-d H:i:s")
							];
							$this->lead_model->insert_lead_transaction($trans_data); // Lead Sales Transactions

							if (count($lead_arr) <> 0)
							{
								$transaction_id = $this->db->insert_id();
								$this->lead_model->insert_lead_transaction_items($transaction_id, $lead_arr);			
							}							
						}
					}
				}
				else // If Credit Card Info (Format) is incorrect
				{
					foreach ($this->cart->contents() as $dec_key => $dec_val) 
					{
						$this->lead_model->revert_lead_buyer($dec_val['id'], $data['user_id']);
					}

					if(isset($response['error_codes']))
					{
						$error_array = [
							'response_codes'  => $response['error_codes'],
							'controller'      => 'cart.php',
							'transaction_num' => (isset($response['TransactionID'])) ? $response['TransactionID'] : '',
							'fk_main'         => 0
						];

						$this->eway_transactions_model->insert_response_codes($error_array);
						$err_arr = explode(',', $response['error_codes']);
						$err_string = "";

						foreach ($err_arr as $err_key => $err_val) 
						{
							switch ($err_val) 
							{
								case 'V6100':
									$err_string .= "Invalid Card Name";
									break;
								case 'V6101':
									$err_string .= "Invalid Expiry Month";
									break;
								case 'V6102':
									$err_string .= "Invalid Expiry Year";
									break;
								case 'V6106':
									$err_string .= "Invalid CVN";
									break;			
								case 'V6110':
									$err_string .= "Invalid Credit Card Number";
									break;
								default:
									$err_string .= "Error code: {$err_val}";
									break;
							}
							$err_string .= ", ";
						}
						
						$err_string = rtrim($err_string, ', ');

						$response_array['message'] = " Error: " . $err_string . "!";
						$response_array['message'] .= " This Credit Card cannot be authorized at the moment. Please contact the administrators for further info.";
						$error = 1;
					}
					else
					{
						$response_array['message'] = "Sorry, your payment was declined. Please make sure that your Credit Card information is correct and that you have sufficient funds to proceed with the purchase.";
						$error = 1;
					}
				}
    		}
    		else if($post_data['cc_method'] == 2 && $token_total_amt > 0)
			{
				$token_identifier = 0;

    			if($post_data['is_checked'] == 1)
    			{
    				$create_token_array =[
						'first_name' => $post_data['first_name'],
						'last_name'  => $post_data['last_name'],
						'cc_number'  => $post_data['credit_card_number'],
						'exp_month'  => $post_data['expiry_month'],
						'exp_year'   => $post_data['expiry_year'],
						'cvn'        => $post_data['cvn'],
						'card_type'  => $post_data['card_type']
    				];

    				$token_response = $this->insert_token_info($create_token_array);
    				$token_json = json_decode($token_response, TRUE);
	    			$token_identifier = (isset($token_json['id'])) ? $token_json['id'] : 0;
    			}

				$payment_array = [
					'name'      => $post_data['first_name'] ." ". $post_data['last_name'],
					'cc_number' => $post_data['credit_card_number'],
					'exp_month' => $post_data['expiry_month'],
					'exp_year'  => $post_data['expiry_year'],
					'cvn'       => $post_data['cvn'],
					'amount'    => $payment_amt - ($payment_amt * .10) // 10% discount for cc payment
				];
				$response = $this->straight_transaction($payment_array);

				if(isset($response['TransactionID']))
				{
					$eway_trans_data = [
						'fk_user'      => $data['user_id'],
						'fk_token'     => $token_identifier,
						'trans_type'   => 1,
						'trans_amount' => ((float)$token_total_amt),
						'trans_id'     => $response['TransactionID'],
						'auth_code'    => $response['AuthorisationCode'],
						'date_created' => date("Y-m-d H:i:s")
					];
					$this->eway_transactions_model->insert_transactions($eway_trans_data);

					$response_array['status'] = TRUE;
					$error = 0;
					if(isset($response['AuthorisationCode']))
					{
						if($response['AuthorisationCode'] == "000000")
						{
							$response_array['message'] = "Payment was declined! Please check your credit card details and balance...";
							$error = 1;

							$error_array = [
								'response_codes'  => '000000',
								'controller'      => 'cart.php',
								'transaction_num' => (isset($response['TransactionID'])) ? $response['TransactionID'] : '',
								'fk_main'         => $data['user_id']
							];
							$this->eway_transactions_model->insert_response_codes($error_array);	

							foreach ($this->cart->contents() as $dec_key => $dec_val) 
							{
								$this->lead_model->revert_lead_buyer($dec_val['id'], $data['user_id']);
							}
						}
						else
						{
							$discount = $token_total_amt * .10;
							$original_amount = $token_total_amt;
							$total_amount = $token_total_amt - $discount;
							$trans_data = [
								'fk_user'      		=> $data['user_id'],
								'quantity'     		=> $cart_ctr,
								'original_amount'	=> (float)$original_amount,
								'discount'			=> (float)$discount,
								'amount'       		=> (float)$total_amount,
								'transaction_type' 	=> 0,
								'payment_type' 		=> 2,
								'deprecated'   		=> 0,
								'created_at'   		=> date("Y-m-d H:i:s")
							];
							$this->lead_model->insert_lead_transaction($trans_data); // Lead Sales Transactions

							if (count($lead_arr) <> 0)
							{
								$transaction_id = $this->db->insert_id();
								$this->lead_model->insert_lead_transaction_items($transaction_id, $lead_arr);			
							}							
						}
					}
				}
				else
				{
					foreach ($this->cart->contents() as $dec_key => $dec_val) 
					{
						$this->lead_model->revert_lead_buyer($dec_val['id'], $data['user_id']);
					}

					if(isset($response['error_codes']))
					{
						$error_array = [
							'response_codes'  => $response['error_codes'],
							'controller'      => 'cart.php',
							'transaction_num' => (isset($response['TransactionID'])) ? $response['TransactionID'] : '',
							'fk_main'         => 0
						];
						$this->eway_transactions_model->insert_response_codes($error_array);
						$err_arr = explode(',', $response['error_codes']);
						$err_string = "";
						foreach ($err_arr as $err_key => $err_val) 
						{
							switch ($err_val) 
							{
								case 'V6100':
									$err_string .= "Invalid Card Name";
									break;
								case 'V6101':
									$err_string .= "Invalid Expiry Month";
									break;
								case 'V6102':
									$err_string .= "Invalid Expiry Year";
									break;
								case 'V6106':
									$err_string .= "Invalid CVN";
									break;			
								case 'V6110':
									$err_string .= "Invalid Credit Card Number";
									break;
								default:
									$err_string .= "Error code: {$err_val}";
									break;
							}
							$err_string .= ", ";
						}
						$err_string = rtrim($err_string, ', ');

						$response_array['message'] = " Error: " . $err_string . "!";
						$response_array['message'] .= " This Credit Card cannot be authorized at the moment. Please contact the administrators for further info.";
						$error = 1;
					}
					else
					{
						$response_array['message'] = "Sorry, your payment was declined...";
						$error = 1;
					}
				}
    		}
    		else
    		{
    			$error = 1;
    		}
    	}
    	else
		{
			$error = 1; 
		}

    	if ($error==0)
    	{
			$this->session->unset_userdata('cart_contents');
			$response_array['status']  = TRUE;
			$response_array['message'] = "Transaction Successful!";
    	}

    	echo json_encode($response_array);
    }

	public function get_cart_items_count ()
	{
		$data = $this->data;
		echo count($this->cart->contents());
	}

    public function eway_checkout ($order_id)
    {
        if (!$order_id) { show_404(); }

        $response = array();

        $amount = 30; // real amount 
        $amount = $amount * 100; //The amount of the transaction in the lowest denomination for the currency.
        $CurrencyCode = "AUD";
        $RedirectUrl = base_url("cart/eway_redirect/" . $order_id);
        $CancelUrl = base_url("cart/eway_cancel/" . $order_id);

        $params = array("TotalAmount" => $amount, "CurrencyCode" => $CurrencyCode, "RedirectUrl" => $RedirectUrl, "CancelUrl" => $CancelUrl);

        $this->load->library('rapidapi', $params);

        $result = $this->rapidapi->CreateAccessCodesShared();

        if (isset($result->Errors)) 
        {
            // Get Error Messages from Error Code. Error Code Mappings are in the Config.ini file
            $ErrorArray = explode(",", $result->Errors);
            $lblError = "";
            foreach ($ErrorArray as $error) 
            {
                $error = $this->rapidapi->getMessage($error);
                $lblError .= $error . "<br />\n";
            }
            $response['payment_error'] = $lblError; //if failed, show errors
        } 
        else 
        {
            $redirect_url = $response['redirect_url'] = $result->SharedPaymentUrl; //in success, redirect to eway site for payment
            redirect($redirect_url); //send to eway fro real payment
            return FALSE;
        }

        echo "<pre>";
        print_r($response);
        echo "</pre>";
        //$this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function eway_redirect($id) /* Eway redirects after transaction finished */
    {
        if (!$id) 
        {
        	show_404(); 
		}

        $data = array();
        $data['error'] = false;
        unset($_SESSION['order_id']);

        if (isset($_GET['AccessCode']) && $_GET['AccessCode'] != "") 
        {
            $AccessCode = $_GET['AccessCode'];
        } 
        else 
        {
            show_404();
        }

        $this->load->library('rapidapi');
        $result = $this->rapidapi->GetAccessCodeResult($AccessCode); //confirm tansaction

        $lblError = "";

        if (isset($result->Errors)) 
        {
            $ErrorArray = explode(",", $result->Errors);
            foreach ($ErrorArray as $error) 
            {
                $error = $this->rapidapi->getMessage($error);
                $lblError .= $error . "<br />\n";
            }
        }
        //echo $lblError;die();

        if (isset($lblError) && $lblError != "") 
        {
            $data['error_message'] = $lblError;
            $data['error'] = true;
        } 
        else 
        {
            if ($result->ResponseMessage == "A2000" && $result->ResponseCode == '00') //Transaction Approved
            {
                echo "<pre>";
                print_r($result);
                echo "</pre>";
                //save to your database here, i have not created save function here
                $data['success_message'] = "The following order has been purchased successfully.";
            } 
            else 
            {
                $lblError .= "Your transaction has been inturrupted." . "<br />\n";
                $data['error_message'] = $lblError;
            }
        }
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        //$this->load->view('eway_sucess_v', $data); //view success message
    }

    public function eway_cancel($id) /* Eway redirecs if transaction is cancelled by users */
    {
        if (!$id) { show_404(); }

        $data = array();
        unset($_SESSION['order_id']);
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        //$this->load->view('eway_cancel_v', $data); //view cancel message
    }

	public function load_order ($order_id) // To be rechecked
	{
		$this->load->model('order_model', '', TRUE);
		$data['order_details'] = $this->order_model->get_order($order_id);
		$order_arr = array(
			"order_id" 			=> $data['order_details']['id_order'], 
			"status" 			=> $data['order_details']['status'],
			"description" 		=> $data['order_details']['description'],
			"price" 			=> $data['order_details']['price'],
			"payment_method" 	=> $data['order_details']['payment_method'],
			"reference_no" 		=> $data['order_details']['reference_no'],
			"shipping" 			=> $data['order_details']['shipping'],
			"address" 			=> $data['order_details']['address'],
			"created_at" 		=> $data['order_details']['created_at']
		);

		echo json_encode($order_arr);
	}
}
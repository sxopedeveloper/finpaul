<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('unlogged_main.php');

class Campaign extends Unlogged_main
{
	public function __construct()
	{
	    ob_start();
		parent::__construct();
	}

	function index ()
	{
		header ("Location: ".site_url());
		exit ();
	}

	public function process ()
	{
		date_default_timezone_set('Australia/Sydney');
		ini_set('max_execution_time', -1);	
		$now = date("Y-m-d H:i:s");

		$lead_id = $_POST['lead_id'];
		$redirect_url = $_POST['redirect_url'];
		$postcode = $_POST['postcode'];
		$make = $_POST['make'];
		$model = $_POST['model'];
		
		// $user_id = $this->pma_purchase($lead_id, $postcode, $make);
		// $this->templated_dealer_lead_email_init(18, $user_id, $lead_id, "company", "dealer");
		$this->templated_client_email_init(16, $lead_id, "company");
		
		header ("Location: ".$redirect_url);
		exit();
	}
	
	public function send_pma_activate_email ()
	{
		date_default_timezone_set('Australia/Sydney');
		ini_set('max_execution_time', -1);	
		$now = date("Y-m-d H:i:s");

		$query = "SELECT id_user FROM users WHERE pma_status = 1";
		$pma_active_dealers = $this->db->query($query)->row_array();
		if (count($pma_active_dealers)>0)
		{
			foreach ($pma_active_dealers AS $pma_active_dealer)
			{
				$this->templated_dealer_email_init(17, $pma_active_dealer['id_user']);
			}
		}
	}

	public function pma_purchase ($lead_id, $postcode, $make)
	{
		$email_type = "";
		$user_id = 0;

		$current_month = date('m');
		$current_year = date('Y');
		$query = "
		SELECT u.id_user, u.username, u.pma_status, u.lead_cap, u.postcode,
		u.id_user AS `user_id`, 
		u.lead_cap AS `monthly_cap`,
		(	
			SELECT COUNT(1) FROM leads 
			WHERE fk_buyer = `user_id` 
			AND MONTH(`purchase_date`) = '".$current_month."' 
			AND YEAR(`purchase_date`) = '".$current_year."'
		) AS `this_month_purchase`,
		(SELECT purchase_date FROM leads WHERE fk_buyer = `user_id` ORDER BY purchase_date DESC LIMIT 1) AS `last_purchase_date`,
		(SELECT IF (`last_purchase_date` IS NULL, '0000-00-00 00:00:00', `last_purchase_date`)) AS `lpd`		
		FROM users u 
		JOIN dealer_attributes da ON u.id_user = da.fk_user
		WHERE 1
		AND u.pma_status = 1 		
		AND da.dealership_brand LIKE '%".$this->db->escape_str($make)."%'
		AND (
			u.postcode = '".$this->db->escape_str($postcode)."'
			OR u.id_user IN (SELECT fk_user FROM pma_protection WHERE postcode = '".$this->db->escape_str($postcode)."')
		)
		GROUP BY u.id_user
		HAVING `monthly_cap` > `this_month_purchase`
		ORDER BY lpd ASC LIMIT 1";
		$chosen_buyer = $this->db->query($query)->row_array();
		if (isset($chosen_buyer['id_user']))
		{
			$lead_price = 44;
			$lead_arr[$lead_id] = 44;

			$success = 0;			
			
			$user_id = $chosen_buyer['id_user'];
			$token_infos = $this->payment_model->get_token_infos($user_id);
			if (count($token_infos)>0)
			{
				foreach($token_infos AS $token_info)
				{
					$recurring_array = array(
						'customer_token' => $token_info['token'],
						'total_amount' => $lead_price - ($lead_price * .10)
					);

					$response = $this->recurring_transaction($recurring_array);
					if(isset($response['TransactionID'])) // Credit Card Info Validation
					{
						$eway_trans_data = [
							'fk_user'      => $user_id,
							'fk_token'     => $token_info['id'],
							'trans_type'   => 2,
							'trans_amount' => ((float)$recurring_array['total_amount']),
							'trans_id'     => $response['TransactionID'],
							'auth_code'    => $response['AuthorisationCode'],
							'date_created' => date("Y-m-d H:i:s")
						];
						$this->eway_transactions_model->insert_transactions($eway_trans_data); // Eway Transactions DB //						

						if(isset($response['AuthorisationCode']))
						{
							if($response['AuthorisationCode'] == "000000")
							{
								$error_message = "Credit Card Payment was declined!";
								$error_array = [
									'response_codes'  => '000000',
									'controller'      => 'campaign.php',
									'transaction_num' => (isset($response['TransactionID'])) ? $response['TransactionID'] : '',
									'fk_main'         => $user_id
								];
								$this->eway_transactions_model->insert_response_codes($error_array);
							}
							else
							{
								$discount = $lead_price * .10;
								$original_amount = $lead_price;
								$total_amount = $lead_price - $discount;
								$trans_data = [
									'fk_user'      		=> $user_id,
									'quantity'     		=> 1,
									'original_amount'	=> (float)$original_amount,
									'discount'			=> (float)$discount,
									'amount'       		=> (float)$total_amount,
									'transaction_type' 	=> 1,
									'payment_type' 		=> 2,
									'deprecated'   		=> 0,
									'created_at'   		=> date("Y-m-d H:i:s")
								];
								$this->lead_model->insert_lead_transaction($trans_data); // Lead Sales Transactions
								$transaction_id = $this->db->insert_id();
								$this->lead_model->insert_lead_transaction_items($transaction_id, $lead_arr);
							
								$success = 1;
								break;
							}
						}
					}
				}

				if ($success == 0)
				{
					$email_type = "Credit Card payment declined";
				}
				else
				{
					$email_type = "Credit Card payment successful";
				}
			}
			else
			{
				$email_type = "No Credit Card information";
			}

			if ($success == 0) // If Credit Card Payment Failed, proceed to 7 Day Account
			{
				$user_details = $this->user_model->get_user_balance($user_id);	
				$new_balance = $user_details['balance'] + $lead_price;
				$this->user_model->update_user_balance($user_id, $new_balance);
				
				$discount = 0;
				$original_amount = $lead_price;
				$total_amount = $lead_price - $discount;
				$trans_data = [
					'fk_user'      		=> $user_id,
					'quantity'     		=> 1,
					'original_amount'	=> (float)$original_amount,
					'discount'			=> (float)$discount,
					'amount'       		=> (float)$total_amount,
					'transaction_type' 	=> 1,
					'payment_type' 		=> 1,
					'deprecated'   		=> 0,
					'created_at'   		=> date("Y-m-d H:i:s")
				];
				$this->lead_model->insert_lead_transaction($trans_data); // Lead Sales Transactions
				$transaction_id = $this->db->insert_id();
				$this->lead_model->insert_lead_transaction_items($transaction_id, $lead_arr);				
			}

			$this->lead_model->update_lead_buyer($lead_id, $user_id, 1);			
		}
		return $user_id;
	}
}
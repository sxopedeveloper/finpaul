<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require "vendor/autoload.php";

class Squareup
{
	private $charge_api   = null;
	private $location_api = null;
	private $customer_api = null;
	private $card_api     = null;

	private $access_token = 'sandbox-sq0atb-8LTDrYd8LDDCFmiBWuTobA';

	private $locations_response = null;
	private $location_id = "";

	function __construct()
	{
		$this->charge_api   = new \SquareConnect\Api\TransactionApi();
		$this->location_api = new \SquareConnect\Api\LocationApi();
		$this->customer_api = new \SquareConnect\Api\CustomerApi();
		$this->card_api     = new \SquareConnect\Api\CustomerCardApi();

		$this->locations_response = $this->location_api->listLocations($this->access_token);

		$location_arr = json_decode($this->locations_response, TRUE);

		$this->location_id = $location_arr['locations'][0]['id'];
	}

	function index()
	{
		echo "hello!";		
	}

	function charge($charge_array = [], $card_nonce = "", $card_id = "", $customer_id = "")
	{
		$response_array = [];

		$idempotencyKey = uniqid();

		// $card_id = "a07a8e42-2643-5928-567f-5a7e0f2c8231";
		// $customer_id = "CBASEH0l1jTK8aiGuOH_7dPmvDogAQ";

		$charge_array = [
			'idempotency_key' => $idempotencyKey,
			'amount_money' => [
				'amount' => 200, 
				'currency' => 'AUD'
			],
			'buyer_email_address' => "christian@qteme.com.au"
		];

		if($card_nonce != "")
			$charge_array['card_nonce'] = $card_nonce;
		else{
			$charge_array['customer_card_id'] = $card_id;
			$charge_array['customer_id']      = $customer_id;
		}

		try 
		{
			$response_array['response'] = json_decode($this->charge_api->charge($this->access_token, $this->location_id, $charge_array), TRUE);
			// $response = $this->charge_api->charge($this->access_token, $this->location_id, $charge_array);
		} 
		catch (Exception $e) 
		{
			$response_array['error'] = $e->getMessage();
			// $response = $e->getMessage();
		}

		// echo "<pre>";
		// print_r(json_decode($response, TRUE)); die();

		return $response_array;
	}

	function retrieve_transcation($transaction_id = "")
	{
		$response_array = [];

		try 
		{
			$response_array['response'] = json_decode($this->charge_api->retrieveTransaction($this->access_token, $this->location_id, $transaction_id), TRUE);
		}
		catch (Exception $e) 
		{
			$response_array['error'] = $e->getMessage();
			// $response = $e->getMessage();
		}

		return $response_array;
	}

	function list_transactions()
	{
		$result = $this->charge_api->listTransactions($this->access_token, $this->location_id);

		$json_array = json_decode($result, TRUE);

		echo "<pre>";
		print_r($json_array);

		// return $json_array = json_decode($result, TRUE);
	}

	function list_customer()
	{

	}

	function create_customer($customer_array = [])
	{
		$response_array = [];

		$customer_array = [
			'given_name'    => 'Amelia',
			'family_name'   => 'Earhart',
			'email_address' => 'Amelia.Earhart@example.com',
			'reference_id'  => '666',
			'note'          => 'Client'
		];

		try 
		{
			$response_array['response'] = json_decode($this->customer_api->createCustomer($this->access_token, $customer_array), TRUE);
		} 
		catch (Exception $e) 
		{
			$response_array['error'] = $e->getMessage();
		}

		return json_decode($response_array, TRUE);
	}

	function create_customer_card($customer_id = "", $card_nonce = "", $cardholder_name = "")
	{
		$response_array = [];

		$card_nonce = "CBASED5OtQN9ZzOEkaTvoX8XiPUgAQ";
		$customer_id = "CBASEH0l1jTK8aiGuOH_7dPmvDogAQ";

		$card_array = [
			'card_nonce' => $card_nonce,
			'cardholder_name' => 'Amelia Earhart',
		];

		try 
		{
			$response_array['response'] = json_decode($this->card_api->createCustomerCard($this->access_token, $customer_id, $card_array),TRUE);
		} 
		catch (Exception $e) 
		{
			$response_array['error'] = $e->getMessage();
		}

		return $response_array;

	}
}




<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set('max_execution_time', -1);

require_once('./application/libraries/eway-rapid-php-master/include_eway.php');

class Eway extends CI_Controller 
{
	// this commented api key, api password and endpoint are for sandbox testing purposes only please do not erase
	// private $apiKey      = 'F9802Cnp8Wp/TyDS2sSV8mremEmjtkBCmQuefAFtv7jgpTr0a5fVUQZJxsw9NPlEDtdhqv';
	// private $apiPassword = 'PYuKUJXK';
	// private $apiEndpoint = \Eway\Rapid\Client::MODE_SANDBOX;
	private $apiKey = 'F9802A2PBBp853tR3Ei5TJiYbsqJJ/geKdG2SyH1mn5N9w0lprA2I6eGd5x/hi9c4Zyalg';
	private $apiPassword = 'h8bwZjFk';
	private $apiEndpoint = \Eway\Rapid\Client::MODE_PRODUCTION;
	private $client;
	private $data = [];

	public function __construct ()
	{
		parent::__construct();
		$this->client = \Eway\Rapid::createClient($this->apiKey, $this->apiPassword, $this->apiEndpoint);
	}

	public function index ()
	{
		header ("Location: ".site_url());
	}

	
	
	
	public function create_customer_token ($customer_array = array())
	{
		$return_array = array();
		$response = $this->client->createCustomer(\Eway\Rapid\Enum\ApiMethod::DIRECT, $customer_array);
		if ($response->Errors === null)
		{
			$return_array['tokenCustomerID'] = $response->Customer->TokenCustomerID;
		} 
		else 
		{
		    $return_array['error_codes'] = $response->Errors;
		}
		return $return_array;
	}

	public function payment_transaction ($payment_array = array())
	{
		$return_array = array();
		$transaction = [
		    'Customer' => [
		        'TokenCustomerID' => $payment_array['customer_token'],
		        'CardDetails' => [
			        'CVN' => "{$payment_array['cvn']}",
		    	]
		    ],
		    'Payment' => [
		        'TotalAmount' => $payment_array['total_amount'],
		    ],
		    'TransactionType' => \Eway\Rapid\Enum\TransactionType::PURCHASE,
		];
		$response = $this->client->createTransaction(\Eway\Rapid\Enum\ApiMethod::DIRECT, $transaction);
		if ($response->TransactionStatus)
		{
			$return_array['TransactionID']     = $response->TransactionID;
			$return_array['AuthorisationCode'] = $response->AuthorisationCode;
			$reutrn_array['ResponseCode']      = $response->ResponseCode;
		} 
		else 
		{
		    $return_array['error_codes'] = $response->Errors;
		}
		return $return_array;
	}

	public function recurring_transaction($payment_array = array())
	{
		$return_array = array();
		$transaction = [
		    'Customer' => [
		        'TokenCustomerID' => $payment_array['customer_token']
		    ],
		    'Payment' => [
		        'TotalAmount' => $payment_array['total_amount'],
		    ],
		    'TransactionType' => \Eway\Rapid\Enum\TransactionType::RECURRING
		];
		$response = $this->client->createTransaction(\Eway\Rapid\Enum\ApiMethod::DIRECT, $transaction);

		if ($response->TransactionStatus)
		{
			$return_array['TransactionID']     = $response->TransactionID;
			$return_array['AuthorisationCode'] = $response->AuthorisationCode;
			$reutrn_array['ResponseCode']      = $response->ResponseCode;
		} 
		else 
		{
		    $return_array['error_codes'] = $response->Errors;

		    $return_array['TransactionID']     = isset($response->TransactionID) ? $response->TransactionID : "";
			$return_array['AuthorisationCode'] = isset($response->AuthorisationCode) ? $response->AuthorisationCode : "";
			$reutrn_array['ResponseCode']      = isset($response->ResponseCode) ? $response->ResponseCode : "";
		}
		return $return_array;
	}
	
	public function charge_customer($id)
	{
		// array(2) { ["TransactionID"]=> int(203253676) ["AuthorisationCode"]=> string(6) "076205" }

		if ($id==1)
		{
			$payment_array['customer_token'] = '';
			$payment_array['total_amount'] = 200000;
		}

		$return_array = array();
		$transaction = [
		    'Customer' => [
		        'TokenCustomerID' => $payment_array['customer_token']
		    ],
		    'Payment' => [
		        'TotalAmount' => $payment_array['total_amount'],
		    ],
		    'TransactionType' => \Eway\Rapid\Enum\TransactionType::RECURRING
		];
		$response = $this->client->createTransaction(\Eway\Rapid\Enum\ApiMethod::DIRECT, $transaction);
		if ($response->TransactionStatus)
		{
			$return_array['TransactionID']     = $response->TransactionID;
			$return_array['AuthorisationCode'] = $response->AuthorisationCode;
			$reutrn_array['ResponseCode']      = $response->ResponseCode;
		} 
		else 
		{
		    $return_array['error_codes'] = $response->Errors;
		}

		var_dump($return_array);
	}

	public function straight_transaction($payment_array = array())
	{
		$return_array = array();
		$transaction = [
		    'Customer' => [
		        'CardDetails' => [
		            'Name' => $payment_array['name'],
		            'Number' => $payment_array['cc_number'],
		            'ExpiryMonth' => $payment_array['exp_month'],
		            'ExpiryYear' => $payment_array['exp_year'],
		            'CVN' => $payment_array['cvn'],
		        ]
		    ],
		    'Payment' => [
		        'TotalAmount' => $payment_array['amount'],
		    ],
		    'TransactionType' => \Eway\Rapid\Enum\TransactionType::PURCHASE,
		];

		$response = $this->client->createTransaction(\Eway\Rapid\Enum\ApiMethod::DIRECT, $transaction);
		if (!$response->getErrors())
		{
			$return_array['TransactionID']     = $response->TransactionID;
			$return_array['AuthorisationCode'] = $response->AuthorisationCode;
			$reutrn_array['ResponseCode']      = $response->ResponseCode;
		} 
		else 
		{
		    $return_array['error_codes'] = $response->Errors;
		}
		return $return_array;
	}

	public function refund_transaction($refund_array = array())
	{
		$return_array = array();
		$refund = [
		    'Refund' => [
				'TransactionID' => $refund_array['trans_id'],
				'TotalAmount'   => $refund_array['amount']
		    ],
		];

		$response = $this->client->refund($refund);
		if ($response->TransactionStatus)
		{
			$return_array['TransactionID']     = $response->TransactionID;
			$return_array['AuthorisationCode'] = $response->AuthorisationCode;
		} 
		else 
		{
		    if ($response->getErrors()) 
		    {
		        foreach ($response->getErrors() as $error) 
		        {
		            $return_array['error_codes'] .= \Eway\Rapid::getMessage($error) . ",";
		        }
		    }
		}
		return $return_array;
	}
}
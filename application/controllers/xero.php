<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('admin_main.php');
require_once("./application/libraries/xero/XeroOAuth.php");

class Xero extends Admin_main 
{
	private $minimal_array = [
		'Invoice' => [
			'Type' => 'ACCREC',
			'Contact' => [
				'Name' => 'Christian Burgos',
				'EmailAddress' => 'christian@qteme.com.au'
			],
			'Date' => '2017-05-28T00:00:00',
			'DueDate' => '2017-06-30T00:00:00',
			'CurrencyCode' => 'AUD',
			'Status' => 'AUTHORISED',
			'LineAmountTypes' => 'Inclusive',
			'LineItems' => [
				'LineItem' => [
					'Description' => 'Bike',
					'Quantity' => '1',
					'UnitAmount' => '5000',
					'AccountCode' => '200'
				]
			]
		]
	];

	private $complete_array =  [
		'Invoice' => [
			'Type' => 'ACCREC',
			'Contact' => [
				'ContactNumber' => '0006841301',
				'Name' => 'Christian Burgos',
				'ContactStatus' => 'ACTIVE',
				'EmailAddress' => 'christian@qteme.com.au',
				'SkypeUserName' => 'SKYPE',
				'BankAccountDetails' => 'Bank Account Details',
				'TaxNumber' => 'Tax Number',
				'AccountsReceivableTaxType' => 'OUTPUT',
				'AccountsPayableTaxType' => 'INPUT',
				'FirstName' => 'Christian',
				'LastName' => 'Burgos',
				'DefaultCurrency' => 'AUD',
				'Addresses' => [
					'Address' => [
						'AddressType' => 'STREET',
						'AttentionTo' => 'Christian B.',
						'AddressLine1' => 'Level 71',
						'AddressLine2' => '30 Rockefeller plaza',
						'AddressLine3' => '',
						'AddressLine4' => '',
						'City' => 'New York',
						'Region' => 'New York State',
						'PostalCode' => '10112',
						'Country' => 'USA',
					],
					'Address' => [
						'AddressType' => 'POBOX',
						'AttentionTo' => 'Christian B.',
						'AddressLine1' => 'PO Box 10112',
						'AddressLine2' => '',
						'AddressLine3' => '',
						'AddressLine4' => '',
						'City' => 'New York',
						'Region' => 'New York State',
						'PostalCode' => '10112',
						'Country' => 'USA',
					]
				],
				'Phones' => [
					'Phone' => [
						'PhoneType' => 'Mobile',
						'PhoneNumber' => '5555555',
						'PhoneAreaCode' => '02',
						'PhoneCountryCode' => '63'
					],
					'Phone' => [
						'PhoneType' => 'FAX',
						'PhoneNumber' => '5555555',
						'PhoneAreaCode' => '02',
						'PhoneCountryCode' => '63'
					]
				],
			],
			'Date' => '2017-05-28T00:00:00', //
			'DueDate' => '2017-06-30T00:00:00',
			'InvoiceNumber' => 'INV001',
			'Reference' => 'xxcc55',
			'CurrencyCode' => 'AUD',
			'Status' => 'AUTHORISED',
			'LineAmountTypes' => 'Inclusive',
			'SubTotal' => '10000.00',
			'TotalTax' => '20.00',
			'Url' => 'qteme.com.au',
			'BrandingThemeID' => '3b148ee0-adfa-442c-a98b-9059a73e8ef5',
			'LineItems' => [
				'LineItem' => [
					'Description' => 'Bike',
					'Quantity' => '1',
					'UnitAmount' => '5000',
					'TaxType' => '',
					'AccountCode' => '200'
				]
			]
		]
	];

	private $useragent;
	private $XeroOAuth;
	private $signatures = [];
	private $api_module;

	function __construct()
	{
		parent::__construct();

		define ("XRO_APP_TYPE", "Private");
		define ("OAUTH_CALLBACK", "oob");

		$this->useragent = "XeroOAuth-PHP Private App Test";

		$this->signatures = [
			'consumer_key'    => 'UDMVRIEO8A7RAFJ1UWIO19UISXRS4G',
			'shared_secret'   => 'MUMCDYQLYB870IIIACW3SCZZYVIH4P',
			'core_version'    => '2.0',
			'payroll_version' => '1.0',
			'file_version'    => '1.0' 
		];

		if (XRO_APP_TYPE == "Private" || XRO_APP_TYPE == "Partner") 
		{
			$this->signatures['rsa_private_key'] = FCPATH . 'assets/certificates/privatekey.pem';
			$this->signatures['rsa_public_key'] = FCPATH . 'assets/certificates/publickey.cer';
		}

		$this->XeroOAuth = new XeroOAuth (
			array_merge(
				array(
					'application_type' => XRO_APP_TYPE,
					'oauth_callback'   => OAUTH_CALLBACK,
					'user_agent'       => $this->useragent 
				), $this->signatures 
			) 
		);
	}

	public function index ()
	{
		$initialCheck = $this->XeroOAuth->diagnostics();

		$checkErrors = count($initialCheck);
		if ($checkErrors > 0) 
		{
			foreach ($initialCheck as $check)
			{
				echo 'Error: ' . $check . PHP_EOL;
			}
			die();
		}
		else 
		{
			$session = $this->persistSession ( array (
					'oauth_token'          => $this->XeroOAuth->config ['consumer_key'],
					'oauth_token_secret'   => $this->XeroOAuth->config ['shared_secret'],
					'oauth_session_handle' => '' 
			) );

			$oauthSession = $this->retrieveSession ();
			
			if (isset ( $oauthSession ['oauth_token'] )) 
			{
				$this->XeroOAuth->config['access_token']         = $oauthSession['oauth_token'];
				$this->XeroOAuth->config['access_token_secret']  = $oauthSession['oauth_token_secret'];
				$this->XeroOAuth->config['session_handle']       = $oauthSession['oauth_session_handle'];
				
				$response = $this->XeroOAuth->request('GET', $this->XeroOAuth->url('Invoices', 'core'), array(), "", "json");
				if  ($this->XeroOAuth->response['code'] == 200) {
					echo "Xero is Working!";           
		        } else {
		           $this->outputError($this->XeroOAuth);
		        }

			}
			
		}
	}

	public function invoice_values ($input_arr)
	{		
		$complete_array =  [
			'Invoice' => [
				'Type' => 'ACCREC',
				'Contact' => [
					'ContactNumber' => $input_arr['ContactNumber'],
					'Name' => $input_arr['Name'],
					'ContactStatus' => 'ACTIVE',
					'EmailAddress' => $input_arr['EmailAddress'],
					'FirstName' => '',
					'LastName' => '',
					'DefaultCurrency' => 'AUD',
					'Addresses' => [
						'Address' => [
							'AddressType' => 'STREET',
							'AttentionTo' => $input_arr['AttentionTo'],
							'AddressLine1' => $input_arr['AddressLine1'],
							'AddressLine2' => '',
							'AddressLine3' => '',
							'AddressLine4' => '',
							'City' => '',
							'Region' => $input_arr['Region'],
							'PostalCode' => $input_arr['PostalCode'],
							'Country' => 'Australia'
						]
					],
					'Phones' => [
						'Phone' => [
							'PhoneType' => 'MOBILE',
							'PhoneNumber' => $input_arr['MobileNumber']
						],
						'Phone' => [
							'PhoneType' => 'PHONE',
							'PhoneNumber' => $input_arr['PhoneNumber']
						]						
					]				
				],
				'Date' => $input_arr['Date'].'T00:00:00',
				'DueDate' => $input_arr['DueDate'].'T00:00:00',
				'Reference' => $input_arr['Reference'],
				'CurrencyCode' => 'AUD',
				'Status' => 'AUTHORISED',
				'LineAmountTypes' => 'Inclusive',
				'SubTotal' => $input_arr['SubTotal'],
				'TotalTax' => $input_arr['TotalTax'],
				'LineItems' => []
			]
		];

		if (isset($input_arr['InvoiceID']))
		{
			$complete_array['Invoice']['InvoiceID'] = $input_arr['InvoiceID'];
		}		
		
		$complete_array['Invoice']['LineItems'] = $input_arr['LineItems'];
		// var_dump($complete_array);
		// die ();
		return $this->transact("Invoices", "json", $complete_array, "POST");
	}
	
	public function transact ($api_module = "", $format = "json", $transaction_data = [], $method = "POST")
	{
		// $api_module = array('Invoices', 'Payments');
		// $format = array('json');
		// $transaction_data = array();
		// $method = "POST";
		// $xml_element = array('<Invoices></Invoices>', '<Payments></Payments>');
		
		if ($api_module == "Invoices")
		{
			$xml_element = "<Invoices></Invoices>";
		}
		else if ($api_module == "Payments")
		{
			$xml_element = "<Payments></Payments>";
		}

		$xml_data = new SimpleXMLElement($xml_element);
		$this->array_to_xml($transaction_data, $xml_data);
		$xml = $xml_data->asXML();
		
		$xml = str_replace('<item0>', '', $xml);
		$xml = str_replace('<item1>', '', $xml);
		$xml = str_replace('<item2>', '', $xml);
		$xml = str_replace('<item3>', '', $xml);
		$xml = str_replace('<item4>', '', $xml);
		$xml = str_replace('<item5>', '', $xml);
		$xml = str_replace('<item6>', '', $xml);
		$xml = str_replace('<item7>', '', $xml);
		$xml = str_replace('<item8>', '', $xml);
		$xml = str_replace('<item9>', '', $xml);
		
		$xml = str_replace('</item0>', '', $xml);
		$xml = str_replace('</item1>', '', $xml);
		$xml = str_replace('</item2>', '', $xml);
		$xml = str_replace('</item3>', '', $xml);
		$xml = str_replace('</item4>', '', $xml);
		$xml = str_replace('</item5>', '', $xml);
		$xml = str_replace('</item6>', '', $xml);
		$xml = str_replace('</item7>', '', $xml);
		$xml = str_replace('</item8>', '', $xml);
		$xml = str_replace('</item9>', '', $xml);		

		$initialCheck = $this->XeroOAuth->diagnostics();

		$checkErrors = count ( $initialCheck );
		if ($checkErrors > 0)
		{
			foreach ($initialCheck as $check)
			{
				echo 'Error: ' . $check . PHP_EOL;
			}
		} 
		else
		{
			$session = $this->persistSession(
				array(
					'oauth_token'          => $this->XeroOAuth->config ['consumer_key'],
					'oauth_token_secret'   => $this->XeroOAuth->config ['shared_secret'],
					'oauth_session_handle' => '' 
				)
			);

			$oauthSession = $this->retrieveSession();
			
			if (isset($oauthSession['oauth_token'])) 
			{
				$this->XeroOAuth->config['access_token']         = $oauthSession['oauth_token'];
				$this->XeroOAuth->config['access_token_secret']  = $oauthSession['oauth_token_secret'];
				$this->XeroOAuth->config['session_handle']       = $oauthSession['oauth_session_handle'];
				
				$response = $this->XeroOAuth->request($method, $this->XeroOAuth->url($api_module, 'core'), array(), $xml, $format);

				if ($this->XeroOAuth->response['code'] == 200)
				{
		            $response = $this->XeroOAuth->parseResponse($this->XeroOAuth->response['response'], $this->XeroOAuth->response['format']);
		            return $response;
		        }
				else 
				{
					return $this->outputError($this->XeroOAuth);
		        }
			}	
		}
	}

	public function add_invoice ($input_arr = [])
	{
		$xml_data = new SimpleXMLElement('<Invoices></Invoices>');

		$this->array_to_xml($this->array,$xml_data);

		$xml = $xml_data->asXML();

		$initialCheck = $this->XeroOAuth->diagnostics();

		$checkErrors = count ( $initialCheck );
		if ($checkErrors > 0) 
		{
			foreach ($initialCheck as $check) 
			{
				echo 'Error: ' . $check . PHP_EOL;
			}
			die();
		} 
		else
		{
			$session = $this->persistSession ( array (
					'oauth_token'          => $this->XeroOAuth->config ['consumer_key'],
					'oauth_token_secret'   => $this->XeroOAuth->config ['shared_secret'],
					'oauth_session_handle' => '' 
			) );

			$oauthSession = $this->retrieveSession ();
			
			if (isset($oauthSession['oauth_token']))
			{
				$this->XeroOAuth->config['access_token']         = $oauthSession['oauth_token'];
				$this->XeroOAuth->config['access_token_secret']  = $oauthSession['oauth_token_secret'];
				$this->XeroOAuth->config['session_handle']       = $oauthSession['oauth_session_handle'];
				
				$response = $this->XeroOAuth->request('POST', $this->XeroOAuth->url('Invoices', 'core'), array(), $xml, "xml");
				if  ($this->XeroOAuth->response['code'] == 200)
				{
		            $response = $this->XeroOAuth->parseResponse($this->XeroOAuth->response['response'], $this->XeroOAuth->response['format']);
		            var_dump($response);
		        }
				else 
				{
		           $this->outputError($this->XeroOAuth);
		        }
			}
		}
	}

	public function receive_payments ($input_arr = [])
	{
		$input_arr = [
			'Payment' => [
				'Invoice' => [
					'InvoiceID'     => '6983a03d-6435-4864-9724-5aea8636fc29',
					'InvoiceNumber' => 'ORC1050'
				],
				'Account' => [
					'AccountID' => '13918178-849a-4823-9a31-57b7eac713d7',
					'Code'      => '001'
				],
				'Date'         => '2017-05-31T00:00:00',
				'Reference'    => 'CHQ0009238',
				'CurrencyRate' => '1',
				'Amount'       => '1000'
			]
		];

		$xml_data = new SimpleXMLElement('<Payments></Payments>');

		$this->array_to_xml($input_arr,$xml_data);

		$xml = $xml_data->asXML();

		$initialCheck = $this->XeroOAuth->diagnostics();

		$checkErrors = count ( $initialCheck );
		if ($checkErrors > 0) {
			// you could handle any config errors here, or keep on truckin if you like to live dangerously
			foreach ( $initialCheck as $check ) {
				echo 'Error: ' . $check . PHP_EOL;
			}
			die();
		} else {
			$session = $this->persistSession ( array (
					'oauth_token'          => $this->XeroOAuth->config ['consumer_key'],
					'oauth_token_secret'   => $this->XeroOAuth->config ['shared_secret'],
					'oauth_session_handle' => '' 
			) );

			$oauthSession = $this->retrieveSession ();
			
			if (isset ( $oauthSession ['oauth_token'] )) {
				$this->XeroOAuth->config ['access_token']        = $oauthSession ['oauth_token'];
				$this->XeroOAuth->config ['access_token_secret'] = $oauthSession ['oauth_token_secret'];
				
				$this->XeroOAuth->config['access_token']         = $oauthSession['oauth_token'];
				$this->XeroOAuth->config['access_token_secret']  = $oauthSession['oauth_token_secret'];
				$this->XeroOAuth->config['session_handle']       = $oauthSession['oauth_session_handle'];
				
				$response = $this->XeroOAuth->request('PUT', $this->XeroOAuth->url('Payments', 'core'), array(), $xml, "xml");
				if  ($this->XeroOAuth->response['code'] == 200) {
		            $response = $this->XeroOAuth->parseResponse($this->XeroOAuth->response['response'], $this->XeroOAuth->response['format']);

		            var_dump($response);
		            
		        } else {
		           $this->outputError($this->XeroOAuth);
		        }

			}
			
		}
	}

	public function get_invoice ($invoice_id = "")
	{

	}

	public function get_invoices ($params = [])
	{
		$initialCheck = $this->XeroOAuth->diagnostics();

		$checkErrors = count ( $initialCheck );
		if ($checkErrors > 0) {
			// you could handle any config errors here, or keep on truckin if you like to live dangerously
			foreach ( $initialCheck as $check ) {
				echo 'Error: ' . $check . PHP_EOL;
			}
			die();
		} else {
			$session = $this->persistSession ( array (
					'oauth_token'          => $this->XeroOAuth->config ['consumer_key'],
					'oauth_token_secret'   => $this->XeroOAuth->config ['shared_secret'],
					'oauth_session_handle' => '' 
			) );

			$oauthSession = $this->retrieveSession ();
			
			if (isset ( $oauthSession ['oauth_token'] )) {
				$this->XeroOAuth->config ['access_token']        = $oauthSession ['oauth_token'];
				$this->XeroOAuth->config ['access_token_secret'] = $oauthSession ['oauth_token_secret'];
				
				$this->XeroOAuth->config['access_token']         = $oauthSession['oauth_token'];
				$this->XeroOAuth->config['access_token_secret']  = $oauthSession['oauth_token_secret'];
				$this->XeroOAuth->config['session_handle']       = $oauthSession['oauth_session_handle'];
				
				$response = $this->XeroOAuth->request('GET', $this->XeroOAuth->url('Invoices', 'core'), array(), "", "json");
				if  ($this->XeroOAuth->response['code'] == 200) {
		            $response = $this->XeroOAuth->parseResponse($this->XeroOAuth->response['response'], $this->XeroOAuth->response['format']);
					// echo "hello!";
		            var_dump($response);
		            
		        } else {
		           $this->outputError($this->XeroOAuth);
		        }

			}
			
		}
	}

	public function get_contact ($contact_name = "")
	{

	}

	public function get_contacts ($params = [])
	{

	}

	public function add_contact ($input_arr = [])
	{

	}

	private function array_to_xml ( $data, &$xml_data ) 
	{
		foreach( $data as $key => $value ) 
		{
			if( is_numeric($key) ){
				$key = 'item'.$key; //dealing with <0/>..<n/> issues
			}
			if( is_array($value) ) {
				$subnode = $xml_data->addChild($key);
				$this->array_to_xml($value, $subnode);
			} else {
				$xml_data->addChild("$key",htmlspecialchars("$value"));
			}
		}
	}

	/**
	 * Persist the OAuth access token and session handle somewhere
	 * In my example I am just using the session, but in real world, this is should be a storage engine
	 *
	 * @param array $params the response parameters as an array of key=value pairs
	 */
	private function persistSession ($response)
	{
	    if (isset($response)) {
	        $_SESSION['access_token']       = $response['oauth_token'];
	        $_SESSION['oauth_token_secret'] = $response['oauth_token_secret'];
	      	if(isset($response['oauth_session_handle']))  $_SESSION['session_handle']     = $response['oauth_session_handle'];
	    } else {
	        return false;
	    }

	}

	/**
	 * Retrieve the OAuth access token and session handle
	 * In my example I am just using the session, but in real world, this is should be a storage engine
	 */
	private function retrieveSession ()
	{
	    if (isset($_SESSION['access_token'])) {
	        $response['oauth_token']            =    $_SESSION['access_token'];
	        $response['oauth_token_secret']     =    $_SESSION['oauth_token_secret'];
	        $response['oauth_session_handle']   =    $_SESSION['session_handle'];
	        return $response;
	    } else {
	        return false;
	    }

	}

	private function outputError ($XeroOAuth)
	{
	    echo 'Error: ' . $XeroOAuth->response['response'] . PHP_EOL;
	    $this->pr($XeroOAuth);
	}

	/**
	 * Debug function for printing the content of an object
	 *
	 * @param mixes $obj
	 */
	private function pr ($obj)
	{
	    if (!$this->is_cli())
	        echo '<pre style="word-wrap: break-word">';
	    if (is_object($obj))
	        print_r($obj);
	    elseif (is_array($obj))
	        print_r($obj);
	    else
	        echo $obj;
	    if (!$this->is_cli())
	        echo '</pre>';
	}

	private function is_cli ()
	{
	    return (PHP_SAPI == 'cli' && empty($_SERVER['REMOTE_ADDR']));
	}
}
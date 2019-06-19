<?php

session_start();
include_once "templates/base.php";

/************************************************
  Make an API request authenticated with a service
  account.
 ************************************************/
require_once realpath(dirname(__FILE__) . '/../autoload.php');

/************************************************
 ************************************************/

// MY ACCOUNT DATA HERE
$client_id = 'xxx';
$service_account_name = 'xxx'; //Email Address 
$key_file_location = 'xxx.p12'; //key.p12
$groupKey = 'xxx';

echo pageHeader("My Service Account Access");
if ($client_id == '<YOUR_CLIENT_ID>'
    || !strlen($service_account_name)
    || !strlen($key_file_location)) {
  echo missingServiceAccountDetailsWarning();
}

$client = new Google_Client();
$client->setApplicationName("Client_Library_Examples");
//$service = new Google_Service_Books($client); //ORIGINAL
$service = new Google_Service_Directory($client);

/************************************************
 ************************************************/
if (isset($_SESSION['service_token'])) {
  $client->setAccessToken($_SESSION['service_token']);
}
$authArray = array(
                'https://www.googleapis.com/auth/admin.directory.group',
                'https://www.googleapis.com/auth/admin.directory.group.readonly',
                'https://www.googleapis.com/auth/admin.directory.group.member',
                'https://www.googleapis.com/auth/admin.directory.group.member.readonly'
);
$key = file_get_contents($key_file_location);
$cred = new Google_Auth_AssertionCredentials(
    $service_account_name,
    $authArray, //array('https://www.googleapis.com/auth/books'), //ORIGINAL
    $key
);
$client->setAssertionCredentials($cred);
if($client->getAuth()->isAccessTokenExpired()) {
  $client->getAuth()->refreshTokenWithAssertion($cred);
}
$_SESSION['service_token'] = $client->getAccessToken();


/************************************************
 ************************************************/
//$optParams = array('filter' => 'free-ebooks'); //ORIGINAL
$optParams = array('fields' => 'id');
//$results = $service->volumes->listVolumes('Henry David Thoreau', $optParams); //ORIGINAL
$results = $service->groups->get($groupKey, $optParams);
echo "<h3>Results Of Call:</h3>";
foreach ($results as $item) {
  //echo $item['volumeInfo']['title'], "<br /> \n"; //ORIGINAL
    echo "<pre>".print_r ($item, true)."</pre>";
}

echo pageFooter(__FILE__);
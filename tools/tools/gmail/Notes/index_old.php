<?php
require_once __DIR__.'/vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setAuthConfig('client_secrets.json');
// $client->addScope(Google_Service_Directory::ADMIN_DIRECTORY_USER);
$client->addScope(Google_Service_Gmail::GMAIL_READONLY);

// $_SESSION['access_token'] = array(
	// 'access_token' => 'ya29.GlsCBNRidr1SEz27w1JNZoYGRFdnxev35k7-7ZK_RMsKeXSZLus_rRaxAro7HU3DapN_DB49nByhqVqk-SJUNPKAkikcRoIj70e1dgH987iq1_65z6a3jz71FNt4',
	// 'token_type' => 'Bearer',
	// 'expires_in' => 3600, 
	// 'created' => strtotime("now")
// );

// $_SESSION['access_token'] = array(
	// 'access_token' => 'ya29.GlsCBAYRAGoqCcFD8tJNQFQmIMbgYlMzY3ZBaVCnx-Kdev0sdh4whRtYuPsTF3VViqSbOImlS9xlbnk1SJHiVKKxTEfFroKjXPoJjuWY12Vv2FPT9NVgUxUxxCQL', 
	// 'token_type' => 'Bearer',
	// 'expires_in' => 3600,
	// 'created' => strtotime("now")
// );

if (isset($_SESSION['access_token']) && $_SESSION['access_token'])
{
	
	// print_r( $_SESSION['access_token'] );
	
	// exit();
	
	$client->setAccessToken($_SESSION['access_token']);
	
	// $client->domain = 'qteme.com.au';
	
	// $mail = new Google_Service_Directory($client);

	// $results = $mail->users()->list( 'users', 'GET', array('domain' => 'qteme.com.au', 'maxResults' => '500') );
	// $results = $mail;
	
	// $password = crypt ( "Password", $salt="IamSecretkey" );

	// $userObj = new Google_Service_Directory_User(
	
		// array(
		
			// 'password' =>  $password
		
		// )
	
	// );
	
	// try {
		
		// $results = $mail->users->update("eleazar@qteme.com.au", $userObj );
	
	// }
	// catch(Error $ex) {
		
		// print_r($ex->getMessage());
	
	// }
	
	// echo'<pre>';
	// print_r( $results );
	// exit();
	
	// Print the labels in the user's account.
	
	$service = new Google_Service_Gmail($client);
	
	$user = 'me';
	$results = $service->users_labels->listUsersLabels($user);
	
	if (count($results->getLabels()) == 0)
	{
		print "No labels found.\n";
	}
	else
	{
		print "Labels:<br>";
		foreach ($results->getLabels() as $label)
		{
			printf("- %s<br>", $label->getName());
		}
	}
	
	// $files = $drive->files->listFiles(array())->getFiles();
	// echo json_encode($files);
}
else
{
	$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/gsuite/oauth2callback.php';
	header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
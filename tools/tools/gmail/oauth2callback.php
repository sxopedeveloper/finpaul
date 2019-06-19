<?php
$db = mysqli_connect("127.0.0.1", "root", "", "mycarquo_master");
// $db = mysqli_connect( "109.73.228.248", "mycarquo_master", "McQ@yoU0854", "mycarquo_master" );

require_once __DIR__.'/gmail/autoload.php';

session_start();

$client = new Google_Client();
$client->setApplicationName('QuoteMe Email App');
$client->setAuthConfigFile('client_secrets.json');
$client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/gsuite/oauth2callback.php');
define('SCOPES', 
	implode(' ', 
		array(
			Google_Service_Gmail::MAIL_GOOGLE_COM,
			Google_Service_Gmail::GMAIL_COMPOSE,
			Google_Service_Gmail::GMAIL_MODIFY,
			Google_Service_Gmail::GMAIL_SEND,
			// Google_Service_Drive::DRIVE,
			// Google_Service_Drive::DRIVE_FILE
		)
	)
);
$client->setScopes(SCOPES);
$client->setAccessType('offline');
$client->setApprovalPrompt('force');

if (! isset($_GET['code']))
{
	$auth_url = $client->createAuthUrl();
	header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
}
else
{
	$authCode = $_GET['code'];
	$token = json_encode( $client->fetchAccessTokenWithAuthCode(urldecode($authCode)) );

	mysqli_query($db,"INSERT INTO gmail_tokens( token,type ) VALUES('$token','original')");
	
	$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/gsuite/index.php';
	
	header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
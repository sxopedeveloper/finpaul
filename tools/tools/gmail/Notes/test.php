<?php
require_once __DIR__.'/vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setAuthConfig('client_secrets.json');
$client->addScope(Google_Service_Gmail::GMAIL_READONLY);

if (isset($_SESSION['access_token']) && $_SESSION['access_token'])
{
	
	$client->setAccessToken($_SESSION['access_token']);

	$service = new Google_Service_Gmail($client);
	
	$user = 'me';
	
	
	
	/*
	// This is the get LABELs function: comment out muna
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
			printf( "- <a href='#' id='%s'>%s</a><br>", $label->getName(), $label->getName() );
		}
	}
	*/
}
else
{
	$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/gsuite/oauth2callback.php';
	header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
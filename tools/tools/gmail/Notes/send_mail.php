<?php
include 'database.php';

$query = mysqli_query( $db, "SELECT * FROM tokens WHERE type='original'" );
if( mysqli_num_rows($query) != 0 )
{
    $tokenrow = mysqli_fetch_array($query);
    extract($tokenrow);
}
else
{
	$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/gsuite/oauth2callback.php';
	header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}

$time_created = json_decode($token)->created;
$t = time();
$timediff = $t - $time_created;
$refreshToken = json_decode($token)->refresh_token;

require_once __DIR__.'/gmail/autoload.php';

session_start();

$client = new Google_Client();
$client->setApplicationName('QuoteMe Email App');
$client->setAuthConfig('client_secrets.json');
$client->addScope(
	Google_Service_Gmail::GMAIL_READONLY, 
	Google_Service_Gmail::MAIL_GOOGLE_COM,
	Google_Service_Gmail::GMAIL_COMPOSE,
	Google_Service_Gmail::GMAIL_MODIFY
);

$client->setAccessType('offline');
$client->setApprovalPrompt('force');

if(( $timediff > 3600 )&&( $token!='' ))
{
	$client->setAccessToken($token);

	// messageList($client);
	mail_sender($client);
}
else
{
    $query = mysqli_query( $db, "SELECT * FROM tokens WHERE type='refresh'" );
    if( mysqli_num_rows($query) != 0 )
    {
        $refreshrow = mysqli_fetch_array($query);
        extract( $refreshrow );
        $refresh_created = json_decode($token)->created;
        $refreshtimediff = $t - $refresh_created;
        
        if($refreshtimediff>3600)
        {
            $client->refreshToken($refreshToken);
			$newtoken = json_encode( $client->getAccessToken() );
			
			mysqli_query( $db, "UPDATE tokens SET token='$newtoken' WHERE type='refresh'" );
			$token = $newtoken;
        }
        else
        {
			$client->setAccessToken($token);
        }
		
		// messageList($client);
		mail_sender($client);
	}
    else
    {
        $client->refreshToken($refreshToken);
        $newtoken = $client->getAccessToken();
		
        mysqli_query( $db, "INSERT INTO tokens( token,type ) VALUES('$token','refresh')" );
        $token = $newtoken;
		
		// messageList($client);
		mail_sender($client);
	}
	
}

function mail_sender($client)
{
	$objGMail = new Google_Service_Gmail($client);
     
    $subjectCharset = $charset = 'utf-8';
    $strToMailName = 'Elly Padilla';
    $strToMail = 'silver.fangz13@gmail.com';
    $strSesFromName = 'abswebdevgroup';
    $strSesFromEmail = 'abswebdevgroup@gmail.com';
    $strSubject = 'Test mail using GMail API' . date('M d, Y h:i:s A');
 
    $strRawMessage .= 'To: ' . encodeRecipients($strToMailName . " <" . $strToMail . ">") . "\r\n";
    $strRawMessage .= 'From: '. encodeRecipients($strSesFromName . " <" . $strSesFromEmail . ">") . "\r\n";
 
    $strRawMessage .= 'Subject: =?' . $subjectCharset . '?B?' . base64_encode($strSubject) . "?=\r\n";
    $strRawMessage .= 'MIME-Version: 1.0' . "\r\n";
    $strRawMessage .= 'Content-type: Multipart/Alternative; boundary="' . $boundary . '"' . "\r\n";
 
    $strRawMessage .= "\r\n--{$boundary}\r\n";
    $strRawMessage .= 'Content-Type: text/plain; charset=' . $charset . "\r\n";
    $strRawMessage .= 'Content-Transfer-Encoding: 7bit' . "\r\n\r\n";
    $strRawMessage .= "this is a test!" . "\r\n";
 
    $strRawMessage .= "--{$boundary}\r\n";
    $strRawMessage .= 'Content-Type: text/html; charset=' . $charset . "\r\n";
    $strRawMessage .= 'Content-Transfer-Encoding: quoted-printable' . "\r\n\r\n";
    $strRawMessage .= "this is a tes2t!" . "\r\n";
	
	//Send Mails
    //Prepare the message in message/rfc822
    try {
        // The message needs to be encoded in Base64URL
        $mime = rtrim(strtr(base64_encode($strRawMessage), '+/', '-_'), '=');
        $msg = new Google_Service_Gmail_Message();
        $msg->setRaw($mime);
        $objSentMsg = $objGMail->users_messages->send("me", $msg);
 
        print('Message sent object');
        print($objSentMsg);
 
    }
	catch (Exception $e)
	{
        print($e->getMessage());
    }
}
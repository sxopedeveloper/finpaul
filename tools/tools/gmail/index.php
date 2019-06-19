<?php
include 'database.php';

/*
	PHP Mailer Class
	Used in extracting the standard email format ( header, body, and other mail parts )
*/
require 'PHPMailer/PHPMailerAutoload.php';

// get the stored tokens from db
$query = mysqli_query( $db, "SELECT * FROM gmail_tokens WHERE type='original'" );
if( mysqli_num_rows($query) != 0 )
{
    $tokenrow = mysqli_fetch_array($query);
    extract($tokenrow);
}
else
{
	// auth URL
	$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/gsuite/oauth2callback.php';
	header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}

// variables used in the Get Email Functions
$time_created = json_decode($token)->created;
$t = time();
$timediff = $t - $time_created;
$refreshToken = json_decode($token)->refresh_token;

require_once __DIR__.'/gmail/autoload.php';

session_start();

// Initiate the Google Client
$client = new Google_Client();
$client->setApplicationName('QuoteMe Email App');
$client->setAuthConfig('client_secrets.json');

/*
	Use SCOPES
	overwrite the scopes depending on the service being used
	Note: you will also have to change the scopes on the oauth2callback.php
*/
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

if(( $timediff > 3600 )&&( $token!='' ))
{
	$client->setAccessToken($token);

	messageList($client); // get message function
	// mail_sender($client); // send email snippets
}
else
{
    $query = mysqli_query( $db, "SELECT * FROM gmail_tokens WHERE type='refresh'" );
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
			
			mysqli_query( $db, "UPDATE gmail_tokens SET token='$newtoken' WHERE type='refresh'" );
			$token = $newtoken;
        }
        else
        {
			$client->setAccessToken($token);
        }
		
		messageList($client); // get message function
		// mail_sender($client); // send email snippets
	}
    else
    {
        $client->refreshToken($refreshToken);
        $newtoken = $client->getAccessToken();
		
        mysqli_query( $db, "INSERT INTO gmail_tokens( token,type ) VALUES('$token','refresh')" );
        $token = $newtoken;
		
		messageList($client); // get message function
		// mail_sender($client); // send email snippets
	}
}

function messageList($client)
{
	$mysqli = new mysqli( "127.0.0.1", "root", "", "mycarquo_master" );
	// $mysqli = new mysqli( "109.73.228.248", "mycarquo_master", "McQ@yoU0854", "mycarquo_master" );
	
	$service = new Google_Service_Gmail($client);
	$user = 'me';
	
	$params = array(
		// 'labelIds' => 'INBOX', 
		'maxResults' => 20000
	);
	
	$query = mysqli_query( $mysqli, "SELECT MAX(received_date) as latest FROM `emails`" );
	
	$last_date = mysqli_fetch_array($query);
	extract($last_date);
	
	if(isset($latest))
	{
		$date = date_create($latest);
		$date->modify('-1 day');
		$filter_date = date_format($date, 'Y/m/d');
		$params['q'] = 'in:inbox after:'.$filter_date ;
	}
	
	// echo '<pre>';
	// var_dump($params); die();
	
	// q="in:sent after:2014/01/01 before:2014/01/30"
	$messages = $service->users_messages->listUsersMessages( $user, $params );
	$list = $messages->getMessages();
	
	// Sort: reverse order
	// usort($list, "cmp");
	
	foreach ($list as $msg)
	{
		$message = $service->users_messages->get( $user, $msg->getId(), array( 'format' => 'full') );
		
		$headers = $message->getPayload()->getHeaders();
		
		$message_id = $msg->getId();
		
		$subject = getHeader($headers, 'Subject');
		$subject = $mysqli->real_escape_string( $subject );
		
		$recipient = getHeader($headers, 'To');
		$to = getHeader($headers, 'To');
		$recipient_email = substr_function( $to, strpos( $to, '<' ) + 1, strpos( $to, '>' ) );
		$recipient_name = substr_function($to, 0, strpos( $to, '<' ) - 1);
		
		$sender = getHeader($headers, 'From');
		$from = getHeader($headers, 'From');
		$sender_email = substr_function( $from, strpos( $from, '<' ) + 1, strpos( $from, '>' ) );
		$sender_name = substr_function($from, 0, strpos( $from, '<' ) - 1);
		
		$date = getHeader($headers, 'Date');
		
		$user_agent = getHeader($headers, 'User-Agent');
		$mime_version = getHeader($headers, 'Mime-Version');
		$content_type = getHeader($headers, 'Content-Type');
		$originating_ip = getHeader($headers, 'X-Originating-IP');
		
		$received_date = date( 'Y-m-d H:i:s', strtotime($date) );
		
		$parts = $message->getPayload()->getParts();
		
		// Thread ID:
		$email = $service->users_messages->get($user, $msg->getId());
		
		$content = '';
		if( isset($parts[0]) )
		{
			$body = $parts[0]['body'];
			$rawData = $body->data;
			$sanitizedData = strtr($rawData,'-_', '+/');
			$content = base64_decode($sanitizedData);
			$content = $mysqli->real_escape_string( $content );
		}
		
		$recipient = $mysqli->real_escape_string($recipient);
		$recipient_name = $mysqli->real_escape_string($recipient_name);
		$recipient_email = $mysqli->real_escape_string($recipient_email);
		
		$sender = $mysqli->real_escape_string($sender);
		$sender_name = $mysqli->real_escape_string($sender_name);
		$sender_email = $mysqli->real_escape_string($sender_email);
		
		$data = array(
			'sender' => "'".$sender."'",
			'sender_name' => "'".$sender_name."'",
			'sender_email' => "'".$sender_email."'",
			
			'recipient' => "'".$recipient."'",
			'recipient_name' => "'".$recipient_name."'",
			'recipient_email' => "SUBSTRING_INDEX(SUBSTRING_INDEX('".$to."', '<', -1), '>', 1)",
			
			'gmail_id' => "'".$message_id."'",
			'thread_id' => "'".$email['threadId']."'",
			'received_date' => "'".$received_date."'",
			'subject' => "'".$subject."'",
			'content' => "'".$content."'",
			'created_at' => "'".date("Y-m-d H:i:s")."'",
			'user_agent' => "'".$user_agent."'",
			'mime_version' => "'".$mime_version."'",
			'content_type' => "'".$content_type."'",
			'originating_ip' => "'".$originating_ip."'"
		);
		
		$insert_id = 0;
		
		$db = insert_db( $data, 'emails' );
		
		$insert_id = (isset($db['insert_id'])) ? $db['insert_id'] : $insert_id;
		
		if( $db['result'] == 'error')
		{
			die( $db['message'] );
		}
		
		foreach( $parts as $key => $value )
		{
			if( $insert_id == 0 ) exit();
			
			if( strlen( $value['filename'] ) > 0 )
			{
				$attachment_id = $parts[$key]->body->attachmentId;
				$size = $parts[$key]->body->size;
				
				$attachmentData = $service->users_messages_attachments->get( $user, $msg->getId(), $attachment_id );

				$messageDetails = $message->getPayload();
				
				foreach ($messageDetails['parts'][$value['partId']]['headers'] as $item)
				{
					$attachmentHeaders[$item->name] = $item->value;
				}
				
				$content_type = ( isset($attachmentHeaders['Content-type']) ) ? $attachmentHeaders['Content-type'] : "";
				$content_type = $mysqli->real_escape_string($content_type);
				
				$content_disposition = ( isset($attachmentHeaders['Content-Disposition']) ) ? $attachmentHeaders['Content-Disposition'] : "";
				$content_disposition = $mysqli->real_escape_string($content_disposition);
				
				$content_encoding = ( isset($attachmentHeaders['Content-Transfer-Encoding']) ) ? $attachmentHeaders['Content-Transfer-Encoding'] : "";
				$content_encoding = $mysqli->real_escape_string($content_encoding);
				
				$filename = $mysqli->real_escape_string($value['filename']);
				
				$data = array(
					'fk_email' => "'".$insert_id."'",
					'gmail_id' => "'".$message_id."'",
					'gmail_attachment_id' => "'".$attachment_id."'",
					'filename' => "'".$filename."'",
					'size' => "'".$size."'",
					'content_type' => "'".$content_type."'",
					'content_disposition' => "'".$content_disposition."'",
					'content_encoding' => "'".$content_encoding."'",
					'created_at' => "'".date("Y-m-d H:i:s")."'"
				);
				
				$db = insert_db( $data, 'email_attachments' );
		
				if( $db['result'] == 'error')
				{
					die( $db['message'] );
				}
			}
		}
	}
}


function mail_sender($client)
{
	// $service = new Google_Service($client);
	$service = new Google_Service_Drive($client);

	/*
	// Upload attachment on the Google Drive
	// DRIVE_FILE
	// $fileMetadata = new Google_Service_Drive_DriveFile(
		// array(
			// 'title' => 'photo.jpg'
		// )
	// );
	// $content = file_get_contents('photo.jpg');
	// $file = $driveService->files->insert( $fileMetadata,
		// array(
			// 'data' => $content,
			// 'mimeType' => 'image/jpeg',
			// 'uploadType' => 'multipart',
			// 'fields' => 'id'
		// )
	// );
	// printf("File ID: %s\n", $file->id);
	*/
	
	$filename = 'photo.jpg';
	
	$file = new Google_Service_Drive_DriveFile();
	$file->setName($filename);
	
	$mimeType = mime_content_type($filename);
	
	$file->setMimeType($mimeType);

	// Set the parent folder.
	if (isset($parentId))
	{
		$parent = new Google_Service_Drive_ParentReference();
		$parent->setId($parentId);
		$file->setParents(array($parent));
	}

	try
	{
		$data = file_get_contents('photo.jpg');

		$createdFile = $service->files->create($file, array(
		'data' => $data,
		'mimeType' => $mimeType,
		));

		// echo '<pre>';
		// var_dump($createdFile);
	}
	catch (Exception $e)
	{
		print "An error occurred: " . $e->getMessage();
	}
	
	/*
	// this is the original send email function snippets
	
	$service = new Google_Service_Gmail($client);
	
	$subject = "Gmail API Test";
	$msg = "Hey! This is a test message sent using gmail api.";
	
	$from = "eleazar@qteme.com.au";
	$fname = "Elly Padilla";
	
	$mail = new PHPMailer();
	$mail->CharSet = "UTF-8";
	$mail->From = $from;
	$mail->FromName = $fname;
	$mail->AddAddress("silver.fangz13@gmail.com");
	$mail->AddReplyTo($from,$fname);
	$mail->Subject = $subject;
	$mail->Body    = $msg;
	$mail->preSend();
	
    try
	{
		$mime = $mail->getSentMIMEMessage();
		$m = new Google_Service_Gmail_Message();
		$data = base64_encode($mime);
		$data = str_replace(array('+','/','='),array('-','_',''),$data); // url safe
		$m->setRaw($data);
		
		// when sending a reply:
		$threadId = '15ad5ea86de2a31d';
		
		$m->setThreadId($threadId);
		
		$objSentMsg = $service->users_messages->send('me', $m);
		
        print('Message sent object');
        echo '<pre>';
		var_dump($objSentMsg);
 
    }
	catch (Exception $e)
	{
        print($e->getMessage());
    }
	*/
}

//
function encodeRecipients($recipient){
    $recipientsCharset = 'utf-8';
    if (preg_match("/(.*)<(.*)>/", $recipient, $regs)) {
        $recipient = '=?' . $recipientsCharset . '?B?'.base64_encode($regs[1]).'?= <'.$regs[2].'>';
    }
    return $recipient;
}

// Download Attachment Function
// This function will accept 4 parameters:
// client, filename, messageId, attachmentId
function download_attachment( $client, $filename, $messageId, $attachmentId )
{
	$service = new Google_Service_Gmail($client);
	
	$data = $service->users_messages_attachments->get('me', $messageId, $attachmentId);

	try
	{
		$data = strtr($data->data, array('-' => '+', '_' => '/'));

		$fh = fopen( $filename, "w+" );
		fwrite( $fh, base64_decode($data) );
		fclose( $fh );
		
		header('Content-Type: application/octet-stream');
		header("Content-Transfer-Encoding: Binary"); 
		header("Content-disposition: attachment; filename=\"" . basename($filename) . "\""); 
		readfile($filename);
	}
	catch (Exception $e)
	{
		print "An error occurred: " . $e->getMessage();
	}
}

/*
// Sort Order
function cmp($a, $b)
{
    return ( $a->getId() < $b->getId() ) ? -1 : 1;
}
*/

// Get Header Function
function getHeader($headers, $name)
{
	foreach($headers as $header)
	{
		if($header['name'] == $name)
		{
			return $header['value'];
		}
	}
}

// source_string, start_index, end_index
function substr_function($str, $start, $end)
{
  return substr($str, $start, $end - $start);
}
?>
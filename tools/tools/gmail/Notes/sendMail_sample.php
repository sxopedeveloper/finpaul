<?php
 
session_start();
 
  require_once 'Google/autoload.php'; // or wherever autoload.php is located
 
    $client = new Google_Client();
    $client->setClientId("x-x.apps.googleusercontent.com");
    $client->setClientSecret("xyxyxyxyxy");
    $client->setRedirectUri("https://x.com/pipis2/");
    $client->setAccessType('offline');
    $client->setApprovalPrompt('force');
 
    $client->addScope("https://mail.google.com/");
    $client->addScope("https://www.googleapis.com/auth/gmail.compose");
    $client->addScope("https://www.googleapis.com/auth/gmail.modify");
    $client->addScope("https://www.googleapis.com/auth/gmail.readonly");
 
 
if (isset($_REQUEST['code'])) {
    //land when user authenticated
    $code = $_REQUEST['code'];
    $client->authenticate($code);
     
    $_SESSION['gmail_access_token'] = $client->getAccessToken();
     
    header("Location: https://x.com/pipis2/");
}
 
//$isAccessCodeExpired = $client->isAccessTokenExpired();
 
 
//if (isset($_SESSION['gmail_access_token']) &amp;&amp; !empty($_SESSION['gmail_access_token']) &amp;&amp; $isAccessCodeExpired != 1) {
if (isset($_SESSION['gmail_access_token'])) {
    //gmail_access_token setted;
     
    $boundary = uniqid(rand(), true);
 
    $client->setAccessToken($_SESSION['gmail_access_token']);            
    $objGMail = new Google_Service_Gmail($client);
     
    $subjectCharset = $charset = 'utf-8';
    $strToMailName = 'To User Name';
    $strToMail = 'yourmail@yourmail@93.com';
    $strSesFromName = 'From User Name';
    $strSesFromEmail = 'yourmail@yourmail@93.com';
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
 
    } catch (Exception $e) {
        print($e->getMessage());
        unset($_SESSION['gmail_access_token']);
    }
}
else {
    // Failed Authentication
    if (isset($_REQUEST['error'])) {
        //header('Location: ./index.php?error_code=1');
        echo "error auth";
    }
    else{
        // Redirects to google for User Authentication
        $authUrl = $client->createAuthUrl();
        header("Location: $authUrl");
    }
}
 
function encodeRecipients($recipient){
    $recipientsCharset = 'utf-8';
    if (preg_match("/(.*)<(.*)>/", $recipient, $regs)) {
        $recipient = '=?' . $recipientsCharset . '?B?'.base64_encode($regs[1]).'?= <'.$regs&#91;2&#93;.'>';
    }
    return $recipient;
}
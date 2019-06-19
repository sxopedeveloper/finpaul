<?php
//pull token from database
$tokenquery="SELECT * FROM token WHERE type='original'";
$tokenresult = mysqli_query($cxn,$tokenquery);
if($tokenresult!=0)
{
    $tokenrow=mysqli_fetch_array($tokenresult);
    extract($tokenrow);
}
$time_created = json_decode($token)->created;
$t=time();
$timediff=$t-$time_created;
echo $timediff."<br>";
$refreshToken= json_decode($token)->refresh_token;

//start google client note:
$client = new Google_Client();
$client->setApplicationName('');
$client->setScopes(array());
$client->setClientId('');
$client->setClientSecret('');
$client->setRedirectUri('');
$client->setAccessType('offline');
$client->setDeveloperKey('');

//resets token if expired
if(($timediff>3600)&&($token!=''))
{
    echo $refreshToken."</br>";
    $refreshquery="SELECT * FROM token WHERE type='refresh'";
    $refreshresult = mysqli_query($cxn,$refreshquery);
    //if a refresh token is in there...
    if($refreshresult!=0)
    {
        $refreshrow=mysqli_fetch_array($refreshresult);
        extract($refreshrow);
        $refresh_created = json_decode($token)->created;
        $refreshtimediff=$t-$refresh_created;
        echo "Refresh Time Diff: ".$refreshtimediff."</br>";
        //if refresh token is expired
        if($refreshtimediff>3600)
        {
            $client->refreshToken($refreshToken);
			$newtoken=$client->getAccessToken();
			echo $newtoken."</br>";
			$tokenupdate="UPDATE token SET token='$newtoken' WHERE type='refresh'";
			mysqli_query($cxn,$tokenupdate);
			$token=$newtoken;
			echo "refreshed again";
        }
        //if the refresh token hasn't expired, set token as the refresh token
        else
        {
			$client->setAccessToken($token);
			echo "use refreshed token but not time yet";
        }
    }
    //if a refresh token isn't in there...
    else
    {
        $client->refreshToken($refreshToken);
        $newtoken=$client->getAccessToken();
        echo $newtoken."</br>";
        $tokenupdate="INSERT INTO token (type,token) VALUES ('refresh','$newtoken')";
        mysqli_query($cxn,$tokenupdate);
        $token=$newtoken;
        echo "refreshed for first time";
    }      
}

//if token is still good.
if(($timediff<3600)&&($token!=''))
{
    $client->setAccessToken($token);
}

$service = new Google_DfareportingService($client);
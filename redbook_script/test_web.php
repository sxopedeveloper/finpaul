<?php

$username = 'lum-customer-hl_dbf3c54e-zone-static-route_err-pass_dyn';
$password = 'p7za2kger8u8';
$port = 22225;

$session = mt_rand();
$super_proxy = 'servercountry-US.zproxy.lum-superproxy.io';
$curl = curl_init('http://lumtest.com/myip.json');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_PROXY, "http://$super_proxy:$port");
curl_setopt($curl, CURLOPT_PROXYUSERPWD, "$username-country-us-session-$session:$password");
$result = curl_exec($curl);



 $content = curl_exec( $curl );
    $err     = curl_errno( $curl );
    $errmsg  = curl_error( $curl );
    $header  = curl_getinfo( $curl );
 if ($err) {
	    echo '** <br> **';
	    echo $error_msg = curl_error($curl);
	    echo '** <br> **';
	}
    if ($errmsg) {
    	echo '** <br>	 **';
	    echo $error_msg = curl_error($curl);
	    echo '** <br> **';
	}
curl_close($curl);

    echo $result;

echo $content ;
?>



<?php

echo '--------------------------------EXIT--------------------------------------------';

exit();


echo 'To enable your free eval account and get CUSTOMER, YOURZONE and '
    .'YOURPASS, please contact sales@luminati.io';
$ch = curl_init('https://www.redbook.com.au/cars/results');
curl_setopt($ch, CURLOPT_PROXY, 'http://zproxy.lum-superproxy.io:22225');
curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'lum-customer-hl_dbf3c54e-zone-static:p7za2kger8u8');
curl_exec($ch);



	//$ch      = curl_init( $url );

 /*$options = array(
        CURLOPT_RETURNTRANSFER => true,     // return web page
        CURLOPT_HEADER         => false,    // don't return headers
        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
        CURLOPT_ENCODING       => "",       // handle all encodings
        CURLOPT_USERAGENT      => "spider", // who am i
        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
        CURLOPT_TIMEOUT        => 120,      // timeout on response
        CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        CURLOPT_SSL_VERIFYPEER => true     // Disabled SSL Cert checks
    );

    curl_setopt_array( $ch, $options );*/
    $content = curl_exec( $ch );
    $err     = curl_errno( $ch );
    $errmsg  = curl_error( $ch );
    $header  = curl_getinfo( $ch );
    

    // $header['errno']   = $err;
    // $header['errmsg']  = $errmsg;
    // $header['content'] = $content;

    $contents =  $content;
    //return $header;
    if ($err) {
	    echo '** <br> **';
	    echo $error_msg = curl_error($ch);
	    echo '** <br> **';
	}
    if ($errmsg) {
    	echo '** <br>	 **';
	    echo $error_msg = curl_error($ch);
	    echo '** <br> **';
	}

	if (isset($error_msg)) {
	    // TODO - Handle cURL error accordingly
	    exit;
	}

	curl_close( $ch );

    print_r($contents);

?>
<?php 
	include('application/third_party/mm_get_rb_data/simple_html_dom_node.php');
	include('application/third_party/mm_get_rb_data/simple_html_dom.php');
	// helper functions
	// -----------------------------------------------------------------------------
	// get html dom from file
	// $maxlen is defined in the code as PHP_STREAM_COPY_ALL which is defined as -1. ! function_exists('file_get_html'))

	function file_get_html_live($url, $use_include_path = false, $context=null, $offset = -1, $maxLen=-1, $lowercase = true, $forceTagsClosed=true, $target_charset = DEFAULT_TARGET_CHARSET, $stripRN=true, $defaultBRText=DEFAULT_BR_TEXT, $defaultSpanText=DEFAULT_SPAN_TEXT)
	{	
		
		
		
		// We DO force the tags to be terminated.
		$dom = new simple_html_dom(null, $lowercase, $forceTagsClosed, $target_charset, $stripRN, $defaultBRText, $defaultSpanText);
		// For sourceforge users: uncomment the next line and comment the retreive_url_contents line 2 lines down if it is not already done.
		$contents = file_get_contents($url, $use_include_path, $context, $offset);
		// Paperg - use our own mechanism for getting the contents as we want to control the timeout.
		//$contents = retrieve_url_contents($url);
		if (empty($contents) || strlen($contents) > MAX_FILE_SIZE)
		{
			return false;
		}
		// The second parameter can force the selectors to all be lowercase.
		$dom->load($contents, $lowercase, $stripRN);
		return $dom;
	}

	// get html dom from string

	function file_get_html($url, $use_include_path = false, $context=null, $offset = -1, $maxLen=-1, $lowercase = true, $forceTagsClosed=true, $target_charset = DEFAULT_TARGET_CHARSET, $stripRN=true, $defaultBRText=DEFAULT_BR_TEXT, $defaultSpanText=DEFAULT_SPAN_TEXT)
	{	
		
		
		// We DO force the tags to be terminated.
		$dom = new simple_html_dom(null, $lowercase, $forceTagsClosed, $target_charset, $stripRN, $defaultBRText, $defaultSpanText);
		// For sourceforge users: uncomment the next line and comment the retreive_url_contents line 2 lines down if it is not already done.
		
		//$contents = file_get_contents($url, $use_include_path, $context, $offset);

		/****************************************************************************/
		
		$options = array(
        CURLOPT_RETURNTRANSFER => true,     // return web page
        CURLOPT_HEADER         => false,    // don't return headers
        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
        CURLOPT_ENCODING       => "",       // handle all encodings
        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
        CURLOPT_TIMEOUT        => 120,      // timeout on response
        CURLOPT_MAXREDIRS      => 5,       // stop after 10 redirects
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4 
	    );

	    $ch      = curl_init( $url );
	    curl_setopt_array( $ch, $options );
	    $contents = curl_exec( $ch );
	    $err     = curl_errno( $ch );
	    $errmsg  = curl_error( $ch );
	    $header  = curl_getinfo( $ch );
	    curl_close( $ch );

	    /*$header['errno']   = $err;
	    $header['errmsg']  = $errmsg;
	    $header['content'] = $content;
	    print_r($header);*/
	    /*********************************************************************************/

		// Paperg - use our own mechanism for getting the contents as we want to control the timeout.
		//$contents = retrieve_url_contents($url);
		if (empty($contents) || strlen($contents) > MAX_FILE_SIZE)
		{
			return false;
		}
		// The second parameter can force the selectors to all be lowercase.
		$dom->load($contents, $lowercase, $stripRN);
		return $dom;
	}
	function str_get_html($str, $lowercase=true, $forceTagsClosed=true, $target_charset = DEFAULT_TARGET_CHARSET, $stripRN=true, $defaultBRText=DEFAULT_BR_TEXT, $defaultSpanText=DEFAULT_SPAN_TEXT)
	{
		//include('application/third_party/mm_get_rb_data/simple_html_dom_node.php');
		//include('application/third_party/mm_get_rb_data/simple_html_dom.php');
		
		$dom = new simple_html_dom(null, $lowercase, $forceTagsClosed, $target_charset, $stripRN, $defaultBRText, $defaultSpanText);
		if (empty($str) || strlen($str) > MAX_FILE_SIZE)
		{
			$dom->clear();
			return false;
		}
		$dom->load($str, $lowercase, $stripRN);
		return $dom;
	}


	// dump html dom tree
	function dump_html_tree($node, $show_attr=true, $deep=0)
	{
		//include('application/third_party/mm_get_rb_data/simple_html_dom_node.php');
		//include('application/third_party/mm_get_rb_data/simple_html_dom.php');
		
		$node->dump($node);
	}

?>
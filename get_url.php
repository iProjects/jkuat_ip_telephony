<?php


	// output: /myproject/index.php
	$currentPath = $_SERVER['PHP_SELF']; 

	// output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index ) 
	$pathInfo = pathinfo($currentPath); 

	// output: localhost
	$hostName = $_SERVER['HTTP_HOST']; 

	// output: http://
	$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';

	// return: http://localhost/myproject/
	//echo $protocol.'://'.$hostName.$pathInfo['dirname']."/";

	$server_path = $protocol.'://'.$hostName.$pathInfo['dirname']."/";

	
	
	
	
	
	
	
	
	//session_start();
		
		
		
//$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";  
//$CurPageURL = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];  
//echo "The URL of current page: ".$CurPageURL;  
//echo $protocol . $_SERVER['HTTP_HOST'];
//echo $_SERVER['REQUEST_URI']; 
 
 
 
	//echo getBaseUrl();
	
	/**
 * Suppose, you are browsing in your localhost 
 * http://localhost/myproject/index.php?id=8
 */
function getBaseUrl() 
{
    // output: /myproject/index.php
    $currentPath = $_SERVER['PHP_SELF']; 

    // output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index ) 
    $pathInfo = pathinfo($currentPath); 

    // output: localhost
    $hostName = $_SERVER['HTTP_HOST']; 

    // output: http://
    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';

    // return: http://localhost/myproject/
    return $protocol.'://'.$hostName.$pathInfo['dirname']."/";
}

?>
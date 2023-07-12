<?php
// remove all session variables
session_unset();

// destroy the session
session_destroy();

if (isset($_COOKIE['loggedinuser'])) {
    unset($_COOKIE['loggedinuser']);  
	setcookie('loggedinuser', '', time() - 3600, '/'); // empty value and old timestamp
} 

if (isset($_COOKIE['loggedintime'])) { 
	unset($_COOKIE['loggedintime']);  
	setcookie('loggedintime', '', time() - 3600, '/'); // empty value and old timestamp
} 

if (isset($_COOKIE['logged_in_user_email'])) { 
	unset($_COOKIE['logged_in_user_email']);  
	setcookie('logged_in_user_email', '', time() - 3600, '/'); // empty value and old timestamp
} 

return print_r($_SESSION);

?>
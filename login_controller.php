<?php
 
/* login */
$response = "";

if(isset($_POST)){
 
	$user_name = trim(htmlspecialchars(strip_tags($_POST['user_name'])));
	$user_password = trim(htmlspecialchars(strip_tags($_POST['user_password']))); 
	$password_length = 5;
	
	if(!isset($user_name)){
		$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> email is mandatory field./div>';
	}
	if(!filter_var($user_name, FILTER_VALIDATE_EMAIL)){
		// $response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>Please enter a valid Email Address.</div>'; 
	}
	if(!isset($user_password)){
		$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> password is mandatory field./div>';
	}
	if(strlen($user_password) < $password_length){
		// $response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>Password should be at least ' . $password_length . ' characters.</div>'; 
	} 

	if(!empty($response)){
		echo $response;
		return;
	}

	require 'login_dal.php';

	$login_dal = new login_dal();

	echo $login_dal->Login($user_name, $user_password);
 
}

?>

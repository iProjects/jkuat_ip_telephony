<?php
 
/* login */
$response = "";

if(isset($_POST)){
 
	$email = trim(htmlspecialchars(strip_tags($_POST['email'])));
	$pass_word = trim(htmlspecialchars(strip_tags($_POST['pass_word']))); 
	$password_length = 5;
	
	if(!isset($email)){
		$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Email is mandatory field.</div>';
	} 	
	$regex = "/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,6})+$/";
	if (!preg_match_all($regex, $email)) {
		$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Please provide a valid email.</div>';
	} 
	if(!isset($pass_word)){
		$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Password is mandatory field./div>';
	}
	if(strlen($pass_word) < $password_length){
		// $response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>Password should be at least ' . $password_length . ' characters.</div>'; 
	} 

	if(!empty($response)){
		echo $response;
		return;
	}

	require 'login_dal.php';

	$login_dal = new login_dal();

	echo $login_dal->Login($email, $pass_word);
 
}

?>

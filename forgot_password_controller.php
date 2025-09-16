<?php
 
require 'forgot_password_dal.php';

/* login */
$response = "";

if(isset($_POST))
{
 
	$email = trim(htmlspecialchars(strip_tags($_POST['email']))); 
	
	if(!isset($email)){
		$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Email is mandatory field.</div>';
	} 	
	$regex = "/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,6})+$/";
	if (!preg_match_all($regex, $email)) {
		$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Please provide a valid email.</div>';
	} 
	
	if(!empty($response)){
		echo $response;
		return;
	}

	$forgot_password_dal = new forgot_password_dal();
 
	echo $forgot_password_dal->forgot_password($email);
 
}

?>

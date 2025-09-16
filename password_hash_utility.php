<?php

require 'user_dal.php';	

if(isset($_POST['action'])){
	if ($_POST['action'] == "create_hash") 
	{ 
		create_hash(); 
	}
	if ($_POST['action'] == "verify_password") 
	{ 
		verify_password(); 
	}  	
}

function create_hash() {
 
	$response = "";

	if(isset($_POST)){
	 
		$email = trim(htmlspecialchars(strip_tags($_POST['email'])));
		$pass_word = trim(htmlspecialchars(strip_tags($_POST['pass_word']))); 
		
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

		if(!empty($response)){
			echo $response;
			return;
		}

		$options['cost'] = 12;
 
		// echo "Hashed password using bcrypt: ",
		$default_hash = password_hash($pass_word, PASSWORD_DEFAULT, $options);
		echo $default_hash;


		$user_dal = new user_dal();

		echo $user_dal->update_user_password_hash($email, $default_hash);

  
	}

}

function verify_password() {
 
	$response = "";

	if(isset($_POST)){
	 
		$email = trim(htmlspecialchars(strip_tags($_POST['email'])));
		$pass_word = trim(htmlspecialchars(strip_tags($_POST['pass_word']))); 
		
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

		if(!empty($response)){
			echo $response;
			return;
		}

		$user_dal = new user_dal();

		$user = $user_dal->get_user_given_email($email);

		if($user)
		{
			//echo $user;

			$data = json_decode($user, true);
			// echo $data["password_hash"];

			$saved_hash = $data["password_hash"];

			if (password_verify($pass_word, $saved_hash)) {
				echo 'success';
			} else {
				echo 'Error authenticating the user.';
			}

		}else
		{
			echo 'Error retrieving the user.';
		}
		
	 
	}

}



?>
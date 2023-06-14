<?php

if(isset($_POST['action'])){
	if ($_POST['action'] == "validate_email") 
	{ 
		validate_email(); 
	}
	if ($_POST['action'] == "send_email") 
	{ 
		send_email(); 
	}  	
}

function validate_email()
{
	
	try {
		$response = "";

		if(isset($_POST)){
		 
			$email = trim(htmlspecialchars(strip_tags($_POST['email'])));
			$message = trim(htmlspecialchars(strip_tags($_POST['message'])));
			
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
		 
			$to = $email;              // user’s email
			$subject = "Verification";      // email subject
			$from = "fanikiwa254@gmail.com";    // your email
			$message = "
			Thank you for signing up!
			Please click on the link below to log in with the following credentials.
			————————
			Username: 'fanikiwa254@gmail.com'
			Password: 'phkbommtmijgshws'
			————————
			Click here to log in:
			//Add a link to your website’s login page";
			if(mail($to, $subject, $message, $from)){
				echo "Email Verified!";
			}
			else{
				echo "Email does not exist!";
				// here you can cancel the registration
			}
			 
		  
		}

	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
		
}


function send_email()
{
	
	try {
		
		$to_email = "fanikiwa254@gmail.com";
		$subject = "Simple Email Test via PHP";
		$body = "Hi,nn This is test email send by PHP Script";
		$headers = "From: sender\'s email";
		 
		if (mail($to_email, $subject, $body, $headers)) {
			echo "Email successfully sent to $to_email...";
		} else {
			echo "Email sending failed...";
		}
		
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
		
}

?>
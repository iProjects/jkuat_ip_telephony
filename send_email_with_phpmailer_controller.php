<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/phpmailer/phpmailer/src/Exception.php';
require __DIR__ . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require __DIR__ . '/vendor/phpmailer/phpmailer/src/SMTP.php';

//Load Composer's autoloader
require 'vendor/autoload.php';

if(isset($_POST['action'])){ 
	if ($_POST['action'] == "send_email") 
	{ 
		send_email(); 
	}  	
}

function send_email()
{ 

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
	 		
		//Create an instance; passing `true` enables exceptions
		$mail = new PHPMailer(true);

		try {
			//Server settings
			$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
			$mail->isSMTP();                                            //Send using SMTP
			$mail->Host       = 'smtp.gmail.com';                     	//Set the SMTP server to send through
			$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
			$mail->Username   = 'fanikiwa254@gmail.com';                //SMTP username
			$mail->Password   = 'phkbommtmijgshws';                     //SMTP password
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
			$mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS` 
																		/// TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above


			//Recipients
			$mail->setFrom($email, 'Mailer');
			$mail->addAddress($email, 'Joe User');     //Add a recipient
			$mail->addAddress($email);               //Name is optional
			$mail->addReplyTo($email, 'Information');
			$mail->addCC($email);
			$mail->addBCC($email);

			//Attachments
			//$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
			//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

			//Content
			$mail->isHTML(true);                                  //Set email format to HTML
			$mail->Subject = 'Here is the subject';
			$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
			$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			$mail->send();
			
			echo 'Message has been sent';
		} catch (Exception $e) {
			echo "Message could not be sent. Mailer Error: {$e->getMessage()}";
		}

	}
}

?>
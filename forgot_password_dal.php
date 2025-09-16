
<?php
/* Quick description on library file structure:

– Database – At the very top of the file we are using our database connection file that we are going to need through the library.

– CRUD: Class name which is having our methods collection.

– __construct() and destruct() method to initiate our database connection variable.
 
– Login() : Used to authenticate user email against the password.
 
– get_user_role() : Use to get authenticate user role.
 */
 session_start();
 
require 'database.php';
require 'send_email_with_phpmailer_controller.php';
		 
class forgot_password_dal
{

    protected $db;

    function __construct()
    { 
		$this->db = DB();
    }

    function __destruct()
    {
        $this->db = null;
    }
 
    /*
     * forgot_password
     *
     * @param $email 
     * 
     */
	public function forgot_password($email)
    {
		try{				 
				
				$is_email = $this->check_if_email_exists($email);
				 
				if(!$is_email)
				{
					$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>User with Email [ ' . $email . ' ] does not exists.</div>';
					return $response;
				} 
				else
				{
					$user = $this->get_user_given_email($email);

					$new_password = $this->random_password();

					$password_hash = $this->create_hash($new_password);
			 
					$encoded_password = $this->encode($new_password);
					
					// Update query
					$query = "UPDATE tbl_users SET  
					pass_word = :encoded_password, 
					password_hash = :password_hash 
					WHERE email = :email";
					
					// prepare query for execution
					$stmt = $this->db->prepare($query);
					
					// bind the parameters
					$stmt->bindParam(":email", $email, PDO::PARAM_STR);
					$stmt->bindParam(":encoded_password", $encoded_password, PDO::PARAM_STR); 
					$stmt->bindParam(":password_hash", $password_hash, PDO::PARAM_STR); 
					
					// Execute the query
					//$stmt->execute();

					$response = "<div class='alert alert-success'>new password [ " . $new_password . " ] .</div>";

					$message = "";
					$subject = "Online Ip Telephony. Reset Password";
					$body = "<br />  ———————— <br /> 
							Username: " .  $email . " <br /> 
							Password: " . $new_password . " <br /> 
							———————— <br /> ";
					echo $body;
					$alt_body = "";
					$full_names = $user['full_names'];

					$mailer_response = send_reset_password_email($email, $message, $subject, $body, $alt_body, $full_names);

					if($mailer_response == "success")
					{ 		
						$response = "A new password has been sent to your email. <br /> Check your email.";
					}
		 
					return $response;

				}	
			 
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }

    /*
     * Get user Details
     *
     * @param $email
     * 
     */
    public function check_if_email_exists($email)
    {
		try{
			// select query
			$query = "SELECT * FROM tbl_users 
			WHERE email = :email";

			// prepare query for execution			
			$stmt = $this->db->prepare($query);

			// bind the parameters
			$stmt->bindParam(":email", $email, PDO::PARAM_STR);

			// Execute the query
			$stmt->execute();
			
			$arr = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if (!$arr) {
				// array is empty.
				return null;
			}

			extract($arr); 
			
			return $email;		
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }
	
	private function random_password()
	{
		$random_characters = 2;
		$random_password = "";

		$lower_case = "abcdefghijklmnopqrstuvwxyz";
		$upper_case = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$numbers = "1234567890";
		$symbols = "!@#$%^&*.";

		$lower_case = str_shuffle($lower_case);
		$upper_case = str_shuffle($upper_case);
		$numbers = str_shuffle($numbers);
		$symbols = str_shuffle($symbols);

		//$random_password = substr($lower_case, 0, $random_characters);
		$random_password .= substr($upper_case, 0, 4);
		$random_password .= substr($numbers, 0, 3);
		$random_password .= substr($symbols, 0, 1);

		return str_shuffle($random_password);

	}

    /*
     * Get user Details
     *
     * @param $email
     * 
     */
    public function get_user_given_email($email)
    {
		try{
			// select query
			$query = "SELECT * FROM tbl_users 
			WHERE email = :email";

			// prepare query for execution			
			$stmt = $this->db->prepare($query);

			// bind the parameters
			$stmt->bindParam(":email", $email, PDO::PARAM_STR);

			// Execute the query
			$stmt->execute();
			
			// return retrieved row as a json object
			return $stmt->fetch(PDO::FETCH_ASSOC);
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }
	
	function create_hash($pass_word) {

		$options['cost'] = 12;

		$default_hash = password_hash($pass_word, PASSWORD_DEFAULT, $options);
		return $default_hash;

	}

	var $skey = "EaaJgaD0uFDEg7tpvMOqKfAQ46Bqi8Va"; // you can change it

    public  function safe_b64encode($string) {
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }

    public function safe_b64decode($string) {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

    public  function encode($value){ 
        if(!$value){return false;}
        $text = $value;
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->skey, $text, MCRYPT_MODE_ECB, $iv);
        return trim($this->safe_b64encode($crypttext)); 
    }

    public function decode($value){
        if(!$value){return false;}
        $crypttext = $this->safe_b64decode($value); 
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->skey, $crypttext, MCRYPT_MODE_ECB, $iv);
        return trim($decrypttext);
    }











}

?>
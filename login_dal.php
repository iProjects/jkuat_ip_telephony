
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
		 
class login_dal
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
     * Login
     *
     * @param $email
	 * @param $pass_word
     * */
    public function Login($email, $pass_word)
    {
		try{
			// select query
			$query = "SELECT * FROM tbl_users 
			WHERE email = :email AND password = :pass_word";
			
			// prepare query for execution			
			$stmt = $this->db->prepare($query);
			
			// bind the parameters
			$stmt->bindParam(":email", $email, PDO::PARAM_STR);
			$stmt->bindParam(":pass_word", $pass_word, PDO::PARAM_STR);
			
			// Execute the query
			$stmt->execute();
			
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			 
			if(!$row)
			{
				return 'failure';
			}
			else
			{
				$_SESSION['loggedinuser'] = $email;
				$_SESSION['loggedintime'] = date("d-m-Y h:i:s a");
				$_SESSION['logged_in_user_email'] = $row['email'];
				
				setcookie('loggedinuser', $email, time() + (60*60*24*365), '/');
				setcookie('loggedintime', date("d-m-Y h:i:s a"), time() + (60*60*24*365), '/');
				setcookie('logged_in_user_email', $row['email'], time() + (60*60*24*365), '/');
				 
				$role = $this->get_user_role($email);

				if(!$role)
				{
					return '<br />failure';
				}else{
					return 'successfull';
				}
			}
			 
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
		 
    }
	
    /*
     * get_user_role
     *
     * @param $email 
     * */
	private function get_user_role($email)
    {
		try{
			 
			// select query
			$query = "SELECT role_name FROM tbl_roles AS roles 
			INNER JOIN tbl_users_roles AS users_roles ON roles.id = users_roles.role_id 
			INNER JOIN tbl_users AS users ON users_roles.user_id = users.id 
			WHERE users.email = :email";
			
			// prepare query for execution			
			$stmt = $this->db->prepare($query);
			
			// bind the parameters
			$stmt->bindParam(":email", $email, PDO::PARAM_STR); 
			
			// Execute the query
			$stmt->execute();
			
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			 
			if(!$row)
			{
				echo "Error retrieving user Role.";
				return false;
			}
			else
			{
				$role = $row['role_name'];

				//echo $role;
				$_SESSION['logged_in_user_role'] = $role; 
				setcookie('logged_in_user_role', $role, time() + (60*60*24*365), '/');
				
				return true;
			}
			 
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }










}

?>
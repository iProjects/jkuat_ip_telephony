
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
     * @param $user_name
	 * @param $user_password
     * */
    public function Login($user_name, $user_password)
    {
		try{
			// select query
			$query = "SELECT * FROM telephoneadmin WHERE username = :user_name AND password = :user_password";
			// prepare query for execution			
			$stmt = $this->db->prepare($query);
			// bind the parameters
			$stmt->bindParam(":user_name", $user_name, PDO::PARAM_STR);
			$stmt->bindParam(":user_password", $user_password, PDO::PARAM_STR);
			// Execute the query
			$stmt->execute();
			
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			//print_r($row);

			if(!$row)
			{
				return 'failure';
			}
			else
			{
				$_SESSION['loggedinuser'] = $user_name;
				$_SESSION['loggedintime'] = date("d-m-Y h:i:s a");
				$_SESSION['logged_in_user_email'] = $row['email'];
				
				$this->get_user_role($user_name);

				return 'successfull';
			}
			 
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
		 
    }
	
    /*
     * get_user_role
     *
     * @param $user_name 
     * */
	private function get_user_role($user_name)
    {
		try{
			$logged_in_user_email = $_SESSION['logged_in_user_email'];
			
			// select query
			$query = "SELECT * FROM adminregistration WHERE email = :logged_in_user_email";
			// prepare query for execution			
			$stmt = $this->db->prepare($query);
			// bind the parameters
			$stmt->bindParam(":logged_in_user_email", $logged_in_user_email, PDO::PARAM_STR); 
			// Execute the query
			$stmt->execute();
			
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			//print_r($row);

			if(!$row)
			{
				echo "error retrieving user email.";
			}
			else
			{
				$_SESSION['logged_in_user_role'] = $row['adminType']; 
			}
			 
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }










}

?>
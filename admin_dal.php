
<?php
/* Quick description on library file structure:

– Database – At the very top of the file we are using our database connection file that we are going to need through the library.

– CRUD: Class name which is having our methods collection.

– __construct() and destruct() method to initiate our database connection variable.
 
– create_extension() : Used to create an extension record in database.
 
– get_user_role() : Use to get authenticate user role.
 */
 session_start();
 
require 'database.php';
		 
class admin_dal
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
     * Get campuses count
     * 
     * */
    public function get_campus_count()
    {
		try{
			// select query
			$query = "SELECT * FROM tbl_campuses";
			// prepare query for execution			
			$stmt = $this->db->prepare($query); 
			// Execute the query
			$stmt->execute();
			
			// this is how to get number of rows returned
			$num = $stmt->rowCount();
		
			// return retrieved row as a json object
			return json_encode($num);		
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }
	
    /*
     * Get departments count
     * 
     * */
    public function get_departments_count()
    {
		try{
			// select query
			$query = "SELECT * FROM tbl_departments";
			// prepare query for execution			
			$stmt = $this->db->prepare($query); 
			// Execute the query
			$stmt->execute();
			
			// this is how to get number of rows returned
			$num = $stmt->rowCount();
		
			// return retrieved row as a json object
			return json_encode($num);	
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }
	
    /*
     * Get extensions count
     * 
     * */
    public function get_extensions_count()
    {
		try{
			// select query
			$query = "SELECT * FROM tbl_extensions";
			// prepare query for execution			
			$stmt = $this->db->prepare($query); 
			// Execute the query
			$stmt->execute();
			
			// this is how to get number of rows returned
			$num = $stmt->rowCount();
		
			// return retrieved row as a json object
			return json_encode($num);	
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }

    /*
     * Get users count
     * 
     * */
    public function get_users_count()
    {
		try{
			// select query
			$query = "SELECT * FROM tbl_users";
			// prepare query for execution			
			$stmt = $this->db->prepare($query); 
			// Execute the query
			$stmt->execute();
			
			// this is how to get number of rows returned
			$num = $stmt->rowCount();
		
			// return retrieved row as a json object
			return json_encode($num);		
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }
	
    /*
     * Get get logged in user roles and rights
     * 
     * */
    public function get_user_roles_and_rights($logged_in_user_email)
    {
		try{
			
			$user = $this->get_user_given_email($logged_in_user_email);
			
			if (!$user) {
				// array is empty.
				$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Error retrieving User with Email [ ' . $logged_in_user_email . ' ] </div>';
				return $response;
			}

			$role_rights_arr = $this->get_role_rights_given_role_id($logged_in_user_email);
		
			// return retrieved row as a json object
			return json_encode($role_rights_arr);		
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }
	
    /*
     * Get user Details
     *
     * @param $email
     * */
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
			
			$user = $stmt->fetch(PDO::FETCH_ASSOC);
			 
			return $user;		
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }
	
    /*
     * Get Role Rights Details
     *
     * @param $role id
     * */
    public function get_role_rights_given_role_id($logged_in_user_email)
    {
		try{
			// select query
			$query = "SELECT right_code FROM tbl_rights AS rights  
			INNER JOIN tbl_roles_rights AS roles_rights ON rights.id = roles_rights.right_id  
			INNER JOIN tbl_roles AS roles ON roles_rights.role_id = roles.id  
			INNER JOIN tbl_users_roles AS users_roles ON roles.id = users_roles.role_id  
			INNER JOIN tbl_users AS users ON users_roles.user_id = users.id 			
			WHERE (users.email = :logged_in_user_email AND rights.status = :status AND roles_rights.allowed = 1)  
			ORDER BY rights.right_name ASC";
			
			// prepare query for execution			
			$stmt = $this->db->prepare($query);
			// bind the parameters
			$stmt->bindParam(":logged_in_user_email", $logged_in_user_email, PDO::PARAM_STR);
			$status = "active";
			$stmt->bindParam(":status", $status, PDO::PARAM_STR);
			// Execute the query
			$stmt->execute();
			
			// return retrieved rows as an array
			$data = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				//extract($row); 			 
				//$data[] = $right_code;
				 			 
				$data[] = $row;
			}
			
			//return json
			return json_encode($data);	
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }
	
    /*
     * Get Rights
     * 
     * */
    public function get_roles_and_rights()
    {
		try{
			// select query
			$query = "SELECT right_code FROM tbl_rights AS rights   
			ORDER BY rights.right_name ASC";
			
			// prepare query for execution			
			$stmt = $this->db->prepare($query); 
			
			// Execute the query
			$stmt->execute();
			
			// return retrieved rows as an array
			$data = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				//extract($row); 			 
				//$data[] = $right_code;
				 			 
				$data[] = $row;
			}
			
			//return json
			return json_encode($data);	
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }
	
 
 
 
 




}

?>

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
			$query = "SELECT * FROM campuses";
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
			$query = "SELECT * FROM depts";
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
			$query = "SELECT deptcode FROM depts WHERE deptcode is not null";
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
			$query = "SELECT * FROM adminregistration";
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
	
 
 




}

?>
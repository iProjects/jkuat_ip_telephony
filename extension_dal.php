
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
		 
class extension_dal
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
     * Add new Record
     *
	 * @param $campus_id
	 * @param $department_id
	 * @param $owner_assigned
	 * @param $extension_number
	 *
     * @return $string
     * */
	public function create_extension($campus_id, $department_id, $owner_assigned, $extension_number, $addedby)
    {
		try{
			
			$extension_no = $this->check_if_extension_number_exists($extension_number);
			 
			if(!empty($extension_no))
			{
				$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>Extension Number [ ' . $extension_number . ' ] exists.</div>';
				return $response;
			}
			
			// insert query
			$query = "INSERT INTO tbl_extensions(
			campus_id, 
			department_id, 
			owner_assigned, 
			extension_number,
			status, 
			created_date, 
			addedby) 
			VALUES(
			:campus_id, 
			:department_id, 
			:owner_assigned, 
			:extension_number,
			:status,
			:created_date,			
			:addedby)";
			
			// prepare query for execution
			$stmt = $this->db->prepare($query);
			
			// bind the parameters
			$stmt->bindParam(":campus_id", $campus_id, PDO::PARAM_STR);
			$stmt->bindParam(":department_id", $department_id, PDO::PARAM_STR);
			$owner_assigned = ucwords($owner_assigned);
			$stmt->bindParam(":owner_assigned", $owner_assigned, PDO::PARAM_STR);
			$stmt->bindParam(":extension_number", $extension_number, PDO::PARAM_STR);
			$status = "active";
			$stmt->bindParam(":status", $status, PDO::PARAM_STR); 
			$created_date = date('d-m-Y h:i:s A');
			$stmt->bindParam(":created_date", $created_date, PDO::PARAM_STR); 
			$stmt->bindParam(":addedby", $addedby, PDO::PARAM_STR); 

			// Execute the query
			$stmt->execute();
			
			// save lastInsertId in a variable
			$lastInsertId = $this->db->lastInsertId();
			
			$response = "<div class='alert alert-success'>Extension No [ " . $extension_number . " ] for [ " . $owner_assigned . " ]  was successfully created.<br />Last Insert Id = [ " . $lastInsertId . " ]</div>";
  
			//$response = "<div class='alert alert-success'>Extension No [ " . $extension_number . " ] was successfully created. <br />Last Insert Id = [ " . $lastInsertId . " ]</div>";
			
			return $response;
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }

    /*
     * Add new Record from upload
     *
	 * @param $campus_id
	 * @param $department_id
	 * @param $owner_assigned
	 * @param $extension_number
	 
     * @return $string
     * */
	public function create_extension_from_upload($campus_id, $department_id, $owner_assigned, $extension_number, $addedby)
    {
		try{
			
			$extension_no = $this->check_if_extension_number_exists($extension_number);
			 
			if(!empty($extension_no))
			{
				$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>Extension Number [ ' . $extension_number . ' ] exists.</div>';
				return $response;
			}
			
			// insert query
			$query = "INSERT INTO tbl_extensions(
			campus_id, 
			department_id, 
			owner_assigned, 
			extension_number,
			status, 
			created_date, 
			addedby) 
			VALUES(
			:campus_id, 
			:department_id, 
			:owner_assigned, 
			:extension_number,
			:status,
			:created_date,			
			:addedby)";
			
			// prepare query for execution
			$stmt = $this->db->prepare($query);
			
			// bind the parameters
			$stmt->bindParam(":campus_id", $campus_id, PDO::PARAM_STR);
			$stmt->bindParam(":department_id", $department_id, PDO::PARAM_STR);
			$owner_assigned = ucwords($owner_assigned);
			$stmt->bindParam(":owner_assigned", $owner_assigned, PDO::PARAM_STR);
			$stmt->bindParam(":extension_number", $extension_number, PDO::PARAM_STR);
			$status = "active";
			$stmt->bindParam(":status", $status, PDO::PARAM_STR); 
			$created_date = date('d-m-Y h:i:s A');
			$stmt->bindParam(":created_date", $created_date, PDO::PARAM_STR); 
			$stmt->bindParam(":addedby", $addedby, PDO::PARAM_STR); 
			
			// Execute the query
			$stmt->execute();
			
			// save lastInsertId in a variable
			$lastInsertId = $this->db->lastInsertId();
			
			$response = "<div class='alert alert-success'>Extension No [ " . $extension_number . " ] for [ " . $owner_assigned . " ]  was successfully created.<br />Last Insert Id = [ " . $lastInsertId . " ]</div>";
  
			//$response = "<div class='alert alert-success'>Extension No [ " . $extension_number . " ] was successfully created. Last Insert Id = [ " . $lastInsertId . " ]</div>";
			
			return $response;
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }

    /*
     * Get extension Details
     *
     * @param $extension_number
     * */
    public function check_if_extension_number_exists($extension_number)
    {
		try{
			// select query
			$query = "SELECT * FROM tbl_extensions 
			WHERE extension_number = :extension_number";

			// prepare query for execution			
			$stmt = $this->db->prepare($query);

			// bind the parameters
			$stmt->bindParam(":extension_number", $extension_number, PDO::PARAM_STR);

			// Execute the query
			$stmt->execute();
			
			$arr = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if (!$arr) {
				// array is empty.
				return null;
			}

			extract($arr); 
			
			return $deptcode;		
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return null;
		}
    }
	
    /*
     * Update Record
     *
	 * @param $campus_id
	 * @param $department_id
	 * @param $owner_assigned
	 * @param $extension_number
	 * @param $id

     * @return $mixed
     * */
    public function update_extension($campus_id, $department_id, $owner_assigned, $extension_number, $id)
    {
		try{
			// Update query
			$query = "UPDATE tbl_extensions SET 
			campus_id = :campus_id,  
			department_id = :department_id, 			
			owner_assigned = :owner_assigned, 
			extension_number = :extension_number 
			WHERE id = :id";
			
			// prepare query for execution
			$stmt = $this->db->prepare($query);
			
			// bind the parameters
			$stmt->bindParam(":campus_id", $campus_id, PDO::PARAM_STR); 
			$stmt->bindParam(":department_id", $department_id, PDO::PARAM_STR);
			$owner_assigned = ucwords($owner_assigned);
			$stmt->bindParam(":owner_assigned", $owner_assigned, PDO::PARAM_STR);
			$stmt->bindParam(":extension_number", $extension_number, PDO::PARAM_STR);
			$stmt->bindParam(":id", $id, PDO::PARAM_STR);
			
			// Execute the query
			$stmt->execute();
			
			$response = "<div class='alert alert-success'>Extension No [ " . $extension_number . " ] for [ " . $owner_assigned . " ]  was successfully updated.</div>";
   
			return $response;
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }

    /*
     * Update Record
     *
	 * @param $campus_id
	 * @param $department_id
	 * @param $owner_assigned
	 * @param $extension_number

     * @return $mixed
     * */
    public function update_extension_from_upload($campus_id, $department_id, $owner_assigned, $extension_number)
    {
		try{
			// Update query
			$query = "UPDATE tbl_extensions SET 
			campus_id = :campus_id,  
			department_id = :department_id, 			
			owner_assigned = :owner_assigned
			WHERE extension_number = :extension_number";
			
			// prepare query for execution
			$stmt = $this->db->prepare($query);
			
			// bind the parameters
			$stmt->bindParam(":campus_id", $campus_id, PDO::PARAM_STR); 
			$stmt->bindParam(":department_id", $department_id, PDO::PARAM_STR);
			$owner_assigned = ucwords($owner_assigned);
			$stmt->bindParam(":owner_assigned", $owner_assigned, PDO::PARAM_STR);
			$stmt->bindParam(":extension_number", $extension_number, PDO::PARAM_STR); 
			
			// Execute the query
			$stmt->execute();
 
			$response = "<div class='alert alert-success'>Extension No [ " . $extension_number . " ] for [ " . $owner_assigned . " ]  was successfully updated.</div>";
  
			return $response;
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }

    /*
     * Get extension Details
     *
     * @param $id
     * */
    public function get_extension($id)
    {
		try{
			// select query
			$query = "SELECT * FROM tbl_extensions WHERE id = :id";

			// prepare query for execution			
			$stmt = $this->db->prepare($query);

			// bind the parameters
			$stmt->bindParam(":id", $id, PDO::PARAM_STR);

			// Execute the query
			$stmt->execute();

			// return retrieved row as a json object
			return json_encode($stmt->fetch(PDO::FETCH_ASSOC));
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }
	
    /*
     * Get extension Details
     *
     * @param $id
     * */
    public function fetch_extension($id)
    {
		try{
			// select query
			$query = "SELECT * FROM tbl_extensions WHERE id = :id";

			// prepare query for execution			
			$stmt = $this->db->prepare($query);

			// bind the parameters
			$stmt->bindParam(":id", $id, PDO::PARAM_STR);

			// Execute the query
			$stmt->execute();

			// return retrieved row as a json object
			return $stmt->fetch(PDO::FETCH_ASSOC);
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }
	
    /*
     * Read all extension records
     *
     * @return $mixed
     * */
    public function get_all_extensions()
    {
		try{
			// select query - select all data
			$query = "SELECT * FROM tbl_extensions ORDER BY id DESC";

			// prepare query for execution	
			$stmt = $this->db->prepare($query);

			// Execute the query
			$stmt->execute();

			// return retrieved rows as an array
			$data = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$data[] = $row;
			}
			return $data;
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }

    /*
     * Delete Record
     *
     * @param $id
     * */
    public function delete_extension($id)
    {
		try{
			
			$extension_record = $this->fetch_extension($id);
			 
			foreach ($extension_record as $key => $value) {
				if($key == "extension_number") {
					$extension_number = $value; 
				}
				if($key == "owner_assigned") {
					$owner_assigned = $value; 
				}
			}
			
			// delete query
			$query = "DELETE FROM tbl_extensions 
			WHERE id = :id";

			// prepare query for execution
			$stmt = $this->db->prepare($query);

			// bind the parameters
			$stmt->bindParam(":id", $id, PDO::PARAM_STR);

			// Execute the query
			$stmt->execute();
			
			$response = "<div class='alert alert-success'>Extension No [ " . $extension_number . " ] for [ " . $owner_assigned . " ]  was successfully deleted.</div>";
			
			return $response;
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }

    /*
     * Get campus Details
     *
     * @param $ccode
     * */
    public function get_campus_given_code($ccode)
    {
		try{
			// select query
			$query = "SELECT * FROM campuses WHERE ccode = :ccode";
			// prepare query for execution			
			$stmt = $this->db->prepare($query);
			// bind the parameters
			$stmt->bindParam(":ccode", $ccode, PDO::PARAM_STR);
			// Execute the query
			$stmt->execute();
			// return retrieved row as a json object
			return json_encode($stmt->fetch(PDO::FETCH_ASSOC));
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }
	
    /*
     * Get campus Details
     *
     * @param $ccode
     * */
    public function get_campus_name_given_code($ccode)
    {
		try{
			// select query
			$query = "SELECT cname  FROM campuses WHERE ccode = :ccode";
			// prepare query for execution			
			$stmt = $this->db->prepare($query);
			// bind the parameters
			$stmt->bindParam(":ccode", $ccode, PDO::PARAM_STR);
			// Execute the query
			$stmt->execute();
			
			$arr = $stmt->fetch(PDO::FETCH_ASSOC);
			
			extract($arr); 
			
			return $cname;
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }
	
    /*
     * Read all campus records
     *
     * @return $mixed
     * */
    public function get_all_campuses()
    {
		try{
			// select query - select all data
			$query = "SELECT * FROM tbl_campuses 
			ORDER BY campus_name ASC";

			// prepare query for execution	
			$stmt = $this->db->prepare($query);

			// Execute the query
			$stmt->execute();

			// return retrieved rows as an array
			$data = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$data[] = $row;
			}

			//return $data;
			return json_encode($data);

		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }

    /*
     * Read all campus codes
     *
     * @return $mixed
     * */
    public function get_campus_codes()
    {
		try{
			// select query - select all data
			$query = "SELECT ccode FROM tbl_campuses ORDER BY id ASC";
			// prepare query for execution	
			$stmt = $this->db->prepare($query);
			// Execute the query
			$stmt->execute();
			// return retrieved rows as an array
			$data = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$data[] = $row;
			}
			//return $data;
			return json_encode($data);
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }

    /*
     * Read all campus names
     *
     * @return $mixed
     * */
    public function get_campus_names()
    {
		try{
			// select query - select all data
			$query = "SELECT DISTINCT campus_name FROM tbl_campuses ORDER BY id ASC";

			// prepare query for execution	
			$stmt = $this->db->prepare($query);

			// Execute the query
			$stmt->execute();

			// return retrieved rows as an array
			$data = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$data[] = $row;
			}

			//return $data;
			return json_encode($data);

		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }

    /*
     * Read all department names given campus
     *
     * @return $mixed
     * */
    public function get_departments_given_campus_id($campus_id)
    {
		try{
			// select query - select all data
			$query = "SELECT * FROM tbl_departments as departments  
			WHERE departments.campus_id = :campus_id 
			ORDER BY departments.department_name ASC";

			// prepare query for execution	
			$stmt = $this->db->prepare($query);

			// bind the parameters
			$stmt->bindParam(":campus_id", $campus_id, PDO::PARAM_STR);

			// Execute the query
			$stmt->execute();

			// return retrieved rows as an array
			$data = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$data[] = $row;
			}

			//return $data;
			return json_encode($data);

		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }

    /*
     * Read all department names given campus
     *
     * @return $mixed
     * */
    public function get_department_names($campus_id)
    {
		try{
			// select query - select all data
			$query = "SELECT DISTINCT department_name FROM tbl_departments as departments  
			INNER JOIN tbl_extensions as extensions ON departments.id = extensions.department_id 
			WHERE extensions.campus_id = :campus_id 
			ORDER BY departments.department_name ASC";

			// prepare query for execution	
			$stmt = $this->db->prepare($query);

			// bind the parameters
			$stmt->bindParam(":campus_id", $campus_id, PDO::PARAM_STR);

			// Execute the query
			$stmt->execute();

			// return retrieved rows as an array
			$data = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$data[] = $row;
			}

			//return $data;
			return json_encode($data);

		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }
  
    /*
     * Get campus Details
     *
     * @param $campus_id
     * */
    public function get_campus_name_given_id($campus_id)
    {
		try{
			// select query
			$query = "SELECT campus_name FROM tbl_campuses 
			WHERE id = :campus_id";

			// prepare query for execution			
			$stmt = $this->db->prepare($query);

			// bind the parameters
			$stmt->bindParam(":campus_id", $campus_id, PDO::PARAM_STR);

			// Execute the query
			$stmt->execute();
			
			$campus_name = $stmt->fetch(PDO::FETCH_ASSOC);
			
			return $campus_name["campus_name"];
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }
	
    /*
     * Get department Details
     *
     * @param $department_id
     * */
    public function get_department_name_given_id($department_id)
    {
		try{
			// select query
			$query = "SELECT department_name FROM tbl_departments 
			WHERE id = :department_id";

			// prepare query for execution			
			$stmt = $this->db->prepare($query);

			// bind the parameters
			$stmt->bindParam(":department_id", $department_id, PDO::PARAM_STR);

			// Execute the query
			$stmt->execute();
			
			$department_name = $stmt->fetch(PDO::FETCH_ASSOC);
			
			return $department_name["department_name"];
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }
	
	public function search_extensions_v2($page, $records_to_display, $campus_code, $department, $other_params)
	{		
		// PAGINATION VARIABLES
		// page is the current page, if there's nothing set, default is page 1
		//$page = isset($_POST['page']) ? $_POST['page'] : 1;
		
		// set records or rows of data per page
		//$cards_to_display = isset($_POST['cards_to_display']) ? $_POST['cards_to_display'] : 6;
		
		// set records or rows of data per page
		$records_per_page = (int)$records_to_display;
		
		// calculate for the query LIMIT clause
		$from_record_num = ($records_per_page * $page) - $records_per_page;
		 
		//$total_rows = $this->count_search_extensions($campus_code, $department, $extension_number);
		 
		// select data for current page
		
		/*SEARCH SENARIOS
			1. all items are specified.
			2. other params only typed.
			3. campus only selected.			
			4. department only selected. 
			5. campus and department selected.		
			6. campus and other params typed.
			7. department and other params typed.
			8. no item is specified.		
		*/
		
		//all items are specified.
		if(!empty($campus_code) && !empty($department) && !empty($other_params))
		{
			$query = "SELECT * FROM tbl_extensions WHERE ccode = :campus_code AND deptname = :department AND (deptcode LIKE :extension_number OR deptname LIKE :txtdepartment OR ownerassigned LIKE :owner_assigned) ORDER BY ccode, deptname, ownerassigned ASC LIMIT :from_record_num, :records_per_page";
						
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			$stmt->bindParam(":campus_code", $campus_code, PDO::PARAM_STR);
			$stmt->bindParam(":department", $department, PDO::PARAM_STR);
			 
			$pattern  = '%' . $other_params . '%';
			
			$stmt->bindParam(":extension_number", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $other_params . '%';
			
			$stmt->bindParam(":txtdepartment", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $other_params . '%';
			
			$stmt->bindParam(":owner_assigned", $pattern, PDO::PARAM_STR);
				
			
			$count_query = "SELECT * FROM tbl_extensions WHERE ccode = :campus_code AND deptname = :department AND (deptcode LIKE :extension_number OR deptname LIKE :txtdepartment OR ownerassigned LIKE :owner_assigned) ORDER BY ccode, deptname, ownerassigned ASC";
			
			$count_stmt = $this->db->prepare($count_query);
			 
			$count_stmt->bindParam(":campus_code", $campus_code, PDO::PARAM_STR);
			$count_stmt->bindParam(":department", $department, PDO::PARAM_STR);
			 
			$pattern  = '%' . $other_params . '%';
			
			$count_stmt->bindParam(":extension_number", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $other_params . '%';
			
			$count_stmt->bindParam(":txtdepartment", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $other_params . '%';
			
			$count_stmt->bindParam(":owner_assigned", $pattern, PDO::PARAM_STR);
				
		}
		//other params only typed.
		else if(empty($campus_code) && empty($department) && !empty($other_params))
		{
			$query = "SELECT * FROM tbl_extensions WHERE (deptcode LIKE :extension_number OR deptname LIKE :department OR ownerassigned LIKE :owner_assigned) ORDER BY ccode, deptname, ownerassigned ASC LIMIT :from_record_num, :records_per_page";
						
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			 
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
					 
			$pattern  = '%' . $other_params . '%';
			
			$stmt->bindParam(":extension_number", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $other_params . '%';
			
			$stmt->bindParam(":department", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $other_params . '%';
			
			$stmt->bindParam(":owner_assigned", $pattern, PDO::PARAM_STR);
					
			
			$count_query = "SELECT * FROM tbl_extensions WHERE (deptcode LIKE :extension_number OR deptname LIKE :department OR ownerassigned LIKE :owner_assigned) ORDER BY ccode, deptname, ownerassigned ASC";
			
			$count_stmt = $this->db->prepare($count_query);
			  
			$pattern  = '%' . $other_params . '%';
			
			$count_stmt->bindParam(":extension_number", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $other_params . '%';
			
			$count_stmt->bindParam(":department", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $other_params . '%';
			
			$count_stmt->bindParam(":owner_assigned", $pattern, PDO::PARAM_STR);
				
		} 
		//campus only selected.
		else if(!empty($campus_code) && empty($department) && empty($other_params))
		{				
			$query = "SELECT * FROM tbl_extensions WHERE ccode = :campus_code ORDER BY ccode ASC LIMIT :from_record_num, :records_per_page";
			 				
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			$stmt->bindParam(":campus_code", $campus_code, PDO::PARAM_STR); 
			
			
			$count_query = "SELECT * FROM tbl_extensions WHERE ccode = :campus_code ORDER BY ccode ASC";
			
			$count_stmt = $this->db->prepare($count_query);
			 
			$count_stmt->bindParam(":campus_code", $campus_code, PDO::PARAM_STR);
					
		} 
		//department only selected.
		else if(empty($campus_code) && !empty($department) && empty($other_params))
		{
			$query = "SELECT * FROM tbl_extensions WHERE deptname = :department ORDER BY deptname ASC LIMIT :from_record_num, :records_per_page";
			 				
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
						
			$stmt->bindParam(":department", $department, PDO::PARAM_STR); 
			
			
			$count_query = "SELECT * FROM tbl_extensions WHERE deptname = :department ORDER BY deptname ASC";
			
			$count_stmt = $this->db->prepare($count_query);
			 
			$count_stmt->bindParam(":department", $department, PDO::PARAM_STR); 
						
		} 
		//campus and department selected.
		else if(!empty($campus_code) && !empty($department) && empty($other_params))
		{				
			$query = "SELECT * FROM tbl_extensions WHERE ccode = :campus_code AND deptname = :department ORDER BY ccode, deptname ASC LIMIT :from_record_num, :records_per_page";
 
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			$stmt->bindParam(":campus_code", $campus_code, PDO::PARAM_STR);
			$stmt->bindParam(":department", $department, PDO::PARAM_STR); 
						
			
			$count_query = "SELECT * FROM tbl_extensions WHERE ccode = :campus_code AND deptname = :department ORDER BY ccode, deptname ASC";
			
			$count_stmt = $this->db->prepare($count_query);
			 
			$count_stmt->bindParam(":campus_code", $campus_code, PDO::PARAM_STR);
			$count_stmt->bindParam(":department", $department, PDO::PARAM_STR);  
						
		}
		//campus and other_params typed.
		else if(!empty($campus_code) && empty($department) && !empty($other_params))
		{				
			$query = "SELECT * FROM tbl_extensions WHERE ccode = :campus_code AND (deptcode LIKE :extension_number OR deptname LIKE :txtdepartment OR ownerassigned LIKE :owner_assigned) ORDER BY ccode, deptname, ownerassigned ASC LIMIT :from_record_num, :records_per_page";
			 					
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			$stmt->bindParam(":campus_code", $campus_code, PDO::PARAM_STR); 
			 
			$pattern  = '%' . $other_params . '%';
			
			$stmt->bindParam(":extension_number", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $other_params . '%';
			
			$stmt->bindParam(":txtdepartment", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $other_params . '%';
			
			$stmt->bindParam(":owner_assigned", $pattern, PDO::PARAM_STR);
					
			
			$count_query = "SELECT * FROM tbl_extensions WHERE ccode = :campus_code AND (deptcode LIKE :extension_number OR deptname LIKE :txtdepartment OR ownerassigned LIKE :owner_assigned) ORDER BY ccode, deptname, ownerassigned ASC";
			
			$count_stmt = $this->db->prepare($count_query);
			 
			$count_stmt->bindParam(":campus_code", $campus_code, PDO::PARAM_STR);
			
			$pattern  = '%' . $other_params . '%';
			
			$count_stmt->bindParam(":extension_number", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $other_params . '%';
			
			$count_stmt->bindParam(":txtdepartment", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $other_params . '%';
			
			$count_stmt->bindParam(":owner_assigned", $pattern, PDO::PARAM_STR);
						
		}
		//department and other_params typed.
		else if(empty($campus_code) && !empty($department) && !empty($other_params))
		{				
			$query = "SELECT * FROM tbl_extensions WHERE deptname = :department AND (deptcode LIKE :extension_number OR deptname LIKE :txtdepartment OR ownerassigned LIKE :owner_assigned) ORDER BY ccode, deptname, ownerassigned ASC LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			 
			$stmt->bindParam(":department", $department, PDO::PARAM_STR); 
			
			$pattern  = '%' . $other_params . '%';
			
			$stmt->bindParam(":extension_number", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $other_params . '%';
			
			$stmt->bindParam(":txtdepartment", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $other_params . '%';
			
			$stmt->bindParam(":owner_assigned", $pattern, PDO::PARAM_STR);
					
			
			$count_query = "SELECT * FROM tbl_extensions WHERE deptname = :department AND (deptcode LIKE :extension_number OR deptname LIKE :txtdepartment OR ownerassigned LIKE :owner_assigned) ORDER BY ccode, deptname, ownerassigned ASC";
			
			$count_stmt = $this->db->prepare($count_query);
			 
			$count_stmt->bindParam(":department", $department, PDO::PARAM_STR);
			
			$pattern  = '%' . $other_params . '%';
			
			$count_stmt->bindParam(":extension_number", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $other_params . '%';
			
			$count_stmt->bindParam(":txtdepartment", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $other_params . '%';
			
			$count_stmt->bindParam(":owner_assigned", $pattern, PDO::PARAM_STR);
					
		}  
		//no item is specified.
		else if(empty($campus_code) && empty($department) && empty($other_params))
		{				
			$query = "SELECT * FROM tbl_extensions ORDER BY id DESC LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			
			$count_query = "SELECT * FROM tbl_extensions ORDER BY id DESC";
			
			$count_stmt = $this->db->prepare($count_query);
			
		}
		else
		{ 
			$_SESSION['extensions_count'] = 0;
			return;
		}

		$stmt->execute();
			
		$count_stmt->execute();
				 
		// this is how to get number of rows returned
		$num = $stmt->rowCount();
		
		$count_num = $count_stmt->rowCount();
		
		$_SESSION['extensions_count'] = $count_num;

		//echo $num;
		// link to create record form
		//echo "<a href='create.php' class='btn btn-primary m-b-1em'>Create New Product</a>";
		 
		//check if more than 0 record found
		if($num>0){
		 
			// data from database will be here
			echo "<table class='table table-dark table-striped table-hover table-bordered table-sm' id='table_extensions'>";//start table

			//creating our table heading
			echo "<thead class='thead-dark'>";
			echo "<tr>"; 
				echo "<th scope='col'>Campus</th>";
				echo "<th scope='col'>Department</th>"; 
				echo "<th scope='col'>Owner Assigned</th>";
				echo "<th scope='col'>Extension No</th>";
				echo "<th scope='col'></th>";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			
			// table body will be here
			// retrieve our table contents
			// fetch() is faster than fetchAll()
			// http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
			 
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				 
				// extract row
				// this will make $row['firstname'] to
				// just $firstname only
				extract($row);
				 					
				$id = $row['id'];
				$ccode = $row['ccode'];
				$deptcode = $row['deptcode'];
				$extension_number = $row['extension_number'];
				$owner_assigned = $row['owner_assigned'];

				$campus_name = $this->get_campus_name_given_code($ccode); 
				 			 
				// creating new table row per record
				echo "<tr class='table-primary'>";
					 
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($campus_name, ENT_QUOTES);

				echo "</td>";
					
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($deptcode, ENT_QUOTES);

				echo "</td>";
			 
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($owner_assigned, ENT_QUOTES);

				echo "</td>";
					
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($extension_number, ENT_QUOTES);

				echo "</td>";
			 
				echo "<td class='table-success'>";
					
				echo "<a onClick='edit_extension({$id})' style='cursor:hand !important;' 
				class='btn btn-info m-r-1em crud_buttons btn_edit btn_edit_extension' 
				title='edit'  
				data-id='{$id}' 
				data-toggle='popover' 
				data-placement='auto' 
				data-trigger='hover' 
				data-content='edit extension' >
				edit
					<span class='glyphicon'>
					</span>
				</a>";
								
				echo "<a onClick='delete_extension({$id})' style='cursor:hand !important;' 
				class='btn btn-danger m-r-1em crud_buttons btn_delete btn_delete_extension' 
				title='delete'  
				data-id='{$id}' 
				data-toggle='popover' 
				data-placement='auto' 
				data-trigger='hover' 
				data-content='delete extension' >
				delete
					<span class='glyphicon'>
					</span>
				</a>";
				
				echo "</td>";
			  			
				echo "</tr>";
				
			} 

			echo "</tbody>";
			
			echo "<tfoot>";
			
			echo "</tfoot>";
			
			// end table
			echo "</table>";
			
			// PAGINATION
			// count total number of rows
			// $query = "SELECT COUNT(*) as total_rows FROM tbl_extensions";
			// $stmt = $this->db->prepare($query);
			 
			// // execute query
			// $stmt->execute();
			 
			// // get total rows
			// $row = $stmt->fetch(PDO::FETCH_ASSOC);
			// $total_rows = $row['total_rows'];
			
			//$total_rows = $this->count_search_extensions($campus_code, $department, $extension_number);
			
			// paginate records
			$page_url="extensions.php?";
			include_once "paging_search_extensions_table.php";
		}
		 
		// if no records found
		else{
			echo "<div class='alert alert-danger'>No records found.</div>";
		}
	}
  
	public function search_extensions_v3($page, $records_to_display, $campus_id, $department_id, $other_params)
	{		
		// PAGINATION VARIABLES
		// page is the current page, if there's nothing set, default is page 1
		//$page = isset($_POST['page']) ? $_POST['page'] : 1;
		
		// set records or rows of data per page
		//$cards_to_display = isset($_POST['cards_to_display']) ? $_POST['cards_to_display'] : 6;
		
		// set records or rows of data per page
		$records_per_page = (int)$records_to_display;
		
		// calculate for the query LIMIT clause
		$from_record_num = ($records_per_page * $page) - $records_per_page;
		 
		//$total_rows = $this->count_search_extensions($campus_id, $department_id, $extension_number, $txtdepartment_id, $txtowner_assigned);
		 
		// select data for current page
		
		
		/*SEARCH SENARIOS
			1. all items are specified.
			2. other params only typed.
			3. campus only selected.			
			4. department only selected. 
			5. campus and department selected.		
			6. campus and other params typed.
			7. department and other params typed.
			8. no item is specified.		
		*/
		
		//all items are specified.
		if(!empty($campus_id) && !empty($department_id) && !empty($other_params))
		{
			$query = "SELECT * FROM tbl_extensions as extensions 
			INNER JOIN tbl_campuses as campuses ON extensions.campus_id = campuses.id 
			INNER JOIN tbl_departments as departments ON extensions.department_id = departments.id 
			WHERE (campuses.id = :campus_id AND departments.id = :department_id AND (departments.department_name LIKE :typed_department OR extensions.owner_assigned LIKE :owner_assigned OR extensions.extension_number LIKE :extension_number)) 
			ORDER BY campuses.id, departments.id, extensions.extension_number ASC 
			LIMIT :from_record_num, :records_per_page";
 
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			$stmt->bindParam(":campus_id", $campus_id, PDO::PARAM_STR);
			$stmt->bindParam(":department_id", $department_id, PDO::PARAM_STR);
			 
			$pattern  = '%' . $other_params . '%';
			
			$stmt->bindParam(":typed_department", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $other_params . '%';
			
			$stmt->bindParam(":owner_assigned", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $other_params . '%';
			
			$stmt->bindParam(":extension_number", $pattern, PDO::PARAM_STR);
				
			
			$count_query = "SELECT * FROM tbl_extensions as extensions 
			INNER JOIN tbl_campuses as campuses ON extensions.campus_id = campuses.id 
			INNER JOIN tbl_departments as departments ON extensions.department_id = departments.id 
			WHERE (campuses.id = :campus_id AND departments.id = :department_id AND (departments.department_name LIKE :typed_department OR extensions.owner_assigned LIKE :owner_assigned OR extensions.extension_number LIKE :extension_number))  
			ORDER BY campuses.id, departments.id, extensions.extension_number ASC";
			
			$count_stmt = $this->db->prepare($count_query);
			 
			$count_stmt->bindParam(":campus_id", $campus_id, PDO::PARAM_STR);
			$count_stmt->bindParam(":department_id", $department_id, PDO::PARAM_STR);
			 
			$pattern  = '%' . $other_params . '%';
			
			$count_stmt->bindParam(":typed_department", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $other_params . '%';
			
			$count_stmt->bindParam(":owner_assigned", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $other_params . '%';
			
			$count_stmt->bindParam(":extension_number", $pattern, PDO::PARAM_STR);
				
		}
		//other params only typed.
		else if(empty($campus_id) && empty($department_id) && !empty($other_params))
		{
			$query = "SELECT * FROM tbl_extensions as extensions  
			INNER JOIN tbl_departments as departments ON extensions.department_id = departments.id 
			WHERE (departments.department_name LIKE :typed_department OR extensions.owner_assigned LIKE :owner_assigned OR extensions.extension_number LIKE :extension_number) 
			ORDER BY departments.department_name, extensions.owner_assigned, extensions.extension_number ASC 
			LIMIT :from_record_num, :records_per_page";
						
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			 
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			$pattern  = '%' . $other_params . '%';
			
			$stmt->bindParam(":typed_department", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $other_params . '%';
			
			$stmt->bindParam(":owner_assigned", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $other_params . '%';
			
			$stmt->bindParam(":extension_number", $pattern, PDO::PARAM_STR);

			
			$count_query = "SELECT * FROM tbl_extensions as extensions  
			INNER JOIN tbl_departments as departments ON extensions.department_id = departments.id 
			WHERE (departments.department_name LIKE :typed_department OR extensions.owner_assigned LIKE :owner_assigned OR extensions.extension_number LIKE :extension_number)  
			ORDER BY departments.department_name, extensions.owner_assigned, extensions.extension_number ASC";
			
			$count_stmt = $this->db->prepare($count_query);
			  
			$pattern  = '%' . $other_params . '%';
			
			$count_stmt->bindParam(":typed_department", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $other_params . '%';
			
			$count_stmt->bindParam(":owner_assigned", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $other_params . '%';
			
			$count_stmt->bindParam(":extension_number", $pattern, PDO::PARAM_STR);
				
		} 
		//campus only selected.
		else if(!empty($campus_id) && empty($department_id) && empty($other_params))
		{				
			$query = "SELECT * FROM tbl_extensions as extensions 
			INNER JOIN tbl_campuses as campuses ON extensions.campus_id = campuses.id  
			WHERE (campuses.id = :campus_id) 
			ORDER BY campuses.campus_name ASC 
			LIMIT :from_record_num, :records_per_page";
 
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			$stmt->bindParam(":campus_id", $campus_id, PDO::PARAM_STR);
			
			
			$count_query = "SELECT * FROM tbl_extensions as extensions 
			INNER JOIN tbl_campuses as campuses ON extensions.campus_id = campuses.id  
			WHERE (campuses.id = :campus_id) 
			ORDER BY campuses.campus_name ASC";
			
			$count_stmt = $this->db->prepare($count_query);
			 
			$count_stmt->bindParam(":campus_id", $campus_id, PDO::PARAM_STR);
					
		} 
		//department only selected.
		else if(empty($campus_id) && !empty($department_id) && empty($other_params))
		{
			$query = "SELECT * FROM tbl_extensions as extensions  
			INNER JOIN tbl_departments as departments ON extensions.department_id = departments.id 
			WHERE (departments.id = :department_id) 
			ORDER BY departments.department_name ASC 
			LIMIT :from_record_num, :records_per_page";
 
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			 
			$stmt->bindParam(":department_id", $department_id, PDO::PARAM_STR);
			  
			
			$count_query = "SELECT * FROM tbl_extensions as extensions  
			INNER JOIN tbl_departments as departments ON extensions.department_id = departments.id 
			WHERE (departments.department_name = :department_id) 
			ORDER BY departments.id ASC";
			
			$count_stmt = $this->db->prepare($count_query);
			  
			$count_stmt->bindParam(":department_id", $department_id, PDO::PARAM_STR);
			 				
		} 
		//campus and department selected.
		else if(!empty($campus_id) && !empty($department_id) && empty($other_params))
		{				
			$query = "SELECT * FROM tbl_extensions as extensions 
			INNER JOIN tbl_campuses as campuses ON extensions.campus_id = campuses.id 
			INNER JOIN tbl_departments as departments ON extensions.department_id = departments.id 
			WHERE (campuses.id = :campus_id AND departments.id = :department_id) 
			ORDER BY campuses.campus_name, departments.department_name ASC 
			LIMIT :from_record_num, :records_per_page";
 
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			$stmt->bindParam(":campus_id", $campus_id, PDO::PARAM_STR);
			$stmt->bindParam(":department_id", $department_id, PDO::PARAM_STR);
			  
			
			$count_query = "SELECT * FROM tbl_extensions as extensions 
			INNER JOIN tbl_campuses as campuses ON extensions.campus_id = campuses.id 
			INNER JOIN tbl_departments as departments ON extensions.department_id = departments.id 
			WHERE (campuses.id = :campus_id AND departments.id = :department_id) 
			ORDER BY campuses.campus_name, departments.department_name ASC";
			
			$count_stmt = $this->db->prepare($count_query);
			 
			$count_stmt->bindParam(":campus_id", $campus_id, PDO::PARAM_STR);
			$count_stmt->bindParam(":department_id", $department_id, PDO::PARAM_STR);
			  
		}
		//campus and other_params typed.
		else if(!empty($campus_id) && empty($department_id) && !empty($other_params))
		{				
			$query = "SELECT * FROM tbl_extensions as extensions 
			INNER JOIN tbl_campuses as campuses ON extensions.campus_id = campuses.id 
			INNER JOIN tbl_departments as departments ON extensions.department_id = departments.id 
			WHERE (campuses.id = :campus_id AND (departments.department_name LIKE :typed_department OR extensions.owner_assigned LIKE :owner_assigned OR extensions.extension_number LIKE :extension_number))  
			ORDER BY campuses.campus_name, extensions.extension_number ASC 
			LIMIT :from_record_num, :records_per_page";
 
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			$stmt->bindParam(":campus_id", $campus_id, PDO::PARAM_STR); 
			 
			$pattern  = '%' . $other_params . '%';
			
			$stmt->bindParam(":typed_department", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $other_params . '%';
			
			$stmt->bindParam(":owner_assigned", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $other_params . '%';
			
			$stmt->bindParam(":extension_number", $pattern, PDO::PARAM_STR);
				
			
			$count_query = "SELECT * FROM tbl_extensions as extensions 
			INNER JOIN tbl_campuses as campuses ON extensions.campus_id = campuses.id 
			INNER JOIN tbl_departments as departments ON extensions.department_id = departments.id 
			WHERE (campuses.id = :campus_id AND (departments.department_name LIKE :typed_department OR extensions.owner_assigned LIKE :owner_assigned OR extensions.extension_number LIKE :extension_number))   
			ORDER BY campuses.campus_name, extensions.extension_number ASC";
			
			$count_stmt = $this->db->prepare($count_query);
			 
			$count_stmt->bindParam(":campus_id", $campus_id, PDO::PARAM_STR); 
			 
			$pattern  = '%' . $other_params . '%';
			
			$count_stmt->bindParam(":typed_department", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $other_params . '%';
			
			$count_stmt->bindParam(":owner_assigned", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $other_params . '%';
			
			$count_stmt->bindParam(":extension_number", $pattern, PDO::PARAM_STR);
				
		}
		//department and other_params typed.
		else if(empty($campus_id) && !empty($department_id) && !empty($other_params))
		{				
			$query = "SELECT * FROM tbl_extensions as extensions 
			INNER JOIN tbl_departments as departments ON extensions.department_id = departments.id 
			WHERE (departments.id = :department_id AND (departments.department_name LIKE :typed_department OR extensions.owner_assigned LIKE :owner_assigned OR extensions.extension_number LIKE :extension_number))  
			ORDER BY departments.department_name, extensions.extension_number ASC 
			LIMIT :from_record_num, :records_per_page";
 
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			 
			$stmt->bindParam(":department_id", $department_id, PDO::PARAM_STR);
			 
			$pattern  = '%' . $other_params . '%';
			
			$stmt->bindParam(":typed_department", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $other_params . '%';
			
			$stmt->bindParam(":owner_assigned", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $other_params . '%';
			
			$stmt->bindParam(":extension_number", $pattern, PDO::PARAM_STR);
				
			
			$count_query = "SELECT * FROM tbl_extensions as extensions 
			INNER JOIN tbl_departments as departments ON extensions.department_id = departments.id 
			WHERE (departments.id = :department_id AND (departments.department_name LIKE :typed_department OR extensions.owner_assigned LIKE :owner_assigned OR extensions.extension_number LIKE :extension_number))  
			ORDER BY departments.department_name, extensions.extension_number ASC";
			
			$count_stmt = $this->db->prepare($count_query);
			  
			$count_stmt->bindParam(":department_id", $department_id, PDO::PARAM_STR);
			 
			$pattern  = '%' . $other_params . '%';
			
			$count_stmt->bindParam(":typed_department", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $other_params . '%';
			
			$count_stmt->bindParam(":owner_assigned", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $other_params . '%';
			
			$count_stmt->bindParam(":extension_number", $pattern, PDO::PARAM_STR);
				
		}  
		//no item is specified.
		else if(empty($campus_id) && empty($department_id) && empty($other_params))
		{				
			$query = "SELECT * FROM tbl_extensions 
			ORDER BY id ASC 
			LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			

			$count_query = "SELECT * FROM tbl_extensions 
			ORDER BY id ASC";
			
			$count_stmt = $this->db->prepare($count_query);
			  
		}
		else
		{ 
			$_SESSION['extensions_count'] = 0;
			return;
		}

		$stmt->execute();
			
		$count_stmt->execute();
				 
		// this is how to get number of rows returned
		$num = $stmt->rowCount();
		
		$count_num = $count_stmt->rowCount();
		
		$_SESSION['extensions_count'] = $count_num;
 
		//echo $num;
		// link to create record form
		//echo "<a href='create.php' class='btn btn-primary m-b-1em'>Create New Product</a>";
		 
		//check if more than 0 record found
		if($num>0){
		 
			// data from database will be here
			echo "<table class='table table-dark table-striped table-hover table-bordered table-sm' id='table_extensions'>";//start table

			//creating our table heading
			echo "<thead class='thead-dark'>";
			echo "<tr>"; 
				echo "<th scope='col'>Campus</th>";
				echo "<th scope='col'>Department</th>";  
				echo "<th scope='col'>Owner Assigned</th>";
				echo "<th scope='col'>Extension No</th>";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			
			// table body will be here
			// retrieve our table contents
			// fetch() is faster than fetchAll()
			// http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
			 
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				 
				// extract row
				// this will make $row['firstname'] to
				// just $firstname only
				extract($row);
				 					
				$id = $row['id'];
				$campus_id = $row['campus_id'];
				$department_id = $row['department_id'];
				$owner_assigned = $row['owner_assigned'];
				$extension_number = $row['extension_number'];

				$campus_name = $this->get_campus_name_given_id($campus_id);
				$department_name = $this->get_department_name_given_id($department_id);
				 
				// creating new table row per record
				echo "<tr class='table-primary'>";
					 
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($campus_name, ENT_QUOTES);

				echo "</td>";
					
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($department_name, ENT_QUOTES);

				echo "</td>";
			 
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($owner_assigned, ENT_QUOTES);

				echo "</td>";
					
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($extension_number, ENT_QUOTES);

				echo "</td>";
			 
				echo "<td class='table-success'>";
					
				echo "<a onClick='edit_extension({$id})' style='cursor:hand !important;' 
				class='btn btn-info m-r-1em crud_buttons btn_edit btn_edit_extension' 
				title='edit'  
				data-id='{$id}' 
				data-toggle='popover' 
				data-placement='auto' 
				data-trigger='hover' 
				data-content='edit extension' >
				edit
					<span class='glyphicon'>
					</span>
				</a>";
								
				echo "<a onClick='delete_extension({$id})' style='cursor:hand !important;' 
				class='btn btn-danger m-r-1em crud_buttons btn_delete btn_delete_extension' 
				title='delete'  
				data-id='{$id}' 
				data-toggle='popover' 
				data-placement='auto' 
				data-trigger='hover' 
				data-content='delete extension' >
				delete
					<span class='glyphicon'>
					</span>
				</a>";
				
				echo "</td>";
			  			
				echo "</tr>";
				
			} 

			echo "</tbody>";
			
			echo "<tfoot>";
			
			echo "</tfoot>";
			
			// end table
			echo "</table>";
			
			// PAGINATION
			// count total number of rows
			// $query = "SELECT COUNT(*) as total_rows FROM tbl_extensions";
			// $stmt = $this->db->prepare($query);
			 
			// // execute query
			// $stmt->execute();
			 
			// // get total rows
			// $row = $stmt->fetch(PDO::FETCH_ASSOC);
			// $total_rows = $row['total_rows'];
			
			//$total_rows = $this->count_search_extensions($campus_code, $department, $extension_number);
			
			// paginate records
			$page_url="extensions.php?";
			include_once "paging_search_extensions_table.php";
		}
		 
		// if no records found
		else{
			echo "<div class='alert alert-danger'>No records found.</div>";
		}
	}
 
 
 




}

?>
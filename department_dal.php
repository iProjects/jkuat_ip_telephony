
<?php
/* Quick description on library file structure:

– Database – At the very top of the file we are using our database connection file that we are going to need through the library.

– CRUD: Class name which is having our methods collection.

– __construct() and destruct() method to initiate our database connection variable.
 
– create_department() : Used to create an department record in database.
 
– get_user_role() : Use to get authenticate user role.
 */
 session_start();
 
require 'database.php';
		 
class department_dal
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
	 * @param $department_name
	 * @param $addedby 
	 
     * @return $string
     * */
	public function create_department($department_name, $campus_id, $addedby)
    {
		try{
			
			$is_department_name = $this->check_if_department_for_campus_exists($department_name, $campus_id);
			$campus_name = $this->get_campus_name_given_id($campus_id);
			 
			if(!empty($is_department_name))
			{
				$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>Department  [ ' . $department_name . ' ] for Campus [ ' . $campus_name . ' ] exists.</div>';
				return $response;
			}
			
			// insert query
			$query = "INSERT INTO tbl_departments( 
			campus_id, 
			department_name, 
			status, 
			created_date, 
			addedby) 
			VALUES( 
			:campus_id,
			:department_name,
			:status,
			:created_date,			
			:addedby)";
			
			// prepare query for execution
			$stmt = $this->db->prepare($query);
			
			// bind the parameters 
			$department_name = ucwords($department_name);
			$stmt->bindParam(":campus_id", $campus_id, PDO::PARAM_STR);
			$stmt->bindParam(":department_name", $department_name, PDO::PARAM_STR);
			$status = "active";
			$stmt->bindParam(":status", $status, PDO::PARAM_STR); 
			$created_date = date('d-m-Y h:i:s A');
			$stmt->bindParam(":created_date", $created_date, PDO::PARAM_STR); 
			$stmt->bindParam(":addedby", $addedby, PDO::PARAM_STR); 
			
			// Execute the query
			$stmt->execute();
			
			// save lastInsertId in a variable
			$lastInsertId = $this->db->lastInsertId();
			
			$response = "<div class='alert alert-success'>Department  [ ' . $department_name . ' ] for Campus [ ' . $campus_name . ' ] was successfully created. <br /> Last Insert Id = [ " . $lastInsertId . " ]</div>";
			return $response;
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }

    /*
     * Get department Details
     *
     * @param $department_name
     * */
    public function check_if_department_for_campus_exists($department_name, $campus_id)
    {
		try{
			// select query
			$query = "SELECT * FROM tbl_departments 
			WHERE department_name = :department_name AND campus_id = :campus_id";

			// prepare query for execution			
			$stmt = $this->db->prepare($query);

			// bind the parameters
			$stmt->bindParam(":department_name", $department_name, PDO::PARAM_STR);
			$stmt->bindParam(":campus_id", $campus_id, PDO::PARAM_STR);

			// Execute the query
			$stmt->execute();
			
			$arr = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if (!$arr) {
				// array is empty.
				return null;
			}

			extract($arr); 
			
			return $department_name;		
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }
	
    /*
     * Update Record
     * 
	 * @param $department_name 
	 * @param $id 

     * @return $mixed
     * */
    public function update_department($department_name, $campus_id, $id)
    {
		try{
			// Update query
			$query = "UPDATE tbl_departments SET 
			campus_id = :campus_id, 
			department_name = :department_name  
			WHERE id = :id";
			
			// prepare query for execution
			$stmt = $this->db->prepare($query);
			
			// bind the parameters 
			$department_name = ucwords($department_name);
			$stmt->bindParam(":campus_id", $campus_id, PDO::PARAM_STR); 
			$stmt->bindParam(":department_name", $department_name, PDO::PARAM_STR); 
			$stmt->bindParam(":id", $id, PDO::PARAM_STR);
			
			// Execute the query
			$stmt->execute();
 
 			$campus_name = $this->get_campus_name_given_id($campus_id);

			$response = "<div class='alert alert-success'>Department  [ ' . $department_name . ' ] for Campus [ ' . $campus_name . ' ] was successfully updated.</div>";
			
			return $response;
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }

    /*
     * Get department Details
     *
     * @param $id
     * */
    public function get_department($id)
    {
		try{
			// select query
			$query = "SELECT * FROM tbl_departments 
			WHERE id = :id";
			
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
     * Get department Details
     *
     * @param $id
     * */
    public function fetch_department($id)
    {
		try{
			// select query
			$query = "SELECT * FROM tbl_departments 
			WHERE id = :id";
			
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
     * Read all department records
     *
     * @return $mixed
     * */
    public function get_all_departments_arr()
    {
		try{
			// select query - select all data
			$query = "SELECT * FROM tbl_departments 
			ORDER BY id DESC";

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
    public function delete_department($id)
    {
		try{
			
			$department_record = $this->fetch_department($id);
			 
			foreach ($department_record as $key => $value) {
				if($key == "department_name") {
					$department_name = $value; 
				} 
				if($key == "campus_id") {
					$campus_id = $value; 
				} 
			}
			
			// delete query
			$query = "DELETE FROM tbl_departments WHERE id = :id";

			// prepare query for execution
			$stmt = $this->db->prepare($query);

			// bind the parameters
			$stmt->bindParam(":id", $id, PDO::PARAM_STR);

			// Execute the query
			$stmt->execute();
			
			$campus_name = $this->get_campus_name_given_id($campus_id);

			$response = "<div class='alert alert-success'>Department  [ ' . $department_name . ' ] for Campus [ ' . $campus_name . ' ] was successfully deleted.</div>";
			return $response;
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }
  

    /*
     * Read all department records
     *
     * @return $mixed
     * */
    public function get_all_departments()
    {
		try{
			// select query - select all data
			$query = "SELECT * FROM tbl_departments 
			ORDER BY id DESC";

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
     * Read all department names
     *
     * @return $mixed
     * */
    public function get_department_names()
    {
		try{
			// select query - select all data
			$query = "SELECT DISTINCT department_name FROM tbl_departments 
			ORDER BY department_name ASC";

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
	
	public function search_departments_v2($page, $records_to_display, $department_name, $campus_name)
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
		 
		//$total_rows = $this->count_search_departments($department_code, $department, $extension_number);
		 
		// select data for current page
		
		/*SEARCH SENARIOS 
			1. all items are specified.		
			2. department only typed.		
			3. campus only typed.		 
			4. no item is specified.		
		*/
		 
		//all items are specified.
		if(!empty($department_name) && !empty($campus_name))
		{
			$query = "SELECT * FROM tbl_departments as departments 
			INNER JOIN tbl_campuses as campuses ON departments.campus_id = campuses.id 
			WHERE (departments.department_name LIKE :department_name AND campuses.campus_name LIKE :campus_name) 
			ORDER BY departments.department_name, campuses.campus_name ASC 
			LIMIT :from_record_num, :records_per_page";
						
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			  
			$pattern  = '%' . $department_name . '%';
			
			$stmt->bindParam(":department_name", $pattern, PDO::PARAM_STR);
			
			$pattern  = '%' . $campus_name . '%';
			
			$stmt->bindParam(":campus_name", $pattern, PDO::PARAM_STR);
			
			
			$count_query = "SELECT * FROM tbl_departments as departments
			INNER JOIN tbl_campuses as campuses ON departments.campus_id = campuses.id
			WHERE (departments.department_name LIKE :department_name AND campuses.campus_name LIKE :campus_name)
			ORDER BY departments.department_name, campuses.campus_name ASC";
			
			$count_stmt = $this->db->prepare($count_query);
			  
			$pattern  = '%' . $department_name . '%';
			
			$count_stmt->bindParam(":department_name", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $campus_name . '%';
			
			$count_stmt->bindParam(":campus_name", $pattern, PDO::PARAM_STR);
			
		} 
		//department only typed.
		else if(!empty($department_name) && empty($campus_name))
		{
			$query = "SELECT * FROM tbl_departments 
			WHERE department_name LIKE :department_name 
			ORDER BY department_name ASC 
			LIMIT :from_record_num, :records_per_page";
						
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			  
			$pattern  = '%' . $department_name . '%';
			
			$stmt->bindParam(":department_name", $pattern, PDO::PARAM_STR);
			
			
			$count_query = "SELECT * FROM tbl_departments 
			WHERE department_name LIKE :department_name 
			ORDER BY department_name ASC";
			
			$count_stmt = $this->db->prepare($count_query);
			  
			$pattern  = '%' . $department_name . '%';
			
			$count_stmt->bindParam(":department_name", $pattern, PDO::PARAM_STR);
				
		} 
		//campus only typed.
		else if(empty($department_name) && !empty($campus_name))
		{
			$query = "SELECT * FROM tbl_departments as departments 
			INNER JOIN tbl_campuses as campuses ON departments.campus_id = campuses.id 
			WHERE (campuses.campus_name LIKE :campus_name) 
			ORDER BY campuses.campus_name ASC  
			LIMIT :from_record_num, :records_per_page";
						
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			  
			$pattern  = '%' . $campus_name . '%';
			
			$stmt->bindParam(":campus_name", $pattern, PDO::PARAM_STR);
			
			
			$count_query = "SELECT * FROM tbl_departments as departments 
			INNER JOIN tbl_campuses as campuses ON departments.campus_id = campuses.id 
			WHERE (campuses.campus_name LIKE :campus_name) 
			ORDER BY campuses.campus_name ASC";
			
			$count_stmt = $this->db->prepare($count_query);
			  
			$pattern  = '%' . $campus_name . '%';
			
			$count_stmt->bindParam(":campus_name", $pattern, PDO::PARAM_STR);
				
		}  
		//no item is specified.
		else if(empty($department_name) && empty($campus_name))
		{				
			$query = "SELECT * FROM tbl_departments 
			ORDER BY id DESC 
			LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			
			$count_query = "SELECT * FROM tbl_departments 
			ORDER BY id DESC";
			
			$count_stmt = $this->db->prepare($count_query);
			  
		}
		else
		{ 
			$_SESSION['departments_count'] = 0;
			return;
		}
 
		$stmt->execute();
			
		$count_stmt->execute();
				 
		// this is how to get number of rows returned
		$num = $stmt->rowCount();
		
		$count_num = $count_stmt->rowCount();
		
		$_SESSION['departments_count'] = $count_num;

		//echo $num;
		// link to create record form
		//echo "<a href='create.php' class='btn btn-primary m-b-1em'>Create New Product</a>";
		 
		//check if more than 0 record found
		if($num>0){
		 
			// data from database will be here
			echo "<table class='table table-dark table-striped table-hover table-bordered table-sm' id='table_departments'>";//start table

			//creating our table heading
			echo "<thead class='thead-dark'>";
			echo "<tr>";
				echo "<th scope='col'>#</th>"; 
				echo "<th scope='col'>Campus</th>"; 
				echo "<th scope='col'>Name</th>"; 				
				echo "<th scope='col'>Status</th>"; 
				echo "<th scope='col'>Created Date</th>"; 
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
				$department_name = $row['department_name'];
				$campus_id = $row['campus_id'];
				$status = $row['status'];
				$created_date = $row['created_date']; 
				$addedby = $row['addedby']; 

 				$campus_name = $this->get_campus_name_given_id($campus_id);

				// creating new table row per record
				echo "<tr class='table-primary'>";
					
				echo "<td class='table-success'>";
								
				echo htmlspecialchars($id, ENT_QUOTES);
			
				echo "</td>";
			  
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($campus_name, ENT_QUOTES);

				echo "</td>";
			  
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($department_name, ENT_QUOTES);

				echo "</td>";
			  
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($status, ENT_QUOTES);

				echo "</td>"; 
			 
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($created_date, ENT_QUOTES);

				echo "</td>"; 
			 
				echo "<td class='table-success'>";
					
				echo "<a onClick='edit_department({$id})' style='cursor:hand !important;' 
				class='btn btn-info m-r-1em crud_buttons btn_edit btn_edit_department' 
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
								
				echo "<a onClick='delete_department({$id})' style='cursor:hand !important;' 
				class='btn btn-danger m-r-1em crud_buttons btn_delete btn_delete_department' 
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
			// $query = "SELECT COUNT(*) as total_rows FROM tbl_departments";
			// $stmt = $this->db->prepare($query);
			 
			// // execute query
			// $stmt->execute();
			 
			// // get total rows
			// $row = $stmt->fetch(PDO::FETCH_ASSOC);
			// $total_rows = $row['total_rows'];
			
			//$total_rows = $this->count_search_departments($department_code, $department, $extension_number);
			
			// paginate records
			$page_url="departments.php?";
			include_once "paging_search_departments_table.php";
		}
		 
		// if no records found
		else{
			echo "<div class='alert alert-danger'>No records found.</div>";
		}
	}
 
 
 




}

?>
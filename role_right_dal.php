
<?php
/* Quick description on library file structure:

– Database – At the very top of the file we are using our database connection file that we are going to need through the library.

– CRUD: Class name which is having our methods collection.

– __construct() and destruct() method to initiate our database connection variable.
 
– create_role_right() : Used to create an role_right record in database.
 
– get_role_right() : Use to get authenticate role_right role_right.
 */
 session_start();
 
require 'database.php';
		 
class role_right_dal
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
	 * @param $role_id 
	 * @param $right_id 
	 * @param $allowed 
	 * @param $status 
	 * @param $addedby 
	 *
     * @return $string
     * */
	public function create_role_right($role_id, $right_id, $allowed, $status, $addedby)
    {
		try{
			
			$is_role_right = $this->check_if_role_right_exists($role_id, $right_id);
						
			$role_name = $this->get_role_name_given_role_id($role_id);
			$right_name = $this->get_right_name_given_right_id($right_id);

			if($is_role_right)
			{
				$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>Right [ ' . $right_name . ' ] for Role [ ' . $role_name . ' ] exists.</div>';
				return $response;
			}
			 
			// insert query
			$query = "INSERT INTO tbl_roles_rights(
			role_id, 
			right_id, 
			allowed, 			
			addedby,  
			status, 			
			created_date) 
			VALUES(
			:role_id,  
			:right_id, 
			:allowed,  
			:addedby,  
			:status,			
			:created_date)";
			
			// prepare query for execution
			$stmt = $this->db->prepare($query);
			
			// bind the parameters
			$stmt->bindParam(":role_id", $role_id, PDO::PARAM_STR); 
			$stmt->bindParam(":right_id", $right_id, PDO::PARAM_STR); 
			$stmt->bindParam(":allowed", $allowed, PDO::PARAM_INT); 
			$stmt->bindParam(":addedby", $addedby, PDO::PARAM_STR);  
			$stmt->bindParam(":status", $status, PDO::PARAM_STR); 
			$created_date = date('d-m-Y h:i:s A');
			$stmt->bindParam(":created_date", $created_date, PDO::PARAM_STR);  
			
			// Execute the query
			$stmt->execute();
			
			// save lastInsertId in a variable
			$lastInsertId = $this->db->lastInsertId();
			
			$response = "<div class='alert alert-success'>Right [ " . $right_name . " ] for Role [ " . $role_name . " ] was successfully created. <br />Last Insert Id = [ " . $lastInsertId . " ]</div>";
			return $response;
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }

    /*
     * Get role_right Details
     *
     * @param $role_id 
	 * @param $right_id 
	 *
     * */
    public function check_if_role_right_exists($role_id, $right_id)
    {
		try{
			// select query
			$query = "SELECT * FROM tbl_roles_rights 
			WHERE role_id = :role_id AND right_id = :right_id";

			// prepare query for execution			
			$stmt = $this->db->prepare($query);

			// bind the parameters
			$stmt->bindParam(":role_id", $role_id, PDO::PARAM_STR);
			$stmt->bindParam(":right_id", $right_id, PDO::PARAM_STR);

			// Execute the query
			$stmt->execute();
			
			$arr = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if (!$arr) {
				// array is empty.
				return null;
			}

			extract($arr); 
			
			return $arr;		
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }
	 
    /*
     * Update Record
     *
	 * @param $role_id 
	 * @param $right_id 
	 * @param $status 
	 * @param $id 
	 *
     * @return $mixed
     * */
    public function update_role_right($role_id, $right_id, $status, $id)
    {
		try{
			// Update query
			$query = "UPDATE tbl_roles_rights SET 
			role_id = :role_id,
			right_id = :right_id, 
			status = :status      			
			WHERE id = :id";
			
			// prepare query for execution
			$stmt = $this->db->prepare($query);
			
			// bind the parameters
			$stmt->bindParam(":role_id", $role_id, PDO::PARAM_STR); 
			$stmt->bindParam(":right_id", $right_id, PDO::PARAM_STR); 
			$stmt->bindParam(":status", $status, PDO::PARAM_STR); 
			$stmt->bindParam(":id", $id, PDO::PARAM_STR);
			
			// Execute the query
			$stmt->execute();

			$role_name = $this->get_role_name_given_role_id($role_id);
			$right_name = $this->get_right_name_given_right_id($right_id);

			$response = "<div class='alert alert-success'>Right [ " . $right_name . " ] for Role [ " . $role_name . " ] was successfully updated.</div>";
			
			return $response;
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }

    /*
     * Get role_right Details
     *
     * @param $id
     * */
    public function get_role_right($id)
    {
		try{
			// select query
			$query = "SELECT * FROM tbl_roles_rights 
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
     * Get role_right Details
     *
     * @param $id
     * */
    public function fetch_role_right($id)
    {
		try{
			// select query
			$query = "SELECT * FROM tbl_roles_rights 
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
     * Read all role_right records
     *
     * @return $mixed
     * */
    public function get_all_role_rights_arr()
    {
		try{
			// select query - select all data
			$query = "SELECT * FROM tbl_roles_rights 
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
    public function delete_role_right($id)
    {
		try{
			
			$role_right_record = $this->fetch_role_right($id);
			 
			foreach ($role_right_record as $key => $value) {
				if($key == "role_id") {
					$role_id = $value; 
				} 
				if($key == "right_id") {
					$right_id = $value; 
				}  
			}
			
			$role_name = $this->get_role_name_given_role_id($role_id);
			$right_name = $this->get_right_name_given_right_id($right_id);

			if($role_id == 1)
			{
				$response = "<div class='alert alert-danger'>Cannot delete Rights for Role [ " . $role_name . " ].</div>";		
				return $response;			
			}

			// delete query
			$query = "DELETE FROM tbl_roles_rights 
			WHERE id = :id";

			// prepare query for execution
			$stmt = $this->db->prepare($query);

			// bind the parameters
			$stmt->bindParam(":id", $id, PDO::PARAM_STR);

			// Execute the query
			$stmt->execute();
			
			$response = "<div class='alert alert-success'>Right [ " . $right_name . " ] for Role [ " . $role_name . " ] was successfully deleted.</div>";
			
			return $response;
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }

    /*
     * Get role Details
     *
     * @param $role_id
     * */
    public function get_role_name_given_role_id($role_id)
    {
		try{
			// select query
			$query = "SELECT role_name FROM tbl_roles 
			WHERE id = :role_id";

			// prepare query for execution			
			$stmt = $this->db->prepare($query);

			// bind the parameters
			$stmt->bindParam(":role_id", $role_id, PDO::PARAM_STR);

			// Execute the query
			$stmt->execute();

			// return retrieved row as a json object
			$role_name = $stmt->fetch(PDO::FETCH_ASSOC);
			
			return $role_name["role_name"];
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }
	
    /*
     * Get right Details
     *
     * @param $right_id
     * */
    public function get_right_name_given_right_id($right_id)
    {
		try{
			// select query
			$query = "SELECT right_name FROM tbl_rights 
			WHERE id = :right_id";

			// prepare query for execution			
			$stmt = $this->db->prepare($query);

			// bind the parameters
			$stmt->bindParam(":right_id", $right_id, PDO::PARAM_STR);

			// Execute the query
			$stmt->execute();

			// return retrieved row as a json object
			$right_name = $stmt->fetch(PDO::FETCH_ASSOC);
			
			return $right_name["right_name"];
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }
	 

    /*
     * Read all role_right records
     *
     * @return $mixed
     * */
    public function get_all_role_rights()
    {
		try{
			// select query - select all data
			$query = "SELECT * FROM tbl_roles_rights 
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
    
	public function search_roles_rights_v2($page, $records_to_display, $role_name, $right_name)
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
		 
		//$total_rows = $this->count_search_role_rights($role_right_code, $department, $extension_number);
		 
		// select data for current page
		
		/*SEARCH SENARIOS
			1. all items are specified. 
			2. role name typed. 	
			3. right name typed. 			
			4. no item is specified.		
		*/
		 
		//all items are specified.
		if(!empty($role_name) && !empty($right_name))
		{
			$query = "SELECT * FROM tbl_roles_rights 
			INNER JOIN tbl_roles ON tbl_roles_rights.role_id = tbl_roles.id 
			INNER JOIN tbl_rights ON tbl_roles_rights.right_id = tbl_rights.id 
			WHERE (role_name LIKE :role_name AND right_name LIKE :right_name) 
			ORDER BY tbl_roles.role_name, tbl_rights.right_name ASC 
			LIMIT :from_record_num, :records_per_page";
						
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			 
			$pattern  = '%' . $role_name . '%';
			
			$stmt->bindParam(":role_name", $pattern, PDO::PARAM_STR);
				 
			$pattern  = '%' . $right_name . '%';
			
			$stmt->bindParam(":right_name", $pattern, PDO::PARAM_STR);
				 
			
			$count_query = "SELECT * FROM tbl_roles_rights 
			INNER JOIN tbl_roles ON tbl_roles_rights.role_id = tbl_roles.id 
			INNER JOIN tbl_rights ON tbl_roles_rights.right_id = tbl_rights.id 
			WHERE (role_name LIKE :role_name AND right_name LIKE :right_name) 
			ORDER BY tbl_roles.role_name, tbl_rights.right_name ASC";
			
			$count_stmt = $this->db->prepare($count_query);
			  
			$pattern  = '%' . $role_name . '%';
			
			$count_stmt->bindParam(":role_name", $pattern, PDO::PARAM_STR);
				 
			$pattern  = '%' . $right_name . '%';
			
			$count_stmt->bindParam(":right_name", $pattern, PDO::PARAM_STR);
				 
		} 
		//role name typed.
		else if(!empty($role_name) && empty($right_name))
		{				
			$query = "SELECT * FROM tbl_roles_rights 
			INNER JOIN tbl_roles ON tbl_roles_rights.role_id = tbl_roles.id 
			WHERE (role_name LIKE :role_name) 
			ORDER BY tbl_roles.role_name ASC 
			LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			$pattern  = '%' . $role_name . '%';
			
			$stmt->bindParam(":role_name", $pattern, PDO::PARAM_STR);
				 
			
			$count_query = "SELECT * FROM tbl_roles_rights 
			INNER JOIN tbl_roles ON tbl_roles_rights.role_id = tbl_roles.id 
			WHERE (role_name LIKE :role_name) 
			ORDER BY tbl_roles.role_name ASC";
			
			$count_stmt = $this->db->prepare($count_query);
			  
			$pattern  = '%' . $role_name . '%';
			
			$count_stmt->bindParam(":role_name", $pattern, PDO::PARAM_STR);
				 
		}
		//right name typed.
		else if(empty($role_name) && !empty($right_name))
		{				
			$query = "SELECT * FROM tbl_roles_rights  
			INNER JOIN tbl_rights ON tbl_roles_rights.right_id = tbl_rights.id 
			WHERE (right_name LIKE :right_name) 
			ORDER BY tbl_rights.right_name ASC 
			LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			$pattern  = '%' . $right_name . '%';
			
			$stmt->bindParam(":right_name", $pattern, PDO::PARAM_STR);
				 
			
			$count_query = "SELECT * FROM tbl_roles_rights  
			INNER JOIN tbl_rights ON tbl_roles_rights.right_id = tbl_rights.id 
			WHERE (right_name LIKE :right_name) 
			ORDER BY tbl_rights.right_name ASC";
			
			$count_stmt = $this->db->prepare($count_query);
			  
			$pattern  = '%' . $right_name . '%';
			
			$count_stmt->bindParam(":right_name", $pattern, PDO::PARAM_STR);
			  
		}
		//no item is specified.
		else if(empty($role_name) && empty($right_name))
		{				
			$query = "SELECT * FROM tbl_roles_rights 
			ORDER BY id DESC 
			LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			
			$count_query = "SELECT * FROM tbl_roles_rights 
			ORDER BY id DESC";
			
			$count_stmt = $this->db->prepare($count_query);
			  
		}
		else
		{ 
			$_SESSION['roles_rights_count'] = 0;
			return;
		}

		$stmt->execute();
			
		$count_stmt->execute();
				 
		// this is how to get number of rows returned
		$num = $stmt->rowCount();
		
		$count_num = $count_stmt->rowCount();
		
		$_SESSION['roles_rights_count'] = $count_num;

		//echo $num;
		// link to create record form
		//echo "<a href='create.php' class='btn btn-primary m-b-1em'>Create New Product</a>";
		 
		//check if more than 0 record found
		if($num>0){
		 
			// data from database will be here
			echo "<table class='table table-dark table-striped table-hover table-bordered table-sm' id='table_roles_rights'>";//start table

			//creating our table heading
			echo "<thead class='thead-dark'>";
			echo "<tr>";
				echo "<th scope='col'>#</th>";
				echo "<th scope='col'>Role</th>"; 
				echo "<th scope='col'>Right</th>"; 
				echo "<th scope='col'>Allowed</th>"; 
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
				$role_id = $row['role_id']; 
				$right_id = $row['right_id']; 
				$status = $row['status'];
				$allowed = $row['allowed'];
				$created_date = $row['created_date']; 
  
				$role_name = $this->get_role_name_given_role_id($role_id);
				$right_name = $this->get_right_name_given_right_id($right_id);
				
				if($allowed)
				{
					$allowed_str = "Allowed";
				}else{
					$allowed_str = "Not Allowed";
				}

				// creating new table row per record
				echo "<tr class='table-primary'>";
					
				echo "<td class='table-success'>";
								
				echo htmlspecialchars($id, ENT_QUOTES);
			
				echo "</td>";
			 
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($role_name, ENT_QUOTES);

				echo "</td>";
					 
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($right_name, ENT_QUOTES);

				echo "</td>";
					 
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($allowed_str, ENT_QUOTES);

				echo "</td>"; 
			 
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($status, ENT_QUOTES);

				echo "</td>"; 
			 
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($created_date, ENT_QUOTES);

				echo "</td>"; 
			 
				echo "<td class='table-success'>";
				if($role_id == 1)
				{
					
				}else{
					echo "<a onClick='edit_role_right({$id})' style='cursor:hand !important;' 
					class='btn btn-info m-r-1em crud_buttons btn_edit btn_edit_role_right' 
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
									
					echo "<a onClick='delete_role_right({$id})' style='cursor:hand !important;' 
					class='btn btn-danger m-r-1em crud_buttons btn_delete btn_delete_role_right' 
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
				}
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
			// $query = "SELECT COUNT(*) as total_rows FROM tbl_roles_rights";
			// $stmt = $this->db->prepare($query);
			 
			// // execute query
			// $stmt->execute();
			 
			// // get total rows
			// $row = $stmt->fetch(PDO::FETCH_ASSOC);
			// $total_rows = $row['total_rows'];
			
			//$total_rows = $this->count_search_role_rights($role_right_code, $department, $extension_number);
			
			// paginate records
			$page_url="roles_rights.php?";
			include_once "paging_search_roles_rights_table.php";
		}
		 
		// if no records found
		else{
			echo "<div class='alert alert-danger'>No records found.</div>";
		}
	}
 
    /*
     * Read all rights records
     *
     * @return $mixed
     * */
    public function get_all_rights_arr()
    {
		try{
			// select query - select all data
			$query = "SELECT * FROM tbl_rights 
			WHERE status = :status 
			ORDER BY right_name ASC";

			// prepare query for execution	
			$stmt = $this->db->prepare($query);

			// bind the parameters 
			$status = "active";
			$stmt->bindParam(":status", $status, PDO::PARAM_STR); 

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
     * Read all roles records
     *
     * @return $mixed
     * */
    public function get_all_roles_arr()
    {
		try{
			// select query - select all data
			$query = "SELECT * FROM tbl_roles 
			WHERE status = :status 
			ORDER BY role_name ASC";

			// prepare query for execution	
			$stmt = $this->db->prepare($query);

			// bind the parameters 
			$status = "active";
			$stmt->bindParam(":status", $status, PDO::PARAM_STR); 

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

 
 




}

?>
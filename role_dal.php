
<?php
/* Quick description on library file structure:

– Database – At the very top of the file we are using our database connection file that we are going to need through the library.

– CRUD: Class name which is having our methods collection.

– __construct() and destruct() method to initiate our database connection variable.
 
– create_role() : Used to create an role record in database.
 
– get_role_role() : Use to get authenticate role role.
 */
 session_start();
 
require 'database.php';
		 
class role_dal
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
	 * @param $role_name 
	 
     * @return $string
     * */
	public function create_role($role_name, $addedby)
    {
		try{
			
			$is_role_name = $this->check_if_role_name_exists($role_name);
			 
			if(!empty($is_role_name))
			{
				$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>Role with Name [ ' . $role_name . ' ] exists.</div>';
				return $response;
			}
			 
			// insert query
			$query = "INSERT INTO tbl_roles(
			role_name,  
			addedby,  
			status, 			
			created_date) 
			VALUES(
			:role_name,  
			:addedby,  
			:status,			
			:created_date)";
			
			// prepare query for execution
			$stmt = $this->db->prepare($query);
			
			// bind the parameters
			$role_name = ucwords($role_name); 
			$stmt->bindParam(":role_name", $role_name, PDO::PARAM_STR); 
			$stmt->bindParam(":addedby", $addedby, PDO::PARAM_STR); 
			$status = "active";
			$stmt->bindParam(":status", $status, PDO::PARAM_STR); 
			$created_date = date('d-m-Y h:i:s A');
			$stmt->bindParam(":created_date", $created_date, PDO::PARAM_STR);  
			
			// Execute the query
			$stmt->execute();
			
			// save lastInsertId in a variable
			$lastInsertId = $this->db->lastInsertId();
			
			$response = "<div class='alert alert-success'>Role with Name [ " . $role_name . " ] was successfully created. <br />Last Insert Id = [ " . $lastInsertId . " ]</div>";
			return $response;
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }

    /*
     * Get role Details
     *
     * @param $role_name
     * */
    public function check_if_role_name_exists($role_name)
    {
		try{
			// select query
			$query = "SELECT * FROM tbl_roles WHERE role_name = :role_name";
			// prepare query for execution			
			$stmt = $this->db->prepare($query);
			// bind the parameters
			$stmt->bindParam(":role_name", $role_name, PDO::PARAM_STR);
			// Execute the query
			$stmt->execute();
			
			$arr = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if (!$arr) {
				// array is empty.
				return null;
			}

			extract($arr); 
			
			return $role_name;		
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }
	 
    /*
     * Update Record
     *
	 * @param $role_name 

     * @return $mixed
     * */
    public function update_role($role_name, $id)
    {
		try{
			// Update query
			$query = "UPDATE tbl_roles SET 
			role_name = :role_name 
			WHERE id = :id";
			
			// prepare query for execution
			$stmt = $this->db->prepare($query);
			
			// bind the parameters
			$role_name = ucwords($role_name); 
			$stmt->bindParam(":role_name", $role_name, PDO::PARAM_STR); 
			$stmt->bindParam(":id", $id, PDO::PARAM_STR);
			
			// Execute the query
			$stmt->execute();
 
			$response = "<div class='alert alert-success'>Role with Name [ " . $role_name . " ] was successfully updated.</div>";
			
			return $response;
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }

    /*
     * Get role Details
     *
     * @param $id
     * */
    public function get_role($id)
    {
		try{
			// select query
			$query = "SELECT * FROM tbl_roles WHERE id = :id";
			
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
     * Get role Details
     *
     * @param $id
     * */
    public function fetch_role($id)
    {
		try{
			// select query
			$query = "SELECT * FROM tbl_roles WHERE id = :id";
			
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
     * Read all role records
     *
     * @return $mixed
     * */
    public function get_all_roles_arr()
    {
		try{
			// select query - select all data
			$query = "SELECT * FROM tbl_roles ORDER BY role_name ASC";
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
     * Delete Record
     *
     * @param $id
     * */
    public function delete_role($id)
    {
		try{
			
			$role_record = $this->fetch_role($id);
			 
			foreach ($role_record as $key => $value) {
				if($key == "role_name") {
					$role_name = $value; 
				}  
			}
			
			if($role_id == 1)
			{
				$response = "<div class='alert alert-danger'>Cannot delete Role [ ' . $role_name . ' ].</div>";		
				return $response;			
			}

			// delete query
			$query = "DELETE FROM tbl_roles WHERE id = :id";

			// prepare query for execution
			$stmt = $this->db->prepare($query);

			// bind the parameters
			$stmt->bindParam(":id", $id, PDO::PARAM_STR);

			// Execute the query
			$stmt->execute();
			
			$response = "<div class='alert alert-success'>Role [ " . $role_name . " ] was successfully deleted.</div>";
			
			return $response;
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }

    /*
     * Get role Details
     *
     * @param $role_name
     * */
    public function get_role_given_role_name($role_name)
    {
		try{
			// select query
			$query = "SELECT * FROM tbl_roles WHERE role_name = :role_name";
			// prepare query for execution			
			$stmt = $this->db->prepare($query);
			// bind the parameters
			$stmt->bindParam(":role_name", $role_name, PDO::PARAM_STR);
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
     * Read all role records
     *
     * @return $mixed
     * */
    public function get_all_roles()
    {
		try{
			// select query - select all data
			$query = "SELECT * FROM tbl_roles ORDER BY id DESC";
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
     * Read all role names
     *
     * @return $mixed
     * */
    public function get_role_names()
    {
		try{
			// select query - select all data
			$query = "SELECT DISTINCT role_name FROM tbl_roles ORDER BY id ASC";
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
  
	public function search_roles_v2($page, $records_to_display, $role_name)
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
		 
		//$total_rows = $this->count_search_roles($role_code, $department, $extension_number);
		 
		// select data for current page
		
		/*SEARCH SENARIOS
			1. all items are specified. 	 
			2. no item is specified.		
		*/
		 
		//all items are specified.
		if(!empty($role_name))
		{
			$query = "SELECT * FROM tbl_roles WHERE (role_name LIKE :role_name) ORDER BY role_name ASC LIMIT :from_record_num, :records_per_page";
						
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			 
			$pattern  = '%' . $role_name . '%';
			
			$stmt->bindParam(":role_name", $pattern, PDO::PARAM_STR);
				 
			
			$count_query = "SELECT * FROM tbl_roles WHERE (role_name LIKE :role_name) ORDER BY role_name ASC";
			
			$count_stmt = $this->db->prepare($count_query);
			  
			$pattern  = '%' . $role_name . '%';
			
			$count_stmt->bindParam(":role_name", $pattern, PDO::PARAM_STR);
				 
		} 
		//no item is specified.
		else if(empty($role_name))
		{				
			$query = "SELECT * FROM tbl_roles ORDER BY id DESC LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			
			$count_query = "SELECT * FROM tbl_roles ORDER BY id DESC";
			
			$count_stmt = $this->db->prepare($count_query);
			  
		}
		else
		{ 
			$_SESSION['roles_count'] = 0;
			return;
		}

		$stmt->execute();
			
		$count_stmt->execute();
				 
		// this is how to get number of rows returned
		$num = $stmt->rowCount();
		
		$count_num = $count_stmt->rowCount();
		
		$_SESSION['roles_count'] = $count_num;

		//echo $num;
		// link to create record form
		//echo "<a href='create.php' class='btn btn-primary m-b-1em'>Create New Product</a>";
		 
		//check if more than 0 record found
		if($num>0){
		 
			// data from database will be here
			echo "<table class='table table-dark table-striped table-hover table-bordered table-sm' id='table_roles'>";//start table

			//creating our table heading
			echo "<thead class='thead-dark'>";
			echo "<tr>";
				echo "<th scope='col'>#</th>";
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
			
			$counta = 0;
			
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				 
				// extract row
				// this will make $row['firstname'] to
				// just $firstname only
				extract($row);
				 					
				$id = $row['id'];
				$role_name = $row['role_name']; 
				$status = $row['status'];
				$created_date = $row['created_date']; 
 
				$counta++;
				
				//$id = $counta;
					
				// creating new table row per record
				echo "<tr class='table-primary'>";
					
				echo "<td class='table-success'>";
								
				echo htmlspecialchars($id, ENT_QUOTES);
			
				echo "</td>";
			 
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($role_name, ENT_QUOTES);

				echo "</td>";
					 
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($status, ENT_QUOTES);

				echo "</td>"; 
			 
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($created_date, ENT_QUOTES);

				echo "</td>"; 
			 
				echo "<td class='table-success'>";
				if($id == 1)
				{
					
				}else{
					echo "<a onClick='edit_role({$id})' style='cursor:hand !important;' 
					class='btn btn-info m-r-1em crud_buttons btn_edit' 
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
									
					echo "<a onClick='delete_role({$id})' style='cursor:hand !important;' 
					class='btn btn-danger m-r-1em crud_buttons btn_delete' 
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
			// $query = "SELECT COUNT(*) as total_rows FROM tbl_roles";
			// $stmt = $this->db->prepare($query);
			 
			// // execute query
			// $stmt->execute();
			 
			// // get total rows
			// $row = $stmt->fetch(PDO::FETCH_ASSOC);
			// $total_rows = $row['total_rows'];
			
			//$total_rows = $this->count_search_roles($role_code, $department, $extension_number);
			
			// paginate records
			$page_url="roles.php?";
			include_once "paging_search_roles_table.php";
		}
		 
		// if no records found
		else{
			echo "<div class='alert alert-danger'>No records found.</div>";
		}
	}
 
 
 




}

?>
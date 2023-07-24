
<?php
/* Quick description on library file structure:

– Database – At the very top of the file we are using our database connection file that we are going to need through the library.

– CRUD: Class name which is having our methods collection.

– __construct() and destruct() method to initiate our database connection variable.
 
– create_user_role() : Used to create an user_role record in database.
 
– get_user_role_user_role() : Use to get authenticate user_role user_role.
 */
 session_start();
 
require 'database.php';
		 
class user_role_dal
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
	 * @param $user_id 
	 * @param $role_id 
	 *
     * @return $string
     * */
	public function create_user_role($user_id, $role_id, $status, $addedby)
    {
		try{
			
			$is_user_role = $this->check_if_user_role_exists($user_id, $role_id);
			 	
			$full_names = $this->get_full_names_given_user_id($user_id);
			$role_name = $this->get_role_name_given_role_id($role_id);

			if(!empty($is_user_role))
			{
				$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>User [ ' . $full_names . ' ] with Role [ ' . $role_name . ' ] exists.</div>';
			}
			 
			// insert query
			$query = "INSERT INTO tbl_users_roles(
			user_id,  
			role_id,  
			addedby,  
			status, 			
			created_date) 
			VALUES(
			:user_id,  
			:role_id,  
			:addedby,  
			:status,			
			:created_date)";
			
			// prepare query for execution
			$stmt = $this->db->prepare($query);
			
			// bind the parameters
			$stmt->bindParam(":user_id", $user_id, PDO::PARAM_STR); 
			$stmt->bindParam(":role_id", $role_id, PDO::PARAM_STR); 
			$stmt->bindParam(":addedby", $addedby, PDO::PARAM_STR);  
			$stmt->bindParam(":status", $status, PDO::PARAM_STR); 
			$created_date = date('d-m-Y h:i:s A');
			$stmt->bindParam(":created_date", $created_date, PDO::PARAM_STR);  
			
			// Execute the query
			$stmt->execute();
			
			// save lastInsertId in a variable
			$lastInsertId = $this->db->lastInsertId();
			
			$response = "<div class='alert alert-success'>User [ ' . $full_names . ' ] with Role [ ' . $role_name . ' ] was successfully created. <br />Last Insert Id = [ " . $lastInsertId . " ]</div>";
			return $response;
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }

    /*
     * Get user_role Details
     *
     * @param $user_id 
	 * @param $role_id 
	 *
     * */
    public function check_if_user_role_exists($user_id, $role_id)
    {
		try{
			// select query
			//$query = "SELECT * FROM tbl_users_roles 
			//WHERE user_id = :user_id AND role_id = :role_id";

			$query = "SELECT * FROM tbl_users_roles  
			WHERE user_id = :user_id";

			// prepare query for execution			
			$stmt = $this->db->prepare($query);

			// bind the parameters
			$stmt->bindParam(":user_id", $user_id, PDO::PARAM_STR); 
			$stmt->bindParam(":role_id", $role_id, PDO::PARAM_STR); 

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
	 * @param $user_id 
	 * @param $role_id 
	 *
     * @return $mixed
     * */
    public function update_user_role($user_id, $role_id, $id)
    {
		try{
			// Update query
			$query = "UPDATE tbl_users_roles SET 
			user_id = :user_id, 
			role_id = :role_id 			
			WHERE id = :id";
			
			// prepare query for execution
			$stmt = $this->db->prepare($query);
			
			// bind the parameters
			$stmt->bindParam(":user_id", $user_id, PDO::PARAM_STR); 
			$stmt->bindParam(":role_id", $role_id, PDO::PARAM_STR); 
			$stmt->bindParam(":id", $id, PDO::PARAM_STR);
			
			// Execute the query
			$stmt->execute();
 
			$full_names = $this->get_full_names_given_user_id($user_id);
			$role_name = $this->get_role_name_given_role_id($role_id);

			$response = "<div class='alert alert-success'>User [ ' . $full_names . ' ] with Role [ ' . $role_name . ' ] was successfully updated.</div>";
			
			return $response;
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }

    /*
     * Get user_role Details
     *
     * @param $id
     * */
    public function get_user_role($id)
    {
		try{
			// select query
			$query = "SELECT * FROM tbl_users_roles 
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
     * Get user_role Details
     *
     * @param $id
     * */
    public function fetch_user_role($id)
    {
		try{
			// select query
			$query = "SELECT * FROM tbl_users_roles 
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
     * Read all user_role records
     *
     * @return $mixed
     * */
    public function get_all_user_roles_arr()
    {
		try{
			// select query - select all data
			$query = "SELECT * FROM tbl_users_roles 
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
    public function delete_user_role($id)
    {
		try{
			
			$user_role_record = $this->fetch_user_role($id);
			 
			foreach ($user_role_record as $key => $value) {
				if($key == "role_id") {
					$role_id = $value; 
				}  
			}
			
			$full_names = $this->get_full_names_given_user_id($user_id);
			$role_name = $this->get_role_name_given_role_id($role_id);

			if($user_id == 1)
			{
				$response = "<div class='alert alert-danger'>Cannot delete User [ ' . $full_names . ' ] with Role [ ' . $role_name . ' ].</div>";		
				return $response;			
			}

			// delete query
			$query = "DELETE FROM tbl_users_roles 
			WHERE id = :id";

			// prepare query for execution
			$stmt = $this->db->prepare($query);

			// bind the parameters
			$stmt->bindParam(":id", $id, PDO::PARAM_STR);

			// Execute the query
			$stmt->execute();
			
			$response = "<div class='alert alert-success'>User [ ' . $full_names . ' ] with Role [ ' . $role_name . ' ] was successfully deleted.</div>";
			
			return $response;
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }

    /*
     * Get user Details
     *
     * @param $user_id
     * */
    public function get_full_names_given_user_id($user_id)
    {
		try{
			// select query
			$query = "SELECT full_names FROM tbl_users 
			WHERE id = :user_id";

			// prepare query for execution			
			$stmt = $this->db->prepare($query);

			// bind the parameters
			$stmt->bindParam(":user_id", $user_id, PDO::PARAM_STR);

			// Execute the query
			$stmt->execute();

			// return retrieved row as a json object
			$full_names = $stmt->fetch(PDO::FETCH_ASSOC);
			
			return $full_names["full_names"];
			
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
     * Read all user_role records
     *
     * @return $mixed
     * */
    public function get_all_users_roles()
    {
		try{
			// select query - select all data
			$query = "SELECT * FROM tbl_users_roles 
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
    
	public function search_users_roles_v2($page, $records_to_display, $full_names, $role_name)
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
		 
		//$total_rows = $this->count_search_user_roles($user_role_code, $department, $extension_number);
		 
		// select data for current page
		
		/*SEARCH SENARIOS
			1. all items are specified. 
			2. full names typed. 	
			3. role name typed. 			
			4. no item is specified.		
		*/
		 
		//all items are specified.
		if(!empty($full_names) && !empty($role_name))
		{
			$query = "SELECT * FROM tbl_users_roles users_roles
			INNER JOIN tbl_users users ON users_roles.user_id = users.id 
			INNER JOIN tbl_roles roles ON users_roles.role_id = roles.id 
			WHERE (users.full_names LIKE :full_names AND roles.role_name LIKE :role_name) 
			ORDER BY users.full_names ASC
			LIMIT :from_record_num, :records_per_page";
						
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			 
			$pattern  = '%' . $full_names . '%';
			
			$stmt->bindParam(":full_names", $pattern, PDO::PARAM_STR);
				 
			$pattern  = '%' . $role_name . '%';
			
			$stmt->bindParam(":role_name", $pattern, PDO::PARAM_STR);
				 
			
			$count_query = "SELECT * FROM tbl_users_roles users_roles
			INNER JOIN tbl_users users ON users_roles.user_id = users.id 
			INNER JOIN tbl_roles roles ON users_roles.role_id = roles.id 
			WHERE (users.full_names LIKE :full_names AND roles.role_name LIKE :role_name) 
			ORDER BY users.full_names ASC";
			
			$count_stmt = $this->db->prepare($count_query);
			  
			$pattern  = '%' . $full_names . '%';
			
			$count_stmt->bindParam(":full_names", $pattern, PDO::PARAM_STR);
				 
			$pattern  = '%' . $role_name . '%';
			
			$count_stmt->bindParam(":role_name", $pattern, PDO::PARAM_STR);
				 
		} 
		//full name typed.
		else if(!empty($full_names)&& empty($role_name))
		{				
			$query = "SELECT * FROM tbl_users_roles AS users_roles  
			INNER JOIN tbl_users AS users ON users_roles.user_id = users.id 
			WHERE (users.full_names LIKE :full_names) 
			ORDER BY users.full_names ASC  
			LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			$pattern  = '%' . $full_names . '%';
			
			$stmt->bindParam(":full_names", $pattern, PDO::PARAM_STR);
				 
			
			$count_query = "SELECT * FROM tbl_users_roles users_roles 
			INNER JOIN tbl_users users ON users.id = users_roles.user_id  
			WHERE (users.full_names LIKE :full_names) 
			ORDER BY users.full_names ASC";
			
			$count_stmt = $this->db->prepare($count_query);
			  
			$pattern  = '%' . $full_names . '%';
			
			$count_stmt->bindParam(":full_names", $pattern, PDO::PARAM_STR);
				 
		}
		//role name typed.
		else if(empty($full_names)&& !empty($role_name))
		{				
			$query = "SELECT * FROM tbl_users_roles  
			INNER JOIN tbl_roles AS roles ON tbl_users_roles.role_id = roles.id 
			WHERE (roles.role_name LIKE :role_name) 
			ORDER BY roles.role_name ASC 
			LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			$pattern  = '%' . $role_name . '%';
			
			$stmt->bindParam(":role_name", $pattern, PDO::PARAM_STR);
				 
			
			$count_query = "SELECT * FROM tbl_users_roles  
			INNER JOIN tbl_roles AS roles ON tbl_users_roles.role_id = roles.id 
			WHERE (roles.role_name LIKE :role_name) 
			ORDER BY roles.role_name ASC";
			
			$count_stmt = $this->db->prepare($count_query);
			  
			$pattern  = '%' . $role_name . '%';
			
			$count_stmt->bindParam(":role_name", $pattern, PDO::PARAM_STR);
			  
		}
		//no item is specified.
		else if(empty($full_names) && empty($role_name))
		{				
			$query = "SELECT * FROM tbl_users_roles 
			ORDER BY id DESC 
			LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			
			$count_query = "SELECT * FROM tbl_users_roles 
			ORDER BY id DESC";
			
			$count_stmt = $this->db->prepare($count_query);
			  
		}
		else
		{ 
			$_SESSION['users_roles_count'] = 0;
			return;
		}

		$stmt->execute();
			
		$count_stmt->execute();
				 
		// this is how to get number of rows returned
		$num = $stmt->rowCount();
		
		$count_num = $count_stmt->rowCount();
		
		$_SESSION['users_roles_count'] = $count_num;

		//echo $num;
		// link to create record form
		//echo "<a href='create.php' class='btn btn-primary m-b-1em'>Create New Product</a>";
		 
		//check if more than 0 record found
		if($num>0){
		 
			// data from database will be here
			echo "<table class='table table-dark table-striped table-hover table-bordered table-sm' id='table_users_roles'>";//start table

			//creating our table heading
			echo "<thead class='thead-dark'>";
			echo "<tr>";
				echo "<th scope='col'>#</th>";
				echo "<th scope='col'>User</th>"; 
				echo "<th scope='col'>Role</th>"; 
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
				$user_id = $row['user_id']; 
				$role_id = $row['role_id']; 
				$status = $row['status'];
				$created_date = $row['created_date']; 
    
				$full_names = $this->get_full_names_given_user_id($user_id);
				$role_name = $this->get_role_name_given_role_id($role_id);
				
				// creating new table row per record
				echo "<tr class='table-primary'>";
					
				echo "<td class='table-success'>";
								
				echo htmlspecialchars($id, ENT_QUOTES);
			
				echo "</td>";
			 
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($full_names, ENT_QUOTES);

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
				if($user_id == 1)
				{
					
				}else{
					echo "<a onClick='edit_user_role({$id})' style='cursor:hand !important;' 
					class='btn btn-info m-r-1em crud_buttons btn_edit btn_edit_user_role' 
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
									
					echo "<a onClick='delete_user_role({$id})' style='cursor:hand !important;' 
					class='btn btn-danger m-r-1em crud_buttons btn_delete btn_delete_user_role' 
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
			// $query = "SELECT COUNT(*) as total_rows FROM tbl_users_roles";
			// $stmt = $this->db->prepare($query);
			 
			// // execute query
			// $stmt->execute();
			 
			// // get total rows
			// $row = $stmt->fetch(PDO::FETCH_ASSOC);
			// $total_rows = $row['total_rows'];
			
			//$total_rows = $this->count_search_user_roles($user_role_code, $department, $extension_number);
			
			// paginate records
			$page_url="user_roles.php?";
			include_once "paging_search_users_roles_table.php";
		}
		 
		// if no records found
		else{
			echo "<div class='alert alert-danger'>No records found.</div>";
		}
	}
 
    /*
     * Read all users records
     *
     * @return $mixed
     * */
    public function get_all_users_arr()
    {
		try{
			// select query - select all data
			$query = "SELECT * FROM tbl_users ORDER BY full_names ASC";
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
     * Read all roles records
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
			//return $data;
			return json_encode($data);
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }

 
 




}

?>
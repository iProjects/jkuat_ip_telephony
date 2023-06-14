
<?php
/* Quick description on library file structure:

– Database – At the very top of the file we are using our database connection file that we are going to need through the library.

– CRUD: Class name which is having our methods collection.

– __construct() and destruct() method to initiate our database connection variable.
 
– create_user() : Used to create an user record in database.
 
– get_user_role() : Use to get authenticate user role.
 */
 session_start();
 
require 'database.php';
		 
class user_dal
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
	 * @param $email
	 * @param $username
	 * @param $password
	 * @param $secretWord 
	 
     * @return $string
     * */
	public function create_user($email, $username, $password, $secretWord)
    {
		try{
			
			$is_email = $this->check_if_email_exists($email);
			 
			if(!empty($is_email))
			{
				$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>User with Email [ ' . $email . ' ] exists.</div>';
				return $response;
			}
			
			$is_username = $this->check_if_username_exists($username);
			 
			if(!empty($is_username))
			{
				$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>User Name [ ' . $username . ' ] exists.</div>';
				return $response;
			}
			
			// insert query
			$query = "INSERT INTO telephoneadmin(
			email, 
			username, 
			password,
			secretWord,  
			status, 			
			created_date) 
			VALUES(
			:email, 
			:username, 
			:password,
			:secretWord, 
			:status,			
			:created_date)";
			
			// prepare query for execution
			$stmt = $this->db->prepare($query);
			
			// bind the parameters
			$stmt->bindParam(":email", $email, PDO::PARAM_STR);
			$stmt->bindParam(":username", $username, PDO::PARAM_STR);
			$stmt->bindParam(":secretWord", $secretWord, PDO::PARAM_STR);
			$stmt->bindParam(":password", $password, PDO::PARAM_STR);
			$status = "active";
			$stmt->bindParam(":status", $status, PDO::PARAM_STR); 
			$created_date = date('d-m-Y h:i:s A');
			$stmt->bindParam(":created_date", $created_date, PDO::PARAM_STR);  
			
			// Execute the query
			$stmt->execute();
			
			// save lastInsertId in a variable
			$lastInsertId = $this->db->lastInsertId();
			
			$response = "<div class='alert alert-success'>record was successfully created. Last Insert Id = [ " . $lastInsertId . " ]</div>";
			return $response;
			
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
    public function check_if_email_exists($email)
    {
		try{
			// select query
			$query = "SELECT * FROM telephoneadmin WHERE email = :email";
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
	
    /*
     * Get user Details
     *
     * @param $username
     * */
    public function check_if_username_exists($username)
    {
		try{
			// select query
			$query = "SELECT * FROM telephoneadmin WHERE username = :username";
			// prepare query for execution			
			$stmt = $this->db->prepare($query);
			// bind the parameters
			$stmt->bindParam(":username", $username, PDO::PARAM_STR);
			// Execute the query
			$stmt->execute();
			
			$arr = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if (!$arr) {
				// array is empty.
				return null;
			}

			extract($arr); 
			
			return $username;		
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }
	
    /*
     * Update Record
     *
	 * @param $email
	 * @param $username
	 * @param $password
	 * @param $secretword 

     * @return $mixed
     * */
    public function update_user($email, $username, $password, $secretword, $id)
    {
		try{
			// Update query
			$query = "UPDATE telephoneadmin SET 
			email = :email, 
			username = :username,  
			password = :password, 
			secretWord = :secretword 
			WHERE id = :id";
			
			// prepare query for execution
			$stmt = $this->db->prepare($query);
			
			// bind the parameters
			$stmt->bindParam(":email", $email, PDO::PARAM_STR);
			$stmt->bindParam(":username", $username, PDO::PARAM_STR);
			$stmt->bindParam(":password", $password, PDO::PARAM_STR); 
			$stmt->bindParam(":secretword", $secretword, PDO::PARAM_STR); 
			$stmt->bindParam(":id", $id, PDO::PARAM_STR);
			
			// Execute the query
			$stmt->execute();
 
			$response = "<div class='alert alert-success'>record with id [ " . $id . " ] was successfully updated.</div>";
			
			return $response;
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }

    /*
     * Get user Details
     *
     * @param $id
     * */
    public function get_user($id)
    {
		try{
			// select query
			$query = "SELECT * FROM telephoneadmin WHERE id = :id";
			
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
     * Read all user records
     *
     * @return $mixed
     * */
    public function get_all_users_arr()
    {
		try{
			// select query - select all data
			$query = "SELECT * FROM telephoneadmin ORDER BY id DESC";
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
    public function delete_user($id)
    {
		try{
			// delete query
			$query = "DELETE FROM telephoneadmin WHERE id = :id";
			// prepare query for execution
			$stmt = $this->db->prepare($query);
			// bind the parameters
			$stmt->bindParam(":id", $id, PDO::PARAM_STR);
			// Execute the query
			$stmt->execute();
			
			$response = "<div class='alert alert-success'>record with id [ " . $id . " ] was successfully deleted.</div>";
			return $response;
			
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
			$query = "SELECT * FROM telephoneadmin WHERE email = :email";
			// prepare query for execution			
			$stmt = $this->db->prepare($query);
			// bind the parameters
			$stmt->bindParam(":email", $email, PDO::PARAM_STR);
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
     * Read all user records
     *
     * @return $mixed
     * */
    public function get_all_users()
    {
		try{
			// select query - select all data
			$query = "SELECT * FROM telephoneadmin ORDER BY id DESC";
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
     * Read all user names
     *
     * @return $mixed
     * */
    public function get_user_names()
    {
		try{
			// select query - select all data
			$query = "SELECT DISTINCT username FROM telephoneadmin ORDER BY id ASC";
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
     * Read all emails
     *
     * @return $mixed
     * */
    public function get_user_emails()
    {
		try{
			// select query - select all data
			$query = "SELECT DISTINCT email FROM telephoneadmin ORDER BY id ASC";
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
 
	public function get_paginated_users_table($page, $records_to_display)
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
		
		// select data for current page
		$query = "SELECT * FROM telephoneadmin ORDER BY id DESC LIMIT :from_record_num, :records_per_page";
		 
		$stmt = $this->db->prepare($query);
		
		$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
		$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
		
		$stmt->execute();
				 
		// this is how to get number of rows returned
		$num = $stmt->rowCount();
		
		// link to create record form
		//echo "<a href='create.php' class='btn btn-primary m-b-1em'>Create New Product</a>";
		 
		//check if more than 0 record found
		if($num>0){
		 
			// data from database will be here
			echo "<table class='table table-dark table-striped table-hover table-bordered table-sm' id='table_users'>";//start table

			//creating our table heading
			echo "<thead class='thead-dark'>";
			echo "<tr>";
				echo "<th scope='col'>#</th>";
				echo "<th scope='col'>Email</th>";
				echo "<th scope='col'>User Name</th>"; 
				echo "<th scope='col'>Password</th>"; 
				echo "<th scope='col'>Secret Word</th>"; 
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
				$email = $row['email'];
				$username = $row['username'];
				$password = $row['password']; 
				$secretword = $row['secretWord'];
				$status = $row['status'];
				$created_date = $row['created_date']; 
 
				// creating new table row per record
				echo "<tr class='table-primary'>";
					
				echo "<td class='table-success'>";
								
				echo htmlspecialchars($id, ENT_QUOTES);
			
				echo "</td>";
			 
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($email, ENT_QUOTES);

				echo "</td>";
					
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($username, ENT_QUOTES);

				echo "</td>";
			 
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($password, ENT_QUOTES);

				echo "</td>"; 
				
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($secretword, ENT_QUOTES);

				echo "</td>"; 
			 
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($status, ENT_QUOTES);

				echo "</td>"; 
			 
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($created_date, ENT_QUOTES);

				echo "</td>"; 
			 
				echo "<td class='table-light'>";
					
				echo "<a onClick='edit_user({$id})' style='cursor:hand !important;' 
				class='btn btn-info m-r-1em crud_buttons btn_edit' 
				title='edit'  
				data-id='{$id}' 
				data-toggle='popover' 
				data-placement='auto' 
				data-trigger='hover' 
				data-content='edit user' >
				edit
					<span class='glyphicon'>
					</span>
				</a>";
								
				echo "<a onClick='delete_user({$id})' style='cursor:hand !important;' 
				class='btn btn-danger m-r-1em crud_buttons btn_delete' 
				title='delete'  
				data-id='{$id}' 
				data-toggle='popover' 
				data-placement='auto' 
				data-trigger='hover' 
				data-content='delete user' >
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
			$query = "SELECT COUNT(*) as total_rows FROM telephoneadmin";
			$stmt = $this->db->prepare($query);
			 
			// execute query
			$stmt->execute();
			 
			// get total rows
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$total_rows = $row['total_rows'];

			// paginate records
			$page_url="users.php?";
			include_once "paging_users_table.php";
		}
		 
		// if no records found
		else{
			echo "<div class='alert alert-danger'>No records found.</div>";
		}
	}
 
	public function search_users($page, $records_to_display, $email, $username)
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
		 
		//$total_rows = $this->count_search_users($user_code, $department, $extension_number);
		 
		// select data for current page
		
		/*SEARCH SENARIOS
			1. all items are specified.
			2. email only typed.
			3. username only typed.		 
			5. no item is specified.		
		*/
		 
		//all items are specified.
		if(!empty($email) && !empty($username))
		{
			$query = "SELECT * FROM telephoneadmin WHERE email LIKE :email AND username LIKE :username ORDER BY email, username ASC LIMIT :from_record_num, :records_per_page";
						
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			 
			$pattern  = '%' . $email . '%';
			
			$stmt->bindParam(":email", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $username . '%';
			
			$stmt->bindParam(":username", $pattern, PDO::PARAM_STR);
				 
		}
		//email only typed.
		else if(!empty($email) && empty($username))
		{
			$query = "SELECT * FROM telephoneadmin WHERE email LIKE :email ORDER BY email ASC LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
						
			$pattern  = '%' . $email . '%';
			
			$stmt->bindParam(":email", $pattern, PDO::PARAM_STR);
				
		}
		//username only typed.
		else if(empty($email) && !empty($username))
		{
			$query = "SELECT * FROM telephoneadmin WHERE username LIKE :username ORDER BY username ASC LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
						
			$pattern  = '%' . $username . '%';
			
			$stmt->bindParam(":username", $pattern, PDO::PARAM_STR);
				
		} 
		//no item is specified.
		else if(empty($email) && empty($username))
		{				
			$query = "SELECT * FROM telephoneadmin ORDER BY id DESC LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			//$_SESSION['users_count'] = 0;			
			//return;
		}
		else
		{ 
			$_SESSION['users_count'] = 0;
			return;
		}

		$stmt->execute();
				 
		// this is how to get number of rows returned
		$num = $stmt->rowCount();
		
		$_SESSION['users_count'] = $num;

		$total_rows = $num;
		
		//echo $num;
		// link to create record form
		//echo "<a href='create.php' class='btn btn-primary m-b-1em'>Create New Product</a>";
		 
		//check if more than 0 record found
		if($num>0){
		 
			// data from database will be here
			echo "<table class='table table-dark table-striped table-hover table-bordered table-sm' id='table_users'>";//start table

			//creating our table heading
			echo "<thead class='thead-dark'>";
			echo "<tr>";
				echo "<th scope='col'>#</th>";
				echo "<th scope='col'>Email</th>";
				echo "<th scope='col'>User Name</th>"; 
				echo "<th scope='col'>Password</th>"; 
				echo "<th scope='col'>Secret Word</th>"; 
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
				$email = $row['email'];
				$username = $row['username'];
				$password = $row['password']; 
				$secretword = $row['secretWord'];
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
					
				echo htmlspecialchars($email, ENT_QUOTES);

				echo "</td>";
					
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($username, ENT_QUOTES);

				echo "</td>";
			 
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($password, ENT_QUOTES);

				echo "</td>"; 
				
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($secretword, ENT_QUOTES);

				echo "</td>"; 
			 
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($status, ENT_QUOTES);

				echo "</td>"; 
			 
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($created_date, ENT_QUOTES);

				echo "</td>"; 
			 
				echo "<td class='table-light'>";
					
				echo "<a onClick='edit_user({$id})' style='cursor:hand !important;' 
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
								
				echo "<a onClick='delete_user({$id})' style='cursor:hand !important;' 
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
			// $query = "SELECT COUNT(*) as total_rows FROM telephoneadmin";
			// $stmt = $this->db->prepare($query);
			 
			// // execute query
			// $stmt->execute();
			 
			// // get total rows
			// $row = $stmt->fetch(PDO::FETCH_ASSOC);
			// $total_rows = $row['total_rows'];
			
			//$total_rows = $this->count_search_users($user_code, $department, $extension_number);
			
			// paginate records
			$page_url="users.php?";
			include_once "paging_search_users_table.php";
		}
		 
		// if no records found
		else{
			echo "<div class='alert alert-danger'>No records found.</div>";
		}
	}
 
 
 




}

?>
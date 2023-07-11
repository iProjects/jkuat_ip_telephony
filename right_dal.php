
<?php
/* Quick description on library file structure:

– Database – At the very top of the file we are using our database connection file that we are going to need through the library.

– CRUD: Class name which is having our methods collection.

– __construct() and destruct() method to initiate our database connection variable.
 
– create_right() : Used to create an right record in database.
 
– get_right_role() : Use to get authenticate right role.
 */
 session_start();
 
require 'database.php';
		 
class right_dal
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
	 * @param $right_name 
	 
     * @return $string
     * */
	public function create_right($right_name, $addedby)
    {
		try{
			
			$is_right_name = $this->check_if_right_name_exists($right_name);
			 
			if(!empty($is_right_name))
			{
				$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>Right with Name [ ' . $right_name . ' ] exists.</div>';
				return $response;
			}
			
			// insert query
			$query = "INSERT INTO tbl_rights(
			right_name,  
			addedby,  			
			status, 			
			created_date) 
			VALUES(
			:right_name, 
			:addedby, 
			:status,			
			:created_date)";
			
			// prepare query for execution
			$stmt = $this->db->prepare($query);
			
			// bind the parameters
			$right_name = ucwords($right_name); 
			$stmt->bindParam(":right_name", $right_name, PDO::PARAM_STR); 
			$stmt->bindParam(":addedby", $addedby, PDO::PARAM_STR); 
			$status = "active";
			$stmt->bindParam(":status", $status, PDO::PARAM_STR); 
			$created_date = date('d-m-Y h:i:s A');
			$stmt->bindParam(":created_date", $created_date, PDO::PARAM_STR);  
			
			// Execute the query
			$stmt->execute();
			
			// save lastInsertId in a variable
			$lastInsertId = $this->db->lastInsertId();
			
			$response = "<div class='alert alert-success'>Right with Name [ " . $right_name . " ] was successfully created. <br />Last Insert Id = [ " . $lastInsertId . " ]</div>";
			return $response;
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }

    /*
     * Get right Details
     *
     * @param $right_name
     * */
    public function check_if_right_name_exists($right_name)
    {
		try{
			// select query
			$query = "SELECT * FROM tbl_rights WHERE right_name = :right_name";
			// prepare query for execution			
			$stmt = $this->db->prepare($query);
			// bind the parameters
			$stmt->bindParam(":right_name", $right_name, PDO::PARAM_STR);
			// Execute the query
			$stmt->execute();
			
			$arr = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if (!$arr) {
				// array is empty.
				return null;
			}

			extract($arr); 
			
			return $right_name;		
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }
	
    /*
     * Update Record
     *
	 * @param $right_name  

     * @return $mixed
     * */
    public function update_right($right_name, $id)
    {
		try{
			// Update query
			$query = "UPDATE tbl_rights SET 
			right_name = :right_name 
			WHERE id = :id";
			
			// prepare query for execution
			$stmt = $this->db->prepare($query);
			
			// bind the parameters
			$right_name = ucwords($right_name); 
			$stmt->bindParam(":right_name", $right_name, PDO::PARAM_STR); 
			$stmt->bindParam(":id", $id, PDO::PARAM_STR);
			
			// Execute the query
			$stmt->execute();
 
			$response = "<div class='alert alert-success'>Right with Name [ " . $right_name . " ] was successfully updated.</div>";
			
			return $response;
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }

    /*
     * Get right Details
     *
     * @param $id
     * */
    public function get_right($id)
    {
		try{
			// select query
			$query = "SELECT * FROM tbl_rights WHERE id = :id";
			
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
     * Get right Details
     *
     * @param $id
     * */
    public function fetch_right($id)
    {
		try{
			// select query
			$query = "SELECT * FROM tbl_rights WHERE id = :id";
			
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
     * Read all right records
     *
     * @return $mixed
     * */
    public function get_all_rights_arr()
    {
		try{
			// select query - select all data
			$query = "SELECT * FROM tbl_rights 
			WHERE status = active 
			ORDER BY right_name ASC";
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
    public function delete_right($id)
    {
		try{
			
			$right_record = $this->fetch_right($id);
			 
			foreach ($right_record as $key => $value) {
				if($key == "right_name") {
					$right_name = $value; 
				}  
			}
			
			// delete query
			$query = "DELETE FROM tbl_rights WHERE id = :id";
			// prepare query for execution
			$stmt = $this->db->prepare($query);
			// bind the parameters
			$stmt->bindParam(":id", $id, PDO::PARAM_STR);
			// Execute the query
			$stmt->execute();
			
			$response = "<div class='alert alert-success'>Right with Name [ " . $right_name . " ] was successfully deleted.</div>";
			
			return $response;
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }

    /*
     * Get right Details
     *
     * @param $right_name
     * */
    public function get_right_given_right_name($right_name)
    {
		try{
			// select query
			$query = "SELECT * FROM tbl_rights WHERE right_name = :right_name";
			// prepare query for execution			
			$stmt = $this->db->prepare($query);
			// bind the parameters
			$stmt->bindParam(":right_name", $right_name, PDO::PARAM_STR);
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
     * Read all right records
     *
     * @return $mixed
     * */
    public function get_all_rights()
    {
		try{
			// select query - select all data
			$query = "SELECT * FROM tbl_rights  
			WHERE status = active  
			ORDER BY id ASC";
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
     * Read all right names
     *
     * @return $mixed
     * */
    public function get_right_names()
    {
		try{
			// select query - select all data
			$query = "SELECT DISTINCT right_name FROM tbl_rights ORDER BY right_name ASC";
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
 
	public function get_paginated_rights_table($page, $records_to_display)
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
		$query = "SELECT * FROM tbl_rights ORDER BY id ASC LIMIT :from_record_num, :records_per_page";
		 
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
			echo "<table class='table table-dark table-striped table-hover table-bordered table-sm' id='table_rights'>";//start table

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
			 
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				 
				// extract row
				// this will make $row['firstname'] to
				// just $firstname only
				extract($row);
				 					
				$id = $row['id'];
				$right_name = $row['right_name']; 
				$status = $row['status'];
				$created_date = $row['created_date']; 
 
				// creating new table row per record
				echo "<tr class='table-primary'>";
					
				echo "<td class='table-success'>";
								
				echo htmlspecialchars($id, ENT_QUOTES);
			
				echo "</td>";
			 
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($right_name, ENT_QUOTES);

				echo "</td>";
				
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($status, ENT_QUOTES);

				echo "</td>"; 
			 
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($created_date, ENT_QUOTES);

				echo "</td>"; 
			 
				echo "<td class='table-light'>";
					
				echo "<a onClick='edit_right({$id})' style='cursor:hand !important;' 
				class='btn btn-info m-r-1em crud_buttons btn_edit btn_edit_right' 
				title='edit'  
				data-id='{$id}' 
				data-toggle='popover' 
				data-placement='auto' 
				data-trigger='hover' 
				data-content='edit right' >
				edit
					<span class='glyphicon'>
					</span>
				</a>";
								
				echo "<a onClick='delete_right({$id})' style='cursor:hand !important;' 
				class='btn btn-danger m-r-1em crud_buttons btn_delete btn_delete_right' 
				title='delete'  
				data-id='{$id}' 
				data-toggle='popover' 
				data-placement='auto' 
				data-trigger='hover' 
				data-content='delete right' >
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
			$query = "SELECT COUNT(*) as total_rows FROM tbl_rights";
			$stmt = $this->db->prepare($query);
			 
			// execute query
			$stmt->execute();
			 
			// get total rows
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$total_rows = $row['total_rows'];

			// paginate records
			$page_url="rights.php?";
			include_once "paging_rights_table.php";
		}
		 
		// if no records found
		else{
			echo "<div class='alert alert-danger'>No records found.</div>";
		}
	}
 
	public function search_rights($page, $records_to_display, $right_name)
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
		 
		//$total_rows = $this->count_search_rights($right_code, $department, $extension_number);
		 
		// select data for current page
		
		/*SEARCH SENARIOS
			1. all items are specified. 	 
			2. no item is specified.		
		*/
		 
		//all items are specified.
		if(!empty($right_name))
		{
			$query = "SELECT * FROM tbl_rights WHERE right_name LIKE :right_name ORDER BY right_name ASC LIMIT :from_record_num, :records_per_page";
						
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			 
			$pattern  = '%' . $right_name . '%';
			
			$stmt->bindParam(":right_name", $pattern, PDO::PARAM_STR);
			
		}  
		//no item is specified.
		else if(empty($right_name))
		{				
			$query = "SELECT * FROM tbl_rights ORDER BY id ASC LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			//$_SESSION['rights_count'] = 0;			
			//return;
		}
		else
		{ 
			$_SESSION['rights_count'] = 0;
			return;
		}

		$stmt->execute();
				 
		// this is how to get number of rows returned
		$num = $stmt->rowCount();
		
		$_SESSION['rights_count'] = $num;

		$total_rows = $num;
		
		//echo $num;
		// link to create record form
		//echo "<a href='create.php' class='btn btn-primary m-b-1em'>Create New Product</a>";
		 
		//check if more than 0 record found
		if($num>0){
		 
			// data from database will be here
			echo "<table class='table table-dark table-striped table-hover table-bordered table-sm' id='table_rights'>";//start table

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
				$right_name = $row['right_name'];
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
					
				echo htmlspecialchars($right_name, ENT_QUOTES);

				echo "</td>";
				
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($status, ENT_QUOTES);

				echo "</td>"; 
			 
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($created_date, ENT_QUOTES);

				echo "</td>"; 
			 
				echo "<td class='table-light'>";
					
				echo "<a onClick='edit_right({$id})' style='cursor:hand !important;' 
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
								
				echo "<a onClick='delete_right({$id})' style='cursor:hand !important;' 
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
			// $query = "SELECT COUNT(*) as total_rows FROM tbl_rights";
			// $stmt = $this->db->prepare($query);
			 
			// // execute query
			// $stmt->execute();
			 
			// // get total rows
			// $row = $stmt->fetch(PDO::FETCH_ASSOC);
			// $total_rows = $row['total_rows'];
			
			//$total_rows = $this->count_search_rights($right_code, $department, $extension_number);
			
			// paginate records
			$page_url="rights.php?";
			include_once "paging_search_rights_table.php";
		}
		 
		// if no records found
		else{
			echo "<div class='alert alert-danger'>No records found.</div>";
		}
	}
 
	public function search_rights_v2($page, $records_to_display, $right_name)
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
		 
		//$total_rows = $this->count_search_rights($right_code, $department, $extension_number);
		 
		// select data for current page
		
		/*SEARCH SENARIOS
			1. all items are specified. 		 
			2. no item is specified.		
		*/
		 
		//all items are specified.
		if(!empty($right_name))
		{
			$query = "SELECT * FROM tbl_rights WHERE (right_name LIKE :right_name) ORDER BY right_name ASC LIMIT :from_record_num, :records_per_page";
						
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			 
			$pattern  = '%' . $right_name . '%';
			
			$stmt->bindParam(":right_name", $pattern, PDO::PARAM_STR);
				 
			
			$count_query = "SELECT * FROM tbl_rights WHERE (right_name LIKE :right_name) ORDER BY right_name ASC";
			
			$count_stmt = $this->db->prepare($count_query);
			  
			$pattern  = '%' . $right_name . '%';
			
			$count_stmt->bindParam(":right_name", $pattern, PDO::PARAM_STR);
				 
		} 
		//no item is specified.
		else if(empty($right_name))
		{				
			$query = "SELECT * FROM tbl_rights ORDER BY id ASC LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			
			$count_query = "SELECT * FROM tbl_rights ORDER BY id ASC";
			
			$count_stmt = $this->db->prepare($count_query);
			  
		}
		else
		{ 
			$_SESSION['rights_count'] = 0;
			return;
		}

		$stmt->execute();
			
		$count_stmt->execute();
				 
		// this is how to get number of rows returned
		$num = $stmt->rowCount();
		
		$count_num = $count_stmt->rowCount();
		
		$_SESSION['rights_count'] = $count_num;

		//echo $num;
		// link to create record form
		//echo "<a href='create.php' class='btn btn-primary m-b-1em'>Create New Product</a>";
		 
		//check if more than 0 record found
		if($num>0){
		 
			// data from database will be here
			echo "<table class='table table-dark table-striped table-hover table-bordered table-sm' id='table_rights'>";//start table

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
				$right_name = $row['right_name'];
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
					
				echo htmlspecialchars($right_name, ENT_QUOTES);

				echo "</td>";
					 
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($status, ENT_QUOTES);

				echo "</td>"; 
			 
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($created_date, ENT_QUOTES);

				echo "</td>"; 
			 
				echo "<td class='table-success'>";
					
				echo "<a onClick='edit_right({$id})' style='cursor:hand !important;' 
				class='btn btn-info m-r-1em crud_buttons btn_edit not_allowed' 
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
								
				echo "<a onClick='delete_right({$id})' style='cursor:hand !important;' 
				class='btn btn-danger m-r-1em crud_buttons btn_delete not_allowed' 
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
			// $query = "SELECT COUNT(*) as total_rows FROM tbl_rights";
			// $stmt = $this->db->prepare($query);
			 
			// // execute query
			// $stmt->execute();
			 
			// // get total rows
			// $row = $stmt->fetch(PDO::FETCH_ASSOC);
			// $total_rows = $row['total_rows'];
			
			//$total_rows = $this->count_search_rights($right_code, $department, $extension_number);
			
			// paginate records
			$page_url="rights.php?";
			include_once "paging_search_rights_table.php";
		}
		 
		// if no records found
		else{
			echo "<div class='alert alert-danger'>No records found.</div>";
		}
	}
 
 
 




}

?>
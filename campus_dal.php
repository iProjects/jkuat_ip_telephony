
<?php
/* Quick description on library file structure:

– Database – At the very top of the file we are using our database connection file that we are going to need through the library.

– CRUD: Class name which is having our methods collection.

– __construct() and destruct() method to initiate our database connection variable.
 
– create_campus() : Used to create an campus record in database.
 
– get_user_role() : Use to get authenticate user role.
 */
 session_start();
 
require 'database.php';
		 
class campus_dal
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
	 * @param $campus_code
	 * @param $campus_name
	 * @param $addedby 
	 
     * @return $string
     * */
	public function create_campus($campus_code, $campus_name, $addedby)
    {
		try{
			
			$is_campus_code = $this->check_if_campus_code_exists($campus_code);
			 
			if(!empty($is_campus_code))
			{
				$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>Campus Code [ ' . $campus_code . ' ] exists.</div>';
				return $response;
			}
			
			// insert query
			$query = "INSERT INTO campuses(
			ccode, 
			cname, 
			addedby) 
			VALUES(
			:campus_code, 
			:campus_name, 
			:addedby)";
			
			// prepare query for execution
			$stmt = $this->db->prepare($query);
			
			// bind the parameters
			$stmt->bindParam(":campus_code", $campus_code, PDO::PARAM_STR);
			$stmt->bindParam(":campus_name", $campus_name, PDO::PARAM_STR);
			$stmt->bindParam(":addedby", $addedby, PDO::PARAM_STR); 
			
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
     * Get campus Details
     *
     * @param $campus_code
     * */
    public function check_if_campus_code_exists($campus_code)
    {
		try{
			// select query
			$query = "SELECT * FROM campuses WHERE ccode = :campus_code";
			// prepare query for execution			
			$stmt = $this->db->prepare($query);
			// bind the parameters
			$stmt->bindParam(":campus_code", $campus_code, PDO::PARAM_STR);
			// Execute the query
			$stmt->execute();
			
			$arr = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if (!$arr) {
				// array is empty.
				return null;
			}

			extract($arr); 
			
			return $ccode;		
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }
	
    /*
     * Update Record
     *
	 * @param $code
	 * @param $campus_number
	 * @param $owner_assigned
	 * @param $department

     * @return $mixed
     * */
    public function update_campus($campus_code, $campus_name, $id)
    {
		try{
			// Update query
			$query = "UPDATE campuses SET 
			ccode = :campus_code, 
			cname = :campus_name
			WHERE cid = :id";
			
			// prepare query for execution
			$stmt = $this->db->prepare($query);
			
			// bind the parameters
			$stmt->bindParam(":campus_code", $campus_code, PDO::PARAM_STR);
			$stmt->bindParam(":campus_name", $campus_name, PDO::PARAM_STR); 
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
     * Get campus Details
     *
     * @param $id
     * */
    public function get_campus($id)
    {
		try{
			// select query
			$query = "SELECT * FROM campuses WHERE cid = :id";
			
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
     * Delete Record
     *
     * @param $id
     * */
    public function delete_campus($id)
    {
		try{
			// delete query
			$query = "DELETE FROM campuses WHERE cid = :id";
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
 
	public function get_paginated_campuses_table($page, $records_to_display)
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
		$query = "SELECT * FROM campuses ORDER BY cid DESC LIMIT :from_record_num, :records_per_page";
		 
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
			echo "<table class='table table-dark table-striped table-hover table-bordered table-sm' id='table_campuses'>";//start table

			//creating our table heading
			echo "<thead class='thead-dark'>";
			echo "<tr>";
				echo "<th scope='col'>#</th>";
				echo "<th scope='col'>Code</th>";
				echo "<th scope='col'>Name</th>";
				echo "<th scope='col'>Aded By</th>"; 
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
				 					
				$id = $row['cid'];
				$campus_code = $row['ccode'];
				$campus_name = $row['cname'];
				$addedby = $row['addedby']; 
 
				// creating new table row per record
				echo "<tr class='table-primary'>";
					
				echo "<td class='table-success'>";
								
				echo htmlspecialchars($id, ENT_QUOTES);
			
				echo "</td>";
			 
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($campus_code, ENT_QUOTES);

				echo "</td>";
					
				echo "<td class='table-info'>";
					
				echo htmlspecialchars($campus_name, ENT_QUOTES);

				echo "</td>";
			 
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($addedby, ENT_QUOTES);

				echo "</td>"; 
			 
				echo "<td class='table-light'>";
					
				echo "<a onClick='edit_campus({$id})' style='cursor:hand !important;' 
				class='btn btn-info m-r-1em crud_buttons btn_edit' 
				title='edit'  
				data-id='{$id}' 
				data-toggle='popover' 
				data-placement='auto' 
				data-trigger='hover' 
				data-content='edit campus' >
				edit
					<span class='glyphicon'>
					</span>
				</a>";
								
				echo "<a onClick='delete_campus({$id})' style='cursor:hand !important;' 
				class='btn btn-danger m-r-1em crud_buttons btn_delete' 
				title='delete'  
				data-id='{$id}' 
				data-toggle='popover' 
				data-placement='auto' 
				data-trigger='hover' 
				data-content='delete campus' >
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
			$query = "SELECT COUNT(*) as total_rows FROM campuses";
			$stmt = $this->db->prepare($query);
			 
			// execute query
			$stmt->execute();
			 
			// get total rows
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$total_rows = $row['total_rows'];

			// paginate records
			$page_url="campuses.php?";
			include_once "paging_campuses_table.php";
		}
		 
		// if no records found
		else{
			echo "<div class='alert alert-danger'>No records found.</div>";
		}
	}
 
	public function search_campuses($page, $records_to_display, $campus_code, $campus_name)
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
		 
		//$total_rows = $this->count_search_campuses($campus_code, $department, $extension_number);
		 
		// select data for current page
		
		/*SEARCH SENARIOS
			1. all items are specified.
			2. code only typed.
			3. name only typed.			
			4. added by only selected.
			5. no item is specified.		
		*/
		
		//all items are specified.
		if(!empty($campus_code) && !empty($campus_name) && !empty($addedby))
		{
			$query = "SELECT * FROM campuses WHERE ccode LIKE :campus_code AND cname LIKE :campus_name ORDER BY ccode, cname, addedby ASC LIMIT :from_record_num, :records_per_page";
						
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			 
			$pattern  = '%' . $campus_code . '%';
			
			$stmt->bindParam(":campus_code", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $campus_name . '%';
			
			$stmt->bindParam(":campus_name", $pattern, PDO::PARAM_STR);
				 
		}
		//code only typed.
		else if(!empty($campus_code) && empty($campus_name))
		{
			$query = "SELECT * FROM campuses WHERE ccode LIKE :campus_code ORDER BY ccode ASC LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
						
			$pattern  = '%' . $campus_code . '%';
			
			$stmt->bindParam(":campus_code", $pattern, PDO::PARAM_STR);
				
		}
		//name only typed.
		else if(empty($campus_code) && !empty($campus_name))
		{
			$query = "SELECT * FROM campuses WHERE cname LIKE :campus_name ORDER BY cname, ccode ASC LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
						
			$pattern  = '%' . $campus_name . '%';
			
			$stmt->bindParam(":campus_name", $pattern, PDO::PARAM_STR);
				
		} 
		//no item is specified.
		else if(empty($campus_code) && empty($campus_name))
		{				
			$query = "SELECT * FROM campuses ORDER BY cid DESC LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			//$_SESSION['campuses_count'] = 0;			
			//return;
		}
		else
		{ 
			$_SESSION['campuses_count'] = 0;
			return;
		}

		$stmt->execute();
				 
		// this is how to get number of rows returned
		$num = $stmt->rowCount();
		
		$_SESSION['campuses_count'] = $num;

		$total_rows = $num;
		
		//echo $num;
		// link to create record form
		//echo "<a href='create.php' class='btn btn-primary m-b-1em'>Create New Product</a>";
		 
		//check if more than 0 record found
		if($num>0){
		 
			// data from database will be here
			echo "<table class='table table-dark table-striped table-hover table-bordered table-sm' id='table_campuses'>";//start table

			//creating our table heading
			echo "<thead class='thead-dark'>";
			echo "<tr>";
				echo "<th scope='col'>#</th>";
				echo "<th scope='col'>Code</th>";
				echo "<th scope='col'>Name</th>";
				echo "<th scope='col'>Added By</th>"; 
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
				 					
				$id = $row['cid'];
				$campus_code = $row['ccode'];
				$campus_name = $row['cname'];
				$addedby = $row['addedby']; 
 
				$counta++;
				
				//$id = $counta;
					
				// creating new table row per record
				echo "<tr class='table-primary'>";
					
				echo "<td class='table-success'>";
								
				echo htmlspecialchars($id, ENT_QUOTES);
			
				echo "</td>";
			 
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($campus_code, ENT_QUOTES);

				echo "</td>";
					
				echo "<td class='table-info'>";
					
				echo htmlspecialchars($campus_name, ENT_QUOTES);

				echo "</td>";
			 
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($addedby, ENT_QUOTES);

				echo "</td>";
					  
				echo "<td class='table-light'>";
					
				echo "<a onClick='edit_campus({$id})' style='cursor:hand !important;' 
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
								
				echo "<a onClick='delete_campus({$id})' style='cursor:hand !important;' 
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
			// $query = "SELECT COUNT(*) as total_rows FROM campuses";
			// $stmt = $this->db->prepare($query);
			 
			// // execute query
			// $stmt->execute();
			 
			// // get total rows
			// $row = $stmt->fetch(PDO::FETCH_ASSOC);
			// $total_rows = $row['total_rows'];
			
			//$total_rows = $this->count_search_campuses($campus_code, $department, $extension_number);
			
			// paginate records
			$page_url="campuses.php?";
			include_once "paging_search_campuses_table.php";
		}
		 
		// if no records found
		else{
			echo "<div class='alert alert-danger'>No records found.</div>";
		}
	}
 
 
 




}

?>
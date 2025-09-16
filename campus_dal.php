
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
	public function create_campus($campus_name, $status, $addedby)
    {
		try{
			
			$is_campus_name = $this->check_if_campus_name_exists($campus_name);
			 
			if($is_campus_name)
			{
				$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>Campus [ ' . $campus_name . ' ] exists.</div>';
				return $response;
			}
			
			// insert query
			$query = "INSERT INTO tbl_campuses( 
			campus_name, 
			status, 
			created_date, 
			addedby) 
			VALUES( 
			:campus_name, 
			:status,
			:created_date,			
			:addedby)";
			
			// prepare query for execution
			$stmt = $this->db->prepare($query);
			
			// bind the parameters 
			$campus_name = ucwords($campus_name);
			$stmt->bindParam(":campus_name", $campus_name, PDO::PARAM_STR);
			$stmt->bindParam(":status", $status, PDO::PARAM_STR); 
			$created_date = date('d-m-Y h:i:s A');
			$stmt->bindParam(":created_date", $created_date, PDO::PARAM_STR); 
			$stmt->bindParam(":addedby", $addedby, PDO::PARAM_STR); 
			
			// Execute the query
			$stmt->execute();
			
			// save lastInsertId in a variable
			$lastInsertId = $this->db->lastInsertId();
			
			$response = "<div class='alert alert-success'>Campus [ " . $campus_name . " ] was successfully created. <br /> Last Insert Id = [ " . $lastInsertId . " ]</div>";
			return $response;
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }

    /*
     * Get campus Details
     *
     * @param $campus_name
     * */
    public function check_if_campus_name_exists($campus_name)
    {
		try{
			// select query
			$query = "SELECT * FROM tbl_campuses 
			WHERE campus_name = :campus_name";

			// prepare query for execution			
			$stmt = $this->db->prepare($query);

			// bind the parameters
			$stmt->bindParam(":campus_name", $campus_name, PDO::PARAM_STR);

			// Execute the query
			$stmt->execute();
			
			$arr = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if (!$arr) {
				// array is empty.
				return null;
			}

			extract($arr); 
			
			return $campus_name;		
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }
	
    /*
     * Update Record
     * 
	 * @param $campus_name 
	 * @param $status
	 * @param $id
	 *
     * @return $mixed
     * */
    public function update_campus($campus_name, $status, $id)
    {
		try{
			// Update query
			$query = "UPDATE tbl_campuses SET  
			campus_name = :campus_name,  
			status = :status 
			WHERE id = :id";
			
			// prepare query for execution
			$stmt = $this->db->prepare($query);
			
			// bind the parameters 
			$campus_name = ucwords($campus_name);
			$stmt->bindParam(":campus_name", $campus_name, PDO::PARAM_STR); 
			$stmt->bindParam(":status", $status, PDO::PARAM_STR); 
			$stmt->bindParam(":id", $id, PDO::PARAM_STR);
			
			// Execute the query
			$stmt->execute();
 
			$response = "<div class='alert alert-success'>Campus [ " . $campus_name . " ] was successfully updated.</div>";
			
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
			$query = "SELECT * FROM tbl_campuses 
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
     * Get campus Details
     *
     * @param $id
     * */
    public function fetch_campus($id)
    {
		try{
			// select query
			$query = "SELECT * FROM tbl_campuses 
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
     * Delete Record
     *
     * @param $id
     * */
    public function delete_campus($id)
    {
		try{
			
			$campus_record = $this->fetch_campus($id);
			 
			foreach ($campus_record as $key => $value) {
				if($key == "campus_name") {
					$campus_name = $value; 
				} 
			}
			
			//check if this campus has an extension associated with it.
			$extensions_query =  "SELECT * FROM tbl_extensions as extensions  
			INNER JOIN tbl_campuses as campuses ON extensions.campus_id = campuses.id 
			WHERE extensions.campus_id = :campus_id";

			// prepare query for execution
			$extensions_stmt = $this->db->prepare($extensions_query);

			// bind the parameters
			$extensions_stmt->bindParam(":campus_id", $id, PDO::PARAM_STR);

			// Execute the query
			$extensions_stmt->execute();
			
			$extensions_arr = $extensions_stmt->fetch(PDO::FETCH_ASSOC);
			
			$extensions_count = $extensions_stmt->rowCount();

			$response = null;
			
			if (!$extensions_arr) {
				// array is empty.
				//continue with deletion.
			}else{
				//array has something, which means there is atleast an extension tied to this department.
				//warn the user.

				if($extensions_count > 1)
				{
					$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>[ ' .  $extensions_count . ' ] extensions are associated with this campus.</div>';
				}else{
					$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>[ ' .  $extensions_count . ' ] extension is associated with this campus.</div>';
				}
			
			}

			//check if this capus has a department associated with it.
			$departments_query =  "SELECT * FROM tbl_departments as departments 
			INNER JOIN tbl_campuses as campuses ON departments.campus_id = campuses.id 
			WHERE departments.campus_id = :campus_id";

			// prepare query for execution
			$departments_stmt = $this->db->prepare($departments_query);

			// bind the parameters
			$departments_stmt->bindParam(":campus_id", $id, PDO::PARAM_STR);

			// Execute the query
			$departments_stmt->execute();
			
			$departments_arr = $departments_stmt->fetch(PDO::FETCH_ASSOC);
			
			$departments_count = $departments_stmt->rowCount();

			if (!$departments_arr) {
				// array is empty.
				//continue with deletion.
			}else{
				//array has something, which means there is atleast an extension tied to this department.
				//warn the user.

				if($departments_count > 1)
				{
					$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>[ ' .  $departments_count . ' ] departments are associated with this campus.</div>';
				}else{
					$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>[ ' .  $departments_count . ' ] department is associated with this campus.</div>';
				}
			
			}

			if($response)
			{
				return $response;
			}

			// delete query
			$query = "DELETE FROM tbl_campuses 
			WHERE id = :id";

			// prepare query for execution
			$stmt = $this->db->prepare($query);

			// bind the parameters
			$stmt->bindParam(":id", $id, PDO::PARAM_STR);

			// Execute the query
			$stmt->execute();
			
			$response = "<div class='alert alert-success'>Campus [ " . $campus_name . " ] was successfully deleted.</div>";
			return $response;
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }
   
	public function search_campuses_v2($page, $records_to_display, $campus_name)
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
			1. name only typed.			 
			2. no item is specified.		
		*/
		 
		//name only typed.
		if(!empty($campus_name))
		{
			$query = "SELECT * FROM tbl_campuses 
			WHERE campus_name LIKE :campus_name 
			ORDER BY campus_name ASC 
			LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
						
			$pattern  = '%' . $campus_name . '%';
			
			$stmt->bindParam(":campus_name", $pattern, PDO::PARAM_STR);
			
			
			$count_query = "SELECT * FROM tbl_campuses 
			WHERE campus_name LIKE :campus_name 
			ORDER BY campus_name ASC";
			
			$count_stmt = $this->db->prepare($count_query);
			  
			$pattern  = '%' . $campus_name . '%';
			
			$count_stmt->bindParam(":campus_name", $pattern, PDO::PARAM_STR);
				 	
		} 
		//no item is specified.
		else if(empty($campus_name))
		{				
			$query = "SELECT * FROM tbl_campuses 
			ORDER BY id DESC 
			LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			
			$count_query = "SELECT * FROM tbl_campuses 
			ORDER BY id DESC";
			
			$count_stmt = $this->db->prepare($count_query);
			   
		}
		else
		{ 
			$_SESSION['campuses_count'] = 0;
			return;
		}

		$stmt->execute();
			
		$count_stmt->execute();
				 
		// this is how to get number of rows returned
		$num = $stmt->rowCount();
		
		$count_num = $count_stmt->rowCount();
		
		$_SESSION['campuses_count'] = $count_num;

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
				$campus_name = $row['campus_name'];
				$status = $row['status'];
				$created_date = $row['created_date']; 
				$addedby = $row['addedby']; 
 
				$counta++;
				
				//$id = $counta;
					
				// creating new table row per record
				echo "<tr class='table-primary'>";
					
				echo "<td class='table-success'>";
								
				echo htmlspecialchars($id, ENT_QUOTES);
			
				echo "</td>";
			  
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($campus_name, ENT_QUOTES);

				echo "</td>";
			    
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($status, ENT_QUOTES);

				echo "</td>"; 
			 
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($created_date, ENT_QUOTES);

				echo "</td>"; 
			 
				echo "<td class='table-success'>";
					
				echo "<a onClick='edit_campus({$id})' style='cursor:hand !important;' 
				class='btn btn-info m-r-1em crud_buttons btn_edit btn_edit_campus' 
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
				class='btn btn-danger m-r-1em crud_buttons btn_delete btn_delete_campus' 
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
			// $query = "SELECT COUNT(*) as total_rows FROM tbl_campuses";
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

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
		 
class search_dal
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
	 * @param $code
	 * @param $extension_number
	 * @param $owner_assigned
	 * @param $department
     * @return $string
     * */
	public function create_extension($code, $extension_number, $owner_assigned, $department)
    {
		try{
			
			$extension_no = $this->get_extension_given_number($extension_number);
			
			if(!empty($extension_no))
			{
				$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>Extension number [ ' . $extension_number . ' ] exists.</div>';
				return $response;
			}
			
			// insert query
			$query = "INSERT INTO depts(
			ccode, 
			deptcode, 
			ownerassigned, 
			deptname) 
			VALUES(
			:code, 
			:extension_number, 
			:owner_assigned, 
			:department)";
			// prepare query for execution
			$stmt = $this->db->prepare($query);
			// bind the parameters
			$stmt->bindParam(":code", $code, PDO::PARAM_STR);
			$stmt->bindParam(":extension_number", $extension_number, PDO::PARAM_STR);
			$stmt->bindParam(":owner_assigned", $owner_assigned, PDO::PARAM_STR);
			$stmt->bindParam(":department", $department, PDO::PARAM_STR);
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
     * Update Record
     *
	 * @param $code
	 * @param $extension_number
	 * @param $owner_assigned
	 * @param $department

     * @return $mixed
     * */
    public function update_extension($code, $extension_number, $owner_assigned, $department, $id)
    {
		try{
			// Update query
			$query = "UPDATE depts SET 
			ccode = :code, 
			deptcode = :extension_number,  
			ownerassigned = :owner_assigned, 
			deptname = :department
			WHERE id = :id";
			// prepare query for execution
			$stmt = $this->db->prepare($query);
			// bind the parameters
			$stmt->bindParam(":code", $code, PDO::PARAM_STR);
			$stmt->bindParam(":extension_number", $extension_number, PDO::PARAM_STR);
			$stmt->bindParam(":owner_assigned", $owner_assigned, PDO::PARAM_STR);
			$stmt->bindParam(":department", $department, PDO::PARAM_STR);
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
     * Get extension Details
     *
     * @param $id
     * */
    public function get_extension($id)
    {
		try{
			// select query
			$query = "SELECT * FROM depts WHERE id = :id";
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
     * @param $extension_number
     * */
    public function get_extension_given_number($extension_number)
    {
		try{
			// select query
			$query = "SELECT * FROM depts WHERE deptcode = :extension_number";
			// prepare query for execution			
			$stmt = $this->db->prepare($query);
			// bind the parameters
			$stmt->bindParam(":extension_number", $extension_number, PDO::PARAM_STR);
			// Execute the query
			$stmt->execute();
			
			$arr = $stmt->fetch(PDO::FETCH_ASSOC);
			
			return count($arr);			
			
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
			$query = "SELECT * FROM depts ORDER BY id DESC";
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
			// delete query
			$query = "DELETE FROM depts WHERE id = :id";
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
			$query = "SELECT * FROM campuses ORDER BY cid ASC";
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
			$query = "SELECT ccode FROM campuses ORDER BY cid ASC";
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
			$query = "SELECT DISTINCT cname FROM campuses ORDER BY cid ASC";
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
    public function get_department_names($campus_code)
    {
		try{
			// select query - select all data
			$query = "SELECT DISTINCT deptname FROM depts WHERE ccode = :campus_code ORDER BY id ASC";
			// prepare query for execution	
			$stmt = $this->db->prepare($query);
			// bind the parameters
			$stmt->bindParam(":campus_code", $campus_code, PDO::PARAM_STR);
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

	public function get_paginated_extensions_table($page, $records_to_display)
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
		$query = "SELECT * FROM depts ORDER BY id DESC LIMIT :from_record_num, :records_per_page";
		 
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
			echo "<table class='table table-dark table-striped table-hover table-bordered table-sm' id='table_extensions'>";//start table

			//creating our table heading
			echo "<thead class='thead-dark'>";
			echo "<tr>";
				echo "<th scope='col'>id</th>";
				echo "<th scope='col'>campus</th>";
				echo "<th scope='col'>extension no</th>";
				echo "<th scope='col'>owner assigned</th>";
				echo "<th scope='col'>department</th>"; 
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
				$code = $row['ccode'];
				$extension_number = $row['deptcode'];
				$owner_assigned = $row['ownerassigned'];
				$department = $row['deptname'];

				$campus_name = $this->get_campus_name_given_code($code);
				 
				// creating new table row per record
				echo "<tr class='table-primary'>";
					
				echo "<td class='table-success'>";
								
				echo htmlspecialchars($id, ENT_QUOTES);
			
				echo "</td>";
			 
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($campus_name, ENT_QUOTES);

				echo "</td>";
					
				echo "<td class='table-info'>";
					
				echo htmlspecialchars($extension_number, ENT_QUOTES);

				echo "</td>";
			 
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($owner_assigned, ENT_QUOTES);

				echo "</td>";
					
				echo "<td class='table-warning'>";
					
				echo htmlspecialchars($department, ENT_QUOTES);

				echo "</td>";
			 
				echo "<td class='table-light'>";
					
				echo "<a onClick='edit_extension({$id})' style='cursor:hand !important;' 
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
								
				echo "<a onClick='delete_extension({$id})' style='cursor:hand !important;' 
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
			$query = "SELECT COUNT(*) as total_rows FROM depts";
			$stmt = $this->db->prepare($query);
			 
			// execute query
			$stmt->execute();
			 
			// get total rows
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$total_rows = $row['total_rows'];

			// paginate records
			$page_url="admin_index.php?";
			include_once "paging_extensions_table.php";
		}
		 
		// if no records found
		else{
			echo "<div class='alert alert-danger'>No records found.</div>";
		}
	}
 
	public function search_extensions($page, $records_to_display, $campus_code, $department, $extension_number, $txtdepartment, $txtowner_assigned)
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
		 
		//$total_rows = $this->count_search_extensions($campus_code, $department, $extension_number, $txtdepartment, $txtowner_assigned);
		 
		// select data for current page
		
		
		/*SEARCH SENARIOS
			1. all items are specified.
			2. extension only typed.
			3. department only typed.			
			4. department only selected.
			5. owner assigned only typed.
			6. campus and department selected.		
			7. campus and department selected and extension typed.
			8. campus and department selected and department typed.
			9. campus and department selected and owner assigned typed.		
			10. campus and extension typed.
			11. campus and department typed.
			12. campus and owner assigned typed.
			13. no item is specified.		
		*/
		
		//all items are specified.
		if(!empty($campus_code) && !empty($department) && !empty($extension_number) && !empty($txtdepartment) && !empty($txtowner_assigned))
		{
			$query = "SELECT * FROM depts WHERE ccode = :campus_code AND deptname = :department AND deptcode LIKE :extension_number  AND deptname LIKE :txtdepartment AND ownerassigned LIKE :txtowner_assigned ORDER BY ccode, deptname, ownerassigned ASC LIMIT :from_record_num, :records_per_page";
						
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			$stmt->bindParam(":campus_code", $campus_code, PDO::PARAM_STR);
			$stmt->bindParam(":department", $department, PDO::PARAM_STR);
			
			$pattern  = '%' . $extension_number . '%';
			
			$stmt->bindParam(":extension_number", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $txtdepartment . '%';
			
			$stmt->bindParam(":txtdepartment", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $txtowner_assigned . '%';
			
			$stmt->bindParam(":txtowner_assigned", $pattern, PDO::PARAM_STR);
				
		}
		//extension only typed.
		else if(empty($campus_code) && empty($department) && !empty($extension_number) && empty($txtdepartment) && empty($txtowner_assigned))
		{
			$query = "SELECT * FROM depts WHERE deptcode LIKE :extension_number ORDER BY deptcode, ccode ASC LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
						
			$pattern  = '%' . $extension_number . '%';
			
			$stmt->bindParam(":extension_number", $pattern, PDO::PARAM_STR);
				
		}
		//department only typed.
		else if(empty($campus_code) && empty($department) && empty($extension_number) && !empty($txtdepartment) && empty($txtowner_assigned))
		{
			$query = "SELECT * FROM depts WHERE deptname LIKE :txtdepartment ORDER BY deptname, ccode ASC LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
						
			$pattern  = '%' . $txtdepartment . '%';
			
			$stmt->bindParam(":txtdepartment", $pattern, PDO::PARAM_STR);
				
		}
		//department only selected.
		else if(empty($campus_code) && !empty($department) && empty($extension_number) && empty($txtdepartment) && empty($txtowner_assigned))
		{
			$query = "SELECT * FROM depts WHERE deptname LIKE :department ORDER BY deptname, ccode ASC LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
						
			$stmt->bindParam(":department", $department, PDO::PARAM_STR); 
				
		}
		//owner assigned only typed.
		else if(empty($campus_code) && empty($department) && empty($extension_number) && empty($txtdepartment) && !empty($txtowner_assigned))
		{
			$query = "SELECT * FROM depts WHERE ownerassigned LIKE :txtowner_assigned ORDER BY ownerassigned, ccode ASC LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
						
			$pattern  = '%' . $txtowner_assigned . '%';
			
			$stmt->bindParam(":txtowner_assigned", $pattern, PDO::PARAM_STR);
				
		}
		//campus and department selected.
		else if(!empty($campus_code) && !empty($department) && empty($extension_number) && empty($txtdepartment) && empty($txtowner_assigned))
		{				
			$query = "SELECT * FROM depts WHERE ccode = :campus_code AND deptname = :department ORDER BY ccode, deptname ASC LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			$stmt->bindParam(":campus_code", $campus_code, PDO::PARAM_STR);
			$stmt->bindParam(":department", $department, PDO::PARAM_STR); 
				
		} 
		//campus and department selected and extension typed.
		else if(!empty($campus_code) && !empty($department) && !empty($extension_number) && empty($txtdepartment) && empty($txtowner_assigned))
		{				
			$query = "SELECT * FROM depts WHERE ccode = :campus_code AND deptname = :department AND deptcode LIKE :extension_number ORDER BY ccode, deptname, deptcode ASC LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			$stmt->bindParam(":campus_code", $campus_code, PDO::PARAM_STR);
			$stmt->bindParam(":department", $department, PDO::PARAM_STR); 
			
			$pattern  = '%' . $extension_number . '%';
			
			$stmt->bindParam(":extension_number", $pattern, PDO::PARAM_STR);
					
		}
		//campus and department selected and department typed.
		else if(!empty($campus_code) && !empty($department) && empty($extension_number) && !empty($txtdepartment) && empty($txtowner_assigned))
		{				
			$query = "SELECT * FROM depts WHERE ccode = :campus_code AND deptname = :department AND deptname LIKE :txtdepartment ORDER BY ccode, deptname ASC LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			$stmt->bindParam(":campus_code", $campus_code, PDO::PARAM_STR);
			$stmt->bindParam(":department", $department, PDO::PARAM_STR); 
			
			$pattern  = '%' . $txtdepartment . '%';
			
			$stmt->bindParam(":txtdepartment", $pattern, PDO::PARAM_STR);
					
		}
		//campus and department selected and owner assigned typed.
		else if(!empty($campus_code) && !empty($department) && empty($extension_number) && empty($txtdepartment) && !empty($txtowner_assigned))
		{				
			$query = "SELECT * FROM depts WHERE ccode = :campus_code AND deptname = :department AND ownerassigned LIKE :txtowner_assigned ORDER BY ccode, deptname, ownerassigned ASC LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			$stmt->bindParam(":campus_code", $campus_code, PDO::PARAM_STR);
			$stmt->bindParam(":department", $department, PDO::PARAM_STR); 
			
			$pattern  = '%' . $txtowner_assigned . '%';
			
			$stmt->bindParam(":txtowner_assigned", $pattern, PDO::PARAM_STR);
					
		} 
		//campus and extension typed.
		else if(!empty($campus_code) && empty($department) && !empty($extension_number) && empty($txtdepartment) && empty($txtowner_assigned))
		{				
			$query = "SELECT * FROM depts WHERE ccode = :campus_code AND deptcode LIKE :extension_number ORDER BY ccode, deptcode ASC LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			$stmt->bindParam(":campus_code", $campus_code, PDO::PARAM_STR);
			
			$pattern  = '%' . $extension_number . '%';
			
			$stmt->bindParam(":extension_number", $pattern, PDO::PARAM_STR);
				
		}
		//campus and department typed.
		else if(!empty($campus_code) && empty($department) && empty($extension_number) && !empty($txtdepartment) && empty($txtowner_assigned))
		{				
			$query = "SELECT * FROM depts WHERE ccode = :campus_code AND deptname LIKE :txtdepartment ORDER BY ccode, deptname ASC LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			$stmt->bindParam(":campus_code", $campus_code, PDO::PARAM_STR);
			
			$pattern  = '%' . $txtdepartment . '%';
			
			$stmt->bindParam(":txtdepartment", $pattern, PDO::PARAM_STR);
				
		}
		//campus and owner assigned typed.
		else if(!empty($campus_code) && empty($department) && empty($extension_number) && empty($txtdepartment) && !empty($txtowner_assigned))
		{				
			$query = "SELECT * FROM depts WHERE ccode = :campus_code AND ownerassigned LIKE :txtowner_assigned ORDER BY ccode, ownerassigned ASC LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			$stmt->bindParam(":campus_code", $campus_code, PDO::PARAM_STR);
			
			$pattern  = '%' . $txtowner_assigned . '%';
			
			$stmt->bindParam(":txtowner_assigned", $pattern, PDO::PARAM_STR);
				
		}
		//no item is specified.
		else if(empty($campus_code) && empty($department) && empty($extension_number) && empty($txtdepartment) && empty($txtowner_assigned))
		{				
			$query = "SELECT * FROM depts ORDER BY id ASC LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			$_SESSION['search_count'] = 0;			
			return;
		}
		else
		{ 
			$_SESSION['search_count'] = 0;
			return;
		}

		$stmt->execute();
				 
		// this is how to get number of rows returned
		$num = $stmt->rowCount();
		
		$_SESSION['search_count'] = $num;

		//$total_rows = $num;

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
				echo "<th scope='col'>Extension No</th>";
				echo "<th scope='col'>Owner Assigned</th>";
				echo "<th scope='col'>Department</th>";  
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
				$code = $row['ccode'];
				$extension_number = $row['deptcode'];
				$owner_assigned = $row['ownerassigned'];
				$department = $row['deptname'];

				$campus_name = $this->get_campus_name_given_code($code);
				 
				// creating new table row per record
				echo "<tr class='table-primary'>";
								 
				echo "<td class='table-success'>";
					
				echo "<span class='tbl_label'>Campus: </span>";
				
				echo "<span class='tbl_data'>" . htmlspecialchars($campus_name, ENT_QUOTES) . "</span>";

				echo "</td>";
				
				echo "<td class='table-info'>";
					
				echo "<span class='tbl_label'>Extension: </span>";
				
				echo "<span class='tbl_data'>" . htmlspecialchars($extension_number, ENT_QUOTES) . "</span>";

				echo "</td>";
			 
				echo "<td class='table-success'>";
					
				echo "<span class='tbl_label'>Owner: </span>";
				
				echo "<span class='tbl_data'>" . htmlspecialchars($owner_assigned, ENT_QUOTES) . "</span>";

				echo "</td>";
					
				echo "<td class='table-warning'>";
					
				echo "<span class='tbl_label'>Department: </span>";
				
				echo "<span class='tbl_data'>" . htmlspecialchars($department, ENT_QUOTES) . "</span>";

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
			// $query = "SELECT COUNT(*) as total_rows FROM depts";
			// $stmt = $this->db->prepare($query);
			 
			// // execute query
			// $stmt->execute();
			 
			// // get total rows
			// $row = $stmt->fetch(PDO::FETCH_ASSOC);
			// $total_rows = $row['total_rows'];
			
			//$total_rows = $num;
			
			// paginate records
			$page_url="index.php?";
			include_once "paging_search_table.php";
		}
		 
		// if no records found
		else{
			echo "<div class='alert alert-danger'>No records found.</div>";
		}
	}
 
	public function search_extensions_v2($page, $records_to_display, $campus_code, $department, $extension_number, $txtdepartment, $txtowner_assigned)
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
		 
		//$total_rows = $this->count_search_extensions($campus_code, $department, $extension_number, $txtdepartment, $txtowner_assigned);
		 
		// select data for current page
		
		
		/*SEARCH SENARIOS
			1. all items are specified.
			2. extension only typed.
			3. department only typed.			
			4. department only selected.
			5. owner assigned only typed.
			6. campus and department selected.		
			7. campus and department selected and extension typed.
			8. campus and department selected and department typed.
			9. campus and department selected and owner assigned typed.		
			10. campus and extension typed.
			11. campus and department typed.
			12. campus and owner assigned typed.
			13. no item is specified.		
		*/
		
		//all items are specified.
		if(!empty($campus_code) && !empty($department) && !empty($extension_number) && !empty($txtdepartment) && !empty($txtowner_assigned))
		{
			$query = "SELECT * FROM depts WHERE ccode = :campus_code AND deptname = :department AND deptcode LIKE :extension_number  AND deptname LIKE :txtdepartment AND ownerassigned LIKE :txtowner_assigned ORDER BY ccode, deptname, ownerassigned ASC LIMIT :from_record_num, :records_per_page";
						
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			$stmt->bindParam(":campus_code", $campus_code, PDO::PARAM_STR);
			$stmt->bindParam(":department", $department, PDO::PARAM_STR);
			
			$pattern  = '%' . $extension_number . '%';
			
			$stmt->bindParam(":extension_number", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $txtdepartment . '%';
			
			$stmt->bindParam(":txtdepartment", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $txtowner_assigned . '%';
			
			$stmt->bindParam(":txtowner_assigned", $pattern, PDO::PARAM_STR);
				
		}
		//extension only typed.
		else if(empty($campus_code) && empty($department) && !empty($extension_number) && empty($txtdepartment) && empty($txtowner_assigned))
		{
			$query = "SELECT * FROM depts WHERE deptcode LIKE :extension_number ORDER BY deptcode, ccode ASC LIMIT :from_record_num, :records_per_page";
						
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			 
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
						
			$pattern  = '%' . $extension_number . '%';
			
			$stmt->bindParam(":extension_number", $pattern, PDO::PARAM_STR);
				
			
			
			$count_query = "SELECT * FROM depts WHERE deptcode LIKE :extension_number ORDER BY deptcode, ccode ASC";
			
			$count_stmt = $this->db->prepare($count_query);
			 
			$count_stmt->bindParam(":extension_number", $pattern, PDO::PARAM_STR);
					
				
		}
		//department only typed.
		else if(empty($campus_code) && empty($department) && empty($extension_number) && !empty($txtdepartment) && empty($txtowner_assigned))
		{
			$query = "SELECT * FROM depts WHERE deptname LIKE :txtdepartment ORDER BY deptname, ccode ASC LIMIT :from_record_num, :records_per_page";
								
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
						
			$pattern  = '%' . $txtdepartment . '%';
			
			$stmt->bindParam(":txtdepartment", $pattern, PDO::PARAM_STR);
			
			$count_query = "SELECT * FROM depts WHERE deptname LIKE :txtdepartment ORDER BY deptname, ccode ASC";
			
			$count_stmt = $this->db->prepare($count_query);
			 
			$count_stmt->bindParam(":txtdepartment", $pattern, PDO::PARAM_STR);
					
		}
		//department only selected.
		else if(empty($campus_code) && !empty($department) && empty($extension_number) && empty($txtdepartment) && empty($txtowner_assigned))
		{
			$query = "SELECT * FROM depts WHERE deptname LIKE :department ORDER BY deptname, ccode ASC LIMIT :from_record_num, :records_per_page";
			 				
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
						
			$stmt->bindParam(":department", $department, PDO::PARAM_STR); 
				
		}
		//owner assigned only typed.
		else if(empty($campus_code) && empty($department) && empty($extension_number) && empty($txtdepartment) && !empty($txtowner_assigned))
		{
			$query = "SELECT * FROM depts WHERE ownerassigned LIKE :txtowner_assigned ORDER BY ownerassigned, ccode ASC LIMIT :from_record_num, :records_per_page";
			 						
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
						
			$pattern  = '%' . $txtowner_assigned . '%';
			
			$stmt->bindParam(":txtowner_assigned", $pattern, PDO::PARAM_STR);
				
		}
		//campus and department selected.
		else if(!empty($campus_code) && !empty($department) && empty($extension_number) && empty($txtdepartment) && empty($txtowner_assigned))
		{				
			$query = "SELECT * FROM depts WHERE ccode = :campus_code AND deptname = :department ORDER BY ccode, deptname ASC LIMIT :from_record_num, :records_per_page";
			 				
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			$stmt->bindParam(":campus_code", $campus_code, PDO::PARAM_STR);
			$stmt->bindParam(":department", $department, PDO::PARAM_STR); 
				
		} 
		//campus and department selected and extension typed.
		else if(!empty($campus_code) && !empty($department) && !empty($extension_number) && empty($txtdepartment) && empty($txtowner_assigned))
		{				
			$query = "SELECT * FROM depts WHERE ccode = :campus_code AND deptname = :department AND deptcode LIKE :extension_number ORDER BY ccode, deptname, deptcode ASC LIMIT :from_record_num, :records_per_page";
 
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			$stmt->bindParam(":campus_code", $campus_code, PDO::PARAM_STR);
			$stmt->bindParam(":department", $department, PDO::PARAM_STR); 
			
			$pattern  = '%' . $extension_number . '%';
			
			$stmt->bindParam(":extension_number", $pattern, PDO::PARAM_STR);
					
		}
		//campus and department selected and department typed.
		else if(!empty($campus_code) && !empty($department) && empty($extension_number) && !empty($txtdepartment) && empty($txtowner_assigned))
		{				
			$query = "SELECT * FROM depts WHERE ccode = :campus_code AND deptname = :department AND deptname LIKE :txtdepartment ORDER BY ccode, deptname ASC LIMIT :from_record_num, :records_per_page";
			 					
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			$stmt->bindParam(":campus_code", $campus_code, PDO::PARAM_STR);
			$stmt->bindParam(":department", $department, PDO::PARAM_STR); 
			
			$pattern  = '%' . $txtdepartment . '%';
			
			$stmt->bindParam(":txtdepartment", $pattern, PDO::PARAM_STR);
					
		}
		//campus and department selected and owner assigned typed.
		else if(!empty($campus_code) && !empty($department) && empty($extension_number) && empty($txtdepartment) && !empty($txtowner_assigned))
		{				
			$query = "SELECT * FROM depts WHERE ccode = :campus_code AND deptname = :department AND ownerassigned LIKE :txtowner_assigned ORDER BY ccode, deptname, ownerassigned ASC LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			$stmt->bindParam(":campus_code", $campus_code, PDO::PARAM_STR);
			$stmt->bindParam(":department", $department, PDO::PARAM_STR); 
			
			$pattern  = '%' . $txtowner_assigned . '%';
			
			$stmt->bindParam(":txtowner_assigned", $pattern, PDO::PARAM_STR);
					
		} 
		//campus and extension typed.
		else if(!empty($campus_code) && empty($department) && !empty($extension_number) && empty($txtdepartment) && empty($txtowner_assigned))
		{				
			$query = "SELECT * FROM depts WHERE ccode = :campus_code AND deptcode LIKE :extension_number ORDER BY ccode, deptcode ASC LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			$stmt->bindParam(":campus_code", $campus_code, PDO::PARAM_STR);
			
			$pattern  = '%' . $extension_number . '%';
			
			$stmt->bindParam(":extension_number", $pattern, PDO::PARAM_STR);
				
		}
		//campus and department typed.
		else if(!empty($campus_code) && empty($department) && empty($extension_number) && !empty($txtdepartment) && empty($txtowner_assigned))
		{				
			$query = "SELECT * FROM depts WHERE ccode = :campus_code AND deptname LIKE :txtdepartment ORDER BY ccode, deptname ASC LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			$stmt->bindParam(":campus_code", $campus_code, PDO::PARAM_STR);
			
			$pattern  = '%' . $txtdepartment . '%';
			
			$stmt->bindParam(":txtdepartment", $pattern, PDO::PARAM_STR);
				
		}
		//campus and owner assigned typed.
		else if(!empty($campus_code) && empty($department) && empty($extension_number) && empty($txtdepartment) && !empty($txtowner_assigned))
		{				
			$query = "SELECT * FROM depts WHERE ccode = :campus_code AND ownerassigned LIKE :txtowner_assigned ORDER BY ccode, ownerassigned ASC LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			$stmt->bindParam(":campus_code", $campus_code, PDO::PARAM_STR);
			
			$pattern  = '%' . $txtowner_assigned . '%';
			
			$stmt->bindParam(":txtowner_assigned", $pattern, PDO::PARAM_STR);
				
		}
		//no item is specified.
		else if(empty($campus_code) && empty($department) && empty($extension_number) && empty($txtdepartment) && empty($txtowner_assigned))
		{				
			$query = "SELECT * FROM depts ORDER BY id ASC LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			$_SESSION['search_count'] = 0;			
			return;
		}
		else
		{ 
			$_SESSION['search_count'] = 0;
			return;
		}

		$stmt->execute();
			
		$count_stmt->execute();
				 
		// this is how to get number of rows returned
		$num = $stmt->rowCount();
		
		$count_num = $count_stmt->rowCount();
		
		$_SESSION['search_count'] = $count_num;

		//$total_rows = $num;

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
				echo "<th scope='col'>Extension No</th>";
				echo "<th scope='col'>Owner Assigned</th>";
				echo "<th scope='col'>Department</th>";  
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
				$code = $row['ccode'];
				$extension_number = $row['deptcode'];
				$owner_assigned = $row['ownerassigned'];
				$department = $row['deptname'];

				$campus_name = $this->get_campus_name_given_code($code);
				 
				// creating new table row per record
				echo "<tr class='table-primary'>";
								 
				echo "<td class='table-success'>";
					
				echo "<span class='tbl_label'>Campus: </span>";
				
				echo "<span class='tbl_data'>" . htmlspecialchars($campus_name, ENT_QUOTES) . "</span>";

				echo "</td>";
				
				echo "<td class='table-info'>";
					
				echo "<span class='tbl_label'>Extension: </span>";
				
				echo "<span class='tbl_data'>" . htmlspecialchars($extension_number, ENT_QUOTES) . "</span>";

				echo "</td>";
			 
				echo "<td class='table-success'>";
					
				echo "<span class='tbl_label'>Owner: </span>";
				
				echo "<span class='tbl_data'>" . htmlspecialchars($owner_assigned, ENT_QUOTES) . "</span>";

				echo "</td>";
					
				echo "<td class='table-warning'>";
					
				echo "<span class='tbl_label'>Department: </span>";
				
				echo "<span class='tbl_data'>" . htmlspecialchars($department, ENT_QUOTES) . "</span>";

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
			// $query = "SELECT COUNT(*) as total_rows FROM depts";
			// $stmt = $this->db->prepare($query);
			 
			// // execute query
			// $stmt->execute();
			 
			// // get total rows
			// $row = $stmt->fetch(PDO::FETCH_ASSOC);
			// $total_rows = $row['total_rows'];
			
			//$total_rows = $num;
			
			// paginate records
			$page_url="index.php?";
			include_once "paging_search_table.php";
		}
		 
		// if no records found
		else{
			echo "<div class='alert alert-danger'>No records found.</div>";
		}
	}
 
	public function count_search_extensions($campus_code, $department, $extension_number)
	{		 
		// select data for current page		
		if(!empty($campus_code) && !empty($department) && !empty($extension_number))
		{
			$query = "SELECT COUNT(*) FROM depts WHERE ccode = :campus_code AND deptname = :department AND deptcode LIKE :extension_number ORDER BY id DESC";
						
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			 
			$stmt->bindParam(":campus_code", $campus_code, PDO::PARAM_STR);
			$stmt->bindParam(":department", $department, PDO::PARAM_STR);
			
			$pattern  = '%' . $extension_number . '%';
			
			$stmt->bindParam(":extension_number", $pattern, PDO::PARAM_STR);
				
		}
		else if(empty($campus_code) && empty($department) && !empty($extension_number))
		{
			$query = "SELECT COUNT(*) FROM depts WHERE deptcode LIKE :extension_number ORDER BY id DESC";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			 
			$pattern  = '%' . $extension_number . '%';
			
			$stmt->bindParam(":extension_number", $pattern, PDO::PARAM_STR);
				
		}
		else if(!empty($campus_code) && !empty($department) && empty($extension_number))
		{				
			$query = "SELECT COUNT(*) FROM depts WHERE ccode = :campus_code AND deptname = :department ORDER BY id DESC";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);
 
			$stmt->bindParam(":campus_code", $campus_code, PDO::PARAM_STR);
			$stmt->bindParam(":department", $department, PDO::PARAM_STR); 
				
		}
		else if(empty($campus_code) && empty($department) && empty($extension_number))
		{				
			$query = "SELECT COUNT(*) FROM depts ORDER BY id DESC";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);
 
		}
		else
		{
			return;
		}

		$stmt->execute();
				 
		// this is how to get number of rows returned
		$num = $stmt->rowCount();
		//echo $num;	
		return $num;
	}
 
 
 
 




}

?>
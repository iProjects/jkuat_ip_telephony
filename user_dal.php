
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
    //protected $converter;

    function __construct()
    { 
		$this->db = DB();
		//$this->converter = new Encryption;
    }

    function __destruct()
    {
        $this->db = null;
        //$this->converter = null;
    }
 
    /*
     * Add new Record
     *
	 * @param $email
	 * @param $full_names
	 * @param $pass_word
	 * @param $secret_word 
	 * @param $status 
	 * @param $addedby 
	 *
     * @return $string
     * */
	public function create_user($email, $full_names, $encoded_password, $password_hash, $secret_word, $status, $addedby)
    {
		try{
			
			$is_email = $this->check_if_email_exists($email);
			 
			if($is_email)
			{
				$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>User with Email [ ' . $email . ' ] exists.</div>';
				return $response;
			}
			 
			// insert query
			$query = "INSERT INTO tbl_users(
			email, 
			full_names, 
			pass_word,
			password_hash,
			secret_word,  			 
			addedby,  
			status, 			
			created_date) 
			VALUES(
			:email, 
			:full_names, 
			:pass_word,
			:password_hash,
			:secret_word, 			 
			:addedby,  
			:status,			
			:created_date)";
			
			// prepare query for execution
			$stmt = $this->db->prepare($query);
			
			// bind the parameters
			$stmt->bindParam(":email", $email, PDO::PARAM_STR);
			$full_names = ucwords($full_names); 
			$stmt->bindParam(":full_names", $full_names, PDO::PARAM_STR);
			$stmt->bindParam(":pass_word", $encoded_password, PDO::PARAM_STR); 
			$stmt->bindParam(":password_hash", $password_hash, PDO::PARAM_STR); 
			$stmt->bindParam(":secret_word", $secret_word, PDO::PARAM_STR);
			$stmt->bindParam(":addedby", $addedby, PDO::PARAM_STR);  
			$stmt->bindParam(":status", $status, PDO::PARAM_STR); 
			$created_date = date('d-m-Y h:i:s A');
			$stmt->bindParam(":created_date", $created_date, PDO::PARAM_STR);   
			
			// Execute the query
			$stmt->execute();
			
			// save lastInsertId in a variable
			$lastInsertId = $this->db->lastInsertId();
			
			$response = "<div class='alert alert-success'>User with Email [ " . $email . " ] was successfully created. <br />Last Insert Id = [ " . $lastInsertId . " ]</div>";
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
			$query = "SELECT * FROM tbl_users 
			WHERE email = :email";

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
     * @param $full_names
     * */
    public function check_if_full_names_exists($full_names)
    {
		try{
			// select query
			$query = "SELECT * FROM tbl_users 
			WHERE full_names = :full_names";

			// prepare query for execution			
			$stmt = $this->db->prepare($query);

			// bind the parameters
			$stmt->bindParam(":full_names", $full_names, PDO::PARAM_STR);

			// Execute the query
			$stmt->execute();
			
			$arr = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if (!$arr) {
				// array is empty.
				return null;
			}

			extract($arr); 
			
			return $full_names;		
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }
	
    /*
     * Update Record
     *
	 * @param $email
	 * @param $full_names
	 * @param $pass_word
	 * @param $secret_word 
	 * @param $status 
	 * @param $id
	 *
     * @return $mixed
     * */
    public function update_user($email, $full_names, $encoded_password, $password_hash, $secret_word, $status, $id)
    {
		try{
			// Update query
			$query = "UPDATE tbl_users SET 
			email = :email, 
			full_names = :full_names,  
			pass_word = :pass_word, 
			password_hash = :password_hash, 
			secret_word = :secret_word, 
			status = :status   
			WHERE id = :id";
			
			// prepare query for execution
			$stmt = $this->db->prepare($query);
			
			// bind the parameters
			$stmt->bindParam(":email", $email, PDO::PARAM_STR);
			$full_names = ucwords($full_names); 
			$stmt->bindParam(":full_names", $full_names, PDO::PARAM_STR);
			$stmt->bindParam(":pass_word", $encoded_password, PDO::PARAM_STR); 
			$stmt->bindParam(":password_hash", $password_hash, PDO::PARAM_STR); 
			$stmt->bindParam(":secret_word", $secret_word, PDO::PARAM_STR); 
			$stmt->bindParam(":status", $status, PDO::PARAM_STR);
			$stmt->bindParam(":id", $id, PDO::PARAM_STR);
			
			// Execute the query
			$stmt->execute();
 
			$response = "<div class='alert alert-success'>User with Email [ " . $email . " ] was successfully updated.</div>";
			
			return $response;
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }

    /*
     * Update Record
     *
	 * @param $email
	 * @param $password_hash 
	 *
     * @return $mixed
     * */
    public function update_user_password_hash($email, $password_hash)
    {
		try{
			// Update query
			$query = "UPDATE tbl_users SET  
			password_hash = :password_hash 
			WHERE email = :email";
			
			// prepare query for execution
			$stmt = $this->db->prepare($query);
			
			// bind the parameters
			$stmt->bindParam(":email", $email, PDO::PARAM_STR);  
			$stmt->bindParam(":password_hash", $password_hash, PDO::PARAM_STR);  
			
			// Execute the query
			$stmt->execute();
 
			$response = "<div class='alert alert-success'>User with Email [ " . $email . " ] was successfully updated.</div>";
			
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
			$query = "SELECT * FROM tbl_users 
			WHERE id = :id";
			
			// prepare query for execution			
			$stmt = $this->db->prepare($query);
			
			// bind the parameters
			$stmt->bindParam(":id", $id, PDO::PARAM_STR);
			
			// Execute the query
			$stmt->execute();

			$user = $stmt->fetch(PDO::FETCH_ASSOC);
  			
			$encoded_password = $user['pass_word'];
			$decoded_password = $this->decode($encoded_password);  
			$user['pass_word'] = $decoded_password;

			// return retrieved row as a json object
			return json_encode($user); 
			
		} catch (Exception $e){
			$response = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' . $e->getMessage() . '</div>';
			return $response;
		}
    }

	var $skey = "EaaJgaD0uFDEg7tpvMOqKfAQ46Bqi8Va"; // you can change it

    public  function safe_b64encode($string) {
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }

    public function safe_b64decode($string) {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

    public  function encode($value){ 
        if(!$value){return false;}
        $text = $value;
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->skey, $text, MCRYPT_MODE_ECB, $iv);
        return trim($this->safe_b64encode($crypttext)); 
    }

    public function decode($value){
        if(!$value){return false;}
        $crypttext = $this->safe_b64decode($value); 
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->skey, $crypttext, MCRYPT_MODE_ECB, $iv);
        return trim($decrypttext);
    }

    /*
     * Get user Details
     *
     * @param $id
     * */
    public function fetch_user($id)
    {
		try{
			// select query
			$query = "SELECT * FROM tbl_users 
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
     * Read all user records
     *
     * @return $mixed
     * */
    public function get_all_users_arr()
    {
		try{
			// select query - select all data
			$query = "SELECT * FROM tbl_users 
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
     * Delete Record
     *
     * @param $id
     * */
    public function delete_user($id)
    {
		try{
			
			$user_record = $this->fetch_user($id);
			 
			foreach ($user_record as $key => $value) {
				if($key == "email") {
					$email = $value; 
				} 
				if($key == "full_names") {
					$full_names = $value; 
				} 
			}
			 
			if($id == 1)
			{
				$response = "<div class='alert alert-danger'>Cannot delete User [ ' . $full_names . ' ].</div>";		
				return $response;			
			}

			//check if this user has a role associated with it.
			$users_roles_query =  "SELECT * FROM tbl_users_roles as users_roles  
			INNER JOIN tbl_users as users ON users_roles.user_id = users.id 
			WHERE users_roles.user_id = :user_id";

			// prepare query for execution
			$users_roles_stmt = $this->db->prepare($users_roles_query);

			// bind the parameters
			$users_roles_stmt->bindParam(":user_id", $id, PDO::PARAM_STR);

			// Execute the query
			$users_roles_stmt->execute();
			
			$users_roles_arr = $users_roles_stmt->fetch(PDO::FETCH_ASSOC);
			
			$users_roles_count = $users_roles_stmt->rowCount();

			$response = null;
			
			if (!$users_roles_arr) {
				// array is empty.
				//continue with deletion.
			}else{
				//array has something, which means there is atleast an role tied to this user.
				//warn the user.

				if($users_roles_count > 1)
				{
					$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>[ ' .  $users_roles_count . ' ] roles are associated with this user.</div>';
				}else{
					$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>[ ' .  $users_roles_count . ' ] role is associated with this user.</div>';
				}
			
			}

			if($response)
			{
				return $response;
			}

			// delete query
			$query = "DELETE FROM tbl_users 
			WHERE id = :id";

			// prepare query for execution
			$stmt = $this->db->prepare($query);

			// bind the parameters
			$stmt->bindParam(":id", $id, PDO::PARAM_STR);

			// Execute the query
			$stmt->execute();
			
			$response = "<div class='alert alert-success'>User with Email [ " . $email . " ] for [ " . $full_names . " ]  was successfully deleted.</div>";
			
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
			$query = "SELECT * FROM tbl_users 
			WHERE email = :email";

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
			$query = "SELECT * FROM tbl_users 
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
     * Read all user names
     *
     * @return $mixed
     * */
    public function get_user_names()
    {
		try{
			// select query - select all data
			$query = "SELECT DISTINCT full_names FROM tbl_users 
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
     * Read all emails
     *
     * @return $mixed
     * */
    public function get_user_emails()
    {
		try{
			// select query - select all data
			$query = "SELECT DISTINCT email FROM tbl_users 
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
  
	public function search_users_v2($page, $records_to_display, $email, $full_names)
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
			3. full_names only typed.		 
			5. no item is specified.		
		*/
		 
		//all items are specified.
		if(!empty($email) && !empty($full_names))
		{
			$query = "SELECT * FROM tbl_users WHERE (email LIKE :email AND full_names LIKE :full_names) 
			ORDER BY email, full_names ASC 
			LIMIT :from_record_num, :records_per_page";
						
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			 
			$pattern  = '%' . $email . '%';
			
			$stmt->bindParam(":email", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $full_names . '%';
			
			$stmt->bindParam(":full_names", $pattern, PDO::PARAM_STR);
			
			
			$count_query = "SELECT * FROM tbl_users WHERE (email LIKE :email AND full_names LIKE :full_names) 
			ORDER BY email, full_names ASC";
			
			$count_stmt = $this->db->prepare($count_query);
			  
			$pattern  = '%' . $email . '%';
			
			$count_stmt->bindParam(":email", $pattern, PDO::PARAM_STR);
				
			$pattern  = '%' . $full_names . '%';
			
			$count_stmt->bindParam(":full_names", $pattern, PDO::PARAM_STR);
				 
		}
		//email only typed.
		else if(!empty($email) && empty($full_names))
		{
			$query = "SELECT * FROM tbl_users WHERE email LIKE :email ORDER BY email ASC LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
						
			$pattern  = '%' . $email . '%';
			
			$stmt->bindParam(":email", $pattern, PDO::PARAM_STR);
				
			
			$count_query = "SELECT * FROM tbl_users WHERE email LIKE :email ORDER BY email ASC";
			
			$count_stmt = $this->db->prepare($count_query);
			  
			$pattern  = '%' . $email . '%';
			
			$count_stmt->bindParam(":email", $pattern, PDO::PARAM_STR);
				 
		}
		//full_names only typed.
		else if(empty($email) && !empty($full_names))
		{
			$query = "SELECT * FROM tbl_users WHERE full_names LIKE :full_names ORDER BY full_names ASC LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);
			
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
						
			$pattern  = '%' . $full_names . '%';
			
			$stmt->bindParam(":full_names", $pattern, PDO::PARAM_STR);
				
			
			$count_query = "SELECT * FROM tbl_users WHERE full_names LIKE :full_names ORDER BY full_names ASC";
			
			$count_stmt = $this->db->prepare($count_query);
			  
			$pattern  = '%' . $full_names . '%';
			
			$count_stmt->bindParam(":full_names", $pattern, PDO::PARAM_STR);
				 
		} 
		//no item is specified.
		else if(empty($email) && empty($full_names))
		{				
			$query = "SELECT * FROM tbl_users ORDER BY id DESC LIMIT :from_record_num, :records_per_page";
							
			//echo $query;
			
			$stmt = $this->db->prepare($query);

			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			
			
			$count_query = "SELECT * FROM tbl_users ORDER BY id DESC";
			
			$count_stmt = $this->db->prepare($count_query);
			  
		}
		else
		{ 
			$_SESSION['users_count'] = 0;
			return;
		}

		$stmt->execute();
			
		$count_stmt->execute();
				 
		// this is how to get number of rows returned
		$num = $stmt->rowCount();
		
		$count_num = $count_stmt->rowCount();
		
		$_SESSION['users_count'] = $count_num;

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
				echo "<th scope='col'>Full Names</th>";  
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
				$full_names = $row['full_names'];
				$pass_word = $row['pass_word']; 
				$secret_word = $row['secret_word'];
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
					
				echo htmlspecialchars($full_names, ENT_QUOTES);

				echo "</td>";
			  
				echo "<td class='table-success'>";
					
				echo htmlspecialchars($secret_word, ENT_QUOTES);

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
					echo "<a onClick='edit_user({$id})' style='cursor:hand !important;' 
					class='btn btn-info m-r-1em crud_buttons btn_edit btn_edit_user' 
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
					class='btn btn-danger m-r-1em crud_buttons btn_delete btn_delete_user' 
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
			// $query = "SELECT COUNT(*) as total_rows FROM tbl_users";
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
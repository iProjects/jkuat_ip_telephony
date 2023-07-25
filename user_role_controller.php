<?php

require 'user_role_dal.php';

if(isset($_POST['action'])){
	if ($_POST['action'] == "create_user_role") 
	{ 
		create_user_role(); 
	}
	if ($_POST['action'] == "update_user_role") 
	{ 
		update_user_role(); 
	} 
	if ($_POST['action'] == "search_users_roles") 
	{ 
		search_users_roles(); 
	} 
	if ($_POST['action'] == "get_user_role") 
	{ 
		get_user_role(); 
	}
	if ($_POST['action'] == "delete_user_role") 
	{ 
		delete_user_role(); 
	} 
	if ($_POST['action'] == "get_users_roles_search_count") 
	{ 
		get_users_roles_search_count(); 
	}	
	if ($_POST['action'] == "fetch_users") 
	{ 
		fetch_users(); 
	}
	if ($_POST['action'] == "fetch_roles") 
	{ 
		fetch_roles(); 
	}
}
	
function create_user_role() {
 
	$response = "";

	if(isset($_POST)){
	 
		$user_id = trim(htmlspecialchars(strip_tags($_POST['user_id']))); 
		$role_id = trim(htmlspecialchars(strip_tags($_POST['role_id']))); 
		$status = trim(htmlspecialchars(strip_tags($_POST['status'])));
		$addedby = trim(htmlspecialchars(strip_tags($_POST['addedby']))); 
		
		if(!isset($user_id)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> User is mandatory field.</div>';
		} 
		if(!isset($role_id)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Role is mandatory field.</div>';
		} 		

		if(!empty($response)){
			echo $response;
			return;
		}

		$user_role_dal = new user_role_dal();

		echo $user_role_dal->create_user_role($user_id, $role_id, $status, $addedby);
	 
	}

}
 
function update_user_role() {
 
	$response = "";

	if(isset($_POST)){
	 
		$id = trim(htmlspecialchars(strip_tags($_POST['id'])));
		$user_id = trim(htmlspecialchars(strip_tags($_POST['user_id']))); 
		$role_id = trim(htmlspecialchars(strip_tags($_POST['role_id']))); 
		$status = trim(htmlspecialchars(strip_tags($_POST['status'])));
		
		if(!isset($id)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Error retrieving the primary key.</div>';
		} 
		if(!isset($user_id)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> User is mandatory field.</div>';
		} 
		if(!isset($role_id)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Role is mandatory field.</div>';
		} 		
 
		if(!empty($response)){
			echo $response;
			return;
		}

		$user_role_dal = new user_role_dal();

		echo $user_role_dal->update_user_role($user_id, $role_id, $status, $id);
	 
	}

}

function get_user_role() {
 
	$response = "";

	if(isset($_POST)){
	 
		$id = trim(htmlspecialchars(strip_tags($_POST['id']))); 
		
		if(!isset($id)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> id is mandatory field.</div>';
		}  

		if(!empty($response)){
			echo $response;
			return;
		}

		$user_role_dal = new user_role_dal();

		echo $user_role_dal->get_user_role($id);
	 
	}

}
 
function search_users_roles() {
 
	$response = "";

	if(isset($_POST)){
		
		$page = trim(htmlspecialchars(strip_tags($_POST['page'])));
		$records_to_display = trim(htmlspecialchars(strip_tags($_POST['records_to_display'])));
		$user_name = trim(htmlspecialchars(strip_tags($_POST['user_name']))); 
		$role_name = trim(htmlspecialchars(strip_tags($_POST['role_name']))); 
 
		if(!isset($page)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> page is mandatory field.</div>';
		} 
		if(!isset($records_to_display)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> records to display is mandatory field.</div>';
		} 
		
		if(!empty($response)){ 
			return;
		}

		$user_role_dal = new user_role_dal();

		echo $user_role_dal->search_users_roles_v2($page, $records_to_display, $user_name, $role_name);
	 
	}

}

function delete_user_role() {
 
	$response = "";

	if(isset($_POST)){
	 
		$id = trim(htmlspecialchars(strip_tags($_POST['id']))); 
		
		if(!isset($id)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> id is mandatory field.</div>';
		}  

		if(!empty($response)){
			echo $response;
			return;
		}

		$user_role_dal = new user_role_dal();

		echo $user_role_dal->delete_user_role($id);
	 
	}

}

function get_users_roles_search_count() {

	if (isset($_SESSION['users_roles_count']))
	{
		echo "[ " . $_SESSION["users_roles_count"] . " ] records";
	}
}

function fetch_users() {

	$user_role_dal = new user_role_dal();

	echo $user_role_dal->get_all_users_arr();
  
}

function fetch_roles() {

	$user_role_dal = new user_role_dal();

	echo $user_role_dal->get_all_roles_arr();	  

}









?>

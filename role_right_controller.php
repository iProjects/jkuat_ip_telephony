<?php

require 'role_right_dal.php'; 

if(isset($_POST['action'])){
	if ($_POST['action'] == "create_role_right") 
	{ 
		create_role_right(); 
	}
	if ($_POST['action'] == "update_role_right") 
	{ 
		update_role_right(); 
	} 
	if ($_POST['action'] == "search_roles_rights") 
	{ 
		search_roles_rights(); 
	} 
	if ($_POST['action'] == "get_role_right") 
	{ 
		get_role_right(); 
	}
	if ($_POST['action'] == "delete_role_right") 
	{ 
		delete_role_right(); 
	} 
	if ($_POST['action'] == "get_roles_rights_search_count") 
	{ 
		get_roles_rights_search_count(); 
	}
	if ($_POST['action'] == "fetch_roles") 
	{ 
		fetch_roles(); 
	}
	if ($_POST['action'] == "fetch_rights") 
	{ 
		fetch_rights(); 
	}	
}
	
function create_role_right() {
 
	$response = "";

	if(isset($_POST)){
	 
		$role_id = trim(htmlspecialchars(strip_tags($_POST['role_id']))); 
		$right_id = trim(htmlspecialchars(strip_tags($_POST['right_id']))); 
		$allowed = trim(htmlspecialchars(strip_tags($_POST['allowed']))); 
		$status = trim(htmlspecialchars(strip_tags($_POST['status'])));
		$addedby = trim(htmlspecialchars(strip_tags($_POST['addedby']))); 
		
		if(!isset($role_id)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Role is mandatory field.</div>';
		}  
		if(!isset($right_id)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Right is mandatory field.</div>';
		}  

		if(!empty($response)){
			echo $response;
			return;
		}

		$role_right_dal = new role_right_dal();

		echo $role_right_dal->create_role_right($role_id, $right_id, $allowed, $status, $addedby);
	 
	}

}
 
function update_role_right() {
 
	$response = "";

	if(isset($_POST)){
	 
		$id = trim(htmlspecialchars(strip_tags($_POST['id'])));
		$role_id = trim(htmlspecialchars(strip_tags($_POST['role_id']))); 
		$right_id = trim(htmlspecialchars(strip_tags($_POST['right_id']))); 
		$status = trim(htmlspecialchars(strip_tags($_POST['status'])));
		
		if(!isset($id)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Error retrieving the primary key.</div>';
		} 
		if(!isset($role_id)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Role is mandatory field.</div>';
		}  
		if(!isset($right_id)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Right is mandatory field.</div>';
		}  

		if(!empty($response)){
			echo $response;
			return;
		}

		$role_right_dal = new role_right_dal();

		echo $role_right_dal->update_role_right($role_id, $right_id, $status, $id);
	 
	}

}

function get_role_right() {
 
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

		$role_right_dal = new role_right_dal();

		echo $role_right_dal->get_role_right($id);
	 
	}

}
 
function search_roles_rights() {
 
	$response = "";

	if(isset($_POST)){
		
		$page = trim(htmlspecialchars(strip_tags($_POST['page'])));
		$records_to_display = trim(htmlspecialchars(strip_tags($_POST['records_to_display'])));
		$role_name = trim(htmlspecialchars(strip_tags($_POST['role_name']))); 
		$right_name = trim(htmlspecialchars(strip_tags($_POST['right_name']))); 
 
		if(!isset($page)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> page is mandatory field.</div>';
		} 
		if(!isset($records_to_display)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> records to display is mandatory field.</div>';
		} 
		
		if(!empty($response)){ 
			return;
		}

		$role_right_dal = new role_right_dal();

		echo $role_right_dal->search_roles_rights_v2($page, $records_to_display, $role_name, $right_name);
	 
	}

}

function delete_role_right() {
 
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

		$role_right_dal = new role_right_dal();

		echo $role_right_dal->delete_role_right($id);
	 
	}

}

function get_roles_rights_search_count() {

	if (isset($_SESSION['roles_rights_count']))
	{
		echo "[ " . $_SESSION["roles_rights_count"] . " ] records";
	}
}

function fetch_roles() {

	$role_right_dal = new role_right_dal();

	echo $role_right_dal->get_all_roles_arr();
  
}

function fetch_rights() {

	$role_right_dal = new role_right_dal();

	echo $role_right_dal->get_all_rights_arr();	  

}









?>

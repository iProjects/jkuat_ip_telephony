<?php

require 'role_dal.php';

if(isset($_POST['action'])){
	if ($_POST['action'] == "create_role") 
	{ 
		create_role(); 
	}
	if ($_POST['action'] == "update_role") 
	{ 
		update_role(); 
	} 
	if ($_POST['action'] == "search_roles") 
	{ 
		search_roles(); 
	} 
	if ($_POST['action'] == "get_role") 
	{ 
		get_role(); 
	}
	if ($_POST['action'] == "delete_role") 
	{ 
		delete_role(); 
	} 
	if ($_POST['action'] == "get_roles_search_count") 
	{ 
		get_roles_search_count(); 
	}	
}
	
function create_role() {
 
	$response = "";

	if(isset($_POST)){
	 
		$role_name = trim(htmlspecialchars(strip_tags($_POST['role_name']))); 
		$addedby = trim(htmlspecialchars(strip_tags($_POST['addedby']))); 
		
		if(!isset($role_name)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Name is mandatory field.</div>';
		}  

		if(!empty($response)){
			echo $response;
			return;
		}

		$role_dal = new role_dal();

		echo $role_dal->create_role($role_name, $addedby);
	 
	}

}
 
function update_role() {
 
	$response = "";

	if(isset($_POST)){
	 
		$id = trim(htmlspecialchars(strip_tags($_POST['id'])));
		$role_name = trim(htmlspecialchars(strip_tags($_POST['role_name']))); 
		
		if(!isset($id)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Error retrieving the primary key.</div>';
		} 
		if(!isset($role_name)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Name is mandatory field.</div>';
		}  

		if(!empty($response)){
			echo $response;
			return;
		}

		$role_dal = new role_dal();

		echo $role_dal->update_role($role_name, $id);
	 
	}

}

function get_role() {
 
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

		$role_dal = new role_dal();

		echo $role_dal->get_role($id);
	 
	}

}
 
function search_roles() {
 
	$response = "";

	if(isset($_POST)){
		
		$page = trim(htmlspecialchars(strip_tags($_POST['page'])));
		$records_to_display = trim(htmlspecialchars(strip_tags($_POST['records_to_display'])));
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

		$role_dal = new role_dal();

		echo $role_dal->search_roles_v2($page, $records_to_display, $role_name);
	 
	}

}

function delete_role() {
 
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

		$role_dal = new role_dal();

		echo $role_dal->delete_role($id);
	 
	}

}

function get_roles_search_count() {

	if (isset($_SESSION['roles_count']))
	{
		echo "[ " . $_SESSION["roles_count"] . " ] records";
	}
}









?>

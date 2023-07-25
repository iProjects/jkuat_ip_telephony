<?php

require 'department_dal.php';

if(isset($_POST['action']))
{
	if ($_POST['action'] == "create_department") 
	{ 
		create_department(); 
	}
	if ($_POST['action'] == "update_department") 
	{ 
		update_department(); 
	} 
	if ($_POST['action'] == "search_departments") 
	{ 
		search_departments(); 
	} 
	if ($_POST['action'] == "get_department") 
	{ 
		get_department(); 
	}
	if ($_POST['action'] == "delete_department") 
	{ 
		delete_department(); 
	} 
	if ($_POST['action'] == "get_departments_search_count") 
	{ 
		get_departments_search_count(); 
	}	
}
	
function create_department() {
 
	$response = "";

	if(isset($_POST)){
	  
		$campus_id = trim(htmlspecialchars(strip_tags($_POST['campus_id'])));
		$department_name = trim(htmlspecialchars(strip_tags($_POST['department_name'])));
		$status = trim(htmlspecialchars(strip_tags($_POST['status'])));
		$addedby = trim(htmlspecialchars(strip_tags($_POST['addedby']))); 
		 
		if(!isset($campus_id)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Campus is mandatory field.</div>';
		} 
		if(!isset($department_name)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Name is mandatory field.</div>';
		} 
		if(!isset($addedby)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Added By is mandatory field.</div>';
		}  

		if(!empty($response)){
			echo $response;
			return;
		}

		$department_dal = new department_dal();

		echo $department_dal->create_department($campus_id, $department_name, $status, $addedby);
	 
	}

}

function update_department() {
 
	$response = "";

	if(isset($_POST)){
	 
		$id = trim(htmlspecialchars(strip_tags($_POST['id']))); 
		$campus_id = trim(htmlspecialchars(strip_tags($_POST['campus_id'])));
		$department_name = trim(htmlspecialchars(strip_tags($_POST['department_name']))); 
		$status = trim(htmlspecialchars(strip_tags($_POST['status'])));
		
		if(!isset($id)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Error retrieving the primary key.</div>';
		}  
		if(!isset($campus_id)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Campus is mandatory field.</div>';
		} 
		if(!isset($department_name)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Name is mandatory field.</div>';
		}  

		if(!empty($response)){
			echo $response;
			return;
		}

		$department_dal = new department_dal();

		echo $department_dal->update_department($campus_id, $department_name, $status, $id);
	 
	}

}

function get_department() {
 
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

		$department_dal = new department_dal();

		echo $department_dal->get_department($id);
	 
	}

}
   
function search_departments() {
 
	$response = "";

	if(isset($_POST)){
		
		$page = trim(htmlspecialchars(strip_tags($_POST['page'])));
		$records_to_display = trim(htmlspecialchars(strip_tags($_POST['records_to_display']))); 
		$department_name = trim(htmlspecialchars(strip_tags($_POST['department_name']))); 
		$campus_name = trim(htmlspecialchars(strip_tags($_POST['campus_name']))); 
		
		if(!isset($page)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> page is mandatory field.</div>';
		} 
		if(!isset($records_to_display)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> records to display is mandatory field.</div>';
		} 
		
		if(!empty($response)){ 
			return;
		}

		$department_dal = new department_dal();

		echo $department_dal->search_departments_v2($page, $records_to_display, $department_name, $campus_name);
	 
	}

}

function delete_department() {
 
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

		$department_dal = new department_dal();

		echo $department_dal->delete_department($id);
	 
	}

}

function get_departments_search_count() {

	if (isset($_SESSION['departments_count']))
	{
		echo "[ " . $_SESSION["departments_count"] . " ] records";
	}
}









?>

<?php

require 'admin_dal.php';

if(isset($_POST['action'])){ 
	if ($_POST['action'] == "fetch_extensions") 
	{ 
		fetch_extensions(); 
	} 
	if ($_POST['action'] == "fetch_campus_codes") 
	{ 
		fetch_campus_codes(); 
	} 
	if ($_POST['action'] == "fetch_all_campuses") 
	{ 
		fetch_all_campuses(); 
	} 
	if ($_POST['action'] == "fetch_department_names") 
	{ 
		fetch_department_names(); 
	} 
	if ($_POST['action'] == "search_extensions") 
	{ 
		search_extensions(); 
	} 
	if ($_POST['action'] == "get_extension") 
	{ 
		get_extension(); 
	}
	if ($_POST['action'] == "get_campus_count") 
	{ 
		get_campus_count(); 
	}
	if ($_POST['action'] == "get_departments_count") 
	{ 
		get_departments_count(); 
	}
	if ($_POST['action'] == "get_extensions_count") 
	{ 
		get_extensions_count(); 
	}
	if ($_POST['action'] == "get_users_count") 
	{ 
		get_users_count(); 
	}
	
}
	
function create_extension() {
 
	$response = "";

	if(isset($_POST)){
	 
		$code = trim(htmlspecialchars(strip_tags($_POST['code'])));
		$extension_number = trim(htmlspecialchars(strip_tags($_POST['extension_number'])));
		$owner_assigned = trim(htmlspecialchars(strip_tags($_POST['owner_assigned'])));
		$department = trim(htmlspecialchars(strip_tags($_POST['department'])));  
		
		if(!isset($code)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> code is mandatory field./div>';
		} 
		if(!isset($extension_number)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> extension number is mandatory field./div>';
		} 
		if(!isset($owner_assigned)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> owner assigned is mandatory field./div>';
		} 
		if(!isset($department)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> department is mandatory field./div>';
		} 

		if(!empty($response)){
			echo $response;
			return;
		}

		$admin_dal = new admin_dal();

		echo $admin_dal->create_extension($code, $extension_number, $owner_assigned, $department);
	 
	}

}

function get_extension() {
 
	$response = "";

	if(isset($_POST)){
	 
		$id = trim(htmlspecialchars(strip_tags($_POST['id']))); 
		
		if(!isset($id)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> id is mandatory field./div>';
		}  

		if(!empty($response)){
			echo $response;
			return;
		}

		$admin_dal = new admin_dal();

		echo $admin_dal->get_extension($id);
	 
	}

}

function fetch_extensions() {
 
	$response = "";

	if(isset($_POST)){
	 
		$page = trim(htmlspecialchars(strip_tags($_POST['page'])));
		$records_to_display = trim(htmlspecialchars(strip_tags($_POST['records_to_display'])));
 
		if(!isset($page)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> page is mandatory field./div>';
		} 
		if(!isset($records_to_display)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> records to display is mandatory field./div>';
		} 

		if(!empty($response)){
			echo $response;
			return;
		}

		$admin_dal = new admin_dal();

		echo $admin_dal->get_paginated_extensions_table($page, $records_to_display);
	 
	}

}

function fetch_campus_codes() {

	$admin_dal = new admin_dal();

	echo $admin_dal->get_campus_codes();
   
}

function fetch_all_campuses() {

	$admin_dal = new admin_dal();

	echo $admin_dal->get_all_campuses();
   
}

function fetch_department_names() {
	
	if(isset($_POST)){
	 
		$campus_code = trim(htmlspecialchars(strip_tags($_POST['campus_code']))); 
 
		if(!isset($campus_code)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> campus name is mandatory field./div>';
		}  

		if(!empty($response)){
			//echo $response;
			return;
		}

		$admin_dal = new admin_dal();

		echo $admin_dal->get_department_names($campus_code);
	   
	}

}

function search_extensions() {
 
	$response = "";

	if(isset($_POST)){
		
		$page = trim(htmlspecialchars(strip_tags($_POST['page'])));
		$records_to_display = trim(htmlspecialchars(strip_tags($_POST['records_to_display'])));
		$campus_code = trim(htmlspecialchars(strip_tags($_POST['campus_code'])));
		$department = trim(htmlspecialchars(strip_tags($_POST['department'])));
		$extension_number = trim(htmlspecialchars(strip_tags($_POST['extension_number'])));
 
		if(!isset($page)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> page is mandatory field./div>';
		} 
		if(!isset($records_to_display)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> records to display is mandatory field./div>';
		} 
		
		if(!empty($response)){ 
			return;
		}

		$admin_dal = new admin_dal();

		echo $admin_dal->search_extensions($page, $records_to_display, $campus_code, $department, $extension_number);
	 
	}

}
 

function get_campus_count() {

	$admin_dal = new admin_dal();

	echo $admin_dal->get_campus_count();
   
}

function get_departments_count() {

	$admin_dal = new admin_dal();

	echo $admin_dal->get_departments_count();
   
}

function get_extensions_count() {

	$admin_dal = new admin_dal();

	echo $admin_dal->get_extensions_count();
   
}

function get_users_count() {

	$admin_dal = new admin_dal();

	echo $admin_dal->get_users_count();
   
}







?>
<?php

require 'search_dal.php';

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
	if ($_POST['action'] == "fetch_departments_given_campus") 
	{ 
		fetch_departments_given_campus(); 
	} 
	if ($_POST['action'] == "search_extensions") 
	{ 
		search_extensions(); 
	} 
	if ($_POST['action'] == "get_extension") 
	{ 
		get_extension(); 
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

		$search_dal = new search_dal();

		echo $search_dal->get_extension($id);
	 
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

		$search_dal = new search_dal();

		echo $search_dal->get_paginated_extensions_table($page, $records_to_display);
	 
	}

}

function fetch_campus_codes() {

	$search_dal = new search_dal();

	echo $search_dal->get_campus_codes();
   
}

function fetch_all_campuses() {

	$search_dal = new search_dal();

	echo $search_dal->get_all_campuses();
   
}

function fetch_departments_given_campus() {
	
	if(isset($_POST)){
	 
		$campus_id = trim(htmlspecialchars(strip_tags($_POST['campus_id']))); 
 
		if(!isset($campus_id)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> campus is mandatory field./div>';
		}  

		if(!empty($response)){
			//echo $response;
			return;
		}

		$search_dal = new search_dal();

		echo $search_dal->get_departments_given_campus($campus_id);
	   
	}

}

function search_extensions() {
 
	$response = "";

	if(isset($_POST)){
		
		$page = trim(htmlspecialchars(strip_tags($_POST['page'])));
		$records_to_display = trim(htmlspecialchars(strip_tags($_POST['records_to_display'])));
		$campus_id = trim(htmlspecialchars(strip_tags($_POST['campus_id'])));
		$department_id = trim(htmlspecialchars(strip_tags($_POST['department_id'])));
		$other_params = trim(htmlspecialchars(strip_tags($_POST['other_params'])));
 
		if(!isset($page)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Page is mandatory field./div>';
		} 
		if(!isset($records_to_display)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Records to display is mandatory field./div>';
		} 
		
		if(!empty($response)){ 
			return;
		}

		$search_dal = new search_dal();

		echo $search_dal->search_extensions_v3($page, $records_to_display, $campus_id, $department_id, $other_params);
	 
	}

}
 








?>

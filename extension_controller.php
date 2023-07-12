<?php

require 'extension_dal.php';

if(isset($_POST['action']))
{
	if ($_POST['action'] == "create_extension") 
	{ 
		create_extension(); 
	}
	if ($_POST['action'] == "update_extension") 
	{ 
		update_extension(); 
	}
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
	if ($_POST['action'] == "get_departments_given_campus_id") 
	{ 
		get_departments_given_campus_id(); 
	} 
	if ($_POST['action'] == "search_extensions") 
	{ 
		search_extensions(); 
	} 
	if ($_POST['action'] == "get_extension") 
	{ 
		get_extension(); 
	}
	if ($_POST['action'] == "delete_extension") 
	{ 
		delete_extension(); 
	}
	if ($_POST['action'] == "get_extension_given_number") 
	{ 
		get_extension_given_number(); 
	}
	if ($_POST['action'] == "get_extensions_search_count") 
	{ 
		get_extensions_search_count(); 
	}	
}
	
function create_extension() {
 
	$response = "";

	if(isset($_POST)){
	 
		$campus_id = trim(htmlspecialchars(strip_tags($_POST['campus_id'])));
		$department_id = trim(htmlspecialchars(strip_tags($_POST['department_id'])));
		$owner_assigned = trim(htmlspecialchars(strip_tags($_POST['owner_assigned'])));
		$extension_number = trim(htmlspecialchars(strip_tags($_POST['extension_number'])));  
		$addedby = trim(htmlspecialchars(strip_tags($_POST['addedby']))); 
		
		if(!isset($campus_id)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Campus is mandatory field.</div>';
		} 
		if(!isset($department_id)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Department is mandatory field.</div>';
		} 
		if(!isset($owner_assigned)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Owner Assigned is mandatory field.</div>';
		} 
		if(!isset($extension_number)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Extension Number is mandatory field.</div>';
		} 
		if(!isset($addedby)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Added By is mandatory field.</div>';
		} 
		
		if(!empty($response)){
			echo $response;
			return;
		}

		$extension_dal = new extension_dal();

		echo $extension_dal->create_extension($campus_id, $department_id, $owner_assigned, $extension_number, $addedby);
	 
	}

}

function update_extension() {
 
	$response = "";

	if(isset($_POST)){
	 
		$id = trim(htmlspecialchars(strip_tags($_POST['id'])));
		$campus_id = trim(htmlspecialchars(strip_tags($_POST['campus_id'])));
		$department_id = trim(htmlspecialchars(strip_tags($_POST['department_id'])));
		$owner_assigned = trim(htmlspecialchars(strip_tags($_POST['owner_assigned'])));
		$extension_number = trim(htmlspecialchars(strip_tags($_POST['extension_number']))); 
		
		if(!isset($id)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> error retrieving the primary key.</div>';
		} 
		if(!isset($campus_id)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Campus is mandatory field.</div>';
		} 
		if(!isset($department_id)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Department is mandatory field.</div>';
		} 
		if(!isset($owner_assigned)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Owner Assigned is mandatory field.</div>';
		} 
		if(!isset($extension_number)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Extension Number is mandatory field.</div>';
		} 

		if(!empty($response)){
			echo $response;
			return;
		}

		$extension_dal = new extension_dal();

		echo $extension_dal->update_extension($campus_id, $department_id, $owner_assigned, $extension_number, $id);
	 
	}

}

function get_extension() {
 
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

		$extension_dal = new extension_dal();

		echo $extension_dal->get_extension($id);
	 
	}

}

function get_extension_given_number() {
 
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

		$extension_dal = new extension_dal();

		echo $extension_dal->get_extension($id);
	 
	}

}

function fetch_extensions() {
 
	$response = "";

	if(isset($_POST)){
	 
		$page = trim(htmlspecialchars(strip_tags($_POST['page'])));
		$records_to_display = trim(htmlspecialchars(strip_tags($_POST['records_to_display'])));
 
		if(!isset($page)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> page is mandatory field.</div>';
		} 
		if(!isset($records_to_display)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> records to display is mandatory field.</div>';
		} 

		if(!empty($response)){
			echo $response;
			return;
		}

		$extension_dal = new extension_dal();

		echo $extension_dal->get_paginated_extensions_table($page, $records_to_display);
	 
	}

}

function check_if_extension_number_exists($extension_number) {

	$extension_dal = new extension_dal();

	return $extension_dal->check_if_extension_number_exists($extension_number);
   
}

function fetch_all_campuses() {

	$extension_dal = new extension_dal();

	echo $extension_dal->get_all_campuses();
   
}

function get_departments_given_campus_id() {
	
	if(isset($_POST)){
	 
		$campus_id = trim(htmlspecialchars(strip_tags($_POST['campus_id']))); 
 
		if(!isset($campus_id)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> campus is mandatory field.</div>';
		}  

		if(!empty($response)){
			//echo $response;
			return;
		}

		$extension_dal = new extension_dal();

		echo $extension_dal->get_departments_given_campus_id($campus_id);
	   
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
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> page is mandatory field.</div>';
		} 
		if(!isset($records_to_display)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> records to display is mandatory field.</div>';
		} 
		
		if(!empty($response)){ 
			return;
		}

		$extension_dal = new extension_dal();

		echo $extension_dal->search_extensions_v3($page, $records_to_display, $campus_id, $department_id, $other_params);
	 
	}

}

function delete_extension() {
 
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

		$extension_dal = new extension_dal();

		echo $extension_dal->delete_extension($id);
	 
	}

}

function get_extensions_search_count() {

	if (isset($_SESSION['extensions_count']))
	{
		echo "[ " . $_SESSION["extensions_count"] . " ] records";
	}
}









?>

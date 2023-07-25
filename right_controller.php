<?php

require 'right_dal.php';

if(isset($_POST['action'])){
	if ($_POST['action'] == "create_right") 
	{ 
		create_right(); 
	}
	if ($_POST['action'] == "update_right") 
	{ 
		update_right(); 
	} 
	if ($_POST['action'] == "search_rights") 
	{ 
		search_rights(); 
	} 
	if ($_POST['action'] == "get_right") 
	{ 
		get_right(); 
	}
	if ($_POST['action'] == "delete_right") 
	{ 
		delete_right(); 
	} 
	if ($_POST['action'] == "get_rights_search_count") 
	{ 
		get_rights_search_count(); 
	}	
}
	
function create_right() {
 
	$response = "";

	if(isset($_POST)){
	 
		$right_name = trim(htmlspecialchars(strip_tags($_POST['right_name']))); 
		$status = trim(htmlspecialchars(strip_tags($_POST['status'])));
		$addedby = trim(htmlspecialchars(strip_tags($_POST['addedby']))); 
		
		if(!isset($right_name)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Name is mandatory field.</div>';
		}   

		if(!empty($response)){
			echo $response;
			return;
		}

		$right_dal = new right_dal();

		echo $right_dal->create_right($right_name, $status, $addedby);
	 
	}

}
 
function update_right() {
 
	$response = "";

	if(isset($_POST)){
	 
		$id = trim(htmlspecialchars(strip_tags($_POST['id'])));
		$right_name = trim(htmlspecialchars(strip_tags($_POST['right_name']))); 
		$status = trim(htmlspecialchars(strip_tags($_POST['status'])));
		
		if(!isset($id)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Error retrieving the primary key.</div>';
		} 
		if(!isset($right_name)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Name is mandatory field.</div>';
		}  

		if(!empty($response)){
			echo $response;
			return;
		}

		$right_dal = new right_dal();

		echo $right_dal->update_right($right_name, $status, $id);
	 
	}

}

function get_right() {
 
	$response = "";

	if(isset($_POST)){
	 
		$id = trim(htmlspecialchars(strip_tags($_POST['id']))); 
		
		if(!isset($id)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>id is mandatory field.</div>';
		}  

		if(!empty($response)){
			echo $response;
			return;
		}

		$right_dal = new right_dal();

		echo $right_dal->get_right($id);
	 
	}

}
 
function search_rights() {
 
	$response = "";

	if(isset($_POST)){
		
		$page = trim(htmlspecialchars(strip_tags($_POST['page'])));
		$records_to_display = trim(htmlspecialchars(strip_tags($_POST['records_to_display'])));
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

		$right_dal = new right_dal();

		echo $right_dal->search_rights_v2($page, $records_to_display, $right_name);
	 
	}

}

function delete_right() {
 
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

		$right_dal = new right_dal();

		echo $right_dal->delete_right($id);
	 
	}

}

function get_rights_search_count() {

	if (isset($_SESSION['rights_count']))
	{
		echo "[ " . $_SESSION["rights_count"] . " ] records";
	}
}









?>

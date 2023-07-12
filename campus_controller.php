<?php

require 'campus_dal.php';

if(isset($_POST['action']))
{
	if ($_POST['action'] == "create_campus") 
	{ 
		create_campus(); 
	}
	if ($_POST['action'] == "update_campus") 
	{ 
		update_campus(); 
	}   
	if ($_POST['action'] == "search_campuses") 
	{ 
		search_campuses(); 
	} 
	if ($_POST['action'] == "get_campus") 
	{ 
		get_campus(); 
	}
	if ($_POST['action'] == "delete_campus") 
	{ 
		delete_campus(); 
	} 
	if ($_POST['action'] == "get_campuses_search_count") 
	{ 
		get_campuses_search_count(); 
	}	
}
	
function create_campus() {
 
	$response = "";

	if(isset($_POST)){
	  
		$campus_name = trim(htmlspecialchars(strip_tags($_POST['campus_name'])));
		$addedby = trim(htmlspecialchars(strip_tags($_POST['addedby']))); 
		 
		if(!isset($campus_name)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Name is mandatory field.</div>';
		} 
		if(!isset($addedby)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Added By is mandatory field.</div>';
		}  

		if(!empty($response)){
			echo $response;
			return;
		}

		$campus_dal = new campus_dal();

		echo $campus_dal->create_campus($campus_name, $addedby);
	 
	}

}

function update_campus() {
 
	$response = "";

	if(isset($_POST)){
	 
		$id = trim(htmlspecialchars(strip_tags($_POST['id']))); 
		$campus_name = trim(htmlspecialchars(strip_tags($_POST['campus_name']))); 
		
		if(!isset($id)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Error retrieving the primary key.</div>';
		}  
		if(!isset($campus_name)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Name is mandatory field.</div>';
		}   

		if(!empty($response)){
			echo $response;
			return;
		}

		$campus_dal = new campus_dal();

		echo $campus_dal->update_campus($campus_name, $id);
	 
	}

}

function get_campus() {
 
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

		$campus_dal = new campus_dal();

		echo $campus_dal->get_campus($id);
	 
	}

}
 
function search_campuses() {
 
	$response = "";

	if(isset($_POST)){
		
		$page = trim(htmlspecialchars(strip_tags($_POST['page'])));
		$records_to_display = trim(htmlspecialchars(strip_tags($_POST['records_to_display']))); 
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

		$campus_dal = new campus_dal();

		echo $campus_dal->search_campuses_v2($page, $records_to_display, $campus_name);
	 
	}

}

function delete_campus() {
 
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

		$campus_dal = new campus_dal();

		echo $campus_dal->delete_campus($id);
	 
	}

}

function get_campuses_search_count() {

	if (isset($_SESSION['campuses_count']))
	{
		echo "[ " . $_SESSION["campuses_count"] . " ] records";
	}
}









?>

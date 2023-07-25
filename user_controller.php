<?php

require 'user_dal.php';

if(isset($_POST['action'])){
	if ($_POST['action'] == "create_user") 
	{ 
		create_user(); 
	}
	if ($_POST['action'] == "update_user") 
	{ 
		update_user(); 
	} 
	if ($_POST['action'] == "search_users") 
	{ 
		search_users(); 
	} 
	if ($_POST['action'] == "get_user") 
	{ 
		get_user(); 
	}
	if ($_POST['action'] == "delete_user") 
	{ 
		delete_user(); 
	} 
	if ($_POST['action'] == "get_users_search_count") 
	{ 
		get_users_search_count(); 
	}	
}
	
function create_user() {
 
	$response = "";

	if(isset($_POST)){
	 
		$email = trim(htmlspecialchars(strip_tags($_POST['email'])));
		$full_names = trim(htmlspecialchars(strip_tags($_POST['full_names'])));
		$password = trim(htmlspecialchars(strip_tags($_POST['password'])));
		$secretword = trim(htmlspecialchars(strip_tags($_POST['secretword']))); 
		$status = trim(htmlspecialchars(strip_tags($_POST['status'])));
		$addedby = trim(htmlspecialchars(strip_tags($_POST['addedby']))); 
		
		if(!isset($email)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Email is mandatory field.</div>';
		} 
		$regex = "/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,6})+$/";
		if (!preg_match_all($regex, $email)) {
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Please provide a valid email.</div>';
		} 
		if(!isset($full_names)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> User Name is mandatory field.</div>';
		} 
		if(!isset($password)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Password is mandatory field.</div>';
		} 
		if(!isset($secretword)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Secret Word is mandatory field.</div>';
		}  

		if(!empty($response)){
			echo $response;
			return;
		}

		$user_dal = new user_dal();

		echo $user_dal->create_user($email, $full_names, $password, $secretword, $status, $addedby);
	 
	}

}
 
function update_user() {
 
	$response = "";

	if(isset($_POST)){
	 
		$id = trim(htmlspecialchars(strip_tags($_POST['id'])));
		$email = trim(htmlspecialchars(strip_tags($_POST['email'])));
		$full_names = trim(htmlspecialchars(strip_tags($_POST['full_names'])));
		$password = trim(htmlspecialchars(strip_tags($_POST['password'])));
		$secretword = trim(htmlspecialchars(strip_tags($_POST['secretword']))); 
		$status = trim(htmlspecialchars(strip_tags($_POST['status'])));
		
		if(!isset($id)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Error retrieving the primary key.</div>';
		} 
		if(!isset($email)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Email is mandatory field.</div>';
		} 
		$regex = "/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,6})+$/";
		if (!preg_match_all($regex, $email)) {
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Please provide a valid email.</div>';
		} 
		if(!isset($full_names)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> User Name is mandatory field.</div>';
		} 
		if(!isset($password)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Password is mandatory field.</div>';
		} 
		if(!isset($secretword)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Secret Word is mandatory field.</div>';
		}   

		if(!empty($response)){
			echo $response;
			return;
		}

		$user_dal = new user_dal();

		echo $user_dal->update_user($email, $full_names, $password, $secretword, $status, $id);
	 
	}

}

function get_user() {
 
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

		$user_dal = new user_dal();

		echo $user_dal->get_user($id);
	 
	}

}
 
function search_users() {
 
	$response = "";

	if(isset($_POST)){
		
		$page = trim(htmlspecialchars(strip_tags($_POST['page'])));
		$records_to_display = trim(htmlspecialchars(strip_tags($_POST['records_to_display'])));
		$email = trim(htmlspecialchars(strip_tags($_POST['email'])));
		$full_names = trim(htmlspecialchars(strip_tags($_POST['full_names']))); 
 
		if(!isset($page)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> page is mandatory field.</div>';
		} 
		if(!isset($records_to_display)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> records to display is mandatory field.</div>';
		} 
		
		if(!empty($response)){ 
			return;
		}

		$user_dal = new user_dal();

		echo $user_dal->search_users_v2($page, $records_to_display, $email, $full_names);
	 
	}

}

function delete_user() {
 
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

		$user_dal = new user_dal();

		echo $user_dal->delete_user($id);
	 
	}

}

function get_users_search_count() {

	if (isset($_SESSION['users_count']))
	{
		echo "[ " . $_SESSION["users_count"] . " ] records";
	}
}









?>

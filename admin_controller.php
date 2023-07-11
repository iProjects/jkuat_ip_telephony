<?php

require 'admin_dal.php';

if(isset($_POST['action'])){ 
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
	if ($_POST['action'] == "get_user_roles_and_rights") 
	{ 
		get_user_roles_and_rights(); 
	}
	if ($_POST['action'] == "get_roles_and_rights") 
	{ 
		get_roles_and_rights(); 
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

function get_user_roles_and_rights() {

	$response = "";

	if(isset($_POST)){
	 
		$logged_in_user_email = trim(htmlspecialchars(strip_tags($_POST['logged_in_user_email']))); 
		
		if(!isset($logged_in_user_email)){
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Error retrieving logged in user details.  Cannot authorize.</div>';
		}  

		if(!empty($response)){
			echo $response;
			return;
		}

		$admin_dal = new admin_dal();

		echo $admin_dal->get_user_roles_and_rights($logged_in_user_email);
	 
	}   
}

function get_roles_and_rights() {

	$admin_dal = new admin_dal();

	echo $admin_dal->get_roles_and_rights();
  
}







?>

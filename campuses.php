<?php

session_start();
 
include_once "get_url.php";
  
if (isset($_COOKIE['loggedinuser']))
{
	// 👇 check if cookie exists
	if (isset($_COOKIE["origin"])) {
		
		//get the logged in user role from the session		
		$logged_in_user_role = $_SESSION['logged_in_user_role'];
		
		if($logged_in_user_role == "LimitedAdmin" || $logged_in_user_role == "Superadmin")
		{ 
			$global_path = $_COOKIE["origin"];
			//echo $global_path; 
			//header('Location: ' . $global_path . 'campuses.php');
			//exit(); 
		}
	}else{
		$cookie_name = "origin";
		$cookie_value = $server_path;
		setcookie($cookie_name, $cookie_value, time() + (60*60*24*365), "/");
		
		$global_path = $_COOKIE["origin"];
		echo $global_path; 
		header('Location: ' . $global_path . 'campuses.php');
		exit(); 
	}
}else{ 
		$global_path = $_COOKIE["origin"];
		echo $global_path; 
		header('Location: ' . $global_path . 'login.php');
		exit();
}

?>

<!DOCTYPE html> 
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Ip Telephony - Campuses</title>
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1"/>
	
    <link rel="icon" type="image/png" href="images/favicon.png"/>
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico"/>
	
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" media="all" href="css/bootstrap-3.3.7.css" />
			   
	<!-- jQuery ui -->
	<link rel="stylesheet" type="text/css" media="all" href="css/jquery-ui-1.12.1.css" />
	
	<link rel="stylesheet" type="text/css" media="all" href="css/style.css" />
  
	<link rel="stylesheet" type="text/css" media="all" href="css/campus.css" /> 
	
  
</head>
<body>
	 
	<!-- container -->
	<!-- Content Section -->

	
	<div id="div_navigation"> 
		<span id="lbl_search_count"></span>
		<div id="progress_bar" class="progress-bar progress-bar-striped indeterminate"></div>
		 
		<div id="div_logggin_info"> 						 
			<span  id= "lbllogginuser">
				<?php
					echo "Logged in User [ " . $_SESSION["loggedinuser"] . " ]";
				?>
			</span>
			<span  id= "lblloggedintime">
				<?php
					echo "[ " . $_SESSION["loggedintime"] . " ]";
				?>
			</span>				 
		</div>

	</div>
			
	
	
		
	<div class="wrapper">

		<!--Top menu -->
		<div class="sidebar">
	 
			<!--profile image & text-->
			<div class="profile">
				<img id="img_logo" src="images/jkuat_logo.png" > 
				<h3>JKUAT</h3>
				<p> ONLINE TELEPHONY DIRECTORY</p>
			</div>
				 
			<!--menu item-->
			<ul>
				<li>
					<a id="btndashboard">
						<span class="icon"><i class="fas fa-home"></i></span>
						<span class="item">Dashboard</span>
					</a>
				</li>
				<li>
					<a id="btnlist_extensions">
						<span class="icon"><i class="fas fa-home"></i></span>
						<span class="item">Extensions</span>
					</a>
				</li>
				<li>
					<a id="btnlist_campuses" class="active">
						<span class="icon"><i class="fas fa-desktop"></i></span>
						<span class="item">Campuses</span>
					</a>
				</li>
				<li>
					<a id="btnlist_departments">
						<span class="icon"><i class="fas fa-user-friends"></i></span>
						<span class="item">Departments</span>
					</a>
				</li>
				<li>
					<a id="btnlist_users">
						<span class="icon"><i class="fas fa-tachometer-alt"></i></span>
						<span class="item">Users</span>
					</a>
				</li> 
				<li>
					<a id="btn_logout">
						<span class="icon"><i class="fas fa-cog"></i></span>
						<span class="item">Logout</span>
					</a>
				</li>

			
			
		</div>

	</div>
	
	 	
			
	<div id="dashboard_container">

			
		<div id="campus_container">
			<div id="div_container"> 
				<button id="btncreate_campus_view" type="button" class="btn btn-success btn_create">Create Campus</button>	 
			</div>
			
			<div id="div_admin_search_container">
				  
				<div class="div_search">
					<label for="txt_search_code">Code</label> 
					<input type="text" id="txt_search_code" name="txt_search_code" placeholder="Code" class="form-control" required placeholder="Code" />
				</div>
				 
				<div class="div_search">
					<label for="txt_search_name">Name</label> 
					<input type="text" id="txt_search_name" name="txt_search_name" placeholder="Name" class="form-control" required placeholder="Name" />
				</div>
					 
				<div class="div_search">
					<label for="cbo_search_records_to_display">No of Records to Display</label> 
					<select id="cbo_search_records_to_display" class="form-control"></select>
				</div>
				 
			</div>
			 
			<div id="div_content_container">
				 
				<div id="div_content"></div>
				
				<div id="div_messages"></div>
				
			</div>
			
		</div>

  

		<div id="div_edit_campus_container">
 
 
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="loginmodallabel">Edit Campus</h4>
				</div>
				   
				<div class="modal-body">
					<div class="form-group">
						<h5 class="card-title">Fields with <span class="text-danger">*</span> are mandatory!</h5>
						<div id="div_modal_msg"></div>
					</div>

					<div class="form-group">						
						<div class="div_messages_modal"></div>			
					</div>

					<div class="form-group"> 
						<input type="text" id="txt_edit_id" name="txt_edit_id" placeholder="id" class="form-control" required placeholder="id" />
					</div>
 
					<div class="form-group"> 
						<input type="text" id="txt_edit_addedby" name="txt_edit_addedby" placeholder="id" class="form-control" required placeholder="added by" />
					</div>
 
					<div class="form-group">
						<label for="txt_edit_code">Code<span class="text-danger">*</span></label> 
						<input type="text" id="txt_edit_code" name="txt_edit_code" placeholder="Code" class="form-control" required placeholder="Code" />
					</div>
					 
					<div class="form-group">
						<label for="txt_edit_name">Name<span class="text-danger">*</span></label> 
						<input type="text" id="txt_edit_name" name="txt_edit_name" placeholder="Name" class="form-control" required placeholder="Name" />
					</div>
						 
				</div> 
				<div class="modal-footer"> 
					<button id="btnupdate_campus" type="button" class="btn btn-success" ><img src="images/add.png" alt="Update" title="Update" style="vertical-align:bottom;" />Update</button>
					<button id="btnclose_edit_campus_modal" type="button" class="btn btn-danger" data-dismiss="modal"><img src="images/cancel.png" alt="Cancel" title="Cancel" style="vertical-align:bottom;" />Cancel</button>
				</div>
			</div>

 
		</div>
		
		
		
	</div>

 
	<!-- // Content Section -->
	<!-- end .container -->


	<!-- Bootstrap Modals -->

	<!-- create Modal -->
	<div class="modal fade crud_modal" id="create_campus_modal" tabindex="-1" role="dialog" aria-labelledby="create_campus_modal_label">
		<div class="modal-dialog" role="document">
		
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="loginmodallabel">Create Campus</h4>
				</div>
				  
				<div class="modal-body">
					<div class="form-group">
						<h5 class="card-title">Fields with <span class="text-danger">*</span> are mandatory!</h5>
						<div id="div_modal_msg"></div>
					</div>

					<div class="form-group">						
						<div class="div_messages_modal"></div>			
					</div>

					<div class="form-group">
						<label for="txt_create_code">Code<span class="text-danger">*</span></label> 
						<input type="text" id="txt_create_code" name="txt_create_code" placeholder="Code" class="form-control" required placeholder="Code" />
					</div>
					 
					<div class="form-group">
						<label for="txt_create_name">Name<span class="text-danger">*</span></label> 
						<input type="text" id="txt_create_name" name="txt_create_name" placeholder="Name" class="form-control" required placeholder="Name" />
					</div>
						 

				</div> 
				<div class="modal-footer"> 
					<button id="btncreate_campus" type="button" class="btn btn-success" ><img src="images/add.png" alt="Create" title="Create" style="vertical-align:bottom;" />Create</button>
					<button id="btnclose_create_campus_modal" type="button" class="btn btn-danger" data-dismiss="modal"><img src="images/cancel.png" alt="Cancel" title="Cancel" style="vertical-align:bottom;" />Cancel</button>
				</div>
			</div>
			
		</div>
	</div>
	<!-- // create Modal -->

	
	<!-- // Bootstrap Modals -->


    <div id="div_footer"> 
        <span id="lblcopyright">copyright</span> 
        <span id="lblfooterdate">date</span> 
        <span id="lblfootertime">time</span>
        <span id="lblfooterelapsedtime">elapsed</span>
    </div>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="js/jquery-3.2.1.js" type="text/javascript" language="javascript" defer></script>
	
	<script src="js/jquery-ui-1.12.1.js" type="text/javascript" language="javascript" defer></script>
		  
	<!-- Latest compiled and minified Bootstrap JavaScript -->
	<script src="js/bootstrap-3.3.7.js" type="text/javascript" language="javascript" defer></script>
 
	<script src="js/utils.js" type="text/javascript" language="javascript" defer></script>
	<script src="js/campus.js" type="text/javascript" language="javascript" defer></script>
	
</body>
</html>



























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
			//header('Location: ' . $global_path . 'admin.php');
			//exit(); 
		}
	}else{
		$cookie_name = "origin";
		$cookie_value = $server_path;
		setcookie($cookie_name, $cookie_value, time() + (60*60*24*365), "/");
		
		$global_path = $_COOKIE["origin"];
		echo $global_path; 
		header('Location: ' . $global_path . 'admin.php');
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
	<title>Ip Telephony - Dashboard</title>
	
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
  
	<link rel="stylesheet" type="text/css" media="all" href="css/admin.css" /> 
	  
  
</head>
<body>
	 
	<!-- container -->
	<!-- Content Section -->
 
	<div id="div_navigation"> 
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
			
			
	<div id="dashboard_container" >
		 
		 
			<div class="dashboard_card">
				<p>Campuses</p>  
				<div id="div_dashboard_card_campus" class="div_dashboard_card"></div>
			</div>
				
			<div class="dashboard_card">
				<p>Departments</p>  
				<div id="div_dashboard_card_departments" class="div_dashboard_card"></div>
			</div>
				
			<div class="dashboard_card">
				<p>Extensions</p>  
				<div id="div_dashboard_card_extensions" class="div_dashboard_card"></div>
			</div>
			 
			<div class="dashboard_card">
				<p>Users</p>  
				<div id="div_dashboard_card_users" class="div_dashboard_card"></div>
			</div>
			 
	</div>


 

	<div class="wrapper">

		<!--Humburger button -->
		<div class="hamburger_lines" onclick="toggle_navigation();">
		
		  <span class="line line1"></span>
		  <span class="line line2"></span>
		  <span class="line line3"></span>
			  
		</div>

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
					<a id="btndashboard" class="active">
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
					<a id="btnlist_campuses">
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
			</ul>

			
			
		</div>

	</div>
		 
		 
	<!-- // Content Section -->
	<!-- end .container -->

	<!--<div id="toast" class="invisible"> 
		<a id="btn_close_toast"><img src="images/delete.png" /></a>
		<div id="div_toast_msg"></div>
	</div>  -->
 

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
	<script src="js/admin.js" type="text/javascript" language="javascript" defer></script> 
	 
 


</body>
</html>



























<?php

session_start();
 
include_once "get_url.php";
  
if (isset($_COOKIE['loggedinuser']))
{
	// 👇 check if cookie exists
	if (isset($_COOKIE["origin"])) {
		
		//get the logged in user role from the session		
		$logged_in_user_role = $_COOKIE['logged_in_user_role'];
		
		if($logged_in_user_role == "LimitedAdmin" || $logged_in_user_role == "Superadmin")
		{ 
			$global_path = $_COOKIE["origin"];
			//echo $global_path; 
			//header('Location: ' . $global_path . 'upload_download_utility.php');
			//exit(); 
		}
	}else{
		$cookie_name = "origin";
		$cookie_value = $server_path;
		setcookie($cookie_name, $cookie_value, time() + (60*60*24*365), "/");
		
		$global_path = $_COOKIE["origin"];
		echo $global_path; 
		header('Location: ' . $global_path . 'upload_download_utility.php');
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
	<title>Ip Telephony - Upload Utility</title>
	
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
  
	<link rel="stylesheet" type="text/css" media="all" href="css/upload_download_utility.css" /> 
	
  
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
					echo "Logged in User [ " . $_COOKIE["loggedinuser"] . " ]";
				?>
			</span>
			<span  id= "lblloggedintime">
				<?php
					echo "[ " . $_COOKIE["loggedintime"] . " ]";
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
				<li id="view_upload_download_utility">
					<a id="btnupload_download_utility" class="active">
						<span class="icon"><i class="fas fa-home"></i></span>
						<span class="item">Upload Utility</span>
					</a>
				</li>
				<li id="view_extensions">
					<a id="btnlist_extensions">
						<span class="icon"><i class="fas fa-home"></i></span>
						<span class="item">Extensions</span>
					</a>
				</li>
				<li id="view_campuses">
					<a id="btnlist_campuses">
						<span class="icon"><i class="fas fa-desktop"></i></span>
						<span class="item">Campuses</span>
					</a>
				</li>
				<li id="view_departments">
					<a id="btnlist_departments">
						<span class="icon"><i class="fas fa-user-friends"></i></span>
						<span class="item">Departments</span>
					</a>
				</li>
				<li id="view_users">
					<a id="btnlist_users">
						<span class="icon"><i class="fas fa-tachometer-alt"></i></span>
						<span class="item">Users</span>
					</a>
				</li> 
				<li id="view_roles">
					<a id="btnlist_roles">
						<span class="icon"><i class="fas fa-tachometer-alt"></i></span>
						<span class="item">Roles</span>
					</a>
				</li> 
				<li id="view_rights">
					<a id="btnlist_rights">
						<span class="icon"><i class="fas fa-tachometer-alt"></i></span>
						<span class="item">Rights</span>
					</a>
				</li> 
				<li id="view_users_roles">
					<a id="btnlist_users_roles">
						<span class="icon"><i class="fas fa-tachometer-alt"></i></span>
						<span class="item">Users Roles</span>
					</a>
				</li> 
				<li id="view_roles_rights">
					<a id="btnlist_roles_rights">
						<span class="icon"><i class="fas fa-tachometer-alt"></i></span>
						<span class="item">Roles Rights</span>
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

			
		<div id="upload_container">
			 
			<div id="div_content_container">
				 
				<div id="div_content"> 
					<label id="lbl_title">You can download a preformated template to see how the extensions data is supposed to be formatted.</label>
					
					<div id="div_select">
						<label id="lbl_choose">Choose your file</label>
						<input type="file" name="txt_file" id="txt_file" class="form-control" accept=".xls,.xlsx">
						<img id="img_result" />
						<label id="lbl_upload_error"></label>
					</div>
					<div id="div_upload">
						<button type="submit" id="btn_upload" name="btn_upload" class="btn btn-success">Upload Extensions</button>
						<!-- <a id="btn_download" href="Template/extensions_template.xlsx" class="btn btn-info">Download Extensions Excel Template</a> -->
						<a id="btn_download" class="btn btn-info">Download Extensions Excel Template</a>
					</div>
				 
				</div>
				
				<div id="div_messages"></div>
				
			</div>
			
		</div>

  
		
		
	</div>

 

	<!-- // Content Section -->
	<!-- end .container -->
 

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
	<script src="js/upload_download_utility.js" type="text/javascript" language="javascript" defer></script>
	
</body>
</html>



























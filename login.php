<?php
session_start();
 
include_once "get_url.php";

// 👇 check if cookie exists
if (isset($_COOKIE["origin"])) {
	$global_path = $_COOKIE["origin"];
	 
}else{
	$cookie_name = "origin";
	$cookie_value = $server_path;
	setcookie($cookie_name, $cookie_value, time() + (60*60*24*365), "/");

	$global_path = $_COOKIE["origin"];
 
}

?>

<!DOCTYPE html> 
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Ip Telephony - Login</title>
	
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
  
	<link rel="stylesheet" type="text/css" media="all" href="css/login.css" />
  
</head>
<body>
 
 
	<!-- container -->
	<!-- Content Section -->
	
	
	
	
	

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
				<a id="btnsearch" class="active">
					<span class="icon"><i class="fas fa-home"></i></span>
					<span class="item">Search</span>
				</a>
			</li> 
		</ul>

		
		
    </div>

</div>
	
	 
	 
	 
	 <div id="dashboard_container">
	 
		<div id="div_login_container">
 
 
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="loginmodallabel">Login</h4>
				</div>
				   
				<div class="modal-body">
					<div class="form-group">
						<h5 class="card-title">Fields with <span class="text-danger">*</span> are mandatory!</h5>
					</div>

					<div class="form-group">						
						<div id="div_messages_modal"></div>			
					</div>
 
					<div class="form-group">
						<label for="txtemail">Email <span class="text-danger">*</span></label>
						<input type="email" id="txtemail" name="txtemail" placeholder="Email" class="form-control" required placeholder="Email" />
						<p id="txtemail_error" class="error"></p>
					</div>

					<div class="form-group">
						<label for="txtpassword">Password <span class="text-danger">*</span></label>
						<input type="password" id="txtpassword" name="txtpassword" placeholder="Password" class="form-control" required placeholder="Password" />
						<p id="txtpassword_error" class="error"></p>
					</div>

				</div> 
				<div class="modal-footer"> 
					<button id="btnlogin" type="button" class="btn btn-success">Login</button>
				</div>
			</div>

 
		</div>
		
	
	</div>
		
		
		
		
		
		
	<!-- // Content Section -->
	<!-- end .container -->
	
	
	
	<!-- Bootstrap Modals -->

	<!--  Login Modal
	<div class="modal fade" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="loginmodallabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="loginmodallabel">Login</h4> 
				</div>
				  
				<div class="modal-body">
					<div class="form-group">					
						<h5 class="card-title">Fields with <span class="text-danger">*</span> are mandatory!</h5>						
						<div id="div_modal_msg"></div>
					</div>

					<div class="form-group">
						<label for="txtuser_name">Email <span class="text-danger">*</span></label>
						<input type="text" id="txtuser_name" name="txtuser_name" placeholder="Email" class="form-control" required placeholder="Email" />
					</div>

					<div class="form-group">
						<label for="txtuser_password">Password <span class="text-danger">*</span></label>
						<input type="text" id="txtuser_password" name="txtuser_password" placeholder="Password" class="form-control" required placeholder="Password" />
					</div>
	 
				</div> 
				<div class="modal-footer"> 
					<button id="btnhome" type="submit" class="btn btn-success">Home</button>
					<button id="btnlogin" type="submit" class="btn btn-primary">Login</button>
				</div>
			</div>
			
			<div id="div_messages_modal"></div>
			
		</div>
	</div>
	<!-- // Login Modal -->

	<!-- // Bootstrap Modals -->
 
 
	<div id="div_messages"></div>
 

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
	<script src="js/login.js" type="text/javascript" language="javascript" defer></script>
	
</body>
</html>



























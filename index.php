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
	<title>Ip Telephony - Home</title>
	
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
  
	<link rel="stylesheet" type="text/css" media="all" href="css/search.css" />
  
</head>
<body>
 
	<!-- container -->
	<!-- Content Section -->
 	
		
	<div id="div_navigation">   						 
		<span id="lbl_search_count"></span>
		<div id="progress_bar" class="progress-bar progress-bar-striped indeterminate"></div>	
	</div>
			


			
	<div id="maincontainer" class="container">

		<div id="div_search_content"></div>

		<div id="div_messages"></div>

		<div id="div_help_content">
		
			<p id="title">Search senarios include:-</p>			
			<ol id="lst_help_content">
				<li><p>1. All items are specified.</p></li>
				<li><p>2. Campus and Department(selected).</p></li>
				<li><p>3. Campus and Department(typed).</p></li>
				<li><p>4. Campus and Owner Assigned(typed).</p></li>
				<li><p>5. Campus and Extension(typed).</p></li>
				<li><p>6. Campus and Department selected and Extension typed.</p></li>
				<li><p>7. Campus and Department selected and Department typed.</p></li>
				<li><p>8. Campus and Department selected and Owner Assigned typed.</p></li>
				<li><p>9. Department only(typed).</p></li>
				<li><p>10. Department only(selected).</p></li>
				<li><p>11. Owner Assigned only(typed).</p></li>
				<li><p>12. Extension only(typed).</p></li>
				<li><p>13. No item is specified.</p></li>
			</ol>		 
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
		
		<div id="div_search_content_container">
			 
			
			<div class="div_search">
				<button id="btnclearsearch" type="button" class="btnclearsearch"><i class="fa fa-fw fa-plus-circle"></i>Clear Search</button>
			</div>
				
			<div class="div_search">
				<label for="cbocampus">Select Campus</label> 
				<select id="cbocampus" class="form-control"></select>
			</div>
				
			<div class="div_search">
				<label for="cbodepartment">Select Department</label> 
				<select id="cbodepartment" class="form-control"></select>
			</div>
				
			<div class="div_search">
				<label for="txtdepartment">Department</label> 
				<input type="text" id="txtdepartment" name="txtdepartment" placeholder="Department" class="form-control" required placeholder="Department" />
			</div>
				
			<div class="div_search">
				<label for="txtowner_assigned">Owner Assigned</label> 
				<input type="text" id="txtowner_assigned" name="txtowner_assigned" placeholder="Owner Assigned" class="form-control" required placeholder="Owner Assigned" />
			</div>
				
			<div class="div_search">
				<label for="txtextension_number">Extension No</label> 
				<input type="text" id="txtextension_number" name="txtextension_number" placeholder="Extension No" class="form-control" required placeholder="Extension No" />
			</div>
			 
			
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
	<script src="js/search.js" type="text/javascript" language="javascript" defer></script>
	
</body>
</html>



























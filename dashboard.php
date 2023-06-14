<?php
session_start();

if (!isset($_SESSION['loggedinuser']))
{
	header('Location: http://localhost:90/jkuat_ip_telephony/login.php');
	exit();
}
        
$logged_in_user_role = $_SESSION['logged_in_user_role'];

if($logged_in_user_role == "LimitedAdmin")
{
	header('Location: http://localhost:90/jkuat_ip_telephony/dashboard.php');
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
	
	<link rel="stylesheet" type="text/css" media="all" href="css/dashboard.css" /> 
	
  
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
			
			
	<div id="dashboard-container" >
		 
		 
			<div class="dashboard-card">
				<p>Campuses</p>  
				<div id="div_dashboard-card_campus" class="div_dashboard-card"></div>
			</div>
				
			<div class="dashboard-card">
				<p>Departments</p>  
				<div id="div_dashboard-card_departments" class="div_dashboard-card"></></div>
			</div>
				
			<div class="dashboard-card">
				<p>Extensions</p>  
				<div id="div_dashboard-card_extensions" class="div_dashboard-card"></></div>
			</div>
			 
			<div class="dashboard-card">
				<p>Users</p>  
				<div id="div_dashboard-card_campus" class="div_dashboard-card"></></div>
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
				<a id="btnreports">
					<span class="icon"><i class="fas fa-chart-line"></i></span>
					<span class="item">Reports</span>
				</a>
			</li> 
			<li>
				<a id="btnsettings">
					<span class="icon"><i class="fas fa-cog"></i></span>
					<span class="item">Settings</span>
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


	<!-- Bootstrap Modals -->

	<!-- create Modal -->
	<div class="modal fade crud_modal" id="create_user_modal" tabindex="-1" role="dialog" aria-labelledby="create_user_modal_label">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="loginmodallabel">Create User</h4>
				</div>
				  
				<div class="modal-body">
					<div class="form-group">
						<h5 class="card-title">Fields with <span class="text-danger">*</span> are mandatory!</h5>
						<div id="div_modal_msg"></div>
					</div>

					<div class="form-group">
						<label for="cbo_create_campus">Campus <span class="text-danger">*</span></label> 
						<select id="cbo_create_campus" class="form-control"></select>
					</div>

					<div class="form-group">
						<label for="txtextension_number">Extension No <span class="text-danger">*</span></label>
						<input type="text" id="txt_create_extension_number" name="txtextension_number" placeholder="Extension No" class="form-control" required placeholder="Extension No" />
					</div>

					<div class="form-group">
						<label for="txtowner_assigned">Owner Assigned <span class="text-danger">*</span></label>
						<input type="text" id="txt_create_owner_assigned" name="txtowner_assigned" placeholder="Owner Assigned" class="form-control" required placeholder="Owner Assigned" />
					</div>
	 
					<div class="form-group">
						<label for="cbo_create_department">Department <span class="text-danger">*</span></label>
						<select id="cbo_create_department" class="form-control"></select>
					</div>
	 
				</div> 
				<div class="modal-footer"> 
					<button id="btncreate_extension" type="button" class="btn btn-primary" ><img src="images/add.png" alt="Create" title="Create" style="vertical-align:bottom;" />Create</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal"><img src="images/cancel.png" alt="Cancel" title="Cancel" style="vertical-align:bottom;" />Cancel</button>
				</div>
			</div>
			
			<div id="div_messages_modal"></div>
			
		</div>
	</div>
	<!-- // create Modal -->

	<!-- edit Modal -->
	<div class="modal fade crud_modal" id="edit_user_modal" tabindex="-1" role="dialog" aria-labelledby="edit_user_modal_label">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="loginmodallabel">Edit User</h4>
				</div>
				  
				<div class="modal-body">
					<div class="form-group">
						<h5 class="card-title">Fields with <span class="text-danger">*</span> are mandatory!</h5>
						<div id="div_modal_msg"></div>
					</div>

					<div class="form-group"> 
						<input type="text" id="txt_edt_id" name="txt_edt_id" placeholder="id" class="form-control" required placeholder="id" />
					</div>

					<div class="form-group">
						<label for="cbo_edit_campus">Campus <span class="text-danger">*</span></label> 
						<select id="cbo_edit_campus" class="form-control"></select>
					</div>

					<div class="form-group">
						<label for="txt_edit_extension_number">Extension No <span class="text-danger">*</span></label>
						<input type="text" id="txt_edit_extension_number" name="txt_edit_extension_number" placeholder="Extension No" class="form-control" required placeholder="Extension No" />
					</div>

					<div class="form-group">
						<label for="txt_edit_owner_assigned">Owner Assigned <span class="text-danger">*</span></label>
						<input type="text" id="txt_edit_owner_assigned" name="txt_edit_owner_assigned" placeholder="Owner Assigned" class="form-control" required placeholder="Owner Assigned" />
					</div>
	 
					<div class="form-group">
						<label for="cbo_edit_department">Department <span class="text-danger">*</span></label>
						<select id="cbo_edit_department" class="form-control"></select>
					</div>
	 
				</div> 
				<div class="modal-footer"> 
					<button id="btnupdate_extension" type="button" class="btn btn-primary" ><img src="images/add.png" alt="Update" title="Update" style="vertical-align:bottom;" />Update</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal"><img src="images/cancel.png" alt="Cancel" title="Cancel" style="vertical-align:bottom;" />Cancel</button>
				</div>
			</div>
			
			<div id="div_messages_modal"></div>
			
		</div>
	</div>
	<!-- // edit Modal -->

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
	<script src="js/dashboard.js" type="text/javascript" language="javascript" defer></script>
	
</body>
</html>



























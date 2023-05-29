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
	header('Location: http://localhost:90/jkuat_ip_telephony/extensions.php');
	exit();
}

?>
<!DOCTYPE html> 
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Ip Telephony - Extensions</title>
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1"/>
	
    <link rel="icon" type="image/png" href="images/favicon.png"/>
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico"/>
	
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" media="all" href="css/bootstrap-3.3.7.css" />
			   
	<!-- jQuery ui -->
	<link rel="stylesheet" type="text/css" media="all" href="css/jquery-ui-1.12.1.css" />
	
	<link rel="stylesheet" type="text/css" media="all" href="css/admin.css" /> 
	
  
</head>
<body>
	 
	<!-- container -->
	<!-- Content Section -->

	<div id="div_navigation"> 
		<div id="progress_bar" class="progress-bar progress-bar-striped indeterminate"></div>
		<img id="img_logo" src="images/jkuat_logo.png" >
				
		<div id="page_header">
			<span id="organization_name">JOMO KENYATTA UNIVERSITY OF AGRICULTURE AND TECHNOLOGY</span>
			<span id="organization_slogan">Setting Trends in Higher Education, Research and Innovation.</span>  
			<span id="app_title">JKUAT ONLINE TELEPHONY DIRECTORY</span> 
		</div> 
			
		<div id="div_logggin_info"> 						 
			<span  id= "lbllogginuser" class="btn btn-success btn_logout" >
				<i class="fa fa-fw fa-plus-circle">
					<?php
						echo "logged in user [ " . $_SESSION["loggedinuser"] . " ]";
					?>
				</i>
			</span>
			<span  id= "lblloggedintime" class="btn btn-success btn_logout" >
				<i class="fa fa-fw fa-plus-circle">
					<?php
						echo "[ " . $_SESSION["loggedintime"] . " ]";
					?>
				</i>
			</span>				
			<button id="btn_logout" type="button" class="btn btn-warning btn_logout"><i class="fa fa-fw fa-plus-circle"></i>Logout</button>  
		</div>

	</div>
			
			
	<div id="maincontainer" class="container">
		<div id="div_container">
		
			<button id="btnlist_extensions" type="button" class="btn btn-warning crud_buttons"><i class="fa fa-fw fa-plus-circle"></i>Extensions</button> 
			<button id="btncreate_extension_view" type="button" class="btn btn-success crud_buttons"><img src="images/add.png" alt="Create" title="Create" style="vertical-align:bottom;" />create extension</button>		
			<button id="btnlist_users" type="button" class="btn btn-warning crud_buttons"><i class="fa fa-fw fa-plus-circle"></i>Users</button> 
			<button id="btnlist_departments" type="button" class="btn btn-warning crud_buttons"><i class="fa fa-fw fa-plus-circle"></i>Departments</button> 
			<button id="btnlist_campuses" type="button" class="btn btn-warning crud_buttons"><i class="fa fa-fw fa-plus-circle"></i>Campuses</button> 
				 
		</div>
		
		<div id="div_admin_search_container">
			 
			<div class="div_search">
				<label for="cbo_search_campus">Campus</label> 
				<select id="cbo_search_campus" class="form-control"></select>
			</div>
				
			<div class="div_search">
				<label for="cbo_search_department">Department</label> 
				<select id="cbo_search_department" class="form-control"></select>
			</div>
				
			<div class="div_search">
				<label for="txt_search_extension_number">Extension No</label> 
				<input type="text" id="txt_search_extension_number" name="txt_search_extension_number" placeholder="Extension No" class="form-control" required placeholder="Extension No" />
			</div>
			 
			<div class="div_search">
				<label for="cbo_records_to_display">No of Records to Display</label> 
				<select id="cbo_records_to_display" class="form-control"></select>
			</div>
			 
		</div>
		
		<div id="div_search_content_container">
			 
			<div id="div_search_content"></div>
			  
		</div>
		
		<div id="div_content_container">
			 <select id="select">                                             
            <option value="0">System Design</option>
            <option value="1">DSA-Online</option>
            <option value="2">Fork Python</option>
            <option value="3">Fork Java</option>
        </select> 
			<div id="div_content"></div>
			
			<div id="div_messages"></div>
			
		</div>
		
	</div>

	<!-- // Content Section -->
	<!-- end .container -->


	<!-- Bootstrap Modals -->

	<!-- create Modal -->
	<div class="modal fade crud_modal" id="create_extension_modal" tabindex="-1" role="dialog" aria-labelledby="create_extension_modal_label">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="loginmodallabel">Create Extension</h4>
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
	<div class="modal fade crud_modal" id="edit_extension_modal" role="dialog" aria-labelledby="edit_extension_modal_label">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="loginmodallabel">Edit Extension</h4>
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

	<script src="js/select2.js" type="text/javascript" language="javascript" defer></script>
	<script src="js/utils.js" type="text/javascript" language="javascript" defer></script>
	<script src="js/admin.js" type="text/javascript" language="javascript" defer></script>
	
</body>
</html>



























 
$(document).ready(function () {
    
	//listen for enter key event in document.
	document.addEventListener("keypress", documententerkeyglobalhandler, false);
  
    $('#btn_logout').on('click', function(){
        logout_ajax();
    });
	    
    $('#btncreate_department_view').on('click', function(){
		clear_logs();
        $('#create_department_modal').modal('show');
		$("#txt_create_department_name").val(""); 
    });
	   
	$('#create_department_modal').on('shown.bs.modal', function () {
		fetch_all_campuses();
		$('#cbo_create_campus').focus();
	})  
	 
    $('#btncreate_department').on('click', function(){
        create_department();
    });
	    
    $('#btnupdate_department').on('click', function(){
        update_department();
    });
	    
	resize_components();

	$(window).on('resize', function(){
		resize_components();         
	});

	$(window).on('load', function(){
		resize_components();
	});
	      
    $('#txt_search_campus').on('input', function(){
        search_departments(1);
    });
	  
    $('#txt_search_name').on('input', function(){
        search_departments(1);
    });
	  
    $('.btn_edit').on('click', function(){
		clear_logs();
		var id = $(this).attr('data-id');  		
        edit_department(id);
    });
	  
    $('.btn_delete').on('click', function(){
		clear_logs();
		var id = $(this).attr('data-id');
        delete_department(id);
    });
		
    $('#btndashboard').on('click', function(){
        window.location.href = global_path + 'admin.php';
    });
	  
    $('#btnlist_extensions').on('click', function(){
        window.location.href = global_path + 'extensions.php';
    });
	  
    $('#btnlist_campuses').on('click', function(){
        window.location.href = global_path + 'campuses.php';
    });
	
    $('#btnlist_departments').on('click', function(){
        window.location.href = global_path + 'departments.php';
    });
	  
    $('#btnlist_users').on('click', function(){
        window.location.href = global_path + 'users.php';
    });
	  
    $('#btnlist_roles').on('click', function(){
        window.location.href = global_path + 'roles.php';
    });
	  
    $('#btnlist_rights').on('click', function(){
        window.location.href = global_path + 'rights.php';
    });
	  
    $('#btnlist_users_roles').on('click', function(){
        window.location.href = global_path + 'users_roles.php';
    });
	  
    $('#btnlist_roles_rights').on('click', function(){
        window.location.href = global_path + 'roles_rights.php';
    });
	  
    $('#img_logo').on('click', function(){
        window.location.href = global_path + 'admin.php';
    });
	
	search_departments(1);
	
    $('#btnclose_create_department_modal').on('click', function(){
        clear_logs();
    });
	   
    $('#btnclose_edit_department_modal').on('click', function(){
        clear_logs();
		search_departments(1);		
    });
 
	$('.hamburger_lines').css('left', function() {
		return ($('.sidebar').width() - 55) + "px";
	});
		
	var select_options_arr = "";
	select_options_arr += '<option value="active">active</option>';
	select_options_arr += '<option value="inactive">inactive</option>'; 
	
	$('#cbo_create_status').html(select_options_arr);	
	$('#cbo_edit_status').html(select_options_arr);	

	wire_events();

	disable_all_actions();
		
	setTimeout(function() {
		authorization();
	}, 1000);
	
	$("#progress_bar").hide();
	 
});

var global_page_number_holder = 1;

function resize_components() { 

	$('#maincontainer').css('margin-top', function() {
		return $('#div_navigation').height();
	});

	$('#login_modal').css('margin-top', function() {
		return $('#div_navigation').height();
	});

	$('#create_department_modal').css('margin-top', function() {
		return $('#div_navigation').height();
	});
 
	$('#edit_department_modal').css('margin-top', function() {
		return $('#div_navigation').height();
	});
 
	$('#div_messages').css('margin-bottom', function() {
		return $('#div_footer').height();
	});
  
	$('#div_content_container').css('margin-bottom', function() {
		return $('#div_footer').height();
	});
 
}
   
function logout_ajax(){
	 
	show_progress();
	  
	// send data to server asynchronously.
	$.ajax({
		url: "logout.php",
		type: "POST",
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 
		
		window.location.href = global_path + 'login.php';
		 
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
	
}
 
function documententerkeyglobalhandler(e){

	var key = e.which || e.keycode;

	var callingelement = e.target.id;

	// ENTER key was pressed.
	if(key === 13){

		var url = this.URL;

		var _patharr = [];
		_patharr = url .split("/");

		var callingpagename = _patharr[4];

		switch(callingpagename){  
			case "departments.php":
				//create_department();
			break;
			default: 
			break;
		}

		
	}	
}
 
function create_department(){
	
	show_progress();
	clear_logs();
	document.querySelector("#cbo_create_campus_error").innerHTML = "";
	document.querySelector("#txt_create_department_name_error").innerHTML = "";
	
	var campus_id = $("#cbo_create_campus").val();
	var department_name = $("#txt_create_department_name").val().trim();
	var status = $("#cbo_create_status").val();
	var addedby = readCookie("loggedinuser"); 

	var isvalid = true;
	 
	if(campus_id != null)
	{ 
		if(campus_id.length == 0)
		{ 
			//log_error_messages("Select Campus."); 	
			document.querySelector("#cbo_create_campus_error").innerHTML = "Select Campus.";
      		document.querySelector("#cbo_create_campus_error").style.display = "block";			
			isvalid = false;
		} 
	}
	if(campus_id == null)
	{ 
		//log_error_messages("Select Campus."); 		
		document.querySelector("#cbo_create_campus_error").innerHTML = "Select Campus.";
      	document.querySelector("#cbo_create_campus_error").style.display = "block";		
		isvalid = false;
	}
	if(department_name.length == 0)
	{ 
		//log_error_messages("Name cannot be null."); 	
		document.querySelector("#txt_create_department_name_error").innerHTML = "Name cannot be null.";
      	document.querySelector("#txt_create_department_name_error").style.display = "block";			
		isvalid = false;
	}
	if(addedby == null)
	{ 
		log_error_messages("Cookie value not set."); 		
		isvalid = false;
	}else{
		if(addedby.length == 0)
		{ 
			log_error_messages("Error accessing cookie value."); 		
			isvalid = false;
		} 
	}	
	
	if(isvalid == false)
	{	
		hide_progress();
		return;
	}
	
	// send data to server asynchronously.
	$.ajax({
		url: "department_controller.php",
		type: "POST",
		data: { 
			"department_name": department_name,
			"campus_id": campus_id,
			"status": status, 
			"addedby": addedby, 
			"action": "create_department"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 

		log_info_messages(response);  

		search_departments(1);
		
		$('#create_department_modal').modal('hide');
		
		clear_logs();
		
		show_info_toast(response);
		
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
	
}
 
function edit_department(id){
	 
	show_progress();
	clear_logs();
	
	console.log("id: " + id); 
	
	var isvalid = true;
	if(id.length == 0)
	{
		log_error_messages("id cannot be null."); 
		isvalid = false;
	}
 
	if(isvalid == false)
	{	
		hide_progress();
		return;
	}
	
	fetch_all_campuses();
	
	// send data to server asynchronously.
	$.ajax({
		url: "department_controller.php",
		type: "POST",
		data: {
			"id": id,
			"action": "get_department"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 
		 
		var data = JSON.parse(response);
				 
		var id = data.id; 
		var department_name = data.department_name; 
		var campus_id = data.campus_id;
		var status = data.status;
 
		$('#edit_department_modal').modal('show'); 

		$('#edit_department_modal').on('shown.bs.modal', function () {
			$('#cbo_edit_campus').focus();
			$('#txt_edit_id').val(id);  
			$('#cbo_edit_campus').val(campus_id);  		 
			$("#txt_edit_department_name").val(department_name); 
			$('#cbo_edit_status').val(status); 
		})  

		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
	
}

function update_department(){
	
	show_progress();
	clear_logs();  
	document.querySelector("#cbo_edit_campus_error").innerHTML = "";
	document.querySelector("#txt_edit_department_name_error").innerHTML = "";
	
	var id = $('#txt_edit_id').val();
	var campus_id = $("#cbo_edit_campus").val(); 
	var department_name = $("#txt_edit_department_name").val().trim(); 
	var status = $("#cbo_edit_status").val();
	
	var isvalid = true;
	
	if(id.length == 0)
	{
		log_error_messages("Error retieving primary key."); 
		isvalid = false;
	} 
 	if(campus_id != null)
	{ 
		if(campus_id.length == 0)
		{ 
			//log_error_messages("Select Campus."); 	
			document.querySelector("#cbo_edit_campus_error").innerHTML = "Select Campus.";
      		document.querySelector("#cbo_edit_campus_error").style.display = "block";			
			isvalid = false;
		} 
	}
	if(campus_id == null)
	{ 
		//log_error_messages("Select Campus."); 		
		document.querySelector("#cbo_edit_campus_error").innerHTML = "Select Campus.";
      	document.querySelector("#cbo_edit_campus_error").style.display = "block";		
		isvalid = false;
	}
	if(department_name.length == 0)
	{ 
		//log_error_messages("Name cannot be null."); 	
		document.querySelector("#txt_edit_department_name_error").innerHTML = "Name cannot be null.";
      	document.querySelector("#txt_edit_department_name_error").style.display = "block";			
		isvalid = false;
	} 

	if(isvalid == false)
	{	
		hide_progress();
		return;
	}
	
	// send data to server asynchronously.
	$.ajax({
		url: "department_controller.php",
		type: "POST",
		data: {
			"id": id,
			"department_name": department_name, 
			"campus_id": campus_id,
			"status": status, 
			"action": "update_department"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 

		log_info_messages(response); 

		$('#edit_department_modal').modal('hide'); 

		search_departments(1);
		
		clear_logs();
		
		show_info_toast(response);
		
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
	
}

function delete_department(id){
	 
	show_progress();
		
	var delete_prompt = get_delete_extension_prompt(id);
	
	hide_progress();
	
}
 
function get_delete_extension_prompt(id){
	  
	show_progress();
	clear_logs();
	
	console.log("id: " + id); 
	
	var isvalid = true;
	if(id.length == 0)
	{
		show_error_toast("Error retrieving the Primary Key. <br />Reload the page."); 
		isvalid = false;
	}
 
	if(isvalid == false)
	{	
		hide_progress();
		return;
	}
	 
	// send data to server asynchronously.
	$.ajax({
		url: "department_controller.php",
		type: "POST",
		data: {
			"id": id,
			"action": "get_department"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 
		 
		var data = JSON.parse(response);
				 
		var id = data.id; 
		var department_name = data.department_name;
		var addedby = data.addedby; 
		
		var delete_prompt = "Are you sure you wish to delete Department [ " + department_name + " ].";
		
		console.log("delete_prompt: " + delete_prompt); 
					
		var heading = "Delete";
		var question = "are you sure you want to delete the record with id [ " + id + " ].";
		var cancelButtonTxt = "cancel";
		var okButtonTxt = "ok";
		
		var confirmModal = 
			$('<div id= "delete_modal" class="modal fade">' +        
			  '<div class="modal-dialog">' +
			  '<div class="modal-content">' +
			  '<div class="modal-header">' +
				'<a class="close" data-dismiss="modal" >&times;</a>' +
				'<h3>' + heading +'</h3>' +
			  '</div>' +

			  '<div class="modal-body">' + delete_prompt + '</div>' +

			  '<div class="modal-footer">' +		  
				'<a href="#!" id="okButton" class="btn btn-primary">' + 
				  okButtonTxt + 
				'</a>' +
				'<a href="#!" class="btn btn-danger" data-dismiss="modal">' + 
				  cancelButtonTxt + 
				'</a>' +
			  '</div>' +
			  '</div>' +
			  '</div>' +
			'</div>');

		confirmModal.find('#okButton').click(function(event) { 
			 
			confirmModal.modal('hide');
			
			// send data to server asynchronously.
			$.ajax({
			url: "department_controller.php",
			type: "POST",
			data: {
				"id": id,
				"action": "delete_department"
			},//data to be posted
			}).done(function(response){
				response = response.trim();

				console.log("response: " + response); 
	 
				log_info_messages(response); 
				
				search_departments(1);
				
				show_info_toast(response);
			
				hide_progress();

			}).fail(function(jqXHR, textStatus){
				log_error_messages(textStatus);
				hide_progress();
			});
		}); 

		confirmModal.modal('show');  
			
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
	
}
 
function fetch_departments(page){
	 
	show_progress();
	
	global_page_number_holder = page;
	
	var records_to_display = 5;
	records_to_display = $("#cbo_search_records_to_display").val();
	
	console.log("records_to_display: " + records_to_display);
	
	console.log("page: " + page);
	
	// send data to server asynchronously.
	$.ajax({
		url: "department_controller.php",
		type: "POST",
		data: {
			"page": page,
			"records_to_display": records_to_display,
			"action": "fetch_departments"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 
				
		$('#div_content').html(response);
 
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
	
}

function search_departments(page){
	 
	show_progress();
	
	close_toast();
	
	global_page_number_holder = page;
	
	var records_to_display = 10; 
	
	console.log("records_to_display: " + records_to_display);	
	console.log("page: " + page);
	
	var department_name = $("#txt_search_name").val(); 
	var campus_name = $("#txt_search_campus").val(); 
	 
	console.log("department_name: " + department_name);	 
	
	show_progress();
	
	// send data to server asynchronously.
	$.ajax({
		url: "department_controller.php",
		type: "POST",
		data: {
			"page": page,
			"records_to_display": records_to_display, 
			"department_name": department_name, 
			"campus_name": campus_name, 
			"action": "search_departments"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 
				   
		$('#department_container').css({'display' : 'block'});
	 
		$('#div_edit_department_container').css({'display' : 'none'});
	 		 
		$('#div_content').html(response);
		
		get_departments_search_count();
		
		disable_all_actions();

		setTimeout(function() {
			authorization();
		}, 1000);
		
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
	
}

function fetch_all_campuses() {
	
	show_progress();
		
	// send data to server asynchronously.
	$.ajax({
		url: "extension_controller.php",
		type: "POST",
		data: {
			"action": "fetch_all_campuses"
		},//data to be posted
	}).done(function(response){
		 
		console.log("response: " + response); 
		
		var campus_arr = JSON.parse(response);
		
		console.log("campus_arr: " + campus_arr); 
		
		var select_options_arr = [];

		select_options_arr.push('<option value=""></option>');
		
		for (var i = 0; i < campus_arr.length; i++) {
			var id = campus_arr[i].id;
			var campus_name = campus_arr[i].campus_name;
			console.log(id);
			console.log(campus_name);
			select_options_arr.push('<option value="' + id + '">' + campus_name + '</option>');
		}
 
		$('#cbo_create_campus').html(select_options_arr);
		$('#cbo_edit_campus').html(select_options_arr);
  
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
		
}

function get_departments_search_count(){
	 
	show_progress();
	  
	// send data to server asynchronously.
	$.ajax({
		url: "department_controller.php",
		type: "POST",
		data: { 
			"action": "get_departments_search_count"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 
		
		$('#lbl_search_count').text(response);
		
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
	
}
 
function go2Page(total_pages)
{
	close_toast();
	
	var current_page = document.getElementById("txt_page").value; 
	
	if(current_page.length == 0)
	{
		show_error_toast("Specify a Page number");
		return;
	}
	
	if(current_page > total_pages)
	{
		show_error_toast("Page number [ " + current_page + " ] does not exists.");
	}else{	
		search_departments(current_page);
	}
}

function toggle_navigation()
{ 
	var display = $('.sidebar').css('display');
	
	if(display == "block")
	{	
		//hide the sidebar
		var style = [
			'display: none',
		].join(';');
			
		$('.sidebar').attr('style', style);
		
		$('.hamburger_lines').css('left', function() {
			return "15px";
		});
		
		//expand the contnent
		var content_style = [ 
			'width: 90%',
			'left: 3%', 
		].join(';');
			
		$('#dashboard_container').attr('style', content_style);
				
	}else{
		//show the sidebar
		var style = [
			'display: block',
		].join(';');
			
		$('.sidebar').attr('style', style);
		
		
		$('.hamburger_lines').css('left', function() {
			return ($('.sidebar').width() - 55) + "px";
		});
		
		//shrink the contnent
		var content_style = [ 
			'width: 60%',
			'left: 30%', 
		].join(';');
			
		$('#dashboard_container').attr('style', content_style);
		
	}
}

function disable_all_actions()
{
	try{		
			
		show_progress();
		 
		// send data to server asynchronously.
		$.ajax({
			url: "admin_controller.php",
			type: "POST",
			data: {  
				"action": "get_roles_and_rights"
			},//data to be posted
		}).done(function(response){
			response = response.trim();
			
			console.log("response: " + response); 
			  
			var rights_obj = JSON.parse(response);
			 
			console.log("rights_obj: " + rights_obj); 
				 
			//var rights_arr = jQuery.parseJSON(rights_obj);
 
			//console.log("rights_arr: " + rights_arr); 
				 
			for (var i = 0; i < rights_obj.length; i++) {
				var right_code = rights_obj[i].right_code; 
				console.log(right_code); 

				var dom_element_from_id = document.querySelector('#' + right_code);
				var dom_element_from_class = document.querySelector('.' + right_code);
 
				console.log(dom_element_from_id); 
				console.log(dom_element_from_class); 

				if (dom_element_from_id) {
					//The element exists
					var style = [
						'display: none',
					].join(';');
						
					dom_element_from_id.setAttribute('style', style);
					
				}else if(dom_element_from_class){
					//The element exists
					var style = [
						'display: none',
					].join(';');
						
					dom_element_from_class.setAttribute('style', style);	

					var crud_elements = document.querySelectorAll('.' + right_code);

					console.log(crud_elements); 

					for (var t = 0; t < crud_elements.length; t++) {
						var current_item = crud_elements[t];
						console.log(current_item); 
						current_item.style.display = "none";
					}

				}

			}
	  
			hide_progress();
			
		}).fail(function(jqXHR, textStatus){
			log_error_messages(textStatus);
			hide_progress();
		});
		
		
	}catch (err) {
        log_error_messages(err);
        console.log(err);
    }	
}


function authorization()
{
	try{		
			
		show_progress();
		
		var logged_in_user_email = readCookie("logged_in_user_email");
		
		console.log("logged_in_user_email: " + logged_in_user_email); 
			  
		// send data to server asynchronously.
		$.ajax({
			url: "admin_controller.php",
			type: "POST",
			data: { 
				"logged_in_user_email": logged_in_user_email,
				"action": "get_user_roles_and_rights"
			},//data to be posted
		}).done(function(response){
			response = response.trim();
			
			console.log("response: " + response); 
			  
			var rights_obj = JSON.parse(response);
			 
			console.log("rights_obj: " + rights_obj); 
				 
			var rights_arr = jQuery.parseJSON(rights_obj);
 
			console.log("rights_arr: " + rights_arr); 
				 
			for (var i = 0; i < rights_arr.length; i++) {
				var right_code = rights_arr[i].right_code; 
				console.log(right_code); 

				var dom_element_from_id = document.querySelector('#' + right_code);
				var dom_element_from_class = document.querySelector('.' + right_code);
 
				console.log(dom_element_from_id); 
				console.log(dom_element_from_class); 

				if (dom_element_from_id) {
					//The element exists
					var style = [
						'display: block',
					].join(';');
						
					dom_element_from_id.setAttribute('style', style);
					//dom_element_from_id.setAttribute("style", "display: block;");
					
				}else if(dom_element_from_class){
					//The element exists
					var style = [
						'display: block',
					].join(';');
						
					dom_element_from_class.setAttribute('style', style);	
					
					var crud_elements = document.querySelectorAll('.' + right_code);

					console.log(crud_elements); 

					for (var t = 0; t < crud_elements.length; t++) {
						var current_item = crud_elements[t];
						console.log(current_item); 
						current_item.style.display = "block";
					}
				
				}

			}
	  
			hide_progress();
			
		}).fail(function(jqXHR, textStatus){
			log_error_messages(textStatus);
			hide_progress();
		});
		
		
	}catch (err) {
        log_error_messages(err);
        console.log(err);
    }	
}














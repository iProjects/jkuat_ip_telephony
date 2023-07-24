 
$(document).ready(function () {
    
	//listen for enter key event in document.
	document.addEventListener("keypress", documententerkeyglobalhandler, false);
  
    $('#btn_logout').on('click', function(){
        logout_ajax();
    });
	   
    $('#btncreate_user_role_view').on('click', function(){
		clear_logs();
        $('#create_user_role_modal').modal('show'); 
		$("#cbo_create_user").val("");
		$("#cbo_create_role").val(""); 		
    });
	
	$('#create_user_role_modal').on('shown.bs.modal', function () {
		$('#cbo_create_user').focus();
		fetch_users();
		fetch_roles();
	})  
	
    $('#btncreate_user_role').on('click', function(){
        create_user_role();
    });
	    
    $('#btnupdate_user_role').on('click', function(){
        update_user_role();
    });
	    
	resize_components();

	$(window).on('resize', function(){
		resize_components();         
	});

	$(window).on('load', function(){
		resize_components();
	});
	     
    $('#txt_search_user_name').on('input', function(){
        search_users_roles(1);
    });
	  
    $('#txt_search_role_name').on('input', function(){
        search_users_roles(1);
    });
	  
    $('.btn_edit').on('click', function(){
		clear_logs();
		var id = $(this).attr('data-id');  
        edit_user_role(id);
    });
	  
    $('.btn_delete').on('click', function(){
		clear_logs();
		var id = $(this).attr('data-id');
        delete_user_role(id);
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
	
	search_users_roles(1);
	
    $('#btnclose_create_user_role_modal').on('click', function(){
        clear_logs();
    });
	   
    $('#btnclose_edit_user_role_modal').on('click', function(){
        clear_logs();
		search_users_roles(1);		
    });
 
	$('.hamburger_lines').css('left', function() {
		return ($('.sidebar').width() - 55) + "px";
	});
		
	var select_options_arr = "";
	select_options_arr += '<option value="active">active</option>';
	select_options_arr += '<option value="inactive">inactive</option>'; 
	
	$('#cbo_create_status').html(select_options_arr);	
	$('#cbo_edit_status').html(select_options_arr);	

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

	$('#create_user_role_modal').css('margin-top', function() {
		return $('#div_navigation').height();
	});
 
	$('#edit_user_role_modal').css('margin-top', function() {
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
			case "users_roles.php":
				//create_user_role();
			break;
			default: 
			break;
		}

		
	}	
}
 
function create_user_role(){
	
	show_progress();
	clear_logs(); 
	document.querySelector("#cbo_create_user_error").innerHTML = "";
	document.querySelector("#cbo_create_role_error").innerHTML = "";
	 
	var user_id = $("#cbo_create_user").val();
	var role_id = $("#cbo_create_role").val();
	var status = $("#cbo_create_status").val();
	var addedby = readCookie("loggedinuser"); 

	var isvalid = true;
	
	if(user_id == null)
	{ 
		//log_error_messages("Select User."); 		
		document.querySelector("#cbo_create_user_error").innerHTML = "Select User.";
  		document.querySelector("#cbo_create_user_error").style.display = "block";	
		isvalid = false;
	}else{
		if(user_id.length == 0)
		{ 
			//log_error_messages("Select User."); 		
			document.querySelector("#cbo_create_user_error").innerHTML = "Select User.";
  			document.querySelector("#cbo_create_user_error").style.display = "block";	
			isvalid = false;
		}
	}
	if(role_id == null)
	{ 
		//log_error_messages("Select Role."); 		
		document.querySelector("#cbo_create_role_error").innerHTML = "Select Role.";
  		document.querySelector("#cbo_create_role_error").style.display = "block";	
		isvalid = false;
	}else{
		if(role_id.length == 0)
		{ 
			//log_error_messages("Select Role."); 		
			document.querySelector("#cbo_create_role_error").innerHTML = "Select Role.";
  			document.querySelector("#cbo_create_role_error").style.display = "block";	
			isvalid = false;
		}
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
		url: "user_role_controller.php",
		type: "POST",
		data: { 
			"user_id": user_id,
			"role_id": role_id,
			"status": status, 
			"addedby": addedby, 
			"action": "create_user_role"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 

		log_info_messages(response);  

		search_users_roles(1);
		
		$('#create_user_role_modal').modal('hide');
		
		clear_logs();
		
		show_info_toast(response);
		
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
	
}
 
function edit_user_role(id){
	 
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
	 
	// send data to server asynchronously.
	$.ajax({
		url: "user_role_controller.php",
		type: "POST",
		data: {
			"id": id,
			"action": "get_user_role"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 

		fetch_users();
		fetch_roles();

		var data = JSON.parse(response);
				 
		var id = data.id; 
		var user_id = data.user_id; 
		var role_id = data.role_id; 

		$('#txt_edit_id').val(id);   
		$("#cbo_edit_user").val(user_id); 
		$("#cbo_edit_role").val(role_id); 
		 
		$('#div_edit_user_role_container').css({'display' : 'block'});
	 		
		$('#user_role_container').css({'display' : 'none'});
	 		 
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
	
}

function update_user_role(){
	
	show_progress();
	clear_logs();  
	document.querySelector("#cbo_edit_user_error").innerHTML = "";
	document.querySelector("#cbo_edit_role_error").innerHTML = "";
	
	var id = $('#txt_edit_id').val(); 
	var user_id = $("#cbo_edit_user").val();
	var role_id = $("#cbo_edit_role").val();
	
	var isvalid = true;
	
	if(id.length == 0)
	{
		log_error_messages("Error retieving primary key."); 
		isvalid = false;
	}  
	if(user_id == null)
	{ 
		//log_error_messages("Select User."); 		
		document.querySelector("#cbo_edit_user_error").innerHTML = "Select User.";
  		document.querySelector("#cbo_edit_user_error").style.display = "block";	
		isvalid = false;
	}else{
		if(user_id.length == 0)
		{ 
			//log_error_messages("Select User."); 		
			document.querySelector("#cbo_edit_user_error").innerHTML = "Select User.";
  			document.querySelector("#cbo_edit_user_error").style.display = "block";	
			isvalid = false;
		}
	}
	if(role_id == null)
	{ 
		//log_error_messages("Select Role."); 		
		document.querySelector("#cbo_edit_role_error").innerHTML = "Select Role.";
  		document.querySelector("#cbo_edit_role_error").style.display = "block";	
		isvalid = false;
	}else{
		if(role_id.length == 0)
		{ 
			//log_error_messages("Select Role."); 		
			document.querySelector("#cbo_edit_role_error").innerHTML = "Select Role.";
  			document.querySelector("#cbo_edit_role_error").style.display = "block";	
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
		url: "user_role_controller.php",
		type: "POST",
		data: {
			"id": id, 
			"user_id": user_id,
			"role_id": role_id,
			"action": "update_user_role"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 

		log_info_messages(response);  

		search_users_roles(1);
		
		clear_logs();
		
		show_info_toast(response);
		
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
	
}

function delete_user_role(id){
	 
	show_progress();
			
	var delete_prompt = get_delete_prompt(id);
	
	hide_progress();
	
}
 
function get_delete_prompt(id){
	  
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
		url: "user_role_controller.php",
		type: "POST",
		data: {
			"id": id,
			"action": "get_user_role"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 
		 
		var data = JSON.parse(response);
				 
		var id = data.id; 
		var user_id = data.user_id; 
		var role_id = data.role_id; 
		
		var delete_prompt = "Are you sure you wish to delete Role [ " + role_id + " ].";
		
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
			url: "user_role_controller.php",
			type: "POST",
			data: {
				"id": id,
				"action": "delete_user_role"
			},//data to be posted
			}).done(function(response){
				response = response.trim();

				console.log("response: " + response); 
	 
				log_info_messages(response); 
				
				search_users_roles(1);
				
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
 
function search_users_roles(page){
	 
	show_progress();
	
	close_toast();
	
	global_page_number_holder = page;
	
	var records_to_display = 10; 
	
	console.log("records_to_display: " + records_to_display);	
	console.log("page: " + page);
	
	var user_name = $("#txt_search_user_name").val(); 
	var role_name = $("#txt_search_role_name").val(); 
	 	
	console.log("user_name: " + user_name);	 
	console.log("role_name: " + role_name);	 
	
	show_progress();
	
	// send data to server asynchronously.
	$.ajax({
		url: "user_role_controller.php",
		type: "POST",
		data: {
			"page": page,
			"records_to_display": records_to_display, 
			"user_name": user_name, 
			"role_name": role_name, 
			"action": "search_users_roles"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 
				   
		$('#user_role_container').css({'display' : 'block'});
	 
		$('#div_edit_user_role_container').css({'display' : 'none'});
	 		 
		$('#div_content').html(response);
		
		get_users_roles_search_count();
		
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
 
function get_users_roles_search_count(){
	 
	show_progress();
	  
	// send data to server asynchronously.
	$.ajax({
		url: "user_role_controller.php",
		type: "POST",
		data: { 
			"action": "get_users_roles_search_count"
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
		search_users_roles(current_page);
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
 
function fetch_users() {
	
	show_progress();
		
	// send data to server asynchronously.
	$.ajax({
		url: "user_role_controller.php",
		type: "POST",
		data: {
			"action": "fetch_users"
		},//data to be posted
	}).done(function(response){
		 
		console.log("response: " + response); 
		
		var users_arr = JSON.parse(response);
		
		console.log("users_arr: " + users_arr); 
		
		var select_options_arr = [];

		select_options_arr.push('<option value=""></option>');
		
		for (var i = 0; i < users_arr.length; i++) {
			var id = users_arr[i].id;
			var full_names = users_arr[i].full_names;
			console.log(id);
			console.log(full_names);
			select_options_arr.push('<option value="' + id + '">' + full_names + '</option>');
		}
 
		$('#cbo_create_user').html(select_options_arr);
		$('#cbo_edit_user').html(select_options_arr);
  
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
		
}
 

function fetch_roles() {
	
	show_progress();
		
	// send data to server asynchronously.
	$.ajax({
		url: "user_role_controller.php",
		type: "POST",
		data: {
			"action": "fetch_roles"
		},//data to be posted
	}).done(function(response){
		 
		console.log("response: " + response); 
		
		var roles_arr = JSON.parse(response);
		
		console.log("roles_arr: " + roles_arr); 
		
		var select_options_arr = [];

		select_options_arr.push('<option value=""></option>');
		
		for (var i = 0; i < roles_arr.length; i++) {
			var id = roles_arr[i].id;
			var role_name = roles_arr[i].role_name;
			console.log(id);
			console.log(role_name);
			select_options_arr.push('<option value="' + id + '">' + role_name + '</option>');
		}
  
		$('#cbo_create_role').html(select_options_arr);
		$('#cbo_edit_role').html(select_options_arr);
  
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
		
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














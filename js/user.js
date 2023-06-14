 
$(document).ready(function () {
    
	//listen for enter key event in document.
	document.addEventListener("keypress", documententerkeyglobalhandler, false);
  
    $('#btn_logout').on('click', function(){
        logout_ajax();
    });
	   
	populate_display_vectors();
	 
    $('#btncreate_user_view').on('click', function(){
        $('#create_user_modal').modal('show'); 
		$("#txt_create_email").val(""); 
		$("#txt_create_username").val(""); 
		$("#txt_create_password").val(""); 
		$("#txt_create_secretword").val(""); 
    });
	  
	$('#create_user_modal').on('shown.bs.modal', function () {
		$('#txt_create_email').focus();
	})  
	 
    $('#btncreate_user').on('click', function(){
        create_user();
    });
	    
    $('#btnupdate_user').on('click', function(){
        update_user();
    });
	    
	resize_components();

	$(window).on('resize', function(){
		resize_components();         
	});

	$(window).on('load', function(){
		resize_components();
	});
	     
    $('#txt_search_email').on('input', function(){
        search_users(1);
    });
	
    $('#txt_search_username').on('input', function(){
        search_users(1);
    });
	 
    $('#cbo_search_records_to_display').on('change', function(){
        search_users(1);
    });
	
    $('.btn_edit').on('click', function(){
		var id = $(this).attr('data-id');  
        edit_user(id);
    });
	  
    $('.btn_delete').on('click', function(){
		var id = $(this).attr('data-id');
        delete_user(id);
    });
		
    $('#btndashboard').on('click', function(){
        window.location.href = global_path + 'admin.php';
    });
	  
    $('#btnlist_extensions').on('click', function(){
        window.location.href = global_path + 'extensions.php';
    });
	  
    $('#btnlist_users').on('click', function(){
        window.location.href = global_path + 'users.php';
    });
	  
    $('#btnlist_departments').on('click', function(){
        window.location.href = global_path + 'departments.php';
    });
	  
    $('#btnlist_campuses').on('click', function(){
        window.location.href = global_path + 'campuses.php';
    });
	
    $('#img_logo').on('click', function(){
        window.location.href = global_path + 'admin.php';
    });
	  
	search_users(1);
	
    $('#btnclose_create_user_modal').on('click', function(){
        clear_logs();
    });
	   
    $('#btnclose_edit_user_modal').on('click', function(){
        clear_logs();
		search_users(1);		
    });
 
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

	$('#create_user_modal').css('margin-top', function() {
		return $('#div_navigation').height();
	});
 
	$('#edit_user_modal').css('margin-top', function() {
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
			case "users.php":
				//create_user();
			break;
			default: 
			break;
		}

		
	}	
}
 
function create_user(){
	
	show_progress();
	clear_logs();
	
	var email = $('#txt_create_email').val().trim();
	var username = $("#txt_create_username").val().trim();
	var pass_word = $('#txt_create_password').val().trim();
	var secretword = $("#txt_create_secretword").val().trim(); 

	var isvalid = true;
	
	if(email.length == 0)
	{
		log_error_messages("Email cannot be null."); 
		isvalid = false;
	} 
	if(email.length != 0)
	{
		var is_email_valid = validate_email(email);
		if(!is_email_valid)
		{
			log_error_messages("Please provide a valid email address."); 
			isvalid = false;
		} 
	} 
	if(username.length == 0)
	{ 
		log_error_messages("User Name cannot be null."); 		
		isvalid = false;
	}
	if(pass_word.length == 0)
	{
		log_error_messages("Password cannot be null."); 
		isvalid = false;
	} 
	if(secretword.length == 0)
	{ 
		log_error_messages("Secret Word cannot be null."); 		
		isvalid = false;
	}
	 	
	
	if(isvalid == false)
	{	
		hide_progress();
		return;
	}
	
	// send data to server asynchronously.
	$.ajax({
		url: "user_controller.php",
		type: "POST",
		data: {
			"email": email,
			"username": username,
			"password": pass_word, 
			"secretword": secretword, 
			"action": "create_user"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 

		log_info_messages(response);  

		search_users(1);
		
		$('#create_user_modal').modal('hide'); 
		
		clear_logs();
		
		show_info_toast("User created successfully.");
		
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
	
}
 
function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
}

function validate_email(email) {
	var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,6})+$/;
	if(!regex.test(email)) {
	   return false;
	}else{
	   return true;
	}
}
	
function edit_user(id){
	 
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
		url: "user_controller.php",
		type: "POST",
		data: {
			"id": id,
			"action": "get_user"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 
		 
		var data = JSON.parse(response);
			 
		var id = data.id;
		var email = data.email.trim();
		var username = data.username.trim();
		var pass_word = data.password.trim(); 
		var secretword = data.secretWord.trim(); 

		$('#txt_edit_id').val(id);  
		$("#txt_edit_email").val(email);
		$("#txt_edit_username").val(username);
		$("#txt_edit_password").val(pass_word);
		$("#txt_edit_secretword").val(secretword);
		 
		$('#div_edit_user_container').css({'display' : 'block'});
	 		
		$('#user_container').css({'display' : 'none'});
	 		 
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
	
}

function update_user(){
	
	show_progress();
	clear_logs();  
	
	var id = $('#txt_edit_id').val();
	var email = $('#txt_edit_email').val().trim();
	var username = $("#txt_edit_username").val().trim();  
	var pass_word = $('#txt_edit_password').val().trim();
	var secretword = $("#txt_edit_secretword").val().trim();  

	var isvalid = true;
	
	if(id.length == 0)
	{
		log_error_messages("Error retieving primary key."); 
		isvalid = false;
	} 
	if(email.length == 0)
	{
		log_error_messages("Email cannot be null."); 
		isvalid = false;
	} 
	if(email.length != 0)
	{
		var is_email_valid = validate_email(email);
		if(!is_email_valid)
		{
			log_error_messages("Please provide a valid email address."); 
			isvalid = false;
		} 
	} 
	if(username.length == 0)
	{ 
		log_error_messages("User Name cannot be null."); 		
		isvalid = false;
	}
	if(pass_word.length == 0)
	{
		log_error_messages("Password cannot be null."); 
		isvalid = false;
	} 
	if(secretword.length == 0)
	{ 
		log_error_messages("Secret Word cannot be null."); 		
		isvalid = false;
	}	
	 	
	if(isvalid == false)
	{	
		hide_progress();
		return;
	}
	
	// send data to server asynchronously.
	$.ajax({
		url: "user_controller.php",
		type: "POST",
		data: {
			"id": id,
			"email": email,
			"username": username,
			"password": pass_word, 
			"secretword": secretword, 
			"action": "update_user"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 

		log_info_messages(response);  

		search_users(1);
		
		clear_logs();
		
		show_info_toast("User updated successfully.");
		
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
	
}

function delete_user(id){
	 
	show_progress();
			
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

		  '<div class="modal-body">' +
			'<p class="form-control">' + question + '</p>' +
		  '</div>' +

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
		url: "user_controller.php",
		type: "POST",
		data: {
			"id": id,
			"action": "delete_user"
		},//data to be posted
		}).done(function(response){
			response = response.trim();

			console.log("response: " + response); 
 
			log_info_messages(response); 
			
			search_users(1);
			
			show_info_toast("User deleted successfully.");
		
			hide_progress();

		}).fail(function(jqXHR, textStatus){
			log_error_messages(textStatus);
			hide_progress();
		});
	}); 

	confirmModal.modal('show');  
	
	hide_progress();
	
}
 
  
function fetch_users(page){
	 
	show_progress();
	
	global_page_number_holder = page;
	
	var records_to_display = 5;
	records_to_display = $("#cbo_search_records_to_display").val();
	
	console.log("records_to_display: " + records_to_display);
	
	console.log("page: " + page);
	
	// send data to server asynchronously.
	$.ajax({
		url: "user_controller.php",
		type: "POST",
		data: {
			"page": page,
			"records_to_display": records_to_display,
			"action": "fetch_users"
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

function search_users(page){
	 
	show_progress();
	
	global_page_number_holder = page;
	
	var records_to_display = 5;
	records_to_display = $("#cbo_search_records_to_display").val();
	
	console.log("records_to_display: " + records_to_display);	
	console.log("page: " + page);
	
	var email = $("#txt_search_email").val();
	var username = $("#txt_search_username").val(); 
	
	console.log("email: " + email);	
	console.log("username: " + username); 
	
	show_progress();
	
	// send data to server asynchronously.
	$.ajax({
		url: "user_controller.php",
		type: "POST",
		data: {
			"page": page,
			"records_to_display": records_to_display,
			"email": email,
			"username": username, 
			"action": "search_users"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 
				   
		$('#user_container').css({'display' : 'block'});
	 
		$('#div_edit_user_container').css({'display' : 'none'});
	 		 
		$('#div_content').html(response);
		
		get_users_search_count();
		
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
	
}

function populate_display_vectors()
{
	var select_options_arr = "";
	select_options_arr += '<option value="-1">All</option>';
	select_options_arr += '<option value="5">5</option>';
	select_options_arr += '<option value="10">10</option>'; 
	
	$('#cbo_search_records_to_display').html(select_options_arr);	
	$('#cbo_search_records_to_display').html(select_options_arr);	 

}

function get_users_search_count(){
	 
	show_progress();
	  
	// send data to server asynchronously.
	$.ajax({
		url: "user_controller.php",
		type: "POST",
		data: { 
			"action": "get_users_search_count"
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
 














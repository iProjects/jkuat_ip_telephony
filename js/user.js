 
$(document).ready(function () {
    
	//listen for enter key event in document.
	document.addEventListener("keypress", documententerkeyglobalhandler, false);
  
    $('#btn_logout').on('click', function(){
        logout_ajax();
    });
	   
	populate_display_vectors();
	 
    $('#btncreate_user_view').on('click', function(){
		clear_logs();
        $('#create_user_modal').modal('show'); 
		$("#txt_create_email").val(""); 
		$("#txt_create_full_names").val(""); 
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
	
    $('#txt_search_full_names').on('input', function(){
        search_users(1);
    });
	 
    $('#cbo_search_records_to_display').on('change', function(){
        search_users(1);
    });
	
    $('.btn_edit').on('click', function(){
		clear_logs();
		var id = $(this).attr('data-id');  
        edit_user(id);
    });
	  
    $('.btn_delete').on('click', function(){
		clear_logs();
		var id = $(this).attr('data-id');
        delete_user(id);
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
	
	search_users(1);
	
    $('#btnclose_create_user_modal').on('click', function(){
        clear_logs();
    });
	   
    $('#btnclose_edit_user_modal').on('click', function(){
        clear_logs();
		search_users(1);		
    });
 
	$('.hamburger_lines').css('left', function() {
		return ($('.sidebar').width() - 55) + "px";
	});
		
	var select_options_arr = "";
	select_options_arr += '<option value="active">active</option>';
	select_options_arr += '<option value="inactive">inactive</option>'; 
	
	$('#cbo_create_status').html(select_options_arr);	
	$('#cbo_edit_status').html(select_options_arr);	

    $('#txt_create_password').on('input', function(){
     	var pass_word = $('#txt_create_password').val().trim();

		document.querySelector("#txt_create_password_error").innerHTML = "";

		if(pass_word.length > 0)
		{
			var uppercase = new RegExp('[A-Z]');
			var lowercase = new RegExp('[a-z]');
			var numbers = new RegExp('[0-9]');
			var symbols = new RegExp('[-+_!@#$%^&*.,?]');

			if(!pass_word.match(uppercase))
			{
				document.querySelector("#txt_create_password_error").innerHTML = "Password must have an upper case.";
				document.querySelector("#txt_create_password_error").style.display = "block";	 
			}
			if(!pass_word.match(lowercase))
			{
				document.querySelector("#txt_create_password_error").innerHTML += "<br />Password must have a lower case.";
				document.querySelector("#txt_create_password_error").style.display = "block";	 
			}
			if(!pass_word.match(numbers))
			{
				document.querySelector("#txt_create_password_error").innerHTML += "<br />Password must have a number.";
				document.querySelector("#txt_create_password_error").style.display = "block";	 
			}
			if(!pass_word.match(symbols))
			{
				document.querySelector("#txt_create_password_error").innerHTML += "<br />Password must have a symbol.";
				document.querySelector("#txt_create_password_error").style.display = "block";	 
			}
			if(pass_word.length < 8)
			{
				document.querySelector("#txt_create_password_error").innerHTML += "<br />Password must have atleast 8 characters.";
				document.querySelector("#txt_create_password_error").style.display = "block";	 
			}
		} 

    });
	
    $('#txt_edit_password').on('input', function(){
     	var pass_word = $('#txt_edit_password').val().trim();

		document.querySelector("#txt_edit_password_error").innerHTML = "";

		if(pass_word.length > 0)
		{
			var uppercase = new RegExp('[A-Z]');
			var lowercase = new RegExp('[a-z]');
			var numbers = new RegExp('[0-9]');
			var symbols = new RegExp('[-+_!@#$%^&*.,?]');

			if(!pass_word.match(uppercase))
			{
				document.querySelector("#txt_edit_password_error").innerHTML = "Password must have an upper case.";
				document.querySelector("#txt_edit_password_error").style.display = "block";	 
			}
			if(!pass_word.match(lowercase))
			{
				document.querySelector("#txt_edit_password_error").innerHTML += "<br />Password must have a lower case.";
				document.querySelector("#txt_edit_password_error").style.display = "block";	 
			}
			if(!pass_word.match(numbers))
			{
				document.querySelector("#txt_edit_password_error").innerHTML += "<br />Password must have a number.";
				document.querySelector("#txt_edit_password_error").style.display = "block";	 
			}
			if(!pass_word.match(symbols))
			{
				document.querySelector("#txt_edit_password_error").innerHTML += "<br />Password must have a symbol.";
				document.querySelector("#txt_edit_password_error").style.display = "block";	 
			}
			if(pass_word.length < 8)
			{
				document.querySelector("#txt_edit_password_error").innerHTML += "<br />Password must have atleast 8 characters.";
				document.querySelector("#txt_edit_password_error").style.display = "block";	 
			}
		} 

    });
	
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
	document.querySelector("#txt_create_email_error").innerHTML = "";
	document.querySelector("#txt_create_full_names_error").innerHTML = "";
	document.querySelector("#txt_create_password_error").innerHTML = "";
	document.querySelector("#txt_create_secretword_error").innerHTML = "";
	
	var email = $('#txt_create_email').val().trim();
	var full_names = $("#txt_create_full_names").val().trim();
	var pass_word = $('#txt_create_password').val().trim();
	var secret_word = $("#txt_create_secretword").val().trim(); 
	var status = $("#cbo_create_status").val();
	var addedby = readCookie("loggedinuser"); 

	var isvalid = true;
	
	if(email.length == 0)
	{
		//log_error_messages("Email cannot be null."); 
		document.querySelector("#txt_create_email_error").innerHTML = "Email cannot be null.";
  		document.querySelector("#txt_create_email_error").style.display = "block";	
		isvalid = false;
	} 
	if(email.length != 0)
	{
		var is_email_valid = validate_email(email);
		if(!is_email_valid)
		{
			//log_error_messages("Please provide a valid email address."); 
			document.querySelector("#txt_create_email_error").innerHTML = "Please provide a valid email address.";
  			document.querySelector("#txt_create_email_error").style.display = "block";	
			isvalid = false;
		} 
	} 
	if(full_names.length == 0)
	{ 
		//log_error_messages("User Name cannot be null."); 		
		document.querySelector("#txt_create_full_names_error").innerHTML = "User Name cannot be null.";
  		document.querySelector("#txt_create_full_names_error").style.display = "block";	
		isvalid = false;
	}
	if(pass_word.length == 0)
	{
		//log_error_messages("Password cannot be null."); 
		document.querySelector("#txt_create_password_error").innerHTML = "Password cannot be null.";
  		document.querySelector("#txt_create_password_error").style.display = "block";	
		isvalid = false;
	} 
	if(pass_word.length > 0)
	{
		var uppercase = new RegExp('[A-Z]');
		var lowercase = new RegExp('[a-z]');
		var numbers = new RegExp('[0-9]');
		var symbols = new RegExp('[-+_!@#$%^&*.,?]');

		if(!pass_word.match(uppercase))
		{
			document.querySelector("#txt_create_password_error").innerHTML = "Password must have an upper case.";
	  		document.querySelector("#txt_create_password_error").style.display = "block";	
			isvalid = false;
		}
		if(!pass_word.match(lowercase))
		{
			document.querySelector("#txt_create_password_error").innerHTML += "<br />Password must have a lower case.";
	  		document.querySelector("#txt_create_password_error").style.display = "block";	
			isvalid = false;
		}
		if(!pass_word.match(numbers))
		{
			document.querySelector("#txt_create_password_error").innerHTML += "<br />Password must have a number.";
	  		document.querySelector("#txt_create_password_error").style.display = "block";	
			isvalid = false;
		}
		if(!pass_word.match(symbols))
		{
			document.querySelector("#txt_create_password_error").innerHTML += "<br />Password must have a symbol.";
	  		document.querySelector("#txt_create_password_error").style.display = "block";	
			isvalid = false;
		}
		if(pass_word.length < 8)
		{
			document.querySelector("#txt_create_password_error").innerHTML += "<br />Password must have atleast 8 characters.";
	  		document.querySelector("#txt_create_password_error").style.display = "block";	
			isvalid = false;
		}
	} 
	if(secret_word.length == 0)
	{ 
		//log_error_messages("Secret Word cannot be null."); 		
		document.querySelector("#txt_create_secretword_error").innerHTML = "Secret Word cannot be null.";
  		document.querySelector("#txt_create_secretword_error").style.display = "block";	
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
			"full_names": full_names,
			"pass_word": pass_word, 
			"secret_word": secret_word, 
			"status": status, 
			"addedby": addedby, 
			"action": "create_user"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 

		log_info_messages(response);  

		search_users(1);
		
		$('#create_user_modal').modal('hide'); 
		
		clear_logs();
		
		show_info_toast(response);
		
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

function validate_password()
{
	//regex to check if a string contains uppercase, lowercase, special character and numeric value
	var pattern = new RegExp("^(?=.*[a-z)(?=.*[A-Z)(?=.*\\d)(?=.*[-+_!@#$%^&*.,?]).+$");
	var uppercase = new RegExp('A-Z');
	var lowercase = new RegExp('a-z');
	var numbers = new RegExp('[0-9]');

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
		var email = data.email;
		var full_names = data.full_names;
		var pass_word = data.pass_word; 
		var secret_word = data.secret_word; 
		var status = data.status;
 
		$('#edit_user_modal').modal('show'); 

		$('#edit_user_modal').on('shown.bs.modal', function () {
			$('#txt_edit_full_names').focus();
			$('#txt_edit_id').val(id);  
			$("#txt_edit_email").val(email);
			$("#txt_edit_full_names").val(full_names);
			$("#txt_edit_password").val(pass_word);
			$("#txt_edit_secretword").val(secret_word);
			$('#cbo_edit_status').val(status); 
		})  

		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
	
}

function update_user(){
	
	show_progress();
	clear_logs();  
	document.querySelector("#txt_edit_email_error").innerHTML = "";
	document.querySelector("#txt_edit_full_names_error").innerHTML = "";
	document.querySelector("#txt_edit_password_error").innerHTML = "";
	document.querySelector("#txt_edit_secretword_error").innerHTML = "";
	
	var id = $('#txt_edit_id').val();
	var email = $('#txt_edit_email').val().trim();
	var full_names = $("#txt_edit_full_names").val().trim();  
	var pass_word = $('#txt_edit_password').val().trim();
	var secret_word = $("#txt_edit_secretword").val().trim();   
	var status = $("#cbo_edit_status").val();

	var isvalid = true;
	
	if(id.length == 0)
	{
		log_error_messages("Error retieving primary key."); 
		isvalid = false;
	} 
	if(email.length == 0)
	{
		//log_error_messages("Email cannot be null."); 
		document.querySelector("#txt_edit_email_error").innerHTML = "Email cannot be null.";
  		document.querySelector("#txt_edit_email_error").style.display = "block";	
		isvalid = false;
	} 
	if(email.length != 0)
	{
		var is_email_valid = validate_email(email);
		if(!is_email_valid)
		{
			//log_error_messages("Please provide a valid email address."); 
			document.querySelector("#txt_edit_email_error").innerHTML = "Please provide a valid email address.";
  			document.querySelector("#txt_edit_email_error").style.display = "block";	
			isvalid = false;
		} 
	} 
	if(full_names.length == 0)
	{ 
		//log_error_messages("User Name cannot be null."); 		
		document.querySelector("#txt_edit_full_names_error").innerHTML = "User Name cannot be null.";
  		document.querySelector("#txt_edit_full_names_error").style.display = "block";	
		isvalid = false;
	}
	if(pass_word.length == 0)
	{
		//log_error_messages("Password cannot be null."); 
		document.querySelector("#txt_edit_password_error").innerHTML = "Password cannot be null.";
  		document.querySelector("#txt_edit_password_error").style.display = "block";	
		isvalid = false;
	} 
	if(pass_word.length > 0)
	{
		var uppercase = new RegExp('[A-Z]');
		var lowercase = new RegExp('[a-z]');
		var numbers = new RegExp('[0-9]');
		var symbols = new RegExp('[-+_!@#$%^&*.,?]');

		if(!pass_word.match(uppercase))
		{
			document.querySelector("#txt_edit_password_error").innerHTML = "Password must have an upper case.";
	  		document.querySelector("#txt_edit_password_error").style.display = "block";	
			isvalid = false;
		}
		if(!pass_word.match(lowercase))
		{
			document.querySelector("#txt_edit_password_error").innerHTML += "<br />Password must have a lower case.";
	  		document.querySelector("#txt_edit_password_error").style.display = "block";	
			isvalid = false;
		}
		if(!pass_word.match(numbers))
		{
			document.querySelector("#txt_edit_password_error").innerHTML += "<br />Password must have a number.";
	  		document.querySelector("#txt_edit_password_error").style.display = "block";	
			isvalid = false;
		}
		if(!pass_word.match(symbols))
		{
			document.querySelector("#txt_edit_password_error").innerHTML += "<br />Password must have a symbol.";
	  		document.querySelector("#txt_edit_password_error").style.display = "block";	
			isvalid = false;
		}
		if(pass_word.length < 8)
		{
			document.querySelector("#txt_edit_password_error").innerHTML += "<br />Password must have atleast 8 characters.";
	  		document.querySelector("#txt_edit_password_error").style.display = "block";	
			isvalid = false;
		}
	} 
	if(secret_word.length == 0)
	{ 
		//log_error_messages("Secret Word cannot be null."); 		
		document.querySelector("#txt_edit_secretword_error").innerHTML = "Secret Word cannot be null.";
  		document.querySelector("#txt_edit_secretword_error").style.display = "block";	
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
			"full_names": full_names,
			"pass_word": pass_word, 
			"secret_word": secret_word, 
			"status": status, 
			"action": "update_user"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 

		log_info_messages(response);  

		$('#edit_user_modal').modal('hide'); 

		search_users(1);
		
		clear_logs();
		
		show_info_toast(response);
		
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
	
}

function delete_user(id){
	 
	show_progress();
	
	var delete_prompt = get_delete_user_prompt(id);
	
	hide_progress();
	
}
 
function get_delete_user_prompt(id){
	  
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
		var email = data.email;
		var full_names = data.full_names;
		var pass_word = data.pass_word; 
		var secret_word = data.secret_word; 
		
		var delete_prompt = "Are you sure you wish to delete User with Email [ " + email + " ] for [ " + full_names + " ].";
		
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
	
	close_toast();
	
	global_page_number_holder = page;
	
	var records_to_display = 10; 
	
	console.log("records_to_display: " + records_to_display);	
	console.log("page: " + page);
	
	var email = $("#txt_search_email").val();
	var full_names = $("#txt_search_full_names").val(); 
	
	console.log("email: " + email);	
	console.log("full_names: " + full_names); 
	
	show_progress();
	
	// send data to server asynchronously.
	$.ajax({
		url: "user_controller.php",
		type: "POST",
		data: {
			"page": page,
			"records_to_display": records_to_display,
			"email": email,
			"full_names": full_names, 
			"action": "search_users"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 
				   
		$('#user_container').css({'display' : 'block'});
	 
		$('#div_edit_user_container').css({'display' : 'none'});
	 		 
		$('#div_content').html(response);
		
		get_users_search_count();
		
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














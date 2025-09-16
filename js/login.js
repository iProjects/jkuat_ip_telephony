 
$(document).ready(function () {
   
	$('#login_modal').modal({
			backdrop: 'static', 
			keyboard: false
		},'show');
	 
	//listen for enter key event in document.
	document.addEventListener("keypress", documententerkeyglobalhandler, false);
 
    $('#btn_login').on('click', function(){
        login_ajax();
    });
	   
	resize_components();

	$(window).on('resize', function(){
		resize_components();         
	});

	$(window).on('load', function(){
		resize_components();
	});
	 
    $('#btnlogin').on('click', function(){
        window.location.href = global_path + 'login.php';
    });
	  
    $('#btnforgot_password').on('click', function(){
        window.location.href = global_path + 'forgot_password.php';
    });
	  
    $('#btnsearch').on('click', function(){
        window.location.href = global_path + 'index.php';
    });
	
	$("#txtemail").val("");
	$("#txtpassword").val("");
	$("#txtemail").focus();
	
	wire_events();

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

	$('#create_extension_modal').css('margin-top', function() {
		return $('#div_navigation').height();
	});
 
	$('#edit_extension_modal').css('margin-top', function() {
		return $('#div_navigation').height();
	});
 
	$('#div_messages').css('margin-bottom', function() {
		return $('#div_footer').height();
	});
  
	$('#div_content_container').css('margin-bottom', function() {
		return $('#div_footer').height();
	});
 
}
  
function login_ajax(){
	 
	show_progress();
	clear_logs();
	document.querySelector("#txtemail_error").innerHTML = "";
	document.querySelector("#txtpassword_error").innerHTML = "";

	var email = $("#txtemail").val();
	var pass_word = $("#txtpassword").val();

	var isvalid = true;
	if(email.length == 0)
	{
		//log_error_messages("Email cannot be null."); 
		document.querySelector("#txtemail_error").innerHTML = "Email cannot be null.";
  		document.querySelector("#txtemail_error").style.display = "block";		
		isvalid = false;
	} 
	if(email.length != 0)
	{
		var is_email_valid = validate_email(email);
		if(!is_email_valid)
		{
			//log_error_messages("Please provide a valid email address."); 
			document.querySelector("#txtemail_error").innerHTML = "Please provide a valid email address.";
      		document.querySelector("#txtemail_error").style.display = "block";		
			isvalid = false;
		} 
	} 
	if(pass_word.length == 0)
	{ 
		//log_error_messages("Password cannot be null."); 		
		document.querySelector("#txtpassword_error").innerHTML = "Password cannot be null.";
  		document.querySelector("#txtpassword_error").style.display = "block";		
		isvalid = false;
	}

	if(isvalid == false)
	{	
		hide_progress();
		return;
	}
	
	// send data to server asynchronously.
	$.ajax({
		url: "login_controller.php",
		type: "POST",
		data: {
			"email": email,
			"pass_word": pass_word
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 
		
		if(response == "success")
		{ 		
			log_info_messages("login successful Redirecting...");
			window.location.href = global_path + 'admin.php';
		}
		else
		{ 
			log_error_messages(response);
		}	
		
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
			case "login.php":
				login_ajax();
			break; 
			default: 
			break;
		}

		
	}	
}
 











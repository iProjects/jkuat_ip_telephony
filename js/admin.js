 
$(document).ready(function () {
     
	//listen for enter key event in document.
	document.addEventListener("keypress", documententerkeyglobalhandler, false);
  
    $('#btn_logout').on('click', function(){
        logout_ajax();
    });
	
	resize_components();

	$(window).on('resize', function(){
		resize_components();         
	});

	$(window).on('load', function(){
		resize_components();
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
	
	get_campus_count();
	get_departments_count();
	get_extensions_count();
	get_users_count();
	
	var logged_in_user_email = readCookie("logged_in_user_email");
	send_email(logged_in_user_email);
	
	console.log("logged_in_user_email: " + logged_in_user_email);
	
	$('.hamburger_lines').css('left', function() {
		return ($('.sidebar').width() - 40) + "px";
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
			case "login.php":
				login_ajax();
			break;
			case "index.php":
				
			break;
			case "super_admin_index.php":
				create_extension();
			break;
			case "limited_admin_index.php":
				create_extension();
			break;
			default: 
			break;
		}

		
	}	
}
  
function get_campus_count(){
	 
	show_progress();
	 
	// send data to server asynchronously.
	$.ajax({
		url: "admin_controller.php",
		type: "POST",
		data: { 
			"action": "get_campus_count"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 
				
		$('#div_dashboard_card_campus').html(response);
 
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
	
}

function get_departments_count(){
	 
	show_progress();
	 
	// send data to server asynchronously.
	$.ajax({
		url: "admin_controller.php",
		type: "POST",
		data: { 
			"action": "get_departments_count"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 
				
		$('#div_dashboard_card_departments').html(response);
 
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
	
}

function get_extensions_count(){
	 
	show_progress();
	 
	// send data to server asynchronously.
	$.ajax({
		url: "admin_controller.php",
		type: "POST",
		data: { 
			"action": "get_extensions_count"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 
		 
		$('#div_dashboard_card_extensions').html(response);
 
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
	
}

function get_users_count(){
	 
	show_progress();
	 
	// send data to server asynchronously.
	$.ajax({
		url: "admin_controller.php",
		type: "POST",
		data: { 
			"action": "get_users_count"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 
				
		$('#div_dashboard_card_users').html(response);
 
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
	
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
			'width: 60%',
			'left: 30%', 
		].join(';');
			
		$('#dashboard_container').attr('style', content_style);
				
	}else{
		//show the sidebar
		var style = [
			'display: block',
		].join(';');
			
		$('.sidebar').attr('style', style);
		
		
		$('.hamburger_lines').css('left', function() {
			return ($('.sidebar').width() - 40) + "px";
		});
		
		//shrink the contnent
		var content_style = [ 
			'width: 60%',
			'left: 30%', 
		].join(';');
			
		$('#dashboard_container').attr('style', content_style);
		
	}
}
 






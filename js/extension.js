 
$(document).ready(function () {
    
	disable_all_actions();
	
	//listen for enter key event in document.
	document.addEventListener("keypress", documententerkeyglobalhandler, false);
  
    $('#btn_logout').on('click', function(){
        logout_ajax();
    });
	    
	fetch_all_campuses();
	  
    $('#btncreate_extension_view').on('click', function(){		
		clear_logs();
        $('#create_extension_modal').modal('show');
		fetch_campus_codes(); 
		$("#cbo_create_campus").val("");
		$("#txt_create_department").val(""); 
		$("#txt_create_owner_assigned").val("");
		$("#txt_create_extension_number").val(""); 
    });
	
	$('#create_extension_modal').on('shown.bs.modal', function () {
		$('#txt_create_owner_assigned').focus();
	})  
	  
    $('#btncreate_extension').on('click', function(){
        create_extension();
    });
	    
    $('#btnupdate_extension').on('click', function(){
        update_extension();
    });
	    
	resize_components();

	$(window).on('resize', function(){
		resize_components();         
	});

	$(window).on('load', function(){
		resize_components();
	});
	 
    $('#cbo_search_campus').on('change', function(){
        get_departments_given_campus_id("cbo_search_campus");
		search_extensions(1);
    });
	
    $('#cbo_create_campus').on('change', function(){
        get_departments_given_campus_id("cbo_create_campus"); 
    });
	
    $('#cbo_edit_campus').on('change', function(){
        get_departments_given_campus_id("cbo_edit_campus"); 
    });
	
    $('#cbo_search_department').on('change', function(){ 
		search_extensions(1);
    });
	
    $('#txt_other_params').on('input', function(){
        search_extensions(1);
    });
	 
    $('.btn_edit').on('click', function(){
		var id = $(this).attr('data-id');  
		clear_logs();
        edit_extension(id);
    });
	  
    $('.btn_delete').on('click', function(){
		var id = $(this).attr('data-id');
		clear_logs();
        delete_extension(id);
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
	
	search_extensions(1);
	
    $('#btnclose_create_extension_modal').on('click', function(){
        clear_logs();
    });
	   
    $('#btnclose_edit_extension_modal').on('click', function(){
        clear_logs();
		search_extensions(1);		
    });
 
    $('#txt_page').on('input', function(){
        console.log($('#txt_page').val());
    });
	
	$('.hamburger_lines').css('left', function() {
		return ($('.sidebar').width() - 55) + "px";
	});
		
	authorization();
	
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
			case "extensions.php":
				search_extensions(1);
			break; 
			default: 
			break;
		}

		
	}	
}
 
function create_extension(){
	
	show_progress();
	clear_logs();
	document.querySelector("#cbo_create_campus_error").innerHTML = "";
	document.querySelector("#cbo_create_department_error").innerHTML = "";
	document.querySelector("#txt_create_owner_assigned_error").innerHTML = "";
	document.querySelector("#txt_create_extension_number_error").innerHTML = "";


	var campus_id = $('#cbo_create_campus').val();
	var department_id = $("#cbo_create_department").val();
	var owner_assigned = $("#txt_create_owner_assigned").val().trim();
	var extension_number = $("#txt_create_extension_number").val().trim();
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
	if(department_id != null)
	{ 
		if(department_id.length == 0)
		{ 
			//log_error_messages("Select Department."); 		
			document.querySelector("#cbo_create_department_error").innerHTML = "Select Department.";
      		document.querySelector("#cbo_create_department_error").style.display = "block";	
			isvalid = false;
		} 
	}
	if(department_id == null)
	{ 
		//log_error_messages("Select Department."); 		
		document.querySelector("#cbo_create_department_error").innerHTML = "Select Department.";
      	document.querySelector("#cbo_create_department_error").style.display = "block";	
		isvalid = false;
	}
	if(owner_assigned.length == 0)
	{ 
		//log_error_messages("Owner Assigned cannot be null."); 		
		document.querySelector("#txt_create_owner_assigned_error").innerHTML = "Owner Assigned cannot be null.";
      	document.querySelector("#txt_create_owner_assigned_error").style.display = "block";	
		isvalid = false;
	}
	if(extension_number.length == 0)
	{ 
		//log_error_messages("Extension Number cannot be null."); 		
		document.querySelector("#txt_create_extension_number_error").innerHTML = "Extension Number cannot be null.";
      	document.querySelector("#txt_create_extension_number_error").style.display = "block";	
		isvalid = false;
	}
	if(extension_number.length != 0)
	{
		if(!$.isNumeric(extension_number))
		{ 
			//log_error_messages("Extension Number must be digits."); 		
			document.querySelector("#txt_create_extension_number_error").innerHTML = "Extension Number must be digits.";
      		document.querySelector("#txt_create_extension_number_error").style.display = "block";	
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
		url: "extension_controller.php",
		type: "POST",
		data: {
			"campus_id": campus_id,
			"department_id": department_id,
			"owner_assigned": owner_assigned,
			"extension_number": extension_number,
			"addedby": addedby, 
			"action": "create_extension"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 

		log_info_messages(response);  

		search_extensions(1);
		
		$('#create_extension_modal').modal('hide');
		
		clear_logs();
		
		show_info_toast(response);
		
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
	
}

function get_extension_given_number(extension_number){
	 
	show_progress();
	
	console.log("extension_number: " + extension_number); 
	
	var isvalid = true;
	if(extension_number.length == 0)
	{
		log_error_messages("Extension Number cannot be null."); 
		isvalid = false;
	}
 
	if(isvalid == false)
	{	
		hide_progress();
		return;
	}
	 
	// send data to server asynchronously.
	$.ajax({
		url: "extension_controller.php",
		type: "POST",
		data: {
			"extension_number": extension_number,
			"action": "get_extension_given_number"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 
		 
		var ext = JSON.parse(response);
				 
		var id = ext.id;
		var campus_id = ext.campus_id;
		var department_id = ext.department_id;
		var _extension_number = ext.extension_number;
		var owner_assigned = ext.owner_assigned;
 
		if(extension_number == _extension_number)
		{
			return true;
		}
		
		return false;
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
	
}

function edit_extension(id){
	 
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
		url: "extension_controller.php",
		type: "POST",
		data: {
			"id": id,
			"action": "get_extension"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 
		
		fetch_campus_codes();
		fetch_campus_codes("cbo_edit_campus");
		 		
		var data = JSON.parse(response);
				 
		var id = data.id;
		var campus_id = data.campus_id;
		var department_id = data.department_id;
		var extension_number = data.extension_number;
		var owner_assigned = data.owner_assigned;

	  
		$('#txt_edit_id').val(id); 
		$('#cbo_edit_campus').val(campus_id); 
		$("#cbo_edit_department").val(department_id);
		$("#txt_edit_extension_number").val(extension_number);
		$("#txt_edit_owner_assigned").val(owner_assigned);
		
		$('#div_edit_extension_container').css({'display' : 'block'});
	 		
		$('#extensions_container').css({'display' : 'none'});
 
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
	
}

function update_extension(){
	
	show_progress();
	clear_logs();  
	document.querySelector("#cbo_edit_campus_error").innerHTML = "";
	document.querySelector("#cbo_edit_department_error").innerHTML = "";
	document.querySelector("#txt_edit_owner_assigned_error").innerHTML = "";
	document.querySelector("#txt_edit_extension_number_error").innerHTML = "";

	var id = $('#txt_edit_id').val();
	var campus_id = $('#cbo_edit_campus').val();
	var department_id = $("#cbo_edit_department").val();
	var owner_assigned = $("#txt_edit_owner_assigned").val().trim();
	var extension_number = $("#txt_edit_extension_number").val().trim();

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
	if(department_id != null)
	{ 
		if(department_id.length == 0)
		{ 
			//log_error_messages("Select Department."); 		
			document.querySelector("#cbo_edit_department_error").innerHTML = "Select Department.";
      		document.querySelector("#cbo_edit_department_error").style.display = "block";	
			isvalid = false;
		} 
	}
	if(department_id == null)
	{ 
		//log_error_messages("Select Department."); 		
		document.querySelector("#cbo_edit_department_error").innerHTML = "Select Department.";
      	document.querySelector("#cbo_edit_department_error").style.display = "block";	
		isvalid = false;
	}
	if(owner_assigned.length == 0)
	{ 
		//log_error_messages("Owner Assigned cannot be null."); 		
		document.querySelector("#txt_edit_owner_assigned_error").innerHTML = "Owner Assigned cannot be null.";
      	document.querySelector("#txt_edit_owner_assigned_error").style.display = "block";	
		isvalid = false;
	}
	if(extension_number.length == 0)
	{ 
		//log_error_messages("Extension Number cannot be null."); 		
		document.querySelector("#txt_edit_extension_number_error").innerHTML = "Extension Number cannot be null.";
      	document.querySelector("#txt_edit_extension_number_error").style.display = "block";	
		isvalid = false;
	}
	if(extension_number.length != 0)
	{
		if(!$.isNumeric(extension_number))
		{ 
			//log_error_messages("Extension Number must be digits."); 		
			document.querySelector("#txt_edit_extension_number_error").innerHTML = "Extension Number must be digits.";
      		document.querySelector("#txt_edit_extension_number_error").style.display = "block";	
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
		url: "extension_controller.php",
		type: "POST",
		data: {
			"id": id,
			"campus_id": campus_id,
			"department_id": department_id,
			"extension_number": extension_number,
			"owner_assigned": owner_assigned,
			"action": "update_extension"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 

		log_info_messages(response);  

		search_extensions(1);
		
		clear_logs();
		
		show_info_toast(response);
		
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
	
}

function delete_extension(id){
	 
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
		url: "extension_controller.php",
		type: "POST",
		data: {
			"id": id,
			"action": "get_extension"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 
		 
		var data = JSON.parse(response);
				 
		var id = data.id;
		var campus_id = data.campus_id;
		var department_id = data.department_id;
		var extension_number = data.extension_number;
		var owner_assigned = data.owner_assigned;
		
		var delete_prompt = "Are you sure you wish to delete Extension No [ " + extension_number + " ] for [ " + owner_assigned + " ].";
		
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
			url: "extension_controller.php",
			type: "POST",
			data: {
				"id": id,
				"action": "delete_extension"
			},//data to be posted
			}).done(function(response){
				response = response.trim();

				console.log("response: " + response); 
	 
				log_info_messages(response); 
				
				search_extensions(1);
				
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

function fetch_campus_codes() {
	
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
 
		console.log("select_options_arr: " + select_options_arr); 
		
		$('#cbo_search_campus').html(select_options_arr);		 
		$('#cbo_edit_campus').html(select_options_arr);
		 
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
 
		$('#cbo_search_campus').html(select_options_arr);
		$('#cbo_create_campus').html(select_options_arr);
		$('#cbo_edit_campus').html(select_options_arr);
 
		get_departments_given_campus_id("cbo_search_campus");
		get_departments_given_campus_id("cbo_create_campus");
		get_departments_given_campus_id("cbo_edit_campus");
		
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
		
}

function get_departments_given_campus_id(campus_name) {
	
	show_progress();
	
	var campus_id = "";
	
	switch(campus_name)
	{
		case "cbo_search_campus":
			 campus_id = $("#cbo_search_campus").val();
			 $('#cbo_search_department').html("");
			 if(campus_id.length == 0)
			 {
				$('#cbo_search_department').html("");
				search_extensions(1);
			 }
		break;
		case "cbo_create_campus":
			 campus_id = $("#cbo_create_campus").val();
			 $('#cbo_create_department').html("");	
			 if(campus_id.length == 0)
			 {
				$('#cbo_create_department').html("");				 
			 }
		break;
		case "cbo_edit_campus":
			 campus_id = $("#cbo_edit_campus").val();
			 $('#cbo_edit_department').html(""); 
			 if(campus_id.length == 0)
			 {
				$('#cbo_edit_department').html(""); 				 
			 }
		break;
	}
	
	console.log("campus_id: " + campus_id); 
	
	if(campus_id == undefined)
	{			 
		return;	
	}
	
	// send data to server asynchronously.
	$.ajax({
		url: "extension_controller.php",
		type: "POST",
		data: {
			"campus_id": campus_id,
			"action": "get_departments_given_campus_id"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		 
		console.log("response: " + response); 
		
		var names_arr = JSON.parse(response);
		
		console.log("names_arr: " + names_arr); 
			
		var select_options_arr = [];
		
		select_options_arr.push('<option value=""></option>');
		
		for(var i = 0; i < names_arr.length; i++) {
			var id = names_arr[i].id;
			var department_name = names_arr[i].department_name.trim();
			console.log(id);
			console.log(department_name);
			
			select_options_arr.push('<option value="' + id + '">' + department_name + '</option>');
		}
 		
 		switch(campus_name)
		{
			case "cbo_search_campus":
				 $('#cbo_search_department').html(select_options_arr);
			break;
			case "cbo_create_campus":
				 $('#cbo_create_department').html(select_options_arr);
			break;
			case "cbo_edit_campus":
				 $('#cbo_edit_department').html(select_options_arr);
			break;
		}

		//search_extensions(1);
		
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
		
}

function fetch_extensions(page){
	 
	show_progress();
	
	global_page_number_holder = page;
	
	var records_to_display = 5;
	records_to_display = $("#cbo_search_records_to_display").val();
	
	console.log("records_to_display: " + records_to_display);
	
	console.log("page: " + page);
	
	// send data to server asynchronously.
	$.ajax({
		url: "extension_controller.php",
		type: "POST",
		data: {
			"page": page,
			"records_to_display": records_to_display,
			"action": "fetch_extensions"
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

function search_extensions(page){
	
	show_progress();
	
	close_toast();
	
	global_page_number_holder = page;
	
	var records_to_display = 10; 
	
	console.log("records_to_display: " + records_to_display);	
	console.log("page: " + page);
	
	var campus_id = $("#cbo_search_campus").val();
	var department_id = $("#cbo_search_department").val();
	var other_params = $("#txt_other_params").val(); 
	
	console.log("campus_id: " + campus_id);	
	console.log("department_id: " + department_id);	
	console.log("other_params: " + other_params); 
	
	show_progress();
	
	// send data to server asynchronously.
	$.ajax({
		url: "extension_controller.php",
		type: "POST",
		data: {
			"page": page,
			"records_to_display": records_to_display,
			"campus_id": campus_id,
			"department_id": department_id,
			"other_params": other_params, 
			"action": "search_extensions"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 
				  
		$('#extensions_container').css({'display' : 'block'});
	 
		$('#div_edit_extension_container').css({'display' : 'none'});
	 		 
		$('#div_content').html(response);
		
		get_extensions_search_count();
		
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
	
}
 
function get_extensions_search_count(){
	 
	show_progress();
	  
	// send data to server asynchronously.
	$.ajax({
		url: "extension_controller.php",
		type: "POST",
		data: { 
			"action": "get_extensions_search_count"
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
		search_extensions(current_page);
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
				 
			var rights_arr = jQuery.parseJSON(rights_obj);
 
			console.log("rights_arr: " + rights_arr); 
				 
			for (var i = 0; i < rights_arr.length; i++) {
				var right_code = rights_arr[i].right_code; 
				console.log(right_code); 

				var dom_element_from_id = $('"#"' + right_code + '""')[0]; 
				var dom_element_from_class = $('"."' + right_code + '""')[0]; 
				
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

				var dom_element_from_id = $("#" + right_code + "")[0]; 
				var dom_element_from_class = $("." + right_code + "")[0]; 
				
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





























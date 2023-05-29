 
$(document).ready(function () {
   
	$('#login_modal').modal({
			backdrop: 'static', 
			keyboard: false
		},'show');
	 
	//listen for enter key event in document.
	document.addEventListener("keypress", documententerkeyglobalhandler, false);
 
    $('#btnlogin').on('click', function(){
        login_ajax();
    });
	 
    $('#btn_login').on('click', function(){        
		window.location.href = 'http://localhost:90/jkuat_ip_telephony/login.php';		 
    });

    $('#btnhome').on('click', function(){        
		window.location.href = 'http://localhost:90/jkuat_ip_telephony';		 
    });

    $('#btn_logout').on('click', function(){
        logout_ajax();
    });
	  
    $('#btnlist_extensions').on('click', function(){
        fetch_extensions(1);
    });

	populate_display_vectors();
	
	fetch_all_campuses();
	
	//search_extensions(1);
	
    $('#btncreate_extension_view').on('click', function(){
        $('#create_extension_modal').modal('show');
		fetch_campus_codes();
    });
	  
    $('#btncreate_user_view').on('click', function(){
        $('#create_user_modal').modal('show');
		fetch_campus_codes();
    });
	  
    $('#btncreate_campus_view').on('click', function(){
        $('#create_campus_modal').modal('show');
		fetch_campus_codes();
    });
	  
    $('#btncreate_department_view').on('click', function(){
        $('#create_department_modal').modal('show');
		fetch_campus_codes();
    });
	  
    $('#btncreate_extension').on('click', function(){
        create_extension();
    });
	    
	resize_components();

	$(window).on('resize', function(){
		resize_components();         
	});

	$(window).on('load', function(){
		resize_components();
	});
	
    $('#cbo_records_to_display').on('change', function(){
        fetch_extensions(1);
    });
	
    $('#cbo_search_campus').on('change', function(){
        fetch_department_names("cbo_search_campus");
		search_extensions(1);
    });
	
    $('#cbo_create_campus').on('change', function(){
        fetch_department_names("cbo_create_campus"); 
    });
	
    $('#cbo_edit_campus').on('change', function(){
        fetch_department_names("cbo_edit_campus"); 
    });
	
    $('#cbo_search_department').on('change', function(){ 
		search_extensions(1);
    });
	
    $('#txt_search_extension_number').on('input', function(){
        search_extensions(1);
    });
	
    $('#cbo_search_records_to_display').on('change', function(){
        search_extensions(1);
    });
	
    $('.btn_edit').on('click', function(){
		var id = $(this).attr('data-id');  
        edit_extension(id);
    });
	  
    $('.btn_delete').on('click', function(){
		var id = $(this).attr('data-id');
        delete_extension(id);
    });
		
    $('#btnlist_extensions').on('click', function(){
        window.location.href = 'http://localhost:90/jkuat_ip_telephony/extensions.php'
    });
	  
    $('#btnlist_users').on('click', function(){
        window.location.href = 'http://localhost:90/jkuat_ip_telephony/users.php'
    });
	  
    $('#btnlist_departments').on('click', function(){
        window.location.href = 'http://localhost:90/jkuat_ip_telephony/departments.php'
    });
	  
    $('#btnlist_campuses').on('click', function(){
        window.location.href = 'http://localhost:90/jkuat_ip_telephony/campuses.php'
    });
	
	fetch_extensions(1);
	  
	$("#progress_bar").hide();
	
    log_info_messages("finished load...");
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
	
	var email = $("#txtuser_name").val();
	var pwd = $("#txtuser_password").val();

	var isvalid = true;
	if(email.length == 0)
	{
		log_error_messages("email cannot be null."); 
		isvalid = false;
	}
	if(pwd.length == 0)
	{ 
		log_error_messages("password cannot be null."); 		
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
			"user_name": email,
			"user_password": pwd
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 
		
		if(response == "successfull")
		{
			log_info_messages("login successful Redirecting...");
			window.location.href = 'http://localhost:90/jkuat_ip_telephony/extensions.php';
		}
		else if(response == "failure")
		{
			log_error_messages("error authenticating the user.");
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

function logout_ajax(){
	 
	show_progress();
	  
	// send data to server asynchronously.
	$.ajax({
		url: "logout.php",
		type: "POST",
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 
		
		window.location.href = 'http://localhost:90/jkuat_ip_telephony/login.php';
		 
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
 
function create_extension(){
	 
	show_progress();
	
	var code = $('#cbo_create_campus').val();
	var extension_number = $("#txt_create_extension_number").val().trim();
	var owner_assigned = $("#txt_create_owner_assigned").val().trim();
	var department = $("#cbo_create_department").val();

	var isvalid = true;
	if(code.length == 0)
	{
		log_error_messages("code cannot be null."); 
		isvalid = false;
	}
	if(extension_number.length == 0)
	{ 
		log_error_messages("extension number cannot be null."); 		
		isvalid = false;
	}
	if(owner_assigned.length == 0)
	{ 
		log_error_messages("owner assigned cannot be null."); 		
		isvalid = false;
	}
	if(department.length == 0)
	{ 
		log_error_messages("department cannot be null."); 		
		isvalid = false;
	}
	
	if(isvalid == false)
	{	
		hide_progress();
		return;
	}
	
	// send data to server asynchronously.
	$.ajax({
		url: "admin_controller.php",
		type: "POST",
		data: {
			"code": code,
			"extension_number": extension_number,
			"owner_assigned": owner_assigned,
			"department": department,
			"action": "create_extension"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 
		
		if(response == "successfull")
		{
			 log_info_messages(response); 
		}
		else if(response == "failure")
		{
			log_error_messages("error authenticating the user.");
		}
		else
		{ 
			log_error_messages(response);
		}	
		
		fetch_extensions(1);
		
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
	
}

function edit_extension(id){
	 
	show_progress();
	
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
		url: "admin_controller.php",
		type: "POST",
		data: {
			"id": id,
			"action": "get_extension"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 
		
		fetch_campus_codes("cbo_edit_campus");
		//fetch_department_names()
				
		var ext = JSON.parse(response);
				 
		var id = ext.id;
		var code = ext.ccode.trim();
		var extension_number = ext.deptcode.trim();
		var owner_assigned = ext.ownerassigned.trim();
		var department = ext.deptname.trim();

		$('#txt_edt_id').val(id);

		$("#cbo_edit_campus").select2({
			dropdownParent: $(".modal-content")
		});
		  
		$('#cbo_edit_campus').val(code);
		// $('#cbo_edit_campus').val(code).change();
		// document.getElementById("cbo_edit_campus").value = code;
		
		// $("#edit_extension_modal #cbo_edit_campus option[value=" + code + "]").attr('selected', 'selected');
		
		// const text = code;
		// const $select = document.querySelector('#cbo_edit_campus');
		// const $options = Array.from($select.options);

		// const optionToSelect = $options.find(item => item.value === text);
		// optionToSelect.selected = true;

		// var options = [];
		
		// $("#cbo_edit_campus > option").each(function() {
			// options.push(this.value);
			// console.log(this.text + ' ' + this.value);
		// });

		// var index = jQuery.inArray(code, options);
		
		// document.getElementById("cbo_edit_campus").options[index].selected = true;
		
		// $("#cbo_edit_campus").prop("selectedIndex", index);
		
		$("#txt_edit_extension_number").val(extension_number);
		$("#txt_edit_owner_assigned").val(owner_assigned);
		$("#cbo_edit_department").val(department);
		//$("#cbo_edit_department").val(department).trigger('change');

		//$("#edit_extension_modal #cbo_edit_department option[value=" + department + "]").attr('selected', 'selected');

		$('#edit_extension_modal').modal('show');
		
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
	
}

function delete_extension(id){
	 
	show_progress();
			
	var heading = "Delete";
	var question = "are you sure you want to delete the record with id [ " + id + " ].";
	var cancelButtonTxt = "cancel";
	var okButtonTxt = "ok";
	
	var confirmModal = 
		$('<div class="modal fade">' +        
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
		url: "admin_controller.php",
		type: "POST",
		data: {
			"id": id,
			"action": "delete_extension"
		},//data to be posted
		}).done(function(response){
			response = response.trim();

			console.log("response: " + response); 
 
			log_info_messages(response); 
			
			fetch_extensions(1);
			
			hide_progress();

		}).fail(function(jqXHR, textStatus){
			log_error_messages(textStatus);
			hide_progress();
		});
	}); 

	confirmModal.modal('show');  
	
	hide_progress();
	
}

function fetch_campus_codes() {
	
	show_progress();
		
	// send data to server asynchronously.
	$.ajax({
		url: "admin_controller.php",
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
			var name = campus_arr[i].cname.trim();
			var code = campus_arr[i].ccode.trim();
			console.log(name);
			console.log(code);
			select_options_arr.push('<option value="' + code + '">' + name + '</option>');
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
		url: "admin_controller.php",
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
			var name = campus_arr[i].cname.trim();
			var code = campus_arr[i].ccode.trim();
			console.log(name);
			console.log(code);
			select_options_arr.push('<option value="' + code + '">' + name + '</option>');
		}
 
		$('#cbo_search_campus').html(select_options_arr);
		$('#cbo_create_campus').html(select_options_arr);
		$('#cbo_edit_campus').html(select_options_arr);
 
		fetch_department_names("cbo_search_campus");
		fetch_department_names("cbo_create_campus");
		fetch_department_names("cbo_edit_campus");
		
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
		
}

function fetch_department_names(campus_name) {
	
	show_progress();
	
	var campus_code = "";
	
	switch(campus_name)
	{
		case "cbo_search_campus":
			 campus_code = $("#cbo_search_campus").val();
		break;
		case "cbo_create_campus":
			 campus_code = $("#cbo_create_campus").val();
		break;
		case "cbo_edit_campus":
			 campus_code = $("#cbo_edit_campus").val();
		break;
	}
	 
	console.log("campus_code: " + campus_code); 
	
	if(campus_code == undefined)
	{			 
		return;	
	}
	
	// send data to server asynchronously.
	$.ajax({
		url: "admin_controller.php",
		type: "POST",
		data: {
			"campus_code": campus_code,
			"action": "fetch_department_names"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		 
		console.log("response: " + response); 
		
		var names_arr = JSON.parse(response);
		
		console.log("names_arr: " + names_arr); 
			
		var select_options_arr = [];
		
		select_options_arr.push('<option value=""></option>');
		
		for (var i = 0; i < names_arr.length; i++) {
			var name = names_arr[i].deptname.trim();
			console.log(name);
			select_options_arr.push('<option value="' + name + '">' + name + '</option>');
		}
 		 
		$('#cbo_search_department').html(select_options_arr);
		$('#cbo_create_department').html(select_options_arr);
		$('#cbo_edit_department').html(select_options_arr);
  
		search_extensions(1);
		
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
	records_to_display = $("#cbo_records_to_display").val();
	
	console.log("records_to_display: " + records_to_display);
	
	console.log("page: " + page);
	
	// send data to server asynchronously.
	$.ajax({
		url: "admin_controller.php",
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
	
	global_page_number_holder = page;
	
	var records_to_display = 5;
	records_to_display = $("#cbo_records_to_display").val();
	
	console.log("records_to_display: " + records_to_display);	
	console.log("page: " + page);
	
	var campus_code = $("#cbo_search_campus").val();
	var department = $("#cbo_search_department").val();
	var extension_number = $("#txt_search_extension_number").val();
	
	console.log("campus_code: " + campus_code);	
	console.log("department: " + department);	
	console.log("extension_number: " + extension_number);
	
	show_progress();
	
	// send data to server asynchronously.
	$.ajax({
		url: "admin_controller.php",
		type: "POST",
		data: {
			"page": page,
			"records_to_display": records_to_display,
			"campus_code": campus_code,
			"department": department,
			"extension_number": extension_number,
			"action": "search_extensions"
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

function populate_display_vectors()
{
	var select_options_arr = "";
	select_options_arr += '<option value="5">5</option>';
	select_options_arr += '<option value="10">10</option>';
	select_options_arr += '<option value="20">20</option>';
	select_options_arr += '<option value="30">30</option>';
	select_options_arr += '<option value="40">40</option>';
	select_options_arr += '<option value="50">50</option>';
	select_options_arr += '<option value="100">100</option>';
	select_options_arr += '<option value="200">200</option>';
	select_options_arr += '<option value="500">500</option>';
	select_options_arr += '<option value="1000">1000</option>';
	select_options_arr += '<option value="-1">All</option>';
	
	$('#cbo_records_to_display').html(select_options_arr);	
	$('#cbo_search_records_to_display').html(select_options_arr);	 

}















 
$(document).ready(function () {
    
	//listen for enter key event in document.
	document.addEventListener("keypress", documententerkeyglobalhandler, false);
  
    $('#btn_logout').on('click', function(){
        logout_ajax();
    });
	   
	populate_display_vectors();
	 
    $('#btncreate_department_view').on('click', function(){
        $('#create_department_modal').modal('show');
		$("#txt_create_name").val(""); 
    });
	   
	$('#create_department_modal').on('shown.bs.modal', function () {
		$('#txt_create_name').focus();
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
	      
    $('#txt_search_name').on('input', function(){
        search_departments(1);
    });
	 
    $('#cbo_search_records_to_display').on('change', function(){
        search_departments(1);
    });
	
    $('.btn_edit').on('click', function(){
		var id = $(this).attr('data-id');  
        edit_department(id);
    });
	  
    $('.btn_delete').on('click', function(){
		var id = $(this).attr('data-id');
        delete_department(id);
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
	  
	search_departments(1);
	
    $('#btnclose_create_department_modal').on('click', function(){
        clear_logs();
    });
	   
    $('#btnclose_edit_department_modal').on('click', function(){
        clear_logs();
		search_departments(1);		
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
	 
	var department_name = $("#txt_create_name").val().trim();
	var addedby = readCookie("loggedinuser"); 

	var isvalid = true;
	 
	if(department_name.length == 0)
	{ 
		log_error_messages("Name cannot be null."); 		
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
		
		show_info_toast("Department created successfully.");
		
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
		var department_name = data.department_name.trim();
		var addedby = data.addedby.trim(); 

		$('#txt_edit_id').val(id);  
		$("#txt_edit_name").val(department_name);
		$("#txt_edit_addedby").val(addedby);
		 
		$('#div_edit_department_container').css({'display' : 'block'});
	 		
		$('#department_container').css({'display' : 'none'});
	 		 
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
	
}

function update_department(){
	
	show_progress();
	clear_logs();  
	
	var id = $('#txt_edit_id').val();
	var department_name = $("#txt_edit_name").val().trim();  
	
	var isvalid = true;
	
	if(id.length == 0)
	{
		log_error_messages("Error retieving primary key."); 
		isvalid = false;
	} 
	if(department_name.length == 0)
	{ 
		log_error_messages("Name cannot be null."); 		
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
			"action": "update_department"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 

		log_info_messages(response);  

		search_departments(1);
		
		clear_logs();
		
		show_info_toast("Department updated successfully.");
		
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
	
}

function delete_department(id){
	 
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
			
			show_info_toast("Department deleted successfully.");
		
			hide_progress();

		}).fail(function(jqXHR, textStatus){
			log_error_messages(textStatus);
			hide_progress();
		});
	}); 

	confirmModal.modal('show');  
	
	hide_progress();
	
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
	
	global_page_number_holder = page;
	
	var records_to_display = 5;
	records_to_display = $("#cbo_search_records_to_display").val();
	
	console.log("records_to_display: " + records_to_display);	
	console.log("page: " + page);
	 
	var department_name = $("#txt_search_name").val(); 
	 
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
			"action": "search_departments"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 
				   
		$('#department_container').css({'display' : 'block'});
	 
		$('#div_edit_department_container').css({'display' : 'none'});
	 		 
		$('#div_content').html(response);
		
		get_departments_search_count();
		
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
 














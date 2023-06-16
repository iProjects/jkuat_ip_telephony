 
$(document).ready(function () {
    
	//listen for enter key event in document.
	document.addEventListener("keypress", documententerkeyglobalhandler, false);
  
    $('#btn_logout').on('click', function(){
        logout_ajax();
    });
	   
	populate_display_vectors();
	 
    $('#btncreate_campus_view').on('click', function(){
		clear_logs();
        $('#create_campus_modal').modal('show');
		$('#txt_create_code').val("");
		$("#txt_create_name").val(""); 
    });
	
	$('#create_campus_modal').on('shown.bs.modal', function () {
		$('#txt_create_code').focus();
	})  
	
    $('#btncreate_campus').on('click', function(){
        create_campus();
    });
	    
    $('#btnupdate_campus').on('click', function(){
        update_campus();
    });
	    
	resize_components();

	$(window).on('resize', function(){
		resize_components();         
	});

	$(window).on('load', function(){
		resize_components();
	});
	     
    $('#txt_search_code').on('input', function(){
        search_campuses(1);
    });
	
    $('#txt_search_name').on('input', function(){
        search_campuses(1);
    });
	 
    $('#cbo_search_records_to_display').on('change', function(){
        search_campuses(1);
    });
	
    $('.btn_edit').on('click', function(){
		clear_logs();
		var id = $(this).attr('data-id');  
        edit_campus(id);
    });
	  
    $('.btn_delete').on('click', function(){
		clear_logs();
		var id = $(this).attr('data-id');
        delete_campus(id);
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
	  
	search_campuses(1);
	
    $('#btnclose_create_campus_modal').on('click', function(){
        clear_logs();
    });
	   
    $('#btnclose_edit_campus_modal').on('click', function(){
        clear_logs();
		search_campuses(1);		
    });
 
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

	$('#create_campus_modal').css('margin-top', function() {
		return $('#div_navigation').height();
	});
 
	$('#edit_campus_modal').css('margin-top', function() {
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
			case "campuses.php":
				//create_campus();
			break;
			default: 
			break;
		}

		
	}	
}
 
function create_campus(){
	
	show_progress();
	clear_logs();
	
	var campus_code = $('#txt_create_code').val().trim();
	var campus_name = $("#txt_create_name").val().trim();
	var addedby = readCookie("loggedinuser"); 

	var isvalid = true;
	
	if(campus_code.length == 0)
	{
		log_error_messages("Code cannot be null."); 
		isvalid = false;
	} 
	if(campus_name.length == 0)
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
		url: "campus_controller.php",
		type: "POST",
		data: {
			"campus_code": campus_code,
			"campus_name": campus_name,
			"addedby": addedby, 
			"action": "create_campus"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 

		log_info_messages(response);  

		search_campuses(1);
		
		$('#create_campus_modal').modal('hide');
		
		clear_logs();
		
		show_info_toast(response);
		
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
	
}
 
function edit_campus(id){
	 
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
		url: "campus_controller.php",
		type: "POST",
		data: {
			"id": id,
			"action": "get_campus"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 
		 
		var data = JSON.parse(response);
				 
		var id = data.cid;
		var campus_code = data.ccode.trim();
		var campus_name = data.cname.trim();
		var addedby = data.addedby.trim(); 

		$('#txt_edit_id').val(id);  
		$("#txt_edit_code").val(campus_code);
		$("#txt_edit_name").val(campus_name);
		$("#txt_edit_addedby").val(addedby);
		 
		$('#div_edit_campus_container').css({'display' : 'block'});
	 		
		$('#campus_container').css({'display' : 'none'});
	 		 
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
	
}

function update_campus(){
	
	show_progress();
	clear_logs();  
	
	var id = $('#txt_edit_id').val();
	var campus_code = $('#txt_edit_code').val().trim();
	var campus_name = $("#txt_edit_name").val().trim();  

	var isvalid = true;
	
	if(id.length == 0)
	{
		log_error_messages("Error retieving primary key."); 
		isvalid = false;
	} 
	if(campus_code.length == 0)
	{
		log_error_messages("Code cannot be null."); 
		isvalid = false;
	} 
	if(campus_name.length == 0)
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
		url: "campus_controller.php",
		type: "POST",
		data: {
			"id": id,
			"campus_code": campus_code,
			"campus_name": campus_name, 
			"action": "update_campus"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 

		log_info_messages(response);  

		search_campuses(1);
		
		clear_logs();
		
		show_info_toast(response);
		
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
	
}

function delete_campus(id){
	 
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
		url: "campus_controller.php",
		type: "POST",
		data: {
			"id": id,
			"action": "get_campus"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 
		 
		var data = JSON.parse(response);
				 
		var id = data.cid;
		var campus_code = data.ccode.trim();
		var campus_name = data.cname.trim();
		var addedby = data.addedby.trim();
		
		var delete_prompt = "Are you sure you wish to delete Campus [ " + campus_name + " ].";
		
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
			url: "campus_controller.php",
			type: "POST",
			data: {
				"id": id,
				"action": "delete_campus"
			},//data to be posted
			}).done(function(response){
				response = response.trim();

				console.log("response: " + response); 
	 
				log_info_messages(response); 
				
				search_campuses(1);
				
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

function fetch_campuses(page){
	 
	show_progress();
	
	global_page_number_holder = page;
	
	var records_to_display = 5;
	records_to_display = $("#cbo_search_records_to_display").val();
	
	console.log("records_to_display: " + records_to_display);
	
	console.log("page: " + page);
	
	// send data to server asynchronously.
	$.ajax({
		url: "campus_controller.php",
		type: "POST",
		data: {
			"page": page,
			"records_to_display": records_to_display,
			"action": "fetch_campuses"
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

function search_campuses(page){
	 
	show_progress();
	
	close_toast();
	
	global_page_number_holder = page;
	
	var records_to_display = 10; 
	
	console.log("records_to_display: " + records_to_display);	
	console.log("page: " + page);
	
	var campus_name = $("#txt_search_name").val(); 
	 	
	console.log("campus_name: " + campus_name);	 
	
	show_progress();
	
	// send data to server asynchronously.
	$.ajax({
		url: "campus_controller.php",
		type: "POST",
		data: {
			"page": page,
			"records_to_display": records_to_display, 
			"campus_name": campus_name, 
			"action": "search_campuses"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 
				   
		$('#campus_container').css({'display' : 'block'});
	 
		$('#div_edit_campus_container').css({'display' : 'none'});
	 		 
		$('#div_content').html(response);
		
		get_campuses_search_count();
		
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

function get_campuses_search_count(){
	 
	show_progress();
	  
	// send data to server asynchronously.
	$.ajax({
		url: "campus_controller.php",
		type: "POST",
		data: { 
			"action": "get_campuses_search_count"
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
		search_campuses(current_page);
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
 




























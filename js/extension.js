 
$(document).ready(function () {
    
	//listen for enter key event in document.
	document.addEventListener("keypress", documententerkeyglobalhandler, false);
  
    $('#btn_logout').on('click', function(){
        logout_ajax();
    });
	   
	populate_display_vectors();
	
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
	
	var campus = $('#cbo_create_campus').val();
	var department = $("#cbo_create_department").val();
	var owner_assigned = $("#txt_create_owner_assigned").val().trim();
	var extension_number = $("#txt_create_extension_number").val().trim();

	var isvalid = true;
	
	if(campus.length == 0)
	{
		log_error_messages("Select Campus."); 
		isvalid = false;
	}
	if(department.length == 0)
	{ 
		log_error_messages("Select Department."); 		
		isvalid = false;
	}
	if(owner_assigned.length == 0)
	{ 
		log_error_messages("Owner Assigned cannot be null."); 		
		isvalid = false;
	}
	if(extension_number.length == 0)
	{ 
		log_error_messages("Extension Number cannot be null."); 		
		isvalid = false;
	}
	if(!$.isNumeric(extension_number))
	{ 
		log_error_messages("Extension Number must be digits."); 		
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
			"code": campus,
			"extension_number": extension_number,
			"owner_assigned": owner_assigned,
			"department": department,
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
		var code = ext.ccode.trim();
		var _extension_number = ext.deptcode.trim();
		var owner_assigned = ext.ownerassigned.trim();
		var department = ext.deptname.trim();
 
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
		//fetch_department_names()
				
		var data = JSON.parse(response);
				 
		var id = data.id;
		var code = data.ccode.trim();
		var extension_number = data.deptcode.trim();
		var owner_assigned = data.ownerassigned.trim();
		var department = data.deptname.trim();

	  
		$('#txt_edit_id').val(id);

		// $("#cbo_edit_campus").select2({
			// dropdownParent: $(".modal-content")
		// });
		  
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

		//var div_edit_extension_container = $('#div_edit_extension_container');
 
		//$('#dashboard-container').append(div_edit_extension_container);
  
		$('#div_edit_extension_container').css({'display' : 'block'});
	 		
		$('#extensions_container').css({'display' : 'none'});
	 		
		//$('#edit_extension_modal').modal('show');
		
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
	
}

function update_extension(){
	
	show_progress();
	clear_logs();  
	
	var id = $('#txt_edit_id').val();
	var campus = $('#cbo_edit_campus').val();
	var department = $("#cbo_edit_department").val();
	var owner_assigned = $("#txt_edit_owner_assigned").val().trim();
	var extension_number = $("#txt_edit_extension_number").val().trim();

	var isvalid = true;
	
	if(id.length == 0)
	{
		log_error_messages("Error retieving primary key."); 
		isvalid = false;
	} 
	if(campus.length == 0)
	{
		log_error_messages("Select campus."); 
		isvalid = false;
	}
	if(department != null)
	{ 
		if(department.length == 0)
		{ 
			log_error_messages("Select Department."); 		
			isvalid = false;
		} 
	}
	if(department == null)
	{ 
		log_error_messages("Select Department."); 		
		isvalid = false;
	}
	if(owner_assigned.length == 0)
	{ 
		log_error_messages("Owner Assigned cannot be null."); 		
		isvalid = false;
	}
	if(extension_number.length == 0)
	{ 
		log_error_messages("Extension Number cannot be null."); 		
		isvalid = false;
	}
	if(!$.isNumeric(extension_number))
	{ 
		log_error_messages("Extension Number must be digits."); 		
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
			"code": campus,
			"extension_number": extension_number,
			"owner_assigned": owner_assigned,
			"department": department,
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
		var code = data.ccode.trim();
		var extension_number = data.deptcode.trim();
		var owner_assigned = data.ownerassigned.trim();
		var department = data.deptname.trim();
		
		var delete_prompt = "Are you sure you wish to delete Extension No [ " + extension_number + " ] for [ " + owner_assigned + " ] in Campus [ " + code + " ].";
		
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
			 if(campus_code.length == 0)
			 {
				$('#cbo_search_department').html("");
				search_extensions(1);
			 }
		break;
		case "cbo_create_campus":
			 campus_code = $("#cbo_create_campus").val();
			 if(campus_code.length == 0)
			 {
				$('#cbo_create_department').html("");				 
			 }
		break;
		case "cbo_edit_campus":
			 campus_code = $("#cbo_edit_campus").val();
			 if(campus_code.length == 0)
			 {
				$('#cbo_edit_department').html(""); 				 
			 }
		break;
	}
	
	console.log("campus_code: " + campus_code); 
	
	if(campus_code == undefined)
	{			 
		return;	
	}
	
	// send data to server asynchronously.
	$.ajax({
		url: "extension_controller.php",
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
		
		for(var i = 0; i < names_arr.length; i++) {
			var name = names_arr[i].deptname.trim();
			console.log(name);
			select_options_arr.push('<option value="' + name + '">' + name + '</option>');
		}
 		 
		$('#cbo_search_department').html(select_options_arr);
		$('#cbo_create_department').html(select_options_arr);
		$('#cbo_edit_department').html(select_options_arr);
  
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
	
	var campus_code = $("#cbo_search_campus").val();
	var department = $("#cbo_search_department").val();
	var other_params = $("#txt_other_params").val(); 
	
	console.log("campus_code: " + campus_code);	
	console.log("department: " + department);	
	console.log("other_params: " + other_params); 
	
	show_progress();
	
	// send data to server asynchronously.
	$.ajax({
		url: "extension_controller.php",
		type: "POST",
		data: {
			"page": page,
			"records_to_display": records_to_display,
			"campus_code": campus_code,
			"department": department,
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

function populate_display_vectors()
{
	var select_options_arr = "";
	select_options_arr += '<option value="-1">All</option>';
	select_options_arr += '<option value="5">5</option>';
	select_options_arr += '<option value="10">10</option>'; 
	
	$('#cbo_search_records_to_display').html(select_options_arr);	
	$('#cbo_search_records_to_display').html(select_options_arr);	 

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
 














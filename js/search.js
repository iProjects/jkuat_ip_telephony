
$(document).ready(function () {
    
    $('#btn_login').on('click', function(){        
		window.location.href = 'http://localhost:90/jkuat_ip_telephony/login.php';		 
    });
 
	populate_display_vectors();
	 
	//listen for enter key event in document.
	document.addEventListener("keypress", documententerkeyglobalhandler, false);
 
	resize_components();

	$(window).on('resize', function(){
		resize_components();         
	});

	$(window).on('load', function(){
		resize_components();
	});
	 
	fetch_all_campuses();
	 
	search_extensions(1);
	
    $('#cbocampus').on('change', function(){
        fetch_department_names("cbocampus");
		search_extensions(1);
    });
	 
    $('#cbodepartment').on('change', function(){ 
		search_extensions(1);
    });
	
    $('#txtextension_number').on('input', function(){
        search_extensions(1);
    });
	
    $('#txtdepartment').on('input', function(){
        search_extensions(1);
    });
	
    $('#txtowner_assigned').on('input', function(){
        search_extensions(1);
    });
	
    $('#cbo_search_records_to_display').on('change', function(){
        search_extensions(1);
    });
	 
    $('#btnclearsearch').on('click', function(){        
		$('#cbocampus').val("");
		$('#cbodepartment').val("");
		$('#txtdepartment').val("");		
		$('#txtextension_number').val("");
		$('#div_search_content').html("");
		$('#lbl_search_count').text("");
    });
 
	$('#txtextension_number').keypress(function(e){    

		var charCode = (e.which) ? e.which : event.keyCode;
		if (String.fromCharCode(charCode).match(/[^0-9]/g))    
		{
			return false;                        
		}
	}); 
	
	$('#lbl_search_count').text("");
	
	$("#progress_bar").hide();
	 
});

var global_page_number_holder = 1;

function resize_components() { 

	$('#maincontainer').css('margin-top', function() {
		return $('#div_navigation').height();
	});
 
	$('#div_messages').css('margin-bottom', function() {
		return $('#div_footer').height();
	});
  
	$('#div_content_container').css('margin-bottom', function() {
		return $('#div_footer').height();
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
			case "index.php":
				
			break; 
			default: 
			break;
		}

		
	}	
}
  
function fetch_all_campuses() {
	
	show_progress();
		
	// send data to server asynchronously.
	$.ajax({
		url: "search_controller.php",
		type: "POST",
		data: {
			"action": "fetch_all_campuses"
		},//data to be posted
	}).done(function(response){
		 
		console.log("response: " + response); 
		
		var campus_arr = JSON.parse(response);
		
		console.log("campus_arr: " + campus_arr); 
		
		var select_options_arr = "";

		select_options_arr += '<option value=""></option>';
		
		for (var i = 0; i < campus_arr.length; i++) {
			var name = campus_arr[i].cname;
			var code = campus_arr[i].ccode;
			console.log(name);
			console.log(code);
			select_options_arr += '<option value="' + code + '">' + name + '</option>';
		}
 
		$('#cbocampus').html(select_options_arr); 
 
		fetch_department_names("cbocampus"); 
		
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
		
}

function fetch_department_names(campus_name) {
	
	show_progress();
	
	var campus_code = $("#cbocampus").val(); 
	 
	console.log("campus_code: " + campus_code); 
	
	if(campus_code == undefined)
	{			 
		return;	
	}
	
	// send data to server asynchronously.
	$.ajax({
		url: "search_controller.php",
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
			
		var select_options_arr = "";
		
		select_options_arr += '<option value=""></option>';
		
		for (var i = 0; i < names_arr.length; i++) {
			var name = names_arr[i].deptname;
			console.log(name);
			select_options_arr += '<option value="' + name + '">' + name + '</option>';
		}
 		 
		$('#cbodepartment').html(select_options_arr); 
  
		search_extensions(1);
		
		hide_progress();
		
	}).fail(function(jqXHR, textStatus){
		log_error_messages(textStatus);
		hide_progress();
	});
		
}

function search_extensions(page){
	 
	show_progress();
	
	global_page_number_holder = page;
	
	var records_to_display = 10;
	//records_to_display = $("#cbo_search_records_to_display").val();
	
	console.log("records_to_display: " + records_to_display);	
	console.log("page: " + page);
	
	var campus_code = $("#cbocampus").val();
	var department = $("#cbodepartment").val();
	var extension_number = $("#txtextension_number").val();
	var txtdepartment = $("#txtdepartment").val();
	var txtowner_assigned = $("#txtowner_assigned").val();
	
	console.log("campus_code: " + campus_code);	
	console.log("department: " + department);	
	console.log("extension_number: " + extension_number);
	console.log("txtdepartment: " + txtdepartment);
	console.log("txtowner_assigned: " + txtowner_assigned);
	
	show_progress();
	
	// send data to server asynchronously.
	$.ajax({
		url: "search_controller.php",
		type: "POST",
		data: {
			"page": page,
			"records_to_display": records_to_display,
			"campus_code": campus_code,
			"department": department,
			"extension_number": extension_number,
			"txtdepartment": txtdepartment,
			"txtowner_assigned": txtowner_assigned,
			"action": "search_extensions"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 
				
		$('#div_search_content').html(response);
 
		get_search_results_count();
		
		$("#div_search_content").scrollTop();
 
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

function get_search_results_count(){
	 
	show_progress();
	  
	// send data to server asynchronously.
	$.ajax({
		url: "search_results_count.php",
		type: "POST",
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

function go2Page()
{
	var page = document.getElementById("txt_page").value; 
	search_extensions(page);
}














$(document).ready(function () {
    
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
	
    $('#txt_page').on('input', function(){
        console.log($('#txt_page').val());
    });
	
    $('#cbocampus').on('change', function(){
        fetch_department_names("cbocampus");
		search_extensions(1);
    });
	 
    $('#cbodepartment').on('change', function(){ 
		search_extensions(1);
    });
	
    $('#txt_other_params').on('input', function(){
        search_extensions(1);
    });
	
    $('#btnclearsearch').on('click', function(){        
		$('#cbocampus').val("");
		$('#cbodepartment').val("");
		$('#txt_other_params').val("");		 
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
	
	$('#txt_other_params').focus();
	
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
				search_extensions(1);
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
	
	close_toast();
	
	global_page_number_holder = page;
	
	var records_to_display = 10; 
	
	console.log("records_to_display: " + records_to_display);	
	console.log("page: " + page);
	
	var campus_code = $("#cbocampus").val();
	var department = $("#cbodepartment").val();
	var other_params = $("#txt_other_params").val(); 
	
	console.log("campus_code: " + campus_code);	
	console.log("department: " + department);	
	console.log("other_params: " + other_params); 
	
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
			"other_params": other_params, 
			"action": "search_extensions"
		},//data to be posted
	}).done(function(response){
		response = response.trim();
		
		console.log("response: " + response); 
				
		$('#div_search_content').html(response);
 
		//get_search_results_count();
		
		$("#div_search_content").scrollTop();
		
		$("#div_help_content").hide();
		 
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
			
		$('#maincontainer').attr('style', content_style);
				
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
			
		$('#maincontainer').attr('style', content_style);
		
	}
}
 











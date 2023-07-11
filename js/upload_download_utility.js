 
$(document).ready(function () {
    
	//listen for enter key event in document.
	document.addEventListener("keypress", documententerkeyglobalhandler, false);
  
    $('#btn_logout').on('click', function(){
        logout_ajax();
    });
	     
    $('#btn_upload').on('click', function(){
        upload_extensions();
    });
	      
    $('#btn_download').on('click', function(){
        download_extensions();
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
	

	/* this function will call when onchange event fired */
	$("#txt_file").on("input",function(){
		
		$("#lbl_upload_error").text("");
		$("#img_result").attr("src", "");
		
		/* current this object refer to input element */
		var $input = $(this);

		/* collect list of files choosen */
		var files = $input[0].files;

		var filename = files[0].name;
  
		/* getting file extenstion eg- .jpg,.png, etc */
		var extension = filename.substr(filename.lastIndexOf("."));

		/* define allowed file types */
		var allowedExtensionsRegx = /(\.xlsx|\.xls)$/i;

		/* testing extension with regular expression */
		var isAllowed = allowedExtensionsRegx.test(extension);

		if(isAllowed){
			//$("#lbl_upload_error").text("File type is valid for the upload"); 
			//$("#lbl_upload_error" ).css({ "color": "lime" });
			$("#img_result").attr("src", "images/success.png");
			$("#img_result" ).css({ "width": "5%", "height": "5%" });
		}else{
			$("#lbl_upload_error").text("Kindly choose an Excel File."); 
			$("#lbl_upload_error" ).css({ "color": "red" });
			$("#img_result").attr("src", "images/error.png");
			$("#img_result" ).css({ "width": "5%", "height": "5%" });
			return false;
		}
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
			case "upload_download_utility.php":
				upload_extensions();
			break;
			default: 
			break;
		}

		
	}	
}
 
function upload_extensions(){
	try {
		
		show_progress();
		clear_logs();
		
		$("#lbl_upload_error").text(""); 
		
		$("#btn_upload").attr('disabled', true);
		
		var isvalid = true;
		
		var upload_file = $("#txt_file")[0].files.length;
		var addedby = readCookie("loggedinuser"); 

		if(upload_file === 0)
		{
			log_error_messages("Please select a file to upload."); 
			$("#lbl_upload_error").text("Please select a file to upload."); 
			$("#lbl_upload_error" ).css({ "color": "red" });
			$("#txt_file").focus();
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
			$("#btn_upload").attr('disabled', false);
			hide_progress();
			return;
		}
		
		
		/*  input element */
		var $input = $('#txt_file');

		/* collect list of files choosen */
		var files = $input[0].files;

		var filename = files[0].name;
  
		/* getting file extenstion eg- .jpg,.png, etc */
		var extension = filename.substr(filename.lastIndexOf("."));

		/* define allowed file types */
		var allowedExtensionsRegx = /(\.xlsx|\.xls)$/i;

		/* testing extension with regular expression */
		var isAllowed = allowedExtensionsRegx.test(extension);

		if(isAllowed){

			show_info_toast("Uploading file...");
				
			var formData = new FormData();
			formData.append('file', $('#txt_file')[0].files[0]);

			console.log("formData: " + formData); 

			// send data to server asynchronously.
			$.ajax({
				url: "upload_extensions_from_excel_controller.php",
				type: "POST",	 
				data: {  
						"formData": formData, 
						"addedby": addedby, 
						"action": "upload_extensions"
					},//data to be posted	 			
				cache : false,
				processData: false,
			}).done(function(response){
				response = response.trim();
				
				console.log("response: " + response); 

				show_info_toast(response);
				
				log_info_messages(response);  
  
				clear_logs();
				
				hide_progress();
				
			}).fail(function(jqXHR, textStatus){
				var err_msg = jqXHR.responseText + "<br />" + jqXHR.statusText;
				show_error_toast(err_msg);
				log_error_messages(err_msg);
				hide_progress();
			});
			
		}else{
			$("#lbl_upload_error").text("Kindly choose an Excel File."); 
			$("#lbl_upload_error" ).css({ "color": "red" });
			$("#img_result").attr("src", "images/error.png");
			$("#img_result" ).css({ "width": "5%", "height": "5%" }); 
		}
				
		$("#btn_upload").attr('disabled', false);
			
	}
    catch (err) {	
		$("#btn_upload").attr('disabled', false);			
        console.log(err);
        log_error_messages(err);
    }	
	
}
  
  
function download_extensions(){
	try {
		
		show_progress();
		clear_logs();

		$("#btn_download").attr('disabled', true);

		// send data to server asynchronously.
		$.ajax({
			url: "upload_extensions_from_excel_controller.php",
			type: "POST",
			data: {   
					"action": "download_extensions"
				},//data to be posted 
		}).done(function(response){
			response = response.trim();
			
			console.log("response: " + response); 

			show_info_toast(response);
			
			log_info_messages(response);  

			clear_logs();
			
			hide_progress();
			
		}).fail(function(jqXHR, textStatus){
			var err_msg = jqXHR.responseText + "<br />" + jqXHR.statusText;
			show_error_toast(err_msg);
			log_error_messages(err_msg);
			hide_progress();
		});
			
		$("#btn_download").attr('disabled', false);

	}
    catch (err) {
		$("#btn_download").attr('disabled', false);
        console.log(err);
        log_error_messages(err);
    }	
	
}
  
  
  
  
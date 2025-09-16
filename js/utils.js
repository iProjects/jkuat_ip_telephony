
$(document).ready(function () {
  
  var server_path = "";
  
    setInterval(function () {
        showcurrenttime();
    }, 1000);
	
	set_origin();
	
    $('#btn_close_toast').on('click', function(){
        hide_toast();
    });
	
	add_toast_to_dom();
	
	//send_message_to_email("finished loading...");
	
});
 
function showcurrenttime() {
    try {
        var d = new Date();

        g_arrMonth = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

        g_arrDay = new Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

        var strmonthname = g_arrMonth[d.getMonth()]; var strdayname = g_arrDay[d.getDay()];

        var datestring = ("0" + d.getDate()).slice(-2) + "-" + strdayname + "-" + ("0" + (d.getMonth() + 1)).slice(-2) + "-" + strmonthname + "-" + d.getFullYear();

        var ampm = d.getHours() >= 12 ? 'pm' : 'am';

        var timestring = ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2) + ":" + ("0" + d.getSeconds()).slice(-2) + " " + ampm;

        $("#lblfooterdate").html(datestring);
        $("#lblfooterdate").attr("title", datestring);
        $("#lblfootertime").html(timestring);
        $("#lblfootertime").attr("title", timestring);

        var strcopyright = "Copyright (c) JKUAT. " + d.getFullYear() + " All rights reserved"
        $("#lblcopyright").html(strcopyright);
        $("#lblcopyright").attr("title", strcopyright);
 
    }catch (err) {
        log_error_messages(err);
        console.log(err);
    }
}

var myInterval = setInterval(elapsed_time, 1000);

function myStopFunction() {
    clearInterval(myInterval);
}

var _initial_date = new Date();

function elapsed_time() {

    var _today = _initial_date;
    var _current = new Date();
    var _days = parseInt((_current - _today) / (1000 * 60 * 60 * 24));
    var _hours = parseInt(Math.abs(_current - _today) / (1000 * 60 * 60) % 24);
    var _minutes = parseInt(Math.abs(_current.getTime() - _today.getTime()) / (1000 * 60) % 60);
    var _seconds = parseInt(Math.abs(_current.getTime() - _today.getTime()) / (1000) % 60);

    var _elapsed_time = _days + ':' + _hours + ':' + _minutes + ':' + _seconds;

    $('#lblfooterelapsedtime').text(_elapsed_time);

}

function log_info_messages(message) {
    $("#div_messages").fadeIn(2000, function () {

		var d = new Date();
		var datestring = ("0" + d.getDate()).slice(-2) + "-" + ("0" + (d.getMonth() + 1)).slice(-2) + "-" + d.getFullYear();
		var timestring = ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2) + ":" + ("0" + d.getSeconds()).slice(-2);
		var today = datestring + " " + timestring;

		var msg = today + " : " + message;
 
		$("#div_messages_modal").append('<div class="div_info_message_item">' + msg + '</div>');
		$(".div_messages_modal").append('<div class="div_info_message_item">' + msg + '</div>'); 
		
		console.log(msg);
		
		show_info_toast(msg);
				 
	});
}

function log_error_messages(message) {
    $("#div_messages").fadeIn(2000, function () {

		var d = new Date();
		var datestring = ("0" + d.getDate()).slice(-2) + "-" + ("0" + (d.getMonth() + 1)).slice(-2) + "-" + d.getFullYear();
		var timestring = ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2) + ":" + ("0" + d.getSeconds()).slice(-2);
		var today = datestring + " " + timestring;

		var msg = today + " : " + message;
 
		$("#div_messages_modal").append('<div class="div_error_message_item">' + msg + '</div>');
		$(".div_messages_modal").append('<div class="div_error_message_item">' + msg + '</div>'); 
		
		console.log(msg);
		
		show_error_toast(msg);
				
    });
}
 
function show_progress(){	
	$("#progress_bar").show();
	$("#progress_bar").fadeIn(100);
}

function hide_progress(){
	$("#progress_bar").hide();
	$("#progress_bar").fadeOut(1000);
}


function clear_logs(){	
	$("#div_messages").html('');
	$("#div_messages_modal").html('');
	$(".div_messages_modal").html('');
	$("#div_login_messages").html('');
}

function  set_origin()
{
	try { 
	 
		var saved_origin = readCookie("origin");
		console.log(saved_origin);
		
		if(saved_origin.length == 0)
		{
			var origin = document.location.origin; 
			//createCookie("origin", origin, 8000);
		}
    }
    catch (err) {
        log_error_messages(err);
        console.log(err);
    }
}

function createCookie(name, value, days) {
    var expires;

    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    } else {
        expires = "";
    }
    document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
}

function readCookie(name) {
    var nameEQ = encodeURIComponent(name) + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ')
            c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0)
            return decodeURIComponent(c.substring(nameEQ.length, c.length));
    }
    return null;
}

function eraseCookie(name) {
    createCookie(name, "", -1);
}


var saved_origin = readCookie("origin");
var global_path = saved_origin;


function show_error_toast(message) {

	$('#div_toast_msg').html(message);

	var style = [
		'display: block', 
		'position: absolute',
		'width: auto',
		'height: auto',
		'max-width: 50%',
		'max-height: 50%',
		'word-break: break-all',
		'word-wrap: break-word',
		'overflow-wrap: break-word',
		'overflow: auto',
		'right: 1%',
		'bottom: 5%',
		'float: right',
		'background-color: rgb(241, 10, 10)',
		'color: rgb(255 255 255)',
		'animation: fadein 5s, fadeout 5s 60s',
	].join(';');
	
	$('#toast').removeClass("invisible");	
	$('#toast').attr('style', style);
 
	setTimeout(function() { 			
			 
		$('#toast').addClass("invisible");	
		$('#toast').attr('style', style);			 

	}, 60000);

}
 
function show_info_toast(message) {

	$('#div_toast_msg').html(message);
			
	var style = [
		'display: block', 
		'position: fixed',
		'width: auto',
		'height: auto',
		'max-width: 50%',
		'max-height: 50%',
		'word-break: break-all',
		'word-wrap: break-word',
		'overflow-wrap: break-word',
		'overflow: auto',
		'right: 1%',
		'bottom: 5%',
		'float: right',
		'background-color: rgb(6 104 4)',
		'color: rgb(255 255 255)',
		'animation: fadein 5s, fadeout 5s 60s',
		'border-radius: 5px',
	].join(';');
	
	$('#toast').removeClass("invisible");	
	$('#toast').attr('style', style);
 
	setTimeout(function() { 			
			 
		$('#toast').addClass("invisible");	
		$('#toast').attr('style', style);			 

	}, 60000);
	
}

function hide_toast(){
	var style = [
		'animation: fadein 5s, fadeout 5s 5s',
	].join(';');
	 	
	$('#toast').attr('style', style);
	
	setTimeout(function() { 
		$('#toast').addClass("invisible");	
		$('#toast').attr('style', style);	
	}, 5000);
	
	close_toast();
}

function add_toast_to_dom(){
	var _toast_div = '<div id="toast" class="invisible">';
	_toast_div += '<a id="btn_close_toast" onClick="close_toast()"><img src="images/delete.png" /></a>';
	_toast_div += '<div id="div_toast_msg"></div>';
	_toast_div += '</div>';
	$("body").append(_toast_div); 
	 
}

function close_toast(){
	$('#toast').addClass("invisible");	
	$("#toast").css('display', 'none');
}

function send_message_to_email(message)
{ 
	var logged_in_user_email = readCookie("logged_in_user_email");
	send_email(logged_in_user_email, message); 
}

 function send_email(email, message)
 {
	try {
		
		// send data to server asynchronously.
		$.ajax({
			url: "send_email_with_phpmailer_controller.php",
			type: "POST",
			data: {
				"email": email,
				"message": message,
				"action": "send_email"
			},//data to be posted
		}).done(function(response){
			response = response.trim();
			
			console.log("response: " + response); 
			  
			log_info_messages(response);

			hide_progress();
			
		}).fail(function(jqXHR, textStatus){
			log_error_messages(textStatus);
			hide_progress();
		});
		
		
		// send data to server asynchronously.
		$.ajax({
			url: "send_email_controller.php",
			type: "POST",
			data: {
				"email": email,
				"message": message,
				"action": "send_email"
			},//data to be posted
		}).done(function(response){
			response = response.trim();
			
			console.log("response: " + response); 
			  
			//show_info_toast(response);
			
			log_info_messages(response);

			hide_progress();
			
		}).fail(function(jqXHR, textStatus){
			log_error_messages(textStatus);
			hide_progress();
		});
		
		
	}
    catch (err) {
        console.log(err);
        log_error_messages(err);
    }		 
 }
 











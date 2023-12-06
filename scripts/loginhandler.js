// JavaScript to handle login
$(document).ready(function () {
	
	// Check for sessionid cookie
	const sessionidValue = document.cookie
		.split("; ")
		.find((row) => row.startsWith("sessionid="))
		?.split("=")[1];
		console.log(sessionidValue);
	
	// Check for userid cookie
	const useridValue = document.cookie
		.split("; ")
		.find((row) => row.startsWith("userid="))
		?.split("=")[1];
	console.log(useridValue);
	// Grab formdata when login form is submitted
	$("#LoginForm").submit(function (event) {
		var formData ={
			username: $("#username").val(),
			password: $("#password").val(),
		};
		
		// ajax request for login processing script
		$.ajax({
			type: "POST",
			url: "/scripts/process.php",
			data: formData,
			dataType: "json",
			encode: true,
		}).done(function (data){
			
			// Check for errors
			if (!data.success) {
				
				if (data.errors.password) {
					$("#FormPassword").addClass("has-error");
					$("#FormPassword").append(
						'<div class="help-block">' + data.errors.password + "</div>"
					);
				} else if (data.errors.activation) {
					$("#FormPassword").addClass("has-error");
					$("#FormPassword").append(
						'<div class="help-block">' + data.errors.activation + "</div>"
					);
				}
			// If no errors, continue
			} else {
				
				// Load main menu
				$.get('/snippets/mainmenu.html', function(newHTMLdata) {
					$("#App").html(newHTMLdata);
				})
			}
		});
		
		event.preventDefault();
	});
});

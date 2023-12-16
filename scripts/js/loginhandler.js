// JavaScript to handle login
$(document).ready(function () {	
	// Grab formdata when login form is submitted
	$("#LoginForm").submit(function (event) {
		var formData ={
			username: $("#email").val(),
			password: $("#password").val(),
		};
		// ajax request for login processing script
		$.ajax({
			type: "POST",
			url: "/scripts/php/process.php",
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
				$.get('/snippets/mainmenu.php', function(newHTMLdata) {
					$("#rowmain").html(newHTMLdata);
				})
				
				// Load navbar
				$.get('/snippets/navbar.html', function(newHTMLdata) {
					$("body").prepend(newHTMLdata);
				})
			}
		});
		
		event.preventDefault();
	});
});

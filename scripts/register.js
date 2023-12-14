// JavaScript Document to handle registration
$(document).ready(function () {
	$("#regButton").click(function () {
		
		$.get('/snippets/registration.html', function(data) {
			$("#middle").html(data);
		})
	});
});

$(document).ready(function (){
	$("body").on("submit", "#RegisterForm", function(event) {
		
		event.preventDefault();
		
		var formData ={
			firstname: $("#firstname").val(),
			lastname: $("#lastname").val(),
			email: $("#email").val(),
			password: $("#password").val(),
		}
		
		$.ajax({
			type: "POST",
			url: "/scripts/register.php",
			data: formData,
			dataType: "json",
			encode: true,
		}).done(function (data) {

			if (!data.success) {
				
				if (data.errors.password) {
					$("#FormPassword").addClass("has-error");
					$("#FormPassword").append(
						'<div class="help-block">' + data.errors.password + "</div>"
					);
				}
				if (data.errors.username) {
					$("#FormPassword").addClass("has-error");
					$("#FormPassword").append(
						'<div class="help-block">' + data.errors.username + "</div>"
					);
				}
			} else {
				$.get('/snippets/registrationsuccess.html', function(newHTMLdata) {
					$("#middle").html(newHTMLdata);
				})
			}
			
		});
	});
});

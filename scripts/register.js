// JavaScript Document to handle auth form
$(document).ready(function () {
	$(".regButton").click(function () {
		
		$.get('/snippets/registration.html', function(data) {
			$("#App").html(data);
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
				if (data.errors.username) {
					$("#FormEmailAddress").addClass("has-error");
					$("#FormEmailAddress").append(
						'<div class="help-block">' + data.errors.username + "</div>"
					);
				}
			}
			
		});
	});
});
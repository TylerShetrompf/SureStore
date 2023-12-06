// JavaScript Document to handle auth form
$(document).ready(function () {
	$("#LoginForm").submit(function (event) {
		var formData ={
			username: $("#username").val(),
			password: $("#password").val(),
		};

		$.ajax({
			type: "POST",
			url: "/scripts/process.php",
			data: formData,
			dataType: "json",
			encode: true,
		}).done(function (data){
			
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
			}
		});
		
		event.preventDefault();
	});
});
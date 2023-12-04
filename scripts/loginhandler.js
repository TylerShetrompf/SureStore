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
			console.log(data);
			if (!data.success) {
				
				if (data.errors.password) {
					$("#FormPassword").addClass("has-error");
					$("#FormPassword").append(
						'<div class="help-block">' + data.errors.password + "</div>"
					);
				}
				
			}
		});
		
		event.preventDefault();
	});
});
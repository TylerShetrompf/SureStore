// JavaScript Document to handle auth form
$(document).ready(function () {
	$("form").submit(function (event) {
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
				
				if (data.errors.username) {
					$("#FormUsername").addClass("has-error");
					$("#FormUsername").append(
						'<div class="help-block">' + data.errors.username + "</div>"
					);
				}
				
				if (data.errors.username) {
					$("#FormPassword").addClass("has-error");
					$("#FormPassword").append(
						'<div class="help-block">' + data.errors.password + "</div>"
					);
				}
				
				if (data.errors.database) {
					$("#submitbutton").addClass("has-error");
					$("#submitbutton").append(
						'<div class="help-block">' + data.errors.password + "</div>"
					);
				}
				
			}
		});
		
		event.preventDefault();
	});
});
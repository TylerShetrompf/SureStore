// JavaScript Document to handle auth form
$(document).ready(function () {
	$(".regButton").click(function () {
		$.get('/snippets/registration.html', function(data) {
			$("#App").html(data);
			console.log("regButtonPushed");
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
		console.log("formDataSubmitted");
		console.log(formData);
		console.log(firstname);
		$.ajax({
			type: "POST",
			url: "/scripts/register.php",
			data: formData,
			dataType: "json",
			encode: true,
		}).done(function (data) {
			console.log(data);
		});
	});
});
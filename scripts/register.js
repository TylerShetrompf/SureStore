// JavaScript Document to handle auth form
$(document).ready(function () {
	$("#Register").submit(function (event) {
		event.preventDefault();
		$.ajax({}).done(function () {
			$("#App").innerHTML = "test success";
		})
	})
})
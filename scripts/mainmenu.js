// JavaScript Document for handling the main menu
$(document).ready(function () {
	$("body").on("click", "#locButton", function() {
		$.get('/snippets/locator.html', function(data) {
			$("#App").html(data);
		})
	});
});
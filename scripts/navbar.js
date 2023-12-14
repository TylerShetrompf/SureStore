// JavaScript Document for navbar
$(document).ready(function () {
	
	// Home nav button
	$("body").on("click", "#homenav", function(event) {
		event.preventDefault();
		$.get('/snippets/mainmenu.php', function(data) {
			$("#App").html(data);
		})
	});
	
	
});
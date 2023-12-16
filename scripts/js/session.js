// Javascript document for handling sessions
$(document).ready(function(){
	$.ajax({
		type: "GET",
		url: "/scripts/php/verifysession.php",
		dataType: "json",
		encode: true
	}).done(function (data){
		if (data["success"] == true){
			// Load main menu
			$.get('/snippets/mainmenu.php', function(newHTMLdata) {
				$("#appcontainer").html(newHTMLdata);
			})
				
			// Load navbar
			$.get('/snippets/navbar.html', function(newHTMLdata) {
				$("body").prepend(newHTMLdata);
			})
		}
	});
});
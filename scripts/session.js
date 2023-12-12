// Javascript document for handling sessions
// FOR SOME UNKNOWN REASON, THIS SCRIPT NEEDS TO BE INCLUDED LAST IN MAIN.HTML
$(document).ready(function() {
	// Check for sessionid cookie
	const sessionidCookie = decodeURIComponent(document.cookie).split("; ");
	const sessionidRow = sessionidCookie.find((row) => row.startsWith("sessionid="));
	const sessionidValue = sessionidRow.split("=")[1];
	
	// Check for userid cookie
	const useridCookie = decodeURIComponent(document.cookie).split("; ");
	const useridRow = useridCookie.find((row) => row.startsWith("userid="));
	const useridValue = useridRow.split("=")[1];
	var cookieData ={
		userid: useridValue,
		sessionid: sessionidValue,
	};
		
	$.post("/scripts/verifysession.php", cookieData, function(data){
		var returnsuccess = JSON.parse(data);
		if (returnsuccess.success) {
			$.get('/snippets/mainmenu.php', function(newHTMLdata) {
				$("#App").html(newHTMLdata);
			});
			// Load navbar
			$.get('/snippets/navbar.html', function(newHTMLdata) {
				$(".navbar").html(newHTMLdata);
			});
		}
	});
});
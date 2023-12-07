// Javascript document for handling sessions
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
		}
	});
});
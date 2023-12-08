// JavaScript Document for handling the main menu
$(document).ready(function () {
	$("body").on("click", "#locButton", function(event) {
		event.preventDefault();
		$.get('/snippets/locator.html', function(data) {
			$("#App").html(data);
		})
	});
});


$(document).ready(function () {
	$("body").on("keyup", "#vaultsearchform", function () {
		var query = $("#search").val();
		$.ajax({
			type: "POST",
			url: "/scripts/vaultsearch.php",
			data: query,
			dataType: "json",
			encode: true,
		}).done(function (data){
			console.log(data);
		})
	});
});

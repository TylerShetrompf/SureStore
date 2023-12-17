// JavaScript Document for handling the main menu
$(document).ready(function () {
	
	// Locator button
	$("body").on("click", "#locButton", function(event) {
		event.preventDefault();
		$.get('/snippets/locator.php', function(data) {
			$("#middle").html(data);
			
			// Call initialize select2 function so that select2 registers box on load
			initializeSelect2();
		})
	});
	
	// Maintenance button
	$("body").on("click", "#maintButton", function(event) {
		event.preventDefault();
		$.get('/snippets/maintenance.php', function(data) {
			$("#middle").html(data);
		})
	});
	
	// Admin button
	$("body").on("click", "#adminButton", function(event) {
		event.preventDefault();
		$.get('/snippets/admin.php', function(data) {
			$("#middle").html(data);
		})
	});

});
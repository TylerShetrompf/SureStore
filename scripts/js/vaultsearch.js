// JavaScript Document to handle vault search
// Create reg button
$(document).ready(function (){
	
	// New reg handler
	$("body").on("submit", "#newregform", function(event){
		event.preventDefault();
		var orderid = $("#regidinput").val();
		$.get('/snippets/vaultinfo/vaultinfo.html', function(data) {
			$("#appcontainer").html(data);
		}).done(function(){
			$.get('/snippets/vaultinfo/newordermiddle.php', function(data) {
				$("#middle").html(data);
			}).done(function(){
				initordernew(orderid);
			});
		})

	});
	
	// Vault search selection handler
	// Grab selected content, format
	$('body').on("change", "#search", function(event) {
		event.preventDefault();
		
		// Set content variable
		var content = $("#select2-search-container").text();
		
		// Narrow content down to array
		content = content.replace("Order: ", "");
		content = content.replace(" Customer: ",",");
		content = content.replace(" Vault: ",",");
		content = content.replace(" ",",");
		content = content.split(",");
		
		// Assign values to associative array
		var orderid = content[0];
		
		
		$.get('/snippets/vaultinfo/vaultinfo.html', function(data) {
			$("#appcontainer").html(data);
		}).done(function () {
			$.get('/snippets/vaultinfo/vaultinfoleft.html', function(data) {
				$("#left").html(data);
			}).done(function() {
				$.get('/snippets/vaultinfo/vaultinfomiddle.php', function(data) {
					$("#middle").html(data);
				}).done(function (){
					initorderfull(orderid);
				})
			})
		})	
	});
});
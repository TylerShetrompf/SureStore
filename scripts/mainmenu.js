// JavaScript Document for handling the main menu
$(document).ready(function () {
	
	// Locator button
	$("body").on("click", "#locButton", function(event) {
		event.preventDefault();
		$.get('/snippets/locator.php', function(data) {
			$("#App").html(data);
			
			// Call initialize selct2 function so that select 2 registers box on load
			initializeSelect2();
		})
	});
	
	// Maintenance button
	$("body").on("click", "#maintButton", function(event) {
		event.preventDefault();
		$.get('/snippets/maintenance.php', function(data) {
			$("#App").html(data);
		})
	});
	
	$("body").on("click", "#adminButton", function(event) {
		event.preventDefault();
		$.get('/snippets/admin.php', function(data) {
			$("#App").html(data);
		})
	});
	
	// Home nav button
	$("body").on("click", "#homenav", function(event) {
		event.preventDefault();
		$.get('/snippets/mainmenu.php', function(data) {
			$("#App").html(data);
		})
	});
});

function initializeSelect2(){
	$('.vaultSearch').select2({
		placeholder: "Search by registration, customer name, or vault...",
		ajax: {
			type: "POST",
			url: '/scripts/vaultsearch.php',
			data: function(term){
				return term;
			},
			dataType: "json",
			encode: true,
			processResults: function (data) {
				return data;
			}
		}
	});
	$('.vaultSearch').on("select2:select", function(event) {	
		console.log('Selecting');
	});
}
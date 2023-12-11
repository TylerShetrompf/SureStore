// JavaScript Document for handling the main menu
$(document).ready(function () {
	$("body").on("click", "#locButton", function(event) {
		event.preventDefault();
		$.get('/snippets/locator.html', function(data) {
			$("#App").html(data);
			
			// Call initialize selct2 function so that select 2 registers box on load
			initializeSelect2();
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
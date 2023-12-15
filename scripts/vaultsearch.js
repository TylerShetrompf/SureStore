// JavaScript Document to handle vault search

// Select2 stuff
function initializeSelect2(){
	$('#search').select2({
		theme: 'bootstrap-5',
		width: "100%",
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
	
	// Grab selected content, format
	$('#search').on("change", function(event) {
		event.preventDefault();
		
		// Set content variable
		var content = $("#select2-search-container").text();
		
		// Narrow content down to array
		content = content.replace("Reg: ", "");
		content = content.replace(" Customer: ",",");
		content = content.replace(" Vault: ",",");
		content = content.replace(" ",",");
		content = content.split(",");
		
		// Assign values to associative array
		var orderid = content[0];
		$.get('/snippets/vaultinfoleft.html', function(data) {
			$("#left").html(data);
		})
		initializeItemTable(orderid);
	});
}
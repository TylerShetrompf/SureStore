// JavaScript Document to handle vault search

// Select2 stuff
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
	
	// Grab selected content, format
	$('.vaultSearch').on("change", function(event) {
		event.preventDefault();
		
		// Set content variable
		var content = $(".select2-selection__rendered").text();
		
		// Narrow content down to array
		content = content.replace("Reg: ", "");
		content = content.replace(" Customer: ",",");
		content = content.replace(" Vault: ",",");
		content = content.replace(" ",",");
		content = content.split(",");
		
		// Assign values to associative array
		var formData = {
			orderid: content[0],
		};
		$.ajax({
			type: "POST",
			url: "/scripts/vaultinfo.php",
			data: formData,
			dataType: "json",
			encode: true,
		}).done(function (returndata){
			$.get('/snippets/vaultinfoleft.html', function(data) {
				$(".leftside").html(data);
				initializeDataTables();
			})
			$.get('/snippets/vaultinforight.html', function(data) {
				$(".rightside").html(data);
			})
		});
	});
}
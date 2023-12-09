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
	$('.vaultSearch').select2({
		ajax:{
			url: '/scripts/vaultsearch2.php',
			dataType: 'json',
		},
		placeholder: 'Search',
		minimumInputLength: 1,
	});
});

/*
$(document).ready(function () {
	$("body").on("keyup", "#search", function () {
		var input ={
			query: $("#search").val(),
		};
		$.ajax({
			type: "POST",
			url: "/scripts/vaultsearch.php",
			data: input,
			dataType: "json",
			encode: true,
		}).done(function (data){;
			console.log(data);
			// $("#vaultsearchform").append(data);
		})
	});
});
*/
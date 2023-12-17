// JavaScript Document to handle logout
$(document).ready(function() {
	$("body").on("click", "#logoutnav", function(event){
		event.preventDefault();
		$.ajax({
			type: "GET",
			url: "/scripts/php/logout.php",
			dataType: "json",
			encode: true
		});
		location.reload();
	})
});
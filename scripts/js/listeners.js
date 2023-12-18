// JavaScript Document containing jquery listeners
$(document).ready(function () {
	
	// Listener to handle create order submit
	$("body").on("submit", "#neworderform", function (event){
		event.preventDefault();
		var formData ={
			custbusiness: $('#businessinput').val(),
			custtn : $('#cust-tn').val(),
			custfirst: $('#custfirstinput').val(),
			custlast: $('#custlastinput').val(),
			custaddress: $('#custaddyinput').val(),
			custcity: $('#custcityinput').val(),
			custzip: $('#custzipinput').val(),
			orderid: $('#reginput').val(),
			orderwh: $('#regwhinput').val(),
			datein: $('#regdateininput').val(),
			weight: $('#regweightinput').val(),
			custstate: $('#custstateinput').val(),
			custcountry: $('#custcountryinput').val()
		}
		$.ajax({
			url: "/scripts/php/createorder.php",
			type: "POST",
			data: formData,
			dataType: "json",
			encode: true
		}).done(function (data) {
			if (data["success"] == "false") {
				$("#neworderdiv").prepend('<div class="alert alert-danger" role="alert"><h4 class="alert-heading">ERROR</h4><p>ORDER CREATION OR CUSTOMER CREATION HAS FAILED. YOUR CHANGES MAY NOT HAVE BEEN SAVED.</p><hr><p class="mb-0">PLEASE CONTACT SYSTEM ADMINISTRATOR.</p></div>');
			} else {
				$.get('/snippets/vaultinfo/vaultinfo.html', function(data) {
					$("#appcontainer").html(data);
				})

				$.get('/snippets/vaultinfo/vaultinfoleft.html', function(data) {
					$("#left").html(data);
				}).done(function(){
					initializeItemTable(formData["orderid"]);
				})

				$.get('/snippets/vaultinfo/vaultinfomiddle.php', function(data) {
					$("#middle").html(data);
				}).done(function(){
					initializeSelect2();
					fillreginfo(formData["orderid"]);
					fillcustinfo(formData["orderid"]);
					custsearch();
				})
			}
		});
		
	}); // end of create order listener
	
	
	
	
	
	
	
	
}) // End of document.ready
// JavaScript Document to handle custinfo
$(document).ready(function (){
	
	// Custinfo form submit handler
	$("body").on("submit", "#custinfoform", function (event){
		event.preventDefault();
		var custformdata ={
			custbusiness: $('#businessinput').val(),
			custtn : $('#cust-tn').val(),
			custfirst: $('#custfirstinput').val(),
			custlast: $('#custlastinput').val(),
			custaddress: $('#custaddyinput').val(),
			custcity: $('#custcityinput').val(),
			custzip: $('#custzipinput').val(),
			orderid: $('#reginput').val(),
			custstate: $('#custstateinput').val(),
			custcountry: $('#custcountryinput').val()
		}
		
		if ($("#hiddencustid").val()) {
			custformdata["custid"] = $("#hiddencustid").val();
		}
		$.ajax({
			url: "/scripts/php/updatecustinfo.php",
			type: "POST",
			data: custformdata,
			dataType: "json",
			encode: true
		}).done(function (data){
			if (data["success"] == "false"){
				$("#reginfodiv").append('<div class="alert alert-danger" role="alert">Update failed. Please contact system administrator.</div>')
			} else {
				$.get('/snippets/vaultinfo/vaultinfo.html', function(data) {
					$("#appcontainer").html(data);
				}).done(function (){
					$.get('/snippets/vaultinfo/vaultinfoleft.html', function(data) {
						$("#left").html(data);
					}).done(function(){
						$.get('/snippets/vaultinfo/vaultinfomiddle.php', function(data) {
							$("#middle").html(data);
						}).done(function(){
							initorderfull(custformdata["orderid"]);
						})
					})
				})
			}
		});
	});
	
	// Customer search select handler
	$('body').on("change", "#custidinput", function(event) {
		event.preventDefault();
		var content = $("#select2-custidinput-container").text();
		content = content.replaceAll(" ", ",");
		content = content.split(",");
		var first = content[1];
		var last = content[2];
		
		var formData ={
			custfirst: first,
			custlast: last
		}
		
		$.ajax({
			url: "/scripts/php/custsearch.php",
			type: "POST",
			data: formData,
			dataType: "json",
			encode: true
		}).done(function (data){

			// Set option on custstate search box
			$('#custstateinput').select2({theme: 'bootstrap-5'}).val(data["custstate"]).trigger("change");

			// Set option on custcountry search box
			$('#custcountryinput').select2({theme: 'bootstrap-5'}).val(data["custcountry"]).trigger("change");

			// Fill fields with appropriate values
			$('#businessinput').val(data["custbusiness"]);
			$('#cust-tn').val(data["custtn"]);
			$('#custfirstinput').val(data["custfirst"]);
			$('#custlastinput').val(data["custlast"]);
			$('#custaddyinput').val(data["custaddress"]);
			$('#custcityinput').val(data["custcity"]);
			$('#custzipinput').val(data["custzip"]);
			$('#hiddencustid').val(data["custid"]);
		});
		
	});
	
		
	// Phone number masking handler
	$('body').on("keydown", '#cust-tn', function (e) {
		var key = e.which || e.charCode || e.keyCode || 0;
		$phone = $(this);

		// Don't let them remove the starting '('
		if ($phone.val().length === 1 && (key === 8 || key === 46)) {
				$phone.val('('); 
			return false;
		} else if ($phone.val().charAt(0) !== '(') {
			// Reset if they highlight and type over first char.
			$phone.val('('+String.fromCharCode(e.keyCode)+''); 
		}

		// Auto-format- do not expose the mask as the user begins to type
		if (key !== 8 && key !== 9) {
			if ($phone.val().length === 4) {
				$phone.val($phone.val() + ')');
			}
			if ($phone.val().length === 5) {
				$phone.val($phone.val() + ' ');
			}			
			if ($phone.val().length === 9) {
				$phone.val($phone.val() + '-');
			}
		}

		// Allow numeric (and tab, backspace, delete) keys only
		return (key == 8 || 
				key == 9 ||
				key == 46 ||
				(key >= 48 && key <= 57) ||
				(key >= 96 && key <= 105));
		
	}).bind('focus click', function () {
		$phone = $(this);

		if ($phone.val().length === 0) {
			$phone.val('(');
		} else {
			var val = $phone.val();
			$phone.val('').val(val); // Ensure cursor remains at the end
		}
	}).blur(function () {
		$phone = $(this);

		if ($phone.val() === '(') {
			$phone.val('');
		}
	});
	
});

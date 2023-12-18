// JavaScript Document containing functions

// Function to initialize datatables for vault listing
function initializeOrderTables(orderid){
	// Define columns
	
}

// Function to initialize select2 for vaultsearch 
function initializeSelect2(){
	$('#search').select2({
		theme: 'bootstrap-5',
		width: "100%",
		placeholder: "Search by order, customer name, or vault...",
		ajax: {
			type: "POST",
			url: '/scripts/php/vaultsearch.php',
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
}

// Function to initialize various aspects of order screen
function initorderfull(orderid) {
	fillreginfo(orderid);
	fillcustinfo(orderid);
	initializeSelect2();
	custsearch();
	initializeItemTable(orderid);
}

// Function to initialize various aspects of NEW order screen
function initordernew(orderid) {
	initializeSelect2();
	custsearch();
	$('#reginput').val(orderid);
}


// Function to fill customer id fields
function fillcustinfo(orderid){
	var formData ={
		orderid: orderid,
	};
	
	// Get cust values
	$.ajax({
		type: "POST",
		url: '/scripts/php/custinfo.php',
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
}

// function to initialize and handle customer select2
function custsearch() {	
	// custid select2
	$("#custidinput").select2({
		theme: 'bootstrap-5',
		width: "100%",
		placeholder: "Select existing customer...",
		ajax: {
			type: "POST",
			url: '/scripts/php/custinfo.php',
			data: function(term){
				return term;
			},
			dataType: "json",
			encode: true,
			processResults: function (data){
				return data;
			}
		}
	});
	
	// Select 2 for states
	$('#custstateinput').select2({
		theme: 'bootstrap-5',
		placeholder: "Select state"
	});
	
	// Select 2 for countries
	$('#custcountryinput').select2({
		theme: 'bootstrap-5',
		placeholder: "Select country"
	});
}

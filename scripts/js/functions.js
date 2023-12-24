// JavaScript Document containing functions

// Function to initialize various aspects of order screen
function initorderfull(orderid) {
	fillreginfo(orderid);
	fillcustinfo(orderid);
	initializeSelect2();
	custsearch();
	initializeItemTable(orderid);
	initpdforder(orderid);
	initializeHistTable(orderid);
}

// Function to handle qr and pdf generation for orders
function initpdforder (orderid) {
	
	// prepend O. for orderqr
	let QRid = "O_" + orderid;
	
	// Call to GenQR function for QRCode
	GenQR(QRid).then(function(result){
		let qrformdata = {
			dataurl: result,
			orderid: orderid
		}
		$.ajax({
			url: '/scripts/php/pdfgen.php',
			type: 'POST',
			data: qrformdata,
			dataType: "json",
			encode: true,
		}).done(function (results){
			let width = $('#printbtn').width();
			let height = $('#middle').height();
			$('#pdfframe').attr('style','width:' + width + 'px; height:' + height + 'px;');
			$('#pdfframe').attr('src', 'https://docs.google.com/gview?url=https://surestore.store/QR/' + results + '&embedded=true');

		})
	})
}

function pdfallorder (orderid) {
	
	// prepend O. for orderqr
	let QRid = "O_" + orderid;
	
	// array for item ajax form
	let itemformdata = {
		orderid: orderid,
	}
	
	// Array to fill with item qr codes
	let qrformdata = {
		orderid: orderid,
	}
	
	let itemqr = {};
	
	$.ajax({
		url: '/scripts/php/iteminfo.php',
		type: "POST",
		data: itemformdata,
		dataType: "json",
		encode: true
	}).done(function (results){
		for (let item of results) {
			let itemQRid = "I_" + item["itemid"];
			GenQR(itemQRid).then(function(qrresult){
				let itemid = item["itemid"];
				itemqr[itemid] = qrresult;
			})
		}
		qrformdata["itemQR"] = itemqr;
		GenQR(QRid).then(function(result){
			qrformdata["orderqr"] = result;
			console.log(qrformdata);
			$.ajax({
				url: '/scripts/php/pdfgenall.php',
				type: 'POST',
				data: qrformdata,
				dataType: "json",
				encode: true,
			}).done(function (results){
				console.log(results);
			})
		}) 
		
	});
	
	// Call to GenQR function for QRCode

}

// Function to initialize various aspects of NEW order screen
function initordernew(orderid) {
	initializeSelect2();
	custsearch();
	$('#reginput').val(orderid);
}

// Function to initialize DataTables for orderhist table
function initializeHistTable(orderid) {
	let columnDefs = [
		{
			data: "histtime",
			title: "Date & Time",
			type: "readonly"
		},
		{
			data: "histdesc",
			title: "Description"
		}
	];
	
	let formData ={
		orderid: orderid,
	};
	
	$("#histheading").text("Order: " + orderid + " History");
	
	$.ajax({
		url: '/scripts/php/orderhist.php',
		type: 'POST',
		data: formData,
		dataType: "json",
		encode: true,
	}).done(function(data){
		$('#histtab').DataTable({
			columns: columnDefs,
			data: data,
			select: 'single'
		});
	});
}

// Function to initialize DataTables for itemid table
function initializeItemTable(itemorderid) {
	// Define columns
	let columnDefs = [
		{
			data: "itemid",
			title: "ID",
			type: "readonly"
		},
		{
			data: "itemdesc",
			title: "Item Description",
		},
		{
			data: "itemvault",
			title: "Item Vault",
			type: "select",
			select2: {
				width: "100%",
				placeholder: "Unchanged",
				ajax: {
					type: "POST",
					url: '/scripts/select2scripts/vaultlist.php',
					data: function(term){
						return term;
					},
					dataType: "json",
					encode: true,
					processResults: function (data) {
						return data;
					}
				}
			}
		},
		{
			data: "itemloose",
			title: "Item Loose",
			type: "select",
			select2: {
				width: "100%",
				placeholder: "Unchanged",
				ajax: {
					type: "POST",
					url: '/scripts/select2scripts/looselist.php',
					data: function(term){
						return term;
					},
					dataType: "json",
					encode: true,
					processResults: function (data) {
						return data;
					}
				}
			}
		},
		{
			data: "itemvaulter",
			title: "Vaulter",
			type: "select",
			select2: {
				width: "100%",
				placeholder: "Unchanged",
				ajax: {
					type: "POST",
					url: '/scripts/select2scripts/vaulterlist.php',
					data: function(term){
						return term;
					},
					dataType: "json",
					encode: true,
					processResults: function (data) {
						return data;
					}
				}
			}
		}
	];
	
	let formData ={
		orderid: itemorderid,
	};
	$.ajax({
		url: '/scripts/php/iteminfo.php',
		type: 'POST',
		data: formData,
		dataType: "json",
		encode: true,
	}).done(function(data){
		$('#iteminfo').DataTable({
			"sPaginationType": "full_numbers",
			columns: columnDefs,
			data: data,
			dom: 'Bfrtip',
			select: 'single',
			responsive: true,
			altEditor: true,
			buttons: [
				{
					text: 'Add',
					name: 'add'
				},
				{
					extend: 'selected',
					text: 'Edit',
					name: 'edit'
				},
				{
					extend: 'selected',
					text: 'Delete',
					name: 'delete'
				},
				{
					text: 'Refresh',
					name: 'refresh'
				},
				{
					text: 'Print Locator',
					name: 'print'
				}
			],
			onAddRow: function(datatable, rowdata, success, error) {
				
				if (rowdata["itemvault"] != null) {
					rowdata["itemvault"] = $("#select2-itemvault-container").text();
				}
				
				if (rowdata["itemloose"] != null) {
					rowdata["itemloose"] = $("#select2-itemloose-container").text();
				}
				
				if (rowdata["itemvaulter"] != null) {
					rowdata["itemvaulter"] = $("#select2-itemvaulter-container").text();
				}
				
				rowdata["itemorder"] = itemorderid;
				$.ajax({
					url: '/scripts/editorscripts/itemadd.php',
					type: 'POST',
					dataType: 'json',
					encode: true,
					data: rowdata,
					success: success,
					error: error
				}).done(function(returndata){
					if (returndata.errors){
						alert("Item add found. Please contact system administrator.");
					}
				});
			},
			onDeleteRow: function(datatable, rowdata, success, error) {
				let delitemid ={
					itemid: $("tr.selected > td").eq(0).text(),
					itemorder: itemorderid
				}
				$.ajax({
					url: '/scripts/editorscripts/itemdel.php',
					type: 'POST',
					dataType: 'json',
					encode: true,
					data: delitemid,
					success: success,
					error: error
				}).done(function(returndata){
					if (returndata.errors){
						alert("Item delete failed. Please contact system administrator.");
					}
				});
			},
			onEditRow: function(datatable, rowdata, success, error) {
				if (rowdata["itemvault"] == null && rowdata["itemloose"] == null) {
					rowdata["itemvault"] = $("tr.selected > td").eq(2).text();
				} else if (rowdata["itemvault"] == null && rowdata["itemloose"] != null){
					rowdata["itemvault"] = "";
				} else {
					rowdata["itemvault"] = $("#select2-itemvault-container").text();
				}
				
				if (rowdata["itemloose"] == null && rowdata["itemvault"] == null) {
					rowdata["itemloose"] = $("tr.selected > td").eq(3).text();
				} else if (rowdata["itemloose"] == null && rowdata["itemvault"] != null){
					rowdata["itemloose"] = "";
				}  else {
					rowdata["itemloose"] = $("#select2-itemloose-container").text();
				}
				
				if (rowdata["itemdesc"] == null) {
					rowdata["itemdesc"] = $("tr.selected > td").eq(1).text();
				} 
				
				if (rowdata["itemvaulter"] == null) {
					rowdata["itemvaulter"] = $("tr.selected > td").eq(4).text();
				} else {
					rowdata["itemvaulter"] = $("#select2-itemvaulter-container").text();
				}
				rowdata["itemorder"] = itemorderid;
				$.ajax({
					url: '/scripts/editorscripts/itemedit.php',
					type: 'POST',
					dataType: 'json',
					encode: true,
					data: rowdata,
					success: success,
					error: error
				}).done(function(returndata){
					if (returndata.errors){
						alert("Item edit failed. Please contact system administrator.");
					}
				});
			}
		});
	});
} // End of function to initialize DataTables for itemid table

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

// Function to fill order id fields
function fillreginfo(orderid){
	let formData ={
		orderid: orderid,
	};
	$.ajax({
		url: "/scripts/php/reginfo.php",
		type: "POST",
		data: formData,
		dataType: "json",
		encode: true
	}).done(function (data){
		
		// Fill form value fields with appropriate values
		$('#reginput').val(data["orderid"]);
		$("#hiddenorderid").val(data["orderid"]);
		$('#regwhinput').val(data["orderwh"]);
		$('#regdateininput').val(data["datein"]);
		$('#regdatemodinput').val(data["histtime"]);
		$('#regweightinput').val(data["weight"]);
		
		// Fill locator sheet with appropriate values
		$("#locorderid").text("Orderid: " + data["orderid"]);
		$("#locorderweight").text("Weight: " + data["weight"]);
		$("#locin").text("Order in: " + data["datein"]);
		
		// Check if order is closed
		if (data["dateout"] != null){
			$('#regdateoutinput').val(data["dateout"]);
		}
		
		// Check if order is mil, toggle button if so
		if (data["ordermil"] == "t") {
			$("#milcheck").attr("checked", true);
		}
	});	
}

// Function to fill customer id fields
function fillcustinfo(orderid){
	let formData ={
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
		
		// Fill form fields with appropriate values
		$('#businessinput').val(data["custbusiness"]);
		$('#cust-tn').val(data["custtn"]);
		$('#custfirstinput').val(data["custfirst"]);
		$('#custlastinput').val(data["custlast"]);
		$('#custaddyinput').val(data["custaddress"]);
		$('#custcityinput').val(data["custcity"]);
		$('#custzipinput').val(data["custzip"]);
		$('#hiddencustid').val(data["custid"]);
		
		// Fill locator sheet with appropriate values
		$("#loccustname").text("Customer: " + data["custfirst"] + " " + data["custlast"]);
		
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

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
	whsearch();
	initcustorderstab(orderid);
}

// Function to initialize session checker
function initSessionChecker() {
	$('body').click(function() {
		
		$.ajax({
			type: "POST",
			dataType: "json",
			encode: true,
			url: "/scripts/php/verifysession.php"
		}).done(function(result) {
			if (result["success"] == false){
				window.location.replace("https://surestore.store/");
			}
		});
		
	})
}

// Function to initialize manage vaulter page and table
function initManageVaulter() {
	let columnDefs = [
		{
			data: "vaulterid",
			title: "Vaulter ID",
			type: "readonly"
		},
		{
			data: "vaulterfirst",
			title: "First Name",
		},
		{
			data: "vaulterlast",
			title: "Last Name",
		}
	];
	
	//ajax for vaulter table
	$.ajax({
		url: "/scripts/php/vaulterinfo.php",
		type: 'POST',
		dataType: 'json',
		encode: true,
	}).done(function (data){
		$("#vaultertab").DataTable({
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
				}
			],
			onAddRow: function(datatable, rowdata, success, error){
				$.ajax({
					url: '/scripts/editorscripts/vaulteradd.php',
					type: 'POST',
					dataType: 'json',
					encode: true,
					data: rowdata,
					success: success,
					error: error
				}).done(function (returndata){
					if (returndata.errors){
						alert("Vaulter add failed. Please contact system administrator.");
					}
				});
			},
			onDeleteRow: function(datatable, rowdata, success, error) {
				
				// assign whid to be passed
				let delvaulterid = {
					vaulterid: $("tr.selected > td").eq(0).text()
				}
				
				// ajax for delete
				$.ajax({
					url: '/scripts/editorscripts/vaulterdel.php',
					type: 'POST',
					dataType: 'json',
					encode: true,
					data: delvaulterid,
					success: success,
					error: error
				}).done(function(returndata) {
					if (returndata.errors){
						alert("Vaulter delete failed. Please contact system administrator.");
					}
				});
				
			},
			onEditRow: function(datatable, rowdata, success, error) {
				rowdata["oldid"] = $("tr.selected > td").eq(0).text();
				console.log(rowdata);
				// ajax for wh edit
				$.ajax({
					url: '/scripts/editorscripts/vaulteredit.php',
					type: 'POST',
					dataType: 'json',
					encode: true,
					data: rowdata,
					success: success,
					error: error
				}).done(function(returndata) {
					if (returndata.errors){
						alert("Vaulter edit failed. Please contact system administrator.");
					}
				});
			}
		})
	})
	
} // end of function to initialize manage vaulter page and table

// Function to initialize manage wh page and table
function initManageWh() {
	let columnDefs = [
		{
			data: "whid",
			title: "Warehouse ID",
		},
		{
			data: "whaddress",
			title: "Street Address",
		},
		{
			data: "whcity",
			title: "City",
		},
		{
			data: "whstate",
			title: "State",
			pattern: '[A-Za-z][A-Za-z]',
		},
		{
			data: "whzip",
			title: "Zip",
		},
		{
			data: "whcountry",
			title: "Country",
			pattern: '[A-Za-z][A-Za-z][A-Za-z]'
		},
	];
	
	//ajax for wh table
	$.ajax({
		url: "/scripts/php/whinfo.php",
		type: 'POST',
		dataType: 'json',
		encode: true,
	}).done(function (data){
		$("#whtab").DataTable({
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
				}
			],
			onAddRow: function(datatable, rowdata, success, error){
				$.ajax({
					url: '/scripts/editorscripts/whadd.php',
					type: 'POST',
					dataType: 'json',
					encode: true,
					data: rowdata,
					success: success,
					error: error
				}).done(function (returndata){
					if (returndata.errors){
						alert("Warehouse add failed. Please contact system administrator.");
					}
				});
			},
			onDeleteRow: function(datatable, rowdata, success, error) {
				
				// assign whid to be passed
				let delwhid = {
					whid: $("tr.selected > td").eq(0).text()
				}
				
				// ajax for delete
				$.ajax({
					url: '/scripts/editorscripts/whdel.php',
					type: 'POST',
					dataType: 'json',
					encode: true,
					data: delwhid,
					success: success,
					error: error
				}).done(function(returndata) {
					if (returndata.errors){
						alert("Warehouse delete failed. Please contact system administrator.");
					}
				});
				
			},
			onEditRow: function(datatable, rowdata, success, error) {
				rowdata["oldid"] = $("tr.selected > td").eq(0).text();
				
				// ajax for wh edit
				$.ajax({
					url: '/scripts/editorscripts/whedit.php',
					type: 'POST',
					dataType: 'json',
					encode: true,
					data: rowdata,
					success: success,
					error: error
				}).done(function(returndata) {
					if (returndata.errors){
						alert("Warehouse edit failed. Please contact system administrator.");
					}
				});
			}
		})
	})
	
} // end of function to initialize manage wh page and table

// function to initialize manage loc page and tables
function initManageLoc() {
	// Define columns for vault table
	let columnDefsVault = [
		{
			data: "vaultid",
			title: "Vault ID"
		},
		{
			data: "vaultwh",
			title: "Vault Warehouse",
			type: "select",
			select2:{
				width: "100%",
				placeholder: "Unchanged",
				ajax: {
					type: "POST",
					url: '/scripts/select2scripts/whlist.php',
					data: function(term) {
						return term;
					},
					dataType: "json",
					encode: true,
					processResults: function(data) {
						return data;
					}
				}
				
			}
		},
		{
			data: "vaultrow",
			title: "Vault Row",
			placeholder: "Unchanged"
		},
		{
			data: "disabled",
			title: "Vault Status",
			placeholder: "Unchanged",
			type: "select",
			select2: {
				width: "100%",
				placeholder: "Unchanged",
			},
			options: {
				"t":"Disabled",
				"f":"Enabled"
			}
		}
	];
	
	// define columns for loose table
	let columnDefsLoose = [
		{
			data: "looseid",
			title: "Loose ID"
		},
		{
			data: "loosewh",
			title: "Loose Warehouse",
			type: "select",
			select2:{
				width: "100%",
				placeholder: "Unchanged",
				ajax: {
					type: "POST",
					url: '/scripts/select2scripts/whlist.php',
					data: function(term) {
						return term;
					},
					dataType: "json",
					encode: true,
					processResults: function(data) {
						return data;
					}
				}
				
			}
		},
		{
			data: "disabled",
			title: "Loose Status",
			placeholder: "Unchanged",
			type: "select",
			select2: {
				width: "100%",
				placeholder: "Unchanged",
			},
			options: {
				"t":"Disabled",
				"f":"Enabled"
			}
		}
	];
	
	// ajax for vault table
	$.ajax({
		url: '/scripts/php/vaulttab.php',
		type: 'POST',
		dataType: "json",
		encode: true,
	}).done(function (data){
		$("#vaulttab").DataTable({
			"sPaginationType": "full_numbers",
			columns: columnDefsVault,
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
					name: 'print',
					className : 'vaultlocprint'
				}
			],
			onAddRow: function(datatable, rowdata, success, error){
				rowdata["vaultwh"] = $("#select2-vaultwh-container").text();
				$.ajax({
					url: '/scripts/editorscripts/vaultadd.php',
					type: 'POST',
					dataType: 'json',
					encode: true,
					data: rowdata,
					success: success,
					error: error
				}).done(function (returndata){
					if (returndata.errors){
						alert("Vault add failed. Please contact system administrator.");
					}
				});
			},
			onDeleteRow: function(datatable, rowdata, success, error) {
				
				// assign vaultid to be passed
				let delvaultid = {
					vaultid: $("tr.selected > td").eq(0).text()
				}
				
				// ajax for delete
				$.ajax({
					url: '/scripts/editorscripts/vaultdel.php',
					type: 'POST',
					dataType: 'json',
					encode: true,
					data: delvaultid,
					success: success,
					error: error
				}).done(function(returndata) {
					if (returndata.errors){
						alert("Vault delete failed. Please contact system administrator.");
					}
				});
				
			},
			onEditRow: function(datatable, rowdata, success, error) {
				if (rowdata["vaultwh"] != null){
					rowdata["vaultwh"] = $("#select2-vaultwh-container").text();
				}
				// assign values for empty edits
				if (rowdata["vaultid"] == null) {
					rowdata["vaultid"] = $("tr.selected > td").eq(0).text();
				} else {
					rowdata["oldid"] = $("tr.selected > td").eq(0).text();
				}
				if (rowdata["vaultwh"] == null) {
					rowdata["vaultwh"] = $("tr.selected > td").eq(1).text();
				} else {
					rowdata["oldwh"] = $("tr.selected > td").eq(1).text();
				}
				if (rowdata["vaultrow"] == null) {
					rowdata["vaultrow"] = $("tr.selected > td").eq(3).text();
				}
				if (rowdata["disabled"] == null) {
					rowdata["disabled"] = $("tr.selected > td").eq(3).text();
				}
				
				
				// ajax for vault edit
				$.ajax({
					url: '/scripts/editorscripts/vaultedit.php',
					type: 'POST',
					dataType: 'json',
					encode: true,
					data: rowdata,
					success: success,
					error: error
				}).done(function(returndata) {
					if (returndata.errors){
						alert("Vault edit failed. Please contact system administrator.");
					}
				});
			}
		});
	});
	
	// ajax for loose table
	$.ajax({
		url: '/scripts/php/loosetab.php',
		type: 'POST',
		dataType: "json",
		encode: true,
	}).done(function (data){
		$("#loosetab").DataTable({
			"sPaginationType": "full_numbers",
			columns: columnDefsLoose,
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
					name: 'print',
					className : 'looselocprint'
				}
			],
			onAddRow: function(datatable, rowdata, success, error){
				rowdata["loosewh"] = $("#select2-loosewh-container").text();
				$.ajax({
					url: '/scripts/editorscripts/looseadd.php',
					type: 'POST',
					dataType: 'json',
					encode: true,
					data: rowdata,
					success: success,
					error: error
				}).done(function (returndata){
					if (returndata.errors){
						alert("Loose add failed. Please contact system administrator.");
					}
				});
			},
			onDeleteRow: function(datatable, rowdata, success, error) {
				
				// assign looseid to be passed
				let dellooseid = {
					looseid: $("tr.selected > td").eq(0).text()
				}
				
				// ajax for delete
				$.ajax({
					url: '/scripts/editorscripts/loosedel.php',
					type: 'POST',
					dataType: 'json',
					encode: true,
					data: dellooseid,
					success: success,
					error: error
				}).done(function(returndata) {
					if (returndata.errors){
						alert("Loose delete failed. Please contact system administrator.");
					}
				});
				
			},
			onEditRow: function(datatable, rowdata, success, error) {
				if (rowdata["loosewh"] != null){
					rowdata["loosewh"] = $("#select2-loosewh-container").text();
				}
				// assign values for empty edits
				if (rowdata["looseid"] == null) {
					rowdata["looseid"] = $("tr.selected > td").eq(0).text();
				} else {
					rowdata["oldid"] = $("tr.selected > td").eq(0).text();
				}
				if (rowdata["loosewh"] == null) {
					rowdata["loosewh"] = $("tr.selected > td").eq(1).text();
				} else {
					rowdata["oldwh"] = $("tr.selected > td").eq(1).text();
				}
				if (rowdata["disabled"] == null) {
					rowdata["disabled"] = $("tr.selected > td").eq(2).text();
				}
				
				// ajax for loose edit
				$.ajax({
					url: '/scripts/editorscripts/looseedit.php',
					type: 'POST',
					dataType: 'json',
					encode: true,
					data: rowdata,
					success: success,
					error: error
				}).done(function(returndata) {
					if (returndata.errors){
						alert("Loose edit failed. Please contact system administrator.");
					}
				});
			}
		});
	});
} // end of function to initialize manage loc page and tables

// Function to initialize QR scanner
function initializeQRscanner() {
	
	$("#modbody").html('<div id="qrscanner"><video id="qrscanner-video"></video></div>');
	const videoElem = document.getElementById('qrscanner-video');
	const qrScanner = new QrScanner(
		videoElem,
		result => processScan(result, qrScanner),
		{
			highlightScanRegion: true,
        	highlightCodeOutline: true,
		}
	);
	qrScanner.start();
	
	// Listener for scan close button
	$('body').on("click", "#closescan", function(){
		qrScanner.stop();
	}); // end of listener for scan clsoe button
} // end of function to initialize qr scanner

// Function to initialize QR scanner for location update
function initializeQRlocUpdate() {
	
	$("#modbody").html('<div id="qrscanner"><video id="qrscanner-video"></video></div>');
	const videoElem = document.getElementById('qrscanner-video');
	const qrScanner = new QrScanner(
		videoElem,
		result => locUpdate(result, qrScanner),
		{
			highlightScanRegion: true,
        	highlightCodeOutline: true,
		}
	);
	qrScanner.start();
	
	// Listener for scan close button
	$('body').on("click", "#closescan", function(){
		qrScanner.stop();
	}); // end of listener for scan clsoe button
} // end of function to initialize QR scanner for location update

// function to update location of item
function locUpdate(result, qrScanner) {
	$('#scanLocModal').modal('toggle');
	qrScanner.stop();
	
	let resString = result["data"];
	let resArray = resString.split("_");
	let resType = resArray[0];
	let resID = resArray[1];
	let formData = {
		itemid: $("#hiddenitemid").val(),
		locid: resID,
		loctype: resType
	}
	if (resType == "L" || resType == "V"){
		$.ajax({
			url: '/scripts/php/updateloc.php',
			type: 'POST',
			data: formData,
			dataType: "json",
			encode: true,
		}).done(function () {
			let orderid = $("#itemorder").val();
			$.get('/snippets/vaultinfo/vaultinfo.php', function(data) {
				$("#appcontainer").html(data);
			}).done(function () {
				$.get('/snippets/vaultinfo/vaultinfoleft.php', function(data) {
					$("#left").html(data);
				}).done(function() {
					$.get('/snippets/vaultinfo/vaultinfomiddle.php', function(data) {
						$("#middle").html(data);
					}).done(function (){
						$.get('/snippets/vaultinfo/vaultinforight.php', function(data) {
							$("#right").html(data);
							initorderfull(orderid);						
						})
					})
				})
			})	
		})
	}
}

// Function to process QR scan 
function processScan(result, qrScanner) {
	$('#scanModal').modal('toggle');
	qrScanner.stop();
	let resString = result["data"];
	let resArray = resString.split("_");
	let resType = resArray[0];
	let resID = resArray[1];
	if(resType == "O") {
		
		let orderid = resID;
		$.get('/snippets/vaultinfo/vaultinfo.php', function(data) {
			$("#appcontainer").html(data);
		}).done(function () {
			$.get('/snippets/vaultinfo/vaultinfoleft.php', function(data) {
				$("#left").html(data);
			}).done(function() {
				$.get('/snippets/vaultinfo/vaultinfomiddle.php', function(data) {
					$("#middle").html(data);
				}).done(function (){
					$.get('/snippets/vaultinfo/vaultinforight.php', function(data) {
						$("#right").html(data);
						initorderfull(orderid);						
					})
				})
			})
		})	
	}
	
	if(resType == "I") {
		let itemid = resID;
		$.get('/snippets/itemmenu.php', function(data) {
			$("#appcontainer").html(data);
		}).done(function() {
			$("#hiddenitemid").val(itemid);
			let formData = {
				itemid: itemid
			}
			$.ajax({
				url: '/scripts/php/itemmenuinfo.php',
				type: 'POST',
				data: formData,
				dataType: "json",
				encode: true,
			}).done(function (results) {
				$("#itemorder").val(results["itemorder"]);
				$("#itemcust").val(results["itemcust"]);
				$("#itemloc").val(results["itemloc"]);
				$("#itemvaulter").val(results["itemvaulter"]);
				$("#itemdesc").val(results["itemdesc"]);
			});
		})
	}
	
	if(resType == "L" || resType == "V") {
		$.get('/snippets/vaultinfo/vaultinfo.php', function(data) {
			$("#appcontainer").html(data);
		}).done(function(){
			$.get('/snippets/locationmenu.php', function(data) {
				$("#middle").html(data);
			}).done(function (){
				initLocItemTab(resID);
			})
		})

	}
	
} //end of function to process QR scan 

function initLocItemTab(resid) {
	let columnDefs = [
		{
			data: "itemorder",
			title: "Order",
			type: "readonly"
		},
		{
			data: "itemdesc",
			title: "Item Description",
			type: "readonly"
		}
	];
	
	let formData = {
		locid: resid,
	}
	
	$("#locitemheading").text("Items in " + resid);
	
	$.ajax({
		url: '/scripts/php/locitems.php',
		type: "POST",
		data: formData,
		dataType: "json",
		encode: true
	}).done(function(data) {
		$('#locitemtable').DataTable({
			columns: columnDefs,
			data: data,
			select: 'single'
		});
	});
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
			let height = $('#reginfoform').height();
			$('#pdfframe').attr('style','width:' + width + 'px; height:' + height + 'px;');
			$('#pdfframe').attr('src', 'https://surestore.store/QR/' + results);
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
			$.ajax({
				url: '/scripts/php/pdfgenall.php',
				type: 'POST',
				data: qrformdata,
				dataType: "json",
				encode: true,
			}).done(function (){
				const pdfWindow = window.open('https://surestore.store/QR/' + orderid + '.pdf').print();
			});
		}) 
	});
	
	// Call to GenQR function for QRCode

}

// Function to print vault pdf
function pdfvault(vaultid) {
	let locQR = "V_" + vaultid;
	let formData ={
		locid: vaultid,
	}
	GenQR(locQR).then(function(qrresult) {
		formData["locqr"] = qrresult;
		$.ajax({
			url: "/scripts/php/locpdf.php",
			type: "POST",
			data: formData,
			dataType: "json",
			encode: true
		}).done(function (){
			const pdfWindow = window.open('https://surestore.store/QR/' + vaultid + '.pdf').print();
		});
	})
}

// Function to print loose pdf
function pdfloose(looseid) {
	let locQR = "L_" + looseid;
	let formData ={
		locid: looseid,
	}
	GenQR(locQR).then(function(qrresult) {
		formData["locqr"] = qrresult;
		$.ajax({
			url: "/scripts/php/locpdf.php",
			type: "POST",
			data: formData,
			dataType: "json",
			encode: true
		}).done(function (){
			const pdfWindow = window.open('https://surestore.store/QR/' + looseid + '.pdf').print();
		});
	})
}

// Function to print item pdf
function pdfitem(itemid) {
	
	// prepend I_ for itemqr
	let itemQR = "I_" + itemid;
	let formData ={
		itemid: itemid,
	}
	GenQR(itemQR).then(function(qrresult){
		formData["itemqr"] = qrresult;
		$.ajax({
			url: "/scripts/php/itempdf.php",
			type: "POST",
			data: formData,
			dataType: "json",
			encode: true
		}).done(function (){
			const pdfWindow = window.open('https://surestore.store/QR/' + itemid + '.pdf').print();
		});
	});
}

// Function to initialize various aspects of NEW order screen
function initordernew(orderid) {
	initializeSelect2();
	custsearch();
	whsearch();
	$('#reginput').val(orderid);
}

// Function to initialize DataTables for custorders table
function initcustorderstab(orderid) {
	
	// NOTE: custorders Modal heading is handled in fillcustinfo function
	// Define Columns for table
	let columnDefs = [
		{
			data: "orderid",
			title: "Order ID"
		},
		{
			data: "orderwh",
			title: "Warehouse"
		}
	];
	
	// Form data for ajax req
	let formData ={
		orderid: orderid,
	};
	
	// Ajax to get customer orders and populate table
	$.ajax({
		url: '/scripts/php/custorders.php',
		type: 'POST',
		data: formData,
		dataType: "json",
		encode: true,
	}).done(function(data) {
		$('#custorderstab').DataTable({
			columns: columnDefs,
			data: data,
			select: 'single'
		});
	});
} // End of Function to initialize DataTables for custorders table

// Function to initialize openvaults table
function initOpenVaultsTable(orderwh){
	$("#openvaultsheading").text("Open Vaults at " + orderwh);
	
	let columnDefs = [
		{
			data: "vaultid",
			tite: "Vault ID",
			type: "readonly"
		},
		{
			data: "vaultrow",
			title: "Vault Row",
			type: "readonly"
		}
	];
	
	let formData ={
		whid: orderwh,
	};
	
	$.ajax({
		url: '/scripts/php/emptyvaults.php',
		type: 'POST',
		data: formData,
		dataType: 'json',
		encode: true,
	}).done(function(data){
		$('#openvaultstab').DataTable({
			columns: columnDefs,
			data: data,
			select: 'single'
		});
	}); 
	
} // end of function to initialize openvaults table

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

// Function to initialize datatables for all hist table
function initializeAllHistTable() {
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
	
	$("#histheading").text("All History");
	
	$.ajax({
		url: '/scripts/php/allhist.php',
		type: 'POST',
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
		},
		{
			data: "datein",
			title: "Item In",
			type: "date",
		},
		{
			data: "dateout",
			title: "Item Out",
			type: "date",
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
					name: 'print',
					className : 'itemlocprint'
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
						alert("Item add failed. Please contact system administrator.");
					} else {
						initpdforder(itemorderid);
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
					} else {
						initpdforder(itemorderid);
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
					} else {
						initpdforder(itemorderid);
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
		minimumInputLength: 2,
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
		var newOption = new Option(data["orderwh"]);
		$('#regwhinput').append(newOption).trigger('change');
		$('#regdateininput').val(data["datein"]);
		$('#regdatemodinput').val(data["histtime"]);
		$('#regweightinput').val(data["weight"]);
		
		if (data["sitex"] != null) {
			$('#sitexcol').html('<div class="form-group" id="sitex"><input type="date" class="form-control shadow-sm" id="sitexinput"><small id="sitexHelp" class="form-text text-muted">Expiration Date</small></div>');
			$('#sitexinput').val(data["sitex"]);
			$('#sitex').removeAttr('hidden');
			
		}
		
		// Check if order is closed
		if (data["dateout"] != null){
			$('#regdateoutinput').val(data["dateout"]);
		}
		if (data["valtype"] == "60l") {
			$("#valtypeselect").val("60l").change();
			let value = $('#regweightinput').val() * 0.6;
			value = value.toFixed(2);
			$("#regvalueinput").val("$" + value);
			$("#regvalueinput").prop('disabled', true);
			$("#regvalueHelp").text("Value (Automatic)");
		}
		
		if (data["valtype"] == "nts") {
			let value = $('#regweightinput').val() * 6.0;
			if (value < 7500){
				value = 7500;
			}
			if (value > 75000){
				value = 75000;
			}
			value = value.toFixed(2);
			$("#regvalueinput").val("$" + value);
			$("#regvalueinput").prop('disabled', true);
			$("#regvalueHelp").text("Value (Automatic)");
		}
		
		if (data["valtype"] == "frc") {
			$("#valtypeselect").val("frc").change();
			$("#regvalueinput").val(data["orderval"]);
			$("#regvalueinput").prop('disabled', false);
			$("#regvalueHelp").text("Value (Required)");	
		}
		
		if (data["valtype"] == "oth") {
			$("#valtypeselect").val("oth").change();
			$("#regvalueinput").val(data["orderval"]);
			$("#regvalueinput").prop('disabled', false);
			$("#regvalueHelp").text("Value (Required)");
		}
		
		// Check if ordertype is set
		if (data["ordertype"] != null){
			$('#selectedType').val(data["ordertype"]);
			$('#selectedType').text(data["ordertype"]);
		}
		
		if (data["ordertype"] == "SIRVA SIT") {
			$('#sitcheckrow').removeAttr("hidden");
			if(data["sitnum"] != null){
				$('#sitnuminput').val(data["sitnum"]);
				$('#sitcheck').prop("checked", true);
				$('#sitex').removeAttr("hidden");
				$('#sitnum').removeAttr("hidden");
				$("#sitnuminput").prop('disabled', false);
				$("#sitnuminput").prop('required', true);
				$("#sitnumHelp").text("SIT# (Required)");
				$("#sitexinput").prop('disabled', false);
				$("#sitexinput").prop('required', true);
			} else {
				$('#sitcheck').prop("checked", false);
				$('#sitex').attr("hidden", true);
				$('#sitnum').attr("hidden", true);
				$("#sitnuminput").prop('disabled', true);
				$("#sitnuminput").prop('required', false);
				$("#sitnumHelp").text("SIT# (Required)");
				$("#sitexinput").prop('disabled', true);
				$("#sitexinput").prop('required', false);
			}
			
		}
		
		if (data["ordertype"] == "MIL SIT") {
			$('#sitcheckrow').removeAttr("hidden");
			if(data["sitnum"] != null){
				$('#sitnuminput').val(data["sitnum"]);
				$('#sitcheck').prop("checked", true);
				$('#sitex').removeAttr("hidden");
				$('#sitnum').removeAttr("hidden");
				$("#sitnuminput").prop('disabled', false);
				$("#sitnuminput").prop('required', true);
				$("#sitnumHelp").text("SIT# (Required)");
				$("#sitexinput").prop('disabled', false);
				$("#sitexinput").prop('required', true);
			} else {
				$('#sitcheck').prop("checked", false);
				$('#sitex').attr("hidden", true);
				$('#sitnum').attr("hidden", true);
				$("#sitnuminput").prop('disabled', true);
				$("#sitnuminput").prop('required', false);
				$("#sitnumHelp").text("SIT# (Required)");
				$("#sitexinput").prop('disabled', true);
				$("#sitexinput").prop('required', false);
			}
		}
		
		if (data["ordertype"] == "NTS") {
			$('#sitex').removeAttr("hidden");
			$("#valtypeselect").val("nts").change();
			$("#sitnuminput").prop('disabled', true);
			$("#sitnuminput").prop('required', false);
			$("#sitnumHelp").text("SIT# (SIT Orders Only)");
			$("#sitexinput").prop('disabled', false);
			$("#sitexinput").prop('required', true);
		}
		
		if (data["ordertype"] == "PERM STG (HHG)") {
			$("#sitnuminput").prop('disabled', true);
			$("#sitnuminput").prop('required', false);
			$("#sitnumHelp").text("SIT# (SIT Orders Only)");
			$("#sitexinput").prop('disabled', true);
			$("#sitexinput").prop('required', false);
		}
		
		if (data["ordertype"] == "PERM STG (Non-HHG)") {
			$("#sitnuminput").prop('disabled', true);
			$("#sitnuminput").prop('required', false);
			$("#sitnumHelp").text("SIT# (SIT Orders Only)");
			$("#sitexinput").prop('disabled', true);
			$("#sitexinput").prop('required', false);
		}
		
		if (data["ordertype"] == "R19/Local Pickup") {
			$("#sitnuminput").prop('disabled', true);
			$("#sitnuminput").prop('required', false);
			$("#sitnumHelp").text("SIT# (SIT Orders Only)");
			$("#sitexinput").prop('disabled', true);
			$("#sitexinput").prop('required', false);
		}
		
		if (data["ordertype"] == "OTHER") {
			$("#sitnuminput").prop('disabled', true);
			$("#sitnuminput").prop('required', false);
			$("#sitnumHelp").text("SIT# (SIT Orders Only)");
			$("#sitexinput").prop('disabled', true);
			$("#sitexinput").prop('required', false);
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
		
		// NOTE: Following is for custorders modal
		// Fill custorders modal heading
		let custfirst = data["custfirst"];
		let custlast = data["custlast"];
		let custname = custfirst + " " + custlast;
		
		$("#custordersheading").text(custname + "'s Orders");
		
	});
}

function whsearch() {
	$('#regwhinput').select2({
		theme: 'bootstrap-5',
		width: "100%",
		placeholder: "Select Warehouse...",
		ajax: {
			type: "POST",
			url: '/scripts/select2scripts/whlist.php',
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

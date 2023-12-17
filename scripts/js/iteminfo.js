// JavaScript Document to handle item info

// Initialize DataTables
function initializeItemTable(itemorderid){
	// Define columns
	var columnDefs = [
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
	
	var formData ={
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
						alert("Item not found");
					}
				});
			},
			onDeleteRow: function(datatable, rowdata, success, error) {
				var delitemid ={
					itemid: $("tr.selected > td").eq(0).text(),
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
						alert("Item not found");
					}
				});
			},
			onEditRow: function(datatable, rowdata, success, error) {
				if (rowdata["itemvault"] == null) {
					rowdata["itemvault"] = $("tr.selected > td").eq(2).text();
				} else {
					rowdata["itemvault"] = $("#select2-itemvault-container").text();
				}
				
				if (rowdata["itemloose"] == null) {
					rowdata["itemloose"] = $("tr.selected > td").eq(3).text();
				} else {
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
						alert("Item not found");
					}
				});
			}
		});
	});
}
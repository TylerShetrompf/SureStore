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
			title: "Item Description"
		},
		{
			data: "itemvault",
			title: "Item Vault"
		},
		{
			data: "itemloose",
			title: "Item Loose"
		},
		{
			data: "itemvaulter",
			title: "Vaulter"
		}
	];
	
	var formData ={
		orderid: itemorderid,
	};
	$.ajax({
		url: '/scripts/iteminfo.php',
		type: 'POST',
		data: formData,
		dataType: "json",
		encode: true,
	}).done(function(data){
		console.log(data);
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
				console.log(rowdata);
				$.ajax({
					url: '/scripts/itemadd.php',
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
				$.ajax({
					url: '/scripts/itemdel.php',
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
			onEditRow: function(datatable, rowdata, success, error) {
				console.log(rowdata);
				$.ajax({
					url: '/scripts/itemedit.php',
					type: 'POST',
					dataType: 'json',
					encode: true,
					data: rowdata,
					success: success,
					error: error
				}).done(function(returndata){
					console.log(returndata);
					if (returndata.errors){
						alert("Item not found");
					}
				});
			}
		});
	});
}
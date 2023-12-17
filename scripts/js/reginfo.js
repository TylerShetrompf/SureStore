// JavaScript Document for reginfo page
function fillreginfo(orderid){
	var formData ={
		orderid: orderid,
	};
	$.ajax({
		url: "/scripts/php/reginfo.php",
		type: "POST",
		data: formData,
		dataType: "json",
		encode: true
	}).done(function (data){
		
		// Get modtime to correct format
		var timestamp = data["timezone"];
		timestamp = timestamp.replace(" ", "T");
		
		// Fill value fields with appropriate values
		$('#reginput').val(data["orderid"]);
		$('#regwhinput').val(data["orderwh"]);
		$('#regdateininput').val(data["datein"]);
		$('#regdatemodinput').val(timestamp);
		$('#regweightinput').val(data["weight"]);
		
		// Check if order is mil, toggle button if so
		if (data["ordermil"] == "t") {
			$("#milcheck").attr('checked', true);
		}
	});
	

}
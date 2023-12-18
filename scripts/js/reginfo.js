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
		var timestamp = data["histtime"];
		timestamp = timestamp.replace(" ", "T");
		
		// Fill value fields with appropriate values
		$('#reginput').val(data["orderid"]);
		$('#regwhinput').val(data["orderwh"]);
		$('#regdateininput').val(data["datein"]);
		$('#regdatemodinput').val(data["histtime"]);
		$('#regweightinput').val(data["weight"]);
		
		// Check if order is closed
		if (data["dateout"] != null){
			$('#regdateoutinput').val(data["dateout"]);
		}
		
		// Check if order is mil, toggle button if so
		if (data["ordermil"] == "t") {
			$("#milcheck").attr("checked", true);
		}
	});

	$("#milcheck").click(function (){
		if ($("#milcheck").attr("checked") == "checked"){
			$("#milcheck").attr("checked", false);
		} else if ($("#milcheck").attr("checked") == undefined){
			$("#milcheck").attr("checked", true);
		}
	});
	
	
	$('#reginfoform').submit(function (event){
		event.preventDefault();
		
		var regformdata ={
			oldorderid: orderid,
			orderid: $('#reginput').val(),
			orderwh: $('#regwhinput').val(),
			datein: $('#regdateininput').val(),
			weight: $('#regweightinput').val()
		}
		
		if ($('#regdateoutinput').val() != ""){
			regformdata["dateout"] = $('#regdateoutinput').val();
		}
		
		// Check if ordermil box is ticked and if so add to regformdata
		if ($("#milcheck").attr("checked") == "checked"){
			regformdata["ordermil"] = true;
		}
		
		$.ajax({
			url: "/scripts/php/updatereginfo.php",
			type: "POST",
			data: regformdata,
			dataType: "json",
			encode: true
		}).done(function (data){
			if (data["success"] == "false"){
				$("#reginfodiv").append('<div class="alert alert-danger" role="alert">Update failed. Please contact system administrator.</div>')
			} else {
				$.get('/snippets/vaultinfo/vaultinfo.html', function(data) {
					$("#appcontainer").html(data);
				})
		
				$.get('/snippets/vaultinfo/vaultinfoleft.html', function(data) {
					$("#left").html(data);
				}).done(function(){
					initializeItemTable(regformdata["orderid"]);
				})
				
				$.get('/snippets/vaultinfo/vaultinfomiddle.php', function(data) {
					$("#middle").html(data);
				}).done(function(){
					initializeSelect2();
					fillreginfo(regformdata["orderid"]);
					fillcustinfo(regformdata["orderid"]);
				})
			}
		});
		
	});
	
}
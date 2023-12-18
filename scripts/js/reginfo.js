// JavaScript Document for reginfo page
$(document).ready(function(){
	
	// Handler for military check switch
	$("body").on("click", "#milcheck", function (){
		if ($("#milcheck").attr("checked") == "checked"){
			$("#milcheck").attr("checked", false);
		} else if ($("#milcheck").attr("checked") == undefined){
			$("#milcheck").attr("checked", true);
		}
	});
	
	// handler for reg update form submissions
	$('body').on("submit", "#reginfoform", function (event){
		event.preventDefault();
		
		var regformdata ={
			oldorderid: $("#hiddenorderid").val(),
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
				$("#reginfodiv").append('<div class="alert alert-danger" role="alert">Update failed. Please contact system administrator.</div>');
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
							initorderfull(regformdata["orderid"]);
						})
					})
				})
			}
		});
		
	});
});
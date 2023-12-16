// JavaScript Document
function fillreginfo(orderid){
	var formData ={
		orderid: orderid,
	};
	$.ajax({
		url: "/scripts/php/reginfo.php"
		type:"POST",
		data: formData,
		dataType: "json",
		encode: true
	}).done(function (data){
		
	});
}
// JavaScript Document
function fillreginfo(orderid){
	var formData ={
		orderid: orderid,
	};
	$.ajax({
		url: "/scripts/php/reginfo.php"
		type:"POST",
		
	})
}
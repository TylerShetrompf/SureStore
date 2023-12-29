// JavaScript Document for pw reset
$(document).ready(function () {
	
	// listener for form submit
	$("body").on("submit", "#resetForm", function(event){
		event.preventDefault();
		
		let userid = $("#hiddenuserid").val();
		let actcode = $("#hiddenactcode").val();
		let pass1 = $("#pass1").val();
		let pass2 = $("#pass2").val();
		
		if (pass1 === pass2) {
			let formData ={
				userid: userid,
				actcode: actcode,
				password: pass1
			}
			
			$.ajax({
				url: '/scripts/php/setpassword.php',
				type: 'POST',
				dataType: "json",
				encode: true,
				data: formData
			}).done(function (result) {
				if (result["success"] == true) {
					$('#middle').html('<img class="mx-auto d-block" src="images/logoSmol.png" alt="SureStore Logo"><h1>Password Reset!</h1><p>Your SureStore password is now reset.</p><a href="https://surestore.store" class="btn btn-danger btn-large btn-block">Return to login</a>')
				} else {
					alert("Passwords reset failed, please contact your system administrator.");
				}
			})
			
		} else {
			alert("Passwords must match!");
		}
	})
})
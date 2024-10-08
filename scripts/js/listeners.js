// JavaScript Document containing jquery listeners
$(document).ready(function () {
	
	// Listener for resetpwbutton
	$("body").on("click", "#sendrespwButton", function(event) {
		event.preventDefault();
		let userid = $("#email").val();
		let formData = { 
			userid: userid,
		}
		$.ajax({
			type: "POST",
			data: formData,
			dataType: "json",
			encode: true,
			url: "/scripts/php/pwreset.php"
		}).done(function() {
			$.get("/snippets/resetsuccess.php", function(data) {
				$("#appcontainer").html(data);
			})
		})
	})
	
	// Listener for vault and loose manage button
	$("body").on("click", "#manageLocButton", function(event) {
		event.preventDefault();
		$.get("/snippets/manageloc.php", function(data) {
			$("#appcontainer").html(data);
			initManageLoc();
		})
	}); // end of listener for vault and loose manage button
	
	// Listener for vaulters manage button
	$("body").on("click", "#manageVaulterButton", function(event) {
		event.preventDefault();
		$.get("/snippets/managevaulter.php", function(data) {
			$("#appcontainer").html(data);
			initManageVaulter();
		})
	}); // end of listener for vaulters manage button
	
	// Listener for warehouse manage button
	$("body").on("click", "#manageWhButton", function(event) {
		event.preventDefault();
		$.get("/snippets/managewh.php", function(data) {
			$("#appcontainer").html(data);
			initManageWh();
		})
	}); // end of listener for warehouse manage button
	
	// Listener for reports button
	$("body").on("click", "#reportsButton", function(event) {
		event.preventDefault();
		$.get("/snippets/reports.php", function(data) {
			$("#appcontainer").html(data);
		})
	}); // end of listener for for reports button
	
	// Listener for report select
	$("body").on("submit", "#reportselectform", function(event) {
		event.preventDefault();
		//$('#reportModal').modal('toggle');
		if ($("#reportselect").val() == "whval"){
			$.ajax({
				type: "POST",
				url: "/scripts/reports/valuations.php"
			}).done(function(){
				window.open('/temp/valuations.csv', '_blank');
			})
		}
		
		if ($("#reportselect").val() == "sitex"){
			$.ajax({
				type: "POST",
				url: "/scripts/reports/expiredsit.php"
			}).done(function(){
				window.open('/temp/sitex.csv', '_blank');
			})
		}
		
		if ($("#reportselect").val() == "sitempty"){
			$.ajax({
				type: "POST",
				url: "/scripts/reports/emptysit.php"
			}).done(function(){
				window.open('/temp/sitempty.csv', '_blank');
			})
		}
		
		if ($("#reportselect").val() == "inout"){
			$.ajax({
				type: "POST",
				url: "/scripts/reports/inout.php"
			}).done(function(){
				window.open('/temp/inout.csv', '_blank');
			})
		}
		
		if ($("#reportselect").val() == "used"){
			$.ajax({
				type: "POST",
				url: "/scripts/reports/used.php"
			}).done(function(){
				window.open('/temp/used.csv', '_blank');
			})
		}
	}); // end of listener for report select
	
	// Listener for Order Info button on item menu
	$('body').on("click", "#infoOrder", function(event) {
		event.preventDefault();
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
	});
	
	// Listener for pdf print button
	$('body').on( "click", "#printbtn", function(event){
		event.preventDefault();
		let orderid = $("#reginput").val();
		const pdfWindow = window.open('https://surestore.store/QR/' + orderid + '.pdf').print();
	}); // end of listener for pdf print button
	
	// Listener for pdf print ALL button
	$('body').on( "click", "#printallbtn", function(event){
		event.preventDefault();
		let orderid = $("#reginput").val();
		pdfallorder(orderid);
	}); // end of listener for pdf print ALL button
	
	// Listener for print item locator
	$('body').on("click", ".itemlocprint", function(event) {
		event.preventDefault();
		let itemid = $("tr.selected > td").eq(0).text();
		pdfitem(itemid);
	}); // end of listener to print item locator
	
	// Listener for print vault locator
	$('body').on("click", ".vaultlocprint", function(event) {
		event.preventDefault();
		let locid = $("tr.selected > td").eq(0).text();
		pdfvault(locid);
	}); // end of listener to print vault locator
	
	// Listener for print loose locator
	$('body').on("click", ".looselocprint", function(event) {
		event.preventDefault();
		let locid = $("tr.selected > td").eq(0).text();
		pdfloose(locid);
	}); // end of listener to print vault locator
	
	// Listener for vault search selections
	$('body').on("change", "#search", function(event) {
		event.preventDefault();
		
		// Set content variable
		let content = $("#select2-search-container").text();
		
		// Narrow content down to array
		content = content.replace("Order: ", "");
		content = content.replace(" Customer: ",",");
		content = content.replace(" Vault: ",",");
		content = content.replace(" ",",");
		content = content.split(",");
		
		// Assign values to associative array
		let orderid = content[0];
		
		
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
	}); // end of listener for vault search selections
	
	
	// Listener to handle create order submit
	$("body").on("submit", "#neworderform", function (event){
		event.preventDefault();
		let formData ={
			custbusiness: $('#businessinput').val(),
			custtn : $('#cust-tn').val(),
			custfirst: $('#custfirstinput').val(),
			custlast: $('#custlastinput').val(),
			custaddress: $('#custaddyinput').val(),
			custcity: $('#custcityinput').val(),
			custzip: $('#custzipinput').val(),
			orderid: $('#reginput').val(),
			orderwh: $('#select2-regwhinput-container').text(),
			weight: $('#regweightinput').val(),
			custstate: $('#custstateinput').val(),
			custcountry: $('#custcountryinput').val(),
			ordertype: $('#typeselect').val(),
			valtype: $('#valtypeselect').val(),
			value: $('#regvalueinput').val(),
		}
		
		if ($("#hiddencustid").val()) {
			formData["custid"] = $("#hiddencustid").val();
		}
		
		if ($('#sitnuminput').val() != ""){
			formData["sitnum"] = $('#sitnuminput').val();
		}
		
		if ($('#sitexinput').val() != ""){
			formData["sitex"] = $('#sitexinput').val();
		}
		
		$.ajax({
			url: "/scripts/php/createorder.php",
			type: "POST",
			data: formData,
			dataType: "json",
			encode: true
		}).done(function (data) {
			if (data["success"] == "false") {
				$("#neworderdiv").prepend('<div class="alert alert-danger" role="alert"><h4 class="alert-heading">ERROR</h4><p>ORDER CREATION OR CUSTOMER CREATION HAS FAILED. YOUR CHANGES MAY NOT HAVE BEEN SAVED.</p><hr><p class="mb-0">PLEASE CONTACT SYSTEM ADMINISTRATOR.</p></div>');
			} else {
				let orderid = $('#reginput').val();
				$.get('/snippets/vaultinfo/vaultinfo.php', function(data) {
					$("#appcontainer").html(data);
				}).done(function(){
					$.get('/snippets/vaultinfo/vaultinfoleft.php', function(data) {
						$("#left").html(data);
					}).done(function(){
						$.get('/snippets/vaultinfo/vaultinfomiddle.php', function(data) {
							$("#middle").html(data);
						}).done(function(){
							$.get('/snippets/vaultinfo/vaultinforight.php', function(data) {
								$("#right").html(data);
								initorderfull(orderid);						
							})
						})
					})
				})				
			}
		});
		
	}); // end of create order listener
	
	
	// Listener to handle custinfo form submit
	$("body").on("submit", "#custinfoform", function (event){
		event.preventDefault();
		let custformdata ={
			custbusiness: $('#businessinput').val(),
			custtn : $('#cust-tn').val(),
			custfirst: $('#custfirstinput').val(),
			custlast: $('#custlastinput').val(),
			custaddress: $('#custaddyinput').val(),
			custcity: $('#custcityinput').val(),
			custzip: $('#custzipinput').val(),
			orderid: $('#reginput').val(),
			custstate: $('#custstateinput').val(),
			custcountry: $('#custcountryinput').val()
		}
		
		if ($("#hiddencustid").val()) {
			custformdata["custid"] = $("#hiddencustid").val();
		}
		console.log(custformdata);
		$.ajax({
			url: "/scripts/php/updatecustinfo.php",
			type: "POST",
			data: custformdata,
			dataType: "json",
			encode: true
		}).done(function (data){
			if (data["success"] == "false"){
				$("#reginfodiv").append('<div class="alert alert-danger" role="alert">Update failed. Please contact system administrator.</div>')
			} else {
				$.get('/snippets/vaultinfo/vaultinfo.php', function(data) {
					$("#appcontainer").html(data);
				}).done(function (){
					$.get('/snippets/vaultinfo/vaultinfoleft.php', function(data) {
						$("#left").html(data);
					}).done(function(){
						$.get('/snippets/vaultinfo/vaultinfomiddle.php', function(data) {
							$("#middle").html(data);
						}).done(function (){
							$.get('/snippets/vaultinfo/vaultinforight.php', function(data) {
								$("#right").html(data);
								initorderfull(custformdata["orderid"]);			
							})
						})
					})
				})
			}
		});
	}); // end of cust info form submit listener
	
	
	// Customer search select listener
	$('body').on("change", "#custidinput", function(event) {
		event.preventDefault();
		let content = $("#select2-custidinput-container").text();
		content = content.replaceAll(" ", ",");
		content = content.split(",");
		let first = content[1];
		let last = content[2];
		
		let formData ={
			custfirst: first,
			custlast: last
		}
		
		$.ajax({
			url: "/scripts/php/custsearch.php",
			type: "POST",
			data: formData,
			dataType: "json",
			encode: true
		}).done(function (data){

			// Set option on custstate search box
			$('#custstateinput').select2({theme: 'bootstrap-5'}).val(data["custstate"]).trigger("change");

			// Set option on custcountry search box
			$('#custcountryinput').select2({theme: 'bootstrap-5'}).val(data["custcountry"]).trigger("change");

			// Fill fields with appropriate values
			$('#businessinput').val(data["custbusiness"]);
			$('#cust-tn').val(data["custtn"]);
			$('#custfirstinput').val(data["custfirst"]);
			$('#custlastinput').val(data["custlast"]);
			$('#custaddyinput').val(data["custaddress"]);
			$('#custcityinput').val(data["custcity"]);
			$('#custzipinput').val(data["custzip"]);
			$('#hiddencustid').val(data["custid"]);
		});
		
	}); // end of customer search select listener
	
	
	// Phone number masking listener
	$('body').on("keydown", '#cust-tn', function (e) {
		let key = e.which || e.charCode || e.keyCode || 0;
		$phone = $(this);

		// Don't let them remove the starting '('
		if ($phone.val().length === 1 && (key === 8 || key === 46)) {
				$phone.val('('); 
			return false;
		} else if ($phone.val().charAt(0) !== '(') {
			// Reset if they highlight and type over first char.
			$phone.val('('+String.fromCharCode(e.keyCode)+''); 
		}

		// Auto-format- do not expose the mask as the user begins to type
		if (key !== 8 && key !== 9) {
			if ($phone.val().length === 4) {
				$phone.val($phone.val() + ')');
			}
			if ($phone.val().length === 5) {
				$phone.val($phone.val() + ' ');
			}			
			if ($phone.val().length === 9) {
				$phone.val($phone.val() + '-');
			}
		}

		// Allow numeric (and tab, backspace, delete) keys only
		return (key == 8 || key == 9 || key == 46 || (key >= 48 && key <= 57) || (key >= 96 && key <= 105));
		
	}).bind('focus click', function () {
		$phone = $(this);

		if ($phone.val().length === 0) {
			$phone.val('(');
		} else {
			let val = $phone.val();
			$phone.val('').val(val); // Ensure cursor remains at the end
		}
	}).blur(function () {
		$phone = $(this);

		if ($phone.val() === '(') {
			$phone.val('');
		}
	}); // end of phone number masking listener
	
	
	// Login form submit listener
	$("#LoginForm").submit(function (event) {
		let formData ={
			username: $("#email").val(),
			password: $("#password").val(),
		};
		// ajax request for login processing script
		$.ajax({
			type: "POST",
			url: "/scripts/php/process.php",
			data: formData,
			dataType: "json",
			encode: true,
		}).done(function (data){
			// Check for errors
			if (!data.success) {
				
				if (data.errors.password) {
					$("#FormPassword").addClass("has-error");
					$("#FormPassword").append(
						'<div class="help-block">' + data.errors.password + "</div>"
					);
				} else if (data.errors.activation) {
					$("#FormPassword").addClass("has-error");
					$("#FormPassword").append(
						'<div class="help-block">' + data.errors.activation + "</div>"
					);
				}
			// If no errors, continue
			} else {
				
				// Load main menu
				$.get('/snippets/mainmenu.php', function(newHTMLdata) {
					$("#appcontainer").html(newHTMLdata);
				})
				
				// Load navbar
				$.get('/snippets/navbar.php', function(newHTMLdata) {
					$("body").prepend(newHTMLdata);
				})
				
				// initialize session checking function
				initSessionChecker();
			}
		});
		
		event.preventDefault();
	}); // end of login form submit listener
	
	
	// Listener for locator button
	$("body").on("click", "#locButton", function(event) {
		event.preventDefault();
		$.get('/snippets/locator.php', function(data) {
			$("#middle").html(data);
			
			// Call initialize select2 function so that select2 registers box on load
			initializeSelect2();
			custsearch();
		})
	}); // end of listener for locator button
	
	
	// Listener for maintenance button
	$("body").on("click", "#maintButton", function(event) {
		event.preventDefault();
		$.get('/snippets/maintenance.php', function(data) {
			$("#middle").html(data);
			initializeAllHistTable();
		})
	}); // end of listener for maintenance button
	
	// Listener for scan button
	$('body').on("click", "#scanButton", function(event){
		event.preventDefault();
		initializeQRscanner();
	}); // end of listener for scan button
	
	// Listener for itemmenu scan button
	$('body').on("click", "#scanLocButton", function(event){
		event.preventDefault();
		initializeQRlocUpdate();
	}); // end of listener itemmenu for scan button
	
	// Listener for admin button
	$("body").on("click", "#adminButton", function(event) {
		event.preventDefault();
		$.get('/snippets/admin.php', function(data) {
			$("#middle").html(data);
		})
	}); // end of listener for admin button
	
	
	// Listener for navbar logout button
	$("body").on("click", "#logoutnav", function(event){
		event.preventDefault();
		$.ajax({
			type: "GET",
			url: "/scripts/php/logout.php",
			dataType: "json",
			encode: true
		});
		location.reload();
	}); // end of listener for navbar logout button
	
	
	// Listener for navbar home button
	$("body").on("click", "#homenav", function(event) {
		event.preventDefault();
		$.get('/snippets/mainmenu.php', function(data) {
			$("#appcontainer").html(data);
		})
	}); // end of listener for navbar home button
	
	
	// Listener for reg update form submits
	$('body').on("submit", "#reginfoform", function (event){
		event.preventDefault();
		
		let regformdata ={
			oldorderid: $("#hiddenorderid").val(),
			orderid: $('#reginput').val(),
			orderwh: $('#select2-regwhinput-container').text(),
			weight: $('#regweightinput').val(),
			ordertype: $('#typeselect').val(),
			valtype: $('#valtypeselect').val(),
			orderval: $('#regvalueinput').val(),
		}
		
		if ($('#regdateoutinput').val() != ""){
			regformdata["dateout"] = $('#regdateoutinput').val();
		}
		
		if ($('#sitexinput').val() != ""){
			regformdata["sitex"] = $('#sitexinput').val();
		}
		
		if ($('#sitnuminput').val() != ""){
			regformdata["sitnum"] = $('#sitnuminput').val();
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
				$.get('/snippets/vaultinfo/vaultinfo.php', function(data) {
					$("#appcontainer").html(data);
				}).done(function (){
					$.get('/snippets/vaultinfo/vaultinfoleft.php', function(data) {
						$("#left").html(data);
					}).done(function(){
						$.get('/snippets/vaultinfo/vaultinfomiddle.php', function(data) {
							$("#middle").html(data);
						}).done(function (){
							$.get('/snippets/vaultinfo/vaultinforight.php', function(data) {
								$("#right").html(data);
								initorderfull(regformdata["orderid"]);
							})
						})
					})
				})
			}
		});
		
	}); // end of listener for reg update form submits
	
	// Listener for reg value type changes
	$("body").on("change", "#valtypeselect", function(){
		if ($("#valtypeselect").val() == "60l") {
			let value = $('#regweightinput').val() * 0.6;
			value = value.toFixed(2);
			$("#regvalueinput").val("$" + value);
			$("#regvalueinput").prop('disabled', true);
			$("#regvalueHelp").text("Value (Automatic)");
		}
		
		if ($("#valtypeselect").val() == "frc") {
			$("#regvalueinput").prop('disabled', false);
			$("#regvalueHelp").text("Value (Required)");
		}
		
		if ($("#valtypeselect").val() == "nts") {
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
		
		if ($("#valtypeselect").val() == "oth") {
			$("#regvalueinput").prop('disabled', false);
			$("#regvalueHelp").text("Value (Required)");
		}
	}); // End of listener for reg value type changes
	
	// Listener for order type changes
	$("body").on("change", "#typeselect", function(){
		if ($("#typeselect").val() == "SIRVA SIT") {
			$('#sitcheckrow').removeAttr('hidden');
			$('#sitex').attr('hidden', true);
			$('#sitnum').attr('hidden', true);
			$("#sitnuminput").prop('disabled', false);
			$("#sitnumHelp").text("SIT# (Required)");
			$('#sitexcol').html('<div class="form-group" id="sitex"><input type="date" class="form-control shadow-sm" id="sitexinput"><small id="sitexHelp" class="form-text text-muted">Expiration Date (Required)</small></div>');
			$('#sitexcolnew').html('<div class="form-group" id="sitex"><input type="input" class="form-control shadow-sm" id="sitexinput"><small id="sitexHelp" class="form-text text-muted">Expiration Days (Required)</small></div>');
			$('#sitex').attr('hidden', true);
			$("#sitexinput").prop('disabled', false);
			
			$("#valtypeselect").prop('disabled', false);
		}
		
		if ($("#typeselect").val() == "MIL SIT") {
			$('#sitcheckrow').removeAttr('hidden');
			$('#sitex').attr('hidden', true);
			$('#sitnum').attr('hidden', true);
			$("#sitnuminput").prop('disabled', false);
			$("#sitnumHelp").text("SIT# (Required)");
			$('#sitexcol').html('<div class="form-group" id="sitex"><input type="date" class="form-control shadow-sm" id="sitexinput"><small id="sitexHelp" class="form-text text-muted">Expiration Date (Required)</small></div>');
			$('#sitexcolnew').html('<div class="form-group" id="sitex"><input type="input" class="form-control shadow-sm" id="sitexinput"><small id="sitexHelp" class="form-text text-muted">Expiration Days (Required)</small></div>');
			$('#sitex').attr('hidden', true);
			$("#sitexinput").prop('disabled', false);
			
			$("#valtypeselect").prop('disabled', false);
		}
		
		if ($("#typeselect").val() == "NTS") {
			$('#sitcheckrow').attr('hidden', true);
			$('#sitnum').attr('hidden', true);
			$('#sitex').removeAttr('hidden');
			$("#sitnuminput").val('');
			$("#sitnuminput").prop('disabled', true);
			$("#sitnuminput").prop('required', false);
			$("#valtypeselect").val("nts").trigger("change");
			$("#valtypeselect").prop('disabled', true);
			$("#sitnuminput").prop('required', true);
			$("#sitnumHelp").text("SIT# (SIT Orders Only)");
			$('#sitexcol').html('<div class="form-group" id="sitex"><input type="date" class="form-control shadow-sm" id="sitexinput"><small id="sitexHelp" class="form-text text-muted">Expiration Date (Required)</small></div>');
			$('#sitexcolnew').html('<div class="form-group" id="sitex"><input type="input" class="form-control shadow-sm" id="sitexinput"><small id="sitexHelp" class="form-text text-muted">Expiration Days (Required)</small></div>');
			$("#sitexinput").prop('disabled', false);
			$("#sitexinput").prop('required', true);
		}
		
		if ($("#typeselect").val() == "PERM STG (HHG)") {
			$('#sitcheckrow').attr('hidden', true);
			$('#sitnum').attr('hidden', true);
			$("#sitnuminput").val('');
			$("#sitnuminput").prop('disabled', true);
			$("#sitnuminput").prop('required', false);
			$("#sitnumHelp").text("SIT# (SIT Orders Only)");
			$('#sitexcol').html('<div class="form-group" id="sitex"><input type="input" class="form-control shadow-sm" id="sitexinput"><small id="sitexHelp" class="form-text text-muted">Expiration Days (SIT/NTS Only)</small></div>');
			$('#sitexcolnew').html('<div class="form-group" id="sitex"><input type="input" class="form-control shadow-sm" id="sitexinput"><small id="sitexHelp" class="form-text text-muted">Expiration Days (SIT/NTS Only)</small></div>');
			$('#sitex').attr('hidden', true);
			$("#sitexinput").prop('disabled', true);
			$("#sitexinput").prop('required', false);
			
			$("#valtypeselect").prop('disabled', false);
		}
		
		if ($("#typeselect").val() == "PERM STG (Non-HHG)") {
			$('#sitcheckrow').attr('hidden', true);
			$('#sitex').attr('hidden', true);
			$('#sitnum').attr('hidden', true);
			$("#sitnuminput").val('');
			$("#sitnuminput").prop('disabled', true);
			$("#sitnuminput").prop('required', false);
			$("#sitnumHelp").text("SIT# (SIT Orders Only)");
			$('#sitexcol').html('<div class="form-group" id="sitex"><input type="input" class="form-control shadow-sm" id="sitexinput"><small id="sitexHelp" class="form-text text-muted">Expiration Days (SIT/NTS Only)</small></div>');
			$('#sitexcolnew').html('<div class="form-group" id="sitex"><input type="input" class="form-control shadow-sm" id="sitexinput"><small id="sitexHelp" class="form-text text-muted">Expiration Days (SIT/NTS Only)</small></div>');
			$('#sitex').attr('hidden', true);
			$("#sitexinput").prop('disabled', true);
			$("#sitexinput").prop('required', false);
			
			$("#valtypeselect").prop('disabled', false);
		}
		
		if ($("#typeselect").val() == "R19/Local Pickup") {
			$('#sitcheckrow').attr('hidden', true);
			$('#sitex').attr('hidden', true);
			$('#sitnum').attr('hidden', true);
			$("#sitnuminput").val('');
			$("#sitnuminput").prop('disabled', true);
			$("#sitnuminput").prop('required', false);
			$("#sitnumHelp").text("SIT# (SIT Orders Only)");
			$('#sitexcol').html('<div class="form-group" id="sitex"><input type="input" class="form-control shadow-sm" id="sitexinput"><small id="sitexHelp" class="form-text text-muted">Expiration Days (SIT/NTS Only)</small></div>');
			$('#sitexcolnew').html('<div class="form-group" id="sitex"><input type="input" class="form-control shadow-sm" id="sitexinput"><small id="sitexHelp" class="form-text text-muted">Expiration Days (SIT/NTS Only)</small></div>');
			$('#sitex').attr('hidden', true);
			$("#sitexinput").prop('disabled', true);
			$("#sitexinput").prop('required', false);
			
			$("#valtypeselect").prop('disabled', false);
		}
		
		if ($("#typeselect").val() == "OTHER") {
			$('#sitcheckrow').attr('hidden', true);
			$('#sitex').attr('hidden', true);
			$('#sitnum').attr('hidden', true);
			$("#sitnuminput").val('');
			$("#sitnuminput").prop('disabled', true);
			$("#sitnuminput").prop('required', false);
			$("#sitnumHelp").text("SIT# (SIT Orders Only)");
			$('#sitexcol').html('<div class="form-group" id="sitex"><input type="input" class="form-control shadow-sm" id="sitexinput"><small id="sitexHelp" class="form-text text-muted">Expiration Days (SIT/NTS Only)</small></div>');
			$('#sitexcolnew').html('<div class="form-group" id="sitex"><input type="input" class="form-control shadow-sm" id="sitexinput"><small id="sitexHelp" class="form-text text-muted">Expiration Days (SIT/NTS Only)</small></div>');
			$('#sitex').attr('hidden', true);
			$("#sitexinput").prop('disabled', true);
			$("#sitexinput").prop('required', false);
			
			$("#valtypeselect").prop('disabled', false);
		}
	}); //end of listener for order type changes
	
	
		// Listener for sit checkbox
	$('body').on("change", "#sitcheck", function() {
		
		if ($('#sitcheck').prop("checked") == true) {
			
			$('#sitnum').removeAttr('hidden');
			$('#sitex').removeAttr('hidden');
			
			$("#sitnuminput").prop('disabled', false);
			$("#sitexinput").prop('disabled', false);
			
			$("#sitnuminput").prop('required', true);
			$("#sitexinput").prop('required', true);
			
		}
		
		if ($('#sitcheck').prop("checked") == false) {
			
			$('#sitnum').attr('hidden', true);
			$('#sitex').attr('hidden', true);
			
			$("#sitnuminput").prop('required', false);
			$("#sitexinput").prop('required', false);

		}
		
	}); // end of listener for sit checkbox
	
	
	// Listener for weight changes
	$("body").on("keyup", "#regweightinput", function(){
		if ($("#valtypeselect").val() == "60l") {
			let value = $('#regweightinput').val() * 0.6;
			value = value.toFixed(2);
			$("#regvalueinput").val("$" + value);
			$("#regvalueinput").prop('disabled', true);
			$("#regvalueHelp").text("Value (Automatic)");
		}
		
		if ($("#valtypeselect").val() == "nts") {
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
	}); // end of Listener for weight changes
	
	// Listener for main menu register button
	$("#regButton").click(function () {
		
		$.get('/snippets/registration.html', function(data) {
			$("#middle").html(data);
		})
	}); // end of listener for main menu register button
	
	// Listener for main menu resetpw button
	$("#respwButton").click(function () {
		
		$.get('/snippets/resetpw.html', function(data) {
			$("#middle").html(data);
		})
	}); // end of listener for main menu register button
	
	// Listener for show open vaults button
	$("body").on("click","#showopenvaultsbtn", function (){
		let regwh = $("#regwhinput").val();
		
		if($("#openvaultsheading").text() == ""){
			initOpenVaultsTable(regwh);
		}
	})// end of Listener for show open vaults button
	
	// Listener for registerform submissions
	$("body").on("submit", "#RegisterForm", function(event) {
		
		event.preventDefault();
		
		let formData ={
			firstname: $("#firstname").val(),
			lastname: $("#lastname").val(),
			email: $("#email").val(),
			password: $("#password").val(),
		}
		
		$.ajax({
			type: "POST",
			url: '/scripts/php/register.php',
			data: formData,
			dataType: "json",
			encode: true,
		}).done(function (data) {
			if (!data.success) {
				
				if (data.errors.password) {
					$("#FormPassword").addClass("has-error");
					$("#FormPassword").append(
						'<div class="help-block">' + data.errors.password + "</div>"
					);
				}
				if (data.errors.username) {
					$("#FormPassword").addClass("has-error");
					$("#FormPassword").append(
						'<div class="help-block">' + data.errors.username + "</div>"
					);
				}
			} else {
				$.get('/snippets/registrationsuccess.html', function(newHTMLdata) {
					$("#middle").html(newHTMLdata);
				})
			}
			
		});
	}); // end of listener for registerform submissions
	
	
	// Listener for new order form submissions
	$("body").on("submit", "#newregform", function(event){
		event.preventDefault();
		let orderid = $("#regidinput").val();
		$.get('/snippets/vaultinfo/vaultinfo.php', function(data) {
			$("#appcontainer").html(data);
		}).done(function(){
			$.get('/snippets/vaultinfo/newordermiddle.php', function(data) {
				$("#middle").html(data);
			}).done(function(){
				initordernew(orderid);
			});
		})

	}); // end of listener for new order form submissions
	
	

	
	
}) // End of document.ready
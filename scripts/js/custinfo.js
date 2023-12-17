// JavaScript Document
function fillcustinfo(orderid){
	var formData ={
		orderid: orderid,
	};
	
	// custid select2
	$("#custidinput").select2({
		theme: 'bootstrap-5',
		width: "100%",
		placeholder: "Select customer...",
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
	
	
	// Phone number masking
	$('#cust-tn')

	.keydown(function (e) {
		var key = e.which || e.charCode || e.keyCode || 0;
		$phone = $(this);

    // Don't let them remove the starting '('
    if ($phone.val().length === 1 && (key === 8 || key === 46)) {
			$phone.val('('); 
      return false;
		} 
    // Reset if they highlight and type over first char.
    else if ($phone.val().charAt(0) !== '(') {
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
		return (key == 8 || 
				key == 9 ||
				key == 46 ||
				(key >= 48 && key <= 57) ||
				(key >= 96 && key <= 105));	
	})
	
	.bind('focus click', function () {
		$phone = $(this);
		
		if ($phone.val().length === 0) {
			$phone.val('(');
		}
		else {
			var val = $phone.val();
			$phone.val('').val(val); // Ensure cursor remains at the end
		}
	})
	
	.blur(function () {
		$phone = $(this);
		
		if ($phone.val() === '(') {
			$phone.val('');
		}
	});
	
}	
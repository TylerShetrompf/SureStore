<!doctype html>
<html>

<head>
<meta charset="utf-8">
<title>Reset Password</title>
<link rel="shortcut icon" href="https://www.surestore.store/images/favicon.ico">
<!-- Include JQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!-- Include Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js" integrity="sha512-WW8/jxkELe2CAiE4LvQfwm1rajOS8PHasCCx+knHG0gBHt8EXxS6T6tJRTGuDQVnluuAvMxWF4j8SNFDKceLFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>	
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" integrity="sha512-b2QcS5SsA8tZodcDtGRELiGv5SaKSk1vDHDaQRda0htPYWZ6046lr3kJ5bAAQdpV2mmA/4v0wQF9MyU6/pDIAg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="/style/style2.css">
<!-- PWReset Script -->
<script src="/scripts/js/pwreset.js"></script>
</head>

<body>
	<?php
		// Initialize variables from GET in email link
		$actcode = $_GET['actcode'];
		$userid = $_GET['userid'];
	
		// Connect to DB
		include '/var/www/html/scripts/php/connectdb.php';
	
		// Query to check that user exists with proper activation code
		$checkuserquery = pg_query_params($surestore_db, "SELECT * FROM sureusers WHERE LOWER(userid) = LOWER($1) AND actcode = $2", array($userid, $actcode));
		$checkuserresults = pg_fetch_assoc($checkuserquery);

		// Validate query
		if($checkuserresults){
			echo('<div class="container-fluid" id="appcontainer"><div class="row" id="rowmain"><div class="col-lg-4 order-2 order-lg-1" id="left"></div><div class="col-lg-4 order-1 order-lg-2" id="middle"><img class="mx-auto d-block" src="images/logoSmol.png" alt="SureStore Logo"><form class="bg-light px-2 my-2 border rounded" id="resetForm"><div class="form-group my-2 shadow-sm" id="FormPass1"><input type="password" class="form-control" id="pass1" placeholder="Password"></div><div class="form-group my-2 shadow-sm" id="FormPass2"><input type="password" class="form-control" id="pass2" placeholder="Confirm Password"></div><input type="text" class="visually-hidden" id="hiddenuserid" value="'.$userid.'"><input type="text" class="visually-hidden" id="hiddenactcode" value="'.$actcode.'"><div class="d-grid my-1"><button type="submit" id="pwresetbtn" class="btn btn-success btn-large btn-block shadow-sm">Set Password</button></div></form></div><div class="col-lg-4 order-3 order-lg-3" id="right"></div></div></div><footer class="footer fixed-bottom"><div class="container-fluid"><span class="text-white">&copy; SureStore.store</span></div></footer>');
		} else {
			echo('<div class="container"><div class="row"><div class="col-sm-3"></div><div class="col-sm-6" id="body"><img class="mx-auto d-block" src="images/logoSmol.png" alt="SureStore Logo"><div class="bg-danger rounded-3"><h1>Password Reset Failed :(</h1><p>Password reset link is invalid.</p></div><div class="d-grid gap-2 my-2"><a href="https://surestore.store" class="btn btn-danger btn-large btn-block">Return to login</a></div></div><div class="col-sm-3"></div><footer class="footer"><div class="container-fluid"><span class="text-white">&copy; SureStore.store</span></div></footer></div>');
		}
		pg_close($surestore_db);
	?>
</body>
</html>

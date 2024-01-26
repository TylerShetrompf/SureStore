<!doctype html>
<html>

<head>
<meta charset="utf-8">
<title>Account Activated</title>
<link rel="shortcut icon" href="https://www.surestore.store/images/favicon.ico">
<!-- Include Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js" integrity="sha512-WW8/jxkELe2CAiE4LvQfwm1rajOS8PHasCCx+knHG0gBHt8EXxS6T6tJRTGuDQVnluuAvMxWF4j8SNFDKceLFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>	
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" integrity="sha512-b2QcS5SsA8tZodcDtGRELiGv5SaKSk1vDHDaQRda0htPYWZ6046lr3kJ5bAAQdpV2mmA/4v0wQF9MyU6/pDIAg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="/style/style2.css">
</head>

<body>
<?php
	// Initialize variables from GET in email link
	$actcode = $_GET['actcode'];
	$userid = $_GET['userid'];
	$newactcode = rand(10000,99999);
	// Connect to DB
	include '/var/www/html/scripts/php/connectdb.php';

	$actuserquery = pg_query_params($surestore_db, "UPDATE sureusers SET activated = 'TRUE', actcode = $1 WHERE LOWER(userid) = LOWER($2) AND actcode = $3", array($newactcode, $userid, $actcode));
	echo('<div class="container"><div class="row"><div class="col-sm-3"></div><div class="col-sm-6" id="body"><img class="mx-auto d-block" src="images/logoSmol.png" alt="SureStore Logo"><div class="bg-light rounded-3"><h1>Account Activated</h1><p>Your SureStore account is now activated!</p></div><div class="d-grid gap-2 my-2"><a href="https://surestore.store" class="btn btn-success btn-large btn-block">Return to login</a></div></div><div class="col-sm-3"></div><footer class="footer"><div class="container-fluid"><span class="text-white">&copy; SureStore.store</span></div></footer></div>');

	pg_close($surestore_db);
?>
</body>
</html>

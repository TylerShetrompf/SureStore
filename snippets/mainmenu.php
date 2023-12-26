<?php
// PHP to check session
//include '/var/www/html/scripts/php/reverifysession.php';

// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

// Get userid from cookie
$userid = $_COOKIE['userid'];

// Check user privelege level
$userquery = pg_query_params($surestore_db, 'select useracl from sureusers where LOWER(userid) = LOWER($1)', array($userid));

$userresult = pg_fetch_assoc($userquery);

echo(
		
'<div class="row" id="rowmain">

	<!-- 3 Columns in Main Row -->

	<!-- Left row -->
	<div class="col-sm-4" id="left"></div>

	<!-- Middle row -->
	<div class="col-sm-4" id="middle">

		<div class="d-grid gap-2 my-2" id="locButton">
			<button type="button" class="btn btn-success btn-lg btn-block">Locator</button>
		</div>
		
		<div class="d-grid gap-2 my-2" id="scanButton">
			<button type="button" class="btn btn-success btn-lg btn-block">Scan</button>
		</div>'
);

if ($userresult["useracl"] >= "2") {
	
echo ('	
		<div class="d-grid gap-2 my-2" id="maintButton">
			<button type="button" class="btn btn-warning btn-lg btn-block">Maintenance</button>
		</div>'
);
	
}

if ($userresult["useracl"] == "3") {
	
echo ('	
		<div class="d-grid gap-2 my-2" id="adminButton">
			<button type="button" class="btn btn-danger btn-lg btn-block">Admin</button>
		</div>'
);
	
}


echo ('	
	</div>

	<!-- Right row -->
	<div class="col-sm-4" id="right"></div>
	
</div>'
);
?>
<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';
// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

// Initialize looses array
$loose = [];

// loose query
$loosequery = pg_query($surestore_db, "select * from sureloose");

// Iterate through results and add to array
while ($looseresult = pg_fetch_assoc($loosequery)) {
	
	// init empty entry array
	$entry = [];
	
	//assign values from result to entry array
	$entry["looseid"] = $looseresult["looseid"];
	$entry["loosewh"] = $looseresult["loosewh"];
	
	// push entry array to looses array
	array_push($loose, $entry);
	
}

// Echo back to ajax
echo json_encode($loose);

// Close db connection
pg_close($surestore_db);
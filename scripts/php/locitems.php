<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';
// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

// Initialize items array
$items = [];

// Get locid from post
$locid = $_POST["locid"];

$locquery = pg_query_params($surestore_db, "select itemorder, itemdesc from sureitems where LOWER(itemvault) = LOWER($1) OR LOWER(itemloose) = LOWER($1)", array($locid));

while ($locqueryresult = pg_fetch_assoc($locquery)) {
	$entry = [];
	$entry ["itemorder"] = $locqueryresult["itemorder"];
	$entry ["itemdesc"] = $locqueryresult["itemdesc"];

	array_push($items, $entry);
}

// Echo back to ajax
echo json_encode($items);

// Close db connection
pg_close($surestore_db);
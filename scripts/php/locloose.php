<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';
// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

// Initialize items array
$items = [];

// Get orderid from post
$orderid = $_POST["orderid"];

// Item query
$itemquery = pg_query_params($surestore_db, "select distinct itemloose, itemvaulter, string_agg(itemdesc, ', ') itemdesc from sureitems where LOWER(itemorder) = LOWER($1) and itemloose is NOT NULL group by itemloose, itemvaulter", array($orderid));

while ($itemqueryresult = pg_fetch_assoc($itemquery)) {
	$entry = [];
	$entry ["itemdesc"] = $itemqueryresult["itemdesc"];
	$entry ["itemloose"] = $itemqueryresult["itemloose"];
	
	// Get Vaulters name
	$vaulterid = $itemqueryresult["itemvaulter"];
	$vaulterquery = pg_query_params($surestore_db, "select * from surevaulters where vaulterid = $1", array($vaulterid));
	$vaulterqueryresult = pg_fetch_assoc($vaulterquery);
	$entry ["itemvaulter"] = $vaulterqueryresult["vaulterfirst"]." ".$vaulterqueryresult["vaulterlast"];
	array_push($items, $entry);
}

// Echo back to ajax
echo json_encode($items);

// Close db connection
pg_close($surestore_db);
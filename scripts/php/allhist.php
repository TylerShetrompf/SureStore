<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';
// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

// Initialize history array
$hist = [];

$histquery = pg_query($surestore_db, "select timezone('US/Eastern', date_trunc('minute', histtime)) as histtime, histdesc from surehistory");

while ($histqueryresult = pg_fetch_assoc($histquery)) {
	$entry = [];
	$entry ["histdesc"] = $histqueryresult["histdesc"];
	$entry ["histtime"] = $histqueryresult["histtime"];

	array_push($hist, $entry);
}

// Echo back to ajax
echo json_encode($hist);

// Close db connection
pg_close($surestore_db);
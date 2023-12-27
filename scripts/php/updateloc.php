<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';

// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

// initialize userid variable from cookie
$userid = $_COOKIE["userid"];

$loctype = $_POST["loctype"];
$locid = $_POST["locid"];
$itemid = $_POST["itemid"];

$itemquery = pg_query_params($surestore_db, "select itemorder from sureitems where itemid = $1", array($itemid));

$itemresult = pg_fetch_assoc($itemquery);
$orderid = $itemresult["itemorder"];

if ($loctype == "L") {
	$updatequery = pg_query_params($surestore_db, "update sureitems set itemloose = $1, itemvault = NULL where itemid = $2", array($locid, $itemid));
}
if ($loctype == "V") {
	$updatequery = pg_query_params($surestore_db, "update sureitems set itemloose = NULL, itemvault = $1 where itemid = $2", array($locid, $itemid));
}



// Log in surehistory
$updatetext = $userid." moved item ".$itemid." in order ".$orderid." to location ". $locid;
$histquery = pg_query_params($surestore_db, "insert into surehistory(historder, histdesc) values($1, $2)", array($orderid,$updatetext));

// Close DB connection
pg_close($surestore_db);
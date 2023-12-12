<?php
// Include db connection
include '/var/www/html/scripts/connectdb.php';

// Initialize data and results arrays
$data = [];
$results = [];
$items = [];
$history = [];
// Get variables from POST
$orderid = $_POST["orderid"];
$vault = $_POST["vault"];

// Query
$orderidquery = pg_query_params($surestore_db, "select * from sureorders where orderid = $1", array($orderid));

$orderidqueryresult = pg_fetch_assoc($orderidquery);

$custid = $orderidquery["ordercust"];

$datein = $orderidquery["datein"];

$dateout = $orderidquery["dateout"];

$ordermil = $orderidquery["ordermil"];

$orderidquery = pg_query_params($surestore_db, "select * from sureorders where orderid = $1", array($orderid));

$itemquery = pg_query_params($surestore_db, "select * from sureitems where itemorder = $1", array($orderid));

while ($itemqueryresult = pg_fetch_assoc($itemquery)) {
	$entry = [];
	$entry ["itemid"] = $itemqueryresult["itemid"];
	$entry ["itemdesc"] = $itemqueryresult["itemdesc"];
	$entry ["itemvault"] = $itemqueryresult["itemvault"];
	$entry ["itemloose"] = $itemqueryresult["itemloose"];
	$entry ["itemvaulter"] = $itemqueryresult["itemvaulter"];
	array_push($items, $entry);
}

$historyquery = pg_query_params($surestore_db, "select * from surehistory where historder = $1", array($orderid));

while ($historyqueryresult = pg_fetch_assoc($historyquery)) {
	$entry = [];
	$entry ["histid"] = $historyqueryresult["histid"];
	$entry ["histdesc"] = $historyqueryresult["histdesc"];
	$entry ["histime"] = $historyqueryresult["histime"];
	array_push($history, $entry);
}

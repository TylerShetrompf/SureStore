<?php
// Include db connection
include '/var/www/html/scripts/connectdb.php';

// Initialize data and results arrays
$data = [];
$items = [];
$history = [];
$orderinfo = [];
// Get variables from POST
$orderid = $_POST["orderid"];

// Query
$orderidquery = pg_query_params($surestore_db, "select * from sureorders where orderid = $1", array($orderid));

$orderidqueryresult = pg_fetch_assoc($orderidquery);

$orderinfo["custid"] = $orderidqueryresult["ordercust"];
$orderinfo["datein"] = $orderidqueryresult["datein"];
$orderinfo["dateout"] = $orderidqueryresult["dateout"];
$orderinfo["ordermil"] = $orderidqueryresult["ordermil"];

$custquery = pg_query_params($surestore_db, "select * from surecustomer where custid = $1", array($orderinfo["custid"]));

$custqueryresult = pg_fetch_assoc($custquery);
$orderinfo["custfirst"] = $custqueryresult["custfirst"];
$orderinfo["custlast"] = $custqueryresult["custlast"];

$data["orderinfo"] = $orderinfo;

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

$data["items"] = $items;

$historyquery = pg_query_params($surestore_db, "select * from surehistory where historder = $1", array($orderid));

while ($historyqueryresult = pg_fetch_assoc($historyquery)) {
	$entry = [];
	$entry ["histid"] = $historyqueryresult["histid"];
	$entry ["histdesc"] = $historyqueryresult["histdesc"];
	$entry ["histime"] = $historyqueryresult["histime"];
	array_push($history, $entry);
}

$data["history"] = $history;

echo json_encode($data);

pg_close($surestore_db);
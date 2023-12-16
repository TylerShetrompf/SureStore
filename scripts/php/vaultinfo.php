<?php
// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

// Initialize data and results arrays
$data = [];
$items = [];
$history = [];
$orderinfo = [];
// Get variables from POST
$orderid = $_POST["orderid"];

// Order id query
$orderidquery = pg_query_params($surestore_db, "select * from sureorders where LOWER(orderid) = LOWER($1)", array($orderid));

$orderidqueryresult = pg_fetch_assoc($orderidquery);

// Assign results from query to orderinfo array
$orderinfo["custid"] = $orderidqueryresult["ordercust"];
$orderinfo["datein"] = $orderidqueryresult["datein"];
$orderinfo["dateout"] = $orderidqueryresult["dateout"];
$orderinfo["ordermil"] = $orderidqueryresult["ordermil"];

// Customer query
$custquery = pg_query_params($surestore_db, "select * from surecustomer where LOWER(custid) = LOWER($1)", array($orderinfo["custid"]));

$custqueryresult = pg_fetch_assoc($custquery);

// Assign results from query to orderinfo array
$orderinfo["custfirst"] = $custqueryresult["custfirst"];
$orderinfo["custlast"] = $custqueryresult["custlast"];

// Assign orderinfo array to data array orderinfo value
$data["orderinfo"] = $orderinfo;

// Item query
$itemquery = pg_query_params($surestore_db, "select * from sureitems where LOWER(itemorder) = LOWER($1)", array($orderid));

// Iterate through results, create a new entry in items array for each
while ($itemqueryresult = pg_fetch_assoc($itemquery)) {
	$entry = [];
	$entry ["itemid"] = $itemqueryresult["itemid"];
	$entry ["itemdesc"] = $itemqueryresult["itemdesc"];
	$entry ["itemvault"] = $itemqueryresult["itemvault"];
	$entry ["itemloose"] = $itemqueryresult["itemloose"];
	$entry ["itemvaulter"] = $itemqueryresult["itemvaulter"];
	array_push($items, $entry);
}

// Assign items array to data array items value
$data["items"] = $items;

// History query
$historyquery = pg_query_params($surestore_db, "select * from surehistory where LOWER(historder) = LOWER($1)", array($orderid));

// Iterate through results, create a new entry in history array for each
while ($historyqueryresult = pg_fetch_assoc($historyquery)) {
	$entry = [];
	$entry ["histid"] = $historyqueryresult["histid"];
	$entry ["histdesc"] = $historyqueryresult["histdesc"];
	$entry ["histime"] = $historyqueryresult["histime"];
	array_push($history, $entry);
}

// Assign history array to data array history value
$data["history"] = $history;

// Echo back to ajax
echo json_encode($data);

// Close db connection
pg_close($surestore_db);
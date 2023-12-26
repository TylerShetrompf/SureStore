<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';

// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

$data = [];

// Initialize variable from post
$itemid = $_POST["itemid"];

$itemquery = pg_query_params($surestore_db, "select * from sureitems where itemid = $1", array($itemid));

$iteminforesults = pg_fetch_assoc($itemquery);

// assign array values from results
$data["itemorder"] = $iteminforesults["itemorder"];
$orderid = $iteminforesults["itemorder"];
$data["itemdesc"] = $iteminforesults["itemdesc"];

if ($iteminforesults["itemloose"]){
	$data["itemloc"] = $iteminforesults["itemloose"];
}
if ($iteminforesults["itemvault"]){
	$data["itemloc"] = $iteminforesults["itemvault"];
}

$vaulterid = $iteminforesults["itemvaulter"];

// get vaulter name 
$vaulterquery = pg_query_params($surestore_db, "select * from surevaulters where vaulterid = $1", array($vaulterid));
$vaulterqueryresult = pg_fetch_assoc($vaulterquery);

// assign array value from result
$data ["itemvaulter"] = $vaulterqueryresult["vaulterfirst"]." ".$vaulterqueryresult["vaulterlast"];

// get custid for order
$orderquery = pg_query_params($surestore_db, "select ordercust from sureorders where orderid = $1", array($orderid));

$orderqueryresult = pg_fetch_assoc($orderquery);

$custid = $orderqueryresult["ordercust"];

// get customers name 
$custquery = pg_query_params($surestore_db, "select custfirst, custlast from surecustomer where custid = $1", array($custid));

$custqueryresult = pg_fetch_assoc($custquery);

$data ["itemcust"] = $custqueryresult["custfirst"]." ".$custqueryresult["custlast"];

echo json_encode($data);

// Close DB connection
pg_close($surestore_db);

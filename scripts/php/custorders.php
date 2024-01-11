<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';
// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

// initialize custorders array
$custorders = [];

// get orderid from post
$orderid = $_POST["orderid"];

// query to Get custid from order
$custidquery = pg_query_params($surestore_db, "select ordercust from sureorders where orderid = $1", array($orderid));

// cust id to var
$custidres = pg_fetch_assoc($custidquery);
$custid = $custidres["ordercust"];

// Get customers other active orders
$ordersquery = pg_query_params($surestore_db, "select distinct sureorders.orderid, sureorders.orderwh from sureorders left join sureitems on sureorders.orderid = sureitems.itemorder where sureorders.ordercust = $1 AND sureitems.dateout is NULL order by sureorders.orderid", array($custid));

//iterate through results, push entries to custorders array
while ($ordersqueryresult = pg_fetch_assoc($ordersquery)) {
	$entry = [];
	$entry ["orderid"] = $ordersqueryresult["orderid"];
	$entry ["orderwh"] = $ordersqueryresult["orderwh"];
	
	array_push($custorders, $entry);
}

// Echo back to ajax
echo json_encode($custorders);

// Close db connection
pg_close($surestore_db);
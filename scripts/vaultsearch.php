<?php
// Include db connection
include '/var/www/html/scripts/connectdb.php';

// Initialize data and results arrays
$data = [];
$results = [];

// Get user input from post, append %
$userinput = $_POST['term']."%";

// Query
$dbquery = pg_query_params($surestore_db, "select surecustomer.custfirst, surecustomer.custlast, sureorders.orderid, sureitems.itemvault from sureorders inner join surecustomer on sureorders.ordercust=surecustomer.custid inner join sureitems on sureorders.orderid=sureitems.itemorder WHERE sureorders.orderid like $1 OR surecustomer.custfirst like $1 OR surecustomer.custlast like $1 OR sureitems.itemvault like $1", array($userinput));

// Initialize ID variable
$id = 1;

// Save result to associative array, iterate through array, assign results
while ($dbresult = pg_fetch_assoc($dbquery)) {
	$entry = [];
	$entry["id"] = $id;
	$entry["text"] = "Reg: ".$dbresult["orderid"]." Customer: ".$dbresult["custfirst"]." ".$dbresult["custlast"]." Vault: ".$dbresult["itemvault"];
	array_push($results, $entry);
	$id++;
}
$data["results"] = $results;

// Echo back results
echo json_encode($data);

// Close DB connection
pg_close($surestore_db);
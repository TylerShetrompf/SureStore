<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';
// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

// Initialize data and results arrays
$data = [];
$results = [];

// Get user input from post, append %
$userinput = $_POST['term']."%";

// Query
$dbquery = pg_query_params($surestore_db, "select distinct on (sureorders.orderid) sureorders.orderid, min(surecustomer.custfirst) as custfirst, min(surecustomer.custlast) as custlast, string_agg(sureitems.itemvault, ',') as itemvault, string_agg(sureitems.itemloose, ',') as itemloose from sureorders left join surecustomer on sureorders.ordercust=surecustomer.custid left join sureitems on sureorders.orderid=sureitems.itemorder WHERE(LOWER(sureorders.orderid) like LOWER($1) OR LOWER(surecustomer.custfirst) like LOWER($1) OR LOWER(surecustomer.custlast) like LOWER($1) OR LOWER(sureitems.itemvault) like LOWER($1) OR LOWER(sureitems.itemloose) like LOWER($1)) group by sureorders.orderid", array($userinput));

// Initialize ID variable
$id = 1;

// Save result to associative array, iterate through array, assign results
while ($dbresult = pg_fetch_assoc($dbquery)) {
	$entry = [];
	$entry["id"] = $id;
	
	$locstring = $dbresult["itemvault"];
	if (strlen($dbresult["itemvault"] > 15)){
		$locstring = substr($dbresult["itemvault"], 0, 15);
	}
	
	$entry["text"] = "Order: ".$dbresult["orderid"]." Cust: ".$dbresult["custfirst"]." ".$dbresult["custlast"]." Vaults: ".$locstring;
	array_push($results, $entry);
	$id++;
}
$data["results"] = $results;

// Echo back results
echo json_encode($data);

// Close DB connection
pg_close($surestore_db);
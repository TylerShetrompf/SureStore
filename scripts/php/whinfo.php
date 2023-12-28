<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';
// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

// Initialize whs array
$warehouses = [];

// whs query
$whquery = pg_query($surestore_db, "select * from surewarehouse");

// Iterate through results and add to array
while ($whresult = pg_fetch_assoc($whquery)) {
	
	// init empty entry array
	$entry = [];
	
	//assign values from result to entry array
	$entry["whid"] = $whresult["whid"];
	$entry["whaddress"] = $whresult["whaddress"];
	$entry["whcity"] = $whresult["whcity"];
	$entry["whstate"] = $whresult["whstate"];
	$entry["whzip"] = $whresult["whzip"];
	$entry["whcountry"] = $whresult["whcountry"];
	
	// push entry array to whs array
	array_push($warehouses, $entry);
	
}

// Echo back to ajax
echo json_encode($warehouses);

// Close db connection
pg_close($surestore_db);
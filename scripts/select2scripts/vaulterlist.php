<?php
// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

// Initialize data and results arrays
$data = [];
$results = [];

// Get user input from post, append %
$userinput = $_POST['term']."%";

// Query
$dbquery = pg_query_params($surestore_db, "select * from surevaulters where LOWER(vaulterfirst) like LOWER($1) OR LOWER(vaulterlast) like LOWER($1)", array($userinput));

// Initialize ID variable
$id = 1;

// Save result to associative array, iterate through array, assign results
while ($dbresult = pg_fetch_assoc($dbquery)) {
	$entry = [];
	$entry["id"] = $id;
	$entry["text"] = $dbresult["vaulterfirst"]." ".$dbresult["vaulterlast"];
	array_push($results, $entry);
	$id++;
}
$data["results"] = $results;

// Echo back results
echo json_encode($data);
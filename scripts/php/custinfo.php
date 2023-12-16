<?php
// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

$data = [];
$results = [];

// Get user input from post, append %
$userinput = $_POST['term']."%";

// Query
$dbquery = pg_query_params($surestore_db, "select * from surecustomer where LOWER(surecustomer.custfirst) like LOWER($1) or LOWER(surecustomer.custlast) like LOWER($1) or LOWER(surecustomer.custbusiness) like LOWER($1)", array($userinput));

// Initialize ID variable
$id = 1;

while ($dbresult = pg_fetch_assoc($dbquery)) {
	
	$entry = [];
	$entry["id"] = $id;
	$entry["text"] = "Customer: ".$dbresult["custfirst"]." ".$dbresult["custlast"]." Business: ".$dbresult["custbusiness"];
	array_push($results, $entry);
	$id++;
}

$data["results"] = $results;

// Echo back results
echo json_encode($data);

// Close DB connection
pg_close($surestore_db);
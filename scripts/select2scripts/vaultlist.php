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
$dbquery = pg_query_params($surestore_db, "select * from surevault where LOWER(vaultid) like LOWER($1) and surevault.disabled = false and vaultid not in (select surevault.vaultid from surevault full outer join sureitems on surevault.vaultid = sureitems.itemvault where sureitems.datein is not null and sureitems.dateout is null and sureitems.itemvault is not null)", array($userinput));

// Initialize ID variable
$id = 1;

// Save result to associative array, iterate through array, assign results
while ($dbresult = pg_fetch_assoc($dbquery)) {
	$entry = [];
	$entry["id"] = $id;
	$entry["text"] = $dbresult["vaultid"];
	array_push($results, $entry);
	$id++;
}
$data["results"] = $results;

// Echo back results
echo json_encode($data);
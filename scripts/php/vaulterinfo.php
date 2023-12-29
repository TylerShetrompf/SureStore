<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';
// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

// Initialize vaulters array
$vaulters = [];

// vaulters query
$vaulterquery = pg_query($surestore_db, "select * from surevaulters");

// Iterate through results and add to array
while ($vaulterresult = pg_fetch_assoc($vaulterquery)) {
	
	// init empty entry array
	$entry = [];
	
	//assign values from result to entry array
	$entry["vaulterid"] = $vaulterresult["vaulterid"];
	$entry["vaulterfirst"] = $vaulterresult["vaulterfirst"];
	$entry["vaulterlast"] = $vaulterresult["vaulterlast"];
	
	// push entry array to vaulters array
	array_push($vaulters, $entry);
	
}

// Echo back to ajax
echo json_encode($vaulters);

// Close db connection
pg_close($surestore_db);
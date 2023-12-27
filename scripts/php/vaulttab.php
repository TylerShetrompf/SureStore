<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';
// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

// Initialize vaults array
$vaults = [];

// Vaults query
$vaultquery = pg_query($surestore_db, "select * from surevault");

// Iterate through results and add to array
while ($vaultresult = pg_fetch_assoc($vaultquery)) {
	
	// init empty entry array
	$entry = [];
	
	//assign values from result to entry array
	$entry["vaultid"] = $vaultresult["vaultid"];
	$entry["vaultwh"] = $vaultresult["vaultwh"];
	
	// push entry array to vaults array
	array_push($vaults, $entry);
	
}

// Echo back to ajax
echo json_encode($vaults);

// Close db connection
pg_close($surestore_db);
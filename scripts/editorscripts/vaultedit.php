<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';
// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

// init data array
$data = [];

// Initialize variables from POST
$vaultid = $_POST["vaultid"];
$vaultwh = $_POST["vaultwh"];
$oldid = $_POST["oldid"];
$oldwh = $_POST["oldwh"];

// query to update vault row
$vaultupdatequery = pg_query_params($surestore_db, "UPDATE surevault SET vaultid = $1, vaultwh = $2 WHERE vaultid = $3", array($vaultid, $vaultwh, $oldid));

//assign result to assoc array
$vaultupdateresult = pg_fetch_assoc($vaultupdatequery);

// log update to history log
$updatetext = $userid." updated vault ".$oldid." in warehouse ".$oldwh." to be ".$vaultid." in warehouse ".$vaultwh.".";
$histquery = pg_query_params($surestore_db, "insert into surehistory(histdesc) values($1)", array($updatetext));

// query new row
$vaultquery = pg_query_params($surestore_db, "select * from surevault where vaultid = $1", array($vaultid));

// assign new row to assoc array
$vaultresult = pg_fetch_assoc($vaultquery);

// Return new row
echo json_encode($vaultresult);

// Close DB connection
pg_close($surestore_db);
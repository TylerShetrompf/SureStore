<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';
// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

// init data array
$data = [];

//init variables from post
$vaulterid = $_POST["vaulterid"];
$vaulterfirst = $_POST["vaulterfirst"];
$vaulterlast = $_POST["vaulterlast"];
$oldid = $_POST["oldid"];


// get userid from cookie
$userid = $_COOKIE["userid"];

//query to update wh
$vaulterupdatequery = pg_query_params($surestore_db, "update surevaulters set vaulterid = $1, vaulterfirst = $2, vaulterlast = $3 where vaulterid = $4 RETURNING *;", array($vaulterid, $vaulterfirst, $vaulterlast, $oldid));

// log update to history log
$updatetext = $userid." updated vaulter ".$oldid." to be ".$vaulterid." with name ".$vaulterfirst." ".$vaulterlast.".";
$histquery = pg_query_params($surestore_db, "insert into surehistory(histdesc) values($1)", array($updatetext));

// query new row
$vaulterquery = pg_query_params($surestore_db, "select * from surevaulters where vaulterid = $1", array($vaulterid));

// assign new row to assoc array
$vaulterresult = pg_fetch_assoc($vaulterquery);

// Return new row
echo json_encode($vaulterresult);

// Close DB connection
pg_close($surestore_db);
<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';
// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

// init data array
$data = [];

// Initialize variables from POST
$looseid = $_POST["looseid"];
$loosewh = $_POST["loosewh"];
$disabled = $_POST["disabled"];
$oldid = $_POST["oldid"];
$oldwh = $_POST["oldwh"];

// query to update loose row
$looseupdatequery = pg_query_params($surestore_db, "UPDATE sureloose SET looseid = $1, loosewh = $2, disabled = $3 WHERE looseid = $4", array($looseid, $loosewh, $disabled, $oldid));

//assign result to assoc array
$looseupdateresult = pg_fetch_assoc($looseupdatequery);

// log update to history log
$updatetext = $userid." updated loose ".$oldid." in warehouse ".$oldwh." to be ".$looseid." in warehouse ".$loosewh." with status: ".$_POST["disabled"].".";
$histquery = pg_query_params($surestore_db, "insert into surehistory(histdesc) values($1)", array($updatetext));

// query new row
$loosequery = pg_query_params($surestore_db, "select * from sureloose where looseid = $1", array($looseid));

// assign new row to assoc array
$looseresult = pg_fetch_assoc($loosequery);

if ($looseresult["disabled"] == "f"){
	$looseresult["disabled"] = "Enabled";
}
if ($looseresult["disabled"] == "t"){
	$looseresult["disabled"] = "Disabled";
}

// Return new row
echo json_encode($looseresult);

// Close DB connection
pg_close($surestore_db);
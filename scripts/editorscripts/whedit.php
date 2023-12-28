<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';
// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

// init data array
$data = [];

//init variables from post
$whid = $_POST["whid"];
$whaddress = $_POST["whaddress"];
$whcity = $_POST["whcity"];
$whstate = $_POST["whstate"];
$whzip = $_POST["whzip"];
$whcountry = $_POST["whcountry"];
$oldid = $_POST["oldid"];

// get userid from cookie
$userid = $_COOKIE["userid"];

//query to update wh
$whcreatequery = pg_query_params($surestore_db, "update surewarehouse set whid=$1, whaddress = $2, whcity = $3, whstate = $4, whzip = $5, whcountry = $6 where whid = $7 RETURNING *;", array($whid, $whaddress, $whcity, $whstate, $whzip, $whcountry, $oldid));

// log update to history log
$updatetext = $userid." updated Warehouse ".$oldid." to be ".$whid." with address ".$whaddress." ".$whcity." ".$whstate." ".$whzip." ".$whcountry.".";
$histquery = pg_query_params($surestore_db, "insert into surehistory(histdesc) values($1)", array($updatetext));

// query new row
$whquery = pg_query_params($surestore_db, "select * from surewarehouse where whid = $1", array($whid));

// assign new row to assoc array
$whresult = pg_fetch_assoc($whquery);

// Return new row
echo json_encode($whresult);

// Close DB connection
pg_close($surestore_db);
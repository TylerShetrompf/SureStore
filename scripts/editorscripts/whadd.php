<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';
// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

//init data array
$data = [];

//init variables from post
$whid = $_POST["whid"];
$whaddress = $_POST["whaddress"];
$whcity = $_POST["whcity"];
$whstate = $_POST["whstate"];
$whzip = $_POST["whzip"];
$whcountry = $_POST["whcountry"];

// get userid from cookie
$userid = $_COOKIE["userid"];

//query to create wh
$whcreatequery = pg_query_params($surestore_db, "INSERT INTO surewarehouse(whid, whaddress, whcity, whstate, whzip, whcountry) VALUES($1, $2, $3, $4, $5, $6) RETURNING *;", array($whid, $whaddress, $whcity, $whstate, $whzip, $whcountry));

// assign result to variable
$whcreateresult = pg_fetch_assoc($whcreatequery);

if(pg_affected_rows($whcreatequery) == 0){
		$data["errors"] = "error here";
		echo json_encode($data);
} else {
	$updatetext = $userid." Added Warehouse ".$whcreateresult["whid"].".";
	$histquery = pg_query_params($surestore_db, "insert into surehistory(histdesc) values($1)", array($updatetext));
	echo json_encode($whcreateresult);
}

// Close DB connection
pg_close($surestore_db);
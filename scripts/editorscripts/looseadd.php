<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';
// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

//init data array
$data = [];

//init variables from post
$looseid = $_POST["looseid"];
$loosewh = $_POST["loosewh"];

// get userid from cookie
$userid = $_COOKIE["userid"];

//query to create loose
$loosecreatequery = pg_query_params($surestore_db, "INSERT INTO sureloose(looseid, loosewh) VALUES($1, $2) RETURNING *;", array($looseid, $loosewh));

// assign result to variable
$loosecreateresult = pg_fetch_assoc($loosecreatequery);

if(pg_affected_rows($loosecreatequery) == 0){
		$data["errors"] = "error here";
		echo json_encode($data);
} else {
	$updatetext = $userid." Added loose ".$loosecreateresult["looseid"]." to warehouse ".$loosecreateresult["loosewh"].".";
	$histquery = pg_query_params($surestore_db, "insert into surehistory(histdesc) values($1)", array($updatetext));
	echo json_encode($loosecreateresult);
}

// Close DB connection
pg_close($surestore_db);
<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';
// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

//init data array
$data = [];

//init variables from post
$vaulterfirst = $_POST["vaulterfirst"];
$vaulterlast = $_POST["vaulterlast"];

// get userid from cookie
$userid = $_COOKIE["userid"];

//query to create wh
$vaultercreatequery = pg_query_params($surestore_db, "INSERT INTO surevaulters(vaulterfirst, vaulterlast) VALUES($1, $2) RETURNING *;", array($vaulterfirst, $vaulterlast));

// assign result to variable
$vaultercreateresult = pg_fetch_assoc($vaultercreatequery);

if(pg_affected_rows($vaultercreatequery) == 0){
		$data["errors"] = "error here";
		echo json_encode($data);
} else {
	$updatetext = $userid." Added vaulter ".$vaultercreateresult["vaulterfirst"]." ".$vaultercreateresult["vaulterlast"].".";
	$histquery = pg_query_params($surestore_db, "insert into surehistory(histdesc) values($1)", array($updatetext));
	echo json_encode($vaultercreateresult);
}

// Close DB connection
pg_close($surestore_db);
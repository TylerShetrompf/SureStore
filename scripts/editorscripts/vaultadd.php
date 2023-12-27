<?php
// PHP to check session
//include '/var/www/html/scripts/php/reverifysession.php';
// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

//init data array
$data = [];

//init variables from post
$vaultid = $_POST["vaultid"];
$vaultwh = $_POST["vaultwh"];

// get userid from cookie
$userid = $_COOKIE["userid"];

//query to create vault
$vaultcreatequery = pg_query_params($surestore_db, "INSERT INTO surevault(vaultid, vaultwh) VALUES($1, $2) RETURNING *;", array($vaultid, $vaultwh));

// assign result to variable
$vaultcreateresult = pg_fetch_assoc($vaultcreatequery);

if(pg_affected_rows($vaultcreatequery) == 0){
		$data["errors"] = "error here";
		echo json_encode($data);
} else {
	$updatetext = $userid." Added vault ".$vaultcreateresult["vaultid"]." to warehouse ".$vaultcreateresult["vaultwh"].".";
	$histquery = pg_query_params($surestore_db, "insert into surehistory(histdesc) values($1)", array($updatetext));
	echo json_encode($vaultcreateresult);
}

// Close DB connection
pg_close($surestore_db);
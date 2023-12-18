<?php

// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

$data = [];

$itemdesc = $_POST["itemdesc"];
$itemvault = $_POST["itemvault"];
$itemloose = $_POST["itemloose"];
$itemorder = $_POST["itemorder"];
$userid = $_COOKIE["userid"];

// Turn vaulter name into vaulterid 
$itemvaultername = $_POST["itemvaulter"];
$vaulternamearray = explode(" ", $itemvaultername);
$vaulterfirst = $vaulternamearray[0];
$vaulterlast = $vaulternamearray[1];
$vaulteridquery = pg_query_params($surestore_db, "select * from surevaulters where LOWER(vaulterfirst) = LOWER($1) AND LOWER(vaulterlast) = LOWER($2)", array($vaulterfirst, $vaulterlast));
$vaulteridresult = pg_fetch_assoc($vaulteridquery);
$itemvaulter = $vaulteridresult["vaulterid"];

if ($itemvault && !$itemloose){
	$itemcreatequery = pg_query_params($surestore_db, "INSERT INTO sureitems (itemdesc, itemvault, itemorder, itemvaulter) VALUES ($1, $2, $3, $4) RETURNING *;", array($itemdesc, $itemvault, $itemorder, $itemvaulter));
	$createqueryresult = pg_fetch_assoc($itemcreatequery);
	$createqueryresult["itemvaulter"] = $itemvaultername;
	
	
	if(pg_affected_rows($itemcreatequery) == 0){
		$data["errors"] = "error here";
		echo json_encode($data);
	} else {
		// Log in surehistory
		$updatetext = $userid." Added item ".$createqueryresult["itemid"]." in order ".$itemorder.".";
		$histquery = pg_query_params($surestore_db, "insert into surehistory(historder, histdesc) values($1, $2)", array($itemorder,$updatetext));
		echo json_encode($createqueryresult);
	}
}

if ($itemloose && !$itemvault){
	$itemcreatequery = pg_query_params($surestore_db, "INSERT INTO sureitems (itemdesc, itemloose, itemorder, itemvaulter) VALUES ($1, $2, $3, $4) RETURNING *;", array($itemdesc, $itemloose, $itemorder, $itemvaulter));
	$createqueryresult = pg_fetch_assoc($itemcreatequery);
	$createqueryresult["itemvaulter"] = $itemvaultername;
	
	if(pg_affected_rows($itemcreatequery) == 0){
		$data["errors"] = "error here";
		echo json_encode($data);
	} else {
		// Log in surehistory
		$updatetext = $userid." Added item ".$createqueryresult["itemid"]." in order ".$itemorder.".";
		$histquery = pg_query_params($surestore_db, "insert into surehistory(historder, histdesc) values($1, $2)", array($itemorder,$updatetext));
		echo json_encode($createqueryresult);
	}
	
}

// Close DB connection
pg_close($surestore_db);
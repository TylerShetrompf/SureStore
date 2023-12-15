<?php

// Include db connection
include '/var/www/html/scripts/connectdb.php';

$data = [];
// Initialize variables from POST
$itemid = $_POST["itemid"];
$itemdesc = $_POST["itemdesc"];
$itemvault = $_POST["itemvault"];
$itemloose = $_POST["itemloose"];

// Turn vaulter name into vaulterid 
$itemvaultername = $_POST["itemvaulter"];
$vaulternamearray = explode(" ", $itemvaultername);
$vaulterfirst = $vaulternamearray[0];
$vaulterlast = $vaulternamearray[1];
$vaulteridquery = pg_query_params($surestore_db, "select * from surevaulters where vaulterfirst = $1 AND vaulterlast = $2", array($vaulterfirst, $vaulterlast));
$vaulteridresult = pg_fetch_assoc($vaulteridquery);
$itemvaulter = $vaulteridresult["vaulterid"];

// Query 
$itemidquery = pg_query_params($surestore_db, "select * from sureitems where itemid = $1", array($itemid));

// Assign result to variable
$itemidresult = pg_fetch_assoc($itemidquery);

// Check if return false
if($itemidresult == false){
	$data["errors"] = "itemid does not exist";
	echo json_encode($data);
} else {
	if ($itemloose){
		$itemupdatequery = pg_query_params($surestore_db, "UPDATE sureitems SET itemdesc = $1, itemloose = $2, itemvaulter = $3 WHERE itemid = $4", array($itemdesc, $itemloose, $itemvaulter, $itemid));
		$itemidquery2 = pg_query_params($surestore_db, "select * from sureitems where itemid = $1", array($itemid));
		$itemidresult2 = pg_fetch_assoc($itemidquery2);		
	} else {
		$itemupdatequery = pg_query_params($surestore_db, "UPDATE sureitems SET itemdesc = $1, itemvault = $2, itemvaulter = $3 WHERE itemid = $4", array($itemdesc, $itemvault, $itemvaulter, $itemid));
		$itemidquery2 = pg_query_params($surestore_db, "select * from sureitems where itemid = $1", array($itemid));
		$itemidresult2 = pg_fetch_assoc($itemidquery2);
	}
	echo json_encode($itemidresult2);
}

// Close DB connection
pg_close($surestore_db);

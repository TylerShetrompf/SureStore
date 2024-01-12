<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';

// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

// Initialize data array
$data = [];

// initialize variables from post
$oldorderid = $_POST["oldorderid"];
$orderid = $_POST["orderid"];
$orderwh = $_POST["orderwh"];
$weight = $_POST["weight"];

// initialize userid variable from cookie
$userid = $_COOKIE["userid"];

if ($oldorderid != $orderid) {
	$orderidquery = pg_query_params($surestore_db, "update sureorders set orderid = $1 where orderid = $2", array($orderid, $oldorderid));
	if (pg_affected_rows($orderidquery) == 0){
		$data["success"] = "false";
	} else {
		// Log in surehistory
		$updatetext = $userid." changed orderid from ".$oldorderid." to ".$orderid.".";
		$histquery = pg_query_params($surestore_db, "insert into surehistory(historder, histdesc) values($1, $2)", array($orderid,$updatetext));
	}
}

if ($_POST["dateout"]) {
	$dateout = $_POST["dateout"];
	$dateoutquery = pg_query_params($surestore_db, "update sureitems set dateout = $1 where itemorder = $2 and dateout IS NULL", array($dateout, $orderid));
	if(pg_affected_rows($dateoutquery) == 0){
		$data["success"] = "false";
	} else {
		// Log in surehistory
		$updatetext = $userid." set date out of order ".$orderid." to ".$dateout.".";
		$histquery = pg_query_params($surestore_db, "insert into surehistory(historder, histdesc) values($1, $2)", array($orderid,$updatetext));
	}
}
if ($_POST["ordertype"]) {
	$ordertype = $_POST["ordertype"];
	$ordertypequery = pg_query_params($surestore_db, "update sureorders set ordertype = $1 where orderid = $2", array($ordertype, $orderid));
	if(pg_affected_rows($ordertypequery) == 0){
		$data["success"] = "false";
	} else {
		// Log in surehistory
		$updatetext = $userid." labeled order ".$orderid." as type ".$ordertype.".";
		$histquery = pg_query_params($surestore_db, "insert into surehistory(historder, histdesc) values($1, $2)", array($orderid,$updatetext));
	}
}

if ($_POST["valtype"]) {
	$valtype = $_POST["valtype"];
	$valtypequery = pg_query_params($surestore_db, "update sureorders set valtype = $1 where orderid = $2", array($valtype, $orderid));
	if(pg_affected_rows($valtypequery) == 0){
		$data["success"] = "false";
	} else {
		// Log in surehistory
		$updatetext = $userid." labeled order ".$orderid." valtype as type ".$valtype.".";
		$histquery = pg_query_params($surestore_db, "insert into surehistory(historder, histdesc) values($1, $2)", array($orderid,$updatetext));
	}
}

if ($_POST["orderval"]) {
	$orderval = $_POST["orderval"];
	$ordervalquery = pg_query_params($surestore_db, "update sureorders set orderval = $1 where orderid = $2", array($orderval, $orderid));
	if(pg_affected_rows($ordervalquery) == 0){
		$data["success"] = "false";
	} else {
		// Log in surehistory
		$updatetext = $userid." set order ".$orderid." value as ".$orderval.".";
		$histquery = pg_query_params($surestore_db, "insert into surehistory(historder, histdesc) values($1, $2)", array($orderid,$updatetext));
	}
}

$updatequery = pg_query_params($surestore_db, "update sureorders set orderwh = $1, weight = $2 where orderid = $3", array($orderwh, $weight, $orderid));
if(pg_affected_rows($updatequery) == 0){
	$data["success"] = "false";
} else {
		// Log in surehistory
		$updatetext = $userid." updated ".$orderid." warehouse to ".$orderwh.", and weight to ".$weight.".";
		$histquery = pg_query_params($surestore_db, "insert into surehistory(historder, histdesc) values($1, $2)", array($orderid,$updatetext));
}
echo json_encode($data);

// Close DB connection
pg_close($surestore_db);
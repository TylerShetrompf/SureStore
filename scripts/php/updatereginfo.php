<?php

// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

// Initialize data array
$data = [];

// initialize variables from post
$oldorderid = $_POST["oldorderid"];
$orderid = $_POST["orderid"];
$orderwh = $_POST["orderwh"];
$datein = $_POST["datein"];
$weight = $_POST["weight"];

if ($oldorderid != $orderid) {
	$orderidquery = pg_query_params($surestore_db, "update sureorders set orderid = $1 where orderid = $2", array($orderid, $oldorderid));
	if (pg_affected_rows($orderidquery) == 0){
		$data["success"] = "false";
		$data["orderidup"] = "OrderID update failed";
	}
}

if ($_POST["dateout"]) {
	$dateout = $_POST["dateout"];
	$dateoutquery = pg_query_params($surestore_db, "update sureorders set dateout = $1 where orderid = $2", array($dateout, $orderid));
	if(pg_affected_rows($dateoutquery) == 0){
		$data["success"] = "false";
		$data["dateoutup"] = "DateOut update failed";
	}
}
if ($_POST["ordermil"]) {
	$ordermil = $_POST["ordermil"];
	$ordermilquery = pg_query_params($surestore_db, "update sureorders set ordermil = $1 where orderid = $2", array($ordermil, $orderid));
	if(pg_affected_rows($ordermilquery) == 0){
		$data["success"] = "false";
		$data["ordermilup"] = "OrderMil update failed";
	}
}

$updatequery = pg_query_params($surestore_db, "update sureorders set orderwh = $1, datein = $2, weight = $3 where orderid = $4", array($orderwh, $datein, $weight, $orderid));
if(pg_affected_rows($updatequery) == 0){
	$data["success"] = "false";
	$data["orderup"] = "Order update failed";
}
echo json_encode($data);
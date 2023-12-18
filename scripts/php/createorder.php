<?php

// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

$data = [];

// Initialize customer vars
$custbusiness = $_POST["custbusiness"];
$custtn = $_POST["custtn"];
$custtn = preg_replace("/[^0-9]/", "", $custtn );
$custfirst = $_POST["custfirst"];
$custlast = $_POST["custlast"];
$custaddress = $_POST["custaddress"];
$custcity = $_POST["custcity"];
$custzip = $_POST["custzip"];
$custstate = $_POST["custstate"];
$custcountry = $_POST["custcountry"];

// Initialize order vars
$orderid = $_POST["orderid"];
$orderwh = $_POST["orderwh"];
$datein = $_POST["datein"];
$weight = $_POST["weight"];

// Userid from cookie
$userid = $_COOKIE["userid"];

// Cust query
$custquery = pg_query_params($surestore_db, "insert into surecustomer(custbusiness, custtn, custfirst, custlast, custaddress, custcity, custzip, custstate, custcountry) values($1, $2, $3, $4, $5, $6, $7, $8, $9) returning custid", array($custbusiness, $custtn, $custfirst, $custlast, $custaddress, $custcity, $custzip, $custstate, $custcountry));

// cust result
$custresult = pg_fetch_assoc($custquery);

// check if row created
if (pg_affected_rows($custquery) == 0){
	
	$data["success"] = "false";
	echo json_encode($data);
	
} else {
	$data["custid"] = $custresult;
	// order query
	$orderquery = pg_query_params($surestore_db, "insert into sureorders(orderid, orderwh, datein, weight, ordercust) values($1, $2, $3, $4, $5)", array($orderid, $orderwh, $datein, $weight, $custresult["custid"]));
	
	// check if row created
	if (pg_affected_rows($orderquery) == 0){
		
		$data["success"] = "false";
		echo json_encode($data);
		
	} else {
		
		// cust hist
		$custhisttext = $userid." created customer ".$custfirst." ".$custlast.".";
		$custhistquery = pg_query_params($surestore_db, "insert into surehistory(histdesc, historder) values($1, $2)", array($custhisttext, $orderid));
		
		// order hist
		$orderhisttext = $userid." created order ".$orderid." "." with customer ".$custfirst." ".$custlast.".";
		$custhistquery = pg_query_params($surestore_db, "insert into surehistory(histdesc, historder) values($1, $2)", array($custhisttext, $orderid));
		
		$data["success"] = "true";
		echo json_encode($data);
		
	}

}

pg_close($surestore_db);
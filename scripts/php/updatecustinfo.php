<?php

// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

// Initialize data array
$data = [];

// get variables from post
$custbus = $_POST["custbusiness"];
$custtn = $_POST["custtn"];
$custfirst = $_POST["custfirst"];
$custlast = $_POST["custlast"];
$custaddress = $_POST["custaddress"];
$custcity = $_POST["custcity"];
$custzip = $_POST["custzip"];
$orderid = $_POST["orderid"];
$custstate = $_POST["custstate"];
$custcountry = $_POST["custcountry"];

// initialize userid variable from cookie
$userid = $_COOKIE["userid"];

// check if custid was posted, if not make a new customer
if ($_POST["custid"]) {
	$custid = $_POST["custid"];
	$custupquery = pg_query_params($surestore_db, "update surecustomer set custbusiness = $1, custtn = $2, custfirst = $3, custlast = $4, custaddress = $5, custcity = $6, custzip = $7, custstate = $8, custcountry = $9 where custid = $10", array($custbus, $custtn, $custfirst, $custlast, $custaddress, $custcity, $custzip, $custstate, $custcountry, $custid));
	
	if (pg_affected_rows($custupquery) == 0){
		$data["success"] = "false";
	} else {
		// Log in surehistory
		$updatetext = $userid." updated customer information for ".$custfirst." ".$custlast.".";
		$histquery = pg_query_params($surestore_db, "insert into surehistory(historder, histdesc) values($1, $2)", array($orderid,$updatetext));
	}
} else {
	$custcreatequery = pg_query_params($surestore_db, "insert into surecustomer(custbusiness, custtn, custfirst, custlast, custaddress, custcity, custzip, custstate, custcountry) values($1, $2, $3, $4, $5, $6, $7, $8, $9) returning custid", array($custbus, $custtn, $custfirst, $custlast, $custaddress, $custcity, $custzip, $custstate, $custcountry));
	
	if(pg_affected_rows($custcreatequery) == 0){
		$data["success"] = "false";
	} else {
		$newcustrow = pg_fetch_assoc($custcreatequery);
		$custid = $newcustrow[0];
		$ordercustquery = pg_query_params($surestore_db, "update sureorders set ordercust = $1 where orderid = $2", array($custid, $orderid));
		if(pg_affected_rows($ordercustquery) == 0){
			$data["success"] = "false";
		} else {
			// Log in surehistory
			$updatetext = $userid." updated customer information for order ".$orderid." to ".$custfirst." ".$custlast.".";
			$histquery = pg_query_params($surestore_db, "insert into surehistory(historder, histdesc) values($1, $2)", array($orderid,$updatetext));
		}
	}

}
echo json_encode($data);

// Close DB connection
pg_close($surestore_db);
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

// initialize userid variable from cookie
$userid = $_COOKIE["userid"];

// check if custid was posted, if not make a new customer
if ($_POST["custid"]) {
	$custid = $_POST["custid"];
	$custupquery = pg_query_params($surestore_db, "update surecustomer set custbusiness = $1, custtn = $2, custfirst = $3, custlast = $4, custaddress = $5, custcity = $6, custzip = $7 where custid = $8", array($custbus, $custtn, $custfirst, $custlast, $custaddress, $custcity, $custzip, $custid));
	
	if (pg_affected_rows($custupquery) == 0){
		$data["success"] = "false";
	} else {
		// Log in surehistory
		$updatetext = $userid." updated customer information for ".$custfirst." ".$custlast.".";
		$histquery = pg_query_params($surestore_db, "insert into surehistory(historder, histdesc) values($1, $2)", array($orderid,$updatetext));
	}
} else {
	$custcreatequery = pg_query_params($surestore_db, "insert into surecustomer(custbusiness, custtn, custfirst, custlast, custaddress, custcity, custzip) values($1, $2, $3, $4, $5, $6, $7) returning custid", array($custbus, $custtn, $custfirst, $custlast, $custaddress, $custcity, $custzip));
	
	if(pg_affected_rows($custcreatequery) == 0){
		$data["success"] = "false";
	}
	$newcustrow = pg_fetch_row($custcreatequery);
	$custid = $newcustrow[0];
	$ordercustquery = pg_query_params($surestore_db, "update sureorders set ordercust = $1 where orderid = $2", array($custid, $orderid));
	if(pg_affected_rows($ordercustquery) == 0){
		$data["success"] = "false";
	}
}
echo json_encode($data);

// Close DB connection
pg_close($surestore_db);
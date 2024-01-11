<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';
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
$ordertype = $_POST["ordertype"];

// Userid from cookie
$userid = $_COOKIE["userid"];

if ($_POST["custid"]) {
	$custid = $_POST["custid"];
	
	$custupquery = pg_query_params($surestore_db, "update surecustomer set custbusiness = $1, custtn = $2, custfirst = $3, custlast = $4, custaddress = $5, custcity = $6, custzip = $7, custstate = $8, custcountry = $9 where custid = $10", array($custbusiness, $custtn, $custfirst, $custlast, $custaddress, $custcity, $custzip, $custstate, $custcountry, $custid));
	
	if (pg_affected_rows($custupquery) == 0){
		$data["success"] = "false";
		echo json_encode($data);
	} else {
		// Log in surehistory
		$updatetext = $userid." updated customer information for ".$custfirst." ".$custlast.".";
		$histquery = pg_query_params($surestore_db, "insert into surehistory(historder, histdesc) values($1, $2)", array($orderid,$updatetext));
		
		// order query
		$orderquery = pg_query_params($surestore_db, "insert into sureorders(orderid, orderwh, datein, weight, ordercust, ordertype) values($1, $2, $3, $4, $5, $6)", array($orderid, $orderwh, $datein, $weight, $custid, $ordertype));

		// check if row created
		if (pg_affected_rows($orderquery) == 0){

			$data["success"] = "false";
			echo json_encode($data);

		} else {
			
			// order hist
			$orderhisttext = $userid." created order ".$orderid." "." with customer ".$custfirst." ".$custlast.".";
			$orderhistquery = pg_query_params($surestore_db, "insert into surehistory(histdesc, historder) values($1, $2)", array($orderhisttext, $orderid));

			$data["success"] = "true";
			echo json_encode($data);

		}
	}
	
} else {
	
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
		$orderquery = pg_query_params($surestore_db, "insert into sureorders(orderid, orderwh, datein, weight, ordercust, ordertype) values($1, $2, $3, $4, $5, $6)", array($orderid, $orderwh, $datein, $weight, $custresult["custid"], $ordertype));

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
			$orderhistquery = pg_query_params($surestore_db, "insert into surehistory(histdesc, historder) values($1, $2)", array($orderhisttext, $orderid));

			$data["success"] = "true";
			echo json_encode($data);

		}

	}
	
}

pg_close($surestore_db);
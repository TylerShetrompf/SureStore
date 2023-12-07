<?php

// Kill and go to login if no session or user cookie
if ((!isset($_COOKIE["userid"])) or (!isset($_COOKIE["sessionid"]))) {
	header('Location: https://www.surestore.store');
	die();
} else {
	//Include DB connection
	include '/var/www/html/scripts/connectdb.php';
	
	// Set variables to cookie values
	$userid = $_COOKIE['userid'];
	$sessionid = $_COOKIE['sessionid'];
	
	// Query for rows
	$query = pg_query_params($surestore_db, 'SELECT userid, sessionid FROM sureusers WHERE userid = $1', array($userid));
	
	// Get results to array
	$results = pg_fetch_assoc($query);
	
	// Close DB connection
	pg_close($surestore_db);
	
	// Set vars for db values
	$useridresult = $results["userid"];
	$sessionidresult = $results["sessionid"];
	
	// Make sure userid exists and session id matches
	if (empty($useridresult)) {
		die();
	} 	elseif ($sessionidresult != $sessionid) {
		die();
	}
}
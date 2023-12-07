<?php

// Initialize arrays for error messages and data
$data = [];

$surestore_db = pg_pconnect("host=localhost dbname=SureStore user=postgres password=97DnXjPQSUu$925atBo!9WZuAf@7aaWQ");

$userid = $_POST['userid'];
$sessionid = $_POST['sessionid'];
$query = pg_query_params($surestore_db, 'SELECT userid, sessionid FROM sureusers WHERE userid = $1', array($userid));

$results = pg_fetch_assoc($query);

$useridresult = $results["userid"];
$sessionidresult = $results["sessionid"];

pg_close($surestore_db);

if (empty($useridresult)) {
	$data["success"] = false;
} elseif ($sessionidresult != $sessionid) {
	$data["success"] = false;
} else {
	$data["success"] = true;
}

echo json_encode($data);
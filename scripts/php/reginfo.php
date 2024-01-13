<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';

// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

// Initialize data array
$data = [];

// get orderid from post
$orderid = $_POST["orderid"];

//query for reginfo
$reginfoquery = pg_query_params($surestore_db, "select sureorders.orderid, sureorders.orderwh, sureorders.weight, sureorders.ordertype, sureorders.valtype, sureorders.orderval, sureorders.sitnum from sureorders where sureorders.orderid=$1", array($orderid));

// assign results to assoc array
$reginforesults = pg_fetch_assoc($reginfoquery);

// query for lastmod time
$lastmodquery = pg_query_params($surestore_db, "select timezone('US/Eastern', date_trunc('minute', histtime)) as histtime from surehistory where historder = $1 order by histtime desc limit 1", array($orderid));

// assign results to assoc array
$lastmodresult = pg_fetch_assoc($lastmodquery);

// add histtime to reginforresults array
$reginforesults["histtime"] = $lastmodresult["histtime"];

// query to get datein
$dateinquery = pg_query_params($surestore_db, "select datein from sureitems where itemorder = $1 order by datein asc limit 1", array($orderid));

// assign results to assoc array
$dateinresult = pg_fetch_assoc($dateinquery);

// add datein to reginforresults array
$reginforesults["datein"] = $dateinresult["datein"];

// query to get dateout
$dateoutquery = pg_query_params($surestore_db, "select dateout from sureitems where itemorder = $1 order by dateout desc limit 1", array($orderid));

// assign results to assoc array
$dateoutresult = pg_fetch_assoc($dateoutquery);

// add dateout to reginforresults array
$reginforesults["dateout"] = $dateoutresult["dateout"];

echo json_encode($reginforesults);

// Close DB connection
pg_close($surestore_db);

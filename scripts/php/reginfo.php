<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';

// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

// Initialize data array
$data = [];

$orderid = $_POST["orderid"];

$reginfoquery = pg_query_params($surestore_db, "select sureorders.orderid, sureorders.orderwh, sureorders.datein, sureorders.dateout, sureorders.weight, sureorders.ordertype from sureorders where sureorders.orderid=$1", array($orderid));

$reginforesults = pg_fetch_assoc($reginfoquery);

$lastmodquery = pg_query_params($surestore_db, "select timezone('US/Eastern', date_trunc('minute', histtime)) as histtime from surehistory where historder = $1 order by histtime desc limit 1", array($orderid));

$lastmodresult = pg_fetch_assoc($lastmodquery);

$reginforesults["histtime"] = $lastmodresult["histtime"];

echo json_encode($reginforesults);

// Close DB connection
pg_close($surestore_db);

<?php
// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

$results = [];

$custfirst = $_POST["custfirst"];
$custlast = $_POST["custlast"];

$custquery = pg_query_params($surestore_db, "select * from surecustomer where custfirst=$1 and custlast=$2", array($custfirst,$custlast));

$custresult = pg_fetch_assoc($custquery);

echo json_encode($custresult);

// Close DB connection
pg_close($surestore_db);
<?php
include '/var/www/html/scripts/connectdb.php';
$userinput = $_POST['query'];
$dbquery = pg_query_params($surestoredb, "SELECT * from sureorders WHERE orderid LIKE $1 OR ordercust LIKE $1", array($us erinput));

$dbresult = pg_fetch_assoc($dbquery);

echo json_encode($searchresult);

pg_close($surestore_db);
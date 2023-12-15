<?php

// Include db connection
include '/var/www/html/scripts/connectdb.php';

$itemid = $_POST["itemid"];

$deletequery = pg_query_params($surestore_db, "DELETE FROM sureitems where itemid = $1", array($itemid));
$deletequeryresult = pg_fetch_assoc($deletequery);

echo json_encode($deletequeryresult);
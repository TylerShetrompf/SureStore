<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';
// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

$itemid = $_POST["itemid"];
$itemorder = $_POST["itemorder"];
$userid = $_COOKIE["userid"];

$deletequery = pg_query_params($surestore_db, "DELETE FROM sureitems where itemid = $1", array($itemid));
$deletequeryresult = pg_fetch_assoc($deletequery);

$updatetext = $userid." deleted item ".$itemid." from order ".$orderid.".";
$histquery = pg_query_params($surestore_db, "insert into surehistory(historder, histdesc) values($1, $2)", array($itemorder,$updatetext));

echo json_encode($deletequeryresult);
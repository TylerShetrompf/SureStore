<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';
// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

// get vaultid from post
$vaultid = $_POST["vaultid"];

// get user id from cookie
$userid = $_COOKIE["userid"];

//delete query 
$deletequery = pg_query_params($surestore_db, "DELETE FROM surevault where vaultid = $1", array($vaultid));

// assign result to array
$deletequeryresult = pg_fetch_assoc($deletequery);

// log in history table
$updatetext = $userid." deleted vault ".$vaultid.".";
$histquery = pg_query_params($surestore_db, "insert into surehistory(histdesc) values($1)", array($updatetext));

// echo back result
echo json_encode($deletequeryresult);

// Close DB connection
pg_close($surestore_db);
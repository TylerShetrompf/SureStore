<?php


// Include connection to postgresql database
include '/var/www/html/scripts/php/connectdb.php';

// initialize variable from cookie
$userid = $_COOKIE["userid"];

$newsessionid = password_hash(($userid.time()), PASSWORD_DEFAULT);
$logoutquery = pg_query_params($surestore_db, "update sureusers set sessionid = $1 where LOWER(userid) = LOWER($2)", array($newsessionid, $userid));
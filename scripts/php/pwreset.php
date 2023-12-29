<?php 
// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

$userid = $_POST['userid'];
$actcode = rand(10000,99999);

$resetmessage = "Please click the following link to activate your account: https://www.surestore.store/reset.php?actcode=$actcode&userid=$userid";

$updateactquery = pg_query_params($surestore_db, "UPDATE sureusers SET actcode = $1 WHERE userid = $2", array($actcode, $userid));

mail($userid, "Password Reset", $resetmessage, "From: admin@surestore.store");

echo json_encode("success");

// Close database connection
pg_close($surestore_db);
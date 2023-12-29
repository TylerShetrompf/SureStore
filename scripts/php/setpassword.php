<?php

// Connect to DB
include '/var/www/html/scripts/php/connectdb.php';

// init data array
$data = [];

//get variables from post
$actcode = $_POST['actcode'];
$userid = $_POST['userid'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$newactcode = rand(10000,99999);

// query to update password
$updatequery = pg_query_params($surestore_db, "UPDATE sureusers SET userpw = $1, actcode = $2 WHERE userid = $3 and actcode = $4", array($password, $newactcode, $userid, $actcode));

$affected = pg_affected_rows($updatequery);

if ($affected == 0) {
	$data["success"] = false;
	echo json_encode($data);
} else {
	$data["success"] = true;
	echo json_encode($data);
}
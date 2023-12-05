<?php

// Initialize arrays for error messages and data
$errors = [];
$data = [];

// Initialize array for user data
$userData = [];

// Initialize variables from POST'd data
$userid = $_POST['email'];
$userpw = password_hash($_POST['password'], PASSWORD_DEFAULT);
$useracl = "1"; // Set user ACL to '1' = user
$userfirst = $_POST['firstname'];
$userlast = $_POST['lastname'];
$activated = 0;
$actcode = rand(10000,99999);

echo $userid;
echo $userfirst;


// Connect to Postgresql database
$surestore_db = pg_pconnect("host=localhost dbname=SureStore user=postgres password=97DnXjPQSUu$925atBo!9WZuAf@7aaWQ");

// Check if account exists with email
// Query for user check
$checkuserquery = pg_query_params($surestore_db, 'SELECT userid FROM sureusers WHERE userid = $1', array($userid));

// Results for user check as assoc array
$checkuserresults = pg_fetch_assoc($checkuserquery);

// Add error if email is in use
if($checkuserresults){
	$errors['username'] = 'Email already in use';
}

// If email is not in use, create entry in table.
if(!$checkuserresults){
	$createuserquery = pg_query_params($surestore_db, "INSERT INTO sureusers(userid, userpw, useracl, userfirst, userlast, activated, actcode) VALUES ($1, $2, $3, $4, $5, $6, $7)", array($userid, $userpw, $useracl, $userfirst, $userlast, $activated, $actcode));
}

echo $userid;
echo $userfirst;

pg_close($surestore_db);
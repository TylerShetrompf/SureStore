<?php

// Include connection to postgresql database
include '/var/www/html/scripts/connectdb.php';

// Initialize arrays for error messages and data
$errors = [];
$data = [];

$userid = $_POST['username'];

// Retrieve username and password from database
$query = pg_query_params($surestore_db, 'SELECT userid, userpw, activated FROM sureusers WHERE LOWER(userid) = LOWER($1)', array($userid));

// Fetch results as an array
$results = pg_fetch_assoc($query);

// Create variable for username and password
$username = $results["userid"];
$dbpassword = $results["userpw"];
$activated = $results["activated"];

// Set var for posted password
$password = $_POST['password'];

// Close DB connection
pg_close($surestore_db);

// Return error text if username or password is incorrect.
 if (empty($username)) {
	$errors['password'] = 'Username or password is incorrect';
} elseif(!password_verify($password,$dbpassword)) {
	$errors['password'] = 'Username or password is incorrect';
} elseif($activated != "t"){
	$errors['activation'] = 'This account is not activated. Please check your email for an activation link.';
 }



if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {
	
	include '/var/www/html/scripts/connectdb.php';
	// Create session cookie
	$sessioncookiename = "sessionid";
	$sessioncookieval = password_hash(($userid.time()), PASSWORD_DEFAULT);
	setcookie($sessioncookiename, $sessioncookieval, time() + (86400 * 7), "/");
	
	// Create user cookie
	$usercookiename = "userid";
	$usercookieval = "$userid";
	setcookie($usercookiename, $usercookieval, time() + (86400 * 7), "/");
	
	// Insert session cookie
	$cookiequery = pg_query_params($surestore_db, "UPDATE sureusers SET sessionid = $1 WHERE LOWER(userid) = LOWER($2)", array($sessioncookieval, $userid));
	
	pg_close($surestore_db);
	
    $data['success'] = true;
    $data['message'] = 'Success!';
}

echo json_encode($data);

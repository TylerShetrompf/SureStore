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

// Check password length:
$pwlength = strlen($_POST['password']);
if ($pwlength < 8){
	$errors['password'] = 'Password must be at least 8 characters long.';
} else {
	
	// Initialize variables from POST'd data
	$userid = $_POST['email'];
	$userpw = password_hash($_POST['password'], PASSWORD_DEFAULT);
	$useracl = "1"; // Set user ACL to '1' = user
	$userfirst = $_POST['firstname'];
	$userlast = $_POST['lastname'];
	$activated = 0;
	$actcode = rand(10000,99999);
	
	// Connect to Postgresql database
	include '/var/www/html/scripts/connectdb.php';

	// Check if account exists with email
	// Query for user check
	$checkuserquery = pg_query_params($surestore_db, 'SELECT userid FROM sureusers WHERE userid = $1', array($userid));
	
	// Results for user check as assoc array
	$checkuserresults = pg_fetch_assoc($checkuserquery);
	
	// Add error if email is in use
	if($checkuserresults){
		$errors['username'] = 'Email already in use';
	}

	// Initialize variable for activation code email body
	$actmessage = "Please click the following link to activate your account: https://www.surestore.store/activate.php?actcode=$actcode&userid=$userid";

	// If email is not in use, create entry in table.
	if(!$checkuserresults){
		$createuserquery = pg_query_params($surestore_db, "INSERT INTO sureusers(userid, userpw, useracl, userfirst, userlast, activated, actcode) VALUES ($1, $2, $3, $4, $5, $6, $7)", array($userid, $userpw, $useracl, $userfirst, $userlast, $activated, $actcode));

		// Send registration code email
		mail($userid, "Registration Key", $actmessage, "From: admin@surestore.store");
	}
	
	// Close database connection
	pg_close($surestore_db);
	
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {
    $data['success'] = true;
    $data['message'] = 'Success!';
}

echo json_encode($data);
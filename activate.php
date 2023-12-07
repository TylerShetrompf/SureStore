<!doctype html>
<html>

<head>
<meta charset="utf-8">
<title>Account Activated</title>
<link rel="shortcut icon" href="https://www.surestore.store/images/favicon.ico">
<link rel="stylesheet" href="/style/style.css">
<style>
	body {
		align-content: center;
	}
	#activationerror {
		background-color: #000000;
	}

	h1 {
		padding: 12px 20px;
		display: inline-block;
		border: 1px solid #ccc;
		border-radius: 20px;
		box-sizing: border-box;
		background-color: #5781A4;
	}	
</style>
</head>

<body>
	<?php
		// Initialize variables from GET in email link
		$actcode = $_GET['actcode'];
		$userid = $_GET['userid'];
	
		// Connect to DB
		include '/var/www/html/scripts/connectdb.php';
	
		// Query to check that user exists with proper activation code
		$checkuserquery = pg_query_params($surestore_db, "SELECT * FROM sureusers WHERE userid = $1 AND actcode = $2", array($userid, $actcode));
		$checkuserresults = pg_fetch_assoc($checkuserquery);

		// Validate query
		if($checkuserresults){
			$actuserquery = pg_query_params($surestore_db, "UPDATE sureusers SET activated = 'TRUE' WHERE userid = $1 AND actcode = $2", array($userid, $actcode));
			echo('<img src="images/logoSmol.png" alt="logo" size="50%">');
			echo('<h1>Congratulations! ');
			echo('Your SureStore account is now activated. ');
			echo('Please click the button below to return to the login page:</h1>');
			echo('<form id="returntologin" action="https://surestore.store">');
			echo('<button type="submit" class="stylish-button"/>Go to login</form>');
		} else {
			echo('<img src="images/logoSmol.png" alt="logo" size="50%">');
			echo('<div class="help-block">');
			echo('<h1 id="activationerror"> Activation link invalid. Please try again or contact your server administrator. </h1>');
			echo('</div>');
			echo('<form id="returntologin" action="https://surestore.store">');
			echo('<button type="submit" class="stylish-button"/>Go to login</form>');
		}
		pg_close($surestore_db);
	?>
</body>
</html>

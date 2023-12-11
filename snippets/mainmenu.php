<?php
	// PHP to check session
	include '/var/www/html/scripts/reverifysession.php';
?>

<div class="topnav">
	<a href="#Home" class="navbutton">Home</a>
	<a href="#Logout" class="navbutton">Logout</a>
</div>
<div class="mainMenu">
	<form id="locatorButton" class="mainButton">
		<button type=button id="locButton" class="stylish-button">Locator</button>
	</form>
	<form id="maintbuttonform" class="mainButton">
		<button type=button id="maintButton" class="stylish-button">Maintenance</button>
	</form>
	<form id="adminbuttonform" class="mainButton">
		<button type=button id="adminButton" class="stylish-button">Admin</button>
	</form>
</div>
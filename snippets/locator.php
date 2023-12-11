<?php
	// PHP to check session
	include '/var/www/html/scripts/reverifysession.php';
?>

<div class="topnav">
	<a href="#Home" class="navbutton" id="homenav">Home</a>
	<a href="#Logout" class="navbutton" id="logoutnav">Logout</a>
</div>
<select class="vaultSearch" name="search" id="search">
</select>
<h2> OR </h2>
<form id="scanbuttonform" class="mainButton">
	<button type="button" id="scanButton" class="stylish-button">Scan</button>
</form>
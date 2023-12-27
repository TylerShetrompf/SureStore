<?php

// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';

echo ('

<div class="navbar navbar-expand-lg navbar-dark bg-dark">
	<div class="navbar-brand mx-3">
		<img src="images/logoTiny.png" alt="logo" size="25%">
	</div>
	<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarnav" aria-controls="navbarnav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	
	<div class="collapse navbar-collapse" id="navbarnav">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item mx-3"><a class="nav-link" href="#Home" id="homenav">Home</a></li>
			<li class="nav-item mx-3"><a class="nav-link" href="#Scan" id="scanButton" data-bs-toggle="modal" data-bs-target="#scanModal">Scan</a></li>
			<li class="nav-item mx-3"><a class="nav-link" href="https://surestore.store" id="logoutnav">Logout</a></li>
		</ul>
	</div>
</div>

');

?>
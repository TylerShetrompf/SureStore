<?php
	// PHP to check session
	include '/var/www/html/scripts/reverifysession.php';
?>

<!-- 3 Columns in Main Row -->
			
<!-- Left row -->
<div class="col-sm-4" id="left"></div>

<!-- Middle row -->
<div class="col-sm-4" id="middle">
	
	<div class="d-grid gap-2 my-2" id="locButton">
		<button type="button" class="btn btn-success btn-lg btn-block">Locator</button>
	</div>
	
	<div class="d-grid gap-2 my-2" id="maintButton">
		<button type="button" class="btn btn-success btn-lg btn-block">Maintenance</button>
	</div>
	
	<div class="d-grid gap-2 my-2" id="adminButton">
		<button type="button" class="btn btn-success btn-lg btn-block">Admin</button>
	</div>
	
</div>

<!-- Right row -->
<div class="col-sm-4" id="right"></div>
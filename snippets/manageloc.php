<?php

// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';

echo('

<div class="row" id="rowmain">
	
	<div class="col-lg-6" id="left">
		<div class="bg-light my-2 border rounded">
			<h6 class="text-center">Vaults</h6>
			<table id="vaulttab" class="display" style="width:100%"></table>
		</div>
	</div>
	
	<div class="col-lg-6" id="right">
		<div class="bg-light my-2 border rounded">
			<h6 class="text-center">Loose</h6>
			<table id="loosetab" class="display" style="width:100%"></table>
		</div>
	</div>
	
</div>

');
?>
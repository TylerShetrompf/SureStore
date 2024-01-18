<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';

echo('

<div class="bg-light px-2 my-2 border rounded" id="pdfdiv">
	<embed id="pdfframe" class="my-2" frameborder="0" type="application/pdf"></embed>
	<div class="d-grid gap-2 my-2">
		<input type="button" id="printbtn" value="Print Locator Sheet" class="btn btn-info btn-large btn-block">
	</div>
	<div class="d-grid gap-2 my-2">
		<input type="button" id="printallbtn" value="Print ALL Locator Sheets" class="btn btn-danger btn-large btn-block">
	</div>
</div>');
?>
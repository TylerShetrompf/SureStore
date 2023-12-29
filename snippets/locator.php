<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';

echo('
<div class="">
	<!-- Select2 -->
	<div class="my-2">
		<select class="form-select" name="search" id="search"></select>
	</div>

	<h2 class="text-center">OR</h2>

	<!-- New Reg Form -->
	<form id="newregform">
		<div class="row mb-2">
			<div class="col">
				<input type="input" class="form-control shadow-sm" id="regidinput">
			</div>
			<div class="col">
				<button type="submit" class="btn btn-success btn-large btn-block">Create Order</button>
			</div>
		</div>
	</form>

</div>
');
?>
<?php
	// PHP to check session
	include '/var/www/html/scripts/php/reverifysession.php';
?>

<!-- Select2 -->
<div class="my-2">
	<select class="form-select" name="search" id="search"></select>
</div>

<div class="bg-light px-2 my-2 border rounded">
	<form action="/scripts/reginfo.php" id="reginfoform">

		<!-- Reg# -->
		<div class="form-group my-2" id="reg">
			<input type="input" class="form-control shadow-sm" id="reginput" required>
			<small id="regHelp" class="form-text text-muted">Registration # (Required)</small>
		</div>

		<!-- Business Name -->
		<div class="form-group my-2" id="business">
			<input type="input" class="form-control shadow-sm" id="businessinput">
			<small id="businessHelp" class="form-text text-muted">Business Name (Optional)</small>
		</div>

		<!-- Customer First Name -->
		<div class="form-group my-2" id="regfirst">
			<input type="input" class="form-control shadow-sm" id="regfirstinput" required>
			<small id="regfirstHelp" class="form-text text-muted">Customer's First Name (Required)</small>
		</div>

		<!-- Customer Last Name -->
		<div class="form-group my-2" id="reglast">
			<input type="input" class="form-control shadow-sm" id="reglastinput" required>
			<small id="reglastHelp" class="form-text text-muted">Customer's Last Name (Required)</small>
		</div>

		<!-- Date checked in -->
		<div class="form-group my-2" id="regdatein">
			<input type="date" class="form-control shadow-sm" id="regdateininput" required>
			<small id="regdateinHelp" class="form-text text-muted">Date In  (Required)</small>
		</div>

		<!-- Date modified -->
		<div class="form-group my-2" id="regdatemod">
			<input type="date" class="form-control shadow-sm" id="regdatemodinput">
			<small id="regdatemodHelp" class="form-text text-muted">Date Modified (Automatic)</small>
		</div>

		<!-- Date checked out -->
		<div class="form-group my-2" id="regdateout">
			<input type="date" class="form-control shadow-sm" id="regdateoutinput">
			<small id="regdateoutHelp" class="form-text text-muted">Date Out (Optional)</small>
		</div>

		<!-- Military checkbox -->
		<div class="form-check form-switch">
			<input class="form-check-input" type="checkbox" id="milcheck" value="">
			<label class="form-check-label" for="milcheck">Military</label>
		</div>

		<!-- submit button-->
		<div class="d-grid gap-2 my-2">
			<button type="submit" class="btn btn-success btn-large btn-block">Update Order Info</button>
		</div>
	</form>
</div>
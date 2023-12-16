<?php
	// PHP to check session
	include '/var/www/html/scripts/reverifysession.php';
?>

<!-- Select2 -->
<div class="my-2">
	<select class="form-select" name="search" id="search"></select>
</div>

<div class="bg-light px-2 my-2 border rounded">
	<form action="/scripts/reginfo.php" id="reginfoform">

		<!-- Reg# -->
		<div class="form-group my-2 shadow-sm" id="reg">
			<input type="input" class="form-control" id="reginput">
		</div>

		<!-- Business Name -->
		<div class="form-group my-2 shadow-sm" id="business">
			<input type="input" class="form-control" id="businessinput">
		</div>

		<!-- Customer First Name -->
		<div class="form-group my-2 shadow-sm" id="regfirst">
			<input type="input" class="form-control" id="regfirstinput">
		</div>

		<!-- Customer Last Name -->
		<div class="form-group my-2 shadow-sm" id="reglast">
			<input type="input" class="form-control" id="reglastinput">
		</div>

		<!-- Date checked in -->
		<div class="form-group my-2 shadow-sm" id="regdatein">
			<input type="date" class="form-control" id="regdateininput">
		</div>

		<!-- Date modified -->
		<div class="form-group my-2 shadow-sm" id="regdatemod">
			<input type="date" class="form-control" id="regdatemodinput">
		</div>

		<!-- Date checked out -->
		<div class="form-group my-2 shadow-sm" id="regdateout">
			<input type="date" class="form-control" id="regdateoutinput">

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
<?php
	// PHP to check session
	include '/var/www/html/scripts/php/reverifysession.php';
?>

<!-- Select2 -->
<div class="my-2">
	<select class="form-select" name="search" id="search"></select>
</div>

<div class="bg-light px-2 my-2 border rounded" id="reginfodiv">
	<form action="/scripts/php/reginfo.php" id="reginfoform">
		<div class="row">
			<div class="col">
				<!-- Reg# -->
				<div class="form-group my-2" id="reg">
					<input type="input" class="form-control shadow-sm" id="reginput" required>
					<small id="regHelp" class="form-text text-muted">Registration # (Required)</small>
				</div>
			</div>
			<div class="col">
				<div class="form-group my-2" id="regwh">
					<input type="input" class="form-control shadow-sm" id="regwhinput" required>
					<small id="regwhHelp" class="form-text text-muted">Warehouse</small>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<!-- Date checked in -->
				<div class="form-group my-2" id="regdatein">
					<input type="date" class="form-control shadow-sm" id="regdateininput" required>
					<small id="regdateinHelp" class="form-text text-muted">Date In  (Required)</small>
				</div>
			</div>
			<div class="col">
				<!-- Date checked out -->
				<div class="form-group my-2" id="regdateout">
					<input type="date" class="form-control shadow-sm" id="regdateoutinput">
					<small id="regdateoutHelp" class="form-text text-muted">Date Out (Optional)</small>
				</div>
			</div>
		</div>
		<!-- Date modified -->
		<div class="form-group my-2" id="regdatemod">
			<input type="datetime-local" class="form-control shadow-sm" id="regdatemodinput" readonly>
			<small id="regdatemodHelp" class="form-text text-muted">Date Last Modified (Automatic)</small>
		</div>
		
		<div class="row">

			<div class="col">
				<!-- Order Weight -->
				<div class="form-group" id="regweight">
					<input type="input" class="form-control shadow-sm" id="regweightinput" required>
					<small id="regweightHelp" class="form-text text-muted">Weight (Required)</small>
				</div>
			</div>
			
			<div class="col">
				<!-- Military checkbox -->
				<div class="form-check form-switch">
					<input class="form-check-input" type="checkbox" id="milcheck" value="">
					<label class="form-check-label" for="milcheck">Military</label>
				</div>
			</div>
		</div>


		<!-- submit button-->
		<div class="d-grid gap-2 my-2">
			<button type="submit" class="btn btn-success btn-large btn-block">Update Order Info</button>
		</div>
		
	</form>
</div>

<div class="bg-light px-2 my-2 border rounded">
	
	<form action="/scripts/php/custinfo.php" id="custinfoform">
		
		<div class="row">
			
			<div class="col">
				<div class="form-group my-1" id="custid">
					<select class="form-select shadow-sm" name="custidinput" id="custidinput"></select>
					<small id="custidHelp" class="form-text text-muted">ID</small>
				</div>
			</div>
			
			<div class="col">
				<!-- Business Name -->
				<div class="form-group my-1" id="custbusiness">
					<input type="input" class="form-control shadow-sm" id="businessinput" >
					<small id="businessHelp" class="form-text text-muted">Business Name</small>
				</div>
			</div>
		</div>
		
		<div class="row">
			
			<div class="col">
				<!-- Customer First Name -->
				<div class="form-group mb-1" id="custfirst">
					<input type="input" class="form-control shadow-sm" id="regfirstinput" >
					<small id="custfirstHelp" class="form-text text-muted">Customer's First Name</small>
				</div>
			</div>
			
			<div class="col">	
				<!-- Customer Last Name -->
				<div class="form-group mb-1" id="custlast">
					<input type="input" class="form-control shadow-sm" id="custlastinput" >
					<small id="custlastHelp" class="form-text text-muted">Customer's Last Name</small>
				</div>
			</div>
		</div>
		
		<div class="row">
			<!-- Customer Phone # -->
			<div class="form-group mb-1" id="custtn">
				<input id="cust-tn" name="cust-tn" type="text" class="form-control shadow-sm" maxlength="14" placeholder="(XXX) XXX-XXXX" />
				<small id="custtnHelp" class="form-text text-muted">Phone #</small>
			</div>
		</div>
		
		<div class="row">
			
			<div class="col">
				<!-- Customer Street Address -->
				<div class="form-group mb-1" id="custaddy">
					<input type="input" class="form-control shadow-sm" id="custaddyinput" >
					<small id="custaddyHelp" class="form-text text-muted">Street Address</small>
				</div>
			</div>
			
			<div class="col">
				<!-- Cust City -->
				<div class="form-group mb-1" id="regcity">
					<input type="input" class="form-control shadow-sm" id="custcityinput" >
					<small id="custcityHelp" class="form-text text-muted">City</small>
				</div>
			</div>
			
			<div class="col">
				<!-- Cust State -->
				<div class="form-group mb-1" id="custstate">
					<input type="input" class="form-control shadow-sm" id="custstateinput">
					<small id="custstateHelp" class="form-text text-muted">State</small>
				</div>
			</div>
		</div>
		
		<div class="row">
			
			<div class="col">
				<!-- Cust Zip -->
				<div class="form-group mb-1" id="custzip">
					<input type="input" class="form-control shadow-sm" id="custzipinput">
					<small id="custzipHelp" class="form-text text-muted">ZIP</small>
				</div>
			</div>
			
			<div class="col">
				<!-- Cust Country -->
				<div class="form-group mb-1" id="custcountry">
					<input type="input" class="form-control shadow-sm" id="custcountryinput">
					<small id="custcountryHelp" class="form-text text-muted">Country</small>
				</div>
			</div>
		</div>

		<!-- submit button-->
		<div class="d-grid gap-2 my-1">
			<button type="submit" class="btn btn-success btn-large btn-block">Update Customer Info</button>
		</div>
		
	</form>
</div>
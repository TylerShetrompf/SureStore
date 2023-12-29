<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';

// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

// Get userid from cookie
$userid = $_COOKIE['userid'];

// Check user privelege level
$userquery = pg_query_params($surestore_db, 'select useracl from sureusers where LOWER(userid) = LOWER($1)', array($userid));

$userresult = pg_fetch_assoc($userquery);

echo('
<div class="row" id="rowmain">

		
		<!-- Scanner Modal -->
		<div class="modal" id="scanModal">
			<div class="bg-light px-2 my-2 border rounded" id="histmodaldiv">
				<div class="modal-dialog">
					<div class="modal-content">

						<!-- Modal Header -->
						<div class="modal-header">
							<button type="button" id="closescan" class="btn-close" data-bs-dismiss="modal"></button>
						</div>

						<!-- Modal Body -->
						<div class="modal-body" id="modbody">
						
						</div>
						<!-- Modal Footer -->
						<div class="modal-footer">
							<button type="button" id="closescan" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
						</div>

					</div>
				</div>
			</div>
		</div>

	<!-- 3 Columns in Main Row -->

	<!-- Left row -->
	<div class="col-sm-4" id="left"></div>

	<!-- Middle row -->
	<div class="col-sm-4 bg-light px-2 my-2 border rounded" id="middle">

		<div class="d-grid gap-2 my-2" id="locButton">
			<button type="button" class="btn btn-success btn-lg btn-block shadow-sm">Locator</button>
		</div>
		
		<!-- Show Scanner button -->
		<div class="d-grid gap-2 my-2">
			<button type="button" class="btn btn-success btn-lg btn-block shadow-sm" data-bs-toggle="modal" id="scanButton" data-bs-target="#scanModal">Scan</button>
		</div>
		
');

if ($userresult["useracl"] >= "2") {
	
echo ('	
		<div class="d-grid gap-2 my-2" id="maintButton">
			<button type="button" class="btn btn-warning btn-lg btn-block shadow-sm">Maintenance</button>
		</div>'
);
	
}

if ($userresult["useracl"] == "3") {
	
echo ('	
		<div class="d-grid gap-2 my-2" id="adminButton">
			<button type="button" class="btn btn-danger btn-lg btn-block shadow-sm">Admin</button>
		</div>'
);
	
}


echo ('	
	</div>

	<!-- Right row -->
	<div class="col-sm-4" id="right"></div>
	
</div>
');
?>
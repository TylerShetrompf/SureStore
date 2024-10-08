<?php

// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';

echo ('
<div id="maintdiv">
	<div class="d-grid gap-2 my-2" id="manageLocButton">
		<button type="button" class="btn btn-success btn-lg btn-block">Manage Locations</button>
	</div>
	
	<div class="d-grid gap-2 my-2" id="manageWhButton">
		<button type="button" class="btn btn-success btn-lg btn-block">Manage Warehouses</button>
	</div>
	
	<div class="d-grid gap-2 my-2" id="manageVaulterButton">
		<button type="button" class="btn btn-success btn-lg btn-block">Manage Vaulters</button>
	</div>

	<div class="d-grid gap-2 my-2" id="reportsButton">
		<button type="button" class="btn btn-dark btn-lg btn-block">Reports</button>
	</div>

	<!-- Show history button -->
	<div class="d-grid gap-2 my-2">
		<button type="button" class="btn btn-info btn-large btn-block" data-bs-toggle="modal" data-bs-target="#allhistModal">All History</button>
	</div>

	<!-- History Modal -->
	<div class="modal" id="allhistModal">
		<div class="bg-light px-2 my-2 border rounded" id="histmodaldiv">
			<div class="modal-dialog">
				<div class="modal-content">

					<!-- Modal Header -->
					<div class="modal-header">
						<h4 class="modal-title" id="histheading"></h4>
						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
					</div>

					<!-- Modal Body -->
					<div class="modal-body">
						<table id="histtab" class="display" style="width:100%"></table>
					</div>
					<!-- Modal Footer -->
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
');
?>
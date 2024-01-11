<?php

// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';

echo('

<div class="row" id="rowmain">
	
	<!-- Scanner Modal -->
	<div class="modal" id="scanModal">
		<div class="bg-light px-2 my-2 border rounded" id="scanModalDiv">
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
	
	<!-- Report Modal -->
	<div class="modal" id="reportModal">
		<div class="bg-light px-2 my-2 border rounded" id="reportModalDiv">
			<div class="modal-dialog">
				<div class="modal-content">

					<!-- Modal Header -->
					<div class="modal-header">
						<button type="button" id="closereport" class="btn-close" data-bs-dismiss="modal"></button>
					</div>

					<!-- Modal Body -->
					<div class="modal-body" id="modreportbody">

					</div>
					<!-- Modal Footer -->
					<div class="modal-footer">
						<button type="button" id="closereport" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
					</div>

				</div>
			</div>
		</div>
	</div>
	
	<div class="col-lg-4" id="left">
	</div>
	
	<div class="col-lg-4" id="middle">
		<div class="bg-light px-2 my-2 border rounded">
			<h3 class="text-center">Reports</h3>
			<!-- Select Report -->
			<form id="reportselectform">
				<div class="d-grid gap-2 my-2">
					<select class="form-select" id="reportselect">
						<option selected>Select a report...</option>
					</select>
				</div>
				<div class="d-grid gap-2 mb-2">
					<button type="submit" class="btn btn-success btn-large btn-block">Open</button>
				</div>
			</form>
		</div>
	</div>
	
	<div class="col-lg-4" id="right">
	</div>
	
</div>

')?>
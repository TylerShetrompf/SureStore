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
	
	<div class="col-lg-4" id="left">
	</div>
	
	<div class="col-lg-4" id="middle">
		<div class="bg-light my-2 border rounded">
			<h6 class="text-center">Warehouses</h6>
			<table id="whtab" class="display" style="width:100%"></table>
		</div>
	</div>
	
	<div class="col-lg-4" id="right">
	</div>
	
</div>

');
?>
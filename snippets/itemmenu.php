<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';

echo('
<div class="row" id="rowmain">

		
		<!-- Scanner Modal -->
		<div class="modal" id="scanLocModal">
			<div class="bg-light px-2 my-2 border rounded" id="scanLocmodaldiv">
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
	<div class="col-sm-4" id="middle">
		
		<div class="bg-light px-2 my-2 border rounded" id="iteminfodiv">
			<form id="iteminfoform">
				
				<input type="input" class="form-control shadow-sm" id="itemorder" disabled>
				<small id="itemorderHelp" class="form-text text-muted">Item Order</small>
				
				<input type="input" class="form-control shadow-sm" id="itemcust" disabled>
				<small id="itemcustHelp" class="form-text text-muted">Item Customer</small>
				
				<input type="input" class="form-control shadow-sm" id="itemloc" disabled>
				<small id="itemlocHelp" class="form-text text-muted">Item Location</small>
				
				<input type="input" class="form-control shadow-sm" id="itemvaulter" disabled>
				<small id="itemvaulterHelp" class="form-text text-muted">Item Vaulter</small>
				
				<textarea class="form-control shadow-sm" id="itemdesc" disabled></textarea>
				<small id="itemdescHelp" class="form-text text-muted">Item Description</small>
				
			</form>
		</div>
		
		<div class="d-grid gap-2 my-2" id="infoOrder">
			<button type="button" class="btn btn-success btn-lg btn-block">Order Info</button>
		</div>
		
		<!-- Show Scanner button -->
		<div class="d-grid gap-2 my-2">
			<button type="button" class="btn btn-success btn-large btn-block" data-bs-toggle="modal" id="scanLocButton" data-bs-target="#scanLocModal">Check Item In</button>
		</div>
	</div>
	
	<!-- Hidden itemid -->
	<input type="text" class="visually-hidden" id="hiddenitemid">
	<!-- Right row -->
	<div class="col-sm-4" id="right"></div>
	
</div>

');
?>
<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';
echo('
<!-- Main Row -->
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

	<!-- Left column -->
	<div class="col-lg-4 order-2 order-lg-1" id="left"></div>

	<!-- Middle column -->
	<div class="col-lg-4 order-1 order-lg-2" id="middle"></div>

	<!-- Right column -->
	<div class="col-lg-4 order-3 order-lg-3" id="right"></div>
</div>

<!-- bottom row -->
<div class="row" id="rowbottom">
	<div class="col-sm-4 order-1" id="bottomleft"></div>
	<div class="col-sm-4 order-2" id="bottommid"></div>
	<div class="col-sm-4 order-3" id="bottomright"></div>
</div>
');
?>
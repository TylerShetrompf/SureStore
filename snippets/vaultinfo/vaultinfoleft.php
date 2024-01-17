<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';
echo('
<div class="bg-light my-2 border rounded">
	<h6 class="text-center">Order Items</h6>
	<table id="iteminfo" class="display" style="width:100%"></table>
</div>

<!-- Show openvaults button -->
<div class="d-grid gap-2 my-2">
	<button type="button" id="showopenvaultsbtn" class="btn btn-secondary btn-large btn-block" data-bs-toggle="modal" data-bs-target="#openvaultsModal">Show Open Vaults</button>
</div>

<!-- openvaults Modal -->
<div class="modal" id="openvaultsModal">
	<div class="bg-light px-2 my-2 border rounded" id="openvaultsmodaldiv">
		<div class="modal-dialog">
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title" id="openvaultsheading"></h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>

				<!-- Modal Body -->
				<div class="modal-body">
					<table id="openvaultstab" class="display" style="width:100%"></table>
				</div>
				<!-- Modal Footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
				</div>

			</div>
		</div>
	</div>
</div>
');
?>
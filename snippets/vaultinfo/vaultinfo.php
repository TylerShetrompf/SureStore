<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';
echo('
<!-- Main Row -->
<div class="row" id="rowmain">

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
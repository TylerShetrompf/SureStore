<?php
// PHP to check session
//include '/var/www/html/scripts/php/reverifysession.php';
// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

$cols = array("OrderID","Weight","Valuation");

$opencsv = fopen('../../temp/valuations.csv', 'w');

$whquery = pg_query($surestore_db, "select whid from surewarehouse");

while ($whrow = pg_fetch_assoc($whquery)){
	
	fputcsv($opencsv, array("Warehouse: ", $whrow["whid"]));
	
	fputcsv($opencsv, $cols);
	
	$queryorders = pg_query_params($surestore_db, "select distinct(sureorders.orderid), sureorders.weight, sureorders.orderval from sureorders left join sureitems on sureitems.itemorder = sureorders.orderid where sureitems.dateout is NULL AND sureorders.orderwh = $1", array($whrow["whid"]));
	
	while ($row = pg_fetch_assoc($queryorders)){
		fputcsv($opencsv, array($row["orderid"], $row["weight"], $row["orderval"]));
	}
	
	$qtotal = pg_query_params($surestore_db, "select SUM(sureorders.orderval) from sureorders left join sureitems on sureitems.itemorder = sureorders.orderid where sureitems.dateout is NULL AND sureorders.orderwh = $1", array($whrow["whid"]));
	
	$totalval = pg_fetch_assoc($qtotal);

	$totalrow = array("", "Total:", $totalval["sum"]);
	fputcsv($opencsv, $totalrow);
	fputcsv($opencsv, array(""));
	fputcsv($opencsv, array(""));
	
}

fclose($opencsv);

// Close DB connection
pg_close($surestore_db);
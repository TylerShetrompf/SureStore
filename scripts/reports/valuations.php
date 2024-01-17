<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';
// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

$cols = array("OrderID","Order Type","Weight", "Valuation Type","Valuation");

$opencsv = fopen('../../temp/valuations.csv', 'w');

$whquery = pg_query($surestore_db, "select whid from surewarehouse");

while ($whrow = pg_fetch_assoc($whquery)){
	
	fputcsv($opencsv, array("Warehouse: ", $whrow["whid"]));
	
	fputcsv($opencsv, $cols);
	
	$queryorders = pg_query_params($surestore_db, "select distinct(sureorders.orderid), sureorders.ordertype, sureorders.weight, sureorders.valtype, sureorders.orderval::numeric::float from sureorders left join sureitems on sureitems.itemorder = sureorders.orderid where sureitems.dateout is NULL AND sureorders.orderwh = $1", array($whrow["whid"]));
	
	$total = 0.0;
	
	while ($row = pg_fetch_assoc($queryorders)){
		$valtype;
		if ($row["valtype"] == "60l"){
			$valtype = "$0.60/lb";
		}
		if ($row["valtype"] == "frc"){
			$valtype = "Full Replacement Charge";
		}
		if ($row["valtype"] == "oth"){
			$valtype = "OTHER";
		}
		if ($row["valtype"] == "nts"){
			$valtype = "NTS";
		}
		
		fputcsv($opencsv, array($row["orderid"], $row["ordertype"], $row["weight"], $valtype, "$".$row["orderval"]));
		$total += $row["orderval"];
	}	
	
	$totalrow = array("", "", "", "Total:", "$".$total);
	fputcsv($opencsv, $totalrow);
	fputcsv($opencsv, array(""));
	fputcsv($opencsv, array(""));
	
}

fclose($opencsv);

// Close DB connection
pg_close($surestore_db);
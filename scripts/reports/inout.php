<?php
// include PHPMailer
require_once('/var/www/html/scripts/phpmailer/PHPMailer.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

$whquery = pg_query($surestore_db, "select whid from surewarehouse");

$opencsv = fopen('/var/www/html/temp/inout.csv', 'w');

while ($rowwh = pg_fetch_row($whquery)){
	$wh = $rowwh[0];
	// In section
	fputcsv($opencsv, array("Warehouse ".$wh." Orders In:"));
	fputcsv($opencsv, array(""));
	fputcsv($opencsv, array("Order ID","Weight","Warehouse"));
	
	$inquery = pg_query_params($surestore_db, "select distinct(sureorders.orderid), sureorders.weight, sureorders.orderwh from sureorders left join sureitems on sureitems.itemorder = sureorders.orderid where sureitems.datein = now()::date and orderwh = $1", array($wh));
	$incounter = 0;
	while ($inrow = pg_fetch_row($inquery)){
		fputcsv($opencsv, $inrow);
		$incounter++;
	}
	fputcsv($opencsv, array("","Total In: ",$incounter));
	fputcsv($opencsv, array(""));
	// Out section
	fputcsv($opencsv, array("Warehouse ".$wh." Orders Out:"));
	fputcsv($opencsv, array(""));
	fputcsv($opencsv, array("Order ID","Weight","Warehouse"));
	
	$outquery = pg_query_params($surestore_db, "select distinct(sureorders.orderid), sureorders.weight, sureorders.orderwh from sureorders left join sureitems on sureitems.itemorder = sureorders.orderid where sureitems.dateout = now()::date and orderwh = $1", array($wh));
	$outcounter = 0;
	while ($outrow = pg_fetch_row($outquery)){
		fputcsv($opencsv, $outrow);
		$outcounter++;
	}
	fputcsv($opencsv, array("","Total Out: ",$outcounter));
	fputcsv($opencsv, array(""));
	fputcsv($opencsv, array(""));
	fputcsv($opencsv, array(""));
}

fclose($opencsv);

// Close DB connection
pg_close($surestore_db);
<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';
// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

$nositquery = pg_query($surestore_db, "select * from sureorders where ordertype = 'SIRVA SIT' and sitnum is null");

$opencsv = fopen('/var/www/html/temp/sitempty.csv', 'w');

fputcsv($opencsv, array("Order ID","Date In","Customer"));

while ($roworder = pg_fetch_assoc($nositquery)){
	
	$orderid = $roworder["orderid"];
	$custid = $roworder["ordercust"];
	$dateinquery = pg_query_params("SELECT datein FROM sureitems WHERE itemorder = $1 AND datein <= CURRENT_DATE - 7 ORDER BY datein asc limit 1", array($orderid));
	
	$resultdate = pg_fetch_row($dateinquery);
	if($resultdate){
		$datein = $resultdate[0];
		$custquery = pg_query_params("SELECT * FROM surecustomer WHERE custid = $1", array($custid));
		$custresult = pg_fetch_assoc($custquery);
		$custname = $custresult["custfirst"]." ".$custresult["custlast"];
		fputcsv($opencsv, array($orderid, $datein, $custname));
	}
	
}

fclose($opencsv);

// Close DB connection
pg_close($surestore_db);
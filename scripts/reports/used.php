<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';
// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

$whquery = pg_query($surestore_db, "select whid from surewarehouse");

$opencsv = fopen('/var/www/html/temp/used.csv', 'w');
	
fputcsv($opencsv, array("Warehouse","Vaults In Use", "Total Vaults"));

while ($rowwh = pg_fetch_row($whquery)){
	
	$wh = $rowwh[0];
	
	$totalquery = pg_query_params($surestore_db, 'select vaultid from surevault where vaultwh = $1', array($wh));
	
	$totalvaults = pg_num_rows($totalquery);
	
	$usedquery = pg_query_params($surestore_db, 'select vaultid from surevault where vaultwh = $1 and vaultid in (select itemvault as vaultid from sureitems where datein is not null and dateout is null and itemvault is not null)', array($wh));
	
	$usedvaults = pg_num_rows($usedquery);
	fputcsv($opencsv, array($wh,$usedvaults, $totalvaults));
}


fclose($opencsv);

// Close DB connection
pg_close($surestore_db);
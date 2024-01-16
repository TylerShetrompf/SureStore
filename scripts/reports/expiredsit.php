<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';
// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

$exsitquery = pg_query($surestore_db, "select orderid, sitex, sitnum from sureorders where sitex < CURRENT_DATE");

$opencsv = fopen('../../temp/sitex.csv', 'w');

fputcsv($opencsv, array("OrderID","Expiration","SIT Number"));

while ($row = pg_fetch_row($exsitquery)){
	fputcsv($opencsv, $row);
}

fclose($opencsv);

// Close DB connection
pg_close($surestore_db);
<?php
// include PHPMailer
require_once('/var/www/html/scripts/phpmailer/PHPMailer.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

$whquery = pg_query($surestore_db, "select whid from surewarehouse");

$opencsv = fopen('/var/www/html/temp/tempused.csv', 'w');
	
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

$email = new PHPMailer();
$email->isSendmail();
$email->SetFrom('admin@surestore.store'); //Name is optional
$email->Subject   = 'Daily Vaults Report';
$email->Body      = "See attached for report.";
$email->AddAddress( 'tyler@shetrompf.com' );

$file_to_attach = '/var/www/html/temp/tempused.csv';

$email->AddAttachment( $file_to_attach , 'report.csv' );

return $email->Send();

// Close DB connection
pg_close($surestore_db);
<?php
// include PHPMailer
require_once('/var/www/html/scripts/phpmailer/PHPMailer.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

$exsitquery = pg_query($surestore_db, "select orderid, sitex, sitnum from sureorders where sitex < CURRENT_DATE");

$opencsv = fopen('../../temp/tempsitex.csv', 'w');

fputcsv($opencsv, array("OrderID","Expiration","SIT Number"));

while ($row = pg_fetch_row($exsitquery)){
	fputcsv($opencsv, $row);
}

fclose($opencsv);

$email = new PHPMailer();
$email->isSendmail();
$email->SetFrom('admin@surestore.store'); //Name is optional
$email->Subject   = 'Expired SIT Report';
$email->Body      = "See attached for report.";
$email->AddAddress( 'tyler@shetrompf.com' );

$file_to_attach = '../../temp/tempsitex.csv';

$email->AddAttachment( $file_to_attach , 'report.csv' );

return $email->Send();

unlink($opencsv);

// Close DB connection
pg_close($surestore_db);
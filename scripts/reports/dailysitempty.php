<?php
// include PHPMailer
require_once('/var/www/html/scripts/phpmailer/PHPMailer.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

$nositquery = pg_query($surestore_db, "select * from sureorders where ordertype = 'SIRVA SIT' and sitnum is null");

$opencsv = fopen('/var/www/html/temp/tempsitempty.csv', 'w');

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

$email = new PHPMailer();
$email->isSendmail();
$email->SetFrom('admin@surestore.store'); //Name is optional
$email->Subject   = 'Orders Needing SIT#';
$email->Body      = "See attached for report.";
$email->AddAddress( 'tyler@shetrompf.com' );

$file_to_attach = '/var/www/html/temp/tempsitempty.csv';

$email->AddAttachment( $file_to_attach , 'report.csv' );

return $email->Send();

// Close DB connection
pg_close($surestore_db);
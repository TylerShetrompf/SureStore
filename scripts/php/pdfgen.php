<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';
// FPDF
require('/var/www/html/scripts/php/fpdf.php');

// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

// get variables from post
$orderid = $_POST["orderid"];
$dataurl = $_POST["dataurl"];

// Query for order info
$orderquery = pg_query_params($surestore_db, "select * from sureorders where orderid = $1", array($orderid));

// Get result for order query
$orderresults = pg_fetch_assoc($orderquery);

// Assign results from order query to variables
$weight = $orderresults["weight"];
$custid = $orderresults["ordercust"];

// Query for date in
$datequery = pg_query_params($surestore_db,"select datein from sureitems where itemorder = $1 order by datein asc limit 1", array($orderid));

// get results for date query
$dateresults = pg_fetch_assoc($datequery);

// assign result from date query to variable
$datein = $dateresults["datein"];

// Query for cust info
$custquery = pg_query_params($surestore_db, "select * from surecustomer where custid = $1", array($custid));

// Get result for cust query
$custresult = pg_fetch_assoc($custquery);

// Assign results from cust query to variables
$custname = $custresult["custfirst"]." ".$custresult["custlast"];

// Query for vaults and loose
$vaultloosequery = pg_query_params($surestore_db, "select distinct itemvault, itemloose from sureitems where itemorder = $1 and dateout IS NULL", array($orderid));

// Counter variable for vault loose results
$vaultcounter = 0;
$loosecounter = 0;
// Arrays for vault/loose
$vaults = [];
$loose = [];
// Get results for vault/loose query
while ($row = pg_fetch_assoc($vaultloosequery)){
	if ($row["itemvault"] != NULL){
		$vaults[$vaultcounter] = $row["itemvault"];
		$vaultcounter++;
	}
	if ($row["itemloose"] != NULL){
		$loose[$loosecounter] = $row["itemloose"];
		$loosecounter++;
	}
}

// Set path and name for qr code
$imgname = '../../QR/'.$orderid.".png";

if (file_exists($imgname)) {
	
	$pdfname = $orderid.".pdf";
	$pdfpath = '../../QR/'.$pdfname;
	$pdf = new FPDF('P','in','Letter');
	$pdf->AddPage();
	$pdf->Image($imgname,-0.15,0.5);
	$pdf->SetFont('Arial','B',50);
	$pdf->Text(0.25,0.65,$orderid."/".$custname);
	$pdf->SetFont('Arial','B',25);
	$pdf->Text(3,1.2,'Date In: '.$datein);
	$pdf->Text(3,1.7,'Weight: '.$weight);
	$pdf->Text(2.5,4,'Vaults and Loose: ');
	$pdf->SetFont('Arial','B',20);
	$listy = 4.5;
	$listx = 1.0;
	foreach ($vaults as $rowvault){
		if ($listx >= 8) {
			$listy = $listy + 0.5;
			$listx = 1.0;
		}
		$pdf->Text($listx,$listy,$rowvault);
		$listx = $listx + 1;
	}
	foreach ($loose as $rowloose){
		if ($listx >= 8) {
			$listy = $listy + 0.5;
			$listx = 1.0;
		}
		$pdf->Text($listx,$listy,$rowloose);
		$listx = $listx + 1;
	}

	
	$pdf->Output('F', $pdfpath);
	echo json_encode($pdfname);
} else {
	$dataPieces = explode(',', $dataurl);
	$encodedImg = $dataPieces[1];

	$decodedImg = base64_decode($encodedImg);

	if( $decodedImg!==false ) {
	
		if( file_put_contents($imgname,$decodedImg)!==false ) {
			$pdfname = $orderid.".pdf";
			$pdfpath = '../../QR/'.$pdfname;
			$pdf = new FPDF();

		}
	}
	$pdfname = $orderid.".pdf";
	$pdfpath = '../../QR/'.$pdfname;
	$pdf = new FPDF('P','in','Letter');
	$pdf->AddPage();
	$pdf->Image($imgname,-0.15,0.5);
	$pdf->SetFont('Arial','B',50);
	$pdf->Text(0.25,0.65,$orderid."/".$custname);
	$pdf->SetFont('Arial','B',25);
	$pdf->Text(3,1.2,'Date In: '.$datein);
	$pdf->Text(3,1.7,'Weight: '.$weight);
	$pdf->Text(2.5,4,'Vaults and Loose: ');
	$pdf->SetFont('Arial','B',20);
	$listy = 4.5;
	$listx = 1.0;
	foreach ($vaults as $rowvault){
		if ($listx >= 8) {
			$listy = $listy + 0.5;
			$listx = 1.0;
		}
		$pdf->Text($listx,$listy,$rowvault);
		$listx = $listx + 1;
		$listcount++;
	}
	foreach ($loose as $rowloose){
		if ($listx >= 8) {
			$listy = $listy + 0.5;
			$listx = 1.0;
		}
		$pdf->Text($listx,$listy,$rowloose);
		$listx = $listx + 1;
	}

	
	$pdf->Output('F', $pdfpath);
	echo json_encode($pdfname);
}

pg_close($surestore_db);
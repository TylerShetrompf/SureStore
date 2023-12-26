<?php

// FPDF
require('/var/www/html/scripts/php/fpdf.php');

// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

// Get variables from post
$itemid = $_POST["itemid"];
$itemqr = $_POST["itemqr"];

// split item dataurl into pieces, assign variable to base64 string
$itemdataPiece = explode(',', $itemqr);
$encodedItemImg = $itemdataPiece[1];
$decodedItemImg = base64_decode($encodedItemImg);

// set item qr path and name
$itemimgname = '../../QR/'.$itemid.'.png';

// query to get item info
$itemquery = pg_query_params($surestore_db, "select * from sureitems where itemid = $1", array($itemid));

// assign result to assoc array
$itemresult = pg_fetch_assoc($itemquery);

// assign results to array variables
$itemdesc = $itemresult["itemdesc"];
$itemvault = $itemresult["itemvault"];
$itemloose = $itemresult["itemloose"];
$orderid = $itemresult["itemorder"];

// Get Vaulters name
$vaulterid = $itemresult["itemvaulter"];
$vaulterquery = pg_query_params($surestore_db, "select * from surevaulters where vaulterid = $1", array($vaulterid));
$vaulterqueryresult = pg_fetch_assoc($vaulterquery);

// assign vaulters name to array
$itemvaulter = $vaulterqueryresult["vaulterfirst"]." ".$vaulterqueryresult["vaulterlast"];

// Query for order info
$orderquery = pg_query_params($surestore_db, "select * from sureorders where orderid = $1", array($orderid));

// Get result for order query
$orderresults = pg_fetch_assoc($orderquery);

// Assign results from order query to variables
$weight = $orderresults["weight"];
$datein = $orderresults["datein"];
$custid = $orderresults["ordercust"];

// Query for cust info
$custquery = pg_query_params($surestore_db, "select * from surecustomer where custid = $1", array($custid));

// Get result for cust query
$custresult = pg_fetch_assoc($custquery);

// Assign results from cust query to variables
$custname = $custresult["custfirst"]." ".$custresult["custlast"];

//check if image exists 
if (file_exists($itemimgname)) {
	
	$pdfname = $itemid.".pdf";
	$pdfpath = '../../QR/'.$pdfname;
	$pdf = new FPDF('P','in','Letter');
	
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',25);
	$pdf->Image($itemimgname);
	$pdf->Text(3.5,1,'Order: '.$orderid);
	$pdf->Text(3.5,1.5,'Customer: '.$custname);
	$pdf->Text(3.5,2,'Date In: '.$datein);

	if ($itemvault) {
		$pdf->Text(3.5,2.5,'Vault: '.$itemvault);
	}

	if ($itemloose) {
		$pdf->Text(3.5,2.5,'Loose: '.$itemloose);
	}

	$pdf->Text(3.5,3,'Vaulter: '.$itemvaulter);
	$pdf->Text(2.5,4,'Item Description: ');
	$pdf->SetFont('Arial','B',20);
	$pdf->Text(1.0,4.5,$itemdesc);
	
	$pdf->Output('F', $pdfpath);
	echo json_encode($pdfname);

} else {
	// save png of qr
	file_put_contents($itemimgname,$decodedItemImg);

	$pdfname = $itemid.".pdf";
	$pdfpath = '../../QR/'.$pdfname;
	$pdf = new FPDF('P','in','Letter');
	
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',25);
	$pdf->Image($itemimgname);
	$pdf->Text(3.5,1,'Order: '.$orderid);
	$pdf->Text(3.5,1.5,'Customer: '.$custname);
	$pdf->Text(3.5,2,'Date In: '.$datein);

	if ($itemvault) {
		$pdf->Text(3.5,2.5,'Vault: '.$itemvault);
	}

	if ($itemloose) {
		$pdf->Text(3.5,2.5,'Loose: '.$itemloose);
	}

	$pdf->Text(3.5,3,'Vaulter: '.$itemvaulter);
	$pdf->Text(2.5,4,'Item Description: ');
	$pdf->SetFont('Arial','B',20);
	$pdf->Text(1.0,4.5,$itemdesc);
	
	$pdf->Output('F', $pdfpath);
	echo json_encode($pdfname);
}

pg_close($surestore_db);
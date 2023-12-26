<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';
// FPDF
require('/var/www/html/scripts/php/fpdf.php');

// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

// get variables from post
$orderid = $_POST["orderid"];
$orderqr = $_POST["orderqr"];
$itempostarray = $_POST["itemQR"];
$items = [];
// Generate itemQR codes, get item data
foreach ($itempostarray as $key => $value){
	
	// split item dataurl into pieces, assign variable to base64 string
	$itemdataPiece = explode(',', $value);
	$encodedItemImg = $itemdataPiece[1];
	$decodedItemImg = base64_decode($encodedItemImg);
	
	// set item qr path and name
	$itemimgname = '../../QR/'.$key.'.png';
	
	//check if image exists 
	if (file_exists($itemimgname)) {
		// query to get item info
		$itemquery = pg_query_params($surestore_db, "select * from sureitems where itemid = $1", array($key));

		// assign result to assoc array
		$itemresult = pg_fetch_assoc($itemquery);

		// assign results to array variables
		$items[$key]["itemdesc"] = $itemresult["itemdesc"];
		$items[$key]["itemvault"] = $itemresult["itemvault"];
		$items[$key]["itemloose"] = $itemresult["itemloose"];

		// Get Vaulters name
		$vaulterid = $itemresult["itemvaulter"];
		$vaulterquery = pg_query_params($surestore_db, "select * from surevaulters where vaulterid = $1", array($vaulterid));
		$vaulterqueryresult = pg_fetch_assoc($vaulterquery);

		// assign vaulters name to array
		$items[$key]["itemvaulter"] = $vaulterqueryresult["vaulterfirst"]." ".$vaulterqueryresult["vaulterlast"];

		// assign item img path to array
		$items[$key]["imagepath"] = $itemimgname;
	} else {
		// save png of qr
		file_put_contents($itemimgname,$decodedItemImg);

		// query to get item info
		$itemquery = pg_query_params($surestore_db, "select * from sureitems where itemid = $1", array($key));

		// assign result to assoc array
		$itemresult = pg_fetch_assoc($itemquery);

		// assign results to array variables
		$items[$key]["itemdesc"] = $itemresult["itemdesc"];
		$items[$key]["itemvault"] = $itemresult["itemvault"];
		$items[$key]["itemloose"] = $itemresult["itemloose"];

		// Get Vaulters name
		$vaulterid = $itemresult["itemvaulter"];
		$vaulterquery = pg_query_params($surestore_db, "select * from surevaulters where vaulterid = $1", array($vaulterid));
		$vaulterqueryresult = pg_fetch_assoc($vaulterquery);

		// assign vaulters name to array
		$items[$key]["itemvaulter"] = $vaulterqueryresult["vaulterfirst"]." ".$vaulterqueryresult["vaulterlast"];

		// assign item img path to array
		$items[$key]["imagepath"] = $itemimgname;
	}
	
}

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

// Query for vaults and loose
$vaultloosequery = pg_query_params($surestore_db, "select distinct itemvault, itemloose from sureitems where itemorder = $1", array($orderid));

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
	$pdf->SetFont('Arial','B',25);
	$pdf->Image($imgname);
	$pdf->Text(3.5,1,'Order: '.$orderid);
	$pdf->Text(3.5,1.5,'Customer: '.$custname);
	$pdf->Text(3.5,2,'Date In: '.$datein);
	$pdf->Text(3.5,2.5,'Weight: '.$weight);
	$pdf->Text(2.5,4,'Vaults and Loose: ');
	$pdf->SetFont('Arial','B',20);
	$listx = 4.5;
	$listcount = 0;
	$listy = 1.0;
	foreach ($vaults as $rowvault){
		if ($listcount >= 3) {
			$listx = $listx + 0.5;
			$listcount = 0;
			$listy = 1.0;
		}
		$pdf->Text($listy,$listx,$rowvault);
		$listy = $listy + 2;
	}
	foreach ($loose as $rowloose){
		if ($listcount >= 3) {
			$listx = $listx + 0.5;
			$listcount = 0;
			$listy = 1.0;
		}
		$pdf->Text($listy,$listx,$rowloose);
		$listy = $listy + 2;
	}

	foreach ($items as $key => $value) {
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',25);
		$pdf->Image($value["imagepath"]);
		$pdf->Text(3.5,1,'Order: '.$orderid);
		$pdf->Text(3.5,1.5,'Customer: '.$custname);
		$pdf->Text(3.5,2,'Date In: '.$datein);
		
		if ($value["itemvault"]) {
			$pdf->Text(3.5,2.5,'Vault: '.$value["itemvault"]);
		}
		
		if ($value["itemloose"]) {
			$pdf->Text(3.5,2.5,'Loose: '.$value["itemloose"]);
		}
		
		$pdf->Text(3.5,3,'Vaulter: '.$value["itemvaulter"]);
		$pdf->Text(2.5,4,'Item Description: ');
		$pdf->SetFont('Arial','B',20);
		$pdf->Text(1.0,4.5,$value["itemdesc"]);
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
	$pdf->SetFont('Arial','B',25);
	$pdf->Image($imgname);
	$pdf->Text(3.5,1,'Order: '.$orderid);
	$pdf->Text(3.5,1.5,'Customer: '.$custname);
	$pdf->Text(3.5,2,'Date In: '.$datein);
	$pdf->Text(3.5,2.5,'Weight: '.$weight);
	$pdf->Text(2.5,4,'Vaults and Loose: ');
	$pdf->SetFont('Arial','B',20);
	$listx = 4.5;
	$listcount = 0;
	$listy = 1.0;
	foreach ($vaults as $rowvault){
		if ($listcount >= 3) {
			$listx = $listx + 0.5;
			$listcount = 0;
			$listy = 1.0;
		}
		$pdf->Text($listy,$listx,$rowvault);
		$listy = $listy + 2;
	}
	foreach ($loose as $rowloose){
		if ($listcount >= 3) {
			$listx = $listx + 0.5;
			$listcount = 0;
			$listy = 1.0;
		}
		$pdf->Text($listy,$listx,$rowloose);
		$listy = $listy + 2;
	}

	
	$pdf->Output('F', $pdfpath);
	echo json_encode($pdfname);
}

pg_close($surestore_db);
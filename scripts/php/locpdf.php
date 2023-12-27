<?php
// PHP to check session
include '/var/www/html/scripts/php/reverifysession.php';
// FPDF
require('/var/www/html/scripts/php/fpdf.php');

// Include db connection
include '/var/www/html/scripts/php/connectdb.php';

// Get variables from post
$locid = $_POST["locid"];
$locqr = $_POST["locqr"];

// split loc dataurl into pieces, assign variable to base64 string
$locdataPiece = explode(',', $locqr);
$encodedlocImg = $locdataPiece[1];
$decodedlocImg = base64_decode($encodedlocImg);

// set loc qr path and name
$locimgname = '../../QR/'.$locid.'.png';

if (file_exists($locimgname)) {
		
	$pdfname = $locid.".pdf";
	$pdfpath = '../../QR/'.$pdfname;
	$pdf = new FPDF('P','in','Letter');
	
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',40);
	$pdf->Image($locimgname, 1.75, 2.5, 5, 5);
	$pdf->Text(3, 2, $locid);
	$pdf->Output('F', $pdfpath);
	echo json_encode($pdfname);
} else {
	// save png of qr
	file_put_contents($locimgname,$decodedlocImg);
	
	$pdfname = $locid.".pdf";
	$pdfpath = '../../QR/'.$pdfname;
	$pdf = new FPDF('P','in','Letter');
	
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',40);
	$pdf->Image($locimgname, 1.75, 2.5, 5, 5);
	$pdf->Text(3, 2, $locid);
	$pdf->Output('F', $pdfpath);
	echo json_encode($pdfname);
}

pg_close($surestore_db);
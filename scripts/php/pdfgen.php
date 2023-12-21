<?php
require('/var/www/html/scripts/php/fpdf.php');

// get variables from post
$orderid = $_POST["orderid"];
$dataurl = $_POST['dataurl'];

// Set path and name for qr code
$imgname = '../../images/QR/'.$orderid.".png";

$dataPieces = explode(',', $dataurl);
$encodedImg = $dataPieces[1];

$decodedImg = base64_decode($encodedImg);

if( $decodedImg!==false ) {
	
	if( file_put_contents($imgname,$decodedImg)!==false ) {
		
		$pdfname = $orderid.".pdf";
		$pdfpath = '../../images/QR/'.$pdfname;
		$pdf = new FPDF();
        $pdf->AddPage();
        $pdf->Image($imgname);
        $pdf->Output('F', $pdfpath);
		
		echo json_encode($pdfname);
	}
}

<?php
require('/var/www/html/scripts/php/fpdf.php');

// get variables from post
$orderid = "696966";
// $dataurl = $_POST['dataurl'];

// Set path and name for qr code
$imgname = '../../QR/'.$orderid.".png";

if (file_exists($imgname)) {
	
	$pdfname = $orderid.".pdf";
	$pdfpath = '../../QR/'.$pdfname;
	$pdf = new FPDF('P','in','Letter');
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',15);
	$pdf->Image($imgname);
	$pdf->Text(4,1,'Order: '.$orderid);
	$pdf->Output('F', $pdfpath);
	echo json_encode($pdfname);
} /* else {
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
}
*/
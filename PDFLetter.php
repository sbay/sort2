<?php
// We'll be outputting a PDF
//header('Content-type: application/pdf');

// It will be called downloaded.pdf
//header('Content-Disposition: attachment; filename="downloaded.pdf"');


if( $_REQUEST['action'] == 'letters' )
{
	
	
	$records = null;
	$records = $_REQUEST['records'];
	
	require_once 'fpdf.php';
	

	$pdf = new FPDF();
	$pdf->SetFont('Times', 'B', 15);
	$pdf->AddPage();

	$dirBrows		= $_REQUEST['directory'];
	$fileName 		= $dirBrows .  DIRECTORY_SEPARATOR   . trim($records[0]) . trim($records[1]) . trim($records[2]) . ".pdf" ;
	$fullName 		= $records[0] . " " . $records[1] . " " . $records[2] . "\n";
	$fullAdress		= $records[3] . "\n" . $records[4] . "\n" . $records[5] . "\n" .  $records[6] . "\n";

	$pdf->Write(5, $fullName . $fullAdress );
	$pdf->Output( $fileName ,'F');
	echo  $fileName;
	}
?>
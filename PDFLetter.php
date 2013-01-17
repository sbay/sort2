<?php
// We'll be outputting a PDF
//header('Content-type: application/pdf');

// It will be called downloaded.pdf
//header('Content-Disposition: attachment; filename="downloaded.pdf"');


if( $_REQUEST['action'] == 'letters' )
{
	$hostName		= $_SERVER[SERVER_NAME]; 
	$dirBrows		=  "." . DIRECTORY_SEPARATOR . "tmp";	
	
	if( $_REQUEST['directory'] == true )
	{
		$mask 	= $dirBrows . DIRECTORY_SEPARATOR . "*.*";
		array_map( "unlink", glob( $mask ) );
	}
	
	$records 	= null;
	$records 	= $_REQUEST['records'];
	
	require_once 'fpdf.php';
	
	
	
	
	if(!file_exists($dirBrows))
	{
		mkdir($dirBrows);
	}

	$pdf = new FPDF();
	$pdf->SetFont('Times', 'B', 15);
	$pdf->AddPage();

	
	$fileName 		= $dirBrows .  DIRECTORY_SEPARATOR   . trim($records[0]) . "_"  . trim($records[1]) . "_" . trim($records[2]) . ".pdf" ;
	$fullName 		= $records[0] . " " . $records[1] . " " . $records[2] . "\n";
	$fullAdress		= $records[3] . "\n" . $records[4] . "\n" . $records[5] . "\n" .  $records[6] . "\n";

	$linkFileName	= "http:" . DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR . $hostName . DIRECTORY_SEPARATOR . $fileName;
	$pdf->Write(5, $fullName . $fullAdress );
	$pdf->Output( $fileName ,'F');
	echo  $linkFileName;
	}
?>
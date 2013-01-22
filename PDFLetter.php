<?php

if( $_REQUEST['action'] == 'letters' )
{
	$hostName		= $_SERVER[SERVER_NAME]; 
	$dirBrows		=  "." . DIRECTORY_SEPARATOR . "tmp";	
	
	if( /*$_REQUEST['directory'] == */true )
	{
		$mask 	= $dirBrows . DIRECTORY_SEPARATOR . "*.*";
		array_map( "unlink", glob( $mask ) );
	}
	
	if(  !$_REQUEST['records'] )
	{
	 echo "error #1";
	 return;
	}

	$printRecords	= $_REQUEST['records'];
	
	require_once 'fpdf.php';
	
	if(!file_exists($dirBrows))
	{
		mkdir($dirBrows);
	}

	$pdf = new FPDF();
	
	$fileName 	= $dirBrows . DIRECTORY_SEPARATOR .  "temp" . ".pdf";
	
	
	$maxRecords	=	sizeof($printRecords);
	for($i=0; $i < $maxRecords ; $i++)
	{
		$pdf->SetFont('Times', 'B', 15);
		// envelop
		$pdf->AddPage();

		$fullName 		= $printRecords[$i][0] . " " . $printRecords[$i][1] . " " . $printRecords[$i][2] . "\n";
		$fullAdress		= $printRecords[$i][3] . "\n" . $printRecords[$i][4] . "\n" . $printRecords[$i][5] . "\n" .  $printRecords[$i][6] . "\n";
		$pdf->Write(5, $fullName . $fullAdress );
		
		
		// letter
		$pdf->SetFont('');
		$pdf->AddPage();
		$letter			= "Dear," . $fullName . ", our records indicate...";
		$pdf->Write(5, $letter );
		
	}
	$linkFileName	= "http:" . DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR . $hostName . DIRECTORY_SEPARATOR . $fileName;
		
	$pdf->Output( $fileName ,'F');
	echo  $linkFileName;
}
?>
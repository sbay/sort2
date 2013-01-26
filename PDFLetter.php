<?php

if( $_REQUEST['action'] == 'letters' )
{
	$hostName		= $_SERVER[SERVER_NAME]; 
	$dirBrows		=  "." . DIRECTORY_SEPARATOR . "tmp";	
	
	
	if(  !$_REQUEST['records'] )
	{
	 echo "empty record";
	 return;
	}

	$printRecords	= 	$_REQUEST['records'];
	
	
	if(!file_exists($dirBrows))
	{
		mkdir($dirBrows);
	}
	else
	{
		// remove previous file
		$mask 	= $dirBrows . DIRECTORY_SEPARATOR . "letter.pdf";
		array_map( "unlink", glob( $mask ) );
	}
	
	
	
	require_once 'library/fpdf.php';
	
	$pdf = new FPDF();
	
	$fileName 	= $dirBrows . DIRECTORY_SEPARATOR .  "letter.pdf";
	
	
	$maxRecords	=	sizeof($printRecords);
	for($i=0; $i < $maxRecords ; $i++)
	{
		$pdf->SetFont('Times', 'B', 15);
		$pdf->AddPage();
	
		// envelop
		$fullName 		= $printRecords[$i][0] . " " . $printRecords[$i][1] . " " . $printRecords[$i][2] . "\n";
		$street 		= $printRecords[$i][3] . "\n";
		$adress			= $printRecords[$i][4] .  " " . $printRecords[$i][5] . " " . $printRecords[$i][6] . "\n";
		$pdf->Image('img/flr_head.jpg',0,0,0, 90);
		$pdf->SetXY(($pdf->GetX()+100),95);
		$pdf->Cell(0,0,$fullName);
		$pdf->Ln(10);
		$pdf->SetX(($pdf->GetX()+100));
		$pdf->Cell(0,0,$street);
		$pdf->Ln(10);
		$pdf->SetX(($pdf->GetX()+100));
		$pdf->Cell(0,0,$adress);
		$pdf->Image('img/flr_foot.jpg',0,135,0,135);
		
	}
	$linkFileName	= "http:" . DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR . $hostName . DIRECTORY_SEPARATOR . $fileName;
		
	$pdf->Output( $fileName ,'F');
	echo  $linkFileName;
}
?>
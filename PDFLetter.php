<?php

if( $_REQUEST['action'] == 'letters' )
{
	$hostName		= $_SERVER[SERVER_NAME]; 
	$dirBrows		=  "tmp";	
	
	
	if(  !$_REQUEST['records'] )
	{
	 echo "empty record";
	 return;
	}

	$printRecords	= 	$_REQUEST['records'];
	
	$fileName 	= $dirBrows . DIRECTORY_SEPARATOR .  "letter.pdf";
	if(!file_exists($dirBrows))
	{
		mkdir($dirBrows);
	}
	else
	{
		// remove previous file
		array_map( "unlink", glob( $fileName ) );
	}
	
	
	
	require_once 'library/fpdf.php';
	
	$pdf = new FPDF();
		
	$maxRecords	=	sizeof($printRecords);
	for($i=0; $i < $maxRecords ; $i++)
	{
		$pdf->SetFont('Times', 'B', 12);
		$pdf->AddPage();
	
		// flier
		$fullName 		= $printRecords[$i][0] . " " . $printRecords[$i][1] . " " . $printRecords[$i][2] . "\n";
		$street 		= $printRecords[$i][3] . "\n";
		$adress			= $printRecords[$i][4] .  ", " . $printRecords[$i][5] . " " . $printRecords[$i][6] . "\n";
		$pdf->Image('img/flr_head.jpg',0,0, -200);
		$pdf->SetXY(($pdf->GetX()+120),95);
		$pdf->Cell(0,0,$fullName);
		$pdf->Ln(5);
		$pdf->SetX(($pdf->GetX()+120));
		$pdf->Cell(0,0,$street);
		$pdf->Ln(5);
		$pdf->SetX(($pdf->GetX()+120));
		$pdf->Cell(0,0,$adress);
		$pdf->Image('img/flr_foot.jpg',0,150, -200);
		
	}
		
	$pdf->Output( $fileName ,'F');
	echo  $fileName;
}
?>
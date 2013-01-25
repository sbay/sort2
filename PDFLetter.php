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
	$recordPart		=	"letter";
	
	if( $_REQUEST['part'] == "envelop" )
	{
		$recordPart = "envelop";
	}
	
	
	if(!file_exists($dirBrows))
	{
		mkdir($dirBrows);
	}
	else
	{
		// remove previous file
		$mask 	= $dirBrows . DIRECTORY_SEPARATOR . $recordPart . ".pdf";
		array_map( "unlink", glob( $mask ) );
	}
	
	
	
	require_once 'fpdf.php';
	
	$pdf = new FPDF();
	
	$fileName 	= $dirBrows . DIRECTORY_SEPARATOR .  $recordPart . ".pdf";
	
	
	$maxRecords	=	sizeof($printRecords);
	for($i=0; $i < $maxRecords ; $i++)
	{
		$pdf->SetFont('Times', 'B', 15);
		
		$pdf->AddPage();

		if($recordPart == "envelop")
		{
			// envelop
			$fullName 		= $printRecords[$i][0] . " " . $printRecords[$i][1] . " " . $printRecords[$i][2] . "\n";
			$fullAdress		= $printRecords[$i][3] . "\n" . $printRecords[$i][4] . "\n" . $printRecords[$i][5] . "\n" .  $printRecords[$i][6] . "\n";
			$pdf->Write(5, $fullName . $fullAdress );
		}
		else 
		{
			// letter
			$pdf->SetFont('');
			$letter			= "Dear," . $fullName . ", our records indicate...";
			$pdf->Write(5, $letter );
		}
		
	}
	$linkFileName	= "http:" . DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR . $hostName . DIRECTORY_SEPARATOR . $fileName;
		
	$pdf->Output( $fileName ,'F');
	echo  $linkFileName;
}
?>
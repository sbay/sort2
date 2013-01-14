<?php

$records = null;
	$records = $_REQUEST['records'];
	
	require_once 'fpdf.php';
	

	//for ($i=0; $i<sizeof($records); $i++)
	//{
		$pdf = new FPDF();
		$pdf->SetFont('Times', 'B', 15);
		$pdf->AddPage();
		
		//$fullName 		= $records[$i][0] . " " . $records[$i][1] . " " . $records[$i][2] . "\n";
		//$fullAdress		= $records[$i][3] . "\n" . $records[$i][4] . "\n" . $records[$i][5] . "\n" .  $records[$i][6] . "\n";

		$pdf->Write(5, "Vasia Poopkin" );
		$pdf->Output();
	//}
	
	
	
//}

?>
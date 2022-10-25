<?php
	set_time_limit(3600);
	//Required File
	require_once "dompdf/autoload.inc.php";
	
	use Dompdf\Dompdf;

	// DOMPDF Object
	$pdf = new Dompdf();
	
	// if(isset($_POST['downloadPdf'])) {

		// Print Details

		
		// Values
		
		// Card File Inclusion
		ob_start();
		require('c.php');
		$html = ob_get_contents();
		ob_get_clean();
		
		// Loading HTML to Convert into PDF
		$pdf->loadHtml($html);
		
		// Custom Size & File Name
		date_default_timezone_set('Asia/Dhaka');
		$fileName = 'Bulk -- '.$title.' - '.date("Y-m-d h-i-s").'.pdf';
		
		$pdf->setPaper('A4', 'portrait');
		$pdf->render();
		
		$pdf->stream($fileName, array(
		"Attatchment" => false
		));


		// // Save PDF
		// $output = $pdf->output();
		// file_put_contents($fileName, $output);
		// // View PDF
		// header('Content-type: application/pdf');
		// header('Content-Disposition: inline; filename='.$fileName);
		// header('Content-Transfer-Encoding: binary');
		// header('Content-Length: ' . filesize($fileName));
		// header('Accept-Ranges: bytes');
		// readfile($fileName);
		
	// }
	
	// else {
	// 	header("Location: ../admin/index.php");
	// }
?>
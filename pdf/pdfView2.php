<?php 
	
	//Required File
	require_once "dompdf/autoload.inc.php";
	
	use Dompdf\Dompdf;
	
	// Values From Inputs
	if(isset($_POST['downloadPdf'])) {

		# Syllabus
		

		if(isset($_POST['syllabus'])) {
			$syl = $_POST['syllabus'];
		}
		
		// Department
		if(isset($_POST['department'])) {
			$department = $_POST['department'];
		}
		// Student Name
		if(isset($_POST['sname'])) {
			$sname = $_POST['sname'];
		}
		// Student ID
		if(isset($_POST['uid'])) {
			$uid = $_POST['uid'];
		}
		// Batch
		if(isset($_POST['batch'])) {
			if($_POST['batch'] < 10) {
				$batch = '0'.$_POST['batch'];
			} else {
				$batch = $_POST['batch'];
			}
		}
		// Year
		if(isset($_POST['year'])) {
			$year = $_POST['year'];
		}
		// Semester
		if(isset($_POST['semester'])) {
			$semester = $_POST['semester'];
		}
		// Session
		if(isset($_POST['session'])) {
			$session = $_POST['session'];
		}

		// Exam type
		if(isset($_POST['examtype'])) {
			if($_POST['examtype'] == 11) {
				$examtype ='Winter Semester Mid-Term';
				$color = 'white';
			}
			else if($_POST['examtype'] == 12) {
				$examtype ='Winter Semester Final';
				$color = 'pink';
			}
			else if($_POST['examtype'] == 21) {
				$examtype ='Summer Semester Mid-Term';
				$color = 'white';
			}
			else if($_POST['examtype'] == 22) {
				$examtype ='Summer Semester Final';
				$color = 'white';
			}

			else {
				$examtype ='Unknown';
			}
		}
		
		
		$pdf = new Dompdf();
		
		// Card File Inclusion
		ob_start();
		require('card.php');
		$html = ob_get_contents();
		ob_get_clean();
		
		// Loading HTML to Convert into PDF
		$pdf->loadHtml($html);
		
		// Custom Size & File Name
		$fileName = $sname.'-'.$uid.'.pdf';
		
		$pdf->setPaper('A4', 'portrait');
		$pdf->render();
		
		$pdf->stream($fileName, array(
		"Attatchment" => true
		));
		
	}
	
	else {
		header("Location: ../admin/index.php");
	}
?>		
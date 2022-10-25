<?php 
    include '../connect.php';

    // Total Students
    $tquery = "SELECT id FROM studentlist";
    $tresult = $connect->query($tquery);
    $totalstudents = $tresult->num_rows;
    echo '<p class="card-text text-center fs-2">Total Students: <span class="fw-bold fs-1">'.$totalstudents.'</span></p>';
    $connect->close();

?>
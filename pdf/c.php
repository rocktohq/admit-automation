<?php
include '../connect.php';
include 'functions.php';
include 'logo.php';

$sql = "SELECT * FROM `sfmu.print_details`";
$result = $connect->query($sql);
$row = $result->fetch_assoc();
$department = strtolower($row['short_name']);
$examtype = $row['examtype'];
$esemester = $row['esemester'];
$color = $row['color'];
$syl = $row['syllabus'];
$title = strtoupper($department);

// $syllabus = '`sfmu.'.$department.'_syllabus_'.$syl.'`';
$syllabus = "`sfmu.{$department}_syllabus_{$syl}`";


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admits of <?php echo $title; ?> Department</title>
    <!-- Custom CSS -->

    <?php include 'style.php'; ?>
</head>

<body>
    <?php
    // Students Information
    $sql = "SELECT * FROM `sfmu.tmp_students`";
    $result= $connect->query($sql);
    while($row = $result->fetch_assoc()) {
        $syear = $row['year'];
        $ssemester = $row['semester'];
        if($row['batch'] < 10) {
            $batch = '0'.$row['batch'];
        } else {
            $batch = $row['batch'];
        }

    ?>
    <div class="admit-card-main">
        <div class="header">
            <img src="<?php echo $encLogo; ?>" alt="Logo">
            <h3 class="varsity">Sheikh Fazilatunnesa Mujib University, Jamalpur</h3>
            <div class="clear"></div>
        </div>
        <h1 class="admit-text">Admit Card</h1>
        <div class="container ml-2 fs-12">
            <div class="exam-name">
                <p class="fw-bold"><?php echo $esemester; ?> Semester <?php echo $examtype; ?> Examination, <?php echo date("Y"); ?></p>
            </div>
            <div class="information">
                <p class="fw-bold">Department: <?php echo strtoupper($department); ?></p>
                <p class="fw-bold">Undergraduate/Graduate Program: <?php program($department); ?> (Honours)</p>
                <table class="fw-bold">
                    <tr>
                        <td>Year: <?php echo $row['year']; ?><?php echo supText($row['year']); ?></td>
                        <td>Semester: <?php echo $row['semester']; ?><?php echo supText($row['semester']); ?></td>
                    </tr>
                    <tr>
                        <td>Batch No: <?php echo $batch; ?></td>
                        <td>Admission Session: <?php echo $row['session']; ?></td>
                    </tr>
                </table>
                <p class="fw-bold">ID: <?php echo $row['uid']; ?></p>
                <p class="fw-bold">Type of Student: Regular<?php 
                    if(!empty($row['retake'])) {
                        echo ', Retake';
                    } 
                    if(!empty($row['improvement'])) {
                        echo ', Improvement';
                    }
                    if(!empty($row['recourse'])) {
                        echo ', Recourse';
                    }
                    if(!empty($row['incomplete'])) {
                        echo ', Incomplete';
                    }
                ?></p>
                <p class="fw-bold">Name <span class="fw-normal">(Block Letter)</span>: <span class="fw-bold"><?php echo $row['name']; ?></span></p>
            </div>
        </div>
        <div class="admit-extra">
            <p class="fs-11 fw-bold ml-1">Subject registered with course code for examination:</p>
            <table>
                <tr class="fs-10 fw-bold text-center">
                    <td>SL</td>
                    <td>Course Title</td>
                    <td>Course Code</td>
                    <td>RT/GI/RC/I</td>
                    <td>Credit</td>
                </tr>
                <?php
                $csql = "SELECT * FROM $syllabus WHERE year = '$syear' AND semester = '$ssemester' AND type = 1";
                $cresult= $connect->query($csql);
                $len = $cresult->num_rows;
                $len1 = $len+1;
                $i = 1;
                while($crow = $cresult->fetch_assoc()) {
                
                ?>
                <tr class="fs-10">
                    <td class="text-center"><?php echo $i; ?></td>
                    <td><?php echo ucwords($crow['course_title']); ?></td>
                    <td><?php echo strtoupper(str_replace("-", " ", $crow['course_code'])); ?></td>
                    <td class="text-center"></td>
                    <td class="text-center"><?php echo $crow['credit']; ?></td>
                </tr>
                  
                <?php $i++; } ?>
                <?php
                    if(!empty($row['retake'])) {
                        $values =  explode(",", str_replace(", ", ",", $row['retake']));
                        foreach($values as $value) {
                            echo '<tr class="fs-10">
                            <td class="text-center">'.$len1.'</td>';
                            print retake($value, $syllabus);
                            echo '</tr>';
                            $len1++;
                        }
                        
                    }

                    if(!empty($row['improvement'])) {
                        $values =  explode(",", str_replace(", ", ",", $row['improvement']));
                        foreach($values as $value) {
                            echo '<tr class="fs-10">
                            <td class="text-center">'.$len1.'</td>';
                            print improvement($value, $syllabus);
                            echo '</tr>';
                            $len1++;
                        }
                        
                    }

                    if(!empty($row['recourse'])) {
                        $values =  explode(",", str_replace(", ", ",", $row['recourse']));
                        foreach($values as $value) {
                            echo '<tr class="fs-10">
                            <td class="text-center">'.$len1.'</td>';
                            print recourse($value, $syllabus);
                            echo '</tr>';
                            $len1++;
                        }   
                    }

                    if(!empty($row['incomplete'])) {
                        $values =  explode(",", str_replace(", ", ",", $row['incomplete']));
                        foreach($values as $value) {
                            echo '<tr class="fs-10">
                            <td class="text-center">'.$len1.'</td>';
                            print incomplete($value, $syllabus);
                            echo '</tr>';
                            $len1++;
                        }   
                    }

                    ?>
                <?php
                
                for($i = $len1; $i<=10; $i++) {
                    echo '<tr class="fs-10">
                    <td class="text-center">'.$i.'</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>';
                }
                ?>
            </table>
            <div class="instructions ml-1">
                <p class="fs-11 fw-bold mt-1">Instructions:</p>
                <ol class="fs-10">
                    <li>Students are not allowed to sit for the examination without Admit Card.</li>
                    <li>Students can keep necessary instruments with them for examination with the permission of the invigilators.</li>
                    <li>Students must abide by the rules of examination.</li>
                    <li>The examinee should enter the examination hall after entering the invigilators.</li>
                    <li>No student is allowed to sit for the examination after half an hour of starting.</li>
                    <li>No examinee should leave the examination hall before an hour of starting.</li>
                    <li>Any sort of unfair means is a punishable offence.</li>
                    <li>Mobile phone is strictly prohibited during the examination.</li>
                </ol>
            </div>
            <div class="seal mt-1">
                <img class="signature" src="<?php echo $encSig2; ?>" alt="Signature">
                <p class="fw-bold">Controller of Examination</p>
            </div>
        </div>
        <div class="fs-10 fw-bold ml-2">[NB: Admit card should not be used for any kind of staining, writing or using dishonest means.]</div>
    </div>
    <?php } ?>
</body>

</html>
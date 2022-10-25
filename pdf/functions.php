<?php

//Power Text
function supText($value) {
    if($value == 1) {
        echo '<sup>st</sup>';
    }
    else if($value == 2) {
        echo '<sup>nd</sup>';
    }
    else if($value == 3) {
        echo '<sup>rd</sup>';
    }
    else if($value > 3) {
        echo '<sup>th</sup>';
    }
    else {
        echo '<sup>unknown</sup>';
    }
}

// Retake
function retake($sub, $syllabus) {
    include '../connect.php';
    $rcode = strtolower($sub);
    $sql = "SELECT * FROM $syllabus WHERE course_code = '$rcode'";
    $result = $connect->query($sql);
    $row = $result->fetch_assoc();
    echo '<td>'.ucwords($row['course_title']).'</td>
        <td>'.strtoupper(str_replace("-", " ", $row['course_code'])).'</td>
        <td class="text-center">RT</td>
        <td class="text-center">'.$row['credit'].'</td>';
}

// Improvement
function improvement($sub, $syllabus) {
    include '../connect.php';
    $rcode = strtolower($sub);
    $sql = "SELECT * FROM $syllabus WHERE course_code = '$rcode'";
    $result = $connect->query($sql);
    $row = $result->fetch_assoc();
    echo '<td>'.ucwords($row['course_title']).'</td>
        <td>'.strtoupper(str_replace("-", " ", $row['course_code'])).'</td>
        <td class="text-center">GI</td>
        <td class="text-center">'.$row['credit'].'</td>';
}

// Recourse
function recourse($sub, $syllabus) {
    include '../connect.php';
    $rcode = strtolower($sub);
    $sql = "SELECT * FROM $syllabus WHERE course_code = '$rcode'";
    $result = $connect->query($sql);
    $row = $result->fetch_assoc();
    echo '<td>'.ucwords($row['course_title']).'</td>
        <td>'.strtoupper(str_replace("-", " ", $row['course_code'])).'</td>
        <td class="text-center">RC</td>
        <td class="text-center">'.$row['credit'].'</td>';
}

// Incomplete
function incomplete($sub, $syllabus) {
    include '../connect.php';
    $rcode = strtolower($sub);
    $sql = "SELECT * FROM $syllabus WHERE course_code = '$rcode'";
    $result = $connect->query($sql);
    $row = $result->fetch_assoc();
    echo '<td>'.ucwords($row['course_title']).'</td>
        <td>'.strtoupper(str_replace("-", " ", $row['course_code'])).'</td>
        <td class="text-center">I</td>
        <td class="text-center">'.$row['credit'].'</td>';
}

// Program
function program($dep) {
    include '../connect.php';
    $dep = strtolower($dep);
    $sql = "SELECT program FROM `sfmu.departments` WHERE short_name = '$dep'";
    $result = $connect->query($sql);
    $row = $result->fetch_assoc();
    echo $row['program'];

}
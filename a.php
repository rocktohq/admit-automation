<?php
include 'connect.php';

$username = 'AdminMe';
$department = 'HelloDept';

$query = "INSERT INTO `sfmu.logs`(`user_name`, `department`, `login_time`) VALUES('$username','$department', NOW())";
$connect->query($query);
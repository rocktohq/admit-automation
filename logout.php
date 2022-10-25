<?php
include 'connect.php';

session_start();
$name = $_SESSION['name'];
date_default_timezone_set('Asia/Dhaka');
// $date = date('Y-m-d h:i:s');

$sql = "UPDATE `sfmu.logs` SET `logout_time` = NOW() WHERE `user_name` = '$name' ORDER BY id DESC LIMIT 1";
$connect->query($sql);

session_destroy();
header("Location: index.php");


?>
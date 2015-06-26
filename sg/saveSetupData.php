<?php
require 'dbconnect.php';
$van = $_POST['van'];
$temp = $_POST['temp']; 
$humi = $_POST['humi'];
$command = "#".$van.$temp.$humi;   
mysql_query("insert into command values ('".$command."')");

mysqli_connect($connect);
?>
<?php
require 'dbconnect.php';
$van_no = $_GET['vanno'];
$my_query1 = "UPDATE mapstt SET van_no = '".$van_no."' ";
mysql_query ($my_query1);
echo $van_no;

mysqli_close($connect);
?>
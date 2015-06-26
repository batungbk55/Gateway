<?php
require '../dbconnect.php';

$id= $_GET["id"];

$query1 = "INSERT INTO `tbSensor` (`id` ,`sensors`)VALUES (NULL ,  '$id');";

$fetch = mysql_query($query1); 
?>

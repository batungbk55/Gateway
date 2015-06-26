<?php

require '../dbconnect.php';

$id= $_GET["id"];


$query1 = "INSERT INTO `tbSMS_EB` (`id` ,`SMS`)VALUES (NULL ,  '$id');";

$fetch = mysql_query($query1); 
?>

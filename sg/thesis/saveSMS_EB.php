<?php

require '../dbconnect.php';

$id= $_GET["id"];


$query1 = "INSERT INTO `tbSMS_EB` (`id` ,`SMS_EB`)VALUES (NULL ,  '$id');";

$fetch = mysql_query($query1); 
?>

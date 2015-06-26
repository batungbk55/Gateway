<?php

if (isset ($_GET["id"]))
{
require '../dbconnect.php';
 

$id= $_GET["id"];


$query1 = "INSERT INTO  `command` (`command`)VALUES ('$id');";

$fetch = mysql_query($query1); 

   
}
?>

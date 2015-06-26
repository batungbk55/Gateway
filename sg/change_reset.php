<?php
require 'dbconnect.php';
$my_query1 = "UPDATE mapstt SET reset = 1";
mysql_query ($my_query1);
echo "resetok";

mysqli_close($connect);
?>
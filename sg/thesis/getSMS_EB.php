<?php

{
require '../dbconnect.php';
$query = "select SMS_EB from tbSMS_EB;";

$fetch = mysql_query($query); 
$str="";
while ($row = mysql_fetch_array($fetch, MYSQL_ASSOC)) {
   
   $str = $str.$row['SMS_EB'].";";
 
}

echo $str;
   
}
?>

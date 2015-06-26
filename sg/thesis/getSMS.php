<?php

{
require '../dbconnect.php';

$query = "select SMS from `tbSMS`;";

$fetch = mysql_query($query); 
$str="";
while ($row = mysql_fetch_array($fetch, MYSQL_ASSOC)) {
   
   $str = $str.$row['SMS'];
 
}

echo $str;
   
}
?>

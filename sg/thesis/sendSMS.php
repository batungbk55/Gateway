<?php

{

require '../dbconnect.php';
$query= "SELECT data FROM sendSMS"; 
$fetch = mysql_query($query); 
$str="";
while ($row = mysql_fetch_array($fetch, MYSQL_ASSOC)) {
   $str = $str.$row['data'];
}
echo $str;  
}


?>

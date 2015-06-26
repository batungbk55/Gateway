<?php

{
require '../dbconnect.php';

$query = "select command from `command`;";

$fetch = mysql_query($query); 
$str="";
while ($row = mysql_fetch_array($fetch, MYSQL_ASSOC)) {
   
   $str = $str.$row['command'];
 
}

echo $str;
   
}
?>

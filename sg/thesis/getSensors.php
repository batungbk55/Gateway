<?php

{
 
require '../dbconnect.php';

$query = "SELECT * FROM  `cdata` WHERE nodecat =  'sensor' AND STATUS =1";

$fetch = mysql_query($query); 
$str="";
while ($row = mysql_fetch_array($fetch, MYSQL_ASSOC)) {
   
   $str = $str.$row['mac']."-".$row['netip']."@";
 
}

echo $str;
   
}
?>

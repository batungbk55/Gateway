<?php
require '../dbconnect.php';
$chon=mysql_query("SELECT * FROM link where id='4'");
while($kqchon=mysql_fetch_array($chon))
{
    $a1=$kqchon['url'];
}
 mysql_query("UPDATE link SET url = '1' WHERE id = '5'");
if($a1==2)
{
	pclose(popen("start /B ping.bat","r"));die();
}
if($a1==1)
{
	pclose(popen("start /B 1ping.bat","r"));die();
}
?>
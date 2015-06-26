<?php
	require 'dbconnect.php';
	$result=$_GET['data'];
	$mac = substr ($result,8,2);//MM
	$network_ip = substr ($result,4,4);//NNNN
	$now = getdate(); 
    $cTime = $now["hours"] . ":" . $now["minutes"] . ":" . $now["seconds"]; 
    $cDate = $now["year"] . "-" . $now["mon"] . "-" . $now["mday"]; 
	$my_query = "INSERT INTO node_data(mac,netip,status,date,time) VALUES ('".$mac."','".$network_ip."','join','".$cDate."','".$cTime."')";
	mysql_query ($my_query);
	$mac = '04';
	$sql1 = "SELECT netip FROM data_sensor WHERE mac='04' order by data_sensor.time desc LIMIT 0,1";
	mysql_query($sql1);
	$q = mysql_query("SELECT netip FROM data_sensor WHERE mac = '04' ORDER BY TIME DESC LIMIT 0 , 1");
	$row  = mysql_fetch_array($q);
	echo $row['netip'];
	
	mysqli_close($connect);
	
?>
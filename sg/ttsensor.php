<?php
require 'dbconnect.php';
$id = $_POST['id'];
$sql1 = "SELECT * FROM cdata WHERE mac='".$id."'";
$query1 = mysql_query($sql1);
$row_no = mysql_num_rows($query1);
if($row_no==0){//Neu chua ton tai dia chi mac
		$netip = 'ko xd';
		$status = 0;
		$temp = 'ko xd';
		$humi = 'ko xd';
		$ener = 'ko xd';
}
else{ //Neu da ton tai mac
	while ($row1 = mysql_fetch_array($query1)){
		$netip = $row1['netip'];
		$status = $row1['status'];
		$temp = $row1['temp'];
		$humi = $row1['humi'];
		$ener = $row1['ener'];
	}
}
$member = array('mac' => $id
			   ,'netip' => $netip
			   ,'status' => $status
			   ,'temp' => $temp
			   ,'humi' =>$humi
			   ,'ener' => $ener);
echo json_encode($member);
die;

mysqli_close($connect);
?>
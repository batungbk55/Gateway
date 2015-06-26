<?php
require 'dbconnect.php';
$id = $_POST['id'];

$sql1 = "SELECT * FROM val_status WHERE val='".$id."'";
$query1 = mysql_query($sql1);
$row_no = mysql_num_rows($query1);
if($row_no==0){//Neu chua ton tai val
}
else{ //Neu da ton tai val
	while ($row1 = mysql_fetch_array($query1)){
		$status = $row1['status'];
		if ($status==0)$status = "tat"; 
		else $status = "bat";
		$member = array('val' => $id,'status' => $status);
	}
}
echo json_encode($member);
die;

mysqli_close($connect);
?>
<?php
	require 'dbconnect.php';
	$id = $_POST['id'];
	$result = mysql_query("SELECT * FROM bantin WHERE STT='".$id."'");
    $row = mysql_fetch_row($result);
    $bantin = $row[1];
	echo $bantin;
	
	mysqli_close($connect);
?>
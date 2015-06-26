<?php
	require 'dbconnect.php';
	$u = $_POST['user'];
	$p = $_POST['pass'];
	$result = mysql_query("SELECT MAX(user_id) FROM user");
	$row = mysql_fetch_row($result);
	$id = $row[0] + 1;
	$sql="SELECT user_id from user where user_name='".$u."'";
    $query=mysql_query($sql);
	$row = mysql_fetch_row($query);
    if ($row > 0) {
	     echo "false";
    }
    else{
		$sql1="INSERT INTO user (level, user_name, password, user_id) VALUES ('2','".$u."','".$p."','".$id."')";
		$query1=mysql_query($sql1);
		echo "true";
	}
	
	mysqli_close($connect);
?>
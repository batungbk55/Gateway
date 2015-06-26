<?php
require 'dbconnect.php';
session_start();
$u = $_POST['u'];
$p = $_POST['p'];
$_SESSION['user'] = $u;
$_SESSION['p'] = $p;
$response="false";
$statement="Select level from user WHERE user_name='".$u."' and password='".$p."'";
$result=mysql_query($statement);
if (!$result) {
	echo $response;
}
else{
	while($row=mysql_fetch_array($result)){
		$response="true";
		$_SESSION['login_status'] ='yes';
		$_SESSION['level'] = $row['level']; 
	}
}
echo $response;

mysqli_close($connect);
?>
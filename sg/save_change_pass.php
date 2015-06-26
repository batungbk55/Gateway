<?php
require 'dbconnect.php';
session_start();

$pass = $_POST['pass'];
$newpass = $_POST['newpass'];
$user = $_SESSION['user'];
$sql = "SELECT * FROM user WHERE user_name = '".$user."'";
$query = mysql_query($sql);
$row = mysql_fetch_row($query);
$result = "false";
if($row >0)
{
	$p = $row[2];
	if($pass == $p)
	{
		mysql_query("UPDATE user SET password='".$newpass."' WHERE user_name='".$user."'");
		$result = "true";;
		}
}
echo $result;

mysqli_close($connect);
?>
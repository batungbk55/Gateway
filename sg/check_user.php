<?php
require 'dbconnect.php';
if(isset($_POST['username']))
{
$user = $_POST['username'];
$sql="Select user_id from user where user_name='".$user."'";
$query=mysql_query($sql);
$row = mysql_fetch_row($query);
if($row > 0)
{
	echo "false";
}
else
{
	echo "true";
	}
}

mysqli_close($connect);
?>
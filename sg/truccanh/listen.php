<?
require '../dbconnect.php';
$sql=mysql_query("SELECT * FROM kiemtra ");
while($kq=mysql_fetch_array($sql)){
    $a=$kq['trangthai'];
}
?>
<html>
	<head>  
	<!--meta http-equiv="refresh" content="1"-->
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	</head>
	<body>  
		<h2>Hiện Tại Chưa Nhận Được Cảnh Báo !</h2>
	<?
	if($a=='bat'){ 
		mysql_query("UPDATE kiemtra SET trangthai = 'tat' WHERE ID = '1'"); 
    ?>
	<script>
		location.href="action.php";
	</script>
	<?
	   //mysql_query("UPDATE kiemtra SET trangthai = 'tat' WHERE ID = '1'"); 
	}
	else
	{}
	?>
	<div id="mama"></div>
	</body>
</html>
<?php
session_start();
require '../dbconnect.php';
mysql_query("UPDATE kiemtra SET trangthai = 'tat' WHERE ID = '1'");  
$chon2=mysql_query("SELECT * FROM link where id='5'");
while($kqchon2=mysql_fetch_array($chon2))
{
    $a2=$kqchon2['url'];
}
$date = time();
$mdir='video'; //thu muc chua tap tin can doi ten
$r1='thanghien'; //tu can doi trong ten file
$r2=gmdate("d-m-Y-H-i-s", time()+7*3600);
$r3=gmdate('d-m-Y');
$r4=gmdate('H-i-s',time()+7*3600);
 //ten dc doi thanh
function mass_rename($dir,$r1,$r2) {
	$opdir=opendir($dir);
	while ($a=readdir($opdir)) {
		if ($a=='.' or $a=='..') continue;
		if (is_file($dir.'/'.$a)) {
			$b=str_replace($r1,$r2,$a);
			rename($dir.'/'.$a,$dir.'/'.$b); 
			}
		else {
			mass_rename($dir.'/'.$a,$r1,$r2); 
			} 
		}
		closedir($opdir);
		return $dir; 
	}
	mass_rename($mdir,$r1,$r2);
	if($a2==1){
		mysql_query("INSERT INTO video VALUES('{$r4}','{$r3}')");
		mysql_query("UPDATE link SET url = '0' WHERE id = '5'"); 
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2//EN">
<html>
<head>
<title>Trực Canh</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<script src="jquery.js"></script>
</head>
<body>
	<form method="POST">
		<script>	   
		     var isLogin='<?php if(isset($_SESSION['login_status'])){if($_SESSION['login_status']=='yes')echo 'yes';else echo 'no';}else    echo 'no';?>';
	     var isLevel='<?php if(isset($_SESSION['level'])){echo $_SESSION['level'];}?>';
		 if(isLevel == 1)
		 {
			function updatePhone(){
				  var url = "listen.php";
				jQuery("#mama").load(url);
			}
			setInterval("updatePhone()", 1000);
		 }
		 else
		 {
			 $(document).ready(function(e) {
                $("#mama").html("<h3>Bạn chưa đăng nhập hoặc không có quyền xem trực canh !</h3>");
            });
			 }
		</script>
		<br />
		<div id="mama"></div>
	</form>
</body>
</html>

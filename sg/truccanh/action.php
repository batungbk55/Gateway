<?
require '../dbconnect.php';
$chon=mysql_query("SELECT * FROM link where id='4'");
while($kqchon=mysql_fetch_array($chon))
{
    $a1=$kqchon['url'];
}
$sql=mysql_query("SELECT * FROM link where id='{$a1}'");
while($kq=mysql_fetch_array($sql))
{
    $a=$kq['url'];
}
?>
<html>
	<head>
		<title>Trực Canh</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	</head>
  	<script type="text/javascript">
		init_reload();
		function init_reload(){
			setInterval( function() {					   
				window.location.href="index.php";
			},60000);
		}
	</script>
    <h2>Cảnh Báo !</h2>
    <br/>
    <br/>    
	<body >  
		<form name="aa" method="POST">
		<embed type="application/x-vlc-plugin" version="VideoLAN.VLCPlugin.2"
				name="video" id="video: my video" autoplay="yes" loop="yes"
				target="<?php print $a ?>"
				 width="352" height="288" onfocus="javascript:videoClicked();" />
		<br />
		<br />
		<object width="1" height="1" loop="yes">
			<param name="movie" value="baodong.mp3" />
			<param name="quality" value="high" />
			<param name="wmode" value="transparent" />
			<embed width="1" height="1" src="baodong.mp3" loop="yes"></embed>
		</object>
		<br /> 
		<br />
		<iframe src="luu.php" scrolling="no" height="10" width="10" frameborder="0" ></iframe>   
		</form>
	</body>
</html>
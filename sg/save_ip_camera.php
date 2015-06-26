<?php
require 'dbconnect.php';
$ip_camera = $_POST['ip'];
$stream_ip = array();
$stream_ip[0] = "@echo on \r\n";
$stream_ip[1] = "cd C:\Program Files\VideoLAN\VLC\r\n";
$save_ip = "vlc -vvv \"http://".$ip_camera.":12345\" --sout=#transcode{vcodec=mp2v,vb=\"352\",vfilter=croppadd{cropttop=0,cropbottom=0,paddleft=0}}:standard{access=file,mux=ts,dst=\"C:\\xampp\\htdocs\\web\\sg\\truccanh\\video\\thanghien.mpg\"} --run-time 50 vlc://quit \r\n";
$stream_ip[2] = "exit";
$ping_new =  $stream_ip[0].$stream_ip[1].$save_ip.$stream_ip[2];
$fpt3=fopen("truccanh/1ping.bat","w+")or exit("khong tim thay file can mo");
$write3=fwrite($fpt3,$ping_new);
fclose($fpt3);
$ip="http://".$ip_camera.":12345/video2.mjpg";
mysql_query("UPDATE link SET url = '{$ip}' WHERE id = '1'");
echo "Thay đổi IP Thành Công";

mysqli_close($connect);
?>
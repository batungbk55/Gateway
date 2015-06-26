<?php
require 'dbconnect.php';
if(isset($_POST['ip_bo']) && isset($_POST['ip_server']))
{
	$ip_bonhung = $_POST['ip_bo'];
	$ip_server = $_POST['ip_server'];
	$stream_webcam = array();
	$stream_webcam[0] = "@echo on \r\n";
	$stream_webcam[1] = "cd C:\Program Files\VideoLAN\VLC\r\n";
	$stream_webcam[2] = "vlc -vvv \"rtsp://".$ip_bonhung.":5454/test1.rtp\" --sout \"#transcode{vcodec=mp4v,acodec=mpga,vb=280}:standard{access=http,mux=ogg,dst=".$ip_server.":1234}\" run-time 10 vlc://quit\r\n";
	$stream_webcam[3] = "exit";
	$server_new = $stream_webcam[0].$stream_webcam[1].$stream_webcam[2].$stream_webcam[3];
	$fpt2=fopen("truccanh/server.bat","w+")or exit("khong tim thay file can mo");
    $write2=fwrite($fpt2,$server_new);
	fclose($fpt2);
		
	$save_webcam = "vlc -vvv \"http://".$ip_server.":1234\" --sout=#transcode{vcodec=mp2v,vb=\"280\",vfilter=croppadd{cropttop=0,cropbottom=0,paddleft=0}}:standard{access=file,mux=ts,dst=\"C:\\xampp\\htdocs\\web\\sg\\truccanh\\video\\thanghien.mpg\"} --run-time 50 vlc://quit \r\n";;
	$ping_new =  $stream_webcam[0].$stream_webcam[1].$save_webcam.$stream_webcam[3];
	$fpt=fopen("truccanh/ping.bat","w+")or exit("khong tim thay file can mo");
    $write=fwrite($fpt,$ping_new);
	fclose($fpt);
    $iptg="http://".$ip_server.":1234";
    mysql_query("UPDATE link SET url = '{$iptg}' WHERE id = '2'");
    mysql_query("UPDATE socket SET ip = '{$ip_bonhung}' WHERE id = '1'");
	
	echo "Cài đặt địa chỉ IP thành công";
}

mysqli_close($connect);
?>
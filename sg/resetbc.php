<?php   
require 'dbconnect.php';
sleep(1);
$bt = "Chưa nhận được phản hồi từ actor báo cháy.";
$mymsg = $_POST['command'];//NNNN 031 $
$netip = substr ($mymsg,0,4);
$mymsg = "OK:".$netip."B183";
$now = getdate();
while(true)
{
	$sql1="SELECT bt FROM bantin_map WHERE bt LIKE '%".$mymsg."%' LIMIT 1";//#OK:B1NNNN83
	$query1 = mysql_query($sql1);
	$row_no = mysql_num_rows($query1);
	if($row_no != 0)
	{
		$bt = "Đã reset thành công báo cháy.";	
		break;
	}
	$now1 = getdate();
	$a = ($now1["hours"]*3600+$now1["minutes"]*60+$now1["seconds"])- ($now["hours"]*3600+$now["minutes"]*60+$now["seconds"]);
	if($a>25){

		break;
	}
}
/*
for ($i = 0; $i<5; $i++){
	$sql1="SELECT bt FROM bantin_map WHERE bt LIKE '%".$mymsg."%' LIMIT 1";//#OK:B1NNNN83
	$query1 = mysql_query($sql1);
	$row_no = mysql_num_rows($query1);	
	if($row_no==0){
		sleep(1);
	}
	else{
		while ($row1 = mysql_fetch_array($query1)){
			$bt = "Da reset thanh cong actor bao chay.";				
		}
		break;
		
	}
}
*/
echo $bt;
$sql1="DELETE FROM bantin_map WHERE bt LIKE '%".$mymsg."%' ";//#OK:B1NNNN13
$query1 = mysql_query($sql1);
$my_query1 = "UPDATE mapstt SET reset = 0 ";
mysql_query ($my_query1);
mysqli_close($connect);
?>
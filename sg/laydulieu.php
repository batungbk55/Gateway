<?php   
require 'dbconnect.php';
$msg = $_POST['command'];//NNNN000
$network_ip = substr ($msg,0,4);
$mymsg = "#RD:".$network_ip;
//sleep(1);
$bt = "false";
$now = getdate();
while(true)
{
	$sql1="SELECT bt FROM bantin_map WHERE bt LIKE '%".$mymsg."%'";
	$query1 = mysql_query($sql1);
	$row_no = mysql_num_rows($query1);
	if($row_no != 0)
	{
		while($row1 = mysql_fetch_array($query1)){
			$bt = $row1['bt'];
		}
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
	$sql1="SELECT bt FROM bantin_map WHERE bt LIKE '%".$mymsg."%'";
	$query1 = mysql_query($sql1);
	$row_no = mysql_num_rows($query1);	
	if($row_no==0){
		sleep(1);
	}
	else{
		while ($row1 = mysql_fetch_array($query1)){
			$bt = $row1['bt'];
			
		}
		break;		
	}
}
*/
if ($bt!="false"){
		$result = $bt;
		$mac = substr($result,6,2);
		$network_ip= substr($result,4,4);
		$mac = substr($result,8,2);
		
		$temp_16 = substr($result,10,4);
		$temp_10 = base_convert($temp_16, 16, 10);
		$tempreture = $temp_10*0.01-39.6;
		
		$humidity_16 = substr($result,14,4);
		$humidity_10 = base_convert($humidity_16,16,10);
		$h1 = 0.0367*$humidity_10-0.0000015955*$humidity_10*$humidity_10- 2.0468;
		$humidity = ($tempreture - 25)*(0.01+0.00008*$humidity_10) + $h1;
		
		$EE_16 = substr($result,18,4);
		$EE_10 = base_convert($EE_16,16,10);
		$energy =(0.78/((doubleval($EE_10)/4096)));
		
		$member = array('mac' => $mac
					   ,'netip' => $network_ip
					   ,'temp' => $tempreture
					   ,'humi' => $humidity
					   ,'ener' => $energy);
		echo json_encode($member);
}
else echo $bt;
$sql1="DELETE FROM bantin_map WHERE bt LIKE '%".$mymsg."%'";
$query1 = mysql_query($sql1);
$my_query1 = "UPDATE mapstt SET temp_humi = 0 ";
mysql_query ($my_query1);

mysqli_close($connect);
?>
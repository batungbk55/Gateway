<?php   
require 'dbconnect.php';
sleep(1);
$bt = "Chưa nhận được phản hồi!";
$now = getdate();
while(true)
{
	$sql1="SELECT bt FROM bantin_map WHERE bt LIKE '%OK:0000008F%' LIMIT 1";
	$query1 = mysql_query($sql1);
	$row_no = mysql_num_rows($query1);
	if($row_no != 0)
	{
		$bt = "Tất cả các van đã được bật thành công.";		
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
		$sql1="SELECT bt FROM bantin_map WHERE bt LIKE '%OK:0000008F%' LIMIT 1";
		$query1 = mysql_query($sql1);
		$row_no = mysql_num_rows($query1);	
		if($row_no==0){
			sleep(1);
		}
		else{
		
			$bt = "Tất cả các van đã được bật thành công.";		
			break;
			
		}
	}
	*/
$sql1="DELETE FROM bantin_map WHERE bt LIKE '%OK:0000008F%' ";
$query1 = mysql_query($sql1);
$my_query1 = "UPDATE mapstt SET van_no = 0 ";
mysql_query ($my_query1);
echo $bt;

mysql_close($connect);
?>
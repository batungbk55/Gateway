<?php   
require 'dbconnect.php';
sleep(1);
$bt = "false";
	for ($i = 0; $i<5; $i++){
		$sql1="SELECT bantin FROM bantin WHERE bantin LIKE '%#OK:0000000F%' LIMIT 1";
		$query1 = mysql_query($sql1);
		$row_no = mysql_num_rows($query1);	
		if($row_no==0){
			sleep(1);
		}
		else{
			while ($row1 = mysql_fetch_array($query1)){
				$bt = "Tat ca cac van da tat thanh cong.";	
			}
			break;
		}
	}
echo $bt;
?>
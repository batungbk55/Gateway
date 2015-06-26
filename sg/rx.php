<?php
require 'dbconnect.php';
if(isset($_GET['data'])) echo $_GET['data'];
//$result1 = $_GET['data'];
$result="#".$_GET['data'];
/*
if(strpos($result1,"RS")!== false)
{
	$my_query = "UPDATE cdata SET status=0 WHERE 1";
	mysql_query($my_query);
	$my_query = "UPDATE cdata SET status=1 WHERE mac ='00'";
	mysql_query($my_query);
}
else if(strpos($result1,"BC")!== false)
{
	$my_query = "UPDATE cdata SET status=0 WHERE 1";
	mysql_query($my_query);
	$my_query = "UPDATE cdata SET status=1 WHERE mac ='B1'";
	mysql_query($my_query);
	mysql_query("UPDATE cdata SET netip='0000' WHERE mac='B1'");
	}
else*/
{
$sql2 = "INSERT INTO bantin(bantin) VALUES ('".$result."')";
mysql_query($sql2);

$my_query = "INSERT INTO tbSMS_EB(SMS_EB) VALUES ('".$result1."')";
mysql_query ($my_query);

$insertID = mysql_insert_id();
$insertID = $insertID - 5;
$sql5 = "DELETE FROM bantin WHERE STT='".$insertID."'";
mysql_query($sql5);

if(strpos($result,"JN:")!==false){	//#JN:NNNNMM
	$my_query = "INSERT INTO Sensors(data) VALUES ('".$result1."')";
	mysql_query ($my_query);
		$mac = substr ($result,8,2);//MM
		$network_ip = substr ($result,4,4);//NNNN
		
		$my_query = "INSERT INTO data_sensor(mac,netip,cat,time) VALUES ('".$mac."','".$network_ip."',1,now())";
		mysql_query ($my_query);
		
		$sql1 = "SELECT * FROM cdata WHERE mac='".$mac."'";
		$query1 = mysql_query($sql1);
		$row_no = mysql_num_rows($query1);	
		if($row_no==0){
			$check = 0;//Neu chua ton tai dia chi mac
		}
		else $check=1;
		if( "01"<= $mac && $mac < "A0"){//Sensor
			if($check == 1){//Da ton tai mac thi thay the
				$my_query = "UPDATE cdata SET netip = '".$network_ip."', nodecat = 'sensor', status=1 WHERE mac = '".$mac."'";
				mysql_query($my_query);
			}
			else{//Xet dia chi mang
				$sql2 = "SELECT * FROM cdata WHERE netip = '".$network_ip."'";
				$query2 = mysql_query($sql2);
				$row_no2 = mysql_num_rows($query2);
				if($row_no2==0){
					$checkip = 0;//Neu ko ton tai dia chi mang
				}
				else $checkip=1;
				if ($checkip==1){
					$my_query = "UPDATE cdata SET mac = '".$mac."', nodecat = 'sensor', status=1 WHERE netip = '".$network_ip."'";
					mysql_query($my_query);
				}
				else {
					$my_query = "INSERT INTO cdata(mac,netip,nodecat,status) VALUES ('".$mac."','".$network_ip."','sensor',1)";
					mysql_query ($my_query);
				}
			}
		}
		else{ // artor
			if($check == 1){
				$my_query = "UPDATE cdata SET netip = '".$network_ip."', nodecat = 'actor' WHERE mac = '".$mac."'";
				mysql_query($my_query);
			}
			else{
				$sql2 = "SELECT * FROM cdata WHERE netip = '".$network_ip."'";
				$query2 = mysql_query($sql2);
				$row_no2 = mysql_num_rows($query2);
				if($row_no2==0){
					$checkip = 0;//Neu ko ton tai dia chi ip
				}
				else $checkip=1;
				if ($checkip==1){
					$my_query = "UPDATE cdata SET mac = '".$mac."', nodecat = 'actor', status=1 WHERE netip = '".$network_ip."'";
					mysql_query($my_query);
				}
				else{
				$my_query = "INSERT INTO cdata(mac,netip,nodecat,status) VALUES ('".$mac."','".$network_ip."','actor',1)";
				mysql_query($my_query);
				}
			}
		}	
}

if(strpos($result,"AD:")!==false){//#AD:NNNNMMDDDDDDDDEEEE
		$mac = substr ($result,8,2);//MM
		$network_ip = substr ($result,4,4);//NNNN
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
		
		$my_query = "INSERT INTO data_sensor(mac,netip,cat,time,temp,humi,ener) VALUES ('".$mac."','".$network_ip."',2,now(),'".$tempreture."','".$humidity."','".$energy."')";
		mysql_query ($my_query);
		
		//luu vao bang du lieu trung binh
		if($mac[0] == '0')
		{
			$sqllan = "SELECT * FROM data_avg WHERE Sensor='".$mac."' and Date='".date('d-m-Y')."'";
			$querylan = mysql_query($sqllan);
			$rowlan = mysql_num_rows($querylan);
			if($rowlan == 0)
			{
				$insert_lan = "INSERT INTO data_avg VALUES('".$mac."','".$tempreture."','".$humidity."','".$energy."','".date('d-m-Y')."')";
				mysql_query($insert_lan);
				}
			else
			{
				while($row_lan = mysql_fetch_array($querylan))
				{
				$tem = $row_lan['Temp'];
				$humi = $row_lan['Humi'];
				$e = $row_lan['Power'];
				}
				$tem_avg = ($tem + $tempreture)/2;
				$humi_avg = ($humi + $humidity)/2;
				$e_avg = ($e + $energy)/2;
				$update_lan = "UPDATE data_avg SET Temp = '".$tem_avg."',Humi = '".$humi_avg."',Power='".$e_avg."' WHERE Sensor='".$mac."'";
				mysql_query($update_lan);
				}
			}
			
		else
		{
			$sqlbc = "SELECT * FROM data_avgbc WHERE Sensor='".$mac."' and Date='".date('d-m-Y')."'";
			$querybc = mysql_query($sqlbc);
			$rowbc = mysql_num_rows($querybc);
			if($rowbc == 0)
			{
				$insert_bc = "INSERT INTO data_avgbc VALUES('".$mac."','".$tempreture."','".$humidity."','".$energy."','".date('d-m-Y')."')";
				mysql_query($insert_bc);
				}
			else
			{
				while($row_bc = mysql_fetch_array($querybc))
				{
				$tem = $row_bc['Temp'];
				$humi = $row_bc['Humi'];
				$e = $row_bc['Power'];
				}
				$tem_avg = ($tem + $tempreture)/2;
				$humi_avg = ($humi + $humidity)/2;
				$e_avg = ($e + $energy)/2;
				$update_bc = "UPDATE data_avgbc SET Temp = '".$tem_avg."',Humi = '".$humi_avg."',Power='".$e_avg."' WHERE Sensor='".$mac."'";
				mysql_query($update_bc);
				}
			}
		//end
		
		
		$sql1 = "SELECT * FROM cdata WHERE mac='".$mac."'";
		$query1 = mysql_query($sql1);
		$row_no = mysql_num_rows($query1);
		if($row_no==0){//Neu chua ton tai dia chi mac thi kiem tra tiep xem da ton tai dia chi mang hay chua
			//$check = 0;
				$sql2 = "SELECT * FROM cdata WHERE netip = '".$network_ip."'";
				$query2 = mysql_query($sql2);
				$row_no2 = mysql_num_rows($query2);
				if($row_no2==0){//Neu ko ton tai dia chi mang
					//$checkip = 0;
					$my_query = "INSERT INTO cdata(mac,netip,nodecat,status,temp,humi,ener) VALUES ('".$mac."','".$network_ip."','sensor',1,'".$tempreture."','".$humidity."','".$energy."')";
					mysql_query ($my_query);
				}
				else {
					//$checkip=1;				
					$my_query = "UPDATE cdata SET mac = '".$mac."', nodecat = 'sensor', status=1, temp='".$tempreture."',humi='".$humidity."',ener='".$energy."' WHERE netip = '".$network_ip."'";
					mysql_query($my_query);
				}				
		}
		else{ //Neu da ton tai mac thi thay the
				//$check=1;
				$my_query = "UPDATE cdata SET netip='".$network_ip."',nodecat='sensor',status=1,temp='".$tempreture."',humi='".$humidity."',ener='".$energy."' WHERE mac = '".$mac."'";
				mysql_query($my_query);
		}
}
if(strpos($result,"RD:")!==false){//#RD:NNNNMMDDDDDDDDEEEE
	
	$mac = substr ($result,8,2);//MM
	$network_ip = substr ($result,4,4);//NNNN
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
	//Luu du lieu trung binh ve do thi
	if($mac[0] == '0')
		{
			$sqllan = "SELECT * FROM data_avg WHERE Sensor='".$mac."' and Date='".date('d-m-Y')."'";
			$querylan = mysql_query($sqllan);
			$rowlan = mysql_num_rows($querylan);
			if($rowlan == 0)
			{
				$insert_lan = "INSERT INTO data_avg VALUES('".$mac."','".$tempreture."','".$humidity."','".$energy."','".date('d-m-Y')."')";
				mysql_query($insert_lan);
				}
			else
			{
				while($row_lan = mysql_fetch_array($querylan))
				{
				$tem = $row_lan['Temp'];
				$humi = $row_lan['Humi'];
				$e = $row_lan['Power'];
				}
				$tem_avg = ($tem + $tempreture)/2;
				$humi_avg = ($humi + $humidity)/2;
				$e_avg = ($e + $energy)/2;
				$update_lan = "UPDATE data_avg SET Temp = '".$tem_avg."',Humi = '".$humi_avg."',Power='".$e_avg."' WHERE Sensor='".$mac."'";
				mysql_query($update_lan);
				}
			}
			
		else
		{
			$sqlbc = "SELECT * FROM data_avgbc WHERE Sensor='".$mac."' and Date='".date('d-m-Y')."'";
			$querybc = mysql_query($sqlbc);
			$rowbc = mysql_num_rows($querybc);
			if($rowbc == 0)
			{
				$insert_bc = "INSERT INTO data_avgbc VALUES('".$mac."','".$tempreture."','".$humidity."','".$energy."','".date('d-m-Y')."')";
				mysql_query($insert_bc);
				}
			else
			{
				while($row_bc = mysql_fetch_array($querybc))
				{
				$tem = $row_bc['Temp'];
				$humi = $row_bc['Humi'];
				$e = $row_bc['Power'];
				}
				$tem_avg = ($tem + $tempreture)/2;
				$humi_avg = ($humi + $humidity)/2;
				$e_avg = ($e + $energy)/2;
				//$insert_bc = "INSERT INTO data_avgbc VALUES('".$mac."','".$tem_avg."','".$humi_avg."','".$e_avg."','".date('d-m-Y')."')";
	$update_bc = "UPDATE data_avgbc SET Temp = '".$tem_avg."',Humi = '".$humi_avg."',Power='".$e_avg."' WHERE Sensor='".$mac."'";
				mysql_query($update_bc);
				}
			}
	//end
	
	//map
	$sql2 = "SELECT temp_humi FROM mapstt";
	$query2 = mysql_query($sql2);
	$row2 = mysql_fetch_array($query2);
	$temp_humi = $row2['temp_humi'];
	if (strcmp($mac, $temp_humi)==0) {
		$sql2 = "INSERT INTO bantin_map(bt) VALUES ('".$result."')";
		mysql_query($sql2);
	}
	
	
	//gateway		
	$my_query = "INSERT INTO data_sensor(mac,netip,cat,time,temp,humi,ener) VALUES ('".$mac."','".$network_ip."',2,now(),'".$tempreture."','".$humidity."','".$energy."')";
	mysql_query ($my_query);
	
	$sql1 = "SELECT * FROM cdata WHERE mac='".$mac."'";
	$query1 = mysql_query($sql1);
	$row_no = mysql_num_rows($query1);	
	if($row_no==0){//Neu chua ton tai dia chi mac thi kiem tra tiep xem da ton tai dia chi mang hay chua
		//$check = 0;
			$sql2 = "SELECT * FROM cdata WHERE netip = '".$network_ip."'";
			$query2 = mysql_query($sql2);
			$row_no2 = mysql_num_rows($query2);
			if($row_no2==0){//Neu ko ton tai dia chi mang
				//$checkip = 0;
				$my_query = "INSERT INTO cdata(mac,netip,nodecat,status,temp,humi,ener) VALUES ('".$mac."','".$network_ip."','sensor',1,'".$tempreture."','".$humidity."','".$energy."')";
				mysql_query ($my_query);
			}
			else {
				//$checkip=1;				
				$my_query = "UPDATE cdata SET mac = '".$mac."', nodecat = 'sensor', status=1, temp='".$tempreture."',humi='".$humidity."',ener='".$energy."' WHERE netip = '".$network_ip."'";
				mysql_query($my_query);
			}				
	}
	else{ //Neu da ton tai mac thi thay the
			//$check=1;
			$my_query = "UPDATE cdata SET netip='".$network_ip."',nodecat='sensor',status=1,temp='".$tempreture."',humi='".$humidity."',ener='".$energy."' WHERE mac = '".$mac."'";
			mysql_query($my_query);
	}
}

if(strpos($result,"VL:")!==false){//#VL:
		$mac = substr($result, 4,2);
		$sql3="SELECT * FROM cdata WHERE mac = '".$mac."'";
		$query3= mysql_query($sql3);
		$row_no3 = mysql_num_rows($query3);	
		if($row_no3==0){
			$check = 0;//Neu ko ton tai node co dia chi mang nay trong CSDL
			//$sql="INSERT INTO data_sensor() VALUES ";
			//$sql="";
		}
		else {//da ton tai dia chi mac
			$check=1;
			$sql="UPDATE cdata SET netip='".$network_ip."',status=0";
			mysql_query($sql);
			$sql="INSERT INTO data_sensor(mac,netip,cat) VALUES ('".$mac."','".$network_ip."',4)";
		}
}

if(strpos($result,"OK:")!==false){//#OK:NNNNMMSS		
		$network_ip = substr($result, 4,4);
		$stt_16 = substr($result, 10,2);	
		$stt_10 = base_convert($stt_16, 16, 10);
		$mac = substr($result,8,2);
		
		if ($mac == '00'){
			//map
			$sql2 = "SELECT van_no FROM mapstt";
			$query2 = mysql_query($sql2);
			$row2 = mysql_fetch_array($query2);
			$van_no = $row2['van_no'];
			if ($van_no!='0') {
				$sql2 = "INSERT INTO bantin_map(bt) VALUES ('".$result."')";
				mysql_query($sql2);
			}
			//gateway
			if ($stt_10 > 128){
				$val = $stt_10 - 128;
				if ($val == 15){
					$my_query = "INSERT INTO data_val(val,actor_mac,actor_netip,status,time) VALUES ('".$val."','".$mac."','".$network_ip."',1,now())";
					mysql_query ($my_query);
					$my_query1 = "UPDATE val_status SET status = 1 WHERE 1";
					mysql_query ($my_query1);
				}
				else {
					$my_query = "INSERT INTO data_val(val,actor_mac,actor_netip,status,time) VALUES ('".$val."','".$mac."','".$network_ip."',1,now())";
					mysql_query ($my_query);
					$my_query1 = "UPDATE val_status SET status = 1 WHERE val='".$val."'";
					mysql_query ($my_query1);
				}
			}
			if (64 < $stt_10 && $stt_10 < 128){
				
			}
			if ($stt_10 < 64){
				$val = $stt_10;
				if ($val == 15){
						$my_query = "INSERT INTO data_val(val,actor_mac,actor_netip,status,time) VALUES ('".$val."','".$mac."','".$network_ip."',0,now())";
						mysql_query ($my_query);
						$my_query1 = "UPDATE val_status SET status = 0 WHERE 1";
						mysql_query ($my_query1);
					}
					else {
						$my_query = "INSERT INTO data_val(val,actor_mac,actor_netip,status,time) VALUES ('".$val."','".$mac."','".$network_ip."',0,now())";
						mysql_query ($my_query);
						$my_query1 = "UPDATE val_status SET status = 0 WHERE val='".$val."'";
						mysql_query ($my_query1);
					}
				}
		}
		elseif ($mac == "B1"){
			//map
			$sql2 = "SELECT reset FROM mapstt";
			$query2 = mysql_query($sql2);
			$row2 = mysql_fetch_array($query2);
			$reset = $row2['reset'];
			if ($reset==1) {
				$sql2 = "INSERT INTO bantin_map(bt) VALUES ('".$result."')";
				mysql_query($sql2);
			}
			//gateway
			$val = $stt_10 - 128;
			$my_query = "INSERT INTO data_val(val,actor_mac,actor_netip,status,time) VALUES ('".$val."','".$mac."','".$network_ip."',1,now())";
			mysql_query ($my_query);
			$my_query1 = "UPDATE bc_status SET level = '".$val."', netip='".$network_ip."' ";
			mysql_query ($my_query1);
			
		}
}

if(strpos($result,"#SN") !== false){//#SN:NNNNMMSS
		$mac = substr ($result,8,2);//MM
		$network_ip = substr ($result,4,4);//NNNN
	    $state_node = substr($result,10,2);
		    
	    if($state_node == "02"){//co chay
	    	//$status = "fire";
	    	$my_query = "INSERT INTO data_sensor(mac,netip,time,cat) VALUES ('".$mac."','".$network_ip."',now(),32)";
			mysql_query ($my_query);
		}
		elseif($state_node == "03"){//co phat hien xam nhap
	    	//$status = "intrusion";
	    	$my_query = "INSERT INTO data_sensor(mac,netip,time,cat) VALUES ('".$mac."','".$network_ip."',now(),33)";
			mysql_query ($my_query);
	    }
	    elseif($state_node == "04"){//het nang luong
	     	//$status = "energy";
	     	$my_query = "INSERT INTO data_sensor(mac,netip,time,cat) VALUES ('".$mac."','".$network_ip."',now(),34)";
			mysql_query ($my_query);
	    }
}

if(strpos($result,"RT") !== false){
	$result = substr($result, 4);
	$a = substr($result, 4);
	$len = strlen($a);
	$b = substr($a, 0, $len-1); 
	mysql_query("INSERT INTO road(road) VALUES '".$b."'");
	//$src = substr($b, 0,4);
	//$des = substr($b,$len-5,4);
	//$q1 = mysql_query("SELECT mac FROM node WHERE networkip = '".$src."'");
	//$r1 = mysql_fetch_array($q1);
	//$q2 = mysql_query("SELECT mac FROM node WHERE networkip = '".$des."'");
	//$r2 = mysql_fetch_array($q2);	
	//mysql_query("UPDATE node(src,des,bet) SET ('".$r1['mac']."','".$r2['mac']."','".$r."')");
}
}

mysql_close($connect);
?>

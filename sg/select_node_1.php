<?php
require 'dbconnect.php';

echo "<select id='node1'><option value=''>---Chọn nút mạng---</option>";

if ($_GET['id_malenh'] == "000"){
	$sql1 = "SELECT * FROM cdata WHERE nodecat='sensor' AND status=1";
	$query1 = mysql_query($sql1);
    while($row1 = mysql_fetch_array($query1)){
		$mac1 = $row1['mac'];
		if ('29' < $mac1 && $ $mac1< '40') {
			echo "<option value='".$mac1."' >Node ". $mac1."</option>";
		}		
	}
}
elseif($_GET['id_malenh'] == "malenh"){

}
else{
	$sql2 = "SELECT * FROM cdata WHERE nodecat='actor' AND status=1";
	$query2 = mysql_query($sql2);
    while($row2=mysql_fetch_array($query2)){
	    $mac2 = $row2['mac'];
	    if ($mac2 == 'B1') {
	    	echo "<option value='".$mac2."'>Đồng hồ báo cháy</option>";
	    }
	}
}    
     
echo "</select>";
$connect=null;
//mysql_close($connect);
?>


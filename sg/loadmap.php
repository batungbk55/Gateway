<?php
session_start();
require 'dbconnect.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="map.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src = "jquery.js"></script>
<script type="text/javascript" src = "map.js"></script>
<title>Untitled Document</title>

<script type="text/javascript">
</script>
</head>

<body>
         <center>
		 
	      <input   type="radio" value="Vườn Lan"  name="map" id="vuonlan" checked="true">&nbsp;Vườn lan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  <input  type="radio" value="Báo cháy" name="map"  id="baochay">&nbsp;Báo cháy</br>
		  </center>
<div id="mymap"><img alt="Map" src="vuonlan.png" /></div>
<?php 
$sql3 = "SELECT * FROM node_coor WHERE 1";
$query3 = mysql_query($sql3);
while ($row3 = mysql_fetch_array($query3)){
	$mac = $row3['mac'];
	$px = $row3['px'];
	$py = $row3['py'];
	if ($row3['nodecat']=="actor"){
		?>
		<div class="icactor" id="<?php echo $mac?>" style="position: absolute;left: <?php echo $py ?>px;top: <?php echo $px ?>px; z-index:1; cursor: pointer;">
			<img  src="images/green.png" style="position: absolute;left: 0px;top: 0px; z-index: -1000"/>
			<b><?php echo $mac?></b>
		</div>	
		<?php 
	}
	else {
		$sql5 = "SELECT * FROM cdata WHERE mac = '".$mac."'";
        $query5 = mysql_query($sql5);
		$row5 = mysql_fetch_array($query5);
		?>
		<div class="icsensor" id="<?php echo $mac;?>" style="position: absolute;left: <?php echo $py ?>px;top: <?php echo $px ?>px; z-index:1; cursor: pointer;">
        <?php
		$status = $row5['status'];
		if($status == 0)
		{
        ?>
			<img src="images/violet.png" style="position: absolute;left: 0px;top: 0px; z-index: -1000"/>
			<b><?php 
		}
		else
		{ ?>
        	<img src="images/red.png" style="position: absolute;left: 0px;top: 0px; z-index: -1000"/>
        <?php
		}
		echo $mac?></b>
		</div> 
		<?php
	}
}
$sql4 = "SELECT * FROM val_coordinates WHERE 1";
$query4 = mysql_query($sql4);
while ($row4 = mysql_fetch_array($query4)){
	$id = $row4['val'];
	$px = $row4['px'];
	$py = $row4['py'];
	$sql6 = "SELECT status FROM val_status WHERE val = '".$id."'";
    $query6 = mysql_query($sql6);
	$row6 = mysql_fetch_array($query6);
	?>
	<div class="icval" id="<?php echo $id;?>" style="position: absolute; left: <?php echo $py ?>px;top: <?php echo $px ?>px; z-index:1; cursor: pointer;">
    <?php
	if($row6['status'] == 0)
	{
    ?>      
		<img src="images/grey.png" style="position: absolute;left:0px;top: 0px; z-index: -1"/>
		<?php
	}
	else
	{?>
		<img src="images/yellow.png" style="position: absolute;left:0px;top: 0px; z-index: -1"/>
	<?php }?>
	<b style="color: #000">V <?php echo $row4['val'] ?></b>
	</div>
	<?php
}

mysql_close($connect);
?>
</body>
</html>
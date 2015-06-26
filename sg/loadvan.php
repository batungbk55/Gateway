<?php
session_start();
require 'dbconnect.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
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
		<img src="images/grey.png" style="position: absolute;left:0px;top: 0px; z-index: 2"/>
		<?php
	}
	else
	{?>
		<img src="images/yellow.png" style="position: absolute;left:0px;top: 0px; z-index: 2"/>
	<?php }?>
	<b style="color: #000">V <?php echo $row4['val'] ?></b>
	</div>
	<?php
}
?>
</body>
</html>
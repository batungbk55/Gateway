<?php
require 'dbconnect.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2//EN">

<html>
<head>
    <title></title>
</head>
	<link href="bootstrap.css" rel="stylesheet" type="text/css" />

<body>
<form name="m" method="POST">
<h1>TÙY CHỈNH TRỰC CANH</h1>
link video1 <input type="text" name="link1" class="input-medium search-query span4" />&nbsp;&nbsp;
<input type="submit" value=" OK" name="bnt1" class="btn btn-success" />
<br />
<br />
<br />
link video2 <input type="text" name="link2" class="input-medium search-query span4" />&nbsp;&nbsp;
<input type="submit" value="OK" name="bnt2" class="btn btn-success" />
<br />
<br />
<br />
HOST:<input type="text" name="host" class="input-medium search-query" /> &nbsp;PORT:<input type="text" name="port" class="input-medium search-query" />&nbsp;&nbsp; <input type="submit" name="bnt3" value="OK" class="btn btn-success" />
<br /><br />
Trực Canh :
<input type="submit" name="chon1" value="Link 1" class="btn btn-danger"  />&nbsp;&nbsp; <input type="submit" name="chon2" value="Link 2" class="btn btn-danger"  />
<?php
if(isset($_POST['bnt1']))
{
      $url=$_POST['link1'];
	  if(!empty($url))
	  {
      	mysql_query("UPDATE link SET url = '{$url}' WHERE id = '1'");
      	echo("Link 1 Đã được cập nhật");
		  
	  }
}
if(isset($_POST['bnt2']))
{
      $url2=$_POST['link2'];
	  if($url2 != "")
	  {
      	mysql_query("UPDATE link SET url = '{$url2}' WHERE id = '2'");
      	echo("Link 2 Đã được cập nhật");  
	  }
    
}
if(isset($_POST['bnt3']))
{
    $host=$_POST['host'];
    $port=$_POST['port'];
	if($host != "" && $port != "")
	{
      mysql_query("UPDATE socket SET ip = '{$host}',port= '{$port}' WHERE id = '1'") or die("chet");
      echo("socket Đã được cập nhật");  
	}
    
}
if(isset($_POST['chon1']))
{
  mysql_query("UPDATE link SET url = '1' WHERE id = '4'");
  echo "<br/>"."ĐÃ CHỌN LINK 1 PHÁT TÍN HIỆU TRỰC CANH";   
    }
    if(isset($_POST['chon2']))
{
  mysql_query("UPDATE link SET url = '2' WHERE id = '4'");
  echo "<br/>"."ĐÃ CHỌN LINK 2 PHÁT TÍN HIỆU TRỰC CANH";   
    }
    
	mysqli_close($connect);
 ?>
 

</form>
</body>
</html>

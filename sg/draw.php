<?php 
session_start();
require 'dbconnect.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	 <head>
	 <title>Vẽ đồ thị</title>
	 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	 <link href="style.css" rel="stylesheet" type="text/css" />
	 <style>
	 
#left_select{
	background-color:#6CF;
	width: 500px;
	float:left;
	}
#right_select{
	background-color:#0FF;
	float:right;
	width: 480px;
	}
table {
	text-align: center;
	width: 500px;
}
td {
	height: 35px;
}
table .mul {
	display: none;
}
h3{
	text-align:center;
	}
</style>
	 <script type="text/javascript" src="https://www.google.com/jsapi"></script>
	 <script type="text/javascript" src = "jquery.js"></script>
	 <script type="text/javascript">
$(document).ready(function(){
	 var isLogin='<?php if(isset($_SESSION['login_status'])){if($_SESSION['login_status']=='yes')echo 'yes';else echo 'no';}else    echo 'no';?>';
	var isLevel='<?php if(isset($_SESSION['level'])){echo $_SESSION['level'];}?>';
	if(isLogin=='yes'){			 
		//var content = "<table><tr><td><a href='signout.php'>Ðăng xuất</a></td><td></td></tr></table>";
		var content = "<table><tr><td><i>Xin chào bạn </i><b> [ </b><u id='log'><?php if(isset($_SESSION['login_status'])){ echo $_SESSION['user'];} ?></u><b> ] </b></td><td></td></tr></table>";
		$('#ttlogin').append(content);
	}
	else{
		var content = "<table><tr><td> <a href='register.php'>Đăng ký</a>&nbsp&nbsp&nbsp&nbsp<a href='login.php'>Đăng nhập</a></td></td></tr></table>";
		$('#ttlogin').append(content);
	}
	//*******************************
	$("#log").click(function(e) {
		$("#menulogin").css('left',e.pageX - 150);
		$("#menulogin").css('top',e.pageY + 10);
        $("#menulogin").show();
    });
	$(document).bind("mouseup",function(e){
		$("#menulogin").hide();
		});
	$("input[name='rdngayve']").change(function(e) {
        if($(this).val() == 'oneday')
		{
			$(".mul").hide();
			$("#chonngay").show();
			}
		else
		{
			$("#chonngay").hide();
			$(".mul").show();
			if($("input[name='rdKhuVuc']:checked").val() == "Lan")
			{
				$("#sensorLan").show();
				$("#sensorBC").hide();
				}
			else
			{
				$("#sensorLan").hide();
				$("#sensorBC").show();
				}
			}
    });
	
		$("input[name='rdKhuVuc']").change(function(e) {
		if($("input[name='rdngayve']:checked").val() == 'mulday')
        if($(this).val() == 'Lan')
		{
				$("#sensorLan").show();
				$("#sensorBC").hide();
				}
			else
			{
					$("#sensorLan").hide();
					$("#sensorBC").show();
			}
    });
});
	 </script>
	 </head>

	 <body>
     <div id="wrap">
       <div id="top">
         <div id="ttlogin"></div>
         <br />
         <div id="banner">
           <embed src="http://bannertudong.com/uploads/system/flash/20110503/view.swf" quality="high" bgcolor="#ffffff" wmode="transparent" menu="false" width="1000" height="250" name="Editor" align="middle" allowScriptAccess="always" flashVars='xml=http://bannertudong.com/uploads/user/20130904/19948/19948.xml?0' type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
         </div>
         <div id = "menulogin" class="ctmenu">
           <table>
             <tr>
               <td class="menuitem" id = "tt"><a href="">Chỉnh sửa thông tin</a></td>
             </tr>
             <tr>
               <td class="menuitem" id = "pass"><a href="change_pass.php"> Đổi mật khẩu </a></td>
             </tr>
             <tr>
               <td class="menuitem" id = "out"><a href="signout.php">Đăng xuất</a></td>
             </tr>
           </table>
         </div>
         <div id="menu">
           <ul>
             <li ><a href="index.php"><span>Bo nhúng</span></a></li>
             <li><a href="mapvl.php"><span>Bản đồ</span></a></li>
             <li class="active"><a href="draw.php"><span>Vẽ đồ thị</span></a></li>
             <li><a href="video.php"><span>Video</span></a></li>
             <li><a href="camera.php"><span>Camera</span></a></li>
             <li ><a href="truccanh.php"><span>Trực canh</span></a></li>
             <?php if(isset($_SESSION['login_status'])) 
					if($_SESSION['login_status']=='yes') {
						if($_SESSION['level'] == 1){
			?>
             <li><a href="manage.php"><span>Quản lý</span></a></li>
             <?php }}?>
           </ul>
         </div>
       </div>
       <div id="contentwrap">
         <div id="mainpage">
           <div id="left_select"> 
           <h3>Vẽ đồ thị dữ liệu sensor</h3>
           <br />
           <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
             <table>
               <tr id = "loaidothi">
                 <td><b>Thời gian vẽ: </b></td >
                 <td> Một ngày
                   <input type="radio" name="rdngayve" value="oneday" checked="checked"/></td>
                 <td> Nhiều ngày
                   <input type="radio" name="rdngayve" value="mulday" /></td>
               </tr>
               <tr id = "khuvuc">
                 <td><b>Khu vực: </b></td>
                 <td> Vườn lan
                   <input type="radio" name="rdKhuVuc" value="Lan" checked="checked"/></td>
                 <td> Cảnh báo cháy
                   <input type="radio" name="rdKhuVuc" value="baochay"/></td>
               </tr>
               <tr id = "chonngay">
                 <td><b>Chọn ngày: </b></td>
                 <td><input type="date" name="DrawDay"/></td>
                 <td></td>
               </tr>
               <tr id = "chonthang" class="mul">
                 <td><b>Chọn Tháng: </b></td>
                 <td><input type="month" name="monthDraw"/></td>
                 <td></td>
               </tr>
               <tr id = "khoangngay" class="mul">
                 <td></td>
                 <td> Từ ngày:
                   <input type="text" name="txtbegin" style="width:50px;" /></td>
                 <td> Đến ngày:
                   <input type="text" name="txtend" style="width:50px;"/></td>
               </tr>
               <tr id="sensorLan" class="mul">
                 <td><b>Chọn Sensor:</b></td>
                 <td><select id="selec" name="macSensorLan">
                     <option>---Chọn Sensor---</option>
                     <option value="01">Sensor 01</option>
                     <option value="02">Sensor 02</option>
                     <option value="03">Sensor 03</option>
                     <option value="04">Sensor 04</option>
                     <option value="05">Sensor 05</option>
                     <option value="06">Sensor 06</option>
                     <option value="07">Sensor 07</option>
                     <option value="08">Sensor 08</option>
                     <option value="09">Sensor 09</option>
                     <option value="0A">Sensor 0A</option>
                     <option value="0B">Sensor 0B</option>
                     <option value="0C">Sensor 0C</option>
                   </select></td>
                 <td></td>
               </tr>
               <tr id="sensorBC" class="mul">
                 <td><b>Chọn Sensor:</b></td>
                 <td><select id="selec" name="macSensorBC">
                     <option>---Chọn Sensor---</option>
                     <option value="31">Sensor 31</option>
                     <option value="32">Sensor 32</option>
                     <option value="33">Sensor 33</option>
                     <option value="34">Sensor 34</option>
                     <option value="35">Sensor 35</option>
                     <option value="36">Sensor 36</option>
                     <option value="37">Sensor 37</option>
                     <option value="38">Sensor 38</option>
                     <option value="39">Sensor 39</option>
                   </select></td>
                 <td></td>
               </tr>
               <tr>
                 <td></td>
                 <td><input type="submit" name="btDraw" value="Vẽ Đồ thị"/></td>
                 <td></td>
               </tr>
             </table>
           </form>
           </div>
           <div id="right_select">
           <h3>Vẽ đồ thị thời gian tưới actor khu vườn lan</h3><br /> 
           <form action="" method="post">
           <table style="width:480px; text-align:center;">
           	<tr>
            	<td><b>Thời gian vẽ:</b></td>
                <td>Một ngày <input type="radio" name="rdngayveactor" checked="checked" value="motngay"></td>
                <td>Nhiều ngày <input type="radio" name="rdngayveactor" value="nhieungay"> </td>
            <tr>
            <tr>
            	<td><b>Chọn ngày;</b></td>
                <td><input type="date" name="dtActor" /></td>
                <td></td>
            </tr>
            <tr>
            	<td><b>Chọn tháng: </b></td>
                <td><input type="month" name="monthActor" /><td>
                <td></td>
            </tr>
            <tr style="text-align:left;">
            	<td></td>
                <td style="text-align:right;">Từ ngày <input type="text" name="txtTungayActor" style="width:50px;"/></td>
                <td style="text-align:left;">Đến ngày <input type="text" name="txtDenngayActor" style="width:50px;" /></td>
            </tr>
            <tr>
            	<td><b>Chọn van tưới: </b></td>
                <td>
                	<select name="vanActor">
                    <option value="0">-----Chọn van tưới-----</option>
                    <?php
					for($i = 1; $i < 7; $i++)
					{
						echo "<option value='".$i."'> Van ".$i."</option>";
						}
                    ?>
                    </select>
                </td>
            </tr>
            <tr>
            	<td></td>
                <td><input type="submit" value="Vẽ đồ thị" name="btActor" /></td>
                <td></td>
            </tr>
           </table>
           </form>
           </div>
           <div style="clear:both"></div>
           <?php
		 function getDataSensorR($date,$sensor,$val)
		  {
			  $result = 0;
			  $sql = "SELECT * FROM data_avg WHERE Date='".$date."' and Sensor='".$sensor."'";
			  $query = mysql_query($sql);
			  $row = mysql_fetch_array($query);
			  if($row != 0)
			  {
				  $result = $row[$val];
				  }
			  return $result;
			  }
		 function getDataSensorRBC($date,$sensor,$val)
		  {
			  $result = 0;
			  $sql = "SELECT * FROM data_avgbc WHERE Date='".$date."' and Sensor='".$sensor."'";
			  $query = mysql_query($sql);
			  $row = mysql_fetch_array($query);
			  if($row != 0)
			  {
				  $result = $row[$val];
				  }
			  return $result;
			  }
          if(isset($_POST['btDraw']))
		  {
			  //Ve bieu do 1 ngay
			  if($_POST['rdngayve'] == 'oneday')
			  {
			  $date_ = $_POST['DrawDay'];
              $ngay1= substr($date_,8,2);
              $thang1= substr($date_,5,2);
              $nam1= substr($date_,0,4);
              $ngaythangnam=$ngay1."-".$thang1."-".$nam1;
			  //ve bieu do 1 ngay khu bao chay
			  if ($_POST['rdKhuVuc']== 'Lan')
			  {
		  ?>
           <script language="javascript">
          //Ve do thi 
				google.load("visualization", "1", {packages:["corechart"]});
      			google.setOnLoadCallback(drawChart);
      			function drawChart() {
        		var data = google.visualization.arrayToDataTable([
          		['Sensor','Nhiệt độ (ºC)','Độ ẩm (%)','Năng lượng (V)'],
          		<?php
				for($i = 1; $i < 13; $i++)
				{
					$mac = dechex($i);
					$mac = '0'.strtoupper($mac);
					echo "['".$mac."',".getDataSensorR($ngaythangnam,$mac,"Temp").",".getDataSensorR($ngaythangnam,$mac,"Humi").",".getDataSensorR($ngaythangnam,$mac,"Power")."],";
					}
				?>
        		]);
        var options = {
          title: 'Dữ liệu sensor vườn lan ngày <?php echo $ngaythangnam;?>',
          hAxis: {title: 'Sensor vườn lan', titleTextStyle: {color: 'red'}}
        };
        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
	  </script>
           <div id="chart_div" style="width:auto; height: 600px;"></div>
           <?php
			  }
			  //Ket thuc ve bieu do lan 1 ngay
			  
			  //ve bieu do 1 ngay khu bao chay
			  else
			  {
		  ?>
           <script language="javascript">
          //Ve do thi 
				google.load("visualization", "1", {packages:["corechart"]});
      			google.setOnLoadCallback(drawChart);
      			function drawChart() {
        		var data = google.visualization.arrayToDataTable([
          		['Sensor','Nhiệt độ (ºC)','Độ ẩm (%)','Năng lượng (V)'],
				<?php
				for($i = 31; $i < 40; $i++)
				{
					echo "['".$i."',".getDataSensorRBC($ngaythangnam,$i,"Temp").",".getDataSensorRBC($ngaythangnam,$i,"Humi").",".getDataSensorRBC($ngaythangnam,$i,"Power")."],";
					}
				?>
        		]);
        var options = {
          title: 'Dữ liệu sensor khu báo cháy ngày <?php echo $ngaythangnam;?>',
          hAxis: {title: 'Sensor khu báo cháy', titleTextStyle: {color: 'red'}}
        };
        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
	  </script>
           <div id="chart_div" style="width:auto; height: 600px;"></div>
           <?php
			  }
			  //Ket thuc ve bieu bao chay 1 ngay
			  }
			  //Ve nhieu ngay
			  else
			  {
				  $month = substr($_POST['monthDraw'],5,2);
				  $year = substr($_POST['monthDraw'],0,4);
				  $begin = $_POST['txtbegin'];
				  $end = $_POST['txtend'];
				  
				  //Ve nhieu ngay khu vuon lan
				  if ($_POST['rdKhuVuc']== 'Lan')
			  	  {
				  $sensor = $_POST['macSensorLan'];
				  ?>
           <script language="javascript">
          //Ve do thi 
				google.load("visualization", "1", {packages:["corechart"]});
      			google.setOnLoadCallback(drawChart);
      			function drawChart() {
        		var data = google.visualization.arrayToDataTable([
          		['Sensor','Nhiệt độ (ºC)','Độ ẩm (%)','Năng lượng (V)'],
				<?php
				for($i = $begin;$i <= $end;$i++)
				{
					$ngay = $i."-".$month."-".$year;
					echo "['".$i."',".getDataSensorR($ngay,$sensor,"Temp").",".getDataSensorR($ngay,$sensor,"Humi").",".getDataSensorR($ngay,$sensor,"Power")."],";
					}
				?>
        		]);

        var options = {
          title: 'Dữ liệu sensor <?php echo $sensor; ?> từ ngày <?php echo $begin; ?> đến ngày <?php echo $end; ?> tháng <?php echo $month; ?> năm <?php echo $year; ?>',
          hAxis: {title: 'Sensor vườn lan', titleTextStyle: {color: 'red'}}
        };
        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
	  </script>
           <div id="chart_div" style="width:auto; height: 600px;"></div>
           <?php
				  }
				  //Ve nhieu ngay khu bao chay
				  else
				  {
					  $sensor = $_POST['macSensorBC'];
				  ?>
           <script language="javascript">
          //Ve do thi 
				google.load("visualization", "1", {packages:["corechart"]});
      			google.setOnLoadCallback(drawChart);
      			function drawChart() {
        		var data = google.visualization.arrayToDataTable([
          		['Sensor','Nhiệt độ (ºC)','Độ ẩm (%)','Năng lượng (V)'],
				<?php
				for($i = $begin;$i <= $end;$i++)
				{
					$ngay = $i."-".$month."-".$year;
					echo "['".$i."',".getDataSensorRBC($ngay,$sensor,"Temp").",".getDataSensorRBC($ngay,$sensor,"Humi").",".getDataSensorRBC($ngay,$sensor,"Power")."],";
					}
				?>
        		]);

        var options = {
          title: 'Dữ liệu sensor <?php echo $sensor; ?> từ ngày <?php echo $begin; ?> đến ngày <?php echo $end; ?> tháng <?php echo $month; ?> năm <?php echo $year; ?>',
          hAxis: {title: 'Sensor vườn lan', titleTextStyle: {color: 'red'}}
        };
        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
	  </script>
           <div id="chart_div" style="width:auto; height: 600px;"></div>
           <?php
					  
					  }
				  }
		 } 
		 ?>
           
         </div>
         <div id="bottom">
           <div id="footer">
             <div id="fl_right">Copyright by <a href="#">Lab 411</a></div>
             <div class="clear"></div>
           </div>
         </div>
       </div>
       <div id="contentbtm"></div>
     </div>
</body>
</html>
<?php
require 'dbconnect.php';
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Manage</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="manage.css" rel="stylesheet" type="text/css" />
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
	$("#save_ip_webcam").click(function(e) {
        var ip_bonhung_new = $("#ip_bonhung").val();
		var ip_server_new = $("#ip_server").val();
		var pattern = /^[0-9]{3}.[0-9]{3}.[0-9]{0,3}.[0-9]{0,3}$/g;
		var pattern1 = /^[0-9]{3}.[0-9]{3}.[0-9]{0,3}.[0-9]{0,3}$/g;
		if(ip_bonhung_new.length == 0 || ip_server_new.length == 0)
		{
			alert("Chưa nhập đầy đủ IP");
			}
		else
		{
			var rs1 = pattern.test(ip_bonhung_new);
		    var rs2 = pattern1.test(ip_server_new);
			if(rs1 == 0 || rs2 == 0)
			{
				alert("Địa chỉ IP nhập vào không đúng");
				}
			else
			{
				$.ajax({
						url:'save_ip_webcam.php',
						type:'POST',
						data:"ip_bo="+ip_bonhung_new+"&ip_server="+ip_server_new,
						success:function(result)
						{
							alert(result);
						}
					});
			}
		}
    });
	$("#save_ip_camera").click(function(e) {
        var ip_camera_new = $("#ip_camera").val();
	//	alert($("#ip_camera").val());
		if(ip_camera_new.length == 0)
		{
			alert("Chưa nhập địa chỉ IP");
			}
		else
		{
			var pattern = /^[0-9]{3}.[0-9]{3}.[0-9]{0,3}.[0-9]{0,3}$/g;
			var re = pattern.test(ip_camera_new);
			if(re == 0)
			{
				alert("Địa chỉ không chính xác");
				}
			else
			{
				$.ajax({
					url: 'save_ip_camera.php',
					type:'POST',
					data:'ip='+ip_camera_new,
					success:function(result)
					{
						alert(result);
						}
					});
				}
			}
    });
	
	$("#txttruccanh").click(function(e) {
        $("#maintruccanh").slideToggle("fast");
    });
	$("#txtsetup").click(function(e) {
        $("#setup").slideToggle("fast");
    });
	$("#btnsetup").click(function(e) {
        var temp = $("#txttemp").val();
		var humi = $("#txthumi").val();
		var index = document.getElementById("van").selectedIndex;
		var sovan = document.getElementById("van").options;
		if(temp == "" || humi == "" || index == 0)
		{
			alert("Chưa nhập đủ thông tin");
			}
		else
		{
			var patt1 = /^[0-9]{2}$/g;
			var patt2 = /^[0-9]{2}$/ 
			var result1 = patt1.test(temp);
			var result2 = patt2.test(humi);
			var van = sovan[index].value;
			if(result1 == 0 || result2 == 0)
			{
				
				alert("Dữ liệu nhập không chính xác");
				}
			else
			{
				$.ajax({
					url: "saveSetupData.php",
					type: "POST",
					data: "van="+van+"&temp="+temp+"&humi="+humi,
					success: function(res)
					{
						alert("Đã gửi dữ liệu");
						}
					});
				}
			}
    });
});
        function chay()
        {
            parent.mouse.location="chayserver.php";
        }
</script>
</head>

<body>
<div id="wrap">
  	<div id="top">
        <div id="ttlogin"></div>
        <div id="banner">
	    <embed src="http://bannertudong.com/uploads/system/flash/20110503/view.swf" quality="high" bgcolor="#ffffff" wmode="transparent" menu="false" width="1000" height="250" name="Editor" align="middle" allowScriptAccess="always" flashVars='xml=http://bannertudong.com/uploads/user/20130904/19948/19948.xml?0' type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
        </div>    
        <div id = "menulogin" class="ctmenu">
           <table>
	           <tr><td class="menuitem" id = "tt"><a href="">Chỉnh sửa thông tin</a></td></tr>
	           <tr><td class="menuitem" id = "pass"><a href="change_pass.php"> Đổi mật khẩu </a></td></tr>
               <tr><td class="menuitem" id = "out"> <a href="signout.php">Đăng xuất</a></td></tr>
           </table>
        </div>    
  	</div>
  
	<div id="menu">
		<ul>			
	      	<li><a href="index.php"><span>Bo nhúng</span></a></li>
	      	<li><a href="mapvl.php"><span>Bản đồ</span></a></li>
	      	<li><a href="video.php"><span>Video</span></a></li>
	      	<li><a href="camera.php"><span>Camera</span></a></li>	      
            <li><a href="truccanh.php"><span>Trực canh</span></a></li>
            <li class="active"><a href="manage.php"><span>Quản lý</span></a></li>
	   	</ul>
	</div>
	
  	<div id="contentwrap">
    <div id="mainpage">
    <form name="m" method="POST">
		<h2 style="text-align:center" id="txttruccanh" class="slide"> TÙY CHỈNH HỆ THỐNG  TRỰC CANH</h2> <br />
        <div id="maintruccanh">
        
        <div id="webcam" class="divTruccanh">
		&nbsp;<strong>WEBCAM  :</strong>
		<br /> <br />
		IP Bo Nhúng :&nbsp;<input type="text" name="ip_bonhung" id="ip_bonhung"/>
		<br /><br /><br />
		IP Server &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<input type="text" name="ip_server" id="ip_server"/>
		<br /><br />
		<input type="button" name="save_ip_webcam" id="save_ip_webcam" class="save" value="Thay Đổi" />
		<br /><br />
        </div>
        
        <div id="camera" class="divTruccanh">
		&nbsp;<strong>IPCAMERA:</strong>
		<br /><br /> <br />
 		Ip camera &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<input  type="text" id="ip_camera"/><br /><br />
		<input type="button" name="save_ip_camera" id="save_ip_camera" class="save" value="Thay Đổi" />
         </div> 
         
         <div style="clear:both"></div>
         
         <div id="truccanh" class="divTruccanh">
		<h2>Chọn luồng xem trực canh: </h2>     <br />
		<input type="submit" name="chon1" value="IP CAMERA"  id="ipcamera" class="bttruccanh"  />&nbsp;&nbsp; <input type="submit" name="chon2" value="WEBCAM" class="bttruccanh" id="btwebcam" />
		<br />
       
		<?php

		if(isset($_POST['chon1']))
		{
  			mysql_query("UPDATE link SET url = '1' WHERE id = '4'");
  			echo "<br/>"."ĐÃ CHỌN IP CAMERA PHÁT TÍN HIỆU TRỰC CANH";   
    	}
    	if(isset($_POST['chon2']))
		{
  			mysql_query("UPDATE link SET url = '2' WHERE id = '4'");
  			echo "<br/>"."ĐÃ CHỌN WEBCAM PHÁT TÍN HIỆU TRỰC CANH";   
    	}
    
 		?>
         </div>
         
		<div id="mangngoai" class="divTruccanh">
		&nbsp;<h2>Cài đặt địa chỉ IP ra mạng internet</h2> 
		<br />
		IP Router :<input type="text" name="mangngoai" /> &nbsp;&nbsp;<input type="submit" value="Cài đặt" name="ip_router" class = "bttruccanh"/>
		<br />
		<?php
		if(isset($_POST['ip_router']))
		{
    		$tg=$_POST['mangngoai'];
			$pattern = "/^[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}$/";
			if(preg_match($pattern,$tg) == 1)
			{
    			mysql_query("UPDATE socket SET ip = '{$tg}' WHERE id = '1'");
    			$ipmn="http://".$tg.":12345/video2.mjpg";
    			$wcmn="http://".$tg.":1234";
    			mysql_query("UPDATE link SET url = '{$ipmn}' WHERE id = '1'") or die("không được");
    			mysql_query("UPDATE link SET url = '{$wcmn}' WHERE id = '2'")or die("không được");
    			echo"Cài đặt thành Công !";
			}
			else
			{
				echo "<script> alert('Nhap dia chi IP khong chinh xac');</script>";
				}
		}
 		?>
		</div>
        
         <div id="stream" class="divTruccanh">
         <h2>Lấy luồng video</h2> <br />
		<input type="button"  value="Chạy SerVer" onclick="chay()" class="bttruccanh" /><br />
		<br />
		<iframe src="#" scrolling="no" height="30" width="550" frameborder="0" name="mouse"></iframe>
        </div>
        
        </div>
        <br />
        <div id="setupbonhung">
        <h2 align="center" class="slide" id="txtsetup">CÀI ĐẶT NGƯỠNG NHIỆT ĐỘ TỪ WEB</h2>
        	<div id="setup">
        	<b>Chọn van tưới: </b>
        	<select id = "van" class ="val">
					<option value = "0">----Chọn van tưới----</option>
					<option value="1">Van số 1</option> 
					<option value="2">Van số 2</option> 
		            <option value="3">Van số 3</option> 
		            <option value="4">Van số 4</option> 
					<option value="5">Van số 5</option> 
					<option value="6">Van số 6</option>  
			    </select><br />
             <b>Nhiệt độ:</b>
             <input type="text" id = "txttemp" style="margin-left:48px; width:142px; margin-top:10px;" /><br />
             <b>Độ ẩm: </b>
             <input type="text" id = "txthumi" style="margin-left:64px; width:142px; margin-top:10px;"/> <br />
             <input type="button" id = "btnsetup" value="Cài đặt" style="width:80px; height:30px; margin-top: 10px; margin-left: 60px;" />
         	</div>
        </div>
</form>
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
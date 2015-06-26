<?php 
session_start();
require 'dbconnect.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
	<link href="style.css" rel="stylesheet" type="text/css" />
    <link href="gateway.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src = "jquery.js"></script>

<script type="text/javascript">
    $(document).ready(function(e){
		
	});
</script>
</head>

<body>
<div id="wrap">
  	<div id="top">
    	<div id="ttlogin"></div> <br />
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
	<div id="menu">
		<ul>			
	      	<li class="active"><a href="index.php"><span>Bo nhúng</span></a></li>
	      	<li><a href="mapvl.php"><span>Bản đồ</span></a></li>
            <li><a href="draw.php"><span>Vẽ đồ thị</span></a></li>
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
		<div id="right_con">			
			<div class="log3">Thông tin khu cảnh báo cháy</div>
			<div class="title_back">
				<select id = "malenh1" class ="malenh">
					<option value = "malenh">----Chọn mã lệnh----</option>
					<option value="000">Lấy nhiệt độ, độ ẩm</option> 
					<option value="011">Gửi cảnh báo mức 1</option> 
		            <option value="021">Gửi cảnh báo mức 2</option> 
		            <option value="031">Gửi cảnh báo mức 3</option> 
					<option value="041">Gửi cảnh báo mức 4</option> 
					<option value="051">Gửi cảnh báo mức 5</option> 
					<option value="131">&nbsp&nbsp&nbsp&nbsp&nbspReset</option> 
			    </select>
			    <span id = "chon_node1">
					<select id = "node1" class = "node">
						<option>---Chọn nút mạng---</option>
					</select>
				</span>
				<button id="send_bc">Gửi lệnh</button>
		    </div>	
			<div id="message1"></div>
		</div>
		<div id="left_con">	
			<div class="log5">Thông tin khu chăm sóc lan</div>		
			<div class="title_back">
				<select id = "malenh">
					<option value = "malenh">----Chọn mã lệnh----</option>
					<option value="000">Lấy nhiệt độ, độ ẩm</option> 
					<option value="011">Bật van 1</option> 
		            <option value="021">Bật van 2</option> 
		            <option value="031">Bật van 3</option> 
					<option value="041">Bật van 4</option> 
					<option value="051">Bật van 5</option> 
					<option value="061">Bật van 6</option> 
					<option value="151">Bật tất cả các van</option> 
					<option value="010">Tắt van 1</option> 
					<option value="020">Tắt van 2</option> 
					<option value="030">Tắt van 3</option> 
		            <option value="040">Tắt van 4</option> 
		            <option value="050">Tắt van 5</option> 
		            <option value="060">Tắt van 6</option> 
					<option value="150">Tắt tất cả các van</option> 
			    </select>
			    <span id = "chon_node">
					<select id = "node" name = "node">
						<option>---Chọn nút mạng---</option>
					</select>
				</span>
				<button id="send">Gửi lệnh</button>
		    </div>			
			<div id="message"></div>
		</div>
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

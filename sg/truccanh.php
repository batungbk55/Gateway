<?php session_start(); 
require 'dbconnect.php';
$sql=mysql_query('SELECT * FROM video');
//mysql_close($connect);
?>
<html>
<head>
	<title>CSS Heaven 1</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="style.css" rel="stylesheet" type="text/css" />
    <link href="camera.css" rel="stylesheet" type="text/css" /> 
	<script type="text/javascript" src = "jquery.js"></script>
<style type="text/css">

</style>
<script type="text/javascript">

function check_db(username,password){ 
	http.open('get', 'check_login.php?u='+username+'&p='+password);
	http.onreadystatechange = handleResponse;
	http.send(null);
}

function handleResponse() {
	if(http.readyState == 4){
  		var response = http.responseText;
  		if(response=='false'){
  	  		document.getElementById('fail_alert').innerHTML="Ä�Äƒng nháº­p tháº¥t báº¡i. Vui lÃ²ng thá»­ láº¡i";
  	  		document.getElementById('username').value = "";
  	  		document.getElementById('password').value = "";
  	  	}
  		else if(response=='true'){
  			document.getElementById('fail_alert').innerHTML="Ä�Äƒng nháº­p thÃ nh cÃ´ng!";
  			window.history.back(-1);
  	  	}
  	}
}
</script>
<script type="text/javascript">
$(document).ready(function(e) {
    		//*******************************
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
});
</script>
</head>
<body>
	<form method="POST" name="video">
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
                <li><a href="draw.php"><span>Vẽ đồ thị</span></a></li>
		      	<li><a href="video.php"><span>Video</span></a></li>
		      	<li><a href="camera.php"><span>Camera</span></a></li>       	    
	            <li class="active"><a href="truccanh.php"><span>Trực canh</span></a></li>
	            <?php if(isset($_SESSION['login_status'])) 
					if($_SESSION['login_status']=='yes') {
						if($_SESSION['level'] == 1){
			?>
            <li><a href="manage.php"><span>Quản lý</span></a></li>
            <?php }}?>
	   		</ul>
			</div>
  		<div id="contentwrap">
	    <div id="mainpage">
			<div id="left_con">
	        <br />
	        <br />
			<div id="lvd0">Trực Canh</div>
			</div>
			<div id="right_con">
				<div class="log3">Phát hiện xâm nhập</div><br />
		        <br /><br /><br />
		   <iframe src="truccanh/index.php" scrolling="no" height="500" width="600" frameborder="0" ></iframe>
			
            
			</div>
	    </div>
        <div id="bottom">
				<div id="footer">
			        <div id="fl_right">Copyright by <a href="#">Lab 411</a></div>
			        <div class="clear"></div>
				</div>
		    </div>
		</div>
        
	</div>
</form>
</body>
</html>
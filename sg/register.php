<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Đăng ký</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
/*#header {
	background:#6E8B3D;
	width:980px;
	height:200px;
	margin: 10px;
}*/
#top_login{
	height: 50px;
}
#login .log3{
	border-bottom: solid 1px #b0bb88;
	font-size: 40px;
	display: block;
	font: bold 30px Comfortaa;
	padding-bottom: 10px;
	color: #212713;
}
#bottom_login{
	height: 100px;
}
button {
	cursor: pointer;
	margin-top: 10px;
	margin-bottom: 10px;
	margin-left: 10px;
	padding: 5px 10px 5px 10px;
	font-weight: bold;
}
.log1{
	width: 140px;
	padding : 7px 7px 10px 7px;
	font-weight: bold;
	margin-bottom: 10px;
}
.log2 input{
	width: 200px;
	padding: 2px;
	margin-bottom: 10px;
}
#fail_alert{
	padding: 5px 10px 20px 10px;
	font-weight: bold;
	font-size: 20px;
}
#username_alert,#password_alert{
	padding : 7px 7px 15px 7px;
	font-weight: normal;
	margin-bottom: 10px;
}
</style>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
$(document).ready(function (){
	 var isLogin='<?php if(isset($_SESSION['login_status'])){if($_SESSION['login_status']=='yes')echo 'yes';else echo 'no';}else    echo 'no';?>';
	var isLevel='<?php if(isset($_SESSION['level'])){echo $_SESSION['level'];}?>';
	if(isLogin=='yes'){			 
		var content = "<table><tr><td><i>Xin chào bạn </i><b> [ </b><u id='log'><?php if(isset($_SESSION['login_status'])){ echo $_SESSION['user'];} ?></u><b> ] </b></td><td></td></tr></table>";
		$('#ttlogin').append(content);
	}
	else{
		var content = "<table><tr><td> <a href='register.php'>Đăng ký</a>&nbsp&nbsp&nbsp&nbsp<a href='login.php'>Đăng nhập</a></td></td></tr></table>";
		$('#ttlogin').append(content);
	}
	//*******************************
	$('#register').click(function(){
		if($("#username").val() == "" || $("#password").val() == "")
		{
			alert("Bạn phải điền đầy đủ thông tin");
			}
		else
		{
			if($("#password").val().length < 5)
			{
				alert("Mật khẩu chứa ít nhất 5 ký tự");
				}
			else
			{
			var user = $("#username").val();
			var pass = $("#password").val();
			$.ajax({
				url: "check_register.php",                           
				type: "POST",
				data: "user="+user+"&pass="+pass, 
			    success:function(response){
			    	if(response=='false'){
					  	$('#fail_alert').text("Đăng ký thất bại. Vui lòng thử lại.");
					}
				  	if(response=='true'){
					  	alert('Đăng ký thành công');
					  	document.location.href="index.php";
					}			    
			    } 
			});
			}
		}
	});	
	
	$("#username").keyup(function(e) {
		var username = $("#username").val();
		//$("#username_alert").html("cheking....");
		if($("#username").val().length == 0)
		{
			$("#im").hide();
			}
		else{
        $.ajax({
			url: "check_user.php",
			type:"POST",
			data:"username="+username,
			success: function(result)
			{
				//$("#username_alert").html(result);
				if(result == "true")
				{
					$("#im").attr("src","images/check.gif");
					$("#im").show();
					}
				else
				{
					
					$("#im").attr("src","images/false.png");
					$("#im").show();
					}
				}
			});
		}
    });
	$("#password").keyup(function(e) {
        if($("#password").val().length < 5 && $("#password").val().length > 0 )
		{
			$("#impass").attr("src","images/false.png");
			$("#impass").show();
			}
		if($("#password").val().length >= 5)
		{
			$("#impass").attr("src","images/check.gif");
			$("#impass").show();
			}
		if($("#password").val().length == 0)
		{
			$("#impass").hide();
			}
    });
});
</script>
</head>

<body>
<div id="wrap">
  	<div id="top">
        <div id="ttlogin"></div>
        <div id="banner">
	    <embed src="http://bannertudong.com/uploads/system/flash/20110503/view.swf" quality="high" bgcolor="#ffffff" wmode="transparent" menu="false" width="1000" height="250" name="Editor" align="middle" allowScriptAccess="always" flashVars='xml=http://bannertudong.com/uploads/user/20130904/19948/19948.xml?0' type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
        </div>    
  	</div>
  
	<div id="menu">
		<ul>			
	      	<li><a href="index.php"><span>Bo nhúng</span></a></li>
	      	<li><a href="map.php"><span>Bản đồ</span></a></li>
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
  	<div id="contentwrap">
    <div id="mainpage">
    <center>
	
	<div id="login">
		<div class="log3">Đăng ký</div>
		<div id="top_login"></div>	
		<span id="fail_alert"></span><br>
		<table>	
		<tr>
			<td class="log1">Tên đăng nhập:</td>
			<td class="log2"><input id="username" type="text"></td>
			<td id="username_alert"><img id="im"></img></td>
		</tr>		
		<tr>
			<td class="log1">Mật khẩu:</td>
			<td class="log2"><input id="password" type="password"></td>
			<td id="password_alert"><img id="impass"> </td>
		</tr>
        
		</table>
			<button id="register" style="">Đăng ký</button>
	</div>
	<div id="bottom_login"></div>
</center>
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>CSS Heaven 1</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
/*#header {
	background:#6E8B3D;
	width:980px;
	height:200px;
	margin: 10px;
} */
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
$(document).ready(function(){
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
	$(document).keypress(function(event) {
        if(event.keyCode == '13')
		{
			var user_name=$('#username').val();
		    var pass_word=$('#password').val();
		    if(user_name=="" && pass_word==""){
			$('#username_alert').text("Chưa điền tên đăng nhập");
			$('#password_alert').text("Chưa điền mật khẩu đăng nhập");
			
		}
		else if(pass_word==""){
			$('#username_alert').text("");
			$('#password_alert').text("Chưa điền mật khẩu đăng nhập");
			
		}
		else if(user_name=="" ){
			$('#password_alert').text("");
			$('#username_alert').text("Chưa điền tên đăng nhập");
			
		}
		else{
			$.ajax({
				url: "check_login.php",                           
				type: "POST",
				data: "u="+user_name+"&p="+pass_word, 
			    success:function(response){
			  		if(response=='false'){
			  	  		$('#fail_alert').text("Tên đăng nhập hoặc mật khẩu không đúng!");
			  	  		$('#username').text( "");
			  	  		$('#password').text("");
			  	  	}
			  		else if(response=='true'){
			  			alert('Đăng nhập thành công!');
			  			//window.history.back(-1);
						window.location.href = "index.php";
			  	  	}		    
			    } 
			});
		}
			}
    });
	$('#check_login').click(function(){
		var user_name=$('#username').val();
		var pass_word=$('#password').val();
		if(user_name=="" && pass_word==""){
			$('#username_alert').text("Chưa điền tên đăng nhập");
			$('#password_alert').text("Chưa điền mật khẩu đăng nhập");
			
		}
		else if(pass_word==""){
			$('#username_alert').text("");
			$('#password_alert').text("Chưa điền mật khẩu đăng nhập");
			
		}
		else if(user_name=="" ){
			$('#password_alert').text("");
			$('#username_alert').text("Chưa điền tên đăng nhập");
			
		}
		else{
			$.ajax({
				url: "check_login.php",                           
				type: "POST",
				data: "u="+user_name+"&p="+pass_word, 
			    success:function(response){
			  		if(response=='false'){
			  	  		$('#fail_alert').text("Tên đăng nhập hoặc mật khẩu không đúng!");
			  	  		$('#username').text( "");
			  	  		$('#password').text("");
			  	  	}
			  		else if(response=='true'){
			  			alert('Đăng nhập thành công!');
			  			//window.history.back(-1);
						window.location.href = "index.php";
			  	  	}		    
			    } 
			});
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
		<div class="log3">Đăng nhập</div>
		<div id="top_login"></div>	
		<span id="fail_alert"></span><br />
		<table>
		<tr>
			<td class="log1">Tên đăng nhập:</td>
			<td class="log2"><input id="username" type="text"/></td>
			<td id="username_alert"></td>
		</tr>
		<tr>
			<td class="log1">Mật khẩu:</td>
			<td class="log2"><input id="password" type="password"/></td>
			<td id="password_alert"></td>
		</tr>
		</table>
		<button id="check_login">Đăng nhập</button>	
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
<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Đổi mật khẩu</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="style.css" rel="stylesheet" type="text/css" />
<style>
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
	margin-left: 0px;
	padding: 5px 10px 5px 10px;
	font-weight: bold;
}
.log1{
	width: 200px;
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
$(document).ready(function(e) {
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
	$("#log").click(function(e) {
		$("#menulogin").css('left',e.pageX - 150);
		$("#menulogin").css('top',e.pageY + 10);
        $("#menulogin").show();
    });
	$(document).bind("mouseup",function(e){
		$("#menulogin").hide();
		});
	//*******************************
	$('#changepass').click(function(e) {
        if($('#passht').val() == "")
		{
			alert("Chưa nhập mật khẩu hiện tại");
			}
		else if($('#newpass').val() == "")
		{
			alert("Chưa nhập mật khẩu mới");
			}
		else if($('#renewpass').val() == "")
		{
			alert ("Chưa xác nhận lại mật khẩu");
			}
		else
		{
			if($('#newpass').val().length < 5)
			{
				alert("Mật khẩu chứa ít nhất 5 ký tự");
			}
			else
			{ 
				 	if($('#newpass').val() == $('#renewpass').val())
					{
						var newpass = $('#newpass').val();
						var pass = $('#passht').val();
						$.ajax({
							url:"save_change_pass.php",
							type:"POST",
							data:"pass="+pass+"&newpass="+newpass,
							success: function(result)
							{
								if(result == "true")
								{
									alert("Đổi mật khẩu thành công");
									document.location.href="index.php";
								}
								else
								{
									alert("Không đổi được mật khẩu vui lòng thử lại");
								}
							}
						});
					}
					else
					{
						alert("Nhập lại mật khẩu không chính xác");	
					}
				}
			}
    });
});
</script>>
</head>

<body>
<div id="wrap">
  	<div id="top">
	    <h1 id="sitename">Sigate <em>WSAN</em> LAb 411</h1>
        <div id="ttlogin"></div>    
        <div id = "menulogin" class="ctmenu">
           <table>
	           <tr><td class="menuitem" id = "tt"><a href="">Chỉnh sửa thông tin</a></td></tr>
	           <tr><td class="menuitem" id = "pass"><a href=""> Đổi mật khẩu </a></td></tr>
               <tr><td class="menuitem" id = "out"> <a href="signout.php">Đăng xuất</a></td></tr>
           </table>
        </div>
  	</div>
  
	<div id="menu">
		<ul>			
	      	<li><a href="index.php"><span>Bo nhúng</span></a></li>
	      	<li><a href="map.php"><span>Bản đồ</span></a></li>
	      	<li><a href="video.php"><span>Video</span></a></li>
	      	<li><a href="camera.php"><span>Camera</span></a></li>	      
            <li ><a href="truccanh.php"><span>Trực canh</span></a></li>
            <li><a href="manage.php"><span>Quản lý</span></a></li>
	   	</ul>
	</div>
  	<div id="contentwrap">
    <div id="header"> 
    </div>
    <div id="mainpage">
    <center>
	
	<div id="login">
		<div class="log3">Đổi mật khẩu</div>
		<div id="top_login"></div>	
		<span id="fail_alert"></span><br>
		<table>	
		<tr>
			<td class="log1">Mật khẩu hiện tại:</td>
			<td class="log2"><input id="passht" type="password"></td>
		</tr>		
		<tr>
			<td class="log1">Mật khẩu mới:</td>
			<td class="log2"><input id="newpass" type="password"></td>
			<td id="password_alert"><img id="impass"> </td>
		</tr>
        <tr>
			<td class="log1">Nhâp lại mật khẩu mới:</td>
			<td class="log2"><input id="renewpass" type="password"></td>
			<td id="password_alert"><img id="impass"> </td>
		</tr>
        <tr><td></td></tr>
        <tr>
        <td></td>
        <td><button id="changepass" style="">Đổi mật khẩu</button></td>	
		</tr>
        </table>
		
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
<?php 
session_start(); 
require 'dbconnect.php';
	$sql=mysql_query('SELECT * FROM video');
    $lenh=mysql_query("SELECT * FROM link WHERE id='1'");
    while($link=mysql_fetch_array($lenh))
    {
         $link1=$link['url'];
    }
    $lenh2=mysql_query("SELECT * FROM link WHERE id='2'");
    while($link3=mysql_fetch_array($lenh2))
    {
         $link2=$link3['url'];
    }    
?>
<html>
<head>
	<title>CAMERA</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="style.css" rel="stylesheet" type="text/css" />
    <link href="camera.css" rel="stylesheet" type="text/css" /> 
	<script type="text/javascript" src = "jquery.js"></script>
 <script language="javascript">
	//*******************************
	$(document).ready(function(e) {
         var isLogin='<?php if(isset($_SESSION['login_status'])){if($_SESSION['login_status']=='yes')echo 'yes';else echo 'no';}else    echo 'no';?>';
	     isLevel='<?php if(isset($_SESSION['level'])){echo $_SESSION['level'];}?>';
	     if(isLogin=='yes'){			 
		//var content = "<table><tr><td><a href='signout.php'>Ðăng xuất</a></td><td></td></tr></table>";
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
    });
	//*******************************
	   function xoaytrai()
        {
			
			if(isLevel==1)
			{
                parent.mouse2.location="camera/xoayphai.php";
			}
			else
			{
				alert("Bạn chưa đăng nhập hoặc không có quyền điều khiển!");
				}
				
        }
		
        function xoayphai()
        {
			
			if(isLevel==1)
			{
                parent.mouse2.location="camera/xoaytrai.php";
			}
			else
			{
				alert("Bạn chưa đăng nhập hoặc không có quyền điều khiển!");
				}
				
		}
		
        function xoaytraiip()
        {
			if(isLevel==1)
			{
            parent.mouse2.location="http://192.168.0.165:12345/cgi-bin/camctrl/camctrl.cgi?move=left";
			}
			else
			{
				alert("Bạn chưa đăng nhập hoặc không có quyền điều khiển!");
				}
		}
		
        function xoayphaiip()
        {
			if(isLevel==1)
			{
            parent.mouse2.location="http://192.168.0.165:12345/cgi-bin/camctrl/camctrl.cgi?move=right";
			}
			else
			{
				alert("Bạn chưa đăng nhập hoặc không có quyền điều khiển!");
				}
        }
    </script>
   
</head>

<body>
<form method="POST" name="video">
 <script type="text/javascript">
	   
		</script>
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
	      	<li class="active"><a href="camera.php"><span>Camera</span></a></li>           
             <li><a href="truccanh.php"><span>Trực canh</span></a></li>
            <?php if(isset($_SESSION['login_status'])) 
					if($_SESSION['login_status']=='yes') {
						if($_SESSION['level'] == 1){
			?>
            <li><a href="manage.php"><span>Quản lý</span></a></li>
            <?php }}?>
	   	</ul>
	</div>
  	<div id="contentwrap">
   
     <iframe name="mouse2" src="#" scrolling="no" height="1" width="1" frameborder="1"></iframe>
    
    <div id="mainpage">
    	<div id="right_con">
		<div class="log3">CAMERA STREAMING</div><br />
        <br /><br /><br /><br /><br />
        <h1 id="selectca">Chọn camera xem video !</h1>
        <?php
        if(isset($_POST['camera1']))
        {
			mysql_query("UPDATE link SET url = '1' WHERE id = '3'");
            ?>
            <script language="javascript">
			$(document).ready(function(e) {
                $("#selectca").hide();
            });
			</script>
            <h2> Video phát từ camera 1</h2> <br />
             <embed type="application/x-vlc-plugin" version="VideoLAN.VLCPlugin.2"
             name="video" id="video: my video" autoplay="yes" loop="yes"
             target="http://192.168.0.165:12345/video2.mjpg"
             width="504" height="344" onFocus="javascript:videoClicked();" />
             <br />
             
            <?php
        }  
        if(isset($_POST['camera2']))
        { 
		    mysql_query("UPDATE link SET url = '2' WHERE id = '3'");
            ?>
            <script language="javascript">
			$(document).ready(function(e) {
                $("#selectca").hide();
            });
			</script>
             <h2> Video phát từ camera 2</h2> <br />
             <embed type="application/x-vlc-plugin" version="VideoLAN.VLCPlugin.2"
             name="video" id="video: my video" autoplay="yes" loop="yes"
             target="<?php print $link2 ?>"
             width="504" height="328" onFocus="javascript:videoClicked();" />
             <br />
            <?php      
        }
        ?>
        
		
	</div>
		<div id="left_con">
        <br />
        <br />
		<div id="lvd0">Chọn Camera :</div>
        <br /><br />
        <div id="pvd0">
       <div > 
       <input type="submit" class="btn btn-primary" value="Camera  1" name="camera1" size="20" style="position: absolute; width: 200; height: 30; " /><br /></div>
        <br /><br />
        <div ><input type="submit" class="btn btn-primary" value="Camera  2" name="camera2" size="20" style="position: absolute; width: 200; height: 30; " /></div>
      <br /><br />
	</div>
    <div id="lvd1"> Tùy chọn </div>
    <div id="pvd1" >
    <?php
           $lenh3=mysql_query("SELECT * FROM link WHERE id='3'");
            while($ca=mysql_fetch_array($lenh3))
            {
                $choose=$ca['url'];
            }
             if($choose==1)
            {
            echo '<input type="button" class="btn-info" value="Xoay trái ip" onclick="xoaytraiip()"  />';echo "        ";
            echo '<input type="button" class="btn-info" value="Xoay phải ip" onclick="xoayphaiip()" />'; 
            }
            if($choose==2)
           { 
	             echo '<input type="button" class="btn-info" value="Xoay trái" onclick="xoaytrai()"  />';echo "         ";
                 echo '<input type="button" class="btn-info" value="Xoay phải" onclick="xoayphai()" />';
           }
    
       if($choose==0)
        {
        echo 'Chưa chọn camera';
        }
		
		//mysql_close($connect);
     ?>
    </div>
  
	</div>

    </div>
   
	<div id="bottom">
		<div id="footer">
	        <div id="fl_left">&copy; YourSitename.com | All Rights Reserved</div>
	        <div id="fl_right"><a href="http://www.websitetemplateco.com/">Free CSS Templates</a> by <a href="http://cssheaven.org">CSS Heaven</a></div>
	        <div class="clear"></div>
		</div>
    </div>
	</div>
	<div id="contentbtm"></div>
</div>
</form>
</body>
</html>
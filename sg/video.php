<?php session_start(); 
require 'dbconnect.php';
	$sql=mysql_query('SELECT * FROM video');
?>
<html>
<head>
	<title>VIDEO</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
#header {
	background:url("images/hd1.png");
	width:980px;
	height:200px;
	margin: 10px;
	position: relative;
} 
.log3{
	border-bottom: solid 1px #b0bb88;
	display: block;
	font: bold 30px Comfortaa;
	padding-bottom: 10px;
	color: #212713;
	float: right;
}
#lvd0,#lvd1,#lvd2,#lvd3,#lvd4,#lvd5,#lvd6,#lvd7,#lvd8,#lvd9,#lvd10,#lvd11,#lvd12,#lvd13,#lvd14,#lvd15,#lvd16,#lvd17,#lvd18,#lvd19,#lvd20,#lvd21,#lvd22,#lvd23,#lvd24,#lvd25,#lvd26,#lvd27,#lvd28,#lvd29{
	border-bottom: solid 1px #b0bb88;
	display: block;
	font: bold 21px Comfortaa;
	padding-bottom: 10px;
	color: #212713;
	margin-top: 10px;
	cursor: pointer;
	text-decoration: underline;
}
#pvd0,#pvd1,#pvd2,#pvd3,#pvd4,#pvd5,#pvd6,#pvd7,#pvd7,#pvd9,#pvd10,#pvd11,#pvd12,#pvd13,#pvd14,#pvd15,#pvd16,#pvd17,#pvd18,#pvd19,#pvd20,#pvd21,#pvd22,#pvd23,#pvd24,#pvd25,#pvd26,#pvd27,#pvd28,#pvd29{
	display: none;
	padding: 10px 10px 10px 10px;
	
}
#left_con{
	width: 300px;
	height: 580px;
	float: left;
    overflow: auto; 
}
#right_con{
	width: 560px;
	background:#6E8B3D;
	height: 200px;
	float: right;
	height: 580px;
    	overflow: auto; 
}
#mainpage{
	background:#6E8B3D;
	width:960px;
	margin:10px;
	position: relative;
	padding-top: 10px;
	height: 600px; 
}
#message{
	height: 530px; 
	width: 740px; 
	overflow: auto; 
	background-color: silver; 
	border: 2px solid #555555;
	margin-top: 70px;
	padding-left: 20px;
}
button {
	cursor: pointer;
	margin-top: 10px;
	margin-bottom: 10px;
	margin-left: 50px;
	padding: 5px 10px 5px 10px;
	font-weight: bold;
}
#title_back select {
	width: 190px;
	padding: 2px;
}
#title_back{
	margin-top: 50px;
}
.log4{
	border-bottom: solid 1px #b0bb88;
	display: block;
	font: bold 21px Comfortaa;
	padding-bottom: 10px;
	color: #212713;
	margin-top: 50px;
}
#ttlogin{
	float: right;
    }
#ttlogin a{
	color: white;
     }
td u,b {
		color: white;
	}
</style>
<script type="text/javascript" src = "jquery.js"></script>
<script language="javascript">
        //*******************************
	     $(document).ready(function(e) {
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
	<script type="text/javascript" src="js/jquery.jmslideshow.js"></script>
<?php
$j=0;
while($j<30)
{
 ?>   
    <script type="text/javascript">
$(document).ready(function(){			
	$('<?php print '#lvd'.$j; ?>').click(function(){
		$('<?php print '#pvd'.$j ?>').slideToggle("fast");
        
	});				
});
		</script>
        <?php 
        $j++;
        } ?>
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
	      	<li class="active"><a href="video.php"><span>Video</span></a></li>
	      	<li><a href="camera.php"><span>Camera</span></a></li>
            <li><a href="truccanh.php"><span>Trực Canh</span></a></li>
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
		<div class="log4">Tìm Kiếm</div><br />
        
	
        Chọn ngày :
        <input type="date" name="ngay" />
			
		    <br/><br/>
            <input type="submit" name="Timkiem" value="Tìm Kiếm" style="position: absolute; height: 30; width: 100; margin-left:150px;" />
	</div>
	     <div id="right_con">
		<div class="log3">Video Replay</div><br />
        
        <br /><br /><br />
        
           <?php
           $sovideo=0;
            if(isset($_POST['Timkiem']))
            {
				$date_ = $_POST['ngay'];
                $ngay1= substr($date_,8,2);
                $thang1= substr($date_,5,2);
                $nam1= substr($date_,0,4);
                $ngaythangnam=$ngay1."-".$thang1."-".$nam1;
                $sql=mysql_query("SELECT * FROM video where ngay= '{$ngaythangnam}'") or die("khong co du lieu") ;
                $sq2=mysql_query("SELECT * FROM video where ngay= '{$ngaythangnam}'") or die("khong co du lieu") ;
          	while($kq=mysql_fetch_array($sql))
            {
               $sovideo++;
                
            }
            echo "Có ".$sovideo." video cảnh báo được tìm thấy trong ngày ".$ngay1." tháng ".$thang1." năm ".$nam1;
            echo '<br/>';
            echo '<br/>';
            $i=0;
            while($kq2=mysql_fetch_array($sq2))
            {
               $go=$kq2['gio'];
               ?>
               <div id="<?php print 'lvd'.$i ?>"><?php echo substr($go,0,2);?> gio <?php echo substr($go,3,2);?> phut <?php echo substr($go,6,8); ?> giay</div>
               
               <div id="<?php print 'pvd'.$i?>">  <embed type="application/x-vlc-plugin" version="VideoLAN.VLCPlugin.2"
             name="video2" id="video2: my video" autoplay="yes" loop="no"
          target="<?php print "truccanh/video/".$ngaythangnam."-".$go.".mpg"; ?>"
             width="352" height="288" onFocus="javascript:videoClicked();" /> </div>
             
               <br/>
               <?php
              
                $i++;
            }
            }
			//mysql_close($connect);
            ?>
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
</body>
</html>
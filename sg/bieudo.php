<?php 
session_start();
require 'dbconnect.php';
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Highcharts Example</title>
        <link href="style.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="lich.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script src="highcharts.js"></script>
        <script src="exporting.js"></script>
        <script type="text/javascript" src="js/jquery.jmslideshow.js"></script>
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

#left_con{
	width: 480px;
	height: 580px;
	float: left;
    overflow: auto; 
	
}
#right_con{
	width: 480px;
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
<script type="text/javascript">
function getTime()
{
	    var timer = new Date();          
		var hour = timer.getHours();     
		if( hour < 10) hour = "0" + hour;          
		var minute = timer.getMinutes(); 
		if(minute < 10) minute = "0" + minute;       
		var second = timer.getSeconds(); 
		if(second < 10) second = "0" + second;       
		var now_time = "<i>" + hour + ":" + minute + ":" + second +"___</i>";
		return now_time;
	}	
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
	
	
function check_db(username,password){ 
	http.open('get', 'check_login.php?u='+username+'&p='+password);
	http.onreadystatechange = handleResponse;
	http.send(null);
}

	
function handleResponse() {
	if(http.readyState == 4){
  		var response = http.responseText;
  		if(response=='false'){
  	  		document.getElementById('fail_alert').innerHTML="Đăng nhập thất bại. Vui lòng thử lại";
  	  		document.getElementById('username').value = "";
  	  		document.getElementById('password').value = "";
  	  	}
  		else if(response=='true'){
  			document.getElementById('fail_alert').innerHTML="Đăng nhập thành công!";
  			window.history.back(-1);
  	  	}
  	}
	
}
		function drawvl(t1,t2,t3,t4,t5,t6,t7,t8,t9,t0A,t0B,t0C,h1,h2,h3,h4,h5,h6,h7,h8,h9,h0A,h0B,h0C,p1,p2,p3,p4,p5,p6,p7,p8,p9,p0A,p0B,p0C){		
     
        $('#container').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Biểu đồ cột dữ liệu trung bình khu vực'+""+textArea+""+'ngày'+" "+time1
            },
            xAxis: {
                categories: ['01', '02', '03', '04', '05','06','07','08','09','0A','0B','0C',]
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Nhiệt độ',
                data: [t1,t2,t3,t4,t5,t6,t7,t8,t9,t0A,t0B,t0C]
            }, {
                name: 'Độ ẩm',
                data: [h1, h2,h3,h4,h5,h6,h7,h8,h9,h0A,h0B,h0C]
            }, {
                name: 'Năng lượng ',
                data: [p1, p2,p3, p4,p5,p6,p7,p8,p9,p0A,p0B,p0C]
            }]
        });
	
    }
	//ham ve bao chay
	function drawbc(t31,t32,t33,t34,t35,t36,t37,t38,t39){		
     
        $('#container').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Biểu đồ cột dữ liệu trung bình khu vực'+""+textArea+""+'ngày'+" "+time1
            },
            xAxis: {
                categories: ['31', '32', '33', '34', '35','36','37','38','39',]
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Nhiệt độ',
                data: [t31,t32,t33,t34,t35,t36,t37,t38,t39]
            }, {
                name: 'Độ ẩm',
                data: [h31,h32,h33,h34,h35,h36,h37,h38,h39]
            }, {
                name: 'Năng lượng',
                data: [p31,p32,p33,p34,p35,p36,p37,p38,p39]
            }]
        });
	
    }
		var area;
		var textArea;
		$(document).ready(function(e) {
			
			//var x=8;
            $("#Draw").click(function(e) {
				var time=time1;
				alert(time);
				var y= document.getElementById("area").selectedIndex;
		        var b = document.getElementById("area").options;
		         area = b[y].value;//alert(area);
				  textArea = b[y].text;
                $.ajax({
					url:"getdata_avg.php",
					type:"POST",
					data:"message="+area+time,
					async:false,
					success: function(data){
						var getdata=$.parseJSON(data);
						if(area=="0"||time1=="") alert("Bạn chưa chọn khu vực hoặc ngày muốn xem biểu đồ");
						if(area=="1"){
							t1=getdata.Temp1;t1=parseFloat(t1);t2=getdata.Temp2;t2=parseFloat(t2);t3=getdata.Temp3;	t3=parseFloat(t3);						t4=getdata.Temp4;t4=parseFloat(t4);t5=getdata.Temp5;t5=parseFloat(t5);t6=getdata.Temp6;t6=parseFloat(t6);
						    t7=getdata.Temp7;t7=parseFloat(t7);t8=getdata.Temp8;t8=parseFloat(t8);t9=getdata.Temp9;t9=parseFloat(t9);
						    t0A=getdata.Temp0A;t0A=parseFloat(t0A);t0B=getdata.Temp0B;t0B=parseFloat(t0B);t0C=getdata.Temp0C;t0C=parseFloat(t0C);
						    h1=getdata.Humi1;h1=parseFloat(h1);h2=getdata.Humi1;h1=parseFloat(h2); h3=getdata.Humi3;h3=parseFloat(h3);h4=getdata.Humi4;h4=parseFloat(h4);h5=getdata.Humi5;h5=parseFloat(h5);h6=getdata.Humi6;h6=parseFloat(h6);h7=getdata.Humi7;h7=parseFloat(h7);h8=getdata.Humi8;h8=parseFloat(h8);h9=parseFloat(getdata.Humi9);h0A=parseFloat(getdata.Humi0A);h0B=parseFloat(getdata.Humi0B);h0C=parseFloat(getdata.Humi0C);
							//lay nag luong
							p1=parseFloat(getdata.Power1);p2=parseFloat(getdata.Power2);p3=parseFloat(getdata.Power3);p4=parseFloat(getdata.Power4);p5=parseFloat(getdata.Power5);p6=parseFloat(getdata.Power6);p7=parseFloat(getdata.Power7);p8=parseFloat(getdata.Power8);p9=parseFloat(getdata.Power9);p0A=parseFloat(getdata.Power0A);p0B=parseFloat(getdata.Power0B);p0C=parseFloat(getdata.Power0C);
						    $('#area').prop('selectedIndex',0);
						   //alert( typeof(x));
						   //alert(data);
						   drawvl(t1,t2,t3,t4,t5,t6,t7,t8,t9,t0A,t0B,t0C,h1,h2,h3,h4,h5,h6,h7,h8,h9,h0A,h0B,h0C,p1,p2,p3,p4,p5,p6,p7,p8,p9,p0A,p0B,p0C);
						}
						else if(area=="2") {
							t31=parseFloat(getdata.Temp31);t32=parseFloat(getdata.Temp32);t33=parseFloat(getdata.Temp33);t34=parseFloat(getdata.Temp34);t35=parseFloat(getdata.Temp35);t36=parseFloat(getdata.Temp36);t37=parseFloat(getdata.Temp37);t38=parseFloat(getdata.Temp38);t39=parseFloat(getdata.Temp39);
							h31=parseFloat(getdata.Humi31);h32=parseFloat(getdata.Humi32);h32=parseFloat(getdata.Humi32);h33=parseFloat(getdata.Humi33);h34=parseFloat(getdata.Humi34);h35=parseFloat(getdata.Humi35);h36=parseFloat(getdata.Humi36);h37=parseFloat(getdata.Humi37);h38=parseFloat(getdata.Humi38);h39=parseFloat(getdata.Humi39);
							p31=parseFloat(getdata.Power31);p32=parseFloat(getdata.Power32);p33=parseFloat(getdata.Power33);p34=parseFloat(getdata.Power34);p35=parseFloat(getdata.Power35);p36=parseFloat(getdata.Power36);p37=parseFloat(getdata.Power37);p38=parseFloat(getdata.Power38);p39=parseFloat(getdata.Power39);
							drawbc(t31,t32,t33,t34,t35,t36,t37,t38,t39,h31,h32,h33,h34,h35,h36,h37,h38,h39,p31,p32,p33,p34,p35,p36,p37,p38,p39);
							$('#area').prop('selectedIndex',0);
						}
					}
				});
            });
			
	$("#bam1").click(function(e) {
				var time="30-11-2013";
                draw(<?php 
		$result = mysql_query("SELECT Temp FROM data_avg WHERE Sensor='04' AND Date='".$time."'");
	    $row = mysql_fetch_row($result);
	    $highest_id = $row[0];
	    echo $highest_id;
		?>);
				//alert(x);
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
	      	<li><a href="map.php"><span>Bản đồ</span></a></li>
	      	<li ><a href="video.php"><span>Video</span></a></li>
	      	<li><a href="camera.php"><span>Camera</span></a></li>
            <li><a href="truccanh.php"><span>Trực Canh</span></a></li>
             <li class="active"><a href="bieudo.php"><span>Biểu Đồ</span></a></li>
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
            
            <div id="setup">
                   
                         <tr><td><b>Khu vực: </b></td>
                             <td> <select id = "area" class ="area">
                                    <option value = "0">--Khu vực--</option>
                                    <option value = "1">--Vườn lan--</option>
                                    <option value = "2">--Báo cháy--</option>
                                    
                                </select>
                             </td>
                         </tr>    
                         <br/>
                         <tr><td><b>Chọn ngày :</b></td></tr>
                     </table>
                  
             </div>
            
            <div style="left:40px;float:left;">
 
                <script language="JavaScript">
                <!--
                setOutputSize("medium");
                document.writeln(printSelectedMonth());
                -->
                          
                
                </script>
                   <button  name="Draw" id="Draw" style=" position:inherit;height: 20;margin:9;left:50; width: 300px; " >Xem biểu đồ</button>
                    
               </div>

            <div id="container" style="min-width: 310px; height: 250px; margin: 0 auto"><p id="ngay"></p></div>
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

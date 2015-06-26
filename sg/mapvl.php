<?php
session_start();
require 'dbconnect.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>Map</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="map.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src = "jquery.js"></script>
<script type="text/javascript" src="jquery142.js"></script>
<script type="text/javascript">
$(document).ready(function(){
   
	var IdCmd = '<?php 
		$result = mysql_query("SELECT MAX(STT) FROM bantin");
	    $row = mysql_fetch_row($result);
	    $highest_id = $row[0];
	    echo $highest_id;
	?>';
	setInterval(function(){
		$.get("test2.php",function(data){
			if(data > IdCmd){
                    load(data)
					IdCmd = data;
			}
		});
	},500);
	function load(id){
		$.ajax({
			url: 'check_db.php',
			type:'POST',
			data:'id='+id,
			success: function(str)
			{
				var i = str.search("#JN");
				var j = str.search("#OK");
				if(i > -1 || j > -1)
				{
					//window.location.reload();
					//$("#icon").remove();
					//$(".icsensor").remove();
					//$(".icactor").remove();
					//$(".icval").remove();
					//$("#mymap").remove();
					
					$("#mainpage").load("loadmap.php");
					$("#mainpage").fadeOut("fast").load("loadmap.php").fadeIn("fast");
				}
				}
			});
		}
	$("#vuonlan").click(function(e){
		     window.location.href="mapvl.php";
		});
	$("#baochay").click(function(e){
	     window.location.href="mapbc.php";
	});
	var isLogin='<?php if(isset($_SESSION['login_status'])){if($_SESSION['login_status']=='yes')echo 'yes';else echo 'no';}else echo 'no';?>';
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
		
	$('.icactor').bind("contextmenu",function(e){
		$("#menusensor").hide();
		$("#menuval").hide();
		$("#menuactor").hide();
		$("#menubaochay").hide();
		$("#menu0").hide();
		macactor = $(this).attr('id');
		if(macactor =="00"){
			$.ajax({
				url: "ttactor.php",                           
				type: "POST",
				data: "id="+macactor, 
			    success:function(data){
			    	var getData = $.parseJSON(data);		    	
			    	$("#menuactor").css('left',e.pageX);
				    $("#menuactor").css('top',e.pageY);
				    
				    $("#idactor").text('Actor: '+getData.mac);
				    $('#battatca').attr('title',getData.mac);
				    $('#tattatca').attr('title',getData.mac);		    		 
				    $("#menuactor").show();			    
			    } 
			});	
		}
		if(macactor =="B1"){
			$.ajax({
				url: "ttbaochay.php",                           
				type: "POST",
				data: "id="+macactor, 
			    success:function(data){
			    	var getData = $.parseJSON(data);		    	
			    	$("#menubaochay").css('left',e.pageX);
				    $("#menubaochay").css('top',e.pageY);
				    
				    $("#idactor_bc").text('Actor : '+getData.mac);
				    $("#level_bc").text('Level : '+getData.level);
				    $('#reset').attr('title',getData.mac);			    		 
				    $("#menubaochay").show();			    
			    } 
			});	
		}	
        return false;
 	});
	
	$('.icval').bind("contextmenu",function(e){
		$("#menusensor").hide();
		$("#menuval").hide();
		$("#menuactor").hide();
		$("#menubaochay").hide();
		$("#menu0").hide();
		macval = $(this).attr('id');
		$.ajax({
			url: "ttval.php",                           
			type: "POST",
			data: "id="+macval, 
		    success:function(data){
		    	var getData = $.parseJSON(data);		    	
		    	$("#menuval").css('left',e.pageX);
			    $("#menuval").css('top',e.pageY);
			    
			    $("#idval").text('Van: '+getData.val);
			    $("#status").text('Status: '+getData.status);
			    $('#batvan').attr('title',getData.val);
			    $('#tatvan').attr('title',getData.val);	
			    $("#menuval").show();
		    } 
		});		
        return false;
 	});

	$("#batvan").click(function(e) {				
		$("#menuval").hide();
		var id = $(this).attr('title');
		if(isLevel==1){	
			$.get("change_van_no.php", {vanno: id }).done(function(data) {	
				
				var command;
				switch(id){
					case '1': command = "00011$"; break;
					case '2': command = "00021$"; break;
					case '3': command = "00031$"; break;
					case '4': command = "00041$"; break;
					case '5': command = "00051$"; break;
					case '6': command = "00061$"; break;
					default: command = "00011$";
				} 
				
				$.ajax({
					url:"send.php",
					type:"POST",
					data:"command="+command,
					success: function(string ){		
						if(string=="false"){
							alert("Không tìm thấy địa chỉ mạng của Actor !");
						}
						else{		
							$.ajax({
								url:"rxbatvan.php",
								type:"POST",
								data:"command="+string,
								success: function(bdata){
									alert(bdata);
									
								}
							});
						}				
					}
				});
			});
		}
		else{
			alert("Bạn chưa đăng nhập hoặc không được phép điều khiển van!");
		}		
	});

	$("#tatvan").click(function(e) {
		$("#menuval").hide();
		var id = $(this).attr('title');
		if(isLevel==1){	
			$.get("change_van_no.php", {vanno: id }).done(function(data) {
				//alert(data);
				var command;
				switch(id){
					case '1':command = "00010$";break;
					case '2':command = "00020$";break;
					case '3':command = "00030$";break;
					case '4':command = "00040$";break;
					case '5':command = "00050$";break;
					case '6':command = "00060$";break;
					default:command = "00010$";
				} 
				$.ajax({
					url:"send.php",
					type:"POST",
					data:"command="+command,
					success: function(string ){
						if(string=="false"){
							alert("Không tìm thấy địa chỉ mạng của Actor !");
						}
						else{
							$.ajax({
								url:"rxtatvan.php",
								type:"POST",
								data:"command="+string,
								success: function(bdata){
									alert(bdata);
								}
							});
						}
					}
				}); 
			});
		}
		else{
			alert("Bạn chưa đăng nhập hoặc không được phép điều khiển van!");
		}	
	});
	$('.icsensor').bind("contextmenu",function(e){
		$("#menusensor").hide();
		$("#menuval").hide();
		$("#menuactor").hide();
		$("#menubaochay").hide();
		$("#menu0").hide();
		macss = $(this).attr('id');
		$.ajax({
			url: "ttsensor.php",                           
			type: "POST",
			data: "id="+macss, 
		    success:function(data){
		    	var getData = $.parseJSON(data);				    
			    
			    if(getData.status == 0){				    
			    	$('#laydulieu').attr('title','no');
			    	$("#menu0").css('left',e.pageX);
				    $("#menu0").css('top',e.pageY);
			    	$("#menu0").show();
			    }
			    else{
			    	$("#idsensor").text('Sensor: '+getData.mac);
				    $("#nhietdo").text('Nhiet do: '+getData.temp);
				    $("#doam").text('Do am: '+getData.humi);
				    $("#nangluong").text('Nang luong: '+getData.ener);
			    	$('#laydulieu').attr('title',getData.mac);
			    	
			    	$("#menusensor").css('left',e.pageX);
				    $("#menusensor").css('top',e.pageY);
			    	$("#menusensor").show();
			    }			   
		    } 
		});		
        return false;
 	});
    $("#laydulieu").click(function(e) {
    	$("#menusensor").hide();
        mac = $(this).attr('title');
        $.get("changestt.php", {macid: mac}).done(function(data) {
			//alert(data);           
			$.ajax({
				url:"send.php",
				type:"POST",
				data:"command="+mac+"000$",
				success: function(string ){
					if(string=="false"){
						alert("Không tìm thấy địa chỉ mạng của Actor !");
					}
					else{
						$.ajax({
							url:"laydulieu.php",
							type:"POST",
							data:"command="+string,
							success: function(data){
								if(data !="false"){
									var getData = $.parseJSON(data);
									alert("Nút mạng: "+getData.mac+"\nĐịa chỉ mạng: "+getData.netip+"\nNhiệt độ: "+getData.temp+"\nĐộ ẩm: "+getData.humi+"\nNăng lượng: "+getData.ener);
								}
								else{
									alert("Chưa nhận được dữ liệu phản hồi.");
								}
							}
						});
					}
				}
			});
        });
    });
	
	$("#battatca").click(function(e) {
		$("#menuactor").hide();
		var id = $(this).attr('title');
		if(isLevel==1){	
			$.get("change_van_no.php", {vanno: "F" }).done(function(data) {
				//alert(data);
				$.ajax({
					url:"send.php",
					type:"POST",
					data:"command="+id+"151$",
					success: function(string ){
						if(string=="false"){
							alert("Không tìm thấy địa chỉ mạng của Actor !");
						}
						else{
							$.ajax({
								url:"battatca.php",
								type:"POST",
								success: function(data1){
									alert(data1);
								}
							});
						}
					}
				});
			});
		}
		else{
			alert("Bạn chưa đăng nhập hoặc không được phép điều khiển van!");
		}	
    });
	$("#tattatca").click(function(e) {
		$("#menuactor").hide();
		var id = $(this).attr('title');
		if(isLevel==1){	
			$.get("change_van_no.php", {vanno: "F" }).done(function(data) {
				//alert(data);
				$.ajax({
					url:"send.php",
					type:"POST",
					data:"command="+id+"150$",
					success: function(string ){
						if(string=="false"){
						}
						else{
							$.ajax({
								url:"tattatca.php",
								type:"POST",
								data:"command="+string,
								success: function(data1){
									alert(data1);
								}
							});
						}
					}
				});
			});
		}
		else{
			alert("Bạn chưa đăng nhập hoặc không được phép điều khiển van!");
		}
    });
    $("#reset").click(function(e) {
    	$("#menubaochay").hide();
    	var id = $(this).attr('title');
    	if(isLevel==1){
	    	$.get("change_reset.php",function(data){        	
	        	//alert(data);
	    		$.ajax({
	    			url:"send.php",
	    			type:"POST",
	    			data:"command="+id+"031$",
	    			success: function(string ){ 		
	    				$.ajax({
	    					url:"resetbc.php",
	    					type:"POST",
	    					data:"command="+string,
	    					success: function(data){
	    						alert(data);
	    					}
	    				});
	    			}
	    		});	    	
        	});    	
    	}
		else{
			alert("Bạn chưa đăng nhập hoặc không được phép điều khiển van!");
		}
    });
	
    $("#mainpage").bind("contextmenu",function(e){
        return false;
 	});
 	$("#mainpage").bind("mousedown",function(e){
 		$("#menusensor").hide();
		$("#menuval").hide();
		$("#menuactor").hide();
		$("#menubaochay").hide();
		$("#menu0").hide();
 	});
});
</script>
</head>

<body>
    <div id = "menubaochay" class="ctmenu">
<table>
	<tr><td class="menuitem0" id = "idactor_bc"></td></tr>
	<tr><td class="menuitem0" id = "level_bc"></td></tr>
	<tr><td class="menuitem" id = "reset">Reset</td></tr>
</table>
</div>
<div id = "menuactor" class="ctmenu">
<table>
	<tr><td class="menuitem" id = "idactor"></td></tr>
	<tr><td class="menuitem" id = "battatca">Bật tất cả các van</td></tr>
    <tr><td class="menuitem" id = "tattatca">Tắt tất cả các van</td></tr>
</table>
</div>
<div id = "menuval" class="ctmenu">
<table>
	<tr><td class="menuitem0" id = "idval"></td></tr>
	<tr><td class="menuitem0" id = "status"></td></tr>
	<tr><td class="menuitem" id = "batvan">Bật van</td></tr>
    <tr><td class="menuitem" id = "tatvan">Tắt van</td></tr>
</table>   
</div>
<div id = "menu0" class="ctmenu">
<table>
	<tr><td class="menuitem0" ></td></tr>
	<tr><td class="menuitem0" id = "id0">Chưa gia nhập mạng</td></tr>
	<tr><td class="menuitem0" ></td></tr>
</table>   
</div>
<div id = "menusensor" class="ctmenu">
<table>
	<tr><td class="menuitem0" id = "idsensor"></td></tr>
	<tr><td class="menuitem0" id = "nhietdo"></td></tr>
	<tr><td class="menuitem0" id = "doam"></td></tr>
	<tr><td class="menuitem0" id = "nangluong"></td></tr>
	<tr><td class="menuitem" id = "laydulieu">Lấy nhiệt độ, độ ẩm</td></tr>
</table>
</div>
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
	      	<li ><a href="index.php"><span>Bo nhúng</span></a></li>
	      	<li class="active"><a href="mapvl.php"><span>Bản đồ</span></a></li>
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
    <div style="padding-bottom:170px"></div>

  	<div id="contentwrap">
    
 <!-- Ban do khu vuc vuon lan -->
    <div id="mainpage">
	 <center>
		 
	      <input   type="radio" value="Vườn Lan"  name="map" id="vuonlan" checked="true">&nbsp;Vườn lan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  <input  type="radio" value="Báo cháy" name="map"  id="baochay">&nbsp;Báo cháy</br>
		  </center>
    	<div id="mymap"><img alt="Map" src="vuonlan.png" /></div>
        <div id= "icon">
<?php 
$sql3 = "SELECT * FROM node_coor WHERE 1";
$query3 = mysql_query($sql3);
while ($row3 = mysql_fetch_array($query3)){
	$mac = $row3['mac'];
	$px = $row3['px'];
	$py = $row3['py'];
	if ($row3['nodecat']=="actor"){
		?>
		<div class="icactor" id="<?php echo $mac?>" style="position: absolute;left: <?php echo $py ?>px;top: <?php echo $px ?>px; z-index:1; cursor: pointer;">
			<img  src="images/green.png" style="position: absolute;left: 0px;top: 0px; z-index: -1000"/>
			<b><?php echo $mac?></b>
		</div>	
		<?php 
	}
	else {
		$sql5 = "SELECT * FROM cdata WHERE mac = '".$mac."'";
        $query5 = mysql_query($sql5);
		$row5 = mysql_fetch_array($query5);
		?>
		<div class="icsensor" id="<?php echo $mac;?>" style="position: absolute;left: <?php echo $py ?>px;top: <?php echo $px ?>px; z-index:1; cursor: pointer;">
        <?php
		$status = $row5['status'];
		if($status == 0)
		{
        ?>
			<img src="images/violet.png" style="position: absolute;left: 0px;top: 0px; z-index: -1000"/>
			<b><?php 
		}
		else
		{ ?>
        	<img src="images/red.png" style="position: absolute;left: 0px;top: 0px; z-index: -1000"/>
        <?php
		}
		echo $mac?></b>
		</div> 
		<?php
	}
}
$sql4 = "SELECT * FROM val_coordinates WHERE 1";
$query4 = mysql_query($sql4);
while ($row4 = mysql_fetch_array($query4)){
	$id = $row4['val'];
	$px = $row4['px'];
	$py = $row4['py'];
	$sql6 = "SELECT status FROM val_status WHERE val = '".$id."'";
    $query6 = mysql_query($sql6);
	$row6 = mysql_fetch_array($query6);
	?>
	<div class="icval" id="<?php echo $id;?>" style="position: absolute; left: <?php echo $py ?>px;top: <?php echo $px ?>px; z-index:1; cursor: pointer;">
    <?php
	if($row6['status'] == 0)
	{
    ?>      
		<img src="images/grey.png" style="position: absolute;left:0px;top: 0px; z-index: -1"/>
		<?php
	}
	else
	{?>
		<img src="images/yellow.png" style="position: absolute;left:0px;top: 0px; z-index: -1"/>
	<?php }?>
	<b style="color: #000">V <?php echo $row4['val'] ?></b>
	</div>
	<?php
}
?>
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




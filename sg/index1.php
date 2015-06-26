<?php 
session_start();
require 'dbconnect.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>Gateway</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="style.css" rel="stylesheet" type="text/css" />
	<link href="gateway.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src = "jquery.js"></script>
	<script type="text/javascript" src = "gateway.js"></script>
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
		
		var IdCmd = '<?php 
		$result = mysql_query("SELECT MAX(STT) FROM bantin");
	    $row = mysql_fetch_row($result);
	    $highest_id = $row[0];
	    echo $highest_id;
	?>';
	
	setInterval(function(){
		$.get("test.php",function(data){
			if(data > IdCmd){
				showdata(data);
				IdCmd = data;
			}
		});
	},500);
	
	function showdata(id_now){
		var now_time = getTime();
		$.ajax({
			url: "autoshow.php",                           
			type: "POST",
			async: false,
		    data: "id_now="+ id_now,
			success:function(data){   
				var getData = $.parseJSON(data);
				var string = getData.bantin;
				var bc = getData.bc;  
				if(string.length > 0)
				{                  
				if(bc == 0){
					var divmessage = document.getElementById("message"); 
					var newmsg = document.createElement("i");
					newmsg.innerHTML = "<b>"+now_time+"</b>"+string;
					divmessage.appendChild(newmsg);
					divmessage.scrollTop = divmessage.scrollHeight;
				}
				else{
					
					var divmessage = document.getElementById("message1"); 
					var newmsg = document.createElement("i");
					newmsg.innerHTML ="<b>"+now_time+"</b>"+string;
					divmessage.appendChild(newmsg);
					divmessage.scrollTop = divmessage.scrollHeight;
				}	
				}
			}
		});
	}	
		
	$("#malenh").change(function() {
		     var giatri = this.value;
		     $("#chon_node").load("select_node.php?id_malenh=" + giatri);
	});

	$("#malenh1").change(function() {
		var giatri = this.value;
		$("#chon_node1").load("select_node_1.php?id_malenh=" + giatri);
	});
		
	$("#send").click(function(){
		if(isLevel==1)
		{
		var now_time = getTime();			
		
		var x= document.getElementById("malenh").selectedIndex;
		var a = document.getElementById("malenh").options;
		var state_malenh = a[x].value;                         
		var textmalenh = a[x].text;                        
		var y= document.getElementById("node").selectedIndex;
		var b = document.getElementById("node").options;//tai nut mang chi co mot lish  chon nut khong co nhieu lua chọn vay tai sao phai chon
		var addNode = b[y].value;                            
		var textNode = b[y].text;	

		                        
		if(x > 0 && y > 0){
			var message;
			var command;                        
			if($("#malenh").val() == "000"){
				message = now_time + "Lấy nhiệt độ, độ ẩm, năng lượng tại nút : "+textNode+"<br>";
				command = addNode + "000" + "$"; 
			}else{
				message = now_time + textmalenh + " tai: "+textNode+"<br>";
				command = addNode + state_malenh + "$"; 
			}
			//alert(command);
			$.ajax({
				url: "send.php",                           
				type: "POST",
				data: "command="+command,                   
			    async: false,
			    success:function(data){  
			        //alert(data);                     
			       	var divmessage = document.getElementById("message"); 
					var newmsg1 = document.createElement("b");              
					newmsg1.innerHTML = message;
					divmessage.appendChild(newmsg1);
					var newmsg2 = document.createElement("i");
					newmsg2.innerHTML = "Mã lệnh: " +data+"<br>";
					divmessage.appendChild(newmsg2);
					divmessage.scrollTop = divmessage.scrollHeight;
				}	
			});			
		}			
		else{
			alert ("Chưa chọn đủ thông tin.");	
		}
		}
		else{
			alert("Bạn chưa đăng nhập hoặc không có quyền gửi lệnh!");
			}
		$('#malenh').prop('selectedIndex',0);
		$('#node').prop('selectedIndex',0);
		$('#malenh1').prop('selectedIndex',0);
		$('#node1').prop('selectedIndex',0);
	});

	$("#send_bc").click(function(){		
	if(isLevel==1)
	{
		var now_time = getTime();	
			
		var i= document.getElementById("malenh1").selectedIndex;
		var k = document.getElementById("malenh1").options;		
		var state_malenh = k[i].value;                         
		var textmalenh = k[i].text;  
		
		var j= document.getElementById("node1").selectedIndex;
		var h = document.getElementById("node1").options;
		var addNode = h[j].value;                            
		var textNode = h[j].text;	
		                 
		if(i > 0 && j > 0){			
			var message;
			var command;                        
			if($("#malenh1").val() == "000"){
				message = now_time + "Lấy nhiệt độ, độ ẩm, năng lượng tại: "+textNode+"<br>";
				command = addNode + "000" + "$"; 
			}else{
				message = now_time + textmalenh + " tai: "+textNode+"<br>";
				command = addNode + state_malenh + "$"; 
			}
			
			$.ajax({
				url: "send.php",                           
				type: "POST",
				data: "command="+command,                   
			    async: false,
			    success:function(data){  
			                             
			       	var divmessage = document.getElementById("message1"); 
					var newmsg1 = document.createElement("b");              
					newmsg1.innerHTML = message;
					divmessage.appendChild(newmsg1);
					var newmsg2 = document.createElement("i");
					newmsg2.innerHTML = "Mã Lệnh: "+ data+"<br>";
					divmessage.appendChild(newmsg2);
					divmessage.scrollTop = divmessage.scrollHeight;
				}	
			});			
		}			
		else{
			alert ("Chưa chọn đủ thông tin.");	
		}
	    }
		else
		{
			alert("Bạn chưa đăng nhập hoặc không có quyền gửi lệnh!");
			}
		$('#malenh').prop('selectedIndex',0);
		$('#node').prop('selectedIndex',0);
		$('#malenh1').prop('selectedIndex',0);
		$('#node1').prop('selectedIndex',0);
	});
    
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
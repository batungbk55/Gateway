<?php 
require 'dbconnect.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>CSS Heaven 1</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="style.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src = "jquery.js"></script>
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
	width: 190px;
	height: 580px;
	float: left;
}
#right_con{
	width: 760px;
	background:#6E8B3D;
	height: 200px;
	float: right;
	height: 580px;
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
</style>
<script type="text/javascript">
$(document).ready(function(){
	var IdCmd = '<?php 
		$result = mysql_query("SELECT MAX(STT) FROM bantin");
	    $row = mysql_fetch_row($result);
	    $highest_id = $row[0];
	    echo $highest_id;
		mysqli_close($connect);
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
		$.ajax({
			url: "autoshow.php",                           
			type: "POST",
			async: false,
		    data: "id_now="+ id_now,
			success:function(string){                      
				if(string != null){
					var divmessage = document.getElementById("message"); 
					var newmsg = document.createElement("i");
					newmsg.innerHTML = string;
					divmessage.appendChild(newmsg);
					divmessage.scrollTop = divmessage.scrollHeight;
				}
			}	
		});
	}		
	$("#malenh").change(function() {
		var giatri = this.value;
		$("#chon_node").load("select_node.php?id_malenh=" + giatri);
	});
		
	$("#send").click(function(){
		var timer = new Date();          
		var hour = timer.getHours();     
		if( hour < 10)
		     hour = "0" + hour;          
		var minute = timer.getMinutes(); 
		if(minute < 10)
			minute = "0" + minute;       
		var second = timer.getSeconds(); 
		if(second < 10)
		    second = "0" + second;       
		var now_time = "<i>" + hour + ":" + minute + ":" + second +"___</i>";
		
		var x= document.getElementById("malenh").selectedIndex;
		var a = document.getElementById("malenh").options;
		var state_malenh = a[x].value;                         //Láº¥y giÃ¡ trá»‹ option cá»§a select chá»�n mÃ£ lá»‡nh
		var textmalenh = a[x].text;                         //láº¥y text cá»§a option chá»�n mÃ£ lá»‡nh VD: Báº­t van A
		var y= document.getElementById("node").selectedIndex;
		var b = document.getElementById("node").options;
		var addNode = b[y].value;                             //Láº¥y giÃ¡ trá»‹ option cá»§a select chá»�n node
		var textNode = b[y].text;	                          //láº¥y text cá»§a option chá»�n mÃ£ lá»‡nh VD: Node 1
		if(x > 0 && y > 0){
			var message;
			var command;                        
			if($("#malenh").val() == "000"){
				message = now_time + "Láº¥y nhiá»‡t Ä‘á»™, Ä‘á»™ áº©m, nÄƒng lÆ°á»£ng táº¡i: "+textNode+"<br>";
				command = addNode + "000" + "$"; 
			}else{
				message = now_time + textmalenh + " táº¡i: "+textNode+"<br>";
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
					newmsg2.innerHTML = data+"<br>";
					divmessage.appendChild(newmsg2);
					divmessage.scrollTop = divmessage.scrollHeight;
				}	
			});			
		}			
		else{// ChÆ°a chá»�n Ä‘á»§ mÃ£ lá»‡nh vÃ  loáº¡i Node hiá»‡n ra thÃ´ng bÃ¡o
			alert ("ChÆ°a chá»�n Ä‘á»§ thÃ´ng tin");	
		}
		$('#malenh').prop('selectedIndex',0);
		$('#node').prop('selectedIndex',0);
	});

	$('#sa').click(function(){
		var timer = new Date();           //Gá»�i cÃ¡c phÆ°Æ¡ng thá»©c cá»§a Ä‘á»‘i tÆ°á»£ng timer
		var hour = timer.getHours();      //Láº¥y giá»� hiá»‡n táº¡i (giÃ¡ trá»‹ tá»« 0 - 23)
		if( hour < 10)
		     hour = "0" + hour;           //ThÃªm 0 vÃ o trÆ°á»›c giá»� nhá»� hÆ¡n 10 VD: 09
		var minute = timer.getMinutes();  //Láº¥y phÃºt hiá»‡n táº¡i
		if(minute < 10)
			minute = "0" + minute;        //ThÃªm 0 vÃ o trÆ°á»›c phÃºt nhá»� hÆ¡n 10
		var second = timer.getSeconds();  //Láº¥y giÃ¢y hiá»‡n táº¡i
		if(second < 10)
		    second = "0" + second;        //ThÃªm 0 vÃ o giÃ¢y trÆ°á»›c giÃ¢y nhá»� hÆ¡n 10
		var now_time = "<i>" + hour + ":" + minute + ":" + second +"___</i>";	
		var message;		
		$.ajax({
			url: "send3.php",                             //Ä�á»‹a chá»‰ trang nháº­n dá»¯ liá»‡u
			type: "POST",
			data: "cmd=FFFF010$", 
			async: false,
		    success:function(data){
		    	message = now_time + "Gửi lệnh đồng bộ thời gian ngủ của các sensor <br>";
				var divmessage = document.getElementById("message"); 
				var newmsg1 = document.createElement("b");              
				newmsg1.innerHTML = message;
				divmessage.appendChild(newmsg1);
				divmessage.scrollTop = divmessage.scrollHeight;
		    } 
		});
	});    
});
</script>
</head>

<body>
<div id="wrap">
  	<div id="top">
	    <h1 id="sitename">Sigate <em>WSAN</em> LAb 411</h1>	    
  	</div>
  
	<div id="menu">
		<ul>
	    	<li><a href="index.php"><span>Home</span></a></li>
	      	<li><a href="map.php"><span>Map</span></a></li>
	      	<li class="active"><a href="gateway.php"><span>Gateway</span></a></li>
	      	<li><a href="video.php"><span>Video</span></a></li>
	      	<li><a href="manage.php"><span>Manage</span></a></li>
	   	</ul>
	</div>
  	<div id="contentwrap">
    <div id="header">
    </div>
    <div id="mainpage">
		<div id="left_con">
		<div class="log4">Connect to Gateway</div>
		<div id="title_back">
			<select id = "malenh" name ="malenh">
				<option value = "malenh">----Chá»�n mÃ£ lá»‡nh----</option>
				<option value="000">Láº¥y nhiá»‡t Ä‘á»™, Ä‘á»™ áº©m</option> 
				<option value="011">Báº­t van 1</option> 
	            <option value="021">Báº­t van 2</option> 
	            <option value="031">Báº­t van 3</option> 
				<option value="041">Báº­t van 4</option> 
				<option value="051">Báº­t van 5</option> 
				<option value="151">Báº­t táº¥t cáº£ cÃ¡c van</option> 
				<option value="010">Táº¯t van 1</option> 
				<option value="020">Táº¯t van 2</option> 
				<option value="030">Táº¯t van 3</option> 
	            <option value="040">Táº¯t van 4</option> 
	            <option value="050">Táº¯t van 5</option> 
				<option value="150">Táº¯t táº¥t cáº£ cÃ¡c van</option> 
		    </select>
		    <br><br>
		    <span id = chon_node>
				<select id = "node" name = "node">
					<option>--Chá»�n node máº¡ng--</option>
				</select>
			</span>
			<br /><br />
			<button id="send">Gá»­i lá»‡nh</button>
			<button id="sa">Sleep all</button>
	    </div>
	</div>
	<div id="right_con">
		<div class="log3">ThÃ´ng tin káº¿t ná»‘i vá»›i bo nhÃºng</div>
		<div id="message"></div>
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
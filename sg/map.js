// JavaScript Document
$(document).ready(function(){
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
        mac = $(this).attr('title');
        $.get("changestt.php", {macid: mac}).done(function(data) {
			//alert(data);           
			$.ajax({
				url:"send.php",
				type:"POST",
				data:"command="+mac+"000$",
				success: function(string ){
					if(string=="false"){
						alert("Không tìm thấy địa chỉ mạng của Sensor !");
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
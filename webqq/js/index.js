$(function(){
	iniDelegate();
	setInterval('userRespond()',1000);
	setInterval('getUnreadMsg()',1000);
	setInterval('getFriends()',1000);
});

function iniDelegate(){
	$(document).on("click",".friendli",function(){
		var istalking=$(this).attr("istalking");
		if(istalking=="yes"){
			return;
		}
		$(".friendli").attr("istalking","no");
		$(this).attr("istalking","yes");

		$("#chatdiv").show();
		$(".fli").hide();
		$(this).find(".red").hide();
		var friendname=$(this).find(".cfnn").html();
		var fid=$(this).attr("friendid");
		$(".chattitle").html("与"+friendname+"聊天中……");
		if(istalking=="no"){
			$(".chatHistory").append('<div class="fli" id="friend'+fid+'"></div>');
		}
		
		$(".sendbtn").attr("friendid",fid);
	});

	$(".closebtn").click(function(){
		$(this).parent().hide();
	});

	$(".sendbtn").click(function(){
		var msg=$(".txtMsg").val();
		if(msg==""){
			return;
		}

		var receiverid=$(this).attr("friendid");
		var senderid=$("#info").attr("curuserid");

		$.ajax({
			type:"POST",
			url:"include/ajax.php",
			data:{flag:'sendMsg',msg:msg,senderid:senderid,receiverid:receiverid},
			success:function(res){
				showMsg(receiverid);
			}
		});
	});

	$(".log").click(function(){
		logout();
	});
}

function showMsg(id){
	var userhead=$("#info").attr("curuserhead");
	var usernicheng=$("#info").attr("curusernicheng");
	var cont=$(".txtMsg").val();
	var html="";
	html+='<div class="selfmsg">';
	html+='	<img class="userheadimage" src="'+userhead+'" />';
	html+='	<p class="username">'+usernicheng+'</p>';
	html+='	<p class="word">'+cont+'</p>';
	html+='</div>';
	$("#friend"+id).append(html);
	$(".txtMsg").val("");
}

function getUnreadMsg(){
	$.ajax({
		type:"POST",
		url:"include/ajax.php",
		data:{flag:'getUnreadMsg'},
		success:function(res){
			var objs=eval("("+res+")");
			
			$.each(objs,function(){
					var istalking=$(".friendli[friendid="+this.msgSender+"]").attr("istalking");
					if(istalking=="yes"){
						var html="";
						html+='<div class="othermsg">';
						html+='	<img class="otherheadimage" src="'+this.userHeadImage+'" />';
						html+='	<p class="othername">'+this.userNickname+'</p>';
						html+='	<p class="otherword">'+this.msgContent+'</p>';
						html+='</div>';
						$("#friend"+this.msgSender).append(html);
						setReadMsg(this.msgSender);
					}else{
						$(".friendli[friendid="+this.msgSender+"]").find(".red").show();
					}
			});
		}
	});
}


function setReadMsg(sender){
	$.ajax({
		type:"POST",
		url:"include/ajax.php",
		data:{flag:'setReadMsg',sender:sender},
		success:function(res){

		}
	});
}

function getFriends(){
	$.ajax({
		type:"POST",
		url:"include/ajax.php",
		data:{flag:'getFriends'},
		success:function(res){
			var arry=res.split('|');
			$("#onlinefriendslist").html(arry[0]);
			$("#offlinefriendslist").html(arry[1]);
		}
	});
}

function logout(){
	$.ajax({
		type:"POST",
		url:"include/ajax.php",
		data:{flag:'logout'},
		success:function(res){

		}
	});
}

function userRespond(){
	$.ajax({
		type:"POST",
		url:"include/ajax.php",
		data:{flag:'userrespond'},
		success:function(res){

		}
	});
}
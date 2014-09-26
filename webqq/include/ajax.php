<?php 
	session_start();
	include_once "ez_sql_core.php";
	include_once "ez_sql_mysql.php";
	$flag=isset($_POST["flag"])?$_POST["flag"]:"";
	$msg=isset($_POST["msg"])?$_POST["msg"]:"";
	$senderid=isset($_POST["senderid"])?$_POST["senderid"]:"";
	$receiverid=isset($_POST["receiverid"])?$_POST["receiverid"]:"";
	$sender=isset($_POST["sender"])?$_POST["sender"]:"";
	$db=new ezSQL_mysql();

	$curUserID=isset($_SESSION["wodeid"])?$_SESSION["wodeid"]:"";

	if($flag=="sendMsg"){
		$sql1="select userState from userinfo where id=$receiverid";
		$res1=$db->get_row($sql1);
		if($res1=="online"){
			$sql="insert into msgInfo(id,msgContent,msgSender,msgReceiver,msgSendTime,msgState)";
			$sql .="values(null,'$msg',$senderid,$receiverid,now(),'read')";
			$res=$db->query($sql);
		}else{
			$sql="insert into msgInfo(id,msgContent,msgSender,msgReceiver,msgSendTime,msgState)";
			$sql .="values(null,'$msg',$senderid,$receiverid,now(),'unread')";
			$res=$db->query($sql);
		}
		if(!$res){
			echo "fail";
		}else{
			echo "ok";
		}
		die();
	}

	//获得未读消息
	if($flag=="getUnreadMsg"){
		if($curUserID==""){
			echo 'need login';
			die();
		}
		$sql="select * from msginfo,userinfo where msginfo.msgReceiver=$curUserID and msginfo.msgState='unread' and msginfo.msgSender=userinfo.id";
		$res=$db->get_results($sql);

		echo json_encode($res);
	}	

	//获得未读消息后标记为已读
	if($flag=="setReadMsg"){
		if($curUserID==""){
			echo 'need login';
			die();
		}
		$sql="update msginfo set msgState='read' where msgSender=$sender";
		$res=$db->query($sql);
	}

	if($flag=="getFriends"){
		$res1=$db->get_results("select userinfo.id,userinfo.userNickname,userinfo.userHeadImage,userinfo.userState from userinfo,friendsinfo where userinfo.id=friendsinfo.friendid and friendsinfo.userid=$curUserID");
		$onlineHtml="";
		$offlineHtml="";
		if($res1){
			foreach ($res1 as $friend) {
				$curHeadImageUrl=$friend->userHeadImage;
				$curFriendNickname=$friend->userNickname;
				$curFriendId=$friend->id;
				if($friend->userState=="online"){
					$onlineHtml .= "<li class='friendli' friendid='$curFriendId' istalking='no'><img src='$curHeadImageUrl' class='friendimage' /><div class='red'></div><a class='cfnn'>$curFriendNickname</a><li>";
				}else{
					$offlineHtml .= "<li class='friendli' friendid='$curFriendId' istalking='no'><img src='$curHeadImageUrl' class='friendimage offlineimage' /><div class='red'></div><a class='cfnn'>$curFriendNickname</a><li>";
				}
			}
		}
		echo $onlineHtml.'|'.$offlineHtml;
	}	

	if($flag=="logout"){
		$sql="update userinfo set userState='offline' where id=$curUserID";
		$db->query($sql);
	}

	if($flag=="userrespond"){
		$sql="update userinfo set userActive=now() where id=$curUserID";
		$db->query($sql);

		$sql1="select userActive from userinfo where id=$curUserID";
		$res1=$db->get_row($sql1);
		$one=mktime($res1);
		$two=mktime(time());  
		$cha=$two-$one;
		if($cha>60000){
			$sql2="update userinfo set userState='offline' where id=$curUserID";
			$db->query($sql2);
		}
	}
 ?>
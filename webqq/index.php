<?php 
	include_once "include/ez_sql_core.php";
	include_once "include/ez_sql_mysql.php";
	$db=new ezSQL_mysql();
	session_start();
	$userid=isset($_POST["userid"])?$_POST["userid"]:"";
	$userpwd=isset($_POST["userpwd"])?$_POST["userpwd"]:"";
	$flag=isset($_POST["flag"])?$_POST["flag"]:"";
	if($userid!=""&&$userpwd!=""){
		$res=$db->get_row("select * from userinfo where id='".$userid."'and userpwd=".$userpwd."");
		if(!$res){
			header("location:login.php?error=wrongpwd");
			die();
		}else{
			//将当前成功登录的人的信息写入session中
			$_SESSION["wodeid"]=$userid;
			$_SESSION["wodenicheng"]=$res->userNickname;
			$_SESSION["wodeheadimage"]=$res->userHeadImage;
			//echo "success to login!welcome ".$res->userNickName;
		}
	}

	$curid=isset($_SESSION["wodeid"])?$_SESSION["wodeid"]:"";
	$curnicheng=isset($_SESSION["wodenicheng"])?$_SESSION["wodenicheng"]:"";
	$curhead=isset($_SESSION["wodeheadimage"])?$_SESSION["wodeheadimage"]:"";
	if($curid==""){
		header("location:login.php?error=needlogin");
		die();
	}else{
		$sql="update userinfo set userState='online' where id=$curid";
		$db->query($sql);
		echo "welcom  ".$curnicheng;
	}
 ?>
<html>
<head>
	<title>Web Chat</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="js/index.js"></script>
</head>
<body>
	<a class="log" href="login.php?logout=yes">Logout</a>
	<div id="friendslist">
		<div class="oname">Online</div>
		<ul id="onlinefriendslist">
			
		</ul>
		<div class="oname">Offline</div>
		<ul id="offlinefriendslist">
			
		</ul>	
	</div>	

	<div id="chatdiv">
		<div class="chattitle"></div>
		<div class="closebtn">X</div>
		<div class="chatHistory">
			
		</div>
		<div class="chatMsg">
			<input class="txtMsg" maxlength="4000" type="text" />
			<div class="sendbtn">Send</div>
		</div>
	</div>

	<div id="info" curuserid="<?php echo $curid; ?>" curuserhead="<?php echo $curhead; ?>" curusernicheng="<?php echo $curnicheng; ?>"></div>
</body>
</html>
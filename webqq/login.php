<?php 
	include_once "include/ez_sql_core.php";
	include_once "include/ez_sql_mysql.php";
	$db=new ezSQL_mysql();
	session_start();
?>
<html>
<head>
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
	<div id="logincontainer">
		<h1 class="formh1">
			<strong>Welcome to WebQQ</strong>
		</h1>
		<div class="kuang">
			<div class="blocktitle">
				<div class="blockoptions"></div>
				<h2>PLEASE LOGIN</h2>
			</div>
			<form id="formlogin" action="index.php" method="POST">
				<div class="formgroup">
					<div class="col">
						<input name="userid" type="text" id="txtUserid" class="formcontrol" placeholder="Your userid..">
					</div>
				</div>
				<div class="formgroup">
					<div class="col">
						<input name="userpwd" type="password" id="txtUserPwd" class="formcontrol" placeholder="Your password..">
					</div>
				</div>
				<div class="formgroup formactions">
					<div class="col8">
						<label class="csscheckbox">
							<input type="checkbox" id="rememberme">
							<span></span>
						</label>
						Remember Me?
					</div>
					<div class="col4">
						<!-- <input name="flag" type="text" value="getFriends" style="display:none;"> -->
						<button type="submit" class="btn">Let's Go
					</div>					
				</div>				
			</form>
		</div>
		<footer class="textfoot">
			<small>
				<span id="yearcopy">2014</span> © 
				<a href="#">Smart QQ</a>
			</small>
		</footer>
	</div>
	<?php 
		$info=isset($_GET["error"])?$_GET["error"]:"";
		$logout=isset($_GET["logout"])?$_GET["logout"]:"";
		if($info=="wrongpwd"){
			$js='alert("fail to login! try it again!")';
			echo "<script>".$js."</script>";
		}
		if ($logout=="yes") {
			unset($_SESSION["wodeid"]);
			unset($_SESSION["wodenicheng"]);
		}
	 ?>
</body>
</html>
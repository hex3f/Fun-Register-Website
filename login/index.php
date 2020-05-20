<?php
header("Content-type: text/html; charset=utf-8");
$login = false;
$key = "";
session_start();

//  判断session值应该在的位置
if (isset($_SESSION["reg_login"]) && $_SESSION["reg_login"] === true) {
	header("location:../register/reg/index.php");
}else if (isset($_SESSION["login_1"]) && $_SESSION["login_1"] === true) {
	header("location:../getkey/index.php");
}else if(isset($_SESSION["getkey_reg_login"]) && $_SESSION["getkey_reg_login"] === true){
	header("location:../getkey/index.php");
}else if (isset($_SESSION["login"]) && $_SESSION["login"] === true) {
	$login = true;
	$key = $_SESSION["login_key"];
}else{
	echo "没有登录信息";
	die();
}

if($login){
	
}
?>
<!DOCTYPE html>
<html lang="zh-cn">
	<head>
		<title>HEX3F - 秘钥中心</title>
	</head>
	<body>
		<div>
			<?php echo "欢迎来到HEX3F"; ?>
			<?php echo "<a href='loginout.php'>退出登录</a>"; ?>
			<?php echo "<p>你的登录秘钥：</p><textarea rows='5' cols='80'>".$key."</textarea>"; ?>
			<p>这个网站目前就这样 23333</p>
		</div>
	</body>
</html>
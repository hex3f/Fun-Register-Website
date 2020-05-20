<?php
header("Content-type: text/html; charset=utf-8");
//$reg_login = false;
session_start();
//  判断session值应该在的位置
if (isset($_SESSION["reg_login"]) && $_SESSION["reg_login"] === true) {
	header("location:reg/index.php");
}else if (isset($_SESSION["login_1"]) && $_SESSION["login_1"] === true) {
	header("location:../getkey/index.php");
}else if (isset($_SESSION["login"]) && $_SESSION["login"] === true) {
	header("location:../login/index.php");
}else if(isset($_SESSION["getkey_reg_login"]) && $_SESSION["getkey_reg_login"] === true){
	header("location:../getkey/index.php");
}else {
	$_SESSION["reg_login"] = false;
	//echo "未通过验证"."</br>";
}

?>
<?php 
require '../api/db_conn.php';
$die_page = false;
if(is_array($_POST)&&count($_POST)>0)//判断是否有POST参数
{
	if(isset($_POST["code"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
	{
		$smscode = $_POST["code"];//存在
		$sql = "SELECT code_encryption FROM reg_check";
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0) {
			// 输出数据
			while($row = $result->fetch_assoc()) {
				//判断数据库内是否有该code
				if($row["code_encryption"] == $smscode){
					echo "<font>POST数据：".$_POST["code"]."</font>";
					echo "<font></br>数据库数据：".$row["code_encryption"]."</font>";
					echo "<font></br>数据匹配"."</font>";
					//echo "<script type='text/javascript'>web_tip('错误','该CODE无法注册！请注意大小写！','http://downsc.chinaz.net/Files/DownLoad/sound1/201908/11827.wav');</script>";
					goto start_loding;
				}else{
					$die_page = true;
				}
			}
		}
	}else{
		$die_page = true;
	}
}else{
	$die_page = true;
}

if($die_page){
	echo "<font style='color:red;'>数据不匹配，加载中断。</font>";
	//echo "<script type='text/javascript'>web_tip('错误','该CODE无法注册！请注意大小写！','http://downsc.chinaz.net/Files/DownLoad/sound1/201908/11827.wav');</script>";
	die();
}

start_loding:
?>

<!DOCTYPE html>
<html>
	<html lang="zh-cn">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<title>HEX3F - CODE验证</title>
		<script src="https://cdn.bootcss.com/modernizr/2.8.3/modernizr.min.js" type="text/javascript"></script>
		<link rel="stylesheet" href="https://cdn.bootcss.com/jqueryui/1.12.1/jquery-ui.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<!-- JQUERY -->
		<script src="https://cdn.bootcss.com/jquery/2.2.4/jquery.js"></script>
		<!-- Pop-up warning css -->
		<link rel="stylesheet" href="../css/banneralert.css" />
		<!-- tip css -->
		<link rel="stylesheet" href="../css/tip.css" />
		<!-- tip js -->
		<script src="../js/tip/justToolsTip.js"></script>
		<!-- Pop-up warning css -->
		<link rel="stylesheet" href="../css/banneralert.css" />
		
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="../css/font.css">
		<script type="text/javascript">
		function web_tip(tipTitle, tipMessage,soundData){
			/* 网站提示 start */
			$(document).ready(function(){
				$("body").showbanner({
					title : tipTitle,
					content : tipMessage,
					sound : soundData,
					handle : false,
					show_duration : 200,
					duration : 3000,
					hide_duration : 700
				});
			});
			/* 网站提示 end */
		}
		</script>
	</head>
<body>
	<div id="wrapper">
		<div id="boxy-login-wrapper">
			<form id="boxy-login-form" name="boxy-login-form" > 
				<fieldset>
						<div class="boxy-form-inner rotateFirst3d">
							<span class="end-cap left"><span class="glyphicon glyphicon-user top_tip_reg" data-toggle="tooltip" title="点击开始注册"></span></span>
							<span class="side front">
								  <span class="glyphicon glyphicon-asterisk top_tip_code" data-toggle="tooltip" title="CODE"></span>
								  <input id="boxy-input"  type="input" name="username" class="rotate" value="<?php echo $smscode; ?>" disabled="value"/>
								  <button class="boxy-button next-field" data-step="0"></button>
							</span>

                            <span class="side bottom">
                                  <span class="glyphicon glyphicon-user top_tip_phone" data-toggle="tooltip"></span>
                                  <input id="boxy-password" step="2" type="username" name="password" class="rotate" placeholder="手机号" required />
                                  <button class="boxy-button next-field sub" data-step="1"></button>
                            </span>

                            <span class="side back">
                                  <span class="boxy-checked glyphicon glyphicon-check"></span>
                                  <span class="boxy-unchecked glyphicon glyphicon-unchecked"></span>
                                      <label for="remember-me">
                                        <input id="remember-me" type="checkbox" name="remember-me" checked />同意hex3f协议?
                                      </label>
                                  <button class="boxy-button boxy-final-button" data-step="2">同意</button>
                            </span>
							
                            <div class="end-cap right">
                                <span class="glyphicon glyphicon-remove-circle icon-failure" data-toggle="tooltip" title="错误：手机号与CODE不匹配"></span>
                                <span class="glyphicon glyphicon-user icon-success" data-toggle="tooltip" title=""></span>
                            </div>
						</div>
					</fieldset>
			</form>
            <em class="small-forgot">
				<a href="#" class="boxy-forgot">疑难解答</a>
            </em>

		</div>
	</div>
	<script>
		$(".top_tip_reg").mouseover(function(){
			var _this = $(this);
			_this.justToolsTip({
				animation:"moveInTop",
				width:"120px",
				contents:"开始注册流程",
				gravity:'top'
			});
		})
		$(".top_tip_code").mouseover(function(){
			var _this = $(this);
			_this.justToolsTip({
				animation:"moveInTop",
				width:"120px",
				contents:"加密后的CODE",
				gravity:'top'
			});
		})
		$(".top_tip_phone").mouseover(function(){
			var _this = $(this);
			_this.justToolsTip({
				animation:"moveInTop",
				width:"120px",
				contents:"需要验证的手机号码",
				gravity:'top'
			});
		})
	</script>
	<!-- tip js -->
	<script src="../js/banneralert/banneralert.min.js" language="javascript"></script>
	<script src="https://cdn.bootcss.com/jqueryui/1.12.1/jquery-ui.js"></script>
	<script src='js/bootbox.min.js'></script>
	<script src='js/bootstrap.glyphs.js'></script>
	<script  src="js/index.js"></script>
	<!-- tip js -->
	<script src="../js/banneralert/banneralert.min.js" language="javascript"></script>
	</body>
</html>

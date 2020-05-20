<?php
$reg_login = false;
$key = "";
session_start();

//  判断session值应该在的位置
if (isset($_SESSION["reg_login"]) && $_SESSION["reg_login"] === true) {
	$reg_login = true;
	$key = $_SESSION["key"];
	echo "已通过验证";
	//echo $_SESSION["phone"];
}else if (isset($_SESSION["login"]) && $_SESSION["login"] === true) {
	header("location:../../login/index.php");
}else if(isset($_SESSION["getkey_reg_login"]) && $_SESSION["getkey_reg_login"] === true){
	header("location:../../getkey/index.php");
}else {
	$_SESSION["reg_login"] = false;
	$reg_login = false;
	echo "未通过验证"."</br>";
}
?>
<!DOCTYPE html>
<html lang="zh-cn" class="no-js">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<title>HEX3F - 注册向导</title>
		<meta name="description" content="Minimal Form Interface: Simplistic, single input view form" />
		<meta name="keywords" content="form, minimal, interface, single input, big form, responsive form, transition" />
		<meta name="author" content="Codrops" />
		<link rel="shortcut icon" href="../favicon.ico">
		<link rel="stylesheet" type="text/css" href="css/normalize.css" />
		<link rel="stylesheet" type="text/css" href="css/demo.css" />
		<link rel="stylesheet" type="text/css" href="css/component.css" />
		<link rel="stylesheet" type="text/css" href="../../css/font.css" />
		<script src="js/modernizr.custom.js"></script>
		<script src="https://cdn.bootcss.com/jquery/2.2.4/jquery.js"></script>
	</head>
	<body>
		<div class="container">
			<!-- Top Navigation -->
			<header class="codrops-header">
			  <h1>HEX3F 注册向导 <span>HEX3F REGISTER WIZARD</span></h1>
			</header>
			<section>
				<?php
				if($reg_login){
					echo "<form id='theForm' class='simform' autocomplete='off' action='http://www.baidu.com'>";
				}else if(!$reg_login){
					echo "<form id='theForm' class='simform' autocomplete='off' action='http://www.baidu.com'>";
				}
				?>
				
					<div class="simform-inner">
						<!-- data start -->
						<ol class='questions'>
						<?php
							if(!$reg_login){	
								echo "<li>";
								echo "<span><label for='q0'>注册密钥</label></span>";
								echo "<input id='q0' name='q0' type='text'/>";
								echo "</li>";
							}else if($reg_login){
								echo "<li>";
								echo "<span><label for='q1'>用户名</label></span>";
								echo "<input id='q1' name='q1' type='text'/>";
								echo "</li>";
								echo "<li>";
								echo "<span><label for='q2'>通讯IP(作用于好友之间的通讯)</label></span>";
								echo "<input id='q2' name='q2' type='text'/>";
								echo "</li>";
								echo "<li>";
								echo "<span><label for='q3'>电子邮箱(这个十分重要，请认真填写)</label></span>";
								echo "<input id='q3' name='q3' type='text'/>";
								echo "</li>";
							}
						?>
						</ol>
						<!-- /data end -->
						<button class="submit" type="submit">Send answers</button>
						<div class="controls">
							<button class="next"></button>
							<div class="progress"></div>
							<span class="number">
								<span class="number-current"></span>
								<span class="number-total"></span>
							</span>
							<span class="error-message"></span>
						</div><!-- / controls -->
					</div><!-- /simform-inner -->
					<span class="final-message"></span>
				<?php
				if($reg_login){
					echo "</form>";
				}else if(!$reg_login){
					echo "</form>";
				}
				?>		
			</section>
		</div><!-- /container -->		<div style='margin:0 auto;margin-top:15px;text-align:center;padding:10px;'>
		<?php
		if($reg_login){			echo "<span style='color:white;'>临时注册登录密钥 - 请马上保存该密钥，若没注册成功，使用该key进入本页面可以再次注册。若丢失，则号码直接弃用！</span>";			echo "<div><font style='color:red;font-size:30px;'>（密钥）KEY:".$key."</font></div>";
		}
		?>		</div>
		<script src="js/classie.js"></script>
		<script src="js/stepsForm.js"></script>
		<script>
			var theForm = document.getElementById( 'theForm' );
			
			<?php
			if($reg_login){
				echo "var _username = document.getElementById('q1');";
				echo "\r\n";
				echo "var _ip = document.getElementById('q2');";
				echo "\r\n";
				echo "var _email = document.getElementById('q3');";
				echo "\r\n";
			}else if(!$reg_login){
				echo "var _key = document.getElementById('q0');";
				echo "\r\n";
			}
			?>

			new stepsForm( theForm, {
				onSubmit : function( form ) {
					// hide form
					classie.addClass( theForm.querySelector( '.simform-inner' ), 'hide' );
					var messageEl = theForm.querySelector( '.final-message' );
					
					/* 异步传输 start */
					$.post("check/check.php", { <?php if($reg_login){echo "username: _username.value, ip: _ip.value, email: _email.value";}else if(!$reg_login){echo "key: _key.value";} ?> },
					   function(data){
						 //console.log(data);	//调试
						 if(data == "参数格式不正确"){
							 messageEl.innerHTML = '参数格式不正确';
							 classie.addClass( messageEl, 'show' );
						 }else if(data == "空"){
							 messageEl.innerHTML = '出现空数据';
							 classie.addClass( messageEl, 'show' );
						 }else if(data == "验证成功"){
							 messageEl.innerHTML = '参数验证完成 请勿关闭网页 即将跳转登录key获取页面';
							 classie.addClass( messageEl, 'show' );
							 setTimeout("self.location='../../getkey/index.php'",3000);
						 }else if(data == "数据库内不存在这个注册KEY"){
							 messageEl.innerHTML = '数据库内不存在这个注册KEY';
							 classie.addClass( messageEl, 'show' );
						 }else if(data == "存在相同IP"){
							 messageEl.innerHTML = '存在相同IP 发生冲突';
							 classie.addClass( messageEl, 'show' );
						 }else if(data == "key校验成功"){
							 messageEl.innerHTML = 'key校验成功，马上刷新继续注册';
							 classie.addClass( messageEl, 'show' );
							 location.reload();
						 }else{
							 messageEl.innerHTML = '发生异常';
							 classie.addClass( messageEl, 'show' );
						 }
					});
					/* 异步传输 end */
					
				}
			} );
		</script>
	</body>
</html>
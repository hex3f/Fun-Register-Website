<?php
header("Content-type: text/html; charset=utf-8");
$key = "";
session_start();

//  判断session值应该在的位置
if (isset($_SESSION["login"]) && $_SESSION["login"] === true) {
	header("location:../login/index.php");
}else if (isset($_SESSION["reg_login"]) && $_SESSION["reg_login"] === true) {
	header("location:../register/reg/index.php");
}else if (isset($_SESSION["getkey_reg_login"]) && $_SESSION["getkey_reg_login"] === true) {
	if($_SESSION["username"] == "" || $_SESSION["email"] == "" || $_SESSION["ip"] == ""){
		echo "没有数据";
		die();
	}
	$key = $_SESSION["key"];
}else if (isset($_SESSION["login_1"]) && $_SESSION["login_1"] === true) {
	if($_SESSION["username"] == "" || $_SESSION["email"] == "" || $_SESSION["ip"] == ""){
		echo "没有数据";
		die();
	}
}else {
	$_SESSION["reg_login"] = false;
	echo "未通过验证";
	die();
}

?>
<!DOCTYPE html>
<html lang="zh-cn">
	<head>
		<title>HEX3F - 登录密钥</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="initial-scale=1.0, width=device-height"><!--  mobile Safari, FireFox, Opera Mobile  -->
		<link rel="stylesheet" type="text/css" href="https://www.bootcss.com/p/buttons/css/buttons.css" />
		<script src="https://cdn.bootcss.com/jquery/2.2.4/jquery.js"></script>
		<!-- Hacker rain effect js -->
		<script src="../js/typed.js" type="text/javascript"></script>
		<!-- Hacker rain effect -->
		<script type="text/javascript">
		$(function(){
			$("#typed").typed({
				// strings: ["Typed.js is a <strong>jQuery</strong> plugin.", "It <em>types</em> out sentences.", "And then deletes them.", "Try it out!"],
				stringsElement: $('#typed-strings'),
				typeSpeed: 100,
				backDelay: 500,
				loop: false,
				contentType: 'html', // or text
				// defaults to false for infinite loop
				loopCount: false,
				resetCallback: function() { newTyped(); }
			});

			$(".reset").click(function(){
				$("#typed").typed('reset');
			});

		});
		</script>
		<script src="libs/modernizr.js"></script>
		<style type="text/css">
			* {
				margin: 0;
				padding: 0;
			}
			html, body {
				width: 100%;
				height: 100%;
				background: #22292C;
				color:white;
				font-size:20px;
				overflow: hidden;
			}
			div {
				margin-top:1em;
				margin-bottom:1em;
			}
			input {
				padding: .5em;
				margin: .5em;
			}
			select {
				padding: .5em;
				margin: .5em;
			}
			#signatureparent {
				color:darkblue;
				background-color:rgba(255,255,255,0.5);
				/*max-width:600px;*/
			}
			/*This is the div within which the signature canvas is fitted*/
			#signature {
				border: 2px dotted black;
				background-color:lightgrey;
			}
			/* Drawing the 'gripper' for touch-enabled devices */ 
			html.touch #content {
				float:left;
				width:92%;
			}
			#img_data {
				background-color:rgba(0,0,0,0.5);
				color:rgb(172,168,153);
			}
			#content {
				width: 1000px;
				position: absolute;
				text-align: center;
				top: 0%;
				left: 50%;
				transform: translateX(-50%);
			}
		</style>
	</head>
	<body>
		<canvas id="canvas" width="1280" height="1024"> 你的浏览器不支持canvas标签，请您更换浏览器 </canvas>
		<script src="../js/wordEffect.js"></script>
		<div>
			<div id="content">
				<div id="signatureparent">
					<div style="color:white;"><p id="tip_value">在画板绘图并点击 获取图形密钥 并获取登录秘钥</p></div>
					<div id="signature"></div></div>
				<div id="tools"></div>
			</div>
			<div id="scrollgrabber"></div>
		</div>
		<script>
		/*  @preserve
		jQuery pub/sub plugin by Peter Higgins (dante@dojotoolkit.org)
		Loosely based on Dojo publish/subscribe API, limited in scope. Rewritten blindly.
		Original is (c) Dojo Foundation 2004-2010. Released under either AFL or new BSD, see:
		http://dojofoundation.org/license for more information.
		*/
		(function($) {
			var topics = {};
			$.publish = function(topic, args) {
				if (topics[topic]) {
					var currentTopic = topics[topic],
					args = args || {};
			
					for (var i = 0, j = currentTopic.length; i < j; i++) {
						currentTopic[i].call($, args);
					}
				}
			};
			$.subscribe = function(topic, callback) {
				if (!topics[topic]) {
					topics[topic] = [];
				}
				topics[topic].push(callback);
				return {
					"topic": topic,
					"callback": callback
				};
			};
			$.unsubscribe = function(handle) {
				var topic = handle.topic;
				if (topics[topic]) {
					var currentTopic = topics[topic];
			
					for (var i = 0, j = currentTopic.length; i < j; i++) {
						if (currentTopic[i] === handle.callback) {
							currentTopic.splice(i, 1);
						}
					}
				}
			};
		})(jQuery);
		</script>
		<script src="libs/jSignature.min.noconflict.js"></script>
		<script>
		(function($){
		$(document).ready(function() {
			
			// This is the part where jSignature is initialized.
			var $sigdiv = $("#signature").jSignature({'UndoButton':true})
			
			// All the code below is just code driving the demo. 
			, $tools = $('#tools')
			, $extraarea = $('#displayarea')
			, pubsubprefix = 'jSignature.demo.'
			
			var export_plugins = $sigdiv.jSignature('listPlugins','export')
			, chops = ['<select>','<option value="image">第一步：点击（刷新）获取图形数据</option>']
			, name
			for(var i in export_plugins){
				if (export_plugins[i] = "image"){
				break;
					name = export_plugins[i]
					chops.push('<option value="' + name + '">' + '加密' + '</option>')
				}
			}
			chops.push('</select>')
			
			var login_key_1 = "";
			var login_key_2 = "";
			
			$(chops.join('')).bind('click', function(e){
				if (e.target.value !== ''){
					var data = $sigdiv.jSignature('getData', e.target.value)
					$.publish(pubsubprefix + 'formatchanged')
					if (typeof data === 'string'){
						$('textarea', $tools).val(data)
					} else if($.isArray(data)){
						$('textarea', $tools).val(data.join(','))
						$.publish(pubsubprefix + data[0], data);
						login_key_1 = data[0];
						login_key_2 = data[1];
					} else {
						try {
							$('textarea', $tools).val(JSON.stringify(data))
						} catch (ex) {
							$('textarea', $tools).val('Not sure how to stringify this, likely binary, format.')
						}
					}
				}
			}).appendTo($tools)
			
			$('<input type="button" class="button button-tiny" value="重置画板与数据">').bind('click', function(e){
				login_key_1 = "";
				login_key_2 = "";
				$sigdiv.jSignature('reset')
				document.getElementById("img_data").value = "";
			}).appendTo($tools)
			
			$('<div><textarea disabled="disabled" id="img_data" style="width:100%;height:15em;"></textarea></div>').appendTo($tools)
			
			
			$('<input type="button" class="button button-large button-plain button-border" value="第二步：获得加密登录秘钥">').bind('click', function(e){
				
				/* 异步传输手机号码 start */
				$.post("check/get_loginkey.php", { login_key_1: login_key_1, login_key_2: login_key_2 },
					function(data){
					 var value = document.getElementById("tip_value");
					 console.log(data);	//调试
					 if(data == "验证成功"){
						 value.innerHTML = "验证成功,请不要关闭页面，一秒后跳转到用户页面";
						 setTimeout("self.location='../login/index.php'",1000);
					 }else if(data == "验证文件删除失败"){
						 value.innerHTML = "验证文件删除失败";
					 }
					 
					});
				/* 异步传输手机号码 end */
				
			}).appendTo($tools)
			
		})
		})(jQuery)
		</script>
	</body>
</html>
